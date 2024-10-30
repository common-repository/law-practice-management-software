<?php 
MJ_lawmgt_browser_javascript_check();
//access right
$user_access=MJ_lawmgt_get_userrole_wise_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		MJ_lawmgt_access_right_page_not_access_message();
		die;
	}	
}
$obj_message = new MJ_lawmgt_message();

$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'inbox');
?>
<div class="page_inner_front"><!--  PAGE INNER DIV -->

	<?php 
	if(isset($_POST['save_message']))
	{
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_message_nonce' ) )
		{ 
			$result = $obj_message->MJ_lawmgt_add_message($_POST);
		}
	}	
	if(isset($result))
	{
		//wp_redirect ( home_url() . '?dashboard=user&page=message&tab=inbox&message=1');
		$redirect_url=home_url() . '?dashboard=user&page=message&tab=inbox&message=1';
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
	if(isset($_REQUEST['message']))
	{
		$message =sanitize_text_field($_REQUEST['message']);
		if($message == 1)
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<?php esc_html_e('Message sent successfully','lawyer_mgt');?>
			</div>				
		<?php
		}
		elseif($message == 2)
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<?php esc_html_e('Message deleted successfully','lawyer_mgt');?>
			</div>			
		<?php 			
		}
	}	
	?>
	<div id="main-wrapper"><!-- MAIN WRAPER  DIV -->
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<div class="row mailbox-header">
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
								<?php
								if($user_access['add']=='1')
								{
									?>
									<a class="btn btn-success btn-block" href="?dashboard=user&page=message&tab=compose"><?php esc_html_e('Compose','lawyer_mgt');?></a>
								<?php
								}	
								?>	
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<h2>
									<?php
									if(!isset($_REQUEST['tab']) || (sanitize_text_field($_REQUEST['tab']) == 'inbox'))
										echo esc_html( __( 'Inbox', 'lawyer_mgt' ) );
									else if(isset($_REQUEST['page']) && sanitize_text_field($_REQUEST['tab']) == 'sentbox')
										echo esc_html( __( 'Sent Item', 'lawyer_mgt' ) );
									else if(isset($_REQUEST['page']) && sanitize_text_field($_REQUEST['tab']) == 'compose')
										echo esc_html( __( 'Compose', 'lawyer_mgt' ) );
									?>
								</h2>
							</div>	   
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
							<ul class="list-unstyled mailbox-nav">
								<li <?php if(!isset($_REQUEST['tab']) || (sanitize_text_field($_REQUEST['tab']) == 'inbox')){?>class="active"<?php }?>>
									<a href="?dashboard=user&page=message&tab=inbox"><i class="fa fa-inbox"></i> <?php esc_html_e('Inbox','lawyer_mgt');?><span class="badge badge-success pull-right"><?php echo esc_html(count($obj_message->MJ_lawmgt_count_inbox_item(get_current_user_id())));?></span></a></li>
								<li <?php if(isset($_REQUEST['tab']) && sanitize_text_field($_REQUEST['tab']) == 'sentbox'){?>class="active"<?php }?>><a href="?dashboard=user&page=message&tab=sentbox"><i class="fa fa-sign-out"></i><?php esc_html_e('Sent','lawyer_mgt');?></a></li>                                
							</ul>
						</div>
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
							<?php  
							if(isset($_REQUEST['tab']) && sanitize_text_field($_REQUEST['tab']) == 'sentbox')
								require_once LAWMS_PLUGIN_DIR. '/template/message/sendbox.php';
							if(!isset($_REQUEST['tab']) || (sanitize_text_field($_REQUEST['tab']) == 'inbox'))
								require_once LAWMS_PLUGIN_DIR. '/template/message/inbox.php';
							if(isset($_REQUEST['tab']) && (sanitize_text_field($_REQUEST['tab']) == 'compose'))
								require_once LAWMS_PLUGIN_DIR. '/template/message/composemail.php';
							if(isset($_REQUEST['tab']) && (sanitize_text_field($_REQUEST['tab']) == 'view_message'))
								require_once LAWMS_PLUGIN_DIR. '/template/message/view_message.php';
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!--END  MAIN WRAPER  DIV -->
</div><!--END PAGE INNER DIV -->