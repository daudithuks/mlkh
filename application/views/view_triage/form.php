<?php
echo form_open('view_triage/save/'.$triage_info->patient_id,array('id'=>'customer_form'));
?>
<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="customer_basic_info">
<legend><?php echo $this->lang->line("triage_basic_information"); ?></legend>

<div class="field_row clearfix">	
<?php echo form_label('Patient Number:', 'patient_id',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'patient_id',
		'readonly'=>'readonly',
		'id'=>'patient_id',
		'value'=>$triage_info->patient_id)
	);?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label('Blood Pressure:', 'blood_pressure'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'blood_pressure',
		'id'=>'blood_pressure',
		'value'=>$triage_info->blood_pressure)
	);?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label('Pulse Rate:', 'pulse_rate'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'pulse_rate',
		'id'=>'pulse_rate',
		'value'=>$triage_info->pulse_rate)
	);?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label('Temperature:', 'temperature',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'temperature',
		'id'=>'temperature',
		'value'=>$triage_info->temperature)
	);?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label('Weight:', 'weight',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'weight',
		'id'=>'weight',
		'value'=>$triage_info->weight)
	);?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label('Triage Code:', 'triage_code'); ?>
	<div class='form_field'>
	<?php echo form_dropdown('triage_code',array(
		'referral'=>'REFERRAL',
		'emergency'=>'EMERGENCY',
		'birth_delivery'=>'BIRTH DELIVERY',
		'walk_in'=>'WALK-IN',
		'accident'=>'ACCIDENT')
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Priority:', 'priority'); ?>
	<div class='form_field'>
	<?php echo form_dropdown('priority',array(
		'4'=>'WHITE',
		'3'=>'GREEN',
		'2'=>'YELLLOW',
		'1'=>'RED')
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Gen. Appearance:', 'general_appearance'); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'general_appearance',
		'id'=>'general_appearance',
		'value'=>$triage_info->general_appearance,
		'rows'=>'5',
		'cols'=>'17')		
	);?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label('Chief Complaints:', 'chief_complaint'); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'chief_complaint',
		'id'=>'chief_complaint',
		'value'=>$triage_info->chief_complaint,
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
	$('#customer_form').validate({
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
			patient_id: "required",
			temperature: "required",
    		weight: "required"
   		},
		messages: 
		{
     		patient_id: "<?php echo 'Please enter patient number'; ?>",
			blood_pressure: "<?php echo 'Please enter blood pressure'; ?>",
    		pulse_rate: "<?php echo 'Please enter pulse rate'; ?>",
    		temperature: "<?php echo 'Please enter temperature'; ?>",
    		weight: "<?php echo 'Please enter weight'; ?>"
		}
	});
});
</script>