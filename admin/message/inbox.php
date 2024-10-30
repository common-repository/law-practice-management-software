<div class="mailbox-content"><!-- MAILBOX CONTENT DIV   -->
	<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">
						<?php 
						$message = $obj_message->MJ_lawmgt_count_inbox_item(get_current_user_id());
					  
						$max = 10;
						if(isset($_GET['pg'])){
							$p = sanitize_text_field($_GET['pg']);
						}else{
							$p = 1;
						}
						$limit = ($p - 1) * $max;
						$prev = $p - 1;
						$next = $p + 1;
						$limits = (int)($p - 1) * $max;
						$totlal_message =count($message);
						$totlal_message = ceil($totlal_message / $max);
						$lpm1 = $totlal_message - 1;
						$offest_value = ($p-1) * $max;
						echo esc_attr($obj_message->MJ_lawmgt_pagination($totlal_message,$p,$prev,$next,'page=message&tab=inbox'));?>
				
		<table class="table">
			<tbody>
				<tr> 			
					<th>
						<span><?php esc_html_e('Message From','lawyer_mgt');?></span>
					</th>
					<th><?php esc_html_e('Subject','lawyer_mgt');?></th>
					 <th>
						  <?php esc_html_e('Description','lawyer_mgt');?>
					</th>
					 <th>
						  <?php esc_html_e('Date','lawyer_mgt');?>
					</th>
				</tr>
				<?php
				$post_id=0;
				$message = $obj_message->MJ_lawmgt_get_inbox_message(get_current_user_id(),$limit,$max);
				foreach($message as $msg)
				{
					if($post_id==$msg->post_id)
					{
						continue;
					}
					else
					{
						?>
						<tr>				
							<td><?php echo esc_html(MJ_lawmgt_get_display_name($msg->sender));?></td>
							<td>
								 <a href="?page=message&tab=inbox&tab=view_message&from=inbox&id=<?php echo esc_attr($msg->message_id);?>"> <?php echo esc_attr(wordwrap($msg->msg_subject,10,"<br>\n",TRUE)); /* if($obj_message->MJ_lawmgt_count_reply_item($msg->post_id)>=1){?><span class="badge badge-success pull-right"><?php echo esc_attr($obj_message->MJ_lawmgt_count_reply_item($msg->post_id));?></span><?php }  */?></a>
							</td>
							<td>
								<?php echo wordwrap(esc_html($msg->message_body),30,"<br>\n",TRUE);?>
							</td>
							<td>
								<?php  echo  MJ_lawmgt_getdate_in_input_box($msg->msg_date);?>
							</td>
						</tr>
					 <?php 
					}
					$post_id= sanitize_text_field($msg->post_id);
				}?> 		
			</tbody>
		</table>
	</div>
 </div><!--END  MAILBOX CONTENT DIV   -->