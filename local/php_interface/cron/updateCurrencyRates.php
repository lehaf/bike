<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
?>
<?php
use classes\CurrencyRates;

$rates = new CurrencyRates();
$rates->getCurrency();
?>

