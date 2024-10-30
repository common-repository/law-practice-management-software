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
<script type="text/javascript">
    var $ = jQuery.noConflict();
	jQuery(document).ready(function($)
	{
		"use strict";
		jQuery('#note_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
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
		$(".submitnote").on("click",function()
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
		 
		$(".submitnote").on("click",function()
		{	
			var checked = $(".multiselect_validation123 .dropdown-menu input:checked").length;

			if(!checked)
			{
				 
				alert("<?php esc_html_e('Please select atleast one Attorney Name','lawyer_mgt');?>");
				return false;
			}			
		}); 
	});	
</script>
<?php 	
if($active_tab == 'add_note')
{
	$note_id=0;
	$edt=0;
	if(isset($_REQUEST['id']))
		$note_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id']));
		$casedata='';
		if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'editnote')
		{					
			$edt=1;
			$casedata=$note->MJ_lawmgt_get_signle_note_by_id($note_id);
		}?>
    <div class="panel-body"><!-- PANEL BODY DIV  -->
       <form name="note_form" action="" method="post" class="form-horizontal" id="note_form" enctype='multipart/form-data'>	
			<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
			<input id="action" class="form-control  text-input" type="hidden"  value="<?php echo esc_attr($action); ?>" name="action">
			<div class="header">	
				<h3 class="first_hed"><?php esc_html_e('Linked To','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Case Name','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<?php
					$obj_case=new MJ_lawmgt_case;
					$result = $obj_case->MJ_lawmgt_get_open_all_case();
									
					if($edt){ $data=$casedata->case_id;}else{ $data=''; }?>
					<select class="form-control validate[required] case_id" name="case_id" id="case_id">				
						<option value=""><?php esc_html_e('Select Case Name','lawyer_mgt');?></option>
						<?php 
						foreach($result as $result1)
						{						
						  echo '<option value="'.esc_attr($result1->id).'" '.selected($data,esc_html($result1->id)).'>'.esc_html($result1->case_name).'</option>';
						} ?>
					</select>
				</div>
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="practice_area_id"><?php esc_html_e('Practice Area','lawyer_mgt');?></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback practics" >
					<input type="hidden" class="form-control" value="<?php if($edt){ echo esc_attr($casedata->practice_area_id);}?>" name="practice_area_id" id="practice_area_id" readonly />
					<input type="text" class="form-control" value="<?php if($edt){ echo esc_attr(get_the_title(esc_attr($casedata->practice_area_id))); }?>" name="practice_area_id1" id="practice_area_id1" readonly />
				</div>				
			</div>
			<?php wp_nonce_field( 'save_note_nonce' ); ?>
			<div class="form-group">
			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="assigned_to_user"><?php esc_html_e('Client Name','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback multiselect_validation">
					<?php if($edt){ $data=$casedata->assigned_to_user;}elseif(isset($_POST['assigned_to_user'])) { $data= sanitize_text_field($_POST['assigned_to_user']); }?>
						<?php 
							$conats=explode(',',$data);							
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
								<?php echo esc_html($user_name); ?>
							</option>
							<?php
							 }
							 ?>
						</select>						
				</div>
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="assigned_to_attorney"><?php esc_html_e('Attorney Name','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback multiselect_validation123">
					<?php if($edt){ $data=$casedata->assign_to_attorney;}elseif(isset($_POST['assign_to_attorney'])){ $data=sanitize_text_field($_POST['assign_to_attorney']); } ?>
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
			<div class="header">
				<h3><?php esc_html_e('Note Information','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="note_name"><?php esc_html_e('Note Name','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="note_name" class="form-control text-input validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]" type="text" placeholder="<?php esc_html_e('Enter Note Name','lawyer_mgt');?>" value="<?php if($edt){ echo esc_attr($casedata->note_name);}elseif(isset($_POST['note_name'])){ echo esc_attr($_POST['note_name']); } ?>" name="note_name">
				</div>
			</div>	
			 <div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="note"><?php esc_html_e('Note','lawyer_mgt');?><span class="require-field"></span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<?php 
					 $setting=array(
					 'media_buttons' => false,
					 'quicktags' => false,
					 'textarea_rows' => 10,
					 );
					 if($edt)
					{
						wp_editor(stripslashes($casedata->note),'note',$setting);
					}
					else
					{
						wp_editor('','note',$setting );
					}
					?>
				</div>
			</div>			
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="date_time"><?php esc_html_e('Date','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="date_time" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date1 form-control validate[required]  has-feedback-left " type="text"  name="date_time"  placeholder=""
					value="<?php if($edt){ echo esc_html(MJ_lawmgt_getdate_in_input_box($casedata->date_time));}else{ echo  date("Y/m/d");}?>" readonly>
					<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
				</div>			
			</div>
		   <div class="form-group margin_top_div_css1">
			<div class="offset-sm-2 col-sm-8">
				  <input type="submit" id="" name="savenote" class="btn btn-success submitnote" value="<?php if($edt){
				   esc_attr_e('Save Note','lawyer_mgt');}else{ esc_attr_e('Add Note','lawyer_mgt');}?>"></input>
			</div>
			</div>
        </form>
	</div><!-- END PANEL BODY DIV  -->
<?php 
}
?>	