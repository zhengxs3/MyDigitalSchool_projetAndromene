<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PlayerDecision Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $decision_id
 * @property int $party_id
 * @property int $elapsed_time
 * @property int $score
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Decision $decision
 * @property \App\Model\Entity\Party $party
 */
class PlayerDecision extends Entity
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
        'decision_id' => true,
        'party_id' => true,
        'elapsed_time' => true,
        'score' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'decision' => true,
        'party' => true,
    ];
}
