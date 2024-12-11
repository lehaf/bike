<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
?>
<?php
use classes\Page;

$filter = new Page();
$filter->resetTodayCounter();
?>

