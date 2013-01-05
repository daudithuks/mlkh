<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dispensing_model extends CI_Model {

	public function get_customer_history($customer_id)
	{
		$this->db->where('customer_id', $customer_id);
		$this->db->where('processed', 2);
		$this->db->order_by("invoice_time", "desc"); 
		$q = $this->db->get('prescription_history');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			return $data ;
		}
	}
	public function get_prescriptions_for_customer($customer_id)
	{
		$this->db->where('customer_id', $customer_id);
		$this->db->where('processed', 1);
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
	public function get_invoice_id_by_customer_id($customer_id ='-1')
	{
		if ($customer_id == '-1') {
			return FALSE;
		}else{
			$this->db->where('customer_id', $current_id);
			$this->db->where('processed', 1);
			$q = $this->db->get('invoices');
			if ($q->num_rows() > 0)
			{
			   $row = $query->row(); 

			   return $row->invoice_id;
			}
		}
	}
	public function update_prescription_invoice($invoice_data, $customer_id = '-1')
	{
		if ($customer_id == '-1' || FALSE) {
			return FALSE;
		}else{
			$this->db->trans_start();
			$this->db->where('customer_id', $customer_id);
			$this->db->where('processed', 1);
			$this->db->update('invoices', $invoice_data); 
			$this->db->trans_complete();
			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}
	
	function get_customer_search_suggestions_dispensing($search,$limit=25)
	{
		$suggestions = array();
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');
		$this->db->join('invoices','customers.person_id=invoices.customer_id');
		$this->db->where("department",'Pharmacy');
		$this->db->where("department",'Pharmacy');
		$this->db->where("(first_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		last_name LIKE '%".$this->db->escape_like_str($search)."%' or middle_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");
		$this->db->order_by("last_name", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->person_id.'|'.$row->first_name.' '.$row->last_name;		
		}
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');
		$this->db->join('invoices','customers.person_id=invoices.customer_id');
		$this->db->where("department",'Pharmacy');
		$this->db->where("processed",'1');
		$this->db->where('deleted',0);		
		$this->db->like("customers.person_id",str_ireplace("MLKH","",$search));
		$this->db->order_by("customers.person_id", "asc");		
		$by_person_id = $this->db->get();
		foreach($by_person_id->result() as $row)
		{
			$suggestions[]=$row->person_id.'|'.$this->Appconfig->get('patient_prefix').$row->person_id;
		}
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');
		$this->db->join('invoices','customers.person_id=invoices.customer_id');
		$this->db->where("department",'Pharmacy');
		$this->db->where("processed",'1');
		$this->db->where('deleted',0);		
		$this->db->like("account_number",$search);
		$this->db->order_by("account_number", "asc");		
		$by_account_number = $this->db->get();
		foreach($by_account_number->result() as $row)
		{
			$suggestions[]=$row->person_id.'|'.$row->account_number;
		}
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');
		$this->db->join('invoices','customers.person_id=invoices.customer_id');
		$this->db->where("department",'Pharmacy');
		$this->db->where("processed",'1');
		$this->db->where('deleted',0);		
		$this->db->like("national_id",$search);
		$this->db->order_by("national_id", "asc");		
		$by_national_id = $this->db->get();
		foreach($by_national_id->result() as $row)
		{
			$suggestions[]=$row->person_id.'|'.$row->national_id;		
		}

		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}

}

/* End of file Dispensing_model.php */
/* Location: ./application/models/Dispensing_model.php */
