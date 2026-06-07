<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PartiesFixture
 */
class PartiesFixture extends TestFixture
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
                'briefing_id' => 1,
                'room_id' => 1,
                'status' => 'Lorem ipsum dolor sit amet',
                'current_round' => 1,
                'created' => '2026-05-31 19:19:12',
                'modified' => '2026-05-31 19:19:12',
            ],
        ];
        parent::init();
    }
}
