<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlayerDecisions Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\DecisionsTable&\Cake\ORM\Association\BelongsTo $Decisions
 * @property \App\Model\Table\PartiesTable&\Cake\ORM\Association\BelongsTo $Parties
 *
 * @method \App\Model\Entity\PlayerDecision newEmptyEntity()
 * @method \App\Model\Entity\PlayerDecision newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\PlayerDecision> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlayerDecision get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\PlayerDecision findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\PlayerDecision patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\PlayerDecision> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlayerDecision|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\PlayerDecision saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\PlayerDecision>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PlayerDecision>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PlayerDecision>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PlayerDecision> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PlayerDecision>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PlayerDecision>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PlayerDecision>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PlayerDecision> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PlayerDecisionsTable extends Table
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

        $this->setTable('player_decisions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Decisions', [
            'foreignKey' => 'decision_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Parties', [
            'foreignKey' => 'party_id',
            'joinType' => 'INNER',
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
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->integer('decision_id')
            ->notEmptyString('decision_id');

        $validator
            ->integer('party_id')
            ->notEmptyString('party_id');

        $validator
            ->integer('elapsed_time')
            ->requirePresence('elapsed_time', 'create')
            ->notEmptyString('elapsed_time');

        $validator
            ->integer('score')
            ->requirePresence('score', 'create')
            ->notEmptyString('score');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['decision_id'], 'Decisions'), ['errorField' => 'decision_id']);
        $rules->add($rules->existsIn(['party_id'], 'Parties'), ['errorField' => 'party_id']);

        return $rules;
    }
}
