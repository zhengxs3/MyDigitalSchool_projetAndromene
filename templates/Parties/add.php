<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Party $party
 * @var \Cake\Collection\CollectionInterface|string[] $briefings
 * @var \Cake\Collection\CollectionInterface|string[] $rooms
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Parties'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="parties form content">
            <?= $this->Form->create($party) ?>
            <fieldset>
                <legend><?= __('Add Party') ?></legend>
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
