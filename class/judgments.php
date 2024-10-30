<?php  
class MJ_lawmgt_Judgments /*<---START MJ_lawmgt_Judgments CLASS--->*/
{
	  /*<--- Add Judgments FUNCTION --->*/
	public function MJ_lawmgt_add_judgment($data,$document_url)
	{
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix . 'lmgt_judgments';
				
		$judgment_data['date']=sanitize_text_field(date('Y-m-d',strtotime($data['date'])));
		$judgment_data['case_id']=sanitize_text_field($data['case_id']);
		$judgment_data['judge_name']=sanitize_text_field($data['judge_name']);
		$judgment_data['judgments_details']=sanitize_textarea_field($data['judgments_details']);
		$judgment_data['judgments_law_details']=sanitize_textarea_field($data['judgments_law_details']);
 
		if(esc_attr($data['action'])=='edit')
		{			
			$judgment_id['id']=sanitize_text_field($data['judgment_id']);
			 $document_data=array();	
			$judgment_data['updated_date']=date("Y-m-d H:i:s");
			$document_data[]=array('title'=>sanitize_text_field($data['document_name']),'value'=>$document_url);
			$judgment_data['judgments_document']=json_encode($document_data);
			$result=$wpdb->update( $table_lmgt_judgments, $judgment_data ,$judgment_id);
			if($result)
			{	
				//audit Log
				$case_id=  sanitize_text_field($data['case_id']);
				$case_name=MJ_lawmgt_get_case_name($case_id);
				$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';	
				$judge_name=sanitize_text_field($data['judge_name']);
				$jugdment_translation=esc_html__('Updated Judgement Of ','lawyer_mgt');				
				MJ_lawmgt_append_audit_log($jugdment_translation.' '.$judge_name,get_current_user_id(),$case_link);
				MJ_lawmgt_append_audit_log_for_downlaod($jugdment_translation.' '.$judge_name,get_current_user_id(),'');
				MJ_lawmgt_append_audit_judgment_log($jugdment_translation.' '.$judge_name,get_current_user_id(),$case_link);
				MJ_lawmgt_append_audit_caselog($jugdment_translation.' '.$judge_name,get_current_user_id(),$case_link);
				MJ_lawmgt_userwise_activity($jugdment_translation.' '.$judge_name,get_current_user_id(),$case_link); 
				
				MJ_lawmgt_append_audit_caselog_download($jugdment_translation.' '.$judge_name, get_current_user_id());
				MJ_lawmgt_append_audit_judgment_log_download($jugdment_translation.' '.$judge_name, get_current_user_id());
				
				
			}	
			return $result;	
		}
		else
		{		
			$document_data=array();	
			
			$document_data[]=array('title'=>sanitize_text_field($data['document_name']),'value'=>$document_url);
			$judgment_data['judgments_document']=json_encode($document_data);
			$judgment_data['created_date']=date("Y-m-d H:i:s");
			$judgment_data['created_by']=get_current_user_id();
			$result=$wpdb->insert( $table_lmgt_judgments, $judgment_data);
			 
			$last=$wpdb->insert_id;
			
			if($result)
			{		
				//send judgement mail //
				$contact_attorney_data=MJ_lawmgt_get_contact_and_attorney_data_by_case_id($data['case_id']);
				
				foreach($contact_attorney_data as $user_id)
				{ 				
					$system_name=get_option('lmgt_system_name');				
						
					$userdata=get_userdata($user_id);
					$to=$userdata->user_email;
					$arr['{{Lawyer System Name}}']=$system_name;	
					$arr['{{User Name}}']=$userdata->display_name;
					$arr['{{Case Name}}']=MJ_lawmgt_get_case_name(sanitize_text_field($data['case_id']));
					$arr['{{Case Number}}']=MJ_lawmgt_get_case_number(sanitize_text_field($data['case_id']));
					$arr['{{Judge Name}}']=sanitize_text_field($data['judge_name']);
					$arr['{{Date}}']= sanitize_text_field($data['date']);
					$arr['{{Judgments Details}}']=sanitize_textarea_field($data['judgments_details']);
				 
					$subject =get_option('lmgt_judgment_email_subject');
					$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
					$message = get_option('lmgt_judgment_email_template');	
					$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
					
					MJ_lawmgt_send_mail($to,$subject_replacement,$message_replacement); 	
				}
				//audit Log
				$case_id=  sanitize_text_field($data['case_id']);
				$case_name=MJ_lawmgt_get_case_name($case_id);
				$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';	
				$judge_name=sanitize_text_field($data['judge_name']);				
				$add_jugdment_translation=esc_html__('Added New Judgement Of ','lawyer_mgt');				
				MJ_lawmgt_append_audit_log($add_jugdment_translation.' '.$judge_name,get_current_user_id(),$case_link);
				MJ_lawmgt_append_audit_log_for_downlaod($add_jugdment_translation.' '.$judge_name,get_current_user_id(),'');
				MJ_lawmgt_append_audit_judgment_log($add_jugdment_translation.' '.$judge_name,get_current_user_id(),$case_link);
				MJ_lawmgt_append_audit_caselog($add_jugdment_translation.' '.$judge_name,get_current_user_id(),$case_link);
				MJ_lawmgt_userwise_activity($add_jugdment_translation.' '.$judge_name,get_current_user_id(),$case_link);  

   				MJ_lawmgt_append_audit_caselog_download($add_jugdment_translation.' '.$judge_name, get_current_user_id());
   				MJ_lawmgt_append_audit_judgment_log_download($add_jugdment_translation.' '.$judge_name, get_current_user_id());
			}
		}    
		return $result;
	}
	/*<--- GET All Judgements  FUNCTION--->*/
	public function MJ_lawmgt_get_all_judgment()
	{
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix . 'lmgt_judgments';
	
		$result = $wpdb->get_results("SELECT * FROM $table_lmgt_judgments ORDER BY id DESC");
		return $result;	
	}	
	/*<--- GET All OWN Judgements  FUNCTION--->*/
	public function MJ_lawmgt_get_all_own_judgment()
	{
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix . 'lmgt_judgments';
		$user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_lmgt_judgments where created_by=$user_id ORDER BY id DESC");
		return $result;	
	}	
	/*<--- GET SINGLE Judgement FUNCTION--->*/
	public function MJ_lawmgt_get_single_judgment($id)
	{
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix . 'lmgt_judgments';
		$result = $wpdb->get_row("SELECT * FROM $table_lmgt_judgments where id=".$id);
		return $result;
	}
	/*<--- DELETE Judgement  FUNCTION--->*/
	public function MJ_lawmgt_delete_judgment($id)
	{
		$jujgmentata=$this->MJ_lawmgt_get_single_judgment($id);
		 
		$case_id=$jujgmentata->case_id;
		$case_name=MJ_lawmgt_get_case_name($case_id);
		$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';
		$judge_name=$jujgmentata->judge_name;
		 
		$add_jugdment_translation=esc_html__('Deleted Judgement Of ','lawyer_mgt');		
		MJ_lawmgt_append_audit_log($add_jugdment_translation.' '.$judge_name,get_current_user_id(),$case_link);
		MJ_lawmgt_append_audit_log_for_downlaod($add_jugdment_translation.' '.$judge_name,get_current_user_id(),'');
		MJ_lawmgt_append_audit_judgment_log($add_jugdment_translation.' '.$judge_name,get_current_user_id(),$case_link);
		MJ_lawmgt_append_audit_caselog($add_jugdment_translation.' '.$judge_name,get_current_user_id(),$case_link);
		MJ_lawmgt_userwise_activity($add_jugdment_translation.' '.$judge_name,get_current_user_id(),$case_link); 

        MJ_lawmgt_append_audit_caselog_download($add_jugdment_translation.' '.$judge_name, get_current_user_id());
        MJ_lawmgt_append_audit_judgment_log_download($add_jugdment_translation.' '.$judge_name, get_current_user_id());
		
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix . 'lmgt_judgments';
		$result = $wpdb->query("DELETE FROM $table_lmgt_judgments where id= ".$id);
		return $result;
	}
	/*<--- GET ALL Judgement  BY ATTORNY  FUNCTION --->*/
	function MJ_lawmgt_get_all_judgment_by_attorney()
	{
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix. 'lmgt_judgments';
		$table_case = $wpdb->prefix. 'lmgt_cases';
		
		$attorney_id = get_current_user_id();
			
		$casedata = $wpdb->get_results("SELECT * FROM $table_case where FIND_IN_SET($attorney_id,case_assgined_to) OR created_by=$attorney_id");
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
			$result = $wpdb->get_results("SELECT * FROM $table_lmgt_judgments where case_id IN (".implode(',', $case_id).")");
		}
		else
		{
			$result ='';
		}	
		return $result;
	}
	/*<--- GET Judgement BY CLIENT  FUNCTION --->*/
	function MJ_lawmgt_get_all_judgment_by_client()
	{
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix. 'lmgt_judgments';
		$table_case_contact = $wpdb->prefix. 'lmgt_case_contacts';
		$user_id = get_current_user_id();
			
			$casedata = $wpdb->get_results("SELECT * FROM $table_case_contact where user_id=$user_id");
			$case_id=array();
			if(!empty($casedata))
			{		
				foreach($casedata as $data)
				{
					$case_id[]= $data->case_id;
				}	
			}
		$case_id_sanitize = array_map( 'sanitize_text_field', wp_unslash( $case_id ) );
		if(!empty($case_id_sanitize))
		{	
			$result = $wpdb->get_results("SELECT * FROM $table_lmgt_judgments where case_id IN (".implode(',', $case_id_sanitize).") OR created_by=$user_id");
		}
		else
		{
			$result ='';
		}
		return $result;
	}
	/*<---DELETE MULTIPLE RECORD  FUNCTION--->*/
	public function MJ_lawmgt_delete_selected_jugments($record_id)
	{		
	 
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix. 'lmgt_judgments';
		$result = $wpdb->query("DELETE FROM $table_lmgt_judgments where id= ".$record_id);
		return $result;
	}
	/*<--- GET ALL CASEORDERS  DASHBOEARD FUNCTION --->*/
	function MJ_lawmgt_get_all_judgments_dashboard()
	{
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix. 'lmgt_judgments';
		
		$result = $wpdb->get_results("SELECT * FROM $table_lmgt_judgments where date<=CURDATE() ORDER BY date limit 5");
		return $result;		
		
	}
	/*<--- GET ALL CASEORDERS  DASHBOEARD Created by FUNCTION --->*/
	function MJ_lawmgt_get_all_judgments_dashboard_created_by()
	{
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix. 'lmgt_judgments';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_lmgt_judgments where date<=CURDATE() AND created_by=$current_user_id ORDER BY date limit 5");
		return $result;		
		
	}
	/*<--- GET Attorney ALL  JUDGMENTS DASHBOAERD FUNCTION --->*/
	function MJ_lawmgt_get_attorney_all_judgments_dashboard()
	{		
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix. 'lmgt_judgments';
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
			$result = $wpdb->get_results("SELECT * FROM $table_lmgt_judgments where date<=CURDATE() AND case_id IN (".implode(',', $case_id).") ORDER BY date limit 5");
		}
		else
		{
			$result ='';
		}	
		return $result;
	}
	/*<--- GET ALL Judgement BY CLIENT DASHBOARD FUNCTION --->*/
	function MJ_lawmgt_get_contact_all_judgments_dashboard()
	{
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix. 'lmgt_judgments';
		$table_case_contact = $wpdb->prefix. 'lmgt_case_contacts';
		
		$user_id = get_current_user_id();
			
			$casedata = $wpdb->get_results("SELECT * FROM $table_case_contact where user_id=$user_id");
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
			$result = $wpdb->get_results("SELECT * FROM $table_lmgt_judgments where date<=CURDATE() AND case_id IN (".implode(',', $case_id).")ORDER BY date limit 5");
		}
		else
		{
			$result ='';
		}
		return $result;
	}	
	/*<--- GET ALL CASE JUDGMENTS FUNCTION --->*/
	function MJ_lawmgt_get_all_case_judgments($case_id)
	{
		global $wpdb;
		$table_lmgt_judgments = $wpdb->prefix. 'lmgt_judgments';
		
		$result = $wpdb->get_results("SELECT * FROM $table_lmgt_judgments where case_id=$case_id");
		return $result;		
		
	}
}  /*<---END  MJ_lawmgt_Judgments  CLASS--->*/
?>