$(document).ready(function() {
	if (Modernizr.localstorage) {
		var hideBirthday = localStorage.getItem('birthday.2013.hide');
		if (!hideBirthday) {
			$('body').append("<div style='height: 263px' class='birthday-beandog'><img src='/img/birthday-beandog.png' /></div>");
			$(".birthday-beandog").hide();
			$('.birthday-beandog').delay(3000).slideDown(4000);
			$('body').append("<div class='birthday-speech'><p><b>Did you know?</b> After 2 years in human relationships, the presence of hormones which cause sexual attraction between partners is practically non-existant.</p><p>Also, May 8th 2013 marks Badgame's second birthday. It's rare for offsites to last this long. Thanks for everything!</p><div class='birthday-hide'>Hide this message</div></div>");
			$(".birthday-speech").hide();
			$(".birthday-speech").delay(8000).fadeIn();
			
			$('.birthday-hide').click(function() {
				$(".birthday-beandog").fadeOut(500, function() {$(this).remove()});
				$(".birthday-speech").fadeOut(500, function() {$(this).remove()});
				localStorage.setItem("birthday.2013.hide", "true");
			})
		}
	}
});