<?php
/**
 * Forma de uso:
 *
 *  $mdObject = Doctrine::getTable('mdProduct')->find(2);
 * 
 *  try{
 * 
 *      $profile = mdProfileHandler::getInstance($mdObject)->loadProfile('perfil 1');
 * 
 *      $profile = mdProfileHandler::getInstance($mdObject)->loadProfile('perfil 2');
 * 
 *      $profile = mdProfileHandler::getInstance($mdObject)->loadProfile('perfil 3');
 * 
 *  }catch(Exception $e){
 *      
 *  }
 *
 *  $label = $profile->getLabel('atributo', 'perfil 1');
 * 
 *  $value = $profile->getValue('atributo', 'perfil 1');
 * 
 *  $label = $profile->getLabel('atributo', 'perfil 2');
 * 
 *  $value = $profile->getValue('atributo', 'perfil 2');
 * 
 * 
 * Otra forma de uso:
 * 
 *  $mdObject = Doctrine::getTable('mdProduct')->find(2);
 * 
 *  $profile = mdProfileHandler::getInstance($mdObject)->loadProfile('perfil');
 * 
 *  $label = $profile->getLabel('atributo');
 * 
 *  $value = $profile->getValue('atributo');
 * 
 * @package mdAttributeDoctrinePlugin
 * @author  Gaston Caldeiro
 * @version 1.1
 * 
 */
class mdProfileHandler 
{
    private $mdObject   = NULL;
    
    private $profiles   = array();

    private $attributes = array();

    private $values     = array();    
    
    private $profile_load       = NULL;
    
    private $attributesHashMap  = array();
    
    private static $collection  = array();

    // Metodos de Instanciacion
    
    /**
     * Devuelve una instancia del mdProfileHandler para el objeto $mdObject
     * Excepciones;
     *  100: No se ha pasado un objeto
     * 
     * @param object $mdObject
     * @return mdProfileHandler 
     */
    public static function getInstance($mdObject)
    {
        if(is_null($mdObject))
        {
            throw new Exception('you have to set an mdObject in mdProfileHandler::getInstance()', 100);
        }
        else
        {
            if(array_key_exists($mdObject->getObjectClass() . '_' . $mdObject->getId(), self::$collection))
            {
               return self::$collection[$mdObject->getObjectClass() . '_' . $mdObject->getId()];
            }
            else
            {
                $instance           = new mdProfileHandler();
                
                $instance->mdObject = $mdObject;
                
                self::$collection[$mdObject->getObjectClass() . '_' . $mdObject->getId()] = $instance;
                
                return $instance;
            }
        }
    }
    
    /**
     * Constructor
     */
    private function  __construct()
    {
    }    
    
    // Metodos Publicos
    
    /**
     * Devuelve el valor del atributo de clave $key y perfil $profile
     * Si no se pasa ningun profile, el metodo intentara devolver el valor
     * de la clave pasada del ultimo perfil cargado en el loadProfile.
     * 
     * Excepciones;
     *  101: No se ha pasado un $profile como parametro y no se cargo ningun profile previo al llamado de esta funcion y 
     *  102: No se ha cargado el profile o el objeto no lo tiene
     *  104: El perfil no tiene el atributo pasado como parametro
     * 
     * @param string $key
     * @param string $profile
     * @return string
     */
    public function getValue($key, $profile = NULL)
    {
        try
        {
            if(is_null($profile))
            {
                if(is_null($this->profile_load))
                {
                    throw new Exception('you have to load a profile first', 101);
                }
                else
                {
                    $profile = $this->profile_load;
                }
            }
            
            if(isset($this->profiles[$profile]))
            {
                if(isset($this->attributes[$profile][$key]))
                {
                    if(!is_null($this->values[$profile][$this->attributes[$profile][$key]['id']]))
                    {
                        return $this->values[$profile][$this->attributes[$profile][$key]['id']]->value;                    
                    }
                    else
                    {
                        return '';
                    }                    
                }
                else
                {
                    throw new Exception('profile has not attribute ' . $key, 104);
                }
            }
            else
            {
                throw new Exception('object has not profile ' . $profile . ' or profile not loaded', 102);
            }
        }
        catch(Excpetion $e)
        {
            throw $e;
        }
    }

    /**
     * Devuelve el nombre del atributo de clave $key y perfil $profile
     * Si no se pasa ningun profile, el metodo intentara devolver el valor
     * de la clave pasada del ultimo perfil cargado en el loadProfile.
     * 
     * Excepciones;
     *  101: No se ha pasado un $profile como parametro y no se cargo ningun profile previo al llamado de esta funcion y 
     *  102: No se ha cargado el profile o el objeto no lo tiene
     *  104: El perfil no tiene el atributo pasado como parametro
     *  105: El label del atributo no ha sido traducido
     * 
     * @param string $key
     * @param string $profile
     * @return string 
     */
    public function getLabel($key, $profile = NULL)
    {
        try
        {
            if(is_null($profile))
            {
                if(is_null($this->profile_load))
                {
                    throw new Exception('you have to load a profile first', 101);
                }
                else
                {
                    $profile = $this->profile_load;
                }
            }
            
            if(isset($this->profiles[$profile]))
            {
                if(isset($this->attributes[$profile][$key]))
                {
                    if(isset($this->attributes[$profile][$key]['Translation'][sfContext::getInstance()->getUser()->getCulture()]))
                    {
                        return $this->attributes[$profile][$key]['Translation'][sfContext::getInstance()->getUser()->getCulture()]['label'];                        
                    }
                    else
                    {
                        throw new Exception('label of attribute ' . $key . ' has not been translated', 105);
                    }

                }
                else
                {
                    throw new Exception('profile has not attribute ' . $key, 104);                    
                }
            }
            else
            {
                throw new Exception('object has not profile ' . $profile . ' or profile not loaded', 102);
            }
        }
        catch(Excpetion $e)
        {
            throw $e;
        }
    }

    /**
     * Carga el profile del objeto instanciado en el getInstance
     * 
     * @param string $profile
     * @return mdProfileHandler 
     */
    public function loadProfile($profile)
    {
        $attribute_ids = array();

        if($this->hasProfile($profile))
        {
            $this->profile_load = $profile;
            
            // Cargo todos los atributos en attributesHashMap
            $attributes = Doctrine::getTable('mdAttribute')->findAttributes(sfContext::getInstance()->getUser()->getCulture());

            foreach($attributes as $attribute)
            {

                $this->attributesHashMap[$attribute['id']] = $attribute;
            }


            $profileAttributesIds = Doctrine::getTable('mdProfileAttribute')->findBy('md_profile_id', $this->profiles[$profile]->id, Doctrine_Core::HYDRATE_ARRAY);

            foreach($profileAttributesIds as $k => $data)
            {
                // Cargo los atributos del perfil
                $this->attributes[$profile][$this->attributesHashMap[$data['md_attribute_id']]['name']] = $this->attributesHashMap[$data['md_attribute_id']];
                
                // Inicializo los valores de cada uno de los atributos del perfil vacio
                $this->values[$profile][$data['md_attribute_id']] = NULL;
                
                // Encolo ids
                $attribute_ids[] = $data['md_attribute_id'];
            }

            //cargo los valores para el objeto de id tal y clase tal de la tabla attribute_object
            $values = Doctrine::getTable('mdAttribute')->findAttributesValues($this->mdObject, $this->profiles[$profile]->id, $attribute_ids, sfContext::getInstance()->getUser()->getCulture());

            foreach($values as $k => $value)
            {
                $tmp = '';
                
                if(!is_null($value['md_attribute_value_id']))
                {
                    // Primero se chequea si no es un atributo multi-valuado
                    $tmp = Doctrine::getTable('mdAttribute')->findValue($this->mdObject, (int)$value['md_attribute_value_id'], sfContext::getInstance()->getUser()->getCulture());
                }
                else if(!$this->attributesHashMap[$value['md_attribute_id']]['translated'])
                {
                    // En segunda instancia se chequea si es un atributo no traducido
                    $tmp = $value['value_non_translated'];
                }
                else
                {
                    // Es un texto con i18n
                    if(array_key_exists("Translation", $value) && array_key_exists(sfContext::getInstance()->getUser()->getCulture(), $value["Translation"]))
                    {
                        $tmp = $value["Translation"][sfContext::getInstance()->getUser()->getCulture()]['value'];                        
                    }
                }
                
                $info                   = new stdClass();
                $info->id               = $value['id'];
                $info->md_attribute_id  = $value['md_attribute_id'];
                $info->value            = $tmp;
                $this->values[$profile][$info->md_attribute_id] = $info;       
            }

        }
        else
        {
            throw new Exception('Object has not profile ' . $profile, 101);
        }

        return $this;
    }

    /**
     * Devuelve true si el objeto con el cual se instancio el handler posee el perfil $profile
     * 
     * @param string $profile
     * @return boolean 
     */
    public function hasProfile($profile)
    {
        // Variable temporal para almacenar los nombres de los perfiles del objeto
        $names = array();
        
        // Si no se han cargado los perfiles aun
        if(count($this->profiles) <= 0)
        {
            // Obtenemos los perfiles del objeto
            $mdProfileObjectCollection = Doctrine::getTable('mdProfileObject')->findByMultiples(array('object_id', 'object_class_name'),array($this->mdObject->getId(), $this->mdObject->getObjectClass()));
            foreach($mdProfileObjectCollection as $mdProfileObject)
            {
                $name = $mdProfileObject->retrieveMdProfile()->getName();
                $info = new stdClass();
                $info->id = $mdProfileObject->getMdProfileId();
                $info->name = $name;
                $this->profiles[$name] = $info;            
            }
        }
        
        // Construimos el arreglo de nombres temporal
        foreach($this->profiles as $profileObject)
        {
            $names[$profileObject->name] = $profileObject->name;
        }

        // Retornamos
        return array_key_exists($profile, $names);        
    }
    
    // Metodos Estaticos
    
    /**
     * Devuelve el mdProfile de nombre $name
     * 
     * @param srting $name
     * @return mdProfile 
     */
    public static function retrieveMdProfileByName($name)
    {
        return Doctrine::getTable('mdProfile')->findOneBy('name', $name);
    }

    /**
     * Devuelve el perfil tiene el atributo pedido
     * 
     * @autor maui
     * @param string $key
     * @param string $profile
     * @return string 
     */
    public function hasAttribute($key, $profile = NULL)
    {
        try
        {
            if(is_null($profile))
            {
                if(is_null($this->profile_load))
                {
                    throw new Exception('you have to load a profile first', 101);
                }
                else
                {
                    $profile = $this->profile_load;
                }
            }
            
            if(isset($this->profiles[$profile]))
            {
                if(isset($this->attributes[$profile][$key]))
                {
                   return true;

                }
                else
                {
                  return false;
                }
            }
            else
            {
                throw new Exception('object has not profile ' . $profile . ' or profile not loaded', 102);
            }
        }
        catch(Excpetion $e)
        {
            throw $e;
        }
    }

}
