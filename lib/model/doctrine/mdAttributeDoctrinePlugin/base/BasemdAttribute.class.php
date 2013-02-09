<?php

/**
 * BasemdAttribute
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $label
 * @property string $type_class
 * @property integer $requiered
 * @property boolean $translated
 * @property Doctrine_Collection $mdProfileAttribute
 * @property Doctrine_Collection $mdAttributeValue
 * @property Doctrine_Collection $mdAttributeObject
 * 
 * @method integer             getId()                 Returns the current record's "id" value
 * @method string              getName()               Returns the current record's "name" value
 * @method string              getLabel()              Returns the current record's "label" value
 * @method string              getTypeClass()          Returns the current record's "type_class" value
 * @method integer             getRequiered()          Returns the current record's "requiered" value
 * @method boolean             getTranslated()         Returns the current record's "translated" value
 * @method Doctrine_Collection getMdProfileAttribute() Returns the current record's "mdProfileAttribute" collection
 * @method Doctrine_Collection getMdAttributeValue()   Returns the current record's "mdAttributeValue" collection
 * @method Doctrine_Collection getMdAttributeObject()  Returns the current record's "mdAttributeObject" collection
 * @method mdAttribute         setId()                 Sets the current record's "id" value
 * @method mdAttribute         setName()               Sets the current record's "name" value
 * @method mdAttribute         setLabel()              Sets the current record's "label" value
 * @method mdAttribute         setTypeClass()          Sets the current record's "type_class" value
 * @method mdAttribute         setRequiered()          Sets the current record's "requiered" value
 * @method mdAttribute         setTranslated()         Sets the current record's "translated" value
 * @method mdAttribute         setMdProfileAttribute() Sets the current record's "mdProfileAttribute" collection
 * @method mdAttribute         setMdAttributeValue()   Sets the current record's "mdAttributeValue" collection
 * @method mdAttribute         setMdAttributeObject()  Sets the current record's "mdAttributeObject" collection
 * 
 * @package    naturalia
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasemdAttribute extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('md_attribute');
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
        $this->hasColumn('label', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('type_class', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('requiered', 'integer', 1, array(
             'type' => 'integer',
             'default' => 0,
             'notnull' => true,
             'length' => 1,
             ));
        $this->hasColumn('translated', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('mdProfileAttribute', array(
             'local' => 'id',
             'foreign' => 'md_attribute_id'));

        $this->hasMany('mdAttributeValue', array(
             'local' => 'id',
             'foreign' => 'md_attribute_id'));

        $this->hasMany('mdAttributeObject', array(
             'local' => 'id',
             'foreign' => 'md_attribute_id'));

        $i18n0 = new Doctrine_Template_I18n(array(
             'fields' => 
             array(
              0 => 'label',
             ),
             ));
        $this->actAs($i18n0);
    }
}