<?php 
$obj_rules=new MJ_lawmgt_rules;
?>
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		"use strict";
		$('#rules_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	});

	jQuery("body").on("change", ".input-file[type=file]", function ($)
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
</script>
<?php 	
if($active_tab == 'add_rules')
{
	$id=0;
	$edit=0;
	if(isset($_REQUEST['id']))
		$id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id']));
	 
		if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
		{					
			$edit=1;
			$rules_data=$obj_rules->MJ_lawmgt_get_signle_rule_by_id($id);
		} ?>
    <div class="panel-body"><!-- PANEL BODY DIV  -->
       <form name="rules_form" action="" method="post" class="form-horizontal" id="rules_form" enctype='multipart/form-data'>	
			<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
			<input id="action" class="form-control  text-input" type="hidden"  value="<?php echo esc_attr($action); ?>" name="action">
			
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Rule Name','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 has-feedback">
					<input id="rule_name" class="form-control validate[required,custom[address_description_validation],maxSize[150]] text-input" name="rule_name" type="text" placeholder="<?php esc_html_e('Enter Rule Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($rules_data->rule_name);}elseif(isset($_POST['rule_name'])){ echo esc_attr($_POST['rule_name']); } ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="description"><?php esc_html_e('Description','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 has-feedback">
					<textarea rows="3"  class="validate[required,custom[address_description_validation],maxSize[150]] width_100_per" name="description" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" id="description"><?php if($edit){ echo esc_textarea($rules_data->description);}elseif(isset($_POST['description'])){ echo esc_textarea($_POST['description']); } ?></textarea>					
				</div>		
			</div>
			<?php wp_nonce_field( 'save_rules_nonce' ); ?>
			<?php  
			if($edit)
			{
				$doc_data=json_decode($rules_data->document_url);
				?>
				<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="documents"><?php esc_html_e('Upload Documents','lawyer_mgt');?></label>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
							<input type="text"  name="document_name" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($doc_data[0]->title);}elseif(isset($_POST['document_name'])){ echo esc_attr($_POST['document_name']); } ?>"  class="form-control validate[custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause"/>
						</div>
						<label class="col-lg-1 col-md-1 col-sm-1 col-xs-12 control-label"><?php esc_html_e('Select File','lawyer_mgt');?></label>							
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">					
							<input type="file" name="rule_documents" class="form-control file_validation input-file"/>						
							<input type="hidden" name="old_hidden_rule_documents" value="<?php if($edit){ 
							echo esc_url($doc_data[0]->value);}elseif(isset($_POST['rule_documents'])){ echo esc_url($_POST['rule_documents']); } ?>">					
						</div>
						
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<?php
							if(!empty($doc_data[0]->value))
							{
								?>
								<a  target="blank" class="status_read btn btn-default" href="<?php print esc_url(content_url().'/uploads/document_upload/'.esc_attr($doc_data[0]->value)); ?>" record_id="<?php echo esc_attr($rules_data->id);?>">
								<i class="fa fa-download"></i><?php echo esc_attr($doc_data[0]->value);?></a>
								<?php
							}
							?>
						</div>
					</div>
			<?php }
			else{
			?>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="documents"><?php esc_html_e('Upload Documents','lawyer_mgt');?></label>
				 
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<input type="text"  name="document_name" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>" class="form-control validate[custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause"/>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<input type="file" name="rule_documents" class="form-control file_validation input-file ">
				</div>				
				 
			</div>	
			<?php  } ?>
			<div class="form-group margin_top_div_css1">
				<div class="offset-sm-2 col-sm-8">
				  <input type="submit" id="submitrules" name="saverules" class="btn btn-success" value="<?php if($edit){		
				   esc_attr_e('Save Rule','lawyer_mgt');}else{ esc_attr_e('Add Rule','lawyer_mgt');}?>"></input>
				</div>
			</div>
        </form>
	</div><!-- END PANEL BODY DIV  -->
<?php 
}
?>	