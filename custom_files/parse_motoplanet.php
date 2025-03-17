<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
ini_set('max_execution_time', 123456);

$xml = simplexml_load_file('motoplanet.xml');
$objJsonDocument = json_encode($xml);
$arrOutput = json_decode($objJsonDocument, TRUE);

$data = $arrOutput['shop']['offers']['offer'];

//pr($elements);
//$class = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();
//
if (!empty($data)) {
//    $data = [];

//    CEventLog::Add(array(
//        "SEVERITY" => "SECURITY",
//        "AUDIT_TYPE_ID" => "Начало импорта объявлений с av.by",
//        "MODULE_ID" => "iblock",
//        "ITEM_ID" => CATALOG_IBLOCK_ID,
//        "DESCRIPTION" => "Начался импорт объявлений с av.by",
//    ));
//
//    foreach ($fileData as $row) {
//        $type = $row[1];
//        $mark = $row[5];
//        $model = $row[6];
//
//        if (!isset($data[$type])) {
//            $data[$type] = [];
//        }
//
//        if (!isset($data[$type][$mark])) {
//            $data[$type][$mark] = [];
//        }
//
//        if (!isset($data[$type][$mark][$model])) {
//            $data[$type][$mark][$model] = [$row];
//        } else {
//            $data[$type][$mark][$model][] = $row;
//        }
//    }

    $count = 0;
    $categoriesId = [
        102 => 14221, //мотоботы
        103 => 14222, //мотокеды
        79 => 17736, //наколенник
        83 => 14235, //налокотники
        91 => 14236, //пояса
        82 => 14238, //протекторы
        78 => 14239, //черепахи
        81 => 14240, //шорты
        87 => 17712, //чехлы
        59 => 14250, //Шлемы
        62 => 14216, //мотоштаны
        95 => 14213, //Дождевики на тело
        60 => 14214, //Куртки
        61 => 14215, //Перчатки
        89 => 17742, //Pinlock
        63 => 14212, //Комбинезоны
        93 => 14242, //Кофры, сумки
        64 => 14218, //Балаклавы
        90 => 14251, //Очки
        65 => 14252, //Визоры
        97 => 14223, //Мотобахилы
        92 => 14244, //Рюкзаки
        94 => 14246, //Сумки на бак
        86 => 14210, //Джерси
        101 => 14217, //Носки, чулки
        69 => 14219, //Термобелье
        96 => 17703, //Bluetooth гарнитуры
        109 => 17704, //Держатели для телефона
        108 => 14245,//Системы крепления для кофров


    ];

    $categoriesProps = [
        [
            'sectionId' => 14216,
            'prop' => 'material_clothes',
            'items' => [105, 106, 104, 107],
        ],
        [
            'sectionId' => 14250,
            'prop' => 'type_helmet',
            'items' => [73, 74, 75, 76, 77],
        ],
        [
            'sectionId' => 17712,
            'prop' => 'type_transport_field',
            'items' => [87],
        ]
    ];

    $propsNames = [
        "parse_link",
        "delivery",
        "payment",
        "status",
        "category_part",
        "state_product",
        "country",
        "contact_person",
        "phone",
        "saller",
        "producer_helmet",
        "producer_glass",
        "producer_clothes",
        "type_helmet",
        "material_clothes",
        "type_transport_field"
    ];


    $propsListInfo = getPropsInfo($propsNames);

    $fileElements = array_column($data, 'url');

    $class = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();
    $existElements = $class::getList([
        'select' => ['parse_link_' => 'parse_link.VALUE'],
        'filter' => ['USER.VALUE' => 18]
    ])->fetchAll();

    $existElements = array_column($existElements, 'parse_link_');
    $update = array_intersect($fileElements, $existElements); //обновить элементы
    $add = array_diff($fileElements, $existElements); // добавить новые
    $delete = array_diff($existElements, $fileElements); // удалить

    foreach ($data as &$val) {
        $propInfo = array_values(array_filter($categoriesProps, function ($item) use ($val) {
            return in_array($val['categoryId'], $item['items']);
        }));
        $iblockSectionId = ($propInfo) ? $propInfo[0]['sectionId'] : $categoriesId[(int)$val['categoryId']];

        if(!$iblockSectionId) {continue;}

        $val['section'] = $iblockSectionId;
        $val['addProp'] = ($propInfo) ? $propInfo[0]['prop'] : "";
        $element = setElementsPropsFromParser($val, $propsListInfo);
        pr($element);
        if (in_array($val['url'], $add)) {
//                                $addElements[] = setElementsPropsFromParser($val, $propsListInfo);
            $count++;
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
                'filter' => ['parse_link.VALUE' => $element['fields']['parse_link'], 'USER.VALUE' => 18]
            ])->fetch()['ID'];

//            $updateElement = setElementsPropsFromParser($val, $propsListInfo);
            $editElem = editElement($elementId, $element['product']);
            pr(['edit_' . $elementId => $element]);
        }
    }


    if(!empty($delete)) {
        $elementDelete = $class::getList([
            'select' => ['ID'],
            'filter' => ['parse_link.VALUE' => $delete]
        ])->fetchAll();
        foreach ($elementDelete as $item) {
            pr(['delete' => $item['ID']]);
            deleteElements($item['ID']);
        }
    }

//        vr(["site" => $siteElementsNumbers]);
//        vr(["file" => $fileElementsNumbers]);
//        vr($addElements);
//        vr($delElements);
//        vr($addElements);
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
    $userId = 18;
    $iblockId = 26;


    $producerType = getProducerType($iblockId, $elem['section'])[0];

    $fields = [
        "parse_link" => $elem['url'], //url
        "NAME" => $elem['name'], //name
        "PREVIEW_PICTURE" => $elem['picture'], //picture
        "DETAIL_PICTURE" => $elem['picture'], //picture
        "DETAIL_TEXT" =>  preg_replace('/^!\[CDATA\[(.*?)]]$/s', '$1', $elem['description']), //description
        "DETAIL_TEXT_TYPE" => "html",
        "IBLOCK_SECTION_ID" => $elem['section'], //$categories
//        "MORE_PHOTO" => $images,

        "category_part" => "Продать",
        "state_product" => "Новый",
        "delivery" => ["Почта", "Европочта", "Самовывоз"],
        "status" => "В наличии",
        "payment" => ["Наличный расчет", "Безналичный расчет"],
        $producerType => $elem['vendor'], //vendor , но получить code по IBLOCK_SECTION_ID

        "phone" => ["+375 (33) 390-69-06"], // телефон
        "country" => "Минск", // город
        "contact_person" => "motoplanet.by", // имя
        "saller" => "Компания",
        "user" => $userId,
    ];


    $userBrand = \Bitrix\Main\UserTable::getList([
        'select' => ['UF_BRAND_ID'],
        'filter' => ['=ID' => $userId],
    ])->fetch();

    if ($userBrand['UF_BRAND_ID']) {
        $fields['BRAND'] = $userBrand['UF_BRAND_ID'];
    }

    if (!empty($elem['addProp'])) {
        if($elem['addProp'] === 'type_transport_field') {
            $elem['typePrefix'] = ['Мотоциклы'];
        }
        $fields[$elem['addProp']] = $elem['typePrefix'];
    }

    //Если шлемы, то добавить свойство type_helmet
    //Если штаны, то добавить свойство material_clothes
    //Если чехлы, то добавить свойство type_transport_field

    $productInfo = [
        "PRICE" => trim($elem['price']), //price
        "CURRENCY" => 'BYN',
    ];
    $fields = convertElementFields($fields, $propsInfo);
    return ['fields' => $fields, 'product' => $productInfo];
}


function convertElementFields(array $props, array $propsInfo): array
{
    $materials = [
        "Джинсовые" => "Джинса",
        "Кожанные" => "Кожа",
        "Текстильные" => "Текстиль"
    ];

    $typeHelmet = [
        "Интегралы" => "Интеграл",
        "Кроссовые" => "Кроссовый",
        "Модуляры" => "Модуляр",
        "Открытые" => "Открытый",
    ];

    $producer = [
        "Bycity" => "By Сity",
        "BY CITY" => "By Сity",
    ];

    $listProps = array_keys($propsInfo);

    foreach ($props as $propCode => &$propValue) {
        if (in_array($propCode, $listProps)) {
            if($propCode === 'material_clothes' && isset($materials[$propValue])) {
                $propValue = $materials[$propValue];
            }
            if($propCode === 'type_helmet' && isset($typeHelmet[$propValue])) {
                $propValue = $typeHelmet[$propValue];
            }

            if(str_contains($propCode, 'producer_') && isset($producer[$propValue])) {
                $propValue = $producer[$propValue];
            }

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
    do {
        $randomNumber = mt_rand(100000, 999999);
        $elementExist = $iblockClass::getList([
            'select' => ['ID', 'NAME'],
            'filter' => [
                'USER.VALUE' => 18,
                'exp_id.VALUE' => $randomNumber
            ]
        ])->fetch();
    } while ($elementExist);

    $newElement = $iblockClass::createObject();
    $newElement->setId(0);

    $newElement->set("ACTIVE", true);
    $newElement->set("exp_id", $randomNumber);
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
            $fileId = resizeImage($item);
            $data[$prop] = $fileId;
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

function editElement(int $elementId, array $productInfo): array
{
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

    return ['success'];
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
                "width" => $arFile["WIDTH"] - 10,
                "height" => $arFile["HEIGHT"] - 10,
            ];

            if ($imageWidth > $maxWidth || $imageHeight > $maxHeight) {
                $arResizeOptions = array(
                    "width" => $maxWidth,
                    "height" => $maxHeight,
                );
            }

            $resizedImage = \CFile::ResizeImageGet(
                $fileId,
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

function getProducerType(int $iblockId, int $sectionId): array
{
    $sectionInfo = \Bitrix\Iblock\SectionTable::getList([
        'filter' => [
            '=IBLOCK_ID' => 26, // Указываем ID инфоблока
            '=ID' => 14215
        ],
        'select' => [
            'IBLOCK_SECTION_ID', // ID родительского раздела
            'DEPTH_LEVEL'
        ]
    ])->fetch();

    $sections = [$sectionId];
    if($sectionInfo['DEPTH_LEVEL'] > 2) {
        $sections[] = $sectionInfo['IBLOCK_SECTION_ID'];
    }

    $rsSectionProps = \Bitrix\Iblock\SectionPropertyTable::getList([
        "filter" => ['=IBLOCK_ID' => $iblockId, "=SECTION_ID" => $sections],
        "select" => ["PROPERTY_ID"],
    ])->fetchAll();
    $sectionPropsId = array_column($rsSectionProps, 'PROPERTY_ID');

    $properties = \Bitrix\Iblock\PropertyTable::getList([
        'filter' => [
            'IBLOCK_ID' => $iblockId,
            'ID' => $sectionPropsId
        ],
        'select' => ['CODE']
    ])->fetchAll();
    $producerType = array_filter($properties, function ($item) {
        return str_contains($item['CODE'], 'producer_');
    });

    return array_column($producerType, 'CODE');
}