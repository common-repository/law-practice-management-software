<?php 	
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'general_setting');
?>
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV -->
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' ));?></h3>
	  </div>
	</div>
<?php 	
if(isset($_POST['save_setting']))
{	
	$optionval=MJ_lawmgt_option();

	foreach($optionval as $key=>$val)
	{
		if(isset($_POST[$key]))
		{
			$result=update_option( $key, strip_tags($_POST[$key]));
		}
	}	
	if(isset($_REQUEST['lawyer_enable_sandbox']))
			update_option( 'lawyer_enable_sandbox', 'yes' );
		else 
			update_option( 'lawyer_enable_sandbox', 'no' );
	   if(isset($_REQUEST['lmgt_enable_staff_can_message']))
			update_option( 'lmgt_enable_staff_can_message', 'yes' );
		else 
			update_option( 'lmgt_enable_staff_can_message', 'no' );	
		
	   if(isset($_REQUEST['lmgt_enable_case_hearing_date_remainder']))
		{
			update_option( 'lmgt_enable_case_hearing_date_remainder', 'yes' );
		}
		else
		{	
			update_option( 'lmgt_enable_case_hearing_date_remainder', 'no' );
		}	
		
	if(isset($result))
	{?>  
		
		<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
             <?php esc_html_e('General Settings Updated Successfully','lawyer_mgt');?>
        </div>			
		<?php 
	}
}
if(isset($_POST['save_case_setting']))
{	 
	//$curr_created =implode(',',$_POST['case_columns']);
	$curr_created =implode(',',array_map( 'sanitize_text_field', wp_unslash( $_POST["case_columns"] ) ));
   // $curr_created1 =implode(',',$_POST['case_export']);
	$curr_created1 =implode(',',array_map( 'sanitize_text_field', wp_unslash( $_POST["case_export"] ) ));
	
	$result_case=update_option( 'lmgt_case_columns_option', $curr_created );
	$result_case=update_option( 'lmgt_case_export_option', $curr_created1 );
	 
	if(isset($result_case))
	{?>  
		
		<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
             <?php esc_html_e('Case Settings Updated Successfully','lawyer_mgt');?>
        </div>			
		<?php 
	}  
}
if(isset($_POST['save_contact_setting']))
{	 
	//$curr_created3 =implode(',',$_POST['contact_columns']);
	$curr_created3 =implode(',',array_map( 'sanitize_text_field', wp_unslash( $_POST["contact_columns"] ) ));
	$result_contact=update_option( 'lmgt_contact_columns_option', $curr_created3 );
	 
	 
	if(isset($result_contact))
	{ 
	?>  
		
		<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
             <?php esc_html_e('Client Settings Updated Successfully','lawyer_mgt');?>
        </div>			
		<?php 
	}  
}
if(isset($_POST['save_document_setting']))
{	 
	$curr_created4 =implode(',',array_map( 'sanitize_text_field', wp_unslash( $_POST["document_columns"] ) ));
	//$curr_created4 =implode(',',$_POST['document_columns']);
    //$curr_created5 =implode(',',$_POST['document_export']);
	$curr_created5 =implode(',',array_map( 'sanitize_text_field', wp_unslash( $_POST["document_export"] ) ));
	$result_case=update_option( 'lmgt_document_columns_option', $curr_created4 );
	$result_case=update_option( 'document_export_option', $curr_created5 );
	 
	if(isset($result_case))
	{?>  
		
		<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
             <?php esc_html_e('Document Settings Updated Successfully','lawyer_mgt');?>
        </div>			
		<?php 
	}  
}
if(isset($_POST['save_invoice_setting']))
{	 
	//$curr_created6 =implode(',',$_POST['invoice_columns']);
	$curr_created6 =implode(',',array_map( 'sanitize_text_field', wp_unslash( $_POST["invoice_columns"] ) ));
	$result_case=update_option( 'lmgt_invoice_columns_option', $curr_created6 );
	if(isset($result_case))
	{ ?>  
		
		<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
             <?php esc_html_e('Invoice Settings Updated Successfully','lawyer_mgt');?>
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
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'general_setting' ? 'active' : ''; ?> menucss">
									<a href="?page=lmgt_gnrl_setting&tab=general_setting">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('General Setting', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'case_setting' ? 'active' : ''; ?> menucss">
									<a href="?page=lmgt_gnrl_setting&tab=case_setting">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Case Setting', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'contact_setting' ? 'active' : ''; ?> menucss">
									<a href="?page=lmgt_gnrl_setting&tab=contact_setting">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Client Setting', 'lawyer_mgt'); ?>
									</a>
								</li>
								<?php
								if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
								{
									?>
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'document_setting' ? 'active' : ''; ?> menucss">
										<a href="?page=lmgt_gnrl_setting&tab=document_setting">
											<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Document Setting', 'lawyer_mgt'); ?>
										</a>
									</li>
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'invoice_setting' ? 'active' : ''; ?> menucss">
										<a href="?page=lmgt_gnrl_setting&tab=invoice_setting">
											<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Invoice Setting', 'lawyer_mgt'); ?>
										</a>
									</li>
								  <?php
								}
								?>
							</ul>
					    </h2>
						<?php
						if($active_tab == 'general_setting')
						{ ?>
							<script type="text/javascript">
							    var $ = jQuery.noConflict();
								jQuery(document).ready(function($)
								{
									"use strict";
									$('#setting_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
									$('.onlyletter_number_space_validation').keypress(function( e ) 
									{     
										var regex = new RegExp("^[0-9a-zA-Z \b]+$");
										var key = String.fromCharCode(!event.charCode ? event.which: event.charCode);
										if (!regex.test(key)) 
										{
											event.preventDefault();
											return false;
										} 
								   }); 
								   //not  allow space validation
									$('.space_not_allow').keypress(function( e ) 
									{
									   if(e.which === 32) 
										 return false;
									});
								} );
							</script>
 							<div class="tab-pane  tabs fade  active in margin_top_25_px_css" id="nav-open" role="tabpanel" aria-labelledby="nav-open-tab">
								<form name="setting_form" action="" method="post" class="form-horizontal" id="setting_form">
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="lmgt_system_name"><?php esc_html_e('LPMS Name','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<input id="lmgt_system_name" class="form-control has-feedback-left validate[required]" type="text" value="<?php echo esc_html(get_option( 'lmgt_system_name' ));?>"  name="lmgt_system_name">
											<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>	
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="lmgt_staring_year"><?php esc_html_e('Starting Year','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<input id="lmgt_staring_year" class="form-control validate[required,maxSize[4],minSize[4]] has-feedback-left" type="number" value="<?php echo esc_attr(get_option( 'lmgt_staring_year' ));?>"  name="lmgt_staring_year">
											<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="lmgt_address"><?php esc_html_e('LPMS Address','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<input id="lmgt_address" class="form-control has-feedback-left validate[required]" type="text" value="<?php echo esc_attr(get_option( 'lmgt_address' ));?>"  name="lmgt_address">
											<span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="lmgt_contact_number"><?php esc_html_e('Office Phone Number','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<input id="lmgt_contact_number" class="form-control has-feedback-left validate[required]" type="text" value="<?php echo esc_attr(get_option( 'lmgt_contact_number' ));?>"  name="lmgt_contact_number">
											<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>
									<div class="form-group" class="form-control" id="">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="lmgt_contry"><?php esc_html_e('Country','lawyer_mgt');?></label>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">			
										<?php 
										$xml=simplexml_load_file(plugins_url( 'countrylist.xml', __FILE__ )) or die("Error: Cannot create object");
										?>
										 <select name="lmgt_contry" class="form-control validate[required]" id="lmgt_contry">
												<option value=""><?php esc_html_e('Select Country','lmgt_contry');?></option>
												<?php
													foreach($xml as $country)
													{  
													?>
													 <option value="<?php echo esc_attr($country->name);?>" <?php selected(get_option( 'lmgt_contry' ), $country->name);  ?>><?php echo esc_html($country->name);?></option>
												<?php }?>
											</select> 
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="lmgt_email"><?php esc_html_e('Email','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
										<input id="lmgt_email" class="form-control has-feedback-left validate[required,custom[email]] text-input" type="text" value="<?php echo esc_html(get_option( 'lmgt_email' ));?>"  name="lmgt_email">
										<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>
								
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Date Format','lawyer_mgt');?>
										</label>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
										<?php $date_format_array = MJ_lawmgt_datepicker_dateformat();
										if(get_option( 'lmgt_datepicker_format' ))
										{
											$selected_format = get_option( 'lmgt_datepicker_format' );
										}
										else
											$selected_format = 'Y-m-d';
										?>
										<select id="lmgt_datepicker_format" class="form-control" name="lmgt_datepicker_format">
											<?php 
											foreach($date_format_array as $key=>$value)
											{
												if($value=='yy-mm-dd')
												{
													$display_date='yyyy-mm-dd';
												}
												elseif($value=='yy/mm/dd')
												{
													$display_date='yyyy/mm/dd';
												}	
												elseif($value=='dd-mm-yy')
												{
													$display_date='dd-mm-yyyy';
												}	
												elseif($value=='mm-dd-yy')
												{
													$display_date='mm-dd-yyyy';
												}	
												elseif($value=='mm/dd/yy')
												{
													$display_date='mm/dd/yyyy';
												}	
												
												echo '<option value="'.esc_attr($value).'" '.selected($selected_format,$value).'>'.esc_html($display_date).'</option>';
											}
											?>
										</select>
											
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="lmgt_fevicon"><?php esc_html_e('LPMS Icon','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
											<input type="text" id="lmgt_fevicon_url" name="lmgt_fevicon" class="form-control has-feedback-left validate[required]" value="<?php  echo get_option( 'lmgt_fevicon' ); ?>" readonly />
											<span class="fa fa-image form-control-feedback left" aria-hidden="true"></span>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<input id="lmgt_fevicon" type="button" class="button" value="<?php esc_html_e('Upload image', 'lawyer_mgt' ); ?>" />
										<span class="description"><?php esc_html_e('Upload image.', 'lawyer_mgt' ); ?></span>                    
										</div>
										<div class="clearfix"></div>	
										<div class="upload_img offset-sm-2 col-sm-8">				
										<div id="lmgt_fevicon_image_preview" class="upload_img">
										<img class="height_35px_width_35px_css" src="<?php  echo esc_url(get_option( 'lmgt_fevicon' )); ?>" />				
										</div>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="lmgt_system_logo"><?php esc_html_e('LPMS Logo','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
										<input type="text" id="lmgt_user_avatar_url" name="lmgt_system_logo" class="form-control has-feedback-left validate[required]" value="<?php  echo esc_url(get_option( 'lmgt_system_logo' )); ?>" readonly />
										<span class="fa fa-image form-control-feedback left" aria-hidden="true"></span>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
										<input id="upload_logo_image_button" type="button" class="button" value="<?php esc_html_e('Upload image', 'lawyer_mgt' ); ?>" />
										<span class="description"><?php esc_html_e('Upload image', 'lawyer_mgt' ); ?></span>
										</div>	
										<div class="clearfix"></div>	
										<div class="upload_img offset-lg-2 offset-md-2  offset-sm-2 col-lg-2 col-md-2 col-sm-2 col-xs-12">				
										<div id="upload_logo_image_preview" class="upload_img">
										<img  class="width_100_per" src="<?php  echo esc_url(get_option( 'lmgt_system_logo' )); ?>" /></div>
										</div>
									</div>		
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="lmgt_cover_image"><?php esc_html_e('LPMS Cover Image','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
										<input type="text" id="lmgt_cover_image" name="lmgt_cover_image" class="form-control has-feedback-left validate[required]" value="<?php  echo esc_url(get_option( 'lmgt_cover_image' )); ?>"readonly  />
										<span class="fa fa-image form-control-feedback left" aria-hidden="true"></span>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<input id="upload_cover_image_button" type="button" class="button" value="<?php esc_html_e('Upload Cover Image', 'lawyer_mgt' ); ?>" />
										<span class="description"><?php esc_html_e('Upload Cover Image', 'lawyer_mgt' ); ?></span>
										</div>
										<div class="clearfix"></div>	
										<div class="upload_img offset-lg-2 offset-md-2  offset-sm-2 col-lg-8 col-md-8 col-sm-8 col-xs-12">	
										<div id="upload_cover_image_preview" class="upload_img">
										<img  class="width_100_per" src="<?php  echo esc_url(get_option( 'lmgt_cover_image' )); ?>" />				
										</div>
										</div>
									</div>	
									<div class="header">	
										<h3 class="first_hed"><?php esc_html_e('Paypal Setting','lawyer_mgt');?></h3>
										<hr>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Enable Sandbox','lawyer_mgt');?></label>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<div class="checkbox">
												<label>
													<input type="checkbox" name="lawyer_enable_sandbox"  class="margin_top_top" value="1" <?php echo checked(get_option('lawyer_enable_sandbox'),'yes');?>/><?php esc_html_e('Enable','lawyer_mgt');?>
											  </label>
										  </div>
										</div>
									</div>		
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="lmgt_email"><?php esc_html_e('Paypal Email Id','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<input id="paypal_email" class="form-control has-feedback-left validate[required,custom[email]] text-input" type="text" value="<?php echo esc_attr(get_option( 'lmgt_paypal_email' ));?>"  name="lmgt_paypal_email">
											<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Select Currency','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">			   
										<select name="lmgt_currency_code" class="form-control validate[required] text-input">
									  <option value=""> <?php esc_html_e('Select Currency','lawyer_mgt');?></option>
									  <option value="AUD" <?php echo selected(get_option( 'lmgt_currency_code' ),'AUD');?>>
									  <?php esc_html_e('Australian Dollar','lawyer_mgt');?></option>
									  <option value="BRL" <?php echo selected(get_option( 'lmgt_currency_code' ),'BRL');?>>
									  <?php esc_html_e('Brazilian Real','lawyer_mgt');?> </option>
									  <option value="CAD" <?php echo selected(get_option( 'lmgt_currency_code' ),'CAD');?>>
									  <?php esc_html_e('Canadian Dollar','lawyer_mgt');?></option>
									  <option value="CZK" <?php echo selected(get_option( 'lmgt_currency_code' ),'CZK');?>>
									  <?php esc_html_e('Czech Koruna','lawyer_mgt');?></option>
									  <option value="DKK" <?php echo selected(get_option( 'lmgt_currency_code' ),'DKK');?>>
									  <?php esc_html_e('Danish Krone','lawyer_mgt');?></option>
									  <option value="EUR" <?php echo selected(get_option( 'lmgt_currency_code' ),'EUR');?>>
									  <?php esc_html_e('Euro','lawyer_mgt');?></option>
									  <option value="HKD" <?php echo selected(get_option( 'lmgt_currency_code' ),'HKD');?>>
									  <?php esc_html_e('Hong Kong Dollar','lawyer_mgt');?></option>
									  <option value="HUF" <?php echo selected(get_option( 'lmgt_currency_code' ),'HUF');?>>
									  <?php esc_html_e('Hungarian Forint','lawyer_mgt');?> </option>
									  <option value="INR" <?php echo selected(get_option( 'lmgt_currency_code' ),'INR');?>>
									  <?php esc_html_e('Indian Rupee','lawyer_mgt');?></option>
									  <option value="ILS" <?php echo selected(get_option( 'lmgt_currency_code' ),'ILS');?>>
									  <?php esc_html_e('Israeli New Sheqel','lawyer_mgt');?></option>
									  <option value="JPY" <?php echo selected(get_option( 'lmgt_currency_code' ),'JPY');?>>
									  <?php esc_html_e('Japanese Yen','lawyer_mgt');?></option>
									  <option value="MYR" <?php echo selected(get_option( 'lmgt_currency_code' ),'MYR');?>>
									  <?php esc_html_e('Malaysian Ringgit','lawyer_mgt');?></option>
									  <option value="MXN" <?php echo selected(get_option( 'lmgt_currency_code' ),'MXN');?>>
									  <?php esc_html_e('Mexican Peso','lawyer_mgt');?></option>
									  <option value="NOK" <?php echo selected(get_option( 'lmgt_currency_code' ),'NOK');?>>
									  <?php esc_html_e('Norwegian Krone','lawyer_mgt');?></option>
									  <option value="NZD" <?php echo selected(get_option( 'lmgt_currency_code' ),'NZD');?>>
									  <?php esc_html_e('New Zealand Dollar','lawyer_mgt');?></option>
									  <option value="PHP" <?php echo selected(get_option( 'lmgt_currency_code' ),'PHP');?>>
									  <?php esc_html_e('Philippine Peso','lawyer_mgt');?></option>
									  <option value="PLN" <?php echo selected(get_option( 'lmgt_currency_code' ),'PLN');?>>
									  <?php esc_html_e('Polish Zloty','lawyer_mgt');?></option>
									  <option value="GBP" <?php echo selected(get_option( 'lmgt_currency_code' ),'GBP');?>>
									  <?php esc_html_e('Pound Sterling','lawyer_mgt');?></option>
									  <option value="SGD" <?php echo selected(get_option( 'lmgt_currency_code' ),'SGD');?>>
									  <?php esc_html_e('Singapore Dollar','lawyer_mgt');?></option>
									  <option value="SEK" <?php echo selected(get_option( 'lmgt_currency_code' ),'SEK');?>>
									  <?php esc_html_e('Swedish Krona','lawyer_mgt');?></option>
									  <option value="CHF" <?php echo selected(get_option( 'lmgt_currency_code' ),'CHF');?>>
									  <?php esc_html_e('Swiss Franc','lawyer_mgt');?></option>
									  <option value="TWD" <?php echo selected(get_option( 'lmgt_currency_code' ),'TWD');?>>
									  <?php esc_html_e('Taiwan New Dollar','lawyer_mgt');?></option>
									  <option value="THB" <?php echo selected(get_option( 'lmgt_currency_code' ),'THB');?>>
									  <?php esc_html_e('Thai Baht','lawyer_mgt');?></option>
									  <option value="TRY" <?php echo selected(get_option( 'lmgt_currency_code' ),'TRY');?>>
									  <?php esc_html_e('Turkish Lira','lawyer_mgt');?></option>
									  <option value="USD" <?php echo selected(get_option( 'lmgt_currency_code' ),'USD');?>>
									  <?php esc_html_e('U.S. Dollar','lawyer_mgt');?></option>
									</select>
										</div>
										<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
											<span class="font_size_20_px_css"><?php echo MJ_lawmgt_get_currency_symbol(get_option( 'lmgt_currency_code' ));?></span>
										</div>
									</div>	
									
									<div class="header pt_10">		
										<h3><?php esc_html_e('Message Setting','lawyer_mgt');?></h3>
										<hr>
									</div>
									<div class="form-group padding_bottom_20px height_30px ">
										<label class="padding_bottom_10px col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label ml_20" for="lmgt_enable_staff_can_message"><?php esc_html_e("Staff can Message To Admin","lawyer_mgt");?></label>
										<div class="col-sm-6">
											<div class="checkbox">
												<label>
													<input type="checkbox" name="lmgt_enable_staff_can_message" class="margin_top_top "  value="yes" <?php echo checked(get_option('lmgt_enable_staff_can_message'),'yes');?>/><?php esc_html_e('Enable','lawyer_mgt');?>
											  </label>
										  </div>
										</div>
									</div> 
								<hr>
									
								<div class="case_rem">	
									<div class="header">		
										<h3><?php esc_html_e('Case Hearing Date Remainder Setting','lawyer_mgt');?></h3>
										 
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="lmgt_enable_case_hearing_date_remainder"><?php esc_html_e('Enable Alert Mail','lawyer_mgt');?></label>
										<div class="col-sm-8">
											<div class="checkbox">
												<label>
													<input type="checkbox" name="lmgt_enable_case_hearing_date_remainder"  class="margin_top_top" value="yes" <?php echo checked(get_option('lmgt_enable_case_hearing_date_remainder'),'yes');?>/><?php esc_html_e('Enable','lawyer_mgt');?>
											  </label>
										  </div>
										</div>
									</div>
							
									<div class="form-group">
										<label class="padding_bottom_10px col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="lmgt_case_hearing_date_remainder"><?php esc_html_e('Reminder Before Days','lawyer_mgt');?></label>
										<div class="col-sm-8">
											<input id="lmgt_case_hearing_date_remainder" class="form-control" min="0" type="number" onKeyPress="if(this.value.length==4) return false;" value="<?php echo esc_attr(get_option( 'lmgt_case_hearing_date_remainder' ));?>"  name="lmgt_case_hearing_date_remainder">
										</div>
									</div>
									
									<div class="header">
									 <hr>
										<h3><?php esc_html_e('Invoice Information','lawyer_mgt');?></h3>
									</div>								
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('GST Number / Vat Number / Tax number','lawyer_mgt');?></label>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<input class="form-control onlyletter_number_space_validation space_not_allow" maxlength="15" type="text" value="<?php echo esc_attr(get_option( 'lmgt_gst_number' ));?>"  name="lmgt_gst_number">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('TAX ID','lawyer_mgt');?></label>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<input class="form-control" type="number" min="0" onKeyPress="if(this.value.length==15) return false;" value="<?php echo esc_attr(get_option( 'lmgt_tax_id' ));?>"  name="lmgt_tax_id">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label padding_bottom_10px"><?php esc_html_e('Corporate ID','lawyer_mgt');?></label>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<input class="form-control" type="number" min="0" onKeyPress="if(this.value.length==15) return false;" value="<?php echo esc_attr(get_option( 'lmgt_corporate_id' ));?>"  name="lmgt_corporate_id">
										</div>
									</div>
									<div class="header">
									<hr>
										<h3><?php esc_html_e('Bank Details','lawyer_mgt');?></h3>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Bank Name','lawyer_mgt');?></label>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<input class="form-control validate[custom[onlyLetterSp]]" type="text" value="<?php echo esc_attr(get_option( 'lmgt_bank_name' ));?>"  name="lmgt_bank_name">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Account Holder Name','lawyer_mgt');?></label>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<input class="form-control validate[custom[onlyLetterSp]]" type="text" value="<?php echo esc_attr(get_option( 'lmgt_account_holder_name' ));?>"  name="lmgt_account_holder_name">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Account Number','lawyer_mgt');?></label>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<input class="form-control" type="number" min="0" onKeyPress="if(this.value.length==30) return false;" value="<?php echo esc_attr(get_option( 'lmgt_account_number' ));?>"  name="lmgt_account_number">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Account Type','lawyer_mgt');?></label>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<input class="form-control validate[custom[onlyLetterSp]]" type="text" value="<?php echo esc_attr(get_option( 'lmgt_account_type' ));?>"  name="lmgt_account_type">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('IFSC Code','lawyer_mgt');?></label>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<input class="form-control onlyletter_number_space_validation space_not_allow" maxlength="11" type="text" value="<?php echo esc_attr(get_option( 'lmgt_ifsc_code' ));?>"  name="lmgt_ifsc_code">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label padding_bottom_10px"><?php esc_html_e('Swift Code','lawyer_mgt');?></label>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<input class="form-control onlyletter_number_space_validation space_not_allow" maxlength="11" type="text" value="<?php echo esc_attr(get_option( 'lmgt_swift_code' ));?>"  name="lmgt_swift_code">
										</div>
									</div>	
									<div class="header">
									<hr>
										<h3><?php esc_html_e('Default Court Selection','lawyer_mgt');?></h3>
										<label><?php esc_html_e('You can select the your default court so while adding case, you no need to select the court again and again.','lawyer_mgt');?></label>
									</div>	
									<div class="form-group margin_top_10_px_css">	
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="court_id"><?php esc_html_e('Court','lawyer_mgt');?> </label>
										
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">			
											<select class="form-control courttostate" name="lmgt_default_court" id="courttostate">
											<option value=""><?php esc_html_e('Select Court','lawyer_mgt');?></option>
												<?php 
													$category = get_option( 'lmgt_default_court' );						
													$court_category=MJ_lawmgt_get_all_category('court_category');
													if(!empty($court_category))
													{
														foreach ($court_category as $retrive_data)
														{
															echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected($category,esc_html($retrive_data->ID)).'>'.esc_html($retrive_data->post_title).'</option>';
														}
													} 
												?>
											</select>
										</div>
									</div>
									<div class="offset-sm-2 col-sm-8 save_client_btn">	        	
										<input type="submit" value="<?php esc_attr_e('Save', 'lawyer_mgt' ); ?>" name="save_setting" class="btn btn-success"/>
									</div>       
								</form>
							</div>							
						<?php 
						} 
						if($active_tab == 'case_setting')
						{ 
							$page_columns_array=explode(',',get_option( 'lmgt_case_columns_option' ));
							$page_export_array=explode(',',get_option( 'lmgt_case_export_option' ));
							?>
						<div class="tab-pane  tabs fade  active in margin_top_25_px_css" id="nav-open" role="tabpanel" aria-labelledby="nav-open-tab">
							<form name="case_form" action="" method="post" class="form-horizontal" id="case_form">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">		
									<div class="header">	
										<h3 class="first_hed"><?php esc_html_e('Default Page Columns','lawyer_mgt');?></h3>
										<label><?php esc_html_e('You can select the columns that you want to see on the list page.','lawyer_mgt');?></label>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="case_name" <?php if(in_array('case_name',$page_columns_array)){ echo 'checked'; } ?> >
											<label class="control-label" for="case_name"><?php esc_html_e('Case Name','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="case_number" <?php if(in_array('case_number',$page_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="case_number"><?php esc_html_e('Case Number','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="open_date" <?php if(in_array('open_date',$page_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="open_date"><?php esc_html_e('Open Date','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="statute_of_limitation" <?php if(in_array('statute_of_limitation',$page_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="statute_of_limitation"><?php esc_html_e('Statute Of Limitation','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="priority" <?php if(in_array('priority',$page_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="priority"><?php esc_html_e('priority','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="practice_area" <?php if(in_array('practice_area',$page_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="practice_area"><?php esc_html_e('Practice Area','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="court_details" <?php if(in_array('court_details',$page_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="court_details"><?php esc_html_e('Court Details','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="contact_link" <?php if(in_array('contact_link',$page_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="contact_link"><?php esc_html_e('Client Link ','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="billing_contact_name" <?php if(in_array('billing_contact_name',$page_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="billing_contact_name"><?php esc_html_e('Billing Client Name','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="billing_type" <?php if(in_array('billing_type',$page_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="billing_type"><?php esc_html_e('Billing Type','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="attorney_name" <?php if(in_array('attorney_name',$page_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="attorney_name"><?php esc_html_e('Attorney Name','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="court_hall_no" <?php if(in_array('court_hall_no',$page_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="court_hall_no"><?php esc_html_e('Court Hall No','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="floor" <?php if(in_array('floor',$page_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="floor"><?php esc_html_e('Floor','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="crime_no" <?php if(in_array('crime_no',$page_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="crime_no"><?php esc_html_e('Crime No','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="fir_no" <?php if(in_array('fir_no',$page_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="fir_no"><?php esc_html_e('FIR No','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="hearing_date" <?php if(in_array('hearing_date',$page_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="hearing_date"><?php esc_html_e('Hearing Dates','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="stages" <?php if(in_array('stages',$page_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="stages"><?php esc_html_e('Stages','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="classification" <?php if(in_array('classification',$page_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="classification"><?php esc_html_e('Classification','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="earlier_court_history" <?php if(in_array('earlier_court_history',$page_columns_array)){ echo 'checked'; } ?>  />
											<label class="control-label" for="earlier_court_history"><?php esc_html_e('Earlier Court History','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="referred_by" <?php if(in_array('referred_by',$page_columns_array)){ echo 'checked'; } ?>  />
											<label class="control-label" for="referred_by"><?php esc_html_e('Referred By','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="opponent_details" <?php if(in_array('opponent_details',$page_columns_array)){ echo 'checked'; } ?>  />
											<label class="control-label" for="opponent_details"><?php esc_html_e('Opponent Details','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_columns[]" value="opponent_attorney_details" <?php if(in_array('opponent_attorney_details',$page_columns_array)){ echo 'checked'; } ?>  />
											<label class="control-label" for="opponent_attorney_details"><?php esc_html_e('Opponent  Attorney Details','lawyer_mgt');?></label>
										</div>
									</div>
								</div>
								
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 head_margin">	
								<hr>						
									<div class="header">	
										<h3 class="first_hed"><?php esc_html_e('Default Export Columns','lawyer_mgt');?></h3>
										<label><?php esc_html_e('You can select the columns that you want to export so you need to click the columns every time while exporting.','lawyer_mgt');?></label>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="case_name" <?php if(in_array('case_name',$page_export_array)){ echo 'checked'; } ?>>
											<label class="control-label" for="case_name"><?php esc_html_e('Case Name','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="case_number" <?php if(in_array('case_number',$page_export_array)){ echo 'checked'; } ?>/>
											<label class="control-label" for="case_number"><?php esc_html_e('Case Number','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="open_date" <?php if(in_array('open_date',$page_export_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="open_date"><?php esc_html_e('Open Date','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="statute_of_limitation" <?php if(in_array('statute_of_limitation',$page_export_array)){ echo 'checked'; } ?>/>
											<label class="control-label" for="statute_of_limitation"><?php esc_html_e('Statute Of Limitation','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="priority"<?php if(in_array('priority',$page_export_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="priority"><?php esc_html_e('priority','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="practice_area" <?php if(in_array('practice_area',$page_export_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="case_number"><?php esc_html_e('Practice Area','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="court_details"<?php if(in_array('court_details',$page_export_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="court_details"><?php esc_html_e('Court Details','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="contact_link" <?php if(in_array('contact_link',$page_export_array)){ echo 'checked'; } ?>/>
											<label class="control-label" for="contact_link"><?php esc_html_e('Client Link ','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="billing_contact_name" <?php if(in_array('billing_contact_name',$page_export_array)){ echo 'checked'; } ?>/>
											<label class="control-label" for="billing_contact_name"><?php esc_html_e('Billing Client Name','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="billing_type" <?php if(in_array('billing_type',$page_export_array)){ echo 'checked'; } ?>/>
											<label class="control-label" for="billing_type"><?php esc_html_e('Billing Type','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="attorney_name" <?php if(in_array('attorney_name',$page_export_array)){ echo 'checked'; } ?>/>
											<label class="control-label" for="attorney_name"><?php esc_html_e('Attorney Name','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="court_hall_no" <?php if(in_array('court_hall_no',$page_export_array)){ echo 'checked'; } ?>/>
											<label class="control-label" for="court_hall_no"><?php esc_html_e('Court Hall No','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="floor" <?php if(in_array('floor',$page_export_array)){ echo 'checked'; } ?>/>
											<label class="control-label" for="floor"><?php esc_html_e('Floor','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="crime_no" <?php if(in_array('crime_no',$page_export_array)){ echo 'checked'; } ?>/>
											<label class="control-label" for="crime_no"><?php esc_html_e('Crime No','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="fir_no" <?php if(in_array('fir_no',$page_export_array)){ echo 'checked'; } ?>/>
											<label class="control-label" for="fir_no"><?php esc_html_e('FIR No','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="hearing_date" <?php if(in_array('hearing_date',$page_export_array)){ echo 'checked'; } ?>/>
											<label class="control-label" for="hearing_date"><?php esc_html_e('Hearing Dates','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="stages" <?php if(in_array('stages',$page_export_array)){ echo 'checked'; } ?>/>
											<label class="control-label" for="stages"><?php esc_html_e('Stages','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="classification" <?php if(in_array('classification',$page_export_array)){ echo 'checked'; } ?>/>
											<label class="control-label" for="fir_no"><?php esc_html_e('Classification','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="earlier_court_history" <?php if(in_array('earlier_court_history',$page_export_array)){ echo 'checked'; } ?>/>
											<label class="control-label" for="hearing_date"><?php esc_html_e('Earlier Court History','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="referred_by" <?php if(in_array('referred_by',$page_export_array)){ echo 'checked'; } ?>/>
											<label class="control-label" for="referred_by"><?php esc_html_e('Referred By','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="opponent_details" <?php if(in_array('opponent_details',$page_export_array)){ echo 'checked'; } ?>  />
											<label class="control-label" for="opponent_details"><?php esc_html_e('Opponent Details','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="case_export[]" value="opponent_attorney_details" <?php if(in_array('opponent_attorney_details',$page_export_array)){ echo 'checked'; } ?>  />
											<label class="control-label" for="opponent_attorney_details"><?php esc_html_e('Opponent  Attorney Details','lawyer_mgt');?></label>
										</div>
									</div>
								</div>
								<div class=" col-sm-8 margin_top_15_px_css" >	        	
									<input type="submit" value="<?php esc_attr_e('Save', 'lawyer_mgt' ); ?>" name="save_case_setting" class="btn btn-success"/>
								</div> 
							</form>
						</div>
					<?php }
					if($active_tab == 'contact_setting')
					{ 
						$contact_columns_array=explode(',',get_option('lmgt_contact_columns_option'));
					?>
						<div class="tab-pane  tabs fade  active in margin_top_25_px_css" id="nav-open" role="tabpanel" aria-labelledby="nav-open-tab">
							<form name="contact_form" action="" method="post" class="form-horizontal" id="contact_form">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">		
									<div class="header">	
										<h3 class="first_hed"><?php esc_html_e('Default Page Columns','lawyer_mgt');?></h3>
										<label><?php esc_html_e('You can select the columns that you want to see on the list page.','lawyer_mgt');?></label>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="photo" <?php if(in_array('photo',$contact_columns_array)){ echo 'checked'; } ?> >
											<label class="control-label" for="photo"><?php esc_html_e('Photo','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="contact_name" <?php if(in_array('contact_name',$contact_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="contact_name"><?php esc_html_e('Client Name','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="date_of_birth" <?php if(in_array('date_of_birth',$contact_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="date_of_birth"><?php esc_html_e('Date Of Birth','lawyer_mgt');?></label>
										</div>
										 
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="contact_email" <?php if(in_array('contact_email',$contact_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="contact_email"><?php esc_html_e('Client Email','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="mobile_no" <?php if(in_array('mobile_no',$contact_columns_array)){ echo 'checked'; } ?>/>
											<label class="control-label" for="mobile_no"><?php esc_html_e('Mobile No','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="contact_case_link" <?php if(in_array('contact_case_link',$contact_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="contact_case_link"><?php esc_html_e('Case Link','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="group" <?php if(in_array('group',$contact_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="group"><?php esc_html_e('Group','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="address" <?php if(in_array('address',$contact_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="address"><?php esc_html_e('Address','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="contact_city" <?php if(in_array('contact_city',$contact_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="contact_city"><?php esc_html_e('City ','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="contact_state" <?php if(in_array('contact_state',$contact_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="contact_state"><?php esc_html_e('State','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="job_title" <?php if(in_array('job_title',$contact_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="job_title"><?php esc_html_e('Job Title','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="gender" <?php if(in_array('gender',$contact_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="gender"><?php esc_html_e('Gender','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="pin_code" <?php if(in_array('pin_code',$contact_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="pin_code"><?php esc_html_e('Pincode','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="alternate_no" <?php if(in_array('alternate_no',$contact_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="alternate_no"><?php esc_html_e('Alternate Mobile No','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="phone_home" <?php if(in_array('phone_home',$contact_columns_array)){ echo 'checked'; } ?>/>
											<label class="control-label" for="phone_home"><?php esc_html_e('Home Phone','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="phone_work" <?php if(in_array('phone_work',$contact_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="phone_work"><?php esc_html_e('Work Phone','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="fax" <?php if(in_array('fax',$contact_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="fax"><?php esc_html_e('Fax','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="license_no" <?php if(in_array('license_no',$contact_columns_array)){ echo 'checked'; } ?>/>
											<label class="control-label" for="license_no"><?php esc_html_e('License No','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="website" <?php if(in_array('website',$contact_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="website"><?php esc_html_e('Website','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="contact_columns[]" value="contact_description" <?php if(in_array('contact_description',$contact_columns_array)){ echo 'checked'; } ?> />
											<label class="control-label" for="contact_description"><?php esc_html_e('Description','lawyer_mgt');?></label>
										</div>
									</div>
									<div class=" col-sm-8 margin_top_15_px_css">	        	
									<input type="submit" value="<?php esc_attr_e('Save', 'lawyer_mgt' ); ?>" name="save_contact_setting" class="btn btn-success"/>
								</div>
								</div>
							</form>
						</div>
					<?php }
					if($active_tab == 'document_setting')
					{
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
							$document_columns_array=explode(',',get_option('lmgt_document_columns_option'));
							$document_export_array=explode(',',get_option('document_export_option'));
								?>
						<div class="tab-pane  tabs fade  active in margin_top_25_px_css" id="nav-open" role="tabpanel" aria-labelledby="nav-open-tab">
							<form name="contact_form" action="" method="post" class="form-horizontal" id="contact_form">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">		
									<div class="header">	
										<h3 class="first_hed"><?php esc_html_e('Default Page Columns','lawyer_mgt');?></h3>
										<label><?php esc_html_e('You can select the columns that you want to see on the list page.','lawyer_mgt');?></label>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="document_columns[]" value="document_title"<?php if(in_array('document_title',$document_columns_array)) { echo 'checked'; } ?> >
											<label class="control-label" for="document_title"><?php esc_html_e('Document Title','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="document_columns[]" value="document_type" <?php if(in_array('document_type',$document_columns_array)) { echo 'checked'; } ?> />
											<label class="control-label" for="document_type"><?php esc_html_e('Document Type','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="document_columns[]" value="document_case_link" <?php if(in_array('document_case_link',$document_columns_array)) { echo 'checked'; } ?>/>
											<label class="control-label" for="document_case_link"><?php esc_html_e('Case Link','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="document_columns[]" value="tag_name" <?php if(in_array('tag_name',$document_columns_array)) { echo 'checked'; } ?> />
											<label class="control-label" for="tag_name"><?php esc_html_e('Tags Name','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="document_columns[]" value="status" <?php if(in_array('status',$document_columns_array)) { echo 'checked'; }  ?> />
											<label class="control-label" for="status"><?php esc_html_e('Status','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="document_columns[]" value="last_updated" <?php if(in_array('last_updated',$document_columns_array)) { echo 'checked'; } ?> />
											<label class="control-label" for="last_updated"><?php esc_html_e('Last Updated','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="document_columns[]" value="document_description" <?php if(in_array('document_description',$document_columns_array)) { echo 'checked'; } ?> />
											<label class="control-label" for="document_description"><?php esc_html_e('Description','lawyer_mgt');?></label>
										</div>
									</div>	
								</div>
								
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 head_margin">	
								 <hr>	
									<div class="header">
										<h3 class="first_hed"><?php esc_html_e('Default Export Columns','lawyer_mgt');?></h3>
										<label><?php esc_html_e('You can select the columns that you want to export so you need to click the columns every time while exporting.','lawyer_mgt');?></label>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="document_export[]" value="document_title"  <?php if(in_array('document_title',$document_export_array)) { echo 'checked'; } ?> >
											<label class="control-label" for="document_title"><?php esc_html_e('Document Title','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="document_export[]" value="document_type"  <?php if(in_array('document_type',$document_export_array)) { echo 'checked'; }  ?> />
											<label class="control-label" for="document_type"><?php esc_html_e('Document Type','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="document_export[]" value="document_case_link"  <?php if(in_array('document_case_link',$document_export_array)) { echo 'checked'; } ?> />
											<label class="control-label" for="document_case_link"><?php esc_html_e('Case Link','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="document_export[]" value="tag_name"  <?php if(in_array('tag_name',$document_export_array)) { echo 'checked'; } ?> />
											<label class="control-label" for="tag_name"><?php esc_html_e('Tags Name','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="document_export[]" value="status"  <?php if(in_array('status',$document_export_array)) { echo 'checked'; } ?> />
											<label class="control-label" for="status"><?php esc_html_e('Status','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="document_export[]" value="last_updated"  <?php if(in_array('last_updated',$document_export_array)) { echo 'checked'; } ?> />
											<label class="control-label" for="last_updated"><?php esc_html_e('Last Updated','lawyer_mgt');?></label>
										</div>
									</div>	
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="document_export[]" value="document_description"  <?php if(in_array('document_description',$document_export_array)) { echo 'checked'; }  ?> />
											<label class="control-label" for="document_description"><?php esc_html_e('Description','lawyer_mgt');?></label>
										</div>
									</div>
								</div>
								<div class=" col-sm-8 margin_top_15_px_css">	        	
										<input type="submit" value="<?php esc_attr_e('Save', 'lawyer_mgt' ); ?>" name="save_document_setting" class="btn btn-success"/>
								</div> 
							</form>
						</div>
					<?php }
					if($active_tab == 'invoice_setting')
					{
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
							$invoice_columns_array=explode(',',get_option('lmgt_invoice_columns_option'));
					?>
						<div class="tab-pane  tabs fade  active in margin_top_25_px_css" id="nav-open" role="tabpanel" aria-labelledby="nav-open-tab">
							<form name="invoice_form" action="" method="post" class="form-horizontal" id="invoice_form">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">		
									<div class="header">	
										<h3 class="first_hed"><?php esc_html_e('Default Page Columns','lawyer_mgt');?></h3>
										<label><?php esc_html_e('You can select the columns that you want to see on the list page.','lawyer_mgt');?></label>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="invoice_columns[]" value="invoice_number" <?php if(in_array('invoice_number',$invoice_columns_array)) { echo 'checked';  } ?> >
											<label class="control-label" for="invoice_number"><?php esc_html_e('invoice Number','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="invoice_columns[]" value="invoice_date"  <?php if(in_array('invoice_date',$invoice_columns_array)) { echo 'checked';  } ?>/>
											<label class="control-label" for="invoice_date"><?php esc_html_e('Invoice Date','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="invoice_columns[]" value="due_date"  <?php if(in_array('due_date',$invoice_columns_array)) { echo 'checked';  } ?> />
											<label class="control-label" for="due_date"><?php esc_html_e('Due Date','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="invoice_columns[]" value="invoice_billing_contact_name"  <?php if(in_array('invoice_billing_contact_name',$invoice_columns_array)) { echo 'checked';  } ?> />
											<label class="control-label" for="invoice_billing_contact_name"><?php esc_html_e('Billing Client Name','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="invoice_columns[]" value="invoice_case_name"  <?php if(in_array('invoice_case_name',$invoice_columns_array)) { echo 'checked';  } ?> />
											<label class="control-label" for="invoice_case_name"><?php esc_html_e('Case Name','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="invoice_columns[]" value="total_amount"   <?php if(in_array('total_amount',$invoice_columns_array)) { echo 'checked';  } ?> />
											<label class="control-label" for="total_amount"><?php esc_html_e('Total Amount','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="invoice_columns[]" value="paid_amount"   <?php if(in_array('paid_amount',$invoice_columns_array)) { echo 'checked';  } ?>/>
											<label class="control-label" for="paid_amount"><?php esc_html_e('Paid Amount','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="invoice_columns[]" value="due_amount"  <?php if(in_array('due_amount',$invoice_columns_array)) { echo 'checked';  } ?> />
											<label class="control-label" for="due_amount"><?php esc_html_e('Due Amount','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="invoice_columns[]" value="payment_status"  <?php if(in_array('payment_status',$invoice_columns_array)) { echo 'checked';  } ?> />
											<label class="control-label" for="payment_status"><?php esc_html_e('Payment Status ','lawyer_mgt');?></label>
										</div>
									</div>
									<div class="table_row">
										 
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="invoice_columns[]" value="invoice_notes"  <?php if(in_array('invoice_notes',$invoice_columns_array)) { echo 'checked';  } ?> />
											<label class="control-label" for="invoice_notes"><?php esc_html_e('Notes','lawyer_mgt');?></label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
											<input type="checkbox" name="invoice_columns[]" value="terms"  <?php if(in_array('terms',$invoice_columns_array)) { echo 'checked';  } ?> />
											<label class="control-label" for="terms"><?php esc_html_e('Terms & Conditions ','lawyer_mgt');?></label>
										</div>
									</div>
								</div>
								<div class=" col-sm-8 margin_top_15_px_css ">	        	
										<input type="submit" value="<?php esc_attr_e('Save', 'lawyer_mgt' ); ?>" name="save_invoice_setting" class="btn btn-success " />
								</div>
							</form>
						</div>
					<?php }
					?>
					</div>
				</div>
			</div>
		</div>
	</div><!-- END  MAIN WRAPER  DIV -->
</div><!-- END  INNER PAGE  DIV -->