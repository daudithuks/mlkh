<?php $this->load->view("consultant/consultation_summary"); ?>
<?php
  //get the controller name 
  $CI =& get_instance();
  $controller_name=strtolower(get_class($CI));
 ?>

<div id="Cancel_sale">
	<div class='small_button' id='open_consultation_button' style='float:right;margin-top:5px;'><span style='font-size:73%;'>Open Consultation</span></div>
	<?php echo form_open("$controller_name/select_customer",array('id'=>'preview_lab_report_form')); ?>
	<?php echo form_hidden("customer",$patient_id); ?>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
    $("#open_consultation_button").click(function()
    {
    	$('#preview_lab_report_form').submit();
    });
});
</script>