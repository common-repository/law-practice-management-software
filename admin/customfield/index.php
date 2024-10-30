<?php 
$obj_custome_field=new MJ_lawmgt_custome_field;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'custome_field_list');
$result=null;
if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
{
	//wp_redirect (admin_url().'admin.php?page=lmgt_system');
	$redirect_url=esc_url(admin_url().'admin.php?page=lmgt_system');
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
?>
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV -->
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' )); ?></h3>
	  </div>
	</div>
	<?php 
	//save Custom Field Data
	if(isset($_POST['add_custom_field']))
	{	
		if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='insert')
		{		
			//add Custom Field data
			$result=$obj_custome_field->MJ_lawmgt_add_custom_field($_POST);		   
			if($result)
			{
				//wp_redirect ( admin_url() . 'admin.php?&page=custom_field&tab=custome_field_list&message=1');
			    $redirect_url= esc_url(admin_url().'admin.php?&page=custom_field&tab=custome_field_list&message=1');
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
			//update Custom Field data
			$result=$obj_custome_field->MJ_lawmgt_add_custom_field($_POST);			
			if($result)
			{
				//wp_redirect ( admin_url() . 'admin.php?&page=custom_field&tab=custome_field_list&message=2');	
			    $redirect_url= esc_url(admin_url().'admin.php?&page=custom_field&tab=custome_field_list&message=2');
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
	if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='delete')
	{		
		$result=$obj_custome_field->MJ_lawmgt_delete_custome_field(sanitize_text_field($_REQUEST['id']));
		
		if($result)
		{
			//wp_redirect ( admin_url() . 'admin.php?page=custom_field&tab=custome_field_list&message=3');
		    $redirect_url= esc_url(admin_url().'admin.php?page=custom_field&tab=custome_field_list&message=3');
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
	if(isset($_POST['custome_delete_selected']))
	{
		if (isset($_POST["selected_id"]))
		{	
			foreach($_POST["selected_id"] as $custome_id)
			{		
				$record_id= sanitize_text_field($custome_id);
				$result=$obj_custome_field->MJ_lawmgt_delete_selected_custome_field($record_id);
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
			//wp_redirect ( admin_url() . 'admin.php?page=custom_field&tab=custome_field_list&message=3');
		    $redirect_url= esc_url(admin_url().'admin.php?page=custom_field&tab=custome_field_list&message=3');
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
				<?php esc_html_e('Custom Field Inserted Successfully','lawyer_mgt');?>
				</div>
				<?php 
			
		}
		elseif($message == 2)
		{?>
				<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
					<?php esc_html_e('Custom Field  Updated Successfully','lawyer_mgt');?>
				</div>
				<?php 			
		}
		elseif($message == 3) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
             <?php esc_html_e('Custom Field  Delete Successfully','lawyer_mgt');?>
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
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'custome_field_list' ? 'active' : ''; ?> menucss">
									<a href="?page=custom_field&tab=custome_field_list">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Custom Field List', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_custome_field' ? 'active' : ''; ?> menucss">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
								{?>
								<a href="?page=custom_field&tab=add_custome_field&action=edit&id=<?php echo esc_attr($_REQUEST['id']);?>">
									<?php esc_html_e('Edit Custom Field', 'lawyer_mgt'); ?>
								</a>  
								<?php 
								}
								else
								{?>
									<a href="?page=custom_field&tab=add_custome_field">
										<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Custom Field', 'lawyer_mgt');?>
									</a>  
								<?php  
								}?>
								</li>							
							</ul>
					   </h2>
						<?php
						if($active_tab == 'custome_field_list')
						{ ?>
							<script type="text/javascript">
							    var $ = jQuery.noConflict();
								jQuery(document).ready(function($)
								{
									"use strict";
									jQuery('#custome_field_list').DataTable({
										"responsive": true,
										"autoWidth": false,
										"order": [[ 1, "asc" ]],
										language:<?php echo wpnc_datatable_multi_language();?>,
										 "aoColumns":[
													  {"bSortable": false}, 
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
									jQuery('#note_list').validationEngine();
								});
							</script>	
							<div class="tab-pane  tabs fade  active in" id="nav-open" role="tabpanel" aria-labelledby="nav-open-tab">
								<form name="" action="" method="post" enctype='multipart/form-data'>
									<div class="panel-body">
										<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">	
											<table id="custome_field_list" class="custome_field_list table table-striped table-bordered">
												<thead>	
													<?php  ?>
													<tr>
														<th><input type="checkbox" id="select_all"></th>
														<th><?php  esc_html_e('Form Name', 'lawyer_mgt' ) ;?></th>
														<th><?php esc_html_e('Lable', 'lawyer_mgt' ) ;?></th>
														<th><?php esc_html_e('Type', 'lawyer_mgt' ) ;?></th>
														<th><?php esc_html_e('Validation', 'lawyer_mgt' ) ;?></th>
														<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
													</tr>
													<br/>
												</thead>
												<tbody>
													<?php
													$custome_feilddata=$obj_custome_field->MJ_lawmgt_get_all_custom_field_data();
													if(!empty($custome_feilddata))
													{													
														foreach ($custome_feilddata as $retrieved_data)
														{
															?>
															<tr> 
																<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->id); ?>"></td>												
																<td class="added"><?php echo esc_html($retrieved_data->form_name);?></td>	
																<td class="added"><?php echo esc_html($retrieved_data->field_label);?></td>	
																<td class="added"><?php echo esc_html($retrieved_data->field_type);?></td>
																<td class="added"><?php echo esc_html($retrieved_data->field_validation);?></td>
																
																<td class="action"> 
																<a href="?page=custom_field&tab=add_custome_field&action=edit&id=<?php echo esc_attr($retrieved_data->id);?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
																<a href="?page=custom_field&tab=custome_field_list&action=delete&id=<?php echo esc_attr($retrieved_data->id);?>" class="btn btn-danger" 
																	onclick="return confirm('<?php esc_html_e('Are you sure you want to Delete this Custome Field ?','lawyer_mgt');?>');">
																  <?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>					
																</td>               
															</tr>
													<?php 
														} 			
													} ?>     
												</tbody>
											</table>
											<?php  
											if(!empty($custome_feilddata))
												{
											?>
											<div class="form-group">		
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
													<input type="submit" class="btn delete_check  delete_margin_bottom btn-danger" name="custome_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
												</div>
											</div>
												<?php  } ?>
										</div>
									</div>       
								</form>
							</div>
						<?php 
						} 
						if($active_tab == 'add_custome_field')
						{
							require_once LAWMS_PLUGIN_DIR. '/admin/customfield/add_customfield.php';
						}						
						?>
					</div>
				</div>
			</div>
		</div>
	</div><!-- END  MAIN WRAPER  DIV -->
</div><!-- END  INNER PAGE  DIV -->