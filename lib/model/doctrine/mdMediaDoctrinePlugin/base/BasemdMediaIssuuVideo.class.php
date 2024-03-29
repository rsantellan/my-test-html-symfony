<?php

/**
 * BasemdMediaIssuuVideo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $documentId
 * @property text $embed_code
 * 
 * @method integer           getId()         Returns the current record's "id" value
 * @method string            getDocumentId() Returns the current record's "documentId" value
 * @method text              getEmbedCode()  Returns the current record's "embed_code" value
 * @method mdMediaIssuuVideo setId()         Sets the current record's "id" value
 * @method mdMediaIssuuVideo setDocumentId() Sets the current record's "documentId" value
 * @method mdMediaIssuuVideo setEmbedCode()  Sets the current record's "embed_code" value
 * 
 * @package    naturalia
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasemdMediaIssuuVideo extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('md_media_issuu_video');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('documentId', 'string', 512, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 512,
             ));
        $this->hasColumn('embed_code', 'text', null, array(
             'type' => 'text',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $mdmediacontentbehavior0 = new mdMediaContentBehavior();
        $this->actAs($mdmediacontentbehavior0);
    }
}