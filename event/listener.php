<?php
/**
 * toxyy ACP Merge Child Forums
 *
 * @copyright	(c) 2022 toxyy <thrashtek@yahoo.com>
 * @license		GNU General Public License, version 2 (GPL-2.0)
 */

namespace toxyy\acpmergechildforums\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $language;
	protected $request;
	protected $acp_controller;

	/**
	 * Constructor
	 *
	 * @param \phpbb\language\language								$language
	 * @param \phpbb\request\request								$request
	 * @param \toxyy\acpmergechildforums\controller\acp_controller	$acp_controller
	 */
	public function __construct(
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\toxyy\acpmergechildforums\controller\acp_controller $acp_controller
	)
	{
		$this->language			= $language;
		$this->request			= $request;
		$this->acp_controller	= $acp_controller;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.acp_manage_forums_display_form' => 'acp_manage_forums_display_form',
		];
	}

	public function acp_manage_forums_display_form($event)
	{
		$template_data = $event['template_data'];

		$forum_id = $this->request->variable('f', 0);
		$submit = $this->request->variable('mcf_submit', '');
		$all_forums = $this->request->variable('mcf_all_forums', 0);
		$forum_ids = $this->request->variable('mcf_f', [0]);
		$u_action = $template_data['U_EDIT_ACTION'];
		$errors = [];

		if ($submit)
		{
			if (confirm_box(true))
			{
				// get array of all forum ids if we are deleting all
				if ($all_forums)
				{
					$forum_ids = $this->acp_controller->make_forum_select(false, $event['forum_id'], true);
				}
				$errors = $this->acp_controller->delete_forums($forum_ids, 'move', 'delete', $forum_id);
				trigger_error($this->language->lang('ACP_MCF_SUCCESS') . adm_back_link($u_action));
			}
			else
			{
				if (empty($forum_ids) && !$all_forums)
				{
					trigger_error($this->language->lang('ACP_MCF_NO_EXIST') . adm_back_link($u_action), E_USER_WARNING);
				}

				confirm_box(false, $this->language->lang('ACP_MCF_CONFIRM'), build_hidden_fields([
					'mcf_submit'		=> $submit,
					'mcf_all_forums'	=> $all_forums,
					'mcf_f'				=> $forum_ids
				]));

				redirect($u_action);
			}
		}

		$template_data = array_merge($template_data, [
			'S_ERRORS'				=> ($errors) ? true : false,
			'ERROR_MSG'				=> implode('<br /><br />', $errors),
			'S_MCF_FORUM_OPTIONS'	=> $this->acp_controller->make_forum_select(false, $event['forum_id'])
		]);

		$event['template_data'] = $template_data;
	}
}
