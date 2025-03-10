<?php

namespace web;


use Bitrix\Catalog\PriceTable;
use Bitrix\Catalog\ProductTable;
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\ORM\PropertyValue;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Loader;
use Bitrix\Main\Context;
use Bitrix\Iblock\SectionTable;

class CreateElement extends \CBitrixComponent
{
    private array $staticProps = [
        "ID",
        "IBLOCK_ID",
        "IBLOCK_SECTION_ID",
        "SORT",
        "NAME",
        "PREVIEW_PICTURE",
        "PREVIEW_TEXT",
        "DETAIL_PICTURE",
        "DETAIL_TEXT",
        "CODE",
        "MORE_PHOTO",
        "USER"
    ];

    private array $requestData = [];

    private array $errors = [];
    private array $userProps = [];

    private string $templateFolder = '';

    private array $requiredFields = [];
    private int $elementId;
    private array $section;
    private int $userId;
    

    private function getElementId() : int
    {
        return $this->requestData['GET']['element'] ?? 0;
    }

    private function getSection() : array
    {
        if($this->requestData['GET']['type']) {
            $entity = \Bitrix\Iblock\Model\Section::compileEntityByIblock($this->arParams['IBLOCK_ID']);
            $section = $entity::getList([
                'filter' => ['=ID' => $this->requestData['GET']['type']],
                'select' => ['ID', 'CODE', 'UF_SECTION_CODE', 'IBLOCK_SECTION_ID', 'UF_MODERATION'] // Получаем только ID и CODE
            ])->fetch();
        }

        return $section ?? [];
    }

    private function getUserId() : ?int
    {
        return \Bitrix\Main\Engine\CurrentUser::get()->getId();
    }
    public function onPrepareComponentParams($arParams)
    {
        $request = \Bitrix\Main\Context::getCurrent()->getRequest();
        $this->elementId = $this->getElementId();

        if (($request->isAjaxRequest() && $request->getPost('sectionId')) || $this->elementId !== 0) {
            $arParams['SECTION_ID'] = (int)$request->getPost('sectionId');
        }

        $parentSection = SectionTable::getList([
            'filter' => [
                '=ID' => $arParams['SECTION_ID'],
                '>=DEPTH_LEVEL' => 2,
            ],
            'select' => [
                'ID',
                'NAME',
                'IBLOCK_SECTION_ID',
                'PARENT_SECTION_ID' => 'IBLOCK_SECTION.ID',
                'FIRST_LEVEL_PARENT_ID' => 'FIRST_LEVEL_SECTION.ID',
            ],
            'runtime' => [
                new \Bitrix\Main\Entity\ReferenceField(
                    'IBLOCK_SECTION',
                    SectionTable::class,
                    ['=this.IBLOCK_SECTION_ID' => 'ref.ID'],
                    ['join_type' => 'LEFT']
                ),

                new \Bitrix\Main\Entity\ReferenceField(
                    'FIRST_LEVEL_SECTION',
                    SectionTable::class,
                    ['=this.IBLOCK_SECTION.IBLOCK_SECTION_ID' => 'ref.ID'],
                    ['join_type' => 'LEFT']
                )
            ],
        ])->fetch();

        if ($parentSection) {
            $arParams['PARENT_SECTION_ID'] = $parentSection['PARENT_SECTION_ID'];
            $arParams['FIRST_LEVEL_PARENT_ID'] = $parentSection['FIRST_LEVEL_PARENT_ID'];
        }

        return $arParams;
    }
    public function executeComponent(): void
    {
        $this->userId = $this->getUserId();
        if (!$this->userId) {
            LocalRedirect($this->arParams['AUTH_LINK']);
            exit();
        }

        if (!empty($this->arParams["IBLOCK_ID"]) && (int)$this->arParams["IBLOCK_ID"]) {
            $this->setApiCode();
            $this->requestData = $this->getRequestData();
            $this->elementId = $this->getElementId();
            $this->section = $this->getSection();

            if($this->elementId) {
                $iblockClass = \Bitrix\Iblock\Iblock::wakeUp($this->arParams["IBLOCK_ID"])->getEntityDataClass();
                $element = $iblockClass::getByPrimary($this->elementId, ['select' => ['USER']])->fetchObject();

                if($this->userId !== (int)$element->getUser()->getValue()) {
                    LocalRedirect($this->arParams['PERSONAL_LINK']);
                    exit();
                }
            }

            if ($this->arParams["IS_TEMPLATE_INCLUDE"] === "Y") {
                if ($this->requestData['GET']['type']) {
                    $sectId = (!isset($this->arParams['PARENT_SECTION_ID'])) ? $this->arParams['SECTION_ID'] : [$this->arParams['PARENT_SECTION_ID'], $this->arParams['SECTION_ID']];
                    if ($this->arParams['FIRST_LEVEL_PARENT_ID']) $sectId[] = $this->arParams['FIRST_LEVEL_PARENT_ID'];

                    $rsSectionProps = \Bitrix\Iblock\SectionPropertyTable::getList([
                        "filter" => ['=IBLOCK_ID' => $this->arParams["IBLOCK_ID"] ?? 0, "=SECTION_ID" => $sectId],
                        "select" => ["PROPERTY_ID"],
                    ])->fetchAll();
                    $sectionPropsId = array_column($rsSectionProps, 'PROPERTY_ID');

                    $properties = \Bitrix\Iblock\PropertyTable::getList([
                        'filter' => [
                            'IBLOCK_ID' => $this->arParams["IBLOCK_ID"] ?? 0,
                            'ID' => $sectionPropsId
                        ],
                        'order' => ['SORT' => 'ASC', 'ID' => 'DESC']
                    ])->fetchAll();

                    if (!empty($properties)) {
                        $sectId = (!isset($this->arParams['PARENT_SECTION_ID'])) ? ["SECTION_ID" => $this->arParams['SECTION_ID']] : [
                            "FIRST_LEVEL_PARENT_ID" => $this->arParams['FIRST_LEVEL_PARENT_ID'] , "PARENT_SECTION_ID" => $this->arParams['PARENT_SECTION_ID'], "SECTION_ID" => $this->arParams['SECTION_ID']
                        ];

                        $this->requiredFields = $this->getRequiredFields($sectId);

                        foreach ($properties as $field) {
                            $this->arResult["SHOW_FIELDS"][$field['CODE']] = $field;
                            $this->arResult["SHOW_FIELDS"][$field['CODE']]['CUSTOM_IS_REQUIRED'] = (in_array($field['ID'], $this->requiredFields)) ? "Y" : "N";

                            if ($field['CODE'] === 'country') {
                                $countries = \Bitrix\Sale\Location\LocationTable::getList([
                                    'filter' => [
                                        '=TYPE_CODE' => 'COUNTRY',
                                        '=NAME.LANGUAGE_ID' => 'ru',
                                        '=TYPE.NAME.LANGUAGE_ID' => 'ru',
                                    ],
                                    'select' => [
                                        'ID',
                                        'NAME_RU' => 'NAME.NAME',
                                        'TYPE_CODE' => 'TYPE.CODE',
                                        'CODE'
                                    ],
                                    'order' => [
                                        'SORT' => 'ASC'
                                    ],
                                    'cache' => [
                                        'ttl' => 36000000,
                                        'cache_joins' => true
                                    ]
                                ])->fetchAll();
                                $this->arResult['COUNTRIES'] = $countries;
                            }

                            $this->arResult['CURRENCIES'] = \Bitrix\Currency\CurrencyTable::getList([
                                'select' => ['CURRENCY', 'BASE'],
                                'cache' => [
                                    'ttl' => 36000000,
                                    'cache_joins' => true
                                ]
                            ])->fetchAll();


                            if ($field["PROPERTY_TYPE"] === "E" || $field["PROPERTY_TYPE"] === "G") {
                                $linkElements = ElementTable::getList([
                                    "filter" => ["=IBLOCK_ID" => $field["LINK_IBLOCK_ID"]],
                                    "select" => ["NAME", "ID"]
                                ])->fetchAll();
                                $this->arResult["SHOW_FIELDS"][$field['CODE']]["LINK_ELEMENTS"] = $linkElements;
                            }

                            if ($field["PROPERTY_TYPE"] === "L") {
                                $linkElements = \Bitrix\Iblock\PropertyEnumerationTable::getList([
                                    "filter" => ["=PROPERTY_ID" => $field["ID"]],
                                    "order" => ["SORT" => "ASC", "ID" => 'DESC'],
                                    'cache' => [
                                        'ttl' => 36000000,
                                        'cache_joins' => true
                                    ],
                                ])->fetchAll();
                                $this->arResult["SHOW_FIELDS"][$field['CODE']]["PROPERTY_LIST"] = $linkElements;
                            }
                        }
                    }

                    if ($this->elementId) {
                        $this->arResult['ELEMENT_FIELDS'] = $this->getElementField($this->elementId);

                        $this->arResult['ELEMENT_PRICE'] = \Bitrix\Catalog\PriceTable::getList([
                            'filter' => ['PRODUCT_ID' => $this->elementId],
                            'select' => ['PRICE', 'CURRENCY']
                        ])->fetch();

                        $elementProps = \Bitrix\Iblock\ElementTable::getList([
                            'filter' => [
                                'ID' => $this->elementId,
                            ],
                            'select' => ['ID', 'NAME', 'PREVIEW_PICTURE', 'DETAIL_TEXT', 'IBLOCK_SECTION_ID'],
                        ])->fetch();

                        $sectionResult = \Bitrix\Iblock\SectionTable::getList([
                            'filter' => ['ID' => $elementProps['IBLOCK_SECTION_ID'], '!=DEPTH_LEVEL' => [1, 2]],
                            'select' => [
                                'NAME',
                                'IBLOCK_SECTION_ID',
                                'SECTION_NAME' => 'PARENT_SECTION.NAME',
                            ],
                            'runtime' => [
                                new \Bitrix\Main\Entity\ReferenceField(
                                    'PARENT_SECTION',
                                    \Bitrix\Iblock\SectionTable::getEntity(),
                                    ['=this.IBLOCK_SECTION_ID' => 'ref.ID'],
                                    ['join_type' => 'left']
                                ),
                            ],
                        ])->fetch();

                        if ($this->arResult['ELEMENT_FIELDS']['MORE_PHOTO']) {
                            array_unshift($this->arResult['ELEMENT_FIELDS']['MORE_PHOTO'], $elementProps['PREVIEW_PICTURE']);
                        }
                        $this->arResult['ELEMENT_PROPS'] = $elementProps;
                        $this->arResult['ELEMENT_PROPS']['IBLOCK_SECTION_NAME'] = $sectionResult['NAME'];
                        $this->arResult['ELEMENT_PROPS']['SECTION_ID'] = $sectionResult['IBLOCK_SECTION_ID'] ?? $elementProps['IBLOCK_SECTION_ID'];
                        $this->arResult['ELEMENT_PROPS']['SECTION_NAME'] = $sectionResult['SECTION_NAME'] ?? $sectionResult['NAME'];

                        if ($this->arResult['ELEMENT_FIELDS']['country']) {
                            $cityResult = \Bitrix\Sale\Location\LocationTable::getByPrimary($this->arResult['ELEMENT_FIELDS']['country'], [
                                'select' => ['ID', 'PARENT_ID']
                            ])->fetch();

                            $parentId = $cityResult['PARENT_ID'];

                            while ($parentId) {
                                $parentLocation = \Bitrix\Sale\Location\LocationTable::getByPrimary($parentId, [
                                    'select' => ['ID', 'PARENT_ID', 'TYPE_ID']
                                ])->fetch();

                                if ($parentLocation['TYPE_ID'] == 3) { // Регион
                                    $regionId = $parentLocation['ID'];
                                } elseif ($parentLocation['TYPE_ID'] == 1) { // Страна
                                    $countryId = $parentLocation['ID'];
                                }

                                $parentId = $parentLocation['PARENT_ID'];
                            }

                            $this->arResult['ELEMENT_COUNTRY'] = [
                                'COUNTRY' => $countryId ?? 0,
                                'REGION' => $regionId ?? 0,
                                'CITY' => $cityResult['ID']
                            ];
                        }
                    }
                }

                $this->templateFolder = $this->getPath() . '/templates/' . $this->getTemplateName();
                if ($this->requestData['POST']['ajax'] === 'Y') {
                    $this->userProps = $this->arResult["SHOW_FIELDS"] ?? [];
                    $this->ajaxPost($this->requestData);
                }

                $this->includeComponentTemplate();
            }

        } else {
            echo "Введен неверный инфоблок";
        }

    }
    private function ajaxPost(array $data): void
    {
        ob_end_clean();
        if (!empty($data["POST"])) {
            $this->errors = $this->checkFields($data['POST']);

            if (empty($this->errors)) {
                $data["POST"]["NAME"] = $this->setName($data["POST"]);
                $data["POST"]["USER"] = $this->userId;
                $data["POST"]["IBLOCK_SECTION_ID"] = (isset($data["POST"]["IBLOCK_SECTION_ID"])) ? $data["POST"]["IBLOCK_SECTION_ID"] : $_GET['type'];

                if(isset($data["POST"]["exp_id"]) && empty($data["POST"]["exp_id"])){
                    do {
                        $randomNumber = mt_rand(100000, 999999);
                        $entityElement = \Bitrix\Iblock\Iblock::wakeUp($this->arParams['IBLOCK_ID'])->getEntityDataClass();
                        $elementExist = $entityElement::getList([
                            'select' => ['ID', 'NAME'],
                            'filter' => [
                                'USER.VALUE' => $this->userId,
                                'exp_id.VALUE' => $randomNumber
                            ]
                        ])->fetch();

                    } while ($elementExist);
                    $data["POST"]["exp_id"] = $randomNumber;
                }

                //конвертация пробега в км
                if (isset($this->userProps['race_km']) && !empty($data['POST']['race_unit']) && !empty($data['POST']['race'])) {
                    $raceUnitXmlId = \Bitrix\Iblock\PropertyEnumerationTable::getList([
                        "filter" => ["=ID" => $data['POST']['race_unit']],
                        "select" => ["XML_ID"],
                    ])->fetch()["XML_ID"];

                    $data["POST"]["race_km"] = $this->convertRace((int)$data["POST"]["race"], $raceUnitXmlId);
                }

                foreach ($data["POST"] as $prop => &$value) {
                    if (in_array($prop, $this->staticProps) || isset($this->userProps[$prop]) && !$data["FILES"][$prop]) {
                        $elementData[$prop]["VALUE"] = $value;
                        $elementData[$prop]["MULTIPLE"] = (is_array($value));
                    }
                }
                unset($value);

                //изменение адреса видео youTube
                if(isset($elementData['POPUP_VIDEO'])) {
                    $elementData['POPUP_VIDEO']['VALUE'] = $this->convertYoutubeVideoUrl($elementData['POPUP_VIDEO']['VALUE']);
                }
                //добавление картинок
                if (!empty($data["FILES"])) {
                    foreach ($data["FILES"] as $code => $fileInfo) {
                        if (in_array($code, $this->staticProps) || $code === 'picture') {
                            // Папка для временных файлов
                            $uploadDir = $_SERVER["DOCUMENT_ROOT"] . "/upload/tmp/";
                            $isMultiple = is_array($fileInfo["name"]);
                            $filesId = [];

                            $names = $isMultiple ? $fileInfo["name"] : [$fileInfo["name"]];
                            $tmpNames = $isMultiple ? $fileInfo["tmp_name"] : [$fileInfo["tmp_name"]];

                            foreach ($names as $key => $name) {
                                $filePath = $uploadDir . basename($name);
                                if (move_uploaded_file($tmpNames[$key], $filePath)) {
                                    $arFile = \CFile::MakeFileArray($filePath);
                                    $arFile['MODULE_ID'] = 'iblock';

                                    if ($arFile) {
                                        $fileId = \CFile::SaveFile($arFile, "images");
                                        if ($fileId) {
                                            $arFile = \CFile::GetFileArray($fileId);

                                            $imageWidth = $arFile["WIDTH"];
                                            $imageHeight = $arFile["HEIGHT"];
                                            $maxWidth = 1200;
                                            $maxHeight = 1200;

                                            if ($imageWidth > $maxWidth || $imageHeight > $maxHeight) {
                                                $arResizeOptions = array(
                                                    "width" => $maxWidth,
                                                    "height" => $maxHeight,
                                                );
                                                $resizedImage = \CFile::ResizeImageGet(
                                                    $arFile,
                                                    $arResizeOptions,
                                                    BX_RESIZE_IMAGE_PROPORTIONAL, // Пропорциональный ресайз
                                                    true,
                                                    [],
                                                    false,
                                                    80
                                                );

                                                if ($resizedImage) {
                                                    // Сохраняем уменьшенную картинку
                                                    $resizedFile = \CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'] . $resizedImage['src']);
                                                    $resizedFile['MODULE_ID'] = 'iblock';

                                                    // Сохраняем уменьшенное изображение
                                                    $resizedFileId = \CFile::SaveFile($resizedFile, "images");

                                                    \CFile::Delete($fileId);
                                                    $fileId = $resizedFileId;
                                                }
                                            }

                                        }
                                        $filesId[] = $fileId;
                                    }

                                    if (!empty($filesId)) {
                                        unlink($filePath);
                                    }
                                }
                            }

                            if (!$isMultiple && !empty($filesId)) {
                                $filesId = $filesId[0];
                            }

                            if ($code === 'picture' && !$isMultiple) {
                                $elementData['PREVIEW_PICTURE']["VALUE"] = $filesId;
                                $elementData['PREVIEW_PICTURE']["MULTIPLE"] = false;

                                $elementData['DETAIL_PICTURE']["VALUE"] = $filesId;
                                $elementData['DETAIL_PICTURE']["MULTIPLE"] = false;

                                continue;
                            }

                            $elementData[$code]["VALUE"] = $filesId;
                            $elementData[$code]["MULTIPLE"] = $isMultiple;
                        }
                    }
                }

                if ($data['POST']['action'] === 'add' || $data['POST']['action'] === 'copy') {
                    $newElement = $this->createElement($elementData ?? []);
                    if (Loader::includeModule('sale') && $newElement["STATUS"] === "OK") {
                        $catalogIblock = \Bitrix\Catalog\CatalogIblockTable::getList([
                            'filter' => ['=IBLOCK_ID' => $this->arParams['IBLOCK_ID']],
                        ])->fetchObject();

                        if ($catalogIblock) {
                            $newProduct = $this->createProduct($newElement["ID"]);
                            echo json_encode($newProduct);
                            die();
                        }
                    }
                    echo json_encode($newElement);
                }

                if ($data['POST']['action'] === 'edit') {
                    $edit = $this->editElement($elementData ?? []);
                    echo json_encode($edit);
                }

            } else {
                echo json_encode(["STATUS" => "ERROR", "ERRORS" => $this->errors]);
            }
        }

        die();
    }
    private function getElementField(int $elementId): array
    {
        $properties = \Bitrix\Iblock\ElementPropertyTable::getList([
            'filter' => ['IBLOCK_ELEMENT_ID' => $elementId],
            'select' => ['IBLOCK_PROPERTY_ID', 'VALUE', 'VALUE_ENUM']
        ])->fetchAll();

        $propertyIds = array_column($properties, 'IBLOCK_PROPERTY_ID');
        $propertyInfoList = \Bitrix\Iblock\PropertyTable::getList([
            'filter' => ['ID' => $propertyIds],
            'select' => ['ID', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE']
        ])->fetchAll();

        $propertyInfoMap = [];
        foreach ($propertyInfoList as $propertyInfo) {
            $propertyInfoMap[$propertyInfo['ID']] = $propertyInfo;
        }

        $result = [];
        foreach ($properties as $property) {
            $propertyInfo = $propertyInfoMap[$property['IBLOCK_PROPERTY_ID']];
            $code = $propertyInfo['CODE'];

            if ($propertyInfo['PROPERTY_TYPE'] === 'L') {
                $value = $property['VALUE_ENUM'];
            } else {
                $value = $property['VALUE'];
            }

            if ($propertyInfo['MULTIPLE'] === 'Y') {
                $result[$code][] = $value;
            } else {
                $result[$code] = $value;
            }
        }

        return $result;
    }

    private function setApiCode(): void
    {
        $apiCode = \Bitrix\Iblock\IblockTable::getList([
            "select" => ["API_CODE", "CODE"],
            'filter' => ["=ID" => $this->arParams['IBLOCK_ID']],
            'cache' => [
                'ttl' => 36000000,
                'cache_joins' => true
            ],
        ])->fetchObject();

        if (empty($apiCode->getApiCode())) {
            $apiCode->setApiCode($apiCode->getCode() . "Api");
            $apiCode->save();
        }
    }

    private function getRequestData(): array
    {
        $request = \Bitrix\Main\Context::getCurrent()->getRequest();
        if ($this->arParams["IS_TEMPLATE_INCLUDE"] === "Y") {
            $data["POST"] = $request->getPostList()->toArray();
            $data["GET"] = $request->getQueryList()->toArray();
            $data["FILES"] = $request->getFileList()->toArray();
        } elseif ($this->arParams["IS_TEMPLATE_INCLUDE"] === "N" && isset($GLOBALS["NEW_ELEMENT"])) {
            $data["POST"] = $GLOBALS["NEW_ELEMENT"]["POST"] ?? [];
            $data["POST"] = $GLOBALS["NEW_ELEMENT"]["GET"] ?? [];
            $data["FILES"] = $GLOBALS["NEW_ELEMENT"]["FILES"] ?? [];
        }
        return $data ?? [];
    }

    private function addErrors(object $data): array
    {
        foreach ($data->getErrors() as $error) {
            $this->errors[$error->getField()->getName()] = $error->getMessage();
        }

        return $this->errors;
    }

    private function getFieldEnumId(string $propertyCode, int $iblockId, array $enumFilter) : ?int
    {
        $property = \Bitrix\Iblock\PropertyTable::getList([
            'filter' => [
                'IBLOCK_ID' => $iblockId,
                'CODE' => $propertyCode,
            ],
            'select' => ['ID'],
        ])->fetch();

        if($property['ID']) {
            $filter = array_merge(['PROPERTY_ID' => $property['ID']], $enumFilter);
            $enum = \Bitrix\Iblock\PropertyEnumerationTable::getList([
                'filter' => $filter,
                'select' => ['ID'],
            ])->fetch();
        }
        return $enum['ID'] ?? null;
    }
    private function createElement(array $data): array
    {
        $iblockClass = \Bitrix\Iblock\Iblock::wakeUp($this->arParams["IBLOCK_ID"])->getEntityDataClass();
        $newElement = $iblockClass::createObject();
        $newElement->setId(0);

        $newElement->set("ACTIVE", true);
        $newElement->set("ACTIVE_FROM", date('d.m.Y H:i:s'));
        $newElement->set("SEARCHABLE_CONTENT", strtoupper($data["NAME"]["VALUE"]));
        $newElement->set("CREATED_BY", $data["USER"]["VALUE"]);
        $newElement->set("DETAIL_TEXT_TYPE", "html");


        $userBrand = \Bitrix\Main\UserTable::getList([
            'select' => ['UF_BRAND_ID'],
            'filter' => ['=ID' => $this->userId],
        ])->fetch();


        if($userBrand['UF_BRAND_ID']) {
            $newElement->set("BRAND", $userBrand['UF_BRAND_ID']);
            $userType = 'legal';
        } else {
            $userType = 'fis';
        }

        $enumId = $this->getFieldEnumId('saller', (int)$this->arParams['IBLOCK_ID'], ['XML_ID' => $userType]);;
        $newElement->set("saller", $enumId);

        if(!empty($this->section['UF_MODERATION'])) {
            $moderationEnumId = $this->getFieldEnumId('IS_MODERATION', (int)$this->arParams['IBLOCK_ID'], ['XML_ID' => 'Y']);
            $newElement->set("IS_MODERATION", $moderationEnumId);
            $newElement->set("ACTIVE", false);
        }

        $arTransParams = array(
            "max_len" => 250,
            "change_case" => 'L',
            "replace_space" => '-',
            "replace_other" => '-',
            "delete_repeat_replace" => true
        );
        $newElement->set("CODE", \CUtil::translit($data["NAME"]["VALUE"], "ru", $arTransParams));

        foreach ($data as $prop => $item) {
            if ($item["MULTIPLE"] && is_array($item["VALUE"])) {
                foreach ($item["VALUE"] as $value) {
                    $newElement->addTo($prop, new PropertyValue($value));
                }
            } else {
                if($prop === 'DETAIL_TEXT') {
                    $item['VALUE'] = nl2br($item['VALUE'], false);
                }
                $newElement->set($prop, $item["VALUE"]);
            }
        }

        $newItemId = $newElement->save();

        if ($newItemId->isSuccess()) {
            //для оновления в общем списке
            $element = new \CIBlockElement;
            $element->Update($newItemId->getId(), [
                'IBLOCK_SECTION_ID' => $data['IBLOCK_SECTION_ID']['VALUE'],
                'XML_ID' => $newElement->getId()
            ]);
            $element->SetPropertyValuesEx($newItemId->getId(), false, ['LAST_RISE' => $newElement->getDateCreate()]);

            //для обновления меню
            global $CACHE_MANAGER;
            $CACHE_MANAGER->ClearByTag('bitrix:menu');

            $result = ["STATUS" => "OK", "ID" => $newItemId->getId()];
        } else {
            $this->errors = $this->addErrors($newItemId);
            $result = ["STATUS" => "ERROR", "ERRORS" => $this->errors];
        }

        return $result;
    }

    private function editElement(array $data): array
    {
        $iblockClass = \Bitrix\Iblock\Iblock::wakeUp($this->arParams["IBLOCK_ID"])->getEntityDataClass();
        $element = $iblockClass::getByPrimary($this->elementId, ['select' => array_keys($data)])->fetchObject();
        $elementPhotos = $iblockClass::getByPrimary($this->elementId, ['select' => ['MORE_PHOTO', 'PREVIEW_PICTURE']])->fetchObject();
        $delPhotos = [];
        if (!empty($elementPhotos)) {
            foreach ($elementPhotos->getMorePhoto()->getAll() as $photo) {
                $delPhotos[] = $photo->getValue();
            }
            $delPhotos[] = $elementPhotos->getPreviewPicture();

            if (!empty($delPhotos)) {
                foreach ($delPhotos as $photo) {
                    \CFile::Delete($photo);
                }
            }
        }

        $arTransParams = array(
            "max_len" => 250,
            "change_case" => 'L',
            "replace_space" => '-',
            "replace_other" => '-',
            "delete_repeat_replace" => true
        );
        $element->set("CODE", \CUtil::translit($data["NAME"]["VALUE"], "ru", $arTransParams));

        $currentDate = new \DateTime();
        $element->set("TIMESTAMP_X", $currentDate->format('d.m.Y H:i:s'));
        $element->set("DETAIL_TEXT_TYPE", 'html');


        if(!empty($this->section['UF_MODERATION'])) {
            $moderationEnumId = $this->getFieldEnumId('IS_MODERATION', (int)$this->arParams['IBLOCK_ID'], ['XML_ID' => 'Y']);
            $element->set("IS_MODERATION", $moderationEnumId);
            $element->set("ACTIVE", false);
        }

        if (!empty($data)) {
            foreach ($this->staticProps as $prop) {
                if ($data[$prop]) {
                    if ($data[$prop]['MULTIPLE']) {
                        $propertyValues = $element->get($prop);
                        // Удаляем все существующие значения
                        foreach ($propertyValues as $value) {
                            $propertyValues->remove($value);
                        }
                        // Добавляем новые значения
                        foreach ($data[$prop]['VALUE'] as $value) {
                            $element->addTo($prop, new PropertyValue($value));
                        }
                    } else {
                        if($prop === 'DETAIL_TEXT') {
                            $data[$prop]['VALUE'] = nl2br($data[$prop]['VALUE'], false);
                        }

                        $element->set($prop, $data[$prop]['VALUE']);
                    }
                }
            }
            foreach ($this->userProps as $prop => $propData) {
                if (array_key_exists($prop, $data)) {
                    $item = $data[$prop];
                    if ($propData['MULTIPLE'] === 'Y' && is_array($item['VALUE'])) {
                        $propertyValues = $element->get($prop);
                        // Удаляем все существующие значения
                        foreach ($propertyValues as $value) {
                            $propertyValues->remove($value);
                        }
                        // Добавляем новые значения
                        foreach ($item['VALUE'] as $value) {
                            $element->addTo($prop, new PropertyValue($value));
                        }
                    } else {
                        // Устанавливаем значение для одиночных свойств
                        $element->set($prop, $item['VALUE']);
                    }
                } else {
                    if ($propData['PROPERTY_TYPE'] === 'L') {
                        if ($propData['MULTIPLE'] === 'Y') {
                            $element->fill($prop);
                            $propertyValues = $element->get($prop);
                            foreach ($propertyValues as $value) {
                                $propertyValues->remove($value);
                            }
                        } else {
                            $element->set($prop, null);
                        }
                    }
                }
            }
        }

        $existingPrice = \Bitrix\Catalog\PriceTable::getList([
            'filter' => [
                'PRODUCT_ID' => $this->elementId,
                'CATALOG_GROUP_ID' => 1,
            ],
        ])->fetch();

        if ($existingPrice) {
            PriceTable::update($existingPrice['ID'], [
                "PRICE" => $this->requestData["POST"]["PRICE"] ?? 0,
                "CURRENCY" => ($this->requestData["POST"]["CURRENCY"]) ?: 'RUB',
                "PRICE_SCALE" => $this->requestData["POST"]["PRICE"] ?? 0
            ]);
        }

        $newItemId = $element->save();

        if ($newItemId->isSuccess()) {
            //сброс зависимостей для отображения корректных данных
            $ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues($this->arParams['IBLOCK_ID'], $this->elementId);
            $ipropValues->clearValues();

            $result = ["STATUS" => "OK", 'FORM' => $this->successFormTemplate(), 'action' => 'edit'];
        } else {
            $this->errors = $this->addErrors($newItemId);
            $result = ["STATUS" => "ERROR", "ERRORS" => $this->errors];
        }

        return $result;
    }

    private function createProduct(int $elementId): array
    {
        $product = ProductTable::add(["ID" => $elementId]);

        if ($product->isSuccess()) {
            $price = PriceTable::add([
                "PRODUCT_ID" => $product->getId(),
                "CATALOG_GROUP_ID" => 1,
                "PRICE" => $this->requestData["POST"]["PRICE"] ?? 0,
                "CURRENCY" => ($this->requestData["POST"]["CURRENCY"]) ?: 'RUB',
                "PRICE_SCALE" => $this->requestData["POST"]["PRICE"] ?? 0
            ]);

            if ($price->isSuccess()) {
                $result = ['STATUS' => 'OK', 'FORM' => $this->successFormTemplate()];
            } else {
                $result = ["STATUS" => "ERROR", "ERRORS" => $this->addErrors($price)];
            }
        } else {
            $result = ["STATUS" => "ERROR", "ERRORS" => $this->addErrors($product)];
        }

        return $result;
    }

    private function successFormTemplate(): string
    {
        $filePath = $_SERVER['DOCUMENT_ROOT'] . $this->templateFolder . '/success.php';
        $arParams = $this->arParams;
        ob_start();
        if (file_exists($filePath)) include $filePath;
        $form = ob_get_clean();
        return $form;
    }

    private function getCheckProperty(string $sectionCode, array $data): string
    {
        $propertyId = \Bitrix\Iblock\PropertyTable::getList([
            'filter' => [
                'CODE' => $sectionCode
            ],
            'select' => ['ID']
        ])->fetch();
        if ($propertyId) {
            $propertyValue = \Bitrix\Iblock\PropertyEnumerationTable::getList([
                'filter' => [
                    'PROPERTY_ID' => $propertyId['ID'],
                    'ID' => $data[$sectionCode]
                ],
                'select' => ['VALUE'],
            ])->fetch();
        }

        return $propertyValue['VALUE'] ?? "";
    }

    private function setName(array $data): string
    {
        $sectCode = (!empty($this->section['UF_SECTION_CODE'])) ? $this->section['UF_SECTION_CODE'] : $this->section['CODE'];
        $name = $data["NAME"] ?? "";

        if(empty($name)) {
            if ((int)$this->section["IBLOCK_SECTION_ID"] === TRANSPORT_SECTION_ID) {
                $type = $this->getCheckProperty('type_' . $sectCode, $data);
                $year = $this->getCheckProperty('year', $data);

                $name = $type . ' ' . $data["SECTION"] . ' ' . $data["SUBSECTION"];
                if(!empty($data["MODEL_OTHER"])) $name .= ' ' . $data["MODEL_OTHER"];
                if (!empty($data["year"])) $name .= ', ' . $year . ' г.';
            } elseif ((int)$this->section["IBLOCK_SECTION_ID"] === PARTS_SECTION_ID) {
                $type = $this->getCheckProperty('type_' . $sectCode, $data);
                $year = $this->getCheckProperty('year', $data);

                $name = $type . ' к ' . $data["SECTION"] . ' ' . $data["SUBSECTION"];
                if(!empty($data["MODEL_OTHER"])) $name .= ' ' . $data["MODEL_OTHER"];
                if (!empty($data["year"])) $name .= ', ' . $year . ' г.';
            } elseif ((int)$this->section["ID"] === GARAGES_SECTION_ID) {
                $category = $this->getCheckProperty('category_garage', $data);
                $type = $this->getCheckProperty('type_garage', $data);
                $name = $category . ' ' . $type;
            } elseif((int)$this->section["ID"] === SERVICES_SECTION_ID) {
                $name = trim($data['contact_person']) ?? '';
                $serviceSection = SectionTable::getById($data['IBLOCK_SECTION_ID'])->fetch();

                if($serviceSection) {
                    $name .= " | " . $serviceSection['NAME'];
                }
            }
        }

        return $name;
    }

    private function getRequiredFields(array $sectId): array
    {
        $entity_data_class = '';
        $requiredFieldsId = [];

        $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList([
            "filter" => ['TABLE_NAME' => "b_required_fields"],
        ])->fetch();

        if (isset($hlblock['ID'])) {
            $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
            $entity_data_class = $entity->getDataClass();
        }

        if (!empty($entity_data_class)) {
            $requiredFields = $entity_data_class::getList([
                'filter' => ['=UF_SECTION' => $sectId],
                'select' => ['UF_FIELDS'],
            ])->fetchAll();

            foreach ($requiredFields as $item) {
                foreach ($item["UF_FIELDS"] as $value) {
                    $requiredFieldsId[] = $value;
                }
            }
        }

        return $requiredFieldsId;
    }


    private function convertRace(int $race, string $unit): float
    {
        $motoHours = 1.2;
        $mile = 0.621371;
        if ($unit === "moto-hours") {
            $race = round($race / $motoHours, 2);
        } elseif ($unit === "mile") {
            $race = round($race / $mile, 2);
        }

        return $race;
    }

    private function convertYoutubeVideoUrl (string $url): string {
        $convertUrl = '';
        if (!empty($url)) {
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
                $videoId = $match[1];
                if (empty($videoId)) {
                    $videoId = $url;
                }
            } else {
                $videoId = $url;
            }
            $convertUrl = 'https://www.youtube.com/embed/' . $videoId;
        }
        return $convertUrl;
    }
    private function checkFields(array $data) : array {
        $entityIblock= \Bitrix\Iblock\Iblock::wakeUp($this->arParams['IBLOCK_ID'])->getEntityDataClass();

        if(!$data["IBLOCK_SECTION_ID"]) {
            if(isset($data["POST"]["SUBSECTION"])) {
                $errors["SUBSECTION"] = "Данной модели не существует";
            }
        }

        if(in_array($this->requestData['GET']['type'], [SERVICES_SECTION_ID])) {
            $rsElements =  $entityIblock::getList([
                'select' => ['ID'],
                'filter' => ['=IBLOCK_SECTION_ID' => $data['IBLOCK_SECTION_ID'], '=USER.VALUE' => $this->userId]
            ])->fetchAll();

            if(!empty($rsElements)) {
                $ids = array_column($rsElements, 'ID');
                if(!in_array($this->elementId, $ids) || (in_array($this->elementId, $ids) && $this->requestData['GET']['action'] === "copy")) {
                    $errors['IBLOCK_SECTION_ID'] = 'В данной категории уже есть объявление';
                }
            }
        }

        $fieldsToCheck = [
            "IBLOCK_SECTION_ID" => "Необходимо заполнить «Категория»",
            "CATEGORY" => "Необходимо заполнить «Категория»",
            "SUBCATEGORY" => "Необходимо заполнить «Подкатегория товара/услуги»",
            'exp_id' => "Объявление с таким артиклом уже существует"
        ];


        foreach ($fieldsToCheck as $field => $errorMessage) {
            if($field === 'exp_id') {
                if(!empty($data[$field])) {
                    $element = $entityIblock::getList([
                        'select' => ['ID', 'NAME'],
                        'filter' => [
                            '=USER.VALUE' => $this->userId,
                            '=exp_id.VALUE' => $data[$field],
                            '!=ID' => ($this->requestData["GET"]["action"] === "edit") ? $this->elementId : 0
                        ]
                    ])->fetch();

                    if($element) {
                        $errors[$field] = $errorMessage;
                    }
                }
                continue;
            }

            if (isset($data[$field]) && empty($data[$field])) {
                $errors[$field] = $errorMessage;
            }
        }


        foreach ($this->userProps as $prop => $value) {
            if (empty($data[$prop]) && $value['CUSTOM_IS_REQUIRED'] === "Y") {
                $errors[$prop] = "Необходимо заполнить «" . $value['NAME'] . "»";
            }
        }
        if (isset($data['PRICE']) && empty($data['PRICE'])) $errors['PRICE'] = "Необходимо заполнить «Цена»";
        return $errors ?? [];
    }
}