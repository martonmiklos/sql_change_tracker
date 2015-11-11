<div class="sqlChanges view">
<h2><?php echo __('Sql Change'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($sqlChange['SqlChange']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Change'); ?></dt>
		<dd>
			<?php echo h($sqlChange['SqlChange']['change']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comment'); ?></dt>
		<dd>
			<?php echo h($sqlChange['SqlChange']['comment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($sqlChange['SqlChange']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Sql Change'), array('action' => 'edit', $sqlChange['SqlChange']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Sql Change'), array('action' => 'delete', $sqlChange['SqlChange']['id']), null, __('Are you sure you want to delete # %s?', $sqlChange['SqlChange']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sql Changes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sql Change'), array('action' => 'add')); ?> </li>
	</ul>
</div>
