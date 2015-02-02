<div class="users index">
	<h2><?php echo __('Users'); ?></h2>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo $this->Paginator->sort('username', 'Username'); ?></th>
			<th><?php echo $this->Paginator->sort('email', 'Email'); ?></th>
			<th><?php echo $this->Paginator->sort('role', 'Role'); ?></th>
			<th class="actions"></th>
		</tr>
		<?php foreach ($users as $user): ?>
		<tr>
			<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
			<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
			<td><?php echo h($user['User']['role']); ?>&nbsp;</td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id'])); ?>
				<?php if($current_user['id'] == $user['User']['id']): ?>
					<?php echo $this->Html->link(__('Update'), array('action' => 'edit', $user['User']['id'])); ?>
				<?php endif; ?>
				<?php if($user['User']['id'] != $current_user['id']): ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), null, __('You really want to delete the user: %s?', $user['User']['username'])); ?>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<p>
		<?php
			echo $this->Paginator->counter(array(
			'format' => __('Page {:page} of {:pages}.')
			));
		?>	
	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('Previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('Next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>


	<div class="button-add">
		<?php
			echo $this->Html->link(__('Add New User'), array('action' => 'add'));
		?>
	</div>

</div>

<?php include "../View/menu.php";?>