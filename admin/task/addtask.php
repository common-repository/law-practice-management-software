<?php 
$obj_case_tast= new MJ_lawmgt_case_tast;
$casedata=null;
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
		$('#assigned_to_user').multiselect({
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>'
			},
			buttonWidth: '50%',
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
		$('#assign_to_attorney').multiselect({
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>'
			},
			buttonWidth: '50%',
			nonSelectedText :'<?php esc_html_e('Select Attorney Name','lawyer_mgt');?>',
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
		$("#reminder_entry").append('<div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" ><?php esc_html_e('Task Reminders','lawyer_mgt');?></label><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback"><select name="casedata[type][]" id="case_reminder_type"><option selected="selected" value="mail"><?php esc_html_e('Mail','lawyer_mgt');?></option></select></div><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback btn_margin"><input id="remindertimevalue" class="form-control text-input validate[required]" type="number"  value="1" name="casedata[remindertimevalue][]" min="1"></div><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 btn_margin has-feedback"><select name="casedata[remindertimeformat][]" id="case_reminder_type"><option selected="selected" value="day"><?php esc_html_e('Day(s)','lawyer_mgt');?></option><option value="hour"><?php esc_html_e('Hour(s)','lawyer_mgt');?></option></select></div><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Task Due Date','lawyer_mgt');?></label><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger"></div></div>');   		
	}
	function MJ_lawmgt_deleteParentElement(n)
	{
		"use strict";
		alert("<?php esc_html_e('Do you really want to delete this ?','lawyer_mgt');?>");
		n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
	}
</script>	

<?php 	
if($active_tab == 'add_task')
{
	$case_id=0;
	$edt=0;
	if(isset($_REQUEST['task_id']))
		$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['task_id']));
		if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edittask')
		{					
			$edt=1;
			$casedata=$obj_case_tast->MJ_lawmgt_get_all_edit_tast($case_id);
		 
		}		
		$args = array(	
					'role' => 'client',
					'meta_key'     => 'archive',
					'meta_value'   => '0',
					'meta_compare' => '=',
				); 	
			$result =get_users($args);	
        ?>	
	<div class="panel-body"><!-- PANEL BODY DIV  -->
		<form name="task_form" action="" method="post" class="form-horizontal" id="task_form" enctype='multipart/form-data'>	
			<?php $action = sanitize_text_field(isset($_REQUEST['action'])?sanitize_text_field($_REQUEST['action']):'insert');?>
			<input id="action" class="form-control  text-input" type="hidden"  value="<?php if($edt){ echo 'edittask'; }?>" name="action">
			<input type="hidden" name="case_id" value="<?php echo $case_id;?>"  />
			<input type="hidden" name="task_id" id="task_id" value="<?php if($edt){ echo $casedata->task_id;}?>"  />
			<div class="header">	
				<h3 class="first_hed"><?php esc_html_e('Linked To','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Case Name','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<?php 
						global $wpdb;
						$table_case = $wpdb->prefix. 'lmgt_cases';						
						$result = $obj_case->MJ_lawmgt_get_open_all_case();
					 
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
					<input type="text" class="form-control" value="<?php if($edt){ echo esc_html(get_the_title(esc_attr($casedata->practice_area_id))); }?>" name="practice_area_id1" id="practice_area_id1" readonly />
				</div>
			</div>
			<div class="header">
				<h3><?php esc_html_e('Task Information','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="task_name"><?php esc_html_e('Task Name','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="task_name" class="form-control   validate[required] text-input validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]" type="text" placeholder="<?php esc_html_e('Enter Task Name','lawyer_mgt');?>" value="<?php if($edt){ echo esc_attr($casedata->task_name);}elseif(isset($_POST['task_name'])){ echo esc_attr($_POST['task_name']); } ?>" name="task_name">
				</div>
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="due_date"><?php esc_html_e('Due Date','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="due_date"  class="date1 form-control validate[required]  has-feedback-left " data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" type="text"  name="due_date"  placeholder="<?php esc_html_e('Select Due Date','lawyer_mgt');?>"
					value="<?php if($edt){ echo esc_html(MJ_lawmgt_getdate_in_input_box($casedata->due_date));}elseif(isset($_POST['due_date'])){ echo MJ_lawmgt_getdate_in_input_box($_POST['due_date']); } ?>" readonly>
					<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>	
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
					<textarea id="description" class="form-control validate[custom[address_description_validation]]" type="text" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" value="" maxlength="150" name="description"><?php if($edt){ echo esc_textarea($casedata->description); } ?></textarea>
				</div>
			</div>
			<?php wp_nonce_field( 'save_task_nonce' ); ?>
			<div class="form-group">
				<div class="header">							 		
					<div class="form-group">
						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin" for="priority"><?php esc_html_e('Priority','lawyer_mgt');?></label>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
							<select class="form-control " name="priority" id="priority">				
									<option value="0" <?php if($edt && $casedata->priority=='0') { print ' selected'; }?>><?php esc_html_e('High','lawyer_mgt');?></option>
									<option value="1" <?php if($edt && $casedata->priority=='1') { print ' selected'; }?>><?php esc_html_e('Low','lawyer_mgt');?></option>
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
						   $repeatdata= esc_attr($casedata->repeat);
					   }
					   else
					   {
						    $repeatdata="";
					   }
					   ?>
					   <div class="form-group repeatuntil_div display_block_css"  <?php if($edt && $repeatdata=='1' ||$repeatdata=='2' || $repeatdata=='3' || $repeatdata=='4' || $repeatdata=='5') { ?> <?php }?> >
						   <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " ><?php esc_html_e('Repeat Until','lawyer_mgt');?></label>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
								<input id="repeatuntil"  class="date1 form-control validate[required]  has-feedback-left " data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" type="text"  name="repeatuntil"  placeholder=""
									value="<?php if($edt){ echo MJ_lawmgt_getdate_in_input_box($casedata->repeat_until);}elseif(isset($_POST['repeat_until'])){ echo MJ_lawmgt_getdate_in_input_box($_POST['repeat_until']); } ?>">
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
										<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
											<input type="hidden" name="casedata[id][]" value="<?php echo esc_attr($retrive_data->id);?>">
											<select name="casedata[type][]" id="case_reminder_types">
												<option selected="selected" value="mail" <?php if($retrive_data=='mail') { print ' selected'; }?>><?php echo $retrive_data->reminder_type;?></option>
											</select>
										</div>	
										<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback btn_margin">
										<input id="remindertimevalue" class="form-control text-input validate[required]" type="number"  value="<?php echo $retrive_data->reminder_time_value;?>" name="casedata[remindertimevalue][]" min="1">
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
											<input type="button" value="<?php esc_html_e('Remove','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger">
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
							<input type="button" value="<?php esc_html_e('Add Reminder','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_reminder()" class="add_reminder btn btn-success">
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
									<input type="button" value="<?php esc_html_e('Remove','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger">
								</div>		
							</div>		
						</div>				  
						<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
							<input type="button" value="<?php esc_attr_e('Add Reminder','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_reminder()" class="add_reminder btn btn-success">
						</div>	
					<?php 
					} 
					?>
				</div>
			</div>	
			<div class="header">	
				<h3><?php esc_html_e('Assign To','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="assigned_to_user"><?php esc_html_e('Client Name','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback multiselect_validation">
					<?php if($edt){ $data=$casedata->assigned_to_user;}elseif(isset($_POST['assigned_to_user'])){ $data= sanitize_text_field($_POST['assigned_to_user']); }?>
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
								$user_name=$userdata->display_name;		
							?>
							<option value="<?php print esc_attr($Editdata1->user_id);?>" <?php echo in_array($Editdata1->user_id,explode(',',$data)) ? 'selected': ''; ?>>
									<?php echo esc_html($user_name);?>
							</option>
							<?php 
							 }
							 ?>
						</select>
				</div>
				 
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="assigned_to_attorney"><?php esc_html_e('Attorney Name','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback multiselect_validation123">
					<?php if($edt){ $data=$casedata->assign_to_attorney;}elseif(isset($_POST['assign_to_attorney'])){ $data=sanitize_text_field($_POST['assign_to_attorney']); }?>
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
								$user_name=$user_details->display_name;	
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
		</form>
	</div><!-- END PANEL BODY DIV  -->
<?php 
}
?>