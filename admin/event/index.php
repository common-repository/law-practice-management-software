<?php 	
$event=new MJ_lawmgt_Event;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'eventlist');
$result=null;
?>
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV -->
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' )); ?></h3>
	  </div>
	</div>
	<?php 
	if(isset($_POST['saveevent']))
	{
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_event_nonce' ) )
		{ 
			if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='edit')
			{
				 $result=$event->MJ_lawmgt_add_event($_POST);
				 if($result)
				 {
					//wp_redirect (admin_url(). 'admin.php?page=event&tab=eventlist&message=2');
					$redirect_url=admin_url().'admin.php?page=event&tab=eventlist&message=2';
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
					//wp_redirect (admin_url(). 'admin.php?page=event&tab=eventlist&message=1');
				    $redirect_url=admin_url().'admin.php?page=event&tab=eventlist&message=1';
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
			$case_id=$_REQUEST['case_id'];
			//wp_redirect (admin_url(). 'admin.php?page=event&tab=eventlist&message=3');
			$redirect_url=admin_url().'admin.php?page=event&tab=eventlist&message=3';
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
		if (isset($_REQUEST['selected_id']))
		{	
			$selected_id = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ) );
			$all = implode(",", $selected_id);			
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
			//wp_redirect (admin_url(). 'admin.php?page=event&tab=eventlist&message=3');
			$redirect_url=admin_url().'admin.php?page=event&tab=eventlist&message=3';
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
		$message = sanitize_text_field($_REQUEST['message']);
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
	<div id="main-wrapper">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<h2 class="nav-tab-wrapper">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="add_event">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'eventlist' ? 'active' : ''; ?> menucss">
									<a href="?page=event&tab=eventlist">
									<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Event List', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_event' ? 'active' : ''; ?> menucss">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
								{?>
									<a href="?page=event&tab=add_event&action=edit&id=<?php echo esc_attr($_REQUEST['id']);?> ">
										<?php esc_html_e('Edit Event', 'lawyer_mgt'); ?>
									</a>  
								<?php 
								}
								else
								{?>
									<a href="?page=event&tab=add_event">
										<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Event', 'lawyer_mgt');?>
									</a>  
								<?php  
								}?>
								</li>		
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
								{?>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'viewevent' ? 'active' : ''; ?> menucss">
									<a href="?page=event&tab=viewevent&action=view&id=<?php echo esc_attr($_REQUEST['id']);?>">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('View Event', 'lawyer_mgt'); ?>
									</a>
								</li>
								<?php
								}
								?>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'eventactivity' ? 'active' : ''; ?> menucss">
									<a href="?page=event&tab=eventactivity">
									<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('Event Activity', 'lawyer_mgt'); ?>
									</a>
								</li>
							</ul>
						</h2>
						<?php
						if($active_tab == 'add_event')
						{
						   require_once LAWMS_PLUGIN_DIR. '/admin/event/addevent.php';	   
						}
						if($active_tab == 'eventactivity')
						{
						  require_once LAWMS_PLUGIN_DIR. '/admin/event/event_activity.php';	   
						}
						if($active_tab == 'viewevent')
						{
						   require_once LAWMS_PLUGIN_DIR. '/admin/event/view_event.php';						   
						}
						if($active_tab=='eventlist')
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
									jQuery('#event_list').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
								});
							</script>
							<form name="" action="" method="post" enctype='multipart/form-data'>
							<div class="panel-body">
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
											
											$eventdata=$event->MJ_lawmgt_get_all_event_by_id(); 
											if(!empty($eventdata))
											{					   
												foreach ($eventdata as $retrieved_data)
												{	
													$case_name=MJ_lawmgt_get_case_name_by_id(esc_attr($retrieved_data->case_id));
													foreach($case_name as $case_name1)
													{
														$case_name2= esc_attr($case_name1->case_name);
													}												
													$user_id = esc_attr($retrieved_data->assigned_to_user);
													$contac_id=explode(',',$user_id);
													$conatc_name=array();
													foreach($contac_id as $contact_name)
													{	
														$userdata=get_userdata($contact_name);
														$conatc_name[]=$userdata->display_name;										   
													}
												$attorney= esc_attr($retrieved_data->assign_to_attorney);
												$attorney_name=explode(',',$attorney);
												$attorney_name1=array();
												foreach($attorney_name as $attorney_name2) 
												{
													$attorneydata=get_userdata($attorney_name2);	
														
													$attorney_name1[]=$attorneydata->display_name;										   
												}
													?>
													<tr>	
														<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->event_id); ?>"></td>												
														 <td><a href="admin.php?page=event&tab=viewevent&action=view&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->event_id));?>"><?php echo esc_html($retrieved_data->event_name);?></a></td>
														 <td class="prac_area"><a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>"><?php echo esc_html($case_name2); ?></a></td>	
														<td class="added"><?php echo esc_html(get_the_title($retrieved_data->practice_area_id));?></td>	
														
														<td class="added"><?php echo esc_html(implode(',',$conatc_name));?></td>
														<td class="added"><?php echo esc_html(implode(',',$attorney_name1));?></td>
																			
														<td class="added"><?php echo  esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->start_date).' '.$retrieved_data->start_time);?></td>
														<td class="added"><?php echo  esc_html($retrieved_data->address);?></td>						
														 <td class="action"> 		
														<a href="admin.php?page=event&tab=viewevent&action=view&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->event_id));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>						 
														<a href="admin.php?page=event&tab=add_event&action=edit&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->event_id));?>" id="ediit" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
														<a href="admin.php?page=event&tab=eventlist&deleteevent=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->event_id));?>" class="btn btn-danger" 
															onclick="return confirm('<?php esc_html_e('Are you sure you want to Delete this Event ?','lawyer_mgt');?>');">
														  <?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>					
														  </td>               
													</tr>
										<?php 	} 			
											} ?>     
										</tbody>
									</table>
									<?php
									if(!empty($eventdata))
										{									
									?>
									<div class="form-group">		
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
											<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="event_delete_selected"  value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
										</div>
									</div>
									<?php }?>
								</div>
							 </div> 
							</form>	
						<?php 
						}	
						?>
					</div>
				</div>
			</div>
		</div>
    </div><!-- END  MAIN WRAPER  DIV -->
</div><!-- END  INNER PAGE  DIV -->