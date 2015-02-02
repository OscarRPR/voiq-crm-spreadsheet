<?php 
	echo $this->Html->css('jquery-ui-1.8.21.custom');
	echo $this->Html->css('progress-bar');
	echo $this->Html->script('jquery-1.7.2.min');
	echo $this->Html->script('jquery-ui-1.8.21.custom.min');
	echo $this->Html->script('handlers_upload');
?>

<div class="upload form">
	<h2>Upload Spreadsheet</h2>
	<div class="box-content">
		<?php echo $this->Form->create(false, array('type' => 'file')); ?>

			<h4> It supports any of these formats (.xls, .xlsx, .csv, .txt). The files should be exported with Microsoft Excel to avoid compatibility problems in this first version. </br>
			In the formats .xls and .xlsx, the sheet should have the name Contacts, otherwise the process will fail. </br>
			All of them should use a header row using the following format (columns), otherwise the process will fail: </br> 
			</h4>
			
			<div style="padding-left: 8px;">
				<h4>
				first_name  last_name  phone_numbers  main_email  extra_emails  gender  birthdate 
				</h4>
			</div>

			<h4>
			There are some restrictions for the data which are described next, if this criteria it's not met, the process will not upload the information:
			</h4>


			<div style="padding-left: 8px;">
				<h5> 
				* first_name and last_name are required fields. </br>
				* phone_numbers are separated with the symbol '|' and must be at least one phone number. US phone number format. </br>
				* main_email it's the primary email of the client. Not required. </br>
				* extra_emails are separated with the symbol '|'. Not required. </br>
				* gender should be Male, Female or empty. Not required. </br>
				* birthdate should use the next format mm-dd-YYYY. Not required. </br>
				</h5>
			</div>

			<h4>After uploading, the process will download automatically a log with information about possible errors and basic information.</h4>

			<fieldset>
				<?php
					echo $this->Form->input('id', array('type' => 'hidden', 'value' => $current_user['id']));
					echo $this->Form->input('username', array('type' => 'hidden', 'value' => $current_user['username']));
					echo $this->Form->input('FileInput', array('label' => false, 'type' => 'file', 'id' => 'fileInput'));
				?>
			</fieldset>
		<?php 	
				$options = array
				(
				    'label' => 'Upload',
				    'value' => 'Upload',
				    'onClick' => 'progressBar(this);'
				    
				);
				echo $this->Form->end($options);?> 

			<div id="result" class="center-progress" style="width: 96%;">
			</div>

	</div>

	<div id="loading_progress_main" class="meter orange center" style="display: none;"> 
			<span id="loading_bar" style="width: 0%"></span>    
	</div>
</div>

<?php include "../View/menu.php"; ?>