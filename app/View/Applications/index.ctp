<div class="applications index">
	<h2><?php echo __('Applications'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('master_database'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($applications as $application): ?>
	<tr>
		<td><?php echo h($application['Application']['id']); ?>&nbsp;</td>
		<td><?php echo h($application['Application']['name']); ?>&nbsp;</td>
		<td><?php echo h($application['Application']['master_database']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Changes'), array('controller' => 'sql_changes', 'action' => 'index', $application['Application']['id'])); ?>
			<?php echo $this->Html->link(__('Systems'), array('controller' => 'systems', 'action' => 'index', $application['Application']['id'])); ?>
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $application['Application']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $application['Application']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $application['Application']['id']), null, __('Are you sure you want to delete # %s?', $application['Application']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Application'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Systems'), array('controller' => 'systems', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New System'), array('controller' => 'systems', 'action' => 'add')); ?> </li>
	</ul>
</div>
