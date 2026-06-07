<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Party> $parties
 */
?>
<div class="parties index content">
    <?= $this->Html->link(__('New Party'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Parties') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('briefing_id') ?></th>
                    <th><?= $this->Paginator->sort('room_id') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('current_round') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($parties as $party): ?>
                <tr>
                    <td><?= $this->Number->format($party->id) ?></td>
                    <td><?= $party->hasValue('briefing') ? $this->Html->link($party->briefing->title, ['controller' => 'Briefings', 'action' => 'view', $party->briefing->id]) : '' ?></td>
                    <td><?= $party->hasValue('room') ? $this->Html->link($party->room->name, ['controller' => 'Rooms', 'action' => 'view', $party->room->id]) : '' ?></td>
                    <td><?= h($party->status) ?></td>
                    <td><?= $this->Number->format($party->current_round) ?></td>
                    <td><?= h($party->created) ?></td>
                    <td><?= h($party->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $party->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $party->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $party->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $party->id),
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