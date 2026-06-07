<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Superpower $superpower
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $superpower->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $superpower->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Superpowers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="superpowers form content">
            <?= $this->Form->create($superpower) ?>
            <fieldset>
                <legend><?= __('Edit Superpower') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('icon_url');
                    echo $this->Form->control('description');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
