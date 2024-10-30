<?php 
/*<---START MJ_lawmgt_case_tast  CLASS--->*/
class MJ_lawmgt_case_tast
{	
	/*<--- ADD TASK FUNCTION--->*/
	function MJ_lawmgt_add_tast($tast_data)
	{
		 global $wpdb;
		 $table_case_task = $wpdb->prefix. 'lmgt_add_task'; 
		 $table_task_reminder = $wpdb->prefix. 'lmgt_task_reminder'; 
		 
		 $case_tast_data['case_id']=sanitize_text_field($tast_data['case_id']);
		 $case_tast_data['practice_area_id']=sanitize_text_field($tast_data['practice_area_id']);
		 $case_tast_data['task_name']=sanitize_text_field($tast_data['task_name']);
		 $case_tast_data['due_date']=sanitize_text_field(date('Y-m-d',strtotime($tast_data['due_date'])));
		 $case_tast_data['status']=sanitize_text_field($tast_data['status']);
		 $case_tast_data['description']=sanitize_textarea_field($tast_data['description']);
		 $case_tast_data['priority']=sanitize_text_field($tast_data['priority']);
		 $case_tast_data['repeat']=sanitize_text_field($tast_data['repeat']);
		 $case_tast_data['repeat_until']=sanitize_text_field(date('Y-m-d',strtotime($tast_data['repeatuntil'])));
		 $case_tast_data['assigned_to_user']= implode(',',$tast_data['assigned_to_user']);
		 $case_tast_data['assign_to_attorney']= implode(',',$tast_data['assign_to_attorney']);
		 $user_email = explode(',',$case_tast_data['assigned_to_user']);
		 $attorney_email = explode(',',$case_tast_data['assign_to_attorney']);
		 $all_contact_attorney = array_merge($user_email, $attorney_email);
		 
		 $current_user=wp_get_current_user();
		 
		if(esc_attr($tast_data['action'])=='edittask' || esc_attr($tast_data['action'])=='edit')
		{
			$task_id['task_id']=sanitize_text_field($_REQUEST['task_id']);
			$case_tast_data['updated_date']=date("Y-m-d H:i:s");
			$result=$wpdb->update( $table_case_task, $case_tast_data ,$task_id);
			if($result)
			{				 
				foreach($all_contact_attorney as $user_email1)
				{
					$userdata=get_userdata($user_email1);
					$to= sanitize_email($userdata->user_email);
					$name = sanitize_text_field($userdata->display_name);
					$system_name=get_option('lmgt_system_name');
					 
					$case_name=MJ_lawmgt_get_case_name(sanitize_text_field($case_tast_data['case_id']));
					$arr['{{Lawyer System Name}}']=$system_name;							
					$arr['{{User Name}}'] = $name;
					$arr['{{Task Name}}'] =sanitize_text_field($case_tast_data['task_name']);
					$arr['{{Case Name}}'] = $case_name;
					$arr['{{Practice Area}}'] = sanitize_text_field($case_tast_data['practice_area_id']);
					$arr['{{Status}}'] = $case_tast_data['status'];
					$arr['{{Due Date}}'] = $case_tast_data['due_date'];
					$arr['{{Description}}'] =sanitize_textarea_field($case_tast_data['description']);			
					 
					$subject =get_option('lmgt_task_assigned_updated_email_subject');
					$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
					$message = get_option('lmgt_task_assigned_updated_email_template');	
					$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
					MJ_lawmgt_send_mail($to,$subject_replacement,$message_replacement);
				}
			}
			// task Reminder
			
			$task_id=$_REQUEST['task_id'];
			
			$result_reminder_data=$wpdb->query("DELETE FROM $table_task_reminder WHERE task_id = $task_id");
			
			$type=$tast_data['casedata'];			
			
			if(!empty($tast_data['casedata']))
			{
				foreach($type['type'] as $key=>$value)
				{	
					$reminderdata=array();
					
					$reminderdata['case_id']=sanitize_text_field($tast_data['case_id']);
					$reminderdata['task_id']=$task_id;
					$reminderdata['user_id']=$current_user->ID;
					$reminderdata['due_date'] = $tast_data['due_date'];		
					$reminderdata['reminder_type']=$type['type'][$key];
					$reminderdata['reminder_time_value']=$type['remindertimevalue'][$key];
					$reminderdata['reminder_time_format']=$type['remindertimeformat'][$key];					
					
					$result=$wpdb->insert( $table_task_reminder, $reminderdata);
				} 
			}
			
			//audit Log
			$case_id= sanitize_text_field($case_tast_data['case_id']);
			$case_name=MJ_lawmgt_get_case_name($case_id);
			$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';
			$task_name=sanitize_text_field($case_tast_data['task_name']);	
			$task_translation=esc_html__('Upadated Task ','lawyer_mgt');
			$task_link='<a href="?page=task&tab=view_task&action=view_task&task_id='.MJ_lawmgt_id_encrypt(esc_attr($task_is)).'">'.esc_html($task_name).'</a>'; 
			MJ_lawmgt_append_audit_log($task_translation.' '.$task_name,get_current_user_id(),$case_link);
            MJ_lawmgt_append_audit_log_for_downlaod($task_translation.' '.$case_name,get_current_user_id(),'');			
			MJ_lawmgt_append_audit_tasklog($task_translation.' '.$task_link,get_current_user_id(),$case_link);			
			MJ_lawmgt_append_audit_caselog($task_translation.' '.$task_link,get_current_user_id(),$case_link);			
			MJ_lawmgt_userwise_activity($task_translation.' '.$task_link,get_current_user_id(),$case_link);	

            MJ_lawmgt_append_audit_caselog_download($task_translation.' '.$task_name, get_current_user_id());			
            MJ_lawmgt_append_audit_tasklog_download($task_translation.' '.$task_name, get_current_user_id());			
			
		}
		else
		{	
			$case_tast_data['created_date']=date("Y-m-d H:i:s");
			$case_tast_data['created_by']=get_current_user_id();
			
			$result=$wpdb->insert( $table_case_task, $case_tast_data);
			if($result)
			{
				foreach($all_contact_attorney as $user_email1)
				{
					$userdata=get_userdata($user_email1);
					$to=sanitize_email($userdata->user_email);
					$name = sanitize_text_field($userdata->display_name);
					$system_name=get_option('lmgt_system_name');
					$case_name=MJ_lawmgt_get_case_name(sanitize_text_field($case_tast_data['case_id']));
					$arr['{{Lawyer System Name}}']=$system_name;							
					$arr['{{User Name}}'] = $name;
					$arr['{{Task Name}}'] = sanitize_text_field($case_tast_data['task_name']);
					$arr['{{Case Name}}'] = $case_name;
					$arr['{{Practice Area}}'] = get_the_title(sanitize_text_field($case_tast_data['practice_area_id']));						
					$arr['{{Status}}'] = "In Progress";
					$arr['{{Due Date}}'] = $case_tast_data['due_date'];
					$arr['{{Description}}'] = sanitize_textarea_field($case_tast_data['description']);			
				 
					$subject =get_option('lmgt_task_assigned_email_subject');
					$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
					$message = get_option('lmgt_task_assigned_email_template');	
					$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
					
					MJ_lawmgt_send_mail($to,$subject_replacement,$message_replacement);
				}
			}
			
			$last=$wpdb->insert_id;				
			// Task Reminder
			if(!empty($tast_data['casedata']))
			{					
				$type= sanitize_text_field($tast_data['casedata']);				
				
				foreach($type['type'] as $key=>$value)
				{	
					$reminderdata['case_id']=sanitize_text_field($tast_data['case_id']);
					$reminderdata['task_id']=$last;
					$reminderdata['user_id']=$current_user->ID;
					$reminderdata['due_date'] = $tast_data['due_date'];		
					$reminderdata['reminder_type']=$type['type'][$key];
					$reminderdata['reminder_time_value']=$type['remindertimevalue'][$key];
					$reminderdata['reminder_time_format']=$type['remindertimeformat'][$key];
					
					$result=$wpdb->insert( $table_task_reminder, $reminderdata);
				}
			}	
			//audit Log
			$case_id=$case_tast_data['case_id'];
			$case_name=MJ_lawmgt_get_case_name($case_id);
			$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';
			$task_name=$case_tast_data['task_name'];
			$add_task_translation=esc_html__('Added New Task ','lawyer_mgt');			
			$task_link='<a href="?page=task&tab=view_task&action=view_task&task_id='.MJ_lawmgt_id_encrypt(esc_attr($last)).'">'.esc_html($task_name).'</a>'; 
			MJ_lawmgt_append_audit_log($add_task_translation.' '.$task_name,get_current_user_id(),$case_link);	
            MJ_lawmgt_append_audit_log_for_downlaod($add_task_translation.' '.$case_name,get_current_user_id(),'');			
			MJ_lawmgt_append_audit_tasklog($add_task_translation.' '.$task_link,get_current_user_id(),$case_link);			
			MJ_lawmgt_append_audit_caselog($add_task_translation.' '.$task_link,get_current_user_id(),$case_link);			
			MJ_lawmgt_userwise_activity($add_task_translation.' '.$task_link,get_current_user_id(),$case_link);	

           MJ_lawmgt_append_audit_caselog_download($add_task_translation.' '.$task_name, get_current_user_id());	
         MJ_lawmgt_append_audit_tasklog_download($add_task_translation.' '.$task_name, get_current_user_id());		   
		}
		return $result;
	}
	/*<---GET ALL CASETASK FUNCTION--->*/
	public function MJ_lawmgt_get_all_case_tast()
	{
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_add_task';

		$result = $wpdb->get_results("SELECT * FROM $table_case_task ORDER BY task_id DESC");
		return $result;	
	}
	/*<---GET ALL CASETASK Created by FUNCTION--->*/
	public function MJ_lawmgt_get_all_case_tast_created_by()
	{
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_add_task';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_case_task where created_by=$current_user_id ORDER BY task_id DESC");
		return $result;	
	}
	/*<--- GET ALL CASETASK By Month FUNCTION --->*/
	function MJ_lawmgt_get_all_task_by_current_month()
	{
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_add_task';
		
		$result = $wpdb->get_results("SELECT * FROM $table_case_task where due_date>=CURDATE() ORDER BY due_date limit 5");
		return $result;		
		
	}	
	/*<--- GET ALL CASETASK By Month Created_by FUNCTION --->*/
	function MJ_lawmgt_get_all_task_by_current_month_created_by()
	{
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_add_task';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_case_task where due_date>=CURDATE() AND created_by=$current_user_id ORDER BY due_date limit 5");
		return $result;		
		
	}	
	/*<--- GET Attorney ALL CASETASK By Month FUNCTION --->*/
	function MJ_lawmgt_get_attorney_all_task_by_current_month()
	{
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_add_task';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		
		$attorney_id = get_current_user_id();
			
		$casedata = $wpdb->get_results("SELECT * FROM $table_case where FIND_IN_SET($attorney_id,case_assgined_to)");
		$case_id=array();
		if(!empty($casedata))
		{		
			foreach($casedata as $data)
			{
				$case_id[]=$data->id;
			}	
		}
		
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_case_task where due_date>=CURDATE() AND (case_id IN (".implode(',', $case_id).") OR created_by=$attorney_id)  ORDER BY due_date limit 5");
		}
		else
		{
			$result ='';
		}	
		
		return $result;		
		
	}	
	/*<--- GET Contact ALL CASETASK By Month FUNCTION --->*/
	function MJ_lawmgt_get_contact_all_task_by_current_month()
	{
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_add_task';
		
		$current_user_id = get_current_user_id();
					
		$result = $wpdb->get_results("SELECT * FROM $table_case_task where due_date>=CURDATE() AND (FIND_IN_SET($current_user_id,assigned_to_user) OR created_by=$current_user_id)ORDER BY due_date limit 5");
		return $result;		
		
	}
	/*<---GET ALL TASK BY Attorney FUNCTION--->*/
	public function MJ_lawmgt_get_all_case_tast_by_attorney()
	{
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_add_task';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		
		$attorney_id = get_current_user_id();
			
		$casedata = $wpdb->get_results("SELECT * FROM $table_case where FIND_IN_SET($attorney_id,case_assgined_to)");
		$case_id=array();
		if(!empty($casedata))
		{		
			foreach($casedata as $data)
			{
				$case_id[]=$data->id;
			}	
		}
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_case_task  where case_id IN (".implode(',', $case_id).") OR created_by=$attorney_id ORDER BY task_id DESC");
		}
		else
		{
			$result ='';
		}
		return $result;	
	}
	/*<---  GET ALL TASK BY CLIENT FUNCTION --->*/
	public function MJ_lawmgt_get_all_case_tast_by_client()
	{
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_add_task';

		$current_user_id = get_current_user_id();
			
		$result = $wpdb->get_results("SELECT * FROM $table_case_task  where FIND_IN_SET($current_user_id,assigned_to_user) OR created_by=$current_user_id ORDER BY task_id DESC");
		return $result;	
	}
	/*<---  GET ALL TASK BY CASE ID FUNCTION --->*/
	public function MJ_lawmgt_get_tast_by_caseid($case_id)
	{
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_add_task';

		$result = $wpdb->get_results("SELECT * FROM $table_case_task where case_id=$case_id ORDER BY task_id DESC");
		return $result;	
	}
	/*<---  GET ALL TASK BY CASE AND CREATED BY FUNCTION --->*/
	public function MJ_lawmgt_get_tast_by_caseid_created_by($case_id)
	{
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_add_task';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_case_task where case_id=$case_id AND created_by=$current_user_id ORDER BY task_id DESC");
		return $result;	
	}
	/*<---  GET ALL TASK BY CASE AND CLIENT FUNCTION --->*/
	public function MJ_lawmgt_get_tast_by_caseid_and_client($case_id,$current_user_id)
	{
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_add_task';
		
		$result = $wpdb->get_results("SELECT * FROM $table_case_task where case_id=$case_id AND (FIND_IN_SET($current_user_id,assigned_to_user) OR created_by=$current_user_id) ORDER BY task_id DESC");
		return $result;	
	}
	/*<---  GET ALL TASK BY CASE AND Attorney FUNCTION --->*/
	public function MJ_lawmgt_get_tast_by_caseid_and_attorney($case_id)
	{
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_add_task';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_case_task where case_id=$case_id AND (FIND_IN_SET($current_user_id,assign_to_attorney) OR created_by=$current_user_id) ORDER BY task_id DESC");
		return $result;	
	}
	/*<---  GET ALL FILTER TASK FUNCTION --->*/
	public function MJ_lawmgt_get_filter_case_tast($complet_stat,$case_name)
	{
		
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_add_task';
		$result = $wpdb->get_results("SELECT * FROM $table_case_task where case_satus=$complet_stat And matter='$case_name'");
		return $result;	
	}		
	/*<---  GET ALL TASK FUNCTION --->*/
	public function MJ_lawmgt_get_all_edit_tast($task_id)
	{
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_add_task';
	
		$result = $wpdb->get_row("SELECT * FROM $table_case_task where task_id=$task_id");
		
		return $result;	
	}
	/*<---DELETE TASK  FUNCTION--->*/
	public function MJ_lawmgt_delete_tast($id)
	{
		//audit Log
		$case_id=$_REQUEST['case_id'];
		$case_name=MJ_lawmgt_get_case_name($case_id);
		$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.$case_name.'</a>';
		$task_name=MJ_lawmgt_get_task_name($id);			
		$task_link='<a href="?page=task&tab=view_task&action=view_task&task_id='.MJ_lawmgt_id_encrypt(esc_attr($last)).'">'.$task_name.'</a>'; 
		$Deleted_task_tran=esc_html__('Deleted Task ','lawyer_mgt');
		MJ_lawmgt_append_audit_log($Deleted_task_tran.' '.$task_link,get_current_user_id(),$case_link);
		MJ_lawmgt_append_audit_log_for_downlaod($Deleted_task_tran.' '.$task_name,get_current_user_id(),'');
		MJ_lawmgt_append_audit_tasklog($Deleted_task_tran.' '.$task_link,get_current_user_id(),$case_link);
		MJ_lawmgt_append_audit_caselog($Deleted_task_tran.' '.$task_link,get_current_user_id(),$case_link);
		MJ_lawmgt_userwise_activity($Deleted_task_tran.' '.$task_link,get_current_user_id(),$case_link);
		
		MJ_lawmgt_append_audit_caselog_download($Deleted_task_tran.' '.$task_name, get_current_user_id());
		MJ_lawmgt_append_audit_tasklog_download($Deleted_task_tran.' '.$task_name, get_current_user_id());
		
		global $wpdb;
		$table_task = $wpdb->prefix. 'lmgt_add_task';
		$result = $wpdb->query("DELETE from $table_task where task_id= ".$id);
		return $result;
	}
	/*<---GET SINGEL TASK REMINDER FUNCTION--->*/
	public function MJ_lawmgt_get_single_task_reminder($task_id)
	{
		global $wpdb;	
		$table_task_reminder = $wpdb->prefix. 'lmgt_task_reminder';	
		$result = $wpdb->get_results("SELECT * FROM $table_task_reminder where task_id=".$task_id);	
		return $result;	
	}
	/*<---  DELETE SELECTED TASK FUNCTION --->*/
	public function MJ_lawmgt_delete_selected_task($all)
	{		
		global $wpdb;
		$table_task = $wpdb->prefix. 'lmgt_add_task';
		$result = $wpdb->query("DELETE FROM $table_task where task_id IN($all)");
		return $result;
	}
	/*<---GET ALL TASK BY Attorney And DUEDATE WISE FUNCTION--->*/
	public function MJ_lawmgt_get_task_by_attorney_duedate_wise($starting_date,$ending_date)
	{
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_add_task';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		
		$attorney_id = get_current_user_id();
			
		$casedata = $wpdb->get_results("SELECT * FROM $table_case where FIND_IN_SET($attorney_id,case_assgined_to)");
		$case_id=array();
		if(!empty($casedata))
		{		
			foreach($casedata as $data)
			{
				$case_id[]=$data->id;
			}	
		}
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_case_task  where (case_id IN (".implode(',', $case_id).") OR created_by=$attorney_id)  AND due_date >= '$starting_date' AND due_date <= '$ending_date'");
		}
		else
		{
			$result ='';
		}
		return $result;	
	}
	/*<---GET ALL TASK BY CLIENT And DUEDATE WISE FUNCTION--->*/
	public function MJ_lawmgt_get_task_by_client_duedate_wise($starting_date,$ending_date)
	{
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_add_task';

		$current_user_id = get_current_user_id();
			
		$result = $wpdb->get_results("SELECT * FROM $table_case_task  where FIND_IN_SET($current_user_id,assigned_to_user) AND due_date >= '$starting_date' AND due_date <= '$ending_date'");
		return $result;	
	}
	/*<---GET ALL TASK BY DUEDATE WISE FUNCTION--->*/
	public function MJ_lawmgt_get_all_task_duedate_wise($starting_date,$ending_date)
	{
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_add_task';
		$result = $wpdb->get_results("SELECT * FROM $table_case_task where due_date >= '$starting_date' AND due_date <= '$ending_date'");
		 
		return $result;	
		
	}
	/*<---GET ALL TASK BY DUEDATE Created by WISE FUNCTION--->*/
	public function MJ_lawmgt_get_all_task_duedate_wise_created_by($starting_date,$ending_date)
	{
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_add_task';
		$attorney_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_case_task where created_by=$attorney_id AND due_date >= '$starting_date' AND due_date <= '$ending_date'");
		 
		return $result;	
		
	}
	/*<---GET ALL CASETASK REPORT FUNCTION--->*/
	public function MJ_lawmgt_get_all_task_report($or)
	{
		 
		$extraquery='';
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_add_task';
		 
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
		 
		$result = $wpdb->get_results("SELECT * FROM $table_case_task where".$extraquery);
		 
		return $result;
	}
}/*<---END  MJ_lawmgt_case_tast  CLASS--->*/
?>