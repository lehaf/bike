<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

use Bitrix\Iblock\SectionPropertyTable; ?>

<?php
$this->setFrameMode(true);

\Bitrix\Main\Page\Asset::getInstance()->addCss("https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css");
\Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/catalog/filter.css", ['GROUP' => 1000]);
?>
<?php
$sectCode = $arResult['SECTION']['CODE'];
$price = $arResult['ITEMS']['BASE'];
?>

<form action="#" id="filter" class="selection-block" method="get" data-sect="<?= $arResult['SECTION']['ID'] ?>"
      data-filter="<?= $arParams['FILTER_NAME'] ?>">
    <div class="form-header">
        <div class="save-search">
            <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.1842 5.2236C10.7774 5.01676 10.3175 4.93811 9.86512 4.99804C9.41274 5.05796 8.98917 5.25365 8.65036 5.55926C8.31154 5.25365 7.88798 5.05796 7.4356 4.99804C6.98322 4.93811 6.5233 5.01676 6.11656 5.2236C5.29819 5.66415 4.54278 6.79698 5.24049 8.56966C5.83328 10.143 8.04183 12.3196 8.65036 12.3196C9.25889 12.3196 11.4674 10.1378 12.0602 8.56966C12.7317 6.79698 12.0025 5.66415 11.1842 5.2236ZM11.0792 8.19729C10.6281 9.39831 9.21167 10.7462 8.65036 11.1762C8.08904 10.7357 6.67263 9.39831 6.22148 8.19729C5.77033 6.99628 6.14279 6.39839 6.60968 6.1519C6.77186 6.06833 6.95183 6.02515 7.13428 6.02603C7.35252 6.03112 7.56616 6.08975 7.75643 6.19674C7.94669 6.30374 8.10775 6.45583 8.22544 6.63965C8.27378 6.70889 8.33814 6.76544 8.41303 6.80449C8.48792 6.84353 8.57114 6.86392 8.6556 6.86392C8.74007 6.86392 8.82329 6.84353 8.89818 6.80449C8.97307 6.76544 9.03743 6.70889 9.08577 6.63965C9.24675 6.37404 9.50025 6.1773 9.79755 6.08727C10.0948 5.99723 10.4149 6.02025 10.6963 6.1519C11.1579 6.39839 11.5094 7.07495 11.0792 8.19729Z"
                      fill="#ED1C24"/>
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M11.279 5.0475C11.7284 5.28942 12.1506 5.71984 12.3692 6.3296C12.5884 6.94137 12.597 7.7173 12.2473 8.64051C11.9369 9.46138 11.2153 10.4218 10.5064 11.1702C10.1499 11.5465 9.79018 11.8762 9.4774 12.1135C9.32125 12.232 9.17305 12.3303 9.04005 12.3999C8.91315 12.4664 8.77648 12.5196 8.65036 12.5196C8.52435 12.5196 8.38774 12.4665 8.26082 12.4002C8.12782 12.3307 7.97961 12.2326 7.82346 12.1143C7.51065 11.8774 7.15087 11.5483 6.79438 11.1722C6.08575 10.4248 5.36446 9.46491 5.05385 8.64156C4.6906 7.71786 4.69898 6.94109 4.92208 6.32863C5.14434 5.71846 5.57351 5.2888 6.02176 5.0475L6.02588 5.04528C6.46867 4.8201 6.96939 4.73453 7.46187 4.79977C7.89639 4.85733 8.30649 5.02995 8.65036 5.2983C8.99422 5.02995 9.40433 4.85733 9.83885 4.79977C10.3313 4.73453 10.832 4.82015 11.2748 5.04533L11.279 5.0475ZM8.65036 5.55926C8.98917 5.25365 9.41274 5.05796 9.86512 4.99804C10.3175 4.93811 10.7774 5.01676 11.1842 5.2236C12.0025 5.66415 12.7317 6.79698 12.0602 8.56966C11.4674 10.1378 9.25889 12.3196 8.65036 12.3196C8.04183 12.3196 5.83328 10.143 5.24049 8.56966C4.54278 6.79698 5.29819 5.66415 6.11656 5.2236C6.5233 5.01676 6.98322 4.93811 7.4356 4.99804C7.88798 5.05796 8.31154 5.25365 8.65036 5.55926ZM10.892 8.12696L10.8925 8.12571C11.2973 7.06952 10.9501 6.51736 10.6066 6.33078C10.3712 6.22205 10.1039 6.20346 9.85552 6.27868C9.60544 6.35442 9.39221 6.51991 9.25681 6.74331L9.2501 6.75438C9.18332 6.85003 9.09408 6.9279 8.99064 6.98183C8.8872 7.03576 8.77226 7.06392 8.6556 7.06392C8.53895 7.06392 8.42401 7.03576 8.32057 6.98183C8.21712 6.9279 8.12823 6.84979 8.06145 6.75414L8.05686 6.74757C7.95685 6.59135 7.82011 6.46201 7.6584 6.37107C7.49723 6.28043 7.31632 6.23064 7.13148 6.22602C6.98218 6.22559 6.83496 6.26098 6.70218 6.32923C6.51078 6.43052 6.34154 6.60082 6.26352 6.87196C6.18411 7.1479 6.19261 7.55168 6.40871 8.12696C6.62121 8.69267 7.06849 9.3052 7.54394 9.8389C7.95243 10.2974 8.37047 10.6854 8.65149 10.9197C8.93137 10.6894 9.34846 10.3023 9.75661 9.84301C10.232 9.30812 10.6794 8.69288 10.892 8.12696ZM8.65036 11.1762C8.08904 10.7357 6.67263 9.39831 6.22148 8.19729C5.77033 6.99628 6.14279 6.39839 6.60968 6.1519C6.77186 6.06833 6.95183 6.02515 7.13428 6.02603C7.35252 6.03112 7.56616 6.08975 7.75643 6.19674C7.94669 6.30374 8.10775 6.45583 8.22544 6.63965C8.27378 6.70889 8.33814 6.76544 8.41303 6.80449C8.48792 6.84353 8.57114 6.86392 8.6556 6.86392C8.74007 6.86392 8.82329 6.84353 8.89818 6.80449C8.97307 6.76544 9.03743 6.70889 9.08577 6.63965C9.24675 6.37404 9.50025 6.1773 9.79755 6.08727C10.0948 5.99723 10.4149 6.02025 10.6963 6.1519C11.1579 6.39839 11.5094 7.07495 11.0792 8.19729C10.6281 9.39831 9.21167 10.7462 8.65036 11.1762Z"
                      fill="#ED1C24"/>
                <path d="M20.0395 19.2896L14.9456 14.1919C16.3926 12.5504 17.144 10.4105 17.0406 8.22499C16.9372 6.03949 15.9873 3.97997 14.3918 2.48236C12.7963 0.98475 10.6805 0.166586 8.49231 0.201046C6.30408 0.235506 4.21513 1.11989 2.66763 2.66699C1.12012 4.2141 0.235516 6.30251 0.201046 8.49018C0.166577 10.6778 0.984951 12.7931 2.48295 14.3881C3.98094 15.9832 6.04099 16.9329 8.22705 17.0363C10.4131 17.1396 12.5536 16.3885 14.1955 14.9419L19.2945 20.0449C19.3433 20.094 19.4013 20.133 19.4653 20.1597C19.5292 20.1863 19.5977 20.2 19.667 20.2C19.7362 20.2 19.8048 20.1863 19.8687 20.1597C19.9327 20.133 19.9907 20.094 20.0395 20.0449C20.0902 19.9959 20.1306 19.9373 20.1582 19.8724C20.1858 19.8075 20.2 19.7378 20.2 19.6673C20.2 19.5968 20.1858 19.527 20.1582 19.4621C20.1306 19.3972 20.0902 19.3386 20.0395 19.2896ZM8.6505 15.9908C7.19793 15.9908 5.77797 15.5602 4.57021 14.7534C3.36244 13.9466 2.42109 12.7998 1.86522 11.4582C1.30934 10.1165 1.1639 8.64019 1.44728 7.21589C1.73067 5.7916 2.43015 4.4833 3.45727 3.45644C4.48439 2.42958 5.79303 1.73027 7.21769 1.44696C8.64235 1.16365 10.1191 1.30906 11.4611 1.86479C12.8031 2.42052 13.9501 3.36162 14.7571 4.56908C15.5641 5.77654 15.9948 7.19613 15.9948 8.64833C15.9948 10.5957 15.2211 12.4633 13.8437 13.8402C12.4664 15.2172 10.5983 15.9908 8.6505 15.9908Z"
                      fill="#ED1C24"/>
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M20.1797 19.147L15.2184 14.1819C16.6194 12.5211 17.3432 10.3903 17.2404 8.21554C17.1345 5.97813 16.162 3.86971 14.5287 2.33654C12.8953 0.803373 10.7293 -0.0342074 8.48916 0.00107084C6.249 0.036349 4.11047 0.941717 2.52622 2.52555C0.941978 4.10939 0.0363591 6.2474 0.00107114 8.48703C-0.0342168 10.7267 0.803596 12.8921 2.33716 14.5251C3.87072 16.158 5.97967 17.1303 8.2176 17.2361C10.3929 17.3389 12.5241 16.6153 14.1853 15.2146L19.1526 20.1857C19.1525 20.1856 19.1526 20.1858 19.1526 20.1857C19.2199 20.2535 19.3002 20.3076 19.3884 20.3443C19.4766 20.3811 19.5714 20.4 19.667 20.4C19.7626 20.4 19.8573 20.3811 19.9456 20.3443C20.0332 20.3078 20.1128 20.2545 20.1798 20.1873C20.2492 20.1201 20.3044 20.0396 20.3423 19.9507C20.3804 19.861 20.4 19.7646 20.4 19.6673C20.4 19.5699 20.3804 19.4735 20.3423 19.3839C20.3044 19.2948 20.2491 19.2143 20.1797 19.147ZM14.1955 14.9419L19.2945 20.0449C19.3433 20.094 19.4013 20.133 19.4653 20.1597C19.5292 20.1863 19.5977 20.2 19.667 20.2C19.7362 20.2 19.8048 20.1863 19.8687 20.1597C19.9327 20.133 19.9907 20.094 20.0395 20.0449C20.0902 19.9959 20.1306 19.9373 20.1582 19.8724C20.1858 19.8075 20.2 19.7378 20.2 19.6673C20.2 19.5968 20.1858 19.527 20.1582 19.4621C20.1306 19.3972 20.0902 19.3386 20.0395 19.2896L14.9456 14.1919C16.3926 12.5504 17.144 10.4105 17.0406 8.22499C16.9372 6.03949 15.9873 3.97997 14.3918 2.48236C12.7963 0.98475 10.6805 0.166586 8.49231 0.201046C6.30408 0.235506 4.21513 1.11989 2.66763 2.66699C1.12012 4.2141 0.235516 6.30251 0.201046 8.49018C0.166577 10.6778 0.984951 12.7931 2.48295 14.3881C3.98094 15.9832 6.04099 16.9329 8.22705 17.0363C10.4131 17.1396 12.5536 16.3885 14.1955 14.9419ZM4.6813 14.5871C5.85618 15.3719 7.23747 15.7908 8.6505 15.7908C10.5453 15.7908 12.3625 15.0383 13.7023 13.6988C15.0421 12.3593 15.7948 10.5426 15.7948 8.64833C15.7948 7.2357 15.3758 5.85479 14.5908 4.68022C13.8058 3.50565 12.69 2.59018 11.3845 2.04957C10.0791 1.50897 8.64257 1.36753 7.2567 1.64312C5.87082 1.91872 4.59782 2.59898 3.59867 3.59787C2.59952 4.59677 1.9191 5.86943 1.64344 7.25492C1.36778 8.64041 1.50926 10.0765 2.04999 11.3816C2.59072 12.6867 3.50642 13.8022 4.6813 14.5871ZM4.57021 14.7534C5.77797 15.5602 7.19793 15.9908 8.6505 15.9908C10.5983 15.9908 12.4664 15.2172 13.8437 13.8402C15.2211 12.4633 15.9948 10.5957 15.9948 8.64833C15.9948 7.19613 15.5641 5.77654 14.7571 4.56908C13.9501 3.36162 12.8031 2.42052 11.4611 1.86479C10.1191 1.30906 8.64235 1.16365 7.21769 1.44696C5.79303 1.73027 4.48439 2.42958 3.45727 3.45644C2.43015 4.4833 1.73067 5.7916 1.44728 7.21589C1.1639 8.64019 1.30934 10.1165 1.86522 11.4582C2.42109 12.7998 3.36244 13.9466 4.57021 14.7534Z"
                      fill="#ED1C24"/>
            </svg>
            <span class="save-search__prev">Сохранить поиск</span>
            <span class="save-search__save">Сохранён</span>
        </div>
        <div class="save-search-popup">
            <div class="search-popup__mark">
                BMW
            </div>
            <div class="search-popup__parameters">
                4 передачи, 5 передач, 2 передачи, 3 передачи, Кардан, Ремень, Бензин турбонаддув + 1
            </div>
            <div class="form-row form-row-checkbox form-row-checkbox--selection">
                <input type="checkbox" class="input-checkbox" name="emailMes" id="emailMes">
                <label for="emailMes" class="checkbox-label">Уведомления на электронную почту</label>
            </div>
            <div class="form-group custom-select-inner form-group-custom-select color-select">
                <select name="type-moto" class="select-type custom-select right-select">
                    <option value="" selected>
                        Получать письма
                    </option>
                    <option value="reset">
                        Сбросить
                    </option>
                    <option value="2001">
                        Получать письма каждые 4 часа
                    </option>
                    <option value="2002">
                        Получать письма каждые 8 часа
                    </option>
                    <option value="2003">
                        Получать письма каждые 24 часа
                    </option>
                </select>
            </div>
            <div class="search-popup__btn">
                <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.2853 15.9999H3.42815C2.48284 15.9999 1.71387 15.2309 1.71387 14.2856V5.14272C1.71387 4.82717 1.96975 4.57129 2.2853 4.57129H11.4282C11.7437 4.57129 11.9996 4.82717 11.9996 5.14272V14.2856C11.9996 15.2309 11.2306 15.9999 10.2853 15.9999ZM2.85672 5.71415V14.2856C2.85672 14.6006 3.11312 14.857 3.42815 14.857H10.2853C10.6003 14.857 10.8567 14.6006 10.8567 14.2856V5.71415H2.85672Z"
                          fill="#ED1C24"/>
                    <path d="M12 5.71434H1.71429C0.768972 5.71434 0 4.94537 0 4.00005C0 3.05474 0.768972 2.28577 1.71429 2.28577H12C12.9453 2.28577 13.7143 3.05474 13.7143 4.00005C13.7143 4.94537 12.9453 5.71434 12 5.71434ZM1.71429 3.42862C1.39926 3.42862 1.14286 3.68502 1.14286 4.00005C1.14286 4.31508 1.39926 4.57148 1.71429 4.57148H12C12.315 4.57148 12.5714 4.31508 12.5714 4.00005C12.5714 3.68502 12.315 3.42862 12 3.42862H1.71429Z"
                          fill="#ED1C24"/>
                    <path d="M9.14286 3.42857H4.57143C4.25589 3.42857 4 3.17269 4 2.85714V0.571429C4 0.255886 4.25589 0 4.57143 0H9.14286C9.4584 0 9.71429 0.255886 9.71429 0.571429V2.85714C9.71429 3.17269 9.4584 3.42857 9.14286 3.42857ZM5.14286 2.28571H8.57143V1.14286H5.14286V2.28571Z"
                          fill="#ED1C24"/>
                    <path d="M5.14272 13.714C4.82717 13.714 4.57129 13.4581 4.57129 13.1425V7.42824C4.57129 7.1127 4.82717 6.85681 5.14272 6.85681C5.45826 6.85681 5.71415 7.1127 5.71415 7.42824V13.1425C5.71415 13.4581 5.45826 13.714 5.14272 13.714Z"
                          fill="#ED1C24"/>
                    <path d="M8.57094 13.7142C8.2554 13.7142 7.99951 13.4583 7.99951 13.1428V7.42848C7.99951 7.11294 8.2554 6.85706 8.57094 6.85706C8.88648 6.85706 9.14237 7.11294 9.14237 7.42848V13.1428C9.14237 13.4583 8.88648 13.7142 8.57094 13.7142Z"
                          fill="#ED1C24"/>
                </svg>
                Удалить историю поиска
            </div>
        </div>

        <!--        состояние-->
        <?php if (!empty($arResult['ITEMS']['state_moto']['VALUES'])): ?>
            <div class="form-row form-row-radio-block">
                <?php $curState = current($arResult['ITEMS']['state_moto']['VALUES']) ?>
                <div class="form-col">
                    <input type="radio"
                           class="radio-block"
                           name="<?= $curState['CONTROL_NAME_ALT'] ?>"
                           id="all_<?= $curState['CONTROL_ID'] ?>"
                           checked=""
                           value=""
                    >
                    <label for="all_<?= $curState['CONTROL_ID'] ?>" class="radio-block__label">Все</label>
                </div>
                <?php foreach ($arResult['ITEMS']['state_moto']['VALUES'] as $ar): ?>
                    <div class="form-col">
                        <input type="radio"
                               class="radio-block"
                               name="<?= $ar['CONTROL_NAME_ALT'] ?>"
                               id="<?= $ar['CONTROL_ID'] ?>"
                               value="<?= $ar['HTML_VALUE_ALT'] ?>"
                            <?= ($ar["CHECKED"]) ? 'checked' : '' ?>
                        >
                        <label for="<?= $ar['CONTROL_ID'] ?>"
                               class="radio-block__label"><?= $ar['VALUE'] ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!--    марка и модель-->
    <div class="model-selection">
        <div class="form-row custom-select-inner form-group-custom-select flex-row">
            <div class="form-row__col">
                <div class="form-row">
                    <select id="brand-select" name="<?= $arParams['FILTER_NAME'] ?>_mark"></select>
                </div>
                <div class="form-row add-select select-btn">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.087 4.94545H12V7.10303H7.087V12H4.90072V7.10303H0V4.94545H4.90072V0H7.087V4.94545Z"
                              fill="#666666"/>
                    </svg>
                </div>
            </div>
            <div class="form-row__col custom-select--multiple">
                <div class="form-row">
                    <select id="model-select" name="<?= $arParams['FILTER_NAME'] ?>_model" multiple disabled>
                        <option placeholder>Модель</option>
                    </select>
                </div>
                <div class="form-row remove-select select-btn">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.09856 6.44252L11.9541 10.298L10.2609 11.9912L6.40539 8.13569L2.56247 11.9786L0.846775 10.2629L4.68969 6.41999L0.843834 2.57413L2.537 0.880967L6.38286 4.72683L10.2638 0.845859L11.9795 2.56156L8.09856 6.44252Z"
                              fill="#666666"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!--    тип транспорта-->
    <div class="form-row flex-row">
        <?php if (!empty($arResult['ITEMS']['type_' . $sectCode]['VALUES'])): ?>
            <div class="form-row__col">
                <div class="custom-select-inner form-group-custom-select">
                    <div class="custom-select--multiple">
                        <select id="transportSelect" multiple
                                name="<?= current($arResult['ITEMS']['type_' . $sectCode]['VALUES'])['CONTROL_NAME_ALT'] ?>">
                            <option value=""><?= $arResult['ITEMS']['type_' . $sectCode]['NAME'] ?></option>
                            <option value="reset">Любой</option>
                            <?php foreach ($arResult['ITEMS']['type_' . $sectCode]['VALUES'] as $ar): ?>
                                <option
                                        id="<?= $ar['CONTROL_ID'] ?>"
                                        value="<?= $ar["HTML_VALUE_ALT"] ?>"
                                    <?= ($ar["CHECKED"]) ? 'selected' : '' ?>
                                >
                                    <?= $ar["VALUE"] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!--        год-->
        <?php if (!empty($arResult['ITEMS']['year']['VALUES'])): ?>
            <div class="form-row__col">
                <div class="form-row__col">
                    <div class="form-group custom-select-inner form-group-custom-select left-select color-select">
                        <select name="<?= $arParams['FILTER_NAME'] ?>_year_MIN"
                                class="select-type custom-select right-select">
                            <option value="" selected>
                                <?= $arResult['ITEMS']['year']['NAME'] ?>, от
                            </option>
                            <option value="reset">
                                Сбросить
                            </option>
                            <?php foreach ($arResult['ITEMS']['year']['VALUES'] as $ar): ?>
                                <option
                                        id="<?= $ar['CONTROL_ID'] ?>"
                                        value="<?= $ar["VALUE"] ?>"
                                    <?= ($ar["CHECKED_FOR"] === "MIN") ? 'selected' : '' ?>
                                >
                                    <?= $ar["VALUE"] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row__col">
                    <div class="form-group custom-select-inner form-group-custom-select right-select color-select">
                        <select name="<?= $arParams['FILTER_NAME'] ?>_year_MAX"
                                class="select-type custom-select">
                            <option value="" selected>
                                до
                            </option>
                            <option value="reset">
                                Сбросить
                            </option>
                            <?php foreach ($arResult['ITEMS']['year']['VALUES'] as $ar): ?>
                                <option
                                        id="<?= $ar['CONTROL_ID'] ?>"
                                        value="<?= $ar["VALUE"] ?>"
                                    <?= ($ar["CHECKED_FOR"] === 'MAX') ? 'selected' : '' ?>
                                >
                                    <?= $ar["VALUE"] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!--    цена-->
    <div class="form-row flex-row">
        <div class="form-row__col">
            <div class="form-row__col <?= (!empty($price["VALUES"]["MIN"]["HTML_VALUE"])) ? 'is-active' : '' ?>">
                <input
                        type="text"
                        name="<?= $price["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                        id="<?= $price["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                        value="<?= $price["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                        class="custom-input input-change left-input"
                        placeholder="Цена (BYN), от"
                        data-text="BYN"
                >
                <span class="reset-input">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8.98109 1.35706L1.69526 8.64289M9.03313 8.69493L1.64322 1.30502" stroke="#ED1C24" stroke-width="1.4"
      stroke-linecap="round" stroke-linejoin="round"/>
</svg>
                    </span>
            </div>
            <div class="form-row__col <?= (!empty($price["VALUES"]["MAX"]["HTML_VALUE"])) ? 'is-active' : '' ?>">
                <input
                        type="text"
                        name="<?= $price["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                        id="<?= $price["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                        value="<?= $price["VALUES"]["MAX"]['HTML_VALUE'] ?>"
                        class="custom-input input-change right-input"
                        placeholder="до"
                        data-text="BYN"
                >
                <span class="reset-input">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8.98109 1.35706L1.69526 8.64289M9.03313 8.69493L1.64322 1.30502" stroke="#ED1C24" stroke-width="1.4"
      stroke-linecap="round" stroke-linejoin="round"/>
</svg>
                    </span>
            </div>
        </div>
        <div class="form-row__col">
            <div class="form-row__col <?= (!empty($arResult['ITEMS']['race']['VALUES']['MIN']['HTML_VALUE'])) ? 'is-active' : '' ?>">
                <input
                        type="text"
                        name="<?= $arResult['ITEMS']['race']['VALUES']['MIN']['CONTROL_NAME'] ?>"
                        id="<?= $arResult['ITEMS']['race']['VALUES']['MIN']['CONTROL_ID'] ?>"
                        value="<?= $arResult['ITEMS']['race']['VALUES']['MIN']['HTML_VALUE'] ?>"
                        class="custom-input input-change left-input"
                        placeholder="Пробег (км), от"
                        data-text="км"
                >
                <span class="reset-input">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8.98109 1.35706L1.69526 8.64289M9.03313 8.69493L1.64322 1.30502" stroke="#ED1C24" stroke-width="1.4"
      stroke-linecap="round" stroke-linejoin="round"/>
</svg>
                    </span>
            </div>
            <div class="form-row__col <?= (!empty($arResult['ITEMS']['race']['VALUES']['MAX']['HTML_VALUE'])) ? 'is-active' : '' ?>">
                <input
                        type="text"
                        name="<?= $arResult['ITEMS']['race']['VALUES']['MAX']['CONTROL_NAME'] ?>"
                        id="<?= $arResult['ITEMS']['race']['VALUES']['MAX']['CONTROL_ID'] ?>"
                        value="<?= $arResult['ITEMS']['race']['VALUES']['MAX']['HTML_VALUE'] ?>"
                        class="custom-input input-change right-input"
                        placeholder="до"
                        data-text="км"
                >
                <span class="reset-input">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8.98109 1.35706L1.69526 8.64289M9.03313 8.69493L1.64322 1.30502" stroke="#ED1C24" stroke-width="1.4"
      stroke-linecap="round" stroke-linejoin="round"/>
</svg>
                    </span>
            </div>
        </div>
    </div>

    <div class="inner-more-form">
        <div class="form-row flex-row">
            <!--    объем-->
            <div class="form-row__col-30">
                <div class="form-row__col <?= (!empty($arResult['ITEMS']['power']['VALUES']['MIN']['HTML_VALUE'])) ? 'is-active' : '' ?>">
                    <input
                            type="text"
                            name="<?= $arResult['ITEMS']['power']['VALUES']['MIN']['CONTROL_NAME'] ?>"
                            id="<?= $arResult['ITEMS']['power']['VALUES']['MIN']['CONTROL_ID'] ?>"
                            value="<?= $arResult['ITEMS']['power']['VALUES']['MIN']['HTML_VALUE'] ?>"
                            class="custom-input input-change left-input"
                            placeholder="Объем (СМ3), от"
                            data-text="см³"
                    >
                    <span class="reset-input">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8.98109 1.35706L1.69526 8.64289M9.03313 8.69493L1.64322 1.30502" stroke="#ED1C24" stroke-width="1.4"
      stroke-linecap="round" stroke-linejoin="round"/>
</svg>
                    </span>
                </div>
                <div class="form-row__col <?= (!empty($arResult['ITEMS']['power']['VALUES']['MAX']['HTML_VALUE'])) ? 'is-active' : '' ?>">
                    <input
                            type="text"
                            name="<?= $arResult['ITEMS']['power']['VALUES']['MAX']['CONTROL_NAME'] ?>"
                            id="<?= $arResult['ITEMS']['power']['VALUES']['MAX']['CONTROL_ID'] ?>"
                            value="<?= $arResult['ITEMS']['power']['VALUES']['MAX']['HTML_VALUE'] ?>"
                            class="custom-input input-change right-input"
                            placeholder="до"
                            data-text="см³"
                    >
                    <span class="reset-input">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8.98109 1.35706L1.69526 8.64289M9.03313 8.69493L1.64322 1.30502" stroke="#ED1C24" stroke-width="1.4"
      stroke-linecap="round" stroke-linejoin="round"/>
</svg>
                    </span>
                </div>
            </div>

            <div class="form-row__col-30 gap-20">
                <!--                тип двигателя-->
                <?php if (!empty($arResult['ITEMS']['motor_type_' . $sectCode]['VALUES'])): ?>
                    <div class="form-row__col">
                        <div class="form-group custom-select-inner form-group-custom-select color-select">
                            <select name="<?= current($arResult['ITEMS']['motor_type_' . $sectCode]['VALUES'])['CONTROL_NAME_ALT'] ?>"
                                    class="select-type custom-select">
                                <option value="" selected>
                                    <?= $arResult['ITEMS']['motor_type_' . $sectCode]['NAME'] ?>
                                </option>
                                <option value="reset">
                                    Любой
                                </option>
                                <?php foreach ($arResult['ITEMS']['motor_type_' . $sectCode]['VALUES'] as $ar): ?>
                                    <option
                                            id="<?= $ar['CONTROL_ID'] ?>"
                                            value="<?= $ar["HTML_VALUE_ALT"] ?>"
                                        <?= ($ar["CHECKED"]) ? 'selected' : '' ?>
                                    >
                                        <?= $ar["VALUE"] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>

                <!--                количество цилиндров-->
                <?php if (!empty($arResult['ITEMS']['cylinders_count_' . $sectCode]['VALUES'])): ?>
                    <div class="form-row__col">
                        <div class="form-group custom-select-inner form-group-custom-select color-select">
                            <select name="<?= current($arResult['ITEMS']['cylinders_count_' . $sectCode]['VALUES'])['CONTROL_NAME_ALT'] ?>"
                                    class="select-type custom-select">
                                <option value="" selected>
                                    Цилиндров
                                </option>
                                <option value="reset">
                                    Сбросить
                                </option>

                                <?php foreach ($arResult['ITEMS']['cylinders_count_' . $sectCode]['VALUES'] as $ar): ?>
                                    <option
                                            id="<?= $ar['CONTROL_ID'] ?>"
                                            value="<?= $ar["HTML_VALUE_ALT"] ?>"
                                        <?= ($ar["CHECKED"]) ? 'selected' : '' ?>
                                    >
                                        <?= $ar["VALUE"] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <!--                мощность-->
            <div class="form-row__col-30">
                <div class="form-row__col <?= (!empty($arResult['ITEMS']['energy']['VALUES']['MIN']['HTML_VALUE'])) ? 'is-active' : '' ?>">
                    <input
                            type="text"
                            name="<?= $arResult['ITEMS']['energy']['VALUES']['MIN']['CONTROL_NAME'] ?>"
                            id="<?= $arResult['ITEMS']['energy']['VALUES']['MIN']['CONTROL_ID'] ?>"
                            value="<?= $arResult['ITEMS']['energy']['VALUES']['MIN']['HTML_VALUE'] ?>"
                            class="custom-input input-change left-input"
                            placeholder="Мощность (л.с.), от"
                            data-text="л.с.">
                    <span class="reset-input">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8.98109 1.35706L1.69526 8.64289M9.03313 8.69493L1.64322 1.30502" stroke="#ED1C24" stroke-width="1.4"
      stroke-linecap="round" stroke-linejoin="round"/>
</svg>
                    </span>
                </div>
                <div class="form-row__col <?= (!empty($arResult['ITEMS']['energy']['VALUES']['MAX']['HTML_VALUE'])) ? 'is-active' : '' ?>">
                    <input
                            type="text"
                            name="<?= $arResult['ITEMS']['energy']['VALUES']['MAX']['CONTROL_NAME'] ?>"
                            id="<?= $arResult['ITEMS']['energy']['VALUES']['MAX']['CONTROL_ID'] ?>"
                            value="<?= $arResult['ITEMS']['energy']['VALUES']['MAX']['HTML_VALUE'] ?>"
                            class="custom-input input-change right-input"
                            placeholder="до"
                            data-text="л.с.">
                    <span class="reset-input">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8.98109 1.35706L1.69526 8.64289M9.03313 8.69493L1.64322 1.30502" stroke="#ED1C24" stroke-width="1.4"
      stroke-linecap="round" stroke-linejoin="round"/>
</svg>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-row flex-row">
            <!--            расположение цилиндров-->
            <?php if (!empty($arResult['ITEMS']['cylinder_place_' . $sectCode]['VALUES'])): ?>
                <div class="form-row__col-30">
                    <div class="custom-select-inner form-group-custom-select">
                        <div class="custom-select--multiple">
                            <select id="cylinder"
                                    name="<?= current($arResult['ITEMS']['cylinder_place_' . $sectCode]['VALUES'])['CONTROL_NAME_ALT'] ?>"
                                    multiple>
                                <option placeholder>Расположение цилиндров</option>
                                <option value="reset">Любое</option>
                                <?php foreach ($arResult['ITEMS']['cylinder_place_' . $sectCode]['VALUES'] as $ar): ?>
                                    <option
                                            id="<?= $ar['CONTROL_ID'] ?>"
                                            value="<?= $ar["HTML_VALUE_ALT"] ?>"
                                        <?= ($ar["CHECKED"]) ? 'selected' : '' ?>
                                    >
                                        <?= $ar["VALUE"] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="form-row__col-30 gap-20">
                <!--            главнавная передача-->
                <?php if (!empty($arResult['ITEMS']['count_door_' . $sectCode]['VALUES'])): ?>
                    <div class="form-row__col">
                        <div class="custom-select-inner form-group-custom-select">
                            <div class="custom-select--multiple">
                                <select id="mainGear"
                                        name="<?= current($arResult['ITEMS']['count_door_' . $sectCode]['VALUES'])['CONTROL_NAME_ALT'] ?>"
                                        multiple>
                                    <option placeholder>Главная передача</option>
                                    <option value="reset">Любая</option>
                                    <?php foreach ($arResult['ITEMS']['count_door_' . $sectCode]['VALUES'] as $ar): ?>
                                        <option
                                                id="<?= $ar['CONTROL_ID'] ?>"
                                                value="<?= $ar["HTML_VALUE_ALT"] ?>"
                                            <?= ($ar["CHECKED"]) ? 'selected' : '' ?>
                                        >
                                            <?= $ar["VALUE"] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <!--                коробка-->
                <?php if (!empty($arResult['ITEMS']['transmission']['VALUES'])): ?>
                    <div class="form-row__col">
                        <div class="custom-select-inner form-group-custom-select">
                            <div class="custom-select--multiple">
                                <select name="<?= current($arResult['ITEMS']['transmission']['VALUES'])['CONTROL_NAME_ALT'] ?>"
                                        id="transmission" multiple>
                                    <option placeholder>Коробка</option>
                                    <option value="reset">Любая</option>
                                    <?php foreach ($arResult['ITEMS']['transmission']['VALUES'] as $ar): ?>
                                        <option
                                                id="<?= $ar['CONTROL_ID'] ?>"
                                                value="<?= $ar["HTML_VALUE_ALT"] ?>"
                                            <?= ($ar["CHECKED"]) ? 'selected' : '' ?>
                                        >
                                            <?= $ar["VALUE"] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!--            число тактов-->
            <?php if (!empty($arResult['ITEMS']['cycles_number_' . $sectCode]['VALUES'])): ?>
                <div class="form-row__col-30">
                    <div class="custom-select-inner form-group-custom-select">
                        <div class="custom-select--multiple">
                            <select id="cycles"
                                    name="<?= current($arResult['ITEMS']['cycles_number_' . $sectCode]['VALUES'])['CONTROL_NAME_ALT'] ?>"
                                    multiple>
                                <option placeholder>Число тактов</option>
                                <option value="reset">Любое</option>
                                <?php foreach ($arResult['ITEMS']['cycles_number_' . $sectCode]['VALUES'] as $ar): ?>
                                    <option
                                            id="<?= $ar['CONTROL_ID'] ?>"
                                            value="<?= $ar["HTML_VALUE_ALT"] ?>"
                                        <?= ($ar["CHECKED"]) ? 'selected' : '' ?>
                                    >
                                        <?= $ar["VALUE"] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="form-row flex-row">
            <!--            цвет-->
            <?php if (!empty($arResult['ITEMS']['color']['VALUES'])): ?>
                <div class="form-row__col-30">
                    <div class="form-group form-group--radio-color radio-color--checkbox">
                        <div class="form-row form-row-radio-mini form-row-radio-mini--color">
                            <?php foreach ($arResult['ITEMS']['color']['VALUES'] as $ar): ?>
                                <div class="form-col">
                                    <input
                                            type="checkbox"
                                            value="<?= $ar["HTML_VALUE"] ?>"
                                            class="radio-block"
                                            name="<?= $ar["CONTROL_NAME"] ?>"
                                            id="<?= $ar["CONTROL_ID"] ?>"
                                        <?= ($ar["CHECKED"]) ? 'checked' : '' ?>
                                    >
                                    <label data-role="label_<?= $ar["CONTROL_ID"] ?>" for="<?= $ar["CONTROL_ID"] ?>"
                                           class="radio-color__label">
                                        <span class="_color-item" data-color="<?= $ar['XML_ID'] ?>"></span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($arResult['ITEMS']['color']['VALUES']) >= 10): ?>
                            <div class="color-btn">
                                <div class="color-btn__arrow active">
                                    <svg width="9" height="6" viewBox="0 0 9 6" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.5 5.60498L8.39711 0.91748H0.602886L4.5 5.60498Z" fill="#666666"/>
                                    </svg>
                                </div>
                                <div class="color-btn__cross">
                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.98011 1.69495L1.69429 8.98078M9.03215 9.03282L1.64224 1.64291"
                                              stroke="#666666" stroke-width="1.4" stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!--            тип продавца-->
            <?php if (!empty($arResult['ITEMS']['saller']['VALUES'])): ?>
                <div class="form-row__col-30">
                    <div class="form-row form-row-radio-block">
                        <?php $curSaller = current($arResult['ITEMS']['saller']['VALUES']) ?>
                        <div class="form-col grow-1">
                            <input
                                    type="radio"
                                    class="radio-block"
                                    name="<?= $curSaller['CONTROL_NAME_ALT'] ?>"
                                    id="all_<?= $curSaller['CONTROL_ID'] ?>"
                                    value=""
                                    checked=""
                            >
                            <label for="all_<?= $curSaller['CONTROL_ID'] ?>" class="radio-block__label">Неважно</label>
                        </div>

                        <?php foreach ($arResult['ITEMS']['saller']['VALUES'] as $ar): ?>
                            <div class="form-col grow-1">
                                <input
                                        type="radio"
                                        class="radio-block"
                                        name="<?= $ar['CONTROL_NAME_ALT'] ?>"
                                        id="<?= $ar['CONTROL_ID'] ?>"
                                        value="<?= $ar['HTML_VALUE_ALT'] ?>"
                                    <?= ($ar["CHECKED"]) ? 'checked' : '' ?>
                                >
                                <label for="<?= $ar['CONTROL_ID'] ?>"
                                       class="radio-block__label"><?= $ar['VALUE'] ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="form-row__col-30">
                <div class="form-row form-row-checkbox selection-block-checkbox-row">
                    <?php if (!empty($arResult['ITEMS']['PRICE_TYPE']['VALUES'])): ?>
                        <?php foreach ($arResult['ITEMS']['PRICE_TYPE']['VALUES'] as $ar): ?>
                            <?php if ($ar['URL_ID'] !== 'contract-price'): ?>
                                <div class="col">
                                    <input
                                            type="checkbox"
                                            class="input-checkbox"
                                            value="<?= $ar["HTML_VAОбменLUE"] ?>"
                                            name="<?= $ar["CONTROL_NAME"] ?>"
                                            id="<?= $ar["CONTROL_ID"] ?>"
                                    >
                                    <label for="<?= $ar["CONTROL_ID"] ?>"
                                           class="checkbox-label"><?= $ar['VALUE'] ?></label>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <div class="col">
                        <input type="checkbox" class="input-checkbox" name="<?= $arParams['FILTER_NAME'] ?>_photo"
                               id="photo"
                               value="Y" <?= ($_GET[$arParams['FILTER_NAME'] . '_photo']) ? 'checked' : '' ?>>
                        <label for="photo" class="checkbox-label">С фото</label>
                    </div>
                    <div class="col">
                        <input type="checkbox" class="input-checkbox" name="<?= $arParams['FILTER_NAME'] ?>_video"
                               id="video"
                               value="Y" <?= ($_GET[$arParams['FILTER_NAME'] . '_video']) ? 'checked' : '' ?>>
                        <label for="video" class="checkbox-label">С видео</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-border">
            <div class="form-row flex-row">
                <div class="form-row__col-30">
                    <div class="form-group custom-select-inner form-group-custom-select">
                        <div class="form-row">
                            <select name="<?= $arParams['FILTER_NAME'] ?>_country"
                                    class="select-type  custom-select-list" id="country">
                                <option value="" selected>
                                    Страна
                                </option>
                                <option value="reset">
                                    Сбросить
                                </option>
                                <?php foreach ($arResult['COUNTRIES'] as $country): ?>
                                    <option
                                            value="<?= $country['ID'] ?>"
                                    >
                                        <?= $country['NAME_RU'] ?>

                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row__col-30">
                    <div class="form-group custom-select-inner form-group-custom-select">
                        <div class="form-row">
                            <select name="<?= $arParams['FILTER_NAME'] ?>_region"
                                    class="select-type  custom-select-list" id="region"
                                    data-select="region-list" disabled>
                                <option value="" selected>
                                    Область
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row__col-30">
                    <div class="form-group custom-select-inner form-group-custom-select">
                        <div class="form-row">
                            <select name="<?= $arParams['FILTER_NAME'] ?>_city" class="select-type  custom-select-list"
                                    id="city"
                                    data-select="city-list" disabled>
                                <option value="" selected>
                                    Город
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--        дополнительные параметры-->
        <?php if (!empty($arResult['ITEMS']['complect_' . $sectCode]['VALUES'])): ?>
            <div class="form-row form-row-checkbox form-row-checkbox--selection">
                <?php foreach ($arResult['ITEMS']['complect_' . $sectCode]['VALUES'] as $ar): ?>
                    <div class="col">
                        <input
                                type="checkbox"
                                class="input-checkbox"
                                value="<?= $ar["HTML_VALUE"] ?>"
                                name="<?= $ar["CONTROL_NAME"] ?>"
                                id="<?= $ar["CONTROL_ID"] ?>"
                            <?= ($ar["CHECKED"]) ? 'checked' : '' ?>
                        >
                        <label data-role="label_<?= $ar["CONTROL_ID"] ?>" for="<?= $ar["CONTROL_ID"] ?>"
                               class="checkbox-label"><?= $ar["VALUE"] ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="form-row form-row--btn">
        <div class="parameters-btn-inner">
            <div class="all-parameters">
                <span class="all-parameters__text"> Все параметры</span>
                <svg width="10" height="7" viewBox="0 0 10 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1.5L5 5.5L9 1.5" stroke="#ED1C24" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="reset-parameters">
                <div class="cnt-parameters">12</div>
                <button type="reset">
                    Сбросить <span class="no-mobile">фильтры</span>
                    <svg width="9" height="10" viewBox="0 0 9 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.8494 4.7228L8.851 7.72441L7.53283 9.04258L4.53122 6.04098L1.53941 9.03279L0.203696 7.69707L3.19551 4.70526L0.201407 1.71116L1.51958 0.392986L4.51368 3.38709L7.53512 0.365653L8.87083 1.70137L5.8494 4.7228Z"
                              fill="#9F9F9F"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="result-block">
        </div>

    </div>
</form>

<?php
\Bitrix\Main\Page\Asset::getInstance()->addJs("https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js");
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/catalog/filter-action.js", ['GROUP' => 1000]);
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/catalog/filter.js", ['GROUP' => 1000]);
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/custom/main.js", ['GROUP' => 2000]);
?>