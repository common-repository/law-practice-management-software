<?php 
// This is adminside main First page of lawyer management plugin 
add_action( 'admin_menu', 'MJ_lawmgt_system_menu' );
function MJ_lawmgt_system_menu() 
{
	add_menu_page('WP Law', esc_html__('WP Law','lawyer_mgt'),'manage_options','lmgt_system','MJ_lawmgt_system_dashboard',plugins_url('lawyers-management/assets/images/logo/home.png' )); 
	
	add_submenu_page('lmgt_system', 'Attorney', esc_html__( 'Attorney', 'lawyer_mgt' ), 'administrator', 'attorney', 'MJ_lawmgt_attorney_manage');
	
	add_submenu_page('lmgt_system', 'Staff', esc_html__( 'Staff', 'lawyer_mgt' ), 'administrator', 'staff', 'MJ_lawmgt_staff_manage');
	
	add_submenu_page('lmgt_system', 'Accountant', esc_html__( 'Accountant', 'lawyer_mgt' ), 'administrator', 'accountant', 'MJ_lawmgt_accountant_manage');
	
	add_submenu_page('lmgt_system', 'Clients', esc_html__( 'Clients', 'lawyer_mgt' ), 'administrator', 'contacts', 'MJ_lawmgt_contacts_manage');
	
	add_submenu_page('lmgt_system', 'Court', esc_html__( 'Court', 'lawyer_mgt' ), 'administrator', 'court', 'MJ_lawmgt_court_manage');
	
	add_submenu_page('lmgt_system', 'Cases', esc_html__( 'Cases', 'lawyer_mgt' ), 'administrator', 'cases', 'MJ_lawmgt_cases_manage');
	
	add_submenu_page('lmgt_system', 'Orders', esc_html__( 'Orders', 'lawyer_mgt' ), 'administrator', 'orders', 'MJ_lawmgt_orders_manage');
	
	add_submenu_page('lmgt_system', 'Judgments', esc_html__( 'Judgments', 'lawyer_mgt' ), 'administrator', 'judgments', 'MJ_lawmgt_judgments_manage');
	
	add_submenu_page('lmgt_system', 'Cause List', esc_html__( 'Cause List', 'lawyer_mgt' ), 'administrator', 'causelist', 'MJ_lawmgt_causelist_manage');
	if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
	{
		add_submenu_page('lmgt_system', 'Tasks', esc_html__( 'Tasks', 'lawyer_mgt' ), 'administrator', 'task', 'MJ_lawmgt_task_manage');
	}
	add_submenu_page('lmgt_system', 'Events', esc_html__( 'Events', 'lawyer_mgt' ), 'administrator', 'event', 'MJ_lawmgt_event_manage');
	
	add_submenu_page('lmgt_system', 'Notes', esc_html__( 'Notes', 'lawyer_mgt' ), 'administrator', 'note', 'MJ_lawmgt_note_manage');
	
	add_submenu_page('lmgt_system', 'Workflow', esc_html__( 'Workflow', 'lawyer_mgt' ), 'administrator', 'workflow', 'MJ_lawmgt_workflow_manage');
	if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
	{
		add_submenu_page('lmgt_system', 'Documents', esc_html__( 'Documents', 'lawyer_mgt' ), 'administrator', 'documents', 'MJ_lawmgt_documents_manage');
		
		add_submenu_page('lmgt_system', 'Invoices', esc_html__( 'Invoices', 'lawyer_mgt' ), 'administrator', 'invoice', 'MJ_lawmgt_invoice_manage');
	}	
	add_submenu_page('lmgt_system', 'Rules', esc_html__( 'Rules', 'lawyer_mgt' ), 'administrator', 'rules', 'MJ_lawmgt_rules_manage');
	if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
	{
		add_submenu_page('lmgt_system', 'Custom Fields', esc_html__( 'Custom Fields', 'lawyer_mgt' ), 'administrator', 'custom_field', 'MJ_lawmgt_custom_field_manage');
	
		add_submenu_page('lmgt_system', 'Reports', esc_html__( 'Reports', 'lawyer_mgt' ), 'administrator', 'report', 'MJ_lawmgt_report_manage');
	}	
	add_submenu_page('lmgt_system', 'Audit Log', esc_html__( 'Audit Log', 'lawyer_mgt' ), 'administrator', 'audit_log', 'MJ_lawmgt_audit_log_manage');
	
	add_submenu_page('lmgt_system', 'Messages', esc_html__( 'Messages', 'lawyer_mgt' ), 'administrator', 'message', 'MJ_lawmgt_message_manage');

	add_submenu_page('lmgt_system', 'Access Rights', esc_html__( 'Access Rights', 'lawyer_mgt' ), 'administrator', 'access_right', 'MJ_lawmgt_access_right_manage');
	
	add_submenu_page('lmgt_system', 'Mail_templates', esc_html__( 'Mail Templates', 'lawyer_mgt' ), 'administrator', 'mail_template', 'MJ_lawmgt_mail_template_manage');
	
	add_submenu_page('lmgt_system', 'Settings', esc_html__( 'Settings', 'lawyer_mgt' ), 'administrator', 'lmgt_gnrl_setting', 'MJ_lawmgt_gnrl_settings');

	//add_submenu_page('lmgt_system', 'Calander', esc_html__( 'Calander', 'lawyer_mgt' ), 'administrator', 'calander', 'MJ_lawmgt_gnrl_Calander');
}
function MJ_lawmgt_system_dashboard()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/dasboard.php';
}
function MJ_lawmgt_attorney_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/attorney/index.php';
}	
function MJ_lawmgt_staff_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/staff/index.php';
}	
function MJ_lawmgt_accountant_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/accountant/index.php';
}
function MJ_lawmgt_contacts_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/contacts/index.php';
}
function MJ_lawmgt_court_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/court/index.php';
}
function MJ_lawmgt_cases_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/cases/index.php';
}
 
function MJ_lawmgt_orders_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/orders/index.php';
}
function MJ_lawmgt_task_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/task/index.php';
}
function MJ_lawmgt_event_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/event/index.php';
}
function MJ_lawmgt_note_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/notes/index.php';
}
function MJ_lawmgt_workflow_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/workflow/index.php';
}
function MJ_lawmgt_documents_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/documents/index.php';
}
function MJ_lawmgt_invoice_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/invoice/index.php';
}
function MJ_lawmgt_rules_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/rules/index.php';
}
function MJ_lawmgt_judgments_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/judgments/index.php';
}
function MJ_lawmgt_causelist_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/causelist/index.php';
}
function MJ_lawmgt_custom_field_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/customfield/index.php';
} 
function MJ_lawmgt_report_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/report/index.php';
}
function MJ_lawmgt_audit_log_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/auditlog/index.php';
}
function MJ_lawmgt_message_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/message/index.php';
}
function MJ_lawmgt_access_right_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/access_right/index.php';
}
function MJ_lawmgt_mail_template_manage()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/mailtemplate/index.php';
}
function MJ_lawmgt_gnrl_settings()
{
	require_once LAWMS_PLUGIN_DIR. '/admin/general-settings.php';
}
?>