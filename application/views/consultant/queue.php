<?php 
  //get the controller name 
  $CI =& get_instance();
  $controller_name=strtolower(get_class($CI));

 if(!empty($main_queue)){ ?>
<table>
<thead><tr><th>Patient Queue</th></tr></thead>
<tbody>
<?php
foreach($main_queue as $item){
	$patient=$this->Customer->get_info($item['patient_id']);
	$patient_name=$patient->first_name.' '.$patient->middle_name.' '.$patient->last_name;
	$patient_number = $this->Appconfig->get('patient_prefix').$patient->person_id;
	?>
	<tr><td>
    <?php 
    $text = ucwords(strtolower($patient_name))." <span style='font-size:smaller; font-style:italic'>(".$patient_number.")</span>";
	if(!isset($customer))echo anchor($controller_name."/select_customer/".$item['patient_id'],$text,array('title'=>'Open Consultation')); 
	else echo $text;
    ?>
<?php } ?>
</tbody>
</table>
<div class="clearfix" style="margin-bottom:1px;">&nbsp;</div>
<hr />
<?php } ?>

<?php  if(!empty($lab_queue)){ ?>
<table>
<thead><tr><th>Lab Requests</th></tr></thead>
<tbody>
<?php
foreach($lab_queue as $item){
	$patient_id=$this->Customer->get_info($item['patient_id']);
	$patient=$patient_id->first_name.' '.$patient_id->middle_name.' '.$patient_id->last_name;
	$status = ($item['consultation_status']==101||$item['consultation_status']==111||$item['consultation_status']==121)?"pending":"completed";
?>
	<tr><td>
    <?php 
    $text = ucwords(strtolower($patient))." <span style='font-size:smaller; font-style:italic'>(".$status.")</span>";
    if($status=="completed" && !isset($customer)) echo anchor($controller_name."/preview_lab_report/".$item['consultation_id'],$text,array('class'=>'thickbox none','title'=>'Lab Test Report')); 
    else echo $text; ?>
<?php } ?>
</tbody>
</table>
<div class="clearfix" style="margin-bottom:1px;">&nbsp;</div>
<hr />
<?php } ?>
<?php  if(!empty($xray_queue)){ ?>
<table>
<thead><tr><th>X Ray Requests</th></tr></thead>
<tbody>
<?php
foreach($xray_queue as $item){
	$patient_id=$this->Customer->get_info($item['patient_id']);
	$patient=$patient_id->first_name.' '.$patient_id->middle_name.' '.$patient_id->last_name;
	$status = ($item['consultation_status']==110||$item['consultation_status']==111||$item['consultation_status']==112)?"pending":"completed";
?>
    <tr><td>
    <?php 
    $text = ucwords(strtolower($patient))." <span style='font-size:smaller; font-style:italic'>(".$status.")</span>";
    if($status=="completed" && !isset($customer)) echo anchor($controller_name."/preview_xray_report/".$item['consultation_id'],$text,array('class'=>'thickbox none','title'=>'X Ray Report')); 
    else echo $text; ?>
    </td></tr>
<?php } ?>
</tbody>
</table>
<div class="clearfix" style="margin-bottom:1px;">&nbsp;</div>
<hr />
<?php } ?>

<?php  if(!empty($referral_queue)){ ?>
<table>
<thead><tr><th>Referrals</th></tr></thead>
<tbody>
<?php
foreach($referral_queue as $item){
	$patient=$this->Customer->get_info($item['patient_id']);
	$patient_name=$patient->first_name.' '.$patient->middle_name.' '.$patient->last_name;
	$patient_number = $this->Appconfig->get('patient_prefix').$patient->person_id;
	?>
	<tr><td>
    <?php 
    $text = ucwords(strtolower($patient_name))." <span style='font-size:smaller; font-style:italic'>(".$patient_number.")</span>";
	if(!isset($customer))echo anchor($controller_name."/preview_referrer_notes/".$item['consultation_id'],$text,array('class'=>'thickbox none','title'=>'Referral Notes'));
	else echo $text;
	?>
    </td></tr>
<?php } ?>
</tbody>
</table>
<div class="clearfix" style="margin-bottom:1px;">&nbsp;</div>
<hr />
<?php } ?>

<?php  if(!empty($returned_referral_queue)){ ?>
<table>
<thead><tr><th>Returned Referrals</th></tr></thead>
<tbody>
<?php
foreach($returned_referral_queue as $item){
	$patient=$this->Customer->get_info($item['patient_id']);
	$patient_name=$patient->first_name.' '.$patient->middle_name.' '.$patient->last_name;
	$patient_number = $this->Appconfig->get('patient_prefix').$patient->person_id;
	?>
	<tr><td>
    <?php 
    $text = ucwords(strtolower($patient_name))." <span style='font-size:smaller; font-style:italic'>(".$patient_number.")</span>";
	if(!isset($customer))echo anchor($controller_name."/preview_referrer_notes/".$item['referral_consultation'],$text,array('class'=>'thickbox none','title'=>'Consultation Notes'));
	else echo $text;
	?>
    </td></tr>
<?php } ?>
</tbody>
</table>
<div class="clearfix" style="margin-bottom:1px;">&nbsp;</div>
<hr />
<?php } ?>


