<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "left";

// need to correct display prop stores_filter
Aspro\Max\Stores\Property::filterSmartProp($arResult['ITEMS'], $arParams);

foreach($arResult["ITEMS"] as $key => $arItem)
{
	if( $arItem['PROPERTY_TYPE'] === 'L' ){
		$arPropInline[] = $arItem['ID'];
		$arPropInlineName[$arItem['ID']] = $arItem['NAME'];
	}
	
}

$resultEnum = Bitrix\Iblock\PropertyEnumerationTable::getList([
	'select' => ['PROPERTY_ID', 'COUNT'],
	'group' => ['PROPERTY_ID'],
	'filter' => ['=COUNT' => 1, 'PROPERTY_ID' => $arPropInline],
	'runtime' => array(
	new Bitrix\Main\Entity\ExpressionField('COUNT', 'COUNT(*)')
	)
]);
while ($rowEnum = $resultEnum->fetch()){
	if(is_array($arResult["ITEMS"][$rowEnum['PROPERTY_ID']]["VALUES"]))
		sort($arResult["ITEMS"][$rowEnum['PROPERTY_ID']]["VALUES"]);
	if($arResult["ITEMS"][$rowEnum['PROPERTY_ID']]["VALUES"])
		$arResult["ITEMS"][$rowEnum['PROPERTY_ID']]["VALUES"][0]["VALUE"] = $arPropInlineName[$rowEnum['PROPERTY_ID']];
	$arResult['ITEMS'][$rowEnum['PROPERTY_ID']]['IS_PROP_INLINE'] = true;
} 

\Bitrix\Main\Localization\Loc::loadLanguageFile(__FILE__);

// sort
if ($arParams['SHOW_SORT']) {
	include 'sort.php';
}

global $sotbitFilterResult;
$sotbitFilterResult = $arResult;