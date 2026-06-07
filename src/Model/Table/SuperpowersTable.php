<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Superpowers Model
 *
 * @property \App\Model\Table\UserSuperpowersTable&\Cake\ORM\Association\HasMany $UserSuperpowers
 *
 * @method \App\Model\Entity\Superpower newEmptyEntity()
 * @method \App\Model\Entity\Superpower newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Superpower> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Superpower get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Superpower findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Superpower patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Superpower> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Superpower|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Superpower saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Superpower>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Superpower>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Superpower>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Superpower> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Superpower>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Superpower>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Superpower>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Superpower> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SuperpowersTable extends Table
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

        $this->setTable('superpowers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('UserSuperpowers', [
            'foreignKey' => 'superpower_id',
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
            ->scalar('icon_url')
            ->maxLength('icon_url', 255)
            ->requirePresence('icon_url', 'create')
            ->notEmptyString('icon_url');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        return $validator;
    }
}
