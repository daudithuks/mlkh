<?php
  //get the controller name 
  $CI =& get_instance();
  $controller_name=strtolower(get_class($CI));

 echo form_open($controller_name."/save_family_history",array('id'=>'save_family_history_form')); ?>

<table id="register">
<tbody id="cart_contents">
<tr>
<td width="20%">Occupation</td>
<td align="left"><?php echo form_input(array(
									'name'=>'occupation',
									'id'=>'occupation',
									'value'=>$family_history["occupation"],
									'onchange' => 'save_family_history()')); ?></td>
</tr>
<tr>
<td width="10%">Alcohol</td>
<td align="left">
<label>
<?php echo form_radio(array(
	'name'=>'alcohol',
	'id'=>'alcohol_yes',
	'value'=>'yes',
	'checked'=>$family_history["alcohol"]=='yes'?'checked':'',
	'onchange' => 'save_family_history()')); ?>
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;<label>
<?php echo form_radio(array(
	'name'=>'alcohol',
	'id'=>'alcohol_no',
	'value'=>'no',
	'checked'=>$family_history["alcohol"]=='no'?'checked':'',
	'onchange' => 'save_family_history()')); ?>
No</label>
</td>
</tr>
<tr>
<td width="10%">Cigarettes</td>
<td align="left"><label>
<?php echo form_radio(array(
	'name'=>'cigarettes',
	'id'=>'cigarettes_yes',
	'value'=>'yes',
	'checked'=>$family_history["cigarettes"]=='yes'?'checked':'',
	'onchange' => 'save_family_history()')); ?>
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;<label>
<?php echo form_radio(array(
	'name'=>'cigarettes',
	'id'=>'cigarettes_no',
	'value'=>'no',
	'checked'=>$family_history["cigarettes"]=='no'?'checked':'',
	'onchange' => 'save_family_history()')); ?>
No
</label>
</td>
</tr>
<tr>
<td width="10%">Familial Diseases</td>
<td align="left"><?php echo form_textarea(array(
									'name'=>'familial_diseases',
									'id'=>'familial_diseases',
									'value'=>$family_history["familial_diseases"],
									'onchange' => 'save_family_history()')); ?></td>
</tr>
</tbody>
</table>

</form>
<script type='text/javascript'>
function enable_text(source,target)
{
	if(source.checked == "checked") $("#"+target).attr("readonly","readonly");
	
}

function save_family_history()
{
	$("#save_family_history_form").ajaxSubmit();
}
</script>