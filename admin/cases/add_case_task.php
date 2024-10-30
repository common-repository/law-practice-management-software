<?php 
$note=new MJ_lawmgt_Note;
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
<?php 	
if($active_tab == 'task')
{
	$active_tab = isset($_GET['tab3'])?$_GET['tab3']:'tasklist';
?>
	<h2>
		<ul id="myTab" class="sub_menu_css line nav nav-tabs" role="tablist">
			<li role="presentation" class="<?php echo esc_html($active_tab) == 'tasklist' ? 'active' : ''; ?>">
				<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=task&tab3=tasklist&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">						
					<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Task List', 'lawyer_mgt'); ?>
				</a>
			</li>
			<?php if(isset($_REQUEST['edit'])&& sanitize_text_field($_REQUEST['edit'])=='true') {?>
			<li role="presentation" class="<?php echo esc_html($active_tab) == 'addtask' ? 'active' : ''; ?>">
				<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=task&tab3=addtask&edit=true&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&task_id=<?php echo esc_attr($_REQUEST['task_id']);?>">
					<?php echo esc_html__('Edit Task', 'lawyer_mgt'); ?>
				</a>
			</li>
			<?php }else{?>
			<li role="presentation" class="<?php echo $active_tab == 'addtask' ? 'active' : ''; ?>">
				<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=task&tab3=addtask&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
					<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Task', 'lawyer_mgt'); ?>	
				</a>
			</li>
			<?php }					
			 if(isset($_REQUEST['view'])&& sanitize_text_field($_REQUEST['view'])=='true') {?>
			<li role="presentation" class="<?php echo $active_tab == 'viewtask' ? 'active' : ''; ?>">
				<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=task&tab3=viewtask&view=true&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&task_id=<?php echo esc_attr($_REQUEST['task_id']); ?>">
				<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('View Task', 'lawyer_mgt'); ?>
				</a>
			</li>
			<?php }?>	
		</ul>
    </h2>
	<?php
	if($active_tab=='addtask')
	{	 
		require_once LAWMS_PLUGIN_DIR. '/admin/cases/add_task.php'; 
	}
	if($active_tab=='viewtask')
	{	 
		require_once LAWMS_PLUGIN_DIR. '/admin/cases/view_case_task.php'; 
	}
	if($active_tab=='tasklist')
	{?>
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
				jQuery('#tast_list').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
			} );
		</script>
		<form name="tast_list" action="" method="post" enctype='multipart/form-data'>
			<div class="panel-body"><!-- PANEL BODY DIV -->
				<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">	
					<table id="case_tast_list" class="tast_list1 table table-striped table-bordered">
						<thead>									
						<?php
							if(isset($_REQUEST['case_id']))
							$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
							$casedata=$obj_case_tast->MJ_lawmgt_get_tast_by_caseid($case_id);	
							?>      
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
							if(!empty($casedata))
							{
								foreach ($casedata as $retrieved_data)
								{
									$user_id= sanitize_text_field($retrieved_data->assigned_to_user);
									$contac_id=explode(',',$user_id);
									$user_name=array();
									foreach($contac_id as $contact_name)
									{								
										$userdata=get_userdata($contact_name);													
										$user_name[]='<a href="?page=contacts&tab=add_contact&action=view&contact_id='.MJ_lawmgt_id_encrypt(esc_attr($userdata->ID)).'">'.$userdata->display_name.'</a>';
									}
									 $attorney=$retrieved_data->assign_to_attorney;
									$attorney_name=explode(',',$attorney);
									$attorney_name1=array();
									foreach($attorney_name as $attorney_name2) 
									{
										$attorneydata=get_userdata($attorney_name2);	
										$attorney_name1[]='<a href="?page=attorney&tab=view_attorney&action=view&attorney_id='.MJ_lawmgt_id_encrypt(esc_attr($attorneydata->ID)).'">'.esc_html($attorneydata->display_name).'</a>';
									}
									$case_name=MJ_lawmgt_get_case_name_by_id($retrieved_data->case_id);
									foreach($case_name as $case_name1)
									{
										$case_name2=$case_name1->case_name;
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
										<td class="email"><?php echo esc_html($retrieved_data->task_name);?></td>
										<td class="prac_area"><a href="?page=cases&tab=casedetails&action=view&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>"><?php echo esc_html($case_name2); ?></a></td>	
										<td class="added"><?php echo MJ_lawmgt_getdate_in_input_box(esc_html($retrieved_data->due_date));?></td>
										<td class="added"><?php echo  esc_html($statu);?></td>
										<td class="contact_link"><?php echo  esc_html($prio); ?></td>					
										<td class="added"><?php echo  implode($user_name,',');?></td>
										<td class="added"><?php echo  implode($attorney_name1,',');?>						
										<td class="action"> 
										<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=task&tab3=viewtask&view=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&task_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->task_id));?>" id='view_task_user' class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
										 <a href="admin.php?page=cases&tab=casedetails&action=view&tab2=task&tab3=addtask&edit=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&task_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->task_id));?>" id="ediit" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
										 <a href="?page=cases&tab=casedetails&action=view&editats=true&deletetask=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&task_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->task_id));?>" class="btn btn-danger" 
											onclick="return confirm('<?php esc_html_e('Are you sure you want to Delete this Task ?','lawyer_mgt');?>');">
										  <?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>					
										  </td>               
									</tr>
						<?php	 } 			
							} ?>     
						</tbody> 
					</table>
					<?php    if(!empty($casedata))
							{
					?>
					<div class="form-group">		
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
							<input type="submit" class="btn delete_margin_bottom delete_check btn-danger" name="task_delete_selected"  value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
						</div>
					</div>
						<?php  } ?>
				</div>
			</div> <!-- END PANEL BODY DIV --> 
		</form>
<?php 
	}	  
}
 ?>	