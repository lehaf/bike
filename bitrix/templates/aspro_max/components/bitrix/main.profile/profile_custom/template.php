<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if($arResult['SHOW_SMS_FIELD'] && !$arResult["strProfileError"]){
	CJSCore::Init('phone_auth');
}

\Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/choices.min.css", ['GROUP' => 1]);
\Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/catalog/filter.css", ['GROUP' => 1000]);

\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/choices.min.js", ['GROUP' => 1]);

global $arTheme;

// get phone auth params
list($bPhoneAuthSupported, $bPhoneAuthShow, $bPhoneAuthRequired, $bPhoneAuthUse) = Aspro\Max\PhoneAuth::getOptions();

?>
<div class="module-form-block-wr lk-page border_block">
	<?if($arResult["strProfileError"]):?>
		<?//ShowError($arResult["strProfileError"]);?>
		<div class="alert alert-danger compact"><?=$arResult["strProfileError"]?></div>
	<?endif;?>
	<?if($arResult['DATA_SAVED'] === 'Y'):?>
		<div class="alert alert-success compact"><?=GetMessage('PROFILE_DATA_SAVED')?></div>
	<?endif;?>
	<?if($arResult["SHOW_SMS_FIELD"] && !$arResult["strProfileError"]):?>
		<div class="alert alert-success compact"><?=GetMessage('main_profile_code_sent')?></div>
	<?endif;?>
	<div class="form-block-wr">
		<?if($arResult["SHOW_SMS_FIELD"] && !$arResult["strProfileError"]):?>
			<form method="post" name="form1" class="main" action="<?=$arResult["FORM_TARGET"]?>?" enctype="multipart/form-data">
				<?=$arResult["BX_SESSION_CHECK"]?>
				<input type="hidden" name="lang" value="<?=LANG?>" />
				<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
				<input type="hidden" name="SIGNED_DATA" value="<?=htmlspecialcharsbx($arResult["SIGNED_DATA"])?>" />
				<div class="form-control">
					<div class="wrap_md">
						<div class="iblock label_block">
							<label><?=GetMessage("main_profile_code")?><span class="star">*</span></label>
							<input size="30" type="text" name="SMS_CODE" value="<?=htmlspecialcharsbx($arResult["SMS_CODE"])?>" autocomplete="off" />
						</div>
					</div>
				</div>
				<div class="but-r">
					<div class="line-block form_footer__bottom">
						<div class="line-block__item">
							<button class="btn btn-default btn-lg" type="submit" name="code_submit_button" value="Y"><span><?=GetMessage("main_profile_send")?></span></button>
						</div>
						<div class="line-block__item">
							<?$APPLICATION->IncludeFile(SITE_DIR."include/required_message.php", Array(), Array("MODE" => "html"));?>
						</div>
					</div>
				</div>
				<div id="bx_profile_error" style="display:none"><?ShowError("error")?></div>
				<div id="bx_profile_resend"></div>
				<script>
				new BX.PhoneAuth({
					containerId: 'bx_profile_resend',
					errorContainerId: 'bx_profile_error',
					interval: <?=$arResult["PHONE_CODE_RESEND_INTERVAL"]?>,
					data:
						<?=CUtil::PhpToJSObject([
							'signedData' => $arResult["SIGNED_DATA"],
						])?>,
					onError:
						function(response)
						{
							var errorDiv = BX('bx_profile_error');
							var errorNode = BX.findChildByClassName(errorDiv, 'errortext');
							errorNode.innerHTML = '';
							for(var i = 0; i < response.errors.length; i++)
							{
								errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br>';
							}
							errorDiv.style.display = '';
						}
				});
				</script>
			</form>
		<?else:?>
			<form method="post" name="form1" class="main" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
				<?=$arResult["BX_SESSION_CHECK"]?>
				<input type="hidden" name="lang" value="<?=LANG?>" />
				<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
				<?if($arTheme["LOGIN_EQUAL_EMAIL"]["VALUE"] == "Y"):?>
					<input type="hidden" name="LOGIN" maxlength="50" value="<? echo $arResult["arUser"]["LOGIN"]?>" />
				<?else:?>
					<div class="form-control">
						<div class="wrap_md">
							<div class="iblock label_block">
								<label><?=GetMessage("PERSONAL_LOGIN")?><span class="star">*</span></label>
								<input required type="text" name="LOGIN" required value="<?=$arResult["arUser"]["LOGIN"]?>" />
							</div>
						</div>
					</div>
				<?endif?>
				<?if($arTheme["PERSONAL_ONEFIO"]["VALUE"] == "Y"):?>
					<div class="form-control">
						<div class="wrap_md">
							<div class="iblock label_block">
								<label><?=GetMessage("PERSONAL_FIO")?><span class="star">*</span></label>
								<?
								$arName = array();
								if(!$arResult["strProfileError"])
								{
									if($arResult["arUser"]["LAST_NAME"]){
										$arName[] = $arResult["arUser"]["LAST_NAME"];
									}
									if($arResult["arUser"]["NAME"]){
										$arName[] = $arResult["arUser"]["NAME"];
									}
									if($arResult["arUser"]["SECOND_NAME"]){
										$arName[] = $arResult["arUser"]["SECOND_NAME"];
									}
								}
								else
									$arName[] = htmlspecialcharsbx($_POST["NAME"]);
								?>
								<input required type="text" name="NAME" maxlength="50" value="<?=implode(' ', $arName);?>" />
							</div>
						</div>
					</div>
				<?else:?>
<!--					<div class="form-control">-->
<!--						<div class="wrap_md">-->
<!--							<div class="iblock label_block">-->
<!--								<label>--><?php //=GetMessage("PERSONAL_LASTNAME")?><!--</label>-->
<!--								<input type="text" name="LAST_NAME" maxlength="50" value="--><?php //=$arResult["arUser"]["LAST_NAME"];?><!--" />-->
<!--							</div>-->
<!--						</div>-->
<!--					</div>-->
					<div class="form-control">
						<div class="wrap_md">
							<div class="iblock label_block">
								<label><?=GetMessage("PERSONAL_NAME")?></label>
								<input type="text" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"];?>" />
							</div>
						</div>
					</div>
<!--					<div class="form-control">-->
<!--						<div class="wrap_md">-->
<!--							<div class="iblock label_block">-->
<!--								<label>--><?php //=GetMessage("PERSONAL_SECONDNAME")?><!--</label>-->
<!--								<input type="text" name="SECOND_NAME" maxlength="50" value="--><?php //=$arResult["arUser"]["SECOND_NAME"];?><!--" />-->
<!--							</div>-->
<!--						</div>-->
<!--					</div>-->
				<?endif;?>
				<div class="form-control">
					<div class="wrap_md">
						<div class="iblock label_block">
							<label><?=GetMessage("PERSONAL_EMAIL")?><span class="star">*</span></label>
							<input required type="text" name="EMAIL" maxlength="50" placeholder="name@company.ru" value="<? echo $arResult["arUser"]["EMAIL"]?>" />
						</div>
						<div class="iblock text_block">
							<?if($arTheme["LOGIN_EQUAL_EMAIL"]["VALUE"] != "Y"):?>
								<?=GetMessage("PERSONAL_EMAIL_SHORT_DESCRIPTION")?>
							<?else:?>
								<?=GetMessage("PERSONAL_EMAIL_DESCRIPTION")?>
							<?endif;?>
						</div>
					</div>
				</div>
				<?$mask = \Bitrix\Main\Config\Option::get('aspro.max', 'PHONE_MASK', '+7 (999) 999-99-99');?>
				<div class="form-control">
					<div class="wrap_md">
						<div class="iblock label_block">
							<label><?=GetMessage("PERSONAL_PHONE")?><span class="star">*</span></label>
							<?
							if(strlen($arResult["arUser"]["PERSONAL_PHONE"]) && strpos($arResult["arUser"]["PERSONAL_PHONE"], '+') === false && strpos($mask, '+') !== false){
								$arResult["arUser"]["PERSONAL_PHONE"] = '+'.$arResult["arUser"]["PERSONAL_PHONE"];
							}
							?>
							<input required type="tel" name="PERSONAL_PHONE" class="phone" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" />
						</div>
					</div>
				</div>
				<?if($arResult['PHONE_REGISTRATION']):?>
					<div class="form-control">
						<div class="wrap_md">
							<div class="iblock label_block">
								<label><?=GetMessage("main_profile_phone_number")?><?=($arResult['PHONE_REQUIRED'] ? '<span class="star">*</span>' : '')?></label>
								<?
								if(strlen($arResult["arUser"]["PHONE_NUMBER"]) && strpos($arResult["arUser"]["PHONE_NUMBER"], '+') === false && strpos($mask, '+') !== false){
									$arResult["arUser"]["PHONE_NUMBER"] = '+'.$arResult["arUser"]["PHONE_NUMBER"];
								}
								?>
								<input <?=($arResult['PHONE_REQUIRED'] ? 'required' : '')?> type="tel" name="PHONE_NUMBER" class="phone" maxlength="255" value="<?=$arResult["arUser"]["PHONE_NUMBER"]?>" />
							</div>
							<div class="iblock text_block">
								<?=GetMessage("PHONE_NUMBER_DESCRIPTION".($bPhoneAuthUse ? '_WITH_AUTH' : ''))?>
							</div>
						</div>
					</div>
				<?endif;?>

<!--                страна, регион и город-->
                <div class="form-control">
                    <div class="iblock label_block">
                        <label><?=GetMessage('PERSONAL_LOCATION')?><?=($arResult['PHONE_REQUIRED'] ? '<span class="star">*</span>' : '')?></label>
                    </div>
                    <div class="text_block">
                        <?=GetMessage('PERSONAL_LOCATION_DESCRIPTION')?>
                    </div>
                    <div class="form-row flex-row location-group-select">
                        <div class="form-row__col-30">
                            <div class="form-group custom-select-inner form-group-custom-select">
                                <div class="form-row">
                                    <select name="UF_COUNTRY_ID"
                                            class="select-type  custom-select-list iks-ignore" id="country">
                                        <option value="" selected>
                                            Страна
                                        </option>
                                        <option value="reset">
                                            Сбросить
                                        </option>
                                        <?php foreach ($arResult['COUNTRIES'] as $country): ?>
                                            <option
                                                    value="<?= $country['ID'] ?>"
                                                <?=($arResult['arUser']['UF_COUNTRY_ID'] === $country['ID']) ? 'selected' : ''?>
                                            >
                                                <?= $country['NAME_RU'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row__col-30 select-region">
                            <div class="form-group custom-select-inner form-group-custom-select">
                                <div class="form-row">
                                    <select name="UF_REGION_ID"
                                            class="select-type  custom-select-list iks-ignore" id="region"
                                            data-select="region-list"
                                        <?=(!empty($arResult['arUser']['UF_COUNTRY_ID'])) ? '' : 'disabled'?>
                                    >
                                        <option value="" selected>
                                            Область
                                        </option>
                                        <option value="reset">
                                            Сбросить
                                        </option>
                                        <?php if(!empty($arResult['REGIONS'])):?>
                                            <?php foreach ($arResult['REGIONS'] as $region): ?>
                                                <option
                                                        value="<?= $region['ID'] ?>"
                                                    <?=($arResult['arUser']['UF_REGION_ID'] === $region['ID']) ? 'selected' : ''?>
                                                >
                                                    <?= $region['NAME'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row__col-30 select-city">
                            <div class="form-group custom-select-inner form-group-custom-select">
                                <div class="form-row">
                                    <select name="UF_CITY_ID" class="select-type custom-select-list iks-ignore"
                                            id="city"
                                            data-select="city-list"
                                        <?=(!empty($arResult['arUser']['UF_REGION_ID'])) ? '' : 'disabled'?>
                                    >
                                        <option value="" selected>
                                            Город
                                        </option>
                                        <option value="reset">
                                            Сбросить
                                        </option>
                                        <?php if(!empty($arResult['CITIES'])):?>
                                            <?php foreach ($arResult['CITIES'] as $city): ?>
                                                <option
                                                        value="<?= $city['ID'] ?>"
                                                    <?=($arResult['arUser']['UF_CITY_ID'] === $city['ID']) ? 'selected' : ''?>
                                                >
                                                    <?= $city['NAME'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


				<div class="but-r">
					<div class="line-block form_footer__bottom">
						<div class="line-block__item">
							<button class="btn btn-default btn-lg" type="submit" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE_TITLE") : GetMessage("MAIN_ADD_TITLE"))?>"><span><?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE_TITLE") : GetMessage("MAIN_ADD_TITLE"))?></span></button>
						</div>
						<div class="line-block__item">
							<div class="required-fields-note">
								<span class="star">*</span> &ndash; <?=GetMessage('FORM_REQUIRED_FIELDS');?>
							</div>
						</div>
					</div>
				</div>
			</form>
		<?endif;?>
	</div>
	<script>
	$(document).ready(function(){
		$(".form-block-wr form").validate({rules:{ EMAIL: { email: true }}	});
	})
	if (typeof appAspro === 'object' && appAspro && appAspro.phone) {
		appAspro.phone.init($('.form-block-wr input.phone'), {
			coutriesData: '<?=CMax::$arParametrsList['FORMS']['OPTIONS']['USE_INTL_PHONE']['DEPENDENT_PARAMS']['PHONE_CITIES']['TYPE_SELECT']['SRC']?>',
			mask: arAsproOptions['THEME']['PHONE_MASK'],
			onlyCountries: '<?=CMax::GetFrontParametrValue('PHONE_CITIES');?>',
			preferredCountries: '<?=CMax::GetFrontParametrValue('PHONE_CITIES_FAVORITE');?>'
		})
	}
	</script>
</div>
<?$arScripts = ['phone_input']?>
<?if (CMax::GetFrontParametrValue('USE_INTL_PHONE') === 'Y'):?>
	<?$arScripts[] = 'intl_phone_input'?>
<?elseif (CMax::GetFrontParametrValue('PHONE_MASK')):?>
	<?$arScripts[] = 'phone_mask'?>
<?endif;?>
<?\Aspro\Max\Functions\Extensions::init($arScripts);?>