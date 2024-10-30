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
$obj_orders=new MJ_lawmgt_Orders;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'orderlist');
?>
<div class="page_inner_front"><!--  PAGE INNER DIV -->
	<?php
	if(isset($_POST['save_orders']))
	{	
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_order_nonce' ) )
		{ 
			$upload_docs_array=array();	
			if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action']) == 'edit')
			{	
				//New Documents //
				if(!empty($_FILES['orders_documents']['name']))
				{
					$count_array=count($_FILES['orders_documents']['name']);

					for($a=0;$a<$count_array;$a++)
					{			
						foreach($_FILES['orders_documents'] as $image_key=>$image_val)
						{		
							$document_array[$a]=array(
							'name'=>sanitize_file_name($_FILES['orders_documents']['name'][$a]),
							'type'=>sanitize_file_name($_FILES['orders_documents']['type'][$a]),
							'tmp_name'=>sanitize_text_field($_FILES['orders_documents']['tmp_name'][$a]),
							'error'=>sanitize_file_name($_FILES['orders_documents']['error'][$a]),
							'size'=>sanitize_file_name($_FILES['orders_documents']['size'][$a])
							);							
						}
					}				
					foreach($document_array as $key=>$value)		
					{	
						$get_file_name=$document_array[$key]['name'];	
						
						$upload_docs_array[]=MJ_lawmgt_load_documets($value,$value,$get_file_name);				
					} 				
				}
				//Old Documents //
				if(!empty($_FILES['orders_documents_old']['name']))
				{
					$count_array=count($_FILES['orders_documents_old']['name']);

					for($a=0;$a<$count_array;$a++)
					{			
						foreach($_FILES['orders_documents_old'] as $image_key=>$image_val)
						{		
							$document_array1[$a]=array(
							'name'=>sanitize_file_name($_FILES['orders_documents_old']['name'][$a]),
							'type'=>sanitize_file_name($_FILES['orders_documents_old']['type'][$a]),
							'tmp_name'=>sanitize_text_field($_FILES['orders_documents_old']['tmp_name'][$a]),
							'error'=>sanitize_file_name($_FILES['orders_documents_old']['error'][$a]),
							'size'=>sanitize_file_name($_FILES['orders_documents_old']['size'][$a])
							);							
						}
					}	
									
					foreach($document_array1 as $key=>$value)		
					{	
						$get_file_name=$document_array1[$key]['name'];	
						
						if(!empty($get_file_name))
						{
							$upload_docs_array[]=MJ_lawmgt_load_documets($value,$value,$get_file_name);				
						}
						else
						{
							$upload_docs_array[]=senitize_file_name($_POST['old_hidden_orders_documents'][$key]);
						}				
					} 				
				}
				
				$upload_docs_array_filter=array_filter($upload_docs_array);
				$result=$obj_orders->MJ_lawmgt_add_order($_POST,$upload_docs_array_filter);
					
				if($result)
				{
					//wp_redirect (home_url().'?dashboard=user&page=orders&tab=orderlist&message=2');	
					$redirect_url=home_url().'?dashboard=user&page=orders&tab=orderlist&message=2';
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
				if(!empty($_FILES['orders_documents']['name']))
				{
					$count_array=count($_FILES['orders_documents']['name']);

					for($a=0;$a<$count_array;$a++)
					{			
						foreach($_FILES['orders_documents'] as $image_key=>$image_val)
						{		
							$document_array[$a]=array(
							'name'=>sanitize_file_name($_FILES['orders_documents']['name'][$a]),
							'type'=>sanitize_file_name($_FILES['orders_documents']['type'][$a]),
							'tmp_name'=>sanitize_text_field($_FILES['orders_documents']['tmp_name'][$a]),
							'error'=>sanitize_file_name($_FILES['orders_documents']['error'][$a]),
							'size'=>sanitize_file_name($_FILES['orders_documents']['size'][$a])
							);							
						}
					}				
					foreach($document_array as $key=>$value)		
					{	
						$get_file_name=$document_array[$key]['name'];	
						
						$upload_docs_array[]=MJ_lawmgt_load_documets($value,$value,$get_file_name);				
					} 				
				}
				$upload_docs_array_filter=array_filter($upload_docs_array);	
				$result=$obj_orders->MJ_lawmgt_add_order($_POST,$upload_docs_array_filter);
				
				if($result)
				{
					//wp_redirect (home_url().'?dashboard=user&page=orders&tab=orderlist&message=1');
					$redirect_url=home_url().'?dashboard=user&page=orders&tab=orderlist&message=1';
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
		$result = $obj_orders->MJ_lawmgt_delete_orders(sanitize_text_field($_REQUEST['order_id']));				
		if($result)
		{			
			//wp_redirect (home_url().'?dashboard=user&page=orders&tab=orderlist&message=3');
			$redirect_url = home_url().'?dashboard=user&page=orders&tab=orderlist&message=3';
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
				<?php esc_html_e('Order Inserted Successfully','lawyer_mgt');?>
			</div>
				<?php 
			
		}
		elseif($message == 2)
		{?>
				<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
					<?php esc_html_e('Order Updated Successfully','lawyer_mgt');?>
				</div>
				<?php 			
		}
		elseif($message == 3) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
             <?php esc_html_e('Order Deleted Successfully','lawyer_mgt');?>
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
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="tablist">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'orderlist' ? 'active' : ''; ?> menucss active_mt">
									<a href="?dashboard=user&page=orders&tab=orderlist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Orders List', 'lawyer_mgt'); ?>
									</a>
								</li>
								
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_order' ? 'active' : ''; ?> menucss tab_mt">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
								{?>
								<a href="?dashboard=user&page=orders&tab=add_order&&action=edit&id=<?php echo esc_attr($_REQUEST['id']);?>">
									<?php esc_html_e('Edit Order', 'lawyer_mgt'); ?>
								</a>  
								<?php 
								}			
								else
								{
									if($user_access['add']=='1')
									{
										?>
										<a href="?dashboard=user&page=orders&tab=add_order&&action=insert">
											<?php echo '<span class="fa fa-plus-circle"></span> '.esc_html__('Add Order', 'lawyer_mgt');?>
										</a>  
										<?php  
									}
								}
								?>
								</li>
								
							</ul>	
						</h2>
						<?php  
						if($active_tab == 'orderlist')
						{ 
						?>	
							<script type="text/javascript">
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
													  {"bSortable": true},
													   {"bSortable": true},
													  {"bSortable": false},
													  {"bSortable": true},
													   {"bSortable": true},
													  {"bVisible": true} <?php
													if($user_access['edit']=='1' || $user_access['delete']=='1')
													{
														?>
														,{"bSortable": false}
													  <?php
													}
												  ?>												  
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
							</script>
							<form name="wcwm_report" action="" method="post">
								<div class="panel-body margin_panel_cases">
									<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">
										<table id="attorney_list" class="table table-striped table-bordered">
											<thead>
												<tr>
													<th><input type="checkbox" id="select_all"></th>
													<th><?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Judge Name', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Next Hearing Date', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Order Details', 'lawyer_mgt' ) ;?></th>
													<th><?php esc_html_e('Purpose Of Hearing ', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Order Document', 'lawyer_mgt' ) ;?></th>
													 
													<?php
															if($user_access['edit']=='1' || $user_access['delete']=='1')
															{
															?>  
													<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
															<?php  }  ?>
												</tr>
											</thead>
											<tbody>
											 <?php 
											if($user_role == 'attorney')
											{
												if($user_access['own_data'] == '1')
												{
													$orders_result=$obj_orders->MJ_lawmgt_get_all_orders_by_attorney();
												}
												else
												{
													$orders_result=$obj_orders->MJ_lawmgt_get_all_orders();
												}													
											}
											elseif($user_role == 'client')
											{
												if($user_access['own_data'] == '1')
												{
													$orders_result=$obj_orders->MJ_lawmgt_get_all_orders_by_client();
												}
												else
												{
													$orders_result=$obj_orders->MJ_lawmgt_get_all_orders();
												}	
											}
											else					
											{	
												if($user_access['own_data'] == '1')
												{
													$orders_result=$obj_orders->MJ_lawmgt_get_all_own_orders();
												}
												else
												{
													$orders_result=$obj_orders->MJ_lawmgt_get_all_orders();
												}											
											}	
											
											 if(!empty($orders_result))
											 {
												foreach ($orders_result as $retrieved_data)
												{
													$case_name=MJ_lawmgt_get_case_name_by_id($retrieved_data->case_id);
													foreach($case_name as $case_name1)
													{
														$case_name2=esc_html($case_name1->case_name);
													}	
												?>
												<tr>
													<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->id);?>"></td>				
													 		
													<td class=""><?php echo esc_html($case_name2);?></td>
													<td class=""><?php 
													if(!empty($retrieved_data->judge_name))
													{
													  echo esc_html($retrieved_data->judge_name);
													}
													else
													{
														echo '<b class="desh" >'."-".'</b>';
													}
													?></td>
													<td class=""><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->next_hearing_date));?></td>	
													<td class=""><?php echo esc_html($retrieved_data->orders_details);?></td>
													<td class=""><?php 
													if(!empty($retrieved_data->purpose_of_hearing))
													{
						                                echo esc_html($retrieved_data->purpose_of_hearing);
													}
													else
													{
														echo '<b class="desh" >'."-".'</b>';
													}
													?></td>
													<td class="added">
													<?php 
													$doc_data=json_decode($retrieved_data->orders_document);
													if(!empty($doc_data))
													{
														foreach ($doc_data as $retrieved_data1)
														{
															?><a href="<?php print esc_url(content_url().'/uploads/document_upload/'.$retrieved_data1->value); ?>" target="blank" class="status_read btn btn-default download_btn" record_id="<?php echo esc_html($retrieved_data1->title);?>"><i class="fa fa-download"></i><?php esc_html_e(' Download', 'lawyer_mgt');?></a><?php
														}															
													} 
													else
													{
														
														echo '<b class="desh" >'."-".'</b>';
													}
													?>
													</td>
													<?php
													if($user_access['edit']=='1' || $user_access['delete']=='1')
													{
														?>  
														<td class="action">	
														<?php
														if($user_access['edit']=='1')
														{
															?>														
															<a href="?dashboard=user&page=orders&tab=add_order&action=edit&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
														<?php
														}
														if($user_access['delete']=='1')
														{
															?>	
															<a href="?dashboard=user&page=orders&tab=orderlist&action=delete&order_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');">
															<?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>		
														<?php
														}
														?>	
													</td>
													<?php 
													} 			
													?>  
												</tr>
												<?php } 			
											}?>     
											</tbody>        
										</table>
									</div>
								</div>       
							</form>
							 <?php 
							 }	
						if($active_tab == 'add_order')
						{
							$order_id=0;
							$edit=0;
							if(isset($_REQUEST['id']))
								$order_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id']));
							if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
							{			
								$edit=1;		
								$order_info = $obj_orders->MJ_lawmgt_get_single_orders($order_id);			
							}?>
		
							<script type="text/javascript">
							var $ = jQuery.noConflict();
							jQuery(document).ready(function($)
							{
								"use strict"; 
								$('#judgment_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});

								  $('#date').datepicker({
										changeMonth: true,
										changeYear: true,	        
										yearRange:'-65:+0',
										 endDate: '+0d',
										autoclose: true,
										onChangeMonthYear: function(year, month, inst) {
											$(this).val(month + "/" + year);
										}                    
								 });  
								 var start = new Date();
									var end = new Date(new Date().setYear(start.getFullYear()+1));
									$('.next_date').datepicker({
										startDate : start,
										endDate   : end,
										autoclose: true
									});		
							});	
							jQuery("body").on("change", ".input-file[type=file]", function ()
							{ 
								"use strict"; 
								var file = this.files[0]; 
								var file_id = jQuery(this).attr('id'); 
								var ext = $(this).val().split('.').pop().toLowerCase(); 
								//Extension Check 
								if($.inArray(ext, ['pdf','doc','docx','xls','xlsx','ppt','pptx','csv']) == -1)
								{
									  alert('<?php _e("Only pdf,doc,docx,xls,xlsx,ppt,pptx,csv formate are allowed.'  + ext + ' formate are not allowed.","lawyer_mgt") ?>');
									$(this).replaceWith('<input type="file" name="cartificate[]" class="form-control file_validation input-file">');
									return false; 
								} 
								 //File Size Check 
								 if (file.size > 20480000) 
								 {
									alert("<?php esc_html_e('Too large file Size. Only file smaller than 10MB can be uploaded.','lawyer_mgt');?>");
									$(this).replaceWith('<input type="file" name="cartificate[]" class="form-control file_validation input-file">'); 
									return false; 
								 }
							 });
							 
								//add more file upload div append
								"use strict"; 
								var blank_cirtificate_entry ='';
								jQuery(document).ready(function($)
								{ 
									"use strict"; 
									blank_cirtificate_entry = $('#cartificate_entry1').html();   	
								}); 
								"use strict"; 
								var value = 1;
								function MJ_lawmgt_add_cirtificate()
								{		
									"use strict"; 
									value++;
			
										$("#cartificate_div").append('<div class="form-group" row="'+value+'"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="documents"><?php esc_html_e('Upload Documents','lawyer_mgt');?></label><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><input type="text"  name="document_name[]" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>" class="form-control validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause"/></div><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><input type="file" name="orders_documents[]" class="form-control file_validation doc_label input-file "></div><div class="col-lg-2 col-md-1 col-sm-1 col-xs-12"><input type="button" value="<?php esc_html_e('Delete','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate doc_label btn btn-danger"></div></div>');
								}  	
								
								function MJ_lawmgt_deleteParentElement(n)
								{
									"use strict"; 
									alert("<?php esc_html_e('Do you really want to delete this record ?','lawyer_mgt');?>");
									n.parentNode.parentNode.remove();				
								}
							
						</script>
							<div class="panel-body"><!--PANEL BODY DIV   -->
								<form name="judgment_form" action="" method="post" class="form-horizontal" id="judgment_form" enctype='multipart/form-data'>	
									<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
									<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">		
									<input type="hidden" name="order_id" value="<?php echo esc_attr($order_id);?>"  />			
									<div class="form-group">				
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="date"><?php esc_html_e('Date','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
										
											<input id="date" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="form-control has-feedback-left validate[required]" name="date"  placeholder="<?php esc_html_e('Select Order Date','lawyer_mgt');?>"
											 value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($order_info->date));}elseif(isset($_POST['date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['date'])); } ?>" readonly>
											<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
											<span id="inputSuccess2Status2" class="sr-only"><?php esc_html_e('(success)','lawyer_mgt');?></span>
											
											 
										</div>
									</div> 
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Case Name','lawyer_mgt');?><span class="require-field">*</span></label>				
										<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">			
											<select class="form-control validate[required]" name="case_id" id="case_id">
											<option value=""><?php esc_html_e('Select Case Name','lawyer_mgt');?></option>
											<?php 
											 if($edit)
												$case_name =$order_info->case_id;				
											else 
												$case_name = "";
									
											$obj_case=new MJ_lawmgt_case;
											$user_case_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('cases');
											if($user_role == 'attorney')
											{
												if($user_case_access['own_data'] == '1')
												{
													$attorney_id = get_current_user_id();
													$result = $obj_case->MJ_lawmgt_get_open_case_by_attorney($attorney_id);	
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
											if(!empty($result))
											{
												foreach ($result as $retrive_data)
												{ 		 	
												?>
													<option value="<?php echo esc_attr($retrive_data->id);?>" <?php selected($case_name,esc_attr($retrive_data->id));  ?>><?php echo esc_html($retrive_data->case_name); ?> </option>
												<?php
												}
											} 
											?> 
											</select>				
										</div>			
									</div>
									<?php wp_nonce_field( 'save_order_nonce' ); ?>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12  control-label" for=""><?php esc_html_e('Judge Name','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
											<input id="judge_name" class="form-control has-feedback-left  validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input"   type="text" placeholder="<?php esc_html_e('Enter Judge Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($order_info->judge_name
											);}elseif(isset($_POST['judge_name'])){ echo esc_attr($_POST['judge_name']); } ?>" name="judge_name">
											<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>
										
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for=""><?php esc_html_e('Orders Details','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
											<textarea rows="3" class="validate[required,custom[address_description_validation],maxSize[150]] width_100_per" name="orders_details" placeholder="<?php esc_html_e('Enter Orders Details','lawyer_mgt');?>" id="orders_details"><?php if($edit){ echo esc_textarea($order_info->orders_details);}elseif(isset($_POST['orders_details'])){ echo esc_textarea($_POST['orders_details']); } ?></textarea>				
										</div>		
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Hearing_date"><?php esc_html_e('Next Hearing Date','lawyer_mgt');?><span class="require-field">*</span></label>
											<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
												<input id="next_hearing_date"  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="next_date form-control has-feedback-left validate[required]" type="text"  name="next_hearing_date"  placeholder="<?php esc_html_e('Select Next Hearing Date','lawyer_mgt');?>"
												value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($order_info->next_hearing_date));}elseif(isset($_POST['next_hearing_date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['next_hearing_date'])); } ?>" readonly>
												<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
												 
											</div>
									</div>	
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="next_hearing_date_description"><?php esc_html_e('Purpose Of Hearing','lawyer_mgt');?></label>
										<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
											<textarea rows="3" class="validate[custom[address_description_validation],maxSize[150]] width_100_per" name="purpose_of_hearing" id="purpose_of_hearing"><?php if($edit){ echo esc_textarea($order_info->purpose_of_hearing);}elseif(isset($_POST['purpose_of_hearing'])){ echo esc_textarea($_POST['purpose_of_hearing']); } ?></textarea>				
										</div>		
									</div>
									<?php  
										if($edit)
										{
											?>
											<div id="cartificate_div">	
												<input type="hidden" name="hidden_doc" value="<?php echo esc_attr($order_info->orders_document); ?>">
												<?php
												$increment=1;
												$doc_data=json_decode($order_info->orders_document);
												if(!empty($doc_data))
												{
													foreach ($doc_data as $retrieved_data)
													{
													?>
														<div class="form-group">	
															<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Upload Documents','lawyer_mgt');?></label>	
															<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
																<input type="text"  name="document_name[]" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($retrieved_data->title);}elseif(isset($_POST['document_name'])){ echo esc_attr($_POST['document_name']); } ?>"  class="form-control 	validate[custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause"/>
															</div>
															<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">					
																<input type="file" name="orders_documents_old[]" class="form-control file_validation input-file"/>						
																<input type="hidden" name="old_hidden_orders_documents[]" value="<?php if($edit){ echo esc_attr($retrieved_data->value);}elseif(isset($_POST['orders_details'])){ echo esc_attr($_POST['orders_details']); } ?>">					
															</div>
															<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
																<a  target="blank" class="status_read btn btn-default" href="<?php print esc_url(content_url().'/uploads/document_upload/'.$retrieved_data->value); ?>" record_id="<?php echo $order_info->id;?>">
																<i class="fa fa-download"></i><?php echo esc_html($retrieved_data->value);?></a>
															</div>
															<?php
															if($increment != 1)
															{
															?>
																<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12"><input type="button" value="<?php esc_html_e('Delete','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger"></div>
															<?php	
															}
															?>
														</div>
													<?php
														$increment=$increment-1;
													}
												}
												else
												{
													?>
													<div class="form-group" row="1">
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="documents"><?php esc_html_e('Upload Documents','lawyer_mgt');?></label>
														<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
														<input type="text"  name="document_name[]" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>" class="form-control validate[custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause"/>
														</div>
														<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
															<input type="file" name="orders_documents[]" class="form-control doc_label file_validation input-file ">
														</div>	
													</div>	
													<?php
												}				
												?>
											</div>
											<?php
										}
										else{
										?>
										<div id="cartificate_div">	
											<div class="form-group" row="1">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="documents"><?php esc_html_e('Upload Documents','lawyer_mgt');?></label>
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
												<input type="text"  name="document_name[]" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>" class="form-control validate[custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause"/>
												</div>
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
													<input type="file" name="orders_documents[]" class="form-control doc_label file_validation input-file ">
												</div>	
											</div>	
										</div>	
										<?php  } ?>
										<div class=" offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
												<input type="button" value="<?php esc_attr_e('Add More Documents','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_cirtificate()" class="add_cirtificate btn btn-success mt_10">
											</div>
										<div class="offset-sm-2 col-sm-8">
											<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Add Orders','lawyer_mgt');}?>" name="save_orders" class="btn btn-success mt_10"/>
										</div>
									</form>
								</div><!--END PANEL BODY DIV   -->
						<?php 	
						}
						?>
					</div>			
				</div>
			</div>
		</div>
	</div> <!-- END MAIN WRAPER  DIV -->
</div><!--  END PAGE INNER DIV -->