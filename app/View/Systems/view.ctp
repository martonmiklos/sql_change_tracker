<div class="systems view">
<h2><?php echo __('System'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($system['System']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($system['System']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Database name'); ?></dt>
		<dd>
			<?php echo h($system['System']['database']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last rolled out sql Change'); ?></dt>
		<dd>
			<?php echo $this->Html->link($system['SqlChange']['id'], array('controller' => 'sql_changes', 'action' => 'view', $system['SqlChange']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Application'); ?></dt>
		<dd>
			<?php echo $this->Html->link($system['Application']['name'], array('controller' => 'applications', 'action' => 'view', $system['Application']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit System'), array('action' => 'edit', $system['System']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete System'), array('action' => 'delete', $system['System']['id']), null, __('Are you sure you want to delete # %s?', $system['System']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Systems'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New System'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sql Changes'), array('controller' => 'sql_changes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sql Change'), array('controller' => 'sql_changes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Applications'), array('controller' => 'applications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Application'), array('controller' => 'applications', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Rollouts'), array('controller' => 'rollouts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Rollout'), array('controller' => 'rollouts', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Rollouts'); ?></h3>
	<?php if (!empty($system['Rollout'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('System Id'); ?></th>
		<th><?php echo __('Start Change Id'); ?></th>
		<th><?php echo __('End Change Id'); ?></th>
		<th><?php echo __('Rolled Out'); ?></th>
		<th><?php echo __('Date'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($system['Rollout'] as $rollout): ?>
		<tr>
			<td><?php echo $rollout['id']; ?></td>
			<td><?php echo $rollout['system_id']; ?></td>
			<td><?php echo $rollout['start_change_id']; ?></td>
			<td><?php echo $rollout['end_change_id']; ?></td>
			<td><?php echo $rollout['rolled_out']; ?></td>
			<td><?php echo $rollout['date']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'rollouts', 'action' => 'view', $rollout['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'rollouts', 'action' => 'edit', $rollout['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'rollouts', 'action' => 'delete', $rollout['id']), null, __('Are you sure you want to delete # %s?', $rollout['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Rollout'), array('controller' => 'rollouts', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
