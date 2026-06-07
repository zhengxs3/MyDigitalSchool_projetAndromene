<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Room Entity
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $status
 * @property int|null $max_players
 * @property int $created_by
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Party[] $parties
 */
class Room extends Entity
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
        'name' => true,
        'code' => true,
        'status' => true,
        'max_players' => true,
        'created_by' => true,
        'parties' => true,
    ];
}
