/*
    START
    Load JS plugins and various functions
*/

// Initialize
var trescal = {};

// Starting functions
$(document).ready(function(){
	trescal.slider('.js-slider');
	trescal.smallslider('.js-news-slider', false);
	trescal.smallslider('.js-focus-slider', true);
	trescal.popover('.js-popover');
	trescal.popoverHover('.js-popover-hover');
	trescal.popover('.nav-main > li > a');
	trescal.readmore('.news-content', 90);
	trescal.showlang('.dwld-lang-select');
	trescal.faq('.faq-question');
	trescal.stickyHead('.js-sticky-head');
	trescal.stickySide('.js-sticky-side');
	trescal.readmore('.job-content', 0);
	trescal.viewLab('.link-lab');
	if (typeof trescal.maparea == 'function') trescal.maparea('.js-map-area');
	$('.external').click(function(){
		window.open(this.href);
		return false;
	});
});

// AJAX for location
trescal.viewLab = function(selector) {
	if (!$(selector).length) return;
	$(selector).click(function(){
		$.post(this.href, null, function(result){
			if (result.success) {
				$('.mapSide-window').html(result.render);
				$('.side-title').html(result.city);
			}
		}, 'json');
		return false;
	});
}

// Main slider
trescal.slider = function(selector){
	if(!$(selector).length) return;
	$(selector).flexslider({
		animation: 'fade',
		controlNav: true
	});
}

// Small slider
trescal.smallslider = function(selector,random){
	if(!$(selector).length) return;
	$(selector).flexslider({
		animation: 'slide',
		controlNav: false,
		directionNav: false,
		randomize: random
	});
}

// Tooltip menu
trescal.popover = function(selector){
	if(!$(selector).length) return;
	$(selector).popover({
		html: true,
		title: false,
		placement: 'bottom',
		content: function(){
			return $(this).next('.popover-inside').html();
		}
	}).click(function() {
		$(this).toggleClass('is-open');
	});
	$(':not(body)').on('click', function (e) {
		$(selector).each(function () {
			if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
				$(this).popover('hide');
				$(this).removeClass('is-open');
				return;
			}
		});
	});
}

// Tooltip menu (hover effect)
trescal.popoverHover = function(selector){
	if(!$(selector).length) return;
	$(selector).popover({
		html: true,
		title: false,
		trigger: 'hover',
		placement: 'bottom',
		delay: { show: 100, hide: 100 },
		content: function(){
			return $(this).next('.popover-inside').html();
		}
	});
}

// Truncate text and add read more link
trescal.readmore = function(selector,height){
	if(!$(selector).length) return;
	$(selector).readmore({
		maxHeight: height,
		heightMargin: 0,
		speed: 300,
		embedCSS: false,
		moreLink: '<a href="#" class="lnk-read">Lire la suite</a>',
		lessLink: '<a href="#" class="lnk-read lnk-close">Fermer</a>'
	});
}

// Show list of available translations
trescal.showlang = function(selector){
	if(!$(selector).length) return;
	$(selector).on( 'click', function(){
		$(this).next('.dwld-lang-list').fadeToggle('fast');
	});
}

// FAQ
trescal.faq = function(selector){
	if(!$(selector).length) return;
	$('.faq-answer').hide();
	$(selector).click( function(){
		var that = $(this);
		var container = that.parent();
		var isOpen = container.hasClass('is-open');
		var answer = that.next('.faq-answer');
		var anchor = that.attr('id');
		answer.slideToggle(400).parent().toggleClass('is-open');
		container.siblings().removeClass('is-open').find('.faq-answer').slideUp(400);
		return false;
	});
}

// Stick header
trescal.stickyHead = function(selector){
	if(!$(selector).length) return;
	$(selector).sticky({
		'offset' : 0,
		'zindex' : 1000 
	});
}

// Stick sidebar
trescal.stickySide = function(selector){
	if(!$(selector).length) return;
	$(selector).sticky({
		'offset' : 157,
		'stopper' : '.footer'
	});
}

// Keep bootstrap popover open when hovering (cf. http://jsfiddle.net/WojtekKruszewski/Zf3m7/22/)
var originalLeave = $.fn.popover.Constructor.prototype.leave;
$.fn.popover.Constructor.prototype.leave = function(obj){
  var self = obj instanceof this.constructor ?
    obj : $(obj.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type)
  var container, timeout;
  originalLeave.call(this, obj);
  if(obj.currentTarget) {
    container = $(obj.currentTarget).siblings('.popover')
    timeout = self.timeout;
    container.one('mouseenter', function(){
      clearTimeout(timeout);
      container.one('mouseleave', function(){
        $.fn.popover.Constructor.prototype.leave.call(self, self);
      });
    })
  }
};