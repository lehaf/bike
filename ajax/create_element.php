<?php

use web\CreateElement;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (isset($_POST['action'])) {
    //получение марок и моделей
    if ($_POST['action'] === 'categories') {
        $sectId = (int)$_POST['sectId'];
        $categories = [];
        if ($sectId) {
            $categories = getSections([
                '=IBLOCK_ID' => CATALOG_IBLOCK_ID,
                '=IBLOCK_SECTION_ID' => $sectId,
            ]);
        }

        if ($_POST['flag'] === 'getSubCategories') {
            $options = '';
            $html = '';
            if (!empty($categories)) {
                foreach ($categories as $category) {
                    $options .= '<option value="' . $category['ID'] . '">' . $category['NAME'] . '</option>';
                }
                $html = '<label for="categorySelect" class="form-group__label">Подкатегория товара<span>*</span></label>
                                    <div class="form-row">
                                        <select name="SUBCATEGORY" class="select-type custom-select selectSearch check-block"
                                                id="subCategorySelect" data-text="Поиск по названию" data-select="subcat-list">
                                                <option value="" selected>
                                                Поиск по названию
                                            </option>
                                                <option value="reset">
                                Сбросить
                            </option>';
                $html .= $options;
                $html .= '</select>
                      <div class="error-form">Необходимо заполнить «Подкатегория товара»</div>
                      </div>';
            }
            echo json_encode($html);
            die();
        }

        echo json_encode($categories);
        die();
    } elseif ($_POST['action'] === 'categoryWithPopular') {
        $sectId = (int)$_POST['sectId'];
        $categories = [];
        $popularSections = [];
        if ($sectId) {
            $categories = getSections([
                '=IBLOCK_SECTION_ID' => $sectId,
            ]);
            $popularSections = getSections([
                '=ACTIVE' => 'Y',
                '!UF_POPULAR' => false,
                '=IBLOCK_SECTION_ID' => $sectId
            ]);
        }

        echo json_encode(['fullCategories' => $categories, 'popularCategories' => $popularSections]);
        die();
    } elseif ($_POST['action'] === 'location') { //получение областей
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
    }
}