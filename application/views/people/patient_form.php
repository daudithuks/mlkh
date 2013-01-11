<div class="field_row clearfix">	
<?php echo form_label('Patient Number:', 'person_id'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'person_id',
		'readonly'=>'readonly',
		'id'=>'person_id',
		'value'=>$person_info->person_id)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_first_name').':', 'first_name',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'first_name',
		'id'=>'first_name',
		'value'=>$person_info->first_name)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Middle Name:', 'middle_name'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'middle_name',
		'id'=>'middle_name',
		'value'=>$person_info->middle_name)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_last_name').':', 'last_name',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'last_name',
		'id'=>'last_name',
		'value'=>$person_info->last_name)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Gender:', 'gender',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_dropdown('gender',array(
		'male'=>'Male',
		'female'=>'Female'),
		$person_info->gender	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Visit Satus:', 'visit_status',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_dropdown('visit_status',array(
		''=>'',
		'0'=>'Re-Attendance',
		'1'=>'New Patient'),
		$person_info->visit_status	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Civil Status:', 'civil_status'); ?>
	<div class='form_field'>
	<?php echo form_dropdown('civil_status',array(
		'single'=>'Single',
		'married'=>'Married',
		'divorced'=>'Divorced',
		'widowed'=>'Widowed'),
		$person_info->civil_status	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label('Date of Birth: MM/DD/YYYY', ' age',array('class'=>'required')); ?>
        <div class='form_field'>
        <?php 
			$dob = explode('-',$person_info->age);
			
			if($dob[0] != 0000) $age = $dob[2]."/".$dob[1]."/".$dob[0]; 
			echo form_input(array(
                'name'=>'age',
                'id'=>'age',
               	'value'=>$age, 
				'class'=>'date')
        );?>
	</div>
</div>


<div class="field_row clearfix">	
<?php echo form_label('Next of Kin:', ' next_kin',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'next_kin',
		'id'=>'next_kin',
		'value'=>$person_info->next_kin)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Next of Kin Phone:', 'next_kin_tel',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'next_kin_tel',
		'id'=>'next_kin_tel',
		'value'=>$person_info->next_kin_tel)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Residence/Estate:', 'residence'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'residence',
		'id'=>'residence',
		'value'=>$person_info->residence)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('NHIF #:', 'nhif'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'nhif',
		'id'=>'nhif',
		'value'=>$person_info->nhif)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('National ID:', 'national_id'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'national_id',
		'id'=>'national_id',
		'value'=>$person_info->national_id)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_phone_number').':', 'phone_number'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'phone_number',
		'id'=>'phone_number',
		'value'=>$person_info->phone_number));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_email').':', 'email'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'email',
		'id'=>'email',
		'value'=>$person_info->email)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_address').':', 'address_1'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'address_1',
		'id'=>'address_1',
		'value'=>$person_info->address_1));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_town').':', 'city'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'city',
		'id'=>'city',
		'value'=>$person_info->city));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_zip').':', 'zip'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'zip',
		'id'=>'zip',
		'value'=>$person_info->zip));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_country').':', 'country'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'country',
		'id'=>'country',
		'value'=>$person_info->country));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label('Blood Group:', 'blood_group'); ?>
	<div class='form_field'>
	<?php echo form_dropdown('blood_group',array(
		''=>'',
		'O'=>'O',
		'A'=>'A',
		'B'=>'B',
		'AB'=>'AB'),
		$person_info->blood_group	);?>
	</div>
</div>

<!--<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_comments').':', 'comments'); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'comments',
		'id'=>'comments',
		'value'=>$person_info->comments,
		'rows'=>'5',
		'cols'=>'17')		
	);?>
	</div>
</div>-->
