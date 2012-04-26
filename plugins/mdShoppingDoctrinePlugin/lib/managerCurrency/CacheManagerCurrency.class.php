<?php
class CacheManagerCurrency extends md_cache_manager{

    const TABLE_NAME_CURRENCY   = 'mdCurrency';

    const TIME_TO_LIFE          = 3600;

    private static $instance = NULL;

    public $currencies = NULL;

    private function  __construct() {}

    public function getTable()
    {
        return self::TABLE_NAME_CURRENCY;
    }

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {

            self::$instance = new CacheManagerCurrency();

        }
        return self::$instance;
    }

    public function init($hydrationMode = NULL)
    {
        if(is_null($this->currencies))
        {
            $this->currencies = Doctrine::getTable(self::TABLE_NAME_CURRENCY)->findAll($hydrationMode, self::TIME_TO_LIFE, true);
        }
    }

    public function getCollection()
    {
        return $this->currencies;
    }

    public function findMdCurrencyBy($key, $value, $hydrationMode = null)
    {
//        print_r('estoy aca');
//        print_r('<hr/>');
//        print_r(get_class($this));
//        print_r('<hr/>');
//        print_r(get_class(parent));
        return $this->find($key, $value, $hydrationMode);
    }

}
