<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Decision $decision
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Decision'), ['action' => 'edit', $decision->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Decision'), ['action' => 'delete', $decision->id], ['confirm' => __('Are you sure you want to delete # {0}?', $decision->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Decisions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Decision'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="decisions view content">
            <h3><?= h($decision->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Briefing') ?></th>
                    <td><?= $decision->hasValue('briefing') ? $this->Html->link($decision->briefing->title, ['controller' => 'Briefings', 'action' => 'view', $decision->briefing->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($decision->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Resources Used') ?></th>
                    <td><?= $this->Number->format($decision->resources_used) ?></td>
                </tr>
                <tr>
                    <th><?= __('Round Number') ?></th>
                    <td><?= $this->Number->format($decision->round_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Score') ?></th>
                    <td><?= $this->Number->format($decision->score) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($decision->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($decision->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Correct') ?></th>
                    <td><?= $decision->is_correct ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Content') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($decision->content)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Player Decisions') ?></h4>
                <?php if (!empty($decision->player_decisions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Party Id') ?></th>
                            <th><?= __('Elapsed Time') ?></th>
                            <th><?= __('Score') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($decision->player_decisions as $playerDecision) : ?>
                        <tr>
                            <td><?= h($playerDecision->id) ?></td>
                            <td><?= h($playerDecision->user_id) ?></td>
                            <td><?= h($playerDecision->party_id) ?></td>
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