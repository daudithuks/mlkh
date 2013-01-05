<?php
require_once ("person_controller.php");
class Admissions extends Person_controller
{
	function __construct()
	{
		parent::__construct('admissions');
	}
	
	function index()
	{
		$config['base_url'] = site_url('/admissions/index');
		$config['total_rows'] = $this->Customer->count_all_admission();
		$config['per_page'] = '20';
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['manage_table']=get_admissions_manage_table( $this->Customer->get_all_queued( $config['per_page'], $this->uri->segment( $config['uri_segment'] ) ), $this );
		$this->load->view('admissions/manage',$data);
	}

	/*
	Gets one row for a person manage table. This is called using AJAX to update one row.
	*/
	function get_row()
	{
		$person_id = $this->input->post('row_id');
		$data_row=get_admissions_data_row($this->Person->get_info($person_id),$this);
		echo $data_row;
	}
	
	/*
	Returns patient table data rows. This will be called with AJAX.
	*/
	function search()
	{
		$search=$this->input->post('search');
		$data_rows=get_admissions_manage_table_data_rows($this->Customer->search($search),$this);
		echo $data_rows;
	}
	
	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		$suggestions = $this->Customer->get_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}
	
	/*load the alliocation edit form*/
	function view_allocate($patient_id=-1)
	{
		$data['person_info']=$this->Customer->get_info($patient_id);
		$data['outpatient_service']=$this->Consultation->get_outpatient_services();
		$this->load->view("admissions/allocate",$data);
	}
	/*insert patient allocation*/
	function save_allocation($patient_id=-1)
	{
		if($this->input->post('through_triage')==1)$encounter_status='0';
		else $encounter_status='1';
		$encounter_data = array(
			'patient_id' => $patient_id,
			'visit_status' =>$this->input->post('visit_status'),
			'encounter_type' => $this->input->post('outpatient_service'),
			'encounter_status' => $encounter_status);
		if($this->Consultation->save_allocation($encounter_data))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('patients_successful_updating').' '.
			$person_data['first_name'].' '.$person_data['last_name'],'person_id'=>$patient_id));
		}
		else//failure
		{	
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('patients_error_adding_updating').' '.
			$person_data['first_name'].' '.$person_data['last_name'],'person_id'=>-1));
		}
	}

	
	/*
	Loads the patient edit form
	*/
	function view($patient_id=-1)
	{
		$data['person_info']=$this->Customer->get_info($patient_id);
		$this->load->view("admissions/form",$data);
	}
	
	/*
	Inserts/updates a patient
	*/
	function save($patient_id=-1)
	{
		$dob = explode('/',$this->input->post('age'));
		$age = $dob[2]."-".$dob[0]."-".$dob[1];
		$person_data = array(
		'first_name'=>$this->input->post('first_name'),
		'last_name'=>$this->input->post('last_name'),
		'middle_name'=>$this->input->post('middle_name'),
		'gender'=>$this->input->post('gender'),
		'civil_status'=>$this->input->post('civil_status'),
		'visit_status'=>$this->input->post('visit_status'),
		'next_kin'=>$this->input->post('next_kin'),
		'next_kin_tel'=>$this->input->post('next_kin_tel'),
		'residence'=>$this->input->post('residence'),
		'blood_group'=>$this->input->post('blood_group'),
		'national_id'=>$this->input->post('national_id'),
		'nhif'=>$this->input->post('nhif'),
		'age'=>$age,
		'phone_number'=>$this->input->post('phone_number'),
		'email'=>$this->input->post('email'),
		'address_1'=>$this->input->post('address_1'),
		'address_2'=>$this->input->post('address_2'),
		'city'=>$this->input->post('city'),
		'state'=>$this->input->post('state'),
		'zip'=>$this->input->post('zip'),
		'country'=>$this->input->post('country'),
		'comments'=>$this->input->post('comments')
		);
		$patient_data=array(
		'account_number'=>$this->input->post('account_number')=='' ? null:$this->input->post('account_number'),
		'taxable'=>$this->input->post('taxable')=='' ? 0:1,
		);
		if($this->Customer->save($person_data,$patient_data,$patient_id))
		{
			//New patient
			if($patient_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('patients_successful_adding').' '.
				$person_data['first_name'].' '.$person_data['last_name'],'person_id'=>$patient_data['person_id']));
			}
			else //previous patient
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('patients_successful_updating').' '.
				$person_data['first_name'].' '.$person_data['last_name'],'person_id'=>$patient_id));
			}
		}
		else//failure
		{	
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('patients_error_adding_updating').' '.
			$person_data['first_name'].' '.$person_data['last_name'],'person_id'=>-1));
		}
	}
	
	/*
	This deletes patients from the patients table
	*/
	function delete()
	{
		/*$patients_to_delete=$this->input->post('ids');
		
		if($this->Customer->delete_list($patients_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('patients_successful_deleted').' '.
			count($patients_to_delete).' '.$this->lang->line('patients_one_or_multiple')));
		}
		else*/
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('patients_cannot_be_deleted')));
		}
	}
	
	function excel()
	{
		$data = file_get_contents("import_customers.csv");
		$name = 'import_customers.csv';
		force_download($name, $data);
	}
	
	function excel_import()
	{
		$this->load->view("customers/excel_import", null);
	}

	function do_excel_import()
	{
		$msg = 'do_excel_import';
		$failCodes = array();
		if ($_FILES['file_path']['error']!=UPLOAD_ERR_OK)
		{
			$msg = $this->lang->line('items_excel_import_failed');
			echo json_encode( array('success'=>false,'message'=>$msg) );
			return;
		}
		else
		{
			if (($handle = fopen($_FILES['file_path']['tmp_name'], "r")) !== FALSE)
			{
				//Skip first row
				fgetcsv($handle);
				
				$i=1;
				while (($data = fgetcsv($handle)) !== FALSE) 
				{
					$person_data = array(
					'first_name'=>$data[0],
					'last_name'=>$data[1],
					'email'=>$data[2],
					'phone_number'=>$data[3],
					'address_1'=>$data[4],
					'address_2'=>$data[5],
					'city'=>$data[6],
					'state'=>$data[7],
					'zip'=>$data[8],
					'country'=>$data[9],
					'comments'=>$data[10]
					);
					
					$patient_data=array(
					'account_number'=>$data[11]=='' ? null:$data[11],
					'taxable'=>$data[12]=='' ? 0:1,
					);
					
					if(!$this->Customer->save($person_data,$patient_data))
					{	
						$failCodes[] = $i;
					}
					
					$i++;
				}
			}
			else 
			{
				echo json_encode( array('success'=>false,'message'=>'Your upload file has no data or not in supported format.') );
				return;
			}
		}

		$success = true;
		if(count($failCodes) > 1)
		{
			$msg = "Most patients imported. But some were not, here is list of their CODE (" .count($failCodes) ."): ".implode(", ", $failCodes);
			$success = false;
		}
		else
		{
			$msg = "Import Customers successful";
		}

		echo json_encode( array('success'=>$success,'message'=>$msg) );
	}
	
	/*
	get the width for the add/edit form
	*/
	function get_form_width()
	{			
		return 350;
	}
}
?>
