<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Parties Model
 *
 * @property \App\Model\Table\BriefingsTable&\Cake\ORM\Association\BelongsTo $Briefings
 * @property \App\Model\Table\RoomsTable&\Cake\ORM\Association\BelongsTo $Rooms
 * @property \App\Model\Table\PartyPlayersTable&\Cake\ORM\Association\HasMany $PartyPlayers
 * @property \App\Model\Table\PlayerDecisionsTable&\Cake\ORM\Association\HasMany $PlayerDecisions
 *
 * @method \App\Model\Entity\Party newEmptyEntity()
 * @method \App\Model\Entity\Party newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Party> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Party get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Party findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Party patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Party> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Party|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Party saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Party>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Party>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Party>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Party> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Party>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Party>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Party>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Party> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PartiesTable extends Table
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

        $this->setTable('parties');
        $this->setDisplayField('status');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Briefings', [
            'foreignKey' => 'briefing_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Rooms', [
            'foreignKey' => 'room_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('PartyPlayers', [
            'foreignKey' => 'party_id',
        ]);
        $this->hasMany('PlayerDecisions', [
            'foreignKey' => 'party_id',
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
            ->integer('briefing_id')
            ->allowEmptyString('briefing_id');

        $validator
            ->integer('room_id')
            ->notEmptyString('room_id');

        $validator
            ->scalar('status')
            ->maxLength('status', 30)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

       $validator
            ->integer('current_round')
            ->allowEmptyString('current_round');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add(
            $rules->existsIn(['briefing_id'], 'Briefings', ['allowNullableNulls' => true]),
            ['errorField' => 'briefing_id']
        );
        
        $rules->add($rules->existsIn(['room_id'], 'Rooms'), ['errorField' => 'room_id']);

        return $rules;
    }
}
