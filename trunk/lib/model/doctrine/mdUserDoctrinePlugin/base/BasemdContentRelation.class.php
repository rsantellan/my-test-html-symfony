<?php

/**
 * BasemdContentRelation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $md_content_id_first
 * @property integer $md_content_id_second
 * @property string $object_class_name
 * @property string $profile_name
 * @property mdContent $mdContentRelation1
 * @property mdContent $mdContentRelation2
 * 
 * @method integer           getMdContentIdFirst()     Returns the current record's "md_content_id_first" value
 * @method integer           getMdContentIdSecond()    Returns the current record's "md_content_id_second" value
 * @method string            getObjectClassName()      Returns the current record's "object_class_name" value
 * @method string            getProfileName()          Returns the current record's "profile_name" value
 * @method mdContent         getMdContentRelation1()   Returns the current record's "mdContentRelation1" value
 * @method mdContent         getMdContentRelation2()   Returns the current record's "mdContentRelation2" value
 * @method mdContentRelation setMdContentIdFirst()     Sets the current record's "md_content_id_first" value
 * @method mdContentRelation setMdContentIdSecond()    Sets the current record's "md_content_id_second" value
 * @method mdContentRelation setObjectClassName()      Sets the current record's "object_class_name" value
 * @method mdContentRelation setProfileName()          Sets the current record's "profile_name" value
 * @method mdContentRelation setMdContentRelation1()   Sets the current record's "mdContentRelation1" value
 * @method mdContentRelation setMdContentRelation2()   Sets the current record's "mdContentRelation2" value
 * 
 * @package    naturalia
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasemdContentRelation extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('md_content_relation');
        $this->hasColumn('md_content_id_first', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('md_content_id_second', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('object_class_name', 'string', 128, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 128,
             ));
        $this->hasColumn('profile_name', 'string', 128, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 128,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('mdContent as mdContentRelation1', array(
             'local' => 'md_content_id_first',
             'foreign' => 'id'));

        $this->hasOne('mdContent as mdContentRelation2', array(
             'local' => 'md_content_id_second',
             'foreign' => 'id'));
    }
}