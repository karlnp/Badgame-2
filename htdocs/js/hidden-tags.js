Badgame = this.Badgame || {};

Badgame.RefreshHiddenBlocks = function() {
	$('.hiddenheader').toggle(function() {
		var hiddenblock = $(this).next('.hiddenblock');
		if ($(this).hasClass('nwsheader')) {
			var html = hiddenblock.find('textarea').val();
			hiddenblock.find('textarea').replaceWith(html);
		}
		hiddenblock.slideDown();
	}, function() {
		$(this).next('.hiddenblock').slideUp();
	});
}

$(document).ready(Badgame.RefreshHiddenBlocks);
