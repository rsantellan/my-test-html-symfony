<?php

class mdCategoryObjectComponents extends sfComponents
{

    /*
     * @param mdObject = object that implements mdCategoryBehavior
     */
    public function executeObjectRelationBox(sfWebRequest $request){
        //TODO: evaluar si los parametros estan vacios y largar excepcion
        $this->tree = Doctrine::getTable('mdCategory')->getTreeByObject($this->mdObject->getObjectClass(), $this->mdObject->getId());
    }
    public function executeObjectRelationBoxTreeNode(sfWebRequest $request){
        //TODO: evaluar si los parametros estan vacios y largar excepcion
        $this->tree = Doctrine::getTable('mdCategory')->getTreeByObject($this->mdObject->getObjectClass(), $this->mdObject->getId());
    }
}