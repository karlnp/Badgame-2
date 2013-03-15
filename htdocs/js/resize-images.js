$(window).load(function() {
	// Go through every image in the posts
	$('.post img').each(function(index, element) {
		// What's the height? The width?
		var imgwidth = $(this).width();
		var imgheight = $(this).height();

		var maxheight = 768;
		var maxwidth = $(this).closest('.post').width() - 20;

		// What do we need to shrink image by?
		var scaleFactor = 0;	

		if((imgwidth > maxwidth) || (imgheight > maxheight)) {
			// Scale by width factor if landscape
			if(imgwidth >= imgheight) {
				scaleFactor = maxwidth / imgwidth;
			// Scale by height factor if portrait
			} else {
				scaleFactor = maxheight / imgheight;
			}
		}

		if (scaleFactor) {
			$(this).wrap('<div class="resized-image">');
			$(this).attr('natural-width', imgwidth);
			$(this).attr('natural-height', imgheight);
			$(this).css('width', Math.round(imgwidth * scaleFactor));
			$(this).css('height', Math.round(imgheight * scaleFactor));
			$(this).after('<span class="zoomtip">Image resized. Click to show full-size.</span>');
			$(this).toggle(function() {
				$(this).animate(
					{width: $(this).attr('natural-width'), height: $(this).attr('natural-height')},
					 500
				);
				// Hide my siblings
				$(this).siblings('.zoomtip').fadeOut();
			}, function() {
				$(this).animate({width: maxwidth, height: maxheight}, 500);
				$(this).siblings('.zoomtip').fadeIn();
			});
		}
	});
});
