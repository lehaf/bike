<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);
?>
<?php

use \Bitrix\Main\Page\Asset;

Asset::getInstance()->addCss("https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css");
Asset::getInstance()->addCss($templateFolder . '/style.css');

$lastSectKey = (!empty($arResult["CUSTOM_SECTIONS"])) ? array_key_last($arResult["CUSTOM_SECTIONS"]) : "";

$firstFieldKey = (!empty($arResult["SORT_SHOW_FIELDS"])) ? array_key_first($arResult["SORT_SHOW_FIELDS"]) : "";
$showCategories = "";
if (!empty($arResult["SORT_SHOW_FIELDS"])) {
    if (array_key_exists('MODEL', $arResult["SORT_SHOW_FIELDS"])) $showCategories = "data-action='catModel' data-id={$arParams['SECTION_ID']}";
    if (array_key_exists('CATEGORY', $arResult["SORT_SHOW_FIELDS"])) $showCategories = "data-action='cat' data-id={$arParams['SECTION_ID']}";
}
$isLastBlock = false;

$ajax = false;
if ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    $ajax = true;
}
$notEmptyBlocks = ['NAME', 'MODEL', 'PRICE', 'CATEGORY', 'SUBCATEGORY', 'PHOTO', 'OTHER_FIELDS'];
?>
    <div class="steps-content" <?= $showCategories ?>>
        <?php if (isset($_GET['type'])): ?>
            <div class="step">
                <div class="wrapper">
                    <form action="#" class="step-form" method="post" id="stepForm">
                        <?php foreach ($arResult['SORT_SHOW_FIELDS'] as $key => $block): ?>
                            <?php $class = '';
                            $class .= ($key === $firstFieldKey) ? 'active' : '';
                            $class .= ($key === 'OTHER_FIELDS' || $key === 'PHOTO') ? ' step-form__inner--big' : '';
                            $class .= ($key === 'FIELDS') ? ' fields' : '';
                            ?>
                            <div class="step-form__inner <?= $class ?>">
                                <?php if (!empty($block['NAME'])): ?>
                                    <div class="step-form__title">
                                        <?= $block['NAME'] ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($block['DESCRIPTION'])): ?>
                                    <p class="step-form__subtitle">
                                        <?= $block['DESCRIPTION'] ?>
                                    </p>
                                <?php endif; ?>

                                <?php if ($key === 'MODEL'): ?>
                                    <?php if (!empty($arResult['CATEGORIES'])): ?>
                                        <div class="form-group">
                                            <label for="brand" class="form-group__label">Марка<span>*</span></label>
                                            <div class="form-row form-row-brand">
                                                <input type="text" class="custom-input check-block"
                                                       placeholder="Поиск марки"
                                                       id="brand"
                                                       autocomplete="off" name="SECTION">
                                                <div class="error-form">Необходимо заполнить «Марка»</div>
                                                <div class="brand-list" id="brandBlock">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="brandModel"
                                                   class="form-group__label">Модель<span>*</span></label>
                                            <div class="form-row">
                                                <input type="text" class="custom-input check-block"
                                                       placeholder="Поиск модели"
                                                       id="brandModel"
                                                       autocomplete="off" disabled name="SUBSECTION">
                                                <div class="error-form">Необходимо заполнить «Модель»</div>
                                                <div class="brand-list brand-list--model" id="modelBlock">
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if ($key === 'PRICE'): ?>
                                    <div class="form-group row--split">
                                        <label for="price" class="form-group__label">Цена<span>*</span></label>
                                        <div class="form-group-row">
                                            <input type="text" class="custom-input check-block number"
                                                   placeholder="Например, 1000 BYN"
                                                   id="price"
                                                   autocomplete="off" name="PRICE">
                                            <div class="form-group custom-select-inner form-group-custom-select select-no_reset">
                                                <div class="form-row">
                                                    <select class="custom-select" id="currency" name="CURRENCY">
                                                        <?php foreach ($arResult['CURRENCIES'] as $curKey => $currency): ?>
                                                            <option value="<?= $currency['CURRENCY'] ?>" <?= ($currency['BASE'] === 'Y') ? 'selected' : '' ?>>
                                                                <?= $currency['CURRENCY'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="error-form">Необходимо заполнить «Цена»</div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($key === 'OTHER_FIELDS'): ?>
                                    <div class="form-group">
                                        <div class="form-row">
                                        <textarea name="DETAIL_TEXT" class="custom-textarea"
                                                  placeholder="Введите описание" id="adDescription" maxlength="2000"
                                                  data-text="ad-description"></textarea>
                                            <div class="textarea-info">
                                                Символов&nbsp;
                                                <div class="textarea-info__number">
                                                    0
                                                </div>
                                                <div class="textarea-info__full">
                                                    /2000
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (!empty($arResult['TAGS'])): ?>
                                        <div class="ad-description-list" data-text="ad-description">
                                            <?php foreach ($arResult['TAGS'] as $tag): ?>
                                                <div class="ad-description-list__el"><?= $tag ?></div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if ($key === 'PHOTO'): ?>
                                    <div class="dropzone">
                                        <div class="dropzone__description">
                                            <div class="dropzone_count">
                                                <span class="dropzone_count__loaded">0 </span> /10
                                            </div>
                                        </div>
                                        <div class="dropzone__content">
                                            <label for="inputFile" class="preview-img ad-photo">
                                                <input type="file" multiple accept="image/*" id="inputFile">
                                                <span class="input-file-btn">
                                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.7915 7.88856H18.0112V11.0592H10.7915V18.2554H7.57867V11.0592H0.376953V7.88856H7.57867V0.621094H10.7915V7.88856Z"
                                                  fill="#ACACAC"/>
                                        </svg>
                                   Добавить фото
                                </span>
                                            </label>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($ajax === true && $key === 'FIELDS') {
                                    ob_end_clean();
                                } ?>
                                <?php if (!empty($block['FIELDS'])): ?>
                                    <?php if ($key === 'TECHNICAL'): ?>
                                        <?php foreach ($block['FIELDS'] as $field): ?>
                                            <div class="form-group row-block">
                                                <?php foreach ($field as $value): ?>
                                                    <?php if ($value['PROPERTY_TYPE'] === 'S' || $value['PROPERTY_TYPE'] === 'N'): ?>
                                                        <div class="form-col">
                                                            <label for="<?= $value['CODE'] ?>"
                                                                   class="form-group__label"><?= $value['NAME'] ?><?= ($value['CUSTOM_CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                            <input type="text"
                                                                   class="custom-input size-input <?= ($value['CODE'] !== 'square') ? 'size-input--square' : '' ?>"
                                                                   id="<?= $value['CODE'] ?>"
                                                                   placeholder="<?= $value['NAME'] ?>" data-size="м"
                                                                <?= ($value['CODE'] === 'square') ? 'disabled' : '' ?>
                                                            >
                                                            <div class="error-form">Необходимо заполнить <?= $value['NAME'] ?></div>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <?php foreach ($block['FIELDS'] as $name => $field): ?>

                                            <?php if ($name === 'pair_race'): ?> <!-- парные свойства пробег-объем-->
                                                <div class="form-group row-block">
                                                    <div class="form-col form-col--select row--split">
                                                        <div class="form-group">
                                                            <label for="<?= $field['race']['CODE'] ?>"
                                                                   class="form-group__label"><?= $field['race']['NAME'] ?><?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                            <div class="form-group-row">
                                                                <input type="text"
                                                                       class="custom-input <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?>"
                                                                       placeholder="<?= $field['race']['NAME'] ?>"
                                                                       id="<?= $field['race']['CODE'] ?>"
                                                                       autocomplete="off">
                                                                <div class="form-group custom-select-inner form-group-custom-select select-no_reset">
                                                                    <div class="form-row">
                                                                        <select name="type-moto" class="custom-select"
                                                                                name="<?= $field['race_unit']['CODE'] ?>">
                                                                            <?php foreach ($field['race_unit']['PROPERTY_LIST'] as $num => $value): ?>
                                                                                <option value="<?= $value['ID'] ?>" <?= ($key === 0) ? 'selected' : '' ?>>
                                                                                    <?= $value['VALUE'] ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-col form-col--select">
                                                        <label for="<?= $field['power']['CODE'] ?>"
                                                               class="form-group__label"><?= $field['power']['NAME'] ?><?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                        <input type="text"
                                                               class="custom-input size-input <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?>"
                                                               id="<?= $field['power']['CODE'] ?>"
                                                               placeholder="<?= $field['power']['NAME'] ?>"
                                                               data-size="см³">
                                                    </div>
                                                </div>
                                            <?php elseif ($name === 'pair_param'): ?> <!-- парные свойства длина-высота-->
                                                <div class="form-group row-block">
                                                    <div class="form-col">
                                                        <label for="lengthProduct"
                                                               class="form-group__label"><?= $field['length']['NAME'] ?><?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                        <input type="text"
                                                               class="custom-input size-input <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?>"
                                                               id="<?= $field['length']['CODE'] ?>"
                                                               placeholder="<?= $field['length']['NAME'] ?>"
                                                               data-size="м">
                                                    </div>
                                                    <div class="form-col">
                                                        <label for="widthProduct"
                                                               class="form-group__label"><?= $field['high']['NAME'] ?><?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                        <input type="text"
                                                               class="custom-input size-input <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?>"
                                                               id="<?= $field['high']['CODE'] ?>"
                                                               placeholder="<?= $field['length']['NAME'] ?>"
                                                               data-size="м">
                                                    </div>
                                                </div>
                                            <?php elseif ($field['CODE'] === 'color' && !empty($field['PROPERTY_LIST'])): ?>
                                                <div class="form-group form-group--radio-color <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'form-checked check-block' : '' ?>">
                                                    <label class="form-group__label"><?= $field['NAME'] ?><?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                    <div class="form-row form-row-radio-mini form-row-radio-mini--color">
                                                        <?php foreach ($field['PROPERTY_LIST'] as $item): ?>
                                                            <div class="form-col">
                                                                <input type="radio" class="radio-block"
                                                                       name="<?= $field['CODE'] ?>"
                                                                       id="color-<?= $item['ID'] ?>"
                                                                       value="<?= $item['ID'] ?>">
                                                                <label for="color-<?= $item['ID'] ?>"
                                                                       class="radio-color__label">
                                                        <span class="_color-item"
                                                              data-color="<?= $item['XML_ID'] ?>"></span>
                                                                </label>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <div class="error-form">Необходимо заполнить  «<?= $field['NAME'] ?>»</div>
                                                </div>
                                            <?php else: ?>
                                                <?php
                                                switch ($field["PROPERTY_TYPE"]):
                                                    case "L": ?>
                                                        <?php if ($field["LIST_TYPE"] === 'L' && !empty($field['PROPERTY_LIST'])): ?>
                                                            <div class="form-group custom-select-inner form-group-custom-select">
                                                                <label for="<?= $field['CODE'] ?>"
                                                                       class="form-group__label"><?= $field['NAME'] ?><?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                                <div class="form-row">
                                                                    <select name="<?= $field['CODE'] ?>"
                                                                            class="select-type custom-select <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?>"
                                                                            id="<?= $field['CODE'] ?>">
                                                                        <option value="" selected>
                                                                            <?= $field['NAME'] ?>
                                                                        </option>
                                                                        <option value="reset">
                                                                            Сбросить
                                                                        </option>
                                                                        <?php foreach ($field['PROPERTY_LIST'] as $item): ?>
                                                                            <option value="<?= $item['ID'] ?>">
                                                                                <?= $item['VALUE'] ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    <div class="error-form">Необходимо заполнить
                                                                        «<?= $field['NAME'] ?>»
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php break; ?>
                                                        <?php endif; ?>

                                                        <?php if ($field["LIST_TYPE"] === 'C' && !empty($field['PROPERTY_LIST'])): ?>
                                                            <?php if ($field['MULTIPLE'] === "Y"): ?>
                                                                <?php $count = count($field['PROPERTY_LIST']) ?>
                                                                <div class="form-group  <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'form-checked check-block' : '' ?>">
                                                                    <label for="<?= $field['CODE'] ?>"
                                                                           class="form-group__label"><?= $field['NAME'] ?><?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                                    <div class="form-row <?= ($count > 5) ? 'form-row-checkbox' : 'checkbox-row' ?>">
                                                                        <?php foreach ($field['PROPERTY_LIST'] as $item): ?>
                                                                            <div class="col">
                                                                                <input type="checkbox"
                                                                                       class="input-checkbox"
                                                                                       name="<?= $field['CODE'] ?>[]"
                                                                                       id="check-<?= $item['ID'] ?>"
                                                                                       value="<?= $item['ID'] ?>">
                                                                                <label for="check-<?= $item['ID'] ?>"
                                                                                       class="checkbox-label"><?= $item['VALUE'] ?></label>
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                    <div class="error-form">Необходимо заполнить
                                                                        «<?= $field['NAME'] ?>»
                                                                    </div>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="form-group <?= (in_array($field['ID'], $arResult['CUSTOM_CHECK'] ?? [])) ? '' : 'form-group--radio-mini' ?> <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'form-checked check-block' : '' ?>">
                                                                    <label class="form-group__label"><?= $field['NAME'] ?><?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                                    <div class="form-row <?= (in_array($field['ID'], $arResult['CUSTOM_CHECK'] ?? [])) ? 'form-row-radio-block' : 'form-row-radio-mini' ?>">
                                                                        <?php foreach ($field['PROPERTY_LIST'] as $key=>$item): ?>
                                                                            <div class="form-col">
                                                                                <input type="radio" class="radio-block"
                                                                                       name="<?= $field['CODE'] ?>"
                                                                                       id="radio-<?= $item['ID'] ?>"
                                                                                       value="<?= $item['ID'] ?>"
                                                                                    <?=($key === 0) ? 'checked' : ''?>
                                                                                >
                                                                                <label for="radio-<?= $item['ID'] ?>"
                                                                                       class="<?= (in_array($field['ID'], $arResult['CUSTOM_CHECK'] ?? [])) ? 'radio-block__label' : 'radio-mini__label' ?>"><?= $item['VALUE'] ?></label>
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                    <div class="error-form">Необходимо заполнить
                                                                        «<?= $field['NAME'] ?>»
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>
                                                            <?php break; ?>
                                                        <?php endif; ?>
                                                        <?php break; ?>
                                                    <?php case "S": ?>
                                                    <?php if ($field['USER_TYPE'] === 'SAsproMaxRegionLocation'): ?>
                                                        <?php if (!empty($arResult['COUNTRIES'])): ?>
                                                            <div class="form-group custom-select-inner form-group-custom-select country">
                                                                <label for="country"
                                                                       class="form-group__label">Страна<?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                                <div class="form-row">
                                                                    <select name="COUNTRY"
                                                                            class="select-type  custom-select-list <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?>  country"
                                                                            id="country">
                                                                        <option value="" selected>
                                                                            Страна
                                                                        </option>
                                                                        <option value="reset">
                                                                            Сбросить
                                                                        </option>
                                                                        <?php foreach ($arResult['COUNTRIES'] as $country): ?>
                                                                            <option value="<?= $country['ID'] ?>">
                                                                                <?= $country['NAME_RU'] ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    <div class="error-form">Необходимо заполнить
                                                                        «Страна»
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group custom-select-inner form-group-custom-select">
                                                                <label for="region"
                                                                       class="form-group__label">Область<?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                                <div class="form-row">
                                                                    <select name="REGION"
                                                                            class="select-type  custom-select-list <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?>  country"
                                                                            id="region"
                                                                            data-select="region-list" disabled>
                                                                        <option value="" selected>
                                                                            Область
                                                                        </option>
                                                                    </select>
                                                                    <div class="error-form">Необходимо заполнить
                                                                        «Область»
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group custom-select-inner form-group-custom-select">
                                                                <label for="city"
                                                                       class="form-group__label">Город<?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                                <div class="form-row">
                                                                    <select name="country"
                                                                            class="select-type  custom-select-list <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?> country"
                                                                            id="city"
                                                                            data-select="city-list" disabled>
                                                                        <option value="" selected>
                                                                            Город
                                                                        </option>
                                                                    </select>
                                                                    <div class="error-form">Необходимо заполнить
                                                                        «Город»
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php break; ?>
                                                    <?php endif; ?>

                                                    <?php if ($field['USER_TYPE'] === 'map_yandex'): ?>
                                                        <div class="form-group form-group--map-search">
                                                            <label for="mapInput"
                                                                   class="form-group__label"><?= $field['NAME'] ?><?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                            <input type="text"
                                                                   class="custom-input <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?>"
                                                                   placeholder="[Широта, долгота]" id="mapInput"
                                                                   autocomplete="off"
                                                                   name="<?= $field['CODE'] ?>">
                                                        </div>
                                                        <p class="description-text">
                                                            Координаты задаются в виде [широта, долгота] через запятую,
                                                            без пробела, в градусах с десятичной
                                                            дробной частью, не более 7 знаков после точки.<br>
                                                            <span class="map-example">Пример: 55.777044,37.555554</span>
                                                        </p>
                                                        <div id="map"></div>
                                                        <?php break; ?>
                                                    <?php endif; ?>

                                                    <?php if ($field['CODE'] === 'VIDEO_YOUTUBE'): ?>

                                                        <div class="video-block">
                                                            <div class="video-block-text">
                                                                <div class="video-block-text-head">
                                                                    <div class="video-block-icon">
                                                                        <img src="<?= $templateFolder ?>/images/video.png"
                                                                             alt="img">
                                                                    </div>
                                                                    <div class="video-block-title">
                                                                        Прикрепить видео из <span>YouTube </span>
                                                                    </div>
                                                                </div>
                                                                <div class="video-block-description">
                                                                    Видео привлекает внимание и повышает шансы на
                                                                    продажу.
                                                                    Снимите ролик на телефон и загрузите на YouTube.
                                                                    <br>
                                                                    Мы опубликуем его после проверки модератора.
                                                                </div>
                                                            </div>
                                                            <div class="video-block-input">
                                                                <div class="form-group">
                                                                    <label for="videoLink"
                                                                           class="form-group__label"><?= $field['NAME'] ?><?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                                    <div class="form-row form-row-brand">
                                                                        <input type="text"
                                                                               class="custom-input <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?>"
                                                                               placeholder="" id="videoLink"
                                                                               name="<?= $field['CODE'] ?>"
                                                                               autocomplete="off">
                                                                    </div>
                                                                    <div class="error-form">Необходимо заполнить
                                                                        «<?= $field['NAME'] ?>»
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php break; ?>
                                                    <?php endif; ?>

                                                    <?php if ($field['CODE'] === 'phone'): ?>
                                                        <div class="form-group">
                                                            <div class="data-user-container data-user-container--tel">
                                                                <div class="form-tel-container">
                                                                    <div class="form-group form-group--tel">
                                                                        <label for="brand"
                                                                               class="form-group__label"><?= $field['NAME'] ?><?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                                        <input type="tel"
                                                                               placeholder="+375 (xx) xxx-xx-xx"
                                                                               class="dataUserTel custom-input <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?>"
                                                                               id="dataUserTel"
                                                                               name="<?= $field['CODE'] ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="add-new-phone">
                                                                    <svg width="12" height="13" viewBox="0 0 12 13"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M7.087 5.44545H12V7.60303H7.087V12.5H4.90072V7.60303H0V5.44545H4.90072V0.5H7.087V5.44545Z"
                                                                              fill="#666666"/>
                                                                    </svg>
                                                                    <div class="add-new-phone-text">Добавить номер
                                                                        телефона
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="error-form">Необходимо заполнить
                                                                «<?= $field['NAME'] ?>»
                                                            </div>
                                                        </div>
                                                        <?php break; ?>
                                                    <?php endif; ?>
                                                    <div class="form-group">
                                                        <label for="<?= $field['CODE'] ?>"
                                                               class="form-group__label"><?= $field['NAME'] ?><?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                        <div class="form-row">
                                                            <input type="text"
                                                                   class="custom-input <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?>"
                                                                   placeholder="<?= $field['NAME'] ?>"
                                                                   id="<?= $field['CODE'] ?>"
                                                                   name="<?= $field['CODE'] ?>">
                                                        </div>
                                                        <div class="error-form">Необходимо заполнить
                                                            «<?= $field['NAME'] ?>»
                                                        </div>
                                                    </div>
                                                    <?php break; ?>
                                                <?php case "N": ?>
                                                    <div class="form-group">
                                                        <label for="<?= $field['CODE'] ?>"
                                                               class="form-group__label"><?= $field['NAME'] ?><?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                        <div class="form-row">
                                                            <input type="text"
                                                                   class="custom-input number <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?>"
                                                                   placeholder="<?= $field['NAME'] ?>"
                                                                   id="<?= $field['CODE'] ?>"
                                                                   name="<?= $field['CODE'] ?>"
                                                            >
                                                        </div>
                                                        <div class="error-form">Необходимо заполнить
                                                            «<?= $field['NAME'] ?>»
                                                        </div>
                                                    </div>
                                                    <?php break; ?>
                                                <?php default:
                                                    break; ?>
                                                <?php endswitch;
                                                ?>
                                                <!--                                            --><?php //setTemplateField($field, $arResult); ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if ($ajax === true && $key === 'FIELDS') die(); ?>

                                <?php if ($key === 'NAME'): ?>
                                    <div class="form-group">
                                        <label for="nameText" class="form-group__label">Название
                                            товара<span>*</span></label>
                                        <div class="form-row ">
                                        <textarea name="name" class="custom-textarea check-block"
                                                  placeholder="Введите название" id="nameText"
                                                  maxlength="2000"></textarea>
                                            <div class="textarea-info">
                                                Символов&nbsp;
                                                <div class="textarea-info__number">
                                                    0
                                                </div>
                                                <div class="textarea-info__full">
                                                    /2000
                                                </div>
                                            </div>
                                        </div>
                                        <div class="error-form">Необходимо заполнить «Название товара»</div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($key === 'CATEGORY'): ?>
                                    <?php if (!empty($arResult['CATEGORIES'])): ?>
                                        <div class="form-group custom-select-inner form-group-custom-select select-search">
                                            <label for="categorySelect" class="form-group__label">Категория
                                                товара<span>*</span></label>
                                            <div class="form-row">
                                                <select name="IBLOCK_SECTION_ID"
                                                        class="select-type custom-select selectSearch check-block"
                                                        id="categorySelect"
                                                        data-text="Поиск по названию"
                                                        data-select="cat-list"
                                                >
                                                    <option value="" selected>
                                                        Поиск по названию
                                                    </option>
                                                </select>
                                                <div class="error-form">Необходимо заполнить «Категория товара»</div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if ($key === 'SUBCATEGORY'): ?>
                                    <div class="form-group custom-select-inner form-group-custom-select select-search subcategory">
                                    </div>
                                    <div class="form-group">
                                        <label for="nameText" class="form-group__label">Название
                                            товара<span>*</span></label>
                                        <div class="form-row form-row--rel">
                                        <textarea name="NAME" class="custom-textarea check-block"
                                                  placeholder="Введите название запчасти" id="nameText"
                                                  maxlength="2000"></textarea>
                                            <div class="textarea-info">
                                                Символов&nbsp;
                                                <div class="textarea-info__number">
                                                    0
                                                </div>
                                                <div class="textarea-info__full">
                                                    /2000
                                                </div>
                                            </div>
                                        </div>
                                        <div class="error-form">Необходимо заполнить «Название товара»</div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($key !== $arResult['LAST_FIELD']): ?>
                                    <?= nextBtnTemplate() ?>
                                <?php else: ?>
                                    <button type="submit"
                                            class="step-form__btn step-form__btn-submit form__btn--disable">
                                        <?= Loc::getMessage('SUBMIT') ?>
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </form>
                </div>
            </div>
        <?php else: ?>
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
                                            <a class="step-category__el <?= ($number === (count($sections)-1) && $lastSectKey !== $key) ? 'step-category__el--center' : '' ?>"
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
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.js"
            integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=e2caa9ca-c646-4d64-b8c9-bbe9b1227165"
            type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery.maskedinput@1.4.1/src/jquery.maskedinput.min.js"
            type="text/javascript"></script>


<?php

function nextBtnTemplate(): string
{
    return '<div class="step-form__btn form__btn--disable ">
                                        Далее
                                        <svg width="11" height="12" viewBox="0 0 11 12" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.40796 11.5L11 6.00001C9.59738 4.62435 6.81062 1.87566 5.40799 0.5L4.7022 1.1828C5.96397 2.41998 7.63288 4.06854 9.10532 5.5145L-2.1919e-07 5.51447L-2.61636e-07 6.48553L9.10533 6.48553L4.70223 10.8096L5.40796 11.5Z"
                                                  fill="white"/>
                                        </svg>
                                    </div>';
}
