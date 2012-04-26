function submitSingleAttributeForm(widget)
{
    if(typeof calledOnStartSaveSingleWidgetForm == 'function') {
        calledOnStartSaveSingleWidgetForm();
    }  
    var form = $(widget).parents('.one_widget_form');
    $.ajax({
        url: $(form).attr('action'),
        data: $(form).serialize(),
        type: 'post',
        dataType: 'json',
        success: function(json){
            if(json.response == "OK"){
                if(typeof calledOnSaveSingleWidgetForm == 'function') {
                    calledOnSaveSingleWidgetForm();
                }
            }else {

            }
        },
        complete: function(json)
        {
          if(typeof calledOnCompleteSaveSingleWidgetForm == 'function') {
              calledOnCompleteSaveSingleWidgetForm();
          }
        }
    });
}
