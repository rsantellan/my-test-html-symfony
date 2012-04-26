<?php
class mdAuthComponents extends sfComponents{
	
	public function executeSmallSigninAjax(){
		$this->form = new mdPassportLoginForm ( );
	}
	
	
}