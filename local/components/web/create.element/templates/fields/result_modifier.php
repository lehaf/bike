<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
//разделение свойств по блокам
if ($_GET['type']) {
    $start_time = microtime(true);
    $arResult['TEST'] = $arResult['SHOW_FIELDS'];
    $sectId = (!isset($arParams['PARENT_SECTION_ID'])) ? ["SECTION_ID" => $arParams['SECTION_ID']] : [
        "PARENT_SECTION_ID" => $arParams['PARENT_SECTION_ID'], "SECTION_ID" => $arParams['SECTION_ID']
    ];

    $resultFields = setBlocksFields($arResult['SHOW_FIELDS'] ?? [], $sectId);
    $arResult['SORT_SHOW_FIELDS'] = sortFields($resultFields['fields']);
    $arResult['LAST_FIELD'] = $resultFields['lastKey'];

    $entityCustomCheck = getHlblock("b_custom_check");
    $resCustomCheck = $entityCustomCheck::getList(["select" => ["UF_FIELD"]])->fetchAll();
    $arResult['CUSTOM_CHECK'] = array_column($resCustomCheck, "UF_FIELD");

    $entityTags = getHlblock("b_tags");
    $tags = $entityTags::getList([
        'filter' => ['@UF_SECTIONS' => $arParams['SECTION_ID']],
    ])->fetch();
    $arResult['TAGS'] = $tags['UF_TAGS'];

    $arResult['CATEGORIES'] = getSections([
        '=IBLOCK_ID' => CATALOG_IBLOCK_ID,
        '=IBLOCK_SECTION_ID' => $arParams['SECTION_ID'],
    ]);
}
function compareBySort($a, $b)
{
    if ($a['SORT'] == $b['SORT']) {
        return 0;
    }
    return ($a['SORT'] < $b['SORT']) ? -1 : 1;
}

?>
