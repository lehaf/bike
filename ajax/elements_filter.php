<?php

use web\CreateElement;
use classes\Filter;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'categories' :
            $sectId = (int)$_POST['sectId'];
            $categories = [];
            if ($sectId) {
                $categories = getSections([
                    '=IBLOCK_ID' => CATALOG_IBLOCK_ID,
                    '=IBLOCK_SECTION_ID' => $sectId,
                ]);
            }
            echo json_encode($categories);
            die();
        case 'categoryWithPopular' :
            $sectId = (int)$_POST['sectId'];
            if ($sectId) {
                $fullSect = getPopularAndFullCategories($sectId);

                if($_POST['flag'] === 'founds') {
                    $allSectionIds = [];
                    $parentSectionIds = array_merge(
                        array_column($fullSect['popularCategories'], 'ID'),
                        array_column($fullSect['fullCategories'], 'ID')
                    );
                    //получение разделов и их дочерние разделы
                    $sections = \Bitrix\Iblock\SectionTable::getList([
                        'select' => ['ID', 'IBLOCK_SECTION_ID'],
                        'filter' => [
                            'IBLOCK_ID' => CATALOG_IBLOCK_ID,
                            [
                                'LOGIC' => 'OR',
                                '@ID' => $parentSectionIds, // Указанные разделы
                                '@IBLOCK_SECTION_ID' => $parentSectionIds, // Их дочерние
                            ],
                        ],
                    ])->fetchAll();
                    $allSectionIds = array_unique(array_column($sections, 'ID'));

                    //получение количества элементов в каждом дочернем разделе (модели)
                    $elementCounts = [];
                    $res = \Bitrix\Iblock\ElementTable::getList([
                        'select' => ['CNT', 'IBLOCK_SECTION_ID'],
                        'filter' => [
                            '=IBLOCK_ID' => CATALOG_IBLOCK_ID,
                            '@IBLOCK_SECTION_ID' => $allSectionIds,
                            '=ACTIVE' => 'Y',
                        ],
                        'runtime' => [
                            new \Bitrix\Main\Entity\ExpressionField('CNT', 'COUNT(*)'),
                        ],
                        'group' => ['IBLOCK_SECTION_ID'],
                    ]);

                    while ($row = $res->fetch()) {
                        $elementCounts[$row['IBLOCK_SECTION_ID']] = $row['CNT'];
                    }

                    //подсчет элементов в родительских разделах (марки)
                    $parentElementCounts = [];
                    foreach ($parentSectionIds as $parentId) {
                        $totalCount = $elementCounts[$parentId] ?? 0; // Считываем количество для родителя
                        foreach ($sections as $section) {
                            if ($section['IBLOCK_SECTION_ID'] == $parentId) {
                                $totalCount += $elementCounts[$section['ID']] ?? 0;
                            }
                        }
                        $parentElementCounts[$parentId] = $totalCount;
                    }

                    // удаление разделов с нулевым количеством элементов
                    foreach (['popularCategories', 'fullCategories'] as $key) {
                        foreach ($fullSect[$key] as &$section) {
                            $section['ELEMENTS_COUNT'] = $parentElementCounts[$section['ID']] ?? 0;
                        }

                        $fullSect[$key] = array_filter($fullSect[$key], function ($section) {
                            return $section['ELEMENTS_COUNT'] > 0;
                        });

                        $fullSect[$key] = array_values($fullSect[$key]);
                    }
                }
                $categories = $fullSect['fullCategories'];
                $popularSections = $fullSect['popularCategories'];
            }

            echo json_encode(['fullCategories' => $categories ?? [], 'popularCategories' => $popularSections ?? []]);
            die();
        case 'location' :
            $id = (int)$_POST['id'] ?? 0;
            $type = ($_POST['flag'] === 'getRegions') ? 'REGION' : 'CITY';

            $filter = [
                '=TYPE.CODE' => $type,
                '=NAME.LANGUAGE_ID' => 'ru',
                '=TYPE.NAME.LANGUAGE_ID' => 'ru',
            ];
            $select = [
                'ID',
                'NAME_RU' => 'NAME.NAME',
                'CODE'
            ];
            $order = ['NAME_RU' => 'ASC'];

            $directRegions = \Bitrix\Sale\Location\LocationTable::getList([
                'filter' => $filter + ['=PARENT_ID' => $id],
                'select' => $select,
                'order' => $order
            ])->fetchAll();


            $indirectRegions = \Bitrix\Sale\Location\LocationTable::getList([
                'filter' => $filter + ['=PARENT.PARENT_ID' => $id],
                'select' => $select,
                'order' => $order
            ])->fetchAll();

            $allRegions = array_merge($directRegions ?? [], $indirectRegions ?? []);

            $newAllRegions = array_map(function ($region) {
                $region['NAME'] = $region['NAME_RU']; // Переименование ключа
                unset($region['NAME_RU']); // Удаление старого ключа
                return $region;
            }, $allRegions);

            echo json_encode($newAllRegions);
            die();
        case 'foundBrands':
            $sectId = (int)$_POST['sectId'];
            if ($sectId) {
                $fullSect = getPopularAndFullCategories($sectId);

                foreach ($fullSect as &$sections) {
                    foreach ($sections as &$section) {
                        $filter = [
                            'IBLOCK_ID' => CATALOG_IBLOCK_ID,
                            'SECTION_ID' => $section['ID'],
                            'ACTIVE' => 'Y',
                            'INCLUDE_SUBSECTIONS' => 'Y'
                        ];

                        $section['ELEMENTS_COUNT'] = \CIBlockElement::GetList([], $filter, [], false);
                    }
                }
                unset($sections, $section);

                $popularSections = array_values(array_filter($fullSect['popularCategories'], function ($element) {
                    return $element['ELEMENTS_COUNT'] > 0;
                }));
                $categories = array_values(array_filter($fullSect['fullCategories'], function ($element) {
                    return $element['ELEMENTS_COUNT'] > 0;
                }));
            }
            echo json_encode(['popularCategories' => $popularSections ?? [], 'fullCategories' => $categories ?? []]);
            die();
        case 'ajaxCount' :
            $filter = new Filter();
            $arFilter = $filter::getFilterParams($_POST['url'], $_POST['filterName'], CATALOG_IBLOCK_ID, $_POST['sectId']);
            echo json_encode(CIBlockElement::GetList([], $arFilter, [], false));
            die();
    }
}
