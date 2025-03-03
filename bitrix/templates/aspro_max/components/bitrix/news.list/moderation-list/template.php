<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

use \Bitrix\Main\Page\Asset;
?>

<?php
$ajax = false;
if ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') $ajax = true;
?>
<div class="advert-tabs">
    <a href="?tab=moderation" data-sect="moderation"
       class="advert-tabs__item <?=($_GET['tab'] === 'moderation') ? 'active' : ''?>">
        На модерации (<?=$arResult['COUNT_MOD']?>)
    </a>
    <a href="?tab=list" data-sect="list"
       class="advert-tabs__item <?=($_GET['tab'] === 'list') ? 'active' : ''?>">
        На исправлении у пользователя (<?=$arResult['COUNT_MOD_1']?>)
    </a>
</div>
<?php if($ajax && isset($_GET['tab'])) {ob_end_clean();}?>

<?php if (!empty($arResult['ITEMS'])): ?>
    <div class="advert-list" data-iblock="<?= $arParams['IBLOCK_ID'] ?>">
        <?php foreach ($arResult["ITEMS"] as $arItem): ?>
            <?php
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <div class="advert-item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>" data-id='<?= $arItem['ID'] ?>'>
                <div class="advert-main">
                    <div class="advert-item__row">
                        <div class="advert-item__photo">
                            <?php $img = (!empty($arItem['PREVIEW_PICTURE'])) ? $arItem['PREVIEW_PICTURE']['SRC'] : SITE_TEMPLATE_PATH . "/images/empty_img_element.png" ?>
                            <img src="<?= $img ?>" alt="img">
                        </div>
                        <div class="advert-item__info">
                            <div class="advert-item__info__left">
                                <a href="/<?= $arItem['DETAIL_PAGE_URL'] ?>"
                                   class="advert-item__title"><?= $arItem['NAME'] ?></a>
                                <!--                            --><?php //if((int)$arResult['SECTIONS'][$activeSect]['ID'] === SERVICES_SECTION_ID):?>
                                <!--                                <p class="font_xs">--><?php //=$arItem['SECTIONS_CHAIN']?><!--</p>-->
                                <!--                            --><?php //endif;?>
                                <div class="advert-item__status">
                                    <div class="advert-item__status__content">
                                        Добавлено <?=$arItem['MODERATION_FROM_DATE']?>
                                    </div>
                                    <div class="advert-item__status__content">
                                        Кабинет №<?=$arItem['USER_CABINET_NUMBER']?>
                                    </div>
                                    <div class="advert-item__status-num">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.19095 5.64706H9.98552L10.367 4.12116C10.43 3.86902 10.6855 3.71572 10.9377 3.77876C11.1898 3.84179 11.3431 4.09729 11.2801 4.34943L10.9557 5.64706H11.7647C12.0246 5.64706 12.2353 5.85775 12.2353 6.11765C12.2353 6.37755 12.0246 6.58824 11.7647 6.58824H10.7204L10.0145 9.41177H11.7647C12.0246 9.41177 12.2353 9.62245 12.2353 9.88235C12.2353 10.1423 12.0246 10.3529 11.7647 10.3529H9.77919L9.39771 11.8788C9.33468 12.131 9.07918 12.2843 8.82704 12.2212C8.5749 12.1582 8.4216 11.9027 8.48464 11.6506L8.80905 10.3529H6.01448L5.63301 11.8788C5.56997 12.131 5.31447 12.2843 5.06234 12.2212C4.8102 12.1582 4.6569 11.9027 4.71993 11.6506L5.04434 10.3529H4.23529C3.9754 10.3529 3.76471 10.1423 3.76471 9.88235C3.76471 9.62245 3.9754 9.41177 4.23529 9.41177H5.27963L5.98552 6.58824H4.23529C3.9754 6.58824 3.76471 6.37755 3.76471 6.11765C3.76471 5.85775 3.9754 5.64706 4.23529 5.64706H6.22081L6.60229 4.12116C6.66532 3.86902 6.92082 3.71572 7.17296 3.77876C7.4251 3.84179 7.5784 4.09729 7.51536 4.34943L7.19095 5.64706ZM6.95566 6.58824L6.24978 9.41177H9.04434L9.75022 6.58824H6.95566ZM4.23529 16C1.89621 16 0 14.1038 0 11.7647V4.23529C0 1.89621 1.89621 0 4.23529 0H11.7647C14.1038 0 16 1.89621 16 4.23529V11.7647C16 14.1038 14.1038 16 11.7647 16H4.23529ZM4.23529 15.0588H11.7647C13.584 15.0588 15.0588 13.584 15.0588 11.7647V4.23529C15.0588 2.416 13.584 0.941176 11.7647 0.941176H4.23529C2.416 0.941176 0.941176 2.416 0.941176 4.23529V11.7647C0.941176 13.584 2.416 15.0588 4.23529 15.0588Z"
                                                  fill="#666666"/>
                                        </svg>
                                        <?= $arItem['ID'] ?>
                                    </div>
                                </div>
                                <div class="">
                                    <label for="">Текст ошибки:</label>
                                    <?php if($_GET['tab'] !== 'list'):?>
                                        <input type="text" class="custom-input" value="<?=$arItem['PROPERTIES']['MODERATION_ERROR']['VALUE']?>">
                                    <?php else:?>
                                        <span><?=$arItem['PROPERTIES']['MODERATION_ERROR']['VALUE']?> </span>
                                    <?php endif;?>
                                </div>
                            </div>
                            <?php if($_GET['tab'] !== 'list'):?>
                            <div class="advert-item__info__right">
                                <div class="advert-edit">
                                    <a href="#" class="advert-btn-post" data-action="success">
                                        Опубликовать
                                    </a>
                                    <a href="#" class="advert-btn-pause" data-action="fail">
                                        Не прошел модерацию
                                    </a>
                                </div>
                            </div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="advert-empty">
        <p class="advert-empty__text">Нет объявлений на модерации</p>
    </div>
<?php endif; ?>

<?php if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
    <br/><?= $arResult["NAV_STRING"] ?>
<?php endif; ?>
<?php if($ajax && isset($_GET['tab'])) {die();}?>


