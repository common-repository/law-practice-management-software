<?php 
class MJ_lawmgt_Court
{  	 
	/*<--- ADD COURT FUNCTION --->*/
	function MJ_lawmgt_lmgt_add_court($court_data)
	{
		
		global $wpdb;
		$table_add_court = $wpdb->prefix. 'lmgt_court'; 
		 
		$case_tast_data['court_id']=sanitize_text_field($court_data['court_id']);
		$case_tast_data['state_id']=sanitize_text_field($court_data['state_id']);
		
		
		$selected_id_filter = array_map( 'sanitize_text_field', wp_unslash( $court_data['bench_id']));
       $case_bench_id = implode(",", $selected_id_filter);
	   $case_tast_data['bench_id']=$case_bench_id;
	   
		$case_tast_data['court_details'] = sanitize_textarea_field($court_data['court_details']);
		if(esc_attr($court_data['action'])=='edit')
		{			
			$court_id['c_id']=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id']));
			$case_tast_data['updated_by']=get_current_user_id();
			$result=$wpdb->update( $table_add_court, $case_tast_data ,$court_id);
			if($result)
			{
				//audit Log
				$case_link=null;
				$update_court=esc_html__('Updated Court ','lawyer_mgt');
				$court_name=get_post(sanitize_text_field($case_tast_data['court_id']));
				$court_link=esc_html($court_name->post_title);
				MJ_lawmgt_append_audit_log($update_court.' '.$court_link,get_current_user_id(),$case_link);
				MJ_lawmgt_append_audit_log_for_downlaod($update_court.' '.$court_link,get_current_user_id(),'');
				MJ_lawmgt_append_audit_courtlog($update_court.' '.$court_link,get_current_user_id(),$case_link);
				MJ_lawmgt_userwise_activity($update_court.' '.$court_link,get_current_user_id(),$case_link);  
			}
				
		}
		else
		{		
	
			$case_tast_data['created_date']=date("Y-m-d");
			$case_tast_data['created_by']=get_current_user_id();
			$result=$wpdb->insert( $table_add_court, $case_tast_data);
			if($result)
			{
				//audit Log
				$case_link=null;
				$add_court=esc_html__('Added New Court ','lawyer_mgt');
				$court_name=get_post(sanitize_text_field($case_tast_data['court_id']));
				$court_link=esc_html($court_name->post_title);
				MJ_lawmgt_append_audit_log($add_court.' '.$court_link,get_current_user_id(),$case_link);
				MJ_lawmgt_append_audit_log_for_downlaod($add_court.' '.$court_link,get_current_user_id(),'');
				MJ_lawmgt_append_audit_courtlog($add_court.' '.$court_link,get_current_user_id(),$case_link);
				MJ_lawmgt_userwise_activity($add_court.' '.$court_link,get_current_user_id(),$case_link); 
			}			
		}    
		return $result;
	}
	
	/*<---GET ALL DATA TASK  FUNCTION--->*/
	public function MJ_lawmgt_get_all_court_data()
	{		
		global $wpdb;
		$table_name = $wpdb->prefix. 'lmgt_court';
	
		$result = $wpdb->get_results("SELECT * FROM $table_name where deleted_status=0");
		 
		return $result;	
	}
	/*<---GET ALL DATA TASK  FUNCTION--->*/
	public function MJ_lawmgt_get_all_own_court_data()
	{		
		global $wpdb;
		$table_name = $wpdb->prefix. 'lmgt_court';
	    $user_id=get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_name where deleted_status=0 AND created_by=$user_id");
		 
		return $result;	
	}
	/*<---DELETE TASK  FUNCTION--->*/
	public function MJ_lawmgt_delete_court($id)
	{
		$court=new MJ_lawmgt_Court;		
		global $wpdb;
		$wpnc_court = $wpdb->prefix. 'lmgt_court';
		//audit Log
		$case_link=null;
		$casedata=$court->MJ_lawmgt_get_signle_court_by_id(sanitize_text_field(MJ_lawmgt_id_decrypt($id)));
		$court_name=get_post($casedata->court_id);
		$court_link=esc_html($court_name->post_title);
		$deleted_court=esc_html__('Deleted Court ','lawyer_mgt');
		MJ_lawmgt_append_audit_log($deleted_court.' '.$court_link,get_current_user_id(),$case_link);
		MJ_lawmgt_append_audit_log_for_downlaod($deleted_court.' '.$court_link,get_current_user_id(),'');
		MJ_lawmgt_append_audit_courtlog($deleted_court.' '.$court_link,get_current_user_id(),$case_link);
		MJ_lawmgt_userwise_activity($deleted_court.' '.$court_link,get_current_user_id(),$case_link);
			 
		$court_data['deleted_status']=1;
		$whereid['c_id']=sanitize_text_field(MJ_lawmgt_id_decrypt($id));
		$delete_court=$wpdb->update($wpnc_court, $court_data, $whereid);
		 
		return $delete_court;		 
	}
	/*<---DELETE MULTIPLE RECORD  FUNCTION--->*/
	public function MJ_lawmgt_delete_selected_court($record_id)
	{			 
		global $wpdb;
		$wpnc_court = $wpdb->prefix. 'lmgt_court';
		$court_data['deleted_status']=1;
		$whereid['c_id']=$record_id;
		$result=$wpdb->update($wpnc_court, $court_data, $whereid);
		return $result;
	}
	/*<---GET SINGLE DATA TASK  FUNCTION--->*/
	public function MJ_lawmgt_get_signle_court_by_id($c_id)
	{
		global $wpdb;
		$table_case_task = $wpdb->prefix. 'lmgt_court';
	
		$result = $wpdb->get_row("SELECT * FROM $table_case_task where c_id=$c_id");
		
		return $result;	
	}	
}
?>