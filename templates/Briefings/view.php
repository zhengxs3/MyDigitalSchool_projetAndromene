<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Briefing $briefing
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Briefing'), ['action' => 'edit', $briefing->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Briefing'), ['action' => 'delete', $briefing->id], ['confirm' => __('Are you sure you want to delete # {0}?', $briefing->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Briefings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Briefing'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="briefings view content">
            <h3><?= h($briefing->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($briefing->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($briefing->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Time Limit') ?></th>
                    <td><?= $this->Number->format($briefing->time_limit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($briefing->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($briefing->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Content') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($briefing->content)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Objective') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($briefing->objective)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Decisions') ?></h4>
                <?php if (!empty($briefing->decisions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Content') ?></th>
                            <th><?= __('Resources Used') ?></th>
                            <th><?= __('Round Number') ?></th>
                            <th><?= __('Score') ?></th>
                            <th><?= __('Is Correct') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($briefing->decisions as $decision) : ?>
                        <tr>
                            <td><?= h($decision->id) ?></td>
                            <td><?= h($decision->content) ?></td>
                            <td><?= h($decision->resources_used) ?></td>
                            <td><?= h($decision->round_number) ?></td>
                            <td><?= h($decision->score) ?></td>
                            <td><?= h($decision->is_correct) ?></td>
                            <td><?= h($decision->created) ?></td>
                            <td><?= h($decision->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Decisions', 'action' => 'view', $decision->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Decisions', 'action' => 'edit', $decision->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Decisions', 'action' => 'delete', $decision->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $decision->id),
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
                <h4><?= __('Related Parties') ?></h4>
                <?php if (!empty($briefing->parties)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Room Id') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Current Round') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($briefing->parties as $party) : ?>
                        <tr>
                            <td><?= h($party->id) ?></td>
                            <td><?= h($party->room_id) ?></td>
                            <td><?= h($party->status) ?></td>
                            <td><?= h($party->current_round) ?></td>
                            <td><?= h($party->created) ?></td>
                            <td><?= h($party->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Parties', 'action' => 'view', $party->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Parties', 'action' => 'edit', $party->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Parties', 'action' => 'delete', $party->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $party->id),
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