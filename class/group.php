<?php  
class MJ_lawmgt_group /*<---START Lmgtgroup  CLASS--->*/
{
	  /*<--- GET ALL GROUP FUNCTION --->*/
	public function MJ_lawmgt_get_all_group()
	{
		global $wpdb;
		$table_group = $wpdb->prefix. 'posts';
	
		$result = $wpdb->get_results("SELECT * FROM $table_group where post_type = 'contact_group'");
	
		return $result;
	}
}  /*<---END  Lmgtgroup  CLASS--->*/
?>