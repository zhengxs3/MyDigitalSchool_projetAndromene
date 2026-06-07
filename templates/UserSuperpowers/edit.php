<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserSuperpower $userSuperpower
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $superpowers
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $userSuperpower->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $userSuperpower->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List User Superpowers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="userSuperpowers form content">
            <?= $this->Form->create($userSuperpower) ?>
            <fieldset>
                <legend><?= __('Edit User Superpower') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('superpower_id', ['options' => $superpowers]);
                    echo $this->Form->control('quantity');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
