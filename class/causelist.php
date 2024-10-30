<?php 
class Lmgtcauselist /*<---START Lmgtcauselist  CLASS--->*/
{
	//--------- CURRENT DATE CAUSELIST ----------//
	public function MJ_lawmgt_get_current_date_causelist()
	{
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix . 'lmgt_judgments';
		$table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		
		$current_date =date('Y-m-d');
		$causedata = $wpdb->get_results("SELECT * FROM $table_lmgt_judgments where date='$current_date'");
		$causedata1 = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where date='$current_date'");
		
		$case_id=array();
		if(!empty($causedata))
		{		
			foreach($causedata as $data)
			{
				$case_id[]= sanitize_text_field($data->case_id);
			}	
		}
		if(!empty($causedata1))
		{		
			foreach($causedata1 as $data)
			{
				$case_id[]= sanitize_text_field($data->case_id);
			}	
		}
		 
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_case where id IN (".implode(',', $case_id).") AND case_status='open'");
		}
		else
		{
			$result ='';
		}
		 		
		return $result; 
	}	
	//--------- CURRENT DATE CAUSELIST BY ATTORNEY ----------//
	public function MJ_lawmgt_get_current_date_causelist_by_attorney()
	{
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix . 'lmgt_judgments';
		$table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$attorney_id=get_current_user_id();
		$current_date =date('Y-m-d');
		$causedata = $wpdb->get_results("SELECT * FROM $table_lmgt_judgments where date='$current_date'");
		$causedata1 = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where date='$current_date'");
		
		$case_id=array();
		if(!empty($causedata))
		{		
			foreach($causedata as $data)
			{
				$case_id[]= sanitize_text_field($data->case_id);
			}	
		}
		if(!empty($causedata1))
		{		
			foreach($causedata1 as $data)
			{
				$case_id[]= sanitize_text_field($data->case_id);
			}	
		}
		 
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_case where id IN (".implode(',', $case_id).") AND (FIND_IN_SET($attorney_id,case_assgined_to) OR created_by=$attorney_id) AND case_status='open'");
		}
		else
		{
			$result ='';
		}
		 		
		return $result; 
	}	
	//--------- CURRENT DATE CAUSELIST BY CLIENT ----------//
	public function MJ_lawmgt_get_current_date_causelist_by_client()
	{
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix . 'lmgt_judgments';
		$table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$current_date =date('Y-m-d');
		$causedata = $wpdb->get_results("SELECT * FROM $table_lmgt_judgments where date='$current_date'");
		$causedata1 = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where date='$current_date'");
		
		$case_id=array();
		if(!empty($causedata))
		{		
			foreach($causedata as $data)
			{	
				$result_client_case=$this->MJ_lawmgt_get_client_case_or_not($data->case_id);
				
				if($result_client_case == 1)
				{
					$case_id[]= $data->case_id;
				}
			}	
		}
		if(!empty($causedata1))
		{		
			foreach($causedata1 as $data)
			{
				$result_client_case=$this->MJ_lawmgt_get_client_case_or_not($data->case_id);
				if($result_client_case == 1)
				{
					$case_id[]= $data->case_id;
				}
			}	
		}
		 
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_case where id IN (".implode(',', $case_id).") AND case_status='open'");
		}
		else
		{
			$result ='';
		}
		 		
		return $result; 
	}	
	/*<--- GET CLIESE CASE OR NOT  FUNCTION --->*/
	public function MJ_lawmgt_get_client_case_or_not($case_id)
	{
		
		global $wpdb;
		$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
		$user_id=get_current_user_id();
		$result = $wpdb->get_row("SELECT * FROM $table_case_contacts where case_id=$case_id AND user_id=$user_id");
		
		if(!empty($result))
		{
			$result=1;
		}
		else
		{
			$result=0;
		}	
		return $result;
	}
	//--------- CURRENT DATE CAUSELIST BY ATTORNEY COURT FILTER----------//
	public function MJ_lawmgt_get_causelist_by_attorney_wise_court_filter($court_id)
	{
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix . 'lmgt_judgments';
		$table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$attorney_id=get_current_user_id();
		$current_date =date('Y-m-d');
		$causedata = $wpdb->get_results("SELECT * FROM $table_lmgt_judgments where date='$current_date'");
		$causedata1 = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where date='$current_date'");
		
		$case_id=array();
		if(!empty($causedata))
		{		
			foreach($causedata as $data)
			{
				$case_id[]= sanitize_text_field($data->case_id);
			}	
		}
		if(!empty($causedata1))
		{		
			foreach($causedata1 as $data)
			{
				$case_id[]= sanitize_text_field($data->case_id);
			}	
		}
		 
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_case where id IN (".implode(',', $case_id).") AND FIND_IN_SET($attorney_id,case_assgined_to) AND case_status='open' AND court_id=$court_id");
		}
		else
		{
			$result ='';
		}
		 		
		return $result; 
	}
	//--------- CURRENT DATE CAUSELIST BY CLIENT COURT FILTER ----------//
	public function MJ_lawmgt_get_causelist_by_client_wise_court_filter($court_id)
	{
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix . 'lmgt_judgments';
		$table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$current_date =date('Y-m-d');
		$causedata = $wpdb->get_results("SELECT * FROM $table_lmgt_judgments where date='$current_date'");
		$causedata1 = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where date='$current_date'");
		
		$case_id=array();
		if(!empty($causedata))
		{		
			foreach($causedata as $data)
			{	
				$result_client_case=$this->MJ_lawmgt_get_client_case_or_not($data->case_id);
				
				if($result_client_case == 1)
				{
					$case_id[]= sanitize_text_field($data->case_id);
				}
			}	
		}
		if(!empty($causedata1))
		{		
			foreach($causedata1 as $data)
			{
				$result_client_case=$this->MJ_lawmgt_get_client_case_or_not($data->case_id);
				if($result_client_case == 1)
				{
					$case_id[]= sanitize_text_field($data->case_id);
				}
			}	
		}
		 
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_case where id IN (".implode(',', $case_id).") AND case_status='open' AND court_id=$court_id");
		}
		else
		{
			$result ='';
		}
		 		
		return $result; 
	}	
	//--------- CURRENT DATE CAUSELIST AND COURT FILTER----------//
	public function MJ_lawmgt_get_all_causelist_court_filter($court_id)
	{
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix . 'lmgt_judgments';
		$table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		
		$current_date =date('Y-m-d');
		$causedata = $wpdb->get_results("SELECT * FROM $table_lmgt_judgments where date='$current_date'");
		$causedata1 = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where date='$current_date'");
		
		$case_id=array();
		if(!empty($causedata))
		{		
			foreach($causedata as $data)
			{
				$case_id[]= sanitize_text_field($data->case_id);
			}	
		}
		if(!empty($causedata1))
		{		
			foreach($causedata1 as $data)
			{
				$case_id[]= sanitize_text_field($data->case_id);
			}	
		}
		 
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_case where id IN (".implode(',', $case_id).") AND case_status='open' AND court_id=$court_id");
		}
		else
		{
			$result ='';
		}
		 		
		return $result; 
	}
	//--------- WEEKLY CAUSELIST ----------//
	public function MJ_lawmgt_get_weekly_causelist()
	{
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix . 'lmgt_judgments';
		$table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$current_date =date('Y-m-d');
		$new_date = date('Y-m-d', strtotime('-7 day', strtotime($current_date)));
		 
		$causedata = $wpdb->get_results("SELECT * FROM $table_lmgt_judgments where date BETWEEN '$new_date' AND '$current_date'");
		$causedata1 = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where date BETWEEN '$new_date' AND '$current_date'");
		
		$case_id=array();
		if(!empty($causedata))
		{		
			foreach($causedata as $data)
			{
				$case_id[]= sanitize_text_field($data->case_id);
			}	
		}
		if(!empty($causedata1))
		{		
			foreach($causedata1 as $data)
			{
				$case_id[]=sanitize_text_field($data->case_id);
			}	
		}
		 
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_case where id IN (".implode(',', $case_id).") AND case_status='open'");
		}
		else
		{
			$result ='';
		}
		 		
		return $result; 
	}	
	//--------- WEEKLY CAUSELIST BY ATTORNEY ----------//
	public function MJ_lawmgt_get_weekly_causelist_by_attorney()
	{
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix . 'lmgt_judgments';
		$table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$attorney_id=get_current_user_id();
		
		$current_date =date('Y-m-d');
		$new_date = date('Y-m-d', strtotime('-7 day', strtotime($current_date)));
		
		$causedata = $wpdb->get_results("SELECT * FROM $table_lmgt_judgments where date BETWEEN '$new_date' AND '$current_date'");
		
		$causedata1 = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where date BETWEEN '$new_date' AND '$current_date'");
		
		$case_id=array();
		if(!empty($causedata))
		{		
			foreach($causedata as $data)
			{
				$case_id[]= sanitize_text_field($data->case_id);
			}	
		}
		if(!empty($causedata1))
		{		
			foreach($causedata1 as $data)
			{
				$case_id[]= sanitize_text_field($data->case_id);
			}	
		}
		 
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_case where id IN (".implode(',', $case_id).") AND (FIND_IN_SET($attorney_id,case_assgined_to) OR created_by=$attorney_id) AND case_status='open'");
		}
		else
		{
			$result ='';
		}
		 		
		return $result; 
	}	
	//--------- CURRENT DATE CAUSELIST BY CLIENT ----------//
	public function MJ_lawmgt_get_weekly_causelist_by_client()
	{
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix . 'lmgt_judgments';
		$table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		
		$current_date =date('Y-m-d');
		$new_date = date('Y-m-d', strtotime('-7 day', strtotime($current_date)));
		
		$causedata = $wpdb->get_results("SELECT * FROM $table_lmgt_judgments where date BETWEEN '$new_date' AND '$current_date'");
		$causedata1 = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where date BETWEEN '$new_date' AND '$current_date'");
		
		$case_id=array();
		if(!empty($causedata))
		{		
			foreach($causedata as $data)
			{	
				$result_client_case=$this->MJ_lawmgt_get_client_case_or_not($data->case_id);
				
				if($result_client_case == 1)
				{
					$case_id[]= sanitize_text_field($data->case_id);
				}
			}	
		}
		if(!empty($causedata1))
		{		
			foreach($causedata1 as $data)
			{
				$result_client_case=$this->MJ_lawmgt_get_client_case_or_not($data->case_id);
				if($result_client_case == 1)
				{
					$case_id[]= sanitize_text_field($data->case_id);
				}
			}	
		}
		 
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_case where id IN (".implode(',', $case_id).") AND case_status='open'");
		}
		else
		{
			$result ='';
		}
		 		
		return $result; 
	}		
} /*<---END  Lmgtcauselist  CLASS--->*/
?>