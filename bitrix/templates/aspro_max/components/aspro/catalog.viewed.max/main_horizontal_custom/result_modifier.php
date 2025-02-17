<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?php
if(!empty($arResult['ITEMS'])) {
   foreach ($arResult['ITEMS'] as &$arItem) {
       $allPrices = getItemPrices([$arItem['ID']]);
       $itemPrices = $allPrices['prices'][$arItem['ID']];
       if ($itemPrices) {
           $arItem['PRICES_CUST'] = convertPrice($itemPrices, $allPrices['desired'], $allPrices['base']);
           $arItem["INFO"]["CONVERT_PRICE"] = $arItem['PRICES_CUST']['CONVERT']['USD'];
       }

       $iblockEntity = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();

       $result = $iblockEntity::getList([
           'filter' => ['ID' => $arItem['ID']],
           'select' => ['ID', 'contract_price_' => 'contract_price.VALUE' ] // `CONTRACT_PRICE` - код свойства в верхнем регистре
       ])->fetch();

       $arItem["INFO"]["IS_CONTRACT_PRICE"] = ($result['contract_price_']) ? 'Y' : 'N';

   }
}
?>