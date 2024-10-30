<?php 	
$obj_workflow=new MJ_lawmgt_workflow;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'workflowlist');
?>
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV -->
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' ));?></h3>
	  </div>
	</div>
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
					//wp_redirect ('?admin.php&page=workflow&tab=workflowlist&message=2');
					$url=admin_url().'admin.php?page=workflow&tab=workflowlist&message=2';
					if (!headers_sent())
					{
					    header('Location: '.esc_url($url));
					}
				    else 
					{
						echo '<script type="text/javascript">';
						echo 'window.location.href="'.esc_url($url).'";';
						echo '</script>';
					}
				}
			 }
			 else
			 {
				 $result=$obj_workflow->MJ_lawmgt_add_workflow($_POST);
				if($result)
				{
					//wp_redirect ('?admin.php&page=workflow&tab=workflowlist&message=1');
					$url=admin_url().'admin.php?page=workflow&tab=workflowlist&message=1';
					if (!headers_sent())
					{
					    header('Location: '.esc_url($url));
					}
				    else 
					{
						echo '<script type="text/javascript">';
						echo 'window.location.href="'.esc_url($url).'";';
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
			//wp_redirect (admin_url(). 'admin.php?page=workflow&tab=workflowlist&message=3');
			$url=admin_url().'admin.php?page=workflow&tab=workflowlist&message=3';
			if (!headers_sent())
			{
				header('Location: '.esc_url($url));
			}
			else 
			{
				echo '<script type="text/javascript">';
				echo 'window.location.href="'.esc_url($url).'";';
				echo '</script>';
			}
		}
	}
	if(isset($_POST['workflow_delete_selected']))
	{
		if (isset($_REQUEST['selected_id']))
		{	
			$selected_id = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ) );
			$all = implode(",", $selected_id);			
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
			//wp_redirect (admin_url(). 'admin.php?page=workflow&tab=workflowlist&message=3');
			$url=admin_url().'admin.php?page=workflow&tab=workflowlist&message=3';
			if (!headers_sent())
			{
				header('Location: '.esc_url($url));
			}
			else 
			{ 
				echo '<script type="text/javascript">';
				echo 'window.location.href="'.esc_url($url).'";';
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
	<div id="main-wrapper">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<h2 class="nav-tab-wrapper">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="workflow">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'workflowlist' ? 'active' : ''; ?> menucss">
									<a href="?page=workflow&tab=workflowlist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Workflow List', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_workflow' ? 'active' : ''; ?> menucss">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
								{?>
									<a href="?page=workflow&tab=add_workflow&action=edit&workflow_id=<?php echo esc_attr($_REQUEST['workflow_id']);?>">
									<?php esc_html_e('Edit Workflow', 'lawyer_mgt'); ?>
								</a>  
								<?php 
								}
								else
								{?>
									<a href="?page=workflow&tab=add_workflow">
										<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Workflow', 'lawyer_mgt');?>
									</a>  
								<?php  
								}?>
								</li>
								<?php
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
								{
								?>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'view_workflow' ? 'active' : ''; ?> menucss">
									<a href="?page=workflow&tab=view_workflow&action=view&workflow_id=<?php echo esc_attr($_REQUEST['workflow_id']);?>">
										<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('View Workflow', 'lawyer_mgt'); ?>
									</a>
								</li>
								<?php
								}
								?>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'workflowactivity' ? 'active' : ''; ?> menucss">
									<a href="?page=workflow&tab=workflowactivity">
										<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('Workflow Activity', 'lawyer_mgt'); ?>
									</a>
								</li>
											
							</ul>
						</h2>
						<?php
						if($active_tab == 'add_workflow')
						{
						   require_once LAWMS_PLUGIN_DIR. '/admin/workflow/addworkflow.php';
						}
						
						if($active_tab == 'view_workflow')
						{
						   require_once LAWMS_PLUGIN_DIR. '/admin/workflow/viewworkflow.php';
						}
						if($active_tab == 'workflowactivity')
						{
						   require_once LAWMS_PLUGIN_DIR. '/admin/workflow/workflow_activity.php';
						}
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
													  {"bSortable": false},
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
							<div class="panel-body">
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
											$workflowdata=$obj_workflow->MJ_lawmgt_get_all_workflow(); 
											if(!empty($workflowdata))
											{					   
												foreach ($workflowdata as $retrieved_data)
												{			
													$user_name=get_userdata($retrieved_data->created_by);
													$attorney_name=MJ_lawmgt_get_display_name($retrieved_data->assgined_to);
													?>
													<tr>
														<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->id); ?>"></td>												
														<td class="added"><?php echo esc_html($retrieved_data->name);?></td>
														<td class="added"><?php echo esc_html($retrieved_data->permission);?></td>														
														<td class="added"><?php echo esc_html($attorney_name);?></td>
														<td class="added"><?php echo esc_html($retrieved_data->created_date);?></td>
														<td class="added"><?php echo esc_html($user_name->display_name);?></td>
														<td class="action"> 	
															<a href="admin.php?page=workflow&tab=view_workflow&action=view&workflow_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>"  class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>								
															<a href="admin.php?page=workflow&tab=add_workflow&action=edit&workflow_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" id="ediit" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>											
															<a href="admin.php?page=workflow&tab=workflowlist&action=delete&workflow_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" 
															onclick="return confirm('<?php esc_html_e('Are you sure you want to Delete this workflow ?','lawyer_mgt');?>');">
															  <?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>					
														  </td>               
													</tr>
											<?php 
												} 			
											} ?>     
										</tbody>
									</table>
									<?php   
									if(!empty($workflowdata))
										{
									?>
									<div class="form-group">		
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
											<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="workflow_delete_selected"  value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
										</div>
									</div>
										<?php }  ?>
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