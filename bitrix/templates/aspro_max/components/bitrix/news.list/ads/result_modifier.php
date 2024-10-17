<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Main\Loader;
use Bitrix\Catalog\PriceTable;
use Bitrix\Currency\CurrencyManager;

?>
<?php
//получение разделов в табах
$productsSections = [TIRES_SECTION_ID, PRODUCTS_SECTION_ID, SERVICES_SECTION_ID, GARAGES_SECTION_ID];
$sections = [TRANSPORT_SECTION_ID, PARTS_SECTION_ID, $productsSections];
$sectionsTabs = [];
if (!empty($sections)) {
    foreach ($sections as $key => $section) {
        if (is_array($section)) {
            $rsSection = getSections([
                '=IBLOCK_ID' => $arParams['IBLOCK_ID'],
                '=ID' => $section,
            ]);
        } else {
            $rsSection = getSections([
                '=IBLOCK_ID' => $arParams['IBLOCK_ID'],
                '=IBLOCK_SECTION_ID' => $section,
            ]);
        }
        //количество элементов
        if (!empty($rsSection)) {
            foreach ($rsSection as &$sect) {
                $count = CIBlockElement::GetList(
                    [],
                    [
                        'IBLOCK_ID' => $arParams['IBLOCK_ID'], // ID вашего инфоблока
                        'SECTION_ID' => $sect['ID'], // ID раздела
                        'PROPERTY_USER' => $USER->GetID(),
                        'INCLUDE_SUBSECTIONS' => 'Y', // Включение подкатегорий (если нужно)
                    ],
                    [],
                    false,
                    ['ID']
                );
                $sect['COUNT'] = $count;
                $sectionsTabs[$sect['ID']] = $sect;
            }
            unset($sect);
        }
    }
}
$filteredItems = array_filter($sectionsTabs, function($item) {
    return intval($item['COUNT']) > 0;
});
$arResult['SECTIONS'] = $filteredItems;

if (!empty($arResult['ITEMS'])) {
    //получение доступных валют и цен
    $allPrices = getItemPrices($arResult);

    foreach ($arResult['ITEMS'] as &$item) {
        //получение ссылки на детальную страницу
        $rsItems = \Bitrix\Iblock\ElementTable::getList([
            'select' => ['ID', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'CODE', 'DETAIL_PAGE_URL' => 'IBLOCK.DETAIL_PAGE_URL'],
            'filter' => ['=ID' => $item['ID']]
        ])->fetch();
        $item['DETAIL_PAGE_URL'] = CIBlock::ReplaceDetailUrl($rsItems['DETAIL_PAGE_URL'], $rsItems, false, 'E');

        //количество дней с момента публикации
        $date1 = new DateTime($item['ACTIVE_FROM']);
        $date2 = new DateTime(date('d.m.Y H:i:s'));
        $interval = $date1->diff($date2);
        $item['PUBLISH_DAYS'] = ($interval->days === 0) ? 1 : $interval->days;

        //конвертация цены
//        $itemPrices = $pricesByProductId[$item['ID']];
        $itemPrices = $allPrices['prices'][$item['ID']];
        if ($itemPrices) {
            $item['PRICES'] = convertPrice($itemPrices, $allPrices['desired'], $allPrices['base']);
        }

        //получение названия раздела
        if ((int)$_GET['section'] === PRODUCTS_SECTION_ID) {
            $item['SECTION_NAME'] = \Bitrix\Iblock\SectionTable::getList([
                'filter' => ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $item['IBLOCK_SECTION_ID']],
                'select' => ['NAME'],
            ])->fetch()['NAME'];
        }

        //получения города
        $item['CITY'] = \Bitrix\Sale\Location\LocationTable::getList([
            'filter' => [
                "=TYPE.CODE" => "CITY",
                '=ID' => $item['PROPERTIES']['country'],
                '=NAME.LANGUAGE_ID' => 'ru',
                '=TYPE.NAME.LANGUAGE_ID' => 'ru',
            ],
            'select' => [
                'NAME_RU' => 'NAME.NAME',
            ],
        ])->fetch()['NAME_RU'];


        //получение даты добавления в виде "7 сентября"
        $item['FORMAT_ACTIVE_FROM'] = convertDate($item['ACTIVE_FROM'] ?? $item['DATE_CREATE']);
    }

    $arResult['PARENT_SECTION_ID'] = Bitrix\Iblock\SectionTable::getList([
        'filter' => ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $_GET['section']],
        'select' => ['IBLOCK_SECTION_ID'],
    ])->fetch()['IBLOCK_SECTION_ID'];

    //получение дерева разделов (для секции товаров)
    if ((int)$_GET['section'] === PRODUCTS_SECTION_ID) {
        $sectionTree = buildSectionTreeFromItems($arResult['ITEMS'], $arParams['IBLOCK_ID']);
        updateElementCounts($sectionTree);

        $arResult['SECTION_TREE'] = $sectionTree[PRODUCTS_SECTION_ID]['CHILDREN'];
    }

}

function buildSectionTreeFromItems(array $items, int $iblockId): array
{
    $sectionIds = [];
    $elementCounts = [];

    foreach ($items as $item) {
        if (!empty($item['IBLOCK_SECTION_ID'])) {
            $sectionId = $item['IBLOCK_SECTION_ID'];
            $sectionIds[] = $sectionId;

            if (!isset($elementCounts[$sectionId])) {
                $elementCounts[$sectionId] = 0;
            }
            $elementCounts[$sectionId]++;
        }
    }

    $sectionIds = array_unique($sectionIds);

    if (empty($sectionIds)) {
        return [];
    }

    $sections = getAllParentSections($sectionIds, $iblockId);
    return buildSectionTree($sections, $elementCounts);
}

function getAllParentSections(array $sectionIds, int $iblockId): array
{
    $allSections = [];

    $sections = Bitrix\Iblock\SectionTable::getList([
        'filter' => ['IBLOCK_ID' => $iblockId, 'ID' => $sectionIds],
        'select' => ['ID', 'NAME', 'IBLOCK_SECTION_ID'],
        'order' => ['IBLOCK_SECTION_ID' => 'ASC', 'SORT' => 'ASC']
    ])->fetchAll();

    $allSections = array_merge($allSections, $sections);
    $parentIds = array_filter(array_column($sections, 'IBLOCK_SECTION_ID'));

    while (!empty($parentIds)) {
        $parentSections = Bitrix\Iblock\SectionTable::getList([
            'filter' => ['IBLOCK_ID' => $iblockId, 'ID' => $parentIds],
            'select' => ['ID', 'NAME', 'IBLOCK_SECTION_ID'],
            'order' => ['IBLOCK_SECTION_ID' => 'ASC', 'SORT' => 'ASC']
        ])->fetchAll();

        $allSections = array_merge($allSections, $parentSections);
        $parentIds = array_filter(array_column($parentSections, 'IBLOCK_SECTION_ID'));
    }

    return $allSections;
}

function buildSectionTree(array $sections, array $elementCounts): array
{
    $tree = [];
    $sectionIndex = [];

    foreach ($sections as $section) {
        $section['CHILDREN'] = [];
        $section['ELEMENT_COUNT'] = isset($elementCounts[$section['ID']]) ? $elementCounts[$section['ID']] : 0;
        $sectionIndex[$section['ID']] = $section;
    }

    foreach ($sectionIndex as $id => &$section) {
        if ($section['IBLOCK_SECTION_ID']) {
            if (isset($sectionIndex[$section['IBLOCK_SECTION_ID']])) {
                $sectionIndex[$section['IBLOCK_SECTION_ID']]['CHILDREN'][$id] = &$section;
            }
        } else {
            $tree[$id] = &$section;
        }
    }

    unset($section);
    return $tree;
}

function updateElementCounts(array &$tree): void
{
    foreach ($tree as &$section) {
        if (!empty($section['CHILDREN'])) {
            updateElementCounts($section['CHILDREN']);
            foreach ($section['CHILDREN'] as $childSection) {
                $section['ELEMENT_COUNT'] += $childSection['ELEMENT_COUNT'];
            }
        }
    }
}

?>
