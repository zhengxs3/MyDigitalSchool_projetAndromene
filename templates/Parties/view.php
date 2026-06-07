<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Party $party
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Party'), ['action' => 'edit', $party->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Party'), ['action' => 'delete', $party->id], ['confirm' => __('Are you sure you want to delete # {0}?', $party->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Parties'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Party'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="parties view content">
            <h3><?= h($party->status) ?></h3>
            <table>
                <tr>
                    <th><?= __('Briefing') ?></th>
                    <td><?= $party->hasValue('briefing') ? $this->Html->link($party->briefing->title, ['controller' => 'Briefings', 'action' => 'view', $party->briefing->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Room') ?></th>
                    <td><?= $party->hasValue('room') ? $this->Html->link($party->room->name, ['controller' => 'Rooms', 'action' => 'view', $party->room->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($party->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($party->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Current Round') ?></th>
                    <td><?= $this->Number->format($party->current_round) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($party->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($party->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Party Players') ?></h4>
                <?php if (!empty($party->party_players)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Role') ?></th>
                            <th><?= __('Objective') ?></th>
                            <th><?= __('Resources') ?></th>
                            <th><?= __('Score') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($party->party_players as $partyPlayer) : ?>
                        <tr>
                            <td><?= h($partyPlayer->id) ?></td>
                            <td><?= h($partyPlayer->user_id) ?></td>
                            <td><?= h($partyPlayer->role) ?></td>
                            <td><?= h($partyPlayer->objective) ?></td>
                            <td><?= h($partyPlayer->resources) ?></td>
                            <td><?= h($partyPlayer->score) ?></td>
                            <td><?= h($partyPlayer->status) ?></td>
                            <td><?= h($partyPlayer->created) ?></td>
                            <td><?= h($partyPlayer->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PartyPlayers', 'action' => 'view', $partyPlayer->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PartyPlayers', 'action' => 'edit', $partyPlayer->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'PartyPlayers', 'action' => 'delete', $partyPlayer->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $partyPlayer->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Player Decisions') ?></h4>
                <?php if (!empty($party->player_decisions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Decision Id') ?></th>
                            <th><?= __('Elapsed Time') ?></th>
                            <th><?= __('Score') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($party->player_decisions as $playerDecision) : ?>
                        <tr>
                            <td><?= h($playerDecision->id) ?></td>
                            <td><?= h($playerDecision->user_id) ?></td>
                            <td><?= h($playerDecision->decision_id) ?></td>
                            <td><?= h($playerDecision->elapsed_time) ?></td>
                            <td><?= h($playerDecision->score) ?></td>
                            <td><?= h($playerDecision->created) ?></td>
                            <td><?= h($playerDecision->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PlayerDecisions', 'action' => 'view', $playerDecision->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PlayerDecisions', 'action' => 'edit', $playerDecision->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'PlayerDecisions', 'action' => 'delete', $playerDecision->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $playerDecision->id),
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