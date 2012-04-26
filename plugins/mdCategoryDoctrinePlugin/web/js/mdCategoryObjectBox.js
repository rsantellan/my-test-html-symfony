var MdCategoryObjectBox = function(options){

	this._initialize(options);
	
};

MdCategoryObjectBox.prototype = {
	_initialize : function (options){
		 if(options != undefined && options['object_class'] != undefined ){
            this.object_class = options['object_class'];
        }else{
            this.object_class = '';
            alert('MdCategoryObjectBox.js Error: no object class');
        }
	},

    openEditCategoryObjectBox: function(id){

        this.showRemoveCategoryObjectButtons();

        var url = __MD_CONTROLLER_SYMFONY + '/mdCategoryObject/editBoxAjax';

        var place = '#bloque_agregar_cat_' + id;

        $.ajax({
            url: url,
            type: 'post',
            data: { 'mdObjectId': id, 'mdObjectClass': this.object_class },
            dataType: 'html',
            success: function(html){
                if($('#add_category_to_object_box').length == 0){
                    $(place).append(html);
                }
            }
        });
        return false;
        
    },

    closeEditCategoryObjectBox: function(){
        $('#add_category_to_object_box').remove();
        this.hideRemoveCategoryObjectButtons();
        return false;
    },

    enableApplyCategoryObjectButton: function(){
        $('#addCategoryButton').show();
    },

    disableApplyCategoryObjectButton: function(){
        //$('#addCategoryButton').hide();
    },

    getCategoryChildsSelect: function(selectId){
        var sel = document.getElementById(selectId);
        var objOption = sel.options[sel.selectedIndex];
        option_obj = $(sel.options[sel.selectedIndex]);

        objSelect = $(objOption).parents()[0]; //select padre del option recibido

        //borro los selects siguientes al elegido
        $(objSelect).next('select').each(function(index, item){
            item.options.length = 0;
            $(item).remove();
        });
        
        //disabled el boton agregar
        this.disableApplyCategoryObjectButton();

        $.ajax({
            url: __MD_CONTROLLER_SYMFONY + '/mdCategoryObject/getCategorySons',
            type: 'post',
            data: {'mdCategoryId': objOption.value},
            dataType: 'json',
            success: function(json){
                if(json.length>0){ //si la cat elegida tiene hijos
                    //genero un nuevo select
                    objNewSelect = document.createElement("select");
                    objNewSelect.id = 'cat_bloque_' + objOption.value;
                    objNewSelect.size = 10;
                    objNewSelect.onchange = new Function("mdCategoryObjectBox.getCategoryChildsSelect('cat_bloque_"+objOption.value+"');");
                    //le cargo las opciones recibidas
                    for(var i=0;i<json.length;i++){
                        var opt=document.createElement('option');
                        opt.text=json[i]['name'];
                        opt.value=json[i]['id'];
                        objNewSelect.options.add(opt);
                    }
                                        
                    //agrego el select a continuacion del clickeado
                    $(objSelect).parents()[0].appendChild(objNewSelect);
                //}else{

                  //si la cat cliqueda no tiene hijos habilito el boton aplicar
                    mdCategoryObjectBox.enableApplyCategoryObjectButton();
                }
            }
        });

    },



    addCategoryObject: function(object_id){

        var url = __MD_CONTROLLER_SYMFONY + '/mdCategoryObject/addCategoryToObject';


        //voy a buscar el ultimo select que contiene el div y me quedo con el option seleccionado
        selects = $('#md_category_form_content').children();
        var index = 1;
        var finish = false;
        category_id = $(selects[selects.length-index]).attr('value');
        if(category_id == "")
        {
          index++;
          while(!finish && index <= selects.length)
          {
            category_id = $(selects[selects.length-index]).attr('value');
            if(category_id != "")
            {
              finish = true;
            }
            index++;
          }
        }
        var self = this;

        mdShowLoading();
        $.ajax({
            url: url, 
            type: 'post',
            data: { 'mdObjectClass': this.object_class, 'mdObjectId': object_id, 'mdCategoryId': category_id},
            dataType: 'html',
            success: function(html){
                self.updateCategorieTreeFromResponse(html);
            },
            complete: function()
            {
              mdHideLoading();
            }
        });

        //disabled boton aplicar
        //this.disableApplyCategoryObjectButton();
        return false;
    },

    removeCategoryObject: function(object_id, category_id, remove_object){
        parent_li = $(remove_object).parents()[0];
        $(parent_li).hide();
        var url = __MD_CONTROLLER_SYMFONY + '/mdCategoryObject/removeCategoryObject';
        var self = this;
        mdShowLoading();
        $.ajax({
            url: url,
            type: 'post',
            data: { 'mdObjectId': object_id, 'mdObjectClass': this.object_class, 'mdCategoryId': category_id },
            dataType: 'html',
            success: function(html){
                self.updateCategorieTreeFromResponse(html);
            },
            complete: function()
            {
              mdHideLoading();
            }

        });
        
        return false;

    },

    updateCategoryTree: function(object_id){
        var self = this;
        var url = __MD_CONTROLLER_SYMFONY + '/mdCategoryObject/renderCategoryObject';

        $.ajax({
            url: url,
            data: { 'mdObjectClass': this.object_class, 'mdObjectId': object_id },
            dataType: 'html',
            success: function(html){
                self.updateCategorieTreeFromResponse(html);
            }
        });

        return false;

    },

    updateCategorieTreeFromResponse: function(html_content){
        $('#categories_tree').html(html_content);
        this.showRemoveCategoryObjectButtons();
    },

    showRemoveCategoryObjectButtons: function(){
        var buttons = $('div.md_category_remove');
        buttons.each(function(index, button){
            $(button).show();
        });
    },

    hideRemoveCategoryObjectButtons: function(){
        var buttons = $('div.md_category_remove');
        buttons.each(function(index, button){
            $(button).hide();
        });
    }
}
