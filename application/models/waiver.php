<?php
class Waiver extends CI_Model
{
	/*
	Determines if a given waiver_id is a waiver
	*/
	function exists( $waiver_id )
	{
		$this->db->from('waivers');
		$this->db->where('waiver_id',$waiver_id);
		$this->db->where('deleted',0);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}

	/*
	Returns all the waivers
	*/
	function get_all($limit=10000, $offset=0)
	{
		$query = "* FROM `mlkh_waivers`AS w INNER JOIN ( SELECT `person_id`,CONCAT(`first_name`,SPACE(1),`last_name`) AS `employee` FROM `mlkh_people`)AS e ON w.`employee_id` = e.`person_id` INNER JOIN ( SELECT `person_id`,CONCAT(`first_name`,SPACE(1),`last_name`) AS `customer` FROM `mlkh_people`)AS c ON w.`customer_id` = c.`person_id` WHERE w.`deleted`=0";
		//$this->db->where('deleted',0);
		$this->db->select($query,FALSE);
		/*$this->db->from('waivers');
		$this->db->join('customers', 'customers.person_id = waivers.customer_id', $type = 'INNER');
		$this->db->join('people', 'customers.person_id = people.person_id', $type = 'INNER');
		$this->db->where('waivers.deleted',0);
		$this->db->order_by("waiver_date", "asc");
		$this->db->limit($limit);
		$this->db->offset($offset);*/
		return $this->db->get();
	}
	
	function count_all()
	{
		$this->db->from('waivers');
		$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}

	/*
	Gets information about a particular waiver
	*/
	function get_info($waiver_id)
	{
		$query = "* FROM `mlkh_waivers`AS w INNER JOIN ( SELECT `person_id`,CONCAT(`first_name`,SPACE(1),`last_name`) AS `employee` FROM `mlkh_people`)AS e ON w.`employee_id` = e.`person_id` INNER JOIN ( SELECT `person_id`,CONCAT(`first_name`,SPACE(1),`last_name`) AS `customer` FROM `mlkh_people`)AS c ON w.`customer_id` = c.`person_id` WHERE w.`deleted`=0 AND w.`waiver_id`='$waiver_id'";
		/*$this->db->where('waiver_id',$waiver_id);
		$this->db->where('deleted',0);*/
		$this->db->select($query,FALSE);
		
		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $waiver_id is NOT an waiver
			$waiver_obj=new stdClass();

			//Get all the fields from waivers table
			$fields = $this->db->list_fields('waivers');

			foreach ($fields as $field)
			{
				$waiver_obj->$field='';
			}

			return $waiver_obj;
		}
	}

	/*
	Get an waiver id given an waiver number
	*/
	function get_waiver_id($serial)
	{
		$this->db->from('waivers');
		$this->db->where('serial',$serial);
		$this->db->where('deleted',0);

		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row()->waiver_id;
		}

		return false;
	}
	
	function get_waiver($customer_id)
	{
		$this->db->from('waivers');
		$this->db->where('customer_id',$customer_id);
		$this->db->where('value > 0');
		$this->db->where('deleted',0);
		
		return $this->db->get()->row();
	}

	/*
	Gets information about multiple waivers
	*/
	function get_multiple_info($waiver_ids)
	{
		$this->db->from('waivers');
		$this->db->where_in('waiver_id',$waiver_ids);
		$this->db->where('deleted',0);
		$this->db->order_by("waiver_date", "asc");
		return $this->db->get();
	}

	/*
	Inserts or updates a waiver
	*/
	function save(&$waiver_data,$waiver_id=false)
	{
		if (!$waiver_id or !$this->exists($waiver_id))
		{
			if($this->db->insert('waivers',$waiver_data))
			{
				$waiver_data['waiver_id']=$this->db->insert_id();
				return true;
			}
			return false;
		}

		$this->db->where('waiver_id', $waiver_id);
		return $this->db->update('waivers',$waiver_data);
	}

	/*
	Updates multiple waivers at once
	*/
	function update_multiple($waiver_data,$waiver_ids)
	{
		$this->db->where_in('waiver_id',$waiver_ids);
		return $this->db->update('waivers',$waiver_data);
	}

	/*
	Deletes one waiver
	*/
	function delete($waiver_id)
	{
		$this->db->where('waiver_id', $waiver_id);
		return $this->db->update('waivers', array('deleted' => 1));
	}

	/*
	Deletes a list of waivers
	*/
	function delete_list($waiver_ids)
	{
		$this->db->where_in('waiver_id',$waiver_ids);
		return $this->db->update('waivers', array('deleted' => 1));
 	}

 	/*
	Get search suggestions to find waivers
	*/
	function get_search_suggestions($search,$limit=25)
	{
		$suggestions = array();

		$this->db->from('waivers');
		$this->db->like('serial', $search);
		$this->db->where('deleted',0);
		$this->db->order_by("waiver_date", "asc");
		$by_waiver_serial = $this->db->get();
		foreach($by_waiver_serial->result() as $row)
		{
			$suggestions[]=$row->serial;
		}
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');	
		$this->db->where("(first_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		last_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");
		$this->db->order_by("last_name", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->first_name.' '.$row->last_name;		
		}

		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}

	/*
	Preform a search on waivers
	*/
	function search($search)
	{
		$query = "* FROM `mlkh_waivers`AS w INNER JOIN ( SELECT `person_id`,CONCAT(`first_name`,SPACE(1),`last_name`) AS `employee` FROM `mlkh_people`)AS e ON w.`employee_id` = e.`person_id` INNER JOIN ( SELECT `person_id`,CONCAT(`first_name`,SPACE(1),`last_name`) AS `customer` FROM `mlkh_people`)AS c ON w.`customer_id` = c.`person_id` WHERE w.`deleted`=0 AND (w.`serial` LIKE '%$search%' OR c.`customer` LIKE '%$search%')";
		$this->db->select($query,FALSE);
		/*$this->db->where('deleted',0);
		$this->db->like('serial', $search);
		$this->db->or_like('customer', $search);*/ 
		$this->db->order_by("waiver_date", "asc");
		return $this->db->get();	
	}
	
	function get_waiver_value( $serial )
	{
		if ( !$this->exists( $this->get_waiver_id($serial)))
			return 0;
		
		$this->db->from('waivers');
		$this->db->where('serial',$serial);
		return $this->db->get()->row()->value;
	}
	
	function used_serials()
	{
		$this->db->select('serial');
		$this->db->from('waivers');
		$result = $this->db->get()->result_array();
		$serial = array();
		foreach ($result as $row) $serial[]=$row['serial'];
		return $serial;
	}
	
	function update_waiver_value( $waiver_id, $value )
	{
		$this->db->where('waiver_id', $waiver_id);
		$this->db->update('waivers', array('value' => $value));
	}
	
	function get_waiver_user( $serial )
	{
		if ( !$this->exists( $this->get_waiver_id($serial)))
			return 0;
		
		$this->db->from('waivers');
		$this->db->where('serial',$serial);
		return $this->db->get()->row()->customer_id;
	}
}
?>
