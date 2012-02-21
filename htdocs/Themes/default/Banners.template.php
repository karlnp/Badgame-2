<?php

function template_main() 
{
	global $context, $settings, $options, $scripturl, $txt;

	// Show the link tree.
	echo '
	<div style="padding: 3px;">', theme_linktree(), '</div>';
	
	// shall we use the tabs?
	if (!empty($settings['use_tabs']))
	{
		// Display links to view all/upload.
		echo '
	<table cellpadding="0" cellspacing="0" border="0" style="margin-left: 10px;">
		<tr>
			<td class="mirrortab_first">&nbsp;</td>';

		foreach ($context['sort_links'] as $link)
		{
			if ($link['selected'])
				echo '
				<td class="mirrortab_active_first">&nbsp;</td>
				<td valign="top" class="mirrortab_active_back">
					<a href="' . $scripturl . '?action=banners' . (!empty($link['action']) ? ';sa=' . $link['action'] : '') . '">', $link['label'], '</a>
				</td>
				<td class="mirrortab_active_last">&nbsp;</td>';
			else
				echo '
				<td valign="top" class="mirrortab_back">
					<a href="' . $scripturl . '?action=banners' . (!empty($link['action']) ? ';sa=' . $link['action'] : '') . '">', $link['label'], '</a>
				</td>';
		}

		echo '
			<td class="mirrortab_last">&nbsp;</td>
		</tr>
	</table>';
	}
	
	echo '<div class="tborder" style="padding: 10px">';
	
	foreach ($context['banners'] as $banner) {
		echo '<img src="', $banner['filename'], '" title="Uploaded by ', $banner['uploader_name'], '" style="margin: 5px" />';
	}
	echo '</div>';
}

function template_upload() 
{
	global $context, $settings, $options, $scripturl, $txt;

	// Show the link tree.
	echo '
	<div style="padding: 3px;">', theme_linktree(), '</div>';
	
	// shall we use the tabs?
	if (!empty($settings['use_tabs']))
	{
		// Display links to view all/upload.
		echo '
	<table cellpadding="0" cellspacing="0" border="0" style="margin-left: 10px;">
		<tr>
			<td class="mirrortab_first">&nbsp;</td>';

		foreach ($context['sort_links'] as $link)
		{
			if ($link['selected'])
				echo '
				<td class="mirrortab_active_first">&nbsp;</td>
				<td valign="top" class="mirrortab_active_back">
					<a href="' . $scripturl . '?action=banners' . (!empty($link['action']) ? ';sa=' . $link['action'] : '') . '">', $link['label'], '</a>
				</td>
				<td class="mirrortab_active_last">&nbsp;</td>';
			else
				echo '
				<td valign="top" class="mirrortab_back">
					<a href="' . $scripturl . '?action=banners' . (!empty($link['action']) ? ';sa=' . $link['action'] : '') . '">', $link['label'], '</a>
				</td>';
		}

		echo '
			<td class="mirrortab_last">&nbsp;</td>
		</tr>
	</table>';
	}
	
	echo '<div class="tborder">';
	
	echo '<div class="banner-help">';
	echo '<h1>Let\'s make a banner!</h1>';
	echo '<p>Did you know? All banners at the top of the page appear from a random rotation of user-submitted banners. ',
		'This is your chance to create your own! All you have to do is follow these 3 rules and upload your banner ',
		'with the form provided.</p>';
	echo '<ul>';
	echo '<li>All banners must be 445x115 in size. For the sake of consistency, applying a 1px black border around the edges is nice, but not necessary.</li>';
	echo '<li>Banners must be under 256kb in size.</li>';
	echo '<li>Banners should be work-safe and have either an aesthetic or humorous quality.</li>';
	echo '</ul>';
	echo '<p>Once uploaded, your banner is put in a moderation queue. The mods check this regularly ', 
		'as a final pass before either approving or rejecting your banner. You won\'t be notified in ',
		'the event of either happening, so please be patient and don\'t worry about it.</p>';
	echo '<p>Thanks, and have fun.</p>';
	echo '</div>';
	
	echo '<div style="width: 400px; text-align: center; margin: 0 auto;">';
	if ($context['banner_upload_error']) {
		echo '<span style="color: red; font-size: 1.5em; font-weight: bold">', $context['banner_upload_error'], '</span>';
	}
	if ($context['banner_upload_success']) {
		echo '<span style="color: green; font-size: 1.5em; font-weight: bold">', $context['banner_upload_success'], '</span>';
	}
	echo '<form action="', $scripturl, '?action=banners;sa=upload" method="post" enctype="multipart/form-data" >';
	echo '<input type="file" size="48" name="banner" /><br />';
	echo '<input type="submit" value="Upload banner!" />';
	echo '</form>';
	echo '</div>';
	
	echo '</div>';
}

function template_queue() 
{
	global $context, $settings, $options, $scripturl, $txt;

	// Show the link tree.
	echo '
	<div style="padding: 3px;">', theme_linktree(), '</div>';
	
	// shall we use the tabs?
	if (!empty($settings['use_tabs']))
	{
		// Display links to view all/upload.
		echo '
	<table cellpadding="0" cellspacing="0" border="0" style="margin-left: 10px;">
		<tr>
			<td class="mirrortab_first">&nbsp;</td>';

		foreach ($context['sort_links'] as $link)
		{
			if ($link['selected'])
				echo '
				<td class="mirrortab_active_first">&nbsp;</td>
				<td valign="top" class="mirrortab_active_back">
					<a href="' . $scripturl . '?action=banners' . (!empty($link['action']) ? ';sa=' . $link['action'] : '') . '">', $link['label'], '</a>
				</td>
				<td class="mirrortab_active_last">&nbsp;</td>';
			else
				echo '
				<td valign="top" class="mirrortab_back">
					<a href="' . $scripturl . '?action=banners' . (!empty($link['action']) ? ';sa=' . $link['action'] : '') . '">', $link['label'], '</a>
				</td>';
		}

		echo '
			<td class="mirrortab_last">&nbsp;</td>
		</tr>
	</table>';
	}
	
	echo '<div class="tborder">';
	
	if ($context['banner_mod_message']) {
		echo '<div class="badgame-message">', $context['banner_mod_message'], '</div>';
	} else {
		echo '<div class="banner-queue-help">';
		echo '<p>', count($context['queued_banners']), " banners currently in the queue.</p>";
		echo '<p>Rejecting banners should work now. Please reject any banners that have been in the BG1 rotation, 
		they will be brought back at a later date.</p><p>Similarly please reject any plain old unfunny / lazy banners - the user doesn\'t
		know their banner has been rejected. Contact me immediately if anything bad crops up.</p>';
		echo '</div>';
		echo '<div class="banner-collection">';
		
		foreach ($context['queued_banners'] as $banner) {
			echo '<div class="queued-banner">',
				'<b>Uploaded on ', date('M d Y H:i', $banner['time']), ' by ', $banner['uploader_name'], '</b><br />',
				'<img src="', $banner['filename'], '" /><br />',
				'<a href="', $scripturl, '?action=banners;sa=queue;approve=', $banner['id'], '">Approve this banner</a> |',
				' <a href="', $scripturl, '?action=banners;sa=queue;reject=', $banner['id'], '">Reject this banner</a>',
				'</div>';
		}
		
		echo '</div>';
	}
	echo '</div>';
}

?>