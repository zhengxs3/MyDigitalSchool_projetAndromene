<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserSuperpowersFixture
 */
class UserSuperpowersFixture extends TestFixture
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
                'superpower_id' => 1,
                'quantity' => 1,
            ],
        ];
        parent::init();
    }
}
