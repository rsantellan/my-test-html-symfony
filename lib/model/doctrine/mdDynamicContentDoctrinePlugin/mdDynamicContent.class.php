<?php

/**
 * mdDynamicContent
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    naturalia
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class mdDynamicContent extends PluginmdDynamicContent
{

    public function __toString()
    {
        $string = "";
        switch($this->getTypeName())
        {
            case "locales";
                $profile = mdProfileHandler::getInstance($this)->loadProfile('locales');
                $string = $profile->getValue('nombre');
            break;
            case "puntoVenta";
                $profile = mdProfileHandler::getInstance($this)->loadProfile('puntoVenta');
                $string = $profile->getValue('nombre');
            break;
        }
        return $string;
    }
}