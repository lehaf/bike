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
                                            <div class="cost prices clearfix">
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
                                            <div class="cost prices clearfix">
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
                                <div class="description description__card-list">
                                    <div class="item-title card-list-title">
                                        <a href="/catalog/mototrasport2/snow/baltmotors/snowdog/39685/"
                                           class="dark_link js-notice-block__title"><span>Снегоход Baltmotors Snowdog</span></a>
                                        <div class="item-data-card">
                                            <div class="item-data-card__year">
                                                2020 г.
                                            </div>
                                            <div class="item-data-card__kilometer">
                                                114 300 км
                                            </div>
                                        </div>
                                    </div>
                                    <div class="description__name-product">
                                        Туристический Эндуро
                                    </div>
                                    <div class="product-description">
                                        <div class="product-description__left">
                                            <div class="product-description__el">
                                                <div class="product-description__i">72 см3</div>
                                                <div class="product-description__i">7 л.с.</div>
                                                <div class="product-description__i">4 такта</div>
                                            </div>
                                            <div class="product-description__el">
                                                <div class="product-description__i">1 цилиндр</div>
                                                <div class="product-description__i">рядное длинное название</div>
                                            </div>
                                            <div class="product-description__el">
                                                <div class="product-description__i">4 передачи</div>
                                            </div>
                                        </div>
                                        <div class="product-description__right">
                                            <div class="product-description__el"> <div class="product-description__i">Цепь</div></div>
                                            <div class="product-description__el"> <div class="product-description__i">Оранжевый</div></div>
                                        </div>
                                    </div>
                                    <div class="description-text">
                                        Отличное состояние. Из США. Самый модный цвет. Басовитый выхлоп. 10.2020 дата выпуска воарво, а площадкам просьба не беспокоить. Самый модный цвет. Басовитый выхлоп.Очень дллинный тек...
                                    </div>
                                    <div class="item-card-location">
                                        <div class="item-card-location__city">
                                            Минск
                                        </div>
                                        <div class="item-card-location__data">
                                            Сегодня в 11:47
                                        </div>
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
                                    <div class="prices-all">
                                        <div class="prices-all__i">≈ 1800 $</div>
                                        <div class="prices-all__i">≈ 499 000 ₽</div>
                                        <div class="prices-all__i">≈ 304 €</div>
                                    </div>
                                </div>
                            </div>
                            <div class="like_icons list like_icons__list" data-size="3">
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
                                <div class="description description__card-list">
                                    <div class="item-title card-list-title">
                                        <a href="/catalog/mototrasport2/snow/baltmotors/snowdog/39685/"
                                           class="dark_link js-notice-block__title"><span>Снегоход Baltmotors Snowdog</span></a>
                                        <div class="item-data-card">
                                            <div class="item-data-card__year">
                                                2020 г.
                                            </div>
                                            <div class="item-data-card__kilometer">
                                                114 300 км
                                            </div>
                                        </div>
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
                                    <div class="description-text">
                                        Отличное состояние. Из США. Самый модный цвет. Басовитый выхлоп. 10.2020 дата выпуска воарво, а площадкам просьба не беспокоить. Самый модный цвет. Басовитый выхлоп.Очень дллинный тек...
                                    </div>
                                    <div class="item-card-location">
                                        <div class="item-card-location__city">
                                            Минск
                                        </div>
                                        <div class="item-card-location__data">
                                            Сегодня в 11:47
                                        </div>
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
                                </div>
                            </div>
                            <div class="like_icons list like_icons__list" data-size="3">
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

                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const descriptions = document.querySelectorAll('.product-description__el');

                    descriptions.forEach(el => {
                        if (el.scrollWidth > el.clientWidth) {
                            el.classList.add('truncated');
                        }
                    });
                });
            </script>


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
                <div class="js_wrapper_items load-offer-js"
                     data-params="YTo0Nzp7czoxMzoiQUxUX1RJVExFX0dFVCI7czo2OiJOT1JNQUwiO3M6MTE6IlNIT1dfQUJTRU5UIjtOO3M6MjU6IkhJREVfTk9UX0FWQUlMQUJMRV9PRkZFUlMiO3M6MToiTiI7czoxMDoiUFJJQ0VfQ09ERSI7YToxOntpOjA7czo0OiJCQVNFIjt9czoxNjoiT0ZGRVJfVFJFRV9QUk9QUyI7YTowOnt9czoxMDoiQ0FDSEVfVElNRSI7aTozNjAwMDAwO3M6MTY6IkNPTlZFUlRfQ1VSUkVOQ1kiO3M6MToiWSI7czoxMToiQ1VSUkVOQ1lfSUQiO3M6MzoiUlVCIjtzOjE3OiJPRkZFUlNfU09SVF9GSUVMRCI7czo0OiJzb3J0IjtzOjE3OiJPRkZFUlNfU09SVF9PUkRFUiI7czozOiJhc2MiO3M6MTg6Ik9GRkVSU19TT1JUX0ZJRUxEMiI7czo0OiJzb3J0IjtzOjE4OiJPRkZFUlNfU09SVF9PUkRFUjIiO3M6MzoiYXNjIjtzOjE3OiJMSVNUX09GRkVSU19MSU1JVCI7aTowO3M6MTI6IkNBQ0hFX0dST1VQUyI7czoxOiJZIjtzOjI1OiJMSVNUX09GRkVSU19QUk9QRVJUWV9DT0RFIjthOjg6e2k6MDtzOjk6IkNPTE9SX1JFRiI7aToxO3M6NToiU0laRVMiO2k6MjtzOjY6IlZPTFVNRSI7aTozO3M6NjoiV0VJR0hUIjtpOjQ7czo2OiJTSVpFUzIiO2k6NTtzOjY6IlNJWkVTMyI7aTo2O3M6NjoiU0laRVM0IjtpOjc7czo2OiJTSVpFUzUiO31zOjE4OiJTSE9XX0RJU0NPVU5UX1RJTUUiO3M6MToiWSI7czoxNzoiU0hPV19DT1VOVEVSX0xJU1QiO3M6MToiWSI7czoxNzoiUFJJQ0VfVkFUX0lOQ0xVREUiO2I6MTtzOjE1OiJVU0VfUFJJQ0VfQ09VTlQiO2I6MDtzOjEyOiJTSE9XX01FQVNVUkUiO3M6MToiWSI7czoxNDoiU0hPV19PTERfUFJJQ0UiO3M6MToiWSI7czoyMToiU0hPV19ESVNDT1VOVF9QRVJDRU5UIjtzOjE6IlkiO3M6Mjg6IlNIT1dfRElTQ09VTlRfUEVSQ0VOVF9OVU1CRVIiO3M6MToiWSI7czoxMDoiVVNFX1JFR0lPTiI7czoxOiJOIjtzOjY6IlNUT1JFUyI7YTowOnt9czoxMzoiREVGQVVMVF9DT1VOVCI7czoxOiIxIjtzOjEwOiJCQVNLRVRfVVJMIjtzOjg6Ii9iYXNrZXQvIjtzOjIyOiJPRkZFUlNfQ0FSVF9QUk9QRVJUSUVTIjthOjg6e2k6MDtzOjk6IkNPTE9SX1JFRiI7aToxO3M6NToiU0laRVMiO2k6MjtzOjY6IlZPTFVNRSI7aTozO3M6NjoiV0VJR0hUIjtpOjQ7czo2OiJTSVpFUzIiO2k6NTtzOjY6IlNJWkVTMyI7aTo2O3M6NjoiU0laRVM0IjtpOjc7czo2OiJTSVpFUzUiO31zOjE4OiJQUk9EVUNUX1BST1BFUlRJRVMiO3M6MDoiIjtzOjI2OiJQQVJUSUFMX1BST0RVQ1RfUFJPUEVSVElFUyI7czoxOiJOIjtzOjI0OiJBRERfUFJPUEVSVElFU19UT19CQVNLRVQiO3M6MToiWSI7czoyNzoiU0hPV19ESVNDT1VOVF9USU1FX0VBQ0hfU0tVIjtzOjE6Ik4iO3M6MTY6IlNIT1dfQVJUSUNMRV9TS1UiO3M6MToiWSI7czoxOToiT0ZGRVJfQUREX1BJQ1RfUFJPUCI7czoxMDoiTU9SRV9QSE9UTyI7czoyNToiUFJPRFVDVF9RVUFOVElUWV9WQVJJQUJMRSI7czo4OiJxdWFudGl0eSI7czoxODoiU0hPV19PTkVfQ0xJQ0tfQlVZIjtzOjE6IlkiO3M6MTU6IkRJU1BMQVlfQ09NUEFSRSI7czoxOiJZIjtzOjIwOiJESVNQTEFZX1dJU0hfQlVUVE9OUyI7czoxOiJZIjtzOjE3OiJNQVhfR0FMTEVSWV9JVEVNUyI7czoxOiI1IjtzOjEyOiJTSE9XX0dBTExFUlkiO3M6MToiWSI7czoxMDoiU0hPV19QUk9QUyI7czoxOiJOIjtzOjE2OiJTSE9XX1BPUFVQX1BSSUNFIjtzOjE6IlkiO3M6MTM6IkFERF9QSUNUX1BST1AiO3M6MTA6Ik1PUkVfUEhPVE8iO3M6MjA6IkFERF9ERVRBSUxfVE9fU0xJREVSIjtzOjE6IlkiO3M6MTk6IklCSU5IRVJJVF9URU1QTEFURVMiO2E6MDp7fXM6MTY6IklCTE9DS19JRF9QQVJFTlQiO2k6MjY7czo5OiJJQkxPQ0tfSUQiO2k6Mjg7fQ==.cc26f4f6c6195ccf63b0d55b893d8b7ce6348f46aad5291e36ba7647a00cc2b2"
                     data-i-appeared="true">
                    <div id="table-scroller-wrapper" class="table-view js_append flexbox flexbox--row with-opt-buy ">
                        <div class="table-view__item item bordered box-shadow main_item_wrapper js-notice-block"
                             id="bx_3966226736_39685" data-id="39685" data-product_type="1">
                            <div class="table-view__item-wrapper item_info catalog-adaptive flexbox flexbox--row">
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
                                            <div class="item-title">
                                                <a
                                                        href="/catalog/mototrasport2/snow/baltmotors/snowdog/39685/"
                                                        class="dark_link js-notice-block__title"><span>Снегоход Baltmotors Snowdog</span></a>
                                            </div>
                                            <div class="item-card-location">
                                                <div class="item-card-location__city">
                                                    Минск
                                                </div>
                                                <div class="item-card-location__data">
                                                    Сегодня в 11:47
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-actions flexbox flexbox--row">
                                            <div class="product-description">
                                                <div class="product-description__left">
                                                    <div class="product-description__el">
                                                        <div class="product-description__i">72 см3</div>
                                                        <div class="product-description__i">7 л.с.</div>
                                                        <div class="product-description__i">4 такта</div>
                                                    </div>
                                                    <div class="product-description__el truncated">
                                                        <div class="product-description__i">1 цилиндр</div>
                                                        <div class="product-description__i">рядное длинное название</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-data-price">
                                                <div class="item-data-card">
                                                    <div class="item-data-card__year">
                                                        2020 г.
                                                    </div>
                                                    <div class="item-data-card__kilometer">
                                                        114 300 км
                                                    </div>
                                                </div>
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
                                                    <div class="prices-all">
                                                        <div class="prices-all__i">≈ 1800 $</div>
                                                        <div class="prices-all__i">≈ 499 000 ₽</div>
                                                        <div class="prices-all__i">≈ 304 €</div>
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
                                </div>
                            </div>
                        </div>
                        <div class="table-view__item item bordered box-shadow main_item_wrapper js-notice-block"
                             id="bx_3966226736_39685" data-id="39685" data-product_type="1">
                            <div class="table-view__item-wrapper item_info catalog-adaptive flexbox flexbox--row">
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
                                            <div class="item-title">
                                                <a
                                                        href="/catalog/mototrasport2/snow/baltmotors/snowdog/39685/"
                                                        class="dark_link js-notice-block__title"><span>Снегоход Baltmotors Snowdog</span></a>
                                            </div>
                                            <div class="item-card-location">
                                                <div class="item-card-location__city">
                                                    Минск
                                                </div>
                                                <div class="item-card-location__data">
                                                    Сегодня в 11:47
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-actions flexbox flexbox--row">
                                           <div class="product-description-text">
                                               <div class="wrapp_stockers sa_block"
                                                    data-fields="[&quot;&quot;,&quot;&quot;]" data-stores="[]"
                                                    data-user-fields="[&quot;&quot;,&quot;UF_CATALOG_ICON&quot;,&quot;&quot;]">
                                                   <div data-click="N" class="item-stock " data-id="39685"><span
                                                               class="icon stock"></span><span
                                                               class="value">Мало</span></div>
                                                   <div class="article_block" data-name="Арт." data-value="36473928">
                                                       <div class="muted">Артикул: 36473928</div>
                                                   </div>
                                               </div>
                                               <div class="product-text">
                                                   Отличное состояние. Из США. Самый модный цвет. Басовитый   состояние. Из США. Самый модный цвет. Басовитый выхлоп...
                                               </div>
                                           </div>
                                            <div class="info-data-price">
                                                <div class="item-data-card">
                                                    <div class="item-data-card__year">
                                                        2020 г.
                                                    </div>
                                                    <div class="item-data-card__kilometer">
                                                        114 300 км
                                                    </div>
                                                </div>
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
                                                    <div class="prices-all">
                                                        <div class="prices-all__i">≈ 1800 $</div>
                                                        <div class="prices-all__i">≈ 499 000 ₽</div>
                                                        <div class="prices-all__i">≈ 304 €</div>
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