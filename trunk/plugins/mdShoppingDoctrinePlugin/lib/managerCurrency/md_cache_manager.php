<?php
abstract class md_cache_manager {

    abstract public function getTable();

    abstract public function init();

    abstract public function getCollection();

    /**
     * Devuelve un objeto cuyas keys son $keys y sus valores son $values
     *
     * @param <array | string> $keys
     * @param <array | string> $values
     * @param <string> $hydrationMode
     * @return <Doctrine_Object>
     */
    public function find($keys, $values, $hydrationMode = null)
    {

        if(!is_array($keys)) { $keys = array($keys); }

        if(!is_array($values)) { $values = array($values); }

        $this->init($hydrationMode);

        $collection = $this->getCollection();

        if($hydrationMode == Doctrine_Core::HYDRATE_ARRAY){

            return $this->findByHYDRATE_ARRAY($collection, $keys, $values);

        }elseif ($hydrationMode == Doctrine_Core::HYDRATE_RECORD || is_null($hydrationMode)) {

            return $this->findByHYDRATE_RECORD($collection, $keys, $values);

        }else{

            throw new Exception('invalid hydrationMode to this function', 100);

        }

    }

    private function findByHYDRATE_ARRAY($collection, $keys = array(), $values = array())
    {

        $condition = false;
        foreach ($collection as $object){

            for ($i = 0; $i < count($keys); $i++)
            {

                if($object[$keys[$i]] == $values[$i])
                {
                    $condition = true;
                }else
                {
                    $condition = false;
                    break;
                }

            }

            if($condition){
                return $object;
            }

        }
        return array();

    }

    private function findByHYDRATE_RECORD($collection, $keys = array(), $values = array())
    {

        $condition = false;
        foreach ($collection as $object)
        {

            for ($i = 0; $i < count($keys); $i++)
            {

                if($object->__call('get' . $keys[$i], array()) == $values[$i])
                {

                    $condition = true;

                }else
                {

                    $condition = false;
                    break;

                }

            }

            if($condition)
            {
                return $object;
            }

        }
        return array();

    }

}
