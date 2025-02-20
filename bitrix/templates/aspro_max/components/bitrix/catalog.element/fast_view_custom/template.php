<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?global $arTheme;?>
<div class="basket_props_block" id="bx_basket_div_<?=$arResult["ID"];?>" style="display: none;">
	<?if (!empty($arResult['PRODUCT_PROPERTIES_FILL'])){
		foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo){?>
			<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
			<?if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))
				unset($arResult['PRODUCT_PROPERTIES'][$propID]);
		}
	}
	$templateData["USE_OFFERS_SELECT"] = false;
	$arResult["EMPTY_PROPS_JS"]="Y";
	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
	if (!$emptyProductProperties){
		$arResult["EMPTY_PROPS_JS"]="N";?>
		<div class="wrapper">
			<table>
				<?foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo){?>
					<tr>
						<td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>
						<td>
							<?if('L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE'] && 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']){
								foreach($propInfo['VALUES'] as $valueID => $value){?>
									<label>
										<input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?>
									</label>
								<?}
							}else{?>
								<select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]">
									<?foreach($propInfo['VALUES'] as $valueID => $value){?>
										<option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option>
									<?}?>
								</select>
							<?}?>
						</td>
					</tr>
				<?}?>
			</table>
		</div>
	<?}?>
</div>

<?if ($arResult['SKU_CONFIG']):?><div class="js-sku-config" data-params='<?=\Aspro\Max\Product\SkuTools::getSignedParams($arResult['SKU_CONFIG'])?>'></div><?endif;?>

<?
$this->setFrameMode(true);
use \Bitrix\Main\Localization\Loc;
$currencyList = '';
if (!empty($arResult['CURRENCIES'])){
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
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
		"STORE_PATH"  =>  $arParams["STORE_PATH"],
		"MAIN_TITLE"  =>  $arParams["MAIN_TITLE"],
		"MAX_AMOUNT"=>$arParams["MAX_AMOUNT"],
		"USE_ONLY_MAX_AMOUNT" => $arParams["USE_ONLY_MAX_AMOUNT"],
		"SHOW_EMPTY_STORE" => $arParams['SHOW_EMPTY_STORE'],
		"SHOW_GENERAL_STORE_INFORMATION" => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
		"USE_ONLY_MAX_AMOUNT" => $arParams["USE_ONLY_MAX_AMOUNT"],
		"USER_FIELDS" => $arParams['USER_FIELDS'],
		"FIELDS" => $arParams['FIELDS'],
		"STORES" => $arParams['STORES'] = array_diff((array)$arParams['STORES'], [], ['']),
	)
);
unset($currencyList, $templateLibrary);

if ($arResult['OUT_OF_PRODUCTION']) {
	$templateData['OUT_OF_PRODUCTION'] = [
		'SHOW_ANALOG' => $arResult['PRODUCT_ANALOG']
	];
}

$actualItem = $arResult["OFFERS"] ? (isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]) ? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']] : reset($arResult['OFFERS'])) : $arResult;

$arSkuTemplate = array();
if (!empty($arResult['SKU_PROPS'])){
	$arSkuTemplate=CMax::GetSKUPropsArray($arResult['SKU_PROPS'], $arResult["SKU_IBLOCK_ID"], "list", $arParams["OFFER_HIDE_NAME_PROPS"], "N", $arResult, $arParams['OFFER_SHOW_PREVIEW_PICTURE_PROPS']);
	//$arSkuTemplate=CMax::GetSKUPropsArray($arResult['SKU_PROPS'], $arResult["SKU_IBLOCK_ID"], "list", $arParams["OFFER_HIDE_NAME_PROPS"]);
}
$strMainID = $this->GetEditAreaId($arResult['ID']);
$item_id = $arResult["ID"];

$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

$arResult["strMainID"] = $this->GetEditAreaId($arResult['ID'])."f";
$arItemIDs=CMax::GetItemsIDs($arResult, "Y");

$showCustomOffer=(($arResult['OFFERS'] && $arParams["TYPE_SKU"] !="N") ? true : false);
if( $showCustomOffer && isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]) ){
	$arCurrentSKU = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']];
	$totalCount = CMax::GetTotalCount($arCurrentSKU, $arParams);
	$arQuantityData = CMax::GetQuantityArray([
		'totalCount' => $totalCount, 
		'arItemIDs' => array('ID' => $arCurrentSKU["ID"]), 
		'useStoreClick' => 'N', 
		'bShowAjaxItems' => ($arParams["USE_STORE"] == "Y" && $arResult["STORES_COUNT"] && $arResult['CATALOG_TYPE'] != CCatalogProduct::TYPE_SET),
		'dataAmount' => $arParams['CATALOG_DETAIL_SHOW_AMOUNT_STORES'] !== 'Y' ? [] : [
			'ID' => $arCurrentSKU['ID'],
			'STORES' => $arParams['STORES'],
			'IMMEDIATELY' => 'Y',
		],
	]);
} else {
	$totalCount = CMax::GetTotalCount($actualItem, $arParams);
	$arQuantityData = CMax::GetQuantityArray([
		'totalCount' => $totalCount, 
		'arItemIDs' => array('ID' => $actualItem['ID']), 
		'useStoreClick' => 'Y', 
		'bShowAjaxItems' => ($arResult['CATALOG_TYPE'] != CCatalogProduct::TYPE_SET && $arResult['STORES_COUNT']),
		'dataAmount' => $arParams['CATALOG_DETAIL_SHOW_AMOUNT_STORES'] !== 'Y' ? [] : [
			'ID' => $arResult['ID'],
			'STORES' => $arParams['STORES'],
			'IMMEDIATELY' => 'Y',
		],
	]);
}

$arParams["BASKET_ITEMS"]=($arParams["BASKET_ITEMS"] ? $arParams["BASKET_ITEMS"] : array());
$useStores = $arParams["USE_STORE"] == "Y" && $arResult["STORES_COUNT"] && $arQuantityData["RIGHTS"]["SHOW_QUANTITY"];
$showCustomOffer=(($arResult['OFFERS'] && $arParams["TYPE_SKU"] !="N") ? true : false);
$bUseSkuProps = ($arResult["OFFERS"] && !empty($arResult['OFFERS_PROP']));
if($showCustomOffer){
	$templateData['JS_OBJ'] = $strObName;
}
$strMeasure='';
$arAddToBasketData = array();

$popupVideo = $arResult['PROPERTIES']['POPUP_VIDEO']['VALUE'];
$bOfferPreviewText = false;
if( $showCustomOffer && isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]) ){
	//$arCurrentSKU = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']];
	$item_id = $arCurrentSKU["ID"];
	$bOfferPreviewText = $arParams['SHOW_SKU_DESCRIPTION'] === 'Y' && $arCurrentSKU["PREVIEW_TEXT"];
	if(strlen($arParams["SKU_DETAIL_ID"]))
		$arResult['DETAIL_PAGE_URL'].= '?'.$arParams["SKU_DETAIL_ID"].'='.$arCurrentSKU['ID'];
	//$templateData["OFFERS_INFO"]["CURRENT_OFFER"] = $arCurrentSKU["ID"];	
	$currentOfferTitle = $arCurrentSKU['IPROPERTY_VALUES']["ELEMENT_PAGE_TITLE"] ?? $arCurrentSKU["NAME"];
	if ($arCurrentSKU["DISPLAY_PROPERTIES"]["ARTICLE"]["VALUE"]) {
		$arCurrentSKU['DISPLAY_PROPERTIES']['ARTICLE']["VALUE"] = (is_array($arCurrentSKU['DISPLAY_PROPERTIES']['ARTICLE']["VALUE"]) ? reset($arCurrentSKU['DISPLAY_PROPERTIES']['ARTICLE']["VALUE"]) : $arCurrentSKU['DISPLAY_PROPERTIES']['ARTICLE']["VALUE"]);
        $article = $arCurrentSKU['DISPLAY_PROPERTIES']['ARTICLE'];
		unset($arCurrentSKU['DISPLAY_PROPERTIES']['ARTICLE']);
    } elseif($arParams['SHOW_ARTICLE_SKU'] === 'Y') {
		$article = $arResult["CML2_ARTICLE"];
	}
	if($arCurrentSKU['PROPERTIES']['POPUP_VIDEO']['VALUE']){
		$popupVideo = $arCurrentSKU['PROPERTIES']['POPUP_VIDEO']['VALUE'];
	}
	$arResult['OFFER_PROP'] = $arCurrentSKU['DISPLAY_PROPERTIES'];
	CIBlockPriceTools::clearProperties($arResult['OFFER_PROP'], $arParams['OFFER_TREE_PROPS']);
	$arResult['OFFER_PROP'] = CMax::PrepareItemProps($arResult['OFFER_PROP']);
} else {
	$article = $arResult["CML2_ARTICLE"];
}

if($arResult["OFFERS"])
{
	$strMeasure=$arResult["MIN_PRICE"]["CATALOG_MEASURE_NAME"];
	$templateData["STORES"]["OFFERS"]="Y";

	if($showCustomOffer){
		$currentSKUIBlock = $arResult["OFFERS"][$arResult["OFFERS_SELECTED"]]["IBLOCK_ID"];
		$currentSKUID = $arResult["OFFERS"][$arResult["OFFERS_SELECTED"]]["ID"];
		$arResult["OFFERS"][$arResult["OFFERS_SELECTED"]]["IS_OFFER"] = "Y";

		/* need for add basket props */
		$arResult["OFFERS"][$arResult["OFFERS_SELECTED"]]["IBLOCK_ID"] = $arResult['IBLOCK_ID'];
		/* */
		// for current offer buy block
		$arAddToBasketData = CMax::GetAddToBasketArray($arResult["OFFERS"][$arResult["OFFERS_SELECTED"]], $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, $arItemIDs["ALL_ITEM_IDS"], 'btn-lg no-icons', $arParams);
		/* restore IBLOCK_ID */
		$arResult["OFFERS"][$arResult["OFFERS_SELECTED"]]["IBLOCK_ID"] = $currentSKUIBlock;
		/* */
	}
}
else
{
	if(($arParams["SHOW_MEASURE"]=="Y")&&($arResult["CATALOG_MEASURE"]))
	{
		$arMeasure = CCatalogMeasure::getList(array(), array("ID"=>$arResult["CATALOG_MEASURE"]), false, false, array())->GetNext();
		$strMeasure=$arMeasure["SYMBOL_RUS"];
	}
	$arAddToBasketData = CMax::GetAddToBasketArray($arResult, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], true, $arItemIDs["ALL_ITEM_IDS"], 'btn-lg no-icons', $arParams);
}
$arOfferProps = implode(';', $arParams['OFFERS_CART_PROPERTIES']);

// save item viewed
$arFirstPhoto = reset($arResult['MORE_PHOTO']);
$viwedItem = $arCurrentSKU ?? $arResult;
$arItemPrices = $viwedItem['MIN_PRICE'];	
if(isset($viwedItem['PRICE_MATRIX']) && $viwedItem['PRICE_MATRIX'])
{
	$rangSelected = $viwedItem['ITEM_QUANTITY_RANGE_SELECTED'];
	$priceSelected = $viwedItem['ITEM_PRICE_SELECTED'];
	if(isset($viwedItem['FIX_PRICE_MATRIX']) && $viwedItem['FIX_PRICE_MATRIX'])
	{
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
$elementName = ((isset($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arResult['NAME']);
if($arTheme['CHANGE_TITLE_ITEM_DETAIL']['VALUE'] === "Y" && $currentOfferTitle){
	$elementName = $currentOfferTitle;
}
?>

<div class="form product-main">
	<div class="form_head">
		<h2><a href="<?=$arResult['DETAIL_PAGE_URL'];?>" class="dark_link fast-view-title"><?=$elementName;?></a></h2>

		<div class="flexbox flexbox--row align-items-center justify-content-between flex-wrap">
			<div class="col-auto">
				<div class="product-info-headnote__inner">
					<?\Aspro\Functions\CAsproMaxItem::showDelayCompareBtn($arParams, $arResult, $arAddToBasketData, $totalCount, $bUseSkuProps, 'list static', false, false, '_small', $currentSKUID, $currentSKUIBlock);?>
					<?if($arParams["SHOW_RATING"] == "Y"):?>
						<div class="product-info-headnote__rating">
							<?$frame = $this->createFrame('dv_'.$arResult["ID"])->begin();?>
								<div class="rating">
									<?									
									if($arParams['REVIEWS_VIEW'] == 'EXTENDED'):?>
										<div class="blog-info__rating--top-info">
											<div class="votes_block nstar ">
												<div class="ratings">
													<?$message = $arResult['PROPERTIES']['EXTENDED_REVIEWS_COUNT']['VALUE'] ? GetMessage('VOTES_RESULT', array('#VALUE#' => $arResult['PROPERTIES']['EXTENDED_REVIEWS_RAITING']['VALUE'])) : GetMessage('VOTES_RESULT_NONE')?>
													<div class="inner_rating" title="<?=$message?>">
														<?for($i=1;$i<=5;$i++):?>
															<div class="item-rating <?=$i<=round((float)$arResult['PROPERTIES']['EXTENDED_REVIEWS_RAITING']['VALUE']) ? 'filed' : ''?>"><?=CMax::showIconSvg("star", SITE_TEMPLATE_PATH."/images/svg/catalog/star_small.svg");?></div>
														<?endfor;?>
													</div>
												</div>
											</div>
											<?if($arResult['PROPERTIES']['EXTENDED_REVIEWS_COUNT']['VALUE']):?>
												<span class="font_sxs"><?=$arResult['PROPERTIES']['EXTENDED_REVIEWS_COUNT']['VALUE']?></span>
											<?endif;?>
										</div>
									<?else:?>
										<?$APPLICATION->IncludeComponent(
											"bitrix:iblock.vote",
											"element_rating",
											Array(
												"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
												"IBLOCK_ID" => $arResult["IBLOCK_ID"],
												"ELEMENT_ID" => $arResult["ID"],
												"MAX_VOTE" => 5,
												"VOTE_NAMES" => array(),
												"CACHE_TYPE" => $arParams["CACHE_TYPE"],
												"CACHE_TIME" => $arParams["CACHE_TIME"],
												"DISPLAY_AS_RATING" => 'vote_avg'
											),
											$component, array("HIDE_ICONS" =>"Y")
										);?>
									<?endif;?>
								</div>
							<?$frame->end();?>
						</div>
					<?endif;?>
					<div class="product-info-headnote__article">
						<div class="article muted font_xs" itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue" <?if(!strlen($article["VALUE"])){?>id="<? echo $arItemIDs["ALL_ITEM_IDS"]['DISPLAY_PROP_ARTICLE_DIV'] ?>" style="display: none;"<?}?>>
							<span class="article__title" itemprop="name"><?=$article["NAME"];?>:</span>
							<span class="article__value" itemprop="value"><?=$article["VALUE"];?></span>
						</div>
					</div>
				</div>
			</div>
			<?if($arResult["BRAND_ITEM"]):?>
				<div class="col-auto">
					<div class="product-info-headnote__brand">
						<div class="brand">
							<?if(!$arResult["BRAND_ITEM"]["IMAGE"]):?>
								<a href="<?=$arResult["BRAND_ITEM"]["DETAIL_PAGE_URL"]?>" class="brand__link dark_link"><?=$arResult["BRAND_ITEM"]["NAME"]?></a>
							<?else:?>
								<a class="brand__picture" href="<?=$arResult["BRAND_ITEM"]["DETAIL_PAGE_URL"]?>">
									<img  src="<?=$arResult["BRAND_ITEM"]["IMAGE"]["src"]?>" alt="<?=$arResult["BRAND_ITEM"]["IMAGE"]["ALT"]?>" title="<?=$arResult["BRAND_ITEM"]["IMAGE"]["TITLE"]?>" />
								</a>
							<?endif;?>
						</div>
					</div>
				</div>
			<?endif;?>
		</div>
	</div>

	<script type="text/javascript">
	setViewedProduct(<?=$arResult['ID']?>, <?=CUtil::PhpToJSObject($arViewedData, false)?>);
	</script>

	<div class="fastview-product flexbox flexbox--row <?=(!$showCustomOffer ? "noffer" : "");?> <?=($arParams["SHOW_UNABLE_SKU_PROPS"] != "N" ? "show_un_props" : "unshow_un_props");?>" id="<?=$arItemIDs["strMainID"];?>">
		<div class="fastview-product__image">
			<div class="product-detail-gallery product-detail-gallery--small js-notice-block__image">
				<?//main gallery?>
				<?$arParams['PICTURE_RATIO'] = 'square';?>
				<?\Aspro\Functions\CAsproMax::showMainGallery([
					'POPUPVIDEO' => $popupVideo,
					'IS_CURRENT_SKU' => !!$arCurrentSKU,
					'IS_CUSTOM_OFFERS' => $showCustomOffer,
					'NEED_STICKERS' => true,
					'SHOW_THUMBS' => false,
					'IS_FAST_VIEW' => true,
				], $arResult, $arParams);?>

			</div>
		</div>
		<div class="fastview-product__info item_info scrollblock">
			<div class="prices_item_block">
				<div class="middle_info1 main_item_wrapper">
					<?if ($arResult['PRODUCT_ANALOG']):?>
						<div class="js-item-analog js-animate-appearance"></div>
					<?endif;?>
					<a href="<?=$arResult["DETAIL_PAGE_URL"];?>"></a>
					<?$frame = $this->createFrame()->begin();?>
                    <?php if(!empty($arResult['PRICES_CUST']['BASE'])):?>
					<div class="prices_block">
						<div class="cost prices detail">
                            <div class="price_matrix_wrapper ">
                                <div class="price font-bold font_mxs" data-currency="BYN" data-value="1">
                                    <?php if (!empty($arResult['PROPERTIES']['contract_price']['VALUE'])): ?>
                                        <?=Loc::getMessage('CONTRACT_PRICE_TEXT');?>
                                    <?php else: ?>
                                        <?= $arResult['PRICES_CUST']['BASE'] ?>
                                        <?php if (!empty($arResult['PRICES_CUST']['CONVERT']) && empty($arResult['PROPERTIES']['contract_price']['VALUE'])): ?>
                                                <?php foreach ($arResult['PRICES_CUST']['CONVERT'] as $price): ?>
                                                    <span class="muted font_sxs font-normal" style="font-weight: 400">
                                                        / ≈ <?= $price ?>
                                                    </span>
                                                <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>																											</div>
                            </div>
						</div>
						<?\Aspro\Functions\CAsproMax::showBonusBlockDetail($arCurrentSKU ?: $arResult);?>

						<?//stock?>
						<div class="quantity_block_wrapper sa_block">
                            <?php if (!empty($arResult['PROPERTIES']['status']['VALUE_XML_ID'])): ?>
                                <div class="item-stock">
                                    <span class="icon <?= $arResult['PROPERTIES']['status']['VALUE_XML_ID'] ?>"></span>
                                    <span class="value font_sxs"><?= $arResult['PROPERTIES']['status']['VALUE'] ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="muted font_sxs">
                               Артикул : <?= $arResult['PROPERTIES']['exp_id']['VALUE'] ?>
                            </div>
<!--							--><?php //=$arQuantityData["HTML"];?>
<!--							--><?//if($arParams["SHOW_CHEAPER_FORM"] == "Y"):?>
<!--								<div class="cheaper_form muted777 font_xs">-->
<!--									--><?php //=CMax::showIconSvg("cheaper", SITE_TEMPLATE_PATH.'/images/svg/catalog/cheaper.svg', '', '', true, false);?>
<!--									<span class="animate-load dotted" data-event="jqm" data-param-form_id="CHEAPER" data-name="cheaper" data-autoload-product_name="--><?php //=CMax::formatJsName($arCurrentSKU ? $arCurrentSKU['NAME'] : $arResult['NAME']);?><!--" data-autoload-product_id="--><?php //=$arCurrentSKU ? $arCurrentSKU['ID'] : $arResult['ID'];?><!--">--><?php //=($arParams["CHEAPER_FORM_NAME"] ? $arParams["CHEAPER_FORM_NAME"] : Loc::getMessage("CHEAPER"));?><!--</span>-->
<!--								</div>-->
<!--							--><?//endif;?>
						</div>
					</div>
                    <?php endif;?>
					<?$frame->end();?>

					<?//preview_text?>
					<?if($arResult["PREVIEW_TEXT"] || $bOfferPreviewText):?>
						<div class="preview_text font_xs muted777 preview-text-replace">
							<?if($bOfferPreviewText):?>
								<?=$arCurrentSKU["PREVIEW_TEXT"];?>
							<?else:?>
								<?=$arResult['PREVIEW_TEXT'];?>
							<?endif;?>
						</div>
					<?endif;?>

					<?$isShowProps = ($arResult['DISPLAY_PROPERTIES'] || $arResult['OFFER_PROP']);?>
					<div class="props_list_wrapp char-toggle-visible <?=($isShowProps ? '' : 'hidden')?>">
						<?TSolution\Functions::showBlockHtml([
							'FILE' => '/catalog/props_in_section.php',
							'TITLE_TOP' => '<div class="show_props"><span class="darken font_sm char_title"><span class="">'.Loc::getMessage("CT_NAME_DOP_CHAR").'</span></span></div>',
							'ITEM' => $arResult,
							'PARAMS' => [
								'ITEM_CLASSES' => 'properties__item--compact font_xs',
								'SHOW_HINTS' => $arParams['SHOW_HINTS'],
							]
						])?>
					</div>
				</div>
			</div>
		</div>
		<?
		if($arResult['CATALOG'] && $actualItem['CAN_BUY'] && $arParams['USE_PREDICTION'] === 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled('sale')){
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
					),
					'REQUEST_ITEMS' => true,
					'RCM_TEMPLATE' => 'main',
				),
				$component,
				array('HIDE_ICONS' => 'Y')
			);
		}
		?>
	</div>
	<div class="btn-wrapper"><a href="<?=$arResult['DETAIL_PAGE_URL'];?>" class="btn btn-default btn-lg round-ignore bottom-href-fast-view"><?=Loc::getMessage('MORE_TEXT_ITEM');?><?=CMax::showIconSvg("down", SITE_TEMPLATE_PATH.'/images/svg/catalog/arrow_quicklook.svg', '', '', true, false);?></a></div>

	<script type="text/javascript">
		BX.message({
			QUANTITY_AVAILIABLE: '<? echo COption::GetOptionString("aspro.max", "EXPRESSION_FOR_EXISTS", GetMessage("EXPRESSION_FOR_EXISTS_DEFAULT"), SITE_ID); ?>',
			QUANTITY_NOT_AVAILIABLE: '<? echo COption::GetOptionString("aspro.max", "EXPRESSION_FOR_NOTEXISTS", GetMessage("EXPRESSION_FOR_NOTEXISTS"), SITE_ID); ?>',
			ADD_ERROR_BASKET: '<? echo GetMessage("ADD_ERROR_BASKET"); ?>',
			ADD_ERROR_COMPARE: '<? echo GetMessage("ADD_ERROR_COMPARE"); ?>',
			ONE_CLICK_BUY: '<? echo GetMessage("ONE_CLICK_BUY"); ?>',
			SITE_ID: '<? echo SITE_ID; ?>'
		})
		InitOwlSlider();
		var navs = $('#popup_iframe_wrapper .navigation-wrapper-fast-view .fast-view-nav');
		if(navs.length) {
			var ajaxData = {
				element: "<?=$arResult['ID']?>",
				iblock: "<?=$arParams['IBLOCK_ID']?>",
				section: "<?=$arResult['IBLOCK_SECTION_ID']?>",
			};
			if($('.smart-filter-filter').length && $('.smart-filter-filter').text().length) {
				try {
					var text = $('.smart-filter-filter').text().replace('var filter = ', '');
			        JSON.parse(text);
					ajaxData.filter = text;
			    } catch (e) {}
			}

			if($('.smart-filter-sort').length && $('.smart-filter-sort').text().length) {
				try {
					var text = $('.smart-filter-sort').text().replace('var filter = ', '');
			        JSON.parse(text);
					ajaxData.sort = text;
			    } catch (e) {}
			}
			navs.data('ajax', ajaxData);
		}
	</script>
</div>

<?\Aspro\Functions\CAsproMax::showBonusComponentDetail($arResult);?>