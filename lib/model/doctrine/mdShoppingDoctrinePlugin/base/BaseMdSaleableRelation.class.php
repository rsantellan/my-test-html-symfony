<?php

/**
 * BaseMdSaleableRelation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $md_saleable_parent_id
 * @property integer $md_saleable_son_id
 * @property MdSaleable $MdSaleable
 * @property MdSaleable $MdSaleable_2
 * 
 * @method integer            getMdSaleableParentId()    Returns the current record's "md_saleable_parent_id" value
 * @method integer            getMdSaleableSonId()       Returns the current record's "md_saleable_son_id" value
 * @method MdSaleable         getMdSaleable()            Returns the current record's "MdSaleable" value
 * @method MdSaleable         getMdSaleable2()           Returns the current record's "MdSaleable_2" value
 * @method MdSaleableRelation setMdSaleableParentId()    Sets the current record's "md_saleable_parent_id" value
 * @method MdSaleableRelation setMdSaleableSonId()       Sets the current record's "md_saleable_son_id" value
 * @method MdSaleableRelation setMdSaleable()            Sets the current record's "MdSaleable" value
 * @method MdSaleableRelation setMdSaleable2()           Sets the current record's "MdSaleable_2" value
 * 
 * @package    naturalia
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMdSaleableRelation extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('md_saleable_relation');
        $this->hasColumn('md_saleable_parent_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('md_saleable_son_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('MdSaleable', array(
             'local' => 'md_saleable_parent_id',
             'foreign' => 'id'));

        $this->hasOne('MdSaleable as MdSaleable_2', array(
             'local' => 'md_saleable_son_id',
             'foreign' => 'id'));
    }
}