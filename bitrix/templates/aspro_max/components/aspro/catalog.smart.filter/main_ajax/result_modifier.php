<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(count($arResult['COMBO']) == 1)
{
	$hidden = true;
	foreach($arResult['COMBO'][0] as $value)
	{
		if($value)
			$hidden = false;
	}
}

if($hidden)
	$arResult['ITEMS'] = array();

if($arResult['ITEMS'])
{
	$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "left";

	// need to correct display prop stores_filter
	Aspro\Max\Stores\Property::filterSmartProp($arResult['ITEMS'], $arParams);

	foreach($arResult["ITEMS"] as $key => $arItem)
	{
		if( $arItem['PROPERTY_TYPE'] === 'L' ){
			$arPropInline[] = $arItem['ID'];
			$arPropInlineName[$arItem['ID']] = $arItem['NAME'];
		}

		if(isset($arItem['PRICE']) && $arItem['PRICE'])
		{
			if (
				(isset($arItem['VALUES']['MIN']['HTML_VALUE']) && $arItem['VALUES']['MIN']['HTML_VALUE'])
				&& (isset($arItem['VALUES']['MAX']['HTML_VALUE']) && $arItem['VALUES']['MAX']['HTML_VALUE'])
			) {
				$arResult['PRICE_SET'] = 'Y';
				break;
			}
		}

		$i = 0;

		if($arItem['PROPERTY_TYPE'] == 'S' || $arItem['PROPERTY_TYPE'] == 'L' || $arItem['PROPERTY_TYPE'] == 'E')
		{
			foreach($arItem['VALUES'] as $arValue)
			{
				if(isset($arValue['CHECKED']) && $arValue['CHECKED'])
				{
					$arResult["ITEMS"][$key]['PROPERTY_SET'] = 'Y';
					++$i;
				}
			}

			if($i)
			{
				$arResult["ITEMS"][$key]['COUNT_SELECTED'] = $i;
			}
		}

		if($arItem['PROPERTY_TYPE'] == 'N')
		{
			foreach($arItem['VALUES'] as $arValue)
			{
				if(isset($arValue['HTML_VALUE']) && $arValue['HTML_VALUE'])
				{
					$arResult['ITEMS'][$key]['PROPERTY_SET'] = 'Y';
				}
			}
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
}

if ($arParams['SHOW_SORT']) {

	$sort = array( 'ASPRO_FILTER_SORT' => array (
		'NAME' => GetMessage('ASPRO_FILTER_SORT'),
		'DISPLAY_TYPE' => 'ASPRO_FILTER_SORT',
		'DISPLAY_EXPANDED' => 'Y',
		"CODE" => 'ASPRO_FILTER_SORT',
		"ID" => 'ASPRO_FILTER_SORT',
		"ASPRO_FILTER_SORT" => "Y",
		'VALUES' => array (),
	));

	$arResult["ITEMS"] = $sort + $arResult["ITEMS"];

	$arAvailableSort = array();
	$arSorts = $arParams["SORT_BUTTONS"];

	if(in_array("POPULARITY", $arSorts)){
		$arAvailableSort["SHOWS"] = array("SHOWS", "desc");
	}
	if(in_array("NAME", $arSorts)){
		$arAvailableSort["NAME"] = array("NAME", "asc");
	}
	if(in_array("PRICE", $arSorts)){
		$arSortPrices = $arParams["SORT_PRICES"];
		if($arSortPrices == "MINIMUM_PRICE" || $arSortPrices == "MAXIMUM_PRICE"){
			$arAvailableSort["PRICE"] = array("PROPERTY_".$arSortPrices, "desc");
		}
		else{
			if($arSortPrices == "REGION_PRICE")
			{
				global $arRegion;
				if($arRegion)
				{
					if(!$arRegion["PROPERTY_SORT_REGION_PRICE_VALUE"] || $arRegion["PROPERTY_SORT_REGION_PRICE_VALUE"] == "component")
					{
						$price = CCatalogGroup::GetList(array(), array("NAME" => $arParams["SORT_REGION_PRICE"]), false, false, array("ID", "NAME"))->GetNext();
						$arAvailableSort["PRICE"] = array("CATALOG_PRICE_".$price["ID"], "desc");
					}
					else
					{
						$arAvailableSort["PRICE"] = array("CATALOG_PRICE_".$arRegion["PROPERTY_SORT_REGION_PRICE_VALUE"], "desc");
					}
				}
				else
				{
					$price_name = ($arParams["SORT_REGION_PRICE"] ? $arParams["SORT_REGION_PRICE"] : "BASE");
					$price = CCatalogGroup::GetList(array(), array("NAME" => $price_name), false, false, array("ID", "NAME"))->GetNext();
					$arAvailableSort["PRICE"] = array("CATALOG_PRICE_".$price["ID"], "desc");
				}
			}
			else
			{
				$price = CCatalogGroup::GetList(array(), array("NAME" => $arParams["SORT_PRICES"]), false, false, array("ID", "NAME"))->GetNext();
				$arAvailableSort["PRICE"] = array("CATALOG_PRICE_".$price["ID"], "desc");
			}
		}
	}
	if(in_array("QUANTITY", $arSorts)){
		$arAvailableSort["CATALOG_AVAILABLE"] = array("QUANTITY", "desc");
	}
	$sort = "SHOWS";
	if((array_key_exists("sort", $_REQUEST) && array_key_exists(ToUpper($_REQUEST["sort"]), $arAvailableSort)) || (array_key_exists("sort", $_SESSION) && array_key_exists(ToUpper($_SESSION["sort"]), $arAvailableSort)) || $arParams["ELEMENT_SORT_FIELD"]){
		if($_REQUEST["sort"]){
			$sort = ToUpper($_REQUEST["sort"]);
			$_SESSION["sort"] = ToUpper($_REQUEST["sort"]);
		}
		elseif($_SESSION["sort"]){
			$sort = ToUpper($_SESSION["sort"]);
		}
		else{
			$sort = ToUpper($arParams["ELEMENT_SORT_FIELD"]);
		}
	}
	$sort_order=$arAvailableSort[$sort][1];
	if((array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc"))) || (array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc")) ) || $arParams["ELEMENT_SORT_ORDER"]){
		if($_REQUEST["order"]){
			$sort_order = $_REQUEST["order"];
			$_SESSION["order"] = $_REQUEST["order"];
		}
		elseif($_SESSION["order"]){
			$sort_order = $_SESSION["order"];
		}
		else{
			$sort_order = ToLower($arParams["ELEMENT_SORT_ORDER"]);
		}
	}

	foreach($arAvailableSort as $key => $val){
		$newSort = $sort_order == 'desc' ? 'asc' : 'desc';
		$current_url = $APPLICATION->GetCurPageParam('sort='.$key.'&order='.$newSort, 	array('sort', 'order'));
		$url = str_replace('+', '%2B', $current_url);
		$arResult["ITEMS"]['ASPRO_FILTER_SORT']['VALUES'][] = array(
		    'CONTROL_HTML' => '<span class="sort_btn js-load-link '.(($sort == $key && $newSort == $sort_order) ? 'current' : '').' '.$sort_order.' '.$key.'" data-url="'.$url.'" onclick="AjaxClickLink(this)">'.GetMessage('SECT_SORT_'.$key).' ('.GetMessage($newSort).')'.'</span>',
		    'CHECKED' => ($sort == $key && $newSort == $sort_order) ? 'Y' : 'N',
		    'VALUE' => GetMessage('SECT_SORT_'.$key).' ('.GetMessage($newSort).')',
		);

		$newSort = $sort_order == 'desc' ? 'desc' : 'asc';
		$current_url = $APPLICATION->GetCurPageParam('sort='.$key.'&order='.$newSort, 	array('sort', 'order'));
		$url = str_replace('+', '%2B', $current_url);
		$arResult["ITEMS"]['ASPRO_FILTER_SORT']['VALUES'][] = array(
		    'CONTROL_HTML' => '<span class="sort_btn js-load-link '.(($sort == $key && $newSort == $sort_order) ? 'current' : '').' '.$sort_order.' '.$key.'" onclick="AjaxClickLink(this)">'.GetMessage('SECT_SORT_'.$key).' ('.GetMessage($newSort).')'.'</span>',
		    'CHECKED' => ($sort == $key && $newSort == $sort_order) ? 'Y' : 'N',
		    'VALUE' => GetMessage('SECT_SORT_'.$key).' ('.GetMessage($newSort).')',
		);
	}
}

global $sotbitFilterResult;
$sotbitFilterResult = $arResult;