<?php 
	echo $this->Html->css('jquery-ui-1.8.21.custom');
	echo $this->Html->script('jquery-1.7.2.min');
	echo $this->Html->script('jquery-ui-1.8.21.custom.min');
?>

<div id="container">
	<div class="customer form">
	<h2>Search</h2>
	<div class="box-content">
		<?php echo $this->Form->create('Search'); ?>
			<fieldset>
				<?php
				echo $this->Form->input('username', array('label' => 'Username', 'type' => 'text'));
				echo $this->Form->input('first_name', array('label' => 'First Name Contact', 'type' => 'text'));
				echo $this->Form->input('last_name', array('label' => 'Last Name Contact', 'type' => 'text'));
				?>
			</fieldset>
			<?php 
				echo $this->Form->input('reset', array('label' => false, 'type' => 'reset', 'value' => 'Clear'));
				echo $this->Form->end(__('Search')); 
			?> 
	</div>
	</div>
</div>

<?php include "../View/menu.php"; ?>