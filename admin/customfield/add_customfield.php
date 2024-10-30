<?php	
$obj_custome_field=new MJ_lawmgt_custome_field;
$file_type_find='';
$file_type_value='';
$edit=0;
if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
{
	$edit=1;
	$custom_field_id=sanitize_text_field($_REQUEST['id']);
    $custom_field_data=$obj_custome_field->MJ_lawmgt_get_single_custom_field_data($custom_field_id);
}
?>	

<script type="text/javascript">
jQuery("document").ready(function($)
{
    "use strict";	
	$('#custom_field_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});						
});
</script>
<style>
	.checkbox-inline{
		padding-top: 15px !important;
		margin-top: 0;
		margin-bottom: 0;
	}
</style>
 <div class="panel-body"><!-- PANEL BODY DIV  -->
    <form class="form form-horizontal" name="custom_field_form" enctype="multipart/form-data" method="post" id="custom_field_form">
			<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
			<input type="hidden" name="custom_field_id" value="<?php if($edit){ echo esc_attr($custom_field_id); } ?>"/>
				<div class="header">	
					<h3 class="first_hed"><?php esc_html_e('Custom Field Information','lawyer_mgt');?></h3>
					<hr>
				</div>		   
				<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Form Name',	'lawyer_mgt');?><span class="require-field">*</span></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
						<select id="module_name" class="form-control validate[required]"  name="form_name" <?php if($edit){ ?> disabled <?php } ?>>
							<option value=""><?php esc_html_e('Select Form','lawyer_mgt');?></option>
							<option value="client" <?php if($edit) selected('client',$custom_field_data->form_name);?>><?php esc_html_e('Client','lawyer_mgt');?></option>
							<option value="case" <?php if($edit) selected('case',$custom_field_data->form_name);?>><?php esc_html_e('Case','lawyer_mgt');?></option>
							 
						</select>
					</div>
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Label',	'lawyer_mgt');?><span class="require-field">*</span></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
						<input type="text" id="field_label" maxlength="50" class="form-control  validate[required,custom[onlyLetter_specialcharacter]]" name="field_label" placeholder="<?php esc_html_e('Enter Name','lawyer_mgt');?>" <?php if($edit){ ?> value="<?php echo esc_attr($custom_field_data->field_label); ?>" <?php } ?>>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Type',	'lawyer_mgt');?><span class="require-field">*</span></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
						<select id="field_type" class="form-control validate[required] dropdown_change"  name="field_type" <?php if($edit){ ?> disabled <?php } ?>>
							<option value=""><?php esc_html_e('Select Input Type','lawyer_mgt');?></option>
							<option value="text" <?php if($edit) selected('text',$custom_field_data->field_type); ?>><?php esc_html_e('Text Box','lawyer_mgt');?></option>
							<option value="textarea" <?php if($edit) selected('textarea',$custom_field_data->field_type);?>><?php esc_html_e('Textarea','lawyer_mgt');?></option>
							<option value="dropdown" <?php if($edit) selected('dropdown',$custom_field_data->field_type);?>><?php esc_html_e('Dropdown','lawyer_mgt');?></option>
							<option value="date" <?php if($edit) selected('date',$custom_field_data->field_type);?>><?php esc_html_e('Date Field','lawyer_mgt');?></option>
							<option value="checkbox" <?php if($edit) selected('checkbox',$custom_field_data->field_type);?>><?php esc_html_e('Checkbox','lawyer_mgt');?></option>
							<option value="radio" <?php if($edit) selected('radio',$custom_field_data->field_type);?>><?php esc_html_e('Radio','lawyer_mgt');?></option>
							<option value="file" <?php if($edit) selected('file',$custom_field_data->field_type);?>><?php esc_html_e('File','lawyer_mgt');?></option>
						</select>
					</div>
					<?php 
					if($edit)
					{									
						$validation = explode("|",$custom_field_data->field_validation);
						$min = "";
						$max = "";
						$file_type = "";
						$file_size = "";
						$Tclass = $Dclass = NULL;
						foreach($validation as $key=>$value)
						{
							if (strpos($value, 'min') !== false)
							{
								 $min = $value;
							}
							elseif(strpos($value, 'max') !== false)
							{
								 $max = $value;
							}
							elseif(strpos($value, 'file_types') !== false)
							{
								 $file_type = $value;
							}
							elseif(strpos($value, 'file_upload_size') !== false)
							{
								 $file_size = $value;
							}	
						}									
						
						$exa = $custom_field_data->field_validation;
						$max_find = $max;
						$min_find = $min;
						$file_type_find = $file_type;
						$file_size_find = $file_size;
						$limit_max = substr($max_find,0,3);
						$limit_min = substr($min_find,0,3);
						$limit_value_max = substr($max_find,4);
						$limit_value_min = substr($min_find,4);
						$file_type_value = substr($file_type_find,11);
						$file_size_value = substr($file_size_find,17);
						
						if($custom_field_data->field_type=='dropdown' || $custom_field_data->field_type=='checkbox' || $custom_field_data->field_type=='radio'  )
						{
							$Tclass="disabled";
							$Dclass="disabled";										
						}
						else if($custom_field_data->field_type=='text' || $custom_field_data->field_type=='textarea')
						{
							$Dclass="disabled";
							$Tclass=NULL;									
						}
						else if($custom_field_data->field_type=='date')
						{
							$Tclass="disabled";
							$Dclass=NULL;
						}
					}			 
					?>
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Validation',	'lawyer_mgt');?><span class="require-field">*</span></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
						<div class="d-inline-block custom-control custom-checkbox mr-1 margin_left_custom_field">
							<label class="col-lg-3 col-md-3 col-sm-4 col-xs-12 margin_left_custom_field_new checkbox-inline mr-2">
							<input type="checkbox" name="validation[]"  value="nullable" class="nullable_rule margin_top_0" <?php if($edit){ if(in_array("nullable",$validation)){ echo 'checked'; } }else{ echo 'checked'; } ?>><span class="span_left_custom margin_bottom_5_px_css"><?php esc_html_e('Nullable','lawyer_mgt'); ?></span>
							</label>
							<label class=" col-lg-3 col-md-3 col-sm-4 col-xs-12 checkbox-inline mr-2">
							<input type="checkbox" name="validation[]"  value="required" class="required_rule margin_top_0" <?php if($edit){ if(in_array("required",$validation)){ echo 'checked'; } }  ?>><span class="span_left_custom"><?php esc_html_e('Required','lawyer_mgt'); ?></span>
							</label>
							<label class="col-lg-4 col-md-4 col-sm-4 col-xs-12 checkbox-inline mr-2">
							<input type="checkbox"  name="validation[]" <?php if($edit){ echo $Tclass; } ?> value="numeric" id="only_number_id" class="only_number margin_top_0" <?php if($edit){ if(in_array("numeric",$validation)){ echo 'checked'; } }  ?>><span class="span_left_custom"><?php esc_html_e('Only Number','lawyer_mgt'); ?></span>
							</label>
							<label class="col-lg-4 col-md-4 col-sm-4 col-xs-12 checkbox-inline mr-2 ">
							<input type="checkbox" name="validation[]" <?php if($edit){ echo $Tclass; } ?> value="alpha" id="only_char_id" class="only_char margin_top_0"<?php if($edit){ if(in_array("alpha",$validation)){ echo 'checked'; } }  ?>><span class="span_left_custom"><?php esc_html_e('Only Character','lawyer_mgt'); ?></span>
							</label>
							<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 checkbox-inline mr-2">
							<input type="checkbox" name="validation[]" <?php if($edit){ echo $Tclass; } ?>  value="alpha_space" id="char_space_id" class="char_space margin_top_0" <?php if($edit){ if(in_array("alpha_space",$validation)){ echo 'checked'; } }  ?>><span class="span_left_custom"><?php esc_html_e('Character with Space','lawyer_mgt'); ?></span>
							</label>
							<label class="col-lg-6 col-md-6 col-sm-6 col-xs-12 checkbox-inline mr-2 ">
							<input type="checkbox" id="char_num_id" class="char_num margin_top_0" <?php if($edit){ echo $Tclass; } ?> name="validation[]"  value="alpha_num " <?php if($edit){ if(in_array("alpha_num",$validation)){ echo 'checked'; } }  ?>><span class="span_left_custom"><?php esc_html_e('Number & Character','lawyer_mgt'); ?></span>
							</label>
							<label class="col-lg-4 col-md-4 col-sm-4 col-xs-12 checkbox-inline mr-2">
							<input type="checkbox" id="email_id" class="email margin_top_0" <?php if($edit){ echo $Tclass; } ?>  name="validation[]"  value="email" <?php if($edit){ if(in_array("email",$validation)){ echo 'checked'; } }  ?>><span class="span_left_custom"><?php esc_html_e('Email','lawyer_mgt'); ?></span>
							</label>
							<label class="col-lg-4 col-md-4 col-sm-4 col-xs-12 checkbox-inline mr-2">
							<input type="checkbox" name="validation[]" <?php if($edit){ echo $Tclass; } ?> class="opentext max margin_top_0" id="max_value" value="max" <?php if($edit){ if(in_array("max",$validation)){ echo 'checked'; } }  ?>><span class="span_left_custom"><?php esc_html_e('Maximum','lawyer_mgt'); ?></span>
							</label>
							<label class="col-lg-4 col-md-4 col-sm-4 col-xs-12 checkbox-inline mr-2 ">
							<input type="checkbox" name="validation[]" <?php if($edit){ echo $Tclass; } ?> class="opentext min margin_top_0" id="min_value" value="min" <?php if($edit){ if(in_array("min",$validation)){ echo 'checked'; } }  ?>><span class="span_left_custom"><?php esc_html_e('Minimum','lawyer_mgt'); ?></span>
							</label>
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 checkbox-inline mr-2">
							<input type="checkbox" class="url margin_top_0" name="validation[]" <?php if($edit){ echo $Tclass; } ?> value="url" <?php if($edit){ if(in_array("url",$validation)){ echo 'checked'; } }  ?>><span class="span_left_custom"><?php esc_html_e('URL','lawyer_mgt'); ?></span>
							</label>
							<label class="col-lg-8 col-md-8 col-sm-8 col-xs-12 checkbox-inline mr-2 ">
							<input type="checkbox" name="validation[]" <?php if($edit){ echo $Dclass; } ?> id="date0" class="date margin_top_0" value="before_or_equal:today" <?php if($edit){ if(in_array("before_or_equal:today",$validation)){ echo 'checked'; } }  ?>><span class="span_left_custom"><?php esc_html_e("Before Or Equal(Today's Date)",'lawyer_mgt'); ?></span>
							</label>
							<label class="col-lg-4 col-md-4 col-sm-4 col-xs-12 checkbox-inline mr-2 ">
							<input type="checkbox" name="validation[]" <?php if($edit){ echo $Dclass; } ?> id="date1"  class="date margin_top_0"  value="date_equals:today" <?php if($edit){ if(in_array("date_equals:today",$validation)){ echo 'checked'; } }  ?>><span class="span_left_custom"><?php esc_html_e("Today's Date",'lawyer_mgt'); ?></span>
							</label>
							<label class="col-lg-8 col-md-8 col-sm-8 col-xs-12 checkbox-inline mr-2">
							<input type="checkbox" name="validation[]" <?php if($edit){ echo $Dclass; } ?> id="date2"  class="date margin_top_0"   value="after_or_equal:today" <?php if($edit){ if(in_array("after_or_equal:today",$validation)){ echo 'checked'; } }  ?>><span class="span_left_custom"><?php esc_html_e("After Or Equal(Today's Date)",'lawyer_mgt'); ?></span>
							</label>
						</div>
					</div>
				</div>
				<?php 
				if($edit)
				{
					$custom_meta=$obj_custome_field->MJ_lawmgt_get_single_custom_field__dropdown_meta_data($custom_field_id);	
					if($custom_field_data->field_type=='dropdown')
					{	
						?>
						<div class="sub_cat">
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Dropdown Label','lawyer_mgt');?></label>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
									<input type="text" maxlength="30" class="form-control" placeholder="<?php esc_html_e('','lawyer_mgt');?>">
								</div>
								<div class="col-md-2">
									<input type="button"  name="menu_web" class="btn btn-primary add_more" value="<?php esc_attr_e('Add More','lawyer_mgt'); ?>">
								</div>
							</div>
						</div>							
						<div class="row">
							<div class="col-md-12 drop_label">
								<?php
								if(!empty($custom_meta))
								{	
									foreach($custom_meta as $custom_metas)
									{
										?>												
										<div class="badge badge-danger label_data custom-margin" >
											<input type="hidden" value="<?php echo esc_attr($custom_metas->option_label); ?>" name="d_label[]"><span><?php echo esc_html($custom_metas->option_label); ?></span><a href="#"><i label_id="<?php echo esc_attr($custom_metas->id); ?>" class="fa fa-trash font-medium-2 delete_d_label" aria-hidden="true"></i></a>
										</div>
										&nbsp;
										<?php
									}
								}
								?>
							</div>
						</div>
						<?php
					}
					elseif($custom_field_data->field_type=='checkbox')
					{
						?>
						
						<div class="checkbox_cat">
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Checkbox Label','lawyer_mgt');?></label>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
									<input type="text" maxlength="30" class="form-control c_label" placeholder="<?php esc_html_e('','lawyer_mgt');?>">
								</div>
								<div class="col-md-2">
									<input type="button"  name="menu_web" class="btn btn-primary add_more_checkbox" value="<?php esc_html_e('Add More','lawyer_mgt'); ?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 checkbox_label">
							<?php
								if(!empty($custom_meta))
								{	
									foreach($custom_meta as $custom_metas)
									{
										?>												
										<div class="badge badge-warning label_checkbox custom-margin"  >
											<input type="hidden" value="<?php echo esc_attr($custom_metas->option_label); ?>"  name="c_label[]"><span><?php echo esc_html($custom_metas->option_label); ?></span><a href="#"><i label_id="<?php echo esc_attr($custom_metas->id); ?>" class="fa fa-trash font-medium-2 delete_c_label" aria-hidden="true"></i></a>
										</div>
										&nbsp;
										<?php
									}
								}
							?>										
							</div>
						</div>
						<?php
					}
					elseif($custom_field_data->field_type=='radio')
					{
						?>
						<div class="radio_cat">
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Radio Label','lawyer_mgt');?></label>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
									<input type="text" maxlength="30" class="form-control r_label" placeholder="<?php esc_html_e('','lawyer_mgt');?>">
								</div>
								<div class="col-md-2">
									<input type="button"  name="menu_web" class="btn btn-primary add_more_radio" value="<?php esc_attr_e('Add More','lawyer_mgt'); ?>">
								</div>
							</div>
						</div>
						 
						<div class="row">
							<div class="col-md-12 radio_label">
								<?php
								if(!empty($custom_meta))
								{	
									foreach($custom_meta as $custom_metas)
									{
										?>												
										<div class="badge badge-secondary label_radio custom-margin"  >
											<input type="hidden" value="<?php echo esc_attr($custom_metas->option_label); ?>"  name="r_label[]"><span><?php echo esc_html($custom_metas->option_label); ?></span><a href="#"><i class="fa fa-trash font-medium-2 delete_r_label" label_id="<?php echo esc_attr($custom_metas->id); ?>" aria-hidden="true"></i></a>
										</div>
										&nbsp;
										<?php
									}
								}
								?>
							</div>
						</div>
						<?php
					}
					?>
					
					<div class="file_type_and_size">
						<?php																		
						if(strpos($file_type_find, 'file_types') !== false)
						{
							?>
							<div class="form-group margin_top_custome">
							
								<input type="hidden" name="validation[]" value="<?php echo esc_attr($file_type_find); ?>" class="file_types_value"> 
								<label class=" col-lg-2 col-md-2 col-sm-2 col-xs-12  control-label" for="case_link"><?php esc_html_e('File Types (like png,jpg,pdf,doc)','lawyer_mgt');?><span class="require-field">*</span></label>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
									<input class="form-control file_types_input" maxlength="100" type="text" id="userinput11" value="<?php echo esc_attr($file_type_value); ?>">
								</div>
							
							<?php
						}																	
						if(strpos($file_size_find, 'file_upload_size') !== false)
						{
							?>
								<input type="hidden" name="validation[]" value="<?php echo $file_size_find; ?>" class="file_size_value"> 
								<label class=" col-lg-2 col-md-2 col-sm-2 col-xs-12  control-label" for="case_link"><?php esc_html_e('File Upload Size(kb','lawyer_mgt');?><span class="require-field">*</span></label>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
									<input class="form-control file_size_input" maxlength="30" type="text" id="userinput9" value="<?php echo esc_attr($file_size_value); ?>">
								</div>
							
							</div>										
						<?php
						}	
						?>	
					</div>	
					
					<div class="">									
						<?php
						if(strpos($max_find, 'max') !== false)
						{
							?>
							<div class="" id="min_limit">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Minimum Limit','lawyer_mgt');?><span class="require-field">*</span></label>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
									<input type="number" class="form-control validate[required]" value="<?php echo esc_attr($limit_value_min); ?>"  id="min" >
								</div>
							</div>
							<?php
						}
						else	
						{
							?>
							<div class="display_none_css" id="min_limit">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Minimum Limit','lawyer_mgt');?><span class="require-field">*</span></label>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
									<input type="number" class="form-control validate[required]"  id="min" >
								</div>
							</div>
							<?php
						}									
						if(strpos($min_find, 'min') !== false)
						{
							?>	
							<div class="" id="max_limit">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Maximum Limit','lawyer_mgt');?><span class="require-field">*</span></label>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
									<input type="number" class="form-control validate[required]" value="<?php echo esc_attr($limit_value_max); ?>"  id="max" >
								</div>
							</div>
							<?php
						}
						else	
						{
							?>	
							<div class="display_none_css" id="max_limit">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Maximum Limit','lawyer_mgt');?><span class="require-field">*</span></label>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
									<input type="number" class="form-control validate[required]"  id="max" >
								</div>
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
					<div class="sub_cat display_none_css">
						 
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Dropdown Label','lawyer_mgt');?></label>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
									<input type="text" maxlength="30" class="form-control d_label" placeholder="<?php esc_html_e('','lawyer_mgt');?>">
								</div>
								<div class="col-md-2">
									<input type="button"  name="menu_web" class="btn btn-primary add_more" value="<?php esc_attr_e('Add More','lawyer_mgt'); ?>">
								</div>
							</div>
						 
					</div>							
					<div class="row sub_cat">
						<div class="col-md-12 drop_label">
						</div>
					</div>	
					<div class="checkbox_cat display_none_css">
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Checkbox Label','lawyer_mgt');?></label>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
									<input type="text" maxlength="30" class="form-control c_label" placeholder="<?php esc_html_e('','lawyer_mgt');?>">
								</div>
								<div class="col-md-2">
									<input type="button"  name="menu_web" class="btn btn-primary add_more_checkbox" value="<?php esc_html_e('Add More','lawyer_mgt'); ?>">
								</div>
							</div>
						</div>
					 
					<div class="row checkbox_cat">
						<div class="col-md-12 checkbox_label">
						</div>
					</div>
					
					<div class="radio_cat display_none_css">
						<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Radio Label','lawyer_mgt');?> </label>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
									<input type="text" maxlength="30" class="form-control r_label" placeholder="<?php esc_html_e('','lawyer_mgt');?>">
								</div>
								<div class="col-md-2">
									<input type="button"  name="menu_web" class="btn btn-primary add_more_radio" value="<?php esc_html_e('Add More','lawyer_mgt'); ?>">
								</div>
						</div>
					</div>
					<div class="row radio_cat">
						<div class="col-md-12 radio_label">
						</div>
					</div>
					
					<div class="file_type_and_size display_none_css">
						<div class="form-group margin_top_custome">
						
								<input type="hidden" name="validation[]" value="<?php echo $file_type_find; ?>" class="file_types_value"> 
								<label class=" col-lg-2 col-md-2 col-sm-2 col-xs-12  control-label" for="case_link"><?php esc_html_e('File Types (like png,jpg,pdf,doc)','lawyer_mgt');?><span class="require-field">*</span></label>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
									<input class="form-control file_types_input validate[required]" maxlength="100" type="text" id="userinput11" value="<?php echo esc_attr($file_type_value); ?>">
								</div>
							 
								<input type="hidden" name="validation[]" value="" class="file_size_value">
								<label class=" col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('File Upload Size(kb)','lawyer_mgt');?><span class="require-field">*</span></label>	
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">	
									<input class="form-control file_size_input validate[required]" maxlength="30" type="text" id="userinput9" >
								</div>
						</div>
					</div>
					<div class="form-group">
						<div id="min_limit" class="display_none_css">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Minimum Limit','lawyer_mgt');?><span class="require-field">*</span></label>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
								<input type="number" class="form-control validate[required]"  id="min" >
							</div>
						</div>
						<div id="max_limit" class="display_none_css">
							<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Maximum Limit','lawyer_mgt');?><span class="require-field">*</span></label>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
								<input type="number" class="form-control validate[required]"  id="max" >
							</div>
						</div>
					</div>
					<?php
				}
				?>							
			
			<div class="form-group">
				<div class="col-md-12 margin_top_20px_css">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Visibility','lawyer_mgt');?><span class="require-field">*</span></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback margin_top_custome5">
						<input type="checkbox"  value="1" <?php if($edit){  echo checked($custom_field_data->field_visibility,'1'); }else{  echo 'checked'; } ?> class="custom-control-input hideattar" name="field_visibility" >
						<label class="custom-control-label margin_bottom_5_px_css"  for="colorCheck1"><?php esc_html_e('Yes','lawyer_mgt'); ?></label>
					</div>
				</div>		 
			</div>		 
		 
		 <div class="form-group margin_top_div_css1">
			<div class="offset-sm-2 col-sm-8">
			  <input type="submit"  name="add_custom_field" class="btn btn-success" value="<?php  esc_attr_e('Submit','lawyer_mgt');?>"></input>
			</div>
		</div>
						 
	</form>	
</div><!-- END PANEL BODY DIV  -->	
<script type="text/javascript">
var $ = jQuery.noConflict();
jQuery(document).ready(function ($) 
{
	"use strict";
	<!-- Make checked required or validation code start -->
	$(".required_rule").on('change', function (event) 
	{
		$('.nullable_rule').iCheck('uncheck');
	});

	$(".nullable_rule").on('change', function (event) 
	{
		$('.required_rule').iCheck('uncheck');
	});

	$(".nullable_rule").on('ifUnchecked', function (event) 
	{
		$('.required_rule').iCheck('check');
	});

	$(".required_rule").on('ifUnchecked', function (event) 
	{
		$('.nullable_rule').iCheck('check');
	});

	$(".only_number").on('change', function (event) 
	{
		if ($("input#only_number_id").is(':checked')) { 
		
			$('.only_char,.char_space,.char_num,.email,.url,.date').iCheck('disable');
			$('.only_char,.char_space,.char_num,.email,.url,.date').iCheck('uncheck');
			$('.only_char,.char_space,.char_num,.email,.url,.date').attr('disabled', true);
		}
		else{
			$('.only_char,.char_space,.char_num,.email,.url,.date').iCheck('enable');
			$('.only_char,.char_space,.char_num,.email,.url,.date').attr('disabled', false);
		}
	});

	$(".only_char").on('change', function (event)
	{
		if ($("input#only_char_id").is(':checked')) {
			$('.only_number,.char_space,.char_num,.email,.url,.date').iCheck('disable');
			$('.only_number,.char_space,.char_num,.email,.url,.date').iCheck('uncheck');
			$('.only_number,.char_space,.char_num,.email,.url,.date').attr('disabled', true);
		}
		else{
			
			$('.only_number,.char_space,.char_num,.email,.url,.date').iCheck('enable');
			$('.only_number,.char_space,.char_num,.email,.url,.date').attr('disabled', false);
		}
	});

	$(".char_num").on('change', function (event) 
	{
		if ($("input#char_num_id").is(':checked')) {
			$('.only_char,.only_number,.char_space,.email,.url,.date').iCheck('disable');
			$('.only_char,.only_number,.char_space,.email,.url,.date').iCheck('uncheck');
			$('.only_char,.only_number,.char_space,.email,.url,.date').attr('disabled', true);
		}
		else{
			$('.only_char,.only_number,.char_space,.char_num,.email,.url,.date').iCheck('enable');
			$('.only_char,.only_number,.char_space,.char_num,.email,.url,.date').attr('disabled', false);
		}
	});
	

	$(".char_space").on('change', function (event)
	{
		if ($("input#char_space_id").is(':checked')) {
			$('.only_char,.only_number,.char_num,.email,.url,.date').iCheck('disable');
			$('.only_char,.only_number,.char_num,.email,.url,.date').iCheck('uncheck');
			$('.only_char,.only_number,.char_num,.email,.url,.date').attr('disabled', true);
		}
		else{
			$('.only_char,.only_number,.char_num,.email,.url,.date').iCheck('enable');
			$('.only_char,.only_number,.char_num,.email,.url,.date').attr('disabled', false);
		}
	});

	$(".email").on('change', function (event) 
	{
		if ($("input#email_id").is(':checked')) {
			$('.only_char,.only_number,.char_num,.char_space,.url,.date').iCheck('disable');
			$('.only_char,.only_number,.char_num,.char_space,.url,.date').iCheck('uncheck');
			$('.only_char,.only_number,.char_num,.char_space,.url,.date').attr('disabled', true);
		}
		else{
			$('.only_char,.only_number,.char_num,.char_space,.url,.date').iCheck('enable');
			$('.only_char,.only_number,.char_num,.char_space,.url,.date').attr('disabled', false);
		}
	});

	$(".url").on('change', function (event) 
	{
		if ($("input#url_id").is(':checked')) {
			$('.only_char,.only_number,.char_num,.char_space,.email,.date').iCheck('disable');
			$('.only_char,.only_number,.char_num,.char_space,.email,.date').iCheck('uncheck');
			$('.only_char,.only_number,.char_num,.char_space,.email,.date').attr('disabled', true);
		}
		else{
			$('.only_char,.only_number,.char_num,.char_space,.email,.date').iCheck('enable');
			$('.only_char,.only_number,.char_num,.char_space,.email,.date').attr('disabled', false);
		}
	});

	$(".date").on('change', function (event) 
	{
		if ($("input#date0").is(':checked')) 
		{
			$('.only_char,.only_number,.char_num,.char_space,.email,.url,.min,.max').iCheck('disable');
			$('.only_char,.only_number,.char_num,.char_space,.email,.url,.min,.max').iCheck('uncheck');
			$('.only_char,.only_number,.char_num,.char_space,.email,.url,.min,.max').attr('disabled', true);

			$.each($('.date'), function (key, value) 
			{
				$('#date' + key).iCheck('disable');
				$('#date' + key).attr('disabled', true);
			});
			$(this).iCheck('enable');
			$(this).attr('disabled', false);
		}
		else if ($("input#date1").is(':checked')) 
		{
			$('.only_char,.only_number,.char_num,.char_space,.email,.url,.min,.max').iCheck('disable');
			$('.only_char,.only_number,.char_num,.char_space,.email,.url,.min,.max').iCheck('uncheck');
			$('.only_char,.only_number,.char_num,.char_space,.email,.url,.min,.max').attr('disabled', true);

			$.each($('.date'), function (key, value) 
			{
				$('#date' + key).iCheck('disable');
				$('#date' + key).attr('disabled', true);
			});
			$(this).iCheck('enable');
			$(this).attr('disabled', false);
		}
		else if ($("input#date2").is(':checked')) 
		{
			$('.only_char,.only_number,.char_num,.char_space,.email,.url,.min,.max').iCheck('disable');
			$('.only_char,.only_number,.char_num,.char_space,.email,.url,.min,.max').iCheck('uncheck');
			$('.only_char,.only_number,.char_num,.char_space,.email,.url,.min,.max').attr('disabled', true);

			$.each($('.date'), function (key, value) 
			{
				$('#date' + key).iCheck('disable');
				$('#date' + key).attr('disabled', true);
			});
			$(this).iCheck('enable');
			$(this).attr('disabled', false);
		}
		else
		{
			$('.only_char,.only_number,.char_num,.char_num,.char_space,.email,.url,.min,.max').iCheck('uncheck');
			$('.only_char,.only_number,.char_num,.char_num,.char_space,.email,.url,.min,.max').attr('disabled', false);

			$.each($('.date'), function (key, value) 
			{
				$('#date' + key).iCheck('enable');
				$('#date' + key).attr('disabled', false);
			});
		}
	});

	 
	<!-- Make checked required or nullable code end -->

	$('body').on('change', '.dropdown_change', function () 
	{
		var dropdwon_data = $(".dropdown_change option:selected").val();
		
		if (dropdwon_data == 'text' || dropdwon_data == 'textarea') 
		{
			$('.date').iCheck('disable');
			$('.date').attr('disabled', true);
			$('.only_number,.only_char,.char_space,.char_num,.email,.max,.min,.url').iCheck('enable');
			$('.only_number,.only_char,.char_space,.char_num,.email,.max,.min,.url').attr('disabled', false);
			
			$('.file_type_and_size').fadeOut(1000);
			$('.radio_cat').fadeOut(1000);
			$('.checkbox_cat').fadeOut(1000);
			$('.sub_cat').fadeOut(1000);

		}
		else if (dropdwon_data == 'dropdown') 
		{
			$('.radio_cat').fadeOut(1000);
			$('.checkbox_cat').fadeOut(1000);
			$('.sub_cat').fadeIn(1000);

			$('.only_number,.only_char,.char_space,.char_num,.email,.max,.min,.url,.date').iCheck('disable');
			$('.only_number,.only_char,.char_space,.char_num,.email,.max,.min,.url,.date').attr('disabled', true);
			
			$('.file_type_and_size').fadeOut(1000);	
			$('#max_value').val('max');
			$('#max_limit').fadeOut(1000);
			$('#min_value').val('min');
			$('#min_limit').fadeOut(1000);
		}
		else if (dropdwon_data == 'checkbox') 
		{
			$('.only_number,.only_char,.char_space,.char_num,.email,.max,.min,.url,.date').iCheck('disable');
			$('.only_number,.only_char,.char_space,.char_num,.email,.max,.min,.url,.date').attr('disabled', true);
			
			$('.file_type_and_size').fadeOut(1000);
			$('.sub_cat').fadeOut(1000);
			$('.radio_cat').fadeOut(1000);
			$('.checkbox_cat').fadeIn(1000);
		}
		else if (dropdwon_data == 'radio') 
		{
			$('.only_number,.only_char,.char_space,.char_num,.email,.max,.min,.url,.date').iCheck('disable');
			$('.only_number,.only_char,.char_space,.char_num,.email,.max,.min,.url,.date').attr('disabled', true);
			
			$('.file_type_and_size').fadeOut(1000);
			$('.sub_cat').fadeOut(1000);
			$('.checkbox_cat').fadeOut(1000);
			$('.radio_cat').fadeIn(1000);
			$('#max_value').val('max');
			$('#max_limit').fadeOut(1000);
			$('#min_value').val('min');
			$('#min_limit').fadeOut(1000);

		}
		else if (dropdwon_data == 'date') 
		{

			$('.only_number,.only_char,.char_space,.char_num,.email,.max,.min,.url').iCheck('disable');
			$('.only_number,.only_char,.char_space,.char_num,.email,.max,.min,.url').attr('disabled', true);

			$('.date').iCheck('enable');
			$('.date').attr('disabled', false);
			$('.file_type_and_size').fadeOut(1000);
			$('.radio_cat').fadeOut(1000);
			$('.checkbox_cat').fadeOut(1000);
			$('.sub_cat').fadeOut(1000);
			$('#max_value').val('max');
			$('#max_limit').fadeOut(1000);
			$('#min_value').val('min');
			$('#min_limit').fadeOut(1000);
		}
		else if (dropdwon_data == 'file') 
		{

			$('.only_number,.only_char,.char_space,.char_num,.email,.max,.min,.url,.date').iCheck('disable');
			$('.only_number,.only_char,.char_space,.char_num,.email,.max,.min,.url,.date').attr('disabled', true);
			
			$('.file_type_and_size').fadeIn(1000);
			$('.radio_cat').fadeOut(1000);
			$('.checkbox_cat').fadeOut(1000);
			$('.sub_cat').fadeOut(1000);
			$('#max_value').val('max');
			$('.file_types_value').val('file_types');
			$('.file_size_value').val('file_upload_size');
			$('#max_limit').fadeOut(1000);
			$('#min_value').val('min');
			$('#min_limit').fadeOut(1000);
		}
		else 
		{
			$('.only_number,.only_char,.char_space,.char_num,.email,.max,.min,.url,.date').iCheck('disable');
			$('.only_number,.only_char,.char_space,.char_num,.email,.max,.min,.url,.date').attr('disabled', false);
			
			$('.file_type_and_size').fadeOut(1000);
			$('.radio_cat').fadeOut(1000);
			$('.checkbox_cat').fadeOut(1000);
			$('.sub_cat').fadeOut(1000);
			$('#max_value').val('max');
			$('#max_limit').fadeOut(1000);
			$('#min_value').val('min');
			$('#min_limit').fadeOut(1000);
		}
	});
	$('body').on('change', '#module_name', function () 
	{
		var module_name_data = $("#module_name option:selected").val();

		if (module_name_data == 'user') 
		{
			$('.role_div').fadeIn(1000);			
		}
		else
		{
			$('.role_div').fadeOut(1000);
		}	
	});			
});

// Add More Dropdown Label Code
jQuery(document).ready(function ($)
{
	"use strict";
	$('body').on('click', '.add_more', function () 
	{
		var text = $('.d_label').val();
		
		if(text.length>0){
			$('.drop_label').append('<div class="badge badge-danger label_data custom-margin" ><input type="hidden" value="' + text + '" name="d_label[]"><span>' + text + '</span><a href="#"><i class="fa fa-trash font-medium-2 delete_d_label" aria-hidden="true"></i></a></div> ');
			$('.d_label').val('');
		}
	});

	$('body').on('click', '.delete_d_label', function () 
	{
		$(this).parents('.label_data').remove();
	});
});

// Add More Checkbox Label Code

jQuery(document).ready(function ($)
{
	"use strict";
	$('body').on('click', '.add_more_checkbox', function () 
	{
		var text = $('.c_label').val();
		if(text.length>0){
			$('.checkbox_label').append('<div class="badge badge-warning label_checkbox custom-margin"  ><input type="hidden" value="' + text + '"  name="c_label[]"><span>' + text + '</span><a href="#"><i class="fa fa-trash font-medium-2 delete_c_label" aria-hidden="true"></i></a></div> ');
			$('.c_label').val('');
		}	
	});

	$('body').on('click', '.delete_c_label', function () 
	{
		$(this).parents('.label_checkbox').remove();
	});
});

// Add More Radio Label Code
jQuery(document).ready(function ($) 
{
	"use strict";
	$('body').on('click', '.add_more_radio', function ()
	{
		var text = $('.r_label').val();
		if(text.length>0)
		{
			$('.radio_label').append('<div class="badge badge-secondary label_radio custom-margin margin_right_3px_css"><input type="hidden" value="' + text + '"  name="r_label[]"><span>' + text + '</span><a href="#"><i class="fa fa-trash font-medium-2 delete_r_label" aria-hidden="true"></i></a></div>');
			$('.r_label').val('');
		}	
	});

	$('body').on('click', '.delete_r_label', function () 
	{
		$(this).parents('.label_radio').remove();
	});
});

// Max and Min Validation Code
jQuery(document).ready(function ($) 
{
	"use strict";
	//$(".opentext").on('change', function (event) 
	$('body').on('change', '.opentext', function ()
	{
		if ($(this).prop("checked") == true) 
		{
			var value_data = $(this).attr('value');

			if (value_data == 'max') 
			{
				$('#max_limit').fadeIn(1000);
			}
			else if (value_data == 'min') 
			{
				$('#min_limit').fadeIn(1000);
			}
		} 
		else
		{
			var value_data = $(this).attr('value');

			if (value_data == 'max') 
			{
				$('#max_limit').fadeOut(1000);
			}
			else if (value_data == 'min') 
			{
				$('#min_limit').fadeOut(1000);
			}
		}
	});
	
	$('body').on('keyup', '#max', function () 
	{
		var limit = 'max:' + $(this).val();
		$('#max_value').attr('value', limit);
	});

	$('body').on('keyup', '#min', function () 
	{
		var limit = 'min:' + $(this).val();
		$('#min_value').attr('value', limit);
	});
	
	$('body').on('keyup', '.file_types_input', function () 
	{
		var limit = 'file_types:' + $(this).val();
		$('.file_types_value').attr('value', limit);
	});
	
	$('body').on('keyup', '.file_size_input', function () 
	{
		var limit = 'file_upload_size:' + $(this).val();
		$('.file_size_value').attr('value', limit);
	});
});
</script>