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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $briefing->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $briefing->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Briefings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="briefings form content">
            <?= $this->Form->create($briefing) ?>
            <fieldset>
                <legend><?= __('Edit Briefing') ?></legend>
                <?php
                    echo $this->Form->control('title');
                    echo $this->Form->control('content');
                    echo $this->Form->control('objective');
                    echo $this->Form->control('time_limit');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
