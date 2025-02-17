<?php

use classes\Filter;

$entity = \Bitrix\Iblock\Model\Section::compileEntityByIblock(CATALOG_IBLOCK_ID);
$sectInfo = $entity::getList([
    'filter' => ['=ID' => $arResult['SECTION']['ID']],
    'select' => ['CODE', 'UF_SECTION_CODE'] // Получаем только ID и CODE
])->fetch();

$arResult['SECTION']['CODE'] = (!empty($sectInfo['UF_SECTION_CODE']) ? $sectInfo['UF_SECTION_CODE'] : $sectInfo['CODE']);

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

    $filter = new Filter();
    $arFilter = $filter::getFilterParams($_SERVER['QUERY_STRING'], $arParams['FILTER_NAME'], CATALOG_IBLOCK_ID, $currentSection['ID']);
    $arResult['FILTER_ELEMENTS_COUNT'] = CIBlockElement::GetList([], $arFilter, [], false);

    $arResult['ITEMS'] = $newItems;
}

if(\Bitrix\Main\Engine\CurrentUser::get()->getId()) {
    $entityUsersSearch = getHlblock("b_user_search");
    $result = $entityUsersSearch::getList([
        "select" => ["*"],
        "order" => ["ID"=>"DESC"],
        "filter" => ["UF_USER_ID" => \Bitrix\Main\Engine\CurrentUser::get()->getId()],
    ])->fetchAll();
    if(!empty($result)) {
        foreach ($result as &$item) {
            $res = \CIBlockSection::GetByID($item['UF_SECTION']);
            if ($section = $res->GetNext()) {
                $item['FILTER_SECTION_URL'] = $section['SECTION_PAGE_URL'];
            }
        }
        unset($item);
    }
    $arResult['SEARCHES'] = $result;

    $filterUrl = [];
    foreach ($_GET as $key => $value) {
        if($key === "set_filter" || str_contains($key, $arParams['FILTER_NAME'])) {
            if($key === $arParams['FILTER_NAME'] . '_mark') {
                foreach ($value as $markId => $markValue) {
                    $filterUrl[] = $key . '[' . $markId . ']=' . $markValue;
                }
            } else {
                $filterUrl[] = $key . "=" . $value;
            }
        }
    }
    $filterUrl = "?" . implode("&", $filterUrl);

    $arFilter = [
        "=UF_FILTER_QUERY" => $filterUrl,
        "=UF_USER_ID" => \Bitrix\Main\Engine\CurrentUser::get()->getId(),
    ];
    $arSelect = [
        'ID',
        'UF_TITLE',
        'UF_DESCRIPTION',
        'UF_FILTER_QUERY',
        'UF_NOTIFY_INTERVAL',
    ];

    $result = $entityUsersSearch::getList([
        'select' => $arSelect,
        'filter' => $arFilter,
    ])->fetch();

    $arResult['EXIST_SEARCH'] = $result;
}