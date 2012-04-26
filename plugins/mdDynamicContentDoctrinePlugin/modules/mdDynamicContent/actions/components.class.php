<?php

class mdDynamicContentComponents extends sfComponents
{

    public function executeMdDynamicContentRelation(sfWebRequest $request)
    {
        $this->_MD_Content_Concrete_Owner;
        $typeName = $this->_MD_Configuration['typeName'];
        $mdDynamicContent = new mdDynamicContent();
        $mdDynamicContent->addTmpArrayMdProfileId($this->_MD_Configuration['profileId']);
        $mdDynamicContent->setEmbedProfile(true);
        $this->form = new mdDynamicContentForm($mdDynamicContent);
    }

}
