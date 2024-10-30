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

<?php 	
$obj_invoice=new MJ_lawmgt_invoice;

if($active_tab == 'invoice')
{
	$active_tab = isset($_GET['tab3'])?$_GET['tab3']:'invoicelist';
	?>  
	<h2>	
		<ul id="myTab" class="sub_menu_css line nav nav-tabs case_details_documents" role="tablist">
			<li role="presentation" class="<?php echo esc_html($active_tab) == 'invoicelist' ? 'active' : ''; ?> ">
				<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=invoice&tab3=invoicelist&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
					<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Invoice List', 'lawyer_mgt'); ?>				
				</a>
			</li>
			<?php if(isset($_REQUEST['edit'])&& sanitize_text_field($_REQUEST['edit'])=='true') {?>
			<li role="presentation" class="<?php echo esc_html($active_tab) == 'addinvoice' ? 'active' : ''; ?>">
				<a href="admin.php?page=cases&tab=casedetails&action=view&edit=true&tab2=invoice&tab3=addinvoice&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&invoice_id=<?php echo esc_attr($_REQUEST['invoice_id']);?>">
					<?php echo esc_html__('Edit Invoice', 'lawyer_mgt'); ?>					
				</a>
			</li>
			<?php }else{?>
			<li role="presentation" class="<?php echo esc_html($active_tab) == 'addinvoice' ? 'active' : ''; ?>">
				<a href="admin.php?page=cases&tab=casedetails&action=view&add=true&tab2=invoice&tab3=addinvoice&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
					<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Invoice', 'lawyer_mgt'); ?>	
				</a>
			</li>
			<?php 
			}
			if(isset($_REQUEST['view'])&& sanitize_text_field($_REQUEST['view'])=='true')
			{
			?>
			<li role="presentation" class="<?php echo esc_html($active_tab) == 'viewinvoice' ? 'active' : ''; ?>">
				<a href="admin.php?page=cases&tab=casedetails&action=view&view=true&tab2=invoice&tab3=viewinvoice&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&invoice_id=<?php echo esc_attr($_REQUEST['invoice_id']);?>">
					<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('View Invoice', 'lawyer_mgt'); ?>
				</a>
			</li>
			<?php
			}	?>	
		</ul>
	</h2>
	<?php
	if($active_tab=='addinvoice')
	{	 
		require_once LAWMS_PLUGIN_DIR. '/admin/cases/add_case_invoice.php'; 
	}
	if($active_tab=='viewinvoice')
	{	 
		require_once LAWMS_PLUGIN_DIR. '/admin/cases/view_case_invoice.php'; 
	}
	if($active_tab=='invoicelist')
	{
		$invoice_columns_array=explode(',',get_option('lmgt_invoice_columns_option'));		
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
							if(isset($_REQUEST['case_id']))
								$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
							 $invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice_by_caseid($case_id);
							foreach ($invoicedata as $retrieved_data)
							{
								$user_id= esc_attr($retrieved_data->user_id);
								$userdata=get_userdata($user_id);
								$conatc_name='<a href="?page=contacts&tab=viewcontact&action=view&contact_id='.MJ_lawmgt_id_encrypt(esc_attr($userdata->ID)).'">'.esc_html($userdata->display_name).'</a>';
						 ?>
							<tr>
								<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo $retrieved_data->id; ?>"></td>																								
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
													<td><?php echo $conatc_name;?></td>
											 <?php  }  ?>
											 <?php if(in_array('invoice_case_name',$invoice_columns_array)) {  
													 				
													$case_id= esc_attr($retrieved_data->case_id);
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
													<td><span class="btn btn-success btn-xs"><?php echo MJ_lawmgt_get_invoice_paymentstatus(esc_attr($retrieved_data->id)); ?></span></td>
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
											<a href="?page=cases&tab=casedetails&action=view&view=true&tab2=invoice&tab3=viewinvoice&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
											<a href="?page=cases&tab=casedetails&action=view&edit=true&tab2=invoice&tab3=addinvoice&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
											<a href="?page=cases&tab=casedetails&action=view&deleteinvoice=true&tab2=invoice&tab3=invoicelist&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" 
											onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');">
											<?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>		
										<?php 
										}
									   else 
									   {
										?>						   
											<a href="#"  class="show-payment-popup btn btn-default" case_id="<?php echo esc_attr($retrieved_data->case_id); ?>" invoice_id="<?php echo esc_attr($retrieved_data->id); ?>" view_type="payment" due_amount="<?php echo number_format(esc_html($retrieved_data->due_amount),2, '.', '');?>"><?php esc_html_e('Pay','lawyer_mgt');?></a>
											<a href="?page=cases&tab=casedetails&action=view&view=true&tab2=invoice&tab3=viewinvoice&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
											<a href="?page=cases&tab=casedetails&action=view&edit=true&tab2=invoice&tab3=addinvoice&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
											<a href="?page=cases&tab=casedetails&action=view&deleteinvoice=true&tab2=invoice&tab3=invoicelist&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" 
											onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');">
											<?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>		
									<?php
									   }
									 ?>				
								</td>               
							</tr>
							<?php } 			
						?>     
						</tbody>        
					</table>
					<?php  if(!empty($invoicedata))
					{
					?>
					<div class="form-group">		
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
							<input type="submit" class="btn delete_margin_bottom delete_check btn-danger" name="invoice_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
						</div>
					</div>
					<?php }?>
				</div>
			</div>		   
		</form>
	 <?php 
	}
}
?>	