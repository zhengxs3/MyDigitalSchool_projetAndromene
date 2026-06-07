<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlayerDecisionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlayerDecisionsTable Test Case
 */
class PlayerDecisionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlayerDecisionsTable
     */
    protected $PlayerDecisions;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.PlayerDecisions',
        'app.Users',
        'app.Decisions',
        'app.Parties',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PlayerDecisions') ? [] : ['className' => PlayerDecisionsTable::class];
        $this->PlayerDecisions = $this->getTableLocator()->get('PlayerDecisions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PlayerDecisions);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\PlayerDecisionsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\PlayerDecisionsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
