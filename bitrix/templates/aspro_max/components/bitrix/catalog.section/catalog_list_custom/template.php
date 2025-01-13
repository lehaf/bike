<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? $this->setFrameMode(true); ?>
<? use \Bitrix\Main\Localization\Loc,
    \Bitrix\Main\Web\Json; ?>
<?php \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/catalog/section-list.css", ['GROUP' => 1000]); ?>
<?php \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/catalog/section-block.css", ['GROUP' => 1000]); ?>
<?php \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/catalog/section-table.css", ['GROUP' => 1000]); ?>
<? if (count($arResult["ITEMS"]) >= 1) { ?>
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
    <? if ($arParams["AJAX_REQUEST"] == "N"){ ?>
    <div class="js_wrapper_items load-offer-js"
         data-params='<?= \Aspro\Max\Product\SkuTools::getSignedParams($arTransferParams) ?>'>
        <div class="display_list <?= ($arParams["SHOW_UNABLE_SKU_PROPS"] != "N" ? "show_un_props" : "unshow_un_props"); ?> js_append <?= $arParams["TYPE_VIEW_CATALOG_LIST"]; ?>  flexbox flexbox--row">
            <? } ?>
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

            $arParams["BASKET_ITEMS"] = ($arParams["BASKET_ITEMS"] ? $arParams["BASKET_ITEMS"] : array());

            $arOfferProps = implode(';', $arParams['OFFERS_CART_PROPERTIES']);

            $bNormalView = ($arParams["TYPE_VIEW_CATALOG_LIST"] == "TYPE_1");

            // params for catalog elements compact view
            $arParamsCE_CMP = $arParams;
            $arParamsCE_CMP['TYPE_SKU'] = 'N';

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

                $arItem["strMainID"] = $this->GetEditAreaId($arItem['ID']);
                $arItemIDs = CMax::GetItemsIDs($arItem);

                $totalCount = CMax::GetTotalCount($arItem, $arParams);
                $arQuantityData = CMax::GetQuantityArray($totalCount, array('ID' => $item_id), 'N', (($arItem["OFFERS"] || $arItem['CATALOG_TYPE'] == CCatalogProduct::TYPE_SET || $bSlide || !$arResult['STORES_COUNT']) ? false : true));

                $strMeasure = '';
                $arAddToBasketData = array();

                $arCurrentSKU = array();

                $bComplect = $arItem["PROPERTIES"]["PRODUCT_SET"]["VALUE"] === "Y";
                $addParams = array();
                if ($bComplect) {
                    $addParams = array("DISPLAY_WISH_BUTTONS" => "N", "MESSAGE_FROM" => Loc::getMessage('FROM') . ' ');
                    $arItem["SHOW_FROM_LANG"] = "Y";
                }

                $elementName = ((isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arItem['NAME']);

                $bUseSkuProps = ($arItem["OFFERS"] && !empty($arItem['OFFERS_PROP']));

                if (!$arItem["OFFERS"] || $arParams['TYPE_SKU'] !== 'TYPE_1') {
                    if ($arParams["SHOW_MEASURE"] == "Y" && $arItem["CATALOG_MEASURE"]) {
                        $arMeasure = CCatalogMeasure::getList(array(), array("ID" => $arItem["CATALOG_MEASURE"]), false, false, array())->GetNext();
                        $strMeasure = $arMeasure["SYMBOL_RUS"];
                    }
                    if ($bComplect) {
                        $arItem["SHOW_MORE_BUTTON"] = "Y";
                    }
                    $arAddToBasketData = CMax::GetAddToBasketArray($arItem, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, $arItemIDs["ALL_ITEM_IDS"], '', $arParams);
                } elseif ($arItem["OFFERS"]) {
                    $strMeasure = $arItem["MIN_PRICE"]["CATALOG_MEASURE_NAME"];
                    if ($arParams['TYPE_SKU'] == 'TYPE_1' && $arItem['OFFERS_PROP']) {
                        $currentSKUIBlock = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["IBLOCK_ID"];
                        $currentSKUID = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["ID"];
                        $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["IS_OFFER"] = "Y";

                        //$totalCountCMP = CMax::GetTotalCount($arItem, $arParamsCE_CMP);
                        $totalCountCMP = $totalCount;
                        $arQuantityDataCMP = CMax::GetQuantityArray($totalCountCMP, array('ID' => $item_id), 'N', false, 'ce_cmp_visible');

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

                        $arAddToBasketData = CMax::GetAddToBasketArray($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]], $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, $arItemIDs["ALL_ITEM_IDS"], '', $arParams);

                        /* restore IBLOCK_ID */
                        $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["IBLOCK_ID"] = $currentSKUIBlock;
                        /* */
                    }
                }
                ?>
                <div class="list_item_wrapp item_wrap item item-parent clearfix bordered box-shadow js-notice-block">
                    <? if (isset($arItem["OFFERS"]) && $bUseSkuProps): ?>
                        <template class="offers-template-json">
                            <?= \Aspro\Max\Product\SkuTools::getOfferTreeJson($arItem["OFFERS"]) ?>
                        </template>
                        <? $bUseSelectOffer = true; ?>
                    <? endif; ?>
                    <? $bUseSelectOffer = true; ?>
                    <div class="list_item item_info catalog-adaptive flexbox flexbox--row <?= ($arItem["OFFERS"] ? 'has-sku' : '') ?>"
                         id="<?= $arItemIDs["strMainID"]; ?>">
                        <? if ($arParams['SHOW_GALLERY'] == 'Y' && $arItem['OFFERS']): ?>
                            <div class="js-item-gallery hidden"><? \Aspro\Functions\CAsproMaxItem::showSectionGallery(array('ITEM' => $arItem, 'RESIZE' => $arResult['CUSTOM_RESIZE_OPTIONS'])); ?></div>
                        <? endif; ?>
                        <? //image block?>
                        <div class="image_block">
                            <div class="image_wrapper_block js-notice-block__image">
                                <? \Aspro\Functions\CAsproMaxItem::showStickers($arParams, $arItem, true); ?>
                                <? if ($arParams['SHOW_GALLERY'] == 'Y'): ?>
                                    <? if ($bUseSkuProps && $arItem["OFFERS"]): ?>
                                        <? \Aspro\Functions\CAsproMaxItem::showSectionGallery(array('ITEM' => $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]], 'RESIZE' => $arResult['CUSTOM_RESIZE_OPTIONS'])); ?>
                                    <? else: ?>
                                        <?php if ($arItem['PREVIEW_PICTURE']): ?>
                                            <? \Aspro\Functions\CAsproMaxItem::showSectionGallery(array('ITEM' => $arItem, 'RESIZE' => $arResult['CUSTOM_RESIZE_OPTIONS'])); ?>
                                        <?php else: ?>
                                            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="thumb"><img class="img-responsive " src="<?=SITE_TEMPLATE_PATH?>/images/empty_img_element.png" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" /></a>
                                        <?php endif; ?>
                                    <? endif; ?>
                                <? else: ?>
                                    <? \Aspro\Functions\CAsproMaxItem::showImg($arParams, $arItem, false); ?>
                                <? endif; ?>
                            </div>
                            <!--                            <div class="adaptive">-->
                            <!--                                --><? // \Aspro\Functions\CAsproMaxItem::showDelayCompareBtn(array_merge($arParams, $addParams), $arItem, $arAddToBasketData, $totalCount, $bUseSkuProps, 'block', ($arParams['USE_FAST_VIEW'] != 'N'), ($arParams['SHOW_ONE_CLICK_BUY'] == 'Y'), '_small', $currentSKUID, $currentSKUIBlock); ?>
                            <!--                            </div>-->
                        </div>

                        <? //text-block?>
                        <div class="description_wrapp">
                            <div class="description description__card-list">
                                <!--название элемента-->
                                <div class="item-title card-list-title">
                                    <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"
                                       class="dark_link js-notice-block__title"><span><?= $elementName; ?></span></a>
                                    <?php if (array_intersect($arResult['LEVEL_PARENTS'], SECTION_TYPE_1)): ?>
                                        <div class="item-data-card">
                                            <?php if (!empty($arItem['PROPERTIES']['year']['VALUE'])): ?>
                                                <div class="item-data-card__year">
                                                    <?= $arItem['PROPERTIES']['year']['VALUE'] ?> г.
                                                </div>
                                            <?php endif; ?>
                                            <div class="item-data-card__kilometer">
                                                <?= $arItem['PROPERTIES']['race']['VALUE'] ?> <?= $arItem['PROPERTIES']['race_unit']['VALUE_ENUM'] ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!--блок под названием-->
                                <?php if (array_intersect($arResult['LEVEL_PARENTS'], SECTION_TYPE_1)): ?>
                                    <div class="description__name-product">
                                        <?= $arItem['PROPERTIES']['type_' . $arParams['SECTION_CODE']]['VALUE'] ?>
                                    </div>
                                <?php else: ?>
                                    <div class="wrapp_stockers md-store sa_block <?= ($arParams["SHOW_RATING"] == "Y" ? 'with-rating' : ''); ?>"
                                         data-fields='<?= Json::encode($arParams["FIELDS"]) ?>'
                                         data-user-fields='<?= Json::encode($arParams["USER_FIELDS"]) ?>'
                                         data-stores='<?= Json::encode($arParams["STORES"]) ?>'>
                                        <? if ($arParams["SHOW_RATING"] == "Y"): ?>
                                            <div class="rating sm-stars">
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

                                        <?php if (array_intersect($arResult['LEVEL_PARENTS'], SECTION_TYPE_4)): ?>
                                            <div class="item-stock">
                                                <span class="icon <?= $arItem['PROPERTIES']['status']['VALUE_XML_ID'] ?>"></span>
                                                <span class="value font_sxs"><?= $arItem['PROPERTIES']['status']['VALUE'] ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <!--                                        --><?php //= $arQuantityData["HTML"]; ?>
                                        <!--                                        --><? // if (isset($arQuantityDataCMP) && $arQuantityDataCMP && $arItem['OFFERS'] && !empty($arItem['OFFERS_PROP'])): ?>
                                        <!--                                            --><?php //= $arQuantityDataCMP["HTML"]; ?>
                                        <!--                                        --><? // endif; ?>
                                        <?php if (!empty($arItem['PROPERTIES']['article_part']['VALUE']) && (array_intersect($arResult['LEVEL_PARENTS'], array_merge(SECTION_TYPE_2, SECTION_TYPE_4)))): ?>
                                            <div class="article_block muted font_sxs">
                                                <?= Loc::getMessage('ARTICLE_FULL'); ?>
                                                : <?= $arItem['PROPERTIES']['article_part']['VALUE']; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <!--свойства мототранспорта-->
                                <?php if (array_intersect($arResult['LEVEL_PARENTS'], SECTION_TYPE_1)): ?>
                                    <div class="product-description">
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
                                        <div class="product-description__right">
                                            <div class="product-description__el">
                                                <div class="product-description__i"><?= $arItem['PROPERTIES']['count_door_' . $arParams['SECTION_CODE']]['VALUE_ENUM'] ?></div>
                                            </div>
                                            <div class="product-description__el">
                                                <div class="product-description__i"><?= $arItem['PROPERTIES']['color']['VALUE_ENUM'] ?></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($arItem['DETAIL_TEXT'])): ?>
                                    <?php $class = (!array_intersect($arResult['LEVEL_PARENTS'], SECTION_TYPE_1)) ? 'description-text--l' : '' ?>
                                    <div class="description-text <?= $class ?>">
                                        <?= $arItem['DETAIL_TEXT'] ?>
                                    </div>
                                <?php endif; ?>
                                <div class="item-card-location">
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
                        </div>

                        <? //price block?>
                        <?php if (!empty($arItem['PRICES_CUST'])): ?>
                            <?php $isPriceContract = (!empty($arItem['PROPERTIES']['contract_price']['VALUE'])); ?>
                            <div class="information_wrapp main_item_wrapper">
                                <div class="information <?= ($arItem["OFFERS"] && $arItem['OFFERS_PROP'] ? 'has_offer_prop' : ''); ?>  inner_content js_offers__<?= $arItem['ID']; ?>_<?= $arParams["FILTER_HIT_PROP"] ?>">
                                    <div class="cost prices clearfix">
                                        <div class="font-bold font_mxs">
                                            <?php if ($isPriceContract): ?>
                                                Договорная
                                            <?php else: ?>
                                                <?= $arItem['PRICES_CUST']['BASE'] ?>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (!$isPriceContract && !empty($arItem['PRICES_CUST']['CONVERT'])): ?>
                                            <div class="prices-all">
                                                <?php foreach ($arItem['PRICES_CUST']['CONVERT'] as $price): ?>
                                                    <div class="prices-all__i">≈ <?= $price ?></div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <? \Aspro\Functions\CAsproMax::showBonusBlockList($arCurrentSKU ?: $arItem); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php \Aspro\Functions\CAsproMaxItem::showDelayCompareBtn(array_merge($arParams, $addParams), $arItem, $arAddToBasketData, $totalCount, $bUseSkuProps, 'block', ($arParams['USE_FAST_VIEW'] != 'N'), false, '_small', $currentSKUID, $currentSKUIBlock); ?>

                    </div>
                </div>
            <? } ?>
            <? if ($arParams["AJAX_REQUEST"] == "N"){ ?>
        </div>
    </div>
<? } ?>
    <? if ($arParams["AJAX_REQUEST"] == "Y"){ ?>
    <div class="wrap_nav bottom_nav_wrapper">
        <? } ?>

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

<? } else { ?>
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
<? } ?>
    <script>
        BX.message({
            QUANTITY_AVAILIABLE: '<? echo COption::GetOptionString("aspro.max", "EXPRESSION_FOR_EXISTS", GetMessage("EXPRESSION_FOR_EXISTS_DEFAULT"), SITE_ID); ?>',
            QUANTITY_NOT_AVAILIABLE: '<? echo COption::GetOptionString("aspro.max", "EXPRESSION_FOR_NOTEXISTS", GetMessage("EXPRESSION_FOR_NOTEXISTS"), SITE_ID); ?>',
            ADD_ERROR_BASKET: '<? echo GetMessage("ADD_ERROR_BASKET"); ?>',
            ADD_ERROR_COMPARE: '<? echo GetMessage("ADD_ERROR_COMPARE"); ?>',
        })
    </script>
<? \Aspro\Functions\CAsproMax::showBonusComponentList($arResult); ?>