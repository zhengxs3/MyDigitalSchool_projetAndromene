<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\PartyPlayer> $partyPlayers
 */
?>
<div class="partyPlayers index content">
    <?= $this->Html->link(__('New Party Player'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Party Players') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('party_id') ?></th>
                    <th><?= $this->Paginator->sort('role') ?></th>
                    <th><?= $this->Paginator->sort('resources') ?></th>
                    <th><?= $this->Paginator->sort('score') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($partyPlayers as $partyPlayer): ?>
                <tr>
                    <td><?= $this->Number->format($partyPlayer->id) ?></td>
                    <td><?= $partyPlayer->hasValue('user') ? $this->Html->link($partyPlayer->user->pseudo, ['controller' => 'Users', 'action' => 'view', $partyPlayer->user->id]) : '' ?></td>
                    <td><?= $partyPlayer->hasValue('party') ? $this->Html->link($partyPlayer->party->status, ['controller' => 'Parties', 'action' => 'view', $partyPlayer->party->id]) : '' ?></td>
                    <td><?= h($partyPlayer->role) ?></td>
                    <td><?= $this->Number->format($partyPlayer->resources) ?></td>
                    <td><?= $this->Number->format($partyPlayer->score) ?></td>
                    <td><?= h($partyPlayer->status) ?></td>
                    <td><?= h($partyPlayer->created) ?></td>
                    <td><?= h($partyPlayer->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $partyPlayer->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $partyPlayer->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $partyPlayer->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $partyPlayer->id),
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