<?php
require_once ("secure_area.php");
class Pharmacy_Stock extends Secure_area
{
	function __construct()
	{
		parent::__construct('pharmacy_stock');
		$this->load->library('receiving_lib');
	}

	function index()
	{
		$this->_reload();
	}

	function item_search()
	{
		$suggestions = $this->Item->get_item_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		$suggestions = array_merge($suggestions, $this->Item_kit->get_item_kit_search_suggestions($this->input->post('q'),$this->input->post('limit')));
		echo implode("\n",$suggestions);
	}

	// function supplier_search()
	// {
	// 	$suggestions = $this->Supplier->get_suppliers_search_suggestions($this->input->post('q'),$this->input->post('limit'));
	// 	echo implode("\n",$suggestions);
	// }

	/*/////////// g code //////////////////*/
	function employee_search()
	{
		$suggestions = $this->Receiving->get_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}

	/*///////////end g code ////////////////////////*/

	// function select_supplier()
	// {
	// 	$supplier_id = $this->input->post("supplier");
	// 	$this->receiving_lib->set_supplier($supplier_id);
	// 	$this->_reload();
	// }

	/* ///////////////g code /////////////*/
	//selects employee that's both recieving or being issued to
	function select_recieving_employee($employee_id = 0)
	{
		if (!$employee_id) {
			if ($this->input->post("employee")) {
				$employee_id = $this->input->post("employee");
				$this->receiving_lib->set_recieving_employee($employee_id);
			} 
		}else{
			if ($this->Employee->exists($employee_id) == 1) 
			{
				$this->receiving_lib->set_recieving_employee($employee_id);
			}
		}
		$this->_reload();
	}
	/*///////////////end g code ///////////*/

	function change_mode()
	{
		$mode = $this->input->post("mode");
		$this->receiving_lib->set_mode($mode);
		$this->_reload();
	}

	// function add()
	// {
	// 	$data=array();
	// 	$mode = $this->receiving_lib->get_mode();
	// 	$item_id_or_number_or_item_kit_or_receipt = $this->input->post("item");
	// 	$quantity = $mode=="receive" ? 1:-1;

	// 	if($this->receiving_lib->is_valid_receipt($item_id_or_number_or_item_kit_or_receipt) && $mode=='return')
	// 	{
	// 		$this->receiving_lib->return_entire_receiving($item_id_or_number_or_item_kit_or_receipt);
	// 	}
	// 	elseif($this->receiving_lib->is_valid_item_kit($item_id_or_number_or_item_kit_or_receipt))
	// 	{
	// 		$this->receiving_lib->add_item_kit($item_id_or_number_or_item_kit_or_receipt);
	// 	}
	// 	elseif(!$this->receiving_lib->add_item($item_id_or_number_or_item_kit_or_receipt,$quantity))
	// 	{
	// 		$data['error']=$this->lang->line('recvs_unable_to_add_item');
	// 	}
	// 	$this->_reload($data);
	// }
	/* /////////////////g code /////////////*/
		//need to do a function of this that adds items to array for mode issue
	function doadd()
	{
		$data=array();
		$mode = $this->receiving_lib->get_mode();
		$item_id_or_number_or_item_kit_or_receipt = $this->input->post("item");
		////major problem here///////////should record this negatives or actual submitted data

		$quantity = $mode=="receive" ? 1:-1;

		if($this->receiving_lib->is_valid_receipt($item_id_or_number_or_item_kit_or_receipt) && $mode=='issuing')
		{
			$this->receiving_lib->return_entire_receiving($item_id_or_number_or_item_kit_or_receipt);
		}
		elseif($this->receiving_lib->is_valid_item_kit($item_id_or_number_or_item_kit_or_receipt))
		{
			$this->receiving_lib->add_item_kit($item_id_or_number_or_item_kit_or_receipt);
		}
		elseif(!$this->receiving_lib->add_item($item_id_or_number_or_item_kit_or_receipt,$quantity))
		{
			$data['error']=$this->lang->line('recvs_unable_to_add_item');
		}
		$this->_reload($data);
	}
	/*//////////////////end g code /////////*/
	function edit_item($item_id)
	{
		$data= array();

		//$this->form_validation->set_rules('price', 'lang:items_price', 'required|numeric');
		$this->form_validation->set_rules('quantity', 'lang:items_quantity', 'required|integer');
		//$this->form_validation->set_rules('discount', 'lang:items_discount', 'required|integer');

    	$description = $this->input->post("description");
    	$serialnumber = $this->input->post("serialnumber");
		//$price = $this->input->post("price");
		$quantity = $this->input->post("quantity");
		//$discount = $this->input->post("discount");
		$price = 0;
		$discount = 0;

		if ($this->form_validation->run() != FALSE)
		{
			$this->receiving_lib->edit_item($item_id,$description,$serialnumber,$quantity,$discount,$price);
		}
		else
		{
			$data['error']=$this->lang->line('recvs_error_editing_item');
		}

		$this->_reload($data);
	}
	////////there shall be no editing of the cart ////////////// in my code///// hence should be deleted
	function delete_item($item_number)
	{
		$this->receiving_lib->delete_item($item_number);
		$this->_reload();
	}

	// function delete_supplier()
	// {
	// 	$this->receiving_lib->delete_supplier();
	// 	$this->_reload();
	// }

	/*///////// g code /////////////*/
	function delete_recieving_employee()
	{
		$this->receiving_lib->delete_recieving_employee();
		$this->_reload();
	}
	/*////////end g code ///////////*/

	function complete()
	{
		$data['cart']=$this->receiving_lib->get_cart();
		$data['total']=$this->receiving_lib->get_total();
		$data['receipt_title']=$this->lang->line('recvs_receipt');
		$data['transaction_time']= date('m/d/Y h:i:s a');
		$supplier_id=$this->receiving_lib->get_supplier();
		//g code//
		$recieving_employee_id = $this->receiving_lib->get_recieving_employee();
		//g code //
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		$comment = $this->input->post('comment');
		$emp_info=$this->Employee->get_info($employee_id);
		$payment_type = $this->input->post('payment_type');
		$data['payment_type']=$this->input->post('payment_type');

		if ($this->input->post('amount_tendered'))
		{
			$data['amount_tendered'] = $this->input->post('amount_tendered');
			$data['amount_change'] = to_currency($data['amount_tendered'] - round($data['total'], 2));
		}
		$data['employee']=$emp_info->first_name.' '.$emp_info->last_name;

		if($supplier_id!=-1)
		{
			$suppl_info=$this->Supplier->get_info($supplier_id);
			$data['supplier']=$suppl_info->first_name.' '.$suppl_info->last_name;
		}

		//SAVE receiving to database ////add deparment_id here and in model that saves
		$data['receiving_id']='RECV '.$this->Receiving->save($data['cart'], $recieving_employee_id,$employee_id,$comment,$payment_type);
		
		if ($data['receiving_id'] == 'RECV -1')
		{
			$data['error_message'] = $this->lang->line('receivings_transaction_failed');
		}
		/////this stuff will need to be commented out and the view reloaded
		///$this->_reload($data);
		// $this->load->view("receivings/receipt",$data);
		$this->receiving_lib->clear_all();
		$this->_reload($data);
	}
	//////this function needs to be deleted///////////
	// function receipt($receiving_id)
	// {
	// 	$receiving_info = $this->Receiving->get_info($receiving_id)->row_array();
	// 	$this->receiving_lib->copy_entire_receiving($receiving_id);
	// 	$data['cart']=$this->receiving_lib->get_cart();
	// 	$data['total']=$this->receiving_lib->get_total();
	// 	$data['receipt_title']=$this->lang->line('recvs_receipt');
	// 	$data['transaction_time']= date('m/d/Y h:i:s a', strtotime($receiving_info['receiving_time']));
	// 	$supplier_id=$this->receiving_lib->get_supplier();
	// 	$emp_info=$this->Employee->get_info($receiving_info['employee_id']);
	// 	$data['payment_type']=$receiving_info['payment_type'];

	// 	$data['employee']=$emp_info->first_name.' '.$emp_info->last_name;

	// 	if($supplier_id!=-1)
	// 	{
	// 		$supplier_info=$this->Supplier->get_info($supplier_id);
	// 		$data['supplier']=$supplier_info->first_name.' '.$supplier_info->last_name;
	// 	}
	// 	$data['receiving_id']='RECV '.$receiving_id;
	// 	$this->load->view("receivings/receipt",$data);
	// 	$this->receiving_lib->clear_all();

	// }

	function _reload($data=array())
	{
		$person_info = $this->Employee->get_logged_in_employee_info();
		$data['cart']=$this->receiving_lib->get_cart();
		$data['modes']=array('receive'=>$this->lang->line('recvs_receiving'),'return'=>$this->lang->line('recvs_issuing'));
		$data['mode']=$this->receiving_lib->get_mode();
		$data['items_module_allowed'] = $this->Employee->has_permission('items', $person_info->person_id);
		

		// $supplier_id=$this->receiving_lib->get_supplier();
		// if($supplier_id!=-1)
		// {
		// 	$info=$this->Supplier->get_info($supplier_id);
		// 	$data['supplier']=$info->first_name.' '.$info->last_name;
		// }
		$selected_employee_id = $this->receiving_lib->get_recieving_employee();
		if ($selected_employee_id != -1) {
			$info = $this->Employee->get_info($selected_employee_id);
			$data['selected_employee'] = $info->first_name.' '.$info->last_name;
		}
		$this->load->view("pharmacy_stock/pharmacy_stock",$data);
	}

    function cancel_receiving()
    {
    	$this->receiving_lib->clear_all();
    	$this->_reload();
    }

}
?>