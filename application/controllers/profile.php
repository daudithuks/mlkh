<?php
require_once ("person_controller.php");
class Profile extends Person_controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$data['person_info']=$this->Employee->get_logged_in_employee_info();
		$data['all_modules']=$this->Module->get_all_modules();
		$data['usernames']=$this->usernames($this->Employee->get_logged_in_employee_info()->person_id);
		$this->load->view("profile/form",$data);
	}
	
	/*
	Returns employee table data rows. This will be called with AJAX.
	*/
	
	function usernames($employee_id)
	{
		$usernames =  $this->Profiles->get_taken_usernames($employee_id);
	}
	
	function search()
	{
		$search=$this->input->post('search');
		$data_rows=get_people_manage_table_data_rows($this->Employee->search($search),$this);
		echo $data_rows;
	}
	
	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		$suggestions = $this->Employee->get_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}
	
	/*
	Loads the employee edit form
	*/
	function view($employee_id=-1)
	{
		$data['person_info']=$this->Employee->get_info($employee_id);
		$data['all_modules']=$this->Module->get_all_modules();
		$this->load->view("employees/form",$data);
	}
	
	/*
	Inserts/updates an employee
	*/
	function save($employee_id=-1)
	{
		//Password has been changed OR first time password set
		if($this->input->post('password')!='')
		{
			$employee_data=array(
			'username'=>$this->input->post('username'),
			'password'=>md5($this->input->post('password'))
			);
		}
		else //Password not changed
		{
			$employee_data=array('username'=>$this->input->post('username'));
		}
		
		if($this->Profiles->save($employee_data,$employee_id))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('profiles_successful_updating').' '.
			$person_data['first_name'].' '.$person_data['last_name'],'person_id'=>$employee_id));
		}
		else//failure
		{	
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('profiles_error_adding_updating').' '.
			$person_data['first_name'].' '.$person_data['last_name'],'person_id'=>-1));
		}
	}
	
	/*
	This deletes employees from the employees table
	*/
	function delete()
	{
		$employees_to_delete=$this->input->post('ids');
		
		if($this->Profile->delete_list($employees_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('employees_successful_deleted').' '.
			count($employees_to_delete).' '.$this->lang->line('employees_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('employees_cannot_be_deleted')));
		}
	}
	/*
	get the width for the add/edit form
	*/
	function get_form_width()
	{
		return 650;
	}
}
?>