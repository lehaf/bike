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
    $allPrices = getItemPrices(array_column($arResult['ITEMS'], 'ID'));

    //дерево разделов услуг
    $servicesSectionTree = [];
    if((int)$_GET['section'] === SERVICES_SECTION_ID) {
        $servicesSectionTree = buildSectionTreeFromItems($arResult['ITEMS'], $arParams['IBLOCK_ID']);
    }

    $parentSection = $servicesSectionTree[$_GET['section']]['CHILDREN'];
    foreach ($arResult['ITEMS'] as &$item) {
        //получение раздела и подрадела
        $item['SECTIONS_CHAIN'] = findSectionRecursive($parentSection, $item['IBLOCK_SECTION_ID']);

        if((int)$_GET['section'] === SERVICES_SECTION_ID) {
            $nameParts = explode('|', $item['NAME']); // Разделяем по запятой

            if (count($nameParts) > 1) {
                $name = trim($nameParts[1]);
                $fc = mb_strtoupper(mb_substr($name, 0, 1));
                $item['NAME'] =$fc . mb_substr($name, 1);; // Преобразуем вторую часть
            }
        }


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

        //количество дней в продаже
        $startDate = new DateTime($item['DATE_CREATE']);
        $currentDate = new DateTime(); // по умолчанию берет текущую дату и время

        $interval = $startDate->diff($currentDate);
        $item['DIFF_DAYS'] = number_format((int)$interval->days, 0, '.', ' ');

        //количество в избранном
        $entityFav = \Bitrix\Iblock\Iblock::wakeUp(32)->getEntityDataClass();
        $resultFav = $entityFav::getList([
            'select' => ['LINK_ELEMENTS'],
            'filter' => ['LINK_ELEMENTS.IBLOCK_GENERIC_VALUE' => $item['ID']],
        ])->fetchAll();
       $item['FAVORIT_COUNT'] = count($resultFav);

        //доступно ли поднятие вверх
        $item['UP_TIME_LEFT'] = false;
        $item['UP_DAYS'] = false;

        if(!empty($item['PROPERTIES']['LAST_RISE']['VALUE'])) {
            $currentDate = new DateTime();
            $createDate = new DateTime($item['DATE_CREATE']);
            $lastRiseDate = new DateTime($item['PROPERTIES']['LAST_RISE']['VALUE']);

            if($createDate->format('Y-m-d H:i:s') !== $lastRiseDate->format('Y-m-d H:i:s')) {
                $interval = $currentDate->diff($lastRiseDate);
                $elapsedHours = ($interval->days * 24) + $interval->h;

                if($elapsedHours < (int)$arParams['UP_TIME']) {
                    $item['UP_TIME_LEFT'] = $arParams['UP_TIME'] - $elapsedHours;
                }

                $currentDay = $currentDate->setTime(0,0);
                $lastRiseDay = $lastRiseDate->setTime(0,0);
                $intervalDays = $currentDay->diff($lastRiseDate);
                $daysDiff = $intervalDays->days;

                if ($interval->invert === 1) { // Если дата последнего поднятия раньше текущей даты
                    if ($daysDiff === 0) {
                        $item['UP_DAYS'] = "сегодня";
                    } elseif ($daysDiff === 1) {
                        $item['UP_DAYS'] = "вчера";
                    } else {
                        $item['UP_DAYS'] = $daysDiff . ' ' . getPluralForm($daysDiff, ['день', 'дня', 'дней']) . ' '  ."назад";
                    }
                }
            }
        }

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

function findSectionRecursive($sections, $targetSectionId) {
    foreach ($sections as $sectionId => $section) {
        // Проверяем, является ли текущий раздел нужным
        if ($sectionId == $targetSectionId) {
            return $section['NAME']; // Возвращаем название найденного раздела
        }

        // Если есть дочерние разделы, ищем среди них
        if (!empty($section['CHILDREN'])) {
            $result = findSectionRecursive($section['CHILDREN'], $targetSectionId);
            if ($result) {
                return $section['NAME'] . ' — ' . $result; // Формируем цепочку разделов
            }
        }
    }
    return null; // Если не нашли, возвращаем null
}

?>
