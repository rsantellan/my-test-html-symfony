function retrieveProfilesList(objectId, objectClass, url)
{
	var addProfileAjax = new Ajax.Request(url, {
			method: 'post',
			parameters: 'objectId=' + objectId + '&objectClass='+ objectClass, 
			onSuccess: function (response){
					var json=response.responseText.evalJSON();
          var results = new $H(json);
          if(results.get('result') == 0)
          {
            $('new_profile_' + objectId).update(results.get('body'));
            Effect.SlideDown('new_profile_' + objectId, {
							duration: 1.0
            });
          }
					
			}
	});  
}

function showObjectProfile(objectId)
{
  $('show_form_profile_' + objectId).request({
      onSuccess: function(response){
          var json = response.responseText.evalJSON();
          var results = new $H(json);
          if(results.get('result') == 0){
              $('profile_form_' + objectId).update(results.get('body'));
          }
      }
  });
  return false;  
}

function saveObjectProfile(objectId)
{
  try {
    var tinyList = $$('.textarea-with-tiny');
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
      }

    }

  } catch (e) { }
  
  $('profile_new_form_' + objectId).request({
    onSuccess: function(response){
      var json = response.responseText.evalJSON();
      var results = new $H(json);
      if(results.get('result') == 1)
      {
        $('md_object_' + objectId).select('[class=start_profiles]').first().insert({
        bottom: results.get('body')
        });
        $('profile_new_form_' + objectId).remove();
      }
      else
      {
        $('show_form_profile_' + objectId).update(results.get('body'));
      }
      clickElement("button_to_save");
    }
  });
  return false;  
}

function clickElement(elementid){
    var e = document.getElementById(elementid);
    if (typeof e == 'object') {
        /*if(typeof e.click != 'undefined') {
            e.click();
            alert('click');
            return false;
        }
        else */
        if(document.createEvent) {
            var evObj = document.createEvent('MouseEvents');
            evObj.initEvent('click',true,true);
            e.dispatchEvent(evObj);
            alert('createEvent');
            return false;
        }
        else if(document.createEventObject) {
            e.fireEvent('onclick');
            alert('createEventObject');
            return false;
        }
        else {
            e.click();
            alert('click');
            return false;
        }
    }
}
