<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Rooms Model
 *
 * @property \App\Model\Table\PartiesTable&\Cake\ORM\Association\HasMany $Parties
 *
 * @method \App\Model\Entity\Room newEmptyEntity()
 * @method \App\Model\Entity\Room newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Room> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Room get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Room findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Room patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Room> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Room|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Room saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Room>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Room>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Room>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Room> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Room>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Room>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Room>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Room> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RoomsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('rooms');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Parties', [
            'foreignKey' => 'room_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('code')
            ->maxLength('code', 20)
            ->requirePresence('code', 'create')
            ->notEmptyString('code');

        $validator
            ->scalar('status')
            ->maxLength('status', 30)
            ->allowEmptyString('status');

        $validator
            ->integer('max_players')
            ->allowEmptyString('max_players');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmptyString('created_by');

        return $validator;
    }
}
