<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

global $USER, $arTheme;
\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);
$APPLICATION->AddChainItem(GetMessage("TITLE"));
$APPLICATION->SetTitle(GetMessage("TITLE"));
$APPLICATION->SetPageProperty("TITLE_CLASS", "center");
use \Bitrix\Main\Config\Option;
?>
<style type="text/css">
	.left-menu-md, body .container.cabinte-page .maxwidth-theme .left-menu-md, .right-menu-md, body .container.cabinte-page .maxwidth-theme .right-menu-md{display:none !important;}
	.content-md{width:100%;}
	.border_block{border:none;}
</style>
<?if(!$USER->IsAuthorized()):?>
	<?
	// default fields, that you can change
	$arShowFields = array("LOGIN", "NAME", "EMAIL", "PERSONAL_PHONE");
	$arRequiredFields = array("NAME");
	$useBackUrl = 'Y';

	if( Option::get('main', 'new_user_phone_required', 'N', SITE_ID) == 'Y' ) {
		$arRequiredFields[] = "PERSONAL_PHONE";
	}
	
	if( Option::get('main', 'new_user_email_required', 'N', SITE_ID) == 'Y' ) {
		$arRequiredFields[] = "EMAIL";
		if( Option::get('main', 'new_user_registration_email_confirmation', 'N', SITE_ID) == 'Y' ){
			$useBackUrl = 'N';
		}
	}

	// get phone auth params
	list($bPhoneAuthSupported, $bPhoneAuthShow, $bPhoneAuthRequired, $bPhoneAuthUse) = Aspro\Max\PhoneAuth::getOptions();

	// add phone field after email field if phone auth supported and need for to register
	if($bPhoneAuthSupported && $bPhoneAuthShow){
		$arShowFields[] = "PHONE_NUMBER";

		// remove phone field
		$phoneKey = array_search("PERSONAL_PHONE", $arShowFields);
		if($phoneKey !== false){
			unset($arShowFields[$phoneKey]);
		}

		// search email field
		$emailKey = array_search("EMAIL", $arShowFields);
		if($emailKey !== false){
			$arShowFields = array_merge(array_slice($arShowFields, 0, $emailKey + 1), array("PERSONAL_PHONE"), array_slice($arShowFields, $emailKey + 1));
		}
		else{
			$arShowFields[] = "PERSONAL_PHONE";
		}

		if($bPhoneAuthRequired){
			$arRequiredFields[] = "PERSONAL_PHONE";
		}
	}
	?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.register",
		"main",
		Array(
			"USER_PROPERTY_NAME" => "",
			"SHOW_FIELDS" => $arShowFields,
			"REQUIRED_FIELDS" => $arRequiredFields,
			"AUTH" => "Y",
			"USE_BACKURL" => $useBackUrl,
			"SUCCESS_PAGE" => "",
			"SET_TITLE" => "N",
			"USER_PROPERTY" => array()
		)
	);?>
<?else:?>
	<?$url = ($arTheme["PERSONAL_PAGE_URL"]["VALUE"] ? $arTheme["PERSONAL_PAGE_URL"]["VALUE"] : $arParams["SEF_FOLDER"]);?>
	<?LocalRedirect($url);?>
<?endif;?>