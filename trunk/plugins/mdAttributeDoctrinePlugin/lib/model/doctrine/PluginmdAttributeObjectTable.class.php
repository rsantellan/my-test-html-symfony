<?php

abstract class PluginmdAttributeObjectTable extends Doctrine_Table {

    /**
     * Returns the attribute object to a given object and attribute
     * @param $objectId
     * @param $objectClass
     * @param $value
     * @param $attId
     * @return Doctrine_Collection
     * @author Rodrigo Santellan
     */
    public function getMdAttributeByObjectIdAndClass($objectId, $objectClass, $value, $attId) {
        $query = Doctrine_Query::create()
                        ->select('mdC.*')
                        ->from('mdAttributeObject mdC')
                        ->where('mdC.object_class = ?', $objectClass)
                        ->addWhere('mdC.object_id = ?', $objectId)
                        ->addWhere('mdC.md_attribute_value_id = ?', $value)
                        ->addWhere('mdC.md_attribute_id = ?', $attId);
        return $query->fetchOne();
    }

    public function getMdAttributeMdProfileByObjectIdAndClass($objectId, $objectClass, $mdProfileId, $attId, $fetch_one = true) {
        $query = Doctrine_Query::create()
                        ->select('mdC.*')
                        ->from('mdAttributeObject mdC')
                        ->where('mdC.object_class_name = ?', $objectClass)
                        ->addWhere('mdC.object_id = ?', $objectId)
                        ->addWhere('mdC.md_profile_id = ?', $mdProfileId)
                        ->addWhere('mdC.md_attribute_id = ?', $attId);
        if ($fetch_one) {
            return $query->fetchOne();
        }
        return $query->execute();
    }

    public function findByMultiples($keys = array(), $values = array(), $fetch_one = false) {
        $query = Doctrine_Query::create ()
                        ->select('mdAO.*')
                        ->from('mdAttributeObject mdAO');

        for ($i = 0; $i < count($keys); $i++) {
            $query->addWhere('mdAO.' . $keys[$i] . ' = ?', $values[$i]);
        }
        if ($fetch_one) {
            return $query->fetchOne();
        }
        return $query->execute();
    }

    public function filterByAttributeChoice($query,$object_class, $value, $mdAttributeId, $mdProfileId, $options = array())
    {
         //inicializo las opciones
        if(!isset($options['excluded'])) $options['excluded'] = array();

        //soluciono problema de hidratacion
        if($query->getType()==Doctrine_Query_Abstract::SELECT)
                $query->select($query->getRootAlias().'.*');

        $query->addFrom('mdAttributeObject mdC')
                ->addWhere($query->getRootAlias().'.id = mdC.object_id')
                ->addWhere('mdC.object_class_name = ?', $object_class)
                ->addWhere('mdC.md_profile_id = ?', $mdProfileId)
                ->addWhere('mdC.md_attribute_id = ?', $mdAttributeId)
                ->addWhere('mdC.md_attribute_value_id = ?', $value);
        return $query;
    }

    public function retrieveAllAttributesObjectsByProfileIdAttributeIdAndValue($mdProfileId, $mdAttributeId, $value = null, $page = 1, $limit = null) {
        $query = Doctrine_Query::create()
                        ->select('mdC.*')
                        ->from('mdAttributeObject mdC, mdProfileObject mdP')
                        ->where('mdC.md_profile_id = ?', $mdProfileId)
                        ->addWhere('mdC.object_id = mdP.object_id')
                        ->addWhere('mdC.object_class_name = mdP.object_class_name')
                        ->addWhere('mdC.md_attribute_id = ?', $mdAttributeId);
        if ($value != null) {
            $query
                    ->addFrom('mdAttributeObjectTranslation mdCT, mdAttribute mdA')
                    ->addWhere('mdC.id = mdCT.id')
                    ->addWhere('mdCT.value = ?', $value);
        }
        $query->orderBy('mdC.object_id DESC');
        if ($limit != null) {
            $query->limit($limit);
            if ($page != 1) {
                $query->offset($page);
            }
        }
        return $query->execute();
    }

    public function searchContents($word, $object_class = NULL, $lang = "es")
    {
        $query = $this->createQuery("mdC")
                    ->addSelect("mdC.object_id, mdC.object_class_name")
                    ->addFrom("mdAttributeObjectTranslation mdCT")
                    ->where("mdC.id = mdCT.id")
                    ->addWhere("mdCT.value LIKE ?", '%'.$word.'%')
                    ->addWhere("mdCT.lang = ?", $lang);
        if(!is_null($object_class))
        {
            $query->addWhere("mdC.object_class_name = ?", $object_class);
        }
        return $query->execute(array(), Doctrine_Core::HYDRATE_SCALAR);
    }
}
