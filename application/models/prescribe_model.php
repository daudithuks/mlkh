<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prescribe_model extends Invoice {
	
	public function save_cart($invoice_data, $cart)
	{
		//save invoice data to get invoice id
		$this->db->trans_start();
		$this->db->insert('invoices',$invoice_data);
	    $invoice_id = $this->db->insert_id();
		$this->db->trans_complete();
		//loop through the recieved array and save each item in array to db
		foreach ($cart as $cart_item) {
			$quantity = $this->get_real_quantity($cart_item['item_id'], $cart_item['dosage']);
			$unit_price= $this->Item->get_info($cart_item['item_id'])->unit_price;
			if ($invoice_id) {
				$invoices_items = array(
				'invoice_id' => $invoice_id,
				'item_id' =>$cart_item['item_id'],
				'description' => "",
				'serialnumber' =>"",
				'line' => 1,
				'quantity_purchased' => $quantity,
				'item_cost_price' => 0.00,
				'item_unit_price' => $unit_price,
				'discount_percent' => 0,
				//'route_of_adm' => $invoice_item_data['route_of_adm'],
				'frequency' => $cart_item['frequency'],
				'dosage' => $cart_item['dosage'],
				'duration' => $cart_item['duration']
					);
				$this->db->trans_start();
				$this->db->insert('invoices_items',$invoices_items);
				$this->db->trans_complete();
				$this->updateItems($cart_item['item_id'], $quantity);
			}
		}

		if ($this->db->trans_status() === FALSE)
		{
			return -1;
		}
		return $invoice_id;
	}
	function get_real_quantity($item_id, $dosage)
	{
		$si_unit= $this->Item->get_info($item_id)->si_unit;
		$name = $this->Item->get_info($item_id)->name;
		if (stripos($name, 'ml')) {
			if ($si_unit == 0) {
				$si_unit = 60.0;
			}
			return ceil($dosage/$si_unit);
		}else{
			return $dosage;
		}
		
		/*
		$position = stripos($name, 'ml')
		if ($pos2 !== false) {
		    echo "We found '$findme' in '$mystring2' at position $pos2";
		}
		*/
		// if (stripos($name, 'AMP', 'Vial',' Bottles', 'Tube', 'Syrup')) {
		// 	//harcoded values ama? 
		// }
		// $prescribe_status = $this->Item->get_info($item_id)->prescribe_status;
	}

	function updateItems($item_id, $current_quantity)
	{
		//setup quantity purchased here
		////deduct from item quantity here
		$quantity_in_stock=$this->Item->get_info($item_id)->quantity;
		$new_quantity = $quantity_in_stock - $current_quantity;
		$item_data = array('quantity' => $new_quantity);
		//$new_result = $this->Item->save($item_data, $item_id);
		$this->db->where('item_id', $item_id);
		///this will only update if prescribe status is 1
		$this->db->where('prescribe_status', 1);
		$result = $this->db->update('items',$item_data);
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}else{
			return FALSE;
		}
	}
	public function update_prescription_items($invoice_item_data)
	{
		$this->db->trans_start();
		$this->db->where('invoice_id', $invoice_item_data['invoice_id']);
		$this->db->update('invoices_items', $invoice_item_data); 
		$this->db->trans_complete();
		if ($this->db->affected_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}
	public function get_prescriptions_for_customer($customer_id)
	{
		$this->db->where('customer_id', $customer_id);
		$this->db->order_by("invoice_time", "desc"); 
		// $this->db->where('processed', 1);//check this in prescribe model to show most relevant
		$q = $this->db->get('prescription_history');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			return $data ;
		}
	}

	public function get_info_by_id($id)
	{
		$q = $this->db->get_where('invoices_items',array('item_id'=>$id));
		if ($q->num_rows() > 0) {
			
			return $row = $q->row();
		}
	}
	public function get_all_routes_of_adm()
	{
		$q = $this->db->get('pharm_route_admin');
		if ($q->num_rows() > 0) {
			foreach ($q->result_array() as $row) {
				$data[$row['route_id']] = $row['name'];
			}
			return $data;
		}
	}

	public function get_all_frequencies()
	{
		$q = $this->db->get('frequency');
		if ($q->num_rows() > 0) {
			foreach ($q->result_array() as $row) {
				$data[$row['frequency_id']] = $row['frequency_name'];
			}
			return $data;
		}
	}

	function get_item_search_suggestions($search,$limit=25)
	{
		$suggestions = array();

		$this->db->from('items');
		$this->db->where('category', 'pharm');
		$this->db->where('deleted',0);
		$this->db->where('unit_price !=',0.00);
		$this->db->like('name', $search);
		$this->db->order_by("name", "asc");
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->item_id.'|'.$row->name;
		}

		$this->db->from('items');
		$this->db->where('category', 'pharm');
		$this->db->where('deleted',0);
		$this->db->like('item_number', $search);
		$this->db->order_by("item_number", "asc");
		$by_item_number = $this->db->get();
		foreach($by_item_number->result() as $row)
		{
			$suggestions[]=$row->item_id.'|'.$row->name;
		}

		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}
	
}

/* End of file prescribe_model.php */
/* Location: ./application/models/prescribe_model.php */
