<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Main\Loader;
use Bitrix\Catalog\PriceTable;
use Bitrix\Currency\CurrencyManager;

?>
<?php
if (!empty($arResult['ITEMS'])) {
    //получение доступных валют и цен
    $allPrices = getItemPrices(array_column($arResult['ITEMS'], 'ID'));
    foreach ($arResult['ITEMS'] as &$item) {

        //получение даты добавления в виде "7 сентября"
        $updateDate = DateTime::createFromFormat("d.m.Y H:i:s", $item['TIMESTAMP_X']);
        $item['MODERATION_FROM_DATE'] = convertDate($item['TIMESTAMP_X']) . ' в ' . $updateDate->format("H:i");

        //получение номера кабинета пользователя
        $cabinetNumber = \Bitrix\Main\UserTable::getList([
            'select' => ['UF_CABINET_NUMBER'],
            'filter' => ['=ID' => $item['PROPERTIES']['USER']['VALUE']],
        ])->fetch();
        $item['USER_CABINET_NUMBER'] = ($cabinetNumber['UF_CABINET_NUMBER']) ?: "";

        //получение ссылки на детальную страницу
        $rsItems = \Bitrix\Iblock\ElementTable::getList([
            'select' => ['ID', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'CODE', 'DETAIL_PAGE_URL' => 'IBLOCK.DETAIL_PAGE_URL'],
            'filter' => ['=ID' => $item['ID']]
        ])->fetch();
        $item['DETAIL_PAGE_URL'] = CIBlock::ReplaceDetailUrl($rsItems['DETAIL_PAGE_URL'], $rsItems, false, 'E');
    }

}


?>
