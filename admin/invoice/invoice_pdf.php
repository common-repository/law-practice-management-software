<?php 
$obj_case=new MJ_lawmgt_case;
$obj_invoice=new MJ_lawmgt_invoice;
$invoice_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['invoice_id']));
$invoice_info=$obj_invoice->MJ_lawmgt_get_single_invoice($invoice_id);
$user_id=sanitize_text_field($invoice_info->user_id);	
$case_id=sanitize_text_field($invoice_info->case_id);
$case_info = $obj_case->MJ_lawmgt_get_single_case($case_id);	
$user_info=get_userdata($user_id); 	
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="invoice.pdf"');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');	
require LAWMS_PLUGIN_DIR. '/lib/mpdf/mpdf.php';	
 $mpdf	=	new mPDF('c','A4','','' , 5 , 5 , 5 , 0 , 0 , 0); 
	$mpdf->debug = true;
	$mpdf->WriteHTML('<html>');
	$mpdf->WriteHTML('<head>');
	$mpdf->WriteHTML('<style>
				table.invoiceDetails>tbody>tr>td
				{
					border-top:none;
				}
				</style>');
	$mpdf->WriteHTML('</head>');
	$mpdf->WriteHTML('<body>');	
	
	$mpdf->SetTitle('Invoice Sleep');
		$mpdf->WriteHTML('<div class="panel-body">');	
		$mpdf->WriteHTML('<div class="row">');	
			$mpdf->WriteHTML('<div class="col-xs-12">');	
				$mpdf->WriteHTML('<h3><b>'.esc_html(get_option( 'lmgt_system_name' )).'</b></h3>');		
				$mpdf->WriteHTML('<div>');
				$mpdf->WriteHTML('<label>'.esc_html(get_option( 'lmgt_address' )).'</label>');	
				$mpdf->WriteHTML('</div>');	
				$mpdf->WriteHTML('<div>');
				$mpdf->WriteHTML('<label>'.esc_html(get_option( 'lmgt_contry' )).'</label>');	
				$mpdf->WriteHTML('</div>');	
				$mpdf->WriteHTML('<div>');
				$mpdf->WriteHTML('<label>'.esc_html(get_option( 'lmgt_contact_number' )).'</label>');	
				$mpdf->WriteHTML('</div>');		
			$mpdf->WriteHTML('</div>');		
		$mpdf->WriteHTML('</div>');	
		$mpdf->WriteHTML('<div class="row">');	
			$mpdf->WriteHTML('<div class="col-xs-10">');	
				$mpdf->WriteHTML('<h3><b>'.esc_html($user_info->display_name).'</b></h3>');		
				$mpdf->WriteHTML('<div>');
				$mpdf->WriteHTML('<label>'.esc_html($user_info->address).'</label>');	
				$mpdf->WriteHTML('</div>');	
				$mpdf->WriteHTML('<div>');
				$mpdf->WriteHTML('<label>'.esc_html($user_info->city_name).'</label>');	
				$mpdf->WriteHTML('</div>');	
				$mpdf->WriteHTML('<div>');
				$mpdf->WriteHTML('<label>'.esc_html($user_info->state_name).'</label>');	
				$mpdf->WriteHTML('</div>');		
			$mpdf->WriteHTML('</div>');	
			$mpdf->WriteHTML('<div class="col-xs-2">');		
				$mpdf->WriteHTML('<table class="table invoiceDetails float_right_css">');		
				$mpdf->WriteHTML('<tbody>');		
					$mpdf->WriteHTML('<tr>');		
						$mpdf->WriteHTML('<td class="text-right">Invoice Number :</td>');		
						$mpdf->WriteHTML('<td class="text-left">'.esc_html($invoice_info->invoice_number).'</td>');		
					$mpdf->WriteHTML('</tr>');	
					$mpdf->WriteHTML('<tr>');		
						$mpdf->WriteHTML('<td class="text-right">Invoice Date :</td>');		
						$mpdf->WriteHTML('<td class="text-left">'.esc_html(MJ_lawmgt_getdate_in_input_box($invoice_info->generated_date)).'</td>');		
					$mpdf->WriteHTML('</tr>');	
					$mpdf->WriteHTML('<tr>');		
						$mpdf->WriteHTML('<td class="text-right">Due Date :</td>');		
						$mpdf->WriteHTML('<td class="text-left">'.esc_html(MJ_lawmgt_getdate_in_input_box($invoice_info->due_date)).'</td>');		
					$mpdf->WriteHTML('</tr>');	
				$mpdf->WriteHTML('</tbody>');	
				$mpdf->WriteHTML('</table>');	
			$mpdf->WriteHTML('</div>');	
			$mpdf->WriteHTML('<div class="margin_top_20px_css">');		
				$mpdf->WriteHTML('<hr class="border_top_dashed_2px_css">');		
			$mpdf->WriteHTML('</div>');		
			$mpdf->WriteHTML('<div class="row">');	
			$mpdf->WriteHTML('<div>');	
			$mpdf->WriteHTML('<h3><b>'.esc_html($case_info->case_name).'</b></h3>');	
			$mpdf->WriteHTML('</div>');	
			$mpdf->WriteHTML('</div>');	
			
			$mpdf->WriteHTML('<div class="row">');	
			$mpdf->WriteHTML('<h3>Time Entries Activity</h3>');	
			$mpdf->WriteHTML('<table class="table table-bordered">');	
			$mpdf->WriteHTML('<thead>');	
			$mpdf->WriteHTML('<tr>');	
			$mpdf->WriteHTML('<th>Date</th>');	
			$mpdf->WriteHTML('<th>Time Entry Activity</th>');	
			$mpdf->WriteHTML('<th>Description</th>');	
			$mpdf->WriteHTML('<th>Hours</th>');	
			$mpdf->WriteHTML('<th>Rate</th>');	
			$mpdf->WriteHTML('<th>Sub total</th>');	
			$mpdf->WriteHTML('</div>');	
			$mpdf->WriteHTML('</div>');	
			$mpdf->WriteHTML('</div>');	
			$mpdf->WriteHTML('</tr>');	
			$mpdf->WriteHTML('</thead>');
			$mpdf->WriteHTML('<tbody>');

			$result=$obj_invoice->MJ_lawmgt_get_single_invoice_time_entry($invoice_id);
			if(!empty($result))
			{			
				$time_entry_totals=0;
				$time_entry_total_tax=0;
				foreach($result as $data)
				{ 
					$time_entry_sub=$data->subtotal;
					$tax1=$data->tax1;
					$tax2=$data->tax2;
					$total_tax=$time_entry_sub / 100 * $tax1 + $time_entry_sub / 100 * $tax2;
					$time_entry_total_tax+=$time_entry_sub / 100 * $tax1 + $time_entry_sub / 100 * $tax2;
					$time_entry_totals+=$time_entry_sub-$total_tax;
					
					$mpdf->WriteHTML('<tr>');						 	
					$mpdf->WriteHTML('<td>'.esc_html(MJ_lawmgt_getdate_in_input_box($data->time_entry_date)).'</td>');						 	
					$mpdf->WriteHTML('<td>'.esc_html($data->time_entry).'</td>');						 	
					$mpdf->WriteHTML('<td>'.esc_html($data->description).'</td>');						 	
					$mpdf->WriteHTML('<td>'.esc_html($data->hours).'</td>');						 	
					$mpdf->WriteHTML('<td>'.esc_html($data->rate).'</td>');						 	
					$mpdf->WriteHTML('<td>'.esc_html($data->subtotal).'</td>');					 	
											
					$mpdf->WriteHTML('</tr>');				 	
												
				}
			}	
				$mpdf->WriteHTML('<tr>');	
					$mpdf->WriteHTML('<td colspan="5" class="text-right">Time Entries Total Amount:</td>');	
					$mpdf->WriteHTML('<td>'.esc_html($time_entry_totals).'</td>');	
				$mpdf->WriteHTML('</tr>');		
			$mpdf->WriteHTML('</tbody>');
			$mpdf->WriteHTML('</table>');			
			$mpdf->WriteHTML('</div>');	
		
			$mpdf->WriteHTML('<div class="row">');	
			$mpdf->WriteHTML('<h3>Expenses</h3>');	
			$mpdf->WriteHTML('<table class="table table-bordered">');	
			$mpdf->WriteHTML('<thead>');	
			$mpdf->WriteHTML('<tr>');	
			$mpdf->WriteHTML('<th>Date</th>');	
			$mpdf->WriteHTML('<th>Expenses Activity</th>');	
			$mpdf->WriteHTML('<th>Description</th>');	
			$mpdf->WriteHTML('<th>Quantity</th>');	
			$mpdf->WriteHTML('<th>Price</th>');	
			$mpdf->WriteHTML('<th>Sub total</th>');	
			$mpdf->WriteHTML('</div>');	
			$mpdf->WriteHTML('</div>');	
			$mpdf->WriteHTML('</div>');	
			$mpdf->WriteHTML('</tr>');	
			$mpdf->WriteHTML('</thead>');
			$mpdf->WriteHTML('<tbody>');
			
				$result=$obj_invoice->MJ_lawmgt_get_single_invoice_expenses($invoice_id);
					
				if(!empty($result))
				{	
					$expense_totals=0;			
					$expense_total_tax=0;			
					foreach($result as $data)
					{ 
						$expense_sub=$data->subtotal;
						$tax1=$data->tax1;
						$tax2=$data->tax2;
						$total_tax=$expense_sub / 100 * $tax1 + $expense_sub / 100 * $tax2;
						$expense_total_tax+=$expense_sub / 100 * $tax1 + $expense_sub / 100 * $tax2;
						$expense_totals+=$expense_sub-$total_tax;
			
						$mpdf->WriteHTML('<tr>');						 	
						$mpdf->WriteHTML('<td>'.esc_html(MJ_lawmgt_getdate_in_input_box($data->expense_date)).'</td>');						 	
						$mpdf->WriteHTML('<td>'.esc_html($data->expense).'</td>');						 	
						$mpdf->WriteHTML('<td>'.esc_html($data->description).'</td>');						 	
						$mpdf->WriteHTML('<td>'.esc_html($data->quantity).'</td>');						 	
						$mpdf->WriteHTML('<td>'.esc_html($data->price).'</td>');						 	
						$mpdf->WriteHTML('<td>'.esc_html($data->subtotal).'</td>');					 	
												
						$mpdf->WriteHTML('</tr>');				 	
												
				}
			}	
				$mpdf->WriteHTML('<tr>');	
					$mpdf->WriteHTML('<td colspan="5" class="text-right">Expenses Total Amount:</td>');	
					$mpdf->WriteHTML('<td>'.esc_html($expense_totals).'</td>');	
				$mpdf->WriteHTML('</tr>');		
			$mpdf->WriteHTML('</tbody>');
			$mpdf->WriteHTML('</table>');			
			$mpdf->WriteHTML('</div>');	
			
			$mpdf->WriteHTML('<div class="row">');	
			$mpdf->WriteHTML('<h3>Flat fee</h3>');	
			$mpdf->WriteHTML('<table class="table table-bordered">');	
			$mpdf->WriteHTML('<thead>');	
			$mpdf->WriteHTML('<tr>');	
			$mpdf->WriteHTML('<th>Date</th>');	
			$mpdf->WriteHTML('<th>Flat fee Activity</th>');	
			$mpdf->WriteHTML('<th>Description</th>');	
			$mpdf->WriteHTML('<th>Quantity</th>');	
			$mpdf->WriteHTML('<th>Price</th>');	
			$mpdf->WriteHTML('<th>Sub total</th>');	
			$mpdf->WriteHTML('</div>');	
			$mpdf->WriteHTML('</div>');	
			$mpdf->WriteHTML('</div>');	
			$mpdf->WriteHTML('</tr>');	
			$mpdf->WriteHTML('</thead>');
			$mpdf->WriteHTML('<tbody>');
			
					$result=$obj_invoice->MJ_lawmgt_get_single_invoice_flat_fee($invoice_id);
					if(!empty($result))
					{	
						$flat_fee_totals=0;							
						$flat_fee_total_tax=0;							
						foreach($result as $data)
						{
							$flat_fee_sub=$data->subtotal;
							$tax1=$data->tax1;
							$tax2=$data->tax2;
							$total_tax=$flat_fee_sub / 100 * $tax1 + $flat_fee_sub / 100 * $tax2;
							$flat_fee_total_tax+=$flat_fee_sub / 100 * $tax1 + $flat_fee_sub / 100 * $tax2;
							$flat_fee_totals+=$flat_fee_sub-$total_tax;
			
						$mpdf->WriteHTML('<tr>');						 	
						$mpdf->WriteHTML('<td>'.esc_html(MJ_lawmgt_getdate_in_input_box($data->flat_fee_date)).'</td>');						 	
						$mpdf->WriteHTML('<td>'.esc_html($data->flat_fee).'</td>');						 	
						$mpdf->WriteHTML('<td>'.esc_html($data->description).'</td>');						 	
						$mpdf->WriteHTML('<td>'.esc_html($data->quantity).'</td>');						 	
						$mpdf->WriteHTML('<td>'.esc_html($data->price).'</td>');						 	
						$mpdf->WriteHTML('<td>'.esc_html($data->subtotal).'</td>');					 	
												
						$mpdf->WriteHTML('</tr>');				 	
												
				}
			}	
				$mpdf->WriteHTML('<tr>');	
					$mpdf->WriteHTML('<td colspan="5" class="text-right">Flat fee Total Amount:</td>');	
					$mpdf->WriteHTML('<td>'.esc_html($flat_fee_totals).'</td>');	
				$mpdf->WriteHTML('</tr>');		
			$mpdf->WriteHTML('</tbody>');
			$mpdf->WriteHTML('</table>');			
			$mpdf->WriteHTML('</div>');	
			
			$mpdf->WriteHTML('<div class="row">');	
				$mpdf->WriteHTML('<div class="col-xs-7 padding_right_invoice_css">');	
				$mpdf->WriteHTML('<div class="padding_10px_css">');	
					$mpdf->WriteHTML('<h3>Terms & Conditions</h3>');	
					$mpdf->WriteHTML('<label>'.esc_html($invoice_info->terms).'</label>');	
				$mpdf->WriteHTML('</div>');	
				$mpdf->WriteHTML('<div class="padding_10_px_css">');	
					$mpdf->WriteHTML('<h3>Notes</h3>');	
					$mpdf->WriteHTML('<label>'.esc_html($invoice_info->note).'</label>');	
				$mpdf->WriteHTML('</div>');	
			$mpdf->WriteHTML('<div class="col-xs-2">');	
			$mpdf->WriteHTML('</div>');	
			
			$mpdf->WriteHTML('<div class="col-xs-3 padding_right_invoice_css">');	
			$mpdf->WriteHTML('<div class="padding_10px_css">');	
			$mpdf->WriteHTML('<table class="table invoiceDetails" >');	
			$mpdf->WriteHTML('<tbody>');	
			$mpdf->WriteHTML('<tr>');	
				$mpdf->WriteHTML('<td class="text-right">Time Entry Sub-Total Amount :</td>');	
				$mpdf->WriteHTML('<td class="text-left">'.esc_html($time_entry_totals).'</td>');	
			$mpdf->WriteHTML('</tr>');	
			$mpdf->WriteHTML('<tr>');	
				$mpdf->WriteHTML('<td class="text-right">Expenses Sub-Total Amount :</td>');	
				$mpdf->WriteHTML('<td class="text-left">'.esc_html($expense_totals).'</td>');	
			$mpdf->WriteHTML('</tr>');
			$mpdf->WriteHTML('<tr>');	
				$mpdf->WriteHTML('<td class="text-right">Flat fee Sub-Total Amount :</td>');	
				$mpdf->WriteHTML('<td class="text-left">'.esc_html($flat_fee_totals).'</td>');	
			$mpdf->WriteHTML('</tr>');			
				$sub_total=$time_entry_totals+$expense_totals+$flat_fee_totals;			
			$mpdf->WriteHTML('<tr>');	
				$mpdf->WriteHTML('<td class="text-right"><b>Sub-Total Amount :</b></td>');
				$mpdf->WriteHTML('<td class="text-left">'.esc_html($sub_total).'</td>');					
			$mpdf->WriteHTML('</tr>');
			$total_tax=$time_entry_total_tax+$expense_total_tax+$flat_fee_total_tax;
			$mpdf->WriteHTML('<tr>');	
				$mpdf->WriteHTML('<td class="text-right"><b>Total Tax  :</b></td>');
				$mpdf->WriteHTML('<td class="text-left">'.esc_html($total_tax).'</td>');					
			$mpdf->WriteHTML('</tr>');
					$discount_per=$invoice_info->discount;
					$discount=$sub_total/100 * $discount_per;
			$mpdf->WriteHTML('<tr>');	
				$mpdf->WriteHTML('<td class="text-right"><b>Discount Amount :</b></td>');
				$mpdf->WriteHTML('<td class="text-left">'.esc_html($discount).'</td>');					
			$mpdf->WriteHTML('</tr>');	
			$total=$sub_total-$discount;			
			$mpdf->WriteHTML('<tr>');	
				$mpdf->WriteHTML('<td class="text-right"><b>Total Amount  :</b></td>');
				$mpdf->WriteHTML('<td class="text-left">'.esc_html($total).'</td>');					
			$mpdf->WriteHTML('</tr>');
			$mpdf->WriteHTML('<tr>');	
				$mpdf->WriteHTML('<td class="text-right"><b>Paid Amount :</b></td>');
				$mpdf->WriteHTML('<td class="text-left">'.esc_html($amount_paid=$invoice_info->paid_amount).'</td>');					
			$mpdf->WriteHTML('</tr>');
			$mpdf->WriteHTML('</tbody>');
			$mpdf->WriteHTML('</table>');			
			$mpdf->WriteHTML('</div>');	
			
			$mpdf->WriteHTML('<div class="text-right padding_10_px_css">');	
			$mpdf->WriteHTML('<table class="table invoiceDetails" >');	
			$mpdf->WriteHTML('<tbody>');
			$balance_due=$total-$amount_paid;			
			$mpdf->WriteHTML('<tr>');	
				$mpdf->WriteHTML('<td class="text-right"><b>Due Amount :</b></td>');
				$mpdf->WriteHTML('<td class="text-left">'.esc_html($balance_due).'</td>');					
			$mpdf->WriteHTML('</tr>');
			$mpdf->WriteHTML('</tbody>');
			$mpdf->WriteHTML('</table>');			
			$mpdf->WriteHTML('</div>');	
			
	$mpdf->WriteHTML('</div>');	 
	
	$mpdf->WriteHTML("</body>");
	$mpdf->WriteHTML("</html>");
	$mpdf->Output();	
	unset($mpdf);	
	die; 	
?>