<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PartyPlayers Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\PartiesTable&\Cake\ORM\Association\BelongsTo $Parties
 *
 * @method \App\Model\Entity\PartyPlayer newEmptyEntity()
 * @method \App\Model\Entity\PartyPlayer newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\PartyPlayer> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PartyPlayer get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\PartyPlayer findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\PartyPlayer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\PartyPlayer> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PartyPlayer|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\PartyPlayer saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\PartyPlayer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PartyPlayer>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PartyPlayer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PartyPlayer> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PartyPlayer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PartyPlayer>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PartyPlayer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PartyPlayer> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PartyPlayersTable extends Table
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

        $this->setTable('party_players');
        $this->setDisplayField('role');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->integer('party_id')
            ->notEmptyString('party_id');

        $validator
            ->scalar('role')
            ->maxLength('role', 50)
            ->requirePresence('role', 'create')
            ->notEmptyString('role');

        $validator
            ->scalar('objective')
            ->requirePresence('objective', 'create')
            ->notEmptyString('objective');

        $validator
            ->integer('resources')
            ->requirePresence('resources', 'create')
            ->notEmptyString('resources');

        $validator
            ->integer('score')
            ->requirePresence('score', 'create')
            ->notEmptyString('score');

        $validator
            ->scalar('status')
            ->maxLength('status', 30)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

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
        $rules->add($rules->existsIn(['party_id'], 'Parties'), ['errorField' => 'party_id']);

        return $rules;
    }
}
