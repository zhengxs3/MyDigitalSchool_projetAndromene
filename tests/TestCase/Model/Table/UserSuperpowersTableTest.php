<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserSuperpowersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserSuperpowersTable Test Case
 */
class UserSuperpowersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserSuperpowersTable
     */
    protected $UserSuperpowers;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.UserSuperpowers',
        'app.Users',
        'app.Superpowers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UserSuperpowers') ? [] : ['className' => UserSuperpowersTable::class];
        $this->UserSuperpowers = $this->getTableLocator()->get('UserSuperpowers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->UserSuperpowers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\UserSuperpowersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\UserSuperpowersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
