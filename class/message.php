<?php 	  
class MJ_lawmgt_message  /*<---START Lmgt_message  CLASS--->*/
{	
    /*<--- ADD MESSAGE FUNCTION --->*/
	public function MJ_lawmgt_add_message($data)
	{
		global $wpdb;
		$table_message=$wpdb->prefix."lmgt_message";
		
		$created_date = date("Y-m-d H:i:s");
		$subject = sanitize_text_field($data['subject']);
		$message_body = sanitize_textarea_field($data['message_body']);
		
		$role=sanitize_text_field($data['receiver']);
		
		if($role == 'client')
		{	
			$current_user_id=get_current_user_id();
			$current_user_role=MJ_lawmgt_get_roles($current_user_id);
			if($current_user_role == 'attorney')			
			{
				$userdata=get_users(array('role'=>$role,
									'meta_key'     => 'archive',
									'meta_value'   => '0',
									'meta_compare' => '=',));
			}
			else
			{
				$userdata=get_users(array('role'=>$role,
									'meta_key'     => 'archive',
									'meta_value'   => '0',
									'meta_compare' => '=',));
			}
			
		}
		else
		{
			$userdata=get_users(array('role'=>$role));
		}
		
		if($role == 'attorney' || $role == 'client' || $role == 'staff_member' || $role == 'accountant' || $role == 'administrator')
		{ 
			if(!empty($userdata))
			{
				$mail_id = array();
				
				foreach($userdata as $user)
				{
					if($user->ID != $current_user_id)
					{
						$mail_id[]=$user->ID;
					}
				}
			
				$post_id = wp_insert_post(array(
									'post_status' => 'publish',
									'post_type' => 'lmgt_message',
									'post_title' => $subject,
									'post_content' =>$message_body			
									));
				foreach($mail_id as $user_id)
				{			
					$reciever_id = $user_id;
					$message_data=array('sender'=>get_current_user_id(),
										'receiver'=>$user_id,
										'msg_subject'=>$subject,
										'message_body'=>$message_body,
										'msg_date'=>$created_date,
										'msg_status' =>0,
										'post_id' =>$post_id
									);
					
					$result=$wpdb->insert( $table_message, $message_data );
					
					$user = get_userdata($user_id);
					$role=$user->roles;
					$reciverrole=$role[0];
					if($reciverrole == 'administrator' )
					{
						$page_link= sanitize_url(admin_url().'admin.php?page=message&tab=inbox');
					}
					else
					{
						$page_link= sanitize_url(home_url().'/?dashboard=user&page=message&tab=inbox');
					} 
						
					//start mail subject
					
					$reciever_data=get_userdata($user_id);
					$reciever_name= sanitize_text_field($reciever_data->display_name);
					$reciever_email= sanitize_email($reciever_data->user_email);
					$sender_id=get_current_user_id();
					$senderdata=get_userdata($sender_id);
					$sendername_name= sanitize_text_field($senderdata->display_name);
					$system_name=get_option('lmgt_system_name');
					
					$arr['{{Receiver Name}}']=$reciever_name;			
					$arr['{{Sender Name}}']=$sendername_name;
					$arr['{{Message Content}}']=$message_body;
					$arr['{{Lawyer System Name}}']=$system_name;	
					$arr['{{Message_Link}}']=$page_link;
					
					$to=array();
					
					$to[]=$reciever_email;
		
					$email_subject =get_option('lmgt_message_received_email_subject');
					$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$email_subject);
					$message = get_option('lmgt_message_received_email_template');	
					$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
					
					MJ_lawmgt_send_mail($to,$subject_replacement,$message_replacement); 
					
					//end send mail	
				}
				$result=add_post_meta($post_id, 'message_for',$role);
				$result = 1;  
			}
		}
		else 
		{			
			$user_id = $data['receiver'];
			$post_id = wp_insert_post( array(
					'post_status' => 'publish',
					'post_type' => 'lmgt_message',
					'post_title' => $subject,
					'post_content' =>$message_body			
			) );
			$message_data=array('sender'=>get_current_user_id(),
					'receiver'=>$user_id,
					'msg_subject'=>$subject,
					'message_body'=>$message_body,
					'msg_date'=>$created_date,
					'msg_status' =>0,
					'post_id' =>$post_id
			);
			
			$user = get_userdata($user_id);
			$role=$user->roles;
			$reciverrole=$role[0];
			if($reciverrole == 'administrator' ) 
			{
				$page_link= sanitize_url(admin_url().'admin.php?page=message&tab=inbox');
			}
			else
			{
				$page_link= sanitize_url(home_url().'/?dashboard=user&page=message&tab=inbox');
			} 
			//start mail subject 			
			$reciever_data=get_userdata($user_id);
			$reciever_name= sanitize_text_field($reciever_data->display_name);
			$reciever_email= sanitize_email($reciever_data->user_email);
			$sender_id=get_current_user_id();
			$senderdata=get_userdata($sender_id);
			$sendername_name= sanitize_text_field($senderdata->display_name);
			$system_name=get_option('lmgt_system_name');
			
			$arr['{{Receiver Name}}']=$reciever_name;			
			$arr['{{Sender Name}}']=$sendername_name;
			$arr['{{Message Content}}']=$message_body;
			$arr['{{Lawyer System Name}}']=$system_name;	
			$arr['{{Message_Link}}']=$page_link;
			
			$to=array();
			
			$to[]=$reciever_email;

			$email_subject =get_option('lmgt_message_received_email_subject');
			$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$email_subject);
			$message = get_option('lmgt_message_received_email_template');	
			$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
			
			MJ_lawmgt_send_mail($to,$subject_replacement,$message_replacement); 
					
			//end send mail	
			
			$result=$wpdb->insert($table_message,$message_data);	
			
			$result=add_post_meta($post_id, 'message_for','user');
			$result=add_post_meta($post_id, 'message_for_userid',$user_id); 
		}
		
		return $result;	
	}
	/*<--- DELETE MESSAGE FUNCTION --->*/
	public function MJ_lawmgt_delete_message($mid)
	{
		global $wpdb;
		$table_lmgt_message = $wpdb->prefix. 'lmgt_message';
		$result = $wpdb->query("DELETE FROM $table_lmgt_message where message_id= ".$mid);
		
		return $result;
	}
	/*<--- COUNT SEND  MESSAGE FUNCTION --->*/
	public function MJ_lawmgt_count_send_item($user_id)
	{
		global $wpdb;
		$posts = $wpdb->prefix."posts";
		$total =$wpdb->get_var("SELECT Count(*) FROM ".$posts." Where post_type = 'lmgt_message' AND post_author = $user_id");
		return $total;
	}
	
	/*<--- COUNT INBOX MESSAGE FUNCTION --->*/
	public function MJ_lawmgt_count_inbox_item($user_id)
	{
		global $wpdb;
		$tbl_name_message = $wpdb->prefix .'lmgt_message';
		
		$inbox =$wpdb->get_results("SELECT *  FROM $tbl_name_message where receiver = $user_id AND msg_status=0");
		return $inbox;
	}
	
	/*<--- GET  INBOX MESSAGE FUNCTION --->*/	
	public function MJ_lawmgt_get_inbox_message($user_id,$p=0,$lpm1=10)
	{
		global $wpdb;
		$tbl_name_message = $wpdb->prefix.'lmgt_message';
		$tbl_name_message_replies = $wpdb->prefix .'lmgt_message_replies';
		$inbox = $wpdb->get_results("SELECT DISTINCT b.message_id, a.* FROM $tbl_name_message a LEFT JOIN $tbl_name_message_replies b ON a.post_id = b.message_id WHERE ( a.receiver = $user_id OR b.receiver_id =$user_id)  ORDER BY msg_date DESC limit $p , $lpm1");
		return $inbox;
	}
	/*<--- MESSAGE PAGINATION FUNCTION --->*/
	public function MJ_lawmgt_pagination($totalposts,$p,$prev,$next,$page)
	{		
		$pagination = "";
		
		if($totalposts > 1)
		{
			$pagination .= '<div class="btn-group">';
		
			if ($p > 1)
				$pagination.= "<a href=\"?$page&pg=$prev\" class=\"btn btn-default\"><i class=\"fa fa-angle-left\"></i></a> ";
			else
				$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-left\"></i></a> ";
		
			if ($p < $totalposts)
				$pagination.= " <a href=\"?$page&pg=$next\" class=\"btn btn-default next-page\"><i class=\"fa fa-angle-right\"></i></a>";
			else
				$pagination.= " <a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-right\"></i></a>";
			$pagination.= "</div>\n";
		}
		return $pagination;
	}
	
	/*<---SEND  MESSAGE FUNCTION --->*/
	public function MJ_lawmgt_get_send_message($user_id,$max=10,$offset=0)
	{	
		$args['post_type'] = 'lmgt_message';
		$args['posts_per_page'] =$max;
		$args['offset'] = $offset;
		$args['post_status'] = 'public';
		$args['author'] = $user_id;			
		$q = new WP_Query();
		$sent_message = $q->query( $args );
		return $sent_message;
	}	
	/*<--GET  MESSAGE  BY FUNCTION --->*/
	public function MJ_lawmgt_get_message_by_id($id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "lmgt_message";
		
		$qry = $wpdb->prepare( "SELECT * FROM $table_name WHERE message_id= %d ",$id);
		return $retrieve_subject = $wpdb->get_row($qry);
	
	}
	/*<---SEND  REPLY  MESSAGE FUNCTION --->*/
	public function MJ_lawmgt_send_replay_message($data)
	{			
		global $wpdb;
		$table_name = $wpdb->prefix . "lmgt_message_replies";
		$messagedata['message_id'] = sanitize_text_field($data['message_id']);
		$messagedata['sender_id'] = sanitize_text_field($data['user_id']);
		$messagedata['receiver_id'] = sanitize_text_field($data['receiver_id']);
		$messagedata['message_comment'] = sanitize_textarea_field($data['replay_message_body']);
		$messagedata['created_date'] = date("Y-m-d h:i:s");
		$result=$wpdb->insert( $table_name, $messagedata );
		if($result)	
		return $result;
	}
	/*<---GET ALL REPLY  MESSAGE FUNCTION --->*/
	public function MJ_lawmgt_get_all_replies($id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "lmgt_message_replies";
		return $result =$wpdb->get_results("SELECT * FROM $table_name where message_id = $id");
	}
	/*<---COUNT REPLY ITEM FUNCTION --->*/
	public function MJ_lawmgt_count_reply_item($id)
	{
		global $wpdb;
		$tbl_name = $wpdb->prefix .'lmgt_message_replies';
		
		$result=$wpdb->get_var("SELECT count(*) FROM $tbl_name where message_id = $id");
		return $result;
	}
	/*<---DELETE REPLY  FUNCTION --->*/
	public function MJ_lawmgt_delete_reply($id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "lmgt_message_replies";
		$reply_id['id']=$id;
		return $result=$wpdb->delete( $table_name, $reply_id);
	}	
} /*<---END  Lmgt_message  CLASS--->*/
?>