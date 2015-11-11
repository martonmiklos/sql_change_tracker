<div class="systems form">
<?php echo $this->Form->create('System'); ?>
	<fieldset>
		<legend><?php echo __('Add System'); ?></legend>
	<?php
		echo $this->Form->input('name', array('type' => 'string'));
		echo $this->Form->input('sql_change_id');
		echo $this->Form->input('remote_database_host');
		echo $this->Form->input('remote_database');
		echo $this->Form->input('remote_database_user');
		echo $this->Form->input('remote_database_password', array('type' => 'password'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Systems'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Sql Changes'), array('controller' => 'sql_changes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sql Change'), array('controller' => 'sql_changes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Applications'), array('controller' => 'applications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Application'), array('controller' => 'applications', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Rollouts'), array('controller' => 'rollouts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Rollout'), array('controller' => 'rollouts', 'action' => 'add')); ?> </li>
	</ul>
</div>
