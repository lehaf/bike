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

    private array $data = [];

    private array $errors = [];
    private array $userProps = [];

    private array $imageExtentions = ['jpg', 'png', 'jpeg', 'gif'];

    private string $templateFolder = '';

    private array $requiredFields = [];

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

    private function setData(): array
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

    private function setUserProps(): array
    {
        $res = \Bitrix\Iblock\PropertyTable::getList([
            "filter" => ["=IBLOCK_ID" => $this->arParams["IBLOCK_ID"], "=ACTIVE" => "Y"],
        ])->fetchAll();

        if (!empty($res)) {
            foreach ($res as $prop) {
                $userProps[$prop["CODE"]] = $prop;
            }
        }

        return $userProps ?? [];
    }

    private function addErrors(object $data): array
    {
        foreach ($data->getErrors() as $error) {
            $this->errors[$error->getField()->getName()] = $error->getMessage();
        }

        return $this->errors;
    }

    private function createElement(array $data): array
    {
        $iblockClass = \Bitrix\Iblock\Iblock::wakeUp($this->arParams["IBLOCK_ID"])->getEntityDataClass();
        $newElement = $iblockClass::createObject();
        $newElement->setId(0);

        $newElement->set("ACTIVE", true);
        $arTransParams = array(
            "max_len" => 250,
            "change_case" => 'L',
            "replace_space" => '_',
            "replace_other" => '_',
            "delete_repeat_replace" => true
        );
        $newElement->set("CODE", \CUtil::translit($data["NAME"]["VALUE"], "ru", $arTransParams));

        foreach ($data as $prop => $item) {
            if ($item["MULTIPLE"] && is_array($item["VALUE"])) {
                foreach ($item["VALUE"] as $value) {
                    $newElement->addTo($prop, new PropertyValue($value));
                }
            } else {
                $newElement->set($prop, $item["VALUE"]);

                if ($prop === "IBLOCK_SECTION_ID") {
                    $newElement->set("IN_SECTIONS", "Y");
                }
            }
        }

        $newItemId = $newElement->save();

        if ($newItemId->isSuccess()) {
            $result = ["STATUS" => "OK", "ID" => $newItemId->getId()];
        } else {
            $this->errors = $this->addErrors($newItemId);
            Debug::dumpToFile($this->errors);
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
                "PRICE" => $this->data["POST"]["PRICE"] ?? 0,
                "CURRENCY" => ($this->data["POST"]["CURRENCY"]) ?: 'RUB',
                "PRICE_SCALE" => $this->data["POST"]["PRICE"] ?? 0
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

    private function imageCreateFromFile(string $filename, string $type): object
    {

        switch ($type) {
            case 'image/jpeg':
                return imagecreatefromjpeg($filename);
                break;
            case 'image/png':
                return imagecreatefrompng($filename);
                break;

            case 'image/gif':
                return imagecreatefromgif($filename);
                break;

            default:
                throw new \InvalidArgumentException('File "' . $filename . '" is not valid jpg, png or gif image.');
                break;
        }
    }

    private function imageFile(string $file, string $newFileName, string $type): void
    {
        switch ($type) {
            case 'image/jpeg':
                imagejpeg($file, $newFileName);
                break;
            case 'image/png':
                imagesavealpha($file, true);
                imagepng($file, $newFileName, 0);
                break;

            case 'image/gif':
                imagegif($file, $newFileName);
                break;

            default:
                throw new \InvalidArgumentException('File is not valid jpg, png or gif image.');
                break;
        }

    }

    private function decodeImg(string $img): int
    {
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/imgbs64.png', $data);
        $arFile = \CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . "/imgbs64.png");
        $fileId = \CFile::SaveFile($arFile, "iblock");
        return $fileId;
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
                    'ID' => $data["POST"][$sectionCode]
                ],
                'select' => ['VALUE'],
            ])->fetch();
        }

        return $propertyValue['VALUE'] ?? "";
    }

    private function setName(array $data): string
    {
        $section = SectionTable::getById($data['GET']['type'])->fetch();
        $name = "";

        if ((int)$section["IBLOCK_SECTION_ID"] === TRANSPORT_SECTION_ID || (int)$section["IBLOCK_SECTION_ID"] === PARTS_SECTION_ID) {
            $type = $this->getCheckProperty('type_' . $section['CODE'], $data);
            $year = $this->getCheckProperty('year', $data);

            $name = $type . ' ' . $data["POST"]["SECTION"] . ' ' . $data["POST"]["SUBSECTION"];
            if (!empty($data["POST"]["year"])) $name .= ', ' . $year;
        }

        if ((int)$section["ID"] === GARAGES_SECTION_ID) {
            $category = $this->getCheckProperty('category_garage', $data);
            $type = $this->getCheckProperty('type_garage', $data);
            $name = $category . ' ' . $type;

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

    private function ajaxPost(array $data): void
    {
        ob_end_clean();
        if (!empty($data["POST"])) {
            if (!isset($data["POST"]["NAME"])) {
                $data["POST"]["NAME"] = $this->setName($data);
            }

            $data["POST"]["IBLOCK_SECTION_ID"] = $data["POST"]["IBLOCK_SECTION_ID"] ?? $data['GET']['type'];

            $fieldsToCheck = [
                "IBLOCK_SECTION_ID" => "Заполните поле",
                "CATEGORY" => "Заполните поле",
                "SUBCATEGORY" => "Заполните поле"
            ];

            foreach ($fieldsToCheck as $field => $errorMessage) {
                if (isset($data["POST"][$field]) && empty($data["POST"][$field])) {
                    $this->errors[$field] = $errorMessage;
                }
            }
//            if (!isset($data["POST"]["IBLOCK_SECTION_ID"])) {
//                $data["POST"]["IBLOCK_SECTION_ID"] = $data['GET']['type'];
//            }
//
//            if(empty($data["POST"]["IBLOCK_SECTION_ID"])) {
//                $this->errors += ["IBLOCK_SECTION_ID" => 'Заполните поле'];
//            }
//
//            if(isset($data["POST"]["CATEGORY"]) && empty($data["POST"]["CATEGORY"])) {
//                $this->errors += ["CATEGORY" => 'Заполните поле'];
//            }
//
//            if(isset($data["POST"]["SUBCATEGORY"]) && empty($data["POST"]["SUBCATEGORY"])) {
//                $this->errors += ["SUBCATEGORY" => 'Заполните поле'];
//            }


            $data["POST"]["USER"] = \Bitrix\Main\Engine\CurrentUser::get()->getId();

            foreach ($this->userProps as $prop => $value) {
                if (empty($data['POST'][$prop]) && $value['CUSTOM_IS_REQUIRED'] === "Y") {
                    $this->errors += [$prop => "Заполните поле '" . $value['NAME'] . "'"];
                }
            }
            if (isset($data['POST']['PRICE']) && empty($data['POST']['PRICE'])) $this->errors['PRICE'] = "Заполните цену";

            foreach ($data["POST"] as $prop => &$value) {
                if (in_array($prop, $this->staticProps) || isset($this->userProps[$prop]) && !$data["FILES"][$prop]) {
                    //добавление изображений
                    if ($prop === 'PREVIEW_PICTURE' || $prop === 'DETAIL_PICTURE' || $prop === 'MORE_PHOTO') {
                        if (is_array($value) && !empty($value)) {
                            $images = [];
                            foreach ($value as $item) {
                                $images[] = $this->decodeImg($item);
                            }
                            $value = $images;
                        } else {
                            $value = $this->decodeImg($value);
                        }
                    }

                    $elementData[$prop]["VALUE"] = $value;
                    $elementData[$prop]["MULTIPLE"] = (is_array($value));
                }
            }
            unset($value);
        }

        if (!empty($data["FILES"])) {

            $arRotateImages = $data["POST"]["ROTATE_IMAGES"];
            foreach ($data["FILES"] as $code => $file) {
                $fileInfo = $data["FILES"][$code];

                foreach ($fileInfo["name"] as $key => $name) {

                    $fileExtension = pathinfo($fileInfo["name"][$key], PATHINFO_EXTENSION);
                    $arFile = \CFile::MakeFileArray($fileInfo["tmp_name"][$key]);
                    $fileId = \CFile::SaveFile($arFile, "iblock");

                    if ($arRotateImages && isset($arRotateImages[$code])) {
                        foreach ($arRotateImages[$code] as $rotateImage) {
                            if ($rotateImage["NAME"] === $name) {
                                $newImg = $this->imageCreateFromFile($_SERVER["DOCUMENT_ROOT"] . \CFile::GetPath($fileId), $arFile["type"]);
                                $newImg = imagerotate($newImg, $rotateImage["ROTATE"], 0);
                                $this->imageFile($newImg, $rotateImage["NAME"], $arFile["type"]);
                                imagedestroy($newImg);

                                \CFile::Delete($fileId);
                                $arFile = \CFile::MakeFileArray($rotateImage["NAME"]);
                                $fileId = \CFile::SaveFile($arFile, "iblock");
                            }
                        }
                    }

                    if ($key === 0 && $data["POST"][$code] && isset($data["POST"][$code]["is_images"])) {
                        $fileExtensionFirst = pathinfo($fileInfo["name"][0], PATHINFO_EXTENSION);
                        if (in_array($fileExtensionFirst, $this->imageExtentions) && isset($this->userProps[$code])
                            && str_contains($this->userProps[$code]['FILE_TYPE'], $fileExtensionFirst)) {

                            $elementData["PREVIEW_PICTURE"]["VALUE"] = $fileId;
                            $elementData["PREVIEW_PICTURE"]["MULTIPLE"] = false;
                            $elementData["DETAIL_PICTURE"]["VALUE"] = $fileId;
                            $elementData["DETAIL_PICTURE"]["MULTIPLE"] = false;

                            continue;
                        }
                    }

                    if ((in_array($code, $this->staticProps) && in_array($fileExtension, $this->imageExtentions))
                        || (isset($this->userProps[$code]) && str_contains($this->userProps[$code]['FILE_TYPE'], $fileExtension))) {
                        $elementData[$code]["VALUE"][] = $fileId;
                        $elementData[$code]["MULTIPLE"] = (isset($this->userProps[$code]) && $this->userProps[$code]['MULTIPLE'] === "Y");;
                    } else {
                        $this->errors[$code] = "Неверный формат файла или несуществующее свойство инфоблока";
                    }

                }
            }
        }

        if (empty($this->errors)) {
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
        } else {
            echo json_encode(["STATUS" => "ERROR", "ERRORS" => $this->errors]);
        }

        die();

    }

    public function onPrepareComponentParams($arParams)
    {
        $request = \Bitrix\Main\Context::getCurrent()->getRequest();

        if ($request->isAjaxRequest() && $request->getPost('sectionId')) {
            $arParams['SECTION_ID'] = (int)$request->getPost('sectionId');
        }

        $parentSection = SectionTable::getList([
            'filter' => [
                '=ID' => $arParams['SECTION_ID'],
                '>=DEPTH_LEVEL' => 2,
                '=IBLOCK_SECTION.DEPTH_LEVEL' => 2,
            ],
            'select' => [
                'ID',
                'NAME',
                'IBLOCK_SECTION_ID',
                'PARENT_SECTION_ID' => 'IBLOCK_SECTION.ID',
                'PARENT_SECTION_NAME' => 'IBLOCK_SECTION.NAME'
            ],
            'runtime' => [
                new \Bitrix\Main\Entity\ReferenceField(
                    'IBLOCK_SECTION',
                    SectionTable::class,
                    ['=this.IBLOCK_SECTION_ID' => 'ref.ID']
                )
            ],
        ])->fetch();

        if ($parentSection) {
            $arParams['PARENT_SECTION_ID'] = $parentSection['PARENT_SECTION_ID'];
        }

        return $arParams;
    }

    public function executeComponent(): void
    {
        if (!\Bitrix\Main\Engine\CurrentUser::get()->getId()) {
            $currentUrl = urlencode(Context::getCurrent()->getRequest()->getRequestUri());
            LocalRedirect($this->arParams['AUTH_LINK']);
            exit();
        }

        if (!empty($this->arParams["IBLOCK_ID"]) && (int)$this->arParams["IBLOCK_ID"]) {
            $this->setApiCode();
            $this->data = $this->setData();

            if ($this->arParams["IS_TEMPLATE_INCLUDE"] === "Y") {
                if ($this->data['GET']['type']) {
                    $sectId = (!isset($this->arParams['PARENT_SECTION_ID'])) ? $this->arParams['SECTION_ID'] : [$this->arParams['PARENT_SECTION_ID'], $this->arParams['SECTION_ID']];

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
                        'order' => ['SORT' => 'ASC']
                    ])->fetchAll();

                    if (!empty($properties)) {
                        $sectId = (!isset($this->arParams['PARENT_SECTION_ID'])) ? ["SECTION_ID" => $this->arParams['SECTION_ID']] : [
                            "PARENT_SECTION_ID" => $this->arParams['PARENT_SECTION_ID'], "SECTION_ID" => $this->arParams['SECTION_ID']
                        ];
                        $this->requiredFields = $this->getRequiredFields($sectId);

                        foreach ($properties as $field) {
                            $this->arResult["SHOW_FIELDS"][$field['CODE']] = $field;
                            $this->arResult["SHOW_FIELDS"][$field['CODE']]['CUSTOM_IS_REQUIRED'] = (in_array($field['ID'], $this->requiredFields)) ? "Y" : "N";

                            if($field['CODE'] === 'country') {
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
                                    "order" => ["SORT" => "ASC"],
                                    'cache' => [
                                        'ttl' => 36000000,
                                        'cache_joins' => true
                                    ],
                                ])->fetchAll();
                                $this->arResult["SHOW_FIELDS"][$field['CODE']]["PROPERTY_LIST"] = $linkElements;
                            }
                        }
                    }

                }

                $this->templateFolder = $this->getPath() . '/templates/' . $this->getTemplateName();
                if ($this->data['POST']['ajax'] === 'Y') {
                    $this->userProps = $this->arResult["SHOW_FIELDS"] ?? [];
                    $this->ajaxPost($this->data);
                }

                $this->includeComponentTemplate();
            }

        } else {
            echo "Введен неверный инфоблок";
        }

    }
}