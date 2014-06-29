
(function($) {
	$('#navigator li').removeClass('active');
	$('#navigator li.sidebar').addClass('open');
	var path = window.location.pathname;
	$('a[href="' + path + '"]').parent().addClass('active');

	$('iframe').css({
		'padding':'0',
		'height':(parseFloat(window.innerHeight.toString())-160)+'px'
	});
})(jQuery);