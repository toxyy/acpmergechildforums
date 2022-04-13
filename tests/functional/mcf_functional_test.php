<?php
/**
 * toxyy ACP Merge Child Forums
 *
 * @copyright	(c) 2022 toxyy <thrashtek@yahoo.com>
 * @license		GNU General Public License, version 2 (GPL-2.0)
 */

namespace toxyy\acpmergechildforums\tests\functional;

/**
 * @group functional
 */
class mcf_functional_test extends \phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return array('toxyy/acpmergechildforums');
	}

	protected function setUp(): void
	{
		parent::setUp();

		$this->add_lang_ext('phpbb/topicprefixes', ['info_acp_acpmergechildforums']);
	}

	public function test_edit_forum_installed()
	{
		$this->login();
		$this->admin_login();
		$crawler = self::request('GET', "adm/index.php?i=acp_forums&icat=7&mode=manage&parent_id=0&f=2&action=edit&sid=={$this->sid}");
		$this->assertContains($this->lang('ACP_MCF'), $crawler->filter('#forumedit')->text());
	}
}