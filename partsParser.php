<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Iblock\SectionTable;
Bitrix\Main\Loader::includeModule("iblock");

$transportSectionId = 9007;
$partsSectionId = 10688;
$markModelArray = getStructuredArray($transportSectionId);
$bs = new CIBlockSection();
//
if(!empty($markModelArray)) {
    foreach ($markModelArray as $markData) {
        $fields = [
            "ACTIVE" => $markData['ACTIVE'], // Активность раздела
            "IBLOCK_ID" => CATALOG_IBLOCK_ID, // ID инфоблока
            "NAME" => $markData['NAME'], // Название нового раздела
            "CODE" => $markData['CODE'],
            "UF_POPULAR" => $markData['UF_POPULAR'],
            "UF_IMG" => $markData['UF_IMG'],
            "IBLOCK_SECTION_ID" => $partsSectionId, // ID родительского раздела
        ];
        $sectionId = $bs->Add($fields);

        if ($sectionId) {
            $bs->Update($markData['ID'], ['UF_PARTS_SECTION' => $sectionId]);
            if(!empty($markData['MODELS'])) {
                foreach ($markData['MODELS'] as $modelId => $model) {
                    $fields = [
                        "ACTIVE" => $model['ACTIVE'], // Активность раздела
                        "IBLOCK_ID" => CATALOG_IBLOCK_ID, // ID инфоблока
                        "NAME" => $model['NAME'], // Название нового раздела
                        "CODE" => $model['CODE'],
                        "IBLOCK_SECTION_ID" => $sectionId, // ID родительского раздела
                    ];
                    $subsectionId = $bs->Add($fields);
                    if ($subsectionId) {
                        $bs->Update($modelId, ['UF_PARTS_SECTION' => $subsectionId]);
                    }
                }
            }
        }
    }
}

function getStructuredArray($parentSectionId) {
    $result = [];

    // Получаем все подразделы указанного раздела
    $entity = \Bitrix\Iblock\Model\Section::compileEntityByIblock(CATALOG_IBLOCK_ID);
    $subSections = $entity::getList([
        'filter' => [
            'IBLOCK_SECTION_ID' => $parentSectionId,
        ],
        'select' => ['ID', 'ACTIVE', 'NAME', 'CODE', 'UF_POPULAR', 'UF_IMG'],
        'order' => ['SORT' => 'ASC'],
    ]);

    while ($subSection = $subSections->fetch()) {
        $markId = $subSection['ID'];
        $markName = $subSection['NAME'];
        $markActive = $subSection['ACTIVE'];
        $markCode = $subSection['CODE'];
        $markPopular = $subSection['UF_POPULAR'];
        $markImg = $subSection['UF_IMG'];

        // Получаем вложенные подразделы для текущего подраздела
        $models = $entity::getList([
            'filter' => [
                'IBLOCK_SECTION_ID' => $markId,
                'ACTIVE' => 'Y',
            ],
            'select' => ['ID', 'ACTIVE', 'NAME', 'CODE'],
            'order' => ['SORT' => 'ASC'],
        ]);

        $modelArray = [];
        while ($model = $models->fetch()) {
            $modelArray[$model['ID']] = [
                'ACTIVE' => $model['ACTIVE'],
                'NAME' => $model['NAME'],
                'CODE' => $model['CODE']
            ];
        }
        $result[] = [
            "ID" => $markId,
            "ACTIVE" => $markActive,
            "NAME" => $markName,
            "CODE" => $markCode,
            "UF_POPULAR" => $markPopular,
            "UF_IMG" => $markImg,
            "MODELS" => $modelArray,
        ];
    }

    return $result;
}

