<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BriefingsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BriefingsTable Test Case
 */
class BriefingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BriefingsTable
     */
    protected $Briefings;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Briefings',
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
        $config = $this->getTableLocator()->exists('Briefings') ? [] : ['className' => BriefingsTable::class];
        $this->Briefings = $this->getTableLocator()->get('Briefings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Briefings);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\BriefingsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
