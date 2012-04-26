var mdImageFileGallery = function(options){
	this._initialize();

}

mdImageFileGallery.instance = null;
mdImageFileGallery.getInstance = function (){
	if(mdImageFileGallery.instance == null)
		mdImageFileGallery.instance = new mdImageFileGallery();
	return mdImageFileGallery.instance;
}

mdImageFileGallery.prototype = {
    _initialize: function(){

    },

    mdImageFileGallery_iniRemove: function(){
        $('ul.md_thumbs li img').each(function(index, item){
            elRemove = $(item).next('div.remove');
            elDownload = $(item).prev('div.download');
            $(item).hover(function(eventObject){
                $(eventObject.currentTarget).next('div.remove').show();
                $(eventObject.currentTarget).prev('div.download').show();
            }, function(eventObject){
                $(eventObject.currentTarget).next('div.remove').hide();
                $(eventObject.currentTarget).prev('div.download').hide();
            });

            elDownload.hover(function(eventObject){
               $(eventObject.currentTarget).show();
                document.body.style.cursor = 'pointer';
            }, function(eventObject){
                $(eventObject.currentTarget).hide();
                document.body.style.cursor = 'auto';
            });

            elRemove.hover(function(eventObject){
               $(eventObject.currentTarget).show();
                document.body.style.cursor = 'pointer';
            }, function(eventObject){
                $(eventObject.currentTarget).hide();
                document.body.style.cursor = 'auto';
            });
        });
    },

    mdImageFileGallery_iniCategory: function(category){
        
    },

    mdImageFileGallery_RemoveImage: function(file, category, url, confirmText){
        var self = this;
        if(confirm(confirmText)){
            $.ajax({
                url: url,
                data: { "file": file },
                type: 'get',
                success: function(){
                    self.mdImageFileGallery_UpdateImageAlbum(category);
                }
            });
        }
    },

    mdImageFileGallery_UpdateImageAlbum: function(category){
        var self = this;
        $.ajax({
            url: '/backend.php/mdImageFileGallery/updateImageAlbum',
            data: { 'category': category },
            type: 'post',
            dataType: 'json',
            success: function(json){
                $('#el_category_'+category).html(json);

                $('a.open-modal').fancybox({ autoScale: false });
                self.mdImageFileGallery_iniRemove();
            }
        });

    }

}
