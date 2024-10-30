<?php  
class MJ_lawmgt_practicearea /*<---START MJ_lawmgt_practicearea  CLASS--->*/
{
	
	/*<---GET ALL  MJ_lawmgt_practicearea  FUNCTION--->*/
	
	public function MJ_lawmgt_get_all_practicearea()
	{
		global $wpdb;
		$table_posts = $wpdb->prefix. 'posts';
	
		$result = $wpdb->get_results("SELECT * FROM $table_posts where post_type='practice_area'");
		return $result;
	
	}	
	/*<---GET SINGLE  MJ_lawmgt_practicearea  FUNCTION--->*/
	
	public function MJ_lawmgt_get_single_practicearea($id)
	{
		global $wpdb;
		$table_posts = $wpdb->prefix. 'posts';
	
		$result = $wpdb->get_row("SELECT * FROM $table_posts where ID='$id'");
		return $result;
	
	}
} /*<---END MJ_lawmgt_practicearea  CLASS--->*/
?>