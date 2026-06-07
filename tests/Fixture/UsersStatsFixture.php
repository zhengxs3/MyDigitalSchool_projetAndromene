<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersStatsFixture
 */
class UsersStatsFixture extends TestFixture
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
                'total_score' => 1,
                'games_played' => 1,
                'games_won' => 1,
                'created' => '2026-05-31 19:19:04',
                'modified' => '2026-05-31 19:19:04',
            ],
        ];
        parent::init();
    }
}
