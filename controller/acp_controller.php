<?php
/**
 * toxyy ACP Merge Child Forums
 *
 * @copyright (c) 2022 toxyy <thrashtek@yahoo.com>
 * @license       GNU General Public License, version 2 (GPL-2.0)
 */

namespace toxyy\acpmergechildforums\controller;

class acp_controller
{
	protected $db;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface $db
	 */
	public function __construct(
		\phpbb\db\driver\driver_interface $db,
    )
    {
		$this->db = $db;
	}

	/**
	 * Based off of make_forum_select
	 * https://github.com/phpbb/phpbb/blob/prep-release-3.3.7/phpBB/includes/functions_admin.php#L66 Simple version of
	 * jumpbox, just lists authed forums Made it simpler, allowed for parent forum selection
	 */
	function make_forum_select($select_id = false, $parent_id = false, $return_array = false)
	{
		$rowset = get_forum_branch($parent_id, 'all', 'descending', false);
		$right = 0;
		$padding_store = array('0' => '');
		$padding = '';
		$forum_list = ($return_array) ? array() : '';

		// Sometimes it could happen that forums will be displayed here not be displayed within the index page
		// This is the result of forums not displayed at index, having list permissions and a parent of a forum with no permissions.
		// If this happens, the padding could be "broken"

		foreach ($rowset as $row)
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
			$disabled = false;

			if ($return_array)
			{
				// Include some more information...
				$selected = (is_array($select_id)) ? ((in_array($row['forum_id'], $select_id)) ? true : false) : (($row['forum_id'] == $select_id) ? true : false);
				$forum_list[$row['forum_id']] = array_merge(array('padding' => $padding, 'selected' => ($selected && !$disabled), 'disabled' => $disabled), $row);
			}
			else
			{
				$selected = (is_array($select_id)) ? ((in_array($row['forum_id'], $select_id)) ? ' selected="selected"' : '') : (($row['forum_id'] == $select_id) ? ' selected="selected"' : '');
				$forum_list .= '<option value="' . $row['forum_id'] . '"' . (($disabled) ? ' disabled="disabled" class="disabled-option"' : $selected) . '>' . $padding . $row['forum_name'] . '</option>';
			}
		}
		unset($padding_store, $rowset);

		return $forum_list;
	}
}