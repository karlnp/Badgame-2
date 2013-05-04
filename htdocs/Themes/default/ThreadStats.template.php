<?php

function template_main()
{
	global $context, $settings, $options, $txt, $scripturl;

	echo '<div class="genericPanel">';

	echo '<a href="', $scripturl, '?topic=', $context['threadId'], '"><b>Thread stats for ', $context['threadSubject'], '</b></a><br /><br />';

	echo '<table class="bordercolor" cellpadding="4" style="width: 96%; margin: 0 auto">';
	
	$rowclass = "windowbg";

	foreach($context['threadPosterStats'] as $row)
	{
		if ($rowclass == "windowbg") {
			$rowclass = "windowbg2";
		} else if ($rowclass == "windowbg2") {
			$rowclass = "windowbg";
		}

		echo '<tr class="', $rowclass, '">
		<td><a href="', $scripturl, '?action=profile;u=', $row['memberId'], '">', $row['memberName'], '</a></td><td>',
		'<a href="', $scripturl, '?topic=', $context['threadId'], '&filterUserId=', $row['memberId'], '">', $row['messages'], '</a></td>
		</tr>';
	}
	echo '</table>';

	echo '</div>';
}

?>