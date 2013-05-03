<?php

function template_main()
{
	global $context, $settings, $options, $txt, $scripturl;

	echo '<script type="text/javascript">';
	echo '$(document).ready(function() {
		$(".unhideLink").click(function() {
			var unhideUrl = "index.php?action=hidethread&unhide=1&topic=" + $(this).attr("topicId");
			$.ajax({
				url: unhideUrl,
				success: function() {
					location.reload(true);
				}
			});
		})
	});';

	echo '</script>';

	echo '<div class="genericPanel">';
	echo 'You have ' . count($context['hidden_threads']) . ' threads hidden.';

	foreach($context['hidden_threads'] as $hiddenThread) 
	{
		echo '<div>';
		echo '<h3 style="margin-bottom: 0;"><a href="', $scripturl, '?topic=', $hiddenThread['threadId'], '">', $hiddenThread['threadTitle'], '</a></h3>';

		if ($hiddenThread['opId']) {
			echo 'Posted by : <a href="', $scripturl, '?action=profile;u=', $hiddenThread['opId'], '">', $hiddenThread['opName'], '</a>';
		} else {
			echo 'Posted by : (account deleted)';
		}

		echo ' <span class="lastReadClearButton unhideLink" topicId="', $hiddenThread['threadId'], '">(Unhide this thread?)</a>';

		echo '</div>';
	}

	echo '</div>';
}

?>