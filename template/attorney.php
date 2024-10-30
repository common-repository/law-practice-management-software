<?php 	
MJ_lawmgt_browser_javascript_check();
//access right
$user_access=MJ_lawmgt_get_userrole_wise_access_right_array();

$curr_user_id=get_current_user_id();
$obj_user=new MJ_lawmgt_Users;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'attorneylist');
?>
<div class="page_inner_front"><!--  PAGE INNER DIV -->
	
	<div id="main-wrapper"><!--  PAGE MAIN WRAPPER DIV -->
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<h2 class="nav-tab-wrapper margin_bottom">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="tablist">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'attorneylist' ? 'active' : ''; ?> menucss active_mt">
									<a href="?dashboard=user&page=attorney&tab=attorneylist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Attorney List', 'lawyer_mgt'); ?>
									</a>
								</li>			
								<?php
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
								{	
								?>	
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'view_attorney' ? 'active' : ''; ?> menucss active_mt">
									<a href="?dashboard=user&page=attorney&tab=view_attorney&action=view&attorney_id=<?php echo esc_attr($_REQUEST['attorney_id']);?>">
										<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('View Attorney', 'lawyer_mgt'); ?>
									</a>
								</li>
								<?php
								}
								?>
							</ul>
						</h2>
						<?php 
						if($active_tab == 'attorneylist')
						{ ?>	
							<script type="text/javascript">
							var $ = jQuery.noConflict();
							jQuery(document).ready(function($)
							{
								"use strict"; 
								jQuery('#attorney_list').DataTable({
									 "order": [[ 1, "asc" ]],
									 "responsive": true,
										"autoWidth": false,
									 language:<?php echo wpnc_datatable_multi_language();?>,
									 "aoColumns":[
												  {"bSortable": false},
												  {"bSortable": true},
												  {"bSortable": true},
												  {"bSortable": true},
												  {"bSortable": true},
												  {"bSortable": true},
												  {"bVisible": true}
												  <?php  
												if($user_role !== 'client' && $user_role !== 'accountant' )
												{ 
													?>
												  ,{"bSortable": false}
												 <?php  
												 } 
												 ?> 												  
											   ]				
									});
								
							} );
							</script>
							<div class="panel-body">
							<form name="wcwm_report" action="" method="post">
								
									<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">
										<table id="attorney_list" class="table table-striped table-bordered">
											<thead>
												<tr>
													<th><?php  esc_html_e('Photo', 'lawyer_mgt' ) ;?></th>
													<th><?php esc_html_e('Attorney Name', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Attorney Email', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Mobile Number', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Degree', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Experience(Years)', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Rate', 'lawyer_mgt' ) ;?></th>
												<?php  
												 if($user_role !== 'client' && $user_role !== 'accountant' && $user_role !== 'staff_member'  )
												{ 
													?>
													<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
												<?php  
												}  
												?>
												</tr>
											</thead>
											<tbody>
												<?php
												if($user_role == 'attorney')
												{	
													if($user_access['own_data'] == '1')
													{
														$user_id=get_current_user_id();		
				
														$attorneydata=array();
				
														$attorneydata[]=get_userdata($user_id);	
																												
													}
													else
													{	
														 $args = array(
														'role' => 'attorney',
														'meta_query' =>array( 
															array(
																	'key' => 'deleted_status',
																	'value' =>0,
																	'compare' => '='
																)
															)	
														);	
														$attorneydata=get_users($args);
													}
												}
												elseif($user_role == 'client')
												{		
												
													if($user_access['own_data'] == '1')
													{
														$obj_case=new MJ_lawmgt_case;
														$client_cases=$obj_case->MJ_lawmgt_get_open_and_close_case_by_client();
														$attorney_data=array();
														$attorneydata1=array();
														if(!empty($client_cases))
														{		
															foreach($client_cases as $data)
															{
																$case_assigned=explode(',',$data->case_assgined_to);	
																if(!empty($case_assigned))
																{		
																	foreach($case_assigned as $data4)
																	{
																		$attorney_data[]=$data4;
																	}
																}
															}	
														}
														$attorney_unique=array_unique($attorney_data);
														 if(!empty($attorney_unique))
														{		
															foreach($attorney_unique as $data1)
															{
																$attorneydata1[]=get_userdata($data1);
															}	
														}  
														 
														$attorneydata=$attorneydata1;  
													}
													else
													{	
														 $args = array(
														'role' => 'attorney',
														'meta_query' =>array( 
															array(
																	'key' => 'deleted_status',
																	'value' =>0,
																	'compare' => '='
																)
															)	
														);	
														$attorneydata=get_users($args);
													}
												}
												else
												{ 
													$get_attorney = array('role' => 'attorney');
													 $args = array(
													'role' => 'attorney',
													'meta_query' =>array( 
														array(
																'key' => 'deleted_status',
																'value' =>0,
																'compare' => '='
															)
														)	
													);	
													$attorneydata=get_users($get_attorney);
													
												}	 
												
												if(!empty($attorneydata))
												{	
													foreach ($attorneydata as $retrieved_data)
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
														?></td>
														 
														<td class="name"> <?php echo esc_html($retrieved_data->display_name);?> </td>
														<td class="email"><?php echo esc_html($retrieved_data->user_email);?></td>
														<td class="mobile"><?php echo esc_html($retrieved_data->mobile);?></td>
														<td class="degree"><?php echo esc_html($retrieved_data->degree);?></td>
														<td class="experience"><?php echo esc_html($retrieved_data->experience);?></td>
														 
														<td class="rate"><?php if(!empty($retrieved_data->rate)){ echo number_format(esc_html($retrieved_data->rate) ,2); echo " /".esc_html($retrieved_data->rate_type); }  ?></td>
														<?php 
														if($user_role !== 'client' && $user_role !== 'accountant' && $user_role !== 'staff_member' )
														{ 
															?> 
															<td class="action">
															<?php 
															if($user_role == 'attorney')
															{
																if($retrieved_data->ID == $curr_user_id)
																{
																?>
																	<a href="?dashboard=user&page=attorney&tab=view_attorney&action=view&attorney_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
																	<?php 
																} 
															}
															?>
															</td> 
															<?php
														} 			
														?>  
													</tr>
													<?php
													} 			
												}?>  
											</tbody>        
										</table>
									</div>
								      
							</form>
							</div> 
							
						<?php 
						}	
						if($active_tab == 'view_attorney')
						{	
						?>	 
							<?php 
							$role='attorney';
							$obj_user=new MJ_lawmgt_Users;
							$attorney_id=0;
							$edit=0;
							if(isset($_REQUEST['attorney_id']))
								$attorney_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['attorney_id']));
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
								{					
									$edit=1;
									$user_info = get_userdata($attorney_id);				
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
												<img alt="" class="max_width_100_per_css" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
												<?php }
												else {
													?>
												<img class="image_upload max_width_100px"  src="<?php if($edit)echo esc_url( $user_info->lmgt_user_avatar ); ?>" />
												<?php 
												}
												}
												else {
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
												<i class="fa fa-graduation-cap"></i> <?php esc_html_e('Degree','lawyer_mgt'); ?>
											</div>
											<div class="col-md-8 col-sm-12 table_td">
												<span class="txt_color"><?php if($edit){ echo esc_html($user_info->degree);}?></span>
											</div>
										</div>
										<div class="table_row">
											<div class="col-md-4 col-sm-12 table_td">
												<i class="fa fa-power-off"></i> <?php esc_html_e('Experience','lawyer_mgt');?>
											</div>
											<div class="col-md-8 col-sm-12 table_td">
												<span class="txt_color"><?php if($edit){ echo esc_html($user_info->experience);}?></span>
											</div>
										</div>
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
												?>		
												</span>
											</div>
										</div>
									</div>
								</div> 		
							</div>
							<div class="row style_padding_0px_21px_css">
								<div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 close_padding">
									<div class="x_panel attorney_open_case background_color_f7f7f7">
										<div class="x_title">										   
											<h2><?php esc_html_e('Attorney Open Case History','lawyer_mgt');?></h2>
											<ul class="nav navbar-right panel_toolbox">
											  <li><a href="?dashboard=user&page=cases&tab=caselist&tab2=open&attoeny_deatil=true&attorney_id=<?php echo esc_attr($_REQUEST['attorney_id']); ?>" data-toggle="modal"  print="20" class="openserviceall"><button type="button" class="btn  btn-default btn_view_all margin_bottom_0_px_css"><?php esc_html_e('View All','lawyer_mgt');?></button></a>
											  </li>											  
											</ul>
											<div class="clearfix"></div>
										</div>
										<?php 					 
										global $wpdb;
										$attorney=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['attorney_id']));		
										$table_case = $wpdb->prefix. 'lmgt_cases';	
										$attorneydata=$wpdb->get_results("SELECT * FROM $table_case WHERE FIND_IN_SET($attorney,case_assgined_to) AND case_status='open' ORDER BY id DESC LIMIT 0 , 5");						
										if(!empty($attorneydata))
										{												
											foreach ($attorneydata as $retrieved_data)
											{				
											
												$case_id=$retrieved_data->id;
												 $table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
												$contactdata=$wpdb->get_results("SELECT * FROM $table_case_contacts WHERE case_id=$case_id");
												
												$username=array();
												
												if(!empty($contactdata))
												{							
													foreach($contactdata as $contactdata1)
													{				
														 $username[]=MJ_lawmgt_get_display_name($contactdata1->user_id);	
													}
													$contatc_name=implode(',',$username);						
												}
												 ?>
												<div class="x_content">
													<article class="media event">
														<a class="pull-left date">
															<p class="month"><?php echo date('M',strtotime(esc_html($retrieved_data->open_date)));?></p>
															<p class="day"><?php echo date('d',strtotime(esc_html($retrieved_data->open_date)));?></p>
														</a>
														<div class="media-body">
															<h5> <b><?php esc_html_e('Client Name:','lawyer_mgt');?> </b> <span class=""><?php echo esc_html($contatc_name);?></span> </h5>  
															<p><?php esc_html_e('Case Name:','lawyer_mgt');?>  <span class=""><?php echo esc_html($retrieved_data->case_name);?></span></p>
														</div>
														<a href="?dashboard=user&page=cases&tab=casedetails&action=view&close_case=true&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($case_id)); ?>"  data-target="#myModal-open-modal" print="20" class="openmodel"><i class="fa fa-eye eye" aria-hidden="true"></i></a>
													</article>
												</div>
											<?php 
											} 						
										}
										else
										{
											echo esc_html_e('No Cases Available','lawyer_mgt');
										}
										?> 
									</div>
								</div>			  
								<div class="col-lg-6 col-md-6 col-xs-12 col-sm-6 close_padding">
									<div class="x_panel attorney_close_case background_color_f7f7f7">
										<div class="x_title">								   
											<h2><?php esc_html_e('Attorney Close Case History','lawyer_mgt');?></h2>
											<ul class="nav navbar-right panel_toolbox">
												<li><a href="?dashboard=user&page=cases&tab=caselist&tab2=close&attoeny_deatil=true&attorney_id=<?php echo esc_attr($_REQUEST['attorney_id']); ?>" data-toggle="modal"  print="20" class="openserviceall"><button type="button" class="btn  btn-default btn_view_all margin_bottom_0_px_css"><?php esc_html_e('View All','lawyer_mgt');?></button></a>
												</li>									  
											</ul>
											<div class="clearfix"></div>
										</div>
										<?php 					 
										global $wpdb;
										$attorney=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['attorney_id']));		 
										$table_case = $wpdb->prefix. 'lmgt_cases';
										$attorneydata=$wpdb->get_results("SELECT * FROM $table_case WHERE FIND_IN_SET($attorney,case_assgined_to) AND case_status='close' ORDER BY id DESC LIMIT 0 , 5");
											
										if(!empty($attorneydata))
										{						
											foreach ($attorneydata as $retrieved_data)
											{											
												$case_id=$retrieved_data->id;
												$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
												$contactdata=$wpdb->get_results("SELECT * FROM $table_case_contacts WHERE case_id=$case_id");
												$username=array();
												
												if(!empty($contactdata))
												{							
													foreach($contactdata as $contactdata1)
													{				
														 $username[]=MJ_lawmgt_get_display_name($contactdata1->user_id);	
													}
													$contatc_name=implode(',',$username);						
												}
												?>
												<div class="x_content">
													<article class="media event">
														<a class="pull-left date">
															<p class="month"><?php echo date('M',strtotime(esc_html($retrieved_data->open_date)));?></p>
															<p class="day"><?php echo date('d',strtotime(esc_html($retrieved_data->open_date)));?></p>
														</a>
														<div class="media-body">
															<h5> <b><?php esc_html_e('Client Name:','lawyer_mgt');?> </b> <span class=""><?php echo esc_html($contatc_name);?></span> </h5>  
															<p><?php esc_html_e('Case Name:','lawyer_mgt');?><span class=""><?php echo esc_html($retrieved_data->case_name);?></span></p>
														</div>
														<a href="?dashboard=user&page=cases&tab=casedetails&action=view&close_case=true&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($case_id)); ?>"  data-target="#myModal-open-modal" print="20" class="openmodel"><i class="fa fa-eye eye" aria-hidden="true"></i></a>
													</article>
												</div>
											<?php
											} 						
										}
										else
										{
											echo esc_html_e('No Cases Available','lawyer_mgt');
										}
					
										?> 
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
	</div><!--  PAGE MAIN WRAPPER DIV -->
</div><!--  PAGE INNER DIV -->