<?php $this->load->view("partial/header"); ?>
<div id="page_title" style="margin-bottom:8px;"><?php echo $this->lang->line('reports_report_input'); ?></div>
<?php
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}
?>
	<?php echo form_label($this->lang->line('reports_date_range'), 'report_date_range_label', array('class'=>'required')); ?>
	<div id='report_date_range_simple'>
		<input type="radio" name="report_type" id="simple_radio" value='simple' checked='checked'/>
		<?php echo form_dropdown('report_date_range_simple',$report_date_range_simple, '', 'id="report_date_range_simple"'); ?>
	</div>
	
	<div id='report_date_range_complex'>
		<input type="radio" name="report_type" id="complex_radio" value='complex' />
		<?php echo form_dropdown('start_month',$months, $selected_month, 'id="start_month"'); ?>
		<?php echo form_dropdown('start_day',$days, $selected_day, 'id="start_day"'); ?>
		<?php echo form_dropdown('start_year',$years, $selected_year, 'id="start_year"'); ?>
		-
		<?php echo form_dropdown('end_month',$months, $selected_month, 'id="end_month"'); ?>
		<?php echo form_dropdown('end_day',$days, $selected_day, 'id="end_day"'); ?>
		<?php echo form_dropdown('end_year',$years, $selected_year, 'id="end_year"'); ?>
	</div>
    
    <?php echo form_label('Age', 'report_age_label', array('class'=>'required')); ?>
	<div id='report_date_range_simple'>
    	<label>
		<input type="radio" name="age_type" id="simple_age" value='simple' checked='checked'/>
		All
        </label>
	</div>
	
	<div id='report_date_range_complex'>
   		<input type="radio" name="age_type" id="complex_age" value='complex' />
		<?php echo form_dropdown('start_age',$age, $selected_age, 'id="start_age"'); ?>
		&ensp;years&emsp;-&emsp;
		<?php echo form_dropdown('end_age',$age, $selected_age, 'id="end_age"'); ?>&ensp;years
   </div>
	

<?php
echo form_button(array(
	'name'=>'generate_report',
	'id'=>'generate_report',
	'content'=>$this->lang->line('common_submit'),
	'class'=>'submit_button')
);
?>

<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	$("#generate_report").click(function()
	{		
		if ($("#simple_radio").attr('checked') && $("#simple_age").attr('checked'))
		{
			window.location = window.location+'/'+$("#report_date_range_simple option:selected").val();
		}
		else if (($("#complex_radio").attr('checked') && $("#simple_age").attr('checked')))
		{
			var start_date = $("#start_year").val()+'-'+$("#start_month").val()+'-'+$('#start_day').val();
			var end_date = $("#end_year").val()+'-'+$("#end_month").val()+'-'+$('#end_day').val();
	
			window.location = window.location+'/'+start_date + '/'+ end_date;
		}
		else if ($("#simple_radio").attr('checked') && $("#complex_age").attr('checked'))
		{
			var start_age = $("#start_age").val();
			var end_age = $("#end_age").val();
			window.location = window.location+'/'+$("#report_date_range_simple option:selected").val() + '/'+ start_age+ '/'+ end_age;
		}
		else
		{
			var start_date = $("#start_year").val()+'-'+$("#start_month").val()+'-'+$('#start_day').val();
			var end_date = $("#end_year").val()+'-'+$("#end_month").val()+'-'+$('#end_day').val();
			var start_age = $("#start_age").val();
			var end_age = $("#end_age").val();
	
			window.location = window.location+'/'+start_date + '/'+ end_date + '/'+ start_age+ '/'+ end_age ;
		}
	});
	
	$("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").click(function()
	{
		$("#complex_radio").attr('checked', 'checked');
	});
	
	$("#start_age, #end_age").click(function()
	{
		$("#complex_age").attr('checked', 'checked');
	});
	
	$("#report_date_range_simple").click(function()
	{
		$("#simple_radio").attr('checked', 'checked');
	});
	
});
</script>