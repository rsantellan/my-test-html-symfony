<?php use_helper('mdAsset');?>
<div class="md_add_block_shadow" id='add_category_to_object_box'>
	<div class="md_center_block_add_category">
		<div class="md_content_block_add_category">
			<div class="md_background_title md_category_title">
                <h3><?php echo __('mdCategoryDoctrine_text_selectCategoryToAssociate'); ?> <a href="javascript:void(0);" onclick="mdCategoryObjectBox.closeEditCategoryObjectBox();"><?php echo plugin_image_tag('mastodontePlugin', 'cerrar.png')  ?></a></h3>
			</div>
			<div class="md_content_block_category">
                            <div id="md_category_form_content">
                <select name="cat_bloque" size="5" id="cat_bloque" class="md_first_level md_block_category_st" onchange="mdCategoryObjectBox.getCategoryChildsSelect('cat_bloque');">
				<?php foreach($parentCategories as $category):?>
					<option value='<?php echo $category->getId()?>'><?php echo $category->getName()?> </option>
				<?php endforeach;?>
				</select>
                            </div>
                            <div class="clear"></div>
                            <div class="md_delete_category">
                                <a href="javascript:void(0);" id="addCategoryButton" onclick="return mdCategoryObjectBox.addCategoryObject(<?php echo $mdObjectId?>)" class="listo"><?php echo __('mdCategoryDoctrine_text_apply'); ?></a> | <a href="#" onclick='return mdCategoryObjectBox.closeEditCategoryObjectBox()'><?php echo __('mdCategoryDoctrine_text_close'); ?></a>
                            </div>
                        </div><!--CONTENIDO BLOQUE-->
		</div><!--CONTENIDO BLOQUE AGREGAR-->
	</div><!--CENTER BLOQUE AGREGAR-->
</div><!--SOMBRA BLOQUE AGREGAR-->
