<?php 
$obj_case=new MJ_lawmgt_case;	
$note=new MJ_lawmgt_Note;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'notelist');
$result=null;
?>
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV -->
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'lmgt_system_name' );?></h3>
	  </div>
	</div>
	<?php 
	if(isset($_POST['savenote']))
	{
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_note_nonce' ) )
		{ 
		   if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action']) == 'editnote')
			{
				 
				$result=$note->MJ_lawmgt_add_note($_POST);
				
				if($result)
				{
					//wp_redirect (admin_url().'admin.php?page=note&tab=notelist&message=2');
					$redirect_url=admin_url().'admin.php?page=note&tab=notelist&message=2';
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
					//wp_redirect (admin_url().'admin.php?page=note&tab=notelist&message=1');
					$redirect_url=admin_url().'admin.php?page=note&tab=notelist&message=1';
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
			//wp_redirect ( admin_url() . 'admin.php?page=note&tab=notelist&message=3');
			$redirect_url=admin_url().'admin.php?page=note&tab=notelist&message=3';
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
		if (isset($_REQUEST['selected_id']))
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
			//wp_redirect ( admin_url() . 'admin.php?page=note&tab=notelist&message=3');
			$redirect_url=admin_url().'admin.php?page=note&tab=notelist&message=3';
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
		$message = sanitize_text_field($_REQUEST['message']);
		if($message == 1)
		{?>	
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
	
	<div id="main-wrapper">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white">
					<div class="panel-body">
					   <h2 class="nav-tab-wrapper">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="add_event">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'notelist' ? 'active' : ''; ?> menucss">
									<a href="?page=note&tab=notelist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Note List', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_note' ? 'active' : ''; ?> menucss">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'editnote')
								{?>
								<a href="?page=note&tab=add_note&action=editnote&id=<?php echo esc_attr($_REQUEST['id']);?>">
									<?php esc_html_e('Edit Note', 'lawyer_mgt'); ?>
								</a>  
								<?php 
								}
								else
								{?>
									<a href="?page=note&tab=add_note">
										<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Note', 'lawyer_mgt');?>
									</a>  
								<?php  
								}?>
								</li>
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'viewnote')
								{?>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'viewnote' ? 'active' : ''; ?> menucss">
									<a href="?page=note&tab=viewnote&action=viewnote&note_id=<?php echo esc_attr($_REQUEST['note_id']);?>">
										<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('View Note', 'lawyer_mgt'); ?>
									</a>
								</li>
								<?php
								}
								?>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'noteactivity' ? 'active' : ''; ?> menucss">
									<a href="?page=note&tab=noteactivity">
										<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('Note Activity', 'lawyer_mgt'); ?>
									</a>
								</li>
							</ul>
					   </h2>
						<?php
						if($active_tab == 'notelist')
						{ ?>
							<script type="text/javascript">
							    var $ = jQuery.noConflict();
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
								jQuery(document).ready(function($) 
								{
									"use strict";
									jQuery('#note_list').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
								});
							</script>	
							<div class="tab-pane  tabs fade  active in" id="nav-open" role="tabpanel" aria-labelledby="nav-open-tab">
								<form name="" action="" method="post" enctype='multipart/form-data'>
									<div class="panel-body">
										<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">	
											<table id="note_list111" class="tast_list1 table table-striped table-bordered">
												<thead>	
													<?php  ?>
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
													$notedata=$note->MJ_lawmgt_get_all_note();
													if(!empty($notedata))
													{													
														foreach ($notedata as $retrieved_data)
														{
															$case_name=MJ_lawmgt_get_case_name_by_id($retrieved_data->case_id);
															 foreach($case_name as $case_name1)
															 {
																$case_name2= $case_name1->case_name;
															 }
															$user_id=$retrieved_data->assigned_to_user;
															$contac_id=explode(',',$user_id);
															$conatc_name=array();
															foreach($contac_id as $contact_name)
															{
																$userdata=get_userdata($contact_name);
																$conatc_name[]='<a href="?page=contacts&tab=viewcontact&action=view&contact_id='.MJ_lawmgt_id_encrypt(esc_attr($userdata->ID)).'">'.$userdata->display_name.'</a>';										   
															}
															$attorney=$retrieved_data->assign_to_attorney;
															$attorney_name=explode(',',$attorney);
															$attorney_name1=array();
															foreach($attorney_name as $attorney_name2) 
															{
																$attorneydata=get_userdata($attorney_name2);	
																	
																$attorney_name1[]='<a href="?page=attorney&tab=view_attorney&action=view&attorney_id='.MJ_lawmgt_id_encrypt(esc_attr($attorneydata->ID)).'">'.$attorneydata->display_name.'</a>';										   
															}															
															?>
															<tr> 
																<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->note_id); ?>"></td>
																<td class="email"><a href="?page=note&tab=viewnote&action=viewnote&note_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->note_id));?>"><?php echo esc_html($retrieved_data->note_name);?></a></td>
																<td class="case_link"><a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>"><?php echo esc_html($case_name2);?></a></td>
																<td class="added"><?php echo esc_html(get_the_title($retrieved_data->practice_area_id));?></td>	
																<td class="added"><?php echo implode(',',$conatc_name);?></td>
																<td class="added"><?php echo implode(',',$attorney_name1);?></td>
																<td class="added"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->date_time));?></td>						
																<td class="action"> 
																<a href="?page=note&tab=viewnote&action=viewnote&note_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->note_id));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>						 
																<a href="?page=note&tab=add_note&action=editnote&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->note_id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
																<a href="?page=note&tab=notelist&action=deletenote&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&note_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->note_id));?>" class="btn btn-danger" 
																	onclick="return confirm('<?php esc_html_e('Are you sure you want to Delete this Note ?','lawyer_mgt');?>');">
																  <?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>					
																</td>               
															</tr>
													<?php 
														} 			
													} ?>     
												</tbody>
											</table>
											<?php  
											if(!empty($notedata))
												{
											?>
											<div class="form-group">		
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
													<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="note_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
												</div>
											</div>
												<?php  } ?>
										</div>
									</div>       
								</form>
							</div>
						<?php 
						} 
						if($active_tab == 'add_note')
						{
							require_once LAWMS_PLUGIN_DIR. '/admin/notes/addnotes.php';
						}
						if($active_tab == 'viewnote')
						{
							require_once LAWMS_PLUGIN_DIR. '/admin/notes/view_notes.php';  
						}
						if($active_tab == 'noteactivity')
						{	
							require_once LAWMS_PLUGIN_DIR. '/admin/notes/note_activity.php';
						}	
						?>
					</div>
				</div>
			</div>
		</div>
	</div><!-- END  MAIN WRAPER  DIV -->
</div><!-- END  INNER PAGE  DIV -->