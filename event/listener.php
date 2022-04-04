<?php
/**
 * toxyy ACP Merge Child Forums
 *
 * @copyright (c) 2022 toxyy <thrashtek@yahoo.com>
 * @license       GNU General Public License, version 2 (GPL-2.0)
 */

namespace toxyy\acpmergechildforums\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $helper;
	protected $language;
	protected $php_ext;

	/**
	 * Constructor
	 *
	 * @param \phpbb\template\template    $template
	 * @param \phpbb\user                 $user
	 * @param \phpbb\language\language    $language
	 * @param string                      $php_ext
	 */
	public function __construct(
		\phpbb\controller\helper $helper,
		\phpbb\language\language $language,
		$php_ext
	)
	{
		$this->helper  = $helper;
		$this->lang    = $language;
		$this->php_ext = $php_ext;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.acp_manage_forums_display_form' => 'acp_manage_forums_display_form',
		];
	}

	public function acp_manage_forums_display_form($event)
	{
		//global $phpbb_container;
		$template_data = $event['template_data'];
		//$controller	= $phpbb_container->get('toxyy.acpmergechildforums.controller.acp');
        //$controller->set_page_url($template_data['U_BACK']);
		$basename = "-toxyy-acpmergechildforums-acp-main_module";
		$mode = "confirm";
		$template_data += [
			'U_MCF' => append_sid("index.$this->php_ext") . "&amp;i=$basename&amp;mode=$mode",
		];
		//print_r($template_data);
		//exit;
		$event['template_data'] = $template_data;
	}
}
