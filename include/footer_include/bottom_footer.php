<?
global $APPLICATION, $arRegion, $arSite, $arTheme, $bIndexBot, $is404, $isForm, $isIndex;
$arExt = [];

$APPLICATION->IncludeComponent(
    "aspro:theme.max", 
    ".default", 
    array(
        'SHOW_TEMPLATE' => 'Y'
    ),
    false, 
	array('HIDE_ICONS' => 'Y')
);

if (CMax::IsOrderPage()) {
	$arExt[] = 'order_actions';
}
if (CMax::IsBasketPage()) {
	$arExt[] = 'hash_location';
}
?>
<div class="bx_areas">
	<?CMax::ShowPageType('bottom_counter');?>
</div>
<?CMax::ShowPageType('search_title_component');?>
<?CMax::setFooterTitle();
CMax::showFooterBasket();?>
<div id="body_iframe_wrapper"></div>
<div id="popup_iframe_wrapper"></div>
<?
if ($arExt) {
	\Aspro\Max\Functions\Extensions::init($arExt);
}
?>
<?include_once('bottom_footer_custom.php');?>