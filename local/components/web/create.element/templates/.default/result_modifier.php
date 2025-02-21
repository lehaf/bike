<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
$productsSections = [TIRES_SECTION_ID, PRODUCTS_SECTION_ID, SERVICES_SECTION_ID, RENT_SECTION_ID, GARAGES_SECTION_ID];
$sections = [TRANSPORT_SECTION_ID, PARTS_SECTION_ID, $productsSections];
$arResult["CUSTOM_SECTIONS"] = [];
if (!empty($sections)) {
    foreach ($sections as $key => $section) {
        if (is_array($section)) {
            $rsSection = getSections([
                '=ID' => $section,
                'ACTIVE' => 'Y',
            ]);
            if (!empty($rsSection)) {
                foreach ($rsSection as $sect) {
                    $arResult["CUSTOM_SECTIONS"]["SECTIONS_" . $key][] = $sect;
                }
            }
        } else {
            $rsSection = getSections([
                '=IBLOCK_SECTION_ID' => $section,
                'ACTIVE' => 'Y',
            ]);

            if (!empty($rsSection)) {
                $arResult["CUSTOM_SECTIONS"]["SECTIONS_" . $key] = $rsSection;
            }
        }
    }
}

//разделение свойств по блокам
if ($_GET['type']) {
    $entity = \Bitrix\Iblock\Model\Section::compileEntityByIblock($arParams['IBLOCK_ID']);
    $arResult['SECTION_CODE'] = $entity::getList([
        'select' => ['UF_SECTION_CODE'],
        'filter' => ['=ID' => $_GET['type']]
    ])->fetch()['UF_SECTION_CODE'];

    $sectId = (!isset($arParams['PARENT_SECTION_ID'])) ? ["SECTION_ID" => $arParams['SECTION_ID']] : [
        "PARENT_SECTION_ID" => $arParams['PARENT_SECTION_ID'], "SECTION_ID" => $arParams['SECTION_ID']
    ];

    $resultFields = setBlocksFields($arResult['SHOW_FIELDS'] ?? [], $sectId);
    $arResult['SORT_SHOW_FIELDS'] = sortFields($resultFields['fields']);
    $arResult['LAST_FIELD'] = $resultFields['lastKey'];

    $entityCustomCheck = getHlblock("b_custom_check");
    $resCustomCheck = $entityCustomCheck::getList(["select" => ["UF_FIELD"]])->fetchAll();
    $arResult['CUSTOM_CHECK'] = array_column($resCustomCheck, "UF_FIELD");

    $entityTags = getHlblock("b_tags");
    $tags = $entityTags::getList([
        'filter' => ['@UF_SECTIONS' => $arParams['SECTION_ID']],
    ])->fetch();
    $arResult['TAGS'] = $tags['UF_TAGS'];

    $arResult['CATEGORIES'] = getSections([
        '=IBLOCK_ID' => $arParams['IBLOCK_ID'],
        '=IBLOCK_SECTION_ID' => $arParams['SECTION_ID'],
    ]);

    if((int)$_GET['type'] === SERVICES_SECTION_ID || (int)$_GET['type'] === PRODUCTS_SECTION_ID){
        $entity = \Bitrix\Iblock\Model\Section::compileEntityByIblock(CATALOG_IBLOCK_ID);
        $subsections = $entity::getList([
            "select" => ['ID', 'CODE', 'NAME', 'IBLOCK_SECTION_ID'],
            "filter" => [
                '=IBLOCK_SECTION_ID' => array_column($arResult['CATEGORIES'], 'ID'),
            ],
            "order" => ['SORT' => 'ASC', 'ID' => 'DESC'],
            'cache' => [
                'ttl' => 36000000,
                'cache_joins' => true
            ],
        ])->fetchAll();

        $arResult['SUBSECTIONS'] = [];
        if(!empty($subsections)){
            foreach ($subsections as $subsection) {
                if(!isset($arResult['SUBSECTIONS'][$subsection['IBLOCK_SECTION_ID']])){
                    $arResult['SUBSECTIONS'][$subsection['IBLOCK_SECTION_ID']] = [];
                }
                $arResult['SUBSECTIONS'][$subsection['IBLOCK_SECTION_ID']][] = $subsection;
            }
        }
    }



    if($arResult['SORT_SHOW_FIELDS']['PRICE']) {
        $priceTypes = ['auction', 'exchange', 'contract_price'];
        $arResult['SORT_SHOW_FIELDS']['PRICE']['PRICE_TYPE_ROW'] = array_filter($arResult['SORT_SHOW_FIELDS']['PRICE']['FIELDS'], function($value) use ($priceTypes) {
            return getPriceType($value, $priceTypes);
        });
        $arResult['SORT_SHOW_FIELDS']['PRICE']['FIELDS'] = array_filter($arResult['SORT_SHOW_FIELDS']['PRICE']['FIELDS'], function($value) use ($priceTypes) {
            return unsetPriceType($value, $priceTypes);
        });
    }


}

if(empty($arResult['ELEMENT_FIELDS'])) {
    $user = \Bitrix\Main\UserTable::getList([
        'select' => ['PERSONAL_PHONE'],
        'filter' => ['ID' => \Bitrix\Main\Engine\CurrentUser::get()->getId()],
    ])->fetch();

    $lastName = \Bitrix\Main\Engine\CurrentUser::get()->getLastName() ?? '';
    $firstName = \Bitrix\Main\Engine\CurrentUser::get()->getFirstName() ?? '';
    $secondName = \Bitrix\Main\Engine\CurrentUser::get()->getSecondName() ?? '';

    $arResult['USER_PROFILE'] = [
        'phone' => $user['PERSONAL_PHONE'] ?? '',
        'name' => $lastName . ' ' . $firstName . ' ' . $secondName,
    ];
} else {
    $arResult['USER_PROFILE'] = [
        'phone' => $arResult['ELEMENT_FIELDS']['phone'][0] ?? '',
    ];
}

if(empty($arResult['ELEMENT_COUNTRY'])) {
    $userLocation = \Bitrix\Main\UserTable::getList([
        'select' => ['UF_COUNTRY_ID', 'UF_REGION_ID', 'UF_CITY_ID'],
        'filter' => ['ID' => \Bitrix\Main\Engine\CurrentUser::get()->getId()],
    ])->fetch();
    if(!empty($userLocation['UF_COUNTRY_ID'])) {
        $id = $userLocation['UF_COUNTRY_ID'];
        $type = 'REGION';
        $arResult['REGIONS'] = getLocations($type, $id);
    }

    if(!empty($userLocation['UF_REGION_ID'])) {;
        $id = $userLocation['UF_REGION_ID'];
        $type = 'CITY';
        $arResult['CITIES'] = getLocations($type, $id);
    }

    $arResult['USER_LOCATION'] = $userLocation;
}

function getPriceType($value, $priceTypes) {
    return in_array($value['CODE'], $priceTypes);
}

function unsetPriceType($value, $priceTypes) {
    return !in_array($value['CODE'], $priceTypes);
}

?>
