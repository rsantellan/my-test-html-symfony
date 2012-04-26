<?php

class mdAttributeBehavior extends Doctrine_Template {

    public function setTableDefinition() {
        $this->addListener(new mdAttributeBehaviorListener());
    }

    public function setTmpMdAttributesValues($values) {
        if (count($values) != 0) {
            $this->setEmbedProfile(true);
        }
        $this->getInvoker()->tmp_array_md_attribute_values = $values;
    }

    public function getTmpMdAttributesValues() {
        try {
            return $this->getInvoker()->tmp_array_md_attribute_values;
        } catch (Exception $e) {
            throw new Exception("Missing tmp_array_md_attribute_values variable in the object with the mdAttribute behavior", 190);
        }
    }

    /**
     * @deprecated use saveTmpMdProfileId
     * @param int $tmpMdProfileId
     */
    public function setTmpMdProfileId($tmpMdProfileId) {
        $this->setEmbedProfile(true);
        $this->getInvoker()->tmp_profile_id = $tmpMdProfileId;
    }

    public function saveTmpMdProfileId($tmpMdProfileId) {
        $this->setEmbedProfile(true);
        $this->getInvoker()->tmp_profile_id = $tmpMdProfileId;
    }

    public function getTmpArrayMdProfileId() {
        return $this->getInvoker()->tmp_array_profile_id;
    }

    public function setTmpArrayMdProfileId($array) {
        $this->getInvoker()->tmp_array_profile_id = $array;
    }

    public function addTmpArrayMdProfileId($id) {
        if (is_null($this->getInvoker()->tmp_array_profile_id)) {
            $this->getInvoker()->tmp_array_profile_id = array();
        }
        array_push($this->getInvoker()->tmp_array_profile_id, $id);
    }

    public function getTmpMdProfileId() {
        return $this->getInvoker()->tmp_profile_id;
    }

    public function setEmbedProfile($boolean) {
        $this->getInvoker()->mdEmbedProfile = $boolean;
    }

    public function getEmbedProfile() {
        return $this->getInvoker()->mdEmbedProfile;
    }

    /**
     * Retrieves all the atributes objects by attribute name
     * @param string $name
     * @return Doctrine_Collection
     * @author Rodrigo Santellan
     */
    public function retrieveAtributeObjectsByAttributeName($name, $profileName = null) {
        $class = get_class($this->getInvoker());
        $id = $this->getInvoker()->getId();
        if (is_null($profileName)) {
            $mdProfile = mdAttributeHandler::retrieveProfiles($class, $id, true);
        } else {
            $mdProfile = Doctrine::getTable('mdProfile')->findOneBy('name', $profileName);
        }

        return mdAttributeHandler::retrieveAttributeObjectsByAttributeName($mdProfile->getId(), $name, $id, $class);
    }

    public function retrieveAtributeValueObjectsByAttributeName($name, $profileName = null) {
        $object = $this->retrieveAtributeObjectsByAttributeName($name, $profileName);
        if (!$object
            )return "";
        return $object->getValue();
    }

    /**
     * Retrieves the attribute form
     * @return array de sfForm
     * @author Rodrigo Santellan
     */
    public function retrieveAllAttributesForm() {
        $class = get_class($this->getInvoker());
        $id = $this->getInvoker()->getId();
        $handler = new mdAttributeHandler();
        $return = array();
        if (!$this->getEmbedProfile()) {
            return $return;
        }
        $setedValues = $this->getInvoker()->getTmpMdAttributesValues();
        if (is_null($this->getTmpArrayMdProfileId())) {
            $mdProfile = mdAttributeHandler::retrieveProfiles($class, $id, true);
            if (!is_null($mdProfile)) {
                $mdProfileId = $mdProfile->getId();
            } else {
                $mdProfileId = 0;
            }
            $tmpSetedValues = array();
            if (isset($setedValues[$mdProfileId])) {
                $tmpSetedValues = $setedValues[$mdProfileId];
            }
            array_push($return, $handler->getAllAttributesForm($mdProfileId, $id, $class, $tmpSetedValues));
        } else {
            //print_r('no es nulo el tmp_profile_id');
            foreach ($this->getTmpArrayMdProfileId() as $tmpProfileid) {
                $tmpSetedValues = array();
                if (isset($setedValues[$tmpProfileid])) {
                    $tmpSetedValues = $setedValues[$tmpProfileid];
                }
                array_push($return, $handler->getAllAttributesForm($tmpProfileid, $id, $class, $tmpSetedValues));
            }
        }

        return $return;
    }

    /**
     * Saves all the attributes of the given form
     * @param sfForm $sfForm
     * @return sfForm
     * @author Rodrigo Santellan
     */
    public function saveAllAttributes($sfForm) {
        $id = $this->getInvoker()->getId();
        $class = get_class($this->getInvoker());
        $handler = new mdAttributeHandler();
        $this->refreshCache($id, $class);
        return $handler->saveAllAttributes($id, $class, $sfForm);
    }

    private function refreshCache($object_id, $object_class) {
        if (sfConfig::get('sf_driver_cache')) {
            $manager = Doctrine_Manager::getInstance();
            $cacheDriver = $manager->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
            $key = sfConfig::get('sf_root_dir') . '_md_attribute_id_' . $object_id . '_class_' . $object_class;
            $cacheDriver->deleteByPrefix($key);
        }
        Doctrine::getTable('mdAttribute')->refreshCache($object_id, $object_class);
    }

    /**
     * Gets all the attributes of an object
     * @return Doctrine_Collection
     * @author Rodrigo Santellan
     */
    public function getAllAtributes() {
        $class = get_class($this->getInvoker());
        return mdAttributeHandler::getAllAttributes($class);
    }

    /**
     * Retrieves all the attributes objects
     * @return Doctrine_Collection
     * @author Rodrigo Santellan
     */
    public function retrieveAllAtributesObjects($profileId) {
        $class = get_class($this->getInvoker());
        $id = $this->getInvoker()->getId();
        return mdAttributeHandler::retrieveAllAttributesObjects($profileId, $class, $id);
    }

    public function hasProfile($mdProfileName) {
        return mdAttributeHandler::hasProfile($mdProfileName, $this->getInvoker());
    }

    public function addProfile($mdProfileName) {
        $mdProfile = Doctrine::getTable('mdProfile')->findOneBy('name', $mdProfileName);
        if (!$mdProfile) {
            throw new Exception('No mdProfile', 162);
        }
        return $this->getInvoker()->executeAddProfile($mdProfile->getId());
    }

    public function addProfileById($id) {
        return $this->getInvoker()->executeAddProfile($id);
    }

    public function executeAddProfile($mdProfileId) {
        $mdProfile = Doctrine::getTable('mdProfile')->find($mdProfileId);
        if ($this->getInvoker()->hasProfile($mdProfile->getName()))
            return false;
        $class = get_class($this->getInvoker());
        $id = $this->getInvoker()->getId();
        return mdAttributeHandler::addProfile($id, $class, $mdProfileId);
    }

    public function getAttributesFormOfMdProfile($mdProfileName) {
        $mdProfile = Doctrine::getTable('mdProfile')->findOneBy('name', $mdProfileName);
        if (!$mdProfile)
            return null;
        $class = get_class($this->getInvoker());
        $id = $this->getInvoker()->getId();
        $handler = new mdAttributeHandler();

        return $handler->getAllAttributesForm($mdProfile->getId(), $id, $class);
    }

    public function getAttributesFormOfMdProfileById($mdProfileId) {
        $class = get_class($this->getInvoker());
        $id = $this->getInvoker()->getId();
        $handler = new mdAttributeHandler();

        return $handler->getAllAttributesForm($mdProfileId, $id, $class);
    }

    public function getAllUsedProfiles() {
        return Doctrine::getTable('mdProfileObject')->findByMultiples(array('object_id', 'object_class_name'), array($this->getInvoker()->getId(), $this->getInvoker()->getObjectClass()));
    }

    public function getAllObjectProfile() {
        return Doctrine::getTable('mdProfile')->findBy('object_class_name', $this->getInvoker()->getObjectClass());
    }

    public function getAllObjectsOfProfile($mdProfileName) {
        $mdProfile = Doctrine::getTable('mdProfile')->findOneBy('name', $mdProfileName);
    }

    public function getAllObjctsIdsOfProfile($mdProfileName) {
        $mdProfile = Doctrine::getTable('mdProfile')->findOneBy('name', $mdProfileName);
        if ($mdProfile) {
            return Doctrine::getTable('mdProfileObject')->findAllObjectIdsByMdProfile($this->getInvoker(), $mdProfile->getId());
        }
        return Doctrine::getTable('mdProfileObject')->findAllObjectIdsByMdProfile($this->getInvoker(), 0);
    }

    public function getAttributeLabel($name) {

        return Doctrine::getTable('mdAttribute')->findBy('name', $name)->getFirst()->getLabel();
    }

    public function getProfile($type = null) {
        $profile = mdProfileHandler::getInstance($this->getInvoker())->loadProfile($type);
        return $profile;
    }

}

