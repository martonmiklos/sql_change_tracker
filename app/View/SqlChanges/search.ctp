<div class="sqlChanges form">
<?php echo $this->Form->create('Search'); ?>
	<fieldset>
		<legend><?php echo __('Find Sql Change'); ?></legend>
	<?php
		echo $this->Form->input('term');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Search')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Sql Changes'), array('action' => 'index', $application_id)); ?></li>
	</ul>
</div>
