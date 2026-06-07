<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Decisions Model
 *
 * @property \App\Model\Table\BriefingsTable&\Cake\ORM\Association\BelongsTo $Briefings
 * @property \App\Model\Table\PlayerDecisionsTable&\Cake\ORM\Association\HasMany $PlayerDecisions
 *
 * @method \App\Model\Entity\Decision newEmptyEntity()
 * @method \App\Model\Entity\Decision newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Decision> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Decision get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Decision findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Decision patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Decision> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Decision|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Decision saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Decision>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Decision>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Decision>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Decision> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Decision>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Decision>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Decision>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Decision> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DecisionsTable extends Table
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

        $this->setTable('decisions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Briefings', [
            'foreignKey' => 'briefing_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('PlayerDecisions', [
            'foreignKey' => 'decision_id',
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
            ->notEmptyString('briefing_id');

        $validator
            ->scalar('content')
            ->requirePresence('content', 'create')
            ->notEmptyString('content');

        $validator
            ->integer('resources_used')
            ->requirePresence('resources_used', 'create')
            ->notEmptyString('resources_used');

        $validator
            ->integer('round_number')
            ->requirePresence('round_number', 'create')
            ->notEmptyString('round_number');

        $validator
            ->integer('score')
            ->requirePresence('score', 'create')
            ->notEmptyString('score');

        $validator
            ->boolean('is_correct')
            ->requirePresence('is_correct', 'create')
            ->notEmptyString('is_correct');

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
        $rules->add($rules->existsIn(['briefing_id'], 'Briefings'), ['errorField' => 'briefing_id']);

        return $rules;
    }
}
