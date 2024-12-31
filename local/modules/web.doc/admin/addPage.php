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
<h2>Страница добавления объявления</h2>
<div class="point">

</div>

<p>Для отображения свойств необходимо добавить их к разделу и к необходимой “секции” на странице.</p>
<h3>Добавление к разделу</h3>
<div class="point">
    <p>
        1. Чтобы свойство стало возможным для привязки к разделу необходимо перейти в <a
                href="/bitrix/admin/cat_catalog_edit.php?lang=ru&IBLOCK_ID=26">Магазин->Каталог
            товаров->Настройки каталога->Свойства элемента</a>. В необходимом свойстве нажать кнопку “Скрыть”, после
        нажать
        “Применить” или “Сохранить”
    </p>
    <img src="/bitrix/images/web.doc/img1.png" alt="">
</div>
<div class="point">
    <p>
        2. Для добавления свойства к разделу перейти в <a
                href="/bitrix/admin/cat_section_admin.php?lang=ru&type=aspro_max_catalog&IBLOCK_ID=26&find_section_section=0&SECTION_ID=0&apply_filter=Y">
            Магазин->Каталог товаров->Разделы </a>. Выбрать необходимый раздел и нажать “Изменить”
    </p>
    <img src="/bitrix/images/web.doc/img2.png" alt="">
</div>
<div class="point">
    <p>
        3. Перейти во вкладку “Свойства элементо” и внизу списка будет поле для выбора свойств. Выбирать необходимое и
        нажать кнопку “Добавить”, а после “Применить” или “Сохранить”
    </p>
    <img src="/bitrix/images/web.doc/img3.png" alt="">
    <p class="note">
        <span class="important">****</span> Свойства необходимо привязывать именно к разделу, в которое будет делаться
        добавление. Если добавление в
        разделы типа “Мото товары” или “Услуги”, где вывод свойств зависит от выбранного раздела, то можно добавлять
        свойства в сам раздел, например, “Мотоэкипировка”, и отдельные свойства для “Мотоботы” и тп. Также в этом случае
        необходимо выбрать данные разделы в “Укажите основные характеристики”(FIELDS) в Highload-блоке “Секции в
        добавлении объявления” (Blocks).
    </p>
    <p class="note">
        <span class="important">****</span> В секции “Укажите технические данные” (TECHNICAL) будут отображаться только
        текстовые поля и отображение будет в два столбца.
    </p>
    <p class="note">
        <span class="important">****</span> При создании свойств в инфоблоке нельзя ставить галочку “Обязательно”,
        потому что оно станет таковым для всего инфоблока, а не для конкретного раздела.
    </p>
    <p class="note">
        <span class="important">****</span> Не желательно изменять символьные коды type_<i>текст</i>, year, race,
        race_unit,
        phone, country, power, length, width, height, square, color для избежания некорректной верстки
    </p>
</div>
<h3>Добавление свойств к “секции” на странице</h3>
<div class="point">
    <p>
        1. Для начала необходимо привязать секции к разделам. Для этого необходимо зайти в Highload-блоке <a
                href="/bitrix/admin/highloadblock_rows_list.php?ENTITY_ID=4&lang=ru">“Секции в
            добавлении объявления” (Blocks)</a> либо создать новую, заполнив все поля, либо изменить сущетсвующие:
    </p>
    <div class="subpoint">
        <p>a. <i>Название (UF_NAME)</i> отвечает за заголовок секции</p>
        <p>b. <i>Название (UF_SECTIONS)</i> отвечает за разделы, в которых будет отображаться секция</p>
        <p>c. <i>Название (UF_SORT)</i> отвечает за порядок секций</p>
        <p>d. <i>Название (UF_CODE)</i> отвечает за символьный код секции (нужно для разработки)</p>
        <p>e. <i>Название (UF_DESCRIPTION)</i> отвечает за описание секции (<span class="important">****</span> Данное свойство у уже существующих секций не менять)</p>
    </div>
</div>
<div class="point">
    <p>
        2. После необходимо перейти в Highload-блок <a
                href="/bitrix/admin/highloadblock_rows_list.php?ENTITY_ID=5&lang=ru">“Свойства в секциях”</a> и добавить
        необходимые свойства в “секции”.
        Свойства хранятся во множественном свойстве и вводится <span class="important">ID свойства</span>
    </p>
    <img class="smaller" src="/bitrix/images/web.doc/img4.png" alt="">
</div>
<div class="point">
    <p>
        3. Чтобы сделать свойство обязательным для определенного раздела необходимо аналогичным способом (выбрав раздел
        и задав ID необходимых свойств) добавить их в Highload-блок <a
                href="/bitrix/admin/highloadblock_rows_list.php?ENTITY_ID=7&lang=ru">“Обязательные при добавлении поля”
            (RequiredFields)</a>.
    </p>
</div>
<div class="point">
    <p>
        4. Для отображения радиокнопок вида:
    </p>
    <img class="smallest" src="/bitrix/images/web.doc/img5.png" alt="">
    <p>
        необходимо добавить ID свойства в Highload-блок <a href="/bitrix/admin/highloadblock_rows_list.php?ENTITY_ID=6&lang=ru">“Кастомные чекбоксы” (CustomCheckbox)</a>. Также данное свойство не
        должно быть множественным и иметь тип отображения “Флажки” (настройки в свойствах инфоблока).
    </p>
</div>
<div class="point">
    <p>
        5. Для отображения тегов в Описании товара необходимо в Highload-блоке <a href="/bitrix/admin/highloadblock_rows_list.php?ENTITY_ID=8&lang=ru">“Теги для описания товара” (Tags)</a> выбрать
        разделы (можно выбрать несколько) и ввести желаемые теги.
    </p>
    <img src="/bitrix/images/web.doc/img6.png" alt="">
</div>
<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php"); ?>
