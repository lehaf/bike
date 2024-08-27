<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);
?>
<?php

use \Bitrix\Main\Page\Asset;

Asset::getInstance()->addCss("https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css");
Asset::getInstance()->addCss($templateFolder . '/style.css');

$lastSectKey = (!empty($arResult["CUSTOM_SECTIONS"])) ? array_key_last($arResult["CUSTOM_SECTIONS"]) : "";
?>
<?php if (!empty($arResult["CUSTOM_SECTIONS"])): ?>
    <div class="step">
        <div class="wrapper">
            <div class="step-category">
                <?php foreach ($arResult["CUSTOM_SECTIONS"] as $key => $sections): ?>
                    <div class="step-category-container <?= ($lastSectKey === $key) ? 'step-category-container--center' : ''; ?>">
                        <div class="step-category__title">
                            <?= Loc::getMessage($key) ?>
                        </div>
                        <div class="step-category-inner <?= ($lastSectKey === $key) ? 'step-category-inner--center' : ''; ?>">
                            <?php foreach ($sections as $number => $sect): ?>
                                <a class="step-category__el <?= ($number === count($sect) && $lastSectKey !== $key) ? 'step-category__el--center' : '' ?>"
                                   data-id="<?= $sect["ID"] ?>"
                                   href="?type=<?= $sect["ID"] ?>"
                                >
                                    <div class="step-category__el__img">
                                        <img src="<?= $sect["PICTURE"] ?>" alt="<?= $sect["NAME"] ?>"
                                             data-mobile="<?= $sect["PICTURE"] ?>">
                                    </div>
                                    <div class="step-category__el__description">
                                        <?= $sect["NAME"] ?>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.6.4.js"
            integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=e2caa9ca-c646-4d64-b8c9-bbe9b1227165"
            type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery.maskedinput@1.4.1/src/jquery.maskedinput.min.js"
            type="text/javascript"></script>

<?php
