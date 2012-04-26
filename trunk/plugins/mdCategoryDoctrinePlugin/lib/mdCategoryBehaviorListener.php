<?php
/**
 *
 *
 * @author     maui
 */

class mdCategoryBehaviorListener extends Doctrine_Record_Listener
{
	public function postDelete(Doctrine_Event $event)
	{
        $object = $event->getInvoker();

        $mdCategoryObject = Doctrine::getTable('mdCategoryObject')->retrieveAllObjectInfoOfObject($object);
        foreach($mdCategoryObject as $catObject){
            $catObject->delete();
        }

    }
}