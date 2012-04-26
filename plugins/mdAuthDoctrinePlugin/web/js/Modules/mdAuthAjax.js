var __MD__POST_LOGIN = ''; //Contiene la pagina hacia donde se redirigira luego del login

function submitSigninAjax(){
	if($('login-btn') && $('login-loader')){
    	$('login-btn').hide();
    	$('login-loader').show();
		}
		$('form_login_ajax').request({
			onSuccess: function(response) {
				var json = response.responseText.evalJSON();
				var results = new $H(json);
				if(results.get('result') == 0){
                    if(__MD__POST_LOGIN != ''){
                        document.location = __MD__POST_LOGIN;
                    }else{
                        document.location.reload();
                    }
				}else{
					$('form_login_ajax_div').update(results.get('body'));
				}
			}
		});
	return false;
}

function setPostLogin(page)
{
    __MD__POST_LOGIN = page;
}