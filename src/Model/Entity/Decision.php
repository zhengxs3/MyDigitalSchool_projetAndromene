<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Decision Entity
 *
 * @property int $id
 * @property int $briefing_id
 * @property string $content
 * @property int $resources_used
 * @property int $round_number
 * @property int $score
 * @property bool $is_correct
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Briefing $briefing
 * @property \App\Model\Entity\PlayerDecision[] $player_decisions
 */
class Decision extends Entity
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
        'content' => true,
        'resources_used' => true,
        'round_number' => true,
        'score' => true,
        'is_correct' => true,
        'created' => true,
        'modified' => true,
        'briefing' => true,
        'player_decisions' => true,
    ];
}
