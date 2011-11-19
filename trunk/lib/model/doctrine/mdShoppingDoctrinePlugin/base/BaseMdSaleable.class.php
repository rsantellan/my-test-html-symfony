<?php

/**
 * BaseMdSaleable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $object_class
 * @property integer $object_id
 * @property Doctrine_Collection $MdSaleableRelation
 * 
 * @method integer             getId()                 Returns the current record's "id" value
 * @method string              getObjectClass()        Returns the current record's "object_class" value
 * @method integer             getObjectId()           Returns the current record's "object_id" value
 * @method Doctrine_Collection getMdSaleableRelation() Returns the current record's "MdSaleableRelation" collection
 * @method MdSaleable          setId()                 Sets the current record's "id" value
 * @method MdSaleable          setObjectClass()        Sets the current record's "object_class" value
 * @method MdSaleable          setObjectId()           Sets the current record's "object_id" value
 * @method MdSaleable          setMdSaleableRelation() Sets the current record's "MdSaleableRelation" collection
 * 
 * @package    naturalia
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMdSaleable extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('md_saleable');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('object_class', 'string', 250, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 250,
             ));
        $this->hasColumn('object_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('MdSaleableRelation', array(
             'local' => 'id',
             'foreign' => 'md_saleable_parent_id'));
    }
}