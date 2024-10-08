<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Мои объявления");
if (!$USER->isAuthorized()) {
    LocalRedirect(SITE_DIR . 'auth');
} else {
    ?>
    <?php
    global $filterUser;
    $filterUser = [
		'=PROPERTY_USER' => \Bitrix\Main\Engine\CurrentUser::get()->getId(),
		'=SECTION_ID' => (isset($_GET['subsection'])) ? $_GET['subsection'] : $_GET['section'],
		'INCLUDE_SUBSECTIONS' => 'Y',
		'ACTIVE' => "",
	];
    ?>
    <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"ads", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "N",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "ACTIVE",
			2 => "DATE_CREATE",
		),
		"FILTER_NAME" => "filterUser",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "26",
		"IBLOCK_TYPE" => "aspro_max_catalog",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "diameter",
			1 => "type_atv",
			2 => "type_bike",
			3 => "type_scooter",
			4 => "type_snow",
			5 => "transport_type",
			6 => "year",
			7 => "state",
			8 => "count_door_bike",
			9 => "count_door_atv",
			10 => "count_door_snow",
			11 => "count_door_scooter",
			12 => "cylinders_count_atv",
			13 => "cylinders_count_scooter",
			14 => "cylinders_count_snow",
			15 => "producer",
			16 => "motor_type_bike",
			17 => "motor_type_scooter",
			18 => "motor_type_atv",
			19 => "motor_type_snow",
			20 => "color",
			21 => "state_moto",
			22 => "state_part",
			23 => "complect_bike",
			24 => "complect_scooter",
			25 => "complect_snow",
			26 => "complect_atv",
			27 => "race",
			28 => "race_unit",
			29 => "MODEL_OTHER",
			30 => "power",
			31 => "country",
			32 => "contact_person",
			33 => "phone",
			34 => "type1",
			35 => "type2",
			36 => "height",
			37 => "length",
			38 => "number",
			39 => "square",
			40 => "VIDEO_YOUTUBE",
			41 => "PRICE_TYPE",
			42 => "width",
			43 => "cylinders_count_bike",
			44 => "PROP_373",
			45 => "PROP_371",
			46 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "ads"
	),
	false
);?>
<? } ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>