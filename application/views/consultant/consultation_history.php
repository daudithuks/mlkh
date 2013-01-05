<?php 
//get the controller name 
  $CI =& get_instance();
  $controller_name=strtolower(get_class($CI));

$this->load->view("partial/header"); ?>
<div id="page_title" style="margin-bottom:8px;">Consultation History</div>
<script type="text/javascript">
$(document).ready(function() 
{ 
    init_table_sorting();
}); 

function init_table_sorting()
{
	//Only init if there is more than one row
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(
		{ 
			sortList: [[0,1]], 
			headers: 
			{ 
				2: { sorter: false},
			} 

		}); 
	}
}

function post_person_form_submit(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);	
	}
	else
	{
		//This is an update, just update one row
		if(jQuery.inArray(response.person_id,get_visible_checkbox_ids()) != -1)
		{
			update_row(response.person_id,'<?php echo site_url("$controller_name/get_row")?>');
			set_feedback(response.message,'success_message',false);	
			
		}
		else //refresh entire table
		{
			do_search(true,function()
			{
				//highlight new row
				hightlight_row(response.person_id);
				set_feedback(response.message,'success_message',false);		
			});
		}
	}
}
</script>

<div id="queue_section">
<?php $this->load->view("consultant/queue"); ?>
</div>

<div id="register_wrapper">
<?php echo $this->pagination->create_links();?>
<div id="table_action_header">

</div>
<div id="table_holder">
<?php echo $manage_table; ?>
</div>
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
		echo form_open($controller_name."/select_customer",array('id'=>'select_customer_form')); ?>
		<label id="customer_label" for="customer">Select Patient</label>
		<?php echo form_input(array('name'=>'customer','id'=>'customer','size'=>'30','value'=>'Start typing patient name'));?>
		</form>
		<?php
	}
	?>

	<!--<div id='sale_details'>
		<div class="float_left" style="width:55%;">Clinical Summary:</div>
		<div class="float_left" style="width:45%;font-weight:bold;"></div>

		
	</div>

	<div class="clearfix" style="margin-bottom:1px;">&nbsp;</div>-->

	<div class="clearfix" style="margin-bottom:1px;">&nbsp;</div>
    
    
    <div class="clearfix" style="margin-bottom:1px;">&nbsp;</div>

	<div id="Cancel_sale">
		<?php echo anchor($controller_name."/","<div class='small_button' style='float:right;margin-top:5px;'><span style='font-size:73%;'>Close</span></div>"); ?>

	</div>
</div>
<div class="clearfix" style="margin-bottom:30px;">&nbsp;</div>

<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>
