<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlayerDecisionsFixture
 */
class PlayerDecisionsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'user_id' => 1,
                'decision_id' => 1,
                'party_id' => 1,
                'elapsed_time' => 1,
                'score' => 1,
                'created' => '2026-05-31 19:19:39',
                'modified' => '2026-05-31 19:19:39',
            ],
        ];
        parent::init();
    }
}
