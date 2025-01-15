<?php
namespace classes;

use Bitrix\Main;
use Bitrix\Main\Loader;
use Bitrix\Currency;

class CurrencyRates
{
    public function getCurrency(): void
    {
        global $DB;

        Loader::includeModule('currency');
        $baseCurrency = Currency\CurrencyManager::getBaseCurrency();
        $currencies = \Bitrix\Currency\CurrencyTable::getList([
            'select' => ['CURRENCY'],
            'order' => ['SORT' => 'ASC'],
        ])->fetchAll();

        $desiredCurrencies = array_column($currencies, 'CURRENCY');
        $currency = array_filter($desiredCurrencies, function ($currency) use ($baseCurrency) {
            return $currency !== $baseCurrency;
        });

        $date = date("d.m.Y");
        $url = "";

        switch ($baseCurrency) {
            case 'BYR':
            case 'BYN':
                $url = 'http://www.nbrb.by/Services/XmlExRates.aspx?ondate=' . $DB->FormatDate($date, \CLang::GetDateFormat('SHORT', LANGUAGE_ID), 'Y-M-D');
                break;
            case 'RUB':
            case 'RUR':
                $url = 'https://www.cbr.ru/scripts/XML_daily.asp?date_req=' . $DB->FormatDate($date, \CLang::GetDateFormat('SHORT', LANGUAGE_ID), 'D.M.Y');
                break;
        }


        $http = new Main\Web\HttpClient();
        $http->setRedirect(true);
        $data = $http->get($url);

        $charset = 'windows-1251';
        $matches = [];
        if (preg_match("/<" . "\?XML[^>]{1,}encoding=[\"']([^>\"']{1,})[\"'][^>]{0,}\?" . ">/i", $data, $matches)) {
            $charset = trim($matches[1]);
        }
        $data = preg_replace("#<!DOCTYPE[^>]+?>#i", '', $data);
        $data = preg_replace("#<" . "\\?XML[^>]+?\\?" . ">#i", '', $data);
        $data = Main\Text\Encoding::convertEncoding($data, $charset, SITE_CHARSET);

        $objXML = new \CDataXML();
        $res = $objXML->LoadString($data);
        if ($res !== false) {
            $data = $objXML->GetArray();
        } else {
            $data = false;
        }

        if (!empty($data) && is_array($data)) {
            switch ($baseCurrency) {
                case 'BYR':
                case 'BYN':
                    if (!empty($data["DailyExRates"]["#"]["Currency"]) && is_array($data["DailyExRates"]["#"]["Currency"])) {
                        $fullCurrencyList = $data['DailyExRates']['#']['Currency'];
                        $currencyList = array_filter($fullCurrencyList, function ($currencyRate) use ($currency) {
                            return in_array($currencyRate["#"]["CharCode"][0]["#"], $currency);
                        });

                        foreach ($currencyList as $currencyRate) {
                            $currencyId = $currencyRate["#"]["CharCode"][0]["#"];
                            $result[$currencyId]['STATUS'] = 'OK';
                            $result[$currencyId]['RATE_CNT'] = (int)$currencyRate["#"]["Scale"][0]["#"];
                            $result[$currencyId]['RATE'] = (float)str_replace(",", ".", $currencyRate["#"]["Rate"][0]["#"]);
                        }
                        unset($currencyRate, $currencyList);
                    }
                    break;
                case 'RUB':
                case 'RUR':
                    if (!empty($data["ValCurs"]["#"]["Valute"]) && is_array($data["ValCurs"]["#"]["Valute"])) {
                        $fullCurrencyList = $data["ValCurs"]["#"]["Valute"];
                        $currencyList = array_filter($fullCurrencyList, function ($currencyRate) use ($currency) {
                            return in_array($currencyRate["#"]["CharCode"][0]["#"], $currency);
                        });
                        foreach ($currencyList as $currencyRate) {
                            $currencyId = $currencyRate["#"]["CharCode"][0]["#"];

                            $result[$currencyId]['STATUS'] = 'OK';
                            $result[$currencyId]['RATE_CNT'] = (int)$currencyRate["#"]["Nominal"][0]["#"];
                            $result[$currencyId]['RATE'] = (float)str_replace(",", ".", $currencyRate["#"]["Value"][0]["#"]);
                            break;

                        }
                        unset($currencyRate, $currencyList);
                    }
                    break;
            }
        }

        if (!empty($result)) {
            foreach ($result as $key => $value) {
                if ($value['STATUS'] == 'OK') {
                    $arFilter = array(
                        "CURRENCY" => $key,
                        "DATE_RATE" => $date,
                    );
                    $by = "date";
                    $order = "desc";
                    $db_rate = \CCurrencyRates::GetList($by, $order, $arFilter);
                    if (!$ar_rate = $db_rate->Fetch()) {
                        $arFields = array(
                            "RATE" => $value["RATE"],
                            "RATE_CNT" => $value["RATE_CNT"],
                            "CURRENCY" => $key,
                            "DATE_RATE" => $date,
                        );
                        if (!\CCurrencyRates::Add($arFields))
                            echo "Ошибка добавления курса";
                        else
                            echo "Курс добавлен";
                    } else {
                        echo "Курс уже существует";
                    }
                }
            }
        }
    }
}
?>
