<?php 
$obj_case=new MJ_lawmgt_case;
$obj_case_tast= new MJ_lawmgt_case_tast;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'tasklist');
if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
{
	//wp_redirect (admin_url().'admin.php?page=lmgt_system');
	$redirect_url= esc_url(admin_url().'admin.php?page=lmgt_system');
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
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV -->
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' ));?></h3>
	  </div>
	</div>
	<?php 	
	if(isset($_POST['savetast']))
	{		
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_task_nonce' ) )
		{ 
			if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edittask')
			{
				$result=$obj_case_tast->MJ_lawmgt_add_tast($_POST);
				if($result)
				{
					//wp_redirect (admin_url().'admin.php?page=task&tab=tasklist&message=2');	
					$redirect_url= esc_url(admin_url().'admin.php?page=task&tab=tasklist&message=2');
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
					//wp_redirect (admin_url().'admin.php?page=task&tab=tasklist&message=1');	
					$redirect_url= esc_url(admin_url().'admin.php?page=task&tab=tasklist&message=1');
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
			//wp_redirect ( admin_url() . 'admin.php?page=task&tab=tasklist&message=3');
			$redirect_url= esc_url(admin_url().'admin.php?page=task&tab=tasklist&message=3');
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
			$selected_id = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ) );
			$all = implode(",", $selected_id);			
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
			//wp_redirect ( admin_url() . 'admin.php?page=task&tab=tasklist&message=3');
			$redirect_url= esc_url(admin_url().'admin.php?page=task&tab=tasklist&message=3');
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
		{?>
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
					<div class="panel-body">
						<h2 class="nav-tab-wrapper">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="tablist">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'tasklist' ? 'active' : ''; ?> menucss">
									<a href="?page=task&tab=tasklist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Task List', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_task' ? 'active' : ''; ?> menucss ">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edittask')
								{?>
								<a href="?page=task&tab=add_task&action=edittask&task_id=<?php echo esc_attr($_REQUEST['task_id']);?>">
									<?php esc_html_e('Edit Task', 'lawyer_mgt'); ?>
								</a>  
								<?php 
								}
								else
								{?>
									<a href="?page=task&tab=add_task">
										<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Task', 'lawyer_mgt');?>
									</a>  
								<?php  
								}?>
								</li>			
								<?php if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view_task'){?>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'view_task' ? 'active' : ''; ?> menucss">
									<a href="?page=task&tab=view_task&action=view_task&task_id=<?php echo esc_attr($_REQUEST['task_id']);?>">
										<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('View Task', 'lawyer_mgt'); ?>
									</a>
								</li>
								<?php } ?>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'taskactivity' ? 'active' : ''; ?> menucss">
									<a href="?page=task&tab=taskactivity">
										<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('Task Activity', 'lawyer_mgt'); ?>
									</a>
								</li>
							</ul>
						</h2>
						<?php 	
						if($active_tab == 'tasklist')
						{ ?>
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
								});
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
								});
							</script>	
							 
							<div class="tab-pane  tabs fade  active in" id="nav-open" role="tabpanel" aria-labelledby="nav-open-tab">
							<div class="panel-body">
								<form name="tast_list" id="tast_list" action="" method="post" enctype='multipart/form-data'>
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
										$casedata=$obj_case_tast->MJ_lawmgt_get_all_case_tast();
										if(!empty($casedata))
										{										
											foreach ($casedata as $retrieved_data)
											{
												$user_id=$retrieved_data->assigned_to_user;
												$attorney=$retrieved_data->assign_to_attorney;
												$contac_id=explode(',',$user_id);
												$attorney_name=explode(',',$attorney);
												$user_name=array();
												$attorney_name1=array();
												foreach($contac_id as $contact_name) 
												{
													$userdata=get_userdata($contact_name);	
														
													$user_name[]='<a href="?page=contacts&tab=viewcontact&action=view&contact_id='.MJ_lawmgt_id_encrypt(esc_attr($userdata->ID)).'">'.esc_html($userdata->display_name).'</a>';										   
												}
												foreach($attorney_name as $attorney_name2) 
												{
													$attorneydata=get_userdata($attorney_name2);	
														
													$attorney_name1[]='<a href="?page=attorney&tab=view_attorney&action=view&attorney_id='.MJ_lawmgt_id_encrypt(esc_attr($attorneydata->ID)).'">'.esc_html($attorneydata->display_name).'</a>';										   
												}
												$case_name=MJ_lawmgt_get_case_name_by_id($retrieved_data->case_id);
												if(!empty($case_name))
												{
													foreach($case_name as $case_name1)
													{
														$case_name2=$case_name1->case_name;
													}
												}
												else
												{
													$case_name2='';
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
													<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->task_id); ?>"></td>												
													<td class="task"><a href="?page=task&tab=view_task&action=view_task&task_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->task_id));?>"><?php echo esc_html($retrieved_data->task_name);?></a></td>
													<td class="prac_area"><a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>"><?php echo esc_html($case_name2); ?></a></td>	
													<td class="added"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->due_date));?></td>						 
													<td class="added"><?php echo esc_html__($statu) ;?></td>
													<td class="contact_link"><?php echo esc_html($prio); ?></td>					
													 						 
													<td class="added"><?php echo  implode($user_name,',');?></td>
													<td class="added"><?php echo  implode($attorney_name1,',');?></td>
													<td class="action"> 
														<a href="?page=task&tab=view_task&action=view_task&task_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->task_id));?>" id='view_task_user' class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
														<a href="?page=task&tab=add_task&action=edittask&task_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->task_id));?>" id='edit_task_user' class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
														<a href="?page=task&tab=tasklist&action=deletetask&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&task_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->task_id));?>" class="btn btn-danger" 
															onclick="return confirm('<?php esc_html_e('Are you sure you want to Delete this Task ?','lawyer_mgt');?>');">
														  <?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>					
													</td>               
												</tr>
										<?php 
											} 			
										} 
										?>     
									</tbody>   
								</table>
								<?php 
								if(!empty($casedata))
										{
								?>
								<div class="form-group">		
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
										<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="task_delete_selected"  value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
									</div>
								</div>
										<?php } ?>
							  </div>
							 </div>       
							</form>
							</div>
						<?php
						} 
						if($active_tab == 'add_task')
						{
						   require_once LAWMS_PLUGIN_DIR. '/admin/task/addtask.php';
						   
						}
						if($active_tab == 'taskactivity')
						{
						   require_once LAWMS_PLUGIN_DIR. '/admin/task/task_activity.php';
						}
						if($active_tab == 'view_task')
						{
						   require_once LAWMS_PLUGIN_DIR. '/admin/task/view_task.php';
						} 
						?>
					</div>
				</div>
			</div>
		</div>
	</div><!-- END  MAIN WRAPER  DIV -->
</div><!-- END  INNER PAGE  DIV -->