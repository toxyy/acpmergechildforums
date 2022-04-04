<?php
/**
 * toxyy ACP Merge Child Forums
 *
 * @copyright (c) 2022 toxyy <thrashtek@yahoo.com>
 * @license       GNU General Public License, version 2 (GPL-2.0)
 */

namespace toxyy\acpmergechildforums\acp;

class main_info
{
    public function module()
    {
        return [
            'filename' => '\toxyy\acpmergechildforums\acp\main_module',
            'title'    => 'ACP_MCF',
            'modes'    => [
                'confirm'  => [
                    'title'   => 'ACP_MCF',
                    'auth'    => 'ext_toxyy/acpmergechildforums && acl_a_board',
                    'display' => 0,
                    'cat'     => ['ACP_MCF'],
                ],
            ],
        ];
    }
}
