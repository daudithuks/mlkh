<?php
class Invoice extends CI_Model
{
	public function get_info($invoice_id)
	{
		$this->db->from('invoices');
		$this->db->where('invoice_id',$invoice_id);
		return $this->db->get();
	}

	function exists($invoice_id)
	{
		$this->db->from('invoices');
		$this->db->where('invoice_id',$invoice_id);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}
	
	function already_invoiced($customer_id)
	{
		$this->db->from('invoices');
		$this->db->where(array('customer_id'=>$customer_id,'processed'=>'0'));
		$invoice_id = $this->db->get()->row()->invoice_id;
		return $invoice_id;
	}
	
	function already_invoiced_test($customer_id,$department)
	{
		$this->db->from('invoices');
		$this->db->where(array('customer_id'=>$customer_id,'processed'=>'1','department'=>$department));
		$invoice_id = $this->db->get()->row()->invoice_id;
		return $invoice_id;
	}
	
	function update($invoice_data, $invoice_id)
	{
		$this->db->where('invoice_id', $invoice_id);
		$success = $this->db->update('invoices',$invoice_data);
		
		return $success;
	}
	
	function save ($items,$customer_id,$employee_id,$comment,$payments,$invoice_id=false)
	{
		if(count($items)==0)
			return -1;

		//Alain Multiple payments
		//Build payment types string

		$invoices_data = array(
			'invoice_time' => date('Y-m-d H:i:s'),
			'customer_id'=> $this->Customer->exists($customer_id) ? $customer_id : null,
			'employee_id'=>$employee_id,
			'amount'=>$payments,
			'comment'=>$comment
		);

		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
		
		if ($this->already_invoiced($customer_id)){
			$invoice_id = $this->already_invoiced($customer_id);
			$this->update($invoices_data,$invoice_id);
			
			$this->db->where('invoice_id', $invoice_id);
			$this->db->delete("invoices_items");
		}
		else{
			$this->db->insert('invoices',$invoices_data);
			$invoice_id = $this->db->insert_id();
		}


		foreach($items as $line=>$item)
		{
			$cur_item_info = $this->Item->get_info($item['item_id']);

			$invoices_items_data = array
			(
				'invoice_id'=>$invoice_id,
				'item_id'=>$item['item_id'],
				'line'=>$item['line'],
				'description'=>$item['description'],
				'serialnumber'=>$item['serialnumber'],
				'quantity_purchased'=>$item['quantity'],
				'item_cost_price' => $cur_item_info->cost_price,
				'item_unit_price'=>$item['price']
			);
			
			$this->db->insert('invoices_items',$invoices_items_data);

		}
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			return -1;
		}
		
		return $invoice_id;
	}
	
	function save_xray ($items,$customer_id,$employee_id,$comment,$payments,$department=0)
	{
		if(count($items)==0)
			return -1;

		//Alain Multiple payments
		//Build payment types string

		$invoices_data = array(
			'invoice_time' => date('Y-m-d H:i:s'),
			'customer_id'=> $this->Customer->exists($customer_id) ? $customer_id : null,
			'employee_id'=>$employee_id,
			'amount'=>$payments,
			'department'=>$department,
			'comment'=>$comment,
			'processed'=>2,
		);

		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
		
		if ($this->already_invoiced_test($customer_id,$department)){
			$invoice_id = $this->already_invoiced_test($customer_id,$department);
			$this->update($invoices_data,$invoice_id);
			
			$this->db->where('invoice_id', $invoice_id);
			$this->db->delete("invoices_items");
		}
		else{
			$this->db->insert('invoices',$invoices_data);
			$invoice_id = $this->db->insert_id();
		}
		
		$this->db->from("invoices");
		$this->db->where('invoice_id', $invoice_id);
		$consultation_id = $this->db->get()->row()->consultation_id;
		
		if ($consultation_id){
			$status = $this->Consultation->get_status($consultation_id);
			
			switch($status)
			{
				case 101:
					if ($department == "Lab") $status = 102;
				break;
				case 110:
					if ($department == "X-Ray") $status = 120;
				break;
				case 111:
					if ($department == "X-Ray") $status = 121;
					else if ($department == "Lab") $status = 112;
				break;
				case 121:
					if ($department == "Lab") $status = 122;
				break;
				case 112:
					if ($department == "X-Ray") $status = 122;
				break;
			}
			$consultation_data = array(
				'consultation_status'=>$status
			);
		
			$this->db->where('consultation_id',$consultation_id);
			$this->db->update('consultation',$consultation_data);
		}


		foreach($items as $line=>$item)
		{
			$cur_item_info = $this->Item->get_info($item['item_id']);

			$invoices_items_data = array
			(
				'invoice_id'=>$invoice_id,
				'item_id'=>$item['item_id'],
				'line'=>$item['line'],
				'result'=>$item['result'],
				'serialnumber'=>$item['serialnumber'],
				'quantity_purchased'=>$item['quantity'],
				'item_cost_price' => $cur_item_info->cost_price,
				'item_unit_price'=>$item['price']
			);
			$xray_items_data = array
			(
				'invoice_id'=>$invoice_id,
				'item_id'=>$item['item_id'],
				'result'=>$item['result']
			);
			
			$this->db->insert('invoices_items',$invoices_items_data);
			//$this->db->insert('radiology_report',$xray_items_data);

		}
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			return -1;
		}
		
		return $invoice_id;
	}

	function save_lab ($items,$customer_id,$employee_id,$comment,$payments,$department=null)
	{
		if(count($items)==0)
			return -1;

		//Alain Multiple payments
		//Build payment types string

		$invoices_data = array(
			'invoice_time' => date('Y-m-d H:i:s'),
			'customer_id'=> $this->Customer->exists($customer_id) ? $customer_id : null,
			'employee_id'=>$employee_id,
			'amount'=>$payments,
			'department'=>$department,
			'comment'=>$comment,
			'processed'=>2,
		);

		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
		
		if ($this->already_invoiced_test($customer_id,$department)){
			$invoice_id = $this->already_invoiced_test($customer_id,$department);
			$this->update($invoices_data,$invoice_id);
			
			$this->db->where('invoice_id', $invoice_id);
			$this->db->delete("invoices_items");
		}
		else{
			$this->db->insert('invoices',$invoices_data);
			$invoice_id = $this->db->insert_id();
		}

		$this->db->from("invoices");
		$this->db->where('invoice_id', $invoice_id);
		$consultation_id = $this->db->get()->row()->consultation_id;
		
		if ($consultation_id){
			$status = $this->Consultation->get_status($consultation_id);
			
			switch($status)
			{
				case 101:
					if ($department == "Lab") $status = 102;
				break;
				case 110:
					if ($department == "X-Ray") $status = 120;
				break;
				case 111:
					if ($department == "X-Ray") $status = 121;
					else if ($department == "Lab") $status = 112;
				break;
				case 121:
					if ($department == "Lab") $status = 122;
				break;
				case 112:
					if ($department == "X-Ray") $status = 122;
				break;
			}
			$consultation_data = array(
				'consultation_status'=>$status
			);
		
			$this->db->where('consultation_id',$consultation_id);
			$this->db->update('consultation',$consultation_data);
		}
		
		foreach($items as $line=>$item)
		{
			$cur_item_info = $this->Item->get_info($item['item_id']);

			$invoices_items_data = array
			(
				'invoice_id'=>$invoice_id,
				'item_id'=>$item['item_id'],
				'line'=>$item['line'],
				'result'=>$item['result'],
				'serialnumber'=>$item['serialnumber'],
				'quantity_purchased'=>$item['quantity'],
				'item_cost_price' => $cur_item_info->cost_price,
				'item_unit_price'=>$item['price']
			);
			$lab_items_data = array
			(
				'invoice_id'=>$invoice_id,
				'item_id'=>$item['item_id'],
				'result'=>$item['result']
			);
			
			$this->db->insert('invoices_items',$invoices_items_data);
			$this->db->insert('lab_report',$lab_items_data);

		}
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			return -1;
		}
		
		return $invoice_id;
	}

	function save_opd_nursing ($items,$customer_id,$employee_id,$comment,$payments,$department=0)
	{
		if(count($items)==0)
			return -1;

		//Alain Multiple payments
		//Build payment types string

		$invoices_data = array(
			'invoice_time' => date('Y-m-d H:i:s'),
			'customer_id'=> $this->Customer->exists($customer_id) ? $customer_id : null,
			'employee_id'=>$employee_id,
			'amount'=>$payments,
			'department'=>$department,
			'comment'=>$comment,
			'processed'=>2,
		);

		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
		
		if ($this->Consultation->returning($customer_id)){
			$consultation_id = $this->Consultation->returning($customer_id);
			$status = $this->Consultation->get_status($consultation_id);
			
			switch($status)
			{
				case 101:
					if ($department == "Lab") $status = 102;
				break;
				case 110:
					if ($department == "X-Ray") $status = 120;
				break;
				case 111:
					if ($department == "X-Ray") $status = 121;
					else if ($department == "Lab") $status = 112;
				break;
				case 121:
					if ($department == "Lab") $status = 122;
				break;
				case 112:
					if ($department == "X-Ray") $status = 122;
				break;
			}
			$consultation_data = array(
				'consultation_status'=>$status
			);
		
			$this->db->where('consultation_id',$consultation_id);
			$this->db->update('consultation',$consultation_data);
		}
		
		if ($this->already_invoiced_test($customer_id,$department)){
			$invoice_id = $this->already_invoiced_test($customer_id,$department);
			$this->update($invoices_data,$invoice_id);
			
			$this->db->where('invoice_id', $invoice_id);
			$this->db->delete("invoices_items");
		}
		else{
			$this->db->insert('invoices',$invoices_data);
			$invoice_id = $this->db->insert_id();
		}


		foreach($items as $line=>$item)
		{
			$cur_item_info = $this->Item->get_info($item['item_id']);

			$invoices_items_data = array
			(
				'invoice_id'=>$invoice_id,
				'item_id'=>$item['item_id'],
				'line'=>$item['line'],
				'result'=>$item['result'],
				'serialnumber'=>$item['serialnumber'],
				'quantity_purchased'=>$item['quantity'],
				'item_cost_price' => $cur_item_info->cost_price,
				'item_unit_price'=>$item['price']
			);
			$xray_items_data = array
			(
				'invoice_id'=>$invoice_id,
				'item_id'=>$item['item_id'],
				'result'=>$item['result']
			);
			
			$this->db->insert('invoices_items',$invoices_items_data);
			//$this->db->insert('radiology_report',$xray_items_data);

		}
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			return -1;
		}
		
		return $invoice_id;
	}
	
	function get_invoice($customer_id,$employee_id=null)
	{
		if ($employee_id)
			$where = array('customer_id'=>$customer_id,'processed'=>'0','employee_id'=>$employee_id);
		else 
			$where = array('customer_id'=>$customer_id,'processed'=>'0');
		$this->db->from('invoices_items');
		$this->db->join('invoices', 'invoices.invoice_id = invoices_items.invoice_id', $type = 'INNER');
		$this->db->where($where);
		return $this->db->get();
	}
	
	function get_invoice_test($customer_id,$department)
	{
		$where = array('customer_id'=>$customer_id,'department'=>$department,'processed'=>'1');
		$this->db->from('invoices_items');
		$this->db->join('invoices', 'invoices.invoice_id = invoices_items.invoice_id', $type = 'INNER');
		$this->db->where($where);
		return $this->db->get();
	}
	
	function get_invoice_consultation($customer_id,$department){
		$where = array('customer_id'=>$customer_id,'department'=>$department,'processed'=>'1');
		$this->db->from('invoices');
		$this->db->where($where);
		return $this->db->get()->row()->consultation_id;
	}
	
	function get_pharmacy_consultation($customer_id,$department=null){
		$this->db->from('consultation');
		$this->db->join('invoices', 'invoices.consultation_id = consultation.consultation_id');
		$this->db->where('patient_id',$customer_id);
		if ($department) $this->db->where('department',$department);
		$this->db->order_by("consultation.consultation_id", "desc");
		return $this->db->get()->row()->consultation_id;
	}
	
	function get_test_queue($department)
	{
		$this->db->from('invoices');
		$this->db->where('processed', "1");
		$this->db->where('department', "$department");
		$this->db->order_by("invoice_id", "asc");
		$this->db->limit(20);
		
		return $this->db->get()->result_array();
	}
	
	function delete($invoice_id)
	{
		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
		
		$this->db->delete('invoices_items', array('invoice_id' => $invoice_id)); 
		$this->db->delete('invoices', array('invoice_id' => $invoice_id)); 
		
		$this->db->trans_complete();
				
		return $this->db->trans_status();
	}

	function get_invoice_items($invoice_id)
	{
		$this->db->from('invoices_items');
		$this->db->where('invoice_id',$invoice_id);
		return $this->db->get();
	}

	function get_customer($invoice_id)
	{
		$this->db->from('invoices');
		$this->db->where('invoice_id',$invoice_id);
		return $this->Customer->get_info($this->db->get()->row()->customer_id);
	}
	
	

}
?>
