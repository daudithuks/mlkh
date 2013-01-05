<?php $this->load->view("partial/header"); ?>
<div id="page_title" style="margin-bottom:8px;"><?php echo $this->lang->line('reports_reports'); ?></div>
<div id="welcome_message"><?php echo $this->lang->line('reports_welcome_message'); ?>
<ul id="report_list">
	<li><h3>Revenues by Supplier Category</h3>
		<ul>
			<li><?php echo anchor('pharmacyreports/revenue_by_drug_suppliers', 'Revenues'); ?></li>
		</ul>
	</li>
	<li><h3>Revenues by Drug Category</h3>
		<ul>
			<li><?php echo anchor('pharmacyreports/revenue_by_drug_classification', 'Revenues'); ?></li>
		</ul>
	</li>
	<li><h3>Department Consumption</h3>
		<ul>
			<li><?php echo anchor('pharmacyreports/department_consumption', 'Total Consumption'); ?></li>
			<li>Individual Departments</li>
			<?php foreach ($departments as $dept): ?>
				<li><?php echo anchor('pharmacyreports/department_consumption_per_drug/'.$dept->department_id.'', $dept->department_name); ?></li>
			<?php endforeach ?>
		</ul>
	</li>
	<li><h3>Workload</h3>
		<ul>
			<li><?php echo anchor('pharmacyreports/workload', 'Workload'); ?></li>
		</ul>
	</li>
</ul>
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