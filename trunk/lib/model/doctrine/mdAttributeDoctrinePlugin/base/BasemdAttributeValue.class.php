<?php

/**
 * BasemdAttributeValue
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property int $md_attribute_id
 * @property mdAttribute $mdAttribute
 * @property Doctrine_Collection $mdAttributeObject
 * 
 * @method integer             getId()                Returns the current record's "id" value
 * @method string              getName()              Returns the current record's "name" value
 * @method int                 getMdAttributeId()     Returns the current record's "md_attribute_id" value
 * @method mdAttribute         getMdAttribute()       Returns the current record's "mdAttribute" value
 * @method Doctrine_Collection getMdAttributeObject() Returns the current record's "mdAttributeObject" collection
 * @method mdAttributeValue    setId()                Sets the current record's "id" value
 * @method mdAttributeValue    setName()              Sets the current record's "name" value
 * @method mdAttributeValue    setMdAttributeId()     Sets the current record's "md_attribute_id" value
 * @method mdAttributeValue    setMdAttribute()       Sets the current record's "mdAttribute" value
 * @method mdAttributeValue    setMdAttributeObject() Sets the current record's "mdAttributeObject" collection
 * 
 * @package    naturalia
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasemdAttributeValue extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('md_attribute_value');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('md_attribute_id', 'int', 4, array(
             'type' => 'int',
             'notnull' => true,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('mdAttribute', array(
             'local' => 'md_attribute_id',
             'foreign' => 'id'));

        $this->hasMany('mdAttributeObject', array(
             'local' => 'id',
             'foreign' => 'md_attribute_value_id'));

        $i18n0 = new Doctrine_Template_I18n(array(
             'fields' => 
             array(
              0 => 'name',
             ),
             ));
        $this->actAs($i18n0);
    }
}