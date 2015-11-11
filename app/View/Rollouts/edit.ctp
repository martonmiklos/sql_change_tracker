<div class="rollouts form">
<?php echo $this->Form->create('Rollout'); ?>
	<fieldset>
		<legend><?php echo __('Edit Rollout'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('system_id');
		echo $this->Form->input('start_change_id', array('selected' => $rollOut['Rollout']['start_change_id'], 'type' => 'select', 'options' => $startChanges));
		echo $this->Form->input('end_change_id', array('value' => $rollOut['Rollout']['end_change_id']));
		echo $this->Form->input('rolled_out');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Rollout.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Rollout.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Rollouts'), array('action' => 'index', $rollOut['System']['application_id'])); ?></li>
		<li><?php echo $this->Html->link(__('List Systems'), array('controller' => 'systems', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sql Changes'), array('controller' => 'sql_changes', 'action' => 'index', $rollOut['System']['application_id'])); ?> </li>
		<li><?php echo $this->Html->link(__('New Sql Change'), array('controller' => 'sql_changes', 'action' => 'add', $rollOut['System']['application_id'])); ?> </li>
	</ul>
</div>
