<?php
class CacheManagerCurrencyConvertion extends md_cache_manager{

    const TABLE_NAME_CURRENCY_CONVERTION   = 'mdCurrencyConvertion';

    const TIME_TO_LIFE          = 3600;

    private static $instance = NULL;

    public $currenciesConvertion = NULL;

    private function  __construct() {}

    public function getTable()
    {
        return self::TABLE_NAME_CURRENCY_CONVERTION;
    }

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {

            self::$instance = new CacheManagerCurrencyConvertion();

        }
        return self::$instance;
    }

    public function init($hydrationMode = NULL)
    {
        if(is_null($this->currenciesConvertion))
        {
            $this->currenciesConvertion = Doctrine::getTable(self::TABLE_NAME_CURRENCY_CONVERTION)->findAll($hydrationMode, self::TIME_TO_LIFE, true);
        }
    }

    public function getCollection()
    {
        return $this->currenciesConvertion;
    }

    public function findCurrencyConvertion($keys = array(), $values = array(), $hydrationMode = null)
    {
        return $this->find($keys, $values, $hydrationMode);
    }

}
