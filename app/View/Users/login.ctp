<div class="row-fluid">
	<div class="well span5 center login-box">
		<div class="alert alert-info">
			Please enter your credentials.
		</div>
		<?php
			echo $this->Form->create();
		?>
			<fieldset>
				<div class="input-prepend" title="Username" data-rel="tooltip">
					<span class="add-on"><i class="icon-user"></i></span>
					<?php
						echo $this->Form->input('username', array('class' => 'input-large span10',
																	'div' => false,
																	'label' => false,
																	'autofocus' =>''));
					?>
				</div>
				<div class="input-prepend" title="Password" data-rel="tooltip">
					<span class="add-on"><i class="icon-lock"></i></span>
					<?php
						echo $this->Form->input('password', array('class' => 'input-large span10',
																	'div' => false,
																	'label' => false));
					?>
				</div>
			</fieldset>
		<?php
			echo $this->Form->end(array(
    				'label' => 'Log in',
    				'class' => 'btn btn-primary',
    				'div' => false
				));
		?>
	</div>
</div>