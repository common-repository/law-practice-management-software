<?php 
class MJ_lawmgt_Note
{  /*<---START MJ_lawmgt_Note  CLASS--->*/
	/*<--- ADD NOTE FUNCTION --->*/
	function MJ_lawmgt_add_note($note_data)
	{
          $note_data['action']='';
         $_REQUEST['editnote']='';
		 global $wpdb;
		 $table_note = $wpdb->prefix. 'lmgt_add_note'; 
		 $notes_data['case_id']=sanitize_text_field($note_data['case_id']);
		 
		 $assigned_to_user = array_map( 'sanitize_text_field', wp_unslash( $note_data['assigned_to_user'] ));
		 $notes_data['assigned_to_user']=  implode(",", $assigned_to_user);
		
		 $assign_to_attorney = array_map( 'sanitize_text_field', wp_unslash( $note_data['assign_to_attorney'] ));
		 $notes_data['assign_to_attorney']=  implode(",", $assign_to_attorney);
		 $notes_data['practice_area_id']=sanitize_text_field($note_data['practice_area_id']);
		 $notes_data['note_name']=sanitize_text_field($note_data['note_name']);
		 $notes_data['note']=$note_data['note'];
		 $notes_data['date_time']=sanitize_text_field(date('Y-m-d h:i',strtotime($note_data['date_time'])));
		 
		 $user_email = explode(',',$notes_data['assigned_to_user']);
		 $attorney_email = explode(',',$notes_data['assign_to_attorney']);
		 
		 $all_contact_attorney = array_merge($user_email, $attorney_email);
		if(esc_attr($note_data['action'])=='editnote' or sanitize_text_field($_REQUEST['editnote']) == 'true')
		{	
			 
			$note_id['note_id']=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id']));
			$notes_data['updated_date']=date("Y-m-d H:i:s");
			$result=$wpdb->update( $table_note, $notes_data ,$note_id);
			  	 
			//audit Log
			$case_id=sanitize_text_field($notes_data['case_id']);
			$case_name=MJ_lawmgt_get_case_name($case_id);
			$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';
			$note_name=MJ_lawmgt_strip_tags_and_stripslashes($notes_data['note_name']);
			$note_id=$_REQUEST['id'];
			$note_link='<a href="?page=note&tab=viewnote&action=viewnote&note_id='.MJ_lawmgt_id_encrypt(esc_attr($note_id)).'">'.esc_html($note_name).'</a>';
			$updated_note=esc_html__('Updated Note ','lawyer_mgt');
			MJ_lawmgt_append_audit_log($updated_note.' '.$note_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_log_for_downlaod($updated_note.' '.$note_name,get_current_user_id(),'');
			MJ_lawmgt_append_audit_notelog($updated_note.' '.$note_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_caselog($updated_note.' '.$note_link,get_current_user_id(),$case_link);
			MJ_lawmgt_userwise_activity($updated_note.' '.$note_link,get_current_user_id(),$case_link);
			
			MJ_lawmgt_append_audit_notelog_download($updated_note.' '.$note_name, get_current_user_id());
			MJ_lawmgt_append_audit_caselog_download($updated_note.' '.$note_name, get_current_user_id());
			
			
		}
		else
		{		
			 $notes_data['created_date']=date("Y-m-d H:i:s");
			 $notes_data['created_by']=get_current_user_id();
			 $result=$wpdb->insert( $table_note, $notes_data);
			 $last=$wpdb->insert_id;
			
			 //----SEND MAIL--------
			if($result)
			{
				
				foreach($all_contact_attorney as $user_email1)
				{
					$userdata=get_userdata($user_email1);
					$to= sanitize_email($userdata->user_email);
					$name = sanitize_text_field($userdata->display_name);
					$system_name=get_option('lmgt_system_name');
					 
					$arr['{{Lawyer System Name}}']= sanitize_text_field($system_name);	
					$arr['{{User Name}}']= $name;
					$arr['{{Note Name}}']=sanitize_text_field($note_data['note_name']);
					$arr['{{Case Name}}']=MJ_lawmgt_get_case_name(sanitize_text_field($note_data['case_id']));
					$arr['{{Practice Area}}']=get_the_title($note_data['practice_area_id']);
					$arr['{{Date}}']= $notes_data['date_time'];
					$arr['{{Note}}']=$note_data['note'];
					
					$subject =get_option('lmgt_note_assigned_email_subject');
					$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
					$message = get_option('lmgt_note_assigned_email_template');	
					$message_replacement = strip_tags(MJ_lawmgt_string_replacemnet($arr,$message));
					
					MJ_lawmgt_send_mail($to,$subject_replacement,$message_replacement); 	
				}
			}
			//audit Log
			$case_id=sanitize_text_field($notes_data['case_id']);
			$case_name=MJ_lawmgt_get_case_name($case_id);
			$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';
			$note_name=$notes_data['note_name'];
			$note_link='<a href="?page=note&tab=viewnote&action=viewnote&note_id='.MJ_lawmgt_id_encrypt(esc_attr($last)).'">'.esc_html($note_name).'</a>';
			$added_note=esc_html__('Added New Note ','lawyer_mgt');
			MJ_lawmgt_append_audit_log($added_note.' '.$note_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_log_for_downlaod($added_note.' '.$note_name,get_current_user_id(),'');
			MJ_lawmgt_append_audit_notelog($added_note.' '.$note_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_caselog($added_note.' '.$note_link,get_current_user_id(),$case_link);
			MJ_lawmgt_userwise_activity($added_note.' '.$note_link,get_current_user_id(),$case_link);
			
			MJ_lawmgt_append_audit_caselog_download($added_note.' '.$note_name, get_current_user_id());
			MJ_lawmgt_append_audit_notelog_download($added_note.' '.$note_name, get_current_user_id());
			
		}    
		return $result;
	}
	/*<--- DELETE NOTE FUNCTION --->*/
	public function MJ_lawmgt_delete_note($id)
	{
		//audit Log
		$case_id=sanitize_text_field($_REQUEST['case_id']);
		$case_name=MJ_lawmgt_get_case_name($case_id);
		$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';
		$note_name=MJ_lawmgt_get_note_name($id);
		$note_link='<a href="?page=note&tab=viewnote&action=viewnote&note_id='.MJ_lawmgt_id_encrypt(esc_attr($id)).'">'.esc_html($note_name).'</a>';
		$deleted_note=esc_html__('Deleted Note ','lawyer_mgt');
		MJ_lawmgt_append_audit_log($deleted_note.' '.$note_link,get_current_user_id(),$case_link);
		MJ_lawmgt_append_audit_log_for_downlaod($deleted_note.' '.$note_name,get_current_user_id(),'');
		MJ_lawmgt_append_audit_notelog($deleted_note.' '.$note_link,get_current_user_id(),$case_link);
		MJ_lawmgt_append_audit_caselog($deleted_note.' '.$note_link,get_current_user_id(),$case_link);
		MJ_lawmgt_userwise_activity($deleted_note.' '.$note_link,get_current_user_id(),$case_link);
		
		MJ_lawmgt_append_audit_caselog_download($deleted_note.' '.$note_name, get_current_user_id());
		MJ_lawmgt_append_audit_notelog_download($deleted_note.' '.$note_name, get_current_user_id());
		
		global $wpdb;
		$table_note = $wpdb->prefix. 'lmgt_add_note';
		$result = $wpdb->query("DELETE from $table_note where note_id= ".$id);
		return $result;
	}
	/*<---GET ALL NOTE BY ID  FUNCTION --->*/
	public function MJ_lawmgt_get_note_by_id($note_id)
	{
		global $wpdb;
		$table_note = $wpdb->prefix. 'lmgt_add_note';
		$result = $wpdb->get_results("SELECT * FROM $table_note where case_id=$note_id");
		return $result;	
	}
	/*<---GET ALL NOTE  FUNCTION --->*/
	function MJ_lawmgt_get_all_note()
	{
		global $wpdb;
		$table_note= $wpdb->prefix. 'lmgt_add_note';

		$result = $wpdb->get_results("SELECT * FROM $table_note ORDER BY note_id DESC");
		return $result;
	}
	/*<---GET ALL NOTE Created by FUNCTION --->*/
	function MJ_lawmgt_get_all_note_created_by()
	{
		global $wpdb;
		$table_note= $wpdb->prefix. 'lmgt_add_note';
		$attorney_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_note where created_by=$attorney_id ORDER BY note_id DESC");
		return $result;
	}
	/*<---GET ALL NOTE BY Attorney FUNCTION --->*/
	function MJ_lawmgt_get_all_note_by_attorney()
	{
		global $wpdb;
		$table_note= $wpdb->prefix. 'lmgt_add_note';
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
			$result = $wpdb->get_results("SELECT * FROM $table_note where case_id IN (".implode(',', $case_id).") OR created_by=$attorney_id ORDER BY note_id DESC");
		}
		else
		{
			$result ='';
		}	
		return $result;
	}
	function MJ_lawmgt_get_note_by_caseid_and_client($case_id)
	{
		global $wpdb;
		$table_note= $wpdb->prefix. 'lmgt_add_note';
		
		$current_user_id = get_current_user_id();
			
		$result = $wpdb->get_results("SELECT * FROM $table_note where case_id=$case_id AND (FIND_IN_SET($current_user_id,assigned_to_user) OR created_by=$current_user_id) ORDER BY note_id DESC");
		return $result;
	}
	function MJ_lawmgt_get_note_by_caseid_and_attorney($case_id)
	{
		global $wpdb;
		$table_note= $wpdb->prefix. 'lmgt_add_note';
		
		$current_user_id = get_current_user_id();
			
		$result = $wpdb->get_results("SELECT * FROM $table_note where case_id=$case_id AND (FIND_IN_SET($current_user_id,assign_to_attorney) OR created_by=$current_user_id) ORDER BY note_id DESC");
		return $result;
	}
	/*<---GET ALL NOTE BY CLIENT  FUNCTION --->*/
	function MJ_lawmgt_get_all_note_by_client()
	{
		global $wpdb;
		$table_note= $wpdb->prefix. 'lmgt_add_note';
		
		$current_user_id = get_current_user_id();
			
		$result = $wpdb->get_results("SELECT * FROM $table_note where FIND_IN_SET($current_user_id,assigned_to_user) OR created_by=$current_user_id ORDER BY note_id DESC");
		return $result;
	}
	//GET SINGLE NOTE BY ID //
	function MJ_lawmgt_get_signle_note_by_id($id)
	{
		global $wpdb;
		$table_note = $wpdb->prefix. 'lmgt_add_note';

		$result = $wpdb->get_row("SELECT * FROM $table_note where note_id=".$id);
		return $result;
	}
	/*<---GET  NOTE  BY CASE ID FUNCTION --->*/
	public function MJ_lawmgt_get_note_by_caseid($case_id)
	{
		global $wpdb;
		$table_note = $wpdb->prefix. 'lmgt_add_note';

		$result = $wpdb->get_results("SELECT * FROM $table_note where case_id=$case_id ORDER BY note_id DESC");
		return $result;	
	}
	/*<---GET  NOTE  BY CASE ID Created By FUNCTION --->*/
	public function MJ_lawmgt_get_note_by_caseid_created_by($case_id)
	{
		global $wpdb;
		$table_note = $wpdb->prefix. 'lmgt_add_note';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_note where case_id=$case_id AND created_by=$current_user_id ORDER BY note_id DESC");
		return $result;	
	}
	//DELETE SELECTED NOTE//
	public function MJ_lawmgt_delete_selected_note($all)
	{		
		global $wpdb;
		$table_note = $wpdb->prefix. 'lmgt_add_note';
		$result = $wpdb->query("DELETE FROM $table_note where note_id IN($all)");
		return $result;
	}
	/*<--- GET ALL  Note By Month FUNCTION --->*/
		function MJ_lawmgt_get_all_note_dashboard()
		{
			global $wpdb;
			$table_note = $wpdb->prefix. 'lmgt_add_note';
			
			$result = $wpdb->get_results("SELECT * FROM $table_note where date_time >= CURDATE() ORDER BY date_time limit 5");
			return $result;
		}
		/*<--- GET ALL  Note By Month created by FUNCTION --->*/
		function MJ_lawmgt_get_all_note_dashboard_created_by()
		{
			global $wpdb;
			$table_note = $wpdb->prefix. 'lmgt_add_note';
			$current_user_id = get_current_user_id();
			$result = $wpdb->get_results("SELECT * FROM $table_note where date_time >= CURDATE() AND created_by=$current_user_id ORDER BY date_time limit 5");
			return $result;
		}
		/*<---GET ALL NOTE BY Attorney Dashboard FUNCTION --->*/
	function MJ_lawmgt_get_attorney_all_note_dashboard()
	{
		global $wpdb;
		$table_note= $wpdb->prefix. 'lmgt_add_note';
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
			$result = $wpdb->get_results("SELECT * FROM $table_note where date_time>=CURDATE() AND (case_id IN (".implode(',', $case_id).") OR created_by=$attorney_id) ORDER BY note_id DESC");
		}
		else
		{
			$result ='';
		}	
		return $result;
  }
  /*<---GET ALL NOTE BY CLIENT  FUNCTION --->*/
  function MJ_lawmgt_get_contact_all_note_dashboard()
  {
		global $wpdb;
		$table_note= $wpdb->prefix. 'lmgt_add_note';
		
		$current_user_id = get_current_user_id();
			
		$result = $wpdb->get_results("SELECT * FROM $table_note where date_time>=CURDATE() AND (FIND_IN_SET($current_user_id,assigned_to_user) OR created_by=$current_user_id) ORDER BY note_id DESC");
		return $result;
	}
}
?>