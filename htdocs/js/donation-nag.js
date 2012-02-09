Badgame = this.Badgame || {};
Badgame.DonationNag = this.Badgame.DonationNag || {};

Badgame.DonationNag.RemindNextMonth = function() {
	var now = new Date();
	if (now.getMonth() == 11) {
		nextReminder = new Date(now.getFullYear() + 1, 0, 1);
	} else {
		nextReminder = new Date(now.getFullYear(), now.getMonth() + 1, 1);
	}
	var reminderTime = nextReminder.getTime();
	localStorage.setItem('nag.reminder', reminderTime);
}

Badgame.DonationNag.Remind = function(days) {
	var now = new Date();
	var nowTime = now.getTime();
	var thenTime = nowTime + (8640000 * days);
	localStorage.setItem('nag.reminder', thenTime);
}

Badgame.DonationNag.Donate = function() {
	// set reminder time to 1st of next month
	Badgame.DonationNag.RemindNextMonth();
	$("#nagbox").html("<h2>Thank you! You are now going to Paypal...</h2><div class='smalltext'>I'll ask again next month.</div>");
	// go to paypal page
	window.location.href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=X9PGEY6PZR73U";
}

Badgame.DonationNag.ShortRemind = function() {
	Badgame.DonationNag.Remind(3);
	$("#nagbox").hide();
}

Badgame.DonationNag.LongRemind = function() {
	Badgame.DonationNag.RemindNextMonth();
	$("#nagbox").hide();
}

Badgame.DonationNag.NeverRemind = function() {
	if (confirm("You will never ever be asked to donate again. Is this OK?")) {
		localStorage.setItem('nag.neverRemind', 'true');
		$("#nagbox").hide();
	}
}

Badgame.DonationNag.ShowNag = function() {
	var naggerHtml = "<div id='nagbox'><h1>Did you know?</h1>" +
			"<p>Badgame isn't free. It costs roughly $80 a month to host this " +
			"forum, and developing/maintaining the software can take a lot of time.</p>" +
			"<p>Donations help keep the server running and fund future development " +
			"of the forum software. Anything you can donate is appreciated.</p>" +
			"<div id='nag-donate' class='positive-nagbutton nagbutton'>Sure! I can donate this month!</div>" +
			"<div id='nag-shortremind' class='nagbutton'>Please remind me in a few days.</div>" +
			"<div id='nag-longremind' class='nagbutton'>Please remind me next month.</div>" +
			"<div id='nag-neverremind' class='nagbutton'>Never remind me again.</div>" +
			"</div>";
			
		$('body').append(naggerHtml);
		// select the overlay element - and "make it an overlay"
		$("#nagbox").overlay({
			// disable this for modal dialog-type of overlays
			closeOnClick: false,
			// load it immediately after the construction
			load: true
		});
		
		$('#nag-donate').click(Badgame.DonationNag.Donate);
		$('#nag-shortremind').click(Badgame.DonationNag.ShortRemind);
		$('#nag-longremind').click(Badgame.DonationNag.LongRemind);
		$('#nag-neverremind').click(Badgame.DonationNag.NeverRemind);
}

$(document).ready(function() {
	if (Modernizr.localstorage) {
		var hideReminder = localStorage.getItem('nag.neverRemind');
		if (!hideReminder) {
			var nextReminder = parseInt(localStorage.getItem('nag.reminder'));
			if (!nextReminder) {
				Badgame.DonationNag.RemindNextMonth();
			} {
				var nowTime = new Date().getTime();
				if (nowTime > nextReminder) {
					Badgame.DonationNag.ShowNag();
				}
			}
		}
	}
});
