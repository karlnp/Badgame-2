Badgame = this.Badgame || {};

Badgame.SkeletonPrank = function() {
	if ($(".skeleton").size() == 0) {
		$('body').append("<img class='skeleton' src='http://i.imgur.com/XqEel.png' style='display: none' />");
	}
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
	$(".postrow[author-id='1170']").find(".post").append("<div class='smalltext'>(This post was definitely written by a retard.)</div>");
});
