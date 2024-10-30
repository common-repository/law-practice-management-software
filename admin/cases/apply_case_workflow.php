<!-- Workflow Pop up Code -->
<div class="popup-bg1">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="workflow_list">
			</div>     
		</div>
    </div>     
</div>
<!-- Workflow List End POP-UP Code -->
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		"use strict";
		$('#workflow_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
		
		/* $(".event_contact").multiselect({ 
			  nonSelectedText :'Select Client Name',
			 includeSelectAllOption: true         
		 }); */
		 
		 /* $(".task_contact").multiselect({ 
			 nonSelectedText :'Select Client Name',
			 includeSelectAllOption: true         
		 }); */
		 
		 
		 $('.event_contact').multiselect({
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>'
			},
			buttonWidth: '100%',
			nonSelectedText :'<?php esc_html_e('Select Client Name','lawyer_mgt');?>',
			selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
			enableFiltering: true,
			filterBehavior: 'text',
			enableCaseInsensitiveFiltering: true,
			includeSelectAllOption: true ,
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>',
				filter: '<li class="multiselect-item filter"><div class="input-group m-0 mb-1"><input class="form-control multiselect-search" type="text"></div></li>',
				filterClearBtn: '<div class="input-group-append"><button class="btn btn btn-outline-secondary multiselect-clear-filter" type="button"><i class="fa fa-times"></i></button></div>'
			}
			});
		 
		 $('.task_contact').multiselect({
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>'
			},
			buttonWidth: '100%',
			nonSelectedText :'<?php esc_html_e('Select Client Name','lawyer_mgt');?>',
			selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
			enableFiltering: true,
			filterBehavior: 'text',
			enableCaseInsensitiveFiltering: true,
			includeSelectAllOption: true ,
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>',
				filter: '<li class="multiselect-item filter"><div class="input-group m-0 mb-1"><input class="form-control multiselect-search" type="text"></div></li>',
				filterClearBtn: '<div class="input-group-append"><button class="btn btn btn-outline-secondary multiselect-clear-filter" type="button"><i class="fa fa-times"></i></button></div>'
			}
			});
		 //------ADD workflow AJAX----------
		   $('#add_workflow_form').on('submit', function(e) 
		   {	
				e.preventDefault();
				//var form = $(this).serialize(); 
				var valid = $('#add_workflow_form').validationEngine('validate');
				if (valid == true) 
				{		 
					var form = new FormData(this);
					
					$.ajax({
						type:"POST",
						url: $(this).attr('action'),
						data:form,
						cache: false,
						contentType: false,
						processData: false,
						success: function(data)
						{	
							if(data!="")
							{ 
								var json_obj = $.parseJSON(data);
								$('#add_workflow_form').trigger("reset");
								$('#apply_workflow_name').append(json_obj);						
								$('.modal').modal('hide');
							}       
						},
							error: function(data){
						}
					})
				}
			});  
	});
</script> 
	<?php 	
	$obj_workflow=new MJ_lawmgt_workflow;
	$obj_caseworkflow=new MJ_lawmgt_caseworkflow;
	$workflow_id=0;
	$edit=0;
	if(isset($_REQUEST['workflow_id']))
		$workflow_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['workflow_id']));
		$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
	if(isset($_REQUEST['edit']) && sanitize_text_field($_REQUEST['edit']) == 'true')
	{					
		$edit=1;
		$workflow_allevents=$obj_caseworkflow->MJ_lawmgt_get_single_applyworkflow_allevents_by_caseid($workflow_id,$case_id);
	} 
	?> 
    <div class="panel-body"><!-- PANEL BODY  DIV -->
        <form name="workflow_form" action="" method="post" class="form-horizontal" id="workflow_form" enctype='multipart/form-data'>	
			<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">	
			<input type="hidden" id="case_id" name="case_id" value="<?php echo esc_attr($case_id);?>"  />		
			<input type="hidden" name="workflow_id" value="<?php echo esc_attr($workflow_id);?>"  />		
			<div class="header">	
				<h3 class="first_hed"><?php esc_html_e('Workflow Information','lawyer_mgt');?></h3>
				<hr>
			</div>	
			<?php wp_nonce_field( 'save_case_work_nonce' ); ?>
			<?php
			if($edit==0)
			{
			?>
				<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Select Workflow','lawyer_mgt');?><span class="require-field">*</span></label>
					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">			
						<select class="form-control validate[required]" name="workflow_name" id="apply_workflow_name">
							<option value=""><?php esc_html_e('Select Workflow','lawyer_mgt');?></option>
							<?php 
							$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
							$attorney_id=$obj_workflow->MJ_lawmgt_get_attorney_by_case($case_id);
						
							$workflow_data=$obj_workflow->MJ_lawmgt_get_all_workflow_by_case_attorney($attorney_id); 
							
							if(!empty($workflow_data))
							{
								foreach ($workflow_data as $retrive_data)
								{ 		 	
								?>
									<option value="<?php echo esc_attr($retrive_data->id);?>"><?php echo esc_html($retrive_data->name); ?> </option>
								<?php 
								}
							} 
							?> 
						</select>	
					</div>	
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
						<a href="#" class="btn btn-success" data-toggle="modal" data-target="#myModal_add_workflow"> <?php esc_html_e('Add Workflow','lawyer_mgt');?></a>	
					</div>			
				</div>			
				<div class="apply_workflow_details_div">			
				</div>	
			<?php 
			}			
			if($edit==1)
			{
			?>
				<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Workflow Name','lawyer_mgt');?></label>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
					<?php $workflow_name=MJ_lawmgt_get_workflow_name($workflow_id);?>
						<input type="text" class="form-control" name="workflow_name"  value="<?php echo esc_attr($workflow_name);?>" readonly="readonly">	
					</div>					
				</div>
				<div class="header">	
				<h3 class="first_hed"><?php esc_html_e('Workflow Events','lawyer_mgt');?></h3>
				<hr>
				</div>	
				<?php
				if(!empty($workflow_allevents))
				{				
					foreach ($workflow_allevents as $retrive_data)
					{
					?>						
						<div class="form-group workflow_item overflw">
							<input type="hidden" name="event_id[]" value="<?php echo esc_attr($retrive_data->id);?>">
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="event_subject"><?php esc_html_e('Event Subject','lawyer_mgt');?></label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
									<input id="event_subject" class="form-control has-feedback-left validate[required,custom[onlyLetterSp]] text-input event_subject" type="text" placeholder="<?php esc_html_e('Enter Event Subject','lawyer_mgt');?>" value="<?php echo esc_attr($retrive_data->subject);?>" name="event_subject[]" readonly="readonly">
									<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Event Date','lawyer_mgt');?><span class="require-field">*</span></label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
									<input class="form-control has-feedback-left validate[required] text-input event_date apply_case_event_date" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" type="text" placeholder="<?php esc_html_e('Select Event Date','lawyer_mgt');?>" value="<?php if($edit){ echo esc_html(MJ_lawmgt_getdate_in_input_box($retrive_data->event_date));}elseif(isset($_POST['event_date'])){ echo esc_html(MJ_lawmgt_getdate_in_input_box($_POST['event_date'])); } ?>" name="event_date[]" readonly>
									<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
								</div>	
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" ><?php esc_html_e('Attendees','lawyer_mgt');?></label>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">			
								<select class="form-control event_contact"  multiple="multiple" name="event_contact[<?php echo esc_attr($retrive_data->subject);?>][]">			
									<?php
									global $wpdb;
				
									$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
									
									$case_conacts = $wpdb->get_results("SELECT * FROM $table_case_contacts where case_id=".$case_id);
									
									$selected_attendees=explode(",",$retrive_data->attendees);			
									
									if(!empty($case_conacts))
									{
										foreach ($case_conacts as $retrive_data)
										{ 													
											$contact_name=MJ_lawmgt_get_display_name($retrive_data->user_id);
											?>
												<option value="<?php echo esc_attr($retrive_data->user_id);?>" <?php if(!empty($selected_attendees)){ if(in_array($retrive_data->user_id,$selected_attendees)) { print "selected"; } }?>><?php echo esc_html($contact_name);?></option>	
										<?php
										} 
									} 		
																		
									?>	
								</select>				
								</div>
							</div>
						</div>	
				<?php
					}
				} 
				?>		
				<div class="header">	
					<h3 class="first_hed"><?php esc_html_e('Workflow Tasks','lawyer_mgt');?></h3>
					<hr>
				</div>
				<?php

				if(!empty($workflow_alltasks))
				{				
					foreach ($workflow_alltasks as $retrive_data)
					{ 
					
					?>
					
						<div class="form-group workflow_item">
							<input type="hidden" name="task_id[]" value="<?php echo esc_attr($retrive_data->id);?>">
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="task_subject"><?php esc_html_e('Task Subject','lawyer_mgt');?></label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
									<input id="event_subject" class="form-control has-feedback-left validate[required] text-input task_subject" type="text" placeholder="<?php esc_html_e('Enter task Subject','lawyer_mgt');?>" value="<?php echo esc_attr($retrive_data->subject);?>" name="task_subject[]" readonly="readonly">
									<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label "><?php esc_html_e('Due Date','lawyer_mgt');?></label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
							<?php
								$due_date=$retrive_data->due_date;
								$data=json_decode($due_date);
								$due_date_type =$data->due_date_type;
								$days =$data->days;
								$day_formate =$data->day_formate;
								$day_type =$data->day_type;
								$task_event_name =$data->task_event_name;
							?>
								<input type="hidden" name="due_date_type[]" value=<?php  echo esc_attr($due_date_type);?>>
								<input type="hidden" name="days[]" value=<?php echo esc_attr($days);?>>
								<input type="hidden" name="day_formate[]" value=<?php echo esc_attr($day_formate);?>>
								<input type="hidden" name="day_type[]" value=<?php echo esc_attr($day_type);?>>
								<input type="hidden" name="task_event_name[]" value=<?php echo esc_attr($task_event_name);?>>
								<?php
								if($data->due_date_type == 'automatically')
								{
								?>
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label task_due_date_css" name="due_date[]"> <?php echo esc_html($days);?> <?php echo esc_html($day_formate);?> <?php echo esc_html($day_type);?> <?php echo esc_html($task_event_name);?> </label>
								<?php
								}
								else
								{
								?>
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label task_due_date_css" name="due_date[]"><?php esc_html_e('No Due Date','lawyer_mgt');?></label>
							 <?php
								}
								?>
							</div>	
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" ><?php esc_html_e('Assign To','lawyer_mgt');?></label>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">			
									<select class="form-control task_contact"  multiple="multiple" name="task_contact[<?php echo esc_attr($retrive_data->subject);?>][]">	
										<?php		
										global $wpdb;
					
										$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
										
										$case_conacts = $wpdb->get_results("SELECT * FROM $table_case_contacts where case_id=".$case_id);
										
										$selected_assign_to=explode(",",$retrive_data->assign_to);			
										
										if(!empty($case_conacts))
										{
											foreach ($case_conacts as $retrive_data)
											{ 	
												$contact_name=MJ_lawmgt_get_display_name($retrive_data->user_id);
												?>	
													<option value="<?php echo esc_attr($retrive_data->user_id);?>" <?php if(!empty($selected_assign_to)){ if(in_array($retrive_data->user_id,$selected_assign_to)) { print "selected"; } }?>><?php echo esc_html($contact_name);?></option>	
										<?php
											} 
										} 						
										?>	
									</select>				
								</div>
							</div>
						</div>
							<?php
					}
				}						
			}
			?>
			<div class="offset-sm-2 col-sm-8 workflow_top_10">
				<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Apply Workflow','lawyer_mgt');}?>" name="save_workflow" class="btn btn-success"/>
			</div>
		</form>
    </div>
	 
    <!----------ADD Workflow-----
	-------->	 
<script type="text/javascript">
var $ = jQuery.noConflict();
	jQuery(document).ready(function($)
	{
		"use strict";
		$('#add_workflow_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	});
	 "use strict";
	var value = 1;
	function MJ_lawmgt_add_event()
   	{
	   "use strict";
		value++;
		
   		$("#event_div").append('<div class="form-group workflow_item"><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="event_subject"><?php esc_html_e('Event Subject','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback"><input id="event_subject'+value+'" opt_class="op'+value+'" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input event_subject" type="text" placeholder="<?php esc_html_e('Enter Event Subject','lawyer_mgt');?>" value="" name="event_subject[]"><span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span></div></div><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="event_description"><?php esc_html_e('Event Description','lawyer_mgt');?></label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback"><textarea rows="2"  class=" width_100_per_resize_css validate[custom[address_description_validation],maxSize[150]]" name="event_description[]" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" id="event_description"></textarea></div></div><div class="form-group"><div class="offset-lg-2 col-lg-2 offset-md-2 col-md-2 offset-sm-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt');?>" class="remove_event btn btn-danger" row="'+value+'"></div></div></div>');   

		$(".task_event_name").append('<option class=op'+value+'></option>');
   	}  	
	"use strict";
	var value = 1;
	function MJ_lawmgt_add_task()
   	{
	   "use strict";
		value++;
   		$("#task_div").append('<div class="form-group workflow_item"><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="task_subject">Task Subject<span class="require-field">*</span></label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback"><input id="task_subject" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input " type="text" placeholder="<?php esc_html_e('Enter Task Subject','lawyer_mgt');?>" value="" name="task_subject[]"><span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span></div></div><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="task_description">Task Description</label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback"><textarea rows="2"  name="task_description[]" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" class=" width_100_per_resize_css validate[custom[address_description_validation],maxSize[150]]"  id="task_description"></textarea></div></div><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="due_date_type">Due Date</label><div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"><select class="form-control due_date_type'+value+'" name="due_date_type[]"  id="due_date_type" row="'+value+'" ><option value="automatically"><?php esc_html_e('Automatically','lawyer_mgt');?></option><option value="no_due_date" selected><?php esc_html_e('No due date','lawyer_mgt');?></option></select></div><div class="date_time_by_event date_time_by_event_css  date_time_by_event'+value+'"><div class="days_pading_0px col-lg-1 col-md-1 col-sm-12 col-xs-12"><input class="form-control validate[required] text-input" type="number" placeholder="<?php esc_html_e('Enter Days','lawyer_mgt');?>" value="1" name="days[]"></div><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><select class="form-control" name="day_formate[]" id="days"><option value="days" selected><?php esc_html_e('Days','lawyer_mgt');?></option></select></div><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><select class="form-control" name="day_type[]" id="days"><option value="before" selected><?php esc_html_e('Before','lawyer_mgt');?></option><option value="after" ><?php esc_html_e('After','lawyer_mgt'); ?></option></select></div><div class=" task_event_name_padding_opx col-lg-2 col-md-2 col-sm-12 col-xs-12"><select class="form-control validate[required] task_event_name task_event_name'+value+'" name="task_event_name[]" id="task_event_name"></select></div></div></div><div class="form-group"><div class="offset-lg-2 col-lg-2 offset-md-2 col-md-2 offset-sm-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt'); ?>" onclick="MJ_lawmgt_deleteParentElement_task(this)" class="remove_task btn btn-danger"></div></div>');   		
		
		var event_name=[];
		var i=0;
			
		$(".event_subject").each(function () 
		{
			"use strict";
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
	     n.closest('.workflow_item').remove();	  
   	}
</script>  
<div class="modal fade overflow_scroll_css" id="myModal_add_workflow" role="dialog"> <!---- MODEL DIV    ---------->
    <div class="modal-dialog modal-lg"><!---- MODEL DIALOG DIV    ---------->
		<div class="modal-content"><!---- MODEL CONTANT DIV    ---------->
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h3 class="modal-title"><?php esc_html_e('Add Workflow','lawyer_mgt');?></h3>
			</div>
			<div class="modal-body">
				<form name="add_workflow_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form-horizontal" id="add_workflow_form" enctype='multipart/form-data'>	
					<input type="hidden" name="action" value="MJ_lawmgt_add_workflow_into_database">		
					<input type="hidden" name="workflow_id" value="<?php echo esc_attr($workflow_id);?>"  />
					<div class="header">	
						<h3 class="first_hed"><?php esc_html_e('Workflow Information','lawyer_mgt');?></h3>
						<hr>
					</div>
					<div class="form-group">
						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="workflow_name"><?php esc_html_e('Workflow Name','lawyer_mgt');?><span class="require-field">*</span></label>
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
							<input id="workflow_name" class="form-control has-feedback-left validate[required] text-input onlyletter_number_space_validation" maxlength="50" type="text" placeholder="<?php esc_html_e('Enter Workflow Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($workflow_info->name);}elseif(isset($_POST['workflow_name'])){ echo esc_attr($_POST['workflow_name']); } ?>" name="workflow_name">
							<span class="fa fa-stack-overflow form-control-feedback left" aria-hidden="true"></span>
						</div>			
					</div>	
					<div class="form-group">
						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="workflow_description"><?php esc_html_e('Workflow Description','lawyer_mgt');?></label>
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
							<textarea rows="3"  class="width_100_per_resize_css" name="workflow_description" maxlength="150" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" id="workflow_description"><?php if($edit){ echo esc_textarea($workflow_info->description);}elseif(isset($_POST['workflow_description'])){ echo esc_textarea($_POST['workflow_description']); } ?></textarea>
						</div>		
					</div>		
					<div class="form-group">		
						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="permission_type"><?php esc_html_e('Workflow Permissions','lawyer_mgt');?></label>
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
						<select class="form-control" name="permission_type" id="workflow_permission_type">				
								 <?php 
							if($edit)
								$permission_type = esc_attr($workflow_info->permission);					
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
							<div class="col-sm-4">			
						<select class="form-control case_assgined_to validate[required]" name="assginedto" id="assginedto">
							<option value=""><?php esc_html_e('Select Attorney');?></option>
							<?php 
							
							$attorney_id=$obj_workflow->MJ_lawmgt_get_attorney_by_case($case_id);
							$assginedto=explode(',',$attorney_id);
							
							if(!empty($assginedto))
							{
								foreach ($assginedto as $retrive_data)
								{ 		
									$user_info = get_userdata($retrive_data);		
									?>
									<option value="<?php echo esc_attr($user_info->ID);?>"><?php echo esc_attr($user_info->display_name); ?> </option>
								<?php
								}
							} 
							?> 
							</select>
						</div>
					</div>	
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
								$e_name_array_A = array_map( 'sanitize_text_field', wp_unslash( $e_name_array ) );				  
								$event_name_array=json_encode($e_name_array_A);					  
												  
								?>					
									<div class="form-group workflow_item">
										<div class="form-group">
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="event_subject"><?php esc_html_e('Event Subject','lawyer_mgt');?><span class="require-field">*</span></label>
											<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
												<input id="event_subject" opt_class="<?php echo 'op'.$value; ?>" class="form-control has-feedback-left validate[required] text-input event_subject onlyletter_number_space_validation" maxlength="50" type="text" placeholder="<?php esc_html_e('Enter Event Subject','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($retrive_data->subject);}elseif(isset($_POST['event_subject'])){ echo esc_attr($_POST['event_subject']); } ?>" name="event_subject[]">
												<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="event_description"><?php esc_html_e('Event Description','lawyer_mgt');?></label>
											<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
												<textarea rows="2" class="width_100_per_resize_css" name="event_description[]" maxlength="150" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" id="event_description"><?php if($edit){ echo esc_attr($retrive_data->description);}elseif(isset($_POST['event_description'])){ echo esc_attr($_POST['event_description']); } ?></textarea>
											</div>	
										</div>	
										<div class="form-group">
											<div class="offset-lg-2 col-lg-2 offset-md-2 col-md-2 offset-sm-2 col-sm-2 col-xs-12">
												<input type="button" value="<?php esc_html_e('Remove','lawyer_mgt') ?>" class="remove_event btn btn-danger" row="<?php echo $value; ?>">
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
					<div class=" offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
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
											<input id="task_subject" class="form-control has-feedback-left validate[required] text-input onlyletter_number_space_validation" maxlength="50" type="text" placeholder="<?php esc_html_e('Enter Task Subject','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($retrive_data->subject);}elseif(isset($_POST['task_subject'])){ echo esc_attr($_POST['task_subject']); } ?>" name="task_subject[]">
											<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="task_description"><?php esc_html_e('Task Description','lawyer_mgt');?></label>
										<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
											<textarea rows="2" class="width_100_per_resize_css"  name="task_description[]" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" maxlength="150" id="task_description"><?php if($edit){ echo esc_textarea($retrive_data->description);}elseif(isset($_POST['task_description'])){ echo esc_textarea($_POST['task_description']); } ?></textarea>
										</div>	
									</div>
									<?php
										$due_date=$retrive_data->due_date;
										$data=json_decode( $due_date);
									?>
									<div class="form-group">
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="due_date_type"><?php esc_html_e('Due DateDue Date','lawyer_mgt');?></label>						
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
															<option class="<?php echo esc_attr($retrive_data->e_class);?>" value="<?php echo esc_attr($retrive_data->subject);?>" <?php selected($task_event_name,$retrive_data->subject);  ?>><?php echo esc_attr($retrive_data->subject); ?> </option>
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
										<div class="date_time_by_event date_time_by_event_css  date_time_by_event<?php echo $value; ?> col-md-8" row="<?php echo esc_attr($value); ?>" >	
																		
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
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
													<select class="form-control validate[required] task_event_name task_event_name<?php echo $value; ?>" name="task_event_name[]" id="task_event_name">
													<?php 
													$event_data = json_decode($event_name_array);
													if(!empty($event_data))
													{									
															foreach ($event_data as $retrive_data)
															{ 				 	
															
														?>
															<option class="<?php echo esc_attr($retrive_data->e_class);?>" value="<?php echo esc_attr($retrive_data->subject);?>" ><?php echo esc_attr($retrive_data->subject); ?> </option>
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
					<div class=" offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
						<input type="button" value="<?php esc_attr_e('Add More Task','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_task()" class="add_task btn btn-success">
					</div>			
					<div class="offset-sm-2 col-sm-8">
						<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Add Workflow','lawyer_mgt');}?>" name="save_workflow" class="btn btn-success"/>
					</div>
				</form>
			</div>	  
		</div>	<!---- END MODEL CONTANT DIV    ---------->  
	</div>	 <!---- MODEL DIALOG DIV    ---------->  
</div>	 <!---- MODEL DIV    ---------->