<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Localization\Loc;

$arTemplateParameters = array(
	"BLOCK_TITLE" => Array(
		"NAME" => "Заголовок блока",
		"PARENT" => "STYLE",
		"TYPE" => "STRING",
		"DEFAULT" => "Новый блок",
	),
	"ALL_ELEMENTS_URL" => Array(
		"NAME" => "Путь на все товары",
		"PARENT" => "STYLE",
		"TYPE" => "STRING",
		"DEFAULT" => "/",
	),
	"ALL_ELEMENTS_TITLE" => Array(
		"NAME" => "Заголовок для всех товаров",
		"PARENT" => "STYLE",
		"TYPE" => "STRING",
		"DEFAULT" => "Все товары",
	),
	"TABS_SECTION_ID" => Array(
		"NAME" => "Родительский раздел для табов",
		"PARENT" => "STYLE",
		"TYPE" => "STRING",
		"DEFAULT" => "10682",
	),
);
?>
