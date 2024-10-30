<?php 	
$court=new MJ_lawmgt_Court;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'courtlist');
$result=null;
?>
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV -->
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' ));?></h3>
	  </div>
	</div>
	  
	 <?php 
	if(isset($_POST['save_court']))//save_court	
	{
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_court_nonce' ) )
		{ 
			if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='edit')
			{
				$result=$court->MJ_lawmgt_lmgt_add_court($_POST);
				if($result)
				{
					//wp_redirect ( admin_url().'admin.php?page=court&tab=courtlist&message=2');
					$redirect_url=admin_url().'admin.php?page=court&tab=courtlist&message=2';
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
					//wp_redirect ( admin_url().'admin.php?page=court&tab=courtlist&message=1');
					$redirect_url=admin_url().'admin.php?page=court&tab=courtlist&message=1';
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
			//wp_redirect ( admin_url().'admin.php?page=court&tab=courtlist&message=3');
		    $redirect_url=admin_url().'admin.php?page=court&tab=courtlist&message=3';
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
			foreach($_POST["selected_id"] as $event_id)
			{		
				$record_id= sanitize_text_field($event_id);
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
			//wp_redirect ( admin_url() . 'admin.php?page=court&tab=courtlist&message=3');
			$redirect_url=admin_url().'admin.php?page=court&tab=courtlist&message=3';
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
					   <h2 class="nav-tab-wrapper">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="add_court">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'courtlist' ? 'active' : ''; ?> menucss">
									<a href="?page=court&tab=courtlist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Court List', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_court' ? 'active' : ''; ?> menucss">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
								{?>
								<a href="?page=court&tab=add_court&action=edit&id=<?php echo esc_attr($_REQUEST['id']);?>">
									<?php esc_html_e('Edit Court', 'lawyer_mgt'); ?>
								</a>  
								<?php 
								}
								else
								{?>
									<a href="?page=court&tab=add_court">
										<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Court', 'lawyer_mgt');?>
									</a>  
								<?php  
								}?>
								</li>
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
								{?>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'viewcourt' ? 'active' : ''; ?> menucss">
									<a href="?page=court&tab=viewcourt&action=view&c_id=<?php echo esc_attr($_REQUEST['c_id']);?>">
										<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('View Court', 'lawyer_mgt'); ?>
									</a>
								</li>
								<?php
								}
								?>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'courtactivity' ? 'active' : ''; ?> menucss">
									<a href="?page=court&tab=courtactivity">
										<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('Court Activity', 'lawyer_mgt'); ?>
									</a>
								</li>
							</ul>
					   </h2>
						<?php
						if($active_tab == 'courtlist')
						{ ?>
						<script type="text/javascript">
						        var $ = jQuery.noConflict();
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
									
									jQuery("body").on("change", ".sub_chk", function()
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
													<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
												</tr>
												<br/>
											</thead>
											 
											<tbody>
												<?php 
												 
												$court_data=$court->MJ_lawmgt_get_all_court_data();
												 
												if(!empty($court_data))
												{
													foreach ($court_data as $retrieved_data)
													{
														?>
														<tr>
															<td class="title123"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->c_id); ?>"></td>	
															<td class="court">
															<?php 
															$court_name = get_post(esc_html($retrieved_data->court_id));
															echo esc_html($court_name->post_title);?></td>
															<td class="state">
															<?php 
															$state_name=get_post(esc_html($retrieved_data->state_id)); 
															echo esc_html($state_name->post_title);?></td>
															<td class="bench">
															<?php
															$bench_name= esc_attr($retrieved_data->bench_id);
															$contac_id=explode(',',$bench_name);
															$conatc_name=array();
															foreach($contac_id as $contact_name)
															{
																$user_data=get_post($contact_name);
																$conatc_name[]=$user_data->post_title;
															}		
															$conatc_name_sanitize = array_map( 'sanitize_text_field', wp_unslash( $conatc_name ) );
															echo esc_html(implode(',',$conatc_name_sanitize));?></td>
															<td class="action">
															<a href="?page=court&tab=add_court&action=edit&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->c_id));?>" id='' class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
															<a href="?page=court&tab=courtlist&action=delete&c_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->c_id));?>" class="btn btn-danger" 
															onclick="return confirm('<?php esc_html_e('Are you sure you want to Delete this Court ?','lawyer_mgt');?>');">
														  <?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>
														   
														</tr>
													<?php 
													} 
												}
												 ?>
											</tbody>
										</table>
										<?php 
								if(!empty($court_data))
										{
								?>
								<div class="form-group">		
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
										<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="court_delete_selected"  value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
									</div>
								</div>
										<?php } ?>
								    </div><!--END TABLE RESPONSIVE-->
							    </div>   
						    </form>
													
						<?php 
						} 
						if($active_tab == 'add_court')
						{
							require_once LAWMS_PLUGIN_DIR. '/admin/court/add_court.php';
						}
						if($active_tab == 'courtactivity')
						{	
							require_once LAWMS_PLUGIN_DIR. '/admin/court/court_activity.php';
						}	
						?>
					</div>
				</div>
			</div>
		</div>
	</div><!-- END  MAIN WRAPER  DIV -->
</div><!-- END  INNER PAGE  DIV -->