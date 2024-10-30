<?php  
class MJ_lawmgt_documents /*<---START MJ_lawmgt_documents  CLASS--->*/
{
	 /*<--- ADD DOCUMENT FUNCTION --->*/
	public function MJ_lawmgt_add_documents($data,$upload_docs_array)
	{		
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';
 
		$documentsdata['case_id']=sanitize_text_field($data['case_name']);		
		$documentsdata['document_url']=$upload_docs_array;		
		$documentsdata['type']=sanitize_text_field($data['documents_type']);
		
		$documentsdata['document_description']=sanitize_textarea_field($data['document_description']);	
		
		$current_user=wp_get_current_user();
		$date= date("Y-m-d"); 		
		$user_data= sanitize_user($current_user->user_login);
		$current_user_id= MJ_lawmgt_get_roles($current_user->ID);
		$last_updated_translation=esc_html__('Updated on ','lawyer_mgt');
		$by=esc_html__(' By ','lawyer_mgt');
		$documentsdata['last_update']=$last_updated_translation.' '.$date.' '.$by.' '.$user_data." ( ".$current_user_id." ) ";
		$last_update=$documentsdata['last_update'];
		
		if((esc_attr($data['action'])=='edit') || isset($_REQUEST['edit'])&& sanitize_text_field($_REQUEST['edit'])=='true')
		{	
			//audit Log
			$case_id=  sanitize_text_field($documentsdata['case_id']);
			$case_name=MJ_lawmgt_get_case_name($case_id);
			$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';
			$updated_documents=esc_html__('Updated Document ','lawyer_mgt');
			MJ_lawmgt_append_audit_log($updated_documents.' '.sanitize_text_field($data['documents_type']),get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_log_for_downlaod($updated_documents.' '.$case_name,get_current_user_id(),'');
			MJ_lawmgt_append_audit_documetlog($updated_documents.' '.sanitize_text_field($data['documents_type']),get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_caselog($updated_documents.' '.sanitize_text_field($data['documents_type']),get_current_user_id(),$case_link);
			MJ_lawmgt_userwise_activity($updated_documents.' '.sanitize_text_field($data['documents_type']),get_current_user_id(),$case_link);
			
			MJ_lawmgt_append_audit_caselog_download($updated_documents.' '.sanitize_text_field($data['documents_type']), get_current_user_id());
			MJ_lawmgt_append_audit_documetlog_download($updated_documents.' '.sanitize_text_field($data['documents_type']), get_current_user_id());
			 				
			//documents edit
			$status_array=array();							
			$user_status=json_encode($status_array);
			$documents_id['id']=sanitize_text_field($data['documents_id']);	
			$documentsdata['case_id']=sanitize_text_field($data['case_name']);
			$documentsdata['title']=sanitize_text_field($data['cartificate_name']);
			$documentsdata['document_url']=$upload_docs_array;
			$documentsdata['type']=sanitize_text_field($data['documents_type']);
			$documentsdata['tag_names']=implode(",",$data['hidden_tags']);
			$documentsdata['document_description']=sanitize_textarea_field($data['document_description']);	
			$documentsdata['status']=$user_status;
			$documentsdata['last_update']=$last_update;
			$documentsdata['updated_date']=date("Y-m-d H:i:s");
			$documentsdata['updated_by']=get_current_user_id();
			
			$result=$wpdb->update($table_documents,$documentsdata,$documents_id);

			return $result;
		}		
		else
		{	
			foreach($documentsdata['document_url'] as $key=>$value)
			{	
				$status_array=array();
				
				$user_status=json_encode($status_array);
				$documentsdata['case_id']=sanitize_text_field($data['case_name']);
				$documentsdata['title']=sanitize_text_field($data['cartificate_name'][$key]);
				$documentsdata['document_url']=$value;
				$documentsdata['type']=sanitize_text_field($data['documents_type']);
				$documentsdata['tag_names']=implode(",",$data['documents_tag_names'][$key]);
				$documentsdata['document_description']=sanitize_text_field($data['document_description']);	
				$documentsdata['status']=$user_status;
				$documentsdata['last_update']=$last_update;
				$documentsdata['created_date']=date("Y-m-d H:i:s");
				$documentsdata['created_by']=get_current_user_id();
				
				$result=$wpdb->insert( $table_documents, $documentsdata );
				
				//audit Log
				$case_id=  sanitize_text_field($documentsdata['case_id']);
				$case_name=MJ_lawmgt_get_case_name($case_id);
				$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';
				$upload_documents=esc_html__('Uploaded New Document ','lawyer_mgt');
				MJ_lawmgt_append_audit_log($upload_documents.' '.sanitize_text_field($data['documents_type']),get_current_user_id(),$case_link);
				MJ_lawmgt_append_audit_log_for_downlaod($upload_documents.' '.$case_name,get_current_user_id(),'');
				MJ_lawmgt_append_audit_documetlog($upload_documents.' '.sanitize_text_field($data['documents_type']),get_current_user_id(),$case_link);
				MJ_lawmgt_append_audit_caselog($upload_documents.' '.sanitize_text_field($data['documents_type']),get_current_user_id(),$case_link);
				MJ_lawmgt_userwise_activity($upload_documents.' '.sanitize_text_field($data['documents_type']),get_current_user_id(),$case_link);
				
				MJ_lawmgt_append_audit_caselog_download($upload_documents.' '.sanitize_text_field($data['documents_type']), get_current_user_id());
				MJ_lawmgt_append_audit_documetlog_download($upload_documents.' '.sanitize_text_field($data['documents_type']), get_current_user_id());
				 		
			}
				
			return $result;
		}
	}
	/*<--- GET SINGLE DOCUMENT FUNCTION --->*/
	public function MJ_lawmgt_get_single_documents($id)
	{
		global $wpdb;		
		$table_documents = $wpdb->prefix. 'lmgt_documents';
		$result = $wpdb->get_row("SELECT * FROM $table_documents where id=".$id);
		return $result;
	}
	/*<--- GET ALL DOCUMENT FUNCTION --->*/
	public function MJ_lawmgt_get_all_documents()
	{
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';
	
		$result = $wpdb->get_results("SELECT * FROM $table_documents ORDER BY id DESC");
		return $result;	
	}
	/*<--- GET ALL DOCUMENT Created By FUNCTION --->*/
	public function MJ_lawmgt_get_all_documents_created_by()
	{
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_documents where created_by=$current_user_id ORDER BY id DESC");
		return $result;	
	}
	/*<--- GET ALL DOCUMENT BY ID FUNCTION --->*/
	public function MJ_lawmgt_get_all_documents_by_attorney()
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$table_documents = $wpdb->prefix. 'lmgt_documents';
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
			$result = $wpdb->get_results("SELECT * FROM $table_documents where case_id IN (".implode(',', $case_id).") OR created_by=$attorney_id ORDER BY id DESC");
		}
		else
		{
			$result ='';
		}	
		return $result;	
	}
	/*<--- GET ALL DOCUMENT BY CLIENT FUNCTION --->*/
	public function MJ_lawmgt_get_all_documents_by_client()
	{
		global $wpdb;
		$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
		$table_documents = $wpdb->prefix. 'lmgt_documents';
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
			$result = $wpdb->get_results("SELECT * FROM $table_documents where case_id IN (".implode(',', $case_id).") OR created_by=$current_user_id ORDER BY id DESC");
		}
		else
		{
			$result ='';
		}
		return $result;	
	}
	/*<--- GET ALL  UNREAD DOCUMENT  FUNCTION --->*/
	public function MJ_lawmgt_get_all_unread_documents()
	{
		global $wpdb;	
		
		$table_documents = $wpdb->prefix. 'lmgt_documents';
		$user = wp_get_current_user();
		$current_user_id = $user->ID;
		
		$result = $wpdb->get_results("SELECT * FROM $table_documents where status NOT LIKE '_{$current_user_id},%' AND status NOT LIKE '%,{$current_user_id},%' AND status NOT LIKE '%,{$current_user_id}_' AND status NOT LIKE '%[{$current_user_id}]%' ORDER BY id DESC");
		return $result;	
	}
	/*<--- GET ALL  UNREAD DOCUMENT Created by FUNCTION --->*/
	public function MJ_lawmgt_get_all_unread_documents_created_by()
	{
		global $wpdb;	
		
		$table_documents = $wpdb->prefix. 'lmgt_documents';
		$user = wp_get_current_user();
		$current_user_id = $user->ID;
		
		$result = $wpdb->get_results("SELECT * FROM $table_documents where (status NOT LIKE '_{$current_user_id},%' AND status NOT LIKE '%,{$current_user_id},%' AND status NOT LIKE '%,{$current_user_id}_' AND status NOT LIKE '%[{$current_user_id}]%') AND (created_by=$current_user_id)  ORDER BY id DESC");
		return $result;	
	}
	/*<--- GET ALL  UNREAD DOCUMENT BY CLIENT  FUNCTION --->*/
	public function MJ_lawmgt_get_all_unread_documents_by_client()
	{
		global $wpdb;	
		$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
		$table_documents = $wpdb->prefix. 'lmgt_documents';
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
			$result = $wpdb->get_results("SELECT * FROM $table_documents where (status NOT LIKE '_{$current_user_id},%' AND status NOT LIKE '%,{$current_user_id},%' AND status NOT LIKE '%,{$current_user_id}_' AND status NOT LIKE '%[{$current_user_id}]%') AND (case_id IN (".implode(',', $case_id).") OR created_by=$current_user_id) ORDER BY id DESC");
		}
		else
		{
			$result ='';
		}	
		return $result;	
	}
	
	/*<--- GET ALL  UNREAD DOCUMENT  BY ATTORNY FUNCTION --->*/
	public function MJ_lawmgt_get_all_unread_documents_by_attorney()
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';			
		$table_documents = $wpdb->prefix. 'lmgt_documents';
		$user = wp_get_current_user();
		$current_user_id = $user->ID;
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
			$result = $wpdb->get_results("SELECT * FROM $table_documents where (status NOT LIKE '_{$current_user_id},%' AND status NOT LIKE '%,{$current_user_id},%' AND status NOT LIKE '%,{$current_user_id}_' AND status NOT LIKE '%[{$current_user_id}]%') AND (case_id IN (".implode(',', $case_id).") OR created_by=$attorney_id) ORDER BY id DESC");
		}
		else
		{
			$result ='';
		}	
		return $result;	
	}
	/*<--- Check DOCUMENT Status FUNCTION --->*/
	public function MJ_lawmgt_check_documents_status_by_user($id)
	{
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';
		$user = wp_get_current_user();
		$current_user_id = $user->ID;
		$result = $wpdb->get_row("SELECT * FROM $table_documents where (status LIKE '_{$current_user_id},%' OR status LIKE '%,{$current_user_id},%' OR status LIKE '%,{$current_user_id}_' OR status LIKE '%[{$current_user_id}]%') AND (id=$id) ORDER BY id DESC");
		
		if(!empty($result))
		{
			$doc_Status='Read';
		}
		else
		{
			$doc_Status='Unread';
		}
		
		return $doc_Status;	
	}
	/*<--- GET ALL  READ DOCUMENT  FUNCTION --->*/
	public function MJ_lawmgt_get_all_read_documents()
	{
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';
		$user = wp_get_current_user();
		$current_user_id = $user->ID;
		$result = $wpdb->get_results("SELECT * FROM $table_documents where status LIKE '_{$current_user_id},%' OR status LIKE '%,{$current_user_id},%' OR status LIKE '%,{$current_user_id}_' OR status LIKE '%[{$current_user_id}]%' ORDER BY id DESC");
		
		
		return $result;	
	}
	/*<--- GET ALL  READ DOCUMENT  Created by FUNCTION --->*/
	public function MJ_lawmgt_get_all_read_documents_craeted_by()
	{
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';
		$user = wp_get_current_user();
		$current_user_id = $user->ID;
		$result = $wpdb->get_results("SELECT * FROM $table_documents where (status LIKE '_{$current_user_id},%' OR status LIKE '%,{$current_user_id},%' OR status LIKE '%,{$current_user_id}_' OR status LIKE '%[{$current_user_id}]%') AND (created_by=$current_user_id) ORDER BY id DESC");
		
		
		return $result;	
	}
	/*<--- GET ALL  READ DOCUMENT BY CLIENT   FUNCTION --->*/
	public function MJ_lawmgt_get_all_read_documents_by_client()
	{
		global $wpdb;	
		$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
		$table_documents = $wpdb->prefix. 'lmgt_documents';
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
			$result = $wpdb->get_results("SELECT * FROM $table_documents where (status LIKE '_{$current_user_id},%' OR status LIKE '%,{$current_user_id},%' OR status LIKE '%,{$current_user_id}_' OR status LIKE '%[{$current_user_id}]%') AND (case_id IN (".implode(',', $case_id).") OR created_by=$current_user_id) ORDER BY id DESC");
		}
		else
		{
			$result ='';
		}
		return $result;	
	}
	/*<--- GET ALL READ DOCUMENT BY ATTORNY FUNCTION --->*/
	public function MJ_lawmgt_get_all_read_documents_by_attorney()
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';	
		$table_documents = $wpdb->prefix. 'lmgt_documents';
		$user = wp_get_current_user();
		$current_user_id = $user->ID;
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
			$result = $wpdb->get_results("SELECT * FROM $table_documents where (status LIKE '_{$current_user_id},%' OR status LIKE '%,{$current_user_id},%' OR status LIKE '%,{$current_user_id}_' OR status LIKE '%[{$current_user_id}]%') AND (case_id IN (".implode(',', $case_id).") OR created_by=$attorney_id) ORDER BY id DESC");
		}
		else
		{
			$result ='';
		}
		return $result;	
	}
	/*<--- GET ALL  ALL  DOCUMENT BY CASE ID  FUNCTION --->*/
	public function MJ_lawmgt_get_casewise_all_documents($case_id)
	{
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';
	
		$result = $wpdb->get_results("SELECT * FROM $table_documents where case_id=$case_id ORDER BY id DESC");
		return $result;	
	}
	/*<--- GET ALL  ALL  DOCUMENT BY CASE ID Created by FUNCTION --->*/
	public function MJ_lawmgt_get_casewise_all_documents_created_by($case_id)
	{
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_documents where case_id=$case_id AND created_by=$current_user_id ORDER BY id DESC");
		return $result;	
	}
	/*<--- GET CASEWISE ALL UNREAD DOCUMENT FUNCTION --->*/
	public function MJ_lawmgt_get_casewise_all_unread_documents($case_id)
	{
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';
		$user = wp_get_current_user();
		$current_user_id = $user->ID;
		$result = $wpdb->get_results("SELECT * FROM $table_documents where (status NOT LIKE '_{$current_user_id},%' AND status NOT LIKE '%,{$current_user_id},%' AND status NOT LIKE '%,{$current_user_id}_' AND status NOT LIKE '%[{$current_user_id}]%') AND (case_id=$case_id) ORDER BY id DESC");
		return $result;	
	}
	/*<--- GET CASHWISE ALL UNREAD DOCUMENT BY Created BY FUNCTION --->*/
	public function MJ_lawmgt_get_casewise_all_unread_documents_created_by($case_id)
	{
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';
		$user = wp_get_current_user();
		$current_user_id = $user->ID;
		$result = $wpdb->get_results("SELECT * FROM $table_documents where (status NOT LIKE '_{$current_user_id},%' AND status NOT LIKE '%,{$current_user_id},%' AND status NOT LIKE '%,{$current_user_id}_' AND status NOT LIKE '%[{$current_user_id}]%') AND (case_id=$case_id AND created_by=$current_user_id) ORDER BY id DESC");
		return $result;	
	}
	//GET CASEWISE ALL READ DOCUMENT FUNCTION//
	public function MJ_lawmgt_get_casewise_all_read_documents($case_id)
	{
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';
		$user = wp_get_current_user();
		$current_user_id = $user->ID;
		$result = $wpdb->get_results("SELECT * FROM $table_documents where (status LIKE '_{$current_user_id},%' OR status LIKE '%,{$current_user_id},%' OR status LIKE '%,{$current_user_id}_' OR status LIKE '%[{$current_user_id}]%') AND (case_id=$case_id) ORDER BY id DESC");
		
		return $result;	
	}
	//GET CASEWISE ALL READ DOCUMENT Created BY FUNCTION//
	public function MJ_lawmgt_get_casewise_all_read_documents_created_by($case_id)
	{
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';
		$user = wp_get_current_user();
		$current_user_id = $user->ID;
		$result = $wpdb->get_results("SELECT * FROM $table_documents where (status LIKE '_{$current_user_id},%' OR status LIKE '%,{$current_user_id},%' OR status LIKE '%,{$current_user_id}_' OR status LIKE '%[{$current_user_id}]%') AND (case_id=$case_id)  AND (created_by=$current_user_id) ORDER BY id DESC");
		
		return $result;	
	}
	/*<--- DELETE DOCUMENT  FUNCTION --->*/
	public function MJ_lawmgt_delete_documets($id)
	{
		//audit Log
		$case_id=$_REQUEST['case_id'];
		$case_name=MJ_lawmgt_get_case_name($case_id);
		$deleted_document=esc_html__('Deleted Document ','lawyer_mgt');
		$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.$case_name.'</a>';
		MJ_lawmgt_append_audit_log($deleted_document.' '.MJ_lawmgt_get_document_name($id),get_current_user_id(),$case_link);
		MJ_lawmgt_append_audit_log_for_downlaod($deleted_document.' '.$case_name,get_current_user_id(),'');
		MJ_lawmgt_append_audit_documetlog($deleted_document.' '.MJ_lawmgt_get_document_name($id),get_current_user_id(),$case_link);
		MJ_lawmgt_append_audit_caselog($deleted_document.' '.MJ_lawmgt_get_document_name($id),get_current_user_id(),$case_link);
		MJ_lawmgt_userwise_activity($deleted_document.' '.MJ_lawmgt_get_document_name($id),get_current_user_id(),$case_link);
		
		MJ_lawmgt_append_audit_caselog_download($deleted_document.' '.MJ_lawmgt_get_document_name($id), get_current_user_id());
		MJ_lawmgt_append_audit_documetlog_download($deleted_document.' '.MJ_lawmgt_get_document_name($id), get_current_user_id());
		
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';
		$result = $wpdb->query("DELETE FROM $table_documents where id= ".$id);
		return $result;
	}
	/*<--- DELETE SELECTED DOCUMENT  FUNCTION --->*/
	public function MJ_lawmgt_delete_selected_documents($all)
	{		
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';
		$result = $wpdb->query("DELETE FROM $table_documents where id IN($all)");
		return $result;
	}
	/*<--- EXPORT SELECTED DOCUMENT  FUNCTION --->*/
	public function MJ_lawmgt_export_selected_documents($all)
	{		
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';
		$result = $wpdb->get_results("select * FROM $table_documents where id IN($all)");
		return $result;
	}
} /*<---END  MJ_lawmgt_documents  CLASS--->*/
?>