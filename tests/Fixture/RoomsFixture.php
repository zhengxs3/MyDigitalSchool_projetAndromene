<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RoomsFixture
 */
class RoomsFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'code' => 'Lorem ipsum dolor ',
                'status' => 'Lorem ipsum dolor sit amet',
                'max_players' => 1,
                'created_by' => 1,
                'created' => '2026-05-26 10:07:42',
                'modified' => '2026-05-26 10:07:42',
            ],
        ];
        parent::init();
    }
}
