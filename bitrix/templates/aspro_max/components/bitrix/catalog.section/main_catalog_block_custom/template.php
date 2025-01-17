<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? $this->setFrameMode(true); ?>
<? use \Bitrix\Main\Localization\Loc,
    \Bitrix\Main\Web\Json; ?>

<?php \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/catalog/section-list.css", ['GROUP' => 1000]); ?>
<?php \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/catalog/section-block.css", ['GROUP' => 1000]); ?>
<?php \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/catalog/section-table.css", ['GROUP' => 1000]); ?>
<?php
$ajax = false;
if ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') $ajax = true;
?>

<? $arParams["SHOW_HINTS"] = "N"; ?>
    <div class="maxwidth-theme only-on-front">
        <div class="tab_slider_wrapp">
            <div class="top_block">
                <h3><?=$arParams['BLOCK_TITLE']?></h3>
                <div class="right_block_wrapper" style="display: flex">
                    <?php if(!empty($arResult['TABS'])):?>
                    <div class="tabs-wrapper with_link arrow_scroll_init swipeignore" data-i-appeared="true" data-id="<?=$arParams['TABS_SECTION_ID']?>"
                         style="overflow: hidden; position: relative; max-width: 1436.3px;">
                        <ul class="tabs"
                            style="white-space: nowrap; min-width: auto; overflow: visible; z-index: 1; transform: translateX(0px);">
                            <?php foreach ($arResult['TABS'] as $key=>$tab):?>
                                <li data-code="<?=$tab['ID']?>" class="font_xs <?=($key === array_key_first($arResult['TABS'])) ? 'cur active' : ''?>"><span class="muted777"><?=$tab['NAME']?></span>
                                </li>
                            <?php endforeach;?>
                        </ul>
                        <div class="arrows_wrapper">
                            <div class="arrow arrow_left colored_theme_hover_text fill-dark-light-block disabled"
                                 style="top: -1px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8">
                                    <rect width="12" height="8" fill="#333" fill-opacity="0"></rect>
                                    <path d="M1015.69,507.693a0.986,0.986,0,0,1-1.4,0l-4.31-4.316-4.3,4.316a0.993,0.993,0,0,1-1.4-1.408l4.99-5.009a1.026,1.026,0,0,1,1.43,0l4.99,5.009A0.993,0.993,0,0,1,1015.69,507.693Z"
                                          fill="#333" transform="translate(-1004 -501)"></path>
                                </svg>
                            </div>
                            <div class="arrow arrow_right colored_theme_hover_text fill-dark-light-block disabled"
                                 style="top: -1px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8">
                                    <rect width="12" height="8" fill="#333" fill-opacity="0"></rect>
                                    <path d="M1015.69,507.693a0.986,0.986,0,0,1-1.4,0l-4.31-4.316-4.3,4.316a0.993,0.993,0,0,1-1.4-1.408l4.99-5.009a1.026,1.026,0,0,1,1.43,0l4.99,5.009A0.993,0.993,0,0,1,1015.69,507.693Z"
                                          fill="#333" transform="translate(-1004 -501)"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <?php endif;?>
                    <a href="<?=$arParams['ALL_ELEMENTS_URL']?>" class="font_upper muted"><?=$arParams['ALL_ELEMENTS_TITLE']?></a>
                </div>
            </div>
            <?php if ($ajax && $_POST['sectId']) {
                ob_end_clean();
            } ?>
            <div class="tabs-content active" data-code="<?=$arResult['TABS'][$arParams['SECTION_ID']]['ID']?>">
                <? if ($arResult["ITEMS"]): ?>
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
                    <?
                    $currencyList = '';
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

                    $bFastViewFull = \CMax::GetFrontParametrValue('SHOW_FULL_FAST_VIEW') == "Y" && $arParams['SHOW_GALLERY'] !== 'Y' && $arParams['SHOW_PROPS'] !== 'Y';

                    if ($fast_view_text_tmp = \CMax::GetFrontParametrValue('EXPRESSION_FOR_FAST_VIEW'))
                        $fast_view_text = $fast_view_text_tmp;
                    else
                        $fast_view_text = Loc::getMessage('FAST_VIEW');


                    $bHasBottomPager = $arParams["DISPLAY_BOTTOM_PAGER"] == "Y" && $arResult["NAV_STRING"];
                    ?>
                    <!-- items-container -->
                    <? if ($arParams["AJAX_REQUEST"] != "Y"): ?>
                    <? $bSlide = (isset($arParams['SLIDE_ITEMS']) && $arParams['SLIDE_ITEMS']); ?>
                    <? $bGiftblock = (isset($arParams['GIFT_ITEMS']) && $arParams['GIFT_ITEMS']); ?>
                    <? if (!$bSlide): ?>
                    <div class="js_wrapper_items load-offer-js"
                         data-params='<?= \Aspro\Max\Product\SkuTools::getSignedParams($arTransferParams) ?>'>
                        <? endif; ?>
                        <div class="top_wrapper items_wrapper <?= $templateName; ?>_template <?= $arParams['IS_COMPACT_SLIDER'] ? 'compact-catalog-slider' : '' ?>" style="position: relative">
                            <div class="fast_view_params"
                                 data-params="<? //=urlencode(serialize($arTransferParams));?>"></div>
                            <div class="catalog_block items row <?= $arParams['IS_COMPACT_SLIDER'] ? 'swipeignore mobile-overflow' : '' ?> margin0 <?= $bHasBottomPager ? 'has-bottom-nav' : '' ?> js_append ajax_load block flexbox<?= ($bSlide ? ' owl-carousel owl-theme owl-bg-nav visible-nav short-nav hidden-dots swipeignore ' : ''); ?>"
                                 <? if ($bSlide): ?>data-plugin-options='{"nav": true, "autoplay" : false,  "autoplayTimeout" : "3000", "smartSpeed":1000, <?= (count($arResult["ITEMS"]) > 4 ? "\"loop\": true," : "") ?> "responsiveClass": true, "responsive":{"0":{"items": 2},"600":{"items": 2},"768":{"items": 3},"1200":{"items": 4}}}'<? endif; ?>>
                                <? endif; ?>
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
                                    $arQuantityData = CMax::GetQuantityArray($totalCount, array('ID' => $item_id), 'N', (($arItem["OFFERS"] || $arItem['CATALOG_TYPE'] == CCatalogProduct::TYPE_SET || $bSlide || !$arResult['STORES_COUNT']) ? false : true));

                                    if (isset($arParams['ID_FOR_TABS']) && $arParams['ID_FOR_TABS'] == 'Y') {
                                        $arItem["strMainID"] = $this->GetEditAreaId($arItem['ID']) . "_" . $arParams["FILTER_HIT_PROP"];
                                    } else {
                                        $arItem["strMainID"] = $this->GetEditAreaId($arItem['ID']);
                                    }

                                    $arItemIDs = CMax::GetItemsIDs($arItem);

                                    if ($arParams["SHOW_MEASURE"] == "Y" && $arItem["CATALOG_MEASURE"]) {
                                        if (isset($arItem["ITEM_MEASURE"]) && (is_array($arItem["ITEM_MEASURE"]) && $arItem["ITEM_MEASURE"]["TITLE"])) {
                                            $strMeasure = $arItem["ITEM_MEASURE"]["TITLE"];
                                        } else {
                                            $arMeasure = CCatalogMeasure::getList(array(), array("ID" => $arItem["CATALOG_MEASURE"]), false, false, array())->GetNext();
                                            $strMeasure = $arMeasure["SYMBOL_RUS"];
                                        }
                                    }
                                    $bBigBlock = ($arItem['PROPERTIES']['BIG_BLOCK']['VALUE'] == 'Y' && $arParams['SHOW_BIG_BLOCK'] != 'N');

                                    $bUseSkuProps = ($arItem["OFFERS"] && !empty($arItem['OFFERS_PROP']) && !$bBigBlock && $arParams['TYPE_SKU'] != 'N');

                                    $elementName = ((isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arItem['NAME']);

                                    if ($bUseSkuProps) {
                                        if (!$arItem["OFFERS"]) {
                                            $arAddToBasketData = CMax::GetAddToBasketArray($arItem, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, $arItemIDs["ALL_ITEM_IDS"], 'btn-exlg', $arParams);
                                        } elseif ($arItem["OFFERS"]) {

                                            $currentSKUIBlock = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["IBLOCK_ID"];
                                            $currentSKUID = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["ID"];
                                            $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["IS_OFFER"] = "Y";

                                            //$totalCountCMP = CMax::GetTotalCount($arItem, $arParamsCE_CMP);
                                            $totalCountCMP = $totalCount;
                                            $arQuantityDataCMP = CMax::GetQuantityArray($totalCountCMP, array('ID' => $item_id), 'N', false, 'ce_cmp_visible');

                                            $strMeasure = $arItem["MIN_PRICE"]["CATALOG_MEASURE_NAME"];
                                            $totalCount = CMax::GetTotalCount($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]], $arParams);
                                            $arQuantityData = CMax::GetQuantityArray($totalCount, array('ID' => $currentSKUID), 'N', (($arItem['CATALOG_TYPE'] == CCatalogProduct::TYPE_SET || $bSlide || !$arResult['STORES_COUNT']) ? false : true), 'ce_cmp_hidden');

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

                                            $arAddToBasketData = CMax::GetAddToBasketArray($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]], $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, $arItemIDs["ALL_ITEM_IDS"], 'btn-exlg', $arParams);

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
                                        $arAddToBasketData = CMax::GetAddToBasketArray($arItem, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, array(), 'btn-exlg', $arParams);
                                    }

                                    switch ($arParams["LINE_ELEMENT_COUNT"]) {
                                        case '4':
                                            $col = ($bBigBlock ? 6 : 3);
                                            break;
                                        case '3':
                                            $col = 4;
                                            break;
                                        default:
                                            $col = ($bBigBlock ? 40 : 20);
                                            break;
                                    }
                                    if ($arParams["SET_LINE_ELEMENT_COUNT"]) {
                                        if ($arParams["LINE_ELEMENT_COUNT"] == 5) {
                                            $col = '5_2';
                                        }
                                    }
                                    ?>
                                    <? if ($bBigBlock): ?>
                                        <div class="item hidden">
                                            <div class="catalog_item_wrapp catalog_item">
                                                <div class="item_info">
                                                    <div class="item-title"></div>
                                                    <div class="sa_block"></div>
                                                </div>
                                            </div>
                                        </div>
                                    <? endif; ?>

                                    <? $bFonImg = false; ?>
                                    <? if ($bBigBlock): ?>
                                        <? if ($arItem["PROPERTIES"]["BIG_BLOCK_PICTURE"]["VALUE"]) {
                                            $img = \CFile::ResizeImageGet($arItem["PROPERTIES"]["BIG_BLOCK_PICTURE"]["VALUE"], array("width" => 900, "height" => 900), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                                            $imageSrc = $img["src"];
                                            $bFonImg = true;
                                        } elseif (!empty($arItem["DETAIL_PICTURE"])) {
                                            $img = \CFile::ResizeImageGet($arItem["DETAIL_PICTURE"], array("width" => 600, "height" => 600), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                                            $imageSrc = $img["src"];
                                        } elseif (!empty($arItem["PREVIEW_PICTURE"])) {
                                            $imageSrc = $arItem["PREVIEW_PICTURE"]["SRC"];
                                        } else {
                                            $imageSrc = SITE_TEMPLATE_PATH . '/images/svg/noimage_product.svg';
                                        } ?>
                                    <? endif; ?>

                                    <? ob_start(); ?>
                                    <? if ($arParams["SHOW_RATING"] == "Y"): ?>
                                        <div class="rating">
                                            <? $frame = $this->createFrame('dv_' . $arItem["ID"])->begin(''); ?>
                                            <?
                                            global $arTheme;
                                            if ($arParams['REVIEWS_VIEW']):?>
                                                <div class="blog-info__rating--top-info">
                                                    <div class="votes_block nstar with-text">
                                                        <div class="ratings">
                                                            <? $message = $arItem['PROPERTIES']['EXTENDED_REVIEWS_COUNT']['VALUE'] ? GetMessage('VOTES_RESULT', array('#VALUE#' => $arItem['PROPERTIES']['EXTENDED_REVIEWS_RAITING']['VALUE'])) : GetMessage('VOTES_RESULT_NONE') ?>
                                                            <div class="inner_rating" title="<?= $message ?>">
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
                                            <? $frame->end(); ?>
                                        </div>
                                    <? endif; ?>
                                    <? $itemRating = ob_get_clean(); ?>


                                    <? ob_start(); ?>
                                    <?php if (array_intersect($arResult['LEVEL_PARENTS'], SECTION_TYPE_1)): ?>
                                        <div class="item_info_product">
                                            <?= (!empty($arItem['PROPERTIES']['year']['VALUE'])) ? $arItem['PROPERTIES']['year']['VALUE'] . ', ' : '' ?> <?= $arItem['PROPERTIES']['race']['VALUE'] ?> <?= $arItem['PROPERTIES']['race_unit']['VALUE_ENUM'] ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="sa_block " data-fields='<?= Json::encode($arParams["FIELDS"]) ?>'
                                             data-stores='<?= Json::encode($arParams["STORES"]) ?>'
                                             data-user-fields='<?= Json::encode($arParams["USER_FIELDS"]) ?>'>
                                            <?php if (array_intersect($arResult['LEVEL_PARENTS'], SECTION_TYPE_4) && !empty($arItem['PROPERTIES']['status']['VALUE_XML_ID'])): ?>
                                                <div class="item-stock">
                                                    <span class="icon <?= $arItem['PROPERTIES']['status']['VALUE_XML_ID'] ?>"></span>
                                                    <span class="value font_sxs"><?= $arItem['PROPERTIES']['status']['VALUE'] ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($arItem['PROPERTIES']['article_part']['VALUE']) && (array_intersect($arResult['LEVEL_PARENTS'], array_merge(SECTION_TYPE_2, SECTION_TYPE_4)))): ?>
                                                <div class="article_block">
                                                    <div class="muted font_sxs"><?= Loc::getMessage('ARTICLE_FULL'); ?>
                                                        : <?= $arItem['PROPERTIES']['article_part']['VALUE']; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>

                                    <? $itemSaBlock = ob_get_clean(); ?>

                                    <? ob_start(); ?>
                                    <div class="item-title">
                                        <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"
                                           class="<?= $bBigBlock && $bFonImg ? '' : 'dark_link' ?> js-notice-block__title option-font-bold font_sm"><span><?= $elementName; ?></span></a>
                                    </div>
                                    <? $itemTitle = ob_get_clean(); ?>

                                    <? ob_start(); ?>
                                    <? if ($arItem["PROPERTIES"]["SUB_TITLE"]["VALUE"]): ?>
                                        <div class="preview_text muted font_xs">
                                            <? if (!is_array($arItem["PROPERTIES"]["SUB_TITLE"]['~VALUE'])): ?>
                                                <?= $arItem["PROPERTIES"]["SUB_TITLE"]["VALUE"]; ?>
                                            <? else: ?>
                                                <?= $arItem["PROPERTIES"]["SUB_TITLE"]["~VALUE"]["TEXT"]; ?>
                                            <? endif ?>
                                        </div>
                                    <? endif; ?>
                                    <? $itemSubTitle = ob_get_clean(); ?>

                                    <? ob_start(); ?>
                                    <?php $isPriceContract = (!empty($arItem['PROPERTIES']['contract_price']['VALUE'])); ?>
                                    <?php if (!empty($arItem['PRICES_CUST'])): ?>
                                        <div class="cost prices clearfix<?= $arParams['TYPE_VIEW_BASKET_BTN'] === 'TYPE_2' && !$bBigBlock ? ' prices--with_icons_block' : '' ?>">
                                            <div class="price_matrix_wrapper prices-row">
                                                <div class="price font-bold font_mxs">
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
                                                <?php if (!$isPriceContract && !empty($arItem['PRICES_CUST'])): ?>
                                                    <div class="price-dollar">
                                                        ≈ <?= $arItem['PRICES_CUST']['CONVERT']['USD'] ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <? \Aspro\Functions\CAsproMax::showBonusBlockList($arCurrentSKU ?: $arItem); ?>
                                    <? $itemPrice = ob_get_clean(); ?>

                                    <? ob_start(); ?>
                                    <div class="footer_button <?= ($arItem["OFFERS"] && $arItem['OFFERS_PROP'] ? 'has_offer_prop' : ''); ?> inner_content js_offers__<?= $arItem['ID']; ?>_<?= $arParams["FILTER_HIT_PROP"] ?><?= ($arParams["TYPE_VIEW_BASKET_BTN"] == "TYPE_2" ? ' n-btn' : '') ?>">
                                        <? if (!$bOutOfProduction): ?>
                                            <div class="sku_props ce_cmp_hidden">
                                                <? if ($arItem["OFFERS"] && count($arItem["OFFERS"]) > 1) {
                                                    if (!empty($arItem['OFFERS_PROP'])) {
                                                        ?>
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
                                                        <?
                                                    }
                                                } ?>
                                            </div>
                                        <? endif; ?>
                                    </div>
                                    <? $itemFooterButton = ob_get_clean(); ?>

                                    <? ob_start(); ?>
                                    <? if ($arParams["SHOW_DISCOUNT_TIME"] == "Y" && $arParams['SHOW_COUNTER_LIST'] != 'N') { ?>
                                        <? $min_price_id = 0;
                                        if ($arItem["OFFERS"]) {
                                            if ($arCurrentSKU && isset($arCurrentSKU['PRICE_MATRIX']) && $arCurrentSKU['PRICE_MATRIX']) // USE_PRICE_COUNT
                                            {
                                                if (isset($arCurrentSKU['PRICE_MATRIX']['MATRIX']) && is_array($arCurrentSKU['PRICE_MATRIX']['MATRIX'])) {
                                                    $arMatrixKey = array_keys($arCurrentSKU['PRICE_MATRIX']['MATRIX']);
                                                    $min_price_id = current($arMatrixKey);
                                                }
                                            }
                                        } else {
                                            if (isset($arItem['PRICE_MATRIX']) && $arItem['PRICE_MATRIX']) // USE_PRICE_COUNT
                                            {
                                                $arMatrixKey = array_keys($arItem['PRICE_MATRIX']['MATRIX']);
                                                $min_price_id = current($arMatrixKey);
                                            }
                                        } ?>
                                        <? $arDiscount = [] ?>
                                        <? \Aspro\Functions\CAsproMax::showDiscountCounter($totalCount, $arDiscount, $arQuantityData, $arItem, $strMeasure, 'v2 grey', $item_id, true); ?>
                                    <? } ?>
                                    <? $itemDiscountTime = ob_get_clean(); ?>
                                    <div class="col-lg-<?= $col; ?><? if ($bBigBlock): ?> col-md-8 col-sm-12 col-xs-12<? else: ?> col-md-4 col-sm-6 col-xs-6<? endif; ?> col-xxs-12 item item-parent catalog-block-view__item js-notice-block item_block<?= ($bBigBlock ? ' big' : ''); ?> <?= ($arParams['SET_LINE_ELEMENT_COUNT'] ? 'custom-line' : ''); ?> <?= $bComplect ? 'complect_item' : '' ?>"
                                         data-id="<?= $arItem["ID"] ?>" <?= $arParams['BIG_DATA_MODE'] === "Y" ? "data-bigdata=Y" : "" ?>
                                         data-product_type="<?= $arItem["CATALOG_TYPE"] ?>">
                                        <div class="basket_props_block"
                                             id="bx_basket_div_<?= $arItem["ID"]; ?>_<?= $arParams["FILTER_HIT_PROP"] ?>"
                                             style="display: none;">
                                            <? if (!empty($arItem['PRODUCT_PROPERTIES_FILL'])) {
                                                foreach ($arItem['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo):?>
                                                    <input type="hidden"
                                                           name="<?= $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<?= $propID; ?>]"
                                                           value="<?= htmlspecialcharsbx($propInfo['ID']); ?>">
                                                <?endforeach;
                                            }
                                            if (!$emptyProductProperties) {
                                                ?>
                                                <div class="wrapper">
                                                    <table>
                                                        <? foreach ($arItem['PRODUCT_PROPERTIES'] as $propID => $propInfo) {
                                                            ?>
                                                            <tr>
                                                                <td><? echo $arItem['PROPERTIES'][$propID]['NAME']; ?></td>
                                                                <td>
                                                                    <? if ('L' == $arItem['PROPERTIES'][$propID]['PROPERTY_TYPE'] && 'C' == $arItem['PROPERTIES'][$propID]['LIST_TYPE']) {
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
                                            <? } ?>
                                        </div>

                                        <div class="catalog_item_wrapp catalog_item item_wrap main_item_wrapper<?= ($bBigBlock ? ' big' : ''); ?> <?= ($bFonImg ? '' : ' product_image') ?> <?= ($arItem["OFFERS"] ? 'has-sku' : '') ?>"
                                             id="<?= $arItem["strMainID"] ?>">
                                            <? if (isset($arItem["OFFERS"]) && $bUseSkuProps): ?>
                                                <template class="offers-template-json">
                                                    <?= \Aspro\Max\Product\SkuTools::getOfferTreeJson($arItem["OFFERS"]) ?>
                                                </template>
                                                <? $bUseSelectOffer = true; ?>
                                            <? endif; ?>
                                            <? $bUseSelectOffer = true; ?>
                                            <div class="inner_wrap <?= $arParams["TYPE_VIEW_BASKET_BTN"] ?>">
                                                <? if (isset($arParams["COMPLECT_MODE"]) && $arParams["COMPLECT_MODE"] == "Y"): ?>
                                                    <div class="item_block__complect-checkbox filter label_block">
                                                        <input type="checkbox" class="complect_checkbox_item"
                                                               name="chec_item"
                                                               id=<?= $arItem["strMainID"] . "_complect" ?>>
                                                        <label for=<?= $arItem["strMainID"] . "_complect" ?>></label>
                                                    </div>
                                                <? endif; ?>
                                                <? if ($arParams['SHOW_GALLERY'] == 'Y' && $arItem['OFFERS']): ?>
                                                    <div class="js-item-gallery hidden"><? \Aspro\Functions\CAsproMaxItem::showSectionGallery(array('ITEM' => $arItem, 'RESIZE' => $arResult['CUSTOM_RESIZE_OPTIONS'])); ?></div>
                                                <? endif; ?>
                                                <? if ($bBigBlock): ?>
                                                    <? if ($bFonImg): ?>
                                                        <a class="absolute-full-block lazy absolute-full-block_bg_center darken-bg-animate"
                                                           href="<?= $arItem['DETAIL_PAGE_URL']; ?>"
                                                           data-src="<?= $imageSrc ?>"
                                                           data-bg="<?= $imageSrc ?>"
                                                           style="background-image:url(<?= \Aspro\Functions\CAsproMax::showBlankImg($imageSrc); ?>)"><span></span></a>
                                                    <? endif; ?>
                                                <? endif; ?>
                                                <div class="image_wrapper_block js-notice-block__image <?= ($arParams['SHOW_PROPS'] == 'Y' && $arItem['DISPLAY_PROPERTIES'] && !$bBigBlock ? ' with-props' : ''); ?>">
                                                    <? \Aspro\Functions\CAsproMaxItem::showStickers($arParams, $arItem, true); ?>
                                                    <? if ($arParams['TYPE_VIEW_BASKET_BTN'] == 'TYPE_3'): ?>
                                                        <? if (!$bFastViewFull): ?><div class="like_icons block ce_cmp_hidden"><? endif; ?>
                                                        <? if (!$bComplect): ?>
                                                            <div class="fast_view_button <?= $bFastViewFull ? 'fast_view_button--full fast_view_button--center' : '' ?>">
                                                <span title="<?= $fast_view_text ?>"
                                                      class="rounded3 <?= $bFastViewFull ? 'font_upper_xs' : 'colored_theme_hover_bg' ?> "
                                                      data-event="jqm" data-param-form_id="fast_view"
                                                      data-param-iblock_id="<?= $arParams["IBLOCK_ID"]; ?>"
                                                      data-param-id="<?= $arItem["ID"]; ?>"
                                                      data-param-item_href="<?= urlencode($arItem["DETAIL_PAGE_URL"]); ?>"
                                                      data-name="fast_view"><?= \CMax::showIconSvg($bFastViewFull ? "fw " : "fw ncolor colored", SITE_TEMPLATE_PATH . "/images/svg/quickview" . $typeSvg . ".svg"); ?><?= $bFastViewFull ? $fast_view_text : '' ?></span>
                                                            </div>
                                                        <? endif; ?>
                                                        <? if (!$bFastViewFull): ?></div><? endif; ?>
                                                        <div class="ce_cmp_visible">
                                                            <!--									--><? //\Aspro\Functions\CAsproMaxItem::showDelayCompareBtn(array_merge($arParams, $addParams), $arItem, $arAddToBasketData, $totalCount, $bUseSkuProps, 'block', ($arParams['USE_FAST_VIEW'] != 'N'), ($arParams['SHOW_ONE_CLICK_BUY'] == 'Y' && !$bComplect), '_small', $currentSKUID, $currentSKUIBlock);?>
                                                        </div>
                                                    <? else: ?>
                                                        <? if ($bFastViewFull && $arParams['USE_FAST_VIEW'] != 'N' && !$bComplect): ?>
                                                            <div class="fast_view_button fast_view_button--full">
                                                <span title="<?= $fast_view_text ?>" class="rounded2 font_upper_xs"
                                                      data-event="jqm" data-param-form_id="fast_view"
                                                      data-param-iblock_id="<?= $arParams["IBLOCK_ID"]; ?>"
                                                      data-param-id="<?= $arItem["ID"]; ?>"
                                                      data-param-item_href="<?= urlencode($arItem["DETAIL_PAGE_URL"]); ?>"
                                                      data-name="fast_view"><?= \CMax::showIconSvg("fw ", SITE_TEMPLATE_PATH . "/images/svg/quickview" . $typeSvg . ".svg"); ?><?= $fast_view_text ?></span>
                                                            </div>
                                                        <? endif; ?>
                                                        <? \Aspro\Functions\CAsproMaxItem::showDelayCompareBtn(array_merge($arParams, $addParams), $arItem, $arAddToBasketData, $totalCount, $bUseSkuProps, 'block', ($arParams['USE_FAST_VIEW'] != 'N' && !$bComplect && !$bFastViewFull), ($arParams['SHOW_ONE_CLICK_BUY'] == 'Y' && !$bComplect), '_small', $currentSKUID, $currentSKUIBlock); ?>
                                                    <? endif; ?>
                                                    <? if (!$bBigBlock): ?>
                                                        <? if ($arParams['SHOW_PROPS'] == 'Y' && $arItem['DISPLAY_PROPERTIES']): ?>
                                                            <div class="properties properties_absolute scrollblock">
                                                                <div class="properties__container">
                                                                    <? foreach ($arItem['DISPLAY_PROPERTIES'] as $arProp): ?>
                                                                        <div class="properties__item">
                                                                            <div class="properties__title font_sxs muted">
                                                                                <?= $arProp['NAME'] ?>
                                                                                <? if ($arProp["HINT"] && $arParams["SHOW_HINTS"] == "Y"): ?>
                                                                                    <div class="hint"><span
                                                                                                class="icon colored_theme_hover_bg"><i>?</i></span>
                                                                                        <div class="tooltip"><?= $arProp["HINT"] ?></div>
                                                                                    </div>
                                                                                <? endif; ?>
                                                                            </div>

                                                                            <div class="properties__value font_sm darken">
                                                                                <?
                                                                                if (is_array($arProp["DISPLAY_VALUE"])) {
                                                                                    foreach ($arProp["DISPLAY_VALUE"] as $key => $value) {
                                                                                        if ($arProp["DISPLAY_VALUE"][$key + 1]) {
                                                                                            echo $value . ", ";
                                                                                        } else {
                                                                                            echo $value;
                                                                                        }
                                                                                    }
                                                                                } else {
                                                                                    echo $arProp["DISPLAY_VALUE"];
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    <? endforeach; ?>
                                                                </div>
                                                                <div class="properties__container properties__container_js">
                                                                    <? if ($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['DISPLAY_PROPERTIES']): ?>
                                                                        <? foreach ($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['DISPLAY_PROPERTIES'] as $arProp): ?>
                                                                            <div class="properties__item">
                                                                                <div class="properties__title font_sxs muted"><?= $arProp['NAME'] ?></div>
                                                                                <div class="properties__value font_sm darken">
                                                                                    <?
                                                                                    if (is_array($arProp["DISPLAY_VALUE"])) {
                                                                                        foreach ($arProp["DISPLAY_VALUE"] as $key => $value) {
                                                                                            if ($arProp["DISPLAY_VALUE"][$key + 1]) {
                                                                                                echo $value . ", ";
                                                                                            } else {
                                                                                                echo $value;
                                                                                            }
                                                                                        }
                                                                                    } else {
                                                                                        echo $arProp["DISPLAY_VALUE"];
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        <? endforeach; ?>
                                                                    <? endif; ?>
                                                                </div>
                                                            </div>
                                                        <? endif; ?>
                                                        <?= $itemDiscountTime ?>
                                                        <? if ($arParams['SHOW_GALLERY'] == 'Y' && $arParams['SHOW_PROPS'] != 'Y'): ?>
                                                            <? if ($bUseSkuProps && $arItem["OFFERS"]): ?>
                                                                <? \Aspro\Functions\CAsproMaxItem::showSectionGallery(array('ITEM' => $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]], 'RESIZE' => $arResult['CUSTOM_RESIZE_OPTIONS'])); ?>
                                                            <? else: ?>
                                                                <?php if ($arItem['PREVIEW_PICTURE']): ?>
                                                                    <? \Aspro\Functions\CAsproMaxItem::showSectionGallery(array('ITEM' => $arItem, 'RESIZE' => $arResult['CUSTOM_RESIZE_OPTIONS'])); ?>
                                                                <?php else: ?>
                                                                    <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"
                                                                       class="thumb"><img class="img-responsive "
                                                                                          src="<?= SITE_TEMPLATE_PATH ?>/images/empty_img_element.png"
                                                                                          alt="<?= $arItem["NAME"] ?>"
                                                                                          title="<?= $arItem["NAME"] ?>"/></a>
                                                                <?php endif; ?>
                                                            <? endif; ?>
                                                        <? else: ?>
                                                            <? \Aspro\Functions\CAsproMaxItem::showImg($arParams, $arItem, false); ?>
                                                        <? endif; ?>
                                                    <? else: ?>
                                                        <? if ($bFonImg): ?>
                                                            <div class="ce_cmp_visible">
                                                        <? endif; ?>
                                                        <? \Aspro\Functions\CAsproMaxItem::showImg($arParams, $arItem, false); ?>
                                                        <? if ($bFonImg): ?>
                                                            </div>
                                                        <? endif; ?>
                                                        <?= $itemDiscountTime ?>
                                                    <? endif; ?>
                                                </div>

                                                <? if ($bBigBlock): ?>
                                                    <div class="item_info flexbox flexbox--row justify-content-between flex-wrap">
                                                        <div class="item_info--left_block">
                                                            <div class="top_info flexbox flexbox--row flex-wrap">
                                                                <?= $itemRating ?>
                                                                <?= $itemSaBlock ?>
                                                                <?= $itemTitle ?>
                                                            </div>
                                                        </div>
                                                        <div class="item_info--right_block">
                                                            <?= $itemPrice ?>
                                                        </div>
                                                    </div>
                                                <? else: ?>
                                                    <div class="item_info">
                                                        <div class="item_info--top_block">
                                                            <?= $itemRating ?>
                                                            <?= $itemTitle ?>
                                                            <?= $itemSubTitle ?>
                                                            <?= $itemSaBlock ?>
                                                        </div>
                                                        <div class="item_info--bottom_block">
                                                            <?= $itemPrice ?>
                                                        </div>
                                                    </div>
                                                <? endif; ?>

                                                <? if (!$bBigBlock): ?>
                                                    <?= $itemFooterButton ?>
                                                <? endif; ?>
                                            </div>

                                            <? if ($bBigBlock): ?>
                                                <?= $itemFooterButton ?>
                                            <? endif; ?>
                                        </div>
                                    </div>
                                <? } ?>

                                <? if ($arParams['IS_COMPACT_SLIDER'] && $bHasBottomPager): ?>
                                    <? if ($arParams["AJAX_REQUEST"] == "Y"): ?>
                                        <div class="wrap_nav bottom_nav_wrapper">
                                    <? endif; ?>

                                    <div class="bottom_nav mobile_slider animate-load-state block-type round-ignore"
                                         data-parent=".tabs_slider"
                                         data-append=".items" <?= ($arParams["AJAX_REQUEST"] == "Y" ? "style='display: none; '" : ""); ?>>
                                        <?= CMax::showIconSvg('bottom_nav-icon colored_theme_svg', SITE_TEMPLATE_PATH . '/images/svg/mobileBottomNavLoader.svg'); ?>
                                        <?= $arResult["NAV_STRING"] ?>
                                    </div>

                                    <? if ($arParams["AJAX_REQUEST"] == "Y"): ?>
                                        </div>
                                    <? endif; ?>
                                <? endif; ?>

                                <? if ($bUseSelectOffer): ?>
                                    <script>typeof useOfferSelect === 'function' && useOfferSelect()</script>
                                <? endif; ?>

                                <? if ($arParams["AJAX_REQUEST"] != "Y"): ?>
                                <? if (!$bSlide): // close js_wrapper_items           ?>
                                <!-- items-container -->
                            </div>
                            <? endif; ?>
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

                        <div class="bottom_nav animate-load-state block-type" <?= ($showAllCount ? 'data-all_count="' . $allCount . '"' : '') ?>
                             data-parent=".tabs_slider"
                             data-append=".items" <?= ($arParams["AJAX_REQUEST"] == "Y" ? "style='display: none; '" : ""); ?>>
                            <? if ($arParams["DISPLAY_BOTTOM_PAGER"] == "Y") { ?><?= $arResult["NAV_STRING"] ?><? } ?>
                        </div>


                        <? if ($arParams["AJAX_REQUEST"] == "Y"): ?>
                    </div>
                <? endif; ?>

                    <script>
                        // lazyLoadPagenBlock();
                        <?if($bSlide):?>
                        sliceItemBlockSlide();
                        <?else:?>
                        sliceItemBlock();
                        <?endif;?>
                    </script>
                <? elseif ($arParams['IS_CATALOG_PAGE'] == 'Y'): ?>
                    <div class="no_goods catalog_block_view">
                        <div class="no_products">
                            <div class="wrap_text_empty">
                                <? if ($_REQUEST["set_filter"]) { ?>
                                    <? $APPLICATION->IncludeFile(SITE_DIR . "include/section_no_products_filter.php", array(), array("MODE" => "html", "NAME" => GetMessage('EMPTY_CATALOG_DESCR'))); ?>
                                <? } else { ?>
                                    <? $APPLICATION->IncludeFile(SITE_DIR . "include/section_no_products.php", array(), array("MODE" => "html", "NAME" => GetMessage('EMPTY_CATALOG_DESCR'))); ?>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                <? endif; ?>
            </div>
            <?php if ($ajax && $_POST['sectId']) {
                die();
            } ?>
        </div>
    </div>
<? if ($arParams['BIG_DATA_MODE'] === "Y"): ?>

    <? $signer = new \Bitrix\Main\Security\Sign\Signer; ?>
    <script>
        setBigData({
            siteId: '<?=CUtil::JSEscape($component->getSiteId())?>',
            componentPath: '<?=CUtil::JSEscape($componentPath)?>',
            params: <?=CUtil::PhpToJSObject($arParams)?>,
            bigData: <?=CUtil::PhpToJSObject($arResult['BIG_DATA'])?>,
            template: '<?=CUtil::JSEscape($signer->sign($templateName, 'catalog.section'))?>',
            parameters: '<?=CUtil::JSEscape($signer->sign(base64_encode(serialize($arResult['ORIGINAL_PARAMETERS'])), 'catalog.section'))?>',
            wrapper: '.bigdata-wrapper',
            countBigdata: '<?=CUtil::JSEscape($arParams['BIGDATA_COUNT_BOTTOM'])?>'
        });
    </script>
<? endif; ?>

<? \Aspro\Functions\CAsproMax::showBonusComponentList($arResult); ?>