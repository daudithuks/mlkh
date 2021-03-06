<?php 
  //get the controller name 
  $CI =& get_instance();
  $controller_name=strtolower(get_class($CI));

$this->load->view("partial/header"); ?>

<div id="page_title" style="margin-bottom:8px;">Consultation</div>
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


<div id="TabbedPanels1" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab" tabindex="0">Chief Complaints</li>
    <li class="TabbedPanelsTab" tabindex="0">Past Medical History</li>
    <?php  if ($gender == 'female'){ ?>
    <li class="TabbedPanelsTab" tabindex="0">Obst &amp; Gynae History</li>
    <?php  } ?>
    <li class="TabbedPanelsTab" tabindex="0">Family/Social History</li>
    <li class="TabbedPanelsTab" tabindex="0">Examination</li>
    <li class="TabbedPanelsTab" tabindex="0">Diagnosis</li>
    <?php if(isset($customer)) {?><li class="TabbedPanelsTab" tabindex="0">Summary</li><?php } ?>
  </ul>
  <div class="TabbedPanelsContentGroup">
    <div class="TabbedPanelsContent">
    	<?php $this->load->view("consultant/chief_complaints"); ?>
    </div>
    <div class="TabbedPanelsContent"><?php $this->load->view("consultant/medical_history"); ?></div>
    <?php  if ($gender == 'female'){ ?>
    <div class="TabbedPanelsContent"><?php $this->load->view("consultant/obs_gyn"); ?></div>
    <?php  } ?>
    <div class="TabbedPanelsContent"><?php $this->load->view("consultant/family_history"); ?></div>
    <div class="TabbedPanelsContent"><?php $this->load->view("consultant/examination"); ?></div>
    <div class="TabbedPanelsContent" id="diagnosis_tab"><?php $this->load->view("consultant/diagnosis"); ?></div>
    <?php if(isset($customer)){ ?><div class="TabbedPanelsContent" id="summary_tab"><?php $this->load->view("consultant/consultation_summary"); ?></div><?php } ?>
  </div>
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
		<?php echo form_input(array('name'=>'customer','id'=>'customer','size'=>'25','value'=>'Start typing patient name'));?>
		</form>
		<?php
	}
	?>

	<div id="Payment_Types" >

		
			<?php 
			if(isset($customer))
			{
				echo "<div style='height:150px;'>";
				if(isset($referred))
					echo anchor($controller_name."/view_referrer_notes/$referred",'Referral Notes',array('class'=>'thickbox none','title'=>'Referral Notes'))."<br />";
				if(isset($returned_referrals))
					echo anchor($controller_name."/view_referrer_notes/$returned_referrals","Referee's Notes",array('class'=>'thickbox none','title'=>'Consultation Notes'))."<br />";
				echo anchor($controller_name."/consultation_history/",'Consultation History')."<br />";
//&& count($complaints)>0
				if(isset($customer) && isset($consultation_id))
				{
					//echo anchor("lab_request/#",'Lab Test Request',array('class'=>'thickbox none','title'=>'Lab Test Request'))."<br />";
	//				echo anchor("invoices/#",'X Ray Request',array('class'=>'thickbox none','title'=>'X Ray Request'))."<br />";
	//				echo anchor("prescription/#",'Prescribe',array('class'=>'thickbox none','title'=>'Prescription'))."<br />";
					//echo anchor("consultant/#",'Refer Patient',array('class'=>'thickbox none','title'=>'Referral'))."<br />";
					
					if(!isset($lab_request))
						echo anchor($controller_name."/lab_request/",'Lab Test Request')."<br />";
					else echo "<p style='font-size:smaller; font-style:italic'>Pending Lab Test Request</p>";
					if(!isset($xray_request))
						echo anchor($controller_name."/xray_request/",'X Ray Request')."<br />";
					else echo "<p style='font-size:smaller; font-style:italic'>Pending X Ray Request</p>";
					
					echo anchor($controller_name."/service_request/",'Other Services')."<br />";
					
					if (count($diagnoses)>0) echo anchor("prescribe/",'Prescribe')."<br />";
					
					if($lab_report)
						echo anchor($controller_name."/lab_report/",'Lab Report')."<br />";
					if($xray_report)
						echo anchor($controller_name."/xray_report/",'X Ray Report')."<br />";
				}
				echo "</div>";
			}				
				
			?>
			
		
		<div class="clearfix" style="margin-bottom:1px;" style="font-size:smaller; font-style:italic">&nbsp;</div>
	</div>
	<div class="clearfix" style="margin-bottom:1px;">&nbsp;</div>
    
    
    <div class="clearfix" style="margin-bottom:1px;">&nbsp;</div>

			<?php if(isset($customer)){?>
            <div id="finish_sale">
            
            <?php if(isset($consultation_id)){?>
            <?php echo anchor($controller_name."/refer/width:425",
	"<div class='small_button' id='refer_sale_button' style='float:right;margin-top:5px;'><span>Refer</span></div>",
	array('class'=>'thickbox none','title'=>'Refer Patient'));
	?>
    		<?php } ?>
            <div class="clearfix" style="margin-bottom:1px;">&nbsp;</div>
				<?php echo form_open($controller_name."/save_consultation",array('id'=>'save_consultation_form')); ?>	
				<div class='small_button' id='finish_sale_button' style='float:left;margin-top:5px;'><span>Save</span></div>
<?php if(count($complaints)>0){ ?>
            	<div class='small_button' id='discharge_sale_button' style='float:right;margin-top:5px;'><span>Discharge</span></div>
                <?php } ?>
			</div>
            <?php  }  ?>
			</form>
		<div id="Cancel_sale">
		<?php echo form_open($controller_name."/cancel_consultation",array('id'=>'cancel_sale_form')); ?>
        <?php if(isset($customer)){?>
		<div class='small_button' id='close_sale_button' style='float:left;margin-top:5px;'>
			<span>Close</span>
		</div>
        <?php  }  ?>
        <div class='small_button' id='cancel_sale_button' style='float:right;margin-top:5px;'>
			<span>Cancel</span>
		</div>
    	</form>
    	</div>
</div>
<div class="clearfix" style="margin-bottom:30px;">&nbsp;</div>
<div id="feedback_bar"></div>

<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	var queue_reload = setInterval(function(){$("#queue_section").load('<?php echo site_url("$controller_name/refresh_queue"); ?>');},10000);
	var summary_reload = setInterval(function(){$("#summary_tab").load('<?php echo site_url("$controller_name/refresh_summary"); ?>');},2000);
	
	$('#customer').click(function()
    {
    	$(this).attr('value','');
    });

    $("#customer").autocomplete('<?php echo site_url($controller_name."/customer_search"); ?>',
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
    	$(this).attr('value',"Start typing patient name");
    });
	
    $("#finish_sale_button").click(function()
    {
    	if (confirm('Are you sure you want to save this consultation?'))
    	{
    		$('#save_consultation_form').attr('action', '<?php echo site_url($controller_name."/save_consultation"); ?>');
			$('#save_consultation_form').submit();
    	}
    });

	$("#discharge_sale_button").click(function()
	{
		if (confirm('Are you sure you want to discharge this patient? This consultation information will not be made available until a re-visit.'))
    	{
			$('#save_consultation_form').attr('action', '<?php echo site_url($controller_name."/discharge"); ?>');
    		$('#save_consultation_form').submit();
    	}
	});
	
	$("#close_sale_button").click(function()
    {
    	if (confirm('Are you sure you want to close this consultation? The consultation information will be saved.'))
    	{
    		$('#cancel_sale_form').attr('action', '<?php echo site_url($controller_name."/close_consultation"); ?>');
			$('#cancel_sale_form').submit();
    	}
    });

    $("#cancel_sale_button").click(function()
    {
    	if (confirm('Are you sure you want to cancel this consultation? The consultation information will not be saved.'))
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

function post_refer_form_submit(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);	
	}
	else
	{
		set_feedback(response.message,'success_message',false);	
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


var Accordion1 = new Spry.Widget.Accordion("Accordion1");
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
</script>
