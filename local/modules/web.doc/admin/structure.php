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
<h3 style="color: red">Если слетит после обновления аспро, то перезалить следующие файлы:</h3>
<div style="margin-bottom: 30px">
    <p>Файлы для изменения сортировки в каталоге (по дате создания):</p>
    <p>bitrix/templates/aspro_max/components/bitrix/catalog/main/lang/ru/.parameters.php - название пункта в настройках компонента</p>
    <p>bitrix/templates/aspro_max/components/bitrix/catalog/main/lang/ru/section.php - название пункта на странице каталога</p>
    <p>bitrix/templates/aspro_max/components/bitrix/catalog/main/.parameters.php - добавлен пункт для сортировки по DATE_CREATE в параметр SORT_BUTTONS</p>
    <p>bitrix/templates/aspro_max/components/bitrix/catalog/main/sort.php - добавлена логика для корректного отображения нового пункта сортировки "Дата создания" (DATE_CREATE)</p>
</div>

<div style="margin-bottom: 50px">
    Для работы функционала захода на неактивные обявления пользователем, который их создал необходимо:
    В файле <i>bitrix/templates/aspro_max/components/bitrix/catalog/main/elements.php</i> убрать подобный вызов метода process404:
    <pre>
        $arElement = CMaxCache::CIBLockElement_GetList(array('CACHE' => array("MULTI" =>"N", "TAG" => CMaxCache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), CMax::makeElementFilterInRegion($arElementFilter), false, false, array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "DETAIL_PICTURE", "PROPERTY_ASSOCIATED_FILTER", "PROPERTY_EXPANDABLES_FILTER", "PROPERTY_ASSOCIATED", "PROPERTY_EXPANDABLES"));

        if(!$arElement)
        {
            \Bitrix\Iblock\Component\Tools::process404(
                ""
                ,($arParams["SET_STATUS_404"] === "Y")
                ,($arParams["SET_STATUS_404"] === "Y")
                ,($arParams["SHOW_404"] === "Y")
                ,$arParams["FILE_404"]
            );
        }
    </pre>
</div>



<h3>Кроны</h3>
<div>
    <div style="margin-bottom: 30px">
        <p>Файл запускающий крон по отправке писем (сохраненные в фильтре поиски) находится по пути: <i>/local/php_interface/cron/filterMail.php</i> (запуск от 30 минут)</p>
        <p>Файл <i>/local/php_interface/cron/filterMail.php</i> использует метод init из класса  <i>/local/php_interface/classes/Filter.php </i></p>
    </div>
    <div>
        <p>Файл запускающий крон по обнулению счетчика за текущий день находится по пути: <i>/local/php_interface/cron/elementResetCounter.php</i> (запуск каждый день в 00:00)</p>
        <p>Файл <i>/local/php_interface/cron/elementResetCounter.php</i> использует метод resetTodayCounter из класса  <i>/local/php_interface/classes/Page.php </i></p>
    </div>
</div>



<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php"); ?>
