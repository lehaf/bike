<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */
$sectionId = "";
if(isset($_GET['type'])) {
	if($_GET['element'] && $_GET['action']) {
		$APPLICATION->SetTitle("Изменить объявление");
	} else {
		$APPLICATION->SetTitle("Подать объявление");
	}

	$sectionId = $_GET['type'];
} else {
	$APPLICATION->SetTitle("Выберите категорию");
}
?>
<?$APPLICATION->IncludeComponent(
	"web:create.element",
	".default",
	array(
		"IS_TEMPLATE_INCLUDE" => "Y",
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE" => "aspro_max_catalog",
		"IBLOCK_ID" => "26",
		"SECTION_ID" => $sectionId,
		"AUTH_LINK" => '/auth',
		"SUCCESS_LINK" => '/personal/ads/?section=' . $sectionId,
	),
	false
);?>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>