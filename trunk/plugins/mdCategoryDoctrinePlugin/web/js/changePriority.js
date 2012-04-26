function changePriority(url, objId, value)
{
  $.ajax({
      url: url,
      data: { 'mdCategoryId': objId, 'value': value },
      dataType: 'json',
      type: 'post',
      success: function(json){
          
      }
  })
}
