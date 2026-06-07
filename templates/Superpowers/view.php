<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Superpower $superpower
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Superpower'), ['action' => 'edit', $superpower->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Superpower'), ['action' => 'delete', $superpower->id], ['confirm' => __('Are you sure you want to delete # {0}?', $superpower->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Superpowers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Superpower'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="superpowers view content">
            <h3><?= h($superpower->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($superpower->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Icon Url') ?></th>
                    <td><?= h($superpower->icon_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($superpower->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($superpower->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($superpower->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($superpower->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related User Superpowers') ?></h4>
                <?php if (!empty($superpower->user_superpowers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($superpower->user_superpowers as $userSuperpower) : ?>
                        <tr>
                            <td><?= h($userSuperpower->id) ?></td>
                            <td><?= h($userSuperpower->user_id) ?></td>
                            <td><?= h($userSuperpower->quantity) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'UserSuperpowers', 'action' => 'view', $userSuperpower->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'UserSuperpowers', 'action' => 'edit', $userSuperpower->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'UserSuperpowers', 'action' => 'delete', $userSuperpower->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $userSuperpower->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>