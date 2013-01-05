<?php
  //get the controller name 
  $CI =& get_instance();
  $controller_name=strtolower(get_class($CI));

 echo form_open($controller_name."/save_medical_history",array('id'=>'save_medical_history_form')); ?>

<table id="register">
<tbody id="cart_contents">
<tr>
<td width="20%">Previous Admissions</td>
<td align="left"><?php echo form_textarea(array(
									'name'=>'previous_admission',
									'id'=>'previous_admission',
									'value'=>$medical_history["previous_admission"],
									'rows'=>'5',
									'onchange' => 'save_medical_history()')); ?></td>
</tr>
<tr>
<td width="10%">Medication</td>
<td align="left"><?php echo form_textarea(array(
									'name'=>'medication',
									'id'=>'medication',
									'value'=>$medical_history["medication"],
									'rows'=>'5',
									'onchange' => 'save_medical_history()')); ?></td>
</tr>
<tr>
<td width="10%">Allergies</td>
<td align="left"><?php echo form_textarea(array(
									'name'=>'allergies',
									'id'=>'allergies',
									'value'=>$medical_history["allergies"],
									'rows'=>'5',
									'onchange' => 'save_medical_history()')); ?></td>
</tr>
<tr>
<td width="10%">Chronic Illness
<p style='font-size:smaller; font-style:italic'>(include TB, HIV, HTN, Epilepsy, Asthma etc)</p>
<p style='font-size:smaller; color:#F00'><?php 
$data = array(
	'name'        => 'newsletter',
    'id'          => 'newsletter',
    //'checked'     => empty($chronic_illness)?TRUE:FALSE,
    "onclick" => "disable_text(this,'chronic_illness')"
    );

//echo form_checkbox($data);
?></p>
</td>
<td align="left"><?php echo form_textarea(array(
									'name'=>'chronic_illness',
									'id'=>'chronic_illness',
									'value'=>$medical_history["chronic_illness"],
									'rows'=>'5',
									'onchange' => 'save_medical_history()')); ?></td>
</tr>
<tr>
<td width="10%">Previous Surgery</td>
<td align="left"><?php echo form_textarea(array(
									'name'=>'previous_surgery',
									'id'=>'previous_surgery',
									'value'=>$medical_history["previous_surgery"],
									'rows'=>'5',
									'onchange' => 'save_medical_history()')); ?></td>
</tr>

</tbody>
</table>

</form>
<script type='text/javascript'>

//validation and submit handling
$(document).ready(function()
{
	$('.date').datePicker({startDate: '01/01/1900'});
});

function disable_text(source,target)
{
	if(source.checked == "checked") $("#"+target).attr("readonly","readonly");
	
}

function save_medical_history()
{
	$("#save_medical_history_form").ajaxSubmit();
}
</script>