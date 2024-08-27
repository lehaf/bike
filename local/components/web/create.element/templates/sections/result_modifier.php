<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
$productsSections = [PRODUCTS_SECTION_ID, TIRES_SECTION_ID, SERVICES_SECTION_ID, GARAGES_SECTION_ID];
$sections = [TRANSPORT_SECTION_ID, PARTS_SECTION_ID, $productsSections];
$arResult["CUSTOM_SECTIONS"] = [];
if (!empty($sections)) {
    foreach ($sections as $key => $section) {
        if (is_array($section)) {
            $rsSection = getSections([
                '=IBLOCK_ID' => CATALOG_IBLOCK_ID,
                '=ID' => $section,
            ]);
            if (!empty($rsSection)) {
                foreach ($rsSection as $sect) {
                    $arResult["CUSTOM_SECTIONS"]["SECTIONS_" . $key][] = $sect;
                }
            }
        } else {
            $rsSection = getSections([
                '=IBLOCK_ID' => CATALOG_IBLOCK_ID,
                '=IBLOCK_SECTION_ID' => $section,
            ]);

            if (!empty($rsSection)) {
                $arResult["CUSTOM_SECTIONS"]["SECTIONS_" . $key] = $rsSection;
            }
        }
    }
}
?>
