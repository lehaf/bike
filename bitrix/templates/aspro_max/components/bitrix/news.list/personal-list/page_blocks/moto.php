<?php $sectionCode = (!empty($arResult['SECTIONS'][$activeSect]['UF_SECTION_CODE'])) ? $arResult['SECTIONS'][$activeSect]['UF_SECTION_CODE'] : $arResult['SECTIONS'][$activeSect]['CODE']?>
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
                                <?php if ($arItem['ACTIVE'] === 'N'): ?>
                                    <div class="advert-item__status__content">
                                        <div class="advert-item__status__content__btn">
                                            <svg width="6" height="6" viewBox="0 0 6 6" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="3" cy="3" r="3" fill="#ED1C24"/>
                                            </svg>
                                            Не опубликовано
                                        </div>
                                        <?php if(!empty($arItem['PROPERTIES']['IS_MODERATION']['VALUE'])):?>
                                            <span class="moderation">
                                                <svg width="13" height="14" viewBox="0 0 13 14" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
<path d="M6.5 0.5C2.91744 0.5 0 3.41744 0 7C0 10.5826 2.91744 13.5 6.5 13.5C10.0826 13.5 13 10.5826 13 7C13 3.41744 10.0826 0.5 6.5 0.5ZM5.44186 9.26744C5.44186 9.52442 5.24535 9.72093 4.98837 9.72093C4.7314 9.72093 4.53488 9.52442 4.53488 9.26744V4.73256C4.53488 4.47558 4.7314 4.27907 4.98837 4.27907C5.24535 4.27907 5.44186 4.47558 5.44186 4.73256V9.26744ZM8.46512 9.26744C8.46512 9.52442 8.2686 9.72093 8.01163 9.72093C7.75465 9.72093 7.55814 9.52442 7.55814 9.26744V4.73256C7.55814 4.47558 7.75465 4.27907 8.01163 4.27907C8.2686 4.27907 8.46512 4.47558 8.46512 4.73256V9.26744Z"
      fill="#30A960"/>
</svg>
                                             На проверке у модератора, до 2-х рабочих дней
                                               </span>
                                        <?php else:?>
                                        <span>На паузе</span>
                                        <?php endif;?>
                                    </div>
                                <?php else: ?>
                                    <div class="advert-item__status__content checking">
                                        <div class="advert-status--published">
                                            <svg width="6" height="6" viewBox="0 0 6 6" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="3" cy="3" r="3" fill="#30A960"/>
                                            </svg>
                                            Опубликовано
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="advert-item__status-num">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.19095 5.64706H9.98552L10.367 4.12116C10.43 3.86902 10.6855 3.71572 10.9377 3.77876C11.1898 3.84179 11.3431 4.09729 11.2801 4.34943L10.9557 5.64706H11.7647C12.0246 5.64706 12.2353 5.85775 12.2353 6.11765C12.2353 6.37755 12.0246 6.58824 11.7647 6.58824H10.7204L10.0145 9.41177H11.7647C12.0246 9.41177 12.2353 9.62245 12.2353 9.88235C12.2353 10.1423 12.0246 10.3529 11.7647 10.3529H9.77919L9.39771 11.8788C9.33468 12.131 9.07918 12.2843 8.82704 12.2212C8.5749 12.1582 8.4216 11.9027 8.48464 11.6506L8.80905 10.3529H6.01448L5.63301 11.8788C5.56997 12.131 5.31447 12.2843 5.06234 12.2212C4.8102 12.1582 4.6569 11.9027 4.71993 11.6506L5.04434 10.3529H4.23529C3.9754 10.3529 3.76471 10.1423 3.76471 9.88235C3.76471 9.62245 3.9754 9.41177 4.23529 9.41177H5.27963L5.98552 6.58824H4.23529C3.9754 6.58824 3.76471 6.37755 3.76471 6.11765C3.76471 5.85775 3.9754 5.64706 4.23529 5.64706H6.22081L6.60229 4.12116C6.66532 3.86902 6.92082 3.71572 7.17296 3.77876C7.4251 3.84179 7.5784 4.09729 7.51536 4.34943L7.19095 5.64706ZM6.95566 6.58824L6.24978 9.41177H9.04434L9.75022 6.58824H6.95566ZM4.23529 16C1.89621 16 0 14.1038 0 11.7647V4.23529C0 1.89621 1.89621 0 4.23529 0H11.7647C14.1038 0 16 1.89621 16 4.23529V11.7647C16 14.1038 14.1038 16 11.7647 16H4.23529ZM4.23529 15.0588H11.7647C13.584 15.0588 15.0588 13.584 15.0588 11.7647V4.23529C15.0588 2.416 13.584 0.941176 11.7647 0.941176H4.23529C2.416 0.941176 0.941176 2.416 0.941176 4.23529V11.7647C0.941176 13.584 2.416 15.0588 4.23529 15.0588Z"
                                              fill="#666666"/>
                                    </svg>
                                    Артикул: <?= $arItem['PROPERTIES']['exp_id']['VALUE'] ?>
                                </div>
                            </div>

                            <?php if(!empty($arItem['PROPERTIES']['MODERATION_ERROR']['VALUE']) && empty($arItem['PROPERTIES']['IS_MODERATION']['VALUE'])):?>
                                <div class="advert-mod-error">
                                    <span>Не прошло модерацию:</span> <?=$arItem['PROPERTIES']['MODERATION_ERROR']['VALUE']?>
                                </div>
                            <?php endif;?>

                            <div class="advert-description">
                                <?php if ((int)$arResult['PARENT_SECTION_ID'] !== TRANSPORT_SECTION_ID): ?>
                                    <div class="advert-description__text">
                                        <?= $arItem['DETAIL_TEXT'] ?>
                                    </div>
                                <?php else: ?>
                                    <div class="advert-description-list">
                                        <div class="advert-description__inner">
                                            <?php if (!empty($arItem['PROPERTIES']['power']['VALUE'])): ?>
                                                <div class="advert-description-list__el">
                                                    <?= $arItem['PROPERTIES']['power']['VALUE'] ?> см3 <span>/</span>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (!empty($arItem['PROPERTIES']['energy']['VALUE'])): ?>
                                                <div class="advert-description-list__el">
                                                    <?= $arItem['PROPERTIES']['energy']['VALUE'] ?> л.с. <span>/</span>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (!empty($arItem['PROPERTIES']['cycles_number_' . $sectionCode]['VALUE'])): ?>
                                                <div class="advert-description-list__el">
                                                    <?= $arItem['PROPERTIES']['cycles_number_' . $sectionCode]['VALUE_ENUM'] ?>
                                                    <?= getPluralForm($arItem['PROPERTIES']['cycles_number_' . $sectionCode]['VALUE_ENUM'], ['такт', 'такта', 'тактов']) ?>
                                                    <span>/</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="advert-description__inner">
                                            <?php if (!empty($arItem['PROPERTIES']['cylinders_count_' . $sectionCode]['VALUE'])): ?>
                                                <div class="advert-description-list__el">
                                                    <?= $arItem['PROPERTIES']['cylinders_count_' . $sectionCode]['VALUE_ENUM'] ?>
                                                    <?= getPluralForm($arItem['PROPERTIES']['cylinders_count_' . $sectionCode]['VALUE_ENUM'], ['цилиндр', 'цилиндра', 'цилиндров']) ?>
                                                    <span>/</span>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (!empty($arItem['PROPERTIES']['cylinder_place_' . $sectionCode]['VALUE'])): ?>
                                                <div class="advert-description-list__el">
                                                    <?= $arItem['PROPERTIES']['cylinder_place_' . $sectionCode]['VALUE_ENUM'] ?>
                                                    <span>/</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <?php if (!empty($arItem['PROPERTIES']['transmission_' . $sectionCode]['VALUE'])): ?>
                                            <div class="advert-description__inner">
                                                <div class="advert-description-list__el">
                                                    <?= $arItem['PROPERTIES']['transmission_' . $sectionCode]['VALUE_ENUM'] ?>
                                                    <span>/</span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="advert-description__data">
                                    <div class="advert-description__data__el"> <?= $arItem['PROPERTIES']['count_door_' . $sectionCode]['VALUE_ENUM'] ?></div>
                                    <div class="advert-description__data__el"><?= $arItem['PROPERTIES']['color']['VALUE_ENUM'] ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="advert-item__info__right">
                            <?php if (!empty($arItem['PRICES'])): ?>
                                <div class="advert-price">
                                    <div class="advert-price__title">
                                        <?php if(!empty($arItem['PROPERTIES']['contract_price']['VALUE'])):?>
                                            Договорная
                                        <?php else:?>
                                            <?=(!empty($arItem['PROPERTIES']['price_from']['VALUE'])) ? 'от ' : ''?><?= $arItem['PRICES']['BASE']?><?=(!empty($arItem['PROPERTIES']['arenda_unit']['VALUE'])) ? ' / ' . mb_strtolower($arItem['PROPERTIES']['arenda_unit']['VALUE']) : ''?>
                                        <?php endif;?>
                                    </div>
                                    <?php if (empty($arItem['PROPERTIES']['contract_price']['VALUE'])): ?>
                                        <div class="advert-price-list">
                                            <?php foreach ($arItem['PRICES']['CONVERT'] as $price): ?>
                                                <div class="advert-price-list__el">≈ <?= $price ?></div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <div class="advert-edit">
                                <a href="/add/?action=edit&type=<?= $_GET['section'] ?>&element=<?= $arItem['ID'] ?>"
                                   class="advert-edit__item">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.1361 2.01852L13.9995 0.881646C13.4302 0.316893 12.661 0 11.8592 0C11.0575 0 10.2882 0.316893 9.71896 0.881646L1.65778 8.94456C1.26165 9.34566 0.982872 9.84758 0.85166 10.3959L0.0455416 13.7742C-0.0226873 14.0744 -0.0141351 14.3869 0.0704069 14.6829C0.154949 14.9788 0.31275 15.2487 0.529213 15.4675C0.746218 15.6865 1.01591 15.8461 1.31237 15.9308C1.60883 16.0155 1.9221 16.0226 2.22206 15.9512L5.5997 15.1449C6.14789 15.0137 6.6497 14.7349 7.05071 14.3386L15.1119 6.27573C15.3934 5.99487 15.6168 5.66121 15.7692 5.29388C15.9216 4.92654 16 4.53274 16 4.13503C16 3.73732 15.9216 3.34352 15.7692 2.97619C15.6168 2.60885 15.3934 2.27519 15.1119 1.99433L15.1361 2.01852ZM6.22041 13.5001C5.98097 13.741 5.67971 13.9112 5.3498 13.9919L1.97216 14.7982C1.87211 14.82 1.76822 14.8167 1.66977 14.7885C1.57131 14.7604 1.48134 14.7083 1.40788 14.637C1.33715 14.5631 1.28549 14.4731 1.2574 14.3747C1.2293 14.2764 1.22562 14.1727 1.24666 14.0726L2.05278 10.6942C2.13383 10.3661 2.30078 10.0656 2.53645 9.82342L9.00958 3.30052L12.7177 7.00946L6.22041 13.5001ZM14.2816 5.43719L13.5722 6.14673L9.89631 2.44585L10.6057 1.73632C10.9472 1.39609 11.4095 1.20506 11.8915 1.20506C12.3734 1.20506 12.8358 1.39609 13.1772 1.73632L14.2816 2.89737C14.6217 3.2389 14.8127 3.70134 14.8127 4.18341C14.8127 4.66548 14.6217 5.12791 14.2816 5.46944V5.43719Z"
                                              fill="#999999"/>
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
                                              fill="#999999"/>
                                        <path d="M7.9982 6.56409C7.83565 6.56621 7.68035 6.63173 7.5654 6.74668C7.45046 6.86163 7.38494 7.01692 7.38281 7.17947V11.282C7.38281 11.4452 7.44765 11.6018 7.56305 11.7172C7.67846 11.8326 7.83499 11.8974 7.9982 11.8974C8.16141 11.8974 8.31793 11.8326 8.43334 11.7172C8.54875 11.6018 8.61358 11.4452 8.61358 11.282V7.17947C8.61146 7.01692 8.54594 6.86163 8.43099 6.74668C8.31604 6.63173 8.16075 6.56621 7.9982 6.56409Z"
                                              fill="#999999"/>
                                        <path d="M10.463 6.56409C10.3005 6.56621 10.1452 6.63173 10.0302 6.74668C9.9153 6.86163 9.84978 7.01692 9.84766 7.17947V11.282C9.84766 11.4452 9.91249 11.6018 10.0279 11.7172C10.1433 11.8326 10.2998 11.8974 10.463 11.8974C10.6263 11.8974 10.7828 11.8326 10.8982 11.7172C11.0136 11.6018 11.0784 11.4452 11.0784 11.282V7.17947C11.0763 7.01692 11.0108 6.86163 10.8958 6.74668C10.7809 6.63173 10.6256 6.56621 10.463 6.56409Z"
                                              fill="#999999"/>
                                        <path d="M5.53726 6.56409C5.37471 6.56621 5.21942 6.63173 5.10447 6.74668C4.98952 6.86163 4.924 7.01692 4.92188 7.17947V11.282C4.92188 11.4452 4.98671 11.6018 5.10212 11.7172C5.21752 11.8326 5.37405 11.8974 5.53726 11.8974C5.70047 11.8974 5.85699 11.8326 5.9724 11.7172C6.08781 11.6018 6.15264 11.4452 6.15264 11.282V7.17947C6.15052 7.01692 6.085 6.86163 5.97005 6.74668C5.8551 6.63173 5.69981 6.56621 5.53726 6.56409Z"
                                              fill="#999999"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(empty($arItem['PROPERTIES']['IS_MODERATION']['VALUE']) && empty($arItem['PROPERTIES']['MODERATION_ERROR']['VALUE'])):?>
                <div class="advert-btn">
                    <?php if(!$arItem['UP_TIME_LEFT']):?>
                    <a href="#" class="advert-btn-up">
                        Поднять <span>вверх</span>
                        <svg width="20" height="14" viewBox="0 0 20 14" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.2773 0.192756L12.7718 1.68771C12.2051 1.83106 12.0229 2.54781 12.4278 2.97787L13.7232 4.28851L10.4239 7.62655H5.10064C4.83751 7.62655 4.57438 7.72894 4.39222 7.93373L0.30361 12.0704C-0.101203 12.48 -0.101203 13.1149 0.30361 13.5244C0.506016 13.7292 0.769144 13.8316 1.01203 13.8316C1.25492 13.8316 1.53829 13.7292 1.72045 13.5244L5.50545 9.6949H10.8287C11.0919 9.6949 11.355 9.59251 11.5372 9.38772L15.14 5.7425L16.4354 7.05314C16.8402 7.46272 17.5486 7.27841 17.7106 6.705L19.1881 1.13478C19.3501 0.561374 18.844 0.0494046 18.2773 0.192756Z"
                                  fill="white"/>
                        </svg>
                    </a>
                    <?php else:?>
                        <div class="btn-info-update">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.5 15C11.6294 15 15 11.6294 15 7.5C15 3.37059 11.6294 0 7.5 0C3.37059 0 0 3.37059 0 7.5C0 11.6294 3.37059 15 7.5 15ZM7.5 0.705882C11.2412 0.705882 14.2941 3.75879 14.2941 7.5C14.2941 11.2412 11.2411 14.2941 7.5 14.2941C3.75892 14.2941 0.705882 11.2412 0.705882 7.5C0.705882 3.75882 3.75892 0.705882 7.5 0.705882Z" fill="#8F8F8F"/>
                                <path d="M7.81626 7.74717L7.85159 7.58825V2.55884H7.14577V7.50001L5.32812 11.1353L5.96342 11.4529L7.81626 7.74717Z" fill="#8F8F8F"/>
                            </svg>
                            Следующее поднятие через <?=$arItem['UP_TIME_LEFT']?> ч.
                        </div>
                        <div class="btn-info-update btn-info-update--table">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.5 15C11.6294 15 15 11.6294 15 7.5C15 3.37059 11.6294 0 7.5 0C3.37059 0 0 3.37059 0 7.5C0 11.6294 3.37059 15 7.5 15ZM7.5 0.705882C11.2412 0.705882 14.2941 3.75879 14.2941 7.5C14.2941 11.2412 11.2411 14.2941 7.5 14.2941C3.75892 14.2941 0.705882 11.2412 0.705882 7.5C0.705882 3.75882 3.75892 0.705882 7.5 0.705882Z" fill="#8F8F8F"/>
                                <path d="M7.81626 7.74717L7.85159 7.58825V2.55884H7.14577V7.50001L5.32812 11.1353L5.96342 11.4529L7.81626 7.74717Z" fill="#8F8F8F"/>
                            </svg>
                            Поднятие через <?=$arItem['UP_TIME_LEFT']?> ч.
                        </div>
                        <div class="btn-info-mobile">
                            <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.3583 9.71069H4.63506C4.32322 9.71069 4.06641 9.86765 4.06641 10.0351V10.9036C4.06641 11.0814 4.34156 11.2279 4.63506 11.2279H10.3583C10.6701 11.2279 10.9269 11.071 10.9269 10.9036V10.0351C10.9269 9.86765 10.6701 9.71069 10.3583 9.71069Z" fill="#37C770"/>
                                <path d="M14.2096 4.93926L7.95447 0.889811C7.73434 0.732856 7.27575 0.732856 7.03729 0.889811L0.78213 4.93926C0.562007 5.09621 0.745443 5.3578 1.13066 5.3578H4.06563V8.07836C4.06563 8.25624 4.34078 8.40274 4.63428 8.40274H10.3575C10.6693 8.40274 10.9261 8.24578 10.9261 8.07836V5.3578H13.8611C14.2647 5.3578 14.4481 5.09621 14.2096 4.93926Z" fill="#37C770"/>
                            </svg>
                            Через <?=$arItem['UP_TIME_LEFT']?> ч.
                        </div>
                        <a href="#" class="advert-btn-update">
                            <svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.0129 0.916931C6.11692 -0.41336 1.81894 1.54583 0.432621 5.28416C-0.113765 6.75845 -0.132995 8.32329 0.320596 9.7655L1.08237 7.71164L1.09663 7.71629C1.09297 7.01654 1.21035 6.31194 1.46137 5.63556C2.64573 2.44138 6.31783 0.767548 9.64693 1.90411C12.9758 3.04017 14.7205 6.5632 13.5359 9.7569C12.3978 12.8258 8.9253 14.5034 5.69704 13.5951L6.04921 12.6457L3.23346 13.2854L4.99075 15.5L5.33073 14.5835C9.12651 15.6846 13.2262 13.7204 14.5656 10.109C15.9517 6.37012 13.9103 2.24685 10.013 0.917109L10.0129 0.916931Z" fill="white"/>
                            </svg>
                            Обновить за 7,80 р.
                        </a>
                    <?php endif;?>
                    <?php if ($arItem['ACTIVE'] === 'N'): ?>
                        <a href="" class="advert-btn-post">
                            Опубликовать
                            <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.14738 0.808087C1.99486 0.89135 1.9 1.05124 1.9 1.225L1.9 9.775C1.9 9.94875 1.99486 10.1086 2.14738 10.1919C2.2999 10.2752 2.48567 10.2685 2.63188 10.1746L9.28186 5.89957C9.41782 5.81217 9.5 5.66164 9.5 5.5C9.5 5.33836 9.41782 5.18783 9.28186 5.10043L2.63188 0.825439C2.48568 0.731479 2.2999 0.724824 2.14738 0.808087Z"
                                      fill="#028F3A"/>
                                <path d="M0.949218 9.775C0.949218 10.0373 0.736561 10.25 0.474218 10.25C0.211876 10.25 -0.000781644 10.0373 -0.000781633 9.775L-0.000781259 1.225C-0.000781247 0.962667 0.211876 0.75 0.474219 0.75C0.736561 0.75 0.949219 0.962667 0.949219 1.225L0.949218 9.775Z"
                                      fill="#028F3A"/>
                            </svg>
                        </a>
                    <?php else: ?>
                        <a href="" class="advert-btn-pause">
                            На паузу
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.5 0C2.91744 0 0 2.91744 0 6.5C0 10.0826 2.91744 13 6.5 13C10.0826 13 13 10.0826 13 6.5C13 2.91744 10.0826 0 6.5 0ZM5.44186 8.76744C5.44186 9.02442 5.24535 9.22093 4.98837 9.22093C4.7314 9.22093 4.53488 9.02442 4.53488 8.76744V4.23256C4.53488 3.97558 4.7314 3.77907 4.98837 3.77907C5.24535 3.77907 5.44186 3.97558 5.44186 4.23256V8.76744ZM8.46512 8.76744C8.46512 9.02442 8.2686 9.22093 8.01163 9.22093C7.75465 9.22093 7.55814 9.02442 7.55814 8.76744V4.23256C7.55814 3.97558 7.75465 3.77907 8.01163 3.77907C8.2686 3.77907 8.46512 3.97558 8.46512 4.23256V8.76744Z"
                                      fill="#ED1C24"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
                <?php endif;?>
            </div>
            <div class="advert-data">
                <div class="advert-data__location">
                    <?= $arItem['CITY'] ?>
                </div>
                <div class="advert-data__public">
                    Опубликовано <?= $arItem['FORMAT_ACTIVE_FROM'] ?>
                </div>
                <?php if($arItem['UP_DAYS']):?>
                <div class="advert-data__day">
                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.67075 9.71069H3.94756C3.63572 9.71069 3.37891 9.86765 3.37891 10.0351V10.9036C3.37891 11.0814 3.65406 11.2279 3.94756 11.2279H9.67075C9.98259 11.2279 10.2394 11.071 10.2394 10.9036V10.0351C10.2394 9.86765 9.98259 9.71069 9.67075 9.71069Z"
                              fill="#37C770"/>
                        <path d="M13.5221 4.93926L7.26697 0.889811C7.04684 0.732856 6.58825 0.732856 6.34979 0.889811L0.0946302 4.93926C-0.125493 5.09621 0.057943 5.3578 0.443158 5.3578H3.37813V8.07836C3.37813 8.25624 3.65328 8.40274 3.94678 8.40274H9.66997C9.98181 8.40274 10.2386 8.24578 10.2386 8.07836V5.3578H13.1736C13.5772 5.3578 13.7606 5.09621 13.5221 4.93926Z"
                              fill="#37C770"/>
                    </svg>
                    Поднято: <?=$arItem['UP_DAYS']?>
                </div>
                <?php endif;?>
            </div>
            <div class="advert-stats">
                <div class="advert-stats__title">
                    <svg width="21" height="24" viewBox="0 0 21 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.7673 23.246H0V23.9499H20.7673V23.246Z" fill="#505456"/>
                        <path d="M5.56205 14.587H2.71094V23.5979H5.56205V14.587Z" fill="#505456"/>
                        <path d="M5.87926 23.95H2.35938V14.2351H5.91446V23.95H5.87926ZM3.06335 23.246H5.21048V14.9391H3.06335V23.246Z"
                              fill="#505456"/>
                        <path d="M18.3042 5.99854H15.4531V23.598H18.3042V5.99854Z" fill="#505456"/>
                        <path d="M18.6214 23.95H15.1016V5.64661H18.6566V23.95H18.6214ZM15.8055 23.246H17.9527V6.35058H15.8055V23.246Z"
                              fill="#505456"/>
                        <path d="M11.9331 11.1727H9.08203V23.5979H11.9331V11.1727Z" fill="#505456"/>
                        <path d="M12.2504 23.95H8.73047V10.8208H12.2856V23.95H12.2504ZM9.43445 23.246H11.5816V11.5248H9.43445V23.246Z"
                              fill="#505456"/>
                        <path d="M19.706 1.25313L19.3789 0.629761L0.927096 10.3131L1.25423 10.9364L19.706 1.25313Z"
                              fill="#505456"/>
                        <path d="M17.918 0.366699L19.6075 0.929881L19.0795 2.58423" fill="#505456"/>
                        <path d="M19.4316 2.68984L18.7629 2.51385L19.1501 1.14109L17.8125 0.718705L18.0237 0.0499268L20.03 0.683506L19.4316 2.68984Z"
                              fill="#505456"/>
                    </svg>
                    Статистика объявления
                </div>
                <div class="advert-stats-list">
                    <?php $allShow = (!empty($arItem['PROPERTIES']['SHOW_ALL']['VALUE'])) ? $arItem['PROPERTIES']['SHOW_ALL']['VALUE'] : 0?>
                    <?php $phoneShow = (!empty($arItem['PROPERTIES']['SHOW_PHONE']['VALUE'])) ? $arItem['PROPERTIES']['SHOW_PHONE']['VALUE'] : 0?>
                    <div class="advert-stats__item">
                        <div class="advert-stats__item__num"><?=number_format($allShow, 0, '.', ' ')?></div>
                        <div class="advert-stats__item__title"><?=getPluralForm($allShow, ['просмотр', 'просмотра', 'просмотров'])?> объявления</div>
                    </div>
                    <div class="advert-stats__item">
                        <div class="advert-stats__item__num"><?=number_format($phoneShow, 0, '.', ' ')?></div>
                        <div class="advert-stats__item__title"><?=getPluralForm($phoneShow, ['просмотр', 'просмотра', 'просмотров'])?> телефона</div>
                    </div>
                    <div class="advert-stats__item">
                        <div class="advert-stats__item__num"><?=$arItem['FAVORIT_COUNT']?></div>
                        <div class="advert-stats__item__title">пользователей добавлены в закладки</div>
                    </div>
                    <div class="advert-stats__item">
                        <div class="advert-stats__item__num"><?= $arItem['DIFF_DAYS'] ?></div>
                        <div class="advert-stats__item__title"><?= getPluralForm((int)$arItem['DIFF_DAYS'], ['день', 'дня', 'дней']) ?>
                            в продаже
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
