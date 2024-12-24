<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<div class="jqmOverlay"
     style="height: 100%; width: 100%; position: fixed; left: 0px; top: 0px; z-index: 2999; opacity: 0.5;"></div>
<div class="callback-custom_frame jqmWindow popup jqm-init scrollblock show _modal-new"
     style="z-index: 3000; opacity: 1;">
    <div>
        <a href="#"
           class="close jqmClose"><?= CMax::showIconSvg('', SITE_TEMPLATE_PATH . '/images/svg/Close.svg') ?></a>
        <div class="_form-modal">
            <div class="_form_head">
                <div class="form_head-text">
                    <?= $name ?>
                </div>
                <div class="form_head__img">
                    <img src="/upload/CMax/logo-form.png" alt="">
                </div>
            </div>
            <div class="_form-description">
                Скажите продавцу, что звоните с Bike.by.
            </div>
            <div class="_form-text">
                Если после разговора вы выяснили, что объявление неактуальное или недостоверное,
                <div class="form-popup" data-event="claim-form">сообщите нам</div>
            </div>
            <div class="_form-phone">
                <div class="_form-phone__title"><?= $name ?></div>
                <?php if (!empty($phones)): ?>
                    <div class="_form-phone__list">
                        <?php foreach ($phones as $phone): ?>
                            <div class="_form-phone__el">
                                <a href="tel:<?=$phone?>"><?=$phone?></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<script>
    $('.jqmClose').on('click', function (e) {
        e.preventDefault();
        $(this).closest('#popup_iframe_wrapper').removeAttr('style');
        $(this).closest('.callback-custom_frame').remove();
        $('.jqmOverlay').remove();
    })

    $('.form-popup').on('click', function (e) {
        $.ajax({
            url: '/ajax/form_custom.php',
            data: {type: $(this).attr('data-event'), elementId: <?=$request['elementId']?>},
            type: 'GET',
            success: function (response) {
                $('.callback-custom_frame').html(response);
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    });
    $(".jqmOverlay").on("click", function () {
        $("#popup_iframe_wrapper").css("display", "none");
        $(".callback-custom_frame").remove();
    });

</script>
