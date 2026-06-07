<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PartyPlayer $partyPlayer
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Party Player'), ['action' => 'edit', $partyPlayer->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Party Player'), ['action' => 'delete', $partyPlayer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $partyPlayer->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Party Players'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Party Player'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="partyPlayers view content">
            <h3><?= h($partyPlayer->role) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $partyPlayer->hasValue('user') ? $this->Html->link($partyPlayer->user->pseudo, ['controller' => 'Users', 'action' => 'view', $partyPlayer->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Party') ?></th>
                    <td><?= $partyPlayer->hasValue('party') ? $this->Html->link($partyPlayer->party->status, ['controller' => 'Parties', 'action' => 'view', $partyPlayer->party->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= h($partyPlayer->role) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($partyPlayer->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($partyPlayer->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Resources') ?></th>
                    <td><?= $this->Number->format($partyPlayer->resources) ?></td>
                </tr>
                <tr>
                    <th><?= __('Score') ?></th>
                    <td><?= $this->Number->format($partyPlayer->score) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($partyPlayer->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($partyPlayer->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Objective') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($partyPlayer->objective)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>