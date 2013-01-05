<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ("secure_area.php");

class Pharmacyreports extends Secure_area {

	public function __construct()
	{
		parent::__construct('pharmacyreports');
		$this->load->helper('report');		

	}

	//Initial report listing screen
	public function index()
	{
		$this->load->model('pharmacyreports/Category_report_model');
		$model = $this->Category_report_model;
		$data['departments']=$model->get_all_departments();
		$this->load->view("pharmacyreports/listing", $data);	
	}

	function _get_common_report_data()
	{
		$data = array();
		$data['report_date_range_simple'] = get_simple_date_ranges();
		$data['months'] = get_months();
		$data['days'] = get_days();
		$data['years'] = get_years();
		$data['selected_month']=date('n');
		$data['selected_day']=date('d');
		$data['selected_year']=date('Y');	
	
		return $data;
	}
	function revenue_by_drug_suppliers($start_date, $end_date, $sale_type, $export_excel=0)
	{
		//
		if (!$start_date) 
		{
			$data = $this->_get_common_report_data();
			$this->load->view("pharmacyreports/date_input",$data);
		} else 
		{
			//display report nigga
			$this->load->model('pharmacyreports/Category_report_model');
			$model = $this->Category_report_model;
			$data['revenue']=$model->get_revenue_by_suppliers($start_date, $end_date);
			$this->load->view('pharmacyreports/tabular', $data);
		}
		
	}
	public function revenue_by_drug_classification($start_date, $end_date, $sale_type, $export_excel=0)
	{
		if (!$start_date) 
		{
			$data = $this->_get_common_report_data();
			$this->load->view("pharmacyreports/date_input",$data);
		} else 
		{
			//display report nigga
			$this->load->model('pharmacyreports/Category_report_model');
			$model = $this->Category_report_model;
			$data['revenue']=$model->get_revenue_by_classification($start_date, $end_date);
			$this->load->view('pharmacyreports/tabular', $data);
		}
	}
	public function workload($start_date, $end_date, $sale_type, $export_excel=0)
	{
		if (!$start_date) 
		{
			$data = $this->_get_common_report_data();
			$this->load->view("pharmacyreports/date_input",$data);
		} else 
		{
			//display report nigga
			$this->load->model('pharmacyreports/Category_report_model');
			$model = $this->Category_report_model;
			$data['overfive']=$model->get_all_over_five($start_date, $end_date);
			$data['underfive'] = $model->get_all_under_five($start_date, $end_date);
			$this->load->view('pharmacyreports/workload', $data);
		}
	}

	public function department_consumption($start_date, $end_date, $sale_type, $export_excel=0)
	{
		if (!$start_date) 
		{
			$data = $this->_get_common_report_data();
			$this->load->view("pharmacyreports/date_input",$data);
		} else 
		{
			//display report nigga
			$this->load->model('pharmacyreports/Category_report_model');
			$model = $this->Category_report_model;
			$data['revenue']=$model->get_consumption_by_deparment($start_date, $end_date);
			// var_dump($data);
			$this->load->view('pharmacyreports/tabular', $data);
		}
	}
	public function department_consumption_per_drug($department_id,$start_date, $end_date, $sale_type)
	{
		if (!$start_date) 
		{
			$data = $this->_get_common_report_data();
			$this->load->view("pharmacyreports/date_input",$data);
		} else 
		{
			//display report nigga
			$this->load->model('pharmacyreports/Category_report_model');
			$model = $this->Category_report_model;
			$data['items']=$model->get_consumption_by_deparment_per_drug($start_date, $end_date, $department_id);
			//var_dump($data);
			$this->load->view('pharmacyreports/advancedtabular', $data);
		}
	}

}

/* End of file pharmacyreports.php */
/* Location: ./application/controllers/pharmacyreports.php */