<?php
  //get the controller name 
  $CI =& get_instance();
  $controller_name=strtolower(get_class($CI));

 echo form_open($controller_name."/save_obst_gyn",array('id'=>'save_obst_gyn_form')); ?>

<table id="register">
<tbody id="cart_contents">
<tr>
<td width="10%">Parity</td>
<td align="left"><?php echo form_textarea(array(
									'name'=>'parity',
									'id'=>'parity',
									'value'=>$obst_gyn["parity"],
									'rows'=>'5',
									'onchange' => 'save_obst_gyn()')); ?></td>
</tr>
<tr>
<td width="10%">Gravida</td>
<td align="left"><?php echo form_textarea(array(
									'name'=>'gravida',
									'id'=>'gravida',
									'value'=>$obst_gyn["gravida"],
									'rows'=>'5',
									'onchange' => 'save_obst_gyn()')); ?></td>
</tr>
<tr>
<td width="10%">LMP</td>
<td align="left">
<table><tr>
<td align="right"><?php echo form_input(array(
                'name'=>'lmp_start',
                'id'=>'lmp_start',
               	'value'=>$obst_gyn["lmp_start"], 
				'class'=>'date',
				'onchange' => 'save_obst_gyn()')
        ); ?></td>
<td>to</td>
<td align="right"><?php echo form_input(array(
				'name'=>'lmp_end',
				'id'=>'lmp_end',
				'value'=>$obst_gyn["lmp_end"], 
				'class'=>'date',
				'onchange' => 'save_obst_gyn()')
		); ?></td>
</tr></table>
</td>
</tr>
<tr>
<td width="10%">Menarche</td>
<td align="left"><?php echo form_textarea(array(
									'name'=>'menarche',
									'id'=>'menarche',
									'value'=>$obst_gyn["menarche"],
									'rows'=>'5',
									'onchange' => 'save_obst_gyn()')); ?></td>
</tr>
<tr>
<td width="10%">Menses<p style='font-size:smaller; font-style:italic'>(Characterize)</p></td>
<td align="left"><?php echo form_textarea(array(
									'name'=>'menses',
									'id'=>'menses',
									'value'=>$obst_gyn["menses"],
									'rows'=>'5',
									'onchange' => 'save_obst_gyn()')); ?></td>
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

function save_obst_gyn()
{
	$("#save_obst_gyn_form").ajaxSubmit();
}
</script>