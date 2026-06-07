<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UsersStat $usersStat
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Users Stat'), ['action' => 'edit', $usersStat->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Users Stat'), ['action' => 'delete', $usersStat->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usersStat->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users Stats'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Users Stat'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="usersStats view content">
            <h3><?= h($usersStat->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $usersStat->hasValue('user') ? $this->Html->link($usersStat->user->pseudo, ['controller' => 'Users', 'action' => 'view', $usersStat->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($usersStat->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Score') ?></th>
                    <td><?= $this->Number->format($usersStat->total_score) ?></td>
                </tr>
                <tr>
                    <th><?= __('Games Played') ?></th>
                    <td><?= $this->Number->format($usersStat->games_played) ?></td>
                </tr>
                <tr>
                    <th><?= __('Games Won') ?></th>
                    <td><?= $this->Number->format($usersStat->games_won) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($usersStat->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($usersStat->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>