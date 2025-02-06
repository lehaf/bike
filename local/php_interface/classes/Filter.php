<?php
namespace classes;

use Bitrix\Main\Loader;
use Bitrix\Iblock;
use Bitrix\Catalog\SmartFilter;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Iblock\PropertyEnumerationTable;
use Bitrix\Sale\Location\LocationTable;
use Bitrix\Main;

Loader::includeModule('location');
Loader::includeModule('highloadblock');
Loader::includeModule('catalog');
Loader::includeModule('iblock');

class Filter
{
    private string $searchSectionCode = '';
    private string $sitePath = '';

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

    public static function getFilterParams(string $url, string $filterName, int $iblockId, int $sectId): array
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
            if ($filterCurrency && ($arrParams[">=CATALOG_PRICE_1"] || $arrParams["<=CATALOG_PRICE_1"])) {
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
                        $arrParams[">=CATALOG_PRICE_1"] = \CCurrencyRates::ConvertCurrency($arrParams[">=CATALOG_PRICE_1"], $filterCurrency, $baseCurrency);
                    }

                    if ($arrParams["<=CATALOG_PRICE_1"]) {
                        $arrParams["<=CATALOG_PRICE_1"] = \CCurrencyRates::ConvertCurrency($arrParams["<=CATALOG_PRICE_1"], $filterCurrency, $baseCurrency);
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

            if (!empty($cities)) {
                $arrParams['=PROPERTY_' . self::getPropertyId($iblockId, 'country')] = $cities;
            }

            if ($searchParams[$filterName . '_photo']) {
                $arrParams['!PREVIEW_PICTURE'] = false;
            }

            if ($searchParams[$filterName . '_video']) {
                $arrParams['!PROPERTY_' . self::getPropertyId($iblockId, 'POPUP_VIDEO')] = false;
            }

            if ($searchParams[$filterName . '_article']) {
                $arrParams['=PROPERTY_' . self::getPropertyId($iblockId, 'article_part')] = $searchParams[$filterName . '_article'];
            }

            if ($searchParams[$filterName . '_exp_id']) {
                $arrParams['=PROPERTY_' . self::getPropertyId($iblockId, 'exp_id')] = $searchParams[$filterName . '_exp_id'];
            }
        }

        $arrParams['IBLOCK_ID'] = $iblockId;
        $arrParams['SECTION_ID'] = $sectId; //подставить значение раздела, в котором находится фильтр
        $arrParams['INCLUDE_SUBSECTIONS'] = "Y";
        $arrParams['ACTIVE'] = 'Y';

        return $arrParams;
    }
    private function getElementsTemplate (array $arrParams, array $arSelect) : string
        {
            $result = \CIBlockElement::GetList([], $arrParams, false, ['nTopCount' => 8], $arSelect);
            $resultTemplate = "";
            while ($item = $result->GetNext()) {

                if (!empty($item['PROPERTY_COUNTRY_VALUE'])) {
                    $location = \Bitrix\Sale\Location\LocationTable::getList([
                        'filter' => ['=ID' => $item['PROPERTY_COUNTRY_VALUE'], '=NAME.LANGUAGE_ID' => 'ru',],
                        'select' => ['NAME_RU' => 'NAME.NAME'] // Название на русском
                    ])->fetch();
                    $countryName = $location['NAME_RU'];
                }

                $imgPath = (!empty($item['PREVIEW_PICTURE'])) ? \CFile::GetPath($item['PREVIEW_PICTURE']) : SITE_TEMPLATE_PATH . '/bitrix/images/empty_img_element.png';

                $allPrices = getItemPrices([$item['ID']]);
                $itemPrices = $allPrices['prices'][$item['ID']];
                $prices = [];
                if ($itemPrices) {
                    $prices = convertPrice($itemPrices, $allPrices['desired'], $allPrices['base']);
                }

                $propsString = "";
                $props = (in_array($arrParams['SECTION_ID'], SECTION_TYPE_2)) ? [] : [
                    'year' => (!empty($item['PROPERTY_YEAR_VALUE'])) ? $item['PROPERTY_YEAR_VALUE'] . ' г.' : '',
                    'race' => (!empty($item['PROPERTY_RACE_VALUE'])) ? $item['PROPERTY_RACE_VALUE'] . ' ' . $item['PROPERTY_RACE_UNIT_VALUE'] : '',
                    'power' => (!empty($item['PROPERTY_POWER_VALUE'])) ? $item['PROPERTY_POWER_VALUE'] . ' л.с.' : '',
                    'motor_type' => (!empty($item['PROPERTY_TYPE_' . $this->searchSectionCode . '_VALUE'])) ? $item['PROPERTY_TYPE_' . $this->searchSectionCode . '_VALUE'] : '',
                    'transmission' => (!empty($item['PROPERTY_TRANSMISSION_VALUE'])) ? $item['PROPERTY_TRANSMISSION_VALUE'] : '',
                ];
                if(!empty($props)) {
                    foreach ($props as $prop) {
                        $propsString .= $prop . ' / ';
                    }
                    $propsString = rtrim($propsString, ' / ');
                }


                $element = [
                    'id' => $item['ID'],
                    'name' => $item['NAME'],
                    'img' => $this->sitePath . $imgPath,
                    'url' => $this->sitePath . $item['DETAIL_PAGE_URL'],
                    'price' => ["BYN" => $prices["BASE"], "USD" => $prices["CONVERT"]["USD"]],
                    'props' => $propsString,
                    'city' => $countryName ?? ''
                ];

                $resultTemplate .=   include $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/searchMailResultRaw.php';
            }
            return  $resultTemplate;
        }
    public function init(): void
    {
        global $APPLICATION;

        $entityUsersSearch = getHlblock("b_user_search");
        $resUsersSearch = $entityUsersSearch::getList([
            "select" => ["*"],
            "filter" => [">UF_NOTIFY_INTERVAL" => 0]
        ])->fetchAll();
        $filterName = 'arFilter';
        // Проверяем, есть ли результаты
        if (empty($resUsersSearch)) {
            return;
        }

        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $this->sitePath = $protocol . $_SERVER['HTTP_HOST'];

        $searches = [];
        foreach ($resUsersSearch as $search) {
            $sectionUrl = "";
            $arrParams = self::getFilterParams($search['UF_FILTER_QUERY'], $filterName, CATALOG_IBLOCK_ID, $search['UF_SECTION']);
            //добавление поска в интервале времени (между последней отправкой и заданным интервалом);
            $currentDate = new \DateTime();
            $currentDate->add(\DateInterval::createFromDateString("+4 hours"));
            $startDate = \DateTime::createFromFormat("d.m.Y H:i:s", $search['UF_LAST_SENT']);
            $endDate = clone $startDate;
            $endDate->add(\DateInterval::createFromDateString("+" . $search['UF_NOTIFY_INTERVAL'] . "hours"));
            $arrParams['>=TIMESTAMP_X'] = $startDate->format('d.m.Y H:i:s');
            $arrParams['<=TIMESTAMP_X'] = $endDate->format('d.m.Y H:i:s');

            $elementsCount = \CIBlockElement::GetList([], $arrParams, [], false);

            if ($currentDate >= $endDate && (int)$elementsCount > 0) {
                $res = \CIBlockSection::GetByID($search['UF_SECTION']);
                if ($section = $res->GetNext()) {
                    $sectionUrl = $section['SECTION_PAGE_URL'];
                    $this->searchSectionCode = strtoupper($section['CODE']);
                }

                $userEmail = \Bitrix\Main\Engine\CurrentUser::get()->getEmail();
                $title = $search['UF_TITLE'];
                if (!empty($search['UF_DESCRIPTION'])) {
                    $title .= ', ' . $search['UF_DESCRIPTION'];
                }

                $searches[$userEmail][] = [
                    'TITLE' => $title,
                    'COUNT' => $elementsCount,
                    'FILTER_URL' => $sectionUrl . $search['UF_FILTER_QUERY'],
                ];

                $arSelect = (in_array($search['UF_SECTION'], SECTION_TYPE_2)) ? [
                    "ID",
                    "NAME",
                    "PREVIEW_PICTURE",
                    "DETAIL_PAGE_URL",
                    "PROPERTY_COUNTRY"
                ] : [
                    "ID",
                    "NAME",
                    "PREVIEW_PICTURE",
                    "DETAIL_PAGE_URL",
                    "PROPERTY_YEAR",
                    "PROPERTY_RACE",
                    "PROPERTY_RACE_UNIT",
                    "PROPERTY_POWER",
                    "PROPERTY_TYPE_" . $this->searchSectionCode,
                    "PROPERTY_TRANSMISSION",
                    "PROPERTY_COUNTRY"
                ];

               $resultTemplate = $this->getElementsTemplate($arrParams, $arSelect);


                $arEventFields = array(
                    "EMAIL" => $userEmail,
                    "ELEMENTS_COUNT" => $elementsCount . ' ' . getPluralForm($elementsCount, ['объявлние', 'объявления', 'объявлений']),
                    "FILTER_TITLE" => $title,
                    "FILTER_URL" => $this->sitePath . $sectionUrl . $search['UF_FILTER_QUERY'],
                    "RESULT" => $resultTemplate
                );
                pr($arEventFields);

                \CEvent::Send("USER_SEARCH", SITE_ID, $arEventFields);

//                $result = $entityUsersSearch::update($search['ID'], ['UF_LAST_SENT' => $currentDate->format('d.m.Y H:i:s')]);
//                if ($result->isSuccess()) {
//                    echo "Письмо по фильтру " . $title . " отправлено" ;
//                } else {
//                    echo "Ошибка для " . $title . ": " . $result->getErrorMessages();
//                }


                //добавить код обновление времени последней отправки, получение 8 новых элементов
            }
        }

        // Разбиваем параметры
        pr($searches);
    }
}

?>
