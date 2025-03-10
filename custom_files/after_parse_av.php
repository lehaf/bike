<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
ini_set('max_execution_time', 123456);

use PhpOffice\PhpSpreadsheet\IOFactory;

$file = IOFactory::load("test.csv");

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
        "state_moto",
        "country",
        "contact_person",
        "phone",
        "color",
        "saller"
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
        $entitySection = \Bitrix\Iblock\Model\Section::compileEntityByIblock(CATALOG_IBLOCK_ID);

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
            $sectionId = $entitySection::getList([
                'select' => ['ID'],
                'filter' => ['=UF_SECTION_CODE' => $key]
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
//                                $updateElements[] = setElementsPropsFromParser($val, $propsListInfo);
                                $elementId = array_search($val[2], $siteElementsNumbers, true);
                                $element = setElementsPropsFromParser($val, $propsListInfo);
                                $newElement = editElement($element['fields'] ?? [], $elementId, $element['product']);
                                pr(['edit_' . $elementId => $element]);
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

    if (!empty($images)) {
        foreach ($images as &$image) {
            $folder = $_SERVER["DOCUMENT_ROOT"] . "/custom_files/img/";

            $filePath = $folder . $image;

            if (!file_exists($filePath)) {
                // Убираем расширение из имени файла
                $fileNameWithoutExt = pathinfo($image, PATHINFO_FILENAME);
                // Ищем файл с любым расширением
                $files = glob($folder . $fileNameWithoutExt . ".*");

                if (!empty($files)) {
                    // Берем первый найденный файл
                    $image = $files[0];
                }
            } else {
                $image = $filePath;
            }
        }
    }

    $previewImg = $images[0];
    unset($images[0]);

    $raceUnit = (trim($elem[14]) === 'моточасов') ? 'мото ч.' : trim($elem[14]);
    $phones = explode("||", $elem[19]);
    $formatPhones = [];
    if(!empty($phones)) {
        foreach ($phones as $phone) {
            $formatPhones[] = formatPhoneNumber($phone);
        }
    }

    $raceKm = convertRace(trim($elem[13]), $raceUnit);
    $state = (($elem[7] === '2024' || $elem[7] === '2025') && (int)$raceKm < 100) ? 'Новый' : 'С пробегом';

    $fields = [
        "IS_AV" => 'Да',
        "NAME" => "$elem[5] $elem[6], $elem[7] г.",
        "PREVIEW_PICTURE" => $previewImg,
        "DETAIL_PICTURE" => $previewImg,
        "DETAIL_TEXT" => $elem[18],
        "DETAIL_TEXT_TYPE" => "html",
        "IBLOCK_SECTION_ID" => $elem["SECTION_ID"],
//        "MORE_PHOTO" => $images,

        "complect_" . $elem[1] => explode("||", $elem[15]), // комплектация (надо создать)
        "phone" => $formatPhones, // телефон
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
        "race_km" => $raceKm,
        "state_moto" => $state,
        "country" => trim($elem[16]), // город
        "contact_person" => trim($elem[20]), // имя

        "color" => "Чёрный",
        "saller" => "Частное лицо"
    ];

    $productInfo = [
        "PRICE" => trim($elem[3]),
        "CURRENCY" => 'BYN',
    ];
    $fields = convertElementFields($fields, $propsInfo);
    return ['fields' => $fields, 'product' => $productInfo];
}

function formatPhoneNumber($phoneNumber) : string
{
    // Убираем лишние символы (например, пробелы или тире) и приводим к единому виду
    $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

    // Проверяем, начинается ли номер с "+"
    if (!str_starts_with($phoneNumber, '375')) {
        return $phoneNumber;
    }

    // Проверяем длину номера после приведения к формату
    if (strlen($phoneNumber) !== 12) {
        return $phoneNumber;
    }

    // Разбиваем номер на части
    $countryCode = substr($phoneNumber, 0, 3); // Код страны
    $areaCode = substr($phoneNumber, 3, 2);   // Код оператора
    $part1 = substr($phoneNumber, 5, 3);      // Первая часть номера
    $part2 = substr($phoneNumber, 8, 2);      // Вторая часть номера
    $part3 = substr($phoneNumber, 10, 2);     // Третья часть номера

    // Форматируем номер
    return "+$countryCode ($areaCode) $part1-$part2-$part3";
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

    $date = getRandomDate();
    $newElement->set("ACTIVE", true);
    $newElement->set("ACTIVE_FROM", $date);
    $newElement->set("SEARCHABLE_CONTENT", strtoupper($data["NAME"]));
    $newElement->set("DATE_CREATE", $date);
    $newElement->set("TIMESTAMP_X", $date);


    $arTransParams = array(
        "max_len" => 250,
        "change_case" => 'L',
        "replace_space" => '-',
        "replace_other" => '-',
        "delete_repeat_replace" => true
    );
    $newElement->set("CODE", \CUtil::translit($data["NAME"], "ru", $arTransParams));


    foreach ($data as $prop => &$item) {
        if($prop === 'PREVIEW_PICTURE' || $prop === 'DETAIL_PICTURE') {
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
    $element = $iblockClass::getByPrimary($elementId)->fetchObject();
//    $elementPhotos = $iblockClass::getByPrimary($elementId, ['select' => ['MORE_PHOTO', 'PREVIEW_PICTURE']])->fetchObject();
//
//    $delPhotos = [];
//    if (!empty($elementPhotos)) {
//        foreach ($elementPhotos->getMorePhoto()->getAll() as $photo) {
//            $delPhotos[] = $photo->getValue();
//        }
//        $delPhotos[] = $elementPhotos->getPreviewPicture();
//        $delPhotos[] = $elementPhotos->getDetailPicture();
//
//        if (!empty($delPhotos)) {
//            foreach ($delPhotos as $photo) {
//                \CFile::Delete($photo);
//            }
//        }
//    }

    $arTransParams = array(
        "max_len" => 250,
        "change_case" => 'L',
        "replace_space" => '-',
        "replace_other" => '-',
        "delete_repeat_replace" => true
    );
    $element->set("CODE", \CUtil::translit($data["NAME"], "ru", $arTransParams));

    $currentDate = new \DateTime();
    $date = getRandomDate();
    $element->set("TIMESTAMP_X", $currentDate->format('d.m.Y H:i:s'));
    $element->set("DATE_CREATE", $date);
    $element->set("LAST_RISE", $date);

    if (!empty($data)) {
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
        foreach ($data as $prop => &$item) {
            if($prop === 'PREVIEW_PICTURE' || $prop === 'DETAIL_PICTURE') {
                continue;
//                $arFile = \CFile::MakeFileArray($item);
//                $fileId = \CFile::SaveFile($arFile, "iblock");
//                $data[$prop] = $fileId;
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
                    continue;
                }
            }

            if (is_array($item)) {
                $element->fill($prop);
                $propertyValues = $element->get($prop);
                // Удаляем все существующие значения
                foreach ($propertyValues as $val) {
                    $propertyValues->remove($val);
                }
                foreach ($item as $value) {
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
function getRandomDate() {
    $start = strtotime('-30 days'); // 30 дней назад от текущего дня
    $end = time(); // Текущий момент

    $randomTimestamp = rand($start, $end);

    return date('d.m.Y H:i:s', $randomTimestamp);
}
