<?php
/**
 * toxyy ACP Merge Child Forums
 *
 * @copyright (c) 2022 toxyy <thrashtek@yahoo.com>
 * @license		  GNU General Public License, version 2	(GPL-2.0)
 */

namespace toxyy\acpmergechildforums\event;

use	Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $language;
	protected $request;
	protected $acp_controller;
	protected $php_ext;

	/**
	 * Constructor
	 *
	 * @param \phpbb\language\language							   $language
	 * @param \phpbb\request\request							   $request
	 * @param \toxyy\acpmergechildforums\controller\acp_controller $acp_controller
	 * @param string											   $php_ext
	 */
	public function	__construct(
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\toxyy\acpmergechildforums\controller\acp_controller $acp_controller,
		$php_ext
	)
	{
		$this->lang			  = $language;
		$this->request		  = $request;
		$this->acp_controller =	$acp_controller;
		$this->php_ext		  = $php_ext;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.acp_manage_forums_display_form' => 'acp_manage_forums_display_form',
		];
	}

	public function	acp_manage_forums_display_form($event)
	{
		$template_data = $event['template_data'];
		$basename =	"-toxyy-acpmergechildforums-acp-main_module";
		$mode =	"confirm";
		$u_back_vars = "prev_basename={$this->request->variable('i', '')}
					&amp;prev_icat={$this->request->variable('icat', 0)}
					&amp;prev_mode={$this->request->variable('mode', '')}
					&amp;prev_parent_id={$this->request->variable('parent_id', 0)}
					&amp;f={$this->request->variable('f', 0)}
					&amp;prev_action={$this->request->variable('action', '')}";

		$submit = $this->request->variable('mcf_submit', '');

		if($submit)
		{
			$forum_list = $this->request->variable('mcf_f', [0]);
		}

		$template_data += [
			'U_MCF'				  => append_sid("./index.$this->php_ext") .	"&amp;i=$basename&amp;mode=$mode&amp;$u_back_vars",
			'S_MCF_FORUM_OPTIONS' => $this->acp_controller->make_forum_select(false, $event['forum_id']),
		];

		$event['template_data']	= $template_data;
	}
}
