<?php
class Morbidity_Summary extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	
	public function countCategory(array $inputs)
	{		
		$this->db->from('consultation_diagnosis');
		$this->db->join('consultation','consultation.consultation_id=consultation_diagnosis.consultation_id');
		$this->db->join('people','consultation.patient_id=people.person_id');
		$this->db->having('consultation_time BETWEEN "'. $inputs['start_date']. ' 00:00:00" and "'. $inputs['end_date'].' 23:59:59"');
		$this->db->where('diagnosis_code',$inputs['diagnosis_code']);
		//if ( !empty($inputs['start_age'])&& !empty($inputs['end_age']) ) $this->db->having('age BETWEEN "'. $inputs['start_age']. '" and "'. $inputs['end_age'].'"');
		return $this->db->get();
	}
	
	public function countOthers(array $inputs)
	{		
		$this->db->from('consultation_diagnosis');
		$this->db->join('consultation','consultation.consultation_id=consultation_diagnosis.consultation_id');
		$this->db->join('people','consultation.patient_id=people.person_id');
		$this->db->having('consultation_time BETWEEN "'. $inputs['start_date']. ' 00:00:00" and "'. $inputs['end_date'].' 23:59:59"');
		$this->db->where_not_in('diagnosis_code',$inputs['diagnosis_codes']);
		
		return $this->db->get();
	}
	
	public function getCategories()
	{		
		$this->db->from('morbidity_categories');
		return $this->db->get()->result_array();
	}
	
	
}
?>
