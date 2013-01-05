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
	<table width="100%" border="1"  class="tablesorter">
		<thead>
			<tr>
            	<th colspan="2">&nbsp;</th>
				<th colspan="3">Under 5 Years</th>
                <th colspan="3">Above 5 Years</th>
                <th rowspan="2">Total</th>
			</tr>
        </thead>
       <tbody>
        	<tr>
            	<th colspan="2">&nbsp;</th>
                <th>Male</th>
                <th>Female</th>
                <th>Sub-Total</th>
                <th>Male</th>
                <th>Female</th>
                <th>Sub-Total</th>
            </tr>
			<tr>
            	<th rowspan="3">General Outpatient</th>
                <th>New</th>
                <td><?php echo $data['general']['new']['child']['male']; ?></td>
                <td><?php echo $data['general']['new']['child']['female']; ?></td>
                <td><?php echo array_sum($data['general']['new']['child']); ?></td>
                <td><?php echo $data['general']['new']['adult']['male']; ?></td>
                <td><?php echo $data['general']['new']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['general']['new']['adult']); ?></td>
                <td><?php echo array_sum($data['general']['new']['adult']) + array_sum($data['general']['new']['child']); ?></td>
            </tr>
            <tr>
            	<th>Revisit</th>
                <td><?php echo $data['general']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['general']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['general']['revisit']['child']); ?></td>
                <td><?php echo $data['general']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['general']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['general']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['general']['revisit']['adult']) + array_sum($data['general']['revisit']['child']); ?></td>
            </tr>
            <tr>
            	<th>Total</th>
                <td><?php echo $data['general']['new']['child']['male'] + $data['general']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['general']['new']['child']['female'] + $data['general']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['general']['new']['child']) + array_sum($data['general']['revisit']['child']); ?></td>
                <td><?php echo $data['general']['new']['adult']['male'] + $data['general']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['general']['new']['adult']['female'] + $data['general']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['general']['new']['adult']) + array_sum($data['general']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['general']['new']['child']) + array_sum($data['general']['revisit']['child']) + array_sum($data['general']['new']['adult']) + array_sum($data['general']['revisit']['adult']); ?></td>
            </tr>
            
            <tr><th colspan="9"  bgcolor="#999999">Special Clinics</th></tr>
            <tr>
            	<th rowspan="3">ENT</th>
                <th>New</th>
                <td><?php echo $data['ent']['new']['child']['male']; ?></td>
                <td><?php echo $data['ent']['new']['child']['female']; ?></td>
                <td><?php echo array_sum($data['ent']['new']['child']); ?></td>
                <td><?php echo $data['ent']['new']['adult']['male']; ?></td>
                <td><?php echo $data['ent']['new']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['ent']['new']['adult']); ?></td>
                <td><?php echo array_sum($data['ent']['new']['adult']) + array_sum($data['ent']['new']['child']); ?></td>
            </tr>
            <tr>
            	<th>Revisit</th>
                <td><?php echo $data['ent']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['ent']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['ent']['revisit']['child']); ?></td>
                <td><?php echo $data['ent']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['ent']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['ent']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['ent']['revisit']['adult']) + array_sum($data['ent']['revisit']['child']); ?></td>
            </tr>
            <tr>
            	<th>Total</th>
                <td><?php echo $data['ent']['new']['child']['male'] + $data['ent']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['ent']['new']['child']['female'] + $data['ent']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['ent']['new']['child']) + array_sum($data['ent']['revisit']['child']); ?></td>
                <td><?php echo $data['ent']['new']['adult']['male'] + $data['ent']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['ent']['new']['adult']['female'] + $data['ent']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['ent']['new']['adult']) + array_sum($data['ent']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['ent']['new']['child']) + array_sum($data['ent']['revisit']['child']) + array_sum($data['ent']['new']['adult']) + array_sum($data['ent']['revisit']['adult']); ?></td>
            </tr>
            
            <tr>
            	<th rowspan="3">Eye</th>
                <th>New</th>
                <td><?php echo $data['eye']['new']['child']['male']; ?></td>
                <td><?php echo $data['eye']['new']['child']['female']; ?></td>
                <td><?php echo array_sum($data['eye']['new']['child']); ?></td>
                <td><?php echo $data['eye']['new']['adult']['male']; ?></td>
                <td><?php echo $data['eye']['new']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['eye']['new']['adult']); ?></td>
                <td><?php echo array_sum($data['eye']['new']['adult']) + array_sum($data['eye']['new']['child']); ?></td>
            </tr>
            <tr>
            	<th>Revisit</th>
                <td><?php echo $data['eye']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['eye']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['eye']['revisit']['child']); ?></td>
                <td><?php echo $data['eye']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['eye']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['eye']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['eye']['revisit']['adult']) + array_sum($data['eye']['revisit']['child']); ?></td>
            </tr>
            <tr>
            	<th>Total</th>
                <td><?php echo $data['eye']['new']['child']['male'] + $data['eye']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['eye']['new']['child']['female'] + $data['eye']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['eye']['new']['child']) + array_sum($data['eye']['revisit']['child']); ?></td>
                <td><?php echo $data['eye']['new']['adult']['male'] + $data['eye']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['eye']['new']['adult']['female'] + $data['eye']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['eye']['new']['adult']) + array_sum($data['eye']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['eye']['new']['child']) + array_sum($data['eye']['revisit']['child']) + array_sum($data['eye']['new']['adult']) + array_sum($data['eye']['revisit']['adult']); ?></td>
            </tr>
            
            <tr>
            	<th rowspan="3">Dental</th>
                <th>New</th>
                <td><?php echo $data['dental']['new']['child']['male']; ?></td>
                <td><?php echo $data['dental']['new']['child']['female']; ?></td>
                <td><?php echo array_sum($data['dental']['new']['child']); ?></td>
                <td><?php echo $data['dental']['new']['adult']['male']; ?></td>
                <td><?php echo $data['dental']['new']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['dental']['new']['adult']); ?></td>
                <td><?php echo array_sum($data['dental']['new']['adult']) + array_sum($data['dental']['new']['child']); ?></td>
            </tr>
            <tr>
            	<th>Revisit</th>
                <td><?php echo $data['dental']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['dental']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['dental']['revisit']['child']); ?></td>
                <td><?php echo $data['dental']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['dental']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['dental']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['dental']['revisit']['adult']) + array_sum($data['dental']['revisit']['child']); ?></td>
            </tr>
            <tr>
            	<th>Total</th>
                <td><?php echo $data['dental']['new']['child']['male'] + $data['dental']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['dental']['new']['child']['female'] + $data['dental']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['dental']['new']['child']) + array_sum($data['dental']['revisit']['child']); ?></td>
                <td><?php echo $data['dental']['new']['adult']['male'] + $data['dental']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['dental']['new']['adult']['female'] + $data['dental']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['dental']['new']['adult']) + array_sum($data['dental']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['dental']['new']['child']) + array_sum($data['dental']['revisit']['child']) + array_sum($data['dental']['new']['adult']) + array_sum($data['dental']['revisit']['adult']); ?></td>
            </tr>
            
            <tr>
            	<th rowspan="3">TB</th>
                <th>New</th>
                <td><?php echo $data['tb']['new']['child']['male']; ?></td>
                <td><?php echo $data['tb']['new']['child']['female']; ?></td>
                <td><?php echo array_sum($data['tb']['new']['child']); ?></td>
                <td><?php echo $data['tb']['new']['adult']['male']; ?></td>
                <td><?php echo $data['tb']['new']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['tb']['new']['adult']); ?></td>
                <td><?php echo array_sum($data['tb']['new']['adult']) + array_sum($data['tb']['new']['child']); ?></td>
            </tr>
            <tr>
            	<th>Revisit</th>
                <td><?php echo $data['tb']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['tb']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['tb']['revisit']['child']); ?></td>
                <td><?php echo $data['tb']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['tb']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['tb']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['tb']['revisit']['adult']) + array_sum($data['tb']['revisit']['child']); ?></td>
            </tr>
            <tr>
            	<th>Total</th>
                <td><?php echo $data['tb']['new']['child']['male'] + $data['tb']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['tb']['new']['child']['female'] + $data['tb']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['tb']['new']['child']) + array_sum($data['tb']['revisit']['child']); ?></td>
                <td><?php echo $data['tb']['new']['adult']['male'] + $data['tb']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['tb']['new']['adult']['female'] + $data['tb']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['tb']['new']['adult']) + array_sum($data['tb']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['tb']['new']['child']) + array_sum($data['tb']['revisit']['child']) + array_sum($data['tb']['new']['adult']) + array_sum($data['tb']['revisit']['adult']); ?></td>
            </tr>
            
            <tr>
            	<th rowspan="3">Orthopaedic</th>
                <th>New</th>
                <td><?php echo $data['orthopaedic']['new']['child']['male']; ?></td>
                <td><?php echo $data['orthopaedic']['new']['child']['female']; ?></td>
                <td><?php echo array_sum($data['orthopaedic']['new']['child']); ?></td>
                <td><?php echo $data['orthopaedic']['new']['adult']['male']; ?></td>
                <td><?php echo $data['orthopaedic']['new']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['orthopaedic']['new']['adult']); ?></td>
                <td><?php echo array_sum($data['orthopaedic']['new']['adult']) + array_sum($data['orthopaedic']['new']['child']); ?></td>
            </tr>
            <tr>
            	<th>Revisit</th>
                <td><?php echo $data['orthopaedic']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['orthopaedic']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['orthopaedic']['revisit']['child']); ?></td>
                <td><?php echo $data['orthopaedic']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['orthopaedic']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['orthopaedic']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['orthopaedic']['revisit']['adult']) + array_sum($data['orthopaedic']['revisit']['child']); ?></td>
            </tr>
            <tr>
            	<th>Total</th>
                <td><?php echo $data['orthopaedic']['new']['child']['male'] + $data['orthopaedic']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['orthopaedic']['new']['child']['female'] + $data['orthopaedic']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['orthopaedic']['new']['child']) + array_sum($data['orthopaedic']['revisit']['child']); ?></td>
                <td><?php echo $data['orthopaedic']['new']['adult']['male'] + $data['orthopaedic']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['orthopaedic']['new']['adult']['female'] + $data['orthopaedic']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['orthopaedic']['new']['adult']) + array_sum($data['orthopaedic']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['orthopaedic']['new']['child']) + array_sum($data['orthopaedic']['revisit']['child']) + array_sum($data['orthopaedic']['new']['adult']) + array_sum($data['orthopaedic']['revisit']['adult']); ?></td>
            
            <tr><th colspan="9"  bgcolor="#999999">MCH Clinics</th></tr>
            <tr>
            	<th rowspan="3">CWC</th>
                <th>New</th>
                <td><?php echo $data['cwc']['new']['child']['male']; ?></td>
                <td><?php echo $data['cwc']['new']['child']['female']; ?></td>
                <td><?php echo array_sum($data['cwc']['new']['child']); ?></td>
                <td><?php echo $data['cwc']['new']['adult']['male']; ?></td>
                <td><?php echo $data['cwc']['new']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['cwc']['new']['adult']); ?></td>
                <td><?php echo array_sum($data['cwc']['new']['adult']) + array_sum($data['cwc']['new']['child']); ?></td>
            </tr>
            <tr>
            	<th>Revisit</th>
                <td><?php echo $data['cwc']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['cwc']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['cwc']['revisit']['child']); ?></td>
                <td><?php echo $data['cwc']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['cwc']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['cwc']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['cwc']['revisit']['adult']) + array_sum($data['cwc']['revisit']['child']); ?></td>
            </tr>
            <tr>
            	<th>Total</th>
                <td><?php echo $data['cwc']['new']['child']['male'] + $data['cwc']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['cwc']['new']['child']['female'] + $data['cwc']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['cwc']['new']['child']) + array_sum($data['cwc']['revisit']['child']); ?></td>
                <td><?php echo $data['cwc']['new']['adult']['male'] + $data['cwc']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['cwc']['new']['adult']['female'] + $data['cwc']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['cwc']['new']['adult']) + array_sum($data['cwc']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['cwc']['new']['child']) + array_sum($data['cwc']['revisit']['child']) + array_sum($data['cwc']['new']['adult']) + array_sum($data['cwc']['revisit']['adult']); ?></td>
            </tr>
            
            <tr>
            	<th rowspan="3">ANC</th>
                <th>New</th>
                <td><?php echo $data['anc']['new']['child']['male']; ?></td>
                <td><?php echo $data['anc']['new']['child']['female']; ?></td>
                <td><?php echo array_sum($data['anc']['new']['child']); ?></td>
                <td><?php echo $data['anc']['new']['adult']['male']; ?></td>
                <td><?php echo $data['anc']['new']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['anc']['new']['adult']); ?></td>
                <td><?php echo array_sum($data['anc']['new']['adult']) + array_sum($data['anc']['new']['child']); ?></td>
            </tr>
            <tr>
            	<th>Revisit</th>
                <td><?php echo $data['anc']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['anc']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['anc']['revisit']['child']); ?></td>
                <td><?php echo $data['anc']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['anc']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['anc']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['anc']['revisit']['adult']) + array_sum($data['anc']['revisit']['child']); ?></td>
            </tr>
            <tr>
            	<th>Total</th>
                <td><?php echo $data['anc']['new']['child']['male'] + $data['anc']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['anc']['new']['child']['female'] + $data['anc']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['anc']['new']['child']) + array_sum($data['anc']['revisit']['child']); ?></td>
                <td><?php echo $data['anc']['new']['adult']['male'] + $data['anc']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['anc']['new']['adult']['female'] + $data['anc']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['anc']['new']['adult']) + array_sum($data['anc']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['anc']['new']['child']) + array_sum($data['anc']['revisit']['child']) + array_sum($data['anc']['new']['adult']) + array_sum($data['anc']['revisit']['adult']); ?></td>
            </tr>
            
            <tr>
            	<th rowspan="3">PNC</th>
                <th>New</th>
                <td><?php echo $data['pnc']['new']['child']['male']; ?></td>
                <td><?php echo $data['pnc']['new']['child']['female']; ?></td>
                <td><?php echo array_sum($data['pnc']['new']['child']); ?></td>
                <td><?php echo $data['pnc']['new']['adult']['male']; ?></td>
                <td><?php echo $data['pnc']['new']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['pnc']['new']['adult']); ?></td>
                <td><?php echo array_sum($data['pnc']['new']['adult']) + array_sum($data['pnc']['new']['child']); ?></td>
            </tr>
            <tr>
            	<th>Revisit</th>
                <td><?php echo $data['pnc']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['pnc']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['pnc']['revisit']['child']); ?></td>
                <td><?php echo $data['pnc']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['pnc']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['pnc']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['pnc']['revisit']['adult']) + array_sum($data['pnc']['revisit']['child']); ?></td>
            </tr>
            <tr>
            	<th>Total</th>
                <td><?php echo $data['pnc']['new']['child']['male'] + $data['pnc']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['pnc']['new']['child']['female'] + $data['pnc']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['pnc']['new']['child']) + array_sum($data['pnc']['revisit']['child']); ?></td>
                <td><?php echo $data['pnc']['new']['adult']['male'] + $data['pnc']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['pnc']['new']['adult']['female'] + $data['pnc']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['pnc']['new']['adult']) + array_sum($data['pnc']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['pnc']['new']['child']) + array_sum($data['pnc']['revisit']['child']) + array_sum($data['pnc']['new']['adult']) + array_sum($data['pnc']['revisit']['adult']); ?></td>
            </tr>
            
            <tr>
            	<th rowspan="3">FP</th>
                <th>New</th>
                <td><?php echo $data['fp']['new']['child']['male']; ?></td>
                <td><?php echo $data['fp']['new']['child']['female']; ?></td>
                <td><?php echo array_sum($data['fp']['new']['child']); ?></td>
                <td><?php echo $data['fp']['new']['adult']['male']; ?></td>
                <td><?php echo $data['fp']['new']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['fp']['new']['adult']); ?></td>
                <td><?php echo array_sum($data['fp']['new']['adult']) + array_sum($data['fp']['new']['child']); ?></td>
            </tr>
            <tr>
            	<th>Revisit</th>
                <td><?php echo $data['fp']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['fp']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['fp']['revisit']['child']); ?></td>
                <td><?php echo $data['fp']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['fp']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['fp']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['fp']['revisit']['adult']) + array_sum($data['fp']['revisit']['child']); ?></td>
            </tr>
            <tr>
            	<th>Total</th>
                <td><?php echo $data['fp']['new']['child']['male'] + $data['fp']['revisit']['child']['male']; ?></td>
                <td><?php echo $data['fp']['new']['child']['female'] + $data['fp']['revisit']['child']['female']; ?></td>
                <td><?php echo array_sum($data['fp']['new']['child']) + array_sum($data['fp']['revisit']['child']); ?></td>
                <td><?php echo $data['fp']['new']['adult']['male'] + $data['fp']['revisit']['adult']['male']; ?></td>
                <td><?php echo $data['fp']['new']['adult']['female'] + $data['fp']['revisit']['adult']['female']; ?></td>
                <td><?php echo array_sum($data['fp']['new']['adult']) + array_sum($data['fp']['revisit']['adult']); ?></td>
                <td><?php echo array_sum($data['fp']['new']['child']) + array_sum($data['fp']['revisit']['child']) + array_sum($data['fp']['new']['adult']) + array_sum($data['fp']['revisit']['adult']); ?></td>
            </tr>
		</tbody>
	</table>
</div>
<div id="report_summary">
<?php foreach($summary_data as $name=>$value) { ?>
	<div class="summary_row"><?php echo $this->lang->line('reports_'.$name). ': '.to_currency($value); ?></div>
<?php }?>
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