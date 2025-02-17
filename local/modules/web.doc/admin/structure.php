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
<div style="margin-bottom: 50px">
    <p>Файлы для изменения сортировки (по дате создания) в каталоге:</p>
    <p>bitrix/templates/aspro_max/components/bitrix/catalog/main/lang/ru/.parameters.php - название пункта в настройках компонента</p>
    <p>bitrix/templates/aspro_max/components/bitrix/catalog/main/lang/ru/section.php - название пункта на странице каталога</p>
    <p>bitrix/templates/aspro_max/components/bitrix/catalog/main/.parameters.php - добавлен пункт для сортировки по DATE_CREATE в параметр SORT_BUTTONS</p>
    <p>bitrix/templates/aspro_max/components/bitrix/catalog/main/sort.php - добавлена логика для корректного отображения нового пункта сортировки "Дата создания" (DATE_CREATE)</p>
</div>

<div style="margin-bottom: 50px">
    <p>Файлы для отображения фильтра по городам в каталоге шин, услуг, гаражей:</p>
    <p>bitrix/templates/aspro_max/components/bitrix/catalog/main/filter.php - генерирует путь на новый шаблон фильтра main_compact_ajax_custom</p>
</div>

<div style="margin-bottom: 50px">
    <p>Файл для изменения слова "товаров" на "объявлений" в выводе подразделов в каталоге: bitrix/templates/aspro_max/components/bitrix/catalog.section.list/sections_list/lang/ru/template.php</>
    <p>В нем изменить $MESS["COUNT_ELEMENTS_TITLE"], $MESS["COUNT_ELEMENTS_TITLE_2"], $MESS["COUNT_ELEMENTS_TITLE_3"] на необходимые значения</p>
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


<div style="margin-bottom: 50px">
    Для отображения открытого аккордиона на странице /info/faq/ при нажатии на кнопку "Регистрация как Юр. лицо" в форме авторизации:
    В файл <i>bitrix/templates/aspro_max/components/bitrix/news.list/items-list/script.js</i> добавить код:
    <pre>
        const urlObj = new URL(window.location);
        const searchParams = urlObj.searchParams;
        let accordionId = searchParams.get('tab');

        if(accordionId) {
            const accordion = document.querySelector(`.accordion-head[href='#${accordionId}']`);
            accordion?.parentElement.classList.add('opened');
            accordion?.click();
        }
    </pre>
</div>

<div style="margin-bottom: 50px">
    Для отображения текста после списка объявлений типа "Расчёты осуществляются в белорусских рублях. Сумма в иностранной валюте (после знака ≈) указана как эквивалент для определения стоимости (цены) в белорусских рублях по курсу НБРБ или определённому рекламодателем (заказчиком)." в выбранном разделе:
    В файл <i>bitrix/templates/aspro_max/components/bitrix/catalog/main/section.php</i> добавить код:
    <pre>
        @include_once($_SERVER['DOCUMENT_ROOT'] . '/include/section_info.php');
    </pre>
    после тега div, имеющего класс 'js_wrapper_items'.
</div>

<div style="margin-bottom: 50px">
    Для корректного отображения бургер-меню на десктопе (без корзины, кнопок "Заказать звонок" и "Задать вопрос", без адреса и email) необходимо перезалить файл <i>bitrix/templates/aspro_max/page_blocks/mega_menu_1.php</i> из бэкапа
</div>

<div style="margin-bottom: 50px">
    Для кастомизации карточек блока "Ранее вы смотрели" необходимо в файлу <i>include/footer/comp_viewed.php</i> установить шаблон main_horizontal_custom для компонета aspro:catalog.viewed.max (расположен в bitrix/templates/aspro_max/components/aspro/catalog.viewed.max/main_horizontal_custom/)
</div>

<h3>Кроны</h3>
<div>
    <div style="margin-bottom: 30px">
        <p>Файл запускающий крон по отправке писем (сохраненные в фильтре поиски) находится по пути: <i>/local/php_interface/cron/filterMail.php</i> (запуск от 30 минут)</p>
        <p>Файл <i>/local/php_interface/cron/filterMail.php</i> использует метод init из класса  <i>/local/php_interface/classes/Filter.php </i></p>
    </div>
    <div style="margin-bottom: 30px">
        <p>Файл запускающий крон по обнулению счетчика за текущий день находится по пути: <i>/local/php_interface/cron/elementResetCounter.php</i> (запуск каждый день в 00:00)</p>
        <p>Файл <i>/local/php_interface/cron/elementResetCounter.php</i> использует метод resetTodayCounter из класса  <i>/local/php_interface/classes/Page.php </i></p>
    </div>
    <div style="margin-bottom: 30px">
        <p>Файл запускающий крон по обновлению курса валют НЦБ находится по пути: <i>/local/php_interface/cron/updateCurrencyRates.php</i> (запуск каждый день в 00:01)</p>
        <p>Файл <i>/local/php_interface/cron/currencyRates.php</i> использует метод getCurrency из класса  <i>/local/php_interface/classes/CurrencyRates.php </i></p>
    </div>
</div>



<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php"); ?>
