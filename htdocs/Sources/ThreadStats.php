<?php

if (!defined('SMF'))
	die('Hack attempt...');

function ThreadStats() {
	global $board, $topic, $user_info, $board_info, $ID_MEMBER, $db_prefix, $modSettings, $context;
	
	is_not_guest();
	
	$topicId = mysql_real_escape_string($_REQUEST['topic']);

	$query = db_query("SELECT t.ID_TOPIC, m.subject 
		FROM {$db_prefix}topics AS t LEFT JOIN {$db_prefix}messages AS m
		ON t.ID_FIRST_MSG = m.ID_MSG
		WHERE t.ID_TOPIC = $topicId", __FILE__, __LINE__);

	while ($row = mysql_fetch_assoc($query)) {
		$context['threadId'] = $topicId;
		$context['threadSubject'] = $row['subject'];
	}

	mysql_free_result($query);

	$query = db_query("SELECT {$db_prefix}messages.ID_MEMBER AS memberId, COUNT(ID_MSG) AS messages, {$db_prefix}members.realName as memberName
		FROM {$db_prefix}messages LEFT JOIN ${db_prefix}members
		ON {$db_prefix}messages.ID_MEMBER = ${db_prefix}members.ID_MEMBER
		WHERE ID_TOPIC = $topicId
		GROUP BY {$db_prefix}messages.ID_MEMBER
		ORDER BY messages DESC", __FILE__, __LINE__);
	
	$threadPosterStats = array();

	while ($row = mysql_fetch_assoc($query)) {
		if ($row['memberId'] != 0) {
			$threadPosterStats[] = $row;
		}
	}

	mysql_free_result($query);

	$context['threadPosterStats'] = $threadPosterStats;

	loadTemplate('ThreadStats');
}

?>