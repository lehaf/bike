<?php

use web\CreateElement;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'getCategories') {
        $sectId = (int)$_POST['sectId'];
        $categories = [];
        $html = "";
        if($sectId) {
            $categories = getLeafSections($sectId);
        }

        if(!empty($categories)) {
            $options = '';
            $html .= ' <select name="type-moto" class="select-type custom-select check-block" id="section">
                                <option value="" selected>
            Выберите раздел
            </option>';
            foreach ($categories as $category) {
                $options .= '<option value="' . $category['ID'] . '">' . $category['NAME'] . '</option>';
            }
            $html .= $options;
            $html .= '</select>';

        }

        echo json_encode($html);
        die();
    }
}

function getLeafSections(int $sectionId = null) {
    $categories = [];
    $sections = \Bitrix\Iblock\SectionTable::getList([
        'filter' => [
            'IBLOCK_ID' => CATALOG_IBLOCK_ID,
            'IBLOCK_SECTION_ID' => $sectionId,
            'ACTIVE' => 'Y',
        ],
        'select' => ['ID', 'NAME'],
    ])->fetchAll();

    foreach ($sections as $section) {
        // Проверяем наличие подразделов у текущего раздела
        $subSections = \Bitrix\Iblock\SectionTable::getList([
            'filter' => [
                'IBLOCK_ID' => CATALOG_IBLOCK_ID,
                'IBLOCK_SECTION_ID' => $section['ID'], // Подразделы текущего раздела
                'ACTIVE' => 'Y',
            ],
            'select' => ['ID', 'NAME'],
        ])->fetchAll();

        if (count($subSections) > 0) {
            $categories = array_merge($categories, getLeafSections($section['ID']));
        } else {
            $categories[] = $section;
        }
    }

    return $categories;
}