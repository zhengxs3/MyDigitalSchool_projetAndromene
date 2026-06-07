<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Briefings Model
 *
 * @property \App\Model\Table\DecisionsTable&\Cake\ORM\Association\HasMany $Decisions
 * @property \App\Model\Table\PartiesTable&\Cake\ORM\Association\HasMany $Parties
 *
 * @method \App\Model\Entity\Briefing newEmptyEntity()
 * @method \App\Model\Entity\Briefing newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Briefing> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Briefing get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Briefing findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Briefing patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Briefing> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Briefing|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Briefing saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Briefing>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Briefing>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Briefing>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Briefing> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Briefing>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Briefing>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Briefing>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Briefing> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BriefingsTable extends Table
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

        $this->setTable('briefings');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Decisions', [
            'foreignKey' => 'briefing_id',
        ]);
        $this->hasMany('Parties', [
            'foreignKey' => 'briefing_id',
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
            ->scalar('title')
            ->maxLength('title', 100)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('content')
            ->requirePresence('content', 'create')
            ->notEmptyString('content');

        $validator
            ->scalar('objective')
            ->requirePresence('objective', 'create')
            ->notEmptyString('objective');

        $validator
            ->integer('time_limit')
            ->requirePresence('time_limit', 'create')
            ->notEmptyString('time_limit');

        return $validator;
    }
}
