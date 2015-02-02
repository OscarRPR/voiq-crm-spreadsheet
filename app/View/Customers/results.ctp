<div class="customer index">
	<h2>Results</h2>

	<div class="submit">
		<input type='submit' onclick="location.href='/voiq/customers/search'" value='Go back to Search' />
	</div>

		<table cellpadding="0" cellspacing="0">
			<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('first_name', 'First Name'); ?></th>
				<th><?php echo $this->Paginator->sort('last_name', 'Last Name'); ?></th>
				<th><?php echo $this->Paginator->sort('username', 'User Upload'); ?></th>
				<th class="actions"></th>
			</tr>
			<?php foreach ($customers as $customer): ?>
			<tr>
				<td><?php echo h($customer['Customer']['id']); ?>&nbsp;</td>
				<td><?php echo h($customer['Customer']['first_name']); ?>&nbsp;</td>
				<td><?php echo h($customer['Customer']['last_name']); ?></td>
				<td><?php echo h($customer['User']['username']); ?></td>
				<td class="actions"></td>
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
</div>

<?php include "../View/menu.php"; ?>