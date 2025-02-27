<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arTemplateParameters = array(
    'SHOW_MODERATION_PAGE' => array(
        'NAME' => GetMessage('SHOW_MODERATION_PAGE_TITLE'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'Y',
        "PARENT" => "BASE",
    ),
    'PATH_TO_MODERATION' => array(
        'NAME' => GetMessage('PATH_TO_MODERATION_TITLE'),
        'TYPE' => 'STRING',
        'DEFAULT' => '={SITE_DIR."personal/ads/"}',
        "COLS" => 25,
        "PARENT" => "URL_TEMPLATES",
    ),
    'SHOW_ADS_PAGE' => array(
        'NAME' => GetMessage('SHOW_ADS_PAGE_TITLE'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'Y',
        "PARENT" => "BASE",
    ),
    'PATH_TO_ADS' => array(
        'NAME' => GetMessage('PATH_TO_ADS_TITLE'),
        'TYPE' => 'STRING',
        'DEFAULT' => '={SITE_DIR."personal/ads/"}',
        "COLS" => 25,
        "PARENT" => "URL_TEMPLATES",
    ),
	'SHOW_BONUS_PAGE' => array(
		'NAME' => GetMessage('SHOW_BONUS_PAGE_TITLE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
		"PARENT" => "BASE",
	),
	'PATH_TO_BONUS' => array(
		'NAME' => GetMessage('PATH_TO_BONUS_TITLE'),
		'TYPE' => 'STRING',
		'DEFAULT' => '={SITE_DIR."personal/bonus/"}',
		"COLS" => 25,
		"PARENT" => "URL_TEMPLATES",
	),
	
);

?>