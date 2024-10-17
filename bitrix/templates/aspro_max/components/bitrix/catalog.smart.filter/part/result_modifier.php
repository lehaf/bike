<?php

$arResult['SECTION']['CODE'] = \Bitrix\Iblock\SectionTable::getList([
    'filter' => ['=ID' => $arResult['SECTION']['ID']],
    'select' => ['CODE'] // Получаем только ID и CODE
])->fetch()['CODE'];

if(!empty($arResult["ITEMS"])) {
    $newItems = [];

    foreach($arResult["ITEMS"] as $arItem) {
        $newItems[$arItem['CODE']] = $arItem;
    }

    foreach ($newItems['year']['VALUES'] as &$year) {
        if($_GET['year_MIN'] === $year['VALUE']) {
            $year['CHECKED_FOR'] = 'MIN';
        }

        if($_GET['year_MAX'] === $year['VALUE']) {
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

    $arResult['ITEMS'] = $newItems;
}