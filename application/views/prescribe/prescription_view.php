<?php $this->load->view("partial/header"); ?>
<div id="page_title" style="margin-bottom:8px;"><?php echo $this->lang->line('prescription'); ?></div>
<?php
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}

if (isset($warning))
{
	echo "<div class='warning_mesage'>".$warning."</div>";
}

if (isset($success))
{
	echo "<div class='success_message'>".$success."</div>";
}
?>
<div id="register_wrapper">

<table id="register">
<thead>
<tr>
<th style="width:10%;"><?php echo $this->lang->line('prescription_item_number'); ?></th>
<th style="width:10%;"><?php echo $this->lang->line('presctiption_item_name'); ?></th>
<th style="width:10%;"><?php echo $this->lang->line('prescription_dosage'); ?></th>
<th style="width:10%;"><?php echo $this->lang->line('prescription_route_of_admin'); ?></th>
<th style="width:15%;"><?php echo $this->lang->line('prescription_frequency'); ?></th>
<th style="width:15%;"><?php echo $this->lang->line('prescription_duration'); ?></th>
<th style="width:15%;"><?php echo $this->lang->line('prescription_edit'); ?></th>
<th style="width:15%;"><?php echo $this->lang->line('prescription_delete'); ?></th>
</tr>
</thead>
<tbody id="cart_contents">
	<tr>
		<?php 
		if (isset($item)) {
			# just show value in text box

			?>
			<td><?php echo $item['item_number'];?></td>
			<?php
		}else{
			echo form_open("docprescribe/select_item",array('id'=>'add_item_form')); 
		 	?><td><?php echo form_input(array('name'=>'item','id'=>'item'));?> </td>
			</form>
			<?php
		}
		 ?>

		<?php echo form_open("docprescribe/add_prescription",array('id'=>'add_presc_form')); ?>
		<?php echo form_hidden('item_id', $item['item_id']); ?>
		<td style="align:center;"><?php echo $item['name'];?></td>
		<td><?php echo form_input(array('name'=>'dosage','value'=>"",'size'=>'3')); ?></td>
		<td><?php echo form_dropdown('roa', $roa, "1" ); ?></td>
		<td><?php echo form_dropdown('frequency', $frequency, "1"); ?></td>
		<td><?php echo form_input(array('name'=>'duration','value'=>"",'size'=>'3')); ?></td>
		<td><?php echo form_submit('add', 'Add'); ?> </td>
	</tr>
</form>
</tbody>
</table>


<table id="register">
<thead>
<tr>
<th style="width:10%;"><?php echo $this->lang->line('prescription_date'); ?></th>
<th style="width:10%;"><?php echo $this->lang->line('presctiption_item_name'); ?></th>
<th style="width:10%;"><?php echo $this->lang->line('prescription_dosage'); ?></th>
<th style="width:15%;"><?php echo $this->lang->line('prescription_frequency'); ?></th>
<th style="width:15%;"><?php echo $this->lang->line('prescription_duration'); ?></th>
<th style="width:15%;"><?php echo $this->lang->line('prescription_quantity'); ?></th>
<th style="width:15%;"><?php echo $this->lang->line('prescription_staff'); ?></th>
</tr>
</thead>
<tbody>
	<?php
if(count($prescriptions)==0)
{
?>
<tr>
	<td colspan='8'>
		<div class='warning_message' style='padding:7px;'><?php echo $this->lang->line('no_prescriptions_for_patient'); ?></div>
	</td>
</tr>
<?php
}
//else
{
?>
	<?php foreach ($prescriptions as $prescription): ?>
		<tr>
			<td><?php echo $prescription->invoice_time; ?></td>
			<td><?php echo $prescription->item_id; ?></td>
			<td><?php echo $prescription->dosage; ?></td>
			<td><?php echo $prescription->frequency; ?></td>
			<td><?php echo $prescription->duration; ?></td>
			<td><?php echo $prescription->quantity_purchased; ?></td>
			<td><?php echo $prescription->employee_id; ?></td>
		</tr>
	<?php endforeach ?>
<?php
}
?>
</tbody>
</table>
<?php if (isset($customer)): ?>
	<!-- load table using table helper -->
<?php endif ?>
</div>


<div id="overall_sale">
	<?php
	if(isset($customer))
	{
		echo $this->lang->line("invoices_customer").': <b>'.$customer. '</b><br />';
		echo anchor("docprescribe/remove_customer",'['.$this->lang->line('common_remove').' '.$this->lang->line('customers_customer').']');
	}
	else
	{
		echo form_open("docprescribe/select_customer",array('id'=>'select_customer_form')); ?>
		<label id="customer_label" for="customer"><?php echo $this->lang->line('invoices_select_customer'); ?></label>
		<?php echo form_input(array('name'=>'customer','id'=>'customer','size'=>'30','value'=>$this->lang->line('invoices_start_typing_customer_name')));?>
		</form>
		
		<div class="clearfix">&nbsp;</div>
		<?php
	}
	?>
	<?php if (isset($customer)): ?>
	<div id='sale_details'>
		<div class="float_left" style="width:55%;">Gender:</div>
		<div class="float_left" style="width:45%;font-weight:bold;"><?php echo $gender; ?></div>
		<div class="float_left" style="width:55%;">Age:</div>
		<div class="float_left" style="width:45%;font-weight:bold;"><?php echo $age; ?></div>
		<div class="float_left" style="width:55%;">Patient_No:</div>
		<div class="float_left" style="width:45%;font-weight:bold;"><?php echo $patient_no; ?></div>
		<div class="float_left" style="width:55%;">Civil_status:</div>
		<div class="float_left" style="width:45%;font-weight:bold;"><?php echo $civil_status; ?></div>
	</div>
	<?php endif ?>
	
	<?php
	// Only show this part if there are Items already in the invoice.
	if(count($cart) > 0)
	{
	?>

    	
		<div class="clearfix" style="margin-bottom:1px;">&nbsp;</div>
		<?php
		// Only show this part if there is at least one payment entered.
		if(isset($customer))
		{
		?>
			<div id="finish_sale">
				<?php echo form_open("docprescribe/complete",array('id'=>'finish_invoice_form')); ?>
				<label id="comment_label" for="comment"><?php echo $this->lang->line('common_comments'); ?>:</label>
				<?php echo form_textarea(array('name'=>'comment', 'id' => 'comment', 'value'=>$comment,'rows'=>'4','cols'=>'23'));?>
				<br /><br />
				
				<?php
				echo "<div class='small_button' id='finish_sale_button' style='float:left;margin-top:5px;'><span>".$this->lang->line('invoices_complete_invoice')."</span></div>";
				?>
			</div>
			</form>
        <div id="Cancel_sale">
		<?php echo form_open("docprescribe/cancel_invoice",array('id'=>'cancel_sale_form')); ?>
		<div class='small_button' id='cancel_sale_button' style='margin-top:5px;'>
			<span><?php echo $this->lang->line('invoices_cancel_invoice'); ?></span>
		</div>
    	</form>
    	</div>
		<?php
		}
		?>


	</div>

	<?php
	}
	?>
</div>
<div class="clearfix" style="margin-bottom:30px;">&nbsp;</div>


<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
    $("#item").autocomplete('<?php echo site_url("invoices/item_search"); ?>',
    {
    	minChars:0,
    	max:100,
    	selectFirst: false,
       	delay:10,
    	formatItem: function(row) {
			return row[1];
		}
    });

    $("#item").result(function(event, data, formatted)
    {
		$("#add_item_form").submit();
    });

	$('#item').focus();

	$('#item').blur(function()
    {
    	$(this).attr('value',"<?php echo $this->lang->line('invoices_start_typing_item_name'); ?>");
    });

	$('#item,#customer').click(function()
    {
    	$(this).attr('value','');
    });

    $("#customer").autocomplete('<?php echo site_url("invoices/customer_search"); ?>',
    {
    	minChars:0,
    	delay:10,
    	max:100,
    	formatItem: function(row) {
			return row[1];
		}
    });

    $("#customer").result(function(event, data, formatted)
    {
		$("#select_customer_form").submit();
    });

    $('#customer').blur(function()
    {
    	$(this).attr('value',"<?php echo $this->lang->line('invoices_start_typing_customer_name'); ?>");
    });
	
	$('#comment').change(function() 
	{
		$.post('<?php echo site_url("invoices/set_comment");?>', {comment: $('#comment').val()});
	});
	
	$('#email_receipt').change(function() 
	{
		$.post('<?php echo site_url("invoices/set_email_receipt");?>', {email_receipt: $('#email_receipt').is(':checked') ? '1' : '0'});
	});
	
	
    $("#finish_sale_button").click(function()
    {
    	if (confirm('<?php echo $this->lang->line("invoices_confirm_finish_invoice"); ?>'))
    	{
    		$('#finish_invoice_form').submit();
    	}
    });

	$("#suspend_sale_button").click(function()
	{
		if (confirm('<?php echo $this->lang->line("invoices_confirm_suspend_invoice"); ?>'))
    	{
			$('#finish_invoice_form').attr('action', '<?php echo site_url("invoices/suspend"); ?>');
    		$('#finish_invoice_form').submit();
    	}
	});

    $("#cancel_sale_button").click(function()
    {
    	if (confirm('<?php echo $this->lang->line("invoices_confirm_cancel_invoice"); ?>'))
    	{
    		$('#cancel_sale_form').submit();
    	}
    });

	$("#add_payment_button").click(function()
	{
	   $('#add_payment_form').submit();
    });

	$("#payment_types").change(checkPaymentTypeGiftcard).ready(checkPaymentTypeGiftcard)
});

function post_item_form_submit(response)
{
	if(response.success)
	{
		$("#item").attr("value",response.item_id);
		$("#add_item_form").submit();
	}
}

function post_person_form_submit(response)
{
	if(response.success)
	{
		$("#customer").attr("value",response.person_id);
		$("#select_customer_form").submit();
	}
}

function checkPaymentTypeGiftcard()
{
	if ($("#payment_types").val() == "<?php echo $this->lang->line('invoices_giftcard'); ?>")
	{
		$("#amount_tendered_label").html("<?php echo $this->lang->line('invoices_giftcard_number'); ?>");
		$("#amount_tendered").val('');
		$("#amount_tendered").focus();
	}
	else
	{
		$("#amount_tendered_label").html("<?php echo $this->lang->line('invoices_amount_tendered'); ?>");		
	}
}

</script>
