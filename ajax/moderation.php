<?php

use web\CreateElement;
use Bitrix\Main\Application;


require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (isset($_POST['moderation']) && $_POST['moderation'] == 'Y') {
    $element = new \CIBlockElement;

    if ($_POST['action'] === 'success') {
        $element->Update($_POST['elementId'], [
            'ACTIVE' => 'Y',
        ]);
        $element->SetPropertyValuesEx($_POST['elementId'], false, ['MODERATION_ERROR' => '', 'IS_MODERATION' => false]);
        $result = ['status' => 'success', 'message' => 'Объявление опубликовано'];
    } else if ($_POST['action'] === 'fail') {
        if(!empty($_POST['failText'])) {
            $element->SetPropertyValuesEx($_POST['elementId'], false, ['MODERATION_ERROR' => $_POST['failText'], 'IS_MODERATION' => false]);
            $result = ['status' => 'success', 'message' => 'Объявление отправлено на исправление'];
        } else {
            $result = ['status' => 'error'];
        }
    }

    global $CACHE_MANAGER;
    $CACHE_MANAGER->ClearByTag('bitrix:menu');
    echo json_encode($result ?? []);
}