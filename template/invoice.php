<?php 
MJ_lawmgt_browser_javascript_check();
if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
{
	//wp_redirect ( home_url() . '?dashboard=user');
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
$obj_invoice=new MJ_lawmgt_invoice;
$obj_case=new MJ_lawmgt_case;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'invoicelist');
$invoice_columns_array=explode(',',get_option('lmgt_invoice_columns_option'));
$result=null;
?>
<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="invoice_data"></div>
        </div>
    </div> 
</div>
<!-- End POP-UP Code -->
<div class="page_inner_front"><!--  PAGE INNER DIV -->
	
	<?php
	if(isset($_POST['add_fee_payment']))
	{
		//POP up data save in payment history
	    if($_POST['payment_method'] == 'Paypal')
		{				
			require_once LAWMS_PLUGIN_DIR. '/lib/paypal/paypal_process.php';				
		}
		else
		{ 
			$result=$obj_invoice->MJ_lawmgt_add_feepayment($_POST);		
				
			if($result)
			{
				//wp_redirect ( home_url() . '?dashboard=user&page=invoice&tab=invoicelist&message=4');
				$redirect_url=home_url() . '?dashboard=user&page=invoice&tab=invoicelist&message=4';
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
	//var_dump($_POST);
	if(isset($_POST['payer_status']) &&  sanitize_text_field($_POST['payer_status']) == 'VERIFIED' && (isset($_POST['payment_status'])) &&  sanitize_text_field($_POST['payment_status'])=='Completed' && isset($_REQUEST['half']) &&  sanitize_text_field($_REQUEST['half'])=='yes' )
	{		
		
		$custom_array = explode("_", sanitize_text_field($_POST['custom']));
		$feedata['invoice_id']=$custom_array[1];

		$feedata['amount']= sanitize_text_field($_POST['mc_gross_1']);
		$feedata['payment_method']='paypal';	
	
		$feedata['created_by']=$custom_array[0];
		
		$result = $obj_invoice->MJ_lawmgt_add_feepayment($feedata);
		
		//var_dump($result);die;
		 //----SEND NOTIFICATION MAIL--------
		$system_name=get_option('lmgt_system_name');
			
		//$to=array();
		$user_id=get_current_user_id();
		$userdata=get_userdata($user_id);
		$arr['{{Lawyer System Name}}']=$system_name;	
		$arr['{{User Name}}']=esc_html($userdata->display_name);	
		$to=sanitize_email($userdata->user_email);			
		$subject =get_option('lmgt_payment_received_against_invoice_email_subject');
		$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
		$message = get_option('lmgt_payment_received_against_invoice_email_template');	
		$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
		if($result)
		{ 
			//wp_redirect ( home_url() . '?dashboard=user&page=invoice&action=success');
			$redirect_url=home_url() . '?dashboard=user&page=invoice&action=success';
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
	if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='success')	
	{ ?>
		<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<?php esc_html_e('Payment successfull','lawyer_mgt');?>
		</div>
	<?php
	}		
	if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='cancel')
	{ ?>
		<div class="alert_msg alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<?php esc_html_e('Payment Cancel','lawyer_mgt');?>
		</div>
	<?php
	}		
	if(isset($_POST['save_invoice']))
	{	
		$nonce =  sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_invoice_nonce' ) )
		{ 
			if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='edit')
			{	
				$result=$obj_invoice->MJ_lawmgt_add_invoice($_POST);
					
				if($result)
				{
					//wp_redirect ( home_url() . '?dashboard=user&page=invoice&tab=invoicelist&message=2');
					$redirect_url=home_url() . '?dashboard=user&page=invoice&tab=invoicelist&message=2';
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
				$result=$obj_invoice->MJ_lawmgt_add_invoice($_POST);		
				
				if($result)
				{
					//wp_redirect ( home_url() . '?dashboard=user&page=invoice&tab=invoicelist&message=1');
					$redirect_url=home_url() . '?dashboard=user&page=invoice&tab=invoicelist&message=1';
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
		$result=$obj_invoice->MJ_lawmgt_delete_invoice(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['invoice_id'])));				
		if($result)
		{
			//wp_redirect ( home_url() . '?dashboard=user&page=invoice&tab=invoicelist&message=3');
			$redirect_url=home_url() . '?dashboard=user&page=invoice&tab=invoicelist&message=3';
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
	if(isset($_POST['invoice_delete_selected']))
	{
		if (isset($_POST["selected_id"]))
		{	
			$selected_id_filter = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ));
			$all = implode(",", $selected_id_filter);			
			$result=$obj_invoice->MJ_lawmgt_delete_selected_invoice($all);	
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
			//wp_redirect ( home_url() . '?dashboard=user&page=invoice&tab=invoicelist&message=3');
			$redirect_url=home_url() . '?dashboard=user&page=invoice&tab=invoicelist&message=3';
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
	//save tax
	if(isset($_POST['save_tax']))
	{	
		$nonce =  sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_tax_nonce' ) )
		{
			if($_REQUEST['action']=='edit_tax')
			{				
				$result=$obj_invoice->MJ_lawmgt_add_tax($_POST);
				
				if($result)	
				{			
					//wp_redirect ( home_url() . '?dashboard=user&page=invoice&tab=taxlist&message=6');
					$redirect_url=home_url() . '?dashboard=user&page=invoice&tab=taxlist&message=6';
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
				$result=$obj_invoice->MJ_lawmgt_add_tax($_POST);
				
				if($result)
				{				
					//wp_redirect ( home_url() . '?dashboard=user&page=invoice&tab=taxlist&message=5');
					$redirect_url=home_url() . '?dashboard=user&page=invoice&tab=taxlist&message=5';
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
	if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='delete_tax')
	{		
		 
		$result=$obj_invoice->MJ_lawmgt_delete_tax(sanitize_text_field($_REQUEST['tax_id']));	
		 
		if($result)
		{
			//wp_redirect ( home_url() . '?dashboard=user&page=invoice&tab=taxlist&message=7');
			$redirect_url=home_url() . '?dashboard=user&page=invoice&tab=taxlist&message=7';
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
				<?php esc_html_e('Invoice Inserted Successfully','lawyer_mgt');?>
			</div>
			<?php
		}
		elseif($message == 2)
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<?php esc_html_e('Invoice Updated Successfully','lawyer_mgt');?>
			</div>
			<?php 			
		}
		elseif($message == 3) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Invoice Deleted Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 4) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Payment Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 5) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
		 <?php esc_html_e('Tax Inserted Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 6) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
		 <?php esc_html_e('Tax Updated Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 7) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
		 <?php esc_html_e('Tax Deleted Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
	} 		
	?>
	<div id="main-wrapper"><!-- MAIN WRAPER  DIV -->
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white">
					<div class="panel-body"><!-- PANEL BODY DIV  -->
						<h2 class="nav-tab-wrapper invoice_wrappwr">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="tablist">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'invoicelist' ? 'active' : ''; ?> menucss">
									<a href="?dashboard=user&page=invoice&tab=invoicelist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Invoice List', 'lawyer_mgt'); ?>
									</a>
								</li>
								
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_invoice' ? 'active' : ''; ?> menucss">
									<?php  
									if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
									{?>
									<a href="?dashboard=user&page=invoice&tab=add_invoice&action=edit&invoice_id=<?php echo esc_attr($_REQUEST['invoice_id']);?>">
										<?php esc_html_e('Edit Invoice', 'lawyer_mgt'); ?>
									</a>  
									<?php 
									}			
									else
									{
										if($user_access['add']=='1')
										{				
											?>
											<a href="?dashboard=user&page=invoice&tab=add_invoice&&action=insert">
												<?php echo '<span class="fa fa-plus-circle"></span> '.esc_html__('Add Invoice', 'lawyer_mgt');?>
											</a>  
											<?php  
										}
									}?>
									</li>
								
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
								{
								?>
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'invoicedetails' ? 'active' : ''; ?> menucss">
										<a href="?dashboard=user&page=invoice&tab=invoicedetails&action=view&invoice_id=<?php echo esc_attr($_REQUEST['invoice_id']);?>">
											<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('Invoice Details', 'lawyer_mgt'); ?>
										</a>
									</li>
						  <?php } ?>	
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'taxlist' ? 'active' : ''; ?> menucss">
									<a href="?dashboard=user&page=invoice&tab=taxlist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Tax List', 'lawyer_mgt'); ?>
									</a>
								</li>
								
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_tax' ? 'active' : ''; ?> menucss">
										<?php  
										if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit_tax')
										{?>
										<a href="?dashboard=user&page=invoice&tab=add_tax&&action=edit_tax&tax_id=<?php echo esc_attr($_REQUEST['tax_id']);?>">
											<?php esc_html_e('Edit Tax', 'lawyer_mgt'); ?>
										</a>  
										<?php 
										}			
										else
										{
											if($user_access['add']=='1')
											{
												?>
												<a href="?dashboard=user&page=invoice&tab=add_tax&&action=insert">
													<?php echo '<span class="fa fa-plus-circle"></span> '.esc_html__('Add Tax', 'lawyer_mgt');?>
												</a>  
												<?php  
											}
										}
										?>
									</li>
								
							</ul>
						</h2>
						<?php	
						if($active_tab == 'invoicelist')
						{ 
						?>	
							<script type="text/javascript">
								jQuery(document).ready(function($)
								{
									"use strict"; 
									jQuery('#invoice_list').DataTable({
										"responsive": true,
										"autoWidth": false,
										 "order": [[ 1, "asc" ]],
										 language:<?php echo wpnc_datatable_multi_language();?>,
										 "aoColumns":[
													  {"bSortable": false},
													  <?php if(in_array('invoice_number',$invoice_columns_array)) { ?>
													  {"bSortable": true},
											<?php  }  ?>
											<?php if(in_array('invoice_date',$invoice_columns_array)) {  ?>
													  {"bSortable": true},
											<?php   }   ?>
											<?php if(in_array('due_date',$invoice_columns_array)) {  ?>
													  {"bSortable": true},
											<?php   }   ?>
											 <?php if(in_array('invoice_billing_contact_name',$invoice_columns_array)) { ?>
													  {"bSortable": true},
											 <?php  }  ?>
											 <?php if(in_array('invoice_case_name',$invoice_columns_array)) { ?>
													  {"bSortable": true},	
											 <?php  }  ?>
											 <?php if(in_array('total_amount',$invoice_columns_array)) { ?>
													  {"bSortable": true},
											 <?php  }  ?>
											 <?php if(in_array('paid_amount',$invoice_columns_array)) {  ?>
													  {"bSortable": true},
											<?php  }  ?>
											<?php  if(in_array('due_amount',$invoice_columns_array)) {     ?>
													  {"bSortable": true},
											<?php  }  ?>
											<?php if(in_array('payment_status',$invoice_columns_array)) { ?>
													  {"bVisible": true},
											<?php  }  ?>
											 
											<?php if(in_array('invoice_notes',$invoice_columns_array)) { ?>
													  {"bSortable": true},
											<?php  }  ?>
											<?php if(in_array('terms',$invoice_columns_array)) {   ?>
													  {"bSortable": true},
											<?php  }  ?>	                 
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
							</script>
							<form name="wcwm_report" action="" method="post">
								<div class="panel-body margin_panel_cases">
									<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">
										<table id="invoice_list" class="table table-striped table-bordered">
											<thead>
												<tr>
													<th><input type="checkbox" id="select_all"></th>
													<?php if(in_array('invoice_number',$invoice_columns_array)) { ?>
													<th><?php  esc_html_e('Invoice Number', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?>
											<?php if(in_array('invoice_date',$invoice_columns_array)) { ?>
													<th><?php esc_html_e('Invoice Date', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?>		
											<?php if(in_array('due_date',$invoice_columns_array)) { ?>
													<th><?php esc_html_e('Due Date', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?>		
											<?php if(in_array('invoice_billing_contact_name',$invoice_columns_array)) { ?>
													<th> <?php esc_html_e('Billing Client Name', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?>
											<?php if(in_array('invoice_case_name',$invoice_columns_array)) { ?>
													<th> <?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?>
											<?php if(in_array('total_amount',$invoice_columns_array)) { ?>
													<th> <?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('Total Amount', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?>
											<?php if(in_array('paid_amount',$invoice_columns_array)) { ?>
													<th> <?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('Paid Amount', 'lawyer_mgt' ) ;?></th>	
											<?php  }  ?>
											<?php if(in_array('due_amount',$invoice_columns_array)) { ?>
													<th> <?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('Due Amount', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?>
											<?php if(in_array('payment_status',$invoice_columns_array)) { ?>
													<th> <?php esc_html_e('Payment Status', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?>
											 
											<?php if(in_array('invoice_notes',$invoice_columns_array)) { ?>
													<th><?php  esc_html_e('Notes', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?>
											<?php if(in_array('terms',$invoice_columns_array)) { ?>
													<th><?php  esc_html_e('Terms & Conditions', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?> 			
													<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
												</tr>
											</thead>
											<tbody>
											<?php 
												if($user_role == 'attorney')
												{
													if($user_access['own_data'] == '1')
													{
														$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice_by_attorney();
													}
													else
													{
														$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice();
													}	
												}
												elseif($user_role == 'client')
												{
													if($user_access['own_data'] == '1')
													{
														$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice_by_client();
													}
													else
													{
														$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice();
													}	
												}
												else
												{
													if($user_access['own_data'] == '1')
													{
														$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice_created_by();
													}
													else
													{
														$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice();
													}
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
															<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->id); ?>"></td>
																<?php if(in_array('invoice_number',$invoice_columns_array)) { ?>
																		<td><?php echo esc_html($retrieved_data->invoice_number);?></td>
																<?php  }  ?>
																<?php if(in_array('invoice_date',$invoice_columns_array)) {  ?>
																		<td><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->generated_date));?></td>		
																<?php  }  ?>
																<?php if(in_array('due_date',$invoice_columns_array)) {  ?>		
																		<td><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->due_date));?></td>
																 <?php  }  ?>			
																		<?php if(in_array('invoice_billing_contact_name',$invoice_columns_array)) { ?>
																		<td><?php echo esc_html($conatc_name);?></td>
																 <?php  }  ?>
																 <?php if(in_array('invoice_case_name',$invoice_columns_array)) {  
																						
																		$case_id=$retrieved_data->case_id;
																		$case_name=$obj_invoice->MJ_lawmgt_get_all_case_name_from_case_id($case_id); ?>
																		<td><a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>"><?php echo esc_html($case_name->case_name);?></a></td>
																 <?php  }        
																  if(in_array('total_amount',$invoice_columns_array)) { ?>
																		<td><?php echo number_format(esc_html($retrieved_data->total_amount),2);?></td>
																<?php  }  	
																if(in_array('paid_amount',$invoice_columns_array)) {  ?>
																		<td><?php echo number_format(esc_html($retrieved_data->paid_amount),2);?></td>
																<?php  }   
																if(in_array('due_amount',$invoice_columns_array)) {   ?>
																		<td><?php echo number_format(esc_html($retrieved_data->due_amount),2);?></td>	
																<?php  }   	
																if(in_array('payment_status',$invoice_columns_array)) { ?>
																		<td><span class="btn btn-success btn-xs"><?php echo esc_html($retrieved_data->payment_status); ?></span></td>
																<?php  }  
																if(in_array('invoice_notes',$invoice_columns_array)) { ?>
																		<td><?php echo  esc_html($retrieved_data->note); ?></td>
																<?php  }  
																if(in_array('terms',$invoice_columns_array)) {   ?>		
																		<td><?php echo  esc_html($retrieved_data->terms); ?></td>	
																<?php  }  ?>		
															<td>
															<?php 
																if(MJ_lawmgt_get_invoice_paymentstatus_for_payment($retrieved_data->id) == 'Fully Paid')
																{  ?>
																	<a href="?dashboard=user&page=invoice&tab=invoicedetails&action=view&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
																	<?php
																	if($user_access['edit']=='1')
																	{
																		?>
																		<a href="?dashboard=user&page=invoice&tab=add_invoice&action=edit&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
																	<?php
																	}
																	if($user_access['delete']=='1')
																	{
																		?>
																		<a href="?dashboard=user&page=invoice&tab=invoicelist&action=delete&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($case_id));?>&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" 
																		onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');">
																		<?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>		
																<?php 
																	}
																}
																else 
																{
																	if($user_role == 'client')
																	{	
																	?>
																		<a href="#"  class="show-payment-popup btn btn-default" case_id="<?php echo esc_attr($retrieved_data->case_id); ?>" invoice_id="<?php echo esc_attr($retrieved_data->id); ?>" view_type="payment" due_amount="<?php echo number_format(esc_html($retrieved_data->due_amount),2, '.', '');?>" ><?php esc_html_e('Pay','lawyer_mgt');?></a>	
																	<?php
																	}
																	?>
																	<a href="?dashboard=user&page=invoice&tab=invoicedetails&action=view&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
																	<?php	
																	if($user_access['edit']=='1')
																	{
																	?>
																		<a href="?dashboard=user&page=invoice&tab=add_invoice&action=edit&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
																	<?php
																	}
																	if($user_access['delete']=='1')
																	{
																		?>		
																		<a href="?dashboard=user&page=invoice&tab=invoicelist&action=delete&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($case_id));?>&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" 
																		onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');">
																		<?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>		
																	<?php
																	}
																}
																?>				
															</td>               
														</tr>
													<?php 
													}	 	
												}
													?>     
											</tbody>        
										</table>
										<?php
										if($user_access['delete']=='1')
										{
											if(!empty($invoicedata))
											{
										?>
											<div class="form-group">		
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
													<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="invoice_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
												</div>
											</div>
										<?php 
												}
										} 			
										?>  	
									</div>
								</div>       
							</form>
						<?php 
						}	
						if($active_tab == 'add_invoice')
						{		
							$obj_invoice=new MJ_lawmgt_invoice;
							?>
							<script type="text/javascript">
							    var $ = jQuery.noConflict();
								jQuery(document).ready(function($)
								{
									"use strict"; 
									function MJ_lawmgt_initMultiSelect()
									{	
										"use strict"; 	
									  $(".tax_dropdawn").multiselect({
										 
										nonSelectedText :'<?php esc_html_e('Select Tax','lawyer_mgt');?>',
										selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
										includeSelectAllOption: true         
									 });
									}
									$('#invoice_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
									var start = new Date();
									var end = new Date(new Date().setYear(start.getFullYear()+1));

									$('.date').datepicker({
										changeYear: true,
										yearRange:'-65:+0',
										autoclose: true										
									}).on('changeDate', function(){
										$('.date1').datepicker('setStartDate', new Date($(this).val()));
									}); 
									
									 $(".tax_dropdawn").multiselect({
										nonSelectedText :'<?php esc_html_e('Select Tax','lawyer_mgt');?>',
										numberDisplayed: 1,	
										selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
										includeSelectAllOption: true         
									});
									
									$('.date1').datepicker({
										startDate : start,
										endDate   : end,
										autoclose: true
									}).on('changeDate', function(){
										$('.date').datepicker('setEndDate', new Date($(this).val()));
									});	
									$('.demo').on("click",function(){
									MJ_lawmgt_initMultiSelect();
									}) 
								});								 
								"use strict"; 			
								var time_entry ='';
								var expense ='';
								var flat_fee ='';
								jQuery(document).ready(function($)
								{ 
									"use strict"; 
									time_entry = $('.time_entry_div').html();   	
									expense = $('.expenses_entry_div').html();   	
									flat_fee = $('.flat_entry_div').html();   	
								}); 
								
								function MJ_lawmgt_add_time_entry()
								{ 
									"use strict"; 
									var value = $('.time_increment').val(); 
									value++;  
									 
									  $(".tax_dropdawn").multiselect({
										nonSelectedText :'<?php esc_html_e('Select Tax','lawyer_mgt');?>',
										numberDisplayed: 1,	
										selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
										includeSelectAllOption: true         
									});  
									<?php
									$user = wp_get_current_user();
									$userid=$user->ID;
									$user_name=get_userdata($userid);	
									?>
									
									$(".time_entry_div").append('<div class="main_time_entry_div"><div class="form-group"><label class="col-sm-2 control-label" for="medicine_name"><?php esc_html_e('Time Entries','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-sm-3 margin_bottom_5px"><input class="form-control text-input validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]" type="text" value="" name="time_entry[]" placeholder="<?php esc_html_e('Enter time entry','lawyer_mgt');?>"></div> <div class="col-sm-3 margin_bottom_5px has-feedback">	 <input  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="customfielddate date date_css form-control has-feedback-left validate[required]" type="text"  name="time_entry_date[]"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>" value="" readonly><span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span> </div> <div class="col-sm-3 margin_bottom_5px"> <textarea class="validate[custom[address_description_validation],maxSize[150]]" rows="1" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" name="time_entry_description[]"></textarea> </div></div> <div class="form-group"><div class="col-sm-3 margin_bottom_5px offset-sm-2"> <input class="form-control text-input validate[required] added_subtotal time_entry_hours'+value+'" row="'+value+'" type="number" onKeyPress="if(this.value.length==2) return false;" value="" min="1" name="time_entry_hours[]" placeholder="<?php esc_html_e('Enter hours','lawyer_mgt');?>"></div><div class="col-sm-3 margin_bottom_5px"> <input  class="form-control text-input validate[required,min[0],maxSize[8]] added_subtotal time_entry_rate'+value+'" row="'+value+'" type="number" step="0.01" value="" name="time_entry_rate[]" placeholder="<?php esc_html_e('Enter rate','lawyer_mgt');?>"> </div><div class="col-sm-3 margin_bottom_5px"> <input   class="form-control text-input time_entry_sub'+value+'" row="'+value+'" placeholder="<?php esc_html_e('Time Entry Subtotal','lawyer_mgt');?>" type="text" value="" name="time_entry_sub[]" readonly="readonly"> </div></div><div class="form-group"><div class="col-sm-3 margin_bottom_5px offset-sm-2"> <input   class="form-control validate[min[0],max[100]] text-input" type="number" step="0.01" value="" name="time_entry_discount" placeholder="<?php esc_html_e('Enter Discount in (%)','lawyer_mgt');?>" ></div> <div class="col-sm-3 margin_bottom_5px"><select  class="form-control tax_charge tax_dropdawn"  multiple="multiple" name="time_entry_tax['+value+'][]" ><?php $obj_invoice= new MJ_lawmgt_invoice(); $hmgt_taxs=$obj_invoice->MJ_lawmgt_get_all_tax_data(); if(!empty($hmgt_taxs)){	foreach($hmgt_taxs as $entry){ ?> <option value="<?php echo esc_attr($entry->tax_id); ?>"><?php echo esc_html($entry->tax_title);?>-<?php echo esc_html($entry->tax_value);?></option> <?php } }	?></select></div><div class="col-sm-3 margin_bottom_5px"><input type="button"  value="<?php esc_html_e('Delete','lawyer_mgt');?> "  class="remove_time_entry btn btn-danger"></div></div><hr>');
									$('.time_increment').val(value); 
								}  
								
								 
									function MJ_lawmgt_add_expense()
									{
										"use strict"; 
										var value_expence = $('.expenses_increment').val(); 
										value_expence++;
										$(".tax_dropdawn").multiselect({
											nonSelectedText :'<?php esc_html_e('Select Tax','lawyer_mgt');?>',
											numberDisplayed: 1,	
											selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
											includeSelectAllOption: true         
										}); 
										<?php 
											$user = wp_get_current_user();
											$userid=$user->ID;
											$user_name=get_userdata($userid);	
										?>
										
										$(".expenses_entry_div").append('<div class="main_expenses_entry_div"><div class="form-group"><label class="col-sm-2 control-label" for="medicine_name"><?php esc_html_e('Expenses Entries','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-sm-3 margin_bottom_5px"><input class="form-control text-input validate[required] onlyletter_number_space_validation" maxlength="50" type="text" value="" name="expense[]" placeholder="<?php esc_html_e('Enter expense','lawyer_mgt');?>"></div> <div class="col-sm-3 margin_bottom_5px has-feedback">	 <input  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="customfielddate date_css date form-control has-feedback-left validate[required]" type="text"  name="expense_date[]"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>" value="" readonly><span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span> </div> <div class="col-sm-3 margin_bottom_5px"> <textarea class="validate[custom[address_description_validation],maxSize[150]]" rows="1"  maxlength="150" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" name="expense_description[]"></textarea> </div></div> <div class="form-group"><div class="col-sm-3 margin_bottom_5px offset-sm-2"> <input  class="form-control text-input validate[required] added_subtotal_expenses expense_quantity'+value_expence+'" row="'+value_expence+'" type="number" onKeyPress="if(this.value.length==2) return false;" value="" min="1" name="expense_quantity[]"  placeholder="<?php esc_html_e('Enter quantity','lawyer_mgt');?>"></div><div class="col-sm-3 margin_bottom_5px"> <input  class="form-control text-input added_subtotal_expenses validate[required,min[0],maxSize[8]] expense_price'+value_expence+'" row="'+value_expence+'"  type="number" value="" name="expense_price[]"  placeholder="<?php esc_html_e('Enter Price','lawyer_mgt');?>"> </div><div class="col-sm-3 margin_bottom_5px"> <input class="form-control text-input  expense_sub'+value_expence+'" row="'+value_expence+'" type="text" value="" placeholder="<?php esc_html_e('Expenses Entry Subtotal','lawyer_mgt');?>" name="expense_sub[]" readonly="readonly"> </div></div><div class="form-group"><div class="col-sm-3 margin_bottom_5px offset-sm-2"> <input class="form-control validate[min[0],max[100]] text-input" type="number" step="0.01" value="" name="expenses_entry_discount" placeholder="<?php esc_html_e('Enter Discount in (%)','lawyer_mgt');?>" ></div> <div class="col-sm-3 margin_bottom_5px"><select  class="form-control tax_charge tax_dropdawn"  multiple="multiple" name="expenses_entry_tax['+value_expence+'][]"><?php $obj_invoice= new MJ_lawmgt_invoice(); $hmgt_taxs=$obj_invoice->MJ_lawmgt_get_all_tax_data(); if(!empty($hmgt_taxs)){	foreach($hmgt_taxs as $entry){ ?> <option value="<?php echo esc_attr($entry->tax_id); ?>"><?php echo esc_html($entry->tax_title);?>-<?php echo esc_html($entry->tax_value);?></option> <?php } }	?></select></div><div class="col-sm-3 margin_bottom_5px"><input type="button" value="<?php esc_html_e('Delete','lawyer_mgt');?>" class="remove_expenses_entry btn btn-danger"></div></div><hr>');
										$('.expenses_increment').val(value); 
									} 
									 
									function MJ_lawmgt_add_flat_fee()
									{	
										"use strict"; 
										var value_flat = $('.flat_increment').val(); 
										value_flat++;
										$(".tax_dropdawn").multiselect({
											nonSelectedText :'<?php esc_html_e('Select Tax','lawyer_mgt');?>',
											numberDisplayed: 1,	
											selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
											includeSelectAllOption: true         
										}); 
										<?php
											$user = wp_get_current_user();
											$userid=$user->ID;
											$user_name=get_userdata($userid);	
										?>
										$(".flat_entry_div").append('<div class="main_flat_entry_div"><div class="form-group"><label class="col-sm-2 control-label" for="medicine_name"><?php esc_html_e('Flat Entries','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-sm-3 margin_bottom_5px"><input class="form-control text-input validate[required] onlyletter_number_space_validation" maxlength="50" type="text" value="" name="flat_fee[]" placeholder="<?php esc_html_e('Enter Flat fee','lawyer_mgt');?>"></div> <div class="col-sm-3 margin_bottom_5px has-feedback"><input  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="customfielddate date_css date form-control has-feedback-left validate[required]" type="text"  name="flat_fee_date[]"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>" value="" readonly><span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span> </div> <div class="col-sm-3 margin_bottom_5px"> <textarea  class="validate[custom[address_description_validation],maxSize[150]]" rows="1" maxlength="150" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" name="flat_fee_description[]"></textarea> </div></div> <div class="form-group"><div class="col-sm-3 margin_bottom_5px offset-sm-2"> <input  class="form-control text-input validate[required] flat_fee_quantity'+value_flat+' added_subtotal_flat_fee" type="number" onKeyPress="if(this.value.length==2) return false;" value="" min="1" name="flat_fee_quantity[]" row="'+value_flat+'" placeholder="<?php esc_html_e('Enter quantity','lawyer_mgt');?>"></div><div class="col-sm-3 margin_bottom_5px"><input class="form-control text-input validate[required,min[0],maxSize[8]] flat_fee_price'+value_flat+' added_subtotal_flat_fee" type="number" value="" name="flat_fee_price[]" row="'+value_flat+'" placeholder="<?php esc_html_e('Enter Price','lawyer_mgt');?>"> </div><div class="col-sm-3 margin_bottom_5px"> <input  class="form-control text-input  flat_fee_sub'+value_flat+'" row="'+value_flat+'" type="text" value="" name="flat_fee_sub[]" placeholder="<?php esc_html_e('Flat Entry Subtotal','lawyer_mgt');?>" readonly="readonly"> </div></div><div class="form-group"><div class="col-sm-3 margin_bottom_5px offset-sm-2"> <input  class="form-control validate[min[0],max[100]] text-input" type="number" step="0.01" value="" name="flat_entry_discount" placeholder="<?php esc_html_e('Enter Discount in (%)','lawyer_mgt');?>" ></div> <div class="col-sm-3 margin_bottom_5px"><select  class="form-control tax_charge tax_dropdawn"  multiple="multiple" name="flat_entry_tax['+value_flat+'][]"><?php $obj_invoice= new MJ_lawmgt_invoice(); $hmgt_taxs=$obj_invoice->MJ_lawmgt_get_all_tax_data(); if(!empty($hmgt_taxs)){	foreach($hmgt_taxs as $entry){ ?> <option value="<?php echo esc_attr($entry->tax_id); ?>"><?php echo esc_html($entry->tax_title);?>-<?php echo esc_html($entry->tax_value);?></option> <?php } }	?></select></div><div class="col-sm-3 margin_bottom_5px"><input type="button" value="<?php esc_html_e('Delete','lawyer_mgt');?>" class="remove_flat_entry btn btn-danger"></div></div><hr>');
										$('.flat_increment').val(value); 
									}	
							</script>
							<?php 	
							$invoice_id=0;
							$edit=0;
							if(isset($_REQUEST['invoice_id']))
								$invoice_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['invoice_id']));
							if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
							{									
								$edit=1;
								$invoice_info=$obj_invoice->MJ_lawmgt_get_single_invoice($invoice_id);									
							} ?> 
							
							<div class="panel-body">
								<form name="invoice_form" action="" method="post" class="form-horizontal" id="invoice_form" enctype='multipart/form-data'>	
									 <?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
									<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">	
									<input type="hidden" name="invoice_id1" value="<?php echo esc_attr($invoice_id);?>"  />
									<input type="hidden" name="paid_amount" value="<?php if($edit) { echo esc_attr($invoice_info->paid_amount); } ?>"  />		
									<div class="header invoice_heading invoice_heading_new">	
										<h3 class="first_hed"><?php esc_html_e('Linked To','lawyer_mgt');?></h3>
										<hr>
									</div>
									<?php wp_nonce_field( 'save_invoice_nonce' ); ?>									
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="contact_name"><?php esc_html_e('Case Name','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<?php
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
											?>
											<select class="form-control validate[required]" name="case_name" id="invoice_case_id">	
												<option value=""><?php esc_html_e('Select Case name','lawyer_mgt');?></option>				
													<?php 
													if($edit){ $data=$invoice_info->case_id;}else{ $data=''; }
													foreach($result as $result1)
													{
														echo '<option value="'.esc_attr($result1->id).'" '.selected($data,esc_attr($result1->id)).'>'.esc_html($result1->case_name).'</option>';
													} ?>
											</select>
										</div>		
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="contact_name"><?php esc_html_e('Billing Client Name','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<select class="form-control validate[required]" name="contact_name" id="invoice_contacts">	
												<option value=""><?php esc_html_e('Select Client Name','lawyer_mgt');?></option>
											<?php
											if($edit)
											{ 
												$user_id=$invoice_info->user_id;
												$invoice_case_id=$invoice_info->case_id;
												$contactdata=MJ_lawmgt_get_billing_user_by_case_id($invoice_case_id);
												
													foreach($contactdata as $retrive_data)
													{  		
													?>						
														<option value="<?php echo esc_attr($retrive_data->billing_contact_id);?>" <?php selected($retrive_data->billing_contact_id,$user_id) ?>><?php echo esc_html(MJ_lawmgt_get_display_name($retrive_data->billing_contact_id));?> </option>						
													<?php 
													}		
											}		
											
											?>
											</select>
										</div>		
									</div>
									<div class="header">	
										<h3 class="first_hed workflow_event"><?php esc_html_e('Invoice Information','lawyer_mgt');?></h3>
										<hr>
									</div>
									<div class="form-group">			
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="invoice_number"><?php esc_html_e('Invoice Number','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="invoice_number" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo esc_attr($invoice_info->invoice_number); } else echo MJ_lawmgt_generate_invoce_number();?>" name="invoice_number" readonly>				
										</div>		
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="date"><?php esc_html_e('Date','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="date"  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date form-control has-feedback-left" type="text"  name="invoice_generated_date"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>"
											value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($invoice_info->generated_date)); }elseif(isset($_POST['invoice_generated_date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['invoice_generated_date'])); } ?>" readonly>
											<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
											<span id="inputSuccess2Status2" class="sr-only">(success)</span>				
										</div>	
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="due_date"><?php esc_html_e('Due Date','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="due_date"  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date1 form-control has-feedback-left" type="text"  name="due_date"  placeholder="<?php esc_html_e('Select Due Date','lawyer_mgt');?>"
											value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($invoice_info->due_date)); }elseif(isset($_POST['due_date'])){ echo MJ_lawmgt_getdate_in_input_box(esc_attr($_POST['due_date'])); } ?>" readonly>
											<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
											<span id="inputSuccess2Status2" class="sr-only">(success)</span>
										</div>	
										 
									</div>
									<div class="header">	
										<h3 class="first_hed workflow_event"><?php esc_html_e('Time Entries','lawyer_mgt');?></h3>
										<hr>
									</div>	
									<div class="time_entry_div">
										<div class="main_time_entry_div">
											<?php
												if(!$edit)
												{ 
												?>
													<input type="hidden" value="-1" name="time_increment"  class="time_increment">
												<?php
												}
													if($edit)
													{ 
														$result_time=$obj_invoice->MJ_lawmgt_get_single_invoice_time_entry($invoice_id);
														
														?>
														<input type="hidden" value="<?php echo sizeof($result_time); ?>" name="time_increment"  class="time_increment">
														<?php	
															if(!empty($result_time))
															{						
																$value = -1;
																foreach($result_time as $data)
																{ 
																 $value++;

																?>
															<div class="form-group">
																<label class="col-sm-2 control-label" for="medicine_name"><?php esc_html_e('Time Entries','lawyer_mgt');?><span class="require-field">*</span></label>
																<div class="col-sm-3 margin_bottom_5px">
																	<input class="form-control text-input validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]" type="text" value="<?php if($edit){ echo esc_attr($data->time_entry);}elseif(isset($_POST['time_entry'])){ echo esc_attr($_POST['time_entry']); } ?>" name="time_entry[]" placeholder="<?php esc_html_e('Enter time entry','lawyer_mgt');?>">
																</div>
																<div class="col-sm-3 margin_bottom_5px has-feedback">
																	<input  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date date_css form-control has-feedback-left" type="text"  name="time_entry_date[]"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>"   value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($data->time_entry_date)); }elseif(isset($_POST['time_entry_date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['time_entry_date'])); } ?>" readonly>
																	<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
																	<span id="inputSuccess2Status2" class="sr-only">(success)</span>
																</div>	
																<div class="col-sm-3 margin_bottom_5px">
																	<textarea rows="1" class="validate[custom[address_description_validation],maxSize[150]]" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>"   name="time_entry_description[]"><?php if($edit){ echo esc_textarea($data->description);}elseif(isset($_POST['time_entry_description'])) {echo esc_textarea($_POST['time_entry_description']); } ?></textarea>
																</div>
																
															</div>
															<div class="form-group">
																<div class="col-sm-3 offset-sm-2 margin_bottom_5px">
																	<input  class="form-control height_34_px_css validate[required] time_entry_hours<?php echo $value; ?> added_subtotal" onKeyPress="if(this.value.length==2) return false;" type="number" min="1" value="<?php if($edit){ echo esc_attr($data->hours);}elseif(isset($_POST['time_entry_hours'])){ echo esc_attr($_POST['time_entry_hours']); } ?>" name="time_entry_hours[]" row="<?php echo $value;?>" placeholder="<?php esc_html_e('Enter hours','lawyer_mgt');?>">
																</div>
																<div class="col-sm-3 margin_bottom_5px">
																	<input class="form-control text-input validate[required,min[0],maxSize[8]] time_entry_rate<?php echo $value; ?> added_subtotal" type="number" value="<?php if($edit){ echo esc_attr($data->rate);}elseif(isset($_POST['time_entry_rate'])){ echo esc_attr($_POST['time_entry_rate']); } ?>" name="time_entry_rate[]" row="<?php echo $value;?>" placeholder="<?php esc_html_e('Enter rate','lawyer_mgt');?>">
																</div>
																<div class="col-sm-3 margin_bottom_5px">
																	<input class="form-control text-input  time_entry_sub<?php echo $value; ?>" row="<?php echo $value;?>" type="text" value="<?php if($edit){ echo esc_attr($data->subtotal);}elseif(isset($_POST['time_entry_sub'])){ echo esc_attr($_POST['time_entry_sub']); } ?>" name="time_entry_sub[]" readonly="readonly">
																</div>
															</div>
															<div class="form-group">
																<div class="col-sm-3 offset-sm-2 margin_bottom_5px">
																	<input class="form-control validate[min[0],max[100]] text-input" type="number" step="0.01" value="<?php if($edit){ echo esc_attr($data->time_entry_discount);}elseif(isset($_POST['time_entry_discount'])){ echo esc_attr($_POST['time_entry_discount']); } ?>" name="time_entry_discount" placeholder="<?php esc_html_e('Enter Discount in (%)','lawyer_mgt');?>" >
																</div>
																<div class="col-sm-3 margin_bottom_5px">
																	<select  class="form-control tax_charge tax_dropdawn" multiple="multiple"  name="time_entry_tax[<?php echo $value; ?>][]" >					
																		<?php
																		$tax_id=explode(',',$data->time_entry_tax);
																		$obj_invoice= new MJ_lawmgt_invoice();
																		$hmgt_taxs=$obj_invoice->MJ_lawmgt_get_all_tax_data();	
																		
																		if(!empty($hmgt_taxs))
																		{
																			foreach($hmgt_taxs as $entry)
																			{	
																				$selected = "";
																				if(in_array($entry->tax_id,$tax_id))
																					$selected = "selected";
																				?>
																				<option value="<?php echo esc_attr($entry->tax_id); ?>" <?php echo $selected; ?> ><?php echo esc_html($entry->tax_title);?>-<?php echo esc_html($entry->tax_value);?></option>
																			<?php 
																			}
																		}
																		?>
																	</select>	
																</div>
																<div class="col-sm-3 margin_bottom_5px">
																	<input type="button"  value="<?php esc_html_e('Delete','lawyer_mgt');?>" class="remove_time_entry btn btn-danger height_39_px_css">
																</div>
															</div><hr>
											 <?php
															}
														} 
														else
														{
															?>
																<input type="hidden" value="-1" name="time_increment"  class="time_increment">
															<?php
														}
													}
												?>	
										</div>
									</div>
									<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
										<input type="button" value="<?php esc_html_e('Add More Time Entries','lawyer_mgt') ?>" onclick="MJ_lawmgt_add_time_entry()" class=" btn demo btn-success">
									</div>
								<!--------->
									<div class="header">	
										<h3 class="first_hed expense_header"><?php esc_html_e('Expenses','lawyer_mgt');?></h3>
										<hr>
									</div>
									<div class="expenses_entry_div">
										<div class="main_expenses_entry_div">
											<?php
												if(!$edit)
												{ 
												?>
													<input type="hidden" value="-1" name="expenses_increment"  class="expenses_increment">
												<?php
												}
														if($edit)
														{ 
															$result_expenses=$obj_invoice->MJ_lawmgt_get_single_invoice_expenses($invoice_id);
														?>
															<input type="hidden" value="<?php echo sizeof($result_expenses); ?>" name="expenses_increment"  class="expenses_increment">
														<?php
															if(!empty($result_expenses))
															{						
															$value = -1;
															 foreach($result_expenses as $data)
															 { 
																$value++;

																?>		
															<div class="form-group">
																<label class="col-sm-2 control-label" for="medicine_name"><?php esc_html_e('Expenses Entries','lawyer_mgt');?><span class="require-field">*</span></label>
																<div class="col-sm-3 margin_bottom_5px">
																	<input   class="form-control invoice_td_height text-input validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]"  type="text" value="<?php if($edit){ echo esc_attr($data->expense);}elseif(isset($_POST['expense'])) { echo esc_attr($_POST['expense']); } ?>" name="expense[]" placeholder="<?php esc_html_e('Enter expense','lawyer_mgt');?>">
																</div>
																<div class="col-sm-3 margin_bottom_5px has-feedback">
																
																	<input  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date date_css form-control has-feedback-left validate[required]" type="text"  name="expense_date[]"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($data->expense_date)); }elseif(isset($_POST['expense_date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['expense_date'])); } ?>" readonly>
																	
																	<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
																	<span id="inputSuccess2Status2" class="sr-only">(success)</span>
																</div>	
																<div class="col-sm-3 margin_bottom_5px">
																	<textarea  rows="1" class=" validate[custom[address_description_validation],maxSize[150]]"  placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>"  name="expense_description[]"><?php if($edit){ $data->description;}elseif(isset($_POST['expense_description'])){ echo esc_textarea($_POST['expense_description']); } ?></textarea>
																</div>
																
															</div>
															<div class="form-group"> 
																<div class="col-sm-3 offset-sm-2 margin_bottom_5px">
																	<input class="form-control invoice_td_height validate[required] expense_quantity<?php echo $value;?> added_subtotal_expenses" onKeyPress="if(this.value.length==2) return false;" min="1" type="number" value="<?php if($edit){ echo esc_attr($data->quantity);}elseif(isset($_POST['expense_quantity'])){ echo esc_attr($_POST['expense_quantity']); } ?>" name="expense_quantity[]" row="<?php echo $value;?>" placeholder="<?php esc_html_e('Enter quantity','lawyer_mgt');?>">
																</div>
																<div class="col-sm-3 margin_bottom_5px">
																	<input class="form-control invoice_td_height validate[required] expense_price<?php echo $value;?> added_subtotal_expenses" onKeyPress="if(this.value.length==8) return false;" min="0" type="number"  step="0.01" value="<?php if($edit){ echo esc_attr($data->price);}elseif(isset($_POST['expense_price'])) { echo esc_attr($_POST['expense_price']); } ?>" name="expense_price[]" row="<?php echo $value;?>" placeholder="<?php esc_html_e('Enter Price','lawyer_mgt');?>">
																</div>
																<div class="col-sm-3 margin_bottom_5px">
																	<input class="form-control invoice_td_height expense_sub<?php echo $value;?>" row="<?php echo $value;?>" type="text" value="<?php if($edit){ echo esc_attr($data->subtotal);}elseif(isset($_POST['expense_sub'])){ echo esc_attr($_POST['expense_sub']); } ?>" name="expense_sub[]" readonly="readonly">
																</div>
															</div>
															<div class="form-group">
																<div class="col-sm-3 offset-sm-2 margin_bottom_5px">
																	<input class="form-control height_34_px_css validate[min[0],max[100]] text-input" type="number" step="0.01" value="<?php if($edit){ echo esc_attr($data->expenses_entry_discount);}elseif(isset($_POST['expenses_entry_discount'])){ echo esc_attr($_POST['expenses_entry_discount']); } ?>" name="expenses_entry_discount" placeholder="<?php esc_html_e('Enter Discount in (%)','lawyer_mgt');?>" >
																</div>
																<div class="col-sm-3 margin_bottom_5px">
																	<select  class="form-control tax_charge tax_dropdawn" multiple="multiple" name="expenses_entry_tax[<?php echo $value; ?>][]" >	  <?php
																		$tax_id=explode(',',$data->expenses_entry_tax);
																		$obj_invoice= new MJ_lawmgt_invoice();
																		$hmgt_taxs=$obj_invoice->MJ_lawmgt_get_all_tax_data();	
																		
																		if(!empty($hmgt_taxs))
																		{
																			foreach($hmgt_taxs as $entry)
																			{	
																				$selected = "";
																				if(in_array($entry->tax_id,$tax_id))
																					$selected = "selected";
																				?>
																				<option value="<?php echo esc_attr($entry->tax_id); ?>" <?php echo $selected; ?> ><?php echo esc_html($entry->tax_title);?>-<?php echo esc_html($entry->tax_value);?></option>
																			<?php 
																			}
																		}
																		?>
																	</select>	
																</div>
																<div class="col-sm-3 margin_bottom_5px">
																	<input type="button" value="<?php esc_html_e('Delete','lawyer_mgt');?>" class="remove_expenses_entry btn btn-danger invoice_button">
																</div>
															</div><hr>
											 <?php
															}
														}
														else
														{
															?>
																<input type="hidden" value="-1" name="expenses_increment"  class="expenses_increment">
															<?php
														}
													}
												?>	
										</div>
										 
									</div>
									
									<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
										<input type="button" value="<?php esc_attr_e('Add More Expenses','lawyer_mgt') ?>" onclick="MJ_lawmgt_add_expense()" class=" btn demo btn-success">
									</div>
								<!-------------->
										 
									<div class="header">	
										<h3 class="first_hed expense_header"><?php esc_html_e('Flat fee','lawyer_mgt');?></h3>
										<hr>
									</div>
										
									<div class="flat_entry_div">
										<div class="main_flat_entry_div">
											<?php if(!$edit)
												{ 
												?>
													<input type="hidden" value="-1" name="flat_increment"  class="flat_increment">
												<?php
												}
													if($edit)
													{ 
														$result_flat=$obj_invoice->MJ_lawmgt_get_single_invoice_flat_fee($invoice_id);
														?>
														<input type="hidden" value="<?php echo sizeof($result_flat); ?>" name="flat_increment"  class="flat_increment">
														<?php
															if(!empty($result_flat))
															{						
																$value = -1;
															 foreach($result_flat as $data)
															 { 
																$value--;

																?>	
															<div class="form-group">
																<label class="col-sm-2 control-label" for="medicine_name"><?php esc_html_e('Flat Entries','lawyer_mgt');?><span class="require-field">*</span></label>
																<div class="col-sm-3 margin_bottom_5px">
																	<input  class="form-control text-input validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] invoice_td_height"  type="text" value="<?php if($edit){ echo esc_attr($data->flat_fee);}elseif(isset($_POST['flat_fee'])){ echo esc_attr($_POST['flat_fee']); } ?>" name="flat_fee[]" placeholder="<?php esc_html_e('Enter Flat fee','lawyer_mgt');?>">
																</div>
																<div class="col-sm-3 margin_bottom_5px has-feedback">
																
																	<input  data-date-format=<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date date_css form-control has-feedback-left validate[required]" type="text"  name="flat_fee_date[]"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box(esc_attr($data->flat_fee_date)));}elseif(isset($_POST['flat_fee_date'])) { echo MJ_lawmgt_getdate_in_input_box(esc_attr($_POST['flat_fee_date'])); } ?>" readonly>
																	<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
																	<span id="inputSuccess2Status2" class="sr-only">(success)</span>
																</div>	
																<div class="col-sm-3 margin_bottom_5px">
																	<textarea rows="1" class=" validate[custom[address_description_validation],maxSize[150]]" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" name="flat_fee_description[]"><?php if($edit){ echo esc_textarea($data->description);}elseif(isset($_POST['flat_fee_description'])) { echo esc_textarea($_POST['flat_fee_description']); } ?></textarea>
																</div>
																
															</div>
															<div class="form-group">
																<div class="col-sm-3 offset-sm-2 margin_bottom_5px">
																	<input  class="form-control text-input validate[required]  invoice_td_height flat_fee_quantity<?php echo $value;?> added_subtotal_flat_fee" onKeyPress="if(this.value.length==2) return false;" type="number" min="1" value="<?php if($edit){ echo esc_attr($data->quantity);}elseif(isset($_POST['flat_fee_quantity'])){ echo esc_attr($_POST['flat_fee_quantity']); } ?>" name="flat_fee_quantity[]" row="<?php echo $value;?>" placeholder="<?php esc_html_e('Enter quantity','lawyer_mgt');?>">
																</div>
																<div class="col-sm-3 margin_bottom_5px">
																	<input   class="form-control text-input validate[required,min[0],maxSize[8]] invoice_td_height flat_fee_price<?php echo $value;?> added_subtotal_flat_fee" type="number" step="0.01" value="<?php if($edit){ echo esc_attr($data->price);}elseif(isset($_POST['flat_fee_price'])){ echo esc_attr($_POST['flat_fee_price']); } ?>" name="flat_fee_price[]" row="<?php echo $value;?>" placeholder="<?php esc_html_e('Enter Price','lawyer_mgt');?>">
																</div>
																<div class="col-sm-3 margin_bottom_5px">
																	<input  class="form-control text-input invoice_td_height flat_fee_sub<?php echo $value;?>" row="<?php echo $value;?>" type="text" value="<?php if($edit){ echo esc_attr($data->subtotal);}elseif(isset($_POST['flat_fee_sub'])){ echo esc_attr($_POST['flat_fee_sub']); } ?>" name="flat_fee_sub[]" readonly="readonly">
																</div>
															</div>
															<div class="form-group">
																<div class="col-sm-3 offset-sm-2 margin_bottom_5px">
																	<input class="form-control height_34_px_css validate[min[0],max[100]] text-input" type="number" step="0.01" value="<?php if($edit){ echo esc_attr($data->flat_entry_discount);}elseif(isset($_POST['flat_entry_discount'])) { echo esc_attr($_POST['flat_entry_discount']); } ?>" name="flat_entry_discount" placeholder="<?php esc_html_e('Enter Discount in (%)','lawyer_mgt');?>" >
																</div>
																<div class="col-sm-3 margin_bottom_5px">
																	<select  class="form-control tax_charge tax_dropdawn" multiple="multiple" name="flat_entry_tax[<?php echo $value; ?>][]" >					
																		<?php
																		$tax_id=explode(',',$data->flat_entry_tax);
																		$obj_invoice= new MJ_lawmgt_invoice();
																		$hmgt_taxs=$obj_invoice->MJ_lawmgt_get_all_tax_data();	
																		
																		if(!empty($hmgt_taxs))
																		{
																			foreach($hmgt_taxs as $entry)
																			{	
																				$selected = "";
																				if(in_array($entry->tax_id,$tax_id))
																					$selected = "selected";
																				?>
																				<option value="<?php echo esc_attr($entry->tax_id); ?>" <?php echo $selected; ?> ><?php echo esc_html($entry->tax_title);?>-<?php echo esc_html($entry->tax_value);?></option>
																			<?php 
																			}
																		}
																		?>
																	</select>		
																</div>
																<div class="col-sm-3 margin_bottom_5px">
																	<input type="button" value="<?php esc_attr_e('Delete','lawyer_mgt');?>" class="remove_flat_entry btn btn-danger invoice_button">
																</div>
															</div><hr>
											 <?php
															}
														} 
														else
														{
															?>
																<input type="hidden" value="-1" name="flat_increment"  class="flat_increment">
															<?php
														}
													}
												?>	
										</div>
										
									</div>
									<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
										<input type="button" value="<?php esc_attr_e('Add More Flat fee','lawyer_mgt') ?>" onclick="MJ_lawmgt_add_flat_fee()" class=" btn demo btn-success">
									</div>
									<div class="header">	
										<h3 class="first_hed expense_header"><?php esc_html_e('Notes,Terms & Conditions','lawyer_mgt');?></h3>
										<hr>
									</div>	
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="note"><?php esc_html_e('Note','lawyer_mgt');?><span class="require-field"></span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<?php 
											$setting=array(
											'media_buttons' => false,
											'quicktags' => false,
											'textarea_rows' => 10,
											);
											if($edit)
											{
												wp_editor(stripslashes($invoice_info->note),'note',$setting);
											}
											else
											{
												wp_editor( '', 'note', $setting );
											}
											 ?>
										</div>
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="terms"><?php esc_html_e('Terms & Conditions','lawyer_mgt');?><span class="require-field"></span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<?php 
											 $setting=array(
											 'media_buttons' => false,
											 'quicktags' => false,
											 'textarea_rows' => 10,
											 );
											 if($edit)
											{
												wp_editor(stripslashes($invoice_info->terms),'terms',$setting);
											}
											else
											{
												wp_editor( '', 'terms', $setting );
											}
											 ?>
											  
										</div>
									</div>		
									<div class="offset-sm-2 col-sm-8">
										<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Add Invoice','lawyer_mgt');}?>" name="save_invoice" class="btn btn-success"/>
									</div>
							</form>
						</div>        
						<?php		
						}	 
						if($active_tab == 'invoicedetails')
						{
							$obj_case=new MJ_lawmgt_case;
							$obj_invoice=new MJ_lawmgt_invoice;
							$invoice_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['invoice_id']));
							$invoice_info=$obj_invoice->MJ_lawmgt_get_single_invoice($invoice_id);	
							$user_id=esc_attr($invoice_info->user_id);	
							$case_id=esc_attr($invoice_info->case_id);
							$case_info = $obj_case->MJ_lawmgt_get_single_case($case_id);	
							$user_info=get_userdata($user_id); 	
							 
							?>							
							 <div class="modal-body invoice_body"><!-- MODEL BODY DIV  -->
								<div>
									<img class="invoicefont1"  src="<?php echo plugins_url('/lawyers-management/assets/images/invoice.jpg'); ?>" width="100%">
									<div class="main_div">	
										 
											<table class="width_100" border="0">					
												<tbody>
													<tr>
														<td class="width_1">
															<img class="system_logo"  src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
														</td>							
														<td class="only_width_20">
															<table border="0">					
																<tbody>
																	<tr>																	
																		<td class="invoice_add">
																			<b><?php esc_html_e('Address:','lawyer_mgt');?></b>
																		</td>	
																		<td class="padding_left_5">
																			<?php echo chunk_split(get_option( 'lmgt_address' ),15,"<BR>").""; ?>
																		</td>											
																	</tr>
																	<tr>																	
																		<td>
																			<b><?php esc_html_e('Email :','lawyer_mgt');?></b>
																		</td>	
																		<td class="padding_left_5">
																			<?php echo esc_html(get_option( 'lmgt_email' ))."<br>"; ?>
																	</tr>
																	<tr>																	
																		<td>
																			<b><?php esc_html_e('Phone :','lawyer_mgt');?></b>
																		</td>	
																		<td class="padding_left_5">
																			<?php echo esc_html(get_option( 'lmgt_contact_number' ))."<br>";  ?>
																		</td>											
																	</tr>
																</tbody>
															</table>							
														</td>
														<td align="right" class="width_24">
														</td>
													</tr>
												</tbody>
											</table>

										<table class="width_50" border="0">
											<tbody>				
												<tr>
													<td colspan="2" class="billed_to" align="center">								
														<h3 class="billed_to_lable" ><?php esc_html_e('| Bill To.','lawyer_mgt');?> </h3>
													</td>
													<td class="width_60">								
													<?php 							
														echo "<h3 class='display_name'>".chunk_split(ucwords(esc_html($user_info->display_name)),30,"<BR>"). "</h3>";
														$address=$user_info->address;						
														echo chunk_split(esc_html($address),30,"<BR>"); 	
														echo esc_html($user_info->city_name).","; 
														echo esc_html($user_info->pin_code)."<br>"; 
														echo esc_html($user_info->mobile)."<br>"; 								
													?>			
													</td>
												</tr>									
											</tbody>
										</table>
											<?php 	
											$issue_date=MJ_lawmgt_getdate_in_input_box($invoice_info->generated_date);						
											$payment_status=$invoice_info->payment_status;
											$invoice_no=$invoice_info->invoice_number;
															?>
										<table class="width_50" border="0">
											<tbody>				
												<tr>	
													<td class="width_30">
													</td>
													<td class="width_10" align="center">
														<h3 class="invoice_lable"><span class="font_size_12_px_css"><?php echo esc_html__('INVOICE','lawyer_mgt'); '#'?><br></span><span class="font_size_18_px_css"><?php echo esc_html($invoice_no);?></span></h3>
														<h5> <?php   echo esc_html__('Date','lawyer_mgt')." : ".esc_html($issue_date); ?></h5>
														<span><?php echo esc_html__('Status','lawyer_mgt')." : ". esc_html__($payment_status,'lawyer_mgt');?></span>									
													</td>							
												</tr>									
											</tbody>
										</table>
										<?php  
										$id=1;
										$result_time=$obj_invoice->MJ_lawmgt_get_single_invoice_time_entry($invoice_id);
										$time_entry_sub_total=0;
										$time_entry_discount=0;
										$time_entry_total_tax=0;
										$time_entry_total_amount=0;
										if(!empty($result_time))
										{		
										?>
										<table class="width_100">	
											<tbody>		
												<tr>
													<td>						
														<h3 class="entry_lable"><?php esc_html_e('Time Entries','lawyer_mgt');?></h3>
													</td>
												</tr>	
											</tbody>	
										</table>
										<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<table class="table table-bordered table_row_color" border="1">
												<thead class="entry_heading">					
														<tr>
															<th class="color_white align_center">#</th>
															<th class="color_white align_center"> <?php esc_html_e('DATE','lawyer_mgt');?></th>
															<th class="color_white"><?php esc_html_e('TIME ENTRY ACTIVITY','lawyer_mgt');?> </th>
															<th class="color_white align_center"><?php esc_html_e('HOURS','lawyer_mgt');?></th>
															<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('AMOUNT','lawyer_mgt');?></th>
															<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('DISCOUNT','lawyer_mgt');?></th>
															<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('TAX','lawyer_mgt');?></th>
															<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('TOTAL AMOUNT','lawyer_mgt');?></th>
															
														</tr>						
												</thead>
												<tbody>
												<?php					
													foreach($result_time as $data)
														{
															$time_entry_sub=$data->subtotal;							
															$discount=$time_entry_sub/100 * $data->time_entry_discount;
															$time_entry_discount+=$discount;
															$after_discount_time_entry_sub=$time_entry_sub-$discount;
															$tax=$data->time_entry_tax;
															
															$tax1_total_amount='0';
															
															if(!empty($tax))
															{
																$tax_explode=explode(",",$tax);

																$total_tax=0;
															
																foreach($tax_explode as $tax1)
																{
																	$taxvalue=MJ_lawmgt_tax_value_by_id($tax1);
																	$total_tax+=$taxvalue->tax_value;
																} 
																if(!empty($total_tax))
																{	
																	$tax1_total_amount=$after_discount_time_entry_sub / 100 * $total_tax ;
																}
															}
															$time_entry_total_tax+=$tax1_total_amount;
															$time_entry_sub_total+=$time_entry_sub;	
															$time_entry_total_sub_amount=$time_entry_sub - $discount + $tax1_total_amount;
															$time_entry_total_amount+=$time_entry_total_sub_amount;
															 
														?>						 
														  <tr class="entry_list">
															<td class="align_center"><?php echo esc_html($id);?></td>
															<td class="align_center"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($data->time_entry_date));?></td>
															<td><?php echo esc_html($data->time_entry);?></td>							
															<td class="align_center"><?php echo esc_html($data->hours);?></td>
															<td class="align_right"><?php echo  number_format(esc_html($data->subtotal),2);?></td>
															<td class="align_right"><?php echo  number_format(esc_html($discount),2);?></td>
															<td class="align_right"><?php echo  number_format(esc_html($tax1_total_amount),2);?></td>
															<td class="align_right"><?php echo  number_format(esc_html($time_entry_total_sub_amount),2);?></td>
														  </tr>
														<?php
														$id=$id+1;
														}
															?>
														<tr class="entry_list">							
															<td colspan="7" class="align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().") :</span>".esc_html_e('Time Entries Total Amount ','lawyer_mgt');?></td>
															<td class="align_right"><?php echo  number_format(esc_html($time_entry_total_amount),2);?></td>		
														</tr>
														<?php	
													}						
													?>
												</tbody>
											</table>
										</div>
										<?php   
												$id=1;
												$result_expence=$obj_invoice->MJ_lawmgt_get_single_invoice_expenses($invoice_id);
												$expense_sub_total=0;
												$expense_discount=0;
												$expense_total_tax=0;
												$expense_entry_total_amount=0;
												if(!empty($result_expence))
												{	?>
										<table class="width_100">	
											<tbody>		
												<tr>
													<td>						
														<h3 class="entry_lable"><?php esc_html_e('Expenses Entries','lawyer_mgt');?></h3>
													</td>
												</tr>	
											</tbody>	
										</table>
										<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<table class="table table-bordered table_row_color" border="1">
												<thead class="entry_heading">					
														<tr>
															<th class="color_white align_center">#</th>
															<th class="color_white align_center"> <?php esc_html_e('DATE','lawyer_mgt');?></th>
															<th class="color_white"><?php esc_html_e('EXPENSES ACTIVITY','lawyer_mgt');?> </th>	
															<th class="color_white align_center"><?php esc_html_e('QUANTITY','lawyer_mgt');?></th>
															<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('AMOUNT','lawyer_mgt');?></th>
															<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('DISCOUNT','lawyer_mgt');?></th>
															<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('TAX','lawyer_mgt');?></th>
															<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('TOTAL AMOUNT','lawyer_mgt');?></th>														
														</tr>						
												</thead>
												<tbody>
												<?php					
													
													foreach($result_expence as $data)
													{ 							
														$expense_sub=$data->subtotal;
														$discount=$expense_sub/100 * $data->expenses_entry_discount;							
														$expense_discount+=$discount;
														$after_discount_expense=$expense_sub-$discount;
														$tax=$data->expenses_entry_tax;
														$tax1_total_amount='0';
															
															if(!empty($tax))
															{
																$tax_explode=explode(",",$tax);

																$total_tax=0;
															
																foreach($tax_explode as $tax1)
																{
																	$taxvalue=MJ_lawmgt_tax_value_by_id($tax1);
																	$total_tax+=$taxvalue->tax_value;
																} 
																if(!empty($total_tax))
																{	
																	$tax1_total_amount=$after_discount_expense / 100 * $total_tax ;
																}
															}
														 
															$expense_total_tax+=$tax1_total_amount;
															$expense_sub_total+=$expense_sub;
															$expense_entry_total_sub_amount=$expense_sub - $discount + $tax1_total_amount;
															$expense_entry_total_amount+=$expense_entry_total_sub_amount;
														?>						 
													  <tr class="entry_list">
														<td class="align_center"><?php echo esc_html($id);?></td>
														<td class="align_center"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($data->expense_date));?></td>
														<td><?php echo esc_html($data->expense);?></td>							
														<td class="align_center"><?php echo esc_html($data->quantity);?></td>
														<td class="align_right"><?php echo  number_format(esc_html($data->subtotal),2);?></td>
														<td class="align_right"><?php echo  number_format(esc_html($discount),2);?></td>
														<td class="align_right"><?php echo  number_format(esc_html($tax1_total_amount),2);?></td>
														<td class="align_right"><?php echo  number_format(esc_html($expense_entry_total_sub_amount),2);?></td>								
													  </tr>
														<?php
														$id=$id+1;
													}
														?>
														 <tr class="entry_list">							
															<td colspan="7" class="align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().") :</span>".esc_html_e('Expenses Entries Total Amount ','lawyer_mgt');?></td>
															<td class="align_right"><?php echo  number_format(esc_html($expense_entry_total_amount),2);?></td>
														 </tr>
														<?php	
												}		
													?>
												</tbody>
											</table>
										</div>
										<?php  
											$id=1;
											$result_falt=$obj_invoice->MJ_lawmgt_get_single_invoice_flat_fee($invoice_id);
											$flat_fee_sub_total=0;
											$flat_fee_discount=0;
											$flat_fee_total_tax=0;
											$flat_entry_total_amount=0;
											if(!empty($result_falt))
											{	
												?>
										<table class="width_100">	
											<tbody>		
												<tr>
													<td>						
														<h3 class="entry_lable"><?php esc_html_e('Flat Fees Entries','lawyer_mgt');?></h3>
													</td>
												</tr>	
											</tbody>	
										</table>
										<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<table class="table table-bordered table_row_color" border="1">
												<thead class="entry_heading">					
														<tr>
															<th class="color_white align_center">#</th>
															<th class="color_white align_center"> <?php esc_html_e('DATE','lawyer_mgt');?></th>
															<th class="color_white"><?php esc_html_e('FLATE FEE ACTIVITY','lawyer_mgt');?> </th>	
															<th class="color_white align_center"><?php esc_html_e('QUANTITY','lawyer_mgt');?></th>
															<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('AMOUNT','lawyer_mgt');?></th>
															<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('DISCOUNT','lawyer_mgt');?></th>
															<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('TAX','lawyer_mgt');?></th>
															<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('TOTAL AMOUNT','lawyer_mgt');?></th>																						
														</tr>						
												</thead>
												<tbody>
												<?php					
													
														foreach($result_falt as $data)
														{							
															$flat_fee_sub=$data->subtotal;
															$discount=$flat_fee_sub/100 * $data->flat_entry_discount;							
															$flat_fee_discount+=$discount;
															$after_discount_flat_fee=$flat_fee_sub-$discount;
															$tax=$data->flat_entry_tax;
															$tax1_total_amount='0';
															
															if(!empty($tax))
															{
																$tax_explode=explode(",",$tax);

																$total_tax=0;
															
																foreach($tax_explode as $tax1)
																{
																	$taxvalue=MJ_lawmgt_tax_value_by_id($tax1);
																	$total_tax+=$taxvalue->tax_value;
																} 
																if(!empty($total_tax))
																{	
																	$tax1_total_amount=$after_discount_flat_fee / 100 * $total_tax ;
																}
															}
															 
															$flat_fee_total_tax+=$tax1_total_amount;
															$flat_fee_sub_total+=$flat_fee_sub;	
															$flat_entry_total_sub_amount=$flat_fee_sub - $discount + $tax1_total_amount;
															$flat_entry_total_amount+=$flat_entry_total_sub_amount;
															?>						 
															  <tr class="entry_list">
																<td class="align_center"><?php echo esc_html($id);?></td>
																<td class="align_center"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($data->flat_fee_date));?></td>
																<td><?php echo esc_html($data->flat_fee);?></td>
																<td class="align_center"><?php echo esc_html($data->quantity);?></td>
																<td class="align_right"><?php echo  number_format(esc_html($data->subtotal),2);?></td>
																<td class="align_right"><?php echo  number_format(esc_html($discount,2));?></td>
																<td class="align_right"><?php echo  number_format(esc_html($tax1_total_amount),2);?></td>
																<td class="align_right"><?php echo  number_format(esc_html($flat_entry_total_sub_amount),2);?></td>
															  </tr>
															<?php
															$id=$id+1;
														}
														?>
														 <tr class="entry_list">							
															<td colspan="7" class="align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().") :</span>".esc_html_e('Flat Fees Total Amount ','lawyer_mgt');?></td>
															<td class="align_right"><?php echo number_format(esc_html($flat_entry_total_amount),2);?></td>		
														 </tr>
														<?php	
													}		
													?>
												</tbody>
											</table>
										</div>
										<table class="width_54" border="0">
											<tbody>
												<?php						
													$bank_name=get_option( 'lmgt_bank_name' );
													$account_holder_name=get_option( 'lmgt_account_holder_name' );
													$account_number=get_option( 'lmgt_account_number' );
													$account_type=get_option( 'lmgt_account_type' );
													$ifsc_code=get_option( 'lmgt_ifsc_code' );
													$swift_code=get_option( 'lmgt_swift_code' );						
													
													$subtotal_amount=$time_entry_sub_total+$expense_sub_total+$flat_fee_sub_total;
													 
													$discount_amount=$time_entry_discount+$expense_discount+$flat_fee_discount;
													 
													$tax_amount=$time_entry_total_tax+$expense_total_tax+$flat_fee_total_tax;
												 
													$due_amount=$subtotal_amount-$discount_amount+$tax_amount-$invoice_info->paid_amount;
													$paid_amount=$invoice_info->paid_amount;
													$grand_total=$subtotal_amount-$discount_amount+$tax_amount;
												?>
												<tr>
													<h4><td class="width_80 align_right"><h4 class="margin"><?php esc_html_e('Subtotal Amount:','lawyer_mgt');?></h4></td>
													<td class="align_right amount_padding_15"> <h4 class="margin"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".number_format(esc_html($subtotal_amount),2);?></h4></td>
												</tr>
												
													<tr>
														<td class="width_80 align_right"><h4 class="margin"><?php esc_html_e('Discount Amount :','lawyer_mgt');?></h4></td>
														<td class="align_right amount_padding_15"> <h4 class="margin"><?php if(!empty($discount_amount)){ echo "<span> -(".MJ_lawmgt_get_currency_symbol().")</span>".number_format(esc_html($discount_amount),2); }else{ echo "<span> -(".MJ_lawmgt_get_currency_symbol().")</span>".'0'; } ?></h4></td>
													</tr>
													<tr>
														<td class="width_80 align_right"><h4 class="margin"><?php esc_html_e('Tax Amount :','lawyer_mgt');?></h4></td>
														<td class="align_right amount_padding_15"><h4 class="margin"><?php if(!empty($tax_amount)){ echo "<span> +(".MJ_lawmgt_get_currency_symbol().")</span>".number_format(esc_html($tax_amount),2); }else{ echo "<span>+(".MJ_lawmgt_get_currency_symbol().")</span>".'0'; }?></h4></td>
													</tr>
													<tr>
														<td class="width_80 align_right"><h4 class="margin"><?php esc_html_e('Paid Amount :','lawyer_mgt');?></h4></td>
														<td class="align_right amount_padding_15"> <h4 class="margin"><span ><?php if(!empty($paid_amount)){ echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".number_format(esc_html($paid_amount),2); }else{ echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".'0'; }?></h4></td>
													</tr>						
													<tr>
														<td class="width_80 align_right due_amount_color"><h4 class="margin"><?php esc_html_e('Due Amount :','lawyer_mgt');?></h4></td>
														<td class="align_right amount_padding_15 due_amount_color"> <h4 class="margin"><span ><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".number_format(esc_html($due_amount),2); ?></h4></td>
													</tr>
												<tr>							
													<td class="align_right grand_total_lable padding_11"><h3 class="padding color_white margin"><?php esc_html_e('Grand Total :','lawyer_mgt');?></h3></td>
													<td class="align_right grand_total_amount amount_padding_15"><h3 class="padding color_white margin"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".number_format(esc_html($grand_total),2); ?></h3></td>
												</tr>							
											</tbody>
										</table>		
										<table class="width_46" border="0">
											<tbody>	
											<?php  if(!empty($bank_name))  {  ?>
												<tr>
													<td colspan="2">
														<h3 class="payment_method_lable"><?php esc_html_e('Payment Method','lawyer_mgt');?>
														</h3>
													</td>								
												</tr>	
											<?php   } ?>
											<?php  if(!empty($bank_name))  {  ?>
												<tr>
													<td class="width_31 font_12"><?php esc_html_e('Bank Name ','lawyer_mgt');  ?></td>
													<td class="font_12">: <?php echo esc_html($bank_name);?></td>
												</tr>
											<?php   } ?>
											<?php  if(!empty($account_holder_name))  {  ?>
												<tr>
													<td class="width_31 font_12"><?php esc_html_e('A/C Holder Name ','lawyer_mgt'); ?></td>
													<td class="font_12">: <?php echo esc_html($account_holder_name);?></td>
												</tr>
											<?php   } ?>
											<?php  if(!empty($account_number))  {  ?>
												<tr>
													<td class="width_31 font_12"><?php esc_html_e('Account No ','lawyer_mgt'); ?></td>
													<td class="font_12">: <?php echo esc_html($account_number);?></td>
												</tr>
											<?php   } ?>
											<?php  if(!empty($account_type))  {  ?>
												<tr>
													<td class="width_31 font_12"><?php esc_html_e('Account Type ','lawyer_mgt'); ?></td>
													<td class="font_12">: <?php echo esc_html($account_type);?></td>
												</tr>
											<?php   } ?>
											<?php  if(!empty($ifsc_code))  {  ?>
												<tr>
													<td class="width_31 font_12"><?php esc_html_e('IFSC Code ','lawyer_mgt'); ?></td>
													<td class="font_12">: <?php echo esc_html($ifsc_code);?></td>
												</tr>
											<?php   } ?>
											<?php  if(!empty($swift_code))  {  ?>	
												<tr>
													<td class="width_31 font_12"><?php esc_html_e('Swift Code ','lawyer_mgt'); ?></td>
													<td class="font_12">: <?php echo esc_html($swift_code);?></td>
												</tr>
											<?php   } ?>
											<?php  if(!empty($bank_name))  {  ?>
												<tr>
													<td class="width_31 font_12"> <?php esc_html_e('Paypal ','lawyer_mgt'); ?></td>
													<td class="font_12">: <?php echo esc_html(get_option( 'lmgt_paypal_email' ));?></td>
												</tr>
											<?php   } ?>
											</tbody>
										</table>	
											<?php   
												$id=1;
												$result_payment=$obj_invoice->MJ_lawmgt_get_single_payment_data($invoice_id);
												 
												if(!empty($result_payment))
												{	?>
										<table class="width_100">	
											<tbody>		
												<tr>
													<td>						
														<h3 class="entry_lable"><?php esc_html_e('Payment History','lawyer_mgt');?></h3>
													</td>
												</tr>	
											</tbody>	
										</table>
										<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<table class="table table-bordered table_row_color" border="1">
												<thead class="entry_heading">					
														<tr>
															<th class="color_white align_center">#</th>
															<th class="color_white align_center"> <?php esc_html_e('DATE','lawyer_mgt');?></th>
															<th class="color_white align_center"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('AMOUNT','lawyer_mgt');?></th>
															<th class="color_white align_center"><?php esc_html_e('PAYMENT METHOD','lawyer_mgt');?> </th>
														</tr>						
												</thead>
												<tbody>
												<?php					
													
													foreach($result_payment as $data)
													{ 							
														?>						 
													  <tr class="entry_list">
														<td class="align_center"><?php echo esc_html($id);?></td>
														<td class="align_center"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($data->date));?></td>
														<td class="align_center"><?php echo  number_format(esc_html($data->amount),2);?></td>
														<td class="align_center"><?php echo esc_html($data->payment_method);?></td>
													  </tr>
														<?php
														$id=$id+1;
													}
												}		
													?>
												</tbody>
											</table>
										</div>										
										<?php			
										$gst_number=get_option( 'lmgt_gst_number' );
										$tax_id=get_option( 'lmgt_tax_id' );
										$corporate_id=get_option( 'lmgt_corporate_id' );
										?>							
										<table class="table_invoice gst_details" border="0">
										<thead>
											<tr>
											<?php 
												if(!empty($gst_number))
												{
												?>
												<th class="align_center"> <?php esc_html_e('GST Number','lawyer_mgt');?></th>
											<?php 
												}
												if(!empty($tax_id))
												{
												?>
												<th class="align_center"> <?php esc_html_e('TAX ID','lawyer_mgt');?></th>
											<?php 
												}
												if(!empty($corporate_id))
												{
												?>
												<th class="align_center"> <?php esc_html_e('Corporate ID','lawyer_mgt');?></th>
												<?php
												}  
												?>
											</tr>	
										</thead>
										<tbody>
											<tr>								
												<td class="align_center"><?php echo esc_html($gst_number);?></td>
												<td class="align_center"><?php echo esc_html($tax_id);?></td>
												<td class="align_center"><?php echo esc_html($corporate_id);?></td>
											</tr>	
										</tbody>
										</table>
										</table>
										<table class="width_100 margin_bottom_20" border="0">				
											<tbody>
												<?php  
												if(!empty($invoice_info->note))
												{
												?>
												<tr>
													<td colspan="2">
														<h3 class="payment_method_lable"><?php esc_html_e('Note','lawyer_mgt');?>
														</h3>
													</td>								
												</tr>
												<tr>
													<td class="font_12 padding_left_15"><?php echo wordwrap(esc_html($invoice_info->note),50,"<br>\n",TRUE);?></td>
												</tr>
												<?php  }  ?>
												<?php  
												if(!empty($invoice_info->terms))
												{
												?>
												<tr>
													<td colspan="2">
														<h3 class="payment_method_lable"><?php esc_html_e('Terms & Conditions','lawyer_mgt');?>
														</h3>
													</td>								
												</tr>
												<tr>
													<td class="font_12 padding_left_15"><?php echo wordwrap(esc_html($invoice_info->terms),50,"<br>\n",TRUE);?></td>
												</tr>	
											<?php  }  ?>
											</tbody>
											
										</table>
										<div class="print-button pull-left">
											<a  href="?page=invoice&print=print&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($invoice_id));?>" target="_blank"class="btn btn-success"><?php esc_html_e('Print','lawyer_mgt');?></a>	
											<a  href="?page=invoice&invoicepdf=invoicepdf&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($invoice_id));?>" target="_blank"class="btn btn-success"><?php esc_html_e('PDF','lawyer_mgt');?></a>				
										</div>
									</div>
								</div>
								
							</div><!-- END MODEL BODY DIV  -->
						 <?php 
						}
						 ?>
						 <script type="text/javascript">
							jQuery(document).ready(function($)
							{
								 "use strict";	
								$('#tax_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
							});
						</script>
						 <?php 	
						if($active_tab == 'add_tax')
						{
							$tax_id=0;
							if(isset($_REQUEST['tax_id']))
							$tax_id=sanitize_text_field($_REQUEST['tax_id']);
							$edit=0;
							if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit_tax')
							{
								$edit=1;
								$result = $obj_invoice->MJ_lawmgt_get_single_tax_data($tax_id);
							}
							?>
							<div class="panel-body"><!-- PANEL BODY DIV START-->
								<form name="tax_form" action="" method="post" class="form-horizontal" id="tax_form">
									<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
									<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
									<input type="hidden" name="tax_id" value="<?php echo esc_attr($tax_id);?>">						
									<?php wp_nonce_field( 'save_tax_nonce' ); ?>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for=""><?php esc_html_e("Tax Name","lawyer_mgt");?><span class="require-field">*</span></label>
										<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
										<input id="" maxlength="30" class="form-control validate[required,custom[address_description_validation]] text-input" type="text" value="<?php if($edit){ echo esc_attr($result->tax_title);}elseif(isset($_POST['tax_title'])){ echo esc_attr($_POST['tax_title']); } ?>" name="tax_title">
									   </div>
									</div>  
									
									<div class="form-group">
									   <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for=""><?php esc_html_e("Tax Value","lawyer_mgt");?>(%)<span class="require-field">*</span></label>
										<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
											<input id="tax" class="form-control validate[required,custom[number]] text-input" onkeypress="if(this.value.length==6) return false;" step="0.01" type="number" value="<?php if($edit){ echo esc_attr($result->tax_value);}elseif(isset($_POST['tax_value'])){ echo esc_attr($_POST['tax_value']); } ?>" name="tax_value" min="0" max="100">
										</div>
									</div>
									<div class="form-group">
										<div class="offset-sm-2 col-sm-8">
											<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Save','lawyer_mgt');}?>" name="save_tax" class="btn btn-success"/>
										</div>
									</div>
								</form>
							</div><!-- PANEL BODY DIV END-->    
						<?php 
						}
						 if($active_tab == 'taxlist')
						{
							?>
							<script type="text/javascript">
							jQuery(document).ready(function($)
							{
								"use strict"; 
								jQuery('#tax_list').DataTable({
									"responsive": true,
									"autoWidth": false,
									"order": [[ 1, "asc" ]],
									language:<?php echo wpnc_datatable_multi_language();?>,
									 "aoColumns":[
												  {"bSortable": true},
												  {"bSortable": false} <?php
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
							</script>
						<div class="tab-pane  tabs fade  active in" id="nav-open" role="tabpanel" aria-labelledby="nav-open-tab">
							<form name="" action="" method="post" enctype='multipart/form-data'>
								<div class="panel-body">
									<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">	
										<table id="tax_list" class="tax_list table table-striped table-bordered">
											<thead>	
												<?php  ?>
												<tr>
													<th><?php esc_html_e('Tax Name', 'lawyer_mgt' ) ;?></th>
													<th> <?php esc_html_e('Tax Value', 'lawyer_mgt' ) ;?> (%)</th>
													<?php  
													if($user_access['edit']=='1' || $user_access['delete']=='1')
													{
														?>
															<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
													<?php 
													}  
													?>
												</tr>
												<br/>
											</thead>
											<tbody>
												<?php
												 
												$taxdata=$obj_invoice->MJ_lawmgt_get_all_tax_data();
												 
												if(!empty($taxdata))
												{													
													foreach ($taxdata as $retrieved_data)
													{
														?>
														<tr>
															<td class=""><?php echo esc_html($retrieved_data->tax_title); ?></td>
															<td class=""><?php echo esc_html($retrieved_data->tax_value); ?></td>
														<?php  
														if($user_access['edit']=='1' || $user_access['delete']=='1')
														{
														?>
															<td class="action">		
																<?php
																if($user_access['edit']=='1')
																{
																	?>
																		<a href="?dashboard=user&page=invoice&tab=add_tax&action=edit_tax&tax_id=<?php echo esc_html($retrieved_data->tax_id);?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a><?php
																}
																if($user_access['delete']=='1')
																{
																	?>								
																	<a href="?dashboard=user&page=invoice&tab=taxlist&action=delete_tax&tax_id=<?php echo esc_html($retrieved_data->tax_id);?>" class="btn btn-danger" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');"><?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>
																<?php
																}
																?>
															</td>
														<?php 
														}  ?>
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
						?>
					</div>							
				</div>
			</div>
		</div><!-- END  MAIN WRAPER  DIV -->
	</div>
</div><!-- END  PAGE INNER DIV -->