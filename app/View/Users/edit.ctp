<div class="users form">
	<h2>Update Account</h2>
	<div class="box-content">
		<?php echo $this->Form->create('User'); ?>
			<fieldset>
				<?php
					echo $this->Form->input('id');
					echo $this->Form->input('username', array('label' => 'Username'));
					echo $this->Form->input('password', array('label' => 'Password'));
					echo $this->Form->input('password_confirmation', array('type' =>'password', 'label' => 'Password Confirmation'));
					echo $this->Form->input('email', array('label' => 'Email'));
					echo $this->Form->input('role', array('options' => array('Webmaster' => 'Webmaster', 'Agent' => 'Agent')));
				?>
			</fieldset>
		<?php echo $this->Form->end(__('Update')); ?>   
	</div>
</div>

<?php include "../View/menu.php"; ?>