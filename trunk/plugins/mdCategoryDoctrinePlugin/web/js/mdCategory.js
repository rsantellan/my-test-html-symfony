var mdCategory = function(options){
	this._initialize();
}

mdCategory.instance = null;
mdCategory.getInstance = function (){
	if(mdCategory.instance == null)
		mdCategory.instance = new mdCategory();
	return mdCategory.instance;
}

mdCategory.prototype = {
	_initialize : function(){

    },

    changeNewHref: function(title)
    {
      var splitString = title.split("_");
      var content = splitString[2];
      var url  = $('#addBox').attr('href');
      var tmp = url.split('/');
      tmp[tmp.length-1] = content;
      url = tmp.join('/');     
      $('#addBox').attr('href', url);
    },
    showCategoryForm: function(url){
        mdShowLoading();
        $.ajax({
            url: url,
            data: {'categoryId': content},
            dataType: 'html',
            type: 'post',
            success: function(html){
                mdHideLoading();
                $('#new_category').replaceWith(html);
                $('#new_category').show();
            }
        });
        return false;
    },

    deleteCategoryWithConfirmation: function(text, id, element, parentId){
        if(confirm(text))
        {
          mdShowLoading();            
          var url = $('#md__delete_objectbox').attr('href');
          $.ajax({
            url: url,
            data: {'id': id},
            type: 'post',
            dataType: 'json',
            success: function(json){
              mdHideLoading();
              if(json.response == "OK"){
                mastodontePlugin.UI.BackendBasic.getInstance().removeActiveBox();
                if(json.parentId == 0)
                {
                  var removePlace = 'tab_container_'+ json.id;
                  $("#tabs").tabs( "remove" , removePlace );
                }
              }
            }
          });

          return false;
        }
        return false;
    },

    createCategory: function(url, newUrl){
        mdShowLoading();
        auxUrl = url;
        try {
            tinyMCE.execCommand("mceRemoveControl", true, $('textarea.with-tiny')[0].id);
            tinyMCE.execCommand("mceAddControl", true, $('textarea.with-tiny')[0].id);
            tinyMCE.triggerSave();
            tinyMCE.execCommand("mceRemoveControl", true, $('textarea.with-tiny')[0].id);
        } catch (e) {}
        
        $.ajax({
            url: $('#category_new_form_').attr('action'),
            data: $('#category_new_form_').serialize(),
            dataType: 'json',
            type: 'post',
            success: function(json){
                mdHideLoading();
                if(json.response == 'ERROR')
                {
                    mastodontePlugin.UI.BackendBasic.getInstance().onNewBoxError(json.body);
                } 
                else
                {
                    if(json.parent_id == 0)
                    {
                        auxUrl = auxUrl + "?mdCategoryId=" + json.object_id;
                        $('#tab_container_div').append("<div id='tab_container_"+json.object_id+"'></div>");
                        $('#tabs_container_ul').append('<li><a href="'+auxUrl+'" title="tab_container_'+json.object_id+'">'+json.name+'</a></li>');
                        mastodontePlugin.UI.BackendBasic.getInstance().close();
                        $("#tabs").tabs("destroy");
                        createTabs();
                        $("#tabs").tabs( "abort" );
                        $("#tabs").tabs( "select" , $("#tabs").tabs( "length" ) -1);
                    } 
                    else
                    {
                        mastodontePlugin.UI.BackendBasic.getInstance().close();
                        var url  = $('#addBox').attr('href');
                        last_char = url.charAt(url.length - 1);
                        if(last_char == json.parent_id)
                        {
                          $('#tabs').tabs( "load" , "tab_container_" + json.parent_id);
                        }
                        else
                        {
                          $('#tabs').tabs( "select" , "tab_container_" + json.parent_id);
                        }
                    }
                    
                }
            }
        });
        return false;
    },
    
    changePriority: function (url, objId, value)
    {
      $("#tabs").tabs( "abort" );
      mastodontePlugin.UI.BackendBasic.getInstance().disable();
      $.ajax({
        url: url,
        data: { 'mdCategoryId': objId, 'value': value },
        dataType: 'json',
        type: 'post',
        success: function(json){

        },
        complete: function(){
          $("#tabs").tabs( "abort" );
          mastodontePlugin.UI.BackendBasic.getInstance().enable();         
        }
      })
    },
    
    saveObject: function (id)
    {
      mdCategory.getInstance().saveMdProfileByAjax(id);
      return false;
    },
        
    saveMdCategoryObject: function (id)
    {
      mdShowLoading();  
      form = 'product_edit_form_' + id;
      $.ajax({
        url: $('#'+form).attr('action'),
        data: $('#'+form).serialize(),
        dataType: 'json',
        type: 'post',
        success: function(json){
          mdHideLoading();  
          if(json.response == 'OK')
          {

            mastodontePlugin.UI.BackendBasic.getInstance().close();
            var selected = $( "#tabs" ).tabs( "option", "selected" );
            $('#tabs').tabs( "load" ,selected);

          }
          else
          {
            $('#'+form).html(json.body);
          }
        }
      })      
    },
    
    saveMdProfileByAjax: function(id)
    {
      mdShowLoading();        
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
			if(list.length>0){
	      for(index = 0; index < list.length; index++)
	      {

	        var form = list[index];
	        $.ajax({
	          url: $(form).attr('action'),
	          data: $(form).serialize(),
	          dataType: 'json',
	          type: 'post',
	          success: function(json){
	              mdHideLoading();
	              if(json.response != "OK")
	              {
	                  $("#md_dynamic_new_profile_"+json.options.profileId).replaceWith(json.options.body);
	                  saveAll = false;
	              }
              
	              if(saveAll && index == list.length)
	              {
	                mdCategory.getInstance().saveMdCategoryObject(id);
	              }
	          }

	        });
	      }

			}else{
				mdCategory.getInstance().saveMdCategoryObject(id);
			}
      /*mastodontePlugin.UI.BackendBasic.getInstance().close();
      var selected = $( "#tabs" ).tabs( "option", "selected" );
      $('#tabs').tabs( "load" ,selected);     */ 
    }

}

mastodontePlugin.UI.BackendBasic.getInstance().afterOpen = function(json){
    if(typeof initializeLightBox == 'function'){
        initializeLightBox(json.id, json.className, MdAvatarAdmin.getInstance().getDefaultAlbumId());
    }
}
