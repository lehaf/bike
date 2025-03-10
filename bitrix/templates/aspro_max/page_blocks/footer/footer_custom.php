<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
global $arTheme;
$bPrintButton = isset($arTheme['PRINT_BUTTON']) ? ($arTheme['PRINT_BUTTON']['VALUE'] == 'Y' ? true : false) : false;
?>
<div class="footer-v1">
	<div class="footer-inner">
		<div class="footer_top">
			<div class="maxwidth-theme">
				<div class="row">
					<div class="col-md-2 col-sm-3">
						<div class="fourth_bottom_menu">
							<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
								array(
									"COMPONENT_TEMPLATE" => ".default",
									"PATH" => SITE_DIR."include/footer/menu/menu_bottom1.php",
									"AREA_FILE_SHOW" => "file",
									"AREA_FILE_SUFFIX" => "",
									"AREA_FILE_RECURSIVE" => "Y",
									"EDIT_TEMPLATE" => "include_area.php"
								),
								false, array("HIDE_ICONS" => "Y")
							);?>
						</div>
					</div>
					<div class="col-md-2 col-sm-3">
						<div class="first_bottom_menu">
							<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
								array(
									"COMPONENT_TEMPLATE" => ".default",
									"PATH" => SITE_DIR."include/footer/menu/menu_bottom2.php",
									"AREA_FILE_SHOW" => "file",
									"AREA_FILE_SUFFIX" => "",
									"AREA_FILE_RECURSIVE" => "Y",
									"EDIT_TEMPLATE" => "include_area.php"
								),
								false, array("HIDE_ICONS" => "Y")
							);?>
						</div>
					</div>
					<div class="col-md-3 col-sm-3">
						<div class="second_bottom_menu">
							<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
								array(
									"COMPONENT_TEMPLATE" => ".default",
									"PATH" => SITE_DIR."include/footer/menu/menu_bottom3.php",
									"AREA_FILE_SHOW" => "file",
									"AREA_FILE_SUFFIX" => "",
									"AREA_FILE_RECURSIVE" => "Y",
									"EDIT_TEMPLATE" => "include_area.php"
								),
								false, array("HIDE_ICONS" => "Y")
							);?>
						</div>
					</div>
					<div class="col-md-2 col-sm-3">
						<div class="third_bottom_menu">
							<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
								array(
									"COMPONENT_TEMPLATE" => ".default",
									"PATH" => SITE_DIR."include/footer/menu/menu_bottom4.php",
									"AREA_FILE_SHOW" => "file",
									"AREA_FILE_SUFFIX" => "",
									"AREA_FILE_RECURSIVE" => "Y",
									"EDIT_TEMPLATE" => "include_area.php"
								),
								false, array("HIDE_ICONS" => "Y")
							);?>
						</div>
					</div>
					<div class="col-md-3 col-sm-12 contact-block">
						<div class="info">
							<div class="row">
								<?if(\Bitrix\Main\Loader::includeModule('subscribe') && $arTheme['HIDE_SUBSCRIBE']['VALUE'] != 'Y'):?>
									<div class="col-md-12 col-sm-12">
										<div class="subscribe_button">
											<a href="https://t.me/bike_by" class="btn" data-param-id="subscribe" data-param-type="subscribe" data-name="subscribe">Подписаться на наш Telegram<?=CMax::showIconSvg('subscribe', SITE_TEMPLATE_PATH.'/images/svg/subscribe_small_footer.svg')?></a>
										</div>
									</div>
								<?endif;?>
<!--								<div class="col-md-12 col-sm-12">-->
<!--									<div class="phone blocks">-->
<!--										<div class="inline-block">-->
<!--											--><?//CMax::ShowHeaderPhones('white sm', true);?>
<!--										</div>-->
<!--										--><?//$callbackExploded = explode(',', $arTheme['SHOW_CALLBACK']['VALUE']);
//										if( in_array('FOOTER', $callbackExploded) ):?>
<!--											<div class="inline-block callback_wrap">-->
<!--												<span class="callback-block animate-load colored" data-event="jqm" data-param-form_id="CALLBACK" data-name="callback">--><?php //=GetMessage("CALLBACK")?><!--</span>-->
<!--											</div>-->
<!--										--><?//endif;?>
<!--									</div>-->
<!--								</div>-->
<!--								<div class="col-md-12 col-sm-12">-->
<!--									--><?php //=CMax::showEmail('email blocks')?>
<!--								</div>-->
<!--								<div class="col-md-12 col-sm-12">-->
<!--									--><?php //=CMax::showAddress('address blocks')?>
<!--								</div>-->

                                <div class="col-md-12 col-sm-12" style="margin-top: 30px">
                                    <div class="confidentiality">
                                        <?=CMax::showIconSvg('privacy_policy', SITE_TEMPLATE_PATH.'/images/svg/privacy_policy.svg')?>
                                        <?$APPLICATION->IncludeFile(SITE_DIR."include/footer/confidentiality.php", Array(), Array(
                                                "MODE" => "php",
                                                "NAME" => "onfidentiality",
                                                "TEMPLATE" => "include_area.php",
                                            )
                                        );?>
                                    </div>
                                    <div class="confidentiality">
                                        <?=CMax::showIconSvg('privacy_policy', SITE_TEMPLATE_PATH.'/images/svg/privacy_policy.svg')?>
                                        <?$APPLICATION->IncludeFile(SITE_DIR."include/footer/confidentiality1.php", Array(), Array(
                                                "MODE" => "php",
                                                "NAME" => "onfidentiality",
                                                "TEMPLATE" => "include_area.php",
                                            )
                                        );?>
                                    </div>
                                    <div class="confidentiality">
                                        <?=CMax::showIconSvg('privacy_policy', SITE_TEMPLATE_PATH.'/images/svg/privacy_policy.svg')?>
                                        <?$APPLICATION->IncludeFile(SITE_DIR."include/footer/confidentiality2.php", Array(), Array(
                                                "MODE" => "php",
                                                "NAME" => "onfidentiality",
                                                "TEMPLATE" => "include_area.php",
                                            )
                                        );?>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12" style="margin-top: 30px">
                                    <div class="footer-info copy font_xxs">
                                        <?$APPLICATION->IncludeFile(SITE_DIR."include/footer/footer_info.php", Array(), Array(
                                                "MODE" => "php",
                                                "NAME" => "info",
                                                "TEMPLATE" => "include_area.php",
                                            )
                                        );?>
                                    </div>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="footer_middle">
			<div class="maxwidth-theme">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="social-block">
							<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
								array(
									"COMPONENT_TEMPLATE" => ".default",
									"PATH" => SITE_DIR."include/footer/social.info.php",
									"AREA_FILE_SHOW" => "file",
									"AREA_FILE_SUFFIX" => "",
									"AREA_FILE_RECURSIVE" => "Y",
									"EDIT_TEMPLATE" => "include_area.php"
								),
								false, array("HIDE_ICONS" => "Y")
							);?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="footer_bottom">
			<div class="maxwidth-theme">
				<div class="footer-bottom__items-wrapper">
					<div class="footer-bottom__item copy font_xs">
						<?$APPLICATION->IncludeFile(SITE_DIR."include/footer/copy/copyright.php", Array(), Array(
								"MODE" => "php",
								"NAME" => "Copyright",
								"TEMPLATE" => "include_area.php",
							)
						);?>
					</div>
					<div id="bx-composite-banner"></div>
					<div class="footer-bottom__item pays">
						<?$APPLICATION->IncludeFile(SITE_DIR."include/footer/copy/pay_system_icons.php", Array(), Array(
								"MODE" => "php",
								"NAME" => "onfidentiality",
								"TEMPLATE" => "include_area.php",
							)
						);?>
					</div>
					<?=\Aspro\Functions\CAsproMax::showDeveloperBlock();?>
				</div>
			</div>
		</div>
	</div>
</div>