<?php
$FILTER_NAME = (string)$arParams["FILTER_NAME"];

//добавление в фильтр год
if ($_GET[$FILTER_NAME . '_year_MIN'] || $_GET[$FILTER_NAME . '_year_MAX']) {
    $yearsForFilter = array_column($arResult['ITEMS']['year']['VALUES'], "VALUE");
    $yearFrom = $_GET[$FILTER_NAME . '_year_MIN'] ?? min($yearsForFilter);
    $yearTo = $_GET[$FILTER_NAME . '_year_MAX'] ?? max($yearsForFilter);
    $years = range($yearFrom, $yearTo);

    $propertyYearId = \Bitrix\Iblock\PropertyTable::getList([
        'filter' => ['=IBLOCK_ID' => $arParams["IBLOCK_ID"], '=CODE' => 'year'],
        'select' => ['ID']
    ])->fetch()['ID'];

    $yearsId = \Bitrix\Iblock\PropertyEnumerationTable::getList([
        'filter' => [
            '=PROPERTY_ID' => $propertyYearId,
            '=VALUE' => $years // Массив значений для поиска
        ],
        'select' => ['ID']
    ])->fetchAll();
    $GLOBALS[$FILTER_NAME]['=PROPERTY_' . $propertyYearId] = array_column($yearsId, 'ID');
}

//добавление фото и видео
if ($_GET[$FILTER_NAME . '_photo']) $GLOBALS[$FILTER_NAME]['!PREVIEW_PICTURE'] = false;
if ($_GET[$FILTER_NAME . '_video']) {
    $propertyVideoId = \Bitrix\Iblock\PropertyTable::getList([
        'filter' => ['=IBLOCK_ID' => $arParams["IBLOCK_ID"], '=CODE' => 'VIDEO_YOUTUBE'],
        'select' => ['ID']
    ])->fetch()['ID'];
    $GLOBALS[$FILTER_NAME]['!PROPERTY_' . $propertyVideoId] = false;
}

//добавление местоположения
$cities = [];
if ($_GET[$FILTER_NAME . '_city']) {
    $cities = $_GET[$FILTER_NAME . '_city'];
} else if($_GET[$FILTER_NAME . '_region'] && $_GET[$FILTER_NAME . '_country']) {
    $regionCities = $arResult['LOCATIONS'][$_GET[$FILTER_NAME . '_country']]['REGIONS'][$_GET[$FILTER_NAME . '_region']]['CITIES'] ?? [['ID' => 1]];
    $cities = array_column($regionCities, 'ID');
} else if ($_GET[$FILTER_NAME . '_country']) {
    if ($arResult['LOCATIONS'][$_GET[$FILTER_NAME . '_country']]) {
        foreach ($arResult['LOCATIONS'][$_GET[$FILTER_NAME . '_country']]['REGIONS'] as $region) {
            foreach ($region['CITIES'] as $city) {
                $cities[] = $city['ID'];
            }
        }
    } else {
        $cities = 1;
    }
};
if(!empty($cities)) {
    $propertyCountryId = \Bitrix\Iblock\PropertyTable::getList([
        'filter' => ['=IBLOCK_ID' => $arParams["IBLOCK_ID"], '=CODE' => 'country'],
        'select' => ['ID']
    ])->fetch()['ID'];
    $GLOBALS[$FILTER_NAME]['=PROPERTY_' . $propertyCountryId] = $cities;
}

//добавление марки и модели (добавление раздела)
$marksWithModels = [];
$emptyMarks = [];
$emptyMarksModels = [];
$sections = [];
// Перебираем все элементы массива
if ($_GET[$FILTER_NAME . '_mark']) {
    foreach ($_GET[$FILTER_NAME . '_mark'] as $key => $value) {
        $models = explode(",", $value);
        if ($models[0] === "Y") {
            $emptyMarks[] = $key;
        } else {
            $sections = array_merge($sections, $models);
        }
    }

    if (!empty($emptyMarks)) {
        $emptyMarksModels = \Bitrix\Iblock\SectionTable::getList([
            'filter' => [
                'IBLOCK_ID' => $arParams["IBLOCK_ID"],  // ID инфоблока, в котором ищем
                'ACTIVE' => 'Y',   // Только активные разделы
                'IBLOCK_SECTION_ID' => $emptyMarks  // ID родительского раздела
            ],
            'select' => ['ID'],  // Выбираем необходимые поля
        ])->fetchAll();
        $emptyMarksModels = array_column($emptyMarksModels, 'ID');
    }
    $sections = array_merge($sections, $emptyMarksModels);
    if(!empty($sections)) $GLOBALS[$FILTER_NAME]['IBLOCK_SECTION_ID'] = $sections;
}


if ($_REQUEST['ajaxCount'] == 'y') {
    $FILTER_NAME = (string)$arParams["FILTER_NAME"];
    ob_end_clean();
    $arFilter = $this->makeFilter($FILTER_NAME);
    $arResult["ELEMENT_COUNT"] = CIBlockElement::GetList(array(), $arFilter, array(), false);
    echo json_encode($arResult["ELEMENT_COUNT"]);
    die();
}
