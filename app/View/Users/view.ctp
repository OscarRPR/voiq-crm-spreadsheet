<div class="users view">
	<h2>Personal Information</h2>
		<div class="box-content">
			<p><?php echo __('Username'); ?>: <?php echo h($user['User']['username']); ?></p>
			<p><?php echo __('Email'); ?>: <?php echo h($user['User']['email']); ?></p>
			<p><?php echo __('Role'); ?>: <?php echo h($user['User']['role']); ?></p>
		</div>
</div>

<?php include "../View/menu.php"; ?>

