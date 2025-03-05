<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
\Bitrix\Main\Loader::includeModule("iblock");
$GLOBALS["NEW_ELEMENT"] = ["new_element"];
$iblockExists = (!empty($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0);
$iblockTypes = \Bitrix\Iblock\TypeTable::getList([
    "select" => ["*", "NAME" => "LANG_MESSAGE.NAME"],
    "filter" => ["=LANG_MESSAGE.LANGUAGE_ID" => "ru"]
])->fetchAll();


foreach ($iblockTypes as $type) {
    $arIblockTypes[$type["ID"]] = "[" . $type["ID"] . "] " . $type["NAME"];
}

$arIBlocks = [];
$iblockFilter = [
    "=ACTIVE" => "Y",
];

if (!empty($arCurrentValues["IBLOCK_TYPE"])) {
    $iblockFilter["=IBLOCK_TYPE_ID"] = $arCurrentValues["IBLOCK_TYPE"];
}
if (isset($_REQUEST["site"])) {
    $iblockFilter["LID"] = $_REQUEST["site"];
}

$db_iblock = \Bitrix\Iblock\IblockTable::getList([
    "select" => ["ID", "NAME"],
    "filter" => $iblockFilter,
    "order" => ["SORT" => "ASC"],
])->fetchAll();

foreach ($db_iblock as $res) {
    $arIBlocks[$res["ID"]] = "[" . $res["ID"] . "] " . $res["NAME"];
}


$arProperty = [];
if ($iblockExists) {

    $rsProp = \Bitrix\Iblock\PropertyTable::getList([
        "filter" => ["=IBLOCK_ID" => $arCurrentValues["IBLOCK_ID"], "=ACTIVE" => "Y"],
        "order" => ["SORT" => "ASC", "NAME" => "ASC"]
    ])->fetchAll();

    if (!empty($rsProp)) {
        foreach ($rsProp as $arr) {
            $arProperty[$arr["CODE"]] = "[" . $arr["CODE"] . "] " . $arr["NAME"];
        }
    }
}

//$staticProps = [
//    "ID" => "ID",
//    "IBLOCK_ID" => "Информационный блок",
//    "SECTIONS" => "Разделы",
//    "SORT" => "Сортировка",
//    "NAME" => "Название",
//    "PREVIEW_PICTURE" => "Картинка для анонса",
//    "PREVIEW_TEXT" => "Описание для анонса",
//    "DETAIL_PICTURE" => "Детальная картинка",
//    "DETAIL_TEXT" => "Детальное описание",
//    "CODE" => "Символьный код"
//];

$arComponentParameters = [
    "GROUPS" => [],
    "PARAMETERS" => [
        "IBLOCK_TYPE" => [
            "PARENT" => "BASE",
            "NAME" => "Тип инфоблока",
            "TYPE" => "LIST",
            "VALUES" => $arIblockTypes,
            "DEFAULT" => "catalog",
            "REFRESH" => "Y",
        ],
        "IBLOCK_ID" => [
            "PARENT" => "BASE",
            "NAME" => "ID инфоблока",
            "TYPE" => "LIST",
            "VALUES" => $arIBlocks,
            "DEFAULT" => $arCurrentValues["IBLOCK_ID"],
            "ADDITIONAL_VALUES" => "Y",
            "REFRESH" => "Y",
        ],
        "IS_TEMPLATE_INCLUDE" => [
            "PARENT" => "BASE",
            "NAME" => "Подключать шаблон",
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
            "REFRESH" => "Y",
        ],
        "AUTH_LINK" => [
            "PARENT" => "BASE",
            "NAME" => "Ссылка для аторизации",
            "TYPE" => "STRING",
            "DEFAULT" => "/auth",
        ],
        "SUCCESS_LINK" => [
            "PARENT" => "BASE",
            "NAME" => "Сыылка после добавления",
            "TYPE" => "STRING",
            "DEFAULT" => "/",
        ],
        "PERSONAL_LINK" => [
            "PARENT" => "BASE",
            "NAME" => "Сыылка на личный кабинет",
            "TYPE" => "STRING",
            "DEFAULT" => "/personal",
        ]
    ],
];

//if ($arCurrentValues["IS_TEMPLATE_INCLUDE"] === "Y") {
//    $arComponentParameters["PARAMETERS"]["LIST_PROPERTIES"] = [
//        "PARENT" => "LIST_SETTINGS",
//        "NAME" => "Поля",
//        "TYPE" => "LIST",
//        "MULTIPLE" => "Y",
//        "VALUES" => $staticProps,
//        "SIZE" => 8,
//        "ADDITIONAL_VALUES" => "Y"
//    ];
//
//    $arComponentParameters["PARAMETERS"]["LIST_FIELDS"] = [
//        "PARENT" => "LIST_SETTINGS",
//        "NAME" => "Свойства",
//        "TYPE" => "LIST",
//        "MULTIPLE" => "Y",
//        "VALUES" => $arProperty,
//        "ADDITIONAL_VALUES" => "Y",
//        "SIZE" => 8
//    ];
//}