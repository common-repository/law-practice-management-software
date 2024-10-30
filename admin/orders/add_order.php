<?php 
$obj_orders=new MJ_lawmgt_Orders;
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
		 
		var start = new Date();
			var end = new Date(new Date().setYear(start.getFullYear()+1));
			$('.next_date').datepicker({
				startDate : start,
				endDate   : end,
				autoclose: true
			});		 
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
			
			$("#cartificate_div").append('<div class="form-group" row="'+value+'"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="documents"><?php esc_html_e('Upload Documents','lawyer_mgt');?></label><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><input type="text"  name="document_name[]" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>" class="form-control validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause"/></div><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><input type="file" name="orders_documents[]" class="form-control file_validation input-file "></div><div class="col-lg-2 col-md-1 col-sm-1 col-xs-12"><input type="button" value="<?php esc_html_e('Delete','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate doc_label btn btn-danger"></div></div>');
		}  			
		function MJ_lawmgt_deleteParentElement(n)
		{
			"use strict";
			alert("<?php esc_html_e('Do you really want to delete this ?','lawyer_mgt');?>");
			n.parentNode.parentNode.remove();				
		}	
</script>
<?php 	
if($active_tab == 'add_order')
{
	$order_id=0;
	$edit=0;
	if(isset($_REQUEST['id']))
		$order_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id']));
	if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
	{			
		$edit=1;		
		$order_info = $obj_orders->MJ_lawmgt_get_single_orders($order_id);			
	}?>
		
    <div class="panel-body"><!--PANEL BODY DIV   -->
        <form name="judgment_form" action="" method="post" class="form-horizontal" id="judgment_form" enctype='multipart/form-data'>	
			<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">		
			 
			 <div class="form-group">				
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="date"><?php esc_html_e('Date','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
				
					<input id="date" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="form-control has-feedback-left validate[required]" name="date"  placeholder="<?php esc_html_e('Select Order Date','lawyer_mgt');?>"
					 value="<?php if($edit){ echo esc_html(MJ_lawmgt_getdate_in_input_box($order_info->date));}elseif(isset($_POST['date'])){ echo MJ_lawmgt_getdate_in_input_box($_POST['date']); } ?>" readonly>
					<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
					<span id="inputSuccess2Status2" class="sr-only"><?php esc_html_e('(success)','lawyer_mgt');?></span>
					
					 
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Case Name','lawyer_mgt');?><span class="require-field">*</span></label>				
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">			
					<select class="form-control validate[required]" name="case_id" id="case_id">
					<option value=""><?php esc_html_e('Select Case Name','lawyer_mgt');?></option>
					<?php 
					 if($edit)
					 {
						$case_name = esc_attr($order_info->case_id);
					 }						
					else
					{						
						$case_name = "";
					}
					$obj_case=new MJ_lawmgt_case;
					$result = $obj_case->MJ_lawmgt_get_open_all_case();
					if(!empty($result))
					{
						foreach ($result as $retrive_data)
						{ 		 	
						?>
							<option value="<?php echo esc_attr($retrive_data->id);?>" <?php selected($case_name,esc_attr($retrive_data->id));  ?>><?php echo esc_html($retrive_data->case_name); ?> </option>
						<?php
						}
					} 
					?> 
					</select>				
				</div>			
			</div>
			<?php wp_nonce_field( 'save_order_nonce' ); ?>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12  control-label" for=""><?php esc_html_e('Judge Name','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
					<input id="judge_name" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]
					text-input" type="text" placeholder="<?php esc_html_e('Enter Judge Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($order_info->judge_name);}elseif(isset($_POST['judge_name'])){ echo esc_attr($_POST['judge_name']); } ?>" name="judge_name">
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>	
			
			
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for=""><?php esc_html_e('Orders Details','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
					<textarea rows="3"  class="validate[required,custom[address_description_validation],maxSize[150]] width_100_per" name="orders_details" placeholder="<?php esc_html_e('Enter Orders Details','lawyer_mgt');?>" id="orders_details"><?php if($edit){ echo esc_textarea($order_info->orders_details);}elseif(isset($_POST['orders_details'])){ echo esc_textarea($_POST['orders_details']); } ?></textarea>				
				</div>		
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Hearing_date"><?php esc_html_e('Next Hearing Date','lawyer_mgt');?><span class="require-field">*</span></label>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
						<input id="next_hearing_date"  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="next_date form-control has-feedback-left validate[required]" type="text"  name="next_hearing_date"  placeholder="<?php esc_html_e('Select Next Hearing Date','lawyer_mgt');?>"
						value="<?php if($edit){ echo MJ_lawmgt_getdate_in_input_box($order_info->next_hearing_date);}elseif(isset($_POST['next_hearing_date'])){ echo esc_html(MJ_lawmgt_getdate_in_input_box($_POST['next_hearing_date'])); } ?>" readonly>
						<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
						 
					</div>
			</div>	
				
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="next_hearing_date_description"><?php esc_html_e('Purpose Of Hearing','lawyer_mgt');?></label>
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
					<textarea rows="3" class="validate[custom[address_description_validation],maxSize[150]] width_100_per" name="purpose_of_hearing" id="purpose_of_hearing"><?php if($edit){ echo esc_textarea($order_info->purpose_of_hearing);}elseif(isset($_POST['purpose_of_hearing'])){ echo esc_textarea($_POST['purpose_of_hearing']); } ?></textarea>				
				</div>		
			</div>
			<?php  
			if($edit)
			{
				?>
				<div id="cartificate_div">	
					<input type="hidden" name="hidden_doc" value="<?php echo esc_attr($order_info->orders_document); ?>">
					<?php
					$increment=1;
					$doc_data=json_decode($order_info->orders_document);
					if(!empty($doc_data))
					{
						foreach ($doc_data as $retrieved_data)
						{
						?>
							<div class="form-group">	
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Upload Documents','lawyer_mgt');?></label>	
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									<input type="text"  name="document_name[]" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($retrieved_data->title);}elseif(isset($_POST['document_name'])){ echo esc_attr($_POST['document_name']); } ?>"  class="form-control 	validate[custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause"/>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">					
									<input type="file" name="orders_documents_old[]" class="form-control file_validation input-file"/>						
									<input type="hidden" name="old_hidden_orders_documents[]" value="<?php if($edit){ echo esc_attr($retrieved_data->value);}elseif(isset($_POST['orders_details'])){ echo esc_attr($_POST['orders_details']); } ?>">					
								</div>
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									<a  target="blank" class="status_read btn btn-default" href="<?php print esc_url(content_url().'/uploads/document_upload/'.esc_attr($retrieved_data->value)); ?>" record_id="<?php echo esc_attr($order_info->id);?>">
									<i class="fa fa-download"></i><?php echo esc_html($retrieved_data->value);?></a>
								</div>
								<?php
								if($increment != 1)
								{
								?>
									<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12"><input type="button" value="<?php esc_html_e('Delete','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger"></div>
								<?php	
								}
								?>
							</div>
						<?php
							$increment=$increment-1;
						}
					}
					else
					{
						?>
						<div class="form-group" row="1">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="documents"><?php esc_html_e('Upload Documents','lawyer_mgt');?></label>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<input type="text"  name="document_name[]" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>" class="form-control validate[custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause"/>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
								<input type="file" name="orders_documents[]" class="form-control file_validation input-file ">
							</div>	
						</div>	
						<?php
					}				
					?>
				</div>
				<?php
			}
			else{
			?>
			<div id="cartificate_div">	
				<div class="form-group" row="1">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="documents"><?php esc_html_e('Upload Documents','lawyer_mgt');?></label>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<input type="text"  name="document_name[]" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>" class="form-control validate[custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause"/>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<input type="file" name="orders_documents[]" class="form-control file_validation input-file ">
					</div>	
				</div>	
			</div>	
			<?php  } ?>
			<div class=" offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
					<input type="button" value="<?php esc_attr_e('Add More Documents','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_cirtificate()" class="add_cirtificate btn btn-success mt_10">
				</div>
			<div class="offset-sm-2 col-sm-8">
				<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Add Orders','lawyer_mgt');}?>" name="save_orders" class="btn btn-success mt_10"/>
			</div>
        </form>
	</div><!--END PANEL BODY DIV   -->
<?php 
}
?>