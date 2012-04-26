var __MD__POST_LOGIN = ''; //Contiene la pagina hacia donde se redirigira luego del login

function submitSigninAjax(){
    if($('#login-btn') && $('#login-loader')){
    	$('#login-btn').hide();
    	$('#login-loader').show();
    }

    if($('#upload_container') && $('#upload_container_overlay')){
        mdShowLoading();
    }

    $.ajax({
        url: $('#form_login_ajax').attr('action'),
        data: $('#form_login_ajax').serialize(),
        type: 'POST',
        dataType: 'json',
        success: function(json) {
            if(json.result == 0){
                if(__MD__POST_LOGIN != ''){
                    document.location = __MD__POST_LOGIN;
                }else{
                    document.location.reload();
                }
            }else{
                $('#form_login_ajax_div').html(json.body);
                if(typeof(afterAjaxLoginFailure) == 'function'){
                    afterAjaxLoginFailure();
                }
            }
        },
        complete: function(){
            if($('#upload_container') && $('#upload_container_overlay')){
                mdHideLoading();
            }
        }
    });
    return false;
}
/*
function submitSigninAjax(){
    var form = "#form_login_ajax";

    $("#button_sign_in").hide();
    $("#loader_sign_in").show();
    $.ajax({
        url: $(form).attr('action'),
        data: $(form).serialize(),
        type: 'POST',
        dataType: 'json',
        success: function(json) {
            if(json.result == '0'){
                document.location.reload();
            }
            else{
                $(form).parent().html(json.body);
            }
        }
    });
}
*/
function setPostLogin(page)
{
    __MD__POST_LOGIN = page;
}


function forgotPasswordForm(form)
{
  $.fancybox.showActivity();
  $.ajax({
      url: $(form).attr('action'),
      data: $(form).serialize(),
      type: 'POST',
      dataType: 'json',
      success: function(json) {
          if(json.response == "OK")
          {
            $.fancybox.close();
            mdShowMessage(json.options.body);
          }
          else
          {
            $("#forgot_password_container").html(json.options.body);
            $.fancybox.resize();
          }
      },
      complete: function(){
          $.fancybox.hideActivity();
          
      }
  });
  
  return false;
}
