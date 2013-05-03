<?php

if (!defined('SMF'))
	die('Hack attempt...');

function HideThread() {
	global $board, $topic, $user_info, $board_info, $ID_MEMBER, $db_prefix, $modSettings;
	
	is_not_guest();
	
	$topicId = mysql_real_escape_string($_REQUEST['topic']);
	
	$query = db_query("SELECT * FROM {$db_prefix}bg2_hiddenthreads WHERE 
		id_member = $ID_MEMBER 
		AND id_thread = $topicId", __FILE__, __LINE__);
		
	$numRows = mysql_num_rows($query);
	
	if ($numRows == 0) {
		db_query("INSERT INTO {$db_prefix}bg2_hiddenthreads
			(id_member, id_thread)
			VALUES ($ID_MEMBER, $topicId)", __FILE__, __LINE__);
	}
	
	$context['page_title'] = 'Thread Hidden';
	loadTemplate('HideThread');
}

function ShowHiddenThreads() {
	global $board, $topic, $user_info, $board_info, $ID_MEMBER, $db_prefix, $modSettings;

	is_not_guest();

	$query = db_query("SELECT * FROM {$db_prefix}bg2_hiddenthreads WHERE 
		id_member = $ID_MEMBER", __FILE__, __LINE__);

	$context['page_title'] = 'Hidden Threads';
	loadTemplate('HiddenThreads');
}