<?php 
//======Front END TEMPLATE CODE START=========//
require_once(ABSPATH.'wp-admin/includes/user.php' );
if (! is_user_logged_in ()) 
{	
	$page_id = get_option ( 'lawmgt_login_page' );
	$redirect_url=esc_url(home_url () . "?page_id=" . esc_attr($page_id));
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

if (is_super_admin ())
{	
	//wp_redirect ( admin_url () . 'admin.php?page=lmgt_system' );
    $redirect_url= esc_url(admin_url () . 'admin.php?page=lmgt_system');
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
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<?php
	wp_enqueue_style( 'frontend_style-css', plugins_url( '/assets/css/frontend_style.css', __FILE__) );
	?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo esc_html(get_option( 'lmgt_system_name' ));?></title>		
	</head>
	<body class="nav-md col-lg-12 col-md-12 col-xs-12 col-sm-12">
	  <!--task-event POP up code -->
	  <div class="popup-bg">
		<div class="overlay-content content_width">
			<div class="modal-content border_top_5px_solid_22baa0">
				<div class="task_event_list">
				</div>     
			</div>
		</div>     
	  </div>
	 <!-- End task-event POP-UP Code -->
		<div class="container container-mrg-changes body"><!-- CONTAINER BODY DIV  -->			
			<div class="main_container">  <!-- MAIN CONTAINER BODY DIV  -->		
				<?php
					$user = wp_get_current_user();
					$user_id=$user->ID; 
					$userdata=get_userdata($user_id);
					$user_role=MJ_lawmgt_get_current_user_role();
					?>
				<div class="row">
				<!-- top navigation -->
			
				<div class="top_nav col-lg-12 col-md-12 col-xs-12 col-sm-12">
				  <div class="nav_menu ">
				  <div class="col-md-6 col-sm-6 col-xs-2 top">
					<a href="?dashboard=user" class="logo_img_das">
						<img class="img-circle head_logo logo_float_left" width="110" height="40" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
					</a>	
					<div class="lms_subname">
						<font><?php echo esc_html(get_option( 'lmgt_system_name' ));?></font>
					</div>
                 </div>
					<nav class="col-md-6 col-sm-6 col-xs-10 profile_height">			
					  <ul class="nav navbar-nav navbar-right navbar_right_header ">
						<li class="">
						  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">    <?php				
							if (empty ($userdata->lmgt_user_avatar))
							{
							?>
								<img alt="" class="height_29_px_width_29_px" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
							<?php
							}
							else
							{
							?>
								<img src="<?php echo esc_url( $userdata->lmgt_user_avatar ); ?>" class="height_29_px_width_29_px">				
							<?php		
							}
							echo esc_html($userdata->display_name);
							?>			
							<!-- <span class=" fa fa-angle-down"></span> -->
						  </a>
						
						  <ul class="dropdown-menu dropdown-usermenu pull-right log_edit">
							 <li><a href="?dashboard=user&page=account"><i class="fa fa-user pull-left"></i><?php esc_html_e(' My Profile','lawyer_mgt');?></a></li>
							<li class="log_edit_mt"><a href="<?php echo wp_logout_url(home_url()); ?>"><i class="fa fa-sign-out pull-left"></i><?php esc_html_e(' Log Out','lawyer_mgt');?></a></li>
						  </ul>
						</li>
					  </ul>
					</nav>
				  </div>
				</div>
				<!-- /top navigation -->
				</div>
				<div class="row template_new left_col">
					<div class="col-sm-12 nopadding apartment_left nav-side-menu">	<!--  Left Side -->
						<div class="brand">
								<?php esc_html_e('Menu','lawyer_mgt'); ?>    
								<i data-target="#menu-content" data-toggle="collapse" 
								class="fa fa-bars fa-2x toggle-btn collapsed account_image" aria-expanded="false">
								</i>
								
						</div>
								   <!--  <h3>General</h3> -->
								   <?php
									$user_role=MJ_lawmgt_get_current_user_role();
									if($user_role=='attorney')
									{
										$menu = get_option( 'lmgt_access_right_attorney');
									}
									elseif($user_role=='client')
									{
										$menu = get_option( 'lmgt_access_right_contacts');
									}
									elseif($user_role=='accountant')
									{
										$menu = get_option( 'lmgt_access_right_accountant');
									}
									elseif($user_role=='staff_member')
									{
										$menu = get_option( 'lmgt_access_right_staff');
									}
									$class = "";
									if (! isset ( $_REQUEST ['page'] ))	
									{
										$class = 'class = "active"';
									}
									?>
									<ul class="nav my_width side-menu collapse menu-sec padding_top_menu" id="menu-content">
									  <li <?php echo $class;?>><a href="?dashboard=user"><i class="icone"><img src="<?php echo esc_url(plugins_url( 'lawyers-management/assets/images/icons/dashboard.png' ))?>"/></i>
										<span class="title"><?php esc_html_e('Dashboard','lawyer_mgt');?></span></a> </li>
										<?php
											$access_page_view_array=array();
											$role = MJ_lawmgt_get_roles($user_id);
											foreach ( $menu as $role_key=>$value_array ) 
											{
												foreach($value_array as $key=>$value)
												{
													if($value['view'] == '1')
													{
														$access_page_view_array[]=$value ['page_link'];
														
														if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $value ['page_link'])
														{
															$class = 'class = "active"';
														}
														else
														{
															$class = "";
														}
														if($value ['page_link'] == 'task' || $value ['page_link'] == 'documents' || $value ['page_link'] == 'invoice' || $value ['page_link'] == 'report')
														{
															if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
															{
																$paid_plan_status=1;
															}
															else
															{
																$paid_plan_status=0;
															}
														}
														else
														{
															$paid_plan_status=1;
														}
														if($paid_plan_status == 1)
														{
															echo '<li ' . $class . '><a href="?dashboard=user&page=' . $value ['page_link'] . '" ><i class="icone"><img src="' .$value ['menu_icone'].'" /></i><span class="title">'.MJ_lawmgt_change_menutitle($key).'</span></a></li>';
														}
													}
												}											
											}
										?>	
									</ul>
					</div>	
				<!-- page content -->				
				<div class="right_col page_body_padding" role="main">
				<div>
				   <?php
					if (isset ( $_REQUEST ['page'] )) 
					{						
						if(in_array($_REQUEST ['page'],$access_page_view_array))
						{
							if(file_exists(LAWMS_PLUGIN_DIR . '/template/' . sanitize_text_field($_REQUEST ['page']) . '.php'))
							{
								require_once(LAWMS_PLUGIN_DIR . '/template/' . sanitize_text_field($_REQUEST ['page']) . '.php');			
								return false;
							} 
							else
							{
								?><h2>
								<?php
								   echo esc_html__('404 ! Page did not found.','lawyer_mgt');
								 ?>
								</h2>
								<?php
							}
						}
						else
						{
							//wp_redirect ('?dashboard=user');
							$redirect_url='?dashboard=user';
							if (!headers_sent())
							{
								header('Location: '. esc_url($redirect_url));
							}
							else 
							{
								echo '<script type="text/javascript">';
								echo 'window.location.href="'.esc_url($redirect_url).'";';
								echo '</script>';
							}
							
							
							return false;
						}
					}
					?>
				  <!-- dashboard -->
					 <?php 
						$notive_array=array();
						$user_event_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('event');
						$user_case_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('cases');
						if($user_role == 'attorney')
						{
							$event=new MJ_lawmgt_Event;

							if($user_event_access['own_data'] == '1')
							{
								$resul_event=$event->MJ_lawmgt_get_all_event_by_attorney();
							}
							else
							{								
								$resul_event=$event->MJ_lawmgt_get_all_event();
							}
							$obj_case=new MJ_lawmgt_case;
							$obj_next_hearing_date=new MJ_lawmgt_Orders;
							$current_id=get_current_user_id();
							if($user_case_access['own_data'] == '1')
							{
								$casedata=$obj_case->MJ_lawmgt_get_open_case_by_attorney($current_id);
							}
							else
							{
								$casedata=$obj_case->MJ_lawmgt_get_open_all_case();
							}						
						}
						elseif($user_role == 'client')
						{
							
							$event=new MJ_lawmgt_Event;
							if($user_event_access['own_data'] == '1')
							{
								$resul_event=$event->MJ_lawmgt_get_all_event_by_client();
							}
							else
							{								
								$resul_event=$event->MJ_lawmgt_get_all_event();
							}
							$obj_case=new MJ_lawmgt_case;
							$obj_next_hearing_date=new MJ_lawmgt_Orders;
							if($user_case_access['own_data'] == '1')
							{
								$casedata=$obj_case->MJ_lawmgt_get_open_case_by_client();
							}
							else
							{
								$casedata=$obj_case->MJ_lawmgt_get_open_all_case();
							}
						}
						else
						{
							$event=new MJ_lawmgt_Event;
							if($user_event_access['own_data'] == '1')
							{
								$resul_event=$event->MJ_lawmgt_get_all_event_by_id_created_by();
							}
							else
							{
								$resul_event=$event->MJ_lawmgt_get_all_event();
							}
							$obj_case=new MJ_lawmgt_case;
							$obj_next_hearing_date=new MJ_lawmgt_Orders;
							if($user_case_access['own_data'] == '1')
							{
								$casedata = $obj_case->MJ_lawmgt_get_open_all_case_created_by();
							}
							else
							{
								$casedata=$obj_case->MJ_lawmgt_get_open_all_case();
							}
						}		
						$page='event';
						$event=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
						if($event)
						{							
							$resul_event=$resul_event;
						}
						else
						{
							$resul_event='';
						}
						$page='cases';
						$cases=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
						if($cases)
						{							
							$casedata=$casedata;
						}
						else
						{
							$casedata='';
						}				
							if(!empty($resul_event))
							{
								foreach($resul_event as $resul)
								{
									$start_date=$resul->start_date;
									$end_date=$resul->end_date;
									$increment=1;
									$notive_array [] = array (
														 'id'=>$resul->event_id,
														 'title' => $resul->event_name,
														 'start' => date('Y-m-d',strtotime($start_date)),
														 //end date change with plus 1 day					 
														 'end' => date('Y-m-d',strtotime($end_date .' +'.$increment.' days')),
														 'start_time' => $resul->start_time,
														 'end_time' => $resul->end_time,
														 'Address'=> $resul->address,
														 'city'=> $resul->city_name,
														 'state'=> $resul->state_name,
														 'pincode'=> $resul->pin_code,
														 'color' => '#3e4797',
														 'model_name' => 'Event Details',
														 'url' => 'Event Details',
														 'start_date' => date('Y-m-d',strtotime($start_date))	
												 );									
								}
							}
							
							if(!empty($casedata))
							{
								foreach($casedata as $data)
								{
									$case_id=$data->id;
									$next_hearing_date= $obj_next_hearing_date->MJ_lawmgt_get_next_hearing_date_asc_by_case_id($case_id);
									if(!empty($next_hearing_date))
									{
										foreach($next_hearing_date as $data1)
										{
											$notive_array [] = array (
													 'id'=>$data->id,
													 'title' => $data->case_name.'-'.$data->case_name,
													 'case_name' => $data->case_name,
													 'case_number' => $data->case_name,
													 'court_id' => get_the_title($data->court_id),
													 'start' =>  $data1->next_hearing_date,
													 'end' => $data1->next_hearing_date,
													 'color' => '#50e6d2',
													 'model_name' => 'Case Details',
                                                      'url' => 'Case Details',													 
													 'start_date' => $data1->next_hearing_date				 
											 );	
										}
									}
								}
							}
						?>
						  <script>
							var $ = jQuery.noConflict();
							document.addEventListener('DOMContentLoaded', function() {
							var calendarEl = document.getElementById('calendar1');
							var calendar = new FullCalendar.Calendar(calendarEl, {
								   height:660,
								   eventLimit: true, // allow "more" link when too many events		
								   headerToolbar: {
								left: 'prev,next today',
								center: 'title',
								right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
							  },
							  events: <?php echo json_encode($notive_array); ?>,  // request to load current events
							  <?php
								if(!empty($notive_array)) 
								{
								?>			
									events: <?php echo json_encode($notive_array); ?> , // request to load current events
									eventClick: function (calEvent)
									{			   
									  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
									  var docHeight = $(document).height(); //grab the height of the page
									  var scrollTop = $(window).scrollTop();
									 // var id  = calEvent.id;
									 // var model  = calEvent.model_name;	
									  //var start_date  = calEvent.start_date;
                                      var id  = calEvent.event.id
			                          var model  = calEvent.event.url									  
										var curr_data = {
															action: 'MJ_lawmgt_show_event_task',
															id : id,
															model : model,
															//start_date : start_date,
															dataType: 'json'
														};	
																		
										$.post(lmgt.ajax, curr_data, function(response) 
										{ 	
										 
											$('.popup-bg').show().css({'height' : docHeight});
											$('.task_event_list').html(response);	
																
											return true; 					
										});	
									}
								<?php 
								}
								?>
							});
							calendar.render();
						  });
						</script>
						 
						 <div class="container body">					
							<!-- top row -->
							<div class="row header_card_height dis_block_res">
								<?php  
								$page='attorney';
								$attorney=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
								if($attorney)
								{								
									?>
									<div class="col-lg-3 col-md-3 col-xs-12 col-sm-3">
									<a href="<?php echo esc_url(home_url().'?dashboard=user&page=attorney');?>">
										<div class="panel info-box panel-white">
											<div class="panel-body attorney">
												<div class="info-box-stats">
													<p class="counter"><?php 
														$user_attorney_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('attorney');
														if($user_role == 'attorney')
														{	
															if($user_attorney_access['own_data'] == '1')
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
															if($user_attorney_access['own_data'] == '1')
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
																												
														echo esc_html(count($attorneydata));
														?>
														</p>
													<span class="info-box-title"><?php echo esc_html( __( 'Attorney', 'lawyer_mgt' ) );?></span>
												</div>
												<img src="<?php echo LAWMS_PLUGIN_URL."/assets/images/dashboard/attorney.png"?>" class="dashboard_background">
											</div>
										</div>
									</a>
									</div>
							<?php  }  
							  
								$page='staff';
								$staff=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
								if($staff)
								{
								?>
									<div class="col-lg-3 col-md-3 col-xs-12 col-sm-3 ">
									<a href="<?php echo esc_url(home_url().'?dashboard=user&page=staff');?>">
										<div class="panel info-box panel-white">
											<div class="panel-body staff_member">
												<div class="info-box-stats">
													<p class="counter"><?php 
														$user_staff_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('staff');
														if($user_role == 'staff_member')
														{
															if($user_staff_access['own_data'] == '1')
															{
																$user_id = get_current_user_id();
																$staffdata=array();
																$staffdata[]=get_userdata($user_id);
															}
															else			
															{
																 $get_staff = array(
																'role' => 'staff_member',
																'meta_query' =>array( 
																	array(
																			'key' => 'deleted_status',
																			'value' =>0,
																			'compare' => '='
																		)
																	)	
																);	 
																$staffdata=get_users($get_staff);
															}		
														}
														else			
														{
															 $get_staff = array(
															'role' => 'staff_member',
															'meta_query' =>array( 
																array(
																		'key' => 'deleted_status',
																		'value' =>0,
																		'compare' => '='
																	)
																)	
															);	 
															$staffdata=get_users($get_staff);
														}
														echo esc_html(count($staffdata));
														?>
														</p>
													<span class="info-box-title"><?php echo esc_html( __( 'Staff', 'lawyer_mgt' ) );?></span>
												</div>
												<img src="<?php echo esc_url(LAWMS_PLUGIN_URL."/assets/images/dashboard/staff.png")?>" class="dashboard_background">
												
											</div>
										</div>
										</a>
									</div>
								<?php  }  
							  
								$page='accountant';
								$accountant=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
								if($accountant)
								{
								?>
									<div class="col-lg-3 col-md-3 col-xs-12 col-sm-3">
									<a href="<?php echo esc_url(home_url().'?dashboard=user&page=accountant');?>">
										<div class="panel info-box panel-white">
											<div class="panel-body accountant">
												<div class="info-box-stats">
													<p class="counter"><?php 
														$user_accountant_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('accountant');
														if($user_role == 'accountant')
														{
															if($user_accountant_access['own_data'] == '1')
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
														echo esc_html(count($accountantdata));
														?>
														</p>
													<span class="info-box-title"><?php echo esc_html( __( 'Accountant', 'lawyer_mgt' ) );?></span>
												</div>
												<img src="<?php echo esc_url(LAWMS_PLUGIN_URL."/assets/images/dashboard/accountant.png")?>" class="dashboard_background">
												
											</div>
										</div>
										</a>
									</div>
							<?php  } 
								
								$page='contacts';
								$contacts=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
								if($contacts)
								{
								?>
									<div class="col-lg-3 col-md-3 col-xs-12 col-sm-3">
									<a href="<?php echo esc_url(home_url().'?dashboard=user&page=contacts');?>">
										<div class="panel info-box panel-white">
											<div class="panel-body client">
												<div class="info-box-stats">
													<p class="counter">
													<?php
													$contactdata_2='';
													$user_contact_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('contacts');
													if($user_role == 'attorney')
													{
															if($user_contact_access['own_data'] == '1')
															{
																$obj_case=new MJ_lawmgt_case;
																$current_user_id = get_current_user_id();
																$attorney_cases=$obj_case->MJ_lawmgt_get_all_case_by_attorney_id($current_user_id);
																$client_data=array();
																$attorneydata1=array();
																if(!empty($attorney_cases))
																{		
																	foreach($attorney_cases as $data)
																	{
																		$case_contact_assigned=explode(',',$data->user_id);	
																		if(!empty($case_contact_assigned))
																		{		
																			foreach($case_contact_assigned as $data1)
																			{
																				$client_data[]=$data1;
																			}
																		}
																	}	
																}
																$contactdata1=array();
																$client_unique=array_unique($client_data);
																if(!empty($client_unique))
																{		
																	foreach($client_unique as $data1)
																	{
																		$contactdata1[]=get_userdata($data1);
																	}	
																}  
																 
																$contactdata_2=$contactdata1; 

																$contactdata_3 = get_users(
																	array(
																		'role' => 'client',
																		'meta_query' => array(		
																		array(
																				'key' => 'created_by',
																				'value' =>get_current_user_id(),
																				'compare' => '='
																			),
																		)
																	));	
																	$contactdata =array_merge($contactdata_2,$contactdata_3);
																	
															}
															else			
															{	
																$contactdata =get_users(array('role'=>'client'));	
															}																
															 	
													}
													elseif($user_role == 'client')
													{
														if($user_contact_access['own_data'] == '1')
														{	
															$user_id = get_current_user_id();
															$contactdata=array();
															$contactdata[]=get_userdata($user_id);	
														}
														else			
														{	
															$contactdata =get_users(array('role'=>'client'));
														}																
													}
													else
													{	
														if($user_contact_access['own_data'] == '1')
														{
															$contactdata = get_users(
																array(
																	'role' => 'client',
																	'meta_query' => array(		
																	array(
																			'key' => 'created_by',
																			'value' =>get_current_user_id(),
																			'compare' => '='
																		),
																	)
																));	
														}
														else			
														{
															
															$contactdata =get_users(array('role'=>'client'));
														}																
													}
														 
													echo esc_html(count($contactdata));
													?>
													</p>
													
													<span class="info-box-title"><?php echo esc_html( __( 'Clients', 'lawyer_mgt' ) );?></span>
												</div>
												<img src="<?php echo esc_url(LAWMS_PLUGIN_URL."/assets/images/dashboard/contact.png")?>" class="dashboard_background">
												
											</div>
										</div>
										</a>
									</div>	
							<?php  } 
								
								$page='cases';
								$cases=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
								if($cases)
								{
								?>
									<div class="col-lg-3 col-md-3 col-xs-12 col-sm-3 save_client_btn">
									<a href="<?php echo esc_url(home_url().'?dashboard=user&page=cases');?>">
										<div class="panel info-box panel-white">
											<div class="panel-body case">
												<div class="info-box-stats">
												 <?php
												 $user_cases_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('cases');
												 $obj_case=new MJ_lawmgt_case;
												if($user_role == 'attorney')
												{
													if($user_cases_access['own_data'] == '1')
													{
														$user_id = get_current_user_id();
														$casedata=$obj_case->MJ_lawmgt_get_all_case_by_attorney_id($user_id);	
													}
													else
													{
														$casedata=$obj_case->MJ_lawmgt_get_all_case();
													}													
												}
												elseif($user_role == 'client')
												{
													if($user_cases_access['own_data'] == '1')
													{
														$casedata=$obj_case->MJ_lawmgt_get_open_and_close_case_by_client();	
													}
													else
													{
														$casedata=$obj_case->MJ_lawmgt_get_all_case();
													}	
												}							   
												else
												{														
													if($user_cases_access['own_data'] == '1')
													{
														$casedata=$obj_case->MJ_lawmgt_get_all_case_created_by();
													}
													else
													{
														$casedata=$obj_case->MJ_lawmgt_get_all_case();
													}
												}
												?>
													<p class="counter"><?php echo esc_html(count($casedata)); ?></p>
													
													<span class="info-box-title"><?php echo esc_html( __( 'Cases', 'lawyer_mgt' ) );?></span>
												</div>
												<img src="<?php echo esc_url(LAWMS_PLUGIN_URL."/assets/images/dashboard/case.png")?>" class="dashboard_background">
											</div>
										</div>
									</a>
									</div>
							<?php  } 
								
								$page='invoice';
								$invoice=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
								if($invoice)
								{
									if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
									{
								?>
									<div class="col-lg-3 col-md-3 col-xs-12 col-sm-3">
									<a href="<?php echo esc_url(home_url().'?dashboard=user&page=invoice');?>">
										<div class="panel info-box panel-white">
											<div class="panel-body invoice">
												<div class="info-box-stats">
												 <?php
												 $user_invoice_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('invoice');
												 $obj_invoice=new MJ_lawmgt_invoice;
												if($user_role == 'attorney')
												{
													if($user_invoice_access['own_data'] == '1')
													{
														$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice_by_attorney();
													}
													else
													{
														$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice();
													}	
												}
												elseif($user_role == 'client')
												{
													if($user_invoice_access['own_data'] == '1')
													{
														$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice_by_client();
													}
													else
													{
														$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice();
													}	
												}
												else
												{
													if($user_invoice_access['own_data'] == '1')
													{
														$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice_created_by();
													}
													else
													{
														$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice();
													}
												}
													
												?>
													<p class="counter">
													<?php if(!empty($invoicedata))
													{
														echo esc_html(count($invoicedata));
													}
													else
													{
														echo "0";
													}

												?> </p>
													<span class="info-box-title"><?php echo esc_html( __( 'Invoices', 'lawyer_mgt' ) );?></span>
												</div>
												<img src="<?php echo esc_url(LAWMS_PLUGIN_URL."/assets/images/dashboard/invoice.png")?>" class="dashboard_background">
												
											</div>
										</div>
										</a>
									</div>
							<?php  } 
								}
								
								$page='task';
								$task=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
								if($task)
								{
									if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
									{
								?>
									<div class="col-lg-3 col-md-3 col-xs-12 col-sm-3">
									<a href="<?php echo esc_url(home_url().'?dashboard=user&page=task');?>">
										<div class="panel info-box panel-white">
											<div class="panel-body task">
												<div class="info-box-stats">
													<?php 
													$user_task_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('task');
													$obj_case=new MJ_lawmgt_case;
													$obj_case_tast= new MJ_lawmgt_case_tast;
													if($user_role == 'attorney')
													{
														if($user_task_access['own_data'] == '1')
														{
															$casedata=$obj_case_tast->MJ_lawmgt_get_all_case_tast_by_attorney();
														}
														else
														{
															$casedata=$obj_case_tast->MJ_lawmgt_get_all_case_tast();	
														}		
													}
													elseif($user_role == 'client')
													{
														if($user_task_access['own_data'] == '1')
														{
															$casedata=$obj_case_tast->MJ_lawmgt_get_all_case_tast_by_client();	
														}
														else
														{
															$casedata=$obj_case_tast->MJ_lawmgt_get_all_case_tast();	
														}
													}
													else
													{
														if($user_task_access['own_data'] == '1')
														{
															$casedata=$obj_case_tast->MJ_lawmgt_get_all_case_tast_created_by();
														}
														else
														{
															$casedata=$obj_case_tast->MJ_lawmgt_get_all_case_tast();	
														}
													}	
													?>
													<p class="counter"> 
													<?php 
													if(!empty($casedata))
													{
														echo esc_html(count($casedata));
													}
													else
													{
														echo "0";
													}

												?> </p>
													<span class="info-box-title"><?php echo esc_html( __( 'Tasks', 'lawyer_mgt' ) );?></span>
													 
												</div>
												<img src="<?php echo esc_url(LAWMS_PLUGIN_URL."/assets/images/dashboard/task_1.png")?>" class="dashboard_background">												
											</div>
										</div>
										</a>
									</div>
							<?php  } 
								}
							?>
							</div>
						   <!-- /top row -->	
						   <!-- calendar modal -->
							<div id="CalenderModalNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							  <div class="modal-dialog">
								<div class="modal-content">

								  <div class="modal-header model_border_bottom">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title" id="myModalLabel"><?php esc_html_e('New Calendar Entry','lawyer_mgt');?></h4>
								  </div>
								  <div class="modal-body">
									<div id="testmodal" class="padding_5px_20px_css">
									  <form id="antoform" class="form-horizontal calender" role="form">
										<div class="form-group">
										  <label class="col-sm-3 control-label"><?php esc_html_e('Title','lawyer_mgt');?></label>
										  <div class="col-sm-9">
											<input type="text" class="form-control" id="title" name="title">
										  </div>
										</div>
										<div class="form-group">
										  <label class="col-sm-3 control-label"><?php esc_html_e('Description','lawyer_mgt');?></label>
										  <div class="col-sm-9">
											<textarea class="form-control height_55px_css" id="descr" name="descr"></textarea>
										  </div>
										</div>
									  </form>
									</div>
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-default antoclose" data-dismiss="modal"><?php esc_html_e('Close','lawyer_mgt');?></button>
									<button type="button" class="btn btn-primary antosubmit"><?php esc_html_e('Save changes','lawyer_mgt');?></button>
								  </div>
								</div>
							  </div>
							</div>
							<div id="CalenderModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							  <div class="modal-dialog">
								<div class="modal-content">

								  <div class="modal-header ">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title" id="myModalLabel2"><?php esc_html_e('Edit Calendar Entry','lawyer_mgt');?></h4>
								  </div>
								  <div class="modal-body">

									<div id="testmodal2" class="padding_5px_20px_css">
									  <form id="antoform2" class="form-horizontal calender" role="form">
										<div class="form-group">
										  <label class="col-sm-3 control-label"><?php esc_html_e('Title','lawyer_mgt');?></label>
										  <div class="col-sm-9">
											<input type="text" class="form-control" id="title2" name="title2">
										  </div>
										</div>
										<div class="form-group">
										  <label class="col-sm-3 control-label"><?php esc_html_e('Description','lawyer_mgt');?></label>
										  <div class="col-sm-9">
											<textarea class="form-control height_55px_css" id="descr2" name="descr"></textarea>
										  </div>
										</div>

									  </form>
									</div>
								  </div>
								  <div class="modal-footer model_border_top">
									<button type="button" class="btn btn-default antoclose2" data-dismiss="modal"><?php esc_html_e('Close','lawyer_mgt');?></button>
									<button type="button" class="btn btn-primary antosubmit2"><?php esc_html_e('Save changes','lawyer_mgt');?></button>
								  </div>
								</div>
							  </div>
							</div>

							<div id="fc_create" data-toggle="modal" data-target="#CalenderModalNew"></div>
							<div id="fc_edit" data-toggle="modal" data-target="#CalenderModalEdit"></div>
							<!-- /calendar modal -->
								<div class="row">
								<?php
								$page='cases';
								$cases=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
								if($cases)
								{
								 ?>
									<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 padding_css">						
										<div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
										<div class="x_panel attorney_open_case">
											<div class="x_title">				   
												<h2><?php esc_html_e('Attorney Open Case History','lawyer_mgt');?></h2>
												<ul class="nav navbar-right panel_toolbox ">
												  <li><a href="?dashboard=user&page=cases&tab=caselist&tab2=open"   print="20" class="openserviceall View_all"><button type="button" class="btn  btn-default btn_view_all"><?php esc_html_e('View All','lawyer_mgt');?></button></a>
												  </li>                      
												</ul>
												<div class="clearfix"></div>
											</div>
											   <?php 
												$user_cases_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('cases');											   
												if($user_role == 'attorney')
												{ 
													global $wpdb;
													$table_case = $wpdb->prefix. 'lmgt_cases';	
													$attorney_id=get_current_user_id();	
													if($user_cases_access['own_data'] == '1')
													{
														$attorneydata=$wpdb->get_results("SELECT * FROM $table_case WHERE  (case_status='open') AND (FIND_IN_SET($attorney_id,case_assgined_to) OR created_by=$attorney_id) ORDER BY id DESC LIMIT 0 , 5");
													
													}
													else
													{
														$attorneydata=$wpdb->get_results("SELECT * FROM $table_case WHERE  case_status='open' ORDER BY id DESC LIMIT 0 , 5");
													}
												}
												elseif($user_role == 'client')
												{ 
													global $wpdb;
													$table_case = $wpdb->prefix. 'lmgt_cases';	
													$obj_case= new MJ_lawmgt_case;
													$attorney_id=get_current_user_id();	
													$case_data=$obj_case->MJ_lawmgt_get_open_case_by_client();
													$case_id=array();
													if(!empty($case_data))
													{		
														foreach($case_data as $data)
														{
															$case_id[]=$data->id;
														}	
													}
													if($user_cases_access['own_data'] == '1')
													{
														if(!empty($case_id))
														{	
															$attorneydata=$wpdb->get_results("SELECT * FROM $table_case WHERE  (case_status='open') AND  (id IN (".implode(',', $case_id).") OR created_by=$attorney_id) ORDER BY id DESC LIMIT 0 , 5");
														}
														else
														{
															$attorneydata='';
														}	
													}
													else
													{
														$attorneydata=$wpdb->get_results("SELECT * FROM $table_case WHERE  case_status='open' ORDER BY id DESC LIMIT 0 , 5");
													}														
												}
												else
												{
													if($user_cases_access['own_data'] == '1')
													{
														global $wpdb;
														$table_case = $wpdb->prefix. 'lmgt_cases';	 
														$attorneydata=$wpdb->get_results("SELECT * FROM $table_case WHERE  case_status='open' AND created_by=$attorney_id ORDER BY id DESC LIMIT 0 , 5");
													}
													else
													{
														global $wpdb;
														$table_case = $wpdb->prefix. 'lmgt_cases';	 
														$attorney_id=get_current_user_id();	
														$attorneydata=$wpdb->get_results("SELECT * FROM $table_case WHERE  case_status='open' ORDER BY id DESC LIMIT 0 , 5");
													}
												}
												
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
															if(!empty($username))
															{
																$contatc_name=implode(',',$username);		
															}	
															else
															{
																$contatc_name='';
															}																
														}
													 ?>
												 
											 <div class="x_content">
											  <article class="media event">
												  <a class="pull-left date">
													<p class="month"><?php echo date('M',strtotime($retrieved_data->open_date));?></p>
													<p class="day"><?php echo date('d',strtotime($retrieved_data->open_date));?></p>
												  </a>
												  <div class="media-body">
													 <h5> <b><?php esc_html_e('Client Name:','lawyer_mgt');?> </b> <?php echo esc_html($contatc_name);?> </h5>  
													 <p><b><?php esc_html_e(' Case Name:','lawyer_mgt');?></b> <?php echo esc_html($retrieved_data->case_name);?></p>
												  </div>
												  <a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($case_id)); ?>"  data-target="#myModal-open-modal" print="20" class="openmodel"><i class="fa fa-eye eye" aria-hidden="true"></i></a>
												</article>
												</div>
												<?php } 
												}
												else
												{
													echo esc_html_e('No Cases Available','lawyer_mgt');
												}
												?> 
												</div>
										</div>	  
											<div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
											<div class="x_panel attorney_close_case">
											  <div class="x_title">				   
												<h2><?php esc_html_e('Attorney Close Case History','lawyer_mgt');?></h2>
												<ul class="nav navbar-right panel_toolbox">
												  <li><a href="?dashboard=user&page=cases&tab=caselist&tab2=close"   print="20" class="openserviceall View_all"><button type="button" class="btn  btn-default btn_view_all"><?php esc_html_e('View All','lawyer_mgt');?></button></a>
												  </li>                      
												</ul>
												<div class="clearfix"></div>
											  </div>
											  <?php 
												$attorney_id=get_current_user_id();	
												if($user_role == 'attorney')
												{ 
													if($user_cases_access['own_data'] == '1')
													{
														global $wpdb;
														$table_case = $wpdb->prefix. 'lmgt_cases';	
														
														$attorneydata=$wpdb->get_results("SELECT * FROM $table_case WHERE  (case_status='close') AND (FIND_IN_SET($attorney_id,case_assgined_to) OR created_by=$attorney_id) ORDER BY id DESC LIMIT 0 , 5");
													}
													else
													{
														global $wpdb;
														$table_case = $wpdb->prefix. 'lmgt_cases';	 		 
														$attorneydata=$wpdb->get_results("SELECT * FROM $table_case WHERE  case_status='close' ORDER BY id DESC LIMIT 0 , 5");
													}
												}
												elseif($user_role == 'client')
												{ 
													global $wpdb;
													$table_case = $wpdb->prefix. 'lmgt_cases';	
													$obj_case= new MJ_lawmgt_case;
													$case_data=$obj_case->MJ_lawmgt_get_close_case_by_client();

													$case_id=array();
													if(!empty($case_data))
													{		
														foreach($case_data as $data)
														{
															$case_id[]=$data->id;
														}	
													}
													if($user_cases_access['own_data'] == '1')
													{
														if(!empty($case_id))
														{		
															$attorneydata=$wpdb->get_results("SELECT * FROM $table_case WHERE  (case_status='close') AND (id IN(".implode(',',$case_id).") OR created_by=$attorney_id) ORDER BY id DESC LIMIT 0 , 5");
														}
														else
														{
															$attorneydata='';	
														}	
													}
													else
													{
														global $wpdb;
														$table_case = $wpdb->prefix. 'lmgt_cases';	 		 
														$attorneydata=$wpdb->get_results("SELECT * FROM $table_case WHERE  case_status='close' ORDER BY id DESC LIMIT 0 , 5");
													}													
												}
												else
												{
													if($user_cases_access['own_data'] == '1')
													{
														global $wpdb;
														$table_case = $wpdb->prefix. 'lmgt_cases';	 		 
														$attorneydata=$wpdb->get_results("SELECT * FROM $table_case WHERE  case_status='close' AND created_by=$attorney_id ORDER BY id DESC LIMIT 0 , 5");
													}
													else
													{
														global $wpdb;
														$table_case = $wpdb->prefix. 'lmgt_cases';	 		 
														$attorneydata=$wpdb->get_results("SELECT * FROM $table_case WHERE  case_status='close' ORDER BY id DESC LIMIT 0 , 5");
													}
												}		
												if(!empty($attorneydata))
												 {
													
													foreach ($attorneydata as $retrieved_data){
													
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
														if(!empty($username))
														{	
															$contatc_name=implode(',',$username);		
														}
														else
														{
															$contatc_name='';
														}													
													}
												 ?>
											<div class="x_content">
											<article class="media event">
												  <a class="pull-left date">
													<p class="month"><?php echo date('M',strtotime($retrieved_data->open_date));?></p>
													<p class="day"><?php echo date('d',strtotime($retrieved_data->open_date));?></p>
												  </a>
												  <div class="media-body">
													 <h5> <b><?php esc_html_e('Client Name:','lawyer_mgt');?> </b> <?php echo esc_html($contatc_name);?> </h5>  
													 <p><b><?php esc_html_e('Case Name:','lawyer_mgt');?></b> <?php echo esc_html($retrieved_data->case_name);?></p>
												  </div>
												  <a href="?dashboard=user&page=cases&tab=casedetails&action=view&close_case=true&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($case_id)); ?>"  data-target="#myModal-open-modal" print="20" class="openmodel"><i class="fa fa-eye eye" aria-hidden="true"></i></a>
												</article>
												</div>
												<?php } 						
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
									<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
									  <div class="x_panel recent_activity">
										<div class="x_title">
										  <h2><?php esc_html_e('Recent Activities','lawyer_mgt');?></h2>
										  <ul class="nav navbar-right panel_toolbox">
											<li><a class="collapse-link"></a>
											</li>                   
										  </ul>
										  <div class="clearfix"></div>
										</div>
										<div class="x_content">
											<table id="examlist" class="table table-striped" cellspacing="0" width="100%" align="center">
												<tbody>
													<?php 				
													global $wpdb;
													$table_user_activity = $wpdb->prefix. 'lmgt_user_activity';	
													$user_id = get_current_user_id();
													$result = $wpdb->get_results("SELECT * FROM $table_user_activity where user_id=$user_id ORDER BY id DESC LIMIT 0 ,5");
													if(!empty($result)) 
													{
														 foreach ($result as $data)
														{		
																$activity=$data->activity;	
																
															?>
															<tr>
																<td><?php echo str_replace("?","?dashboard=user&",$activity);?></td>						
															</tr>
															<?php	
														}	
													}
													else
													{	
														esc_html_e("No Recent Activity",'lawyer_mgt');
													}
													?>
												</tbody>
											</table>
										</div>
									  </div>
									</div>		
								</div>	
								<div class="row">
								<?php
								$page='event';
								$event=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
								if($event)
								{
								 ?>
									<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<div class="x_panel upcoming_events">
											<div class="x_title">
											  <h2><?php esc_html_e('Events','lawyer_mgt');?></h2>
											  <ul class="nav navbar-right panel_toolbox">
												<li class="margin_dasboard"><a href="<?php echo home_url().'?dashboard=user&page=event';?>"><i class="fa fa-external-link" aria-hidden="true"></i></a>
												</li>                    
											  </ul>
											  <div class="clearfix"></div>
											</div>
											<div class="x_content">
													<?php
													$user_event_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('event');
													if($user_role == 'attorney')
													{
														$event=new MJ_lawmgt_Event;
														if($user_event_access['own_data'] == '1')
														{
															$event_by_current_month=$event->MJ_lawmgt_get_attorney_all_event_by_current_month();
														}
														else
														{
															$event_by_current_month=$event->MJ_lawmgt_get_all_event_by_current_month();
														}
													}
													elseif($user_role == 'client')
													{
														$event=new MJ_lawmgt_Event;
														if($user_event_access['own_data'] == '1')
														{
															$event_by_current_month=$event->MJ_lawmgt_get_contact_all_event_by_current_month();
														}
														else
														{
															$event_by_current_month=$event->MJ_lawmgt_get_all_event_by_current_month();
														}
													}
													else
													{
														$event=new MJ_lawmgt_Event;
														if($user_event_access['own_data'] == '1')
														{
															$event_by_current_month=$event->MJ_lawmgt_get_all_event_by_current_month_created_by();
														}
														else
														{
															$event_by_current_month=$event->MJ_lawmgt_get_all_event_by_current_month();
														}
													}
																		
													if(!empty($event_by_current_month)) 
													{
														foreach($event_by_current_month as $eventdata)
														{
														?>			
															<div class="activity_details">
																<p class="event_title Bold viewdetail show_task_event" id="<?php echo $eventdata->event_id;?>" model="Event Details" ><?php echo esc_html($eventdata->event_name);?></p>
													
																<p class="event_date"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($eventdata->start_date));?> | <?php echo esc_html(MJ_lawmgt_getdate_in_input_box($eventdata->end_date));?></p>										
															</div>
														<?php
														}	
													} 
													else 															
														esc_html_e("No Upcoming Event",'lawyer_mgt');
													?>						
											</div>
										</div>
									</div>
							<?php  }
								$user_orders_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('orders');
								$page='orders';
								$orders=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
								if($orders)
								{
								?>
									<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<div class="x_panel upcoming_orders">
											<div class="x_title">
											  <h2><?php esc_html_e('Orders','lawyer_mgt');?></h2>
											  <ul class="nav navbar-right panel_toolbox">
												<li class="margin_dasboard"><a href="<?php echo home_url().'?dashboard=user&page=orders';?>"><i class="fa fa-external-link" aria-hidden="true"></i></a>
												</li>                  
											  </ul>
											  <div class="clearfix"></div>
											</div>
											<div class="x_content">
													<?php
													$obj_orders= new MJ_lawmgt_Orders;
												
													if($user_role == 'attorney')
													{
														if($user_orders_access['own_data'] == '1')
														{
															$orders_by_current_month=$obj_orders->MJ_lawmgt_get_attorney_all_orders_dashboard();
														}
														else
														{
															$orders_by_current_month=$obj_orders->MJ_lawmgt_get_all_orders_dashboard();
														}
													}
													elseif($user_role == 'client')
													{
														if($user_orders_access['own_data'] == '1')
														{
															$orders_by_current_month=$obj_orders->MJ_lawmgt_get_contact_all_orders_dashboard();
														}
														else
														{
															$orders_by_current_month=$obj_orders->MJ_lawmgt_get_all_orders_dashboard();
														}
													}
													else
													{
														if($user_orders_access['own_data'] == '1')
														{
															$orders_by_current_month=$obj_orders->MJ_lawmgt_get_all_orders_dashboard_created_by();
														}
														else
														{
															$orders_by_current_month=$obj_orders->MJ_lawmgt_get_all_orders_dashboard();
														}
													}
																			
													if(!empty($orders_by_current_month)) 
													{
														foreach($orders_by_current_month as $ordersdata)
														{
														?>			
															<div class="activity_details">
																<p class="task_title Bold viewdetail show_task_event" id="<?php echo $ordersdata->id;?>" model="Orders Details"><?php echo esc_html(MJ_lawmgt_get_case_name(esc_html($ordersdata->case_id)));?></p>
													
																<p class="orders_date"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($ordersdata->date));?></p>										
															</div>
														<?php
														}	
													} 
													else 	
														esc_html_e("No Upcoming Orders",'lawyer_mgt');
														
													?>						
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
									<div class="x_panel upcoming_next_hearing_date">
										<div class="x_title">
										  <h2><?php esc_html_e("Next Hearing date",'lawyer_mgt');?></h2>
										  <ul class="nav navbar-right panel_toolbox">
											<li class="margin_dasboard"><a href="<?php echo home_url().'?dashboard=user&page=orders';?>"><i class="fa fa-external-link" aria-hidden="true"></i></a>
											</li>                  
										  </ul>
										  <div class="clearfix"></div>
										</div>
										<div class="x_content">
												<?php 
													$obj_orders= new MJ_lawmgt_Orders;
													if($user_role == 'attorney')
													{
														if($user_orders_access['own_data'] == '1')
														{
															$orders_by_current_month=$obj_orders->MJ_lawmgt_get_attorney_all_next_hearing_date_dashboard();
														}
														else
														{
															$orders_by_current_month=$obj_orders->MJ_lawmgt_get_next_hearing_date_dashboard();
														}
													}
													elseif($user_role == 'client')
													{
														if($user_orders_access['own_data'] == '1')
														{
															$orders_by_current_month=$obj_orders->MJ_lawmgt_get_contact_all_next_hearing_date_dashboard();
														}
														else
														{
															$orders_by_current_month=$obj_orders->MJ_lawmgt_get_next_hearing_date_dashboard();
														}
													}
													else
													{
														if($user_orders_access['own_data'] == '1')
														{
															$orders_by_current_month=$obj_orders->MJ_lawmgt_get_next_hearing_date_dashboard_created_by();
														}
														else
														{
															$orders_by_current_month=$obj_orders->MJ_lawmgt_get_next_hearing_date_dashboard();
														}
													}
												 
												if(!empty($orders_by_current_month)) 
												{
													foreach($orders_by_current_month as $ordersdata)
													{
													?>			
														<div class="activity_details">
															<p class="next_hearing_date_title Bold viewdetail show_task_event" id="<?php echo $ordersdata->id;?>" model="Next Hearing Date Details"><?php echo esc_html(MJ_lawmgt_get_case_name(esc_html($ordersdata->case_id)));?></p>
												
															<p class="next_hearing_date_date"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($ordersdata->next_hearing_date));?></p>										
														</div>
													<?php
													}	
												} 
												else 	
													esc_html_e("No Upcoming Next Hearing Date",'lawyer_mgt');
													
												?>						
										</div>
									</div>
									</div>
									<?php  }
								$page='note';
								$note=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
								if($note)
								{
								?>
									<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<div class="x_panel upcoming_note">
											<div class="x_title">
											  <h2><?php esc_html_e('Notes','lawyer_mgt');?></h2>
											  <ul class="nav navbar-right panel_toolbox">
												<li class="margin_dasboard"><a href="<?php echo home_url().'?dashboard=user&page=note';?>"><i class="fa fa-external-link" aria-hidden="true"></i></a>
												</li>                 
											  </ul>
											  <div class="clearfix"></div>
											</div>
											<div class="x_content">
													<?php 
													$obj_note= new MJ_lawmgt_Note;
													
													$user_note_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('note');
													if($user_role == 'attorney')
													{	
														if($user_note_access['own_data'] == '1')
														{															
															$note_data=$obj_note->MJ_lawmgt_get_attorney_all_note_dashboard();
														}
														else
														{
															$note_data=$obj_note->MJ_lawmgt_get_all_note_dashboard();
														}
													}
													elseif($user_role == 'client')
													{
														if($user_note_access['own_data'] == '1')
														{	
															$note_data=$obj_note->MJ_lawmgt_get_contact_all_note_dashboard();
														}
														else
														{
															$note_data=$obj_note->MJ_lawmgt_get_all_note_dashboard();
														}
													}
													else
													{
														if($user_note_access['own_data'] == '1')
														{	
															$note_data=$obj_note->MJ_lawmgt_get_all_note_dashboard_created_by();
														}
														else
														{															
															$note_data=$obj_note->MJ_lawmgt_get_all_note_dashboard();
														}
													}
																	
													if(!empty($note_data)) 
													{
														foreach($note_data as $notedata)
														{
														?>			
															<div class="activity_details">
																<p class="note_title Bold viewdetail show_task_event" id="<?php echo $notedata->note_id;?>" model="Note Details"><?php echo MJ_lawmgt_get_case_name(esc_html($notedata->case_id));?></p>
													
																<p class="note_date"><?php echo MJ_lawmgt_getdate_in_input_box($notedata->date_time);?></p>										
															</div>
														<?php
														}	
													} 
													else 	
														esc_html_e("No Upcoming Note",'lawyer_mgt');
														
													?>						
											</div>
										</div>
									</div>
							<?php  }
								 
								$page='judgments';
								$judgments=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
								if($judgments)
								{
								?>
									<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<div class="x_panel upcoming_judgments">
											<div class="x_title">
											  <h2><?php esc_html_e('Judgments','lawyer_mgt');?></h2>
											  <ul class="nav navbar-right panel_toolbox">
												<li class="margin_dasboard"><a href="<?php echo home_url().'?dashboard=user&page=judgments';?>"><i class="fa fa-external-link" aria-hidden="true"></i></a>
												</li>                  
											  </ul>
											  <div class="clearfix"></div>
											</div>
											<div class="x_content">
													<?php 
													$user_judgments_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('judgments');
													$obj_judgments= new MJ_lawmgt_Judgments;
													if($user_role == 'attorney')
													{					
														if($user_judgments_access['own_data'] == '1')
														{															
															$judgments_by_current_month=$obj_judgments->MJ_lawmgt_get_attorney_all_judgments_dashboard();
														}
														else
														{
															$judgments_by_current_month=$obj_judgments->MJ_lawmgt_get_all_judgments_dashboard();
														}
													}
													elseif($user_role == 'client')
													{
														if($user_judgments_access['own_data'] == '1')
														{
															$judgments_by_current_month=$obj_judgments->MJ_lawmgt_get_contact_all_judgments_dashboard();
														}
														else
														{
															$judgments_by_current_month=$obj_judgments->MJ_lawmgt_get_all_judgments_dashboard();
														}
													}
													else
													{
														if($user_judgments_access['own_data'] == '1')
														{
															$judgments_by_current_month=$obj_judgments->MJ_lawmgt_get_all_judgments_dashboard_created_by();
														}
														else
														{
															$judgments_by_current_month=$obj_judgments->MJ_lawmgt_get_all_judgments_dashboard();
														}
														
													}
																	
													if(!empty($judgments_by_current_month)) 
													{
														foreach($judgments_by_current_month as $judgmentsdata)
														{
														?>			
															<div class="activity_details">
																<p class="task_title Bold viewdetail show_task_event" id="<?php echo $judgmentsdata->id;?>" model="Judgments Details"><?php echo MJ_lawmgt_get_case_name(esc_html($judgmentsdata->case_id));?></p>
													
																<p class="judgments_date"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($judgmentsdata->date));?></p>										
															</div>
														<?php
														}	
													} 
													else 	
														esc_html_e("No Upcoming Judgments",'lawyer_mgt');
														
													?>						
											</div>
										</div>
									</div>
							<?php  }
								
									if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
									{
									?>
									<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<div class="x_panel">
												<div class="x_title">
													<h2><?php esc_html_e('Calendar','lawyer_mgt');?></h2>							
													<div class="clearfix"></div>
												</div>
												<div id="calendar1" class="x_content full_calender"></div>
												
										</div> 
									</div>
									<?php
									}
								$page='task';
								$task=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
								if($task)
								{
									if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
									{
								?>
									<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
										
										<div class="x_panel upcoming_tasks">
											<div class="x_title">
											  <h2><?php esc_html_e('Tasks','lawyer_mgt');?></h2>
											  <ul class="nav navbar-right panel_toolbox">
												<li class="margin_dasboard"><a href="<?php echo home_url().'?dashboard=user&page=task';?>"><i class="fa fa-external-link" aria-hidden="true"></i></a>
												</li>                   
											  </ul>
											  <div class="clearfix"></div>
											</div>
											<div class="x_content">
													<?php	
													$obj_case_tast= new MJ_lawmgt_case_tast;	
													$user_task_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('task');												
													if($user_role == 'attorney')
													{		
														if($user_task_access['own_data'] == '1')
														{												
															$task_by_current_month=$obj_case_tast->MJ_lawmgt_get_attorney_all_task_by_current_month();
														}
														else
														{
															$task_by_current_month=$obj_case_tast->MJ_lawmgt_get_all_task_by_current_month();
														}
													}
													elseif($user_role == 'client')
													{		
														if($user_task_access['own_data'] == '1')
														{	
															$task_by_current_month=$obj_case_tast->MJ_lawmgt_get_contact_all_task_by_current_month();
														}
														else
														{
															$task_by_current_month=$obj_case_tast->MJ_lawmgt_get_all_task_by_current_month();
														}
													}
													else
													{	
														if($user_task_access['own_data'] == '1')
														{
															$task_by_current_month=$obj_case_tast->MJ_lawmgt_get_all_task_by_current_month_created_by();
														}
														else
														{
															$task_by_current_month=$obj_case_tast->MJ_lawmgt_get_all_task_by_current_month();
														}
													}											
													
																		
													if(!empty($task_by_current_month)) 
													{
														foreach($task_by_current_month as $taskdata)
														{
														?>			
															<div class="activity_details">
																<p class="task_title Bold viewdetail show_task_event" id="<?php echo $taskdata->task_id;?>" model="Task Details"><?php echo esc_html($taskdata->task_name);?></p>
													
																<p class="task_date"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($taskdata->due_date));?></p>										
															</div>
														<?php
														}	
													} 
													else
														esc_html_e("No Upcoming Task",'lawyer_mgt');
													?>						
											</div>
										</div>
									</div>
							<?php  }
								}
								?>
								</div>
								<div class="row">
									<?php
									if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
									{
									?>
									<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<div class="x_panel">
												<div class="x_title">
													<h2><?php esc_html_e('Calendar','lawyer_mgt');?></h2>							
													<div class="clearfix"></div>
												</div>
												<div id="calendar1" class="x_content full_calender"></div>
												
										</div> 
									</div>
									<?php
									}
									$page='report';
									$report=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
									if($report)
									{	
										if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
										{
									?>
										<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<?php
										if($user_role != 'client')  /*--- USER ROLE --*/
										{ 
										?>
											<div class="x_panel report_height_client">
												<div class="x_title">
												  <h2><?php esc_html_e('Report','lawyer_mgt');?></h2>
												  <ul class="nav navbar-right panel_toolbox">
													<li><a class="collapse-link"></a>
													</li>                   
												  </ul>
												  <div class="clearfix"></div>
												</div>
												<?php
												global $wpdb;
												$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
												$table_case = $wpdb->prefix. 'lmgt_cases';
												
												$user_contacts_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('contacts');
												if($user_role == 'attorney')
												{
													if($user_contacts_access['own_data'] == '1')
													{
														$obj_case=new MJ_lawmgt_case;
														$current_user_id = get_current_user_id();
														$attorney_cases=$obj_case->MJ_lawmgt_get_all_case_by_attorney_id($current_user_id);
														$client_data=array();
														$attorneydata1=array();
														if(!empty($attorney_cases))
														{		
															foreach($attorney_cases as $data)
															{
																$case_contact_assigned=explode(',',$data->user_id);	
																if(!empty($case_contact_assigned))
																{		
																	foreach($case_contact_assigned as $data1)
																	{
																		$client_data[]=$data1;
																	}
																}
															}	
														}
														$client_unique=array_unique($client_data);
														 if(!empty($client_unique))
														{	
														$contactdata1=array();													
															foreach($client_unique as $data2)
															{
																$contactdata1[]=get_userdata($data2);
															}	
														}  
														  
														$contactdata_2=$contactdata1; 

														$contactdata_3 = get_users(
															array(
																'role' => 'client',
																'meta_query' => array(
																array(
																		'key' => 'created_by',
																		'value' =>get_current_user_id(),
																		'compare' => '='
																	),
																)
															));	
															$result =array_merge($contactdata_2,$contactdata_3);
															
													}
													else			
													{	
												
														$result =get_users(array('role' => 'client'));	
													}																
														
												}
												elseif($user_role == 'client')
												{
													if($user_contacts_access['own_data'] == '1')
													{														 
														$user_id = get_current_user_id();
														$contactdata=array();
														$result[]=get_userdata($user_id);	
													}
													else			
													{	
														$result =get_users(array('role' => 'client'));	
													}																
												}
												else
												{	
													if($user_contacts_access['own_data'] == '1')
													{
														$result = get_users(
															array(
																'role' => 'client',
																'meta_query' => array(
																array(
																		'key' => 'created_by',
																		'value' =>get_current_user_id(),
																		'compare' => '='
																	),
																)
															));	
													}
													else			
													{														
														$result =get_users(array('role' => 'client'));	
													}																
												}
												$chart_array = array();
												$chart_array[] = array(esc_html__('User Name','lawyer_mgt'),esc_html__('Total No Of Case','lawyer_mgt'));
												if(!empty($result))
												{
													foreach($result as $r)
													{
														$user_id=$r->ID;
														$user_info = get_userdata($user_id);
														$user_name=$user_info->display_name;
														$total_case = $wpdb->get_row("SELECT count(case_id) as count FROM $table_case_contacts where user_id=".$user_id);
														$chart_array[]=array( "$user_name",(int)$total_case->count);
													}
												}	
												$options = Array(
														'title' => esc_html__('Case By Client Report','lawyer_mgt'),
														'titleTextStyle' => Array('color' => '#4E5E6A','fontSize' => 13,'bold'=>true,'italic'=>false,'fontName' =>'Open Sans','sans-serif'),
														'legend' =>Array('position' => 'bottom',
																'textStyle'=> Array('color' => '#4E5E6A','fontSize' => 13,'bold'=>true,'italic'=>false,'fontName' =>'Open Sans','sans-serif')),
															
														'hAxis' => Array(
																'title' =>  esc_html__('User Name','lawyer_mgt'),
																'titleTextStyle' => Array('color' => '#4E5E6A','fontSize' => 13,'bold'=>true,'italic'=>false,'fontName' =>'Open Sans','sans-serif'),
																'textStyle' => Array('color' => '#4E5E6A','fontSize' => 13),
																'maxAlternation' => 2
														),
														'vAxis' => Array(
																'title' =>  esc_html__('No Of Case','lawyer_mgt'),
																'minValue' => 0,
																'maxValue' => 10,
															 'format' => '#',
																'titleTextStyle' => Array('color' => '#4E5E6A','fontSize' => 13,'bold'=>true,'italic'=>false,'fontName' =>'Open Sans','sans-serif'),
																'textStyle' => Array('color' => '#4E5E6A','fontSize' => 13)
														)
												);
												require_once LAWMS_PLUGIN_DIR.'/lib/chart/GoogleCharts.class.php';
												$GoogleCharts = new GoogleCharts;
												if(!empty($result))
												{
													$chart = $GoogleCharts->load( 'column' , 'chart_div1' )->get( $chart_array , $options );
												}

												if(isset($result))
												{
												?>
												<div id="chart_div1" class="width_100_per_height_500px"></div>
											  
											  <!-- Javascript --> 
											 
											  <script type="text/javascript">
														<?php echo $chart; ?>
												</script>
											  <?php }
											 if(empty($result))
											 {?>
												<div class="margin_top_500_px"><?php esc_html_e("There is not enough data to generate report.",'lawyer_mgt');?></div>
											<?php }?>

											</div>
										<?php
										}
										?>
										</div>
									<?php
									}
									}
									?>	
									</div>
								</div>
				  <!-- /dashboard -->
				</div>
				</div>
				</div>
			</div> <!-- END MAIN CONTAINER BODY DIV  -->
		</div> <!-- END CONTAINER BODY DIV  -->
	</body>
</html>
<?PHP //======Front END TEMPLATE CODE START=========//
?>