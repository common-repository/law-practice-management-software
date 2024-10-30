<?php  
set_time_limit(300); // 
class MJ_lawmgt_case  /*<---START Lmgtcase  CLASS--->*/
{
	/*<---  ADD CASE FUNCTION --->*/
	public function MJ_lawmgt_add_case($data)
	{		
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$table_case_staff_users = $wpdb->prefix. 'lmgt_case_staff_users';
		$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
		$table_case_reminder = $wpdb->prefix. 'lmgt_case_reminder';
		$table_orders = $wpdb->prefix. 'lmgt_orders';

        $selected_id_filter = array_map( 'sanitize_text_field', wp_unslash( $data['contact_name']));
        $casedata['user_id'] = implode(",", $selected_id_filter);		
		 
		//$casedata['user_id']=implode(',',$data['contact_name']);
		$casedata['case_name']=sanitize_text_field($data['case_name']);
		$casedata['case_number']=sanitize_text_field($data['case_number']);
		$casedata['court_id']=sanitize_text_field($data['court_id']);
		$casedata['state_id']=sanitize_text_field($data['state_id']);
		$casedata['bench_id']=sanitize_text_field($data['bench_id']);
		
		$casedata['case_assgined_to']=implode(',',$data['assginedto']);
		$user_email = explode(',',$casedata['case_assgined_to']);
		$casedata['earlier_history']=sanitize_textarea_field($data['earlier_history']);			
		$casedata['open_date'] = sanitize_text_field(date('Y-m-d',strtotime($data['open_date'])));
		$casedata['court_hall_no']=sanitize_text_field($data['court_hall_no']);	
		$casedata['floor']=sanitize_text_field($data['floor']);
		$casedata['referred_by']=sanitize_text_field($data['referred_by']);
		$casedata['priority']=sanitize_text_field($data['priority']);
		$casedata['crime_no']=sanitize_text_field($data['crime_no']);	
		$casedata['fri_no']=sanitize_text_field($data['fri_no']);	
		$casedata['classification']=sanitize_text_field($data['classification']);
		$casedata['crime_details']=sanitize_textarea_field($data['crime_details']);	
		$casedata['practice_area_id']=sanitize_text_field($data['practice_area']);	
		$casedata['statute_of_limitations'] = sanitize_text_field(date('Y-m-d',strtotime($data['statute_of_limitations'])));	
		$casedata['case_description']=sanitize_textarea_field($data['case_description']);
		$casedata['billing_contact_id']=sanitize_text_field($data['billing_contact']);
		$casedata['billing_type']=sanitize_text_field($data['billing_type']);
		$casedata['case_status']='open';			
		 
		 $current_user=wp_get_current_user();
		 $date= date("Y-m-d") . "<br>"; 		
		 $user_data= sanitize_user($current_user->user_login);
		 $current_user_id= MJ_lawmgt_get_roles($current_user->ID);
		 
			$added_on_translation=esc_html__('Added on ','lawyer_mgt');
			$by=esc_html__(' by ','lawyer_mgt');
			
		 $casedata['added_on']=$added_on_translation.' '.$date.' '.$by.' '.$user_data." ( ".$current_user_id." ) ";
	
		if(esc_attr($data['action'])=='edit')
		{			
			/*<--- EDIT CASE  --->*/
			$casedata['updated_date']=date("Y-m-d H:i:s");	
			$stage_case_data= sanitize_text_field($data['stages']);
			$stages_data=array();
			if(!empty($stage_case_data))
			{
				foreach($stage_case_data as $key_stage=>$value_stage)
				{
					$stages_data[]=array('id'=>$key_stage,'value'=>$value_stage);
				}
			}	
			//$stages_data_sanitize = array_map( 'sanitize_text_field', wp_unslash( $stages_data ) );		
			$casedata['stages']=json_encode($stages_data);
			 
			 $custom_fileld_value=array();			 
			 $custom_fileld_value_jason_array=array();	
			if(!empty($data['cst']))
			{
				 foreach($data['cst'] as $key=>$value)
				 {
					 $custom_fileld_value[][]=array("id" => "$key", "value" => "$value");				  
				 }	
			}
			$custom_fileld_valuesanitize = array_map( 'sanitize_text_field', wp_unslash( $custom_fileld_value ) );
			$custom_fileld_value_jason_array['custom_fileld_value']=json_encode($custom_fileld_valuesanitize); 
			if(!empty($custom_fileld_value_jason_array))
			{
			
			foreach($custom_fileld_value_jason_array as $key1=>$val1)
			{
				$case_id['id']= sanitize_text_field($data['case_id']);
				$casedata['custom_fileld_value']=sanitize_text_field($val1);		
			}	
			}
			// update opponent details //
			$opponent_value=array();			 
			if(!empty($data['opponents']))
			{
				foreach($data['opponents'] as $key=>$value)
				{
					 $opponent_value[]=array("opponents_name" => sanitize_text_field($value), "opponents_email" =>sanitize_email($data['opponents_email'][$key]) ,"opponents_phonecode" => sanitize_text_field($data['opponents_phonecode'][$key]), "opponents_mobile_number" => sanitize_text_field($data['opponents_mobile_number'][$key]));				  
				}	
			}	
			//$opponent_value_valuesanitize = array_map( 'sanitize_text_field', wp_unslash( $opponent_value ) );
			$casedata['opponents_details']=json_encode($opponent_value); 
			
			// update opponent Attorney details //
			$opponent_attorney_value=array();			 
			if(!empty($data['opponents_attorney']))
			{
				foreach($data['opponents_attorney'] as $key1=>$value1)
				{
					 $opponent_attorney_value[]=array("opponents_attorney_name" => sanitize_text_field($value1), "opponents_attorney_email" =>sanitize_email($data['opponents_attorney_email'][$key1]) ,"opponents_attorney_phonecode" => sanitize_text_field($data['opponents_attorney_phonecode'][$key1]), "opponents_attorney_mobile_number" => sanitize_text_field($data['opponents_attorney_mobile_number'][$key1]));				  
				}	
			}	
			//$opponent_attorney_value_valuesanitize = array_map( 'sanitize_text_field', wp_unslash( $opponent_attorney_value ) );
			$casedata['opponents_attorney_details']=json_encode($opponent_attorney_value); 
			
			$result_updated=$wpdb->update( $table_case, $casedata ,$case_id); 
			/*<---  CASH REMINDER --->*/
			$case_id=$data['case_id'];
			
			$result_reminder_data=$wpdb->query("DELETE FROM $table_case_reminder WHERE case_id = $case_id");
			
			$type= sanitize_text_field($data['casedata']);			
			
			if(!empty($data['casedata']))
			{
				foreach($type['type'] as $key=>$value)
				{	
					$reminderdata=array();
					$reminder_id['id']=$type['id'][$key];
					$reminderdata['case_id']=intval($data['case_id']);
					$reminderdata['user_id']= sanitize_text_field($current_user->ID);
					$reminderdata['statute_of_limitations'] = sanitize_text_field($data['statute_of_limitations']);		
					$reminderdata['reminder_type']=$type['type'][$key];
					$reminderdata['reminder_time_value']=$type['remindertimevalue'][$key];
					$reminderdata['reminder_time_format']=$type['remindertimeformat'][$key];	
					
					$result=$wpdb->insert( $table_case_reminder, $reminderdata);						
				} 
			}
			
			$case_id=$data['case_id'];
			$result = $wpdb->query("DELETE FROM $table_case_contacts where case_id= ".$case_id);
			
			if(!empty($data['contact_name']))
			{			
				foreach($data['contact_name'] as $key=>$user_id)
				{					
					$contactdata['case_id']= sanitize_text_field($data['case_id']);
					$contactdata['user_id']=sanitize_text_field($user_id);						
					
				    $result=$wpdb->insert( $table_case_contacts, $contactdata);					
				}									
			}
				/*<---  CASE Updated MAIL NOTIFICATION --->*/
			if($result_updated)
			{
				$contact_attorney_data=MJ_lawmgt_get_contact_and_attorney_data_by_case_id($case_id);
				if(!empty($contact_attorney_data))
			    {
			
				foreach($contact_attorney_data as $assign_userdata)
				{ 		
					$userdata=get_userdata($assign_userdata);
					$to=sanitize_email($userdata->user_email);
					$name = sanitize_text_field($userdata->display_name);
					$system_name=get_option('lmgt_system_name');
					$arr['{{Lawyer System Name}}']= sanitize_text_field($system_name);							
					$arr['{{User Name}}']=$name;	
					$arr['{{Case Name}}']=sanitize_text_field($data['case_name']);
					$arr['{{Case Number}}']=sanitize_text_field($data['case_number']);	
					$arr['{{Open Date}}']=$data['open_date'];	
					$arr['{{Statute of Limitations Date}}']=$data['statute_of_limitations'];	
				 
					$subject =get_option('lmgt_case_assigned_upadete_email_subject');
					$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
					$message = get_option('lmgt_case_assigned_update_email_template');		
					$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
					MJ_lawmgt_send_mail($to,$subject_replacement,$message_replacement);
				}
			}
			}
			
		/*<---  AUDIT LOG --->*/
			$case_name=MJ_lawmgt_get_case_name($case_id);
			
			$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';
			$updated_case=esc_html__('Updated Case ','lawyer_mgt');
			MJ_lawmgt_append_audit_log($updated_case.' '.$case_name,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_log_for_downlaod($updated_case.' '.$case_name,get_current_user_id(),'');
			MJ_lawmgt_append_audit_caselog($updated_case.' '.$case_name,get_current_user_id(),$case_link);
			MJ_lawmgt_userwise_activity($updated_case.' '.$case_name,get_current_user_id(),$case_link);
			
			MJ_lawmgt_append_audit_caselog_download($updated_case.' '.$case_name, get_current_user_id());
			
			
				
			return $result;
		}
		else
		{	
		/*<---  ADD CASE --->*/
			$casedata['first_hearing_date']=sanitize_text_field(date('Y-m-d',strtotime($data['first_hearing_date'])));
			$stage_case_data=sanitize_text_field($data['stages']);
			$stages_data=array();
			if(!empty($contact_attorney_data))
			{
			foreach($contact_attorney_data as $key_stage=>$value_stage)
			{
				$stages_data[]=array('id'=>$key_stage,'value'=>$value_stage);
			}
			}	
			//$stages_data_sanitize = array_map( 'sanitize_text_field', wp_unslash( $stages_data ) );
			$casedata['stages']=json_encode($stages_data);
			 
			$custom_fileld_value=array();			 
			$custom_fileld_value_jason_array=array();	
			 
			if(!empty($data['cst']))
			{
				foreach($data['cst'] as $key=>$value)
				{
					$custom_fileld_value[][]=array("id" =>  "$key", "value" => "$value");				  
				}	
			}
			$custom_fileld_value_sanitize = array_map( 'sanitize_text_field', wp_unslash( $custom_fileld_value ) );
			$custom_fileld_value_jason_array['custom_fileld_value']=json_encode($custom_fileld_value_sanitize); 
			if(!empty($custom_fileld_value_jason_array))
			{
			foreach($custom_fileld_value_jason_array as $key1=>$val1)
			{
				$casedata['custom_fileld_value']=$val1;				
			}
			}
			
			$casedata['created_date']=date("Y-m-d H:i:s");
			$casedata['created_by']=get_current_user_id();
			
			// Add opponent details //
			$opponent_value=array();			 
			if(!empty($data['opponents']))
			{
				foreach($data['opponents'] as $key=>$value)
				{
					 $opponent_value[]=array("opponents_name" => sanitize_text_field($value), "opponents_email" =>sanitize_email($data['opponents_email'][$key]) ,"opponents_phonecode" => sanitize_text_field($data['opponents_phonecode'][$key]), "opponents_mobile_number" => sanitize_text_field($data['opponents_mobile_number'][$key]));				  
				}	
			}
			//$opponent_value_sanitize = array_map( 'sanitize_text_field', wp_unslash( $opponent_value ) );
			$casedata['opponents_details']=json_encode($opponent_value); 
			
			// Add opponent Attorney details //
			$opponent_attorney_value=array();			 
			if(!empty($data['opponents_attorney']))
			{
				foreach($data['opponents_attorney'] as $key1=>$value1)
				{
					 $opponent_attorney_value[]=array("opponents_attorney_name" => sanitize_text_field($value1), "opponents_attorney_email" =>sanitize_email($data['opponents_attorney_email'][$key1]),"opponents_attorney_phonecode" => sanitize_text_field($data['opponents_attorney_phonecode'][$key1]), "opponents_attorney_mobile_number" => sanitize_text_field($data['opponents_attorney_mobile_number'][$key1]));				  
				}	
			}	
			//$opponent_attorney_value_sanitize = array_map( 'sanitize_text_field', wp_unslash( $opponent_attorney_value ) );
			$casedata['opponents_attorney_details']=json_encode($opponent_attorney_value); 
			
			
			$result=$wpdb->insert( $table_case, $casedata);
			
			$case_id = sanitize_text_field($wpdb->insert_id);
		
			if(!empty($data['contact_name']))
			{				
				foreach($data['contact_name'] as $key=>$user_id)
				{					
					$contactdata['case_id']=$case_id;
					$contactdata['user_id']=$user_id;						
					
				    $result=$wpdb->insert( $table_case_contacts, $contactdata);					
				}									
			}
			
			if(!empty($data['first_hearing_date']))
			{				
				$hearing_data['case_id']=$case_id; 
				$hearing_data['next_hearing_date']=sanitize_text_field(date('Y-m-d',strtotime($data['first_hearing_date'])));
				$hearing_data['orders_details']=esc_html__('First Hearing Date.','lawyer_mgt');						
				$hearing_data['date']=date('Y-m-d');						
				$result=$wpdb->insert( $table_orders, $hearing_data);		
			}
			// case Reminder
			if(!empty($data['casedata']))
			{					
				$type=$data['casedata'];				
				
				foreach($type['type'] as $key=>$value)
				{	
					$reminderdata['case_id']=$case_id; 
					$reminderdata['user_id']= sanitize_text_field($current_user->ID);
					$reminderdata['statute_of_limitations'] = sanitize_text_field($data['statute_of_limitations']);		
					$reminderdata['reminder_type']=$type['type'][$key];
					$reminderdata['reminder_time_value']=$type['remindertimevalue'][$key];
					$reminderdata['reminder_time_format']=$type['remindertimeformat'][$key];
					
					$result=$wpdb->insert( $table_case_reminder, $reminderdata);
				}
			}
			
			/*<---  CASE ASSIGN MAIL NOTIFICATION --->*/
			if($result)
			{
			if(!empty($user_email))
			{
				foreach($user_email as $user_email1)
				{	
					$login_link=home_url();
					$system_name=get_option('lmgt_system_name');
					$userdata=get_userdata($user_email1);	
					$to=sanitize_email($userdata->user_email);
					$name = sanitize_text_field($userdata->display_name);
					$arr['{{Lawyer System Name}}']=sanitize_text_field($system_name);							
					$arr['{{Attrony Name}}']=sanitize_text_field($name);
					$arr['{{Case Name}}']=sanitize_text_field($data['case_name']);
					$arr['{{Case Number}}']=sanitize_text_field($data['case_number']);	
					$arr['{{Open Date}}']=sanitize_text_field($data['open_date']);	
					$arr['{{Statute of Limitations Date}}']=sanitize_text_field($data['statute_of_limitations']);	
					$arr['{{Login Link}}']=sanitize_url($login_link);	
					 
					$subject =get_option('lmgt_case_assigned_email_subject');
					$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
					$message = get_option('lmgt_case_assigned_email_template');		
					$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
					MJ_lawmgt_send_mail($to,$subject_replacement,$message_replacement);
				}
			}
				
			}
			/*<---  CASE ASSIGN MAIL Registration --->*/
		 
			if($result)
			{
				if(!empty($data['contact_name']))
			    {
				foreach($data['contact_name'] as $key=>$user_id)
				{		
					$userdata=get_userdata($user_id);						
					$arr['{{Lawyer System Name}}']=$system_name;							
					$arr['{{User Name}}']=sanitize_text_field($userdata->display_name);
					$arr['{{Login Link}}']= sanitize_url($login_link);	
					$to=sanitize_email($userdata->user_email);	
					
					$subject =get_option('lmgt_case_email_subject');
					$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
					$message = get_option('lmgt_case_email_template');	
					$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);			
					MJ_lawmgt_send_mail($to,$subject_replacement,$message_replacement);
				}
			}				
			}
			 //----SEND MAIL HEARING DATE--------//
			if($result)
			{
				$contact_attorney_data=MJ_lawmgt_get_contact_and_attorney_data_by_case_id($case_id);
				if(!empty($contact_attorney_data))
			    {
				foreach($contact_attorney_data as $assign_userdata)
				{ 				
					$system_name=get_option('lmgt_system_name');				
						
					$userdata=get_userdata($assign_userdata);
					$to= sanitize_email($userdata->user_email);
					$name = sanitize_text_field($userdata->display_name);
					$arr['{{Lawyer System Name}}']= sanitize_text_field($system_name);
					$arr['{{User Name}}']=$name;	
					$arr['{{Case Name}}']=sanitize_text_field($data['case_name']);
					$arr['{{Case Number}}']=sanitize_text_field($data['case_number']);
					$arr['{{Next Hearing Date}}']= $data['first_hearing_date'];
				 
					$subject =get_option('lmgt_next_hearing_date_email_subject');
					$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
					$message = get_option('lmgt_next_hearing_date_email_template');	
					$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
					 
					MJ_lawmgt_send_mail($to,$subject_replacement,$message_replacement); 	
				}
				}
			}
 			//audit Log
			$case_name=MJ_lawmgt_get_case_name($case_id);
			
			$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.$case_name.'</a>';
			
			$added_case=esc_html__('Added New Case ','lawyer_mgt');
			MJ_lawmgt_append_audit_log($added_case.' '.$case_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_log_for_downlaod($added_case.' '.$case_name,get_current_user_id(),'');
			MJ_lawmgt_append_audit_caselog($added_case.' '.$case_link,get_current_user_id(),$case_link);
			MJ_lawmgt_userwise_activity($added_case.' '.$case_link,get_current_user_id(),$case_link);
			
			MJ_lawmgt_append_audit_caselog_download($added_case.' '.$case_name, get_current_user_id());
			
       		return $result;
		}	
	}
	/*<---  GET ALL CONTECT FUNCTION --->*/
	public function MJ_lawmgt_get_all_contact($id)
	{
	
		global $wpdb;
		$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
		
		$result = $wpdb->get_results("SELECT * FROM $table_case_contacts where case_id=$id");
		return $result;	
	}
	/*<---  GET OPEN ALL CASE FUNCTION --->*/
	public function MJ_lawmgt_get_open_all_my_case($id)
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
	
		$result = $wpdb->get_results("SELECT * FROM $table_case where case_status='open' AND user_id=$id ORDER BY id DESC");
	
		return $result;	
	}	
	
	/*<--- GET ALL OPEN CASE FUNCTION --->*/
	public function MJ_lawmgt_get_open_all_case()
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
	
		$result = $wpdb->get_results("SELECT * FROM $table_case where case_status='open' ORDER BY id DESC");
	
		return $result;	
	}	
	/*<--- GET ALL OPEN CASE Created by FUNCTION --->*/
	public function MJ_lawmgt_get_open_all_case_created_by()
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_case where case_status='open' AND created_by=$current_user_id ORDER BY id DESC");
	
		return $result;	
	}

	/*<--- GET ALL OPEN CASE AND CASETYPE Created by FUNCTION --->*/
	public function MJ_lawmgt_get_all_case_created_by_casetype()
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT DISTINCT practice_area_id  FROM $table_case where created_by=$current_user_id ORDER BY id DESC");
	
		return $result;	
	}
		/*<--- GET ALL CASE Created by FUNCTION --->*/
	public function MJ_lawmgt_get_all_case_created_by()
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_case where created_by=$current_user_id ORDER BY id DESC");
	
		return $result;	
	}	
		/*<--- GET ALL CLOSE CASE  BY ID FUNCTION --->*/
	public function MJ_lawmgt_get_close_all_my_case($id)
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
	
		$result = $wpdb->get_results("SELECT * FROM $table_case where case_status='close' AND user_id=$id ORDER BY id DESC");
		return $result;	
	}
	
	/*<--- GET ALL CLOSE CASE  FUNCTION --->*/
	public function MJ_lawmgt_get_close_all_case()
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
	
		$result = $wpdb->get_results("SELECT * FROM $table_case where case_status='close' ORDER BY id DESC");
		return $result;	
	}
	/*<--- GET ALL CLOSE CASE Created By  FUNCTION --->*/
	public function MJ_lawmgt_get_close_all_case_created_by()
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_case where case_status='close' AND created_by=$current_user_id ORDER BY id DESC");
		return $result;	
	}
	/*<--- GET OPEN AND Close CASE  BY CLIENT FUNCTION --->*/
	public function MJ_lawmgt_get_open_and_close_case_by_client()
	{
		global $wpdb;
		$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$current_user_id = get_current_user_id();
		
		$casedata = $wpdb->get_results("SELECT * FROM $table_case_contacts where user_id=$current_user_id");
		
		$case_id=array();
		if(!empty($casedata))
		{		
			foreach($casedata as $data)
			{
				$case_id[]=$data->case_id;
			}	
		}
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_case where id IN (".implode(',', $case_id).") OR created_by=$current_user_id");
		}
		else
		{
			$result ='';
		}	
		return $result;	
	}
	/*<--- GET OPEN  CASE  BY CLIENT FUNCTION --->*/
	public function MJ_lawmgt_get_open_case_by_client()
	{
		global $wpdb;
		$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$current_user_id = get_current_user_id();
		
		$casedata = $wpdb->get_results("SELECT * FROM $table_case_contacts where user_id=$current_user_id");
		
		$case_id=array();
		if(!empty($casedata))
		{		
			foreach($casedata as $data)
			{
				$case_id[]=$data->case_id;
			}	
		}
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_case where (case_status='open') AND (id IN (".implode(',', $case_id).") OR created_by=$current_user_id)");
		}
		else
		{
			$result ='';
		}	
		return $result;	
	}
	
	/*<--- GET ALL CLOSE CASE  BY CLIENT FUNCTION --->*/
	public function MJ_lawmgt_get_close_case_by_client()
	{
		global $wpdb;
		$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$current_user_id = get_current_user_id();
		
		$casedata = $wpdb->get_results("SELECT * FROM $table_case_contacts where user_id=$current_user_id");
		$case_id=array();
		if(!empty($casedata))
		{		
			foreach($casedata as $data)
			{
				$case_id[]=$data->case_id;
			}	
		}
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_case where (case_status='close') AND (id IN (".implode(',', $case_id).") OR created_by=$current_user_id)");
		}
		else
		{
			$result ='';
		}	
		return $result;	
	}
	/*<---  GET OPEN CASE BY ATTORNEY FUNCTION --->*/
	public function MJ_lawmgt_get_open_case_by_attorney($id)
	{
		
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$result = $wpdb->get_results("SELECT * FROM $table_case where  (case_status='open') AND (FIND_IN_SET($id,case_assgined_to) OR created_by=$id)");
		 
		return $result;	
	}	
	/*<---  GET ALL CASE BY ATTORNEY FUNCTION --->*/
	public function MJ_lawmgt_get_all_case_by_attorney_id($id)
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
		
		$result = $wpdb->get_results("SELECT * FROM $table_case where FIND_IN_SET($id,case_assgined_to) OR created_by=$id");
		return $result;	
	}
	/*<--- GET ALL CLOSE CASE  BY Attrony FUNCTION --->*/
	public function MJ_lawmgt_get_close_case_by_attorney($id)
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$result = $wpdb->get_results("SELECT * FROM $table_case where (case_status='close') AND (FIND_IN_SET($id,case_assgined_to) OR created_by=$id)");
		return $result;	
	}
	/*<--- GET ALL OPEN ALL FIRM  CASE FUNCTIONTION --->*/
	public function MJ_lawmgt_get_open_all_firm_case()
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
	
		$result = $wpdb->get_results("SELECT * FROM $table_case where case_status='open' ORDER BY id DESC");
		return $result;	
	}	
	public function MJ_lawmgt_get_close_all_firm_case()
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
	
		$result = $wpdb->get_results("SELECT * FROM $table_case where case_status='close' ORDER BY id DESC");
		return $result;	
	}
	/*<--- GET ALL CASE FUNCTION --->*/
	public function MJ_lawmgt_get_all_case()
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
	
		$result = $wpdb->get_results("SELECT * FROM $table_case");
		return $result;	
	}
	/*<--- GET ALL CASE TYPE FUNCTION --->*/
	public function MJ_lawmgt_get_all_case_type()
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
	
		$result = $wpdb->get_results("SELECT DISTINCT practice_area_id FROM $table_case");
		 
		return $result;	
	}
	/*<--- GET ALL CASE TYPE FUNCTION --->*/
	public function MJ_lawmgt_get_all_practicearea()
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
	
		$result = $wpdb->get_results("SELECT DISTINCT practice_area_id FROM $table_case");
		 
		return $result;	
	}
	/*<---  GET ALL OPEN CASE BY ATTORNEY FUNCTION --->*/
	public function MJ_lawmgt_get_all_open_case_by_attorney($attorney_id)
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
	
		$result = $wpdb->get_results("SELECT * FROM $table_case where (case_status='open') AND (FIND_IN_SET($attorney_id,case_assgined_to) OR created_by=$attorney_id)");
		return $result;	
	} 
	/*<---  GET ALL CASE BY ATTORNEY AND CASE TYPE FUNCTION --->*/
	public function MJ_lawmgt_get_all_case_by_attorney_and_casetype($attorney_id)
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
	
		$result = $wpdb->get_results("SELECT DISTINCT practice_area_id FROM $table_case where FIND_IN_SET($attorney_id,case_assgined_to) OR created_by=$attorney_id");
		return $result;	
	}
	/*<--- GET SINGEL CASE FUNCTION --->*/
	public function MJ_lawmgt_get_single_case($id)
	{
		global $wpdb;	
		$table_case = $wpdb->prefix. 'lmgt_cases';			
		$result = $wpdb->get_row("SELECT * FROM $table_case where id=".$id);	
		return $result;	
	}
	
	/*<--- GET SINGEL CASE  REMINDER FUNCTION --->*/
	public function MJ_lawmgt_get_single_case_reminder($id)
	{
		global $wpdb;	
		$table_case_reminder = $wpdb->prefix. 'lmgt_case_reminder';			
		$result = $wpdb->get_results("SELECT * FROM $table_case_reminder where case_id=".$id);	
		return $result;	
	}
	
	/*<--- DELETE CASE FUNCTION --->*/

	public function MJ_lawmgt_delete_case($case_id)
	{		
		//audit Log		
		$case_name=MJ_lawmgt_get_case_name($case_id);
		$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.$case_name.'</a>';			
		 
		$closed_case=esc_html__('Closed Case ','lawyer_mgt');
		MJ_lawmgt_append_audit_log($closed_case.' '.$case_name,get_current_user_id(),$case_link);
		MJ_lawmgt_append_audit_log_for_downlaod($closed_case.' '.$case_name,get_current_user_id(),'');
		MJ_lawmgt_append_audit_caselog($closed_case.' '.$case_name,get_current_user_id(),$case_link);
		MJ_lawmgt_userwise_activity($closed_case.' '.$case_name,get_current_user_id(),$case_link);
		
		MJ_lawmgt_append_audit_caselog_download($closed_case.' '.$case_name, get_current_user_id());
			
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';	
		
		$case_data['case_status']='close';
		$case_data['close_date']=date("Y-m-d");	
		$update_case_id['id']=$case_id;
		$result=$wpdb->update( $table_case, $case_data ,$update_case_id);
	 
		return $result;
	}
	/*<--- Reopen CASE FUNCTION --->*/
	public function MJ_lawmgt_reopen_case($case_id)
	{		
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';	
		
		$case_data['case_status']='open';
		$case_data['open_date']=date("Y-m-d");	
		$update_case_id['id']=$case_id;
		$result=$wpdb->update( $table_case, $case_data ,$update_case_id);
	 
		return $result;
	}	
	/*<---  GET CASE FORM ALL CUSTOM FIELDS FUNCTION --->*/
	public function MJ_lawmgt_get_case_form_all_customfield($custom_field_id)
	{
		 global $wpdb;
		 $table_custom_field = $wpdb->prefix. 'lmgt_custom_field';
		 $result = $wpdb->get_results("SELECT * FROM $table_custom_field where id=".$custom_field_id);
		 return $result;
	}
	
	/*<--- GET ALL  CASE  FORM VISIBLE FUNCTION --->*/
	public function MJ_lawmgt_get_case_form_all_visable_customfield()
	{
		 global $wpdb;
		 $table_custom_field = $wpdb->prefix. 'lmgt_custom_field';
		 $result = $wpdb->get_results("SELECT * FROM $table_custom_field where form_name='case' AND always_visible='yes'");
		 return $result;
	}
	/*<---  GET CASE FORM ALL CUTOMFIELD SHOW FUNCTION --->*/
	public function MJ_lawmgt_get_case_form_all_show_customfield()
	{
		 global $wpdb;
		 $table_custom_field = $wpdb->prefix. 'lmgt_custom_field';
		 $result = $wpdb->get_results("SELECT * FROM $table_custom_field where form_name='case' AND always_visible='yes' AND status='show'");
		 return $result;
	}
	
	//*<--- GET  CASE FORM CUSTOM FILED EDIT VALUE FUNCTION --->*/
	public function MJ_lawmgt_get_case_form_customfield_edit_value($caseid,$custom_field_id)
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';		
		$case_data = $wpdb->get_row("SELECT custom_fileld_value FROM $table_case where id=".$caseid);
	
		$result=json_decode($case_data->custom_fileld_value);
	
		foreach ($result as $key=>$value)
		{
			
			foreach ($value as $key1=>$value1)
			{				
				$id = $value1->id;
				$value = $value1->value;
				if($custom_field_id == $id)
				{
					return $value;
				}
			}			
		}		 
	}	
	
	/*<--- GET STAFF USER FEE EDIT VALUE FUNCTION --->*/
	public function MJ_lawmgt_get_staff_user_edited_fee_value($case_id,$default_rate,$id)
	{
		 
		global $wpdb;
		$table_case_staff_users= $wpdb->prefix. 'lmgt_case_staff_users';		
		$result = $wpdb->get_row("SELECT fee FROM $table_case_staff_users where case_id=".$case_id." AND user_id=".$id);
		$rate=$result->fee;
		if(!empty($rate))
		{
			return $rate;
		}
		else
		{
			return $default_rate;
		}			
	}	
	
	//*<--- GET  CASE NAME  USING ID FUNCTION --->*/
	public function MJ_lawmgt_get_case_name_using_id($case_id)
	{
		global $wpdb;			
		$table_case = $wpdb->prefix. 'lmgt_cases';			
		$result = $wpdb->get_row("SELECT * FROM $table_case where id=".$case_id);	
		
		return $result;		
	}	
	/*<---  DELETE SELECTED CASE FUNCTION --->*/
	public function MJ_lawmgt_delete_selected_case($all)
	{		
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
			
		$case_data['case_status']='close';
		$case_data['close_date']=date("Y-m-d");	
		$update_case_id['id']=$all;
		$result=$wpdb->update( $table_case, $case_data ,$update_case_id);
		
		return $result;
	}
	//<----------- GET ALL OPEN CASE BY YEAR -------------->//	
	public function MJ_lawmgt_get_open_all_case_and_year($selection_id)
	{		
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
	
		$result = $wpdb->get_results("SELECT * FROM $table_case where case_status='open' AND YEAR(open_date) LIKE '$selection_id'");
	
		return $result;	
	}
	//<----------- GET ALL OPEN CASE BY YEAR Created By-------------->//	
	public function MJ_lawmgt_get_open_all_case_and_year_created_by($selection_id)
	{		
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$current_user_id=get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_case where (case_status='open') AND (created_by=$current_user_id) AND (YEAR(open_date) LIKE '$selection_id')");
	
		return $result;	
	}
	//<----------- GET ALL CLOSE CASE BY YEAR -------------->//	
	public function MJ_lawmgt_get_close_all_case_and_year($selection_id)
	{		
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';	
		 
		$result = $wpdb->get_results("SELECT * FROM $table_case where case_status='close' AND YEAR(open_date) LIKE '$selection_id'");
		 
		return $result;
	}
	//<----------- GET ALL CLOSE CASE BY YEAR Created By-------------->//	
	public function MJ_lawmgt_get_close_all_case_and_year_created_by($selection_id)
	{		
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';	
		 $current_user_id=get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_case where (case_status='close') AND (created_by=$current_user_id) AND (YEAR(open_date) LIKE '$selection_id')");
		 
		return $result;
	}
	//<----------- GET ALL OPEN CASE BY ATTORNEY AND YEAR -------------->//
	public function MJ_lawmgt_get_open_case_by_attorney_and_year($selection_id)
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_case where (case_status='open') AND (FIND_IN_SET($current_user_id,case_assgined_to) OR created_by=$current_user_id) AND (YEAR(open_date) LIKE '$selection_id')");
		return $result;	
	}
	//<----------- GET ALL CLOSE CASE BY ATTORNEY AND YEAR -------------->//
	public function MJ_lawmgt_get_close_case_by_attorney_and_year($selection_id)
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_case where (case_status='close') AND (FIND_IN_SET($current_user_id,case_assgined_to) OR created_by=$current_user_id) AND (YEAR(open_date) LIKE '$selection_id')");
		return $result;	
	}
	//<----------- GET ALL OPEN CASE BY CLIENT AND YEAR -------------->//
	public function MJ_lawmgt_get_open_case_by_client_and_year($selection_id)
	{
		global $wpdb;
		$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$current_user_id = get_current_user_id();
		
		$casedata = $wpdb->get_results("SELECT * FROM $table_case_contacts where user_id=$current_user_id");
		
		$case_id=array();
		if(!empty($casedata))
		{		
			foreach($casedata as $data)
			{
				$case_id[]=$data->case_id;
			}	
		}
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_case where (case_status='open') AND (id IN (".implode(',', $case_id).") OR created_by=$current_user_id) AND (YEAR(open_date) LIKE '$selection_id')");
		}
		else
		{
			$result ='';
		}	
		return $result;	
	}
	//<----------- GET ALL CLOSE CASE BY CLIENT AND YEAR -------------->//
	public function MJ_lawmgt_get_close_case_by_client_and_year($selection_id)
	{
		global $wpdb;
		$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$current_user_id = get_current_user_id();
		
		$casedata = $wpdb->get_results("SELECT * FROM $table_case_contacts where user_id=$current_user_id");
		$case_id=array();
		if(!empty($casedata))
		{		
			foreach($casedata as $data)
			{
				$case_id[]=$data->case_id;
			}	
		}
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_case where (case_status='close') AND (id IN (".implode(',', $case_id).") OR created_by=$current_user_id) AND (YEAR(open_date) LIKE '$selection_id')");
		}
		else
		{
			$result ='';
		}	
		return $result;	
	}
	/*<--- GET  CASE BY CURRENT NEXT HEARING DATE OF ATTORNEY --->CASE DAIRY*/
	public function MJ_lawmgt_get_cases_by_current_next_hearing_date_of_attorney()
	{
		global $wpdb;
		$current_date=date('Y-m-d');
		$table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$current_user_id=get_current_user_id();
		 
		$next_hearing_data = $wpdb->get_results("SELECT * FROM $table_lmgt_orders where next_hearing_date='$current_date' AND deleted_status=0");
		$case_id=array();
		if(!empty($next_hearing_data))
		{		
			foreach($next_hearing_data as $data)
			{
				$case_id[]=$data->case_id;
			}	
		}
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_case where (id IN (".implode(',', $case_id).")) AND (FIND_IN_SET($current_user_id,case_assgined_to) OR created_by=$current_user_id) AND (case_status='open')");
		}
		else
		{
			$result ='';
		}
		 
		return $result;
	}
	/*<--- EXPORT CASE DAIRY BY ATTORNEY --->CASE DAIRY*/
	public function MJ_lawmgt_export_selected_case_dairy($all)
	{		 
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$result = $wpdb->get_results("select * FROM $table_case where id IN($all)");
		return $result;
	}
	/*<--- GET  CASE BY  NEXT HEARING DATE OF ATTORNEY FILTER --->CASE DAIRY*/
	public function MJ_lawmgt_get_case_diary_data_next_hearing_date_wise($starting_date,$ending_date)
	{
		global $wpdb;
		 
		$table_next_hearing_date = $wpdb->prefix. 'next_hearing_date';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$current_user_id=get_current_user_id();
		 
		$next_hearing_data = $wpdb->get_results("SELECT * FROM $table_next_hearing_date where next_hearing_date >= '$starting_date' AND next_hearing_date <= '$ending_date' AND deleted_status=0");
		$case_id=array();
		if(!empty($next_hearing_data))
		{		
			foreach($next_hearing_data as $data)
			{
				$case_id[]=$data->case_id;
			}	
		}
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_case where id IN (".implode(',', $case_id).") AND FIND_IN_SET($current_user_id,case_assgined_to) AND case_status='open'");
		}
		 
		return $result;
	}
	/*<--- GET ALL CASE BY CASENAME AND CASETYPE FUNCTIONTION --->*/
	public function MJ_lawmgt_get_all_case_by_clientname_and_casetype($or)
	{
		 
		$extraquery='';
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$increment = 0;
		foreach($or as $key=>$value)
		{
			if($increment == 0)
			{
				$extraquery .= ' '. $key .' '. "'$value'";
			}
			else
			{
				$extraquery .= ' '.'AND' .' '. $key .' '. "'$value'";
			}
		$increment++;
		}
	     
		$result = $wpdb->get_results("SELECT * FROM $table_case where".$extraquery);
		return $result;
	}
	/*<--- GET ALL CASE BY CASENAME AND CASETYPE FUNCTIONTION --->*/
	public function MJ_lawmgt_get_all_case_by_clientname_and_casetype_owndata($or)
	{
		 
		$extraquery='';
		global $wpdb;
		$attorney_id = get_current_user_id();	
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$increment = 0;
		foreach($or as $key=>$value)
		{
			if($increment == 0)
			{
				$extraquery .= ' '. $key .' '. "'$value'";
			}
			else
			{
				$extraquery .= ' '.'AND' .' '. $key .' '. "'$value'";
			}
			$increment++;
		}
	   
		$result = $wpdb->get_results("SELECT * FROM $table_case  where (FIND_IN_SET($attorney_id,case_assgined_to) OR created_by=$attorney_id ) AND".$extraquery);
		return $result;
	}
	/*<---  GET ALLNEW PRACTICE AREA FUNCTION --->*/
	public function MJ_lawmgt_get_all_practicearea_new($or)
	{
		$extraquery='';
		global $wpdb;
	 
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$increment = 0;
		foreach($or as $key=>$value)
		{
			if($increment == 0)
			{
				$extraquery .= ' '. $key .' '. "'$value'";
			}
			else
			{
				$extraquery .= ' '.'AND' .' '. $key .' '. "'$value'";
			}
		$increment++;
		}
	    	
		$result = $wpdb->get_results("SELECT * FROM $table_case  where".$extraquery);
		return $result;
	}
	/*<---  GET ALL  CASE CEEATED BY AND CASETYPE FUNCTION --->*/
	public function MJ_lawmgt_get_all_case_created_by_casetype_new($or)
	{
		$extraquery='';
		global $wpdb;
		 
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$increment = 0;
		foreach($or as $key=>$value)
		{
			if($increment == 0)
			{
				$extraquery .= ' '. $key .' '. "'$value'";
			}
			else
			{
				$extraquery .= ' '.'AND' .' '. $key .' '. "'$value'";
			}
		$increment++;
		}
	    	
		$result = $wpdb->get_results("SELECT * FROM $table_case  where".$extraquery);
		return $result;
	}
	/*<--- GET ALL CASE BY CASENAME AND CASETYPE FUNCTIONTION --->*/
	public function MJ_lawmgt_get_all_case_by_clientname_and_casetype_craeted_by($or)
	{
		$extraquery='';
		global $wpdb;
		$attorney_id = get_current_user_id();	
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$increment = 0;
		foreach($or as $key=>$value)
		{
			if($increment == 0)
			{
				$extraquery .= ' '. $key .' '. "'$value'";
			}
			else
			{
				$extraquery .= ' '.'AND' .' '. $key .' '. "'$value'";
			}
		$increment++;
		}
	     
		$result = $wpdb->get_results("SELECT * FROM $table_case  where  created_by=$attorney_id AND".$extraquery);
		return $result;
	}
	/*<--- GET ALL CASE BY CASENAME AND CASETYPE FUNCTIONTION --->*/
	public function MJ_lawmgt_get_all_case_by_clientname_and_casetype_all($or)
	{
		$extraquery='';
		global $wpdb;
		$attorney_id = get_current_user_id();	
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$increment = 0;
		foreach($or as $key=>$value)
		{
			if($increment == 0)
			{
				$extraquery .= ' '. $key .' '. "'$value'";
			}
			else
			{
				$extraquery .= ' '.'AND' .' '. $key .' '. "'$value'";
			}
		$increment++;
		}
	     
		$result = $wpdb->get_results("SELECT * FROM $table_case  where ".$extraquery);
		return $result;
	}
	/*<---  GET ALL CASE BY ADDITIONAL AND DISPOSAL ADMIN FUNCTION --->*/
	public function MJ_lawmgt_get_all_case_by_additioncase_and_disposalcase_admin($or)
	{
		 
		$extraquery='';
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$increment = 0;
		foreach($or as $key=>$value)
		{
			if($increment == 0)
			{
				$extraquery .= ' '. $key .' '. "'$value'";
			}
			else
			{
				$extraquery .= ' '.'AND' .' '. $key .' '. "'$value'";
			}
		$increment++;
		}
	  
			$result = $wpdb->get_results("SELECT * FROM $table_case where ".$extraquery);
		 
		
		return $result;
	}
	/*<---  GET ALL CASE BY ADDITIONAL AND DISPOSAL FUNCTION --->*/
	public function MJ_lawmgt_get_all_case_by_additioncase_and_disposalcase($or)
	{
		 
		$extraquery='';
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$increment = 0;
		foreach($or as $key=>$value)
		{
			if($increment == 0)
			{
				$extraquery .= ' '. $key .' '. "'$value'";
			}
			else
			{
				$extraquery .= ' '.'AND' .' '. $key .' '. "'$value'";
			}
		$increment++;
		}
	    
		$user_case_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('cases');
		$user_role=MJ_lawmgt_get_current_user_role();
		
		if($user_role == 'attorney')
		{
			if($user_case_access['own_data'] == '1')
			{
				$attorney_id = get_current_user_id();														
				
				$result = $wpdb->get_results("SELECT * FROM $table_case where (FIND_IN_SET($attorney_id,case_assgined_to) OR created_by=$attorney_id) AND ".$extraquery);
			}
			else
			{
				$result = $wpdb->get_results("SELECT * FROM $table_case where ".$extraquery);
			}		
		}		
		else
		{
			if($user_case_access['own_data'] == '1')
			{
				$attorney_id = get_current_user_id();			
				$result = $wpdb->get_results("SELECT * FROM $table_case where created_by=$attorney_id AND ".$extraquery);
			}
			else
			{
				
				$result = $wpdb->get_results("SELECT * FROM $table_case where ".$extraquery);
			}		
		}
		
		return $result;
	}
} /*<---START Lmgtcase  CLASS--->*/
?>