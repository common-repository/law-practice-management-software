<?php 	
$obj_invoice=new MJ_lawmgt_invoice;
?>
<script type="text/javascript">
    var $ = jQuery.noConflict();
	jQuery(document).ready(function($)
	{
		"use strict";
		function MJ_lawmgt_initMultiSelect()
		{
			$('.tax_dropdawn').multiselect({
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>'
			},
			buttonWidth: '50%',
			numberDisplayed: 1,	
			nonSelectedText :'<?php esc_html_e('Select Tax','lawyer_mgt');?>',
			selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
			enableFiltering: true,
			filterBehavior: 'text',
			enableCaseInsensitiveFiltering: true,
			includeSelectAllOption: true ,
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>',
				filter: '<li class="multiselect-item filter"><div class="input-group m-0 mb-1"><input class="form-control multiselect-search" type="text"></div></li>',
				filterClearBtn: '<div class="input-group-append"><button class="btn btn btn-outline-secondary multiselect-clear-filter" type="button"><i class="fa fa-times"></i></button></div>'
			}
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
		
		$('.tax_dropdawn').multiselect({
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>'
			},
			buttonWidth: '50%',
			numberDisplayed: 1,	
			nonSelectedText :'<?php esc_html_e('Select Tax','lawyer_mgt');?>',
			selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
			enableFiltering: true,
			filterBehavior: 'text',
			enableCaseInsensitiveFiltering: true,
			includeSelectAllOption: true ,
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>',
				filter: '<li class="multiselect-item filter"><div class="input-group m-0 mb-1"><input class="form-control multiselect-search" type="text"></div></li>',
				filterClearBtn: '<div class="input-group-append"><button class="btn btn btn-outline-secondary multiselect-clear-filter" type="button"><i class="fa fa-times"></i></button></div>'
			}
			});
		
		$('.date1').datepicker({
			startDate : start,
			endDate   : end,
			autoclose: true
		}).on('changeDate', function(){
			$('.date').datepicker('setEndDate', new Date($(this).val()));
		});	
		$('.demo').on("click",function()
		{
			MJ_lawmgt_initMultiSelect();
		});  
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
           $('.tax_dropdawn').multiselect({
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>'
			},
			buttonWidth: '50%',
			numberDisplayed: 1,	
			nonSelectedText :'<?php esc_html_e('Select Tax','lawyer_mgt');?>',
			selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
			enableFiltering: true,
			filterBehavior: 'text',
			enableCaseInsensitiveFiltering: true,
			includeSelectAllOption: true ,
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>',
				filter: '<li class="multiselect-item filter"><div class="input-group m-0 mb-1"><input class="form-control multiselect-search" type="text"></div></li>',
				filterClearBtn: '<div class="input-group-append"><button class="btn btn btn-outline-secondary multiselect-clear-filter" type="button"><i class="fa fa-times"></i></button></div>'
			}
			});		
		<?php
			$user = wp_get_current_user();
			$userid=$user->ID;
			$user_name=get_userdata($userid);	
		?>
		$(".time_entry_div").append('<div class="main_time_entry_div"><div class="form-group"><label class="col-sm-2 control-label" for="medicine_name"><?php esc_html_e('Time Entries','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-sm-3 margin_bottom_5px"><input class="form-control text-input validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]" type="text" value="" name="time_entry[]" placeholder="<?php esc_html_e('Enter time entry','lawyer_mgt');?>"></div> <div class="col-sm-3 margin_bottom_5px has-feedback">	 <input  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="customfielddate date date_css form-control has-feedback-left validate[required]" type="text"  name="time_entry_date[]"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>" value="" readonly><span class="fa fa-calendar form-control-feedback left feedback_responsive" aria-hidden="true"></span> </div> <div class="col-sm-3 margin_bottom_5px"> <textarea class="validate[custom[address_description_validation],maxSize[150]]" rows="1" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" name="time_entry_description[]"></textarea> </div></div> <div class="form-group"><div class="col-sm-3 margin_bottom_5px offset-sm-2"> <input class="form-control text-input validate[required] added_subtotal time_entry_hours'+value+'" row="'+value+'" type="number" onKeyPress="if(this.value.length==2) return false;" value="" min="1" name="time_entry_hours[]" placeholder="<?php esc_html_e('Enter hours','lawyer_mgt');?>"></div><div class="col-sm-3 margin_bottom_5px"> <input  class="form-control text-input validate[required,min[0],maxSize[8]] added_subtotal time_entry_rate'+value+'" row="'+value+'" type="number" step="0.01" value="" name="time_entry_rate[]" placeholder="<?php esc_html_e('Enter rate','lawyer_mgt');?>"> </div><div class="col-sm-3 margin_bottom_5px"> <input   class="form-control text-input time_entry_sub'+value+'" row="'+value+'" placeholder="<?php esc_html_e('Time Entry Subtotal','lawyer_mgt');?>" type="text" value="" name="time_entry_sub[]" readonly="readonly"> </div></div><div class="form-group"><div class="col-sm-3 margin_bottom_5px offset-sm-2"> <input   class="form-control validate[min[0],max[100]] text-input" type="number" step="0.01" value="" name="time_entry_discount" placeholder="<?php esc_html_e('Enter Discount in (%)','lawyer_mgt');?>" ></div> <div class="col-sm-3 margin_bottom_5px"><select  class="form-control tax_dropdawn"  multiple="multiple" name="time_entry_tax['+value+'][]" ><?php $obj_invoice= new MJ_lawmgt_invoice(); $hmgt_taxs=$obj_invoice->MJ_lawmgt_get_all_tax_data(); if(!empty($hmgt_taxs)){	foreach($hmgt_taxs as $entry){ ?> <option value="<?php echo esc_attr($entry->tax_id); ?>"><?php echo esc_html($entry->tax_title);?>-<?php echo esc_html($entry->tax_value);?></option> <?php } }	?></select></div><div class="col-sm-3 margin_bottom_5px"><input type="button"  value="<?php esc_attr_e('Delete','lawyer_mgt');?>"  class="remove_time_entry btn btn-danger"></div></div><hr>');
		$('.time_increment').val(value); 
		
	}  	
	//var value_expence = -1; 
	function MJ_lawmgt_add_expense()
	{
		"use strict";
		var value_expence = $('.expenses_increment').val(); 
		value_expence++;
        $('.tax_dropdawn').multiselect({
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>'
			},
			buttonWidth: '50%',
			numberDisplayed: 1,	
			nonSelectedText :'<?php esc_html_e('Select Tax','lawyer_mgt');?>',
			selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
			enableFiltering: true,
			filterBehavior: 'text',
			enableCaseInsensitiveFiltering: true,
			includeSelectAllOption: true ,
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>',
				filter: '<li class="multiselect-item filter"><div class="input-group m-0 mb-1"><input class="form-control multiselect-search" type="text"></div></li>',
				filterClearBtn: '<div class="input-group-append"><button class="btn btn btn-outline-secondary multiselect-clear-filter" type="button"><i class="fa fa-times"></i></button></div>'
			}
			});		
		<?php 
			$user = wp_get_current_user();
			$userid=$user->ID;
			$user_name=get_userdata($userid);	
		?>
		
		$(".expenses_entry_div").append('<div class="main_expenses_entry_div"><div class="form-group"><label class="col-sm-2 control-label" for="medicine_name"><?php esc_html_e('Expenses Entries','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-sm-3 margin_bottom_5px"><input class="form-control text-input validate[required] onlyletter_number_space_validation" maxlength="50" type="text" value="" name="expense[]" placeholder="<?php esc_html_e('Enter expense','lawyer_mgt');?>"></div> <div class="col-sm-3 margin_bottom_5px has-feedback">	 <input  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="customfielddate date date_css form-control has-feedback-left validate[required]" type="text"  name="expense_date[]"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>" value="" readonly><span class="fa fa-calendar form-control-feedback left feedback_responsive" aria-hidden="true"></span> </div> <div class="col-sm-3 margin_bottom_5px"> <textarea class="validate[custom[address_description_validation],maxSize[150]]" rows="1"  maxlength="150" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" name="expense_description[]"></textarea> </div></div> <div class="form-group"><div class="col-sm-3 margin_bottom_5px offset-sm-2"> <input  class="form-control text-input validate[required] added_subtotal_expenses expense_quantity'+value_expence+'" row="'+value_expence+'" type="number" onKeyPress="if(this.value.length==2) return false;" value="" min="1" name="expense_quantity[]"  placeholder="<?php esc_html_e('Enter quantity','lawyer_mgt');?>"></div><div class="col-sm-3 margin_bottom_5px"> <input  class="form-control text-input added_subtotal_expenses validate[required,min[0],maxSize[8]] expense_price'+value_expence+'" row="'+value_expence+'"  type="number" value="" name="expense_price[]"  placeholder="<?php esc_html_e('Enter Price','lawyer_mgt');?>"> </div><div class="col-sm-3 margin_bottom_5px"> <input class="form-control text-input  expense_sub'+value_expence+'" row="'+value_expence+'" type="text" value="" placeholder="<?php esc_html_e('Expenses Entry Subtotal','lawyer_mgt');?>" name="expense_sub[]" readonly="readonly"> </div></div><div class="form-group"><div class="col-sm-3 margin_bottom_5px offset-sm-2"> <input class="form-control validate[min[0],max[100]] text-input" type="number" step="0.01" value="" name="expenses_entry_discount" placeholder="<?php esc_html_e('Enter Discount in (%)','lawyer_mgt');?>" ></div> <div class="col-sm-3 margin_bottom_5px"><select  class="form-control tax_charge tax_dropdawn"  multiple="multiple" name="expenses_entry_tax['+value_expence+'][]"><?php $obj_invoice= new MJ_lawmgt_invoice(); $hmgt_taxs=$obj_invoice->MJ_lawmgt_get_all_tax_data(); if(!empty($hmgt_taxs)){ foreach($hmgt_taxs as $entry){ ?> <option value="<?php echo esc_attr($entry->tax_id); ?>"><?php echo esc_html($entry->tax_title);?>-<?php echo esc_html($entry->tax_value);?></option> <?php } }	?></select></div><div class="col-sm-3 margin_bottom_5px"><input type="button" value="<?php esc_attr_e('Delete','lawyer_mgt');?>" class="remove_expenses_entry btn btn-danger"></div></div><hr>');
		
		$('.expenses_increment').val(value); 
	} 
	 
	function MJ_lawmgt_add_flat_fee()
	{	
	    "use strict";
		var value_flat = $('.flat_increment').val(); 
	
		value_flat++;
	
         $('.tax_dropdawn').multiselect({
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>'
			},
			buttonWidth: '50%',
			nonSelectedText :'<?php esc_html_e('Select Tax','lawyer_mgt');?>',
			selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
			enableFiltering: true,
			filterBehavior: 'text',
			numberDisplayed: 1,	
			enableCaseInsensitiveFiltering: true,
			includeSelectAllOption: true ,
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>',
				filter: '<li class="multiselect-item filter"><div class="input-group m-0 mb-1"><input class="form-control multiselect-search" type="text"></div></li>',
				filterClearBtn: '<div class="input-group-append"><button class="btn btn btn-outline-secondary multiselect-clear-filter" type="button"><i class="fa fa-times"></i></button></div>'
			}
			});		
		
	
		<?php
			$user = wp_get_current_user();
			$userid=$user->ID;
			$user_name=get_userdata($userid);	
		?>
		$(".flat_entry_div").append('<div class="main_flat_entry_div"><div class="form-group"><label class="col-sm-2 control-label" for="medicine_name"><?php esc_html_e('Flat Entries','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-sm-3 margin_bottom_5px"><input class="form-control text-input validate[required] onlyletter_number_space_validation" maxlength="50" type="text" value="" name="flat_fee[]" placeholder="<?php esc_html_e('Enter Flat fee','lawyer_mgt');?>"></div> <div class="col-sm-3 margin_bottom_5px has-feedback"><input  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="customfielddate date_css date form-control has-feedback-left validate[required]" type="text"  name="flat_fee_date[]"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>" value="" readonly><span class="fa fa-calendar form-control-feedback left feedback_responsive" aria-hidden="true"></span> </div> <div class="col-sm-3 margin_bottom_5px"> <textarea  class="validate[custom[address_description_validation],maxSize[150]]" rows="1" maxlength="150" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" name="flat_fee_description[]"></textarea> </div></div> <div class="form-group"><div class="col-sm-3 margin_bottom_5px offset-sm-2"> <input  class="form-control text-input validate[required] flat_fee_quantity'+value_flat+' added_subtotal_flat_fee" type="number" onKeyPress="if(this.value.length==2) return false;" value="" min="1" name="flat_fee_quantity[]" row="'+value_flat+'" placeholder="<?php esc_html_e('Enter quantity','lawyer_mgt');?>"></div><div class="col-sm-3 margin_bottom_5px"><input class="form-control text-input validate[required,min[0],maxSize[8]] flat_fee_price'+value_flat+' added_subtotal_flat_fee" type="number" value="" name="flat_fee_price[]" row="'+value_flat+'" placeholder="<?php esc_html_e('Enter Price','lawyer_mgt');?>"> </div><div class="col-sm-3 margin_bottom_5px"> <input  class="form-control text-input  flat_fee_sub'+value_flat+'" row="'+value_flat+'" type="text" value="" name="flat_fee_sub[]" placeholder="<?php esc_html_e('Flat Entry Subtotal','lawyer_mgt');?>" readonly="readonly"> </div></div><div class="form-group"><div class="col-sm-3 margin_bottom_5px offset-sm-2"> <input  class="form-control validate[min[0],max[100]] text-input" type="number" step="0.01" value="" name="flat_entry_discount" placeholder="<?php esc_html_e('Enter Discount in (%)','lawyer_mgt');?>" ></div> <div class="col-sm-3 margin_bottom_5px"><select  class="form-control tax_charge tax_dropdawn"  multiple="multiple" name="flat_entry_tax['+value_flat+'][]"><?php $obj_invoice= new MJ_lawmgt_invoice(); $hmgt_taxs=$obj_invoice->MJ_lawmgt_get_all_tax_data(); if(!empty($hmgt_taxs)){	foreach($hmgt_taxs as $entry){ ?> <option value="<?php echo esc_attr($entry->tax_id); ?>"><?php echo esc_html($entry->tax_title);?>-<?php echo esc_html($entry->tax_value);?></option> <?php } }	?></select></div><div class="col-sm-3 margin_bottom_5px"><input type="button" value="<?php esc_attr_e('Delete','lawyer_mgt');?>" class="remove_flat_entry btn btn-danger"></div></div><hr>');
		
		$('.flat_increment').val(value); 
	}	
</script>
<?php 	
if($active_tab == 'add_invoice')
{
	$invoice_id=0;
	$edit=0;
	if(isset($_REQUEST['invoice_id']))
		$invoice_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['invoice_id']));
	if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
	{			
		$edit=1;
		$invoice_info=$obj_invoice->MJ_lawmgt_get_single_invoice($invoice_id);	
	}
		?> 		
    <div class="panel-body"><!-- PANEL BODY DIV  -->
        <form name="invoice_form" action="" method="post" class="form-horizontal" id="invoice_form" enctype='multipart/form-data'>	
			 <?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">	
			<input type="hidden" name="invoice_id1" value="<?php echo esc_attr($invoice_id);?>"  />
			<input type="hidden" name="paid_amount" value="<?php if($edit){ echo esc_attr($invoice_info->paid_amount); }?>"  />		
			<div class="header">

				
				<h3 class="first_hed"><?php esc_html_e('Linked To','lawyer_mgt');?></h3>
				<hr>
			</div>
	<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="contact_name"><?php esc_html_e('Case Name','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<?php
					$obj_case=new MJ_lawmgt_case;				
					$result = $obj_case->MJ_lawmgt_get_open_all_case();
				?>
				<select class="form-control validate[required]" name="case_name" id="invoice_case_id">	
					<option value=""><?php esc_html_e('Select Case name','lawyer_mgt');?></option>				
						<?php 
						if($edit){ $data=$invoice_info->case_id;}else{ $data=''; }
						foreach($result as $result1)
						{
							echo '<option value="'.esc_attr($result1->id).'" '.selected($data,$result1->id).'>'.esc_html($result1->case_name).'</option>';
						} ?>
				</select>
				</div>
					<?php wp_nonce_field( 'save_invoice_nonce' ); ?>
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
					<input id="invoice_number" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo esc_attr($invoice_info->invoice_number);} else echo MJ_lawmgt_generate_invoce_number();?>"  name="invoice_number" readonly>				
				</div>		
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="date"><?php esc_html_e('Date','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="date"  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date form-control has-feedback-left " type="text"  name="invoice_generated_date"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_html(MJ_lawmgt_getdate_in_input_box($invoice_info->generated_date));}elseif(isset($_POST['invoice_generated_date'])){ echo MJ_lawmgt_getdate_in_input_box($_POST['invoice_generated_date']); } ?>" readonly>
					<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
					<span id="inputSuccess2Status2" class="sr-only">(success)</span>	
				</div>	
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="due_date"><?php esc_html_e('Due Date','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="due_date"  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date1 form-control has-feedback-left" type="text"  name="due_date"  placeholder="<?php esc_html_e('Select Due Date','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_html(MJ_lawmgt_getdate_in_input_box($invoice_info->due_date));}elseif(isset($_POST['due_date'])){ echo MJ_lawmgt_getdate_in_input_box($_POST['due_date']); } ?>" readonly>
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
										<input class="form-control text-input validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]" type="text" value="<?php if($edit){ echo esc_attr($data->time_entry);} elseif(isset($_POST['time_entry'])){ echo esc_attr($_POST['time_entry']); } ?>" name="time_entry[]" placeholder="<?php esc_html_e('Enter time entry','lawyer_mgt');?>">
									</div>
									<div class="col-sm-3 margin_bottom_5px has-feedback">
										<input  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date date_css form-control has-feedback-left" type="text"  name="time_entry_date[]"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>"   value="<?php if($edit){ echo esc_html(MJ_lawmgt_getdate_in_input_box($data->time_entry_date));}elseif(isset($_POST['time_entry_date'])){ echo MJ_lawmgt_getdate_in_input_box($_POST['time_entry_date']); } ?>" readonly>
										<span class="fa fa-calendar form-control-feedback left feedback_responsive" aria-hidden="true"></span>
										<span id="inputSuccess2Status2" class="sr-only">(success)</span>
									</div>	
									<div class="col-sm-3 margin_bottom_5px">
										<textarea rows="1" class="validate[custom[address_description_validation],maxSize[150]]" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>"   name="time_entry_description[]"><?php if($edit){ echo esc_textarea($data->description);}elseif(isset($_POST['time_entry_description'])){ echo esc_textarea($_POST['time_entry_description']); } ?></textarea>
									</div>
									
								</div>
								<div class="form-group">
									<div class="col-sm-3 offset-sm-2 margin_bottom_5px">
										<input  class="form-control height_34_px_css validate[required] time_entry_hours<?php echo $value; ?> added_subtotal" onKeyPress="if(this.value.length==2) return false;" type="number" min="1" value="<?php if($edit){ echo esc_attr($data->hours);}elseif(isset($_POST['time_entry_hours'])){ echo esc_attr($_POST['time_entry_hours']); } ?>" name="time_entry_hours[]" row="<?php echo $value;?>" placeholder="<?php esc_html_e('Enter hours','lawyer_mgt');?>">
									</div>
									<div class="col-sm-3 margin_bottom_5px">
										<input class="form-control text-input validate[required,min[0],maxSize[8]] time_entry_rate<?php echo $value; ?> added_subtotal" type="number" value="<?php if($edit){ echo esc_attr($data->rate);}elseif(isset($_POST['time_entry_rate'])){ echo esc_attr($_POST['time_entry_rate']); }?>" name="time_entry_rate[]" row="<?php echo $value;?>" placeholder="<?php esc_html_e('Enter rate','lawyer_mgt');?>">
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
										<input type="button" value="<?php esc_attr_e('Delete','lawyer_mgt');?>" class="remove_time_entry btn btn-danger height_39_px_css">
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
				<input type="button" value="<?php esc_attr_e('Add More Time Entries','lawyer_mgt') ?>"   onclick="MJ_lawmgt_add_time_entry()" class=" btn btn-success demo">
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
										<input   class="form-control invoice_td_height text-input validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]"  type="text" value="<?php if($edit){ echo esc_attr($data->expense);}elseif(isset($_POST['expense'])){ echo esc_attr($_POST['expense']); } ?>" name="expense[]" placeholder="<?php esc_html_e('Enter expense','lawyer_mgt');?>">
									</div>
									<div class="col-sm-3 margin_bottom_5px has-feedback">
									
										<input data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date date_css form-control has-feedback-left" type="text"  name="expense_date[]"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>" value="<?php if($edit){ echo MJ_lawmgt_getdate_in_input_box($data->expense_date);}elseif(isset($_POST['expense_date'])){ echo MJ_lawmgt_getdate_in_input_box($_POST['expense_date']); } ?>" readonly>
										
										<span class="fa fa-calendar form-control-feedback left feedback_responsive" aria-hidden="true"></span>
										<span id="inputSuccess2Status2" class="sr-only">(success)</span>
									</div>	
									<div class="col-sm-3 margin_bottom_5px">
										<textarea  rows="1" class=" validate[custom[address_description_validation],maxSize[150]]"  placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>"  name="expense_description[]"><?php if($edit){ echo esc_textarea($data->description);}elseif(isset($_POST['expense_description'])){ echo esc_textarea($_POST['expense_description']); } ?></textarea>
									</div>
									
								</div>
								<div class="form-group">
									<div class="col-sm-3 offset-sm-2 margin_bottom_5px">
										<input class="form-control invoice_td_height validate[required] expense_quantity<?php echo esc_attr($value);?> added_subtotal_expenses" onKeyPress="if(this.value.length==2) return false;" min="1" type="number" value="<?php if($edit){ echo esc_attr($data->quantity);}elseif(isset($_POST['expense_quantity'])){ echo esc_attr($_POST['expense_quantity']); } ?>" name="expense_quantity[]" row="<?php echo $value;?>" placeholder="<?php esc_html_e('Enter quantity','lawyer_mgt');?>">
									</div>
									<div class="col-sm-3 margin_bottom_5px">
										<input class="form-control invoice_td_height validate[required] expense_price<?php echo esc_attr($value);?> added_subtotal_expenses" onKeyPress="if(this.value.length==8) return false;" min="0" type="number"  step="0.01" value="<?php if($edit){ echo esc_attr($data->price);}elseif(isset($_POST['expense_price'])){ echo esc_attr($_POST['expense_price']); } ?>" name="expense_price[]" row="<?php echo $value;?>" placeholder="<?php esc_html_e('Enter Price','lawyer_mgt');?>">
									</div>
									<div class="col-sm-3 margin_bottom_5px">
										<input class="form-control invoice_td_height expense_sub<?php echo esc_attr($value);?>" row="<?php echo $value;?>" type="text" value="<?php if($edit){ echo esc_attr($data->subtotal);}elseif(isset($_POST['expense_sub'])){ echo esc_attr($_POST['expense_sub']); }?>" name="expense_sub[]" readonly="readonly">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-3 offset-sm-2 margin_bottom_5px">
										<input   class=" form-control  validate[min[0],max[100]] text-input height_34_px_css" type="number" step="0.01" value="<?php if($edit){ echo esc_attr($data->expenses_entry_discount);}elseif(isset($_POST['expenses_entry_discount'])){ echo esc_attr($_POST['expenses_entry_discount']); } ?>" name="expenses_entry_discount" placeholder="<?php esc_html_e('Enter Discount in (%)','lawyer_mgt');?>" >
									</div>
									<div class="col-sm-3 margin_bottom_5px">
										<select  class="form-control tax_charge tax_dropdawn" multiple="multiple" name="expenses_entry_tax[<?php echo $value; ?>][]" >					 
											<?php
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
										<input type="button" value="<?php esc_attr_e('Delete','lawyer_mgt');?>" class="remove_expenses_entry btn btn-danger invoice_button">
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
										<input  class="form-control text-input validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] invoice_td_height"  type="text" value="<?php if($edit){ echo esc_attr($data->flat_fee);}elseif(isset($_POST['flat_fee'])) { echo esc_attr($_POST['flat_fee']); }?>" name="flat_fee[]" placeholder="<?php esc_html_e('Enter Flat fee','lawyer_mgt');?>">
									</div>
									<div class="col-sm-3 margin_bottom_5px has-feedback">
									
										<input  data-date-format=<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date date_css form-control has-feedback-left" type="text"  name="flat_fee_date[]"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($data->flat_fee_date));}elseif(isset($_POST['flat_fee_date'])){ echo MJ_lawmgt_getdate_in_input_box($_POST['flat_fee_date']); } ?>" readonly>
										<span class="fa fa-calendar form-control-feedback left feedback_responsive" aria-hidden="true"></span>
										<span id="inputSuccess2Status2" class="sr-only">(success)</span>
									</div>	
									<div class="col-sm-3 margin_bottom_5px">
										<textarea rows="1" class=" validate[custom[address_description_validation],maxSize[150]]" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" name="flat_fee_description[]"><?php if($edit){ echo esc_textarea($data->description);}elseif(isset($_POST['flat_fee_description'])){ echo esc_textarea($_POST['flat_fee_description']); } ?></textarea>
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
										<input  class="form-control validate[min[0],max[100]] text-input height_34_px_css" type="number" step="0.01" value="<?php if($edit){ echo esc_attr($data->flat_entry_discount);}elseif(isset($_POST['flat_entry_discount'])){ echo esc_attr($_POST['flat_entry_discount']); } ?>" name="flat_entry_discount" placeholder="<?php esc_html_e('Enter Discount in (%)','lawyer_mgt');?>" >
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
						wp_editor('','note',$setting);
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
						wp_editor('','terms',$setting);
					 }
					 ?>
				</div>
			</div>		
			<div class="offset-sm-2 col-sm-8 ">
				<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Add Invoice','lawyer_mgt');}?>" name="save_invoice" class="btn btn-success"/>
			</div>
		</form>
    </div>   <!-- END PANEL BODY DIV  -->     
<?php 
}
?>