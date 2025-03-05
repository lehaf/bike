<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
ini_set('max_execution_time', 123456);

use PhpOffice\PhpSpreadsheet\IOFactory;

$file = IOFactory::load("tireNew.csv");

$fileData = $file->getActiveSheet()->toArray();
unset($fileData[0]);

$class = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();

if (!empty($fileData)) {
    $data = [];

//    foreach ($fileData as &$row) {
//        $brand = $row[4];
//        $data[$brand][] = $row;
//    }

    $skipped = ['Камеры для мотоциклов', 'Ободные ленты'];

    $propsNames = [
        "status",
        "producer_tire",
        "tire_length",
        "tire_height",
        "diameter",
        "transport_type",
        "category_tire",
        "state"
    ];

    $propsListInfo = getPropsInfo($propsNames);
    $articles = array_column($fileData, 0);
    $existElements = $class::getList([
        'select' => ['exp_id_' => 'exp_id.VALUE'],
        'filter' => ['USER.VALUE' => 14]
    ])->fetchAll();
    $existElements = array_column($existElements, 'exp_id_');

    $update = array_intersect($articles, $existElements); //обновить элементы
    $add = array_diff($articles, $existElements); // добавить новые
    $delete = array_diff($existElements, $articles); // удалить

//    pr($fileData);
    foreach ($fileData as $item) {
        if(in_array(trim($item[4]), $skipped)) {continue;}
        $element = setElementsPropsFromParser($item, $propsListInfo);
        if(in_array($element['fields']['exp_id'], $add)) {
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
            $elementId = $class::getList([
                'select' => ['ID'],
                'filter' => ['exp_id.VALUE' => $element['fields']['exp_id'], 'USER.VALUE' => 14]
            ])->fetch()['ID'];

            pr(['update' => $elementId]);
            updateElement($elementId, $element);
        }
    }

    if(!empty($delete)) {
        $elementDelete = $class::getList([
            'select' => ['ID'],
            'filter' => ['exp_id.VALUE' => $delete]
        ])->fetchAll();
        foreach ($elementDelete as $item) {
            pr(['delete' => $item['ID']]);
            deleteElements($item['ID']);
        }
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

    $tireSection = 10692;
    $fields = [
        "NAME" => $elem[1],
        "PREVIEW_PICTURE" => $elem[8],
        "DETAIL_PICTURE" => $elem[8],
        "DETAIL_TEXT_TYPE" => "html",
        "IBLOCK_SECTION_ID" => $tireSection,
//        "MORE_PHOTO" => $images,

        "exp_id" => trim($elem[0]),
        "status" => trim($elem[3]),
        "producer_tire" => trim($elem[4]),
        "tire_length" => trim($elem[5]),
        "tire_height" => trim($elem[6]),
        "diameter" => trim($elem[7]),
        "transport_type" => ["мотоцикл"],
        "category_tire" => "продать",
        "state" => "новая",
        "BRAND" => 49865,
        "USER" => 14,


        "phone" => ["+375 (29) 544-33-33"],
        "country" => "Минск", // город
        "contact_person" => "motoshina.by", // имя
    ];


    $productInfo = [
        "PRICE" => round($elem[2] * 1.02, 2),
        "CURRENCY" => 'USD',
    ];

    $fields = convertElementFields($fields, $propsInfo);
    return ['fields' => $fields, 'product' => $productInfo];
}

function convertElementFields(array $props, array $propsInfo): array
{
    $listProps = array_keys($propsInfo);

    foreach ($props as $propCode => &$propValue) {
        if($propCode === 'tire_length') {
            $values = [
                '3' => '3.00',
                '4' => '4.00',
                '5' => '5.00',
                '6' => '6.00',
                '7' => '7.00',
                '8' => '8.00',
                '9' => '9.00',
                '10' => '10.00',
                '11' => '11.00',
                '12' => '12.00',
                '13' => '13.00',
                '14' => '14.00',
                '15' => '15.00',
                '16' => '16.00',
                '18' => '18.00',
                '20' => '20.00',
                '22' => '22.00',
                '24' => '24.00',
            ];
            $propValue = ($values[$propValue]) ?: $propValue;
        }
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

function createElement(array $data): array
{
    $notUserProps = [
        "ID",
        "IBLOCK_ID",
        "IBLOCK_SECTION_ID",
        "SORT",
        "NAME",
        "PREVIEW_PICTURE",
        "PREVIEW_TEXT",
        "DETAIL_PICTURE",
        "DETAIL_TEXT",
        "DETAIL_TEXT_TYPE",
        "CODE",
        "MORE_PHOTO",
    ];

    $iblockClass = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();
    $newElement = $iblockClass::createObject();
    $newElement->setId(0);

    $newElement->set("ACTIVE", true);
    $newElement->set("ACTIVE_FROM", date('d.m.Y H:i:s'));
    $newElement->set("SEARCHABLE_CONTENT", strtoupper($data["NAME"]));

    $arTransParams = array(
        "max_len" => 250,
        "change_case" => 'L',
        "replace_space" => '-',
        "replace_other" => '-',
        "delete_repeat_replace" => true
    );
    $newElement->set("CODE", \CUtil::translit($data["NAME"], "ru", $arTransParams));


    foreach ($data as $prop => &$item) {
        if ($prop === 'PREVIEW_PICTURE' || $prop === 'DETAIL_PICTURE') {
            if ($item !== "https://motokolesa.by") {
                $fileId = resizeImage($item);
                $data[$prop] = $fileId;
            }
        }

//        if($prop === 'MORE_PHOTO') {
//            $fileId = [];
//            foreach ($item as $photo) {
//                $arFile = \CFile::MakeFileArray($photo);
//                $fileId[] = \CFile::SaveFile($arFile, "iblock");
//            }
//
//            $data[$prop] = $fileId;
//        }

        $isUserProp = in_array($prop, $notUserProps);

        if (!$isUserProp) {
            $property = \Bitrix\Iblock\PropertyTable::getList([
                'filter' => [
                    'IBLOCK_ID' => CATALOG_IBLOCK_ID,
                    'CODE' => $prop,
                ],
                'select' => ['ID', 'PROPERTY_TYPE'],
            ])->fetch();

            if (!$property['ID']) {
                continue; // Если свойство не найдено, завершаем обработку
            }
        }

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
        \Bitrix\Main\Diag\Debug::dumpToFile(['errors' => $result]);
    }

    return $result ?? [];
}

function updateElement (int $elementId, array $elementInfo): void {

    $iblockClass = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();
    $element = $iblockClass::getByPrimary($elementId)->fetchObject();
    $element->set('status', $elementInfo['fields']['status']);
    $element->set('tire_length', $elementInfo['fields']['tire_length']);
    $element->save();

    $ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues(CATALOG_IBLOCK_ID, $elementId);
    $ipropValues->clearValues();

    $existingPrice = \Bitrix\Catalog\PriceTable::getList([
        'filter' => [
            'PRODUCT_ID' => $elementId,
            'CATALOG_GROUP_ID' => 1,
        ]
    ])->fetch();

    $price = round($elementInfo['product']["PRICE"] * 1.02, 2);
    if ($existingPrice) {
        \Bitrix\Catalog\PriceTable::update($existingPrice['ID'], [
            "PRICE" => $price,
            "CURRENCY" => ($elementInfo['product']["CURRENCY"]) ?: 'BYN',
            "PRICE_SCALE" => $price
        ]);
    }
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

function resizeImage(string $filePath): ?int
{
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

            $arResizeOptions = [
                "width" => $arFile["WIDTH"] - 80,
                "height" => $arFile["HEIGHT"] - 80,
            ];

            if ($imageWidth > $maxWidth || $imageHeight > $maxHeight) {
                $arResizeOptions = array(
                    "width" => $maxWidth,
                    "height" => $maxHeight,
                );
            }

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

    return $fileId ?? null;
}

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


