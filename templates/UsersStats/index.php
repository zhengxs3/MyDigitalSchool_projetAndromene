<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\UsersStat> $usersStats
 */
?>
<div class="usersStats index content">
    <?= $this->Html->link(__('New Users Stat'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Users Stats') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('total_score') ?></th>
                    <th><?= $this->Paginator->sort('games_played') ?></th>
                    <th><?= $this->Paginator->sort('games_won') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usersStats as $usersStat): ?>
                <tr>
                    <td><?= $this->Number->format($usersStat->id) ?></td>
                    <td><?= $usersStat->hasValue('user') ? $this->Html->link($usersStat->user->pseudo, ['controller' => 'Users', 'action' => 'view', $usersStat->user->id]) : '' ?></td>
                    <td><?= $this->Number->format($usersStat->total_score) ?></td>
                    <td><?= $this->Number->format($usersStat->games_played) ?></td>
                    <td><?= $this->Number->format($usersStat->games_won) ?></td>
                    <td><?= h($usersStat->created) ?></td>
                    <td><?= h($usersStat->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $usersStat->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $usersStat->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $usersStat->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $usersStat->id),
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