<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Briefing Entity
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $objective
 * @property int $time_limit
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Decision[] $decisions
 * @property \App\Model\Entity\Party[] $parties
 */
class Briefing extends Entity
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
        'title' => true,
        'content' => true,
        'objective' => true,
        'time_limit' => true,
        'created' => true,
        'modified' => true,
        'decisions' => true,
        'parties' => true,
    ];
}
