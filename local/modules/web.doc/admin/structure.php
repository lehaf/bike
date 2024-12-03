<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");

/** @global object $USER */

/** @global object $APPLICATION */

use Bitrix\Main\Loader;

$mid = 'web.doc';
if (!$USER->IsAdmin() || !Loader::includeModule($mid)) return;
$APPLICATION->SetAdditionalCSS("/bitrix/css/" . $mid . "/style.css");
?>
<h2>Структура файлов</h2>
<div class="point">

</div>
<p>Файл запускающий крон по отправке писем находится по пути: <i>/local/php_interface/cron/filterMail.php</i></p>
<p>Файл с кодом для крона расположен в <i>/local/php_interface/classes/Filter.php</i></p>


<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php"); ?>
