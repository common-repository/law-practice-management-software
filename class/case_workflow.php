<?php  
class MJ_lawmgt_caseworkflow  /*<---START Lmgtcaseworkflow  CLASS--->*/
{	
	/*<--- ADD CASHWORKFLOW FUNCTION --->*/
	public function MJ_lawmgt_add_caseworkflow($data)
	{		
		global $wpdb;
		$case_workflow_events_tasks = $wpdb->prefix .'lmgt_case_workflow_events_tasks';
						
		if((esc_attr($data['action'])=='edit') || isset($_REQUEST['edit'])&& sanitize_text_field($_REQUEST['edit'])=='true')
		{			
			// add events
			if(!empty($data['event_subject']))
			{					
				foreach($data['event_subject'] as $key=>$value)
				{	
					$workflow_id['id']=$data['event_id'][$key];
					
					$case_workflow_eventdata['event_date']=sanitize_text_field(date('Y-m-d',strtotime($data['event_date'][$key])));	
						
					$attendees='';
					
					if(!empty($data['event_contact']))
					{					
						foreach($data['event_contact'] as $key=>$event_contact_value)
						{		
							if($key == $value)
							{
								$attendees= implode(',', $event_contact_value);		
							}				
						}
					}					
					$case_workflow_eventdata['attendees']=$attendees;
					
					$result=$wpdb->update( $case_workflow_events_tasks, $case_workflow_eventdata,$workflow_id);						
				}		 
			}
		  // add tasks
			if(!empty($data['task_subject']))
			{					
				foreach($data['task_subject'] as $key=>$value)
				{		
					$workflow_id['id']=$data['task_id'][$key];					
						$assign_to='';						
						if(!empty($data['task_contact']))
						{					
							foreach($data['task_contact'] as $key=>$task_contact_value)
							{										
								if($key == $value)
								{
									$assign_to= implode(',', $task_contact_value);
								}				
							}
						}
						$case_workflow_taskdata['assign_to']=$assign_to;
					
						$result=$wpdb->update( $case_workflow_events_tasks, $case_workflow_taskdata,$workflow_id);													
				}	  
			}			
				//audit Log
				$case_id=$_REQUEST['case_id'];
				$case_name=MJ_lawmgt_get_case_name($case_id);
				$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';
				$updated_workflow=esc_html__('Updated applied Workflow ','lawyer_mgt');
				MJ_lawmgt_append_audit_log($updated_workflow.' '.sanitize_text_field($data['workflow_name']),get_current_user_id(),$case_link);	
				
				MJ_lawmgt_append_audit_log_for_downlaod($updated_workflow.' '.sanitize_text_field($data['workflow_name']),get_current_user_id(),'');
				MJ_lawmgt_append_audit_workflowlog($updated_workflow.' '.sanitize_text_field($data['workflow_name']),get_current_user_id(),$case_link);	
				MJ_lawmgt_append_audit_caselog($updated_workflow.' '.sanitize_text_field($data['workflow_name']),get_current_user_id(),$case_link);
				
				
				MJ_lawmgt_append_audit_caselog_download($updated_workflow.' '.sanitize_text_field($data['workflow_name']), get_current_user_id());
				MJ_lawmgt_append_audit_workflowlog_download($updated_workflow.' '.sanitize_text_field($data['workflow_name']), get_current_user_id());
			
			return $result;
		}
		else
		{				
			// add events
			if(!empty($data['event_subject']))
			{					
				foreach($data['event_subject'] as $key=>$value)
				{	
					$case_workflow_eventdata['case_id']=sanitize_text_field($data['case_id']);
					$case_workflow_eventdata['workflow_id']=sanitize_text_field($data['workflow_name']);					
					$case_workflow_eventdata['subject']=sanitize_text_field($value);
					$case_workflow_eventdata['type']="event";						
					$case_workflow_eventdata['event_date']=sanitize_text_field(date('Y-m-d',strtotime($data['event_date'][$key])));
						
					$attendees='';
					
					if(!empty($data['event_contact']))
					{					
						foreach($data['event_contact'] as $key=>$event_contact_value)
						{		
							if($key == $value)
							{
								$attendees= implode(',', $event_contact_value);		
							}				
						}
					}							
					$case_workflow_eventdata['attendees']=$attendees;
					
					$result=$wpdb->insert( $case_workflow_events_tasks, $case_workflow_eventdata);		

					 //Event assgined mail
					foreach(explode(',',$attendees) as $attendees_id)
					{						
						$login_link=home_url();
						$system_name=get_option('lmgt_system_name');
						$case_id=sanitize_text_field($data['case_id']);
						$case_name=MJ_lawmgt_get_case_name($case_id);
						$userdata=get_userdata($attendees_id);	
						$event_date=$case_workflow_eventdata['event_date'];
						$attendees_name=MJ_lawmgt_get_display_name($attendees_id);
						$arr['{{User Name}}']=$attendees_name;
						$attorney_name=MJ_lawmgt_get_attorney_name_by_case_id($case_id);
							
						$arr['{{Attorney Name}}']=$attorney_name;
						$arr['{{Lawyer System Name}}']=$system_name;
						$arr['{{Login Link}}']=$login_link;	
						$arr['{{Event Name}}']=$value;	
						$arr['{{Start Date}}']=$event_date;								
						$arr['{{Case Name}}']=$case_name;
						
						$assginedto=$userdata->user_email;
						
						$subject =get_option('lmgt_workflow_event_email_subject');
						$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
						$message = get_option('lmgt_workflow_event_email_template');		
						$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
						MJ_lawmgt_send_mail($assginedto,$subject_replacement,$message_replacement); 
					}
				}
			}		
			 // add tasks
			if(!empty($data['task_subject']))
			{					
				foreach($data['task_subject'] as $key=>$value)
				{					
					if($data['due_date_type'][$key] == 'automatically')
					{
							
						$due_date_value = array(
									  "due_date_type" => $data['due_date_type'][$key],
									  "days" => $data['days'][$key],
									  "day_formate" => $data['day_formate'][$key],
									  "day_type" => $data['day_type'][$key],
									  "task_event_name" => $data['task_event_name'][$key]
									); 
									
					 }
					 else
					 {						 	
						$due_date_value = array(
									  "due_date_type" => $data['due_date_type'][$key]									 
									); 
					 }
					$due_date= json_encode($due_date_value);
					
					$case_workflow_taskdata['case_id']=sanitize_text_field($data['case_id']);
					$case_workflow_taskdata['workflow_id']=sanitize_text_field($data['workflow_name']);
					$case_workflow_taskdata['subject']=sanitize_text_field($value);	
					$case_workflow_taskdata['due_date']=$due_date;
					$case_workflow_taskdata['type']="task";		
					
					$assign_to='';
					
					if(!empty($data['task_contact']))
					{					
						foreach($data['task_contact'] as $key=>$task_contact_value)
						{										
							if($key == $value)
							{
								$assign_to= implode(',', $task_contact_value);
							}				
						}
					}	
					
					$case_workflow_taskdata['assign_to']=$assign_to;
					
					$result=$wpdb->insert( $case_workflow_events_tasks, $case_workflow_taskdata);
					
					//Task assgined mail							
					foreach(explode(',',$assign_to) as $assign_to_id)
					{		
						if(!empty($assign_to_id))
						{		
							$login_link= sanitize_url(home_url());
							$system_name=get_option('lmgt_system_name');
							$case_id=$data['case_id'];
							$Workflow_id=sanitize_text_field($data['workflow_name']);																		
							$case_name=MJ_lawmgt_get_case_name($case_id);
							$userdata=get_userdata($assign_to_id);	
							
							$due_date_by_event_date=MJ_lawmgt_get_due_date_by_event_date($due_date,$Workflow_id,$case_id);
							
							$assign_to_name=MJ_lawmgt_get_display_name($assign_to_id);
							$arr['{{User Name}}']=sanitize_text_field($assign_to_name);
							$attorney_name=MJ_lawmgt_get_attorney_name_by_case_id($case_id);
								
							$arr['{{Attorney Name}}']=$attorney_name;
							$arr['{{Lawyer System Name}}']=$system_name;
							$arr['{{Login Link}}']=$login_link;	
							$arr['{{Task Name}}']=$value;	
							$arr['{{Due Date}}']=MJ_lawmgt_getdate_in_input_box($due_date_by_event_date);	
							$arr['{{Case Name}}']=$case_name;
							
							$assginedto = sanitize_email($userdata->user_email);
							
							$subject =get_option('lmgt_workflow_task_email_subject');
							$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
							$message = get_option('lmgt_workflow_task_email_template');		
							$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
							
							MJ_lawmgt_send_mail($assginedto,$subject_replacement,$message_replacement);
						}		
					}					
				}				
			}	 
			
			//audit Log
			$case_id=$_REQUEST['case_id'];
			$case_name=MJ_lawmgt_get_case_name($case_id);
			$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';
			$workflow_id=sanitize_text_field($data['workflow_name']);
			$applied_workflow=esc_html__('apply Workflow ','lawyer_mgt');			
			MJ_lawmgt_append_audit_log($applied_workflow.' '.MJ_lawmgt_get_workflow_name($workflow_id),get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_log_for_downlaod($applied_workflow.' '.MJ_lawmgt_get_workflow_name($workflow_id),get_current_user_id(),'');
			MJ_lawmgt_append_audit_workflowlog($applied_workflow.' '.MJ_lawmgt_get_workflow_name($workflow_id),get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_caselog($applied_workflow.' '.MJ_lawmgt_get_workflow_name($workflow_id),get_current_user_id(),$case_link);
			
			MJ_lawmgt_append_audit_caselog_download($applied_workflow.' '.MJ_lawmgt_get_workflow_name($workflow_id), get_current_user_id());
			MJ_lawmgt_append_audit_workflowlog_download($applied_workflow.' '.MJ_lawmgt_get_workflow_name($workflow_id), get_current_user_id());
			
			return $result;
		}	
	}
	/*<--- GET ALL APPLED WORKFLOW BY CASE ID FUNCTION --->*/
	public function MJ_lawmgt_get_all_applyworkflow_by_caseid($case_id)
	{	
		global $wpdb;
		$case_workflow_events_tasks = $wpdb->prefix .'lmgt_case_workflow_events_tasks';
		
		$result = $wpdb->get_results("SELECT DISTINCT(workflow_id),case_id FROM $case_workflow_events_tasks where case_id=$case_id ORDER BY id DESC ");
		
		return $result;	
	}	
	
	/*<--- DELETE CASHWORKFLOW FUNCTION --->*/
	public function MJ_lawmgt_delete_workflow($id)
	{		
		global $wpdb;
		$case_workflow_events_tasks = $wpdb->prefix .'lmgt_case_workflow_events_tasks';
		
		$result = $wpdb->query("DELETE FROM $case_workflow_events_tasks where workflow_id= ".$id);
		
		//audit Log
		$case_id=$_REQUEST['case_id'];
		$case_name=MJ_lawmgt_get_case_name($case_id);
		$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';
		$workflow_id=sanitize_text_field($data['workflow_name']);			
		$deleted_applied_workflow=esc_html__('Deleted applied Workflow ','lawyer_mgt');			
		MJ_lawmgt_append_audit_log($deleted_applied_workflow.' '.MJ_lawmgt_get_workflow_name($workflow_id),get_current_user_id(),$case_link);
		MJ_lawmgt_append_audit_log_for_downlaod($deleted_applied_workflow.' '.MJ_lawmgt_get_workflow_name($workflow_id),get_current_user_id(),'');
		MJ_lawmgt_append_audit_workflowlog($deleted_applied_workflow.' '.MJ_lawmgt_get_workflow_name($workflow_id),get_current_user_id(),$case_link);
		MJ_lawmgt_append_audit_caselog($deleted_applied_workflow.' '.MJ_lawmgt_get_workflow_name($workflow_id),get_current_user_id(),$case_link);
		
		MJ_lawmgt_append_audit_caselog_download($deleted_applied_workflow.' '.MJ_lawmgt_get_workflow_name($workflow_id), get_current_user_id());
		MJ_lawmgt_append_audit_workflowlog_download($deleted_applied_workflow.' '.MJ_lawmgt_get_workflow_name($workflow_id), get_current_user_id());
		return $result;
	}
	/*<--- GET SINGLE CASHWORKFLOW FUNCTION --->*/
	public function MJ_lawmgt_get_single_applyworkflow_allevents_by_caseid($id,$case_id)
	{
		global $wpdb;
		$case_workflow_events_tasks = $wpdb->prefix .'lmgt_case_workflow_events_tasks';
		$result = $wpdb->get_results("SELECT * FROM $case_workflow_events_tasks where type='event' AND workflow_id=$id AND case_id=$case_id ORDER BY id ASC");
		return $result;
	}	
	/*<--- GET SINGLE APPLED WORKFLOW ALL TASK BY CASH ID FUNCTION --->*/
	public function MJ_lawmgt_get_single_applyworkflow_alltasks_by_caseid($id,$case_id)
	{
		global $wpdb;
		$case_workflow_events_tasks = $wpdb->prefix .'lmgt_case_workflow_events_tasks';
		$result = $wpdb->get_results("SELECT * FROM $case_workflow_events_tasks where type='task' AND workflow_id=$id AND case_id=$case_id ORDER BY id ASC");
		return $result;
	}	
	/*<--- DELETE SELECTED WORKFLOW FUNCTION --->*/
	public function MJ_lawmgt_delete_selected_workflow($all)
	{		
		global $wpdb;
		$case_workflow_events_tasks = $wpdb->prefix .'lmgt_case_workflow_events_tasks';
		$result = $wpdb->query("DELETE FROM $case_workflow_events_tasks where workflow_id IN($all)");
		return $result;
	}
}/*<---START Lmgtcaseworkflow  CLASS--->*/
?>