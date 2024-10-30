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
	if(!empty($_REQUEST['action']))
	{
		if (isset ( $_REQUEST ['page'] ) && sanitize_text_field($_REQUEST ['page']) == $user_access['page_link'] && (sanitize_text_field($_REQUEST['action'])=='edit'))
		{
			if($user_access['edit']=='0')
			{	
				MJ_lawmgt_access_right_page_not_access_message();
				die;
			}			
		}
		if (isset ( $_REQUEST ['page'] ) && sanitize_text_field($_REQUEST ['page']) == $user_access['page_link'] && (sanitize_text_field($_REQUEST['action'])=='delete'))
		{
			if($user_access['delete']=='0')
			{	
				MJ_lawmgt_access_right_page_not_access_message();
				die;
			}	
		}
		if (isset ( $_REQUEST ['page'] ) && sanitize_text_field($_REQUEST ['page']) == $user_access['page_link'] && (sanitize_text_field($_REQUEST['action'])=='insert'))
		{
			if($user_access['add']=='0')
			{	
				MJ_lawmgt_access_right_page_not_access_message();
				die;
			}	
		} 
	}
}
$event=new MJ_lawmgt_Event;
$obj_case=new MJ_lawmgt_case;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'eventlist');
$result=null;
?>
<div class="page_inner_front"><!--  PAGE INNER DIV -->
	
	<?php 
	if(isset($_POST['saveevent']))
	{
	   $nonce =  sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_event_nonce' ) )
		{ 
			if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='edit')
			{
				 $result=$event->MJ_lawmgt_add_event($_POST);
				 if($result)
				 {
					//wp_redirect (home_url().'?dashboard=user&page=event&tab=eventlist&message=2');
					$redirect_url=home_url().'?dashboard=user&page=event&tab=eventlist&message=2';
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
				$result=$event->MJ_lawmgt_add_event($_POST);
				if($result)
				{
					//wp_redirect (home_url().'?dashboard=user&page=event&tab=eventlist&message=1');
					$redirect_url=home_url().'?dashboard=user&page=event&tab=eventlist&message=1';
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
	}
	if(isset($_REQUEST['deleteevent'])&& sanitize_text_field($_REQUEST['deleteevent'])=='true')
	{
		$result=$event->MJ_lawmgt_get_signle_event_Delete_by_id(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id'])));
		if($result)
		{
			//wp_redirect (home_url().'?dashboard=user&page=event&tab=eventlist&message=3');
			$redirect_url=home_url().'?dashboard=user&page=event&tab=eventlist&message=3';
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
	if(isset($_POST['event_delete_selected']))
	{
		if (isset($_POST["selected_id"]))
		{		
			$selected_id_filter = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ));
			$all = implode(",", $selected_id_filter);			
			$result=$event->MJ_lawmgt_delete_selected_event($all);	
		}
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
					<?php esc_html_e('Please Select At least One Record.','lawyer_mgt');?>
				</div>
		<?php		
		}	
		if($result)
		{
			$redirect_url=home_url().'?dashboard=user&page=event&tab=eventlist&message=3';
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
	if(isset($_REQUEST['message']))
	{
		$message =sanitize_text_field($_REQUEST['message']);
		if($message == 1)
		{?>	
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
			<?php esc_html_e('Event Inserted Successfully','lawyer_mgt');?>
			</div>
			<?php 
			
		}
		elseif($message == 2)
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<?php esc_html_e('Event Updated Successfully','lawyer_mgt');?>
			</div>
			<?php 			
		}
		elseif($message == 3) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
            <?php esc_html_e('Event Delete Successfully','lawyer_mgt');?>
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
						<h2 class="nav-tab-wrapper margin_bottom">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="add_event">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'eventlist' ? 'active' : ''; ?> menucss active_mt">
									<a href="?dashboard=user&page=event&tab=eventlist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Event List', 'lawyer_mgt'); ?>
									</a>
								</li>
								
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_event' ? 'active' : ''; ?> menucss tab_mt">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
								{?>
								<a href="?dashboard=user&page=event&tab=add_event&action=edit&id=<?php echo esc_attr($_REQUEST['id']);?> ">
									<?php esc_html_e('Edit Event', 'lawyer_mgt'); ?>
								</a>  
								<?php 
								}
								else
								{
									if($user_access['add']=='1')
									{
										?>
										<a href="?dashboard=user&page=event&tab=add_event&&action=insert">
											<?php echo '<span class="fa fa-plus-circle"></span> '.esc_html__('Add Event', 'lawyer_mgt');?>
										</a>  
									<?php 
									}	 
								}
								?>
								</li>		
								<?php									
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
									{?>
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'viewevent' ? 'active' : ''; ?> menucss tab_mt">
										<a href="?dashboard=user&page=event&tab=viewevent&action=view&id=<?php echo esc_attr($_REQUEST['id']);?>">
											<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('View Event', 'lawyer_mgt'); ?>
										</a>
									</li>
									<?php
								}
								?>			
							</ul>
						</h2>
						<?php	
						if($active_tab=='eventlist') /*-- EVENT LIST ACTIVE TAB */
						{?>
							<script type="text/javascript">
								jQuery(document).ready(function($)
								{
									"use strict"; 
									jQuery('#note_list111').DataTable({
										"responsive": true,
										"autoWidth": false,
										"order": [[ 1, "asc" ]],
										language:<?php echo wpnc_datatable_multi_language();?>,
										 "aoColumns":[
													  {"bSortable": false},
													  {"bSortable": false},
													  {"bSortable": true},
													  {"bSortable": true},
													  {"bSortable": true},
													   {"bSortable": true},
													  {"bSortable": true},
													  {"bSortable": true},
													  {"bSortable": false}
												   ]		               		
										});	
										$(".delete_check").on('click', function()
											{	
												if ($('.sub_chk:checked').length == 0 )
											{
												alert("<?php esc_html_e('Please select atleast one record','lawyer_mgt');?>");
												return false;
											}
											else{
												alert("<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>");
												return true;
												}
										});
								} );
								jQuery(document).ready(function($)
								{	
									"use strict"; 
									jQuery('#select_all').on('click', function(e)
									{
										 if($(this).is(':checked',true))  
										 {
											$(".sub_chk").prop('checked', true);  
										 }  
										 else  
										 {  
											$(".sub_chk").prop('checked',false);  
										 } 
									});
									$("body").on("change", ".sub_chk", function()
									{ 
										if(false == $(this).prop("checked"))
										{ 
											$("#select_all").prop('checked', false); 
										}
										if ($('.sub_chk:checked').length == $('.sub_chk').length )
										{
											$("#select_all").prop('checked', true);
										}
									});
								});	
								jQuery(document).ready(function($) 
								{
									"use strict"; 
									jQuery('#event_list').validationEngine();
								});
							</script>
							<form name="event_list" action="" method="post" enctype='multipart/form-data'>
							<div class="panel-body margin_task"> <!-- PANEL BODY DIV  -->
								<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">	
									<table id="note_list111" class="tast_list1 table table-striped table-bordered">
										<thead>												
											<tr>
												<th><input type="checkbox" id="select_all"></th>
												<th><?php  esc_html_e('Event Name', 'lawyer_mgt' ) ;?></th>
												<th><?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
												<th><?php esc_html_e('Practice Area', 'lawyer_mgt' ) ;?></th>
												<th> <?php esc_html_e('Client Name', 'lawyer_mgt' ) ;?></th>
												<th> <?php esc_html_e('Attorney Name', 'lawyer_mgt' ) ;?></th>
												<th> <?php esc_html_e('Date/Time', 'lawyer_mgt' ) ;?></th>
												<th><?php esc_html_e('Address', 'lawyer_mgt' ) ;?></th>
												<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
											</tr>
											<br/>
										</thead>
										<tbody>
											<?php
											if($user_role == 'attorney')
											{
												if($user_access['own_data'] == '1')
												{
													$eventdata=$event->MJ_lawmgt_get_all_event_by_attorney(); 
												}
												else					
												{
													$eventdata=$event->MJ_lawmgt_get_all_event_by_id(); 
												}		
											}
											elseif($user_role == 'client')
											{
												if($user_access['own_data'] == '1')
												{
													$eventdata=$event->MJ_lawmgt_get_all_event_by_client(); 	
												}
												else					
												{
													$eventdata=$event->MJ_lawmgt_get_all_event_by_id(); 
												}	
											}
											else					
											{
												if($user_access['own_data'] == '1')
												{
													$eventdata=$event->MJ_lawmgt_get_all_event_by_id_created_by(); 
												}
												else
												{
													$eventdata=$event->MJ_lawmgt_get_all_event_by_id();
												}
											}	
											if(!empty($eventdata))
											{
											   
												foreach ($eventdata as $retrieved_data)
												{
													$case_name=MJ_lawmgt_get_case_name_by_id($retrieved_data->case_id);
													foreach($case_name as $case_name1)
													{
														$case_name2=esc_html($case_name1->case_name);
													}
												
													 $user_id=$retrieved_data->assigned_to_user;
													 $contac_id=explode(',',$user_id);
													 $conatc_name=array();
													foreach($contac_id as $contact_name) 
													{													
														$userdata=get_userdata($contact_name);
														$conatc_name[]=esc_html($userdata->display_name);
													}
													$attorney=$retrieved_data->assign_to_attorney;
													$attorney_name=explode(',',$attorney);
													$attorney_name1=array();
													foreach($attorney_name as $attorney_name2) 
													{
														$attorneydata=get_userdata($attorney_name2);	
															
														$attorney_name1[]=esc_html($attorneydata->display_name);										   
													}	
													?>
													<tr>
														<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_attr($retrieved_data->event_id); ?>"></td>												
														 <td class="email"><a href="?dashboard=user&page=event&tab=viewevent&action=view&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->event_id));?>"><?php echo esc_html($retrieved_data->event_name);?></a></td>
														 <td class="prac_area"><a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>"><?php echo esc_html($case_name2); ?></a></td>	
														<td class="added"><?php echo esc_html(get_the_title($retrieved_data->practice_area_id));?></td>	
														<td class="added"><?php echo esc_html(implode(',',$conatc_name));?></td>
														<td class="added"><?php echo esc_html(implode(',',$attorney_name1));?></td>					
														<td class="added"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->start_date)).' '.$retrieved_data->start_time;?></td>
														<td class="added"><?php echo  esc_html($retrieved_data->address);?></td>						
														<td class="action"> 		
															<a href="?dashboard=user&page=event&tab=viewevent&action=view&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->event_id));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>						 
															<?php
															if($user_access['edit']=='1')
															{
															?>                       
																<a href="?dashboard=user&page=event&tab=add_event&action=edit&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->event_id));?>" id="ediit" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
															<?php
															}
															if($user_access['delete']=='1')
															{
																?>
																<a href="?dashboard=user&page=event&tab=eventlist&deleteevent=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->event_id));?>" class="btn btn-danger" 
																onclick="return confirm('<?php esc_html_e('Are you sure you want to Delete this Event ?','lawyer_mgt');?>');">
															  <?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>					
															<?php
															}
															?>
														</td>               
													</tr>
										<?php 	} 			
											} ?>     
										</tbody>									
									</table>
									<?php
									if($user_access['delete']=='1')
									{
										if(!empty($eventdata))
										{
											?>  
											<div class="form-group">		
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
													<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="event_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
												</div>
											</div>
											<?php
										}
									}
									?>
								</div>
							</div>   <!-- END PANEL BODY DIV  --> 
							</form>
						 <?php 
						} 
						if($active_tab == 'add_event') /*-- ADD EVENT  TAB */
						{	   
							$obj_case_tast= new MJ_lawmgt_case_tast;
							$event=new MJ_lawmgt_Event;
							?>
							  <!-- POP up code -->
							<div class="popup-bg">
								<div class="overlay-content">
									<div class="modal-content">
										<div class="company_list">
										</div>
									</div>
								</div> 
							</div>
							<!-- End POP-UP Code -->
							<script type="text/javascript">
							    var $ = jQuery.noConflict();
								jQuery(document).ready(function($)
								{
									"use strict"; 
									jQuery('#event_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
									
									var start = new Date();
									var end = new Date(new Date().setYear(start.getFullYear()+1));

									$('.date1').datepicker({
										startDate : start,
										endDate   : end,
										autoclose: true
									}).on('changeDate', function(){
										$('.date2').datepicker('setStartDate', new Date($(this).val()));
									}); 

									$('.date2').datepicker({
										startDate : start,
										endDate   : end,
										autoclose: true
									}).on('changeDate', function(){
										$('.date1').datepicker('setEndDate', new Date($(this).val()));
									});
		
									jQuery('.time').timepicker({
								
										});	
									$('.submitevent').on("click",function()
									{
										var start_date = $("#start_date").val();
										var end_date = $("#end_date").val();
										var start_time = $("#start_time").val();
										var end_time = $("#end_time").val(); 
										
										if(start_date != "" || end_date != "" || start_time != "" || end_time != "")
										{
											if(start_date == end_date)
											{ 
												if(start_time > end_time)
												{ 
													 
													alert("<?php esc_html_e('event start time must less then the end time...','lawyer_mgt');?>");
													$("#end_time").val('');
												}	
											}
										}
									});										
								}); 
								jQuery(document).ready(function($)
								{
									"use strict"; 
									$("#assigned_to_user").multiselect({
										enableFiltering: true,
										enableCaseInsensitiveFiltering: true,
										nonSelectedText :'<?php esc_html_e('Select Client Name','lawyer_mgt');?>',
										minSelectedItems: 1,
										selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
										includeSelectAllOption: true  
									});
									$(".submitevent").on("click",function()
									{	
										var checked = $(".multiselect_validation .dropdown-menu input:checked").length;

										if(!checked)
										{
											alert("<?php esc_html_e('Please select atleast one Client Name','lawyer_mgt');?>");
											return false;
										}			
									});	 
								});
								jQuery(document).ready(function($)
								{	
									"use strict"; 
									$("#assign_to_attorney").multiselect({ 
										enableFiltering: true,
										enableCaseInsensitiveFiltering: true,
										 nonSelectedText :'<?php esc_html_e('Select Attorney Name','lawyer_mgt');?>',
										  selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
										 includeSelectAllOption: true         
									});
									 
									$(".submitevent").on("click",function()
									{	
										var checked = $(".multiselect_validation123 .dropdown-menu input:checked").length;

										if(!checked)
										{
											 
											alert("<?php esc_html_e('Please select atleast one Attorney Name','lawyer_mgt');?>");
											return false;
										}			
									}); 
								});	
								function MJ_lawmgt_add_reminder()
								{
									"use strict"; 
									$("#reminder_entry").append('<div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" ><?php esc_html_e('Event Reminders','lawyer_mgt');?></label><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback"><select name="casedata[type][]" id="case_reminder_type"><option selected="selected" value="mail"><?php esc_html_e('Mail','lawyer_mgt');?></option></select></div><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback btn_margin"><input id="remindertimevalue" class="form-control text-input validate[required]" type="number"  value="1" name="casedata[remindertimevalue][]" min="1"></div><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback btn_margin"><select name="casedata[remindertimeformat][]" id="case_reminder_type"><option selected="selected" value="day"><?php esc_html_e('Day(s)','lawyer_mgt');?></option><option value="hour"><?php esc_html_e('Hour(s)','lawyer_mgt');?></option></select></div><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Event Start Date','lawyer_mgt');?></label><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger"></div></div>');   		
								}  	

								function MJ_lawmgt_deleteParentElement(n)
								{
									"use strict"; 
									alert("<?php esc_html_e('Do you really want to delete this ?','lawyer_mgt');?>");
									n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
								}
							</script>	
							<?php 	
							$event_id=0;
							$edt=0;
							if(isset($_REQUEST['id']))
								$event_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id']));
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
								{					
									$edt=1;
									$casedata=$resul=$event->MJ_lawmgt_get_signle_event_by_id($event_id);
								}?>
							<div class="panel-body "> <!--PANEL BODY DIV  -->
								<form name="event_form" action="" method="post" class="form-horizontal" id="event_form" enctype='multipart/form-data'>	
									<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
									<input id="action" class="form-control  text-input" type="hidden"  value="<?php echo esc_attr($action); ?>" name="action">
									<input id="action1" class="form-control  text-input" type="hidden"  value="<?php echo 'edit'; ?>" name="action1">
									<div class="header margin_cause">	
										<h3 class="first_hed"><?php esc_html_e('Linked To','lawyer_mgt');?></h3>
										<hr>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Case Name','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<?php 	
											$user_case_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('cases');
											if($user_role == 'attorney')
											{
												if($user_case_access['own_data'] == '1')
												{
													$attorney_id = get_current_user_id();														
													$result = $obj_case->MJ_lawmgt_get_open_case_by_attorney($attorney_id);	
												}
												else
												{
													$result = $obj_case->MJ_lawmgt_get_open_all_case();
												}		
											}
											else
											{
												if($user_case_access['own_data'] == '1')
												{
													$result = $obj_case->MJ_lawmgt_get_open_all_case_created_by();
												}
												else
												{
													$result = $obj_case->MJ_lawmgt_get_open_all_case();
												}		
											}
											?>
											<?php if($edt){ $data=$casedata->case_id;}else{ $data=''; }?>
											<select class="form-control validate[required] case_id" name="case_id" id="case_id">				
												<option value=""><?php esc_html_e('Select Case Name','lawyer_mgt');?></option>
												<?php 
												foreach($result as $result1)
												{														
												  echo '<option value="'.esc_attr($result1->id).'" '.selected($data,$result1->id).'>'.esc_html($result1->case_name).'</option>';
												} ?>
											</select>
										</div>
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="practice_area_id"><?php esc_html_e('Practice Area','lawyer_mgt');?></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback practics">
											<input type="hidden" class="form-control" value="<?php if($edt){ echo esc_attr($casedata->practice_area_id);}?>" name="practice_area_id" id="practice_area_id" readonly />
											<input type="text" class="form-control" value="<?php if($edt){ echo esc_attr(get_the_title($casedata->practice_area_id)); }?>" name="practice_area_id1" id="practice_area_id1" readonly />
										</div>
									</div>
									<div class="header">
										<h3><?php esc_html_e('Event Information','lawyer_mgt');?></h3>
										<hr>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="task_name"><?php esc_html_e('Event Name','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="event_name" class="form-control validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input "   type="text" placeholder="<?php esc_html_e('Enter Event Name','lawyer_mgt');?>" value="<?php if($edt){ echo esc_attr($casedata->event_name);}elseif(isset($_POST['event_name'])){ echo esc_attr($_POST['event_name']); } ?>" name="event_name">
										</div>										
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin" for="start_date"><?php esc_html_e('Start Date','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="start_date" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date1 form-control  validate[required] has-feedback-left " type="text"  name="start_date"  placeholder="<?php esc_html_e('Select Start Date','lawyer_mgt');?>"
												value="<?php if($edt){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($casedata->start_date)); }elseif(isset($_POST['startdate'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['startdate'])); } ?>" readonly>
												<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
										</div>
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="start_time"><?php esc_html_e('Start Time','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="start_time"  class="time form-control  validate[required] has-feedback-left " type="text"  name="start_time"  placeholder=""
											value="<?php if($edt){ echo esc_attr($casedata->start_time); }elseif(isset($_POST['start_time'])){ echo esc_attr($_POST['start_time']); } ?>">
											<span class="fa fa-clock form-control-feedback left" aria-hidden="true"></span>
										</div>									
									</div>		
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin" for="end_date"><?php esc_html_e('End Date','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="end_date"  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date2 form-control validate[required]  has-feedback-left " type="text"  name="end_date"  placeholder="<?php esc_html_e('Select End Date','lawyer_mgt');?>"
												value="<?php if($edt){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($casedata->end_date)); }elseif(isset($_POST['end_date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['end_date'])); } ?>" readonly>
												<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
										</div>										
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="end_time"><?php esc_html_e('End Time','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="end_time"  class="time form-control  validate[required] has-feedback-left " type="text"  name="end_time"  placeholder=""
												value="<?php if($edt){ echo esc_attr($casedata->end_time);}elseif(isset($_POST['end_time'])){ echo esc_attr($_POST['end_time']); } ?>">
												<span class="fa fa-clock form-control-feedback left" aria-hidden="true"></span>
										</div>										
									</div>
									<div class="form-group">									
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin" for="pin_code"><?php esc_html_e('Description','lawyer_mgt');?><span class="require-field"></span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<textarea id="description" class="form-control validate[custom[address_description_validation],maxSize[150]]" type="text" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>"   value="" name="description"><?php if($edt){ echo esc_textarea($casedata->description); } ?></textarea>
										</div>									
									</div>									
									<?php
									if($edt)
									{
										$result_reminder=$event->MJ_lawmgt_get_single_event_reminder($event_id);				
										if(!empty($result_reminder))	
										{	
											foreach ($result_reminder as $retrive_data)
											{ 
											?>	
												<div id="reminder_entry">
													<div class="form-group">			
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin" for="SOL Reminders"><?php esc_html_e('Event Reminders','lawyer_mgt');?></label>
														<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
															<input type="hidden" name="casedata[id][]" value="<?php echo esc_attr($retrive_data->id);?>">
															<select name="casedata[type][]" id="case_reminder_types">
																<option selected="selected" value="mail" <?php if($retrive_data=='mail') { print ' selected'; }?>><?php echo esc_html($retrive_data->reminder_type); ?></option>
															</select>
														</div>
														<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback btn_margin">
														<input id="remindertimevalue" class="form-control text-input validate[required]" type="number"  value="<?php echo esc_attr($retrive_data->reminder_time_value); ?>" name="casedata[remindertimevalue][]" min="1">
														</div>
														<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback btn_margin">
														<select name="casedata[remindertimeformat][]" id="case_reminder_type">
															<?php 
																$reminder_value=$retrive_data->reminder_time_format;
																?>
																<option value="day" <?php if($reminder_value=='day') { print ' selected'; }?>><?php esc_html_e('Day(s)','lawyer_mgt'); ?></option>
																<option value="hour" <?php if($reminder_value=='hour') { print ' selected'; }?>><?php esc_html_e('Hour(s)','lawyer_mgt'); ?></option>																
														</select>
														</div>
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Event Start Date','lawyer_mgt') ?></label>
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
															<input type="button" value="<?php esc_attr_e('Remove','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger">
														</div>				
													</div>		
												</div>	
											<?php				
											}
										}
										else
										{
										?>
											 <div id="reminder_entry">
											 </div>
										<?php
										}	
										?>
										<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
											<input type="button" value="<?php esc_attr_e('Add Reminder','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_reminder()" class="add_reminder btn btn-success">
										</div>		
									<?php		
									}
									else
									{
									?>
										<div id="reminder_entry">
											<div class="form-group">	
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin"><?php esc_html_e('Event Reminders','lawyer_mgt');?></label>
												<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
													<select name="casedata[type][]" id="case_reminder_types">
														<option selected="selected" value="mail"><?php esc_html_e('Mail','lawyer_mgt') ?></option>
													</select>
												</div>
												<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback btn_margin">
												<input id="remindertimevalue" class="form-control text-input validate[required]" type="number"  value="1" name="casedata[remindertimevalue][]" min="1">
												</div>
												<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback btn_margin">
												<select name="casedata[remindertimeformat][]" id="case_reminder_type">
													<option selected="selected" value="day"><?php esc_html_e('Day(s)','lawyer_mgt') ?></option>
													<option value="hour"><?php esc_html_e('Hour(s)','lawyer_mgt') ?></option>													
												</select>
												</div>
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Event Start Date','lawyer_mgt') ?></label>
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
													<input type="button" value="<?php esc_html_e('Remove','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger">
												</div>		
											</div>		
										</div>				  
										<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
											<input type="button" value="<?php esc_attr_e('Add Reminder','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_reminder()" class="add_reminder btn btn-success">
										</div>	
									<?php 
									} 
									?>
									<div class="header">		
										<h3><?php esc_html_e('Address Information','lawyer_mgt');?></h3>			
										<hr>
									</div>
									<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="header">													
											<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="address"><?php esc_html_e('Address','lawyer_mgt');?><span class="require-field">*</span></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input id="address" class="form-control validate[required,custom[address_description_validation],maxSize[150]] has-feedback-left text-input"   type="text" placeholder="<?php esc_html_e('Enter Address','lawyer_mgt');?>" value="<?php if($edt){ echo esc_attr($casedata->address);}elseif(isset($_POST['address'])){ echo esc_attr($_POST['address']); } ?>" name="address">
													<span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
												</div>
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="state_name"><?php esc_html_e('State','lawyer_mgt');?><span class="require-field">*</span></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input id="state_name" class="form-control has-feedback-left validate[required,custom[city_state_country_validation],maxSize[50]]"  type="text"  name="state_name" placeholder="<?php esc_html_e('Enter State Name','lawyer_mgt');?>"
													value="<?php if($edt){ echo esc_attr($casedata->state_name);}elseif(isset($_POST['state_name'])) { echo esc_attr($_POST['state_name']); } ?>">
													<span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
												</div>
											</div>
												<?php wp_nonce_field( 'save_event_nonce' ); ?>
											<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin" for="city_name"><?php esc_html_e('City','lawyer_mgt');?><span class="require-field">*</span></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input id="city_name" class="form-control has-feedback-left validate[required,custom[city_state_country_validation],maxSize[50]]"  type="text"  name="city_name"  placeholder="<?php esc_html_e('Enter City Name','lawyer_mgt');?>"
													value="<?php if($edt){ echo esc_attr($casedata->city_name);}elseif(isset($_POST['city_name'])){ echo esc_attr($_POST['city_name']); } ?>">
													<span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
												</div>
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="pin_code"><?php esc_html_e('Pin Code','lawyer_mgt');?><span class="require-field">*</span></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input id="pin_code" class="form-control has-feedback-left validate[required,custom[onlyLetterNumber],maxSize[15]]"  type="text"  name="pin_code" placeholder="<?php esc_html_e('Enter Pin Code','lawyer_mgt');?>" 
													value="<?php if($edt){ echo esc_attr($casedata->pin_code);}elseif(isset($_POST['pin_code'])){ echo esc_attr($_POST['pin_code']); } ?>">
													<span class="fa fa-sort-numeric-down form-control-feedback left" aria-hidden="true"></span>
												</div>
											</div> 		
											<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin" for="priority"><?php esc_html_e('Priority','lawyer_mgt');?></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<select class="form-control " name="priority" id="priority">				
														<option value="0" <?php if($edt && $casedata->priority=='0') { print ' selected'; }?>><?php esc_html_e('High','lawyer_mgt');?></option>
														<option value="1" <?php if($edt && $casedata->priority=='1') { print ' selected'; }?>><?php esc_html_e('Low','lawyer_mgt');?></option>
														<option value="2" <?php if($edt && $casedata->priority=='2') { print ' selected'; }?>><?php esc_html_e('Medium','lawyer_mgt');?></option>
													</select>
												</div>			
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="Repeat"><?php esc_html_e('Repeat','lawyer_mgt');?></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<select class="form-control validate[required]" name="repeat" id="repeat">
														<option value="0" <?php if($edt && $casedata->repeat=='0') { print ' selected'; }?>><?php esc_html_e('Never','lawyer_mgt');?></option>
														<option value="1" <?php if($edt && $casedata->repeat=='1') { print ' selected'; }?>><?php esc_html_e('Every day','lawyer_mgt');?></option>
														<option value="2" <?php if($edt && $casedata->repeat=='2') { print ' selected'; }?>><?php esc_html_e('Every week','lawyer_mgt');?></option>
														<option value="3" <?php if($edt && $casedata->repeat=='3') { print ' selected'; }?>><?php esc_html_e('Every 2 weeks','lawyer_mgt');?></option>
														<option value="4" <?php if($edt && $casedata->repeat=='4') { print ' selected'; }?>><?php esc_html_e('Every month','lawyer_mgt');?></option>
														<option value="5" <?php if($edt && $casedata->repeat=='5') { print ' selected'; }?>><?php esc_html_e('Every year','lawyer_mgt');?></option>
													</select>
											   </div>
											</div>									  
											<div class="header">	
												<h3><?php esc_html_e('Attendees To','lawyer_mgt');?></h3>
												<hr>
											</div>
											<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="assigned_to_user"><?php esc_html_e('Client Name','lawyer_mgt');?><span class="require-field">*</span></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12has-feedback multiselect_validation">
													<?php 
													if($edt)
													{ 
															$data=$casedata->assigned_to_user;
													}
													elseif(isset($_POST['assigned_to_user']))  
													{
														$data=sanitize_text_field($_POST['assigned_to_user']);
													}
													?>
														<?php $conats=explode(',',$data);
														if(!empty($data))
														{
															$Editdata=MJ_lawmgt_get_user_by_edit_case_id($casedata->case_id);
														}													
														?>
														<select class="form-control validate[required] assigned_to_user" multiple="multiple" name="assigned_to_user[]" id="assigned_to_user">				
															<?php
															if(!empty($Editdata))
															{															
																foreach($Editdata as $Editdata1)
																{
																	$userdata=get_userdata($Editdata1->user_id);
																	$user_name=esc_html($userdata->display_name);	
																	?>
																	<option value="<?php print esc_attr($Editdata1->user_id);?>" <?php echo in_array($Editdata1->user_id,explode(',',$data)) ? 'selected': ''; ?>>
																		<?php echo esc_html($user_name);?>
																	</option>
																<?php
																}
															}
															 ?>
														</select>
												</div>
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="assigned_to_attorney"><?php esc_html_e('Attorney Name','lawyer_mgt');?><span class="require-field">*</span></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback multiselect_validation123">
													<?php if($edt){ $data=$casedata->assign_to_attorney;}elseif(isset($_POST['assign_to_attorney'])){ $data=sanitize_text_field($_POST['assign_to_attorney']); } ?>
														<?php $conats=explode(',',$data);
															if(!empty($data))
															{
																$Editdata=MJ_lawmgt_get_attorney_by_edit_case_id($casedata->case_id);
																
																$user_array=$Editdata[0]->case_assgined_to;
																  
																$newarraay=explode(',',$user_array);
															}
															?>
														<select class="form-control validate[required] assign_to_attorney" multiple="multiple" name="assign_to_attorney[]" id="assign_to_attorney">				
															<?php 
															foreach($newarraay as $retrive_data)
															{
																$user_details=get_userdata($retrive_data);
																$user_name=esc_html($user_details->display_name);	
															?>
															<option value="<?php print esc_attr($user_details->ID);?>" <?php echo in_array($user_details->ID,explode(',',$data)) ? 'selected': ''; ?>>
																<?php echo esc_html($user_name);?>
															</option>
															<?php 
															}	
															 ?>
														</select>
												</div>
											</div>									
										<div class="form-group margin_top_div_css1">
											<div class="offset-sm-2 col-sm-8">
												 <input type="submit" id="" name="saveevent" class="btn btn-success submitevent" value="<?php if($edt){
												   esc_attr_e('Save Event','lawyer_mgt');}else{ esc_attr_e('Add Event','lawyer_mgt');}?>"></input>
											</div>
										</div>
									</div>
								</form>
							</div>   <!-- END PANEL BODY DIV  -->     
						<?php 	
						}	 /*-- END ADD EVENT  TAB */
						if($active_tab == 'viewevent') /*-- VIEW EVENT  TAB */
						{
								$obj_case_tast= new MJ_lawmgt_case_tast;
								$event=new MJ_lawmgt_Event;

								if(isset($_REQUEST['id']))
									$event_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id']));
									if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
									{	
										$casedata=$resul=$event->MJ_lawmgt_get_signle_event_by_id($event_id);
									} 
									?>		
									<div class="panel-body margin_panel"> <!-- PANEL BODY  DIV -->
										<div class="header margin_cause">	
											<h3 class="first_hed"><?php esc_html_e('Linked To','lawyer_mgt');?></h3>
											<hr>
										</div>
										<div class="viewtaskdetails">				
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 event_detail_div">							
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
													<div class="table_row">
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
															<?php esc_html_e('Case Name','lawyer_mgt'); ?>
														</div>
														<div class="col-md-4 col-sm-12 table_td">
															<span class="txt_color">
																<?php
																$case_link=MJ_lawmgt_get_case_name($casedata->case_id);
																 echo esc_html($case_link);
																?>
															</span>
														</div>
													</div>
													<div class="table_row">
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
															<?php esc_html_e('Practice Area','lawyer_mgt'); ?>
														</div>
														<div class="col-md-4 col-sm-12 table_td">
															<span class="txt_color">
															<?php
																 echo esc_html(get_the_title(esc_html($casedata->practice_area_id)));
																?>
															</span>
														</div>
													</div>
												</div>
											</div>
											<div class="header">	
												<h3 class="first_hed"><?php esc_html_e('Event Information','lawyer_mgt');?></h3>
												<hr>
											</div>
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 event_detail_div">							
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
													<div class="table_row">
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
															<?php esc_html_e('Event Name','lawyer_mgt'); ?>
														</div>
														<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 table_td">
															<span class="txt_color">
															<?php									
																 echo esc_html($casedata->event_name);
																?>
															</span>
														</div>
													</div>
												</div>
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
													<div class="table_row">
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
															<?php esc_html_e('Start Date','lawyer_mgt'); ?>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
															<span class="txt_color">
															<?php
																 echo esc_html(MJ_lawmgt_getdate_in_input_box($casedata->start_date));
																?>
															</span>
														</div>
													</div>
													<div class="table_row">
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
															<?php esc_html_e('Start Time','lawyer_mgt'); ?>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
															<span class="txt_color">
															<?php
																 echo esc_html($casedata->start_time);
															?>
															</span>
														</div>
													</div>
												</div>
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
													<div class="table_row">
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
															<?php esc_html_e('End Date','lawyer_mgt'); ?>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
															<span class="txt_color">
																<?php
																	echo esc_html(MJ_lawmgt_getdate_in_input_box($casedata->end_date));
																?>
															</span>
														</div>
													</div>												
													<div class="table_row">
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
															<?php esc_html_e('End Time','lawyer_mgt'); ?>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
															<span class="txt_color">
															<?php
															 echo esc_html($casedata->end_time);
															?>
															</span>
														</div>
													</div>												
												</div>
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">													
													<div class="table_row">
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
															<?php esc_html_e('Description','lawyer_mgt'); ?>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
															<span class="txt_color">
															<?php
																if(!empty($casedata->description))
																{
																	 echo esc_html($casedata->description);
																}
																else{
																	 echo "-";
																}
																?>
															</span>
														</div>
													</div>		
													<div class="table_row">
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
															<?php esc_html_e('Address','lawyer_mgt'); ?>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
															<span class="txt_color">
															<?php
																 echo esc_html($casedata->address);
																?>
															</span>
														</div>
													</div>
												</div>
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
													<div class="table_row">
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
															<?php esc_html_e('State Name','lawyer_mgt'); ?>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
															<span class="txt_color">
															<?php
																 echo esc_html($casedata->state_name);
																?>
															</span>
														</div>
													</div>
													<div class="table_row">
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
															<?php esc_html_e('City Name','lawyer_mgt'); ?>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
															<span class="txt_color">
															<?php
																 echo esc_html($casedata->city_name);
																?>
															</span>
														</div>
													</div>
												</div>
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
													<div class="table_row">
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
															<?php esc_html_e('Pin Code','lawyer_mgt'); ?>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
															<span class="txt_color">
															<?php
																 echo esc_html($casedata->pin_code);
																?>
															</span>
														</div>
													</div>	
												</div>	
											</div>					
											<div class="header">	
												<h3 class="first_hed"><?php esc_html_e('Attendees To','lawyer_mgt');?></h3>
												<hr>
											</div>							
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 event_detail_div">							
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
													<div class="table_row">
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
															<?php esc_html_e('Client Name','lawyer_mgt'); ?>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
															<span class="txt_color">
															<?php
																$user=explode(",",$casedata->assigned_to_user);
																$user_name=array();
																if(!empty($user))
																{						
																	foreach($user as $data)
																	{
																		$user_name[]=esc_html(MJ_lawmgt_get_display_name($data));
																	}
																}			
																 echo esc_html(implode(",",$user_name));
																?>
															</span>
														</div>
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
															<?php esc_html_e('Attorney Name','lawyer_mgt'); ?>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
															<span class="txt_color">
															<?php
																$user=explode(",",$casedata->assign_to_attorney);
																$user_name=array();
																if(!empty($user))
																{						
																	foreach($user as $data)
																	{
																		$user_name[]=esc_html(MJ_lawmgt_get_display_name($data));
																	}
																}			
																 echo esc_html(implode(",",$user_name));
																?>
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>	
									</div><!-- END PANEL BODY  DIV -->
						 <?php 
						}	/*-- END VIEW EVENT TAB */
						 ?>
					</div>
				</div>
			</div>
		</div>
	</div><!-- end MAIN WRAPER  DIV -->
</div><!--  end PAGE INNER DIV -->