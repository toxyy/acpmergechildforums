<?php
/**
 * toxyy ACP Merge Child Forums
 *
 * @copyright (c) 2022 toxyy <thrashtek@yahoo.com>
 * @license		  GNU General Public License, version 2	(GPL-2.0)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang =	array();
}

$lang =	array_merge($lang, array(
	'ACP_MCF'				  => 'Merge	child forums',
	'ACP_MCF_EXPLAIN'		  => 'Merges selected child	forums into	this forum.	All	posts are retained and all selected	forums will	be deleted.',
	'ACP_MCF_CONFIRM'		  => 'Confirm merge',
	'ACP_MCF_CONFIRM_EXPLAIN' => 'Are you sure you want	to merge these forums\'	children into this one?	This will delete all selected child	forums and move	their posts	to this	forum.',
	'ACP_MCF_SUCCESS'		  => 'Selected forum children successfully merged.',
));
