<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
ini_set('max_execution_time', 123456);
use PhpOffice\PhpSpreadsheet\IOFactory;
use Bitrix\Iblock\PropertyEnumerationTable;
$file = IOFactory::load("parts.xlsx");

$fileData = $file->getSheet(1)->toArray();
$newFileData = array_filter($fileData, function ($item) {
    return $item[2];
});

$propertyId = 8145;

$enumValues = PropertyEnumerationTable::getList([
    'filter' => ['PROPERTY_ID' => $propertyId],
    'select' => ['ID']
]);

// Удаляем старые значения
while ($enum = $enumValues->fetch()) {
    $deleteResult = PropertyEnumerationTable::delete(['ID' => $enum['ID'], 'PROPERTY_ID' => $propertyId]);
    if (!$deleteResult->isSuccess()) {
        echo "Ошибка удаления ID " . $enum['ID'] . ": " . implode(", ", $deleteResult->getErrorMessages()) . "\n";
    }
}

$sort = 10;
foreach ($newFileData as $value) {
    $result = PropertyEnumerationTable::add([
        'PROPERTY_ID' => $propertyId,
        'VALUE' => $value[2],
        'SORT' => $sort,
        'XML_ID' => md5($value[2])
    ]);

    if ($result->isSuccess()) {
        $sort += 10;
        echo "Добавлено: $value[2]" . '<br>';
    } else {
        echo "Ошибка при добавлении: " . implode(", ", $result->getErrorMessages()) . "<br>";
    }
}
pr($propValue);

$class = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();




