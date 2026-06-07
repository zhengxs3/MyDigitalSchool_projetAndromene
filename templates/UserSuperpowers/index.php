<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\UserSuperpower> $userSuperpowers
 */
?>
<div class="userSuperpowers index content">
    <?= $this->Html->link(__('New User Superpower'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('User Superpowers') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('superpower_id') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userSuperpowers as $userSuperpower): ?>
                <tr>
                    <td><?= $this->Number->format($userSuperpower->id) ?></td>
                    <td><?= $userSuperpower->hasValue('user') ? $this->Html->link($userSuperpower->user->pseudo, ['controller' => 'Users', 'action' => 'view', $userSuperpower->user->id]) : '' ?></td>
                    <td><?= $userSuperpower->hasValue('superpower') ? $this->Html->link($userSuperpower->superpower->name, ['controller' => 'Superpowers', 'action' => 'view', $userSuperpower->superpower->id]) : '' ?></td>
                    <td><?= $this->Number->format($userSuperpower->quantity) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $userSuperpower->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $userSuperpower->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $userSuperpower->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $userSuperpower->id),
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