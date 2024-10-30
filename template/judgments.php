<?php 
MJ_lawmgt_browser_javascript_check();
//access right
$user_access=MJ_lawmgt_get_userrole_wise_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		MJ_lawmgt_access_right_page_not_access_message();
		die;
	}
	if(!empty($_REQUEST['action']))
	{
		if (isset ( $_REQUEST ['page'] ) && sanitize_text_field($_REQUEST ['page']) == $user_access['page_link'] && (sanitize_text_field($_REQUEST['action'])=='edit'))
		{
			if($user_access['edit']=='0')
			{	
				MJ_lawmgt_access_right_page_not_access_message();
				die;
			}			
		}
		if (isset ( $_REQUEST ['page'] ) && sanitize_text_field($_REQUEST ['page']) == $user_access['page_link'] && (sanitize_text_field($_REQUEST['action'])=='delete'))
		{
			if($user_access['delete']=='0')
			{	
				MJ_lawmgt_access_right_page_not_access_message();
				die;
			}	
		}
		if (isset ( $_REQUEST ['page'] ) && sanitize_text_field($_REQUEST ['page']) == $user_access['page_link'] && (sanitize_text_field($_REQUEST['action'])=='insert'))
		{
			if($user_access['add']=='0')
			{	
				MJ_lawmgt_access_right_page_not_access_message();
				die;
			}	
		} 
	}
}	
$obj_judgments=new MJ_lawmgt_Judgments;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'judgmentlist');
?>
<div class="page_inner_front"><!--  PAGE INNER DIV -->
	<?php
	if(isset($_POST['save_judgment']))
	{	
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_judgment_nonce' ) )
		{ 
			if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action']) == 'edit')
			{	
				if(isset($_FILES['judgement_documents']) && !empty($_FILES['judgement_documents']) && $_FILES['judgement_documents']['size'] !=0)
				{			
					if($_FILES['judgement_documents']['size'] > 0)
						$upload_docs=MJ_lawmgt_load_documets($_FILES['judgement_documents'],$_FILES['judgement_documents'],'judgement_documents');			
				}
				else
				{
					if(isset($_REQUEST['old_hidden_judgement_documents']))
					$upload_docs=sanitize_file_name($_REQUEST['old_hidden_judgement_documents']);				
				}
				$result=$obj_judgments->MJ_lawmgt_add_judgment($_POST,$upload_docs);
					
				if($result)
				{
					//wp_redirect (home_url().'?dashboard=user&page=judgments&tab=judgmentlist&message=2');
					$redirect_url=home_url().'?dashboard=user&page=judgments&tab=judgmentlist&message=2';
					if (!headers_sent())
					{
						header('Location: '.esc_url($redirect_url));
					}
					else 
					{
						echo '<script type="text/javascript">';
						echo 'window.location.href="'.esc_url($redirect_url).'";';
						echo '</script>';
					}
				}
			}
			else
			{
				if(isset($_FILES['judgement_documents']) && !empty($_FILES['judgement_documents']) && $_FILES['judgement_documents']['size'] !=0)
				{			
					if($_FILES['judgement_documents']['size'] > 0)
						$upload_docs=MJ_lawmgt_load_documets($_FILES['judgement_documents'],$_FILES['judgement_documents'],'judgement_documents');		
					
				}
				else
				{
					$upload_docs='';
				}
				$result=$obj_judgments->MJ_lawmgt_add_judgment($_POST,$upload_docs);
				
				if($result)
				{
					//wp_redirect (home_url().'?dashboard=user&page=judgments&tab=judgmentlist&message=1');
					$redirect_url=home_url().'?dashboard=user&page=judgments&tab=judgmentlist&message=1';
					if (!headers_sent())
					{
						header('Location: '.esc_url($redirect_url));
					}
					else 
					{
						echo '<script type="text/javascript">';
						echo 'window.location.href="'.esc_url($redirect_url).'";';
						echo '</script>';
					}
				}			
			}	
		}
	}	
	if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='delete')
	{	
		$result=$obj_judgments->MJ_lawmgt_delete_judgment(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['judgment_id'])));				
		if($result)
		{
		   //wp_redirect (home_url().'?dashboard=user&page=judgments&tab=judgmentlist&message=3');
			$redirect_url=home_url().'?dashboard=user&page=judgments&tab=judgmentlist&message=3';
			if (!headers_sent())
			{
				header('Location: '.esc_url($redirect_url));
			}
			else 
			{
				echo '<script type="text/javascript">';
				echo 'window.location.href="'.esc_url($redirect_url).'";';
				echo '</script>';
			}
		}
	}
	if(isset($_POST['judgments_delete_selected']))
	{
		if (isset($_POST["selected_id"]))
		{	
	        $all = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ));
			foreach($all as $event_id)
			{		
				$record_id=$event_id;
				$result=$obj_judgments->MJ_lawmgt_delete_selected_jugments($record_id);
				 
			}
		}
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
					<?php esc_html_e('Please Select At least One Record.','lawyer_mgt');?>
				</div>
		<?php		
		}	 
		if($result)
		{
			//wp_redirect (home_url().'?dashboard=user&page=judgments&tab=judgmentlist&message=3');
			$redirect_url=home_url().'?dashboard=user&page=judgments&tab=judgmentlist&message=3';
			if (!headers_sent())
			{
				header('Location: '.esc_url($redirect_url));
			}
			else 
			{
				echo '<script type="text/javascript">';
				echo 'window.location.href="'.esc_url($redirect_url).'";';
				echo '</script>';
			}
		}	
	}	
	if(isset($_REQUEST['message']))
	{
		$message =sanitize_text_field($_REQUEST['message']);
		if($message == 1)
		{?>	
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
			<?php esc_html_e('Judgment Inserted Successfully','lawyer_mgt');?>
			</div>
			<?php 
			
		}
		elseif($message == 2)
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<?php esc_html_e('Judgment Updated Successfully','lawyer_mgt');?>
			</div>
			<?php 			
		}
		elseif($message == 3) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
            <?php esc_html_e('Judgment Deleted Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
	} 
	?>
	<div id="main-wrapper"><!-- MAIN WRAPER  DIV -->
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<h2 class="nav-tab-wrapper margin_bottom_jugdment">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="tablist">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'judgmentlist' ? 'active' : ''; ?> menucss active_mt">
									<a href="?dashboard=user&page=judgments&tab=judgmentlist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Judgment List', 'lawyer_mgt'); ?>
									</a>
								</li>
								 							
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_judgment' ? 'active' : ''; ?> menucss tab_mt">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
								{?>
								<a href="?dashboard=user&page=judgments&tab=add_judgment&action=edit&id=<?php echo esc_attr($_REQUEST['id']);?> ">
									<?php esc_html_e('Edit Judgment', 'lawyer_mgt'); ?>
								</a>  
								<?php 
								}
								else
								{
									if($user_access['add']=='1')
									{
										?>
										<a href="?dashboard=user&page=judgments&tab=add_judgment&&action=insert">
											<?php echo '<span class="fa fa-plus-circle"></span> '.esc_html__('Add Judgment', 'lawyer_mgt');?>
										</a>  
										<?php
									}								
								}?>
								</li>
							 
							</ul>	
						</h2>
						<?php 	
						if($active_tab == 'judgmentlist')
						{ ?>	
							<script type="text/javascript">
								jQuery(document).ready(function($)
								{
									"use strict"; 
									jQuery('#attorney_list').DataTable({
										"responsive": true,
										"autoWidth": false,
										 "order": [[ 1, "asc" ]],
										 language:<?php echo wpnc_datatable_multi_language();?>,
										 "aoColumns":[
									
												  {"bSortable": false},
												 
												  {"bSortable": false},
												  {"bSortable": false},
												  {"bSortable": false},
												  {"bSortable": true},
												  {"bVisible": true},	
												  {"bVisible": true} <?php
												if($user_access['edit']=='1' || $user_access['delete']=='1')
												{
													?>
													,{"bSortable": false}
												  <?php
												}
												  ?>
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
								});
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
							</script>
							<form name="wcwm_report" action="" method="post">
								<div class="panel-body margin_panel_cases">
									<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">
										<table id="attorney_list" class="table table-striped table-bordered">
											<thead>
												<tr>
													<th><input type="checkbox" id="select_all"></th>
													<th><?php  esc_html_e('Date', 'lawyer_mgt' ) ;?></th>
													<th><?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Judge Name', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Judgments Details', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Judgments Document', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Laws Details', 'lawyer_mgt' ) ;?></th>
												<?php
												if($user_access['edit']=='1' || $user_access['delete']=='1')
												{	?>
													<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
												<?php } ?>
												</tr>
											</thead>
											<tbody>
											 <?php
											if($user_role == 'attorney')
											{
												if($user_access['own_data'] == '1')
												{
													$judgment_result=$obj_judgments->MJ_lawmgt_get_all_judgment_by_attorney(); 
												}
												else
												{
													$judgment_result=$obj_judgments->MJ_lawmgt_get_all_judgment();
												}													
											}
											elseif($user_role == 'client')
											{
												if($user_access['own_data'] == '1')
												{
													$judgment_result=$obj_judgments->MJ_lawmgt_get_all_judgment_by_client(); 	
												}
												else
												{
													$judgment_result=$obj_judgments->MJ_lawmgt_get_all_judgment();
												}	
											}
											else					
											{
												if($user_access['own_data'] == '1')
												{
													$judgment_result=$obj_judgments->MJ_lawmgt_get_all_own_judgment();
												}
												else
												{
													$judgment_result=$obj_judgments->MJ_lawmgt_get_all_judgment();
												}		
											}												 
											
											 if(!empty($judgment_result))
											 {
												foreach ($judgment_result as $retrieved_data)
												{
													$case_name=MJ_lawmgt_get_case_name_by_id($retrieved_data->case_id);
													foreach($case_name as $case_name1)
													{
														$case_name2=esc_html($case_name1->case_name);
													}	
													?>
												<tr>
												
													<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->id); ?>"></td>
													<td class=""><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->date)); ?></td>				
													<td class=""><?php echo esc_html($case_name2); ?></td>
													<td class=""><?php echo esc_html($retrieved_data->judge_name);?></td>
													<td class=""><?php echo esc_html($retrieved_data->judgments_details);?></td>
													<td class="added">
													<?php 
													$doc_data=json_decode($retrieved_data->judgments_document);
													if(!empty($doc_data[0]->value))
													{
														$doc_data=json_decode($retrieved_data->judgments_document);
																	 
														?><a target="blank" href="<?php print esc_url(content_url().'/uploads/document_upload/'.$doc_data[0]->value); ?>" class="status_read btn btn-default" record_id="<?php echo esc_attr($retrieved_data->id);?>"><i class="fa fa-download"></i><?php esc_html_e(' Download', 'lawyer_mgt');?></a><?php  
													}
													else
													{
														echo '<b class="desh" >'."-".'</b>';
													}
												?></td>
													<td class=""><?php 
													if(!empty($retrieved_data->judgments_law_details))
													{
													echo esc_html($retrieved_data->judgments_law_details);
													}
													else{
														echo '<b class="desh" >'."-".'</b>';
													}
													?></td>
													<?php
													if($user_access['edit']=='1' || $user_access['delete']=='1')
													{	?>
													<td class="action">		
														<?php
														if($user_access['edit']=='1')
														{
															?>
															<a href="?dashboard=user&page=judgments&tab=add_judgment&action=edit&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
														<?php
														}
														if($user_access['delete']=='1')
														{
															?>	
															<a href="?dashboard=user&page=judgments&tab=judgmentlist&&action=delete&judgment_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');">
															<?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>		
														<?php
														}
														?>		
													</td> 
													<?php 
													} ?>													
												</tr>
												<?php } 			
											}?>     
											</tbody>        
										</table>
									<?php 
									if($user_access['delete']=='1')
									{
										if(!empty($judgment_result))
										{
											?>
											<div class="form-group">		
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
													<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="judgments_delete_selected"  value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
												</div>
											</div>
											<?php 
										}
									}
									?>										
									</div>
								</div>       
							</form>
						<?php 
						}	
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
							<script type="text/javascript">
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
							<div class="panel-body"><!--PANEL BODY DIV   -->
								<form name="judgment_form" action="" method="post" class="form-horizontal" id="judgment_form" enctype='multipart/form-data'>	
									<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
									<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">		
									<input type="hidden" name="judgment_id" value="<?php echo esc_attr($judgment_id);?>"  />			
									<div class="form-group">				
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="date"><?php esc_html_e('Date','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
											<input id="date" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="form-control has-feedback-left validate[required]" type="text"  name="date"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>"
											value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($judgment_info->date));}elseif(isset($_POST['date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['date'])); } ?>">
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
												$case_name =$judgment_info->case_id;
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
													<option value="<?php echo esc_attr($retrive_data->id);?>" <?php selected($case_name,esc_attr($retrive_data->id));  ?>><?php echo esc_html($retrive_data->case_name); ?> </option>
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
											<input id="judge_name" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" placeholder="<?php esc_html_e('Enter Judge Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($judgment_info->judge_name);}elseif(isset($_POST['judge_name'])){ echo esc_attr($_POST['judge_name']); } ?>" name="judge_name">
											<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>	
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for=""><?php esc_html_e('Judgments Details','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
											<textarea rows="3" class="validate[required,custom[address_description_validation]] width_100_per" name="judgments_details" maxlength="150" placeholder="<?php esc_html_e('Enter Judgments Details','lawyer_mgt');?>" id="judgments_details"><?php if($edit){ echo esc_textarea($judgment_info->judgments_details);}elseif(isset($_POST['judgments_details'])){ echo esc_textarea($_POST['judgments_details']); } ?></textarea>				
										</div>		
									</div>
									<?php wp_nonce_field( 'save_judgment_nonce' ); ?>
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
														<a  target="blank" class="status_read btn btn-default" href="<?php print esc_url(content_url().'/uploads/document_upload/'.$doc_data[0]->value); ?>" record_id="<?php echo esc_attr($judgment_info->id);?>">
														<i class="fa fa-download"></i><?php echo esc_html($doc_data[0]->value);?></a>
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
											<textarea rows="3" class="validate[custom[address_description_validation]] width_100_per" name="judgments_law_details" maxlength="150" placeholder="<?php esc_html_e('Enter Laws Details','lawyer_mgt');?>" id="judgments_law_details"><?php if($edit){ echo esc_textarea($judgment_info->judgments_law_details);}elseif(isset($_POST['judgments_law_details'])){ echo esc_textarea($_POST['judgments_law_details']); } ?></textarea>				
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
					</div>			
				</div>
			</div>
		</div>
	</div> <!-- END MAIN WRAPER  DIV -->
</div><!--  END PAGE INNER DIV -->