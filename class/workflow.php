<?php  
class MJ_lawmgt_workflow  /*<---START MJ_lawmgt_workflow  CLASS--->*/
{
	/*<---ADD WORKFLOW FUNCTION--->*/
	public function MJ_lawmgt_add_workflow($data)
	{		
		global $wpdb;
		$table_workflows = $wpdb->prefix. 'lmgt_workflows';	
		$table_workflow_events_tasks = $wpdb->prefix. 'lmgt_workflow_events_tasks';	
		
		if((sanitize_text_field($data['action'])=='edit') || isset($_REQUEST['edit'])&& sanitize_text_field($_REQUEST['edit'])=='true')
		{	
			// edit workflow
			$workflowdata['name']=sanitize_text_field($data['workflow_name']);
			$workflowdata['description']=sanitize_textarea_field($data['workflow_description']);
			$workflowdata['permission']=sanitize_text_field($data['permission_type']);
			$workflowdata['assgined_to']=sanitize_text_field($data['assginedto']);
			$user = wp_get_current_user();
			$workflowdata['created_by']= sanitize_text_field($user->ID); 			
			$workflowdata['updated_date']=date("Y-m-d");
			
			$workflow_id['id']=sanitize_text_field($data['workflow_id1']);
			 
			$result=$wpdb->update( $table_workflows, $workflowdata,$workflow_id);
			 
			//delete events/tasks
			$id = sanitize_text_field($data['workflow_id1']);
			$result_delete = $wpdb->query("DELETE FROM $table_workflow_events_tasks where workflow_id= ".$id);
			
			// add events
			if(!empty($data['event_subject']))
			{					
				foreach($data['event_subject'] as $key=>$value)
				{
					$eventdata['workflow_id']=$id;
					$eventdata['subject']=sanitize_text_field($value);
					$eventdata['description']=sanitize_textarea_field($data['event_description'][$key]);
					$eventdata['type']="event";						
					
					$result=$wpdb->insert( $table_workflow_events_tasks, $eventdata);
					 
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
									  "due_date_type" => sanitize_text_field($data['due_date_type'][$key]),
									  "days" => sanitize_text_field($data['days'][$key]),
									  "day_formate" => sanitize_text_field($data['day_formate'][$key]),
									  "day_type" => sanitize_text_field($data['day_type'][$key]),
									  "task_event_name" => sanitize_text_field($data['task_event_name'][$key])); 
					 }
					 else
					 {						 	
						$due_date_value = array(
									  "due_date_type" => sanitize_text_field($data['due_date_type'][$key])									 
									); 
					 }
					$due_date_value_sanitize = array_map( 'sanitize_text_field', wp_unslash( $due_date_value ) );
					$due_date= json_encode($due_date_value_sanitize);
					
					$taskdata['workflow_id']=$id;
					$taskdata['subject']=sanitize_text_field($value);
					$taskdata['description']=sanitize_textarea_field($data['task_description'][$key]);
					$taskdata['type']="task";						
					$taskdata['due_date']=$due_date;		
					
					$result=$wpdb->insert( $table_workflow_events_tasks, $taskdata);						
				}		 
			}	
			//audit Log
			$case_link=NULL;
			$workflow_name=sanitize_text_field($data['workflow_name']);			
			$workflow_link='<a href="?page=workflow&tab=view_workflow&action=view&workflow_id='.MJ_lawmgt_id_encrypt(esc_attr($id)).'">'.esc_html($workflow_name).'</a>';
			$updated_workflow=esc_html__('Updated Workflow ','lawyer_mgt');
			MJ_lawmgt_append_audit_log($updated_workflow.' '.$workflow_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_log_for_downlaod($updated_workflow.' '.$workflow_name,get_current_user_id(),'');
			MJ_lawmgt_append_audit_workflowlog($updated_workflow.' '.$workflow_link,get_current_user_id(),$case_link);	
			MJ_lawmgt_userwise_activity($updated_workflow.' '.$workflow_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_workflowlog_download($updated_workflow.' '.$workflow_link,get_current_user_id());
			return $result;
			 
		}
		else
		{		
			// add workflow			
			$workflowdata['name']=sanitize_text_field($data['workflow_name']);
			$workflowdata['description']=sanitize_textarea_field($data['workflow_description']);
			$workflowdata['permission']=sanitize_text_field($data['permission_type']);
			$workflowdata['assgined_to']=sanitize_text_field($data['assginedto']);
			$user = wp_get_current_user();
			$workflowdata['created_by']= sanitize_text_field($user->ID); 
			$workflowdata['created_date']=date("Y-m-d"); 
			$workflowdata['updated_date']=date("Y-m-d");
			
			$result=$wpdb->insert( $table_workflows, $workflowdata);
			
			$lastid = sanitize_text_field($wpdb->insert_id);
			
			// add events
			if(!empty($data['event_subject']))
			{					
				foreach($data['event_subject'] as $key=>$value)
				{	
					$eventdata['workflow_id']=$lastid;
					$eventdata['subject']=sanitize_text_field($value);
					$eventdata['description']=sanitize_textarea_field($data['event_description'][$key]);
					$eventdata['type']="event";						
					
					$result=$wpdb->insert( $table_workflow_events_tasks, $eventdata);						
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
									  "due_date_type" => sanitize_text_field($data['due_date_type'][$key]),
									  "days" => sanitize_text_field($data['days'][$key]),
									  "day_formate" => sanitize_text_field($data['day_formate'][$key]),
									  "day_type" => sanitize_text_field($data['day_type'][$key]),
									  "task_event_name" => sanitize_text_field($data['task_event_name'][$key])
									); 
					 }
					else
					 {						 	
						$due_date_value = array(
									  "due_date_type" => $data['due_date_type'][$key]									 
									); 
					 }
					$due_date_value_sanitize = array_map( 'sanitize_text_field', wp_unslash( $due_date_value ) );
					$due_date= json_encode($due_date_value_sanitize);		
					$taskdata['workflow_id']=$lastid;
					$taskdata['subject']=sanitize_text_field($value);
					$taskdata['description']=sanitize_textarea_field($data['task_description'][$key]);
					$taskdata['type']="task";						
					$taskdata['due_date']=$due_date;				
					
					$result=$wpdb->insert( $table_workflow_events_tasks, $taskdata);						
				}		 
			}	
			
			//audit Log
			$case_link=NULL;
			$workflow_name=sanitize_text_field($data['workflow_name']);			
 			$workflow_link='<a href="?page=workflow&tab=view_workflow&action=view&workflow_id='.MJ_lawmgt_id_encrypt(esc_attr($lastid)).'">'.esc_html($workflow_name).'</a>';
			$added_new_workflow=esc_html__('Added New Workflow ','lawyer_mgt');
			MJ_lawmgt_append_audit_log($added_new_workflow.' '.$workflow_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_log_for_downlaod($added_new_workflow.' '.$workflow_name,get_current_user_id(),'');
			MJ_lawmgt_append_audit_workflowlog($added_new_workflow.' '.$workflow_link,get_current_user_id(),$case_link);
			MJ_lawmgt_userwise_activity($added_new_workflow.' '.$workflow_link,get_current_user_id(),$case_link);
			MJ_lawmgt_userwise_activity($added_new_workflow.' '.$workflow_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_workflowlog_download($added_new_workflow.' '.$workflow_link,get_current_user_id());
       		return $result;
		}	
	}
	/*<---GET ALL WORKFLOW FUNCTION--->*/
	public function MJ_lawmgt_get_all_workflow()
	{	
		global $wpdb;
		$table_workflows = $wpdb->prefix. 'lmgt_workflows';
		
		$result = $wpdb->get_results("SELECT * FROM $table_workflows ORDER BY id DESC");
		return $result;	
	}
	/*<---GET ALL WORKFLOW Created By FUNCTION--->*/
	public function MJ_lawmgt_get_all_workflow_created_by()
	{	
		global $wpdb;
		$table_workflows = $wpdb->prefix. 'lmgt_workflows';
		$user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_workflows where created_by=$user_id ORDER BY id DESC");
		return $result;	
	}
	/*<---GET ATTORNY BY CASE FUNCTION--->*/
	public function MJ_lawmgt_get_attorney_by_case($case_id)
	{	
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
		
		$result = $wpdb->get_row("SELECT case_assgined_to FROM $table_case where id=$case_id");
		return $result->case_assgined_to;	
	}		
	//GET ALL WORKFLOW BY CASE ATTORNEY //
	public function MJ_lawmgt_get_all_workflow_by_case_attorney($attorney_id)
	{	
		global $wpdb;
		$table_workflows = $wpdb->prefix. 'lmgt_workflows';
		$user_id = get_current_user_id();
		
		$result = $wpdb->get_results("SELECT * FROM $table_workflows where assgined_to IN (".$attorney_id.") ORDER BY id DESC");
		return $result;	
	}	
	//GET ALL WORKFLOW BY CASE ATTORNEY OWN //
	public function MJ_lawmgt_get_all_workflow_by_case_attorney_own($attorney_id)
	{	
		global $wpdb;
		$table_workflows = $wpdb->prefix. 'lmgt_workflows';
		$user_id = get_current_user_id();
		
		$result = $wpdb->get_results("SELECT * FROM $table_workflows where assgined_to=$user_id ORDER BY id DESC");
		return $result;	
	}
	//GET ALL WORKFLOW BY CASE ATTORNEY AND Created BY //
	public function MJ_lawmgt_get_all_workflow_by_case_attorney_and_created_by($attorney_id)
	{	
		global $wpdb;
		$table_workflows = $wpdb->prefix. 'lmgt_workflows';
		$user_id = get_current_user_id();
		
		$result = $wpdb->get_results("SELECT * FROM $table_workflows where assgined_to IN (".$attorney_id.") AND created_by=$user_id ORDER BY id DESC");
		return $result;	
	}	
	//GET ALL WORKFLOW BY CASE//
	public function MJ_lawmgt_get_all_workflow_by_case($case_id)
	{	
		global $wpdb;
		$table_workflows = $wpdb->prefix. 'lmgt_workflows';
		$user_id = get_current_user_id();
		
		$result = $wpdb->get_results("SELECT * FROM $table_workflows where assgined_to IN (".$attorney_id.") ORDER BY id DESC");
		return $result;	
	}	
	/*<---GET ALL WORKFLOW  BY ATTORNY FUNCTION--->*/	
	public function MJ_lawmgt_get_all_workflow_by_attorney()
	{	
		global $wpdb;
		$table_workflows = $wpdb->prefix. 'lmgt_workflows';
		$attorney_id=get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_workflows where assgined_to=$attorney_id OR created_by=$attorney_id ORDER BY id DESC");
		return $result;	
	}	
	/*<---DELETE WORKFLOW FUNCTION--->*/
	public function MJ_lawmgt_delete_workflow($id)
	{
		//audit Log
		$case_link=NULL;
		$workflow_name=MJ_lawmgt_get_workflow_name($id);	
		$workflow_link='<a href="?page=workflow&tab=view_workflow&action=view&workflow_id='.MJ_lawmgt_id_encrypt(esc_attr($id)).'">'.$workflow_name.'</a>'; 
		
		$deleted_workflow=esc_html__('Deleted Workflow ','lawyer_mgt');
		MJ_lawmgt_append_audit_log($deleted_workflow.' '.$workflow_link,get_current_user_id(),$case_link);
		MJ_lawmgt_append_audit_log_for_downlaod($deleted_workflow.' '.$workflow_name,get_current_user_id(),'');
		MJ_lawmgt_append_audit_workflowlog($deleted_workflow.' '.$workflow_link,get_current_user_id(),$case_link);
		MJ_lawmgt_userwise_activity($deleted_workflow.' '.$workflow_link,get_current_user_id(),$case_link);
		MJ_lawmgt_append_audit_workflowlog_download($deleted_workflow.' '.$workflow_link,get_current_user_id());
		
		global $wpdb;
		$table_workflows = $wpdb->prefix. 'lmgt_workflows';
		$table_workflow_events_tasks = $wpdb->prefix. 'lmgt_workflow_events_tasks';
		
		$result = $wpdb->query("DELETE FROM $table_workflows where id= ".$id);
		$result = $wpdb->query("DELETE FROM $table_workflow_events_tasks where workflow_id= ".$id);
		return $result;
	}	
	
	/*<---GET SINGLE WORKFLOW FUNCTION--->*/
	public function MJ_lawmgt_get_single_workflow($id)
	{
		global $wpdb;
		$table_workflows = $wpdb->prefix. 'lmgt_workflows';
		$result = $wpdb->get_row("SELECT * FROM $table_workflows where id=".$id);
		return $result;
	}
	
	/*<---GET SINGLE  WORKFLOW EVENT  FUNCTION--->*/
	public function MJ_lawmgt_get_single_workflow_events($id)
	{
		global $wpdb;
		$table_workflow_events_tasks = $wpdb->prefix. 'lmgt_workflow_events_tasks';	
		$result = $wpdb->get_results("SELECT * FROM $table_workflow_events_tasks where type='event' AND workflow_id=$id ORDER BY id ASC");
		return $result;
	}
	
	/*<---GET SINGLE  WORKFLOW TASK FUNCTION--->*/
	public function MJ_lawmgt_get_single_workflow_tasks($id)
	{
		global $wpdb;
		$table_workflow_events_tasks = $wpdb->prefix. 'lmgt_workflow_events_tasks';	
		$result = $wpdb->get_results("SELECT * FROM $table_workflow_events_tasks where type='task' AND workflow_id=$id ORDER BY id ASC");
		return $result;
	}	
	//DELETE SELECTED WORKFLOW//
	public function MJ_lawmgt_delete_selected_workflow($all)
	{		
		global $wpdb;
		$table_workflows = $wpdb->prefix. 'lmgt_workflows';
		$result = $wpdb->query("DELETE FROM $table_workflows where id IN($all)");
		return $result;
	}
} /*<---END  MJ_lawmgt_workflow  CLASS--->*/
?>