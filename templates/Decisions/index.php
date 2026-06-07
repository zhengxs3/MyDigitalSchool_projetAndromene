<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Decision> $decisions
 */
?>
<div class="decisions index content">
    <?= $this->Html->link(__('New Decision'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Decisions') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('briefing_id') ?></th>
                    <th><?= $this->Paginator->sort('resources_used') ?></th>
                    <th><?= $this->Paginator->sort('round_number') ?></th>
                    <th><?= $this->Paginator->sort('score') ?></th>
                    <th><?= $this->Paginator->sort('is_correct') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($decisions as $decision): ?>
                <tr>
                    <td><?= $this->Number->format($decision->id) ?></td>
                    <td><?= $decision->hasValue('briefing') ? $this->Html->link($decision->briefing->title, ['controller' => 'Briefings', 'action' => 'view', $decision->briefing->id]) : '' ?></td>
                    <td><?= $this->Number->format($decision->resources_used) ?></td>
                    <td><?= $this->Number->format($decision->round_number) ?></td>
                    <td><?= $this->Number->format($decision->score) ?></td>
                    <td><?= h($decision->is_correct) ?></td>
                    <td><?= h($decision->created) ?></td>
                    <td><?= h($decision->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $decision->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $decision->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $decision->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $decision->id),
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