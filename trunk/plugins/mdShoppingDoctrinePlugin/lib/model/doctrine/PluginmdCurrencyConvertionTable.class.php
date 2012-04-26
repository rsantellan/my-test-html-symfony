<?php
/**
 */
class PluginmdCurrencyConvertionTable extends Doctrine_Table
{

    public function findCurrencyConvertion($currencyFrom, $currencyTo)
    {

        $mdCurrencyFrom = CacheManagerCurrency::getInstance()->findMdCurrencyBy('code', $currencyFrom);
        $mdCurrencyTo = CacheManagerCurrency::getInstance()->findMdCurrencyBy('code', $currencyTo);

        if(empty($mdCurrencyFrom))
        {

            throw new Exception('currency ' . $currencyFrom . ' not exist in database. You have to define that', 100);

        }

        if(empty($mdCurrencyTo))
        {

            throw new Exception('currency ' . $currencyTo . ' not exist in database. You have to define that', 101);

        }

        $currencyConvertion = CacheManagerCurrencyConvertion::getInstance()->findCurrencyConvertion(array('currency_from','currency_to'), array($mdCurrencyFrom->getId(), $mdCurrencyTo->getId()));

        if(empty ($currencyConvertion))
        {

            throw new Exception('convertion not exist in database. You have to define that', 102);

        }

        return $currencyConvertion;

    }
}