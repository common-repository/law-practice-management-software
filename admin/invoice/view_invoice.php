<?php
$obj_case=new MJ_lawmgt_case;
$obj_invoice=new MJ_lawmgt_invoice;
$invoice_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['invoice_id']));
$invoice_info=$obj_invoice->MJ_lawmgt_get_single_invoice($invoice_id);	
$user_id= sanitize_text_field($invoice_info->user_id);	
$case_id=sanitize_text_field($invoice_info->case_id);
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
										<td class="invoice_add" >
											<b><?php esc_html_e('Address:','lawyer_mgt');?></b>
										</td>	
										<td class="padding_left_5">
											<?php echo chunk_split(esc_html(get_option( 'lmgt_address' )),15,"<BR>").""; ?>
										</td>											
									</tr>
									<tr>																	
										<td>
											<b><?php esc_html_e('Email :','lawyer_mgt');?></b>
										</td>	
										<td class="padding_left_5">
											<?php echo esc_html(get_option( 'lmgt_email' ))."<br>"; ?>
										</td>	
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
							<h3 class="invoice_lable"><span class="font_size_12_px_css"><?php echo esc_html__('INVOICE','lawyer_mgt'); '#' ?><br></span><span class="font_size_18_px_css"><?php echo esc_html($invoice_no);?></span></h3>
							<h5> <?php   echo esc_html__('Date','lawyer_mgt')." : ".esc_html($issue_date); ?></h5>
							<h5><?php echo esc_html__('Status','lawyer_mgt')." : ". esc_html__($payment_status,'lawyer_mgt');?></h5>									
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
									<td class="align_right"><?php echo  number_format(esc_html($discount),2);?></td>
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
						<td class="width_80 align_right"><h4 class="margin"><?php esc_html_e('Subtotal Amount:','lawyer_mgt');?></h4></td>
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
						<td class="align_right grand_total_lable  padding_11"><h3 class="padding color_white margin"><?php esc_html_e('Grand Total :','lawyer_mgt');?></h3></td>
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
						<td class="font_12">: <?php echo get_option( 'lmgt_paypal_email' );?></td>
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
						}  ?>
						<?php 
						if(!empty($tax_id))
						{
						?>
						<th class="align_center"> <?php esc_html_e('TAX ID','lawyer_mgt');?></th>
						<?php
						}  ?>
						<?php 
						if(!empty($corporate_id))
						{
						?>
						<th class="align_center"> <?php esc_html_e('Corporate ID','lawyer_mgt');?></th>
						<?php
						}  ?>
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
			<a  href="?page=invoice&print=print&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($invoice_id));?>" target="_blank" class="btn btn-success"><?php esc_html_e('Print','lawyer_mgt');?></a>	
			<a  href="?page=invoice&invoicepdf=invoicepdf&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($invoice_id));?>" target="_blank" class="btn btn-success"><?php esc_html_e('PDF','lawyer_mgt');?></a>				
		</div>
		</div>
	</div>
</div><!-- END MODEL BODY DIV  -->