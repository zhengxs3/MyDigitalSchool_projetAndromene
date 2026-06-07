<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PartyPlayer $partyPlayer
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $parties
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $partyPlayer->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $partyPlayer->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Party Players'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="partyPlayers form content">
            <?= $this->Form->create($partyPlayer) ?>
            <fieldset>
                <legend><?= __('Edit Party Player') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('party_id', ['options' => $parties]);
                    echo $this->Form->control('role');
                    echo $this->Form->control('objective');
                    echo $this->Form->control('resources');
                    echo $this->Form->control('score');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
