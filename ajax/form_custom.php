<?define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");?>
<?define('STOP_STATISTICS', true);
define('PUBLIC_AJAX_MODE', true);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?php
$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();
$form_id = 12;
$type = htmlspecialcharsbx($request['type']) ?? false;

if (\Bitrix\Main\Loader::includeModule("aspro.max")) {
    global $arRegion;
    if (!$arRegion) {
        $arRegion = CMaxRegionality::getCurrentRegion();
    }
    CMax::GetValidFormIDForSite($form_id);
}

if($type === 'call-form') {
    $entity = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();
    $properties = $entity::getList([
        'select' => ['phone_' => 'phone.VALUE', 'contact_person_' => 'contact_person.VALUE'],
        'filter' => ['ID' => $request['elementId']]
    ])->fetchAll();
    $name = "";
    $phones = [];
    if(!empty($properties)) {
        foreach ($properties as $property) {
            $name = $property['contact_person_'];
            $phones[] = $property['phone_'];
        }
    }
    include('call_form_custom.php');
} elseif ($type === 'claim-form') {
    $APPLICATION->IncludeComponent(
        "bitrix:form",
        "popup_custom",
        Array(
            "ELEMENT_ID" => $request['elementId'],
            "AJAX_MODE" => "Y",
            "SEF_MODE" => "N",
            "WEB_FORM_ID" => $form_id,
            "START_PAGE" => "new",
            "SHOW_LIST_PAGE" => "N",
            "SHOW_EDIT_PAGE" => "N",
            "SHOW_VIEW_PAGE" => "N",
            "SUCCESS_URL" => "",
            "SHOW_ANSWER_VALUE" => "N",
            "SHOW_ADDITIONAL" => "N",
            "SHOW_STATUS" => "N",
            "EDIT_ADDITIONAL" => "N",
            "EDIT_STATUS" => "Y",
            "NOT_SHOW_FILTER" => "",
            "NOT_SHOW_TABLE" => "",
            "CHAIN_ITEM_TEXT" => "",
            "CHAIN_ITEM_LINK" => "",
            "IGNORE_CUSTOM_TEMPLATE" => "N",
            "USE_EXTENDED_ERRORS" => "Y",
            "CACHE_GROUPS" => "N",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "3600000",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "N",
            "SHOW_LICENCE" => CMax::GetFrontParametrValue('SHOW_LICENCE'),
            "HIDDEN_CAPTCHA" => CMax::GetFrontParametrValue('HIDDEN_CAPTCHA'),
            "VARIABLE_ALIASES" => Array(
                "action" => "action"
            )
        )
    );
} elseif ($type === 'delete') {
    include('delete_agree.php');
}
?>
