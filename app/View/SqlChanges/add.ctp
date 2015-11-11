<div class="sqlChanges form">
<?php echo $this->Form->create('SqlChange'); ?>
	<fieldset>
		<legend><?php echo __('Add Sql Change'); ?></legend>
	<?php
		echo $this->Form->input('change');
		echo $this->Form->input('comment');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Sql Changes'), array('action' => 'index')); ?></li>
	</ul>
</div>
