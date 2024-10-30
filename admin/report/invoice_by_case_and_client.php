<?php  
$obj_invoice=new MJ_lawmgt_invoice;
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
							$case_data=$obj_case->MJ_lawmgt_get_all_case();
							
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
							$contactdata=get_users(array('role' => 'client',
												)
											);
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
										$conatc_name='<a href="?page=contacts&tab=viewcontact&action=view&contact_id='.MJ_lawmgt_id_encrypt(esc_attr($userdata->ID)).'">'.esc_html($userdata->display_name).'</a>';
										?>
										<tr> 
										
											<td><?php echo esc_html($retrieved_data->invoice_number);?></td>
											<td><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->generated_date));?></td>		
											<td><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->due_date));?></td>
											<td><?php echo $conatc_name;?></td>
											<?php 	$case_id=$retrieved_data->case_id;
													$case_name=$obj_invoice->MJ_lawmgt_get_all_case_name_from_case_id($case_id); ?>
											<td><a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>"><?php echo esc_html($case_name->case_name);?></a></td>
											<td><?php echo esc_html(number_format($retrieved_data->total_amount,2));?></td>
											<td><?php echo esc_html(number_format($retrieved_data->paid_amount,2));?></td>
											<td><?php echo esc_html(number_format($retrieved_data->due_amount,2));?></td>	
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
?>