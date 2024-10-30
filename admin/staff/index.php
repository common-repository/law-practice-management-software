<?php 	
$obj_user=new MJ_lawmgt_Users;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'stafflist');
$result=null;
?>
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV -->
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' ));?></h3>
	  </div>
	</div>
	<?php 
	if(isset($_POST['save_staff']))
	{
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_staff_nonce' ) )
		{ 
			if(isset($_FILES['staff_member_cv']) && !empty($_FILES['staff_member_cv']) && $_FILES['staff_member_cv']['size'] !=0)
			{
				if($_FILES['staff_member_cv']['size'] > 0)
					$cv=MJ_lawmgt_load_documets($_FILES['staff_member_cv'],$_FILES['staff_member_cv'],'CV');
			}
			else
			{
				if(isset($_REQUEST['hidden_cv']))
					$cv=sanitize_file_name($_REQUEST['hidden_cv']);
			}
			if(isset($_FILES['education_certificate']) && !empty($_FILES['education_certificate']) && $_FILES['education_certificate']['size'] !=0)
			{
				if($_FILES['education_certificate']['size'] > 0)
					$education_cert=MJ_lawmgt_load_documets($_FILES['education_certificate'],$_FILES['education_certificate'],'Edu');
			}
			else
			{
				if(isset($_REQUEST['hidden_education_certificate']))
					$education_cert=sanitize_file_name($_REQUEST['hidden_education_certificate']);
			}
			if(isset($_FILES['experience_cert']) && !empty($_FILES['experience_cert']) && $_FILES['experience_cert']['size'] !=0)
			{
				if($_FILES['experience_cert']['size'] > 0)
					$experience_cert=MJ_lawmgt_load_documets($_FILES['experience_cert'],$_FILES['experience_cert'],'Exp');
			}
			else
			{
				if(isset($_REQUEST['hidden_exp_certificate']))
					$experience_cert=sanitize_file_name($_REQUEST['hidden_exp_certificate']);
			}
			if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='edit')
			{	
				$result=$obj_user->MJ_lawmgt_add_user($_POST);
				$obj_user->MJ_lawmgt_staff_member_update_upload_documents($cv,$education_cert,$experience_cert,$result);			
				if($result)
				{
					//wp_redirect ( admin_url() . 'admin.php?page=staff&tab=stafflist&message=2');
					$redirect_url=admin_url().'admin.php?page=staff&tab=stafflist&message=2';
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
				if( !email_exists( sanitize_email($_POST['email']) ) && !username_exists( sanitize_user($_POST['username']))) {
		
					$result=$obj_user->MJ_lawmgt_add_user($_POST);
					$obj_user->MJ_lawmgt_staff_member_upload_documents($cv,$education_cert,$experience_cert,$result);
					if($result)
					{
						//wp_redirect ( admin_url() . 'admin.php?page=staff&tab=stafflist&message=1');
						$redirect_url=admin_url().'admin.php?page=staff&tab=stafflist&message=1';
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
				{?>
					<div class="alert_msg alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
						</button>
						<?php esc_html_e('Username Or Emailid All Ready Exist.','lawyer_mgt');?>
					</div>					
		  <?php }
			}
		}
	}	
	if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='delete')
	{		
		$result=$obj_user->MJ_lawmgt_delete_usedata(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['staff_id'])));
		$obj_user->MJ_lawmgt_staff_member_upload_documents($cv,$education_cert,$experience_cert,$result);
		if($result)
		{
			//wp_redirect ( admin_url() . 'admin.php?page=staff&tab=stafflist&message=3');
			$redirect_url=admin_url().'admin.php?page=staff&tab=stafflist&message=3';
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
	if(isset($_POST['user_delete_selected']))
	{
		if (isset($_REQUEST['selected_id']))
		{	
			$all = sanitize_text_field($_POST["selected_id"]);			
			$result=$obj_user->MJ_lawmgt_delete_selected_user($all);	
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
			//wp_redirect ( admin_url() . 'admin.php?page=staff&tab=stafflist&message=3');
			$redirect_url=admin_url().'admin.php?page=staff&tab=stafflist&message=3';
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
		$message =$_REQUEST['message'];
		if($message == 1)
		{?>
	
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
			<?php esc_html_e('User Inserted Successfully','lawyer_mgt');?>
			</div>
			<?php 
			
		}
		elseif($message == 2)
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<?php esc_html_e('User Updated Successfully','lawyer_mgt');?>
			</div>
				<?php 			
		}
		elseif($message == 3) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
		 <?php esc_html_e('User Deleted Successfully','lawyer_mgt');?>
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
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="tablist">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'stafflist' ? 'active' : ''; ?> menucss">
									<a href="?page=staff&tab=stafflist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Staff List', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_staff' ? 'active' : ''; ?> menucss">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
								{?>
								<a href="?page=staff&tab=add_staff&&action=edit&staff_id=<?php echo esc_attr($_REQUEST['staff_id']);?>">
									<?php esc_html_e('Edit Staff', 'lawyer_mgt'); ?>
								</a>  
								<?php 
								}
								else
								{?>
									<a href="?page=staff&tab=add_staff">
										<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Staff', 'lawyer_mgt');?>
									</a>  
								<?php  
								}?>
								</li>
								<?php
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
								{	
								?>	
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'view_staff' ? 'active' : ''; ?> menucss">
									<a href="?page=staff&tab=view_staff&action=view&staff_id=<?php echo esc_attr($_REQUEST['staff_id']);?>">
										<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('View Staff', 'lawyer_mgt'); ?>
									</a>
								</li>
								<?php
								}
								?>
							</ul>
						</h2>
						<?php 
						if($active_tab == 'stafflist')
						{ ?>	
							   <script type="text/javascript">
							    var $ = jQuery.noConflict();
								jQuery(document).ready(function($)
								{
									"use strict";
									jQuery('#staff_list').DataTable({
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
													  {"bVisible": true},	                 
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
							<form name="wcwm_report" action="" method="post">
								<div class="panel-body">
									<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">
										<table id="staff_list" class="table table-striped table-bordered">
											 <thead>
											<tr>
												<th><input type="checkbox" id="select_all"></th>
												<th><?php  esc_html_e('Photo', 'lawyer_mgt' ) ;?></th>
												<th><?php esc_html_e('staff Name', 'lawyer_mgt' ) ;?></th>
												<th> <?php esc_html_e('staff Email', 'lawyer_mgt' ) ;?></th>
												<th> <?php esc_html_e('Mobile Number', 'lawyer_mgt' ) ;?></th>
												<th> <?php esc_html_e('Degree', 'lawyer_mgt' ) ;?></th>
												<th> <?php esc_html_e('Experience(Years)', 'lawyer_mgt' ) ;?></th>
												<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
											</tr>
											</thead>
											<tbody>
												 <?php 
												// $get_staff = array('role' => 'staff_member');
												  $get_staff = array(
													'role' => 'staff_member',
													'meta_query' =>array( 
														array(
																'key' => 'deleted_status',
																'value' =>0,
																'compare' => '='
															)
														)	
													);	 
													$staffdata=get_users($get_staff); 
												 if(!empty($staffdata))
												 {
													foreach ($staffdata as $retrieved_data)
													{
													?>
														<tr>
															<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->ID); ?>"></td>				
															<td class="user_image"><?php $uid=$retrieved_data->ID;
																	$userimage=get_user_meta($uid, 'lmgt_user_avatar', true);
																if(empty($userimage))
																{
																	echo '<img src='.esc_url(get_option( 'lmgt_system_logo' )).' height="50px" width="50px" class="img-circle" />';
																}
																else
																	echo '<img src='.esc_url($userimage).' height="50px" width="50px" class="img-circle"/>';
															?></td>
															<td class="name"><a href="?page=staff&tab=view_staff&action=view&staff_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>"><?php echo esc_html($retrieved_data->display_name);?></a></td>				
															<td class="email"><?php echo esc_html($retrieved_data->user_email);?></td>
															<td class="mobile"><?php echo esc_html($retrieved_data->mobile);?></td>
															<td class="degree"><?php echo esc_html($retrieved_data->degree);?></td>
															<td class="experience"><?php echo esc_html($retrieved_data->experience);?></td>
															<td class="action">	
															<a href="?page=staff&tab=view_staff&action=view&staff_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
															<a href="?page=staff&tab=add_staff&action=edit&staff_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
															<a href="?page=staff&tab=stafflist&action=delete&staff_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>" class="btn btn-danger" 
															onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');">
															<?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>
																
															</td>														   
														</tr>
													<?php 
													} 												
												}?>										 
											</tbody>        
										</table>
										<?php if(!empty($staffdata))
											 {
												 ?>
										<div class="form-group">		
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
												<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="user_delete_selected"  value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
											</div>
										</div>
											 <?php }
												 ?>
									</div>
								</div>							   
							</form>
						<?php 
						}
						if($active_tab == 'add_staff')
						{
							require_once LAWMS_PLUGIN_DIR. '/admin/staff/add_staff.php';
						}
						if($active_tab == 'view_staff')
						{
							require_once LAWMS_PLUGIN_DIR. '/admin/staff/view_staff.php';
						}
						?>
					</div>			
				</div>
			</div>
		</div>
	</div><!-- END  MAIN WRAPER  DIV -->
</div><!-- END  INNER PAGE  DIV -->