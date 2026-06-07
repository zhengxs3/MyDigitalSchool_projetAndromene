<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Room> $rooms
 */
?>
<div class="rooms index content">
    <?= $this->Html->link(__('New Room'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Rooms') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('max_players') ?></th>
                    <th><?= $this->Paginator->sort('created_by') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rooms as $room): ?>
                <tr>
                    <td><?= $this->Number->format($room->id) ?></td>
                    <td><?= h($room->name) ?></td>
                    <td><?= h($room->code) ?></td>
                    <td><?= h($room->status) ?></td>
                    <td><?= $room->max_players === null ? '' : $this->Number->format($room->max_players) ?></td>
                    <td><?= $this->Number->format($room->created_by) ?></td>
                    <td><?= h($room->created) ?></td>
                    <td><?= h($room->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $room->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $room->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $room->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $room->id),
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