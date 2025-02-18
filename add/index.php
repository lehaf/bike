<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */
$sectionId = "";

if(isset($_GET['type'])) {
	$sectionName = "";
	$section = \Bitrix\Iblock\SectionTable::getList([
		'select' => ['NAME'], // Поле "Название"
		'filter' => ['ID' => $_GET['type']],
	])->fetch();
	if(!empty($section)) {
		$sectionName = mb_strtolower(trim($section['NAME']));
	}

	if($_GET['element'] && $_GET['action'] === 'edit') {
		$APPLICATION->SetTitle("Изменить объявление" . " (" . $sectionName . ")");
	} else {
		$APPLICATION->SetTitle("Подать объявление" . " (" . $sectionName . ")");
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
		"SUCCESS_LINK" => '/personal/obyavleniya/?section=' . $sectionId,
	),
	false
);?>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>