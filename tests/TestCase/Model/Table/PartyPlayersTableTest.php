<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PartyPlayersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PartyPlayersTable Test Case
 */
class PartyPlayersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PartyPlayersTable
     */
    protected $PartyPlayers;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.PartyPlayers',
        'app.Users',
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
        $config = $this->getTableLocator()->exists('PartyPlayers') ? [] : ['className' => PartyPlayersTable::class];
        $this->PartyPlayers = $this->getTableLocator()->get('PartyPlayers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PartyPlayers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\PartyPlayersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\PartyPlayersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
