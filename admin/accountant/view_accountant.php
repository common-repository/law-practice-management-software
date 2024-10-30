<?php 
$role='accountant';
$obj_user=new MJ_lawmgt_Users;
if($active_tab == 'view_accountant')
{
    $accountant_id=0;
	$edit=0;
	if(isset($_REQUEST['accountant_id']))
		$accountant_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['accountant_id']));
		if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
		{					
			$edit=1;
			$user_info = get_userdata($accountant_id);						
		}?>
		<div class="panel-body panel_body_flot_css"><!-- PANEL BODY DIV   --> 
			<div class="header">	
				<h3 class="first_hed"><?php esc_html_e('Personal Information','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="member_view_row1">
				<div class="col-lg-8 col-md-8 col-xs-12 col-sm-12 membr_left">
					<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 left_side">
					 <?php if($edit) 
							{
								if($user_info->lmgt_user_avatar == "")
								{?>
									<img alt="" class="max_width_100px" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
								<?php 
								}
								else 
								{
								?>
									<img class="image_upload max_width_100px" src="<?php if($edit)echo esc_url( $user_info->lmgt_user_avatar ); ?>" />
								<?php 
								}
							}
							else 
							{
							?>
								<img alt="" class="max_width_100px" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
								<?php 
							}?>
					</div>
					<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 right_side">
						<div class="table_row">
							<div class="col-md-5 col-sm-12 table_td">
								<i class="fa fa-user"></i>
								<?php esc_html_e('Name','lawyer_mgt'); ?>
							</div>
							<div class="col-md-7 col-sm-12 table_td">
								<span class="txt_color">
									<?php echo esc_html($user_info->first_name." ".$user_info->middle_name." ".$user_info->last_name);?>
								</span>
							</div>
						</div>
						<div class="table_row">
							<div class="col-md-5 col-sm-12 table_td">
								<i class="fa fa-envelope"></i>
								<?php esc_html_e('Email','lawyer_mgt');?>
							</div>
							<div class="col-md-7 col-sm-12 table_td">
								<span class="txt_color"><?php echo chunk_split(esc_html($user_info->user_email,20,"<BR>")); ?></span>
							</div>
						</div>
						<div class="table_row">
							<div class="col-md-5 col-sm-12 table_td"><i class="fa fa-phone"></i> <?php esc_html_e('Mobile No','lawyer_mgt');?> </div>
							<div class="col-md-7 col-sm-12 table_td">
								<span class="txt_color">
									<span class="txt_color"><?php echo esc_html($user_info->mobile);?> </span>
								</span>
							</div>
						</div>
						<div class="table_row">
							<div class="col-md-5 col-sm-12 table_td">
								<i class="fa fa-calendar"></i> <?php esc_html_e('Date Of Birth','lawyer_mgt');?>
							</div>
							<div class="col-md-7 col-sm-12 table_td">
								<span class="txt_color"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($user_info->birth_date));?></span>
							</div>
						</div>
						<div class="table_row">
							<div class="col-md-5 col-sm-12 table_td">
								<i class="fa fa-mars"></i> <?php esc_html_e('Gender','lawyer_mgt');?>
							</div>
							<div class="col-md-7 col-sm-12 table_td">
								<span class="txt_color"><?php echo esc_html($user_info->gender);?></span>
							</div>
						</div>
						<div class="table_row">
							<div class="col-md-5 col-sm-12 table_td">
								<i class="fa fa-user"></i> <?php esc_html_e('UserName','lawyer_mgt');?>
							</div>
							<div class="col-md-7 col-sm-12 table_td">
								<span class="txt_color"><?php echo esc_html($user_info->user_login);?> </span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-xs-12 col-sm-12 member_right">
					<span class="report_title">
						<span class="fa-stack cutomcircle">
							<i class="fa fa-align-left fa-stack-1x"></i>
						</span>
						<span class="shiptitle"><?php esc_html_e('More Info','lawyer_mgt');?></span>
					</span>
					<div class="table_row table_row_border">
						<div class="col-md-4 col-sm-12 table_td">
							<i class="fa fa-map-marker"></i> <?php esc_html_e('Address','lawyer_mgt');?>
						</div>
						<div class="col-md-8 col-sm-12 table_td">
							<span class="txt_color"><?php
								if($edit)
								{ 
									if($user_info->address != '')
										echo esc_html($user_info->address).", <BR>";
									if($user_info->city_name != '')
										 echo esc_html($user_info->city_name).", <BR>";
									if($user_info->state_name != '')
										 echo esc_html($user_info->state_name).", <BR>";
									if($user_info->pin_code != '')
										echo esc_html($user_info->pin_code).".";
								}
								?> 
							</span>
						</div>
					</div>
				</div>
			</div> 		
		</div>	<!-- END PANEL BODY DIV   --> 	
<?php 
}
?>