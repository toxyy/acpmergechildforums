<?php
/**
 * toxyy ACP Merge Child Forums
 *
 * @copyright (c) 2022 toxyy <thrashtek@yahoo.com>
 * @license       GNU General Public License, version 2 (GPL-2.0)
 */

namespace toxyy\acpmergechildforums\acp;

class main_module
{
    public $page_title;
    public $tpl_name;
    public $u_action;

	public function main($id, $mode)
	{
        global $language, $template, $request, $config;

        $this->tpl_name = 'acp_demo_body';
        $this->page_title = $language->lang('ACP_DEMO_TITLE');

        add_form_key('acme_demo_settings');

        if ($request->is_set_post('submit'))
        {
            if (!check_form_key('acme_demo_settings'))
            {
                 trigger_error('FORM_INVALID');
            }

            $config->set('acme_demo_goodbye', $request->variable('acme_demo_goodbye', 0));
            trigger_error($language->lang('ACP_DEMO_SETTING_SAVED') . adm_back_link($this->u_action));
        }

        $template->assign_vars([
            'ACME_DEMO_GOODBYE' => $config['acme_demo_goodbye'],
            'U_ACTION'          => $this->u_action,
        ]);
	}
}
