<?php 
$obj_case_tast= new MJ_lawmgt_case_tast;
$event=new MJ_lawmgt_Event;
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
if($active_tab == 'event')
{
    $active_tab = isset($_GET['tab3'])?$_GET['tab3']:'eventlist';
	?>
		<h2>
			<ul id="myTab" class="sub_menu_css line nav nav-tabs" role="tablist">
				<li role="presentation" class="<?php echo esc_html($active_tab) == 'eventlist' ? 'active' : ''; ?>">
					<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=event&tab3=eventlist&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
						<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Event List', 'lawyer_mgt'); ?>
					</a>
				</li>
				<?php if(isset($_REQUEST['editevent'])&& sanitize_text_field($_REQUEST['editevent'])=='true') {?>
				<li role="presentation" class="<?php echo esc_html($active_tab) == 'addevent' ? 'active' : ''; ?>">
					<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=event&tab3=addevent&editevent=true&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&id=<?php echo esc_attr($_REQUEST['id']);?>">
						<?php echo esc_html__('Edit Event', 'lawyer_mgt'); ?>
					</a>
				</li>
				<?php }else{?>
				<li role="presentation" class="<?php echo esc_html($active_tab) == 'addevent' ? 'active' : ''; ?>">
					<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=event&tab3=addevent&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
						<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Event', 'lawyer_mgt'); ?>	
					</a>
				</li>
				<?php }?>
				<?php if(isset($_REQUEST['viewevent'])&& sanitize_text_field($_REQUEST['viewevent'])=='true') {?>
				<li role="presentation" class="<?php echo esc_html($active_tab) == 'viewevent' ? 'active' : ''; ?>">
					<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=event&tab3=viewevent&viewevent=true&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&id=<?php echo esc_attr($_REQUEST['id']);?>">
						<?php echo esc_html__('View Event', 'lawyer_mgt'); ?>
					</a>
				</li>
				<?php } ?>
			</ul>	
		</h2>
		<?php
		if($active_tab=='viewevent')
		{
			require_once LAWMS_PLUGIN_DIR. '\admin\cases\view_case_event.php';
		}			
        if($active_tab=='addevent')
		{	
			$event_id=0;
			$edt=0;
			if(isset($_REQUEST['id']))
				$event_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id']));
				if(isset($_REQUEST['editevent']) && sanitize_text_field($_REQUEST['editevent']) == 'true')
				{					
					$edt=1;
					$casedata=$event->MJ_lawmgt_get_signle_event_by_id($event_id);
				}?>
				
				<script type="text/javascript">
				var $ = jQuery.noConflict();
				jQuery(document).ready(function($)
				{
					"use strict";
					jQuery('#event_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
					
					var start = new Date();
					var end = new Date(new Date().setYear(start.getFullYear()+1));

					$('.date1').datepicker({
						startDate : start,
						endDate   : end,
						autoclose: true
					}).on('changeDate', function(){
						$('.date2').datepicker('setStartDate', new Date($(this).val()));
					}); 

					$('.date2').datepicker({
						startDate : start,
						endDate   : end,
						autoclose: true
					}).on('changeDate', function(){
						$('.date1').datepicker('setEndDate', new Date($(this).val()));
					});
					
					jQuery('.time').timepicker({
				
						});	
					$(".submitevent").on('click', function()
					{
						
						var start_date = $("#start_date").val();
						var end_date = $("#end_date").val();
						var start_time = $("#start_time").val();
						var end_time = $("#end_time").val(); 
						
						if(start_date != "" || end_date != "" || start_time != "" || end_time != "")
						{							
							if(start_date == end_date)
							{								
								if(start_time > end_time)
								{
									 alert("<?php esc_html_e('event start time must less then the end time...','lawyer_mgt');?>");
									$("#end_time").val('');
								}	
							}
						}
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
					 
					$(".submitevent").on("click",function()
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
					 
					$(".submitevent").on("click",function()
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
					$("#reminder_entry").append('<div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" ><?php esc_html_e('Event Reminders','lawyer_mgt');?></label><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback"><select name="casedata[type][]" id="case_reminder_type"><option selected="selected" value="mail"><?php esc_html_e('Mail','lawyer_mgt');?></option></select></div><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 btn_margin has-feedback"><input id="remindertimevalue" class="form-control text-input validate[required]" type="number"  value="1" name="casedata[remindertimevalue][]" min="1"></div><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback btn_margin"><select name="casedata[remindertimeformat][]" id="case_reminder_type"><option selected="selected" value="day"><?php esc_html_e('Day(s)','lawyer_mgt');?></option><option value="hour"><?php esc_html_e('Hour(s)','lawyer_mgt');?></option></select></div><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Event Start Date','lawyer_mgt');?></label><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger"></div></div>');   		
				}  	

				function MJ_lawmgt_deleteParentElement(n)
				{
					"use strict";
					alert("<?php esc_html_e('Do you really want to delete this ?','lawyer_mgt');?>");
					n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
				}
			</script>		
			<div class="panel-body"><!-- PANEL BODY DIV -->
				<form name="event_form" action="" method="post" class="form-horizontal" id="event_form" enctype='multipart/form-data'>	
				   <?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
					<input id="action" class="form-control  text-input" type="hidden"  value="<?php if($edt){ echo 'edit'; }else echo esc_attr($action); ?>" name="action">
					 
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
							$result = $wpdb->get_row("SELECT * FROM $table_case where id=".sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id'])));
							?>
							<input id="case_id" class="form-control   validate[required] text-input" type="hidden"  value="<?php echo esc_attr($result->id); ?>" name="case_id">
							<input id="case_name" class="form-control   validate[required] text-input" type="text"  value="<?php echo esc_attr($result->case_name); ?>" name="case_name" readonly>
										
						</div>
						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="practice_area_id"><?php esc_html_e('Practice Area','lawyer_mgt');?></label>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
						<?php if($edt){ $data=$casedata->practice_area_id;}else{ $data=''; }
						   $obj_practicearea=new MJ_lawmgt_practicearea;
						?>						
							<input type="hidden" class="form-control" value="<?php echo esc_attr($result->practice_area_id);?>" name="practice_area_id" id="practice_area_id" readonly />
							<input type="text" class="form-control" value="<?php echo esc_attr(get_the_title($result->practice_area_id)); ?>" name="practice_area_id1" id="practice_area_id1" readonly />
						</div>
					</div>
					<div class="header">
						<h3><?php esc_html_e('Event Information','lawyer_mgt');?></h3>
						<hr>
					</div>
					<div class="form-group">
						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="task_name"><?php esc_html_e('Event Name','lawyer_mgt');?><span class="require-field">*</span></label>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
							<input id="event_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]],maxSize[50]] text-input onlyletter_number_space_validation"  type="text" placeholder="<?php esc_html_e('Enter Event Name','lawyer_mgt');?>" value="<?php if($edt){ echo esc_attr($casedata->event_name);}elseif(isset($_POST['event_name'])) { echo esc_attr($_POST['event_name']); } ?>" name="event_name">
						</div>						
					</div>
					<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="start_date"><?php esc_html_e('Start Date','lawyer_mgt');?><span class="require-field">*</span></label>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
							<input id="start_date" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date1 form-control  validate[required] has-feedback-left " type="text"  name="start_date"  placeholder="<?php esc_html_e('Select Start Date','lawyer_mgt');?>"
							value="<?php if($edt){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($casedata->start_date));}elseif(isset($_POST['startdate'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['startdate'])); } ?>" readonly>
							<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
						</div>
						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="start_time"><?php esc_html_e('Start Time','lawyer_mgt');?><span class="require-field">*</span></label>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
							<input id="start_time"  class="time form-control  validate[required] has-feedback-left " type="text"  name="start_time"  placeholder=""
								value="<?php if($edt){ echo esc_attr($casedata->start_time);}elseif(isset($_POST['start_time'])){ echo esc_attr($_POST['start_time']); } ?>">
								<span class="fa fa-clock form-control-feedback left" aria-hidden="true"></span>
						</div>
					</div>	
					<?php wp_nonce_field( 'save_case_event_nonce' ); ?>
					<div class="form-group">
						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="end_date"><?php esc_html_e('End Date','lawyer_mgt');?><span class="require-field">*</span></label>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
							<input id="end_date"  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date2 form-control validate[required]  has-feedback-left " type="text"  name="end_date"  placeholder="<?php esc_html_e('Select End Date','lawyer_mgt');?>"
							value="<?php if($edt){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($casedata->end_date));}elseif(isset($_POST['end_date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['end_date'])); } ?>" readonly>
							<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
						</div>
						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="end_time"><?php esc_html_e('End Time','lawyer_mgt');?><span class="require-field">*</span></label>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
							<input id="end_time"  class="time form-control  validate[required] has-feedback-left " type="text"  name="end_time"  placeholder=""
							value="<?php if($edt){ echo esc_attr($casedata->end_time);}elseif(isset($_POST['end_time'])){ echo esc_attr($_POST['end_time']); } ?>">
							<span class="fa fa-clock form-control-feedback left" aria-hidden="true"></span>
						</div>						
					</div>
					<div class="form-group">
						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="pin_code"><?php esc_html_e('Description','lawyer_mgt');?><span class="require-field"></span></label>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
							<textarea id="description" class="form-control validate[custom[address_description_validation]],maxSize[150]]" type="text" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>"  value="" name="description"><?php if($edt){ echo esc_textarea($casedata->description) ; } ?></textarea>
						</div>
					</div>	
					<?php
					if($edt)
					{
						$result_reminder=$event->MJ_lawmgt_get_single_event_reminder($event_id);				
						if(!empty($result_reminder))	
						{	
							foreach ($result_reminder as $retrive_data)
							{ 
							?>	
								<div id="reminder_entry">
									<div class="form-group">			
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="SOL Reminders"><?php esc_html_e('Event Reminders','lawyer_mgt');?></label>
										<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
											<input type="hidden" name="casedata[id][]" value="<?php echo esc_attr($retrive_data->id);?>">
											<select name="casedata[type][]" id="case_reminder_types">
												<option selected="selected" value="mail" <?php if($retrive_data=='mail') { print ' selected'; }?>><?php echo esc_html($retrive_data->reminder_type);?></option>
											</select>
										</div>
										<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
										<input id="remindertimevalue" class="form-control text-input validate[required]" type="number"  value="<?php echo esc_attr($retrive_data->reminder_time_value);?>" name="casedata[remindertimevalue][]" min="1">
										</div>
										<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
										<select name="casedata[remindertimeformat][]" id="case_reminder_type">
												<?php 
												$reminder_value= esc_attr($retrive_data->reminder_time_format);
												?>
												<option value="day" <?php if($reminder_value=='day') { print ' selected'; }?>><?php esc_html_e('Day(s)','lawyer_mgt'); ?></option>
												<option value="hour" <?php if($reminder_value=='hour') { print ' selected'; }?>><?php esc_html_e('Hour(s)','lawyer_mgt'); ?></option>												
										</select>
										</div>
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Event Start Date','lawyer_mgt') ?></label>
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
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Event Reminders','lawyer_mgt');?></label>
								<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
									<select name="casedata[type][]" id="case_reminder_types">
										<option selected="selected" value="mail"><?php esc_html_e('Mail','lawyer_mgt') ?></option>
									</select>
								</div>
								<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 btn_margin has-feedback">
								<input id="remindertimevalue" class="form-control text-input validate[required]" type="number"  value="1" name="casedata[remindertimevalue][]" min="1">
								</div>
								<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 btn_margin has-feedback">
								<select name="casedata[remindertimeformat][]" id="case_reminder_type">
									<option selected="selected" value="day"><?php esc_html_e('Day(s)','lawyer_mgt') ?></option>
									<option value="hour"><?php esc_html_e('Hour(s)','lawyer_mgt') ?></option>									
								</select>
								</div>
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Event Start Date','lawyer_mgt') ?></label>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
									<input type="button" value="<?php esc_html_e('Remove','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger">
								</div>		
							</div>		
						</div>				  
						<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12 reminder_top_bottom_Res">
							<input type="button" value="<?php esc_html_e('Add Reminder','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_reminder()" class="add_reminder btn btn-success">
						</div>	
					<?php 
					} 
					?>					
					<div class="header">
						<h3><?php esc_html_e('Address Information','lawyer_mgt');?></h3>					
						<hr>
					</div>
					<div class="form-group col-md-12">
						<div class="header">							
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="address"><?php esc_html_e('Address','lawyer_mgt');?><span class="require-field">*</span></label>
								<div class="col-sm-4 has-feedback">
									<input id="address" class="form-control validate[required,custom[address_description_validation]],maxSize[150]] has-feedback-left text-input"   type="text" placeholder="<?php esc_html_e('Enter Address','lawyer_mgt');?>" value="<?php if($edt){ echo esc_attr($casedata->address);}elseif(isset($_POST['address'])) { echo esc_attr($_POST['address']); } ?>" name="address">
									<span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
								</div>
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="state_name"><?php esc_html_e('State','lawyer_mgt');?><span class="require-field">*</span></label>
								<div class="col-sm-4 has-feedback">
									<input id="state_name" class="form-control has-feedback-left validate[required,custom[city_state_country_validation]],maxSize[50]]"   type="text"  name="state_name" placeholder="<?php esc_html_e('Enter State Name','lawyer_mgt');?>"
									value="<?php if($edt){ echo esc_attr($casedata->state_name);}elseif(isset($_POST['state_name'])){ echo esc_attr($_POST['state_name']); } ?>">
									<span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="city_name"><?php esc_html_e('City','lawyer_mgt');?><span class="require-field">*</span></label>
								<div class="col-sm-4 has-feedback">
									<input id="city_name" class="form-control has-feedback-left validate[required,custom[city_state_country_validation]],maxSize[50]]"  type="text"  name="city_name"  placeholder="<?php esc_html_e('Enter City Name','lawyer_mgt');?>"
									value="<?php if($edt){ echo esc_attr($casedata->city_name);}elseif(isset($_POST['city_name'])) { echo esc_attr($_POST['city_name']); } ?>">
									<span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
								</div>
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="pin_code"><?php esc_html_e('Pin Code','lawyer_mgt');?><span class="require-field">*</span></label>
								<div class="col-sm-4 has-feedback">
									<input id="pin_code" class="form-control has-feedback-left validate[required,custom[onlyLetterNumber],maxSize[15]]" type="text"  name="pin_code" placeholder="<?php esc_html_e('Enter Pin Code','lawyer_mgt');?>" 
									value="<?php if($edt){ echo esc_attr($casedata->pin_code);}elseif(isset($_POST['pin_code'])) { echo esc_attr($_POST['pin_code']); } ?>">
									<span class="fa fa-sort-numeric-down form-control-feedback left" aria-hidden="true"></span>
								</div>
							</div> 		
							<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="priority"><?php esc_html_e('Priority','lawyer_mgt');?></label>
								<div class="col-sm-4 has-feedback">
									<select class="form-control " name="priority" id="priority">				
											<option value="0" <?php if($edt && $casedata->priority=='0') { print ' selected'; }?>><?php esc_html_e('High','lawyer_mgt');?></option>
											<option value="1" <?php if($edt && $casedata->priority=='1') { print ' selected'; }?>><?php esc_html_e('Low','lawyer_mgt');?></option>
											<option value="2" <?php if($edt && $casedata->priority=='2') { print ' selected'; }?>><?php esc_html_e('Medium','lawyer_mgt');?></option>
									</select>
							   </div>			
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="Repeat"><?php esc_html_e('Repeat','lawyer_mgt');?></label>
								<div class="col-sm-4 has-feedback">
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
						</div>
					</div>
						 <div class="header">	
							<h3><?php esc_html_e('Attendees To','lawyer_mgt');?></h3>
							<hr>
						 </div>
					<div class="form-group">
						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="assigned_to_user"><?php esc_html_e('Client Name','lawyer_mgt');?><span class="require-field">*</span></label>
						<div class="col-sm-4 has-feedback multiselect_validation">
						<?php if($edt){ $data= esc_attr($casedata->assigned_to_user);}elseif(isset($_POST['assigned_to_user'])){ $data=
							esc_attr($_POST['assigned_to_user']); } ?>
							<?php $conats=explode(',',$data);
								$Editdata=MJ_lawmgt_get_user_by_edit_case_id(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id'])));
								?>
							<select class="form-control validate[required] assigned_to_user" multiple="multiple" name="assigned_to_user[]" id="assigned_to_user">				
								<?php
								if(!empty($Editdata))
								{
									foreach($Editdata as $Editdata1)
									{
										$userdata=get_userdata($Editdata1->user_id);
										$user_name= esc_attr($userdata->display_name);	
									?>
										<option value="<?php print esc_attr($Editdata1->user_id);?>" <?php echo in_array($Editdata1->user_id,explode(',',$data)) ? 'selected': ''; ?>>
												<?php echo esc_html($user_name);?>
										</option>
									<?php 
									}
								}
								 ?>
							</select>
						</div>
						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="assigned_to_attorney"><?php esc_html_e('Attorney Name','lawyer_mgt');?><span class="require-field">*</span></label>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback multiselect_validation123">
						<?php if($edt){ $data= esc_attr($casedata->assign_to_attorney);}elseif(isset($_POST['assign_to_attorney'])){ $data= sanitize_text_field($_POST['assign_to_attorney']); } ?>
						<?php 
							global $wpdb;
							$table_case = $wpdb->prefix. 'lmgt_cases';													
							$userdata = $wpdb->get_results("SELECT case_assgined_to FROM $table_case where id=".sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id'])));
							$user_array= esc_attr($userdata[0]->case_assgined_to);
							$newarraay=explode(',',$user_array);
								 
							?>
							<select class="form-control validate[required] assign_to_attorney" multiple="multiple" name="assign_to_attorney[]" id="assign_to_attorney">				
								<?php 
								if(!empty($newarraay))
								{
									foreach ($newarraay as $retrive_data)
									{ 
									$user_details=get_userdata($retrive_data);
									$user_name= esc_attr($user_details->display_name);
									?>
										<option value="<?php print esc_attr($user_details->ID);?>" <?php echo in_array($user_details->ID,explode(',',$data)) ? 'selected': ''; ?>>
											<?php echo esc_html($user_name); ?>
										</option>
									<?php 
									}
								} ?>
							</select>
						</div>
					</div>					
					<div class="form-group margin_top_div_css1">
						<div class="offset-sm-2 col-sm-8">
							  <input type="submit" id="" name="saveevent" class="btn btn-success submitevent" value="<?php if($edt){
							   esc_attr_e('Save Event','lawyer_mgt');}else{ esc_attr_e('Add Event','lawyer_mgt');}?>"></input>
						</div>
					</div>					
				</form>
			</div>  <!--END  PANEL BODY DIV -->      
     <?php
		}
		if($active_tab=='eventlist')
		{?>
			<script type="text/javascript">
			var $ = jQuery.noConflict();
				jQuery(document).ready(function($)
				{
					"use strict";
					jQuery('#note_list111').DataTable({
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
					jQuery('#event_list').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
				} );
			</script>
			<form name="" action="" method="post" enctype='multipart/form-data'>
			<div class="panel-body"><!-- PANEL BODY DIV -->
				 <div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">	
				<table id="note_list111" class="tast_list1 table table-striped table-bordered">
					<thead>	
						<?php
						if(isset($_REQUEST['case_id']))
							$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
							$eventdata=$event->MJ_lawmgt_get_event_by_caseid($case_id); ?>
						<tr>
							<th><input type="checkbox" id="select_all"></th>
							<th><?php  esc_html_e('Event Name', 'lawyer_mgt' ) ;?></th>
							<th><?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
							<th><?php esc_html_e('Practice Area', 'lawyer_mgt' ) ;?></th>
							<th> <?php esc_html_e('Client Name', 'lawyer_mgt' ) ;?></th>
							<th> <?php esc_html_e('Attorney Name', 'lawyer_mgt' ) ;?></th>
							<th> <?php esc_html_e('Date/Time', 'lawyer_mgt' ) ;?></th>
							<th><?php esc_html_e('Address', 'lawyer_mgt' ) ;?></th>
							<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
						</tr>
						<br/>
					</thead>
					<tbody>
							<?php
							if(!empty($eventdata))
							{
								foreach ($eventdata as $retrieved_data)
								{
									$case_name= MJ_lawmgt_get_case_name_by_id($retrieved_data->case_id);
									foreach($case_name as $case_name1)
									{
										$case_name2= sanitize_text_field($case_name1->case_name);
									}								
									$user_id= sanitize_text_field($retrieved_data->assigned_to_user);
									$contac_id=explode(',',$user_id);
									$conatc_name=array();
									foreach($contac_id as $contact_name)
									{									
										$userdata=get_userdata($contact_name);
										$conatc_name[]= sanitize_text_field($userdata->display_name);										   					   
									}	
									$attorney= sanitize_text_field($retrieved_data->assign_to_attorney);
									$attorney_name=explode(',',$attorney);
									$attorney_name1=array();
									foreach($attorney_name as $attorney_name2) 
									{
										$attorneydata=get_userdata($attorney_name2);	
											
										$attorney_name1[]= sanitize_text_field($attorneydata->display_name);										   
									}
								?>
							<tr>
								<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->event_id); ?>"></td>												
								 <td class="email"><a href="admin.php?page=cases&tab=casedetails&action=view&tab2=event&tab3=viewevent&viewevent=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->event_id));?>"><?php echo esc_html($retrieved_data->event_name);?></a></td>
								 <td class="prac_area"><a href="?page=cases&tab=casedetails&action=view&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>"><?php echo esc_html($case_name2); ?></a></td>	
								<td class="added"><?php echo esc_html(get_the_title($retrieved_data->practice_area_id));?></td>	
								<td class="added"><?php echo esc_html(implode(',',$conatc_name));?></td>
								<td class="added"><?php echo esc_html(implode(',',$attorney_name1));?></td>					
								<td class="added"><?php echo  esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->start_date).' '.$retrieved_data->start_time);?></td>
								<td class="added"><?php echo  esc_html($retrieved_data->address);?></td>						
								 <td class="action"> 
								<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=event&tab3=viewevent&viewevent=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->event_id));?>"  class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>								 
								<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=event&tab3=addevent&editevent=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->event_id));?>" id="ediit" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>					
								<a href="?page=cases&tab=casedetails&action=view&editats=true&deleteevent=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->event_id));?>" class="btn btn-danger" 
									onclick="return confirm('<?php esc_html_e('Are you sure you want to Delete this Event ?','lawyer_mgt');?>');">
								  <?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>					
								  </td>               
							</tr>
						<?php } 			
							} ?>     
						</tbody> 
					</table>
					<?php
						if(!empty($eventdata))
						{
							?>
					<div class="form-group">		
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
							<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="event_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
						</div>
					</div>
					<?php  }?>
				</div>
			</div>   <!-- END PANEL BODY DIV -->
			</form>
		 <?php 
		}
}
?>	