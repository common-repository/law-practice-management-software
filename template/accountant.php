 <?php 	
MJ_lawmgt_browser_javascript_check();
//access right
$user_access=MJ_lawmgt_get_userrole_wise_access_right_array();
$obj_user=new MJ_lawmgt_Users;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'accountantlist');
?>
<div class="page_inner_front"><!--  PAGE INNER DIV -->
	
	<div id="main-wrapper"><!-- MAIN WRAPER  DIV -->
		<div class="row"><!--  ROW DIV   --> 
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white"><!-- PANEL WHITE  DIV -->
					<div class="panel-body panel_body_flot_css"><!-- PANEL BODY  DIV -->
						<h2 class="nav-tab-wrapper margin_bottom">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="tablist">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'accountantlist' ? 'active' : ''; ?> menucss active_mt">
									<a href="?dashboard=user&page=accountant&tab=accountantlist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Accountant List', 'lawyer_mgt'); ?>
									</a>
								</li>
								<?php
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
								{	
								?>	
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'view_accountant' ? 'active' : ''; ?> menucss active_mt">
											<a href="?dashboard=user&page=accountant&tab=view_accountant&action=view&accountant_id=<?php echo esc_attr($_REQUEST['accountant_id']);?>">
										<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('View Accountant', 'lawyer_mgt'); ?>
									</a>
								</li>
								<?php
								}
								?>
							</ul>	
						</h2>
						<?php 
						if($active_tab == 'accountantlist')
						{ ?>	
							<script type="text/javascript">
							jQuery(document).ready(function($)
							{
								"use strict"; 
								jQuery('#accountant_list').DataTable({
									"order": [[ 1, "asc" ]],
									"autoWidth": false,
									"responsive": true,
									language:<?php echo wpnc_datatable_multi_language();?>,
									 "aoColumns":[
												  {"bSortable": false},
												  {"bSortable": true},
												  {"bSortable": true},
												  {"bVisible": true},	                 
												  {"bSortable": false}
											   ]
									});	
							} );
							</script>
							<form name="wcwm_report" action="" method="post">
								<div class="panel-body">
									<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">
										<table id="accountant_list" class="table table-striped table-bordered">
											<thead>
												<tr>
													<th><?php  esc_html_e('Photo', 'lawyer_mgt' ) ;?></th>
													<th><?php esc_html_e('accountant Name', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('accountant Email', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Mobile Number', 'lawyer_mgt' ) ;?></th>
													<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if($user_role == 'accountant')
												{
													if($user_access['own_data'] == '1')
													{	
														$user_id = get_current_user_id();
														$accountantdata=array();
														$accountantdata[]=get_userdata($user_id);	
													}
													else			
													{
														 $get_accountant = array(
														'role' => 'accountant',
														'meta_query' =>array( 
															array(
																	'key' => 'deleted_status',
																	'value' =>0,
																	'compare' => '='
																)
														)	
														);	
														$accountantdata=get_users($get_accountant);
													}	
												}
												else			
												{
													 $get_accountant = array(
													'role' => 'accountant',
													'meta_query' =>array( 
														array(
																'key' => 'deleted_status',
																'value' =>0,
																'compare' => '='
															)
													)	
												);	
													$accountantdata=get_users($get_accountant);
												}
												if(!empty($accountantdata))
												{
													foreach ($accountantdata as $retrieved_data)
													{
													?>
													<tr>
														<td class="user_image"><?php $uid=$retrieved_data->ID;
															$userimage=get_user_meta($uid, 'lmgt_user_avatar', true);
															if(empty($userimage))
															{
																echo '<img src='.esc_url(get_option( 'lmgt_system_logo' )).' height="50px" width="50px" class="img-circle" />';
															}
															else
																echo '<img src='.esc_url($userimage).' height="50px" width="50px" class="img-circle"/>';
														?>
														</td>
														<td class="name"> <?php echo esc_html($retrieved_data->display_name);?> </td>				
														<td class="email"><?php echo esc_html($retrieved_data->user_email);?></td>
														<td class="mobile"><?php echo esc_html($retrieved_data->mobile);?></td>
														<td class="action">
														<a href="?dashboard=user&page=accountant&tab=view_accountant&action=view&accountant_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
														</td>               
													</tr>
													<?php 
													} 													
												}?>     
											</tbody>        
										</table>
									</div>
								</div>       
							</form>
						<?php 
						}	
						if($active_tab == 'view_accountant')
						{
						?>	
							<?php 
							$role='accountant';
							$obj_user=new MJ_lawmgt_Users;
							$accountant_id=0;
							$edit=0;
							if(isset($_REQUEST['accountant_id']))
								$accountant_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['accountant_id']));
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
								{					
									$edit=1;
									$user_info = get_userdata($accountant_id);				
								}?>		
							<div class="panel-body">
								<div class="header margin_document_to">	
									<h3 class="first_hed"><?php esc_html_e('Personal Information','lawyer_mgt');?></h3>
									<hr>
								</div>
								<div class="member_view_row1">
									<div class="col-lg-8 col-md-12 col-xs-12 col-sm-12 membr_left">
										<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 left_side">
										 <?php if($edit) 
											   {
													if($user_info->lmgt_user_avatar == "")
													{?>
													<img alt="" class="max_width_100px" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
													<?php }
													else {
														?>
													<img class="image_upload max_width_100px" src="<?php if($edit)echo esc_url( $user_info->lmgt_user_avatar ); ?>" />
													<?php 
													}
												}
												else 
												{
													?>
													<img alt="" class="max_width_100_per_css" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
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
													<span class="txt_color"><?php echo chunk_split(esc_html($user_info->user_email),20,"<BR>"); ?></span>
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
									<div class="col-lg-4 col-md-12 col-xs-12 col-sm-12 member_right">
										<span class="report_title">
											<span class="fa-stack cutomcircle">
												<i class="fa fa-align-left fa-stack-1x"></i>
											</span>
											<span class="shiptitle"><?php esc_html_e('More Info','lawyer_mgt');?></span>
										</span>
										<div class="table_row">
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
										?> 		</span>
											</div>
										</div>
									</div>
								</div> 		
							</div>		
						<?php 
						}
						?>
					</div>			
				</div>
			</div>
		</div>
	</div>
</div><!--  END PAGE INNER DIV -->