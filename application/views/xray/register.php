<?php $this->load->view("partial/header"); ?>
<div id="page_title" style="margin-bottom:8px;"><?php echo $this->lang->line('invoices_xray'); ?></div>
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
<div id="queue_section">
<?php $this->load->view("xray/queue"); ?>
</div>

<div id="register_wrapper">
<?php echo form_open("xray/add",array('id'=>'add_item_form')); ?>
<label id="item_label" for="item">

<?php
//echo $this->lang->line('invoices_find_or_scan_item');
?>
</label>
<?php //echo form_input(array('name'=>'item','id'=>'item','size'=>'40'));?>

</form>
<table id="register">
<thead>
<tr>
<th style="width:10%;"><?php echo $this->lang->line('invoices_item_number'); ?></th>
<th style="width:30%;"><?php echo $this->lang->line('invoices_item_name'); ?></th>
<th style="width:30%;"><?php echo 'Description'; ?></th>
<th style="width:30%;"><?php echo $this->lang->line('invoices_results'); ?></th>


<th style="width:10%;"></th>
</tr>
</thead>
<tbody id="cart_contents">
<?php
if(count($cart)==0)
{
?>
<tr><td colspan='8'>
<div class='warning_message' style='padding:7px;'><?php echo $this->lang->line('invoices_no_items_in_cart'); ?></div>
</tr></tr>
<?php
}
else
{
	foreach(array_reverse($cart, true) as $line=>$item)
	{
		$cur_item_info = $this->Item->get_info($item['item_id']);
		echo form_open("xray/edit_item/$line",array('id'=>'edit_item_form'));
	?>
		<tr>
		<td><?php echo $item['item_number']; ?></td>
		<td style="align:center;"><?php echo $item['name']; ?><br />
        <?php
			if($item['is_serialized']==1)
        	{
				echo '<font color="2F4F4F">'.$this->lang->line('invoices_serial').':</font>'.$item['serialnumber'];
			}
		?>
        </td>

		<td>
		<?php
        		echo $item['description'];
 		?>
		</td>

		<td>
		<?php
        		echo $item['result'];
        		echo form_textarea(array('name'=>'result', 'id' => 'result', 'value'=>$item['result'],'rows'=>'4','cols'=>'23'));
		?>
		</td>

		<td><?php to_currency($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100); ?></td>
		<td><?php echo form_submit("edit_item", $this->lang->line('invoices_edit_item'));?></td>
		<td><?php anchor("xray/delete_item/$line",'['.$this->lang->line('common_delete').']');?></td>
		</tr>
		
		<tr style="height:3px">
		<td colspan=8 style="background-color:white"> </td>
		</tr>		</form>
	<?php
	}
}
?>
</tbody>
</table>
</div>


<div id="overall_sale">
	<?php
	if(isset($customer))
	{
		echo $this->lang->line("invoices_customer").': <b>'.$customer. '</b><br />';
		echo anchor("xray/remove_customer",'['.$this->lang->line('common_remove').' '.$this->lang->line('customers_customer').']');
	}
	else
	{
		echo form_open("xray/select_customer",array('id'=>'select_customer_form')); ?>
		<label id="customer_label" for="customer"><?php echo $this->lang->line('invoices_select_customer'); ?></label>
		<?php echo form_input(array('name'=>'customer','id'=>'customer','size'=>'30','value'=>$this->lang->line('invoices_start_typing_customer_name')));?>
		</form>
		
		<div class="clearfix">&nbsp;</div>
		<?php
	}
	?>

	<div id='sale_details'>
		<?php if(isset($consultation))
					echo anchor("xray/view_consultation_notes/$consultation",'Consultation Notes',array('class'=>'thickbox none','title'=>'Consultation Notes'))."<br />";
	?>

		
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
			<div id="finish_sale">
				<?php echo form_open("xray/complete",array('id'=>'finish_invoice_form')); ?>
				<label id="comment_label" for="comment"><?php echo $this->lang->line('common_comments'); ?>:</label>
				<?php echo form_textarea(array('name'=>'comment', 'id' => 'comment', 'value'=>$comment,'rows'=>'4','cols'=>'23'));?>
				<br /><br />
				
				<?php
				echo "<div class='small_button' id='finish_sale_button' style='float:left;margin-top:5px;'><span>".$this->lang->line('invoices_complete_invoice')."</span></div>";
				?>
			</div>
			</form>
        <div id="Cancel_sale">
		<?php echo form_open("xray/cancel_invoice",array('id'=>'cancel_sale_form')); ?>
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

<script type="text/javascript">
function update_result(text)
{
	this.change(function() { 
            $("#").ajaxSubmit(options); 
            return false; 
        });
}
			
</script>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
    $("#item").autocomplete('<?php echo site_url("xray/item_search"); ?>',
    {
    	minChars:0,
    	max:100,
    	selectFirst: false,
       	delay:10,
    	formatItem: function(row) {
			return row[1];
		}
    });
	
	var queue_reload = setInterval(function(){$("#queue_section").load('<?php echo site_url("xray/refresh_queue"); ?>');},10000);

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

    $("#customer").autocomplete('<?php echo site_url("xray/customer_search"); ?>',
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
		$.post('<?php echo site_url("xray/set_comment");?>', {comment: $('#comment').val()});
	});
	
	$('#email_receipt').change(function() 
	{
		$.post('<?php echo site_url("xray/set_email_receipt");?>', {email_receipt: $('#email_receipt').is(':checked') ? '1' : '0'});
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
			$('#finish_invoice_form').attr('action', '<?php echo site_url("xray/suspend"); ?>');
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
