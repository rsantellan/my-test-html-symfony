function addOptions(multiSelectElement){
    $(multiSelectElement).next(".multiSelectOptions").append("<hr><input class=choice_input type=text />");
    $(multiSelectElement).next(".multiSelectOptions").children(".choice_input").keyup(function(e) {
        if(e.keyCode == 13) {
            var opt_label = $(this).val();
            //Mando a guardar el valor por ajax.
            var attributeName = $(this).parent(".multiSelectOptions").prev(".multiSelect").attr("id");
            var list = attributeName.split('_');
            if("mdAttributes" == list[2])
            {
                attributeName = list[5];
            }
            else
            {
                attributeName = list[2];
            }
            
            var object = this;
            AjaxLoader.getInstance().show();
            $.ajax({
                url: __MD_CONTROLLER_BACKEND_SYMFONY + "/mdAttributeManagement/addAttributeOption",
                data: {
                    'value': opt_label,
                    'label': attributeName
                },
                type: 'post',
                dataType: 'json',
                success: function(json){
                    if(json.response == "OK"){
                        addAnOptionToList(object, opt_label, json.options.id)

                    }else {

                    }
                },
                complete: function()
                {
                    AjaxLoader.getInstance().hide();
                }
            });
            $(this).val("");

        }
    });
}

function addAnOptionToList(element, opt_label, id)
{

    var old_opts = new Array();
    $(element).parent(".multiSelectOptions").find("label > input").each(function(index, item){
        if(!$(item).hasClass("selectAll")){
            var is_selected = ($(item).attr("checked"));
            old_opts.push({text: $(item).parent().text(), value: $(item).val(), selected: is_selected});

        }

    });

    var options = new Array({text: opt_label, value: id, selected:false});

    $.merge(options, old_opts);
    
    var multiSelectElement = $(element).parent(".multiSelectOptions").prev(".multiSelect");
    $(multiSelectElement).multiSelectOptionsUpdate(options);
    
    addOptions(multiSelectElement);
}

function multiselectExistsAndIsUsable()
{
    $(".multiSelect").multiSelect();
    $(".multiSelect").each(function(index, item){
        addOptions(item)
    });
    return true;
}
