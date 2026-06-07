<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserSuperpower $userSuperpower
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User Superpower'), ['action' => 'edit', $userSuperpower->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User Superpower'), ['action' => 'delete', $userSuperpower->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userSuperpower->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List User Superpowers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User Superpower'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="userSuperpowers view content">
            <h3><?= h($userSuperpower->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $userSuperpower->hasValue('user') ? $this->Html->link($userSuperpower->user->pseudo, ['controller' => 'Users', 'action' => 'view', $userSuperpower->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Superpower') ?></th>
                    <td><?= $userSuperpower->hasValue('superpower') ? $this->Html->link($userSuperpower->superpower->name, ['controller' => 'Superpowers', 'action' => 'view', $userSuperpower->superpower->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($userSuperpower->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($userSuperpower->quantity) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>