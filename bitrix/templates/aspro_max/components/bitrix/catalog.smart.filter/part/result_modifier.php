<?php

$arResult['SECTION']['CODE'] = \Bitrix\Iblock\SectionTable::getList([
    'filter' => ['=ID' => $arResult['SECTION']['ID']],
    'select' => ['CODE'] // Получаем только ID и CODE
])->fetch()['CODE'];

if(!empty($arResult["ITEMS"])) {
    $newItems = [];

    foreach($arResult["ITEMS"] as $arItem) {
        $newItems[$arItem['CODE']] = $arItem;
        $checkedValues = array_filter(array_column($arItem['VALUES'], 'CHECKED'));
        if (!empty($checkedValues)) {
            $newItems[$arItem['CODE']]['HAS_CHECKED'] = true;
        }
    }

    $currentSection = \Bitrix\Iblock\SectionTable::getRowById($arParams['START_SECTION_ID'] ?? $arParams['SECTION_ID']);
    if ((int)$currentSection['DEPTH_LEVEL'] === 3) {
        $newItems['MARK'] = $currentSection['ID'];
    } elseif ((int)$currentSection["DEPTH_LEVEL"] === 4) {
        $newItems['MARK'] = $currentSection['IBLOCK_SECTION_ID'];
        $newItems['MODEL'] = $currentSection['ID'];
    }

    $arResult['FILTER_MARKS'] = array_keys($_GET[$arParams['FILTER_NAME'] . "_mark"] ?? []);
    $arResult['FILTER_MODELS'] = $_GET[$arParams['FILTER_NAME'] . '_mark'] ?? [];

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
        ],
    ])->fetchAll();
    $arResult['COUNTRIES'] = $countries;

    if($_GET[$arParams['FILTER_NAME'] . '_country']) {
        $id = $_GET[$arParams['FILTER_NAME'] . '_country'];
        $type = 'REGION';
        $arResult['REGIONS'] = getLocations($type, $id);
    }

    if($_GET[$arParams['FILTER_NAME'] . '_region']) {
        $id = $_GET[$arParams['FILTER_NAME'] . '_region'];
        $type = 'CITY';
        $arResult['CITIES'] = getLocations($type, $id);
    }

    foreach ($newItems['year']['VALUES'] as &$year) {
        if ($_GET[$arParams['FILTER_NAME'] . '_year_MIN'] === $year['VALUE']) {
            $newItems['year']['HAS_CHECKED_FOR_MIN'] = true;
            $year['CHECKED_FOR'] = 'MIN';
        }

        if ($_GET[$arParams['FILTER_NAME'] . '_year_MAX'] === $year['VALUE']) {
            $newItems['year']['HAS_CHECKED_FOR_MAX'] = true;
            $year['CHECKED_FOR'] = 'MAX';
        }
    }
    unset($year);

    $statusStock = [];
    if(!empty($newItems['status']['VALUES'])) {
        foreach ($newItems['status']['VALUES'] as $status) {
            if($status['URL_ID'] === 'stock') {
                $statusStock = $status;
            }
        }
        $newItems['status'] = $statusStock;
    }

    $arResult['ITEMS'] = $newItems;
}