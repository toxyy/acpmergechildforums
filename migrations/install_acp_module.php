<?php
/**
 * toxyy ACP Merge Child Forums
 *
 * @copyright (c) 2022 toxyy <thrashtek@yahoo.com>
 * @license       GNU General Public License, version 2 (GPL-2.0)
 */

namespace toxyy\acpmergechildforums\migrations;

class install_acp_module extends \phpbb\db\migration\migration
{
    public function effectively_installed()
	{
		return isset($this->config['toxyy_mcf_version']);
	}

    static public function depends_on()
    {
        return ['\phpbb\db\migration\data\v31x\v314'];
    }

    public function update_data()
    {
        return [
			['config.add', ['toxyy_mcf_version', '1.00']],
            ['module.add', [
                'acp',
                'ACP_MANAGE_FORUMS',
                [
                    'module_basename' => '\toxyy\acpmergechildforums\acp\main_module',
                ],
            ]],
        ];
    }
}
