Badgame = this.Badgame || {};

Badgame.SkeletonPrank = function() {
	$(".skeleton").css("position", "fixed")
		.css("display", "block")
		.css("top", "-30px")
		.css("left", "3000px");
	$(".skeleton").animate({left: "-1000px"}, 5600, function() {
		$(this).remove();
		localStorage.setItem('skeleton.pranked', 'true');
	});
}

$(document).ready(function() {
	$(".postrow[author-id='92']").find(".post").append("<div class='smalltext'>(This post may have been written by a retard.)</div>");
	if (Modernizr.localstorage && !localStorage.getItem('skeleton.pranked')) {
		// make sure it's loaded
		$('body').append("<img class='skeleton' src='http://i.imgur.com/XqEel.png' style='display: none' />");
		if (Math.random()*1000 < 5) {
			Badgame.SkeletonPrank();
		}
	}
});
