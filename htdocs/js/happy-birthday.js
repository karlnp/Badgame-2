$(document).ready(function() {
	if (Modernizr.localstorage) {
		var hideBirthday = localStorage.getItem('birthday.hide');
		if (!hideBirthday) {
			$('body').append("<div style='height: 263px' class='birthday-beandog'><img src='http://dump.lunaphile.net/birthday-beandog.png' /></div>");
			$(".birthday-beandog").hide();
			$('.birthday-beandog').delay(3000).slideDown(4000);
			$('body').append("<div class='birthday-speech'><h1>Happy birthday Badgame!</h1><p>Badgame has been up and (mostly) running for one year now. Thank you for your continued support and high-quality posting!</p><div class='birthday-hide'>Hide this message</div></div>");
			$(".birthday-speech").hide();
			$(".birthday-speech").delay(8000).fadeIn();
			
			$('.birthday-hide').click(function() {
				$(".birthday-beandog").fadeOut(500, function() {$(this).remove()});
				$(".birthday-speech").fadeOut(500, function() {$(this).remove()});
				localStorage.setItem("birthday.hide", "true");
			})
		}
	}
});