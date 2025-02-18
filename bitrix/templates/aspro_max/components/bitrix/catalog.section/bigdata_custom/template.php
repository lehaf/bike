<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$this->setFrameMode(true);?>
<?use \Bitrix\Main\Localization\Loc,
	  \Bitrix\Main\Web\Json;?>
<?$arParams["SHOW_HINTS"] = "N";?>
<?if($arResult["ITEMS"]):?>
	<!-- items-container -->
	<?$bRow = (isset($arParams['ROW']) && $arParams['ROW'] == 'Y');?>
	<?$bSlide = (isset($arParams['SLIDER']) && $arParams['SLIDER'] == 'Y');?>
	<?$bShowBtn = (isset($arParams['SHOW_BTN']) && $arParams['SHOW_BTN'] == 'Y');?>
		<?if($arParams['TITLE_SLIDER']):?>
			<div class="font_md darken subtitle option-font-bold"><?=$arParams['TITLE_SLIDER'];?></div>
		<?endif;?>
		<div class="block-items<?=($bRow ? ' flexbox flexbox--row flex-wrap' : '');?><?=($bSlide ? ' owl-carousel owl-theme owl-bg-nav short-nav hidden-dots' : '');?> swipeignore"<?if($bSlide):?>data-plugin-options='{"nav": true, "autoplay" : false, "autoplayTimeout" : "3000", "margin": -1, "smartSpeed":1000, <?=(count($arResult["ITEMS"]) > 4 ? "\"loop\": true," : "")?> "responsiveClass": true, "responsive":{"0":{"items": 1},"600":{"items": 2},"768":{"items": 3},"992":{"items": 4}}}'<?endif;?>>
			<?foreach ($arResult['ITEMS'] as $key => $arItem){?>
				<?$strMainID = $this->GetEditAreaId($arItem['ID'] . $key);?>
				<div class="block-item bordered rounded3<?=($bSlide ? '' : ' box-shadow-sm');?>">
					<div class="block-item__wrapper<?=($bShowBtn ? ' w-btn' : '');?> colored_theme_hover_bg-block" id="<?=$strMainID;?>" data-bigdata=Y data-id="<?=$arItem['ID']?>">
						<div class="block-item__inner flexbox flexbox--row">
							<?
							$totalCount = CMax::GetTotalCount($arItem, $arParams);
							$arQuantityData = CMax::GetQuantityArray($totalCount);
							$arItem["FRONT_CATALOG"]="Y";
							$arAddToBasketData = CMax::GetAddToBasketArray($arItem, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], true);

							$elementName = ((isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arItem['NAME']);

							$strMeasure='';
							if($arItem["OFFERS"])
							{
								$strMeasure=$arItem["MIN_PRICE"]["CATALOG_MEASURE_NAME"];
							}
							else
							{
								if (($arParams["SHOW_MEASURE"]=="Y")&&($arItem["CATALOG_MEASURE"]))
								{
									$arMeasure = CCatalogMeasure::getList(array(), array("ID"=>$arItem["CATALOG_MEASURE"]), false, false, array())->GetNext();
									$strMeasure=$arMeasure["SYMBOL_RUS"];
								}
							}
							?>

							<div class="block-item__image block-item__image--wh80">
								<?\Aspro\Functions\CAsproMaxItem::showImg($arParams, $arItem, false);?>
							</div>
							<div class="block-item__info item_info">
								<div class="block-item__title">
									<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="dark-color font_xs"><span><?=$elementName?></span></a>
								</div>
								<div class="block-item__cost cost prices clearfix">
                                    <div class="price_matrix_wrapper ">
                                        <div class="price font-bold font_mxs" data-currency="BYN" data-value="1">
                                            <span class="values_wrapper" style="display: flex; flex-wrap: wrap">
                                                <?php if (!empty($arItem['PROPERTIES']['contract_price']['VALUE'])): ?>
                                                    <?= Loc::getMessage("CONTRACT_PRICE") ?>
                                                <?php elseif (!empty($arItem['PRICES_CUST']['BASE'])): ?>
                                                    <?= $arItem['PRICES_CUST']['BASE'] ?> <span class="price-currency__i" style="margin-left: 3px"> ≈ <?=$arItem['PRICES_CUST']['CONVERT']['USD']?> </span>
                                                <?php endif; ?>
                                            </span>																											</div>
                                    </div>
								</div>

								<?if($bShowBtn):?>
									<div class="more-btn"><a class="btn btn-transparent-border-color btn-xs colored_theme_hover_bg-el" rel="nofollow" href="<?=$arItem["DETAIL_PAGE_URL"]?>" data-item="<?=$arItem["ID"]?>"><?=Getmessage("CVP_TPL_MESS_BTN_DETAIL")?></a></div>
								<?endif;?>
							</div>
						</div>
					</div>
				</div>
			<?}?>
		</div>
	</div>
<?endif;?>
<?\Aspro\Functions\CAsproMax::showBonusComponentList($arResult);?>
<!-- items-container -->

<?$signer = new \Bitrix\Main\Security\Sign\Signer;?>
<script>
	setBigData({
		siteId: '<?=CUtil::JSEscape($component->getSiteId())?>',
		componentPath: '<?=CUtil::JSEscape($componentPath)?>',
		params: <?=CUtil::PhpToJSObject($arParams)?>,
		bigData: <?=CUtil::PhpToJSObject($arResult['BIG_DATA'])?>,
		template: '<?=CUtil::JSEscape($signer->sign($templateName, 'catalog.section'))?>',
		parameters: '<?=CUtil::JSEscape($signer->sign(base64_encode(serialize($arResult['ORIGINAL_PARAMETERS'])), 'catalog.section'))?>',
		wrapper: '.bigdata-wrapper',
		countBigdata: '<?=CUtil::JSEscape($arParams['BIGDATA_COUNT'])?>'
	});
</script>
