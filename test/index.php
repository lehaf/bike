<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Каталог");
\Bitrix\Main\Page\Asset::getInstance()->addCss('/test/block/style.css');
\Bitrix\Main\Page\Asset::getInstance()->addCss('/test/list/style.css');
\Bitrix\Main\Page\Asset::getInstance()->addCss('/test/table/style.css');

?>
    <div class="inner_wrapper">
        <div class="item-cnt" data-count="2"></div>
        <!--'start_frame_cache_viewtype-block'-->
        <div class="ajax_load cur block" data-code="block">

            <!-- items-container -->
            <div class="js_wrapper_items load-offer-js"
                 data-params="YTo0Nzp7czoxMzoiQUxUX1RJVExFX0dFVCI7czo2OiJOT1JNQUwiO3M6MTE6IlNIT1dfQUJTRU5UIjtOO3M6MjU6IkhJREVfTk9UX0FWQUlMQUJMRV9PRkZFUlMiO3M6MToiTiI7czoxMDoiUFJJQ0VfQ09ERSI7YToxOntpOjA7czo0OiJCQVNFIjt9czoxNjoiT0ZGRVJfVFJFRV9QUk9QUyI7YTowOnt9czoxMDoiQ0FDSEVfVElNRSI7aTozNjAwMDAwO3M6MTY6IkNPTlZFUlRfQ1VSUkVOQ1kiO3M6MToiWSI7czoxMToiQ1VSUkVOQ1lfSUQiO3M6MzoiUlVCIjtzOjE3OiJPRkZFUlNfU09SVF9GSUVMRCI7czo0OiJzb3J0IjtzOjE3OiJPRkZFUlNfU09SVF9PUkRFUiI7czozOiJhc2MiO3M6MTg6Ik9GRkVSU19TT1JUX0ZJRUxEMiI7czo0OiJzb3J0IjtzOjE4OiJPRkZFUlNfU09SVF9PUkRFUjIiO3M6MzoiYXNjIjtzOjE3OiJMSVNUX09GRkVSU19MSU1JVCI7aTowO3M6MTI6IkNBQ0hFX0dST1VQUyI7czoxOiJZIjtzOjI1OiJMSVNUX09GRkVSU19QUk9QRVJUWV9DT0RFIjthOjg6e2k6MDtzOjk6IkNPTE9SX1JFRiI7aToxO3M6NToiU0laRVMiO2k6MjtzOjY6IlZPTFVNRSI7aTozO3M6NjoiV0VJR0hUIjtpOjQ7czo2OiJTSVpFUzIiO2k6NTtzOjY6IlNJWkVTMyI7aTo2O3M6NjoiU0laRVM0IjtpOjc7czo2OiJTSVpFUzUiO31zOjE4OiJTSE9XX0RJU0NPVU5UX1RJTUUiO3M6MToiWSI7czoxNzoiU0hPV19DT1VOVEVSX0xJU1QiO3M6MToiWSI7czoxNzoiUFJJQ0VfVkFUX0lOQ0xVREUiO2I6MTtzOjE1OiJVU0VfUFJJQ0VfQ09VTlQiO2I6MDtzOjEyOiJTSE9XX01FQVNVUkUiO3M6MToiWSI7czoxNDoiU0hPV19PTERfUFJJQ0UiO3M6MToiWSI7czoyMToiU0hPV19ESVNDT1VOVF9QRVJDRU5UIjtzOjE6IlkiO3M6Mjg6IlNIT1dfRElTQ09VTlRfUEVSQ0VOVF9OVU1CRVIiO3M6MToiWSI7czoxMDoiVVNFX1JFR0lPTiI7czoxOiJOIjtzOjY6IlNUT1JFUyI7YTowOnt9czoxMzoiREVGQVVMVF9DT1VOVCI7czoxOiIxIjtzOjEwOiJCQVNLRVRfVVJMIjtzOjg6Ii9iYXNrZXQvIjtzOjIyOiJPRkZFUlNfQ0FSVF9QUk9QRVJUSUVTIjthOjg6e2k6MDtzOjk6IkNPTE9SX1JFRiI7aToxO3M6NToiU0laRVMiO2k6MjtzOjY6IlZPTFVNRSI7aTozO3M6NjoiV0VJR0hUIjtpOjQ7czo2OiJTSVpFUzIiO2k6NTtzOjY6IlNJWkVTMyI7aTo2O3M6NjoiU0laRVM0IjtpOjc7czo2OiJTSVpFUzUiO31zOjE4OiJQUk9EVUNUX1BST1BFUlRJRVMiO3M6MDoiIjtzOjI2OiJQQVJUSUFMX1BST0RVQ1RfUFJPUEVSVElFUyI7czoxOiJOIjtzOjI0OiJBRERfUFJPUEVSVElFU19UT19CQVNLRVQiO3M6MToiWSI7czoyNzoiU0hPV19ESVNDT1VOVF9USU1FX0VBQ0hfU0tVIjtzOjE6Ik4iO3M6MTY6IlNIT1dfQVJUSUNMRV9TS1UiO3M6MToiWSI7czoxOToiT0ZGRVJfQUREX1BJQ1RfUFJPUCI7czoxMDoiTU9SRV9QSE9UTyI7czoyNToiUFJPRFVDVF9RVUFOVElUWV9WQVJJQUJMRSI7czo4OiJxdWFudGl0eSI7czoxODoiU0hPV19PTkVfQ0xJQ0tfQlVZIjtzOjE6IlkiO3M6MTU6IkRJU1BMQVlfQ09NUEFSRSI7czoxOiJZIjtzOjIwOiJESVNQTEFZX1dJU0hfQlVUVE9OUyI7czoxOiJZIjtzOjE3OiJNQVhfR0FMTEVSWV9JVEVNUyI7czoxOiI1IjtzOjEyOiJTSE9XX0dBTExFUlkiO3M6MToiWSI7czoxMDoiU0hPV19QUk9QUyI7czoxOiJOIjtzOjE2OiJTSE9XX1BPUFVQX1BSSUNFIjtzOjE6IlkiO3M6MTM6IkFERF9QSUNUX1BST1AiO3M6MTA6Ik1PUkVfUEhPVE8iO3M6MjA6IkFERF9ERVRBSUxfVE9fU0xJREVSIjtzOjE6IlkiO3M6MTk6IklCSU5IRVJJVF9URU1QTEFURVMiO2E6MDp7fXM6MTY6IklCTE9DS19JRF9QQVJFTlQiO2k6MjY7czo5OiJJQkxPQ0tfSUQiO2k6Mjg7fQ==.cc26f4f6c6195ccf63b0d55b893d8b7ce6348f46aad5291e36ba7647a00cc2b2">
                <div class="top_wrapper items_wrapper catalog_block_template ">
                    <div class="fast_view_params" data-params=""></div>
                    <div class="catalog_block items row  margin0  js_append ajax_load block flexbox">


                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 col-xxs-12 item item-parent catalog-block-view__item js-notice-block item_block  "
                             data-id="39685" data-product_type="1">
                            <div class="basket_props_block" id="bx_basket_div_39685_block" style="display: none;">
                            </div>
                            <div class="catalog_item_wrapp catalog_item item_wrap main_item_wrapper  product_image "
                                 id="bx_3966226736_39685">
                                <div class="inner_wrap TYPE_1">
                                    <div class="image_wrapper_block js-notice-block__image ">
                                        <div class="like_icons block" data-size="3">
                                            <div class="wish_item_button item-action">
                                                <span title="В избранное" data-title="В избранное"
                                                      data-title_added="В избранном" data-quantity="1"
                                                      class="wish_item to rounded3 colored_theme_hover_bg js-item-action"
                                                      data-action="favorite" data-item="39685" data-iblock="26"><i
                                                            class="svg inline  svg-inline-wish ncolor colored"
                                                            aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="13"
                                                                                    viewBox="0 0 16 13"><defs><style>.clsw-1 {fill: #fff;fill-rule: evenodd;}</style></defs><path
                                                                    class="clsw-1"
                                                                    d="M506.755,141.6l0,0.019s-4.185,3.734-5.556,4.973a0.376,0.376,0,0,1-.076.056,1.838,1.838,0,0,1-1.126.357,1.794,1.794,0,0,1-1.166-.4,0.473,0.473,0,0,1-.1-0.076c-1.427-1.287-5.459-4.878-5.459-4.878l0-.019A4.494,4.494,0,1,1,500,135.7,4.492,4.492,0,1,1,506.755,141.6Zm-3.251-5.61A2.565,2.565,0,0,0,501,138h0a1,1,0,1,1-2,0h0a2.565,2.565,0,0,0-2.506-2,2.5,2.5,0,0,0-1.777,4.264l-0.013.019L500,145.1l5.179-4.749c0.042-.039.086-0.075,0.126-0.117l0.052-.047-0.006-.008A2.494,2.494,0,0,0,503.5,135.993Z"
                                                                    transform="translate(-492 -134)"></path></svg></i></span>
                                            </div>
                                            <div class="compare_item_button">
                                                <span title="Сравнить"
                                                      class="compare_item to rounded3 colored_theme_hover_bg"
                                                      data-iblock="26" data-item="39685"><i
                                                            class="svg inline  svg-inline-compare ncolor colored"
                                                            aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="14" height="13"
                                                                                    viewBox="0 0 14 13"><path
                                                                    data-name="Rounded Rectangle 913 copy" class="cls-1"
                                                                    d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                                    transform="translate(-590 -134)"></path></svg></i></span>
                                                <span title="В сравнении"
                                                      class="compare_item in added rounded3 colored_theme_bg"
                                                      style="display: none;" data-iblock="26" data-item="39685"><i
                                                            class="svg inline  svg-inline-compare ncolor colored"
                                                            aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="14" height="13"
                                                                                    viewBox="0 0 14 13"><path
                                                                    data-name="Rounded Rectangle 913 copy" class="cls-1"
                                                                    d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                                    transform="translate(-590 -134)"></path></svg></i></span>
                                            </div>
                                            <div class="wrapp_one_click">
																													<span class="rounded3 colored_theme_hover_bg one_click"
                                                                                                                          data-item="39685"
                                                                                                                          data-iblockid="26"
                                                                                                                          data-quantity="1"
                                                                                                                          onclick="oneClickBuy('39685', '26', this)"
                                                                                                                          title="Купить в 1 клик">
																					<i class="svg inline  svg-inline-fw ncolor colored"
                                                                                       aria-hidden="true"><svg
                                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                                width="18" height="16"
                                                                                                viewBox="0 0 18 16"><path
                                                                                                    data-name="Rounded Rectangle 941 copy 2"
                                                                                                    class="cls-1"
                                                                                                    d="M653,148H643a2,2,0,0,1-2-2v-3h2v3h10v-7h-1v2a1,1,0,1,1-2,0v-2H638a1,1,0,1,1,0-2h6v-1a4,4,0,0,1,8,0v1h1a2,2,0,0,1,2,2v7A2,2,0,0,1,653,148Zm-3-12a2,2,0,0,0-4,0v1h4v-1Zm-10,4h5a1,1,0,0,1,0,2h-5A1,1,0,0,1,640,140Z"
                                                                                                    transform="translate(-637 -132)"></path></svg></i>										</span>
                                            </div>
                                            <div class="fast_view_button">
                                                <span title="Быстрый просмотр" class="rounded3 colored_theme_hover_bg"
                                                      data-event="jqm" data-param-form_id="fast_view"
                                                      data-param-iblock_id="26" data-param-id="39685"
                                                      data-param-item_href="%2Fcatalog%2Fmototrasport2%2Fsnow%2Fbaltmotors%2Fsnowdog%2F39685%2F"
                                                      data-name="fast_view"><i
                                                            class="svg inline  svg-inline-fw ncolor colored"
                                                            aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="12"
                                                                                    viewBox="0 0 16 12"><path
                                                                    data-name="Ellipse 302 copy 3" class="cls-1"
                                                                    d="M549,146a8.546,8.546,0,0,1-8.008-6,8.344,8.344,0,0,1,16.016,0A8.547,8.547,0,0,1,549,146Zm0-2a6.591,6.591,0,0,0,5.967-4,7.022,7.022,0,0,0-1.141-1.76,4.977,4.977,0,0,1-9.652,0,7.053,7.053,0,0,0-1.142,1.76A6.591,6.591,0,0,0,549,144Zm-2.958-7.246c-0.007.084-.042,0.159-0.042,0.246a3,3,0,1,0,6,0c0-.087-0.035-0.162-0.042-0.246A6.179,6.179,0,0,0,546.042,136.753Z"
                                                                    transform="translate(-541 -134)"></path></svg></i></span>
                                            </div>
                                        </div>
                                        <a href="/catalog/mototrasport2/snow/baltmotors/snowdog/39685/" class="thumb">
							<span class="section-gallery-wrapper flexbox">
																										<span class="section-gallery-wrapper__item _active">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/bd7/xjm37emzoxn2rm34dfu5kknji10o27n5.jpg"
                                             data-src="/upload/iblock/bd7/xjm37emzoxn2rm34dfu5kknji10o27n5.jpg"
                                             alt="Снегоход Baltmotors Snowdog" title="Снегоход Baltmotors Snowdog">
									</span>
																										<span class="section-gallery-wrapper__item">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/e75/o64es30fdcs3k5je3yzct9yg221tj2rv.jpg"
                                             data-src="/upload/iblock/e75/o64es30fdcs3k5je3yzct9yg221tj2rv.jpg"
                                             alt="Снегоход Baltmotors Snowdog" title="Снегоход Baltmotors Snowdog">
									</span>
																										<span class="section-gallery-wrapper__item">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/fc0/1ef8srdqi6bh3gq29fuimthtd78fgvcu.jpg"
                                             data-src="/upload/iblock/fc0/1ef8srdqi6bh3gq29fuimthtd78fgvcu.jpg"
                                             alt="Снегоход Baltmotors Snowdog" title="Снегоход Baltmotors Snowdog">
									</span>
																										<span class="section-gallery-wrapper__item">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/c8c/t5clp9u1rxbk4ire1tfcs0jksbnt75il.jpg"
                                             data-src="/upload/iblock/c8c/t5clp9u1rxbk4ire1tfcs0jksbnt75il.jpg"
                                             alt="Снегоход Baltmotors Snowdog" title="Снегоход Baltmotors Snowdog">
									</span>
																										<span class="section-gallery-wrapper__item">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/7ee/j9xmawew4fj5q9hobqysdgf6dy9g9g92.jpg"
                                             data-src="/upload/iblock/7ee/j9xmawew4fj5q9hobqysdgf6dy9g9g92.jpg"
                                             alt="Снегоход Baltmotors Snowdog" title="Снегоход Baltmotors Snowdog">
									</span>
															</span>
                                        </a>
                                    </div>
                                    <div class="item_info">
                                        <div class="item_info--top_block">
                                            <div class="item-title">
                                                <a href="/catalog/mototrasport2/snow/baltmotors/snowdog/39685/"
                                                   class="dark_link js-notice-block__title option-font-bold"><span>Снегоход Baltmotors Snowdog</span></a>
                                            </div>
                                        </div>
                                        <div class="item_info_product">
                                            2009, 14 690 км.
                                        </div>
                                        <div class="item_info--bottom_block">
                                            <div class="cost prices clearfix" style="height: 24px;">
                                                <div class="price_matrix_wrapper prices-row">
                                                    <div class="price font-bold font_mxs" data-currency="RUB"
                                                         data-value="185826.2">
                                                        <span class="values_wrapper"><span class="price_value">185&nbsp;826.20</span><span
                                                                    class="price_currency"> ₽</span></span></div>
                                                    <div class="price-dollar">
                                                        ≈ 1800 $
                                                    </div>
                                                </div>
                                                <div class="js-info-block rounded3">
                                                    <div class="block_title text-upper font_xs font-bold">
                                                        Варианты цен <i class="svg inline  svg-inline-close"
                                                                        aria-hidden="true">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                 height="16" viewBox="0 0 16 16">
                                                                <path data-name="Rounded Rectangle 114 copy 3"
                                                                      class="cccls-1"
                                                                      d="M334.411,138l6.3,6.3a1,1,0,0,1,0,1.414,0.992,0.992,0,0,1-1.408,0l-6.3-6.306-6.3,6.306a1,1,0,0,1-1.409-1.414l6.3-6.3-6.293-6.3a1,1,0,0,1,1.409-1.414l6.3,6.3,6.3-6.3A1,1,0,0,1,340.7,131.7Z"
                                                                      transform="translate(-325 -130)"></path>
                                                            </svg>
                                                        </i></div>
                                                    <div class="block_wrap">
                                                        <div class="block_wrap_inner prices ">
                                                            <div class="price_matrix_wrapper prices-row">
                                                                <div class="price font-bold font_mxs"
                                                                     data-currency="RUB" data-value="185826.2">
                                                                    <span class="values_wrapper"><span
                                                                                class="price_value">185&nbsp;826.20</span><span
                                                                                class="price_currency"> ₽</span></span>
                                                                </div>
                                                                <div class="price-dollar">
                                                                    ≈ 1800 $
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="more-btn text-center">
                                                            <a href="" class="font_upper colored_theme_hover_bg">Подробности</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 col-xxs-12 item item-parent catalog-block-view__item js-notice-block item_block  "
                             data-id="39684" data-product_type="1">
                            <div class="basket_props_block" id="bx_basket_div_39684_block" style="display: none;">
                            </div>
                            <div class="catalog_item_wrapp catalog_item item_wrap main_item_wrapper  product_image "
                                 id="bx_3966226736_39684">
                                <div class="inner_wrap TYPE_1">
                                    <div class="image_wrapper_block js-notice-block__image ">
                                        <div class="like_icons block" data-size="2">
                                            <div class="wish_item_button item-action">
                                                <span title="В избранное" data-title="В избранное"
                                                      data-title_added="В избранном" data-quantity="1"
                                                      class="wish_item to rounded3 colored_theme_hover_bg js-item-action"
                                                      data-action="favorite" data-item="39684" data-iblock="26"><i
                                                            class="svg inline  svg-inline-wish ncolor colored"
                                                            aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="13"
                                                                                    viewBox="0 0 16 13"><defs><style>.clsw-1 {fill: #fff;fill-rule: evenodd;}</style></defs><path
                                                                    class="clsw-1"
                                                                    d="M506.755,141.6l0,0.019s-4.185,3.734-5.556,4.973a0.376,0.376,0,0,1-.076.056,1.838,1.838,0,0,1-1.126.357,1.794,1.794,0,0,1-1.166-.4,0.473,0.473,0,0,1-.1-0.076c-1.427-1.287-5.459-4.878-5.459-4.878l0-.019A4.494,4.494,0,1,1,500,135.7,4.492,4.492,0,1,1,506.755,141.6Zm-3.251-5.61A2.565,2.565,0,0,0,501,138h0a1,1,0,1,1-2,0h0a2.565,2.565,0,0,0-2.506-2,2.5,2.5,0,0,0-1.777,4.264l-0.013.019L500,145.1l5.179-4.749c0.042-.039.086-0.075,0.126-0.117l0.052-.047-0.006-.008A2.494,2.494,0,0,0,503.5,135.993Z"
                                                                    transform="translate(-492 -134)"></path></svg></i></span>
                                            </div>
                                            <div class="compare_item_button">
                                                <span title="Сравнить"
                                                      class="compare_item to rounded3 colored_theme_hover_bg"
                                                      data-iblock="26" data-item="39684"><i
                                                            class="svg inline  svg-inline-compare ncolor colored"
                                                            aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="14" height="13"
                                                                                    viewBox="0 0 14 13"><path
                                                                    data-name="Rounded Rectangle 913 copy" class="cls-1"
                                                                    d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                                    transform="translate(-590 -134)"></path></svg></i></span>
                                                <span title="В сравнении"
                                                      class="compare_item in added rounded3 colored_theme_bg"
                                                      style="display: none;" data-iblock="26" data-item="39684"><i
                                                            class="svg inline  svg-inline-compare ncolor colored"
                                                            aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="14" height="13"
                                                                                    viewBox="0 0 14 13"><path
                                                                    data-name="Rounded Rectangle 913 copy" class="cls-1"
                                                                    d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                                    transform="translate(-590 -134)"></path></svg></i></span>
                                            </div>
                                            <div class="wrapp_one_click">
                                            </div>
                                            <div class="fast_view_button">
                                                <span title="Быстрый просмотр" class="rounded3 colored_theme_hover_bg"
                                                      data-event="jqm" data-param-form_id="fast_view"
                                                      data-param-iblock_id="26" data-param-id="39684"
                                                      data-param-item_href="%2Fcatalog%2Fmototrasport2%2Fsnow%2Fbaltmotors%2Fbarboss%2F39684%2F"
                                                      data-name="fast_view"><i
                                                            class="svg inline  svg-inline-fw ncolor colored"
                                                            aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="12"
                                                                                    viewBox="0 0 16 12"><path
                                                                    data-name="Ellipse 302 copy 3" class="cls-1"
                                                                    d="M549,146a8.546,8.546,0,0,1-8.008-6,8.344,8.344,0,0,1,16.016,0A8.547,8.547,0,0,1,549,146Zm0-2a6.591,6.591,0,0,0,5.967-4,7.022,7.022,0,0,0-1.141-1.76,4.977,4.977,0,0,1-9.652,0,7.053,7.053,0,0,0-1.142,1.76A6.591,6.591,0,0,0,549,144Zm-2.958-7.246c-0.007.084-.042,0.159-0.042,0.246a3,3,0,1,0,6,0c0-.087-0.035-0.162-0.042-0.246A6.179,6.179,0,0,0,546.042,136.753Z"
                                                                    transform="translate(-541 -134)"></path></svg></i></span>
                                            </div>
                                        </div>
                                        <a href="/catalog/mototrasport2/snow/baltmotors/barboss/39684/" class="thumb">
							<span class="section-gallery-wrapper flexbox">
																										<span class="section-gallery-wrapper__item _active">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/df6/b86oxgnjdgycaumnrctyk1onqwn15smg.jpg"
                                             data-src="/upload/iblock/df6/b86oxgnjdgycaumnrctyk1onqwn15smg.jpg"
                                             alt="Снегоход Baltmotors Barboss" title="Снегоход Baltmotors Barboss">
									</span>
																										<span class="section-gallery-wrapper__item">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/827/ei5fdr6znvmlsa1ne0gnhdeekdyhjlkw.jpg"
                                             data-src="/upload/iblock/827/ei5fdr6znvmlsa1ne0gnhdeekdyhjlkw.jpg"
                                             alt="Снегоход Baltmotors Barboss" title="Снегоход Baltmotors Barboss">
									</span>
																										<span class="section-gallery-wrapper__item">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/69e/n5zxaij60bnsmqgxtkxhswtbubwrt2sx.jpg"
                                             data-src="/upload/iblock/69e/n5zxaij60bnsmqgxtkxhswtbubwrt2sx.jpg"
                                             alt="Снегоход Baltmotors Barboss" title="Снегоход Baltmotors Barboss">
									</span>
																										<span class="section-gallery-wrapper__item">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/02d/5bxdju3qz49e3dtdleq2fw5rnzkvlygy.jpg"
                                             data-src="/upload/iblock/02d/5bxdju3qz49e3dtdleq2fw5rnzkvlygy.jpg"
                                             alt="Снегоход Baltmotors Barboss" title="Снегоход Baltmotors Barboss">
									</span>
																										<span class="section-gallery-wrapper__item">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/0d2/yccv0qy0ddrqiefv3v52fjj064uecvzv.jpg"
                                             data-src="/upload/iblock/0d2/yccv0qy0ddrqiefv3v52fjj064uecvzv.jpg"
                                             alt="Снегоход Baltmotors Barboss" title="Снегоход Baltmotors Barboss">
									</span>
															</span>
                                        </a>
                                    </div>
                                    <div class="item_info">
                                        <div class="item_info--top_block">
                                            <div class="item-title">
                                                <a href="/catalog/mototrasport2/snow/baltmotors/barboss/39684/"
                                                   class="dark_link js-notice-block__title option-font-bold"><span>Снегоход Baltmotors Barboss</span></a>
                                            </div>
                                        </div>
                                        <div class="item_info_row">
                                            <div data-click="N" class="item-stock " data-id="39685">
                                                <span
                                                        class="icon stock"></span><span
                                                        class="value font_sxs">В наличии</span>
                                            </div>
                                            <div class="article_block" data-name="Арт." data-value="36473928">
                                                <div>Арт: 36473928</div>
                                            </div>
                                        </div>
                                        <div class="item_info--bottom_block">
                                            <div class="cost prices clearfix" style="height: 24px;">
                                                <div class="price_matrix_wrapper prices-row">
                                                    <div class="price font-bold font_mxs" data-currency="RUB"
                                                         data-value="157232.6">
                                                        <span class="values_wrapper"><span class="price_value">157&nbsp;232.60</span><span
                                                                    class="price_currency"> ₽</span></span></div>
                                                    <div class="price-dollar">
                                                        ≈ 1800 $
                                                    </div>
                                                </div>
                                                <div class="js-info-block rounded3">
                                                    <div class="block_title text-upper font_xs font-bold">
                                                        Варианты цен <i class="svg inline  svg-inline-close"
                                                                        aria-hidden="true">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                 height="16" viewBox="0 0 16 16">
                                                                <path data-name="Rounded Rectangle 114 copy 3"
                                                                      class="cccls-1"
                                                                      d="M334.411,138l6.3,6.3a1,1,0,0,1,0,1.414,0.992,0.992,0,0,1-1.408,0l-6.3-6.306-6.3,6.306a1,1,0,0,1-1.409-1.414l6.3-6.3-6.293-6.3a1,1,0,0,1,1.409-1.414l6.3,6.3,6.3-6.3A1,1,0,0,1,340.7,131.7Z"
                                                                      transform="translate(-325 -130)"></path>
                                                            </svg>
                                                        </i></div>
                                                    <div class="block_wrap">
                                                        <div class="block_wrap_inner prices ">
                                                            <div class="price_matrix_wrapper prices-row">
                                                                <div class="price font-bold font_mxs"
                                                                     data-currency="RUB" data-value="157232.6">
                                                                    <span class="values_wrapper"><span
                                                                                class="price_value">157&nbsp;232.60</span><span
                                                                                class="price_currency"> ₽</span></span>
                                                                </div>
                                                                <div class="price-dollar">
                                                                    ≈ 1800 $
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="more-btn text-center">
                                                            <a href="" class="font_upper colored_theme_hover_bg">Подробности</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <script>typeof useOfferSelect === 'function' && useOfferSelect()</script>
                        <!-- items-container -->
                    </div>
                </div>
            </div>

            <div class="bottom_nav animate-load-state block-type" data-all_count="2" data-parent=".tabs_slider"
                 data-append=".items">
            </div>

            <script>
                // lazyLoadPagenBlock();
                sliceItemBlock();
            </script>

            <script>
                BX.Currency.setCurrencies([{
                    'CURRENCY': 'RUB',
                    'FORMAT': {
                        'FORMAT_STRING': '# &#8381;',
                        'DEC_POINT': '.',
                        'THOUSANDS_SEP': '&nbsp;',
                        'DECIMALS': 2,
                        'THOUSANDS_VARIANT': 'B',
                        'HIDE_ZERO': 'Y'
                    }
                }]);
            </script>
            <script>typeof useCountdown === 'function' && useCountdown()</script>

            <!--noindex-->
            <script class="smart-filter-filter" data-skip-moving="true">
                var filter = {"SECTION_ID": "10559"}                                            </script>
            <script class="smart-filter-sort" data-skip-moving="true">
                var filter = {"SHOWS": "asc", "sort": "asc"}                        </script>
            <!--/noindex-->
        </div>
        <!--'end_frame_cache_viewtype-block'-->

        <div class="clear"></div>

        <div class="hidden ajax_breadcrumb">
            <div class="breadcrumbs swipeignore" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                <div class="breadcrumbs__item" id="bx_breadcrumb_0" itemprop="itemListElement" itemscope=""
                     itemtype="http://schema.org/ListItem"><a class="breadcrumbs__link" href="/" title="Главная"
                                                              itemprop="item"><span itemprop="name"
                                                                                    class="breadcrumbs__item-name font_xs">Главная</span>
                        <meta itemprop="position" content="1">
                    </a></div>
                <span class="breadcrumbs__separator">—</span>
                <div class="breadcrumbs__item" id="bx_breadcrumb_1" itemprop="itemListElement" itemscope=""
                     itemtype="http://schema.org/ListItem"><a class="breadcrumbs__link" href="/catalog/" title="Каталог"
                                                              itemprop="item"><span itemprop="name"
                                                                                    class="breadcrumbs__item-name font_xs">Каталог</span>
                        <meta itemprop="position" content="2">
                    </a></div>
                <span class="breadcrumbs__separator">—</span>
                <div class="breadcrumbs__item breadcrumbs__item--with-dropdown colored_theme_hover_bg-block"
                     id="bx_breadcrumb_2" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a class="breadcrumbs__link colored_theme_hover_bg-el-svg" href="/catalog/mototrasport2/"
                       itemprop="item"><span itemprop="name"
                                             class="breadcrumbs__item-name font_xs">МотоТраспорт</span><span
                                class="breadcrumbs__arrow-down colored_theme_hover_bg-el-svg"><i
                                    class="svg inline  svg-inline-arrow" aria-hidden="true"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="5" height="3" viewBox="0 0 5 3"><path
                                            class="cls-1" d="M250,80h5l-2.5,3Z" transform="translate(-250 -80)"></path></svg></i></span>
                        <meta itemprop="position" content="3">
                    </a>
                    <div class="breadcrumbs__dropdown-wrapper">
                        <div class="breadcrumbs__dropdown rounded3"><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs" href="/catalog/zapchasti/">Запчасти</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs" href="/catalog/moto_tovary/">Мото
                                товары</a><a class="breadcrumbs__dropdown-item dark_link font_xs"
                                             href="/catalog/shiny/">Шины</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs" href="/catalog/motouslugi/">Мотоуслуги</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/garazhi/">Гаражи</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/odezhda/">Одежда</a></div>
                    </div>
                </div>
                <span class="breadcrumbs__separator">—</span>
                <div class="breadcrumbs__item breadcrumbs__item--with-dropdown colored_theme_hover_bg-block"
                     id="bx_breadcrumb_3" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a class="breadcrumbs__link colored_theme_hover_bg-el-svg" href="/catalog/mototrasport2/snow/"
                       itemprop="item"><span itemprop="name"
                                             class="breadcrumbs__item-name font_xs">Снегоходы</span><span
                                class="breadcrumbs__arrow-down colored_theme_hover_bg-el-svg"><i
                                    class="svg inline  svg-inline-arrow" aria-hidden="true"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="5" height="3" viewBox="0 0 5 3"><path
                                            class="cls-1" d="M250,80h5l-2.5,3Z" transform="translate(-250 -80)"></path></svg></i></span>
                        <meta itemprop="position" content="4">
                    </a>
                    <div class="breadcrumbs__dropdown-wrapper">
                        <div class="breadcrumbs__dropdown rounded3"><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/bike/">Мотоциклы</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/scooter/"> Скутеры / мопеды</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/atv/">Квадроциклы</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/karting/">Картинг</a></div>
                    </div>
                </div>
                <span class="breadcrumbs__separator">—</span>
                <div class="breadcrumbs__item breadcrumbs__item--with-dropdown colored_theme_hover_bg-block cat_last"
                     id="bx_breadcrumb_4" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <link href="/catalog/mototrasport2/snow/baltmotors/" itemprop="item">
                    <span><span itemprop="name" class="breadcrumbs__item-name font_xs">Baltmotors</span><span
                                class="breadcrumbs__arrow-down "><i class="svg inline  svg-inline-arrow"
                                                                    aria-hidden="true"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="5" height="3" viewBox="0 0 5 3"><path
                                            class="cls-1" d="M250,80h5l-2.5,3Z" transform="translate(-250 -80)"></path></svg></i></span><meta
                                itemprop="position" content="5"></span>
                    <div class="breadcrumbs__dropdown-wrapper">
                        <div class="breadcrumbs__dropdown rounded3"><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/russkaya_mekhanika/">Русская Механика</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/avm/">АВМ</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/bars/">Барс</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/bts/">БТС</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/zid/">ЗиД</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/izhtekhmash/">ИжТехМаш</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/itlan/">Итлан</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/mvp/">МВП</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/minsk/">Минск</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/pelets/">Пелец</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/yamaha/">Yamaha</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/szpi/">СЗПИ</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/shikhan/">Шихан</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/eksklyuziv/">Эксклюзив</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/irbis/">Irbis</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/arctic_cat/">Arctic Cat</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/armada/">Armada</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/bombardier/">Bombardier</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/brait/">Brait</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/cronus/">Cronus</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/forza/">Forza</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/ice_deer/">ICE DEER</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/alpina/">Alpina</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/motoland/">Motoland</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/pegas/">Pegas</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/polaris/">Polaris</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/ski_doo/">Ski-Doo</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/snow_bot/">Snow-bot</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/stels/">Stels</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/wels/">Wels</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/woideal/">Woideal</a></div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            BX.removeCustomEvent("onAjaxSuccessFilter", function tt(e) {
            });
            BX.addCustomEvent("onAjaxSuccessFilter", function tt(e) {
                var arAjaxPageData = {'TITLE': 'Baltmotors', 'WINDOW_TITLE': 'Baltmotors'};
                if ($('.element-count-wrapper .element-count').length) {
                    //$('.element-count-wrapper .element-count').text($('.js_append').closest('.ajax_load.cur').find('.bottom_nav').attr('data-all_count'));
                    var cntFromNav = $('.js_append').closest('.ajax_load.cur').find('.bottom_nav').attr('data-all_count');
                    if (cntFromNav) {
                        $('.element-count-wrapper .element-count').text(cntFromNav);
                    } else {
                        $('.element-count-wrapper .element-count').text($('.js_append > div.item:not(.flexbox)').length)
                    }
                }
                if (arAjaxPageData.TITLE)
                    BX.ajax.UpdatePageTitle(arAjaxPageData.TITLE);
                if (arAjaxPageData.WINDOW_TITLE || arAjaxPageData.TITLE)
                    BX.ajax.UpdateWindowTitle(arAjaxPageData.WINDOW_TITLE || arAjaxPageData.TITLE);
                var ajaxBreadCrumb = $('.ajax_breadcrumb .breadcrumbs');
                if (ajaxBreadCrumb.length) {
                    $('#navigation').html(ajaxBreadCrumb);
                    $('.ajax_breadcrumb').remove();
                }

            });
        </script>
    </div>

    <div class="inner_wrapper">
        <div class="item-cnt" data-count="2"></div>
        <!--'start_frame_cache_viewtype-block'-->
        <div class="ajax_load cur list" data-code="list">
            <div class="js_wrapper_items load-offer-js"
                 data-params="YTo0Nzp7czoxMzoiQUxUX1RJVExFX0dFVCI7czo2OiJOT1JNQUwiO3M6MTE6IlNIT1dfQUJTRU5UIjtOO3M6MjU6IkhJREVfTk9UX0FWQUlMQUJMRV9PRkZFUlMiO3M6MToiTiI7czoxMDoiUFJJQ0VfQ09ERSI7YToxOntpOjA7czo0OiJCQVNFIjt9czoxNjoiT0ZGRVJfVFJFRV9QUk9QUyI7YTowOnt9czoxMDoiQ0FDSEVfVElNRSI7aTozNjAwMDAwO3M6MTY6IkNPTlZFUlRfQ1VSUkVOQ1kiO3M6MToiWSI7czoxMToiQ1VSUkVOQ1lfSUQiO3M6MzoiUlVCIjtzOjE3OiJPRkZFUlNfU09SVF9GSUVMRCI7czo0OiJzb3J0IjtzOjE3OiJPRkZFUlNfU09SVF9PUkRFUiI7czozOiJhc2MiO3M6MTg6Ik9GRkVSU19TT1JUX0ZJRUxEMiI7czo0OiJzb3J0IjtzOjE4OiJPRkZFUlNfU09SVF9PUkRFUjIiO3M6MzoiYXNjIjtzOjE3OiJMSVNUX09GRkVSU19MSU1JVCI7aTowO3M6MTI6IkNBQ0hFX0dST1VQUyI7czoxOiJZIjtzOjI1OiJMSVNUX09GRkVSU19QUk9QRVJUWV9DT0RFIjthOjg6e2k6MDtzOjk6IkNPTE9SX1JFRiI7aToxO3M6NToiU0laRVMiO2k6MjtzOjY6IlZPTFVNRSI7aTozO3M6NjoiV0VJR0hUIjtpOjQ7czo2OiJTSVpFUzIiO2k6NTtzOjY6IlNJWkVTMyI7aTo2O3M6NjoiU0laRVM0IjtpOjc7czo2OiJTSVpFUzUiO31zOjE4OiJTSE9XX0RJU0NPVU5UX1RJTUUiO3M6MToiWSI7czoxNzoiU0hPV19DT1VOVEVSX0xJU1QiO3M6MToiWSI7czoxNzoiUFJJQ0VfVkFUX0lOQ0xVREUiO2I6MTtzOjE1OiJVU0VfUFJJQ0VfQ09VTlQiO2I6MDtzOjEyOiJTSE9XX01FQVNVUkUiO3M6MToiWSI7czoxNDoiU0hPV19PTERfUFJJQ0UiO3M6MToiWSI7czoyMToiU0hPV19ESVNDT1VOVF9QRVJDRU5UIjtzOjE6IlkiO3M6Mjg6IlNIT1dfRElTQ09VTlRfUEVSQ0VOVF9OVU1CRVIiO3M6MToiWSI7czoxMDoiVVNFX1JFR0lPTiI7czoxOiJOIjtzOjY6IlNUT1JFUyI7YTowOnt9czoxMzoiREVGQVVMVF9DT1VOVCI7czoxOiIxIjtzOjEwOiJCQVNLRVRfVVJMIjtzOjg6Ii9iYXNrZXQvIjtzOjIyOiJPRkZFUlNfQ0FSVF9QUk9QRVJUSUVTIjthOjg6e2k6MDtzOjk6IkNPTE9SX1JFRiI7aToxO3M6NToiU0laRVMiO2k6MjtzOjY6IlZPTFVNRSI7aTozO3M6NjoiV0VJR0hUIjtpOjQ7czo2OiJTSVpFUzIiO2k6NTtzOjY6IlNJWkVTMyI7aTo2O3M6NjoiU0laRVM0IjtpOjc7czo2OiJTSVpFUzUiO31zOjE4OiJQUk9EVUNUX1BST1BFUlRJRVMiO3M6MDoiIjtzOjI2OiJQQVJUSUFMX1BST0RVQ1RfUFJPUEVSVElFUyI7czoxOiJOIjtzOjI0OiJBRERfUFJPUEVSVElFU19UT19CQVNLRVQiO3M6MToiWSI7czoyNzoiU0hPV19ESVNDT1VOVF9USU1FX0VBQ0hfU0tVIjtzOjE6Ik4iO3M6MTY6IlNIT1dfQVJUSUNMRV9TS1UiO3M6MToiWSI7czoxOToiT0ZGRVJfQUREX1BJQ1RfUFJPUCI7czoxMDoiTU9SRV9QSE9UTyI7czoyNToiUFJPRFVDVF9RVUFOVElUWV9WQVJJQUJMRSI7czo4OiJxdWFudGl0eSI7czoxODoiU0hPV19PTkVfQ0xJQ0tfQlVZIjtzOjE6IlkiO3M6MTU6IkRJU1BMQVlfQ09NUEFSRSI7czoxOiJZIjtzOjIwOiJESVNQTEFZX1dJU0hfQlVUVE9OUyI7czoxOiJZIjtzOjE3OiJNQVhfR0FMTEVSWV9JVEVNUyI7czoxOiI1IjtzOjEyOiJTSE9XX0dBTExFUlkiO3M6MToiWSI7czoxMDoiU0hPV19QUk9QUyI7czoxOiJOIjtzOjE2OiJTSE9XX1BPUFVQX1BSSUNFIjtzOjE6IlkiO3M6MTM6IkFERF9QSUNUX1BST1AiO3M6MTA6Ik1PUkVfUEhPVE8iO3M6MjA6IkFERF9ERVRBSUxfVE9fU0xJREVSIjtzOjE6IlkiO3M6MTk6IklCSU5IRVJJVF9URU1QTEFURVMiO2E6MDp7fXM6MTY6IklCTE9DS19JRF9QQVJFTlQiO2k6MjY7czo5OiJJQkxPQ0tfSUQiO2k6Mjg7fQ==.cc26f4f6c6195ccf63b0d55b893d8b7ce6348f46aad5291e36ba7647a00cc2b2">
                <div class="display_list show_un_props js_append TYPE_1  flexbox flexbox--row">
                    <div class="list_item_wrapp item_wrap item item-parent clearfix bordered box-shadow js-notice-block">
                        <div class="list_item item_info catalog-adaptive flexbox flexbox--row "
                             id="bx_3966226736_39685">
                            <div class="image_block">
                                <div class="image_wrapper_block js-notice-block__image">
                                    <a href="/catalog/mototrasport2/snow/baltmotors/snowdog/39685/" class="thumb">
							<span class="section-gallery-wrapper flexbox">
																										<span class="section-gallery-wrapper__item _active">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/bd7/xjm37emzoxn2rm34dfu5kknji10o27n5.jpg"
                                             data-src="/upload/iblock/bd7/xjm37emzoxn2rm34dfu5kknji10o27n5.jpg"
                                             alt="Снегоход Baltmotors Snowdog" title="Снегоход Baltmotors Snowdog">
									</span>
																										<span class="section-gallery-wrapper__item">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/e75/o64es30fdcs3k5je3yzct9yg221tj2rv.jpg"
                                             data-src="/upload/iblock/e75/o64es30fdcs3k5je3yzct9yg221tj2rv.jpg"
                                             alt="Снегоход Baltmotors Snowdog" title="Снегоход Baltmotors Snowdog">
									</span>
																										<span class="section-gallery-wrapper__item">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/fc0/1ef8srdqi6bh3gq29fuimthtd78fgvcu.jpg"
                                             data-src="/upload/iblock/fc0/1ef8srdqi6bh3gq29fuimthtd78fgvcu.jpg"
                                             alt="Снегоход Baltmotors Snowdog" title="Снегоход Baltmotors Snowdog">
									</span>
																										<span class="section-gallery-wrapper__item">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/c8c/t5clp9u1rxbk4ire1tfcs0jksbnt75il.jpg"
                                             data-src="/upload/iblock/c8c/t5clp9u1rxbk4ire1tfcs0jksbnt75il.jpg"
                                             alt="Снегоход Baltmotors Snowdog" title="Снегоход Baltmotors Snowdog">
									</span>
																										<span class="section-gallery-wrapper__item">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/7ee/j9xmawew4fj5q9hobqysdgf6dy9g9g92.jpg"
                                             data-src="/upload/iblock/7ee/j9xmawew4fj5q9hobqysdgf6dy9g9g92.jpg"
                                             alt="Снегоход Baltmotors Snowdog" title="Снегоход Baltmotors Snowdog">
									</span>
															</span>
                                    </a>
                                </div>
                                <div class="adaptive">
                                    <div class="like_icons block" data-size="3">
                                        <div class="wish_item_button item-action">
                                            <span title="В избранное" data-title="В избранное"
                                                  data-title_added="В избранном" data-quantity="1"
                                                  class="wish_item to rounded3 colored_theme_hover_bg js-item-action"
                                                  data-action="favorite" data-item="39685" data-iblock="26"><i
                                                        class="svg inline  svg-inline-wish ncolor colored"
                                                        aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="16" height="13"
                                                                                viewBox="0 0 16 13"><defs><style>.clsw-1 {fill: #fff;fill-rule: evenodd;}</style></defs><path
                                                                class="clsw-1"
                                                                d="M506.755,141.6l0,0.019s-4.185,3.734-5.556,4.973a0.376,0.376,0,0,1-.076.056,1.838,1.838,0,0,1-1.126.357,1.794,1.794,0,0,1-1.166-.4,0.473,0.473,0,0,1-.1-0.076c-1.427-1.287-5.459-4.878-5.459-4.878l0-.019A4.494,4.494,0,1,1,500,135.7,4.492,4.492,0,1,1,506.755,141.6Zm-3.251-5.61A2.565,2.565,0,0,0,501,138h0a1,1,0,1,1-2,0h0a2.565,2.565,0,0,0-2.506-2,2.5,2.5,0,0,0-1.777,4.264l-0.013.019L500,145.1l5.179-4.749c0.042-.039.086-0.075,0.126-0.117l0.052-.047-0.006-.008A2.494,2.494,0,0,0,503.5,135.993Z"
                                                                transform="translate(-492 -134)"></path></svg></i></span>
                                        </div>
                                        <div class="compare_item_button">
                                            <span title="Сравнить"
                                                  class="compare_item to rounded3 colored_theme_hover_bg"
                                                  data-iblock="26" data-item="39685"><i
                                                        class="svg inline  svg-inline-compare ncolor colored"
                                                        aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="14" height="13"
                                                                                viewBox="0 0 14 13"><path
                                                                data-name="Rounded Rectangle 913 copy" class="cls-1"
                                                                d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                                transform="translate(-590 -134)"></path></svg></i></span>
                                            <span title="В сравнении"
                                                  class="compare_item in added rounded3 colored_theme_bg"
                                                  style="display: none;" data-iblock="26" data-item="39685"><i
                                                        class="svg inline  svg-inline-compare ncolor colored"
                                                        aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="14" height="13"
                                                                                viewBox="0 0 14 13"><path
                                                                data-name="Rounded Rectangle 913 copy" class="cls-1"
                                                                d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                                transform="translate(-590 -134)"></path></svg></i></span>
                                        </div>
                                        <div class="wrapp_one_click">
																													<span class="rounded3 colored_theme_hover_bg one_click"
                                                                                                                          data-item="39685"
                                                                                                                          data-iblockid="26"
                                                                                                                          data-quantity="1"
                                                                                                                          onclick="oneClickBuy('39685', '26', this)"
                                                                                                                          title="Купить в 1 клик">
																					<i class="svg inline  svg-inline-fw ncolor colored"
                                                                                       aria-hidden="true"><svg
                                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                                width="18" height="16"
                                                                                                viewBox="0 0 18 16"><path
                                                                                                    data-name="Rounded Rectangle 941 copy 2"
                                                                                                    class="cls-1"
                                                                                                    d="M653,148H643a2,2,0,0,1-2-2v-3h2v3h10v-7h-1v2a1,1,0,1,1-2,0v-2H638a1,1,0,1,1,0-2h6v-1a4,4,0,0,1,8,0v1h1a2,2,0,0,1,2,2v7A2,2,0,0,1,653,148Zm-3-12a2,2,0,0,0-4,0v1h4v-1Zm-10,4h5a1,1,0,0,1,0,2h-5A1,1,0,0,1,640,140Z"
                                                                                                    transform="translate(-637 -132)"></path></svg></i>										</span>
                                        </div>
                                        <div class="fast_view_button">
                                            <span title="Быстрый просмотр" class="rounded3 colored_theme_hover_bg"
                                                  data-event="jqm" data-param-form_id="fast_view"
                                                  data-param-iblock_id="26" data-param-id="39685"
                                                  data-param-item_href="%2Fcatalog%2Fmototrasport2%2Fsnow%2Fbaltmotors%2Fsnowdog%2F39685%2F"
                                                  data-name="fast_view"><i
                                                        class="svg inline  svg-inline-fw ncolor colored"
                                                        aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="16" height="12"
                                                                                viewBox="0 0 16 12"><path
                                                                data-name="Ellipse 302 copy 3" class="cls-1"
                                                                d="M549,146a8.546,8.546,0,0,1-8.008-6,8.344,8.344,0,0,1,16.016,0A8.547,8.547,0,0,1,549,146Zm0-2a6.591,6.591,0,0,0,5.967-4,7.022,7.022,0,0,0-1.141-1.76,4.977,4.977,0,0,1-9.652,0,7.053,7.053,0,0,0-1.142,1.76A6.591,6.591,0,0,0,549,144Zm-2.958-7.246c-0.007.084-.042,0.159-0.042,0.246a3,3,0,1,0,6,0c0-.087-0.035-0.162-0.042-0.246A6.179,6.179,0,0,0,546.042,136.753Z"
                                                                transform="translate(-541 -134)"></path></svg></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="description_wrapp">
                                <div class="description">
                                    <div class="item-title">
                                        <a href="/catalog/mototrasport2/snow/baltmotors/snowdog/39685/"
                                           class="dark_link js-notice-block__title"><span>Снегоход Baltmotors Snowdog</span></a>
                                    </div>
                                    <div class="props_list_wrapp" style="display: none;">
                                        <table class="props_list prod">
                                            <tbody>
                                            <tr>
                                                <td>
																<span class="char_name">
																	Тип (снегоход)																																	</span>
                                                </td>
                                                <td>
																<span>
																утилитарный																</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
																<span class="char_name">
																	чество цилиндров (снегоход)																																	</span>
                                                </td>
                                                <td>
																<span>
																1																</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="show_props">
                                        <span class="darken font_xs colored_theme_hover_text char_title"><i
                                                    class="svg  svg-inline-down" aria-hidden="true"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="8" height="5"
                                                        viewBox="0 0 8 5"><path data-name="Rounded Rectangle 890 copy 2"
                                                                                class="cls-1"
                                                                                d="M517.778,610.8a0.721,0.721,0,0,1-1.016,0L514,607.769l-2.79,3.028a0.715,0.715,0,1,1-1.01-1.011l3.273-3.552c0.009-.009.012-0.021,0.021-0.03a0.723,0.723,0,0,1,1.017,0,0.022,0.022,0,0,1,0,0l3.265,3.577A0.712,0.712,0,0,1,517.778,610.8Z"
                                                                                transform="translate(-510 -606)"></path></svg></i><span
                                                    class="">Характеристики</span></span>
                                    </div>
                                </div>
                                <div class="like_icons list" data-size="2">
                                    <div class="wish_item_button item-action">
                                        <span title="В избранное" data-title="В избранное"
                                              data-title_added="В избранном" data-quantity="1"
                                              class="wish_item to rounded3 btn btn-xs font_upper_xs btn-transparent js-item-action"
                                              data-action="favorite" data-item="39685" data-iblock="26"><i
                                                    class="svg inline  svg-inline-wish ncolor colored"
                                                    aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="16" height="13" viewBox="0 0 16 13"><defs><style>.clsw-1 {fill: #fff;fill-rule: evenodd;}</style></defs><path
                                                            class="clsw-1"
                                                            d="M506.755,141.6l0,0.019s-4.185,3.734-5.556,4.973a0.376,0.376,0,0,1-.076.056,1.838,1.838,0,0,1-1.126.357,1.794,1.794,0,0,1-1.166-.4,0.473,0.473,0,0,1-.1-0.076c-1.427-1.287-5.459-4.878-5.459-4.878l0-.019A4.494,4.494,0,1,1,500,135.7,4.492,4.492,0,1,1,506.755,141.6Zm-3.251-5.61A2.565,2.565,0,0,0,501,138h0a1,1,0,1,1-2,0h0a2.565,2.565,0,0,0-2.506-2,2.5,2.5,0,0,0-1.777,4.264l-0.013.019L500,145.1l5.179-4.749c0.042-.039.086-0.075,0.126-0.117l0.052-.047-0.006-.008A2.494,2.494,0,0,0,503.5,135.993Z"
                                                            transform="translate(-492 -134)"></path></svg></i><span
                                                    class="like-text">В избранное</span></span>
                                    </div>
                                    <div class="compare_item_button">
                                        <span title="Сравнить"
                                              class="compare_item to rounded3 btn btn-xs font_upper_xs btn-transparent"
                                              data-iblock="26" data-item="39685"><i
                                                    class="svg inline  svg-inline-compare ncolor colored"
                                                    aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="14" height="13" viewBox="0 0 14 13"><path
                                                            data-name="Rounded Rectangle 913 copy" class="cls-1"
                                                            d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                            transform="translate(-590 -134)"></path></svg></i><span
                                                    class="like-text">Сравнить</span></span>
                                        <span title="В сравнении"
                                              class="compare_item in added rounded3 btn btn-xs font_upper_xs btn-transparent"
                                              style="display: none;" data-iblock="26" data-item="39685"><i
                                                    class="svg inline  svg-inline-compare ncolor colored"
                                                    aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="14" height="13" viewBox="0 0 14 13"><path
                                                            data-name="Rounded Rectangle 913 copy" class="cls-1"
                                                            d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                            transform="translate(-590 -134)"></path></svg></i><span
                                                    class="like-text">В сравнении</span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="information_wrapp main_item_wrapper">
                                <div class="information   inner_content js_offers__39685_list">
                                    <div class="cost prices clearfix">
                                        <div class="price_matrix_wrapper ">
                                            <div class="price font-bold font_mxs" data-currency="RUB"
                                                 data-value="185826.2">
                                                <span class="values_wrapper"><span
                                                            class="price_value">185&nbsp;826.20</span><span
                                                            class="price_currency"> ₽</span></span></div>
                                        </div>
                                        <div class="js-info-block rounded3">
                                            <div class="block_title text-upper font_xs font-bold">
                                                Варианты цен <i class="svg inline  svg-inline-close" aria-hidden="true">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         viewBox="0 0 16 16">
                                                        <path data-name="Rounded Rectangle 114 copy 3" class="cccls-1"
                                                              d="M334.411,138l6.3,6.3a1,1,0,0,1,0,1.414,0.992,0.992,0,0,1-1.408,0l-6.3-6.306-6.3,6.306a1,1,0,0,1-1.409-1.414l6.3-6.3-6.293-6.3a1,1,0,0,1,1.409-1.414l6.3,6.3,6.3-6.3A1,1,0,0,1,340.7,131.7Z"
                                                              transform="translate(-325 -130)"></path>
                                                    </svg>
                                                </i></div>
                                            <div class="block_wrap">
                                                <div class="block_wrap_inner prices ">
                                                    <div class="price_matrix_wrapper ">
                                                        <div class="price font-bold font_mxs" data-currency="RUB"
                                                             data-value="185826.2">
                                                            <span class="values_wrapper"><span class="price_value">185&nbsp;826.20</span><span
                                                                        class="price_currency"> ₽</span></span></div>
                                                    </div>
                                                </div>
                                                <div class="more-btn text-center">
                                                    <a href="" class="font_upper colored_theme_hover_bg">Подробности</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="basket_props_block" id="bx_basket_div_39685" style="display: none;">
                                    </div>
                                    <div class="counter_wrapp  list clearfix">
                                        <div class="counter_block_inner">
                                            <div class="counter_block " data-item="39685">
                                                <span class="minus dark-color" id="bx_3966226736_39685_quant_down"><i
                                                            class="svg inline  svg-inline-wish ncolor colored1"
                                                            aria-hidden="true"><svg width="11" height="1"
                                                                                    viewBox="0 0 11 1"><rect width="11"
                                                                                                             height="1"
                                                                                                             rx="0.5"
                                                                                                             ry="0.5"></rect></svg></i></span>
                                                <input type="text" class="text" id="bx_3966226736_39685_quantity"
                                                       name="quantity" value="1">
                                                <span class="plus dark-color" id="bx_3966226736_39685_quant_up"><i
                                                            class="svg inline  svg-inline-wish ncolor colored1"
                                                            aria-hidden="true"><svg width="11" height="11"
                                                                                    viewBox="0 0 11 11"><path
                                                                    d="M1034.5,193H1030v4.5a0.5,0.5,0,0,1-1,0V193h-4.5a0.5,0.5,0,0,1,0-1h4.5v-4.5a0.5,0.5,0,0,1,1,0V192h4.5A0.5,0.5,0,0,1,1034.5,193Z"
                                                                    transform="translate(-1024 -187)"></path></svg></i></span>
                                            </div>
                                        </div>
                                        <div id="bx_3966226736_39685_basket_actions" class="button_block ">
                                            <!--noindex-->
                                            <span data-value="185826.2" data-currency="RUB"
                                                  class=" to-cart btn btn-default transition_bg animate-load"
                                                  data-item="39685" data-float_ratio="1" data-ratio="1"
                                                  data-bakset_div="bx_basket_div_39685" data-props=""
                                                  data-part_props="N" data-add_props="Y" data-empty_props="Y"
                                                  data-offers="N" data-iblockid="26" data-quantity="1"><i
                                                        class="svg inline  svg-inline-fw ncolor colored"
                                                        aria-hidden="true" title="В корзину"><svg class="" width="19"
                                                                                                  height="16"
                                                                                                  viewBox="0 0 19 16"><path
                                                                data-name="Ellipse 2 copy 9" class="cls-1"
                                                                d="M956.047,952.005l-0.939,1.009-11.394-.008-0.952-1-0.953-6h-2.857a0.862,0.862,0,0,1-.952-1,1.025,1.025,0,0,1,1.164-1h2.327c0.3,0,.6.006,0.6,0.006a1.208,1.208,0,0,1,1.336.918L943.817,947h12.23L957,948v1Zm-11.916-3,0.349,2h10.007l0.593-2Zm1.863,5a3,3,0,1,1-3,3A3,3,0,0,1,945.994,954.005ZM946,958a1,1,0,1,0-1-1A1,1,0,0,0,946,958Zm7.011-4a3,3,0,1,1-3,3A3,3,0,0,1,953.011,954.005ZM953,958a1,1,0,1,0-1-1A1,1,0,0,0,953,958Z"
                                                                transform="translate(-938 -944)"></path></svg></i><span>В корзину</span></span><a
                                                    rel="nofollow" href="/basket/"
                                                    class=" in-cart btn btn-default transition_bg" data-item="39685"
                                                    style="display:none;"><i
                                                        class="svg inline  svg-inline-fw ncolor colored"
                                                        aria-hidden="true" title="В корзине">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18"
                                                         viewBox="0 0 19 18">
                                                        <path data-name="Rounded Rectangle 906 copy 3" class="cls-1"
                                                              d="M1005.97,4556.22l-1.01,4.02a0.031,0.031,0,0,0-.01.02,0.87,0.87,0,0,1-.14.29,0.423,0.423,0,0,1-.05.07,0.7,0.7,0,0,1-.2.18,0.359,0.359,0,0,1-.1.07,0.656,0.656,0,0,1-.21.08,1.127,1.127,0,0,1-.18.03,0.185,0.185,0,0,1-.07.02H993c-0.03,0-.056-0.02-0.086-0.02a1.137,1.137,0,0,1-.184-0.04,0.779,0.779,0,0,1-.207-0.08c-0.031-.02-0.059-0.04-0.088-0.06a0.879,0.879,0,0,1-.223-0.22s-0.007-.01-0.011-0.01a1,1,0,0,1-.172-0.43l-1.541-6.14H988a1,1,0,1,1,0-2h3.188a0.3,0.3,0,0,1,.092.02,0.964,0.964,0,0,1,.923.76l1.561,6.22h9.447l0.82-3.25a1,1,0,0,1,1.21-.73A0.982,0.982,0,0,1,1005.97,4556.22Zm-7.267.47c0,0.01,0,.01,0,0.01a1,1,0,0,1-1.414,0l-2.016-2.03a0.982,0.982,0,0,1,0-1.4,1,1,0,0,1,1.414,0l1.305,1.31,4.3-4.3a1,1,0,0,1,1.41,0,1.008,1.008,0,0,1,0,1.42ZM995,4562a3,3,0,1,1-3,3A3,3,0,0,1,995,4562Zm0,4a1,1,0,1,0-1-1A1,1,0,0,0,995,4566Zm7-4a3,3,0,1,1-3,3A3,3,0,0,1,1002,4562Zm0,4a1,1,0,1,0-1-1A1,1,0,0,0,1002,4566Z"
                                                              transform="translate(-987 -4550)"></path>
                                                    </svg>
                                                </i><span>В корзине</span></a><span class="hidden"
                                                                                    data-js-item-name="Снегоход Baltmotors Snowdog"></span>
                                            <!--/noindex-->
                                        </div>
                                    </div>
                                    <div class="wrapp-one-click">
								<span class="btn btn-transparent-border-color btn-sm type_block transition_bg one_click"
                                      data-item="39685" data-iblockid="26" data-quantity="1"
                                      onclick="oneClickBuy('39685', '26', this)">
									<span>Купить в 1 клик</span>
								</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list_item_wrapp item_wrap item item-parent clearfix bordered box-shadow js-notice-block">
                        <div class="list_item item_info catalog-adaptive flexbox flexbox--row "
                             id="bx_3966226736_39684">
                            <div class="image_block">
                                <div class="image_wrapper_block js-notice-block__image">
                                    <a href="/catalog/mototrasport2/snow/baltmotors/barboss/39684/" class="thumb">
							<span class="section-gallery-wrapper flexbox">
																										<span class="section-gallery-wrapper__item _active">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/df6/b86oxgnjdgycaumnrctyk1onqwn15smg.jpg"
                                             data-src="/upload/iblock/df6/b86oxgnjdgycaumnrctyk1onqwn15smg.jpg"
                                             alt="Снегоход Baltmotors Barboss" title="Снегоход Baltmotors Barboss">
									</span>
																										<span class="section-gallery-wrapper__item">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/827/ei5fdr6znvmlsa1ne0gnhdeekdyhjlkw.jpg"
                                             data-src="/upload/iblock/827/ei5fdr6znvmlsa1ne0gnhdeekdyhjlkw.jpg"
                                             alt="Снегоход Baltmotors Barboss" title="Снегоход Baltmotors Barboss">
									</span>
																										<span class="section-gallery-wrapper__item">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/69e/n5zxaij60bnsmqgxtkxhswtbubwrt2sx.jpg"
                                             data-src="/upload/iblock/69e/n5zxaij60bnsmqgxtkxhswtbubwrt2sx.jpg"
                                             alt="Снегоход Baltmotors Barboss" title="Снегоход Baltmotors Barboss">
									</span>
																										<span class="section-gallery-wrapper__item">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/02d/5bxdju3qz49e3dtdleq2fw5rnzkvlygy.jpg"
                                             data-src="/upload/iblock/02d/5bxdju3qz49e3dtdleq2fw5rnzkvlygy.jpg"
                                             alt="Снегоход Baltmotors Barboss" title="Снегоход Baltmotors Barboss">
									</span>
																										<span class="section-gallery-wrapper__item">
										<span class="section-gallery-wrapper__item-nav "></span>
										<img data-lazyload="" class="img-responsive lazyloaded"
                                             src="/upload/iblock/0d2/yccv0qy0ddrqiefv3v52fjj064uecvzv.jpg"
                                             data-src="/upload/iblock/0d2/yccv0qy0ddrqiefv3v52fjj064uecvzv.jpg"
                                             alt="Снегоход Baltmotors Barboss" title="Снегоход Baltmotors Barboss">
									</span>
															</span>
                                    </a>
                                </div>
                                <div class="fast_view_block rounded2 btn btn-xs font_upper_xs btn-transparent"
                                     data-event="jqm" data-param-form_id="fast_view" data-param-iblock_id="26"
                                     data-param-id="39684"
                                     data-param-item_href="%2Fcatalog%2Fmototrasport2%2Fsnow%2Fbaltmotors%2Fbarboss%2F39684%2F"
                                     data-name="fast_view">
                                    <i class="svg  svg-inline-fw ncolor" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12"
                                             viewBox="0 0 16 12">
                                            <path data-name="Ellipse 302 copy 4" class="cls-1"
                                                  d="M666,241a8.546,8.546,0,0,1-8.008-6,8.344,8.344,0,0,1,16.016,0A8.547,8.547,0,0,1,666,241Zm0-2a6.591,6.591,0,0,0,5.967-4,7.04,7.04,0,0,0-1.141-1.76,4.977,4.977,0,0,1-9.652,0,7.072,7.072,0,0,0-1.142,1.76A6.591,6.591,0,0,0,666,239Zm-2.958-7.246c-0.007.085-.042,0.16-0.042,0.246a3,3,0,1,0,6,0c0-.086-0.035-0.161-0.042-0.245A6.176,6.176,0,0,0,663.042,231.753Z"
                                                  transform="translate(-658 -229)"></path>
                                        </svg>
                                    </i>Быстрый просмотр
                                </div>
                                <div class="adaptive">
                                    <div class="like_icons block" data-size="2">
                                        <div class="wish_item_button item-action">
                                            <span title="В избранное" data-title="В избранное"
                                                  data-title_added="В избранном" data-quantity="1"
                                                  class="wish_item to rounded3 colored_theme_hover_bg js-item-action"
                                                  data-action="favorite" data-item="39684" data-iblock="26"><i
                                                        class="svg inline  svg-inline-wish ncolor colored"
                                                        aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="16" height="13"
                                                                                viewBox="0 0 16 13"><defs><style>.clsw-1 {fill: #fff;fill-rule: evenodd;}</style></defs><path
                                                                class="clsw-1"
                                                                d="M506.755,141.6l0,0.019s-4.185,3.734-5.556,4.973a0.376,0.376,0,0,1-.076.056,1.838,1.838,0,0,1-1.126.357,1.794,1.794,0,0,1-1.166-.4,0.473,0.473,0,0,1-.1-0.076c-1.427-1.287-5.459-4.878-5.459-4.878l0-.019A4.494,4.494,0,1,1,500,135.7,4.492,4.492,0,1,1,506.755,141.6Zm-3.251-5.61A2.565,2.565,0,0,0,501,138h0a1,1,0,1,1-2,0h0a2.565,2.565,0,0,0-2.506-2,2.5,2.5,0,0,0-1.777,4.264l-0.013.019L500,145.1l5.179-4.749c0.042-.039.086-0.075,0.126-0.117l0.052-.047-0.006-.008A2.494,2.494,0,0,0,503.5,135.993Z"
                                                                transform="translate(-492 -134)"></path></svg></i></span>
                                        </div>
                                        <div class="compare_item_button">
                                            <span title="Сравнить"
                                                  class="compare_item to rounded3 colored_theme_hover_bg"
                                                  data-iblock="26" data-item="39684"><i
                                                        class="svg inline  svg-inline-compare ncolor colored"
                                                        aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="14" height="13"
                                                                                viewBox="0 0 14 13"><path
                                                                data-name="Rounded Rectangle 913 copy" class="cls-1"
                                                                d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                                transform="translate(-590 -134)"></path></svg></i></span>
                                            <span title="В сравнении"
                                                  class="compare_item in added rounded3 colored_theme_bg"
                                                  style="display: none;" data-iblock="26" data-item="39684"><i
                                                        class="svg inline  svg-inline-compare ncolor colored"
                                                        aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="14" height="13"
                                                                                viewBox="0 0 14 13"><path
                                                                data-name="Rounded Rectangle 913 copy" class="cls-1"
                                                                d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                                transform="translate(-590 -134)"></path></svg></i></span>
                                        </div>
                                        <div class="wrapp_one_click">
                                        </div>
                                        <div class="fast_view_button">
                                            <span title="Быстрый просмотр" class="rounded3 colored_theme_hover_bg"
                                                  data-event="jqm" data-param-form_id="fast_view"
                                                  data-param-iblock_id="26" data-param-id="39684"
                                                  data-param-item_href="%2Fcatalog%2Fmototrasport2%2Fsnow%2Fbaltmotors%2Fbarboss%2F39684%2F"
                                                  data-name="fast_view"><i
                                                        class="svg inline  svg-inline-fw ncolor colored"
                                                        aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="16" height="12"
                                                                                viewBox="0 0 16 12"><path
                                                                data-name="Ellipse 302 copy 3" class="cls-1"
                                                                d="M549,146a8.546,8.546,0,0,1-8.008-6,8.344,8.344,0,0,1,16.016,0A8.547,8.547,0,0,1,549,146Zm0-2a6.591,6.591,0,0,0,5.967-4,7.022,7.022,0,0,0-1.141-1.76,4.977,4.977,0,0,1-9.652,0,7.053,7.053,0,0,0-1.142,1.76A6.591,6.591,0,0,0,549,144Zm-2.958-7.246c-0.007.084-.042,0.159-0.042,0.246a3,3,0,1,0,6,0c0-.087-0.035-0.162-0.042-0.246A6.179,6.179,0,0,0,546.042,136.753Z"
                                                                transform="translate(-541 -134)"></path></svg></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="description_wrapp">
                                <div class="description">
                                    <div class="item-title">
                                        <a href="/catalog/mototrasport2/snow/baltmotors/barboss/39684/"
                                           class="dark_link js-notice-block__title"><span>Снегоход Baltmotors Barboss</span></a>
                                    </div>
                                    <div class="props_list_wrapp">
                                        <table class="props_list prod">
                                            <tbody>
                                            <tr>
                                                <td>
																<span class="char_name">
																	Тип (снегоход)																																	</span>
                                                </td>
                                                <td>
																<span>
																утилитарный																</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
																<span class="char_name">
																	чество цилиндров (снегоход)																																	</span>
                                                </td>
                                                <td>
																<span>
																1																</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="show_props">
                                        <span class="darken font_xs colored_theme_hover_text char_title"><i
                                                    class="svg  svg-inline-down" aria-hidden="true"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="8" height="5"
                                                        viewBox="0 0 8 5"><path data-name="Rounded Rectangle 890 copy 2"
                                                                                class="cls-1"
                                                                                d="M517.778,610.8a0.721,0.721,0,0,1-1.016,0L514,607.769l-2.79,3.028a0.715,0.715,0,1,1-1.01-1.011l3.273-3.552c0.009-.009.012-0.021,0.021-0.03a0.723,0.723,0,0,1,1.017,0,0.022,0.022,0,0,1,0,0l3.265,3.577A0.712,0.712,0,0,1,517.778,610.8Z"
                                                                                transform="translate(-510 -606)"></path></svg></i><span
                                                    class="">Характеристики</span></span>
                                    </div>
                                </div>
                                <div class="like_icons list" data-size="2">
                                    <div class="wish_item_button item-action">
                                        <span title="В избранное" data-title="В избранное"
                                              data-title_added="В избранном" data-quantity="1"
                                              class="wish_item to rounded3 btn btn-xs font_upper_xs btn-transparent js-item-action"
                                              data-action="favorite" data-item="39684" data-iblock="26"><i
                                                    class="svg inline  svg-inline-wish ncolor colored"
                                                    aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="16" height="13" viewBox="0 0 16 13"><defs><style>.clsw-1 {fill: #fff;fill-rule: evenodd;}</style></defs><path
                                                            class="clsw-1"
                                                            d="M506.755,141.6l0,0.019s-4.185,3.734-5.556,4.973a0.376,0.376,0,0,1-.076.056,1.838,1.838,0,0,1-1.126.357,1.794,1.794,0,0,1-1.166-.4,0.473,0.473,0,0,1-.1-0.076c-1.427-1.287-5.459-4.878-5.459-4.878l0-.019A4.494,4.494,0,1,1,500,135.7,4.492,4.492,0,1,1,506.755,141.6Zm-3.251-5.61A2.565,2.565,0,0,0,501,138h0a1,1,0,1,1-2,0h0a2.565,2.565,0,0,0-2.506-2,2.5,2.5,0,0,0-1.777,4.264l-0.013.019L500,145.1l5.179-4.749c0.042-.039.086-0.075,0.126-0.117l0.052-.047-0.006-.008A2.494,2.494,0,0,0,503.5,135.993Z"
                                                            transform="translate(-492 -134)"></path></svg></i><span
                                                    class="like-text">В избранное</span></span>
                                    </div>
                                    <div class="compare_item_button">
                                        <span title="Сравнить"
                                              class="compare_item to rounded3 btn btn-xs font_upper_xs btn-transparent"
                                              data-iblock="26" data-item="39684"><i
                                                    class="svg inline  svg-inline-compare ncolor colored"
                                                    aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="14" height="13" viewBox="0 0 14 13"><path
                                                            data-name="Rounded Rectangle 913 copy" class="cls-1"
                                                            d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                            transform="translate(-590 -134)"></path></svg></i><span
                                                    class="like-text">Сравнить</span></span>
                                        <span title="В сравнении"
                                              class="compare_item in added rounded3 btn btn-xs font_upper_xs btn-transparent"
                                              style="display: none;" data-iblock="26" data-item="39684"><i
                                                    class="svg inline  svg-inline-compare ncolor colored"
                                                    aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="14" height="13" viewBox="0 0 14 13"><path
                                                            data-name="Rounded Rectangle 913 copy" class="cls-1"
                                                            d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                            transform="translate(-590 -134)"></path></svg></i><span
                                                    class="like-text">В сравнении</span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="information_wrapp main_item_wrapper">
                                <div class="information   inner_content js_offers__39684_list">
                                    <div class="cost prices clearfix">
                                        <div class="price_matrix_wrapper ">
                                            <div class="price font-bold font_mxs" data-currency="RUB"
                                                 data-value="157232.6">
                                                <span class="values_wrapper"><span
                                                            class="price_value">157&nbsp;232.60</span><span
                                                            class="price_currency"> ₽</span></span></div>
                                            <div class="price-dollar">
                                                ≈ 1800 $
                                            </div>
                                        </div>
                                        <div class="js-info-block rounded3">
                                            <div class="block_title text-upper font_xs font-bold">
                                                Варианты цен <i class="svg inline  svg-inline-close" aria-hidden="true">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         viewBox="0 0 16 16">
                                                        <path data-name="Rounded Rectangle 114 copy 3" class="cccls-1"
                                                              d="M334.411,138l6.3,6.3a1,1,0,0,1,0,1.414,0.992,0.992,0,0,1-1.408,0l-6.3-6.306-6.3,6.306a1,1,0,0,1-1.409-1.414l6.3-6.3-6.293-6.3a1,1,0,0,1,1.409-1.414l6.3,6.3,6.3-6.3A1,1,0,0,1,340.7,131.7Z"
                                                              transform="translate(-325 -130)"></path>
                                                    </svg>
                                                </i></div>
                                            <div class="block_wrap">
                                                <div class="block_wrap_inner prices ">
                                                    <div class="price_matrix_wrapper ">
                                                        <div class="price font-bold font_mxs" data-currency="RUB"
                                                             data-value="157232.6">
                                                            <span class="values_wrapper"><span class="price_value">157&nbsp;232.60</span><span
                                                                        class="price_currency"> ₽</span></span></div>
                                                    </div>
                                                </div>
                                                <div class="more-btn text-center">
                                                    <a href="" class="font_upper colored_theme_hover_bg">Подробности</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="basket_props_block" id="bx_basket_div_39684" style="display: none;">
                                    </div>
                                    <div class="counter_wrapp  list clearfix">
                                        <div id="bx_3966226736_39684_basket_actions" class="button_block wide">
                                            <!--noindex-->
                                            <span class=" to-order btn btn-default animate-load" data-event="jqm"
                                                  data-param-form_id="TOORDER" data-name="toorder"
                                                  data-autoload-product_name="Снегоход Baltmotors Barboss"
                                                  data-autoload-product_id="39684"><i
                                                        class="svg inline  svg-inline-fw ncolor colored"
                                                        aria-hidden="true" title="Под заказ"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="18" height="14"
                                                            viewBox="0 0 18 14"><path
                                                                data-name="Rounded Rectangle 1055 copy 4"
                                                                class="mailcls-1"
                                                                d="M903,3845H891a3,3,0,0,1-3-3v-8a3,3,0,0,1,3-3h12a3,3,0,0,1,3,3v8A3,3,0,0,1,903,3845Zm-12-2h12a0.969,0.969,0,0,0,.475-0.14l-3.844-3.86-1.821,1.59c-0.021.03-.03,0.06-0.054,0.09a1.1,1.1,0,0,1-1.512,0c-0.024-.03-0.033-0.06-0.054-0.09l-1.821-1.59-3.844,3.86A0.969,0.969,0,0,0,891,3843Zm-1-2.44,2.861-2.88-2.861-2.5v5.38Zm13-7.56H891a1.037,1.037,0,0,0-.354.07l6.354,5.56,6.354-5.56A1.037,1.037,0,0,0,903,3833Zm1,2.18-2.861,2.5,2.861,2.88v-5.38Z"
                                                                transform="translate(-888 -3831)"></path></svg></i><span>Под заказ</span></span>
                                            <div class="more_text">Наши менеджеры обязательно свяжутся с вами и уточнят
                                                условия заказа
                                            </div>
                                            <span class="hidden" data-js-item-name="Снегоход Baltmotors Barboss"></span>
                                            <!--/noindex-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="bottom_nav list" data-all_count="2">
            </div>
            <script>typeof useOfferSelect === 'function' && useOfferSelect()</script>
            <script>
                BX.message({
                    QUANTITY_AVAILIABLE: 'Есть в наличии',
                    QUANTITY_NOT_AVAILIABLE: 'Нет в наличии',
                    ADD_ERROR_BASKET: 'Ошибка добавления товара в корзину',
                    ADD_ERROR_COMPARE: 'Ошибка добавления товара в список сравнения',
                })
            </script>
            <script>
                BX.Currency.setCurrencies([{
                    'CURRENCY': 'RUB',
                    'FORMAT': {
                        'FORMAT_STRING': '# &#8381;',
                        'DEC_POINT': '.',
                        'THOUSANDS_SEP': '&nbsp;',
                        'DECIMALS': 2,
                        'THOUSANDS_VARIANT': 'B',
                        'HIDE_ZERO': 'Y'
                    }
                }]);
            </script>
            <script>typeof useCountdown === 'function' && useCountdown()</script>

            <!--noindex-->
            <script class="smart-filter-filter" data-skip-moving="true">
                var filter = {"SECTION_ID": "10559"}                                            </script>
            <script class="smart-filter-sort" data-skip-moving="true">
                var filter = {"SHOWS": "asc", "sort": "asc"}                        </script>
            <!--/noindex-->
        </div>
        <!--'end_frame_cache_viewtype-block'-->

        <div class="clear"></div>

        <div class="hidden ajax_breadcrumb">
            <div class="breadcrumbs swipeignore" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                <div class="breadcrumbs__item" id="bx_breadcrumb_0" itemprop="itemListElement" itemscope=""
                     itemtype="http://schema.org/ListItem"><a class="breadcrumbs__link" href="/" title="Главная"
                                                              itemprop="item"><span itemprop="name"
                                                                                    class="breadcrumbs__item-name font_xs">Главная</span>
                        <meta itemprop="position" content="1">
                    </a></div>
                <span class="breadcrumbs__separator">—</span>
                <div class="breadcrumbs__item" id="bx_breadcrumb_1" itemprop="itemListElement" itemscope=""
                     itemtype="http://schema.org/ListItem"><a class="breadcrumbs__link" href="/catalog/" title="Каталог"
                                                              itemprop="item"><span itemprop="name"
                                                                                    class="breadcrumbs__item-name font_xs">Каталог</span>
                        <meta itemprop="position" content="2">
                    </a></div>
                <span class="breadcrumbs__separator">—</span>
                <div class="breadcrumbs__item breadcrumbs__item--with-dropdown colored_theme_hover_bg-block"
                     id="bx_breadcrumb_2" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a class="breadcrumbs__link colored_theme_hover_bg-el-svg" href="/catalog/mototrasport2/"
                       itemprop="item"><span itemprop="name"
                                             class="breadcrumbs__item-name font_xs">МотоТраспорт</span><span
                                class="breadcrumbs__arrow-down colored_theme_hover_bg-el-svg"><i
                                    class="svg inline  svg-inline-arrow" aria-hidden="true"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="5" height="3" viewBox="0 0 5 3"><path
                                            class="cls-1" d="M250,80h5l-2.5,3Z" transform="translate(-250 -80)"></path></svg></i></span>
                        <meta itemprop="position" content="3">
                    </a>
                    <div class="breadcrumbs__dropdown-wrapper">
                        <div class="breadcrumbs__dropdown rounded3"><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs" href="/catalog/zapchasti/">Запчасти</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs" href="/catalog/moto_tovary/">Мото
                                товары</a><a class="breadcrumbs__dropdown-item dark_link font_xs"
                                             href="/catalog/shiny/">Шины</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs" href="/catalog/motouslugi/">Мотоуслуги</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/garazhi/">Гаражи</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/odezhda/">Одежда</a></div>
                    </div>
                </div>
                <span class="breadcrumbs__separator">—</span>
                <div class="breadcrumbs__item breadcrumbs__item--with-dropdown colored_theme_hover_bg-block"
                     id="bx_breadcrumb_3" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a class="breadcrumbs__link colored_theme_hover_bg-el-svg" href="/catalog/mototrasport2/snow/"
                       itemprop="item"><span itemprop="name"
                                             class="breadcrumbs__item-name font_xs">Снегоходы</span><span
                                class="breadcrumbs__arrow-down colored_theme_hover_bg-el-svg"><i
                                    class="svg inline  svg-inline-arrow" aria-hidden="true"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="5" height="3" viewBox="0 0 5 3"><path
                                            class="cls-1" d="M250,80h5l-2.5,3Z" transform="translate(-250 -80)"></path></svg></i></span>
                        <meta itemprop="position" content="4">
                    </a>
                    <div class="breadcrumbs__dropdown-wrapper">
                        <div class="breadcrumbs__dropdown rounded3"><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/bike/">Мотоциклы</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/scooter/"> Скутеры / мопеды</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/atv/">Квадроциклы</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/karting/">Картинг</a></div>
                    </div>
                </div>
                <span class="breadcrumbs__separator">—</span>
                <div class="breadcrumbs__item breadcrumbs__item--with-dropdown colored_theme_hover_bg-block cat_last"
                     id="bx_breadcrumb_4" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <link href="/catalog/mototrasport2/snow/baltmotors/" itemprop="item">
                    <span><span itemprop="name" class="breadcrumbs__item-name font_xs">Baltmotors</span><span
                                class="breadcrumbs__arrow-down "><i class="svg inline  svg-inline-arrow"
                                                                    aria-hidden="true"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="5" height="3" viewBox="0 0 5 3"><path
                                            class="cls-1" d="M250,80h5l-2.5,3Z" transform="translate(-250 -80)"></path></svg></i></span><meta
                                itemprop="position" content="5"></span>
                    <div class="breadcrumbs__dropdown-wrapper">
                        <div class="breadcrumbs__dropdown rounded3"><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/russkaya_mekhanika/">Русская Механика</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/avm/">АВМ</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/bars/">Барс</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/bts/">БТС</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/zid/">ЗиД</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/izhtekhmash/">ИжТехМаш</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/itlan/">Итлан</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/mvp/">МВП</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/minsk/">Минск</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/pelets/">Пелец</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/yamaha/">Yamaha</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/szpi/">СЗПИ</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/shikhan/">Шихан</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/eksklyuziv/">Эксклюзив</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/irbis/">Irbis</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/arctic_cat/">Arctic Cat</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/armada/">Armada</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/bombardier/">Bombardier</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/brait/">Brait</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/cronus/">Cronus</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/forza/">Forza</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/ice_deer/">ICE DEER</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/alpina/">Alpina</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/motoland/">Motoland</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/pegas/">Pegas</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/polaris/">Polaris</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/ski_doo/">Ski-Doo</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/snow_bot/">Snow-bot</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/stels/">Stels</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/wels/">Wels</a><a
                                    class="breadcrumbs__dropdown-item dark_link font_xs"
                                    href="/catalog/mototrasport2/snow/woideal/">Woideal</a></div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            BX.removeCustomEvent("onAjaxSuccessFilter", function tt(e) {
            });
            BX.addCustomEvent("onAjaxSuccessFilter", function tt(e) {
                var arAjaxPageData = {'TITLE': 'Baltmotors', 'WINDOW_TITLE': 'Baltmotors'};
                if ($('.element-count-wrapper .element-count').length) {
                    //$('.element-count-wrapper .element-count').text($('.js_append').closest('.ajax_load.cur').find('.bottom_nav').attr('data-all_count'));
                    var cntFromNav = $('.js_append').closest('.ajax_load.cur').find('.bottom_nav').attr('data-all_count');
                    if (cntFromNav) {
                        $('.element-count-wrapper .element-count').text(cntFromNav);
                    } else {
                        $('.element-count-wrapper .element-count').text($('.js_append > div.item:not(.flexbox)').length)
                    }
                }
                if (arAjaxPageData.TITLE)
                    BX.ajax.UpdatePageTitle(arAjaxPageData.TITLE);
                if (arAjaxPageData.WINDOW_TITLE || arAjaxPageData.TITLE)
                    BX.ajax.UpdateWindowTitle(arAjaxPageData.WINDOW_TITLE || arAjaxPageData.TITLE);
                var ajaxBreadCrumb = $('.ajax_breadcrumb .breadcrumbs');
                if (ajaxBreadCrumb.length) {
                    $('#navigation').html(ajaxBreadCrumb);
                    $('.ajax_breadcrumb').remove();
                }

            });
        </script>
    </div>

    <div class="inner_wrapper">
        <div class="item-cnt" data-count="2"></div>
        <!--'start_frame_cache_viewtype-block'-->
        <div class="ajax_load cur table" data-code="table">
            <div class="table-view-outer  table-view-offer-tree ">
                <div class="flexbox flexbox--row align-items-center justify-content-between flex-wrap product-info-headnote opt-buy ">
                    <div class="col-auto">
                        <div class="product-info-headnote__inner">
                            <div class="product-info-headnote__check">
                                <div class="filter label_block">
                                    <input type="checkbox" name="select_all_items" id="select_all_items" value="Y">
                                    <label for="select_all_items">Выбрать все</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="product-info-headnote__inner">
                            <div class="product-info-headnote__buy">
                                <span data-value="2500" data-currency="RUB"
                                      class="opt_action btn btn-default btn-sm no-action" data-action="buy"
                                      data-iblock_id="26"><span>В корзину</span></span>
                            </div>
                            <div class="product-info-headnote__toolbar">
                                <div class="like_icons list static icons long table-icons" data-size="2">
                                    <div class="wish_item_button">
												<span title="В избранное"
                                                      class="opt_action rounded3 btn btn-xs font_upper_xs btn-transparent no-action"
                                                      data-action="favorite" data-iblock_id="26">
													<i class="svg  svg-inline-op" aria-hidden="true"><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="13" viewBox="0 0 16 13"><defs><style>.clsw-1 {fill: #fff;fill-rule: evenodd;}</style></defs><path
                                                                    class="clsw-1"
                                                                    d="M506.755,141.6l0,0.019s-4.185,3.734-5.556,4.973a0.376,0.376,0,0,1-.076.056,1.838,1.838,0,0,1-1.126.357,1.794,1.794,0,0,1-1.166-.4,0.473,0.473,0,0,1-.1-0.076c-1.427-1.287-5.459-4.878-5.459-4.878l0-.019A4.494,4.494,0,1,1,500,135.7,4.492,4.492,0,1,1,506.755,141.6Zm-3.251-5.61A2.565,2.565,0,0,0,501,138h0a1,1,0,1,1-2,0h0a2.565,2.565,0,0,0-2.506-2,2.5,2.5,0,0,0-1.777,4.264l-0.013.019L500,145.1l5.179-4.749c0.042-.039.086-0.075,0.126-0.117l0.052-.047-0.006-.008A2.494,2.494,0,0,0,503.5,135.993Z"
                                                                    transform="translate(-492 -134)"></path></svg></i>												</span>
                                    </div>
                                    <div class="compare_item_button">
												<span title="Сравнить"
                                                      class="opt_action rounded3 btn btn-xs font_upper_xs btn-transparent no-action"
                                                      data-action="compare" data-iblock_id="26">
													<i class="svg  svg-inline-op" aria-hidden="true"><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="14"
                                                                height="13" viewBox="0 0 14 13"><path
                                                                    data-name="Rounded Rectangle 913 copy" class="cls-1"
                                                                    d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                                    transform="translate(-590 -134)"></path></svg></i>												</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="js_wrapper_items load-offer-js"
                     data-params="YTo0Nzp7czoxMzoiQUxUX1RJVExFX0dFVCI7czo2OiJOT1JNQUwiO3M6MTE6IlNIT1dfQUJTRU5UIjtOO3M6MjU6IkhJREVfTk9UX0FWQUlMQUJMRV9PRkZFUlMiO3M6MToiTiI7czoxMDoiUFJJQ0VfQ09ERSI7YToxOntpOjA7czo0OiJCQVNFIjt9czoxNjoiT0ZGRVJfVFJFRV9QUk9QUyI7YTowOnt9czoxMDoiQ0FDSEVfVElNRSI7aTozNjAwMDAwO3M6MTY6IkNPTlZFUlRfQ1VSUkVOQ1kiO3M6MToiWSI7czoxMToiQ1VSUkVOQ1lfSUQiO3M6MzoiUlVCIjtzOjE3OiJPRkZFUlNfU09SVF9GSUVMRCI7czo0OiJzb3J0IjtzOjE3OiJPRkZFUlNfU09SVF9PUkRFUiI7czozOiJhc2MiO3M6MTg6Ik9GRkVSU19TT1JUX0ZJRUxEMiI7czo0OiJzb3J0IjtzOjE4OiJPRkZFUlNfU09SVF9PUkRFUjIiO3M6MzoiYXNjIjtzOjE3OiJMSVNUX09GRkVSU19MSU1JVCI7aTowO3M6MTI6IkNBQ0hFX0dST1VQUyI7czoxOiJZIjtzOjI1OiJMSVNUX09GRkVSU19QUk9QRVJUWV9DT0RFIjthOjg6e2k6MDtzOjk6IkNPTE9SX1JFRiI7aToxO3M6NToiU0laRVMiO2k6MjtzOjY6IlZPTFVNRSI7aTozO3M6NjoiV0VJR0hUIjtpOjQ7czo2OiJTSVpFUzIiO2k6NTtzOjY6IlNJWkVTMyI7aTo2O3M6NjoiU0laRVM0IjtpOjc7czo2OiJTSVpFUzUiO31zOjE4OiJTSE9XX0RJU0NPVU5UX1RJTUUiO3M6MToiWSI7czoxNzoiU0hPV19DT1VOVEVSX0xJU1QiO3M6MToiWSI7czoxNzoiUFJJQ0VfVkFUX0lOQ0xVREUiO2I6MTtzOjE1OiJVU0VfUFJJQ0VfQ09VTlQiO2I6MDtzOjEyOiJTSE9XX01FQVNVUkUiO3M6MToiWSI7czoxNDoiU0hPV19PTERfUFJJQ0UiO3M6MToiWSI7czoyMToiU0hPV19ESVNDT1VOVF9QRVJDRU5UIjtzOjE6IlkiO3M6Mjg6IlNIT1dfRElTQ09VTlRfUEVSQ0VOVF9OVU1CRVIiO3M6MToiWSI7czoxMDoiVVNFX1JFR0lPTiI7czoxOiJOIjtzOjY6IlNUT1JFUyI7YTowOnt9czoxMzoiREVGQVVMVF9DT1VOVCI7czoxOiIxIjtzOjEwOiJCQVNLRVRfVVJMIjtzOjg6Ii9iYXNrZXQvIjtzOjIyOiJPRkZFUlNfQ0FSVF9QUk9QRVJUSUVTIjthOjg6e2k6MDtzOjk6IkNPTE9SX1JFRiI7aToxO3M6NToiU0laRVMiO2k6MjtzOjY6IlZPTFVNRSI7aTozO3M6NjoiV0VJR0hUIjtpOjQ7czo2OiJTSVpFUzIiO2k6NTtzOjY6IlNJWkVTMyI7aTo2O3M6NjoiU0laRVM0IjtpOjc7czo2OiJTSVpFUzUiO31zOjE4OiJQUk9EVUNUX1BST1BFUlRJRVMiO3M6MDoiIjtzOjI2OiJQQVJUSUFMX1BST0RVQ1RfUFJPUEVSVElFUyI7czoxOiJOIjtzOjI0OiJBRERfUFJPUEVSVElFU19UT19CQVNLRVQiO3M6MToiWSI7czoyNzoiU0hPV19ESVNDT1VOVF9USU1FX0VBQ0hfU0tVIjtzOjE6Ik4iO3M6MTY6IlNIT1dfQVJUSUNMRV9TS1UiO3M6MToiWSI7czoxOToiT0ZGRVJfQUREX1BJQ1RfUFJPUCI7czoxMDoiTU9SRV9QSE9UTyI7czoyNToiUFJPRFVDVF9RVUFOVElUWV9WQVJJQUJMRSI7czo4OiJxdWFudGl0eSI7czoxODoiU0hPV19PTkVfQ0xJQ0tfQlVZIjtzOjE6IlkiO3M6MTU6IkRJU1BMQVlfQ09NUEFSRSI7czoxOiJZIjtzOjIwOiJESVNQTEFZX1dJU0hfQlVUVE9OUyI7czoxOiJZIjtzOjE3OiJNQVhfR0FMTEVSWV9JVEVNUyI7czoxOiI1IjtzOjEyOiJTSE9XX0dBTExFUlkiO3M6MToiWSI7czoxMDoiU0hPV19QUk9QUyI7czoxOiJOIjtzOjE2OiJTSE9XX1BPUFVQX1BSSUNFIjtzOjE6IlkiO3M6MTM6IkFERF9QSUNUX1BST1AiO3M6MTA6Ik1PUkVfUEhPVE8iO3M6MjA6IkFERF9ERVRBSUxfVE9fU0xJREVSIjtzOjE6IlkiO3M6MTk6IklCSU5IRVJJVF9URU1QTEFURVMiO2E6MDp7fXM6MTY6IklCTE9DS19JRF9QQVJFTlQiO2k6MjY7czo5OiJJQkxPQ0tfSUQiO2k6Mjg7fQ==.cc26f4f6c6195ccf63b0d55b893d8b7ce6348f46aad5291e36ba7647a00cc2b2"
                     data-i-appeared="true">
                    <div id="table-scroller-wrapper" class="table-view js_append flexbox flexbox--row with-opt-buy ">
                        <div class="table-view__item item bordered box-shadow main_item_wrapper js-notice-block"
                             id="bx_3966226736_39685" data-id="39685" data-product_type="1">
                            <div class="table-view__item-wrapper item_info catalog-adaptive flexbox flexbox--row">
                                <div class="item-check">
                                    <div class="filter label_block">
                                        <input type="checkbox" name="chec_item" id="chec_item39685" value="Y">
                                        <label for="chec_item39685"></label>
                                    </div>
                                </div>
                                <div class="item-foto">
                                    <div class="item-foto__picture js-notice-block__image">
                                        <a href="/catalog/mototrasport2/snow/baltmotors/snowdog/39685/"
                                           class="thumb shine">
                                            <img class="img-responsive lazyloaded"
                                                 src="/upload/iblock/bd7/xjm37emzoxn2rm34dfu5kknji10o27n5.jpg"
                                                 data-src="/upload/iblock/bd7/xjm37emzoxn2rm34dfu5kknji10o27n5.jpg"
                                                 alt="Снегоход Baltmotors Snowdog" title="Снегоход Baltmotors Snowdog">
                                        </a>
                                        <div class="fast_view_block wicons rounded2" data-event="jqm"
                                             data-param-form_id="fast_view" data-param-iblock_id="26"
                                             data-param-id="39685"
                                             data-param-item_href="%2Fcatalog%2Fmototrasport2%2Fsnow%2Fbaltmotors%2Fsnowdog%2F39685%2F"
                                             data-name="fast_view"><i class="svg inline  svg-inline-fw ncolor"
                                                                      aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12"
                                                     viewBox="0 0 16 12">
                                                    <path data-name="Ellipse 302 copy 4" class="cls-1"
                                                          d="M666,241a8.546,8.546,0,0,1-8.008-6,8.344,8.344,0,0,1,16.016,0A8.547,8.547,0,0,1,666,241Zm0-2a6.591,6.591,0,0,0,5.967-4,7.04,7.04,0,0,0-1.141-1.76,4.977,4.977,0,0,1-9.652,0,7.072,7.072,0,0,0-1.142,1.76A6.591,6.591,0,0,0,666,239Zm-2.958-7.246c-0.007.085-.042,0.16-0.042,0.246a3,3,0,1,0,6,0c0-.086-0.035-0.161-0.042-0.245A6.176,6.176,0,0,0,663.042,231.753Z"
                                                          transform="translate(-658 -229)"></path>
                                                </svg>
                                            </i>Быстрый просмотр
                                        </div>
                                    </div>
                                    <div class="adaptive">
                                        <div class="like_icons block" data-size="2">
                                            <div class="wish_item_button item-action">
                                                <span title="В избранное" data-title="В избранное"
                                                      data-title_added="В избранном" data-quantity="1"
                                                      class="wish_item to rounded3 colored_theme_hover_bg js-item-action"
                                                      data-action="favorite" data-item="39685" data-iblock="26"><i
                                                            class="svg inline  svg-inline-wish ncolor colored"
                                                            aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="13"
                                                                                    viewBox="0 0 16 13"><defs><style>.clsw-1 {fill: #fff;fill-rule: evenodd;}</style></defs><path
                                                                    class="clsw-1"
                                                                    d="M506.755,141.6l0,0.019s-4.185,3.734-5.556,4.973a0.376,0.376,0,0,1-.076.056,1.838,1.838,0,0,1-1.126.357,1.794,1.794,0,0,1-1.166-.4,0.473,0.473,0,0,1-.1-0.076c-1.427-1.287-5.459-4.878-5.459-4.878l0-.019A4.494,4.494,0,1,1,500,135.7,4.492,4.492,0,1,1,506.755,141.6Zm-3.251-5.61A2.565,2.565,0,0,0,501,138h0a1,1,0,1,1-2,0h0a2.565,2.565,0,0,0-2.506-2,2.5,2.5,0,0,0-1.777,4.264l-0.013.019L500,145.1l5.179-4.749c0.042-.039.086-0.075,0.126-0.117l0.052-.047-0.006-.008A2.494,2.494,0,0,0,503.5,135.993Z"
                                                                    transform="translate(-492 -134)"></path></svg></i></span>
                                            </div>
                                            <div class="compare_item_button">
                                                <span title="Сравнить"
                                                      class="compare_item to rounded3 colored_theme_hover_bg"
                                                      data-iblock="26" data-item="39685"><i
                                                            class="svg inline  svg-inline-compare ncolor colored"
                                                            aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="14" height="13"
                                                                                    viewBox="0 0 14 13"><path
                                                                    data-name="Rounded Rectangle 913 copy" class="cls-1"
                                                                    d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                                    transform="translate(-590 -134)"></path></svg></i></span>
                                                <span title="В сравнении"
                                                      class="compare_item in added rounded3 colored_theme_bg"
                                                      style="display: none;" data-iblock="26" data-item="39685"><i
                                                            class="svg inline  svg-inline-compare ncolor colored"
                                                            aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="14" height="13"
                                                                                    viewBox="0 0 14 13"><path
                                                                    data-name="Rounded Rectangle 913 copy" class="cls-1"
                                                                    d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                                    transform="translate(-590 -134)"></path></svg></i></span>
                                            </div>
                                            <div class="fast_view_button">
                                                <span title="Быстрый просмотр" class="rounded3 colored_theme_hover_bg"
                                                      data-event="jqm" data-param-form_id="fast_view"
                                                      data-param-iblock_id="26" data-param-id="39685"
                                                      data-param-item_href="%2Fcatalog%2Fmototrasport2%2Fsnow%2Fbaltmotors%2Fsnowdog%2F39685%2F"
                                                      data-name="fast_view"><i
                                                            class="svg inline  svg-inline-fw ncolor colored"
                                                            aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="12"
                                                                                    viewBox="0 0 16 12"><path
                                                                    data-name="Ellipse 302 copy 3" class="cls-1"
                                                                    d="M549,146a8.546,8.546,0,0,1-8.008-6,8.344,8.344,0,0,1,16.016,0A8.547,8.547,0,0,1,549,146Zm0-2a6.591,6.591,0,0,0,5.967-4,7.022,7.022,0,0,0-1.141-1.76,4.977,4.977,0,0,1-9.652,0,7.053,7.053,0,0,0-1.142,1.76A6.591,6.591,0,0,0,549,144Zm-2.958-7.246c-0.007.084-.042,0.159-0.042,0.246a3,3,0,1,0,6,0c0-.087-0.035-0.162-0.042-0.246A6.179,6.179,0,0,0,546.042,136.753Z"
                                                                    transform="translate(-541 -134)"></path></svg></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-view__info flexbox inner_content js_offers__39685_table">
                                    <div class="table-view__info-wrapper flexbox flexbox--row">
                                        <div class="item-info table-view__info-top">
                                            <div class="item-title"><a
                                                        href="/catalog/mototrasport2/snow/baltmotors/snowdog/39685/"
                                                        class="dark_link js-notice-block__title"><span>Снегоход Baltmotors Snowdog</span></a>
                                            </div>
                                            <div class="wrapp_stockers sa_block"
                                                 data-fields="[&quot;&quot;,&quot;&quot;]" data-stores="[]"
                                                 data-user-fields="[&quot;&quot;,&quot;UF_CATALOG_ICON&quot;,&quot;&quot;]">
                                                <div data-click="N" class="item-stock " data-id="39685"><span
                                                            class="icon stock"></span><span
                                                            class="value font_sxs">Мало</span></div>
                                                <div class="article_block" data-name="Арт." data-value="111111111">
                                                    <div class="muted font_sxs">Арт.: 111111111</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="item-actions flexbox flexbox--row">
                                            <div class="item-price">
                                                <div class="cost prices clearfix">
                                                    <div class="price_matrix_wrapper ">
                                                        <div class="price font-bold font_mxs" data-currency="RUB"
                                                             data-value="185826.2">
                                                            <span class="values_wrapper"><span class="price_value">185&nbsp;826.20</span><span
                                                                        class="price_currency"> ₽</span></span></div>
                                                    </div>
                                                    <div class="js-info-block rounded3">
                                                        <div class="block_title text-upper font_xs font-bold">
                                                            Варианты цен <i class="svg inline  svg-inline-close"
                                                                            aria-hidden="true">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                     height="16" viewBox="0 0 16 16">
                                                                    <path data-name="Rounded Rectangle 114 copy 3"
                                                                          class="cccls-1"
                                                                          d="M334.411,138l6.3,6.3a1,1,0,0,1,0,1.414,0.992,0.992,0,0,1-1.408,0l-6.3-6.306-6.3,6.306a1,1,0,0,1-1.409-1.414l6.3-6.3-6.293-6.3a1,1,0,0,1,1.409-1.414l6.3,6.3,6.3-6.3A1,1,0,0,1,340.7,131.7Z"
                                                                          transform="translate(-325 -130)"></path>
                                                                </svg>
                                                            </i></div>
                                                        <div class="block_wrap">
                                                            <div class="block_wrap_inner prices ">
                                                                <div class="price_matrix_wrapper ">
                                                                    <div class="price font-bold font_mxs"
                                                                         data-currency="RUB" data-value="185826.2">
                                                                        <span class="values_wrapper"><span
                                                                                    class="price_value">185&nbsp;826.20</span><span
                                                                                    class="price_currency"> ₽</span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="more-btn text-center">
                                                                <a href="" class="font_upper colored_theme_hover_bg">Подробности</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="basket_props_block" id="bx_basket_div_39685"
                                                     style="display: none;">
                                                </div>
                                            </div>

                                            <div class="item-buttons item_39685">
                                                <div class="small-block counter_wrapp  list clearfix n-mb">
                                                    <div class="counter_block_inner">
                                                        <div class="counter_block " data-item="39685">
                                                            <span class="minus dark-color"
                                                                  id="bx_3966226736_39685_quant_down"><i
                                                                        class="svg inline  svg-inline-wish ncolor colored1"
                                                                        aria-hidden="true"><svg width="11" height="1"
                                                                                                viewBox="0 0 11 1"><rect
                                                                                width="11" height="1" rx="0.5"
                                                                                ry="0.5"></rect></svg></i></span>
                                                            <input type="text" class="text"
                                                                   id="bx_3966226736_39685_quantity" name="quantity"
                                                                   value="1">
                                                            <span class="plus dark-color"
                                                                  id="bx_3966226736_39685_quant_up"><i
                                                                        class="svg inline  svg-inline-wish ncolor colored1"
                                                                        aria-hidden="true"><svg width="11" height="11"
                                                                                                viewBox="0 0 11 11"><path
                                                                                d="M1034.5,193H1030v4.5a0.5,0.5,0,0,1-1,0V193h-4.5a0.5,0.5,0,0,1,0-1h4.5v-4.5a0.5,0.5,0,0,1,1,0V192h4.5A0.5,0.5,0,0,1,1034.5,193Z"
                                                                                transform="translate(-1024 -187)"></path></svg></i></span>
                                                        </div>
                                                    </div>
                                                    <div id="bx_3966226736_39685_basket_actions" class="button_block ">
                                                        <!--noindex-->
                                                        <span data-value="185826.2" data-currency="RUB"
                                                              class="small to-cart btn btn-default transition_bg animate-load"
                                                              data-item="39685" data-float_ratio="1" data-ratio="1"
                                                              data-bakset_div="bx_basket_div_39685" data-props=""
                                                              data-part_props="N" data-add_props="Y"
                                                              data-empty_props="Y" data-offers="N" data-iblockid="26"
                                                              data-quantity="1"><i
                                                                    class="svg inline  svg-inline-fw ncolor colored"
                                                                    aria-hidden="true" title="В корзину"><svg class=""
                                                                                                              width="19"
                                                                                                              height="16"
                                                                                                              viewBox="0 0 19 16"><path
                                                                            data-name="Ellipse 2 copy 9" class="cls-1"
                                                                            d="M956.047,952.005l-0.939,1.009-11.394-.008-0.952-1-0.953-6h-2.857a0.862,0.862,0,0,1-.952-1,1.025,1.025,0,0,1,1.164-1h2.327c0.3,0,.6.006,0.6,0.006a1.208,1.208,0,0,1,1.336.918L943.817,947h12.23L957,948v1Zm-11.916-3,0.349,2h10.007l0.593-2Zm1.863,5a3,3,0,1,1-3,3A3,3,0,0,1,945.994,954.005ZM946,958a1,1,0,1,0-1-1A1,1,0,0,0,946,958Zm7.011-4a3,3,0,1,1-3,3A3,3,0,0,1,953.011,954.005ZM953,958a1,1,0,1,0-1-1A1,1,0,0,0,953,958Z"
                                                                            transform="translate(-938 -944)"></path></svg></i><span>В корзину</span></span><a
                                                                rel="nofollow" href="/basket/"
                                                                class="small in-cart btn btn-default transition_bg"
                                                                data-item="39685" style="display:none;"><i
                                                                    class="svg inline  svg-inline-fw ncolor colored"
                                                                    aria-hidden="true" title="В корзине">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="19"
                                                                     height="18" viewBox="0 0 19 18">
                                                                    <path data-name="Rounded Rectangle 906 copy 3"
                                                                          class="cls-1"
                                                                          d="M1005.97,4556.22l-1.01,4.02a0.031,0.031,0,0,0-.01.02,0.87,0.87,0,0,1-.14.29,0.423,0.423,0,0,1-.05.07,0.7,0.7,0,0,1-.2.18,0.359,0.359,0,0,1-.1.07,0.656,0.656,0,0,1-.21.08,1.127,1.127,0,0,1-.18.03,0.185,0.185,0,0,1-.07.02H993c-0.03,0-.056-0.02-0.086-0.02a1.137,1.137,0,0,1-.184-0.04,0.779,0.779,0,0,1-.207-0.08c-0.031-.02-0.059-0.04-0.088-0.06a0.879,0.879,0,0,1-.223-0.22s-0.007-.01-0.011-0.01a1,1,0,0,1-.172-0.43l-1.541-6.14H988a1,1,0,1,1,0-2h3.188a0.3,0.3,0,0,1,.092.02,0.964,0.964,0,0,1,.923.76l1.561,6.22h9.447l0.82-3.25a1,1,0,0,1,1.21-.73A0.982,0.982,0,0,1,1005.97,4556.22Zm-7.267.47c0,0.01,0,.01,0,0.01a1,1,0,0,1-1.414,0l-2.016-2.03a0.982,0.982,0,0,1,0-1.4,1,1,0,0,1,1.414,0l1.305,1.31,4.3-4.3a1,1,0,0,1,1.41,0,1.008,1.008,0,0,1,0,1.42ZM995,4562a3,3,0,1,1-3,3A3,3,0,0,1,995,4562Zm0,4a1,1,0,1,0-1-1A1,1,0,0,0,995,4566Zm7-4a3,3,0,1,1-3,3A3,3,0,0,1,1002,4562Zm0,4a1,1,0,1,0-1-1A1,1,0,0,0,1002,4566Z"
                                                                          transform="translate(-987 -4550)"></path>
                                                                </svg>
                                                            </i><span>В корзине</span></a><span class="hidden"
                                                                                                data-js-item-name="Снегоход Baltmotors Snowdog"></span>
                                                        <!--/noindex-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-icons s_2">
                                            <div class="like_icons list static icons long table-icons" data-size="2">
                                                <div class="wish_item_button item-action">
                                                    <span title="В избранное" data-title="В избранное"
                                                          data-title_added="В избранном" data-quantity="1"
                                                          class="wish_item to rounded3 btn btn-xs font_upper_xs btn-transparent js-item-action"
                                                          data-action="favorite" data-item="39685" data-iblock="26"><i
                                                                class="svg inline  svg-inline-wish ncolor colored"
                                                                aria-hidden="true"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="13" viewBox="0 0 16 13"><defs><style>.clsw-1 {fill: #fff;fill-rule: evenodd;}</style></defs><path
                                                                        class="clsw-1"
                                                                        d="M506.755,141.6l0,0.019s-4.185,3.734-5.556,4.973a0.376,0.376,0,0,1-.076.056,1.838,1.838,0,0,1-1.126.357,1.794,1.794,0,0,1-1.166-.4,0.473,0.473,0,0,1-.1-0.076c-1.427-1.287-5.459-4.878-5.459-4.878l0-.019A4.494,4.494,0,1,1,500,135.7,4.492,4.492,0,1,1,506.755,141.6Zm-3.251-5.61A2.565,2.565,0,0,0,501,138h0a1,1,0,1,1-2,0h0a2.565,2.565,0,0,0-2.506-2,2.5,2.5,0,0,0-1.777,4.264l-0.013.019L500,145.1l5.179-4.749c0.042-.039.086-0.075,0.126-0.117l0.052-.047-0.006-.008A2.494,2.494,0,0,0,503.5,135.993Z"
                                                                        transform="translate(-492 -134)"></path></svg></i></span>
                                                </div>
                                                <div class="compare_item_button">
                                                    <span title="Сравнить"
                                                          class="compare_item to rounded3 btn btn-xs font_upper_xs btn-transparent"
                                                          data-iblock="26" data-item="39685"><i
                                                                class="svg inline  svg-inline-compare ncolor colored"
                                                                aria-hidden="true"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="14"
                                                                    height="13" viewBox="0 0 14 13"><path
                                                                        data-name="Rounded Rectangle 913 copy"
                                                                        class="cls-1"
                                                                        d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                                        transform="translate(-590 -134)"></path></svg></i></span>
                                                    <span title="В сравнении"
                                                          class="compare_item in added rounded3 btn btn-xs font_upper_xs btn-transparent"
                                                          style="display: none;" data-iblock="26" data-item="39685"><i
                                                                class="svg inline  svg-inline-compare ncolor colored"
                                                                aria-hidden="true"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="14"
                                                                    height="13" viewBox="0 0 14 13"><path
                                                                        data-name="Rounded Rectangle 913 copy"
                                                                        class="cls-1"
                                                                        d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                                        transform="translate(-590 -134)"></path></svg></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-view__props-wrapper flexbox flexbox--row hide-600 ">
                                        <div class="properties flexbox flexbox--row js-offers-prop">
                                            <div class="properties-table-item flexbox js-prop-replace">
                                                <div class="properties__title font_sxs muted js-prop-title">
                                                    Тип (снегоход)
                                                </div>
                                                <div class="properties__value darken font_sm js-prop-value">
                                                    утилитарный
                                                </div>
                                            </div>
                                            <div class="properties-table-item flexbox js-prop-replace">
                                                <div class="properties__title font_sxs muted js-prop-title">
                                                    чество цилиндров (снегоход)
                                                </div>
                                                <div class="properties__value darken font_sm js-prop-value">
                                                    1
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-view__item item bordered box-shadow main_item_wrapper js-notice-block"
                             id="bx_3966226736_39684" data-id="39684" data-product_type="1">
                            <div class="table-view__item-wrapper item_info catalog-adaptive flexbox flexbox--row">
                                <div class="item-check">
                                    <div class="filter label_block">
                                        <input type="checkbox" name="chec_item" id="chec_item39684" value="Y">
                                        <label for="chec_item39684"></label>
                                    </div>
                                </div>
                                <div class="item-foto">
                                    <div class="item-foto__picture js-notice-block__image">
                                        <a href="/catalog/mototrasport2/snow/baltmotors/barboss/39684/"
                                           class="thumb shine">
                                            <img class="img-responsive lazyloaded"
                                                 src="/upload/iblock/df6/b86oxgnjdgycaumnrctyk1onqwn15smg.jpg"
                                                 data-src="/upload/iblock/df6/b86oxgnjdgycaumnrctyk1onqwn15smg.jpg"
                                                 alt="Снегоход Baltmotors Barboss" title="Снегоход Baltmotors Barboss">
                                        </a>
                                        <div class="fast_view_block wicons rounded2" data-event="jqm"
                                             data-param-form_id="fast_view" data-param-iblock_id="26"
                                             data-param-id="39684"
                                             data-param-item_href="%2Fcatalog%2Fmototrasport2%2Fsnow%2Fbaltmotors%2Fbarboss%2F39684%2F"
                                             data-name="fast_view"><i class="svg inline  svg-inline-fw ncolor"
                                                                      aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12"
                                                     viewBox="0 0 16 12">
                                                    <path data-name="Ellipse 302 copy 4" class="cls-1"
                                                          d="M666,241a8.546,8.546,0,0,1-8.008-6,8.344,8.344,0,0,1,16.016,0A8.547,8.547,0,0,1,666,241Zm0-2a6.591,6.591,0,0,0,5.967-4,7.04,7.04,0,0,0-1.141-1.76,4.977,4.977,0,0,1-9.652,0,7.072,7.072,0,0,0-1.142,1.76A6.591,6.591,0,0,0,666,239Zm-2.958-7.246c-0.007.085-.042,0.16-0.042,0.246a3,3,0,1,0,6,0c0-.086-0.035-0.161-0.042-0.245A6.176,6.176,0,0,0,663.042,231.753Z"
                                                          transform="translate(-658 -229)"></path>
                                                </svg>
                                            </i>Быстрый просмотр
                                        </div>
                                    </div>
                                    <div class="adaptive">
                                        <div class="like_icons block" data-size="2">
                                            <div class="wish_item_button item-action">
                                                <span title="В избранное" data-title="В избранное"
                                                      data-title_added="В избранном" data-quantity="1"
                                                      class="wish_item to rounded3 colored_theme_hover_bg js-item-action"
                                                      data-action="favorite" data-item="39684" data-iblock="26"><i
                                                            class="svg inline  svg-inline-wish ncolor colored"
                                                            aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="13"
                                                                                    viewBox="0 0 16 13"><defs><style>.clsw-1 {fill: #fff;fill-rule: evenodd;}</style></defs><path
                                                                    class="clsw-1"
                                                                    d="M506.755,141.6l0,0.019s-4.185,3.734-5.556,4.973a0.376,0.376,0,0,1-.076.056,1.838,1.838,0,0,1-1.126.357,1.794,1.794,0,0,1-1.166-.4,0.473,0.473,0,0,1-.1-0.076c-1.427-1.287-5.459-4.878-5.459-4.878l0-.019A4.494,4.494,0,1,1,500,135.7,4.492,4.492,0,1,1,506.755,141.6Zm-3.251-5.61A2.565,2.565,0,0,0,501,138h0a1,1,0,1,1-2,0h0a2.565,2.565,0,0,0-2.506-2,2.5,2.5,0,0,0-1.777,4.264l-0.013.019L500,145.1l5.179-4.749c0.042-.039.086-0.075,0.126-0.117l0.052-.047-0.006-.008A2.494,2.494,0,0,0,503.5,135.993Z"
                                                                    transform="translate(-492 -134)"></path></svg></i></span>
                                            </div>
                                            <div class="compare_item_button">
                                                <span title="Сравнить"
                                                      class="compare_item to rounded3 colored_theme_hover_bg"
                                                      data-iblock="26" data-item="39684"><i
                                                            class="svg inline  svg-inline-compare ncolor colored"
                                                            aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="14" height="13"
                                                                                    viewBox="0 0 14 13"><path
                                                                    data-name="Rounded Rectangle 913 copy" class="cls-1"
                                                                    d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                                    transform="translate(-590 -134)"></path></svg></i></span>
                                                <span title="В сравнении"
                                                      class="compare_item in added rounded3 colored_theme_bg"
                                                      style="display: none;" data-iblock="26" data-item="39684"><i
                                                            class="svg inline  svg-inline-compare ncolor colored"
                                                            aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="14" height="13"
                                                                                    viewBox="0 0 14 13"><path
                                                                    data-name="Rounded Rectangle 913 copy" class="cls-1"
                                                                    d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                                    transform="translate(-590 -134)"></path></svg></i></span>
                                            </div>
                                            <div class="fast_view_button">
                                                <span title="Быстрый просмотр" class="rounded3 colored_theme_hover_bg"
                                                      data-event="jqm" data-param-form_id="fast_view"
                                                      data-param-iblock_id="26" data-param-id="39684"
                                                      data-param-item_href="%2Fcatalog%2Fmototrasport2%2Fsnow%2Fbaltmotors%2Fbarboss%2F39684%2F"
                                                      data-name="fast_view"><i
                                                            class="svg inline  svg-inline-fw ncolor colored"
                                                            aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="12"
                                                                                    viewBox="0 0 16 12"><path
                                                                    data-name="Ellipse 302 copy 3" class="cls-1"
                                                                    d="M549,146a8.546,8.546,0,0,1-8.008-6,8.344,8.344,0,0,1,16.016,0A8.547,8.547,0,0,1,549,146Zm0-2a6.591,6.591,0,0,0,5.967-4,7.022,7.022,0,0,0-1.141-1.76,4.977,4.977,0,0,1-9.652,0,7.053,7.053,0,0,0-1.142,1.76A6.591,6.591,0,0,0,549,144Zm-2.958-7.246c-0.007.084-.042,0.159-0.042,0.246a3,3,0,1,0,6,0c0-.087-0.035-0.162-0.042-0.246A6.179,6.179,0,0,0,546.042,136.753Z"
                                                                    transform="translate(-541 -134)"></path></svg></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-view__info flexbox inner_content js_offers__39684_table">
                                    <div class="table-view__info-wrapper flexbox flexbox--row">
                                        <div class="item-info table-view__info-top">
                                            <div class="item-title"><a
                                                        href="/catalog/mototrasport2/snow/baltmotors/barboss/39684/"
                                                        class="dark_link js-notice-block__title"><span>Снегоход Baltmotors Barboss</span></a>
                                            </div>
                                            <div class="wrapp_stockers sa_block"
                                                 data-fields="[&quot;&quot;,&quot;&quot;]" data-stores="[]"
                                                 data-user-fields="[&quot;&quot;,&quot;UF_CATALOG_ICON&quot;,&quot;&quot;]">
                                                <div data-click="N" class="item-stock " data-id="39684"><span
                                                            class="icon  order"></span><span class="value font_sxs">Нет в наличии</span>
                                                </div>
                                                <div class="article_block"></div>
                                            </div>
                                        </div>

                                        <div class="item-actions flexbox flexbox--row">
                                            <div class="item-price">
                                                <div class="cost prices clearfix">
                                                    <div class="price_matrix_wrapper ">
                                                        <div class="price font-bold font_mxs" data-currency="RUB"
                                                             data-value="157232.6">
                                                            <span class="values_wrapper"><span class="price_value">157&nbsp;232.60</span><span
                                                                        class="price_currency"> ₽</span></span></div>
                                                    </div>
                                                    <div class="js-info-block rounded3">
                                                        <div class="block_title text-upper font_xs font-bold">
                                                            Варианты цен <i class="svg inline  svg-inline-close"
                                                                            aria-hidden="true">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                     height="16" viewBox="0 0 16 16">
                                                                    <path data-name="Rounded Rectangle 114 copy 3"
                                                                          class="cccls-1"
                                                                          d="M334.411,138l6.3,6.3a1,1,0,0,1,0,1.414,0.992,0.992,0,0,1-1.408,0l-6.3-6.306-6.3,6.306a1,1,0,0,1-1.409-1.414l6.3-6.3-6.293-6.3a1,1,0,0,1,1.409-1.414l6.3,6.3,6.3-6.3A1,1,0,0,1,340.7,131.7Z"
                                                                          transform="translate(-325 -130)"></path>
                                                                </svg>
                                                            </i></div>
                                                        <div class="block_wrap">
                                                            <div class="block_wrap_inner prices ">
                                                                <div class="price_matrix_wrapper ">
                                                                    <div class="price font-bold font_mxs"
                                                                         data-currency="RUB" data-value="157232.6">
                                                                        <span class="values_wrapper"><span
                                                                                    class="price_value">157&nbsp;232.60</span><span
                                                                                    class="price_currency"> ₽</span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="more-btn text-center">
                                                                <a href="" class="font_upper colored_theme_hover_bg">Подробности</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="basket_props_block" id="bx_basket_div_39684"
                                                     style="display: none;">
                                                </div>
                                            </div>

                                            <div class="item-buttons item_39684">
                                                <div class="small-block counter_wrapp  list clearfix n-mb">
                                                    <div id="bx_3966226736_39684_basket_actions"
                                                         class="button_block wide">
                                                        <!--noindex-->
                                                        <span class="small to-order btn btn-default animate-load"
                                                              data-event="jqm" data-param-form_id="TOORDER"
                                                              data-name="toorder"
                                                              data-autoload-product_name="Снегоход Baltmotors Barboss"
                                                              data-autoload-product_id="39684"><i
                                                                    class="svg inline  svg-inline-fw ncolor colored"
                                                                    aria-hidden="true" title="Под заказ"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="18"
                                                                        height="14" viewBox="0 0 18 14"><path
                                                                            data-name="Rounded Rectangle 1055 copy 4"
                                                                            class="mailcls-1"
                                                                            d="M903,3845H891a3,3,0,0,1-3-3v-8a3,3,0,0,1,3-3h12a3,3,0,0,1,3,3v8A3,3,0,0,1,903,3845Zm-12-2h12a0.969,0.969,0,0,0,.475-0.14l-3.844-3.86-1.821,1.59c-0.021.03-.03,0.06-0.054,0.09a1.1,1.1,0,0,1-1.512,0c-0.024-.03-0.033-0.06-0.054-0.09l-1.821-1.59-3.844,3.86A0.969,0.969,0,0,0,891,3843Zm-1-2.44,2.861-2.88-2.861-2.5v5.38Zm13-7.56H891a1.037,1.037,0,0,0-.354.07l6.354,5.56,6.354-5.56A1.037,1.037,0,0,0,903,3833Zm1,2.18-2.861,2.5,2.861,2.88v-5.38Z"
                                                                            transform="translate(-888 -3831)"></path></svg></i><span>Под заказ</span></span>
                                                        <div class="more_text">Наши менеджеры обязательно свяжутся с
                                                            вами и уточнят условия заказа
                                                        </div>
                                                        <span class="hidden"
                                                              data-js-item-name="Снегоход Baltmotors Barboss"></span>
                                                        <!--/noindex-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-icons s_2">
                                            <div class="like_icons list static icons long table-icons" data-size="2">
                                                <div class="wish_item_button item-action">
                                                    <span title="В избранное" data-title="В избранное"
                                                          data-title_added="В избранном" data-quantity="1"
                                                          class="wish_item to rounded3 btn btn-xs font_upper_xs btn-transparent js-item-action"
                                                          data-action="favorite" data-item="39684" data-iblock="26"><i
                                                                class="svg inline  svg-inline-wish ncolor colored"
                                                                aria-hidden="true"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="13" viewBox="0 0 16 13"><defs><style>.clsw-1 {fill: #fff;fill-rule: evenodd;}</style></defs><path
                                                                        class="clsw-1"
                                                                        d="M506.755,141.6l0,0.019s-4.185,3.734-5.556,4.973a0.376,0.376,0,0,1-.076.056,1.838,1.838,0,0,1-1.126.357,1.794,1.794,0,0,1-1.166-.4,0.473,0.473,0,0,1-.1-0.076c-1.427-1.287-5.459-4.878-5.459-4.878l0-.019A4.494,4.494,0,1,1,500,135.7,4.492,4.492,0,1,1,506.755,141.6Zm-3.251-5.61A2.565,2.565,0,0,0,501,138h0a1,1,0,1,1-2,0h0a2.565,2.565,0,0,0-2.506-2,2.5,2.5,0,0,0-1.777,4.264l-0.013.019L500,145.1l5.179-4.749c0.042-.039.086-0.075,0.126-0.117l0.052-.047-0.006-.008A2.494,2.494,0,0,0,503.5,135.993Z"
                                                                        transform="translate(-492 -134)"></path></svg></i></span>
                                                </div>
                                                <div class="compare_item_button">
                                                    <span title="Сравнить"
                                                          class="compare_item to rounded3 btn btn-xs font_upper_xs btn-transparent"
                                                          data-iblock="26" data-item="39684"><i
                                                                class="svg inline  svg-inline-compare ncolor colored"
                                                                aria-hidden="true"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="14"
                                                                    height="13" viewBox="0 0 14 13"><path
                                                                        data-name="Rounded Rectangle 913 copy"
                                                                        class="cls-1"
                                                                        d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                                        transform="translate(-590 -134)"></path></svg></i></span>
                                                    <span title="В сравнении"
                                                          class="compare_item in added rounded3 btn btn-xs font_upper_xs btn-transparent"
                                                          style="display: none;" data-iblock="26" data-item="39684"><i
                                                                class="svg inline  svg-inline-compare ncolor colored"
                                                                aria-hidden="true"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="14"
                                                                    height="13" viewBox="0 0 14 13"><path
                                                                        data-name="Rounded Rectangle 913 copy"
                                                                        class="cls-1"
                                                                        d="M595,137a1,1,0,0,1,1,1v8a1,1,0,1,1-2,0v-8A1,1,0,0,1,595,137Zm-4,3a1,1,0,0,1,1,1v5a1,1,0,1,1-2,0v-5A1,1,0,0,1,591,140Zm8-6a1,1,0,0,1,1,1v11a1,1,0,1,1-2,0V135A1,1,0,0,1,599,134Zm4,6h0a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1v-5A1,1,0,0,1,603,140Z"
                                                                        transform="translate(-590 -134)"></path></svg></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-view__props-wrapper flexbox flexbox--row hide-600 ">
                                        <div class="properties flexbox flexbox--row js-offers-prop">
                                            <div class="properties-table-item flexbox js-prop-replace">
                                                <div class="properties__title font_sxs muted js-prop-title">
                                                    Тип (снегоход)
                                                </div>
                                                <div class="properties__value darken font_sm js-prop-value">
                                                    утилитарный
                                                </div>
                                            </div>
                                            <div class="properties-table-item flexbox js-prop-replace">
                                                <div class="properties__title font_sxs muted js-prop-title">
                                                    чество цилиндров (снегоход)
                                                </div>
                                                <div class="properties__value darken font_sm js-prop-value">
                                                    1
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bottom_nav table" data-all_count="2">
            </div>
            <script>typeof useOfferSelect === 'function' && useOfferSelect()</script>
            <script></script>

            <script>
                BX.Currency.setCurrencies([{
                    'CURRENCY': 'RUB',
                    'FORMAT': {
                        'FORMAT_STRING': '# &#8381;',
                        'DEC_POINT': '.',
                        'THOUSANDS_SEP': '&nbsp;',
                        'DECIMALS': 2,
                        'THOUSANDS_VARIANT': 'B',
                        'HIDE_ZERO': 'Y'
                    }
                }]);
            </script>
            <!--noindex-->
            <script class="smart-filter-filter" data-skip-moving="true">
                var filter = {"SECTION_ID": "10559"}                                            </script>
            <script class="smart-filter-sort" data-skip-moving="true">
                var filter = {"SHOWS": "asc", "sort": "asc"}                        </script>
            <!--/noindex-->
        </div>
        <!--'end_frame_cache_viewtype-block'-->

        <div class="clear"></div>


    </div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>