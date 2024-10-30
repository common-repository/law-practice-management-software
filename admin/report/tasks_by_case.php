<?php  
$obj_task=new MJ_lawmgt_case_tast;
?>
<script type="text/javascript">

jQuery(document).ready(function($)
{
	"use strict";
	$('#invoice_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
});
</script>
<div class="panel-body">
	<form method="post" id="invoice_form"> 
		 
		<div class="form-group col-md-12 margin_top_custome">
			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('Case Name','lawyer_mgt');?></label>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" > 	
				<select class="form-control" name="case_name" id="case_name">	
					<option value=""><?php esc_html_e('Select Case Name','lawyer_mgt');?></option>
					<?php
							$obj_case=new  MJ_lawmgt_case;
							$case_data=$obj_case->MJ_lawmgt_get_all_case();
							
							if(!empty($case_data))
							{
								foreach($case_data as $retrive_data)
								{  				
							?>						
									<option value="<?php echo esc_attr($retrive_data->id);?>"><?php echo esc_html($retrive_data->case_name);?> </option>
							<?php }	
							}
						?> 			
				</select>
			</div>
		</div>
		 
		<div class="form-group col-md-2 margin_top_custome">
			<label for="subject_id">&nbsp;</label>
			<input type="submit" name="invoice_report" Value="<?php esc_attr_e('Go','lawyer_mgt');?>"  class="btn btn-success"/>
		</div>
	</form>
</div>
<?php
	if(isset($_POST['invoice_report']))
	{ ?>
		<script type="text/javascript">
			jQuery(document).ready(function($)
			{
				"use strict";
				jQuery('#invoice_data_list').DataTable({
					"responsive": true,
					"autoWidth": false,
					"order": [[ 1, "asc" ]],
					language:<?php echo wpnc_datatable_multi_language();?>,
					 "aoColumns":[
								  {"bSortable": true},
								  {"bSortable": true},
								  {"bSortable": true},
								  {"bSortable": true},
								  {"bSortable": true},
								  {"bSortable": true},
								  {"bSortable": true}
							   ]		               		
					});	
			});
			jQuery(document).ready(function($) 
			{
				"use strict";
				jQuery('#note_list').validationEngine();
			});
		</script>	
		<div class="tab-pane  tabs fade  active in" id="nav-open" role="tabpanel" aria-labelledby="nav-open-tab">
			<form name="" action="" method="post" enctype='multipart/form-data'>
				<div class="panel-body">
					<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">	
						<table id="invoice_data_list" class="invoice_data_list table table-striped table-bordered">
							<thead>	
								<?php  ?>
								<tr>
									<th><?php  esc_html_e('Task Name', 'lawyer_mgt' ) ;?></th>
									<th><?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
									<th> <?php esc_html_e('Due Date', 'lawyer_mgt' ) ;?></th>
									<th> <?php esc_html_e('Status', 'lawyer_mgt' ) ;?></th>
									<th> <?php esc_html_e('Priority', 'lawyer_mgt' ) ;?></th>
									<th> <?php esc_html_e('Assign To Client', 'lawyer_mgt' ) ;?></th>
									<th> <?php esc_html_e('Assign To Attorney', 'lawyer_mgt' ) ;?></th>
								</tr>
								<br/>
							</thead>
							<tbody>
								<?php
								$or=array();
								 
								$or['case_id ='] = (!empty(sanitize_text_field($_REQUEST['case_name'])))?sanitize_text_field($_REQUEST['case_name']):NULL;
								 
								$keys = array_keys($or,"");	
								foreach ($keys as $k)
								{
									unset($or[$k]);
								}
							 
								if(!empty($or))
								{
									$task_data=$obj_task->MJ_lawmgt_get_all_task_report($or);
								}
								if(!empty($task_data))
								{													
									foreach ($task_data as $retrieved_data)
									{
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
										$user_name=array();
										$attorney_name1=array();
										$user_id=sanitize_text_field($retrieved_data->assigned_to_user);
										$attorney=sanitize_text_field($retrieved_data->assign_to_attorney);
										$contac_id=explode(',',$user_id);
										foreach($contac_id as $contact_name) 
										{
											$userdata=get_userdata($contact_name);	
											$user_name[]=$userdata->display_name;										   
										}
										$attorney_name=explode(',',$attorney);
										foreach($attorney_name as $attorney_name2) 
										{
											$attorneydata=get_userdata($attorney_name2);	
											$attorney_name1[]=$attorneydata->display_name;
										}
										?>
										<tr> 
											<td><?php echo esc_html($retrieved_data->task_name);?></td>
											<td><?php echo esc_html($case_name2);?></td>		
											<td class="added"><?php echo MJ_lawmgt_getdate_in_input_box($retrieved_data->due_date);?></td>
											<td class="added"><?php echo  esc_html__($statu) ;?></td>
											<td class="contact_link"><?php echo  esc_html($prio); ?></td>	
											<td class="added"><?php echo  esc_html(implode($user_name,','));?></td>
											<td class="added"><?php echo  esc_html(implode($attorney_name1,','));?></td> 
										</tr>
								<?php 
									} 			
								} ?>     
							</tbody>
						</table>
					</div>
				</div>       
			</form>
		</div>
	<?php 
	}
?>