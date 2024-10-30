<script type="text/javascript">
jQuery(document).ready(function($)
{
	"use strict";
	$('#registration_email_template_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});		
});
</script>
   
<?php
if(isset($_REQUEST['user_registration_template']))
{
	update_option('lmgt_user_email_subject',sanitize_text_field($_REQUEST['lmgt_user_email_subject']));
	update_option('lmgt_user_email_template',sanitize_textarea_field($_REQUEST['lmgt_user_email_template']));			
}

if(isset($_REQUEST['case_registration_template']))
{
	update_option('lmgt_case_email_subject',sanitize_text_field($_REQUEST['lmgt_case_email_subject']));
	update_option('lmgt_case_email_template',sanitize_textarea_field($_REQUEST['lmgt_case_email_template']));			
} 

if(isset($_REQUEST['case_upcoming_reminder_template']))
{
	update_option('lmgt_case_upcoming_limitation_date_reminder_email_subject',
       	sanitize_text_field($_REQUEST['lmgt_case_upcoming_limitation_date_reminder_email_subject']));
	update_option('lmgt_case_upcoming_limitation_date_reminder_email_template',
				 sanitize_textarea_field($_REQUEST['lmgt_case_upcoming_limitation_date_reminder_email_template']));			
} 
if(isset($_REQUEST['case_assgined_template']))
{
	update_option('lmgt_case_assigned_email_subject',sanitize_text_field($_REQUEST['lmgt_case_assigned_email_subject']));
	update_option('lmgt_case_assigned_email_template',sanitize_textarea_field($_REQUEST['lmgt_case_assigned_email_template']));			
} 
if(isset($_REQUEST['case_assgined_update_template']))
{
	update_option('lmgt_case_assigned_upadete_email_subject',sanitize_text_field($_REQUEST['lmgt_case_assigned_upadete_email_subject']));
	update_option('lmgt_case_assigned_update_email_template',sanitize_textarea_field($_REQUEST['lmgt_case_assigned_update_email_template']));			
}
 
if(isset($_REQUEST['task_assgined_template']))
{
	update_option('lmgt_task_assigned_email_subject',sanitize_text_field($_REQUEST['lmgt_task_assigned_email_subject']));
	update_option('lmgt_task_assigned_email_template',sanitize_textarea_field($_REQUEST['lmgt_task_assigned_email_template']));			
}
if(isset($_REQUEST['task_assgined_updated_template']))
{
	update_option('lmgt_task_assigned_updated_email_subject',sanitize_text_field($_REQUEST['lmgt_task_assigned_updated_email_subject']));
	update_option('lmgt_task_assigned_updated_email_template',sanitize_textarea_field($_REQUEST['lmgt_task_assigned_updated_email_template']));			
}
if(isset($_REQUEST['event_assgined_template']))
{
	update_option('lmgt_event_assigned_email_subject',sanitize_text_field($_REQUEST['lmgt_event_assigned_email_subject']));
	update_option('lmgt_event_assigned_email_template',sanitize_textarea_field($_REQUEST['lmgt_event_assigned_email_template']));			
}
if(isset($_REQUEST['event_assgined_updated_template']))
{
	update_option('lmgt_event_assigned_updated_email_subject',sanitize_text_field($_REQUEST['lmgt_event_assigned_updated_email_subject']));
	update_option('lmgt_event_assigned_updated_email_template',sanitize_textarea_field($_REQUEST['lmgt_event_assigned_updated_email_template']));			
}
if(isset($_REQUEST['note_assgined_template']))
{
	update_option('lmgt_note_assigned_email_subject',sanitize_text_field($_REQUEST['lmgt_note_assigned_email_subject']));
	update_option('lmgt_note_assigned_email_template',sanitize_textarea_field($_REQUEST['lmgt_note_assigned_email_template']));			
}
if(isset($_REQUEST['workflow_event_assgined_template']))
{
	update_option('lmgt_workflow_event_email_subject',sanitize_text_field($_REQUEST['lmgt_workflow_event_email_subject']));
	update_option('lmgt_workflow_event_email_template',sanitize_textarea_field($_REQUEST['lmgt_workflow_event_email_template']));			
}
if(isset($_REQUEST['workflow_task_assgined_template']))
{
	update_option('lmgt_workflow_task_email_subject',sanitize_text_field($_REQUEST['lmgt_workflow_task_email_subject']));
	update_option('lmgt_workflow_task_email_template',sanitize_textarea_field($_REQUEST['lmgt_workflow_task_email_template']));			
}
if(isset($_REQUEST['payment_received_against_invoice_template']))
{
	update_option('lmgt_payment_received_against_invoice_email_subject',sanitize_text_field($_REQUEST['lmgt_payment_received_against_invoice_email_subject']));
	update_option('lmgt_payment_received_against_invoice_email_template',sanitize_textarea_field($_REQUEST['lmgt_payment_received_against_invoice_email_template']));			
}
if(isset($_REQUEST['message_received_template']))
{
	update_option('lmgt_message_received_email_subject',sanitize_text_field($_REQUEST['lmgt_message_received_email_subject']));
	update_option('lmgt_message_received_email_template',sanitize_textarea_field($_REQUEST['lmgt_message_received_email_template']));			
}
if(isset($_REQUEST['event_reminder_template']))
{
	update_option('lmgt_event_reminder_email_subject',sanitize_text_field($_REQUEST['lmgt_event_reminder_email_subject']));
	update_option('lmgt_event_reminder_email_template',sanitize_textarea_field($_REQUEST['lmgt_event_reminder_email_template']));			
}
if(isset($_REQUEST['task_reminder_template']))
{
	update_option('lmgt_task_reminder_email_subject',sanitize_text_field($_REQUEST['lmgt_task_reminder_email_subject']));
	update_option('lmgt_task_reminder_email_template',sanitize_textarea_field($_REQUEST['lmgt_task_reminder_email_template']));			
}
if(isset($_REQUEST['next_hearing_reminder_template']))
{
	update_option('lmgt_next_hearing_reminder_email_subject',sanitize_text_field($_REQUEST['lmgt_next_hearing_reminder_email_subject']));
	update_option('lmgt_next_hearing_reminder_email_template',sanitize_textarea_field($_REQUEST['lmgt_next_hearing_reminder_email_template']));			
}
if(isset($_REQUEST['case_judgment_template']))
{
	update_option('lmgt_judgment_email_subject',sanitize_text_field($_REQUEST['lmgt_judgment_email_subject']));
	update_option('lmgt_judgment_email_template',sanitize_textarea_field($_REQUEST['lmgt_judgment_email_template']));			
}
if(isset($_REQUEST['case_order_template']))
{
	update_option('lmgt_order_email_subject',sanitize_text_field($_REQUEST['lmgt_order_email_subject']));
	update_option('lmgt_order_email_template',sanitize_textarea_field($_REQUEST['lmgt_order_email_template']));			
}
if(isset($_REQUEST['updated_case_order_template']))
{
	update_option('lmgt_updated_order_email_subject',sanitize_text_field($_REQUEST['lmgt_updated_order_email_subject']));
	update_option('lmgt_updated_order_email_template',sanitize_textarea_field($_REQUEST['lmgt_updated_order_email_template']));			
}
if(isset($_REQUEST['weekly_case_report_template']))
{
	update_option('lmgt_weekly_case_report_email_subject',sanitize_text_field($_REQUEST['lmgt_weekly_case_report_email_subject']));
	update_option('lmgt_weekly_case_report_email_template',sanitize_textarea_field($_REQUEST['lmgt_weekly_case_report_email_template']));			
}
if(isset($_REQUEST['next_hearing_date_template']))
{
	update_option('lmgt_next_hearing_date_email_subject',sanitize_text_field($_REQUEST['lmgt_next_hearing_date_email_subject']));
	update_option('lmgt_next_hearing_date_email_template',sanitize_textarea_field($_REQUEST['lmgt_next_hearing_date_email_template']));
} 
if(isset($_REQUEST['invoice_generated_template']))
{
	update_option('lmgt_generate_invoice_email_subject',sanitize_text_field($_REQUEST['lmgt_generate_invoice_email_subject']));
	update_option('lmgt_generate_invoice_email_template',sanitize_textarea_field($_REQUEST['lmgt_generate_invoice_email_template']));
}
?>
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV -->
	<div class="page-title">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' ));?>
		</h3>
	</div>
	
<div id="main-wrapper"><!-- MAIN WRAPER  DIV -->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-white mail_shadow">
				<div class="panel-body">
					<div class="panel-group" id="accordion">		
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
								  <?php esc_html_e('User Registration Template ','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapseOne" class="panel-collapse collapse">
							  <div class="panel-body">
								<form  class="form-horizontal" method="post" action="" name="parent_form">

									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
										<div class="col-md-8">
											<input class="form-control validate[required]" name="lmgt_user_email_subject" id="user_email_subject" placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print get_option('lmgt_user_email_subject'); ?>">	
										</div>
									</div>
									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
										<div class="col-md-8">
											<textarea  name="lmgt_user_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_user_email_template')); ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="offset-sm-3 col-md-8">
											<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>
											
											<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{User Name}}</strong> <?php esc_html_e('User Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Password}}</strong> <?php esc_html_e('Password','lawyer_mgt'); ?></label><br>
											<label><strong>{{Login Link}}</strong> <?php esc_html_e('Login Link','lawyer_mgt'); ?></label><br>
																
										</div>
									</div>
									<div class="offset-sm-3 col-sm-8">        	
										<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="user_registration_template" class="btn btn-success" type="submit">
									</div>
								</form>
							  </div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsetwo">
								  <?php esc_html_e('Case Registration Template ','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapsetwo" class="panel-collapse collapse">
							  <div class="panel-body">
								<form  class="form-horizontal" method="post" action="" name="parent_form">

									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
										<div class="col-md-8">
											<input class="form-control validate[required]" name="lmgt_case_email_subject" id="case_email_subject" placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_case_email_subject')); ?>">	
										</div>
									</div>
									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
										<div class="col-md-8">
											<textarea name="lmgt_case_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_case_email_template')); ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="offset-sm-3 col-md-8">
											<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>				
											<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{User Name}}</strong> <?php esc_html_e('User Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Login Link}}</strong> <?php esc_html_e('Login Link','lawyer_mgt'); ?></label><br>
																
										</div>
									</div>
									<div class="offset-sm-3 col-sm-8">        	
										<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="case_registration_template" class="btn btn-success" type="submit">
									</div>
								</form>
							  </div>
							</div>
					    </div>
						<div class="panel panel-default">
							<div class="panel-heading mail_height">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsethree">
								  <?php esc_html_e('Case Upcoming Statute of Limitation Due Date Reminder Template ','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapsethree" class="panel-collapse collapse">
							  <div class="panel-body">
								<form  class="form-horizontal" method="post" action="" name="parent_form">

									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
										<div class="col-md-8">
											<input class="form-control validate[required]"
											name="lmgt_case_upcoming_limitation_date_reminder_email_subject" 
											id="case_upcoming_limitation_date_reminder_email_subject" placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_case_upcoming_limitation_date_reminder_email_subject')); ?>">	
										</div>
									</div>
									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
										<div class="col-md-8">
											<textarea 
											name="lmgt_case_upcoming_limitation_date_reminder_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_case_upcoming_limitation_date_reminder_email_template')); ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="offset-sm-3 col-md-8">
											<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>
											
											<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{User Name}}</strong> <?php esc_html_e('User Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Case Name}}</strong> <?php esc_html_e('Case Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Statute of Limitations Date}}</strong> <?php esc_html_e('Statute of Limitations Date','lawyer_mgt'); ?></label><br>
											<label><strong>{{Login Link}}</strong> <?php esc_html_e('Login Link','lawyer_mgt'); ?></label><br>																
										</div>
									</div>
									<div class="offset-sm-3 col-sm-8">        	
										<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="case_upcoming_reminder_template" class="btn btn-success" type="submit">
									</div>
								</form>
							  </div>
							</div>
						</div>
						
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsefour">
								  <?php esc_html_e('Case Assigned Template','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapsefour" class="panel-collapse collapse">
							  <div class="panel-body">
								<form  class="form-horizontal" method="post" action="" name="parent_form">

									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
										<div class="col-md-8">
											<input class="form-control validate[required]" name="lmgt_case_assigned_email_subject" id="case_email_subject" placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_case_assigned_email_subject')); ?>">	
										</div>
									</div>
									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
										<div class="col-md-8">
											<textarea name="lmgt_case_assigned_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_case_assigned_email_template')); ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="offset-sm-3 col-md-8">
											<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>								
											<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Attrony Name}}</strong> <?php esc_html_e('Attrony Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Case Name}}</strong> <?php esc_html_e('Case Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Case Number}}</strong> <?php esc_html_e('Case Number','lawyer_mgt'); ?></label><br>
											<label><strong>{{Open Date}}</strong> <?php esc_html_e('Open Date','lawyer_mgt'); ?></label><br>
											<label><strong>{{Statute of Limitations Date}}</strong> <?php esc_html_e('Statute of Limitations Date','lawyer_mgt'); ?></label><br>
											<label><strong>{{Login Link}}</strong> <?php esc_html_e('Login Link','lawyer_mgt'); ?></label><br>
																
										</div>
									</div>
									<div class="offset-sm-3 col-sm-8">        	
										<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="case_assgined_template" class="btn btn-success" type="submit">
									</div>
								</form>
							  </div>
							</div>
						</div>
						
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsefour_update">
								  <?php esc_html_e('Case Updated Template','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapsefour_update" class="panel-collapse collapse">
							  <div class="panel-body">
								<form  class="form-horizontal" method="post" action="" name="parent_form">

									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
										<div class="col-md-8">
											<input class="form-control validate[required]" name="lmgt_case_assigned_upadete_email_subject" id="case_assigned_upadete_email_subject" placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_case_assigned_upadete_email_subject')); ?>">	
										</div>
									</div>
									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
										<div class="col-md-8">
											<textarea  name="lmgt_case_assigned_update_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_case_assigned_update_email_template')); ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="offset-sm-3 col-md-8">
											<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>								
											<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{User Name}}</strong> <?php esc_html_e('User Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Case Name}}</strong> <?php esc_html_e('Case Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Case Number}}</strong> <?php esc_html_e('Case Number','lawyer_mgt'); ?></label><br>
											<label><strong>{{Open Date}}</strong> <?php esc_html_e('Open Date','lawyer_mgt'); ?></label><br>
											<label><strong>{{Statute of Limitations Date}}</strong> <?php esc_html_e('Statute of Limitations Date','lawyer_mgt'); ?></label><br>
											 
										</div>
									</div>
									<div class="offset-sm-3 col-sm-8">        	
										<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="case_assgined_update_template" class="btn btn-success" type="submit">
									</div>
								</form>
							  </div>
							</div>
						</div>
						
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsefourth_order">
								  <?php esc_html_e('Case Order Template','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapsefourth_order" class="panel-collapse collapse">
							  <div class="panel-body">
								<form  class="form-horizontal" method="post" action="" name="parent_form">

									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
										<div class="col-md-8">
											<input class="form-control validate[required]" name="lmgt_order_email_subject" id="order_email_subject" placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_order_email_subject')); ?>">	
										</div>
									</div>
									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
										<div class="col-md-8">
											<textarea  name="lmgt_order_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_order_email_template')); ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="offset-sm-3 col-md-8">
											<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>								
											<label><strong>{{User Name}}</strong> <?php esc_html_e('User Name','lawyer_mgt'); ?></label><br><label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Case Name}}</strong> <?php esc_html_e('Case Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Case Number}}</strong> <?php esc_html_e('Case Number','lawyer_mgt'); ?></label><br>
											<label><strong>{{Judge Name}} </strong> <?php esc_html_e('Judge Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Next Hearing Date}}</strong> <?php esc_html_e('Next Hearing Date','lawyer_mgt'); ?></label><br>
											<label><strong>{{Order Details}}</strong> <?php esc_html_e('Order Details','lawyer_mgt'); ?></label><br>
										</div>
									</div>
									<div class="offset-sm-3 col-sm-8">        	
										<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="case_order_template" class="btn btn-success" type="submit">
									</div>
								</form>
							  </div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsefourth_order_updated">
								  <?php esc_html_e('Case Order Updated Template','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapsefourth_order_updated" class="panel-collapse collapse">
							  <div class="panel-body">
								<form  class="form-horizontal" method="post" action="" name="parent_form">

									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
										<div class="col-md-8">
											<input class="form-control validate[required]" name="lmgt_updated_order_email_subject" id="order_email_subject" placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_updated_order_email_subject')); ?>">	
										</div>
									</div>
									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
										<div class="col-md-8">
											<textarea name="lmgt_updated_order_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_updated_order_email_template')); ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="offset-sm-3 col-md-8">
											<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>								
											<label><strong>{{User Name}}</strong> <?php esc_html_e('User Name','lawyer_mgt'); ?></label><br><label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Case Name}}</strong> <?php esc_html_e('Case Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Case Number}}</strong> <?php esc_html_e('Case Number','lawyer_mgt'); ?></label><br>
											<label><strong>{{Judge Name}} </strong> <?php esc_html_e('Judge Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Next Hearing Date}}</strong> <?php esc_html_e('Next Hearing Date','lawyer_mgt'); ?></label><br>
											<label><strong>{{Order Details}}</strong> <?php esc_html_e('Order Details','lawyer_mgt'); ?></label><br>
										</div>
									</div>
									<div class="offset-sm-3 col-sm-8">        	
										<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="updated_case_order_template" class="btn btn-success" type="submit">
									</div>
								</form>
							  </div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsefourth_hearing_date_updated">
								  <?php esc_html_e('Case Judgment Template','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapsefourth_hearing_date_updated" class="panel-collapse collapse">
							  <div class="panel-body">
								<form  class="form-horizontal" method="post" action="" name="parent_form">

									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
										<div class="col-md-8">
											<input class="form-control validate[required]" name="lmgt_judgment_email_subject" id="judgment_email_subject" placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_judgment_email_subject')); ?>">	
										</div>
									</div>
									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
										<div class="col-md-8">
											<textarea name="lmgt_judgment_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_judgment_email_template')); ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="offset-sm-3 col-md-8">
											<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>								
											<label><strong>{{User Name}}</strong> <?php esc_html_e('User Name','lawyer_mgt'); ?></label><br><label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Case Name}}</strong> <?php esc_html_e('Case Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Case Number}}</strong> <?php esc_html_e('Case Number','lawyer_mgt'); ?></label><br>
											<label><strong>{{Judge Name}} </strong> <?php esc_html_e('Judge Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Date}}</strong> <?php esc_html_e('Judgement Date','lawyer_mgt'); ?></label><br>
											<label><strong>{{Judgments Details}}</strong> <?php esc_html_e('Judgments Details','lawyer_mgt'); ?></label><br>
										</div>
									</div>
									<div class="offset-sm-3 col-sm-8">        	
										<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="case_judgment_template" class="btn btn-success" type="submit">
									</div>
								</form>
							  </div>
							</div>
						</div>
						<?php
						if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
						{
						?>
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsefive">
								  <?php esc_html_e('Generate Invoice Template','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapsefive" class="panel-collapse collapse">
							  <div class="panel-body">
								<form  class="form-horizontal" method="post" action="" name="invoice_generated_form">

									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
										<div class="col-md-8">
											<input class="form-control validate[required]" name="lmgt_generate_invoice_email_subject" id="case_email_subject" placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_generate_invoice_email_subject')); ?>">	
										</div>
									</div>
									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
										<div class="col-md-8">
											<textarea  name="lmgt_generate_invoice_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_generate_invoice_email_template')); ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="offset-sm-3 col-md-8">
											<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>
											
											<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{User Name}}</strong> <?php esc_html_e('User Name','lawyer_mgt'); ?></label><br>															
										</div>
									</div>
									<div class="offset-sm-3 col-sm-8">        	
										<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="invoice_generated_template" class="btn btn-success" type="submit">
									</div>
								</form>
							  </div>
							</div>
						</div>						
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsesix">
								  <?php esc_html_e('Task Assigned Template','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapsesix" class="panel-collapse collapse">
							  <div class="panel-body">
								<form  class="form-horizontal" method="post" action="" name="parent_form">

									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
										<div class="col-md-8">
											<input class="form-control validate[required]" name="lmgt_task_assigned_email_subject" id="task_email_subject" placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_task_assigned_email_subject')); ?>">	
										</div>
									</div>
									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
										<div class="col-md-8">
											<textarea  name="lmgt_task_assigned_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_task_assigned_email_template')); ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="offset-sm-3 col-md-8">
											<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>
											
											<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Task Name}}</strong> <?php esc_html_e('Task Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Case Name}}</strong> <?php esc_html_e('Case Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Practice Area}}</strong> <?php esc_html_e('Practice Area','lawyer_mgt'); ?></label><br>
											<label><strong>{{Status}}</strong> <?php esc_html_e('Status','lawyer_mgt'); ?></label><br>
											<label><strong>{{Due Date}}</strong> <?php esc_html_e('Due Date','lawyer_mgt'); ?></label><br>
											<label><strong>{{Description}}</strong> <?php esc_html_e('Description','lawyer_mgt'); ?></label><br>
															
										</div>
									</div>
									<div class="offset-sm-3 col-sm-8">        	
										<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="task_assgined_template" class="btn btn-success" type="submit">
									</div>
								</form>
							  </div>
							</div>
						</div>
						
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsesix_upadetd">
								  <?php esc_html_e('Assigned Task Updated Template','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapsesix_upadetd" class="panel-collapse collapse">
							  <div class="panel-body">
								<form  class="form-horizontal" method="post" action="" name="parent_form">

									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
										<div class="col-md-8">
											<input class="form-control validate[required]" name="lmgt_task_assigned_updated_email_subject" id="task_assigned_updated_email_subject" placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_task_assigned_updated_email_subject')); ?>">	
										</div>
									</div>
									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
										<div class="col-md-8">
											<textarea  name="lmgt_task_assigned_updated_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_task_assigned_updated_email_template')); ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="offset-sm-3 col-md-8">
											<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>
											
											<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Task Name}}</strong> <?php esc_html_e('Task Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Case Name}}</strong> <?php esc_html_e('Case Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Practice Area}}</strong> <?php esc_html_e('Practice Area','lawyer_mgt'); ?></label><br>
											<label><strong>{{Status}}</strong> <?php esc_html_e('Status','lawyer_mgt'); ?></label><br>
											<label><strong>{{Due Date}}</strong> <?php esc_html_e('Due Date','lawyer_mgt'); ?></label><br>
											<label><strong>{{Description}}</strong> <?php esc_html_e('Description','lawyer_mgt'); ?></label><br>
															
										</div>
									</div>
									<div class="offset-sm-3 col-sm-8">        	
										<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="task_assgined_updated_template" class="btn btn-success" type="submit">
									</div>
								</form>
							  </div>
							</div>
						</div>
						<?php
						}
						?>
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseven">
								  <?php esc_html_e('Event Assigned Template','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapseven" class="panel-collapse collapse">
							  <div class="panel-body">
								<form  class="form-horizontal" method="post" action="" name="parent_form">

									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
										<div class="col-md-8">
											<input class="form-control validate[required]" name="lmgt_event_assigned_email_subject" id="event_email_subject" placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_event_assigned_email_subject')); ?>">	
										</div>
									</div>
									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
										<div class="col-md-8">
											<textarea  name="lmgt_event_assigned_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_event_assigned_email_template')); ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="offset-sm-3 col-md-8">
											<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>
											
											<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Event Name}}</strong> <?php esc_html_e('Event Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Case Name}}</strong> <?php esc_html_e('Case Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Practice Area}}</strong> <?php esc_html_e('Practice Area','lawyer_mgt'); ?></label><br>
											<label><strong>{{Address}}</strong> <?php esc_html_e('Address','lawyer_mgt'); ?></label><br>
											<label><strong>{{Start Date}}</strong> <?php esc_html_e('Start Date','lawyer_mgt'); ?></label><br>
											<label><strong>{{Description}}</strong> <?php esc_html_e('Description','lawyer_mgt'); ?></label><br>
													
										</div>
									</div>
									<div class="offset-sm-3 col-sm-8">        	
										<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="event_assgined_template" class="btn btn-success" type="submit">
									</div>
								</form>
							  </div>
							</div>
						</div>
						
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseven_updated">
								  <?php esc_html_e('Assigned Event Updated Template','lawyer_mgt'); ?>
								</a>
							  </h4>	
							</div>
							<div id="collapseven_updated" class="panel-collapse collapse">
							  <div class="panel-body">
								<form  class="form-horizontal" method="post" action="" name="parent_form">

									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
										<div class="col-md-8">
											<input class="form-control validate[required]" name="lmgt_event_assigned_updated_email_subject" id="event_assigned_updated_email_subject" placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_event_assigned_updated_email_subject')); ?>">	
										</div>
									</div>
									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
										<div class="col-md-8">
											<textarea  name="lmgt_event_assigned_updated_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_event_assigned_updated_email_template')); ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="offset-sm-3 col-md-8">
											<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>
											
											<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Event Name}}</strong> <?php esc_html_e('Event Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Case Name}}</strong> <?php esc_html_e('Case Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Practice Area}}</strong> <?php esc_html_e('Practice Area','lawyer_mgt'); ?></label><br>
											<label><strong>{{Address}}</strong> <?php esc_html_e('Address','lawyer_mgt'); ?></label><br>
											<label><strong>{{Start Date}}</strong> <?php esc_html_e('Start Date','lawyer_mgt'); ?></label><br>
											<label><strong>{{Description}}</strong> <?php esc_html_e('Description','lawyer_mgt'); ?></label><br>
													
										</div>
									</div>
									<div class="offset-sm-3 col-sm-8">        	
										<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="event_assgined_updated_template" class="btn btn-success" type="submit">
									</div>
								</form>
							  </div>
							</div>
						</div>
						
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapeight">
								  <?php esc_html_e('Note Assigned Template','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapeight" class="panel-collapse collapse">
							  <div class="panel-body">
								<form  class="form-horizontal" method="post" action="" name="parent_form">

									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
										<div class="col-md-8">
											<input class="form-control validate[required]" name="lmgt_note_assigned_email_subject" id="note_email_subject" placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_note_assigned_email_subject')); ?>">	
										</div>
									</div>
									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
										<div class="col-md-8">
											<textarea  name="lmgt_note_assigned_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_note_assigned_email_template')); ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="offset-sm-3 col-md-8">
											<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>
											
											<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{User Name}}</strong> <?php esc_html_e('User Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Note Name}}</strong> <?php esc_html_e('Note Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Case Name}}</strong> <?php esc_html_e('Case Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Practice Area}}</strong> <?php esc_html_e('Practice Area','lawyer_mgt'); ?></label><br>
											<label><strong>{{Date}}</strong> <?php esc_html_e('Date','lawyer_mgt'); ?></label><br>
											<label><strong>{{Note}}</strong> <?php esc_html_e('Note','lawyer_mgt'); ?></label><br>
													
										</div>
									</div>
									<div class="offset-sm-3 col-sm-8">        	
										<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="note_assgined_template" class="btn btn-success" type="submit">
									</div>
								</form>
							  </div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapnine">
								  <?php esc_html_e('Workflow Event Assigned Template','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapnine" class="panel-collapse collapse">
							  <div class="panel-body">
								<form  class="form-horizontal" method="post" action="" name="parent_form">

									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
										<div class="col-md-8">
											<input class="form-control validate[required]" name="lmgt_workflow_event_email_subject" id="note_email_subject" placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_workflow_event_email_subject')); ?>">	
										</div>
									</div>
									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
										<div class="col-md-8">
											<textarea  name="lmgt_workflow_event_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_workflow_event_email_template')); ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="offset-sm-3 col-md-8">
											<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>
											
											<label><strong>{{User Name}}</strong> <?php esc_html_e('User Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Attorney Name}}</strong> <?php esc_html_e('Attorney Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Login Link}}</strong> <?php esc_html_e('Login Link	','lawyer_mgt'); ?></label><br>
											<label><strong>{{Event Name}}</strong> <?php esc_html_e('Event Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Start Date}}</strong> <?php esc_html_e('Start Date','lawyer_mgt'); ?></label><br>
											<!--<label><strong>{{Description }}</strong> <?php esc_html_e('Description','lawyer_mgt'); ?></label><br>-->
											<label><strong>{{Case Name}}</strong> <?php esc_html_e('Case Name','lawyer_mgt'); ?></label><br>							
										</div>
									</div>
									<div class="offset-sm-3 col-sm-8">        	
										<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="workflow_event_assgined_template" class="btn btn-success" type="submit">
									</div>
								</form>
							  </div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapten">
								  <?php esc_html_e('Workflow Task Assigned Template','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapten" class="panel-collapse collapse">
							  <div class="panel-body">
								<form  class="form-horizontal" method="post" action="" name="parent_form">

									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
										<div class="col-md-8">
											<input class="form-control validate[required]" name="lmgt_workflow_task_email_subject" id="note_email_subject" placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_workflow_task_email_subject')); ?>">	
										</div>
									</div>
									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
										<div class="col-md-8">
											<textarea  name="lmgt_workflow_task_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_workflow_task_email_template')); ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="offset-sm-3 col-md-8">
											<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>
											
											<label><strong>{{User Name}}</strong> <?php esc_html_e('User Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Attorney Name}}</strong> <?php esc_html_e('Attorney Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Login Link}}</strong> <?php esc_html_e('Login Link','lawyer_mgt'); ?></label><br>
											<label><strong>{{Task Name}}</strong> <?php esc_html_e('Task Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Due Date}}</strong> <?php esc_html_e('Due Date','lawyer_mgt'); ?></label><br>
											<!--<label><strong>{{Description }}</strong> <?php esc_html_e('Description','lawyer_mgt'); ?></label><br>-->
											<label><strong>{{Case Name}}</strong> <?php esc_html_e('Case Name','lawyer_mgt'); ?></label><br>							
										</div>
									</div>
									<div class="offset-sm-3 col-sm-8">        	
										<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="workflow_task_assgined_template" class="btn btn-success" type="submit">
									</div>
								</form>
							  </div>
							</div>
						</div>		
						<?php
						if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
						{
							?>							
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseten">
								  <?php esc_html_e('Payment Received against Invoice','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapseten" class="panel-collapse collapse">
								<div class="panel-body">
									<form  class="form-horizontal" method="post" action="" name="payment_received_against_invoice_form">

										<div class="form-group">
											<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
											<div class="col-md-8">
												<input class="form-control validate[required]" name="lmgt_payment_received_against_invoice_email_subject"  placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_payment_received_against_invoice_email_subject')); ?>">	
											</div>
										</div>
										<div class="form-group">
											<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
											<div class="col-md-8">
												<textarea  name="lmgt_payment_received_against_invoice_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_payment_received_against_invoice_email_template')); ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<div class="offset-sm-3 col-md-8">
												<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>
												
												<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>
												<label><strong>{{User Name}}</strong> <?php esc_html_e('User Name','lawyer_mgt'); ?></label><br>															
											</div>
										</div>
										<div class="offset-sm-3 col-sm-8">        	
											<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="payment_received_against_invoice_template" class="btn btn-success" type="submit">
										</div>
									</form>
								</div>
							</div>
						</div>
						<?php
						}
						?>
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseeleven">
								  <?php esc_html_e('Message Received Template','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapseeleven" class="panel-collapse collapse">
								<div class="panel-body">
									<form  class="form-horizontal" method="post" action="" name="message_received_form">
										<div class="form-group">
											<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
											<div class="col-md-8">
												<input class="form-control validate[required]" name="lmgt_message_received_email_subject"  placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_message_received_email_subject')); ?>">	
											</div>
										</div>
										<div class="form-group">
											<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
											<div class="col-md-8">
												<textarea  name="lmgt_message_received_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_message_received_email_template')); ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<div class="offset-sm-3 col-md-8">
												<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>
												<label><strong>{{Receiver Name}}</strong> <?php esc_html_e('Name Of Receiver','lawyer_mgt'); ?></label><br>
												<label><strong>{{Sender Name}}</strong> <?php esc_html_e('Name Of Sender','lawyer_mgt'); ?></label><br>
												<label><strong>{{Message Content}} </strong> <?php esc_html_e('Message Content','lawyer_mgt'); ?></label><br>
												<label><strong>{{Message_Link}} </strong> <?php esc_html_e('Message_Link','lawyer_mgt'); ?></label><br>
												<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>													
											</div>
										</div>
										<div class="offset-sm-3 col-sm-8">        	
											<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="message_received_template" class="btn btn-success" type="submit">
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsetwelve">
								  <?php esc_html_e('Event Reminder Template','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapsetwelve" class="panel-collapse collapse">
								<div class="panel-body">
									<form  class="form-horizontal" method="post" action="" name="event_reminder_form">
										<div class="form-group">
											<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
											<div class="col-md-8">
												<input class="form-control validate[required]" name="lmgt_event_reminder_email_subject"  placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_event_reminder_email_subject')); ?>">	
											</div>
										</div>
										<div class="form-group">
											<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
											<div class="col-md-8">
												<textarea  name="lmgt_event_reminder_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_event_reminder_email_template')); ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<div class="offset-sm-3 col-md-8">
												<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>
												
												<label><strong>{{User Name}}</strong> <?php esc_html_e('User Name','lawyer_mgt'); ?></label><br>
												<label><strong>{{Case Name}}</strong> <?php esc_html_e('Case Name','lawyer_mgt'); ?></label><br>
												<label><strong>{{Event Name}} </strong> <?php esc_html_e('Event Name','lawyer_mgt'); ?></label><br>
												<label><strong>{{Start Date}} </strong> <?php esc_html_e('Start Date','lawyer_mgt'); ?></label><br>
												<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>													
												<label><strong>{{Login Link}}</strong> <?php esc_html_e('Login Link','lawyer_mgt'); ?></label><br>													
											</div>
										</div>
										<div class="offset-sm-3 col-sm-8">        	
											<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="event_reminder_template" class="btn btn-success" type="submit">
										</div>
									</form>
								</div>
							</div>
						</div>
						<?php
						if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
						{
						?>
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsethirteen">
								  <?php esc_html_e('Task Reminder Template','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapsethirteen" class="panel-collapse collapse">
								<div class="panel-body">
									<form  class="form-horizontal" method="post" action="" name="task_reminder_form">
										<div class="form-group">
											<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
											<div class="col-md-8">
												<input class="form-control validate[required]" name="lmgt_task_reminder_email_subject"  placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_task_reminder_email_subject')); ?>">	
											</div>
										</div>
										<div class="form-group">
											<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
											<div class="col-md-8">
												<textarea  name="lmgt_task_reminder_email_template" class="form-control validate[required] min_height_200_px_css"><?php print esc_html(get_option('lmgt_task_reminder_email_template')); ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<div class="offset-sm-3 col-md-8">
												<label><strong>{{User Name}}</strong> <?php esc_html_e('User Name','lawyer_mgt'); ?></label><br>
												<label><strong>{{Case Name}}</strong> <?php esc_html_e('Case Name','lawyer_mgt'); ?></label><br>
												<label><strong>{{Task Name}} </strong> <?php esc_html_e('Task Name','lawyer_mgt'); ?></label><br>
												<label><strong>{{Due Date}} </strong> <?php esc_html_e('Due Date','lawyer_mgt'); ?></label><br>
												<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>													
												<label><strong>{{Login Link}}</strong> <?php esc_html_e('Login Link','lawyer_mgt'); ?></label><br>													
											</div>
										</div>
										<div class="offset-sm-3 col-sm-8">        	
											<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="task_reminder_template" class="btn btn-success" type="submit">
										</div>
									</form>
								</div>
							</div>
						</div>
						<?php
						}
						?>
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFourteen">
								  <?php esc_html_e('Next Hearing Reminder Template','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapseFourteen" class="panel-collapse collapse">
								<div class="panel-body">
									<form  class="form-horizontal" method="post" action="" name="next_hearing_reminder_form">
										<div class="form-group">
											<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
											<div class="col-md-8">
												<input class="form-control validate[required]" name="lmgt_next_hearing_reminder_email_subject"  placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_next_hearing_reminder_email_subject')); ?>">	
											</div>
										</div>
										<div class="form-group">
											<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
											<div class="col-md-8">
												<textarea  name="lmgt_next_hearing_reminder_email_template" class="form-control validate[required] min_height_200_px_css"><?php print esc_html(get_option('lmgt_next_hearing_reminder_email_template')); ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<div class="offset-sm-3 col-md-8">
												<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>								
												<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>
												<label><strong>{{User Name}}</strong> <?php esc_html_e('User Name','lawyer_mgt'); ?></label><br>
												<label><strong>{{Case Name}}</strong> <?php esc_html_e('Case Name','lawyer_mgt'); ?></label><br>
												<label><strong>{{Case Number}}</strong> <?php esc_html_e('Case Number','lawyer_mgt'); ?></label><br>
												<label><strong>{{Next Hearing Date}}</strong> <?php esc_html_e('Next Hearing Date','lawyer_mgt'); ?></label><br>
											</div>
										</div>
										<div class="offset-sm-3 col-sm-8">        	
											<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="next_hearing_reminder_template" class="btn btn-success" type="submit">
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFourteen_case_report">
								  <?php esc_html_e('Weekly Cases Updates Template','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapseFourteen_case_report" class="panel-collapse collapse">
								<div class="panel-body">
									<form  class="form-horizontal" method="post" action="" name="weekly_report_form">
										<div class="form-group">
											<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
											<div class="col-md-8">
												<input class="form-control validate[required]" name="lmgt_weekly_case_report_email_subject"  placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_weekly_case_report_email_subject')); ?>">	
											</div>
										</div>
										<div class="form-group">
											<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
											<div class="col-md-8">
												<textarea name="lmgt_weekly_case_report_email_template" class="form-control validate[required] min_height_200_px_css"><?php print esc_html(get_option('lmgt_weekly_case_report_email_template')); ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<div class="offset-sm-3 col-md-8">
												<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>								
												<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>
												<label><strong>{{User Name}}</strong> <?php esc_html_e('User Name','lawyer_mgt'); ?></label><br>
												<label><strong>{{Case Name}}</strong> <?php esc_html_e('Case Name','lawyer_mgt'); ?></label><br>
												<label><strong>{{Case Number}}</strong> <?php esc_html_e('Case Number','lawyer_mgt'); ?></label><br>
											</div>
										</div>
										<div class="offset-sm-3 col-sm-8">        	
											<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="weekly_case_report_template" class="btn btn-success" type="submit">
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
							  <h4 class="panel-title">
								<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsefour_hearing_date">
								  <?php esc_html_e('Next Hearing Date Template','lawyer_mgt'); ?>
								</a>
							  </h4>
							</div>
							<div id="collapsefour_hearing_date" class="panel-collapse collapse">
							  <div class="panel-body">
								<form  class="form-horizontal" method="post" action="" name="parent_form">

									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Subject','lawyer_mgt');?> </label>
										<div class="col-md-8">
											<input class="form-control validate[required]" name="lmgt_next_hearing_date_email_subject" id="next_hearing_date_email_subject" placeholder="<?php esc_html_e('Enter email subject','lawyer_mgt');?>" value="<?php print esc_html(get_option('lmgt_next_hearing_date_email_subject')); ?>">	
										</div>
									</div>
									<div class="form-group">
										<label for="first_name" class="col-sm-3 control-label"><?php esc_html_e('Email Template','lawyer_mgt'); ?> </label>
										<div class="col-md-8">
											<textarea  name="lmgt_next_hearing_date_email_template" class="form-control validate[required] min_height_200px"><?php print esc_html(get_option('lmgt_next_hearing_date_email_template')); ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<div class="offset-sm-3 col-md-8">
											<label><?php esc_html_e('You can use following variables in the email template:','lawyer_mgt');?></label><br>								
											<label><strong>{{Lawyer System Name}}</strong> <?php esc_html_e('Lawyer System Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{User Name}}</strong> <?php esc_html_e('User Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Case Name}}</strong> <?php esc_html_e('Case Name','lawyer_mgt'); ?></label><br>
											<label><strong>{{Case Number}}</strong> <?php esc_html_e('Case Number','lawyer_mgt'); ?></label><br>
											<label><strong>{{Next Hearing Date}}</strong> <?php esc_html_e('Next Hearing Date','lawyer_mgt'); ?></label><br>
										</div>
									</div>
									<div class="offset-sm-3 col-sm-8">        	
										<input value="<?php esc_attr_e('Save','lawyer_mgt'); ?>" name="next_hearing_date_template" class="btn btn-success" type="submit">
									</div>
								</form>
							  </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- END  MAIN WRAPER  DIV -->
</div><!-- END  INNER PAGE  DIV -->
</div>