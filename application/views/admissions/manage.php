<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function() 
{ 
    init_table_sorting();
    enable_select_all();
    enable_row_selection();
    enable_search('<?php echo site_url("$controller_name/suggest")?>','<?php echo $this->lang->line("common_confirm_search")?>');
    enable_email('<?php echo site_url("$controller_name/mailto")?>');
    enable_delete('<?php echo 'Are you sure you want to remove selected patients from the queue?' ?>','<?php echo 'You have not selected any patients to remove from the queue'?>');
	
	$(":radio").click(function()
    {
    	$('#items_filter_form').submit();
    });
}); 

function init_table_sorting()
{
	//Only init if there is more than one row
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(
		{ 
			sortList: [[6,0]], 
			headers: 
			{ 
				0: { sorter: false},
				1: { sorter: false},
				2: { sorter: false},
				3: { sorter: false},
				4: { sorter: false},
				7: { sorter: false},
				8: { sorter: false} 
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

<div id="title_bar">
	<div id="title" class="float_left"><?php echo $this->lang->line('module_'.$controller_name); ?></div>
	
</div>

<div id="search_filter_section" style="background-color:#EEEEEE;">
	<?php echo form_open("$controller_name/refresh",array('id'=>'items_filter_form')); ?>
    <?php echo form_label(' All Queues:', 'all_queues');?>
	<?php echo form_radio(array('name'=>'admission_queue','id'=>'all_queues','value'=>0,'checked'=> isset($admission_queue) ? ($admission_queue == 0 ? 1 : 0 ) : 1 )).' | ';?>
	<?php echo form_label('General OPD:', 'general_queue');?>
	<?php echo form_radio(array('name'=>'admission_queue','id'=>'general_queue','value'=>'General OPD','checked'=> isset($admission_queue)?  ( ($admission_queue == 'General OPD')? 1 : 0) : 0)).' | ';?>
	<?php echo form_label('Paeds:', 'paeds_queue');?>
	<?php echo form_radio(array('name'=>'admission_queue','id'=>'paeds_queue','value'=>'Paeds','checked'=> isset($admission_queue)?  ( ($admission_queue == 'Paeds')? 1 : 0) : 0)).' | ';?>
    <?php echo form_label('MCH:', 'mch_queue');?>
	<?php echo form_radio(array('name'=>'admission_queue','id'=>'mch_queue','value'=>'MCH','checked'=> isset($admission_queue)?  ( ($admission_queue == 'MCH')? 1 : 0) : 0)).' | ';?>
    <?php echo form_label('Special Clinics:', 'special_queue');?>
	<?php echo form_radio(array('name'=>'admission_queue','id'=>'special_queue','value'=>'Special Clinics','checked'=> isset($admission_queue)?  ( ($admission_queue == 'Special Clinics')? 1 : 0) : 0)).' | ';?>
	<input type="hidden" name="search_section_state" id="search_section_state" value="<?php echo isset($search_section_state)?  ( ($search_section_state)? 'block' : 'none') : 'none';?>" />
	</form>
</div>

<?php echo $this->pagination->create_links();?>
<div id="table_action_header">
	<ul>
		<li class="float_left"><span><?php echo anchor("$controller_name/delete",'Remove',array('id'=>'delete')); ?></span></li>
		<li class="float_right">
		<img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
		<?php echo form_open("$controller_name/search",array('id'=>'search_form')); ?><label><strong>Search</strong>
		<input type="text" name ='search' id='search'/></label>
		</form>
		</li>
	</ul>
</div>
<div id="table_holder">
<?php echo $manage_table; ?>
</div>
<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>
