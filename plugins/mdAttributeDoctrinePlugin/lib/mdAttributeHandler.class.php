<?php

class mdAttributeHandler {

    /**
     * Gets all the attributes of a given class
     * @param string $class
     * @return Doctrine_Collection
     * @author Rodrigo Santellan | Gaston Caldeiro
     */
    public static function getAllAttributes($profileId) {
        $list = array();
        $mdAttributes = array();

        
        // Podria joinear estas dos
        $mdProfileAttributes = Doctrine::getTable('mdProfileAttribute')->findBy('md_profile_id', $profileId);
        foreach ($mdProfileAttributes as $mdProfileAttribute) {
            $mdAttributes[] = Doctrine::getTable('mdAttribute')->find($mdProfileAttribute->getMdAttributeId());
        }
        
        
        
        foreach ($mdAttributes as $mdAttribute) {
            $class = $mdAttribute->getInstance();
            array_push($list, $class);
        }
        return $list;
    }

    /**
     * Get all the attributes objects of a given object
     * @param string $class
     * @param int $id
     * @return Doctrine_Collection
     * @author Rodrigo Santellan | Gaston Caldeiro
     */
    public static function retrieveAllAttributesObjects($profileId, $object_class, $object_id) {
        return Doctrine::getTable('mdAttributeObject')->findByMultiples(array('md_profile_id', 'object_class_name', 'object_id'), array($profileId, $object_class, $object_id));
    }

    /**
     * Retrieves the attribute by name
     * @param string $name
     * @param string $class
     * @return Doctrine_collection
     * @author Rodrigo Santellan | Gaston Caldeiro
     */
    public static function retrieveAttributeByName($profileId, $name) {
        $mdProfile = Doctrine::getTable('mdProfile')->find($profileId);
        $mdProfileAttributes = $mdProfile->getMdProfileAttribute();
        $mdAttributes = array();
        foreach ($mdProfileAttributes as $mdProfileAttribute) {
            $mdAttribute = Doctrine::getTable('mdAttribute')->find($mdProfileAttribute->getMdAttributeId());
            $mdAttributes[$mdAttribute->getName()] = $mdAttribute;
        }
        if (array_key_exists($name, $mdAttributes)) {
            return $mdAttributes[$name];
        }
        return false;
    }

    public static function retrieveFormOfSingleAttribute($objectId, $objectClass, $profileId, $mdAttributeId = 0, $mdAttribute = null, $formValues = array())
    {
        if($mdAttributeId == 0 && is_null($mdAttribute))
        {
            throw new Exception("You must given an attribute", 251);
        }
        if($mdAttributeId != 0)
        {
            $mdAttribute = Doctrine::getTable('mdAttribute')->find($mdAttributeId);
        }

        $mdAttributeConcrete = $mdAttribute->getInstance();
        
        //Creo el formulario
        $form = new sfForm();


        //Obtengo los widgets y validarores para trabajar con ellos
        $widgetSchema = $form->getWidgetSchema();
        $validatorSchema = $form->getValidatorSchema();

        //Le pongo el nombre mdAttribute
        $widgetSchema->setNameFormat('one_attribute_form[%s]');
        $widgetSchema['mdProfileId'] = new sfWidgetFormInputHidden(array(), array('value' => $profileId));
        $validatorSchema['mdProfileId'] = new sfValidatorString();
        $widgetSchema->setLabel(array('mdProfileId' => 'Profile Id'));
        $widgetSchema['objectId'] = new sfWidgetFormInputHidden(array(), array('value' => $objectId));
        $validatorSchema['objectId'] = new sfValidatorString();
        $widgetSchema->setLabel(array('objectId' => 'Object Id'));
        $widgetSchema['objectClass'] = new sfWidgetFormInputHidden(array(), array('value' => $objectClass));
        $validatorSchema['objectClass'] = new sfValidatorString();
        $widgetSchema->setLabel(array('objectClass' => 'Object Class'));
        $widgetSchema['mdAttributeId'] = new sfWidgetFormInputHidden(array(), array('value' => $mdAttribute->getId()));
        $validatorSchema['mdAttributeId'] = new sfValidatorString();
        $widgetSchema->setLabel(array('mdAttributeId' => 'attribute id'));
        $attObject = Doctrine::getTable("mdAttributeObject")->getMdAttributeMdProfileByObjectIdAndClass($objectId, $objectClass, $profileId, $mdAttribute->getId(), true);
        if ($attObject != null) {
            
            //si es i18n
            if($mdAttribute->getTranslated())
            {
              $mdAttributeConcrete->setValue($attObject->getValue());
            }
            else
            {
              $mdAttributeConcrete->setValue($attObject->getValueNonTranslated());
            }
                //Si el mdAttributeObject no es nulo, le inyecto el valor al widget.
                
                
             //else
                //
                
            //print_r($attObject->getValue());
            if ($attObject->getMdAttributeValueId()) {
                $mdAttributeConcrete->setMyMdAttributeValueId($attObject->getMdAttributeValueId());
            }
        }

        if(count($formValues) != 0){
            if (!$mdAttributeConcrete->isDateWidget()) {
                if (!$mdAttributeConcrete->isCheckBox()) {
                    if(isset($formValues[$mdAttributeConcrete->getName()])){
                        //si es i18n
                        $mdAttributeConcrete->setValue($formValues[$mdAttributeConcrete->getName()]);
                    }
                }
            }else{
                $value = $formValues[$mdAttributeConcrete->getName()]['year'].' - '.$formValues[$mdAttributeConcrete->getName()]['month'].' - '.$formValues[$mdAttribute->getName()]['day'];
                //si es i18n
                $mdAttributeConcrete->setValue($value);
            }
        }
        //Agrego el widget y el validador.
        $widgetSchema['widget'] = $mdAttributeConcrete->getWidget();
        $validatorSchema['widget'] = $mdAttributeConcrete->getValidator();
        if ($attObject != null) {
            if ($attObject->getMdAttributeValueId()) {
                //En caso de que tenga un mdAttributeValue.
                if ($mdAttributeConcrete->isMultiple()) {
                    //Si es multiple creo una lista y se la agrego
                    $mdAttributeObjects = self::retrieveAllAtributeObjects($profileId, $mdAttributeConcrete->getId(), $id, $class);
                    $list = array();
                    foreach ($mdAttributeObjects as $val) {
                        array_push($list, $val->getMdAttributeValueId());
                    }
                    $form->setDefault($mdAttributeConcrete->getName(), $list);
                } else {
                    if ($mdAttributeConcrete->isDateWidget()) {
                        //print_r('tengo un valor:');
                    } else {
                        //Si es simple lo pongo y ya esta.
                        $form->setDefault($mdAttributeConcrete->getName(), $attObject->getMdAttributeValueId());
                    }
                }
            }
        }
        //Seteo los schemas
        $form->setWidgetSchema($widgetSchema);
        $form->setValidatorSchema($validatorSchema);
        $form->getWidgetSchema()->setFormFormatterName('list');

        return $form;
    }

    public static function saveSingleAttributeForm($sfForm)
    {
        $tainted = $sfForm->getTaintedValues();
        $objectId = $tainted['objectId'];
        $objectClass = $tainted['objectClass'];
        $profileId = $tainted['mdProfileId'];
        $attributeId = $tainted['mdAttributeId'];
        $mdAttribute = Doctrine::getTable("mdAttribute")->find($attributeId);
        
        self::saveWidget($objectId, $objectClass, $profileId, $mdAttribute->getInstance(), $tainted, 'widget');
    }


    private static function saveWidget($objectId, $objectClass, $profileId, $mdAttribute, $tainted, $widgetDefaultName = NULL)
    {

        $default_widget_name = "";
        if(is_null($widgetDefaultName))
        {
            $default_widget_name = $mdAttribute->getName();
        }
        else
        {
            $default_widget_name = $widgetDefaultName;
        }
        if (isset($tainted[$default_widget_name])) 
        {
          if ($mdAttribute->isMultiple()) 
          {
            //Si existe alguno borra todo
            self::removeAllAtributeObjects($profileId, $mdAttribute->getId(), $objectId, $objectClass);
            //ahora guarda
            $aux_tainted = $tainted[$default_widget_name];
            /*******************
             * 
             * Este chequeo se usa por que habia algunos widget que no devolvian array.
             * En este momento no deberia de entrar ninguno por aca. 
             * 
             ******************/ 
            if(!is_array($aux_tainted))
            {
              $aux_tainted_a = $aux_tainted;
              $aux_tainted = array();
              $aux_tainted[] = $aux_tainted_a;
            }
            
            foreach ($aux_tainted as $value) 
            {
              //Creo el objeto y lo guardo
              $mdAttributeObject = new mdAttributeObject();
              if ($mdAttribute->isValueDependent()) 
              {
                  $attId = $value;
                  $mdAttributeObject->setMdAttributeValueId($attId);
              }
              $mdAttributeObject->setMdProfileId($profileId);
              $mdAttributeObject->setObjectClassName($objectClass);
              $mdAttributeObject->setObjectId($objectId);
              $mdAttributeObject->setMdAttributeId($mdAttribute->getId());
              if(!$mdAttribute->getTranslated())
              {
                /***** El atributo no es i18n ********/
                $mdAttributeObject->setValueNonTranslated($value);
              }
              else
              {
                /***** El atributo es i18n ********/
                $mdAttributeObject->setValue($value);                 
              }                 
              $mdAttributeObject->save();
            }
          } 
          else 
          {
            $value = "";
            if ($mdAttribute->isDateWidget()) 
            {
                /**** Lo que se usaba en el global ***/
                $value = $tainted[$mdAttribute->getName()]['year'].'-'.$tainted[$mdAttribute->getName()]['month'].'-'.$tainted[$mdAttribute->getName()]['day'];
                /**** Este es el nuevo ***/
                //$value = $tainted[$default_widget_name]['year'].' - '.$tainted[$mdAttribute->getName()]['month'].' - '.$tainted[$mdAttribute->getName()]['day'];
                /**** Verificar cual de los dos es el correcto. ***/
            } 
            else 
            {
                $value = $tainted[$default_widget_name];
            }
            //print_r($value);
            if(get_class($mdAttribute) == "mdAttributeWidgetDateJavascript")
            {
                $value = $value['date'];
            }

            //Creo el objeto y lo guardo
            $mdAttributeObject = new mdAttributeObject();
            //sfContext::getInstance(()->getLogger()->err('-----call to getAttributeObjectOfAttribute-----');
            /*******Se sustituyo por la llamada directa. Esto se hizo por que no estaba devolviendo el objecto hidratado.*****/
            //$attObject = $this->getAttributeObjectOfAttribute($mdAttributeObjects, $mdAttribute->getId());
            $attObject = Doctrine::getTable("mdAttributeObject")->getMdAttributeMdProfileByObjectIdAndClass($objectId, $objectClass, $profileId, $mdAttribute->getId(), true);
            if ($attObject != null) 
            {
              if (!$mdAttribute->isMultiple()) 
              {
                $mdAttributeObject = Doctrine::getTable('mdAttributeObject')->find($attObject->getId());
              }
            }
            if ($mdAttribute->isValueDependent()) 
            {
              $attId = $tainted[$default_widget_name];
              if($attId != 0)
              {
                  $mdAttributeObject->setMdAttributeValueId($attId);
              }
            }
            $mdAttributeObject->setMdProfileId($profileId);
            $mdAttributeObject->setObjectClassName($objectClass);
            $mdAttributeObject->setObjectId($objectId);
            $mdAttributeObject->setMdAttributeId($mdAttribute->getId());
            if(!$mdAttribute->getTranslated())
            {
              /***** El atributo no es i18n ********/
              $mdAttributeObject->setValueNonTranslated($value);
            }
            else
            {
              /***** El atributo es i18n ********/
              $mdAttributeObject->setValue($value);                 
            } 
                
            $mdAttributeObject->save();
          }
        }
        else
        {
          if($mdAttribute->isCheckBox())
          {
           $attObject = Doctrine::getTable("mdAttributeObject")->getMdAttributeMdProfileByObjectIdAndClass($objectId, $objectClass, $profileId, $mdAttribute->getId(), true);
           if ($attObject != null) 
           {
             $attObject->delete();
           }
          }
        }
    }
    
    /**
     * Retrieves the attribute object by name
     * @param string $name
     * @param int $id
     * @param string $class
     * @return Doctrine_Collection
     * @author Rodrigo Santellan | Gaston Caldeiro
     */
    public static function retrieveAttributeObjectsByAttributeName($profileId, $name, $id, $class) {
        $mdAttribute = self::retrieveAttributeByName($profileId, $name);
        $mdAttributesObject = Doctrine::getTable('mdAttributeObject')->findByMultiples(array('md_profile_id', 'md_attribute_id', 'object_id', 'object_class_name'), array($profileId, $mdAttribute->getId(), $id, $class), true);
        return $mdAttributesObject;
    }

    /**
     * Retrieves the attribute form of a given object
     * @param int $id
     * @param string $class
     * @return Doctrine_Collection
     * @author Rodrigo Santellan
     */
    public function getAllAttributesForm($profileId, $id, $class, $formValues = array()) {
        //Creo el formulario
        $form = new sfForm();

        //Obtengo los widgets y validarores para trabajar con ellos
        $widgetSchema = $form->getWidgetSchema();
        $validatorSchema = $form->getValidatorSchema();

        //Le pongo el nombre mdAttribute
        $widgetSchema->setNameFormat('mdAttributes_' . $profileId . '[%s]');

        if ($profileId == 0) return $form;

        $widgetSchema['mdProfileId'] = new sfWidgetFormInputHidden(array(), array('value' => $profileId));
        $validatorSchema['mdProfileId'] = new sfValidatorInteger();
        $widgetSchema->setLabel(array('mdProfileId' => 'Profile Id'));
        $mdAttributeObjects = array();

        //Si existe el id entonces voy a buscar todos los valores para los atributos.
        if ($id) {
            $mdAttributeObjects = self::retrieveAllAttributesObjects($profileId, $class, $id);
        }

        //Para cada atributo del perfil voy creando los widgets.
        $mdAttributes = self::getAllAttributes($profileId);
        foreach ($mdAttributes as $mdAttribute) {
            
            /**********************************************************************/
            //Obtengo el mdAttributeObject relacionado a ese atributo.
            $attObject = $this->getAttributeObjectOfAttribute($mdAttributeObjects, $mdAttribute->getId());
            if ($attObject != null) {
                // Si no es i18n
                if(!$mdAttribute->getTranslated())
                {
                  $mdAttribute->setValue($attObject->getValueNonTranslated());
                }
                else
                {
                  //Si el mdAttributeObject no es nulo, le inyecto el valor al widget.
                  $mdAttribute->setValue($attObject->getValue());                    
                }
                //print_r($attObject->getValue());
                if ($attObject->getMdAttributeValueId()) {
                    $mdAttribute->setMyMdAttributeValueId($attObject->getMdAttributeValueId());
                }
            }

            /****************************
             * 
             * Aca no importa si tienen o no i18n por que son los valores que estan embebidos en el form que quiere
             * salvar el usuario. Esto se usa para poder retener los datos del mismo.
             * 
             *****************************/ 
            if(count($formValues) != 0){
                if (!$mdAttribute->isDateWidget()) {
                    if (!$mdAttribute->isCheckBox()) {
                        if(isset($formValues[$mdAttribute->getName()])){
                            $mdAttribute->setValue($formValues[$mdAttribute->getName()]);
                        }
                    }
                }else{
                    $value = $formValues[$mdAttribute->getName()]['year'].' - '.$formValues[$mdAttribute->getName()]['month'].' - '.$formValues[$mdAttribute->getName()]['day'];
                    $mdAttribute->setValue($value);
                }
                
            }
            //Podria ir a una funcion hydrate de cada widget
            /**********************************************************************/            
            
            //Agrego el widget y el validador.
            $widgetSchema[$mdAttribute->getName()] = $mdAttribute->getWidget();
            $validatorSchema[$mdAttribute->getName()] = $mdAttribute->getValidator();


// QUE ES ESTO***************************************
            if ($attObject != null) {
                if ($attObject->getMdAttributeValueId()) {
                    //En caso de que tenga un mdAttributeValue.
                    if ($mdAttribute->isMultiple()) {
                        //Si es multiple creo una lista y se la agrego
                        $mdAttributeObjectsAuxiliar = self::retrieveAllAtributeObjects($profileId, $mdAttribute->getId(), $id, $class);
                        $list = array();
                        foreach ($mdAttributeObjectsAuxiliar as $val) {
                            array_push($list, $val->getMdAttributeValueId());
                        }
                        $form->setDefault($mdAttribute->getName(), $list);
                    } else {

                        if ($mdAttribute->isDateWidget()) {
                            //print_r('tengo un valor:');
                        } else {
                            //Si es simple lo pongo y ya esta.
                            $form->setDefault($mdAttribute->getName(), $attObject->getMdAttributeValueId());
                        }
                    }
                }
            }
        }
/**********************************************************/

        //Seteo los schemas
        $form->setWidgetSchema($widgetSchema);
        $form->setValidatorSchema($validatorSchema);
        $form->getWidgetSchema()->setFormFormatterName('list');

        return $form;
    }

    /**
     * Retrieves all the attribute object of an attribute
     * @param array $attObjectList
     * @param int $AttId
     * @return Doctrine_Collection
     * @author Rodrigo Santellan
     */
    private function getAttributeObjectOfAttribute($attObjectList, $AttId) {
        $index = 0;
        $found = false;
        while ($index < count($attObjectList) && !$found) {
            $attObject = $attObjectList[$index];
            if ($attObject->getMdAttributeId() == $AttId) {
                return $attObject;
            }
            $index++;
        }

        return null;
    }

    /**
     * Saves all the attributes
     * @param int $id
     * @param string $class
     * @param sfForm $sfForm
     * @return void
     * @author Rodrigo Santellan | Gaston Caldeiro
     */
    public function saveAllAttributes($id, $class, $sfForm) {
        //Obtengo todos los valores del formulario
        $tainted = $sfForm->getTaintedValues();
        $profileId = $tainted['mdProfileId'];

        unset($tainted['mdProfileId']);
        $mdAttributeObjects = array();
        if ($id) {
            //En caso de que sea un objecto existente busca los mdAttributeObjects para modificarlos
            $mdAttributeObjects = mdAttributeHandler::retrieveAllAttributesObjects($profileId, $class, $id);
        }

        foreach (self::getAllAttributes($profileId) as $mdAttribute) {
            self::saveWidget($id, $class, $profileId, $mdAttribute, $tainted);
        }

        //Asocio el producto al profile en la tabla mdProfileObject
        $mdProfileObject = Doctrine::getTable('mdProfileObject')->findByMultiples(array('object_id', 'object_class_name', 'md_profile_id'), array($id, $class, $profileId));
        if (count($mdProfileObject) == 0) {
            $mdProfileObject = new mdProfileObject();
            $mdProfileObject->setObjectId($id);
            $mdProfileObject->setObjectClassName($class);
            $mdProfileObject->setMdProfileId($profileId);
            $mdProfileObject->setActive(1);
            $mdProfileObject->save();
        }
    }

    /**
     * Devuelve los perfiles de un objeto dados su id y su clase.
     * Si $active es true devuelve el perfil activo
     * sino devuelve todos los perfiles que tiene el objeto
     *
     * @param <integer> $object_id
     * @param <string> $object_class
     * @param <boolean> $active
     * @return <mdProfile>
     */
    public static function retrieveProfiles($object_class, $object_id = NULL, $active = false) {

        if (is_null($object_id)) {
            $mdProfiles = Doctrine::getTable('mdProfile')->findBy('object_class_name', $object_class);
            
            if (count($mdProfiles) == 0) {
                return null;
            }
            if (count($mdProfiles) > 1) {
                throw new Exception('too many profiles', 101);
            }

            return $mdProfiles[0];
        } else {
            if ($active) {

                $mdProfileObject = Doctrine::getTable('mdProfileObject')->findByMultiples(array('object_id', 'object_class_name', 'active'), array($object_id, $object_class, (integer) $active), true);

                if (!$mdProfileObject)
                    return null;

                if (count($mdProfileObject) === 0) {
                    throw new Exception('Error: no profile object', 100);
                }

                return $mdProfileObject->getMdProfile();
            } else {

                $mdProfiles = array();
                $mdProfileObjects = Doctrine::getTable('mdProfileObject')->findByMultiples(array('object_id', 'object_class_name'), array($object_id, $object_class));
                if (count($mdProfileObjects) === 0) {
                    throw new Exception('Error: no profile object', 100);
                }
                foreach ($mdProfileObjects as $mdProfileObject) {
                    $mdProfiles[] = $mdProfileObject->getMdProfile();
                }
                return $mdProfiles;
            }
        }
    }

    public static function hasProfile($mdProfileName, $object) {
        $mdProfile = Doctrine::getTable('mdProfile')->findOneBy('name', $mdProfileName);
        if (!$mdProfile)
            return false;
        $mdProfileObject = Doctrine::getTable('mdProfileObject')->findByObjectAndMdProfile($object, $mdProfile->getId());
        if ($mdProfileObject)
            return true;
        return false;
    }

    public static function addProfile($objectId, $objectClass, $mdProfileId) {
        $mdProfileObject = new mdProfileObject();
        $mdProfileObject->setObjectId($objectId);
        $mdProfileObject->setObjectClassName($objectClass);
        $mdProfileObject->setMdProfileId($mdProfileId);
        $mdProfileObject->setActive(true);
        if ($mdProfileObject->save()) {
            return true;
        } else {
            return false;
        }
    }

    public static function addProfileByName($objectId, $objectClass, $mdProfileName) {
        $mdProfile = Doctrine::getTable('mdProfile')->findOneBy('name', $mdProfileName);
        if (!$mdProfile) {
            throw new Exception('No mdProfile', 162);
        }
        self::addProfile($objectId, $objectClass, $mdProfile->getId());
    }

  public static function retrieveAttributeObjectsByProfileAttributeNameAndValue($mdProfileId, $mdAttributeName, $value = null, $page = 1, $limit = null)
  {
    $mdAttribute = Doctrine::getTable('mdAttribute')->findOneBy('name', $mdAttributeName);
    return self::retrieveAttributeObjectsByProfileAttributeIdAndValue($mdProfileId, $mdAttribute->getId(), $value, $page, $limit);
  }  

  public static function retrieveAttributeObjectsByProfileAttributeIdAndValue($mdProfileId, $mdAttributeId, $value = null,  $page = 1, $limit = null)
  {
    $objectList = Doctrine::getTable('mdAttributeObject')->retrieveAllAttributesObjectsByProfileIdAttributeIdAndValue($mdProfileId, $mdAttributeId, $value,  $page, $limit);
    $list = array();
    foreach($objectList as $object)
    {
      array_push($list, $object->retrieveObject());
    }
    return $list;
  }

  public static function retrieveAttributeObjectsIdsByProfileAttributeNameAndValue($mdProfileId, $mdAttributeName, $value = null, $page = 1, $limit = null)
  {
    $mdAttribute = Doctrine::getTable('mdAttribute')->findOneBy('name', $mdAttributeName);
    return self::retrieveAttributeObjectsByProfileAttributeIdAndValue($mdProfileId, $mdAttribute->getId(), $value, $page, $limit);
  }  

  public static function retrieveAttributeObjectsIdsByProfileAttributeIdAndValue($mdProfileId, $mdAttributeId, $value = null,  $page = 1, $limit = null)
  {
    $objectList = Doctrine::getTable('mdAttributeObject')->retrieveAllAttributesObjectsByProfileIdAttributeIdAndValue($mdProfileId, $mdAttributeId, $value,  $page, $limit);
    $list = array();
    foreach($objectList as $object)
    {
      array_push($list, $object->getObjectId());
    }
    return $list;
  }
    
  public static function retrieveProfilesOfGivenClass($object_class)
  {
    return $mdProfiles = Doctrine::getTable('mdProfile')->findBy('object_class_name', $object_class);
  }

  public static function retrieveAllAtributeObjects($profile_id, $md_attribute_id, $object_id, $object_class)
  {
      return Doctrine::getTable('mdAttributeObject')->getMdAttributeMdProfileByObjectIdAndClass($object_id, $object_class, $profile_id, $md_attribute_id, false);
  }

  public static function removeAllAtributeObjects($profile_id, $md_attribute_id, $object_id, $object_class)
  {
    
    $mdAttributeObjects = self::retrieveAllAtributeObjects($profile_id, $md_attribute_id, $object_id, $object_class);
    foreach($mdAttributeObjects as $ao)
    {
        $ao->delete();
    }
  }

  public static function addValueToObject($profile_id, $md_attribute_id, $object_id, $object_class, $value, $is_translated = false, $value_id = NULL)
  {
    $mdAttributeObject = new mdAttributeObject();
    $mdAttributeObject->setObjectId($object_id);
    $mdAttributeObject->setObjectClassName($object_class);
    $mdAttributeObject->setMdAttributeId($md_attribute_id);
    $mdAttributeObject->setMdAttributeValueId($value_id);
    if($is_translated)
    {
      //$mdAttributeObject->setValueNonTranslated();
      throw new Exception("no lo soporto por ahora", 1293);
    }
    else
    {
      $mdAttributeObject->setValueNonTranslated($value);
    }
    $mdAttributeObject->setMdProfileId($profile_id);
    $mdAttributeObject->save();
    
  }
  
  /**
   * Busca la palabra en los valores introducidos en los objetos
   * 
   * @param <String> $word Palabra clave a buscar
   * @param <String> $object_class Si se quiere especificar la clase en la cual buscar
   * @param <String> $lang Si se quiere especificar el idioma en el cual buscar, por defecto es español
   * @return array
   *        Con el formato array([id], [clase]) si no se le pasa la clase
   *        Con el formato [id] si se le pasa la clase
   */
  public static function searchContents($word, $object_class = NULL, $lang = "es")
  {
      $list =  Doctrine::getTable("mdAttributeObject")->searchContents($word, $object_class, $lang);
      $return = array();
      foreach($list as $object)
      {
          if(is_null($object_class))
          {
              $auxiliar = array();
              $auxiliar['id'] = $object["mdC_object_id"];
              $auxiliar['class'] = $object["mdC_object_class_name"];
              array_push($return, $auxiliar);
          }
          else
          {
              array_push($return, $object["mdC_object_id"]);
          }

      }
      return $return;
  }
}
