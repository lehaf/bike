<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Web\Json;

$this->setFrameMode(true);

$arParams['SHOW_PROPS'] = $arParams['SHOW_PROPS'] ?? 'N';
$arParams['SHOW_STORES_POPUP'] = (boolean)($arParams['SHOW_STORES_POPUP'] ?? false);
?>
<?if($arResult["ITEMS"]){?>
	<?
	$currencyList = '';
	if (!empty($arResult['CURRENCIES']))
	{
		$templateLibrary[] = 'currency';
		$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
	}
	$templateData = array(
		'TEMPLATE_LIBRARY' => $templateLibrary,
		'CURRENCIES' => $currencyList
	);
	unset($currencyList, $templateLibrary);
	$arParams['MD_PRICE'] = 'Y';
	?>
	<div class="content_wrapper_block <?=$templateName;?>">
		<div class="maxwidth-theme">
			<div class="hot-wrapper-items">
				<div class="fast_view_params"></div>
				<?if($arParams['TITLE_BLOCK']):?>
					<div class="top_block">
						<?=CMax::showIconSvg("hot", SITE_TEMPLATE_PATH."/images/svg/flame_productoftheday.svg", "", "", true, false);?><?=Aspro\Functions\CAsproMax::showTitleH($arParams['TITLE_BLOCK']);?>
						<?if($arParams["ALL_URL"] && $arParams["TITLE_BLOCK_ALL"]):?>
							<a href="<?=SITE_DIR.$arParams["ALL_URL"];?>" class="pull-right font_upper muted"><?=$arParams["TITLE_BLOCK_ALL"] ;?></a>
						<?endif;?>
					</div>
				<?endif;?>
				<div class="items swipeignore mobile-overflow mobile-margin-16 mobile-compact c_<?=count($arResult["ITEMS"]);?>">
					<?if(count($arResult["ITEMS"]) > 1):?>
						<div class="flexslider thmb">
						<ul class="flex-direction-nav"><li class="flex-nav-prev"><span class="flex-prev js-click">Previous</span></li><li class="flex-nav-next"><span class="flex-next js-click">Next</span></li></ul>
						</div>
					<?endif;?>
		<?$arOfferProps = implode(';', $arParams['OFFERS_CART_PROPERTIES']);?>

		<?foreach($arResult["ITEMS"] as $key => $arItem){?>
			<?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));

			if(!empty($arItem['PRODUCT_PROPERTIES_FILL']))
			{
				foreach ($arItem['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
				{
					if(isset($arItem['PRODUCT_PROPERTIES'][$propID]))
						unset($arItem['PRODUCT_PROPERTIES'][$propID]);
				}
			}

			$emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);
			$arItem["EMPTY_PROPS_JS"]=(!$emptyProductProperties ? "N" : "Y");

			$item_id = $arItem["ID"];
			$strMeasure = '';

			$totalCount = CMax::GetTotalCount($arItem, $arParams);
			$arQuantityData = CMax::GetQuantityArray($totalCount, array('ID' => $item_id), 'N', ($arItem["OFFERS"] || $arItem['CATALOG_TYPE'] == CCatalogProduct::TYPE_SET || !$arParams['SHOW_STORES_POPUP'] ? false : true));

			$arItem["strMainID"] = $this->GetEditAreaId($arItem['ID'])."_fav";
			$arItemIDs=CMax::GetItemsIDs($arItem);

			if($arParams["SHOW_MEASURE"] == "Y" && $arItem["CATALOG_MEASURE"]){
				if(isset($arItem["ITEM_MEASURE"]) && (is_array($arItem["ITEM_MEASURE"]) && $arItem["ITEM_MEASURE"]["TITLE"]))
				{
					$strMeasure = $arItem["ITEM_MEASURE"]["TITLE"];
				}
				else
				{
					$arMeasure = CCatalogMeasure::getList(array(), array("ID" => $arItem["CATALOG_MEASURE"]), false, false, array())->GetNext();
					$strMeasure = $arMeasure["SYMBOL_RUS"];
				}
			}
			$bUseSkuProps = ($arItem["OFFERS"] && !empty($arItem['OFFERS_PROP']));
			$arCurrentSKU = [];

			$elementName = ((isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arItem['NAME']);

			if($bUseSkuProps)
			{
				if(!$arItem["OFFERS"])
				{
					$arAddToBasketData = CMax::GetAddToBasketArray($arItem, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false,  $arItemIDs["ALL_ITEM_IDS"], 'btn-lg', $arParams);
				}
				elseif($arItem["OFFERS"])
				{

					$strMeasure = $arItem["MIN_PRICE"]["CATALOG_MEASURE_NAME"];
					$totalCount = CMax::GetTotalCount($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]], $arParams);
					$arQuantityData = CMax::GetQuantityArray($totalCount, $arItemIDs["ALL_ITEM_IDS"], 'N');

					$currentSKUIBlock = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["IBLOCK_ID"];
					$currentSKUID = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["ID"];

					$arItem["DETAIL_PAGE_URL"] = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DETAIL_PAGE_URL"];
					if($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["PREVIEW_PICTURE"])
						$arItem["PREVIEW_PICTURE"] = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["PREVIEW_PICTURE"];
					if($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["PREVIEW_PICTURE"])
						$arItem["DETAIL_PICTURE"] = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DETAIL_PICTURE"];

					if($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['IPROPERTY_VALUES']){
						$arItem['SELECTED_SKU_IPROPERTY_VALUES'] = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['IPROPERTY_VALUES'];
					}

					if($arParams["SET_SKU_TITLE"] == "Y"){
						$tmpOfferName = ((isset($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) ? $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['NAME']);
						if(!empty($tmpOfferName)){
							$arItem["NAME"] = $elementName = $tmpOfferName;
						}
					}
					$item_id = $currentSKUID;

					// ARTICLE
					if($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DISPLAY_PROPERTIES"]["ARTICLE"]["VALUE"])
					{
						$arItem["ARTICLE"]["NAME"] = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DISPLAY_PROPERTIES"]["ARTICLE"]["NAME"];
						$arItem["ARTICLE"]["VALUE"] = (is_array($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DISPLAY_PROPERTIES"]["ARTICLE"]["VALUE"]) ? reset($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DISPLAY_PROPERTIES"]["ARTICLE"]["VALUE"]) : $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DISPLAY_PROPERTIES"]["ARTICLE"]["VALUE"]);
					}

					$arCurrentSKU = $arItem["JS_OFFERS"][$arItem["OFFERS_SELECTED"]];
					$strMeasure = $arCurrentSKU["MEASURE"];
				}
			}
			else
			{
				$arAddToBasketData = CMax::GetAddToBasketArray($arItem, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, array('DOP_ID' => 'fav'), 'btn-lg btn-hot-items', $arParams);
			}?>

			<div class="item<?=(!$key ? ' active' : '');?> item-width-322 np">
				<div class="basket_props_block" id="bx_basket_div_<?=$arItem["ID"];?>_fav" style="display: none;">
					<?if (!empty($arItem['PRODUCT_PROPERTIES_FILL'])){
						foreach ($arItem['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo){?>
							<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
						<?}
					}
					if (!$emptyProductProperties){?>
						<div class="wrapper">
							<table>
								<?foreach ($arItem['PRODUCT_PROPERTIES'] as $propID => $propInfo){?>
									<tr>
										<td><? echo $arItem['PROPERTIES'][$propID]['NAME']; ?></td>
										<td>
											<?if('L' == $arItem['PROPERTIES'][$propID]['PROPERTY_TYPE']	&& 'C' == $arItem['PROPERTIES'][$propID]['LIST_TYPE']){
												foreach($propInfo['VALUES'] as $valueID => $value){?>
													<label>
														<input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?>
													</label>
												<?}
											}else{?>
												<select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
													foreach($propInfo['VALUES'] as $valueID => $value){?>
														<option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option>
													<?}?>
												</select>
											<?}?>
										</td>
									</tr>
								<?}?>
							</table>
						</div>
						<?
					}?>
				</div>
				<div class="main_item_wrapper js-notice-block" id="<?=$this->GetEditAreaId($arItem['ID']);?>_fav">
					<div class="inner_wrap row">
						<div class="image col-md-6 text-center">
							<div class="image-wrapper image_wrapper_block js-notice-block__image flexbox">
								<?\Aspro\Functions\CAsproMaxItem::showStickers($arParams, $arItem);?>
								<?$bShowFastViewIcon = false;?>
								
								<?if($arParams['SHOW_GALLERY'] == 'Y' && $arParams['SHOW_PROPS'] != 'Y'):?>
									<?$bShowFastViewIcon = true;?>
									<?if($bUseSkuProps && $arItem["OFFERS"]):?>
										<?\Aspro\Functions\CAsproMaxItem::showSectionGallery( array('ITEM' => $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]) );?>
									<?else:?>
                                        <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"
                                           class="thumb"><img class="img-responsive "
                                                              src="<?= SITE_TEMPLATE_PATH ?>/images/empty_img_element.png"
                                                              alt="<?= $arItem["NAME"] ?>"
                                                              title="<?= $arItem["NAME"] ?>"/></a>
									<?endif;?>
								<?else:?>
									<?\Aspro\Functions\CAsproMaxItem::showImg($arParams, $arItem);?>
								<?endif;?>
								<?$bShowOneClick = $arParams["SHOW_ONE_CLICK"]!="N" ? true : false ?>
								<?\Aspro\Functions\CAsproMaxItem::showDelayCompareBtn($arParams, $arItem, $arAddToBasketData, $totalCount, $bUseSkuProps, 'block lg', $bShowFastViewIcon, $bShowOneClick, '_small');?>
							</div>
						</div>
						<div class="item_info col-md-6">
							<div class="item_info_wrapper">
								<?if($arParams["SHOW_DISCOUNT_TIME"]=="Y"):?>
									<?$arDiscount = []?>
									<?\Aspro\Functions\CAsproMax::showDiscountCounter($totalCount, $arDiscount, $arQuantityData, $arItem, $strMeasure, 'v2 grey', $arItem['ID']);?>
								<?endif;?>
								<?if($arParams["SHOW_RATING"] == "Y"):?>
									<div class="rating">
										<?$frame = $this->createFrame('dv_'.$arItem["ID"])->begin('');?>
											<?
											global $arTheme;
											if( $arParams['REVIEWS_VIEW'] ):?>
												<div class="blog-info__rating--top-info">
													<div class="votes_block nstar with-text">
														<div class="ratings">
															<?$message = $arItem['PROPERTIES']['EXTENDED_REVIEWS_COUNT']['VALUE'] ? GetMessage('VOTES_RESULT', array('#VALUE#' => $arItem['PROPERTIES']['EXTENDED_REVIEWS_RAITING']['VALUE'])) : GetMessage('VOTES_RESULT_NONE')?>
															<div class="inner_rating" title="<?=$message?>">
																<?for($i=1;$i<=5;$i++):?>
																	<div class="item-rating <?=$i<=$arItem['PROPERTIES']['EXTENDED_REVIEWS_RAITING']['VALUE'] ? 'filed' : ''?>"><?=CMax::showIconSvg("star", SITE_TEMPLATE_PATH."/images/svg/catalog/star_small.svg");?></div>
																<?endfor;?>
															</div>
														</div>
													</div>
													<?if($arItem['PROPERTIES']['EXTENDED_REVIEWS_COUNT']['VALUE']):?>
														<span class="font_sxs"><?=$arItem['PROPERTIES']['EXTENDED_REVIEWS_COUNT']['VALUE']?></span>
													<?endif;?>
												</div>
											<?else:?>
												<?$APPLICATION->IncludeComponent(
												   "bitrix:iblock.vote",
												   "element_rating_front",
												   Array(
													  "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
													  "IBLOCK_ID" => $arItem["IBLOCK_ID"],
													  "ELEMENT_ID" =>$arItem["ID"],
													  "MAX_VOTE" => 5,
													  "VOTE_NAMES" => array(),
													  "CACHE_TYPE" => $arParams["CACHE_TYPE"],
													  "CACHE_TIME" => $arParams["CACHE_TIME"],
													  "DISPLAY_AS_RATING" => 'vote_avg'
												   ),
												   $component, array("HIDE_ICONS" =>"Y")
												);?>
											<?endif;?>
										<?$frame->end();?>
									</div>
								<?endif;?>
								<div class="title">
									<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="dark_link font_lg option-font-bold js-notice-block__title"><span><?=$elementName;?></span></a>
								</div>
<!--								<div class="sa_block" data-fields='--><?php //=Json::encode($arParams["FIELDS"])?><!--' data-stores='--><?php //=Json::encode($arParams["STORES"])?><!--' data-user-fields='--><?php //=Json::encode($arParams["USER_FIELDS"])?><!--'>-->
<!--									--><?php //=$arQuantityData["HTML"];?>
<!--									<div class="article_block font_sxs muted" --><?//if(isset($arItem['ARTICLE']) && $arItem['ARTICLE']['VALUE']):?><!--data-name="--><?php //=$arItem['ARTICLE']['NAME'];?><!--" data-value="--><?php //=$arItem['ARTICLE']['VALUE'];?><!--"--><?//endif;?><!--
<!--										--><?//if(isset($arItem['ARTICLE']) && $arItem['ARTICLE']['VALUE']){?>
<!--											<div>--><?php //=$arItem['ARTICLE']['NAME'];?><!--: --><?php //=$arItem['ARTICLE']['VALUE'];?><!--</div>-->
<!--										--><?//}?>
<!--									</div>-->
<!--								</div>-->
                                <?php if (!empty($arItem['PRICES_CUST'])): ?>
                                    <?php $isPriceContract = (!empty($arItem['PROPERTIES']['contract_price']['VALUE'])); ?>
                                    <div class="cost prices clearfix">
                                        <div class="price_matrix_wrapper ">
                                            <div class="price font-bold font_mlg" data-currency="BYN" data-value="50">
                                                <?php if (!empty($arItem['PROPERTIES']['contract_price']['VALUE'])): ?>
                                                    Договорная
                                                <?php else: ?>
                                                    <?= $arItem['PRICES_CUST']['BASE'] ?>
                                                    <?php if (!empty($arItem['PRICES_CUST']['CONVERT'])): ?>
                                                        <?php foreach ($arItem['PRICES_CUST']['CONVERT'] as $price): ?>
                                                            <span class="prices-all__i">/ ≈ <?= $price ?></span>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
								<?\Aspro\Functions\CAsproMax::showBonusBlockList($arItem);?>

								<div class="<?=($arItem["OFFERS"] && $arItem['OFFERS_PROP'] ? 'has_offer_prop' : '');?> footer-action inner_content js_offers__<?=$arItem['ID'];?>_fav">
									<?if(!$arItem["OFFERS"]):?>
										<div class="counter_wrapp list clearfix">
											<?if(($arAddToBasketData["OPTIONS"]["USE_PRODUCT_QUANTITY_LIST"] && $arAddToBasketData["ACTION"] == "ADD") && $arAddToBasketData["CAN_BUY"]):?>
												<?=\Aspro\Functions\CAsproMax::showItemCounter($arAddToBasketData, $arItem["ID"], $arItemIDs, $arParams, 'md', '', true);?>
											<?endif;?>
											<div id="<?=$arItemIDs["ALL_ITEM_IDS"]['BASKET_ACTIONS']; ?>" class="button_block">
												<!--noindex-->
													<?=$arAddToBasketData["HTML"]?>
												<!--/noindex-->
											</div>
										</div>
									<?elseif($arItem["OFFERS"]):?>
										<div class="offer_buy_block buys_wrapp woffers counter_wrapp">
											<?
											$arItem["OFFERS_MORE"] = "Y";
											$arAddToBasketData = CMax::GetAddToBasketArray($arItem, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, $arItemIDs["ALL_ITEM_IDS"], 'btn-lg', $arParams);?>
											<!--noindex-->
												<?=$arAddToBasketData["HTML"]?>
											<!--/noindex-->
										</div>
									<?endif;?>
									<?if($arParams["SHOW_ONE_CLICK"]!="N"):?>
										<?=\Aspro\Functions\CAsproMax::showItemOCB($arAddToBasketData, $arItem, $arParams, false, 'btn-md');?>
									<?endif;?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?}?>

		<?if(count($arResult["ITEMS"]) > 1):?>
			<ol class="flex-control-nav flex-control-paging flex-control-js-click">
				<?for($i = 0;$i < count($arResult["ITEMS"]);$i++):?>
					<li>
						<a href="#" class="<?=(!$i ? 'flex-active' : '')?>" data-index="<?=$i?>"></a>
					</li>
				<?endfor;?>
			</ol>
		<?endif;?>

		</div>
		</div>
		</div>
	</div>
<?}?>
<?\Aspro\Functions\CAsproMax::showBonusComponentList($arResult);?>