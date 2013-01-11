<?php
/*
Gets the html table to manage people.
*/
function get_people_manage_table($people,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	'Name',
	'National ID',
	'Gender',
	'Civil Status',
	$CI->lang->line('common_email'),
	$CI->lang->line('common_phone_number'),
	'&nbsp');
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_people_manage_table_data_rows($people,$controller);
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the people.
*/
function get_people_manage_table_data_rows($people,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($people->result() as $person)
	{
		$table_data_rows.=get_person_data_row($person,$controller);
	}
	
	if($people->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('common_no_persons_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_person_data_row($person,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='person_$person->person_id' value='".$person->person_id."'/></td>";
	$table_data_row.='<td width="20%">'.$person->first_name.' '.$person->middle_name.' '.$person->last_name.'</td>';
	$table_data_row.='<td width="15%">'.character_limiter($person->national_id,10).'</td>';
	$table_data_row.='<td width="10%">'.ucfirst($person->gender).'</td>';
	$table_data_row.='<td width="15%">'.ucfirst($person->civil_status).'</td>';
	$table_data_row.='<td width="20%">'.mailto($person->email,character_limiter($person->email,22)).'</td>';
	$table_data_row.='<td width="15%">'.character_limiter($person->phone_number,15).'</td>';		
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$person->person_id/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}

/*
Gets the html table to manage triage to be added.
*/
function get_add_triage_manage_table($people,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	'Name',
	'Patient Number',
	'Age',
	'Gender',
	'Queue',
	'Queue Position',
	'Clinic',
	'&nbsp');
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_add_triage_manage_table_data_rows($people,$controller);
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the triage to be added.
*/
function get_add_triage_manage_table_data_rows($people,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($people->result() as $person)
	{
		$table_data_rows.=get_add_triage_data_row($person,$controller);
	}
	
	if($people->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='9'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('common_no_persons_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_add_triage_data_row($person,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='2%'><input type='checkbox' id='person_$person->person_id' value='".$person->person_id."'/></td>";
	$table_data_row.='<td width="20%">'.$person->first_name.' '.$person->middle_name.' '.$person->last_name.'</td>';
	$table_data_row.='<td width="10%">'.$CI->Appconfig->get('patient_prefix').$person->person_id.'</td>';
	$table_data_row.='<td width="15%">'.date_diff(date_create(date("Y-m-d")),date_create(date("Y-m-d",strtotime($person->age))))->format('%y yrs %m mths %d days').'</td>';
	$table_data_row.='<td width="5%">'.ucfirst($person->gender).'</td>';
	$table_data_row.='<td width="10%">'.($person->encounter_queue=='Undefined' ? '&nbsp' : $person->encounter_queue).'</td>';
	$table_data_row.='<td width="5%">'.$person->encounter_id.'</td>';
	$table_data_row.='<td width="20%">'.$person->opd_service_name.'</td>';		
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$person->person_id/width:$width", $CI->lang->line('common_add'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_add'))).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}

/*
Gets the html table to manage triage.
*/
function get_view_triage_manage_table($people,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	'Name',
	'Patient Number',
	'Gender',
	'Civil Status',
	'Queue Position',
	$CI->lang->line('common_phone_number'),
	'&nbsp');
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_view_triage_manage_table_data_rows($people,$controller);
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the triage.
*/
function get_view_triage_manage_table_data_rows($people,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($people->result() as $person)
	{
		$table_data_rows.=get_view_triage_data_row($person,$controller);
	}
	
	if($people->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('common_no_persons_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_view_triage_data_row($person,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='person_$person->person_id' value='".$person->person_id."'/></td>";
	$table_data_row.='<td width="20%">'.$person->first_name.' '.$person->middle_name.' '.$person->last_name.'</td>';
	$table_data_row.='<td width="15%">'.$person->person_id.'</td>';
	$table_data_row.='<td width="10%">'.ucfirst($person->gender).'</td>';
	$table_data_row.='<td width="15%">'.ucfirst($person->civil_status).'</td>';
	$table_data_row.='<td width="20%">'.$person->sale_id.'</td>';
	$table_data_row.='<td width="15%">'.character_limiter($person->phone_number,15).'</td>';		
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$person->person_id/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}

function get_admissions_manage_table($people,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	'Name',
	'Patient Number',
	'Age',
	'Gender',
	'Admission Queue',
	'Queue Position',
	'&nbsp',
	'&nbsp',
	);
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_admissions_manage_table_data_rows($people,$controller);
	$table.='</tbody></table>';
	return $table;
}

function get_admissions_manage_table_data_rows($people,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($people->result() as $person)
	{
		$table_data_rows.=get_admissions_data_row($person,$controller);
	}
	
	if($people->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('common_no_persons_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_admissions_data_row($person,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='2%'><input type='checkbox' id='person_$person->person_id' value='".$person->person_id."'/></td>";
	$table_data_row.='<td width="20%">'.$person->first_name.' '.$person->middle_name.' '.$person->last_name.'</td>';
	$table_data_row.='<td width="10%">'.$CI->Appconfig->get('patient_prefix').$person->person_id.'</td>';
	$table_data_row.='<td width="15%">'.date_diff(date_create(date("Y-m-d")),date_create(date("Y-m-d",strtotime($person->age))))->format('%y yrs %m mths %d days').'</td>';
	$table_data_row.='<td width="5%">'.ucfirst($person->gender).'</td>';
	$table_data_row.='<td width="15%">'.$person->queue_admission_department.'</td>';
	$table_data_row.='<td width="5%">'.$person->queue_sale_id.'</td>';
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view_allocate/$person->person_id/".(isset($person->queue_admission_department) ? $person->queue_admission_department : "Undefined")."/width:$width", $CI->lang->line('common_allocate'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_allocate'))).'</td>';		
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$person->person_id/width:$width", $CI->lang->line('common_add'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_add'))).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}

function get_admissions_view_manage_table($people,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	'Name',
	'Patient Number',
	'Gender',
	'Civil Status',
	'Age',
	$CI->lang->line('common_phone_number'),
	'Edit',
	'&nbsp');
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_admissions_view_manage_table_data_rows($people,$controller);
	$table.='</tbody></table>';
	return $table;
}

function get_admissions_view_manage_table_data_rows($people,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($people->result() as $person)
	{
		$table_data_rows.=get_admissions_view_data_row($person,$controller);
	}
	
	if($people->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('common_no_persons_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_admissions_view_data_row($person,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='person_$person->person_id' value='".$person->person_id."'/></td>";
	$table_data_row.='<td width="20%">'.$person->first_name.' '.$person->middle_name.' '.$person->last_name.'</td>';
	$table_data_row.='<td width="15%">'.$CI->Appconfig->get('patient_prefix').$person->person_id.'</td>';
	$table_data_row.='<td width="10%">'.ucfirst($person->gender).'</td>';
	$table_data_row.='<td width="15%">'.ucfirst($person->civil_status).'</td>';
	$table_data_row.='<td width="20%">'.date_diff(date_create(date("Y-m-d")),date_create(date("Y-m-d",strtotime($person->age))))->format('%y yrs %m mths %d days').'</td>';
	$table_data_row.='<td width="15%">'.character_limiter($person->phone_number,15).'</td>';
	$table_data_row.='<td width="10%">'.anchor($controller_name."/view/$person->person_id/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_edit'))).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}
/*
Gets the html table to manage suppliers.
*/
function get_supplier_manage_table($suppliers,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />',
	$CI->lang->line('suppliers_company_name'),
	$CI->lang->line('common_last_name'),
	$CI->lang->line('common_first_name'),
	$CI->lang->line('common_email'),
	$CI->lang->line('common_phone_number'),
	'&nbsp');
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_supplier_manage_table_data_rows($suppliers,$controller);
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the supplier.
*/
function get_supplier_manage_table_data_rows($suppliers,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($suppliers->result() as $supplier)
	{
		$table_data_rows.=get_supplier_data_row($supplier,$controller);
	}
	
	if($suppliers->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('common_no_persons_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_supplier_data_row($supplier,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='person_$supplier->person_id' value='".$supplier->person_id."'/></td>";
	$table_data_row.='<td width="17%">'.character_limiter($supplier->company_name,13).'</td>';
	$table_data_row.='<td width="17%">'.character_limiter($supplier->last_name,13).'</td>';
	$table_data_row.='<td width="17%">'.character_limiter($supplier->first_name,13).'</td>';
	$table_data_row.='<td width="22%">'.mailto($supplier->email,character_limiter($supplier->email,22)).'</td>';
	$table_data_row.='<td width="17%">'.character_limiter($supplier->phone_number,13).'</td>';		
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$supplier->person_id/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}

/*
Gets the html table to manage items.
*/
function get_items_manage_table($items,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	$CI->lang->line('items_item_number'),
	$CI->lang->line('items_name'),
	$CI->lang->line('items_category'),
	$CI->lang->line('items_unit_price'),
	$CI->lang->line('items_quantity'),
	'&nbsp;',
	$CI->lang->line('items_inventory')
	);
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_items_manage_table_data_rows($items,$controller);
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the items.
*/
function get_items_manage_table_data_rows($items,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($items->result() as $item)
	{
		$table_data_rows.=get_item_data_row($item,$controller);
	}
	
	if($items->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('items_no_items_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_item_data_row($item,$controller)
{
	$CI =& get_instance();
	$item_tax_info=$CI->Item_taxes->get_info($item->item_id);
	$tax_percents = '';
	foreach($item_tax_info as $tax_info)
	{
		$tax_percents.=$tax_info['percent']. '%, ';
	}
	$tax_percents=substr($tax_percents, 0, -2);
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='3%'><input type='checkbox' id='item_$item->item_id' value='".$item->item_id."'/></td>";
	$table_data_row.='<td width="15%">'.$item->item_number.'</td>';
	$table_data_row.='<td width="20%">'.$item->name.'</td>';
	$table_data_row.='<td width="14%">'.$item->category.'</td>';
	$table_data_row.='<td width="14%">'.to_currency($item->unit_price).'</td>';
	$table_data_row.='<td width="14%">'.$item->quantity.'</td>';
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$item->item_id/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	
	//Ramel Inventory Tracking
	$table_data_row.='<td width="10%">'.anchor($controller_name."/inventory/$item->item_id/width:$width", $CI->lang->line('common_inv'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_count')))./*'</td>';//inventory count	
	$table_data_row.='<td width="5%">'*/'&nbsp;&nbsp;&nbsp;&nbsp;'.anchor($controller_name."/count_details/$item->item_id/width:$width", $CI->lang->line('common_det'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_details_count'))).'</td>';//inventory details	
	
	$table_data_row.='</tr>';
	return $table_data_row;
}

/*
Gets the html table to manage giftcards.
*/
function get_giftcards_manage_table( $giftcards, $controller )
{
	$CI =& get_instance();
	
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	$CI->lang->line('giftcards_giftcard_number'),
	$CI->lang->line('giftcards_card_value'),
	'&nbsp', 
	);
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_giftcards_manage_table_data_rows( $giftcards, $controller );
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the giftcard.
*/
function get_giftcards_manage_table_data_rows( $giftcards, $controller )
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($giftcards->result() as $giftcard)
	{
		$table_data_rows.=get_giftcard_data_row( $giftcard, $controller );
	}
	
	if($giftcards->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('giftcards_no_giftcards_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_giftcard_data_row($giftcard,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='3%'><input type='checkbox' id='giftcard_$giftcard->giftcard_id' value='".$giftcard->giftcard_id."'/></td>";
	$table_data_row.='<td width="15%">'.$giftcard->giftcard_number.'</td>';
	$table_data_row.='<td width="20%">'.to_currency($giftcard->value).'</td>';
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$giftcard->giftcard_id/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	
	$table_data_row.='</tr>';
	return $table_data_row;
}

/*
Gets the html table to manage waivers.
*/
function get_waivers_manage_table( $waivers, $controller )
{
	$CI =& get_instance();
	
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	'Serial',
	'Patient',
	'Amount',
	'Reason',
	'Date',
	'Waived by',
	'&nbsp', 
	);
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_waivers_manage_table_data_rows( $waivers, $controller );
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the waiver.
*/
function get_waivers_manage_table_data_rows( $waivers, $controller )
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($waivers->result() as $waiver)
	{
		$table_data_rows.=get_waiver_data_row( $waiver, $controller );
	}
	
	if($waivers->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('waivers_no_waivers_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_waiver_data_row($waiver,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='3%'><input type='checkbox' id='waiver_$waiver->waiver_id' value='".$waiver->waiver_id."'/></td>";
	$table_data_row.='<td width="15%">'.$waiver->serial.'</td>';
	$table_data_row.='<td width="15%">'.$waiver->customer.'</td>';
	$table_data_row.='<td width="20%">'.to_currency($waiver->value).'</td>';
	$table_data_row.='<td width="15%">'.$waiver->reason.'</td>';
	$table_data_row.='<td width="15%">'.$waiver->waiver_date.'</td>';
	$table_data_row.='<td width="15%">'.$waiver->employee.'</td>';
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$waiver->waiver_id/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	
	$table_data_row.='</tr>';
	return $table_data_row;
}

/*
Gets the html table to manage item kits.
*/
function get_item_kits_manage_table( $item_kits, $controller )
{
	$CI =& get_instance();
	
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	$CI->lang->line('item_kits_name'),
	$CI->lang->line('item_kits_description'),
	'&nbsp', 
	);
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_item_kits_manage_table_data_rows( $item_kits, $controller );
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the item kits.
*/
function get_item_kits_manage_table_data_rows( $item_kits, $controller )
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($item_kits->result() as $item_kit)
	{
		$table_data_rows.=get_item_kit_data_row( $item_kit, $controller );
	}
	
	if($item_kits->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('item_kits_no_item_kits_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_item_kit_data_row($item_kit,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='3%'><input type='checkbox' id='item_kit_$item_kit->item_kit_id' value='".$item_kit->item_kit_id."'/></td>";
	$table_data_row.='<td width="15%">'.$item_kit->name.'</td>';
	$table_data_row.='<td width="20%">'.character_limiter($item_kit->description, 25).'</td>';
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$item_kit->item_kit_id/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	
	$table_data_row.='</tr>';
	return $table_data_row;
}

function get_consultation_manage_table($consultations,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array(
	'Date',
	'Diagnosed by',
	'&nbsp');
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_consultation_manage_table_data_rows($consultations,$controller);
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the people.
*/
function get_consultation_manage_table_data_rows($consultations,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($consultations->result() as $consultation)
	{
		$table_data_rows.=get_consultation_data_row($consultation,$controller);
	}
	
	if($consultations->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>No previous consultation records</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_consultation_data_row($consultation,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.='<td width="20%">'.$consultation->consultation_time.'</td>';
	$table_data_row.='<td width="65%">'.$consultation->first_name.' '.$consultation->middle_name.' '.$consultation->last_name.'</td>';
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view_summary/$consultation->consultation_id/width:$width", 'View',array('class'=>'thickbox')).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}

?>
