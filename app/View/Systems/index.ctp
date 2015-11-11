<div class="systems index">
	<h2><?php echo __('Systems of the %s application', $application['Application']['name']); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('database'); ?></th>
			<th><?php echo $this->Paginator->sort('sql_change_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($systems as $system): ?>
	<tr>
		<td><?php echo h($system['System']['id']); ?>&nbsp;</td>
		<td><?php echo h($system['System']['name']); ?>&nbsp;</td>
		<td><?php echo h($system['System']['remote_database']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($system['SqlChange']['id'], array('controller' => 'sql_changes', 'action' => 'view', $system['SqlChange']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Rollouts'), array('controller' => 'rollouts', 'action' => 'index', $system['System']['id'])); ?>
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $system['System']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $system['System']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $system['System']['id']), null, __('Are you sure you want to delete # %s?', $system['System']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New System'), array('action' => 'add', $application_id)); ?></li>
		<li><?php echo $this->Html->link(__('List Sql Changes'), array('controller' => 'sql_changes', 'action' => 'index', $application_id)); ?> </li>
		<li><?php echo $this->Html->link(__('New Application'), array('controller' => 'applications', 'action' => 'add')); ?> </li>
	</ul>
</div>
