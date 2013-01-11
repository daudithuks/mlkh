<?php $this->load->view("partial/header"); ?>
<div id="report_register_wrapper">

<table id="register">
<thead>
<tr>
<th style="width:15%;"><?php echo $this->lang->line('invoices_item_number'); ?></th>
<th style="width:35%;"><?php echo $this->lang->line('invoices_item_name'); ?></th>
<th style="width:10%;"><?php echo $this->lang->line('invoices_price'); ?></th>
<th style="width:10%;"><?php echo $this->lang->line('invoices_quantity'); ?></th>
<th style="width:10%;"><?php echo $this->lang->line('invoices_discount'); ?></th>
<th style="width:15%;"><?php echo $this->lang->line('invoices_total'); ?></th>

<th style="width:5%;"></th>
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
		echo form_open("waivers/edit_item/$line",array('id'=>'edit_item_form'));
	?>
		<tr>
		<td><?php echo $cur_item_info->item_number; ?></td>
		<td style="align:center;"><?php echo $cur_item_info->name; ?><br />
        <?php
			if($item['is_serialized']==1)
        	{
				echo '<font color="2F4F4F">'.$this->lang->line('invoices_serial').':</font>'.$item['serialnumber'];
			}
		?>
        </td>



		<td><?php echo $item['price']; echo form_hidden('price',$item['price']);?></td>
		

		<td>
		<?php
        	echo $item['quantity'];
        	echo form_hidden('quantity',$item['quantity']);
		?>
		</td>
        
        <td>
		<?php
        	echo form_input(array('name'=>'discount','value'=>$item['discount'],'size'=>'4'));
		?>
		</td>
        
        <td><?php echo to_currency($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100); ?></td>
		<td><?php echo form_submit("edit_item", $this->lang->line('invoices_edit_item'));?></td>
		<td><?php anchor("invoice/delete_item/$line",'['.$this->lang->line('common_delete').']');?></td>
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


<div id="overall_consultation">
	<?php
	if(isset($customer))
	{
		echo $this->lang->line("invoices_customer").': <b>'.$customer. '</b><br />';
		echo anchor("waivers/remove_customer",'['.$this->lang->line('common_remove').' '.$this->lang->line('customers_customer').']');
	}
	else
	{
		echo form_open("waivers/select_customer",array('id'=>'select_customer_form')); ?>
		<label id="customer_label" for="customer"><?php echo $this->lang->line('invoices_select_customer'); ?></label>
		<?php echo form_input(array('name'=>'customer','id'=>'customer','size'=>'30','value'=>$this->lang->line('invoices_start_typing_customer_name')));?>
		</form>
		
		<div class="clearfix">&nbsp;</div>
		<?php
	}
	?>

	<div id='sale_details'>
		<div class="float_left" style="width:55%;"><?php echo $this->lang->line('invoices_sub_total'); ?>:</div>
		<div class="float_left" style="width:45%;font-weight:bold;"><?php echo to_currency($subtotal); ?></div>

		<?php foreach($taxes as $name=>$value) { ?>
		<div class="float_left" style='width:55%;'><?php echo $name; ?>:</div>
		<div class="float_left" style="width:45%;font-weight:bold;"><?php echo to_currency($value); ?></div>
		<?php }; ?>

		<div class="float_left" style='width:55%;'><?php echo $this->lang->line('invoices_total'); ?>:</div>
		<div class="float_left" style="width:45%;font-weight:bold;"><?php echo to_currency($total); ?></div>
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
				<?php echo form_open("waivers/complete",array('id'=>'finish_invoice_form')); ?>
				<label id="comment_label" for="comment"><?php echo $this->lang->line('common_comments'); ?>:</label>
				<?php echo form_textarea(array('name'=>'comment', 'id' => 'comment', 'value'=>$comment,'rows'=>'4','cols'=>'23'));?>
				<br /><br />
				
				<?php
				echo "<div class='small_button' id='finish_sale_button' style='float:left;margin-top:5px;'><span>".$this->lang->line('invoices_complete_invoice')."</span></div>";
				?>
			</div>
			</form>
        <div id="Cancel_sale">
		<?php echo form_open("waivers/cancel_invoice",array('id'=>'cancel_sale_form')); ?>
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
   
	$('#customer').click(function()
    {
    	$(this).attr('value','');
    });

    $("#customer").result(function(event, data, formatted)
    {
		$("#select_customer_form").submit();
    });

    $('#customer').blur(function()
    {
    	$(this).attr('value',"<?php echo $this->lang->line('invoices_start_typing_customer_name'); ?>");
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
});
</script>