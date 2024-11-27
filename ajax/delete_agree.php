<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="jqmOverlay"
     style="height: 100%; width: 100%; position: fixed; left: 0px; top: 0px; z-index: 2999; opacity: 0.5;"></div>
<div class="delete_frame jqmWindow popup jqm-init scrollblock" style="z-index: 3000; opacity: 1;">
    <div>
        <a class="close jqmClose" href="#"><?= CMax::showIconSvg('', SITE_TEMPLATE_PATH . '/images/svg/Close.svg') ?>
        </a>
        <div class="form ASK ">
            <div class="form_head">
                <h2>Хотите удалить объявление?</h2>
            </div>
            <div class="form_result">
<!--                --><?php //= CMax::showIconSvg(' colored', SITE_TEMPLATE_PATH . '/images/svg/success.svg') ?>
<!--                <span class="success_text">-->
<!--					Обявление будет доступно после проверки модератора-->
<!--        </span>-->
                <div class="close-btn-wrapper">
                    <a class="btn btn-default btn-lg jqmClose has-ripple btn-del" href="#">Удалить</a>
                    <a class="btn btn-default btn-lg jqmClose has-ripple" href="#">Отмена</a>
                </div>
            </div>
        </div>
    </div>
</div>