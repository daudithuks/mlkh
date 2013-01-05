<?php 
//OJB: Check if for excel export process
if($export_excel == 1){
	ob_start();
	$this->load->view("partial/header_excel");
}else{
	$this->load->view("partial/header");
} 
?>
<div id="page_title" style="margin-bottom:8px;"><?php echo $title ?></div>
<div id="page_subtitle" style="margin-bottom:8px;"><?php echo $subtitle ?></div>
<div id="table_holder">
	<table class="tablesorter report" id="sortable_table">
		<thead>
			<tr>
				
				<th>Classification</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<tr>	
				<td>Over five years</td>
				<td><?php echo $overfive; ?></td>
			</tr>
			<tr>	
				<td>Under five years</td>
				<td><?php echo $underfive; ?></td>
			</tr>
		</tbody>
	</table>
</div>
<?php 
if($export_excel == 1){
	$this->load->view("partial/footer_excel");
	$content = ob_end_flush();
	
	$filename = trim($filename);
	$filename = str_replace(array(' ', '/', '\\'), '', $title);
	$filename .= "_Export.xls";
	header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename='.$filename);
	echo $content;
	die();
	
}else{
	$this->load->view("partial/footer"); 
?>

<script type="text/javascript" language="javascript">
function init_table_sorting()
{
	//Only init if there is more than one row
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(); 
	}
}
$(document).ready(function()
{
	init_table_sorting();
});
</script>
<?php 
} // end if not is excel export 
?>