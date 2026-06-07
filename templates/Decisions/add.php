<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Decision $decision
 * @var \Cake\Collection\CollectionInterface|string[] $briefings
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Decisions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="decisions form content">
            <?= $this->Form->create($decision) ?>
            <fieldset>
                <legend><?= __('Add Decision') ?></legend>
                <?php
                    echo $this->Form->control('briefing_id', ['options' => $briefings]);
                    echo $this->Form->control('content');
                    echo $this->Form->control('resources_used');
                    echo $this->Form->control('round_number');
                    echo $this->Form->control('score');
                    echo $this->Form->control('is_correct');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
