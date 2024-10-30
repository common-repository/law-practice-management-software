<script type="text/javascript">
	jQuery(document).ready(function($) 
	{
		"use strict"; 
		$('#message-replay').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	    jQuery("span.timeago").timeago();
	});
</script>

<?php 
MJ_lawmgt_browser_javascript_check();
//access right
$user_access=MJ_lawmgt_get_userrole_wise_access_right_array();
if(sanitize_text_field($_REQUEST['from'])=='sendbox')
{
	$message = get_post(sanitize_text_field($_REQUEST['id']));
	$box='sendbox';
	if(isset($_REQUEST['delete']))
	{
		echo esc_attr($_REQUEST['delete']);
		wp_delete_post(sanitize_text_field($_REQUEST['id']));
		//wp_safe_redirect(home_url()."?dashboard=user&page=message&tab=sentbox&message=2" );
		$redirect_url=home_url()."?dashboard=user&page=message&tab=sentbox&message=2" ;
		if (!headers_sent())
		{
			header('Location: '.esc_url($redirect_url));
		}
		else 
		{
			echo '<script type="text/javascript">';
			echo 'window.location.href="'.esc_url($redirect_url).'";';
			echo '</script>';
		}
		exit();
	}
}
if(esc_attr($_REQUEST['from'])=='inbox')
{
		$message = $obj_message->MJ_lawmgt_get_message_by_id(sanitize_text_field($_REQUEST['id']));
		MJ_lawmgt_change_read_status(sanitize_text_field($_REQUEST['id']));
		$box='inbox';

	if(isset($_REQUEST['delete']))
	{		
		$obj_message->MJ_lawmgt_delete_message(sanitize_text_field($_REQUEST['id']));
		//wp_safe_redirect(home_url()."?dashboard=user&page=message&tab=inbox&message=2" );
		$redirect_url=home_url()."?dashboard=user&page=message&tab=inbox&message=2";
		if (!headers_sent())
		{
			header('Location: '.esc_url($redirect_url));
		}
		else 
		{
			echo '<script type="text/javascript">';
			echo 'window.location.href="'.esc_url($redirect_url).'";';
			echo '</script>';
		}
		exit();
	}

}
if(isset($_POST['replay_message']))
{
	$message_id=sanitize_text_field($_REQUEST['id']);
	$message_from=sanitize_text_field($_REQUEST['from']);
	$result=$obj_message->MJ_lawmgt_send_replay_message($_POST);
	if($result)
	{
		//wp_safe_redirect(home_url()."?dashboard=user&page=message&tab=view_message&from=".$message_from."&id=$message_id&message=1" );
	    $redirect_url=home_url()."?dashboard=user&page=message&tab=view_message&from=".$message_from."&id=$message_id&message=1" ;
		if (!headers_sent())
		{
			header('Location: '.esc_url($redirect_url));
		}
		else 
		{
			echo '<script type="text/javascript">';
			echo 'window.location.href="'.esc_url($redirect_url).'";';
			echo '</script>';
		}
	}
}
if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='delete-reply')
{
	$message_id=sanitize_text_field($_REQUEST['id']);
	$message_from=sanitize_text_field($_REQUEST['from']);
	$result=$obj_message->MJ_lawmgt_delete_reply(sanitize_text_field($_REQUEST['reply_id']));
	if($result)
	{
		//wp_redirect ( home_url().'?dashboard=user&page=message&tab=view_message&action=delete-reply&from='.$message_from.'&id='.$message_id.'&message=2');
	    $redirect_url=home_url().'?dashboard=user&page=message&tab=view_message&action=delete-reply&from='.$message_from.'&id='.$message_id.'&message=2';
		if (!headers_sent())
		{
			header('Location: '.esc_url($redirect_url));
		}
		else 
		{
			echo '<script type="text/javascript">';
			echo 'window.location.href="'.esc_url($redirect_url).'";';
			echo '</script>';
		}
	 }
}
?>
<div class="mailbox-content"><!-- MAIL BOX CONTENT DIV  -->
 	<div class="message-header">
		<h3><span><?php esc_html_e('Subject','lawyer_mgt')?> :</span>  <?php if($box=='sendbox'){ echo esc_html($message->post_title); } else{ echo esc_html($message->msg_subject); } ?></h3>

		<p class="message-date"><?php  if($box=='sendbox') echo MJ_lawmgt_getdate_in_input_box(esc_html($message->post_date)); else echo MJ_lawmgt_getdate_in_input_box(esc_html($message->msg_date));?></p>
	</div>
	<div class="message-sender">                                
    	<p>
			<?php 
			if($box=='sendbox')
			{
				$message_for=get_post_meta(sanitize_text_field($_REQUEST['id']),'message_for',true);
				echo "From: ".(MJ_lawmgt_get_display_name($message->post_author))."<span>&lt;".MJ_lawmgt_get_emailid_byuser_id(esc_html($message->post_author))."&gt;</span><br>";
				if($message_for == 'user')
				{
					echo "To: ".esc_html(MJ_lawmgt_get_display_name(get_post_meta(sanitize_text_field($_REQUEST['id']),'message_for_userid',true)))."<span>&lt;".esc_html(MJ_lawmgt_get_emailid_byuser_id(get_post_meta($_REQUEST['id'],'message_for_userid',true)))."&gt;</span><br>";
				}
				else
				{
					echo "To: ".esc_html__('Group','lawyer_mgt');
				} 
			} 
			else
			{ 
				echo "From: ".esc_html(MJ_lawmgt_get_display_name($message->sender))."<span>&lt;".esc_html(MJ_lawmgt_get_emailid_byuser_id($message->sender))."&gt;</span><br> To: ".esc_html(MJ_lawmgt_get_display_name($message->receiver));  ?> <span>&lt;<?php echo esc_html(MJ_lawmgt_get_emailid_byuser_id($message->receiver));?>&gt;</span>
			<?php 
			}
			?>
		</p>	
	</div>
    <div class="message-content">	
    	<!--<p><?php if($box=='sendbox'){ echo esc_html($message->post_content); } else{ echo esc_html($message->message_body); }?></p>-->
		<p>
			<?php 
			$receiver_id=0;
			if($box=='sendbox')
			{ 
				echo wordwrap(esc_html($message->post_content),70,"<br>\n",TRUE);
				$receiver_id=get_post_meta(sanitize_text_field($_REQUEST['id']),'message_for_userid',true);
			} 
			else
			{ 
				echo wordwrap(esc_html($message->message_body),70,"<br>\n",TRUE);
				$receiver_id=$message->sender;
			}
			?>
		</p>
		<?php
		if($user_access['delete']=='1')
		{
			?>
			<div class="message-options pull-right">
				<a class="btn btn-default" href="?dashboard=user&page=message&tab=view_message&id=<?php echo esc_attr($_REQUEST['id']);?>&from=<?php echo $box;?>&delete=1" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');"><i class="fa fa-trash m-r-xs"></i><?php esc_html_e('Delete','lawyer_mgt')?></a> 
		   </div>
		<?php
		}
		?>
    </div>
	<?php 
	if(isset($_REQUEST['from']) && sanitize_text_field($_REQUEST['from'])=='inbox')
			$allreply_data=$obj_message->MJ_lawmgt_get_all_replies(sanitize_text_field($message->post_id));
		else
			$allreply_data=$obj_message->MJ_lawmgt_get_all_replies(sanitize_text_field($_REQUEST['id']));
	foreach($allreply_data as $reply)
	{ ?>
		<div class="message-content">
			<p><?php echo esc_html($reply->message_comment);?><br><h5><?php esc_html_e('Reply By: ','lawyer_mgt'); echo esc_html(MJ_lawmgt_get_display_name($reply->sender_id));
			if($reply->sender_id == get_current_user_id())
			{
				if($user_access['delete']=='1')
				{
				 ?>		
					<span class="comment-delete">
					<a href="?dashboard=user&page=message&tab=view_message&action=delete-reply&from=<?php echo esc_attr($_REQUEST['from']);?>&id=<?php echo esc_attr($_REQUEST['id']);?>&reply_id=<?php echo esc_attr($reply->id);?>"><?php esc_html_e('Delete','lawyer_mgt');?></a></span> 
				<?php
				}
			}
		 
			?>
			<span class="timeago" title="<?php echo esc_html(MJ_lawmgt_wpnc_convert_time($reply->created_date));?>"></span>
			 
			</h5> 
			</p>
		</div>
	<?php 
	} 
	?>
	<form name="message-replay" method="post" id="message-replay">
		<input type="hidden" name="message_id" value="<?php if($_REQUEST['from']=='sendbox') echo esc_attr($_REQUEST['id']); else echo esc_attr($message->post_id);?>">
		<input type="hidden" name="user_id" value="<?php echo esc_attr(get_current_user_id());?>">
		<input type="hidden" name="receiver_id" value="<?php echo esc_attr($receiver_id);?>">
		<div class="message-content">
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
				<textarea name="replay_message_body" maxlength="150" id="replay_message_body" class="form-control bottom_reply validate[required]  text-input"></textarea>			
			</div>
			<div class="message-options pull-right reply-message-btn">
				<button type="submit" name="replay_message" class="btn btn-default"><i class="fa fa-reply m-r-xs"></i><?php esc_html_e('Reply','lawyer_mgt')?></button>			
			</div>
		</div>
	</form>
</div><!-- END MAIL BOX CONTENT DIV  -->