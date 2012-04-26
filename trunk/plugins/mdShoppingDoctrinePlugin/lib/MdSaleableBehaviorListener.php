<?php

class MdSaleableBehaviorListener extends Doctrine_Record_Listener
{
	public function postSave(Doctrine_Event $event)
	{
		$object = $event->getInvoker();
		if (!Doctrine::getTable('mdSaleable')->retreiveByObject($object)){
			$mdSaleable = new mdSaleable();
			$mdSaleable->setObjectClass(get_class($object));
			$mdSaleable->setObjectId($object->getId());
			$mdSaleable->save();
		}
	}

}
