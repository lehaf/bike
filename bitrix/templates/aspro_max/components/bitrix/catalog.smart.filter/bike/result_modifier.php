<?php

use classes\Filter;

\Bitrix\Main\Loader::IncludeModule("highloadblock");
$arResult['SECTION']['CODE'] = \Bitrix\Iblock\SectionTable::getList([
    'filter' => ['=ID' => $arResult['SECTION']['ID']],
    'select' => ['CODE'] // Получаем только ID и CODE
])->fetch()['CODE'];


if (!empty($arResult["ITEMS"])) {
    $newItems = [];

    foreach ($arResult["ITEMS"] as $arItem) {
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

//    получение XML_ID для свойства "цвет"
    if (!empty($newItems["color"]["VALUES"])) {
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

    $filter = new Filter();
    $arFilter = $filter::getFilterParams($_SERVER['QUERY_STRING'], $arParams['FILTER_NAME'], CATALOG_IBLOCK_ID, $currentSection['ID']);
    $arResult['FILTER_ELEMENTS_COUNT'] = CIBlockElement::GetList([], $arFilter, [], false);


    $arResult['ITEMS'] = $newItems;

    //поиск марок
    $sectId = ($arResult['ITEMS']['MARK']) ?: $arResult['SECTION']['ID'];
    $entity = \Bitrix\Iblock\Model\Section::compileEntityByIblock($arResult['SECTION']['IBLOCK_ID']);
    $sections = $entity::getList([
        "select" => ['ID', 'CODE', 'NAME'],
        "filter" => ['=IBLOCK_SECTION_ID' => $sectId, '=ACTIVE' => 'Y', '!UF_POPULAR' => false],
        'cache' => [
            'ttl' => 36000000,
            'cache_joins' => true
        ],
    ])->fetchAll();

    if(empty($sections)) {
        $sections = $entity::getList([
            "select" => ['ID', 'CODE', 'NAME'],
            "filter" => ['=IBLOCK_SECTION_ID' => $sectId, '=ACTIVE' => 'Y'],
            "limit" => 14,
            'cache' => [
                'ttl' => 36000000,
                'cache_joins' => true
            ],
        ])->fetchAll();
    }

    foreach ($sections as &$section) {
        $filter = [
            'IBLOCK_ID' => $arResult['SECTION']['IBLOCK_ID'],
            'SECTION_ID' => $section['ID'],
            'ACTIVE' => 'Y',
            'INCLUDE_SUBSECTIONS' => 'Y'
        ];

        $section['ELEMENTS_COUNT'] = \CIBlockElement::GetList([], $filter, [], false);
    }

    unset($section);
    $sections = array_filter($sections, function ($element) {
        return $element['ELEMENTS_COUNT'] > 0;
    });

    $arResult['FOUND_BRANDS'] = $sections;
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
