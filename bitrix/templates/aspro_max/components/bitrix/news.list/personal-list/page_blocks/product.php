<div class="product-block">
    <div class="product-menu">
        <ul class="menu">
            <?php if ($ajax === true && $_POST['action'] === 'updateProductsMenu') {ob_end_clean();} ?>
            <?php foreach ($arResult['SECTION_TREE'] as $section) {
                $hasSubmenu = !empty($section['CHILDREN']);
                $class = $hasSubmenu ? 'menu-item has-submenu' : 'menu-item';
                $classLink = !$hasSubmenu ? 'class="last"' : '';
                ?>
                <li class="<?= $class ?>">
                    <a href="" data-sect="<?= $section['ID'] ?>" <?= $classLink ?>>
                        <?php if ($hasSubmenu): ?>
                            <span class="arrow">
            <svg width="6" height="8" viewBox="0 0 6 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.625 3.97998L0.9375 7.87709L0.9375 0.082866L5.625 3.97998Z" fill="#333333"></path>
            </svg>
        </span>
                        <?php endif; ?>
                        <?= $section['NAME'] ?>
                        <span class="quantity">(<?= $section['ELEMENT_COUNT'] ?>)</span>
                    </a>
                    <?php if ($hasSubmenu): ?>
                        <ul class="submenu">
                            <?= renderSectionTree($section['CHILDREN']) ?>
                        </ul>
                    <?php endif; ?>
                </li>
                <?php
            } ?>
            <?php if ($ajax === true && $_POST['action'] === 'updateProductsMenu') {die();} ?>

        </ul>
    </div>
    <div class="product-content">
        <div class="product-update">
            <div class="product-advert-check">
                <input type="checkbox" id="all-product-2">
                <label for="all-product-2" class="all-product-label"></label>
                <label for="all-product-2" class="all-product-text">Выбрать все</label>
            </div>
            <div class="product-update-select">
                <select name="type-moto" class="select-type custom-select check-block" id="updateProduct">
                    <option value="" selected>
                        Выберите действие
                    </option>
                    <option value="active" data-action="active" data-show="none">
                        Опубликовать
                    </option>
                    <option value="pause" data-action="no-active" data-show="none">
                        Постаивть на паузу
                    </option>
                    <?php if ((int)$_GET['section'] !== SERVICES_SECTION_ID): ?>
                        <option value="price" data-action="price" data-show="text">
                            Изменить цену
                        </option>
                    <?php endif; ?>
                    <option value="delete" data-action="delete" data-show="none">
                        Удалить
                    </option>
                </select>
            </div>
            <a href="#" class="product-update-btn">
                Применить
            </a>
        </div>
        <div class="product-advert" data-iblock="<?= $arParams['IBLOCK_ID'] ?>">
            <?php if ($ajax === true && $_GET['subsection']) {
                ob_end_clean();
            } ?>
            <?php foreach ($arResult["ITEMS"] as $arItem): ?>
                <?php
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="product-advert__item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>"
                     data-id="<?= $arItem['ID'] ?>">
                    <div class="product-advert-check">
                        <input type="checkbox" id="product-<?= $arItem['ID'] ?>" class="product-check"
                               data-id="<?= $arItem['ID'] ?>"
                               <?=(!empty($arItem['PROPERTIES']['IS_MODERATION']['VALUE']) || !empty($arItem['PROPERTIES']['MODERATION_ERROR']['VALUE'])) ? 'disabled' : ''?>
                        >
                        <label class="all-product-label" for="product-<?= $arItem['ID'] ?>"></label>
                    </div>
                    <div class="product-item-content">
                        <div class="product-item-left">
                            <div class="product-item__img">
                                <?php $img = (!empty($arItem['PREVIEW_PICTURE'])) ? $arItem['PREVIEW_PICTURE']['SRC'] : SITE_TEMPLATE_PATH . "/images/empty_img_element.png" ?>
                                <img src="<?= $img ?>" alt="img">
                            </div>
                            <div class="product-item-text">
                                <div class="product-item__name product-item__name--flex">
                                    <div>
                                        <?=(!empty($arItem['CURRENT_PRICE']) ? '<span style="color: #ed1c24; font-weight: bold">' . $arItem['CURRENT_PRICE'] . '</span>' . ' | '   : '')?>
                                        <?=(!empty($arItem['CITY']) ? '<span style="font-weight: bold">' . $arItem['CITY'] . '</span>' . ' | '   : '')?>
                                        <?= $arItem['SECTION_NAME'] ?>
                                    </div>

                                    <?php if(!empty($arItem['PROPERTIES']['IS_MODERATION']['VALUE'])):?>
                                    <span class="moderation">
                                                <svg width="13" height="14" viewBox="0 0 13 14" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
<path d="M6.5 0.5C2.91744 0.5 0 3.41744 0 7C0 10.5826 2.91744 13.5 6.5 13.5C10.0826 13.5 13 10.5826 13 7C13 3.41744 10.0826 0.5 6.5 0.5ZM5.44186 9.26744C5.44186 9.52442 5.24535 9.72093 4.98837 9.72093C4.7314 9.72093 4.53488 9.52442 4.53488 9.26744V4.73256C4.53488 4.47558 4.7314 4.27907 4.98837 4.27907C5.24535 4.27907 5.44186 4.47558 5.44186 4.73256V9.26744ZM8.46512 9.26744C8.46512 9.52442 8.2686 9.72093 8.01163 9.72093C7.75465 9.72093 7.55814 9.52442 7.55814 9.26744V4.73256C7.55814 4.47558 7.75465 4.27907 8.01163 4.27907C8.2686 4.27907 8.46512 4.47558 8.46512 4.73256V9.26744Z"
      fill="#30A960"/>
</svg>
                                                На проверке у модератора, до 2-х рабочих дней</span>
                                    <?php elseif (empty($arItem['PROPERTIES']['IS_MODERATION']['VALUE']) && !empty($arItem['PROPERTIES']['MODERATION_ERROR']['VALUE'])):?>
                                        <div class="advert-mod-error">
                                            <span>Не прошло модерацию:</span> <?=$arItem['PROPERTIES']['MODERATION_ERROR']['VALUE']?>
                                        </div>
                                    <?php endif;?>
                                </div>
                                <a href="/<?=$arItem['DETAIL_PAGE_URL']?>" class="product-item__title">
                                    <?= $arItem['NAME'] ?>
                                </a>
                                <div style="font-size: 10px; margin-bottom: 5px"> Артикул : <?= $arItem['PROPERTIES']['exp_id']['VALUE'] ?></div>

                                <div class="advert-info-card">
                                    <div class="advert-info__btn-stats">
                                        <svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.4267 11.646H0V11.9994H10.4267V11.646Z" fill="#505456"/>
                                            <path d="M2.79474 7.29834H1.36328V11.8225H2.79474V7.29834Z" fill="#505456"/>
                                            <path d="M2.95083 11.9996H1.18359V7.12207H2.9685V11.9996H2.95083ZM1.53704 11.6462H2.61505V7.47552H1.53704V11.6462Z" fill="#505456"/>
                                            <path d="M9.18927 2.98682H7.75781V11.823H9.18927V2.98682Z" fill="#505456"/>
                                            <path d="M9.34926 11.9992H7.58203V2.80957H9.36693V11.9992H9.34926ZM7.93548 11.6457H9.01349V3.16302H7.93548V11.6457Z" fill="#505456"/>
                                            <path d="M5.99396 5.58496H4.5625V11.8233H5.99396V5.58496Z" fill="#505456"/>
                                            <path d="M6.15004 11.9995H4.38281V5.40771H6.16772V11.9995H6.15004ZM4.73626 11.646H5.81427V5.76116H4.73626V11.646Z" fill="#505456"/>
                                            <path d="M9.89472 0.603992L9.73047 0.291016L0.466358 5.15271L0.630605 5.46569L9.89472 0.603992Z" fill="#505456"/>
                                            <path d="M8.99609 0.158691L9.84437 0.441448L9.57928 1.27205" fill="#505456"/>
                                            <path d="M9.75824 1.32542L9.42246 1.23706L9.61686 0.547842L8.94531 0.335774L9.05135 0L10.0587 0.318102L9.75824 1.32542Z" fill="#505456"/>
                                        </svg>
                                        <span>
                                            Статистика
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4.92578 9L8.8229 4.3125H1.02867L4.92578 9Z" fill="#666666"/>
                                        </svg>
                                        </span>

                                    </div>
                                    <div class="publish-data__day"> <?= $arItem['FORMAT_ACTIVE_FROM'] ?></div>
                                    <?php if($arItem['UP_DAYS']):?>
                                        <div class="advert-data__day">
                                            <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.67075 9.71069H3.94756C3.63572 9.71069 3.37891 9.86765 3.37891 10.0351V10.9036C3.37891 11.0814 3.65406 11.2279 3.94756 11.2279H9.67075C9.98259 11.2279 10.2394 11.071 10.2394 10.9036V10.0351C10.2394 9.86765 9.98259 9.71069 9.67075 9.71069Z"
                                                      fill="#37C770"></path>
                                                <path d="M13.5221 4.93926L7.26697 0.889811C7.04684 0.732856 6.58825 0.732856 6.34979 0.889811L0.0946302 4.93926C-0.125493 5.09621 0.057943 5.3578 0.443158 5.3578H3.37813V8.07836C3.37813 8.25624 3.65328 8.40274 3.94678 8.40274H9.66997C9.98181 8.40274 10.2386 8.24578 10.2386 8.07836V5.3578H13.1736C13.5772 5.3578 13.7606 5.09621 13.5221 4.93926Z"
                                                      fill="#37C770"></path>
                                            </svg>
                                            <span>Поднято:</span> <?=$arItem['UP_DAYS']?>
                                        </div>
                                    <?php endif;?>
                                </div>

                            </div>
                        </div>
                        <div class="product-item-right">
                            <?php if(empty($arItem['PROPERTIES']['IS_MODERATION']['VALUE']) && empty($arItem['PROPERTIES']['MODERATION_ERROR']['VALUE'])):?>
                            <div class="product-item-btn">
                                <?php if(!$arItem['UP_TIME_LEFT']):?>
                                <a href="#" class="advert-btn-up">
                                    <svg width="14" height="11" viewBox="0 0 14 11" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.9865 0.798562L9.18416 1.83105C8.79274 1.93006 8.66693 2.42508 8.94651 2.7221L9.84118 3.6273L7.56257 5.93271H3.88604C3.70431 5.93271 3.52258 6.00343 3.39677 6.14487L0.572969 9.00189C0.293385 9.28476 0.293385 9.72322 0.572969 10.0061C0.712761 10.1475 0.894491 10.2182 1.06224 10.2182C1.22999 10.2182 1.4257 10.1475 1.55151 10.0061L4.16563 7.36122H7.84216C8.02389 7.36122 8.20562 7.29051 8.33143 7.14907L10.8197 4.6315L11.7144 5.53669C11.994 5.81956 12.4833 5.69227 12.5951 5.29625L13.6156 1.44917C13.7274 1.05315 13.3779 0.699557 12.9865 0.798562Z"
                                              fill="white"/>
                                    </svg>
                                    Поднять
                                </a>
                                <?php else:?>
                                    <div class="btn-inner">
                                        <div class="btn-info-update">
                                            <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.67075 9.71069H3.94756C3.63572 9.71069 3.37891 9.86765 3.37891 10.0351V10.9036C3.37891 11.0814 3.65406 11.2279 3.94756 11.2279H9.67075C9.98259 11.2279 10.2394 11.071 10.2394 10.9036V10.0351C10.2394 9.86765 9.98259 9.71069 9.67075 9.71069Z" fill="#37C770"/>
                                                <path d="M13.5221 4.93913L7.26697 0.889689C7.04684 0.732734 6.58825 0.732734 6.34979 0.889689L0.0946302 4.93913C-0.125493 5.09609 0.057943 5.35768 0.443158 5.35768H3.37813V8.07824C3.37813 8.25612 3.65328 8.40261 3.94678 8.40261H9.66997C9.98182 8.40261 10.2386 8.24566 10.2386 8.07824V5.35768H13.1736C13.5772 5.35768 13.7606 5.09609 13.5221 4.93913Z" fill="#37C770"/>
                                            </svg>
                                            Через <?=$arItem['UP_TIME_LEFT']?> ч.
                                        </div>
                                        <a href="#" class="advert-btn-update">
                                            <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.30674 0.36134C5.93024 -0.791579 2.20532 0.90639 1.00384 4.14627C0.53031 5.42399 0.513644 6.78018 0.906756 8.0301L1.56696 6.25009L1.57932 6.25412C1.57614 5.64767 1.67788 5.03702 1.89543 4.45082C2.92188 1.68253 6.10436 0.231875 8.98958 1.2169C11.8746 2.20148 13.3867 5.25478 12.36 8.02265C11.3737 10.6824 8.36417 12.1363 5.56634 11.3491L5.87156 10.5263L3.43124 11.0807L4.95422 13L5.24887 12.2057C8.53855 13.16 12.0916 11.4576 13.2524 8.32777C14.4537 5.08744 12.6845 1.51394 9.30682 0.361494L9.30674 0.36134Z" fill="white"/>
                                            </svg>
                                            Обновить за 7,80 р.
                                        </a>
                                    </div>
                                <?php endif;?>

                                <?php if ($arItem['ACTIVE'] === 'N'): ?>
                                    <a href="#" class="advert-btn-post">
                                        Опубликовать
                                        <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.14738 0.808087C1.99486 0.89135 1.9 1.05124 1.9 1.225L1.9 9.775C1.9 9.94875 1.99486 10.1086 2.14738 10.1919C2.2999 10.2752 2.48567 10.2685 2.63188 10.1746L9.28186 5.89957C9.41782 5.81217 9.5 5.66164 9.5 5.5C9.5 5.33836 9.41782 5.18783 9.28186 5.10043L2.63188 0.825439C2.48568 0.731479 2.2999 0.724824 2.14738 0.808087Z"
                                                  fill="#028F3A"></path>
                                            <path d="M0.949218 9.775C0.949218 10.0373 0.736561 10.25 0.474218 10.25C0.211876 10.25 -0.000781644 10.0373 -0.000781633 9.775L-0.000781259 1.225C-0.000781247 0.962667 0.211876 0.75 0.474219 0.75C0.736561 0.75 0.949219 0.962667 0.949219 1.225L0.949218 9.775Z"
                                                  fill="#028F3A"></path>
                                        </svg>
                                    </a>
                                <?php else: ?>
                                    <a href="#" class="advert-btn-pause">
                                        На паузу
                                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.5 0C2.91744 0 0 2.91744 0 6.5C0 10.0826 2.91744 13 6.5 13C10.0826 13 13 10.0826 13 6.5C13 2.91744 10.0826 0 6.5 0ZM5.44186 8.76744C5.44186 9.02442 5.24535 9.22093 4.98837 9.22093C4.7314 9.22093 4.53488 9.02442 4.53488 8.76744V4.23256C4.53488 3.97558 4.7314 3.77907 4.98837 3.77907C5.24535 3.77907 5.44186 3.97558 5.44186 4.23256V8.76744ZM8.46512 8.76744C8.46512 9.02442 8.2686 9.22093 8.01163 9.22093C7.75465 9.22093 7.55814 9.02442 7.55814 8.76744V4.23256C7.55814 3.97558 7.75465 3.77907 8.01163 3.77907C8.2686 3.77907 8.46512 3.97558 8.46512 4.23256V8.76744Z"
                                                  fill="#ED1C24"></path>
                                        </svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <?php endif;?>
                            <div class="advert-edit">
                                <a href="/add/?action=edit&type=<?= $_GET['section'] ?>&element=<?= $arItem['ID'] ?>" class="advert-edit__item">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.1361 2.01852L13.9995 0.881646C13.4302 0.316893 12.661 0 11.8592 0C11.0575 0 10.2882 0.316893 9.71896 0.881646L1.65778 8.94456C1.26165 9.34566 0.982872 9.84758 0.85166 10.3959L0.0455416 13.7742C-0.0226873 14.0744 -0.0141351 14.3869 0.0704069 14.6829C0.154949 14.9788 0.31275 15.2487 0.529213 15.4675C0.746218 15.6865 1.01591 15.8461 1.31237 15.9308C1.60883 16.0155 1.9221 16.0226 2.22206 15.9512L5.5997 15.1449C6.14789 15.0137 6.6497 14.7349 7.05071 14.3386L15.1119 6.27573C15.3934 5.99487 15.6168 5.66121 15.7692 5.29388C15.9216 4.92654 16 4.53274 16 4.13503C16 3.73732 15.9216 3.34352 15.7692 2.97619C15.6168 2.60885 15.3934 2.27519 15.1119 1.99433L15.1361 2.01852ZM6.22041 13.5001C5.98097 13.741 5.67971 13.9112 5.3498 13.9919L1.97216 14.7982C1.87211 14.82 1.76822 14.8167 1.66977 14.7885C1.57131 14.7604 1.48134 14.7083 1.40788 14.637C1.33715 14.5631 1.28549 14.4731 1.2574 14.3747C1.2293 14.2764 1.22562 14.1727 1.24666 14.0726L2.05278 10.6942C2.13383 10.3661 2.30078 10.0656 2.53645 9.82342L9.00958 3.30052L12.7177 7.00946L6.22041 13.5001ZM14.2816 5.43719L13.5722 6.14673L9.89631 2.44585L10.6057 1.73632C10.9472 1.39609 11.4095 1.20506 11.8915 1.20506C12.3734 1.20506 12.8358 1.39609 13.1772 1.73632L14.2816 2.89737C14.6217 3.2389 14.8127 3.70134 14.8127 4.18341C14.8127 4.66548 14.6217 5.12791 14.2816 5.46944V5.43719Z"
                                              fill="#999999"></path>
                                    </svg>
                                </a>
                                <a href="/add/?action=copy&type=<?= $_GET['section'] ?>&element=<?= $arItem['ID'] ?>"
                                   class="advert-edit__item">
                                    <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.86848 1.6429C4.85887 1.6601 4.85488 1.6707 4.85488 1.6707C4.76076 1.95306 4.45555 2.1057 4.17318 2.01157C3.89082 1.91745 3.73822 1.61225 3.83234 1.32989C4.00318 0.81738 4.69317 0.0947876 5.88424 0.0947876H13.2985C13.7843 0.0947876 14.3116 0.136266 14.7193 0.395693C15.1898 0.695113 15.3781 1.19223 15.3781 1.78918V12.2848C15.3781 12.8783 15.1381 13.3448 14.7471 13.6648C14.3764 13.9681 13.9055 14.1121 13.4617 14.1676C13.1663 14.2045 12.897 13.995 12.8601 13.6997C12.8232 13.4043 13.0327 13.135 13.328 13.0981C13.6545 13.0572 13.9058 12.9605 14.0646 12.8306C14.2032 12.7172 14.3003 12.5578 14.3003 12.2848V1.78918C14.3003 1.42324 14.1997 1.34261 14.1406 1.30502C14.0187 1.22743 13.7757 1.17262 13.2985 1.17262H5.88424C5.51638 1.17262 5.26458 1.28122 5.10218 1.39722C5.01889 1.45672 4.9572 1.51957 4.91494 1.5739C4.89387 1.60099 4.87871 1.62458 4.86848 1.6429Z" fill="#999999"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.23471 3.38844C1.6159 3.04191 2.11425 2.88721 2.60826 2.88721H10.3114C10.6064 2.88721 11.0909 2.94334 11.5172 3.23324C11.9747 3.54438 12.289 4.07318 12.2946 4.84934C12.3434 5.52061 12.3426 7.33908 12.3308 9.30304C12.3263 10.0489 12.3202 10.8199 12.3142 11.5659C12.3042 12.8232 12.2947 14.0095 12.2947 14.8846C12.2947 15.2128 12.2003 15.6972 11.8839 16.1134C11.5477 16.5558 10.9999 16.8679 10.2151 16.8679H2.51197C2.21748 16.8679 1.76342 16.7662 1.37016 16.4712C0.949682 16.1559 0.625 15.637 0.625 14.8846V4.87047C0.625 4.25465 0.845253 3.74249 1.23471 3.38844ZM1.95974 4.18598C1.8196 4.31338 1.70284 4.52339 1.70284 4.87047V14.8846C1.70284 15.2877 1.8596 15.491 2.01686 15.6089C2.20134 15.7473 2.42131 15.79 2.51197 15.79H10.2151C10.6821 15.79 10.9047 15.6206 11.0258 15.4612C11.1668 15.2757 11.2169 15.0379 11.2169 14.8846C11.2169 14.0058 11.2264 12.8112 11.2365 11.55C11.2424 10.805 11.2485 10.0367 11.253 9.29655C11.2651 7.28455 11.2644 5.50922 11.2185 4.9118L11.2169 4.89117V4.87047C11.2169 4.4064 11.0512 4.21981 10.9111 4.12453C10.7356 4.0052 10.4979 3.96504 10.3114 3.96504H2.60826C2.33196 3.96504 2.10814 4.05107 1.95974 4.18598Z" fill="#999999"/>
                                    </svg>
                                </a>
                                <a href="#" class="advert-edit__del">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.3846 3.28205H11.8974V2.25641C11.8974 1.65797 11.6597 1.08405 11.2365 0.660887C10.8134 0.237728 10.2395 0 9.64103 0H6.35897C5.76054 0 5.18661 0.237728 4.76345 0.660887C4.34029 1.08405 4.10256 1.65797 4.10256 2.25641V3.28205H0.615385C0.452174 3.28205 0.295649 3.34689 0.180242 3.46229C0.0648349 3.5777 0 3.73423 0 3.89744C0 4.06065 0.0648349 4.21717 0.180242 4.33258C0.295649 4.44799 0.452174 4.51282 0.615385 4.51282H1.64103V12.9231C1.64103 13.7391 1.9652 14.5218 2.54224 15.0988C3.11927 15.6758 3.9019 16 4.71795 16H11.2821C12.0981 16 12.8807 15.6758 13.4578 15.0988C14.0348 14.5218 14.359 13.7391 14.359 12.9231V4.51282H15.3846C15.5478 4.51282 15.7044 4.44799 15.8198 4.33258C15.9352 4.21717 16 4.06065 16 3.89744C16 3.73423 15.9352 3.5777 15.8198 3.46229C15.7044 3.34689 15.5478 3.28205 15.3846 3.28205ZM5.33333 2.25641C5.33333 1.98439 5.44139 1.72352 5.63374 1.53117C5.82608 1.33883 6.08696 1.23077 6.35897 1.23077H9.64103C9.91304 1.23077 10.1739 1.33883 10.3663 1.53117C10.5586 1.72352 10.6667 1.98439 10.6667 2.25641V3.28205H5.33333V2.25641ZM13.1282 12.9231C13.1282 13.4127 12.9337 13.8823 12.5875 14.2285C12.2413 14.5747 11.7717 14.7692 11.2821 14.7692H4.71795C4.22832 14.7692 3.75874 14.5747 3.41252 14.2285C3.0663 13.8823 2.87179 13.4127 2.87179 12.9231V4.51282H13.1282V12.9231Z"
                                              fill="#999999"></path>
                                        <path d="M7.9982 6.56409C7.83565 6.56621 7.68035 6.63173 7.5654 6.74668C7.45046 6.86163 7.38494 7.01692 7.38281 7.17947V11.282C7.38281 11.4452 7.44765 11.6018 7.56305 11.7172C7.67846 11.8326 7.83499 11.8974 7.9982 11.8974C8.16141 11.8974 8.31793 11.8326 8.43334 11.7172C8.54875 11.6018 8.61358 11.4452 8.61358 11.282V7.17947C8.61146 7.01692 8.54594 6.86163 8.43099 6.74668C8.31604 6.63173 8.16075 6.56621 7.9982 6.56409Z"
                                              fill="#999999"></path>
                                        <path d="M10.463 6.56409C10.3005 6.56621 10.1452 6.63173 10.0302 6.74668C9.9153 6.86163 9.84978 7.01692 9.84766 7.17947V11.282C9.84766 11.4452 9.91249 11.6018 10.0279 11.7172C10.1433 11.8326 10.2998 11.8974 10.463 11.8974C10.6263 11.8974 10.7828 11.8326 10.8982 11.7172C11.0136 11.6018 11.0784 11.4452 11.0784 11.282V7.17947C11.0763 7.01692 11.0108 6.86163 10.8958 6.74668C10.7809 6.63173 10.6256 6.56621 10.463 6.56409Z"
                                              fill="#999999"></path>
                                        <path d="M5.53726 6.56409C5.37471 6.56621 5.21942 6.63173 5.10447 6.74668C4.98952 6.86163 4.924 7.01692 4.92188 7.17947V11.282C4.92188 11.4452 4.98671 11.6018 5.10212 11.7172C5.21752 11.8326 5.37405 11.8974 5.53726 11.8974C5.70047 11.8974 5.85699 11.8326 5.9724 11.7172C6.08781 11.6018 6.15264 11.4452 6.15264 11.282V7.17947C6.15052 7.01692 6.085 6.86163 5.97005 6.74668C5.8551 6.63173 5.69981 6.56621 5.53726 6.56409Z"
                                              fill="#999999"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-advert__stat">
                    <div class="product-statistics">
                        <?php $allShow = (!empty($arItem['PROPERTIES']['SHOW_ALL']['VALUE'])) ? $arItem['PROPERTIES']['SHOW_ALL']['VALUE'] : 0?>
                        <?php $phoneShow = (!empty($arItem['PROPERTIES']['SHOW_PHONE']['VALUE'])) ? $arItem['PROPERTIES']['SHOW_PHONE']['VALUE'] : 0?>
                        <div class="product-statistics__el">
                            <div class="product-statistics__el-num"><?=number_format($allShow, 0, '.', ' ')?></div>
                            <div class="product-statistics__el-text"><?=getPluralForm($allShow, ['просмотр', 'просмотра', 'просмотров'])?> объявления</div>
                        </div>
                        <div class="product-statistics__el">
                            <div class="product-statistics__el-num"><?=number_format($phoneShow, 0, '.', ' ')?></div>
                            <div class="product-statistics__el-text"><?=getPluralForm($phoneShow, ['просмотр', 'просмотра', 'просмотров'])?> телефона</div>
                        </div>
                        <div class="product-statistics__el">
                            <div class="product-statistics__el-num"><?=$arItem['FAVORIT_COUNT']?></div>
                            <div class="product-statistics__el-text">пользователей добавлены в закладки</div>
                        </div>
                        <div class="product-statistics__el">
                            <div class="product-statistics__el-num"><?= $arItem['DIFF_DAYS'] ?></div>
                            <div class="product-statistics__el-text"><?= getPluralForm((int)$arItem['DIFF_DAYS'], ['день', 'дня', 'дней']) ?> в продаже</div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
<!--            --><?php //if ($ajax === true && $_GET['subsection']) {
//                die();
//            } ?>
        </div>
    </div>
</div>

<?php
function renderSectionTree(array $sections): void
{
    foreach ($sections as $section) {
        $hasSubmenu = !empty($section['CHILDREN']);
        $class = $hasSubmenu ? 'menu-item has-submenu' : 'menu-item';
        $classLink = !$hasSubmenu ? 'class="last"' : '';
        ?>
        <li class="<?= $class ?>">
            <a href="" data-sect="<?= $section['ID'] ?>" <?= $classLink ?>>
                <?php if ($hasSubmenu): ?>
                    <span class="arrow">
                        <svg width="6" height="8" viewBox="0 0 6 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.625 3.97998L0.9375 7.87709L0.9375 0.082866L5.625 3.97998Z" fill="#333333"></path>
                        </svg>
                    </span>
                <?php endif; ?>
                <?= $section['NAME'] ?>&nbsp;<span class="quantity">(<?= $section['ELEMENT_COUNT'] ?>)</span>

            </a>
            <?php if ($hasSubmenu): ?>
                <ul class="submenu">
                    <?= renderSectionTree($section['CHILDREN']) ?>
                </ul>
            <?php endif; ?>
        </li>
        <?php
    }
}

?>