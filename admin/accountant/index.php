<?php 	
$obj_user=new MJ_lawmgt_Users;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'accountantlist');
$result=null;
?>
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV --> 
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' ));?></h3>
	  </div>
	</div>
	<?php 
	//----- SAVE ACCOUNTANT ----//
	if(isset($_POST['save_accountant']))
	{
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_account_nonce' ) )
		{ 
			if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='edit')
			{	
				$result=$obj_user->MJ_lawmgt_add_user($_POST);
				if($result)
				{
					$url= esc_url(admin_url().'admin.php?page=accountant&tab=accountantlist&message=2');
					if (!headers_sent())
					{
						header('Location: '.esc_url($url));
					}
					else 
					{ 
						echo '<script type="text/javascript">';
						echo 'window.location.href="'.esc_url($url).'";';
						echo '</script>';
					}
				}
			}
			else
			{
				if( !email_exists( sanitize_email($_POST['email']) ) && !username_exists( sanitize_user($_POST['username']))) 
				{
					$result=$obj_user->MJ_lawmgt_add_user($_POST);
					if($result)
					{
						//wp_redirect ( admin_url() . 'admin.php?page=accountant&tab=accountantlist&message=1');
					    $url= esc_url(admin_url().'admin.php?page=accountant&tab=accountantlist&message=1');
						if (!headers_sent())
						{
							header('Location: '.esc_url($url));
						}
						else 
						{ 
							echo '<script type="text/javascript">';
							echo 'window.location.href="'.esc_url($url).'";';
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
	//----- DELETE ACCOUNTANT ----//
	if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='delete')
	{		
		$result=$obj_user->MJ_lawmgt_delete_usedata(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['accountant_id'])));
		if($result)
		{
			//wp_redirect ( admin_url() . 'admin.php?page=accountant&tab=accountantlist&message=3');
		    $url= esc_url(admin_url().'admin.php?page=accountant&tab=accountantlist&message=3');
			if (!headers_sent())
			{
				header('Location: '.esc_url($url));
			}
			else 
			{ 
				echo '<script type="text/javascript">';
				echo 'window.location.href="'.esc_url($url).'";';
				echo '</script>';
			}
		}
	}
	if(isset($_POST['user_delete_selected']))
	{
		if (isset($_REQUEST['selected_id']))
		{	
            $all = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ));			
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
			//wp_redirect ( admin_url() . 'admin.php?page=accountant&tab=accountantlist&message=3');
		    $url= esc_url(admin_url().'admin.php?page=accountant&tab=accountantlist&message=3');
			if (!headers_sent())
			{
				header('Location: '.esc_url($url));
			}
			else 
			{ 
				echo '<script type="text/javascript">';
				echo 'window.location.href="'.esc_url($url).'";';
				echo '</script>';
			}
		}	
	}
	if(isset($_REQUEST['message']))
	{
		$message =sanitize_text_field($_REQUEST['message']);
		if($message == 1)
		{  ?>	
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
	<div id="main-wrapper"><!--  MAIN WRAPER DIV   --> 
		<div class="row"><!--  ROW DIV   --> 
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white"><!-- PANEL WHITE  DIV -->
					<div class="panel-body"><!-- PANEL BODY  DIV -->
						<h2 class="nav-tab-wrapper">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="tablist">
								<li role="presentation" class="<?php echo $active_tab == 'accountantlist' ? 'active' : ''; ?> menucss">
									<a href="?page=accountant&tab=accountantlist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Accountant List', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo $active_tab == 'add_accountant' ? 'active' : ''; ?> menucss">
								<?php  
									if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
									{?>
										<a href="?page=accountant&tab=add_accountant&&action=edit&accountant_id=<?php echo sanitize_text_field($_REQUEST['accountant_id']);?>">
										<?php esc_html_e('Edit Accountant', 'lawyer_mgt'); ?>
										</a>  
									<?php 
									}
									else
									{?>
										<a href="?page=accountant&tab=add_accountant">
											<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Accountant', 'lawyer_mgt');?>
										</a>  
									<?php  
									}?>
								</li>
								<?php
								if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view')
								{	
								?>	
								<li role="presentation" class="<?php echo $active_tab == 'view_accountant' ? 'active' : ''; ?> menucss">
									<a href="?page=accountant&tab=view_accountant&action=view&accountant_id=<?php echo sanitize_text_field($_REQUEST['accountant_id']);?>">
									<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('View Accountant', 'lawyer_mgt'); ?>
									</a>
								</li>
								<?php
								}
								?>
							</ul>
						</h2>
						<?php 
						if($active_tab == 'accountantlist')
						{ ?>	
							<script type="text/javascript">
							    var $ = jQuery.noConflict();
								jQuery(document).ready(function($)
								{
									"use strict";
									jQuery('#accountant_list').DataTable({
										"responsive": true,
										"autoWidth": false,
										"order": [[ 1, "asc" ]],
										language:<?php echo wpnc_datatable_multi_language();?>,
										 "aoColumns":[
													  {"bSortable": false},
													  {"bSortable": false},
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
									jQuery("body").on("change", ".sub_chk", function($)
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
								<div class="panel-body"><!-- PANEL BODY  DIV -->
									<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">
										<table id="accountant_list" class="table table-striped table-bordered">
											<thead>
												<tr>
												    <th><input type="checkbox" id="select_all"></th>
													<th><?php  esc_html_e('Photo', 'lawyer_mgt' ) ;?></th>
													<th><?php esc_html_e('accountant Name', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('accountant Email', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Mobile Number', 'lawyer_mgt' ) ;?></th>
													<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
												</tr>
											</thead>
											<tbody>
												<?php 
												 $get_accountant = array(
													'role' => 'accountant',
													'meta_query' =>array( 
														array(
															'key' => 'deleted_status',
															'value' =>0,
															'compare' => '='
														)
													)	
												);	
												$accountantdata=get_users($get_accountant);
												if(!empty($accountantdata))
												{
													foreach ($accountantdata as $retrieved_data)
													{
												 ?>
													<tr>
														<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_attr($retrieved_data->ID); ?>"></td>				
														<td class="user_image"><?php $uid=esc_attr($retrieved_data->ID);
															$userimage=get_user_meta($uid, 'lmgt_user_avatar', true);
															if(empty($userimage))
															{
																echo '<img src='.esc_url(get_option( 'lmgt_system_logo' )).' height="50px" width="50px" class="img-circle" />';
															}
															else
																echo '<img src='.esc_url($userimage).' height="50px" width="50px" class="img-circle"/>';
														?></td>
														<td class="name"><a href="?page=accountant&tab=view_accountant&action=view&accountant_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>"><?php echo esc_html($retrieved_data->display_name);?></a></td>				
														<td class="email"><?php echo esc_html($retrieved_data->user_email);?></td>
														<td class="mobile"><?php echo esc_html($retrieved_data->mobile);?></td>
														<td class="action">
															<a href="?page=accountant&tab=view_accountant&action=view&accountant_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
															<a href="?page=accountant&tab=add_accountant&action=edit&accountant_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
															<a href="?page=accountant&tab=accountantlist&action=delete&accountant_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>" class="btn btn-danger" 
															onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');">
															<?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>
														</td>													   
													</tr>
													<?php 
													} 											
												}?>									 
											</tbody>        
										</table>
										<?php if(!empty($accountantdata))
												{
												?>
													<div class="form-group">		
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
															<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="user_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
														</div>
													</div>
											<?php }?>
									</div>
								</div>       
							</form>
						<?php 
						}
						if($active_tab == 'add_accountant')
						{
							require_once LAWMS_PLUGIN_DIR. '/admin/accountant/add_accountant.php';
						}
						if($active_tab == 'view_accountant')
						{
							require_once LAWMS_PLUGIN_DIR. '/admin/accountant/view_accountant.php';
						}
						 ?>
					
					</div>	<!-- PANEL BODY  DIV -->
				</div>	<!-- ENDPANEL WHITE  DIV -->
			</div>		
		</div><!--  END ROW DIV   --> 
	</div><!-- 	END MAIN WRAPER DIV   --> 
</div><!-- END  PAGE INNER DIV --> 	