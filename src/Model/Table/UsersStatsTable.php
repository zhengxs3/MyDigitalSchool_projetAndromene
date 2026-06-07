<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UsersStats Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\UsersStat newEmptyEntity()
 * @method \App\Model\Entity\UsersStat newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\UsersStat> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UsersStat get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\UsersStat findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\UsersStat patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\UsersStat> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\UsersStat|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\UsersStat saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\UsersStat>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\UsersStat>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\UsersStat>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\UsersStat> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\UsersStat>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\UsersStat>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\UsersStat>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\UsersStat> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersStatsTable extends Table
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

        $this->setTable('users_stats');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->integer('total_score')
            ->requirePresence('total_score', 'create')
            ->notEmptyString('total_score');

        $validator
            ->integer('games_played')
            ->requirePresence('games_played', 'create')
            ->notEmptyString('games_played');

        $validator
            ->integer('games_won')
            ->requirePresence('games_won', 'create')
            ->notEmptyString('games_won');

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

        return $rules;
    }
}
