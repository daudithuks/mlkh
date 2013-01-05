<?php $this->load->view("partial/header"); ?>

<div id="page_title" style="margin-bottom:8px;"><?php echo $this->lang->line('recvs_pharmacy_stock'); ?></div>

<?php
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}
?>



<div id="register_wrapper">
	<?php echo form_open("pharmacy_stock/change_mode",array('id'=>'mode_form')); ?>
		<span><?php echo $this->lang->line('recvs_mode') ?></span>
	<?php echo form_dropdown('mode',$modes,$mode,'onchange="$(\'#mode_form\').submit();"'); ?>
	</form>
	<!-- will be changed to doadd() and the add() eventually -->
	<?php echo form_open("pharmacy_stock/doadd",array('id'=>'add_item_form')); ?>
	<label id="item_label" for="item">

	<?php
	if($mode=='receive')
	{
		echo $this->lang->line('recvs_find_or_scan_item');
	}
	else
	{
		echo $this->lang->line('recvs_find_or_scan_item_or_receipt');
	}
	?>
	</label>
<?php echo form_input(array('name'=>'item','id'=>'item','size'=>'40'));?>

</form>

<!-- Receiving Items List -->

<table id="register">
<thead>
<tr>
<th style="width:11%;"><?php echo $this->lang->line('common_delete'); ?></th>

<th style="width:30%;"><?php echo $this->lang->line('recvs_item_name'); ?></th>
<th style="width:11%;"><?php echo $this->lang->line('recvs_quantity'); ?></th>
<th style="width:11%;"><?php echo $this->lang->line('recvs_edit'); ?></th>
</tr>
</thead>
<tbody id="cart_contents">
<?php
if(count($cart)==0)
{
?>
<tr><td colspan='7'>
<div class='warning_message' style='padding:7px;'><?php echo $this->lang->line('sales_no_items_in_cart'); ?></div>
</tr></tr>
<?php
}
else
{
	foreach(array_reverse($cart, true) as $line=>$item)
	{
		echo form_open("pharmacy_stock/edit_item/$line");
	?>
	<tr>
		<td><?php echo anchor("pharmacy_stock/delete_item/$line",'['.$this->lang->line('common_delete').']');?></td>
		<td style="align:center;"><?php echo $item['name']; ?><br />
		<?php echo $item['description']; echo form_hidden('description',$item['description']); ?><br />
		<td><?php echo form_input(array('name'=>'quantity','value'=>$item['quantity'],'size'=>'2')); ?>	</td>
		<td><?php echo form_submit("edit_item", $this->lang->line('sales_edit_item'));?></td>
	</tr>
		</form>
	<?php
	}
}
?>
</tbody>
</table>
</div>

<!-- Overall Receiving -->

<div id="overall_sale">
	<?php
	if(isset($selected_employee))
	{
		echo $this->lang->line("recvs_employee").': <b>'.$selected_employee. '</b><br />'; //will need to be changed to employee
		echo anchor("pharmacy_stock/delete_recieving_employee",'['.$this->lang->line('recvs_common_delete').' '.$this->lang->line('recvs_employee_employee').']');
	}
	else
	{
		echo form_open("pharmacy_stock/select_recieving_employee",array('id'=>'select_employee_form')); ?>
		<label id="supplier_label" for="employee"><?php echo $this->lang->line('recvs_select_employee'); ?></label>
		<?php echo form_input(array('name'=>'employee','id'=>'employee','size'=>'30','value'=>$this->lang->line('recvs_start_typing_employee_name')));?>
		</form>
		<div class="clearfix">&nbsp;</div>
		<?php
	}
	?>
	<?php
	if(count($cart) > 0)
	{
	?>
	<div id="finish_sale">
		<?php echo form_open("pharmacy_stock/complete",array('id'=>'finish_sale_form')); ?>
        <br />
		<?php echo "<div class='small_button' id='finish_sale_button' style='float:right;margin-top:5px;'><span>".$this->lang->line('recvs_complete_receiving')."</span></div>";
		?>
		</div>

		</form>

	    <?php echo form_open("pharmacy_stock/cancel_receiving",array('id'=>'cancel_sale_form')); ?>
			    <div class='small_button' id='cancel_sale_button' style='float:left;margin-top:5px;'>
					<span>Cancel </span>
				</div>
        </form>
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
    $("#item").autocomplete('<?php echo site_url("pharmacy_stock/item_search"); ?>',
    {
    	minChars:0,
    	max:100,
       	delay:10,
       	selectFirst: false,
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
    	$(this).attr('value',"<?php echo $this->lang->line('sales_start_typing_item_name'); ?>");
    });

	$('#item,#employee').click(function()
    {
    	$(this).attr('value','');
    });
	// enable_search('<?php echo site_url("$controller_name/employee_search")?>','<?php echo $this->lang->line("common_confirm_search")?>');

    $("#employee").autocomplete('<?php echo site_url("pharmacy_stock/employee_search"); ?>',
    {
    	minChars:0,
    	delay:10,
    	max:100,
    	formatItem: function(row) {
    		// console.log(row);
			return row[1];
		}
    });

    $("#employee").result(function(event, data, formatted)
    {
		$("#select_employee_form").submit();
    });

    $('#employee').blur(function()
    {
    	$(this).attr('value',"<?php echo $this->lang->line('recvs_start_typing_employee_name'); ?>");
    });

    $("#finish_sale_button").click(function()
    {
    	if (confirm('<?php echo $this->lang->line("recvs_confirm_finish_receiving"); ?>'))
    	{
    		$('#finish_sale_form').submit();
    	}
    });

    $("#cancel_sale_button").click(function()
    {
    	if (confirm('<?php echo $this->lang->line("recvs_confirm_cancel_receiving"); ?>'))
    	{
    		$('#cancel_sale_form').submit();
    	}
    });


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
		$("#employee").attr("value",response.person_id);
		$("#select_employee_form").submit();
	}
}

</script>