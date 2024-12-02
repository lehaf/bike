<?php

use web\CreateElement;
use classes\Filter;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
\Bitrix\Main\Loader::IncludeModule("highloadblock");
if (isset($_POST['action'])) {
    $entityUsersSearch = getHlblock("b_user_search");
    switch ($_POST['action']) {
        case 'addSearch' :
            $arFields = [
                'UF_USER_ID' => \Bitrix\Main\Engine\CurrentUser::get()->getId(),
                'UF_TITLE' => $_POST['title'] ?? '',
                'UF_DESCRIPTION' => $_POST['description'] ?? '',
                'UF_SECTION' => (int)$_POST['sectionId'] ?? 0,
                'UF_FILTER_QUERY' => $_POST['searchQuery'] ?? '',
                'UF_NOTIFY_INTERVAL' => (int)$_POST['notifyInterval'] ?? 0,
                'UF_LAST_SENT' => date('d.m.Y H:i:s')
            ];

            $result = $entityUsersSearch::add($arFields);
            if ($result->isSuccess()) {
                echo json_encode(['success' => [
                    'searchId' => $result->getId(),
                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                ]]);
            } else {
                echo json_encode(['error' => $result->getErrorMessages()]);
            }
            die();
        case 'editSearch' :
            if ($_POST['searchId']) {
                $isNotify = $_POST['isNotify'] ?? false;
                $notifyInterval = (!empty($_POST['notifyInterval'])) ? $_POST['notifyInterval'] : 24;
                if ($isNotify === "false") {
                    $notifyInterval = 0;
                }

                $arFields = [
                    'UF_NOTIFY_INTERVAL' => (int)$notifyInterval,
                    'UF_LAST_SENT' => date('d.m.Y H:i:s')
                ];

                $result = $entityUsersSearch::update($_POST['searchId'], $arFields);
                if ($result->isSuccess()) {
                    echo json_encode(['success' => $result->getId()]);
                } else {
                    echo json_encode(['error' => $result->getErrorMessages()]);
                }
            } else {
                echo json_encode(['error' => "Неврный пользовательский поиск"]);
            }
            die();
        case 'deleteSearch' :
            if ($_POST['searchId']) {
                $result = $entityUsersSearch::delete($_POST['searchId']);
                if ($result->isSuccess()) {
                    echo json_encode(['success' => 'Удаление завершено']);
                } else {
                    echo json_encode(['error' => $result->getErrorMessages()]);
                }
            } else {
                echo json_encode(['error' => "Неврный пользовательский поиск"]);
            }
            die();
        case 'existSearch' :
            $arFilter = [
                "=UF_FILTER_QUERY" => $_POST['url'],
                "=UF_USER_ID" => \Bitrix\Main\Engine\CurrentUser::get()->getId(),
                "=UF_SECTION" => $_POST['sectionId']
            ];
            $arSelect = [
                'ID',
                'UF_TITLE',
                'UF_DESCRIPTION',
                'UF_FILTER_QUERY',
                'UF_NOTIFY_INTERVAL',
            ];

            $result = $entityUsersSearch::getList([
                'select' => $arSelect,
                'filter' => $arFilter,
            ])->fetch();

            if($result) {
                echo json_encode(['success' => [
                    'id' => $result['ID'],
                    'title' => $result['UF_TITLE'],
                    'description' => $result['UF_DESCRIPTION'],
                    'url' => $result['UF_FILTER_QUERY'],
                    'interval' => $result['UF_NOTIFY_INTERVAL']
                ]]);
            } else {
                echo json_encode(['error' => 'Совпадений не найдено']);
            }

            die();
    }
}
