<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PlayerDecision $playerDecision
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Player Decision'), ['action' => 'edit', $playerDecision->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Player Decision'), ['action' => 'delete', $playerDecision->id], ['confirm' => __('Are you sure you want to delete # {0}?', $playerDecision->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Player Decisions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Player Decision'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="playerDecisions view content">
            <h3><?= h($playerDecision->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $playerDecision->hasValue('user') ? $this->Html->link($playerDecision->user->pseudo, ['controller' => 'Users', 'action' => 'view', $playerDecision->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Decision') ?></th>
                    <td><?= $playerDecision->hasValue('decision') ? $this->Html->link($playerDecision->decision->id, ['controller' => 'Decisions', 'action' => 'view', $playerDecision->decision->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Party') ?></th>
                    <td><?= $playerDecision->hasValue('party') ? $this->Html->link($playerDecision->party->status, ['controller' => 'Parties', 'action' => 'view', $playerDecision->party->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($playerDecision->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Elapsed Time') ?></th>
                    <td><?= $this->Number->format($playerDecision->elapsed_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('Score') ?></th>
                    <td><?= $this->Number->format($playerDecision->score) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($playerDecision->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($playerDecision->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>