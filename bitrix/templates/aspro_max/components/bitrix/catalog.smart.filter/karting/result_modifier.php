<?php

$arResult['SECTION']['CODE'] = \Bitrix\Iblock\SectionTable::getList([
    'filter' => ['=ID' => $arResult['SECTION']['ID']],
    'select' => ['CODE'] // Получаем только ID и CODE
])->fetch()['CODE'];

if(!empty($arResult["ITEMS"])) {
//    $categories = getSections([
//        '=IBLOCK_ID' => CATALOG_IBLOCK_ID,
//        '=IBLOCK_SECTION_ID' => $arResult['SECTION']['ID'],
//    ]);
//    $arResult['MARKS'] = $categories;

    $newItems = [];

    foreach($arResult["ITEMS"] as $arItem) {
        $newItems[$arItem['CODE']] = $arItem;
    }

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
        ]
    ])->fetchAll();
    $arResult['COUNTRIES'] = $countries;

    $locationTree = [];
    foreach ($newItems['country']['VALUES'] as $cityId => $city) {
        $cityInfo = getLocation($cityId, 'CITY');
        $regions = getLocation($cityInfo['PARENT_ID'], 'REGION');
        $countriesInfo =  getLocation($regions['PARENT_ID'], 'COUNTRY');

        if (!isset($locationTree[$countriesInfo['ID']])) {
            $locationTree[$countriesInfo['ID']] = [
                'ID' => $countriesInfo['ID'],
                'NAME' => $countriesInfo['NAME_RU'],
                'REGIONS' => []
            ];
        }

        // Проверяем, существует ли уже регион в дереве страны
        if (!isset($locationTree[$countriesInfo['ID']]['REGIONS'][$regions['ID']])) {
            $locationTree[$countriesInfo['ID']]['REGIONS'][$regions['ID']] = [
                'ID' => $regions['ID'],
                'NAME' => $regions['NAME_RU'],
                'CITIES' => []
            ];
        }

        // Добавляем город в список городов региона
        $locationTree[$countriesInfo['ID']]['REGIONS'][$regions['ID']]['CITIES'][] = [
            'ID' => $cityId,
            'NAME' => $cityInfo['NAME_RU'] // Имя города из массива $city
        ];
    }
    $arResult['LOCATIONS'] = $locationTree;

//    pr($locationTree);

    foreach ($newItems['year']['VALUES'] as &$year) {
        if($_GET['year_MIN'] === $year['VALUE']) {
            $year['CHECKED_FOR'] = 'MIN';
        }

        if($_GET['year_MAX'] === $year['VALUE']) {
            $year['CHECKED_FOR'] = 'MAX';
        }
    }
    unset($year);

//    получение XML_ID для свойства "цвет"
    if(!empty($newItems["color"]["VALUES"])) {
        $colorsId = array_keys($newItems["color"]["VALUES"]) ?? [];
        $colorsXmlId = Bitrix\Iblock\PropertyEnumerationTable::getList([
            'filter' => ['ID' => $colorsId],
            'select' => ['ID', 'XML_ID']
        ])->fetchAll();

        $colorsXmlIdMapped = array_column($colorsXmlId, 'XML_ID', 'ID');

        foreach ($newItems["color"]['VALUES'] as $key => &$item) {
            $item['XML_ID'] = $colorsXmlIdMapped[$key];
        }
        unset($item);
    }

    $arResult['ITEMS'] = $newItems;
}

function getLocation(int $locationId, string $locationType) : array
{
    while ($locationId) {
        // Получаем информацию о местоположении
        $location = \Bitrix\Sale\Location\LocationTable::getList([
            'filter' => [
                '=ID' => $locationId,
                '=NAME.LANGUAGE_ID' => 'ru',
                '=TYPE.NAME.LANGUAGE_ID' => 'ru',],
            'select' => ['ID', 'PARENT_ID', 'TYPE.CODE', 'NAME_RU' => 'NAME.NAME']
        ])->fetch();
//            pr($location);

        if ($location) {
            // Проверяем, является ли это местоположение регионом
            if ($location['SALE_LOCATION_LOCATION_TYPE_CODE'] === $locationType) {
                return $location;
            }

            // Переходим к следующему родителю
            $locationId = $location['PARENT_ID'];
        } else {
            // Если местоположение не найдено, выходим
            break;
        }
    }
    return [];
}