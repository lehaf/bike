<?php
namespace classes;

use Bitrix\Main\Loader;

Loader::includeModule('catalog');
Loader::includeModule('iblock');

class Page
{
    public function resetTodayCounter () : void
    {
        $iblockClass = \Bitrix\Iblock\Iblock::wakeUp(CATALOG_IBLOCK_ID)->getEntityDataClass();
        $elementsCounter = $iblockClass::getList([
            'select' => ['ID','SHOW_TODAY'],
            'filter' => ['!SHOW_TODAY.VALUE' => false]
        ])->fetchCollection();

        foreach ($elementsCounter as $counter) {
            pr([$counter->getId() => $counter->getShowToday()->getValue()]);
            $counter->setShowToday(0);
            $counter->save();
        }
    }
}

?>
