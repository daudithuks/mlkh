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
	$patient=$this->Customer->get_info($item['customer_id']);
	$patient_name=$patient->first_name.' '.$patient->middle_name.' '.$patient->last_name;
	$patient_number = $this->Appconfig->get('patient_prefix').$patient->person_id;
	?>
	<tr><td>
    <?php 
    $text = ucwords(strtolower($patient_name))." <span style='font-size:smaller; font-style:italic'>(".$patient_number.")</span>";
	if(!isset($customer))echo anchor($controller_name."/select_customer/".$item['customer_id'],$text,array('title'=>'Open Request')); 
	else echo $text;
    ?>
<?php } ?>
</tbody>
</table>
<hr />
<?php } ?>