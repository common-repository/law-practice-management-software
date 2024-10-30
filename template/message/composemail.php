<script type="text/javascript">
jQuery(document).ready(function($)
{
	"use strict"; 
	$('#message_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
} );
</script>
<div class="mailbox-content"><!-- MAIL BOX CONTENT DIV  -->
	<h2>
		<?php 
		$edit=0;
		if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
		{
			 echo esc_html__( 'Edit Message', 'lawyer_mgt');
			 $edit=1;
			 $exam_data= get_exam_by_id($_REQUEST['exam_id']);
		}
		?>
	</h2>
	<?php
	if(isset($message))
		echo '<div id="message" class="updated below-h2"><p>'.$message.'</p></div>';
	?>
	<form name="message_form" action="" method="post" class="form-horizontal" id="message_form">
		<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
		<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
		<div class="form-group">
			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="to"><?php esc_html_e('Message To','lawyer_mgt');?><span class="require-field">*</span></label>
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
				<select name="receiver" class="form-control validate[required] text-input" id="to">
					<?php
					if($user_role != 'client')
					{
					?>
						<option value="attorney"><?php esc_html_e('All Attorney','lawyer_mgt');?></option>	
					
						<option value="client"><?php esc_html_e('All Client','lawyer_mgt');?></option>	
					
					<option value="staff_member"><?php esc_html_e('All Staff Member','lawyer_mgt');?></option>	
					<option value="accountant"><?php esc_html_e('All Accountant','lawyer_mgt');?></option>	
					<?php
					}
					
					if(get_option('lmgt_enable_staff_can_message')=='yes')
					{
						?>
						<option value="administrator"><?php esc_html_e('Admin','lawyer_mgt');?></option>	
						<?php
					} 
					MJ_lawmgt_get_all_user_in_message();
					?>
				</select>
			</div>	
		</div>
		<div class="form-group">
			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="subject"><?php esc_html_e('Subject','lawyer_mgt');?><span class="require-field">*</span></label>
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			   <input id="subject" class="form-control validate[required,custom[popup_category_validation]],maxSize[150]] text-input" maxlength="50" type="text" name="subject" >
			</div>
		</div>
		<?php wp_nonce_field( 'save_message_nonce' ); ?>
		<div class="form-group">
			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="subject"><?php esc_html_e('Message Comment','lawyer_mgt');?><span class="require-field">*</span></label>
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			  <textarea name="message_body" id="message_body" class="form-control  validate[required,custom[address_description_validation],maxSize[150]] text-input"></textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
				<div class="pull-right">
					<input type="submit" value="<?php if($edit){ esc_attr_e('Save Message','lawyer_mgt'); }else{ esc_attr_e('Send Message','lawyer_mgt');}?>" name="save_message" class="btn btn-success"/>
				</div>
			</div>
		</div>
	</form>
</div><!-- END MAIL BOX CONTENT DIV  -->