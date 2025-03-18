<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? $this->setFrameMode(true); ?>
<? use \Bitrix\Main\Localization\Loc; ?>


<?php
//if ($USER->IsAuthorized()) {
//    pr('hello');
////    define("ERROR_404", "Y");
////    \CHTTP::SetStatus("404 Not Found");
////    include $_SERVER["DOCUMENT_ROOT"] . "/404.php";
//    die();
//}
//?>

<?php $section ?>
    <div class="basket_props_block" id="bx_basket_div_<?= $arResult["ID"]; ?>" style="display: none;">
        <? if (!empty($arResult['PRODUCT_PROPERTIES_FILL'])) {
            foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo) {
                ?>
                <input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"
                       value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
                <? if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))
                    unset($arResult['PRODUCT_PROPERTIES'][$propID]);
            }
        }
        $templateData["USE_OFFERS_SELECT"] = false;
        $arResult["EMPTY_PROPS_JS"] = "Y";
        $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
        if (!$emptyProductProperties) {
            $arResult["EMPTY_PROPS_JS"] = "N"; ?>
            <div class="wrapper">
                <table>
                    <? foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo) {
                        ?>
                        <tr>
                            <td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>
                            <td>
                                <? if ('L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE'] && 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']) {
                                    foreach ($propInfo['VALUES'] as $valueID => $value) {
                                        ?>
                                        <label>
                                            <input type="radio"
                                                   name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"
                                                   value="<? echo $valueID; ?>" <? echo($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?>
                                        </label>
                                        <?
                                    }
                                } else {
                                    ?>
                                    <select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]">
                                        <? foreach ($propInfo['VALUES'] as $valueID => $value) {
                                            ?>
                                            <option value="<? echo $valueID; ?>" <? echo($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option>
                                        <? } ?>
                                    </select>
                                <? } ?>
                            </td>
                        </tr>
                    <? } ?>
                </table>
            </div>
        <? } ?>
    </div>

<? if ($arResult['SKU_CONFIG']): ?>
<div class="js-sku-config"
     data-params='<?= \Aspro\Max\Product\SkuTools::getSignedParams($arResult['SKU_CONFIG']) ?>'></div><? endif; ?>

<?
$currencyList = '';
if (!empty($arResult['CURRENCIES'])) {
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$bComplect = $arResult["PROPERTIES"]["PRODUCT_SET"]["VALUE"] === "Y";
$addParams = array();
if ($bComplect) {
    $addParams = array("DISPLAY_WISH_BUTTONS" => "N");
}

$templateData = array(
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList,
    'STORES' => array(
        "USE_STORE_PHONE" => $arParams["USE_STORE_PHONE"],
        "SCHEDULE" => $arParams["SCHEDULE"],
        "USE_MIN_AMOUNT" => $arParams["USE_MIN_AMOUNT"],
        "MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
        "ELEMENT_ID" => $arResult["ID"],
        "STORE_PATH" => $arParams["STORE_PATH"],
        "MAIN_TITLE" => $arParams["MAIN_TITLE"],
        "MAX_AMOUNT" => $arParams["MAX_AMOUNT"],
        "USE_ONLY_MAX_AMOUNT" => $arParams["USE_ONLY_MAX_AMOUNT"],
        "SHOW_EMPTY_STORE" => $arParams['SHOW_EMPTY_STORE'],
        "SHOW_GENERAL_STORE_INFORMATION" => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
        "USE_ONLY_MAX_AMOUNT" => $arParams["USE_ONLY_MAX_AMOUNT"],
        "USER_FIELDS" => $arParams['USER_FIELDS'],
        "FIELDS" => $arParams['FIELDS'],
        "STORES_FILTER_ORDER" => $arParams['STORES_FILTER_ORDER'],
        "STORES_FILTER" => $arParams['STORES_FILTER'],
        "STORES" => $arParams['STORES'] = array_diff((array)$arParams['STORES'], [], ['']),
        "SET_ITEMS" => $arResult["SET_ITEMS"],
        'OFFERS_ID' => is_array($arResult['OFFERS']) ? array_column($arResult['OFFERS'], 'ID') : [],
    ),
    'OFFERS_INFO' => array(
        'OFFERS' => is_array($arResult['OFFERS']) ? array_column($arResult['OFFERS'], 'OFFER_GROUP', 'ID') : [],
        'OFFER_GROUP' => $arResult['OFFER_GROUP'],
        'OFFERS_IBLOCK' => $arResult['OFFERS_IBLOCK'],
    ),
    'LINK_SALES' => $arResult['STOCK'],
    'LINK_SERVICES' => $arResult['SERVICES'],
    'LINK_NEWS' => $arResult['NEWS'],
    'LINK_TIZERS' => $arParams['SECTION_TIZERS'],
    'LINK_REVIEWS' => $arResult['LINK_REVIEWS'],
    'LINK_BLOG' => $arResult['BLOG'],
    'LINK_STAFF' => $arResult['LINK_STAFF'],
    'LINK_VACANCY' => $arResult['LINK_VACANCY'],
    'REVIEWS_COUNT' => $arParams['REVIEWS_VIEW'] == 'EXTENDED'
        ? $arResult["PROPERTIES"]['EXTENDED_REVIEWS_COUNT']['VALUE']
        : $arResult['PROPERTIES']['FORUM_MESSAGE_CNT']['VALUE'],
    'CATALOG_SETS' => array(
        'SET_ITEMS_QUANTITY' => $arResult["SET_ITEMS_QUANTITY"],
        'SET_ITEMS' => $arResult["SET_ITEMS"]
    ),
    'VIDEO' => $arResult['VIDEO'],
    'ASSOCIATED' => $arResult['ASSOCIATED'],
    'EXPANDABLES' => $arResult['EXPANDABLES'],
    'REVIEWS_COUNT' => $arResult['PROPERTIES']['BLOG_COMMENTS_CNT']['VALUE'],
    'PRODUCT_SET_OPTIONS' => array(
        'PRODUCT_SET' => $bComplect,
        'PRODUCT_SET_FILTER' => $arResult["PROPERTIES"]["PRODUCT_SET_FILTER"]["~VALUE"],
        'PRODUCT_SET_GROUP' => $arResult["PROPERTIES"]["PRODUCT_SET_GROUP"]["VALUE"] === "Y",
    ),
    'XML_ID' => $arResult['XML_ID'],
);
unset($currencyList, $templateLibrary);

if ($arResult['OUT_OF_PRODUCTION']) {
    $templateData['OUT_OF_PRODUCTION'] = [
        'SHOW_ANALOG' => $arResult['PRODUCT_ANALOG']
    ];
}

if ($arResult["PROPERTIES"]["YM_ELEMENT_ID"] && $arResult["PROPERTIES"]["YM_ELEMENT_ID"]["VALUE"])
    $templateData["YM_ELEMENT_ID"] = $arResult["PROPERTIES"]["YM_ELEMENT_ID"]["VALUE"];

$arSkuTemplate = array();
if (!empty($arResult['SKU_PROPS']))
    $arSkuTemplate = CMax::GetSKUPropsArray($arResult['SKU_PROPS'], $arResult["SKU_IBLOCK_ID"], "list", $arParams["OFFER_HIDE_NAME_PROPS"], "N", $arResult, $arParams['OFFER_SHOW_PREVIEW_PICTURE_PROPS']);
//$arSkuTemplate=CMax::GetSKUPropsArray($arResult['SKU_PROPS'], $arResult["SKU_IBLOCK_ID"], "list", $arParams["OFFER_HIDE_NAME_PROPS"]);

$strMainID = $this->GetEditAreaId($arResult['ID']);
$strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

$arResult["strMainID"] = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = CMax::GetItemsIDs($arResult, "Y");

$showCustomOffer = (($arResult['OFFERS'] && $arParams["TYPE_SKU"] != "N") ? true : false);

if ($showCustomOffer && isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])) {
    $arCurrentSKU = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']];
    $templateData['TOTAL_COUNT'] = $totalCount = CMax::GetTotalCount($arCurrentSKU, $arParams);
    $templateData['QUANTITY_DATA'] = $arQuantityData = CMax::GetQuantityArray([
        'totalCount' => $totalCount,
        'arItemIDs' => ['ID' => $arCurrentSKU["ID"]],
        'useStoreClick' => ($arParams["USE_STORE"] == "Y" && $arResult["STORES_COUNT"] && $arResult['CATALOG_TYPE'] != CCatalogProduct::TYPE_SET ? "Y" : "N"),
        'dataAmount' => $arParams['CATALOG_DETAIL_SHOW_AMOUNT_STORES'] !== 'Y' ? [] : [
            'ID' => $arCurrentSKU['ID'],
            'STORES' => $arParams['STORES'],
            'IMMEDIATELY' => 'Y',
        ],
    ]);
} else {
    $templateData['TOTAL_COUNT'] = $totalCount = CMax::GetTotalCount($arResult, $arParams);
    $templateData['QUANTITY_DATA'] = $arQuantityData = CMax::GetQuantityArray([
        'totalCount' => $totalCount,
        'arItemIDs' => $arItemIDs["ALL_ITEM_IDS"],
        'useStoreClick' => ($arParams["USE_STORE"] == "Y" && $arResult["STORES_COUNT"] && $arResult['CATALOG_TYPE'] != CCatalogProduct::TYPE_SET && (!$arResult["OFFERS"] || ($arResult["OFFERS"] && $arParams["TYPE_SKU"] != "N")) ? "Y" : "N"),
        'dataAmount' => $arParams['CATALOG_DETAIL_SHOW_AMOUNT_STORES'] !== 'Y' ? [] : [
            'ID' => $arResult['ID'],
            'STORES' => $arParams['STORES'],
            'IMMEDIATELY' => 'Y',
        ],
    ]);
}
$templateData['ID_OFFER_GROUP'] = $arItemIDs['ALL_ITEM_IDS']['OFFER_GROUP'];
$templateData['HIDE_ADDITIONAL_GALLERY'] = $arResult['OFFERS'] && 'TYPE_1' === $arParams['TYPE_SKU'] && !$arResult['ADDITIONAL_GALLERY'][$arCurrentSKU['ID']];

$arParams["BASKET_ITEMS"] = ($arParams["BASKET_ITEMS"] ? $arParams["BASKET_ITEMS"] : array());
$useStores = $arParams["USE_STORE"] == "Y" && $arResult["STORES_COUNT"] && $arQuantityData["RIGHTS"]["SHOW_QUANTITY"] && $arResult['CATALOG_TYPE'] != CCatalogProduct::TYPE_SET;
$templateData['STORES']['USE_STORES'] = $useStores;

if ($showCustomOffer)
    $templateData['JS_OBJ'] = $strObName;

$strMeasure = '';
$arAddToBasketData = array();

$templateData['STR_ID'] = $strObName;
$item_id = $arResult["ID"];

$currentSKUID = $currentSKUIBlock = '';

$bUseSkuProps = ($arResult["OFFERS"] && !empty($arResult['OFFERS_PROP']));
$popupVideo = $arResult['PROPERTIES']['POPUP_VIDEO']['VALUE'];
$bOfferDetailText = false;
if ($showCustomOffer && isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])) {
    //$arCurrentSKU = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']];
    $item_id = $arCurrentSKU["ID"];
    $bOfferDetailText = $arParams['SHOW_SKU_DESCRIPTION'] === 'Y' && $arCurrentSKU["DETAIL_TEXT"];
    if (strlen($arParams["SKU_DETAIL_ID"]))
        $arResult['DETAIL_PAGE_URL'] .= '?' . $arParams["SKU_DETAIL_ID"] . '=' . $arCurrentSKU['ID'];
    $templateData["OFFERS_INFO"]["CURRENT_OFFER"] = $arCurrentSKU["ID"];
    $templateData["OFFERS_INFO"]["CURRENT_OFFER_TITLE"] = $arCurrentSKU['IPROPERTY_VALUES']["ELEMENT_PAGE_TITLE"] ?? $arCurrentSKU["NAME"];
    $templateData["OFFERS_INFO"]["CURRENT_OFFER_WINDOW_TITLE"] = $arCurrentSKU['IPROPERTY_VALUES']["ELEMENT_META_TITLE"] ?? $templateData["OFFERS_INFO"]["CURRENT_OFFER_TITLE"];
    if ($arCurrentSKU["DISPLAY_PROPERTIES"]["ARTICLE"]["VALUE"]) {
        $arCurrentSKU['DISPLAY_PROPERTIES']['ARTICLE']["VALUE"] = (is_array($arCurrentSKU['DISPLAY_PROPERTIES']['ARTICLE']["VALUE"]) ? reset($arCurrentSKU['DISPLAY_PROPERTIES']['ARTICLE']["VALUE"]) : $arCurrentSKU['DISPLAY_PROPERTIES']['ARTICLE']["VALUE"]);
        $article = $arCurrentSKU['DISPLAY_PROPERTIES']['ARTICLE'];
        unset($arCurrentSKU['DISPLAY_PROPERTIES']['ARTICLE']);
    } elseif ($arParams['SHOW_ARTICLE_SKU'] === 'Y') {
        $article = $arResult["CML2_ARTICLE"];
    }
    if ($arCurrentSKU['PROPERTIES']['POPUP_VIDEO']['VALUE']) {
        $popupVideo = $arCurrentSKU['PROPERTIES']['POPUP_VIDEO']['VALUE'];
    }
    $arResult['OFFER_PROP'] = $arCurrentSKU['DISPLAY_PROPERTIES'];
    CIBlockPriceTools::clearProperties($arResult['OFFER_PROP'], $arParams['OFFER_TREE_PROPS']);
    $arResult['OFFER_PROP'] = CMax::PrepareItemProps($arResult['OFFER_PROP']);
} else {
    $article = $arResult["CML2_ARTICLE"];
}

if ($arResult["OFFERS"]) {
    $strMeasure = $arResult["MIN_PRICE"]["CATALOG_MEASURE_NAME"];
    $templateData["STORES"]["OFFERS"] = "Y";

    if ($showCustomOffer) {
        $currentSKUIBlock = $arResult["OFFERS"][$arResult["OFFERS_SELECTED"]]["IBLOCK_ID"];
        $currentSKUID = $arResult["OFFERS"][$arResult["OFFERS_SELECTED"]]["ID"];
        $arResult["OFFERS"][$arResult["OFFERS_SELECTED"]]["IS_OFFER"] = "Y";

        /* need for add basket props */
        $arResult["OFFERS"][$arResult["OFFERS_SELECTED"]]["IBLOCK_ID"] = $arResult['IBLOCK_ID'];
        /* */
        // for current offer buy block
        $arAddToBasketData = CMax::GetAddToBasketArray($arResult["OFFERS"][$arResult["OFFERS_SELECTED"]], $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, $arItemIDs["ALL_ITEM_IDS"], 'btn-lg', $arParams);
        /* restore IBLOCK_ID */
        $arResult["OFFERS"][$arResult["OFFERS_SELECTED"]]["IBLOCK_ID"] = $currentSKUIBlock;
        /* */
        $strMeasure = $arCurrentSKU["~CATALOG_MEASURE_NAME"];
    }
} else {
    if (($arParams["SHOW_MEASURE"] == "Y") && ($arResult["CATALOG_MEASURE"])) {
        $arMeasure = CCatalogMeasure::getList(array(), array("ID" => $arResult["CATALOG_MEASURE"]), false, false, array())->GetNext();
        $strMeasure = $arMeasure["SYMBOL_RUS"];
    }
    $arAddToBasketData = CMax::GetAddToBasketArray($arResult, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], true, $arItemIDs["ALL_ITEM_IDS"], 'btn-lg', $arParams);
}
$arOfferProps = implode(';', $arParams['OFFERS_CART_PROPERTIES']);

// save item viewed
$arFirstPhoto = reset($arResult['MORE_PHOTO']);
$viwedItem = $arCurrentSKU ?? $arResult;
$arItemPrices = $viwedItem['MIN_PRICE'];
if (isset($viwedItem['PRICE_MATRIX']) && $viwedItem['PRICE_MATRIX']) {
    $rangSelected = $viwedItem['ITEM_QUANTITY_RANGE_SELECTED'];
    $priceSelected = $viwedItem['ITEM_PRICE_SELECTED'];
    if (isset($viwedItem['FIX_PRICE_MATRIX']) && $viwedItem['FIX_PRICE_MATRIX']) {
        $rangSelected = $viwedItem['FIX_PRICE_MATRIX']['RANGE_SELECT'];
        $priceSelected = $viwedItem['FIX_PRICE_MATRIX']['PRICE_SELECT'];
    }
    $arItemPrices = $viwedItem['ITEM_PRICES'][$priceSelected];
    $arItemPrices['VALUE'] = $arItemPrices['BASE_PRICE'];
    $arItemPrices['PRINT_VALUE'] = \Aspro\Functions\CAsproMaxItem::getCurrentPrice('BASE_PRICE', $arItemPrices);
    $arItemPrices['DISCOUNT_VALUE'] = $arItemPrices['PRICE'];
    $arItemPrices['PRINT_DISCOUNT_VALUE'] = \Aspro\Functions\CAsproMaxItem::getCurrentPrice('PRICE', $arItemPrices);
}
$arViewedData = array(
    'PRODUCT_ID' => $arResult['ID'],
    'IBLOCK_ID' => $viwedItem['IBLOCK_ID'],
    'NAME' => $viwedItem['NAME'],
    'DETAIL_PAGE_URL' => $viwedItem['DETAIL_PAGE_URL'],
    'PICTURE_ID' => $viwedItem['PREVIEW_PICTURE'] ? $viwedItem['PREVIEW_PICTURE']['ID'] : ($arFirstPhoto ? $arFirstPhoto['ID'] : false),
    'CATALOG_MEASURE_NAME' => $viwedItem['CATALOG_MEASURE_NAME'],
    'MIN_PRICE' => $arItemPrices,
    'CAN_BUY' => $viwedItem['CAN_BUY'] ? 'Y' : 'N',
    'IS_OFFER' => $arCurrentSKU ? 'Y' : 'N',
    'WITH_OFFERS' => $arResult['OFFERS'] && !isset($arCurrentSKU) ? 'Y' : 'N',
);

$actualItem = $arResult["OFFERS"] ? (isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]) ? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']] : reset($arResult['OFFERS'])) : $arResult;

if ($arResult["OFFERS"] && $arParams["TYPE_SKU"] == "N")
    unset($templateData['STORES']);
$offerPropCount = $arParams["VISIBLE_PROP_WITH_OFFER"] === "Y" && is_array($arResult['OFFER_PROP']) ? count($arResult['OFFER_PROP']) : 0;
$iCountProps = count($arResult['DISPLAY_PROPERTIES']) + $offerPropCount;
?>

<? if ($arResult["OFFERS"] && $arParams["TYPE_SKU"] == "N"): ?>
    <? $templateData['OFFERS_INFO']['OFFERS_MORE'] = true; ?>
    <?
    $showSkUName = ((in_array('NAME', $arParams['OFFERS_FIELD_CODE'])));
    $showSkUImages = false;
    if (((in_array('PREVIEW_PICTURE', $arParams['OFFERS_FIELD_CODE']) || in_array('DETAIL_PICTURE', $arParams['OFFERS_FIELD_CODE'])))) {
        foreach ($arResult["OFFERS"] as $key => $arSKU) {
            if ($arSKU['PREVIEW_PICTURE'] || $arSKU['DETAIL_PICTURE']) {
                $showSkUImages = true;
                break;
            }
        }
    } ?>

    <? //list offers TYPE_2?>
    <? if ($arResult["OFFERS"] && $arParams["TYPE_SKU"] !== "TYPE_1"): ?>
        <? $this->SetViewTarget('PRODUCT_OFFERS_INFO'); ?>
        <div class="list-offers ajax_load">
            <div class="bx_sku_props" style="display:none;">
                <? $arSkuKeysProp = '';
                $propSKU = $arParams["OFFERS_CART_PROPERTIES"];
                if ($propSKU) {
                    $arSkuKeysProp = base64_encode(serialize(array_keys($propSKU)));
                } ?>
                <input type="hidden" value="<?= $arSkuKeysProp; ?>"/>
            </div>
            <div class="table-view flexbox flexbox--row">
                <? foreach ($arResult["OFFERS"] as $key => $arSKU): ?>
                    <?
                    if ($arResult["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"])
                        $sMeasure = $arResult["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"];
                    else
                        $sMeasure = $arSKU['CATALOG_MEASURE_NAME'] ?? GetMessage("MEASURE_DEFAULT");

                    $skutotalCount = $arSKU['TOTAL_COUNT'];
                    $arskuQuantityData = CMax::GetQuantityArray([
                        'totalCount' => $skutotalCount,
                        'dataAmount' => $arParams['CATALOG_DETAIL_SHOW_AMOUNT_STORES'] !== 'Y' ? [] : [
                            'ID' => $arSKU['ID'],
                            'STORES' => $arParams['STORES'],
                            'IMMEDIATELY' => 'Y',
                        ],
                    ]);

                    $arSKU["IBLOCK_ID"] = $arResult["IBLOCK_ID"];
                    $arSKU["IS_OFFER"] = "Y";
                    $arskuAddToBasketData = $arSKU['ADD_TO_BASKET_DATA'];
                    $arskuAddToBasketData["HTML"] = str_replace('data-item', 'data-props="' . $arOfferProps . '" data-item', $arskuAddToBasketData["HTML"]);
                    ?>
                    <div class="table-view__item item bordered box-shadow main_item_wrapper <?= ($useStores ? "table-view__item--has-stores" : ""); ?> js-notice-block">
                        <?
                        $arFirstSkuPicture = array();
                        if (!empty($arSKU['PREVIEW_PICTURE'])) {
                            $arFirstSkuPicture = $arSKU['PREVIEW_PICTURE'];
                        } elseif (!empty($arSKU['DETAIL_PICTURE'])) {
                            $arFirstSkuPicture = $arSKU['DETAIL_PICTURE'];
                        } elseif (!empty($arResult['PREVIEW_PICTURE'])) {
                            $arFirstSkuPicture = $arResult['PREVIEW_PICTURE'];
                        } elseif (!empty($arResult['DETAIL_PICTURE'])) {
                            $arFirstSkuPicture = $arResult['DETAIL_PICTURE'];
                        }
                        if (isset($arFirstSkuPicture["ID"])) {
                            $arFirstSkuPicture = \CFile::ResizeImageGet($arFirstSkuPicture["ID"], array("width" => 60, "height" => 60), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                        }
                        ?>
                        <meta itemprop="image" content='<?= $arFirstSkuPicture['src'] ?>'>
                        <div class="table-view__item-wrapper item_info catalog-adaptive flexbox flexbox--row">
                            <? if ($showSkUImages): ?>
                                <? //image-block?>
                                <div class="item-foto">
                                    <div class="item-foto__picture">
                                        <? \Aspro\Functions\CAsproMaxItem::showImg($arParams, $arSKU, false, false); ?>
                                    </div>
                                    <div class="adaptive">
                                        <? \Aspro\Functions\CAsproMaxItem::showDelayCompareBtn(array_merge($arParams, $addParams), $arSKU, $arskuAddToBasketData, $skutotalCount, '', 'block', true, false, '_small'); ?>
                                    </div>
                                </div>
                            <? endif; ?>

                            <? //text-block?>
                            <div class="item-info">
                                <div class="item-title font_sm"><?= $arSKU['NAME'] ?></div>
                                <div class="quantity_block_wrapper">
                                    <? if ($arQuantityData["RIGHTS"]["SHOW_QUANTITY"] && !$templateData['OUT_OF_PRODUCTION']): ?>
                                        <?= $arskuQuantityData["HTML"]; ?>
                                    <? endif; ?>
                                    <? if ($arSKU['PROPERTIES']['ARTICLE']['VALUE']): ?>
                                        <div class="font_sxs muted article">
                                            <span class="name"><?= Loc::getMessage('ARTICLE_COMPACT'); ?></span><span
                                                    class="value"><?= $arSKU['PROPERTIES']['ARTICLE']['VALUE']; ?></span>
                                        </div>
                                    <? endif; ?>
                                </div>
                                <? if ($arResult["SKU_PROPERTIES"]): ?>
                                    <div class="properties list">
                                        <div class="properties__container properties props_list">
                                            <? foreach ($arResult["SKU_PROPERTIES"] as $key => $arProp) { ?>
                                                <? if (!$arProp["IS_EMPTY"] && $key != 'ARTICLE'): ?>
                                                    <? $bHasValue = (
                                                        $arResult["TMP_OFFERS_PROP"][$arProp["CODE"]]
                                                        || $arSKU["PROPERTIES"][$arProp["CODE"]]["VALUE"]
                                                    ); ?>
                                                    <? if (!$bHasValue) continue; ?>
                                                    <div class="properties__item properties__item--compact ">
                                                        <div class="properties__title muted properties__item--inline char_name font_sxs">
                                                            <? if ($arProp["HINT"] && $arParams["SHOW_HINTS"] == "Y"): ?>
                                                                <div class="hint"><span class="icon"><i>?</i></span>
                                                                <div class="tooltip"><?= $arProp["HINT"] ?></div>
                                                                </div><? endif; ?>
                                                            <span class="props_item"><?= $arProp["NAME"] ?>:</span>
                                                        </div>
                                                        <div class="properties__value darken properties__item--inline char_value font_xs">
                                                            <? if ($arResult["TMP_OFFERS_PROP"][$arProp["CODE"]]) {
                                                                echo $arResult["TMP_OFFERS_PROP"][$arProp["CODE"]]["VALUES"][$arSKU["TREE"]["PROP_" . $arProp["ID"]]]["NAME"]; ?>
                                                            <? } else {
                                                                if (is_array($arSKU["PROPERTIES"][$arProp["CODE"]]["VALUE"])) {
                                                                    echo implode("/", $arSKU["PROPERTIES"][$arProp["CODE"]]["VALUE"]);
                                                                } else {
                                                                    if ($arSKU["PROPERTIES"][$arProp["CODE"]]["USER_TYPE"] == "directory" && isset($arSKU["PROPERTIES"][$arProp["CODE"]]["USER_TYPE_SETTINGS"]["TABLE_NAME"])) {
                                                                        $rsData = \Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter' => array('=TABLE_NAME' => $arSKU["PROPERTIES"][$arProp["CODE"]]["USER_TYPE_SETTINGS"]["TABLE_NAME"])));
                                                                        if ($arData = $rsData->fetch()) {
                                                                            $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arData);
                                                                            $entityDataClass = $entity->getDataClass();
                                                                            $arFilter = array(
                                                                                'limit' => 1,
                                                                                'filter' => array(
                                                                                    '=UF_XML_ID' => $arSKU["PROPERTIES"][$arProp["CODE"]]["VALUE"]
                                                                                )
                                                                            );
                                                                            $arValue = $entityDataClass::getList($arFilter)->fetch();
                                                                            if (isset($arValue["UF_NAME"]) && $arValue["UF_NAME"]) {
                                                                                echo $arValue["UF_NAME"];
                                                                            } else {
                                                                                echo $arSKU["PROPERTIES"][$arProp["CODE"]]["VALUE"];
                                                                            }
                                                                        }
                                                                    } else {
                                                                        echo $arSKU["PROPERTIES"][$arProp["CODE"]]["VALUE"];
                                                                    }
                                                                }
                                                            } ?>
                                                        </div>
                                                    </div>
                                                <? endif; ?>
                                            <? } ?>
                                        </div>
                                    </div>
                                <? endif; ?>
                            </div>

                            <div class="item-actions flexbox flexbox--row">
                                <? //prices-block?>
                                <div class="item-price">
                                    <div class="cost prices clearfix">
                                        <? if (isset($arSKU['PRICE_MATRIX']) && $arSKU['PRICE_MATRIX']): // USE_PRICE_COUNT?>
                                            <? if (\CMax::GetFrontParametrValue('SHOW_POPUP_PRICE') == 'Y' || $arSKU['ITEM_PRICE_MODE'] == 'Q' || (\CMax::GetFrontParametrValue('SHOW_POPUP_PRICE') != 'Y' && $arSKU['ITEM_PRICE_MODE'] != 'Q' && count($arSKU['PRICE_MATRIX']['COLS']) <= 1)): ?>
                                                <?= CMax::showPriceRangeTop($arSKU, $arParams, Loc::getMessage("CATALOG_ECONOMY")); ?>
                                            <? endif; ?>
                                            <? if (count($arSKU['PRICE_MATRIX']['ROWS']) > 1 || count($arSKU['PRICE_MATRIX']['COLS']) > 1): ?>
                                                <?= CMax::showPriceMatrix($arSKU, $arParams, $sMeasure, $arskuAddToBasketData); ?>
                                            <? endif; ?>
                                        <? elseif ($arSKU["PRICES"]): ?>
                                            <? \Aspro\Functions\CAsproMaxItem::showItemPrices($arParams, $arSKU["PRICES"], $sMeasure, $min_price_id, ($arParams["SHOW_DISCOUNT_PERCENT_NUMBER"] == "Y" ? "N" : "Y")); ?>
                                        <? endif; ?>
                                    </div>

                                    <? \Aspro\Functions\CAsproMax::showBonusBlockDetail($arSKU); ?>

                                    <div class="basket_props_block" id="bx_basket_div_<?= $arSKU["ID"]; ?>"
                                         style="display: none;">
                                        <? if (!empty($arSKU['PRODUCT_PROPERTIES_FILL'])) {
                                            foreach ($arSKU['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo) {
                                                ?>
                                                <input type="hidden"
                                                       name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"
                                                       value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
                                                <? if (isset($arSKU['PRODUCT_PROPERTIES'][$propID]))
                                                    unset($arSKU['PRODUCT_PROPERTIES'][$propID]);
                                            }
                                        }
                                        $arSKU["EMPTY_PROPS_JS"] = "Y";
                                        $emptyProductProperties = empty($arSKU['PRODUCT_PROPERTIES']);
                                        if (!$emptyProductProperties) {
                                            $arSKU["EMPTY_PROPS_JS"] = "N"; ?>
                                            <div class="wrapper">
                                                <table>
                                                    <? foreach ($arSKU['PRODUCT_PROPERTIES'] as $propID => $propInfo) {
                                                        ?>
                                                        <tr>
                                                            <td><? echo $arSKU['PROPERTIES'][$propID]['NAME']; ?></td>
                                                            <td>
                                                                <? if ('L' == $arSKU['PROPERTIES'][$propID]['PROPERTY_TYPE'] && 'C' == $arSKU['PROPERTIES'][$propID]['LIST_TYPE']) {
                                                                    foreach ($propInfo['VALUES'] as $valueID => $value) {
                                                                        ?>
                                                                        <label>
                                                                            <input type="radio"
                                                                                   name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"
                                                                                   value="<? echo $valueID; ?>" <? echo($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?>
                                                                        </label>
                                                                        <?
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
                                                                        foreach ($propInfo['VALUES'] as $valueID => $value) {
                                                                            ?>
                                                                            <option value="<? echo $valueID; ?>" <? echo($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option>
                                                                        <? } ?>
                                                                    </select>
                                                                <? } ?>
                                                            </td>
                                                        </tr>
                                                    <? } ?>
                                                </table>
                                            </div>
                                            <?
                                        } ?>
                                    </div>
                                </div>

                                <? //buttons-block?>
                                <div class="item-buttons item_<?= $arSKU["ID"] ?>">
                                    <div class="counter_wrapp list clearfix n-mb small-block">
                                        <? if ($arskuAddToBasketData["OPTIONS"]["USE_PRODUCT_QUANTITY_DETAIL"] && !count((array)$arSKU["OFFERS"]) && $arskuAddToBasketData["ACTION"] == "ADD" && $arskuAddToBasketData["CAN_BUY"]): ?>
                                            <?= \Aspro\Functions\CAsproMax::showItemCounter($arskuAddToBasketData, $arSKU["ID"], $arSKUIDs, $arParams, '', '', true, true); ?>
                                        <? endif; ?>
                                        <div class="button_block <?= (in_array($arSKU["ID"], $arParams["BASKET_ITEMS"]) || $arskuAddToBasketData["ACTION"] === "OUT_OF_PRODUCTION" || $arskuAddToBasketData["ACTION"] == "ORDER" || ($arskuAddToBasketData["ACTION"] == 'MORE' || !$arskuAddToBasketData["CAN_BUY"]) || !$arskuAddToBasketData["OPTIONS"]["USE_PRODUCT_QUANTITY_DETAIL"] ? "wide" : ""); ?>">
                                            <!--noindex-->
                                            <?= $arskuAddToBasketData["HTML"] ?>
                                            <!--/noindex-->
                                        </div>
                                    </div>
                                    <?= \Aspro\Functions\CAsproMax::showItemOCB($arskuAddToBasketData, $arSKU, $arParams); ?>

                                    <? //delivery calculate?>
                                    <? if (
                                        $arskuAddToBasketData["ACTION"] == "ADD" &&
                                        $arskuAddToBasketData["CAN_BUY"]
                                    ): ?>
                                        <?= \Aspro\Functions\CAsproMax::showCalculateDeliveryBlock($arSKU['ID'], $arParams, $arParams['TYPE_SKU'] !== 'TYPE_1'); ?>
                                    <? endif; ?>

                                    <?
                                    if (isset($arSKU['PRICE_MATRIX']) && $arSKU['PRICE_MATRIX']) // USE_PRICE_COUNT
                                    {
                                        ?>
                                        <? if ($arSKU['ITEM_PRICE_MODE'] == 'Q' && count($arSKU['PRICE_MATRIX']['ROWS']) > 1): ?>
                                        <? $arOnlyItemJSParams = array(
                                            "ITEM_PRICES" => $arSKU["ITEM_PRICES"],
                                            "ITEM_PRICE_MODE" => $arSKU["ITEM_PRICE_MODE"],
                                            "ITEM_QUANTITY_RANGES" => $arSKU["ITEM_QUANTITY_RANGES"],
                                            "MIN_QUANTITY_BUY" => $arskuAddToBasketData["MIN_QUANTITY_BUY"],
                                            "SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
                                            "ID" => $this->GetEditAreaId($arSKU["ID"]),
                                        ) ?>
                                        <script type="text/javascript">
                                            var ob<? echo $this->GetEditAreaId($arSKU["ID"]); ?>el = new JCCatalogSectionOnlyElement(<? echo CUtil::PhpToJSObject($arOnlyItemJSParams, false, true); ?>);
                                        </script>
                                    <? endif; ?>
                                    <? } ?>
                                    <!--noindex-->
                                    <? /*if(isset($arSKU['PRICE_MATRIX']) && $arSKU['PRICE_MATRIX'] && count($arSKU['PRICE_MATRIX']['ROWS']) > 1) // USE_PRICE_COUNT
										{?>
											<?$arOnlyItemJSParams = array(
												"ITEM_PRICES" => $arSKU["ITEM_PRICES"],
												"ITEM_PRICE_MODE" => $arSKU["ITEM_PRICE_MODE"],
												"ITEM_QUANTITY_RANGES" => $arSKU["ITEM_QUANTITY_RANGES"],
												"MIN_QUANTITY_BUY" => $arskuAddToBasketData["MIN_QUANTITY_BUY"],
												"SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
												"ID" => $this->GetEditAreaId($arSKU["ID"]),
											)?>
											<script type="text/javascript">
												var ob<? echo $this->GetEditAreaId($arSKU["ID"]); ?>el = new JCCatalogOnlyElement(<? echo CUtil::PhpToJSObject($arOnlyItemJSParams, false, true); ?>);
											</script>
										<?}*/ ?>
                                    <!--/noindex-->
                                </div>
                            </div>

                            <? //icons-block?>
                            <? if ($arResult['ICONS_SIZE']): ?>
                                <div class="item-icons s_<?= $arResult['ICONS_SIZE'] ?>">
                                    <? \Aspro\Functions\CAsproMaxItem::showDelayCompareBtn(array_merge($arParams, $addParams), $arSKU, $arskuAddToBasketData, $skutotalCount, '', 'list static icons', false, false, '_small', $currentSKUID, $currentSKUIBlock); ?>
                                </div>
                            <? endif; ?>

                            <? //stores icon?>
                            <? if ($useStores): ?>
                                <div class="stores-icons">
                                    <div class="like_icons list static icons">
                                        <div>
                                            <span class="btn btn_xs btn-transparent"><?= CMax::showIconSvg("cat_icons", SITE_TEMPLATE_PATH . "/images/svg/catalog/arrow_sku.svg", "", "", true, false); ?></span>
                                        </div>
                                    </div>
                                </div>
                            <? endif; ?>
                        </div>
                        <div class="offer-stores" style="display: none;">
                            <? $APPLICATION->IncludeComponent("bitrix:catalog.store.amount", "main", array(
                                "PER_PAGE" => "10",
                                "USE_STORE_PHONE" => $arParams["USE_STORE_PHONE"],
                                "SCHEDULE" => $arParams["SCHEDULE"],
                                "USE_MIN_AMOUNT" => $arParams["USE_MIN_AMOUNT"],
                                "MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
                                "ELEMENT_ID" => $arSKU["ID"],
                                "STORE_PATH" => $arParams["STORE_PATH"],
                                "MAIN_TITLE" => $arParams["MAIN_TITLE"],
                                "MAX_AMOUNT" => $arParams["MAX_AMOUNT"],
                                "SHOW_EMPTY_STORE" => $arParams['SHOW_EMPTY_STORE'],
                                "SHOW_GENERAL_STORE_INFORMATION" => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
                                "USE_ONLY_MAX_AMOUNT" => $arParams["USE_ONLY_MAX_AMOUNT"],
                                "USER_FIELDS" => $arParams['USER_FIELDS'],
                                "FIELDS" => $arParams['FIELDS'],
                                "STORES" => $arParams['STORES'],
                                "CACHE_TYPE" => "A",
                                "SET_ITEMS" => $arResult["SET_ITEMS"],
                            ),
                                $component
                            ); ?>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
        <? $this->EndViewTarget(); ?>
    <? endif; ?>
<? endif; ?>

<? //top info?>

    <div class="product-info-wrapper">
        <div class="product-info <?= (!$showCustomOffer ? "noffer" : ""); ?> product-info--type2"
             id="<?= $arItemIDs["strMainID"]; ?>">
            <script type="text/javascript">setViewedProduct(<?=$arResult['ID']?>, <?=CUtil::PhpToJSObject($arViewedData, false)?>);</script>

            <? //meta?>
            <meta itemprop="name"
                  content="<?= $name = strip_tags(!empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arResult['NAME']) ?>"/>
            <link itemprop="url" href="<?= $arResult['DETAIL_PAGE_URL'] ?>"/>
            <meta itemprop="category" content="<?= $arResult['CATEGORY_PATH'] ?>"/>
            <meta itemprop="description"
                  content="<?= (strlen(strip_tags($arResult['PREVIEW_TEXT'])) ? strip_tags($arResult['PREVIEW_TEXT']) : (strlen(strip_tags($arResult['DETAIL_TEXT'])) ? strip_tags($arResult['DETAIL_TEXT']) : $name)) ?>"/>
            <meta itemprop="sku" content="<?= $arResult['ID']; ?>"/>

            <div class="flexbox flexbox--row">

                <? //main gallery?>
                <? \Aspro\Functions\CAsproMax::showMainGallery([
                    'POPUPVIDEO' => $popupVideo,
                    'IS_CURRENT_SKU' => !!$arCurrentSKU,
                    'IS_CUSTOM_OFFERS' => $showCustomOffer,
                ], $arResult, $arParams); ?>

                <div class="product-main">
                    <div class="product-info-headnote clearfix product-info-headnote--bordered">
                        <div class="flexbox flexbox--row align-items-center justify-content-between flex-wrap">
                            <? //delay|compare?>
                            <div class="col-auto">
                                <div class="product-info-headnote__toolbar">
                                    <? \Aspro\Functions\CAsproMaxItem::showDelayCompareBtn(array_merge($arParams, $addParams), $arResult, $arAddToBasketData, $totalCount, $bUseSkuProps, 'list static sm', false, false, '_small', $currentSKUID, $currentSKUIBlock); ?>
                                </div>
                            </div>
                            <? //article,rating,brand?>
                            <div class="col-auto">
                                <div class="_info-inner">
                                    <div class="_info-product">
                                        <?php if (!empty($arResult['ACTIVE_FROM_DATE'])): ?>
                                            <div class="_info-product_el">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                          d="M8 0C3.58453 0 0 3.58453 0 8C0 12.4155 3.58453 16 8 16C12.4155 16 16 12.4155 16 8C16 3.58453 12.4155 0 8 0ZM8 1.06667C11.8267 1.06667 14.9333 4.17333 14.9333 8C14.9333 11.8267 11.8267 14.9333 8 14.9333C4.17333 14.9333 1.06667 11.8267 1.06667 8C1.06667 4.17333 4.17333 1.06667 8 1.06667ZM7.46667 3.73333V8C7.46667 8.14133 7.52267 8.27733 7.62293 8.37707L9.75627 10.5104C9.96427 10.7184 10.3024 10.7184 10.5104 10.5104C10.7184 10.3024 10.7184 9.96427 10.5104 9.75627L8.53333 7.7792V3.73333C8.53333 3.43893 8.2944 3.2 8 3.2C7.7056 3.2 7.46667 3.43893 7.46667 3.73333Z"
                                                          fill="#999999"/>
                                                </svg>
                                                <div class="_info-product_el__text">
                                                    <?= $arResult['ACTIVE_FROM_DATE']; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="_info-product_el">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M16 8.0002C16 7.85425 15.915 7.74074 15.847 7.61101C14.0786 4.8056 11.2221 3.2002 8.04251 3.2002C4.96493 3.2002 1.98937 4.95155 0.136026 7.69209C0.0680127 7.78938 0 7.88668 0 8.0002C0 8.11371 0.0510096 8.21101 0.136026 8.3083C1.98937 11.0651 4.98193 12.8002 8.04251 12.8002C10.9671 12.8002 13.9596 11.1299 15.83 8.4056C15.932 8.27587 16 8.14614 16 8.0002ZM8.04251 11.8759C5.30499 11.8759 2.6695 10.384 0.969182 8.0002C2.6695 5.53533 5.39001 4.04344 8.04251 4.04344C10.865 4.04344 13.3475 5.47047 15.0308 8.0002C13.3305 10.384 10.695 11.8759 8.04251 11.8759ZM8.04251 5.22722C6.46121 5.22722 5.13496 6.49209 5.13496 8.0002C5.13496 9.6056 6.46121 10.7732 8.04251 10.7732C9.62381 10.7732 10.9501 9.58938 10.9501 8.0002C10.9501 6.49209 9.62381 5.22722 8.04251 5.22722ZM8.04251 9.94614C6.88629 9.94614 6.01913 9.02182 6.01913 8.01641C6.01913 7.01101 6.90329 6.08668 8.04251 6.08668C9.09671 6.08668 10.0659 6.92993 10.0659 8.01641C10.0659 9.1029 9.19872 9.94614 8.04251 9.94614Z"
                                                      fill="#666666"/>
                                            </svg>
                                            <div class="_info-product_el__text">
                                                <?= $arResult['PROPERTIES']['SHOW_ALL']['VALUE'] ?> <span>(<?= $arResult['PROPERTIES']['SHOW_TODAY']['VALUE']?> сегодня)</span>
                                            </div>
                                        </div>
                                        <div class="_info-product_el">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.19095 5.64706H9.98552L10.367 4.12116C10.43 3.86902 10.6855 3.71572 10.9377 3.77876C11.1898 3.84179 11.3431 4.09729 11.2801 4.34943L10.9557 5.64706H11.7647C12.0246 5.64706 12.2353 5.85775 12.2353 6.11765C12.2353 6.37755 12.0246 6.58824 11.7647 6.58824H10.7204L10.0145 9.41177H11.7647C12.0246 9.41177 12.2353 9.62245 12.2353 9.88235C12.2353 10.1423 12.0246 10.3529 11.7647 10.3529H9.77919L9.39771 11.8788C9.33468 12.131 9.07918 12.2843 8.82704 12.2212C8.5749 12.1582 8.4216 11.9027 8.48464 11.6506L8.80905 10.3529H6.01448L5.63301 11.8788C5.56997 12.131 5.31447 12.2843 5.06234 12.2212C4.8102 12.1582 4.6569 11.9027 4.71993 11.6506L5.04434 10.3529H4.23529C3.9754 10.3529 3.76471 10.1423 3.76471 9.88235C3.76471 9.62245 3.9754 9.41177 4.23529 9.41177H5.27963L5.98552 6.58824H4.23529C3.9754 6.58824 3.76471 6.37755 3.76471 6.11765C3.76471 5.85775 3.9754 5.64706 4.23529 5.64706H6.22081L6.60229 4.12116C6.66532 3.86902 6.92082 3.71572 7.17296 3.77876C7.4251 3.84179 7.5784 4.09729 7.51536 4.34943L7.19095 5.64706ZM6.95566 6.58824L6.24978 9.41177H9.04434L9.75022 6.58824H6.95566ZM4.23529 16C1.89621 16 0 14.1038 0 11.7647V4.23529C0 1.89621 1.89621 0 4.23529 0H11.7647C14.1038 0 16 1.89621 16 4.23529V11.7647C16 14.1038 14.1038 16 11.7647 16H4.23529ZM4.23529 15.0588H11.7647C13.584 15.0588 15.0588 13.584 15.0588 11.7647V4.23529C15.0588 2.416 13.584 0.941176 11.7647 0.941176H4.23529C2.416 0.941176 0.941176 2.416 0.941176 4.23529V11.7647C0.941176 13.584 2.416 15.0588 4.23529 15.0588Z"
                                                      fill="#666666"/>
                                            </svg>
                                            <div class="_info-product_el__text">
                                                Артикул: <?= $arResult['PROPERTIES']['exp_id']['VALUE'] ?>
                                            </div>
                                        </div>
                                    </div>
                                    <? if ($arResult["BRAND_ITEM"]) { ?>
                                        <div class="product-info-headnote__brand">
                                            <div class="brand" itemprop="brand" itemtype="https://schema.org/Brand"
                                                 itemscope>
                                                <meta itemprop="name" content="<?= $arResult["BRAND_ITEM"]["NAME"] ?>"/>
                                                <? if (!$arResult["BRAND_ITEM"]["IMAGE"]): ?>
                                                    <a href="<?= $arResult["BRAND_ITEM"]["DETAIL_PAGE_URL"] ?>"
                                                       class="brand__link dark_link"><?= $arResult["BRAND_ITEM"]["NAME"] ?></a>
                                                <? else: ?>
                                                    <a class="brand__picture"
                                                       href="<?= $arResult["BRAND_ITEM"]["DETAIL_PAGE_URL"] ?>">
                                                        <img src="<?= $arResult["BRAND_ITEM"]["IMAGE"]["src"] ?>"
                                                             alt="<?= $arResult["BRAND_ITEM"]["IMAGE"]["ALT"] ?>"
                                                             title="<?= $arResult["BRAND_ITEM"]["IMAGE"]["TITLE"] ?>"/>
                                                    </a>
                                                <? endif; ?>
                                            </div>
                                        </div>
                                    <? } ?>
                                </div>
                            </div>

                        </div>
                        <div class="_info-product _info-product--bottom">
                            <?php if (!empty($arResult['CITY'])): ?>
                                <div class="_location-product">
                                    <svg width="12" height="14" viewBox="0 0 12 14" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.00217 0C2.69349 0 0 2.5937 0 5.7694C0 7.59837 0.980934 9.52699 2.92624 11.4889C3.80708 12.3779 4.77653 13.1745 5.81928 13.8664C5.92482 13.956 6.07953 13.956 6.18506 13.8664C7.22781 13.1745 8.19725 12.3779 9.0781 11.4889C11.0234 9.52693 12.0043 7.59831 12.0043 5.7694C12.0043 2.59373 9.31087 0 6.00217 0ZM6.00217 13.2014C5.0544 12.5364 0.66506 9.3441 0.66506 5.7694C0.66506 2.95949 3.05931 0.66506 6.00217 0.66506C8.94509 0.665176 11.3393 2.95955 11.3393 5.7694C11.3393 9.32747 6.94988 12.5364 6.00217 13.2014Z"
                                              fill="#666666"/>
                                        <path d="M6.00147 3.1084C5.40176 3.1084 4.82663 3.34673 4.40259 3.77076C3.97847 4.19476 3.74023 4.77001 3.74023 5.36963C3.74023 5.96934 3.97845 6.54447 4.40259 6.9686C4.8266 7.3926 5.40173 7.63084 6.00147 7.63084C6.60121 7.63084 7.17631 7.39262 7.60034 6.9686C8.02447 6.54447 8.2627 5.96934 8.2627 5.36963C8.2627 4.77004 8.02449 4.19479 7.60034 3.77076C7.17634 3.34675 6.60121 3.1084 6.00147 3.1084ZM6.00147 6.96575C5.57815 6.96575 5.1721 6.79758 4.87277 6.49825C4.57343 6.19891 4.40527 5.79287 4.40527 5.36954C4.40527 4.94622 4.57343 4.5403 4.87277 4.24096C5.1721 3.94162 5.57815 3.77346 6.00147 3.77346C6.42479 3.77346 6.83083 3.94163 7.13017 4.24096C7.42951 4.5403 7.59767 4.94622 7.59767 5.36954C7.59767 5.79287 7.4295 6.19891 7.13017 6.49825C6.83083 6.79758 6.42479 6.96575 6.00147 6.96575Z"
                                              fill="#666666"/>
                                    </svg>

                                    <?= $arResult['CITY']; ?>
                                </div>
                            <?php endif; ?>
                            <? //stock?>
                            <?php if (!empty($arResult['PROPERTIES']['status']['VALUE_XML_ID'])): ?>
                                <div class="item-stock">
                                    <span class="icon <?= $arResult['PROPERTIES']['status']['VALUE_XML_ID'] ?>"></span>
                                    <span class="value font_sxs"><?= $arResult['PROPERTIES']['status']['VALUE'] ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>


                    <? //buttons,props,sales?>
                    <? $bShowPropsBlock = ($arResult["OFFERS"] && $showCustomOffer) || ($arResult["SIZE_PATH"]) || (($arResult['DISPLAY_PROPERTIES'] || $arResult['OFFER_PROP']) && $arParams['VISIBLE_PROP_COUNT'] > 0); ?>
                    <div class="main-block-card flexbox flexbox--row flex-wrap align-items-normal <?= !$bShowPropsBlock ? 'justify-center' : '' ?>">
                        <? if ($bShowPropsBlock): ?>
                            <div class="product-chars">

                                <? //sales?>
                                <div class="js-sales"></div>

                                <? //offers tree props?>
                                <? if ($arResult["OFFERS"] && $showCustomOffer): ?>
                                    <template class="offers-template-json">
                                        <?= \Aspro\Max\Product\SkuTools::getOfferTreeJson($arResult["OFFERS"]) ?>
                                    </template>
                                <? $templateData["USE_OFFERS_SELECT"] = true; ?>
                                    <script>typeof useOfferSelect === 'function' && useOfferSelect()</script>
                                <? $frame = $this->createFrame()->begin(''); ?>
                                    <div class="buy_block offer-props-wrapper">
                                        <div class="sku_props inner_content js_offers__<?= $arResult['ID']; ?>_detail load-offer-js">
                                            <? if (!empty($arResult['OFFERS_PROP'])) { ?>
                                                <div class="bx_catalog_item_scu wrapper_sku sku_in_detail"
                                                     id="<? echo $arItemIDs["ALL_ITEM_IDS"]['PROP_DIV']; ?>"
                                                     data-site_id="<?= SITE_ID; ?>" data-id="<?= $arResult["ID"]; ?>"
                                                     data-offer_id="<?= $arResult["OFFERS"][$arResult["OFFERS_SELECTED"]]["ID"]; ?>"
                                                     data-propertyid="<?= $arResult["OFFERS"][$arResult["OFFERS_SELECTED"]]["PROPERTIES"]["CML2_LINK"]["ID"]; ?>"
                                                     data-offer_iblockid="<?= $arResult["OFFERS"][$arResult["OFFERS_SELECTED"]]["IBLOCK_ID"]; ?>"
                                                     data-iblockid="<?= $arResult["IBLOCK_ID"]; ?>">
                                                    <? foreach ($arSkuTemplate as $code => $strTemplate) {
                                                        if (!isset($arResult['OFFERS_PROP'][$code]))
                                                            continue;
                                                        echo '<div class="item_wrapper">', str_replace('#ITEM#_prop_', $arItemIDs["ALL_ITEM_IDS"]['PROP'], $strTemplate), '</div>';
                                                    } ?>
                                                </div>
                                            <? } ?>
                                        </div>
                                    </div>
                                    <? $frame->end(); ?>
                                <? endif; ?>
                                <? if ($arResult["SIZE_PATH"]): ?>
                                    <div class="table_sizes muted777 font_xs">
									<span>
										<?= CMax::showIconSvg("cheaper", SITE_TEMPLATE_PATH . '/images/svg/catalog/sizestable.svg', '', '', true, false); ?>
										<span class="animate-load dotted" data-event="jqm"
                                              data-param-form_id="TABLES_SIZE"
                                              data-param-url="<?= $arResult["SIZE_PATH"]; ?>"
                                              data-name="TABLES_SIZE"><?= GetMessage("TABLES_SIZE"); ?></span>
									</span>
                                    </div>
                                <? endif; ?>

                                <? //props?>
                                <? $bShowMoreLink = ($iCountProps > $arParams['VISIBLE_PROP_COUNT']); ?>
                                <? if (($arResult['DISPLAY_PROPERTIES'] || $arResult['OFFER_PROP']) && $arParams['VISIBLE_PROP_COUNT'] > 0): ?>
                                    <div class="char-side">
                                        <div class="char-side__title font_sm darken"><?= ($arParams["T_CHARACTERISTICS"] ? $arParams["T_CHARACTERISTICS"] : Loc::getMessage("T_CHARACTERISTICS")); ?></div>
                                        <div class="properties list">
                                            <div class="properties__container properties <?= !$bShowMoreLink ? 'js-offers-prop' : '' ?>">
                                                <? foreach ($arResult['DISPLAY_PROPERTIES'] as $arProp): ?>
                                                    <div class="properties__item properties__item--compact font_xs js-prop-replace">
                                                        <div class="properties__title muted properties__item--inline js-prop-title">
                                                            <?= $arProp['NAME'] ?>
                                                            <? if ($arProp["HINT"] && $arParams["SHOW_HINTS"] == "Y"): ?>
                                                                <div class="hint">
                                                                    <span class="icon colored_theme_hover_bg"><i>?</i></span>
                                                                    <div class="tooltip"><?= $arProp["HINT"] ?></div>
                                                                </div>
                                                            <? endif; ?>
                                                        </div>
                                                        <div class="properties__hr muted properties__item--inline">
                                                            &mdash;
                                                        </div>
                                                        <div class="properties__value darken properties__item--inline js-prop-value">
                                                            <? if (is_array($arProp["DISPLAY_VALUE"]) && count($arProp["DISPLAY_VALUE"]) > 1): ?>
                                                                <?= implode(', ', $arProp["DISPLAY_VALUE"]); ?>
                                                            <? else: ?>
                                                                <?= $arProp["DISPLAY_VALUE"]; ?>
                                                            <? endif; ?>
                                                        </div>
                                                    </div>

                                                <? endforeach; ?>
                                                <? foreach ($arResult['OFFER_PROP'] as $arProp): ?>
                                                    <? if ($j < $arParams['VISIBLE_PROP_COUNT'] || (!$bShowMoreLink && $arParams["VISIBLE_PROP_WITH_OFFER"] !== "Y")): ?>
                                                        <div class="properties__item properties__item--compact font_xs js-prop">
                                                            <div class="properties__title muted properties__item--inline js-prop-title">
                                                                <?= $arProp['NAME'] ?>
                                                                <? if ($arProp["HINT"] && $arParams["SHOW_HINTS"] == "Y"): ?>
                                                                    <div class="hint">
                                                                        <span class="icon colored_theme_hover_bg"><i>?</i></span>
                                                                        <div class="tooltip"><?= $arProp["HINT"] ?></div>
                                                                    </div>
                                                                <? endif; ?>
                                                            </div>
                                                            <div class="properties__hr muted properties__item--inline">
                                                                &mdash;
                                                            </div>
                                                            <div class="properties__value darken properties__item--inline js-prop-value">
                                                                <? if (is_array($arProp["DISPLAY_VALUE"]) && count($arProp["DISPLAY_VALUE"]) > 1): ?>
                                                                    <?= implode(', ', $arProp["DISPLAY_VALUE"]); ?>
                                                                <? else: ?>
                                                                    <?= $arProp["DISPLAY_VALUE"]; ?>
                                                                <? endif; ?>
                                                            </div>
                                                        </div>
                                                    <? endif; ?>
                                                    <? $j++; ?>
                                                <? endforeach; ?>
                                            </div>

                                        </div>
                                    </div>
                                <? endif; ?>
                            </div>
                        <? endif; ?>

                        <? //discount,buy|order|subscribe?>
                        <div class="product-action">
                            <? if ($arResult['PRODUCT_ANALOG']): ?>
                                <div class="js-item-analog js-animate-appearance"></div>
                            <? endif; ?>
                            <div class="info_item">
                                <div class="middle-info-wrapper main_item_wrapper">
                                    <div class="shadowed-block">
                                        <? if ($bComplect): ?>
                                            <div class="complect_prices_block">
                                                <div class="cost prices detail prices_block">
                                                    <div class="prices-wrapper">
                                                        <div class="price font-bold font_mxs">
                                                            <div class="price_value_block values_wrapper">
                                                                <span class="price_value complect_price_value">0</span>
                                                                <span class="price_currency">
																<? //$arResult['MIN_PRICE']['CURRENCY']?>
                                                                <?= str_replace("999", "", \CCurrencyLang::CurrencyFormat("999", $arResult["CURRENCIES"][0]["CURRENCY"])) ?>
															</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="buy_complect_wrap hidden">
                                                    <span data-currency="RUB"
                                                          class="button_buy_complect opt_action btn btn-default btn-sm no-action"
                                                          data-action="buy"
                                                          data-iblock_id="<?= $arParams["IBLOCK_ID"] ?>"><span><?= \Bitrix\Main\Config\Option::get("aspro.max", "EXPRESSION_ADDTOBASKET_BUTTON_DEFAULT", GetMessage("EXPRESSION_ADDTOBASKET_BUTTON_DEFAULT")); ?></span></span>
                                                </div>
                                                <span class="btn btn-default btn-lg type_block has-ripple choise btn-wide"
                                                      data-block=".js-scroll-complect"><span><?= Loc::getMessage("COMPLECT_BUTTON") ?></span></span>
                                            </div>
                                        <? else: ?>
                                            <? $frame = $this->createFrame()->begin(''); ?>

                                            <? //composite fix for offers?>
                                            <? /*
										<?if($arResult["OFFERS"] && $showCustomOffer):?>
											<?$arItemJSParams=CMax::GetSKUJSParams($arResult, $arParams, $arResult, "Y");?>

											<script type="text/javascript">
												var <? echo $arItemIDs["strObName"]; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arItemJSParams, false, true); ?>);
											</script>
										<?endif;?>
										<?*/ ?>
                                            <? //dicount timer?>
                                            <? if ($arParams["SHOW_DISCOUNT_TIME"] == "Y") { ?>
                                                <? $arUserGroups = $USER->GetUserGroupArray(); ?>
                                                <? $arDiscount = [] ?>
                                                <? if ($arParams['SHOW_DISCOUNT_TIME_EACH_SKU'] != 'Y' || ($arParams['SHOW_DISCOUNT_TIME_EACH_SKU'] == 'Y' && (!$arResult['OFFERS'] || ($arResult['OFFERS'] && $arParams['TYPE_SKU'] != 'TYPE_1')))): ?>
                                                    <? \Aspro\Functions\CAsproMax::showDiscountCounter($totalCount, $arDiscount, $arQuantityData, $arResult, $strMeasure, 'compact red', $arResult["ID"]); ?>
                                                <? else: ?>
                                                    <? \Aspro\Functions\CAsproMax::showDiscountCounter($totalCount, $arDiscount, $arQuantityData, $arResult, $strMeasure, 'compact red', $item_id); ?>
                                                <? endif; ?>
                                            <? } ?>
                                            <div class="prices_block _prices_block">
                                                <? //prices?>
                                                <?php if(!empty($arResult['PRICES_CUST'])):?>
                                                <div class="cost prices detail">
                                                    <? if ($arResult["OFFERS"]): ?>
                                                        <?= \Aspro\Functions\CAsproMaxItem::showItemPricesDefault($arParams); ?>
                                                        <div class="js_price_wrapper">
                                                            <? if ($arCurrentSKU): ?>
                                                                <? $arParams['HIDE_PRICE'] = false ?>
                                                                <?
                                                                $arCurrentSKU['CATALOG_MEASURE_NAME'] = $strMeasure;
                                                                if (isset($arCurrentSKU['PRICE_MATRIX']) && $arCurrentSKU['PRICE_MATRIX'] && $arCurrentSKU['ITEM_PRICE_MODE'] == 'Q'): // USE_PRICE_COUNT
                                                                    ?>
                                                                    <? if (!$arParams['USE_PRICE_COUNT']): ?>
                                                                    <? $arParams['HIDE_PRICE'] = true ?>
                                                                    <? \Aspro\Functions\CAsproMaxItem::showItemPrices($arParams, $arCurrentSKU["PRICES"], $strMeasure, $min_price_id, ($arParams["SHOW_DISCOUNT_PERCENT_NUMBER"] == "Y" ? "N" : "Y")); ?>
                                                                <? endif; ?>
                                                                    <? if ($arCurrentSKU['ITEM_PRICE_MODE'] == 'Q' && count($arCurrentSKU['PRICE_MATRIX']['ROWS']) > 1): ?>
                                                                    <?= CMax::showPriceRangeTop($arCurrentSKU, $arParams, Loc::getMessage("CATALOG_ECONOMY")); ?>
                                                                <? endif; ?>
                                                                    <? if ($arParams['USE_PRICE_COUNT']): ?>
                                                                    <?= CMax::showPriceMatrix($arCurrentSKU, $arParams, $strMeasure, $arAddToBasketData); ?>
                                                                <? endif; ?>
                                                                <? else: ?>
                                                                    <!--                                                                    тут выводятся цены у торговых предложений-->
                                                                    <? \Aspro\Functions\CAsproMaxItem::showItemPrices($arParams, $arCurrentSKU["PRICES"], $strMeasure, $min_price_id, ($arParams["SHOW_DISCOUNT_PERCENT_NUMBER"] == "Y" ? "N" : "Y")); ?>
                                                                <? endif; ?>
                                                            <? else: ?>
                                                                <? \Aspro\Functions\CAsproMaxSku::showItemPrices($arParams, $arResult, $item_id, $min_price_id, $arItemIDs, ($arParams["SHOW_DISCOUNT_PERCENT_NUMBER"] == "Y" ? "N" : "Y")); ?>
                                                            <? endif; ?>
                                                        </div>
                                                    <? else: ?>
                                                        <? if (isset($arResult['PRICE_MATRIX']) && $arResult['PRICE_MATRIX']): // USE_PRICE_COUNT?>
                                                            <? if (\CMax::GetFrontParametrValue('SHOW_POPUP_PRICE') == 'Y' || $arResult['ITEM_PRICE_MODE'] == 'Q' || (\CMax::GetFrontParametrValue('SHOW_POPUP_PRICE') != 'Y' && $arResult['ITEM_PRICE_MODE'] != 'Q' && count($arResult['PRICE_MATRIX']['COLS']) <= 1)): ?>
                                                                <?= CMax::showPriceRangeTop($arResult, $arParams, Loc::getMessage("CATALOG_ECONOMY")); ?>
                                                            <? endif; ?>
                                                            <? if (count($arResult['PRICE_MATRIX']['ROWS']) > 1 || count($arResult['PRICE_MATRIX']['COLS']) > 1): ?>
                                                                <?= CMax::showPriceMatrix($arResult, $arParams, $strMeasure, $arAddToBasketData); ?>
                                                            <? endif; ?>
                                                        <? elseif (isset($arResult["PRICES"]) && !empty($arResult['PRICES_CUST'])): ?>
                                                            <div class="price_matrix_wrapper">
                                                                <div class="price font-bold font_mxs price--center">
                                                                    <?php if (!empty($arResult['PROPERTIES']['contract_price']['VALUE'])): ?>
                                                                        <?= Loc::getMessage("CONTRACT_PRICE") ?>
                                                                    <?php else: ?>
                                                                        <?=(!empty($arResult['PROPERTIES']['price_from']['VALUE'])) ? 'от' : ''?>
                                                                        <?= $arResult['PRICES_CUST']['BASE'] ?>
                                                                        <?=(!empty($arResult['PROPERTIES']['arenda_unit']['VALUE'])) ? ' / ' .  mb_strtolower($arResult['PROPERTIES']['arenda_unit']['VALUE']) : ''?>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <?php if (!empty($arResult['PRICES_CUST']['CONVERT']) && empty($arResult['PROPERTIES']['contract_price']['VALUE'])): ?>
                                                                <div class="price-currency">
                                                                    <?php foreach ($arResult['PRICES_CUST']['CONVERT'] as $price): ?>
                                                                        <div class="price-currency__i">
                                                                            ≈ <?= $price ?></div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        <? endif; ?>
                                                    <? endif; ?>
                                                </div>
                                                <?php else:?>
                                                <div class="cost prices detail">
                                                    <div class="price_matrix_wrapper">
                                                        <div class="price font-bold font_mxs price--center">
                                                            <?=GetMessage('NOT_PRICE')?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endif;?>

                                                <? \Aspro\Functions\CAsproMax::showBonusBlockDetail($arCurrentSKU ?: $arResult); ?>
                                                <? //for product wo POPUP_PRICE in fixed header?>
                                                <? if ($arParams['SHOW_POPUP_PRICE'] !== "Y" && !$arResult["OFFERS"]): ?>
                                                    <script>
                                                        <?if(isset($arResult['PRICE_MATRIX']) && $arResult['PRICE_MATRIX']): // USE_PRICE_COUNT?>
                                                        <?$priceHtml = CMax::showPriceMatrix($arResult, $arParams, $strMeasure, $arAddToBasketData);?>
                                                        <?$countPricesMatrix = count($arResult['PRICE_MATRIX']['MATRIX'])?>
                                                        <?$countPricesRows = count($arResult['PRICE_MATRIX']['ROWS'])?>
                                                        <?$countPrices = ($countPricesMatrix > $countPricesRows ? $countPricesMatrix : $countPricesRows)?>
                                                        BX.message({
                                                            ASPRO_ITEM_PRICE_MATRIX: <?=CUtil::PhpToJSObject($priceHtml, false, true);?>
                                                        })
                                                        <?elseif($arResult["PRICES"]):?>
                                                        <?$priceHtml = \Aspro\Functions\CAsproMaxItem::showItemPrices($arParams, $arResult["PRICES"], $strMeasure, $min_price_id, ($arParams["SHOW_DISCOUNT_PERCENT_NUMBER"] == "Y" ? "N" : "Y"), false, true);?>
                                                        <?$countPrices = count($arResult['PRICES'])?>
                                                        BX.message({
                                                            ASPRO_ITEM_PRICE: <?=CUtil::PhpToJSObject($priceHtml, false, true);?>
                                                        })
                                                        <?endif;?>
                                                        BX.message({
                                                            ASPRO_ITEM_POPUP_PRICE: 'Y',
                                                            ASPRO_ITEM_PRICES: <?=$countPrices;?>
                                                        })
                                                    </script>
                                                <? endif; ?>

                                                <? //for offer product wo POPUP_PRICE in fixed header?>
                                                <? if ($arParams['SHOW_POPUP_PRICE'] !== "Y" && $arCurrentSKU): ?>
                                                    <script>
                                                        <?if(isset($arCurrentSKU['PRICE_MATRIX']) && $arCurrentSKU['PRICE_MATRIX']): // USE_PRICE_COUNT?>
                                                        <?$priceHtml = CMax::showPriceMatrix($arCurrentSKU, $arParams, $strMeasure, $arAddToBasketData);?>
                                                        <?$countPricesMatrix = count($arCurrentSKU['PRICE_MATRIX']['MATRIX'])?>
                                                        <?$countPricesRows = count($arCurrentSKU['PRICE_MATRIX']['ROWS'])?>
                                                        <?$countPrices = ($countPricesMatrix > $countPricesRows ? $countPricesMatrix : $countPricesRows)?>
                                                        BX.message({
                                                            ASPRO_ITEM_PRICE_MATRIX: <?=CUtil::PhpToJSObject($priceHtml, false, true);?>
                                                        })
                                                        <?elseif($arCurrentSKU["PRICES"]):?>
                                                        <?$priceHtml = \Aspro\Functions\CAsproMaxItem::showItemPrices($arParams, $arCurrentSKU["PRICES"], $strMeasure, $min_price_id, ($arParams["SHOW_DISCOUNT_PERCENT_NUMBER"] == "Y" ? "N" : "Y"), false, true);?>
                                                        <?$countPrices = count($arCurrentSKU['PRICES'])?>
                                                        BX.message({
                                                            ASPRO_ITEM_PRICE: <?=CUtil::PhpToJSObject($priceHtml, false, true);?>
                                                        })
                                                        <?endif;?>
                                                        BX.message({
                                                            ASPRO_ITEM_POPUP_PRICE: 'Y',
                                                            ASPRO_ITEM_PRICES: <?=$countPrices;?>
                                                        })
                                                    </script>
                                                <? endif; ?>

                                                <div class="prices_block-btn" data-event="call-form"
                                                     data-el="<?= $arResult['ID'] ?>">
                                                    Показать телефон
                                                </div>
                                            </div>

                                            <? //buttons?>

                                            <? $frame->end(); ?>
                                        <? endif; ?>

                                        <? //services?>
                                        <div class="js-services"></div>
                                    </div>

                                </div>

                                <? $this->SetViewTarget('PRODUCT_SIDE_INFO', 900); ?>
                                <? if ($arResult['BRAND_ITEM']): ?>
                                    <div class="brand-detail">
                                        <div class="brand-detail-info bordered rounded3">
                                            <? if ($arResult['BRAND_ITEM']["IMAGE"]): ?>
                                                <div class="brand-detail-info__image"><a
                                                            href="<?= $arResult['BRAND_ITEM']["DETAIL_PAGE_URL"]; ?>"><img
                                                                src="<?= $arResult['BRAND_ITEM']["IMAGE"]["src"]; ?>"
                                                                alt="<?= $arResult['BRAND_ITEM']["NAME"]; ?>"
                                                                title="<?= $arResult['BRAND_ITEM']["NAME"]; ?>"
                                                                itemprop="image"></a></div>
                                            <? endif; ?>
                                            <div class="brand-detail-info__preview">
                                                <? if ($arResult['BRAND_ITEM']["PREVIEW_TEXT"]): ?>
                                                    <div class="text muted777 font_xs"><?= $arResult['BRAND_ITEM']["PREVIEW_TEXT"]; ?></div>
                                                <? endif; ?>
                                                <? if ($arResult['SECTION']): ?>
                                                    <div class="link font_xs"><a
                                                                href="<?= $arResult['BRAND_ITEM']['CATALOG_PAGE_URL'] ?>"
                                                                target="_blank"><?= GetMessage("ITEMS_BY_SECTION") ?></a>
                                                    </div>
                                                <? endif; ?>
                                                <div class="link font_xs"><a
                                                            href="<?= $arResult['BRAND_ITEM']["DETAIL_PAGE_URL"]; ?>"
                                                            target="_blank"><?= GetMessage("ITEMS_BY_BRAND", array("#BRAND#" => $arResult['BRAND_ITEM']["NAME"])) ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <? endif; ?>
                                <? $this->EndViewTarget(); ?>
                            </div>
                        </div>
                    </div>

                    <? //dop text?>
<!--                    --><?// $path = SITE_DIR . "include/element_detail_text.php" ?>
<!--                    <div class="price_txt muted font_sxs--><?php //= ((CMax::checkContentFile($path) ? ' filed' : '')); ?><!--">-->
<!--                        --><?// $APPLICATION->IncludeFile($path, array(), array("MODE" => "html", "NAME" => GetMessage('CT_BCE_CATALOG_DOP_DESCR'))); ?>
<!--                    </div>-->
                </div>
            </div>

            <? $bPriceCount = ($arParams['USE_PRICE_COUNT'] == 'Y'); ?>
            <? if ($arResult['OFFERS']): ?>
                <span itemprop="offers" itemscope itemtype="http://schema.org/AggregateOffer" style="display:none;">
				<meta itemprop="offerCount" content="<?= count($arResult['OFFERS']) ?>"/>
				<meta itemprop="lowPrice"
                      content="<?= ($arResult['MIN_PRICE']['DISCOUNT_VALUE'] ? $arResult['MIN_PRICE']['DISCOUNT_VALUE'] : $arResult['MIN_PRICE']['VALUE']) ?>"/>
				<meta itemprop="highPrice"
                      content="<?= ($arResult['MAX_PRICE']['DISCOUNT_VALUE'] ? $arResult['MAX_PRICE']['DISCOUNT_VALUE'] : $arResult['MAX_PRICE']['VALUE']) ?>"/>
				<meta itemprop="priceCurrency" content="<?= $arResult['MIN_PRICE']['CURRENCY'] ?>"/>
				<? foreach ($arResult['OFFERS'] as $arOffer): ?>
                    <? $currentOffersList = array(); ?>
                    <? foreach ($arOffer['TREE'] as $propName => $skuId): ?>
                        <? $propId = (int)substr($propName, 5); ?>
                        <? foreach ($arResult['SKU_PROPS'] as $prop): ?>
                            <? if ($prop['ID'] == $propId): ?>
                                <? foreach ($prop['VALUES'] as $propId => $propValue): ?>
                                    <? if ($propId == $skuId): ?>
                                        <? $currentOffersList[] = $propValue['NAME']; ?>
                                        <? break; ?>
                                    <? endif; ?>
                                <? endforeach; ?>
                            <? endif; ?>
                        <? endforeach; ?>
                    <? endforeach; ?>
                    <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
						<meta itemprop="sku" content="<?= implode('/', $currentOffersList) ?>"/>
						<a href="<?= $arOffer['DETAIL_PAGE_URL'] ?>" itemprop="url"></a>
						<meta itemprop="price"
                              content="<?= ($arOffer['MIN_PRICE']['DISCOUNT_VALUE']) ? $arOffer['MIN_PRICE']['DISCOUNT_VALUE'] : $arOffer['MIN_PRICE']['VALUE'] ?>"/>
						<meta itemprop="priceCurrency" content="<?= $arOffer['MIN_PRICE']['CURRENCY'] ?>"/>
						<link itemprop="availability"
                              href="http://schema.org/<?= ($arOffer['CAN_BUY'] ? 'InStock' : 'OutOfStock') ?>"/>
						<?
                        if ($arDiscount["ACTIVE_TO"]) {
                            ?>
                            <meta itemprop="priceValidUntil"
                                  content="<?= date("Y-m-d", MakeTimeStamp($arDiscount["ACTIVE_TO"])) ?>"/>
                        <? } ?>
					</span>
                <? endforeach; ?>
			</span>
                <? unset($arOffer, $currentOffersList); ?>
            <? endif; ?>

            <script type="text/javascript">
                BX.message({
                    QUANTITY_AVAILIABLE: '<? echo COption::GetOptionString("aspro.max", "EXPRESSION_FOR_EXISTS", GetMessage("EXPRESSION_FOR_EXISTS_DEFAULT"), SITE_ID); ?>',
                    QUANTITY_NOT_AVAILIABLE: '<? echo COption::GetOptionString("aspro.max", "EXPRESSION_FOR_NOTEXISTS", GetMessage("EXPRESSION_FOR_NOTEXISTS"), SITE_ID); ?>',
                    ADD_ERROR_BASKET: '<? echo GetMessage("ADD_ERROR_BASKET"); ?>',
                    ADD_ERROR_COMPARE: '<? echo GetMessage("ADD_ERROR_COMPARE"); ?>',
                    ONE_CLICK_BUY: '<? echo GetMessage("ONE_CLICK_BUY"); ?>',
                    MORE_TEXT_BOTTOM: '<?=\Bitrix\Main\Config\Option::get("aspro.max", "EXPRESSION_READ_MORE_OFFERS_DEFAULT", GetMessage("MORE_TEXT_BOTTOM"));?>',
                    TYPE_SKU: '<? echo $arParams['TYPE_SKU']; ?>',
                    HAS_SKU_PROPS: '<? echo($arResult['OFFERS_PROP'] ? 'Y' : 'N'); ?>',
                    SITE_ID: '<? echo SITE_ID; ?>'
                })
            </script>
        </div>
    </div>
<?php if (!empty($arResult['COMPLECT_PROPERTY'])): ?>
    <div class="maxwidth-theme">
        <div class="equipment-inner">
            <div class="equipment__title">
                <?= Loc::getMessage('COMPLECT_TITLE'); ?>
            </div>
            <div class="equipment">
                <?php if (!empty($arResult['COMPLECT_PROPERTY'][0]['VALUE'])): ?>
                    <?php foreach ($arResult['COMPLECT_PROPERTY'][0]['VALUE'] as $item): ?>
                        <div class="equipment_el">
                            <div class="equipment_el__i">
                                <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M9.23714 12.8071L7.16611 10.8754C6.93335 10.6583 6.55734 10.6583 6.32457 10.8754C6.09181 11.0925 6.09181 11.4432 6.32457 11.6603L8.81935 13.9872C9.05212 14.2043 9.42813 14.2043 9.66089 13.9872L15.9754 8.09771C16.2082 7.88062 16.2082 7.52992 15.9754 7.31282C15.7427 7.09573 15.3667 7.09573 15.1339 7.31282L9.23714 12.8071Z"
                                          fill="#666666"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M15.0316 7.20308C15.322 6.93229 15.7874 6.93231 16.0777 7.20313C16.3741 7.47953 16.3741 7.931 16.0777 8.20741L9.7632 14.0969C9.47282 14.3677 9.00743 14.3677 8.71704 14.0969L6.22227 11.77C5.92591 11.4936 5.92591 11.0422 6.22227 10.7658C6.51265 10.4949 6.97804 10.4949 7.26842 10.7658L9.23719 12.602L15.0316 7.20308ZM15.8731 7.42252C15.698 7.25916 15.4113 7.25916 15.2362 7.42252L9.23709 13.0121L7.06381 10.9851C6.88866 10.8218 6.60203 10.8218 6.42688 10.9851C6.25771 11.1429 6.25771 11.3929 6.42688 11.5506L8.92166 13.8775C9.09681 14.0408 9.38344 14.0408 9.55858 13.8775L15.8731 7.98802C16.0423 7.83023 16.0423 7.58031 15.8731 7.42252Z"
                                          fill="#666666"/>
                                </svg>
                            </div>
                            <div class="equipment_el__text">
                                <?= $item ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>


<? //detail description?>
<? if ($arResult['DETAIL_TEXT'] || $bOfferDetailText || !empty($arResult['LOCATION_PROPERTY'])): ?>
    <? $templateData['DETAIL_TEXT'] = true; ?>
    <? $this->SetViewTarget('PRODUCT_DETAIL_TEXT_INFO'); ?>
    <div class="content detail-text-wrap" itemprop="description">
        <? if ($bOfferDetailText): ?>
            <?= $arCurrentSKU["DETAIL_TEXT"]; ?>
        <? else: ?>
            <?= $arResult['DETAIL_TEXT']; ?>
        <? endif; ?>
    </div>

    <?php if (!empty($arResult['LOCATION_PROPERTY'])): ?>
        <div class="ordered-block__title option-font-bold font_lg" style="margin-top: 45px">Мы на карте</div>

        <div id="map"></div>
        <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=e2caa9ca-c646-4d64-b8c9-bbe9b1227165"
                type="text/javascript"></script>
        <script>
            const coordValue = "<?=$arResult['LOCATION_PROPERTY']['location']['VALUE'];?>";
            const dataLocation = coordValue.trim().split(',').map(function (item) {
                return parseFloat(item.trim());
            });
            ymaps.ready(init);

            function init() {


                var map = new ymaps.Map('map', {
                    center: dataLocation,
                    zoom: 12,
                    controls: ['zoomControl'],
                    behaviors: ['drag'],
                });


                myPlacemark = new ymaps.Placemark(dataLocation, {
                    preset: 'twirl#violetIcon'
                })
                map.geoObjects.add(myPlacemark)

            }

        </script>
    <?php endif; ?>
    <? $this->EndViewTarget(); ?>
<? endif; ?>

    <? $this->SetViewTarget('SMALL_TEXT'); ?>
    <? $APPLICATION->IncludeFile(SITE_DIR . "include/element_detail_text.php", array(), array("MODE" => "html", "NAME" => GetMessage('CT_BCE_CATALOG_DOP_DESCR'))); ?>
    <? $this->EndViewTarget(); ?>

<? //additional gallery?>
<? if ($arResult['ADDITIONAL_GALLERY']): ?>
    <? $bShowSmallGallery = $arParams['ADDITIONAL_GALLERY_TYPE'] === 'SMALL'; ?>
    <? $templateData['ADDITIONAL_GALLERY'] = true;
    $additionalGallery = $arCurrentSKU ? $arResult['ADDITIONAL_GALLERY'][$arCurrentSKU['ID']] : $arResult['ADDITIONAL_GALLERY'];
    ?>
    <? $this->SetViewTarget('PRODUCT_ADDITIONAL_GALLERY_INFO'); ?>
    <div class="ordered-block">
        <div class="additional-gallery <?= ($arResult['OFFERS'] && 'TYPE_1' === $arParams['TYPE_SKU'] && !$arResult['ADDITIONAL_GALLERY'][$arCurrentSKU['ID']] ? ' hidden' : '') ?>">
            <div class="ordered-block__title option-font-bold font_lg">
                <?= $arParams['BLOCK_ADDITIONAL_GALLERY_NAME']; ?>
            </div>
            <? //switch gallery?>
            <div class="switch-item-block">
                <div class="flexbox flexbox--row">
                    <div class="switch-item-block__count muted777 font_xs">
                        <div class="switch-item-block__count-wrapper switch-item-block__count-wrapper--small" <?= ($bShowSmallGallery ? "" : "style='display:none;'"); ?>>
                            <span class="switch-item-block__count-value"><?= count($additionalGallery); ?></span>
                            <?= Loc::getMessage('PHOTO'); ?>
                            <span class="switch-item-block__count-separate">&mdash;</span>
                        </div>
                        <div class="switch-item-block__count-wrapper switch-item-block__count-wrapper--big" <?= ($bShowSmallGallery ? "style='display:none;'" : ""); ?>>
                            <span class="switch-item-block__count-value">1/<?= count($additionalGallery); ?></span>
                            <span class="switch-item-block__count-separate">&mdash;</span>
                        </div>
                    </div>
                    <div class="switch-item-block__icons-wrapper">
                        <span class="switch-item-block__icons<?= (!$bShowSmallGallery ? ' active' : ''); ?> switch-item-block__icons--big"
                              title="<?= Loc::getMessage("BIG_GALLERY"); ?>"><?= CMax::showIconSvg("gallery", SITE_TEMPLATE_PATH . "/images/svg/gallery_alone.svg", "", "colored_theme_hover_bg-el-svg", true, false); ?></span>
                        <span class="switch-item-block__icons<?= ($bShowSmallGallery ? ' active' : ''); ?> switch-item-block__icons--small"
                              title="<?= Loc::getMessage("SMALL_GALLERY"); ?>"><?= CMax::showIconSvg("gallery", SITE_TEMPLATE_PATH . "/images/svg/gallery_list.svg", "", "colored_theme_hover_bg-el-svg", true, false); ?></span>
                    </div>
                </div>
            </div>

            <? //big gallery?>
            <div class="big-gallery-block"<?= ($bShowSmallGallery ? ' style="display:none;"' : ''); ?> >
                <div class="owl-carousel owl-theme owl-bg-nav short-nav"
                     data-plugin-options='{"items": "1", "autoplay" : false, "autoplayTimeout" : "3000", "smartSpeed":1000, "dots": true, "nav": true, "loop": false, "index": true, "margin": 5}'>
                    <? foreach ($additionalGallery as $i => $arPhoto): ?>
                        <div class="item">
                            <a href="<?= $arPhoto['DETAIL']['SRC'] ?>" class="fancy" data-fancybox="big-gallery"
                               target="_blank" title="<?= $arPhoto['TITLE'] ?>">
                                <img data-src="<?= $arPhoto['PREVIEW']['src'] ?>"
                                     src="<?= \Aspro\Functions\CAsproMax::showBlankImg($arPhoto['PREVIEW']['src']); ?>"
                                     class="img-responsive inline lazy" title="<?= $arPhoto['TITLE'] ?>"
                                     alt="<?= $arPhoto['ALT'] ?>"/>
                            </a>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>

            <? //small gallery?>
            <? \Aspro\Functions\CAsproMax::showSmallGallery(['IS_ACTIVE' => $bShowSmallGallery], $additionalGallery); ?>
        </div>
    </div>
    <? $this->EndViewTarget(); ?>
<? endif; ?>

<? //custom tab?>
<? if ($arParams['SHOW_ADDITIONAL_TAB'] == 'Y'): ?>
    <? $this->SetViewTarget('PRODUCT_CUSTOM_TAB_INFO'); ?>
    <? $APPLICATION->IncludeFile(SITE_DIR . "include/additional_products_description.php", array(), array("MODE" => "html", "NAME" => GetMessage('CT_BCE_CATALOG_ADDITIONAL_DESCRIPTION'))); ?>
    <? $this->EndViewTarget(); ?>
<? endif; ?>

<? if ($arParams["SHOW_HOW_BUY"] == "Y"): ?>
    <? $this->SetViewTarget('PRODUCT_HOW_BUY_INFO'); ?>
    <? $APPLICATION->IncludeFile(SITE_DIR . "include/tab_catalog_detail_howbuy.php", array(), array("MODE" => "html", "NAME" => GetMessage('TITLE_HOW_BUY'))); ?>
    <? $this->EndViewTarget(); ?>
<? endif; ?>

<? if ($arParams["SHOW_PAYMENT"] == "Y"): ?>
    <? $this->SetViewTarget('PRODUCT_PAYMENT_INFO'); ?>
    <? $APPLICATION->IncludeFile(SITE_DIR . "include/tab_catalog_detail_payment.php", array(), array("MODE" => "html", "NAME" => GetMessage('TITLE_PAYMENT'))); ?>
    <? $this->EndViewTarget(); ?>
<? endif; ?>

<? if ($arParams["SHOW_DELIVERY"] == "Y"): ?>
    <? $this->SetViewTarget('PRODUCT_DELIVERY_INFO'); ?>
    <? $APPLICATION->IncludeFile(SITE_DIR . "include/tab_catalog_detail_delivery.php", array(), array("MODE" => "html", "NAME" => GetMessage('TITLE_DELIVERY'))); ?>
    <? $this->EndViewTarget(); ?>
<? endif; ?>

<? if ($arResult['VIDEO']): ?>
    <? $this->SetViewTarget('PRODUCT_VIDEO_INFO'); ?>
    <div class="hidden_print">
        <div class="video_block row">
            <? if (count($arResult['VIDEO']) > 1): ?>
                <? foreach ($arResult['VIDEO'] as $v => $value): ?>
                    <div class="col-sm-6">
                        <?= str_replace('src=', 'width="660" height="457" src=', str_replace(array('width', 'height'), array('data-width', 'data-height'), $value)); ?>
                    </div>
                <? endforeach; ?>
            <? else: ?>
                <div class="col-md-12"><?= $arResult['VIDEO'][0] ?></div>
            <? endif; ?>
        </div>
    </div>
    <? $this->EndViewTarget(); ?>
<? endif; ?>

<? //files?>
<? $instr_prop = ($arParams["DETAIL_DOCS_PROP"] ? $arParams["DETAIL_DOCS_PROP"] : "INSTRUCTIONS"); ?>
<?
$bItemFiles = isset($arResult["PROPERTIES"][$instr_prop]) && (is_array($arResult["PROPERTIES"][$instr_prop]["VALUE"]) && count($arResult["PROPERTIES"][$instr_prop]["VALUE"]));
$bSectionFiles = isset($arResult["SECTION_FULL"]["UF_FILES"]) && is_array($arResult["SECTION_FULL"]["UF_FILES"]) && count($arResult["SECTION_FULL"]["UF_FILES"]);
?>
<? if ($bItemFiles || $bSectionFiles): ?>
    <?
    $arFiles = array();
    if ($arResult["PROPERTIES"][$instr_prop]["VALUE"]) {
        $arFiles = $arResult["PROPERTIES"][$instr_prop]["VALUE"];
    } else {
        $arFiles = $arResult["SECTION_FULL"]["UF_FILES"];
    }
    if (is_array($arFiles)) {
        foreach ($arFiles as $key => $value) {
            if (!intval($value)) {
                unset($arFiles[$key]);
            }
        }
    }
    $templateData['FILES'] = $arFiles;
    if ($arFiles):?>
        <? $this->SetViewTarget('PRODUCT_FILES_INFO'); ?>
        <div class="char_block rounded3 bordered files_block">
            <div class="row flexbox">
                <? foreach ($arFiles as $arItem): ?>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <? $arFile = CMax::GetFileInfo($arItem); ?>
                        <div class="file_type clearfix <?= $arFile["TYPE"]; ?>">
                            <i class="icon"></i>
                            <div class="description">
                                <a target="_blank" href="<?= $arFile["SRC"]; ?>"
                                   class="dark_link font_sm"><?= $arFile["DESCRIPTION"]; ?></a>
                                <span class="size font_xs muted">
										<?= $arFile["FILE_SIZE_FORMAT"]; ?>
									</span>
                            </div>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
        <? $this->EndViewTarget(); ?>
    <? endif; ?>
<? endif; ?>

<?
if ($arResult['CATALOG'] && $actualItem['CAN_BUY'] && $arParams['USE_PREDICTION'] === 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled('sale')) {
    $APPLICATION->IncludeComponent(
        'bitrix:sale.prediction.product.detail',
        'main',
        array(
            'BUTTON_ID' => false,
            'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
            'POTENTIAL_PRODUCT_TO_BUY' => array(
                'ID' => $arResult['ID'],
                'MODULE' => isset($arResult['MODULE']) ? $arResult['MODULE'] : 'catalog',
                'PRODUCT_PROVIDER_CLASS' => isset($arResult['PRODUCT_PROVIDER_CLASS']) ? $arResult['PRODUCT_PROVIDER_CLASS'] : 'CCatalogProductProvider',
                'QUANTITY' => isset($arResult['QUANTITY']) ? $arResult['QUANTITY'] : null,
                'IBLOCK_ID' => $arResult['IBLOCK_ID'],
                'PRIMARY_OFFER_ID' => isset($arResult['OFFERS'][0]['ID']) ? $arResult['OFFERS'][0]['ID'] : null,
                'SECTION' => array(
                    'ID' => isset($arResult['SECTION']['ID']) ? $arResult['SECTION']['ID'] : null,
                    'IBLOCK_ID' => isset($arResult['SECTION']['IBLOCK_ID']) ? $arResult['SECTION']['IBLOCK_ID'] : null,
                    'LEFT_MARGIN' => isset($arResult['SECTION']['LEFT_MARGIN']) ? $arResult['SECTION']['LEFT_MARGIN'] : null,
                    'RIGHT_MARGIN' => isset($arResult['SECTION']['RIGHT_MARGIN']) ? $arResult['SECTION']['RIGHT_MARGIN'] : null,
                ),
            )
        ),
        $component,
        array('HIDE_ICONS' => 'Y')
    );
}
?>
<? $this->SetViewTarget('PRODUCT_GIFT_INFO'); ?>
    <div class="gifts">
        <? if ($arResult['CATALOG'] && $arParams['USE_GIFTS_DETAIL'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled("sale")) {
            $APPLICATION->IncludeComponent("bitrix:sale.gift.product", "main", array(
                "USE_REGION" => $arParams['USE_REGION'] !== 'N' ? 'Y' : 'N',
                "STORES" => $arParams['STORES'],
                "SHOW_UNABLE_SKU_PROPS" => $arParams["SHOW_UNABLE_SKU_PROPS"],
                'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
                'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
                'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE'],
                'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
                'SUBSCRIBE_URL_TEMPLATE' => $arResult['~SUBSCRIBE_URL_TEMPLATE'],
                'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
                "OFFER_HIDE_NAME_PROPS" => $arParams["OFFER_HIDE_NAME_PROPS"],

                "SHOW_DISCOUNT_PERCENT" => "N",
                "SHOW_OLD_PRICE" => $arParams['GIFTS_SHOW_OLD_PRICE'],
                "PAGE_ELEMENT_COUNT" => $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],
                "LINE_ELEMENT_COUNT" => $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],
                "HIDE_BLOCK_TITLE" => $arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE'],
                "BLOCK_TITLE" => $arParams['GIFTS_DETAIL_BLOCK_TITLE'],
                "TEXT_LABEL_GIFT" => $arParams['GIFTS_DETAIL_TEXT_LABEL_GIFT'],
                "SHOW_NAME" => $arParams['GIFTS_SHOW_NAME'],
                "SHOW_IMAGE" => $arParams['GIFTS_SHOW_IMAGE'],
                "MESS_BTN_BUY" => $arParams['GIFTS_MESS_BTN_BUY'],

                "SHOW_PRODUCTS_{$arParams['IBLOCK_ID']}" => "Y",
                "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
                "PRODUCT_SUBSCRIPTION" => $arParams["PRODUCT_SUBSCRIPTION"],
                "MESS_BTN_DETAIL" => $arParams["MESS_BTN_DETAIL"],
                "MESS_BTN_SUBSCRIBE" => $arParams["MESS_BTN_SUBSCRIBE"],
                "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
                "PRICE_CODE" => $arParams["PRICE_CODE"],
                "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
                "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
                "CURRENCY_ID" => $arParams["CURRENCY_ID"],
                "BASKET_URL" => $arParams["BASKET_URL"],
                "ADD_PROPERTIES_TO_BASKET" => $arParams["ADD_PROPERTIES_TO_BASKET"],
                "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                "PARTIAL_PRODUCT_PROPERTIES" => $arParams["PARTIAL_PRODUCT_PROPERTIES"],
                "USE_PRODUCT_QUANTITY" => 'N',
                "OFFER_TREE_PROPS_{$arResult['OFFERS_IBLOCK']}" => $arParams['OFFER_TREE_PROPS'],
                "CART_PROPERTIES_{$arResult['OFFERS_IBLOCK']}" => $arParams['OFFERS_CART_PROPERTIES'],
                "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "SHOW_DISCOUNT_TIME" => "N",
                "SHOW_ONE_CLICK_BUY" => "N",
                "SHOW_DISCOUNT_PERCENT_NUMBER" => "N",
                "SALE_STIKER" => $arParams["SALE_STIKER"],
                "STIKERS_PROP" => $arParams["STIKERS_PROP"],
                "SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
                "SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
                "DISPLAY_TYPE" => "block",
                "SHOW_RATING" => $arParams["SHOW_RATING"],
                "DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
                "DISPLAY_WISH_BUTTONS" => $arParams["DISPLAY_WISH_BUTTONS"],
                "DEFAULT_COUNT" => $arParams["DEFAULT_COUNT"],
                "TYPE_SKU" => "Y",

                "POTENTIAL_PRODUCT_TO_BUY" => array(
                    'ID' => isset($arResult['ID']) ? $arResult['ID'] : null,
                    'MODULE' => isset($arResult['MODULE']) ? $arResult['MODULE'] : 'catalog',
                    'PRODUCT_PROVIDER_CLASS' => isset($arResult['PRODUCT_PROVIDER_CLASS']) ? $arResult['PRODUCT_PROVIDER_CLASS'] : 'CCatalogProductProvider',
                    'QUANTITY' => isset($arResult['QUANTITY']) ? $arResult['QUANTITY'] : null,
                    'IBLOCK_ID' => isset($arResult['IBLOCK_ID']) ? $arResult['IBLOCK_ID'] : null,

                    'PRIMARY_OFFER_ID' => isset($arResult['OFFERS'][0]['ID']) ? $arResult['OFFERS'][0]['ID'] : null,
                    'SECTION' => array(
                        'ID' => isset($arResult['SECTION']['ID']) ? $arResult['SECTION']['ID'] : null,
                        'IBLOCK_ID' => isset($arResult['SECTION']['IBLOCK_ID']) ? $arResult['SECTION']['IBLOCK_ID'] : null,
                        'LEFT_MARGIN' => isset($arResult['SECTION']['LEFT_MARGIN']) ? $arResult['SECTION']['LEFT_MARGIN'] : null,
                        'RIGHT_MARGIN' => isset($arResult['SECTION']['RIGHT_MARGIN']) ? $arResult['SECTION']['RIGHT_MARGIN'] : null,
                    ),
                )
            ), $component, array("HIDE_ICONS" => "Y"));
        }
        if ($arResult['CATALOG'] && $arParams['USE_GIFTS_MAIN_PR_SECTION_LIST'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled("sale")) {
            $APPLICATION->IncludeComponent(
                "bitrix:sale.gift.main.products",
                "main",
                array(
                    "USE_REGION" => $arParams['USE_REGION'] !== 'N' ? 'Y' : 'N',
                    "STORES" => $arParams['STORES'],
                    "SHOW_UNABLE_SKU_PROPS" => $arParams["SHOW_UNABLE_SKU_PROPS"],
                    "PAGE_ELEMENT_COUNT" => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
                    "BLOCK_TITLE" => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'],

                    "OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
                    "OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],

                    "AJAX_MODE" => $arParams["AJAX_MODE"],
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],

                    "ELEMENT_SORT_FIELD" => 'ID',
                    "ELEMENT_SORT_ORDER" => 'DESC',
                    //"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                    //"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                    "FILTER_NAME" => 'searchFilter',
                    "SECTION_URL" => $arParams["SECTION_URL"],
                    "DETAIL_URL" => $arParams["DETAIL_URL"],
                    "BASKET_URL" => $arParams["BASKET_URL"],
                    "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                    "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],

                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "SHOW_ONE_CLICK_BUY" => "N",
                    "CACHE_TIME" => $arParams["CACHE_TIME"],

                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "SET_TITLE" => $arParams["SET_TITLE"],
                    "PROPERTY_CODE" => "",
                    "PRICE_CODE" => $arParams["PRICE_CODE"],
                    "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                    "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
                    "CURRENCY_ID" => $arParams["CURRENCY_ID"],
                    "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
                    "TEMPLATE_THEME" => (isset($arParams["TEMPLATE_THEME"]) ? $arParams["TEMPLATE_THEME"] : ""),

                    "ADD_PICT_PROP" => (isset($arParams["ADD_PICT_PROP"]) ? $arParams["ADD_PICT_PROP"] : ""),

                    "LABEL_PROP" => (isset($arParams["LABEL_PROP"]) ? $arParams["LABEL_PROP"] : ""),
                    "OFFER_ADD_PICT_PROP" => (isset($arParams["OFFER_ADD_PICT_PROP"]) ? $arParams["OFFER_ADD_PICT_PROP"] : ""),
                    "OFFER_TREE_PROPS" => (isset($arParams["OFFER_TREE_PROPS"]) ? $arParams["OFFER_TREE_PROPS"] : ""),
                    "SHOW_DISCOUNT_PERCENT" => "N",
                    "SHOW_OLD_PRICE" => (isset($arParams["SHOW_OLD_PRICE"]) ? $arParams["SHOW_OLD_PRICE"] : ""),
                    "MESS_BTN_BUY" => (isset($arParams["MESS_BTN_BUY"]) ? $arParams["MESS_BTN_BUY"] : ""),
                    "MESS_BTN_ADD_TO_BASKET" => (isset($arParams["MESS_BTN_ADD_TO_BASKET"]) ? $arParams["MESS_BTN_ADD_TO_BASKET"] : ""),
                    "MESS_BTN_DETAIL" => (isset($arParams["MESS_BTN_DETAIL"]) ? $arParams["MESS_BTN_DETAIL"] : ""),
                    "MESS_NOT_AVAILABLE" => (isset($arParams["MESS_NOT_AVAILABLE"]) ? $arParams["MESS_NOT_AVAILABLE"] : ""),
                    'ADD_TO_BASKET_ACTION' => (isset($arParams["ADD_TO_BASKET_ACTION"]) ? $arParams["ADD_TO_BASKET_ACTION"] : ""),
                    'SHOW_CLOSE_POPUP' => (isset($arParams["SHOW_CLOSE_POPUP"]) ? $arParams["SHOW_CLOSE_POPUP"] : ""),
                    'DISPLAY_COMPARE' => (isset($arParams['DISPLAY_COMPARE']) ? $arParams['DISPLAY_COMPARE'] : ''),
                    'COMPARE_PATH' => (isset($arParams['COMPARE_PATH']) ? $arParams['COMPARE_PATH'] : ''),
                    "SHOW_DISCOUNT_TIME" => "N",
                    "SHOW_DISCOUNT_PERCENT_NUMBER" => "N",
                    "SALE_STIKER" => $arParams["SALE_STIKER"],
                    "STIKERS_PROP" => $arParams["STIKERS_PROP"],
                    "SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
                    "DISPLAY_TYPE" => "block",
                    "SHOW_RATING" => $arParams["SHOW_RATING"],
                    "DISPLAY_WISH_BUTTONS" => $arParams["DISPLAY_WISH_BUTTONS"],
                    "DEFAULT_COUNT" => $arParams["DEFAULT_COUNT"],
                )
                + array(
                    'OFFER_ID' => empty($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID']) ? $arResult['ID'] : $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'],
                    'SECTION_ID' => $arResult['SECTION']['ID'],
                    'ELEMENT_ID' => $arResult['ID'],
                ),
                $component,
                array("HIDE_ICONS" => "Y")
            );
        }
        ?>
    </div>
<? $this->EndViewTarget(); ?>

<? \Aspro\Functions\CAsproMax::showBonusComponentDetail($arResult); ?>