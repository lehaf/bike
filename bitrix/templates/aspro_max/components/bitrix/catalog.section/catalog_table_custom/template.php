<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? $this->setFrameMode(true); ?>
<? use \Bitrix\Main\Localization\Loc,
    \Bitrix\Main\Web\Json; ?>
<?php \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/catalog/section-list.css", ['GROUP' => 1000]); ?>
<?php \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/catalog/section-block.css", ['GROUP' => 1000]); ?>
<?php \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/catalog/section-table.css", ['GROUP' => 1000]); ?>
<?
$bShowOfferTree = $arParams["SHOW_OFFER_TREE_IN_TABLE"] === "Y";
$bHideProps = $arParams['SHOW_PROPS_TABLE'] == 'not' || !isset($arParams['SHOW_PROPS_TABLE']);
$bRowProps = $arParams['SHOW_PROPS_TABLE'] == 'rows';
$bColProps = $arParams['SHOW_PROPS_TABLE'] == 'cols';

?>
<? if ($arResult["ITEMS"] && count($arResult["ITEMS"]) >= 1) { ?>
    <?
    $arTransferParams = array(
        "ALT_TITLE_GET" => $arParams["ALT_TITLE_GET"],
        "SHOW_ABSENT" => $arParams["SHOW_ABSENT"],
        "HIDE_NOT_AVAILABLE_OFFERS" => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
        "PRICE_CODE" => $arParams["PRICE_CODE"],
        "OFFER_TREE_PROPS" => $arParams["OFFER_TREE_PROPS"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
        "CURRENCY_ID" => $arParams["CURRENCY_ID"],
        "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
        "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
        "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
        "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
        "LIST_OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "LIST_OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
        "SHOW_DISCOUNT_TIME" => $arParams["SHOW_DISCOUNT_TIME"],
        "SHOW_COUNTER_LIST" => $arParams["SHOW_COUNTER_LIST"],
        "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
        "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
        "SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
        "SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
        "SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
        "SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
        "USE_REGION" => $arParams["USE_REGION"],
        "STORES" => $arParams["STORES"],
        "DEFAULT_COUNT" => $arParams["DEFAULT_COUNT"],
        "BASKET_URL" => $arParams["BASKET_URL"],
        "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
        "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
        "PARTIAL_PRODUCT_PROPERTIES" => $arParams["PARTIAL_PRODUCT_PROPERTIES"],
        "ADD_PROPERTIES_TO_BASKET" => ($arParams["ADD_PROPERTIES_TO_BASKET"] != "N" ? "Y" : "N"),
        "SHOW_DISCOUNT_TIME_EACH_SKU" => $arParams["SHOW_DISCOUNT_TIME_EACH_SKU"],
        "SHOW_ARTICLE_SKU" => $arParams["SHOW_ARTICLE_SKU"],
        "OFFER_ADD_PICT_PROP" => $arParams["OFFER_ADD_PICT_PROP"],
        "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
        "SHOW_ONE_CLICK_BUY" => $arParams["SHOW_ONE_CLICK_BUY"],
        "DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
        "DISPLAY_WISH_BUTTONS" => $arParams["DISPLAY_WISH_BUTTONS"],
        "MAX_GALLERY_ITEMS" => $arParams["MAX_GALLERY_ITEMS"],
        "SHOW_GALLERY" => $arParams["SHOW_GALLERY"],
        "SHOW_PROPS" => $arParams["SHOW_PROPS"],
        "SHOW_POPUP_PRICE" => CMax::GetFrontParametrValue('SHOW_POPUP_PRICE'),
        "ADD_PICT_PROP" => $arParams["ADD_PICT_PROP"],
        "ADD_DETAIL_TO_SLIDER" => $arParams["ADD_DETAIL_TO_SLIDER"],
        "DISPLAY_COMPARE" => CMax::GetFrontParametrValue('CATALOG_COMPARE'),
        "IBINHERIT_TEMPLATES" => $arParams["IBINHERIT_TEMPLATES"] ?? [],
        "IBLOCK_ID_PARENT" => $arParams["IBLOCK_ID"],
        "IBLOCK_ID" => $arResult["SKU_IBLOCK_ID"],
    );

    /* for stores filter for offers in js_item_detail */
    $storesFilterForOffers = Aspro\Max\Stores\Property::getStoresFilterForOffers($arParams);
    if (!empty($storesFilterForOffers)) {
        $arTransferParams["SKU_STORES"] = $storesFilterForOffers;
    }
    /**/
    ?>
    <? $arParams["BASKET_ITEMS"] = ($arParams["BASKET_ITEMS"] ? $arParams["BASKET_ITEMS"] : array()); ?>
    <? $bOptBuy = ($arParams['MANY_BUY_CATALOG_SECTIONS'] == 'Y'); ?>
    <? if ($arParams["AJAX_REQUEST"] == "N"): ?>
    <div class="table-view-outer <?= ($bShowOfferTree ? ' table-view-offer-tree' : ''); ?> <?= ($bColProps ? ' table-view-outer--hidden' : ''); ?>">
        <div class="js_wrapper_items load-offer-js"
             data-params='<?= \Aspro\Max\Product\SkuTools::getSignedParams($arTransferParams) ?>'>
            <div id="table-scroller-wrapper"
                 class="table-view js_append flexbox flexbox--row<?= ($bOptBuy ? ' with-opt-buy' : ''); ?> <?= $bColProps ? 'table-props-cols scroller horizontal-scroll bordered' : '' ?>">
                <? if ($bColProps): ?>
                    <div id="table-scroller-wrapper__header" class="hide-600">
                        <? if ($arResult['SHOW_COLS_PROP'] && $bColProps): ?>
                            <div class="product-info-head bordered rounded-4 grey-bg hide-991">
                                <div class="flexbox flexbox--row">

                                    <div class="table-view__item-wrapper-head">
                                        <div class="item-foto"></div>
                                    </div>
                                    <div class="flex-1 flexbox flexbox--row">
                                        <div class="table-view__info-top">
                                            <div class="table-view__item-wrapper-head">
                                                <div class="font_xs muted"><?= Loc::getMessage('NAME_PRODUCT') ?></div>
                                            </div>
                                        </div>
                                        <? foreach ($arResult['COLS_PROP'] as $arProp): ?>
                                            <div class="table-view__item-wrapper-head props hide-991">
                                                <div class="font_xs muted font_short"><?= $arProp['NAME']; ?></div>
                                            </div>
                                        <? endforeach; ?>
                                        <div class="table-view__item-actions">
                                            <div class="table-view__item-wrapper-head">
                                                <div class="font_xs muted"><?= Loc::getMessage('PRICE_PRODUCT') ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <? endif; ?>
                    </div>
                <? endif; ?>
                <? endif ?>
                <? $currencyList = '';
                if (!empty($arResult['CURRENCIES'])) {
                    $templateLibrary[] = 'currency';
                    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
                }
                $templateData = array(
                    'TEMPLATE_LIBRARY' => $templateLibrary,
                    'CURRENCIES' => $currencyList
                );
                unset($currencyList, $templateLibrary);

                // params for catalog elements compact view
                $arParamsCE_CMP = $arParams;
                $arParamsCE_CMP['TYPE_SKU'] = 'N';
                ?>
                <?
                if (is_array($arParams['OFFERS_CART_PROPERTIES'])) {
                    $arOfferProps = implode(';', $arParams['OFFERS_CART_PROPERTIES']);
                } else {
                    $arOfferProps = '';
                }
                ?>
                <? foreach ($arResult["ITEMS"] as $arItem) { ?>
                    <? $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));

                    $bOutOfProduction = isset($arItem['PROPERTIES']['OUT_OF_PRODUCTION']) && $arItem['PROPERTIES']['OUT_OF_PRODUCTION']['VALUE'] === 'Y';

                    if ($bOutOfProduction && $arItem['OFFERS']) {
                        $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['PROPERTIES']['OUT_OF_PRODUCTION'] = ['VALUE' => $arItem['PROPERTIES']['OUT_OF_PRODUCTION']['VALUE']];

                        if (isset($arItem['PROPERTIES']['PRODUCT_ANALOG_FILTER']) && $arItem['PROPERTIES']['PRODUCT_ANALOG_FILTER']['VALUE']) {
                            $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['PROPERTIES']['PRODUCT_ANALOG_FILTER'] = ['VALUE' => $arItem['PROPERTIES']['PRODUCT_ANALOG_FILTER']['VALUE']];;
                        }
                    }

                    if (!empty($arItem['PRODUCT_PROPERTIES_FILL'])) {
                        foreach ($arItem['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo) {
                            if (isset($arItem['PRODUCT_PROPERTIES'][$propID]))
                                unset($arItem['PRODUCT_PROPERTIES'][$propID]);
                        }
                    }

                    $emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);
                    $arItem["EMPTY_PROPS_JS"] = (!$emptyProductProperties ? "N" : "Y");

                    $item_id = $arItem["ID"];
                    $strMeasure = '';
                    $arCurrentSKU = array();

                    $bComplect = $arItem["PROPERTIES"]["PRODUCT_SET"]["VALUE"] === "Y";
                    $addParams = array();
                    if ($bComplect) {
                        $addParams = array("DISPLAY_WISH_BUTTONS" => "N", "MESSAGE_FROM" => Loc::getMessage('FROM') . ' ');
                        $arItem["SHOW_FROM_LANG"] = "Y";
                    }


                    $currentSKUID = $currentSKUIBlock = '';

                    $totalCount = CMax::GetTotalCount($arItem, $arParams);
                    $arQuantityData = CMax::GetQuantityArray($totalCount, array('ID' => $item_id), 'N', (($arItem["OFFERS"] || $arItem['CATALOG_TYPE'] == CCatalogProduct::TYPE_SET || $bColProps || !$arResult['STORES_COUNT']) ? false : true));

                    $arItem["strMainID"] = $this->GetEditAreaId($arItem['ID']);

                    $arItemIDs = CMax::GetItemsIDs($arItem);

                    if ($arParams["SHOW_MEASURE"] == "Y" && $arItem["CATALOG_MEASURE"]) {
                        if (isset($arItem["ITEM_MEASURE"]) && (is_array($arItem["ITEM_MEASURE"]) && $arItem["ITEM_MEASURE"]["TITLE"])) {
                            $strMeasure = $arItem["ITEM_MEASURE"]["TITLE"];
                        } else {
                            $arMeasure = CCatalogMeasure::getList(array(), array("ID" => $arItem["CATALOG_MEASURE"]), false, false, array())->GetNext();
                            $strMeasure = $arMeasure["SYMBOL_RUS"];
                        }
                    }
                    $bUseSkuProps = ($arItem["OFFERS"] && !empty($arItem['OFFERS_PROP']) && $bShowOfferTree && $arParams['TYPE_SKU'] != 'N');

                    $elementName = ((isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arItem['NAME']);

                    if ($bUseSkuProps) {
                        if (!$arItem["OFFERS"]) {
                            $arAddToBasketData = CMax::GetAddToBasketArray($arItem, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, $arItemIDs["ALL_ITEM_IDS"], 'small', $arParams);
                        } elseif ($arItem["OFFERS"]) {

                            $currentSKUIBlock = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["IBLOCK_ID"];
                            $currentSKUID = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["ID"];
                            $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["IS_OFFER"] = "Y";

                            //$totalCountCMP = CMax::GetTotalCount($arItem, $arParamsCE_CMP);
                            $totalCountCMP = $totalCount;
                            $arQuantityDataCMP = CMax::GetQuantityArray($totalCountCMP, array('ID' => $item_id), 'N', false, 'ce_cmp_visible');

                            $strMeasure = $arItem["MIN_PRICE"]["CATALOG_MEASURE_NAME"];
                            $totalCount = CMax::GetTotalCount($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]], $arParams);
                            $arQuantityData = CMax::GetQuantityArray($totalCount, array('ID' => $currentSKUID), 'N', (($arItem['CATALOG_TYPE'] == CCatalogProduct::TYPE_SET || $bColProps || !$arResult['STORES_COUNT']) ? false : true), 'ce_cmp_hidden');

                            $arItem["DETAIL_PAGE_URL"] = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DETAIL_PAGE_URL"];
                            if ($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["PREVIEW_PICTURE"])
                                $arItem["PREVIEW_PICTURE"] = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["PREVIEW_PICTURE"];
                            if ($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["PREVIEW_PICTURE"])
                                $arItem["DETAIL_PICTURE"] = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DETAIL_PICTURE"];

                            if ($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['IPROPERTY_VALUES']) {
                                $arItem['SELECTED_SKU_IPROPERTY_VALUES'] = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['IPROPERTY_VALUES'];
                            }

                            if ($arParams["SET_SKU_TITLE"] == "Y") {
                                $tmpOfferName = ((isset($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) ? $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['NAME']);
                                if (!empty($tmpOfferName)) {
                                    $arItem["NAME"] = $elementName = $tmpOfferName;
                                }
                            }
                            $item_id = $currentSKUID;

                            // ARTICLE
                            if ($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DISPLAY_PROPERTIES"]["ARTICLE"]["VALUE"]) {
                                $arItem["ARTICLE"]["NAME"] = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DISPLAY_PROPERTIES"]["ARTICLE"]["NAME"];
                                $arItem["ARTICLE"]["VALUE"] = (is_array($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DISPLAY_PROPERTIES"]["ARTICLE"]["VALUE"]) ? reset($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DISPLAY_PROPERTIES"]["ARTICLE"]["VALUE"]) : $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DISPLAY_PROPERTIES"]["ARTICLE"]["VALUE"]);
                                unset($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DISPLAY_PROPERTIES"]["ARTICLE"]);
                            }


                            $arCurrentSKU = $arItem["JS_OFFERS"][$arItem["OFFERS_SELECTED"]];
                            $strMeasure = $arCurrentSKU["MEASURE"];

                            /* need for add basket props */
                            $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["IBLOCK_ID"] = $arItem['IBLOCK_ID'];
                            /* */

                            $arAddToBasketData = CMax::GetAddToBasketArray($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]], $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, $arItemIDs["ALL_ITEM_IDS"], 'small', $arParams);

                            /* restore IBLOCK_ID */
                            $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["IBLOCK_ID"] = $currentSKUIBlock;
                            /* */
                        }
                    } else {
                        $arItem['OFFERS_PROP'] = '';
                        if ($arItem["OFFERS"])
                            $arItem["OFFERS_MORE"] = "Y";
                        if ($bComplect) {
                            $arItem["SHOW_MORE_BUTTON"] = "Y";
                        }
                        $arAddToBasketData = CMax::GetAddToBasketArray($arItem, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, array(), 'small', $arParams);
                    }
                    ?>
                    <? //$arAddToBasketData = $arItem['ADD_TO_BASKET_DATA'];?>
                    <div class="table-view__item item bordered box-shadow main_item_wrapper js-notice-block"
                         id="<?= $this->GetEditAreaId($arItem['ID']); ?>" data-id="<?= $arItem["ID"] ?>"
                         data-product_type="<?= $arItem["CATALOG_TYPE"] ?>">
                        <? if (isset($arItem["OFFERS"]) && $bUseSkuProps): ?>
                            <template class="offers-template-json">
                                <?= \Aspro\Max\Product\SkuTools::getOfferTreeJson($arItem["OFFERS"]) ?>
                            </template>
                            <? $bUseSelectOffer = true; ?>
                        <? endif; ?>
                        <? $bUseSelectOffer = true; ?>
                        <div class="table-view__item-wrapper item_info catalog-adaptive flexbox flexbox--row">

                            <? //image-block?>
                            <div class="item-foto">
                                <div class="item-foto__picture js-notice-block__image">
                                    <?php if ($arItem['PREVIEW_PICTURE']): ?>
                                        <? \Aspro\Functions\CAsproMaxItem::showImg($arParams, $arItem, !$bComplect); ?>
                                    <?php else: ?>
                                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="thumb"><img class="img-responsive " src="<?=SITE_TEMPLATE_PATH?>/images/empty_img_element.png" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" /></a>
                                    <?php endif; ?>
                                </div>
                                <div class="adaptive">
                                    <? \Aspro\Functions\CAsproMaxItem::showDelayCompareBtn(array_merge($arParams, $addParams), $arItem, $arAddToBasketData, $totalCount, $bUseSkuProps, 'block', ($arParams['USE_FAST_VIEW'] != 'N' && !$bComplect), false, '_small'); ?>
                                </div>
                            </div>
                            <div class="table-view__info flexbox inner_content js_offers__<?= $arItem['ID']; ?>_<?= $arParams["FILTER_HIT_PROP"] ?>">
                                <div class="table-view__info-wrapper flexbox flexbox--row">
                                    <? //text-block?>
                                    <div class="item-info table-view__info-top">
                                        <div class="item-title">
                                            <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"
                                               class="dark_link js-notice-block__title">
                                                <span><?= $elementName ?></span>
                                            </a>
                                        </div>
                                        <div class="item-card-location item-card-location--l">
                                            <?php if (!empty($arItem['CITY'])): ?>
                                                <div class="item-card-location__city">
                                                    <?= $arItem['CITY'] ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($arItem['ACTIVE_ELEMENT_FROM'])): ?>
                                                <div class="item-card-location__data">
                                                    <?= $arItem['ACTIVE_ELEMENT_FROM'] ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <? if ($arItem['DISPLAY_PROPERTIES'] && $bColProps): ?>
                                        <? foreach ($arResult['COLS_PROP'] as $key => $arProp): ?>
                                            <div class="table-view__item-wrapper-prop props hide-991">
                                                <? if ($arItem['DISPLAY_PROPERTIES'] && $arItem['DISPLAY_PROPERTIES'][$key]): ?>
                                                    <div class="properties__value darken font_sm font_short">
                                                        <? if (is_array($arItem['DISPLAY_PROPERTIES'][$key]["DISPLAY_VALUE"]) && count($arItem['DISPLAY_PROPERTIES'][$key]["DISPLAY_VALUE"]) > 1): ?>
                                                            <?= implode(', ', $arItem['DISPLAY_PROPERTIES'][$key]["DISPLAY_VALUE"]); ?>
                                                        <? else: ?>
                                                            <?= $arItem['DISPLAY_PROPERTIES'][$key]["DISPLAY_VALUE"]; ?>
                                                        <? endif; ?>
                                                    </div>
                                                <? endif; ?>
                                            </div>
                                        <? endforeach; ?>
                                    <? endif; ?>

                                    <div class="item-actions flexbox flexbox--row">
                                        <div class="product-description">
                                            <?php if (array_intersect($arResult['LEVEL_PARENTS'], SECTION_TYPE_1)): ?>
                                                <div class="product-description__left">
                                                    <div class="product-description__el">
                                                        <?php if (!empty($arItem['PROPERTIES']['power']['VALUE'])): ?>
                                                            <div class="product-description__i">
                                                                <?= $arItem['PROPERTIES']['power']['VALUE'] ?> см3
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if (!empty($arItem['PROPERTIES']['energy']['VALUE'])): ?>
                                                            <div class="product-description__i">
                                                                <?= $arItem['PROPERTIES']['energy']['VALUE'] ?> л.с.
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if (!empty($arItem['PROPERTIES']['cycles_number_' . $arParams['SECTION_CODE']]['VALUE'])): ?>
                                                            <div class="product-description__i">
                                                                <?= $arItem['PROPERTIES']['cycles_number_' . $arParams['SECTION_CODE']]['VALUE_ENUM'] ?>
                                                                <?= getPluralForm($arItem['PROPERTIES']['cycles_number_' . $arParams['SECTION_CODE']]['VALUE_ENUM'], ['такт', 'такта', 'тактов']) ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="product-description__el truncated">
                                                        <?php if (!empty($arItem['PROPERTIES']['cylinders_count_' . $arParams['SECTION_CODE']]['VALUE'])): ?>
                                                            <div class="product-description__i">
                                                                <?= $arItem['PROPERTIES']['cylinders_count_' . $arParams['SECTION_CODE']]['VALUE_ENUM'] ?>
                                                                <?= getPluralForm($arItem['PROPERTIES']['cylinders_count_' . $arParams['SECTION_CODE']]['VALUE_ENUM'], ['цилиндр', 'цилиндра', 'цилиндров']) ?>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if (!empty($arItem['PROPERTIES']['cylinder_place_' . $arParams['SECTION_CODE']]['VALUE'])): ?>
                                                            <div class="product-description__i">
                                                                <?= $arItem['PROPERTIES']['cylinder_place_' . $arParams['SECTION_CODE']]['VALUE_ENUM'] ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php if (!empty($arItem['PROPERTIES']['transmission']['VALUE'])): ?>
                                                        <div class="product-description__el">
                                                            <div class="product-description__i">
                                                                <?= $arItem['PROPERTIES']['transmission']['VALUE_ENUM'] ?>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="product-description__text">
                                                    <div class="wrapp_stockers sa_block"
                                                         data-fields='<?= Json::encode($arParams["FIELDS"]) ?>'
                                                         data-stores='<?= Json::encode($arParams["STORES"]) ?>'
                                                         data-user-fields='<?= Json::encode($arParams["USER_FIELDS"]) ?>'>
                                                        <? if ($arParams["SHOW_RATING"] == "Y"): ?>
                                                            <div class="rating sm-stars">
                                                                <?
                                                                global $arTheme;
                                                                if ($arParams['REVIEWS_VIEW']):?>
                                                                    <div class="blog-info__rating--top-info">
                                                                        <div class="votes_block nstar with-text">
                                                                            <div class="ratings">
                                                                                <? $message = $arItem['PROPERTIES']['EXTENDED_REVIEWS_COUNT']['VALUE'] ? GetMessage('VOTES_RESULT', array('#VALUE#' => $arItem['PROPERTIES']['EXTENDED_REVIEWS_RAITING']['VALUE'])) : GetMessage('VOTES_RESULT_NONE') ?>
                                                                                <div class="inner_rating"
                                                                                     title="<?= $message ?>">
                                                                                    <? for ($i = 1; $i <= 5; $i++): ?>
                                                                                        <div class="item-rating <?= $i <= $arItem['PROPERTIES']['EXTENDED_REVIEWS_RAITING']['VALUE'] ? 'filed' : '' ?>"><?= CMax::showIconSvg("star", SITE_TEMPLATE_PATH . "/images/svg/catalog/star_small.svg"); ?></div>
                                                                                    <? endfor; ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <? if ($arItem['PROPERTIES']['EXTENDED_REVIEWS_COUNT']['VALUE']): ?>
                                                                            <span class="font_sxs"><?= $arItem['PROPERTIES']['EXTENDED_REVIEWS_COUNT']['VALUE'] ?></span>
                                                                        <? endif; ?>
                                                                    </div>
                                                                <? else: ?>
                                                                    <? $APPLICATION->IncludeComponent(
                                                                        "bitrix:iblock.vote",
                                                                        "element_rating_front",
                                                                        array(
                                                                            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                                                            "IBLOCK_ID" => $arItem["IBLOCK_ID"],
                                                                            "ELEMENT_ID" => $arItem["ID"],
                                                                            "MAX_VOTE" => 5,
                                                                            "VOTE_NAMES" => array(),
                                                                            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                                                            "CACHE_TIME" => $arParams["CACHE_TIME"],
                                                                            "DISPLAY_AS_RATING" => 'vote_avg'
                                                                        ),
                                                                        $component, array("HIDE_ICONS" => "Y")
                                                                    ); ?>
                                                                <? endif; ?>
                                                            </div>
                                                        <? endif; ?>

                                                        <?php if (array_intersect($arResult['LEVEL_PARENTS'], SECTION_TYPE_4)): ?>
                                                            <div class="item-stock">
                                                                <span class="icon <?= $arItem['PROPERTIES']['status']['VALUE_XML_ID'] ?>"></span>
                                                                <span class="value font_sxs"><?= $arItem['PROPERTIES']['status']['VALUE'] ?></span>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if (!empty($arItem['PROPERTIES']['article_part']['VALUE']) && (array_intersect($arResult['LEVEL_PARENTS'], array_merge(SECTION_TYPE_2, SECTION_TYPE_4)))): ?>
                                                            <div class="article_block">
                                                                <div class="muted"><?= Loc::getMessage('ARTICLE_FULL'); ?>
                                                                    : <?= $arItem['PROPERTIES']['article_part']['VALUE']; ?>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php if (!empty($arItem['DETAIL_TEXT'])): ?>
                                                        <?php $class = (array_intersect($arResult['LEVEL_PARENTS'], SECTION_TYPE_3)) ? 'description-text--m' : '' ?>
                                                        <div class="description-text description-text--slim <?= $class ?>">
                                                            <?= $arItem['DETAIL_TEXT'] ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <? //prices-block?>
                                        <div class="info-data-price">
                                            <?php if (array_intersect($arResult['LEVEL_PARENTS'], SECTION_TYPE_1)): ?>
                                                <div class="item-data-card">
                                                    <?php if (!empty($arItem['PROPERTIES']['year']['VALUE'])): ?>
                                                        <div class="item-data-card__year">
                                                            <?= $arItem['PROPERTIES']['year']['VALUE'] ?> г.
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if (!empty($arItem['PROPERTIES']['race']['VALUE'])): ?>
                                                        <div class="item-data-card__kilometer">
                                                            <?= $arItem['PROPERTIES']['race']['VALUE'] ?> <?= $arItem['PROPERTIES']['race_unit']['VALUE_ENUM'] ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($arItem['PRICES_CUST'])): ?>
                                                <?php $isPriceContract = (!empty($arItem['PROPERTIES']['contract_price']['VALUE'])); ?>
                                                <div class="item-price">
                                                    <div class="cost prices clearfix">
                                                        <div class="price_matrix_wrapper ">
                                                            <div class="price font-bold font_mxs" data-currency="RUB"
                                                                 data-value="185826.2">
                                                            <span class="values_wrapper">
                                                                <span class="price_value">
                                                                    <?php if ($isPriceContract): ?>
                                                                        Договорная
                                                                    <?php else: ?>
                                                                        <?= $arItem['PRICES_CUST']['BASE'] ?>
                                                                    <?php endif; ?>
                                                                </span>
                                                            </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if (!$isPriceContract && !empty($arItem['PRICES_CUST']['CONVERT'])): ?>
                                                        <div class="prices-all">
                                                            <?php foreach ($arItem['PRICES_CUST']['CONVERT'] as $price): ?>
                                                                <div class="prices-all__i">≈ <?= $price ?></div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php endif; ?>

                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <? //icons-block?>
                                    <? if ($arResult['ICONS_SIZE']): ?>
                                        <div class="item-icons s_<?= $arResult['ICONS_SIZE'] ?>">
                                            <? \Aspro\Functions\CAsproMaxItem::showDelayCompareBtn(array_merge($arParams, $addParams), $arItem, $arAddToBasketData, $totalCount, $bUseSkuProps, 'list static icons long table-icons', false, false, '_small', $currentSKUID, $currentSKUIBlock); ?>
                                        </div>
                                    <? endif; ?>
                                </div>

                                <? if ($arItem["OFFERS"] && !$bOutOfProduction) { ?>
                                    <? if (!empty($arItem['OFFERS_PROP'])) { ?>
                                        <div class="table-view__sku-info-wrapper flexbox flexbox--row hide-600">
                                            <div class="sku_props list ce_cmp_hidden ">
                                                <div class="bx_catalog_item_scu wrapper_sku sku_in_section"
                                                     id="<? echo $arItemIDs["ALL_ITEM_IDS"]['PROP_DIV']; ?>"
                                                     data-site_id="<?= SITE_ID; ?>" data-id="<?= $arItem["ID"]; ?>"
                                                     data-offer_id="<?= $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["ID"]; ?>"
                                                     data-propertyid="<?= $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["PROPERTIES"]["CML2_LINK"]["ID"]; ?>"
                                                     data-offer_iblockid="<?= $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["IBLOCK_ID"]; ?>"
                                                     data-iblockid="<?= $arItem["IBLOCK_ID"]; ?>">
                                                    <? $arSkuTemplate = array(); ?>
                                                    <? $arSkuTemplate = CMax::GetSKUPropsArray($arItem['OFFERS_PROPS_JS'], $arResult["SKU_IBLOCK_ID"], $arParams["DISPLAY_TYPE"], $arParams["OFFER_HIDE_NAME_PROPS"], "N", $arItem, $arParams['OFFER_SHOW_PREVIEW_PICTURE_PROPS'], $arParams['MAX_SCU_COUNT_VIEW']); ?>
                                                    <? foreach ($arSkuTemplate as $code => $strTemplate) {
                                                        if (!isset($arItem['OFFERS_PROP'][$code]))
                                                            continue;
                                                        echo '<div class="item_wrapper">', str_replace('#ITEM#_prop_', $arItemIDs["ALL_ITEM_IDS"]['PROP'], $strTemplate), '</div>';
                                                    } ?>
                                                </div>
                                                <? $arItemJSParams = CMax::GetSKUJSParams($arResult, $arParams, $arItem); ?>
                                            </div>
                                        </div>
                                    <? } ?>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                <? } ?>
                <? if ($arParams["AJAX_REQUEST"] == "N"): ?>
            </div>
        </div>
    </div>
<? endif; ?>

    <? if ($arParams["AJAX_REQUEST"] == "Y"): ?>
    <div class="wrap_nav bottom_nav_wrapper">
        <? endif; ?>

        <? $showAllCount = false; ?>
        <? if ($arParams['IS_CATALOG_PAGE'] == 'Y' && $arParams['SECTION_COUNT_ELEMENTS'] == 'Y'): ?>
            <? if ((int)$arResult['NAV_RESULT']->NavRecordCount > 0): ?>
                <? $this->SetViewTarget("more_text_title"); ?>
                <span class="element-count-wrapper"><span
                            class="element-count muted font_xs rounded3"><?= $arResult['NAV_RESULT']->NavRecordCount; ?></span></span>
                <? $this->EndViewTarget(); ?>
                <?
                $showAllCount = true;
                $allCount = $arResult['NAV_RESULT']->NavRecordCount;
                ?>
            <? endif; ?>
        <? endif; ?>

        <div class="bottom_nav <?= $arParams["DISPLAY_TYPE"]; ?>" <?= ($showAllCount ? 'data-all_count="' . $allCount . '"' : '') ?> <?= ($arParams["AJAX_REQUEST"] == "Y" ? "style='display: none; '" : ""); ?>>
            <? if ($arParams["DISPLAY_BOTTOM_PAGER"] == "Y") { ?><?= $arResult["NAV_STRING"] ?><? } ?>
        </div>
        <? if ($arParams["AJAX_REQUEST"] == "Y"){ ?>
    </div>
<? } ?>

    <? if ($bUseSelectOffer): ?>
        <script>typeof useOfferSelect === 'function' && useOfferSelect()</script>
    <? endif; ?>

    <? //if($arParams["AJAX_REQUEST"]=="N"):?>
    <script><?if ($bColProps):?>var tableScrollerOb = new TableScroller('table-scroller-wrapper');<? endif; ?></script>
    <? //endif;?>

<? } else { ?>
    <div class="module_products_list_b">
        <div class="no_goods">
            <div class="no_products">
                <div class="wrap_text_empty">
                    <? if ($_REQUEST["set_filter"]) { ?>
                        <? $APPLICATION->IncludeFile(SITE_DIR . "include/section_no_products_filter.php", array(), array("MODE" => "html", "NAME" => GetMessage('EMPTY_CATALOG_DESCR'))); ?>
                    <? } else { ?>
                        <? $APPLICATION->IncludeFile(SITE_DIR . "include/section_no_products.php", array(), array("MODE" => "html", "NAME" => GetMessage('EMPTY_CATALOG_DESCR'))); ?>
                    <? } ?>
                </div>
            </div>
            <? if ($_REQUEST["set_filter"]) { ?>
                <span class="button wide btn btn-default"><?= GetMessage('RESET_FILTERS'); ?></span>
            <? } ?>
        </div>
    </div>
<? } ?>

<? \Aspro\Functions\CAsproMax::showBonusComponentList($arResult); ?>