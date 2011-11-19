<?php

/**
 * BasemdCurrencyConvertion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $currency_from
 * @property integer $currency_to
 * @property double $ratio
 * @property mdCurrency $mdCurrencyFrom
 * @property mdCurrency $mdCurrencyTo
 * 
 * @method integer              getCurrencyFrom()   Returns the current record's "currency_from" value
 * @method integer              getCurrencyTo()     Returns the current record's "currency_to" value
 * @method double               getRatio()          Returns the current record's "ratio" value
 * @method mdCurrency           getMdCurrencyFrom() Returns the current record's "mdCurrencyFrom" value
 * @method mdCurrency           getMdCurrencyTo()   Returns the current record's "mdCurrencyTo" value
 * @method mdCurrencyConvertion setCurrencyFrom()   Sets the current record's "currency_from" value
 * @method mdCurrencyConvertion setCurrencyTo()     Sets the current record's "currency_to" value
 * @method mdCurrencyConvertion setRatio()          Sets the current record's "ratio" value
 * @method mdCurrencyConvertion setMdCurrencyFrom() Sets the current record's "mdCurrencyFrom" value
 * @method mdCurrencyConvertion setMdCurrencyTo()   Sets the current record's "mdCurrencyTo" value
 * 
 * @package    naturalia
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasemdCurrencyConvertion extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('md_currency_convertion');
        $this->hasColumn('currency_from', 'integer', 4, array(
             'primary' => true,
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('currency_to', 'integer', 4, array(
             'primary' => true,
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('ratio', 'double', 18, array(
             'type' => 'double',
             'notnull' => true,
             'length' => 18,
             'scale' => '8',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('mdCurrency as mdCurrencyFrom', array(
             'local' => 'currency_from',
             'foreign' => 'id'));

        $this->hasOne('mdCurrency as mdCurrencyTo', array(
             'local' => 'currency_to',
             'foreign' => 'id'));
    }
}