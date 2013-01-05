<?php $this->load->view("partial/header"); ?>
<div id="page_title" style="margin-bottom:8px;"><?php echo $this->lang->line('prescribe_doctor_presc'); ?></div>
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
<?php echo form_open("prescribe/add",array('id'=>'add_item_form')); ?>
<label id="item_label" for="item">

<?php
echo $this->lang->line('prescribe_find_or_scan_item');
?>
</label>
<?php echo form_input(array('name'=>'item','id'=>'item','size'=>'40'));?>

</form>
<table id="register">
<thead>
<tr>
<th style="width:2%;"><?php echo $this->lang->line('prescribe_item_number'); ?></th>
<th style="width:30%;"><?php echo $this->lang->line('prescribe_item_name'); ?></th>
<!-- <th style="width:10%;"><?php echo $this->lang->line('prescribe_price'); ?></th>-->
<th style="width:5%;"><?php echo $this->lang->line('prescribe_quantity'); ?></th>
<th style="width:43%;"><?php echo $this->lang->line('prescribe_notes'); ?></th>
<th style="width:10%;"></th>
<th style="width:10%;"></th>
</tr>
</thead>
<tbody id="cart_contents">
<?php
if(count($cart)==0)
{
?>
<tr><td colspan='8'>
<div class='warning_message' style='padding:7px;'><?php echo $this->lang->line('prescribe_no_items_in_cart'); ?></div>
</tr></tr>
<?php
}
else
{
	foreach(array_reverse($cart, true) as $line=>$item)
	{
		$cur_item_info = $this->Item->get_info($item['item_id']);
		echo form_open("prescribe/edit_item/$line");
	?>
		<tr>
		<td><?php echo $item['item_number']; ?></td>
		<td style="align:center;"><?php echo $item['name']; ?><br />
        <?php
			if($item['is_serialized']==1)
        	{
				echo '<font color="2F4F4F">'.$this->lang->line('prescribe_serial').':</font>'.$item['serialnumber'];
			}
		?>
        </td>

		<td>
		<?php
        	if($item['is_serialized']==1)
        	{
        		echo $item['quantity'];
        		echo form_hidden('quantity',$item['quantity']);
        	}
        	else
        	{
        		echo form_input(array('name'=>'quantity','value'=>$item['quantity'],'size'=>'2'));
        	}
		?>
		</td>

   <!-- <td><?php echo to_currency($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100); ?></td>-->
   		<td><?php echo form_textarea(array('name'=>'description','id'=>'description','value'=>$item['description'],'rows'=>'3','cols'=>'30'));?></td>
		<td><?php echo form_submit("edit_item", $this->lang->line('prescribe_edit_item'));?></td>
		<td><?php echo anchor("prescribe/delete_item/$line",'['.$this->lang->line('common_delete').']');?></td>
		</tr>
		
		<tr style="height:3px">
		<td colspan=8 style="background-color:white"> </td>

		<?php if ($items_module_allowed)
		{
		?>
			<td width="0"><?php echo form_input(array('type'=>'hidden','name'=>'price','value'=>$item['price'],'size'=>'6'));?></td>
		<?php
		}
		else
		{
		?>
			<td width="0"><?php echo $item['price']; ?></td>
			<?php echo form_hidden('price',$item['price']); ?>
		<?php
		}
		?>
		</tr>		</form>
	<?php
	}
}
?>
</tbody>
</table>
<!-- Bwats -->
<!-- view to show basic customer data -->
<?php if (isset($customer)) {
?>
<?php $output="";
 $output .="<tr><td><h4>Patient Number:</h4></td><td>". $patient_id ."</td></tr>";
 $output .="<tr><td><h4>Title:</h4></td><td> ". $cust_phone."</td></tr>"; 
 $output .="<tr><td><h4>Family Name:</h4></td><td>". $customer."</td></tr>";
 $output .="<tr><td><h4>Given Name:</h4></td><td>". $customer."</td></tr>";
 $output .="<tr><td><h4>Date of Birth:</h4></td><td>". $patient_id."</td></tr>";
 $output .="<tr><td><h4>Gender:</h4></td><td>". $patient_id."</td></tr>"; 
 $output .="<tr><td><h4>Blood Group:</h4></td><td>". $patient_id."</td></tr>";
 ?>
<?php
} ?>

	<!-- view to show patient history if any -->

		<div id="patient-history">
			<?php if ($history) {
			?>
			<table border="3">
				<caption><h1>Patient History</h1></caption>
				<thead>
					<tr>
						<th width="200px">prescribed Date</th>
						<th width="100px">Dosage</th>
						<th width="100px">Drug prescribed</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($history as $histo): ?>
					<tr>
						<td><?php echo $histo->sale_time; ?></td>
						<td><?php echo $histo->quantity_purchased; ?></td>
						<td><?php echo $histo->name; ?></td>
					</tr>
					<?php endforeach ?>
					<?php //print_r($history); ?>
					
				</tbody>
			</table>
			<?php
			} ?>
		</div>
		<!-- END Bwats -->
</div>


<div id="overall_sale">
	<?php
	if(isset($customer))
	{
		echo $this->lang->line("prescribe_patient").': <b>'.$customer. '</b><br />';
		echo anchor("prescribe/remove_customer",'['.$this->lang->line('common_remove').' '.$this->lang->line('customers_customer').']');
	}
	else
	{
		echo form_open("prescribe/select_customer",array('id'=>'select_customer_form')); ?>
		<label id="customer_label" for="customer"><?php echo $this->lang->line('prescribe_select_patient'); ?></label>
		<?php echo form_input(array('name'=>'customer','id'=>'customer','size'=>'30','value'=>$this->lang->line('prescribe_start_typing_patient_name')));?>
		</form>
		
		<div class="clearfix">&nbsp;</div>
		<?php
	}
	?>

	<div id='sale_details'>
		<!--Bwats-->
		<table>
			<?php echo $output; ?>
		</table>
		<!--End Bwats-->
		<!-- <div class="float_left" style="width:55%;"><?php echo $this->lang->line('prescribe_sub_total'); ?>:</div>
		<div class="float_left" style="width:45%;font-weight:bold;"><?php echo to_currency($subtotal); ?></div>

		<?php foreach($taxes as $name=>$value) { ?>
		<div class="float_left" style='width:55%;'><?php echo $name; ?>:</div>
		<div class="float_left" style="width:45%;font-weight:bold;"><?php echo to_currency($value); ?></div>
		<?php }; ?>

		<div class="float_left" style='width:55%;'><?php echo $this->lang->line('prescribe_total'); ?>:</div>
		<div class="float_left" style="width:45%;font-weight:bold;"><?php echo to_currency($total); ?></div> -->
	</div>




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
			<!-- <div id="finish_sale">
				<?php echo form_open("prescribe/complete",array('id'=>'finish_invoice_form')); ?>
				<label id="comment_label" for="comment"><?php echo $this->lang->line('prescribe_prescription'); ?>:</label>
				<?php echo form_textarea(array('name'=>'comment', 'id' => 'comment', 'value'=>$comment,'rows'=>'4','cols'=>'23'));?>
				<br /><br />
				
				<?php
				echo "<div class='small_button' id='finish_sale_button' style='float:left;margin-top:5px;'><span>".$this->lang->line('prescribe_complete_prescription')."</span></div>";
				?>
			</div> -->
			</form>
        <!-- <div id="Cancel_sale">
		<?php echo form_open("prescribe/cancel_invoice",array('id'=>'cancel_sale_form')); ?>
		<div class='small_button' id='cancel_sale_button' style='margin-top:5px;'>
			<span><?php echo $this->lang->line('prescribe_cancel_prescription'); ?></span>
		</div> -->
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
    $("#item").autocomplete('<?php echo site_url("prescribe/item_search"); ?>',
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
    	$(this).attr('value',"<?php echo $this->lang->line('prescribe_start_typing_item_name'); ?>");
    });

	$('#item,#customer').click(function()
    {
    	$(this).attr('value','');
    });

    $("#customer").autocomplete('<?php echo site_url("prescribe/customer_search"); ?>',
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
    	$(this).attr('value',"<?php echo $this->lang->line('prescribe_start_typing_patient_name'); ?>");
    });
	
	$('#comment').change(function() 
	{
		$.post('<?php echo site_url("prescribe/set_comment");?>', {comment: $('#comment').val()});
	});
	
	$('#email_receipt').change(function() 
	{
		$.post('<?php echo site_url("prescribe/set_email_receipt");?>', {email_receipt: $('#email_receipt').is(':checked') ? '1' : '0'});
	});
	
	
    $("#finish_sale_button").click(function()
    {
    	if (confirm('<?php echo $this->lang->line("prescribe_confirm_finish_prescription"); ?>'))
    	{
    		$('#finish_invoice_form').submit();
    	}
    });

	$("#suspend_sale_button").click(function()
	{
		if (confirm('<?php echo $this->lang->line("prescribe_confirm_suspend_invoice"); ?>'))
    	{
			$('#finish_invoice_form').attr('action', '<?php echo site_url("prescribe/suspend"); ?>');
    		$('#finish_invoice_form').submit();
    	}
	});

    $("#cancel_sale_button").click(function()
    {
    	if (confirm('<?php echo $this->lang->line("prescribe_confirm_cancel_prescription"); ?>'))
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
	if ($("#payment_types").val() == "<?php echo $this->lang->line('prescribe_giftcard'); ?>")
	{
		$("#amount_tendered_label").html("<?php echo $this->lang->line('prescribe_giftcard_number'); ?>");
		$("#amount_tendered").val('');
		$("#amount_tendered").focus();
	}
	else
	{
		$("#amount_tendered_label").html("<?php echo $this->lang->line('prescribe_amount_tendered'); ?>");		
	}
}

</script>
