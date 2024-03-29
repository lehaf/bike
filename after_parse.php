<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

use PhpOffice\PhpSpreadsheet\IOFactory;

$file = IOFactory::load("motoMini.xlsx");

$fileData = $file->getActiveSheet()->toArray();
unset($fileData[0]);

$class = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();

if (!empty($fileData)) {
    $data = [];

//    CEventLog::Add(array(
//        "SEVERITY" => "SECURITY",
//        "AUDIT_TYPE_ID" => "Начало импорта объявлений с av.by",
//        "MODULE_ID" => "iblock",
//        "ITEM_ID" => CATALOG_IBLOCK_ID,
//        "DESCRIPTION" => "Начался импорт объявлений с av.by",
//    ));

    foreach ($fileData as $row) {
        if (!isset($data[$row[1]])) {
            $data[$row[1]] = [];
        }

        if (!isset($data[$row[1]][$row[3]])) {
            $data[$row[1]][$row[3]] = [];
        }

        if (!isset($data[$row[1]][$row[3]][$row[4]])) {
            $data[$row[1]][$row[3]][$row[4]] = [$row];
        } else {
            $data[$row[1]][$row[3]][$row[4]][] = $row;
        }
    }


    if (!empty($data)) {

        $allElements = $class::getList([
            "filter" => ["!=IS_AV.VALUE" => false],
            "select" => ["number", "ID"]
        ])->fetchCollection();

        if(!$allElements->isEmpty()) {
            foreach ($allElements as $elem) {
                $siteElementsNumbers[$elem->getId()] = $elem->getNumber()->getValue();
            }
        }

        foreach ($data as $key => &$value) {

            $sectionId = \Bitrix\Iblock\SectionTable::getList([
                "select" => ["ID"],
                "filter" => ["=CODE" => $key],
            ])->fetchObject()->getId();



            $subSections = array_keys($value);
            $rsSection = \Bitrix\Iblock\SectionTable::getList([
                "filter" => [
                    "=IBLOCK_ID" => CATALOG_IBLOCK_ID,
                    "=IBLOCK_SECTION_ID" => $sectionId,
                    "=NAME" => $subSections,
                ],
                "select" => ["ID", "NAME"],
            ])->fetchCollection();

            if (!empty($rsSection)) {
                foreach ($rsSection as $sect) {
                    $subSections1 = array_keys($value[$sect->getName()]);
                    $rsSubSection = \Bitrix\Iblock\SectionTable::getList([
                        "filter" => [
                            "=IBLOCK_ID" => CATALOG_IBLOCK_ID,
                            "=IBLOCK_SECTION_ID" => $sect->getId(),
                            "=NAME" => $subSections1,
                        ],
                        "select" => ["ID", "NAME"],
                    ])->fetchCollection();

                    foreach ($rsSubSection as $subSect) {

                        foreach ($value[$sect->getName()][$subSect->getName()] as &$val) {
                            $val["SECTION_ID"] = $subSect->getId();

                            if(!in_array($val[2], $siteElementsNumbers)) {
                                $addElements[] = setElementsProps($val);
                            }

                            $fileElementsNumbers[] = $val[2];
                        }
                    }
                }

            }
        }

        foreach ($siteElementsNumbers as $elemId => $elemNum) {
            if(!in_array($elemNum, $fileElementsNumbers)) {
                $delElements[] = $elemId;
            }
        }

        if(!empty($addElements)) {

            $userProps = getUserProps();

            foreach ($addElements as $elem) {

                if(!empty($elem[18])) {
                    $images = explode("||", $elem[18]);
                    foreach ($images as $img) {
                        $arFile = \CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]. "/photo/" . $img);
//                        vr($arFile);
//                        $fileId = \CFile::SaveFile($arFile, "iblock");
                    }
                }

//                vr($elemProps);
            }
        }

//        vr(["site" => $siteElementsNumbers]);
//        vr(["file" => $fileElementsNumbers]);
        vr($addElements);
//        vr($delElements);
//        vr($addElements);
    }
}

function getUserProps() : array {
    $res = \Bitrix\Iblock\PropertyTable::getList([
        "filter" => ["=IBLOCK_ID" => CATALOG_IBLOCK_ID, "=ACTIVE" => "Y"],
        "select" => ["CODE", "MULTIPLE", "PROPERTY_TYPE"]
    ])->fetchAll();

    if (!empty($res)) {
        foreach ($res as $prop) {
            $userProps[$prop["CODE"]] = $prop;
        }
    }

    return $userProps ?? [];
}

function setElementsProps($elem) : array {
//    vr($elem);
    $sectionName = \Bitrix\Iblock\SectionTable::getList([
        "select" => ["NAME"],
        "filter" => ["=CODE" => $elem[1]],
    ])->fetchObject()->getName();

    $sectionName = mb_substr($sectionName,0,-1);

    $images = explode("||", $elem[18]);
    $previewImg = $images[0];
    unset($images[0]);

    $elemProps = [
        "NAME" => "$sectionName $elem[3] $elem[4]",
        "MORE_PHOTO" => $images,
        "PREVIEW_IMAGE" => $previewImg,
        "DETAIL_IMAGE" => $previewImg,
        "DETAIL_TEXT" => $elem[19],
        "IBLOCK_SECTION_ID" => $elem["SECTION_ID"],

        "type_" . $elem[1] => $elem[10], // тип (надо создать)
        "complect_" . $elem[1] => "", // комплектация (надо создать)
        "motor_type_" . $elem[1] => "", // такт
        "cylinder_count_" . $elem[1]=> "", // количество цилиндров
        "count_door_" . $elem[1] => "", //цепь

        "number" => $elem[2], // номер объявления
        "year" => $elem[5], // год
        "power" => $elem[6], // объем двигателя
        "race" => $elem[11], // пробег
        "basket" => $elem[12], // единицы
        "CITY" => $elem[14], // город
        "city_other" => $elem[15], // район
        "phone" => $elem[16], // телефон
        "contact_person" => $elem[17], // имя
    ];

    return $elemProps ?? [];
}