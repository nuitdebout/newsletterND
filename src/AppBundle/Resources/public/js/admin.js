var admin = {};

$(function(){
  admin.replaceEditor();
  $('.form-document').hide();

  $( ".datepicker" ).datepicker({
    showOn: "button",
    buttonImage: "../bundles/app/images/calendar.png",
    buttonImageOnly: true
  });
  $('#ajoutDoc').click(function(){
    $('#ajoutDoc').hide();
    $('.form-document').show();
  });
  
  $('#formProposition').submit(function(){
      if($('#form_documents_0_file').val() == ""){
        $('.form-document').remove();
        }
  });
  
});

admin.afficheDesc = function(id) {
  $("#"+id).show();
  $("#"+id+"_r").show();
  $("#"+id+"_sp").hide();
}

admin.cacheDesc = function(id) {
  $("#"+id).hide();
  $("#"+id+"_sp").show();
  $("#"+id+"_r").hide();
}

admin.selectSite = function() {
  $('#formSelectSite').submit(function(){
    var data = $(this).serialize();
    $.post(this.action, data, function(result){
      location.reload();
    });
    return false;
  });
  $('#selectSite').change(function(){
    $('#formSelectSite').trigger('submit');
  });
}

admin.replaceEditor = function() {
  $('.editor').each(function(){
    CKEDITOR.replace(this);
  });
}
