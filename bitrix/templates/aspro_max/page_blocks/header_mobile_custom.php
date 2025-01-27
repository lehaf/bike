<?
global $arTheme, $arRegion;
$logoClass = ($arTheme['COLORED_LOGO']['VALUE'] !== 'Y' ? '' : ' colored');
?>
<div class="mobileheader-v1 mobileheader-v1-custom">
    <div class="burger pull-left">
        <?=CMax::showIconSvg("burger dark", SITE_TEMPLATE_PATH."/images/svg/burger.svg");?>
        <?=CMax::showIconSvg("close dark", SITE_TEMPLATE_PATH."/images/svg/Close.svg");?>
    </div>
    <div class="logo-block pull-left">
        <div class="logo<?=$logoClass?>">
            <?=CMax::ShowBufferedLogo();?>
        </div>
    </div>
    <div class="right-icons pull-right">
        <div class="wrap_icon wrap_cabinet">
            <div class="auth_wr_inner ">
                <a rel="nofollow" title="admin" class="personal-link dark-color logined" href="/personal/">
                    <i class="svg svg-inline-cabinet big inline " aria-hidden="true">
                        <svg width="17" height="19" viewBox="0 0 17 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.3078 17.6002C15.4873 17.6002 16.492 16.6559 16.2247 15.5398C15.5596 12.7632 13.3358 11.375 8.96868 11.375C4.6016 11.375 2.37772 12.7632 1.7127 15.5398C1.44535 16.6559 2.45005 17.6002 3.62954 17.6002H14.3078Z" stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.96862 8.26271C11.1043 8.26271 12.1721 7.22518 12.1721 4.63136C12.1721 2.03753 11.1043 1 8.96862 1C6.83297 1 5.76514 2.03753 5.76514 4.63136C5.76514 7.22518 6.83297 8.26271 8.96862 8.26271Z" stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </i>
                </a>
<!--                <ul class="dropdown-menu">-->
<!--                    <li class=" ">-->
<!--                        <a href="/personal/index.php" class="dark-color">Личный кабинет</a>-->
<!--                    </li>-->
<!--                    <li class=" ">-->
<!--                        <a href="/personal/private/" class="dark-color">Личные данные</a>-->
<!--                    </li>-->
<!--                    <li class=" ">-->
<!--                        <a href="/personal/change-password/" class="dark-color">Сменить пароль</a>-->
<!--                    </li>-->
<!--                    <li class=" ">-->
<!--                        <a href="/personal/subscribe/" class="dark-color">Подписки</a>-->
<!--                    </li>-->
<!--                    <li class=" ">-->
<!--                        <a href="/contacts/" class="dark-color">Контакты</a>-->
<!--                    </li>-->
<!--                    <li class=" ">-->
<!--                        <a href="/personal/favorite/" class="dark-color">Избранные товары</a>-->
<!--                    </li>-->
<!--                    <li class=" ">-->
<!--                        <a href="/?logout=yes&amp;login=yes&amp;sessid=a20b94998a47585501599adf4a36838c" class="dark-color">-->
<!--                            <i class="icons">-->
<!--                                <svg id="Exit.svg" xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9">-->
<!--                                    <path class="cls-1" d="M501.849,868.853l-2.011,1.993a0.485,0.485,0,0,1-.694,0,0.506,0.506,0,0,1,0-.707L500.293,869H494.5a0.5,0.5,0,0,1,0-1h5.826l-1.182-1.175a0.5,0.5,0,0,1,0-.7,0.487,0.487,0,0,1,.694,0l2.011,2a0.486,0.486,0,0,1,.138.365A0.492,0.492,0,0,1,501.849,868.853Zm-5.349-3.322a0.486,0.486,0,0,1-.269-0.089l-0.016.024a3.5,3.5,0,1,0,0,6.07l0,0a0.484,0.484,0,0,1,.287-0.1,0.5,0.5,0,0,1,.5.5,0.492,0.492,0,0,1-.242.418l0.008,0.012c-0.022.013-.049,0.018-0.071,0.031h0a4.434,4.434,0,0,1-2.194.6,4.5,4.5,0,1,1,0-9,4.4,4.4,0,0,1,2.057.542A0.5,0.5,0,0,1,496.5,865.531Z" transform="translate(-490 -864)"></path>-->
<!--                                </svg>-->
<!--                            </i>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                </ul>-->
            </div>
        </div>
        <a href="/add" class="add-announcement">
            <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.22545 0.847656V11.1514M11.4509 5.99951H1" stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </a>
    </div>
    <?=\Aspro\Functions\CAsproMax::showProgressBarBlock();?>
</div>