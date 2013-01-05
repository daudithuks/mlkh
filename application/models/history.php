<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class History extends CI_Model {
	public function get_info($customer_id)
	{
		//G CODE
		$this->db->from('history');
		$this->db->where('customer_id',$customer_id);
		$this->db->order_by("sale_time", "desc");
		$query = $this->db->get();
		$data = array();
		foreach ($query->result() as $row)
		{
		    $data[]=$row;
		}
		return $data;

	}
    

}

/* End of file history.php */
/* Location: ./application/models/history.php */