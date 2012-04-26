<?php
/**
 */
class PluginmdProfileAttributeTable extends Doctrine_Table
{

    public function findByMultiples($keys = array(), $values = array()){
        $query = Doctrine_Query::create ()
                    ->select ('mdPO.*')
                    ->from ('mdProfileObject mdPO');

        for ($i = 0; $i < count($keys); $i++){
            $query->addWhere('mdPO.' . $keys[$i] . ' = ?', $values[$i]);
        }

        return $query->execute();

    }

}