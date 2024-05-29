<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
\Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/header/header_custom.css", ['GROUP' => 1000]);

global $arTheme, $arRegion, $bLongHeader2, $dopClass;

$arRegions = CMaxRegionality::getRegions();
$bIncludeRegionsList = $arRegions || ($arTheme['USE_REGIONALITY']['VALUE'] !== 'Y' && $arTheme['USE_REGIONALITY']['DEPENDENT_PARAMS']['REGIONALITY_IPCITY_IN_HEADER']['VALUE'] !== 'N');

if($arRegion)
	$bPhone = ($arRegion['PHONES'] ? true : false);
else
	$bPhone = ((int)$arTheme['HEADER_PHONES'] ? true : false);

$logoClass = ($arTheme['COLORED_LOGO']['VALUE'] !== 'Y' ? '' : ' colored');
$bLongHeader2 = true;
$dopClass = 'wides_menu smalls big_header';
?>
<div class="header-wrapper fix-logo header-v27 new-header">
    <div class="logo_and_menu-row showed icons_top">
        <div class="_header-top">
            <div class="maxwidth-theme wides">
                <div class="header__sub-inner">
                    <div class="content-block no-area header__right-part minwidth0">
                        <div class="subtop lines-block header__top-part items-wrapper top-block top-block-v1">
                            <div class="header__top-item dotted-flex-1 hide-dotted dotted-complete">
                                <div class="menus">
                                    <?php $APPLICATION->IncludeComponent("bitrix:main.include", ".default",
                                        array(
                                            "COMPONENT_TEMPLATE" => ".default",
                                            "PATH" => SITE_DIR."include/menu/menu.topest2.php",
                                            "AREA_FILE_SHOW" => "file",
                                            "AREA_FILE_SUFFIX" => "",
                                            "AREA_FILE_RECURSIVE" => "Y",
                                            "EDIT_TEMPLATE" => "include_area.php"
                                        ),
                                        false
                                    );?>
                                </div>
                            </div>
                            <div class="right-icons header__top-item logo_and_menu-row showed icons_top _right-menu">
                                <div class="line-block__item line-block line-block--40 line-block--40-1200">
                                    <div class="wrap_icon wrap_basket baskets">
                                        <a rel="nofollow" class="basket-link delay big counter-state--empty"
                                           href="/personal/favorite/" title="Избранные товары">
                                            <span class="js-basket-block">
                                                <i class="svg wish big inline " aria-hidden="true">
                                                    <svg class="favorite-icon" width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M14.9425 2.18067C16.5889 3.82708 16.5889 6.49643 14.9425 8.14283L9.18487 13.9005C8.85561 14.2298 8.3217 14.2298 7.99244 13.9005L2.23482 8.14283C0.588394 6.49643 0.588394 3.82708 2.23482 2.18067C3.54372 0.871767 5.12364 0.470985 6.71784 1.24887C7.35061 1.55762 8.18022 2.18067 8.58865 2.99452C8.99709 2.18067 9.8267 1.55762 10.4594 1.24887C12.0536 0.470985 13.6336 0.871767 14.9425 2.18067Z" stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </i>
                                                <span class="title dark_link">Избранные товары</span>
                                                <span class="count js-count empted">0</span>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="wrap_icon wrap_basket baskets">
                                        <!--noindex-->
                                        <a class="basket-link compare big" href="/catalog/compare.php"
                                           title="Список сравниваемых элементов">
                                            <span class="js-basket-block">
                                                <i class="svg svg-inline-compare big inline "
                                                   aria-hidden="true">
                                                    <svg class="compare-icon" width="17" height="13" viewBox="0 0 17 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M13.9059 12.052V7.68963M1.58984 5.5H12.4558M1.58984 1.21484H12.4558M1.58984 9.78516H8.97883M11.741 9.78516H16.0661" stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </i>
                                                <span class="title dark_link">Сравнение</span>
                                                <span class="count">0</span>
                                            </span>
                                        </a>
                                        <!--/noindex-->
                                    </div>
                                </div>
                                <?php global $USER?>
                                <?php if (!$USER->IsAuthorized()):?>
                                    <div class="line-block line-block--40 line-block--40-1200">
                                        <div class="line-block__item no-shrinked">
                                            <div class="wrap_icon inner-table-block1 person">
                                                <!--'start_frame_cache_header-auth-block2'-->            <!-- noindex -->
                                                <div class="auth_wr_inner ">
                                                    <a rel="nofollow" title="Мой кабинет"
                                                       class="personal-link dark-color animate-load"
                                                       data-event="jqm"
                                                       data-param-backurl="%2F%3Fback_url_admin%3D%252Fbitrix%252Fadmin%252Fevent_log.php%253Flang%253Dru"
                                                       data-param-type="auth" data-name="auth"
                                                       href="/personal/">
                                                        <i class="svg svg-inline-cabinet big inline " aria-hidden="true">
                                                            <svg width="13" height="15" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M10.7928 13.4501C11.6646 13.4501 12.4071 12.7419 12.2096 11.9048C11.718 9.82241 10.0743 8.78125 6.84645 8.78125C3.61861 8.78125 1.97487 9.82241 1.48333 11.9048C1.28572 12.7419 2.02833 13.4501 2.90013 13.4501H10.7928Z" stroke="#505456" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.84631 6.44704C8.42484 6.44704 9.2141 5.66889 9.2141 3.72352C9.2141 1.77815 8.42484 1 6.84631 1C5.26778 1 4.47852 1.77815 4.47852 3.72352C4.47852 5.66889 5.26778 6.44704 6.84631 6.44704Z" stroke="#505456" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                        </i>
                                                        <span class="wrap">
                                                            <span class="name">Войти</span>
                                                        </span>
                                                    </a>
                                                </div>
                                                <!-- /noindex -->        <!--'end_frame_cache_header-auth-block2'-->
                                            </div>
                                        </div>
                                    </div>
                                <?php else:?>
                                    <div class="line-block line-block--40 line-block--40-1200">
                                        <div class="line-block__item no-shrinked">
                                            <div class="wrap_icon inner-table-block1 person">
                                                <!--'start_frame_cache_header-auth-block2'-->			<!-- noindex -->
                                                <div class="auth_wr_inner with_dropdown">
                                                    <a rel="nofollow" title="admin" class="personal-link dark-color logined" href="/personal/">
                                                        <i class="svg svg-inline-cabinet big inline " aria-hidden="true">
                                                            <svg width="13" height="15" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M10.7928 13.4501C11.6646 13.4501 12.4071 12.7419 12.2096 11.9048C11.718 9.82241 10.0743 8.78125 6.84645 8.78125C3.61861 8.78125 1.97487 9.82241 1.48333 11.9048C1.28572 12.7419 2.02833 13.4501 2.90013 13.4501H10.7928Z" stroke="#505456" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.84631 6.44704C8.42484 6.44704 9.2141 5.66889 9.2141 3.72352C9.2141 1.77815 8.42484 1 6.84631 1C5.26778 1 4.47852 1.77815 4.47852 3.72352C4.47852 5.66889 5.26778 6.44704 6.84631 6.44704Z" stroke="#505456" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                        </i>
                                                        <span class="wrap"><span class="name">Мой кабинет</span></span>
                                                    </a>
                                                    <i class="svg downs big inline " aria-hidden="true">
                                                        <svg width="5" height="3">
                                                            <use xlink:href="/bitrix/templates/aspro_max/images/svg/header_icons_srite.svg#Triangle_down"></use>
                                                        </svg>
                                                    </i>
                                                    <?$APPLICATION->IncludeComponent(
                                                        "bitrix:menu",
                                                        "cabinet_dropdown",
                                                        Array(
                                                            "COMPONENT_TEMPLATE" => "cabinet_dropdown",
                                                            "MENU_CACHE_TIME" => "3600000",
                                                            "MENU_CACHE_TYPE" => "A",
                                                            "MENU_CACHE_USE_GROUPS" => "Y",
                                                            "MENU_CACHE_GET_VARS" => array(
                                                            ),
                                                            "DELAY" => "N",
                                                            "MAX_LEVEL" => "4",
                                                            "ALLOW_MULTI_SELECT" => "Y",
                                                            "ROOT_MENU_TYPE" => "cabinet",
                                                            "CHILD_MENU_TYPE" => "left",
                                                            "USE_EXT" => "Y"
                                                        ),
                                                        array("HIDE_ICONS" => "Y")
                                                    );?>
                                                </div><!-- /noindex -->		<!--'end_frame_cache_header-auth-block2'-->
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="_header-bottom">
           <div class="maxwidth-theme wides logo-row icons_bottom">
               <div class="header__sub-inner">
                   <div class="content-block no-area header__right-part minwidth0">
                       <div class="subcontent">
                           <div class="subbottom menu-row header__main-part">
                               <div class="logo<?=$logoClass?>">
                                   <?=CMax::ShowBufferedLogo();?>
                               </div>
                               <a href="#" class="add-announcement">
                                   Разместить бесплатно
                                   <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M6.22545 0.847656V11.1514M11.4509 5.99951H1" stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                   </svg>
                               </a>
                               <div class="header__main-item minwidth0 flex1">
                                   <div class="menu">
                                       <div class="menu-only">
                                           <nav class="mega-menu sliced heightauto">
                                               <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
                                                   array(
                                                       "COMPONENT_TEMPLATE" => ".default",
                                                       "PATH" => SITE_DIR."include/menu/menu.top_catalog_sections.php",
                                                       "AREA_FILE_SHOW" => "file",
                                                       "AREA_FILE_SUFFIX" => "",
                                                       "AREA_FILE_RECURSIVE" => "Y",
                                                       "EDIT_TEMPLATE" => "include_area.php"
                                                   ),
                                                   false, array("HIDE_ICONS" => "Y")
                                               );?>
                                           </nav>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
        </div>
    </div>
</div>