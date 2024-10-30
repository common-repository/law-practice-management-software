<?php 
class MJ_lawmgt_Event /*<---START MJ_lawmgt_Event  CLASS--->*/
{
	 /*<--- ADD EVENT FUNCTION --->*/
	function MJ_lawmgt_add_event($event_data)
	{
		global $wpdb;
		$table_add_event = $wpdb->prefix. 'lmgt_add_event'; 
		$table_event_reminder = $wpdb->prefix. 'lmgt_event_reminder'; 
		$case_tast_data['case_id']=sanitize_text_field($event_data['case_id']);
		$case_tast_data['practice_area_id']=sanitize_text_field($event_data['practice_area_id']);
		$case_tast_data['event_name']=sanitize_text_field($event_data['event_name']);
		$case_tast_data['start_date']=sanitize_text_field(date('Y-m-d',strtotime($event_data['start_date'])));
		$case_tast_data['end_date']=sanitize_text_field(date('Y-m-d' ,strtotime($event_data['end_date'])));
		$case_tast_data['start_time']=sanitize_text_field($event_data['start_time']);
		$case_tast_data['end_time']=sanitize_text_field($event_data['end_time']);
		$case_tast_data['description']=sanitize_textarea_field($event_data['description']);
		$case_tast_data['address']=sanitize_text_field($event_data['address']);
		$case_tast_data['state_name']=sanitize_text_field($event_data['state_name']);
		$case_tast_data['city_name']=sanitize_text_field($event_data['city_name']);
		$case_tast_data['pin_code']=sanitize_text_field($event_data['pin_code']);
		$case_tast_data['priority']=sanitize_text_field($event_data['priority']);
		$case_tast_data['repeat']=sanitize_text_field($event_data['repeat']);
		
		$assigned_to_user = array_map( 'sanitize_text_field', wp_unslash( $event_data['assigned_to_user'] ));
		$case_tast_data['assigned_to_user']=  implode(",", $assigned_to_user);
		
		$assign_to_attorney = array_map( 'sanitize_text_field', wp_unslash( $event_data['assign_to_attorney'] ));
		$case_tast_data['assign_to_attorney']=  implode(",", $assign_to_attorney);
		
		$user_email = explode(',',$case_tast_data['assigned_to_user']);
		$attorney_email = explode(',',$case_tast_data['assign_to_attorney']);
		
		
		$all_contact_attorney = array_merge($user_email, $attorney_email);
		$current_user=wp_get_current_user();
		
		if(esc_attr($event_data['action'])=='edit')
		{
			$event_id['event_id']=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id']));
			$case_tast_data['updated_date']=date("Y-m-d H:i:s");
			$result=$wpdb->update( $table_add_event, $case_tast_data ,$event_id);
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
					$arr['{{Event Name}}'] = sanitize_text_field($case_tast_data['event_name']);
					$arr['{{Case Name}}'] = $case_name;
					$arr['{{Practice Area}}'] =  get_the_title($case_tast_data['practice_area_id']); 
					$arr['{{Address}}'] = sanitize_text_field($case_tast_data['address']);
					$arr['{{Start Date}}'] = $case_tast_data['start_date'];
					$arr['{{Description}}'] = sanitize_textarea_field($case_tast_data['description']);			
					 
					$subject =get_option('lmgt_event_assigned_updated_email_subject');
					$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
					$message = get_option('lmgt_event_assigned_updated_email_template');	
					$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
					MJ_lawmgt_send_mail($to,$subject_replacement,$message_replacement);
				}
			}
			// Event Reminder
			$event_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id']));
			
			$result_reminder_data=$wpdb->query("DELETE FROM $table_event_reminder WHERE event_id = $event_id");
			
			$type = sanitize_text_field($event_data['casedata']);			
			
			if(!empty($event_data['casedata']))
			{
				foreach($type['type'] as $key=>$value)
				{	
					$reminderdata=array();
					
					$reminderdata['case_id']=sanitize_text_field($event_data['case_id']);
					$reminderdata['event_id']=$event_id;
					$reminderdata['user_id']= sanitize_text_field($current_user->ID);
					$reminderdata['start_date'] = $event_data['start_date'];		
					$reminderdata['reminder_type']=$type['type'][$key];
					$reminderdata['reminder_time_value']=$type['remindertimevalue'][$key];
					$reminderdata['reminder_time_format']=$type['remindertimeformat'][$key];
					
					$result=$wpdb->insert( $table_event_reminder, $reminderdata);		
				} 
			}
			
			//audit Log
			$case_id=  sanitize_text_field($case_tast_data['case_id']);
			$case_name=MJ_lawmgt_get_case_name($case_id);
			$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';
			$event_name=sanitize_text_field($case_tast_data['event_name']);
			$event_link='<a href="?page=event&tab=viewevent&action=view&id='.MJ_lawmgt_id_encrypt(esc_attr($event_id)).'">'.esc_html($event_name).'</a>';
			$updated_event=esc_html__('Updated Event ','lawyer_mgt');
			MJ_lawmgt_append_audit_log($updated_event.' '.$event_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_log_for_downlaod($updated_event.' '.$event_name,get_current_user_id(),'');
			MJ_lawmgt_append_audit_eventlog($updated_event.' '.$event_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_caselog($updated_event.' '.$event_link,get_current_user_id(),$case_link);
			MJ_lawmgt_userwise_activity($updated_event.' '.$event_link,get_current_user_id(),$case_link);
			
			MJ_lawmgt_append_audit_caselog_download($updated_event.' '.$event_name, get_current_user_id());
			MJ_lawmgt_append_audit_eventlog_download($updated_event.' '.$event_name, get_current_user_id());
			
		}
		else
		{		
			$case_tast_data['created_date']=date("Y-m-d H:i:s");
			$case_tast_data['created_by']=get_current_user_id();
			$result=$wpdb->insert( $table_add_event, $case_tast_data);
			$last=$wpdb->insert_id;
			if($result)
			{
				foreach($all_contact_attorney as $user_email1)
				{
					$userdata=get_userdata($user_email1);
					$to= sanitize_email($userdata->user_email);
					$name = sanitize_text_field($userdata->display_name);
					$system_name=get_option('lmgt_system_name');
					$case_name=MJ_lawmgt_get_case_name($case_tast_data['case_id']);
					 
					$arr['{{Lawyer System Name}}']= sanitize_text_field($system_name);							
					$arr['{{User Name}}'] = $name;
					$arr['{{Event Name}}'] = sanitize_text_field($case_tast_data['event_name']);
					$arr['{{Case Name}}'] = sanitize_text_field($case_name);
					$arr['{{Practice Area}}'] =  get_the_title($case_tast_data['practice_area_id']); 
					$arr['{{Address}}'] = sanitize_text_field($case_tast_data['address']);
					$arr['{{Start Date}}'] = $case_tast_data['start_date'];
					$arr['{{Description}}'] = sanitize_text_field($case_tast_data['description']);			
					 
					$subject =get_option('lmgt_event_assigned_email_subject');
					$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
					$message = get_option('lmgt_event_assigned_email_template');	
					$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
					MJ_lawmgt_send_mail($to,$subject_replacement,$message_replacement);
				}
			}
			// Event Reminder
			if(!empty($event_data['casedata']))
			{					
				$type=$event_data['casedata'];				
				
				foreach($type['type'] as $key=>$value)
				{	
					$reminderdata['case_id']=sanitize_text_field($event_data['case_id']);
					$reminderdata['event_id']=$last;
					$reminderdata['user_id']= sanitize_text_field($current_user->ID);
					$reminderdata['start_date'] = sanitize_text_field($case_tast_data['start_date']);		
					$reminderdata['reminder_type']=$type['type'][$key];
					$reminderdata['reminder_time_value']=$type['remindertimevalue'][$key];
					$reminderdata['reminder_time_format']=$type['remindertimeformat'][$key];
					
					$result=$wpdb->insert( $table_event_reminder, $reminderdata);
				}
			}	
			
			//audit Log
			$case_id=  sanitize_text_field($case_tast_data['case_id']);
			$case_name=MJ_lawmgt_get_case_name($case_id);
			$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';	
			$event_name=$case_tast_data['event_name'];
			$event_link='<a href="?page=event&tab=viewevent&action=view&id='.MJ_lawmgt_id_encrypt(esc_attr($last)).'">'.esc_html($event_name).'</a>';
			$added_event=esc_html__('Added New Event ','lawyer_mgt');
			MJ_lawmgt_append_audit_log($added_event.' '.$event_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_log_for_downlaod($added_event.' '.$event_name,get_current_user_id(),'');
			MJ_lawmgt_append_audit_eventlog($added_event.' '.$event_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_caselog($added_event.' '.$event_link,get_current_user_id(),$case_link);
			MJ_lawmgt_userwise_activity($added_event.' '.$event_link,get_current_user_id(),$case_link);
			
			
			MJ_lawmgt_append_audit_caselog_download($added_event.' '.$event_name, get_current_user_id());
			MJ_lawmgt_append_audit_eventlog_download($added_event.' '.$event_name, get_current_user_id());
		}    
		return $result;
	}	
	/*<--- GET ALL  EVENT FUNCTION --->*/
	function MJ_lawmgt_get_all_event()
	{
		global $wpdb;
		$table_event = $wpdb->prefix. 'lmgt_add_event';
	
		$result = $wpdb->get_results("SELECT * FROM $table_event ORDER BY event_id DESC");
		return $result;
	}
	/*<--- GET ALL  EVENT By Month FUNCTION --->*/
	function MJ_lawmgt_get_all_event_by_current_month()
	{
		global $wpdb;
		$table_event = $wpdb->prefix. 'lmgt_add_event';
		
		$result = $wpdb->get_results("SELECT * FROM $table_event where start_date>=CURDATE() ORDER BY start_date limit 5");
		return $result;
	}
	/*<--- GET ALL  EVENT By Month Created By FUNCTION --->*/
	function MJ_lawmgt_get_all_event_by_current_month_created_by()
	{
		global $wpdb;
		$table_event = $wpdb->prefix. 'lmgt_add_event';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_event where start_date>=CURDATE() AND created_by=$current_user_id ORDER BY start_date limit 5");
		return $result;
	}
	/*<--- GET Attorney ALL  EVENT By Month FUNCTION --->*/
	function MJ_lawmgt_get_attorney_all_event_by_current_month()
	{
		
		global $wpdb;
		$table_event = $wpdb->prefix. 'lmgt_add_event';
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
			$result = $wpdb->get_results("SELECT * FROM $table_event where start_date>=CURDATE() AND (case_id IN (".implode(',', $case_id).") OR created_by=$attorney_id) ORDER BY start_date limit 5");
		}
		else
		{
			$result ='';
		}
		return $result;
	}
	/*<--- GET Contact ALL  EVENT By Month FUNCTION --->*/
	function MJ_lawmgt_get_contact_all_event_by_current_month()
	{
		global $wpdb;
		$table_event = $wpdb->prefix. 'lmgt_add_event';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_event where start_date>=CURDATE() AND (FIND_IN_SET($current_user_id,assigned_to_user) OR created_by=$current_user_id) ORDER BY start_date limit 5");
		return $result;
	}
	
	/*<--- GET SINGLE  EVENT FUNCTION --->*/
	function MJ_lawmgt_get_signle_event_by_id($id)
	{
		global $wpdb;
		$table_event = $wpdb->prefix. 'lmgt_add_event';

		$result = $wpdb->get_row("SELECT * FROM $table_event where event_id=".$id);
		return $result;
	}
	/*<--- GET ALL EVENT BY ID  FUNCTION --->*/
	function MJ_lawmgt_get_all_event_by_id()
	{
		global $wpdb;
		$table_event = $wpdb->prefix. 'lmgt_add_event';

		$result = $wpdb->get_results("SELECT * FROM $table_event");
		return $result;
	}
	/*<--- GET ALL EVENT BY ID Created By  FUNCTION --->*/
	function MJ_lawmgt_get_all_event_by_id_created_by()
	{
		global $wpdb;
		$table_event = $wpdb->prefix. 'lmgt_add_event';
		$attorney_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_event where created_by=$attorney_id");
		return $result;
	}
	/*<--- GET ALL EVENT BY ATTORNY  FUNCTION --->*/
	function MJ_lawmgt_get_all_event_by_attorney()
	{
		global $wpdb;
		$table_event = $wpdb->prefix. 'lmgt_add_event';
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
			$result = $wpdb->get_results("SELECT * FROM $table_event where FIND_IN_SET($attorney_id,assign_to_attorney) OR created_by=$attorney_id OR case_id IN (".implode(',', $case_id).")");
		}
		else
		{
			$result ='';
		}	
		return $result;
	}
	/*<--- GET ALL EVENT BY CLIENT  FUNCTION --->*/
	function MJ_lawmgt_get_all_event_by_client()
	{
		global $wpdb;
		$table_event = $wpdb->prefix. 'lmgt_add_event';
			
		$current_user_id = get_current_user_id();
		
		$result = $wpdb->get_results("SELECT * FROM $table_event where FIND_IN_SET($current_user_id,assigned_to_user)");
		return $result;
	}
	/*<--- GET EVENT BY CASE ID FUNCTION --->*/
	public function MJ_lawmgt_get_event_by_caseid($case_id)
	{
		global $wpdb;
		$table_note = $wpdb->prefix. 'lmgt_add_event';
	
		$result = $wpdb->get_results("SELECT * FROM $table_note where case_id=$case_id ORDER BY event_id DESC");
		return $result;	
	}
	/*<--- GET EVENT BY CASE ID AND CREATED BY FUNCTION --->*/
	public function MJ_lawmgt_get_event_by_caseid_created_by($case_id)
	{
		global $wpdb;
		$table_note = $wpdb->prefix. 'lmgt_add_event';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_note where case_id=$case_id AND created_by=$current_user_id ORDER BY event_id DESC");
		return $result;	
	}
	/*<--- GET EVENT BY CASE ID AND CLIENT FUNCTION --->*/
	public function MJ_lawmgt_get_event_by_caseid_and_client($case_id,$current_user_id)
	{
		global $wpdb;
		$table_note = $wpdb->prefix. 'lmgt_add_event';
		
		$result = $wpdb->get_results("SELECT * FROM $table_note where case_id=$case_id AND (FIND_IN_SET($current_user_id,assigned_to_user) OR created_by=$current_user_id) ORDER BY event_id DESC");
		return $result;	
	}
	/*<--- GET EVENT BY CASE ID AND ATTORNY FUNCTION --->*/
	public function MJ_lawmgt_get_event_by_caseid_and_attorney($case_id)
	{
		global $wpdb;
		$table_note = $wpdb->prefix. 'lmgt_add_event';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_note where case_id=$case_id AND (FIND_IN_SET($current_user_id,assign_to_attorney) OR created_by=$current_user_id) ORDER BY event_id DESC");
		return $result;	
	}
	/*<--- DELETE  EVENT BY ID  FUNCTION --->*/
	function MJ_lawmgt_get_signle_event_Delete_by_id($id)
	{
		//audit Log
		$case_id_data=$this->MJ_lawmgt_get_signle_event_by_id($id);
		$case_id=$case_id_data->case_id;
		 
		$case_name=MJ_lawmgt_get_case_name($case_id);
		$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.$case_name.'</a>';	
		$event_name=MJ_lawmgt_get_event_name($id);
		$event_link='<a href="?page=event&tab=viewevent&action=view&id='.MJ_lawmgt_id_encrypt(esc_attr($id)).'">'.$event_name.'</a>';
		$deleted_event=esc_html__('Deleted Event ','lawyer_mgt');
		
			MJ_lawmgt_append_audit_log($deleted_event.' '.$event_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_log_for_downlaod($deleted_event.' '.$event_name,get_current_user_id(),'');
			MJ_lawmgt_append_audit_eventlog($deleted_event.' '.$event_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_caselog($deleted_event.' '.$event_link,get_current_user_id(),$case_link);
			MJ_lawmgt_userwise_activity($deleted_event.' '.$event_link,get_current_user_id(),$case_link);
			
			MJ_lawmgt_append_audit_caselog_download($deleted_event.' '.$event_name, get_current_user_id());
			MJ_lawmgt_append_audit_eventlog_download($deleted_event.' '.$event_name, get_current_user_id());
		
		global $wpdb;
		$table_event = $wpdb->prefix. 'lmgt_add_event';
		return $result = $wpdb->query("DELETE from $table_event where event_id= ".$id);
	}
	/*<--- GET SINGLE EVENT REMINDER FUNCTION --->*/
	public function MJ_lawmgt_get_single_event_reminder($event_id)
	{
		global $wpdb;	
		$table_event_reminder = $wpdb->prefix. 'lmgt_event_reminder'; 	
		$result = $wpdb->get_results("SELECT * FROM $table_event_reminder where event_id=".$event_id);	
		return $result;	
	}
	/*<--- DELETE SELECTED EVENT  FUNCTION --->*/
	public function MJ_lawmgt_delete_selected_event($all)
	{		
		global $wpdb;
		$table_event = $wpdb->prefix. 'lmgt_add_event';
		$result = $wpdb->query("DELETE FROM $table_event where event_id IN($all)");
		return $result;
	}
} /*<---END  MJ_lawmgt_Event  CLASS--->*/
?>