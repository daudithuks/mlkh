<?php $this->load->view("partial/header"); ?>
<div id="title_bar">
	<div id="title" class="float_left"><?php echo $this->lang->line('profiles_profile'); ?></div>
</div>
<div id="edit_sale_wrapper">
	<?php echo form_open("profile/save/".$person_info->person_id,array('id'=>'employee_edit_form')); ?>
    <div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
	<ul id="error_message_box"></ul>
	
   <div class="field_row clearfix">	
	<?php echo form_label($this->lang->line('profiles_username').':', 'username',array('class'=>'required')); ?>
        <div class='form_field'>
        <?php echo form_input(array(
            'name'=>'username',
            'id'=>'username',
            'value'=>$person_info->username));?>
        </div>
    </div>
    
    <?php
    $password_label_attributes = $person_info->person_id == "" ? array('class'=>'required'):array();
    ?>
    
    <div class="field_row clearfix">	
    <?php echo form_label($this->lang->line('profiles_old_password').':', 'old_password',$password_label_attributes); ?>
        <div class='form_field'>
        <?php echo form_password(array(
            'name'=>'old_password',
            'id'=>'old_password'
        ));?>
        </div>
    </div>
    
    <div class="field_row clearfix">	
    <?php echo form_label($this->lang->line('profiles_new_password').':', 'password',$password_label_attributes); ?>
        <div class='form_field'>
        <?php echo form_password(array(
            'name'=>'password',
            'id'=>'password'
        ));?>
        </div>
    </div>
    
    
    <div class="field_row clearfix">	
    <?php echo form_label($this->lang->line('profiles_repeat_password').':', 'repeat_password',$password_label_attributes); ?>
        <div class='form_field'>
        <?php echo form_password(array(
            'name'=>'repeat_password',
            'id'=>'repeat_password'
        ));?>
        </div>
    </div>
    
    <?php
    echo form_submit(array(
        'name'=>'submit',
        'id'=>'submit',
        'value'=>$this->lang->line('common_submit'),
        'class'=>'submit_button float_right')
    );
    
    ?>
    	
	</form>
</div>
<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{	
	$('#employee_edit_form').validate({
		submitHandler:function(form)
		{
			$(form).ajaxSubmit({
			success:function(response)
			{
				if(response.success)
				{
					set_feedback(response.message,'success_message',false);
				}
				else
				{
					set_feedback(response.message,'error_message',true);	
					
				}
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
			first_name: "required",
			last_name: "required",
			username:
			{
				required:true,
				minlength: 5
			},
			old_password:
			{
 				matches: 123456
			},
			password:
			{
				<?php
				if($person_info->person_id == "")
				{
				?>
				required:true,
				<?php
				}
				?>
				minlength: 8
			},	
			repeat_password:
			{
 				equalTo: "#password"
			},
    		email: "email"
   		},
		messages: 
		{
     		first_name: "<?php echo $this->lang->line('common_first_name_required'); ?>",
     		last_name: "<?php echo $this->lang->line('common_last_name_required'); ?>",
     		username:
     		{
     			required: "<?php echo $this->lang->line('profiles_username_required'); ?>",
     			minlength: "<?php echo $this->lang->line('profiles_username_minlength'); ?>"
     		},
     		old_password:
			{
				matches: "meh"
			},
			password:
			{
				<?php
				if($person_info->person_id == "")
				{
				?>
				required:"<?php echo $this->lang->line('profiles_password_required'); ?>",
				<?php
				}
				?>
				minlength: "<?php echo $this->lang->line('profiles_password_minlength'); ?>"
			},
			repeat_password:
			{
				equalTo: "<?php echo $this->lang->line('profiles_password_must_match'); ?>"
     		},
     		email: "<?php echo $this->lang->line('common_email_invalid_format'); ?>"
		}
	});
});
</script>