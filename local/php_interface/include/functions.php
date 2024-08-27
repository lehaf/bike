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
    $sections = \Bitrix\Iblock\SectionTable::getList([
        'filter' => $filter,
        'select' => ['ID', 'CODE', 'NAME', 'PICTURE'],
        'cache' => [
            'ttl' => 36000000,
            'cache_joins' => true
        ],
    ])->fetchAll();

    if (!empty($sections)) {
        foreach ($sections as &$row) {
            if (!empty($row['PICTURE'])) {
                $row['PICTURE'] = CFile::GetPath($row['PICTURE']);
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
//    pr($arResult['SORT_SHOW_FIELDS']);
    foreach ($showFields as $block => &$item) {
        if (isset($item['FIELDS']) && is_array($item['FIELDS'])) {
            usort($item['FIELDS'], 'compareBySort');
        }

        $fieldsCode = array_column($item["FIELDS"], 'CODE');

        if (in_array('length', $fieldsCode) && in_array('height', $fieldsCode) && $block !== 'TECHNICAL') {
            foreach ($item['FIELDS'] as $key => &$field) {
                if ($field['CODE'] == 'length' || $field['CODE'] == 'high') {
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