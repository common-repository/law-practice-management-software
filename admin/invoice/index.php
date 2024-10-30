<?php 	
$obj_invoice=new MJ_lawmgt_invoice;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'invoicelist');
$invoice_columns_array=explode(',',get_option('lmgt_invoice_columns_option'));
$result=null;
if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
{
	//wp_redirect (admin_url().'admin.php?page=lmgt_system');
	$redirect_url=admin_url().'admin.php?page=lmgt_system';
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
<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="invoice_data">
			</div>
		</div>
    </div> 
</div>
<!-- End POP-UP Code -->
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV -->
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' ));?></h3>
	  </div>
	</div>
	<?php
	if(isset($_POST['add_fee_payment']))
	{
		//POP up data save
		$result=$obj_invoice->MJ_lawmgt_add_feepayment($_POST);			
		if($result)
		{
			//wp_redirect ( admin_url() . 'admin.php?page=invoice&tab=invoicelist&message=4');
			$redirect_url=admin_url().'admin.php?page=invoice&tab=invoicelist&message=4';
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
	if(isset($_POST['save_invoice']))
	{	
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_invoice_nonce' ) )
		{ 
			if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='edit')
			{	
				$result=$obj_invoice->MJ_lawmgt_add_invoice($_POST);
					
				if($result)
				{
					//wp_redirect ( admin_url() . 'admin.php?page=invoice&tab=invoicelist&message=2');
					$redirect_url=admin_url().'admin.php?page=invoice&tab=invoicelist&message=2';
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
					//wp_redirect ( admin_url() . 'admin.php?page=invoice&tab=invoicelist&message=1');
					$redirect_url=admin_url().'admin.php?page=invoice&tab=invoicelist&message=1';
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
			//wp_redirect ( admin_url() . 'admin.php?page=invoice&tab=invoicelist&message=3');
			$redirect_url=admin_url().'admin.php?page=invoice&tab=invoicelist&message=3';
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
			$selected_id = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ) );
			$all = implode(",", $selected_id);			
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
			//wp_redirect ( admin_url() . 'admin.php?page=invoice&tab=invoicelist&message=3');
			$redirect_url=esc_url(admin_url().'admin.php?page=invoice&tab=invoicelist&message=3');
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
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_tax_nonce' ) )
		{
			if($_REQUEST['action']=='edit_tax')
			{				
				$result=$obj_invoice->MJ_lawmgt_add_tax($_POST);
				
				if($result)	
				{			
					//wp_redirect ( admin_url() . 'admin.php?page=invoice&tab=taxlist&message=6');
					$redirect_url= esc_url(admin_url().'admin.php?page=invoice&tab=taxlist&message=6');
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
					//wp_redirect ( admin_url() . 'admin.php?page=invoice&tab=taxlist&message=5');
					$redirect_url= esc_url(admin_url().'admin.php?page=invoice&tab=taxlist&message=5');
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
			//wp_redirect ( admin_url() . 'admin.php?page=invoice&tab=taxlist&message=7');
			$redirect_url= esc_url(admin_url().'admin.php?page=invoice&tab=taxlist&message=7');
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
	<div id="main-wrapper">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<h2 class="nav-tab-wrapper">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="tablist">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'invoicelist' ? 'active' : ''; ?> menucss">
									<a href="?page=invoice&tab=invoicelist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Invoice List', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_invoice' ? 'active' : ''; ?> menucss">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
								{?>
								<a href="?page=invoice&tab=add_invoice&&action=edit&invoice_id=<?php echo esc_attr($_REQUEST['invoice_id']);?>">
									<?php esc_html_e('Edit Invoice', 'lawyer_mgt'); ?>
								</a>  
								<?php 
								}			
								else
								{?>
									<a href="?page=invoice&tab=add_invoice">
										<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Invoice', 'lawyer_mgt');?>
									</a>  
								<?php  
								}?>
								</li>
								<?php 
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
								{
								?>
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'invoicedetails' ? 'active' : ''; ?> menucss">
										<a href="?page=invoice&tab=invoicedetails&action=view&invoice_id=<?php echo esc_attr($_REQUEST['invoice_id']);?>">
											<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('Invoice Details', 'lawyer_mgt'); ?>
										</a>
									</li>
						  <?php } ?>
							<li role="presentation" class="<?php echo esc_html($active_tab) == 'invoiceactivity' ? 'active' : ''; ?> menucss">
								<a href="?page=invoice&tab=invoiceactivity">
									<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('Invoice Activity', 'lawyer_mgt'); ?>
								</a>
							</li>
							<li role="presentation" class="<?php echo esc_html($active_tab) == 'taxlist' ? 'active' : ''; ?> menucss">
									<a href="?page=invoice&tab=taxlist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Tax List', 'lawyer_mgt'); ?>
									</a>
							</li> 
							
							<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_tax' ? 'active' : ''; ?> menucss">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit_tax')
								{?>
								<a href="?page=invoice&tab=add_tax&&action=edit_tax&tax_id=<?php echo esc_attr($_REQUEST['tax_id']);?>">
									<?php esc_html_e('Edit Tax', 'lawyer_mgt'); ?>
								</a>  
								<?php 
								}			
								else
								{?>
									<a href="?page=invoice&tab=add_tax">
										<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Tax', 'lawyer_mgt');?>
									</a>  
								<?php  
								}?>
							</li>
							
						  </ul>
						</h2>
						<?php 	
						if($active_tab == 'invoicelist')
						{ ?>	
							<script type="text/javascript">
							    var $ = jQuery.noConflict();
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
												$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice();
												if(!empty($invoicedata))
												{	
													foreach ($invoicedata as $retrieved_data)
													{
														$user_id= sanitize_text_field($retrieved_data->user_id);
														$userdata=get_userdata($user_id);
														$conatc_name='<a href="?page=contacts&tab=viewcontact&action=view&contact_id='.MJ_lawmgt_id_encrypt(esc_attr($userdata->ID)).'">'.$userdata->display_name.'</a>';
												?>
												<tr>
													<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_attr($retrieved_data->id); ?>"></td>
											<?php if(in_array('invoice_number',$invoice_columns_array)) { ?>
													<td><?php echo esc_html($retrieved_data->invoice_number);?></td>
											<?php  }  ?>
											<?php if(in_array('invoice_date',$invoice_columns_array)) {  ?>
													<td><?php echo esc_attr(MJ_lawmgt_getdate_in_input_box($retrieved_data->generated_date));?></td>		
											<?php  }  ?>
											<?php if(in_array('due_date',$invoice_columns_array)) {  ?>		
													<td><?php echo esc_attr(MJ_lawmgt_getdate_in_input_box($retrieved_data->due_date));?></td>
											 <?php  }  ?>			
													<?php if(in_array('invoice_billing_contact_name',$invoice_columns_array)) { ?>
													<td><?php echo $conatc_name;?></td>
											 <?php  }  ?>
											 <?php if(in_array('invoice_case_name',$invoice_columns_array)) {  
													 				
													$case_id=$retrieved_data->case_id;
													$case_name=$obj_invoice->MJ_lawmgt_get_all_case_name_from_case_id($case_id); ?>
													<td><a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>"><?php echo esc_html($case_name->case_name);?></a></td>
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
															<a href="?page=invoice&tab=invoicedetails&action=view&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
															<a href="?page=invoice&tab=add_invoice&action=edit&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
															<a href="?page=invoice&tab=invoicelist&action=delete&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($case_id));?>&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" 
															onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');">
															<?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>		
														<?php 
														}
														else 
														{
														?>						   
															<a href="#"  class="show-payment-popup btn btn-default" case_id="<?php echo $retrieved_data->case_id; ?>" invoice_id="<?php echo $retrieved_data->id; ?>" view_type="payment" due_amount="<?php echo number_format($retrieved_data->due_amount,2, '.', '');?>"><?php esc_html_e('Pay','lawyer_mgt');?></a>	
															<a href="?page=invoice&tab=invoicedetails&action=view&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
															<a href="?page=invoice&tab=add_invoice&action=edit&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
															<a href="?page=invoice&tab=invoicelist&action=delete&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($case_id));?>&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" 
															onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');">
															<?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>		
													 <?php
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
										<?php if(!empty($invoicedata))
											{	
										?>
										<div class="form-group">		
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
												<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="invoice_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
											</div>
										</div>
											<?php }  ?>
									</div>
								</div>
							</form>
						<?php 
						}
						if($active_tab == 'add_invoice')
						{		
							require_once LAWMS_PLUGIN_DIR. '/admin/invoice/add_invoice.php';		
						} 
						if($active_tab == 'add_tax')
						{		
							require_once LAWMS_PLUGIN_DIR. '/admin/invoice/add_tax.php';		
						} 
						if($active_tab == 'taxlist')
						{		
							require_once LAWMS_PLUGIN_DIR. '/admin/invoice/tax_list.php';		
						} 
						if($active_tab == 'invoicedetails')
						{
							require_once LAWMS_PLUGIN_DIR. '/admin/invoice/view_invoice.php';	 
						}
						if($active_tab == 'invoiceactivity')
						{
							require_once LAWMS_PLUGIN_DIR. '/admin/invoice/invoice_activity.php';	 
						}
						?>
					</div>			
				</div>
			</div>
		</div>
	</div><!-- END  MAIN WRAPER  DIV -->
</div><!-- END  INNER PAGE  DIV -->