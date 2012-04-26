function addMdObject(url){
    new Ajax.Request(url, {
        method: 'post',
        parameters: '',
        onSuccess: function (response){
            var json = response.responseText.evalJSON();
            $('new_md_object_').update(json.newForm);
            Effect.SlideDown('new_md_object_', {
                duration: 1.0
            });

            if(Prototype.Browser.WebKit || Prototype.Browser.IE){
                json.newForm.evalScripts();
            }
        }
    });
}

function saveMdContent()
{
    try {
        var tinyList = $$('.textarea-with-tiny');
        var index = 0;
        for(index=0;index<tinyList.length;index++){
            var aux = tinyList[index];
            try{
                tinyMCE.execCommand("mceRemoveControl", true, aux.id);
                tinyMCE.execCommand("mceAddControl", true, aux.id);
                tinyMCE.triggerSave();
                tinyMCE.execCommand("mceRemoveControl", true, aux.id);
            }
            catch (e){
                alert(e);
            }
        }

    } catch (e) {
        
    }

    $('md_content_new_form_').request({
        onSuccess: function(response){
            var json = response.responseText.evalJSON();
            var results = new $H(json);
            if(results.get('result') == 1){
                $('md_content_new_form_').update(results.get('body'));
            }else{
                var childElements = $('new_md_object_').childElements();
                $('new_md_object_').setStyle({
                    display: 'none'
                });
                childElements.each(function(item) {
                    item.remove();
                });
                $('objects').firstDescendant().insert({
                    'after': results.get('body')
                });

                if(Prototype.Browser.WebKit || Prototype.Browser.IE){
                    results.get('body').evalScripts();
                }

                createMdObjectBox(results.get('id'), MdObjectKeys.OPEN);
                try
                {
                    var opener = $('opener-el');
                    initializeLightBox(results.get('id'), results.get('className'), opener, getDefaultAlbumId());
                }
                catch (e)
                {
                    alert(e);
                }
            }
        }
    });
    return false;

}	

function saveMdProfileByAjax()
{
  try {
    var tinyList = $$('.textarea-with-tiny');
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

  var list = $$(".profile_form");
  for(index = 0; index < list.length; index++)
  {
    var id = list[index].readAttribute('id');
    $(id).request({
      onSuccess: function(response){
        
      }
    });    
  }
}

function hideAddMdContent(){
    $('md_content_new_form_').remove();
    $('new_md_object_').hide();
}


function deleteMdObjectWithConfirmation(id, text){
   if(confirm(text)){
     deleteMdContent(id);
   }
   return false;
}

function deleteMdContent(id){
    var url = $('delete_object').readAttribute('href');
    new Ajax.Request(url,{
        method: 'post',
        parameters: 'id=' + id,
        onSuccess: function(response){
            var json=response.responseText.evalJSON();
            var results = new $H(json);
            if(results.get('response') == "OK"){
                $('md_object_'+id).remove();
                mdObjectList.removeObjectBox(id);
            }
        }
    });
    return false;
}
