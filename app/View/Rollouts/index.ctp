<div class="rollouts index">
	<h2><?php echo __('Rollouts of the %s system (at sql change rev #%d)', $system['System']['name'], $system['System']['sql_change_id']); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('system_id'); ?></th>
			<th><?php echo __('Changes'); ?></th>
			<th><?php echo $this->Paginator->sort('rolled_out'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($rollouts as $rollout): ?>
	<tr>
		<td><?php echo h($rollout['Rollout']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($rollout['System']['name'], array('controller' => 'systems', 'action' => 'view', $rollout['System']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($rollout['StartChange']['id'], array('controller' => 'sql_changes', 'action' => 'view', $rollout['StartChange']['id'])); ?>
			&nbsp;&rarr;&nbsp;
			<?php echo $this->Html->link($rollout['EndChange']['id'], array('controller' => 'sql_changes', 'action' => 'view', $rollout['EndChange']['id'])); ?>
		</td>
		<td><?php if ($rollout['Rollout']['rolled_out']) echo $this->Html->image('test-pass-icon'); ?></td>
		<td><?php echo h($rollout['Rollout']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Apply'), array('action' => 'apply', $rollout['Rollout']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $rollout['Rollout']['id'])); ?>
			<?php echo $this->Form->postLink(__('Rolled out'), array('action' => 'rolled_out', $rollout['Rollout']['id']), null, __('Really rolled out?')); ?>
			<?php echo $this->Html->link(__('PHP code'), array('action' => 'php_sql', $rollout['Rollout']['id'])); ?>
			<?php echo $this->Html->link(__('SQL'), array('action' => 'sql', $rollout['Rollout']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $rollout['Rollout']['id']), null, __('Are you sure you want to delete # %s?', $rollout['Rollout']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New rollout'), array('action' => 'add', $system['System']['id'])); ?></li>
		<li><?php echo $this->Html->link(__('Other systems'), array('controller' => 'systems', 'action' => 'index', $system['Application']['id'])); ?> </li>
	</ul>
</div>
