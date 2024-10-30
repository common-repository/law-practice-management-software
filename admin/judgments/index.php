<?php 	
$obj_judgments=new MJ_lawmgt_Judgments;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'judgmentlist');
$result=null;
?>
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV --> 
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' ));?></h3>
	  </div>
	</div>
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

					$upload_docs= sanitize_text_field($_REQUEST['old_hidden_judgement_documents']);				
				}
				$result=$obj_judgments->MJ_lawmgt_add_judgment($_POST,$upload_docs);
					
				if($result)
				{
					//wp_redirect ( admin_url() . 'admin.php?page=judgments&tab=judgmentlist&message=2');
				    $redirect_url=admin_url().'admin.php?page=judgments&tab=judgmentlist&message=2';
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
					//wp_redirect ( admin_url() . 'admin.php?page=judgments&tab=judgmentlist&message=1');
				    $redirect_url=admin_url().'admin.php?page=judgments&tab=judgmentlist&message=1';
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
			//wp_redirect ( admin_url() . 'admin.php?page=judgments&tab=judgmentlist&message=3');
			$redirect_url=admin_url().'admin.php?page=judgments&tab=judgmentlist&message=3';
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
			foreach($_POST["selected_id"] as $event_id)
			{		
				$record_id= sanitize_text_field($event_id);
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
			//wp_redirect ( admin_url() . 'admin.php?page=judgments&tab=judgmentlist&message=3');
			$redirect_url=admin_url().'admin.php?page=judgments&tab=judgmentlist&message=3';
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
	<div id="main-wrapper"><!--  MAIN WRAPER DIV   --> 
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<h2 class="nav-tab-wrapper">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="tablist">
								<li role="presentation" class="<?php echo $active_tab == 'judgmentlist' ? 'active' : ''; ?> menucss">
									<a href="?page=judgments&tab=judgmentlist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Judgment List', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo $active_tab == 'add_judgment' ? 'active' : ''; ?> menucss">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
								{?>
								<a href="?page=judgments&tab=add_judgment&&action=edit&id=<?php echo esc_attr($_REQUEST['id']);?>">
									<?php esc_html_e('Edit Judgment', 'lawyer_mgt'); ?>
								</a>  
								<?php 
								}			
								else
								{?>
									<a href="?page=judgments&tab=add_judgment">
										<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Judgment', 'lawyer_mgt');?>
									</a>  
								<?php  
								}?>
								</li>
								<?php
								/* if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
								{ */
									?>	
									<li role="presentation" class="<?php echo $active_tab == 'judgment_activity' ? 'active' : ''; ?> menucss">
										<a href="?page=judgments&tab=judgment_activity">
											<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('Judgment Activity', 'lawyer_mgt'); ?>
										</a>
									</li>
									<?php
								//}
								?>
							</ul>
						</h2>
						<?php  
						if($active_tab == 'judgmentlist')
						{ 
						?>	
							<script type="text/javascript">
							    var $ = jQuery.noConflict();
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
													  {"bSortable": true},
													  {"bSortable": true},
													  {"bSortable": true},
													  {"bVisible": true},	
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
								<div class="panel-body">
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
													<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
												</tr>
											</thead>
											<tbody>
											 <?php 
											$judgment_result=$obj_judgments->MJ_lawmgt_get_all_judgment();
											 if(!empty($judgment_result))
											 {
												foreach ($judgment_result as $retrieved_data)
												{
													 
													$case_name=MJ_lawmgt_get_case_name_by_id($retrieved_data->case_id);
													foreach($case_name as $case_name1)
													{
														$case_name2 = sanitize_text_field($case_name1->case_name);
													}	
												?>
												<tr>
													<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->id); ?>"></td>				
													<td class=""><?php echo MJ_lawmgt_getdate_in_input_box($retrieved_data->date);?></td>				
													<td class=""><?php echo esc_html($case_name2); ?></td>
													<td class=""><?php echo esc_html($retrieved_data->judge_name);?></td>
													<td class=""><?php echo esc_html($retrieved_data->judgments_details);?></td>
													<td class="added">
													<?php 
													$doc_data=json_decode($retrieved_data->judgments_document);
													if(!empty($doc_data[0]->value))
													{
														?><a target="blank" href="<?php print esc_url(content_url().'/uploads/document_upload/'.esc_attr($doc_data[0]->value)); ?>" class="status_read btn btn-default" record_id="<?php echo esc_attr($retrieved_data->id);?>"><i class="fa fa-download"></i><?php esc_html_e('Download', 'lawyer_mgt');?></a><?php 
													}
													else
													{
														echo '<b class="desh" >'."-".'</b>';
													}
												?></td>
													<td class=""><?php  if(!empty($retrieved_data->judgments_law_details)){
													echo  esc_html($retrieved_data->judgments_law_details); }
													else
													{
														echo '<b class="desh_jugment" >'."-".'</b>';
													}
													?></td>
													<td class="action">													
														<a href="?page=judgments&tab=add_judgment&action=edit&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
														<a href="?page=judgments&tab=judgmentlist&action=delete&judgment_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');">
														<?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>					
													</td>               
												</tr>
												<?php } 			
											}?>     
											</tbody>        
										</table>
										<?php 
									if(!empty($judgment_result))
										{
								?>
								<div class="form-group">		
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
										<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="judgments_delete_selected"  value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
									</div>
								</div>
										<?php } ?>
									</div>
								</div>       
							</form>
							 <?php 
							 }	
							if($active_tab == 'add_judgment')
							{		
								 require_once LAWMS_PLUGIN_DIR. '/admin/judgments/add_judgment.php';	
							}
							if($active_tab == 'judgment_activity')
							{		 
								require_once LAWMS_PLUGIN_DIR. '/admin/judgments/judgment_activity.php';		
							}
							?>
					</div>
				</div>
			</div>
		</div>
 	</div><!-- 	END MAIN WRAPER DIV   --> 
</div><!-- END  PAGE INNER DIV --> 	