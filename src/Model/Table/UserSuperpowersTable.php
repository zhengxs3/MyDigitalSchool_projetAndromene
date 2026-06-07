<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserSuperpowers Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\SuperpowersTable&\Cake\ORM\Association\BelongsTo $Superpowers
 *
 * @method \App\Model\Entity\UserSuperpower newEmptyEntity()
 * @method \App\Model\Entity\UserSuperpower newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\UserSuperpower> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserSuperpower get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\UserSuperpower findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\UserSuperpower patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\UserSuperpower> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserSuperpower|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\UserSuperpower saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\UserSuperpower>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\UserSuperpower>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\UserSuperpower>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\UserSuperpower> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\UserSuperpower>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\UserSuperpower>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\UserSuperpower>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\UserSuperpower> deleteManyOrFail(iterable $entities, array $options = [])
 */
class UserSuperpowersTable extends Table
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

        $this->setTable('user_superpowers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Superpowers', [
            'foreignKey' => 'superpower_id',
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
            ->integer('superpower_id')
            ->notEmptyString('superpower_id');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmptyString('quantity');

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
        $rules->add($rules->existsIn(['superpower_id'], 'Superpowers'), ['errorField' => 'superpower_id']);

        return $rules;
    }
}
