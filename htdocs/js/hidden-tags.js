$(document).ready(function() {
	$('.hiddenheader').toggle(function() {
		if ($(this).hasClass('nwsheader')) {
			var hiddenblock = $(this).next('.hiddenblock');
			var html = hiddenblock.find('textarea').val();
			hiddenblock.find('textarea').replaceWith(html);
		}
		hiddenblock.slideDown();
	}, function() {
		$(this).next('.hiddenblock').slideUp();
	});
});
