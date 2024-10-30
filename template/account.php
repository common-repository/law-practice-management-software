<script type="text/javascript">
var $ = jQuery.noConflict();
jQuery(document).ready(function () 
{
	"use strict"; 
	$('body').on('click','.account_image', function(event){
		
		$("div.profile-cover").toggleClass("profile_image_margin"); 
	});
});
</script>
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
?>
<div class="page_inner_front"><!-- PAGE INNER DIV  -->
	<?php
	$user_object=new MJ_lawmgt_Users();
	$user = wp_get_current_user ();
	$user_data =get_userdata( $user->ID);

	require_once ABSPATH . 'wp-includes/class-phpass.php';
	$wp_hasher = new PasswordHash( 8, true );
	if(isset($_POST['save_change']))
	{
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_account_user_nonce' ) )
		{  
			$referrer = $_SERVER['HTTP_REFERER'];
			
			$success=0;
			
			if($wp_hasher->CheckPassword(sanitize_text_field($_REQUEST['current_pass']),$user_data->user_pass))
			{			
				if(isset($_REQUEST['new_pass']) == sanitize_text_field($_REQUEST['conform_pass']))
				{
					 wp_set_password( sanitize_text_field($_REQUEST['new_pass']), $user->ID);
						$success=1;
				}
				else
				{
					//wp_redirect($referrer.'&sucess=2');
					$redirect_url=$referrer.'&sucess=2';
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
			else
			{			
				//wp_redirect($referrer.'&sucess=3');
				$redirect_url=$referrer.'&sucess=3';
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
			if($success==1)
			{
				wp_cache_delete($user->ID,'users');
				wp_cache_delete($user_data->user_login,'userlogins');
				wp_logout();
				if(wp_signon(array('user_login'=>$user_data->user_login,'user_password'=>sanitize_text_field($_REQUEST['new_pass'])),false)):
					$referrer = $_SERVER['HTTP_REFERER'];
					//wp_redirect($referrer.'&sucess=1');
					$redirect_url=$referrer.'&sucess=1';
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

				endif;
			}
			else
			{
				wp_set_auth_cookie($user->ID, true);
			}
		}
	}
	if(isset($_POST['save_profile_pic']))
	{
		$referrer = $_SERVER['HTTP_REFERER'];
		if($_FILES['profile']['size'] > 0)
		{
			$image=MJ_lawmgt_load_documets($_FILES['profile'],$_FILES['profile'],'pimg');
			$profile_image_url=esc_url_row(content_url().'/uploads/document_upload/'.sanitize_file_name($image));
		    
			$returnans=update_user_meta($user->ID,'lmgt_user_avatar',$profile_image_url);
			if($returnans)
			{
				//wp_redirect($referrer.'&sucess=2');
				$redirect_url=$referrer.'&sucess=2';
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
	}		
	$edit=1;
	$coverimage=esc_url(get_option( 'lmgt_cover_image' ));
	if($coverimage!="")
	{?>
		<style>
		.profile-cover
		{
			background: url("<?php echo esc_url(get_option( 'lmgt_cover_image' ));?>") repeat scroll 0 0 / cover rgba(0, 0, 0, 0);
		}
		</style>
	<?php 
	}
	?>		
	<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		"use strict"; 
		$('#acountform').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
		$('#user_details_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
		$('#birth_date').datepicker({
				changeMonth: true,
				changeYear: true,	        
				yearRange:'-65:+0',
				 endDate: '+0d',
				autoclose: true,
				onChangeMonthYear: function(year, month, inst) {
					$(this).val(month + "/" + year);
				}                    
		 }); 	
	});
	</script>
	<!-- POP up code -->
	<div class="popup-bg">
		<div class="overlay-content">
			<div class="modal-content">
				<div class="profile_picture">
				</div>
			</div>
		</div>  
	</div>
	<!-- End POP-UP Code -->
	<div class="profile-cover responsive">
		<div class="row">		
			<div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 profile-image ">
				<div class="profile-image-container acc_img">
					<?php
					$umetadata=get_user_meta($user->ID, 'lmgt_user_avatar', true);
					
					if(empty($umetadata))
					{
						echo '<img src='.esc_url(get_option( 'lmgt_system_logo' )).' height="150px" width="150px" class="img-circle img_profile" id="profile_pic"/>';
					}
					else
						echo '<img src='.esc_url($umetadata).' height="150px" width="150px" class="img-circle img_profile" id="profile_pic" />';?>
				</div>
			</div>
		</div>
	</div>			
<div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 aa update_profile_div">
							<button class="btn btn-default btn-file profile_btn " type="file" name="profile_change" id="profile_change"><?php esc_html_e('Update Profile','lawyer_mgt');?></button>
						</div>
	<div Id="main-wrapper" class="float_left_width_100"> <!-- MAIN WRAPER  DIV -->
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
			<div class="col-lg-3 col-md-3 col-xs-12 col-sm-12">
				<h3 class="text-center">
					<?php 
						echo esc_html($user_data->display_name);
					?>
				</h3>				
				<hr>
				<ul class="list-unstyled text-center">
					<li>
					<p><i class="fa fa-map-marker m-r-xs"></i>
						<a href="#"><?php echo esc_html($user_data->address).",".esc_html($user_data->city); ?></a></p>
					</li>	
					<li><i class="fa fa-envelope m-r-xs"></i>
								<a href="#"><?php echo 	esc_html($user_data->user_email);?></a></p>
					</p>
					</li>
				</ul>
			</div>			
			<?php if(isset($_REQUEST['message']))
			{
				$message =sanitize_text_field($_REQUEST['message']);
				if($message == 2)
				{?>
					<div class="col-lg-8 col-md-8 col-xs-12 col-sm-8 alert alert-success  alert-dismissible fade in" role="alert">
						<button type="button" class="close user_message_close_button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
						</button>
						<?php esc_html_e('Record updated successfully.','lawyer_mgt');?>
					</div>								
				<?php 						
				}					
			}?>			
			<div class="col-lg-8 col-md-8 col-xs-12 col-sm-8">
				<div class="panel panel-white">
					<div class="panel-heading">
						<div class="panel-title"><?php esc_html_e('Account Settings ','lawyer_mgt');?>	</div>
					</div>
					<div class="">
						<form class="form-horizontal " id="acountform" name="acountform" action="#" method="post">
							<div class="form-group">
								<label  class="control-label col-xs-2"></label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">	
									
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail" class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12"><?php esc_html_e('Name','lawyer_mgt');?></label>

								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
									<input type="Name" class="form-control" name="first_name" placeholder="<?php esc_html_e('Full Name','lawyer_mgt');?>" value="<?php echo esc_attr($user->display_name); ?>" readonly>
									
								</div>
							</div>
							<?php wp_nonce_field( 'save_account_user_nonce' ); ?>
							<div class="form-group">
								<label for="inputEmail" class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12"><?php esc_html_e('Username','lawyer_mgt');?></label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
									<input type="username" class="form-control " placeholder="<?php esc_html_e('Full Name','lawyer_mgt');?>" value="<?php echo esc_attr($user->user_login); ?>" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword" class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12 "><?php esc_html_e('Current Password','lawyer_mgt');?></label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
									<input type="password" class="form-control" id="inputPassword" placeholder="<?php esc_html_e('Password','lawyer_mgt');?>" name="current_pass">
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword" class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12"><?php esc_html_e('New Password','lawyer_mgt');?></label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
									<input type="password" class="validate[required] form-control" id="new_pass" placeholder="<?php esc_html_e('New Password','lawyer_mgt');?>" name="new_pass">
								</div>
							</div><div class="form-group">
								<label for="inputPassword" class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12"><?php esc_html_e('Conform Password','lawyer_mgt');?></label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
									<input type="password" class="validate[required,equals[new_pass]] form-control" placeholder="<?php esc_html_e('Conform Password','lawyer_mgt');?>" name="conform_pass">
								</div>
							</div>	
							<?php
							if($user_access['edit']=='1')
							{
									?>		
								<div class="form-group">
									<div class="col-xs-offset-2 col-sm-10">
										<button type="submit" class="btn btn-success acc_save_btn" name="save_change"><?php esc_html_e('Save','lawyer_mgt');?></button>
									</div>
								</div>
								<?php
							}	
							?>	
						</form>
					</div>		   
				</div>					
				<?php
				$user_info=get_userdata(get_current_user_id());											
				?> 
				<div class="panel panel-white">
					<div class="panel-heading">
						<div class="panel-title"><?php esc_html_e('Other Information','lawyer_mgt');?>	</div>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" action="#" method="post" id="user_details_form">
							<input type="hidden" value="edit" name="action">							
							<input type="hidden" value="<?php echo  esc_attr(MJ_lawmgt_get_roles($user_info->ID));?>" name="role">
							<input type="hidden" value="<?php echo esc_attr($user_info->ID);?>" name="user_id">
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="birth_date"><?php esc_html_e('Date of birth','lawyer_mgt');?><span class="require-field">*</span></label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
								<input id="birth_date" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="form-control validate[required]" type="text"  name="birth_date" 
									value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($user_info->birth_date));}elseif(isset($_POST['birth_date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['birth_date'])); } ?>" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label for="inputEmail" class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12"><?php esc_html_e('Address','lawyer_mgt');?><span class="require-field">*</span></label>

								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
									<input id="address" class="form-control validate[required,custom[address_description_validation],maxSize[150]]" type="text"  name="address" value="<?php if($edit){ echo esc_attr($user_info->address);}?>">
								</div>
							</div>
							<?php wp_nonce_field( 'save_account_nonce' ); ?>
							<div class="form-group">
							<label for="inputEmail" class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12"><?php esc_html_e('City','lawyer_mgt');?><span class="require-field">*</span></label>

								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
									<input id="city_name" class="form-control validate[required,custom[city_state_country_validation],maxSize[50]]" type="text"  name="city_name" value="<?php if($edit){ echo esc_attr($user_info->city_name);}?>">
								</div>
							</div>
							<div class="form-group">
								<label for="inputstate" class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12"><?php esc_html_e('State','lawyer_mgt');?></label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
									<input id="state_name" class="form-control validate[custom[city_state_country_validation],maxSize[50]]" type="text"  name="state_name" value="<?php if($edit){ echo esc_attr($user_info->state_name);}?>">
								</div>
							</div>							
							<div class="form-group">
								<label for="inputEmail" class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12"><?php esc_html_e('Phone','lawyer_mgt');?> <span class="require-field">*</span></label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
									<input id="mobile" class="form-control  validate[required,custom[phone_number],minSize[6],maxSize[15]]text-input" type="text" name="mobile"  
									value="<?php if($edit){ echo esc_attr($user_info->mobile);}elseif(isset($_POST['mobile'])){ echo esc_attr($_POST['mobile']); } ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail" class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12"><?php esc_html_e('Email','lawyer_mgt');?><span class="require-field">*</span></label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
									<input id="email" class="form-control validate[required,custom[email]] text-input" type="text"  name="email" value="<?php if($edit){ echo esc_attr($user_info->user_email);}?>">
								</div>
							</div>
							<?php
							if($user_access['edit']=='1')
							{
									?>	
								<div class="form-group">
									<div class="offset-sm-2 col-sm-10">
										<button type="submit" class="btn btn-success mt_10" name="profile_save_change"><?php esc_html_e('Save','lawyer_mgt');?></button>
									</div>
								</div>
							<?php
							}
							?>	
						</form>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div><!-- END  MAIN WRAPER  DIV -->
</div><!-- END  INNER PAGE  DIV -->
<?php 
if(isset($_POST['profile_save_change']))
{
	$nonce = sanitize_text_field($_POST['_wpnonce']);
	if (wp_verify_nonce( $nonce, 'save_account_nonce' ) )
	{ 
		$result=$user_object->MJ_lawmgt_add_user($_POST);

		if($result)
		{ 
			//wp_safe_redirect(home_url()."?dashboard=user&page=account&action=edit&message=2");
			$redirect_url=home_url()."?dashboard=user&page=account&action=edit&message=2";
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
}
?>