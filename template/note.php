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
$note=new MJ_lawmgt_Note;
$obj_case=new MJ_lawmgt_case;
$result=null;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'notelist');
?>
<div class="page_inner_front"><!--  PAGE INNER DIV -->
	
	<?php 
	if(isset($_POST['savenote']))
	{
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_note_nonce' ) )
		{ 
			if($_POST['action']=='editnote')
			{
				$result=$note->MJ_lawmgt_add_note($_POST);
				if($result)
				{
					//wp_redirect (home_url().'?dashboard=user&page=note&tab=notelist&message=2');
					$redirect_url=home_url().'?dashboard=user&page=note&tab=notelist&message=2';
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
				$result=$note->MJ_lawmgt_add_note($_POST);
				if($result)
				{
					//wp_redirect (home_url().'?dashboard=user&page=note&tab=notelist&message=1');
                    $redirect_url=home_url().'?dashboard=user&page=note&tab=notelist&message=1';
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
	if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='deletenote')
	{		
		$result=$note->MJ_lawmgt_delete_note(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['note_id'])));
		
		if($result)
		{
			//wp_redirect (home_url().'?dashboard=user&page=note&tab=notelist&message=3');
			$redirect_url=home_url().'?dashboard=user&page=note&tab=notelist&message=3';
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
	if(isset($_POST['note_delete_selected']))
	{
		if (isset($_POST["selected_id"]))
		{	
	    $selected_id = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ) );
		$all = implode(",", $selected_id);
		$result=$note->MJ_lawmgt_delete_selected_note($all);	
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
			//wp_redirect (home_url().'?dashboard=user&page=note&tab=notelist&message=3');
			$redirect_url=home_url().'?dashboard=user&page=note&tab=notelist&message=3';
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
		{
		?>	
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
			<?php esc_html_e('Note Inserted Successfully','lawyer_mgt');?>
			</div>
		<?php 			
		}
		elseif($message == 2)
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<?php esc_html_e('Note Updated Successfully','lawyer_mgt');?>
			</div>
			<?php 			
		}
		elseif($message == 3) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Note Delete Successfully','lawyer_mgt');?>
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
						<h2 class="nav-tab-wrapper margin_bottom">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="add_event">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'notelist' ? 'active' : ''; ?> menucss active_mt">
									<a href="?dashboard=user&page=note&tab=notelist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Note List', 'lawyer_mgt'); ?>
									</a>
								</li>
								
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_note' ? 'active' : ''; ?> menucss">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'editnote')
								{?>
								<a href="?dashboard=user&page=note&tab=add_note&action=editnote&id=<?php echo esc_attr($_REQUEST['id']);?>">
									<?php esc_html_e('Edit Note', 'lawyer_mgt'); ?>
								</a>  
								<?php 
								}
								else
								{
									if($user_access['add']=='1')
									{
										?>
										<a href="?dashboard=user&page=note&tab=add_note&&action=insert">
											<?php echo '<span class="fa fa-plus-circle"></span> '.esc_html__('Add Note', 'lawyer_mgt');?>
										</a>  
										<?php  
									}
								}
								?>
								</li>
								<?php 
									
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'viewnote')
								{?>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'viewnote' ? 'active' : ''; ?> menucss">
									<a href="?dashboard=user&page=note&tab=viewnote&action=viewnote&note_id=<?php echo esc_attr($_REQUEST['note_id']);?>">
										<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('View Note', 'lawyer_mgt'); ?>
									</a>
								</li>
								<?php
								}
								?>
							</ul>
						</h2>
						<?php
						if($active_tab == 'notelist')
						{ ?>
							<script type="text/javascript">
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
											else
											{
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
									jQuery('#note_list').validationEngine();
								});
							</script>	
							<div class="tab-pane  tabs fade  active in" id="nav-open" role="tabpanel" aria-labelledby="nav-open-tab"><!-- TAB-PAN  DIV -->
								<form name="note_list" action="" method="post" enctype='multipart/form-data'>
									<div class="panel-body margin_task">
										<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">	
											<table id="note_list111" class="tast_list1 table table-striped table-bordered">
												<thead>	
													<?php 
													if($user_role == 'attorney')
													{
														if($user_access['own_data'] == '1')
														{
															$notedata=$note->MJ_lawmgt_get_all_note_by_attorney(); 
														}
														else			
														{
															$notedata=$note->MJ_lawmgt_get_all_note(); 
														}	
													}
													elseif($user_role == 'client')
													{
														if($user_access['own_data'] == '1')
														{
															$notedata=$note->MJ_lawmgt_get_all_note_by_client(); 
														}
														else			
														{
															$notedata=$note->MJ_lawmgt_get_all_note(); 
														}
													}
													else			
													{
														if($user_access['own_data'] == '1')
														{
															$notedata=$note->MJ_lawmgt_get_all_note_created_by(); 
														}
														else
														{
															$notedata=$note->MJ_lawmgt_get_all_note(); 
														}
													}	
														?>
													<tr>
														<th><input type="checkbox" id="select_all"></th>
														<th><?php  esc_html_e('Note Name', 'lawyer_mgt' ) ;?></th>
														<th><?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
														<th><?php esc_html_e('Practice Area', 'lawyer_mgt' ) ;?></th>
														<th> <?php esc_html_e('Client Name', 'lawyer_mgt' ) ;?></th>
														<th> <?php esc_html_e('Attorney Name', 'lawyer_mgt' ) ;?></th>
														<th> <?php esc_html_e('Date', 'lawyer_mgt' ) ;?></th>
														<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
													</tr>
													<br/>
												</thead>
												<tbody>
													<?php
													if(!empty($notedata))
													{													
														foreach ($notedata as $retrieved_data)
														{
															$case_name=MJ_lawmgt_get_case_name_by_id($retrieved_data->case_id);
															foreach($case_name as $case_name1)
															{
																$case_name2=esc_html($case_name1->case_name);
															}
														
															$user_id=$retrieved_data->assigned_to_user;
															$contac_id=explode(',',$user_id);
															$conatc_name=array();
															foreach($contac_id as $contact_name) 
															{															
																$userdata=get_userdata($contact_name);
																$conatc_name[]=esc_html($userdata->display_name);											   
															}
															$attorney=$retrieved_data->assign_to_attorney;
															$attorney_name=explode(',',$attorney);
															$attorney_name1=array();
															foreach($attorney_name as $attorney_name2) 
															{
																$attorneydata=get_userdata($attorney_name2);	
																$attorney_name1[]=esc_html($attorneydata->display_name);										   
															}
															?>
															<tr> 
																<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->note_id); ?>"></td>									
																<td class="email"><a href="?dashboard=user&page=note&tab=viewnote&action=viewnote&note_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->note_id));?>"><?php echo esc_html($retrieved_data->note_name);?></a></td>
																<td class="prac_area"><a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>"><?php echo esc_html($case_name2); ?></a></td>							
																<td class="added"><?php echo esc_html(get_the_title($retrieved_data->practice_area_id));?></td>	
																
																<td class="added"><?php echo esc_html(implode(',',$conatc_name));?></td>
																<td class="added"><?php echo implode(',',$attorney_name1);?></td>					
																<td class="added"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->date_time)); ?></td>						
																 <td class="action"> 
																	<a href="?dashboard=user&page=note&tab=viewnote&action=viewnote&note_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->note_id));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>						 
																	<?php
																	if($user_access['edit']=='1')
																	{
																	?>	 
																		<a href="?dashboard=user&page=note&tab=add_note&action=editnote&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->note_id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
																	<?php
																	}
																	if($user_access['delete']=='1')
																	{
																		?>
																		<a href="?dashboard=user&page=note&tab=notelist&action=deletenote&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&note_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->note_id));?>" class="btn btn-danger" 
																			onclick="return confirm('<?php esc_html_e('Are you sure you want to Delete this Note ?','lawyer_mgt');?>');">
																		  <?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>					
																	<?php
																	}
																	?>
																  </td>               
															</tr>
												<?php 	} 			
													} ?>     
												</tbody>
											</table>
												<?php
												if($user_access['delete']=='1')
												{
													if(!empty($notedata))
													{
													?>
														<div class="form-group">		
															<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
																<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="note_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
															</div>
														</div>
													<?php
													}
												}
												?>
										</div>
									</div>       
								</form>
							</div> <!-- END TAB-PAN DIV -->
						<?php 
						} 
						if($active_tab == 'add_note')
						{
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
								  $("#assigned_to_user").multiselect({
										enableFiltering: true,
										enableCaseInsensitiveFiltering: true,
										nonSelectedText :'<?php esc_html_e('Select Client Name','lawyer_mgt');?>',
										minSelectedItems: 1,
										selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',										
										includeSelectAllOption: true         
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
									$("#assign_to_attorney").multiselect({ 
										enableFiltering: true,
										enableCaseInsensitiveFiltering: true,
										 nonSelectedText :'<?php esc_html_e('Select Attorney Name','lawyer_mgt');?>',
										  selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
										 includeSelectAllOption: true         
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
							<div class="panel-body "> <!-- PANEL BODY DIV  -->
								<form name="note_form" action="" method="post" class="form-horizontal" id="note_form" enctype='multipart/form-data'>	
									<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
									<input id="action" class="form-control  text-input" type="hidden"  value="<?php echo esc_attr($action); ?>" name="action">
									<input id="action1" class="form-control  text-input" type="hidden"  value="<?php if($edt) { echo 'editnote'; }?>" name="action1">
									<div class="header margin_task_to_template">	
										<h3 class="first_hed"><?php esc_html_e('Linked To','lawyer_mgt');?></h3>
										<hr>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Case Name','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<?php 		
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
													?>
													<?php if($edt){ $data=$casedata->case_id;}else{ $data=''; }?>
												<select class="form-control validate[required] case_id" name="case_id" id="case_id">				
													<option value=""><?php esc_html_e('Select Case Name','lawyer_mgt');?></option>
													<?php 
													foreach($result as $result1)
													{													
													  echo '<option value="'.esc_attr($result1->id).'" '.selected($data,$result1->id).'>'.esc_html($result1->case_name).'</option>';
													} ?>
												</select>
										</div>
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="practice_area_id"><?php esc_html_e('Practice Area','lawyer_mgt');?></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback practics" >
											<input type="hidden" class="form-control" value="<?php if($edt){ echo esc_attr($casedata->practice_area_id);}?>" name="practice_area_id" id="practice_area_id" readonly />
												<input type="text" class="form-control" value="<?php if($edt){ echo esc_attr(get_the_title($casedata->practice_area_id)); }?>" name="practice_area_id1" id="practice_area_id1" readonly />
										</div>										
									</div>
									<div class="form-group">
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="assigned_to_user"><?php esc_html_e('Client Name','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback multiselect_validation">
											<?php if($edt){ $data=$casedata->assigned_to_user;}elseif(isset($_POST['assigned_to_user'])){ $data=sanitize_text_field($_POST['assigned_to_user']); } ?>
												<?php $conats=explode(',',$data);
												
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
														$user_name=esc_html($userdata->display_name);		
													?>
														<option value="<?php print esc_attr($Editdata1->user_id);?>" <?php echo in_array($Editdata1->user_id,explode(',',$data)) ? 'selected': ''; ?>>
															<?php echo esc_html($user_name);?>
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
														$user_name=esc_html($user_details->display_name);	
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
											<input id="note_name" class="form-control  validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input "  type="text" placeholder="<?php esc_html_e('Enter Note Name','lawyer_mgt');?>" value="<?php if($edt){ echo esc_attr($casedata->note_name);}elseif(isset($_POST['note_name'])){ echo esc_attr($_POST['note_name']); } ?>" name="note_name">
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
									<?php wp_nonce_field( 'save_note_nonce' ); ?>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="date_time"><?php esc_html_e('Date','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="date_time" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date1 form-control validate[required]  has-feedback-left " type="text"  name="date_time"  placeholder=""
												value="<?php if($edt){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($casedata->date_time)); }else{ echo  date("Y/m/d");}?>" readonly>
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
							</div> <!-- END PANEL BODY DIV  -->
						<?php 	 
						}
						if($active_tab == 'viewnote')
						{
							$note=new MJ_lawmgt_Note;
							if(isset($_REQUEST['note_id']))
								$note_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['note_id']));
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'viewnote')
								{	
									$casedata=$note->MJ_lawmgt_get_signle_note_by_id($note_id);
								} 
								?>		
							<div class="panel-body panel_body_flot_css"><!-- PANEL BODY DIV  -->
								<div class="header margin_task_to_template">	
									<h3 class="first_hed"><?php esc_html_e('Linked To','lawyer_mgt');?></h3>
									<hr>
								</div>
								<div class="viewtaskdetails">				
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 task_detail_div">							
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
											<div class="table_row">
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
													<?php esc_html_e('Case Name','lawyer_mgt'); ?>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
													<span class="txt_color">
													<?php
														$case_link=MJ_lawmgt_get_case_name($casedata->case_id);
														echo esc_html($case_link);
														?>
													</span>
												</div>
											</div>
											<div class="table_row">
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
													<?php esc_html_e('Practice Area','lawyer_mgt'); ?>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
													<span class="txt_color">
													<?php
														 echo esc_html(get_the_title(esc_html($casedata->practice_area_id)));
														?>
													</span>
												</div>
											</div>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
											<div class="table_row">
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
													<?php esc_html_e('Client Name','lawyer_mgt'); ?>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
													<span class="txt_color">
												<?php
														$user=explode(",",$casedata->assigned_to_user);
														$user_name=array();
														if(!empty($user))
														{						
															foreach($user as $data)
															{
																$user_name[]=MJ_lawmgt_get_display_name($data);
															}
														}			
														 echo esc_html(implode(",",$user_name));
														?>
													</span>
												</div>
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
													<?php esc_html_e('Attorney Name','lawyer_mgt'); ?>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
													<span class="txt_color">
													<?php
														$user=explode(",",$casedata->assign_to_attorney);
														$user_name=array();
														if(!empty($user))
														{						
															foreach($user as $data)
															{
																$user_name[]=MJ_lawmgt_get_display_name($data);
															}
														}			
														 echo esc_html(implode(",",$user_name));
														?>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="header">	
										<h3 class="first_hed"><?php esc_html_e('Note Information','lawyer_mgt');?></h3>
										<hr>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 task_detail_div">							
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
											<div class="table_row">
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
													<?php esc_html_e('Note Name','lawyer_mgt'); ?>
												</div>
												<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12  table_td">
													<span class="txt_color">
													<?php									
														 echo esc_html($casedata->note_name);
														?>
													</span>
												</div>
											</div>
											<div class="table_row">
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
													<?php esc_html_e('Note','lawyer_mgt'); ?>
												</div>
												<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12  table_td">
													<span class="txt_color">
													<?php
														if(!empty($casedata->note))
														{
															 echo esc_html($casedata->note);
														}
														else{
															echo "-";
														}
														?>
													</span>
												</div>
											</div>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
											<div class="table_row">
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
													<?php esc_html_e('Date','lawyer_mgt'); ?>
												</div>
												<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12  table_td">
													<span class="txt_color">
													<?php
														 echo esc_html(MJ_lawmgt_getdate_in_input_box($casedata->date_time));
														?>
													</span>
												</div>
											</div>
										</div>
									</div>	
								</div>
							</div><!-- END PANEL BODY DIV  -->
						<?php 
						}	 
						?>
					</div>
				</div>
			</div>
		</div>
	</div><!--END MAIN WRAPER  DIV -->
</div><!--  PAGE INNER DIV -->