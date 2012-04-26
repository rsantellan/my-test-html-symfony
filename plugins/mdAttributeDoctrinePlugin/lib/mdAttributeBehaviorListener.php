<?php

class mdAttributeBehaviorListener extends Doctrine_Record_Listener {

    public function preDelete(Doctrine_Event $event) {
        $object = $event->getInvoker();
        $profileObjectList = Doctrine::getTable('mdProfileObject')->findByMultiples(array('object_id', 'object_class_name'), array($object->getId(), $object->getObjectClass()));
        foreach ($profileObjectList as $profileObject) {
            $profileObject->delete();
        }
        $mdAttributeObjectList = Doctrine::getTable('mdAttributeObject')->findByMultiples(array('object_id', 'object_class_name'), array($object->getId(), $object->getObjectClass()));
        foreach ($mdAttributeObjectList as $mdAttributeObject) {
            $mdAttributeObject->delete();
        }
    }

}

