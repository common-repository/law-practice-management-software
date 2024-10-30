<?php 
class MJ_lawmgt_rules 
{  
/*<---START MJ_lawmgt_Note  CLASS--->*/
/*<--- ADD Rule FUNCTION --->*/
	function MJ_lawmgt_add_rules($rule_data,$upload_docs_array)
	{ 
		
		global $wpdb;
		 $table_rules = $wpdb->prefix. 'lmgt_add_rules'; 
		 $rules_data['rule_name']=sanitize_text_field($rule_data['rule_name']);
		 $rules_data['description']=sanitize_textarea_field($rule_data['description']);		
		 
		 if(esc_attr($rule_data['action'])=='edit')
		{	
			
			$rule_id['id']=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id']));
			$rules_data['updated_by']=get_current_user_id();
			$rules_data['updated_date']=date("Y-m-d H:i:s");
			$document_data=array();	
			
			$document_data[]=array('title'=>sanitize_text_field($rule_data['document_name']),'value'=>$upload_docs_array);
			$rules_data['document_url']=json_encode($document_data);
			
			$result=$wpdb->update( $table_rules, $rules_data ,$rule_id);
			  	 
		}
		else
		{	
		 $rules_data['created_by']=get_current_user_id();
		 $rules_data['created_date']=date("Y-m-d H:i:s");
			$document_data=array();	
			
			$document_data[]=array('title'=>sanitize_text_field($rule_data['document_name']),'value'=>$upload_docs_array);
			$rules_data['document_url']=json_encode($document_data);
			 
			$result=$wpdb->insert( $table_rules, $rules_data);
		}
		
		return $result;
	} 
	/*<---GET ALL Rules  FUNCTION --->*/
	public function MJ_lawmgt_get_all_rules() 
	{
		global $wpdb;
		$table_rules= $wpdb->prefix. 'lmgt_add_rules';
		$result = $wpdb->get_results("SELECT * FROM $table_rules where deleted_status=0");
		return $result;

	}
	/*<---GET SINGLE  Rules BY ID  FUNCTION --->*/
	public function MJ_lawmgt_get_signle_rule_by_id($id)
	{
		global $wpdb;
		$table_rules= $wpdb->prefix. 'lmgt_add_rules';
		$result = $wpdb->get_row("SELECT * FROM $table_rules where id=$id");
		 
		return $result;
	}
	/*<---DELETE RULES  FUNCTION--->*/
	public function MJ_lawmgt_delete_rules($id)
	{
		global $wpdb;
		$table_rules= $wpdb->prefix. 'lmgt_add_rules';
		$rules_data['deleted_status']=1;
		$whereid['id']=$id;
		$delete_rules=$wpdb->update($table_rules, $rules_data, $whereid);
		return $delete_rules;
	}
	/*<---DELETE MULTIPLE RECORD  FUNCTION--->*/
	public function MJ_lawmgt_delete_selected_rules($record_id)
	{	
	
		global $wpdb;
		$table_rules= $wpdb->prefix. 'lmgt_add_rules';
		$rules_data['deleted_status']=1;
		$whereid['id']=$record_id;
		$result=$wpdb->update($table_rules, $rules_data, $whereid);
		return $result;
	}
}
?>