$(function(){
  $('.skills-result').hide();
  $('.skills-welcome').show();
  actionAll('#list-skills, #list-skills-squared', 'select');

  $('#list-countries a').click(function(){
    $('.skills-welcome').hide();
    $(this).parents('li').toggleClass('is-selected');
    $('[data-result-country='+$(this).parents('li').attr('data-country')+']').toggle().toggleClass('skills-visible');
    return false;
  });

  $('#list-skills-squared a, #list-skills a').click(function(){
    var skill = $(this).parents('li').attr('data-skill');

    $('.skills-welcome').hide();
    $(this).parents('li').toggleClass('is-selected');
    $('[data-result-skill='+skill+']').toggleClass('is-selected');
    if ($('#list-countries li.is-selected').length == 0 && $('[data-result-skill='+skill+']').hasClass('is-selected')) {
      $('[data-result-skill='+skill+']').parents('.skills-result').each(function(){
        var country = $(this).attr('data-result-country');
        $('#list-countries li[data-country='+country+'] a').trigger('click');
      });
    }
    return false;
  });
});

function actionAll(element, action) {
  var type = (element == '#list-countries') ? 'country' : 'skill';
  $('.skills-welcome').hide();

  if (type == 'country') {
    if (action == 'select') {
      $('li', element).addClass('is-selected');
      $('.skills-result').show().addClass('skills-visible');
    }
    else {
      $('li', element).removeClass('is-selected');
      $('.skills-result').hide().removeClass('skills-visible');
    }
  }
  else {
    if (action == 'select') {
      $('li', element).addClass('is-selected');
      $('.skills-result-domain-ico').addClass('is-selected');
    }
    else {
      $('li', element).removeClass('is-selected');
      $('.skills-result-domain-ico').removeClass('is-selected');
    }
  }

  return false;
}