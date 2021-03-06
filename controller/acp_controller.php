<?php
/**
 * toxyy ACP Merge Child Forums
 *
 * @copyright	(c) 2022 toxyy <thrashtek@yahoo.com>
 * @license		GNU General Public License, version 2 (GPL-2.0)
 */

namespace toxyy\acpmergechildforums\controller;

class acp_controller
{
	protected $auth;
	protected $cache;

	/**
	 * Constructor
	 *
	 * @param \phpbb\auth\auth	$auth
	 * @param \phpbb\cache		$cache
	 */
	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\cache\driver\driver_interface $cache
	)
	{
		$this->auth		= $auth;
		$this->cache	= $cache;
	}

	/**
	 * Based off of make_forum_select
	 * https://github.com/phpbb/phpbb/blob/prep-release-3.3.7/phpBB/includes/functions_admin.php#L66
	 * Simple version of jumpbox, just lists authed forums Made it simpler, allowed for parent forum selection
	 */
	function make_forum_select($select_id = false, $parent_id = false, $return_array = false)
	{
		$rowset = get_forum_branch($parent_id, 'all', 'descending', false);
		$right = 0;
		$padding_store = ['0' => ''];
		$padding = '';
		$forum_list = $return_array ? [] : '';

		// Sometimes it could happen that forums will be displayed here not be displayed within the index page
		// This is the result of forums not displayed at index, having list permissions and a parent of a forum with no permissions.
		// If this happens, the padding could be "broken"

		foreach ($rowset as $row)
		{
			if (!$return_array)
			{
				if ($row['left_id'] < $right)
				{
					$padding .= '&nbsp; &nbsp;';
					$padding_store[$row['parent_id']] = $padding;
				}
				else if ($row['left_id'] > $right + 1)
				{
					$padding = (isset($padding_store[$row['parent_id']])) ? $padding_store[$row['parent_id']] : '';
				}

				$right = $row['right_id'];

				$selected = (is_array($select_id)) ? ((in_array($row['forum_id'], $select_id)) ? ' selected="selected"' : '') : (($row['forum_id'] == $select_id) ? ' selected="selected"' : '');
				$forum_list .= '<option value="' . $row['forum_id'] . '"' . $selected . '>' . $padding . $row['forum_name'] . '</option>';
			}
			else
			{
				$forum_list[] = $row['forum_id'];
			}
		}
		unset($padding_store, $rowset);

		return $forum_list;
	}

	// made this iterative
	// keeping parameters found in the original despite not needing the action ones
	// https://github.com/phpbb/phpbb/blob/prep-release-3.3.7/phpBB/includes/acp/acp_forums.php#L1618
	function delete_forums($forum_ids, $action_posts = 'delete', $action_subforums = 'delete', $posts_to_id = 0, $subforums_to_id = 0)
	{
		$this->acp_forums = new \acp_forums();
		$errors = [];

		// reversing the forum list should always force forum children below their parents,
		// since we are selecting with a big selectbox. This avoids deleting a parents' subforums
		// before getting to potential children that need to be dealt with first.
		$forum_ids = array_reverse($forum_ids);
		foreach ($forum_ids as $child_id)
		{
			$errors = $this->acp_forums->delete_forum($child_id, $action_posts, $action_subforums, $posts_to_id, $subforums_to_id);

			if (count($errors))
			{
				break;
			}

			$this->auth->acl_clear_prefetch();
			$this->cache->destroy('sql', FORUMS_TABLE);
		}
		return $errors;
	}
}
