<?php
class Workload_Summary extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	
	public function getData(array $inputs)
	{		
		$age5 = (date("Y")-5).date("-m-d");
		
		$this->db->from('consultation');
		$this->db->join('people','consultation.patient_id=people.person_id');
		$this->db->join('encounter','consultation.encounter_id=encounter.encounter_id');
		$this->db->group_by('consultation_time');
		$this->db->having('consultation_time BETWEEN "'. $inputs['start_date']. ' 00:00:00" and "'. $inputs['end_date'].' 23:59:59"');
		$this->db->order_by('consultation_time');
		return $this->db->get()->result_array();
	}
	
	
}
?>
