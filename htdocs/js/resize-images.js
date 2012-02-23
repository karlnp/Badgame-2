$(window).load(function() {
	// Go through every image in the posts
	$('.post img').each(function(index, element) {
		// What's the height? The width?
		var imgwidth = $(this).width();
		var imgheight = $(this).height();
		var maxwidth = $(this).closest('.post').width() - 20;
		// Which has the bigger difference between present and permitted
		var resizeWidth = false;
		var resizeHeight = false;
		if ((imgwidth - maxwidth) > (imgheight - 768) && (imgwidth > maxwidth)) {
			resizeWidth = true;
		} else if ((imgwidth - maxwidth) < (imgheight - 768) && (imgheight > 768)) {
			resizeHeight = true;
		}
		if (resizeWidth) {
			$(this).wrap('<div class="resized-image">');
			$(this).attr('natural-width', imgwidth);
			$(this).css('width', maxwidth);
			$(this).after('<span class="zoomtip">Image resized. Click to show full-size.</span>');
			$(this).toggle(function() {
				$(this).animate({width: $(this).attr('natural-width')}, 500);
				// Hide my siblings
				$(this).siblings('.zoomtip').fadeOut();
			}, function() {
				$(this).animate({width: maxwidth}, 500);
				$(this).siblings('.zoomtip').fadeIn();
			});
		} else if (resizeHeight) {
			$(this).wrap('<div class="resized-image">');
			$(this).attr('natural-height', imgheight);
			$(this).css('height', 768);
			$(this).after('<span class="zoomtip">Image resized. Click to show full-size.</span>');
			$(this).toggle(function() {
				$(this).animate({height: $(this).attr('natural-height')}, 500);
				// Hide my siblings
				$(this).siblings('.zoomtip').fadeOut();
			}, function() {
				$(this).animate({height: 768}, 500);
				$(this).siblings('.zoomtip').fadeIn();
			});
		}
	});
});