<?
use Bitrix\Main\SystemException;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	include_once '../../../../ajax/const.php';
	require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
}
?>

<?php
$defaultSectionId = 10691;
$section['ID'] = $defaultSectionId;
$sections = \CIBlockSection::GetList(
	["SORT" => "ASC"], // Сортировка
	[
		'!UF_TABS_ON_MAIN' => false,
		'IBLOCK_ID' => CATALOG_IBLOCK_ID,
		'SECTION_ID' => $defaultSectionId, // Раздел 2-го уровня
		'ACTIVE' => 'Y',
	],
	true, // Не подсчитываем количество элементов
	['ID'] // Выбираем только ID
);

while ($test = $sections->Fetch()) {
	if($test['ELEMENT_CNT'] > 0) {
		$section['ID'] = $test['ID'];
		break;
	}
}

$ajax = false;
if ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') $ajax = true;
if ($ajax && $_POST['sectId']) {
	$section['ID'] = $_POST['sectId'];
	$tabs = $_POST['tabsId'];
}
?>
<? $APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"main_catalog_block_custom",
	array(
		"USE_REGION" => "N",
		"STORES" => "",
		"SHOW_BIG_BLOCK" => "N",
		"IS_CATALOG_PAGE" => "Y",
		"SHOW_UNABLE_SKU_PROPS" => "Y",
		"ALT_TITLE_GET" => "NORMAL",
		"IBLOCK_TYPE" => "aspro_max_catalog",
		"IBLOCK_ID" => "26",
		"SHOW_COUNTER_LIST" => "Y",
		"TABS_SECTION_ID" => $tabs ?? $defaultSectionId,
		"SECTION_ID" => $section["ID"],
		"SECTION_CODE" => "",
		"AJAX_REQUEST" => "N",
		"ELEMENT_SORT_FIELD" => "DATE_CREATE",
		"ELEMENT_SORT_ORDER" => "desc",
		"SHOW_DISCOUNT_TIME_EACH_SKU" => "N",
		"ELEMENT_SORT_FIELD2" => "sort",
		"ELEMENT_SORT_ORDER2" => "asc",
		"FILTER_NAME" => "arrFilter",
		"INCLUDE_SUBSECTIONS" => "Y",
		"PAGE_ELEMENT_COUNT" => "10",
		"LINE_ELEMENT_COUNT" => "5",
		"DISPLAY_TYPE" => "TABLE",
		"SHOW_ARTICLE_SKU" => "Y",
		"SHOW_MEASURE_WITH_RATIO" => "N",
		"BASKET_URL" => "/basket/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"MAX_GALLERY_ITEMS" => "5",
		"SHOW_GALLERY" => "Y",
		"SHOW_PROPS" => "N",
		"SHOW_POPUP_PRICE" => (CMax::GetFrontParametrValue("SHOW_POPUP_PRICE")=="Y"?"Y":"N"),
		"TYPE_VIEW_BASKET_BTN" => CMax::GetFrontParametrValue("TYPE_VIEW_BASKET_BTN"),
		"TYPE_VIEW_CATALOG_LIST" => CMax::GetFrontParametrValue("TYPE_VIEW_CATALOG_LIST"),
		"SHOW_STORES_POPUP" => (CMax::GetFrontParametrValue("STORES_SOURCE")=="STORES"&&$arParams["STORES"]),
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SET_LAST_MODIFIED" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "3600000",
		"CACHE_GROUPS" => "Y",
		"CACHE_FILTER" => "Y",
		"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
		"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
		"BROWSER_TITLE" => "-",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "Y",
		"DISPLAY_COMPARE" => "Y",
		"USE_FAST_VIEW" => CMax::GetFrontParametrValue("USE_FAST_VIEW_PAGE_DETAIL"),
		"MANY_BUY_CATALOG_SECTIONS" => CMax::GetFrontParametrValue("MANY_BUY_CATALOG_SECTIONS"),
		"SET_TITLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => $arParams["MESSAGE_404"],
		"FILE_404" => $arParams["FILE_404"],
		"PRICE_CODE" => array(
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
		"PRICE_VAT_INCLUDE" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "ajax_custom",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
		"PAGER_SHOW_ALL" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"ADD_CHAIN_ITEM" => "N",
		"SHOW_QUANTITY" => $arParams["SHOW_QUANTITY"],
		"ADD_DETAIL_TO_SLIDER" => "Y",
		"OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
		"SHOW_QUANTITY_COUNT" => $arParams["SHOW_QUANTITY_COUNT"],
		"SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
		"SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
		"SHOW_DISCOUNT_TIME" => $arParams["SHOW_DISCOUNT_TIME"],
		"SHOW_ONE_CLICK_BUY" => $arParams["SHOW_ONE_CLICK_BUY"],
		"SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
		"CONVERT_CURRENCY" => "N",
		"CURRENCY_ID" => $arParams["CURRENCY_ID"],
		"USE_STORE" => $arParams["USE_STORE"],
		"MAX_AMOUNT" => $arParams["MAX_AMOUNT"],
		"MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
		"USE_MIN_AMOUNT" => $arParams["USE_MIN_AMOUNT"],
		"USE_ONLY_MAX_AMOUNT" => $arParams["USE_ONLY_MAX_AMOUNT"],
		"DISPLAY_WISH_BUTTONS" => "Y",
		"LIST_DISPLAY_POPUP_IMAGE" => $arParams["LIST_DISPLAY_POPUP_IMAGE"],
		"DEFAULT_COUNT" => $arParams["DEFAULT_COUNT"],
		"SHOW_MEASURE" => "Y",
		"SHOW_HINTS" => "Y",
		"USE_CUSTOM_RESIZE_LIST" => $arTheme["USE_CUSTOM_RESIZE_LIST"]["VALUE"],
		"OFFER_HIDE_NAME_PROPS" => $arParams["OFFER_HIDE_NAME_PROPS"],
		"SHOW_SECTIONS_LIST_PREVIEW" => $arParams["SHOW_SECTIONS_LIST_PREVIEW"],
		"SECTIONS_LIST_PREVIEW_PROPERTY" => $arParams["SECTIONS_LIST_PREVIEW_PROPERTY"],
		"SHOW_SECTION_LIST_PICTURES" => $arParams["SHOW_SECTION_LIST_PICTURES"],
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "N",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
		"SALE_STIKER" => $arParams["SALE_STIKER"],
		"STIKERS_PROP" => $arParams["STIKERS_PROP"],
		"SHOW_RATING" => "N",
		"REVIEWS_VIEW" => (isset($arTheme["REVIEWS_VIEW"]["VALUE"])&&$arTheme["REVIEWS_VIEW"]["VALUE"]=="EXTENDED")||(!isset($arTheme["REVIEWS_VIEW"]["VALUE"])&&isset($arTheme["REVIEWS_VIEW"])&&$arTheme["REVIEWS_VIEW"]=="EXTENDED"),
		"ADD_PICT_PROP" => "MORE_PHOTO",
		"IBINHERIT_TEMPLATES" => $arSeoItem?$arIBInheritTemplates:array(),
		"FIELDS" => $arParams["FIELDS"],
		"USER_FIELDS" => $arParams["USER_FIELDS"],
		"SECTION_COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
		"SHOW_PROPS_TABLE" => $typeTableProps??strtolower(CMax::GetFrontParametrValue("SHOW_TABLE_PROPS")),
		"SHOW_OFFER_TREE_IN_TABLE" => CMax::GetFrontParametrValue("SHOW_OFFER_TREE_IN_TABLE"),
		"SHOW_SLIDER" => "Y",
		"COMPATIBLE_MODE" => "Y",
		"COMPONENT_TEMPLATE" => "main_catalog_block_custom",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SHOW_ALL_WO_SECTION" => "N",
		"BACKGROUND_IMAGE" => "-",
		"SEF_MODE" => "Y",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_LIMIT" => "5",
		"USE_MAIN_ELEMENT_SECTION" => 'Y',
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"SEF_RULE" => "",
		"SECTION_CODE_PATH" => "",
		"BLOCK_TITLE" => "Мототовары от магазинов",
		"ALL_ELEMENTS_URL" => "/catalog/moto_tovary/",
		"ALL_ELEMENTS_TITLE" => "Все мототовары",
		"COMPARE_PATH" => "",
		"USE_COMPARE_LIST" => "N"
	),
	false,
	array(
		"HIDE_ICONS" => $isAjax
	)
); ?>
