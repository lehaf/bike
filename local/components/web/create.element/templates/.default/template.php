<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);
?>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=4535c715-1fd8-4d4a-87bb-8313fe9f8f1b&suggest_apikey=e69e7cac-7b28-48b3-be09-dba3b9e6e1f4"
            type="text/javascript"></script>
<?php
$this->addExternalCss(SITE_TEMPLATE_PATH . "/css/choices.min.css", ['GROUP' => 1]);
$this->addExternalCss(SITE_TEMPLATE_PATH . '/css/catalog/filter.css', ['GROUP' => 1000]);
$this->addExternalCss(SITE_TEMPLATE_PATH . '/css/catalog/tmpStyle.css', ['GROUP' => 1000]);

$this->addExternalJs(SITE_TEMPLATE_PATH . '/js/choices.min.js', ['GROUP' => 1]);
$this->addExternalJs(SITE_TEMPLATE_PATH . '/js/jquery.maskedinput.min.js', ['GROUP' => 1]);
$this->addExternalJs(SITE_TEMPLATE_PATH . '/js/custom/main.js', ['GROUP' => 1000]);

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
$notShowLabel = ['PRICE_TYPE'];
?>
    <div class="steps-content" data-iblock="<?= $arParams['IBLOCK_ID'] ?>" <?= $showCategories ?> >
        <?php if (isset($_GET['type'])): ?>
            <div class="step">
                <div class="wrapper">
                    <form action="#" class="step-form" method="post" id="stepForm">
                        <?php if((int)$arParams['SECTION_ID'] === RENT_SECTION_ID):?>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => "/include/add_page/top_text.php"
                            )
                        );?>
                        <?php endif;?>
                        <?php foreach ($arResult['SORT_SHOW_FIELDS'] as $key => $block): ?>
                            <?php $class = '';
                            $class .= ($key === $firstFieldKey) ? 'active' : '';
                            $class .= ($key === 'OTHER_FIELDS' || $key === 'PHOTO' || $key === 'SERVICE_NAME') ? ' step-form__inner--big' : '';
                            $class .= ($key === 'FIELDS') ? ' fields' : '';
                            ?>
                            <?php if ($key === 'MODEL' && empty($arResult['CATEGORIES'])) continue; ?>
                            <div class="step-form__inner <?= $class ?>">
                                <?php if ($ajax === true && $key === 'FIELDS') {
                                    ob_end_clean();
                                } ?>
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
                                                       autocomplete="off"
                                                       name="SECTION"
                                                       value="<?= ($arResult['ELEMENT_PROPS']) ? $arResult['ELEMENT_PROPS']['SECTION_NAME'] : '' ?>"
                                                    <?= ($arResult['ELEMENT_PROPS']) ? 'data-el=' . $arResult['ELEMENT_PROPS']['SECTION_ID'] : '' ?>
                                                >
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
                                                       autocomplete="off"
                                                    <?= (!$arResult['ELEMENT_PROPS']) ? "disabled" : "" ?>
                                                       value="<?= ($arResult['ELEMENT_PROPS']) ? $arResult['ELEMENT_PROPS']['IBLOCK_SECTION_NAME'] : '' ?>"
                                                       name="SUBSECTION"
                                                >
                                                <div class="error-form">Необходимо заполнить «Модель»</div>
                                                <div class="brand-list brand-list--model"
                                                     id="modelBlock"
                                                    <?= ($arResult['ELEMENT_PROPS']) ? 'data-el=' . $arResult['ELEMENT_PROPS']['IBLOCK_SECTION_ID'] : '' ?>>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if ($key === 'PRICE'): ?>
                                    <div class="form-group row--split" data-type="price">
                                        <label for="price" class="form-group__label">Цена<span>*</span></label>
                                        <div class="form-group-row">
                                            <input type="text" class="custom-input check-block number"
                                                   placeholder="Например, 1000 BYN"
                                                   id="price"
                                                   autocomplete="off" name="PRICE"
                                                   value="<?= (isset($arResult['ELEMENT_PRICE'])) ? floor($arResult['ELEMENT_PRICE']['PRICE']) : '' ?>"
                                            >
                                            <div class="form-group custom-select-inner form-group-custom-select select-no_reset">
                                                <div class="form-row">
                                                    <select class="custom-select" id="currency" name="CURRENCY">
                                                        <?php foreach ($arResult['CURRENCIES'] as $curKey => $currency): ?>
                                                            <option value="<?= $currency['CURRENCY'] ?>"
                                                                <?= ($currency['BASE'] === 'Y' || $currency['CURRENCY'] === $arResult['ELEMENT_PRICE']['CURRENCY']) ? 'selected' : '' ?>
                                                            >
                                                                <?= $currency['CURRENCY'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="error-form">Необходимо заполнить «Цена»</div>
                                    </div>
                                    <?php if (!empty($block['PRICE_TYPE_ROW'])): ?>
                                        <div class="form-group">
                                            <div class="form-row checkbox-row">
                                                <?php foreach ($block['PRICE_TYPE_ROW'] as $item): ?>
                                                    <div class="col">
                                                        <input type="checkbox"
                                                               class="input-checkbox <?= ($item['CODE'] === 'contract_price') ? 'contract-price' : '' ?>"
                                                               name="<?= $item['CODE'] ?>"
                                                               id="check-<?= $item['ID'] ?>"
                                                               value="<?= $item['PROPERTY_LIST'][0]['ID'] ?>"
                                                            <?= ($item['PROPERTY_LIST'][0]['ID'] === $arResult['ELEMENT_FIELDS'][$item['CODE']]) ? 'checked' : '' ?>
                                                        >
                                                        <label for="check-<?= $item['ID'] ?>"
                                                               class="checkbox-label"><?= $item['NAME'] ?></label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="error-form">Необходимо заполнить
                                                «<?= $item['NAME'] ?>»
                                            </div>
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

                                <?php if ($key === 'OTHER_FIELDS'): ?>
                                <?php $textareaText = str_replace('<br>', "\n", $arResult['ELEMENT_PROPS']['DETAIL_TEXT']);?>
                                    <div class="form-group">
                                        <div class="form-row">
                                        <textarea name="DETAIL_TEXT" class="custom-textarea"
                                                  placeholder="Введите описание" id="adDescription" maxlength="2000"
                                                  data-text="ad-description"
                                        ><?= $textareaText ?></textarea>
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
                                        <div class="ad-description-list <?= (!empty($block['FIELDS'])) ? 'ad-description-list--line' : '' ?>"
                                             data-text="ad-description">
                                            <?php foreach ($arResult['TAGS'] as $tag): ?>
                                                <div class="ad-description-list__el"><?= $tag ?></div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if ($key === 'NAME'): ?>
                                    <div class="form-group">
                                        <label for="nameText" class="form-group__label">Название товара/услуги<span>*</span></label>
                                        <div class="form-row form-row--rel">
                                        <input name="NAME" class="custom-input check-block"
                                                type="text"
                                                  placeholder="Введите название товара/услуги"
                                                  id="nameText"
                                                  maxlength="80"
                                               value="<?= $arResult['ELEMENT_PROPS']['NAME']?>"
                                        />
<!--                                            <div class="textarea-info">-->
<!--                                                Символов&nbsp;-->
<!--                                                <div class="textarea-info__number">-->
<!--                                                    0-->
<!--                                                </div>-->
<!--                                                <div class="textarea-info__full">-->
<!--                                                    /2000-->
<!--                                                </div>-->
<!--                                            </div>-->
                                        </div>
                                        <div class="error-form">Необходимо заполнить «Название товара/услуги»</div>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($block['FIELDS'])): ?>
                                    <?php if ($key === 'TECHNICAL'): ?>
                                        <?php foreach ($block['FIELDS'] as $field): ?>
                                            <div class="form-group row-block">
                                                <?php foreach ($field as $value): ?>
                                                    <?php if ($value['PROPERTY_TYPE'] === 'S' || $value['PROPERTY_TYPE'] === 'N'): ?>
                                                        <div class="form-col">
                                                            <label for="<?= $value['CODE'] ?>"
                                                                   class="form-group__label"><?= $value['NAME'] ?><?= ($value['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                            <input type="text"
                                                                   class="number custom-input size-input <?= ($value['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?> <?= ($value['CODE'] !== 'square') ? 'size-input--square' : '' ?>"
                                                                   id="<?= $value['CODE'] ?>"
                                                                   placeholder="<?= $value['NAME'] ?>"
                                                                   name="<?= $value['CODE'] ?>"
                                                                   value="<?= $arResult['ELEMENT_FIELDS'][$value['CODE']]?>"
                                                                <?= ($value['CODE'] === 'square') ? 'disabled' : '' ?>
                                                            >
                                                            <div class="error-form">Необходимо заполнить
                                                                «<?= $value['NAME'] ?>»
                                                            </div>
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
                                                                   class="form-group__label"><?= $field['race']['NAME'] ?><?= ($field['race']['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                            <div class="form-group-row">
                                                                <input type="text"
                                                                       class="number custom-input <?= ($field['race']['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?>"
                                                                       placeholder="<?= $field['race']['NAME'] ?>"
                                                                       id="<?= $field['race']['CODE'] ?>"
                                                                       autocomplete="off"
                                                                       name="<?= $field['race']['CODE'] ?>"
                                                                       value="<?= $arResult['ELEMENT_FIELDS']['race'] ?>"
                                                                >
                                                                <div class="form-group custom-select-inner form-group-custom-select select-no_reset">
                                                                    <div class="form-row">
                                                                        <select class="custom-select"
                                                                                name="<?= $field['race_unit']['CODE'] ?>">
                                                                            <?php foreach ($field['race_unit']['PROPERTY_LIST'] as $num => $value): ?>
                                                                                <option value="<?= $value['ID'] ?>"
                                                                                    <?= ($key === 0 || $value['ID'] === $arResult['ELEMENT_FIELDS']['race_unit']) ? 'selected' : '' ?>
                                                                                >
                                                                                    <?= $value['VALUE'] ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="error-form">Необходимо заполнить
                                                                «<?= $field['race']['NAME'] ?>»
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="form-col form-col--select">
                                                        <label for="<?= $field['power']['CODE'] ?>"
                                                               class="form-group__label"><?= $field['power']['NAME'] ?><?= ($field['power']['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                        <input type="text"
                                                               class="number custom-input size-input <?= ($field['power']['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?>"
                                                               id="<?= $field['power']['CODE'] ?>"
                                                               placeholder="<?= $field['power']['NAME'] ?>"
                                                               name="<?= $field['power']['CODE'] ?>"
                                                               value="<?= $arResult['ELEMENT_FIELDS']['power'] ?>"
                                                        >
                                                        <div class="error-form">Необходимо заполнить
                                                            «<?= $field['power']['NAME'] ?>»
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php elseif ($name === 'pair_param'): ?> <!-- парные свойства длина-высота-->
                                                <div class="form-group row-block">
                                                    <div class="form-col">
                                                        <label for="lengthProduct"
                                                               class="form-group__label"><?= $field['length_tire']['NAME'] ?><?= ($field['length_tire']['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                        <input type="text"
                                                               class="custom-input number size-input <?= ($field['length_tire']['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?>"
                                                               id="<?= $field['length_tire']['CODE'] ?>"
                                                               placeholder="<?= $field['length_tire']['NAME'] ?>"
                                                               name="<?= $field['length_tire']['CODE'] ?>"
                                                               value="<?= $arResult['ELEMENT_FIELDS']['length_tire'] ?>"
                                                        >
                                                        <div class="error-form">Необходимо заполнить
                                                            «<?= $field['length_tire']['NAME'] ?>»
                                                        </div>


                                                    </div>
                                                    <div class="form-col">
                                                        <label for="widthProduct"
                                                               class="form-group__label"><?= $field['height_tire']['NAME'] ?><?= ($field['height_tire']['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                        <input type="text"
                                                               class="custom-input number size-input <?= ($field['height_tire']['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?>"
                                                               id="<?= $field['height_tire']['CODE'] ?>"
                                                               placeholder="<?= $field['height_tire']['NAME'] ?>"
                                                               name="<?= $field['height_tire']['CODE'] ?>"
                                                               value="<?= $arResult['ELEMENT_FIELDS']['height_tire'] ?>"
                                                        >
                                                        <div class="error-form">Необходимо заполнить
                                                            «<?= $field['height_tire']['NAME'] ?>»
                                                        </div>
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
                                                                       value="<?= $item['ID'] ?>"
                                                                    <?= ($item['ID'] === $arResult['ELEMENT_FIELDS'][$field['CODE']]) ? 'checked' : '' ?>
                                                                >
                                                                <label for="color-<?= $item['ID'] ?>"
                                                                       class="radio-color__label">
                                                        <span class="_color-item"
                                                              data-color="<?= $item['XML_ID'] ?>"></span>
                                                                </label>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <div class="error-form">Необходимо заполнить «<?= $field['NAME'] ?>
                                                        »
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <?php
                                                switch ($field["PROPERTY_TYPE"]):
                                                    case "L": ?>
                                                        <?php if ($field["LIST_TYPE"] === 'L' && !empty($field['PROPERTY_LIST'])): ?>
                                                            <?php $isSearch = (strpos($field['CODE'], 'search') !== false) ? ['select-search', 'selectSearch'] : '' ?>
                                                            <div class="form-group custom-select-inner form-group-custom-select select-search">
                                                                <label for="<?= $field['CODE'] ?>"
                                                                       class="form-group__label"><?= $field['NAME'] ?><?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                                <div class="form-row">
                                                                    <select name="<?= $field['CODE'] ?>"
                                                                            class="select-type custom-select <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?> selectSearch"
                                                                            id="<?= $field['CODE'] ?>">
                                                                        <option value="" selected>
                                                                            <?= $field['NAME'] ?>
                                                                        </option>
                                                                        <option value="reset">
                                                                            Сбросить
                                                                        </option>
                                                                        <?php foreach ($field['PROPERTY_LIST'] as $item): ?>
                                                                            <option value="<?= $item['ID'] ?>" <?= ($item['ID'] === $arResult['ELEMENT_FIELDS'][$field['CODE']]) ? 'selected' : '' ?>>
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
                                                                    <?php if (!in_array($field['CODE'], $notShowLabel)): ?>
                                                                        <label for="<?= $field['CODE'] ?>"
                                                                               class="form-group__label form-group__label--up"><?= $field['NAME'] ?><?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                                    <?php endif; ?>
                                                                    <div class="form-row <?= ($count > 5) ? 'form-row-checkbox' : 'checkbox-row' ?>">
                                                                        <?php foreach ($field['PROPERTY_LIST'] as $item): ?>
                                                                            <div class="col">
                                                                                <input type="checkbox"
                                                                                       class="input-checkbox"
                                                                                       name="<?= $field['CODE'] ?>[]"
                                                                                       id="check-<?= $item['ID'] ?>"
                                                                                       value="<?= $item['ID'] ?>"
                                                                                    <?= (in_array($item['ID'], $arResult['ELEMENT_FIELDS'][$field['CODE']] ?? [])) ? 'checked' : '' ?>
                                                                                >
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
                                                                        <?php foreach ($field['PROPERTY_LIST'] as $item): ?>
                                                                            <div class="form-col">
                                                                                <input type="radio" class="radio-block"
                                                                                       name="<?= $field['CODE'] ?>"
                                                                                       id="radio-<?= $item['ID'] ?>"
                                                                                       value="<?= $item['ID'] ?>"
                                                                                    <?= ($item['ID'] === $arResult['ELEMENT_FIELDS'][$field['CODE']]) ? 'checked' : '' ?>
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
                                                            <div class="form-group custom-select-inner form-group-custom-select country select-search">
                                                                <label for="country"
                                                                       class="form-group__label">Страна<?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                                <div class="form-row">
                                                                    <select name="COUNTRY"
                                                                            class="select-type  custom-select-list <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?>  country"
                                                                        <?= ($arResult['ELEMENT_COUNTRY']) ? 'data-el=' . $arResult['ELEMENT_COUNTRY']['COUNTRY'] : '' ?>
                                                                            id="country">
                                                                        <option value="" selected>
                                                                            Страна
                                                                        </option>
                                                                        <option value="reset">
                                                                            Сбросить
                                                                        </option>
                                                                        <?php foreach ($arResult['COUNTRIES'] as $country): ?>
                                                                            <option value="<?= $country['ID'] ?>" <?= ($country['ID'] === $arResult['ELEMENT_COUNTRY']['COUNTRY'] || $arResult['USER_LOCATION']['UF_COUNTRY_ID'] === $country['ID']) ? 'selected' : '' ?>>
                                                                                <?= $country['NAME_RU'] ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    <div class="error-form">Необходимо заполнить
                                                                        «Страна»
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group custom-select-inner form-group-custom-select select-search">
                                                                <label for="region"
                                                                       class="form-group__label">Область<?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                                <div class="form-row">
                                                                    <select name="REGION"
                                                                            class="select-type  custom-select-list <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?>  country"
                                                                            id="region"
                                                                            data-select="region-list"
                                                                        <?= ($arResult['ELEMENT_COUNTRY']) ? 'data-el=' . $arResult['ELEMENT_COUNTRY']['REGION'] : '' ?>
                                                                        <?=(!empty($arResult['USER_LOCATION']['UF_COUNTRY_ID'])) ? '' : 'disabled'?>
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
                                                                                    <?=($arResult['USER_LOCATION']['UF_REGION_ID'] === $region['ID']) ? 'selected' : ''?>
                                                                                >
                                                                                    <?= $region['NAME'] ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        <?php endif;?>
                                                                    </select>
                                                                    <div class="error-form">Необходимо заполнить
                                                                        «Область»
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group custom-select-inner form-group-custom-select select-search">
                                                                <label for="city"
                                                                       class="form-group__label">Город<?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?></label>
                                                                <div class="form-row">
                                                                    <select name="country"
                                                                            class="select-type  custom-select-list <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?> country"
                                                                            id="city"
                                                                            data-select="city-list"
                                                                        <?= ($arResult['ELEMENT_COUNTRY']) ? 'data-el=' . $arResult['ELEMENT_COUNTRY']['CITY'] : '' ?>
                                                                        <?=(!empty($arResult['USER_LOCATION']['UF_REGION_ID'])) ? '' : 'disabled'?>
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
                                                                                    <?=($arResult['USER_LOCATION']['UF_CITY_ID'] === $city['ID']) ? 'selected' : ''?>
                                                                                >
                                                                                    <?= $city['NAME'] ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        <?php endif;?>
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
                                                                   placeholder="Например: Минск Карла Маркса 10" id="mapInput"
                                                                   autocomplete="off"
                                                                   name="SEARCH_ADDRESS"
                                                                   value="<?= $arResult['ELEMENT_FIELDS']['location'] ?>"
                                                            >
                                                            <input type="hidden"
                                                                   id="map_location"
                                                                   autocomplete="off"
                                                                   name="<?= $field['CODE'] ?>"
                                                                   value="<?= $arResult['ELEMENT_FIELDS']['location'] ?>"
                                                            >
                                                            <p class="location-desc">Вводите адрес по-русски. Указывайте номер дома, если таковой имеется.</p>
                                                        </div>
<!--                                                        <p class="description-text">-->
<!--                                                            Координаты задаются в виде [широта, долгота] через запятую,-->
<!--                                                            без пробела, в градусах с десятичной-->
<!--                                                            дробной частью, не более 7 знаков после точки.<br>-->
<!--                                                            <span class="map-example">Пример: 55.777044,37.555554</span>-->
<!--                                                        </p>-->
                                                        <div id="map"></div>
                                                        <?php break; ?>
                                                    <?php endif; ?>

                                                    <?php if ($field['CODE'] === 'POPUP_VIDEO'): ?>

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
                                                                               autocomplete="off"
                                                                               value="<?= $arResult['ELEMENT_FIELDS']['POPUP_VIDEO'] ?>"
                                                                        >
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
                                                                               name="<?= $field['CODE'] ?>"
                                                                               value="<?= $arResult['USER_PROFILE']['phone']?>"
                                                                        >
                                                                    </div>
                                                                    <?php if (!empty($arResult['ELEMENT_FIELDS']['phone']) && count($arResult['ELEMENT_FIELDS']['phone']) > 1): ?>
                                                                        <?php unset($arResult['ELEMENT_FIELDS']['phone'][0]) ?>
                                                                        <?php foreach ($arResult['ELEMENT_FIELDS']['phone'] as $phone): ?>
                                                                            <div class="form-group form-group--tel__new">
                                                                                <input type="tel"
                                                                                       placeholder="+375 (xx) xxx-xx-xx"
                                                                                       class="custom-input dataUserTel"
                                                                                       value="<?= $phone ?>"
                                                                                >
                                                                                <span class="remove_phone">
                                                                                    <svg width="12" height="12"
                                                                                         viewBox="0 0 12 12" fill="none"
                                                                                         xmlns="http://www.w3.org/2000/svg">
                                                                                        <path d="M8.09758 6.44252L11.9531 10.298L10.2599 11.9912L6.40441 8.13569L2.56149 11.9786L0.845798 10.2629L4.68872 6.41999L0.842858 2.57413L2.53602 0.880967L6.38188 4.72683L10.2629 0.845859L11.9785 2.56156L8.09758 6.44252Z"
                                                                                              fill="#666666"/>
                                                                                    </svg>
                                                                                </span>
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>
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
                                                               class="form-group__label">
                                                            <?= $field['NAME'] ?><?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? '<span>*</span>' : '' ?>

                                                        </label>
                                                        <div class="form-row">
                                                            <input type="text"
                                                                   class="custom-input <?= ($field['CUSTOM_IS_REQUIRED'] === 'Y') ? 'check-block' : '' ?>"
                                                                   placeholder="<?= $field['NAME'] ?>"
                                                                   id="<?= $field['CODE'] ?>"
                                                                   name="<?= $field['CODE'] ?>"
                                                                   value="<?= ($field['CODE'] === 'contact_person' && empty($arResult['ELEMENT_FIELDS'])) ? $arResult['USER_PROFILE']['name'] : $arResult['ELEMENT_FIELDS'][$field['CODE']] ?>"
                                                            >
                                                            <?php if($field['CODE'] === 'exp_id'):?>
                                                                <span style="font-size: 12px; color: #989898">Ваш артикул или автоматическое создание</span>
                                                            <?php endif;?>
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
                                                                   value="<?= $arResult['ELEMENT_FIELDS'][$field['CODE']] ?>"
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

                                <?php if ($key === 'CATEGORY'): ?>
                                    <?php if (!empty($arResult['CATEGORIES'])): ?>
                                        <div class="form-group custom-select-inner form-group-custom-select select-search">
                                            <label for="categorySelect"
                                                   class="form-group__label">Категория<span>*</span></label>
                                            <div class="form-row">
                                                <select name="CATEGORY"
                                                        class="select-type custom-select selectSearch check-block"
                                                        id="categorySelect"
                                                        data-text="Поиск по названию"
                                                        data-select="cat-list"
                                                    <?= ($arResult['ELEMENT_PROPS']) ? 'data-el=' . $arResult['ELEMENT_PROPS']['SECTION_ID'] : '' ?>
                                                >
                                                    <option value="" selected>
                                                        Поиск по названию
                                                    </option>
                                                </select>
                                                <div class="error-form">Необходимо заполнить «Категория»</div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if ($key === 'SUBCATEGORY'): ?>
                                    <div class="form-group custom-select-inner form-group-custom-select select-search subcategory"
                                        <?= ($arResult['ELEMENT_PROPS']) ? 'data-el=' . $arResult['ELEMENT_PROPS']['IBLOCK_SECTION_ID'] : '' ?>
                                    >
                                    </div>

                                    <?php if((int)$_GET['type'] !== SERVICES_SECTION_ID):?>
                                    <div class="form-group">
                                        <label for="nameText" class="form-group__label">Название товара/услуги<span>*</span></label>
                                        <div class="form-row form-row--rel">
                                            <textarea name="NAME" class="custom-textarea check-block"
                                                      placeholder="Введите название товара/услуги" id="nameText"
                                                      maxlength="2000"><?= $arResult['ELEMENT_PROPS']['NAME'] ?>
                                            </textarea>
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
                                        <div class="error-form">Необходимо заполнить «Название товара/услуги»</div>
                                    </div>
                                    <?php endif;?>
                                <?php endif; ?>

                                <?php if ($key === 'SERVICE_NAME'):?>
                                    <div class="product-name">
                                        <div class="form-group">
                                            <label for="name"
                                                   class="form-group__label"><?= ((int)$_GET['type'] === SERVICES_SECTION_ID) ? 'Поиск категории' : 'Название товара/услуги<span>*</span>'?></label>
                                            <div class="form-row">
                                                <input type="text"
                                                       class="custom-input <?= ((int)$_GET['type'] === SERVICES_SECTION_ID) ? '' : 'check-block'?>"
                                                       placeholder="Название товара/услуги"
                                                       id="productName"
                                                       name="<?= ((int)$_GET['type'] === SERVICES_SECTION_ID) ? 'SEARCH' : 'NAME'?>"
                                                       value="<?=(((int)$_GET['type'] !== SERVICES_SECTION_ID) ? $arResult['ELEMENT_PROPS']['NAME'] : '')?>"
                                                        maxlength="80"
                                                >
                                                <div class="error-form">Необходимо заполнить
                                                    «Название товара/услуги»
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="categories">
                                        <div class="categories-title">
                                            Возможные категории
                                        </div>
                                        <div class="categories-list">
                                        </div>
                                    </div>
                                    <div class="form-wrapper" id="categorySelection" name="IBLOCK_SECTION_ID">
                                        <div class="category-selection"
                                            <?=($arResult['ELEMENT_PROPS']['IBLOCK_SECTION_ID']) ? 'style="display: none;"' : ''?>
                                        >
                                            <div class="category-selection-main">
                                                <h3 class="category-title">Выбор категории</h3>
                                                <ul class="category-list category-list--selection">
                                                    <?php foreach ($arResult['CATEGORIES'] as $index => $category) : ?>
                                                        <li class="category-list__item <?= ($index === 0) ? 'is-active' : '' ?>"
                                                            data-announcement-category="<?= $category['ID'] ?>">
                                                            <a href="#"><?= $category['NAME'] ?></a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <div class="category-selection-subcategory">
                                                <h3 class="category-title">Подкатегории выбранной категории</h3>
                                                <div class="category-selection-content">
                                                    <?php if (!empty($arResult['SUBSECTIONS'])): ?>
                                                        <?php foreach ($arResult['SUBSECTIONS'] as $parentSectionId => $subsection): ?>
                                                            <div class="category-selection-content__item <?= ((int)$parentSectionId === (int)$arResult['CATEGORIES'][0]['ID'] ) ? 'is-active' : '' ?>"
                                                                 data-announcement-category="<?= $parentSectionId ?>">
                                                                <ul class="category-selection-list">
                                                                    <?php foreach ($subsection as $section): ?>
                                                                        <li class="category-selection-list__item"
                                                                            data-id="<?= $section['ID'] ?>"
                                                                        >
                                                                            <?= $section['NAME'] ?>
                                                                        </li>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="category-selection-ready  <?=($arResult['ELEMENT_PROPS']['IBLOCK_SECTION_ID']) ? 'active' : ''?>"
                                             data-category="<?=($arResult['ELEMENT_PROPS']['IBLOCK_SECTION_ID']) ?: ''?>"
                                        >
                                            <h3 class="category-title">Выбор категории</h3>
                                            <div class="category-selection-ready__main" id="category-select">
                                                <?=($arResult['ELEMENT_PROPS']['IBLOCK_SECTION_NAME'] && $arResult['ELEMENT_PROPS']['SECTION_NAME']) ? $arResult['ELEMENT_PROPS']['SECTION_NAME'] . ' / ' . $arResult['ELEMENT_PROPS']['IBLOCK_SECTION_NAME'] : ''?>
                                            </div>
                                            <div class="category-selection-ready-btn">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.1361 2.01852L13.9995 0.881646C13.4302 0.316893 12.661 0 11.8592 0C11.0575 0 10.2882 0.316893 9.71896 0.881646L1.65778 8.94456C1.26165 9.34566 0.982872 9.84758 0.85166 10.3959L0.0455416 13.7742C-0.0226873 14.0744 -0.0141351 14.3869 0.0704069 14.6829C0.154949 14.9788 0.31275 15.2487 0.529213 15.4675C0.746218 15.6865 1.01591 15.8461 1.31237 15.9308C1.60883 16.0155 1.9221 16.0226 2.22206 15.9512L5.5997 15.1449C6.14789 15.0137 6.6497 14.7349 7.05071 14.3386L15.1119 6.27573C15.3934 5.99487 15.6168 5.66121 15.7692 5.29388C15.9216 4.92654 16 4.53274 16 4.13503C16 3.73732 15.9216 3.34353 15.7692 2.97619C15.6168 2.60885 15.3934 2.27519 15.1119 1.99433L15.1361 2.01852ZM6.22041 13.5001C5.98097 13.741 5.67971 13.9112 5.3498 13.9919L1.97216 14.7982C1.87211 14.82 1.76822 14.8167 1.66977 14.7885C1.57131 14.7604 1.48134 14.7083 1.40788 14.637C1.33715 14.5631 1.28549 14.4731 1.2574 14.3747C1.2293 14.2764 1.22562 14.1727 1.24666 14.0726L2.05278 10.6942C2.13383 10.3661 2.30078 10.0656 2.53645 9.82342L9.00958 3.30052L12.7177 7.00946L6.22041 13.5001ZM14.2816 5.43719L13.5722 6.14673L9.89631 2.44585L10.6057 1.73632C10.9472 1.39609 11.4095 1.20506 11.8915 1.20506C12.3734 1.20506 12.8358 1.39609 13.1772 1.73632L14.2816 2.89737C14.6217 3.2389 14.8127 3.70134 14.8127 4.18341C14.8127 4.66548 14.6217 5.12791 14.2816 5.46944V5.43719Z"
                                                          fill="#ED1C24"/>
                                                </svg>
                                                Изменить подкатегорию
                                            </div>
                                        </div>
                                        <div class="error-form">Необходимо заполнить «Категория»</div>
                                    </div>

                                <?php endif;?>

                                <?php if ($key !== $arResult['LAST_FIELD']): ?>
                                    <?= nextBtnTemplate() ?>
                                <?php else: ?>
                                    <button type="submit"
                                            class="step-form__btn step-form__btn-submit form__btn--disable">
                                        <?=($_GET['action'] === 'edit') ? Loc::getMessage('EDIT') : Loc::getMessage('SUBMIT')?>
                                    </button>
                                <?php endif; ?>
                                <?php if ($ajax === true && $key === 'FIELDS') die(); ?>
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
                                            <a class="step-category__el <?= ($number === (count($sections) - 1) && $lastSectKey !== $key) ? 'step-category__el--center' : '' ?>"
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
