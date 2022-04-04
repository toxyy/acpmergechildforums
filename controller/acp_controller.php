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
    protected $helper;
    protected $language;
    protected $log;
    protected $request;
    protected $template;
    protected $user;
    protected $u_action;

    /**
     * Constructor
     *
     * @param \phpbb\controller\helper     $helper
	 * @param  \phpbb\language\language    $language
	 * @param  \phpbb\log\log              $log
	 * @param  \phpbb\request\request      $request
	 * @param  \phpbb\template\template    $template
	 * @param  \phpbb\user                 $user
     */
    public function __construct(
        \phpbb\controller\helper $helper,
        \phpbb\language\language $language,
        \phpbb\log\log $log,
        \phpbb\request\request $request,
        \phpbb\template\template $template,
        \phpbb\user $user,
    )
    {
        $this->helper   = $helper;
        $this->language = $language;
		$this->log      = $log;
		$this->request  = $request;
		$this->template = $template;
		$this->user     = $user;
    }

    public function display_page($forumid = 0)
    {
        global $phpbb_container;

		$this->language = $phpbb_container->get('language');
		$this->log = $phpbb_container->get('log');
		$this->user = $phpbb_container->get('user');
		$this->request = $phpbb_container->get('request');
		$this->template = $phpbb_container->get('template');

		$this->language->add_lang('info_acp_acpmergechildforums', 'toxyy/acpmergechildforums');
        $action = $this->request->variable('action', '');
        /* Do this now and forget */
        $errors = array();

        /* Add a form key for security */
        add_form_key('acp_merge_child_forums');

        /*if (confirm_box(true))
        {
            $this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'ACP_MCF_SUCCESS', time());

            if ($this->request->is_ajax())
            {
                $json_response = new \phpbb\json_response();

                $json_response->send(array(
                    'MESSAGE_TITLE'	=> $this->language->lang('INFORMATION'),
                    'MESSAGE_TEXT'	=> $this->language->lang('ACP_MCF_SUCCESS'),
                    'REFRESH_DATA'	=> array(
                        'url'	=> '',
                        'time'	=> 3,
                    ),
                ));
            }

            trigger_error($this->language->lang('ACP_MCF_SUCCESS') . adm_back_link($this->u_action));
        }
        else
        {
            confirm_box(false, $this->language->lang('ACP_MCF_CONFIRM'), build_hidden_fields(array(
                'action'	=> $action))
            );

            redirect($this->u_action);
        }*/

        $this->template->assign_vars([
            'U_ACTION'          => $this->u_action,
        ]);
    }

    public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}