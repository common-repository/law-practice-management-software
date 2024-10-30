<?php 
$obj_case=new MJ_lawmgt_case;
?>

<!-- Company POP up code -->
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="company_list">
			</div>  
			<div class="attorney_list">
			</div>	
			<div class="category_list">
			</div> 			
		</div>
    </div>     
</div>
<!-- End Company POP-UP Code -->
<!-- Attorney List End POP-UP Code -->


<script type="text/javascript">
    var $ = jQuery.noConflict();
	jQuery(document).ready(function($)
	{
	    "use strict";
		$('#case_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
		
		$('#birth_date').datepicker(
		{
			changeMonth: true,
			changeYear: true,	        
			yearRange:'-65:+0',
			 endDate: '+0d',
			autoclose: true,
			onChangeMonthYear: function(year, month, inst) 
			{
				$(this).val(month + "/" + year);
			}                    
		}); 	
		 
		var start = new Date();
		var end = new Date(new Date().setYear(start.getFullYear()+1));
		$('.date1').datepicker({
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
		
		$('.date3').datepicker({
			startDate : start,
			endDate   : end,
			autoclose: true
		});
		
		 $('#contact_name').multiselect({
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
		 
		 $('#assginedto').multiselect({
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>'
			},
			buttonWidth: '100%',
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
		 
		 $('#stafflink_attorney').multiselect({
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
		  //user name not  allow space validation
		$('#username').keypress(function( e ) {
		   if(e.which === 32) 
			 return false;
		});	
		
	 
		$("body").on("click","#casesubmit",function()
		{
			var checked = $(".multiselect_validation .dropdown-menu input:checked").length;

			if(!checked)
			{
				alert("<?php esc_html_e('Please select atleast one Client Name','lawyer_mgt');?>");
				return false;
			}		
		});  
		 
		// File extension validation
		$(function() 
		{			
			"use strict";
			$("body").on("change", ".pdf_validation", function()
			{
				if(MJ_lawmgt_fileExtValidate(this))
				{	    	
					 
				}    
			});
		
			var validExt = ".pdf";
			function MJ_lawmgt_fileExtValidate(fdata)
			{
			 var filePath = fdata.value;
			 var getFileExt = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();
			 var pos = validExt.indexOf(getFileExt);
			 if(pos < 0)
			 {
				 
				 alert("<?php esc_html_e('Please Only upload PDF file....','lawyer_mgt');?>");
				fdata.value = '';	
				return false;
			  } else {
				return true;
			  }
			}
		});	
		 //------ADD Attorney AJAX----------
		   $('#attorney_form').on('submit', function(e) 
		   {
			"use strict";
			e.preventDefault();
			 
			var valid = $('#attorney_form').validationEngine('validate');
			
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
							$('#attorney_form').trigger("reset");
							$('#stafflink_attorney').append(json_obj);
							$('#stafflink_attorney').multiselect('rebuild');	
							$('.upload_user_avatar_preview').html('<img alt="" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">');
							$('.lmgt_user_avatar_url').val('');
							$('.modal').modal('hide');
						  }     
					},
					error: function(data){
					}
				})
			}
		}); 
	});

	function MJ_lawmgt_add_reminder()
	{
		"use strict";
		$("#reminder_entry").append('<div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="SOL Reminders"><?php esc_html_e('SOL Reminders','lawyer_mgt');?></label><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback"><select name="casedata[type][]" id="case_reminder_type"><option selected="selected" value="mail"><?php esc_html_e('Mail','lawyer_mgt');?></option></select></div><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback"><input id="remindertimevalue" class="form-control btn_margin text-input validate[required]" type="number"  value="1" name="casedata[remindertimevalue][]" min="1"></div><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback"><select name="casedata[remindertimeformat][]" class="btn_margin" id="case_reminder_type"><option selected="selected" value="day"><?php esc_html_e('Day(s)','lawyer_mgt');?></option><option value="hour"><?php esc_html_e('Hour(s)','lawyer_mgt');?></option></select></div><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Statute Of Limitations','lawyer_mgt');?></label><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger"></div></div>');   		
	}  	

	function MJ_lawmgt_deleteParentElement(n)
	{
		 "use strict";
		alert("<?php esc_html_e('Do you really want to delete this ?','lawyer_mgt');?>");
		n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
	}
	
	//Multiple Stages Add//
	function MJ_lawmgt_add_more_stages()
	{
		 "use strict";
		$("#diagnosissnosis_div").append('<div class="form-group input"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label "><?php esc_html_e('Case Stages','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback"><textarea name="stages[]" rows="3" class="validate[required,custom[address_description_validation]],maxSize[150]] width_100_per" ></textarea></div><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger"></div></div>');
	}
	 
	//Multiple Stages Add End//
	//add multiple opponents //
	"use strict";
	var value = 1;
	function MJ_lawmgt_add_opponents()
	{	
		 "use strict";
		value++;
		$("#opponents_div").append('<div><div class="col-sm-2"></div><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10"><input  class="form-control has-feedback-left validate[custom[onlyLetter_specialcharacter]],maxSize[50]] text-input" type="text" placeholder="<?php esc_html_e('Enter Name','lawyer_mgt');?>" name="opponents[]"><span class="fa fa-user form-control-feedback left" aria-hidden="true"> </span></div><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10"><input class="form-control has-feedback-left validate[custom[email]] text-input" type="text"  maxlength="50" name="opponents_email[]" placeholder="<?php esc_html_e('Enter Email','lawyer_mgt');?>"><span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span></div><div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 margin_bottom_10"><input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  class="form-control"  name="opponents_phonecode[]"></div><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 has-feedback margin_bottom_10"><input  class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]] text-input" type="number" min="0"   name="opponents_mobile_number[]" placeholder="<?php esc_html_e('Enter Mobile No','lawyer_mgt');?>"><span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span></div><div class="col-sm-1 margin_bottom_10"><input type="button" value="<?php esc_html_e('Delete','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger"></div></div>');
	}  	
	
	//add multiple opponents Attorney//
	"use strict";
	var value = 1;
	function MJ_lawmgt_add_opponents_attorney()
	{	
		 "use strict";
		value++;
		
		$("#opponents_attorney_div").append('<div><div class="col-sm-2"></div><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10"><input  class="form-control has-feedback-left validate[custom[onlyLetterSp]] text-input" maxlength="50" type="text" placeholder="<?php esc_html_e('Enter Name','lawyer_mgt');?>" name="opponents_attorney[]"><span class="fa fa-user form-control-feedback left" aria-hidden="true"> </span></div><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10"><input class="form-control has-feedback-left validate[custom[email]] text-input" type="text"  maxlength="50" name="opponents_attorney_email[]" placeholder="<?php esc_html_e('Enter Email','lawyer_mgt');?>"><span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span></div><div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 margin_bottom_10"><input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  class="form-control"  name="opponents_attorney_phonecode[]"></div><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 has-feedback margin_bottom_10"><input  class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]] text-input" type="number" min="0" name="opponents_attorney_mobile_number[]" placeholder="<?php esc_html_e('Enter Mobile No','lawyer_mgt');?>"><span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span></div><div class="col-sm-1 margin_bottom_10"><input type="button" value="<?php esc_html_e('Delete','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger"></div></div>');
	}
	function MJ_lawmgt_deleteParentElement(n)
	{
		 "use strict";
		alert("<?php esc_html_e('Do you really want to delete this ?','lawyer_mgt');?>");
		n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);				
	}
	
</script>
<?php 	
if($active_tab == 'add_case')
{		 
	$case_id=0;
	$edit=0;
	if(isset($_REQUEST['case_id']))
		$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
		if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
		{					
			$edit=1;
			$case_info = $obj_case->MJ_lawmgt_get_single_case($case_id);	
				 
		}?>		
		<div class="panel-body"><!-- 	panel body div -->
			<form name="case_form" action="" method="post" class="form-horizontal" id="case_form" enctype='multipart/form-data'>	
				<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
				<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
				<input type="hidden" name="case_id" value="<?php echo esc_attr($case_id); ?>">
				<div class="header">	
					<h3 class="first_hed"><?php esc_html_e('Case Information','lawyer_mgt');?></h3>
					<hr>
				</div>
				<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Case Name','lawyer_mgt');?><span class="require-field">*</span></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
						<input id="case_name" class="form-control has-feedback-left  validate[required,custom[onlyLetter_specialcharacter]],maxSize[50]] text-input" type="text" placeholder="<?php esc_html_e('Enter Case Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($case_info->case_name);}elseif(isset($_POST['case_name'])) { echo esc_attr($_POST['case_name']); } ?>" name="case_name">
						<span class="fa fa-briefcase form-control-feedback left" aria-hidden="true"></span>
					</div>
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_number"><?php esc_html_e('Case Number','lawyer_mgt');?><span class="require-field">*</span></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
						<input type="hidden" name="edit_case_number" value="<?php if($edit){ echo esc_attr($case_info->case_number);}?>">
						<input id="case_number" class="form-control has-feedback-left validate[required,custom[popup_category_validation]],maxSize[15]] text-input" type="text"  placeholder="<?php esc_html_e('Enter Case Number','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($case_info->case_number);}elseif(isset($_POST['case_number'])) { echo esc_attr($_POST['case_number']); } ?>" name="case_number" min="1">
						<span class="fa fa-sort-numeric-down form-control-feedback left" aria-hidden="true"></span>
					</div>			
				</div>
				<?php wp_nonce_field( 'save_cases_nonce' ); ?>
				<div class="form-group">		
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin" for="open_date"><?php esc_html_e('Open Date','lawyer_mgt');?><span class="require-field">*</span></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
						<input id="open_date"  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date1 form-control has-feedback-left validate[required]" type="text"  name="open_date"  placeholder="<?php esc_html_e('Select Open Date','lawyer_mgt');?>"
						value="<?php if($edit){ echo MJ_lawmgt_getdate_in_input_box(esc_attr($case_info->open_date));}elseif(isset($_POST['open_date'])) { echo MJ_lawmgt_getdate_in_input_box(esc_attr($_POST['open_date'])); } ?>" readonly>
						<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
						<span id="inputSuccess2Status2" class="sr-only"><?php esc_html_e('(success)','lawyer_mgt');?></span>
					</div>
					 
						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="statute_of_limitations"><?php esc_html_e('Statute Of Limitations','lawyer_mgt');?><span class="require-field">*</span></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
						<input id="statute_of_limitations"  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date2 form-control has-feedback-left validate[required]" type="text"  name="statute_of_limitations"  placeholder="<?php esc_html_e('Select Statute Of Limitations','lawyer_mgt');?>"
						value="<?php if($edit){ echo MJ_lawmgt_getdate_in_input_box(esc_attr($case_info->statute_of_limitations));}elseif(isset($_POST['statute_of_limitations'])){ echo MJ_lawmgt_getdate_in_input_box(esc_attr($_POST['statute_of_limitations'])); } ?>" readonly>
						<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
						<span id="inputSuccess2Status2" class="sr-only">(success)</span>
					</div> 
				</div>
				<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 res_label control-label" for="priority"><?php esc_html_e('Priority','lawyer_mgt');?> </label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">			
						<select class="form-control" name="priority" id="priority">
						<?php 
						if($edit)
						{
							$priority = esc_attr($case_info->priority);
						}							
						else
						{							
							$priority = "";
						}
						?>
							<option value="high" <?php echo selected($priority,'high');?>><?php esc_html_e('High','lawyer_mgt');?></option>
							<option value="medium" <?php echo selected($priority,'medium');?>><?php esc_html_e('Medium','lawyer_mgt');?></option>
							<option value="low" <?php echo selected($priority,'low');?>><?php esc_html_e('Low','lawyer_mgt');?></option>
						</select>				
					</div>
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="practice_area"><?php esc_html_e('Practice Area','lawyer_mgt');?><span class="require-field">*</span></label>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">			
						<select class="form-control validate[required]" name="practice_area" id="practice_area_name">
						<option value=""><?php esc_html_e('Select Area','lawyer_mgt');?></option>
						<?php 
						 if($edit)
							$practice_area = esc_attr($case_info->practice_area_id);				
						else 
							$practice_area = "";
				
						$obj_practicearea=new MJ_lawmgt_practicearea;
						$result=$obj_practicearea->MJ_lawmgt_get_all_practicearea();	
						if(!empty($result))
						{
							foreach ($result as $retrive_data)
							{ 		 	
							?>
								<option value="<?php echo esc_attr($retrive_data->ID);?>" <?php selected($practice_area,$retrive_data->ID);  ?>><?php echo esc_attr($retrive_data->post_title); ?> </option>
							<?php }
						} 
						?> 
						</select>				
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
						<button type="button" id="addremovearea" class="btn btn-success btn_margin" model="activity_practicearea"><?php esc_html_e('Add Or Remove','lawyer_mgt');?></button>			
					</div>
				</div>
				<div class="form-group">		
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="case_description"><?php esc_html_e('Case Description','lawyer_mgt');?></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
						<textarea rows="3"  name="case_description" class=" width_100_per validate[custom[address_description_validation]],maxSize[150]]"  id="case_description"><?php if($edit){ echo esc_textarea($case_info->case_description);}elseif(isset($_POST['case_description'])){ echo esc_textarea($_POST['case_description']); } ?></textarea>				
					</div>	
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="earlier history"><?php esc_html_e('Crime Details','lawyer_mgt');?></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
						<textarea rows="3"  name="crime_details" class="validate[custom[address_description_validation]],maxSize[150]] width_100_per"   id="crime_details" ><?php if($edit){ echo esc_textarea($case_info->crime_details);}elseif(isset($_POST['crime_details'])){ echo esc_textarea($_POST['crime_details']); } ?></textarea>				
					</div>
				</div>	
				<!---COURT DETAIL---->
				<div class="form-group">	
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin" for="court_id"><?php esc_html_e('Court Name','lawyer_mgt');?><span class="require-field">*</span></label>
					
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">			
						<select class="form-control courttostate validate[required]" name="court_id" id="courttostate">
						<option value=""><?php esc_html_e('Select Court','lawyer_mgt');?></option>
						<?php 
								if($edit)
								{
									$category =esc_attr($case_info->court_id);
								}
								else 
								{
									$category = esc_html(get_option( 'lmgt_default_court' ));	
								}
								$court_category=MJ_lawmgt_get_all_category('court_category');
								if(!empty($court_category))
								{
									foreach ($court_category as $retrive_data)
									{
										echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected($category,esc_attr($retrive_data->ID)).'>'.esc_attr($retrive_data->post_title).'</option>';
									}
								} ?>
						</select>
					</div>
						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="activity_category"><?php esc_html_e('State Name','lawyer_mgt');?><span class="require-field">*</span></label>
					 
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">	
							<select class="form-control validate[required] state_to_bench court_by_state" name="state_id" id="state_to_bench">
								<option value=""><?php esc_html_e('Select State Name','lawyer_mgt');?></option>
								<?php 
								if($edit)
								{
									$court_id =esc_attr($case_info->court_id);
									$stateid =esc_attr($case_info->state_id);
									
									global $wpdb;
									$table_court = $wpdb->prefix.'lmgt_court';
		
									$result = $wpdb->get_results("SELECT * FROM $table_court where deleted_status=0 AND court_id=".$court_id);
									if(!empty($result))
									{
										foreach($result as $data)
										{
											$state_id=esc_html($data->state_id);
											$latest_posts = get_post($state_id);
										 
											echo '<option value="'.esc_attr($latest_posts->ID).'" '.selected($stateid,esc_attr($latest_posts->ID)).'>'.esc_attr($latest_posts->post_title).'</option>';
										}
									}
								}
								else
								{
									$default_court_id = esc_html(get_option( 'lmgt_default_court' ));	
									global $wpdb;
									$table_court = $wpdb->prefix.'lmgt_court';
		
									$result = $wpdb->get_results("SELECT * FROM $table_court where deleted_status=0 AND court_id=".$default_court_id);
									if(!empty($result))
									{
										foreach($result as $data)
										{
											$state_id=esc_html($data->state_id);
											$latest_posts = get_post($state_id);
										 
											echo '<option value="'.esc_attr($latest_posts->ID).'">'.esc_attr($latest_posts->post_title).'</option>';
										}
									}										
								}									
								?>							
							</select>
						</div>											
					</div>
				<!---Bench DETAIL---->
				<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="activity_category"><?php esc_html_e('Bench Name','lawyer_mgt');?><span class="require-field">*</span></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">	
						<select class="form-control validate[required] state_by_bench" name="bench_id">
								<option value=""><?php esc_html_e('Select Bench Name','lawyer_mgt');?></option>
								<?php 
								 
								if($edit)
								{
									$state_id =esc_html($case_info->state_id);
									$benchid =esc_html($case_info->bench_id);
									
									global $wpdb;
									$table_court = $wpdb->prefix.'lmgt_court';
		
									$result = $wpdb->get_results("SELECT * FROM $table_court where deleted_status=0 AND state_id=".$state_id);
									
									$bench_id = esc_attr($result[0]->bench_id);
									if(!empty($bench_id))
									{
										$bench_id_array=explode(',',$bench_id);
									}
									else
									{
										$bench_id_array='';
									}
									if(!empty($bench_id_array))
									{
										foreach($bench_id_array as $data)
										{
											$latest_posts = get_post($data);
											echo '<option value="'.esc_attr($latest_posts->ID).'" '.selected($benchid,esc_attr($latest_posts->ID)).'>'.esc_attr($latest_posts->post_title).'</option>';
										} 
									}
								}
								?>					
						</select>
					</div><!---Bench DETAIL END---->	
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" ><?php esc_html_e('Court Hall No','lawyer_mgt');?></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
						<input class="form-control has-feedback-left  text-input validate[custom[number]],maxSize[6]] " type="number"  placeholder="<?php esc_html_e('Enter Court Hall No','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($case_info->court_hall_no);}elseif(isset($_POST['court_hall_no'])){ echo esc_attr($_POST['court_hall_no']); } ?>" name="court_hall_no">
						<span class="fa fa-sort-numeric-down form-control-feedback left" aria-hidden="true"></span>
					</div>	
				</div>
				<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" ><?php esc_html_e('Floor','lawyer_mgt');?></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
						<input class="form-control has-feedback-left  text-input validate[custom[number]],maxSize[6]] " type="number"   return false;" placeholder="<?php esc_html_e('Enter Floor No','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($case_info->floor);}elseif(isset($_POST['floor'])){ echo esc_attr($_POST['floor']); } ?>" name="floor">
						<span class="fa fa-sort-numeric-down form-control-feedback left" aria-hidden="true"></span>
					</div>	
						
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" ><?php esc_html_e('Crime No of Police Station','lawyer_mgt');?></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
						<input class="form-control has-feedback-left validate[custom[popup_category_validation]],maxSize[50]] text-input" type="text" placeholder="<?php esc_html_e('Enter Crime No of Police Station','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($case_info->crime_no);}elseif(isset($_POST['crime_no'])){ echo esc_attr($_POST['crime_no']); } ?>" name="crime_no">
						<span class="fa fa-sort-numeric-down form-control-feedback left" aria-hidden="true"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" ><?php esc_html_e('FIR No','lawyer_mgt');?></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
						<input class="form-control has-feedback-left  text-input validate[custom[popup_category_validation]],maxSize[30]] " type="text" placeholder="<?php esc_html_e('Enter FIR No','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($case_info->fri_no);}elseif(isset($_POST['fri_no'])){ echo esc_attr($_POST['fri_no']); } ?>" name="fri_no">
						<span class="fa fa-sort-numeric-down form-control-feedback left" aria-hidden="true"></span>
					</div>

					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Classification"><?php esc_html_e('Classification','lawyer_mgt');?></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
						<input id="classification" class="form-control text-input validate[custom[address_description_validation]],maxSize[150]]"  type="text" placeholder="<?php esc_html_e('Enter Classification','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($case_info->classification);}elseif(isset($_POST['classification'])){ echo esc_attr($_POST['classification']); } ?>" name="classification">
					</div>						
				</div>
				<div class="form-group">												
						
					<?php if($edit == 0)
					{	?>
					 
						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="open_date"><?php esc_html_e('First Hearing Date','lawyer_mgt');?><span class="require-field">*</span></label>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
							<input id="first_hearing_date"  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date3 form-control has-feedback-left validate[required]" type="text"  name="first_hearing_date"  placeholder="<?php esc_html_e('Select First Hearing Date','lawyer_mgt');?>"
							value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($case_info->first_hearing_date));}elseif(isset($_POST['first_hearing_date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['first_hearing_date'])); } ?>" readonly>
							<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
						</div>
				<?php  } ?>	
				</div>
				<div class="form-group">	
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin " for="earlier history"><?php esc_html_e('Earlier Court History','lawyer_mgt');?></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
						<textarea rows="3"  name="earlier_history" class="validate[custom[address_description_validation]],maxSize[150]] width_100_per" id="earlier_history" ><?php if($edit){ echo esc_textarea($case_info->earlier_history);}elseif(isset($_POST['earlier_history'])){ echo esc_textarea($_POST['earlier_history']); } ?></textarea>				
					</div>	
				</div>
				<?php
			   if($edit)
				{ ?>
				<div id="diagnosissnosis_div">
			<?php
					if(!empty($case_info->stages))
					{
						$stages=json_decode($case_info->stages);
						 
					}
					if(!empty($stages))
					{
						foreach($stages as $data)
						{ 
						?>
							<div class="form-group input">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin"><?php esc_html_e('Case Stages','lawyer_mgt');?><span class="require-field">*</span></label>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
									<textarea name="stages[]" rows="3"  class="validate[required,custom[address_description_validation]],maxSize[150]] text-input width_100_per"><?php echo esc_textarea($data->value); ?></textarea>
								</div>
							</div>
						<?php
						}
					}
					else
					{
					?>
						<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label "><?php esc_html_e('Case Stages','lawyer_mgt');?><span class="require-field">*</span></label>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
								<textarea name="stages[]" rows="3"  class="validate[required,custom[address_description_validation]],maxSize[150]] text-input width_100_per" ></textarea>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger"></div>	
						</div>
					<?php
					}	
					?>
				</div>
				<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
					<input type="button" value="<?php esc_html_e('Add Case Stages','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_more_stages()" class="add_more_stages btn btn-success mt_10">
				</div>	
				<?php
				}
			   else
				{ ?>
					<div id="diagnosissnosis_div">	
						<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label "><?php esc_html_e('Case Stages','lawyer_mgt');?><span class="require-field">*</span></label>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
								<textarea name="stages[]" rows="3" class="validate[required,custom[address_description_validation]],maxSize[150]] text-input width_100_per" ></textarea>
							</div>
						</div>
					</div>
					<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
								<input type="button" value="<?php esc_html_e('Add Case Stages','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_more_stages()" class="add_more_stages btn btn-success mt_10" >
					</div>
		<?php   } 
				if($edit)
				{
					$result_reminder=$obj_case->MJ_lawmgt_get_single_case_reminder($case_id);					
					if(!empty($result_reminder))	
					{	
						foreach ($result_reminder as $retrive_data)
						{ 
						?>	
							<div id="reminder_entry">
							    <div class="form-group">			
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="SOL Reminders"><?php esc_html_e('SOL Reminders','lawyer_mgt');?></label>
									<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
										<input type="hidden" name="casedata[id][]" value="<?php echo esc_attr($retrive_data->id);?>">
										<select name="casedata[type][]" id="case_reminder_types">
											<option selected="selected" value="mail" <?php if($retrive_data=='mail') { print ' selected'; }?>><?php echo esc_attr($retrive_data->reminder_type);?></option>
										</select>
									</div>
									<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
									<input id="remindertimevalue" class="form-control text-input btn_margin validate[required] " type="number"  value="<?php echo esc_attr($retrive_data->reminder_time_value);?>" name="casedata[remindertimevalue][]" min="1">
									</div>
									<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
									<select name="casedata[remindertimeformat][]" class="btn_margin" id="case_reminder_type">
										<?php 
											$reminder_value=$retrive_data->reminder_time_format;
											?>
											<option value="day" <?php if($reminder_value=='day') { print ' selected'; }?>>
											<?php esc_html_e('Day(s)','lawyer_mgt'); ?></option>
											<option value="hour" <?php if($reminder_value=='hour') { print ' selected'; }?>><?php esc_html_e('Hour(s)','lawyer_mgt'); ?></option>										
									</select>
									</div>
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Statute Of Limitations','lawyer_mgt') ?></label>
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
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="SOL Reminders"><?php esc_html_e('SOL Reminders','lawyer_mgt');?></label>
							<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
								<select name="casedata[type][]" id="case_reminder_types">
									<option selected="selected" value="mail"><?php esc_html_e('Mail','lawyer_mgt') ?></option>
								</select>
							</div>
							<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
							<input id="remindertimevalue" class="form-control text-input btn_margin validate[required]" type="number"  value="1" name="casedata[remindertimevalue][]" min="1">
							</div>
							<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
							<select name="casedata[remindertimeformat][]" class="btn_margin" id="case_reminder_type">
								<option selected="selected" value="day"><?php esc_html_e('Day(s)','lawyer_mgt') ?></option>
								<option value="hour"><?php esc_html_e('Hour(s)','lawyer_mgt') ?></option>							
							</select>
							</div>
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Statute Of Limitations','lawyer_mgt') ?></label>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
								<input type="button" value="<?php esc_html_e('Remove','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger">
							</div>		
						</div>		
					</div>				  
					<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
						<input type="button" value="<?php esc_html_e('Add Reminder','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_reminder()" class="add_reminder btn btn-success">
					</div>	
				<?php 
				} ?>
				<div class="form-group">		
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="referred_by"><?php esc_html_e('Referred By','lawyer_mgt');?> </label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<input id="referred_by" class="form-control has-feedback-left  validate[custom[onlyLetter_specialcharacter]],maxSize[50]] text-input" type="text" placeholder="<?php esc_html_e('Enter Referred Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($case_info->referred_by);}elseif(isset($_POST['referred_by'])){ echo esc_attr($_POST['referred_by']); }?>" name="referred_by">
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
					</div>
				</div>
				<!-- Custom Fields Data -->	
							<script type="text/javascript">
								jQuery("document").ready(function($)
								{	
									 "use strict";
									//space validation
									$('.space_validation').keypress(function( e ) 
									{
									   if(e.which === 32) 
										 return false;
									});									
									//custom field datepicker
									$('.after_or_equal').datepicker({
										dateFormat: "yy-mm-dd",										
										minDate:0,
										beforeShow: function (textbox, instance) 
										{
											instance.dpDiv.css({
												marginTop: (-textbox.offsetHeight) + 'px'                   
											});
										}
									}); 
									$('.date_equals').datepicker({
										dateFormat: "yy-mm-dd",
										minDate:0,
										maxDate:0,										
										beforeShow: function (textbox, instance) 
										{
											instance.dpDiv.css({
												marginTop: (-textbox.offsetHeight) + 'px'                   
											});
										}
									}); 
									$('.before_or_equal').datepicker({
										dateFormat: "yy-mm-dd",
										maxDate:0,
										beforeShow: function (textbox, instance) 
										{
											instance.dpDiv.css({
												marginTop: (-textbox.offsetHeight) + 'px'                   
											});
										}
									}); 
								});
								//Custom Field File Validation//
								function MJ_lawmgt_custom_filed_fileCheck(obj)
								{	
									 "use strict";
									var fileExtension = $(obj).attr('file_types');
									var fileExtensionArr = fileExtension.split(',');
									var file_size = $(obj).attr('file_size');
									
									var sizeInkb = obj.files[0].size/1024;
									
									if ($.inArray($(obj).val().split('.').pop().toLowerCase(), fileExtensionArr) == -1)
									{										
										alert("<?php esc_html_e('Only','wpnc');?> "+fileExtension+" <?php esc_html_e('formats are allowed.','wpnc');?>");
										$(obj).val('');
									}	
									else if(sizeInkb > file_size)
									{										
										alert("<?php esc_html_e('Only','wpnc');?> "+file_size+" <?php esc_html_e('kb size is allowed.','wpnc');?>");
										$(obj).val('');	
									}
								}
								//Custom Field File Validation//
							</script>
							<?php
							//Get Module Wise Custom Field Data
							$custom_field_obj =new MJ_lawmgt_custome_field;
							$module='case';	
							if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
							{
								$compact_custom_field=$custom_field_obj->MJ_lawmgt_getCustomFieldByModule($module);
							}
							else
							{
								$compact_custom_field='';
							}
							if(!empty($compact_custom_field))
							{
								?>		
								<div class="header">
									<h3><?php esc_html_e('Custom Fields','lawyer_mgt');?></h3>
									<hr>
								</div>						
										<?php
										foreach($compact_custom_field as $custom_field)
										{
											if($edit)
											{
												$custom_field_id= esc_attr($custom_field->id);
												$module_record_id=$case_id;
												$custom_field_value=$custom_field_obj->MJ_lawmgt_get_single_custom_field_meta_value($module,$module_record_id,$custom_field_id);
											}
											// Custom Field Validation // 
											$exa = explode('|',$custom_field->field_validation);
											$min = "";
											$max = "";
											$required = "";
											$red = "";
											$limit_value_min = "";
											$limit_value_max = "";
											$numeric = "";
											$alpha = "";
											$space_validation = "";
											$alpha_space = "";
											$alpha_num = "";
											$email = "";
											$url = "";
											$minDate="";
											$maxDate="";
											$file_types="";
											$file_size="";
											$datepicker_class="";
											foreach($exa as $key=>$value)
											{
												if (strpos($value, 'min') !== false)
												{
												   $min = $value;
												   $limit_value_min = substr($min,4);
												}
												elseif(strpos($value, 'max') !== false)
												{
												   $max = $value;
												   $limit_value_max = substr($max,4);
												}
												elseif(strpos($value, 'required') !== false)
												{
													$required="required";
													$red="*";
												}
												elseif(strpos($value, 'numeric') !== false)
												{
													$numeric="number";
												}
												elseif($value == 'alpha')
												{
													$alpha="onlyLetterSp";
													$space_validation="space_validation";
												}
												elseif($value == 'alpha_space')
												{
													$alpha_space="onlyLetterSp";
												}
												elseif(strpos($value, 'alpha_num') !== false)
												{
													$alpha_num="onlyLetterNumber";
												}
												elseif(strpos($value, 'email') !== false)
												{
													$email = "email";
												}
												elseif(strpos($value, 'url') !== false)
												{
													$url="url";
												}
												elseif(strpos($value, 'after_or_equal:today') !== false )
												{
													$minDate=1;
													$datepicker_class='after_or_equal';
												}
												elseif(strpos($value, 'date_equals:today') !== false )
												{
													$minDate=$maxDate=1;
													$datepicker_class='date_equals';
												}
												elseif(strpos($value, 'before_or_equal:today') !== false)
												{	
													$maxDate=1;
													$datepicker_class='before_or_equal';
												}	
												elseif(strpos($value, 'file_types') !== false)
												{	
													$types = $value;													
												   
													$file_types=substr($types,11);
												}
												elseif(strpos($value, 'file_upload_size') !== false)
												{	
													$size = $value;
													$file_size=substr($size,17);
												}
											}
											$option =$custom_field_obj->MJ_lawmgt_getDropDownValue($custom_field->id);
											$data = 'custom.'.$custom_field->id;
											$datas = 'custom.'.$custom_field->id;											
											if($custom_field->field_type =='text')
											{
												?>	
												<div class="form-group">	
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="<?php echo esc_attr($custom_field->id); ?>"><?php echo ucwords(esc_html($custom_field->field_label)); ?><span class="required red"><?php echo $red; ?></span></label>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
														<input class="form-control hideattar<?php echo $custom_field->form_name; ?> validate[<?php if(!empty($required)){ echo $required; ?>,<?php } ?><?php if(!empty($limit_value_min)){ ?> minSize[<?php echo $limit_value_min; ?>],<?php } if(!empty($limit_value_max)){ ?> maxSize[<?php echo $limit_value_max; ?>],<?php } if($numeric != '' || $alpha != '' || $alpha_space != '' || $alpha_num != '' || $email != '' || $url != ''){ ?> custom[<?php echo $numeric; echo $alpha; echo $alpha_space; echo $alpha_num; echo $email; echo $url; ?>]<?php } ?>] <?php echo $space_validation; ?>" type="text" name="custom[<?php echo $custom_field->id; ?>]" id="<?php echo $custom_field->id; ?>" label="<?php echo $custom_field->field_label; ?>" <?php if($edit){ ?> value="<?php echo esc_attr($custom_field_value); ?>" <?php } ?>>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
													</div>
	                                            </div>
	                                                 
												<?php
											}
											elseif($custom_field->field_type =='textarea')
											{
												?>
												<div class="form-group">	
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label "><?php echo esc_html($custom_field->field_label); ?><span class="required red"><?php echo $red; ?></span></label>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
														<textarea rows="3"
															class="form-control hideattar<?php echo esc_attr($custom_field->form_name); ?> validate[<?php if(!empty($required)){ echo $required; ?>,<?php } ?><?php if(!empty($limit_value_min)){ ?> minSize[<?php echo $limit_value_min; ?>],<?php } if(!empty($limit_value_max)){ ?> maxSize[<?php echo $limit_value_max; ?>],<?php } if($numeric != '' || $alpha != '' || $alpha_space != '' || $alpha_num != '' || $email != '' || $url != ''){ ?> custom[<?php echo $numeric; echo $alpha; echo $alpha_space; echo $alpha_num; echo $email; echo $url; ?>]<?php } ?>] <?php echo $space_validation; ?>" 
															name="custom[<?php echo esc_attr($custom_field->id); ?>]" 
															id="<?php echo esc_attr($custom_field->id); ?>"
															label="<?php echo esc_attr($custom_field->field_label); ?>"
															><?php if($edit){ echo esc_attr($custom_field_value); } ?></textarea>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
													</div>
	                                            </div>
												<?php 
											}
											elseif($custom_field->field_type =='date')
											{
												?>	
												<div class="form-group">
													 <label for="bdate" class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php echo ucwords(esc_html($custom_field->field_label)); ?><span class="required red"><?php echo $red; ?></span></label>
												 
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
														<input class="form-control error custom_datepicker <?php echo $datepicker_class; ?>hideattar<?php echo $custom_field->form_name; ?> <?php if(!empty($required)){ ?> validate[<?php echo $required; ?>] <?php } ?>"name="custom[<?php echo $custom_field->id; ?>]"<?php if($edit){ ?> value="<?php echo esc_attr($custom_field_value); ?>" <?php } ?>id="<?php echo $custom_field->id; ?>" label="<?php echo $custom_field->field_label; ?>">
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
													</div>
	                                            </div>
												 	
												<?php 
											}
											elseif($custom_field->field_type =='dropdown')
											{
												?>	
												<div class="form-group">
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="<?php echo $custom_field->id; ?>"><?php echo ucwords(esc_html($custom_field->field_label)); ?><span class="required red"><?php echo $red; ?></span></label>
													  
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
														<select class="form-control hideattar<?php echo $custom_field->form_name; ?> 
														<?php if(!empty($required)){ ?> validate[<?php echo $required; ?>] <?php } ?>" name="custom[<?php echo $custom_field->id; ?>]"	id="<?php echo $custom_field->id; ?>" label="<?php echo $custom_field->field_label; ?>"
														>
															<?php
															if(!empty($option))
															{															
																foreach ($option as $options)
																{
																	?>
																	<option value="<?php echo esc_attr($options->option_label); ?>" <?php if($edit){ echo selected($custom_field_value,$options->option_label); } ?>> <?php echo ucwords(esc_html($options->option_label)); ?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
													</div>
	                                            </div>
												 
												<?php 
											}
											elseif($custom_field->field_type =='checkbox')
											{
												?>	
													<div class="form-group">
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php echo ucwords(esc_html($custom_field->field_label)); ?><span class="required red"><?php echo $red; ?></span></label>
													 
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
															<?php
															if(!empty($option))
															{
																foreach ($option as $options)
																{ 
																	if($edit)
																	{
																		$custom_field_value_array=explode(',',$custom_field_value);
																	}
																	?>	
																	<div class="d-inline-block custom-control custom-checkbox mr-1">
																		<input type="checkbox" value="<?php echo esc_attr($options->option_label); ?>"  <?php if($edit){  echo checked(in_array($options->option_label,$custom_field_value_array)); } ?> class="custom-control-input hideattar<?php echo $custom_field->form_name; ?>" name="custom[<?php echo $custom_field->id; ?>][]" >
																		<label class="custom-control-label" for="colorCheck1"><?php echo esc_html($options->option_label); ?></label>
																	</div>
																	<?php
																}
															}
															?>
														</div>
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
														</div>
													</div>
												<?php 
											}
											elseif($custom_field->field_type =='radio')
											{
												?>
												<div class="form-group">
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php echo ucwords(esc_html($custom_field->field_label)); ?><span class="required red"><?php echo $red; ?></span></label>
														
														 
													 
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
															<?php
															if(!empty($option))
															{
																foreach ($option as $options)
																{
																	?>
																	<input type="radio"  value="<?php echo esc_attr($options->option_label); ?>" <?php if($edit){ echo checked( $options->option_label, $custom_field_value); } ?> name="custom[<?php echo $custom_field->id; ?>]"  class="custom-control-input hideattar<?php echo $custom_field->form_name; ?> error " id="<?php echo $options->option_label; ?>">
																	
																	<label class="custom-control-label mr-1" for="<?php echo $options->option_label; ?>"><?php echo esc_html($options->option_label); ?></label>
																	<?php
																}
															}
															?>
														</div>
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
														</div>
													</div>
												<?php
											}
											elseif($custom_field->field_type =='file')
											{
												?>	
												<div class="form-group">
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php echo ucwords(esc_html($custom_field->field_label)); ?><span class="required red"><?php echo $red; ?></span></label>
													 
													<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
														<input type="file"  onchange="MJ_lawmgt_custom_filed_fileCheck(this);" Class="hideattar<?php echo $custom_field->form_name; if($edit){ if(!empty($required)){ if($custom_field_value==''){ ?> validate[<?php echo $required; ?>] <?php } } }else{ if(!empty($required)){ ?> validate[<?php echo $required; ?>] <?php } } ?>" name="custom_file[<?php echo $custom_field->id; ?>]" <?php if($edit){ ?> value="<?php echo esc_attr($custom_field_value); ?>" <?php } ?> id="<?php echo $custom_field->id; ?>" file_types="<?php echo $file_types; ?>" file_size="<?php echo $file_size; ?>">
														<p><?php esc_html_e('Please upload only ','wpnc'); echo $file_types; esc_html_e(' file','wpnc');?> </p>
													</div>
														<input type="hidden" name="hidden_custom_file[<?php echo $custom_field->id; ?>]" value="<?php if($edit){ echo esc_attr($custom_field_value); } ?>">
														<label class="label_file"><?php if($edit){ echo esc_html($custom_field_value); } ?></label>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
													</div>
	                                            </div>
											<?php
											}
										}	
										?>	 
							<?php
							}
							?>
				<div class="header">	
					<h3 class="first_hed"><?php esc_html_e('Attorney & Client Link','lawyer_mgt');?></h3>
					<hr>
				</div>
				<div class="form-group">
						<p class="offset-md-2 col-md-10 font_weight_css"><?php esc_html_e('Which attorneys and clients  should be linked to this case?','lawyer_mgt');?></p>
				</div>
				
				<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="assginedto"><?php esc_html_e('Assigned To Attorney','lawyer_mgt');?><span class="require-field">*</span></label>
					
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 multiselect_validation">			
							<select class="form-control case_assgined_to assginedto validate[required]" multiple="multiple" name="assginedto[]" id="assginedto">
							<?php 
							 if($edit)
							 {
								$assginedto = esc_attr($case_info->case_assgined_to);
							 }							
							else 
							{
								$assginedto = "";
							}
							
							$attorney=get_users(array('role' => 'attorney',
									'meta_query' =>array( 
											array(
													'key' => 'deleted_status',
													'value' =>0,
													'compare' => '='
												)
										)	
									)
								);
								//$users = get_users($args);
							if(!empty($attorney))
							{
								foreach ($attorney as $retrive_data)
								{ 		 	
								?>
									<option value="<?php print esc_attr($retrive_data->ID);?>" <?php echo in_array($retrive_data->ID,explode(',',$assginedto)) ? 'selected': ''; ?>>
										<?php echo esc_html($retrive_data->display_name);?>
									</option>
								<?php 
								}
							} 
							?> 
							</select>				
						</div>
					<div class="form-group">
						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="contact_name"><?php esc_html_e('Client Name','lawyer_mgt');?><span class="require-field">*</span></label>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 multiselect_validation">						
							<select name="contact_name[]" multiple="multiple" id="contact_name" class="contactlist_by_company contact_name_data form-control validate[required]">   
								<?php
									if($edit)
									{		
									  global $wpdb;
										$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
										$result = $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
										
										if(!empty($result))
										{
											$select_user_id=array();
											
											foreach ($result as $data)
											{ 							
												$select_user_id[]=$data->user_id;
											}								
										}
									}
									else
									{
										$select_user_id[]="";
									}
									$contactdata=get_users(array('role' => 'client',
												'meta_query' =>array( 
														array(
																'key' => 'archive',
																'value' =>0,
																'compare' => '='
															)
													)	
												)
											);
											 
											foreach($contactdata as $retrive_data)
											{  				
											?>						
												<option value="<?php echo esc_attr($retrive_data->ID);?>" <?php if(in_array($retrive_data->ID,$select_user_id)) { print "selected"; }?>><?php echo esc_html($retrive_data->display_name);?> </option>						
											<?php 
											}	
								 
									?> 			
							</select>
						</div>
					</div>
				</div>
				<div class="header">	
					<h3 class="first_hed"><?php esc_html_e('Billing Information','lawyer_mgt');?></h3>
					<hr>
				</div>
				<div class="form-group">
						<p class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12 font_weight_css"><?php esc_html_e('Which Client will be the billing point of contact for this case?','lawyer_mgt');?></p>
				<div class="form-group">		
				</div>
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="billing_contact"><?php esc_html_e('Billing Client Name','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
				<select class="form-control billing_contactlist_by_company validate[required]" name="billing_contact" id="billing_contact_data">	
					<option value=""><?php esc_html_e('Select Client Name','lawyer_mgt');?></option>
					<?php
						if($edit)
						{					
							$select_billing_id=$case_info->billing_contact_id;
						}
						else
						{
							$select_billing_id="";
						}
							$contactdata=get_users(array('role' => 'client',
												'meta_query' =>array( 
														array(
																'key' => 'archive',
																'value' =>0,
																'compare' => '='
															)
													)	
												)
											);
								foreach($contactdata as $retrive_data)
								{  				
							?>						
									<option value="<?php echo esc_attr($retrive_data->ID);?>" <?php selected($retrive_data->ID,$select_billing_id) ?>><?php echo esc_html($retrive_data->display_name);?> </option>
							<?php }	
						?> 			
				</select>
				</div>
				</div>
				<div class="form-group">
					<p class="offset-md-2 col-md-10 font_weight_css"><?php esc_html_e('How should this case be billed?','lawyer_mgt');?></p>
				</div>
				<div class="form-group">		
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="billing_type"><?php esc_html_e('Billing Type','lawyer_mgt');?></label>
					<div class="col-sm-10">
					<select class="form-control" name="billing_type" id="billing_type">		
					<option value=""><?php esc_html_e('Select Billing Type','lawyer_mgt');?></option>
							 <?php if($edit)
							$billing_type = esc_attr($case_info->billing_type);					
						else 
							 $billing_type = ""; 
						 ?>
						<option value="hourly" <?php if($billing_type == 'hourly') echo 'selected = "selected"';?>><?php esc_html_e('Hourly','lawyer_mgt');?></option>
						<option value="contingency" <?php  if($billing_type == 'contingency') echo 'selected = "selected"';  ?>><?php esc_html_e('Contingency','lawyer_mgt');?></option>
						<option value="flat" <?php   if($billing_type == 'flat') echo 'selected = "selected"';  ?>><?php esc_html_e('Flat Fee','lawyer_mgt');?></option>
						<option value="mixed" <?php   if($billing_type == 'mixed') echo 'selected = "selected"';  ?>><?php esc_html_e('Mix of Flat Fee and Hourly','lawyer_mgt');?></option>
						<option value="pro_bono" <?php if($billing_type == 'pro_bono') echo 'selected = "selected"';  ?>><?php esc_html_e('Pro Bono','lawyer_mgt');?></option>		
					</select>
					</div>
				</div>
				<div class="header">	
					<h3 class="first_hed"><?php esc_html_e('Opponents','lawyer_mgt');?></h3>
					<hr>
				</div>
				<div class="form-group">
					<?php 			
					if($edit)
					{	
						?>
						<div id="opponents_div">	
							<?php
							$opponents_details_array=json_decode($case_info->opponents_details);
							$a=0;
							if(!empty($opponents_details_array))
							{
								foreach ($opponents_details_array as $data)
								{
								?> 	
								<div>	
									<div class="col-sm-2 margin_bottom_10">
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10">
										<input  class="form-control has-feedback-left validate[custom[onlyLetter_specialcharacter]],maxSize[50]] text-input"  value="<?php if($edit){ echo esc_attr($data->opponents_name); } ?>" type="text" placeholder="<?php esc_html_e('Enter Name','lawyer_mgt');?>" name="opponents[]">
										<span class="fa fa-user form-control-feedback left" aria-hidden="true"> </span>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10">
										<input class="form-control has-feedback-left validate[custom[email]] text-input" type="text"  maxlength="50" name="opponents_email[]" value="<?php if($edit){ echo esc_attr($data->opponents_email); } ?>" placeholder="<?php esc_html_e('Enter Email','lawyer_mgt');?>">
										<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
									</div>
									<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 margin_bottom_10">				
										<input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  value="<?php if($edit){ echo esc_attr($data->opponents_phonecode); } ?>" class="form-control"  name="opponents_phonecode[]">
									</div>					
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 has-feedback margin_bottom_10">
										<input  class="form-control has-feedback-left  validate[custom[phone_number],minSize[6],maxSize[15]] text-input" type="number" min="0"  name="opponents_mobile_number[]" value="<?php if($edit){ echo esc_attr($data->opponents_mobile_number); } ?>" placeholder="<?php esc_html_e('Enter Mobile No','lawyer_mgt');?>">
										<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
									</div>
									<div class="col-sm-1 margin_bottom_10">
										<?php
										if($a != 0)
										{
											?>
											<input type="button" value="<?php esc_html_e('Delete','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger">	
											<?php
										}
										?>
									</div>	
								</div>
								<?php
								$a=$a+1;
								}
							}
							?>
						</div>
						<?php
					}	
					else
					{		
						?>	
						<div id="opponents_div">	
							<div>	
								<div class="col-sm-2 margin_bottom_10">
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10">
									<input  class="form-control has-feedback-left  validate[custom[onlyLetter_specialcharacter]],maxSize[50]] text-input"  type="text" placeholder="<?php esc_html_e('Enter Name','lawyer_mgt');?>" name="opponents[]">
									<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10">
									<input class="form-control has-feedback-left validate[custom[email]] text-input" type="text"  maxlength="50" name="opponents_email[]" placeholder="<?php esc_html_e('Enter Email','lawyer_mgt');?>">
									<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
								</div>
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 margin_bottom_10">				
									<input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  class="form-control"  name="opponents_phonecode[]">
								</div>					
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 has-feedback margin_bottom_10">
									<input  class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]] text-input mobile_width" type="number" min="0"   name="opponents_mobile_number[]" placeholder="<?php esc_html_e('Enter Mobile No','lawyer_mgt');?>">
									<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
								</div>
								<div class="col-sm-1 margin_bottom_10">
								</div>	
							</div>	
						</div>	
						<?php
					}
					?>	
					<div class=" offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
						<input type="button" value="<?php esc_html_e('Add More Opponents','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_opponents()" class="add_cirtificate btn btn-success">
					</div>
				</div>
				<div class="header">	
					<h3 class="first_hed"><?php esc_html_e('Opponents Attorney','lawyer_mgt');?></h3>
					<hr>
				</div>	
				<div class="form-group">
					<?php 			
					if($edit)
					{	
						?>
						<div id="opponents_attorney_div">	
							<?php
							$opponents_attorney_details=json_decode($case_info->opponents_attorney_details);
							$a=0;
							if(!empty($opponents_attorney_details))
							{
								foreach ($opponents_attorney_details as $data)
								{
								?> 	
								<div>	
									<div class="col-sm-2 margin_bottom_10">
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10">
										<input  class="form-control has-feedback-left  validate[custom[onlyLetter_specialcharacter]],maxSize[50]] text-input"   value="<?php if($edit){ echo esc_attr($data->opponents_attorney_name); } ?>" type="text" placeholder="<?php esc_html_e('Enter Name','lawyer_mgt');?>" name="opponents_attorney[]">
										<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10">
										<input class="form-control has-feedback-left validate[custom[email]] text-input" type="text"  maxlength="50" name="opponents_attorney_email[]" value="<?php if($edit){ echo esc_attr($data->opponents_attorney_email); } ?>" placeholder="<?php esc_html_e('Enter Email','lawyer_mgt');?>">
										<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
									</div>
									<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 margin_bottom_10">				
										<input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  value="<?php if($edit){ echo esc_attr($data->opponents_attorney_phonecode); } ?>" class="form-control"  name="opponents_attorney_phonecode[]">
									</div>					
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 has-feedback margin_bottom_10">
										<input  class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]] text-input" type="number" min="0"  name="opponents_attorney_mobile_number[]" value="<?php if($edit){ echo esc_attr($data->opponents_attorney_mobile_number); } ?>" placeholder="<?php esc_html_e('Enter Mobile No','lawyer_mgt');?>">
										<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
									</div>
									<div class="col-sm-1 margin_bottom_10">
										<?php
										if($a != 0)
										{
											?>
											<input type="button" value="<?php esc_html_e('Delete','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger">	
											<?php
										}
										?>
									</div>	
								</div>
								<?php
								$a=$a+1;
								}
							}
							?>
						</div>
						<?php
					}	
					else
					{		
						?>	
						<div id="opponents_attorney_div">	
							<div>	
								<div class="col-sm-2 margin_bottom_10">
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10">
									<input  class="form-control has-feedback-left validate[custom[onlyLetter_specialcharacter]],maxSize[50]] text-input"  type="text" placeholder="<?php esc_html_e('Enter Name','lawyer_mgt');?>" name="opponents_attorney[]">
									<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10">
									<input class="form-control has-feedback-left validate[custom[email]] text-input" type="text"  maxlength="50" name="opponents_attorney_email[]" placeholder="<?php esc_html_e('Enter Email','lawyer_mgt');?>">
									<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
								</div>
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 margin_bottom_10">				
									<input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  class="form-control"  name="opponents_attorney_phonecode[]">
								</div>					
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 has-feedback margin_bottom_10">
									<input  class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]] text-input mobile_width" type="number" min="0"   name="opponents_attorney_mobile_number[]" placeholder="<?php esc_html_e('Enter Mobile No','lawyer_mgt');?>">
									<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
								</div>
								<div class="col-sm-1 margin_bottom_10">
								</div>	
							</div>	
						</div>	
						<?php
					}
					?>	
					<div class=" offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
						<input type="button" value="<?php esc_html_e('Add More Opponents Attorney','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_opponents_attorney()" class="add_cirtificate btn btn-success">
					</div>
				</div>
				
				<div class="offset-sm-2 col-sm-8">
					<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Add Case','lawyer_mgt');}?>" name="save_case" id="casesubmit" class="btn btn-success"/>
				</div>		
			</form>
		</div> <!-- 	end panel body div -->
			<?php } ?>
		  <!----------ADD Attorney------------->	 
		  
	<div class="modal fade overflow_scroll_css" id="myModal_add_attorney" role="dialog"><!-- MODAL FADE DIV -->
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h3 class="modal-title"><?php esc_html_e('Add Attorney','lawyer_mgt');?></h3>
				</div>
				<div class="modal-body">
					<form name="attorney_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form-horizontal form_scroll" id="attorney_form" enctype='multipart/form-data'>	         
						<input type="hidden" name="action" value="MJ_lawmgt_add_attorney_into_database">
						<input type="hidden" name="role" value="attorney"  />		
						<div class="header">	
							<h3 class="first_hed"><?php esc_html_e('Personal Information','lawyer_mgt');?></h3>
							<hr>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="first_name"><?php esc_html_e('First Name','lawyer_mgt');?><span class="require-field">*</span></label>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
								<input id="first_name" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter]],maxSize[50]] text-input"  type="text" placeholder="<?php esc_html_e('Enter First Name','lawyer_mgt');?>" value="" name="first_name">
								<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
							</div>
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="middle_name"><?php esc_html_e('Middle Name','lawyer_mgt');?></label>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
								<input id="middle_name" class="form-control has-feedback-left  validate[custom[onlyLetter_specialcharacter]],maxSize[50]] " type="text" placeholder="<?php esc_html_e('Enter Middle Name','lawyer_mgt');?>" value="" name="middle_name">
								<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="last_name"><?php esc_html_e('Last Name','lawyer_mgt');?><span class="require-field">*</span></label>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
								<input id="last_name" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter]],maxSize[50]] text-input" type="text"   placeholder="<?php esc_html_e('Enter Last Name','lawyer_mgt');?>"value="" name="last_name">
								<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
							</div>
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="birth_date"><?php esc_html_e('Date of birth','lawyer_mgt');?><span class="require-field">*</span></label>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
								<input id="birth_date" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date form-control has-feedback-left validate[required]" type="text"  name="birth_date"  placeholder="<?php esc_html_e('Select Birth Date','lawyer_mgt');?>"
								class="form-control has-feedback-left validate[required]" type="text"  name="birth_date"  placeholder="<?php esc_html_e('Select Birth Date','lawyer_mgt');?>"
								value="" readonly>
								<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
								<span id="inputSuccess2Status2" class="sr-only">(success)</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="gender"><?php esc_html_e('Gender','lawyer_mgt');?></label>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<?php $genderval = "male"; ?>
								<label class="radio-inline mr_10">
								 <input type="radio" value="male" class="tog validate[]" name="gender"  <?php  checked( 'male', $genderval);  ?>/><?php esc_html_e('Male','lawyer_mgt');?>
								</label>
								<label class="radio-inline">
								  <input type="radio"  value="female" class="tog validate[required]" name="gender"  <?php  checked( 'female', $genderval);  ?>/><?php esc_html_e('Female','lawyer_mgt');?> 
								</label>
							</div>
						</div>
						<div class="header">
							<h3><?php esc_html_e('Address Information','lawyer_mgt');?></h3>
							<hr>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="address"><?php esc_html_e('Address','lawyer_mgt');?><span class="require-field">*</span></label>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
								<input id="address" class="form-control has-feedback-left validate[required,custom[address_description_validation]],maxSize[150]]" type="text"   name="address"  placeholder="<?php esc_html_e('Enter Address','lawyer_mgt');?>"
								value="">
								<span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
							</div>
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="state_name"><?php esc_html_e('State','lawyer_mgt');?><span class="require-field">*</span></label>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
								<input id="state_name" class="form-control has-feedback-left validate[,custom[city_state_country_validation]],maxSize[50]]"  type="text"  name="state_name" placeholder="<?php esc_html_e('Enter State Name','lawyer_mgt');?>"
								value="">
								<span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>	
						<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="city_name"><?php esc_html_e('City','lawyer_mgt');?><span class="require-field">*</span></label>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
								<input id="city_name" class="form-control has-feedback-left validate[,custom[city_state_country_validation]],maxSize[50]]"   type="text"  name="city_name"  placeholder="<?php esc_html_e('Enter City Name','lawyer_mgt');?>"
								value="">
								<span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
							</div>
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="pin_code"><?php esc_html_e('Pin Code','lawyer_mgt');?><span class="require-field">*</span></label>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
								<input id="pin_code" class="form-control has-feedback-left validate[required,custom[onlyLetterNumber]]" maxlength="10" type="text"  name="pin_code" placeholder="<?php esc_html_e('Enter Pin Code','lawyer_mgt');?>" 
								value="">
								<span class="fa fa-sort-numeric-down form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>		
						<div class="header">
							<h3><?php esc_html_e('Education Information','lawyer_mgt');?></h3>
							<hr>
						</div>
						<div class="form-group">		
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="degree"><?php esc_html_e('Degree','lawyer_mgt');?><span class="require-field">*</span></label>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
								<input id="degree" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter]],maxSize[50]]"   type="text"  name="degree" placeholder="<?php esc_html_e('Enter Degree Name','lawyer_mgt');?>"
								value="">
								<span class="fa fa-graduation-cap form-control-feedback left" aria-hidden="true"></span>
							</div>
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="experience"><?php esc_html_e('Experience(Years)','lawyer_mgt');?><span class="require-field">*</span></label>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
								<input id="experience" class="form-control has-feedback-left validate[required]" type="number" min="0" onKeyPress="if(this.value.length==2) return false;"  name="experience"  placeholder="<?php esc_html_e('Enter Experience','lawyer_mgt');?>"
								value="" min="0" max="99">
								<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>	 		
						<div class="header">
							<h3><?php esc_html_e('Contact Information','lawyer_mgt');?></h3>
							<hr>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="mobile"><?php esc_html_e('Mobile Number','lawyer_mgt');?><span class="require-field">*</span></label>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
							
							<input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  class="form-control" name="phonecode">
							</div>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
								<input id="mobile" class="form-control has-feedback-left validate[required,custom[phone_number],minSize[6],maxSize[15]] text-input" type="number" min="0"   placeholder="<?php esc_html_e('Enter Mobile Number','lawyer_mgt');?>" name="mobile" 
								value="">
								<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
							</div>
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="phone"><?php esc_html_e('Alternate Mobile Number','lawyer_mgt');?></label>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
							
							<input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  class="form-control"  name="phonecode">
							</div>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
								<input id="Altrmobile" class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]] text-input" type="number" min="0" onKeyPress="if(this.value.length==15) return false;"  name="alternate_mobile" placeholder="<?php esc_html_e('Enter Alternate Mobile Number','lawyer_mgt');?>"
								value="">
								<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="phone_home"><?php esc_html_e('Home Phone','lawyer_mgt');?></label>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
								<input id="phone_home" class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]] text-input" type="number" min="0"    name="phone_home"  placeholder="<?php esc_html_e('Enter Home Phone Number','lawyer_mgt');?>"
								value="">
								<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
							</div>
						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="phone_work"><?php esc_html_e('Work Phone','lawyer_mgt');?></label>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
								<input id="phone_work" class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]] text-input"type="number" min="0"    name="phone_work"  placeholder="<?php esc_html_e('Enter Work Phone Number','lawyer_mgt');?>"
								value="">
								<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						<div class="header">	
							<h3><?php esc_html_e('Login Information','lawyer_mgt');?></h3>
							<hr>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="email"><?php esc_html_e('Email','lawyer_mgt');?><span class="require-field">*</span></label>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
								<input id="email" class="form-control has-feedback-left validate[required,custom[email]] text-input" maxlength="50" type="text"  name="email" placeholder="<?php esc_html_e('Enter valid Email','lawyer_mgt');?>"
								value="">
								<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
							</div>
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="username"><?php esc_html_e('Username','lawyer_mgt');?><span class="require-field">*</span></label>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
								<input id="username" class="form-control has-feedback-left validate[required,custom[username_validation],maxSize[30]]]" type="text"  name="username"  placeholder="<?php esc_html_e('Enter valid username','lawyer_mgt');?>"
								value="">
								<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="password"><?php esc_html_e('Password','lawyer_mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
								<input class="form-control has-feedback-left <?php if(!$edit) echo 'validate[required]';?>" type="password" minlength="8" maxlength="12" name="password" placeholder="<?php esc_html_e('Enter valid Password','lawyer_mgt');?>" value="">
								<span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						<div class="header">	
							<h3><?php esc_html_e('Other Information','lawyer_mgt');?></h3>
							<hr>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="rate"><?php esc_html_e('Default Rate','lawyer_mgt');?></label>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
								<input id="rate" class="form-control has-feedback-left validate[min[0],maxSize[8]]"" type="number" step="0.01"   name="rate"  placeholder="<?php esc_html_e('Enter Rate','lawyer_mgt');?>"
								value="">
								<span class="fa fa-rupee-sign form-control-feedback left" aria-hidden="true"></span>
							</div>
							<div class="attorny_default_rate attorny_default_rate_css">
									<?php esc_html_e('/ hr','lawyer_mgt');?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="photo"><?php esc_html_e('Image','lawyer_mgt');?></label>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
								<input type="text" id="lmgt_user_avatar_url" class="lmgt_user_avatar_url form-control has-feedback-left" name="lmgt_user_avatar"  placeholder="<?php esc_html_e('Select image','lawyer_mgt');?>"
								value="" readonly />
								<span class="fa fa-image form-control-feedback left" aria-hidden="true"></span>
							</div>	
								<div class="col-sm-3">
									 <input id="upload_user_avatar_button" type="button" class=" btnupload button btn_margin" value="<?php esc_html_e('Upload image', 'lawyer_mgt' ); ?>" />
									 <span class="description"><?php esc_html_e('Upload image', 'lawyer_mgt' ); ?></span>							
							</div>
							<div class="clearfix"></div>
							
							<div class="upload_img offset-sm-2 col-sm-8">
								<div id="upload_user_avatar_preview" >									
									 <img alt=""  class="height_100px_width_100px" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">										
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="join"><?php esc_html_e('Curriculum Vitae','lawyer_mgt');?></label>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<input  name="attorney_cv" class="form-control file pdf_validation" type="file">
								<input  name="hidden_cv"  type="hidden" value="">
								<p class="help-block"><?php esc_html_e('Upload document in PDF','lawyer_mgt');?></p> 
							</div>							
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="join"><?php esc_html_e('Education Certificate','lawyer_mgt');?></label>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<input name="education_certificate" class="pdf_validation form-control file" type="file">
								<input name="hidden_education_certificate"  type="hidden" value="">
								<p class="help-block"><?php esc_html_e('Upload document in PDF','lawyer_mgt');?></p> 
							</div>
						</div>	
						<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="join"><?php esc_html_e('Experience Certificate','lawyer_mgt');?></label>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<input  name="experience_cert" class="pdf_validation form-control file" type="file">
								<input  name="hidden_exp_certificate"  type="hidden" value="">
								<p class="help-block"><?php esc_html_e('Upload document in PDF','lawyer_mgt');?></p> 
							</div>
						</div>			
						<div class="offset-sm-2 col-sm-8">
							<input type="submit" value="<?php esc_attr_e('Add Attorney','lawyer_mgt');?>" name="save_attorney" class="btn btn-success"/>
						</div>
					</form>
				</div>	  
			</div>	  
		</div>	  
	</div><!-- END MODAL FADE DIV --> 