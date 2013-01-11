<?php
require_once ("secure_area.php");
require_once (APPPATH."libraries/ofc-library/open-flash-chart.php");
class OPD_Reports extends Secure_area 
{	
	function __construct()
	{
		parent::__construct('opd_reports');
		$this->load->helper('report');		
	}
	
	//Initial report listing screen
	function index()
	{
		$this->load->view("opd_reports/listing",array());	
	}
	
	function _get_common_report_data()
	{
		$data = array();
		$data['report_date_range_simple'] = get_simple_date_ranges();
		$data['months'] = get_months();
		$data['days'] = get_days();
		$data['years'] = get_years();
		$data['age'] = get_age();
		$data['selected_month']=date('n');
		$data['selected_day']=date('d');
		$data['selected_year']=date('Y');	
	
		return $data;
	}
	
	//Input for reports that require only a date range and an export to excel. (see routes.php to see that all summary reports route here)
	function date_input_excel_export()
	{
		$data = $this->_get_common_report_data();
		$this->load->view("opd_reports/date_input_excel_export",$data);	
	}
	
	//Input for reports that require only a date range. (see routes.php to see that all graphical summary reports route here)
	function date_input()
	{
		$data = $this->_get_common_report_data();
		$this->load->view("opd_reports/date_input",$data);	
	}
	
	function workload_summary($start_date, $end_date, $start_age=null, $end_age=null, $export_excel=0)
	{
		$this->load->model('opd_reports/workload_summary');
		$model = $this->workload_summary;
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date));
		
		if ( !empty($start_age)&& !empty($end_age) ){
			if ($start_age == 'infant') $start_age= 0;
			if ($end_age == 'infant') $end_age= 0;
			$table_data = array(
				//'general'=>array('male'=>0,'female'=>0),
				'general'=>array('new'=>array('male'=>0,'female'=>0),'revisit'=>array('male'=>0,'female'=>0)),
				'ent'=>array('new'=>array('male'=>0,'female'=>0),'revisit'=>array('male'=>0,'female'=>0)),
				'eye'=>array('new'=>array('male'=>0,'female'=>0),'revisit'=>array('male'=>0,'female'=>0)),
				'tb'=>array('new'=>array('male'=>0,'female'=>0),'revisit'=>array('male'=>0,'female'=>0)),
				'orthopaedic'=>array('new'=>array('male'=>0,'female'=>0),'revisit'=>array('male'=>0,'female'=>0)),
				'dental'=>array('new'=>array('male'=>0,'female'=>0),'revisit'=>array('male'=>0,'female'=>0)),
				'cwc'=>array('new'=>array('male'=>0,'female'=>0),'revisit'=>array('male'=>0,'female'=>0)),
				'anc'=>array('new'=>array('male'=>0,'female'=>0),'revisit'=>array('male'=>0,'female'=>0)),
				'pnc'=>array('new'=>array('male'=>0,'female'=>0),'revisit'=>array('male'=>0,'female'=>0)),
				'fp'=>array('new'=>array('male'=>0,'female'=>0),'revisit'=>array('male'=>0,'female'=>0)),
				);
			foreach ($report_data as $line=>$row) {
				$gender = $row['gender'];
				$clinic = ($row['consultation_type']=='paeds')?'general':$row['consultation_type'];
				$visit = ($row['visit_status'] == 0)?'new':'revisit';
				$consultation_date = strtotime($row['consultation_time']);
				$dob = strtotime($row['age']);
				$age = date_diff(date_create(date("Y-m-d",$consultation_date)),date_create(date("Y-m-d",$dob)))->format('%y');
				
				if ( $age >= $start_age && $age <= $end_age){
					$table_data["$clinic"]["$visit"]["$gender"]++;
				}
			}
			
			$data = array(
				"title" => $start_age == $end_age ? "Workload Summary ($start_age years)" : "Workload Summary ($start_age to $end_age years)",
				"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
				"data" => $table_data,
				//"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type' => $sale_type)),
				"export_excel" => $export_excel
			);
			$this->load->view("opd_reports/workload_summary_age_defined",$data);
		}
		
		else {
			$table_data = array(
				'general'=>array( 
					'new'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0)),
					'revisit'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0))),
				'ent'=>array( 
					'new'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0)),
					'revisit'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0))),
				'eye'=>array( 
					'new'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0)),
					'revisit'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0))),
				'tb'=>array( 
					'new'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0)),
					'revisit'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0))),
				'orthopaedic'=>array( 
					'new'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0)),
					'revisit'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0))),
				'dental'=>array( 
					'new'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0)),
					'revisit'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0))),
				'cwc'=>array(
					'new'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0)),
					'revisit'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0))),
				'anc'=>array( 
					'new'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0)),
					'revisit'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0))),
				'pnc'=>array( 
					'new'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0)),
					'revisit'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0))),
				'fp'=>array( 
					'new'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0)),
					'revisit'=>array(
						'adult'=> array('male'=>0,'female'=>0),
						'child'=> array('male'=>0,'female'=>0))),
				
				);
			foreach ($report_data as $line=>$row) {
				$gender = $row['gender'];
				$clinic = ($row['consultation_type']=='paeds')?'general':$row['consultation_type'];
				$visit = ($row['visit_status'] == 0)?'new':'revisit';
				$consultation_date = strtotime($row['consultation_time']);
				$dob = strtotime($row['age']);
				$age = date_diff(date_create(date("Y-m-d",$consultation_date)),date_create(date("Y-m-d",$dob)))->format('%y');
				
				if ( $age > 5 ){
					$table_data["$clinic"]["$visit"]['adult']["$gender"]++;
				}
				else {
					$table_data["$clinic"]["$visit"]['child']["$gender"]++;
				}
			}
			
			$data = array(
				"title" => "Workload Summary",
				"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
				"data" => $table_data,
				//"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type' => $sale_type)),
				"export_excel" => $export_excel
			);
			
			$this->load->view("opd_reports/workload_summary_standard",$data);
		}
	}
	
	function morbidity_summary($start_date, $end_date, $start_age=null, $end_age=null, $export_excel=0)
	{
		$this->load->model('opd_reports/morbidity_summary');
		$model = $this->morbidity_summary;
		$categories = $model->getCategories();
		$table_data = array();
		$other_data = array();
		if ( !empty($start_age)&& !empty($end_age) ) {
			$age_set = true;
			if ($start_age == 'infant') $start_age= 0;
			if ($end_age == 'infant') $end_age= 0;
		}
		
		foreach ($categories as $category){
			$table_data[$category["category_name"]] = 0;
			if ( $age_set ){				
				$diagnosis_data = $model->countCategory(array('start_date'=>$start_date, 'end_date'=>$end_date,'diagnosis_code'=>$category["category_codes"]))->result_array();
				foreach ($diagnosis_data as $row){
					$consultation_date = strtotime($row['consultation_time']);
					$dob = strtotime($row['age']);
					$age = date_diff(date_create(date("Y-m-d",$consultation_date)),date_create(date("Y-m-d",$dob)))->format('%y');
					
					if ( $age >= $start_age && $age <= $end_age){
						$table_data[$category["category_name"]]++;
					}
				}
			}else {
				$table_data[$category["category_name"]] = $model->countCategory(array('start_date'=>$start_date, 'end_date'=>$end_date,'diagnosis_code'=>$category["category_codes"]))->num_rows();
			}
			if (!empty($category["category_codes"])) $other_data[] = $category["category_codes"];
		}
		
		if($age_set){
			$table_data["Other Diseases"] = 0;
			$other_diseases = $model->countOthers(array('start_date'=>$start_date, 'end_date'=>$end_date,'diagnosis_codes'=>$other_data))->result_array();
			foreach ($other_diseases as $row){
					$consultation_date = strtotime($row['consultation_time']);
					$dob = strtotime($row['age']);
					$age = date_diff(date_create(date("Y-m-d",$consultation_date)),date_create(date("Y-m-d",$dob)))->format('%y');
					
					if ( $age >= $start_age && $age <= $end_age){
						$table_data["Other Diseases"]++;
					}
			}
		}
		
		else $table_data["Other Diseases"] = $model->countOthers(array('start_date'=>$start_date, 'end_date'=>$end_date,'diagnosis_codes'=>$other_data))->num_rows();
		
		$data = array(
				"title" => ( !empty($start_age)&& !empty($end_age) ) ? $start_age == $end_age ? "Morbidity Summary ($start_age years)" : "Morbidity Summary ($start_age to $end_age years)" : "Morbidity Summary",
				"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
				"data" => $table_data,
				//"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type' => $sale_type)),
				"export_excel" => $export_excel
			);
		
		$this->load->view("opd_reports/morbidity_summary",$data);
	}
}
?>
