<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$iblockClass = \Bitrix\Iblock\Iblock::wakeUp($_POST['iblock'])->getEntityDataClass();
$result = [];

if (isset($_POST['action']) && isset($_POST['elementsId'])) {
    switch ($_POST['action']) {
        case 'photos' :
            $imagesPathIds = [];
            $element = $iblockClass::getList([
                'filter' => ['ID' => $_POST['elementsId']],
                'select' => ['MORE_PHOTO', 'PREVIEW_PICTURE']
            ])->fetchObject();

            $imagesPathIds[] = $element->getPreviewPicture();
            foreach ($element->getMorePhoto()->getAll() as $photo) {
                $imagesPathIds[] = $photo->getValue();
            }

            \Bitrix\Main\Diag\Debug::dumpToFile($imagesPathIds);

            if (!empty($imagesPathIds)) {
                foreach ($imagesPathIds as $id) {
                    $result[] = \CFile::GetPath($id);
                }
            }
            break;
        case 'delete':
            $delPhotos = [];
            $element = $iblockClass::getList([
                'filter' => ['ID' => $_POST['elementsId']],
                'select' => ['MORE_PHOTO', 'PREVIEW_PICTURE']
            ])->fetchCollection();

            foreach ($element as $item) {
                foreach ($item->getMorePhoto()->getAll() as $photo) {
                    $delPhotos[] = $photo->getValue();
                }
                $delPhotos[] = $item->getPreviewPicture();
            }

            if (!empty($delPhotos)) {
                foreach ($delPhotos as $photo) {
                    \CFile::Delete($photo);
                }
            }

            if (!empty($_POST['elementsId'])) {
                foreach ($_POST['elementsId'] as $elementId) {
                    $iblockClass::delete($elementId);
                }
            }

            $result = ['success' => true];
            break;
        case 'category':
            $edit = \Bitrix\Iblock\ElementTable::updateMulti(
                $_POST['elementsId'],
                [
                    'IBLOCK_SECTION_ID' => $_POST['section'],
                ]
            );
            break;
        case 'price':
            if (!empty($_POST['elementsId']) && !empty($_POST['price'])) {
                foreach ($_POST['elementsId'] as $elementId) {
                    $existingPrice = \Bitrix\Catalog\PriceTable::getList([
                        'filter' => [
                            'PRODUCT_ID' => $elementId,
                            'CATALOG_GROUP_ID' => 1,
                        ],
                    ])->fetch();

                    if ($existingPrice) {
                        \Bitrix\Catalog\PriceTable::update($existingPrice['ID'], [
                            'PRICE' => $_POST['price']
                        ]);
                    }
                }
            }
            break;
        case 'pause':
        case 'active':
            $result += ['status' => $_POST['action']];
            $btnHtml = '';
            $active = true;

            if ($_POST['action'] === 'pause') {
                $result += [
                    'statusText' => 'Не опубликовано',
                    'statusDesc' => 'На паузе',
                    'btnText' => 'Опубликовать'
                ];
                $active = false;
            }

            if ($_POST['action'] == 'active') {
                $result += [
                    'statusText' => 'Опубликовано',
                    'statusDesc' => 'На проверке у модератора',
                    'btnText' => 'На паузу'
                ];
            }

            if (!empty($_POST['elementsId'])) {
                $edit = \Bitrix\Iblock\ElementTable::updateMulti(
                    $_POST['elementsId'],
                    [
                        'ACTIVE' => $active,
                        'ACTIVE_FROM' => $active ? date('d.m.Y H:i:s') : null,
                    ]
                );
            }
            break;
    }
}

echo json_encode($result);
die();
?>




