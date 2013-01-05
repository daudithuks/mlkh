<?php
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");
class Waivers extends Secure_area implements iData_controller
{
	function __construct()
	{
		parent::__construct('waivers');
	}

	function index()
	{
		$config['base_url'] = site_url('/waivers/index');
		$config['total_rows'] = $this->Waiver->count_all();
		$config['per_page'] = '20';
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['manage_table']=get_waivers_manage_table( $this->Waiver->get_all( $config['per_page'], $this->uri->segment( $config['uri_segment'] ) ), $this );
		$this->load->view('waivers/manage',$data);
	}

	function search()
	{
		$search=$this->input->post('search');
		$data_rows=get_waivers_manage_table_data_rows($this->Waiver->search($search),$this);
		echo $data_rows;
	}

	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		$suggestions = $this->Waiver->get_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}
	
	function suggest_customer()
	{
		$suggestions = $this->Customer->get_customer_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}

	function get_row()
	{
		$waiver_id = $this->input->post('row_id');
		$data_row=get_waiver_data_row($this->Waiver->get_info($waiver_id),$this);
		echo $data_row;
	}

	function view($waiver_id=-1)
	{
		$data['waiver_info']=$this->Waiver->get_info($waiver_id);

		$this->load->view("waivers/form",$data);
	}
	
	function save($waiver_id=-1)
	{
		if($waiver_id==-1)
		{
			$waiver_data = array(
			'customer_id'=>$this->input->post('customer_id'),
			'employee_id'=>$this->Employee->get_logged_in_employee_info()->person_id,
			'serial'=>$this->serial(),
			'value'=>$this->input->post('value'),
			'reason'=>$this->input->post('reason'),
			);
		}
		else
		{
			$waiver_data = array(
			'customer_id'=>$this->input->post('customer_id'),
			'employee_id'=>$this->Employee->get_logged_in_employee_info()->person_id,
			'value'=>$this->input->post('value'),
			'reason'=>$this->input->post('reason'),
			);
		}

		if( $this->Waiver->save( $waiver_data, $waiver_id ) )
		{
			//New waiver
			if($waiver_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('waivers_successful_adding').' '.
				$waiver_data['waiver_id'],'waiver_id'=>$waiver_data['waiver_id']));
				$waiver_id = $waiver_data['waiver_id'];
			}
			else //previous waiver
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('waivers_successful_updating').' '.
				$waiver_id,'waiver_id'=>$waiver_id));
			}
		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('waivers_error_adding_updating').' '.
			$waiver_data['waiver_id'],'waiver_id'=>-1));
		}

	}
	
	function serial()
	{
		$serials = $this->Waiver->used_serials();
		$serial = mt_rand();
		while ( in_array($serial,$serials) )
		{
			$serial = mt_rand();
		}
		return $serial;
	}

	function delete()
	{
		$waivers_to_delete=$this->input->post('ids');

		if($this->Waiver->delete_list($waivers_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('waivers_successful_deleted').' '.
			count($waivers_to_delete).' '.$this->lang->line('waivers_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('waivers_cannot_be_deleted')));
		}
	}
		
	/*
	get the width for the add/edit form
	*/
	function get_form_width()
	{
		return 360;
	}
}
?>