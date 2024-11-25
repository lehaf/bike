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
if ($_GET[$FILTER_NAME . '_video']) {
    $GLOBALS[$FILTER_NAME]['!PROPERTY_' . Filter::getPropertyId($arParams['IBLOCK_ID'], 'VIDEO_YOUTUBE')] = false;
}

//добавление местоположения
$cities = Filter::getCitiesFilterId($_GET, $FILTER_NAME);
if (!empty($cities)) {
    $GLOBALS[$FILTER_NAME]['=PROPERTY_' . Filter::getPropertyId($arParams['IBLOCK_ID'], 'country')] = $cities;
}

//добавление марки и модели (добавление раздела)
if ($_GET[$FILTER_NAME . '_mark']) {
    $sections = Filter::getMarksFilterId($arParams["IBLOCK_ID"], $_GET[$FILTER_NAME . '_mark']);
    if (!empty($sections)) $GLOBALS[$FILTER_NAME]['IBLOCK_SECTION_ID'] = $sections;
}

//конвертация валют
if($_GET[$FILTER_NAME . '_currency'] && ($_GET[$FILTER_NAME . '_P1_MIN'] || $_GET[$FILTER_NAME . '_P1_MAX'])) {
    $baseCurrency = \Bitrix\Currency\CurrencyManager::getBaseCurrency();
    $currencies = \Bitrix\Currency\CurrencyTable::getList([
        'select' => ['CURRENCY'],
        'cache' => [
            'ttl' => 36000000,
            'cache_joins' => true
        ],
    ])->fetchAll();
    $desiredCurrencies = array_column($currencies, 'CURRENCY');

    if ($_GET[$FILTER_NAME . '_currency'] !== $baseCurrency && in_array($_GET[$FILTER_NAME . '_currency'], $desiredCurrencies)) {
        if ($_GET[$FILTER_NAME . '_P1_MIN'] && $_GET[$FILTER_NAME . '_P1_MAX']) {
            $GLOBALS[$FILTER_NAME]['><CATALOG_PRICE_1'] = [
                \CCurrencyRates::ConvertCurrency($_GET[$FILTER_NAME . '_P1_MIN'], $_GET[$FILTER_NAME . '_currency'], $baseCurrency ),
                \CCurrencyRates::ConvertCurrency($_GET[$FILTER_NAME . '_P1_MAX'], $_GET[$FILTER_NAME . '_currency'], $baseCurrency )
            ];
        } elseif ($_GET[$FILTER_NAME . '_P1_MIN']) {
            $GLOBALS[$FILTER_NAME]['>=CATALOG_PRICE_1'] = \CCurrencyRates::ConvertCurrency($_GET[$FILTER_NAME . '_P1_MIN'], $_GET[$FILTER_NAME . '_currency'], $baseCurrency );
        } elseif ($_GET[$FILTER_NAME . '_P1_MAX']) {
            $GLOBALS[$FILTER_NAME]['<=CATALOG_PRICE_1'] = \CCurrencyRates::ConvertCurrency($_GET[$FILTER_NAME . '_P1_MAX'], $_GET[$FILTER_NAME . '_currency'], $baseCurrency );

        }
    }
}

//if($_GET[$FILTER_NAME . '_8115'] && $_GET[$FILTER_NAME . '_8120']) {
//    $GLOBALS[$FILTER_NAME][] = [
//        'LOGIC' => 'OR',
//        ['=PROPERTY_8115' => 554],
//        ['=PROPERTY_8120' => 560],
//    ];
//
//    unset($GLOBALS[$FILTER_NAME]['=PROPERTY_8120'], $GLOBALS[$FILTER_NAME]['=PROPERTY_8115']);
//}


////поиск количества выбранных параметров фильтра
//if ($_REQUEST['ajaxCountParams'] == 'y') {
//    ob_end_clean();
//    echo json_encode(count($GLOBALS[$FILTER_NAME]));
//    die();
//}

//поиск количества элементов, подходящих под фильтр
//if ($_REQUEST['ajaxCount'] == 'y') {
//    ob_end_clean();
//    $arFilter = $this->makeFilter($FILTER_NAME);
//    $arResult["ELEMENT_COUNT"] = CIBlockElement::GetList(array(), $arFilter, array(), false);
//    echo json_encode('$arResult["ELEMENT_COUNT"]');
//    die();
//}

