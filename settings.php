<?php
  
if ( !function_exists( 'add_action' ) ) {
	//echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
     echo esc_html__('Hi there!  I\'m just a plugin, not much I can do when called directly.','lawyer_mgt');
	exit;
}
// INCLUDE ALL CLASS FILES
require_once LAWMS_PLUGIN_DIR. '/lawmgt_function.php';
require_once LAWMS_PLUGIN_DIR. '/class/user.php';
require_once LAWMS_PLUGIN_DIR. '/class/group.php';
require_once LAWMS_PLUGIN_DIR. '/class/practicearea.php';
require_once LAWMS_PLUGIN_DIR. '/class/case.php';
require_once LAWMS_PLUGIN_DIR. '/class/court.php';
require_once LAWMS_PLUGIN_DIR. '/class/case_task.php';
require_once LAWMS_PLUGIN_DIR. '/class/causelist.php';
require_once LAWMS_PLUGIN_DIR. '/class/note.php';
require_once LAWMS_PLUGIN_DIR. '/class/rules.php';
require_once LAWMS_PLUGIN_DIR. '/class/event.php';
require_once LAWMS_PLUGIN_DIR. '/class/documents.php';
require_once LAWMS_PLUGIN_DIR. '/class/custome_field.php';
require_once LAWMS_PLUGIN_DIR. '/class/invoice.php';
require_once LAWMS_PLUGIN_DIR. '/class/judgments.php';
require_once LAWMS_PLUGIN_DIR. '/class/workflow.php';
require_once LAWMS_PLUGIN_DIR. '/class/case_workflow.php';
require_once LAWMS_PLUGIN_DIR. '/class/message.php';
require_once LAWMS_PLUGIN_DIR. '/class/orders.php';
//require_once LAWMS_PLUGIN_DIR. '/lib/paypal/paypal_class.php';
MJ_lawmgt_logs_file();
//PLUGIN INSTALLATION CODE
if (is_admin())
{
	require_once LAWMS_PLUGIN_DIR. '/admin/admin.php';
	function MJ_lawmgt_lawyers_install()
	{	
		add_role('attorney', esc_html__( 'Attorney' ,'lawyer_mgt'),array( 'read' => true, 'level_1' => true ));
		add_role('staff_member', esc_html__( 'Staff Member' ,'lawyer_mgt'),array( 'read' => true, 'level_1' => true ));
		add_role('client', esc_html__( 'Client' ,'lawyer_mgt'),array( 'read' => true, 'level_0' => true ));
		add_role('accountant', esc_html__( 'Accountant' ,'lawyer_mgt'),array( 'read' => true, 'level_1' => true ));		
		MJ_lawmgt_install_tables();	
	}
	register_activation_hook(LAWMS_PLUGIN_BASENAME, 'MJ_lawmgt_lawyers_install' );			
}
//<--   CALL SCRIPT PAGE CODE FUNCTION --> //
function MJ_lawmgt_lawyers_call_script_page()
{
	$page_array = array('lmgt_system','attorney','staff','client','accountant','contacts','court','cases','event','note','task','workflow','documents','invoice','orders','judgments','causelist','rules','custom_field','report','audit_log','message','access_right','mail_template','lmgt_gnrl_setting','lmgt_setup');
	return  $page_array;
}
//TABLES 
function MJ_lawmgt_install_tables()
{	
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				 
			$table_cases = $wpdb->prefix .'lmgt_cases';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_cases." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,
				  `user_id` int(11),
				  `case_name` varchar(255) NOT NULL,
				  `case_number`  varchar(255) NOT NULL,
				  `court_id` int(11) NOT NULL,
				  `state_id` int(11) NOT NULL,				  
				  `bench_id` int(11) NOT NULL,
				  `court_hall_no` int(11),				  
				  `floor` int(11),				  
				  `earlier_history` varchar(255),
				   `classification` varchar(255),
				  `stages` varchar(500),
				  `first_hearing_date` date, 
				  `case_assgined_to` varchar(255) NOT NULL,
				  `open_date` date,
				  `close_date` date,
				  `priority` varchar(255),
				  `practice_area_id` int(11),
				  `referred_by` varchar(255),
				  `statute_of_limitations` date,
				  `case_description` text,
				  `crime_no` varchar(255),
				  `crime_details` varchar(255),
				  `fri_no` varchar(255),
				  `billing_contact_id` int(11),
				  `billing_type` varchar(255),
				  `case_status` varchar(255),					
				  `custom_fileld_value` varchar(255),					
				  `added_on` text,
				  `opponents_details` text,
				  `opponents_attorney_details` text,
				  `created_date` datetime,
				  `updated_date` datetime,
				  `created_by` int(11) ,				  
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);			
			
			$table_court = $wpdb->prefix . 'lmgt_court';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_court ." (
				 `c_id` int(11) NOT NULL AUTO_INCREMENT,
				  `court_id` int(11) NOT NULL,
				  `state_id` int(11) NOT NULL,				  
				  `bench_id` varchar(255) NOT NULL,	
				  `court_details` varchar(255),	
				  `created_date` date ,
				  `created_by` int(11) ,
				  `updated_by` int(11) ,
				  `deleted_status` boolean NOT NULL,
				  PRIMARY KEY (`c_id`)
				) DEFAULT CHARSET=utf8";	
			$wpdb->query($sql);
			 
			$table_case_contacts = $wpdb->prefix .'lmgt_case_contacts';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_case_contacts." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,
				  `case_id` int(11),
				  `company_id` int(11),
				  `user_id` int(11),
				  `created_date` date,
				  `updated_date` date,					  
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);
			
			$table_case_staff_users = $wpdb->prefix .'lmgt_case_staff_users';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_case_staff_users." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,
				  `case_id` int(11),
				  `user_id` int(11),
				  `fee` Double,
				  `created_date` date,
				  `updated_date` date,			
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);
			
			$table_case_reminder = $wpdb->prefix .'lmgt_case_reminder';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_case_reminder." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,
				  `case_id` int(11),
				  `user_id` int(11),
				  `statute_of_limitations` date,				 					
				  `reminder_type` varchar(255),				 					
				  `reminder_time_value` int(11),				 					
				  `reminder_time_format` varchar(255),				 
				  `created_date` date,
				  `updated_date` date,					  
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);
			
			$table_event_reminder = $wpdb->prefix .'lmgt_event_reminder';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_event_reminder." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,
				  `event_id` int(11),
				   `case_id` int(11),
				  `user_id` int(11),
				  `start_date` date,				 					
				  `reminder_type` varchar(255),				 					
				  `reminder_time_value` int(11),				 					
				  `reminder_time_format` varchar(255),				
				  `created_date` date,
				  `updated_date` date,					  
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);
			
			$table_add_event = $wpdb->prefix .'lmgt_add_event';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_add_event." (
				 `event_id` int(11) NOT NULL AUTO_INCREMENT,	
                 `case_id` int(11) NOT NULL,
				 `practice_area_id` int(11),					  
				 `event_name` varchar(255),
				 `start_date` date NOT NULL,
				 `end_date` date NOT NULL,
				 `start_time` varchar(50),
				 `end_time` varchar(50),
				`description` varchar(255),
				`address` varchar(255) NOT NULL,
				`state_name` varchar(255) NOT NULL,
				`city_name` varchar(255) NOT NULL,
				`pin_code` int(11) NOT NULL,
				`priority` int(11),
				`repeat` int(11),
				`assigned_to_user` varchar(255),
				`assign_to_attorney` varchar(255),
				`created_date` date,
				 `updated_date` date,
				 `created_by` int(11) ,	
				  PRIMARY KEY (`event_id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);			
			
			$table_add_note = $wpdb->prefix .'lmgt_add_note';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_add_note." (
				 `note_id` int(11) NOT NULL AUTO_INCREMENT,	
                 `case_id` int(11) NOT NULL,
				 `assigned_to_user` varchar(255) NOT NULL,	
				 `assign_to_attorney` varchar(255),				 
				 `practice_area_id` int(11),
				 `note_name` varchar(255),
				 `note` varchar(255),
				 `date_time` date,
				 `created_date` date,
				 `updated_date` date,	
				 `created_by` int(11) ,	
				  PRIMARY KEY (`note_id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);
			
			$table_workflows= $wpdb->prefix .'lmgt_workflows';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_workflows." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,		
				 `name` varchar(255),	
				  `description` varchar(255),			 	 
				  `permission` varchar(255),
				  `assgined_to` varchar(255),
				  `created_by` varchar(255),
				  `created_date` date,
				  `updated_date` date,	
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);	

			$table_workflow_events_tasks = $wpdb->prefix .'lmgt_workflow_events_tasks';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_workflow_events_tasks." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,		
				 `workflow_id` int(11),	
				  `subject` varchar(255),			 	 
				  `description` varchar(255),
				  `type` varchar(255),
				  `due_date` varchar(255),
				  `event_date` date,
				  `created_date` date,
				  `updated_date` date,	
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);			

			$case_workflow_events_tasks = $wpdb->prefix .'lmgt_case_workflow_events_tasks';
			$sql = "CREATE TABLE IF NOT EXISTS ".$case_workflow_events_tasks." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,		
				 `case_id` int(11),		
				 `workflow_id` int(11),	
				  `subject` varchar(255),	 	 
				  `type` varchar(255),
				  `event_date` date,
				  `due_date` varchar(255),
				  `attendees` varchar(255),
				  `assign_to` varchar(255),
				  `created_date` date,
				  `updated_date` date,	
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);
			
			$user_activity = $wpdb->prefix .'lmgt_user_activity';
			$sql = "CREATE TABLE IF NOT EXISTS ".$user_activity." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,
				  `activity` varchar(255),
				  `user_id` int(11),
				  `created_date` date,				  
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);	
			
			$table_lmgt_message = $wpdb->prefix . 'lmgt_message';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_lmgt_message." (
			`message_id` int(11) NOT NULL AUTO_INCREMENT,
			  `sender` varchar(100) NOT NULL,
			  `receiver` varchar(100) NOT NULL,
			  `msg_date` date NOT NULL,
			  `msg_subject` varchar(100) NOT NULL,
			  `message_body` text NOT NULL,
			  `msg_status` tinyint(4) NOT NULL,
			  `post_id` int(11) NOT NULL,
			  PRIMARY KEY (`message_id`)
			) DEFAULT CHARSET=utf8";	
			$wpdb->query($sql);	
			
			$table_lmgt_message_replies = $wpdb->prefix . 'lmgt_message_replies';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_lmgt_message_replies." (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `message_id` int(11) NOT NULL,
			  `sender_id` int(11) NOT NULL,
			  `receiver_id` int(11) NOT NULL,
			  `message_comment` text NOT NULL,
			  `created_date` datetime,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";	
			$wpdb->query($sql);	
			 
			$table_lmgt_judgments = $wpdb->prefix . 'lmgt_judgments';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_lmgt_judgments." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,		
				  `date` date,
				  `case_id` int(11) NOT NULL,		
				  `judge_name` varchar(255) NOT NULL,	
				  `judgments_details` text,	 
				  `judgments_document` varchar(255),
				  `judgments_law_details` text,	 
				  `created_date` date,
				  `created_by` int(11),
				  `updated_date` date,	
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);	 
			
			$table_lmgt_orders = $wpdb->prefix . 'lmgt_orders';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_lmgt_orders." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,
				 `date` date,
				  `case_id` int(11) NOT NULL,		
				  `judge_name` varchar(255) NOT NULL,	
				  `orders_details` text,	 
				  `orders_document` text,
			   	  `next_hearing_date` date NOT NULL, 
				  `purpose_of_hearing` varchar(255),
				  `created_date` date,
				  `created_by` int(11),	
				  `updated_date` date,
				  `deleted_status` boolean NOT NULL,
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);	
			
			$table_lmgt_alert_mail_log = $wpdb->prefix . 'lmgt_alert_mail_log';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_lmgt_alert_mail_log." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,		
				  `case_id` int(11) NOT NULL,
				  `next_hearing_date` date NOT NULL,
				  `alert_date` date,
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);	

			$table_add_rules = $wpdb->prefix .'lmgt_add_rules';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_add_rules." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,	
				 `rule_name` varchar(255) NOT NULL,
				 `description` varchar(255),
				 `document_url` varchar(255),
				 `created_by` int(11) ,
				 `updated_by` int(11) ,
				 `created_date` date,
				 `updated_date` date,
				 `deleted_status` boolean NOT NULL,
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);
			
			$table_taxes = $wpdb->prefix .'lmgt_taxes';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_taxes." (
				 `tax_id` int(11) NOT NULL AUTO_INCREMENT,	
				 `tax_title` varchar(255) NOT NULL,
				 `tax_value` double NOT NULL,
			     `created_date` date NOT NULL,
				 `created_by` int(11) ,
				 `updated_date` date,
				 `updated_by` int(11) ,
				  `deleted_status` boolean NOT NULL,
				  PRIMARY KEY (`tax_id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);
			
			
			//Paid Table//
			
			$table_documents = $wpdb->prefix .'lmgt_documents';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_documents." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,
				 `case_id` int(11),
				  `title` varchar(255),
				  `document_url` varchar(255),
				  `type` varchar(255),				 					
				  `tag_names` varchar(255),				 					
				  `permission` varchar(255),
				  `document_description` varchar(255),
				  `status` varchar(255),
				  `last_update` varchar(255),
				   `created_date` date,
					`updated_date` date,
				   `created_by` int(11) ,
				    `updated_by` int(11),
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);
			
			$table_task = $wpdb->prefix .'lmgt_add_task';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_task." (
				 `task_id` int(11) NOT NULL AUTO_INCREMENT,	
                 `case_id` int(11) NOT NULL,
				 `practice_area_id` varchar(255),					  
				 `task_name` varchar(255) NOT NULL,
				 `due_date` date NOT NULL,
				`status` int(11) NOT NULL,
				`description` varchar(255),
				`priority` int(11),
				`repeat` int(11),
				`repeat_until` date,
				`assigned_to_user` varchar(255),
				`assign_to_attorney` varchar(255),
				`created_date` date,
				 `updated_date` date,
				 `created_by` int(11) ,				 
				  PRIMARY KEY (`task_id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);
			
			$table_task_reminder = $wpdb->prefix .'lmgt_task_reminder';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_task_reminder." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,
				  `task_id` int(11),
				  `case_id` int(11),
				  `user_id` int(11),
				  `due_date` date,				 					
				  `reminder_type` varchar(255),				 					
				  `reminder_time_value` int(11),				 					
				  `reminder_time_format` varchar(255),				 
				  `created_date` date,
				  `updated_date` date,					  
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);
			
			
			$table_invoice= $wpdb->prefix .'lmgt_invoice';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_invoice." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,				 
				 `user_id` int(11) NOT NULL,				 
				 `case_id` int(11) NOT NULL,				 
				 `invoice_number` varchar(10) NOT NULL,				 
				 `generated_date` date,							 
				 `due_date` date,
				 `note` varchar(255),		
				 `terms` varchar(255),
				 `total_amount` double,		
				 `paid_amount` double,		
				 `due_amount` double,		
				 `payment_by` varchar(255),		
				 `payment_status` varchar(255),		
				  `created_date` date,
				  `updated_date` date,
				  `created_by` int(11) ,		
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);		
			
			$table_invoice_time_entries= $wpdb->prefix .'lmgt_invoice_time_entries';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_invoice_time_entries." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,				 
				 `invoice_id` int(11),
				 `user_id` int(11) NOT NULL,				 
				 `case_id` int(11) NOT NULL,
				 `time_entry` varchar(255),				 
				 `description` varchar(255),				 
				 `time_entry_date` date,				 
				 `billed_by` varchar(255),							 
				  `hours` double,		  
				  `rate` double,		  
				  `subtotal` double,		  
				  `time_entry_tax` varchar(255),		  
				  `time_entry_discount` double,
				  `total_tax_amount` double,	
				  `created_date` date,
				  `updated_date` date,				 
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);				
			
			$table_invoice_expenses= $wpdb->prefix .'lmgt_invoice_expenses';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_invoice_expenses." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,				 
				 `invoice_id` int(11),
				 `user_id` int(11) NOT NULL,				 
				 `case_id` int(11) NOT NULL,
				 `expense` varchar(255),				 
				 `description` varchar(255),				 
				 `expense_date` date,				 
				 `billed_by` varchar(255),							 
				  `quantity` double,		  
				  `price` double,		  
				  `subtotal` double,		  
				  `expenses_entry_tax` varchar(255),	  
				  `expenses_entry_discount` double,
				  `total_tax_amount` double,
				  `created_date` date,
				  `updated_date` date,				 
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);	

			
			$table_invoice_flat_fee= $wpdb->prefix .'lmgt_invoice_flat_fee';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_invoice_flat_fee." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,				 
				 `invoice_id` int(11),
				 `user_id` int(11) NOT NULL,				 
				 `case_id` int(11) NOT NULL,
				 `flat_fee` varchar(255),				 
				 `description` varchar(255),				 
				 `flat_fee_date` date,				 
				 `billed_by` varchar(255),							 
				  `quantity` double,		  
				  `price` double,		  
				  `subtotal` double,		  
				  `flat_entry_tax` varchar(255),	  
				  `flat_entry_discount` double,
				  `total_tax_amount` double,	  
				  `created_date` date,
				  `updated_date` date,				 
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);		
			
			$table_invoice_payment_history= $wpdb->prefix .'lmgt_invoice_payment_history';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_invoice_payment_history." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,		
				 `invoice_id` int(11),	
				  `date` date,	
				 `amount` double,				 
				 `payment_method` varchar(255),				 	 
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			$wpdb->query($sql);	
			
}



//<--  ADMIN SIDE CSS AND JAVASCRIPT CALL FUNCTION --> //
function MJ_lawmgt_lawyers_change_adminbar_css($hook) 
{	
	if(isset($_REQUEST['page']))
	{
		$current_page = sanitize_text_field($_REQUEST['page']);
	}
	else
	{
		$current_page ='';
	}
	$page_array = MJ_lawmgt_lawyers_call_script_page();
	
	if(in_array($current_page,$page_array))
	{
		$lancode=get_locale();
		$code=substr($lancode,0,2);
		wp_enqueue_style( 'mj-lawmgt-style-css', plugins_url( '/assets/css/style.css', __FILE__) );
		wp_enqueue_style( 'mj-lawmgt-popup-css', plugins_url( '/assets/css/mj-lawmgt-popup.css', __FILE__) );
		wp_enqueue_style( 'mj-lawmgt-custom-style-css', plugins_url( '/assets/css/mj-lawmgt-custom-style.css', __FILE__) );
		wp_enqueue_style( 'select2-css', plugins_url( '/lib/select2-3.5.3/select2.css', __FILE__) );
		wp_enqueue_script('select2-js', plugins_url( '/lib/select2-3.5.3/select2-default.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
		//data export to csv
		wp_enqueue_script('export-csv-js', plugins_url( '/assets/js/export-csv.js', __FILE__ ) );
		wp_enqueue_media();					
		wp_enqueue_script('mj-lawmgt-image-upload-js', plugins_url( '/assets/js/mj-lawmgt-image-upload.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );

		
		 wp_enqueue_style( 'bootstrap-css', plugins_url( '/assets/css/bootstrap.css', __FILE__) );
		
		wp_enqueue_style( 'bootstrap-css-font', plugins_url( '/assets/css/bootstrap-glyphicons.css', __FILE__) );
		wp_enqueue_style( 'bootstrap-multiselect-css', plugins_url( '/assets/css/bootstrap-multiselect.css', __FILE__) );
		wp_enqueue_style( 'font-awesome-min-css', plugins_url( '/assets/css/font-awesome-min.css', __FILE__) );
		wp_enqueue_style( 'white-css', plugins_url( '/assets/css/white.css', __FILE__) );
		wp_enqueue_style( 'mj-lawmgt-css', plugins_url( '/assets/css/lmgt.css', __FILE__) );
		wp_enqueue_style( 'mj-lawmgt-responsive-css', plugins_url( '/assets/css/mj-lawmgt-responsive.css', __FILE__) );
		
		wp_enqueue_script('popper', plugins_url( '/assets/js/popper.js', __FILE__ ) );
		wp_enqueue_script('bootstrap-js', plugins_url( '/assets/js/bootstrap.js', __FILE__ ) );
		wp_enqueue_script('bootstrap-multiselect-js', plugins_url( '/assets/js/bootstrap-multiselect.js', __FILE__ ) );
		wp_enqueue_script('mj-lawmgt-js', plugins_url( '/assets/js/modernizr.js', __FILE__ ) );
		if (is_rtl())
		{			
			wp_enqueue_style( 'bootstrap-rtl-css', plugins_url( '/assets/css/bootstrap-rtl.css', __FILE__) );
			wp_enqueue_script('mj-lawmgt-validationEngine-'.$code.'.-js', plugins_url( '/assets/js/jquery-validationEngine-'.$code.'.js', __FILE__ ) );
			wp_enqueue_style('mj-lawmgt-admin-side-rtl-custom-css', plugins_url( '/assets/css/mj-lawmgt-admin-side-rtl-custom-css.css', __FILE__ ) );
		}
		wp_enqueue_script('mj-lawmgt-calender-'.$code.'', plugins_url( '/assets/js/calendar-lang/'.$code.'.js', __FILE__ ), array( 'jquery' ), '4.1.1', true );
		//popup//
		wp_enqueue_script('mj-lawmgt-popup', plugins_url( '/assets/js/mj-lawmgt-popup.js', __FILE__ ), array( 'jquery' ), '4.1.1', false );
		
		//popup file alert msg languages translation//				
		wp_localize_script('mj-lawmgt-popup', 'language_translate', array(
				'group_name_popup' => esc_html__( 'Please enter Group Name.','lawyer_mgt'),
				'name_popup' => esc_html__( 'Please enter Name.', 'lawyer_mgt' ),
				'enter_category_alert' => esc_html__( 'Please enter Category Name.', 'lawyer_mgt' ),
				'enter_court_category_alert' => esc_html__( 'Please enter Court Name.', 'lawyer_mgt' ),
				'enter_state_category_alert' => esc_html__( 'Please enter State Name.', 'lawyer_mgt' ),
				'enter_bench_category_alert' => esc_html__( 'Please enter Bench Name.', 'lawyer_mgt' ),
				'practice_area_popup' => esc_html__( 'Please enter Practice Area.', 'lawyer_mgt' ),
				'tag_name_popup' => esc_html__( 'Please Enter Tag name...', 'lawyer_mgt' ),
				'tag_duplicate_popup' => esc_html__( 'Duplicate Tags', 'lawyer_mgt' ),
				'select_date_popup' => esc_html__( 'Please select date.', 'lawyer_mgt' ),
				'workflow_popup' => esc_html__( 'This Workflow already applyed to this case you can apply this workflow then first delete it and after apply this workflow', 'lawyer_mgt' ),
				
			)
		);
		wp_localize_script( 'mj-lawmgt-popup', 'lmgt', array( 'ajax' => admin_url( 'admin-ajax.php' ) ), __FILE__ );
		//Validation style And Script
		//validation lib
		wp_enqueue_style( 'validate-css', plugins_url( '/lib/validationEngine/css/validationEngine-jquery.css', __FILE__) );	 	
		wp_register_script( 'jquery-validationEngine-'.$code.'', plugins_url( '/lib/validationEngine/js/languages/jquery-validationEngine-'.$code.'.js', __FILE__), array( 'jquery' ) );
		wp_enqueue_script( 'jquery-validationEngine-'.$code.'' );
		wp_register_script( 'jquery-validationEngine', plugins_url( '/lib/validationEngine/js/jquery-validationEngine.js', __FILE__), array( 'jquery' ) );
		wp_enqueue_script( 'jquery-validationEngine' );
		
		// Template CSS & JS		
		wp_enqueue_style( 'nprogress-css', plugins_url( '/assets/css/nprogress.css', __FILE__) );	 	
		wp_enqueue_style( 'green-css', plugins_url( '/assets/css/green.css', __FILE__) );	 	
		wp_enqueue_style( 'dataTables-bootstrap-css', plugins_url( '/assets/css/dataTables-bootstrap.css', __FILE__) );	 	
		wp_enqueue_style( 'dataTables-responsive-css', plugins_url( '/assets/css/dataTables-responsive.css', __FILE__) );	 	
		wp_enqueue_style( 'buttons-bootstrap-css', plugins_url( '/assets/css/buttons-bootstrap.css', __FILE__) );	 	
		wp_enqueue_style( 'fixedHeader-bootstrap-css', plugins_url( '/assets/css/fixedHeader-bootstrap.css', __FILE__) );	 	
		wp_enqueue_style( 'responsive-bootstrap-css', plugins_url( '/assets/css/responsive-bootstrap.css', __FILE__) );	 	
		wp_enqueue_style( 'scroller-bootstrap-css', plugins_url( '/assets/css/scroller-bootstrap.css', __FILE__) );	 	
		wp_enqueue_style( 'bootstrap-progressbar-css', plugins_url( '/assets/css/bootstrap-progressbar.css', __FILE__) );	 	
		wp_enqueue_style( 'jqvmap-css', plugins_url( '/assets/css/jqvmap.css', __FILE__) );	 	
		wp_enqueue_style( 'timepicker-css', plugins_url( '/assets/css/bootstrap-timepicker.css', __FILE__) );		 	 	
		wp_enqueue_style( 'datepicker-css', plugins_url( '/assets/css/datepicker.css', __FILE__) );	 	
		wp_enqueue_style( 'datepicker-default-css', plugins_url( '/assets/css/datepicker-default-css.css', __FILE__) );	 	
		wp_enqueue_style( 'custom-css', plugins_url( '/assets/css/custom.css', __FILE__) );	 	
		wp_enqueue_style( 'fullcalendar', plugins_url( '/assets/css/fullcalendar.css', __FILE__) );	 	
		
		wp_enqueue_script('fastclick-js', plugins_url( '/assets/js/fastclick.js', __FILE__ ) );
		wp_enqueue_script('nprogress', plugins_url( '/assets/js/nprogress.js', __FILE__ ) );
		wp_enqueue_script('Chart-js', plugins_url( '/assets/js/Chart.js', __FILE__ ) );
		wp_enqueue_script('gauge-js', plugins_url( '/assets/js/gauge.js', __FILE__ ) );
		wp_enqueue_script('bootstrap-progressbar-js', plugins_url( '/assets/js/bootstrap-progressbar.js', __FILE__ ) );
		wp_enqueue_script('icheck-js', plugins_url( '/assets/js/icheck.js', __FILE__ ) );
		wp_enqueue_script('jquery-dataTables-js', plugins_url( '/assets/js/jquery-dataTables.js',__FILE__ ) );
		wp_enqueue_script('dataTables-editor', plugins_url( '/assets/js/dataTables-editor.js',__FILE__ ) );
		wp_enqueue_script('dataTables-tableTools', plugins_url( '/assets/js/dataTables-tableTools.js',__FILE__ ) );
		wp_enqueue_script('dataTables-bootstrap', plugins_url( '/assets/js/dataTables-bootstrap.js',__FILE__ ) );
		wp_enqueue_script('dataTables-responsive', plugins_url( '/assets/js/dataTables-responsive.js',__FILE__ ) );
		wp_enqueue_script('dataTables-buttons', plugins_url( '/assets/js/dataTables-buttons.js',__FILE__ ) );
		wp_enqueue_script('buttons-bootstrap', plugins_url( '/assets/js/buttons-bootstrap.js',__FILE__ ) );
		wp_enqueue_script('dataTables-select', plugins_url( '/assets/js/dataTables-select.js',__FILE__ ) );
		wp_enqueue_script('pdfmake-js', plugins_url( '/assets/js/pdfmake.js',__FILE__ ) );
		wp_enqueue_script('vfs_fonts-js', plugins_url( '/assets/js/vfs-fonts.js',__FILE__ ) );
		wp_enqueue_script('jszip-js', plugins_url( '/assets/js/jszip.js',__FILE__ ) );
		wp_enqueue_script('buttons-html5-js', plugins_url( '/assets/js/buttons-html5.js', __FILE__ ) );
		wp_enqueue_script('skycons-js', plugins_url( '/assets/js/skycons.js', __FILE__ ) );
		
		wp_enqueue_script('jquery-flot-js', plugins_url( '/assets/js/jquery-flot.js', __FILE__ ) );
		wp_enqueue_script('jquery-flot-pie-js', plugins_url( '/assets/js/jquery-flot-pie.js', __FILE__ ) );
	
		wp_enqueue_script('jquery-flot-time-js', plugins_url( '/assets/js/jquery-flot-time.js', __FILE__ ) );
		wp_enqueue_script('jquery-flot-stack-js', plugins_url( '/assets/js/jquery-flot-stack.js', __FILE__ ) );
		wp_enqueue_script('jquery-flot-resize-js', plugins_url( '/assets/js/jquery-flot-resize.js', __FILE__ ) );
		wp_enqueue_script('jquery-flot-orderBars-js', plugins_url( '/assets/js/jquery-flot-orderBars.js', __FILE__ ) );
		wp_enqueue_script('jquery-flot-spline-js', plugins_url( '/assets/js/jquery-flot-spline.js', __FILE__ ) );
		wp_enqueue_script('curvedLines-js', plugins_url( '/assets/js/curvedLines.js', __FILE__ ) );
		wp_enqueue_script('jquerydate-js', plugins_url( '/assets/js/date.js', __FILE__ ) );
		wp_enqueue_script('jquery-vmap-js', plugins_url( '/assets/js/jquery-vmap.js', __FILE__ ) );
		wp_enqueue_script('jquery-vmap-world-js', plugins_url( '/assets/js/jquery-vmap-world.js', __FILE__ ) );
		wp_enqueue_script('jquery-vmap-sampledata-js', plugins_url( '/assets/js/jquery-vmap-sampledata.js', __FILE__ ) );
		wp_enqueue_script('bootstrap-datepicker-js', plugins_url( '/assets/js/bootstrap-datepicker.js', __FILE__ ) );
		wp_enqueue_script('bootstrap-timepicker-js', plugins_url( '/assets/js/bootstrap-timepicker.js', __FILE__ ) );
		wp_enqueue_script('custom-js', plugins_url( '/assets/js/custom.js', __FILE__ ) );
		wp_enqueue_script('fullcalendar', plugins_url( '/assets/js/fullcalendar.js', __FILE__ ));	
		//INPUT TAG
		wp_enqueue_style('jquery-tagsinput-css', plugins_url( '/assets/css/jquery-tagsinput.css', __FILE__));
		wp_enqueue_script('jquery-tagsinput-js', plugins_url( '/assets/js/jquery-tagsinput.js', __FILE__ ));
		wp_enqueue_script('jquery-timeago-js', plugins_url( '/assets/js/jquery-timeago.js', __FILE__ ));
	 	
		wp_enqueue_style( 'Viewdetail-css', plugins_url( '/assets/css/Viewdetail.css', __FILE__) );
		wp_enqueue_style( 'mj-lawmgt-newversion', plugins_url( '/assets/css/newversion.css', __FILE__) );
		wp_enqueue_script('loader-js', plugins_url( '/assets/js/loader.js', __FILE__ ));
	}		
}
if(isset($_REQUEST['page']))
add_action( 'admin_enqueue_scripts', 'MJ_lawmgt_lawyers_change_adminbar_css' );

//<--  ADD OPTION FUNCTION --> //
function MJ_lawmgt_option()
{
		$role_access_right_attorney = array();
		$role_access_right_staff = array();
		$role_access_right_accountant = array();
		$role_access_right_contacts = array();

		$role_access_right_attorney['attorney'] =
		[
			"attorney"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/attorney.png' ),
		   "menu_title"=>'Attorney',
		   "page_link"=>'attorney',
		   "own_data" =>'1',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"staff"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/staff.png' ),
		   "menu_title"=>'Staff',
		   "page_link"=>'staff',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
		  "accountant"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/account.png' ),
		   "menu_title"=>'Accountant',
		   "page_link"=>'accountant',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
		   "contacts"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/contact.png' ),
		   "menu_title"=>'Client',
		   "page_link"=>'contacts',
		   "own_data" =>'1',
		   "add" =>'1',
			"edit"=>'1',
			"view"=>'1',
			"delete"=>'1'
			],
			
			"court"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/Court-Module.png' ),
		   "menu_title"=>'Court',
		   "page_link"=>'court',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
		   "cases"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/case.png' ),
		   "menu_title"=>'Cases',
		   "page_link"=>'cases',
		   "own_data" =>'1',
		   "add" =>'1',
			"edit"=>'1',
			"view"=>'1',
			"delete"=>'1'
			],
			"orders"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/order-court.png' ),
		   "menu_title"=>'Orders',
		   "page_link"=>'orders',
		   "own_data" =>'1',
		   "add" =>'1',
			"edit"=>'1',
			"view"=>'1',
			"delete"=>'1'
			],
			
			"judgments"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/Judgement.png' ),
		   "menu_title"=>'Judgments',
		   "page_link"=>'judgments',
		   "own_data" =>'1',
		   "add" =>'1',
			"edit"=>'1',
			"view"=>'1',
			"delete"=>'1'
			],
			
			"causelist"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/cause_list.png' ),
		   "menu_title"=>'Cause List',
		   "page_link"=>'causelist',
		   "own_data" =>'1',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"task"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/task.png' ),
		   "menu_title"=>'Task',
		   "page_link"=>'task',
		   "own_data" =>'1',
		   "add" =>'1',
			"edit"=>'1',
			"view"=>'1',
			"delete"=>'1'
			],
			
			
			"event"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/event.png' ),
		   "menu_title"=>'Event',
		   "page_link"=>'event',
		   "own_data" =>'1',
		   "add" =>'1',
			"edit"=>'1',
			"view"=>'1',
			"delete"=>'1'
			],
			
			"note"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/note.png' ),
		   "menu_title"=>'Note',
		   "page_link"=>'note',
		   "own_data" =>'1',
		   "add" =>'1',
			"edit"=>'1',
			"view"=>'1',
			"delete"=>'1'
			],
			
			"workflow"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/work_flow.png' ),
		   "menu_title"=>'Workflow',
		   "page_link"=>'workflow',
		   "own_data" =>'1',
		   "add" =>'1',
			"edit"=>'1',
			"view"=>'1',
			"delete"=>'1'
			],
			
			"documents"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/document.png' ),
		   "menu_title"=>'Documents',
		   "page_link"=>'documents',
		   "own_data" =>'1',
		   "add" =>'1',
			"edit"=>'1',
			"view"=>'1',
			"delete"=>'1'
			],
			
			"invoice"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/invoice.png' ),
		   "menu_title"=>'Invoice',
		   "page_link"=>'invoice',
		   "own_data" =>'1',
		   "add" =>'1',
			"edit"=>'1',
			"view"=>'1',
			"delete"=>'1'
			],
			
			"rules"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/rules.png' ),
		   "menu_title"=>'Rules',
		   "page_link"=>'rules',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"report"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/report.png' ),
		   "menu_title"=>'Report',
		   "page_link"=>'report',
		   "own_data" =>'1',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"message"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/message.png' ),
		   "menu_title"=>'Message',
		   "page_link"=>'message',
		   "own_data" =>'1',
		   "add" =>'1',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'1'
			],
			"account"=>['menu_icone'=>plugins_url( 'lawyers-management/assets/images/icons/account1.png'),
												"menu_title"=>'Account',
												"page_link"=>'account',
												 "own_data" =>'1',
												 "add" =>'0',
												"edit"=>'1',
												"view"=>'1',
												"delete"=>'0'
									  ]
		];
		$role_access_right_staff['staff'] =
		[
			"attorney"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/attorney.png' ),
		   "menu_title"=>'Attorney',
		   "page_link"=>'attorney',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			 
			"staff"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/staff.png' ),
		   "menu_title"=>'Staff',
		   "page_link"=>'staff',
		   "own_data" =>'1',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
		  "accountant"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/account.png' ),
		   "menu_title"=>'Accountant',
		   "page_link"=>'accountant',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
		   "contacts"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/contact.png' ),
		   "menu_title"=>'Client',
		   "page_link"=>'contacts',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"court"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/Court-Module.png' ),
		   "menu_title"=>'Court',
		   "page_link"=>'court',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
		   "cases"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/case.png' ),
		   "menu_title"=>'Cases',
		   "page_link"=>'cases',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			"orders"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/order-court.png' ),
		   "menu_title"=>'Orders',
		   "page_link"=>'orders',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"judgments"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/Judgement.png' ),
		   "menu_title"=>'Judgments',
		   "page_link"=>'judgments',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"causelist"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/cause_list.png' ),
		   "menu_title"=>'Cause List',
		   "page_link"=>'causelist',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'0',
			"delete"=>'0'
			],
			
			"task"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/task.png' ),
		   "menu_title"=>'Task',
		   "page_link"=>'task',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			
			"event"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/event.png' ),
		   "menu_title"=>'Event',
		   "page_link"=>'event',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"note"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/note.png' ),
		   "menu_title"=>'Note',
		   "page_link"=>'note',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"workflow"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/work_flow.png' ),
		   "menu_title"=>'Workflow',
		   "page_link"=>'workflow',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'0',
			"delete"=>'0'
			],
			
			"documents"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/document.png' ),
		   "menu_title"=>'Documents',
		   "page_link"=>'documents',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"invoice"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/invoice.png' ),
		   "menu_title"=>'Invoice',
		   "page_link"=>'invoice',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'0',
			"delete"=>'0'
			],
			
			"rules"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/rules.png' ),
		   "menu_title"=>'Rules',
		   "page_link"=>'rules',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"report"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/report.png' ),
		   "menu_title"=>'Report',
		   "page_link"=>'report',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"message"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/message.png' ),
		   "menu_title"=>'Message',
		   "page_link"=>'message',
		   "own_data" =>'1',
		   "add" =>'1',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'1'
			],
			"account"=>['menu_icone'=>plugins_url( 'lawyers-management/assets/images/icons/account1.png'),
												"menu_title"=>'Account',
												"page_link"=>'account',
												 "own_data" =>'1',
												 "add" =>'0',
												"edit"=>'1',
												"view"=>'1',
												"delete"=>'0'
									  ]
		];
		$role_access_right_accountant['accountant'] =
		[
			"attorney"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/attorney.png' ),
		   "menu_title"=>'Attorney',
		   "page_link"=>'attorney',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"staff"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/staff.png' ),
		   "menu_title"=>'Staff',
		   "page_link"=>'staff',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
		  "accountant"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/account.png' ),
		   "menu_title"=>'Accountant',
		   "page_link"=>'accountant',
		   "own_data" =>'1',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
		   "contacts"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/contact.png' ),
		   "menu_title"=>'Client',
		   "page_link"=>'contacts',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"court"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/Court-Module.png' ),
		   "menu_title"=>'Court',
		   "page_link"=>'court',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
		   "cases"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/case.png' ),
		   "menu_title"=>'Cases',
		   "page_link"=>'cases',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			"orders"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/order-court.png' ),
		   "menu_title"=>'Orders',
		   "page_link"=>'orders',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'0',
			"delete"=>'0'
			],
			
			"judgments"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/Judgement.png' ),
		   "menu_title"=>'Judgments',
		   "page_link"=>'judgments',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'0',
			"delete"=>'0'
			],
			
			"causelist"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/cause_list.png' ),
		   "menu_title"=>'Cause List',
		   "page_link"=>'causelist',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'0',
			"delete"=>'0'
			],
			
			"task"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/task.png' ),
		   "menu_title"=>'Task',
		   "page_link"=>'task',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'0',
			"delete"=>'0'
			],
			
			
			"event"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/event.png' ),
		   "menu_title"=>'Event',
		   "page_link"=>'event',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'0',
			"delete"=>'0'
			],
			
			"note"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/note.png' ),
		   "menu_title"=>'Note',
		   "page_link"=>'note',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'0',
			"delete"=>'0'
			],
			
			"workflow"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/work_flow.png' ),
		   "menu_title"=>'Workflow',
		   "page_link"=>'workflow',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'0',
			"delete"=>'0'
			],
			
			"documents"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/document.png' ),
		   "menu_title"=>'Documents',
		   "page_link"=>'documents',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'0',
			"delete"=>'0'
			],
			
			"invoice"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/invoice.png' ),
		   "menu_title"=>'Invoice',
		   "page_link"=>'invoice',
		   "own_data" =>'1',
		   "add" =>'1',
			"edit"=>'1',
			"view"=>'1',
			"delete"=>'1'
			],
			
			"rules"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/rules.png' ),
		   "menu_title"=>'Rules',
		   "page_link"=>'rules',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"report"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/report.png' ),
		   "menu_title"=>'Report',
		   "page_link"=>'report',
		   "own_data" =>'1',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"message"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/message.png' ),
		   "menu_title"=>'Message',
		   "page_link"=>'message',
		   "own_data" =>'1',
		   "add" =>'1',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'1'
			],
			"account"=>['menu_icone'=>plugins_url( 'lawyers-management/assets/images/icons/account1.png'),
												"menu_title"=>'Account',
												"page_link"=>'account',
												 "own_data" =>'1',
												 "add" =>'0',
												"edit"=>'1',
												"view"=>'1',
												"delete"=>'0'
									  ]
		];
		$role_access_right_contacts['contacts'] =
		[
			"attorney"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/attorney.png' ),
		   "menu_title"=>'Attorney',
		   "page_link"=>'attorney',
		   "own_data" =>'1',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"staff"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/staff.png' ),
		   "menu_title"=>'Staff',
		   "page_link"=>'staff',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
		  "accountant"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/account.png' ),
		   "menu_title"=>'Accountant',
		   "page_link"=>'accountant',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
		   "contacts"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/contact.png' ),
		   "menu_title"=>'Client',
		   "page_link"=>'contacts',
		   "own_data" =>'1',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"court"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/Court-Module.png' ),
		   "menu_title"=>'Court',
		   "page_link"=>'court',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
		   "cases"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/case.png' ),
		   "menu_title"=>'Cases',
		   "page_link"=>'cases',
		   "own_data" =>'1',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			"orders"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/order-court.png' ),
		   "menu_title"=>'Orders',
		   "page_link"=>'orders',
		   "own_data" =>'1',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"judgments"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/Judgement.png' ),
		   "menu_title"=>'Judgments',
		   "page_link"=>'judgments',
		   "own_data" =>'1',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"causelist"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/cause_list.png' ),
		   "menu_title"=>'Cause List',
		   "page_link"=>'causelist',
		   "own_data" =>'1',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"task"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/task.png' ),
		   "menu_title"=>'Task',
		   "page_link"=>'task',
		   "own_data" =>'1',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			
			"event"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/event.png' ),
		   "menu_title"=>'Event',
		   "page_link"=>'event',
		   "own_data" =>'1',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"note"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/note.png' ),
		   "menu_title"=>'Note',
		   "page_link"=>'note',
		   "own_data" =>'1',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"workflow"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/work_flow.png' ),
		   "menu_title"=>'Workflow',
		   "page_link"=>'workflow',
		   "own_data" =>'1',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"documents"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/document.png' ),
		   "menu_title"=>'Documents',
		   "page_link"=>'documents',
		   "own_data" =>'1',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"invoice"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/invoice.png' ),
		   "menu_title"=>'Invoice',
		   "page_link"=>'invoice',
		   "own_data" =>'1',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"rules"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/rules.png' ),
		   "menu_title"=>'Rules',
		   "page_link"=>'rules',
		   "own_data" =>'0',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"report"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/report.png' ),
		   "menu_title"=>'Report',
		   "page_link"=>'report',
		   "own_data" =>'1',
		   "add" =>'0',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'0'
			],
			
			"message"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/message.png' ),
		   "menu_title"=>'Message',
		   "page_link"=>'message',
		   "own_data" =>'1',
		   "add" =>'1',
			"edit"=>'0',
			"view"=>'1',
			"delete"=>'1'
			],
			"account"=>['menu_icone'=>plugins_url( 'lawyers-management/assets/images/icons/account1.png'),
												"menu_title"=>'Account',
												"page_link"=>'account',
												 "own_data" =>'1',
												 "add" => '0',
												"edit"=>'1',
												"view"=>'1',
												"delete"=>'0'
									  ]
		];
		$options=array("lmgt_system_name"=>"Law Practice Management Software",
					"lmgt_fevicon"=>plugins_url('lawyers-management/assets/images/logo/logo.png'),
					"lmgt_staring_year"=>"2019",
					"lmgt_address"=>"Sapathhexa,S.G.Highway,Ahmedabad",
					"lmgt_contact_number"=>"9999999999",					
					"lmgt_currency_code"=>'INR',
					"lmgt_email"=>get_option('admin_email'),
					"lawyer_enable_sandbox"=>'yes',
					"lmgt_contry"=>"India",
					"lmgt_paypal_email"=>get_option('admin_email'),
					"lmgt_datepicker_format"=>'yy/mm/dd',
					"lmgt_system_logo"=>plugins_url( 'lawyers-management/assets/images/logo/logo.png' ),
					"lmgt_cover_image"=>plugins_url( 'lawyers-management/assets/images/background.jpg' ),
					"lmgt_gst_number" => '',
					"lmgt_tax_id" => '',
					"lmgt_corporate_id" => '',
					"lmgt_bank_name" => '',
					"lmgt_account_holder_name" => '',
					"lmgt_account_number" => '',
					"lmgt_account_type" => '',
					"lmgt_ifsc_code" => '',					
					"lmgt_swift_code" => '',
					"lmgt_enable_case_hearing_date_remainder" => 'yes',
					"lmgt_case_hearing_date_remainder" => '3',
					"lmgt_default_court" => '',
					"lmgt_case_columns_option" => 'case_name,case_number,open_date,practice_area,court_details,contact_link,billing_contact_name,attorney_name,hearing_date',
					"lmgt_case_export_option" => 'case_name,case_number,open_date,practice_area,court_details,contact_link,billing_contact_name,attorney_name,hearing_date',
					"lmgt_contact_columns_option" => 'photo,contact_name,company_name,contact_email,contact_case_link,address',
					"lmgt_document_columns_option" => 'document_title,document_type,document_case_link,tag_name,status,last_updated',
					"document_export_option" => 'document_title,document_type,document_case_link,tag_name,status,last_updated',
					"lmgt_invoice_columns_option" => 'invoice_number,invoice_date,due_date,invoice_billing_contact_name,invoice_case_name,total_amount,paid_amount,due_amount,payment_status',
					
					"lmgt_purchase_or_update_plan" => 0,	
					"lmgt_access_right_attorney" => $role_access_right_attorney,	
					"lmgt_access_right_staff" =>$role_access_right_staff,
					"lmgt_access_right_accountant" => $role_access_right_accountant,
					"lmgt_access_right_contacts" =>$role_access_right_contacts,
					"lmgt_user_email_subject"=>"You are successfully registered at {{Lawyer System Name}}",
					"lmgt_user_email_template"=>"
Dear {{User Name}},

         You are successfully registered at {{Lawyer System Name}}.You can sign in using this link. {{Login Link}} 

UserName : {{User Name}},
Password : {{Password}}

Regards From {{Lawyer System Name}}.",		

					"lmgt_case_email_subject"=>"Case is successfully registered at {{Lawyer System Name}}",
					"lmgt_case_email_template"=>"
Dear {{User Name}},

	Your Case is successfully registered of {{Lawyer System Name}}. You can access system using your User Name and Password. You can sign in using this link. {{Login Link}} 

Regards From {{Lawyer System Name}}.",	

					"lmgt_case_upcoming_limitation_date_reminder_email_subject"=>"Your Case Upcoming Statute of Limitations Due Date of {{Lawyer System Name}}",
					"lmgt_case_upcoming_limitation_date_reminder_email_template"=>"
Dear {{User Name}},

   This is a reminder that you have an upcoming statute of limitations due date. You can sign in using this link. {{Login Link}} 

Case Name : {{Case Name}},
Statute of Limitations : {{Statute of Limitations Date}}

Regards From {{Lawyer System Name}}.",	
//start task
					"lmgt_task_assigned_email_subject"=>"You Assigned New Task at {{Lawyer System Name}}",
					"lmgt_task_assigned_email_template"=>"
Dear {{User Name}}, 

      You have been assigned new Task at {{Lawyer System Name}}. 
	  
Task Name : {{Task Name}},
Case Name : {{Case Name}},
Practice Area : {{Practice Area}},
Status : {{Status}},
Due Date : {{Due Date}},
Description : {{Description}}

Regards From {{Lawyer System Name}}.",
//end task
//start task Updated
					"lmgt_task_assigned_updated_email_subject"=>" Your assigned task is updated at {{Lawyer System Name}}",
					"lmgt_task_assigned_updated_email_template"=>"
Dear {{User Name}}, 

       Your assigned task is updated at {{Lawyer System Name}}. 
	  
Task Name : {{Task Name}},
Case Name : {{Case Name}},
Practice Area : {{Practice Area}},
Status : {{Status}},
Due Date : {{Due Date}},
Description : {{Description}}

Regards From {{Lawyer System Name}}.",
//end task Updated

//start event
					"lmgt_event_assigned_email_subject"=>"You assigned new event at {{Lawyer System Name}}",
					"lmgt_event_assigned_email_template"=>"
Dear {{User Name}}, 

      You have been assigned new event at {{Lawyer System Name}}. 
	  
Event Name : {{Event Name}},
Case Name : {{Case Name}},
Practice Area : {{Practice Area}},
Address : {{Address}},
Start Date : {{Start Date}},
Description : {{Description}}

Regards From {{Lawyer System Name}}.",
//end event
//start event Updated
					"lmgt_event_assigned_updated_email_subject"=>"Your assigned event is updated at {{Lawyer System Name}}",
					"lmgt_event_assigned_updated_email_template"=>"
Dear {{User Name}}, 

      Your assigned event is updated at {{Lawyer System Name}}. 
	  
Event Name : {{Event Name}},
Case Name : {{Case Name}},
Practice Area : {{Practice Area}},
Address : {{Address}},
Start Date : {{Start Date}},
Description : {{Description}}

Regards From {{Lawyer System Name}}.",
//end event Updated
//start note
					"lmgt_note_assigned_email_subject"=>"You assigned new note at {{Lawyer System Name}}",
					"lmgt_note_assigned_email_template"=>"
Dear {{User Name}}, 

      You have been assigned new note at {{Lawyer System Name}}. 
	  
Note Name : {{Note Name}},
Case Name : {{Case Name}},
Practice Area : {{Practice Area}},
Date : {{Date}},
Note : {{Note}}

Regards From {{Lawyer System Name}}.",
//end note
//start message
'lmgt_message_received_mailcontent'=>'Dear {{receiver_name}},

         You have received new message from {{message_content}}".
 
Regards From {{Lawyer System Name}}.',
//end message
					"lmgt_case_assigned_email_subject"=>"You assigned new case at {{Lawyer System Name}}",
					"lmgt_case_assigned_email_template"=>"
Dear {{Attrony Name}},  

      You have been assigned  new case at {{Lawyer System Name}}. You can access system using your username and password. You can sign in using this link. {{Login Link}}

Case Name : {{Case Name}},
Case Number : {{Case Number}},
Open Date : {{Open Date}},
Statute of Limitations : {{Statute of Limitations Date}}

Regards From {{Lawyer System Name}}.",
//----------------- CASE ASSIGNED UPDATE -------------------//
					"lmgt_case_assigned_upadete_email_subject"=>" Your case is updated at {{Lawyer System Name}}",
					"lmgt_case_assigned_update_email_template"=>"
Dear {{User Name}},  

       Your case is updated at {{Lawyer System Name}}.

Case Name : {{Case Name}},
Case Number : {{Case Number}},
Open Date : {{Open Date}},
Statute of Limitations : {{Statute of Limitations Date}}

Regards From {{Lawyer System Name}}.",
//----------------- CASE ASSIGNED UPDATE END-------------------//
 //----------------- NEXT HEARING DATE -------------------//
					"lmgt_next_hearing_date_email_subject"=>"Your Case Next Hearing Date At {{Lawyer System Name}}",
					"lmgt_next_hearing_date_email_template"=>"
Dear {{User Name}},  
	   Your case {{Case Name}} - {{Case Number}} next hearing date is {{Next Hearing Date}}. 
       
Regards From {{Lawyer System Name}}.",
//----------------- NEXT HEARING DATE END -------------------//
//----------------- NEXT HEARING DATE REMAINDER-------------------//
					"lmgt_next_hearing_reminder_email_subject"=>"Your Case Next Hearing Date At {{Lawyer System Name}}",
					"lmgt_next_hearing_reminder_email_template"=>"
Dear {{User Name}},  
	   This is a reminder that your case {{Case Name}} - {{Case Number}} next hearing date is {{Next Hearing Date}}. 
       
Regards From {{Lawyer System Name}}.",
//----------------- NEXT HEARING DATE END REMAINDER-------------------//
					"lmgt_generate_invoice_email_subject"=>"Your have a new invoice from {{Lawyer System Name}}",
					"lmgt_generate_invoice_email_template"=>"
Dear {{User Name}},  

           Your have a new invoice from {{Lawyer System Name}}. You can check the invoice attached here.
		   
Regards From {{Lawyer System Name}}.",

					"lmgt_workflow_event_email_subject"=>"You have been assigned new event by {{Attorney Name}} at {{Lawyer System Name}}",
					"lmgt_workflow_event_email_template"=>"
Dear {{User Name}},  

		You have been assigned new event by {{Attorney Name}} at {{Lawyer System Name}}. You can access system using your username and password. You can sign in using this link. {{Login Link}}

Event Name :  {{Event Name}},
Start Date  : {{Start Date}},
Case Name : {{Case Name}}   
		
Regards From {{Lawyer System Name}}.",

					"lmgt_workflow_task_email_subject"=>"You have been assigned new task by {{Attorney Name}} at {{Lawyer System Name}}",
					"lmgt_workflow_task_email_template"=>"
Dear {{User Name}},  

		You have been assigned new task by {{Attorney Name}} at {{Lawyer System Name}}. You can access system using your username and password. You can sign in using this link. {{Login Link}}

Task Name :  {{Task Name}},
Due Date  : {{Due Date}}, 
Case Name : {{Case Name}}   
		
Regards From {{Lawyer System Name}}.",

					"lmgt_payment_received_against_invoice_email_subject"=>"You have successfully paid your invoice at {{Lawyer System Name}}",
					"lmgt_payment_received_against_invoice_email_template"=>"
Dear {{User Name}},  

		You have successfully paid your invoice.  You can check the invoice attached here.
		
Regards From {{Lawyer System Name}}.",
					
					"lmgt_message_received_email_subject"=>"You have received new message from {{Sender Name}} at {{Lawyer System Name}}",
					"lmgt_message_received_email_template"=>"
Dear {{Receiver Name}},  

		You have received new message from {{Sender Name}}. {{Message Content}} . {{Message_Link}}
		
Regards From {{Lawyer System Name}}.",

					"lmgt_event_reminder_email_subject"=>"Your Case Upcoming Event of {{Lawyer System Name}}",
					"lmgt_event_reminder_email_template"=>"
Dear {{User Name}},  

		This is a reminder that you have an upcoming event date. You can sign in using this link. {{Login Link}} 

Case Name :  {{Case Name}},
Event Name : {{Event Name}}, 
Start Date : {{Start Date}}  
		
Regards From {{Lawyer System Name}}.",

					"lmgt_task_reminder_email_subject"=>"Your Case Upcoming Task of {{Lawyer System Name}}",
					"lmgt_task_reminder_email_template"=>"
Dear {{User Name}},  

		This is a reminder that you have an upcoming task due date. You can sign in using this link. {{Login Link}} 

Case Name :  {{Case Name}},
Task Name  : {{Task Name}}, 
Due Date : {{Due Date}}  
		
Regards From {{Lawyer System Name}}.",

				"lmgt_judgment_email_subject"=>"Your Case Judgment At {{Lawyer System Name}}",
				"lmgt_judgment_email_template"=>"
 Dear {{User Name}},
      Your case {{Case Name}} - {{Case Number}} judgment by {{Judge Name}} at {{Date}}.
Judgments Details : {{Judgments Details}}
Regards From {{Lawyer System Name}}.",

				"lmgt_order_email_subject"=>"Your Case Order At {{Lawyer System Name}}",
				"lmgt_order_email_template"=>"
  Dear {{User Name}},
      Your case {{Case Name}} - {{Case Number}} order by {{Judge Name}} and next hearing date is {{Next Hearing Date}}.
Order Details : {{Order Details}}
Regards From {{Lawyer System Name}}.",

				
				"lmgt_updated_order_email_subject"=>"Your Case Order Updated At {{Lawyer System Name}}",
				"lmgt_updated_order_email_template"=>"
  Dear {{User Name}},
      Your case {{Case Name}} - {{Case Number}} updated order by {{Judge Name}} and next hearing date is {{Next Hearing Date}}.
Order Details : {{Order Details}}
Regards From {{Lawyer System Name}}.",
				
				"lmgt_weekly_case_report_email_subject"=>"Your Case Weekly Update Report At {{Lawyer System Name}}",
				"lmgt_weekly_case_report_email_template"=>"
  Dear {{User Name}},
      Your case {{Case Name}} - {{Case Number}} weekly update report .You can check the weekly update report attached here.
    
Regards From {{Lawyer System Name}}.",

		);
	return $options;
}
//ADD OPTION IN INIT FUNCTION//
add_action('admin_init','MJ_lawmgt_general_setting');
//GENERAL SETTINGS//
function MJ_lawmgt_general_setting()
{
	$options=MJ_lawmgt_option();
	 
	foreach($options as $key=>$val)
	{
		add_option($key,$val);			
	}
}
add_action( 'plugins_loaded', 'MJ_lawmgt_domain_load' );
//DOMAIN NAME LOAD FUNCTION
function MJ_lawmgt_domain_load()
{
	load_plugin_textdomain( 'lawyer_mgt', false, dirname( plugin_basename( __FILE__ ) ). '/languages/' );
}
//<--  CALL CSS And JS IN FRTONTEN SIDE FUNCTION --> //
add_action('wp_enqueue_scripts','MJ_lawmgt_load_script1');

function MJ_lawmgt_load_script1()
{
	if(isset($_REQUEST['dashboard']) && sanitize_text_field($_REQUEST['dashboard']) == 'user')
	{	
		$lancode=get_locale();
		$code=substr($lancode,0,2);
		wp_enqueue_style( 'mj-lawmgt-style-css', plugins_url( '/assets/css/style.css', __FILE__) );
		
		wp_enqueue_style( 'bootstrap-css-font', plugins_url( '/assets/css/bootstrap-glyphicons.css', __FILE__) );
		wp_enqueue_style( 'mj-lawmgt-popup-css', plugins_url( '/assets/css/mj-lawmgt-popup.css', __FILE__) );
		wp_enqueue_style( 'mj-lawmgt-custom-style-css', plugins_url( '/assets/css/mj-lawmgt-custom-style.css', __FILE__) );
		wp_enqueue_style( 'select2-css', plugins_url( '/lib/select2-3.5.3/select2.css', __FILE__) );
		wp_enqueue_style( 'fileinput-css', plugins_url( '/lib/bootstrap-fileinput-master/css/fileinput.css', __FILE__) );
		wp_enqueue_script('select2-js', plugins_url( '/lib/select2-3.5.3/select2-default.js', __FILE__ ), array( 'jquery' ));
		//data export to csv
		wp_enqueue_script('export-csv-js', plugins_url( '/assets/js/export-csv.js', __FILE__ ) );
		wp_enqueue_script('canvas-to-blob-js', plugins_url( '/lib/bootstrap-fileinput-master/js/plugins/canvas-to-blob.js', __FILE__ ) );
		wp_enqueue_script('fileinput-js', plugins_url( '/lib/bootstrap-fileinput-master/js/fileinput.js', __FILE__ ) );
		wp_enqueue_script('fileinput-custom-js', plugins_url( '/lib/bootstrap-fileinput-master/js/fileinput-custom.js', __FILE__ ) );
		wp_enqueue_script('fileinput-locale-js', plugins_url( '/lib/bootstrap-fileinput-master/js/fileinput-locale-'.$code.'.js', __FILE__ ) );
		wp_enqueue_media();					
		wp_enqueue_script('mj-lawmgt-image-upload-js', plugins_url( '/assets/js/mj-lawmgt-image-upload.js', __FILE__ ), array( 'jquery' ));
		wp_enqueue_style( 'bootstrap-css', plugins_url( '/assets/css/bootstrap.css', __FILE__) );
		wp_enqueue_style( 'bootstrap-multiselect-css', plugins_url( '/assets/css/bootstrap-multiselect.css', __FILE__) );
		wp_enqueue_style( 'font-awesome-min-css', plugins_url( '/assets/css/font-awesome-min.css', __FILE__) );
		wp_enqueue_style( 'white-css', plugins_url( '/assets/css/white.css', __FILE__) );
		wp_enqueue_style( 'mj-lawmgt-css', plugins_url( '/assets/css/lmgt.css', __FILE__) );
		wp_enqueue_style( 'mj-lawmgt-responsive-css', plugins_url( '/assets/css/mj-lawmgt-responsive.css', __FILE__) );
		wp_enqueue_script('popper', plugins_url( '/assets/js/popper.js', __FILE__ ) );
		wp_enqueue_script('bootstrap-js', plugins_url( '/assets/js/bootstrap.js', __FILE__ ) );
		wp_enqueue_script('bootstrap-multiselect-js', plugins_url( '/assets/js/bootstrap-multiselect.js', __FILE__ ) );
		wp_enqueue_script('mj-lawmgt-js', plugins_url( '/assets/js/modernizr.js', __FILE__ ) );
		if (is_rtl())
		{			
			wp_enqueue_style( 'bootstrap-rtl-css', plugins_url( '/assets/css/bootstrap-rtl.css', __FILE__) );
			wp_enqueue_script('mj-lawmgt-validationEngine-'.$code.'.-js', plugins_url( '/assets/js/jquery-validationEngine-'.$code.'.js', __FILE__ ) );
			wp_enqueue_style('mj-lawmgt-admin-side-rtl-custom-css', plugins_url( '/assets/css/mj-lawmgt-admin-side-rtl-custom-css.css', __FILE__ ) );
		}
		wp_enqueue_script('mj-lawmgt-calender-'.$code.'', plugins_url( '/assets/js/calendar-lang/'.$code.'.js', __FILE__ ), array( 'jquery' ));
		//popup//
		wp_enqueue_script('mj-lawmgt-popup', plugins_url( '/assets/js/mj-lawmgt-popup.js', __FILE__ ), array( 'jquery' ), '4.1.1', false );
		
		//popup file alert msg languages translation//				
		wp_localize_script('mj-lawmgt-popup', 'language_translate', array(
				'group_name_popup' => esc_html__( 'Please enter Group Name.','lawyer_mgt'),
				'name_popup' => esc_html__( 'Please enter Name.', 'lawyer_mgt' ),
				'enter_category_alert' => esc_html__( 'Please enter Category Name.', 'lawyer_mgt' ),
				'enter_court_category_alert' => esc_html__( 'Please enter Court Name.', 'lawyer_mgt' ),
				'enter_state_category_alert' => esc_html__( 'Please enter State Name.', 'lawyer_mgt' ),
				'enter_bench_category_alert' => esc_html__( 'Please enter Bench Name.', 'lawyer_mgt' ),
				'practice_area_popup' => esc_html__( 'Please enter Practice Area.', 'lawyer_mgt' ),
				'tag_name_popup' => esc_html__( 'Please Enter Tag name...', 'lawyer_mgt' ),
				'tag_duplicate_popup' => esc_html__( 'Duplicate Tags', 'lawyer_mgt' ),
				'select_date_popup' => esc_html__( 'Please select date.', 'lawyer_mgt' ),
				'workflow_popup' => esc_html__( 'This Workflow already applyed to this case you can apply this workflow then first delete it and after apply this workflow', 'lawyer_mgt' ),
				
			)
		);
		wp_localize_script( 'mj-lawmgt-popup', 'lmgt', array( 'ajax' => admin_url( 'admin-ajax.php' ) ) );
		//Validation style And Script
		//validation lib
		wp_enqueue_style( 'validate-css', plugins_url( '/lib/validationEngine/css/validationEngine-jquery.css', __FILE__) );	 	
		wp_register_script( 'jquery-validationEngine-'.$code.'', plugins_url( '/lib/validationEngine/js/languages/jquery-validationEngine-'.$code.'.js', __FILE__), array( 'jquery' ) );
		wp_enqueue_script( 'jquery-validationEngine-'.$code.'' );
		wp_register_script( 'jquery-validationEngine', plugins_url( '/lib/validationEngine/js/jquery-validationEngine.js', __FILE__), array( 'jquery' ) );
		wp_enqueue_script( 'jquery-validationEngine' );
		
		// Template CSS & JS		
		wp_enqueue_style( 'nprogress-css', plugins_url( '/assets/css/nprogress.css', __FILE__) );	 	
		wp_enqueue_style( 'green-css', plugins_url( '/assets/css/green.css', __FILE__) );	 	
		wp_enqueue_style( 'dataTables-bootstrap-css', plugins_url( '/assets/css/dataTables-bootstrap.css', __FILE__) );	 	
		wp_enqueue_style( 'dataTables-responsive-css', plugins_url( '/assets/css/dataTables-responsive.css', __FILE__) );	 	
		wp_enqueue_style( 'buttons-bootstrap-css', plugins_url( '/assets/css/buttons-bootstrap.css', __FILE__) );	 	
		wp_enqueue_style( 'fixedHeader-bootstrap-css', plugins_url( '/assets/css/fixedHeader-bootstrap.css', __FILE__) );	 	
		wp_enqueue_style( 'responsive-bootstrap-css', plugins_url( '/assets/css/responsive-bootstrap.css', __FILE__) );	 	
		wp_enqueue_style( 'scroller-bootstrap-css', plugins_url( '/assets/css/scroller-bootstrap.css', __FILE__) );	 	
		wp_enqueue_style( 'bootstrap-progressbar-css', plugins_url( '/assets/css/bootstrap-progressbar.css', __FILE__) );	 	
		wp_enqueue_style( 'jqvmap-css', plugins_url( '/assets/css/jqvmap.css', __FILE__) );	 	
		wp_enqueue_style( 'timepicker-css', plugins_url( '/assets/css/bootstrap-timepicker.css', __FILE__) );		 	 	
		wp_enqueue_style( 'datepicker-css', plugins_url( '/assets/css/datepicker.css', __FILE__) );	 	
		wp_enqueue_style( 'datepicker-default-css', plugins_url( '/assets/css/datepicker-default-css.css', __FILE__) );	 	
		wp_enqueue_style( 'custom-css', plugins_url( '/assets/css/custom.css', __FILE__) );	 	
		wp_enqueue_style( 'fullcalendar', plugins_url( '/assets/css/fullcalendar.css', __FILE__) );	 	
		
		wp_enqueue_script('fastclick-js', plugins_url( '/assets/js/fastclick.js', __FILE__ ) );
		wp_enqueue_script('nprogress', plugins_url( '/assets/js/nprogress.js', __FILE__ ) );
		wp_enqueue_script('Chart-js', plugins_url( '/assets/js/Chart.js', __FILE__ ) );
		wp_enqueue_script('gauge-js', plugins_url( '/assets/js/gauge.js', __FILE__ ) );
		wp_enqueue_script('bootstrap-progressbar-js', plugins_url( '/assets/js/bootstrap-progressbar.js', __FILE__ ) );
		wp_enqueue_script('icheck-js', plugins_url( '/assets/js/icheck.js', __FILE__ ) );
		wp_enqueue_script('jquery-dataTables-js', plugins_url( '/assets/js/jquery-dataTables.js',__FILE__ ) );
		wp_enqueue_script('dataTables-editor', plugins_url( '/assets/js/dataTables-editor.js',__FILE__ ) );
		wp_enqueue_script('dataTables-tableTools', plugins_url( '/assets/js/dataTables-tableTools.js',__FILE__ ) );
		wp_enqueue_script('dataTables-bootstrap', plugins_url( '/assets/js/dataTables-bootstrap.js',__FILE__ ) );
		wp_enqueue_script('dataTables-responsive', plugins_url( '/assets/js/dataTables-responsive.js',__FILE__ ) );
		wp_enqueue_script('dataTables-buttons', plugins_url( '/assets/js/dataTables-buttons.js',__FILE__ ) );
		wp_enqueue_script('buttons-bootstrap', plugins_url( '/assets/js/buttons-bootstrap.js',__FILE__ ) );
		wp_enqueue_script('dataTables-select', plugins_url( '/assets/js/dataTables-select.js',__FILE__ ) );
		wp_enqueue_script('mj-lawmgt-js', plugins_url( '/assets/js/modernizr.js', __FILE__ ) );
		wp_enqueue_script('pdfmake-js', plugins_url( '/assets/js/pdfmake.js',__FILE__ ) );
		wp_enqueue_script('vfs_fonts-js', plugins_url( '/assets/js/vfs-fonts.js',__FILE__ ) );
		wp_enqueue_script('jszip-js', plugins_url( '/assets/js/jszip.js',__FILE__ ) );
		wp_enqueue_script('buttons-html5-js', plugins_url( '/assets/js/buttons-html5.js', __FILE__ ) );
		wp_enqueue_script('skycons-js', plugins_url( '/assets/js/skycons.js', __FILE__ ) );
		wp_enqueue_script('jquery-flot-js', plugins_url( '/assets/js/jquery-flot.js', __FILE__ ) );
		wp_enqueue_script('jquery-flot-pie-js', plugins_url( '/assets/js/jquery-flot-pie.js', __FILE__ ) );
		wp_enqueue_script('jquery-flot-time-js', plugins_url( '/assets/js/jquery-flot-time.js', __FILE__ ) );
		wp_enqueue_script('jquery-flot-stack-js', plugins_url( '/assets/js/jquery-flot-stack.js', __FILE__ ) );
		wp_enqueue_script('jquery-flot-resize-js', plugins_url( '/assets/js/jquery-flot-resize.js', __FILE__ ) );
		wp_enqueue_script('jquery-flot-orderBars-js', plugins_url( '/assets/js/jquery-flot-orderBars.js', __FILE__ ) );
		wp_enqueue_script('jquery-flot-spline-js', plugins_url( '/assets/js/jquery-flot-spline.js', __FILE__ ) );
		wp_enqueue_script('curvedLines-js', plugins_url( '/assets/js/curvedLines.js', __FILE__ ) );
		wp_enqueue_script('jquerydate-js', plugins_url( '/assets/js/date.js', __FILE__ ) );
		wp_enqueue_script('jquery-vmap-js', plugins_url( '/assets/js/jquery-vmap.js', __FILE__ ) );
		wp_enqueue_script('jquery-vmap-world-js', plugins_url( '/assets/js/jquery-vmap-world.js', __FILE__ ) );
		wp_enqueue_script('jquery-vmap-sampledata-js', plugins_url( '/assets/js/jquery-vmap-sampledata.js', __FILE__ ) );
		
		wp_enqueue_script('bootstrap-datepicker-js', plugins_url( '/assets/js/bootstrap-datepicker.js', __FILE__ ) );
		wp_enqueue_script('bootstrap-timepicker-js', plugins_url( '/assets/js/bootstrap-timepicker.js', __FILE__ ) );
		wp_enqueue_script('custom-js', plugins_url( '/assets/js/custom.js', __FILE__ ) );
		wp_enqueue_script('fullcalendar', plugins_url( '/assets/js/fullcalendar.js', __FILE__ ));	
		//INPUT TAG
		wp_enqueue_style('jquery-tagsinput-css', plugins_url( '/assets/css/jquery-tagsinput.css', __FILE__));
		wp_enqueue_script('jquery-tagsinput-js', plugins_url( '/assets/js/jquery-tagsinput.js', __FILE__ ));
		wp_enqueue_script('jquery-timeago-js', plugins_url( '/assets/js/jquery-timeago.js', __FILE__ ));
	 	
		wp_enqueue_style( 'Viewdetail-css', plugins_url( '/assets/css/Viewdetail.css', __FILE__) );
		wp_enqueue_style( 'mj-lawmgt-newversion', plugins_url( '/assets/css/newversion.css', __FILE__) );
		wp_enqueue_style( 'mj-lawmgt-fronted-custom-css', plugins_url( '/assets/css/template/mj-lawmgt-fronted-custom.css', __FILE__) );
		wp_enqueue_script('mj-lawmgt-fronted-loader-js', plugins_url( '/assets/js/loader.js', __FILE__ ));
	}
}
//Remove theme CSS and JS
function wpse_340767_dequeue_theme_assets() 
{
    $wp_scripts = wp_scripts();
    $wp_styles  = wp_styles();
    $themes_uri = get_theme_root_uri();

    foreach ( $wp_scripts->registered as $wp_script ) 
	{
        if ( strpos( $wp_script->src, $themes_uri ) !== false ) 
		{
            wp_deregister_script( $wp_script->handle );
        }
    }

    foreach ( $wp_styles->registered as $wp_style ) 
	{
        if ( strpos( $wp_style->src, $themes_uri ) !== false ) 
		{
            wp_deregister_style( $wp_style->handle );
        }
    }
}
if(isset($_REQUEST['dashboard']) && sanitize_text_field($_REQUEST['dashboard']) == 'user')
{
	add_action( 'wp_enqueue_scripts', 'wpse_340767_dequeue_theme_assets', 999 );
}
add_action( 'admin_bar_menu', 'MJ_lawmgt_dashboard_link', 999 );

//USER DASHBOARD LINK FUNCTION //
function MJ_lawmgt_dashboard_link( $wp_admin_bar ) {
	$args = array(
			'id'    => 'lawyer-dashboard',
			'title' => esc_html__('lawyer Dashboard','lawyer_mgt'),
			'href'  => home_url().'?dashboard=user',
			'meta'  => array( 'class' => 'lmgt_lawyer-dashboard' )
	);
	$wp_admin_bar->add_node( $args );
}
function MJ_lawmgt_user_dashboard()
{
	if(isset($_REQUEST['dashboard']))
	{
		require_once LAWMS_PLUGIN_DIR. '/fronted_template.php';
		exit;
	}
	if(isset($_REQUEST['lawmgt_login']))
	{
		add_action( 'authenticate', 'pu_blank_login');
	}
}
add_action('wp_head','MJ_lawmgt_user_dashboard');
//<--  INSTALL LOGIN PAGE FUNCTION --> //
function MJ_lawmgt_install_login_page()
{	
	if ( !get_option('lawmgt_login_page') ) 
	{		
		$curr_page = array(
				'post_title' => esc_html__('Law Practice Management Login Page', 'lawyer_mgt'),
				'post_content' => '[lawmgt_login]',
				'post_status' => 'publish',
				'post_type' => 'page',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'post_category' => array(1),
				'post_parent' => 0 );
		
		$curr_created = wp_insert_post( $curr_page );

		update_option( 'lawmgt_login_page', $curr_created );
	}	
}
add_action('init','MJ_lawmgt_install_login_page');

add_shortcode( 'lawmgt_login','MJ_lawmgt_login_link');

add_action('init','MJ_lawmgt_output_ob_start');
function MJ_lawmgt_output_ob_start()
{
   ///ob_start();	
}  
function MJ_lawmgt_my_login_redirect( $redirect_to,$request,$user )
{ 
	$user_roles=array('attorney','staff_member','accountant','client');
	//check for subscribers//
	//is there a user to check? 
   if (isset($user->roles) && is_array($user->roles)) 
   { 
		foreach( $user->roles as $data)
		{
			$roles=$data;
		}
		if(in_array($roles,$user_roles)) 
		{ 
			// redirect them to another URL, in this case, the homepage
			$redirect_to = home_url('/?dashboard=user');
		} 			
	} 
	return $redirect_to; 
} 
add_filter( 'login_redirect', 'MJ_lawmgt_my_login_redirect',10,3);  
?>