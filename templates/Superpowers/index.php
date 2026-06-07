<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Superpower> $superpowers
 */
?>
<div class="superpowers index content">
    <?= $this->Html->link(__('New Superpower'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Superpowers') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('icon_url') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($superpowers as $superpower): ?>
                <tr>
                    <td><?= $this->Number->format($superpower->id) ?></td>
                    <td><?= h($superpower->name) ?></td>
                    <td><?= h($superpower->icon_url) ?></td>
                    <td><?= h($superpower->created) ?></td>
                    <td><?= h($superpower->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $superpower->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $superpower->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $superpower->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $superpower->id),
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