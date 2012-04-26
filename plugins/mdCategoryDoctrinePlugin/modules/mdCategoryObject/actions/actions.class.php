<?php
/**
 *
 *
 * @author     maui
 */
class mdCategoryObjectActions extends sfActions{

    public function executeEditBoxAjax(sfWebRequest $request) {

        $this->forward404Unless($object_id = $request->getParameter ( 'mdObjectId' ));
        $this->forward404Unless($object_class = $request->getParameter ( 'mdObjectClass' ));
        $parentCategories = array();
        $found = false;
        if( sfConfig::get( 'sf_plugins_categories_separate_by_type', false ) )
        {
          $categoryProfileDisplay = sfConfig::get( 'app_plugins_category_by_elements', null );
          if(!is_null($categoryProfileDisplay))
          {
            $object = Doctrine::getTable($object_class)->find($object_id);
            foreach($categoryProfileDisplay as $categoryProfile)
            {
              if($categoryProfile['object_class'] == $object_class)
              {
                if(isset($categoryProfile['object_type']))
                {
                  if($categoryProfile['object_type'] == $object->getTypeName())
                  {
                      array_push($parentCategories, mdCategoryHandler::retrieveCategory($categoryProfile['category_root_id']));
                      $found = true;
                  }                  
                }
                else
                {
                  array_push($parentCategories, mdCategoryHandler::retrieveCategory($categoryProfile['category_root_id']));
                  $found = true;
                }
                
                  
    
              }
            }
          }
        }
        else
        {
          $parentCategories = mdCategoryHandler::retrieveAllParentCategoriesOfClass($object_class);
        }

        

        return $this->renderPartial ('addObjectRelation',array('parentCategories'=>$parentCategories,'mdObjectId'=> $object_id, 'object_class' => $object_class));
    }

    public function executeGetCategorySons(sfWebRequest $request){
            $categories = mdCategoryHandler::retrieveAllMdCategorySons($request->getParameter ( 'mdCategoryId' ) );

            $index = 0;
            $salida = array();
            foreach ( $categories as $categorie ) {
                    $salida[$index]['id'] = $categorie->getId();
                    $salida[$index]['name'] = $categorie->getName();
                    $index++;
            }
            return $this->renderText(json_encode($salida));

    }

    public function executeAddCategoryToObject(sfWebRequest $request){

        $this->forward404Unless($md_category_id = $request->getParameter('mdCategoryId'));

        $this->forward404Unless($object_class = $request->getParameter('mdObjectClass'));
        $this->forward404Unless($object_id = $request->getParameter('mdObjectId'));

        mdCategoryHandler::addCategoryToObjectWithIds($object_id, $md_category_id);

        /*
        $mdCategoryObject = new mdCategoryObject();
        $mdCategoryObject->setMdCategoryId($md_category_id);
        $mdCategoryObject->setObjectId($object_id);
        $mdCategoryObject->save();

        */
        //return $this->renderText("{'ok'}");
        $this->forward($this->getModuleName(), 'renderCategoryObject');
        //return $this->renderComponent('mdCategoryObject', 'objectRelationBoxTreeNode', array('mdObject'=>$mdObject));

    }


    public function executeRemoveCategoryObject(sfWebRequest $request){
        $this->forward404Unless($object_class = $request->getParameter('mdObjectClass'));
        $this->forward404Unless($object_id = $request->getParameter('mdObjectId'));

        $this->forward404Unless($md_category_id = $request->getParameter('mdCategoryId'));

        $mdCategoryObject = Doctrine::getTable('mdCategoryObject')->find(array($object_id, $md_category_id));

        $mdCategoryObject->delete();

        $this->forward($this->getModuleName(), 'renderCategoryObject');
    }

    public function executeRenderCategoryObject(sfWebRequest $request){

        $this->forward404Unless($object_class = $request->getParameter('mdObjectClass'));
        $this->forward404Unless($object_id = $request->getParameter('mdObjectId'));

        $mdObject = Doctrine::getTable($object_class)->find($object_id);

        return $this->renderComponent($this->getModuleName(), 'objectRelationBoxTreeNode', array('mdObject'=>$mdObject));

    }

    public function executeShowNewCategoryForm(sfWebRequest $request){
        $mdCategory = new mdCategory();
        $mdCategory->setEmbedCategoryInfoForm(false);

        $mdCategory->setMdUserIdTmp(1);

        $form = new mdCategoryForm($mdCategory);
        
        $add_category = $this->getPartial('mdCategoryObject/new_category', array('form' => $form, 'objclass' => $request->getParameter('objclass')));

        return $this->renderText(json_encode(array('result' => '1', 'body' => $add_category)));
    }


    public function executeNewCategory(sfWebRequest $request){
        try {
            $mdCategory = new mdCategory();
            $mdCategory->setEmbedCategoryInfoForm(false);
            $mdCategory->setMdUserIdTmp($this->getUser()->getMdPassport()->getMdUser()->getId());
						$mdCategory->setLabel($mdRequestCategory[$this->getUser()->getCulture()]['name']);
            $mdRequestCategory = $request->getParameter('md_category');

            if($mdRequestCategory['md_category_parent_id'] == '0'){
                unset($mdRequestCategory['md_category_parent_id']);
            }

            $categoryForm = new mdCategoryForm($mdCategory);

            $categoryForm->bind($mdRequestCategory);
            
            if ($categoryForm->isValid()){
                $categoryForm->save();
            } else {
                return $this->renderText(json_encode(array('response' => 'ERROR', 'error' => $categoryForm->getFormattedErrors())));
            }
            
        } catch (Exception $e) {
            return $this->renderText(json_encode(array('response' => 'ERROR', 'error' => $e->getMessage())));
        }

        return $this->renderText(json_encode(array('response' => 'OK')));
    }


}
