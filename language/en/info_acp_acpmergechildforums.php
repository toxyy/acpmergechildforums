<?php
/**
 * toxyy ACP Merge Child Forums
 *
 * @copyright	(c) 2022 toxyy <thrashtek@yahoo.com>
 * @license		GNU General Public License, version 2 (GPL-2.0)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang =	array_merge($lang, [
	'ACP_MCF'					=> 'Merge child forums',
	'ACP_MCF_EXPLAIN'			=> 'Merges selected child forums into this forum. All selected forums will be deleted, and all their posts will be moved.',
	'ACP_MCF_CONFIRM'			=> 'Are you sure you want to merge these forums into this one? This will delete the selected forums and move their posts to this forum.',
	'ACP_MCF_NO_EXIST'			=> 'You must select at least one forum to merge.',
	'ACP_MCF_SUCCESS'			=> 'Selected forum children successfully merged.',
]);
