<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php
echo form_open('waivers/save/'.$waiver_info->waiver_id,array('id'=>'item_form'));
?>
<fieldset id="item_basic_info">
<legend><?php echo $this->lang->line("items_basic_information"); ?></legend>

<div class="field_row clearfix">
<?php echo form_label('Patient:', 'name',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'customer',
		'id'=>'customer',
		'value'=>$waiver_info->customer)
	);?>
    <?php echo form_input(array(
		'name'=>'customer_id',
		'id'=>'customer_id',
		'type'=>'hidden',
		'value'=>$waiver_info->customer_id)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label('Amount:', 'name',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'value',
		'id'=>'value',
		'value'=>$waiver_info->value)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label('Reason:', 'name',array('class'=>'required wide')); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'reason',
		'id'=>'reason',
		'rows'=>'5',
		'value'=>$waiver_info->reason)
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
	$("#customer").autocomplete("<?php echo site_url('waivers/suggest_customer');?>",
	{
		max:100,
		minChars:0,
		delay:10,
		formatItem: function(row) {
			return row[1];
		}
	});
    $("#customer").result(function(event, data, formatted)
	{
		$("#customer_id").val(data[0]);
		$("#customer").val(data[1]);
	});
	//$("#customer_id").search();


	$('#item_form').validate({
		submitHandler:function(form)
		{
			/*
			make sure the hidden field #item_number gets set
			to the visible scan_item_number value
			*/
			$('#item_number').val($('#scan_item_number').val());
			$(form).ajaxSubmit({
			success:function(response)
			{
				tb_remove();
				post_item_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules:
		{
			customer_id:"required",
			reason:"required",
			value:
			{
				required:true,
				number:true
			}
   		},
		messages:
		{
			customer_id:"The patient's name is required",
			reason:"Reason is required",
			value:
			{
				required:"Amount is required",
				number:"Please enter a valid value for the amount"
			}
		}
	});
});
</script>