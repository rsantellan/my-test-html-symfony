<?php

/**
 * BasemdProduct
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property double $price
 * @property integer $quantity
 * @property float $tax
 * @property boolean $is_public
 * @property integer $md_unit_id
 * @property integer $md_currency_id
 * @property boolean $is_multiple
 * @property float $weight
 * @property float $volumetric_weight
 * @property integer $priority
 * @property mdUnit $mdUnit
 * @property mdCurrency $mdCurrency
 * @property Doctrine_Collection $mdProductSearch
 * 
 * @method integer             getId()                Returns the current record's "id" value
 * @method string              getName()              Returns the current record's "name" value
 * @method double              getPrice()             Returns the current record's "price" value
 * @method integer             getQuantity()          Returns the current record's "quantity" value
 * @method float               getTax()               Returns the current record's "tax" value
 * @method boolean             getIsPublic()          Returns the current record's "is_public" value
 * @method integer             getMdUnitId()          Returns the current record's "md_unit_id" value
 * @method integer             getMdCurrencyId()      Returns the current record's "md_currency_id" value
 * @method boolean             getIsMultiple()        Returns the current record's "is_multiple" value
 * @method float               getWeight()            Returns the current record's "weight" value
 * @method float               getVolumetricWeight()  Returns the current record's "volumetric_weight" value
 * @method integer             getPriority()          Returns the current record's "priority" value
 * @method mdUnit              getMdUnit()            Returns the current record's "mdUnit" value
 * @method mdCurrency          getMdCurrency()        Returns the current record's "mdCurrency" value
 * @method Doctrine_Collection getMdProductSearch()   Returns the current record's "mdProductSearch" collection
 * @method mdProduct           setId()                Sets the current record's "id" value
 * @method mdProduct           setName()              Sets the current record's "name" value
 * @method mdProduct           setPrice()             Sets the current record's "price" value
 * @method mdProduct           setQuantity()          Sets the current record's "quantity" value
 * @method mdProduct           setTax()               Sets the current record's "tax" value
 * @method mdProduct           setIsPublic()          Sets the current record's "is_public" value
 * @method mdProduct           setMdUnitId()          Sets the current record's "md_unit_id" value
 * @method mdProduct           setMdCurrencyId()      Sets the current record's "md_currency_id" value
 * @method mdProduct           setIsMultiple()        Sets the current record's "is_multiple" value
 * @method mdProduct           setWeight()            Sets the current record's "weight" value
 * @method mdProduct           setVolumetricWeight()  Sets the current record's "volumetric_weight" value
 * @method mdProduct           setPriority()          Sets the current record's "priority" value
 * @method mdProduct           setMdUnit()            Sets the current record's "mdUnit" value
 * @method mdProduct           setMdCurrency()        Sets the current record's "mdCurrency" value
 * @method mdProduct           setMdProductSearch()   Sets the current record's "mdProductSearch" collection
 * 
 * @package    naturalia
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasemdProduct extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('md_product');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('price', 'double', null, array(
             'type' => 'double',
             'notnull' => true,
             ));
        $this->hasColumn('quantity', 'integer', 4, array(
             'type' => 'integer',
             'default' => '1',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('tax', 'float', null, array(
             'type' => 'float',
             'notnull' => true,
             'default' => 0,
             'length' => '',
             ));
        $this->hasColumn('is_public', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 1,
             'notnull' => true,
             ));
        $this->hasColumn('md_unit_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('md_currency_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('is_multiple', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             'notnull' => true,
             ));
        $this->hasColumn('weight', 'float', 6, array(
             'type' => 'float',
             'default' => 0,
             'length' => 6,
             'scale' => '2',
             ));
        $this->hasColumn('volumetric_weight', 'float', 6, array(
             'type' => 'float',
             'default' => 0,
             'length' => 6,
             'scale' => '2',
             ));
        $this->hasColumn('priority', 'integer', 2, array(
             'type' => 'integer',
             'default' => 0,
             'length' => 2,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('mdUnit', array(
             'local' => 'md_unit_id',
             'foreign' => 'id'));

        $this->hasOne('mdCurrency', array(
             'local' => 'md_currency_id',
             'foreign' => 'id'));

        $this->hasMany('mdProductSearch', array(
             'local' => 'id',
             'foreign' => 'id'));

        $mdcontentbehavior0 = new MdContentBehavior();
        $mdi18nbehavior0 = new mdI18nBehavior();
        $mdsaleablebehavior0 = new MdSaleableBehavior();
        $mdattributebehavior0 = new MdAttributeBehavior();
        $mdmediabehavior0 = new mdMediaBehavior();
        $mdcategorybehavior0 = new mdCategoryBehavior();
        $i18n0 = new Doctrine_Template_I18n(array(
             'fields' => 
             array(
              0 => 'name',
             ),
             ));
        $this->actAs($mdcontentbehavior0);
        $this->actAs($mdi18nbehavior0);
        $this->actAs($mdsaleablebehavior0);
        $this->actAs($mdattributebehavior0);
        $this->actAs($mdmediabehavior0);
        $this->actAs($mdcategorybehavior0);
        $this->actAs($i18n0);
    }
}