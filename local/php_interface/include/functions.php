<?php
function pr($o, $show = false, $die = false, $fullBackTrace = false)
{
    global $USER;
//    if ($USER->IsAdmin() && $USER -> GetId() == 1100 || $show) {
    if ($USER->IsAdmin() || $show) {
        $bt = debug_backtrace();

        $firstBt = $bt[0];
        $dRoot = $_SERVER["DOCUMENT_ROOT"];
        $dRoot = str_replace("/", "\\", $dRoot);
        $firstBt["file"] = str_replace($dRoot, "", $firstBt["file"]);
        $dRoot = str_replace("\\", "/", $dRoot);
        $firstBt["file"] = str_replace($dRoot, "", $firstBt["file"]);
        ?>
        <div style='font-size:9pt; color:#000; background:#fff; border:1px dashed #000;'>
            <div style='padding:3px 5px; background:#99CCFF;'>

                <? if ($fullBackTrace == false): ?>
                    File: <b><?= $firstBt["file"] ?></b> [line: <?= $firstBt["line"] ?>]
                <? else: ?>
                    <? foreach ($bt as $value): ?>
                        <?
                        $dRoot = str_replace("/", "\\", $dRoot);
                        $value["file"] = str_replace($dRoot, "", $value["file"]);
                        $dRoot = str_replace("\\", "/", $dRoot);
                        $value["file"] = str_replace($dRoot, "", $value["file"]);
//                        echo '<pre>';
//                        print_r($value);
//                        echo '</pre>';
                        ?>

                        File:
                        <b><?= $value["file"] ?></b> [line: <?= $value["line"] ?>] <?= $value['class'] . '->' . $value['function'] . '()' ?>
                        <br>
                    <? endforeach ?>
                <? endif; ?>
            </div>
            <pre style='padding:10px;'><? is_array($o) ? var_dump($o) : var_dump(htmlspecialcharsbx($o)) ?></pre>
        </div>
        <? if ($die == true) {
            die();
        } ?>
        <?
    } else {
        return false;
    }
}

function getSections(array $filter): array
{
    $entity = \Bitrix\Iblock\Model\Section::compileEntityByIblock(CATALOG_IBLOCK_ID);
    $sections = $entity::getList([
        "select" => ['ID', 'CODE', 'NAME', 'UF_IMG'],
        "filter" => $filter,
        "order" => ['SORT' => 'ASC'],
        'cache' => [
            'ttl' => 36000000,
            'cache_joins' => true
        ],
    ])->fetchAll();

    if (!empty($sections)) {
        foreach ($sections as &$row) {
            if (!empty($row['UF_IMG'])) {
                $row['PICTURE'] = CFile::GetPath($row['UF_IMG']);
            }
        }
        unset($row);
    }

    return $sections;
}

function getHlblock(string $name): string
{
    $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList([
        "filter" => ['TABLE_NAME' => $name],
    ])->fetch();

    $entity_data_class = '';
    if (isset($hlblock['ID'])) {
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();
    }

    return $entity_data_class;
}

function setBlocksFields(array $showFields, array $sectId): array
{
    $entityBlocks = getHlblock("b_blocks");
    $resBlocks = $entityBlocks::getList([
        'order' => ['UF_SORT' => 'ASC']
    ])->fetchAll();
    $sortShowFields = [];
    $lastFieldKey = null;
    $tmpLastKey = null;

    if (!empty($resBlocks)) {
        foreach ($resBlocks as $block) {
            $tmpLastKey = $block["UF_CODE"];
            if (in_array($sectId['SECTION_ID'], $block["UF_SECTIONS"])) {
                $sortShowFields[$block["UF_CODE"]] = [
                    'NAME' => $block["UF_NAME"],
                    'DESCRIPTION' => $block["UF_DESCRIPTION"],
                    'FIELDS' => [],
                ];

                $entityFields = getHlblock("b_fields_blocks");
                $fields = $entityFields::getList([
                    'filter' => ['=UF_BLOCK' => $block['ID']],
                    'select' => ['UF_FIELDS'],
                ])->fetch();


                if (!empty($fields['UF_FIELDS']) && !empty($showFields)) {
                    $lastFieldKey = $block["UF_CODE"];
                    foreach ($showFields as $field) {
                        if (in_array($field['ID'], $fields['UF_FIELDS'])) {
                            $sortShowFields[$block["UF_CODE"]]['FIELDS'][] = $field;
                        }
                    }
                }
            }
        }
    }
    $lastFieldKey = ($tmpLastKey === $lastFieldKey) ? $lastFieldKey : $tmpLastKey;

    return ['lastKey' => $lastFieldKey, 'fields' => $sortShowFields];
}

function sortFields(array $showFields): array
{
    $pairFields = [];

    foreach ($showFields as $block => &$item) {
        $fieldsCode = array_column($item["FIELDS"], 'CODE');

        if (in_array('length_tire', $fieldsCode) && in_array('height_tire', $fieldsCode) && $block !== 'TECHNICAL') {
            foreach ($item['FIELDS'] as $key => &$field) {
                if ($field['CODE'] == 'length_tire' || $field['CODE'] == 'height_tire') {
                    $pairFields[$field['CODE']] = $field;
                    unset($item['FIELDS'][$key]);
                }
            }
            unset($field);
            $item['FIELDS'] = array_merge(['pair_param' => $pairFields], $item['FIELDS']);
        }

        if (in_array('race', $fieldsCode) && in_array('power', $fieldsCode) && in_array('race_unit', $fieldsCode)) {
            foreach ($item['FIELDS'] as $key => &$field) {
                if ($field['CODE'] == 'race' || $field['CODE'] == 'power' || $field['CODE'] == 'race_unit') {
                    $pairFields[$field['CODE']] = $field;
                    unset($item['FIELDS'][$key]);
                }
            }
            unset($field);

            //установление на вторую позицию в массиве
            $item['FIELDS'] = array_merge(
                array_slice($item['FIELDS'], 0, 1, true),
                ['pair_race' => $pairFields],
                array_slice($item['FIELDS'], 1, null, true)
            );
        }

        if ($block === 'TECHNICAL') {
            $item['FIELDS'] = array_chunk($item['FIELDS'], 2);
        }
    }
    unset($item);
    return $showFields;
}

function getPluralForm(int $number, array $forms)
{
    $number = abs($number) % 100;
    if ($number >= 11 && $number <= 19) {
        return $forms[2];
    }
    $remainder = $number % 10;
    if ($remainder == 1) {
        return $forms[0];
    }
    if ($remainder >= 2 && $remainder <= 4) {
        return $forms[1];
    }

    return $forms[2];
}

function convertDate(string $date, bool $withTime = false): string
{
    $dateTime = new DateTime($date);

    $months = [
        1 => 'января',
        2 => 'февраля',
        3 => 'марта',
        4 => 'апреля',
        5 => 'мая',
        6 => 'июня',
        7 => 'июля',
        8 => 'августа',
        9 => 'сентября',
        10 => 'октября',
        11 => 'ноября',
        12 => 'декабря'
    ];

    $today = new DateTime();
    $yesterday = (clone $today)->modify('-1 day');

    if ($dateTime->format('Y-m-d') === $today->format('Y-m-d')) {
        $dayMonth = 'сегодня';
    } elseif ($dateTime->format('Y-m-d') === $yesterday->format('Y-m-d')) {
        $dayMonth = 'вчера';
    } else {
        $day = $dateTime->format('j');
        $month = $months[(int)$dateTime->format('n')];
        $dayMonth = $day . ' ' . $month;
    }

    $time = $dateTime->format('H:i');

    return ($withTime) ? ($dayMonth . ' в ' . $time) : ($dayMonth);
}

function getItemPrices(array $arResult)
{
    $itemsId = array_column($arResult['ITEMS'], 'ID');
    $baseCurrency = \Bitrix\Currency\CurrencyManager::getBaseCurrency();
    $currencies = \Bitrix\Currency\CurrencyTable::getList([
        'select' => ['CURRENCY'],
        'order' => ['SORT' => 'ASC'],
    ])->fetchAll();

    $desiredCurrencies = array_column($currencies, 'CURRENCY');

    $prices = \Bitrix\Catalog\PriceTable::getList([
        'filter' => [
            '=PRODUCT_ID' => $itemsId,
            '=CATALOG_GROUP_ID' => 1,
            '>PRICE' => 0
        ],
        'select' => ['PRODUCT_ID', 'PRICE', 'CURRENCY']
    ])->fetchAll();

    $pricesByProductId = [];
    if (!empty($prices)) {
        foreach ($prices as $priceData) {
            $pricesByProductId[$priceData['PRODUCT_ID']] = $priceData;
        }
    }

    return ["desired" => $desiredCurrencies, "base" => $baseCurrency, "prices" => $pricesByProductId];
}

function convertPrice(array $itemPrices, array $desiredCurrencies, string $baseCurrency): array
{
    $basePrice = $itemPrices['PRICE'];
    $convertBaseCurrency = $itemPrices['CURRENCY'];
    $pricesInCurrencies = [];
    foreach ($desiredCurrencies as $currency) {
        if (!isset($pricesInCurrencies[$currency])) {
            $convertedPrice = \CCurrencyRates::ConvertCurrency($basePrice, $convertBaseCurrency, $currency);
            $formattedPrice = \CCurrencyLang::CurrencyFormat($convertedPrice, $currency, true);

            if ($currency === $baseCurrency) {
                $pricesInCurrencies['BASE'] = $formattedPrice;
            } else {
                $pricesInCurrencies['CONVERT'][$currency] = $formattedPrice;
            }
        }
    }

    return $pricesInCurrencies ?? [];
}