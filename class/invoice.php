<?php  
class MJ_lawmgt_invoice /*<---START MJ_lawmgt_invoice  CLASS--->*/
{
	 /*<--- ADD INVOICE FUNCTION --->*/
	public function MJ_lawmgt_add_invoice($data)
	{	
		global $wpdb;
		$table_invoice = $wpdb->prefix. 'lmgt_invoice';
		$table_invoice_time_entries = $wpdb->prefix. 'lmgt_invoice_time_entries';
		$table_invoice_expenses = $wpdb->prefix. 'lmgt_invoice_expenses';
		$table_invoice_flat_fee = $wpdb->prefix. 'lmgt_invoice_flat_fee';
		$invoicedata['user_id']=sanitize_text_field($data['contact_name']);		
		$invoicedata['case_id']=(sanitize_text_field($data['case_name']));		
		$invoicedata['invoice_number'] = sanitize_text_field($data['invoice_number']);
		$invoicedata['generated_date'] = sanitize_text_field(date('Y-m-d',strtotime($data['invoice_generated_date'])));
		$invoicedata['due_date'] = sanitize_text_field(date('Y-m-d',strtotime($data['due_date'])));
		 
		$invoicedata['note'] = stripslashes($data['note']);
		$invoicedata['terms'] = stripslashes($data['terms']);
	 
		 
		if((esc_attr($data['action'])=='edit') || isset($_REQUEST['edit'])&& sanitize_text_field($_REQUEST['edit'])=='true')
		{	
			// edit invoice
			$invoice_id['id']=sanitize_textarea_field($data['invoice_id1']);
			$invoicedata['updated_date']=date("Y-m-d H:i:s");
			
			$result=$wpdb->update( $table_invoice, $invoicedata,$invoice_id);
			 			
			//delete time entry
			$id = $data['invoice_id1'];
			$result = $wpdb->query("DELETE FROM $table_invoice_time_entries where invoice_id= ".$id);
			
			//add time entry			 
			$time_entry_sub_total=0;
			$time_entry_discount=0;
			$time_entry_total_tax=0;
			if(!empty($data['time_entry']))
			{	
				$invoice_id = sanitize_text_field($data['invoice_id1']);
				 	
				foreach($data['time_entry'] as $key=>$time_entry)
				{

					$time_entry_sub=sanitize_text_field($data['time_entry_sub'][$key]);
					
					$discount=$time_entry_sub/100 * $data['time_entry_discount'];
					
					$time_entry_discount+=$discount;
					
					$after_discount_time_entry_sub=$time_entry_sub-$discount;
					$tax1_total_amount='0';
					if(!empty($data['time_entry_tax']))
					{
						$tax1=$data['time_entry_tax'][$key];
						
						if(!empty($tax1))
						{
							$total_tax=0;
							foreach($tax1 as $tax11)
							{
								$taxvalue=MJ_lawmgt_tax_value_by_id($tax11);
								$total_tax+=$taxvalue->tax_value;
							}
							if(!empty($total_tax))
							{	
								$tax1_total_amount=$after_discount_time_entry_sub / 100 * $total_tax ;
							}
						}
						$time_entry_tax_value=implode(",",$tax1);
					}
					else
					{
						$time_entry_tax_value=null;
					}
				 
					$total_tax=$tax1_total_amount;
					
					$time_entry_total_tax+=$total_tax;
					$time_entry_sub_total+=$time_entry_sub;	
					
					$time_entry_data['invoice_id'] = $invoice_id;
					$time_entry_data['user_id']=sanitize_text_field($data['contact_name']);		
					$time_entry_data['case_id']=sanitize_text_field($data['case_name']);
					$time_entry_data['time_entry'] = sanitize_text_field($time_entry);
					$time_entry_data['description'] = sanitize_textarea_field($data['time_entry_description'][$key]);
					$time_entry_data['time_entry_date'] = sanitize_text_field(date('Y-m-d',strtotime($data['time_entry_date'][$key])));
					$time_entry_data['billed_by'] =get_current_user_id();
					$time_entry_data['hours'] = sanitize_text_field($data['time_entry_hours'][$key]);
					$time_entry_data['rate'] = sanitize_text_field($data['time_entry_rate'][$key]);
					$time_entry_data['subtotal'] = sanitize_text_field($data['time_entry_sub'][$key]);				
					$time_entry_data['time_entry_tax'] =$time_entry_tax_value;
					$time_entry_data['time_entry_discount'] =sanitize_text_field($data['time_entry_discount']);
					$time_entry_data['total_tax_amount'] =$tax1_total_amount;
							
					$result=$wpdb->insert( $table_invoice_time_entries, $time_entry_data);								
				}
			 
			}

			//delete expense
			$id = $data['invoice_id1'];
			$result = $wpdb->query("DELETE FROM $table_invoice_expenses where invoice_id= ".$id);
			$expense_sub_total=0;
			$expense_discount=0;
			$expense_total_tax=0;
				// add expense
				$invoice_id = sanitize_text_field($data['invoice_id1']);
				if(!empty($data['expense']))
				{		
					foreach($data['expense'] as $key=>$expense)
					{			
						$expense_sub=sanitize_text_field($data['expense_sub'][$key]);
						$discount=$expense_sub/100 * sanitize_text_field($data['expenses_entry_discount']);							
						$expense_discount+=$discount;
						$after_discount_expense=$expense_sub-$discount;
						$tax1_total_amount='0';
						if(!empty($data['expenses_entry_tax']))
						{
							$tax1= $data['expenses_entry_tax'][$key];
							
							if(!empty($tax1))
							{
								$total_tax=0;
								foreach($tax1 as $tax11)
								{
									$taxvalue=MJ_lawmgt_tax_value_by_id($tax11);
									$total_tax+=$taxvalue->tax_value;
								}
								if(!empty($total_tax))
								{	
									$tax1_total_amount=$after_discount_expense / 100 * $total_tax ;
								}
							}
							$expense_entry_tax_value=implode(",",$tax1);
						}
						else
						{
							$expense_entry_tax_value=null;
						}
						 
						$total_tax=$tax1_total_amount;	
						
						$expense_total_tax+=$total_tax;
						$expense_sub_total+=$expense_sub;
					
						$expense_data['invoice_id'] = $invoice_id;
						$expense_data['user_id']=sanitize_text_field($data['contact_name']);		
						$expense_data['case_id']=sanitize_text_field($data['case_name']);		
						$expense_data['expense'] = sanitize_text_field($expense);
						$expense_data['description'] = sanitize_textarea_field($data['expense_description'][$key]);
						$expense_data['expense_date'] = sanitize_text_field(date('Y-m-d',strtotime($data['expense_date'][$key]))); 
						$expense_data['billed_by'] = get_current_user_id();
						$expense_data['quantity'] = sanitize_text_field($data['expense_quantity'][$key]);
						$expense_data['price'] = sanitize_text_field($data['expense_price'][$key]);
						$expense_data['subtotal'] = sanitize_text_field($data['expense_sub'][$key]);
						$expense_data['expenses_entry_tax'] =$expense_entry_tax_value;
						
						$expense_data['expenses_entry_discount'] =sanitize_text_field($data['expenses_entry_discount']);
						$expense_data['total_tax_amount'] =$tax1_total_amount;
											
						$result=$wpdb->insert( $table_invoice_expenses, $expense_data);								
					}
				}	
		 
		    //delete flat
			$id = $data['invoice_id1'];
			$result = $wpdb->query("DELETE FROM $table_invoice_flat_fee where invoice_id= ".$id);
			$flat_fee_sub_total=0;
			$flat_fee_discount=0;
			$flat_fee_total_tax=0;
			// add Flat fee	
			 
				$invoice_id = sanitize_text_field($data['invoice_id1']);
				if(!empty($data['flat_fee']))
				{		
					foreach($data['flat_fee'] as $key=>$flat_fee)
					{	
						$flat_fee_sub=sanitize_text_field($data['flat_fee_sub'][$key]);
						$discount=$flat_fee_sub/100 * $data['flat_entry_discount'];							
						$flat_fee_discount+=$discount;
						$after_discount_flat_fee=$flat_fee_sub-$discount;
						
						$tax1_total_amount='0';
						if(!empty($data['flat_entry_tax']))
						{
							$tax1=$data['flat_entry_tax'][$key];
							
							if(!empty($tax1))
							{
								$total_tax=0;
								foreach($tax1 as $tax11)
								{
									$taxvalue=MJ_lawmgt_tax_value_by_id($tax11);
									$total_tax+=$taxvalue->tax_value;
								}
								if(!empty($total_tax))
								{	
									$tax1_total_amount=$after_discount_flat_fee / 100 * $total_tax ;
								}
							}
							$flat_entry_tax_value=implode(",",$tax1);
						}
						else
						{
							$flat_entry_tax_value=null;
						}	
							
						$total_tax=$tax1_total_amount;	
						
						$flat_fee_total_tax+=$total_tax;
						$flat_fee_sub_total+=$flat_fee_sub;	
						
						$flat_fee_data['invoice_id'] = $invoice_id;	
						$flat_fee_data['user_id']=sanitize_text_field($data['contact_name']);		
						$flat_fee_data['case_id']=sanitize_text_field($data['case_name']);	
						$flat_fee_data['flat_fee'] = sanitize_text_field($flat_fee);
						$flat_fee_data['description'] = sanitize_textarea_field($data['flat_fee_description'][$key]);
						$flat_fee_data['flat_fee_date'] = sanitize_text_field(date('Y-m-d',strtotime($data['flat_fee_date'][$key])));  
						$flat_fee_data['billed_by'] =get_current_user_id();
						$flat_fee_data['quantity'] = sanitize_text_field($data['flat_fee_quantity'][$key]);
						$flat_fee_data['price'] = sanitize_text_field($data['flat_fee_price'][$key]);
						$flat_fee_data['subtotal'] = sanitize_text_field($data['flat_fee_sub'][$key]);				
						$flat_fee_data['flat_entry_tax'] = sanitize_text_field($flat_entry_tax_value);
						
						$flat_fee_data['flat_entry_discount'] =sanitize_text_field($data['flat_entry_discount']);
						$flat_fee_data['total_tax_amount'] =$tax1_total_amount;
											
						$result=$wpdb->insert( $table_invoice_flat_fee, $flat_fee_data);								
					}
				}	
		 
			// edit invoice Payments calculation using 
			$inv_id['id']=$invoice_id;
			$subtotal_amount=$time_entry_sub_total+$expense_sub_total+$flat_fee_sub_total;
			
			$discount_amount=$time_entry_discount+$expense_discount+$flat_fee_discount;
 
			$tax_amount=$time_entry_total_tax+$expense_total_tax+$flat_fee_total_tax;
		 
			$paid_amount=$data['paid_amount'];
			$due_amount=$subtotal_amount-$discount_amount+$tax_amount-$paid_amount;			
			$total_amount=$subtotal_amount-$discount_amount+$tax_amount;						
			
			$invoice_payment_data['total_amount'] = $total_amount;
			$invoice_payment_data['paid_amount'] = $paid_amount;
			$invoice_payment_data['due_amount'] = $due_amount;			
			$result=$wpdb->update( $table_invoice, $invoice_payment_data,$inv_id);	
			 
			//audit Log
			$case_id=sanitize_text_field($invoicedata['case_id']);
			$case_name=MJ_lawmgt_get_case_name($case_id);
			$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';
			$invoice_number=sanitize_text_field($invoicedata['invoice_number']);
			$invoice_link='<a href="?page=invoice&tab=invoicedetails&action=view&invoice_id='.MJ_lawmgt_id_encrypt(esc_attr($id)).'">'.esc_html($invoice_number).'</a>';
			$updated_invoice=esc_html__('Updated Invoice Number ','lawyer_mgt');
			MJ_lawmgt_append_audit_log($updated_invoice.' '.$invoice_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_log_for_downlaod($updated_invoice.' '.$invoice_number,get_current_user_id(),'');
			MJ_lawmgt_append_audit_invoicelog($updated_invoice.' '.$invoice_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_caselog($updated_invoice.' '.$invoice_link,get_current_user_id(),$case_link);
			MJ_lawmgt_userwise_activity($updated_invoice.' '.$invoice_link,get_current_user_id(),$case_link);
			
			MJ_lawmgt_append_audit_caselog_download($updated_invoice.' '.$invoice_number, get_current_user_id());
			MJ_lawmgt_append_audit_invoicelog_download($updated_invoice.' '.$invoice_number, get_current_user_id());
			
			return $result;
		}
		else
		{	
			// add invoice
			$invoicedata['created_date']=date("Y-m-d H:i:s");
			$invoicedata['created_by']=get_current_user_id();
			
			$result=$wpdb->insert( $table_invoice, $invoicedata);
		
			// add Time entry				
			$lastid = $wpdb->insert_id;			 
			 
			if(!empty($data['time_entry']))
			{				
				$time_entry_sub_total=0;
				$time_entry_discount=0;
				$time_entry_total_tax=0;
				
				foreach($data['time_entry'] as $key=>$time_entry)
				{	
					$time_entry_sub=sanitize_text_field($data['time_entry_sub'][$key]);
					
					$discount=$time_entry_sub/100 * $data['
					'];	
					 
					$time_entry_discount+=$discount;
					$after_discount_time_entry_sub=$time_entry_sub-$discount;
					$tax1_total_amount='0';
					if(!empty($data['time_entry_tax']))
					{
						$tax1= $data['time_entry_tax'][$key];
						
						if(!empty($tax1))
						{
							$total_tax=0;
							foreach($tax1 as $tax11)
							{
								$taxvalue=MJ_lawmgt_tax_value_by_id($tax11);
								$total_tax+=$taxvalue->tax_value;
							}
							if(!empty($total_tax))
							{	
								$tax1_total_amount=$after_discount_time_entry_sub / 100 * $total_tax ;
							}
						}
						$time_entry_tax_value=implode(",",$tax1);
					}
					else
					{
						$time_entry_tax_value=null;
					}			
				 
					$total_tax=$tax1_total_amount;
					
					$time_entry_total_tax+=$total_tax;
					$time_entry_sub_total+=$time_entry_sub;		
					
					$time_entry_data['invoice_id'] = $lastid;
					$time_entry_data['user_id']=sanitize_text_field($data['contact_name']);		
					$time_entry_data['case_id']=sanitize_text_field($data['case_name']);	
					$time_entry_data['time_entry'] = sanitize_text_field($time_entry);
					$time_entry_data['description'] = sanitize_textarea_field($data['time_entry_description'][$key]);
					$time_entry_data['time_entry_date'] = sanitize_text_field(date('Y-m-d',strtotime($data['time_entry_date'][$key])));  
					$time_entry_data['billed_by'] =get_current_user_id();
					$time_entry_data['hours'] = sanitize_text_field($data['time_entry_hours'][$key]);
					$time_entry_data['rate'] = sanitize_text_field($data['time_entry_rate'][$key]);
					$time_entry_data['subtotal'] = sanitize_text_field($data['time_entry_sub'][$key]);				
					$time_entry_data['time_entry_tax'] =$time_entry_tax_value;
					$time_entry_data['time_entry_discount'] = sanitize_text_field($data['time_entry_discount']);
					$time_entry_data['total_tax_amount'] = $tax1_total_amount;
					   	 			
					$result=$wpdb->insert( $table_invoice_time_entries, $time_entry_data);								
				}
			}
			// add expense		
			if(!empty($data['expense']))
			{			
				$expense_sub_total=0;
				$expense_discount=0;
				$expense_total_tax=0;
				
				foreach($data['expense'] as $key1=>$expense)
				{	
					$expense_sub=MJ_lawmgt_strip_tags_and_stripslashes(sanitize_text_field($data['expense_sub'][$key1]));
					$discount_expense=$expense_sub/100 * $data['expenses_entry_discount'];							
					$expense_discount+=$discount_expense;
					$after_discount_expense=$expense_sub-$discount_expense;
					$tax1_total_amount_expense='0';
					if(!empty($data['expenses_entry_tax']))
					{
						$tax2=$data['expenses_entry_tax'][$key1];
						
						if(!empty($tax2))
						{
							$total_tax_expense=0;
							foreach($tax2 as $tax22)
								{
									$taxvalue_expense=MJ_lawmgt_tax_value_by_id($tax22);
									$total_tax_expense+=$taxvalue_expense->tax_value;
								}
							if(!empty($total_tax))
							{	
								$tax1_total_amount_expense=$after_discount_expense / 100 * $total_tax_expense ;
							}
						}
						$expense_entry_tax_value=implode(",",$tax2);
					}
					else
					{
						$expense_entry_tax_value=null;
					}
					 
					$total_tax_expense=$tax1_total_amount_expense;					
				
					$expense_total_tax+=$total_tax_expense;
					$expense_sub_total+=$expense_sub;
								
					$expense_data['invoice_id'] = $lastid;
					$expense_data['user_id']=sanitize_text_field($data['contact_name']);		
					$expense_data['case_id']=sanitize_text_field($data['case_name']);	
					$expense_data['expense'] = sanitize_text_field($expense);
					$expense_data['description'] = sanitize_textarea_field($data['expense_description'][$key1]);
					$expense_data['expense_date'] = sanitize_text_field(date('Y-m-d',strtotime($data['expense_date'][$key1])));   
					$expense_data['billed_by'] =get_current_user_id();
					$expense_data['quantity'] = $data['expense_quantity'][$key1];
					$expense_data['price'] = $data['expense_price'][$key1];
					$expense_data['subtotal'] = $data['expense_sub'][$key1];					
					$expense_data['expenses_entry_tax'] =$expense_entry_tax_value;
				 
					$expense_data['expenses_entry_discount'] =$data['expenses_entry_discount'];
					$expense_data['total_tax_amount'] =$tax1_total_amount_expense;
						
					$result=$wpdb->insert( $table_invoice_expenses, $expense_data);	
				}
			}	
			
			// add Flat fee	
			if(!empty($data['flat_fee']))
			{			
				$flat_fee_sub_total=0;
				$flat_fee_discount=0;
				$flat_fee_total_tax=0;
				
				foreach($data['flat_fee'] as $key=>$flat_fee)
				{					
					$flat_fee_sub=MJ_lawmgt_strip_tags_and_stripslashes(sanitize_text_field($data['flat_fee_sub'][$key]));
					$discount=$flat_fee_sub/100 * $data['flat_entry_discount'];							
					$flat_fee_discount+=$discount;
					$after_discount_flat_fee=$flat_fee_sub-$discount;
					$tax1_total_amount='0';
					if(!empty($data['flat_entry_tax']))
					{
						$tax1=$data['flat_entry_tax'][$key];
						
						if(!empty($tax1))
						{
							$total_tax=0;
							foreach($tax1 as $tax11)
							{
								$taxvalue=MJ_lawmgt_tax_value_by_id($tax11);
								$total_tax+=$taxvalue->tax_value;
							}
							if(!empty($total_tax))
							{	
								$tax1_total_amount=$after_discount_flat_fee / 100 * $total_tax ;
							}
						}
						$flat_entry_tax_value=implode(",",$tax1);
					}
					else
					{
						$flat_entry_tax_value=null;
					}	
					$total_tax=$tax1_total_amount;						
					
					$flat_fee_total_tax+=$total_tax;
					$flat_fee_sub_total+=$flat_fee_sub;					
					
					$flat_fee_data['invoice_id'] = $lastid;	
					$flat_fee_data['user_id']=sanitize_text_field($data['contact_name']);		
					$flat_fee_data['case_id']=sanitize_text_field($data['case_name']);	
					$flat_fee_data['flat_fee'] = sanitize_text_field($flat_fee);
					$flat_fee_data['description'] = sanitize_textarea_field($data['flat_fee_description'][$key]);
					$flat_fee_data['flat_fee_date'] = sanitize_text_field(date('Y-m-d',strtotime($data['flat_fee_date'][$key]))); 
					$flat_fee_data['billed_by'] = get_current_user_id();
					$flat_fee_data['quantity'] = sanitize_text_field($data['flat_fee_quantity'][$key]);
					$flat_fee_data['price'] = sanitize_text_field($data['flat_fee_price'][$key]);
					$flat_fee_data['subtotal'] = sanitize_text_field($data['flat_fee_sub'][$key]);					
					$flat_fee_data['flat_entry_tax'] =$flat_entry_tax_value;
					 
					$flat_fee_data['flat_entry_discount'] =sanitize_text_field($data['flat_entry_discount']);
					$flat_fee_data['total_tax_amount'] =$tax1_total_amount;
										
					$result=$wpdb->insert( $table_invoice_flat_fee, $flat_fee_data);								
				}
			}
			//invoice Payments calculation using 
			$id['id']=$lastid;
			
			$subtotal_amount=$time_entry_sub_total+$expense_sub_total+$flat_fee_sub_total;
			$discount_amount=$time_entry_discount+$expense_discount+$flat_fee_discount;
			$tax_amount=$time_entry_total_tax+$expense_total_tax+$flat_fee_total_tax;
			$due_amount=$subtotal_amount-$discount_amount+$tax_amount;			
			$total_amount=$subtotal_amount-$discount_amount+$tax_amount;						
			
			$invoice_payment_data['total_amount'] = $total_amount;
			$invoice_payment_data['paid_amount'] = 0;
			$invoice_payment_data['due_amount'] = $due_amount;
			$invoice_payment_data['payment_status'] = "Not Paid";
			$result=$wpdb->update( $table_invoice, $invoice_payment_data,$id);	
			
			//send generate invoice mail to billing contact
			$login_link=home_url();
		    $system_name=get_option('lmgt_system_name');
			
			$to=array();
			$user_id=sanitize_text_field($data['contact_name']);	
			$user_info = get_userdata($user_id);
			$arr['{{Lawyer System Name}}']=$system_name;							
			$arr['{{User Name}}']=$user_info->display_name;			
			$to[]=$user_info->user_email;					
					
			$subject =get_option('lmgt_generate_invoice_email_subject');
			$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
			$message = get_option('lmgt_generate_invoice_email_template');	
			$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
			
			//MJ_lawmgt_send_invoice_generate_mail($to,$subject_replacement,$message_replacement,$lastid);  
			
			//audit Log
			$case_id=sanitize_text_field($invoicedata['case_id']);
			$case_name=MJ_lawmgt_get_case_name($case_id);
			$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';
			$invoice_number=$invoicedata['invoice_number'];
			$invoice_link='<a href="?page=invoice&tab=invoicedetails&action=view&invoice_id='.MJ_lawmgt_id_encrypt(esc_attr($lastid)).'">'.esc_html($invoice_number).'</a>';
			$added_invoice=esc_html__('Added New Invoice Number','lawyer_mgt');
			MJ_lawmgt_append_audit_log($added_invoice.' '.$invoice_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_log_for_downlaod($added_invoice.' '.$invoice_number,get_current_user_id(),'');
			MJ_lawmgt_append_audit_invoicelog($added_invoice.' '.$invoice_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_caselog($added_invoice.' '.$invoice_link,get_current_user_id(),$case_link);
			MJ_lawmgt_userwise_activity($added_invoice.' '.$invoice_link,get_current_user_id(),$case_link);
			
			MJ_lawmgt_append_audit_caselog_download($added_invoice.' '.$invoice_number, get_current_user_id());
			MJ_lawmgt_append_audit_invoicelog_download($added_invoice.' '.$invoice_number, get_current_user_id());

       		return $result;
		}	
	}
	 /*<--- GET INVOICE FUNCTION --->*/
	public function MJ_lawmgt_get_all_invoice()
	{
		global $wpdb;
		$table_invoice = $wpdb->prefix. 'lmgt_invoice';
	
		$result = $wpdb->get_results("SELECT * FROM $table_invoice ORDER BY id DESC");
		return $result;	
	}	
	 /*<--- GET INVOICE Created By FUNCTION --->*/
	public function MJ_lawmgt_get_all_invoice_created_by()
	{
		global $wpdb;
		$table_invoice = $wpdb->prefix. 'lmgt_invoice';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_invoice where created_by=$current_user_id ORDER BY id DESC");
		return $result;	
	}	
	/*<--- GET ALL INVOICE BY ATTORNY FUNCTION --->*/
	public function MJ_lawmgt_get_all_invoice_by_attorney()
	{
		global $wpdb;
		$table_case = $wpdb->prefix. 'lmgt_cases';
		$table_invoice = $wpdb->prefix. 'lmgt_invoice';
		
		$attorney_id = get_current_user_id();
		
		$casedata = $wpdb->get_results("SELECT * FROM $table_case where FIND_IN_SET($attorney_id,case_assgined_to)");
		$case_id=array();
		if(!empty($casedata))
		{		
			foreach($casedata as $data)
			{
				$case_id[]=$data->id;
			}	
		}		
		if(!empty($case_id))
		{
			$result = $wpdb->get_results("SELECT * FROM $table_invoice where case_id IN (".implode(',', $case_id).") OR created_by=$attorney_id ORDER BY id DESC");
		}
		else
		{
			$result ='';
		}
		return $result;	
	}
	/*<--- GET ALL INVOICE BY CLIENT FUNCTION --->*/
	public function MJ_lawmgt_get_all_invoice_by_client()
	{
		global $wpdb;		
		$table_invoice = $wpdb->prefix. 'lmgt_invoice';
		
		$current_user_id = get_current_user_id();
		
		$result = $wpdb->get_results("SELECT * FROM $table_invoice where user_id=$current_user_id OR created_by=$current_user_id ORDER BY id DESC");
		return $result;	
	}
	/*<--- GET ALL INVOICE BY CASE ID  FUNCTION --->*/
	public function MJ_lawmgt_get_all_invoice_by_caseid($case_id)
	{
		global $wpdb;
		$table_invoice = $wpdb->prefix. 'lmgt_invoice';
	
		$result = $wpdb->get_results("SELECT * FROM $table_invoice where case_id=$case_id ORDER BY id DESC");
		return $result;	
	}	
	/*<--- GET ALL INVOICE BY CASE ID AND Created BY FUNCTION --->*/
	public function MJ_lawmgt_get_all_invoice_by_caseid_created_by($case_id)
	{
		global $wpdb;
		$table_invoice = $wpdb->prefix. 'lmgt_invoice';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_invoice where case_id=$case_id AND created_by=$current_user_id ORDER BY id DESC");
		return $result;	
	}	
	/*<--- GET ALL INVOICE BY CASE ID  FUNCTION --->*/
	public function MJ_lawmgt_get_all_invoice_by_caseid_client($case_id,$current_user_id)
	{
		global $wpdb;
		$table_invoice = $wpdb->prefix. 'lmgt_invoice';
		
		$result = $wpdb->get_results("SELECT * FROM $table_invoice where case_id=$case_id AND (user_id=$current_user_id OR created_by=$current_user_id) ORDER BY id DESC");
		return $result;	
	}	
	public function MJ_lawmgt_get_all_case_name_from_case_id($case_id)
	{
		global $wpdb;
		$table_cases = $wpdb->prefix. 'lmgt_cases';
	
		$result = $wpdb->get_row("SELECT case_name FROM $table_cases where id=".$case_id);
		
		return $result;	
	}
	
	/*<---DELETE INVOICE  FUNCTION --->*/
	public function MJ_lawmgt_delete_invoice($id)
	{		
		global $wpdb;
		$table_invoice = $wpdb->prefix. 'lmgt_invoice';
		$table_invoice_time_entries = $wpdb->prefix. 'lmgt_invoice_time_entries';
		$table_invoice_expenses = $wpdb->prefix. 'lmgt_invoice_expenses';
		$table_invoice_flat_fee = $wpdb->prefix. 'lmgt_invoice_flat_fee';
		 
		$result = $wpdb->query("DELETE FROM $table_invoice where id= ".$id);
		$result = $wpdb->query("DELETE FROM $table_invoice_time_entries where invoice_id= ".$id);
		$result = $wpdb->query("DELETE FROM $table_invoice_expenses where invoice_id= ".$id);
		$result = $wpdb->query("DELETE FROM $table_invoice_flat_fee where invoice_id= ".$id);   
		
		 //audit Log
		$case_id=MJ_lawmgt_id_decrypt(sanitize_text_field($_REQUEST['case_id']));
		$case_name=MJ_lawmgt_get_case_name($case_id);
		$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';
		$invoice_number=MJ_lawmgt_get_invoice_number($id);
		
	    $invoice_link='<a href="?page=invoice&tab=invoicedetails&action=view&invoice_id='.MJ_lawmgt_id_encrypt(esc_attr($id)).'">'.esc_html($invoice_number).'</a>';
		$deleted_invoice=esc_html__('Deleted Invoice','lawyer_mgt');
			MJ_lawmgt_append_audit_log($deleted_invoice.' '.$invoice_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_log_for_downlaod($deleted_invoice.' '.$invoice_number,get_current_user_id(),'');
			MJ_lawmgt_append_audit_invoicelog($deleted_invoice.' '.$invoice_link,get_current_user_id(),$case_link);
			MJ_lawmgt_append_audit_caselog($deleted_invoice.' '.$invoice_link,get_current_user_id(),$case_link);
			MJ_lawmgt_userwise_activity($deleted_invoice.' '.$invoice_link,get_current_user_id(),$case_link);

           MJ_lawmgt_append_audit_caselog_download($deleted_invoice.' '.$invoice_number, get_current_user_id());
           MJ_lawmgt_append_audit_invoicelog_download($deleted_invoice.' '.$invoice_number, get_current_user_id());		   
		   
		return $result;
	}
	/*<--- GET SINGLE INVOICE  FUNCTION --->*/
	public function MJ_lawmgt_get_single_invoice($id)
	{
		global $wpdb;
		$table_invoice = $wpdb->prefix. 'lmgt_invoice';
		$result = $wpdb->get_row("SELECT * FROM $table_invoice where id= ".$id);
		return $result;
	}	
	
	/*<--- GET SINGLE INVOICE BY TIME ENTRY FUNCTION --->*/
	public function MJ_lawmgt_get_single_invoice_time_entry($id)
	{
		global $wpdb;
		$table_invoice_time_entries = $wpdb->prefix. 'lmgt_invoice_time_entries';
		$result = $wpdb->get_results("SELECT * FROM $table_invoice_time_entries where invoice_id= ".$id);
		return $result;
	}	
		/*<--- GET SINGLE INVOICE BY EXPENSE  FUNCTION --->*/
	public function MJ_lawmgt_get_single_invoice_expenses($id)
	{
		global $wpdb;
		$table_invoice_expenses = $wpdb->prefix. 'lmgt_invoice_expenses';
		$result = $wpdb->get_results("SELECT * FROM $table_invoice_expenses where invoice_id= ".$id);
		return $result;
	}
		/*<--- GET SINGLE  Payments invoice  FUNCTION --->*/
	public function MJ_lawmgt_get_single_payment_data($id)
	{
		global $wpdb;
		$table_invoice_payment_history = $wpdb->prefix .'lmgt_invoice_payment_history';
		$result = $wpdb->get_results("SELECT * FROM $table_invoice_payment_history where invoice_id= ".$id);
		return $result;
	}
	/*<--- GET SINGLE INVOICE BY FLATE FEE  FUNCTION --->*/	
	public function MJ_lawmgt_get_single_invoice_flat_fee($id)
	{
		global $wpdb;
		$table_invoice_flat_fee = $wpdb->prefix. 'lmgt_invoice_flat_fee';
		$result = $wpdb->get_results("SELECT * FROM $table_invoice_flat_fee where invoice_id= ".$id);
		return $result;
	}	
	
	/*<---ADD FEE PAYMENT FUNCTION  --->*/	
	public function MJ_lawmgt_add_feepayment($data)
	{
		//var_dump($data);die;
		$invoice_number=$this->MJ_lawmgt_get_single_invoice(sanitize_text_field($data['invoice_id']));
		 
		global $wpdb;
		$table_invoice = $wpdb->prefix. 'lmgt_invoice';		
		$table_invoice_payment_history = $wpdb->prefix .'lmgt_invoice_payment_history';
		
		$feedata['invoice_id']=sanitize_text_field($data['invoice_id']);
		$feedata['date']=date("Y-m-d"); 
		$feedata['amount']=sanitize_text_field($data['amount']);
		$feedata['payment_method']=sanitize_text_field($data['payment_method']);	
		
		$amount = $this->MJ_lawmgt_get_amount_by_id(sanitize_text_field($data['invoice_id']));
		$paid_amount=$amount->paid_amount;
		$total_amount=$amount->total_amount;
		
		$uddate_data['paid_amount'] = sanitize_text_field($paid_amount + $feedata['amount']);
		$uddate_data['due_amount'] = sanitize_text_field($total_amount - $uddate_data['paid_amount']);
		$uddate_data['total_amount'] = $total_amount;
		
		$uddate_data['id'] = $data['invoice_id'];
		
		$this->MJ_lawmgt_update_paid_fee_amount($uddate_data);
		
		$amount = $this->MJ_lawmgt_get_amount_by_id(sanitize_text_field($data['invoice_id']));
		$paid_amount=$amount->paid_amount;
		$total_amount=$amount->total_amount;
		$due_amount=$amount->due_amount;
		if($paid_amount == 0)
		{
			$status="Not Paid";
		}
		elseif($paid_amount < $total_amount)
		{
			$status="Partially Paid";
		}
		elseif($paid_amount >= $total_amount)
		{
			$status="Fully Paid";
		}
		
		$payment_status['payment_status']=$status;
		$invoice_id['id']=sanitize_text_field($data['invoice_id']);
		$result=$wpdb->update( $table_invoice, $payment_status ,$invoice_id);
		
		$result=$wpdb->insert( $table_invoice_payment_history,$feedata );	
		$system_name=get_option('lmgt_system_name');	
		
		//audit Log
		$case_id=sanitize_text_field($data['case_id']);
		$case_name=MJ_lawmgt_get_case_name($case_id);
		$case_link='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($case_id)).'">'.esc_html($case_name).'</a>';
		$invoice_number1=$invoice_number->invoice_number;
		$invoice_link='<a href="?page=invoice&tab=invoicedetails&action=view&invoice_id='.MJ_lawmgt_id_encrypt(esc_attr(sanitize_text_field($data['invoice_id']))).'">'.esc_html($invoice_number1).'</a>';
		$added_invoice=esc_html__('Added New Payment Invoice Number','lawyer_mgt');
		MJ_lawmgt_append_audit_log($added_invoice.' '.$invoice_link,get_current_user_id(),$case_link);
		MJ_lawmgt_append_audit_log_for_downlaod($added_invoice.' '.$invoice_number1,get_current_user_id(),'');
		MJ_lawmgt_append_audit_invoicelog($added_invoice.' '.$invoice_link,get_current_user_id(),$case_link);
		MJ_lawmgt_append_audit_caselog($added_invoice.' '.$invoice_link,get_current_user_id(),$case_link);
		MJ_lawmgt_userwise_activity($added_invoice.' '.$invoice_link,get_current_user_id(),$case_link);
		
		MJ_lawmgt_append_audit_caselog_download($added_invoice.' '.$invoice_number1, get_current_user_id());
		MJ_lawmgt_append_audit_invoicelog_download($deleted_invoice.' '.$invoice_number, get_current_user_id());		
	return $result;
	}
	/*<---GET AMOUNT BY ID FUNCTION  --->*/
	public function MJ_lawmgt_get_amount_by_id($invoice_id)
	{
		global $wpdb;
		$table_invoice = $wpdb->prefix. 'lmgt_invoice';
		
		$result = $wpdb->get_row("SELECT * FROM $table_invoice where id = $invoice_id");
		return $result;
	}
		/*<--UPDATE FEES PAYMENT FUNCTION  --->*/
	public function MJ_lawmgt_update_paid_fee_amount($data)
	{
		global $wpdb;
		$table_invoice = $wpdb->prefix. 'lmgt_invoice';
		
		$total_amount=$data['total_amount'];
		
		$feedata['paid_amount'] = sanitize_text_field($data['paid_amount']);
		$feedata['due_amount'] = sanitize_text_field($data['due_amount']);
		$invoice_id['id']= sanitize_text_field($data['id']);
		$result=$wpdb->update( $table_invoice, $feedata ,$invoice_id);
		return $result;
	}	
	//DELETE SELECTED INVOICE//
	public function MJ_lawmgt_delete_selected_invoice($all)
	{		
		global $wpdb;
		$table_invoice = $wpdb->prefix. 'lmgt_invoice';
		$result = $wpdb->query("DELETE FROM $table_invoice where id IN($all)");
		return $result;
	}
	// Add Tax
	public function MJ_lawmgt_add_tax($data)
	{
		global $wpdb;
		$table_taxes=$wpdb->prefix .'lmgt_taxes';
		$taxdata['tax_title']=MJ_lawmgt_strip_tags_and_stripslashes($data['tax_title']);
		$taxdata['tax_value']= sanitize_text_field($data['tax_value']);		
			
		 
		if($data['action']=='edit_tax')
		{	
			$taxdata['updated_by']=get_current_user_id();
			$taxdata['updated_date']=date("Y-m-d H:i:s");
			$taxid['tax_id']= sanitize_text_field($data['tax_id']);
			$result=$wpdb->update( $table_taxes, $taxdata ,$taxid);					
			
			return $result;
		}
		else
		{	
			$taxdata['created_date']=date("Y-m-d H:i:s");
			$taxdata['created_by']=get_current_user_id();			
			$result=$wpdb->insert( $table_taxes,$taxdata);		
			
			return $result;		
		}
	}
	//get single tax data
	public function MJ_lawmgt_get_single_tax_data($tax_id)
	{
		global $wpdb;
		$table_taxes=$wpdb->prefix .'lmgt_taxes';
		$result = $wpdb->get_row("SELECT * FROM $table_taxes where tax_id= ".$tax_id);
		return $result;
	}
	// get all tax data
	public function MJ_lawmgt_get_all_tax_data()
	{
		global $wpdb;
		$table_taxes=$wpdb->prefix .'lmgt_taxes';
		$result = $wpdb->get_results("SELECT * FROM $table_taxes where deleted_status=0");
		return $result;
	}
	// get all tax data Created by
	public function MJ_lawmgt_get_all_tax_data_created_by()
	{
		global $wpdb;
		$table_taxes=$wpdb->prefix .'lmgt_taxes';
		$current_user_id = get_current_user_id();
		$result = $wpdb->get_results("SELECT * FROM $table_taxes where deleted_status=0 AND created_by=$current_user_id");
		return $result;
	}
	/*<---DELETE Tax  FUNCTION --->*/
	public function MJ_lawmgt_delete_tax($id)
	{
		
		global $wpdb;
		$table_taxes = $wpdb->prefix. 'lmgt_taxes';
	 
		$tax_data['deleted_status']=1;
		$whereid['tax_id']=$id;
		$delete_tax=$wpdb->update($table_taxes, $tax_data, $whereid);
		return $delete_tax;
	}
	// get all invoice data form Start date and end date
	public function MJ_lawmgt_get_all_invoice_data_startdate_enddate($start_date,$end_date)
	{
		global $wpdb;
		$table_invoice=$wpdb->prefix .'lmgt_invoice';
		$result = $wpdb->get_results("SELECT * FROM $table_invoice where generated_date >= '$start_date' AND generated_date <= '$end_date'");
		return $result;
	}
	// get all invoice data form Start date and end date and casename
	public function MJ_lawmgt_get_all_invoice_data_startdate_enddate_and_casename($start_date,$end_date,$case_id)
	{
		global $wpdb;
		$table_invoice=$wpdb->prefix .'lmgt_invoice';
		$result = $wpdb->get_results("SELECT * FROM $table_invoice where generated_date >= '$start_date' AND generated_date <= '$end_date' AND case_id=".$case_id);
		return $result;
	}
	// get all invoice data form Start date and end date and Clientname
	public function MJ_lawmgt_get_all_invoice_data_startdate_enddate_and_clientname($start_date,$end_date,$client_id)
	{
		global $wpdb;
		$table_invoice=$wpdb->prefix .'lmgt_invoice';
		$result = $wpdb->get_results("SELECT * FROM $table_invoice where generated_date >= '$start_date' AND generated_date <= '$end_date' AND user_id=".$client_id);
		return $result;
	}
	// get all invoice data form Start date and end date and Clientname
	public function MJ_lawmgt_get_all_invoice_data_startdate_enddate_case_client($or)
	{
		 
		$extraquery='';
		global $wpdb;
		$table_invoice=$wpdb->prefix .'lmgt_invoice';
		 
		$increment = 0;
		foreach($or as $key=>$value)
		{
			if($increment == 0)
			{
				$extraquery .= ' '. $key .' '. "'$value'";
			}
			else
			{
				$extraquery .= ' '.'AND' .' '. $key .' '. "'$value'";
			}
		$increment++;
		}
		 
		$result = $wpdb->get_results("SELECT * FROM $table_invoice where".$extraquery);
		return $result;
	}
	// get all Expenses data form Start date and end date and Clientname
	public function MJ_lawmgt_get_all_expenses_data_startdate_enddate_case_client($or)
	{
		 
		$extraquery='';
		global $wpdb;
		$table_invoice_expenses = $wpdb->prefix. 'lmgt_invoice_expenses';
		 
		$increment = 0;
		foreach($or as $key=>$value)
		{ 
			if($increment == 0)
			{
				$extraquery .= ' '. $key .' '. "'$value'";
			}
			else
			{
				$extraquery .= ' '.'AND' .' '. $key .' '. "'$value'";
			}
		$increment++;
		}
		 
		$result = $wpdb->get_results("SELECT * FROM $table_invoice_expenses where".$extraquery);
		 
		return $result;
	}
	// get all time entry data form Start date and end date and Clientname
	public function MJ_lawmgt_get_all_timeentry_data_startdate_enddate_case_client($or)
	{
		 
		$extraquery='';
		global $wpdb;
		$table_invoice_time_entries = $wpdb->prefix. 'lmgt_invoice_time_entries';
		 
		$increment = 0;
		foreach($or as $key=>$value)
		{
			if($increment == 0)
			{
				$extraquery .= ' '. $key .' '. "'$value'";
			}
			else
			{
				$extraquery .= ' '.'AND' .' '. $key .' '. "'$value'";
			}
		$increment++;
		}
		 
		$result = $wpdb->get_results("SELECT * FROM $table_invoice_time_entries where".$extraquery);
		 
		return $result;
	}
	
} /*<---END  MJ_lawmgt_invoice  CLASS--->*/
?>