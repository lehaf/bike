<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
ini_set('max_execution_time', 123456);
use PhpOffice\PhpSpreadsheet\IOFactory;

$file = IOFactory::load("marksModels.csv");

$fileData = $file->getActiveSheet()->toArray();
unset($fileData[0]);

$class = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();

$newList = [];
//vr($fileData);
if (!empty($fileData)) {
    $result = [];
    foreach ($fileData as $item) {
        $type = $item[0];
        $brand = $item[1];
        $model = $item[2];

        // Инициализируем массивы, если они еще не существуют
        if (!isset($result[$type])) {
            $result[$type] = [];
        }
        if (!isset($result[$type][$brand])) {
            $result[$type][$brand] = [];
        }

        // Добавляем модель в соответствующий бренд
        $result[$type][$brand][] = $model;
    }

    $bs = new \CIBlockSection();
    foreach ($result as $type => $items) {
        if($type === 'snow') {
            foreach ($items as $mark => $models) {
                $markCode = transformCode($mark);
                $fields = [
                    "ACTIVE" => "Y", // Активность раздела
                    "IBLOCK_ID" => CATALOG_IBLOCK_ID, // ID инфоблока
                    "NAME" => $mark, // Название нового раздела
                    "CODE" => $markCode,
                    "IBLOCK_SECTION_ID" => 10536,// ID родительского раздела
                ];
                $sectionId = $bs->Add($fields);
                foreach ($models as $model) {
                    $modelCode = transformCode($model);
                    $fields = [
                        "ACTIVE" => "Y", // Активность раздела
                        "IBLOCK_ID" => CATALOG_IBLOCK_ID, // ID инфоблока
                        "NAME" => $model, // Название нового раздела
                        "CODE" => $modelCode,
                        "IBLOCK_SECTION_ID" => $sectionId,// ID родительского раздела
                    ];
                    $subsectionId = $bs->Add($fields);
                }
            }
        }
    }
    pr($result);
}

function transformCode($str) {
    $arTransParams = array(
        "max_len" => 250,
        "change_case" => 'L',
        "replace_space" => '_',
        "replace_other" => '_',
        "delete_repeat_replace" => true
    );
    return \CUtil::translit($str, "ru", $arTransParams);
}

