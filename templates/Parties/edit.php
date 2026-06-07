<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Party $party
 * @var string[]|\Cake\Collection\CollectionInterface $briefings
 * @var string[]|\Cake\Collection\CollectionInterface $rooms
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $party->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $party->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Parties'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="parties form content">
            <?= $this->Form->create($party) ?>
            <fieldset>
                <legend><?= __('Edit Party') ?></legend>
                <?php
                    echo $this->Form->control('briefing_id', ['options' => $briefings]);
                    echo $this->Form->control('room_id', ['options' => $rooms]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('current_round');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
