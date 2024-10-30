<?php 	
$obj_documents=new MJ_lawmgt_documents;
?>
<script type="text/javascript">
    var $ = jQuery.noConflict();
	jQuery(document).ready(function($)
	{
		"use strict";
		$('#documents_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
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
			$(this).replaceWith('<input type="file" name="cartificate[]" class="form-control file_validation input-file">');
			return false; 
		} 
	 //File Size Check 
	 if (file.size > 20480000) 
	 {
			 
			alert("<?php esc_html_e('Too large file Size. Only file smaller than 10MB can be uploaded.','lawyer_mgt');?>");
			$(this).replaceWith('<input type="file" name="cartificate[]" class="form-control file_validation input-file">'); 
			return false; 
		 }
	 });
		//add more file upload div append
		 "use strict";
		var blank_cirtificate_entry ='';
		jQuery(document).ready(function($)
		{ 
			 "use strict";
			blank_cirtificate_entry = $('#cartificate_entry1').html();   	
		}); 
		 "use strict";
		var value = 1;
		function MJ_lawmgt_add_cirtificate()
		{
			 "use strict";
			value++;
			
			$("#cartificate_div").append('<div id="cartificate_entry1" class="abc cartificate_entry" row="'+value+'"><input type="hidden" name="hidden_tags[]" value="" id="hidden_tags'+value+'" class="hidden_tags" row="'+value+'"><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Title','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="text"  name="cartificate_name[]" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>" class="form-control validate[required,custom[onlyLetter_specialcharacter]],maxSize[50]]"  /></div><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><input type="file" name="cartificate[]" class="form-control file_validation input-file validate[required]"></div><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="text" name="tag_name" id="tag_name'+value+'" class="form-control tages_add ui-autocomplete-input validate[custom[onlyLetter_specialcharacter]],maxSize[50]]"  row="'+value+'" placeholder="<?php esc_html_e('Enter New Tages','lawyer_mgt');?>" autocomplete="off" value=""></div><div id="suggesstion-box"></div><div class="col-lg-1 col-md-2 col-sm-2 col-xs-12"><button type="button" class="btn btn-success botton_submit_pulse addtages_documents" row="'+value+'" id="addtages_community"><?php esc_html_e('Add Tag','lawyer_mgt');?></button></div><div class="col-lg-2 col-md-1 col-sm-1 col-xs-12"><input type="button" value="<?php esc_html_e('Delete','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate doc_label btn btn-danger"></div></div><div class="list_tag_name'+value+' col-lg-offset-7 col-lg-5 col-md-offset-7 col-md-5 col-sm-offset-7 col-sm-5 col-xs-12" row="'+value+'"></div></div>');
		}  	
		
		function MJ_lawmgt_deleteParentElement(n)
		{
			 "use strict";
			alert("<?php esc_html_e('Do you really want to delete this ?','lawyer_mgt');?>");
			n.parentNode.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode.parentNode);		
			 
		}
</script>
	<?php
	$documents_id=0;
	$edit=0;
	if(isset($_REQUEST['documents_id']))
		$documents_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['documents_id']));
	if(isset($_REQUEST['edit']) && sanitize_text_field($_REQUEST['edit']) == 'true')
	{			
		$edit=1;
		$document_result = $obj_documents->MJ_lawmgt_get_single_documents($documents_id);				
	}
	?>		
    <div class="panel-body"><!-- PANEL BODY DIV -->
        <form name="documents_form" action="" method="post" class="form-horizontal" id="documents_form" enctype='multipart/form-data'>	
			<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
			<input type="hidden" name="documents_id" value="<?php echo esc_attr($documents_id);?>"  />
			<div class="header">	
				<h3 class="first_hed"><?php esc_html_e('Documents Information','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="form-group">		
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="documets_type"><?php esc_html_e('Documents Type','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
				<select class="form-control validate[required]" name="documents_type" id="documents_type">		
				<option value=""><?php esc_html_e('Select Documents Type','lawyer_mgt');?></option>
						<?php if($edit)
						{
						   $documents_type =esc_html($document_result->type);	
						}						
					    else 
						{
						   $documents_type = ""; 
						}
					 ?>
					<option value="Case Documents" <?php if($documents_type == 'Case Documents') echo 'selected = "selected"';?>><?php esc_html_e('Case Documents','lawyer_mgt');?></option>
					<option value="Firm Documents" <?php  if($documents_type == 'Firm Documents') echo 'selected = "selected"';  ?>><?php esc_html_e('Firm Documents','lawyer_mgt');?></option>
					<option value="Templates" <?php   if($documents_type == 'Templates') echo 'selected = "selected"';  ?>><?php esc_html_e('Template','lawyer_mgt');?></option>				
				</select>
				</div>
			</div>	
			<?php wp_nonce_field( 'save_case_document_nonce' ); ?>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Case Name','lawyer_mgt');?><span class="require-field">*</span></label>				
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">	
					<?php
						$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
		
		
						global $wpdb;
						$table_case = $wpdb->prefix. 'lmgt_cases';

						$result = $wpdb->get_row("SELECT * FROM $table_case where id=".$case_id);
						
					?>	
					<input type="hidden" class="form-control" name="case_name" id="case_name" value="<?php echo esc_attr($result->id);?>">		
					<input type="text" class="form-control" name="c_name" id="c_name" value="<?php echo esc_attr($result->case_name);?>" readonly="readonly">								
				</div>			
			</div>	
			<?php 			
			if($edit)
			{				
				?> 			
					<div id="cartificate_entrys">
						<?php 
						$tag_name=explode(",",$document_result->tag_names);
						$div_tag_names=array();
						foreach ($tag_name as $retrive_data)
						{ 	
								$div_tag_names[]=$retrive_data;
						}
						?>
						<input type="hidden" name="hidden_tags[]" value="<?php echo implode(',',$div_tag_names);?>" id="hidden_tags1" row="1">
						<div class="form-group">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Title','lawyer_mgt');?><span class="require-field">*</span></label>	
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<input type="text" name="cartificate_name" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>" class="form-control validate[required,custom[onlyLetter_specialcharacter]],maxSize[50]]" value="<?php if($edit){ echo esc_attr($document_result->title);}elseif(isset($_POST['cartificate_name'])){ echo esc_attr($_POST['cartificate_name']); } ?>" />								
							</div>
						</div>
						<div class="form-group">	
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Select File','lawyer_mgt');?><span class="require-field">*</span></label>	
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">					
								<input type="file" name="cartificate" class="form-control file_validation input-file"/>						
								<input type="hidden" name="old_hidden_cartificate" value="<?php if($edit){ echo esc_attr($document_result->document_url);}elseif(isset($_POST['cartificate'])){ echo esc_attr($_POST['cartificate']); } ?>">					
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<a  target="blank" class="status_read btn btn-default" href="<?php print content_url().'/uploads/document_upload/'.$document_result->document_url; ?>" record_id="<?php echo esc_attr($document_result->id);?>>
								<i class="fa fa-download"></i><?php echo esc_html($document_result->document_url);?></a>
							</div>
						</div>
						<div class="form-group">	
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Tags','lawyer_mgt');?></label>	
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">	      
								<input type="text" name="tag_name" id="tag_name1" class="form-control tages_add ui-autocomplete-input validate[custom[onlyLetter_specialcharacter]],maxSize[50]]" placeholder="<?php esc_html_e('Enter New Tages','lawyer_mgt');?>" autocomplete="off" value="" row="1">	
							</div>
							<div id="suggesstion-box"></div>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
								<button type="button" class="btn btn-success botton_submit_pulse addtages_documents" id=""  row="1"><?php esc_html_e('Add Tag','lawyer_mgt') ?></button>
							</div>
						</div>		
						<div class="form-group">
							<div class="list_tag_name1 offset-lg-2 col-lg-4 offset-md-2 col-md-4 offset-sm-2 col-sm-4 col-xs-12" row="1">
						<?php
					
						$tag_name=explode(",",$document_result->tag_names);
							
						foreach ($tag_name as $retrive_data)
						{
							if(!empty($retrive_data))
							{								
							?>
								<div class="added_tag tagging_name"><?php echo esc_attr($retrive_data);?>
								<i class="close fa fa-times removetages sugcolor" row="1" value="<?php echo esc_attr($retrive_data);?>"></i>
								<input type="hidden"  name="documents_tag_names[][]" value="<?php echo esc_attr($retrive_data);?>">
								</div>
							<?php
							}
						}	 
						?>
							</div>
						</div>
					</div>
				<?php				
				
			}			
			else
			{
			?>		
				<div id="cartificate_div">			
					<div id="cartificate_entry1" class="cartificate_entry" row="1">
						<input type="hidden" name="hidden_tags[]" value="" id="hidden_tags1" row="1">
						<div class="form-group">
						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Title','lawyer_mgt');?><span class="require-field">*</span></label>		
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
							<input type="text"  name="cartificate_name[]" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>" class="form-control validate[required,custom[onlyLetter_specialcharacter]],maxSize[50]]" />
						</div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">					
						 						
						<input type="file" name="cartificate[]" class="form-control file_validation validate[required] input-file">				
						</div>					
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">	      
							<input type="text" name="tag_name" id="tag_name1" class="form-control tages_add ui-autocomplete-input validate[custom[onlyLetter_specialcharacter]],maxSize[50]]"   placeholder="<?php esc_html_e('Enter New Tages','lawyer_mgt');?>" autocomplete="off" value="" row="1">	
							
						</div>
						<div id="suggesstion-box"></div>
						<div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
							<button type="button" class="btn btn-success botton_submit_pulse addtages_documents" id="addtages_documents"  row="1"><?php esc_html_e('Add Tag','lawyer_mgt') ?></button>
						</div>	
					
						 		
						</div>
						<div class="list_tag_name1 col-lg-offset-7 col-lg-5 col-md-offset-7 col-md-5 col-sm-offset-7 col-sm-5 col-xs-12" value="" row="1">
							
						</div>
					</div>		
				</div>		
				<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
					<input type="button" value="<?php esc_html_e('Add More Documents','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_cirtificate()" class="add_cirtificate btn btn-success">
				</div>
			<?php
			}
			?>	
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="document_description"><?php esc_html_e('Description','lawyer_mgt');?></label>
				<div class="col-sm-4 has-feedback">
					<textarea rows="3" name="document_description" class="validate[custom[address_description_validation]],maxSize[150]] width_100_per"   id="document_description"><?php if($edit){ echo esc_textarea($document_result->document_description);}elseif(isset($_POST['document_description'])){ echo esc_textarea($_POST['document_description']); } ?></textarea>				
				</div>		
			</div>	
			<div class="offset-sm-2 col-sm-8">
				<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Add Documents','lawyer_mgt');}?>" id="save_documents" name="save_documents" class="btn btn-success"/>
			</div>
        </form>
    </div><!-- END PANEL BODY DIV -->