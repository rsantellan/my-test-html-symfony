<?php

/**
 * PluginmdProfileObject
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class PluginmdProfileObject extends BasemdProfileObject
{

    public function retrieveMdProfile()
    {
        return Doctrine::getTable('mdProfile')->retrieveById($this->getMdProfileId());
    }

}