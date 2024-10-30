<?php   
class MJ_lawmgt_Users   /*<---START MJ_lawmgt_Users  CLASS--->*/
{	
  /*<-- ADD USER FUNCTION--->*/
	public function MJ_lawmgt_add_user($data)
	{	
		global $wpdb;
		$table_members = $wpdb->prefix. 'usermeta';
		$table_custom_field = $wpdb->prefix. 'lmgt_custom_field';
		//-------usersmeta table data--------------
		if(isset($data['first_name']))
		$usermetadata['first_name']=sanitize_text_field($data['first_name']);
		if(isset($data['last_name']))
		$usermetadata['last_name']=sanitize_text_field($data['last_name']);
		if(isset($data['middle_name']))
		$usermetadata['middle_name']=sanitize_text_field($data['middle_name']);
		if(isset($data['gender']))
		$usermetadata['gender']=sanitize_text_field($data['gender']);
		if(isset($data['birth_date']))
		$usermetadata['birth_date']=sanitize_text_field($data['birth_date']);
		if(isset($data['address']))
		$usermetadata['address']=sanitize_text_field($data['address']);		
		if(isset($data['state_name']))
		$usermetadata['state_name']=sanitize_text_field($data['state_name']);		
		if(isset($data['city_name']))
		$usermetadata['city_name']=sanitize_text_field($data['city_name']);		
		if(isset($data['pin_code']))
		$usermetadata['pin_code']=sanitize_text_field($data['pin_code']);		
		if(isset($data['mobile']))
		$usermetadata['mobile']=sanitize_text_field($data['mobile']);
		if(isset($data['alternate_mobile']))
		$usermetadata['alternate_mobile']=sanitize_text_field($data['alternate_mobile']);
		if(isset($data['phone_home']))
		$usermetadata['phone_home']=sanitize_text_field($data['phone_home']);			
		if(isset($data['phone_work']))
		$usermetadata['phone_work']=sanitize_text_field($data['phone_work']);
				
		$current_user=wp_get_current_user();
		$date= date("Y-m-d") . "<br>"; 		
		$user_data= sanitize_user($current_user->user_login);
		$role_current_user_id= MJ_lawmgt_get_roles($current_user->ID);
		$usermetadata['added_on']="Added on ".$date."By".$user_data." ( ".$role_current_user_id." )";
				
		if(isset($data['lmgt_user_avatar']))
		$usermetadata['lmgt_user_avatar']=sanitize_url($data['lmgt_user_avatar']);
		
		 /*<-- ROLE ATTORNY --->*/
		if($data['role']=='attorney')
		{
			if(isset($data['degree']))
			$usermetadata['degree']=sanitize_text_field($data['degree']);			
			if(isset($data['experience']))
			$usermetadata['experience']=sanitize_text_field($data['experience']);	
			if(isset($data['rate']))
			$usermetadata['rate']=sanitize_text_field($data['rate']);
			if(isset($data['rate_type']))
			$usermetadata['rate_type']=sanitize_text_field($data['rate_type']);		
		}
		 /*<-- ROLE STAFFMEMBER --->*/
		if($data['role']=='staff_member')
		{
			if(isset($data['degree']))
			$usermetadata['degree']=sanitize_text_field($data['degree']);			
			if(isset($data['experience']))
			$usermetadata['experience']=sanitize_text_field($data['experience']);				
		}
		/*<-- ROLE CLIENT --->*/
		if($data['role']=='client')
		{
			if(isset($data['job_title']))
			$usermetadata['job_title']=sanitize_text_field($data['job_title']);	
			if(isset($data['fax']))
			$usermetadata['fax']=sanitize_text_field($data['fax']);			
			if(isset($data['website']))
			$usermetadata['website']=sanitize_url($data['website']);		
			if(isset($data['license_number']))
			$usermetadata['license_number']=sanitize_text_field($data['license_number']);
			if(isset($data['contact_description']))
			$usermetadata['contact_description']=sanitize_textarea_field($data['contact_description']);	
			if(isset($data['group']))
			$usermetadata['group']=sanitize_text_field($data['group']);	
			
			$usermetadata['archive']=0;	
		}
		if(isset($data['username']))	
		$userdata['user_login']=sanitize_user($data['username']);
		if(isset($data['email']))
		$userdata['user_email']=sanitize_email($data['email']);
	
		$userdata['user_nicename']=NULL;
		$userdata['user_url']=NULL;
		if(isset($data['first_name']))
		$userdata['display_name']=sanitize_text_field($data['first_name'])." ".sanitize_text_field($data['last_name']);
		
		if($data['password'] != "")
				$userdata['user_pass']=sanitize_text_field($data['password']);
			
		if($data['action']=='edit')
		{						
			//audit Log
			$user_display_name=$userdata['display_name'];
			if($data['role']=='attorney')
			{
				$user_link='<a href="?page=attorney&tab=view_attorney&action=view&attorney_id='.MJ_lawmgt_id_encrypt(esc_attr($data['user_id'])).'">'.esc_html($userdata['display_name']).'</a>';
			}
			if($data['role']=='staff_member')
			{
				$user_link='<a href="?page=staff&tab=view_staff&action=view&staff_id='.MJ_lawmgt_id_encrypt(esc_attr($data['user_id'])).'">'.esc_html($userdata['display_name']).'</a>';
			}
			if($data['role']=='accountant')
			{
				$user_link='<a href="?page=accountant&tab=view_accountant&action=view&accountant_id='.MJ_lawmgt_id_encrypt(esc_attr($data['user_id'])).'">'.esc_html($userdata['display_name']).'</a>';
			}
			if($data['role']=='client')
			{
				$user_link='<a href="?page=contacts&tab=viewcontact&action=view&contact_id='.MJ_lawmgt_id_encrypt(esc_attr($data['user_id'])).'">'.esc_html($userdata['display_name']).'</a>';
			}			
			
			$case_link=NULL;
			$updated_user=esc_html__('Updated User ','lawyer_mgt');
			
			MJ_lawmgt_append_audit_log($updated_user.' '.$user_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_log_for_downlaod($updated_user.' '.$user_display_name,get_current_user_id(),$case_link);
			MJ_lawmgt_userwise_activity($updated_user.' '.$user_link,get_current_user_id(),$case_link);
			$userdata['ID']=sanitize_text_field($data['user_id']);
			
			$user_id = wp_update_user($userdata);
						
			$usermetadata['updated_date']=date("Y-m-d H:i:s");
			
			foreach($usermetadata as $key=>$val)
			{
				$returnans=update_user_meta( $user_id, $key,$val );
			   //$returnans=$returnans = sanitize_meta( $key, $val, 'update_user_meta' );
			}
			 
			return $user_id;
		}
		else  /*<--INSER USER  DATA--->*/
		{		
		 
		
			$user_id = wp_insert_user( $userdata );
			
			$user = new WP_User($user_id);

			$user->set_role($data['role']);
			
			$usermetadata['created_date']=date("Y-m-d H:i:s");
			$usermetadata['created_by']=get_current_user_id();
			$usermetadata['updated_date']=date("Y-m-d H:i:s");
			$usermetadata['deleted_status']=0;
			
			foreach($usermetadata as $key=>$val)
			{
				$returnans=add_user_meta( $user_id, $key,$val, true );
			}
				if(isset($data['first_name']))
				$returnans=update_user_meta( $user_id, 'first_name', sanitize_text_field($data['first_name']));
				if(isset($data['last_name']))
				$returnans=update_user_meta( $user_id, 'last_name', sanitize_text_field($data['last_name']));
				//send mail user Registration				
				$login_link=home_url();
				$system_name=get_option('lmgt_system_name');
				$to=array();
				$arr['{{Lawyer System Name}}']=$system_name;							
				$arr['{{User Name}}']=sanitize_user($data['username']);
				$arr['{{Password}}']=sanitize_text_field($data['password']);
				$arr['{{Login Link}}']=sanitize_url($login_link);	
				$to[]=sanitize_email($data['email']);				
				$subject =get_option('lmgt_user_email_subject');
				$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
				$message = get_option('lmgt_user_email_template');	
				$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
				
				MJ_lawmgt_send_mail($to,$subject_replacement,$message_replacement); 			
			
			//audit Log
			$user_display_name=$userdata['display_name'];
			if($data['role']=='attorney')
			{
				$user_link='<a href="?page=attorney&tab=view_attorney&action=view&attorney_id='.MJ_lawmgt_id_encrypt(esc_attr($user_id)).'">'.esc_html($userdata['display_name']).'</a>';
			}
			if($data['role']=='staff_member')
			{
				$user_link='<a href="?page=staff&tab=view_staff&action=view&staff_id='.MJ_lawmgt_id_encrypt(esc_attr($user_id)).'">'.esc_html($userdata['display_name']).'</a>';
			}
			if($data['role']=='accountant')
			{
				$user_link='<a href="?page=accountant&tab=view_accountant&action=view&accountant_id='.MJ_lawmgt_id_encrypt(esc_attr($user_id)).'">'.esc_html($userdata['display_name']).'</a>';
			}
			if($data['role']=='client')
			{
				$user_link='<a href="?page=contacts&tab=viewcontact&action=view&contact_id='.MJ_lawmgt_id_encrypt(esc_attr($user_id)).'">'.esc_html($userdata['display_name']).'</a>';
			}			
			$case_link=NULL;
			$added_new_user=esc_html__('Added New User ','lawyer_mgt');
			MJ_lawmgt_append_audit_log($added_new_user.' '.$user_link,get_current_user_id(),$case_link);
			MJ_lawmgt_userwise_activity($added_new_user.' '.$user_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_log_for_downlaod($added_new_user.' '.$user_display_name,get_current_user_id(),$case_link);
			
			return $user_id;
		}	
	}
	//attorney 
	/*<-- UPLOAD DOCUMENT FUNCTION --->*/
	public function MJ_lawmgt_upload_documents($cv,$education,$experience,$user_id)
	{
		/* $usermetadata['attorney_cv']=$cv;
		$usermetadata['education_certificate']=$education;
		$usermetadata['experience_certificate']=$experience; */
		$usermetadata['attorney_cv']=sanitize_file_name($cv);
		$usermetadata['education_certificate']=sanitize_file_name($education);
		$usermetadata['experience_certificate']=sanitize_file_name($experience);
		foreach($usermetadata as $key=>$val)
		{
			$returnans=add_user_meta( $user_id,$key,$val);					
		}
	}
	/*<-- UPFDATE DOCUMENT FUNCTION --->*/
	public function MJ_lawmgt_update_upload_documents($cv,$education,$experience,$user_id)
	{
		$usermetadata['attorney_cv']=sanitize_file_name($cv);
		$usermetadata['education_certificate']=sanitize_file_name($education);
		$usermetadata['experience_certificate']=sanitize_file_name($experience);
	
		foreach($usermetadata as $key=>$val){
				$returnans=update_user_meta($user_id,$key,$val);				
		}
	}
	/*<-- STAFFMEMBER UPLOAD DOCUMENT FUNCTION --->*/
	public function MJ_lawmgt_staff_member_upload_documents($cv,$education,$experience,$user_id)
	{
		$usermetadata['staff_member_cv']=sanitize_file_name($cv);
		$usermetadata['education_certificate']=sanitize_file_name($education);
		$usermetadata['experience_certificate']=sanitize_file_name($experience);
		
		foreach($usermetadata as $key=>$val)
		{
			$returnans=add_user_meta( $user_id, $key,$val, true );
		}
	}
	//STAFFMEMBER UPLOAD DOCUMENT//
	public function MJ_lawmgt_staff_member_update_upload_documents($cv,$education,$experience,$user_id)
	{
		$usermetadata['staff_member_cv']=sanitize_file_name($cv);
		$usermetadata['education_certificate']=sanitize_file_name($education);
		$usermetadata['experience_certificate']=sanitize_file_name($experience);
		foreach($usermetadata as $key=>$val){
				$returnans=update_user_meta( $user_id, $key,$val);
		}
	}
	/*<-- DELETE USER DATA FUNCTION --->*/
	public function MJ_lawmgt_delete_usedata($record_id)
	{				
		$case_link=NULL;
		$deleted_user=esc_html__('Deleted User ','lawyer_mgt');
		MJ_lawmgt_append_audit_log($deleted_user.' '.MJ_lawmgt_get_display_name($record_id),get_current_user_id(),$case_link);
		MJ_lawmgt_userwise_activity($deleted_user.' '.MJ_lawmgt_get_display_name($record_id),get_current_user_id(),$case_link);
		
		global $wpdb;
		$table_name = $wpdb->prefix . 'usermeta';
		$user_id =$record_id;
		$new_value =1;
		$updated = update_user_meta( $user_id, 'deleted_status', $new_value );
		 
		return $updated;
		 
	}	
	 //GET CONTACT FORM ALL CUSTOMFIELD//
	public function MJ_lawmgt_get_contact_form_all_customfield($custom_field_id)
	{
		 global $wpdb;
		 $table_custom_field = $wpdb->prefix. 'lmgt_custom_field';
		 $result = $wpdb->get_results("SELECT * FROM $table_custom_field where id=".$custom_field_id);
		 return $result;
	}	 
	//GET CONTACT FORM ALL VISABLE CUSTOMFIELD//
	public function MJ_lawmgt_get_contact_form_all_visable_customfield()
	{
		 global $wpdb;
		 $table_custom_field = $wpdb->prefix. 'lmgt_custom_field';
		 $result = $wpdb->get_results("SELECT * FROM $table_custom_field where form_name='contact' AND always_visible='yes'");
		 return $result;
	}
	//GET CONTACT FORM ALL CUSTOMFIELD SHOW//
	public function MJ_lawmgt_get_contact_form_all_show_customfield()
	{
		 global $wpdb;
		 $table_custom_field = $wpdb->prefix. 'lmgt_custom_field';
		 $result = $wpdb->get_results("SELECT * FROM $table_custom_field where form_name='contact' AND always_visible='yes' AND status='show'");
		 return $result;
	}
	//GET CONTACT FORM CUSTOMFIELD//
	public function MJ_lawmgt_get_contact_form_customfield_edit_value($userid,$custom_field_id)
	{
		$user_data=get_userdata($userid);
		$result=json_decode($user_data->custom_fileld_value);
	
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
	//DELETE SELECTED USER//
	public function MJ_lawmgt_delete_selected_user($all)
	{		
		global $wpdb;
		
		$table_name = $wpdb->prefix . 'usermeta';
		 
		$new_value =1;
		
		foreach ($all as $record_id)
		{
			$updated = update_user_meta( $record_id, 'deleted_status', $new_value );
		}
		return $updated;
	}
}	/*<-- END USER CLASS --->*/
?>