Badgame = this.Badgame || {};
Badgame.HideThreads = this.Badgame.HideThreads || {};

Badgame.HideThreads.HideThreadsOnListing = function() {
	$(".threadrow").each(function() {
		var tid = $(this).attr("thread-id");
		if ($('#show-hidden-threads').prop("checked")) {
			$(this).css("display", "table-row");
			$(this).removeClass("hidden-thread");
			if (localStorage.getItem("hide." + tid)) {
				$(this).addClass("hidden-thread");
			}
		} else {
			if (localStorage.getItem("hide." + tid)) {
				$(this).css("display", "none");
			} else {
				$(this).css("display", "table-row");
				$(this).removeClass("hidden-thread");
			}
		}
	});	
}

$(document).ready(function() {
	if (Modernizr.localstorage) {
		$(".threadrow #hidebutton").click(function() {
			var threadrow = $(this).parents(".threadrow");
			var tid = threadrow.attr("thread-id");
			if (localStorage.getItem("hide." + tid)) {
				if (confirm("Unhide this thread?")) {
					localStorage.removeItem("hide." + tid);
					Badgame.HideThreads.HideThreadsOnListing();
				}
			} else {
				if (confirm("Really hide this thread?")) {
					localStorage.setItem("hide." + tid, "true");
					Badgame.HideThreads.HideThreadsOnListing();
				}
			}
		});
		Badgame.HideThreads.HideThreadsOnListing();
		
		$("#show-hidden-threads").click(Badgame.HideThreads.HideThreadsOnListing);
	}
});
