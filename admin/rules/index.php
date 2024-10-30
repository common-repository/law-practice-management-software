<?php 
$obj_rules=new MJ_lawmgt_rules;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'ruleslist');
$result=null;
?>
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV -->
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' ));?></h3>
	  </div>
	</div>
	<?php 
	if(isset($_POST['saverules']))
	{
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_rules_nonce' ) )
		{ 
			$upload_docs_array=array();	
			
			if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action']) == 'edit')
			{
				if(isset($_FILES['rule_documents']) && !empty($_FILES['rule_documents']) && $_FILES['rule_documents']['size'] !=0)
				{			
					if($_FILES['rule_documents']['size'] > 0)
						$upload_docs=MJ_lawmgt_load_documets($_FILES['rule_documents'],$_FILES['rule_documents'],'rule_documents');			
				}
				else
				{
					if(isset($_REQUEST['old_hidden_rule_documents']))
					$upload_docs= sanitize_text_field($_REQUEST['old_hidden_rule_documents']);				
				}		
				$result=$obj_rules->MJ_lawmgt_add_rules($_POST,$upload_docs);
				
				if($result)
				{
					//wp_redirect (admin_url().'admin.php?page=rules&tab=ruleslist&message=2');
					$url=admin_url().'admin.php?page=rules&tab=ruleslist&message=2';
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
				if(isset($_FILES['rule_documents']) && !empty($_FILES['rule_documents']) && $_FILES['rule_documents']['size'] !=0)
				{			
					if($_FILES['rule_documents']['size'] > 0)
						$upload_docs=MJ_lawmgt_load_documets($_FILES['rule_documents'],$_FILES['rule_documents'],'rule_documents');		
					
				}
				else
				{
					$upload_docs='';
				}
				
				$result=$obj_rules->MJ_lawmgt_add_rules($_POST,$upload_docs);
				if($result)
				{
					//wp_redirect ( admin_url() . 'admin.php?page=rules&tab=ruleslist&message=1');
				    $url=admin_url().'admin.php?page=rules&tab=ruleslist&message=1';
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
		}
	}		 
	if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='delete')
	{	

		$result=$obj_rules->MJ_lawmgt_delete_rules(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id'])));
		
		if($result)
		{
		    //wp_redirect ( admin_url() . 'admin.php?page=rules&tab=ruleslist&message=3');
			$url=admin_url().'admin.php?page=rules&tab=ruleslist&message=3';
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
	if(isset($_POST['rules_delete_selected']))
	{
		if (isset($_POST["selected_id"]))
		{	
			foreach($_POST["selected_id"] as $rules_id)
			{		
				$record_id= sanitize_text_field($rules_id);
				$result=$obj_rules->MJ_lawmgt_delete_selected_rules($record_id);
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
			//wp_redirect ( admin_url() . 'admin.php?page=rules&tab=ruleslist&message=3');
			$url=admin_url().'admin.php?page=rules&tab=ruleslist&message=3';
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
		$message = sanitize_text_field($_REQUEST['message']);
		if($message == 1)
		{?>	
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
				<?php esc_html_e('Rule Inserted Successfully','lawyer_mgt');?>
				</div>
				<?php 
			
		}
		elseif($message == 2)
		{?>
				<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
					<?php esc_html_e('Rule Updated Successfully','lawyer_mgt');?>
				</div>
				<?php 			
		}
		elseif($message == 3) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
             <?php esc_html_e('Rule Delete Successfully','lawyer_mgt');?>
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
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'ruleslist' ? 'active' : ''; ?> menucss">
									<a href="?page=rules&tab=ruleslist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Rules List', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_rules' ? 'active' : ''; ?> menucss">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
								{?>
								<a href="?page=rules&tab=add_rules&action=edit&id=<?php echo esc_attr($_REQUEST['id']);?>">
									<?php esc_html_e('Edit Rules', 'lawyer_mgt'); ?>
								</a>  
								<?php 
								}
								else
								{?>
									<a href="?page=rules&tab=add_rules">
										<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Rules', 'lawyer_mgt');?>
									</a>  
								<?php  
								}?>
								</li>							
							</ul>
					   </h2>
						<?php
						if($active_tab == 'ruleslist')
						{ ?>
							<script type="text/javascript">
								jQuery(document).ready(function($)
								{
									"use strict";
									jQuery('#rule_list').DataTable({
										"responsive": true,
										"autoWidth": false,
										"order": [[ 1, "asc" ]],
										language:<?php echo wpnc_datatable_multi_language();?>,
										 "aoColumns":[
													  {"bSortable": false},
													  {"bSortable": true},
													  {"bSortable": true},
													  {"bSortable": false},
													  {"bSortable": false}
												   ]	
										});	
											jQuery(".delete_check").on('click', function($)
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
											<table id="rule_list" class="rule_list table table-striped table-bordered">
												<thead>	
													<?php  ?>
													<tr>
														<th><input type="checkbox" id="select_all"></th>
														<th><?php  esc_html_e('Rule Name', 'lawyer_mgt' ) ;?></th>
														<th><?php esc_html_e('Description', 'lawyer_mgt' ) ;?></th>
														<th><?php esc_html_e('Documents', 'lawyer_mgt' ) ;?></th>
														<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
													</tr>
													<br/>
												</thead>
												<tbody>
													<?php
													$ruledata=$obj_rules->MJ_lawmgt_get_all_rules();
													if(!empty($ruledata))
													{													
														foreach ($ruledata as $retrieved_data)
														{
															?>
															<tr> 
																<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->id); ?>"></td>												
																<td class="added"><?php echo esc_html($retrieved_data->rule_name);?></td>	
																<td class="added"><?php echo esc_html($retrieved_data->description);?></td>
																
																<td class="added">
																<?php 
																if(!empty($retrieved_data->document_url))
																{
																	$doc_data=json_decode($retrieved_data->document_url);
																	if(!empty($doc_data[0]->value))
																	{
																		?><a target="blank" href="<?php print content_url().'/uploads/document_upload/'.$doc_data[0]->value; ?>" class="status_read btn btn-default" record_id="<?php echo esc_attr($retrieved_data->id);?>"><i class="fa fa-download"></i><?php esc_html_e(' Download', 'lawyer_mgt');?></a><?php
																	} 
																	else
																	{
																		echo '<b class="desh" >'."-".'</b>';
																	}	
																} 
																else
																{
																	echo '<b class="desh" >'."-".'</b>';
																}
																?></td>
																
																<td class="action"> 
																<a href="?page=rules&tab=add_rules&action=edit&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
																<a href="?page=rules&tab=ruleslist&action=delete&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" 
																	onclick="return confirm('<?php esc_html_e('Are you sure you want to Delete this Rule ?','lawyer_mgt');?>');">
																  <?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>					
																</td>               
															</tr>
													<?php 
														} 			
													} ?>     
												</tbody>
											</table>
											<?php  
											if(!empty($ruledata))
												{
											?>
											<div class="form-group">		
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
													<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="rules_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
												</div>
											</div>
												<?php  } ?>
										</div>
									</div>       
								</form>
							</div>
						<?php 
						} 
						if($active_tab == 'add_rules')
						{
							require_once LAWMS_PLUGIN_DIR. '/admin/rules/addrules.php';
						}						
						?>
					</div>
				</div>
			</div>
		</div>
	</div><!-- END  MAIN WRAPER  DIV -->
</div><!-- END  INNER PAGE  DIV -->