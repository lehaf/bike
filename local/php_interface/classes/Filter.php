<?php
namespace classes;

use Bitrix\Main\Loader;
use Bitrix\Iblock;
use Bitrix\Catalog\SmartFilter;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Iblock\PropertyEnumerationTable;
use Bitrix\Sale\Location\LocationTable;

Loader::includeModule('location');
Loader::includeModule('highloadblock');
Loader::includeModule('catalog');
Loader::includeModule('iblock');

class Filter
{
    public static function getPropertyId(int $iblock, string $code): int
    {
        return PropertyTable::getList([
            'filter' => ['=IBLOCK_ID' => $iblock, '=CODE' => $code],
            'select' => ['ID']
        ])->fetch()['ID'];
    }

    public static function getYearsFilterId(int $yearFrom, int $yearTo): array
    {
        $years = range($yearFrom, $yearTo);

        $propertyYearId = PropertyTable::getList([
            'filter' => ['=IBLOCK_ID' => CATALOG_IBLOCK_ID, '=CODE' => 'year'],
            'select' => ['ID']
        ])->fetch()['ID'];

        $yearsId = PropertyEnumerationTable::getList([
            'filter' => [
                '=PROPERTY_ID' => $propertyYearId,
                '=VALUE' => $years // Массив значений для поиска
            ],
            'select' => ['ID']
        ])->fetchAll();
        return array_column($yearsId, 'ID');
    }

    public static function getMarksFilterId(int $iblock, array $marks): array
    {
        $emptyMarks = [];
        $emptyMarksModels = [];
        $sections = [];

        foreach ($marks as $key => $value) {
            $models = explode(",", $value);
            if ($models[0] === "Y") {
                $emptyMarks[] = $key;
            } else {
                $sections = array_merge($sections, $models);
            }
        }

        if (!empty($emptyMarks)) {
            $emptyMarksModels = \Bitrix\Iblock\SectionTable::getList([
                'filter' => [
                    'IBLOCK_ID' => $iblock,  // ID инфоблока, в котором ищем
                    'ACTIVE' => 'Y',   // Только активные разделы
                    'IBLOCK_SECTION_ID' => $emptyMarks  // ID родительского раздела
                ],
                'select' => ['ID'],  // Выбираем необходимые поля
            ])->fetchAll();
            $emptyMarksModels = array_column($emptyMarksModels, 'ID');
        }

        return array_merge($sections, $emptyMarksModels);
    }

    public static function getCitiesFilterId(array $params, string $filterName): array
    {
        $cities = [];
        if ($params[$filterName . '_city']) {
            $cities[] = $params[$filterName . '_city'];
        } else if ($params[$filterName . '_region'] && $params[$filterName . '_country']) {
            $regionId = (int)$params[$filterName . '_region'];
            if ($regionId) {
                $cities = self::getLocationsId($regionId, 'CITY');
            }
        } else if ($params[$filterName . '_country']) {
            $countryId = (int)$params[$filterName . '_country'];
            if ($countryId) {
                $regions = self::getLocationsId((int)$params[$filterName . '_country'], 'REGION');
                if (!empty($regions)) {
                    foreach ($regions as $region) {
                        $cities = array_merge($cities, self::getLocationsId($region, 'CITY'));
                    }
                }
            }
        }

        return $cities;
    }

    private static function getLocationsId(int $id, string $type): array
    {
        $filter = [
            '=TYPE.CODE' => $type,
            '=NAME.LANGUAGE_ID' => 'ru',
            '=TYPE.NAME.LANGUAGE_ID' => 'ru',
        ];
        $select = ['ID'];

        $directRegions = \Bitrix\Sale\Location\LocationTable::getList([
            'filter' => $filter + ['=PARENT_ID' => $id],
            'select' => $select,
        ])->fetchAll();

        $indirectRegions = \Bitrix\Sale\Location\LocationTable::getList([
            'filter' => $filter + ['=PARENT.PARENT_ID' => $id],
            'select' => $select,
        ])->fetchAll();

        $allRegions = array_merge($directRegions ?? [], $indirectRegions ?? []);

        return array_column($allRegions, 'ID');
    }

    public static function getFilterParams(string $url, string $filterName, int $iblockId, int $sectId) : array
    {
        $searchParams = [];
        $arrParams = [];
        parse_str($url, $searchParams);
        $skipParams = ['year', 'video', 'photo', 'mark', 'country', 'region', 'city', 'currency'];

        if (!empty($searchParams)) {

            $propertyCache = []; // Кэш для свойств, чтобы не делать лишние запросы

            foreach ($searchParams as $key => $param) {
                $paramParts = explode('_', str_replace($filterName . '_', '', $key));
                if (!in_array($paramParts[0], $skipParams)) {
                    if (count($paramParts) === 2 || count($paramParts) === 1) {
                        $propertyId = $paramParts[0];
                        $hashValue = $paramParts[1] ?? $param;
                        $isNumber = ($paramParts[1] === 'MIN' || $paramParts[1] === 'MAX');
                        $propertyKey = ($paramParts[0] === 'P1') ? "CATALOG_PRICE_1" : "PROPERTY_" . $propertyId;

                        if ($isNumber) {
                            $operator = ($paramParts[1] === 'MIN') ? ">=" : "<=";
                            $arrParams[$operator . $propertyKey] = $param;
                        } else {
                            // Проверяем, есть ли кэш для данного свойства
                            if (!isset($propertyCache[$propertyId])) {
                                $propertyCache[$propertyId] = PropertyEnumerationTable::getList([
                                    "filter" => ["=PROPERTY_ID" => $propertyId],
                                    "select" => ["ID"]
                                ])->fetchAll();
                            }

                            // Проверяем и добавляем значение, если оно совпадает с хэшем
                            if (!empty($propertyCache[$propertyId])) {
                                foreach ($propertyCache[$propertyId] as $prop) {
                                    if (abs(crc32($prop["ID"])) == $hashValue) {
                                        $arrParams['=' . $propertyKey][] = $prop['ID'];
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $filterCurrency = $searchParams[$filterName . '_currency'];
            if($filterCurrency && ($arrParams[">=CATALOG_PRICE_1"] || $arrParams["<=CATALOG_PRICE_1"])) {
                $baseCurrency = \Bitrix\Currency\CurrencyManager::getBaseCurrency();
                $currencies = \Bitrix\Currency\CurrencyTable::getList([
                    'select' => ['CURRENCY'],
                    'cache' => [
                        'ttl' => 36000000,
                        'cache_joins' => true
                    ],
                ])->fetchAll();
                $desiredCurrencies = array_column($currencies, 'CURRENCY');

                if ($filterCurrency !== $baseCurrency && in_array($searchParams[$filterName . '_currency'], $desiredCurrencies)) {
                   if ($arrParams[">=CATALOG_PRICE_1"]) {
                       $arrParams[">=CATALOG_PRICE_1"] = \CCurrencyRates::ConvertCurrency($arrParams[">=CATALOG_PRICE_1"], $filterCurrency, $baseCurrency );
                   }

                    if ($arrParams["<=CATALOG_PRICE_1"]) {
                        $arrParams["<=CATALOG_PRICE_1"] = \CCurrencyRates::ConvertCurrency($arrParams["<=CATALOG_PRICE_1"], $filterCurrency, $baseCurrency );
                    }
                }
            }

            if ($searchParams[$filterName . '_year_MIN'] || $searchParams[$filterName . '_year_MAX']) {
                $yearFrom = $searchParams[$filterName . '_year_MIN'] ?? 1900;
                $yearTo = $searchParams[$filterName . '_year_MAX'] ?? date('Y');
                $arrParams['=PROPERTY_' . self::getPropertyId($iblockId, 'year')] = self::getYearsFilterId($yearFrom, $yearTo);
            }

            if ($searchParams[$filterName . '_mark']) {
                $sections = self::getMarksFilterId($iblockId, $searchParams[$filterName . '_mark']);
                if (!empty($sections)) $arrParams['IBLOCK_SECTION_ID'] = $sections;
            }

            $cities = self::getCitiesFilterId($searchParams, $filterName);

            if(!empty($cities)) {
                $arrParams['=PROPERTY_' . self::getPropertyId($iblockId, 'country')] = $cities;
            }

            if ($searchParams[$filterName . '_photo']) {
                $arrParams['!PREVIEW_PICTURE'] = false;
            }

            if ($searchParams[$filterName . '_video']) {
                $arrParams['!PROPERTY_' . self::getPropertyId($iblockId, 'VIDEO_YOUTUBE')] = false;
            }

            if ($searchParams[$filterName . '_article']) {
                $arrParams['=PROPERTY_' . self::getPropertyId($iblockId, 'article_part')] = $searchParams[$filterName . '_article'];
            }

            $arrParams['IBLOCK_ID'] = $iblockId;
            $arrParams['SECTION_ID'] = $sectId; //подставить значение раздела, в котором находится фильтр
            $arrParams['INCLUDE_SUBSECTIONS'] = "Y";
            $arrParams['ACTIVE'] = 'Y';
        }
        return $arrParams;
    }
    public function init() : void
    {
        global $APPLICATION;

        $entityUsersSearch = getHlblock("b_user_search");
        $resUsersSearch = $entityUsersSearch::getList(["select" => ["*"]])->fetchAll();
        $filterName = strstr($resUsersSearch[0]['UF_SEARCH_QUERY'], '_', true);
        // Проверяем, есть ли результаты
        if (empty($resUsersSearch)) {
            return; // Если нет результатов, выход из метода
        }

        // Разбиваем параметры
        $searchParams = [];
        parse_str($resUsersSearch[0]['UF_SEARCH_QUERY'], $searchParams);
        $skipParams = ['year', 'video', 'photo', 'mark', 'country', 'region', 'city'];

        if (!empty($searchParams)) {
            $arrParams = [];
            $propertyCache = []; // Кэш для свойств, чтобы не делать лишние запросы

            foreach ($searchParams as $key => $param) {
                $paramParts = explode('_', str_replace($filterName . '_', '', $key));
                if (!in_array($paramParts[0], $skipParams)) {
                    if (count($paramParts) === 2 || count($paramParts) === 1) {
                        $propertyId = $paramParts[0];
                        $hashValue = $paramParts[1] ?? $param;
                        $isNumber = ($paramParts[1] === 'MIN' || $paramParts[1] === 'MAX');
                        $propertyKey = ($paramParts[0] === 'P1') ? "CATALOG_PRICE_1" : "PROPERTY_" . $propertyId;

                        if ($isNumber) {
                            $operator = ($paramParts[1] === 'MIN') ? ">=" : "<=";
                            $arrParams[$operator . $propertyKey] = $param;
                        } else {
                            // Проверяем, есть ли кэш для данного свойства
                            if (!isset($propertyCache[$propertyId])) {
                                $propertyCache[$propertyId] = PropertyEnumerationTable::getList([
                                    "filter" => ["=PROPERTY_ID" => $propertyId],
                                    "select" => ["ID"]
                                ])->fetchAll();
                            }

                            // Проверяем и добавляем значение, если оно совпадает с хэшем
                            if (!empty($propertyCache[$propertyId])) {
                                foreach ($propertyCache[$propertyId] as $prop) {
                                    if (abs(crc32($prop["ID"])) == $hashValue) {
                                        $arrParams['=' . $propertyKey][] = $prop['ID'];
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if ($searchParams[$filterName . '_year_MIN'] || $searchParams[$filterName . '_year_MAX']) {
                $yearFrom = $searchParams[$filterName . '_year_MIN'] ?? 1900;
                $yearTo = $searchParams[$filterName . '_year_MAX'] ?? date('Y');
                $arrParams['=PROPERTY_' . self::getPropertyId(CATALOG_IBLOCK_ID, 'year')] = self::getYearsFilterId($yearFrom, $yearTo);
            }

            if ($searchParams[$filterName . '_mark']) {
                $sections = self::getMarksFilterId(CATALOG_IBLOCK_ID, $searchParams[$filterName . '_mark']);
                if (!empty($sections)) $arrParams['IBLOCK_SECTION_ID'] = $sections;
            }

            $cities = self::getCitiesFilterId($searchParams, $filterName);

            if(!empty($cities)) {
                $arrParams['=PROPERTY_' . self::getPropertyId(CATALOG_IBLOCK_ID, 'country')] = $cities;
            }

            $arrParams['IBLOCK_ID'] = CATALOG_IBLOCK_ID;
            $arrParams['SECTION_ID'] = 7540; //подставить значение раздела, в котором находится фильтр
            $arrParams['INCLUDE_SUBSECTIONS'] = "Y";
            $arrParams['ACTIVE'] = 'Y';


            pr($arrParams);

//            $citiesData = LocationTable::getList([
//                'filter' => ['=TYPE.CODE' => 'CITY'], // Фильтруем по типу 'CITY'
//                'select' => ['ID'], // Выбираем нужные поля
//            ])->fetchAll();
//            foreach ($citiesData as $city) {
//                $this->cities[$city['ID']] = $city['NAME'];
//            }
//            $this->locationTree = self::getLocationTree($this->cities);



            pr(\CIBlockElement::GetList(array(), $arrParams, array(), false));
        }
    }
}

?>
