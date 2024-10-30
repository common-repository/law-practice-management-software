<?php 
$event=new MJ_lawmgt_Event;
$resul_event=$event->MJ_lawmgt_get_all_event();
$notive_array = array();
foreach($resul_event as $resul)
{
	$start_date=esc_html($resul->start_date);
	$end_date=esc_html($resul->end_date);
	$increment =1;
	$notive_array [] = array (
                     'id'=>esc_html($resul->event_id),
					 'title' => esc_html($resul->event_name),
					 'start' => date('Y-m-d',strtotime($start_date)),	
					//end date change with plus 1 day					 
					 'end' => date('Y-m-d',strtotime($end_date .' +'.$increment.' days')),
					 'start_time' => esc_html($resul->start_time),
					 'end_time' => esc_html($resul->end_time),
					 'Address'=> esc_html($resul->address),
					 'city'=> esc_html($resul->city_name),
					 'state'=> esc_html($resul->state_name),
					 'pincode'=> esc_html($resul->pin_code),
					 'color' => '#3e4797',
					 'model_name' => 'Event Details',
					 'url' => 'Event Details',
					 'start_date' => date('Y-m-d',strtotime($start_date))				 
			 );			
}
$obj_case=new MJ_lawmgt_case;
$obj_next_hearing_date=new MJ_lawmgt_Orders;
$casedata=$obj_case->MJ_lawmgt_get_open_all_case();
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
						 'title' => esc_html($data->case_name).'-'.esc_html($data->case_name),
						 'case_name' => esc_html($data->case_name),
						 'case_number' => esc_html($data->case_name),
						 'court_id' => get_the_title($data->court_id),
						 'start' =>  esc_html($data1->next_hearing_date),
						 'end' => esc_html($data1->next_hearing_date),
						 'color' => '#50e6d2',
						 'model_name' => 'Case Details',
						 'url' => 'Case Details',
						 'start_date' => esc_html($data1->next_hearing_date)				 
				 );	
			}
		}
	} 
}
?>
  <script>
    var $ = jQuery.noConflict();
    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
           height:650,
           eventLimit: true, // allow "more" link when too many events		
           headerToolbar: {
        left: 'prev,next today',
        center: 'title',
		//theme: true,
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
              //alert(calEvent.event.id);				
			  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
			  var docHeight = $(document).height(); //grab the height of the page
			  var scrollTop = $(window).scrollTop();
			  var id  = calEvent.event.id
			  var model  = calEvent.event.url
			  //var model  = calEvent.model_name;	
			 // var start_date  = calEvent.start_date;	
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
<?php
if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
{
	global $wpdb;
	$table_invoice = $wpdb->prefix. 'lmgt_invoice';
	$total_paid_amount=$wpdb->get_row("SELECT sum(paid_amount) as total_paid_amount FROM $table_invoice");
	$total_due_amount= $wpdb->get_row("SELECT sum(due_amount) as total_due_amount FROM $table_invoice");
	$total_billable_amount= $wpdb->get_row("SELECT sum(total_amount) as total_billable_amount FROM $table_invoice");
}
?>
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
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV -->
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' )); ?></h3>
	  </div>
	</div>
	
	 
	<div class="container body container_padding"><!-- CONTAINER BODY DIV  -->
		<div class="right_col" role="main">
	  <!-- top row -->
	  
	 
		<div class="row custom_row_css margin_bottom_20">
				<div class="col-lg-3 col-md-3 col-xs-12 col-sm-3">
				<a href="<?php echo esc_url(admin_url().'admin.php?page=attorney');?>">
					<div class="panel info-box panel-white">
						<div class="panel-body attorney">
							<div class="info-box-stats">
								<p class="counter"><?php 
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
								$user_query = new WP_User_Query($args);
								$attorney_count = (int) $user_query->get_total();
								echo esc_html($attorney_count);
								?>
								</p>
								<span class="info-box-title"><?php echo esc_html__( 'Attorney', 'lawyer_mgt' );?></span>
							</div>
							<img src="<?php echo esc_url(LAWMS_PLUGIN_URL."/assets/images/dashboard/attorney.png")?>" class="dashboard_background">
						</div>
					</div>
				</a>
				</div>
				<div class="col-lg-3 col-md-3 col-xs-12 col-sm-3 dashboard_margin_top">
				<a href="<?php echo esc_url(admin_url().'admin.php?page=staff');?>">
					<div class="panel info-box panel-white">
						<div class="panel-body staff_member">
							<div class="info-box-stats">
								 
								<p class="counter"><?php 
								 $args = array(
										'role' => 'staff_member',
										'meta_query' =>array( 
											array(
													'key' => 'deleted_status',
													'value' =>0,
													'compare' => '='
												)
										)	
									);	
								$user_query = new WP_User_Query($args);
								$staff_member_count = (int) $user_query->get_total();
								echo esc_html($staff_member_count);
								?>
								</p>
								<span class="info-box-title"><?php echo esc_html__( 'Staff', 'lawyer_mgt' );?></span>
							</div>
							<img src="<?php echo esc_url(LAWMS_PLUGIN_URL."/assets/images/dashboard/staff.png")?>" class="dashboard_background">
							
						</div>
					</div>
					</a>
				</div>
				<div class="col-lg-3 col-md-3 col-xs-12 col-sm-3 dashboard_margin_top">
				<a href="<?php echo esc_url(admin_url().'admin.php?page=accountant');?>">
					<div class="panel info-box panel-white">
						<div class="panel-body accountant">
							<div class="info-box-stats">
								 
								<p class="counter"><?php 
								 $args = array(
										'role' => 'accountant',
										'meta_query' =>array( 
											array(
													'key' => 'deleted_status',
													'value' =>0,
													'compare' => '='
												)
										)	
									);	
																
								$user_query = new WP_User_Query($args);
								$accountant_count = (int) $user_query->get_total();
								echo esc_html($accountant_count);
								?>
								</p>
								<span class="info-box-title"><?php echo esc_html__( 'Accountant', 'lawyer_mgt' );?></span>
							</div>
							<img src="<?php echo esc_url(LAWMS_PLUGIN_URL."/assets/images/dashboard/accountant.png")?>" class="dashboard_background">
							
						</div>
					</div>
					</a>
				</div>
				<div class="col-lg-3 col-md-3 col-xs-12 col-sm-3 dashboard_margin_top">
				<a href="<?php echo esc_url(admin_url().'admin.php?page=contacts');?>">
					<div class="panel info-box panel-white">
						<div class="panel-body client">
							<div class="info-box-stats">
								<?php
								$user_query = new WP_User_Query(array('role'=>'client'));
								$client_count = (int) $user_query->get_total();
								
								?>
								<p class="counter"><?php echo esc_html($client_count);?></p>
								
								<span class="info-box-title"><?php echo esc_html__( 'Clients', 'lawyer_mgt' );?></span>
							</div>
							<img src="<?php echo esc_url(LAWMS_PLUGIN_URL."/assets/images/dashboard/contact.png")?>" class="dashboard_background">
							
						</div>
					</div>
					</a>
				</div>	
				<div class="col-lg-3 col-md-3 col-xs-12 col-sm-3 save_client_btn">
				<a href="<?php echo esc_url(admin_url().'admin.php?page=cases');?>">
					<div class="panel info-box panel-white">
						<div class="panel-body case">
							<div class="info-box-stats">
							 <?php 
								global $wpdb;
								$table_case = $wpdb->prefix. 'lmgt_cases';
								$total_case = $wpdb->get_row("SELECT COUNT(*) as  total_case FROM $table_case");	
							?>
								<p class="counter"><?php echo  esc_html($total_case->total_case);?></p>
								
								<span class="info-box-title"><?php echo esc_html__( 'Cases', 'lawyer_mgt' );?></span>
							</div>
							<img src="<?php echo esc_url(LAWMS_PLUGIN_URL."/assets/images/dashboard/case.png")?>" class="dashboard_background">
						</div>
					</div>
				</a>
				</div>
				<?php
				if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
				{
					?>
				<div class="col-lg-3 col-md-3 col-xs-12 col-sm-3">
				<a href="<?php echo esc_url(admin_url().'admin.php?page=invoice');?>">
					<div class="panel info-box panel-white">
						<div class="panel-body invoice">
							<div class="info-box-stats">
							<?php 
								global $wpdb;
								$table_invoice= $wpdb->prefix. 'lmgt_invoice';
								$total_invoice = $wpdb->get_row("SELECT COUNT(*) as  total_invoice FROM $table_invoice");	
							?>
								<p class="counter"><?php echo esc_html($total_invoice->total_invoice);?></p>
								<span class="info-box-title"><?php echo esc_html__( 'Invoices', 'lawyer_mgt' );?></span>
							</div>
							<img src="<?php echo esc_url(LAWMS_PLUGIN_URL."/assets/images/dashboard/invoice.png")?>" class="dashboard_background">
							
						</div>
					</div>
					</a>
				</div>
				<div class="col-lg-3 col-md-3 col-xs-12 col-sm-3 ">
				<a href="<?php echo esc_url(admin_url().'admin.php?page=task');?>">
					<div class="panel info-box panel-white">
						<div class="panel-body task">
							<div class="info-box-stats">
								<?php 
								global $wpdb;
								$table_law_add_task= $wpdb->prefix. 'lmgt_add_task';
								$total_task = $wpdb->get_row("SELECT COUNT(*) as  total_task FROM $table_law_add_task");	
								?>
								<p class="counter"><?php echo esc_html($total_task->total_task);?></p>
								<span class="info-box-title"><?php echo esc_html__( 'Tasks', 'lawyer_mgt' );?></span>
							</div>
							<img src="<?php echo esc_url(LAWMS_PLUGIN_URL."/assets/images/dashboard/task_1.png")?>" class="dashboard_background">
							
						</div>
					</div>
					</a>
				</div>
				<?php
				}
				?>
				<div class="col-lg-3 col-md-3 col-xs-12 col-sm-3 save_client_btn">
				<a href="<?php echo esc_url(admin_url().'admin.php?page=lmgt_gnrl_setting');?>">
					<div class="panel info-box panel-white">
						<div class="panel-body setting">
							<div class="info-box-stats">
								<p class="counter"> &nbsp;</p>
								<span class="info-box-title"><?php echo esc_html__( 'Settings', 'lawyer_mgt' );?></span>
							</div>
							<img src="<?php echo esc_url(LAWMS_PLUGIN_URL."/assets/images/dashboard/setting-image.png")?>" class="dashboard_background">
						</div>
					</div>
					</a>
				</div>			
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
		<div id="CalenderModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><!--  CALANDER MODEL EDIT DIV -->
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
		</div><!--  END CALANDER MODEL EDIT DIV -->

		<div id="fc_create" data-toggle="modal" data-target="#CalenderModalNew"></div>
		<div id="fc_edit" data-toggle="modal" data-target="#CalenderModalEdit"></div>
		<!-- /calendar modal -->		
			<div class="row">
				<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 padding_css dashboard_margin_top margin_top_res">						
					<div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
					<div class="x_panel attorney_open_case">
						  <div class="x_title">				   
							<h2><?php esc_html_e('Attorney Open Case History','lawyer_mgt');?></h2>
								<ul class="nav navbar-right panel_toolbox">
								  <li><a href="<?php echo esc_url(admin_url().'admin.php?&page=cases&tab=caselist&tab2=open');?>" print="20" class="openserviceall View_all"><button type="button" class="btn  btn-default btn_view_all"><?php esc_html_e('View All','lawyer_mgt');?></button></a>
								  </li>                      
								</ul>
							<div class="clearfix"></div>
						  </div>
						   <?php 					 
							global $wpdb;
							$table_case = $wpdb->prefix. 'lmgt_cases';	 
							$attorneydata=$wpdb->get_results("SELECT * FROM $table_case WHERE  case_status='open' ORDER BY id DESC LIMIT 5");
									
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
									$username_sanitzie = array_map( 'sanitize_text_field', wp_unslash( $username ) );
									$contatc_name=implode(',',$username_sanitzie);						
								}
							 ?>
						 <div class="x_content">
						  <article class="media event">
							  <a class="pull-left date">
								<p class="month"><?php echo date('M',strtotime(esc_html($retrieved_data->open_date)));?></p>
								<p class="day"><?php echo date('d',strtotime(esc_html($retrieved_data->open_date)));?></p>
							  </a>
							  <div class="media-body">
								 <h5> <b><?php esc_html_e('Client Name:','lawyer_mgt');?> </b> <?php echo esc_html($contatc_name);?> </h5>  
								 <p><b><?php esc_html_e(' Case Name:','lawyer_mgt');?> </b><?php echo esc_html($retrieved_data->case_name);?></p>
							  </div>
							 
							  <a href="<?php echo esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&close_case=true&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)));?>"  data-target="#myModal-open-modal" print="20" class="openmodel"><i class="fa fa-eye eye" aria-hidden="true"></i></a>
							 <!--  <a href="admin.php?page=cases&tab=casedetails&action=view&close_case=true&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($case_id)); ?>"  data-target="#myModal-open-modal" print="20" class="openmodel"><i class="fa fa-eye eye" aria-hidden="true"></i></a> -->
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
							<ul class="nav navbar-right">
							
							  <li><a href="<?php echo esc_url(admin_url().'admin.php?page=cases&tab=caselist&tab2=close');?>" print="20" class="openserviceall View_all padding_0 close_case_att"><button type="button" class="btn  btn-default btn_view_all"><?php esc_html_e('View All','lawyer_mgt');?></button></a>
							  </li>                      
							</ul>
							<div class="clearfix"></div>
						  </div>
						  <?php 
								global $wpdb;
								$table_case = $wpdb->prefix. 'lmgt_cases';		 
								$attorneydata=$wpdb->get_results("SELECT * FROM $table_case WHERE  case_status='close' ORDER BY id DESC LIMIT 5");
									
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
									$username_sanitzie = array_map( 'sanitize_text_field', wp_unslash( $username ) );
									$contatc_name=implode(',',$username_sanitzie);						
								}
							 ?>
						<div class="x_content">
					    <article class="media event">
							  <a class="pull-left date">
								<p class="month"><?php echo date('M',strtotime(esc_html($retrieved_data->open_date)));?></p>
								<p class="day"><?php echo date('d',strtotime(esc_html($retrieved_data->open_date)));?></p>
							  </a>
							  <div class="media-body">
								 <h5> <b><?php esc_html_e('Client Name:','lawyer_mgt');?> </b> <?php echo esc_html($contatc_name);?> </h5>  
								 <p><b><?php esc_html_e('Case Name:','lawyer_mgt');?></b> <?php echo esc_html($retrieved_data->case_name);?></p>
							  </div>
							  <a href="<?php echo esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&close_case=true&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)));?>"  data-target="#myModal-open-modal" print="20" class="openmodel"><i class="fa fa-eye eye" aria-hidden="true"></i></a>
							 <!--  <a href="admin.php?page=cases&tab=casedetails&action=view&close_case=true&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($case_id)); ?>"  data-target="#myModal-open-modal" print="20" class="openmodel"><i class="fa fa-eye eye" aria-hidden="true"></i></a> -->
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
								if(file_exists(LAWMS_LOG_file)) 
								{
									foreach(array_reverse(array_slice(file(LAWMS_LOG_file),-5)) as $line)
									{
									?>
										<tr>
											<td><?php echo esc_html($line);?></td>						
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
				<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel upcoming_events">
						<div class="x_title">
						  <h2><?php esc_html_e('Events','lawyer_mgt');?></h2>
						  <ul class="nav navbar-right panel_toolbox">
							<li class="margin_dasboard"><a href="<?php echo esc_url(admin_url().'admin.php?page=event');?>"><i class="fa fa-external-link" aria-hidden="true"></i></a>
							</li>                  
						  </ul>
						  <div class="clearfix"></div>
						</div>
						<div class="x_content">
								<?php 
								$event_by_current_month=$event->MJ_lawmgt_get_all_event_by_current_month();
													
								if(!empty($event_by_current_month)) 
								{
									foreach($event_by_current_month as $eventdata)
									{
									?>			
										<div class="activity_details">
											<p class="event_title Bold viewdetail show_task_event" id="<?php echo esc_html($eventdata->event_id);?>" model="Event Details" ><?php echo esc_html($eventdata->event_name);?></p>
								
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
					
					<div class="x_panel upcoming_orders">
						<div class="x_title">
						  <h2><?php esc_html_e('Orders','lawyer_mgt');?></h2>
						  <ul class="nav navbar-right panel_toolbox">
							<li class="margin_dasboard"><a href="<?php echo esc_url(admin_url().'admin.php?page=orders');?>"><i class="fa fa-external-link" aria-hidden="true"></i></a>
							</li>                   
						  </ul>
						  <div class="clearfix"></div>
						</div>
						<div class="x_content">
								<?php 
								$obj_orders= new MJ_lawmgt_Orders;
								$orders_by_current_month=$obj_orders->MJ_lawmgt_get_all_orders_dashboard();
													
								if(!empty($orders_by_current_month)) 
								{
									foreach($orders_by_current_month as $ordersdata)
									{
									?>			
										<div class="activity_details">
											<p class="task_title Bold viewdetail show_task_event" id="<?php echo esc_html($ordersdata->id);?>" model="Orders Details"><?php echo esc_html(MJ_lawmgt_get_case_name($ordersdata->case_id));?></p>
								
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
					<div class="x_panel upcoming_next_hearing_date">
						<div class="x_title">
						  <h2><?php esc_html_e("Next Hearing date",'lawyer_mgt');?></h2>
						  <ul class="nav navbar-right panel_toolbox">
							<li class="margin_dasboard"><a href="<?php echo esc_url(admin_url().'admin.php?page=orders');?>"><i class="fa fa-external-link" aria-hidden="true"></i></a>
							</li>                    
						  </ul>
						  <div class="clearfix"></div>
						</div>
						<div class="x_content">
								<?php 
								$obj_orders=new MJ_lawmgt_Orders;
								$orders_result=$obj_orders->MJ_lawmgt_get_next_hearing_date_dashboard();  
								 
								if(!empty($orders_result)) 
								{
									foreach($orders_result as $ordersdata)
									{
									?>			
										<div class="activity_details">
											<p class="next_hearing_date_title Bold viewdetail show_task_event" id="<?php echo $ordersdata->id;?>" model="Next Hearing Date Details"><?php echo MJ_lawmgt_get_case_name(esc_html($ordersdata->case_id));?></p>
								
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
					<?php
					if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
					{
					?>
					<div class="x_panel">
						<div class="x_title">
							<h2><?php esc_html_e('Calendar','lawyer_mgt');?></h2>							
							<div class="clearfix"></div>
						</div>
						<div id="calendar" class="x_content full_calender"></div>
					</div> 
					<?php
					}	
					?>	
				</div>
				
				<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
					<?php
					if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
					{
					?>
					<div class="x_panel upcoming_tasks">
						<div class="x_title">
						  <h2><?php esc_html_e('Tasks','lawyer_mgt');?></h2>
						  <ul class="nav navbar-right panel_toolbox">
							<li class="margin_dasboard"><a href="<?php echo esc_url(admin_url().'admin.php?page=task');?>"><i class="fa fa-external-link" aria-hidden="true"></i></a>
							</li>                     
						  </ul>
						  <div class="clearfix"></div>
						</div>
						<div class="x_content">
								<?php 
								$obj_case_tast= new MJ_lawmgt_case_tast;
								$task_by_current_month=$obj_case_tast->MJ_lawmgt_get_all_task_by_current_month();
													
								if(!empty($task_by_current_month)) 
								{
									foreach($task_by_current_month as $taskdata)
									{
									?>			
										<div class="activity_details">
											<p class="task_title Bold viewdetail show_task_event" id="<?php echo esc_html($taskdata->task_id);?>" model="Task Details"><?php echo esc_html($taskdata->task_name);?></p>
								
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
					<?php
					}
					?>
					<div class="x_panel upcoming_judgments">
						<div class="x_title">
						  <h2><?php esc_html_e("Judgments",'lawyer_mgt');?></h2>
						  <ul class="nav navbar-right panel_toolbox">
							<li class="margin_dasboard"><a href="<?php echo esc_url(admin_url().'admin.php?page=judgments');?>"><i class="fa fa-external-link" aria-hidden="true"></i></a>
							</li>                     
						  </ul>
						  <div class="clearfix"></div>
						</div>
						<div class="x_content">
								<?php 
								$obj_judgments= new MJ_lawmgt_Judgments;
								$judgments_by_current_month=$obj_judgments->MJ_lawmgt_get_all_judgments_dashboard();
													
								if(!empty($judgments_by_current_month)) 
								{
									foreach($judgments_by_current_month as $judgmentsdata)
									{
									?>			
										<div class="activity_details">
											<p class="task_title Bold viewdetail show_task_event" id="<?php echo $judgmentsdata->id;?>" model="Judgments Details"><?php echo esc_html(MJ_lawmgt_get_case_name($judgmentsdata->case_id));?></p>
								
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
					
					<div class="x_panel upcoming_note">
						<div class="x_title">
						  <h2><?php esc_html_e("Notes",'lawyer_mgt');?></h2>
						  <ul class="nav navbar-right panel_toolbox">
							<li class="margin_dasboard"><a href="<?php echo esc_url(admin_url().'admin.php?page=note');?>"><i class="fa fa-external-link" aria-hidden="true"></i></a>
							</li>                     
						  </ul>
						  <div class="clearfix"></div>
						</div>
						<div class="x_content">
								<?php 
								$obj_note= new MJ_lawmgt_Note;
								$note_data=$obj_note->MJ_lawmgt_get_all_note_dashboard();
													
								if(!empty($note_data)) 
								{
									foreach($note_data as $notedata)
									{
									?>			
										<div class="activity_details">
											<p class="note_title Bold viewdetail show_task_event" id="<?php echo esc_html($notedata->note_id);?>" model="Note Details"><?php echo esc_html(MJ_lawmgt_get_case_name($notedata->case_id));?></p>
								
											<p class="note_date"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($notedata->date_time));?></p>										
										</div>
									<?php
									}	
								} 
								else 	
									esc_html_e("No Upcoming Note",'lawyer_mgt');
									
								?>						
						</div>
					</div>
					<?php
					if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
					{
					?>
					<div class="x_panel">
						<div class="x_title">
							<h2><?php esc_html_e('Calendar','lawyer_mgt');?></h2>							
							<div class="clearfix"></div>
						</div>
						<div id="calendar" class="x_content full_calender"></div>
					</div>

					<?php
					}	
					
					if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
					{
					?>
					<div class="x_panel report_height">
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
						
						$result = $wpdb->get_results("SELECT DISTINCT(user_id) FROM $table_case_contacts");
						
						$chart_array = array();
						$chart_array[] = array(esc_html__('User Name','lawyer_mgt'),esc_html__('Total No Of Case','lawyer_mgt'));
						if(!empty($result))
						{
							foreach($result as $r)
							{
								$user_id=$r->user_id;
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
										'title' =>  esc_html__('UserName','lawyer_mgt'),
										'titleTextStyle' => Array('color' => '#4E5E6A','fontSize' => 13,'bold'=>true,'italic'=>false,'fontName' =>'Open Sans','sans-serif'),
										'textStyle' => Array('color' => '#4E5E6A','fontSize' => 13),
										'maxAlternation' => 2
								),
								'vAxis' => Array(
										'title' =>  esc_html__('Number Of Case','lawyer_mgt'),
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
						if(isset($result) && count($result) >0)
						{
							
						?>
							<div id="chart_div1" class="width_100_per_height_500px"></div>
					  
						  <!-- Javascript --> 
						  
						  <script type="text/javascript">
									<?php echo $chart;?>
							</script>
					  <?php 
						}
					 if(isset($result) && empty($result))
					 {?>
						<div class="clear col-md-12"><?php esc_html_e("There is not enough data to generate report.",'lawyer_mgt');?></div>
					<?php }?>

					</div>
					<?php
					}
					?>
				</div>
			</div>		
	</div>
</div><!-- END CONTAINER BODY DIV  -->
</div><!-- END  INNER PAGE  DIV -->