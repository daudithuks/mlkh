<?php
class Consultant_lib
{
	var $CI;

  	function __construct()
	{
		$this->CI =& get_instance();
	}

	function get_diagnoses()
	{
		if(!$this->CI->session->userdata('diagnoses'))
			$this->set_diagnoses(array());

		return $this->CI->session->userdata('diagnoses');
	}

	function set_diagnoses($diagnoses_data)
	{
		$this->CI->session->set_userdata('diagnoses',$diagnoses_data);
	}
	
	function check_diagnosis($patient_id,$consultant_id)
	{
		if($this->CI->Consultation->get_diagnoses($patient_id,$consultant_id)->num_rows() > 0)
		{
			foreach($this->CI->Consultation->get_diagnoses($patient_id,$consultant_id)->result() as $row)
			{
				$this->add_diagnosis($row->diagnosis_code);
			}
		}
	}

	function get_customer()
	{
		if(!$this->CI->session->userdata('customer'))
			$this->set_customer(-1);

		return $this->CI->session->userdata('customer');
	}

	function set_customer($customer_id,$consultant_id)
	{
		$this->CI->session->set_userdata('customer',$customer_id);
		$this->check_diagnosis($customer_id,$consultant_id);
		$this->check_complaints($customer_id,$consultant_id);
		$this->check_obst_gyn($customer_id,$consultant_id);
		$this->check_medical_history($customer_id,$consultant_id);
		$this->check_family_history($customer_id,$consultant_id);
		$this->check_examination($customer_id,$consultant_id);
	}
	
	function get_complaints()
	{
		if(!$this->CI->session->userdata('complaints'))
			$this->set_complaints(array());

		return $this->CI->session->userdata('complaints');
	}
	
	function set_complaints($complaints)
	{
		$this->CI->session->set_userdata('complaints',$complaints);
	}
	
	function check_complaints($patient_id,$consultant_id)
	{
		$complaints = $this->CI->Consultation->get_complaints($patient_id,$consultant_id);
		if( isset($complaints) && !empty($complaints))
		{
			$this->set_complaints($complaints);
		}
	}
	
	function get_obst_gyn()
	{
		if(!$this->CI->session->userdata('obst_gyn'))
			$this->set_obst_gyn(array());

		return $this->CI->session->userdata('obst_gyn');
	}
	
	function set_obst_gyn($obst_gyn)
	{
		$this->CI->session->set_userdata('obst_gyn',$obst_gyn);
	}
	
	function check_obst_gyn($patient_id)
	{
		$obst_gyn = $this->CI->Consultation->get_obst_gyn($patient_id,$consultant_id);
		if( isset($obst_gyn) && !empty($obst_gyn))
		{
			$this->set_obst_gyn($obst_gyn);
		}
	}
	
	function get_medical_history()
	{
		if(!$this->CI->session->userdata('medical_history'))
			$this->set_medical_history(array());

		return $this->CI->session->userdata('medical_history');
	}
	
	function set_medical_history($medical_history)
	{
		$this->CI->session->set_userdata('medical_history',$medical_history);
	}
	
	function check_medical_history($patient_id)
	{
		$medical_history = $this->CI->Consultation->get_medical_history($patient_id,$consultant_id);
		if( isset($medical_history) && !empty($medical_history))
		{
			$this->set_medical_history($medical_history);
		}
	}
	
	function get_family_history()
	{
		if(!$this->CI->session->userdata('family_history'))
			$this->set_family_history(array());

		return $this->CI->session->userdata('family_history');
	}
	
	function set_family_history($family_history)
	{
		$this->CI->session->set_userdata('family_history',$family_history);
	}
	
	function check_family_history($patient_id,$consultant_id)
	{
		$family_history = $this->CI->Consultation->get_family_history($patient_id,$consultant_id);
		if( isset($family_history) && !empty($family_history))
		{
			$this->set_family_history($family_history);
		}
	}
	
	function get_examination()
	{
		if(!$this->CI->session->userdata('examination'))
			$this->set_examination(array());

		return $this->CI->session->userdata('examination');
	}
	
	function set_examination($examination)
	{
		$this->CI->session->set_userdata('examination',$examination);
	}
	
	function check_examination($patient_id,$consultant_id)
	{
		$examination = $this->CI->Consultation->get_examination($patient_id,$consultant_id);
		if( isset($examination) && !empty($examination))
		{
			$this->set_examination($examination);
		}
	}

	function get_mode()
	{
		if(!$this->CI->session->userdata('sale_mode'))
			$this->set_mode('sale');

		return $this->CI->session->userdata('sale_mode');
	}

	function add_diagnosis($diagnosis_code,$primary=0)
	{
		//make sure item exists
		/*if(!$this->CI->Item->exists($item_id))
		{
			//try to get item id given an item_number
			$item_id = $this->CI->Item->get_item_id($item_id);

			if(!$item_id)
				return false;
		}*/

		//Get all diagnoses in the cart so far...
		$diagnoses = $this->get_diagnoses();

        //We need to loop through all items in the cart.
        //If the item is already there, get it's key($updatekey).
        //We also need to get the next key that we are going to use in case we need to add the
        //item to the cart. Since items can be deleted, we can't use a count. we use the highest key + 1.

        $maxkey=0;                       //Highest key so far
        $diagnosisalreadyincart=FALSE;        //We did not find the item yet.
		$insertkey=0;                    //Key to use for new entry.
		$updatekey=0;                    //Key to use to update(quantity)

		foreach ($diagnoses as $item)
		{
            //We primed the loop so maxkey is 0 the first time.
            //Also, we have stored the key in the element itself so we can compare.

			if($maxkey <= $item['line'])
			{
				$maxkey = $item['line'];
			}

			if($item['diagnosis_code']==$diagnosis_code)
			{
				$diagnosisalreadyincart=TRUE;
				$updatekey=$item['line'];
			}
		}

		$insertkey=$maxkey+1;

		//array/cart records are identified by $insertkey and item_id is just another field.
		$item = array(($insertkey)=>
		array(
			'diagnosis_code'=>$diagnosis_code,
			'line'=>$insertkey,
			'description'=>$this->CI->Consultation->get_diagnosis_info($diagnosis_code)->description,
			'primary'=>$primary
			)
		);

		//Item already exists and is not serialized, add to quantity
		if(!$diagnosisalreadyincart)
		{
			$diagnoses += $item;
		}
		
		$this->set_diagnoses($diagnoses);
		return true;

	}
	
	function edit_diagnosis($line,$primary)
	{
		$diagnoses = $this->get_diagnoses();
		if(isset($diagnoses[$line]))
		{
			$dignoses[$line]['primary'] = $primary;
			$this->set_diagnoses($diagnoses);
		}
	}
	
	function delete_diagnosis($line)
	{
		$items=$this->get_diagnoses();
		unset($items[$line]);
		$this->set_diagnoses($items);
	}

	function empty_diagnoses()
	{
		$this->CI->session->unset_userdata('diagnoses');
	}
	function empty_complaints()
	{
		$this->CI->session->unset_userdata('complaints');
	}
	function empty_obst_gyn()
	{
		$this->CI->session->unset_userdata('obst_gyn');
	}
	function empty_medical_history()
	{
		$this->CI->session->unset_userdata('medical_history');
	}
	function empty_family_history()
	{
		$this->CI->session->unset_userdata('family_history');
	}
	function empty_examination()
	{
		$this->CI->session->unset_userdata('examination');
	}

	function delete_customer()
	{
		$this->CI->session->unset_userdata('customer');
	}

	function clear_mode()
	{
		$this->CI->session->unset_userdata('sale_mode');
	}

	function clear_all()
	{
		$this->empty_diagnoses();
		$this->delete_customer();
		$this->empty_complaints();
		$this->empty_obst_gyn();
		$this->empty_medical_history();
		$this->empty_family_history();
		$this->empty_examination();
	}

	function get_lab_cart()
	{
		if(!$this->CI->session->userdata('lab_cart'))
			$this->set_lab_cart(array());

		return $this->CI->session->userdata('lab_cart');
	}

	function set_lab_cart($cart_data)
	{
		$this->CI->session->set_userdata('lab_cart',$cart_data);
	}
	
	function add_lab_item($item_id,$quantity=1,$discount=0,$price=null,$description=null,$serialnumber=null,$invoiced=null)
	{
		//bwats start pass check and age in the add_item()
		//get the status whether an item is charged under five or not
		$check=$this->CI->Item->get_info($item_id)->items_under_five;
		//get customer_id
		$customer_id=$this->get_customer();
		//get details of customer
		$info=$this->CI->Customer->get_info($customer_id);
		//get age of customer
		$age = date_diff(date_create(date("Y-m-d")),date_create(date("Y-m-d",strtotime($info->age))))->format('%y');
		//end bwats

		//make sure item exists
		if(!$this->CI->Item->exists($item_id))
		{
			//try to get item id given an item_number
			$item_id = $this->CI->Item->get_item_id($item_id);

			if(!$item_id)
				return false;
		}


		//Alain Serialization and Description

		//Get all items in the cart so far...
		$items = $this->get_lab_cart();

        //We need to loop through all items in the cart.
        //If the item is already there, get it's key($updatekey).
        //We also need to get the next key that we are going to use in case we need to add the
        //item to the cart. Since items can be deleted, we can't use a count. we use the highest key + 1.

        $maxkey=0;                       //Highest key so far
        $itemalreadyininvoice=FALSE;        //We did not find the item yet.
		$insertkey=0;                    //Key to use for new entry.
		$updatekey=0;                    //Key to use to update(quantity)

		foreach ($items as $item)
		{
            //We primed the loop so maxkey is 0 the first time.
            //Also, we have stored the key in the element itself so we can compare.

			if($maxkey <= $item['line'])
			{
				$maxkey = $item['line'];
			}

			if($item['item_id']==$item_id)
			{
				$itemalreadyininvoice=TRUE;
				$updatekey=$item['line'];
			}
		}

		$insertkey=$maxkey+1;

		//array/cart records are identified by $insertkey and item_id is just another field.
		$item = array(($insertkey)=>
		array(
			'item_id'=>$item_id,
			'line'=>$insertkey,
			'name'=>$this->CI->Item->get_info($item_id)->name,
			'item_number'=>$this->CI->Item->get_info($item_id)->item_number,
			'result'=>$result,
			'description'=>$description!=null ? $description: $this->CI->Item->get_info($item_id)->description,
			'serialnumber'=> $this->CI->Item->get_info($item_id)->is_serialized == 1 ? mt_rand(): '' ,
			'allow_alt_description'=>$this->CI->Item->get_info($item_id)->allow_alt_description,
			'is_serialized'=>$this->CI->Item->get_info($item_id)->is_serialized,
			'quantity'=>$quantity,
            'discount'=>$discount,
			//bwats edit
            		'price'=>$check==1 && ($age<=5)  ? 0 : $this->CI->Item->get_info($item_id)->unit_price,
			//'price'=>$price!=null ? $price: $this->CI->Item->get_info($item_id)->unit_price,
			'invoice'=>$invoiced!=null ? $invoiced : 0
			)
		);

		//Item already exists and is not serialized, add to quantity
		if(!$itemalreadyininvoice)
		{
			$items+=$item;
		}

		$this->set_lab_cart($items);
		return true;

	}
	
	function delete_lab_item($line)
	{
		$items=$this->get_lab_cart();
		unset($items[$line]);
		$this->set_lab_cart($items);
	}
	
	function get_lab_request_total()
	{
		$total = 0;
		foreach($this->get_lab_cart() as $item)
		{
            $total+=($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100);
		}

		return $total;
	}
	
	function get_lab_request($customer_id)
	{
		foreach($this->CI->Consultation->get_invoice($customer_id,"Lab")->result() as $row)
		{
			$this->add_lab_item($row->item_id,$row->quantity_purchased,$row->discount_percent,$row->item_unit_price,$row->description,$row->serialnumber,$row->invoice_id);
		}
	}
	
	function clear_lab_request()
	{
		$this->CI->session->unset_userdata('lab_cart');
	}
	
	function get_xray_cart()
	{
		if(!$this->CI->session->userdata('xray_cart'))
			$this->set_xray_cart(array());

		return $this->CI->session->userdata('xray_cart');
	}

	function set_xray_cart($cart_data)
	{
		$this->CI->session->set_userdata('xray_cart',$cart_data);
	}
	
	function add_xray_item($item_id,$quantity=1,$discount=0,$price=null,$description=null,$serialnumber=null,$invoiced=null)
	{
		//bwats start pass check and age in the add_item()
		//get the status whether an item is charged under five or not
		$check=$this->CI->Item->get_info($item_id)->items_under_five;
		//get customer_id
		$customer_id=$this->get_customer();
		//get details of customer
		$info=$this->CI->Customer->get_info($customer_id);
		//get age of customer
		$age = date_diff(date_create(date("Y-m-d")),date_create(date("Y-m-d",strtotime($info->age))))->format('%y');
		//end bwats

		//make sure item exists
		if(!$this->CI->Item->exists($item_id))
		{
			//try to get item id given an item_number
			$item_id = $this->CI->Item->get_item_id($item_id);

			if(!$item_id)
				return false;
		}


		//Alain Serialization and Description

		//Get all items in the cart so far...
		$items = $this->get_xray_cart();

        //We need to loop through all items in the cart.
        //If the item is already there, get it's key($updatekey).
        //We also need to get the next key that we are going to use in case we need to add the
        //item to the cart. Since items can be deleted, we can't use a count. we use the highest key + 1.

        $maxkey=0;                       //Highest key so far
        $itemalreadyininvoice=FALSE;        //We did not find the item yet.
		$insertkey=0;                    //Key to use for new entry.
		$updatekey=0;                    //Key to use to update(quantity)

		foreach ($items as $item)
		{
            //We primed the loop so maxkey is 0 the first time.
            //Also, we have stored the key in the element itself so we can compare.

			if($maxkey <= $item['line'])
			{
				$maxkey = $item['line'];
			}

			if($item['item_id']==$item_id)
			{
				$itemalreadyininvoice=TRUE;
				$updatekey=$item['line'];
			}
		}

		$insertkey=$maxkey+1;

		//array/cart records are identified by $insertkey and item_id is just another field.
		$item = array(($insertkey)=>
		array(
			'item_id'=>$item_id,
			'line'=>$insertkey,
			'name'=>$this->CI->Item->get_info($item_id)->name,
			'item_number'=>$this->CI->Item->get_info($item_id)->item_number,
			'result'=>$result,
			'description'=>$description!=null ? $description: $this->CI->Item->get_info($item_id)->description,
			'serialnumber'=> $this->CI->Item->get_info($item_id)->is_serialized == 1 ? mt_rand(): '' ,
			'allow_alt_description'=>$this->CI->Item->get_info($item_id)->allow_alt_description,
			'is_serialized'=>$this->CI->Item->get_info($item_id)->is_serialized,
			'quantity'=>$quantity,
            'discount'=>$discount,
			//bwats edit
            		'price'=>$check==1 && ($age<=5) ? 0 : $this->CI->Item->get_info($item_id)->unit_price,
			//'price'=>$price!=null ? $price: $this->CI->Item->get_info($item_id)->unit_price,
			'invoice'=>$invoiced!=null ? $invoiced : 0
			)
		);

		//Item already exists and is not serialized, add to quantity
		if(!$itemalreadyininvoice)
		{
			$items+=$item;
		}

		$this->set_xray_cart($items);
		return true;

	}
	
	function delete_xray_item($line)
	{
		$items=$this->get_xray_cart();
		unset($items[$line]);
		$this->set_xray_cart($items);
	}
	
	function get_xray_request_total()
	{
		$total = 0;
		foreach($this->get_xray_cart() as $item)
		{
            $total+=($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100);
		}

		return $total;
	}
	
	function get_xray_request($customer_id)
	{
		foreach($this->CI->Consultation->get_invoice($customer_id,"X-Ray")->result() as $row)
		{
			$this->add_xray_item($row->item_id,$row->quantity_purchased,$row->discount_percent,$row->item_unit_price,$row->description,$row->serialnumber,$row->invoice_id);
		}
	}
	
	function clear_xray_request()
	{
		$this->CI->session->unset_userdata('xray_cart');
	}
	
	function get_service_cart()
	{
		if(!$this->CI->session->userdata('service_cart'))
			$this->set_service_cart(array());

		return $this->CI->session->userdata('service_cart');
	}

	function set_service_cart($cart_data)
	{
		$this->CI->session->set_userdata('service_cart',$cart_data);
	}
	
	function add_service_item($item_id,$quantity=1,$discount=0,$price=null,$description=null,$serialnumber=null,$invoiced=null)
	{
		//bwats start pass check and age in the add_item()
		//get the status whether an item is charged under five or not
		$check=$this->CI->Item->get_info($item_id)->items_under_five;
		//get customer_id
		$customer_id=$this->get_customer();
		//get details of customer
		$info=$this->CI->Customer->get_info($customer_id);
		//get age of customer
		$age = date_diff(date_create(date("Y-m-d")),date_create(date("Y-m-d",strtotime($info->age))))->format('%y');
		//end bwats

		//make sure item exists
		if(!$this->CI->Item->exists($item_id))
		{
			//try to get item id given an item_number
			$item_id = $this->CI->Item->get_item_id($item_id);

			if(!$item_id)
				return false;
		}


		//Alain Serialization and Description

		//Get all items in the cart so far...
		$items = $this->get_service_cart();

        //We need to loop through all items in the cart.
        //If the item is already there, get it's key($updatekey).
        //We also need to get the next key that we are going to use in case we need to add the
        //item to the cart. Since items can be deleted, we can't use a count. we use the highest key + 1.

        $maxkey=0;                       //Highest key so far
        $itemalreadyininvoice=FALSE;        //We did not find the item yet.
		$insertkey=0;                    //Key to use for new entry.
		$updatekey=0;                    //Key to use to update(quantity)

		foreach ($items as $item)
		{
            //We primed the loop so maxkey is 0 the first time.
            //Also, we have stored the key in the element itself so we can compare.

			if($maxkey <= $item['line'])
			{
				$maxkey = $item['line'];
			}

			if($item['item_id']==$item_id)
			{
				$itemalreadyininvoice=TRUE;
				$updatekey=$item['line'];
			}
		}

		$insertkey=$maxkey+1;

		//array/cart records are identified by $insertkey and item_id is just another field.
		$item = array(($insertkey)=>
		array(
			'item_id'=>$item_id,
			'line'=>$insertkey,
			'name'=>$this->CI->Item->get_info($item_id)->name,
			'item_number'=>$this->CI->Item->get_info($item_id)->item_number,
			'result'=>$result,
			'description'=>$description!=null ? $description: $this->CI->Item->get_info($item_id)->description,
			'serialnumber'=> $this->CI->Item->get_info($item_id)->is_serialized == 1 ? mt_rand(): '' ,
			'allow_alt_description'=>$this->CI->Item->get_info($item_id)->allow_alt_description,
			'is_serialized'=>$this->CI->Item->get_info($item_id)->is_serialized,
			'quantity'=>$quantity,
            'discount'=>$discount,
			 //bwats edit
            		'price'=>$check==1 && ($age<=5) ? 0 : $this->CI->Item->get_info($item_id)->unit_price,
			//'price'=>$price!=null ? $price: $this->CI->Item->get_info($item_id)->unit_price,
			'invoice'=>$invoiced!=null ? $invoiced : 0
			)
		);

		//Item already exists and is not serialized, add to quantity
		if(!$itemalreadyininvoice)
		{
			$items+=$item;
		}

		$this->set_service_cart($items);
		return true;

	}
	
	function delete_service_item($line)
	{
		$items=$this->get_service_cart();
		unset($items[$line]);
		$this->set_service_cart($items);
	}
	
	function get_service_request_total()
	{
		$total = 0;
		foreach($this->get_service_cart() as $item)
		{
            $total+=($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100);
		}

		return $total;
	}
	
	function get_service_request($customer_id)
	{
		foreach($this->CI->Consultation->get_invoice($customer_id,"Nursing")->result() as $row)
		{
			$this->add_service_item($row->item_id,$row->quantity_purchased,$row->discount_percent,$row->item_unit_price,$row->description,$row->serialnumber,$row->invoice_id);
		}
	}
	
	function clear_service_request()
	{
		$this->CI->session->unset_userdata('service_cart');
	}
}
?>
