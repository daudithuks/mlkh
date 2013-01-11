<?php
require_once ("secure_area.php");
class Sales extends Secure_area
{
	function __construct()
	{
		parent::__construct('sales');
		$this->load->library('sale_lib');
	}

	function index()
	{
		$this->_reload();
	}
	
	function check_collections()
	{
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		$collections = $this->Sale->collections($employee_id);
		$data["message"] = "You have exceeded the maximum collection capacity. Please return the collected amount(".$collections->amount.") to the Accounts Department for clearance.";
		
		//if ($collections->status == 1) $this->load->view("sales/lock",$data);
	}

	function item_search()
	{
		$suggestions = $this->Item->get_item_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		$suggestions = array_merge($suggestions, $this->Item_kit->get_item_kit_search_suggestions($this->input->post('q'),$this->input->post('limit')));
		echo implode("\n",$suggestions);
	}

	function customer_search()
	{
		$suggestions = $this->Customer->get_customer_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}

	function select_customer()
	{
		$customer_id = $this->input->post("customer");
		$this->sale_lib->set_customer($customer_id);
		$this->sale_lib->get_invoice($customer_id);
		//$this->sale_lib->get_waiver($customer_id);
		$this->_reload();
	}
	
	function new_customer()
	{
		$this->load->view("sales/form_basic_info",$data);
	}
	
	function save_customer()
	{
		$person_data = array(
			"first_name" => $this->input->post("first_name"),
			"middle_name" => $this->input->post("middle_name"),
			"last_name" => $this->input->post("last_name"),
			"gender" => $this->input->post("gender"),
			);
		$customer_data = array();
		
		if ($this->Customer->save($person_data,$customer_data))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('customers_successful_adding').' '.
				$person_data['first_name'].' '.$person_data['last_name'],'person_id'=>$customer_data['person_id']));
		}
		else
		{	
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('customers_error_adding_updating').' '.
			$person_data['first_name'].' '.$person_data['last_name'],'person_id'=>-1));
		} 
	}

	function change_mode()
	{
		$mode = $this->input->post("mode");
		$this->sale_lib->set_mode($mode);
		$this->_reload();
	}
	
	function set_comment() 
	{
 	  $this->sale_lib->set_comment($this->input->post('comment'));
	}

	function set_section_queue() 
	{
 	  $this->sale_lib->set_section_queue($this->input->post('section_queue'));
	}
	
	function set_email_receipt()
	{
 	  $this->sale_lib->set_email_receipt($this->input->post('email_receipt'));
	}

	//Alain Multiple Payments
	function add_payment()
	{		
		$data=array();
		$this->form_validation->set_rules('amount_tendered', 'lang:sales_amount_tendered', 'numeric');
		
		if ($this->form_validation->run() == FALSE)
		{
			if ( $this->input->post('payment_type') == $this->lang->line('sales_gift_card') )
				$data['error']=$this->lang->line('sales_must_enter_numeric_giftcard');
			else
				$data['error']=$this->lang->line('sales_must_enter_numeric');
				
 			$this->_reload($data);
 			return;
		}
		
		$payment_type=$this->input->post('payment_type');
		/*if ( $payment_type == $this->lang->line('sales_giftcard') )
		{
			$payments = $this->sale_lib->get_payments();
			$payment_type=$this->input->post('payment_type').':'.$payment_amount=$this->input->post('amount_tendered');
			$current_payments_with_giftcard = isset($payments[$payment_type]) ? $payments[$payment_type]['payment_amount'] : 0;
			$cur_giftcard_value = $this->Giftcard->get_giftcard_value( $this->input->post('amount_tendered') ) - $current_payments_with_giftcard;
			if ( $cur_giftcard_value <= 0 )
			{
				$data['error']='Giftcard balance is '.to_currency( $this->Giftcard->get_giftcard_value( $this->input->post('amount_tendered') ) ).' !';
				$this->_reload($data);
				return;
			}
			elseif ( ( $this->Giftcard->get_giftcard_value( $this->input->post('amount_tendered') ) - $this->sale_lib->get_total() ) > 0 )
			{
				$data['warning']='Giftcard balance is '.to_currency( $this->Giftcard->get_giftcard_value( $this->input->post('amount_tendered') ) - $this->sale_lib->get_total() ).' !';
			}
			$this->select_customer($this->Giftcard->get_giftcard_user( $this->input->post('amount_tendered') ));
			$payment_amount=min( $this->sale_lib->get_total(), $this->Giftcard->get_giftcard_value( $this->input->post('amount_tendered') ) );
		}*/
		
		if ( $payment_type == $this->lang->line('sales_waiver') )
		{
			$payments = $this->sale_lib->get_payments();
			$payment_type=$this->input->post('payment_type').':'.$payment_amount=$this->input->post('amount_tendered');
			$current_payments_with_waiver = isset($payments[$payment_type]) ? $payments[$payment_type]['payment_amount'] : 0;
			$cur_waiver_value = $this->Waiver->get_waiver_value( $this->input->post('amount_tendered') ) - $current_payments_with_waiver;
			$customer = $this->sale_lib->get_customer();
			if ( isset($customer) && $customer != -1 ) 
			{
				if ($customer != $this->Waiver->get_waiver_user( $this->input->post('amount_tendered') ))
				{
					$data['error']='The Waiver serial entered is not valid for this patient!';
					$this->_reload($data);
					return;
				}
			}
			elseif ($customer == -1 )
			{
				$this->sale_lib->set_customer($this->Waiver->get_waiver_user( $this->input->post('amount_tendered') ));
				$this->sale_lib->get_invoice($this->Waiver->get_waiver_user( $this->input->post('amount_tendered') ));
			}
			if ( $cur_waiver_value <= 0 )
			{
				$data['error']='Waiver balance is '.to_currency( $this->Waiver->get_waiver_value( $this->input->post('amount_tendered') ) ).' !';
				$this->_reload($data);
				return;
			}
			elseif ( ( $this->Waiver->get_waiver_value( $this->input->post('amount_tendered') ) - $this->sale_lib->get_total() ) > 0 )
			{
				$data['warning']='Waiver balance is '.to_currency( $this->Waiver->get_waiver_value( $this->input->post('amount_tendered') ) - $this->sale_lib->get_total() ).' !';
			}
			$payment_amount=min( $this->sale_lib->get_total(), $this->Waiver->get_waiver_value( $this->input->post('amount_tendered') ) );
		}
		
		else
		{
			$payment_amount=$this->input->post('amount_tendered');
		}
		
		if( !$this->sale_lib->add_payment( $payment_type, $payment_amount ) )
		{
			$data['error']='Unable to Add Payment! Please try again!';
		}
		
		$this->_reload($data);
	}

	//Alain Multiple Payments
	function delete_payment( $payment_id )
	{
		$this->sale_lib->delete_payment( $payment_id );
		$this->_reload();
	}

	function add()
	{
		$data=array();
		$mode = $this->sale_lib->get_mode();
		$item_id_or_number_or_item_kit_or_receipt = $this->input->post("item");
		$quantity = $mode=="sale" ? 1:-1;

		if($this->sale_lib->is_valid_receipt($item_id_or_number_or_item_kit_or_receipt) && $mode=='return')
		{
			$this->sale_lib->return_entire_sale($item_id_or_number_or_item_kit_or_receipt);
		}
		elseif($this->sale_lib->is_valid_item_kit($item_id_or_number_or_item_kit_or_receipt))
		{
			$this->sale_lib->add_item_kit($item_id_or_number_or_item_kit_or_receipt);
		}
		elseif(!$this->sale_lib->add_item($item_id_or_number_or_item_kit_or_receipt,$quantity))
		{
			$data['error']=$this->lang->line('sales_unable_to_add_item');
		}
		
		if($this->sale_lib->out_of_stock($item_id_or_number_or_item_kit_or_receipt))
		{
			$data['warning'] = $this->lang->line('sales_quantity_less_than_zero');
		}
		$this->_reload($data);
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
			$this->sale_lib->edit_item($line,$description,$serialnumber,$quantity,$discount,$price);
		}
		else
		{
			$data['error']=$this->lang->line('sales_error_editing_item');
		}
		
		if($this->sale_lib->out_of_stock($this->sale_lib->get_item_id($line)))
		{
			$data['warning'] = $this->lang->line('sales_quantity_less_than_zero');
		}


		$this->_reload($data);
	}

	function delete_item($item_number)
	{
		$this->sale_lib->delete_item($item_number);
		$this->_reload();
	}

	function remove_customer()
	{
		$this->sale_lib->remove_customer();
		$this->sale_lib->empty_payments();
		$this->_reload();
	}

	function complete()
	{
		$data['cart']=$this->sale_lib->get_cart();
		$data['subtotal']=$this->sale_lib->get_subtotal();
		$data['taxes']=$this->sale_lib->get_taxes();
		$data['total']=$this->sale_lib->get_total();
		$data['receipt_title']=$this->lang->line('sales_receipt');
		$data['transaction_time']= date('m/d/Y h:i:s a');
		$customer_id=$this->sale_lib->get_customer();
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		$comment = $this->sale_lib->get_comment();
		//$section_queue=$this->sale_lib->get_section_queue();
		$section_queue=$this->input->post('section_queue');
		$emp_info=$this->Employee->get_info($employee_id);
		$data['payments']=$this->sale_lib->get_payments();
		$data['amount_change']=$this->sale_lib->get_amount_due() * -1;
		$data['employee']=$emp_info->first_name.' '.$emp_info->last_name;
		$data['patient_number']=$this->Appconfig->get('patient_prefix').$customer_id;

		if($customer_id!=-1)
		{
			$cust_info=$this->Customer->get_info($customer_id);
			$data['customer']=$cust_info->first_name.' '.$cust_info->last_name;
		}

		//SAVE sale to database
		$data['sale_id']=$this->Appconfig->get('receipt_prefix').$this->Sale->save($section_queue,$data['cart'], $customer_id,$employee_id,$comment,$data['payments']);
		if ($data['sale_id'] == $this->Appconfig->get('receipt_prefix').'-1')
		{
			$data['error_message'] = $this->lang->line('sales_transaction_failed');
		}
		else
		{
			if ($this->sale_lib->get_email_receipt() && !empty($cust_info->email))
			{
				$this->load->library('email');
				$config['mailtype'] = 'html';				
				$this->email->initialize($config);
				$this->email->from($this->config->item('email'), $this->config->item('company'));
				$this->email->to($cust_info->email); 

				$this->email->subject($this->lang->line('sales_receipt'));
				$this->email->message($this->load->view("sales/receipt_email",$data, true));	
				$this->email->send();
			}
		}
		$this->load->view("sales/receipt",$data);
		$this->sale_lib->clear_all();
	}
	
	function receipt($sale_id)
	{
		$sale_info = $this->Sale->get_info($sale_id)->row_array();
		$this->sale_lib->copy_entire_sale($sale_id);
		$data['cart']=$this->sale_lib->get_cart();
		$data['payments']=$this->sale_lib->get_payments();
		$data['subtotal']=$this->sale_lib->get_subtotal();
		$data['taxes']=$this->sale_lib->get_taxes();
		$data['total']=$this->sale_lib->get_total();
		$data['receipt_title']=$this->lang->line('sales_receipt');
		$data['transaction_time']= date('m/d/Y h:i:s a', strtotime($sale_info['sale_time']));
		$customer_id=$this->sale_lib->get_customer();
		$emp_info=$this->Employee->get_info($sale_info['employee_id']);
		$data['payment_type']=$sale_info['payment_type'];
		$data['amount_change']=$this->sale_lib->get_amount_due() * -1;
		$data['employee']=$emp_info->first_name.' '.$emp_info->last_name;
		$data['patient_number']=$this->Appconfig->get('patient_prefix').$customer_id;

		if($customer_id!=-1)
		{
			$cust_info=$this->Customer->get_info($customer_id);
			$data['customer']=$cust_info->first_name.' '.$cust_info->last_name;
		}
		$data['sale_id']=$this->Appconfig->get('receipt_prefix').$sale_id;
		$this->load->view("sales/receipt",$data);
		$this->sale_lib->clear_all();

	}
	
	function edit($sale_id)
	{
		$data = array();

		$data['customers'] = array('' => 'No Customer');
		foreach ($this->Customer->get_all()->result() as $customer)
		{
			$data['customers'][$customer->person_id] = $customer->first_name . ' '. $customer->last_name;
		}

		$data['employees'] = array();
		foreach ($this->Employee->get_all()->result() as $employee)
		{
			$data['employees'][$employee->person_id] = $employee->first_name . ' '. $employee->last_name;
		}

		$data['sale_info'] = $this->Sale->get_info($sale_id)->row_array();
				
		
		$this->load->view('sales/edit', $data);
	}
	
	function delete($sale_id)
	{
		$data = array();
		
		if ($this->Sale->delete($sale_id))
		{
			$data['success'] = true;
		}
		else
		{
			$data['success'] = false;
		}
		
		$this->load->view('sales/delete', $data);
		
	}
	
	function save($sale_id)
	{
		$sale_data = array(
			'sale_time' => date('Y-m-d', strtotime($this->input->post('date'))),
			'customer_id' => $this->input->post('customer_id') ? $this->input->post('customer_id') : null,
			'employee_id' => $this->input->post('employee_id'),
			'comment' => $this->input->post('comment'),
			//'section_queue' => $this->input->post('section_queue')
		);
		
		if ($this->Sale->update($sale_data, $sale_id))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('sales_successfully_updated')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('sales_unsuccessfully_updated')));
		}
	}
	
	function _payments_cover_total()
	{
		$total_payments = 0;

		foreach($this->sale_lib->get_payments() as $payment)
		{
			$total_payments += $payment['payment_amount'];
		}

		/* Changed the conditional to account for floating point rounding */
		if ( ( $this->sale_lib->get_mode() == 'sale' ) && ( ( to_currency_no_money( $this->sale_lib->get_total() ) - $total_payments ) > 1e-6 ) )
		{
			return false;
		}
		
		return true;
	}
	
	function _reload($data=array())
	{
		$this->check_collections();
		
		$customer_id=$this->sale_lib->get_customer();
		if($customer_id!=-1)
		{
			$info=$this->Customer->get_info($customer_id);
			$data['customer']=$info->first_name.' '.$info->last_name;
			$data['customer_email']=$info->email;
			
			$this->sale_lib->get_invoice($customer_id);
			//$this->sale_lib->get_waiver($customer_id);
		}
		
		$person_info = $this->Employee->get_logged_in_employee_info();
		$data['cart']=$this->sale_lib->get_cart();
		$data['modes']=array('sale'=>$this->lang->line('sales_sale'),'return'=>$this->lang->line('sales_return'));
		$data['mode']=$this->sale_lib->get_mode();
		$data['subtotal']=$this->sale_lib->get_subtotal();
		$data['taxes']=$this->sale_lib->get_taxes();
		$data['total']=$this->sale_lib->get_total();
		$data['items_module_allowed'] = $this->Employee->has_permission('items', $person_info->person_id);
		$data['comment'] = $this->sale_lib->get_comment();
		$data['email_receipt'] = $this->sale_lib->get_email_receipt();
		$data['payments_total']=$this->sale_lib->get_payments_total();
		$data['amount_due']=$this->sale_lib->get_amount_due();
		$data['payments']=$this->sale_lib->get_payments();
		$data['payment_options']=array(
			$this->lang->line('sales_cash') => $this->lang->line('sales_cash'),
			$this->lang->line('sales_waiver') => $this->lang->line('sales_waiver'),
			$this->lang->line('sales_nhif') => $this->lang->line('sales_nhif')
		);

		$data['payments_cover_total'] = $this->_payments_cover_total();
		$this->load->view("sales/register",$data);
	}

    function cancel_sale()
    {
    	$this->sale_lib->clear_all();
    	$this->_reload();

    }
	
	function suspend()
	{
		$data['cart']=$this->sale_lib->get_cart();
		$data['subtotal']=$this->sale_lib->get_subtotal();
		$data['taxes']=$this->sale_lib->get_taxes();
		$data['total']=$this->sale_lib->get_total();
		$data['receipt_title']=$this->lang->line('sales_receipt');
		$data['transaction_time']= date('m/d/Y h:i:s a');
		$customer_id=$this->sale_lib->get_customer();
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		$comment = $this->input->post('comment');
		$emp_info=$this->Employee->get_info($employee_id);
		$payment_type = $this->input->post('payment_type');
		$data['payment_type']=$this->input->post('payment_type');
		//Alain Multiple payments
		$data['payments']=$this->sale_lib->get_payments();
		$data['amount_change']=to_currency($this->sale_lib->get_amount_due() * -1);
		$data['employee']=$emp_info->first_name.' '.$emp_info->last_name;

		if($customer_id!=-1)
		{
			$cust_info=$this->Customer->get_info($customer_id);
			$data['customer']=$cust_info->first_name.' '.$cust_info->last_name;
		}

		$total_payments = 0;

		foreach($data['payments'] as $payment)
		{
			$total_payments += $payment['payment_amount'];
		}

		//SAVE sale to database
		$data['sale_id']=$this->Appconfig->get('receipt_prefix').$this->Sale_suspended->save($data['cart'], $customer_id,$employee_id,$comment,$data['payments']);
		if ($data['sale_id'] == $this->Appconfig->get('receipt_prefix').'-1')
		{
			$data['error_message'] = $this->lang->line('sales_transaction_failed');
		}
		$this->sale_lib->clear_all();
		$this->_reload(array('success' => $this->lang->line('sales_successfully_suspended_sale')));
	}
	
	function suspended()
	{
		$data = array();
		$data['suspended_sales'] = $this->Sale_suspended->get_all($this->Employee->get_logged_in_employee_info()->person_id)->result_array();
		$this->load->view('sales/suspended', $data);
	}
	
	function unsuspend()
	{
		$sale_id = $this->input->post('suspended_sale_id');
		$this->sale_lib->clear_all();
		$this->sale_lib->copy_entire_suspended_sale($sale_id);
		$this->Sale_suspended->delete($sale_id);
    	$this->_reload();
	}
}
?>
