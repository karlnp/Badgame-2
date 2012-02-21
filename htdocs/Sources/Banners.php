<?php

if (!defined('SMF'))
	die('Hacking attempt...');

// Show a listing of the registered members.
function Banners()
{
	global $scripturl, $txt, $modSettings, $context, $settings;

	loadTemplate('Banners');

	$context['subaction'] = !empty($_GET['sa']) ? $_GET['sa'] : 'list';

	// $subActions array format:
	// 'subaction' => array('label', 'function', 'is_selected')
	$subActions = array(
		'list' => array("Banner List", 'BannerList', $context['subaction'] == 'list'),
	);
	
	if (allowedTo('upload_banners')) {
		$subActions['upload'] = array("Upload Banner", "BannerUpload", $context['subaction'] == 'upload');
	}
	if (allowedTo('approve_banners')) {
		$subActions['queue'] = array("Mod Queue", 'BannerQueue', $context['subaction'] == 'queue');
	}
	
	// Set up the sort links.
	$context['sort_links'] = array();
	foreach ($subActions as $act => $text)
		$context['sort_links'][] = array(
			'label' => $text[0],
			'action' => $act,
			'selected' => $text[2],
		);

	$context['linktree'][] = array(
		'url' => $scripturl . '?action=banners',
		'name' => "Banners"
	);

	// Jump to the sub action.
	if (isset($subActions[$context['subaction']]))
		$subActions[$context['subaction']][1]();
	else
		$subActions['list'][1]();
	
}

function BannerList()
{
	global $scripturl, $txt, $modSettings, $context, $settings, $db_prefix;
	
	$context['page_title'] = "Banner List";
	
	$request = db_query("
				SELECT banners.id, banners.id_uploader, banners.upload_time, banners.filename, banners.approved, members.ID_MEMBER, members.memberName
				FROM {$db_prefix}bg2_banners AS banners, ${db_prefix}members AS members
				WHERE banners.approved = true 
				AND banners.id_uploader = members.ID_MEMBER
				ORDER BY banners.upload_time DESC", __FILE__, __LINE__);
					
	$context['banners'] = array();
		
	while ($row = mysql_fetch_assoc($request))
	{
		$banner = array(
			"id" => $row['id'],
			"filename" => $row['filename'],
			"time" => $row['upload_time'],
			"uploader_id" => $row['id_uploader'],
			"uploader_name" => $row['memberName']
		);
		
		array_push($context['banners'], $banner);
	}
	
	mysql_free_result($request);
}

function BannerUpload()
{
	global $bannerLocationPrefix, $scripturl, $txt, $modSettings, $context, $settings, $db_prefix;
	
	$context['page_title'] = "Upload a Banner";
	$context['sub_template'] = 'upload';
	
	if ($_FILES['banner']) {
		// Oh shit! Someone's trying to upload something!
		$sizes = @getimagesize($_FILES['banner']['tmp_name']);
		if ($sizes === false) {
			$context['banner_upload_error'] = 'Invalid file.';
		} else if (is_array($sizes)) {
			if ($sizes[0] !== 445 || $sizes[1] !== 115) {
				$context['banner_upload_error'] = 'Your banner is not 445x115.';
			} else {
				if ($_FILES['banner']['size'] > 256*1024) {
					$context['banner_upload_error'] = 'Your banner is too large a file. Please try to make it smaller.';
				} else {
					$filehash = sha1_file($_FILES['banner']['tmp_name']);
					if (hashExists($filehash)) {
						$context['banner_upload_error'] = "This banner has already been uploaded. Calm down!";
					} else {
						
						// Well, it passed all our checks...
						
						$extensions = array(
							'1' => '.gif',
							'2' => '.jpg',
							'3' => '.png',
							'6' => '.bmp'
						);
						$extension = isset($extensions[$sizes[2]]) ? $extensions[$sizes[2]] : '.bmp';
						
						// Set bannerLocationPrefix in Settings.php
						$newFilename = $bannerLocationPrefix . $filehash . $extension;

						// Move the file.
						rename($_FILES['banner']['tmp_name'], $newFilename);
						
						$memberId = $context['user']['id'];
						$timestamp = time();
						$filename = "/banners/" . $filehash . $extension;
						
						// Insert our new shit into the database.
						db_query("
							INSERT INTO {$db_prefix}bg2_banners
								(id_uploader, upload_time, filename, hash)
								VALUES ($memberId, $timestamp, '$filename', '$filehash')", __FILE__, __LINE__);	
								
						$context['banner_upload_success'] = "Banner successfully uploaded!";

					}
				}
			}
		}
	}
}

function hashExists($candidateHash) {
	global $context, $db_prefix;
	
	$request = db_query("
			SELECT *
			FROM {$db_prefix}bg2_banners
			WHERE hash = '$candidateHash'", __FILE__, __LINE__);
				
	if ($row = mysql_fetch_assoc($request))
	{
		mysql_free_result($request);
		return true;
	}
	
	mysql_free_result($request);
	return false;
	
}

function BannerQueue()
{
	global $scripturl, $txt, $modSettings, $context, $settings, $db_prefix;
	
	$context['page_title'] = "Banner Queue";
	$context['sub_template'] = 'queue';
	
	// Someone could be trying to approve/reject a banner.
	if (!empty($_GET['approve'])) {
		$approvedBannerId = mysql_real_escape_string($_GET['approve']);
		
		db_query("
			UPDATE {$db_prefix}bg2_banners
			SET approved = 1
			WHERE id = $approvedBannerId", __FILE__, __LINE__);
		
		$context['banner_mod_message'] = "Banner approved!";
	} else {
		// If they're not, list all the banners waiting for approval.
		$request = db_query("
				SELECT banners.id, banners.id_uploader, banners.upload_time, banners.filename, banners.approved, members.ID_MEMBER, members.memberName
				FROM {$db_prefix}bg2_banners AS banners, ${db_prefix}members AS members
				WHERE banners.approved = false 
				AND banners.id_uploader = members.ID_MEMBER
				ORDER BY banners.upload_time DESC", __FILE__, __LINE__);
					
		$context['queued_banners'] = array();
		
		while ($row = mysql_fetch_assoc($request))
		{
			$banner = array(
				"id" => $row['id'],
				"filename" => $row['filename'],
				"time" => $row['upload_time'],
				"uploader_id" => $row['id_uploader'],
				"uploader_name" => $row['memberName']
			);
			
			array_push($context['queued_banners'], $banner);
		}
		
		mysql_free_result($request);
	}
}
?>
