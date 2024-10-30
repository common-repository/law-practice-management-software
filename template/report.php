<?php
$user_role=MJ_lawmgt_get_current_user_role(); 
$obj_invoice=new MJ_lawmgt_invoice;
$obj_case=new  MJ_lawmgt_case;
$obj_task=new MJ_lawmgt_case_tast;
MJ_lawmgt_browser_javascript_check();
if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
{
	$redirect_url=home_url() . '?dashboard=user';
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
//access right//
$user_access=MJ_lawmgt_get_userrole_wise_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		MJ_lawmgt_access_right_page_not_access_message();
		die;
	}
}	
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'paymentreport');
?>
<script type="text/javascript">
jQuery(document).ready(function ($) 
{
	"use strict"; 
	var u_role = $("#bbb").val();
	 if(u_role == 'staff_member')
	 {
		$("h2").removeClass("tab_invoice");
	 }
	 
	 if(u_role == 'attorney')
	 {
		$("h2").removeClass("tab_invoice_new");
	 }
	 if(u_role == 'client')
	 {
		$("h2").removeClass("tab_invoice_new");
	 } 
});
</script>
<div class="page_inner_front"><!--  PAGE INNER DIV -->
	<input type="hidden" class="form-control" id="bbb" value="<?php echo esc_attr($user_role);?>">
	<div id="main-wrapper"><!-- MAIN WRAPER  DIV -->
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<h2 class="nav-tab-wrapper margin_bottom_invoice tab_invoice tab_invoice_new">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="tablist">
								<?php
								if($user_role == 'attorney' || $user_role == 'staff_member')
								{  
								?>
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'paymentreport' ? 'active' : ''; ?> menucss">
										<a href="?dashboard=user&page=report&tab=paymentreport">
											<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Payments', 'lawyer_mgt'); ?>
										</a>
									</li>
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'casereport' ? 'active' : ''; ?> menucss">
										<a href="?dashboard=user&page=report&tab=casereport">
										<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Cases', 'lawyer_mgt'); ?>
										</a>
									</li>
								<?php
								}
								?>
								<?php
								if($user_role == 'client')
								{  
								?>
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'paymentreport' ? 'active' : ''; ?> menucss">
										<a href="?dashboard=user&page=report&tab=paymentreport">
											<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Payments', 'lawyer_mgt'); ?>
										</a>
									</li>
									 
								<?php
								}
								?>
								<?php
								if($user_role == 'staff_member')
								{  
								?>
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'invoicereport' ? 'active' : ''; ?> menucss">
										<a href="?dashboard=user&page=report&tab=invoicereport">
											<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Invoices', 'lawyer_mgt'); ?>
										</a>
									</li>
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'expensereport' ? 'active' : ''; ?> menucss">
										<a href="?dashboard=user&page=report&tab=expensereport">
											<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Expenses', 'lawyer_mgt'); ?>
										</a>
									</li>			
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'timeentriereport' ? 'active' : ''; ?> menucss">
										<a href="?dashboard=user&page=report&tab=timeentriereport">
											<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Time Entries', 'lawyer_mgt'); ?>
										</a>
									</li>	
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'taskreport' ? 'active' : ''; ?> menucss">
										<a href="?dashboard=user&page=report&tab=taskreport">
											<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Tasks', 'lawyer_mgt'); ?>
										</a>
									</li>
								<?php
								}
								?>
								<?php
								if($user_role == 'accountant')
								{  
								?>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'paymentreport' ? 'active' : ''; ?> menucss">
									<a href="?dashboard=user&page=report&tab=paymentreport">
										<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Payments', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo $active_tab == 'invoicereport' ? 'active' : ''; ?> menucss">
										<a href="?dashboard=user&page=report&tab=invoicereport">
											<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Invoices', 'lawyer_mgt'); ?>
										</a>
									</li>
								<?php
								}
								?>
							</ul>
						</h2>
						<?php	
						if($active_tab == 'paymentreport')
						{	
							 
								if($user_role == 'client')
								{
									$active_tab = sanitize_text_field(isset($_GET['tab1'])?$_GET['tab1']:'all_payments_by_case'); 
								}
								else
								{ 
									$active_tab = sanitize_text_field(isset($_GET['tab1'])?$_GET['tab1']:'all_payments_by_case_and_client'); 
								}
								?>
						 
							<h2>
								<ul id="myTab" class="sub_menu_css line bac_white case_nav nav nav-tabs" role="tablist">
								<?php  
								if($user_role != 'client')
								{
								?>
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'all_payments_by_case_and_client' ? 'active' : ''; ?> menucss">
										<a href="?dashboard=user&page=report&tab=paymentreport&tab1=all_payments_by_case_and_client">
											<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('All Payments By Case And Client', 'lawyer_mgt'); ?>
										</a>
									</li>
								<?php  
								}
								?>
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'all_payments_by_case' ? 'active' : ''; ?> menucss">
										<a href="?dashboard=user&page=report&tab=paymentreport&tab1=all_payments_by_case">
											<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('All Payments By Case Report', 'lawyer_mgt'); ?>
										</a>
									</li>
									 
								</ul>	
							</h2>
						<?php 
						if($active_tab == 'all_payments_by_case_and_client')
						{ 	
						?>			
							<script type="text/javascript">
							jQuery(document).ready(function($)
							{
								"use strict"; 
								$('#invoice_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
								 
								$('.sdate').datepicker({
									 
									autoclose: true
								}).on('changeDate', function(){
									$('.edate').datepicker('setStartDate', new Date($(this).val()));
								}); 
								
								 
								$('.edate').datepicker({
									 
									autoclose: true
								}).on('changeDate', function(){
									$('.sdate').datepicker('setEndDate', new Date($(this).val()));
								});
								 
							});

						</script>
						<div class="panel-body">
							<form method="post" id="invoice_form"> 
								<div class="form-group col-md-12" >
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('Case Name','lawyer_mgt');?></label>
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" > 	
										<select class="form-control" name="case_name" id="case_name">	
											<option value=""><?php esc_html_e('Select Case Name','lawyer_mgt');?></option>
											<?php
													$obj_case=new  MJ_lawmgt_case;
													$user_case_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('cases');
													if($user_role == 'attorney')
													{
														if($user_case_access['own_data'] == '1')
														{
															$attorney_id = get_current_user_id();														
															$case_data = $obj_case->MJ_lawmgt_get_all_case_by_attorney_id($attorney_id);	
														}
														else
														{
															$case_data = $obj_case->MJ_lawmgt_get_all_case();
														}		
													}
													else
													{
														if($user_case_access['own_data'] == '1')
														{
															$case_data = $obj_case->MJ_lawmgt_get_all_case_created_by();
														}
														else
														{
															$case_data = $obj_case->MJ_lawmgt_get_all_case();
														}		
													}													
													
													if(!empty($case_data))
													{
														foreach($case_data as $retrive_data)
														{  				
													?>						
															<option value="<?php echo esc_attr($retrive_data->id);?>"><?php echo esc_html($retrive_data->case_name);?> </option>
													<?php }	
													}
												?> 			
										</select>
									</div>
									
									<label  class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('Client Name','lawyer_mgt');?></label>
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
										<select class="form-control" name="client_name" id="client_name">	
											<option value=""><?php esc_html_e('Select Client Name','lawyer_mgt');?></option>
											<?php
													$user_client_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('contacts');
													if($user_role == 'attorney')
													{
														if($user_client_access['own_data'] == '1')
														{
															$obj_case=new MJ_lawmgt_case;
															$current_user_id = get_current_user_id();
															$attorney_cases=$obj_case->MJ_lawmgt_get_all_case_by_attorney_id($current_user_id);
															$client_data=array();
															$attorneydata1=array();
															if(!empty($attorney_cases))
															{		
																foreach($attorney_cases as $data)
																{
																	$case_contact_assigned=explode(',',$data->user_id);	
																	if(!empty($case_contact_assigned))
																	{		
																		foreach($case_contact_assigned as $data1)
																		{
																			$client_data[]=$data1;
																		}
																	}
																}	
															}
															$client_unique=array_unique($client_data);
															 if(!empty($client_unique))
															{		
																foreach($client_unique as $data1)
																{
																	$contactdata1[]=get_userdata($data1);
																}	
															}  
															 
															$contactdata_2=$contactdata1; 

															$contactdata_3 = get_users(
																array(
																	'role' => 'client',
																	'meta_query' => array(						
																	array(
																			'key' => 'created_by',
																			'value' =>get_current_user_id(),
																			'compare' => '='
																		),
																	)
																));	
																$contactdata =array_merge($contactdata_2,$contactdata_3);
																
														}
														else			
														{	
															$contactdata =get_users(array('role'=>'client'));	
														}																
													}
													elseif($user_role == 'client')
													{
														if($user_client_access['own_data'] == '1')
														{	
															$user_id = get_current_user_id();
															$contactdata=array();
															$contactdata[]=get_userdata($user_id);	
														}
														else			
														{	
															$contactdata =get_users(array('role'=>'client'));
														}																
													}
													else
													{	
														if($user_client_access['own_data'] == '1')
														{
															$contactdata = get_users(
																array(
																	'role' => 'client',
																	'meta_query' => array(						
																	array(
																			'key' => 'created_by',
																			'value' =>get_current_user_id(),
																			'compare' => '='
																		),
																	)
																));	
														}
														else			
														{				
															$contactdata =get_users(array('role'=>'client'));
														}																
													}
														if(!empty($contactdata))
														{
															foreach($contactdata as $retrive_data)
															{  				
														?>						
																<option value="<?php echo esc_attr($retrive_data->ID);?>"><?php echo esc_html($retrive_data->display_name);?> </option>
														<?php }	
														}
												?> 			
										</select>
									</div>
								</div>
								<div class="form-group col-md-2 margin_top_custome">
									<label for="subject_id">&nbsp;</label>
									<input type="submit" name="invoice_report_payment" Value="<?php esc_attr_e('Go','lawyer_mgt');?>"  class="btn btn-success"/>
								</div>
							</form>
						</div>
						<?php
							if(isset($_POST['invoice_report_payment']))
							{ ?>
								<script type="text/javascript">
									jQuery(document).ready(function($)
									{
										"use strict"; 
										jQuery('#invoice_data_list').DataTable({
											"responsive": true,
											"autoWidth": false,
											"order": [[ 1, "asc" ]],
											language:<?php echo wpnc_datatable_multi_language();?>,
											 "aoColumns":[
														  {"bSortable": true},
														  {"bSortable": true},
														  {"bSortable": true},
														  {"bSortable": true},
														  {"bSortable": true},
														  {"bSortable": true},
														  {"bSortable": true},
														  {"bSortable": true},
														  {"bSortable": true}
													   ]		               		
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
												<table id="invoice_data_list" class="invoice_data_list table table-striped table-bordered">
													<thead>	
														<?php  ?>
														<tr>
															<th><?php  esc_html_e('Invoice Number', 'lawyer_mgt' ) ;?></th>
															<th><?php esc_html_e('Invoice Date', 'lawyer_mgt' ) ;?></th>
															<th><?php esc_html_e('Due Date', 'lawyer_mgt' ) ;?></th>
															<th><?php  esc_html_e('Billing Client Name', 'lawyer_mgt' ) ;?></th>
															<th><?php  esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
															<th> <?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('Total Amount', 'lawyer_mgt' ) ;?></th>
															<th> <?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('Paid Amount', 'lawyer_mgt' ) ;?></th>	
															<th> <?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('Due Amount', 'lawyer_mgt' ) ;?></th>
															<th> <?php esc_html_e('Payment Status', 'lawyer_mgt' ) ;?></th>
														</tr>
														<br/>
													</thead>
													<tbody>
														<?php
														$or=array();
														$or['case_id ='] = (!empty($_REQUEST['case_name']))?sanitize_text_field($_REQUEST['case_name']):NULL;
														$or['user_id ='] = (!empty($_REQUEST['client_name']))?sanitize_text_field($_REQUEST['client_name']):NULL;
														 
														$keys = array_keys($or,"");	
														foreach ($keys as $k)
														{
															
															unset($or[$k]);
														}
													 
														if(!empty($or))
														{
															$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice_data_startdate_enddate_case_client($or);
															 
														}
														if(!empty($invoicedata))
														{													
															foreach ($invoicedata as $retrieved_data)
															{
																$user_id=$retrieved_data->user_id;
																$userdata=get_userdata($user_id);
																$conatc_name=esc_html($userdata->display_name);
																?>
																<tr> 
																
																	<td><?php echo esc_html($retrieved_data->invoice_number);?></td>
																	<td><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->generated_date));?></td>		
																	<td><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->due_date));?></td>
																	<td><?php echo esc_html($conatc_name); ?></td>
																	<?php 	$case_id=$retrieved_data->case_id;
																			$case_name=$obj_invoice->MJ_lawmgt_get_all_case_name_from_case_id($case_id); ?>
																	<td><a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>"><?php echo esc_html($case_name->case_name);?></a></td>
																	<td><?php echo number_format(esc_html($retrieved_data->total_amount),2);?></td>
																	<td><?php echo number_format(esc_html($retrieved_data->paid_amount),2);?></td>
																	<td><?php echo number_format(esc_html($retrieved_data->due_amount),2);?></td>	
																	<td><span class="btn btn-success btn-xs"><?php echo esc_html(MJ_lawmgt_get_invoice_paymentstatus($retrieved_data->id)); ?></span></td>

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
							}
						}
							if($active_tab == 'all_payments_by_case')
							{ 				
									global $wpdb;
									$table_invoice = $wpdb->prefix. 'lmgt_invoice';
									
									$result = $wpdb->get_results("SELECT DISTINCT(case_id) FROM $table_invoice");
									
									$chart_array = array();
									$chart_array[] = array(esc_html__('Case Name','lawyer_mgt'),esc_html__('Total Paid Amount','lawyer_mgt'));
									 
										$user_case_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('cases');
										if($user_role == 'attorney')
										{											
											$attorney_id=get_current_user_id();
											global $wpdb;
											$table_case = $wpdb->prefix. 'lmgt_cases';
											if($user_case_access['own_data'] == '1')
											{
												$attorney_id = get_current_user_id();														
												$casedata = $obj_case->MJ_lawmgt_get_all_case_by_attorney_id($attorney_id);	
											}
											else
											{
												$casedata = $obj_case->MJ_lawmgt_get_all_case();
											}										
											if(!empty($casedata))
											{
												foreach ($casedata as $retrieved_data)
												{
													$id=$retrieved_data->id;
													 
														global $wpdb;
														$table_case = $wpdb->prefix. 'lmgt_cases';
														$table_invoice = $wpdb->prefix. 'lmgt_invoice';

														$case_info = $wpdb->get_row("SELECT * FROM $table_case where id=".$id);			
														$case_name=$case_info->case_name;
														
														
														$total_paid_amount = $wpdb->get_row("SELECT sum(paid_amount) as paid_amount FROM $table_invoice where case_id=".$id);
														
														$chart_array[]=array( "$case_name",(int)$total_paid_amount->paid_amount);

													//}
												}
											}	
										}	
										elseif($user_role == 'client')
										{		
											
											$obj_case=new MJ_lawmgt_case;
											if($user_case_access['own_data'] == '1')
											{
												 
												$casedata = $obj_case->MJ_lawmgt_get_open_and_close_case_by_client();
											}
											else
											{
												 
												$casedata = $obj_case->MJ_lawmgt_get_all_case();
											}
											
											if(!empty($casedata))
											{
												foreach ($casedata as $retrieved_data)
												{
													$case_id=$retrieved_data->id;
											
													global $wpdb;
													$table_case = $wpdb->prefix. 'lmgt_cases';
													$table_invoice = $wpdb->prefix. 'lmgt_invoice';

													$case_info = $wpdb->get_row("SELECT * FROM $table_case where id=".$case_id);			
													$case_name=$case_info->case_name;
													
													
													$total_paid_amount = $wpdb->get_row("SELECT sum(paid_amount) as paid_amount FROM $table_invoice where case_id=".$case_id);
													
													$chart_array[]=array( "$case_name",(int)$total_paid_amount->paid_amount);
												}
											}	
										}
										else
										{
											$obj_case=new MJ_lawmgt_case;
											if($user_case_access['own_data'] == '1')
											{
												 
												$casedata = $obj_case->MJ_lawmgt_get_all_case_created_by();
											}
											else
											{
												 
												$casedata = $obj_case->MJ_lawmgt_get_all_case();
											}
											if(!empty($casedata))
											{
												foreach ($casedata as $retrieved_data)
												{
													$case_id=$retrieved_data->id;
											
													global $wpdb;
													$table_case = $wpdb->prefix. 'lmgt_cases';
													$table_invoice = $wpdb->prefix. 'lmgt_invoice';

													$case_info = $wpdb->get_row("SELECT * FROM $table_case where id=".$case_id);			
													$case_name=$case_info->case_name;
													
													
													$total_paid_amount = $wpdb->get_row("SELECT sum(paid_amount) as paid_amount FROM $table_invoice where case_id=".$case_id);
													
													$chart_array[]=array( "$case_name",(int)$total_paid_amount->paid_amount);
												}
											}
										}		
										
									$options = Array(
											'title' => esc_html__('All Payments By Case Report','lawyer_mgt'),
											'titleTextStyle' => Array('color' => '#222','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
											'legend' =>Array('position' => 'right',
													'textStyle'=> Array('color' => '#222','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans')),
												
											'hAxis' => Array(
													'title' =>  esc_html__('Case Name','lawyer_mgt'),
													'titleTextStyle' => Array('color' => '#222','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
													'textStyle' => Array('color' => '#222','fontSize' => 14),
													'maxAlternation' => 2
											),
											'vAxis' => Array(
													'title' =>  esc_html__('Invoice Amount','lawyer_mgt'),
												 'minValue' => 0,
													//'maxValue' => 5000,
												 'format' => '#',
													'titleTextStyle' => Array('color' => '#222','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
													'textStyle' => Array('color' => '#222','fontSize' => 14)
											)
									);

								require_once LAWMS_PLUGIN_DIR.'/lib/chart/GoogleCharts.class.php';
								$GoogleCharts = new GoogleCharts;
								if(!empty($result))
								{
								$chart = $GoogleCharts->load( 'column' , 'chart_div' )->get( $chart_array , $options );
								
								}

								if(isset($result) && count($result) >0)
								{
									 
									?>
									<div id="chart_div" class="width_100_per_height_500px"></div>
								  
									<!-- Javascript --> 
									
									<script type="text/javascript">
										<?php echo $chart;?>
									</script>
							  <?php 
								}
								if(isset($result) && empty($result))
								{
								?>
									<div class="clear col-lg-12 col-md-12 col-xs-12 col-sm-12"><?php esc_html_e("There is not enough data to generate report.",'lawyer_mgt');?></div>
								<?php 
								}
							}				
						}

						if($active_tab == 'casereport')
						{
							$active_tab = sanitize_text_field(isset($_GET['tab1'])?$_GET['tab1']:'case_by_client_and_casetype'); 
							?>
							<h2>
								<ul id="myTab" class="sub_menu_css line case_nav nav nav-tabs" role="tablist">
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'case_by_client_and_casetype' ? 'active' : ''; ?> menucss">
										<a href="?dashboard=user&page=report&tab=casereport&tab1=case_by_client_and_casetype">
											<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Cases By Client And Practice Area', 'lawyer_mgt'); ?>
										</a>
									</li>

									<li role="presentation" class="<?php echo $active_tab == 'case_report' ? 'active' : ''; ?> menucss">
										<a href="?dashboard=user&page=report&tab=casereport&tab1=case_report">
											<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Addition and Disposal Cases', 'lawyer_mgt'); ?>
										</a>
									</li>
								</ul>	
							</h2> 
							 <?php
							 if($active_tab == 'case_by_client_and_casetype')
							{
							?>
							<script type="text/javascript">
								jQuery(document).ready(function($)
								{
									"use strict"; 
									$('#invoice_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
									 
									$('.sdate').datepicker({										 
										autoclose: true
									}).on('changeDate', function(){
										$('.edate').datepicker('setStartDate', new Date($(this).val()));
									}); 
									
									$('.edate').datepicker({
										 
										autoclose: true
									}).on('changeDate', function(){
										$('.sdate').datepicker('setEndDate', new Date($(this).val()));
									});									 
								});
							</script>
							<div class="panel-body">
								<form method="post" id="invoice_form"> 
									<div class="form-group col-md-12" >
										
										<label  class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('Client Name','lawyer_mgt');?></label>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
											<select class="form-control" name="client_name" id="client_name">	
												<option value=""><?php esc_html_e('Select Client Name','lawyer_mgt');?></option>
												<?php
													$user_client_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('contacts');
													if($user_role == 'attorney')
													{
														if($user_client_access['own_data'] == '1')
														{
															$obj_case=new MJ_lawmgt_case;
															$current_user_id = get_current_user_id();
															$attorney_cases=$obj_case->MJ_lawmgt_get_all_case_by_attorney_id($current_user_id);
															$client_data=array();
															$attorneydata1=array();
															if(!empty($attorney_cases))
															{		
																foreach($attorney_cases as $data)
																{
																	$case_contact_assigned=explode(',',$data->user_id);	
																	if(!empty($case_contact_assigned))
																	{		
																		foreach($case_contact_assigned as $data1)
																		{
																			$client_data[]=$data1;
																		}
																	}
																}	
															}
															$client_unique=array_unique($client_data);
															 if(!empty($client_unique))
															{		
																foreach($client_unique as $data1)
																{
																	$contactdata1[]=get_userdata($data1);
																}	
															}  
															 
															$contactdata_2=$contactdata1; 

															$contactdata_3 = get_users(
																array(
																	'role' => 'client',
																	'meta_query' => array(						
																	array(
																			'key' => 'created_by',
																			'value' =>get_current_user_id(),
																			'compare' => '='
																		),
																	)
																));	
																$contactdata =array_merge($contactdata_2,$contactdata_3);
																
														}
														else			
														{	
															$contactdata =get_users(array('role'=>'client'));	
														}																
															
													}
													elseif($user_role == 'client')
													{
														if($user_client_access['own_data'] == '1')
														{	
															$user_id = get_current_user_id();
															$contactdata=array();
															$contactdata[]=get_userdata($user_id);	
														}
														else			
														{	
															$contactdata =get_users(array('role'=>'client'));
														}																
													}
													else
													{	
														if($user_client_access['own_data'] == '1')
														{
															$contactdata = get_users(
																array(
																	'role' => 'client',
																	'meta_query' => array(						
																	array(
																			'key' => 'created_by',
																			'value' =>get_current_user_id(),
																			'compare' => '='
																		),
																	)
																));	
														}
														else			
														{				
															$contactdata =get_users(array('role'=>'client'));
														}																
													}
															if(!empty($contactdata))
															{
																foreach($contactdata as $retrive_data)
																{  				
															?>						
																	<option value="<?php echo esc_attr($retrive_data->ID);?>"><?php echo esc_html($retrive_data->display_name);?> </option>
															<?php }	
															}
													?> 			
											</select>
										</div>
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('Practice Area','lawyer_mgt');?></label>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" > 	
											<select class="form-control" name="case_type" id="case_type">	
												<option value=""><?php esc_html_e('Select Practice Area','lawyer_mgt');?></option>
												<?php
													$user_case_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('cases');
													if($user_role == 'attorney')
													{
														if($user_case_access['own_data'] == '1')
														{
															$attorney_id = get_current_user_id();														
															$case_data = $obj_case->MJ_lawmgt_get_all_case_by_attorney_and_casetype($attorney_id);	
														}
														else
														{
															$case_data = $obj_case->MJ_lawmgt_get_all_practicearea();
														}		
													}
													else
													{
														if($user_case_access['own_data'] == '1')
														{
															$case_data = $obj_case->MJ_lawmgt_get_all_case_by_clientname_and_casetype_craeted_by();
														}
														else
														{
															$case_data = $obj_case->MJ_lawmgt_get_all_practicearea();
														}		
													}
														
														if(!empty($case_data))
														{
															foreach($case_data as $retrive_data)
															{  				
														?>						
																<option value="<?php echo esc_attr($retrive_data->practice_area_id);?>"><?php echo esc_html(get_the_title($retrive_data->practice_area_id));?> </option>
														<?php }	
														}
													?> 			
											</select>
										</div>
									</div>
									<div class="form-group col-md-2 margin_top_custome">
										<label for="subject_id">&nbsp;</label>
										<input type="submit" name="case_report_template" Value="<?php esc_attr_e('Go','lawyer_mgt');?>"  class="btn btn-success"/>
									</div>
								</form>
							</div>
							<?php
							
								if(isset($_POST['case_report_template']))
								{ ?>
									<script type="text/javascript">
										jQuery(document).ready(function($)
										{
											"use strict"; 
											jQuery('#case_data_list123').DataTable({
												"responsive": true,
												"autoWidth": false,
												"order": [[ 1, "asc" ]],
												language:<?php echo wpnc_datatable_multi_language();?>,
												 "aoColumns":[
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true}
														   ]		               		
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
													<table id="case_data_list123" class="case_data_list table table-striped table-bordered">
														<thead>	
															<?php  ?>
															<tr>
																<th><?php  esc_html_e('Case Number', 'lawyer_mgt' ) ;?></th>
																<th><?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
																<th><?php esc_html_e('Open Date', 'lawyer_mgt' ) ;?></th>
																<th><?php  esc_html_e('Practice Area', 'lawyer_mgt' ) ;?></th>
																<th><?php  esc_html_e('Court Details', 'lawyer_mgt' ) ;?></th>
																<th><?php  esc_html_e('Client Link', 'lawyer_mgt' ) ;?></th>
																<th> <?php esc_html_e('Attorney Name', 'lawyer_mgt' ) ;?></th>
																<th> <?php esc_html_e('Billing Client Name', 'lawyer_mgt' ) ;?></th>
															</tr>
															<br/>
														</thead>
														<tbody>
															<?php
															$or=array();
															$or['user_id ='] = (!empty($_REQUEST['client_name']))?sanitize_text_field($_REQUEST['client_name']):NULL;
															$or['practice_area_id ='] = (!empty($_REQUEST['case_type']))?sanitize_text_field($_REQUEST['case_type']):NULL;
															 
															$keys = array_keys($or,"");	
															foreach ($keys as $k)
															{
																unset($or[$k]);
															}
															if(!empty($or))
															{
																 
 
																$user_case_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('report');
																 
																if($user_role == 'attorney')
																{
																	if($user_case_access['own_data'] == '1')
																	{
																		$attorney_id = get_current_user_id();														
																		$case_data123 = $obj_case->MJ_lawmgt_get_all_case_by_clientname_and_casetype_owndata($or);	
																	}
																	else
																	{
																		$case_data123 = $obj_case->MJ_lawmgt_get_all_practicearea_new($or);
																		 
																	}		
																}
																else
																{
																	if($user_case_access['own_data'] == '1')
																	{
																		$case_data123 = $obj_case->MJ_lawmgt_get_all_case_created_by_casetype_new($or);
																	}
																	else
																	{
																		$case_data123 = $obj_case->MJ_lawmgt_get_all_practicearea_new($or);
																	}		
																}
															}
															 
															if(!empty($case_data123))
															{	
																 					
																foreach ($case_data123 as $retrieved_data)
																{
																	?>
																	<tr> 
																	
																		<td><?php echo esc_html($retrieved_data->case_number);?></td>
																		<td><?php echo esc_html($retrieved_data->case_name);?></td>
																		<td><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->open_date)); ?></td>
																		<td><?php echo esc_html(get_the_title($retrieved_data->practice_area_id));?></td>
																		<td><?php echo esc_html(get_the_title($retrieved_data->court_id)); ?> - <?php echo esc_html(get_the_title($retrieved_data->state_id)); ?> - <?php echo esc_html(get_the_title($retrieved_data->bench_id)); ?></td>
																		<td><?php
																			$result=get_userdata($retrieved_data->user_id);
																			echo esc_html($result->display_name);?>
																		</td>
																		<td><?php
																			$user=explode(",",$retrieved_data->case_assgined_to);
																			$case_assgined_to=array();
																			if(!empty($user))
																			{						
																				foreach($user as $data4)
																				{
																					$case_assgined_to[]=MJ_lawmgt_get_display_name($data4);
																				}
																			}												
																			echo esc_html(implode(", ",$case_assgined_to));
																			?>
																		</td>
																		<td><?php
																			$result2=get_userdata($retrieved_data->billing_contact_id);
																			echo esc_html($result2->display_name);?>
																		</td>
																		 
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
								}
							}
							if($active_tab == 'case_report')
							{
							?>
								<script type="text/javascript">
								jQuery(document).ready(function($)
								{
									"use strict"; 
									$('#case_reports').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
									 
									$('.sdate').datepicker({										 
										autoclose: true
									}).on('changeDate', function(){
										$('.edate').datepicker('setStartDate', new Date($(this).val()));
									}); 									
									 
									$('.edate').datepicker({										 
										autoclose: true
									}).on('changeDate', function(){
										$('.sdate').datepicker('setEndDate', new Date($(this).val()));
									});									 
								});
							</script>
							<div class="panel-body">
									<form method="post" id="case_reports">  
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css date_css_new" for="exam_id"><?php esc_html_e('Start Date','lawyer_mgt');?><span class="require-field">*</span></label>
									<div class="form-group col-md-2" >
										<input type="text" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>"  class="form-control sdate has-feedback-left validate[required]" name="sdate" 
										value="<?php if(isset($_REQUEST['sdate'])) echo esc_attr($_REQUEST['sdate']);?>" readonly>
										<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>	
									</div>
									<label  class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css date_css_new" for="exam_id"><?php esc_html_e('End Date','lawyer_mgt');?><span class="require-field">*</span></label>
									<div class="form-group col-md-2" >
											<input type="text"  class="form-control edate has-feedback-left validate[required]" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>" name="edate" 
											value="<?php if(isset($_REQUEST['edate'])) echo esc_attr($_REQUEST['edate']);?>" readonly>
									<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>			
									</div>
									<div class="form-group col-md-2">
										<label for="subject_id">&nbsp;</label>
										<input type="submit" name="case_report_addition" Value="<?php esc_attr_e('Go','lawyer_mgt');?>"  class="btn btn-success"/>
									</div>
										
									</form>
							</div>
							<?php
								if(isset($_POST['case_report_addition']))
								{ ?>
									<script type="text/javascript">
										jQuery(document).ready(function($)
										{
											"use strict"; 
											jQuery('#case_data_list').DataTable({
												"responsive": true,
												"autoWidth": false,
												"order": [[ 1, "asc" ]],
												language:<?php echo wpnc_datatable_multi_language();?>,
												 "aoColumns":[
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true}
														   ]		               		
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
													<table id="case_data_list" class="case_data_list table table-striped table-bordered">
														<thead>	
															<?php  ?>
															<tr>
																<th><?php  esc_html_e('Case Number', 'lawyer_mgt' ) ;?></th>
																<th><?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
																<th><?php esc_html_e('Open Date', 'lawyer_mgt' ) ;?></th>
																<th><?php  esc_html_e('Practice Area', 'lawyer_mgt' ) ;?></th>
																<th><?php  esc_html_e('Court Details', 'lawyer_mgt' ) ;?></th>
																<th><?php  esc_html_e('Client Link', 'lawyer_mgt' ) ;?></th>
																<th> <?php esc_html_e('Attorney Name', 'lawyer_mgt' ) ;?></th>
																<th> <?php esc_html_e('Case Status', 'lawyer_mgt' ) ;?></th>
																<th> <?php esc_html_e('Billing Client Name', 'lawyer_mgt' ) ;?></th>
															</tr>
															<br/>
														</thead>
														<tbody>
															<?php
															$or=array();
															$or['open_date >='] = ($_REQUEST['sdate'] != "")?sanitize_text_field(date("Y-m-d",strtotime($_REQUEST['sdate']))):NULL;
															$or['open_date <='] = ($_REQUEST['edate'] != "")?sanitize_text_field(date("Y-m-d",strtotime($_REQUEST['edate']))):NULL;
															 
															$keys = array_keys($or,"");	
															foreach ($keys as $k)
															{
																
																unset($or[$k]);
															}
														 
															if(!empty($or))
															{
																 
																$case_data=$obj_case->MJ_lawmgt_get_all_case_by_additioncase_and_disposalcase($or);
																 
															}
															 
															if(!empty($case_data))
															{	
																						
																foreach ($case_data as $retrieved_data)
																{
																	?>
																	<tr> 
																	
																		<td><?php echo esc_html($retrieved_data->case_number);?></td>
																		<td><?php echo esc_html($retrieved_data->case_name);?></td>
																		<td><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->open_date));?></td>
																		<td><?php echo esc_html(get_the_title($retrieved_data->practice_area_id));?></td>
																		<td><?php echo esc_html(get_the_title($retrieved_data->court_id)); ?> - <?php echo esc_html(get_the_title($retrieved_data->state_id)); ?> - <?php echo esc_html(get_the_title($retrieved_data->bench_id)); ?></td>
																		<td><?php
																			$result=get_userdata($retrieved_data->user_id);
																			echo esc_html($result->display_name);?>
																		</td>
																		<td><?php
																			$user=explode(",",$retrieved_data->case_assgined_to);
																			$case_assgined_to=array();
																			if(!empty($user))
																			{						
																				foreach($user as $data4)
																				{
																					$case_assgined_to[]=esc_html(MJ_lawmgt_get_display_name($data4));
																				}
																			}												
																			echo esc_html(implode(", ",$case_assgined_to));
																			?>
																		</td>
																		<td><?php echo esc_html($retrieved_data->case_status); ?></td>
																		<td><?php
																			$result2=get_userdata($retrieved_data->billing_contact_id);
																			echo esc_html($result2->display_name);?>
																		</td>
																		 
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
								}
							}
							?>
						<?php  
						}   
						if($active_tab == 'invoicereport')
						{
							$active_tab = sanitize_text_field(isset($_GET['tab1'])?$_GET['tab1']:'invoice_by_case_and_client'); 
							?>
							<h2>
								<ul id="myTab" class="sub_menu_css line case_nav nav nav-tabs" role="tablist">
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'invoice_by_case_and_client' ? 'active' : ''; ?> menucss">
											<a href="?dashboard=user&page=report&tab=invoicereport&tab1=invoice_by_case_and_client">
												<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Invoice By Case And Client', 'lawyer_mgt'); ?>
											</a>
									</li>
								</ul>	
							</h2> 
							 <?php
							 if($active_tab == 'invoice_by_case_and_client')
							{
							?>
								<script type="text/javascript">
								jQuery(document).ready(function($)
								{
									"use strict"; 	
									$('#invoice_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
									 
									$('.sdate').datepicker({										 
										autoclose: true
									}).on('changeDate', function(){
										$('.edate').datepicker('setStartDate', new Date($(this).val()));
									}); 
									 
									$('.edate').datepicker({										 
										autoclose: true
									}).on('changeDate', function(){
										$('.sdate').datepicker('setEndDate', new Date($(this).val()));
									});									 
								});
							</script>
							<div class="panel-body">
								<form method="post" id="invoice_form"> 
									<div class="form-group col-md-12" >
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('Start Date','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" > 	
											<input type="text" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>"  placeholder="<?php esc_html_e('Select Start Date','lawyer_mgt');?>"  class="form-control sdate has-feedback-left validate[required]" name="sdate" 
											value="<?php if(isset($_REQUEST['sdate'])) echo esc_attr($_REQUEST['sdate']);?>" readonly>
											<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>	
										</div>
										<label  class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('End Date','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
												<input type="text"  class="form-control edate has-feedback-left validate[required]" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>"  placeholder="<?php esc_html_e('Select End Date','lawyer_mgt');?>" name="edate" 
												value="<?php if(isset($_REQUEST['edate'])) echo esc_attr($_REQUEST['edate']);?>" readonly>
										<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>			
										</div>
									</div>
									<div class="form-group col-md-12 margin_top_custome">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('Case Name','lawyer_mgt');?></label>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" > 	
											<select class="form-control" name="case_name" id="case_name">	
												<option value=""><?php esc_html_e('Select Case Name','lawyer_mgt');?></option>
												<?php
														$obj_case=new  MJ_lawmgt_case;
														$user_case_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('cases');
													if($user_role == 'attorney')
													{
														if($user_case_access['own_data'] == '1')
														{
															$attorney_id = get_current_user_id();														
															$case_data = $obj_case->MJ_lawmgt_get_all_case_by_attorney_id($attorney_id);	
														}
														else
														{
															$case_data = $obj_case->MJ_lawmgt_get_all_case();
														}		
													}
													else
													{
														if($user_case_access['own_data'] == '1')
														{
															$case_data = $obj_case->MJ_lawmgt_get_all_case_created_by();
														}
														else
														{
															$case_data = $obj_case->MJ_lawmgt_get_all_case();
														}		
													}				
														
														if(!empty($case_data))
														{
															foreach($case_data as $retrive_data)
															{  				
														?>						
																<option value="<?php echo esc_attr($retrive_data->id);?>"><?php echo esc_html($retrive_data->case_name);?> </option>
														<?php }	
														}
													?> 			
											</select>
										</div>
										<label  class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('Client Name','lawyer_mgt');?></label>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
											<select class="form-control" name="client_name" id="client_name">	
												<option value=""><?php esc_html_e('Select Client Name','lawyer_mgt');?></option>
												<?php
														$user_client_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('contacts');
														if($user_role == 'attorney')
														{
															if($user_client_access['own_data'] == '1')
															{
																$obj_case=new MJ_lawmgt_case;
																$current_user_id = get_current_user_id();
																$attorney_cases=$obj_case->MJ_lawmgt_get_all_case_by_attorney_id($current_user_id);
																$client_data=array();
																$attorneydata1=array();
																if(!empty($attorney_cases))
																{		
																	foreach($attorney_cases as $data)
																	{
																		$case_contact_assigned=explode(',',$data->user_id);	
																		if(!empty($case_contact_assigned))
																		{		
																			foreach($case_contact_assigned as $data1)
																			{
																				$client_data[]=$data1;
																			}
																		}
																	}	
																}
																$client_unique=array_unique($client_data);
																 if(!empty($client_unique))
																{		
																	foreach($client_unique as $data1)
																	{
																		$contactdata1[]=get_userdata($data1);
																	}	
																}  
																 
																$contactdata_2=$contactdata1; 

																$contactdata_3 = get_users(
																	array(
																		'role' => 'client',
																		'meta_query' => array(						
																		array(
																				'key' => 'created_by',
																				'value' =>get_current_user_id(),
																				'compare' => '='
																			),
																		)
																	));	
																	$contactdata =array_merge($contactdata_2,$contactdata_3);
																	
															}
															else			
															{	
																$contactdata =get_users(array('role'=>'client'));	
															}																
																
														}
														elseif($user_role == 'client')
														{
															if($user_client_access['own_data'] == '1')
															{	
																$user_id = get_current_user_id();
																$contactdata=array();
																$contactdata[]=get_userdata($user_id);	
															}
															else			
															{	
																$contactdata =get_users(array('role'=>'client'));
															}																
														}
														else
														{	
															if($user_client_access['own_data'] == '1')
															{
																$contactdata = get_users(
																	array(
																		'role' => 'client',
																		'meta_query' => array(						
																		array(
																				'key' => 'created_by',
																				'value' =>get_current_user_id(),
																				'compare' => '='
																			),
																		)
																	));	
															}
															else			
															{				
																$contactdata =get_users(array('role'=>'client'));
															}																
														}
															if(!empty($contactdata))
															{
																foreach($contactdata as $retrive_data)
																{  				
															?>						
																	<option value="<?php echo esc_attr($retrive_data->ID);?>"><?php echo esc_html($retrive_data->display_name);?> </option>
															<?php }	
															}
													?> 			
											</select>
										</div>
										
									</div>
									<div class="form-group col-md-12 margin_top_custome">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('Payment Status','lawyer_mgt');?></label>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" > 	
											<select class="form-control" name="payment_status" id="payment_status">	
												<option value=""><?php esc_html_e('Select Payment Status','lawyer_mgt');?></option>
												<option value="Not Paid"><?php esc_html_e('Not Paid','lawyer_mgt');?></option>
												<option value="Partially Paid"><?php esc_html_e('Partially Paid','lawyer_mgt');?></option>
												<option value="Fully Paid"><?php esc_html_e('Fully Paid','lawyer_mgt');?></option>
											</select>
										</div>
										 
									</div>
									<div class="form-group col-md-2 margin_top_custome">
										<label for="subject_id">&nbsp;</label>
										<input type="submit" name="invoice_report_template" Value="<?php esc_attr_e('Go','lawyer_mgt');?>"  class="btn btn-success"/>
									</div>
								</form>
							</div>
							<?php
								if(isset($_POST['invoice_report_template']))
								{ ?>
									<script type="text/javascript">
										jQuery(document).ready(function($)
										{
											"use strict"; 
											jQuery('#invoice_data_list').DataTable({
												"responsive": true,
												"autoWidth": false,
												"order": [[ 1, "asc" ]],
												language:<?php echo wpnc_datatable_multi_language();?>,
												 "aoColumns":[
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true},
															  {"bSortable": true}
														   ]		               		
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
													<table id="invoice_data_list" class="invoice_data_list table table-striped table-bordered">
														<thead>	
															<?php  ?>
															<tr>
																<th><?php  esc_html_e('Invoice Number', 'lawyer_mgt' ) ;?></th>
																<th><?php esc_html_e('Invoice Date', 'lawyer_mgt' ) ;?></th>
																<th><?php esc_html_e('Due Date', 'lawyer_mgt' ) ;?></th>
																<th><?php  esc_html_e('Billing Client Name', 'lawyer_mgt' ) ;?></th>
																<th><?php  esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
																<th> <?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('Total Amount', 'lawyer_mgt' ) ;?></th>
																<th> <?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('Paid Amount', 'lawyer_mgt' ) ;?></th>	
																<th> <?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('Due Amount', 'lawyer_mgt' ) ;?></th>
																<th> <?php esc_html_e('Payment Status', 'lawyer_mgt' ) ;?></th>
															</tr>
															<br/>
														</thead>
														<tbody>
															<?php
															$or=array();
															
															$or['generated_date >='] = ($_REQUEST['sdate'] != "")?sanitize_text_field(date("Y-m-d",strtotime($_REQUEST['sdate']))):NULL;
															$or['generated_date <='] = ($_REQUEST['edate'] != "")?sanitize_text_field(date("Y-m-d",strtotime($_REQUEST['edate']))):NULL;
															$or['case_id ='] = (!empty($_REQUEST['case_name']))?sanitize_text_field($_REQUEST['case_name']):NULL;
															$or['user_id ='] = (!empty($_REQUEST['client_name']))?sanitize_text_field($_REQUEST['client_name']):NULL;
															$or['payment_status ='] = (!empty($_REQUEST['payment_status']))?sanitize_text_field($_REQUEST['payment_status']):NULL;
															 
															$keys = array_keys($or,"");	
															foreach ($keys as $k)
															{
																unset($or[$k]);
															}
														 
															if(!empty($or))
															{
																$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice_data_startdate_enddate_case_client($or);
															}
															if(!empty($invoicedata))
															{													
																foreach ($invoicedata as $retrieved_data)
																{
																	$user_id=$retrieved_data->user_id;
																	$userdata=get_userdata($user_id);
																	$conatc_name=esc_html($userdata->display_name);
																	?>
																	<tr> 
																	
																		<td><?php echo esc_html($retrieved_data->invoice_number);?></td>
																		<td><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->generated_date));?></td>		
																		<td><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->due_date));?></td>
																		<td><?php echo esc_html($conatc_name);?></td>
																		<?php 	$case_id=$retrieved_data->case_id;
																				$case_name=$obj_invoice->MJ_lawmgt_get_all_case_name_from_case_id($case_id); ?>
																		<td><a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>"><?php echo esc_html($case_name->case_name);?></a></td>
																		<td><?php echo number_format(esc_html($retrieved_data->total_amount),2);?></td>
																		<td><?php echo number_format(esc_html($retrieved_data->paid_amount),2);?></td>
																		<td><?php echo number_format(esc_html($retrieved_data->due_amount),2);?></td>	
																		<td><span class="btn btn-success btn-xs"><?php echo esc_html(MJ_lawmgt_get_invoice_paymentstatus($retrieved_data->id)); ?></span></td>

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
								}
							}
						}  
						if($active_tab == 'expensereport')
						{
							$active_tab = sanitize_text_field(isset($_GET['tab1'])?$_GET['tab1']:'expense_by_case_and_client'); 
							 
							?>
							<h2>
								<ul id="myTab" class="sub_menu_css line case_nav nav nav-tabs" role="tablist">
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'expense_by_case_and_client' ? 'active' : ''; ?> menucss">
											<a href="?dashboard=user&page=report&tab=expensereport&tab1=expense_by_case_and_client">
												<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Expenses By Case And Client', 'lawyer_mgt'); ?>
											</a>
									</li>	
									<li role="presentation" class="<?php echo $active_tab == 'expense_by_case' ? 'active' : ''; ?> menucss">
											<a href="?dashboard=user&page=report&tab=expensereport&tab1=expense_by_case">
												<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('All Expenses By Case Report', 'lawyer_mgt'); ?>
											</a>
									</li>
								</ul>
							</h2> 
							 <?php
							 if($active_tab == 'expense_by_case_and_client')
							{
							?>
								<script  type="text/javascript">
									jQuery(document).ready(function($)
									{
										"use strict"; 
										$('#invoice_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
										 
										$('.sdate').datepicker({											 
											autoclose: true
										}).on('changeDate', function(){
											$('.edate').datepicker('setStartDate', new Date($(this).val()));
										}); 
										$('.edate').datepicker({											 
											autoclose: true
										}).on('changeDate', function(){
											$('.sdate').datepicker('setEndDate', new Date($(this).val()));
										});										 
									});
								</script>
								<div class="panel-body">
									<form method="post" id="invoice_form"> 
										<div class="form-group col-md-12" >
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('Start Date','lawyer_mgt');?><span class="require-field">*</span></label>
											<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" > 	
												<input type="text" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>"  placeholder="<?php esc_html_e('Select Start Date','lawyer_mgt');?>"  class="form-control sdate has-feedback-left validate[required]" name="sdate" 
												value="<?php if(isset($_REQUEST['sdate'])) echo esc_attr($_REQUEST['sdate']);?>" readonly>
												<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>	
											</div>
											<label  class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('End Date','lawyer_mgt');?><span class="require-field">*</span></label>
											<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
													<input type="text"  class="form-control edate has-feedback-left validate[required]" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>"  placeholder="<?php esc_html_e('Select End Date','lawyer_mgt');?>" name="edate" 
													value="<?php if(isset($_REQUEST['edate'])) echo esc_attr($_REQUEST['edate']);?>" readonly>
											<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>			
											</div>
										</div>
										<div class="form-group col-md-12 margin_top_custome">
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('Case Name','lawyer_mgt');?></label>
											<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" > 	
												<select class="form-control" name="case_name" id="case_name">	
													<option value=""><?php esc_html_e('Select Case Name','lawyer_mgt');?></option>
													<?php
															$obj_case=new  MJ_lawmgt_case;
															$user_case_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('cases');
													if($user_role == 'attorney')
													{
														if($user_case_access['own_data'] == '1')
														{
															$attorney_id = get_current_user_id();														
															$case_data = $obj_case->MJ_lawmgt_get_all_case_by_attorney_id($attorney_id);	
														}
														else
														{
															$case_data = $obj_case->MJ_lawmgt_get_all_case();

														}		
													}
													else
													{
														if($user_case_access['own_data'] == '1')
														{
															$case_data = $obj_case->MJ_lawmgt_get_all_case_created_by();
														}
														else
														{
															$case_data = $obj_case->MJ_lawmgt_get_all_case();
														}		
													}				
															
															if(!empty($case_data))
															{
																foreach($case_data as $retrive_data)
																{  				
															?>						
																	<option value="<?php echo esc_attr($retrive_data->id);?>"><?php echo esc_html($retrive_data->case_name);?> </option>
															<?php }	
															}
														?> 			
												</select>
											</div>
											<label  class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('Client Name','lawyer_mgt');?></label>
											<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
												<select class="form-control" name="client_name" id="client_name">	
													<option value=""><?php esc_html_e('Select Client Name','lawyer_mgt');?></option>
													<?php
															$user_client_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('contacts');
															if($user_role == 'attorney')
															{
																if($user_client_access['own_data'] == '1')
																{
																	$obj_case=new MJ_lawmgt_case;
																	$current_user_id = get_current_user_id();
																	$attorney_cases=$obj_case->MJ_lawmgt_get_all_case_by_attorney_id($current_user_id);
																	$client_data=array();
																	$attorneydata1=array();
																	if(!empty($attorney_cases))
																	{		
																		foreach($attorney_cases as $data)
																		{
																			$case_contact_assigned=explode(',',$data->user_id);	
																			if(!empty($case_contact_assigned))
																			{		
																				foreach($case_contact_assigned as $data1)
																				{
																					$client_data[]=$data1;
																				}
																			}
																		}	
																	}
																	$client_unique=array_unique($client_data);
																	 if(!empty($client_unique))
																	{		
																		foreach($client_unique as $data1)
																		{
																			$contactdata1[]=get_userdata($data1);
																		}	
																	}  
																	 
																	$contactdata_2=$contactdata1; 

																	$contactdata_3 = get_users(
																		array(
																			'role' => 'client',
																			'meta_query' => array(						
																			array(
																					'key' => 'created_by',
																					'value' =>get_current_user_id(),
																					'compare' => '='
																				),
																			)
																		));	
																		$contactdata =array_merge($contactdata_2,$contactdata_3);
																		
																}
																else			
																{	
																	$contactdata =get_users(array('role'=>'client'));	
																}																
																	
															}
															elseif($user_role == 'client')
															{
																if($user_client_access['own_data'] == '1')
																{	
																	$user_id = get_current_user_id();
																	$contactdata=array();
																	$contactdata[]=get_userdata($user_id);	
																}
																else			
																{	
																	$contactdata =get_users(array('role'=>'client'));
																}																
															}
															else
															{	
																if($user_client_access['own_data'] == '1')
																{
																	$contactdata = get_users(
																		array(
																			'role' => 'client',
																			'meta_query' => array(						
																			array(
																					'key' => 'created_by',
																					'value' =>get_current_user_id(),
																					'compare' => '='
																				),
																			)
																		));	
																}
																else			
																{				
																	$contactdata =get_users(array('role'=>'client'));
																}																
															}
																if(!empty($contactdata))
																{
																	foreach($contactdata as $retrive_data)
																	{  				
																?>						
																		<option value="<?php echo esc_attr($retrive_data->ID);?>"><?php echo esc_html($retrive_data->display_name);?> </option>
																<?php }	
																}
														?> 			
												</select>
											</div>
											
										</div>
										 
										<div class="form-group col-md-2 margin_top_custome">
											<label for="subject_id">&nbsp;</label>
											<input type="submit" name="Expenses_report_template" Value="<?php esc_attr_e('Go','lawyer_mgt');?>"  class="btn btn-success"/>
										</div>
									</form>
								</div>
								<?php
									if(isset($_POST['Expenses_report_template']))
									{ ?>
										<script type="text/javascript">
											jQuery(document).ready(function($)
											{
												"use strict"; 
												jQuery('#invoice_data_list').DataTable({
													"responsive": true,
													"autoWidth": false,
													"order": [[ 1, "asc" ]],
													language:<?php echo wpnc_datatable_multi_language();?>,
													 "aoColumns":[
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true}
															   ]		               		
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
														<table id="invoice_data_list" class="invoice_data_list table table-striped table-bordered">
															<thead>	
																<?php  ?>
																<tr>
																	<th><?php  esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
																	<th><?php esc_html_e('Client Name', 'lawyer_mgt' ) ;?></th>
																	<th><?php esc_html_e('Expense Activity', 'lawyer_mgt' ) ;?></th>
																	<th><?php  esc_html_e('Expense Date', 'lawyer_mgt' ) ;?></th>
																	<th><?php  esc_html_e('Quantity', 'lawyer_mgt' ) ;?></th>
																	<th> <?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('Price', 'lawyer_mgt' ) ;?></th>
																	<th> <?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('SubTotal', 'lawyer_mgt' ) ;?></th>	
																	<th> <?php esc_html_e('Discount(%)', 'lawyer_mgt' ) ;?></th>
																	<th> <?php esc_html_e('Tax', 'lawyer_mgt' ) ;?></th>
																	
																</tr>
																<br/>
															</thead>
															<tbody>
																<?php
																$or=array();
																
																$or['expense_date >='] = ($_REQUEST['sdate'] != "")?sanitize_text_field(date("Y-m-d",strtotime($_REQUEST['sdate']))):NULL;
																$or['expense_date <='] = ($_REQUEST['edate'] != "")?sanitize_text_field(date("Y-m-d",strtotime($_REQUEST['edate']))):NULL;
																$or['case_id ='] = (!empty($_REQUEST['case_name']))?sanitize_text_field($_REQUEST['case_name']):NULL;
																$or['user_id ='] = (!empty($_REQUEST['client_name']))?sanitize_text_field($_REQUEST['client_name']):NULL;
																 
																$keys = array_keys($or,"");	
																foreach ($keys as $k)
																{
																	unset($or[$k]);
																}
															 
																if(!empty($or))
																{
																	$expensesdata=$obj_invoice->MJ_lawmgt_get_all_expenses_data_startdate_enddate_case_client($or);
																}
																if(!empty($expensesdata))
																{													
																	foreach ($expensesdata as $retrieved_data)
																	{
																		 
																		if(!empty($retrieved_data->expenses_entry_tax))
																		{
																			 $tax_id=explode(',',$retrieved_data->expenses_entry_tax);
																			 
																			 $tax_name=array();
																			if(!empty($tax_id))
																			{						
																				foreach($tax_id as $data)
																				{
																					$tax_name[]=esc_html(MJ_lawmgt_get_tax_name($data));
																				}
																			}
																		}
																		?>
																		<tr> 
																			<td><?php 
																			$case_id=esc_attr($retrieved_data->case_id);
																			$case_name=$obj_invoice->MJ_lawmgt_get_all_case_name_from_case_id($case_id);
																			echo esc_html($case_name->case_name);?></td>
																			<td><?php
																			$userdata=get_userdata($retrieved_data->user_id);
																			echo esc_html($userdata->display_name);?></td>		
																			<td><?php echo esc_html($retrieved_data->expense);?></td>
																			<td><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->expense_date));?></td>
																			<td><?php echo esc_html($retrieved_data->quantity);?></td> 
																			<td><?php echo number_format(esc_html($retrieved_data->price),2);?></td>
																			<td><?php echo number_format(esc_html($retrieved_data->subtotal),2);?></td>
																			<td><?php echo esc_html($retrieved_data->expenses_entry_discount);?></td>
																			<td><?php if(!empty($retrieved_data->expenses_entry_tax))
																			{
																				echo esc_html(implode(",",$tax_name));
																			}
																			else
																			{
																				echo "-";
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
									}
							}
							if($active_tab == 'expense_by_case')
							{
 
								global $wpdb;
								$table_invoice = $wpdb->prefix. 'lmgt_invoice';
								$table_invoice_expenses = $wpdb->prefix. 'lmgt_invoice_expenses';
								$table_case = $wpdb->prefix. 'lmgt_cases';
								
								$result = $wpdb->get_results("SELECT DISTINCT(case_id) FROM $table_invoice");
								
								$chart_array = array();
								$chart_array[] = array(esc_html__('Case Name','lawyer_mgt'),esc_html__('Total Expense Amount','lawyer_mgt'));
								if(!empty($result))
								{
									foreach($result as $r)
									{
										$case_id=$r->case_id;
										$case_name = $wpdb->get_row("SELECT case_name FROM $table_case where id=".$case_id);
										$total_expense = $wpdb->get_row("SELECT sum($table_invoice_expenses.subtotal) as total_expense  FROM 	$table_invoice_expenses
										INNER JOIN $table_invoice
										ON $table_invoice.id=$table_invoice_expenses.invoice_id And $table_invoice.case_id=".$case_id);	
									
										$chart_array[]=array( "$case_name->case_name",round($total_expense->total_expense));
									}
								}
								$options = Array(
										'title' => esc_html__('Expenses By Case Report','lawyer_mgt'),
										'titleTextStyle' => Array('color' => '#222','fontSize' => 13,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
										'legend' =>Array('position' => 'right',
												'textStyle'=> Array('color' => '#222','fontSize' => 13,'bold'=>true,'italic'=>false,'fontName' =>'open sans')),
											
										'hAxis' => Array(
												'title' =>  esc_html__('Case Name','lawyer_mgt'),
												'titleTextStyle' => Array('color' => '#222','fontSize' => 13,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
												'textStyle' => Array('color' => '#222','fontSize' => 13),
												'maxAlternation' => 2
										),
										'vAxis' => Array(
												'title' =>  esc_html__('Expense Amount','lawyer_mgt'),
											 'minValue' => 0,
												//'maxValue' => 5000,
											 'format' => '#',
												'titleTextStyle' => Array('color' => '#222','fontSize' => 13,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
												'textStyle' => Array('color' => '#222','fontSize' => 13)
										)
								);


								require_once LAWMS_PLUGIN_DIR.'/lib/chart/GoogleCharts.class.php';
								$GoogleCharts = new GoogleCharts;
								if(!empty($result))
								{
									$chart = $GoogleCharts->load( 'column' , 'chart_div' )->get( $chart_array , $options );
								}

									if(isset($result) && count($result) >0)
									{
									?>
									<div id="chart_div" class="width_100_per_height_500px"></div>
								  
								  <!-- Javascript --> 
								  
								  <script type="text/javascript">
											<?php echo $chart;?>
									</script>
								  <?php }
								 if(isset($result) && empty($result))
								 {?>
									<div class="clear col-md-12"><?php esc_html_e("There is not enough data to generate report.",'lawyer_mgt');?></div>
								<?php } 
							} 
						}
						if($active_tab == 'timeentriereport')
						{
							$active_tab = sanitize_text_field(isset($_GET['tab1'])?$_GET['tab1']:'timeentries_by_case_and_contact'); 
							 
							?>
								<h2>
									<ul id="myTab" class="sub_menu_css line case_nav nav nav-tabs" role="tablist">
										<li role="presentation" class="<?php echo esc_html($active_tab) == 'timeentries_by_case_and_contact' ? 'active' : ''; ?> menucss">
												<a href="?dashboard=user&page=report&tab=timeentriereport&tab1=timeentries_by_case_and_contact">
													<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Time Entries By Case And Client', 'lawyer_mgt'); ?>
												</a>
										</li>	
										<li role="presentation" class="<?php echo $active_tab == 'timeentries_by_case' ? 'active' : ''; ?> menucss">
												<a href="?dashboard=user&page=report&tab=timeentriereport&tab1=timeentries_by_case">
													<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Time Entries By Case', 'lawyer_mgt'); ?>
												</a>
										</li>	
									</ul>
								</h2> 
							 <?php
							 if($active_tab == 'timeentries_by_case_and_contact')
							{
							?>
								<script type="text/javascript">
									jQuery(document).ready(function($)
									{
										"use strict"; 
										$('#invoice_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
										 
										$('.sdate').datepicker({											 
											autoclose: true
										}).on('changeDate', function(){
											$('.edate').datepicker('setStartDate', new Date($(this).val()));
										}); 
										
										 
										$('.edate').datepicker({											 
											autoclose: true
										}).on('changeDate', function(){
											$('.sdate').datepicker('setEndDate', new Date($(this).val()));
										});										 
									});
								</script>
								<div class="panel-body">
									<form method="post" id="invoice_form"> 
										<div class="form-group col-md-12" >
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('Start Date','lawyer_mgt');?><span class="require-field">*</span></label>
											<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" > 	
												<input type="text" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>"  placeholder="<?php esc_html_e('Select Start Date','lawyer_mgt');?>"  class="form-control sdate has-feedback-left validate[required]" name="sdate" 
												value="<?php if(isset($_REQUEST['sdate'])) echo esc_attr($_REQUEST['sdate']);?>" readonly>
												<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>	
											</div>
											<label  class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('End Date','lawyer_mgt');?><span class="require-field">*</span></label>
											<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
													<input type="text"  class="form-control edate has-feedback-left validate[required]" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>"  placeholder="<?php esc_html_e('Select End Date','lawyer_mgt');?>" name="edate" 
													value="<?php if(isset($_REQUEST['edate'])) echo esc_attr($_REQUEST['edate']);?>" readonly>
											<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>			
											</div>
										</div>
										<div class="form-group col-md-12 margin_top_custome">
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('Case Name','lawyer_mgt');?></label>
											<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" > 	
												<select class="form-control" name="case_name" id="case_name">	
													<option value=""><?php esc_html_e('Select Case Name','lawyer_mgt');?></option>
													<?php
													$obj_case=new  MJ_lawmgt_case;
													$user_case_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('cases');
													if($user_role == 'attorney')
													{
														if($user_case_access['own_data'] == '1')
														{
															$attorney_id = get_current_user_id();														
															$case_data = $obj_case->MJ_lawmgt_get_all_case_by_attorney_id($attorney_id);	
														}
														else
														{
															$case_data = $obj_case->MJ_lawmgt_get_all_case();
														}		
													}
													else
													{
														if($user_case_access['own_data'] == '1')
														{
															$case_data = $obj_case->MJ_lawmgt_get_all_case_created_by();
														}
														else
														{
															$case_data = $obj_case->MJ_lawmgt_get_all_case();
														}		
													}				
															
															if(!empty($case_data))
															{
																foreach($case_data as $retrive_data)
																{  				
															?>						
																	<option value="<?php echo esc_attr($retrive_data->id);?>"><?php echo esc_html($retrive_data->case_name);?> </option>
															<?php }	
															}
														?> 			
												</select>
											</div>
											<label  class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('Client Name','lawyer_mgt');?></label>
											<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
												<select class="form-control" name="client_name" id="client_name">	
													<option value=""><?php esc_html_e('Select Client Name','lawyer_mgt');?></option>
													<?php
															$user_client_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('contacts');
															if($user_role == 'attorney')
															{
																if($user_client_access['own_data'] == '1')
																{
																	$obj_case=new MJ_lawmgt_case;
																	$current_user_id = get_current_user_id();
																	$attorney_cases=$obj_case->MJ_lawmgt_get_all_case_by_attorney_id($current_user_id);
																	$client_data=array();
																	$attorneydata1=array();
																	if(!empty($attorney_cases))
																	{		
																		foreach($attorney_cases as $data)
																		{
																			$case_contact_assigned=explode(',',$data->user_id);	
																			if(!empty($case_contact_assigned))
																			{		
																				foreach($case_contact_assigned as $data1)
																				{
																					$client_data[]=$data1;
																				}
																			}
																		}	
																	}
																	$client_unique=array_unique($client_data);
																	 if(!empty($client_unique))
																	{		
																		foreach($client_unique as $data1)
																		{
																			$contactdata1[]=get_userdata($data1);
																		}	
																	}  
																	 
																	$contactdata_2=$contactdata1; 

																	$contactdata_3 = get_users(
																		array(
																			'role' => 'client',
																			'meta_query' => array(						
																			array(
																					'key' => 'created_by',
																					'value' =>get_current_user_id(),
																					'compare' => '='
																				),
																			)
																		));	
																		$contactdata =array_merge($contactdata_2,$contactdata_3);
																		
																}
																else			
																{	
																	$contactdata =get_users(array('role'=>'client'));	
																}																
																	
															}
															elseif($user_role == 'client')
															{
																if($user_client_access['own_data'] == '1')
																{	
																	$user_id = get_current_user_id();
																	$contactdata=array();
																	$contactdata[]=get_userdata($user_id);	
																}
																else			
																{	
																	$contactdata =get_users(array('role'=>'client'));
																}																
															}
															else
															{	
																if($user_client_access['own_data'] == '1')
																{
																	$contactdata = get_users(
																		array(
																			'role' => 'client',
																			'meta_query' => array(						
																			array(
																					'key' => 'created_by',
																					'value' =>get_current_user_id(),
																					'compare' => '='
																				),
																			)
																		));	
																}
																else			
																{				
																	$contactdata =get_users(array('role'=>'client'));
																}																
															}
																if(!empty($contactdata))
																{
																	foreach($contactdata as $retrive_data)
																	{  				
																?>						
																		<option value="<?php echo esc_attr($retrive_data->ID);?>"><?php echo esc_html($retrive_data->display_name);?> </option>
																<?php }	
																}
														?> 			
												</select>
											</div>
											
										</div>
										 
										<div class="form-group col-md-2 margin_top_custome">
											<label for="subject_id">&nbsp;</label>
											<input type="submit" name="time_entry_report_template" Value="<?php esc_attr_e('Go','lawyer_mgt');?>"  class="btn btn-success"/>
										</div>
									</form>
								</div>
								<?php
									if(isset($_POST['time_entry_report_template']))
									{ ?>
										<script type="text/javascript">
											jQuery(document).ready(function($)
											{
												"use strict"; 
												jQuery('#invoice_data_list').DataTable({
													"responsive": true,
													"autoWidth": false,
													"order": [[ 1, "asc" ]],
													language:<?php echo wpnc_datatable_multi_language();?>,
													 "aoColumns":[
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true}
															   ]		               		
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
														<table id="invoice_data_list" class="invoice_data_list table table-striped table-bordered">
															<thead>	
																<?php  ?>
																<tr>
																	<th><?php  esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
																	<th><?php esc_html_e('Client Name', 'lawyer_mgt' ) ;?></th>
																	<th><?php esc_html_e('Time Entry Activity', 'lawyer_mgt' ) ;?></th>
																	<th><?php  esc_html_e('Time Entry Date', 'lawyer_mgt' ) ;?></th>
																	<th><?php  esc_html_e('Hours', 'lawyer_mgt' ) ;?></th>
																	<th> <?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('Rate', 'lawyer_mgt' ) ;?></th>
																	<th> <?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('SubTotal', 'lawyer_mgt' ) ;?></th>	
																	<th> <?php esc_html_e('Discount(%)', 'lawyer_mgt' ) ;?></th>
																	<th> <?php esc_html_e('Tax', 'lawyer_mgt' ) ;?></th>
																	
																</tr>
																<br/>
															</thead>
															<tbody>
																<?php
																$or=array();
																
																$or['time_entry_date >='] = ($_REQUEST['sdate'] != "")?sanitize_text_field(date("Y-m-d",strtotime($_REQUEST['sdate']))):NULL;
																$or['time_entry_date <='] = ($_REQUEST['edate'] != "")?sanitize_text_field(date("Y-m-d",strtotime($_REQUEST['edate']))):NULL;
																$or['case_id ='] = (!empty($_REQUEST['case_name']))?sanitize_text_field($_REQUEST['case_name']):NULL;
																$or['user_id ='] = (!empty($_REQUEST['client_name']))?sanitize_text_field($_REQUEST['client_name']):NULL;
																 
																$keys = array_keys($or,"");	
																foreach ($keys as $k)
																{
																	unset($or[$k]);
																}
															 
																if(!empty($or))
																{
																	$timeentrydata=$obj_invoice->MJ_lawmgt_get_all_timeentry_data_startdate_enddate_case_client($or);
																	 
																}
																if(!empty($timeentrydata))
																{													
																	foreach ($timeentrydata as $retrieved_data)
																	{
																		if(!empty($retrieved_data->time_entry_tax))
																		{
																			$tax_id=explode(',',$retrieved_data->time_entry_tax);
																		}
																		else
																		{
																			$tax_id='';
																		}											
																		$tax_name=array();
																		if(!empty($tax_id))
																		{						
																			foreach($tax_id as $id)
																			{
																				$tax_name[]=esc_html(MJ_lawmgt_get_tax_name($id));
																			}
																		}
																		?>
																		<tr> 
																			<td><?php 
																			$case_id=esc_attr($retrieved_data->case_id);
																			$case_name=esc_html($obj_invoice->MJ_lawmgt_get_all_case_name_from_case_id($case_id));
																			echo esc_html($case_name->case_name);?></td>
																			<td><?php
																			$userdata=get_userdata($retrieved_data->user_id);
																			echo esc_html($userdata->display_name);?></td>		
																			<td><?php echo esc_html($retrieved_data->time_entry);?></td>
																			<td><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->time_entry_date));?></td>
																			<td><?php echo esc_html($retrieved_data->hours);?></td> 
																			<td><?php echo number_format(esc_html($retrieved_data->rate),2);?></td>
																			<td><?php echo number_format(esc_html($retrieved_data->subtotal),2);?></td>
																			<td><?php echo esc_html($retrieved_data->time_entry_discount);?></td>
																			<td><?php 
																			if(!empty($retrieved_data->time_entry_tax))
																			{
																				echo esc_html(implode(",",$tax_name));
																			}
																			else
																			{
																				echo "-";
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
									}
							}
								if($active_tab == 'timeentries_by_case')
								{
	 
									global $wpdb;
									$table_invoice = $wpdb->prefix. 'lmgt_invoice';
									$table_invoice_time_entries = $wpdb->prefix. 'lmgt_invoice_time_entries';
									$table_case = $wpdb->prefix. 'lmgt_cases';
									
									$result = $wpdb->get_results("SELECT DISTINCT(case_id) FROM $table_invoice");
									
									$chart_array = array();
									$chart_array[] = array(esc_html__('Case Name','lawyer_mgt'),esc_html__('Total Time Entries Amount','lawyer_mgt'));
									if(!empty($result))
									{
										foreach($result as $r)
										{
											$case_id=$r->case_id;
											$case_name = $wpdb->get_row("SELECT case_name FROM $table_case where id=".$case_id);
											$total_time_entries = $wpdb->get_row("SELECT sum($table_invoice_time_entries.subtotal) as total_time_entries  FROM 	$table_invoice_time_entries
											INNER JOIN $table_invoice
											ON $table_invoice.id=$table_invoice_time_entries.invoice_id And $table_invoice.case_id=".esc_attr($case_id));	
										
											$chart_array[]=array( "$case_name->case_name",round($total_time_entries->total_time_entries));
										}
									}
									$options = Array(
											'title' => esc_html__('Time Entries By Client Report','lawyer_mgt'),
											'titleTextStyle' => Array('color' => '#222','fontSize' => 13,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
											'legend' =>Array('position' => 'right',
													'textStyle'=> Array('color' => '#222','fontSize' => 13,'bold'=>true,'italic'=>false,'fontName' =>'open sans')),
												
											'hAxis' => Array(
													'title' =>  esc_html__('Case Name','lawyer_mgt'),
													'titleTextStyle' => Array('color' => '#222','fontSize' => 13,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
													'textStyle' => Array('color' => '#222','fontSize' => 13),
													'maxAlternation' => 2
											),
											'vAxis' => Array(
													'title' =>  esc_html__('Time Entries Amount','lawyer_mgt'),
												 'minValue' => 0,
													//'maxValue' => 5000,
												 'format' => '#',
													'titleTextStyle' => Array('color' => '#222','fontSize' => 13,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
													'textStyle' => Array('color' => '#222','fontSize' => 13)
											)
									);


									require_once LAWMS_PLUGIN_DIR.'/lib/chart/GoogleCharts.class.php';
									$GoogleCharts = new GoogleCharts;
									if(!empty($result))
									{
										$chart = $GoogleCharts->load( 'column' , 'chart_div' )->get( $chart_array , $options );
									}

										if(isset($result) && count($result) >0)
										{
										?>
										<div id="chart_div" class="width_100_per_height_500px"></div>
									  
									  <!-- Javascript --> 
									  
									  <script type="text/javascript">
												<?php echo $chart;?>
										</script>
									  <?php }
									 if(isset($result) && empty($result))
									 {?>
										<div class="clear col-md-12"><?php esc_html_e("There is not enough data to generate report.",'lawyer_mgt');?></div>
									<?php } 
								} 
						}
						if($active_tab == 'taskreport')
						{
							$active_tab = sanitize_text_field(isset($_GET['tab1'])?$_GET['tab1']:'tasks_by_case'); 
							 
							?>
								<h2>
									<ul id="myTab" class="sub_menu_css line case_nav nav nav-tabs" role="tablist">
										<li role="presentation" class="<?php echo esc_html($active_tab) == 'tasks_by_case' ? 'active' : ''; ?> menucss">
												<a href="?dashboard=user&page=report&tab=taskreport&tab1=tasks_by_case">
													<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Tasks By Case', 'lawyer_mgt'); ?>
												</a>
										</li>		
									</ul>
								</h2> 
							<?php
							if($active_tab == 'tasks_by_case')
							{
							?>
								<script type="text/javascript">
								jQuery(document).ready(function($)
								{
									"use strict"; 
									$('#invoice_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
								});
								</script>
								<div class="panel-body">
									<form method="post" id="invoice_form"> 
										 
										<div class="form-group col-md-12 margin_top_custome">
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('Case Name','lawyer_mgt');?></label>
											<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" > 	
												<select class="form-control" name="case_name" id="case_name">	
													<option value=""><?php esc_html_e('Select Case Name','lawyer_mgt');?></option>
													<?php
															$obj_case=new  MJ_lawmgt_case;
															$user_case_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('cases');
															if($user_role == 'attorney')
															{
																if($user_case_access['own_data'] == '1')
																{
																	$attorney_id = get_current_user_id();														
																	$case_data = $obj_case->MJ_lawmgt_get_all_case_by_attorney_id($attorney_id);	
																}
																else
																{
																	$case_data = $obj_case->MJ_lawmgt_get_all_case();
																}		
															}
															else
															{
																if($user_case_access['own_data'] == '1')
																{
																	$case_data = $obj_case->MJ_lawmgt_get_all_case_created_by();
																}
																else
																{
																	$case_data = $obj_case->MJ_lawmgt_get_all_case();
																}		
															}				
																	
																	if(!empty($case_data))
																	{
																		foreach($case_data as $retrive_data)
																		{  				
																	?>						
																			<option value="<?php echo esc_attr($retrive_data->id);?>"><?php echo esc_html($retrive_data->case_name);?> </option>
																	<?php }	
																	}
																?> 			
												</select>
											</div>
										</div>
										 
										<div class="form-group col-md-2 margin_top_custome">
											<label for="subject_id">&nbsp;</label>
											<input type="submit" name="invoice_report" Value="<?php esc_attr_e('Go','lawyer_mgt');?>"  class="btn btn-success"/>
										</div>
									</form>
								</div>
								<?php
									if(isset($_POST['invoice_report']))
									{ ?>
										<script type="text/javascript">
											jQuery(document).ready(function($)
											{
												"use strict"; 
												jQuery('#invoice_data_list').DataTable({
													"responsive": true,
													"autoWidth": false,
													"order": [[ 1, "asc" ]],
													language:<?php echo wpnc_datatable_multi_language();?>,
													 "aoColumns":[
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true}
															   ]		               		
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
														<table id="invoice_data_list" class="invoice_data_list table table-striped table-bordered">
															<thead>	
																<?php  ?>
																<tr>
																	<th><?php  esc_html_e('Task Name', 'lawyer_mgt' ) ;?></th>
																	<th><?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
																	<th> <?php esc_html_e('Due Date', 'lawyer_mgt' ) ;?></th>
																	<th> <?php esc_html_e('Status', 'lawyer_mgt' ) ;?></th>
																	<th> <?php esc_html_e('Priority', 'lawyer_mgt' ) ;?></th>
																	<th> <?php esc_html_e('Assign To Client', 'lawyer_mgt' ) ;?></th>
																	<th> <?php esc_html_e('Assign To Attorney', 'lawyer_mgt' ) ;?></th>
																</tr>
																<br/>
															</thead>
															<tbody>
																<?php
																$or=array();
																 
																$or['case_id ='] = (!empty($_REQUEST['case_name']))?sanitize_text_field($_REQUEST['case_name']):NULL;
																 
																$keys = array_keys($or,"");	
																foreach ($keys as $k)
																{
																	unset($or[$k]);
																}
															 
																if(!empty($or))
																{
																	$task_data=$obj_task->MJ_lawmgt_get_all_task_report($or);
																}
																if(!empty($task_data))
																{													
																	foreach ($task_data as $retrieved_data)
																	{
																		$case_name=MJ_lawmgt_get_case_name_by_id(esc_attr($retrieved_data->case_id));
																		foreach($case_name as $case_name1)
																		{
																			$case_name2=esc_html($case_name1->case_name);
																		}
																		 if($retrieved_data->status==0){
																		 $statu='Not Completed';
																		 }else if($retrieved_data->status==1){
																		 $statu='Completed';
																		 }else{
																		 $statu='In Progress';
																		 }
																		 if($retrieved_data->priority==0){
																		 $prio='High';
																		 }else if($retrieved_data->priority==1){
																		 $prio='Low';
																		 }else{
																		 $prio='Medium';
																		 }
																		$user_name=array();
																		$attorney_name1=array();
																		$user_id=$retrieved_data->assigned_to_user;
																		$attorney=$retrieved_data->assign_to_attorney;
																		$contac_id=explode(',',$user_id);
																		foreach($contac_id as $contact_name) 
																		{
																			$userdata=get_userdata($contact_name);	
																			$user_name[]=esc_html($userdata->display_name);										   
																		}
																		$attorney_name=explode(',',$attorney);
																		foreach($attorney_name as $attorney_name2) 
																		{
																			$attorneydata=get_userdata($attorney_name2);	
																			$attorney_name1[]=esc_html($attorneydata->display_name);
																		}
																		?>
																		<tr> 
																			<td><?php echo esc_html($retrieved_data->task_name);?></td>
																			<td><?php echo esc_html($case_name2);?></td>		
																			<td class="added"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->due_date));?></td>
																			<td class="added"><?php echo esc_html($statu);?></td>
																			<td class="contact_link"><?php echo esc_html($prio); ?></td>	
																			<td class="added"><?php echo  esc_html(implode($user_name,','));?></td>
																			<td class="added"><?php echo  esc_html(implode($attorney_name1,',')); ?></td> 
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
									}
							}
						}
						?>
					</div>			
				</div>
			</div>
		</div>
	</div><!-- END MAIN WRAPER  DIV -->
</div><!--  END PAGE INNER DIV -->