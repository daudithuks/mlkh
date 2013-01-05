<?php 
  //get the controller name 
  $CI =& get_instance();
  $controller_name=strtolower(get_class($CI));

echo form_open($controller_name."/add_diagnosis",array('id'=>'add_item_form'));?>
<label id="item_label" for="item">

<?php
echo "Diagnosis";
?>
</label>
<?php echo form_input(array('name'=>'item','id'=>'item','size'=>'40','value'=>'Start typing diagnosis'));?>


</form>
<table id="register">
<thead>
<tr>
<th style="width:10%;">Code</th>
<th style="width:65%;">Description</th>
<!--<th style="width:10%;">Primary</th>-->
<th style="width:10%;"></th>
</tr>
</thead>
<tbody id="cart_contents">
<?php
if(count($diagnoses)==0)
{
?>
<tr><td colspan='8'>
<div class='warning_message' style='padding:7px;'>No diagnosis has been entered</div>
</tr></tr>
<?php
}
else
{
	foreach(array_reverse($diagnoses, true) as $line=>$item)
	{
		$cur_item_info = $this->Consultation->get_diagnosis_info($item['diagnosis_code']);
		echo form_open($controller_name."/edit_diagnosis/$line",array('id'=>"save_diagnosis_form_$line"));
	?>
		<tr>
		<td><?php echo $item['diagnosis_code']; ?></td>
		<td style="align:center;"><?php echo $item['description']; ?></td>
        <!--<td style="align:center;"><?php echo form_checkbox(array(
		'name'=>'primary',
		'value'=>'1',
		'checked'=>$item["primary"]=='1'?'checked':'',
		'onchange' => "save_diagnosis($line)"
		));?></td>-->
        
		<td><?php echo anchor($controller_name."/delete_diagnosis/$line",'['.$this->lang->line('common_delete').']');?></td>
		</tr>
		
		<tr style="height:3px">
		<td colspan=8 style="background-color:white"> </td>
		</tr>		</form>
	<?php
	}
}
?>
</tbody>
</table>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
    $("#item").autocomplete('<?php echo site_url($controller_name."/diagnosis_search"); ?>',
    {
    	minChars:0,
    	max:100,
    	selectFirst: false,
       	delay:10,
    	formatItem: function(row) {
			return row[1];
		}
    });

    $("#item").result(function(event, data, formatted)
    {
		$("#add_item_form").ajaxSubmit();
		$("#add_item_form").ajaxComplete(function(){
			$("#diagnosis_tab").load("<?php echo site_url($controller_name."/refresh_diagnosis"); ?>");
		});
    });

	$('#item').blur(function()
    {
    	$(this).attr('value',"Start typing diagnosis");
    });
	
	$('#item').click(function()
    {
    	$(this).attr('value','');
    });
});

function save_diagnosis(line)
{
	$("#save_diagnosis_form_"+line).ajaxSubmit();
	//alert("#save_diagnosis_form_"+line);
}
</script>