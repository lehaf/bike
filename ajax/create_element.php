<?php

use web\CreateElement;
use Bitrix\Main\Application;


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
                $html = '<label for="categorySelect" class="form-group__label">Подкатегория товара/услуги<span>*</span></label>
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
                      <div class="error-form">Необходимо заполнить «Подкатегория товара/услуги»</div>
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
    } elseif($_POST['action'] === 'check') {
        $entityElement = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();
        $element = $entityElement::getList([
            'filter' => [
                'USER.VALUE' => \Bitrix\Main\Engine\CurrentUser::get()->getId(),
                'exp_id.VALUE' => $_POST['value'],
                '!=ID' => ($_POST['actionPage'] === 'edit') ? $_POST['elementId'] : 0
            ]
        ])->fetch();
        $result = ($element) ? ['status' => 'ERROR', 'ERRORS' => ['exp_id' => 'Объявление с таким артиклом уже существует']] : ['status' => 'OK'];
        echo json_encode($result);
    } elseif($_POST['action'] === 'getServiceSubcategories') {
        $searchQuery = $_POST['query'];

        $obSearch = new CSearchTitle;
        $obSearch->Search(
            $searchQuery,
            10,
            [
                '=MODULE_ID' => 'iblock',
                '=PARAM2' => CATALOG_IBLOCK_ID, // ID инфоблока
                '%ITEM_ID' => 'S',
                'CHECK_DATES' => 'Y',
                'STEMMING' => false
            ],
            false,
            []
        );



        $result = [];
        if ($obSearch->errorno!=0) {
            $result[] = ['error' => $obSearch->error];
        } else {
            while ($res = $obSearch->GetNext()) {
                $result[] = substr($res['ITEM_ID'], 1);
            }
        }

        $sections = \Bitrix\Iblock\SectionTable::getList([
            'filter' => [
                'IBLOCK_ID' => CATALOG_IBLOCK_ID,
                'ID' => $result, // Поиск по вхождению в название
                '!=ID' => $_POST['type'],
                '!=IBLOCK_SECTION_ID' => $_POST['type'],
            ],
            'select' => ['ID', 'NAME', 'LEFT_MARGIN', 'RIGHT_MARGIN', 'IBLOCK_SECTION_ID']
        ])->fetchAll();

        $allParents = [];
        foreach ($sections as $section) {
            $secondLevelParent = \Bitrix\Iblock\SectionTable::getList([
                'filter' => [
                    '<=LEFT_MARGIN' => $section['LEFT_MARGIN'], // Родитель должен быть слева от текущего раздела
                    '>=RIGHT_MARGIN' => $section['RIGHT_MARGIN'], // И справа от текущего
                    'IBLOCK_ID' => CATALOG_IBLOCK_ID, // Указываем инфоблок
                    '=DEPTH_LEVEL' => [1, 2],
                ],
                'select' => ['ID'],
                'order' => ['DEPTH_LEVEL' => 'DESC'],
                'limit' => 2
            ])->fetchAll();
            $parentIds = array_column($secondLevelParent, 'ID');

            if(in_array($_POST['type'], $parentIds)) {
                $resultFilter[] = array_merge($section, ['PARENT_ID' => $secondLevelParent[0]['ID']]);
            }
        }

        echo json_encode($resultFilter ?? []);
    }
}