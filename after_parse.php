<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

use PhpOffice\PhpSpreadsheet\IOFactory;

$file = IOFactory::load("moto1.xlsx");

$fileData = $file->getActiveSheet()->toArray();
unset($fileData[0]);

$class = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();

$newList = [];
//vr($fileData);
if (!empty($fileData)) {
    $sections = [];
    foreach ($fileData as $data) {
//        $key1 = $data[1];
//        $key2 = $data[3];
//        $key3 = $data[4];
//        vr($data[1]);
        if(!isset($sections[$data[1]])){
            $sections[$data[1]] = [];
        }

    }

    vr($sections);
//    $arr = [
//        [
//            'podrazd' => [
//                'podrazd1' => [
//
//                ]
//            ]
//        ]
//    ];
}
