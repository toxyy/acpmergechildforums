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
	protected $php_ext;

	/**
	 * Constructor
	 *
	 * @param \phpbb\language\language								$language
	 * @param \phpbb\request\request								$request
	 * @param \toxyy\acpmergechildforums\controller\acp_controller	$acp_controller
	 * @param string												$php_ext
	 */
	public function __construct(
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\toxyy\acpmergechildforums\controller\acp_controller $acp_controller,
		$php_ext
	)
	{
		$this->language			= $language;
		$this->request			= $request;
		$this->acp_controller	= $acp_controller;
		$this->php_ext			= $php_ext;
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

		$submit = $this->request->variable('mcf_submit', '');
		$all_forums = $this->request->variable('mcf_all_forums', 0);
		$forum_list = $this->request->variable('mcf_f', [0]);
		$u_action = $template_data['U_EDIT_ACTION'];

		if($submit)
		{
			if(confirm_box(true))
			{
				trigger_error($this->language->lang('ACP_MCF_SUCCESS') . adm_back_link($u_action));
			}
			else
			{
				if(empty($forum_list) && !$all_forums)
				{
					trigger_error($this->language->lang('ACP_MCF_NO_EXIST') . adm_back_link($u_action), E_USER_WARNING);
				}

				confirm_box(false, $this->language->lang('ACP_MCF_CONFIRM'), build_hidden_fields([
					'mcf_submit'		=> $submit,
					'mcf_all_forums'	=> $all_forums,
					'mcf_f'				=> $forum_list
				]));

				redirect($u_action);
			}
		}

		$template_data = array_merge($template_data, [
			'S_MCF_FORUM_OPTIONS' => $this->acp_controller->make_forum_select(false, $event['forum_id'])
		]);

		$event['template_data'] = $template_data;
	}
}
