<?php 
$obj_judgments=new MJ_lawmgt_Judgments;
?>
<script type="text/javascript">
    var $ = jQuery.noConflict();
	jQuery(document).ready(function($)
	{
		"use strict";
		$('#judgment_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});

		$('#date').datepicker({
				changeMonth: true,
				changeYear: true,	        
				yearRange:'-65:+0',
				 endDate: '+0d',
				autoclose: true,
				onChangeMonthYear: function(year, month, inst) {
					$(this).val(month + "/" + year);
				}                    
		 }); 
		
		jQuery("body").on("change", ".input-file[type=file]", function ()
		{ 
		    "use strict";
			var file = this.files[0]; 
			var file_id = jQuery(this).attr('id'); 
			var ext = $(this).val().split('.').pop().toLowerCase(); 
			//Extension Check 
			if($.inArray(ext, ['pdf','doc','docx','xls','xlsx','ppt','pptx','csv']) == -1)
			{
				  alert('<?php _e("Only pdf,doc,docx,xls,xlsx,ppt,pptx,csv formate are allowed. '  + ext + ' formate are not allowed.","lawyer_mgt") ?>');
				$(this).replaceWith('<input type="file" name="rule_documents" class="form-control file_validation input-file">');
				return false; 
			} 
			 //File Size Check 
			 if (file.size > 20480000) 
			 {
				alert("<?php esc_html_e('Too large file Size. Only file smaller than 10MB can be uploaded.','lawyer_mgt');?>");
				$(this).replaceWith('<input type="file" name="rule_documents" class="form-control file_validation input-file">'); 
				return false; 
			 }
		 });	
	});
</script>
<?php 	
if($active_tab == 'add_judgment')
{
	$judgment_id=0;
	$edit=0;
	if(isset($_REQUEST['id']))
		$judgment_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id']));
	if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
	{			
		$edit=1;		
		$judgment_info = $obj_judgments->MJ_lawmgt_get_single_judgment($judgment_id);
		 
	}?>
		
    <div class="panel-body"><!--PANEL BODY DIV   -->
        <form name="judgment_form" action="" method="post" class="form-horizontal" id="judgment_form" enctype='multipart/form-data'>	
			<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">		
			<input type="hidden" name="judgment_id" value="<?php echo esc_attr($judgment_id);?>"  />			
			<div class="form-group">				
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="date"><?php esc_html_e('Date','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
					<input id="date" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="form-control has-feedback-left validate[required]" type="text"  name="date"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($judgment_info->date));}elseif(isset($_POST['date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['date'])); }?>" readonly>
					<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
					<span id="inputSuccess2Status2" class="sr-only"><?php esc_html_e('(success)','lawyer_mgt');?></span>
				</div>
			</div>
			<?php wp_nonce_field( 'save_judgment_nonce' ); ?>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Case Name','lawyer_mgt');?><span class="require-field">*</span></label>				
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">			
					<select class="form-control validate[required]" name="case_id" id="case_id">
					<option value=""><?php esc_html_e('Select Case Name','lawyer_mgt');?></option>
					<?php 
					 if($edit)
					 {
						$case_name = esc_attr($judgment_info->case_id);
					 }
					else 
					{
						$case_name = "";
					}
					$obj_case=new MJ_lawmgt_case;
					$user_case_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('cases');
					
					if($user_role == 'attorney')
					{
						if($user_case_access['own_data'] == '1')
						{
							$attorney_id = get_current_user_id();
							$result = $obj_case->MJ_lawmgt_get_all_open_case_by_attorney($attorney_id);	
						}
						else
						{
							$result = $obj_case->MJ_lawmgt_get_open_all_case();
						}		
					}
					else
					{
						if($user_case_access['own_data'] == '1')
						{
							$result = $obj_case->MJ_lawmgt_get_open_all_case_created_by();
						}
						else
						{
							$result = $obj_case->MJ_lawmgt_get_open_all_case();
						}
					}
					if(!empty($result))
					{
						foreach ($result as $retrive_data)
						{ 		 	
						?>
							<option value="<?php echo esc_attr($retrive_data->id);?>" <?php selected($case_name,$retrive_data->id);  ?>><?php echo esc_html($retrive_data->case_name); ?> </option>
						<?php
						}
					} 
					?> 
					</select>				
				</div>			
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12  control-label" for=""><?php esc_html_e('Judge Name','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
					<input id="judge_name" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input" type="text" placeholder="<?php esc_html_e('Enter Judge Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($judgment_info->judge_name);}elseif(isset($_POST['judge_name'])){ echo esc_attr($_POST['judge_name']); } ?>" name="judge_name">
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>	
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for=""><?php esc_html_e('Judgments Details','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
					<textarea rows="3" class="validate[required,custom[address_description_validation],maxSize[150]] width_100_per" name="judgments_details" placeholder="<?php esc_html_e('Enter Judgments Details','lawyer_mgt');?>" id="judgments_details"><?php if($edit){ echo esc_textarea($judgment_info->judgments_details);}elseif(isset($_POST['judgments_details'])){ echo esc_textarea($_POST['judgments_details']); } ?></textarea>				
				</div>		
			</div>
			<?php  
			if($edit)
			{ 
				$doc_data=json_decode($judgment_info->judgments_document);
			?>
				<div class="form-group">	
						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Upload Documents','lawyer_mgt');?></label>	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
							<input type="text"  name="document_name" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($doc_data[0]->title);}elseif(isset($_POST['document_name'])){ echo esc_attr($_POST['document_name']); } ?>"  class="form-control validate[custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause"/>
						</div>
						<label class="col-lg-1 col-md-1 col-sm-1 col-xs-12 control-label"><?php esc_html_e('Select File','lawyer_mgt');?></label>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">					
							<input type="file" name="judgement_documents" class="form-control file_validation input-file"/>						
							<input type="hidden" name="old_hidden_judgement_documents" value="<?php if($edit){ echo esc_attr($doc_data[0]->value);}elseif(isset($_POST['judgement_documents'])){ echo esc_attr($_POST['judgement_documents']); } ?>">					
						</div>
						<?php
						if(!empty($doc_data[0]->value))
						{
						?>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
								<a target="blank"  class="status_read btn btn-default" href="<?php print esc_url(content_url().'/uploads/document_upload/'.esc_attr($doc_data[0]->value)); ?>" record_id="<?php echo esc_attr($judgment_info->id);?>">
								<i class="fa fa-download"></i><?php echo esc_attr($doc_data[0]->value);?></a>
						</div>
							<?php
						}
					?>
					</div>
			<?php 
			}
			else 
			{
			?>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="documents"><?php esc_html_e('Upload Documents','lawyer_mgt');?></label>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<input type="text"  name="document_name" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>" class="form-control validate[custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause"/>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<input type="file" name="judgement_documents" class="form-control file_validation input-file ">				
				</div>	
			</div>	
			<?php  } ?>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for=""><?php esc_html_e('Laws Details','lawyer_mgt');?></label>
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
					<textarea rows="3" class="validate[custom[address_description_validation],maxSize[150]] width_100_per" name="judgments_law_details"   placeholder="<?php esc_html_e('Enter Laws Details','lawyer_mgt');?>" id="judgments_law_details"><?php if($edit){ echo esc_attr($judgment_info->judgments_law_details);}elseif(isset($_POST['judgments_law_details'])){ echo esc_attr($_POST['judgments_law_details']); } ?></textarea>				
				</div>		
			</div>
			<div class="offset-sm-2 col-sm-8 margin_top_div_css1">
				<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Add Judgment','lawyer_mgt');}?>" name="save_judgment" class="btn btn-success"/>
			</div>
        </form>
	</div><!--END PANEL BODY DIV   -->
<?php 
}
?>