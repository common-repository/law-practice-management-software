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
$court=new MJ_lawmgt_Court;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'courtlist');
$result=null;
?>
 <style>
	.dropdown-menu{
		z-index:998;
	}
	.popup-bg{
    background: rgba(0,0,0,0.50);
}
</style>
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV -->
	 
	 <?php 
	if(isset($_POST['save_court']))//save_court	
	{
		$nonce =  sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_court_nonce' ) )
		{ 
			if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='edit')
			{
				$result=$court->MJ_lawmgt_lmgt_add_court($_POST);
				if($result)
				{
					//wp_redirect (home_url().'?dashboard=user&page=court&tab=courtlist&message=2');
					$redirect_url=home_url().'?dashboard=user&page=court&tab=courtlist&message=2';
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
				$result=$court->MJ_lawmgt_lmgt_add_court($_POST);
				if($result)
				{
					//wp_redirect (home_url().'?dashboard=user&page=court&tab=courtlist&message=1');
					$redirect_url=home_url().'?dashboard=user&page=court&tab=courtlist&message=1';
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
	
	if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='delete')//DELETE Court
	{
		 
		$result=$court->MJ_lawmgt_delete_court(sanitize_text_field($_REQUEST['c_id']));
		if($result)
		{
			//wp_redirect (home_url().'?dashboard=user&page=court&tab=courtlist&message=3');
			$redirect_url=home_url().'?dashboard=user&page=court&tab=courtlist&message=3';
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
	if(isset($_POST['court_delete_selected']))
	{
		if (isset($_POST["selected_id"]))
		{	
	       $all = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ));
			foreach($all as $event_id)
			{		
				$record_id=$event_id;
				$result=$court->MJ_lawmgt_delete_selected_court($record_id);
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
			//wp_redirect (home_url().'?dashboard=user&page=court&tab=courtlist&message=3');
			$redirect_url=home_url().'?dashboard=user&page=court&tab=courtlist&message=3';
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
				<?php esc_html_e('Court Inserted Successfully','lawyer_mgt');?>
				</div>
				<?php 
			
		}
		elseif($message == 2)
		{?>
				<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
					<?php esc_html_e('Court Updated Successfully','lawyer_mgt');?>
				</div>
				<?php 			
		}
		elseif($message == 3) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
             <?php esc_html_e('Court Delete Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
	} 		
	?>
	
	<div id="main-wrapper">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<h2 class="nav-tab-wrapper margin_bottom">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="add_court">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'courtlist' ? 'active' : ''; ?> menucss">
									<a href="?dashboard=user&page=court&tab=courtlist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Court List', 'lawyer_mgt'); ?>
									</a>
								</li>
								<?php
								if($user_access['add']=='1')
									{
								?>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_court' ? 'active' : ''; ?> menucss">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
								{?>
								<a href="?dashboard=user&page=court&tab=add_court&action=edit&id=<?php echo esc_attr($_REQUEST['id']);?>">
									<?php esc_html_e('Edit Court', 'lawyer_mgt'); ?>
								</a>  
								<?php 
								}
								else
								{
									
										?>
										<a href="?dashboard=user&page=court&tab=add_court&&action=insert">
											<?php echo '<span class="fa fa-plus-circle"></span> '.esc_html__('Add Court', 'lawyer_mgt');?>
										</a>  
										<?php  
									
								}?>
								
								</li>
									<?php } ?>
							</ul>
						</h2>
						<?php
						if($active_tab == 'courtlist')
						{ ?>
							<script type="text/javascript">
								jQuery(document).ready(function($)
								{
									"use strict"; 
									jQuery('#court_list').DataTable({
										"responsive": true,
										"autoWidth": false,
										"order": [[ 1, "asc" ]],
										language:<?php echo wpnc_datatable_multi_language();?>,
										 "aoColumns":[								  
													  
												
												  {"bSortable": false},
												  
													  {"bSortable": true},
													  {"bSortable": true},
													
													  {"bSortable": true}	
													 <?php
												if($user_access['edit']=='1' || $user_access['delete']=='1')
												{
													?>
													,{"bSortable": false}
												  <?php
												}
												  ?>
												   ]		               		
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
								 
							</script>	
						
							<div class="tab-pane  tabs fade  active in" id="nav-open" role="tabpanel" aria-labelledby="nav-open-tab">
								<form name="court_form" action="" method="post">
									<div class="panel-body"> <!--PANEL BODY-->
										<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12"> <!--TABLE RESPONSIVE-->
											<table id="court_list" class="tast_list1 table table-striped table-bordered">
											<thead>
												<tr>
													<th><input type="checkbox" id="select_all"></th>
													<th><?php esc_html_e('Court Name', 'lawyer_mgt' ) ;?></th>
													<th><?php esc_html_e('State Name', 'lawyer_mgt' ) ;?></th>
													<th><?php esc_html_e('Bench Name', 'lawyer_mgt' ) ;?></th>
												<?php
												if($user_access['edit']=='1' || $user_access['delete']=='1')
												{
													?>
													<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
												<?php
												}
												?>
												</tr>
												<br/>
											</thead>
											 
											<tbody>
												<?php 
												if($user_access['own_data'] == '1')
												{
													$court_data=$court->MJ_lawmgt_get_all_own_court_data();
												}
												else
												{
													$court_data=$court->MJ_lawmgt_get_all_court_data();
												}													
												if(!empty($court_data))
												{
													foreach ($court_data as $retrieved_data)
													{
														?>
														<tr>														
															<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->c_id); ?>"></td>
															<td class="court">
															<?php $court_name = get_post($retrieved_data->court_id); echo esc_html($court_name->post_title);?></td>
															<td class="state"><?php $state_name=get_post($retrieved_data->state_id); echo esc_html($state_name->post_title);?></td>
															<td class="bench">
															<?php
															$bench_name=$retrieved_data->bench_id;
															 
															$contac_id=explode(',',$bench_name);
															$conatc_name=array();
															foreach($contac_id as $contact_name)
															{
																$user_data=get_post($contact_name);
															 
																$conatc_name[]=$user_data->post_title;
															}		
															echo esc_html(implode(',',$conatc_name));?></td>
															<?php
															if($user_access['edit']=='1' || $user_access['delete']=='1')
															{
																?>
																<td class="action">
																<?php
																if($user_access['edit']=='1')
																{
																	?>
																	<a href="?dashboard=user&page=court&tab=add_court&action=edit&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->c_id));?>" id='' class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
																<?php
																}
																if($user_access['delete']=='1')
																{
																	?>		
																	<a href="?dashboard=user&page=court&tab=courtlist&action=delete&c_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->c_id));?>" class="btn btn-danger" 
																	onclick="return confirm('<?php esc_attr_e('Are you sure you want to Delete this Court ?','lawyer_mgt');?>');">
																	<?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>
																<?php
																}
																?>
																</td>
																<?php
															}
																?>
														</tr>
													<?php 
													}
												}
												 ?>
											</tbody>
										</table>
										<?php 
										if($user_access['delete']=='1')
										{
											if(!empty($court_data))
											{
												?>
											<div class="form-group">		
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
													<input type="submit" class="btn delete_margin_bottom btn-danger" name="court_delete_selected" onclick="return confirm('<?php esc_attr_e('Are you sure you want to delete this record?','lawyer_mgt');?>');" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
												</div>
											</div>
										<?php }
										}		?>
								    </div><!--END TABLE RESPONSIVE-->
							    </div>   
						    </form>
							</div>							
						<?php 
						} 
						if($active_tab == 'add_court')
						{
							 
							$court=new MJ_lawmgt_Court;
							$data=null;	
							?>
							<!--Group POP up code -->
							  <div class="popup-bg">
								<div class="overlay-content">
									<div class="modal-content">
										<div class="category_list">
										</div>     
									</div>
								</div>     
							  </div>
							<script type="text/javascript">
	 
								jQuery(document).ready(function($)
								{
									"use strict"; 
									$('#court_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
								    $("#assigned_bench").multiselect({
										nonSelectedText :'<?php esc_html_e('Select Bench Name','lawyer_mgt');?>',
										numberDisplayed: 1,	
										selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
										includeSelectAllOption: true         
									});
									$("#submitcourt").on("click",function()
									{	
										var checked = $(".multiselect_validation .dropdown-menu input:checked").length;

										if(!checked)
										{
											alert("<?php esc_html_e('Please select atleast one Bench','lawyer_mgt');?>");
											return false;
										}			
									});	 	
								});
							</script>
								<?php 	
									$c_id=0;
									$edit=0;
									if(isset($_REQUEST['id']))
										$c_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id']));
										$court_data='';
										if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
										{					
											$edit=1;
											$court_data=$court->MJ_lawmgt_get_signle_court_by_id($c_id);
											 
										}?>
									<div class="panel-body"><!-- PANEL BODY DIV  -->
										<form name="court_form" action="" method="post" class="form-horizontal" id="court_form" enctype='multipart/form-data'>	
											<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
											<input id="action" class="form-control  text-input" type="hidden"  value="<?php echo esc_attr($action); ?>" name="action">
											<div class="header btn_margin">	
												<h3 class="first_hed"><?php esc_html_e('Court Information','lawyer_mgt');?></h3>
												<hr>
											</div>
											<!---COURT DETAIL---->
												<div class="form-group">
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="activity_category"><?php esc_html_e('Court Name','lawyer_mgt');?><span class="require-field">*</span></label>
													 
														<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
															<select class="form-control validate[required] court_category" name="court_id">
																<option value=""><?php esc_html_e('Select Court','lawyer_mgt');?></option>
																<?php 
																if($edit)
																{
																	$category =$court_data->court_id;
																}
																elseif(isset($_REQUEST['court_id']))
																{
																	$category =sanitize_text_field($_REQUEST['court_id']); 
																}									
																else 
																{
																	$category = "";
																}
																$activity_category=MJ_lawmgt_get_all_category('court_category');
																if(!empty($activity_category))
																{
																	foreach ($activity_category as $retrive_data)
																	{
																		echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected($category,$retrive_data->ID).'>'.esc_html($retrive_data->post_title).'</option>';
																	}
																} ?>
															</select>
														</div>					
														<div class="col-sm-2">
															<button id="addremove_cat" class="btn btn-success btn_margin" model="court_category"><?php esc_html_e('Add Or Remove','lawyer_mgt');?></button>
														</div>				
													<?php
													//}
													?>
												</div><!---COURT DETAIL END---->
											<!---State DETAIL---->
												<div class="form-group">
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="activity_category"><?php esc_html_e('State Name','lawyer_mgt');?><span class="require-field">*</span></label>
													 
														<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
															<select class="form-control validate[required] state_category" name="state_id">
																<option value=""><?php esc_html_e('Select State','lawyer_mgt');?></option>
																<?php 
																if($edit)
																	$category =$court_data->state_id;
																
																elseif(isset($_REQUEST['state_id']))
																	$category =sanitize_text_field($_REQUEST['state_id']);  
																else 
																	$category = "";
																
																$activity_category=MJ_lawmgt_get_all_category('state_category');
																if(!empty($activity_category))
																{
																	foreach ($activity_category as $retrive_data)
																	{
																		echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected($category,$retrive_data->ID).'>'.esc_html($retrive_data->post_title).'</option>';
																	}
																} ?>
															</select>
														</div>					
														<div class="col-sm-2">
															<button id="addremove_cat" class="btn btn-success btn_margin" model="state_category"><?php esc_html_e('Add Or Remove','lawyer_mgt');?></button>
														</div>				
													<?php
													//}
													?>
												</div><!---State DETAIL END---->
												<!---Bench DETAIL---->
												<div class="form-group">
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="activity_category"><?php esc_html_e('Bench Name','lawyer_mgt');?><span class="require-field">*</span></label>
													 
														<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 has-feedback multiselect_validation">
														<select class="form-control validate[required] bench_category" multiple="multiple" name="bench_id[]" id="assigned_bench">	
														<?php if($edit){ $data=$court_data->bench_id;}elseif(isset($_POST['bench_category'])){  $data=sanitize_text_field($_POST['bench_category']); } ?>
																<?php 
																$activity_category=MJ_lawmgt_get_all_category('bench_category');
																if(!empty($activity_category))
																{
																	foreach ($activity_category as $retrive_data)
																	{
																		?>
																		<option value="<?php print esc_attr($retrive_data->ID);?>" <?php echo in_array($retrive_data->ID,explode(',',$data)) ? 'selected': ''; ?>>
																		<?php echo esc_html($retrive_data->post_title); ?>
																		</option>
																	<?php 
																	}
																} ?>
														</select>
														</div>					
														<div class="col-sm-2">
															<button id="addremove_cat" class="btn btn-success btn_margin" model="bench_category"><?php esc_html_e('Add Or Remove','lawyer_mgt');?></button>
														</div>				
													<?php
													//}
													?>
												</div><!---Bench DETAIL END---->
												<div class="form-group">	
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for=""><?php esc_html_e('Court Details','lawyer_mgt');?></label>
													<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 has-feedback ">
														<textarea rows="3" class="validate[required,custom[address_description_validation],maxSize[150]] width_100_per_css"  name="court_details"  id="court_details" ><?php if($edit){ echo esc_textarea($court_data->court_details);}elseif(isset($_POST['court_details'])){ echo esc_textarea($_POST['court_details']); } ?></textarea>				
													</div>	
												</div>
												<?php wp_nonce_field( 'save_court_nonce' ); ?>
											   <div class="form-group margin_top_div_css1">
													<div class="offset-sm-2 col-sm-8">
														<input type="submit" id="submitcourt" name="save_court" class="btn btn-success" value="<?php if($edit){
														esc_attr_e('Save Court','lawyer_mgt');}else{ esc_attr_e('Add Court','lawyer_mgt');}?>"></input>
													</div>
												</div>
										</form>
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