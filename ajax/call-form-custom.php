<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<div class="jqmOverlay" style="height: 100%; width: 100%; position: fixed; left: 0px; top: 0px; z-index: 2999; opacity: 0.5;"></div>
<div class="callback-custom_frame jqmWindow popup jqm-init scrollblock show" style="z-index: 3000; opacity: 1;">
    <div>
        <a href="#"
           class="close jqmClose"><?= CMax::showIconSvg('', SITE_TEMPLATE_PATH . '/images/svg/Close.svg') ?></a>
        <div class="form">
            <div class="form_head">
                <h2>Имя и фамилия продавца / название компании</h2>
            </div>
            <div class="form_result success">
                <p>content</p>
                <div class="form-popup" data-event="claim-form" >ссылка на форму</div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.jqmClose').on('click', function (e) {
        e.preventDefault();
        $(this).closest('#popup_iframe_wrapper').removeAttr('style');
        $(this).closest('.callback-custom_frame').remove();
        $(this).closest('.jqmOverlayCustom').remove();
    })
    // $(document).on('click', '.jqmOverlay', function (e) {
    //     e.preventDefault();
    //     $(this).closest('#popup_iframe_wrapper').removeAttr('style');
    //     $('.callback-custom_frame').remove();
    //     $(this).remove();
    // })

    $('.form-popup').on('click', function(e){
        $.ajax({
            url: '/ajax/form_custom.php',
            data: {type: $(this).attr('data-event')},
            type: 'GET',
            success: function(response){
                $('.callback-custom_frame').html(response);
            },
            error: function(xhr, status, error){
                console.log(error);
            }
        });
    });
</script>
