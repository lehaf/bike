<?

use Bitrix\Main\SystemException;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
}
?>
<?php
$rsSections = getSections([
    '=IBLOCK_SECTION_ID' => TRANSPORT_SECTION_ID,
    '=ACTIVE' => 'Y',
]);

$parentSectionCode = Bitrix\Iblock\SectionTable::getList([
    'filter' => ['=ID' => TRANSPORT_SECTION_ID], // Условие: ID раздела
    'select' => ['CODE'], // Поля для выборки
])->fetch()['CODE'];

$sectionId = $rsSections[0]['ID'];
$template = $rsSections[0]['CODE'];
$ajax = false;
if ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') $ajax = true;
?>
<?php if (!empty($rsSections)): ?>
    <div class="maxwidth-theme only-on-front filter-block">
        <div class="advert-tabs">
            <?php foreach ($rsSections as $index => $section): ?>
                <a href="" class="advert-tabs__item <?= ($index === 0) ? 'active' : '' ?>"
                   data-id="<?= $section['ID'] ?>" data-type="<?= $section['CODE'] ?>">
                    <?= $section['NAME'] ?>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="filter-tabs-content" data-sect="<?= $parentSectionCode ?>" style="position: relative">
            <?php if ($ajax && $_GET['filter_tab'] === "Y") {
                ob_end_clean();
                $sectionId = $_GET['sect_id'];
                $template = $_GET['sect_code'];
            } ?>
            <?php
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.smart.filter",
                $template,
                array(
                    "IBLOCK_TYPE" => "aspro_max_catalog",
                    "IBLOCK_ID" => CATALOG_IBLOCK_ID,
                    "AJAX_FILTER_FLAG" => (isset($isAjaxFilter) ? $isAjaxFilter : ''),
                    "SECTION_ID" => $sectionId, //id корневого раздела (мотоцикл, скутер и тп)
                    "START_SECTION_ID" => $sectionId, //id конкретного раздела
                    "FILTER_NAME" => 'arFilter',
                    "PRICE_CODE" => ["BASE"],
                    "CACHE_TYPE" => "N",
                    "CACHE_TIME" => "3600000",
                    "CACHE_NOTES" => "",
                    "CACHE_GROUPS" => true,
                    "SAVE_IN_SESSION" => "N",
                    "XML_EXPORT" => "Y",
                    "SECTION_TITLE" => "NAME",
                    "SECTION_DESCRIPTION" => "DESCRIPTION",
                    "SHOW_HINTS" => "Y",
                    'CONVERT_CURRENCY' => true,
                    'CURRENCY_ID' => "BYN",
                    'DISPLAY_ELEMENT_COUNT' => "Y",
                    "INSTANT_RELOAD" => "Y",
                    "VIEW_MODE" => "compact",
                    "SEF_MODE" => "Y",
                    "SEF_RULE" => "/catalog/#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/",
                    "SMART_FILTER_PATH" => "",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "SEF_RULE_FILTER" => "#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/",
                    "SORT_BUTTONS" => [],
                    "SORT_PRICES" => "REGION_PRICE",
                    "AVAILABLE_SORT" => NULL,
                    "SORT" => NULL,
                    "SORT_ORDER" => NULL,
                    "TOP_VERTICAL_FILTER_PANEL" => NULL,
                    "SHOW_SORT" => true,
                    "STORES" => [],
                ),
                false);
            ?>
            <?php if ($ajax && $_GET['filter_tab'] === "Y") {
                die();
            } ?>
        </div>
    </div>
<?php endif; ?>