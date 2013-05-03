<?php

if (!defined('SMF'))
	die('Hack attempt...');

function HideThread() {
	global $board, $topic, $user_info, $board_info, $ID_MEMBER, $db_prefix, $modSettings, $context;
	
	is_not_guest();
	
	$topicId = mysql_real_escape_string($_REQUEST['topic']);
	$unhide = mysql_real_escape_string($_REQUEST['unhide']);

	$query = db_query("SELECT * FROM {$db_prefix}bg2_hiddenthreads WHERE 
		id_member = $ID_MEMBER 
		AND id_thread = $topicId", __FILE__, __LINE__);
		
	$numRows = mysql_num_rows($query);
	
	if ($unhide == '1' && $numRows > 0) {
		db_query("DELETE FROM {$db_prefix}bg2_hiddenthreads
			WHERE id_member = $ID_MEMBER AND id_thread = $topicId", __FILE__, __LINE__);
		$context['page_title'] = 'Thread unhidden';
		$context['message'] = 'Thread unhidden.';
	} else if ($numRows > 0) {
		$context['page_title'] = 'Thread already hidden';
		$context['message'] = 'Thread already hidden.';
	}
	
	if ($numRows == 0) {
		db_query("INSERT INTO {$db_prefix}bg2_hiddenthreads
			(id_member, id_thread)
			VALUES ($ID_MEMBER, $topicId)", __FILE__, __LINE__);
		$context['page_title'] = 'Thread hidden';
		$context['message'] = 'Thread hidden.';
	}
	
	loadTemplate('HideThread');
}

function ShowHiddenThreads() {
	global $board, $topic, $user_info, $board_info, $ID_MEMBER, $db_prefix, $modSettings, $context;

	is_not_guest();

	$query = db_query("SELECT ht.id_thread AS threadId, m.subject AS threadTitle, mem.realName AS opName, mem.ID_MEMBER AS opId FROM {$db_prefix}bg2_hiddenthreads AS ht 
		LEFT JOIN {$db_prefix}topics AS t ON t.ID_TOPIC = ht.id_thread
		LEFT JOIN {$db_prefix}messages AS m ON m.ID_MSG = t.ID_FIRST_MSG
		LEFT JOIN {$db_prefix}members AS mem on mem.ID_MEMBER = t.ID_MEMBER_STARTED
		WHERE ht.id_member = $ID_MEMBER", __FILE__, __LINE__);

	$hidden_threads = array();

	while ($row = mysql_fetch_assoc($query)) {
		$hidden_threads[] = $row;
	}

	$context['page_title'] = 'Hidden Threads';
	$context['hidden_threads'] = $hidden_threads;

	loadTemplate('HiddenThreads');
}