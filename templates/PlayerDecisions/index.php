<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\PlayerDecision> $playerDecisions
 */
?>
<div class="playerDecisions index content">
    <?= $this->Html->link(__('New Player Decision'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Player Decisions') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('decision_id') ?></th>
                    <th><?= $this->Paginator->sort('party_id') ?></th>
                    <th><?= $this->Paginator->sort('elapsed_time') ?></th>
                    <th><?= $this->Paginator->sort('score') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($playerDecisions as $playerDecision): ?>
                <tr>
                    <td><?= $this->Number->format($playerDecision->id) ?></td>
                    <td><?= $playerDecision->hasValue('user') ? $this->Html->link($playerDecision->user->pseudo, ['controller' => 'Users', 'action' => 'view', $playerDecision->user->id]) : '' ?></td>
                    <td><?= $playerDecision->hasValue('decision') ? $this->Html->link($playerDecision->decision->id, ['controller' => 'Decisions', 'action' => 'view', $playerDecision->decision->id]) : '' ?></td>
                    <td><?= $playerDecision->hasValue('party') ? $this->Html->link($playerDecision->party->status, ['controller' => 'Parties', 'action' => 'view', $playerDecision->party->id]) : '' ?></td>
                    <td><?= $this->Number->format($playerDecision->elapsed_time) ?></td>
                    <td><?= $this->Number->format($playerDecision->score) ?></td>
                    <td><?= h($playerDecision->created) ?></td>
                    <td><?= h($playerDecision->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $playerDecision->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $playerDecision->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $playerDecision->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $playerDecision->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>