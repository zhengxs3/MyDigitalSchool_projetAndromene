<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SuperpowersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SuperpowersTable Test Case
 */
class SuperpowersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SuperpowersTable
     */
    protected $Superpowers;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Superpowers',
        'app.UserSuperpowers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Superpowers') ? [] : ['className' => SuperpowersTable::class];
        $this->Superpowers = $this->getTableLocator()->get('Superpowers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Superpowers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\SuperpowersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
