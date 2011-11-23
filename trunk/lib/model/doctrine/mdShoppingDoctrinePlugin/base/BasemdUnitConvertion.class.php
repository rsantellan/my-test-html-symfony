<?php

/**
 * BasemdUnitConvertion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $from_unit
 * @property integer $to_unit
 * @property float $ratio
 * @property mdUnit $mdUnit
 * @property mdUnit $mdUnit_2
 * 
 * @method integer          getId()        Returns the current record's "id" value
 * @method integer          getFromUnit()  Returns the current record's "from_unit" value
 * @method integer          getToUnit()    Returns the current record's "to_unit" value
 * @method float            getRatio()     Returns the current record's "ratio" value
 * @method mdUnit           getMdUnit()    Returns the current record's "mdUnit" value
 * @method mdUnit           getMdUnit2()   Returns the current record's "mdUnit_2" value
 * @method mdUnitConvertion setId()        Sets the current record's "id" value
 * @method mdUnitConvertion setFromUnit()  Sets the current record's "from_unit" value
 * @method mdUnitConvertion setToUnit()    Sets the current record's "to_unit" value
 * @method mdUnitConvertion setRatio()     Sets the current record's "ratio" value
 * @method mdUnitConvertion setMdUnit()    Sets the current record's "mdUnit" value
 * @method mdUnitConvertion setMdUnit2()   Sets the current record's "mdUnit_2" value
 * 
 * @package    naturalia
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasemdUnitConvertion extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('md_unit_convertion');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('from_unit', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('to_unit', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('ratio', 'float', null, array(
             'type' => 'float',
             'notnull' => true,
             'length' => '',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('mdUnit', array(
             'local' => 'from_unit',
             'foreign' => 'id'));

        $this->hasOne('mdUnit as mdUnit_2', array(
             'local' => 'to_unit',
             'foreign' => 'id'));
    }
}