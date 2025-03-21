<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

if (!empty($arParams["CUSTOM_PAGES"]) && strpos($arParams["CUSTOM_PAGES"], 'fa-') !== false) {
    CJSCore::Init('aspro_font_awesome');
}

/*$APPLICATION->SetTitle(Loc::getMessage("SPS_TITLE_MAIN"));
$APPLICATION->AddChainItem(Loc::getMessage("SPS_CHAIN_MAIN"), $arResult['SEF_FOLDER']);

$theme = Bitrix\Main\Config\Option::get("main", "wizard_eshop_bootstrap_theme_id", "blue", SITE_ID);*/

$availablePages = array();


if ($arParams['SHOW_MODERATION_PAGE'] === 'Y' && \Bitrix\Main\Engine\CurrentUser::get()->isAdmin()) {
    $empty = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();
    $elementCount = $empty::getList([
        'filter' => ['!=IS_MODERATION.VALUE' => false],
        'count_total' => 1,
    ])->getCount();

    $availablePages[] = array(
        "path" => $arResult['PATH_TO_MODERATION'] ?? SITE_DIR . 'personal/moderation/',
        "name" => Loc::getMessage("SPS_MODERATION_PAGE_NAME") . ' (' . $elementCount . ')',
        //CMax::showIconSvg("cat_icons light-ignore", $arImg["src"]);
        //"icon" => '<i class="cur_orders"></i>'
        "icon" => CMax::showIconSvg("cur_orders colored", SITE_TEMPLATE_PATH . '/images/svg/personal/recent_orders.svg')
    );
}

if ($arParams['SHOW_ADS_PAGE'] === 'Y') {
    $empty = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();
    $elementCount = $empty::getList([
        'filter' => ['=USER.VALUE' => \Bitrix\Main\Engine\CurrentUser::get()->getId()],
        'count_total' => 1,
    ])->getCount();

    $availablePages[] = array(
        "path" => $arResult['PATH_TO_ADS'] ?? SITE_DIR . 'personal/obyavleniya/',
        "name" => Loc::getMessage("SPS_ADS_PAGE_NAME") . ' (' . $elementCount . ')',
        //CMax::showIconSvg("cat_icons light-ignore", $arImg["src"]);
        //"icon" => '<i class="cur_orders"></i>'
        "icon" => CMax::showIconSvg("cur_orders colored", SITE_TEMPLATE_PATH . '/images/svg/personal/recent_orders.svg')
    );
}


if ($arParams['SHOW_ORDER_PAGE'] === 'Y') {
    $availablePages[] = array(
        "path" => $arResult['PATH_TO_ORDERS'],
        "name" => Loc::getMessage("SPS_ORDER_PAGE_NAME"),
        //CMax::showIconSvg("cat_icons light-ignore", $arImg["src"]);
        //"icon" => '<i class="cur_orders"></i>'
        "icon" => CMax::showIconSvg("cur_orders colored", SITE_TEMPLATE_PATH . '/images/svg/personal/recent_orders.svg')
    );
}

if ($arParams['SHOW_ACCOUNT_PAGE'] === 'Y') {
    $availablePages[] = array(
        "path" => $arResult['PATH_TO_ACCOUNT'],
        "name" => Loc::getMessage("SPS_ACCOUNT_PAGE_NAME"),
        //"icon" => '<i class="bill"></i>'
        "icon" => CMax::showIconSvg("bill colored", SITE_TEMPLATE_PATH . '/images/svg/personal/personal_account.svg')
    );
}

if ($arParams['SHOW_PRIVATE_PAGE'] === 'Y') {
    $availablePages[] = array(
        "path" => $arResult['PATH_TO_PRIVATE'],
        "name" => Loc::getMessage("SPS_PERSONAL_PAGE_NAME"),
        //"icon" => '<i class="personal"></i>'
        "icon" => CMax::showIconSvg("personal colored", SITE_TEMPLATE_PATH . '/images/svg/personal/personal_data.svg')
    );
}

if ($arParams['SHOW_ORDER_PAGE'] === 'Y') {

    $delimeter = ($arParams['SEF_MODE'] === 'Y') ? "?" : "&";
    $availablePages[] = array(
        "path" => $arResult['PATH_TO_ORDERS'] . $delimeter . "filter_history=Y",
        "name" => Loc::getMessage("SPS_ORDER_PAGE_HISTORY"),
        //"icon" => '<i class="filter_orders"></i>'
        "icon" => CMax::showIconSvg("filter_orders colored", SITE_TEMPLATE_PATH . '/images/svg/personal/orders_history.svg')
    );
}

if ($arParams['SHOW_PROFILE_PAGE'] === 'Y') {
    $availablePages[] = array(
        "path" => $arResult['PATH_TO_PROFILE'],
        "name" => Loc::getMessage("SPS_PROFILE_PAGE_NAME"),
        //"icon" => '<i class="profile"></i>'
        "icon" => CMax::showIconSvg("profile colored", SITE_TEMPLATE_PATH . '/images/svg/personal/orders_profiles.svg')
    );
}

if ($arParams['SHOW_BASKET_PAGE'] === 'Y') {
    $availablePages[] = array(
        "path" => $arParams['PATH_TO_BASKET'],
        "name" => Loc::getMessage("SPS_BASKET_PAGE_NAME"),
        //"icon" => '<i class="cart"></i>'
        "icon" => CMax::showIconSvg("cart colored", SITE_TEMPLATE_PATH . '/images/svg/personal/basket.svg')
    );
}

if ($arParams['SHOW_SUBSCRIBE_PAGE'] === 'Y') {
    $availablePages[] = array(
        "path" => $arResult['PATH_TO_SUBSCRIBE'],
        "name" => Loc::getMessage("SPS_SUBSCRIBE_PAGE_NAME"),
        //"icon" => '<i class="subscribe"></i>'
        "icon" => CMax::showIconSvg("subscribe colored", SITE_TEMPLATE_PATH . '/images/svg/personal/subscribes.svg')
    );
}

if ($arParams['SHOW_CONTACT_PAGE'] === 'Y') {
    $availablePages[] = array(
        "path" => $arParams['PATH_TO_CONTACT'],
        "name" => Loc::getMessage("SPS_CONTACT_PAGE_NAME"),
        //"icon" => '<i class="contact"></i>'
        "icon" => CMax::showIconSvg("contact colored", SITE_TEMPLATE_PATH . '/images/svg/personal/contacts.svg')
    );
}

if (\Aspro\Functions\CAsproMax::isBonusSystemOn() && $arParams['SHOW_BONUS_PAGE'] !== 'N') {
    $availablePages[] = array(
        "path" => $arParams['PATH_TO_BONUS'] ?? SITE_DIR . 'personal/bonus/',
        "name" => Loc::getMessage("SPS_BONUS_PAGE_NAME"),
        "icon" => CMax::showIconSvg("bonus_lk colored", SITE_TEMPLATE_PATH . '/images/svg/personal/bonus_lk.svg')
    );
}

$customPagesList = CUtil::JsObjectToPhp($arParams['~CUSTOM_PAGES']);
if ($customPagesList) {
    foreach ($customPagesList as $page) {
        $availablePages[] = array(
            "path" => $page[0],
            "name" => $page[1],
            "icon" => (strlen($page[2])) ? '<i class="fa ' . htmlspecialcharsbx($page[2]) . '"></i>' : ""
        );
    }
}

if (empty($availablePages)) {
    ShowError(Loc::getMessage("SPS_ERROR_NOT_CHOSEN_ELEMENT"));
} else {
    ?>
    <?php   $cabinetNumber = \Bitrix\Main\UserTable::getList([
        'select' => ['UF_CABINET_NUMBER'],
        'filter' => ['=ID' => \Bitrix\Main\Engine\CurrentUser::get()->getId()],
    ])->fetch()['UF_CABINET_NUMBER'];?>
    <div class="accent-text">Кабинет №<?=$cabinetNumber?></div>
    <div class="personal_wrapper">
        <div class="row sale-personal-section-row-flex">
            <?
            foreach ($availablePages as $blockElement) {
                ?>
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-6">
                    <div class="sale-personal-section-index-block bx-theme-<?= $theme ?>">
                        <a class="sale-personal-section-index-block-link box-shadow"
                           href="<?= htmlspecialcharsbx($blockElement['path']) ?>">
						<span class="sale-personal-section-index-block-ico">
							<?= $blockElement['icon'] ?>
						</span>
                            <h2 class="sale-personal-section-index-block-name color-theme-hover">
                                <?= htmlspecialcharsbx($blockElement['name']) ?>
                            </h2>
                        </a>
                    </div>
                </div>
                <?
            }
            ?>
        </div>
    </div>
    <?
}
?>
