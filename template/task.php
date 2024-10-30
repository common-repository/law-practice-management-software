<?php 
MJ_lawmgt_browser_javascript_check();
if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
{
	//wp_redirect ( home_url() . '?dashboard=user');
	$redirect_url= home_url() . '?dashboard=user';
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
$obj_case=new MJ_lawmgt_case;
$obj_case_tast= new MJ_lawmgt_case_tast;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'tasklist');
$casedata=null;
?>
<div class="page_inner_front">
	
	<?php 	
	if(isset($_POST['savetast']))
	{	
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_task_nonce' ) )
		{ 
			if($_POST['action']=='edittask')
			{
				$result=$obj_case_tast->MJ_lawmgt_add_tast($_POST);
				if($result)
				{
					//wp_redirect (home_url().'?dashboard=user&page=task&tab=tasklist&message=2');
					$redirect_url= home_url().'?dashboard=user&page=task&tab=tasklist&message=2';
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
				$result=$obj_case_tast->MJ_lawmgt_add_tast($_POST);
				if($result)
				{
					//wp_redirect (home_url().'?dashboard=user&page=task&tab=tasklist&message=1');	
					$redirect_url= home_url().'?dashboard=user&page=task&tab=tasklist&message=1';
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
	if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='deletetask')
	{		
		$result=$obj_case_tast->MJ_lawmgt_delete_tast(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['task_id'])));		
		if($result)
		{
			//wp_redirect ( home_url() . '?dashboard=user&page=task&tab=tasklist&message=3');
			$redirect_url= home_url() . '?dashboard=user&page=task&tab=tasklist&message=3';
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
	if(isset($_POST['task_delete_selected']))
	{
		if (isset($_REQUEST['selected_id']))
		{
            $selected_id_filter = array_map( 'sanitize_text_field', wp_unslash( $_REQUEST["selected_id"] ));			
			$all = implode(",", $selected_id_filter);			
			$result=$obj_case_tast->MJ_lawmgt_delete_selected_task($all);	
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
			//wp_redirect ( home_url() . '?dashboard=user&page=task&tab=tasklist&message=3');
			$redirect_url= home_url() . '?dashboard=user&page=task&tab=tasklist&message=3';
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
			<?php esc_html_e('Task Inserted Successfully','lawyer_mgt');?>
			</div>
		<?php 			
		}
		elseif($message == 2)
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<?php esc_html_e('Task Updated Successfully','lawyer_mgt');?>
			</div>
			<?php 			
		}
		elseif($message == 3) 
		{
		?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
		 <?php esc_html_e('Task Delete Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
	} 		
	?>
	<div id="main-wrapper">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white">
					<div class="panel-body panel_body_flot_css">
						<h2 class="nav-tab-wrapper">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="tablist">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'tasklist' ? 'active' : ''; ?> menucss">
									<a href="?dashboard=user&page=task&tab=tasklist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Task List', 'lawyer_mgt'); ?>
									</a>
								</li>
								
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_task' ? 'active' : ''; ?> menucss">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edittask')
								{?>
								<a href="?dashboard=user&page=task&tab=add_task&action=edittask&task_id=<?php echo esc_attr($_REQUEST['task_id']);?>">
									<?php esc_html_e('Edit Task', 'lawyer_mgt'); ?>
								</a>  
								<?php 
								}
								else
								{	
									if($user_access['add']=='1')
									{
										?>
										<a href="?dashboard=user&page=task&tab=add_task&&action=insert">
											<?php echo '<span class="fa fa-plus-circle"></span> '.esc_html__('Add Task', 'lawyer_mgt');?>
										</a>  
									<?php  
									}
								}
								?>
								</li>
								
								<?php if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view_task'){?>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'view_task' ? 'active' : ''; ?> menucss">
									<a href="?dashboard=user&page=task&tab=view_task&action=view_task&task_id=<?php echo esc_attr($_REQUEST['task_id']);?>">
										<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('View Task', 'lawyer_mgt'); ?>
									</a>
								</li>
								<?php } ?>			
							</ul>
						</h2>
						<?php 
						if($active_tab == 'tasklist')
						{ 
						?>
							<script type="text/javascript">
								jQuery(document).ready(function($)
								{
									"use strict"; 
									jQuery('#case_tast_list').DataTable({
										"responsive": true,
										"autoWidth": false,
										"order": [[ 1, "asc" ]],
										language:<?php echo wpnc_datatable_multi_language();?>,
										 "aoColumns":[								  
													  {"bSortable": false},
													  {"bSortable": true},
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
									$('.sdate').datepicker({
			 
										autoclose: true
									}).on('changeDate', function(){
										$('.edate').datepicker('setStartDate', new Date($(this).val()));
									}); 
									
									 
									$('.edate').datepicker({
										 
										autoclose: true
									}).on('changeDate', function(){
										$('.sdate').datepicker('setEndDate', new Date($(this).val()));
									});
								});	
								jQuery(document).ready(function($) 
								{
									"use strict"; 
									jQuery('#tast_list').validationEngine();
								} );
							</script>	
							<div class="tab-pane  tabs fade  active in" id="nav-open" role="tabpanel" aria-labelledby="nav-open-tab">
							<div class="panel-body">
								<form name="tast_list" action="" method="post" enctype='multipart/form-data'>
									<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label filter_lable_task"><?php esc_html_e('Filter By Due Date :','lawyer_mgt');?></label>
										<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12" >
											<input type="text" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>"  class="form-control sdate has-feedback-left validate[required]" name="sdate" placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>
											value="<?php if(isset($_REQUEST['sdate'])) echo esc_attr($_REQUEST['sdate']);?>" readonly>
											<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
										</div>
										<label class="col-lg-1 col-md-1 col-sm-1 col-xs-12 control-label  filter_lable_task_to"><?php esc_html_e('To','lawyer_mgt');?></label>
										<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
												<input type="text"  class="form-control edate has-feedback-left validate[required]" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>"  name="edate" placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>
												value="<?php if(isset($_REQUEST['edate'])) echo esc_attr($_REQUEST['edate']);?>" readonly>
												<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
										</div>
									<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12 button-possition">
										<label for="subject_id">&nbsp;</label>
										<input type="button" name="filter_task" id="filter_task_duedate" Value="<?php esc_attr_e('Go','lawyer_mgt');?>"  class="btn btn-success filter_task_duedate btn-go"/>
									</div>
								</div>
								<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<table id="case_tast_list" class="tast_list1 table table-striped table-bordered">
												<thead>												
												<tr>
													<th><input type="checkbox" id="select_all"></th>
													<th><?php  esc_html_e('Task Name', 'lawyer_mgt' ) ;?></th>
													<th><?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Due Date', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Status', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Priority', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Assign To Client', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Assign To Attorney', 'lawyer_mgt' ) ;?></th>
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
																$casedata=$obj_case_tast->MJ_lawmgt_get_all_case_tast_by_attorney();
															}
															else
															{
																$casedata=$obj_case_tast->MJ_lawmgt_get_all_case_tast();	
															}		
														}
														elseif($user_role == 'client')
														{
															if($user_access['own_data'] == '1')
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
															if($user_access['own_data'] == '1')
															{
																$casedata=$obj_case_tast->MJ_lawmgt_get_all_case_tast_created_by();
															}
															else
															{
																$casedata=$obj_case_tast->MJ_lawmgt_get_all_case_tast();
															}																
														}		
														if(!empty($casedata))
														{
														
															foreach ($casedata as $retrieved_data)
															{
																$user_id=$retrieved_data->assigned_to_user;
																$contac_id=explode(',',$user_id);
																$user_name=array();
																foreach($contac_id as $contact_name) 
																{															
																	$userdata=get_userdata($contact_name);													
																	$user_name[]=esc_html($userdata->display_name);
																}
																$attorney=$retrieved_data->assign_to_attorney;
																$attorney_name=explode(',',$attorney);
																$attorney_name1=array();
																foreach($attorney_name as $attorney_name2) 
																{
																	$attorneydata=get_userdata($attorney_name2);	
																		
																	$attorney_name1[]=esc_html($attorneydata->display_name);										   
																}
																$case_name=MJ_lawmgt_get_case_name_by_id($retrieved_data->case_id);
																foreach($case_name as $case_name1)
																{
																	$case_name2=esc_html($case_name1->case_name);
																}
																	
																 if($retrieved_data->status==0){
																 $statu='Not Completed';
																 }else if($retrieved_data->status==1){
																 $statu='Completed';
																 }else{
																 $statu='In Progress';
																 }
																 if($retrieved_data->priority==0){
																 $prio='High';
																 }else if($retrieved_data->priority==1){
																 $prio='Low';
																 }else{
																 $prio='Medium';
																 }
																?>
																<tr>
																	<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_attr(($retrieved_data->task_id)); ?>"></td>								
																	<td class="email"><?php echo esc_html($retrieved_data->task_name);?></td>
																	<td class="prac_area"><a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>"><?php echo esc_html($case_name2); ?></a></td>	
																	<td class="added"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->due_date));?></td>						 
																	<td class="added"><?php echo esc_html($statu);?></td>
																	<td class="contact_link"><?php echo esc_html($prio); ?></td>

																	<td class="added"><?php echo  esc_html(implode($user_name,','));?>
																	<td class="added"><?php echo  esc_html(implode($attorney_name1,','));?>
																	</td>
																	<td class="action"> 
																		<a href="?dashboard=user&page=task&tab=view_task&action=view_task&task_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->task_id));?>" id='view_task_user' class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
																	<?php
																	if($user_access['edit']=='1')
																	{
																	?>		
																	   <a href="?dashboard=user&page=task&tab=add_task&action=edittask&task_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->task_id));?>" id='edit_task_user' class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
																	<?php
																	}
																	if($user_access['delete']=='1')
																	{
																	?>	
																		<a href="?dashboard=user&page=task&tab=tasklist&action=deletetask&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&task_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->task_id));?>" class="btn btn-danger" 
																			onclick="return confirm('<?php esc_html_e('Are you sure you want to Delete this Task ?','lawyer_mgt');?>');">
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
												if(!empty($casedata))
												{
														
													?>	
													<div class="form-group">		
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
															<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="task_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
														</div>
													</div>
													<?php
												}
											}
											?>		
										</div>
									</div>       
								</form>
							</div>
						<?php 
						} 
						if($active_tab == 'add_task')
						{			
								$obj_case_tast= new MJ_lawmgt_case_tast;
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
										jQuery('#task_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
										var date = new Date();
										date.setDate(date.getDate()-0);
										jQuery('.date1').datepicker
										({
											startDate: date,
											autoclose: true
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
										$(".tasksubmit").on("click",function()
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
										 
										$(".tasksubmit").on("click",function()
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
										$("#reminder_entry").append('<div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" ><?php esc_html_e('Task Reminders','lawyer_mgt');?></label><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback"><select name="casedata[type][]" id="case_reminder_type"><option selected="selected" value="mail"><?php esc_html_e('Mail','lawyer_mgt');?></option></select></div><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 btn_margin has-feedback"><input id="remindertimevalue" class="form-control text-input validate[required]" type="number"  value="1" name="casedata[remindertimevalue][]" min="1"></div><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback btn_margin"><select name="casedata[remindertimeformat][]" id="case_reminder_type"><option selected="selected" value="day"><?php esc_html_e('Day(s)','lawyer_mgt');?></option><option value="hour"><?php esc_html_e('Hour(s)','lawyer_mgt');?></option></select></div><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Task Due Date','lawyer_mgt');?></label><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger"></div></div>');   		
									}
									function MJ_lawmgt_deleteParentElement(n)
									{
										"use strict"; 
										alert("<?php esc_html_e('Do you really want to delete this ?','lawyer_mgt');?>");
										n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
									}
								</script>
								<?php 
								$case_id=0;
								$edt=0;
								if(isset($_REQUEST['task_id']))
									$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['task_id']));
									if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edittask')
									{					
										$edt=1;
										$casedata=$obj_case_tast->MJ_lawmgt_get_all_edit_tast($case_id);
									}?>
								<?php                
												  
									$args = array(	
												'role' => 'client',
												'meta_key'     => 'archive',
												'meta_value'   => '0',
												'meta_compare' => '=',
											); 	
										$result =get_users($args);	
								?>								
								<div class="panel-body margin_task">
									<form name="task_form" action="" method="post" class="form-horizontal" id="task_form" enctype='multipart/form-data'>	
									   <?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
										<input id="action" class="form-control  text-input" type="hidden"  value="<?php if($edt){ echo 'edittask'; }else{ echo  esc_attr($action); }?>" name="action">
										<input type="hidden" name="case_id" value="<?php echo esc_attr($case_id);?>"  />
										<input type="hidden" name="task_id" id="task_id" value="<?php if($edt){ echo esc_attr($casedata->task_id);}?>"  />
										<div class="header">	
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
												if($edt){ $data=$casedata->case_id;}else{ $data=''; }?>
												
												<select class="form-control validate[required] case_id" name="case_id" id="case_id">				
													<option value=""><?php esc_html_e('Select Case Name','lawyer_mgt');?></option>
													<?php 
													foreach($result as $result1)
													{
														echo '<option value="'.$result1->id.'" '.selected($data,$result1->id).'>'.$result1->case_name.'</option>';
													} ?>
												</select>
											</div>
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="practice_area_id"><?php esc_html_e('Practice Area','lawyer_mgt');?></label>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback practics" id="practics">
												<input type="hidden" class="form-control" value="<?php if($edt){ echo esc_attr($casedata->practice_area_id);}?>" name="practice_area_id" id="practice_area_id" readonly />
												<input type="text" class="form-control" value="<?php if($edt){ echo esc_attr(get_the_title($casedata->practice_area_id)); }?>" name="practice_area_id1" id="practice_area_id1" readonly />
											</div>
										</div>
										<div class="header">
											<h3><?php esc_html_e('Task Information','lawyer_mgt');?></h3>
											<hr>
										</div>
										<div class="form-group">
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="task_name"><?php esc_html_e('Task Name','lawyer_mgt');?><span class="require-field">*</span></label>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
												<input id="task_name" class="form-control  validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input" type="text" placeholder="<?php esc_html_e('Enter Task Name','lawyer_mgt');?>" value="<?php if($edt){ echo esc_attr($casedata->task_name);}elseif(isset($_POST['task_name'])){ echo esc_attr($_POST['task_name']); } ?>" name="task_name">
											</div>
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="due_date"><?php esc_html_e('Due Date','lawyer_mgt');?><span class="require-field">*</span></label>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
												<input id="due_date"  class="date1 form-control validate[required]  has-feedback-left " data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" type="text"  name="due_date"  placeholder="<?php esc_html_e('Select Due Date','lawyer_mgt');?>"
													value="<?php if($edt){ echo MJ_lawmgt_getdate_in_input_box($casedata->due_date);}elseif(isset($_POST['due_date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['due_date'])); } ?>" readonly>
													<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
											</div>
										</div>
										<?php wp_nonce_field( 'save_task_nonce' ); ?>
										<div class="form-group">
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="city_name"><?php esc_html_e('Status','lawyer_mgt');?><span class="require-field">*</span></label>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
												<select class="form-control validate[required]" name="status" id="status">				
													<?php 
													if($edt)
													{
													?>
														<option value="0" <?php if($edt && $casedata->status=='0') { print ' selected'; }?>><?php esc_html_e('Not Completed','lawyer_mgt');?></option>
														<option value="1" <?php if($edt && $casedata->status=='1') { print ' selected'; }?>><?php esc_html_e('Completed','lawyer_mgt');?></option>
													<?php
													}
													?>
													<option value="2" <?php if($edt && $casedata->status=='2') { print ' selected'; }?>><?php esc_html_e('In Progress','lawyer_mgt');?></option>
												</select>
											</div>
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="pin_code"><?php esc_html_e('Description','lawyer_mgt');?><span class="require-field"></span></label>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
												<textarea id="description1" class="form-control validate[custom[address_description_validation],maxSize[150]]" type="text" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>"  value="" name="description"><?php if($edt){ echo esc_textarea($casedata->description); } ?></textarea></div>
										</div>
										<div class="form-group">
											<div class="header">
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
													<?php if(!empty($casedata->repeat)) 
													   {
														   $repeatdata=$casedata->repeat;
													   }
													   else
													   {
															$repeatdata="";
													   }
													   ?>
												   <div class="form-group repeatuntil_div display_block_css" <?php if($edt && $repeatdata =='1' ||  $repeatdata=='2' ||  $repeatdata=='3' ||  $repeatdata=='4' ||  $repeatdata=='5') { ?> <?php }?>>
												   <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label "><?php esc_html_e('Repeat Until','lawyer_mgt');?></label>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
														<input id="repeatuntil"  class="date1 form-control validate[required]  has-feedback-left " data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" type="text"  name="repeatuntil"  placeholder=""
														value="<?php if($edt){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($casedata->repeat_until));}elseif(isset($_POST['repeat_until'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['repeat_until'])); } ?>">
														<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
													</div>
												</div>
												<?php
												if($edt)
												{
													$task_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['task_id']));
													$result_reminder=$obj_case_tast->MJ_lawmgt_get_single_task_reminder($task_id);				
													if(!empty($result_reminder))	
													{	
														foreach ($result_reminder as $retrive_data)
														{ 
														?>	
															<div id="reminder_entry">
																<div class="form-group">			
																	<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin"><?php esc_html_e('Task Reminders','lawyer_mgt');?></label>
																	<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback ">
																		<input type="hidden" name="casedata[id][]" value="<?php echo $retrive_data->id;?>">
																		<select name="casedata[type][]" id="case_reminder_types">
																			<option selected="selected" value="mail" <?php if($retrive_data=='mail') { print ' selected'; }?>><?php echo $retrive_data->reminder_type;?></option>
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
																	<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Task Due Date','lawyer_mgt') ?></label>
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
															<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin"><?php esc_html_e('Task Reminders','lawyer_mgt');?></label>
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
															<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Before Task Due Date','lawyer_mgt') ?></label>
															<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																<input type="button" value="<?php esc_attr_e('Remove','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger">
															</div>		
														</div>		
													</div>				  
													<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
														<input type="button" value="<?php esc_attr_e('Add Reminder','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_reminder()" class="add_reminder btn btn-success">
													</div>	
												<?php 
												} 
												?>
												<div class="header margin_task_to">	
													<h3><?php esc_html_e('Assign To','lawyer_mgt');?></h3>
													<hr>
												</div>
												<div class="form-group">
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="assigned_to_user"><?php esc_html_e('Client Name','lawyer_mgt');?><span class="require-field">*</span></label>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback multiselect_validation">
														<?php if($edt){ $data=$casedata->assigned_to_user;}elseif(isset($_POST['assigned_to_user'])){ $data=sanitize_text_field($_POST['assigned_to_user']); }?>
														<?php $conats=explode(',',$data);
															if(!empty($data))
															{
																$Editdata=MJ_lawmgt_get_user_by_edit_case_id($casedata->case_id);
															}														
															?>
														<select class="form-control validate[required] assigned_to_user" multiple="multiple" name="assigned_to_user[]" id="assigned_to_user">				
															<?php 
															foreach($Editdata as $Editdata1)
															{
																$userdata=get_userdata($Editdata1->user_id);
																$user_name=esc_html($userdata->display_name);	
															?>
															<option value="<?php print esc_attr($Editdata1->user_id);?>" <?php echo in_array($Editdata1->user_id,explode(',',$data)) ? 'selected': ''; ?>>
																<?php echo esc_html($user_name); ?>
															</option>
															<?php 
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
														  <input type="submit" id="" name="savetast" class="btn btn-success tasksubmit" value="<?php if($edt){
														   esc_attr_e('Save Task','lawyer_mgt');}else{ esc_attr_e('Add Task','lawyer_mgt');}?>"></input>
													</div>
												</div>
											</div>
										</div>
								</form>							
							</div>
						<?php		
						}	
						if($active_tab == 'view_task')
						{
						?>
							<style>
								.task_detail_div
								{
									border: 1px solid #ddd;
									margin: 15px 0px;
									padding: 10px;
								}
								.table_row .table_td 
								{
								  padding: 10px 10px !important;
								}	
							</style>
							<?php 
							$obj_case_tast= new MJ_lawmgt_case_tast;

							if(isset($_REQUEST['task_id']))
								$task_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['task_id']));
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view_task')
								{	
									$casedata=$obj_case_tast->MJ_lawmgt_get_all_edit_tast($task_id);
								} 
								?>		
								<div class="panel-body">
									<div class="header margin_panel_cases">	
										<h3 class="first_hed"><?php esc_html_e('Linked To','lawyer_mgt');?></h3>
										<hr>
									</div>
									<div class="viewtaskdetails">				
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 task_detail_div">							
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
														<?php esc_html_e('Case Name','lawyer_mgt'); ?>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
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
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
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
											<h3 class="first_hed"><?php esc_html_e('Task Information','lawyer_mgt');?></h3>
											<hr>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 task_detail_div">							
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
														<?php esc_html_e('Task Name','lawyer_mgt'); ?>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<span class="txt_color">
														<?php									
															 echo esc_html($casedata->task_name);
															?>
														</span>
													</div>
												</div>
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
														<?php esc_html_e('Due Date','lawyer_mgt'); ?>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<span class="txt_color">
														<?php
															 echo esc_html(MJ_lawmgt_getdate_in_input_box($casedata->due_date));
															?>
														</span>
													</div>
												</div>
											</div>
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
														<?php esc_html_e('Status','lawyer_mgt'); ?>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<span class="txt_color">
														<?php
															if($casedata->status == '0')
															{
																$status="Not Completed";	
															}
															elseif($casedata->status == '1')
															{
																$status="Completed";	
															}
															elseif($casedata->status == '2')
															{
																$status="In Progress";	
															}
															
															 echo esc_html($status);
															?>
														</span>
													</div>
												</div>
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
											</div>
										</div>					
										<div class="header">	
											<h3 class="first_hed"><?php esc_html_e('Assign To','lawyer_mgt');?></h3>
											<hr>
										</div>							
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 task_detail_div">							
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
								</div>
						<?php			
						}		 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>