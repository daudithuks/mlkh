<?php
echo form_open('triage/save/'.$person_info->person_id,array('id'=>'customer_form'));
?>
<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="customer_basic_info">
<legend><?php echo $this->lang->line("triage_basic_information"); ?></legend>

<div class="field_row clearfix">	
<?php echo form_label('Patient Number:', 'patient_number'); ?>
	<div class='form_field'>
	<?php 
	echo $this->Appconfig->get('patient_prefix').$person_info->person_id;
	echo form_hidden('patient_id',$person_info->person_id); ?>
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
<?php echo form_label('Blood Pressure:', 'blood_pressure'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'blood_pressure',
		'id'=>'blood_pressure',
		'value'=>'')
	);?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label('Pulse Rate:', 'pulse_rate'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'pulse_rate',
		'id'=>'pulse_rate',
		'value'=>'')
	);?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label('Temperature:', 'temperature',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'temperature',
		'id'=>'temperature',
		'value'=>'')
	);?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label('Weight:', 'weight',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'weight',
		'id'=>'weight',
		'value'=>'')
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
		'accident'=>'ACCIDENT'),'walk_in'
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
		'value'=>'',
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
		'value'=>'',
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
			//temperature: "required",
    		weight: "required"
   		},
		messages: 
		{
     		blood_pressure: "<?php echo 'Please enter blood pressure'; ?>",
    		weight: "<?php echo 'Please enter weight'; ?>"
		}
	});
});
</script>
