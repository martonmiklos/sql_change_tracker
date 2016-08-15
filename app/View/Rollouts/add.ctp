<div class="rollouts form">
<?php echo $this->Form->create('Rollout'); ?>
	<fieldset>
		<legend><?php echo __('Add new rollout to the %s system', $system['System']['name']); ?></legend>
	<?php
		$lastOptions = array();
		$endChangesKeys = array_keys($endChanges);
		if (count($endChangesKeys)) {
			$lastOptions = array('selected' => $endChangesKeys[count($endChangesKeys) - 1]);
		}
		
		echo $this->Form->input('start_change_id');
		echo $this->Form->input('end_change_id', $lastOptions);
		echo $this->Form->input('rolled_out');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Rollouts'), array('action' => 'index', $system['System']['application_id'])); ?></li>
		<li><?php echo $this->Html->link(__('List Systems'), array('controller' => 'systems', 'action' => 'index', $system['System']['application_id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sql Changes'), array('controller' => 'sql_changes', 'action' => 'index', $system['System']['application_id'])); ?> </li>
		<li><?php echo $this->Html->link(__('New SQL Change'), array('controller' => 'sql_changes', 'action' => 'add', $system['System']['application_id'])); ?> </li>
	</ul>
</div>
