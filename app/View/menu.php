<div class="span2 main-menu-span">
	<div class="well nav-collapse sidebar-nav">
	<h3><?php echo __('Menu'); ?></h3>
		<ul class="nav nav-tabs nav-stacked main-menu">
			<li><?php echo $this->Html->link(__('My Account'), array('controller' => 'users', 'action' => 'view', $current_user['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('Search CRM Customers'), array('controller' => 'customers', 'action' => 'search')); ?> </li>
			<li><?php echo $this->Html->link(__('Upload Spreadsheet'), array('controller' => 'files', 'action' => 'upload')); ?> </li>
			<?php if($current_user['role'] == 'Webmaster'): ?>
				<li><?php echo $this->Html->link(__('Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
			<?php endif; ?>	
		</ul>
	</div>
</div>