<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Party Entity
 *
 * @property int $id
 * @property int $briefing_id
 * @property int $room_id
 * @property string $status
 * @property int $current_round
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Briefing $briefing
 * @property \App\Model\Entity\Room $room
 * @property \App\Model\Entity\PartyPlayer[] $party_players
 * @property \App\Model\Entity\PlayerDecision[] $player_decisions
 */
class Party extends Entity
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
        'briefing_id' => true,
        'room_id' => true,
        'status' => true,
        'current_round' => true,
        'created' => true,
        'modified' => true,
        'briefing' => true,
        'room' => true,
        'party_players' => true,
        'player_decisions' => true,
    ];
}
