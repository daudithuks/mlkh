<?php
require_once ("secure_area.php");
class opd_nursing extends Secure_area
{
	function __construct()
	{
		parent::__construct('opd_nursing');
		$this->load->library('invoice_lib');
		$this->load->library('consultant_lib');
	}

	function index()
	{
		$this->_reload();
	}

	function service_item_search()
	{
		$suggestions = $this->Item->get_item_search_suggestions_service($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}

	function customer_search()
	{
		$suggestions = $this->Customer->get_customer_search_suggestions_queued($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}

	function select_customer($customer_id = 0)
	{
		if ( !$customer_id )
		{
			if ( $this->input->post("customer") )
			{ 
				$customer_id = $this->input->post("customer");
				$this->invoice_lib->set_customer($customer_id);
				$this->invoice_lib->get_invoice_test($customer_id,"Nursing");
			}
		}
		
		else 
		{
			if ($this->Customer->customer_exists($customer_id) == 1) 
			{
				$this->invoice_lib->set_customer($customer_id);
				$this->invoice_lib->get_invoice_test($customer_id,"Nursing");
			}
		}
		
		$this->_reload();
	}

	function delete_service_item($item_number)
	{
		$this->consultant_lib->delete_lab_item($item_number);
		$this->service_request_form();
		$this->_reload();
	}

	function remove_customer()
	{
		$this->invoice_lib->delete_customer();
		$this->_reload();
	}

	function complete()
	{
		$data['cart']=$this->invoice_lib->get_cart();
		$data['subtotal']=$this->invoice_lib->get_subtotal();
		$data['total']=$this->invoice_lib->get_total();
		$data['receipt_title']=$this->lang->line('invoice_receipt');
		$data['transaction_time']= date('m/d/Y h:i:s a');
		$customer_id=$this->invoice_lib->get_customer();
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		$comment = $this->input->post('comment');
		$emp_info=$this->Employee->get_info($employee_id);
		$data['employee']=$emp_info->first_name.' '.$emp_info->last_name;
		$department="Nursing";

		if($customer_id!=-1)
		{
			$cust_info=$this->Customer->get_info($customer_id);
			$data['customer']=$cust_info->first_name.' '.$cust_info->last_name;
		}

		

		//SAVE invoice to database
		$data['invoice_id']='Invoice '.$this->Invoice->save_opd_nursing($data['cart'], $customer_id,$employee_id,$comment,$data['total'],$department);
		if ($data['invoice_id'] == 'Invoice -1')
		{
			$data['error_message'] = $this->lang->line('invoices_transaction_failed');
		}
		$this->_reload();
		//$this->load->view("opd_nursing/receipt",$data);
		$this->invoice_lib->clear_all();
	}

	function _reload($data=array())
	{
		$person_info = $this->Employee->get_logged_in_employee_info();
		$data['cart']=$this->invoice_lib->get_cart();
		$data['modes']=array('sale'=>$this->lang->line('invoices_invoice'),'return'=>$this->lang->line('invoices_return'));
		$data['mode']=$this->invoice_lib->get_mode();
		$data['subtotal']=$this->invoice_lib->get_subtotal();
		$data['taxes']=$this->invoice_lib->get_taxes();
		$data['total']=$this->invoice_lib->get_total();
		$data['items_module_allowed'] = $this->Employee->has_permission('items', $person_info->person_id);
		//Alain Multiple Payments
		$data['payments_total']=$this->invoice_lib->get_payments_total();
		$data['amount_due']=$this->invoice_lib->get_amount_due();

		$customer_id=$this->invoice_lib->get_customer();
		if($customer_id!=-1)
		{
			$info=$this->Customer->get_info($customer_id);
			$data['customer']=$info->first_name.' '.$info->last_name;
		}
		$this->load->view("opd_nursing/register",$data);
	}

    function cancel_invoice()
    {
    	$this->invoice_lib->clear_all();
    	$this->_reload();

    }

    function service_request($data=array())
	{
		$customer_id=$this->consultant_lib->get_customer();
		$this->consultant_lib->get_service_request($customer_id);
		
		$this->service_request_form();
	}
	
	function service_request_form($data=array())
	{
		
		$customer_id=$this->consultant_lib->get_customer();
		
		$data['service_cart']=$this->consultant_lib->get_service_cart();
		if($customer_id!=-1)
		{
			$info=$this->Customer->get_info_consultation($customer_id);
			
			$data['customer']=$info->first_name.' '.$info->middle_name.' '.$info->last_name;
			$data['patient_id'] = "MLKH".$customer_id;
			$data['age'] = floor((time() - strtotime($info->age))/31536000);
			$data['gender'] = $info->gender;
			$data['blood_pressure'] = $info->blood_pressure;
			$data['temperature'] = $info->temperature;
			$data['pulse_rate'] = $info->pulse_rate;
			$data['weight'] = $info->weight;
			$data['customer_id'] = $customer_id;
		}
		$this->load->view("opd_nursing/invoice",$data);
	}
	
	function add_service_item()
	{
		$data=array();
		$mode = $this->invoice_lib->get_mode();
		$service_item_id  = $this->input->post("item");
		$quantity = $mode=="sale" ? 1:-1;

		if(!$this->invoice_lib->add_item($service_item_id,$quantity))
		{
			$data['error']=$this->lang->line('invoices_unable_to_add_item');
		}
		
		if($this->invoice_lib->out_of_stock($item_id_or_number_or_receipt))
		{
			$data['warning'] = $this->lang->line('invoices_quantity_less_than_zero');
		}
		$this->_reload($data);
		
		//$this->service_request_form($data);
	}
	
	function complete_service_request()
	{
		$data['service_cart']=$this->consultant_lib->get_service_cart();
		$data['total']=$this->consultant_lib->get_service_request_total();
		$customer_id=$this->consultant_lib->get_customer();
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		$comment = $this->input->post('comment');
		$opd_services=$this->input->post('opd_services');
		/*$plaster_of_paris=$opd_services[0];
		$stitching=$opd_services[1];
		$dressing=$opd_services[2];
		$injection=$opd_services[3];*/
		
		$department="Nursing";

		//SAVE invoice to database
		$data['invoice_id']='Invoice '.$this->Consultation->save_request($data['service_cart'], $customer_id,$employee_id,$comment,$data['total'],$department,$opd_services);
		if ($data['invoice_id'] == 'Invoice -1')
		{
			$data['error_message'] = $this->lang->line('invoices_transaction_failed');
		}
		else $data['success'] = "Other Service Request successfully sent";
		
		$this->consultant_lib->clear_service_request();
		$this->_reload($data);
	}
	
	function cancel_service_request()
	{
		$this->consultant_lib->clear_service_request();
    	$this->_reload();
	}

}
?>