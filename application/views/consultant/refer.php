<?php
  //get the controller name 
  $CI =& get_instance();
  $controller_name=strtolower(get_class($CI));
 ?>
<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php
echo form_open($controller_name.'/save_referral/',array('id'=>'refer_form'));
?>
<fieldset id="item_basic_info">
<legend>Referral Information</legend>

<div class="field_row clearfix">
<?php echo form_label('Doctor:', 'refer_doctor',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'refer_doctor_name',
		'id'=>'refer_doctor_name')
	);?>
<input type="hidden" name="refer_doctor" id="refer_doctor" />
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label('Department:', 'refer_department',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_dropdown('refer_department', $departments, 'general','id="refer_department"'); ?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label('Description:', 'refer_description',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'refer_description',
		'id'=>'refer_description',
		'rows'=>'5',
		'cols'=>'17')
	);?>
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
</fieldset>
<?php
echo form_close();
?>
<script type='text/javascript'>

//validation and submit handling
$(document).ready(function()
{
	$("#refer_doctor_name").autocomplete("<?php echo site_url($controller_name.'/suggest_refer_doctor');?>",{
		max:100,
		minChars:0,
		delay:10,
		formatItem: function(row) {	return row[1];		}
		});
    $("#refer_doctor_name").result(function(event, data, formatted){
		$("#refer_doctor_name").val(data[1]);
		$("#refer_doctor").val(data[0]);
});
	$("#refer_doctor_name").search();


	$('#refer_form').validate({
		submitHandler:function(form)
		{
			$(form).ajaxSubmit({
			success:function(response)
			{
				tb_remove();
				post_refer_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules:
		{
			
   		},
		messages:
		{
			
		}
	});
});
</script>
