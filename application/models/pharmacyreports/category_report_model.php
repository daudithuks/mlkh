<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_report_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	function _get_all_suppliers()
	{
		$q = $this->db->get('pharm_supplier_category');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
	}
	public function get_revenue_by_suppliers($start_date, $end_date)
	{
		$suppliers = $this->_get_all_suppliers();
		foreach ($suppliers as $supplier) {
			$this->db->where('supplier_category', $supplier->sup_id);
			$sqlcondition= 'invoice_time BETWEEN "'.$start_date.'" AND "'.$end_date.'" ';
			$this->db->where($sqlcondition);
			$this->db->where('processed', 2);
			$q = $this->db->get('supplier_category_view');
			if ($q->num_rows() > 0) {
				foreach ($q->result() as $row) {
					$data[$supplier->sup_cat_name]['total_revenue'] += $row->quantity_purchased*$row->item_unit_price;
				}


			}

		}
		return $data;
	}
	
	function _get_all_drug_classes()
	{
		$q = $this->db->get('pharm_drug_classification');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
	}
	public function get_revenue_by_classification($start_date, $end_date)
	{
		$classes = $this->_get_all_drug_classes();
		foreach ($classes as $class) {
			$this->db->where('classification', $class->class_id);
			$sqlcondition= 'invoice_time BETWEEN "'.$start_date.'" AND "'.$end_date.'" ';
			$this->db->where($sqlcondition);
			$this->db->where('processed', 2);
			$q = $this->db->get('supplier_category_view');
			if ($q->num_rows() > 0) {
				foreach ($q->result() as $row) {
					$data[$class->class_name]['total_revenue'] += $row->quantity_purchased*$row->item_unit_price;
					$data[$class->class_name]['quantity'] += $row->quantity_purchased;
				}
			}
		}
		return $data;
	}
	function get_all_departments()
	{
		$q = $this->db->get('department');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
	}
	function get_consumption_by_deparment($start_date, $end_date)
	{
		$departments = $this->get_all_departments();
		foreach ($departments as $dept) {
			$this->db->where('department_id', $dept->department_id);
			$sqlcondition= 'receiving_time BETWEEN "'.$start_date.'" AND "'.$end_date.'" ';
			$this->db->where($sqlcondition);
			$q = $this->db->get('department_consumption_view');
			if ($q->num_rows() > 0) {
				foreach ($q->result() as $row) {
					$data[$dept->department_name]['total_revenue'] += ($row->quantity_purchased *-1) *$row->unit_price;
					$data[$dept->department_name]['quantity'] += ($row->quantity_purchased * -1);
				}

			}
		}
		return $data;
	}

	function _get_all_items(){
		$q = $this->db->get('items');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
	}
	function get_consumption_by_deparment_per_drug($start_date, $end_date, $department_id)
	{
		
		$this->db->where('department_id', $department_id);
		$sqlcondition= 'receiving_time BETWEEN "'.$start_date.'" AND "'.$end_date.'" ';
		$this->db->where($sqlcondition);
		$q = $this->db->get('department_consumption_view');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}else{
			return $data = '';
		}
	}

	function get_department_name($department_id)
	{
		$this->db->where('department_id', $department_id);
		$q = $this->db->get('department');
		if ($q->num_rows() > 0) {
			$row = $q->row();
			return $row->department_name;
		}
	}
	
	function get_all_over_five($start_date, $end_date)
	{
		$this->db->from('invoices');
		$this->db->join('people','invoices.customer_id=people.person_id');			
		$sql='age > 5';
		$this->db->where($sql);
		$sqlcondition= 'invoices.invoice_time BETWEEN "'.$start_date.'" AND "'.$end_date.'" ';
		$this->db->where($sqlcondition);
		$q = $this->db->get();
		return $q->num_rows();
	}

	function get_all_under_five($start_date, $end_date)
	{
		$this->db->from('invoices');
		$this->db->join('people','invoices.customer_id=people.person_id');			
		$sql='age <= 5';
		$this->db->where($sql);
		$sqlcondition= 'invoices.invoice_time BETWEEN "'.$start_date.'" AND "'.$end_date.'" ';
		$this->db->where($sqlcondition);
		$q = $this->db->get();
		return $q->num_rows();
	}


}

/* End of file Category_report_model.php */
/* Location: ./application/models/Category_report_model.php */