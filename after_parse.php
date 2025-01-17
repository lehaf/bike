<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
ini_set('max_execution_time', 123456);

use PhpOffice\PhpSpreadsheet\IOFactory;

$file = IOFactory::load("motoMini.csv");

$fileData = $file->getActiveSheet()->toArray();
unset($fileData[0]);

$class = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();

if (!empty($fileData)) {
    $data = [];

//    CEventLog::Add(array(
//        "SEVERITY" => "SECURITY",
//        "AUDIT_TYPE_ID" => "Начало импорта объявлений с av.by",
//        "MODULE_ID" => "iblock",
//        "ITEM_ID" => CATALOG_IBLOCK_ID,
//        "DESCRIPTION" => "Начался импорт объявлений с av.by",
//    ));

    foreach ($fileData as $row) {
        $type = $row[1];
        $mark = $row[5];
        $model = $row[6];

        if (!isset($data[$type])) {
            $data[$type] = [];
        }

        if (!isset($data[$type][$mark])) {
            $data[$type][$mark] = [];
        }

        if (!isset($data[$type][$mark][$model])) {
            $data[$type][$mark][$model] = [$row];
        } else {
            $data[$type][$mark][$model][] = $row;
        }
    }

    $types = array_keys($data);
    $propsNames = [
        "IS_AV",
        "number_av",
        "url_av",
        "year",
        "power",
        "race",
        "race_unit",
        "country",
        "contact_person",
        "phone"
    ];

    if (!empty($types)) {
        foreach ($types as $type) {
            $propsNames[] = "complect_" . $type;
            $propsNames[] = "type_" . $type;
            $propsNames[] = "motor_type_" . $type;
            $propsNames[] = "cylinders_count_" . $type;
            $propsNames[] = "count_door_" . $type;
        }
    }

    $propsListInfo = getPropsInfo($propsNames);
//    pr(getPropsInfo($propsNames));

    if (!empty($data)) {
        $siteElementsNumbers = [];
        $allElements = $class::getList([
            "filter" => ["!=IS_AV.VALUE" => false],
            "select" => ["number_av", "ID"]
        ])->fetchCollection();

        if (!$allElements->isEmpty()) {
            foreach ($allElements as $elem) {
                $siteElementsNumbers[$elem->getId()] = ($elem->getNumberAv()) ? $elem->getNumberAv()->getValue() : '';
            }
        }

        foreach ($data as $key => &$value) {

            $sectionId = \Bitrix\Iblock\SectionTable::getList([
                "select" => ["ID"],
                "filter" => ["=CODE" => $key],
            ])->fetchObject()->getId();


            $subSections = array_keys($value);
            $rsSection = \Bitrix\Iblock\SectionTable::getList([
                "filter" => [
                    "=IBLOCK_ID" => CATALOG_IBLOCK_ID,
                    "=IBLOCK_SECTION_ID" => $sectionId,
                    "=NAME" => $subSections,
                ],
                "select" => ["ID", "NAME"],
            ])->fetchCollection();

            if (!empty($rsSection)) {
                foreach ($rsSection as $sect) {
                    $subSections1 = array_keys($value[$sect->getName()]);
                    $rsSubSection = \Bitrix\Iblock\SectionTable::getList([
                        "filter" => [
                            "=IBLOCK_ID" => CATALOG_IBLOCK_ID,
                            "=IBLOCK_SECTION_ID" => $sect->getId(),
                            "=NAME" => $subSections1,
                        ],
                        "select" => ["ID", "NAME"],
                    ])->fetchCollection();

                    foreach ($rsSubSection as $subSect) {
                        foreach ($value[$sect->getName()][$subSect->getName()] as &$val) {
                            $val["SECTION_ID"] = $subSect->getId();

                            if (!in_array($val[2], $siteElementsNumbers)) {
//                                $addElements[] = setElementsPropsFromParser($val, $propsListInfo);
                                $element = setElementsPropsFromParser($val, $propsListInfo);
                                pr(['add' => $element]);
                                $newElement = createElement($element['fields'] ?? []);
                                pr(['newElem' => $newElement]);

                                if (\Bitrix\Main\Loader::includeModule('sale') && $newElement["STATUS"] === "OK") {
                                    $catalogIblock = \Bitrix\Catalog\CatalogIblockTable::getList([
                                        'filter' => ['=IBLOCK_ID' => CATALOG_IBLOCK_ID],
                                    ])->fetchObject();

                                    if ($catalogIblock) {
                                        $newProduct = createProduct($newElement["ID"], $element['product']);
                                    }
                                }
                            } else {
                                $updateElements[] = setElementsPropsFromParser($val, $propsListInfo);
                                $elementId = array_search($val[2], $siteElementsNumbers, true);
                                $element = setElementsPropsFromParser($val, $propsListInfo);
                                pr(['edit_' . $elementId => $element]);
                                $newElement = editElement($element['fields'] ?? [], $elementId, $element['product']);
                            }

                            $fileElementsNumbers[] = $val[2];
                        }
                    }
                }

            }
        }

        foreach ($siteElementsNumbers as $elemId => $elemNum) {
            if (!in_array($elemNum, $fileElementsNumbers)) {
                $deleteElements[] = $elemId;
                deleteElements($elemId);
            }
        }


//        if (!empty($addElements)) {
//
//            $userProps = getUserProps();
//
//            foreach ($addElements as $elem) {
//
//                if (!empty($elem[18])) {
//                    $images = explode("||", $elem[18]);
//                    foreach ($images as $img) {
//                        $arFile = \CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . "/photo/" . $img);
////                        vr($arFile);
////                        $fileId = \CFile::SaveFile($arFile, "iblock");
//                    }
//                }
//
////                vr($elemProps);
//            }
//        }

//        vr(["site" => $siteElementsNumbers]);
//        vr(["file" => $fileElementsNumbers]);
//        vr($addElements);
//        vr($delElements);
//        vr($addElements);
    }
}

function getUserProps(): array
{
    $res = \Bitrix\Iblock\PropertyTable::getList([
        "filter" => ["=IBLOCK_ID" => CATALOG_IBLOCK_ID, "=ACTIVE" => "Y"],
        "select" => ["CODE", "MULTIPLE", "PROPERTY_TYPE"]
    ])->fetchAll();

    if (!empty($res)) {
        foreach ($res as $prop) {
            $userProps[$prop["CODE"]] = $prop;
        }
    }

    return $userProps ?? [];
}

function getPropsInfo(array $props): array
{
    if (!empty($props)) {
        foreach ($props as $propCode) {
            $property = \Bitrix\Iblock\PropertyTable::getList([
                'filter' => [
                    'IBLOCK_ID' => CATALOG_IBLOCK_ID,
                    'CODE' => $propCode,
                ],
                'select' => ['ID', 'PROPERTY_TYPE'],
            ])->fetch();

            if ($property['ID'] && $property['PROPERTY_TYPE'] === 'L') {
                $propEnums = [];
                $enum = \Bitrix\Iblock\PropertyEnumerationTable::getList([
                    'filter' => [
                        'PROPERTY_ID' => $property['ID'],
                    ],
                    'select' => ['ID', 'VALUE'],
                ])->fetchAll();
                foreach ($enum as $value) {
                    $propEnums[trim(mb_strtolower($value['VALUE']))] = $value['ID'];
                }
                $propsInfo[$propCode] = $propEnums;
            }

        }
    }
    return $propsInfo ?? [];
}

//setElementsPropsFromParser($data['bike']["ABM"]["Raptor"][0], $propsListInfo);
function setElementsPropsFromParser($elem, array $propsInfo): array
{
    $images = explode("||", $elem[21]);
    $previewImg = $images[0];
    unset($images[0]);

    $raceUnit = (trim($elem[14]) === 'моточасов') ? 'мото ч.' : trim($elem[14]);

    $fields = [
        "IS_AV" => 'Да',
        "NAME" => "$elem[12] $elem[5] $elem[6], $elem[7] г.",
        "PREVIEW_PICTURE" => $previewImg,
        "DETAIL_PICTURE" => $previewImg,
        "DETAIL_TEXT" => $elem[18],
        "DETAIL_TEXT_TYPE" => "html",
        "IBLOCK_SECTION_ID" => $elem["SECTION_ID"],
//        "MORE_PHOTO" => $images,

        "complect_" . $elem[1] => explode("||", $elem[15]), // комплектация (надо создать)
        "phone" => explode("||", $elem[19]), // телефон
        "type_" . $elem[1] => trim($elem[12]), // тип (надо создать)
        "motor_type_" . $elem[1] => trim($elem[9]), // такт
        "cylinders_count_" . $elem[1] => trim($elem[10]), // количество цилиндров
        "count_door_" . $elem[1] => trim($elem[11]), //цепь

        "number_av" => trim($elem[2]), // номер объявления с av.by
        "url_av" => $elem[0], // url на объявления в av.by
        "year" => trim($elem[7]), // год
        "power" => trim($elem[8]), // объем двигателя
        "race" => trim($elem[13]), // пробег
        "race_unit" => $raceUnit, // единицы
        "race_km" => convertRace(trim($elem[13]), $raceUnit),
        "country" => trim($elem[16]), // город
        "contact_person" => trim($elem[20]), // имя
    ];

    $productInfo = [
        "PRICE" => trim($elem[3]),
        "CURRENCY" => 'BYN',
    ];
    $fields = convertElementFields($fields, $propsInfo);
    return ['fields' => $fields, 'product' => $productInfo];
}

function convertElementFields(array $props, array $propsInfo): array
{
    $listProps = array_keys($propsInfo);

    foreach ($props as $propCode => &$propValue) {
        if (in_array($propCode, $listProps)) {
            if (is_array($propValue)) {
                $values = [];
                foreach ($propValue as $value) {
                    $values[] = $propsInfo[$propCode][trim(mb_strtolower($value))] ?? '';
                }
                $props[$propCode] = $values;
            } else {
                $props[$propCode] = $propsInfo[$propCode][trim(mb_strtolower($propValue))] ?? '';
            }
        }

        if ($propCode === 'country') {
            \Bitrix\Main\Loader::includeModule('sale');
            $result = \Bitrix\Sale\Location\LocationTable::getList([
                'filter' => [
                    '=NAME.LANGUAGE_ID' => 'ru', // Язык
                    '=NAME.NAME' => $propValue,  // Название города
                    '=TYPE.CODE' => 'CITY',    // Тип местоположения (город)
                ],
                'select' => ['ID', 'NAME.NAME', 'TYPE.CODE'], // Что извлекаем
            ])->fetch();
            $props[$propCode] = ($result['ID']) ?: '';
        }
    }
    return $props;
}

function deleteElements(int $elementId): void
{
    $delPhotos = [];
    $iblockClass = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();
    $element = $iblockClass::getList([
        'filter' => ['ID' => $elementId],
        'select' => ['MORE_PHOTO', 'PREVIEW_PICTURE']
    ])->fetchObject();

    foreach ($element->getMorePhoto()->getAll() as $photo) {
        $delPhotos[] = $photo->getValue();
    }
    $delPhotos[] = $element->getPreviewPicture();

    if (!empty($delPhotos)) {
        foreach ($delPhotos as $photo) {
            \CFile::Delete($photo);
        }
    }

    $element = new CIBlockElement;
    $element->Delete($elementId);
}


function createElement(array $data): array
{
    $iblockClass = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();
    $newElement = $iblockClass::createObject();
    $newElement->setId(0);

    $newElement->set("ACTIVE", true);
    $newElement->set("ACTIVE_FROM", date('d.m.Y H:i:s'));
    $newElement->set("SEARCHABLE_CONTENT", strtoupper($data["NAME"]));

    $arTransParams = array(
        "max_len" => 250,
        "change_case" => 'L',
        "replace_space" => '_',
        "replace_other" => '_',
        "delete_repeat_replace" => true
    );
    $newElement->set("CODE", \CUtil::translit($data["NAME"], "ru", $arTransParams));

    foreach ($data as $prop => &$item) {
        if($prop === 'PREVIEW_PICTURE' || $prop === 'DETAIL_PICTURE') {
            $arFile = \CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . "/photos/img/" . $item);
            $fileId = \CFile::SaveFile($arFile, "iblock");
            $data[$prop] = $fileId;
        }

//        if($prop === 'MORE_PHOTO') {
//            $fileId = [];
//            foreach ($item as $photo) {
//                $arFile = \CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . "/photos/img/" . $photo);
//                $fileId[] = \CFile::SaveFile($arFile, "iblock");
//            }
//
//            $data[$prop] = $fileId;
//        }

        if (is_array($item)) {
            foreach ($item as $value) {
                $newElement->addTo($prop, new \Bitrix\Iblock\ORM\PropertyValue($value));
            }
        } else {
            $newElement->set($prop, $item);
        }
    }

    $newItemId = $newElement->save();

    if ($newItemId->isSuccess()) {
        //для оновления в общем списке
        $element = new \CIBlockElement;
        $element->Update($newItemId->getId(), [
            'IBLOCK_SECTION_ID' => $data['IBLOCK_SECTION_ID'],
            'XML_ID' => $newElement->getId()
        ]);
        $element->SetPropertyValuesEx($newItemId->getId(), false, ['LAST_RISE' => $newElement->getDateCreate()]);

        $result = ["STATUS" => "OK", "ID" => $newItemId->getId()];
    } else {
        foreach ($newItemId->getErrors() as $error) {
            $result[$error->getField()->getName()] = $error->getMessage();
        }
    }

    return $result ?? [];
}

function convertRace(int $race, string $unit): float
{
    $motoHours = 1.2;
    $mile = 0.621371;
    if ($unit === "мото ч.") {
        $race = round($race / $motoHours, 2);
    } elseif ($unit === "миль") {
        $race = round($race / $mile, 2);
    }

    return $race;
}

function editElement(array $data, int $elementId, array $productInfo): array
{
    $iblockClass = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();
    $element = $iblockClass::getByPrimary($elementId, ['select' => array_keys($data)])->fetchObject();
    $elementPhotos = $iblockClass::getByPrimary($elementId, ['select' => ['MORE_PHOTO', 'PREVIEW_PICTURE']])->fetchObject();

    $delPhotos = [];
    if (!empty($elementPhotos)) {
        foreach ($elementPhotos->getMorePhoto()->getAll() as $photo) {
            $delPhotos[] = $photo->getValue();
        }
        $delPhotos[] = $elementPhotos->getPreviewPicture();
        $delPhotos[] = $elementPhotos->getDetailPicture();

        if (!empty($delPhotos)) {
            foreach ($delPhotos as $photo) {
                \CFile::Delete($photo);
            }
        }
    }

    $arTransParams = array(
        "max_len" => 250,
        "change_case" => 'L',
        "replace_space" => '_',
        "replace_other" => '_',
        "delete_repeat_replace" => true
    );
    $element->set("CODE", \CUtil::translit($data["NAME"], "ru", $arTransParams));

    $currentDate = new \DateTime();
    $element->set("TIMESTAMP_X", $currentDate->format('d.m.Y H:i:s'));

    if (!empty($data)) {
        foreach ($data as $prop => &$item) {
            if($prop === 'PREVIEW_PICTURE' || $prop === 'DETAIL_PICTURE') {
                $arFile = \CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . "/photos/img/" . $item);
                $fileId = \CFile::SaveFile($arFile, "iblock");
                $data[$prop] = $fileId;
            }

//        if($prop === 'MORE_PHOTO') {
//            $fileId = [];
//            foreach ($item as $photo) {
//                $arFile = \CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . "/photos/img/" . $photo);
//                $fileId[] = \CFile::SaveFile($arFile, "iblock");
//            }
//
//            $data[$prop] = $fileId;
//        }

            if (is_array($item)) {
                foreach ($item as $value) {
                    $propertyValues = $element->get($prop);
                    // Удаляем все существующие значения
                    foreach ($propertyValues as $val) {
                        $propertyValues->remove($val);
                    }

                   $element->addTo($prop, new \Bitrix\Iblock\ORM\PropertyValue($value));

                }
            } else {
                $element->set($prop, $item);
            }
        }
    }

    $existingPrice = \Bitrix\Catalog\PriceTable::getList([
        'filter' => [
            'PRODUCT_ID' => $elementId,
            'CATALOG_GROUP_ID' => 1,
        ],
    ])->fetch();

    if ($existingPrice) {
        \Bitrix\Catalog\PriceTable::update($existingPrice['ID'], [
            "PRICE" => $productInfo["PRICE"] ?? 0,
            "CURRENCY" => ($productInfo["CURRENCY"]) ?: 'RUB',
            "PRICE_SCALE" => $productInfo["PRICE"] ?? 0
        ]);
    }

    $newItemId = $element->save();

    if ($newItemId->isSuccess()) {
        //сброс зависимостей для отображения корректных данных
        $ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues(CATALOG_IBLOCK_ID, $elementId);
        $ipropValues->clearValues();

        $result = ["STATUS" => "OK"];
    } else {
        $result = ["STATUS" => "ERROR"];
    }

    return $result;
}
//
function createProduct(int $elementId, array $productInfo): array
{
    $product = \Bitrix\Catalog\ProductTable::add(["ID" => $elementId]);

    if ($product->isSuccess()) {
        $price = \Bitrix\Catalog\PriceTable::add([
            "PRODUCT_ID" => $product->getId(),
            "CATALOG_GROUP_ID" => 1,
            "PRICE" => $productInfo["PRICE"] ?? 0,
            "CURRENCY" => ($productInfo["CURRENCY"]) ?: 'RUB',
            "PRICE_SCALE" => $productInfo["PRICE"] ?? 0
        ]);

        if ($price->isSuccess()) {
            $result = ['STATUS' => 'OK'];
        } else {
            $result = ["STATUS" => "ERROR"];
        }
    } else {
        $result = ["STATUS" => "ERROR"];
    }

    return $result;
}
