<?php

if (!defined('SMF'))
	die('Hack attempt...');

function ClearLastRead() {
	global $board, $topic, $user_info, $board_info, $ID_MEMBER, $db_prefix, $modSettings;
	
	is_not_guest();
	
	$topicId = mysql_real_escape_string($_REQUEST['topic']);
	
	$query = db_query("SELECT * FROM {$db_prefix}bg2_lastread WHERE 
		id_member = $ID_MEMBER 
		AND id_thread = $topicId", __FILE__, __LINE__);
		
	$numRows = mysql_num_rows($query);
	
	if ($numRows > 0) {
		db_query("DELETE FROM {$db_prefix}bg2_lastread WHERE 
			id_member = $ID_MEMBER 
			AND id_thread = $topicId", __FILE__, __LINE__);
		$context['clearedLastRead'] = true;
	} else {
		$context['clearedLastRead'] = false;
	}
	
	$context['page_title'] = 'Cleared Last Read';
	loadTemplate('ClearLastRead');
}
