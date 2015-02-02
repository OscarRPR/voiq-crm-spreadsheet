<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo 'VOIQ - CRM Uploader Spreadsheet' ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->css('cake.generic');
		echo $this->Html->css('bootstrap-cerulean');
		echo $this->Html->css('bootstrap-responsive');
		echo $this->Html->css('charisma-app');
		echo $this->Html->css('jquery-ui-1.8.21.custom');
		echo $this->Html->css('fullcalendar.print');
		echo $this->Html->css('chosen');
		echo $this->Html->css('uniform.default');
		echo $this->Html->css('jquery.cleditor');
		echo $this->Html->css('jquery.noty');
		echo $this->Html->css('noty_theme_default');
		echo $this->Html->css('elfinder.min');
		echo $this->Html->css('elfinder.theme');
		echo $this->Html->css('jquery.iphone.toggle');
		echo $this->Html->css('opa-icons');
		echo $this->Html->css('uploadify');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div class="span12 center login-header">
		<h2>VOIQ - CRM Uploader Spreadsheet</h2>
	</div>
	<div id="container">
		<div style="text-align: left; padding-bottom:10px; padding-left:30px">
			<?php if($logged_in): ?>
				Welcome  <?php echo $current_user['username']; ?>.  <?php echo $this->Html->link('Logout', array('controller' =>'users', 'action'=>'logout')); ?>
			<?php endif; ?>
		</div>
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->Session->flash('Auth'); ?>
		<?php echo $this->fetch('content'); ?>
	</div>
</body>
</html>