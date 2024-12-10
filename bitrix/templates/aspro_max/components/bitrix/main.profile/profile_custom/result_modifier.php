<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

if(!empty($arResult['arUser']['UF_COUNTRY_ID'])) {
    $id = $arResult['arUser']['UF_COUNTRY_ID'];
    $type = 'REGION';
    $arResult['REGIONS'] = getLocations($type, $id);
}

if(!empty($arResult['arUser']['UF_REGION_ID'])) {
    $id = $arResult['arUser']['UF_REGION_ID'];
    $type = 'CITY';
    $arResult['CITIES'] = getLocations($type, $id);
}
