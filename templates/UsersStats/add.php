<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UsersStat $usersStat
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Users Stats'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="usersStats form content">
            <?= $this->Form->create($usersStat) ?>
            <fieldset>
                <legend><?= __('Add Users Stat') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('total_score');
                    echo $this->Form->control('games_played');
                    echo $this->Form->control('games_won');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
