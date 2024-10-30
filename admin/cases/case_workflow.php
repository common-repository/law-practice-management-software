<?php 	
$obj_caseworkflow=new MJ_lawmgt_caseworkflow;
if($active_tab == 'workflow')
{
	$active_tab = isset($_GET['tab3'])?$_GET['tab3']:'workflow_list';
	?>     
     	<h2>	
		<ul id="myTab" class="sub_menu_css line nav nav-tabs case_details_documents" role="tablist">
			<li role="presentation" class="<?php echo esc_html($active_tab) == 'workflow_list' ? 'active' : ''; ?> ">
				<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=workflow&tab3=workflow_list&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
					<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Apply Workflow List', 'lawyer_mgt'); ?>				
				</a>
			</li>
			<?php if(isset($_REQUEST['edit'])&& sanitize_text_field($_REQUEST['edit'])=='true') {?>
			<li role="presentation" class="<?php echo esc_html($active_tab) == 'applyworkflow' ? 'active' : ''; ?>">
				<a href="admin.php?page=cases&tab=casedetails&action=view&edit=true&tab2=workflow&tab3=applyworkflow&workflow_id=<?php echo esc_attr($_REQUEST['workflow_id']);?>&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
					<?php echo esc_html__('Edit Apply Workflow', 'lawyer_mgt'); ?>					
				</a>
			</li>
			<?php }else{?>
			<li role="presentation" class="<?php echo esc_html($active_tab) == 'applyworkflow' ? 'active' : ''; ?>">
				<a href="admin.php?page=cases&tab=casedetails&action=view&add=true&tab2=workflow&tab3=applyworkflow&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
					<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Apply Workflow', 'lawyer_mgt'); ?>	
				</a>
			</li>
			<?php 
			}
			?>
			<?php if(isset($_REQUEST['view'])&& sanitize_text_field($_REQUEST['view'])=='true') 
			{
				?>
			<li role="presentation" class="<?php echo esc_html($active_tab) == 'view_applyworkflow' ? 'active' : ''; ?> ">
				<a href="admin.php?page=cases&tab=casedetails&action=view&view=true&tab2=workflow&tab3=view_applyworkflow&workflow_id=<?php echo esc_attr($_REQUEST['workflow_id']);?>&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
					<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('View Apply Workflow', 'lawyer_mgt'); ?>
				</a>
			</li>
			<?php 
			}
			?>
		</ul>
	</h2>
	<?php
	if($active_tab=='applyworkflow')
	{	 
		require_once LAWMS_PLUGIN_DIR. '/admin/cases/apply_case_workflow.php'; 
	}	
	if($active_tab=='view_applyworkflow')
	{	 
		require_once LAWMS_PLUGIN_DIR. '/admin/cases/view_case_applyworkflow.php'; 
	}	
	if($active_tab=='workflow_list')
	{		
	?>      
	<script type="text/javascript">
	var $ = jQuery.noConflict();
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
		});	
	</script>
	<form name="wcwm_report" action="" method="post">
		<div class="panel-body"><!-- PANEL BODY DIV     -->
			<div class="table-responsive">
				<table id="workflow_list" class="table table-striped table-bordered">
					<thead>					
						<tr>
							<th><input type="checkbox" id="select_all"></th>
							<th><?php  esc_html_e('Workflow Name', 'lawyer_mgt' ) ;?></th>
							<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
						</tr>				
					</thead>
					<tbody>
							<?php	
							$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));					
							$workflowdata=$obj_caseworkflow->MJ_lawmgt_get_all_applyworkflow_by_caseid($case_id); 
							if(!empty($workflowdata))
							{					   
								foreach ($workflowdata as $retrieved_data)
								{			
									$workflow_name=MJ_lawmgt_get_workflow_name($retrieved_data->workflow_id);
								?>
								<tr>
									<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->workflow_id); ?>"></td>
									<td class="added"><?php echo esc_html($workflow_name);?></td>
									<td class="action"> 
										<a href="admin.php?page=cases&tab=casedetails&action=view&view=true&tab2=workflow&tab3=view_applyworkflow&workflow_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->workflow_id));?>&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
										<a href="admin.php?page=cases&tab=casedetails&action=view&edit=true&tab2=workflow&tab3=applyworkflow&workflow_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->workflow_id));?>&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>" id="ediit" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>											
										<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=workflow&tab3=workflow_list&deleteworkflow=true&workflow_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->workflow_id));?>&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>" class="btn btn-danger" 
										onclick="return confirm('<?php esc_html_e('Are you sure you want to Delete this workflow ?','lawyer_mgt');?>');">
										  <?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>					
									  </td>               
								</tr>
						<?php } 			
							} ?>     
					</tbody> 
				</table>
				<?php  if(!empty($workflowdata))
						{?>
				<div class="form-group">		
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
						<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="workflow_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
					</div>
				</div>
						<?php }?>
			</div>
		</div><!-- END PANEL BODY DIV     -->
	</form>
	<?php 
	}
}
?>	