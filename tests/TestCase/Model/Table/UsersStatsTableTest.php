<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersStatsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersStatsTable Test Case
 */
class UsersStatsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersStatsTable
     */
    protected $UsersStats;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.UsersStats',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UsersStats') ? [] : ['className' => UsersStatsTable::class];
        $this->UsersStats = $this->getTableLocator()->get('UsersStats', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->UsersStats);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\UsersStatsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\UsersStatsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
