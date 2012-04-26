MdProducts = function(options){
	this._initialize();
}

MdProducts.instance = null;
MdProducts.getInstance = function (){
	if(MdProducts.instance == null)
		MdProducts.instance = new MdProducts();
	return MdProducts.instance;
}

MdProducts.prototype = {
    _initialize : function(){

    },

    cleanAndHideNewForm: function(){
        if($('#new_product_').html() != ""){
            
            //Effect.SlideUp('new_product_', { duration: 1.0, afterFinish: function(){ $('new_product_').innerHTML = "";} });
        }
        return false;
    },

    saveProfile: function(){
        AjaxLoader.getInstance().show();

        try {
            $('#product_new_form_ > textarea.with-tiny').each(function(index, item){
                if($(item).attr('id') != '' && $(item).is('.with-tiny')){
                    tinyMCE.execCommand("mceRemoveControl", true, $(item).attr('id'));
                    tinyMCE.execCommand("mceAddControl", true, $(item).attr('id'));
                }
            });

            tinyMCE.triggerSave();

            $('product_new_form_ > textarea.with-tiny').each(function(index, item){

                if($(item).attr('id') != '' && $(item).is('.with-tiny')){
                    tinyMCE.execCommand("mceRemoveControl", true, $(item).attr('id'));
                }
            });


        } catch (e) {
            //alert('error ' + e.name + ' ' + e.message);
        }



        $.ajax({
            url: $('#product_new_form_').attr('action'),
            data: $('#product_new_form_').serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.result == 0){
                    mastodontePlugin.UI.BackendBasic.getInstance().onNewBoxError(json.body);
                    if(typeof multiselectExistsAndIsUsable == 'function'){
                      multiselectExistsAndIsUsable();
                    }
                }else{
                    mastodontePlugin.UI.BackendBasic.getInstance().onNewBoxAdded('/backend.php/mdProduct/closedBox?id='+json.id);

                }
            },
            complete: function()
            {
              AjaxLoader.getInstance().hide();
            }
        });

        return false;
    },

    getProfiles: function(){
        var mdAppId = $('#new_app_').attr('value');

        $.ajax({
            url: 'mdProduct/listProfiles',
            data: {'mdAppId' : mdAppId},
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.result == 1){
                    $('#list_profiles_').html(json.body);
                }
            }
        });
    },

    showProfile: function(){
        $.ajax({
            url: $('#show_form_profile_').attr('action'),
            data: $('#show_form_profile_').serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.result == 1){
                    $('#profile_form_').html(json.body);
                }
            }
        });

        return false;
    },

    changeProductVisibility: function(mdProductId){
        var url = 'mdProduct/changeProductVisibilityAjax';

        $.ajax({
            url: url,
            data: {'mdProductId': mdProductId},
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK"){
                    $('#is_active_'+ mdProductId).html(json.result);
                }
            }
        });
        return false;
    },

    saveEdit: function(mdProductId){
        var form = $("#product_edit_form_"+mdProductId);
        AjaxLoader.getInstance().show();
        $.ajax({
            url: $(form).attr('action'),
            data: $(form).serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){
                //AjaxLoader.getInstance().hide();
                if(json.result == 1){
                  //mastodontePlugin.UI.BackendBasic.getInstance().close();
                  MdProducts.getInstance().prepareTinyEditorsForSave();
                  MdProducts.getInstance().saveExistingMdProfiles(0);
               } else {
                   mastodontePlugin.UI.BackendBasic.getInstance()
                       .getActivatedContent().html(json.body);
                   AjaxLoader.getInstance().hide();
               }
            },
            error: function()
            {
              AjaxLoader.getInstance().hide();
            }
        })
    },
    
    prepareTinyEditorsForSave: function()
    {
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
    },

    saveExistingMdProfiles: function(position)
    {
        var list = $('.profile_form');
        if(list.length > 0 && position < list.length)
        {
            var form = list[position];
            $.ajax({
                url: $(form).attr('action'),
                data: $(form).serialize(),
                dataType: 'json',
                type: 'post',
                success: function(data){
                    if(data.response == "ERROR")
                    {
                        AjaxLoader.getInstance().hide();
                        $("#md_dynamic_new_profile_" + data.options.profileId).replaceWith(data.options.body);
                        if(typeof multiselectExistsAndIsUsable == 'function'){
                          multiselectExistsAndIsUsable();
                        }
                    }
                    else
                    {
                        MdProducts.getInstance().saveExistingMdProfiles(position + 1);
                    }
                }
            });
        }
        else
        {
            AjaxLoader.getInstance().hide();
            mastodontePlugin.UI.BackendBasic.getInstance().close();
        }

    },
    
    submitFilter: function(pageNum){
        $.ajax({
            url: $('#md_objects_filter').attr('action'),
            data: $('#md_objects_filter').serialize(),
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK"){
                    $('#md_objects_container').replaceWith(json.products);

                    //$('#content_pager').update(json.contentPager);
                    
                }
            }
        });
    },

    deleteProduct: function(id){
        var url = $('#delete_product').attr('href');

        $.ajax({
            url: url,
            data: {'id': id},
            type: 'post',
            dataType: 'json',
            success: function(json){
                if(json.response == "OK"){
                    mastodontePlugin.UI.BackendBasic.getInstance().removeActiveBox();
                }
            }
        });

        return false;
    },

    deleteProductWithConfirmation: function(text, id)
    {
        if(confirm(text))
        {
             MdProducts.getInstance().deleteProduct(id);
        }
        return false;
    }


}

function addTag(){
    var url = 'mdProduct/addTagsForProductsAjax';
    var myAjax = new Ajax.Request(url, {
        method: 'post',
        parameters: 'tags=' + $('nuevo_tag').value,
        onSuccess: function (req){
            var response = req.responseText;
            var data = response.evalJSON();
            $('product_tags').innerHTML = data['tags'];
        }
    });
    return false;
}

function addNewProduct(passportId){
    lightboxObj.destroyIframeContent();
    var url = 'mdProduct/addNewProduct';
    var a = new Ajax.Request(url, {
        method: 'post',
        parameters: 'mdPassportId=' + passportId,
        onSuccess: function (response){
            var html = response.responseText;
            $('new_product_').innerHTML = html;
            Effect.Grow('new_product_', {duration: 1.0});
        }
    });
}

function saveProfile(){
    $('product_new_form_').request({
        onSuccess: function(response){
            var json = response.responseText.evalJSON();
            var results = new $H(json);
            if(results.get('result') == 1){
                $('new_product_').update(results.get('body'));
            }else{
                var childElements = $('new_product_').childElements();
                $('new_product_').setStyle({display: 'none'});
                childElements.each(function(item) {
                    item.remove();
                });
                $('objects').firstDescendant().insert({'after': results.get('body')});

                createMdObjectBoxForProduct(results.get('product_id'), MdObjectKeys.OPEN);

            }
            
            lightboxObj.setOpener($('opener-el'));
            lightboxObj.addContentToLightbox('<input id=\"content-lightbox-extra\" type=\"button\" onclick=\"updatePicturesSlider('+results.get('product_id')+');\" value=\"Listo\" />');
            lightboxObj.setUrl('default/uploader?a=' + results.get('product_id') + '&c=mdProduct');
            lightboxObj.createIframeContent();
        }
    });
    return false;
}

mastodontePlugin.UI.BackendBasic.getInstance().afterOpen = function(json){
    if(typeof initializeLightBox == 'function'){
        initializeLightBox(json.id, json.className);
    }
    if(typeof multiselectExistsAndIsUsable == 'function'){
        multiselectExistsAndIsUsable();
    }
}

mastodontePlugin.UI.BackendBasic.getInstance().afterAdd = function(json){
    if(typeof multiselectExistsAndIsUsable == 'function'){
        multiselectExistsAndIsUsable();
    }
}
