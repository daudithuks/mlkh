<?php
echo form_open('admissions/save_allocation/'.$person_info->person_id,array('id'=>'service_form'));
?>
<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="customer_basic_info">
<legend><?php echo 'Admission Information'; ?></legend>

<div class="field_row clearfix">	
<?php echo form_label('Patient Number:', 'patient_number'); ?>
	<div class='form_field'>
	<?php 
	echo $this->Appconfig->get('patient_prefix').$person_info->person_id; ?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Patient Name:', 'patient_name'); ?>
	<div class='form_field'>
	<?php 
	echo $person_info->first_name.' '.$person_info->last_name; ?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Outpatient Service:', 'outpatient_service'); ?>
	<div class='form_field'>
	<?php 
	$serv_id="outpatient_service";
	echo form_dropdown('outpatient_service', $outpatient_service, '',$serv_id); ?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Visit Status:', 'visit_status'); ?>
	<div class='form_field'>
	<?php 
	$vis_id="visit_status";
	echo form_dropdown('visit_status',array(
		'0'=>'New Patient',
		'1'=>'Re-Attendance'),'0', $vis_id);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Send through Triage:', 'through_triage'); ?>
	<div class='form_field'>
	<?php 
	echo form_checkbox(array(
		'name'=>'through_triage',
		'id'=>'through_triage',
		'value'=>'1',
		'checked'=>'checked'));?>
	</div>
</div>
<?php
echo form_hidden('queue',$queue);
?>
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
	$('#service_form').validate({
		submitHandler:function(form)
		{
			$(form).ajaxSubmit({
			success:function(response)
			{
				tb_remove();
				post_person_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
			//patient_id: "required",
			//temperature: "required",
    		//weight: "required"
   		},
		messages: 
		{
     		//patient_id: "<?php echo 'Please enter patient number'; ?>",
			//blood_pressure: "<?php echo 'Please enter blood pressure'; ?>",
    		//weight: "<?php echo 'Please enter weight'; ?>"
		}
	});
});
</script>
