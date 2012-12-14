<?php

/**
 * testing actions.
 *
 * @package    naturalia
 * @subpackage testing
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class testingActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    
    generateCategoriesProfileAttributes::run();
    die('runned');
  }
}
