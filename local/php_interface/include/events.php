<?php
AddEventHandler("main", "OnBeforeUserAdd", ["CustomEvents", "OnBeforeUserAddHandler"]);
class CustomEvents
{
    public static function OnBeforeUserAddHandler(&$arFields)
    {
        do {
            // Генерируем случайное 6-значное число
            $randomNumber = mt_rand(100000, 999999);

            // Проверяем наличие числа в базе данных
            $userExists = Bitrix\Main\UserTable::getList([
                'select' => ['ID'],
                'filter' => ['=UF_CABINET_NUMBER' => $randomNumber],
                'limit' => 1,
            ])->fetch();

        } while ($userExists);
        $arFields['UF_CABINET_NUMBER'] = $randomNumber;
        return $arFields;
    }
}
