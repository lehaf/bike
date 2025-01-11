<?php
if (file_exists(__DIR__.'/vendor/autoload.php')) require_once __DIR__.'/vendor/autoload.php';
\Bitrix\Main\Loader::registerAutoLoadClasses(null, [
    'classes\Filter' => '/local/php_interface/classes/Filter.php',
    'classes\Page' => '/local/php_interface/classes/Page.php'
]);

if (file_exists(__DIR__.'/include/constants.php')) require_once __DIR__.'/include/constants.php';
if (file_exists(__DIR__.'/include/functions.php')) require_once __DIR__.'/include/functions.php';
if (file_exists(__DIR__.'/include/constants.php')) require_once __DIR__.'/include/events.php';

