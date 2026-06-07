<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PlayerDecision $playerDecision
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $decisions
 * @var string[]|\Cake\Collection\CollectionInterface $parties
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $playerDecision->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $playerDecision->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Player Decisions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="playerDecisions form content">
            <?= $this->Form->create($playerDecision) ?>
            <fieldset>
                <legend><?= __('Edit Player Decision') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('decision_id', ['options' => $decisions]);
                    echo $this->Form->control('party_id', ['options' => $parties]);
                    echo $this->Form->control('elapsed_time');
                    echo $this->Form->control('score');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
