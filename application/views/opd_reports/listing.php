
<?php $this->load->view("partial/header"); ?>
<div id="page_title" style="margin-bottom:8px;">OPD Reports</div>
<ul id="report_list">
	<li><a href="<?php echo site_url('opd_reports/workload_summary');?>">Workload Summary</a></li>

<li><a href="<?php echo site_url('opd_reports/morbidity_summary');?>">Morbidity Summary</a></li>   
<?php
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}
?>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
});
</script>
