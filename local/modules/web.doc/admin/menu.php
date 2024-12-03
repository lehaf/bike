<?php
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

function OnBuildGlobalMenuHandler(&$aGlobalMenu, &$aModuleMenu) : array
{
    $moduleId = "web.doc";

    global $APPLICATION;
//    $APPLICATION->SetAdditionalCSS("/bitrix/css/".$moduleId."/logo.css");

    return [
        "global_menu_" . $moduleId => [
            "menu_id" => $moduleId,
            "text" => 'Документация',
            "title" => 'Документация',
            "sort" => 2000,
            "items_id" => "global_menu_" . $moduleId,
            "help_section" => $moduleId,
            "items" => [
                [
                    "text" => 'Структура файлов',
                    "title" => 'Структура файлов',
                    'icon' => 'sys_menu_icon',
                    "url" => "/bitrix/admin/structure.php?lang=" . LANGUAGE_ID,
                    'items_id' => 'cp',
                ],
                [
                    "text" => 'Страница добавления',
                    "title" => 'Страница добавления',
                    'icon' => 'sys_menu_icon',
                    "url" => "/bitrix/admin/addPage.php?lang=" . LANGUAGE_ID,
                    'items_id' => 'cp',
                ]
            ]
        ]
    ];
}

AddEventHandler('main', 'OnBuildGlobalMenu', 'OnBuildGlobalMenuHandler');

////добавляем пункт меню для нашего модуля
//$menu = array(
//    array(
//        'parent_menu' => 'global_menu_content',//определяем место меню, в данном случае оно находится в главном меню
//        'sort' => 2000,//сортировка, в каком месте будет находится наш пункт
//        'text' => 'Документация',//описание из файла локализации
//        'title' => 'Документация',//название из файла локализации
//        'url' => 'documentation.php'
//    ),
//);
//
//return $menu;