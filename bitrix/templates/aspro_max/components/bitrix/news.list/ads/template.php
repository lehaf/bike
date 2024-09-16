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

Asset::getInstance()->addCss("https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css");
Asset::getInstance()->addCss($templateFolder . '/style.css');
$firstTab = $arResult['SECTIONS'][array_key_first($arResult['SECTIONS'])]['ID'];
$activeSect = (isset($_GET['section'])) ? $_GET['section'] : $firstTab;
$ajax = false;
if ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') $ajax = true;
?>
<?php //if ($arParams["DISPLAY_TOP_PAGER"]): ?>
<!--    --><?php //= $arResult["NAV_STRING"] ?><!--<br/>-->
<?php //endif; ?>
<?php if ($ajax === true && $_GET['section'] && !$_GET['subsection']) {ob_end_clean();} ?>
<?php if(!empty($arResult['SECTIONS'])):?>
    <div class="advert-tabs">
        <?php foreach ($arResult['SECTIONS'] as $sect): ?>
            <a href="section=<?= $sect['ID'] ?>" data-sect="<?= $sect['ID'] ?>"
               class="advert-tabs__item <?= ($activeSect === $sect['ID']) ? 'active' : '' ?>">
                <?= $sect['NAME'] ?> (<?= $sect['COUNT'] ?>)
            </a>
        <?php endforeach; ?>
    </div>
<?php endif;?>
<?php if (!empty($arResult['ITEMS'])): ?>
    <?php if ((int)$activeSect !== PRODUCTS_SECTION_ID) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/page_blocks/moto.php')) include($_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/page_blocks/moto.php');
    } else {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/page_blocks/product.php')) include($_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/page_blocks/product.php');
    } ?>
<?php elseif(empty($arResult['SECTIONS'])): ?>
    <div class="advert-empty">
        <p class="advert-empty__text">Нет объявлений</p>
        <a href="/add" class="advert-empty__btn">
            Разместить бесплатно
            <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.22545 0.848145V11.1519M11.4509 6H1" stroke="white" stroke-width="1.4"
                      stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
    </div>
<?php endif; ?>
<?php if ($ajax === true && $_GET['section'] && !$_GET['subsection']) {
    die();
} ?>

<?php //if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
<!--    <br/>--><?php //= $arResult["NAV_STRING"] ?>
<?php //endif; ?>

<script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>

