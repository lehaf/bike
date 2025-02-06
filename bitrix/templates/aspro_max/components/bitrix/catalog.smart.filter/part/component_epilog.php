<?php
use classes\Filter;
$FILTER_NAME = (string)$arParams["FILTER_NAME"];

//добавление в фильтр год
if ($_GET[$FILTER_NAME . '_year_MIN'] || $_GET[$FILTER_NAME . '_year_MAX']) {
    $yearsForFilter = array_column($arResult['ITEMS']['year']['VALUES'], "VALUE");
    $yearFrom = $_GET[$FILTER_NAME . '_year_MIN'] ?? min($yearsForFilter);
    $yearTo = $_GET[$FILTER_NAME . '_year_MAX'] ?? max($yearsForFilter);
    $GLOBALS[$FILTER_NAME]['=PROPERTY_' . Filter::getPropertyId($arParams['IBLOCK_ID'], 'year')] = Filter::getYearsFilterId((int)$yearTo, (int)$yearFrom);
}

//добавление фото и видео
if ($_GET[$FILTER_NAME . '_photo']) $GLOBALS[$FILTER_NAME]['!PREVIEW_PICTURE'] = false;

//добавление марки и модели (добавление раздела)
$marksWithModels = [];
$emptyMarks = [];
$emptyMarksModels = [];
$sections = [];
// Перебираем все элементы массива
if ($_GET[$FILTER_NAME . '_mark']) {
    $sections = Filter::getMarksFilterId($arParams["IBLOCK_ID"], $_GET[$FILTER_NAME . '_mark']);
    if (!empty($sections)) $GLOBALS[$FILTER_NAME]['IBLOCK_SECTION_ID'] = $sections;
}

if ($_GET[$FILTER_NAME . '_article']) {
    $GLOBALS[$FILTER_NAME]['=PROPERTY_' . Filter::getPropertyId($arParams['IBLOCK_ID'], 'article_part')] = $_GET[$FILTER_NAME . '_article'];
}

if ($_GET[$FILTER_NAME . '_exp_id']) {
    $GLOBALS[$FILTER_NAME]['=PROPERTY_' . Filter::getPropertyId($arParams['IBLOCK_ID'], 'exp_id')] = $_GET[$FILTER_NAME . '_exp_id'];
}