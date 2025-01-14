<?php

use Bitrix\Iblock\SectionTable;

AddEventHandler("main", "OnBeforeUserAdd", ["CustomEvents", "OnBeforeUserAddHandler"]);
//AddEventHandler("iblock", "OnBeforeIBlockSectionAdd", ["CustomEvents", "OnBeforeIBlockSectionAddHandler"]);
//AddEventHandler("iblock", "OnBeforeIBlockSectionUpdate", ["CustomEvents", "OnBeforeIBlockSectionUpdateHandler"]);
AddEventHandler("main", "OnBeforeUserUpdate", Array("CustomEvents", "OnBeforeUserUpdateHandler"));
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

    public static function OnBeforeIBlockSectionAddHandler(&$arFields)
    {
        $entity = \Bitrix\Iblock\Model\Section::compileEntityByIblock(CATALOG_IBLOCK_ID);
        $parentSection = $entity::getList([
            'filter' => ['ID' => $arFields['IBLOCK_SECTION_ID']],
            'select' => ['ID', 'UF_PARTS_SECTION']
        ])->fetch();

        if (!empty($parentSection['UF_PARTS_SECTION'])) {
            $bs = new CIBlockSection();
            $fields = [
                "ACTIVE" => "Y", // Активность раздела
                "IBLOCK_ID" => CATALOG_IBLOCK_ID, // ID инфоблока
                "NAME" => $arFields['NAME'], // Название нового раздела
                "CODE" => $arFields['CODE'],
                "UF_IMG" => $arFields['UF_IMG'],
                "IBLOCK_SECTION_ID" => $parentSection['UF_PARTS_SECTION'],// ID родительского раздела
            ];
            $sectionId = $bs->Add($fields);
            if ($sectionId) {
                \Bitrix\Main\Diag\Debug::dumpToFile($sectionId);

                $arFields['UF_PARTS_SECTION'] = $sectionId;
            }
        }
//        \Bitrix\Main\Diag\Debug::dumpToFile($parentSection);
    }

    public static function OnBeforeIBlockSectionUpdateHandler(&$arFields)
    {
        if (!empty($arFields['UF_PARTS_SECTION'])) {
            $bs = new CIBlockSection();
            $fields = [
                "NAME" => $arFields['NAME'], // Название нового раздела
                "CODE" => $arFields['CODE'],
                "UF_IMG" => $arFields['UF_IMG'],
            ];
            $bs->Update($arFields['UF_PARTS_SECTION'], $fields);
        }
//        \Bitrix\Main\Diag\Debug::dumpToFile($parentSection);
    }

    public static function OnBeforeUserUpdateHandler(&$arFields) {
        $user = \Bitrix\Main\UserTable::getList([
            'filter' => ['ID' => $arFields['ID']],
            'select' => ['UF_BRAND_ID'],
            'limit' => 1,
        ])->fetch();

        $previousBrandId = $user['UF_BRAND_ID'];
        $newBrandId = $arFields['UF_BRAND_ID'];

        if((!empty($newBrandId) && empty($previousBrandId)) || (!empty($previousBrandId) && empty($newBrandId))) {
            $property = \Bitrix\Iblock\PropertyTable::getList([
                'filter' => [
                    'IBLOCK_ID' => CATALOG_IBLOCK_ID,
                    'CODE' => 'saller',
                ],
                'select' => ['ID'],
            ])->fetch();
            $userType = (empty($newBrandId)) ? 'fis' : 'legal';

            if($property['ID']) {
                $entityIblock = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();
                $elements = $entityIblock::getList([
                    'select' => ['ID'],
                    'filter' => ['USER.VALUE' => $arFields['ID']]
                ])->fetchCollection();
                $enum = \Bitrix\Iblock\PropertyEnumerationTable::getList([
                    'filter' => [
                        'PROPERTY_ID' => $property['ID'],
                        'XML_ID' => $userType,
                    ],
                    'select' => ['ID'],
                ])->fetch();

                foreach ($elements as $element) {
                    $element->setSaller($enum['ID']);
                    $element->setBrand($arFields['UF_BRAND_ID']);
                    $element->save();
                }
            }
        }
    }
}
