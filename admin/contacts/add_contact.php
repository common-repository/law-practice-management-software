<?php 
$role='client';
$obj_user=new MJ_lawmgt_Users;
?>
  <!--Group POP up code -->
  <div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="group_list">
			</div>     
		</div>
    </div>     
  </div>
 <!-- End Group POP-UP Code -->
 <!--Custom Field POP up code -->
   <div class="popup-bg1">
     <div class="overlay-content">
		<div class="modal-content">
			<div class="Customfield_list">
			</div>     
		</div>
     </div>     
   </div>
<!-- End Custom Field POP-UP Code -->
<script type="text/javascript">
   var $ = jQuery.noConflict();
	jQuery(document).ready(function($)
	{
		"use strict";
		$('#contact_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
		$('#birth_date').datepicker({
			  changeMonth: true,
				changeYear: true,
				yearRange:'-65:+0',
				endDate: '+0d',
				autoclose: true,
				onChangeMonthYear: function(year, month, inst) {
					$(this).val(month + "/" + year);
				}                   
		   });	
		 //user name not  allow space validation
		$('#username').keypress(function( e ) {
		   if(e.which === 32) 
			 return false;
		});	
	});
	function MJ_lawmgt_ValidateFax() 
	{
		"use strict";
		var regex = new RegExp("^\\+[0-9]{1,3}-[0-9]{3}-[0-9]{7}$");
		var fax = document.getElementById("fax").value;
		if (fax != '')
		{
			if (regex.test(fax))
			{
			} 
			else 
			{
				alert("<?php esc_html_e('Fax number is invalid','lawyer_mgt');?>");
				$('#fax').val('');
			}
		} 
	}
</script>
<?php 	
if($active_tab == 'add_contact')
{
	$contact_id=0;
	$edit=0;
	if(isset($_REQUEST['contact_id']))
		$contact_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['contact_id']));
	if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
	{
		$edit=1;
		$user_info = get_userdata($contact_id);	
	}
	?>	
    <div class="panel-body custom_field"><!-- PANEL BODY CUSTOM FIELD DIV   -->
        <form name="contact_form" action="" method="post" class="form-horizontal" id="contact_form" enctype='multipart/form-data'>	
			 <?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
			<input type="hidden" name="form_name"  id="form_name" value="contact">
			<input type="hidden" name="role" value="<?php echo esc_attr($role);?>"  />
			<input type="hidden" name="user_id" value="<?php echo esc_attr($contact_id);?>"  />
			<div class="header">	
				<h3 class="first_hed"><?php esc_html_e('Client Information','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label text_right" for="first_name"><?php esc_html_e('First Name','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="first_name" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter]],maxSize[50]] text-input"   type="text" placeholder="<?php esc_html_e('Enter First Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($user_info->first_name);}elseif(isset($_POST['first_name'])){ echo esc_attr($_POST['first_name']); } ?>" name="first_name">
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label text_right" for="middle_name"><?php esc_html_e('Middle Name','lawyer_mgt');?></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="middle_name" class="form-control has-feedback-left validate[custom[onlyLetter_specialcharacter]],maxSize[50]]" type="text"  placeholder="<?php esc_html_e('Enter Middle Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($user_info->middle_name);}elseif(isset($_POST['middle_name'])){ echo esc_attr($_POST['middle_name']); } ?>" name="middle_name">
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label text_right" for="last_name"><?php esc_html_e('Last Name','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="last_name" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter]],maxSize[50]] text-input"   type="text"   placeholder="<?php esc_html_e('Enter Last Name','lawyer_mgt');?>"value="<?php if($edit){ echo esc_attr($user_info->last_name);}elseif(isset($_POST['last_name'])){ echo esc_attr($_POST['last_name']); } ?>" name="last_name">
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label text_right" for="birth_date"><?php esc_html_e('Date of birth','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="birth_date" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="form-control has-feedback-left validate[required]" type="text"  name="birth_date"  placeholder="<?php esc_html_e('Select Birth Date','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($user_info->birth_date));}elseif(isset($_POST['birth_date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['birth_date'])); } ?>" readonly>
					<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
					<span id="inputSuccess2Status2" class="sr-only">(success)</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="gender"><?php esc_html_e('Gender','lawyer_mgt');?></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<?php $genderval = "male"; if($edit){ $genderval=esc_attr($user_info->gender); }elseif(isset($_POST['gender'])) {$genderval=esc_attr($_POST['gender']);}?>
					<label class="radio-inline">
					 <input type="radio" value="male" class="tog validate[required]" name="gender"  <?php  checked( 'male', $genderval);  ?>/><?php esc_html_e('Male','lawyer_mgt');?>
					</label>
					<label class="radio-inline">
					  <input type="radio"  value="female" class="tog validate[required]" name="gender"  <?php  checked( 'female', $genderval);  ?>/><?php esc_html_e('Female','lawyer_mgt');?> 
					</label>
				</div>
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="job_title"><?php esc_html_e('Job Title','lawyer_mgt');?></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="job_title" class="form-control has-feedback-left validate[custom[onlyLetter_specialcharacter]],maxSize[50]] text-input" type="text"   placeholder="<?php esc_html_e('Enter Job Title','lawyer_mgt');?>"value="<?php if($edit){ echo esc_attr($user_info->job_title);}elseif(isset($_POST['job_title'])) { echo esc_attr($_POST['job_title']); } ?>" name="job_title">
					<span class="fa fa-graduation-cap form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>
			<?php wp_nonce_field( 'save_contact_nonce' ); ?>
			<div class="form-group">
			
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="group"><?php esc_html_e('Group','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">			
					<select class="form-control validate[required]" name="group" id="group">
					<option value=""><?php esc_html_e('Select Group','lawyer_mgt');?></option>
					<?php 
					if($edit)

						$group =esc_attr($user_info->group);				
					$obj_group=new MJ_lawmgt_group;
					$result=$obj_group->MJ_lawmgt_get_all_group();	
					if(!empty($result))
					{
						foreach ($result as $retrive_data)
						{ 		 	
						?>
							<option value=" <?php echo esc_attr($retrive_data->ID);?> " <?php selected($group,esc_attr($retrive_data->ID));  ?>><?php echo esc_html($retrive_data->post_title); ?> </option>
						<?php 
						}
					} 
					?> 
					</select>				
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">	
					<button id="addremove" type="button" class="btn btn-success btn_margin" model="activity_group"><?php esc_html_e('Add Or Remove','lawyer_mgt');?></button>
				</div>	
			</div>
							<!-- Custom Fields Data -->	
							<script type="text/javascript">
							    var $ = jQuery.noConflict();
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
							
							$module='client';	
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
												$module_record_id=esc_attr($contact_id);
												
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
												   $min = esc_attr($value);
												   $limit_value_min = substr($min,4);
												}
												elseif(strpos($value, 'max') !== false)
												{
												   $max = esc_attr($value);
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
													$types = esc_attr($value);													
												   
													$file_types=substr($types,11);
												}
												elseif(strpos($value, 'file_upload_size') !== false)
												{	
													$size = esc_attr($value);
													$file_size=substr($size,17);
												}
											}
											$option =$custom_field_obj->MJ_lawmgt_getDropDownValue($custom_field->id);
											$data = 'custom.'.esc_attr($custom_field->id);
											$datas = 'custom.'.esc_attr($custom_field->id);											
											
											if($custom_field->field_type =='text')
											{
												?>	
												 
												<div class="form-group">	
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="<?php
													 echo esc_attr($custom_field->id); ?>"><?php echo ucwords(esc_html($custom_field->field_label)); ?><span class="required red"><?php echo esc_attr($red); ?></span></label>
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
															class="form-control hideattar<?php echo $custom_field->form_name; ?> validate[<?php if(!empty($required)){ echo $required; ?>,<?php } ?><?php if(!empty($limit_value_min)){ ?> minSize[<?php echo $limit_value_min; ?>],<?php } if(!empty($limit_value_max)){ ?> maxSize[<?php echo $limit_value_max; ?>],<?php } if($numeric != '' || $alpha != '' || $alpha_space != '' || $alpha_num != '' || $email != '' || $url != ''){ ?> custom[<?php echo $numeric; echo $alpha; echo $alpha_space; echo $alpha_num; echo $email; echo $url; ?>]<?php } ?>] <?php echo $space_validation; ?>" 
															name="custom[<?php echo $custom_field->id; ?>]" 
															id="<?php echo $custom_field->id; ?>"
															label="<?php echo $custom_field->field_label; ?>"
															><?php if($edit){ echo $custom_field_value; } ?></textarea>
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
														<?php if(!empty($required)){ ?> validate[<?php echo $required; ?>] <?php } ?>" name="custom[<?php echo $custom_field->id; ?>]"	id="<?php echo esc_attr($custom_field->id); ?>" label="<?php echo $custom_field->field_label; ?>"
														>
															<?php
															if(!empty($option))
															{															
																foreach ($option as $options)
																{
																	?>
																	<option value="<?php echo esc_attr($options->option_label); ?>" <?php if($edit){ echo selected($custom_field_value,esc_html($options->option_label)); } ?>> <?php echo ucwords(esc_html($options->option_label)); ?></option>
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
																		<input type="checkbox" value="<?php echo esc_attr($options->option_label); ?>"  <?php if($edit){  echo checked(in_array($options->option_label,$custom_field_value_array)); } ?> class="custom-control-input hideattar<?php echo esc_html($custom_field->form_name); ?>" name="custom[<?php echo esc_attr($custom_field->id); ?>][]" >
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
																	<input type="radio"  value="<?php echo esc_attr($options->option_label); ?>" <?php if($edit){ echo checked( $options->option_label, $custom_field_value); } ?> name="custom[<?php echo esc_attr($custom_field->id); ?>]"  class="custom-control-input hideattar<?php echo $custom_field->form_name; ?> error " id="<?php echo esc_attr($options->option_label); ?>">
																	
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
														<input type="file"  onchange="MJ_lawmgt_custom_filed_fileCheck(this);" Class="hideattar<?php echo $custom_field->form_name; if($edit){ if(!empty($required)){ if($custom_field_value==''){ ?> validate[<?php echo $required; ?>] <?php } } }else{ if(!empty($required)){ ?> validate[<?php echo $required; ?>] <?php } } ?>" name="custom_file[<?php echo $custom_field->id; ?>]" <?php if($edit){ ?> value="<?php echo $custom_field_value; ?>" <?php } ?> id="<?php echo $custom_field->id; ?>" file_types="<?php echo $file_types; ?>" file_size="<?php echo $file_size; ?>">
														<p><?php esc_html_e('Please upload only ','wpnc'); echo $file_types; esc_html_e(' file','wpnc');?> </p>
													</div>
														<input type="hidden" name="hidden_custom_file[<?php echo esc_attr-attr($custom_field->id); ?>]" value="<?php if($edit){ echo $custom_field_value; } ?>">
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
				<h3><?php esc_html_e('Address Information','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="address"><?php esc_html_e('Address','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="address" class="form-control has-feedback-left validate[required,custom[address_description_validation]],maxSize[150]]" type="text"   name="address"  placeholder="<?php esc_html_e('Enter Address','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_attr($user_info->address);}elseif(isset($_POST['address'])){ echo esc_attr($_POST['address']); } ?>">
					<span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
				</div>
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="state_name"><?php esc_html_e('State','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="state_name" class="form-control has-feedback-left validate[required,custom[city_state_country_validation]],maxSize[50]]"  type="text"  name="state_name" placeholder="<?php esc_html_e('Enter State Name','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_attr($user_info->state_name);}elseif(isset($_POST['state_name'])){ echo esc_attr($_POST['state_name']); }?>">
					<span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>	
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="city_name"><?php esc_html_e('City','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="city_name" class="form-control has-feedback-left validate[required,custom[city_state_country_validation]],maxSize[50]]"   type="text"  name="city_name"  placeholder="<?php esc_html_e('Enter City Name','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_attr($user_info->city_name);}elseif(isset($_POST['city_name'])) { echo esc_attr($_POST['city_name']); } ?>">
					<span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
				</div>
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="pin_code"><?php esc_html_e('Pin Code','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="pin_code" class="form-control has-feedback-left validate[required,custom[onlyLetterNumber],maxSize[15]]" type="text" name="pin_code"  placeholder="<?php esc_html_e('Enter Pin Code','lawyer_mgt');?>" 
					value="<?php if($edit){ echo esc_attr($user_info->pin_code);}elseif(isset($_POST['pin_code'])){ echo esc_attr($_POST['pin_code']); } ?>">
					<span class="fa fa-sort-numeric-down form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>		
			<div class="header">
				<h3><?php esc_html_e('Contact Information','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="mobile"><?php esc_html_e('Mobile Number','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
				
				<input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  class="form-control" name="phonecode">
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
					<input id="mobile" class="form-control has-feedback-left validate[required,custom[phone_number]] text-input" type="number" min="0" onKeyPress="if(this.value.length==15) return false;" placeholder="<?php esc_html_e('Enter Mobile Number','lawyer_mgt');?>" name="mobile" 
					value="<?php if($edit){ echo esc_attr($user_info->mobile);}elseif(isset($_POST['mobile'])){ echo esc_attr($_POST['mobile']); } ?>">
					<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
				</div>
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="phone"><?php esc_html_e('Alternate Mobile Number','lawyer_mgt');?></label>
				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
				
				<input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  class="form-control"  name="phonecode">
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
					<input id="Altrmobile" class="form-control has-feedback-left validate[custom[phone_number]] text-input" type="number" min="0" onKeyPress="if(this.value.length==15) return false;"  name="alternate_mobile" placeholder="<?php esc_html_e('Enter Alternate Mobile Number','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_attr($user_info->alternate_mobile);}elseif(isset($_POST['alternate_mobile'])){ echo esc_attr($_POST['alternate_mobile']); } ?>">
					<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>
			<div class="form-group">
			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="phone_home"><?php esc_html_e('Home Phone','lawyer_mgt');?></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="phone_home" class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]] text-input" type="number" min="0"    name="phone_home" placeholder="<?php esc_html_e('Enter Home Phone Number','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_attr($user_info->phone_home);}elseif(isset($_POST['phone_home'])){ echo esc_attr($_POST['phone_home']); } ?>">
					<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
				</div>			

			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="phone_work"><?php esc_html_e('Work Phone','lawyer_mgt');?></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="phone_work" class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]] text-input" type="number" min="0"  name="phone_work" placeholder="<?php esc_html_e('Enter Work Phone Number','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_attr($user_info->phone_work);}elseif(isset($_POST['phone_work'])){ echo esc_attr($_POST['phone_work']); } ?>">
					<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="fax"><?php esc_html_e('Fax','lawyer_mgt');?></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="fax" class="form-control has-feedback-left text-input" type="text"  onchange="MJ_lawmgt_ValidateFax()" name="fax"  placeholder="<?php esc_html_e('Enter Fax Number','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_attr($user_info->fax);}elseif(isset($_POST['fax'])) { echo esc_attr($_POST['fax']); } ?>">
					<span class="fa fa-fax form-control-feedback left" aria-hidden="true"></span>					
				</div>
			</div>
			<div class="form-group">
				<label class="offset-sm-2 col-sm-4" ><b><?php esc_html_e('Formate : ','lawyer_mgt');?></b><?php esc_html_e('+(country code)(area code)(fax number)','lawyer_mgt');?></label>
			</div>
			<div class="form-group">
				<label class="offset-sm-2 col-sm-4" ><b><?php esc_html_e('Ex : ','lawyer_mgt');?></b><?php esc_html_e('+1-212-9876543','lawyer_mgt');?></label>
			</div>
			<div class="header">	
				<h3><?php esc_html_e('Login Information','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="email"><?php esc_html_e('Email','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="email" class="form-control has-feedback-left validate[required,custom[email]] text-input" type="text" maxlength="50"  name="email" placeholder="<?php esc_html_e('Enter valid Email','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_attr($user_info->user_email);}elseif(isset($_POST['email'])){ echo esc_attr($_POST['email']); } ?>">
					<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
				</div>
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="username"><?php esc_html_e('Username','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="username" class="form-control has-feedback-left validate[required,custom[username_validation],maxSize[30]]]]" type="text"  name="username"  placeholder="<?php esc_html_e('Enter valid username','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_attr($user_info->user_login);}elseif(isset($_POST['username'])){ echo esc_attr($_POST['username']); } ?>" <?php if($edit) echo "readonly";?>>
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="password"><?php esc_html_e('Password','lawyer_mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input class="form-control has-feedback-left <?php if(!$edit){ echo 'validate[required,minSize[8]]'; }else{ echo 'validate[minSize[8]]'; }?>" type="password"   maxlength="12" name="password" placeholder="<?php esc_html_e('Enter valid Password','lawyer_mgt');?>" value="">
					<span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>
			<div class="header">	
				<h3><?php esc_html_e('Other Information','lawyer_mgt');?></h3>
				<hr>
			</div>
		
			<div class="form-group">
			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="license_number"><?php esc_html_e('License Number','lawyer_mgt');?></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="license_number" class="form-control has-feedback-left validate[custom[onlyLetterNumber]] text-input" maxlength="20" type="text"  name="license_number" placeholder="<?php esc_html_e('Enter License Number','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_attr($user_info->license_number);}elseif(isset($_POST['license_number'])){ echo esc_attr($_POST['license_number']); } ?>">
					<span class="fa fa-sort-numeric-down form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>
			<div class="form-group">
			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="website"><?php esc_html_e('Website','lawyer_mgt');?></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="website" class="form-control has-feedback-left validate[custom[url]] text-input" type="text"   placeholder="<?php esc_html_e('Enter Website','lawyer_mgt');?>"value="<?php if($edit){ echo esc_attr($user_info->website);}elseif(isset($_POST['website'])){ echo esc_attr($_POST['website']); } ?>" name="website">
					<span class="fab fa-google form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="photo"><?php esc_html_e('Image','lawyer_mgt');?></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input type="text" id="lmgt_user_avatar_url" class="form-control has-feedback-left" name="lmgt_user_avatar"  placeholder="<?php esc_html_e('Select image','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_url( $user_info->lmgt_user_avatar ); }elseif(isset($_POST['lmgt_user_avatar'])){ echo esc_url($_POST['lmgt_user_avatar']); } ?>" readonly />
					<span class="fa fa-image form-control-feedback left" aria-hidden="true"></span>
				</div>	
					<div class="col-sm-3">
						 <input id="upload_user_avatar_button" type="button" class="btnupload button btn_margin" value="<?php esc_html_e('Upload image', 'lawyer_mgt' ); ?>" />
						 <span class="description"><?php esc_html_e('Upload image', 'lawyer_mgt' ); ?></span>
				
				</div>
				<div class="clearfix"></div>
				
				<div class="upload_img offset-sm-2 col-sm-8">
						 <div id="upload_user_avatar_preview" >
							 <?php 
							if($edit) 
							{
								if($user_info->lmgt_user_avatar == "")
								{?>
									<img alt="" class="height_100px_width_100px"  src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
								<?php
								}
								else 
								{
								?>
									<img class="image_upload height_100px_width_100px" src="<?php if($edit)echo esc_url( $user_info->lmgt_user_avatar ); ?>" />
								<?php 
								}
							}
							 else 
							{
								?>
								<img alt="" class="height_100px_width_100px" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
								<?php 
							}
							?>
						</div>
			    </div>
			</div>	
			<?php wp_nonce_field( 'save_contact_nonce' ); ?>
			<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="description"><?php esc_html_e('Description','lawyer_mgt');?></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<textarea rows="3" class="validate[custom[address_description_validation]],maxSize[150]] width_414_px_resize_none_css" name="contact_description"   id="description"><?php if($edit){ echo esc_textarea($user_info->contact_description);}elseif(isset($_POST['contact_description'])){ echo esc_textarea($_POST['contact_description']); } ?></textarea>				
				</div>
			</div>					
			<div class="offset-sm-2 col-sm-8">
				<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Add Client','lawyer_mgt');}?>" name="save_contact" class="btn btn-success save_client_btn"/>
			</div>
        </form>
    </div>  <!-- END PANEL BODY CUSTOM FIELD DIV   -->    
<?php 
}
?>       