<?php 
  //get the controller name 
  $CI =& get_instance();
  $controller_name=strtolower(get_class($CI));

$this->load->view("partial/header"); ?>
<div id="page_title" style="margin-bottom:8px;">Lab Report</div>
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
<?php $this->load->view("consultant/queue"); ?>
</div>

<div id="register_wrapper">
<?php echo form_open("lab_report/add",array('id'=>'add_item_form')); ?>
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
<th style="width:30%;"><?php echo $this->lang->line('invoices_item_number'); ?></th>
<th style="width:35%;"><?php echo $this->lang->line('invoices_item_name'); ?></th>
<th style="width:10%;"><?php //echo $this->lang->line('invoices_price'); ?></th>
<th style="width:10%;"><?php //echo $this->lang->line('invoices_quantity'); ?></th>
<th style="width:35%;"><?php echo $this->lang->line('invoices_results'); ?></th>
<th style="width:15%;"><?php //Secho $this->lang->line('invoices_total'); ?></th>

<th style="width:10%;"></th>
<th style="width:10%;"></th>
</tr>
</thead>
<tbody id="cart_contents">
<?php

if(count($lab_report)==0)
{
?>
<tr><td colspan='8'>
<div class='warning_message' style='padding:7px;'><?php echo $this->lang->line('invoices_no_items_in_cart'); ?></div>
</tr></tr>
<?php
}
else
{
	foreach(array_reverse($lab_report, true) as $line=>$item)
	{
		$cur_item_info = $this->Item->get_info($item['item_id']);
		echo form_open("lab_report/edit_item/$line",array('id'=>'edit_item_form'));
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



		<?php if ($items_module_allowed)
		{
		?>
			<td><?php echo form_hidden(array('name'=>'price','value'=>$item['price'],'size'=>'6'));?></td>
		<?php
		}
		else
		{
		?>
			<td><?php $item['price']; ?></td>
			<?php echo form_hidden('price',$item['price']); ?>
		<?php
		}
		?>

		<td>
		<?php
        	if($item['is_serialized']==1)
        	{
        		 echo $item['quantity'];
        		echo form_hidden('quantity',$item['quantity']);
        	}
        	else
        	{
        		echo form_hidden(array('name'=>'quantity','value'=>$item['quantity'],'size'=>'2'));
        	}
		?>
		</td>

		<td>
		<?php
        		echo $item['result'];
        		//echo form_textarea(array('name'=>'result', 'id' => 'result', 'value'=>$item['result'],'rows'=>'4','cols'=>'23'));
		?>
		</td>

		<td><?php to_currency($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100); ?></td>
		<td><?php //echo form_submit("edit_item", $this->lang->line('invoices_edit_item'));?></td>
		<td><?php anchor("lab_report/delete_item/$line",'['.$this->lang->line('common_delete').']');?></td>
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
		$patient=$this->Customer->get_info($customer_id);
		?>
<table>
	<tr><td><b>Patient Id</b></td><td>:<?php echo $patient_id ?></td></tr>
	<tr><td><b>Name</b></td><td>:<?php echo $patient->first_name.' '.$patient->middle_name.' '.$patient->last_name; ?></td></tr>
	<tr><td><b>Gender</b></td><td>:<?php echo $patient->gender; ?></td></tr>
	<tr><td><b>Age</b></td><td>:<?php echo date_diff(date_create(date("Y-m-d")),date_create(date("Y-m-d",strtotime($patient->age))))->format('%y'); ?></td></tr>
	<tr><td><b>Blood pressure</b></td><td>:<?php echo $blood_pressure ?></td></tr>
	<tr><td><b>SPO2</b></td><td>:<?php echo $temperature ?></td></tr>
	<tr><td><b>Pulse rate</b></td><td>:<?php echo $pulse_rate ?></td></tr>
	<tr><td><b>Weight</b></td><td>:<?php echo $weight ?></td></tr>
</table>
	<?php
        //echo $this->lang->line("sales_customer").': <b>'.$customer. '</b><br />';
		//echo anchor("consultant/remove_customer",'['.$this->lang->line('common_remove').' '.$this->lang->line('customers_customer').']');
	}
	else
	{
		echo form_open("lab_report/select_customer",array('id'=>'select_customer_form')); ?>
		<label id="customer_label" for="customer"><?php echo $this->lang->line('invoices_select_customer'); ?></label>
		<?php echo form_input(array('name'=>'customer','id'=>'customer','size'=>'30','value'=>$this->lang->line('invoices_start_typing_customer_name')));?>
		</form>
		
		<div class="clearfix">&nbsp;</div>
		<?php
	}
	?>

	<div id='sale_details'>
		<div class="float_left" style="width:55%;"><?php  $this->lang->line('invoices_sub_total'); ?></div>
		<div class="float_left" style="width:45%;font-weight:bold;"><?php to_currency($subtotal); ?></div>

		<?php foreach($taxes as $name=>$value) { ?>
		<div class="float_left" style='width:55%;'><?php  $name; ?></div>
		<div class="float_left" style="width:45%;font-weight:bold;"><?php to_currency($value); ?></div>
		<?php }; ?>

		<div class="float_left" style='width:55%;'><?php  $this->lang->line('invoices_total'); ?></div>
		<div class="float_left" style="width:45%;font-weight:bold;"><?php  to_currency($total); ?></div>
	</div>
	
		<div class="clearfix" style="margin-bottom:1px;">&nbsp;</div>

        <div id="Cancel_sale">
		<?php echo anchor($controller_name."/","<div class='small_button' style='float:right;margin-top:5px;'><span style='font-size:73%;'>Close</span></div>"); ?>

	</div>

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
    $("#item").autocomplete('<?php echo site_url("lab/item_search"); ?>',
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

    $("#customer").autocomplete('<?php echo site_url("lab/customer_search"); ?>',
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
		$.post('<?php echo site_url("lab/set_comment");?>', {comment: $('#comment').val()});
	});
	
	$('#email_receipt').change(function() 
	{
		$.post('<?php echo site_url("lab/set_email_receipt");?>', {email_receipt: $('#email_receipt').is(':checked') ? '1' : '0'});
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
			$('#finish_invoice_form').attr('action', '<?php echo site_url("lab/suspend"); ?>');
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
