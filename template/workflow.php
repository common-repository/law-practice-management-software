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
		if (isset ( $_REQUEST ['page']) && sanitize_text_field($_REQUEST ['page']) == $user_access['page_link'] && (sanitize_text_field($_REQUEST['action'])=='edit'))
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
$obj_workflow=new MJ_lawmgt_workflow;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'workflowlist');
$result=null;
?>
<div class="page_inner_front"><!--  PAGE INNER DIV -->
	<?php 
	if(isset($_POST['save_workflow']))
	{
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_workflow_nonce' ) )
		{ 
			if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='edit')
			{ 
				$result=$obj_workflow->MJ_lawmgt_add_workflow($_POST);
			
				if($result)
				{
					//wp_redirect (home_url().'?dashboard=user&page=workflow&tab=workflowlist&message=2');
					$redirect_url=home_url().'?dashboard=user&page=workflow&tab=workflowlist&message=2';
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
				$result=$obj_workflow->MJ_lawmgt_add_workflow($_POST);
				if($result)
				{
					//wp_redirect (home_url().'?dashboard=user&page=workflow&tab=workflowlist&message=1');
					$redirect_url=home_url().'?dashboard=user&page=workflow&tab=workflowlist&message=1';
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
	if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='delete')
	{		
		$result=$obj_workflow->MJ_lawmgt_delete_workflow(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['workflow_id'])));
		
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);			
			//wp_redirect (home_url().'?dashboard=user&page=workflow&tab=workflowlist&message=3');
			$redirect_url=home_url().'?dashboard=user&page=workflow&tab=workflowlist&message=3';
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
	if(isset($_POST['workflow_delete_selected']))
	{
		if (isset($_POST["selected_id"]))
		{	
	        $selected_id_filter = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ));
			$all = implode(",", $selected_id_filter);			
			$result=$obj_workflow->MJ_lawmgt_delete_selected_workflow($all);	
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
			//wp_redirect (home_url().'?dashboard=user&page=workflow&tab=workflowlist&message=3');
			$redirect_url=home_url().'?dashboard=user&page=workflow&tab=workflowlist&message=3';
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
			<?php esc_html_e('Workflow Inserted Successfully','lawyer_mgt');?>
			</div>
		<?php 			
		}
		elseif($message == 2)
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<?php esc_html_e('Workflow Updated Successfully','lawyer_mgt');?>
			</div>
				<?php 			
		}
		elseif($message == 3) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Workflow Delete Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
	} 		
	?>
	<div id="main-wrapper"><!-- MAIN WRAPER DIV -->
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<h2 class="nav-tab-wrapper margin_bottom_jugdment">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="workflow">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'workflowlist' ? 'active' : ''; ?> menucss active_mt">
									<a href="?dashboard=user&page=workflow&tab=workflowlist">
									<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Workflow List', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_workflow' ? 'active' : ''; ?> menucss">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
								{?>
									<a href="?dashboard=user&page=workflow&tab=add_workflow&action=edit&workflow_id=<?php echo esc_attr($_REQUEST['workflow_id']);?>">
									<?php esc_html_e('Edit Workflow', 'lawyer_mgt'); ?>
									</a>  
								<?php 
								}
								else
								{
									if($user_access['add']=='1')
									{
										?>
										<a href="?dashboard=user&page=workflow&tab=add_workflow&&action=insert">
										<?php echo '<span class="fa fa-plus-circle"></span> '.esc_html__('Add Workflow', 'lawyer_mgt');?>
										</a>  
									<?php
									}  
								}
								?>
								</li>
								<?php
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
								{
								?>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'view_workflow' ? 'active' : ''; ?> menucss">
									<a href="?dashboard=user&page=workflow&tab=view_workflow&action=view&workflow_id=<?php echo esc_attr($_REQUEST['workflow_id']);?>">
									<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('View Workflow', 'lawyer_mgt'); ?>
									</a>
								</li>
								<?php
								}
								?>			
							</ul>
						</h2>
						<?php	
						if($active_tab=='workflowlist')
						{?>
							<script type="text/javascript">
								jQuery(document).ready(function($)
								{
									"use strict"; 
									jQuery('#workflow_list').DataTable({
										"responsive": true,
										"autoWidth": false,
									"order": [[ 1, "asc" ]],
									language:<?php echo wpnc_datatable_multi_language();?>,
									"aoColumns":[								 
											  {"bbSortable": false},
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
							</script>
							<form name="" action="" method="post" enctype='multipart/form-data'>
							<div class="panel-body margin_panel_cases">
								<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">	
									<table id="workflow_list" class="table table-striped table-bordered">
										<thead>					
											<tr>
											<th><input type="checkbox" id="select_all"></th>	
											<th><?php  esc_html_e('Workflow Name', 'lawyer_mgt' ) ;?></th>
											<th><?php esc_html_e('Permission', 'lawyer_mgt' ) ;?></th>
											<th><?php esc_html_e('Attorney Name', 'lawyer_mgt' ) ;?></th>
											<th><?php esc_html_e('Created Date', 'lawyer_mgt' ) ;?></th>
											<th> <?php esc_html_e('Created By', 'lawyer_mgt' ) ;?></th>					
											<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
											</tr>				
										</thead>
										<tbody>
											<?php
											if($user_role == 'attorney')
											{	
												if($user_access['own_data'] == '1')
												{
													$workflowdata=$obj_workflow->MJ_lawmgt_get_all_workflow_by_attorney(); 
												}
												else
												{
													$workflowdata=$obj_workflow->MJ_lawmgt_get_all_workflow(); 
												}	
											}
											else
											{
												if($user_access['own_data'] == '1')
												{
													$workflowdata=$obj_workflow->MJ_lawmgt_get_all_workflow_created_by(); 
												}
												else
												{
													$workflowdata=$obj_workflow->MJ_lawmgt_get_all_workflow(); 
												}											
											}
											if(!empty($workflowdata))
											{					   
												foreach ($workflowdata as $retrieved_data)
												{			
													$user_name=get_userdata($retrieved_data->created_by);
													$attorney_name=esc_html(MJ_lawmgt_get_display_name($retrieved_data->assgined_to));
												?>
												<tr>
													<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_attr($retrieved_data->id); ?>"></td>												
													<td class="added"><?php echo esc_html($retrieved_data->name);?></td>
													<td class="added"><?php echo esc_html($retrieved_data->permission);?></td>
													<td class="added"><?php echo esc_html($attorney_name);?></td>
													<td class="added"><?php echo esc_html($retrieved_data->created_date);?></td>
													<td class="added"><?php echo esc_html($user_name->display_name);?></td>
													<td class="action"> 	
														<a href="?dashboard=user&page=workflow&tab=view_workflow&action=view&workflow_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>"  class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
														<?php
														if($user_access['edit']=='1')
														{
															?>
															<a href="?dashboard=user&page=workflow&tab=add_workflow&action=edit&workflow_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" id="ediit" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a><?php
														}
														if($user_access['delete']=='1')
														{
															?>											
															<a href="?dashboard=user&page=workflow&tab=workflowlist&action=delete&workflow_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" 
															onclick="return confirm('<?php esc_html_e('Are you sure you want to Delete this workflow ?','lawyer_mgt');?>');">
															  <?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>	
														<?php
														}
														?>
													  </td>               
												</tr>
											<?php
												} 			
											} ?>     
										</tbody>
									</table>
									<?php
									if($user_access['delete']=='1')
									{
										if(!empty($workflowdata))
										{
											?>
											<div class="form-group">		
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
													<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="workflow_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
												</div>
											</div>
											<?php 
										}
									}
									?>
								</div>
							</div> 
							</form>		
						<?php 
						}
						if($active_tab == 'add_workflow')
						{
							$obj_workflow=new MJ_lawmgt_workflow;
							?>
							<script type="text/javascript">
						     	var $ = jQuery.noConflict();
								jQuery(document).ready(function($)
								{
									"use strict"; 
									$('#workflow_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
								});
								"use strict"; 
								var value = 1;
								function MJ_lawmgt_add_event()
								{
									"use strict"; 
									value++;

									$("#event_div").append('<div class="form-group workflow_item"><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="event_subject"><?php esc_html_e('Event Subject','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback"><input id="event_subject'+value+'" opt_class="op'+value+'" class="form-control has-feedback-left   validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input event_subject"  type="text" placeholder="<?php esc_html_e('Enter Event Subject','lawyer_mgt');?>" value="" name="event_subject[]"><span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span></div></div><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="event_description"><?php esc_html_e('Event Description','lawyer_mgt');?></label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback"><textarea rows="2" name="event_description[]" class="validate[custom[address_description_validation],maxSize[150]] width_100_per_resize_css" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" id="event_description"></textarea></div></div><div class="form-group"><div class="offset-lg-2 col-lg-2 offset-md-2 col-md-2 offset-sm-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt');?>" class="remove_event btn btn-danger" onclick="MJ_lawmgt_deleteParentElement_task(this)" row="'+value+'"></div></div></div>');   
	
									$(".task_event_name").append('<option class=op'+value+'></option>');
								}  
                                "use strict"; 								
								var value = 1;
								function MJ_lawmgt_add_task()
								{
									"use strict"; 
									value++;
									$("#task_div").append('<div class="form-group workflow_item"><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="task_subject"><?php esc_html_e('Task Subject','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback"><input id="task_subject" class="form-control has-feedback-left  validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input " type="text" placeholder="<?php esc_html_e('Enter Task Subject','lawyer_mgt');?>" value="" name="task_subject[]"><span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span></div></div><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="task_description"><?php esc_html_e('Task Description','lawyer_mgt');?></label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback"><textarea rows="2" class="validate[custom[address_description_validation],maxSize[150]] width_100_per_resize_css"  name="task_description[]" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>"   id="task_description"></textarea></div></div><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="due_date_type">Due Date</label><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><select class="form-control due_date_type'+value+'" name="due_date_type[]"  id="due_date_type" row="'+value+'" ><option value="automatically"><?php esc_html_e('Automatically','lawyer_mgt');?></option><option value="no_due_date" selected><?php esc_html_e('No due date','lawyer_mgt');?></option></select></div><div class="date_time_by_event date_time_by_event_css  date_time_by_event'+value+'"><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><input class="form-control validate[required] text-input" type="number" placeholder="<?php esc_html_e('Enter Days','lawyer_mgt');?>" value="1" name="days[]"></div><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><select class="form-control" name="day_formate[]" id="days"><option value="days" selected>Days</option></select></div><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><select class="form-control" name="day_type[]" id="days"><option value="before" selected><?php esc_html_e('Before','lawyer_mgt');?></option><option value="after" ><?php esc_html_e('After','lawyer_mgt');?></option></select></div><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><select class="form-control validate[required] task_event_name task_event_name'+value+'" name="task_event_name[]" id="task_event_name"></select></div></div></div><div class="form-group"><div class="offset-lg-2 col-lg-2 offset-md-2 col-md-2 offset-sm-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement_task(this)" class="remove_task btn btn-danger"></div></div>');   		

									var event_name=[];
									var i=0;

									$(".event_subject").each(function () 
									{

									vare_subject=$(this).val();
									var option_class = $(this).attr('opt_class');

									event_name[i]='<option class='+option_class+' value='+e_subject+'>'+e_subject+'</option>';
									i++;
									});	

									$(".task_event_name"+value).html(event_name);
								}  	

								function MJ_lawmgt_deleteParentElement_task(n)
								{
									"use strict"; 
									alert("<?php esc_html_e('Do you really want to delete this ?','lawyer_mgt');?>");
									n.closest('.workflow_item').remove();	  
								}
							</script>
							<?php 		
							$workflow_id=0;
							$edit=0;
							if(isset($_REQUEST['workflow_id']))
							$workflow_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['workflow_id']));
							if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
							{
								$edit=1;
								$workflow_info = $obj_workflow->MJ_lawmgt_get_single_workflow($workflow_id);
							}
							?>

							<div class="panel-body"><!--  PANEL BODY DIV -->
								<form name="workflow_form" action="" method="post" class="form-horizontal" id="workflow_form" enctype='multipart/form-data'>	
									<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
									<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
									<input type="hidden" name="workflow_id1" value="<?php echo esc_attr($workflow_id);?>"  />
									<div class="header margin_cause">	
									<h3 class="first_hed"><?php esc_html_e('Workflow Information','lawyer_mgt');?></h3>
									<hr>
									</div>
									<?php wp_nonce_field( 'save_workflow_nonce' ); ?>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="workflow_name"><?php esc_html_e('Workflow Name','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
											<input id="workflow_name" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input "  type="text" placeholder="<?php esc_html_e('Enter Workflow Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($workflow_info->name);}elseif(isset($_POST['workflow_name'])){ echo esc_attr($_POST['workflow_name']); } ?>" name="workflow_name">
											<span class="fa fa-stack-overflow form-control-feedback left" aria-hidden="true"></span>
										</div>			
									</div>	
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="workflow_description"><?php esc_html_e('Workflow Description','lawyer_mgt');?></label>
										<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
											<textarea rows="3"  class="validate[custom[address_description_validation],maxSize[150]] width_100_per_resize_none_css" name="workflow_description" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>"   id="workflow_description"><?php if($edit){ echo esc_textarea($workflow_info->description);}elseif(isset($_POST['workflow_description'])){ echo esc_textarea($_POST['workflow_description']); } ?></textarea>
										</div>		
									</div>		
									<div class="form-group">		
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="permission_type"><?php esc_html_e('Workflow Permissions','lawyer_mgt');?></label>
										<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
											<select class="form-control" name="permission_type" id="workflow_permission_type">				
											 <?php if($edit)
											$permission_type =$workflow_info->permission;					
											else 
											 $permission_type = ""; 
											?>
											<option value="Private" <?php if($permission_type == 'Private') echo 'selected = "selected"';?>><?php esc_html_e('This is my private workflow','lawyer_mgt');?></option>
											<option value="Public" <?php  if($permission_type == 'Public') echo 'selected = "selected"';  ?>><?php esc_html_e('Share this workflow with all users','lawyer_mgt');?></option>	
											</select>
										</div>
									</div>
									<?php
									if($user_role == 'attorney')
									{
										$attorney_id=get_current_user_id();		
									?>
										<input type="hidden" name="assginedto" value="<?php echo esc_attr( $attorney_id);?>">
									<?php
									}
									else
									{?>	
										<div class="form-group">	
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="assginedto"><?php esc_html_e('Assigned To Attorney','lawyer_mgt');?><span class="require-field">*</span></label>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">			
												<select class="form-control case_assgined_to validate[required]" name="assginedto" id="assginedto">
													<option value=""><?php esc_html_e('Select Attorney Name','lawyer_mgt');?></option>
													<?php 
													if($edit)
													$assginedto =$workflow_info->assgined_to;				
													else 
													$assginedto = "";

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
													$users = get_users($args);

													if(!empty($users))
													{
													foreach ($users as $retrive_data)
													{ 		 	
													?>
														<option value="<?php echo esc_attr($retrive_data->ID);?>"<?php selected($assginedto,$retrive_data->ID);  ?>><?php echo esc_html($retrive_data->display_name); ?> </option>
													<?php }
													} 
													?> 
												</select>				
											</div>
										</div>		
									<?php
									}
									?>		
									<div class="header">	
										<h3 class="first_hed"><?php esc_html_e('Workflow Events','lawyer_mgt');?></h3>
										<hr>
									</div>
									<?php
									if($edit)
									{
										$result_event=$obj_workflow->MJ_lawmgt_get_single_workflow_events($workflow_id);		
										?>
										<div id="event_div">
											<?php
											if(!empty($result_event))
											{
												$value = 1;
												$e_name_array = array();
												foreach ($result_event as $retrive_data)
												{
													$value--; 	

													$e_name_array[] = array(
																	  "e_class" => 'op'.$value,
																	  "subject" => $retrive_data->subject
																	  ); 
																	  
													$event_name_array=json_encode($e_name_array);					  
																	  
													?>					
														<div class="form-group workflow_item">
															<div class="form-group">
																<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="event_subject"><?php esc_html_e('Event Subject','lawyer_mgt');?><span class="require-field">*</span></label>
																<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
																	<input id="event_subject" opt_class="<?php echo 'op'.$value; ?>"   class="form-control has-feedback-left  validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input event_subject " type="text" placeholder="<?php esc_html_e('Enter Event Subject','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($retrive_data->subject);}elseif(isset($_POST['event_subject'])){ echo esc_attr($_POST['event_subject']); } ?>" name="event_subject[]">
																	<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
																</div>
															</div>
															
															<div class="form-group">
																<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="event_description"><?php esc_html_e('Event Description','lawyer_mgt');?></label>
																<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
																	<textarea rows="2"  name="event_description[]" class="validate[custom[address_description_validation],maxSize[150]] width_100_per_resize_css" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" id="event_description"><?php if($edit){ echo esc_textarea($retrive_data->description);}elseif(isset($_POST['event_description'])) { echo esc_textarea($_POST['event_description']); } ?></textarea>
																</div>	
															</div>	
															<div class="form-group">
																<div class="offset-lg-2 col-lg-2 offset-md-2 col-md-2 offset-sm-2 col-sm-2 col-xs-12">
																	<input type="button" value="<?php esc_attr_e('Remove','lawyer_mgt') ?>" class="remove_event btn btn-danger" row="<?php echo $value; ?>">
																</div>			
															</div>			
														</div>				
												<?php
												} 				
											}
										?>
										</div>
										<?php
									}
									else
									{	
									?>		  
										<div id="event_div">

										</div>	
									<?php 
									} ?>			
									<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
										<input type="button" value="<?php esc_attr_e('Add More Event','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_event()" class="add_event btn btn-success">
									</div>			
									<div class="header">	
										<h3 class="first_hed"><?php esc_html_e('Workflow Tasks','lawyer_mgt');?></h3>
										<hr>
									</div>
									<?php
									if($edit)
									{
										$result_task=$obj_workflow->MJ_lawmgt_get_single_workflow_tasks($workflow_id);
									?>
									<div id="task_div">
										<?php
										if(!empty($result_task))
										{
											$value = 1;
											foreach ($result_task as $retrive_data)
											{ 
												$value--; 		
												?>
												<div class="form-group workflow_item">
													<div class="form-group">
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="task_subject"><?php esc_html_e('Task Subject','lawyer_mgt');?><span class="require-field">*</span></label>
														<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
															<input id="task_subject" class="form-control has-feedback-left  validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input "   type="text" placeholder="<?php esc_html_e('Enter Task Subject','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($retrive_data->subject);}elseif(isset($_POST['task_subject'])){ echo esc_attr($_POST['task_subject']); } ?>" name="task_subject[]">
															<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
														</div>
													</div>
													<div class="form-group">
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="task_description"><?php esc_html_e('Task Description','lawyer_mgt');?></label>
														<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
															<textarea rows="2"  name="task_description[]" class="validate[required,custom[address_description_validation],maxSize[150]] width_100_per_resize_css" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" id="task_description"><?php if($edit){ echo esc_textarea($retrive_data->description);}elseif(isset($_POST['task_description'])){ echo esc_textarea($_POST['task_description']); } ?></textarea>
														</div>	
													</div>
													<?php
														$due_date=$retrive_data->due_date;
														$data=json_decode( $due_date);
													?>
													<div class="form-group">
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="due_date_type"><?php esc_html_e('Due Date','lawyer_mgt');?></label>						
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
														<select class="form-control due_date_type<?php echo $value; ?>" name="due_date_type[]" id="due_date_type" row="<?php echo esc_attr($value); ?>">
														 <?php if($edit)
																$due_date_type =$data->due_date_type;					
															else 
																 $due_date_type = ""; 
															?>
															<option value="automatically" <?php if($due_date_type == 'automatically') echo 'selected = "selected"';?>><?php esc_html_e('Automatically','lawyer_mgt');?></option>
															<option value="no_due_date" <?php if($due_date_type == 'no_due_date') echo 'selected = "selected"';?>><?php esc_html_e('No due date','lawyer_mgt');?></option>										
														</select>
													</div>
													<?php 
													if($data->due_date_type == 'automatically')
													{
													?>
														<div class="date_time_by_event  date_time_by_event<?php echo $value; ?> col-md-8" row="<?php echo $value; ?>" >	
																						
																<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																	<input class="form-control validate[required] text-input" type="number" placeholder="<?php esc_html_e('Enter Days','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($data->days);}elseif(isset($_POST['days'])){ echo esc_attr($_POST['days']); } ?>" name="days[]">
																</div>
																<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																	<select class="form-control" name="day_formate[]" id="days">	

																		<option value="days" selected><?php esc_html_e('Days','lawyer_mgt');?></option>
																	</select>
																</div>
																<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																	<select class="form-control" name="day_type[]" id="days">	
																	 <?php if($edit)
																		$day_type =$data->day_type;					
																		else 
																		$day_type = ""; 
																	?>
																		<option value="before" <?php if($day_type == 'before') echo 'selected = "selected"';?>><?php esc_html_e('Before','lawyer_mgt');?></option>
																		<option value="after" <?php if($day_type == 'after') echo 'selected = "selected"';?> ><?php esc_html_e('After','lawyer_mgt');?></option>
																	</select>
																</div>
																<div class="col-sm-4">
																	<select class="form-control validate[required] task_event_name task_event_name<?php echo $value; ?>" name="task_event_name[]" id="task_event_name">
																	<?php 
																	 if($edit)
																		$task_event_name =esc_html($data->task_event_name);				
																	else 
																		$task_event_name = "";		
																	
																	$event_data = json_decode($event_name_array);
																	if(!empty($event_data))
																	{
													
																			foreach ($event_data as $retrive_data)
																			{ 	
																		?>
																			<option class="<?php echo $retrive_data->e_class;?>" value="<?php echo esc_attr($retrive_data->subject);?>" <?php selected($task_event_name,$retrive_data->subject);  ?>><?php echo esc_html($retrive_data->subject); ?> </option>
																		<?php }
																	} 
																	?> 										
																	</select>
																</div>
														</div>
													<?php
													}
													else
													{ ?>
														<div class="date_time_by_event date_time_by_event_css  date_time_by_event<?php echo $value; ?> col-md-8" row="<?php echo $value; ?>" >	
																						
															<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																<input class="form-control validate[required] text-input" type="number" placeholder="<?php esc_html_e('Enter Days','lawyer_mgt');?>" value="1" name="days[]">
															</div>
															<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																<select class="form-control" name="day_formate[]" id="days">	

																	<option value="days" selected><?php esc_html_e('Days','lawyer_mgt');?></option>
																</select>
															</div>
															<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																<select class="form-control" name="day_type[]" id="days">	
																
																	<option value="before" selected><?php esc_html_e('Before','lawyer_mgt');?></option>
																	<option value="after" ><?php esc_html_e('After','lawyer_mgt');?></option>
																</select>
															</div>
															<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
																<select class="form-control validate[required] task_event_name task_event_name<?php echo $value; ?>" name="task_event_name[]" id="task_event_name">
																<?php 
																$event_data = json_decode($event_name_array);
																if(!empty($event_data))
																{
												
																		foreach ($event_data as $retrive_data)
																		{ 				 	
																		
																	?>
																		<option class="<?php echo esc_html($retrive_data->e_class);?>" value="<?php echo esc_attr($retrive_data->subject);?>" ><?php echo esc_html($retrive_data->subject); ?> </option>
																	<?php }
																} 							
																?>																
																</select>
															</div>
														</div>
													<?php 
													}	
													?>
													</div>
													<div class="form-group">
														<div class="offset-lg-2 col-lg-2 offset-md-2 col-md-2 offset-sm-2 col-sm-2 col-xs-12">
															<input type="button" value="<?php esc_attr_e('Remove','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement_task(this)" class="remove_task btn btn-danger">
														</div>			
													</div>		
												</div>		
												<?php
											} 				
										}
										?>
									</div>
									<?php
									}
									else
									{	
									?>		  
										<div id="task_div">

										</div> 
									<?php
									}
									?>			
									<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
										<input type="button" value="<?php esc_attr_e('Add More Task','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_task()" class="add_task btn btn-success">
									</div>			
									<div class="offset-sm-2 col-sm-8">
										<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Add Workflow','lawyer_mgt');}?>" name="save_workflow" class="btn btn-success"/>
									</div>
								</form>
							</div>
							<?php	
						}	
						if($active_tab == 'view_workflow')
						{
							$obj_workflow=new MJ_lawmgt_workflow;
							$workflow_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['workflow_id']));
							$workflow_info = $obj_workflow->MJ_lawmgt_get_single_workflow($workflow_id);

							?>		
							<div class="panel-body">
								<form name="workflow_Details_form" action="" method="post" class="form-horizontal"  enctype='multipart/form-data'>   
									<div class="header margin_task_to_template">	
										<h3 class="first_hed"><?php esc_html_e('Workflow Information','lawyer_mgt');?></h3>
										<hr>
									</div>	
									<div class="">		
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 workflow_info_div">	
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
														<?php esc_html_e('Workflow Name','lawyer_mgt'); ?>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<span class="txt_color">
														<?php
															 echo esc_html($workflow_info->name);
															?>
														</span>
													</div>
												</div>
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
														<?php esc_html_e('Workflow Description','lawyer_mgt'); ?>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<span class="txt_color">
														<?php
															 echo esc_html($workflow_info->description);
															?>
														</span>
													</div>
												</div>
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
														<?php esc_html_e('Workflow Permissions','lawyer_mgt'); ?>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<span class="txt_color">
														<?php
															 echo esc_html($workflow_info->permission);
															?>
														</span>
													</div>
												</div> 
										</div>
									</div>		
									<div class="header">	
										<h3 class="first_hed"><?php esc_html_e('Workflow Events','lawyer_mgt');?></h3>
										<hr>
									</div>	
									<?php
									$result_event=$obj_workflow->MJ_lawmgt_get_single_workflow_events($workflow_id);		
									?>
									<div id="event_div">
										<?php
										if(!empty($result_event))
										{
											foreach ($result_event as $retrive_data)
											{
												?>
												<div class="">		
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 workflow_info_div">	
															<div class="table_row">
																<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																	<?php esc_html_e('Event Subject','lawyer_mgt'); ?>
																</div>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																	<span class="txt_color">
																	<?php
																		 echo esc_html($retrive_data->subject);
																		?>
																	</span>
																</div>
															</div>
															<div class="table_row">
																<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																	<?php esc_html_e('Event Description','lawyer_mgt'); ?>
																</div>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																	<span class="txt_color">
																	<?php
																		 echo esc_html($retrive_data->description);
																		?>
																	</span>
																</div>
															</div>
															 
													</div>
												</div>	
											<?php
											}
										}
									?>
									</div>
									<div class="header">	
										<h3 class="first_hed"><?php esc_html_e('Workflow Tasks','lawyer_mgt');?></h3>
										<hr>
									</div>	
									<?php
									$result_task=$obj_workflow->MJ_lawmgt_get_single_workflow_tasks($workflow_id);		
									?>
									<div id="task_div">
										<?php
										if(!empty($result_task))
										{
											foreach ($result_task as $retrive_data)
											{
												?>
												<div class="">		
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 workflow_info_div">	
																<div class="table_row">
																	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																		<?php esc_html_e('Task Subject','lawyer_mgt'); ?>
																	</div>
																	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																		<span class="txt_color">
																		<?php
																			 echo esc_html($retrive_data->subject);
																			?>
																		</span>
																	</div>
																</div>
																<div class="table_row">
																	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																		<?php esc_html_e('Task Description','lawyer_mgt'); ?>
																	</div>
																	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																		<span class="txt_color">
																		<?php
																			 echo esc_html($retrive_data->description);
																			?>
																		</span>
																	</div>
																</div>
																<?php
																	$due_date=$retrive_data->due_date;
																	$data=json_decode( $due_date);
																?>
																<div class="table_row">
																	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																		<?php esc_html_e('Due Date','lawyer_mgt'); ?>
																	</div>
																	<?php 
																	if($data->due_date_type == 'automatically')
																	{
																	?>
																		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																			<span class="txt_color">
																			<?php
																				 echo  esc_html($data->days." ".$data->day_formate." ".$data->day_type." ".$data->task_event_name);
																				?>
																			</span>
																		</div>
																		<?php
																	}
																	else
																	{
																	?>
																	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																			<span class="txt_color">
																			<?php esc_html_e('No Due Date','lawyer_mgt');?>
																			</span>
																	</div>
																	  <?php
																	}	
																	?>	
																</div>
																 
														</div>
													</div>	
												<?php
											}
										}
										?>
									</div>
								</form>
							</div>        
							<?php 	
						}	
						?>
					</div>
				</div>
			</div>
		</div>
	</div><!-- END MAIN WRAPER DIV -->
</div><!--  END PAGE INNER DIV -->