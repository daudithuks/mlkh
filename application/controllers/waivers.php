<?php
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");
class Waivers extends Secure_area implements iData_controller
{
	function __construct()
	{
		parent::__construct('waivers');
		$this->load->library('invoice_lib');
	}

	function index()
	{
		$config['base_url'] = site_url('/waivers/index');
		$config['total_rows'] = $this->Waiver->count_all();
		$config['per_page'] = '20';
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['manage_table']=get_waivers_manage_table( $this->Waiver->get_all( $config['per_page'], $this->uri->segment( $config['uri_segment'] ) ), $this );
		$this->load->view('waivers/manage',$data);
	}

	function search()
	{
		$search=$this->input->post('search');
		$data_rows=get_waivers_manage_table_data_rows($this->Waiver->search($search),$this);
		echo $data_rows;
	}

	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		$suggestions = $this->Waiver->get_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}
	
	function suggest_customer()
	{
		$suggestions = $this->Customer->get_customer_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}

	function get_row()
	{
		$waiver_id = $this->input->post('row_id');
		$data_row=get_waiver_data_row($this->Waiver->get_info($waiver_id),$this);
		echo $data_row;
	}

	function view($waiver_id=-1)
	{
		$data['waiver_info']=$this->Waiver->get_info($waiver_id);

		$this->load->view("waivers/form",$data);
	}
	
	function save($waiver_id=-1)
	{
		if($waiver_id==-1)
		{
			$waiver_data = array(
			'customer_id'=>$this->input->post('customer_id'),
			'employee_id'=>$this->Employee->get_logged_in_employee_info()->person_id,
			'serial'=>$this->serial(),
			'value'=>$this->input->post('value'),
			'reason'=>$this->input->post('reason'),
			);
		}
		else
		{
			$waiver_data = array(
			'customer_id'=>$this->input->post('customer_id'),
			'employee_id'=>$this->Employee->get_logged_in_employee_info()->person_id,
			'value'=>$this->input->post('value'),
			'reason'=>$this->input->post('reason'),
			);
		}

		if( $this->Waiver->save( $waiver_data, $waiver_id ) )
		{
			//New waiver
			if($waiver_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('waivers_successful_adding').' '.
				$waiver_data['waiver_id'],'waiver_id'=>$waiver_data['waiver_id']));
				$waiver_id = $waiver_data['waiver_id'];
			}
			else //previous waiver
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('waivers_successful_updating').' '.
				$waiver_id,'waiver_id'=>$waiver_id));
			}
		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('waivers_error_adding_updating').' '.
			$waiver_data['waiver_id'],'waiver_id'=>-1));
		}

	}
	
	function serial()
	{
		$serials = $this->Waiver->used_serials();
		$serial = mt_rand();
		while ( in_array($serial,$serials) )
		{
			$serial = mt_rand();
		}
		return $serial;
	}

	function delete()
	{
		$waivers_to_delete=$this->input->post('ids');

		if($this->Waiver->delete_list($waivers_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('waivers_successful_deleted').' '.
			count($waivers_to_delete).' '.$this->lang->line('waivers_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('waivers_cannot_be_deleted')));
		}
	}
	
	function select_customer($customer_id = 0)
	{
		if ( !$customer_id )
		{
			if ( $this->input->post("customer") )
			{ 
				$customer_id = $this->input->post("customer");
				$this->invoice_lib->set_customer($customer_id);
				$this->invoice_lib->get_invoice($customer_id);
			}
		}
		
		else 
		{
			if ($this->Customer->customer_exists($customer_id) == 1) 
			{
				$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
				$this->invoice_lib->set_customer($customer_id);
				$this->invoice_lib->get_invoice($customer_id);
			}
		}
		
		$this->_reload();
	}
	
	function edit_item($line)
	{
		$data= array();

		$this->form_validation->set_rules('price', 'lang:items_price', 'required|numeric');
		$this->form_validation->set_rules('quantity', 'lang:items_quantity', 'required|numeric');

        $description = $this->input->post("description");
        $serialnumber = $this->input->post("serialnumber");
		$price = $this->input->post("price");
		$quantity = $this->input->post("quantity");
		$discount = $this->input->post("discount");


		if ($this->form_validation->run() != FALSE)
		{
			$this->invoice_lib->edit_item($line,$description,$serialnumber,$quantity,$discount,$price);
		}
		else
		{
			$data['error']=$this->lang->line('invoices_error_editing_item');
		}
		
		if($this->invoice_lib->out_of_stock($this->invoice_lib->get_item_id($line)))
		{
			$data['warning'] = $this->lang->line('invoices_quantity_less_than_zero');
		}


		$this->_reload($data);
	}

	function delete_item($item_number)
	{
		$this->invoice_lib->delete_item($item_number);
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
		$data['total_discount']=$this->invoice_lib->get_total_discount();
		$data['receipt_title']=$this->lang->line('invoice_receipt');
		$data['transaction_time']= date('m/d/Y h:i:s a');
		$customer_id=$this->invoice_lib->get_customer();
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		$comment = $this->input->post('comment');
		$emp_info=$this->Employee->get_info($employee_id);
		$data['employee']=$emp_info->first_name.' '.$emp_info->last_name;

		if($customer_id!=-1)
		{
			$cust_info=$this->Customer->get_info($customer_id);
			$data['customer']=$cust_info->first_name.' '.$cust_info->last_name;
		}

		

		//SAVE invoice to database
		$data['invoice_id']='Invoice '.$this->Waiver->save($data['cart'], $customer_id,$employee_id,$comment,$data['total_discount']);
		if ($data['invoice_id'] == 'Invoice -1')
		{
			$data['error_message'] = $this->lang->line('invoices_transaction_failed');
		}
		//$this->load->view("invoices/receipt",$data);
		$this->invoice_lib->clear_all();
		
		redirect('waivers');
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
		$this->load->view("waivers/form",$data);
	}

    function cancel_invoice()
    {
    	$this->invoice_lib->clear_all();
    	redirect('waivers');

    }
		
	/*
	get the width for the add/edit form
	*/
	function get_form_width()
	{
		return 360;
	}
}
?>