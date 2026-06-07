<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Room $room
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Room'), ['action' => 'edit', $room->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Room'), ['action' => 'delete', $room->id], ['confirm' => __('Are you sure you want to delete # {0}?', $room->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Rooms'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Room'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="rooms view content">
            <h3><?= h($room->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($room->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($room->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($room->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($room->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Max Players') ?></th>
                    <td><?= $room->max_players === null ? '' : $this->Number->format($room->max_players) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created By') ?></th>
                    <td><?= $this->Number->format($room->created_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($room->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($room->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Parties') ?></h4>
                <?php if (!empty($room->parties)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Briefing Id') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Current Round') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($room->parties as $party) : ?>
                        <tr>
                            <td><?= h($party->id) ?></td>
                            <td><?= h($party->briefing_id) ?></td>
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