<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PartyPlayersFixture
 */
class PartyPlayersFixture extends TestFixture
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
                'party_id' => 1,
                'role' => 'Lorem ipsum dolor sit amet',
                'objective' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'resources' => 1,
                'score' => 1,
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-05-31 19:19:33',
                'modified' => '2026-05-31 19:19:33',
            ],
        ];
        parent::init();
    }
}
