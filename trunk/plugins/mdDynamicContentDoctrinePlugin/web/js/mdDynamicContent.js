mdDynamicContent = function(options){
	this._initialize();

}

mdDynamicContent.instance = null;
mdDynamicContent.getInstance = function (){
	if(mdDynamicContent.instance == null)
		mdDynamicContent.instance = new mdDynamicContent();
	return mdDynamicContent.instance;
}

mdDynamicContent.prototype = {
    _initialize: function(){

    },

    showProfile: function()
    {
        var form = '#show_new_form_profile';

        $.ajax({
            url: $(form).attr('action'),
            data: $(form).serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){
              if(json.result == 0){
                $('#profile_form_').html(json.body);
              }
            }
        });
      return false;

    },

    saveProfileAjax: function(profileId)
    {
      console.log("saveProfileAjax");
      /*
      var form = "md_dynamic_new_profile_" + profileId;
      var input = $(form).getInputs('submit');
      input[0].value = "Saving...";
      $(form).request({
          onComplete: function(t) {
              input[0].value = "Save";
          }
      });
      */
      return false;

    },

    addNewProfile: function(objectId, url)
    {
      console.log("addNewProfile");
        /*
        new Ajax.Request(url, {
            method: 'post',
            parameters: 'objectId=' + objectId,
            onSuccess: function (response){
                var json = response.responseText.evalJSON();
                $('new_profile_' + objectId).update(json);
                Effect.SlideDown('new_profile_' + objectId, {
                    duration: 1.0
                });
            }
        });*/
    },
    saveMdContent: function(url)
    {
      
      try {
        if(typeof mdShowLoading == "function")
        {
          mdShowLoading(); 
        }
        else 
        {
          parent.mdShowLoading();
        }
        //if(typeof mdShowLoading == "function") mdShowLoading(); else parent.mdShowLoading();
        var tinyList = $('.textarea-with-tiny');
        var index = 0;
        for(index=0;index<tinyList.length;index++){
          var aux = tinyList[index];
          try
          {
            tinyMCE.execCommand("mceRemoveControl", true, aux.id);
            tinyMCE.execCommand("mceAddControl", true, aux.id);
            tinyMCE.triggerSave();
            tinyMCE.execCommand("mceRemoveControl", true, aux.id);
          }
          catch (e)
          {
            //alert(e);
          }
        }

      } catch (e)
      {
          if(typeof mdHideLoading == "function")
          {
            console.log("cierro el loading");
            mdHideLoading(); 
          }
          else 
          {
            parent.mdHideLoading();
          }
      }

      var dispathMethod = (typeof arguments[1] == 'undefined');

      $.ajax({
        url: $('#md_content_new_form_').attr('action'),
        data: $('#md_content_new_form_').serialize(),
        dataType: 'json',
        type: 'post',
        success: function(json){
            if( dispathMethod ){
                mdDynamicContent.getInstance().onAccordionSuccess(json, url);
            }else{
                mdDynamicContent.getInstance().onRelationSuccess(json);
            }
        },
        complete: function()
        {
          if(typeof mdHideLoading == "function")
          {
            mdHideLoading(); 
          }
          else 
          {
            parent.mdHideLoading();
          }
        }
      });
      return false;
    },

    deleteMdObjectWithConfirmation: function(id, text)
    {
       if(confirm(text)){
         mdDynamicContent.getInstance().deleteMdContent(id);
         if(typeof arguments[2] !== 'undefined'){
            parent.$("#flex1").flexReload();
            parent.$('#dialog-modal').dialog('close');
         }
       }
       return false;
    },

    deleteMdContent: function(id)
    {
      var dataString = 'id=' + id;
      $.ajax({
        url: $('#delete_object').attr('href'),
        data: dataString,
        dataType: 'json',
        type: 'post',
        success: function(json){
            if(json.response == "OK")
            {
              mastodontePlugin.UI.BackendBasic.getInstance().removeActiveBox();
            }
            else
            {
              mastodontePlugin.UI.BackendBasic.getInstance().close();
            }
        }

      });
      return false;

    },

    saveMdProfileByAjax: function(id)
    {
        if(typeof mdShowLoading == "function") mdShowLoading(); else parent.mdShowLoading();
      var dispathMethod = (typeof arguments[1] == 'undefined' ? undefined : arguments[1]);
      try {
        var tinyList = $('.textarea-with-tiny');
        var index = 0;
        var aux = null;

        for(index=0; index < tinyList.length; index++){
          aux = tinyList[index];
          try {
            tinyMCE.execCommand("mceRemoveControl", true, aux.id);
            tinyMCE.execCommand("mceAddControl", true, aux.id);
          }
          catch (e){}
        }

        tinyMCE.triggerSave();
        for(index = 0; index < tinyList.length; index++){
          aux = tinyList[index];
          tinyMCE.execCommand("mceRemoveControl", true, aux.id);
        }
      } catch (e) { }

      var list = $(".profile_form");
      var saveAll = true;
      for(index = 0; index < list.length; index++)
      {

        var form = list[index];
        $.ajax({
          url: $(form).attr('action'),
          data: $(form).serialize(),
          dataType: 'json',
          type: 'post',
          success: function(json){
              if(json.response != "OK")
              {
                  $("#md_dynamic_new_profile_"+json.options.profileId).replaceWith(json.options.body);
                  saveAll = false;
              }

              if(saveAll && index == list.length)
              {
                mdDynamicContent.getInstance().saveMdDynamic(id, dispathMethod);
              }else if(!saveAll && index == list.length){
                if(typeof mdHideLoading == "function") mdHideLoading(); else parent.mdHideLoading();
              }
          }

        });
      }
    },

    saveMdDynamic: function (id)
    {
      var dispathMethod = (typeof arguments[1] == 'undefined');
      $.ajax({
          url: $("#md_object_edit_form_" + id).attr('action'),
          data: $("#md_object_edit_form_" + id).serialize(),
          dataType: 'json',
          type: 'post',
          success: function(json){
            if( dispathMethod ){
                mdDynamicContent.getInstance().onAccordionEditSuccess(json);
            }else{
                mdDynamicContent.getInstance().onRelationEditSuccess(json);
            }
          }

        });
    },

    changePriority: function (url, objId, value)
    {
      $.ajax({
        url: url,
        data: {'mdDynamicId': objId, 'value': value},
        dataType: 'json',
        type: 'post',
        success: function(json){
          //javascript:location.reload();
        }
      })
    },

    onAccordionSuccess: function(json, url)
    {
       mdHideLoading();
      if(json.result == '0'){
        mastodontePlugin.UI.BackendBasic.getInstance().onNewBoxError(json.body);
      }else{
        mastodontePlugin.UI.BackendBasic.getInstance().onNewBoxAdded(url + '?id='+json.id);
      }
    },

    onRelationSuccess: function(json)
    {
        $('#addMdDynamicRelation').replaceWith(json.body);
        mastodontePlugin.UI.BackendBasic.getInstance().afterOpen(json);
        if(json.response == "OK"){
            parent.$("#flex1").flexReload();
            if(typeof mdHideLoading == "function")
            {
              mdHideLoading(function(){parent.mdShowMessage("Se ha creado el contenido con exito. Puedes asociarle mas informacion o cerrar la ventana si asi lo deseas.", 4500)}); 
            }
            else 
            {
              parent.mdHideLoading(function(){parent.mdShowMessage("Se ha creado el contenido con exito. Puedes asociarle mas informacion o cerrar la ventana si asi lo deseas.", 4500)});
            }            
            //parent.mdHideLoading(function(){parent.mdShowMessage("Se ha creado el contenido con exito. Puedes asociarle mas informacion o cerrar la ventana si asi lo deseas.", 4500)});
        }else{
          if(typeof mdHideLoading == "function")
            {
              mdHideLoading(function(){parent.mdShowMessage("Se ha creado el contenido con exito. Puedes asociarle mas informacion o cerrar la ventana si asi lo deseas.", 4500)}); 
            }
            else 
            {
              parent.mdHideLoading(function(){parent.mdShowMessage("Se ha creado el contenido con exito. Puedes asociarle mas informacion o cerrar la ventana si asi lo deseas.", 4500)});
            } 
            //parent.mdHideLoading(function(){parent.mdShowMessage("Se ha creado el contenido con exito. Puedes asociarle mas informacion o cerrar la ventana si asi lo deseas.", 4500)});
        }
    },

    onAccordionEditSuccess: function(json)
    {
        mdHideLoading();
        if(json.response == "OK")
        {
            mastodontePlugin.UI.BackendBasic.getInstance().close();

        } else if(json.response == "ERROR"){
            mastodontePlugin.UI.BackendBasic.getInstance()
                       .getActivatedContent().html(json.options._MD_BODY);
        }
    },

    onRelationEditSuccess: function(json)
    {
        if(json.response == "OK"){
            parent.$("#flex1").flexReload();
            parent.$('#dialog-modal').dialog('close');
            parent.mdHideLoading(function(){parent.mdShowMessage("Se han realizado los cambios con exito")});
        }else{
            parent.mdHideLoading();
        }

    }

}

mastodontePlugin.UI.BackendBasic.getInstance().afterOpen = function(json){
    if(typeof initializeLightBox == 'function'){
        //Parche para resolver problemas de sincronizacion. Al abrir el primer box de un contenido
        //se ejecuta el afterOpen antes que los javascript del contenido y esto introducia bugs.
        //solo ocurria la primera ves.
        if(MdAvatarAdmin.getInstance().getDefaultAlbumId() == null)
        {
            setTimeout(function(){initializeLightBox(json.id, json.className, MdAvatarAdmin.getInstance().getDefaultAlbumId());}, 500);
        }
        else
        {
            initializeLightBox(json.id, json.className, MdAvatarAdmin.getInstance().getDefaultAlbumId());
        }
    }
}
