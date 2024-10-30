<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		"use strict";
		$('#message_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	} );
</script>
<div class="mailbox-content"><!-- MAILBOX CONTENT DIV   -->
	<form name="message_form" action="" method="post" class="form-horizontal" id="message_form">
		<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
		<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
		<div class="form-group">
			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="to"><?php esc_html_e('Message To','lawyer_mgt');?><span class="require-field">*</span></label>
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
				<select name="receiver" class="form-control validate[required] text-input" id="to">
					<option value="attorney"><?php esc_html_e('All Attorney','lawyer_mgt');?></option>	
					<option value="client"><?php esc_html_e('All Client','lawyer_mgt');?></option>	
					<option value="staff_member"><?php esc_html_e('All Staff Member','lawyer_mgt');?></option>	
					<option value="accountant"><?php esc_html_e('All Accountant','lawyer_mgt');?></option>	
					<?php MJ_lawmgt_get_all_user_in_message();?>
				</select>
			</div>	
		</div>
		<div class="form-group">
			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="subject"><?php esc_html_e('Subject','lawyer_mgt');?><span class="require-field">*</span></label>
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			   <input id="subject" class="form-control validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input"  type="text" name="subject" >
			</div>
		</div>
		<?php wp_nonce_field( 'save_message_nonce' ); ?>
		<div class="form-group">
			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="subject"><?php esc_html_e('Message Comment','lawyer_mgt');?><span class="require-field">*</span></label>
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			  <textarea name="message_body" id="message_body"  class="form-control validate[required,custom[address_description_validation],maxSize[150]] text-input"></textarea>
			</div>
		</div>

		<div class="form-group">
			<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
				<div class="pull-right">
					<input type="submit" value="<?php esc_attr_e('Send Message','lawyer_mgt');?>" name="save_message" class="btn btn-success"/>
				</div>
			</div>
		</div>
	</form>
</div><!-- END MAILBOX CONTENT DIV   -->