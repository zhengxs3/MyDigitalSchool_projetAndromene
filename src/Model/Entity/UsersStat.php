<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsersStat Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $total_score
 * @property int $games_played
 * @property int $games_won
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\User $user
 */
class UsersStat extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'user_id' => true,
        'total_score' => true,
        'games_played' => true,
        'games_won' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
    ];
}
