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
}

$obj_rules=new MJ_lawmgt_rules;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'ruleslist');
$result=null;
?>
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV -->
	<div id="main-wrapper">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<h2 class="nav-tab-wrapper margin_bottom">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="add_event">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'ruleslist' ? 'active' : ''; ?> menucss">
									<a href="?dashboard=user&page=rules&tab=ruleslist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Rules List', 'lawyer_mgt'); ?>
									</a>
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
												
													  {"bSortable": true},
													  {"bSortable": true},
													  {"bSortable": false}													  
												   ]		               		
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
											<table id="rule_list" class="rule_list table table-striped table-bordered">
												<thead>	
												
													<tr>
													
														<th><?php  esc_html_e('Rule Name', 'lawyer_mgt' ) ;?></th>
														<th><?php esc_html_e('Description', 'lawyer_mgt' ) ;?></th>
														<th><?php esc_html_e('Documents', 'lawyer_mgt' ) ;?></th>
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
																<td class="added"><?php echo esc_html($retrieved_data->rule_name);?></td>	
																<td class="added"><?php echo esc_html($retrieved_data->description);?></td>
																
																<td class="added">
																<?php 
																if(!empty($retrieved_data->document_url))
																{
																	$doc_data=json_decode($retrieved_data->document_url);
																	if(!empty($doc_data[0]->value))
																	{
																		?><a target="blank" href="<?php print esc_url(content_url().'/uploads/document_upload/'.$doc_data[0]->value); ?>" class="status_read btn btn-default" record_id="<?php echo $retrieved_data->id;?>"><i class="fa fa-download"></i><?php esc_html_e(' Download', 'lawyer_mgt');?></a><?php  
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
															</tr>
													<?php 
														} 			
													} ?>     
												</tbody>
											</table>
											 
										</div>
									</div>       
								</form>
							</div>
						<?php 
						} ?>
						
					</div>
				</div>
			</div>
		</div>
	</div><!--END MAIN WRAPER  DIV -->
</div><!--  PAGE INNER DIV -->