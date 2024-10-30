<?php	
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
			
			$("#event_div").append('<div class="form-group workflow_item"><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="event_subject"><?php esc_html_e('Event Subject','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback"><input id="event_subject'+value+'" opt_class="op'+value+'" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]  text-input event_subject"  type="text" placeholder="<?php esc_html_e('Enter Event Subject','lawyer_mgt');?>" value="" name="event_subject[]"><span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span></div></div><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="event_description"><?php esc_html_e('Event Description','lawyer_mgt');?></label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback"><textarea rows="2"  class="validate[custom[address_description_validation],maxSize[150]] width_100_per_resize_css" name="event_description[] width_100_per_resize_css" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" id="event_description"></textarea></div></div><div class="form-group"><div class="offset-lg-2 col-lg-2 offset-md-2 col-md-2 offset-sm-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt');?>" class="remove_event btn btn-danger" onclick="MJ_lawmgt_deleteParentElement_task(this)" row="'+value+'"></div></div></div>');   

			$(".task_event_name").append('<option class=op'+value+'></option>');
		} 
		"use strict";		
		var value = 1;
		function MJ_lawmgt_add_task()
		{
			"use strict";
			value++;
			$("#task_div").append('<div class="form-group workflow_item"><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="task_subject"><?php esc_html_e('Task Subject','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback"><input id="task_subject" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input onlyletter_number_space_validation " type="text" placeholder="<?php esc_html_e('Enter Task Subject','lawyer_mgt');?>" value="" name="task_subject[]"><span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span></div></div><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="task_description"><?php esc_html_e('Task Description','lawyer_mgt');?></label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback"><textarea rows="2" name="task_description[]" class="validate[custom[address_description_validation],maxSize[150]] width_100_per_resize_css" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>"  id="task_description"></textarea></div></div><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="due_date_type"><?php esc_html_e('Due Date','lawyer_mgt');?></label><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><select class="form-control due_date_type'+value+'" name="due_date_type[]"  id="due_date_type" row="'+value+'" ><option value="automatically"><?php esc_html_e('Automatically','lawyer_mgt');?></option><option value="no_due_date" selected><?php esc_html_e('No due date','lawyer_mgt');?></option></select></div><div class="date_time_by_event date_time_by_event_css  date_time_by_event'+value+'"><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><input class="form-control validate[required] text-input" type="number" placeholder="<?php esc_html_e('Enter Days','lawyer_mgt');?>" value="1" name="days[]"></div><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><select class="form-control" name="day_formate[]" id="days"><option value="days" selected><?php esc_html_e('Days','lawyer_mgt');?></option></select></div><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><select class="form-control" name="day_type[]" id="days"><option value="before" selected><?php esc_html_e('Before','lawyer_mgt');?></option><option value="after" >After</option></select></div><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><select class="form-control validate[required] task_event_name task_event_name'+value+'" name="task_event_name[]" id="task_event_name"></select></div></div></div><div class="form-group"><div class="offset-lg-2 col-lg-2 offset-md-2 col-md-2 offset-sm-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement_task(this)" class="remove_task btn btn-danger"></div></div>');   		
			
			var event_name=[];
			var i=0;
				
			$(".event_subject").each(function () 
			{				
				var e_subject=$(this).val();
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
if($active_tab == 'add_workflow')
{
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
    <div class="panel-body"><!-- PANEL BODY DIV  -->
        <form name="workflow_form" action="" method="post" class="form-horizontal" id="workflow_form" enctype='multipart/form-data'>	
			<?php $action = sanitize_text_field(isset($_REQUEST['action'])?sanitize_text_field($_REQUEST['action']):'insert');?>
			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
			<input type="hidden" name="workflow_id1" value="<?php echo esc_attr($workflow_id);?>"  />
			<div class="header">	
				<h3 class="first_hed"><?php esc_html_e('Workflow Information','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="workflow_name"><?php esc_html_e('Workflow Name','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
					<input id="workflow_name" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter]] text-input " maxlength="50" type="text" placeholder="<?php esc_html_e('Enter Workflow Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($workflow_info->name);}elseif(isset($_POST['workflow_name'])){ echo esc_attr($_POST['workflow_name']); } ?>" name="workflow_name">
					<span class="fab fa-stack-overflow form-control-feedback left" aria-hidden="true"></span>
				</div>			
			</div>	
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="workflow_description"><?php esc_html_e('Workflow Description','lawyer_mgt');?></label>
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
					<textarea rows="3" class="validate[custom[address_description_validation],maxSize[150]] width_100_per_resize_css" name="workflow_description" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" id="workflow_description"><?php if($edit){ echo esc_textarea($workflow_info->description);}elseif(isset($_POST['workflow_description'])){ echo esc_textarea($_POST['workflow_description']); } ?></textarea>
				</div>		
			</div>
			<?php wp_nonce_field( 'save_workflow_nonce' ); ?>
			<div class="form-group">		
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="permission_type"><?php esc_html_e('Workflow Permissions','lawyer_mgt');?></label>
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
					<select class="form-control" name="permission_type" id="workflow_permission_type">				
							 <?php if($edit)
							$permission_type  = esc_attr($workflow_info->permission);					
						else 
							 $permission_type = ""; 
						 ?>
						<option value="Private" <?php if($permission_type == 'Private') echo 'selected = "selected"';?>><?php esc_html_e('This is my private workflow','lawyer_mgt');?></option>
						<option value="Public" <?php  if($permission_type == 'Public') echo 'selected = "selected"';  ?>><?php esc_html_e('Share this workflow with all users','lawyer_mgt');?></option>	
					</select>
				</div>
			</div>
			<div class="form-group">	
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="assginedto"><?php esc_html_e('Assigned To Attorney','lawyer_mgt');?><span class="require-field">*</span></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">			
					<select class="form-control case_assgined_to validate[required]" name="assginedto" id="assginedto">
					<option value=""><?php esc_html_e('Select Attorney Name','lawyer_mgt');?></option>
						<?php 
						 if($edit)
						 {
							$assginedto = esc_attr($workflow_info->assgined_to);
						 }							
						else 
						{
							$assginedto = "";
						}
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
			<div class="header">	
				<h3 class="first_hed workflow_event"><?php esc_html_e('Workflow Events 3','lawyer_mgt');?></h3>
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
										<input id="event_subject" opt_class="<?php echo 'op'.$value; ?>" class="form-control has-feedback-left  validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input event_subject " type="text" placeholder="<?php esc_html_e('Enter Event Subject','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($retrive_data->subject);}elseif(isset($_POST['event_subject'])){ echo esc_attr($_POST['event_subject']); } ?>" name="event_subject[]">
										<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="event_description"><?php esc_html_e('Event Description','lawyer_mgt');?></label>
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
										<textarea rows="2" name="event_description[]"   class="validate[required,custom[address_description_validation],maxSize[150]] width_100_per_resize_css" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" id="event_description"><?php if($edit){ echo esc_textarea($retrive_data->description);}elseif(isset($_POST['event_description'])){ echo esc_textarea($_POST['event_description']); } ?></textarea>
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
	 <?php  } ?>			
			<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
				<input type="button" value="<?php esc_attr_e('Add More Event','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_event()" class="add_event btn btn-primary">
			</div>			
			<div class="header">	
				<h3 class="first_hed workflow_task"><?php esc_html_e('Workflow Tasks','lawyer_mgt');?></h3>
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
									<input id="task_subject" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input "  type="text" placeholder="<?php esc_html_e('Enter Task Subject','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($retrive_data->subject);}elseif(isset($_POST['task_subject'])){ echo esc_attr($_POST['task_subject']); } ?>" name="task_subject[]">
									<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="task_description"><?php esc_html_e('Task Description','lawyer_mgt');?></label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
									<textarea rows="2" name="task_description[]" class="validate[required,custom[address_description_validation],maxSize[150]] width_100_per_resize_css"  placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" id="task_description"><?php if($edit){ echo esc_textarea($retrive_data->description);}elseif(isset($_POST['task_description'])){ echo esc_textarea($_POST['task_description']); } ?></textarea>
								</div>	
							</div>
							<?php
								$due_date = esc_attr($retrive_data->due_date);
								$data=json_decode( $due_date);
							?>
							<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="due_date_type"><?php esc_html_e('Due Date','lawyer_mgt');?></label>						
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
								<select class="form-control due_date_type<?php echo $value; ?>" name="due_date_type[]" id="due_date_type" row="<?php echo $value; ?>">
								 <?php if($edit)
										$due_date_type = esc_attr($data->due_date_type);					
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
								<div class="date_time_by_event  date_time_by_event<?php echo $value; ?> " row="<?php echo $value; ?>" >	
																
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
												$day_type = esc_attr($data->day_type);					
												else 
												$day_type = ""; 
											?>
												<option value="before" <?php if($day_type == 'before') echo 'selected = "selected"';?>><?php esc_html_e('Before','lawyer_mgt');?></option>
												<option value="after" <?php if($day_type == 'after') echo 'selected = "selected"';?> ><?php esc_html_e('After','lawyer_mgt');?></option>
											</select>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
											<select class="form-control validate[required] task_event_name task_event_name<?php echo $value; ?>" name="task_event_name[]" id="task_event_name">
											<?php 
											 if($edit)
												$task_event_name = esc_attr($data->task_event_name);				
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
								<div class="date_time_by_event date_time_by_event_css  date_time_by_event<?php echo $value; ?>" row="<?php echo $value; ?>" >	
																
										<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
											<input class="form-control validate[required] text-input" type="number" placeholder="<?php esc_html_e('Enter Days','lawyer_mgt');?>" value="1" name="days[]">
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
											<select class="form-control" name="day_formate[]" id="days">	

												<option value="days" selected><?php esc_html_e('Days','lawyer_mgt');?></option>
											</select>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
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
													<option class="<?php echo esc_attr($retrive_data->e_class);?>" value="<?php echo esc_attr($retrive_data->subject);?>" ><?php echo esc_html($retrive_data->subject); ?> </option>
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
									<input type="button" value="<?php esc_html_e('Remove','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement_task(this)" class="remove_task btn btn-danger">
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
				<input type="button" value="<?php esc_attr_e('Add More Task','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_task()" class="add_task btn btn-primary">
			</div>			
			<div class="offset-sm-2 col-sm-8">
				<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Add Workflow','lawyer_mgt');}?>" name="save_workflow" class="btn btn-success"/>
			</div>
		</form>
    </div>      <!-- END PANEL BODY DIV  -->  
<?php 
}
?>