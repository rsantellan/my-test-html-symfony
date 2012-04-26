    <?php use_helper('mdAsset'); ?>

    <ul id="subsection_categories" class="subsection_tabs">
        <?php foreach($mdCategories as $mdCategory): ?>
					<?php include_partial('mdCategory/tabs_li', array('mdCategory' => $mdCategory));?>
        <?php endforeach; ?>
    </ul>

    <div class="clear"></div>

    <?php /** CONTENEDOR PARA EL FORMULARIO DE AGREGAR NUEVO PRODUCTO **/ ?>
    <div id="new_category" class="productos_editar" style="display: none;"></div>
    <?php /************************************************************/ ?>


    <?php $i = 1; ?>
    <div id="tab_containers">
    <?php foreach($mdCategories as $mdCategory): ?>
			<?php include_partial('mdCategory/tabs_container', array('mdCategory'=>$mdCategory, 'childs'=>$childs, 'i'=> $i)); ?>
			<?php $i++;?>
    <?php endforeach; ?>
		</div>
		
<script type="text/javascript">
 var categoryTabs = new Control.Tabs('subsection_categories',{
    beforeChange: function(old_container, new_container)
    {
        if(old_container.id !== undefined) //si es la primera vez que se carga no hago nada
        {

            var splitOld = old_container.id.split('_');
            var splitNew = new_container.id.split('_');
            var old_id = splitOld[1];
            var new_id = splitNew[1];
            
            $('new_category').innerHTML = '';
            $('new_category').hide();
						if($('objects_'+new_id) === null || $('objects_'+new_id) === undefined)
            {
								$('loading_list_close_'+new_id).show();
                new Ajax.Request('mdCategory/loadTabContent',
                {
                    method: 'post',
                    parameters: 'mdCategoryId=' + new_id,
                    onSuccess: function (response)
                    {
                        var json = response.responseText.evalJSON();
                        var results = new $H(json);
                        var html = results.get('content');
                        $('loading_list_close_'+new_id).hide();
                        $('cat_'+new_id).insert(html);
                        if(!Prototype.Browser.Gecko) html.evalScripts(); //Ejecuto los javascript
                    }
                });
            }
        }
    }
 });
</script>
