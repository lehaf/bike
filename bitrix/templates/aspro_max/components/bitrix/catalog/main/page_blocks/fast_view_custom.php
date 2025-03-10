<?$ElementID = $APPLICATION->IncludeComponent(
	"bitrix:catalog.element",
	"fast_view_custom",
	Array(
		"USE_REGION" => ($arRegion ? "Y" : "N"),
		"USE_PREDICTION" => $arParams['USE_DETAIL_PREDICTION'],
		"SECTION_TIZER"=>$arSection["UF_TIZERS"],
		"SHOW_UNABLE_SKU_PROPS"=>$arParams["SHOW_UNABLE_SKU_PROPS"],
		"HELP_TEXT"=>$arSection["UF_HELP_TEXT"],
		"CALCULATE_DELIVERY" => $arTheme["CALCULATE_DELIVERY"]["VALUE"],
		"EXPRESSION_FOR_CALCULATE_DELIVERY" => $arTheme["EXPRESSION_FOR_CALCULATE_DELIVERY"]["VALUE"],
		"ALT_TITLE_GET" => $arParams["ALT_TITLE_GET"],
		"GRUPPER_PROPS" => $arParams["GRUPPER_PROPS"],
		"USE_CUSTOM_RESIZE" => $arParams["USE_CUSTOM_RESIZE"],
		"SHOW_DISCOUNT_TIME_EACH_SKU" => $arParams["SHOW_DISCOUNT_TIME_EACH_SKU"],
		"DETAIL_DOCS_PROP"=>$arParams["DETAIL_DOCS_PROP"],
		"SHOW_DISCOUNT_TIME"=>$arParams["SHOW_DISCOUNT_TIME"],
		"SHOW_CHEAPER_FORM"=>$arParams["SHOW_CHEAPER_FORM"],
		"SHOW_ARTICLE_SKU" => $arParams["SHOW_ARTICLE_SKU"],
		"TYPE_SKU" => "TYPE_1",
		"SEF_URL_TEMPLATES" => $arParams["SEF_URL_TEMPLATES"],
		"IBLOCK_REVIEWS_TYPE" => $arParams["IBLOCK_REVIEWS_TYPE"],
		"IBLOCK_REVIEWS_ID" => $arParams["IBLOCK_REVIEWS_ID"],
		"SHOW_ONE_CLICK_BUY" => $arParams["SHOW_ONE_CLICK_BUY"],
		"SEF_MODE_BRAND_SECTIONS" => $arParams["SEF_MODE_BRAND_SECTIONS"],
		"SEF_MODE_BRAND_ELEMENT" => $arParams["SEF_MODE_BRAND_ELEMENT"],
		"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
		"META_KEYWORDS" => $arParams["DETAIL_META_KEYWORDS"],
		"META_DESCRIPTION" => $arParams["DETAIL_META_DESCRIPTION"],
		"BROWSER_TITLE" => $arParams["DETAIL_BROWSER_TITLE"],
		"BASKET_URL" => $arParams["BASKET_URL"],
		"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
		"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
		"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
		"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		'SHOW_POPUP_PRICE' => (CMax::GetFrontParametrValue('SHOW_POPUP_PRICE') == 'Y' ? "Y" : "N"),
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"SET_TITLE" => "N",
		"SET_CANONICAL_URL" => $arParams["DETAIL_SET_CANONICAL_URL"],
		"SET_LAST_MODIFIED" => "Y",
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"MESSAGE_404" => $arParams["MESSAGE_404"],
		"SHOW_404" => $arParams["SHOW_404"],
		"FILE_404" => $arParams["FILE_404"],
		"PRICE_CODE" => $arParams['PRICE_CODE'],
		"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
		"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
		"USE_RATIO_IN_RANGES" => $arParams["USE_RATIO_IN_RANGES"],
		"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
		"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
		"LINK_IBLOCK_TYPE" => $arParams["LINK_IBLOCK_TYPE"],
		"LINK_IBLOCK_ID" => $arParams["LINK_IBLOCK_ID"],
		"LINK_PROPERTY_SID" => $arParams["LINK_PROPERTY_SID"],
		"LINK_ELEMENTS_URL" => $arParams["LINK_ELEMENTS_URL"],
		"USE_ALSO_BUY" => $arParams["USE_ALSO_BUY"],
		'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
		'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
		"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
		"OFFERS_FIELD_CODE" => $arParams["DETAIL_OFFERS_FIELD_CODE"],
		"OFFERS_PROPERTY_CODE" => $arParams["DETAIL_OFFERS_PROPERTY_CODE"],
		"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
		"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
		"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
		"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
		"SKU_DISPLAY_LOCATION" => $arParams["SKU_DISPLAY_LOCATION"],
		// "ELEMENT_ID" => 2504,
		"ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
		"ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
		"ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
		"ADD_ELEMENT_CHAIN" => $arParams["ADD_ELEMENT_CHAIN"],
		"USE_STORE" => $arParams["USE_STORE"],
		"USE_STORE_PHONE" => $arParams["USE_STORE_PHONE"],
		"USE_STORE_SCHEDULE" => $arParams["USE_STORE_SCHEDULE"],
		"USE_MIN_AMOUNT" => $arParams["USE_MIN_AMOUNT"],
		"MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
		"STORE_PATH" => $arParams["STORE_PATH"],
		"MAIN_TITLE" => $arParams["MAIN_TITLE"],
		"CATALOG_DETAIL_SHOW_AMOUNT_STORES" => CMax::GetFrontParametrValue('CATALOG_DETAIL_SHOW_AMOUNT_STORES'),
		"USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
		"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
		"IBLOCK_STOCK_ID" => $arParams["IBLOCK_STOCK_ID"],
		"SEF_MODE_STOCK_SECTIONS" => $arParams["SEF_MODE_STOCK_SECTIONS"],
		"SHOW_QUANTITY" => $arParams["SHOW_QUANTITY"],
		"SHOW_QUANTITY_COUNT" => $arParams["SHOW_QUANTITY_COUNT"],
		"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
		"CURRENCY_ID" => $arParams["CURRENCY_ID"],
		'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
		'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
		'SHOW_DEACTIVATED' => $arParams['SHOW_DEACTIVATED'],
		"USE_ELEMENT_COUNTER" => $arParams["USE_ELEMENT_COUNTER"],
		'STRICT_SECTION_CHECK' => (isset($arParams['DETAIL_STRICT_SECTION_CHECK']) ? $arParams['DETAIL_STRICT_SECTION_CHECK'] : ''),
		'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),

		"USE_RATING" => $arParams["USE_RATING"],
		"USE_REVIEW" => $arParams["USE_REVIEW"],
		"REVIEWS_VIEW" => $arTheme["REVIEWS_VIEW"]["VALUE"],
		"FORUM_ID" => $arParams["FORUM_ID"],
		"MAX_AMOUNT" => $arParams["MAX_AMOUNT"],
		"USE_ONLY_MAX_AMOUNT" => $arParams["USE_ONLY_MAX_AMOUNT"],
		"DISPLAY_WISH_BUTTONS" => $arParams["DISPLAY_WISH_BUTTONS"],
		"DEFAULT_COUNT" => $arParams["DEFAULT_COUNT"],
		"SHOW_BRAND_PICTURE" => $arParams["SHOW_BRAND_PICTURE"],
		"PROPERTIES_DISPLAY_LOCATION" => $arParams["PROPERTIES_DISPLAY_LOCATION"],
		"PROPERTIES_DISPLAY_TYPE" => "TABLE",
		"SHOW_ADDITIONAL_TAB" => $arParams["SHOW_ADDITIONAL_TAB"],
		"SHOW_ASK_BLOCK" => $arParams["SHOW_ASK_BLOCK"],
		"ASK_FORM_ID" => $arParams["ASK_FORM_ID"],
		"SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
		"SHOW_HINTS" => $arParams["SHOW_HINTS"],
		"OFFER_HIDE_NAME_PROPS" => $arParams["OFFER_HIDE_NAME_PROPS"],
		"SHOW_KIT_PARTS" => $arParams["SHOW_KIT_PARTS"],
		"SHOW_KIT_PARTS_PRICES" => $arParams["SHOW_KIT_PARTS_PRICES"],
		"SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
		"SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
		"SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
		'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
		'ADD_DETAIL_TO_SLIDER' => (isset($arParams['DETAIL_ADD_DETAIL_TO_SLIDER']) ? $arParams['DETAIL_ADD_DETAIL_TO_SLIDER'] : ''),
		"SHOW_EMPTY_STORE" => $arParams['SHOW_EMPTY_STORE'],
		"SHOW_GENERAL_STORE_INFORMATION" => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
		"USER_FIELDS" => $arParams['USER_FIELDS'],
		"FIELDS" => $arParams['FIELDS'],
		"STORES" => $arParams['STORES'],
		"BIG_DATA_RCM_TYPE" => $arParams['BIG_DATA_RCM_TYPE'],
		"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
		"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
		"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
		"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
		"SALE_STIKER" => $arParams["SALE_STIKER"],
		"STIKERS_PROP" => $arParams["STIKERS_PROP"],
		"SHOW_RATING" => $arParams["SHOW_RATING"],

		"OFFERS_LIMIT" => $arParams["DETAIL_OFFERS_LIMIT"],

		'SHOW_BASIS_PRICE' => (isset($arParams['DETAIL_SHOW_BASIS_PRICE']) ? $arParams['DETAIL_SHOW_BASIS_PRICE'] : 'Y'),
		"DETAIL_PICTURE_MODE" => 'POPUP',

		'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : ''),
		'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
		'SET_VIEWED_IN_COMPONENT' => (isset($arParams['DETAIL_SET_VIEWED_IN_COMPONENT']) ? $arParams['DETAIL_SET_VIEWED_IN_COMPONENT'] : ''),

		'SHOW_SLIDER' => (isset($arParams['DETAIL_SHOW_SLIDER']) ? $arParams['DETAIL_SHOW_SLIDER'] : ''),
		'SLIDER_INTERVAL' => (isset($arParams['DETAIL_SLIDER_INTERVAL']) ? $arParams['DETAIL_SLIDER_INTERVAL'] : ''),
		'SLIDER_PROGRESS' => (isset($arParams['DETAIL_SLIDER_PROGRESS']) ? $arParams['DETAIL_SLIDER_PROGRESS'] : ''),
		'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
		'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),

		'OFFER_SHOW_PREVIEW_PICTURE_PROPS' => $arParams['OFFER_SHOW_PREVIEW_PICTURE_PROPS'],

		"USE_GIFTS_DETAIL" => 'N',
		"USE_GIFTS_MAIN_PR_SECTION_LIST" => 'N',
		"GIFTS_SHOW_DISCOUNT_PERCENT" => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
		"GIFTS_SHOW_OLD_PRICE" => $arParams['GIFTS_SHOW_OLD_PRICE'],
		"GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],
		"GIFTS_DETAIL_HIDE_BLOCK_TITLE" => $arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE'],
		"GIFTS_DETAIL_TEXT_LABEL_GIFT" => $arParams['GIFTS_DETAIL_TEXT_LABEL_GIFT'],
		"GIFTS_DETAIL_BLOCK_TITLE" => $arParams["GIFTS_DETAIL_BLOCK_TITLE"],
		"GIFTS_SHOW_NAME" => $arParams['GIFTS_SHOW_NAME'],
		"GIFTS_SHOW_IMAGE" => $arParams['GIFTS_SHOW_IMAGE'],
		"GIFTS_MESS_BTN_BUY" => $arParams['GIFTS_MESS_BTN_BUY'],

		"GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
		"GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'],
		"CHEAPER_FORM_NAME" => $arParams["CHEAPER_FORM_NAME"],
		"OID" => $arParams["OID"],
		"SHOW_SKU_DESCRIPTION" => $arParams["SHOW_SKU_DESCRIPTION"],
		"SKU_DETAIL_ID" => $arParams["SKU_DETAIL_ID"],
		'CURRENT_BASE_PAGE' => TSolution\CacheableUrl::get(),
	),
	$component
);?>
