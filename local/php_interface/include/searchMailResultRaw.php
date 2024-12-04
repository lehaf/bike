<?php ob_start(); ?>
    <tr>
        <td align="left"
            style="padding-top:24px; width: 150px; height:120px; padding-bottom: 20px; border-bottom: solid 1px #e3e3e3">
            <a href="<?=$element['url']?>"
               style="text-decoration:none; display:block; height: inherit"
               target="_blank"
            >
                <img src="<?= $element['img'] ?>"
                     width="100%"
                     style="width:100%;max-width:100%;border-radius:6px; height: 100%"
                     alt="Фотография модели"
                     border="0">
            </a>
        </td>
        <td align="right" valign="top"
            style="font-family:Helvetica,sans-serif;line-height:100%;color:#000000;text-align:left;padding-top:20px; padding-left: 10px; padding-bottom: 20px; border-bottom: solid 1px #e3e3e3">
            <div style="font-size:22px; margin-bottom: 10px; font-weight:bold;">
                <a href="<?=$element['url']?>"
                   style="color:#dc2f2f;text-decoration:none; line-height:150%"
                   target="_blank"
                >
                    <?= $element['name'] ?>
                </a>
            </div>
            <div style="font-size:20px;font-weight:bold;margin-bottom:20px">
                <?= $element['price']['BYN'] ?><span
                        style="font-size:18px;font-weight:normal">≈ <?= $element['price']['USD'] ?></span>
            </div>
            <?php if (!empty($element['props'])): ?>

                <div style="font-size:16px;line-height:115%;color:#707070;text-align:left;">
                    <?=$element['props']?>
                </div>
            <?php endif; ?>
            <div style="font-size:16px;font-weight:bold;line-height:16px;text-align:left;padding-top:5px">
                <?= $element['city'] ?>
            </div>
        </td>
    </tr>

<?php return ob_get_clean(); ?>