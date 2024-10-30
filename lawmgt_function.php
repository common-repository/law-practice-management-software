<?php
if ( !function_exists( 'add_action' ) )
{
	esc_html__('Hi there!  I\'m just a plugin, not much I can do when called directly.','lawyer_mgt');
	exit;
}
// get currencysymbol function
function MJ_lawmgt_get_currency_symbol( $currency = '' ) 
{			
	$currency = get_option('lmgt_currency_code');
	
	switch ( $currency ) 
	{
		case 'AED' :
		$currency_symbol = 'د.إ';
		break;
		case 'AUD' :
		$currency_symbol = '&#36;';
		break;
		case 'CAD' :
		$currency_symbol = 'C&#36;';
		break;
		case 'CLP' :
		case 'COP' :
		case 'HKD' :
		$currency_symbol = '&#36';
		break;
		case 'MXN' :
		$currency_symbol = '&#36';
		break;
		case 'NZD' :
		$currency_symbol = '&#36';
		break;
		case 'SGD' :
		case 'USD' :
		$currency_symbol = '&#36;';
		break;
		case 'BDT':
		$currency_symbol = '&#2547;&nbsp;';
		break;
		case 'BGN' :
		$currency_symbol = '&#1083;&#1074;.';
		break;
		case 'BRL' :
		$currency_symbol = '&#82;&#36;';
		break;
		case 'CHF' :
		$currency_symbol = '&#67;&#72;&#70;';
		break;
		case 'CNY' :
		case 'JPY' :
		case 'RMB' :
		$currency_symbol = '&yen;';
		break;
		case 'CZK' :
		$currency_symbol = '&#75;&#269;';
		break;
		case 'DKK' :
		$currency_symbol = 'kr.';
		break;
		case 'DOP' :
		$currency_symbol = 'RD&#36;';
		break;
		case 'EGP' :
		$currency_symbol = 'EGP';
		break;
		case 'EUR' :
		$currency_symbol = '&euro;';
		break;
		case 'GBP' :
		$currency_symbol = '&pound;';
		break;
		case 'HRK' :
		$currency_symbol = 'Kn';
		break;
		case 'HUF' :
		$currency_symbol = '&#70;&#116;';
		break;
		case 'IDR' :
		$currency_symbol = 'Rp';
		break;
		case 'ILS' :
		$currency_symbol = '&#8362;';
		break;
		case 'INR' :
		$currency_symbol = 'Rs.';
		break;
		case 'ISK' :
		$currency_symbol = 'Kr.';
		break;
		case 'KIP' :
		$currency_symbol = '&#8365;';
		break;
		case 'KRW' :
		$currency_symbol = '&#8361;';
		break;
		case 'MYR' :
		$currency_symbol = '&#82;&#77;';
		break;
		case 'NGN' :
		$currency_symbol = '&#8358;';
		break;
		case 'NOK' :
		$currency_symbol = '&#107;&#114;';
		break;
		case 'NPR' :
		$currency_symbol = 'Rs.';
		break;
		case 'PHP' :
		$currency_symbol = '&#8369;';
		break;
		case 'PLN' :
		$currency_symbol = '&#122;&#322;';
		break;
		case 'PYG' :
		$currency_symbol = '&#8370;';
		break;
		case 'RON' :
		$currency_symbol = 'lei';
		break;
		case 'RUB' :
		$currency_symbol = '&#1088;&#1091;&#1073;.';
		break;
		case 'SEK' :
		$currency_symbol = '&#107;&#114;';
		break;
		case 'THB' :
		$currency_symbol = '&#3647;';
		break;
		case 'TRY' :
		$currency_symbol = '&#8378;';
		break;
		case 'TWD' :
		$currency_symbol = '&#78;&#84;&#36;';
		break;
		case 'UAH' :
		$currency_symbol = '&#8372;';
		break;
		case 'VND' :
		$currency_symbol = '&#8363;';
		break;
		case 'ZAR' :
		$currency_symbol = '&#82;';
		break;
		default :
		$currency_symbol = $currency;
		break;
	}
	 
	return $currency_symbol;
}
function MJ_lawmgt_is_lmgtpage()
{
	if(isset($_REQUEST['page']))
	{
		$current_page=sanitize_text_field($_REQUEST['page']);
	}
	else
	{
		$current_page ='';
	}
	
	$page_array = MJ_lawmgt_lawyers_call_script_page();
	
	if (in_array($current_page, $page_array))
	{
		return true;
	}	
	return false;
}
//Plan purchase or not check
function MJ_lawmgt_purchase_or_update_plan() 
{	
    $lmgt_plan_status=get_option('lmgt_purchase_or_update_plan');
	if(empty($lmgt_plan_status))
	{
		$lmgt_plan_status=0;
	}
	$GLOBALS['lmgt_purchase_or_update_plan'] = $lmgt_plan_status; 
}
MJ_lawmgt_purchase_or_update_plan();
/*<---  DATE PICKER DATE FOARMTE FUNCTION --->*/
function MJ_lawmgt_datepicker_dateformat()
{
	$date_format_array = array(
	'Y-m-d'=>'yy-mm-dd',
	'Y/m/d'=>'yy/mm/dd',
	'd-m-Y'=>'dd-mm-yy',
	'm-d-Y'=>'mm-dd-yy',
	'm/d/Y'=>'mm/dd/yy');
	return $date_format_array;
}
/*<---  BOOTSTARP DATE PICKER DATE FOARMTE FUNCTION --->*/
function MJ_lawmgt_bootstrap_datepicker_dateformat($key)
{	
	$date_format_array = array(
	'yy-mm-dd'=>'yyyy-mm-dd',
	'yy/mm/dd'=>'yyyy/mm/dd',
	'dd-mm-yy'=>'dd-mm-yyyy',
	'mm-dd-yy'=>'mm-dd-yyyy',
	'mm/dd/yy'=>'mm/dd/yyyy');
	return $date_format_array[$key];
}

/*<---  PHP  DATE FOARMTE FUNCTION --->*/
function MJ_lawmgt_get_phpdateformat($dateformat_value)
{
	$date_format_array = MJ_lawmgt_datepicker_dateformat();
	$php_format = array_search($dateformat_value, $date_format_array);  
	return  $php_format;
}

/*<---  GET DAT IN INPUT BOX FUNCTION --->*/
function MJ_lawmgt_getdate_in_input_box($date)
{	
	return date(MJ_lawmgt_get_phpdateformat(get_option('lmgt_datepicker_format')),strtotime($date));	
}
//case Filter Case Status 
function MJ_lawmgt_case_status()
{			
	if(isset($_REQUEST['selection_id']))
	{
		$case_staus= sanitize_text_field($_REQUEST['selection_id']);
	}
	else
	{
		$case_staus='';
	}
	if(isset($_REQUEST['attorney']))
	{
		$attorney= sanitize_text_field($_REQUEST['attorney']);
	}
	else
	{
		$attorney='';
	}
	 global $wpdb;
	 $table_case = $wpdb->prefix. 'lmgt_cases';	
	 $casedata = $wpdb->get_results("SELECT * FROM $table_case WHERE FIND_IN_SET($attorney,case_assgined_to) AND case_status='$case_staus' ORDER BY id DESC LIMIT 0 , 2");
	
	$practice_area_data = array();	
		
	if(!empty($casedata))
	{
		foreach($casedata as $case_practice_area)
		{
			$case_id=$case_practice_area->id;
			$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
			$contactdata=$wpdb->get_results("SELECT * FROM $table_case_contacts WHERE case_id=$case_id");
            if(!empty($contactdata)){
			foreach($contactdata as $contactdata1)
			{
			    $use= sanitize_text_field($contactdata1->user_id);
				$user_info=get_userdata($use); 
				$userid[]= sanitize_text_field($user_info->display_name);
				$company[]= get_user_meta($use,'company', true );
		
			}
				$contatc_name=implode(',',$userid);
				$compny_name=implode(',',$company);
			}
				 $obj_practicearea=new MJ_lawmgt_practicearea;
				 $practice_id=$retrieved_data->practice_area_id;
				 $practice=$obj_practicearea->MJ_lawmgt_get_single_practicearea($practice_id);
				 $practice_area ='<tr><td>'.esc_html($contatc_name).'</td><td>'.esc_html($compny_name).'</td>
				<td><a href="?page=cases&tab=casedetails&action=view&case_id='.esc_attr($case_practice_area->id).'"</a>'.esc_html($case_practice_area->case_name).'</td>
				<td>'.esc_html($practice->post_title).'</td>
				<td>'.esc_html($case_practice_area->open_date).'</td>
				</tr>';	
				$practice_area_data[]=$practice_area;					
		} 	
	}
			
	echo json_encode($practice_area_data);
	
	die();  
}
//Case Name Get in Task ,Note,Event Module
function MJ_lawmgt_get_case_name_by_id($id)
{
	global $wpdb;	
	$table_case = $wpdb->prefix. 'lmgt_cases';		
	$result = $wpdb->get_results("SELECT case_name FROM $table_case where id=".$id);
	return $result;	
}
//Task Filter function
function MJ_lawmgt_assign_task()
{		
	if(isset($_REQUEST['selection_id']))
	{
		$case_assign= sanitize_text_field($_REQUEST['selection_id']);
	}
	else
	{
		$case_assign='';
	}	
	 global $wpdb;
	 $table_case = $wpdb->prefix. 'lmgt_add_task';	
	 $casedata = $wpdb->get_results("SELECT * FROM $table_case where assign_to_contact=".$case_assign);
	 $case_data = array();	
	if(!empty($casedata))
	{
		foreach($casedata as $case_practice_area)
		{	
			$user_id = sanitize_text_field($case_practice_area->assigned_to_user);
			$con_id= sanitize_text_field($case_practice_area->assign_to_contact);
			$contac_id=explode(',',$user_id);
			$contac_id1=explode(',',$con_id);
			$user_name=array();
			foreach($contac_id as $contact_name)
			{
				$userdata=get_userdata($contact_name);	
				
				$user_name[]= sanitize_text_field($userdata->display_name);	   
			}
					   
			$contact_name1=array();
			foreach($contac_id1 as $contact_name)
			{
				$userdata=get_userdata($contact_name);
				
				$contact_name1[] = sanitize_text_field($userdata->display_name);						   
			}
			$table_case1 = $wpdb->prefix. 'lmgt_cases';		
			$result1 = $wpdb->get_results("SELECT case_name FROM $table_case1 where id=$case_practice_area->case_id");
		  
			foreach($result1 as $case_name1)
			{
				$case_name2= sanitize_text_field($case_name1->case_name);
			}	
			if($case_practice_area->status==0){
							 $statu='Not Completed';
							 }else if($case_practice_area->status==1){
							 $statu='Completed';
							 }else{
							 $statu='In Progress';
							 }
							 if($case_practice_area->priority==0){
							 $prio='High';
							 }else if($case_practice_area->priority==1){
							 $prio='Low';
							 }else{
							 $prio='Medium';
							 }
				$practice_area ='<tr><td>'.esc_html($case_practice_area->task_name).'</td>
					<td><a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr($case_practice_area->case_id).'"</a>'.esc_html($case_name2).'</td>
					<td>'.esc_html(MJ_lawmgt_getdate_in_input_box($case_practice_area->due_date)).'</td>
					<td>'.esc_html($statu).'</td>
					<td>'.esc_html($prio).'</td>
					<td>'.esc_html($case_practice_area->description).'</td>
					<td>'.esc_html(implode($user_name,',')).'</td>
					<td>'.esc_html(implode($contact_name1,',')).'</td>
					<td>'.'<a href="?page=task&tab=view_task&action=view_task&task_id='.esc_attr($case_practice_area->task_id).'" class="btn btn-success">View</a>
					<a href="?page=task&tab=add_task&action=edittask&task_id='.esc_attr($case_practice_area->task_id).'" class="btn btn-info"> Edit</a>
						<a href="?page=task&tab=tasklist&action=deletetask&case_id='.esc_attr($case_practice_area->case_id).'&task_id='.esc_attr($case_practice_area->task_id).'" class="btn btn-danger" 
					onclick="return confirm(Are you sure you want to delete this record?);">
					 Delete</a>'.'
					</td></tr>';	
				$case_data[]=$practice_area;					
		} 
	}
	if(isset($_REQUEST['selection_id'])=='-1')
	{
		$casedata = $wpdb->get_results("SELECT * FROM $table_case");
		foreach($casedata as $case_practice_area)
		{	
		    $user_id= sanitize_text_field($case_practice_area->assigned_to_user);
			$con_id= sanitize_text_field($case_practice_area->assign_to_contact);
			$contac_id=explode(',',$user_id);
			$contac_id1=explode(',',$con_id);
			$user_name=array();
			foreach($contac_id as $contact_name)
			{
				$userdata=get_userdata($contact_name);	
				
				$user_name[]= sanitize_text_field($userdata->display_name);	
					   
			}
					   
			$contact_name1=array();
			foreach($contac_id1 as $contact_name)
			{
				$userdata=get_userdata($contact_name);	
				
				$contact_name1[] = sanitize_text_field($userdata->display_name);	
					   
			}
			$table_case1 = $wpdb->prefix. 'lmgt_cases';		
			$result1 = $wpdb->get_results("SELECT case_name FROM $table_case1 where id=$case_practice_area->case_id");
		
			foreach($result1 as $case_name1)
			{
				$case_name2= sanitize_text_field($case_name1->case_name);
			}	
			if($case_practice_area->status==0){
							 $statu='Not Completed';
							 }else if($case_practice_area->status==1){
							 $statu='Completed';
							 }else{
							 $statu='In Progress';
							 }
							 if($case_practice_area->priority==0){
							 $prio='High';
							 }else if($case_practice_area->priority==1){
							 $prio='Low';
							 }else{
							 $prio='Medium';
							 }
				$practice_area ='<tr><td>'.esc_html($case_practice_area->task_name).'</td>
					<td><a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr($case_practice_area->case_id).'"</a>'.esc_html($case_name2).'</td>
					<td>'.esc_html(MJ_lawmgt_getdate_in_input_box($case_practice_area->due_date)).'</td>
					<td>'.esc_html($statu).'</td>
					<td>'.esc_html($prio).'</td>
					<td>'.esc_html($case_practice_area->description).'</td>
					<td>'.esc_html(implode($user_name,',')).'</td>
					<td>'.esc_html(implode($contact_name1,',')).'</td>
					<td>'.'<a href="?page=task&tab=view_task&action=view_task&task_id='.esc_attr($case_practice_area->task_id).'" class="btn btn-success">View</a>
					<a href="?page=task&tab=add_task&action=edittask&task_id='.esc_attr($case_practice_area->task_id).'" class="btn btn-info"> Edit</a>
						<a href="?page=task&tab=tasklist&action=deletetask&case_id='.esc_attr($case_practice_area->case_id).'&task_id='.esc_attr($case_practice_area->task_id).'" class="btn btn-danger" 
					onclick="return confirm(Are you sure you want to delete this record?);">
					 Delete</a>'.'
					</td></tr>';	
				$case_data[]=$practice_area;					
		} 
	}	
	echo json_encode($case_data);
	
	die();  
}
/*<---  GET USER BY CASE ID FUNCTION --->*/
function MJ_lawmgt_get_user_by_edit_case_id($id)
{  
	 global $wpdb;
	 $table_name = $wpdb->prefix . 'lmgt_case_contacts';
	 return $result = $wpdb->get_results("SELECT user_id FROM $table_name where case_id=$id");
}
/*<---  GET Attorney BY CASE ID FUNCTION --->*/
function MJ_lawmgt_get_attorney_by_edit_case_id($id)
{  
	 global $wpdb;
	 $table_name = $wpdb->prefix . 'lmgt_cases';
	 
	 return $result = $wpdb->get_results("SELECT case_assgined_to FROM $table_name where id=$id");
}
/*<---  get practise arae by class id FUNCTION --->*/
function MJ_lawmgt_get_practicearea_by_class_id($id)
{  
	global $wpdb;
	$table_name = $wpdb->prefix . 'lmgt_cases';
	return $result = $wpdb->get_row("SELECT practice_area_id FROM $table_name where id=$id");
	
}

/*<---  GET USER BY CASE ID FUNCTION --->*/
function MJ_lawmgt_get_user_by_case_id($id)
{  
	 global $wpdb;
	 $table_name = $wpdb->prefix . 'lmgt_case_contacts';
	 return $result = $wpdb->get_results("SELECT * FROM $table_name where case_id=$id");
}
/*<---  GET BILLING USER BY CASE ID FUNCTION --->*/
function MJ_lawmgt_get_billing_user_by_case_id($id)
{  
	 global $wpdb;
	 $table_cases= $wpdb->prefix . 'lmgt_cases';
	 return $result = $wpdb->get_results("SELECT billing_contact_id FROM $table_cases where id=$id");
}
/*<---  GET PRACTICE  BY CASE ID FUNCTION --->*/
function MJ_lawmgt_practice_by_case()
{
		if(isset($_REQUEST['selection_id']))
		{
			$case=sanitize_text_field($_REQUEST['selection_id']);
		}
		else
		{
			$case='';
		}
		
		echo  $class_id =sanitize_text_field($_POST['case_id']);
		global $wpdb;
		$retrieve_data=MJ_lawmgt_get_practicearea_by_class_id($case);
		$defaultmsg=esc_html__( 'Select Users' , 'lawyer_mgt');
		$obj_practicearea=new MJ_lawmgt_practicearea;
			 $practice_id= sanitize_text_field($retrieve_data->practice_area_id);
			 $practice=$obj_practicearea->MJ_lawmgt_get_single_practicearea($practice_id);
		
			$data="<input class='form-control' name='practice_area_id1' id='practice_area_id1' value='".esc_attr($practice->post_title)."' readonly><input class='form-control' type='hidden' name='practice_area_id' id='practice_area_id' value='".esc_attr($practice_id)."'>";
		
		echo json_encode($data);
		die();
		
}
/*<---  GET USER BY CASE  FUNCTION --->*/
function MJ_lawmgt_get_user_by_case()
{
		$case = sanitize_text_field($_REQUEST['selection_id']);
		global $wpdb;
		$retrieve_data=MJ_lawmgt_get_user_by_case_id($case);
		foreach($retrieve_data as $section)
		{
			$userdata=get_userdata($section->user_id);
			echo "<option value='".esc_attr($section->user_id)."'>".esc_html($userdata->display_name)."</option>";
		}
		die();
}
/*<---  GET ATTORNEY BY CASE ID FUNCTION --->*/
function MJ_lawmgt_get_attorney_by_case_id($id)
{  
	 global $wpdb;
	 $table_name = $wpdb->prefix . 'lmgt_cases';
	 $result = $wpdb->get_results("SELECT * FROM $table_name where id=$id");
	 /* var_dump($result);
	 die; */
	 return $result;
}
/*<---  GET Attorney USER BY CASE ID FUNCTION --->*/
function MJ_lawmgt_get_attorney_by_case()
{
	if(isset($_REQUEST['selection_id']))
	{
		$case= sanitize_text_field($_REQUEST['selection_id']);
	}
	else
	{
		$case='';
	}
	 
	global $wpdb;
	$table_case = $wpdb->prefix. 'lmgt_cases';													
	$userdata = $wpdb->get_results("SELECT case_assgined_to FROM $table_case where id=".$case);
	 
	$user_array = sanitize_text_field($userdata[0]->case_assgined_to);
	  
	$newarraay=explode(',',$user_array);
	foreach($newarraay as $section)
	{
		$user_details=get_userdata($section);
		$user_name=$user_details->display_name;
		echo "<option value='".esc_attr($user_details->ID)."'>".esc_html($user_name)."</option>";
	}
	die();
}
/*<---  GET USER BY CASE INVOICE FUNCTION --->*/
function MJ_lawmgt_get_user_by_case_invoice()
{
	if(isset($_REQUEST['invoice_case_id']))
	{
		$invoice_case_id= sanitize_text_field($_REQUEST['invoice_case_id']);
	}
	else
	{
		$invoice_case_id='';
	}
	
	global $wpdb;
	$retrieve_data=MJ_lawmgt_get_billing_user_by_case_id($invoice_case_id);
	foreach($retrieve_data as $section)
	{
		echo "<option value='".esc_attr($section->billing_contact_id)."'>".esc_html(MJ_lawmgt_get_display_name($section->billing_contact_id))."</option>";
	}
	die();
}
 
/*<---  fRONTEND MENU Title FUNCTION --->*/
function MJ_lawmgt_change_menutitle($key)
{
	$menu_titlearray=array('attorney'=>esc_html__('Attorney','lawyer_mgt'),'staff'=>esc_html__('Staff','lawyer_mgt'),'accountant'=>esc_html__('Accountant','lawyer_mgt'),'contacts'=>esc_html__('Clients','lawyer_mgt'),'court'=>esc_html__('Court','lawyer_mgt'),'cases'=>esc_html__('Cases','lawyer_mgt'),'orders'=>esc_html__('Orders','lawyer_mgt'),'judgments'=>esc_html__('Judgments','lawyer_mgt'),'causelist'=>esc_html__('Cause List','lawyer_mgt'),'task'=>esc_html__('Tasks','lawyer_mgt'),'event'=>esc_html__('Events','lawyer_mgt'),'note'=>esc_html__('Notes','lawyer_mgt'),'workflow'=>esc_html__('Workflow','lawyer_mgt'),'documents'=>esc_html__('Documents','lawyer_mgt'),'invoice'=>esc_html__('Invoices','lawyer_mgt'),'rules'=>esc_html__('Rules','lawyer_mgt'),'custom_field'=>esc_html__('Custom Fields','lawyer_mgt'),'report'=>esc_html__('Reports','lawyer_mgt'),'message'=>esc_html__('Messages','lawyer_mgt'),'audit_log'=>esc_html__('Audit Log','lawyer_mgt'),'account'=>esc_html__('Account','lawyer_mgt'));
	
	return $menu_titlearray[$key];
}
/*<---  LOGIN PAGE LINK FUNCTION --->*/
function MJ_lawmgt_login_link()
{
	$args = array( 'redirect' => site_url() );
	
	if(isset($_GET['login']) && sanitize_text_field($_GET['login']) == 'failed')
	{
		?>

	<div id="login-error" class="background_color_FFEBE8_border_1px_solid_C00_padding_5px_css">
	<p><?php esc_html_e('Login failed: You have entered an incorrect Username or password, please try again.','lawyer_mgt'); ?></p>
	</div>
	<?php
	}
	
	$args = array(
			'echo' => true,
			'redirect' => site_url( $_SERVER['REQUEST_URI'] ),
			'form_id' => 'loginform',
			'label_username' => esc_html__( 'Username' , 'lawyer_mgt'),
			'label_password' => esc_html__( 'Password', 'lawyer_mgt' ),
			'label_remember' => esc_html__( 'Remember Me' , 'lawyer_mgt'),
			'label_log_in' => esc_html__( 'Log In' , 'lawyer_mgt'),
			'id_username' => 'user_login',
			'id_password' => 'user_pass',
			'id_remember' => 'rememberme',
			'id_submit' => 'wp-submit',
			'remember' => true,
			'value_username' => NULL,
	        'value_remember' => false ); 
	 $args = array('redirect' => site_url('/?dashboard=user') );
	 
	 if ( is_user_logged_in() )
	 {
		 ?>
		<a href="<?php echo esc_url(home_url('/')."?dashboard=user"); ?>">
		<i class="fa fa-sign-out m-r-xs"></i>
		<?php esc_html_e('Dashboard','lawyer_mgt'); ?>
		</a>
	<?php 
	 }
	 else 
	 {
		wp_login_form( $args );
	 }	 
}	
/*<---  GET CASE TASK FUNCTION --->*/
function MJ_lawmgt_case_stat()
{		

	if(isset($_REQUEST['selection_id']))
	{
		$case = sanitize_text_field($_REQUEST['selection_id']);
	}
	else
	{
		$case='';
	}	
	
	 global $wpdb;
	 $table_case = $wpdb->prefix. 'lmgt_add_task';	
	 $casedata = $wpdb->get_results("SELECT * FROM $table_case where case_id=$case");

	$case_data = array();	
	if(!empty($casedata))
	{
		foreach($casedata as $case_practice_area)
		{
            $user_id = sanitize_text_field($case_practice_area->assigned_to_user);
			$con_id = sanitize_text_field($case_practice_area->assign_to_contact);
			$contac_id=explode(',',$user_id);
			$contac_id1=explode(',',$con_id);
			$user_name=array();
			foreach($contac_id as $contact_name)
			{
				$userdata=get_userdata($contact_name);	
				$user_name[] = sanitize_text_field($userdata->display_name);
					   
			}
						   
			$contact_name1=array();
			foreach($contac_id1 as $contact_name)
			{
				$userdata=get_userdata($contact_name);	
				$contact_name1[] = sanitize_text_field($userdata->display_name);
					   
			}		
			$table_case1 = $wpdb->prefix. 'lmgt_cases';		
			$result1 = $wpdb->get_results("SELECT case_name FROM $table_case1 where id=$case_practice_area->case_id");
		 
			foreach($result1 as $case_name1)
			{
				$case_name2= $case_name1->case_name;
			}	
			if($case_practice_area->status==0){
							 $statu='Not Completed';
							 }else if($case_practice_area->status==1){
							 $statu='Completed';
							 }else{
							 $statu='In Progress';
							 }
							 if($case_practice_area->priority==0){
							 $prio='High';
							 }else if($case_practice_area->priority==1){
							 $prio='Low';
							 }else{
							 $prio='Medium';
							 }
				$practice_area ='<tr><td>'.esc_html($case_practice_area->task_name).'</td>
					<td><a href="?page=cases&tab=casedetails&action=viewlawmgt_case_stat&case_id='.esc_attr($case_practice_area->case_id).'"</a>'.esc_html($case_name2).'</td>
					<td>'.esc_html(MJ_lawmgt_getdate_in_input_box($case_practice_area->due_date)).'</td>
					<td>'.esc_html($statu).'</td>
					<td>'.esc_html($prio).'</td>
					<td>'.esc_html($case_practice_area->description).'</td>
					<td>'.esc_html(implode($user_name,',')).'</td>
					<td>'.'<a href="?page=task&tab=view_task&action=view_task&task_id='.esc_attr($case_practice_area->task_id).'" class="btn btn-success">View</a>
					<a href="?page=task&tab=add_task&action=edittask&task_id='.esc_attr($case_practice_area->task_id).'" class="btn btn-info"> Edit</a>
						<a href="?page=task&tab=tasklist&action=deletetask&case_id='.esc_attr($case_practice_area->case_id).'&task_id='.esc_attr($case_practice_area->task_id).'" class="btn btn-danger" 
					onclick="return confirm(Are you sure you want to delete this record?);">
					 Delete</a>'.'
					</td></tr>';	
				$case_data[]=$practice_area;					
		} 
	}
		if(isset($_REQUEST['selection_id'])=='-1')
		{
			$casedata = $wpdb->get_results("SELECT * FROM $table_case");
			foreach($casedata as $case_practice_area)
			{
				$user_id = sanitize_text_field($case_practice_area->assigned_to_user);
				$con_id = sanitize_text_field($case_practice_area->assign_to_contact);
				$contac_id=explode(',',$user_id);
				$contac_id1=explode(',',$con_id);
				$user_name=array();
				foreach($contac_id as $contact_name)
				{
					$userdata=get_userdata($contact_name);	

					$user_name[]= sanitize_text_field($userdata->display_name);
						   
				}
							   
				$contact_name1=array();
				foreach($contac_id1 as $contact_name)
				{
					$userdata=get_userdata($contact_name);

					$contact_name1[] = sanitize_text_field($userdata->display_name);
						   
				}
				$table_case1 = $wpdb->prefix. 'lmgt_cases';		
				$result1 = $wpdb->get_results("SELECT case_name FROM $table_case1 where id=$case_practice_area->case_id");
				 
				foreach($result1 as $case_name1)
				{
					$case_name2=$case_name1->case_name;
				}			
				if($case_practice_area->status==0){
									 $statu='Not Completed';
									 }else if($case_practice_area->status==1){
									 $statu='Completed';
									 }else{
									 $statu='In Progress';
									 }
									 if($case_practice_area->priority==0){
									 $prio='High';
									 }else if($case_practice_area->priority==1){
									 $prio='Low';
									 }else{
									 $prio='Medium';
									 }
					$practice_area ='<tr><td>'.esc_html($case_practice_area->task_name).'</td>
							<td><a href="?page=cases&tab=casedetails&action=viewlawmgt_case_stat&case_id='.esc_attr($case_practice_area->case_id).'"</a>'.esc_html($case_name2).'</td>
							<td>'.esc_html(MJ_lawmgt_getdate_in_input_box($case_practice_area->due_date)).'</td>
							<td>'.esc_html($statu).'</td>
							<td>'.esc_html($prio).'</td>
							<td>'.esc_html($case_practice_area->description).'</td>
							<td>'.esc_html(implode($user_name,',')).'</td>
							
							<td>'.'<a href="?page=task&tab=view_task&action=view_task&task_id='.esc_attr($case_practice_area->task_id).'" class="btn btn-success">View</a>
							<a href="?page=task&tab=add_task&action=edittask&task_id='.esc_attr($case_practice_area->task_id).'" class="btn btn-info"> Edit</a>
								<a href="?page=task&tab=tasklist&action=deletetask&case_id='.esc_attr($case_practice_area->case_id).'&task_id='.esc_attr($case_practice_area->task_id).'" class="btn btn-danger" 
							onclick="return confirm(Are you sure you want to delete this record?);">
							 Delete</a>'.'
							</td></tr>';	
					$case_data[]=$practice_area;					
			} 
		}	
	echo json_encode($case_data);
	
	die();  
}
/*<---  DOCUMENTS STATUS FILTER FUNCTION --->*/
function MJ_lawmgt_document_status_filter()
{	
	$user_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('documents');
	$document_columns_array=explode(',',get_option('lmgt_document_columns_option'));
	if(isset($_REQUEST['selection_id']))
	{
		$selection_id= sanitize_text_field($_REQUEST['selection_id']);
	}
	else
	{
		$selection_id='';
	}
	if(isset($_REQUEST['case_id']))
	{
		$hidden_case_id= sanitize_text_field($_REQUEST['case_id']);
	}
	else
	{
		$hidden_case_id='';
	}
	
	$user_role=MJ_lawmgt_get_current_user_role();
	
	$obj_documents=new MJ_lawmgt_documents;
    
	if(!empty($hidden_case_id))
	{
		if($selection_id == '-1')
		{	
			$documentdata=$obj_documents->MJ_lawmgt_get_casewise_all_documents($hidden_case_id);	
		}	
		elseif($selection_id == '0')
		{
			$documentdata=$obj_documents->MJ_lawmgt_get_casewise_all_read_documents($hidden_case_id);	
		}
		elseif($selection_id == '1')
		{			
			$documentdata=$obj_documents->MJ_lawmgt_get_casewise_all_unread_documents($hidden_case_id);
		}
	}
	else
	{	
		if($selection_id == '-1')
		{			
			if($user_role == 'attorney')
			{
				if($user_access['own_data'] == '1')
				{
					$documentdata=$obj_documents->MJ_lawmgt_get_all_documents_by_attorney();
				}
				else
				{
					$documentdata=$obj_documents->MJ_lawmgt_get_all_documents();	
				}	
			}
			elseif($user_role == 'client')
			{
				if($user_access['own_data'] == '1')
				{
					$documentdata=$obj_documents->MJ_lawmgt_get_all_documents_by_client();	
				}
				else
				{
					$documentdata=$obj_documents->MJ_lawmgt_get_all_documents();	
				}
			}
			else
			{
				
				if($user_access['own_data'] == '1')
				{
					$documentdata=$obj_documents->MJ_lawmgt_get_all_documents_created_by();	
				}
				else
				{
					 
					$documentdata=$obj_documents->MJ_lawmgt_get_all_documents();	
				}				
			}
		}	
		elseif($selection_id == '0')
		{
			if($user_role == 'attorney')
			{
				if($user_access['own_data'] == '1')
				{
					$documentdata=$obj_documents->MJ_lawmgt_get_all_read_documents_by_attorney();
				}
				else
				{
					$documentdata=$obj_documents->MJ_lawmgt_get_all_read_documents();	
				}
			}
			elseif($user_role == 'client')
			{
				if($user_access['own_data'] == '1')
				{
					$documentdata=$obj_documents->MJ_lawmgt_get_all_read_documents_by_client();
				}
				else
				{
					$documentdata=$obj_documents->MJ_lawmgt_get_all_read_documents();	
				}		
			}
			else
			{
				if($user_access['own_data'] == '1')
				{
					$documentdata=$obj_documents->MJ_lawmgt_get_all_read_documents_craeted_by();	
				}
				else
				{
					$documentdata=$obj_documents->MJ_lawmgt_get_all_read_documents();	
				}
			}	
		}
		elseif($selection_id == '1')
		{
			if($user_role == 'attorney')
			{
				if($user_access['own_data'] == '1')
				{
					$documentdata=$obj_documents->MJ_lawmgt_get_all_unread_documents_by_attorney();
				}
				else
				{
					$documentdata=$obj_documents->MJ_lawmgt_get_all_unread_documents();	
				}	
			}
			elseif($user_role == 'client')
			{
				if($user_access['own_data'] == '1')
				{
					$documentdata=$obj_documents->MJ_lawmgt_get_all_unread_documents_by_client();	
				}
				else
				{
					$documentdata=$obj_documents->MJ_lawmgt_get_all_unread_documents();	
				}	
			}
			else
			{
				if($user_access['own_data'] == '1')
				{
					$documentdata=$obj_documents->MJ_lawmgt_get_all_unread_documents_created_by();
				}
				else
				{
					$documentdata=$obj_documents->MJ_lawmgt_get_all_unread_documents();
				}			
			}	
		}
	}
		
	$document_filter_data = array();	
	global $wpdb;		
	$table_cases = $wpdb->prefix. 'lmgt_cases';
	if(!empty($documentdata))
	{
		foreach($documentdata as $retrieved_data)
		{
			$case_id=$retrieved_data->case_id;			
			$case_name= $wpdb->get_row("SELECT case_name FROM $table_cases where id=".$case_id);
			$status=$obj_documents->MJ_lawmgt_check_documents_status_by_user($retrieved_data->id);
			   
			$document_row ='<tr>	
				<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="'.esc_attr($retrieved_data->id).'"></td>';
				if(in_array('document_title',$document_columns_array))
				{	
					$document_row.='<td class="title">'.esc_html($retrieved_data->title).'</a></td>';
				}
				if(in_array('document_type',$document_columns_array))
				{
					$document_row.='<td class="title">'.esc_html($retrieved_data->type).'</a></td>';
				}	
				if(in_array('document_case_link',$document_columns_array))
				{
					$document_row.='<td class="case_link">';
					if($user_role == 'administrator')
					{
						$document_row.='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id)).'">'.esc_html($case_name->case_name).'</a>';
					}
					else
					{
						$document_row.='<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id)).'">'.esc_html($case_name->case_name).'</a>';
					}		
					$document_row.='</td>';
				}
				if(in_array('tag_name',$document_columns_array))
				{
					$document_row.='<td class="tags_name">'.esc_html($retrieved_data->tag_names).'</td>';
				}
				if(in_array('status',$document_columns_array))
				{
					$document_row.='<td class="tags_name">'.esc_html($status).'</td>';
				}
				if(in_array('last_updated',$document_columns_array))
				{
					$document_row.='<td class="last_update">'.esc_html($retrieved_data->last_update).'</td>';
				}
				if(in_array('document_description',$document_columns_array))
				{
					$document_row.='<td class="last_update">'.esc_html($retrieved_data->document_description).'</td>';
				}
				$document_row.='<td class="action"> 				
				<a href="'.esc_url(content_url().'/uploads/document_upload/'.esc_attr($retrieved_data->document_url)).'" class="status_read btn btn-default" record_id="'.esc_attr($retrieved_data->id).'"><i class="fa fa-download"></i>Download</a>';	
				if(!empty($hidden_case_id))
				{
					if($user_role == 'administrator')
					{
						$document_row .='<a href="?page=cases&tab=casedetails&action=view&tab2=documents&tab3=adddocuments&edit=true&case_id='.sanitize_text_field(MJ_lawmgt_id_encrypt($_REQUEST['case_id'])).'&documents_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'" class="btn btn-info">'.esc_html__('Edit','lawyer_mgt').'</a>
						<a href="?page=cases&tab=casedetails&action=view&deletedocuments=true&tab2=documents&tab3=documentslist&case_id='.sanitize_text_field(MJ_lawmgt_id_encrypt($_REQUEST['case_id'])).'&documents_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'" class="btn btn-danger" 
						onclick="return confirm(Are you sure you want to delete this record?);">
						'.esc_html__('Delete','lawyer_mgt').'</a>';	
					}
					else
					{
						if($user_access['edit']=='1')
						{
							$document_row .='<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=documents&tab3=adddocuments&edit=true&case_id='.sanitize_text_field(MJ_lawmgt_id_encrypt($_REQUEST['case_id'])).'&documents_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'" class="btn btn-info">'.esc_html__('Edit','lawyer_mgt').'</a>';
						}
						if($user_access['delete']=='1')
						{
							$document_row .='<a href="?dashboard=user&page=cases&tab=casedetails&action=view&deletedocuments=true&tab2=documents&tab3=documentslist&case_id='.sanitize_text_field(MJ_lawmgt_id_encrypt($_REQUEST['case_id'])).'&documents_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'" class="btn btn-danger" 
							onclick="return confirm(Are you sure you want to delete this record?);">
							'.esc_html__('Delete','lawyer_mgt').'</a>';	
						}
					}		
				}
				else
				{					
					if($user_role == 'administrator')
					{
						$document_row .='<a href="?page=documents&tab=add_documents&action=edit&documents_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'" class="btn btn-info">'.esc_html__('Edit','lawyer_mgt').'</a>
						<a href="?page=documents&tab=documentslist&action=delete&case_id='.esc_attr(MJ_lawmgt_id_encrypt($case_id)).'&documents_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'" class="btn btn-danger" 
						onclick="return confirm(Are you sure you want to delete this record?);">
						'.esc_html__('Delete','lawyer_mgt').'</a>';
					}
					else
					{
						if($user_access['edit']=='1')
						{
							$document_row .='<a href="?dashboard=user&page=documents&tab=add_documents&action=edit&&documents_id='.sanitize_text_field(MJ_lawmgt_id_encrypt($_REQUEST['case_id'])).'&documents_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'" class="btn btn-info">'.esc_html__('Edit','lawyer_mgt').'</a>';
						}
						if($user_access['delete']=='1')
						{
							$document_row .='<a href="?dashboard=user&page=documents&tab=documentslist&action=delete&&case_id='.sanitize_text_field(MJ_lawmgt_id_encrypt($_REQUEST['case_id'])).'&documents_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'" class="btn btn-danger" 
							onclick="return confirm(Are you sure you want to delete this record?);">
						'.esc_html__('Delete','lawyer_mgt').'</a>';
						}
					}	
				}	
				$document_row .='</td>               
			</tr>';			
			$document_filter_data[]=$document_row;					
		} 
	}	
	echo json_encode($document_filter_data);
	die();  
}
function MJ_lawmgt_fronted_document_status_filter()
{			
	$selection_id= sanitize_text_field($_REQUEST['selection_id']);
	$hidden_case_id = sanitize_text_field($_REQUEST['case_id']);
	$user_role=MJ_lawmgt_get_current_user_role();
	
	$obj_documents=new MJ_lawmgt_documents;

	if(!empty($hidden_case_id))
	{
		if($selection_id=='-1')
		{
			$documentdata=$obj_documents->MJ_lawmgt_get_casewise_all_documents($case_id);	
		}	
		elseif($selection_id=='0')
		{
			$documentdata=$obj_documents->MJ_lawmgt_get_casewise_all_read_documents($case_id);	
		}
		elseif($selection_id=='1')
		{
			$documentdata=$obj_documents->MJ_lawmgt_get_casewise_all_unread_documents($case_id);	
		}
	}
	else
	{
		if($selection_id=='-1')
		{
			if($user_role == 'attorney')
			{
				$documentdata=$obj_documents->MJ_lawmgt_get_all_documents_by_attorney();
			}
			elseif($user_role == 'client')
			{
				$documentdata=$obj_documents->MJ_lawmgt_get_all_documents_by_client();	
			}
			else
			{
				$documentdata=$obj_documents->MJ_lawmgt_get_all_documents();	
			}	
		}	
		elseif($selection_id=='0')
		{
			if($user_role == 'attorney')
			{
				$documentdata=$obj_documents->MJ_lawmgt_get_all_read_documents_by_attorney();
			}
			elseif($user_role == 'client')
			{
				$documentdata=$obj_documents->MJ_lawmgt_get_all_read_documents_by_client();	
			}
			else
			{
				$documentdata=$obj_documents->MJ_lawmgt_get_all_read_documents();	
			}	
		}
		elseif($selection_id=='1')
		{
			if($user_role == 'attorney')
			{
				$documentdata=$obj_documents->MJ_lawmgt_get_all_unread_documents_by_attorney();
			}
			elseif($user_role == 'client')
			{
				$documentdata=$obj_documents->MJ_lawmgt_get_all_unread_documents_by_client_by_client();	
			}
			else
			{
				$documentdata=$obj_documents->MJ_lawmgt_get_all_unread_documents();	
			}	
		}
	}
		
	$document_filter_data = array();	
	global $wpdb;		
	$table_cases = $wpdb->prefix. 'lmgt_cases';
	if(!empty($documentdata))
	{
		foreach($documentdata as $retrieved_data)
		{
			$case_id=$retrieved_data->case_id;			
			$case_name= $wpdb->get_row("SELECT case_name FROM $table_cases where id=".$case_id);
			$status=$obj_documents->MJ_lawmgt_check_documents_status_by_user($retrieved_data->id);
			
			$document_row ='<tr>				
				<td class="title">'.esc_html($retrieved_data->title).'</a></td>				
				<td class="title">'.esc_html($retrieved_data->type).'</a></td>				
				<td class="case_link"><a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr($retrieved_data->case_id).'">'.esc_html($case_name->case_name).'</a></td>
				<td class="tags_name">'.esc_html($retrieved_data->tag_names).'</td>
				<td class="tags_name">'.esc_html($status).'</td>					
				<td class="last_update">'.esc_html($retrieved_data->last_update).'</td>
				<td class="action"> 				
				<a href="'.content_url().'/uploads/document_upload/'.$retrieved_data->document_url.'" class="status_read btn btn-default" record_id="'.esc_attr($retrieved_data->id).'"><i class="fa fa-download"></i>'.esc_html__('Download','lawyer_mgt').'</a>';	
				if(!empty($hidden_case_id))
				{
					$document_row .='<a href="?page=cases&tab=casedetails&action=view&tab2=documents&tab3=adddocuments&edit=true&case_id='.sanitize_text_field($_REQUEST['case_id']).'&documents_id='.esc_attr($retrieved_data->id).'" class="btn btn-info">'.esc_html__('Edit','lawyer_mgt').'</a>
					<a href="?page=cases&tab=casedetails&action=view&deletedocuments=true&tab2=documents&tab3=documentslist&case_id='.sanitize_text_field($_REQUEST['case_id']).'&documents_id='.esc_attr($retrieved_data->id).'" class="btn btn-danger" 
					onclick="return confirm(Are you sure you want to delete this record?);">
					'.esc_html__('Delete','lawyer_mgt').'</a>';	
				}
				else
				{
					$document_row .='<a href="?dashboard=user&page=documents&tab=add_documents&action=edit&&documents_id='.esc_attr($retrieved_data->id).'" class="btn btn-info">'.esc_html__('Edit','lawyer_mgt').'</a>
					<a href="?dashboard=user&page=documents&tab=documentslist&action=delete&&case_id='.$case_id.'&documents_id='.esc_attr($retrieved_data->id).'" class="btn btn-danger" 
					onclick="return confirm(Are you sure you want to delete this record?);">
					'.esc_html__('Delete','lawyer_mgt').'</a>';	
				}	
				$document_row .='</td>               
			</tr>';			
			$document_filter_data[]=$document_row;					
		} 
	}	
	echo json_encode($document_filter_data);
	
	die();  
}
//Task filter End	
function MJ_lawmgt_get_countery_phonecode($country_name)
{
	$url = plugins_url( 'countrylist.xml', __FILE__ );
	$xml=simplexml_load_file(plugins_url( 'countrylist.xml', __FILE__ )) or die("Error: Cannot create object");
	
	foreach($xml as $country)
	{
		if($country_name == $country->name)
			return $country->phoneCode;
	}
}
// file upload validation
function MJ_lawmgt_check_image_valid_extension($filename)
{
	$flag = 2;
	if($filename != '')
	{
		$flag = 0;
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$valid_extension = ['gif','png','jpg','jpeg'];
		if(in_array($ext,$valid_extension) )
		{
			$flag = 1;
		}
	}
	return $flag;
}
// file validation extation
function MJ_lawmgt_check_file_valid_extension($filename)
{
	$flag = 2;
	if($filename != '')
	{
		$flag = 0;
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$valid_extension = ['pdf'];
		if(in_array($ext,$valid_extension) )
		{
			$flag = 1;
		}
	}
	return $flag;
}
// SEND MAIL FUNCTION 	
function MJ_lawmgt_send_mail($emails,$subject,$message)
{	
    $system_name=get_option('lmgt_system_name');
	
	$headers="";
	$headers .= 'From: '.$system_name.' <noreplay@gmail.com>' . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
	
	wp_mail($emails,$subject,$message,$headers);
	
}
//mail fuction for invoice  generated
function MJ_lawmgt_send_invoice_generate_mail($emails,$subject,$message,$invoice_id)
{
	$document_dir = WP_CONTENT_DIR;
	$document_dir .= '/uploads/invoice/';
	$document_path = $document_dir;
	if (!file_exists($document_path))
	{
		mkdir($document_path, 0777, true);		
	}
	
	$obj_case=new MJ_lawmgt_case;
	$obj_invoice=new MJ_lawmgt_invoice;
	$invoice_info=$obj_invoice->MJ_lawmgt_get_single_invoice($invoice_id);	
	$user_id=sanitize_text_field($invoice_info->user_id);	
	$case_id=sanitize_text_field($invoice_info->case_id);
	$case_info = $obj_case->MJ_lawmgt_get_single_case($case_id);	
	$user_info=get_userdata($user_id); 	
	$discount_per=sanitize_text_field($invoice_info->discount);
	
	wp_enqueue_style( 'bootstrap-css', plugins_url( '/assets/css/bootstrap.css', __FILE__) );
	wp_enqueue_style( 'style-css', plugins_url( '/assets/css/style.css', __FILE__) );
	wp_enqueue_script('bootstrap-js', plugins_url( '/assets/js/bootstrap.js', __FILE__ ) );

	header('Content-type: application/pdf');
	header('Content-Disposition: inline; filename="invoice.pdf"');
	header('Content-Transfer-Encoding: binary');
	header('Accept-Ranges: bytes');	
	require LAWMS_PLUGIN_DIR. '/lib/mpdf/mpdf.php';	
	$stylesheet = wp_enqueue_style( 'bootstrap-css', plugins_url( '/assets/css/style.css', __FILE__) );
	$mpdf	=	new mPDF('c','A4','','' , 5 , 5 , 5 , 0 , 0 , 0); 
	$mpdf->debug = true;
	$mpdf->WriteHTML('<html>');
	$mpdf->WriteHTML('<head>');
	$mpdf->WriteHTML('<style></style>');
	$mpdf->WriteHTML($stylesheet,1); // Writing style to pdf
	$mpdf->WriteHTML('</head>');
	$mpdf->WriteHTML('<body>');		
	$mpdf->SetTitle('Invoice');

	$mpdf->WriteHTML('<div id="invoice_print">');		
			$mpdf->WriteHTML('<img class="invoicefont1" src="'.plugins_url('/lawyers-management/assets/images/invoice.jpg').'" width="100%">');
			$mpdf->WriteHTML('<div class="main_div">');	
			
					$mpdf->WriteHTML('<table class="width_100_print" border="0">');					
					$mpdf->WriteHTML('<tbody>');
						$mpdf->WriteHTML('<tr>');
							$mpdf->WriteHTML('<td class="width_1_print">');
								$mpdf->WriteHTML('<img class="system_logo system_logo_print"  src="'.esc_url(get_option( 'lmgt_system_logo' )).'">');
							$mpdf->WriteHTML('</td>');							
							$mpdf->WriteHTML('<td class="only_width_20_print">');	
								$mpdf->WriteHTML('<table border="0">');					
								$mpdf->WriteHTML('<tbody>');
									$mpdf->WriteHTML('<tr>');																	
										$mpdf->WriteHTML('<td class="padding_bottom_20_pc_css">');
											$mpdf->WriteHTML('<b class="font_family">'.esc_html__('Address ','lawyer_mgt').':</b>');
										$mpdf->WriteHTML('</td>');	
										$mpdf->WriteHTML('<td class="padding_left_5 table_td_font font_family">'.chunk_split(esc_html(get_option( 'lmgt_address' )),20,"<BR>").'');
										$mpdf->WriteHTML('</td>');											
									$mpdf->WriteHTML('</tr>');
									$mpdf->WriteHTML('<tr>');																	
										$mpdf->WriteHTML('<td><b class="font_family">'.esc_html__('Email ','lawyer_mgt').' :</b>');
										$mpdf->WriteHTML('</td>');	
										$mpdf->WriteHTML('<td class="padding_left_5 table_td_font font_family">'.esc_html(get_option( 'lmgt_email' ))."<br>".'');
										$mpdf->WriteHTML('</td>');	
									$mpdf->WriteHTML('</tr>');
									$mpdf->WriteHTML('<tr>');																	
										$mpdf->WriteHTML('<td>');
											$mpdf->WriteHTML('<b class="font_family">'.esc_html__('Phone ','lawyer_mgt').' :</b>');
										$mpdf->WriteHTML('</td>');	
										$mpdf->WriteHTML('<td class="padding_left_5 table_td_font font_family">'.esc_html(get_option( 'lmgt_contact_number' ))."<br>".'');
										$mpdf->WriteHTML('</td>');											
									$mpdf->WriteHTML('</tr>');
								$mpdf->WriteHTML('</tbody>');
							$mpdf->WriteHTML('</table>');
							$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('<td align="right" class="width_24">');
							$mpdf->WriteHTML('</td>');
						$mpdf->WriteHTML('</tr>');
					$mpdf->WriteHTML('</tbody>');
				$mpdf->WriteHTML('</table>');
				
				$mpdf->WriteHTML('<table>');
			 $mpdf->WriteHTML('<tr>');
				$mpdf->WriteHTML('<td>');
				
					$mpdf->WriteHTML('<table class="width_50_print"  border="0">');
						$mpdf->WriteHTML('<tbody>');				
						$mpdf->WriteHTML('<tr>');
							$mpdf->WriteHTML('<td colspan="2" class="billed_to_print" align="center">');								
								$mpdf->WriteHTML('<h3 class="billed_to_lable font_family"> | '.esc_html__('Bill To ','lawyer_mgt').'. </h3>');
							$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('<td class="width_40_print">');	
									
									$mpdf->WriteHTML('<h3 class="display_name font_family">'.chunk_split(ucwords(esc_html($user_info->display_name)),30,"<BR>").'</h3>'); 
									$address=$user_info->address;										
									$mpdf->WriteHTML(''.chunk_split(esc_html($address),30,"<BR>").''); 
									  $mpdf->WriteHTML(''.esc_html($user_info->city_name).','); 
									 $mpdf->WriteHTML(''.esc_html($user_info->pin_code).'<br>'); 
									 $mpdf->WriteHTML(''.esc_html($user_info->mobile).'<br>'); 
								
							 $mpdf->WriteHTML('</td>');
						 $mpdf->WriteHTML('</tr>');									
					 $mpdf->WriteHTML('</tbody>');
				 $mpdf->WriteHTML('</table>');
				
				$mpdf->WriteHTML('</td>');
				$mpdf->WriteHTML('<td>');
				
				   $mpdf->WriteHTML('<table class="width_50_print"  border="0">');
					 $mpdf->WriteHTML('<tbody>');				
						 $mpdf->WriteHTML('<tr>');	
							 $mpdf->WriteHTML('<td class="width_30_print">');
							 $mpdf->WriteHTML('</td>');
							 $mpdf->WriteHTML('<td class="width_20_print invoice_lable align_center">');
								
									$issue_date=MJ_lawmgt_getdate_in_input_box($invoice_info->generated_date);						
									$payment_status= sanitize_text_field($invoice_info->payment_status);
									$invoice_no = sanitize_text_field($invoice_info->invoice_number);
																
									$mpdf->WriteHTML('<h3 class="invoice_color font_family"><span class="font_size_12_px_css">'.esc_html__('INVOICE','lawyer_mgt').' #<br></span><span class="font_size_18_px_css" >'.esc_html($invoice_no).'</span>');									
																							
							 $mpdf->WriteHTML('</td>');							
						 $mpdf->WriteHTML('</tr>');
						 $mpdf->WriteHTML('<tr>');	
							 $mpdf->WriteHTML('<td class="width_30_print">');
							 $mpdf->WriteHTML('</td>');
							 $mpdf->WriteHTML('<td class="width_20_print" align="center">');
								$mpdf->WriteHTML('<h5 class="h5_pdf font_family align_center">'.esc_html__('Date ','lawyer_mgt').' : '.$issue_date.'</h5>');
							$mpdf->WriteHTML('<h5 class="h5_pdf font_family align_center">'.esc_html__('Status ','lawyer_mgt').' : '.esc_html__(''.$payment_status.' ','lawyer_mgt').'</h5>');											
							 $mpdf->WriteHTML('</td>');							
						 $mpdf->WriteHTML('</tr>');						
					 $mpdf->WriteHTML('</tbody>');
				 $mpdf->WriteHTML('</table>');	
				$mpdf->WriteHTML('</td>');
			  $mpdf->WriteHTML('</tr>');
			$mpdf->WriteHTML('</table>');
			
			$mpdf->WriteHTML('<table class="width_100_print">');	
				$mpdf->WriteHTML('<tbody>');	
					$mpdf->WriteHTML('<tr>');
						$mpdf->WriteHTML('<td class="padding_left_20_px_css">');
							$mpdf->WriteHTML('<h3 class="entry_lable font_family">'.esc_html__('Time Entries ','lawyer_mgt').'</h3>');
						$mpdf->WriteHTML('</td>');	
					$mpdf->WriteHTML('</tr>');	
				$mpdf->WriteHTML('</tbody>');
			$mpdf->WriteHTML('</table>');
				
				$id=1;
					$result_time=$obj_invoice->MJ_lawmgt_get_single_invoice_time_entry($invoice_id);
					$time_entry_sub_total=0;
					$time_entry_discount=0;
					$time_entry_total_tax=0;
					$time_entry_total_amount=0;
					if(!empty($result_time))
					{	
						$mpdf->WriteHTML('<table class="table table-bordered table_row_color" class="width_93" border="1">');
						$mpdf->WriteHTML('<thead>');
												
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center padding_10_pdf">#</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('DATE','lawyer_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_left font_family padding_10_pdf">'.esc_html__('TIME ENTRY ACTIVITY ','lawyer_mgt').'</th>');						
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('HOURS','lawyer_mgt').'</th>');
								 
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('AMOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('DISCOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('TAX','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('TOTAL AMOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');
							$mpdf->WriteHTML('</tr>');						
						
					$mpdf->WriteHTML('</thead>');
					$mpdf->WriteHTML('<tbody>');
					
							
						foreach($result_time as $data)
						{ 
							$time_entry_sub= sanitize_text_field($data->subtotal);							
							$discount= $time_entry_sub/100 * $data->time_entry_discount;
							$time_entry_discount+=$discount;
							$after_discount_time_entry_sub=$time_entry_sub-$discount;
							$tax= sanitize_text_field($data->time_entry_tax);
							$tax1_total_amount='0';
								
							if(!empty($tax))
							{
								$tax_explode=explode(",",$tax);

								$total_tax=0;
							
								foreach($tax_explode as $tax1)
								{
									$taxvalue=MJ_lawmgt_tax_value_by_id($tax1);
									$total_tax+=$taxvalue->tax_value;
								} 
								if(!empty($total_tax))
								{	
									$tax1_total_amount=$after_discount_time_entry_sub / 100 * $total_tax ;
								}
							}
								//$total_tax=$after_discount_time_entry_sub / 100 * $tax1 + $after_discount_time_entry_sub / 100 * $tax2;
							$time_entry_total_tax+=$tax1_total_amount;
							$time_entry_sub_total+=$time_entry_sub;	
							$time_entry_total_sub_amount=$time_entry_sub - $discount + $tax1_total_amount;
							$time_entry_total_amount+=$time_entry_total_sub_amount;
							$bg_color = $id % 2 === 0 ? "#cad5f5" : "white";
							if($bg_color == 'white')
							{
								$bg_color_css='pdf_background_color_td_css_white';
							}
							else
							{
								$bg_color_css='pdf_background_color_td_css_blue';
							}
							
						  	$mpdf->WriteHTML('<tr class="entry_list '.$bg_color_css.'">');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($id).'</td>');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html(MJ_lawmgt_getdate_in_input_box($data->time_entry_date)).'</td>');
								$mpdf->WriteHTML('<td class="table_td_font padding_10_pdf">'.esc_html($data->time_entry).'</td>');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($data->hours).'</td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($data->subtotal),2).'</td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($discount),2).'</td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($tax1_total_amount),2).'</td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($time_entry_total_sub_amount),2).'</td>');
						 	$mpdf->WriteHTML(' </tr>');
						
						$id=$id+1;
						}
							
							$mpdf->WriteHTML('<tr class="entry_list">');							
								$mpdf->WriteHTML('<td colspan="7" class="align_right table_td_font font_family padding_10_pdf">'.esc_html__('Time Entries Total Amount ','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($time_entry_total_amount),2).'</td>');	
						 	$mpdf->WriteHTML('</tr>');						
									
					
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
				}
					$id=1;
			$result_expence=$obj_invoice->MJ_lawmgt_get_single_invoice_expenses($invoice_id);
			$expense_sub_total=0;
			$expense_discount=0;
			$expense_total_tax=0;
			$expense_entry_total_amount=0;
			if(!empty($result_expence))
			{	
				$mpdf->WriteHTML('<table class="width_100_print">');	
				$mpdf->WriteHTML('<tbody>');	
					$mpdf->WriteHTML('<tr>');
						$mpdf->WriteHTML('<td class="padding_left_20_px_css">');
							$mpdf->WriteHTML('<h3 class="entry_lable font_family">'.esc_html__('Expenses Entries ','lawyer_mgt').'</h3>');
						$mpdf->WriteHTML('</td>');	
					$mpdf->WriteHTML('</tr>');	
				$mpdf->WriteHTML('</tbody>');
			$mpdf->WriteHTML('</table>');				
			
				
				$mpdf->WriteHTML('<table class="table table-bordered table_row_color" class="width_93" border="1">');
					$mpdf->WriteHTML('<thead>');
											
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center padding_10_pdf">#</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('DATE','lawyer_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_left font_family padding_10_pdf">'.esc_html__('EXPENSES ACTIVITY','lawyer_mgt').'</th>');						
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('QUANTITY ','lawyer_mgt').'</th>');
								 
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('AMOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('DISCOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('TAX','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('TOTAL AMOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');
								
							$mpdf->WriteHTML('</tr>');						
						
					$mpdf->WriteHTML('</thead>');
					$mpdf->WriteHTML('<tbody>');
					
							
						foreach($result_expence as $data)
						{ 							
							$expense_sub= sanitize_text_field($data->subtotal);
							$discount=$expense_sub/100 * $data->expenses_entry_discount;							
							$expense_discount+=$discount;
							$after_discount_expense=$expense_sub-$discount;
							$tax=sanitize_text_field($data->expenses_entry_tax);
							$tax1_total_amount='0';
								
							if(!empty($tax))
							{
								$tax_explode=explode(",",$tax);

								$total_tax=0;
							
								foreach($tax_explode as $tax1)
								{
									$taxvalue=MJ_lawmgt_tax_value_by_id($tax1);
									$total_tax+=$taxvalue->tax_value;
								} 
								if(!empty($total_tax))
								{	
									$tax1_total_amount=$after_discount_expense / 100 * $total_tax ;
								}
							}
							 
							$expense_total_tax+=$tax1_total_amount;
							$expense_sub_total+=$expense_sub;
							$expense_entry_total_sub_amount=$expense_sub - $discount + $tax1_total_amount;
							$expense_entry_total_amount+=$expense_entry_total_sub_amount;
							
							$bg_color = $id % 2 === 0 ? "#cad5f5" : "white";
							if($bg_color == 'white')
							{
								$bg_color_css='pdf_background_color_td_css_white';
							}
							else
							{
								$bg_color_css='pdf_background_color_td_css_blue';
							}
						  	$mpdf->WriteHTML('<tr class="entry_list '.$bg_color_css.'">');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($id).'</td>');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html(MJ_lawmgt_getdate_in_input_box($data->expense_date)).'</td>');
								$mpdf->WriteHTML('<td class="table_td_font padding_10_pdf">'.esc_html($data->expense).'</td>');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($data->quantity).'</td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($data->subtotal),2).'</td>');								
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($discount),2).'</td>');								
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($tax1_total_amount),2).'</td>');								
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($expense_entry_total_sub_amount),2).'</td>');								
						 	$mpdf->WriteHTML(' </tr>');
						
							$id=$id+1;
						}
							
							$mpdf->WriteHTML('<tr class="entry_list">');							
								$mpdf->WriteHTML('<td colspan="7" class="align_right table_td_font font_family padding_10_pdf">'.esc_html__('Expenses Entries Total Amount ','lawyer_mgt').' ('.MJ_lawmgt_get_currency_symbol().')</td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($expense_entry_total_amount),2).'</td>');	
						 	$mpdf->WriteHTML('</tr>');						
									
					
					$mpdf->WriteHTML('</tbody>');
				$mpdf->WriteHTML('</table>');
			}	
			$id=1;
			$result_flat=$obj_invoice->MJ_lawmgt_get_single_invoice_flat_fee($invoice_id);
			$flat_fee_sub_total=0;
			$flat_fee_discount=0;
			$flat_fee_total_tax=0;
			$flat_entry_total_amount=0;
			if(!empty($result_flat))
			{			
					$mpdf->WriteHTML('<table class="width_100_print">');	
				$mpdf->WriteHTML('<tbody>');	
					$mpdf->WriteHTML('<tr>');
						$mpdf->WriteHTML('<td class="padding_left_20_px_css">');
							$mpdf->WriteHTML('<h3 class="entry_lable font_family">'.esc_html__('Flat Fees Entries ','lawyer_mgt').'</h3>');
						$mpdf->WriteHTML('</td>');	
					$mpdf->WriteHTML('</tr>');	
				$mpdf->WriteHTML('</tbody>');
			$mpdf->WriteHTML('</table>');				
			
				
				$mpdf->WriteHTML('<table class="table table-bordered table_row_color" class="width_93" border="1">');
					$mpdf->WriteHTML('<thead>');
											
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center padding_10_pdf">#</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('DATE','lawyer_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_left font_family padding_10_pdf">'.esc_html__('FLATE FEE ACTIVITY','lawyer_mgt').'</th>');						
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('QUANTITY ','lawyer_mgt').'</th>');
								 
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('AMOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');								
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('DISCOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');								
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('TAX','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');								
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('TOTAL AMOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');								
							$mpdf->WriteHTML('</tr>');						
						
					$mpdf->WriteHTML('</thead>');
					$mpdf->WriteHTML('<tbody>');
					
					
						foreach($result_flat as $data)
						{							
								$flat_fee_sub= sanitize_text_field($data->subtotal);
								$discount=$flat_fee_sub/100 * $data->flat_entry_discount;							
								$flat_fee_discount+=$discount;
								$after_discount_flat_fee=$flat_fee_sub-$discount;
								$tax= sanitize_text_field($data->flat_entry_tax);
								$tax1_total_amount='0';
								
								if(!empty($tax))
								{
									$tax_explode=explode(",",$tax);

									$total_tax=0;
								
									foreach($tax_explode as $tax1)
									{
										$taxvalue=MJ_lawmgt_tax_value_by_id($tax1);
										$total_tax+=$taxvalue->tax_value;
									} 
									if(!empty($total_tax))
									{	
										$tax1_total_amount=$after_discount_flat_fee / 100 * $total_tax ;
									}
								}
								$flat_fee_total_tax+=$tax1_total_amount;
								$flat_fee_sub_total+=$flat_fee_sub;	
								$flat_entry_total_sub_amount=$flat_fee_sub - $discount + $tax1_total_amount;
								$flat_entry_total_amount+=$flat_entry_total_sub_amount;	
							$bg_color = $id % 2 === 0 ? "#cad5f5" : "white";
							if($bg_color == 'white')
							{
								$bg_color_css='pdf_background_color_td_css_white';
							}
							else
							{
								$bg_color_css='pdf_background_color_td_css_blue';
							}							
						  	$mpdf->WriteHTML('<tr class="entry_list '.$bg_color_css.'">');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($id).'</td>');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html(MJ_lawmgt_getdate_in_input_box($data->flat_fee_date)).'</td>');
								$mpdf->WriteHTML('<td class="table_td_font padding_10_pdf">'.esc_html($data->flat_fee).'</td>');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($data->quantity).'</td>');
								 
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($data->subtotal),2).'</td>');								
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($discount),2).'</td>');								
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($tax1_total_amount),2).'</td>');								
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($flat_entry_total_sub_amount),2).'</td>');								
						 	$mpdf->WriteHTML(' </tr>');
						
							$id=$id+1;
						}
							
							$mpdf->WriteHTML('<tr class="entry_list">');							
								$mpdf->WriteHTML('<td colspan="7" class="align_right table_td_font font_family padding_10_pdf">'.esc_html__('Flat Fees Total Amount ','lawyer_mgt').' ('.MJ_lawmgt_get_currency_symbol().')</td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($flat_entry_total_amount),2).'</td>');	
						 	$mpdf->WriteHTML('</tr>');						
									
					$mpdf->WriteHTML('</tbody>');
				$mpdf->WriteHTML('</table>');
			}			
				$bank_name=get_option( 'lmgt_bank_name' );
				$account_holder_name=get_option( 'lmgt_account_holder_name' );
				$account_number=get_option( 'lmgt_account_number' );
				$account_type=get_option( 'lmgt_account_type' );
				$ifsc_code=get_option( 'lmgt_ifsc_code' );
				$swift_code=get_option( 'lmgt_swift_code' );						
				
				$subtotal_amount=$time_entry_sub_total+$expense_sub_total+$flat_fee_sub_total;
						 
				$discount_amount=$time_entry_discount+$expense_discount+$flat_fee_discount;
				 
				$tax_amount=$time_entry_total_tax+$expense_total_tax+$flat_fee_total_tax;
			 
				$due_amount=$subtotal_amount-$discount_amount+$tax_amount-$invoice_info->paid_amount;
				$paid_amount= sanitize_text_field($invoice_info->paid_amount);
				$grand_total=$subtotal_amount-$discount_amount+$tax_amount;
				
				 
					$mpdf->WriteHTML('<table class="margin_left_table"  border="0">');
					$mpdf->WriteHTML('<tbody>');
						
						$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td  class="width_70 align_right"><h4 class="margin h4_pdf font_family">'.esc_html__('Subtotal Amount ','lawyer_mgt').':</h4></td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8"> <h4 class="margin h4_pdf"><span>'.MJ_lawmgt_get_currency_symbol().'</span>'.number_format(esc_html($subtotal_amount),2).'</h4></td>');
							$mpdf->WriteHTML('</tr>');
						
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin h4_pdf font_family">'.esc_html__('Discount Amount ','lawyer_mgt').' :</h4></td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8"><h4 class="margin h4_pdf"> <span >- '.MJ_lawmgt_get_currency_symbol().'</span>'.number_format(esc_html($discount_amount),2).'</h4></td>');
							$mpdf->WriteHTML('</tr>'); 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin h4_pdf font_family">'.esc_html__('Tax Amount ','lawyer_mgt').' :</h4></td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8"><h4 class="margin h4_pdf"> <span >+ '.MJ_lawmgt_get_currency_symbol().'</span>'.number_format(esc_html($tax_amount),2).'</h4></td>');
							$mpdf->WriteHTML('</tr>');
							
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin h4_pdf font_family">'.esc_html__('Paid Amount ','lawyer_mgt').' :</h4></td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8"> <h4 class="margin h4_pdf"><span >'.MJ_lawmgt_get_currency_symbol().'</span>'.number_format(esc_html($paid_amount),2).'</h4></td>');
							$mpdf->WriteHTML('</tr>');
							
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_70 align_right due_amount_color"><h4 class="margin h4_pdf font_family">'.esc_html__('Due Amount ','lawyer_mgt').' :</h4></td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 due_amount_color"> <h4 class="margin h4_pdf"><span >'.MJ_lawmgt_get_currency_symbol().'</span>'.number_format(esc_html($due_amount),2).'</h4></td>');
							$mpdf->WriteHTML('</tr>');
							
							$mpdf->WriteHTML('<tr>');							
								$mpdf->WriteHTML('<td  class="align_right grand_total_lable font_family padding_11"><h3 class="color_white margin font_family">'.esc_html__('Grand Total ','lawyer_mgt').':</h3></td>');
								$mpdf->WriteHTML('<td class="align_right grand_total_amount amount_padding_8"><h3 class="color_white margin">  <span>'.MJ_lawmgt_get_currency_symbol().''.number_format(esc_html($grand_total),2).'</span></h3></td>');
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
				 
					  $mpdf->WriteHTML('<table class="margin_top_invoice" border="0">');
						$mpdf->WriteHTML('<tbody>');
						if(!empty($bank_name))  { 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td colspan="2" class="padding_left_15_px_css">');
									$mpdf->WriteHTML('<h3 class="payment_method_lable font_family">'.esc_html__('Payment Method ','lawyer_mgt').'');
								$mpdf->WriteHTML('</h3>');
								$mpdf->WriteHTML('</td>');								
							$mpdf->WriteHTML('</tr>');
						}	
						if(!empty($bank_name))  { 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td  class="width_31 font_12">'.esc_html__('Bank Name ','lawyer_mgt').' </td>');
								$mpdf->WriteHTML('<td class="font_12">: '.esc_html($bank_name).'</td>');
							$mpdf->WriteHTML('</tr>');
						}
						if(!empty($bank_name))  { 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td  class="width_31 font_12">'.esc_html__('A/C Holder Name ','lawyer_mgt').'</td>');
								$mpdf->WriteHTML('<td class="font_12">: '.esc_html($account_holder_name).'</td>');
							$mpdf->WriteHTML('</tr>');
						}
						if(!empty($bank_name))  { 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_31 font_12">'.esc_html__('Account No ','lawyer_mgt').'</td>');
								$mpdf->WriteHTML('<td class="font_12">: '.esc_html($account_number).'</td>');
							$mpdf->WriteHTML('</tr>');
						}
						if(!empty($bank_name))  { 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_31 font_12">'.esc_html__('Account Type ','lawyer_mgt').'</td>');
								$mpdf->WriteHTML('<td class="font_12">: '.esc_html($account_type).'</td>');
							$mpdf->WriteHTML('</tr>');
						}
						if(!empty($bank_name))  { 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_31 font_12">'.esc_html__('IFSC Code ','lawyer_mgt').' </td>');
								$mpdf->WriteHTML('<td class="font_12">: '.esc_html($ifsc_code).'</td>');
							$mpdf->WriteHTML('</tr>');
						}
						if(!empty($bank_name))  { 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_31 font_12">'.esc_html__('Swift Code ','lawyer_mgt').' </td>');
								$mpdf->WriteHTML('<td class="font_12">: '.esc_html($swift_code).'</td>');
							$mpdf->WriteHTML('</tr>');
						}
						if(!empty($bank_name))  { 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_31 font_12">'.esc_html__('Paypal ','lawyer_mgt').' </td>');
								$mpdf->WriteHTML('<td class="font_12">: '.esc_html(get_option( 'lmgt_paypal_email' )).'</td>');
							$mpdf->WriteHTML('</tr>');
						}
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>'); 
								
				  $id=1;
			$result_payment=$obj_invoice->MJ_lawmgt_get_single_payment_data($invoice_id);
			if(!empty($result_payment))
			{			
					$mpdf->WriteHTML('<table class="width_100_print">');	
				$mpdf->WriteHTML('<tbody>');	
					$mpdf->WriteHTML('<tr>');
						$mpdf->WriteHTML('<td class="padding_left_20_px_css">');
							$mpdf->WriteHTML('<h3 class="entry_lable font_family">'.esc_html__('Payment History ','lawyer_mgt').'</h3>');
						$mpdf->WriteHTML('</td>');	
					$mpdf->WriteHTML('</tr>');	
				$mpdf->WriteHTML('</tbody>');
			$mpdf->WriteHTML('</table>');				
			
				
				$mpdf->WriteHTML('<table class="table table-bordered table_row_color" class="width_93" border="1">');
					$mpdf->WriteHTML('<thead>');
											
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center padding_10_pdf">#</th>');
								
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('DATE','lawyer_mgt').'</th>');
								
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center amount_padding_8 font_family padding_10_pdf">'.esc_html__('AMOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>'); 

								$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('PAYMENT METHOD ','lawyer_mgt').'</th>');
								
							$mpdf->WriteHTML('</tr>');						
						
					$mpdf->WriteHTML('</thead>');
					$mpdf->WriteHTML('<tbody>');
					
					
						foreach($result_payment as $data)
						{							
							 
							$bg_color = $id % 2 === 0 ? "#cad5f5" : "white";
							if($bg_color == 'white')
							{
								$bg_color_css='pdf_background_color_td_css_white';
							}
							else
							{
								$bg_color_css='pdf_background_color_td_css_blue';
							}	
						  	$mpdf->WriteHTML('<tr class="entry_list '.$bg_color_css.'">');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($id).'</td>');
								
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html(MJ_lawmgt_getdate_in_input_box($data->date)).'</td>');
								
								$mpdf->WriteHTML('<td class="align_center amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($data->amount),2).'</td>');	
								
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($data->payment_method).'</td>'); 
						 	$mpdf->WriteHTML(' </tr>');
						
							$id=$id+1;
						}
							
					$mpdf->WriteHTML('</tbody>');
				$mpdf->WriteHTML('</table>');
			}
				
			$gst_number=get_option( 'lmgt_gst_number' );
			$tax_id=get_option( 'lmgt_tax_id' );
			$corporate_id=get_option( 'lmgt_corporate_id' );
									
			$mpdf->WriteHTML('<table class="table_invoice gst_details" border="0">');
			$mpdf->WriteHTML('<thead>');
				$mpdf->WriteHTML('<tr>');
			if(!empty($gst_number))
				{				
					$mpdf->WriteHTML('<th class="align_center font_family">'.esc_html__('GST Number ','lawyer_mgt').' </th>');
				}
			if(!empty($tax_id))
				{
					$mpdf->WriteHTML('<th class="align_center font_family">'.esc_html__('TAX ID ','lawyer_mgt').' </th>');
				}
			if(!empty($corporate_id))
				{
					$mpdf->WriteHTML('<th class="align_center font_family">'.esc_html__('Corporate ID ','lawyer_mgt').'</th>');
				}
				$mpdf->WriteHTML('</tr>');	
			$mpdf->WriteHTML('</thead>');
			$mpdf->WriteHTML('<tbody>');
				$mpdf->WriteHTML('<tr>');								
					$mpdf->WriteHTML('<td class="align_center">'.esc_html($gst_number).'</td>');
					$mpdf->WriteHTML('<td class="align_center">'.esc_html($tax_id).'</td>');
					$mpdf->WriteHTML('<td class="align_center">'.esc_html($corporate_id).'</td>');
				$mpdf->WriteHTML('</tr>');	
			$mpdf->WriteHTML('</tbody>');
			$mpdf->WriteHTML('</table>'); 
			 
				$mpdf->WriteHTML('<table class="width_100 margin_bottom_20" border="0">');				
					$mpdf->WriteHTML('<tbody>');
					if(!empty($invoice_info->note))
						{
					$mpdf->WriteHTML('<tr>');
							$mpdf->WriteHTML('<td colspan="2" class="padding_left_15_px_css">');
								$mpdf->WriteHTML('<h3 class="payment_method_lable font_family">'.esc_html__('Note ','lawyer_mgt').'</h3>');
							$mpdf->WriteHTML('</td>');								
						$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('<tr>');
							$mpdf->WriteHTML('<td class="font_12 padding_left_15">'.wordwrap(esc_html($invoice_info->note),50,"<br>\n",TRUE).'</td>');
						$mpdf->WriteHTML('</tr>');
						}
						if(!empty($invoice_info->terms))
						{
						$mpdf->WriteHTML('<tr>');
							$mpdf->WriteHTML('<td colspan="2" class="padding_left_15_px_css">');
								$mpdf->WriteHTML('<h3 class="payment_method_lable font_family">'.esc_html__('Terms & Conditions ','lawyer_mgt').'</h3>');
							$mpdf->WriteHTML('</td>');								
						$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('<tr>');
							$mpdf->WriteHTML('<td class="font_12 padding_left_15">'.wordwrap(esc_html($invoice_info->terms),50,"<br>\n",TRUE).'</td>');
						$mpdf->WriteHTML('</tr>');
						}						
					$mpdf->WriteHTML('</tbody>');
				$mpdf->WriteHTML('</table>');
				 
			
				$mpdf->WriteHTML('</div>');
			$mpdf->WriteHTML('</div>'); 
			
			$mpdf->WriteHTML("</body>");
			$mpdf->WriteHTML("</html>");
	
	$mpdf->Output($document_path.''.$invoice_id.'.pdf','F');
	
	unset($mpdf);	
	
	$system_name=get_option('lmgt_system_name');
	
	$headers = "From: ".$system_name.' <noreplay@gmail.com>' . "\r\n";	
	
	$mail_attachment = array($document_path.''.$invoice_id.'.pdf'); 
	
	wp_mail($emails,$subject,$message,$headers,$mail_attachment); 
	unlink($document_path.''.$invoice_id.'.pdf');
}
/*<---  string replacemnet function --->*/
function MJ_lawmgt_string_replacemnet($arr,$message)
{
	$data = str_replace(array_keys($arr),array_values($arr),$message);
	return $data;
}
// LOAD DOCUMENTS 
function MJ_lawmgt_load_documets($file,$type,$nm)
{	
	$parts = pathinfo($type['name']);
	$inventoryimagename = sanitize_file_name(time()."-".rand().".".$parts['extension']);
	$document_dir = WP_CONTENT_DIR;
	$document_dir .= '/uploads/document_upload/';
	$document_path = $document_dir;
	if (!file_exists($document_path)) {
		mkdir($document_path, 0777, true);		
	}
	$imagepath="";	
	if (move_uploaded_file($type['tmp_name'], $document_path.$inventoryimagename)) 
	{
		 $imagepath= $inventoryimagename; 
	}
	return $imagepath;
}
		
//group model code
function MJ_lawmgt_add_or_remove_group()
{	
	$model = sanitize_text_field($_REQUEST['model']);	
 
  ?>
     <div class="modal-header"> <a href="#" class="close-btn badge badge-success pull-right custom_close_btn">X</a>
  		<h4 id="myLargeModalLabel" class="modal-title"><?php esc_html_e('Group','lawyer_mgt'); ?></h4>
	</div>
	<div class="panel panel-white">
  		<div class="group_listbox" style="height: 250px;">
  			<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">
			<table class="table">
			  		<thead>
			  			<tr>
							<th><?php esc_html_e('Group Name','lawyer_mgt'); ?></th>
			                <th><?php esc_html_e('Action','lawyer_mgt'); ?></th>
			            </tr>
			        </thead>
			         <?php 		
        	$increment = 1;
			$obj_group=new MJ_lawmgt_group;
			$group_result=$obj_group->MJ_lawmgt_get_all_group();

        	if(!empty($group_result))
        	{      	
        		foreach ($group_result as $retrieved_data)
        		{
					echo '<tr id="group-'.esc_attr($retrieved_data->ID).'">';
					echo '<td>'.esc_html($retrieved_data->post_title).'</td>';
					echo '<td id='.esc_attr($retrieved_data->ID).'><a class="btn-delete-group badge badge-delete" model='.esc_attr($model).' href="#" id='.esc_attr($retrieved_data->ID).'>X</a></td>';
					echo '</tr>';
					$increment++;		
					
        		}
        	} 
       ?>
		   </table>    
		   </div>
  		</div>
  		<form name="group_form" action="" method="post" class="form-horizontal" id="group_form">
	  	 	<div class="form-group dis_flex">
				<label class="col-sm-2 control-label popup_label practice_ml" for="group_name"><?php esc_html_e('Group Name','lawyer_mgt'); ?><span class="require-field">*</span></label>
				<div class="col-sm-4">
					<input id="group_name" class="form-control text-input" maxlength="50" name="group_name" type="text">	
				</div>
				<div class="col-sm-4">
					<input type="button" value="<?php esc_attr_e('Submit','lawyer_mgt'); ?>" name="save_group" class="btn btn-success" model="<?php echo $model; ?>" id="btn-add-group"/>
				</div>
			</div>
  		</form>
  	</div>
	<?php   
	die();	 
}
 
//show event and task model code
function MJ_lawmgt_show_event_task()
{	
	$id =sanitize_text_field( $_REQUEST['id']);	
	$model = sanitize_text_field($_REQUEST['model']);
	if($model=='Event Details')
	{
		
		$event=new MJ_lawmgt_Event;
		$eventdata=$event->MJ_lawmgt_get_signle_event_by_id($id);
		
		$case_data=MJ_lawmgt_get_case_name_by_id($eventdata->case_id);
		foreach($case_data as $case_name1)
		{
			$case_name=esc_html($case_name1->case_name);
		}
		
	}
	elseif($model=='Task Details')
	{
		
		$obj_case_tast= new MJ_lawmgt_case_tast;
		$taskdata=$obj_case_tast->MJ_lawmgt_get_all_edit_tast($id);
		$user_id=sanitize_text_field($taskdata->assigned_to_user);		
		$contact_id=explode(',',$user_id);	
		$user_name=array();
		foreach($contact_id as $contact_name) 
		{
			$userdata=get_userdata($contact_name);	
				
			$user_name[]=sanitize_text_field($userdata->display_name);										   
		}
		$assigned_to=implode(',',$user_name);	
		$case_data=MJ_lawmgt_get_case_name_by_id($taskdata->case_id);
		foreach($case_data as $case_name1)
		{
			$case_name=sanitize_text_field($case_name1->case_name);
		}
	}
	elseif($model=='Case Details')
	{
		$obj_case=new MJ_lawmgt_case;
		$case_info_data = $obj_case->MJ_lawmgt_get_single_case($id);
	}
	elseif($model == 'Orders Details' OR $model == 'Next Hearing Date Details')
	{
		
		
		$obj_orders= new MJ_lawmgt_Orders;
		$orderdata=$obj_orders->MJ_lawmgt_get_single_orders($id);
		$case_data=MJ_lawmgt_get_case_name_by_id($orderdata->case_id);
		foreach($case_data as $case_name1)
		{
			$case_name=sanitize_text_field($case_name1->case_name);
		}
		
	}
	 
	elseif($model=='Judgments Details')
	{
		
		$obj_judgments= new MJ_lawmgt_Judgments;
		$judgmentsdata=$obj_judgments->MJ_lawmgt_get_single_judgment($id);
		$case_data=MJ_lawmgt_get_case_name_by_id($judgmentsdata->case_id);
		foreach($case_data as $case_name1)
		{
			$case_name= sanitize_text_field($case_name1->case_name);
		}
	}
	elseif($model=='Note Details')
	{
		$obj_note= new MJ_lawmgt_Note;
		$note_data=$obj_note->MJ_lawmgt_get_signle_note_by_id($id);
		$user_id=$note_data->assigned_to_user;		
		$contact_id=explode(',',$user_id);	
		$user_name=array();
		foreach($contact_id as $contact_name) 
		{
			$userdata=get_userdata($contact_name);	
				
			$user_name[]= sanitize_text_field($userdata->display_name);										   
		}
		$assigned_to=implode(',',$user_name);	
		$case_data=MJ_lawmgt_get_case_name_by_id($note_data->case_id);
		foreach($case_data as $case_name1)
		{
			$case_name= sanitize_text_field($case_name1->case_name);
		}
	}
  ?>
     <div class="modal-header model_header_padding"> <a href="#" class="event_close-btn badge badge-success pull-right float-right custom_close_btn">X</a>
  		<h4 id="myLargeModalLabel" class="modal-title"><?php if($model=='Event Details'){ esc_html_e('Event Details','lawyer_mgt'); }elseif($model=='Task Details'){ esc_html_e('Task Details','lawyer_mgt'); }elseif($model=='Case Details'){ esc_html_e('Case Details','lawyer_mgt');	}elseif($model=='Orders Details'){ esc_html_e('Orders Details','lawyer_mgt');}elseif($model=='Next Hearing Date Details'){ esc_html_e('Next Hearing Date Details','lawyer_mgt');}elseif($model=='Judgments Details'){ esc_html_e('Judgments Details','lawyer_mgt');}elseif($model=='Note Details'){ esc_html_e('Note Details','lawyer_mgt');} ?></h4>
	</div>
	<div class="panel panel-white">
	<?php
	if($model=='Event Details')
	{
	?>
		<div class="modal-body">
			<table id="examlist" class="table table-striped" cellspacing="0" width="100%" align="center">
				<tbody>
					<tr>
						<td><?php esc_html_e('Event Name:','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($eventdata->event_name); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e('Case Name:','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($case_name); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e('Address:','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($eventdata->address); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e('Description:','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($eventdata->description); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e('Start Date:','lawyer_mgt'); ?></td>
						<td><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($eventdata->start_date)); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e('End Date:','lawyer_mgt'); ?></td>
						<td><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($eventdata->end_date)); ?></td>
					</tr>				
				</tbody>
			</table>
        </div>  		
	<?php
	}
	elseif($model=='Task Details')
	{
	?>
		<div class="modal-body">
			<table id="examlist" class="table table-striped" cellspacing="0" width="100%" align="center">
				<tbody>
					<tr>
						<td><?php esc_html_e('Task Name :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($taskdata->task_name); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e('Case Name :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($case_name); ?></td>
					</tr>					
					<tr>
						<td><?php esc_html_e('Assigned To :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($assigned_to); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e('Due Date :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($taskdata->due_date)); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e('Description :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($taskdata->description); ?></td>
					</tr>
								
				</tbody>
			</table>
        </div> 
	<?php	
	}
	elseif($model=='Case Details')
	{
		$user=explode(",",$case_info_data->case_assgined_to);
		$case_assgined_to=array();
		if(!empty($user))
		{						
			foreach($user as $data4)
			{
				$case_assgined_to[]=MJ_lawmgt_get_display_name($data4);
			}
		}	
		$user1=explode(",",$case_info_data->user_id);
		$case_assgined_to1=array();
		if(!empty($user1))
		{						
			foreach($user1 as $data5)
			{
				$case_assgined_to1[]=MJ_lawmgt_get_display_name($data5);
			}
		}	
		
	?>
		<div class="modal-body">
			<table id="examlist" class="table table-striped" cellspacing="0" width="100%" align="center">
				<tbody>
					<tr>
						<td><?php esc_html_e('Case Name :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($case_info_data->case_name); ?></td>
					</tr>					
					<tr>
						<td><?php esc_html_e('Case Number :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($case_info_data->case_number); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e('Court Name :','lawyer_mgt'); ?></td>
						<td><?php echo  esc_html(get_the_title($case_info_data->court_id)); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e('Hearing Date :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($_REQUEST['start_date']); ?></td>
					</tr>					
					<tr>
						<td><?php esc_html_e('Attorney Name :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html(implode(", ",$case_assgined_to)); ?></td>
					</tr>	
					<tr>
						<td><?php esc_html_e('Client Name :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html(implode(", ",$case_assgined_to1)); ?></td>
					</tr>					
				</tbody>
			</table>
        </div> 
	<?php	
	}
 
	elseif($model=='Orders Details') 
	{
		 
	?>
		<div class="modal-body">
			<table id="examlist" class="table table-striped" cellspacing="0" width="100%" align="center">
				<tbody>
					<tr>
						<td><?php esc_html_e('Date:','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($orderdata->date); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e('Case Name :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($case_name); ?></td>
					</tr>					
					<tr>
						<td><?php esc_html_e('Judge Name :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($orderdata->judge_name); ?></td>
					</tr>
					 
					<tr>
						<td><?php esc_html_e('Order Details :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($orderdata->orders_details); ?></td>
					</tr>
				</tbody>
			</table>
        </div> 
	<?php	
	}
	elseif($model=='Next Hearing Date Details') 
	{
		 
	?>
		<div class="modal-body">
			<table id="examlist" class="table table-striped" cellspacing="0" width="100%" align="center">
				<tbody>
					<tr>
						<td><?php esc_html_e('Next Hearing Date:','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($orderdata->next_hearing_date); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e('Case Name :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($case_name); ?></td>
					</tr>					
					<tr>
						<td><?php esc_html_e('Judge Name :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($orderdata->judge_name); ?></td>
					</tr>
					 
					<tr>
						<td><?php esc_html_e('Order Details :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($orderdata->purpose_of_hearing); ?></td>
					</tr>
								
				</tbody>
			</table>
        </div> 
	<?php	
	}
	elseif($model=='Judgments Details') 
	{
	?>
		<div class="modal-body">
			<table id="examlist" class="table table-striped" cellspacing="0" width="100%" align="center">
				<tbody>
					<tr>
						<td><?php esc_html_e('Date:','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($judgmentsdata->date); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e('Case Name :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($case_name); ?></td>
					</tr>					
					<tr>
						<td><?php esc_html_e('Judge Name :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($judgmentsdata->judge_name); ?></td>
					</tr>
					 
					<tr>
						<td><?php esc_html_e('Judgments Details :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($judgmentsdata->judgments_details); ?></td>
					</tr>
						
					<tr>
						<td><?php esc_html_e('Judgments Law Details :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($judgmentsdata->judgments_law_details); ?></td>
					</tr>
				</tbody>
			</table>
        </div> 
	<?php	
	}
	elseif($model=='Note Details') 
	{ 
	?>
		<div class="modal-body">
			<table id="examlist" class="table table-striped" cellspacing="0" width="100%" align="center">
				<tbody>
					<tr>
						<td><?php esc_html_e('Note Title:','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($note_data->note_name); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e('Case Name :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($case_name); ?></td>
					</tr>
					
					<tr>
						<td><?php esc_html_e('Date:','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($note_data->date_time); ?></td>
					</tr>
					<tr>
						<td><?php esc_html_e('Assigned To :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($assigned_to); ?></td>
					</tr>
					 
					<tr>
						<td><?php esc_html_e('Note Details :','lawyer_mgt'); ?></td>
						<td><?php echo esc_html($note_data->note); ?></td>
					</tr>
						
				</tbody>
			</table>
        </div> 
	<?php	
	}
	?>
  	</div>
	<?php   
	die();	 
}
//Custom Field model code
function MJ_lawmgt_add_customfield()
{	
	$custom_field_id = sanitize_text_field($_REQUEST['custom_field_id']);
	$edit = sanitize_text_field($_REQUEST['edit']);
	$model = sanitize_text_field($_REQUEST['model']);	 
		
	if(!empty($custom_field_id))
	{
	    global $wpdb;
    	$table_custom_field = $wpdb->prefix. 'lmgt_custom_field';

		$result = $wpdb->get_row("SELECT * FROM $table_custom_field where id=".$custom_field_id);
	}
	?>
     <div class="modal-header"> <a href="#" class="close-btn badge badge-success pull-right custom_close_btn">X</a>			
  		<h4 id="myLargeModalLabel" class="modal-title"><?php if(!empty($edit)){ esc_html_e('Edit Custom Field','lawyer_mgt');}else{ esc_html_e('Add New Custom Field','lawyer_mgt'); } ?></h4>				
	</div>
	<div class="panel panel-white "> <!-- pane div  -->
  		<form name="group_form" action="" method="post" class="form-horizontal" id="group_form">
			<?php
			if(!empty($custom_field_id))
			{
			?>
			<input type="hidden" name="custom_field_id" id="custom_field_id" value="<?php echo esc_html($result->id); ?>">
			<?php	
			}	
			if(!empty($edit))
			{
			?>
			
			<div class="form-customfield col-sm-12">	
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="form_name"><?php esc_html_e('Form Name','lawyer_mgt'); ?></label>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">					
					<label class="control-label" for="form_name"><b><?php echo esc_html($result->form_name); ?></b></label>				
					</div>
			</div>
			<?php	
			}
			else
			{
			?>	
			<div class="form-customfield col-sm-12">	
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="form_name"><?php esc_html_e('Form Name','lawyer_mgt'); ?></label>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">					
					<select class="form-control form_name" name="form_name" id="form_name">	
					 	<option value="contact" selected ><?php esc_html_e('Contact Form','lawyer_mgt'); ?></option>
					 	<option value="case"><?php esc_html_e('Case Form','lawyer_mgt'); ?></option>					 					 	
					</select>
					</div>
			</div>
			<?php } ?>			
	  	 	<div class="form-customfield col-sm-12">	
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="name"><?php esc_html_e('Name','lawyer_mgt'); ?><span class="require-field">*</span></label>

				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
					<input id="customfield_name" class="form-control text-input" value="<?php if(!empty($edit)){ echo esc_html($result->lable); } ?>" name="customfield_name" type="text">
				</div>
			</div>			
	  	 	<div class="form-customfield col-sm-12">	
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="type"><?php esc_html_e('Type','lawyer_mgt'); if(!empty($edit))
						{ ?> <span class="require-field"></span> <?php }else{ ?> <span class="require-field">*</span> <?php } ?></label>
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
					<?php 
						if(!empty($edit))
						{
						?>
							<label class="control-label" for="type"><b><?php echo esc_html($result->type); ?></b>	</label>
						<?php
						}
						else
						{
					?>
					<select class="form-control field_type" name="field_type" id="field_type">	
					 	<option value="textbox" class="default_selected_type" selected><?php esc_html_e('Textbox','lawyer_mgt'); ?></option>
						<option value="textarea"><?php esc_html_e('TextArea','lawyer_mgt'); ?></option>
					 	<option value="dropdownlist"><?php esc_html_e('Drop Down List','lawyer_mgt'); ?></option>
					 	<option value="number"><?php esc_html_e('Number','lawyer_mgt'); ?></option>
					 	<option value="date"><?php esc_html_e('Date','lawyer_mgt'); ?></option>
					</select>
					<?php } ?>	
				</div>
			</div>	
			<div class="form-customfield col-sm-12 customfieldvalue_css display_none_css">
                    <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Value','lawyer_mgt'); ?><span class="require-field">*</span></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<input id="customfieldtype_value" class="form-control text-input validate[required]" value="" name="customfieldtype_value[]" type="text" placeholder="<?php esc_html_e('Enter Value','lawyer_mgt'); ?>">
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">	
						<input type="button" value="<?php esc_attr_e('Remove','lawyer_mgt'); ?>"  class="btn btn-danger deletecustomfield">
					</div>
            </div>						
			<div class="form-customfield customfieldvalue col-lg-12 col-md-12 col-sm-12 col-xs-12">	
			</div>
			<div class="control-group customfieldvalue_css offset-lg-2 offset-md-2 offset-sm-2 col-lg-10 col-md-10 col-sm-10 col-xs-12 display_none_css">
				<button type="button" id="customfielsaddvalue"  class="btn btn-success"><?php esc_html_e('Add More','lawyer_mgt'); ?></button>
			</div>
			 <?php
			if(!empty($edit))
			{
				$visable=$result->always_visible; 
			?>
			<div class="form-customfield col-sm-12 required_field_div">	
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="name"><?php esc_html_e('Always visable?','lawyer_mgt'); ?></label>
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
					<label class="radio-inline">
						<input type="radio" value="yes" class="" name="always_visible" <?php  checked( 'yes', $visable); ?>/><?php esc_html_e('Yes','lawyer_mgt'); ?>
					</label>
					<label class="radio-inline">
						<input type="radio"  value="no" class="" name="always_visible" <?php  checked( 'no', $visable); ?> /><?php esc_html_e('No','lawyer_mgt'); ?> 
					</label>
				</div>
			</div>
			<?php } ?>
			
			<div class="form-customfield col-sm-12 required_field_div">	
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="name"><?php esc_html_e('Required?','lawyer_mgt'); ?></label>
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
				<?php
					$required="no"; if(!empty($edit)){ $required=$result->required; }
				?>
					<label class="radio-inline">
						<input type="radio" value="yes" class="" name="required" <?php  checked( 'yes', $required);  ?>/><?php esc_html_e('Yes','lawyer_mgt'); ?>
					</label>
					<label class="radio-inline">
						<input type="radio"  value="no" class="required_checked" name="required" <?php  checked( 'no', $required);  ?> /><?php esc_html_e('No','lawyer_mgt'); ?> 
					</label>
				</div>
			</div>	
			<div class="form-customfield col-sm-12 validation_type_div">				
					 <?php
					if(!empty($edit))
					{
						$validation= $result->validation;
						$type=$result->type;
						if($type == 'textbox')
						{
							
					?>	
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label validation_label" for="name"><?php esc_html_e('Validation','lawyer_mgt'); ?></label>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">	
					<select class="form-control validation_type" name="validation" id="validation_type">	
					 	<option value="custom[onlyLetterNumber]" <?php if($validation=='custom[onlyLetterNumber]') { print ' selected'; } ?> selected > <?php esc_html_e('Only Letter Number','lawyer_mgt'); ?></option>
					 	<option value="custom[email]" <?php if($validation=='custom[email]') { print ' selected'; } ?>><?php esc_html_e('Email','lawyer_mgt'); ?></option>
					 	<option value="custom[onlyLetterSp]" <?php if($validation=='custom[onlyLetterSp]') { print ' selected'; } ?>> <?php esc_html_e('Only Letter','lawyer_mgt'); ?></option>
					 	<option value="custom[url]" <?php if($validation=='custom[url]') { print ' selected'; }?>><?php esc_html_e('URL','lawyer_mgt'); ?></option>					 	
					</select>
					</div>
					<?php
						}
					}
					else
					{
					?>
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="name"><?php esc_html_e('Validation','lawyer_mgt'); ?></label>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">					
					<select class="form-control validation_type" name="validation" id="validation_type">	
					 	<option value="custom[onlyLetterNumber]" class="default_selected_validation" selected ><?php esc_html_e('Only Letter Number','lawyer_mgt'); ?></option>
					 	<option value="custom[email]"><?php esc_html_e('Email','lawyer_mgt'); ?></option>
					 	<option value="custom[onlyLetterSp]"><?php esc_html_e('Only Letter','lawyer_mgt'); ?></option>
					 	<option value="custom[url]"><?php esc_html_e('URL','lawyer_mgt'); ?></option>					 	
					</select>
					</div>
					<?php						
					}
					?>					
			</div>			
	  	 			
			<div class="form-customfield col-sm-12">
				<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">	
						<?php
						if(!empty($edit))
						{
						?>
						<input type="button" value="<?php  esc_attr_e('Save','lawyer_mgt'); ?>" name="save_customfield" class="btn btn-success" model="<?php echo $model; ?>" id="btn-update-customfield"/>					
						<?php
						}
						else
						{
						?>	
							<input type="button" value="<?php esc_attr_e('Add Custom Field','lawyer_mgt'); ?>" name="save_customfield" class="btn btn-success" model="<?php echo $model; ?>" id="btn-add-customfield"/>					
						<?php 
						} 
						?>
				</div>
			</div>
  		</form>
  	</div> <!-- end panel div -->
	<?php 
	die();
} 
//practice area model code function
function MJ_lawmgt_add_or_remove_practice_area()
{	
	$model = sanitize_text_field($_REQUEST['model']);
  ?>		
     <div class="modal-header"> <a href="#" class="close-btn badge badge-success pull-right custom_close_btn">X</a>
  		<h4 id="myLargeModalLabel" class="modal-title">  <?php esc_html_e('Practice Area','lawyer_mgt'); ?> </h4>
	</div>
	<script type="text/javascript">
	$("#practice_area").keypress(function( e ) 
	{     
		 "use strict";	
		var regex = new RegExp("^[0-9a-zA-Z \b]+$");
		var key = String.fromCharCode(!event.charCode ? event.which: event.charCode);
		if (!regex.test(key)) 
		{
			event.preventDefault();
			return false;
		} 
   });  
	</script>
	<div class="panel panel-white"> <!-- panel body div -->
  		<div class="practice_areabox" style="overflow: scroll; height:250px;">
  			<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">
			<table class="table">
			  		<thead>
			  			<tr>
			                <th><?php esc_html_e('Practice Area','lawyer_mgt'); ?></th>
			                <th><?php esc_html_e('Action','lawyer_mgt'); ?></th>
			            </tr>
			        </thead>
			         <?php 		
        	 $increment = 1;
			 $obj_practice_area=new MJ_lawmgt_practicearea;
			 $practice_area_result=$obj_practice_area->MJ_lawmgt_get_all_practicearea();
        	if(!empty($practice_area_result))
        	{      	
        		foreach ($practice_area_result as $retrieved_data)
        		{
					echo '<tr id="practice_area-'.esc_attr($retrieved_data->ID).'">';      		
					echo '<td>'.esc_html($retrieved_data->post_title).'</td>';
					echo '<td id='.esc_attr($retrieved_data->ID).'><a class="btn-delete-practice_area badge badge-delete" model='.esc_attr($model).' href="#" id='.esc_attr($retrieved_data->ID).'>X</a></td>';
					echo '</tr>';
					$increment++;		
        		}
        	}  
		?>
		   </table>    
		    </div>
  		</div>

  		<form name="practice_area_form" action="" method="post" class="form-horizontal" id="practice_area_form">
	  	 	<div class="form-group">
				<label class="col-sm-2 control-label popup_label practice_ml" for="practice_area"><?php esc_html_e('Practice Area','lawyer_mgt'); ?><span class="require-field">*</span>
				</label>
				<div class="col-sm-4">
					<input id="practice_area" class="form-control text-input " maxlength="50" value="" name="practice_area" type="text">
				</div>
				<div class="col-sm-4">
					<input type="button" value="<?php esc_attr_e('Submit','lawyer_mgt'); ?>" name="save_practice_area" class="btn btn-success" model="<?php echo esc_attr($model); ?>" id="btn-add-practice_area"/>
				</div>
			</div>
  		</form>
  	</div><!--  end panel body div -->
	<?php 
	die();
} 
//practice area model code function
add_action( 'wp_ajax_MJ_lawmgt_add_group', 'MJ_lawmgt_add_group');
add_action( 'wp_ajax_MJ_lawmgt_remove_group', 'MJ_lawmgt_remove_group'); 
add_action( 'wp_ajax_MJ_lawmgt_add_new_customfield', 'MJ_lawmgt_add_new_customfield');
add_action( 'wp_ajax_MJ_lawmgt_update_customfield', 'MJ_lawmgt_update_customfield');
add_action( 'wp_ajax_MJ_lawmgt_get_customfield_option_value', 'MJ_lawmgt_get_customfield_option_value');
add_action( 'wp_ajax_MJ_lawmgt_remove_customfield_from_database', 'MJ_lawmgt_remove_customfield_from_database');
add_action( 'wp_ajax_MJ_lawmgt_add_attorney_into_database', 'MJ_lawmgt_add_attorney_into_database');
add_action( 'wp_ajax_MJ_lawmgt_add_workflow_into_database', 'MJ_lawmgt_add_workflow_into_database');
add_action( 'wp_ajax_MJ_lawmgt_get_stafflink_attorney_info', 'MJ_lawmgt_get_stafflink_attorney_info');
add_action( 'wp_ajax_MJ_lawmgt_add_practice_area', 'MJ_lawmgt_add_practice_area');
add_action( 'wp_ajax_MJ_lawmgt_conatct_by_company', 'MJ_lawmgt_conatct_by_company');
add_action( 'wp_ajax_MJ_lawmgt_caselist_by_contact_name', 'MJ_lawmgt_caselist_by_contact_name');
add_action( 'wp_ajax_MJ_lawmgt_add_or_remove_practice_area','MJ_lawmgt_add_or_remove_practice_area');
add_action( 'wp_ajax_MJ_lawmgt_add_or_remove_group', 'MJ_lawmgt_add_or_remove_group');
add_action( 'wp_ajax_MJ_lawmgt_show_event_task', 'MJ_lawmgt_show_event_task');
add_action( 'wp_ajax_MJ_lawmgt_remove_practice_area', 'MJ_lawmgt_remove_practice_area'); 
add_action( 'wp_ajax_MJ_lawmgt_add_customfield', 'MJ_lawmgt_add_customfield');
add_action( 'wp_ajax_MJ_lawmgt_serch_group1', 'MJ_lawmgt_serch_group1');
add_action( 'wp_ajax_MJ_lawmgt_serch_group2', 'MJ_lawmgt_serch_group2');
add_action( 'wp_ajax_MJ_lawmgt_serch_practice_Area1', 'MJ_lawmgt_serch_practice_Area1'); 
add_action( 'wp_ajax_MJ_lawmgt_serch_practice_Area2', 'MJ_lawmgt_serch_practice_Area2'); 
add_action( 'wp_ajax_MJ_lawmgt_serch_practice_Area3', 'MJ_lawmgt_serch_practice_Area3'); 
add_action( 'wp_ajax_MJ_lawmgt_serch_practice_Area4', 'MJ_lawmgt_serch_practice_Area4'); 
add_action( 'wp_ajax_MJ_lawmgt_serch_case_name_all_documents', 'MJ_lawmgt_serch_case_name_all_documents'); 
add_action( 'wp_ajax_MJ_lawmgt_serch_case_name_unread_documents', 'MJ_lawmgt_serch_case_name_unread_documents'); 
add_action( 'wp_ajax_MJ_lawmgt_serch_case_name_read_documents', 'MJ_lawmgt_serch_case_name_read_documents'); 
add_action( 'wp_ajax_MJ_lawmgt_documets_status_change', 'MJ_lawmgt_documets_status_change'); 
add_action( 'wp_ajax_MJ_lawmgt_add_tags_documents', 'MJ_lawmgt_add_tags_documents'); 
add_action( 'wp_ajax_MJ_lawmgt_add_tags_documents_auto_suggesstion', 'MJ_lawmgt_add_tags_documents_auto_suggesstion'); 
add_action( 'wp_ajax_MJ_lawmgt_document_status_filter', 'MJ_lawmgt_document_status_filter'); 
add_action( 'wp_ajax_MJ_lawmgt_case_year_filter', 'MJ_lawmgt_case_year_filter'); 
add_action( 'wp_ajax_MJ_lawmgt_fronted_document_status_filter', 'MJ_lawmgt_fronted_document_status_filter'); 
add_action( 'wp_ajax_MJ_lawmgt_case_stat', 'MJ_lawmgt_case_stat');
add_action( 'wp_ajax_MJ_lawmgt_assign_task', 'MJ_lawmgt_assign_task'); 
add_action( 'wp_ajax_MJ_lawmgt_case_status', 'MJ_lawmgt_case_status');
add_action( 'wp_ajax_MJ_lawmgt_practice_by_case', 'MJ_lawmgt_practice_by_case');
add_action( 'wp_ajax_MJ_lawmgt_get_user_by_case', 'MJ_lawmgt_get_user_by_case');
add_action( 'wp_ajax_MJ_lawmgt_get_attorney_by_case', 'MJ_lawmgt_get_attorney_by_case');
add_action( 'wp_ajax_MJ_lawmgt_display_time_entery_subtotal', 'MJ_lawmgt_display_time_entery_subtotal');
add_action( 'wp_ajax_MJ_lawmgt_display_expenses_subtotal', 'MJ_lawmgt_display_expenses_subtotal');
add_action( 'wp_ajax_MJ_lawmgt_display_flat_fee_subtotal', 'MJ_lawmgt_display_flat_fee_subtotal');
add_action( 'wp_ajax_MJ_lawmgt_add_payment', 'MJ_lawmgt_add_payment');
add_action( 'wp_ajax_MJ_lawmgt_apply_workflow_details', 'MJ_lawmgt_apply_workflow_details');
add_action( 'wp_ajax_MJ_lawmgt_get_user_by_case_invoice', 'MJ_lawmgt_get_user_by_case_invoice');
add_action( 'wp_ajax_MJ_lawmgt_get_company_by_assigned_attorney', 'MJ_lawmgt_get_company_by_assigned_attorney');
add_action( 'wp_ajax_MJ_lawmgt_change_profile_photo', 'MJ_lawmgt_change_profile_photo');
add_action( 'wp_ajax_MJ_lawmgt_add_or_remove_category', 'MJ_lawmgt_add_or_remove_category');
add_action( 'wp_ajax_MJ_lawmgt_add_category', 'MJ_lawmgt_add_category');
add_action( 'wp_ajax_MJ_lawmgt_remove_category', 'MJ_lawmgt_remove_category');
add_action( 'wp_ajax_MJ_lawmgt_get_court_by_state', 'MJ_lawmgt_get_court_by_state');
add_action( 'wp_ajax_MJ_lawmgt_get_state_by_bench', 'MJ_lawmgt_get_state_by_bench');
add_action( 'wp_ajax_MJ_lawmgt_task_duedate_by_filter', 'MJ_lawmgt_task_duedate_by_filter');
add_action( 'wp_ajax_MJ_lawmgt_court_wise_filter', 'MJ_lawmgt_court_wise_filter');
add_action( 'wp_ajax_MJ_lawmgt_case_diary_filter_by_next_hearing_date', 'MJ_lawmgt_case_diary_filter_by_next_hearing_date');
  
// CHANGE PROFILE PHOTO
function MJ_lawmgt_change_profile_photo()
{
	wp_enqueue_style( 'bootstrap-css', plugins_url( '/assets/css/bootstrap.css', __FILE__) );
	?>
	
	<script type="text/javascript">
	jQuery("body").on("change", ".input-file[type=file]", function ()
	{ 
		 "use strict";	
		var file = this.files[0]; 
		var file_id = jQuery(this).attr('id'); 
		var ext = $(this).val().split('.').pop().toLowerCase(); 
		//Extension Check 
		if($.inArray(ext, ['jpg','jpeg','png']) == -1)
		{			 
			alert('<?php _e("Only jpg,jpeg,png formate are allowed. '  + ext + ' formate not allowed.","lawyer_mgt"); ?>');
			$(this).replaceWith('<input id="input-1" name="profile" type="file" class="form-control file file_border_css input-file">');
			return false; 
		} 
		//File Size Check 
		if (file.size > 20480000) 
		{
			alert("<?php esc_html_e('Too large file Size. Only file smaller than 10MB can be uploaded.','lawyer_mgt'); ?>");
			$(this).replaceWith('<input id="input-1" name="profile" type="file" class="form-control file file_border_css input-file">'); 
			return false; 
		}
	 });
</script>
	<div class="modal-header model_header_border"> <a href="#" class="close-btn badge badge-success pull-right custom_close_btn">X</a>
	</div>
	<form class="form-horizontal" action="#" method="post" enctype="multipart/form-data">
		<div class="form-group">
		<label for="inputEmail" class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-12"><?php esc_html_e('Select Profile Picture','lawyer_mgt'); ?></label>
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">	
				<input id="input-1" name="profile" type="file" class="form-control file file_border_css input-file">
			</div>
		</div>
		<div class="form-group">
			<div class="offset-lg-3 col-lg-9 offset-md-3 col-md-9 offset-sm-3 col-sm-9 col-xs-12">
					<button type="submit" class="btn btn-success" name="save_profile_pic"><?php esc_html_e('Save','lawyer_mgt'); ?></button>
			</div>
		</div>
	</form>
    <?php 
	die();	
} // end CHANGE PROFILE PHOTO

//get invoice payments_status 
function MJ_lawmgt_get_invoice_paymentstatus($invoice_id)
{
	global $wpdb;
	$table_invoice = $wpdb->prefix. 'lmgt_invoice';
	
	$result = $wpdb->get_row("SELECT * FROM $table_invoice where id = $invoice_id");
	
	if($result->paid_amount >= $result->total_amount)
		return esc_html_e('Fully Paid','lawyer_mgt');
	elseif($result->paid_amount > 0)
		return esc_html_e('Partially Paid','lawyer_mgt');
	else
		return esc_html_e('Not Paid','lawyer_mgt'); 
} //end get invoice payments_status 
function MJ_lawmgt_get_invoice_paymentstatus_for_payment($invoice_id)
{
	global $wpdb;
	$table_invoice = $wpdb->prefix. 'lmgt_invoice';
	
	$result = $wpdb->get_row("SELECT * FROM $table_invoice where id = $invoice_id");
	
	if($result->paid_amount >= $result->total_amount)
		return 'Fully Paid';
	elseif($result->paid_amount > 0)
		return 'Partially Paid';
	else
		return 'Not Paid'; 
}
//invoice add Payment Module pop up
function MJ_lawmgt_add_payment()
{
	$case_id = sanitize_text_field($_POST['case_id']);
	$invoice_id = sanitize_text_field($_POST['invoice_id']);
	$due_amount = sanitize_text_field($_POST['due_amount']);
?>
	<div class="modal-header">
			<a href="#" class="close-btn badge badge-success pull-right custom_close_btn">X</a>
			<h4 class="modal-title"><?php echo esc_html(get_option('lmgt_system_name')); ?></h4>
	</div>
	<div class="modal-body">
		 <form name="expense_form" action="" method="post" class="form-horizontal" id="expense_form">
         <?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert'); ?>
		<input type="hidden" name="action" value="<?php echo esc_attr($action); ?>">
		<input type="hidden" name="case_id" value="<?php echo esc_attr($case_id); ?>">
		
		<input type="hidden" name="invoice_id" value="<?php echo esc_attr($invoice_id); ?>">	
		<input type="hidden" name="created_by" value="<?php echo esc_html(get_current_user_id()); ?>">
		<div class="form-group">
			<label class="col-sm-3 control-label" for="amount"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('Paid Amount ', 'lawyer_mgt' ); ?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="amount" class="form-control validate[required] text-input" type="number" min="0" max="<?php echo esc_attr($due_amount);?>" value="<?php echo esc_attr($due_amount);?>" name="amount" step="0.01">
			</div>
		</div>
		<div class="form-group">
			<input type="hidden" name="payment_status" value="paid">
			<label class="col-sm-3 control-label" for="payment_method"><?php esc_html_e('Payment By','lawyer_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">			
				<select name="payment_method" id="payment_method" class="form-control">			
					<?php
					$user_role=MJ_lawmgt_get_current_user_role();
					if($user_role == 'client')
					{	?>
						<option value="Paypal"><?php esc_html_e('Paypal','lawyer_mgt'); ?></option>
						<?php
					}
					else
					{
					?>
						<option value="Cash"><?php esc_html_e('Cash','lawyer_mgt'); ?></option>
						<option value="Cheque"><?php esc_html_e('Cheque','lawyer_mgt'); ?></option>
						<option value="Bank Transfer"><?php esc_html_e('Bank Transfer','lawyer_mgt'); ?></option>
					<?php
					}
					?>
			 </select>
			</div>
		</div>
		<div class="offset-sm-2 col-sm-8">
        	 <input type="submit" value="<?php esc_attr_e('Add Payment','lawyer_mgt'); ?>" name="add_fee_payment" class="btn btn-success"/>
        </div>
		</form>
	</div>
<?php
	die();
} //end invoice add Payment Module pop up

// print FUNCTION CALL ON INIT ACTION
function MJ_lawmgt_print_init()
{
	if (is_user_logged_in ()) 
	{
		if(isset($_REQUEST['print']) && ($_REQUEST['print']) == 'print' && sanitize_text_field($_REQUEST['page']) == 'invoice')
		{			
			?>
			 <script type="text/javascript"> "use strict"; window.onload = function(){ window.print(); };</script> 
			<?php 
			MJ_lawmgt_invoice_print();
			exit;
		}	
	}
} // end print FUNCTION CALL ON INIT ACTION
add_action('init','MJ_lawmgt_print_init');
// pdf fuction call on init
function MJ_lawmgt_pdf_init()
{
	if (is_user_logged_in ()) 
	{
		if(isset($_REQUEST['invoicepdf']) && sanitize_text_field($_REQUEST['invoicepdf']) == 'invoicepdf')
		{
			MJ_lawmgt_invoice_pdf(sanitize_text_field($_REQUEST['invoice_id']));
			exit;
		}	
	}
}
add_action('init','MJ_lawmgt_pdf_init');
 
// invoice pdf fuction //
function MJ_lawmgt_invoice_pdf($id)
{
	$obj_case=new MJ_lawmgt_case;
	$obj_invoice=new MJ_lawmgt_invoice;
	$invoice_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['invoice_id']));
	$invoice_info=$obj_invoice->MJ_lawmgt_get_single_invoice($invoice_id);	
	$user_id= sanitize_text_field($invoice_info->user_id);	
	$case_id= sanitize_text_field($invoice_info->case_id);
	$case_info = $obj_case->MJ_lawmgt_get_single_case($case_id);	
	$user_info=get_userdata($user_id); 	
	$currency_symbol=MJ_lawmgt_get_currency_symbol();

	wp_enqueue_style( 'bootstrap-css', plugins_url( '/assets/css/bootstrap.css', __FILE__) );
	wp_enqueue_script('bootstrap-js', plugins_url( '/assets/js/bootstrap.js', __FILE__ ) );
				
	header('Content-type: application/pdf');
	header('Content-Disposition: inline; filename="invoice.pdf"');
	header('Content-Transfer-Encoding: binary');
	header('Accept-Ranges: bytes');	
	require LAWMS_PLUGIN_DIR. '/lib/mpdf/mpdf.php';	
	$stylesheet = wp_enqueue_style( 'bootstrap-css', plugins_url( '/assets/css/style.css', __FILE__) );
	$mpdf	=	new mPDF('c','A4','','' , 5 , 5 , 5 , 0 , 0 , 0); 
	$mpdf->debug = true;
	$mpdf->WriteHTML('<html>');
	$mpdf->WriteHTML('<head>');
	$mpdf->WriteHTML('<style></style>');
	$mpdf->WriteHTML($stylesheet,1); // Writing style to pdf
	$mpdf->WriteHTML('</head>');
	$mpdf->WriteHTML('<body>');		
	$mpdf->SetTitle('Invoice');

	$mpdf->WriteHTML('<div id="invoice_print">');		
			$mpdf->WriteHTML('<img class="invoicefont1 img_padding_right_pdf" src="'.plugins_url('/lawyers-management/assets/images/invoice.jpg').'" width="100%">');
			$mpdf->WriteHTML('<div class="main_div">');	
			
					$mpdf->WriteHTML('<table class="width_100_print" border="0">');					
					$mpdf->WriteHTML('<tbody>');
						$mpdf->WriteHTML('<tr>');
							$mpdf->WriteHTML('<td class="width_1_print">');
								$mpdf->WriteHTML('<img class="system_logo system_logo_print"  src="'.esc_url(get_option( 'lmgt_system_logo' )).'">');
							$mpdf->WriteHTML('</td>');							
							$mpdf->WriteHTML('<td class="only_width_20_print">');	
								$mpdf->WriteHTML('<table border="0">');					
								$mpdf->WriteHTML('<tbody>');
									$mpdf->WriteHTML('<tr>');																	
										$mpdf->WriteHTML('<td class="padding_bottom_20_pc_css">');
											$mpdf->WriteHTML('<b class="font_family">'.esc_html__('Address ','lawyer_mgt').':</b>');
										$mpdf->WriteHTML('</td>');	
										$mpdf->WriteHTML('<td class="padding_left_5 table_td_font font_family">'.chunk_split(esc_html(get_option( 'lmgt_address' )),20,"<BR>").'');
										$mpdf->WriteHTML('</td>');											
									$mpdf->WriteHTML('</tr>');
									$mpdf->WriteHTML('<tr>');																	
										$mpdf->WriteHTML('<td><b class="font_family">'.esc_html__('Email ','lawyer_mgt').' :</b>');
										$mpdf->WriteHTML('</td>');	
										$mpdf->WriteHTML('<td class="padding_left_5 table_td_font font_family">'.esc_html(get_option( 'lmgt_email' ))."<br>".'');
										$mpdf->WriteHTML('</td>');	
									$mpdf->WriteHTML('</tr>');
									$mpdf->WriteHTML('<tr>');																	
										$mpdf->WriteHTML('<td>');
											$mpdf->WriteHTML('<b class="font_family">'.esc_html__('Phone ','lawyer_mgt').' :</b>');
										$mpdf->WriteHTML('</td>');	
										$mpdf->WriteHTML('<td class="padding_left_5 table_td_font font_family">'.esc_html(get_option( 'lmgt_contact_number' ))."<br>".'');
										$mpdf->WriteHTML('</td>');											
									$mpdf->WriteHTML('</tr>');
								$mpdf->WriteHTML('</tbody>');
							$mpdf->WriteHTML('</table>');
							$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('<td align="right" class="width_24">');
							$mpdf->WriteHTML('</td>');
						$mpdf->WriteHTML('</tr>');
					$mpdf->WriteHTML('</tbody>');
				$mpdf->WriteHTML('</table>');
				
				$mpdf->WriteHTML('<table>');
			 $mpdf->WriteHTML('<tr>');
				$mpdf->WriteHTML('<td>');
				
					$mpdf->WriteHTML('<table class="width_50_print"  border="0">');
						$mpdf->WriteHTML('<tbody>');				
						$mpdf->WriteHTML('<tr>');
							$mpdf->WriteHTML('<td colspan="2" class="billed_to_print" align="center">');								
								$mpdf->WriteHTML('<h3 class="billed_to_lable font_family"> | '.esc_html__('Bill To ','lawyer_mgt').'. </h3>');
							$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('<td class="width_40_print">');	
									
									$mpdf->WriteHTML('<h3 class="display_name font_family">'.chunk_split(ucwords(esc_html($user_info->display_name)),30,"<BR>").'</h3>'); 
									$address=$user_info->address;										
									$mpdf->WriteHTML(''.chunk_split(esc_html($address),30,"<BR>").''); 
									  $mpdf->WriteHTML(''.esc_html($user_info->city_name).','); 
									 $mpdf->WriteHTML(''.esc_html($user_info->pin_code).'<br>'); 
									 $mpdf->WriteHTML(''.esc_html($user_info->mobile).'<br>'); 
								
							 $mpdf->WriteHTML('</td>');
						 $mpdf->WriteHTML('</tr>');									
					 $mpdf->WriteHTML('</tbody>');
				 $mpdf->WriteHTML('</table>');
				
				$mpdf->WriteHTML('</td>');
				$mpdf->WriteHTML('<td>');
				
				   $mpdf->WriteHTML('<table class="width_50_print"  border="0">');
					 $mpdf->WriteHTML('<tbody>');				
						 $mpdf->WriteHTML('<tr>');	
							 $mpdf->WriteHTML('<td class="width_30_print">');
							 $mpdf->WriteHTML('</td>');
							 $mpdf->WriteHTML('<td class="width_20_print invoice_lable align_center">');
								
									$issue_date=MJ_lawmgt_getdate_in_input_box($invoice_info->generated_date);						
									$payment_status=$invoice_info->payment_status;
									$invoice_no=$invoice_info->invoice_number;
																
									$mpdf->WriteHTML('<h3 class="invoice_color font_family"><span class="font_size_12_px_css">'.esc_html__('INVOICE','lawyer_mgt').' #<br></span><span class="font_size_18_px_css">'.esc_html($invoice_no).'</span>');																					
							 $mpdf->WriteHTML('</td>');							
						 $mpdf->WriteHTML('</tr>');
						 $mpdf->WriteHTML('<tr>');	
							 $mpdf->WriteHTML('<td class="width_30_print">');
							 $mpdf->WriteHTML('</td>');
							 $mpdf->WriteHTML('<td class="width_20_print" align="center">');
								$mpdf->WriteHTML('<h5 class="h5_pdf font_family align_center">'.esc_html__('Date ','lawyer_mgt').' : '.$issue_date.'</h5>');
							$mpdf->WriteHTML('<h5 class="h5_pdf font_family align_center">'.esc_html__('Status ','lawyer_mgt').' :'.esc_html__(''.$payment_status.'','lawyer_mgt').' </h5>');											
							 $mpdf->WriteHTML('</td>');							
						 $mpdf->WriteHTML('</tr>');						
					 $mpdf->WriteHTML('</tbody>');
				 $mpdf->WriteHTML('</table>');	
				$mpdf->WriteHTML('</td>');
			  $mpdf->WriteHTML('</tr>');
			$mpdf->WriteHTML('</table>');
			
			$mpdf->WriteHTML('<table class="width_100_print">');	
				$mpdf->WriteHTML('<tbody>');	
					$mpdf->WriteHTML('<tr>');
						$mpdf->WriteHTML('<td class="padding_left_20_px_css">');
							$mpdf->WriteHTML('<h3 class="entry_lable font_family">'.esc_html__('Time Entries ','lawyer_mgt').'</h3>');
						$mpdf->WriteHTML('</td>');	
					$mpdf->WriteHTML('</tr>');	
				$mpdf->WriteHTML('</tbody>');
			$mpdf->WriteHTML('</table>');
				$id=1;
					$result_time=$obj_invoice->MJ_lawmgt_get_single_invoice_time_entry($invoice_id);
					$time_entry_sub_total=0;
					$time_entry_discount=0;
					$time_entry_total_tax=0;
					$time_entry_total_amount=0;
					if(!empty($result_time))
					{	
						$mpdf->WriteHTML('<table class="table table-bordered table_row_color" class="width_93" border="1">');
						$mpdf->WriteHTML('<thead>');
												
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center padding_10_pdf">#</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('DATE','lawyer_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_left font_family padding_10_pdf">'.esc_html__('TIME ENTRY ACTIVITY ','lawyer_mgt').'</th>');						
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('HOURS','lawyer_mgt').'</th>');
								 
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('AMOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('DISCOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('TAX','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('TOTAL AMOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');
							$mpdf->WriteHTML('</tr>');						
						
					$mpdf->WriteHTML('</thead>');
					$mpdf->WriteHTML('<tbody>');
							
						foreach($result_time as $data)
						{ 
							$time_entry_sub=$data->subtotal;							
							$discount=$time_entry_sub/100 * $data->time_entry_discount;
							$time_entry_discount+=$discount;
							$after_discount_time_entry_sub=$time_entry_sub-$discount;
							$tax=$data->time_entry_tax;
							$tax1_total_amount='0';
								
							if(!empty($tax))
							{
								$tax_explode=explode(",",$tax);

								$total_tax=0;
							
								foreach($tax_explode as $tax1)
								{
									$taxvalue=MJ_lawmgt_tax_value_by_id($tax1);
									$total_tax+=$taxvalue->tax_value;
								} 
								if(!empty($total_tax))
								{	
									$tax1_total_amount=$after_discount_time_entry_sub / 100 * $total_tax ;
								}
							}
								
							$time_entry_total_tax+=$tax1_total_amount;
							$time_entry_sub_total+=$time_entry_sub;	
							$time_entry_total_sub_amount=$time_entry_sub - $discount + $tax1_total_amount;
							$time_entry_total_amount+=$time_entry_total_sub_amount;
							
							$bg_color = $id % 2 === 0 ? "#cad5f5" : "white";
							if($bg_color == 'white')
							{
								$bg_color_css='pdf_background_color_td_css_white';
							}
							else
							{
								$bg_color_css='pdf_background_color_td_css_blue';
							}
						  	$mpdf->WriteHTML('<tr class="entry_list '.$bg_color_css.'">');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($id).'</td>');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html(MJ_lawmgt_getdate_in_input_box($data->time_entry_date)).'</td>');
								$mpdf->WriteHTML('<td class="table_td_font padding_10_pdf">'.esc_html($data->time_entry).'</td>');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($data->hours).'</td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($data->subtotal),2).'</td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($discount),2).'</td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($tax1_total_amount),2).'</td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($time_entry_total_sub_amount),2).'</td>');
						 	$mpdf->WriteHTML(' </tr>');
						
						$id=$id+1;
						}
							
							$mpdf->WriteHTML('<tr class="entry_list">');							
								$mpdf->WriteHTML('<td colspan="7" class="align_right table_td_font font_family padding_10_pdf">'.esc_html__('Time Entries Total Amount ','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($time_entry_total_amount),2).'</td>');	
						 	$mpdf->WriteHTML('</tr>');						
									
					
					$mpdf->WriteHTML('</tbody>');
				$mpdf->WriteHTML('</table>');
				}	
			$id=1;
			$result_expence=$obj_invoice->MJ_lawmgt_get_single_invoice_expenses($invoice_id);
			$expense_sub_total=0;
			$expense_discount=0;
			$expense_total_tax=0;
			$expense_entry_total_amount=0;
			if(!empty($result_expence))
			{	
				$mpdf->WriteHTML('<table class="width_100_print">');	
				$mpdf->WriteHTML('<tbody>');	
					$mpdf->WriteHTML('<tr>');
						$mpdf->WriteHTML('<td class="padding_left_20_px_css">');
							$mpdf->WriteHTML('<h3 class="entry_lable font_family">'.esc_html__('Expenses Entries ','lawyer_mgt').'</h3>');
						$mpdf->WriteHTML('</td>');	
					$mpdf->WriteHTML('</tr>');	
				$mpdf->WriteHTML('</tbody>');
			$mpdf->WriteHTML('</table>');	
				
				$mpdf->WriteHTML('<table class="table table-bordered table_row_color" class="width_93" border="1">');
					$mpdf->WriteHTML('<thead>');
											
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center padding_10_pdf">#</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('DATE','lawyer_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_left font_family padding_10_pdf">'.esc_html__('EXPENSES ACTIVITY','lawyer_mgt').'</th>');						
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('QUANTITY ','lawyer_mgt').'</th>');
								 
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('AMOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('DISCOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('TAX','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('TOTAL AMOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');
								
							$mpdf->WriteHTML('</tr>');						
						
					$mpdf->WriteHTML('</thead>');
					$mpdf->WriteHTML('<tbody>');
					
							
						foreach($result_expence as $data)
						{ 							
							$expense_sub=$data->subtotal;
							$discount=$expense_sub/100 * $data->expenses_entry_discount;							
							$expense_discount+=$discount;
							$after_discount_expense=$expense_sub-$discount;
							$tax=$data->expenses_entry_tax;
							$tax1_total_amount='0';
								
							if(!empty($tax))
							{
								$tax_explode=explode(",",$tax);

								$total_tax=0;
							
								foreach($tax_explode as $tax1)
								{
									$taxvalue=MJ_lawmgt_tax_value_by_id($tax1);
									$total_tax+=$taxvalue->tax_value;
								} 
								if(!empty($total_tax))
								{	
									$tax1_total_amount=$after_discount_expense / 100 * $total_tax ;
								}
							}
							 
							$expense_total_tax+=$tax1_total_amount;
							$expense_sub_total+=$expense_sub;
							$expense_entry_total_sub_amount=$expense_sub - $discount + $tax1_total_amount;
							$expense_entry_total_amount+=$expense_entry_total_sub_amount;
							
							$bg_color = $id % 2 === 0 ? "#cad5f5" : "white";
							if($bg_color == 'white')
							{
								$bg_color_css='pdf_background_color_td_css_white';
							}
							else
							{
								$bg_color_css='pdf_background_color_td_css_blue';
							}
						  	$mpdf->WriteHTML('<tr class="entry_list '.$bg_color_css.'">');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($id).'</td>');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html(MJ_lawmgt_getdate_in_input_box($data->expense_date)).'</td>');
								$mpdf->WriteHTML('<td class="table_td_font padding_10_pdf">'.esc_html($data->expense).'</td>');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($data->quantity).'</td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($data->subtotal),2).'</td>');								
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($discount),2).'</td>');								
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($tax1_total_amount),2).'</td>');								
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($expense_entry_total_sub_amount),2).'</td>');								
						 	$mpdf->WriteHTML(' </tr>');
						
							$id=$id+1;
						}
							
							$mpdf->WriteHTML('<tr class="entry_list">');							
								$mpdf->WriteHTML('<td colspan="7" class="align_right table_td_font font_family padding_10_pdf">'.esc_html__('Expenses Entries Total Amount ','lawyer_mgt').' ('.MJ_lawmgt_get_currency_symbol().')</td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($expense_entry_total_amount),2).'</td>');	
						 	$mpdf->WriteHTML('</tr>');						
									
					
					$mpdf->WriteHTML('</tbody>');
				$mpdf->WriteHTML('</table>');
			}	
			$id=1;
			$result_flat=$obj_invoice->MJ_lawmgt_get_single_invoice_flat_fee($invoice_id);
			$flat_fee_sub_total=0;
			$flat_fee_discount=0;
			$flat_fee_total_tax=0;
			$flat_entry_total_amount=0;
			if(!empty($result_flat))
			{			
					$mpdf->WriteHTML('<table class="width_100_print">');	
				$mpdf->WriteHTML('<tbody>');	
					$mpdf->WriteHTML('<tr>');
						$mpdf->WriteHTML('<td class="padding_left_20_px_css">');
							$mpdf->WriteHTML('<h3 class="entry_lable font_family">'.esc_html__('Flat Fees Entries ','lawyer_mgt').'</h3>');
						$mpdf->WriteHTML('</td>');	
					$mpdf->WriteHTML('</tr>');	
				$mpdf->WriteHTML('</tbody>');
			$mpdf->WriteHTML('</table>');				
			
				
				$mpdf->WriteHTML('<table class="table table-bordered table_row_color" class="width_93" border="1">');
					$mpdf->WriteHTML('<thead>');
											
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center padding_10_pdf">#</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('DATE','lawyer_mgt').'</th>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_left font_family padding_10_pdf">'.esc_html__('FLATE FEE ACTIVITY','lawyer_mgt').'</th>');						
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('QUANTITY ','lawyer_mgt').'</th>');
								 
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('AMOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');								
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('DISCOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');								
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('TAX','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');								
								$mpdf->WriteHTML('<th class="color_white entry_heading align_right amount_padding_8 font_family padding_10_pdf">'.esc_html__('TOTAL AMOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');								
							$mpdf->WriteHTML('</tr>');						
						
					$mpdf->WriteHTML('</thead>');
					$mpdf->WriteHTML('<tbody>');
					
					
						foreach($result_flat as $data)
						{							
							$flat_fee_sub=$data->subtotal;
								$discount=$flat_fee_sub/100 * $data->flat_entry_discount;							
								$flat_fee_discount+=$discount;
								$after_discount_flat_fee=$flat_fee_sub-$discount;
								$tax=$data->flat_entry_tax;
								$tax1_total_amount='0';
								
								if(!empty($tax))
								{
									$tax_explode=explode(",",$tax);

									$total_tax=0;
								
									foreach($tax_explode as $tax1)
									{
										$taxvalue=MJ_lawmgt_tax_value_by_id($tax1);
										$total_tax+=$taxvalue->tax_value;
									} 
									if(!empty($total_tax))
									{	
										$tax1_total_amount=$after_discount_flat_fee / 100 * $total_tax ;
									}
								}
								$flat_fee_total_tax+=$tax1_total_amount;
								$flat_fee_sub_total+=$flat_fee_sub;	
								$flat_entry_total_sub_amount=$flat_fee_sub - $discount + $tax1_total_amount;
								$flat_entry_total_amount+=$flat_entry_total_sub_amount;	
							$bg_color = $id % 2 === 0 ? "#cad5f5" : "white";			
							if($bg_color == 'white')
							{
								$bg_color_css='pdf_background_color_td_css_white';
							}
							else
							{
								$bg_color_css='pdf_background_color_td_css_blue';
							}	
						  	$mpdf->WriteHTML('<tr class="entry_list '.$bg_color_css.'">');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($id).'</td>');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html(MJ_lawmgt_getdate_in_input_box($data->flat_fee_date)).'</td>');
								$mpdf->WriteHTML('<td class="table_td_font padding_10_pdf">'.esc_html($data->flat_fee).'</td>');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($data->quantity).'</td>');
								 
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($data->subtotal),2).'</td>');								
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($discount),2).'</td>');								
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($tax1_total_amount),2).'</td>');								
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($flat_entry_total_sub_amount),2).'</td>');								
						 	$mpdf->WriteHTML(' </tr>');
						
							$id=$id+1;
						}
							
							$mpdf->WriteHTML('<tr class="entry_list">');							
								$mpdf->WriteHTML('<td colspan="7" class="align_right table_td_font font_family padding_10_pdf">'.esc_html__('Flat Fees Total Amount ','lawyer_mgt').' ('.MJ_lawmgt_get_currency_symbol().')</td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($flat_entry_total_amount),2).'</td>');	
						 	$mpdf->WriteHTML('</tr>');						
									
					$mpdf->WriteHTML('</tbody>');
				$mpdf->WriteHTML('</table>');
			}			
				$bank_name=get_option( 'lmgt_bank_name' );
				$account_holder_name=get_option( 'lmgt_account_holder_name' );
				$account_number=get_option( 'lmgt_account_number' );
				$account_type=get_option( 'lmgt_account_type' );
				$ifsc_code=get_option( 'lmgt_ifsc_code' );
				$swift_code=get_option( 'lmgt_swift_code' );						
				
				$subtotal_amount=$time_entry_sub_total+$expense_sub_total+$flat_fee_sub_total;
						 
				$discount_amount=$time_entry_discount+$expense_discount+$flat_fee_discount;
				 
				$tax_amount=$time_entry_total_tax+$expense_total_tax+$flat_fee_total_tax;
			 
				$due_amount=$subtotal_amount-$discount_amount+$tax_amount-$invoice_info->paid_amount;
				$paid_amount=$invoice_info->paid_amount;
				$grand_total=$subtotal_amount-$discount_amount+$tax_amount;
				
				 
					$mpdf->WriteHTML('<table class="margin_left_table"  border="0">');
					$mpdf->WriteHTML('<tbody>');
						
						$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td  class="width_70 align_right"><h4 class="margin h4_pdf font_family">'.esc_html__('Subtotal Amount ','lawyer_mgt').':</h4></td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8"> <h4 class="margin h4_pdf"><span>'.MJ_lawmgt_get_currency_symbol().'</span>'.number_format(esc_html($subtotal_amount),2).'</h4></td>');
							$mpdf->WriteHTML('</tr>');
						
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin h4_pdf font_family">'.esc_html__('Discount Amount ','lawyer_mgt').' :</h4></td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8"><h4 class="margin h4_pdf"> <span >- '.MJ_lawmgt_get_currency_symbol().'</span>'.number_format(esc_html($discount_amount),2).'</h4></td>');
							$mpdf->WriteHTML('</tr>'); 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin h4_pdf font_family">'.esc_html__('Tax Amount ','lawyer_mgt').' :</h4></td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8"><h4 class="margin h4_pdf"> <span >+ '.MJ_lawmgt_get_currency_symbol().'</span>'.number_format(esc_html($tax_amount),2).'</h4></td>');
							$mpdf->WriteHTML('</tr>');
							
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin h4_pdf font_family">'.esc_html__('Paid Amount ','lawyer_mgt').' :</h4></td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8"> <h4 class="margin h4_pdf"><span >'.MJ_lawmgt_get_currency_symbol().'</span>'.number_format(esc_html($paid_amount),2).'</h4></td>');
							$mpdf->WriteHTML('</tr>');
							
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_70 align_right due_amount_color"><h4 class="margin h4_pdf font_family">'.esc_html__('Due Amount ','lawyer_mgt').' :</h4></td>');
								$mpdf->WriteHTML('<td class="align_right amount_padding_8 due_amount_color"> <h4 class="margin h4_pdf"><span >'.MJ_lawmgt_get_currency_symbol().'</span>'.number_format(esc_html($due_amount),2).'</h4></td>');
							$mpdf->WriteHTML('</tr>');
							
							$mpdf->WriteHTML('<tr>');							
								$mpdf->WriteHTML('<td  class="align_right grand_total_lable font_family padding_11"><h3 class="color_white margin font_family">'.esc_html__('Grand Total ','lawyer_mgt').':</h3></td>');
								$mpdf->WriteHTML('<td class="align_right grand_total_amount amount_padding_8"><h3 class="color_white margin">  <span>'.MJ_lawmgt_get_currency_symbol().''.number_format(esc_html($grand_total),2).'</span></h3></td>');
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
							
				
					  $mpdf->WriteHTML('<table class="margin_top_invoice" border="0">');
						$mpdf->WriteHTML('<tbody>');
						if(!empty($bank_name))  { 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td colspan="2" class="padding_left_15_px_css">');
									$mpdf->WriteHTML('<h3 class="payment_method_lable my_css font_family">'.esc_html__('Payment Method ','lawyer_mgt').'');
								$mpdf->WriteHTML('</h3>');
								$mpdf->WriteHTML('</td>');								
							$mpdf->WriteHTML('</tr>');
						}	
						if(!empty($bank_name))  { 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td  class="width_31 font_12">'.esc_html__('Bank Name ','lawyer_mgt').' </td>');
								$mpdf->WriteHTML('<td class="font_12">: '.esc_html($bank_name).'</td>');
							$mpdf->WriteHTML('</tr>');
						}
						if(!empty($bank_name))  { 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td  class="width_31 font_12">'.esc_html__('A/C Holder Name ','lawyer_mgt').'</td>');
								$mpdf->WriteHTML('<td class="font_12">: '.esc_html($account_holder_name).'</td>');
							$mpdf->WriteHTML('</tr>');
						}
						if(!empty($bank_name))  { 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_31 font_12">'.esc_html__('Account No ','lawyer_mgt').'</td>');
								$mpdf->WriteHTML('<td class="font_12">: '.esc_html($account_number).'</td>');
							$mpdf->WriteHTML('</tr>');
						}
						if(!empty($bank_name))  { 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_31 font_12">'.esc_html__('Account Type ','lawyer_mgt').'</td>');
								$mpdf->WriteHTML('<td class="font_12">: '.esc_html($account_type).'</td>');
							$mpdf->WriteHTML('</tr>');
						}
						if(!empty($bank_name))  { 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_31 font_12">'.esc_html__('IFSC Code ','lawyer_mgt').' </td>');
								$mpdf->WriteHTML('<td class="font_12">: '.esc_html($ifsc_code).'</td>');
							$mpdf->WriteHTML('</tr>');
						}
						if(!empty($bank_name))  { 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_31 font_12">'.esc_html__('Swift Code ','lawyer_mgt').' </td>');
								$mpdf->WriteHTML('<td class="font_12">: '.esc_html($swift_code).'</td>');
							$mpdf->WriteHTML('</tr>');
						}
						if(!empty($bank_name))  { 
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="width_31 font_12">'.esc_html__('Paypal ','lawyer_mgt').' </td>');
								$mpdf->WriteHTML('<td class="font_12">: '.esc_html(get_option( 'lmgt_paypal_email' )).'</td>');
							$mpdf->WriteHTML('</tr>');
						}
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>'); 
			
			$id=1;
			$result_payment=$obj_invoice->MJ_lawmgt_get_single_payment_data($invoice_id);
			if(!empty($result_payment))
			{			
					$mpdf->WriteHTML('<table class="width_100_print margin_top_invoice_new">');	
				$mpdf->WriteHTML('<tbody>');	
					$mpdf->WriteHTML('<tr>');
						$mpdf->WriteHTML('<td class="padding_left_20_px_css">');
							$mpdf->WriteHTML('<h3 class="entry_lable font_family">'.esc_html__('Payment History ','lawyer_mgt').'</h3>');
						$mpdf->WriteHTML('</td>');	
					$mpdf->WriteHTML('</tr>');	
				$mpdf->WriteHTML('</tbody>');
			$mpdf->WriteHTML('</table>');	
				
				$mpdf->WriteHTML('<table class="table table-bordered table_row_color" class="width_93" border="1">');
					$mpdf->WriteHTML('<thead>');
											
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center padding_10_pdf">#</th>');
								
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('DATE','lawyer_mgt').'</th>');
								
								$mpdf->WriteHTML('<th class="color_white entry_heading align_center amount_padding_8 font_family padding_10_pdf">'.esc_html__('AMOUNT','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>'); 

								$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('PAYMENT METHOD ','lawyer_mgt').'</th>');
								
							$mpdf->WriteHTML('</tr>');						
						
					$mpdf->WriteHTML('</thead>');
					$mpdf->WriteHTML('<tbody>');
					
						foreach($result_payment as $data)
						{							
							 
							$bg_color = $id % 2 === 0 ? "#cad5f5" : "white";
							if($bg_color == 'white')
							{
								$bg_color_css='pdf_background_color_td_css_white';
							}
							else
							{
								$bg_color_css='pdf_background_color_td_css_blue';
							}	
						  	$mpdf->WriteHTML('<tr class="entry_list '.$bg_color_css.'">');
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($id).'</td>');
								
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html(MJ_lawmgt_getdate_in_input_box($data->date)).'</td>');
								
								$mpdf->WriteHTML('<td class="align_center amount_padding_8 table_td_font padding_10_pdf">'.number_format(esc_html($data->amount),2).'</td>');	
								
								$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($data->payment_method).'</td>'); 
						 	$mpdf->WriteHTML(' </tr>');
						
							$id=$id+1;
						}
							
					$mpdf->WriteHTML('</tbody>');
				$mpdf->WriteHTML('</table>');
			}
			$gst_number=get_option( 'lmgt_gst_number' );
			$tax_id=get_option( 'lmgt_tax_id' );
			$corporate_id=get_option( 'lmgt_corporate_id' );
									
			$mpdf->WriteHTML('<table class="table_invoice my_css gst_details" border="0">');
			$mpdf->WriteHTML('<thead>');
				$mpdf->WriteHTML('<tr>');
			if(!empty($gst_number))
				{				
					$mpdf->WriteHTML('<th class="align_center font_family">'.esc_html__('GST Number ','lawyer_mgt').' </th>');
				}
			if(!empty($tax_id))
				{
					$mpdf->WriteHTML('<th class="align_center font_family">'.esc_html__('TAX ID ','lawyer_mgt').' </th>');
				}
			if(!empty($corporate_id))
				{
					$mpdf->WriteHTML('<th class="align_center font_family">'.esc_html__('Corporate ID ','lawyer_mgt').'</th>');
				}
				$mpdf->WriteHTML('</tr>');	
			$mpdf->WriteHTML('</thead>');
			$mpdf->WriteHTML('<tbody>');
				$mpdf->WriteHTML('<tr>');								
					$mpdf->WriteHTML('<td class="align_center">'.esc_html($gst_number).'</td>');
					$mpdf->WriteHTML('<td class="align_center">'.esc_html($tax_id).'</td>');
					$mpdf->WriteHTML('<td class="align_center">'.esc_html($corporate_id).'</td>');
				$mpdf->WriteHTML('</tr>');	
			$mpdf->WriteHTML('</tbody>');
			$mpdf->WriteHTML('</table>');	 
			
				$mpdf->WriteHTML('<table class="width_100 margin_bottom_20" border="0">');				
					$mpdf->WriteHTML('<tbody>');
					if(!empty($invoice_info->note))
						{
					$mpdf->WriteHTML('<tr>');
							$mpdf->WriteHTML('<td colspan="2" class="padding_left_15_px_css">');
								$mpdf->WriteHTML('<h3 class="payment_method_lable font_family">'.esc_html__('Note ','lawyer_mgt').'</h3>');
							$mpdf->WriteHTML('</td>');								
						$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('<tr>');
							$mpdf->WriteHTML('<td class="font_12 padding_left_15">'.wordwrap(esc_html($invoice_info->note),50,"<br>\n",TRUE).'</td>');
						$mpdf->WriteHTML('</tr>');
						}	
						if(!empty($invoice_info->terms))
						{
						$mpdf->WriteHTML('<tr>');
							$mpdf->WriteHTML('<td colspan="2" class="padding_left_15_px_css">');
								$mpdf->WriteHTML('<h3 class="payment_method_lable font_family">'.esc_html__('Terms & Conditions ','lawyer_mgt').'</h3>');
							$mpdf->WriteHTML('</td>');								
						$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('<tr>');
							$mpdf->WriteHTML('<td class="font_12 padding_left_15">'.wordwrap(esc_html($invoice_info->terms),50,"<br>\n",TRUE).'</td>');
						$mpdf->WriteHTML('</tr>');
						}						
					$mpdf->WriteHTML('</tbody>');
				$mpdf->WriteHTML('</table>');
				 
				$mpdf->WriteHTML('</div>');
			$mpdf->WriteHTML('</div>'); 
			
			$mpdf->WriteHTML("</body>");
			$mpdf->WriteHTML("</html>");
	
	$mpdf->Output();	
	unset($mpdf);	

} 
// end invoice pdf fuction //
//print invoice function //
function MJ_lawmgt_invoice_print()
{
	$obj_case=new MJ_lawmgt_case;
	$obj_invoice=new MJ_lawmgt_invoice;
	$invoice_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['invoice_id']));
	$invoice_info=$obj_invoice->MJ_lawmgt_get_single_invoice($invoice_id);	
	$user_id= sanitize_text_field($invoice_info->user_id);	
	$case_id=sanitize_text_field($invoice_info->case_id);
	$case_info = $obj_case->MJ_lawmgt_get_single_case($case_id);	
	$user_info=get_userdata($user_id); 	
	?>
<div class="modal-body invoice_body"> <!-- invoice body div -->
	<div class="invoice_print1">  <!-- invoice print div -->
		<img class="invoicefont1"  src="<?php echo esc_url(plugins_url('/lawyers-management/assets/images/invoice.jpg')); ?>" width="100%">
		<div class="main_div">	 <!-- main div -->				
			<table class="width_100" border="0">					
				<tbody>
					<tr>
						<td class="width_1">
							<img class="system_logo system_logo_print"  src="<?php echo esc_html(get_option( 'lmgt_system_logo' )); ?>">
						</td>							
						<td class="only_width_20">
							<table border="0">					
								<tbody>
									<tr>
										<td class="padding_bottom_17_px">
											<b><?php esc_html_e('Address :','lawyer_mgt');?></b>
										</td>	
										<td class="padding_left_5 table_td_font">
											<?php echo chunk_split(esc_html(get_option( 'lmgt_address' )),30,"<BR>").""; ?>
										</td>											
									</tr>
									<tr>
										<td>
											<b><?php esc_html_e('Email :','lawyer_mgt');?></b>
										</td>	
										<td class="padding_left_5 table_td_font">
											<?php echo esc_html(get_option( 'lmgt_email' ))."<br>"; ?>
										</td>	
									</tr>
									<tr>
										<td>
											<b><?php esc_html_e('Phone :','lawyer_mgt');?></b>
										</td>	
										<td class="padding_left_5 table_td_font">
											<?php echo esc_html(get_option( 'lmgt_contact_number' ))."<br>";  ?>
										</td>											
									</tr>
								</tbody>
							</table>	
						</td>
						<td align="right" class="width_24">
						</td>
					</tr>
				</tbody>
			</table>
			<table class="width_50" border="0">
				<tbody>				
					<tr>
						<td colspan="2" class="billed_to width_9 print_width_9" align="center">								
							<h3 class="billed_to_lable" ><?php _e('| Bill To.','lawyer_mgt');?> </h3>
						</td>
						<td class="width_40 table_td_font">								
						<?php 							
							echo "<h3 class='display_name'>".chunk_split(ucwords(esc_html($user_info->display_name)),30,"<BR>"). "</h3>";
							$address=$user_info->address;
									
							echo chunk_split(esc_html($address),30,"<BR>"); 	
							echo esc_html($user_info->city_name).","; 
							echo esc_html($user_info->pin_code)."<br>"; 
							echo esc_html($user_info->mobile)."<br>"; 								
						?>			
						</td>
					</tr>									
				</tbody>
			</table>
				<?php 	
				$issue_date=MJ_lawmgt_getdate_in_input_box($invoice_info->generated_date);						
				$payment_status= sanitize_text_field($invoice_info->payment_status);
				$invoice_no=sanitize_text_field($invoice_info->invoice_number);
								?>
			<table class="width_50" border="0">
				<tbody>				
					<tr>	
						<td class="width_30">
						</td>
						<td class="print_width_10" align="center">
							<h3 class="invoice_lable invoice_color"><span class="font_size_12_px_css"><?php echo esc_html__('INVOICE','lawyer_mgt'); '#'?><br></span><span class="font_size_18_px_css"><?php echo esc_html($invoice_no); ?></span></h3>
							<h5 class="invoice_date_status"> <?php   echo esc_html__('Date','lawyer_mgt')." : ".esc_html($issue_date); ?></h5>
							<h5 class="invoice_date_status"><?php echo esc_html__('Status','lawyer_mgt')." : ". esc_html__($payment_status,'lawyer_mgt');?></h5>									
						</td>							
					</tr>									
				</tbody>
			</table>
			<?php  
			$id=1;
			$result_time=$obj_invoice->MJ_lawmgt_get_single_invoice_time_entry($invoice_id);
			$time_entry_sub_total=0;
			$time_entry_discount=0;
			$time_entry_total_tax=0;
			$time_entry_total_amount=0;
			if(!empty($result_time))
			{	
			?>
			<table class="width_100">	
				<tbody>		
					<tr>
						<td>						
							<h3 class="entry_lable margin_bottom_5"><?php esc_html_e('Time Entries','lawyer_mgt');?></h3>
						</td>
					</tr>	
				</tbody>	
			</table>		
			<table class="table table-bordered width_100 margin_bottom_10  table_row_color print_table_border" border="1">
				<thead class="entry_heading entry_heading_print print_entry_heading">					
						<tr>
							<th class="color_white align_center">#</th>
							<th class="color_white align_center"> <?php esc_html_e('DATE','lawyer_mgt');?></th>
							<th class="color_white"><?php esc_html_e('TIME ENTRY ACTIVITY','lawyer_mgt');?> </th>
							<th class="color_white align_center"><?php esc_html_e('HOURS','lawyer_mgt');?></th><th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('AMOUNT','lawyer_mgt');?></th>
							<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('DISCOUNT','lawyer_mgt');?></th>
							<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('TAX','lawyer_mgt');?></th>
							<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('TOTAL AMOUNT','lawyer_mgt');?></th>														
						</tr>						
				</thead>
				<tbody>
				<?php					
							
						foreach($result_time as $data)
						{ 
							$time_entry_sub= sanitize_text_field($data->subtotal);							
							$discount=$time_entry_sub/100 * $data->time_entry_discount;
							$time_entry_discount+=$discount;
							$after_discount_time_entry_sub=$time_entry_sub-$discount;
							$tax=sanitize_text_field($data->time_entry_tax);
							$tax1_total_amount='0';
								
							if(!empty($tax))
							{
								$tax_explode=explode(",",$tax);

								$total_tax=0;
							
								foreach($tax_explode as $tax1)
								{
									$taxvalue=MJ_lawmgt_tax_value_by_id($tax1);
									$total_tax+=$taxvalue->tax_value;
								} 
								if(!empty($total_tax))
								{	
									$tax1_total_amount=$after_discount_time_entry_sub / 100 * $total_tax ;
								}
							}								
							$time_entry_total_tax+=$tax1_total_amount;
							$time_entry_sub_total+=$time_entry_sub;	
							$time_entry_total_sub_amount=$time_entry_sub - $discount + $tax1_total_amount;
							$time_entry_total_amount+=$time_entry_total_sub_amount;					
							
						?>						 
						  <tr class="entry_list">
							<td class="align_center table_td_font"><?php echo esc_html($id); ?></td>
							<td class="align_center table_td_font"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($data->time_entry_date));?></td>
							<td class="table_td_font"><?php echo esc_html($data->time_entry);?></td>							
							<td class="align_center table_td_font"><?php echo esc_html($data->hours); ?></td>
							<td class="align_right"><?php echo  number_format(esc_html($data->subtotal),2);?></td>
							<td class="align_right"><?php echo  number_format(esc_html($discount),2);?></td>
							<td class="align_right"><?php echo  number_format(esc_html($tax1_total_amount),2);?></td>
							<td class="align_right"><?php echo  number_format(esc_html($time_entry_total_sub_amount),2);?></td>							
						  </tr>
						<?php
						$id=$id+1;
						}
							?>
						<tr class="entry_list">							
								<td colspan="7" class="align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().") :</span>".esc_html_e('Time Entries Total Amount ','lawyer_mgt');?></td>
								<td class="align_right"><?php echo  number_format(esc_html($time_entry_total_amount),2);?></td>		
							</tr>
						<?php	
					}						
					?>
				</tbody>
			</table>
			<?php  
			$id=1;
				$result_expense=$obj_invoice->MJ_lawmgt_get_single_invoice_expenses($invoice_id);
				$expense_sub_total=0;
				$expense_discount=0;
				$expense_total_tax=0;
				$expense_entry_total_amount=0;
				if(!empty($result_expense))
			{	
			?>
				<table class="width_100">	
				<tbody>		
					<tr>
						<td>						
							<h3 class="entry_lable margin_bottom_5"><?php esc_html_e('Expenses Entries','lawyer_mgt');?></h3>
						</td>
					</tr>	
				</tbody>	
			</table>		
			<table class="table table-bordered width_100 margin_bottom_10 table_row_color print_table_border" border="1">
				<thead class="entry_heading entry_heading_print print_entry_heading">					
						<tr>
							<th class="color_white align_center">#</th>
							<th class="color_white align_center"> <?php esc_html_e('DATE','lawyer_mgt');?></th>
							<th class="color_white"><?php esc_html_e('EXPENSES ACTIVITY','lawyer_mgt');?> </th>	
							<th class="color_white align_center"><?php esc_html_e('QUANTITY','lawyer_mgt');?></th><th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('AMOUNT','lawyer_mgt');?></th>
							<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('DISCOUNT','lawyer_mgt');?></th>
							<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('TAX','lawyer_mgt');?></th>
							<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('TOTAL AMOUNT','lawyer_mgt');?></th>														
						</tr>						
				</thead>
				<tbody>
				<?php					
					
						foreach($result_expense as $data)
						{ 							
							$expense_sub=$data->subtotal;
							$discount=$expense_sub/100 * $data->expenses_entry_discount;							
							$expense_discount+=$discount;
							$after_discount_expense=$expense_sub-$discount;
							$tax=$data->expenses_entry_tax;
							$tax1_total_amount='0';
								
							if(!empty($tax))
							{
								$tax_explode=explode(",",$tax);

								$total_tax=0;
							
								foreach($tax_explode as $tax1)
								{
									$taxvalue=MJ_lawmgt_tax_value_by_id($tax1);
									$total_tax+=$taxvalue->tax_value;
								} 
								if(!empty($total_tax))
								{	
									$tax1_total_amount=$after_discount_expense / 100 * $total_tax ;
								}
							}
							 
							$expense_total_tax+=$tax1_total_amount;
							$expense_sub_total+=$expense_sub;
							$expense_entry_total_sub_amount=$expense_sub - $discount + $tax1_total_amount;
							$expense_entry_total_amount+=$expense_entry_total_sub_amount;
							?>						 
						  <tr class="entry_list">
							<td class="align_center"><?php echo esc_html($id); ?></td>
							<td class="align_center"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($data->expense_date)); ?></td>
							<td><?php echo esc_html($data->expense); ?></td>							
							<td class="align_center"><?php echo esc_html($data->quantity); ?></td>
							<td class="align_right"><?php echo  number_format(esc_html($data->subtotal),2);?></td>
							<td class="align_right"><?php echo  number_format(esc_html($discount),2);?></td>
							<td class="align_right"><?php echo  number_format(esc_html($tax1_total_amount),2);?></td>
							<td class="align_right"><?php echo  number_format(esc_html($expense_entry_total_sub_amount),2);?></td>								
						  </tr>
							<?php
							$id=$id+1;
						}
						?>
						<tr class="entry_list">							
								<td colspan="7" class="align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().") :</span>".esc_html_e('Expenses Entries Total Amount ','lawyer_mgt');?></td>
								<td class="align_right"><?php echo  number_format(esc_html($expense_entry_total_amount),2);?></td>
						</tr>
						<?php	
					}		
					?>
				</tbody>
			</table>
			<?php  
			$id=1;
				$result_falt=$obj_invoice->MJ_lawmgt_get_single_invoice_flat_fee($invoice_id);
				$flat_fee_sub_total=0;
				$flat_fee_discount=0;
				$flat_fee_total_tax=0;
				$flat_entry_total_amount=0;
				if(!empty($result_falt))
				{	
			?>
				<table class="width_100">	
				<tbody>		
					<tr>
						<td>						
							<h3 class="entry_lable margin_bottom_5"><?php esc_html_e('Flat Fees Entries','lawyer_mgt');?></h3>
						</td>
					</tr>	
				</tbody>	
			</table>		
			<table class="table table-bordered width_100 table_row_color print_table_border" border="1">
				<thead class="entry_heading entry_heading_print print_entry_heading">					
						<tr>
							<th class="color_white align_center">#</th>
							<th class="color_white align_center"> <?php esc_html_e('DATE','lawyer_mgt');?></th>
							<th class="color_white"><?php esc_html_e('FLATE FEE ACTIVITY','lawyer_mgt');?> </th>	
							<th class="color_white align_center"><?php esc_html_e('QUANTITY','lawyer_mgt');?></th><th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('AMOUNT','lawyer_mgt');?></th>
							<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('DISCOUNT','lawyer_mgt');?></th>
							<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('TAX','lawyer_mgt');?></th>
							<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('TOTAL AMOUNT','lawyer_mgt');?></th>														
						</tr>						
				</thead>
				<tbody>
				<?php					
					
					foreach($result_falt as $data)
							{							
								$flat_fee_sub=$data->subtotal;
								$discount=$flat_fee_sub/100 * $data->flat_entry_discount;							
								$flat_fee_discount+=$discount;
								$after_discount_flat_fee=$flat_fee_sub-$discount;
								$tax=$data->flat_entry_tax;
								$tax1_total_amount='0';
								
								if(!empty($tax))
								{
									$tax_explode=explode(",",$tax);

									$total_tax=0;
								
									foreach($tax_explode as $tax1)
									{
										$taxvalue=MJ_lawmgt_tax_value_by_id($tax1);
										$total_tax+=$taxvalue->tax_value;
									} 
									if(!empty($total_tax))
									{	
										$tax1_total_amount=$after_discount_flat_fee / 100 * $total_tax ;
									}
								}
								$flat_fee_total_tax+=$tax1_total_amount;
								$flat_fee_sub_total+=$flat_fee_sub;	
								$flat_entry_total_sub_amount=$flat_fee_sub - $discount + $tax1_total_amount;
								$flat_entry_total_amount+=$flat_entry_total_sub_amount;
								?>						 
								  <tr class="entry_list">
									<td class="align_center"><?php echo esc_html($id); ?></td>
									<td class="align_center"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($data->flat_fee_date)); ?></td>
									<td><?php echo esc_html($data->flat_fee); ?></td>
									<td class="align_center"><?php echo esc_html($data->quantity); ?></td>
									<td class="align_right"><?php echo  number_format(esc_html($data->subtotal),2);?></td>
									<td class="align_right"><?php echo  number_format(esc_html($discount),2);?></td>
									<td class="align_right"><?php echo  number_format(esc_html($tax1_total_amount),2);?></td>
									<td class="align_right"><?php echo  number_format(esc_html($flat_entry_total_sub_amount),2);?></td>
								  </tr>
								<?php
								$id=$id+1;
							}
							?>
							 <tr class="entry_list">							
								<td colspan="7" class="align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().") :</span>".esc_html_e('Flat Fees Total Amount ','lawyer_mgt');?></td>
								<td class="align_right"><?php echo number_format(esc_html($flat_entry_total_amount),2);?></td>		
							 </tr>
						<?php	
					}		
					?>
				</tbody>
			</table>
			<table class="width_54" border="0">
				<tbody>
					<?php						
						$bank_name=get_option( 'lmgt_bank_name' );
						 
						$account_holder_name=get_option( 'lmgt_account_holder_name' );
						$account_number=get_option( 'lmgt_account_number' );
						$account_type=get_option( 'lmgt_account_type' );
						$ifsc_code=get_option( 'lmgt_ifsc_code' );
						$swift_code=get_option( 'lmgt_swift_code' );						
						
						$subtotal_amount=$time_entry_sub_total+$expense_sub_total+$flat_fee_sub_total;
						 
						$discount_amount=$time_entry_discount+$expense_discount+$flat_fee_discount;
						 
						$tax_amount=$time_entry_total_tax+$expense_total_tax+$flat_fee_total_tax;
					 
						$due_amount=$subtotal_amount-$discount_amount+$tax_amount-$invoice_info->paid_amount;
						$paid_amount=$invoice_info->paid_amount;
						$grand_total=$subtotal_amount-$discount_amount+$tax_amount;
					?>
					 
					<tr>
						<td class="width_70 align_right"><h4 class="margin"><?php esc_html_e('Subtotal Amount:','lawyer_mgt');?></h4></td>
						<td class="align_right amount_padding_8"> <h4 class="margin"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".number_format(esc_html($subtotal_amount),2);?></h4></td>
					</tr>
					
						<tr>
							<td class="width_70 align_right"><h4 class="margin"><?php esc_html_e('Discount Amount :','lawyer_mgt');?></h4></td>
							<td class="align_right amount_padding_8"> <h4 class="margin"><?php if(!empty($discount_amount)){ echo "<span> -(".MJ_lawmgt_get_currency_symbol().")</span>".number_format(esc_html($discount_amount),2); }else{ echo "<span> -(".MJ_lawmgt_get_currency_symbol().")</span>".'0'; } ?></h4></td>
						</tr>
						<tr>
							<td class="width_70 align_right"><h4 class="margin"><?php esc_html_e('Tax Amount :','lawyer_mgt');?></h4></td>
							<td class="align_right amount_padding_8"><h4 class="margin"><?php if(!empty($tax_amount)){ echo "<span> +(".MJ_lawmgt_get_currency_symbol().")</span>".number_format(esc_html($tax_amount),2); }else{ echo "<span>+(".MJ_lawmgt_get_currency_symbol().")</span>".'0'; }?></h4></td>
						</tr>	
						<tr>
							<td class="width_70 align_right"><h4 class="margin"><?php esc_html_e('Paid Amount :','lawyer_mgt');?></h4></td>
							<td class="align_right amount_padding_8"> <h4 class="margin"><span ><?php if(!empty($paid_amount)){ echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".number_format(esc_html($paid_amount),2); }else{ echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".'0'; }?></h4></td>
						</tr>						
						<tr>
							<td class="width_70 align_right due_amount_color"><h4 class="margin"><?php esc_html_e('Due Amount :','lawyer_mgt');?></h4></td>
							<td class="align_right amount_padding_8 due_amount_color"> <h4 class="margin"><span ><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".number_format(esc_html($due_amount),2); ?></h4></td>
						</tr>
						
					
					<tr>							
						<td class="align_right grand_total_lable grand_total_lable1 padding_11"><h3 class="padding color_white margin"><?php esc_html_e('Grand Total :','lawyer_mgt');?></h3></td>
						<td class="align_right grand_total_amount grand_total_amount1 amount_padding_8 padding_11"><h3 class="padding color_white margin"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".number_format(esc_html($grand_total),2); ?></h3></td>
					</tr>							
				</tbody>
			</table>		
			<table class="width_46" border="0">  <!-- payment methode table -->
				<tbody>	
				<?php  if(!empty($bank_name))  {  ?>
					<tr>
						<td colspan="2">
							<h3 class="payment_method_lable"><?php esc_html_e('Payment Method','lawyer_mgt');?>
							</h3>
						</td>								
					</tr>	
				<?php   } ?>
				<?php  if(!empty($bank_name))  {  ?>
					<tr>
						<td class="width_31 font_12"><?php esc_html_e('Bank Name ','lawyer_mgt');  ?></td>
						<td class="font_12">: <?php echo esc_html($bank_name);?></td>
					</tr>
				<?php   } ?>
				<?php  if(!empty($account_holder_name))  {  ?>
					<tr>
						<td class="width_31 font_12"><?php esc_html_e('A/C Holder Name ','lawyer_mgt'); ?></td>
						<td class="font_12">: <?php echo esc_html($account_holder_name);?></td>
					</tr>
				<?php   } ?>
				<?php  if(!empty($account_number))  {  ?>
					<tr>
						<td class="width_31 font_12"><?php esc_html_e('Account No ','lawyer_mgt'); ?></td>
						<td class="font_12">: <?php echo esc_html($account_number);?></td>
					</tr>
				<?php   } ?>
				<?php  if(!empty($account_type))  {  ?>
					<tr>
						<td class="width_31 font_12"><?php esc_html_e('Account Type ','lawyer_mgt'); ?></td>
						<td class="font_12">: <?php echo esc_html($account_type);?></td>
					</tr>
				<?php   } ?>
				<?php  if(!empty($ifsc_code))  {  ?>
					<tr>
						<td class="width_31 font_12"><?php esc_html_e('IFSC Code ','lawyer_mgt'); ?></td>
						<td class="font_12">: <?php echo esc_html($ifsc_code);?></td>
					</tr>
				<?php   } ?>
				<?php  if(!empty($swift_code))  {  ?>	
					<tr>
						<td class="width_31 font_12"><?php esc_html_e('Swift Code ','lawyer_mgt'); ?></td>
						<td class="font_12">: <?php echo esc_html($swift_code);?></td>
					</tr>
				<?php   } ?>
				<?php  if(!empty($bank_name))  {  ?>
					<tr>
						<td class="width_31 font_12"> <?php esc_html_e('Paypal ','lawyer_mgt'); ?></td>
						<td class="font_12">: <?php echo esc_html(get_option( 'lmgt_paypal_email' ));?></td>
					</tr>
				<?php   } ?>
				</tbody>
			</table> <!--end  payment methode table -->	
				<?php   
					$id=1;
					$result_payment=$obj_invoice->MJ_lawmgt_get_single_payment_data($invoice_id);
					 
					if(!empty($result_payment))
					{	?>
			<table class="width_100">	
				<tbody>		
					<tr>
						<td>						
							<h3 class="entry_lable"><?php esc_html_e('Payment History','lawyer_mgt');?></h3>
						</td>
					</tr>	
				</tbody>	
			</table>
			<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<table class="table table-bordered width_100 margin_bottom_10  table_row_color print_table_border" border="1">
					<thead class="entry_heading entry_heading_print print_entry_heading">					
							<tr>
								<th class="color_white align_center">#</th>
								<th class="color_white align_center"> <?php esc_html_e('DATE','lawyer_mgt');?></th>
								<th class="color_white align_center"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('AMOUNT','lawyer_mgt');?></th>
								<th class="color_white align_center"><?php esc_html_e('PAYMENT METHOD','lawyer_mgt');?> </th>
							</tr>						
					</thead>
					<tbody>
					<?php					
						
						foreach($result_payment as $data)
						{ 							
							?>						 
						  <tr class="entry_list">
							<td class="align_center"><?php echo esc_html($id);?></td>
							<td class="align_center"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($data->date));?></td>
							<td class="align_center"><?php echo  number_format(esc_html($data->amount),2);?></td>
							<td class="align_center"><?php echo esc_html($data->payment_method);?></td>
						  </tr>
							<?php
							$id=$id+1;
						}
					}		
						?>
					</tbody>
				</table>
			</div>			
			<?php			
			$gst_number=get_option( 'lmgt_gst_number' );
			$tax_id=get_option( 'lmgt_tax_id' );
			$corporate_id=get_option( 'lmgt_corporate_id' );
			?>							
			<table class="table_invoice gst_details" border="0"> <!-- gst details table -->	
			<thead>
				<tr>
					<?php 
						if(!empty($gst_number))
						{
						?>
					<th class="align_center"> <?php esc_html_e('GST Number','lawyer_mgt');?></th>
					<?php
						}					
						if(!empty($tax_id))
						{
						?>
					<th class="align_center"> <?php esc_html_e('TAX ID','lawyer_mgt');?></th>
					<?php 
						}
						if(!empty($corporate_id))
						{
						?>
					<th class="align_center"> <?php esc_html_e('Corporate ID','lawyer_mgt');?></th>
						<?php
						}  ?>
				</tr>	
			</thead>
			<tbody>
				<tr>								
					<td class="align_center"><?php echo esc_html($gst_number);?></td>
					<td class="align_center"><?php echo esc_html($tax_id);?></td>
					<td class="align_center"><?php echo esc_html($corporate_id);?></td>
				</tr>	
			</tbody>
			</table> <!--end  gst details table -->	
		<table class="width_100 margin_bottom_20" border="0">				
				<tbody>
					<?php  
					if(!empty($invoice_info->note))
					{
					?>
					<tr>
						<td colspan="2">
							<h3 class="payment_method_lable"><?php esc_html_e('Note','lawyer_mgt');?>
							</h3>
						</td>								
					</tr>
					<tr>
						<td class="font_12 padding_left_15"><?php echo wordwrap(esc_html($invoice_info->note),50,"<br>\n",TRUE);?></td>
					</tr>
					<?php  }  ?>
					<?php  
					if(!empty($invoice_info->terms))
					{
					?>
					<tr>
						<td colspan="2">
							<h3 class="payment_method_lable"><?php esc_html_e('Terms & Conditions','lawyer_mgt');?>
							</h3>
						</td>								
					</tr>
					<tr>
						<td class="font_12 padding_left_15"><?php echo wordwrap(esc_html($invoice_info->terms),50,"<br>\n",TRUE);?></td>
					</tr>	
				<?php  }  ?>
				</tbody>
			</table>
		</div> <!--end  main div -->	
	</div> <!-- end invoice print div -->
</div><!-- end invoice body div -->
<?php
die();		
} //print invoice function //
// add group
function MJ_lawmgt_add_group($data)
{
	global $wpdb;
	$model = sanitize_text_field($_REQUEST['model']);
	
	$data['group_name'] = sanitize_text_field($_REQUEST['group_name']);

	$group_id = wp_insert_post(array('post_title'=>sanitize_text_field($_REQUEST['group_name']), 'post_type'=>'contact_group'));
	$groupid = $wpdb->insert_id;
	$row1 = '<tr id="group-'.sanitize_text_field($groupid).'"><td>'.sanitize_text_field($_REQUEST['group_name']).'</td><td><a class="btn-delete-group badge badge-delete" href="#" id='.esc_attr($groupid).' model="'.esc_attr($model).'">X</a></td></tr>';

	$option = '<option value=" '.sanitize_text_field($groupid).' ">'.sanitize_text_field($_REQUEST['group_name']).'</option>';

	$array_var[] = $row1;
	$array_var[] = $option;
	echo json_encode($array_var);
	die();	 
	
}
// remove group
function MJ_lawmgt_remove_group()
{
	wp_delete_post(sanitize_text_field($_REQUEST['group_id']));
	die();
}
 
//add new customfield
function MJ_lawmgt_add_new_customfield()
{
	
	global $wpdb;		
	$table_custom_field = $wpdb->prefix. 'lmgt_custom_field';
	
	$model = sanitize_text_field($_REQUEST['model']);	
	$form_name = sanitize_text_field($_REQUEST['form_name']);
	$customfield_name = sanitize_text_field($_REQUEST['customfield_name']);
	$field_type = sanitize_text_field($_REQUEST['field_type']);
	$customfieldtype_value = sanitize_text_field($_REQUEST['customfieldtype_value']);
	$required = sanitize_text_field($_REQUEST['required']);
	$validation_type = sanitize_text_field($_REQUEST['validation_type']);
	$edit = sanitize_text_field($_REQUEST['edit']);
	
	if($field_type == 'textbox')
	{
		$validation_value= sanitize_text_field($_REQUEST['validation_type']);
	}
	else
	{
		$validation_value='';		
	}				
		//custom_field table insert field	
		$custom_field['form_name']=sanitize_text_field($_REQUEST['form_name']);
		$custom_field['type']= sanitize_text_field($_REQUEST['field_type']);
		$custom_field['lable']= sanitize_text_field($_REQUEST['customfield_name']);
		$custom_field['always_visible']= sanitize_text_field($_REQUEST['always_visible']);
		$custom_field['required']= sanitize_text_field($_REQUEST['required']);
		$custom_field['validation']=$validation_value;
		$customfieldtype_value = array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['customfieldtype_value'] ));
		$custom_field['optional_values']=implode(",", $customfieldtype_value);
		$custom_field['status']='show';		
		$custom_field['remove_timestamp']='0000-00-00 00:00:00';
		$custom_field['created_date']=date("Y-m-d H:i:s");
		$custom_field['updated_date']=date("Y-m-d H:i:s");

		$result=$wpdb->insert( $table_custom_field, $custom_field);
		$inserted_field_id=$wpdb->insert_id;
		
		if($field_type == 'textbox')
		{
			if($required == 'yes')
			{
				$array_var['name'][]='<div class="form-group"><label class="col-sm-2 control-label" for="name"><b>'.esc_html($customfield_name).'<b><span class="require-field">*</span></label>';
				$array_var['type'][]='<label class="col-sm-1 control-label" for="name">Textbox</label><div class="col-sm-9"><input type="button" id="addcustomfield" custom_field_id="'.esc_attr($inserted_field_id).'"  value="'.esc_html__('Edit','lawyer_mgt').'" edit="edit" class="btn btn-info editcustomfield"><input type="button" value="'.esc_html__('Remove','lawyer_mgt').'" custom_field_id="'.esc_attr($inserted_field_id).'" class="btn btn-danger deletecustomfield"></div></div>';
			}
			else
			{
				$array_var['name'][]='<div class="form-group"><label class="col-sm-2 control-label" for="name"><b>'.esc_html($customfield_name).'<b></label>';
				$array_var['type'][]='<label class="col-sm-1 control-label" for="name">Textbox</label><div class="col-sm-9"><input type="button" id="addcustomfield" custom_field_id="'.esc_attr($inserted_field_id).'"  value="'.esc_html__('Edit','lawyer_mgt').'" edit="edit" class="btn btn-info editcustomfield"><input type="button" value="'.esc_html__('Remove','lawyer_mgt').'" custom_field_id="'.esc_attr($inserted_field_id).'"  class="btn btn-danger deletecustomfield"></div></div>';
			}	
		}
		elseif($field_type == 'textarea')
		{
			if($required == 'yes')
			{
				$array_var['name'][]='<div class="form-group"><label class="col-sm-2 control-label" for="name"><b>'.esc_html($customfield_name).'</b><span class="require-field">*</span></label>';
				$array_var['type'][]='<label class="col-sm-1 control-label" for="name">Textarea</label><div class="col-sm-9"><input type="button" id="addcustomfield" custom_field_id="'.esc_attr($inserted_field_id).'"  value="'.esc_html__('Edit','lawyer_mgt').'" edit="edit" class="btn btn-info editcustomfield"><input type="button" value="'.esc_html__('Remove','lawyer_mgt').'" custom_field_id="'.esc_attr($inserted_field_id).'"  class="btn btn-danger deletecustomfield"></div></div>';
			}
			else
			{
				$array_var['name'][]='<div class="form-group"><label class="col-sm-2 control-label" for="name"><b>'.esc_html($customfield_name).'</b></label><input type="hidden" name="lable[]" value="'.$customfield_name.'">';
				$array_var['type'][]='<label class="col-sm-1 control-label" for="name">Textarea</label><div class="col-sm-9"><input type="button" id="addcustomfield" custom_field_id="'.esc_attr($inserted_field_id).'"  value="'.esc_html__('Edit','lawyer_mgt').'" edit="edit" class="btn btn-info editcustomfield"><input type="button" value="'.esc_html__('Remove','lawyer_mgt').'"  custom_field_id="'.esc_attr($inserted_field_id).'"  class="btn btn-danger deletecustomfield"></div></div>';
			}
		}	
		elseif($field_type == 'dropdownlist')
		{
			$array_var['name'][]='<div class="form-group"><label class="col-sm-2 control-label" for="name"><b>'.esc_html($customfield_name).'</b></label>';
			
			$array_var['type'][]='<label class="col-sm-1 control-label" for="name">Dropdownlist</label><div class="col-sm-9"><input type="button" id="addcustomfield" custom_field_id="'.esc_attr($inserted_field_id).'"  value="'.esc_html__('Edit','lawyer_mgt').'" edit="edit" class="btn btn-info editcustomfield"><input type="button" value="'.esc_html__('Remove','lawyer_mgt').'" custom_field_id="'.esc_attr($inserted_field_id).'"   class="btn btn-danger deletecustomfield"></div></div>';
			
		}
		elseif($field_type == 'number')
		{
			if($required == 'yes')
			{
				$array_var['name'][]='<div class="form-group"><label class="col-sm-2 control-label" for="name"><b>'.esc_html($customfield_name).'</b><span class="require-field">*</span></label>';
				$array_var['type'][]='<label class="col-sm-1 control-label" for="name">Number</label><div class="col-sm-9"><input type="button" id="addcustomfield" custom_field_id="'.esc_attr($inserted_field_id).'"  value="'.esc_html__('Edit','lawyer_mgt').'" edit="edit" class="btn btn-info editcustomfield"><input type="button" value="'.esc_html__('Remove','lawyer_mgt').'"  custom_field_id="'.esc_attr($inserted_field_id).'"  class="btn btn-danger deletecustomfield"></div></div>';
			}
			else
			{
				$array_var['name'][]='<div class="form-group"><label class="col-sm-2 control-label" for="name"><b>'.esc_html($customfield_name).'</b></label>';
				$array_var['type'][]='<label class="col-sm-1 control-label" for="name">Number</label><div class="col-sm-9"><input type="button" id="addcustomfield" custom_field_id="'.esc_attr($inserted_field_id).'"  value="'.esc_html__('Edit','lawyer_mgt').'" edit="edit" class="btn btn-info editcustomfield"><input type="button" value="'.esc_html__('Remove','lawyer_mgt').'" custom_field_id="'.esc_attr($inserted_field_id).'"  class="btn btn-danger deletecustomfield"></div></div>';
			}		
		}
		elseif($field_type == 'date')
		{
			if($required == 'yes')
			{
				$array_var['name'][]='<div class="form-group"><label class="col-sm-2 control-label" for="name"><b>'.esc_html($customfield_name).'</b><span class="require-field">*</span></label>';
				$array_var['type'][]='<label class="col-sm-1 control-label" for="name">Date</label><div class="col-sm-9"><input type="button" id="addcustomfield" custom_field_id="'.esc_attr($inserted_field_id).'"  value="'.esc_html__('Edit','lawyer_mgt').'" edit="edit" class="btn btn-info editcustomfield"><input type="button" value="'.esc_html__('Remove','lawyer_mgt').'" custom_field_id="'.esc_attr($inserted_field_id).'"   class="btn btn-danger deletecustomfield"></div></div>';
			}
			else
			{
				$array_var['name'][]='<div class="form-group"><label class="col-sm-2 control-label" for="name"><b>'.esc_html($customfield_name).'</b></label>';
				$array_var['type'][]='<label class="col-sm-1 control-label" for="name">Date</label><div class="col-sm-9"><input type="button" id="addcustomfield" custom_field_id="'.esc_attr($inserted_field_id).'"  value="'.esc_html__('Edit','lawyer_mgt').'" edit="edit" class="btn btn-info editcustomfield"><input type="button" custom_field_id="'.esc_attr($inserted_field_id).'"  value="'.esc_html__('Remove','lawyer_mgt').'"  class="btn btn-danger deletecustomfield"></div></div>';
			}
		}
		
	$array_var['form_name'][]=$form_name;
	echo json_encode($array_var);
	
	die();		 
}
//update custom field
function MJ_lawmgt_update_customfield($data)
{	
	global $wpdb;		
	$table_custom_field = $wpdb->prefix. 'lmgt_custom_field';
	//custom_field table update field		
	$custom_field_id['id']= sanitize_text_field($_REQUEST['custom_field_id']);
	$custom_field['lable']= sanitize_text_field($_REQUEST['customfield_name']);
	$custom_field['always_visible']= sanitize_text_field($_REQUEST['always_visible']);
	$custom_field['required']=sanitize_text_field($_REQUEST['required']);
	$custom_field['validation']=sanitize_text_field($_REQUEST['validation_type']);
	
	$result=$wpdb->update( $table_custom_field, $custom_field,$custom_field_id);
	
	die();		
}	
//add more customfield option value
function MJ_lawmgt_get_customfield_option_value($data)
{		
	$array_var[]='<div class="control-group customfieldvalue_css addmorecustomvalue"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label">Value<span class="require-field">*</span></label><div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><input id="customfieldtype_value" class=" form-control text-input validate[required]" value="" name="customfieldtype_value[]" type="text" placeholder=""></div><div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><input type="button" value="'.esc_html__('Remove','lawyer_mgt').'" class="btn btn-danger deletecustomfield"></div></div>'; 	 
	
	echo json_encode($array_var);
	die();		
} 
//remove button customfield Remove from the database
function MJ_lawmgt_add_attorney_into_database($data)
{		
	$custom_field_id= sanitize_text_field($_REQUEST['custom_field_id']);

	global $wpdb;		
	$table_custom_field = $wpdb->prefix. 'lmgt_custom_field';
	
	$remove_timestamp=date("Y-m-d H:i:s");
	
	$result = $wpdb->query("UPDATE $table_custom_field SET status='hide',remove_timestamp='$remove_timestamp' where id= ".$custom_field_id);	
	
	echo json_encode($result);
	die();		
}
//get all contact Form Custom field
 function MJ_lawmgt_get_contact_form_all_CustomFields()
{
	global $wpdb;
	$table_custom_field = $wpdb->prefix. 'lmgt_custom_field';
	$result = $wpdb->get_results("SELECT * FROM $table_custom_field where form_name='contact' AND status='show'");
	return $result;
}
//get all case Form Custom field
 function lawmgt_get_case_form_all_CustomFields()
{
	global $wpdb;
	$table_custom_field = $wpdb->prefix. 'lmgt_custom_field';
	$result = $wpdb->get_results("SELECT * FROM $table_custom_field where form_name='case' AND status='show'");
	return $result;
}
//get stafflink attorney info
function MJ_lawmgt_get_stafflink_attorney_info()
{		
	$stafflink_attorney_id = sanitize_text_field($_REQUEST['stafflink_attorney_id']);
	
	$array_var=array();		
	foreach($stafflink_attorney_id as $key=>$id)
	{
		$obj_case=new MJ_lawmgt_case;
		$case_id=sanitize_text_field($_REQUEST['case_id']);
		$stafflink_attorney = get_userdata($id);
		$default_rate=number_format($stafflink_attorney->rate ,2);
		$rate_type=$stafflink_attorney->rate_type;
		
		$default_rate=$obj_case->MJ_lawmgt_get_staff_user_edited_fee_value($case_id,$default_rate,$id);		
		
		$array_var[]='<div class="form-group remove_attorney_div"><label class="col-sm-2 control-label" for="attorne_name">'.esc_html($stafflink_attorney->display_name).'<span class="require-field">*</span><input type="hidden" name="attorney_user_id[]" value="'.esc_attr($stafflink_attorney->ID).'"></label><div class="col-sm-2"><input id="rate" step="0.01" class="form-control validate[required]" value="'.esc_attr($default_rate).'" name="rate[]" type="number" min="0" placeholder=""></div><div><label class="control-label" for="name">'.esc_html__("/").esc_html($rate_type).'</label></div></div>'; 	
	}
		
	echo json_encode($array_var);
	die();		
}
//add attorney into database
function lawmgt_add_attorney_into_database()
{		
	$obj_user=new MJ_lawmgt_Users;
	if(isset($_FILES['upload_user_avatar_image']) && !empty($_FILES['upload_user_avatar_image']) && $_FILES['upload_user_avatar_image']['size'] !=0)
	{
		if($_FILES['upload_user_avatar_image']['size'] > 0)
		{
		 $image=MJ_lawmgt_load_documets($_FILES['upload_user_avatar_image'],$_FILES['upload_user_avatar_image'],'pimg');
		
		 $image_url= sanitize_url(content_url().'/uploads/document_upload/'.esc_attr($image));

		}
		else 
		{
			$image= sanitize_text_field($_REQUEST['hidden_upload_user_avatar_image']);
			$image_url=$image;
		}					
	}
	else
	{
		if(isset($_REQUEST['hidden_upload_user_avatar_image']))
			$image= sanitize_url($_REQUEST['hidden_upload_user_avatar_image']);
			$image_url=$image;
	}
	
	if(isset($_FILES['attorney_cv']) && !empty($_FILES['attorney_cv']) && $_FILES['attorney_cv']['size'] !=0)
	{
	
		if($_FILES['attorney_cv']['size'] > 0)
			$cv=MJ_lawmgt_load_documets($_FILES['attorney_cv'],$_FILES['attorney_cv'],'cv');		
		
	}		
		
	if(isset($_FILES['education_certificate']) && !empty($_FILES['education_certificate']) && $_FILES['education_certificate']['size'] !=0)
	{
		if($_FILES['education_certificate']['size'] > 0)
			$education_cert=MJ_lawmgt_load_documets($_FILES['education_certificate'],$_FILES['education_certificate'],'Edu');
	}		
		
	if(isset($_FILES['experience_cert']) && !empty($_FILES['experience_cert']) && $_FILES['experience_cert']['size'] !=0)
	{
		if($_FILES['experience_cert']['size'] > 0)
			$experience_cert=MJ_lawmgt_load_documets($_FILES['experience_cert'],$_FILES['experience_cert'],'Exp');
	}		
	
	$result=$obj_user->MJ_lawmgt_add_user($_POST);
	
	$returnans=update_user_meta( $result,'lmgt_user_avatar',$image_url);
	
	$result_upload=$obj_user->MJ_lawmgt_upload_documents($cv,$education_cert,$experience_cert,$result);
	
	 $attorney_data=get_userdata($result);
	 
	 $option = "<option value='".$attorney_data->ID."'>".$attorney_data->display_name."</option>";		
	 
	 $array_var[] = $option;
	 
	 echo json_encode($array_var);
	 die();    
		
}	
//add Workflow into database
function MJ_lawmgt_add_workflow_into_database()
{
	$obj_workflow=new MJ_lawmgt_workflow;		
	
	$result=$obj_workflow->MJ_lawmgt_add_workflow($_POST);
	
	global $wpdb;

	$table_workflows = $wpdb->prefix. 'lmgt_workflows';

	$workflow_data = $wpdb->get_row("SELECT * FROM $table_workflows ORDER BY id DESC LIMIT 1");

	$option = "<option value='".esc_attr($workflow_data->id)."'>".esc_html($workflow_data->name)."</option>";

	$array_var[] = $option;
	
	echo json_encode($array_var);
	die();     
}	
//get role by id
function MJ_lawmgt_get_roles($user_id)
{
	$roles = array();
	$user = new WP_User( $user_id );

	if ( !empty( $user->roles ) && is_array( $user->roles ) )
	{
		foreach ( $user->roles as $role )
			 return $role;
	}	
}
//contact add in dropdownlist by company
function MJ_lawmgt_conatct_by_company()
{
	$company_contact_id = sanitize_text_field($_REQUEST['company_contact_id']);

	$contactdata = get_users(
				array(
					'role' => 'client',
					'meta_query' => array(
					array(
							'key' => 'archive',
							'value' =>0,
							'compare' => '='
						),
					array(
							'key' => 'company',
							'value' =>$company_contact_id,
							'compare' => '='
						),
					)
				));	
	$array_var=array();
	foreach($contactdata as $contactname)
	{ 		
		$array_var[]= array("id" => "$contactname->ID", "name" => "$contactname->display_name");	 
	}
	
   echo json_encode($array_var);				
   die;
}

//case add in dropdownlist by contact name
function MJ_lawmgt_caselist_by_contact_name()
{
	$caselist_by_contact_id = sanitize_text_field($_REQUEST['caselist_by_contact_id']);
	
	global $wpdb;	
	$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';			
	$result = $wpdb->get_results("SELECT * FROM $table_case_contacts where user_id=".$caselist_by_contact_id);	
		
	$array_var=array();
	foreach($result as $data)
	{ 
		$case_id=$data->case_id;
		
		$obj_case=new MJ_lawmgt_case;
		$result_case_info=$obj_case->MJ_lawmgt_get_case_name_using_id($case_id);
		
		$array_var[]= array("id" => "$result_case_info->id", "name" => "$result_case_info->case_name");
		 
	}
		
	echo json_encode($array_var);				
   die;
}
//add practice area
function MJ_lawmgt_add_practice_area($data)
{
	global $wpdb;

	$model = sanitize_text_field($_REQUEST['model']);
	
	$practice_area_id=$wpdb->insert_id;

	$practice_area_id = wp_insert_post(array('post_title'=>sanitize_text_field($_REQUEST['practice_area']), 'post_type'=>'practice_area'));
	
	$row1 = '<tr id="practice_area-'.esc_attr($practice_area_id).'"><td>'.sanitize_text_field($_REQUEST['practice_area']).'</td><td id="'.esc_attr($practice_area_id).'"><a class="btn-delete-practice_area badge badge-delete" href="#" id='.esc_attr($practice_area_id).' model="'.esc_attr($model).'">X</a></td></tr>';

	$option = "<option value='esc_attr($practice_area_id)'>".sanitize_text_field($_REQUEST['practice_area'])."</option>";

	$array_var[] = $row1;
	$array_var[] = $option;
	echo json_encode($array_var);
	die();
}

//remove practice Area
function MJ_lawmgt_remove_practice_area()
{
	wp_delete_post($_REQUEST['practice_area_id']);
	die();
}
// GROUP filter
function MJ_lawmgt_serch_group1()
{			
	if($_REQUEST['selection_id']=='-1')
	{
		$contactdata = get_users(
					array(
						'role' => 'client',
						'meta_query' => array(
						array(
						'key' => 'archive',
						'value' =>0,
						'compare' => '='
						),
					)
				));
					
		$userdata = array();	
		
		foreach($contactdata as $users)
		{	
			$contact_id=$users->ID;
			
			$contact_caselink=array();
			global $wpdb;
			$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
			$table_cases = $wpdb->prefix. 'lmgt_cases';
			$result_caselink= $wpdb->get_results("SELECT case_id FROM $table_case_contacts where user_id=".$contact_id);
		   foreach ($result_caselink as $key => $object)
		   {			
			 $case_id=$object->case_id;
			 $case_name= $wpdb->get_results("SELECT id,case_name FROM $table_cases where id=".$case_id);
			  foreach ($case_name as $key => $object)
			  {	
				$contact_caselink[]='<a href="?page=cases&tab=casedetails&action=view&case_id='.esc_attr($object->id).'">'.esc_html($object->case_name).'</a>';
			  }					
		   }
			
			$caselink=implode(',',$contact_caselink);
			
			 
			$uid=$users->ID;
			$userimage=get_user_meta($uid, 'lmgt_user_avatar', true);
			if(empty($userimage))
			 {
			   $userimage=get_option( 'lmgt_system_logo' );	
			 }
			 else
			 {
				 $userimage=get_user_meta($uid, 'lmgt_user_avatar', true);
			 }	
			$user ='<tr><td>'.'<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>'.'</td>
					<td><a href="?page=contacts&tab=add_contact&action=view&contact_id='.esc_attr($users->ID).'">'.esc_html($users->display_name).'</a></td><td>'.esc_html(get_the_title($users->group)).'</td>
					<td>'.esc_html($users->user_email).'</td><td>'.esc_html($users->mobile).'</td><td>'.$caselink.'</td>				   
					<td>'.'
					<a href="?page=contacts&tab=add_contact&action=view&contact_id='.esc_attr($users->ID).'" class="btn btn-success">View</a>
					<a href="?page=contacts&tab=add_contact&action=edit&contact_id='.esc_attr($users->ID).'" class="btn btn-info">Edit</a>
					<a href="?page=contacts&tab=contactlist&action=delete&contact_id='.esc_attr($users->ID).'" class="btn btn-danger" 
					onclick="return confirm(Are you sure you want to delete this record?);">
					 Delete</a>'.'
					</td></tr>';	
			$userdata[]=$user;					
		} 	
	}
	else
	{
		$contact_group_type= sanitize_text_field($_REQUEST['selection_id']);
	
			$contactdata = get_users(
			array(
				'role' => 'client',
				'meta_query' => array(
				array(
						'key' => 'archive',
						'value' =>0,
						'compare' => '='
					),
				array(
						'key' => 'group',
						'value' =>$contact_group_type,
						'compare' => '='
					),
				)
			));		
		
		$userdata = array();	
		
		foreach($contactdata as $users)
		{	
			$contact_id=$users->ID;
		
			$contact_caselink=array();
			global $wpdb;
			$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
			$table_cases = $wpdb->prefix. 'lmgt_cases';
			$result_caselink= $wpdb->get_results("SELECT case_id FROM $table_case_contacts where user_id=".$contact_id);
			foreach ($result_caselink as $key => $object)
			{			
				$case_id=$object->case_id;
				$case_name= $wpdb->get_results("SELECT id,case_name FROM $table_cases where id=".$case_id);
				foreach ($case_name as $key => $object)
				{	
					$contact_caselink[]='<a href="?page=cases&tab=casedetails&action=view&case_id='.esc_attr($object->id).'">'.esc_html($object->case_name).'</a>';
				}					
			}
		
			$caselink=implode(',',$contact_caselink);
			
		 
			$uid=$users->ID;
			$userimage=get_user_meta($uid, 'lmgt_user_avatar', true);
			if(empty($userimage))
			{
				$userimage=get_option( 'lmgt_system_logo' );	
			}
			else
			{
				$userimage=get_user_meta($uid, 'lmgt_user_avatar', true);
			}	
			$user ='<tr><td>'.'<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>'.'</td>
				<td><a href="?page=contacts&tab=add_contact&action=view&contact_id='.$users->ID.'">'.esc_html($users->display_name).'</a></td><td>'.esc_html(get_the_title($users->group)).'</td>
				 <td>'.esc_html($users->user_email).'</td><td>'.esc_html($users->mobile).'</td><td>'.$caselink.'</td>
				<td>'.'
				<a href="?page=contacts&tab=add_contact&action=view&contact_id='.esc_attr($users->ID).'" class="btn btn-success">View</a>
				<a href="?page=contacts&tab=add_contact&action=edit&contact_id='.esc_attr($users->ID).'" class="btn btn-info">Edit</a>
				<a href="?page=contacts&tab=contactlist&action=delete&contact_id='.esc_attr($users->ID).'" class="btn btn-danger" 
				onclick="return confirm(Are you sure you want to delete this record?);">
				 Delete</a>'.'
				</td></tr>';	
			$userdata[]=$user;					
		} 			
	}					
	echo json_encode($userdata);
	die();
}
function MJ_lawmgt_serch_group2()
{	
	if($_REQUEST['selection_id']=='-1')
	{
		$contactdata = get_users(
					array(
						'role' => 'client',
						'meta_query' => array(
						array(
						'key' => 'archive',
						'value' =>1,
						'compare' => '='
						),
					)
				));
		
		$userdata = array();	
	
		foreach($contactdata as $users)
		{
		
			$contact_id=$users->ID;
			
			$contact_caselink=array();
			global $wpdb;
			$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
			$table_cases = $wpdb->prefix. 'lmgt_cases';
			$result_caselink= $wpdb->get_results("SELECT case_id FROM $table_case_contacts where user_id=".$contact_id);
		   foreach ($result_caselink as $key => $object)
		   {			
			  $case_id=$object->case_id;
			  $case_name= $wpdb->get_results("SELECT id,case_name FROM $table_cases where id=".$case_id);
			  foreach ($case_name as $key => $object)
			  {	
				$contact_caselink[]='<a href="?page=cases&tab=casedetails&action=view&case_id='.esc_attr($object->id).'">'.esc_html($object->case_name).'</a>';
			  }					
		   }
			
			$caselink=implode(',',$contact_caselink);
			
			 
			$uid=$retrieved_data->ID;
			$userimage=get_user_meta($uid, 'lmgt_user_avatar', true);
		
			if(empty($userimage))
			{
			   $userimage=get_option( 'lmgt_system_logo' );	
			}
			else
			{
				 $userimage=get_user_meta($uid, 'lmgt_user_avatar', true);
			}				 
			 
			$user ='<tr><td>'.'<img src='.esc_url($userimage).' height="50px" width="50px" class="img-circle"/>'.'</td>
					<td><a href="?page=contacts&tab=add_contact&action=view&contact_id='.esc_attr($users->ID).'">'.esc_html($users->display_name).'</a></td><td>'.esc_html(get_the_title($users->group)).'</td>
					 <td>'.esc_html($users->user_email).'</td><td>'.esc_html($users->mobile).'</td><td>'.$caselink.'</td>
					<td>'.'
					<a href="?page=contacts&tab=add_contact&action=view&contact_id='.esc_attr($users->ID).'" class="btn btn-success">View</a>'.'
					</td>
					</tr>';	
			$userdata[]=$user;					
		} 			
	}
	else
	{
		$contact_group_type= sanitize_text_field($_REQUEST['selection_id']);
		
				$contactdata = get_users(
				array(
					'role' => 'client',
					'meta_query' => array(
					array(
							'key' => 'archive',
							'value' =>1,
							'compare' => '='
						),
					array(
							'key' => 'group',
							'value' =>$contact_group_type,
							'compare' => '='
						),
					)
				));		
		
		$userdata = array();	
	
		foreach($contactdata as $users)
		{
		
			$contact_id=$users->ID;
			
			$contact_caselink=array();
			global $wpdb;
			$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
			$table_cases = $wpdb->prefix. 'lmgt_cases';
			$result_caselink= $wpdb->get_results("SELECT case_id FROM $table_case_contacts where user_id=".$contact_id);
		   foreach ($result_caselink as $key => $object)
		   {			
			  $case_id=$object->case_id;
			  $case_name= $wpdb->get_results("SELECT id,case_name FROM $table_cases where id=".$case_id);
			  foreach ($case_name as $key => $object)
			  {	
				$contact_caselink[]='<a href="?page=cases&tab=casedetails&action=view&case_id='.esc_attr($object->id).'">'.esc_html($object->case_name).'</a>';
			  }					
		   }
			
			$caselink=implode(',',$contact_caselink);
			
			 
			$uid=$retrieved_data->ID;
			$userimage=get_user_meta($uid, 'lmgt_user_avatar', true);
		
			if(empty($userimage))
			 {
			   $userimage=get_option( 'lmgt_system_logo' );	
			 }
			 else
			 {
				 $userimage=get_user_meta($uid, 'lmgt_user_avatar', true);
			 }				 
			 
			$user ='<tr><td>'.'<img src='.esc_url($userimage).' height="50px" width="50px" class="img-circle"/>'.'</td>
					<td><a href="?page=contacts&tab=add_contact&action=view&contact_id='.esc_attr($users->ID).'">'.esc_html($users->display_name).'</a></td><td>'.esc_html(get_the_title($users->group)).'</td>
					 <td>'.esc_html($users->user_email).'</td><td>'.esc_html($users->mobile).'</td><td>'.$caselink.'</td>
					<td>'.'
					<a href="?page=contacts&tab=add_contact&action=view&contact_id='.esc_attr($users->ID).'" class="btn btn-success">View</a>'.'
					</td>
					</tr>';	
			$userdata[]=$user;					
		} 	
	}				
	echo json_encode($userdata);
	die();
}

//practice_Area filter all open Firmcase
 function MJ_lawmgt_serch_practice_Area1()
 {
			
	if($_REQUEST['selection_id']=='-1')
	{
		 global $wpdb;
		 $table_case = $wpdb->prefix. 'lmgt_cases';	
		 $casedata = $wpdb->get_results("SELECT * FROM $table_case where case_status='open'");
	
		$practice_area_data = array();	
		
		foreach($casedata as $case_practice_area)
		{			
			
			$case_id=$case_practice_area->id;
			$user=explode(",",$case_practice_area->case_assgined_to);
			$case_assgined_to=array();
			if(!empty($user))
			{						
				foreach($user as $data4)
				{
					$case_assgined_to[]=MJ_lawmgt_get_display_name($data4);
				}
			}		
						
			$caselink_contact=array();
			global $wpdb;
			$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';

			$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
			 foreach ($result_link_contact as $key => $object)
			 {			
				 $result=get_userdata($object->user_id);
				 $caselink_contact[]='<a href="?page=contacts&tab=add_contact&action=view&contact_id='.esc_attr($object->user_id).'">'.esc_html($result->user_nicename).'</a>';
									
			  }			
			$contact=implode(',',$caselink_contact);				
			
			$practice_area ='<tr><td>'.'<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr($case_practice_area->id).'">'.esc_html($case_practice_area->case_name).'</a></td>
					<td>'.esc_html($case_practice_area->case_number).'</td>
					<td>'.esc_html(get_the_title($case_practice_area->practice_area_id)).'</td>
					<td>'.$contact.'</td>
					<td>'.esc_html(implode(", ",$case_assgined_to)).'</td>
					<td>'.'<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr($case_practice_area->id).'" class="btn btn-success">View</a>
					<a href="?page=cases&tab=add_case&action=edit&tab1=allfirmcase&case_id='.esc_attr($case_practice_area->id).'" class="btn btn-info"> Edit</a>
						<a href="?page=cases&tab=caselist&action=delete&tab1=allfirmcase&case_id='.esc_attr($case_practice_area->id).'" class="btn btn-danger" 
					onclick="return confirm(Are you sure you want to delete this record?);">
					 Delete</a>'.'
					</td></tr>';	
			$practice_area_data[]=$practice_area;					
		} 	
	}
	else
	{
		$practice_Area= sanitize_text_field($_REQUEST['selection_id']);
		
		 global $wpdb;
		 $table_case = $wpdb->prefix. 'lmgt_cases';	
		 $casedata = $wpdb->get_results("SELECT * FROM $table_case where case_status='open' AND practice_area_id=$practice_Area");
	
		$practice_area_data = array();	
		
		foreach($casedata as $case_practice_area)
		{			
			
			$case_id=$case_practice_area->id;
			
			$user=explode(",",$case_practice_area->case_assgined_to);
			$case_assgined_to=array();
			if(!empty($user))
			{						
				foreach($user as $data4)
				{
					$case_assgined_to[]=MJ_lawmgt_get_display_name($data4);
				}
			}	
			$caselink_contact=array();
			global $wpdb;
			$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';

			$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
			foreach ($result_link_contact as $key => $object)
			{			
				$result=get_userdata($object->user_id);
				$caselink_contact[]='<a href="?page=contacts&tab=add_contact&action=view&contact_id='.esc_attr($object->user_id).'">'.$result->user_nicename.'</a>';
									
			}			
			$contact=implode(',',$caselink_contact);				
			
			$practice_area ='<tr><td>'.'<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr($case_practice_area->id).'">'.esc_html($case_practice_area->case_name).'</a></td>
					<td>'.esc_html($case_practice_area->case_number).'</td>
					<td>'.esc_html(get_the_title($case_practice_area->practice_area_id)).'</td>
					<td>'.$contact.'</td>
					<td>'.esc_html(implode(", ",$case_assgined_to)).'</td>
					<td>'.'<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr($case_practice_area->id).'" class="btn btn-success">View</a>
					<a href="?page=cases&tab=add_case&action=edit&tab1=allfirmcase&case_id='.esc_attr($case_practice_area->id).'" class="btn btn-info"> Edit</a>
						<a href="?page=cases&tab=caselist&action=delete&tab1=allfirmcase&case_id='.esc_attr($case_practice_area->id).'" class="btn btn-danger" 
					onclick="return confirm(Are you sure you want to delete this record?);">
					 Delete</a>'.'
					</td></tr>';	
			$practice_area_data[]=$practice_area;					
		} 	
	}	
		
	echo json_encode($practice_area_data);
	
	die();  
}
//practice_Area filter all close Firmcase
 function MJ_lawmgt_serch_practice_Area2()
 {	
	if($_REQUEST['selection_id']=='-1')
	{
		 global $wpdb;
		 $table_case = $wpdb->prefix. 'lmgt_cases';	
		 $casedata = $wpdb->get_results("SELECT * FROM $table_case where case_status='close'");
	
		$practice_area_data = array();	
		
		foreach($casedata as $case_practice_area)
		{				
			$case_id=$case_practice_area->id;
			$attorne_name=get_userdata($case_practice_area->case_assgined_to);
			$caselink_contact=array();
			global $wpdb;
			$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';

			$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
			
			 foreach ($result_link_contact as $key => $object)
			 {			
				 $result=get_userdata($object->user_id);
				 $caselink_contact[]='<a href="?page=contacts&tab=add_contact&action=view&tab2=caseinfo&contact_id='.esc_attr($object->user_id).'">'.esc_html($result->user_nicename).'</a>';					
			  }
			$contact=implode(',',$caselink_contact);		
			
			$practice_area ='<tr><td>'.'<a href="?page=cases&tab=casedetails&action=view&case_id='.esc_attr($case_practice_area->id).'">'.esc_html($case_practice_area->case_name).'</a></td>
					<td>'.esc_html($case_practice_area->case_number).'</td>
					<td>'.esc_html(get_the_title($case_practice_area->practice_area_id)).'</td>
					<td>'.$contact.'</td>
					<td><a href="?page=attorney&tab=view_attorney&action=view&attorney_id='.esc_attr($case_practice_area->case_assgined_to).'">'.esc_html($attorne_name->display_name).'</a></td>
					<td>'.'<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr($case_practice_area->id).'" class="btn btn-success">View</a>'.'</td></tr>';	
			$practice_area_data[]=$practice_area;					
		} 	
	}
	else
	{
		 $practice_Area= sanitize_text_field($_REQUEST['selection_id']);
			
		 global $wpdb;
		 $table_case = $wpdb->prefix. 'lmgt_cases';	
		 $casedata = $wpdb->get_results("SELECT * FROM $table_case where case_status='close' AND practice_area_id=$practice_Area");
	
		$practice_area_data = array();	
		
		foreach($casedata as $case_practice_area)
		{				
			$case_id=$case_practice_area->id;
			$attorne_name=get_userdata($case_practice_area->case_assgined_to);
			
			$caselink_contact=array();
			global $wpdb;
			$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';

			$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
			
			 foreach ($result_link_contact as $key => $object)
			 {			
				 $result=get_userdata($object->user_id);
				 $caselink_contact[]='<a href="?page=contacts&tab=add_contact&action=view&contact_id='.esc_attr($object->user_id).'">'.esc_html($result->user_nicename).'</a>';								
			  }
			$contact=implode(',',$caselink_contact);		
			
			$practice_area ='<tr><td>'.'<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr($case_practice_area->id).'">'.esc_html($case_practice_area->case_name).'</a></td>
					<td>'.esc_html($case_practice_area->case_number).'</td>
					<td>'.esc_html(get_the_title($case_practice_area->practice_area_id)).'</td>
					<td>'.$contact.'</td>
					<td><a href="?page=attorney&tab=view_attorney&action=view&attorney_id='.esc_attr($case_practice_area->case_assgined_to).'">'.esc_html($attorne_name->display_name).'</a></td>
					<td>'.'<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr($case_practice_area->id).'" class="btn btn-success">View</a>'.'</td></tr>';	
			$practice_area_data[]=$practice_area;					
		} 	
	}	
	echo json_encode($practice_area_data);
	
	die();  
}
//practice_Area filter all open mycase
function MJ_lawmgt_serch_practice_Area3()
{	 
	if($_REQUEST['selection_id']=='-1')
	{
		 $user = wp_get_current_user();
		 $id=$user->ID;
		 global $wpdb;
		 $table_case = $wpdb->prefix. 'lmgt_cases';	
		 $casedata = $wpdb->get_results("SELECT * FROM $table_case where case_status='open' AND user_id=".$id);
	
		$practice_area_data = array();	
		
		foreach($casedata as $case_practice_area)
		{			
			
			$case_id=$case_practice_area->id;
			$attorne_name=get_userdata($case_practice_area->case_assgined_to);
				
			$caselink_contact=array();
			global $wpdb;
			$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';

			$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
			 foreach ($result_link_contact as $key => $object)
			 {			
				 $result=get_userdata($object->user_id);
				 $caselink_contact[]='<a href="?page=contacts&tab=add_contact&action=view&contact_id='.esc_attr($object->user_id).'">'.esc_html($result->user_nicename).'</a>';
									
			  }			
			$contact=implode(',',$caselink_contact);				
			
			$practice_area ='<tr><td>'.'<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr($case_practice_area->id).'">'.esc_html($case_practice_area->case_name).'</a></td>
					<td>'.esc_html($case_practice_area->case_number).'</td>
					<td>'.esc_html(get_the_title($case_practice_area->practice_area_id)).'</td>
					<td>'.$contact.'</td>
					<td><a href="?page=attorney&tab=view_attorney&action=view&attorney_id='.esc_attr($case_practice_area->case_assgined_to).'">'.esc_html($attorne_name->display_name).'</a></td>
					<td>'.'<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr($case_practice_area->id).'" class="btn btn-success">View</a><a href="?page=cases&tab=add_case&action=edit&case_id='.esc_attr($case_practice_area->id).'" class="btn btn-info"> Edit</a>
						<a href="?page=cases&tab=caselist&action=delete&case_id='.esc_attr($case_practice_area->id).'" class="btn btn-danger" 
					onclick="return confirm(Are you sure you want to delete this record?);">
					 Delete</a>'.'
					</td></tr>';	
			$practice_area_data[]=$practice_area;					
		} 	
	}
	else
	{
		$practice_Area= sanitize_text_field($_REQUEST['selection_id']);
		 $user = wp_get_current_user();
		 $id=$user->ID;
		 global $wpdb;
		 $table_case = $wpdb->prefix. 'lmgt_cases';	
		 $casedata = $wpdb->get_results("SELECT * FROM $table_case where case_status='open' AND practice_area_id=$practice_Area AND user_id=".$id);
	
		$practice_area_data = array();	
		
		foreach($casedata as $case_practice_area)
		{			
			
			$case_id=$case_practice_area->id;
			$attorne_name=get_userdata($case_practice_area->case_assgined_to);
				
			$caselink_contact=array();
			global $wpdb;
			$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';

			$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
			foreach ($result_link_contact as $key => $object)
			{			
				 $result=get_userdata($object->user_id);
				 $caselink_contact[]='<a href="?page=contacts&tab=add_contact&action=view&contact_id='.esc_attr($object->user_id).'">'.esc_html($result->user_nicename).'</a>';									
			}			
			$contact=implode(',',$caselink_contact);				
			
			$practice_area ='<tr><td>'.'<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr($case_practice_area->id).'">'.esc_html($case_practice_area->case_name).'</a></td>
					<td>'.esc_html($case_practice_area->case_number).'</td>
					<td>'.esc_html(get_the_title($case_practice_area->practice_area_id)).'</td>
					<td>'.$contact.'</td>
					<td><a href="?page=attorney&tab=view_attorney&action=view&attorney_id='.esc_attr($case_practice_area->case_assgined_to).'">'.esc_html($attorne_name->display_name).'</a></td>
					<td>'.'<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr($case_practice_area->id).'" class="btn btn-success">View</a><a href="?page=cases&tab=add_case&action=edit&case_id='.esc_attr($case_practice_area->id).'" class="btn btn-info"> Edit</a>
						<a href="?page=cases&tab=caselist&action=delete&case_id='.esc_attr($case_practice_area->id).'" class="btn btn-danger" 
					onclick="return confirm(Are you sure you want to delete this record?);">
					 Delete</a>'.'
					</td></tr>';	
			$practice_area_data[]=$practice_area;					
		}
	}	
	echo json_encode($practice_area_data);
	
	die();  
} //end practice_Area filter all open mycase
//practice_Area filter all close mycase
function MJ_lawmgt_serch_practice_Area4()
{	
	
	if($_REQUEST['selection_id']=='-1')
	{
		$user = wp_get_current_user();
		 $id=$user->ID;	
		 global $wpdb;
		 $table_case = $wpdb->prefix. 'lmgt_cases';	
		 $casedata = $wpdb->get_results("SELECT * FROM $table_case where case_status='close' AND user_id=".$id);
	
		$practice_area_data = array();	
		
		foreach($casedata as $case_practice_area)
		{				
			$case_id=$case_practice_area->id;
			$attorne_name=get_userdata($case_practice_area->case_assgined_to);
			
			$caselink_contact=array();
			global $wpdb;
			$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';

			$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
			
			 foreach ($result_link_contact as $key => $object)
			 {			
				 $result=get_userdata($object->user_id);
				 $caselink_contact[]='<a href="?page=contacts&tab=add_contact&action=view&contact_id='.esc_attr($object->user_id).'">'.esc_html($result->user_nicename).'</a>';							
			  }
			$contact=implode(',',$caselink_contact);		
			
			$practice_area ='<tr><td>'.'<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr($case_practice_area->id).'">'.esc_html($case_practice_area->case_name).'</a></td>
					<td>'.esc_html($case_practice_area->case_number).'</td>
					<td>'.esc_html(get_the_title($case_practice_area->practice_area_id)).'</td>
					<td>'.$contact.'</td>
					<td><a href="?page=attorney&tab=view_attorney&action=view&attorney_id='.esc_attr($case_practice_area->case_assgined_to).'">'.esc_html($attorne_name->display_name).'</a></td>
					<td>'.'<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr($case_practice_area->id).'" class="btn btn-success">View</a>'.'</td></tr>';						
			$practice_area_data[]=$practice_area;					
		} 	
	}
	else
	{
		$practice_Area= sanitize_text_field($_REQUEST['selection_id']);
		 $user = wp_get_current_user();
		 $id=$user->ID;	
		 global $wpdb;
		 $table_case = $wpdb->prefix. 'lmgt_cases';	
		 $casedata = $wpdb->get_results("SELECT * FROM $table_case where case_status='close' AND practice_area_id=$practice_Area AND user_id=".$id);
	
		$practice_area_data = array();	
		
		foreach($casedata as $case_practice_area)
		{				
			$case_id=$case_practice_area->id;
			$attorne_name=get_userdata($case_practice_area->case_assgined_to);
			
			$caselink_contact=array();
			global $wpdb;
			$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';

			$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
			
			 foreach ($result_link_contact as $key => $object)
			 {			
				 $result=get_userdata($object->user_id);
				 $caselink_contact[]='<a href="?page=contacts&tab=add_contact&action=view&contact_id='.esc_attr($object->user_id).'">'.esc_html($result->user_nicename).'</a>';							
			  }
			$contact=implode(',',$caselink_contact);		
			
			$practice_area ='<tr><td>'.'<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr($case_practice_area->id).'">'.esc_html($case_practice_area->case_name).'</a></td>
					<td>'.esc_html($case_practice_area->case_number).'</td>
					<td>'.esc_html(get_the_title($case_practice_area->practice_area_id)).'</td>
					<td>'.$contact.'</td>
					<td><a href="?page=attorney&tab=view_attorney&action=view&attorney_id='.esc_attr($case_practice_area->case_assgined_to).'">'.esc_html($attorne_name->display_name).'</a></td>
					<<td>'.'<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr($case_practice_area->id).'" class="btn btn-success">View</a>'.'</td></tr>';	
			$practice_area_data[]=$practice_area;					
		}
	}	
	echo json_encode($practice_area_data);
	
	die();  
} //end practice_Area filter all close mycase
//Case Name filter all documents
function MJ_lawmgt_serch_case_name_all_documents()
{	
	if($_REQUEST['selection_id']=='-1')
	{
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';	
		$casename_filter_result = $wpdb->get_results("SELECT * FROM $table_documents");

		$casename_filter_data = array();	
	
		foreach($casename_filter_result as $data)
		{			
				$case_id=$data->case_id;
							
				global $wpdb;		
				$table_cases = $wpdb->prefix. 'lmgt_cases';
				$case_name= $wpdb->get_row("SELECT case_name FROM $table_cases where id=".$case_id);

				$Case_name_row ='<tr><td>'.esc_html($data->title).'</td>
					<td>'.esc_html($data->type).'</td>
					<td>'.esc_html($case_name->case_name).'</td>															
					<td>'.esc_html($data->tag_names).'</td>															
					<td>'.esc_html($data->last_update).'</td>
					<td>'.'<a href="'.content_url().'/uploads/document_upload/'.esc_attr($data->document_url).'" class="status_read btn btn-success" record_id="'.esc_attr($data->id).'">view</a>
					<a href="?page=documents&tab=add_documents&action=edit&tab1=alldocuments&documents_id='.esc_attr($data->id).'" class="btn btn-info"> Edit</a>
						<a href="?page=documents&tab=add_documents&action=edit&tab1=alldocuments&documents_id='.esc_attr($data->id).'" class="btn btn-danger" 
					onclick="return confirm(Are you sure you want to delete this record?);">
					 Delete</a>'.'
					</td></tr>';	
			$casename_filter_data[]=$Case_name_row;					
		} 	
	}
	else
	{
		$selection_id= sanitize_text_field($_REQUEST['selection_id']);
			
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';	
		$casename_filter_result = $wpdb->get_results("SELECT * FROM $table_documents where case_id=$selection_id");

		$casename_filter_data = array();		
	
		foreach($casename_filter_result as $data)
		{			
			$case_id=$data->case_id;
						
			global $wpdb;		
			$table_cases = $wpdb->prefix. 'lmgt_cases';
			$case_name= $wpdb->get_row("SELECT case_name FROM $table_cases where id=".$case_id);

			$Case_name_row ='<tr><td>'.esc_html($data->title).'</td>
				<td>'.esc_html($data->type).'</td>
				<td>'.esc_html($case_name->case_name).'</td>	
				<td>'.esc_html($data->tag_names).'</td>																
				<td>'.esc_html($data->last_update).'</td>
				<td>'.'<a href="'.content_url().'/uploads/document_upload/'.esc_attr($data->document_url).'" class="status_read btn btn-success" record_id="'.esc_attr($data->id).'">view</a>
				<a href="?page=documents&tab=add_documents&action=edit&tab1=alldocuments&documents_id='.esc_attr($data->id).'" class="btn btn-info"> Edit</a>
					<a href="?page=documents&tab=add_documents&action=edit&tab1=alldocuments&documents_id='.esc_attr($data->id).'" class="btn btn-danger" 
				onclick="return confirm(Are you sure you want to delete this record?);">
				 Delete</a>'.'
				</td></tr>';	
			$casename_filter_data[]=$Case_name_row;					
		} 
	}
	echo json_encode($casename_filter_data);	
	die();  
} //end Case Name filter all documents

//Case Name filter unread documents
function MJ_lawmgt_serch_case_name_unread_documents()
{
	if($_REQUEST['selection_id']=='-1')
	{
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';	
		$casename_filter_result = $wpdb->get_results("SELECT * FROM $table_documents where status='unread'");

		$casename_filter_data = array();		
	
		foreach($casename_filter_result as $data)
		{			
				$case_id=$data->case_id;
							
				global $wpdb;		
				$table_cases = $wpdb->prefix. 'lmgt_cases';
				$case_name= $wpdb->get_row("SELECT case_name FROM $table_cases where id=".$case_id);

				$Case_name_row ='<tr><td>'.esc_html($data->title).'</td>
					<td>'.esc_html($data->type).'</td>
					<td>'.esc_html($case_name->case_name).'</td>															
					<td>'.esc_html($data->tag_names).'</td>															
					<td>'.esc_html($data->last_update).'</td>					
					<td>'.'<a href="'.content_url().'/uploads/document_upload/'.esc_attr($data->document_url).'" class="status_read btn btn-success" record_id="'.esc_attr($data->id).'">view</a>
					<a href="?page=documents&tab=add_documents&action=edit&tab1=unreaddocuments&documents_id='.esc_attr($data->id).'" class="btn btn-info"> Edit</a>
						<a href="?page=documents&tab=add_documents&action=edit&tab1=unreaddocuments&documents_id='.esc_attr($data->id).'" class="btn btn-danger" 
					onclick="return confirm(Are you sure you want to delete this record?);">
					 Delete</a>'.'
					</td></tr>';	
			$casename_filter_data[]=$Case_name_row;					
		}
	}
	else
	{
		$selection_id= sanitize_text_field($_REQUEST['selection_id']);
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';	
		$casename_filter_result = $wpdb->get_results("SELECT * FROM $table_documents where case_id=$selection_id AND status='unread'");

		$casename_filter_data = array();			
	
		foreach($casename_filter_result as $data)
		{			
			$case_id=$data->case_id;
						
			global $wpdb;		
			$table_cases = $wpdb->prefix. 'lmgt_cases';
			$case_name= $wpdb->get_row("SELECT case_name FROM $table_cases where id=".$case_id);

			$Case_name_row ='<tr><td>'.esc_html($data->title).'</td>
				<td>'.esc_html($data->type).'</td>
				<td>'.esc_html($case_name->case_name).'</td>	
				<td>'.esc_html($data->tag_names).'</td>																
				<td>'.esc_html($data->last_update).'</td>					
				<td>'.'<a href="'.esc_url(content_url().'/uploads/document_upload/'.esc_attr($data->document_url)).'" class="status_read btn btn-success" record_id="'.esc_attr($data->id).'">view</a>
				<a href="?page=documents&tab=add_documents&action=edit&tab1=unreaddocuments&documents_id='.esc_attr($data->id).'" class="btn btn-info"> Edit</a>
					<a href="?page=documents&tab=add_documents&action=edit&tab1=unreaddocuments&documents_id='.esc_attr($data->id).'" class="btn btn-danger" 
				onclick="return confirm(Are you sure you want to delete this record?);">
				 Delete</a>'.'
				</td></tr>';	
			$casename_filter_data[]=$Case_name_row;					
		} 			
	}
	echo json_encode($casename_filter_data);
	
	die();  
}
//end Case Name filter unread documents
//Case Name filter read documents
function MJ_lawmgt_serch_case_name_read_documents()
{
	if($_REQUEST['selection_id']=='-1')
	{
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';	
		$casename_filter_result = $wpdb->get_results("SELECT * FROM $table_documents where status='read'");

		$casename_filter_data = array();
		
		foreach($casename_filter_result as $data)
		{			
			$case_id=$data->case_id;
						
			global $wpdb;		
			$table_cases = $wpdb->prefix. 'lmgt_cases';
			$case_name= $wpdb->get_row("SELECT case_name FROM $table_cases where id=".$case_id);

			$Case_name_row ='<tr><td>'.esc_html($data->title).'</td>
				<td>'.esc_html($data->type).'</td>
				<td>'.esc_html($case_name->case_name).'</td>	
				<td>'.esc_html($data->tag_names).'</td>															
				<td>'.esc_html($data->last_update).'</td>
				<td>'.'<a href="'.content_url().'/uploads/document_upload/'.esc_attr($data->document_url).'" class="status_read btn btn-success">view</a>
				<a href="?page=documents&tab=add_documents&action=edit&tab1=readdocuments&documents_id='.esc_attr($data->id).'" class="btn btn-info"> Edit</a>
					<a href="?page=documents&tab=add_documents&action=edit&tab1=readdocuments&documents_id='.esc_attr($data->id).'" class="btn btn-danger" 
				onclick="return confirm(Are you sure you want to delete this record?);">
				 Delete</a>'.'
				</td></tr>';	
			$casename_filter_data[]=$Case_name_row;					
		} 
	}
	else
	{
		 $selection_id= sanitize_text_field($_REQUEST['selection_id']);
			
		global $wpdb;
		$table_documents = $wpdb->prefix. 'lmgt_documents';	
		$casename_filter_result = $wpdb->get_results("SELECT * FROM $table_documents where case_id=$selection_id AND status='read'");

		$casename_filter_data = array();
		
		foreach($casename_filter_result as $data)
		{			
			$case_id=$data->case_id;
						
			global $wpdb;		
			$table_cases = $wpdb->prefix. 'lmgt_cases';
			$case_name= $wpdb->get_row("SELECT case_name FROM $table_cases where id=".$case_id);

			$Case_name_row ='<tr><td>'.esc_html($data->title).'</td>
				<td>'.esc_html($data->type).'</td>
				<td>'.esc_html($case_name->case_name).'</td>	
				<td>'.esc_html($data->tag_names).'</td>																
				<td>'.esc_html($data->last_update).'</td>
				<td>'.'<a href="'.esc_url(content_url().'/uploads/document_upload/'.esc_attr($data->document_url)).'" class="status_read btn btn-success">view</a>
				<a href="?page=documents&tab=add_documents&action=edit&tab1=readdocuments&documents_id='.esc_attr($data->id).'" class="btn btn-info"> Edit</a>
					<a href="?page=documents&tab=add_documents&action=edit&tab1=readdocuments&documents_id='.esc_attr($data->id).'" class="btn btn-danger" 
				onclick="return confirm(Are you sure you want to delete this record?);">
				 Delete</a>'.'
				</td></tr>';	
			$casename_filter_data[]=$Case_name_row;					
		}
	}
	echo json_encode($casename_filter_data);
	
	die();  
}
//end Case Name filter read documents
//add tag name in mysql
function MJ_lawmgt_add_tags_documents()
{
			
	 $name=sanitize_text_field($_REQUEST['tag_name']);
	 $tag_name['tag_name']= $name;
	 global $wpdb;
	 $table_tagging = $wpdb->prefix. 'lmgt_tagging';		
	 $result=$wpdb->insert( $table_tagging, $tag_name);
	echo json_encode($name);
	
	die();  
}//end add tag name in mysql
//auto suggest box in tag
function MJ_lawmgt_add_tags_documents_auto_suggesstion()
{
			
	$keyword=sanitize_text_field($_REQUEST['keyword']);		
	 global $wpdb;
	 $table_tagging = $wpdb->prefix. 'lmgt_tagging';	
	 $result = $wpdb->get_results("SELECT DISTINCT tag_name FROM $table_tagging  WHERE tag_name like '" .$keyword. "%' ORDER BY tag_name LIMIT 0,6");
	
	foreach($result as $data)
	{			
		$auto_suggesstion_result[]=$data->tag_name;
	}	
	
	echo json_encode($auto_suggesstion_result);
	
	die();  
}//wnd auto suggest box in tag

//display subentary 
function MJ_lawmgt_display_time_entery_subtotal()
{
			
	$time_entry_hours=sanitize_text_field($_REQUEST['time_entry_hours']);	
	$time_entry_rate=sanitize_text_field($_REQUEST['time_entry_rate']);	
	$time_entry_subtotal=$time_entry_hours * $time_entry_rate;
	
	echo json_encode($time_entry_subtotal);
	
	die(); 
} //end display subentry 
 
// display expanse sub total // 
function MJ_lawmgt_display_expenses_subtotal()
{
			
	$expense_quantity= sanitize_text_field($_REQUEST['expense_quantity']);	
	$expense_price= sanitize_text_field($_REQUEST['expense_price']);	
	$expenses_subtotal=$expense_quantity * $expense_price;
	
	echo json_encode($expenses_subtotal);
	
	die(); 
}  // end display expanse sub total // 
 //  display flate fee sub total // 
function MJ_lawmgt_display_flat_fee_subtotal()
{		
	$flat_fee_quantity = sanitize_text_field($_REQUEST['flat_fee_quantity']);	
	$flat_fee_price = sanitize_text_field($_REQUEST['flat_fee_price']);	
	$flat_fee_subtotal=$flat_fee_quantity * $flat_fee_price;
	
	echo json_encode($flat_fee_subtotal);
	
	die(); 
}  // end  display flate fee sub total // 
  //display expanse sub total //
function MJ_lawmgt_documets_status_change()
{			
	 $record_id= sanitize_text_field($_REQUEST['record_id']);
	
	 $user = wp_get_current_user();
	 $current_user_id = $user->ID;		
	 global $wpdb;
	 $table_documents = $wpdb->prefix. 'lmgt_documents';	
	 $result_status_value= $wpdb->get_row("SELECT status FROM $table_documents where id=".$record_id);
	 
	 $status_value_array=json_decode($result_status_value->status); 
	
	 array_push($status_value_array,$current_user_id); 
	  
	 $status_value_filter=array_filter($status_value_array); 
	 
	 $status_value_unique=array_unique($status_value_filter);
	  
	 $user_status=json_encode($status_value_unique);	 
	 
	 $document_data['status']=$user_status;
	 $document_id['id']= sanitize_text_field($_REQUEST['record_id']);
	 $result=$wpdb->update( $table_documents, $document_data ,$document_id);
	 
	 echo json_encode($result); 
	 die();  
 }
// generate invoice number 
function MJ_lawmgt_generate_invoce_number()
{
	global $wpdb;
	$table_invoice=$wpdb->prefix.'lmgt_invoice';
	
	$result_invoice_no=$wpdb->get_results("SELECT * FROM $table_invoice");						
					
	if(empty($result_invoice_no))
	{							
		return $invoice_no='00001';
	}
	else
	{							
		$result_no=$wpdb->get_row("SELECT invoice_number FROM $table_invoice where id=(SELECT max(id) FROM $table_invoice)");
		
		$last_invoice_number=$result_no->invoice_number;
		
		return $invoice_no = str_pad($last_invoice_number+1, 5, 0, STR_PAD_LEFT);
	} 
 }
//INSERT LAST LOGIN
function MJ_lawmgt_insert_last_login( $login ) 
{
    global $user_id;
    $user = get_userdatabylogin( $login );
    update_user_meta( $user->ID, 'last_login', gmdate( 'Y-m-d H:i:s' ) );
}
add_action( 'wp_login', 'MJ_lawmgt_insert_last_login' );
//ADD LAST LOGIN COLUMN
function MJ_lawmgt_add_last_login_column( $columns ) {
    $columns['last_login'] = esc_html__( 'Last Login', 'last_login' );
    return $columns;
}
add_filter( 'manage_users_columns', 'MJ_lawmgt_add_last_login_column' );
//ADD LAST LOGIN COLUMN VALUE
function MJ_lawmgt_add_last_login_column_value( $value, $column_name, $user_id ) 
{
    $user = get_userdata( $user_id );
    if ( 'last_login' == $column_name && $user->last_login )
        $value = date( 'm/d/Y g:ia', strtotime( $user->last_login ) );
    return $value;
}
add_action( 'manage_users_custom_column', 'MJ_lawmgt_add_last_login_column_value', 10, 3 );

// GET task Due Date BY Event Date
function MJ_lawmgt_get_due_date_by_event_date($due_date,$Workflow_id,$case_id)
{
	$due_date_details = json_decode($due_date);
	
	$due_date_type =$due_date_details->due_date_type;
	
	if($due_date_type == 'automatically')
	{
		$days =	$due_date_details->days;
		$day_type =	$due_date_details->day_type;
		$task_event_name =$due_date_details->task_event_name;
	
		global $wpdb;			
		$table_case_workflow_events_tasks = $wpdb->prefix. 'lmgt_case_workflow_events_tasks';			
		
		$result = $wpdb->get_row("SELECT event_date FROM $table_case_workflow_events_tasks where workflow_id=$Workflow_id AND case_id=$case_id AND subject=$task_event_name");	
		
		$event_date=$result->event_date;
		
		if($day_type == 'after')
		{
			$date=date('Y-m-d', strtotime($event_date .'+'.$days.'day'));
			
			return $date;	
		}
		if($day_type == 'before')
		{			
			$date=date('Y-m-d', strtotime($event_date .'-'.$days.'day'));
			
			return $date;	
		}
	}
	else	
	{
		$date="No Due Date";
		return $date;	
	}
}
 
// GET current user role
function MJ_lawmgt_get_current_user_role()
{
	$user = wp_get_current_user();
	$role=implode(" ",$user->roles);
	
	return $role;
}
// GET Case NAME BY Case ID
function MJ_lawmgt_get_case_name($case_id)
{
	global $wpdb;		
	$table_case = $wpdb->prefix. 'lmgt_cases';			
	$result = $wpdb->get_row("SELECT case_name FROM $table_case where id=".$case_id);	
	return $result->case_name;	
}
// GET Case NUMBER BY Case ID
function MJ_lawmgt_get_case_number($case_id)
{
	global $wpdb;		
	$table_case = $wpdb->prefix. 'lmgt_cases';			
	$result = $wpdb->get_row("SELECT case_number FROM $table_case where id=".$case_id);	
	return $result->case_number;	
}
// GET Attorney NAME BY Case ID
function MJ_lawmgt_get_attorney_name_by_case_id($case_id)
{
	global $wpdb;			
	$table_case = $wpdb->prefix. 'lmgt_cases';			
	$result = $wpdb->get_row("SELECT case_assgined_to FROM $table_case where id=".$case_id);
	$user=explode(",",$result->case_assgined_to);
	$user_name=array();
	if(!empty($user))
	{						
		foreach($user as $data4)
		{
			$user_name[]=MJ_lawmgt_get_display_name($data4);
		}
	}	
	$userdata=get_userdata($result->case_assgined_to);
	
	return implode(", ",$user_name);	
}
// GET Contact&Attorney Data BY Case ID
function MJ_lawmgt_get_contact_and_attorney_data_by_case_id($case_id)
{
	global $wpdb;		
	$table_case = $wpdb->prefix. 'lmgt_cases';		
	$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
	
	$data_array=array();	
	$result = $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
	// var_dump($result);
		
	if(!empty($result))
	{
		foreach($result as $data)
		{
			$data_array[]=$data->user_id;
		}
	}
	$result1 = $wpdb->get_results("SELECT case_assgined_to FROM $table_case where id=".$case_id);
	$user_array= sanitize_text_field($result1[0]->case_assgined_to);
	$newarraay=explode(',',$user_array);
	 
	if(!empty($newarraay))
	{
		foreach($newarraay as $data1)
		{
			$data_array[]=$data1;
		}
	}
	
	return $data_array;	
}
// GET event NAME BY ID
function MJ_lawmgt_get_event_name($event_id)
{
	global $wpdb;			
	$table_add_event = $wpdb->prefix. 'lmgt_add_event';			
	$result = $wpdb->get_row("SELECT event_name FROM $table_add_event where event_id=".$event_id);	
	return $result->event_name;	
}
// GET Task NAME BY ID
function MJ_lawmgt_get_task_name($task_id)
{
	global $wpdb;			
	$table_law_add_task = $wpdb->prefix. 'lmgt_add_task';			
	$result = $wpdb->get_row("SELECT task_name FROM $table_law_add_task where task_id=".$task_id);			
	return $result->task_name;		
}
// GET Note NAME BY ID
function MJ_lawmgt_get_note_name($note_id)
{
	global $wpdb;			
	$table_add_note = $wpdb->prefix. 'lmgt_add_note';			
	$result = $wpdb->get_row("SELECT note_name FROM $table_add_note where note_id=".$note_id);	
	
	return $result->note_name;	
}
// GET Workflow NAME BY ID
function MJ_lawmgt_get_workflow_name($workflow_id)
{
	global $wpdb;			
	$table_workflows = $wpdb->prefix. 'lmgt_workflows';			
	$result = $wpdb->get_row("SELECT name FROM $table_workflows where id=".$workflow_id);		
	return $result->name;	
}
// GET Document NAME BY ID
function MJ_lawmgt_get_document_name($document_id)
{
	global $wpdb;			
	$table_documents = $wpdb->prefix. 'lmgt_documents';			
	$result = $wpdb->get_row("SELECT title FROM $table_documents where id=".$document_id);	
	return $result->title;	
}
// GET Invoice Number BY ID
function MJ_lawmgt_get_invoice_number($invoice_id)
{		 
	global $wpdb;			
	$table_invoice = $wpdb->prefix. 'lmgt_invoice';			
	$result = $wpdb->get_row("SELECT invoice_number FROM $table_invoice where id=".$invoice_id);	
	return $result->invoice_number;	
}
// GET workflow task and event subject name BY ID
function MJ_lawmgt_get_workflow_event_task_subject_name_by_id($id)
{
	global $wpdb;			
	$table_workflow_events_tasks = $wpdb->prefix. 'lmgt_workflow_events_tasks';			
	$result = $wpdb->get_row("SELECT subject FROM $table_workflow_events_tasks where id=".$id);	
	return $result->subject;	
}
// APPEND AUDIT LOG All Activity
function MJ_lawmgt_append_audit_log($audit_action,$user_id,$case_link)
{
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	 
	$document_dir = WP_CONTENT_DIR;
	$document_dir_backup = WP_CONTENT_DIR;
	$document_dir .= '/uploads/Lawyer_logs/';
	$document_dir_backup .= '/uploads/Lawyer_logs_backup/';
	$document_path = $document_dir;
	$document_path_backup = $document_dir_backup;
	if (!file_exists($document_path)) 
	{
		mkdir($document_path, 0777, true);		
	}
	if (!file_exists($document_path_backup)) 
	{
		mkdir($document_path_backup, 0777, true);		
	}
    if (!file_exists(LAWMS_LOG_file)) 
	{
		$fp2 = fopen(LAWMS_LOG_file, "w");	
	}
	$current = file_get_contents(LAWMS_LOG_file);
	//$current1 = file_get_contents(LAWMS_LOG_DIR_backup);
	
	if(empty($case_link))
	{
		$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id);
		 
	}
	else
	{
		$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id)." ".$case_link;
		 
	}	
	// Write the contents back to the file
	file_put_contents(LAWMS_LOG_file, $current);
	//file_put_contents(LAWMS_LOG_DIR_backup, $current1);
}
//Aded new Downlaod File Logs//
// APPEND AUDIT LOG All Activity Download//
function MJ_lawmgt_append_audit_log_for_downlaod($audit_action,$user_id,$case_link)
{
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	 
	$document_dir = WP_CONTENT_DIR;
	$document_dir_backup = WP_CONTENT_DIR;
	$document_dir .= '/uploads/Lawyer_logs/';
	$document_dir_backup .= '/uploads/Lawyer_logs_backup/';
	$document_path = $document_dir;
	$document_path_backup = $document_dir_backup;
	if (!file_exists($document_path)) 
	{
		mkdir($document_path, 0777, true);		
	}
	if (!file_exists($document_path_backup)) 
	{
		mkdir($document_path_backup, 0777, true);		
	}
    if (!file_exists(LAWMS_LOG_file_Downlaod)) 
	{
		$fp2 = fopen(LAWMS_LOG_file_Downlaod, "w");	
	}
	$current = file_get_contents(LAWMS_LOG_file_Downlaod);
	//$current1 = file_get_contents(LAWMS_LOG_DIR_backup);
	
	if(empty($case_link))
	{
		$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id);
		 
	}
	else
	{
		$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id)." ".$case_link;
		 
	}	
	// Write the contents back to the file
	file_put_contents(LAWMS_LOG_file_Downlaod, $current);
	//file_put_contents(LAWMS_LOG_DIR_backup, $current1);
}

// APPEND AUDIT LOG Case Activity downlaod file//
function MJ_lawmgt_append_audit_caselog_download($audit_action,$user_id)
{
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	if (!file_exists(LAWMS_Case_LOG_file_download)) 
	{
		$fp2 = fopen(LAWMS_Case_LOG_file_download, "w");	
	}
	$current = file_get_contents(LAWMS_Case_LOG_file_download);
	
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id);
	 
	// Write the contents back to the file
	file_put_contents(LAWMS_Case_LOG_file_download, $current);
}

// APPEND AUDIT LOG Event Activity//
function MJ_lawmgt_append_audit_eventlog_download($audit_action,$user_id)
{
	if (!file_exists(LAWMS_Event_LOG_file_download)) 
	{
		$fp2 = fopen(LAWMS_Event_LOG_file_download, "w");	
	} 
	$current = file_get_contents(LAWMS_Event_LOG_file_download);
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	//$case_link_translation=esc_html__(' | Case Link : ','lawyer_mgt');
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id);
	file_put_contents(LAWMS_Event_LOG_file_download, $current);
}

/* // APPEND next hearing LOG  Activity //
function MJ_lawmgt_append_audit_next_hearing_datelog_download($audit_action,$user_id,$case_link)
{
	if (!file_exists(LAWMS_next_hearing_date_LOG_file_download)) 
	{
		$fp2 = fopen(LAWMS_next_hearing_date_LOG_file_download, "w");	
	}
	$current = file_get_contents(LAWMS_next_hearing_date_LOG_file_download);
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id);
	// Write the contents back to the file
	file_put_contents(LAWMS_next_hearing_date_LOG_file_download, $current);
} */

// APPEND AUDIT LOG Note Activity
function MJ_lawmgt_append_audit_notelog_download($audit_action,$user_id)
{
	if (!file_exists(LAWMS_Note_LOG_file_download)) 
	{
		$fp2 = fopen(LAWMS_Note_LOG_file_download, "w");	
	} 
	$current = file_get_contents(LAWMS_Note_LOG_file_download);
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id);
	// Write the contents back to the file
	file_put_contents(LAWMS_Note_LOG_file_download, $current);
}

// APPEND AUDIT LOG Task Activity
function MJ_lawmgt_append_audit_tasklog_download($audit_action,$user_id)
{
	if (!file_exists(LAWMS_Task_LOG_file_download)) 
	{
		$fp2 = fopen(LAWMS_Task_LOG_file_download, "w");	
	}
	$current = file_get_contents(LAWMS_Task_LOG_file_download);
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id);
	// Write the contents back to the file
	file_put_contents(LAWMS_Task_LOG_file_download, $current);
}

// APPEND AUDIT LOG Invoice Activity
function MJ_lawmgt_append_audit_invoicelog_download($audit_action,$user_id)
{
	if (!file_exists(LAWMS_Invoice_LOG_file)) 
	{
		$fp2 = fopen(LAWMS_Invoice_LOG_file, "w");	
	}
	$current = file_get_contents(LAWMS_Invoice_LOG_file);
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id);
	
	file_put_contents(LAWMS_Invoice_LOG_file, $current);
}

// APPEND AUDIT LOG Workflow Activity
function MJ_lawmgt_append_audit_workflowlog_download($audit_action,$user_id)
{
	if (!file_exists(LAWMS_Workflow_LOG_file_download)) 
	{
		$fp2 = fopen(LAWMS_Workflow_LOG_file_download, "w");	
	}
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	$current = file_get_contents(LAWMS_Workflow_LOG_file_download);
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id) ;
	// Write the contents back to the file
	file_put_contents(LAWMS_Workflow_LOG_file_download, $current);
}

// APPEND AUDIT LOG Document Activity
function MJ_lawmgt_append_audit_documetlog_download($audit_action,$user_id)
{
	if (!file_exists(LAWMS_Document_LOG_file_download)) 
	{
		$fp2 = fopen(LAWMS_Document_LOG_file_download, "w");	
	}
	$current = file_get_contents(LAWMS_Document_LOG_file_download);
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id);
	// Write the contents back to the file
	file_put_contents(LAWMS_Document_LOG_file_download, $current);
}

// APPEND AUDIT LOG Judgement Activity
function MJ_lawmgt_append_audit_judgment_log_download($audit_action,$user_id)
{
	if (!file_exists(LAWMS_Judgment_LOG_file_download)) 
	{
		$fp2 = fopen(LAWMS_Judgment_LOG_file_download, "w");	
	} 
	$current = file_get_contents(LAWMS_Judgment_LOG_file_download);
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id);
	// Write the contents back to the file
	file_put_contents(LAWMS_Judgment_LOG_file_download, $current);
}

// APPEND AUDIT LOG Judgement Activity
function MJ_lawmgt_append_audit_order_log_download($audit_action,$user_id)
{
	if (!file_exists(LAWMS_Order_LOG_file_download)) 
	{
		$fp2 = fopen(LAWMS_Order_LOG_file_download, "w");	
	} 
	$current = file_get_contents(LAWMS_Order_LOG_file_download);
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id);
	// Write the contents back to the file
	file_put_contents(LAWMS_Order_LOG_file_download, $current);
}

//End Download logs file//

// APPEND AUDIT LOG Case Activity
function MJ_lawmgt_append_audit_caselog($audit_action,$user_id,$case_link)
{
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	$case_link_translation=esc_html__(' | Case Link : ','lawyer_mgt');
	if (!file_exists(LAWMS_Case_LOG_file)) 
	{
		$fp2 = fopen(LAWMS_Case_LOG_file, "w");	
	}
	$current = file_get_contents(LAWMS_Case_LOG_file);
	
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id).' '.$case_link_translation.' '.$case_link;
	 
	// Write the contents back to the file
	file_put_contents(LAWMS_Case_LOG_file, $current);
}
// APPEND AUDIT LOG Event Activity
function MJ_lawmgt_append_audit_eventlog($audit_action,$user_id,$case_link)
{
	if (!file_exists(LAWMS_Event_LOG_file)) 
	{
		$fp2 = fopen(LAWMS_Event_LOG_file, "w");	
	} 
	$current = file_get_contents(LAWMS_Event_LOG_file);
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	$case_link_translation=esc_html__(' | Case Link : ','lawyer_mgt');
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id).' '.$case_link_translation.' '.$case_link;
	
 
	file_put_contents(LAWMS_Event_LOG_file, $current);
}
// APPEND AUDIT LOG Judgement Activity
function MJ_lawmgt_append_audit_judgment_log($audit_action,$user_id,$case_link)
{
	if (!file_exists(LAWMS_Judgment_LOG_file)) 
	{
		$fp2 = fopen(LAWMS_Judgment_LOG_file, "w");	
	} 
	$current = file_get_contents(LAWMS_Judgment_LOG_file);
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	$case_link_translation=esc_html__(' | Case Link : ','lawyer_mgt');
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id).' '.$case_link_translation.' '.$case_link;
	
	 
	// Write the contents back to the file
	file_put_contents(LAWMS_Judgment_LOG_file, $current);
}
// APPEND AUDIT LOG Judgement Activity
function MJ_lawmgt_append_audit_order_log($audit_action,$user_id,$case_link)
{
	if (!file_exists(LAWMS_Order_LOG_file)) 
	{
		$fp2 = fopen(LAWMS_Order_LOG_file, "w");	
	} 
	$current = file_get_contents(LAWMS_Order_LOG_file);
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	$case_link_translation=esc_html__(' | Case Link : ','lawyer_mgt');
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id).' '.$case_link_translation.' '.$case_link;
	
	 
	// Write the contents back to the file
	file_put_contents(LAWMS_Order_LOG_file, $current);
}
// APPEND AUDIT LOG Court Activity
function MJ_lawmgt_append_audit_courtlog($audit_action,$user_id,$case_link)
{
	if (!file_exists(LAWMS_Court_LOG_file)) 
	{
		$fp2 = fopen(LAWMS_Court_LOG_file, "w");	
	} 
	$current = file_get_contents(LAWMS_Court_LOG_file);
	 $on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	 
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id) ;
	
	 
	// Write the contents back to the file
	file_put_contents(LAWMS_Court_LOG_file, $current);
}
// APPEND AUDIT LOG Court Activity
 
// APPEND AUDIT LOG Note Activity
function MJ_lawmgt_append_audit_notelog($audit_action,$user_id,$case_link)
{
	if (!file_exists(LAWMS_Note_LOG_file)) 
	{
		$fp2 = fopen(LAWMS_Note_LOG_file, "w");	
	} 
	$current = file_get_contents(LAWMS_Note_LOG_file);
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	$case_link_translation=esc_html__(' | Case Link : ','lawyer_mgt');
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id).' '.$case_link_translation.' '.$case_link;
	
	 
	// Write the contents back to the file
	file_put_contents(LAWMS_Note_LOG_file, $current);
}
// APPEND AUDIT LOG Note Activity
function MJ_lawmgt_append_audit_next_hearing_datelog($audit_action,$user_id,$case_link)
{
	if (!file_exists(LAWMS_next_hearing_date_LOG_file)) 
	{
		$fp2 = fopen(LAWMS_next_hearing_date_LOG_file, "w");	
	}
	$current = file_get_contents(LAWMS_next_hearing_date_LOG_file);
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	$case_link_translation=esc_html__(' | Case Link : ','lawyer_mgt');
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id).' '.$case_link_translation.' '.$case_link;
	
	 
	// Write the contents back to the file
	file_put_contents(LAWMS_next_hearing_date_LOG_file, $current);
}
// APPEND AUDIT LOG Task Activity
function MJ_lawmgt_append_audit_tasklog($audit_action,$user_id,$case_link)
{
	if (!file_exists(LAWMS_Task_LOG_file)) 
	{
		$fp2 = fopen(LAWMS_Task_LOG_file, "w");	
	}
	$current = file_get_contents(LAWMS_Task_LOG_file);
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	$case_link_translation=esc_html__(' | Case Link : ','lawyer_mgt');
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id).' '.$case_link_translation.' '.$case_link;
	
 
	// Write the contents back to the file
	file_put_contents(LAWMS_Task_LOG_file, $current);
}
// APPEND AUDIT LOG Invoice Activity
function MJ_lawmgt_append_audit_invoicelog($audit_action,$user_id,$case_link)
{
	if (!file_exists(LAWMS_Invoice_LOG_file)) 
	{
		$fp2 = fopen(LAWMS_Invoice_LOG_file, "w");	
	}
	$current = file_get_contents(LAWMS_Invoice_LOG_file);
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	$case_link_translation=esc_html__(' | Case Link : ','lawyer_mgt');
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id).' '.$case_link_translation.' '.$case_link;
	
	 
	file_put_contents(LAWMS_Invoice_LOG_file, $current);
}
// APPEND AUDIT LOG Workflow Activity
function MJ_lawmgt_append_audit_workflowlog($audit_action,$user_id,$case_link)
{
	if (!file_exists(LAWMS_Workflow_LOG_file)) 
	{
		$fp2 = fopen(LAWMS_Workflow_LOG_file, "w");	
	}
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	$case_link_translation=esc_html__(' | Case Link : ','lawyer_mgt');
	$current = file_get_contents(LAWMS_Workflow_LOG_file);
	if(empty($case_link))
	{
		$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id) ;
		 
	}
	else	
	{
		$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id).' '.$case_link_translation.' '.$case_link;
		 
	}	
	// Write the contents back to the file
	file_put_contents(LAWMS_Workflow_LOG_file, $current);
}
// APPEND AUDIT LOG Document Activity
function MJ_lawmgt_append_audit_documetlog($audit_action,$user_id,$case_link)
{
	if (!file_exists(LAWMS_Document_LOG_file)) 
	{
		$fp2 = fopen(LAWMS_Document_LOG_file, "w");	
	}
	$current = file_get_contents(LAWMS_Document_LOG_file);
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	$case_link_translation=esc_html__(' | Case Link : ','lawyer_mgt');
	$current .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id).' '.$case_link_translation.' '.$case_link;
	 
	// Write the contents back to the file
	file_put_contents(LAWMS_Document_LOG_file, $current);
}
//userwise Activity
function MJ_lawmgt_userwise_activity($audit_action,$user_id,$case_link)
{
	$activity=null;
	$on=esc_html__(' on ','lawyer_mgt');
	$by=esc_html__(' by ','lawyer_mgt');
	$case_link_translation=esc_html__(' | Case Link : ','lawyer_mgt');
	if(empty($case_link))
	{
		$activity = "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id);
	}
	else
	{
		$activity .= "\n".$audit_action.' '.$on.' '.MJ_lawmgt_getdate_in_input_box(date("Y-m-d")).' '.$by.' '.MJ_lawmgt_get_display_name($user_id).' '.$case_link_translation.' '.$case_link;
	}
	/* var_dump($activity);
	die; */
	global $wpdb;
	$table_user_activity = $wpdb->prefix. 'lmgt_user_activity';	
	
	$user_activity['activity']= $activity;
	$user_activity['user_id']= $user_id;
	$user_activity['created_date']= date("Y-m-d");
	$result=$wpdb->insert($table_user_activity, $user_activity);	
}   
//get Workflow details
function MJ_lawmgt_apply_workflow_details()
{
	$apply_workflow_id=sanitize_text_field($_REQUEST['apply_workflow_id']);
	$case_id=sanitize_text_field($_REQUEST['case_id']);
			
	global $wpdb;
	$table_case_workflow_events_tasks = $wpdb->prefix. 'lmgt_case_workflow_events_tasks';	
	
	$result_all_ready_apply_workflow_details = $wpdb->get_results("SELECT DISTINCT(workflow_id) FROM $table_case_workflow_events_tasks where case_id=$case_id");	
	$array_var=array();
	$apply_workflow=array();
	
	if(!empty($result_all_ready_apply_workflow_details))
	{
		foreach ($result_all_ready_apply_workflow_details as $retrive_data)
		{ 
			$apply_workflow[]=$retrive_data->workflow_id;
		}
	}	
	if (in_array($apply_workflow_id, $apply_workflow)) 
	{
			$workflow_status="all_ready_apply_workflow";
	}	
	
    	$workflow_details ='<div class="header">	
		<h3 class="first_hed">'.esc_html__('Workflow Events','lawyer_mgt').'</h3>
		<hr>
		</div>';
		global $wpdb;
		$table_workflow_events_tasks = $wpdb->prefix. 'lmgt_workflow_events_tasks';	
		
		$workflow_event_details = $wpdb->get_results("SELECT * FROM $table_workflow_events_tasks where type='event' AND workflow_id='$apply_workflow_id' ORDER BY id ASC");
		
		if(!empty($workflow_event_details))
		{				
			foreach ($workflow_event_details as $retrive_data)
			{ 
				$workflow_details .='<div class="form-group workflow_item">	
							<input type="hidden" name="event_id[]" value="'.esc_attr($retrive_data->id).'">	
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="event_subject">'.esc_html__('Event Subject','lawyer_mgt').'</label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
									<input id="event_subject" class="form-control has-feedback-left validate[required,custom[onlyLetterSp]] text-input event_subject" type="text" placeholder="'.esc_html__('Enter Event Subject','lawyer_mgt').'" value="'.esc_attr($retrive_data->subject).'" name="event_subject[]" readonly="readonly">
									<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label">'.esc_html__('Event Date','lawyer_mgt').'<span class="require-field">*</span></label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
									<input class="form-control has-feedback-left validate[required] text-input event_date apply_case_event_date" data-date-format="'.MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format')).'" type="text" placeholder="'.esc_html__('Select Event Date','lawyer_mgt').'" value="'.esc_attr(MJ_lawmgt_getdate_in_input_box(date("Y-m-d"))).'" name="event_date[]" readonly>
									<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
								</div>	
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" >'.esc_html__('Attendees','lawyer_mgt').'</label>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">			
								<select class="form-control event_contact"  multiple="multiple" name="event_contact['.esc_attr($retrive_data->subject).'][]">';				
						
						global $wpdb;
	
						$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
						
						$case_conacts = $wpdb->get_results("SELECT * FROM $table_case_contacts where case_id=".$case_id);
						
						if(!empty($case_conacts))
						{
							foreach ($case_conacts as $retrive_data)
							{ 		
								$contact_name=MJ_lawmgt_get_display_name($retrive_data->user_id);
								$workflow_details .='<option value="'.esc_attr($retrive_data->user_id).'">'.esc_html($contact_name).'</option>';	
						
							} 
						} 						
								
				$workflow_details .='</select>				
							</div>
							</div>
						</div>';	
			}
		}		
		$workflow_details .='<div class="header">	
		<h3 class="first_hed">'.esc_html__('Workflow Tasks','lawyer_mgt').'</h3>
		<hr>
		</div>';
		global $wpdb;
		$table_workflow_events_tasks = $wpdb->prefix. 'lmgt_workflow_events_tasks';	
		
		$workflow_task_details = $wpdb->get_results("SELECT * FROM $table_workflow_events_tasks where type='task' AND workflow_id='$apply_workflow_id' ORDER BY id ASC");
		 
		if(!empty($workflow_task_details))
		{				
			foreach ($workflow_task_details as $retrive_data)
			{ 
				$workflow_details .='<div class="form-group workflow_item">	
							<input type="hidden" name="task_id[]" value="'.esc_attr($retrive_data->id).'">		
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="task_subject">'.esc_html__('Task Subject','lawyer_mgt').'</label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
									<input id="event_subject" class="form-control has-feedback-left validate[required] text-input task_subject" type="text" placeholder="'.esc_html__('Enter task Subject','lawyer_mgt').'" value="'.esc_attr($retrive_data->subject).'" name="task_subject[]" readonly="readonly">
									<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label ">'.esc_html__('Due Date','lawyer_mgt').'</label>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">';
								 $due_date=$retrive_data->due_date;
							     $data=json_decode($due_date);
								$due_date_type =$data->due_date_type;
								$days =$data->days;
								$day_formate =$data->day_formate;
								$day_type =$data->day_type;
								$task_event_name =$data->task_event_name;
								$workflow_details .='<input type="hidden" name="due_date_type[]" value='.esc_attr($due_date_type).'>
								<input type="hidden" name="days[]" value='.esc_attr($days).'>
								<input type="hidden" name="day_formate[]" value='.esc_attr($day_formate).'>
								<input type="hidden" name="day_type[]" value='.esc_attr($day_type).'>
								<input type="hidden" name="task_event_name[]" value='.esc_attr($task_event_name).'>';
								if($data->due_date_type == 'automatically')
								{
									$workflow_details .='<label class="control-label task_sue_date_css" name="due_date[]">'.esc_html($days).' '.esc_html($day_formate).' '.esc_html($day_type).' '.esc_html($task_event_name).'</label>';
								}
								else
								{
									$workflow_details .='<label class="control-label task_sue_date_css" name="due_date[]">'.esc_html__('No Due Date','lawyer_mgt').'</label>';
								}
							$workflow_details .='</div>	
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" >'.esc_html__('Assign To','lawyer_mgt').'</label>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">			
								<select class="form-control task_contact"  multiple="multiple" name="task_contact['.esc_attr($retrive_data->subject).'][]">';	
								
						global $wpdb;
	
						$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
						
					$case_conacts = $wpdb->get_results("SELECT * FROM $table_case_contacts where case_id=".$case_id);
						
						if(!empty($case_conacts))
						{
							foreach ($case_conacts as $retrive_data)
							{ 		
								$contact_name=MJ_lawmgt_get_display_name($retrive_data->user_id);
								$workflow_details .='<option value="'.esc_attr($retrive_data->user_id).'">'.esc_html($contact_name).'</option>';	
						
							} 
						} 						
								
				$workflow_details .='</select>				
							</div>
							</div>
						</div>';	
			}
		}		
	$array_var[] = $workflow_status;
	$array_var[] = $workflow_details;
	echo json_encode($array_var);
	die();  
}
//  frontend side mmenu list function // 
function MJ_lawmgt_frontend_menu_list()
{
	$access_array=array('attorney' => 
    array (
      'menu_icone' =>plugins_url( 'lawyers-management/assets/images/icons/attorney.png'),
      'menu_title' =>'Attorney',
      'attorney' =>'1',
      'client' =>'1',
      'staff_member' =>'1',
      'accountant' => 0,
      'page_link' =>'attorney'),
	  
	  'staff' => 
    array (
      'menu_icone' =>plugins_url( 'lawyers-management/assets/images/icons/staff.png'),
      'menu_title' =>'Staff',
      'attorney' =>'1',
      'client' =>0,
      'staff_member' =>'1',
      'accountant' => 0,	
      'page_link' =>'staff'),
	  
	  'accountant' => 
    array (
      'menu_icone' =>plugins_url( 'lawyers-management/assets/images/icons/account.png'),
      'menu_title' =>'Accountant',
      'attorney' =>'1',
      'client' =>0,
      'staff_member' =>'1',
      'accountant' => '1',
      'page_link' =>'accountant'),
	  
	'contacts' => 
    array (
      'menu_icone' =>plugins_url( 'lawyers-management/assets/images/icons/contact.png'),
      'menu_title' =>'Contact',
      'attorney' =>'1',
      'client' =>'1',
      'staff_member' =>'1',
      'accountant' => 0,
      'page_link' =>'contacts'),
	  
	  'court' => 
    array (
      'menu_icone' =>plugins_url( 'lawyers-management/assets/images/icons/Court-Module.png'),
      'menu_title' =>'Court',
      'attorney' =>'1',
      'client' =>'1',
      'staff_member' =>'1',
      'accountant' => '1',
      'page_link' =>'court'),
	  
	  'cases' => 
    array (
      'menu_icone' =>plugins_url( 'lawyers-management/assets/images/icons/case.png'),
      'menu_title' =>'Cases',
      'attorney' =>'1',
      'client' =>'1',
      'staff_member' =>'1',
      'accountant' => 0,
      'page_link' =>'cases'),
	  
	    'orders' => 
    array (
      'menu_icone' =>plugins_url( 'lawyers-management/assets/images/icons/order-court.png'),
      'menu_title' =>'Orders',
      'attorney' =>'1',
      'client' =>'1',
      'staff_member' =>'1',
      'accountant' => 0,
      'page_link' =>'orders'),
	  
	  'judgments' => 
    array (
      'menu_icone' =>plugins_url( 'lawyers-management/assets/images/icons/Judgement.png'),
      'menu_title' =>'Judgments',
      'attorney' =>'1',
      'client' =>'1',
      'staff_member' =>'1',
      'accountant' => 0,
      'page_link' =>'judgments'),
	  
	  
	  'causelist' => 
    array (
      'menu_icone' =>plugins_url( 'lawyers-management/assets/images/icons/cause_list.png'),
      'menu_title' =>'Cause List',
      'attorney' =>'1',
      'client' =>'1',
      'staff_member' =>'1',
      'accountant' => 0,
      'page_link' =>'causelist'),
	  
	  'task' => 
    array (
      'menu_icone' =>plugins_url( 'lawyers-management/assets/images/icons/task.png'),
      'menu_title' =>'Task',
      'attorney' =>'1',
      'client' =>'1',
      'staff_member' =>'1',
      'accountant' => 0,
      'page_link' =>'task'),
	  
	   'note' => 
    array (
      'menu_icone' =>plugins_url( 'lawyers-management/assets/images/icons/event.png'),
      'menu_title' =>'Note',
      'attorney' =>'1',
      'client' =>'1',
      'staff_member' =>'1',
      'accountant' => 0,
      'page_link' =>'note'),
	  
	   'event' => 
    array (
      'menu_icone' =>plugins_url( 'lawyers-management/assets/images/icons/note.png'),
      'menu_title' =>'Event',
      'attorney' =>'1',
      'client' =>'1',
      'staff_member' =>'1',
      'accountant' => 0,
      'page_link' =>'event'),
	  
	  'workflow' => 
    array (
      'menu_icone' =>plugins_url( 'lawyers-management/assets/images/icons/work_flow.png'),
      'menu_title' =>'Workflow',
      'attorney' =>'1',
      'client' =>0,
      'staff_member' =>'1',
      'accountant' => 0,
      'page_link' =>'workflow'),
	  
	  'documents' => 
    array (
       'menu_icone' =>plugins_url( 'lawyers-management/assets/images/icons/document.png'),
      'menu_title' =>'Documents',
      'attorney' =>'1',
      'client' =>'1',
      'staff_member' =>'1',
      'accountant' => 0,
      'page_link' =>'documents'),
	  
	   'invoice' => 
    array (
       'menu_icone' =>plugins_url( 'lawyers-management/assets/images/icons/invoice.png'),
      'menu_title' =>'Invoice',
      'attorney' =>'1',
      'client' =>'1',
      'staff_member' =>'1',
      'accountant' => 0,
      'page_link' =>'invoice'),
	  
	  
	'report' => 
    array (
       'menu_icone' =>plugins_url( 'lawyers-management/assets/images/icons/report.png'),
      'menu_title' =>'Report',
      'attorney' =>'1',
      'client' =>0,
      'staff_member' =>'1',
      'accountant' => 0,
      'page_link' =>'report'),
	  
	    
	  'rules' => 
    array (
      'menu_icone' =>plugins_url( 'lawyers-management/assets/images/icons/Rules.png'),
      'menu_title' =>'Rules',
      'attorney' =>'1',
      'client' =>'1',
      'staff_member' =>'1',
      'accountant' => '1',
      'page_link' =>'rules'),
	  
	   'message' => 
    array (
      'menu_icone' =>plugins_url( 'lawyers-management/assets/images/icons/message.png'),
      'menu_title' =>'Message',
      'attorney' =>'1',
      'client' =>'1',
      'staff_member' =>'1',
      'accountant' => 0,
      'page_link' =>'message')
	  );

	 if ( !get_option('lmgt_access_right') ) 
	{
		update_option( 'lmgt_access_right', $access_array );
	}
} // end  frontend side mmenu list function // 
add_action('init','MJ_lawmgt_frontend_menu_list');
// ========================== message module start=============
// LOAD ALL USERLIST IN MESSAGE MODULE
function MJ_lawmgt_get_all_user_in_message()
{
	$user_id=get_current_user_id();
	$user = get_userdata($user_id);
	$role=$user->roles;
	$reciverrole=$role[0];
	if($reciverrole == 'attorney')
	{
		$attorney=get_users(array('role' => 'attorney',
								'meta_query' =>array( 
										array(
												'key' => 'deleted_status',
												'value' =>0,
												'compare' => '='
											)
									)	
								)
							);
								
		$contact=get_users(array('role' => 'client',
									'meta_query' => array(
										array(
											 'key' => 'archive',
											 'value' => '0', 
											 'compare' => '=',
										),
									)
								)
							);
		$staff_member=get_users(array('role' => 'staff_member',
			'meta_query' =>array( 
					array(
							'key' => 'deleted_status',
							'value' =>0,
							'compare' => '='
						)
				)	
			)
		);
		
		$accountant=get_users(array('role' => 'accountant',
			'meta_query' =>array( 
					array(
							'key' => 'deleted_status',
							'value' =>0,
							'compare' => '='
						)
				)	
			)
		);
		 
		 
		$all_user = array('Attorney'=>$attorney,
							'Client'=>$contact,
							'Staff Member'=>$staff_member,
							'Accountant'=>$accountant
						);
	}
	elseif($reciverrole == 'client')
	{
		
		$attorney=get_users(array('role' => 'attorney',
								'meta_query' =>array( 
										array(
												'key' => 'deleted_status',
												'value' =>0,
												'compare' => '='
											)
									)	
								)
							);
						 
		$staff_member=get_users(array('role' => 'staff_member',
			'meta_query' =>array( 
					array(
							'key' => 'deleted_status',
							'value' =>0,
							'compare' => '='
						)
				)	
			)
		);
		
		$accountant=get_users(array('role' => 'accountant',
			'meta_query' =>array( 
					array(
							'key' => 'deleted_status',
							'value' =>0,
							'compare' => '='
						)
				)	
			)
		);
		
		$all_user = array('Attorney'=>$attorney,
				//'Contact'=>$contact,
				'Staff Member'=>$staff_member,
				'Accountant'=>$accountant
				);
	}
	else
	{ 
				
		$attorney=get_users(array('role' => 'attorney',
								'meta_query' =>array( 
										array(
												'key' => 'deleted_status',
												'value' =>0,
												'compare' => '='
											)
									)	
								)
							);
						 
		$contact=get_users(array('role' => 'client',
									'meta_key'     => 'archive',
									'meta_value'   => '0',
									'meta_compare' => '=',));
									
		$staff_member=get_users(array('role' => 'staff_member',
			'meta_query' =>array( 
					array(
							'key' => 'deleted_status',
							'value' =>0,
							'compare' => '='
						)
				)	
			)
		);
		
		$accountant=get_users(array('role' => 'accountant',
			'meta_query' =>array( 
					array(
							'key' => 'deleted_status',
							'value' =>0,
							'compare' => '='
						)
				)	
			)
		);
		
		$all_user = array('Attorney'=>$attorney,
						  'client'=>$contact,
						  'Staff Member'=>$staff_member,
						  'Accountant'=>$accountant);	
	}
	
	$return_array = array();

	foreach($all_user as $key => $value)
	{ 
		if(!empty($value))
		{
			echo '<optgroup label="'.$key.'" style = "text-transform: capitalize;">';
			foreach($value as $user)
			{				
				if($user->ID != $user_id)
				{
					echo '<option value="'.$user->ID.'">'.$user->display_name.'</option>';
				}
			}
		}
	}	
}
// GET DISPLAY NAME BY USER ID
function MJ_lawmgt_get_display_name($user_id)
{
	if (!$user = get_userdata($user_id))
		return false;
	return $user->data->display_name;
}
function MJ_lawmgt_date_formate()
{
	$dateFormat=get_option( 'lmgt_datepicker_format');
	return $dateFormat;
}
// GET ROLE LIST IN MESSAGE MODULE
function MJ_lawmgt_get_role_name_in_message($role)
{
	$profile_pict=array('attorney'=>esc_html__( 'Attorney' ,'lawyer_mgt'),
			'client'=>esc_html__( 'Contact' ,'lawyer_mgt'),
			'staff_member'=> esc_html__( 'Staff Member' ,'lawyer_mgt'),
			'accountant'=> esc_html__( 'Accountant' ,'lawyer_mgt'),	
			'administrator'=> esc_html__( 'Admin' ,'lawyer_mgt'),	
	);
	return $profile_pict[$role];
}
// GET EMAIL USING USER ID
function MJ_lawmgt_get_emailid_byuser_id($id)
{
	if (!$user = get_userdata($id))
		return false;
	return $user->data->user_email;
}
// UPDATE MESSAGE READ STATUS
function MJ_lawmgt_change_read_status($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "lmgt_message";
	$data['msg_status']=1;
	$whereid['message_id']=$id;
	return $retrieve_subject = $wpdb->update($table_name,$data,$whereid);
}
// ========================== message module End=============
 
add_filter( 'cron_schedules', 'MJ_lawmgt_hourremainder' );
add_filter( 'cron_schedules', 'MJ_lawmgt_dayremainder' );
function MJ_lawmgt_hourremainder( $schedules ) 
{
    $schedules['every_onehour'] = array(
            'interval'  => 3600,
            'display'   => esc_html__( 'Every hour', 'lawyer_mgt' )
    );
    return $schedules;
} 
function MJ_lawmgt_dayremainder( $schedules ) 
{
    $schedules['every_day'] = array(
            'interval'  => 86400,
            'display'   => esc_html__( 'Every day', 'lawyer_mgt' )
    );
    return $schedules;
} 
// Schedule an action if it's not already scheduled
 if ( ! wp_next_scheduled( 'MJ_lawmgt_hourremainder' ) ) {
    wp_schedule_event( time(), 'every_onehour', 'MJ_lawmgt_hourremainder' );
} 
if ( ! wp_next_scheduled( 'MJ_lawmgt_dayremainder' ) ) {
    wp_schedule_event( time(), 'every_day', 'MJ_lawmgt_dayremainder' );
}  

// Hook into that action that'll fire every three minutes
add_action( 'MJ_lawmgt_hourremainder', 'MJ_lawmgt_case_remainder_hour_function' );
add_action( 'MJ_lawmgt_hourremainder', 'MJ_lawmgt_event_remainder_hour_function' );
add_action( 'MJ_lawmgt_hourremainder', 'MJ_lawmgt_task_remainder_hour_function' );

add_action( 'MJ_lawmgt_dayremainder', 'MJ_lawmgt_case_remainder_day_function' );
add_action( 'MJ_lawmgt_dayremainder', 'MJ_lawmgt_event_remainder_day_function' );
add_action( 'MJ_lawmgt_dayremainder', 'MJ_lawmgt_task_remainder_day_function' );
  
function MJ_lawmgt_case_remainder_hour_function() 
{
	global $wpdb;
	$table_case_reminder = $wpdb->prefix. 'lmgt_case_reminder';
	
	$case_reminder_result = $wpdb->get_results("SELECT * FROM $table_case_reminder");

	foreach($case_reminder_result as $date)
	{		
		$statute_of_limitations=$date->statute_of_limitations;			
		$reminder_time_value=$date->reminder_time_value;			
		$reminder_time_format=$date->reminder_time_format;	
		$reminder_case_id=$date->case_id;	
		
		if($reminder_time_format == 'hour')
		{
			$current_reminder_date_time = date("Y-m-d H", strtotime('-'.$reminder_time_value.'hours', strtotime($statute_of_limitations)));
			
			$current_date_time=MJ_lawmgt_wpnc_convert_time(date("Y-m-d H:i:s"));
			$current_date_time_new=date("Y-m-d H", strtotime($current_date_time));	
			
			if($current_reminder_date_time == $current_date_time_new)
			{
				global $wpdb;
				$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
				$table_cases = $wpdb->prefix. 'lmgt_cases';		
				
				$contact_attorney_data=MJ_lawmgt_get_contact_and_attorney_data_by_case_id($reminder_case_id);
				$result_case_detail= $wpdb->get_row("SELECT case_name,statute_of_limitations FROM $table_cases where id=".$reminder_case_id);
				
				foreach ($contact_attorney_data as $user_id)
				{	   
					$caselink_contact_email=array();
					$result=get_userdata($user_id);
					$caselink_contact_email[]=$result->user_email;
					$login_link=home_url();
					$system_name=get_option('lmgt_system_name');
					$userdata=get_userdata($user_id);						
					$arr['{{Lawyer System Name}}']=$system_name;						
					$arr['{{User Name}}']=$userdata->user_login;
					$arr['{{Case Name}}']=$result_case_detail->case_name;
					$arr['{{Statute of Limitations Date}}']=$result_case_detail->statute_of_limitations;
					$arr['{{Login Link}}']=$login_link;	
					$subject =get_option('lmgt_case_upcoming_limitation_date_reminder_email_subject');
					$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
					$message = get_option('lmgt_case_upcoming_limitation_date_reminder_email_template');	
					$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
					
					MJ_lawmgt_send_mail($caselink_contact_email,$subject_replacement,$message_replacement); 
				}
			}
	    }		
	}
}

//   case_remainder_day_function  // 
function MJ_lawmgt_case_remainder_day_function() 
{
	global $wpdb;
	$table_case_reminder = $wpdb->prefix. 'lmgt_case_reminder';
	
	$case_reminder_result = $wpdb->get_results("SELECT * FROM $table_case_reminder");

	foreach($case_reminder_result as $date)
	{		
		$statute_of_limitations=$date->statute_of_limitations;			
		$reminder_time_value=$date->reminder_time_value;			
		$reminder_time_format=$date->reminder_time_format;	
		$reminder_case_id=$date->case_id;	
		
		if($reminder_time_format == 'day')
		{			
			$newdate=strtotime('-'.$reminder_time_value.'day',strtotime($statute_of_limitations));
			$current_reminder_date=date("Y-m-d",$newdate);
			$current_date=date("Y-m-d");
			if($current_reminder_date == $current_date)
			{				
				global $wpdb;
				$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
				$table_cases = $wpdb->prefix. 'lmgt_cases';					
				
				$contact_attorney_data=MJ_lawmgt_get_contact_and_attorney_data_by_case_id($reminder_case_id);
				$result_case_detail= $wpdb->get_row("SELECT case_name,statute_of_limitations FROM $table_cases where id=".$reminder_case_id);
					
				foreach ($contact_attorney_data as $user_id)
				{	    
					$caselink_contact_email=array();
					$result=get_userdata($user_id);
					$caselink_contact_email[]=$result->user_email;
					$login_link=home_url();
					$system_name=get_option('lmgt_system_name');
					$userdata=get_userdata($user_id);						
					$arr['{{Lawyer System Name}}']=$system_name;						
					$arr['{{User Name}}']=$userdata->user_login;
					$arr['{{Case Name}}']=$result_case_detail->case_name;
					$arr['{{Statute of Limitations Date}}']=$result_case_detail->statute_of_limitations;
					$arr['{{Login Link}}']=$login_link;	
					
					$subject =get_option('lmgt_case_upcoming_limitation_date_reminder_email_subject');
					$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
					$message = get_option('lmgt_case_upcoming_limitation_date_reminder_email_template');	
					$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);				
					
					MJ_lawmgt_send_mail($caselink_contact_email,$subject_replacement,$message_replacement);
				}					
			}
		}		
	}
} //  end case_remainder_day_function  // 

//event_remainder_hour_function  // 
function MJ_lawmgt_event_remainder_hour_function() 
{
	global $wpdb;
	
	$table_event_reminder = $wpdb->prefix. 'lmgt_event_reminder';
	
	$event_reminder_result = $wpdb->get_results("SELECT * FROM $table_event_reminder");

	foreach($event_reminder_result as $date)
	{		
		$start_date=$date->start_date;			
		$event_id=$date->event_id;			
		$reminder_time_value=$date->reminder_time_value;			
		$reminder_time_format=$date->reminder_time_format;	
		$reminder_case_id=$date->case_id;
		
		if($reminder_time_format == 'hour')
		{
			$current_reminder_date_time = date("Y-m-d H", strtotime('-'.$reminder_time_value.'hours', strtotime($start_date)));

			$current_date_time=MJ_lawmgt_wpnc_convert_time(date("Y-m-d H:i:s"));
			$current_date_time_new=date("Y-m-d H", strtotime($current_date_time));	
			
			if($current_reminder_date_time == $current_date_time_new)
			{				
				global $wpdb;
				$table_add_event = $wpdb->prefix. 'lmgt_add_event'; 				

				$result_event= $wpdb->get_row("SELECT * FROM $table_add_event where event_id=".$event_id);
				
				$case_id=$result_event->case_id;
				$table_case = $wpdb->prefix. 'lmgt_cases';		
				$case_result = $wpdb->get_row("SELECT case_name FROM $table_case where id=".$case_id);
				
				$contact_array=array();
				$contact_array=explode(",",$result_event->assigned_to_user);
				
				$attorney_array=array();
				$attorney_array=explode(",",$result_event->assign_to_attorney);
				
				$all_contact_attorney = array_merge($contact_array, $attorney_array);
				
				foreach ($all_contact_attorney as $key=>$data)
				{	   
					$caselink_contact_email=array();
					
					$userdata=get_userdata($data);
					$caselink_contact_email[]=$userdata->user_email;
					
					$login_link=home_url();
					
					$system_name=get_option('lmgt_system_name');
								
					$arr['{{Lawyer System Name}}']=$system_name;						
					$arr['{{User Name}}']=$userdata->user_login;
					$arr['{{Case Name}}']=$case_result->case_name;
					$arr['{{Event Name}}']=$result_event->event_name;
					$arr['{{Start Date}}']=$result_event->start_date;
					$arr['{{Login Link}}']=$login_link;					
					$subject =get_option('lmgt_event_reminder_email_subject');
					$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
					$message = get_option('lmgt_event_reminder_email_template');	
					$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
	
					MJ_lawmgt_send_mail($caselink_contact_email,$subject_replacement,$message_replacement); 
				}	
			}
	    }		
	}
} //end event_remainder_hour_function  // 

function MJ_lawmgt_event_remainder_day_function()  //event_remainder_day_function  // 
{
	global $wpdb;
	
	$table_event_reminder = $wpdb->prefix. 'lmgt_event_reminder';
	
	$event_reminder_result = $wpdb->get_results("SELECT * FROM $table_event_reminder");

	foreach($event_reminder_result as $date)
	{		
		$start_date=$date->start_date;			
		$event_id=$date->event_id;			
		$reminder_time_value=$date->reminder_time_value;			
		$reminder_time_format=$date->reminder_time_format;	
		$reminder_case_id=$date->case_id;		
		
		if($reminder_time_format == 'day')
		{			
			$newdate=strtotime('-'.$reminder_time_value.'day',strtotime($start_date));
			$current_reminder_date=date("Y-m-d",$newdate);
			$current_date=date("Y-m-d");
			
			if($current_reminder_date == $current_date)
			{				
				global $wpdb;
				$table_add_event = $wpdb->prefix. 'lmgt_add_event'; 				

				$result_event= $wpdb->get_row("SELECT * FROM $table_add_event where event_id=".$event_id);
				
				$case_id=$result_event->case_id;
				$table_case = $wpdb->prefix. 'lmgt_cases';		
				$case_result = $wpdb->get_row("SELECT case_name FROM $table_case where id=".$case_id);
				
				$contact_array=array();
				$contact_array=explode(",",$result_event->assigned_to_user);
				
				$attorney_array=array();
				$attorney_array=explode(",",$result_event->assign_to_attorney);
				
				$all_contact_attorney = array_merge($contact_array, $attorney_array);
				
				foreach ($all_contact_attorney as $key=>$data)
				{	   
					$caselink_contact_email=array();
					
					$userdata=get_userdata($data);
					$caselink_contact_email[]=$userdata->user_email;
					
					$login_link=home_url();
					
					$system_name=get_option('lmgt_system_name');
								
					$arr['{{Lawyer System Name}}']= sanitize_text_field($system_name);						
					$arr['{{User Name}}']=sanitize_user($userdata->user_login);
					$arr['{{Case Name}}']=sanitize_text_field($case_result->case_name);
					$arr['{{Event Name}}']=sanitize_text_field($result_event->event_name);
					$arr['{{Start Date}}']=sanitize_text_field($result_event->start_date);
					$arr['{{Login Link}}']=esc_url($login_link);					
					$subject =get_option('lmgt_event_reminder_email_subject');
					$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
					$message = get_option('lmgt_event_reminder_email_template');	
					$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
	
					MJ_lawmgt_send_mail($caselink_contact_email,$subject_replacement,$message_replacement); 
				}					
			}
		}		
	}
}   //end event_remainder_day_function  //
 
function MJ_lawmgt_task_remainder_hour_function()    //task_remainder_hour_function  // 
{
	global $wpdb;
	
	$table_task_reminder = $wpdb->prefix. 'lmgt_task_reminder';
	
	$task_reminder_result = $wpdb->get_results("SELECT * FROM $table_task_reminder");

	foreach($task_reminder_result as $date)
	{		
		$due_date=$date->due_date;			
		$task_id=$date->task_id;			
		$reminder_time_value=$date->reminder_time_value;			
		$reminder_time_format=$date->reminder_time_format;	
		$reminder_case_id=$date->case_id;
		
		if($reminder_time_format == 'hour')
		{
			$current_reminder_date_time = date("Y-m-d H", strtotime('-'.$reminder_time_value.'hours', strtotime($due_date)));

			$current_date_time=MJ_lawmgt_wpnc_convert_time(date("Y-m-d H:i:s"));
			$current_date_time_new=date("Y-m-d H", strtotime($current_date_time));	
			
			if($current_reminder_date_time == $current_date_time_new)
			{				
				global $wpdb;
				$table_law_add_task = $wpdb->prefix. 'lmgt_add_task'; 				

				$result_task= $wpdb->get_row("SELECT * FROM $table_law_add_task where task_id=".$task_id);
				
				$case_id=$result_task->case_id;
				$table_case = $wpdb->prefix. 'lmgt_cases';		
				$case_result = $wpdb->get_row("SELECT case_name FROM $table_case where id=".$case_id);
				
				$contact_array=array();
				$contact_array=explode(",",$result_task->assigned_to_user);
				
				$attorney_array=array();
				$attorney_array=explode(",",$result_task->assign_to_attorney);
				
				$all_contact_attorney = array_merge($contact_array, $attorney_array);
				
				foreach ($all_contact_attorney as $key=>$data)
				{	   
					$caselink_contact_email=array();
					
					$userdata=get_userdata($data);
					$caselink_contact_email[]=$userdata->user_email;
					
					$login_link=home_url();
					
					$system_name=get_option('lmgt_system_name');
								
					$arr['{{Lawyer System Name}}']= sanitize_text_field($system_name);						
					$arr['{{User Name}}']= sanitize_user($userdata->user_login);
					$arr['{{Case Name}}']= sanitize_text_field($case_result->case_name);
					$arr['{{Task Name}}']= sanitize_text_field($result_task->task_name);
					$arr['{{Due Date}}']= sanitize_text_field($result_task->due_date);
					$arr['{{Login Link}}']= esc_url($login_link);					
					$subject =get_option('lmgt_task_reminder_email_subject');
					$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
					$message = get_option('lmgt_task_reminder_email_template');	
					$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
	
					MJ_lawmgt_send_mail($caselink_contact_email,$subject_replacement,$message_replacement); 
				}	
			}
	    }		
	}
}  //task_remainder_hour_function  // 

function MJ_lawmgt_task_remainder_day_function()   //task_remainder_day_function  // 
{
	global $wpdb;
	
	$table_task_reminder = $wpdb->prefix. 'lmgt_task_reminder';
	
	$task_reminder_result = $wpdb->get_results("SELECT * FROM $table_task_reminder");

	foreach($task_reminder_result as $date)
	{		
		$due_date=$date->due_date;			
		$task_id=$date->task_id;			
		$reminder_time_value=$date->reminder_time_value;			
		$reminder_time_format=$date->reminder_time_format;	
		$reminder_case_id=$date->case_id;
		
		if($reminder_time_format == 'day')
		{			
			$newdate=strtotime('-'.$reminder_time_value.'day',strtotime($due_date));
			$current_reminder_date=date("Y-m-d",$newdate);
			$current_date=date("Y-m-d");
		
			if($current_reminder_date == $current_date)
			{				
				global $wpdb;
				$table_law_add_task = $wpdb->prefix. 'lmgt_add_task'; 				

				$result_task= $wpdb->get_row("SELECT * FROM $table_law_add_task where task_id=".$task_id);
				
				$case_id=$result_task->case_id;
				$table_case = $wpdb->prefix. 'lmgt_cases';		
				$case_result = $wpdb->get_row("SELECT case_name FROM $table_case where id=".$case_id);
				
				$contact_array=array();
				$contact_array=explode(",",$result_task->assigned_to_user);
				
				$attorney_array=array();
				$attorney_array=explode(",",$result_task->assign_to_attorney);
				
				$all_contact_attorney = array_merge($contact_array, $attorney_array);
				
				foreach ($all_contact_attorney as $key=>$data)
				{	   
					$caselink_contact_email=array();
					
					$userdata=get_userdata($data);
					$caselink_contact_email[]=sanitize_text_field($userdata->user_email);
					
					$login_link=home_url();
					
					$system_name=get_option('lmgt_system_name');
								
					$arr['{{Lawyer System Name}}']= sanitize_text_field($system_name);						
					$arr['{{User Name}}']= sanitize_user($userdata->user_login);
					$arr['{{Case Name}}']= sanitize_text_field($case_result->case_name);
					$arr['{{Task Name}}'] = sanitize_text_field($result_task->task_name);
					$arr['{{Due Date}}']= sanitize_text_field($result_task->due_date);
					$arr['{{Login Link}}']= esc_url($login_link);					
					$subject =get_option('lmgt_task_reminder_email_subject');
					$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
					$message = get_option('lmgt_task_reminder_email_template');	
					$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
	
					MJ_lawmgt_send_mail($caselink_contact_email,$subject_replacement,$message_replacement); 
				}					
			}
		}		
	}
} //end task_remainder_day_function  // 
//id convert into encrypted formate
function MJ_lawmgt_id_encrypt($id)
{
	$encrypted_id = base64_encode($id);
	 
	return $encrypted_id;
}
//id convert into decrypted formate
function MJ_lawmgt_id_decrypt($encrypted_id)
{	
	$decrypted_id = base64_decode($encrypted_id);

	return $decrypted_id;
}
//Number Html Tags special character remove from sring
function remove_number_tags_and_special_characters($string)
{	
	$search = array('0','1','2','3','4','5','6','7','8','9','!','@','#','$','%','^','&','*','(',')','.','{','}','<','>',',','+','-','*');
	$replace = array('','','','','','','','','','','','','','','','','','','','','','','','','','','','');
	$new_string=str_replace($search, $replace,strip_tags($string));

	return $new_string;
}

//Html Tags special character remove from sring
function MJ_lawmgt_remove_tags_and_special_characters($string)
{	
	$search = array('!','@','#','$','%','^','&','*','(',')','.','{','}','<','>',',','+','-','*');
	$replace = array('','','','','','','','','','','','','','','','','','','');
	$new_string=str_replace($search, $replace,strip_tags($string));

	return $new_string;
}
//ADD OR REMOVE CATEGORUY //
function MJ_lawmgt_add_or_remove_category()//lawmgt_add_or_remove_category
{	 
	$model = sanitize_text_field($_REQUEST['model']);
	
	$title = esc_html__("title",'lawyer_mgt');

	$table_header_title =  esc_html__("header",'lawyer_mgt');

	$button_text=  esc_html__("Add category",'lawyer_mgt');

	$label_text =  esc_html__("category Name",'lawyer_mgt');

	
	if($model == 'court_category')//court_category
	{
		

		$title = esc_html__("Add Court Category",'lawyer_mgt');

		$table_header_title =  esc_html__("Court Name",'lawyer_mgt');

		$button_text=  esc_html__("Add Court Category",'lawyer_mgt');

		$label_text =  esc_html__("Court Name",'lawyer_mgt');	

	}
	 
	 if($model == 'state_category')//state_category
	{
		

		$title = esc_html__("Add State Category",'lawyer_mgt');

		$table_header_title =  esc_html__("State Name",'lawyer_mgt');

		$button_text=  esc_html__("Add State Category",'lawyer_mgt');

		$label_text =  esc_html__("State Name",'lawyer_mgt');	

	}
	
	if($model == 'bench_category')//bench_category
	{
		

		$title = esc_html__("Add Bench Category",'lawyer_mgt');

		$table_header_title =  esc_html__("Bench Name",'lawyer_mgt');

		$button_text=  esc_html__("Add Bench Category",'lawyer_mgt');

		$label_text =  esc_html__("Bench Name",'lawyer_mgt');	

	}
	if($model == 'case_type_category')//bench_category
	{
		

		$title = esc_html__("Add Case Type",'lawyer_mgt');

		$table_header_title =  esc_html__("Case Type Name",'lawyer_mgt');

		$button_text=  esc_html__("Add Case Type",'lawyer_mgt');

		$label_text =  esc_html__("Case Type Name",'lawyer_mgt');	

	}
	 $cat_result = MJ_lawmgt_get_all_category( $model );	
	 
	?>
	<script type="text/javascript">
	$('.onlyletter_number_space_validation').keypress(function( e ) 
	{     
		 "use strict";	
		var regex = new RegExp("^[0-9a-zA-Z \b]+$");
		var key = String.fromCharCode(!event.charCode ? event.which: event.charCode);
		if (!regex.test(key)) 
		{
			event.preventDefault();
			return false;
		} 
   });  
	</script>
	<div class="modal-header padding_bottom_15_px"> <a href="#" class="close-btn badge badge-success pull-right custom_close_btn">X</a><!--MODAL-HEADER--->

  		<h4 id="myLargeModalLabel" class="modal-title"><?php echo esc_html($title); ?></h4>

	</div>

	<div class="panel panel-white"><!---PANEL-WHITE--->

  		<div class="category_listbox"><!---CATEGORY_LISTBOX----->

  			<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12"><!---TABLE-RESPONSIVE----->

		  		<table class="table">
			  		<thead>
			  			<tr>
							<th><?php echo esc_html($table_header_title); ?></th>
			                <th><?php esc_html_e('Action','lawyer_mgt'); ?></th>
			            </tr>
			        </thead>
					<?php 
					$increment = 1;

					if(!empty($cat_result))
					{
						foreach ($cat_result as $retrieved_data)
						{
							echo '<tr id="cat-'.esc_attr($retrieved_data->ID).'">';
							echo '<td>'.esc_attr($retrieved_data->post_title).'</td>';
							echo '<td id='.esc_attr($retrieved_data->ID).'><a class="btn-delete-cat badge badge-delete" model='.esc_attr($model).' href="#" id='.esc_attr($retrieved_data->ID).'>X</a></td>';
							echo '</tr>';
							$increment++;		
						}
					}
					 ?>
		        </table>
			</div><!---END TABLE-RESPONSIVE----->
		</div><!---END CATEGORY_LISTBOX----->	
		<form name="category_form" action="" method="post" class="form-horizontal" id="category_form"><!---CATEGORY_FORM----->

	  	 	<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label popup_label" for="category_name"><?php echo esc_html($label_text); ?><span class="require-field">*</span></label>

				<div class="col-sm-4" class="padding_bottom_10_px_css">

					<input id="category_name" class="form-control text-input onlyletter_number_space_validation" maxlength="50" value="" name="category_name" <?php if(isset($placeholder_text)){ ?> type="number" placeholder="<?php  echo esc_html($placeholder_text); }else{ ?>" type="text" <?php } ?>>

				</div>
				<div class="col-sm-4" class="padding_bottom_10_px_css">
					<input type="button" value="<?php echo $button_text; ?>" name="save_category" class="btn btn-success" model="<?php echo esc_attr($model); ?>" id="btn-add-cat"/>
				</div>

			</div>
		</form>
	</div><!---END PANEL-WHITE--->
	<?php 
	die();	
}
//ADD CATEGORY POPUP //
function MJ_lawmgt_add_category($data)
{

	global $wpdb;
	$model = sanitize_text_field($_REQUEST['model']);
	
	$status=1;
	$status_msg = esc_html__('You have entered value already exists. Please enter some other value.','lawyer_mgt');
	$array_var = array();
	$data = array();
	$data['category_name'] = sanitize_text_field($_POST['category_name']);
	$data['category_type'] = sanitize_text_field($_POST['model']);
    $posttitle =sanitize_text_field($_REQUEST['category_name']);
 
	
    $post = $wpdb->get_row( "SELECT * FROM $wpdb->posts WHERE upper(post_title) = '" . strtoupper($posttitle) . "' AND  post_type ='". $model."'" );
	 
    $postname= sanitize_text_field($post->post_title);
	
   if(!empty($post))
   {
	   $status=0;
   }
   else
   { 
		$id = MJ_lawmgt_add_categorytype($data);
		$row1 = '<tr id="cat-'.sanitize_text_field($id).'"><td>'.sanitize_text_field($_REQUEST['category_name']).'</td><td><a class="btn-delete-cat badge badge-delete" href="#" id='.esc_attr($id).' model="'.esc_attr($model).'">X</a></td></tr>';

		$option = "<option value='$id'>".esc_html($_REQUEST['category_name'])."</option>";

		$array_var[] = $row1;

		$array_var[] = $option;
   }
    $array_var[2]=$status;
    $array_var[3]=$status_msg;
	echo json_encode($array_var);

	die();
}
//-- Add Dynamic Category
function MJ_lawmgt_add_categorytype($data)
{
	global $wpdb;
	$result = wp_insert_post( array(

			'post_status' => 'publish',

			'post_type' => $data['category_type'],

			'post_title' => $data['category_name']) );

	 $id = $wpdb->insert_id;

	return $id;
}
//remove category 
function MJ_lawmgt_remove_category()
{
 
	wp_delete_post(sanitize_text_field($_REQUEST['cat_id']));
	
	die();
}
//-- Get Dynamic Categories
function MJ_lawmgt_get_all_category($model){

	$args= array('post_type'=> $model,'posts_per_page'=>-1,'orderby'=>'post_title','order'=>'Asc');

	$cat_result = get_posts( $args );

	return $cat_result;

}
//------------ GET STATE NAME BY COURT NAME --------------//
function MJ_lawmgt_get_court_by_state()
{
	$court_id= sanitize_text_field($_REQUEST['court_id']);
	global $wpdb;
	$table_court = $wpdb->prefix .'lmgt_court';
	$retrieve_data = $wpdb->get_results("SELECT * FROM $table_court where court_id=$court_id AND deleted_status=0");
	
	$array_var[]='<option value="">'.esc_html__('Select State','lawyer_mgt').'</option>';
	foreach($retrieve_data as $data)
	{
	 $state_id=$data->state_id;
	 $latest_posts = get_post($state_id);
	 $array_var[]='<option value="'.esc_attr($latest_posts->ID).'">'.esc_html($latest_posts->post_title).'</option>';
	}
	echo json_encode($array_var);
	die();	
}

//------------ GET BENCH NAME BY STATE NAME --------------//
function MJ_lawmgt_get_state_by_bench()
{
	$state_id= sanitize_text_field($_REQUEST['state_id']);
	global $wpdb;
	$table_court = $wpdb->prefix .'lmgt_court';
	$retrieve_data = $wpdb->get_results("SELECT * FROM $table_court where state_id=$state_id AND deleted_status=0");
	$bench_id=$retrieve_data[0]->bench_id;
	$bench_id_array=explode(',',$bench_id);
	$array_var[]='<option value="">'.esc_html__('Select Bench','lawyer_mgt').'</option>';
	foreach($bench_id_array as $data)
	{
	  $latest_posts = get_post($data);
	  $array_var[]='<option value="'.esc_attr($latest_posts->ID).'">'.esc_html($latest_posts->post_title).'</option>';
	} 
	echo json_encode($array_var);
	die();	
}

add_filter( 'cron_schedules', 'MJ_lawmgt_my_hearing_date' );

//HEARING DATE REMINDER//
function MJ_lawmgt_my_hearing_date( $schedules ) 
{
    $schedules['one_hour'] = array(
            'interval'  => 3600,
            'display'   => esc_html__( 'One hour', 'lawyer_mgt' )
    );
    return $schedules;
} 
// Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'MJ_lawmgt_my_hearing_date' ) ) 
{
    wp_schedule_event( time(), 'one_hour', 'MJ_lawmgt_my_hearing_date' );
} 

add_action( 'MJ_lawmgt_my_hearing_date', 'MJ_lawmgt_lawmgt_send_next_hearing_date_email' );

//SEND HEARING DATE REMINDER MAIL FUNCTION
function MJ_lawmgt_lawmgt_send_next_hearing_date_email()
{
	$enable_service=get_option('lmgt_enable_case_hearing_date_remainder');
	if($enable_service=='yes')
	{
		$obj_case=new MJ_lawmgt_case;
		$get_all_cases =$obj_case->MJ_lawmgt_get_open_all_case();
		$obj_next_hearing=new MJ_lawmgt_Orders;
		
		$before_days=get_option('lmgt_case_hearing_date_remainder');
		$today=date('Y-m-d');
		 
		if(!empty($get_all_cases))
		{		
			foreach($get_all_cases as $data)
			{
				$get_all_next_hearing_data =$obj_next_hearing->MJ_lawmgt_get_next_hearing_date_by_case_id($data->id);
				
				if(!empty($get_all_next_hearing_data))
				{
					foreach($get_all_next_hearing_data as $hearing_data)
					{
						$hearing_date=$hearing_data->next_hearing_date;
						
						if(!empty($hearing_date))
						{
							$mail_sent=MJ_lawmgt_check_alert_mail_send($data->id,$hearing_date);
						 
							$date1=date_create($today);
							$date2=date_create($hearing_date);
							$interval = date_diff($date1,$date2);
							$difference=$interval->format('%R%a');
							 
							if($difference<= +$before_days && $difference > 0)
							{	
								if($mail_sent==0)
								{
									$contact_attorney_data=MJ_lawmgt_get_contact_and_attorney_data_by_case_id($data->id);
									
									foreach($contact_attorney_data as $assign_userdata)
									{ 	
										$userdata=get_userdata($assign_userdata);
										$system_name=get_option('lmgt_system_name');				
										$to=$userdata->user_email;
										$name = $userdata->display_name;
										$arr['{{Lawyer System Name}}']=$system_name;
										$arr['{{User Name}}']=$name;						
										$arr['{{Case Name}}']=MJ_lawmgt_get_case_name($data->id);
										$arr['{{Case Number}}']=MJ_lawmgt_get_case_number($data->id);
										$arr['{{Next Hearing Date}}']=$hearing_date;
										$subject =get_option('lmgt_next_hearing_reminder_email_subject');
										$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
										$message = get_option('lmgt_next_hearing_reminder_email_template');	
										$message_replacement = strip_tags(MJ_lawmgt_string_replacemnet($arr,$message));
										$success=MJ_lawmgt_send_mail($to,$subject_replacement,$message_replacement); 	
									}
									MJ_lawmgt_insert_alert_mail($data->id,$hearing_date);
								}
							}		
						}
					}
				}	
			}
		} 
	}
}


//SEND REMINDER MAIL CHECK  FUNCTION
function MJ_lawmgt_check_alert_mail_send($case_id,$hearing_date)
{
	global $wpdb;
	$table_lmgt_alert_mail_log = $wpdb->prefix . 'lmgt_alert_mail_log';
	
	$result= $wpdb->get_var("SELECT count(*) FROM $table_lmgt_alert_mail_log WHERE case_id =$case_id AND next_hearing_date='$hearing_date'");
	 
	return $result;
}

//INSERT REMINDER MESSGAE FUNCTION
function MJ_lawmgt_insert_alert_mail($case_id,$hearing_date)
{
	global $wpdb;
	$table_lmgt_alert_mail_log = $wpdb->prefix . 'lmgt_alert_mail_log';
	$alertdata['case_id']=$case_id;
	$alertdata['next_hearing_date']=$hearing_date;
	$alertdata['alert_date']=date("Y-m-d");
	$result=$wpdb->insert( $table_lmgt_alert_mail_log, $alertdata );
	 
	return $result;
	
}
//----YEAR WISE CASE FILTER -----------//
function MJ_lawmgt_case_year_filter()
{
	$user_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('cases');
 	$page_columns_array=explode(',',get_option( 'lmgt_case_columns_option' ));
	
	$selection_id= sanitize_text_field($_REQUEST['selection_id']);
	$hidden_case_filter= sanitize_text_field($_REQUEST['hidden_case_filter']);
	$user_role=MJ_lawmgt_get_current_user_role();
	$obj_case=new MJ_lawmgt_case;
	$current_user_id = get_current_user_id();
	if($selection_id == 'all')
	{
		if($user_role == 'attorney')
		{
			if($hidden_case_filter == 'open')
			{
				if($user_access['own_data'] == '1')
				{
					$case_data=$obj_case->MJ_lawmgt_get_open_case_by_attorney($current_user_id);
				}
				else
				{
					$case_data=$obj_case->MJ_lawmgt_get_open_all_case();
				}				
			}
			else
			{
				if($user_access['own_data'] == '1')
				{
					$case_data=$obj_case->MJ_lawmgt_get_close_case_by_attorney($current_user_id);
				}
				else
				{
					$case_data=$obj_case->MJ_lawmgt_get_close_all_case();
				}	
			}
		}
		elseif($user_role == 'client')
		{	
			if($hidden_case_filter == 'open')
			{
				if($user_access['own_data'] == '1')
				{
					$case_data=$obj_case->MJ_lawmgt_get_open_case_by_client();
				}
				else
				{
					$case_data=$obj_case->MJ_lawmgt_get_open_all_case();
				}	
			}
			else
			{
				if($user_access['own_data'] == '1')
				{
					$case_data=$obj_case->MJ_lawmgt_get_close_case_by_client();
				}
				else
				{
					$case_data=$obj_case->MJ_lawmgt_get_close_all_case();
				}	
			}
		}
		else
		{
			
			if($hidden_case_filter == 'open')
			{
				if($user_access['own_data'] == '1')
				{
					$case_data = $obj_case->MJ_lawmgt_get_open_all_case_created_by();
				}
				else
				{
					$case_data=$obj_case->MJ_lawmgt_get_open_all_case();
				}
			}
			else
			{
				if($user_access['own_data'] == '1')
				{
					$case_data = $obj_case->MJ_lawmgt_get_close_all_case_created_by();
				}
				else
				{
					$case_data=$obj_case->MJ_lawmgt_get_close_all_case();
				}
			}
		}
	}	
	else 
	{
		if($user_role == 'attorney')
		{
			if($hidden_case_filter == 'open')
			{
				if($user_access['own_data'] == '1')
				{
					$case_data=$obj_case->MJ_lawmgt_get_open_case_by_attorney_and_year($selection_id);
				}
				else
				{
					$case_data=$obj_case->MJ_lawmgt_get_open_all_case_and_year($selection_id);
				}					
			}
			else
			{
				if($user_access['own_data'] == '1')
				{
					$case_data=$obj_case->MJ_lawmgt_get_close_case_by_attorney_and_year($selection_id);
				}
				else
				{
					$case_data=$obj_case->MJ_lawmgt_get_close_all_case_and_year($selection_id);
				}			
			}
		}
		elseif($user_role == 'client')
		{	
			if($hidden_case_filter == 'open')
			{
				if($user_access['own_data'] == '1')
				{
					$case_data=$obj_case->MJ_lawmgt_get_open_case_by_client_and_year($selection_id);
					
				}
				else
				{
					$case_data=$obj_case->MJ_lawmgt_get_open_all_case_and_year($selection_id);
				}
			}
			else
			{
				if($user_access['own_data'] == '1')
				{
					$case_data=$obj_case->MJ_lawmgt_get_close_case_by_client_and_year($selection_id);
				}
				else
				{
					$case_data=$obj_case->MJ_lawmgt_get_close_all_case_and_year($selection_id);
				}					
			}
		}
		else
		{
			
			if($hidden_case_filter == 'open')
			{
				if($user_access['own_data'] == '1')
				{
					$case_data=$obj_case->MJ_lawmgt_get_open_all_case_and_year_created_by($selection_id);
				}
				else
				{	
					$case_data=$obj_case->MJ_lawmgt_get_open_all_case_and_year($selection_id);
				}
			}
			else
			{
				if($user_access['own_data'] == '1')
				{
					$case_data=$obj_case->get_close_all_case_and_year_created_by($selection_id);
				}
				else
				{
					$case_data=$obj_case->MJ_lawmgt_get_close_all_case_and_year($selection_id);
				}
			}
		}	
	}
	 
	$case_filter_data = array();	
	global $wpdb;		
	$table_cases = $wpdb->prefix. 'lmgt_cases';
	if(!empty($case_data))
	{
		foreach($case_data as $retrieved_data)
		{
			$case_id=$retrieved_data->id;
			  $attorney_name=get_userdata($retrieved_data->case_assgined_to);
			  $user=explode(",",$retrieved_data->case_assgined_to);
				$case_assgined_to=array();
				if(!empty($user))
				{						
					foreach($user as $data4)
					{
						$case_assgined_to[]=MJ_lawmgt_get_display_name($data4);
					}
				}	
				
				$caselink_contact=array();
				global $wpdb;
				$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';

				$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
				 foreach ($result_link_contact as $key => $object)
				 {			
					$result=get_userdata($object->user_id);
					if(is_super_admin ())
					{
						$caselink_contact[]='<a href="?page=contacts&tab=viewcontact&action=view&contact_id='.esc_attr(MJ_lawmgt_id_encrypt($object->user_id)).'">'.esc_html($result->display_name).'</a>';
					}
					else
					{
						$caselink_contact[]='<a href="?dashboard=user&page=contacts&tab=viewcontact&action=view&contact_id='.esc_attr(MJ_lawmgt_id_encrypt($object->user_id)).'">'.esc_html($result->display_name).'</a>';
					}
				  }																
				  $contact=implode(',',$caselink_contact);
					
				$opponents_details_array=json_decode($retrieved_data->opponents_details);
				$opponents_array=array();	
					
				if(!empty($opponents_details_array))
				{
					foreach ($opponents_details_array as $data)
					{	
						if($data->opponents_name != '' && $data->opponents_email != '' && $data->opponents_mobile_number != '') 
						{							
							$opponents_array[]=$data->opponents_name.'-'.$data->opponents_email.'- '.$data->opponents_phonecode.' '.$data->opponents_mobile_number;		
						}
						elseif($data->opponents_name != '' && $data->opponents_email != '') 
						{
							$opponents_array[]=$data->opponents_name.'-'.$data->opponents_email;		
						}
						elseif($data->opponents_name != '' && $data->opponents_mobile_number != '') 
						{
							$opponents_array[]=$data->opponents_name.'- '.$data->opponents_phonecode.' '.$data->opponents_mobile_number;		
						}
						else
						{
							$opponents_array[]=$data->opponents_name;
						}					
					}
				}
				$opponents_attorney_details=json_decode($retrieved_data->opponents_attorney_details);
				$opponents_attorney_array=array();		
				if(!empty($opponents_attorney_details))
				{
					foreach ($opponents_attorney_details as $data)
					{
						if($data->opponents_attorney_name != '' && $data->opponents_attorney_email != '' && $data->opponents_attorney_mobile_number != '') 
						{							
							$opponents_attorney_array[]=$data->opponents_attorney_name.'-'.$data->opponents_attorney_email.'- '.$data->opponents_attorney_phonecode.' '.$data->opponents_attorney_mobile_number;		
						}
						elseif($data->opponents_attorney_name != '' && $data->opponents_attorney_email != '') 
						{
							$opponents_attorney_array[]=$data->opponents_attorney_name.'-'.$data->opponents_attorney_email;		
						}
						elseif($data->opponents_attorney_name != '' && $data->opponents_attorney_mobile_number != '') 
						{
							$opponents_attorney_array[]=$data->opponents_attorney_name.'- '.$data->opponents_attorney_phonecode.' '.$data->opponents_attorney_mobile_number;		
						}
						else
						{
							$opponents_attorney_array[]=$data->opponents_attorney_name;
						}
					}
				}
			$document_row ='<tr>';
				if($hidden_case_filter == 'open')
				{
					$document_row.='<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="'.esc_attr($retrieved_data->id).'"></td>';
				}
				 if(in_array('case_number',$page_columns_array)) 
				{  
					$document_row.='<td class="title">'.esc_html($retrieved_data->case_number).'</td>';
				}					
				if(in_array('case_name',$page_columns_array)) 
				{ 
					$document_row.='<td class="case_link">';
						if (is_super_admin ())
						{
							$document_row.='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'">'.esc_html($retrieved_data->case_name).'</a>';
						}
						else
						{
							$document_row.='<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'">'.esc_html($retrieved_data->case_name).'</a>';
						}		
						$document_row.='</td>';
				}
				if(in_array('open_date',$page_columns_array)) 
				{ 
					$document_row.='<td class="tags_name">'.esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->open_date)).'</td>';
				} 
				if($hidden_case_filter == 'close')
				{
					$document_row.='<td class="tags_name">'.esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->close_date)).'</td>';
				}
				if(in_array('case_type',$page_columns_array))
				{
					$document_row.='<td class="tags_name">'.esc_html(get_the_title($retrieved_data->case_type)).'</td>';
				}
				if(in_array('statute_of_limitation',$page_columns_array))
				{
					$document_row.='<td class="tags_name">'.esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->statute_of_limitations)).'</td>';
				}
				if(in_array('priority',$page_columns_array))
				{ 
					$document_row.='<td class="tags_name">'.esc_html($retrieved_data->priority).'</td>';
				}
				if(in_array('practice_area',$page_columns_array))
				{
					$document_row.='<td class="tags_name">'.esc_html(get_the_title($retrieved_data->practice_area_id)).'</td>';
				}
				if(in_array('court_details',$page_columns_array))
				{
					$document_row.='<td>'.esc_html(get_the_title($retrieved_data->court_id)).' - '.esc_html(get_the_title($retrieved_data->state_id)).' - '.esc_html(get_the_title($retrieved_data->bench_id)).'</td>';
				}
				if(in_array('contact_link',$page_columns_array))
				{
					$document_row.='<td class="tags_name">'.$contact.'</td>';			
				}
				if(in_array('billing_contact_name',$page_columns_array))
				{ 
					$document_row.='<td class="case_link">';
					if (is_super_admin ())
					{
						$document_row.='<a href="?page=contacts&tab=viewcontact&action=view&contact_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->billing_contact_id)).'">'.esc_html(MJ_lawmgt_get_display_name($retrieved_data->billing_contact_id)).'</a>';
					}
					else
					{
						$document_row.='<a href="?dashboard=user&page=contacts&tab=viewcontact&action=view&contact_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->billing_contact_id)).'">'.esc_html(MJ_lawmgt_get_display_name($retrieved_data->billing_contact_id)).'</a>';
					}		
					$document_row.='</td>';
				}
				if(in_array('billing_type',$page_columns_array))
				{ 
					$document_row.='<td class="tags_name">'.esc_html($retrieved_data->billing_type).'</td>';
				}
				if(in_array('attorney_name',$page_columns_array))
				{
					$document_row.='<td class="case_link">';
					if (is_super_admin ())
					{
						$document_row.=''.esc_html(implode(", ",$case_assgined_to)).'';
					}
					else
					{
						$document_row.=''.esc_html(implode(", ",$case_assgined_to)).'';
					}		
					$document_row.='</td>';
				}
				if(in_array('court_hall_no',$page_columns_array))
				{
					$document_row.='<td class="tags_name">'.esc_html($retrieved_data->court_hall_no).'</td>';
				}
				if(in_array('floor',$page_columns_array))
				{
					$document_row.='<td class="tags_name">'.esc_html($retrieved_data->floor).'</td>';
				}
				if(in_array('crime_no',$page_columns_array))
				{ 
					$document_row.='<td class="tags_name">'.esc_html($retrieved_data->crime_no).'</td>';
				}
				if(in_array('fir_no',$page_columns_array))
				{
					$document_row.='<td class="tags_name">'.esc_html($retrieved_data->fri_no).'</td>';
				}
				if(in_array('hearing_date',$page_columns_array))
				{
					$document_row.='<td class="case_link">';
					$obj_next_hearing_date=new MJ_lawmgt_Orders;
					$next_hearing_date= $obj_next_hearing_date->MJ_lawmgt_get_next_hearing_date_asc_by_case_id($case_id);
					$hearing_date_array=array();
					foreach($next_hearing_date as $data)
					{
						$hearing_date_array[]=MJ_lawmgt_getdate_in_input_box($data->next_hearing_date);
					}
					$date_value_array=implode(",</br>",$hearing_date_array);
					$document_row.=$date_value_array.'</td>';
				}
				if(in_array('stages',$page_columns_array))
				{
					$document_row.='<td class="case_link">';
					if(!empty($retrieved_data->stages))
					{
						$stages=json_decode($retrieved_data->stages);
					}
					 
					$increment = 0;
					foreach($stages as $data)
					{ 
						$increment++;
						$document_row.='<span class="">'.esc_html($increment).'.'.esc_html($data->value).'</span></br>';
					} 
					$document_row.='</td>';	
				}
				if(in_array('classification',$page_columns_array))
				{ 
					$document_row.='<td class="tags_name">'.esc_html($retrieved_data->classification).'</td>';
				}
				if(in_array('earlier_court_history',$page_columns_array))
				{
					$document_row.='<td class="tags_name">'.esc_html($retrieved_data->earlier_history).'</td>';
				}
				if(in_array('referred_by',$page_columns_array))
				{
					$document_row.='<td class="tags_name">'.esc_html(MJ_lawmgt_get_display_name($retrieved_data->referred_by)).'</td>';
				}
				if(in_array('opponent_details',$page_columns_array))
				{
					$document_row.='<td class="tags_name">'.esc_html(implode(',',$opponents_array)).'</td>';
				}
				if(in_array('opponent_attorney_details',$page_columns_array))
				{ 
					$document_row.='<td class="tags_name">'.esc_html(implode(',',$opponents_attorney_array)).'</td>';
				}	
				$document_row.='<td class="action">';				
				 
					if (is_super_admin ())
					{						 
						if($hidden_case_filter == 'open')
						{
							$document_row .='<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'" class="btn btn-success">'.esc_html__('View','lawyer_mgt').'</a>
							<a href="?page=cases&tab=add_case&action=edit&case_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'" 	class="btn btn-info">'.esc_html__('Edit','lawyer_mgt').'</a>
							<a href="?page=cases&tab=caselist&action=delete&case_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'" class="btn btn-danger" 
							onclick="return confirm(Are you sure you want to delete this record?);">
							'.esc_html__('Close','lawyer_mgt').'</a>';
							
						}
						else
						{
							$document_row .='<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'" class="btn btn-success">'.esc_html__('View','lawyer_mgt').'</a>';

							$document_row .='<a href="?page=cases&tab=caselist&action=reopen&case_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'" class="btn btn-success" onclick="return confirm('.esc_html__('Are you sure you want to ReOpen this Case?','lawyer_mgt').')">'.esc_html__( 'Reopen', 'lawyer_mgt' ).'</a>';
						}
					}
					else
					{
						$document_row .='<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'" class="btn btn-success">'.esc_html__('View','lawyer_mgt').'</a>';
						if($hidden_case_filter == 'open')
						{
							if($user_access['edit']=='1')
							{
								$document_row .='<a href="?dashboard=user&page=cases&tab=add_case&action=edit&case_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'" class="btn btn-info">'.esc_html__('Edit','lawyer_mgt').'</a>';
							}
							if($user_access['delete']=='1')
							{
								$document_row .='<a href="?dashboard=user&page=cases&tab=caselist&action=delete&case_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'" class="btn btn-danger" 
								onclick="return confirm(Are you sure you want to delete this record?);">
								'.esc_html__('Close','lawyer_mgt').'</a>';
							}
						}
						else
						{
							if($user_access['add']=='1')
							{
								$document_row .='<a href="?dashboard=user& page=cases&tab=caselist&action=reopen&case_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'" class="btn btn-success" onclick="return confirm('.esc_html__('Are you sure you want to ReOpen this Case?','lawyer_mgt').')">'.esc_html__( 'Reopen', 'lawyer_mgt' ).'</a>';
							}
						}	
					}	
			 	
				$document_row .='</td>               
			</tr>';			
			$case_filter_data[]=$document_row;	
		/* 	var_dump($case_filter_data);
			die; */
		} 
	}	
	echo json_encode($case_filter_data);
	die();  
}

//dashboard page access right
function MJ_lawmgt_page_access_rolewise_accessright_dashboard($page)
{
	$user = wp_get_current_user();
	$user_id=$user->ID; 
	$role = MJ_lawmgt_get_roles($user_id);
	  
	$menu = get_option( 'lmgt_access_right');	
	
	foreach ( $menu as $key=>$value ) 
	{		
		if($value['page_link'] == $page)
		{
			return $flage=$value[$role];
		}	
	 
	}
} 
add_filter( 'cron_schedules', 'MJ_lawmgt_myaddweekly' );

function MJ_lawmgt_myaddweekly( $schedules ) 
{
    $schedules['weekly_case_report'] = array(
            'interval'  => 604800,
            'display'   => esc_html__( 'Once Weekly', 'lawyer_mgt' )
    );
    return $schedules;
} 

// Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'MJ_lawmgt_myaddweekly' ) ) 
{
    wp_schedule_event( time(), 'weekly_case_report', 'MJ_lawmgt_myaddweekly' );
} 
if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
{
	add_action( 'MJ_lawmgt_myaddweekly', 'MJ_lawmgt_lawmgt_send_weekly_case_report' ); 
}
//SEND WEEKLY CASE REPORT MAIL FUNCTION
function MJ_lawmgt_lawmgt_send_weekly_case_report()
{			
	$obj_case=new MJ_lawmgt_case;
	$casedata=$obj_case->MJ_lawmgt_get_open_all_case();
	if(!empty($casedata))
	{
		foreach ($casedata as $retrieved_data)
		{		
			$case_id=$retrieved_data->id;
			lawmgt_weekly_case_report($case_id);
		}
		?>
		<script type="text/javascript">
		"use strict"; 
		location.reload();				
		</script>
		<?php
	}
}
function lawmgt_weekly_case_report($case_id)
{
	$document_dir = WP_CONTENT_DIR;
	$document_dir .= '/uploads/';
	$document_path = $document_dir;
	if (!file_exists($document_path))
	{
		mkdir($document_path, 0777, true);		
	}
	
	$obj_case=new MJ_lawmgt_case;		
	$case_data=$obj_case->MJ_lawmgt_get_single_case($case_id);
	$contact_data=$obj_case->MJ_lawmgt_get_all_contact($case_id);
	
	if(!empty($contact_data))
	{			
		foreach($contact_data as $key=>$contact_user_id)
		{		
			$user_info=get_userdata($contact_user_id->user_id);
			set_time_limit(1200);			
			wp_enqueue_style( 'bootstrap-css', plugins_url( '/assets/css/bootstrap.css', __FILE__) );
			wp_enqueue_style( 'style-css', plugins_url( '/assets/css/style.css', __FILE__) );
			wp_enqueue_script('bootstrap-js', plugins_url( '/assets/js/bootstrap.js', __FILE__ ) );
			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="weekly_report.pdf"');
			header('Content-Transfer-Encoding: binary');
			header('Accept-Ranges: bytes');	
			require LAWMS_PLUGIN_DIR. '/lib/mpdf/mpdf.php';	 
			$stylesheet = wp_enqueue_style( 'style-css', plugins_url( '/assets/css/style.css', __FILE__) );
			$mpdf	=	new mPDF('c','A4','','' , 5 , 5 , 5 , 0 , 0 , 0); 
			$mpdf->debug = true;
			$mpdf->WriteHTML('<html>');
			$mpdf->WriteHTML('<head>');
			$mpdf->WriteHTML('<style></style>');
			$mpdf->WriteHTML($stylesheet,1); // Writing style to pdf
			$mpdf->WriteHTML('</head>');
			$mpdf->WriteHTML('<body>');		
			$mpdf->SetTitle('Weekly Case Report');
					$mpdf->WriteHTML('<div class="weekly_title"><u>'.esc_html__('Weekly Case Report','lawyer_mgt').'</u><div>');
					 $mpdf->WriteHTML('<div id="invoice_print">');		
							$mpdf->WriteHTML('<img class="invoicefont1" src="'.plugins_url('/lawyers-management/assets/images/invoice.jpg').'" width="100%">');
							$mpdf->WriteHTML('<div class="main_div">');	
							
									$mpdf->WriteHTML('<table class="width_100_print" border="0">');					
									$mpdf->WriteHTML('<tbody>');
										$mpdf->WriteHTML('<tr>');
											$mpdf->WriteHTML('<td class="width_1_print">');
												$mpdf->WriteHTML('<img class="system_logo system_logo_print"  src="'.esc_url(get_option( 'lmgt_system_logo' )).'">');
											$mpdf->WriteHTML('</td>');							
											$mpdf->WriteHTML('<td class="only_width_20_print">');	
												$mpdf->WriteHTML('<table border="0">');					
												$mpdf->WriteHTML('<tbody>');
													$mpdf->WriteHTML('<tr>');																	
														$mpdf->WriteHTML('<td class="padding_bottom_20_pc_css">');
															$mpdf->WriteHTML('<b class="font_family">'.esc_html__('Address ','lawyer_mgt').':</b>');
														$mpdf->WriteHTML('</td>');	
														$mpdf->WriteHTML('<td class="padding_left_5 table_td_font font_family">'.chunk_split(esc_html(get_option( 'lmgt_address' )),20,"<BR>").'');
														$mpdf->WriteHTML('</td>');											
													$mpdf->WriteHTML('</tr>');
													$mpdf->WriteHTML('<tr>');																	
														$mpdf->WriteHTML('<td><b class="font_family">'.esc_html__('Email ','lawyer_mgt').' :</b>');
														$mpdf->WriteHTML('</td>');	
														$mpdf->WriteHTML('<td class="padding_left_5 table_td_font font_family">'.esc_html(get_option( 'lmgt_email' ))."<br>".'');
														$mpdf->WriteHTML('</td>');	
													$mpdf->WriteHTML('</tr>');
													$mpdf->WriteHTML('<tr>');																	
														$mpdf->WriteHTML('<td>');
															$mpdf->WriteHTML('<b class="font_family">'.esc_html__('Phone ','lawyer_mgt').' :</b>');
														$mpdf->WriteHTML('</td>');	
														$mpdf->WriteHTML('<td class="padding_left_5 table_td_font font_family">'.esc_html(get_option( 'lmgt_contact_number' ))."<br>".'');
														$mpdf->WriteHTML('</td>');											
													$mpdf->WriteHTML('</tr>');
												$mpdf->WriteHTML('</tbody>');
											$mpdf->WriteHTML('</table>');
											$mpdf->WriteHTML('</td>');
											$mpdf->WriteHTML('<td align="right" class="width_24">');
											$mpdf->WriteHTML('</td>');
										$mpdf->WriteHTML('</tr>');
									$mpdf->WriteHTML('</tbody>');
								$mpdf->WriteHTML('</table>');
								
								$mpdf->WriteHTML('<table>');
							 $mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td>');
								
									$mpdf->WriteHTML('<table class="width_50_print"  border="0">');
										$mpdf->WriteHTML('<tbody>');				
										$mpdf->WriteHTML('<tr>');
											$mpdf->WriteHTML('<td colspan="2" class="billed_to_print" align="center">');								
												$mpdf->WriteHTML('<h3 class="billed_to_lable font_family">'.esc_html__('Case  Name ','lawyer_mgt').'. </h3>');
												$mpdf->WriteHTML('<h3 class="billed_to_lable font_family">'.esc_html__('User Name ','lawyer_mgt').'. </h3>');
											$mpdf->WriteHTML('</td>');
											$mpdf->WriteHTML('<td class="width_40_print">');	
													$mpdf->WriteHTML('<h3 class="display_name font_family">'.chunk_split(ucwords(esc_html($case_data->case_name)),30,"<BR>").'</h3>'); 
													
													$mpdf->WriteHTML('<h3 class="display_name font_family">'.chunk_split(ucwords(esc_html($user_info->display_name)),30,"<BR>").'</h3>'); 
													$address=$user_info->address;										
													$mpdf->WriteHTML(''.chunk_split(esc_html($address),30,"<BR>").''); 
													  $mpdf->WriteHTML(''.esc_html($user_info->city_name).','); 
													 $mpdf->WriteHTML(''.esc_html($user_info->pin_code).'<br>'); 
													 $mpdf->WriteHTML(''.esc_html($user_info->mobile).'<br>'); 
												
											 $mpdf->WriteHTML('</td>');
										 $mpdf->WriteHTML('</tr>');									
									 $mpdf->WriteHTML('</tbody>');
								 $mpdf->WriteHTML('</table>');
								
								$mpdf->WriteHTML('</td>');
								$mpdf->WriteHTML('<td>');
								
								   $mpdf->WriteHTML('<table class="width_50_print"  border="0">');
									 $mpdf->WriteHTML('<tbody>');				
										 $mpdf->WriteHTML('<tr>');	
											 $mpdf->WriteHTML('<td class="width_30_print">');
											 $mpdf->WriteHTML('</td>');
											 $mpdf->WriteHTML('<td class="width_20_print invoice_lable align_center">');
												
													$case_number=$case_data->case_number;
																				
													$mpdf->WriteHTML('<h3 class="invoice_color font_family"><span class="font_size_12_px_css">'.esc_html__('Case Number','lawyer_mgt').' #<br></span><span class="font_size_18_px_css">'.esc_html($case_number).'</span>');									
																											
											 $mpdf->WriteHTML('</td>');							
										 $mpdf->WriteHTML('</tr>');
										 $mpdf->WriteHTML('<tr>');	
											 $mpdf->WriteHTML('<td class="width_30_print">');
											 $mpdf->WriteHTML('</td>');
											 $mpdf->WriteHTML('<td class="width_20_print" align="center">');
											 $open_date=MJ_lawmgt_getdate_in_input_box($case_data->open_date);
												$mpdf->WriteHTML('<h5 class="h5_pdf font_family align_center">'.esc_html__(' Date ','lawyer_mgt').' : '.esc_html($open_date).'</h5>');
																							
											 $mpdf->WriteHTML('</td>');							
										 $mpdf->WriteHTML('</tr>');						
									 $mpdf->WriteHTML('</tbody>');
								 $mpdf->WriteHTML('</table>');	
								$mpdf->WriteHTML('</td>');
							  $mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('</table>');
							$obj_orders=new MJ_lawmgt_Orders;
							$result_order=$obj_orders->MJ_lawmgt_get_case_wise_orders($case_id);
							if(!empty($result_order))
							{
								$mpdf->WriteHTML('<table class="width_100_print">');	
									$mpdf->WriteHTML('<tbody>');	
										$mpdf->WriteHTML('<tr>');
											$mpdf->WriteHTML('<td class="padding_left_20_px_css">');
												$mpdf->WriteHTML('<h3 class="entry_lable font_family">'.esc_html__('Orders ','lawyer_mgt').'</h3>');
											$mpdf->WriteHTML('</td>');	
										$mpdf->WriteHTML('</tr>');	
									$mpdf->WriteHTML('</tbody>');
								$mpdf->WriteHTML('</table>');
								
								$mpdf->WriteHTML('<table class="table table-bordered table_row_color" class="width_93" border="1">');
									$mpdf->WriteHTML('<thead>');
															
											$mpdf->WriteHTML('<tr>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center padding_10_pdf">#</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('DATE ','lawyer_mgt').'</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('JUDGE NAME ','lawyer_mgt').'</th>');						
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('ORDER DETAILS ','lawyer_mgt').'</th>');
																			
											$mpdf->WriteHTML('</tr>');						
										
									$mpdf->WriteHTML('</thead>');
									$mpdf->WriteHTML('<tbody>');
									
									$id=1;
											
										foreach($result_order as $data1)
										{ 
											$bg_color = $id % 2 === 0 ? "#cad5f5" : "white";
											if($bg_color == 'white')
											{
												$bg_color_css='pdf_background_color_td_css_white';
											}
											else
											{
												$bg_color_css='pdf_background_color_td_css_blue';
											}											
											$mpdf->WriteHTML('<tr class="entry_list '.$bg_color_css.'">');	
												$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($id).'</td>');
												$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html(MJ_lawmgt_getdate_in_input_box($data1->date)).'</td>');
												$mpdf->WriteHTML('<td class="table_td_font align_center padding_10_pdf">'.esc_html($data1->judge_name).'</td>');
												$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($data1->orders_details).'</td>');
											$mpdf->WriteHTML(' </tr>');
										
											$id=$id+1;
										}					
														
									
									$mpdf->WriteHTML('</tbody>');
								$mpdf->WriteHTML('</table>');
							}	
							$obj_judgments=new MJ_lawmgt_Judgments;
							$result_judgement=$obj_judgments->MJ_lawmgt_get_all_case_judgments($case_id);
							if(!empty($result_judgement))
							{		
								 $mpdf->WriteHTML('<table class="width_100_print">');	
									$mpdf->WriteHTML('<tbody>');	
										$mpdf->WriteHTML('<tr>');
											$mpdf->WriteHTML('<td class="padding_left_20_px_css">');
												$mpdf->WriteHTML('<h3 class="entry_lable font_family">'.esc_html__('Judgments','lawyer_mgt').'</h3>');
											$mpdf->WriteHTML('</td>');	
										$mpdf->WriteHTML('</tr>');	
									$mpdf->WriteHTML('</tbody>');
								$mpdf->WriteHTML('</table>');				
							
								
								$mpdf->WriteHTML('<table class="table table-bordered table_row_color" class="width_93" border="1">');
									$mpdf->WriteHTML('<thead>');
															
											$mpdf->WriteHTML('<tr>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center padding_10_pdf">#</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('DATE ','lawyer_mgt').'</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('JUDGE NAME ','lawyer_mgt').'</th>');						
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('JUDGEMENT DETAILS ','lawyer_mgt').'</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('lAW DETAILS ','lawyer_mgt').'</th>');
											$mpdf->WriteHTML('</tr>');						
										
									$mpdf->WriteHTML('</thead>');
									$mpdf->WriteHTML('<tbody>');
									
									$id=1;
											
									foreach($result_judgement as $data2)
									{ 					 
										$bg_color = $id % 2 === 0 ? "#cad5f5" : "white";	
										if($bg_color == 'white')
										{
											$bg_color_css='pdf_background_color_td_css_white';
										}
										else
										{
											$bg_color_css='pdf_background_color_td_css_blue';
										}	
										$mpdf->WriteHTML('<tr class="entry_list '.$bg_color_css.'">');
											$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($id).'</td>');
											$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html(MJ_lawmgt_getdate_in_input_box($data2->date)).'</td>');
											$mpdf->WriteHTML('<td class="table_td_font align_center padding_10_pdf">'.esc_html($data2->judge_name).'</td>');
											$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($data2->judgments_details).'</td>');
											$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($data2->judgments_law_details).'</td>');
											
										$mpdf->WriteHTML(' </tr>');
									
										$id=$id+1;
									}	
											
									$mpdf->WriteHTML('</tbody>');
								$mpdf->WriteHTML('</table>');
							}	
							
							$obj_next_hearing_date= new MJ_lawmgt_Orders;
							$result_hearing_date=$obj_next_hearing_date->MJ_lawmgt_get_casewise_all_next_hearing_date($case_id);
							if(!empty($result_hearing_date))
							{		
								 $mpdf->WriteHTML('<table class="width_100_print">');	
									$mpdf->WriteHTML('<tbody>');	
										$mpdf->WriteHTML('<tr>');
											$mpdf->WriteHTML('<td class="padding_left_20_px_css">');
												$mpdf->WriteHTML('<h3 class="entry_lable font_family">'.esc_html__('HEARING DATES','lawyer_mgt').'</h3>');
											$mpdf->WriteHTML('</td>');	
										$mpdf->WriteHTML('</tr>');	
									$mpdf->WriteHTML('</tbody>');
								$mpdf->WriteHTML('</table>');				
							
								
								$mpdf->WriteHTML('<table class="table table-bordered table_row_color" class="width_93" border="1">');
									$mpdf->WriteHTML('<thead>');
															
											$mpdf->WriteHTML('<tr>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center padding_10_pdf">#</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('JUDGE NAME ','lawyer_mgt').'</th>');						
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('HEARING DATE ','lawyer_mgt').'</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('PURPOSE OF HEARING ','lawyer_mgt').' </th>');
											$mpdf->WriteHTML('</tr>');						
										
									$mpdf->WriteHTML('</thead>');
									$mpdf->WriteHTML('<tbody>');
									
									$id=1;
											
									foreach($result_hearing_date as $data3)
									{ 					 
										$bg_color = $id % 2 === 0 ? "#cad5f5" : "white";	
										if($bg_color == 'white')
										{
											$bg_color_css='pdf_background_color_td_css_white';
										}
										else
										{
											$bg_color_css='pdf_background_color_td_css_blue';
										}	
										$mpdf->WriteHTML('<tr class="entry_list '.$bg_color_css.'">');
											$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($id).'</td>');
											$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($data3->judge_name).'</td>');
											$mpdf->WriteHTML('<td class="table_td_font align_center padding_10_pdf">'.esc_html(MJ_lawmgt_getdate_in_input_box($data3->next_hearing_date)).'</td>');
											$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($data3->description).'</td>');											
										$mpdf->WriteHTML(' </tr>');
									
										$id=$id+1;
									}	
											
									$mpdf->WriteHTML('</tbody>');
								$mpdf->WriteHTML('</table>');
							}								
								
							$obj_case_task= new MJ_lawmgt_case_tast;							
							$user_ids= sanitize_text_field($contact_user_id->user_id);
							$result_task=$obj_case_task->MJ_lawmgt_get_tast_by_caseid_and_client($case_id,$user_ids);
							if(!empty($result_task))
							{	
									$mpdf->WriteHTML('<table class="width_100_print">');	
										$mpdf->WriteHTML('<tbody>');	
											$mpdf->WriteHTML('<tr>');
												$mpdf->WriteHTML('<td class="padding_left_20_px_css">');
													$mpdf->WriteHTML('<h3 class="entry_lable font_family">'.esc_html__('Tasks ','lawyer_mgt').'</h3>');
												$mpdf->WriteHTML('</td>');	
											$mpdf->WriteHTML('</tr>');	
										$mpdf->WriteHTML('</tbody>');
									$mpdf->WriteHTML('</table>');				
							
								
								$mpdf->WriteHTML('<table class="table table-bordered table_row_color" class="width_93" border="1">');
									$mpdf->WriteHTML('<thead>');
															
											$mpdf->WriteHTML('<tr>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center padding_10_pdf">#</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('TASK NAME ','lawyer_mgt').'</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('DUE DATE ','lawyer_mgt').'</th>');						
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('STATUS ','lawyer_mgt').'</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('PRIORITY ','lawyer_mgt').'</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center amount_padding_8 font_family padding_10_pdf">'.esc_html__('Description ','lawyer_mgt').'</th>');		
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center amount_padding_8 font_family padding_10_pdf">'.esc_html__('ASSIGNED CLIENT','lawyer_mgt').'</th>');															
											$mpdf->WriteHTML('</tr>');						
										
									$mpdf->WriteHTML('</thead>');
									$mpdf->WriteHTML('<tbody>');
									
									$id=1;
																				
										foreach($result_task as $data4)
										{	
											$user_id= sanitize_text_field($data4->assigned_to_user);
											$con_id= sanitize_text_field($data4->assign_to_contact);
											$contac_id=explode(',',$user_id);
											$contac_id1=explode(',',$con_id);
											$user_name=array();
											foreach($contac_id as $contact_name) 
											{
												$userdata=get_userdata($contact_name);	
													
												$user_name[]=$userdata->display_name;										   
											}
												
											if($data4->status==0){
											 $statu='Not Completed';
											 }else if($data4->status==1){
											 $statu='Completed';
											 }else{
											 $statu='In Progress';
											 }
											 if($data4->priority==0){
											 $prio='High';
											 }else if($data4->priority==1){
											 $prio='Low';
											 }else{
											 $prio='Medium';
											 }				 
											$bg_color = $id % 2 === 0 ? "#cad5f5" : "white";
											if($bg_color == 'white')
											{
												$bg_color_css='pdf_background_color_td_css_white';
											}
											else
											{
												$bg_color_css='pdf_background_color_td_css_blue';
											}	
											$mpdf->WriteHTML('<tr class="entry_list '.$bg_color_css.'">');
												$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($id).'</td>');
												$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($data4->task_name).'</td>');
												$mpdf->WriteHTML('<td class="table_td_font align_center padding_10_pdf">'.esc_html(MJ_lawmgt_getdate_in_input_box($data4->due_date)).'</td>');
												$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($statu).'</td>');
												$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($prio).'</td>');
												$mpdf->WriteHTML('<td class="align_center amount_padding_8 table_td_font padding_10_pdf">'.esc_html($data4->description).'</td>');	
												$mpdf->WriteHTML('<td class="align_right amount_padding_8 table_td_font padding_10_pdf">'.esc_html(implode($user_name,',')).'</td>');								
											$mpdf->WriteHTML(' </tr>');
										
											$id=$id+1;
										}	
																	
									}						
									
									$mpdf->WriteHTML('</tbody>');
								$mpdf->WriteHTML('</table>');
								
								$event=new MJ_lawmgt_Event;								
								$result_event=$event->MJ_lawmgt_get_event_by_caseid_and_client($case_id,$user_ids);
								if(!empty($result_event))
								{	
									$mpdf->WriteHTML('<table class="width_100_print">');	
										$mpdf->WriteHTML('<tbody>');	
											$mpdf->WriteHTML('<tr>');
												$mpdf->WriteHTML('<td class="padding_left_20_px_css">');
													$mpdf->WriteHTML('<h3 class="entry_lable font_family">'.esc_html__('Events ','lawyer_mgt').'</h3>');
												$mpdf->WriteHTML('</td>');	
											$mpdf->WriteHTML('</tr>');	
										$mpdf->WriteHTML('</tbody>');
									$mpdf->WriteHTML('</table>');				
							
								
								$mpdf->WriteHTML('<table class="table table-bordered table_row_color" class="width_93" border="1">');
									$mpdf->WriteHTML('<thead>');
															
											$mpdf->WriteHTML('<tr>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center padding_10_pdf">#</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('EVENT NAME ','lawyer_mgt').'</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('CLIENT NAME ','lawyer_mgt').'</th>');						
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('DATE/TIME ','lawyer_mgt').'</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('ADDRESS ','lawyer_mgt').'</th>');
																					
											$mpdf->WriteHTML('</tr>');						
										
									$mpdf->WriteHTML('</thead>');
									$mpdf->WriteHTML('<tbody>');
									
									$id=1;
																				
										foreach($result_event as $data5)
										{	
											$user_id= sanitize_text_field($data5->assigned_to_user);
											$contac_id=explode(',',$user_id);
											$conatc_name=array();
											foreach($contac_id as $contact_name)
											{	
												$userdata=get_userdata($contact_name);
												$conatc_name[]=$userdata->display_name;										   
											}		 
											$bg_color = $id % 2 === 0 ? "#cad5f5" : "white";
											if($bg_color == 'white')
											{
												$bg_color_css='pdf_background_color_td_css_white';
											}
											else
											{
												$bg_color_css='pdf_background_color_td_css_blue';
											}	
											$mpdf->WriteHTML('<tr class="entry_list '.$bg_color_css.'">');
												$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($id).'</td>');
												$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($data5->event_name).'</td>');
												$mpdf->WriteHTML('<td class="table_td_font align_center padding_10_pdf">'.esc_html(implode(',',$conatc_name)).'</td>');
												$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html(MJ_lawmgt_getdate_in_input_box($data5->start_date)).' '.esc_html($data5->start_time).'</td>');
												$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($data5->address).'</td>');
																				
											$mpdf->WriteHTML(' </tr>');
										
											$id=$id+1;
										}	
																	
									}						
									
									$mpdf->WriteHTML('</tbody>');
								$mpdf->WriteHTML('</table>');

								$obj_invoice=new MJ_lawmgt_invoice;								
								$result_invoice=$obj_invoice->MJ_lawmgt_get_all_invoice_by_caseid_client($case_id,$user_ids);
								if(!empty($result_invoice))
								{	
									$mpdf->WriteHTML('<table class="width_100_print">');	
										$mpdf->WriteHTML('<tbody>');	
											$mpdf->WriteHTML('<tr>');
												$mpdf->WriteHTML('<td class="padding_left_20_px_css">');
													$mpdf->WriteHTML('<h3 class="entry_lable font_family">'.esc_html__('INVOICES ','lawyer_mgt').'</h3>');
												$mpdf->WriteHTML('</td>');	
											$mpdf->WriteHTML('</tr>');	
										$mpdf->WriteHTML('</tbody>');
									$mpdf->WriteHTML('</table>');	
								
								$mpdf->WriteHTML('<table class="table table-bordered table_row_color" class="width_93" border="1">');
									$mpdf->WriteHTML('<thead>');
															
											$mpdf->WriteHTML('<tr>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center padding_10_pdf">#</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('INVOICE NUMBER ','lawyer_mgt').'</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('DATE ','lawyer_mgt').'</th>');						
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('DUE DATE ','lawyer_mgt').'</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('BILLING CLIENT NAME ','lawyer_mgt').'</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('TOTAL AMOUNT ','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('PAID AMOUNT ','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');
												$mpdf->WriteHTML('<th class="color_white entry_heading align_center font_family padding_10_pdf">'.esc_html__('DUE AMOUNT ','lawyer_mgt').'('.MJ_lawmgt_get_currency_symbol().')</th>');	
											$mpdf->WriteHTML('</tr>');						
										
									$mpdf->WriteHTML('</thead>');
									$mpdf->WriteHTML('<tbody>');
									
									$id=1;
																				
										foreach($result_invoice as $data6)
										{	
											$user_id= sanitize_text_field($data6->user_id);
											$userdata=get_userdata($user_id);
											$conatc_name= $userdata->display_name;
														
											$bg_color = $id % 2 === 0 ? "#cad5f5" : "white";
											if($bg_color == 'white')
											{
												$bg_color_css='pdf_background_color_td_css_white';
											}
											else
											{
												$bg_color_css='pdf_background_color_td_css_blue';
											}	
											$mpdf->WriteHTML('<tr class="entry_list '.$bg_color_css.'">');
												$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($id).'</td>');
												$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html($data6->invoice_number).'</td>');
												$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html(MJ_lawmgt_getdate_in_input_box($data6->generated_date)).'</td>');
												$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.esc_html(MJ_lawmgt_getdate_in_input_box($data6->due_date)).'</td>');
												
												$mpdf->WriteHTML('<td class="table_td_font align_center padding_10_pdf">'.esc_html($conatc_name).'</td>');
												
												$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.number_format(esc_html($data6->total_amount),2).'</td>');						
												$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.number_format(esc_html($data6->paid_amount),2).'</td>');
												$mpdf->WriteHTML('<td class="align_center table_td_font padding_10_pdf">'.number_format(esc_html($data6->due_amount),2).'</td>');
											$mpdf->WriteHTML(' </tr>');
										
											$id=$id+1;
										}	
																	
									}						
									
									$mpdf->WriteHTML('</tbody>');
								$mpdf->WriteHTML('</table>');								
								
								$mpdf->WriteHTML('</div>');
							$mpdf->WriteHTML('</div>');  
			$mpdf->WriteHTML("</body>");
			$mpdf->WriteHTML("</html>");

			$mpdf->Output($document_path.''.$case_id.'.pdf','F');
			
			unset($mpdf);				
		
			$system_name=get_option('lmgt_system_name');
			$user_info1 = get_userdata($contact_user_id->user_id);
			
			$arr['{{Lawyer System Name}}']= sanitize_text_field($system_name);							
			$arr['{{User Name}}']=sanitize_text_field($user_info1->display_name);			
			$arr['{{Case Name}}']= sanitize_text_field($case_data->case_name);			
			$arr['{{Case Number}}']= sanitize_text_field($case_data->case_number);
			
			$emails=$user_info1->user_email;	
			$subject =get_option('lmgt_weekly_case_report_email_subject');
			$subject_replacement = MJ_lawmgt_string_replacemnet($arr,$subject);
			$message = get_option('lmgt_weekly_case_report_email_template');	
			$message_replacement = MJ_lawmgt_string_replacemnet($arr,$message);
			
			$headers="";
			$headers = "From: ".$system_name.' <noreplay@gmail.com>' . "\r\n";	
			
			$mail_attachment = array($document_path.''.$case_id.'.pdf'); 
			
			wp_mail($emails,$subject_replacement,$message_replacement,$headers,$mail_attachment); 	
			
			unlink($document_path.''.$case_id.'.pdf'); 	
		}									
	} 		
	$send=1;	
	return $send;
}
//----DUE DATE WISE TASK FILTER -----------//
function MJ_lawmgt_task_duedate_by_filter()
{		
 	$user_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('task');
	$starting_date = date('Y-m-d',strtotime(sanitize_text_field($_REQUEST['start_date'])));
	$ending_date  = date('Y-m-d',strtotime(sanitize_text_field($_REQUEST['end_date'])));
	 
	$user_role=MJ_lawmgt_get_current_user_role();
	 
	$obj_task=new MJ_lawmgt_case_tast;
 
	if($user_role == 'attorney')
	{
		if($user_access['own_data'] == '1')
		{
			$task_data=$obj_task->MJ_lawmgt_get_task_by_attorney_duedate_wise($starting_date,$ending_date);
		}
		else
		{
			$task_data=$obj_task->MJ_lawmgt_get_all_task_duedate_wise($starting_date,$ending_date);
		}	
	}
	elseif($user_role == 'client')
	{	
		if($user_access['own_data'] == '1')
		{
			$task_data=$obj_task->MJ_lawmgt_get_task_by_client_duedate_wise($starting_date,$ending_date);
		}
		else
		{
			$task_data=$obj_task->MJ_lawmgt_get_all_task_duedate_wise($starting_date,$ending_date);
		}
	}
	else
	{
		if($user_access['own_data'] == '1')
		{
			$task_data=$obj_task->MJ_lawmgt_get_all_task_duedate_wise_created_by($starting_date,$ending_date);
		}
		else
		{	
			$task_data=$obj_task->MJ_lawmgt_get_all_task_duedate_wise($starting_date,$ending_date);
		}
	}	
 
	$task_filter_data = array();	
	 
	if(!empty($task_data))
	{
		foreach($task_data as $retrieved_data)
		{
			
			$case_name=MJ_lawmgt_get_case_name_by_id($retrieved_data->case_id);
			foreach($case_name as $case_name1)
			{
				$case_name2= sanitize_text_field($case_name1->case_name);
			}
			 
			if($retrieved_data->status==0)
			{
				$status='Not Completed';
			}
			else if($retrieved_data->status==1)
			{
				$status='Completed';
			}
			else
			{
				$status='In Progress';
			}
			 
			if($retrieved_data->priority==0)
			{
				$priority='High';
			}
			else if($retrieved_data->priority==1)
			{
				$priority='Low';
			}
			else
			{
				$priority='Medium';
			}
			
			$user_id=sanitize_text_field($retrieved_data->assigned_to_user);
			 
			$contac_id=explode(',',$user_id);
			 
			$user_name=array();
			foreach($contac_id as $contact_name) 
			{
				$userdata=get_userdata($contact_name);	
				if (is_super_admin ())
				{	
					$user_name[]=$userdata->display_name;
				}
				else
				{
					$user_name[]=$userdata->display_name;
				}
			} 
			$attorney=$retrieved_data->assign_to_attorney;
			$attorney_name=explode(',',$attorney);
			$attorney_name1=array();
				
			foreach($attorney_name as $attorney_name2) 
			{
				$attorneydata=get_userdata($attorney_name2);	
				if (is_super_admin ())
				{	
					$attorney_name1[]=$attorneydata->display_name;
				}
				else
				{
					$attorney_name1[]=$attorneydata->display_name;
				}
			} 
			
			$document_row ='<tr>';
				$document_row.='<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="'.esc_attr($retrieved_data->task_id).'"></td>
				<td class="case_link">';
				if (is_super_admin ())
				{
					$document_row.='<a href="?page=task&tab=view_task&action=view_task&task_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->task_id)).'">'.esc_html($retrieved_data->task_name).'</a>';
				}
				else
				{
					$document_row.='<a href="?dashboard=user&page=task&tab=view_task&action=view_task&task_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->task_id)).'">'.esc_html($retrieved_data->task_name).'</a>';
				}		
				$document_row.='</td>
				
				<td class="case_link">';
				if (is_super_admin ())
				{
					$document_row.='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->case_id)).'">'.esc_html($case_name2).'</a>';
				}
				else
				{
					$document_row.='<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->case_id)).'">'.esc_html($case_name2).'</a>';
				}	
				
				$document_row.='</td>
				
				<td class="tags_name">'.esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->due_date)).'</td>
				
				<td class="tags_name">'.esc_html($status).'</td>
				
				<td class="tags_name">'.esc_html($priority).'</td>
				
				<td class="tags_name">'.esc_html(implode($user_name,',')).'</td>
				
				<td class="tags_name">'.esc_html(implode($attorney_name1,',')).'</td>
			 
				<td class="action">';				
				 
					if (is_super_admin ())
					{						 
						$document_row .='<a href="admin.php?page=task&tab=view_task&action=view_task&task_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->task_id)).'" class="btn btn-success">'.esc_html__('View','lawyer_mgt').'</a>
						
						<a href="?page=task&tab=add_task&action=edittask&task_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->task_id)).'" 	class="btn btn-info">'.esc_html__('Edit','lawyer_mgt').'</a>
						<a href="?page=task&tab=tasklist&action=deletetask&case_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->case_id)).'&task_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->task_id)).'" class="btn btn-danger" 
						onclick="return confirm(Are you sure you want to delete this record?);">
						'.esc_html__('Delete','lawyer_mgt').'</a>';
					}
					else
					{
						$document_row .='<a href="?dashboard=user&page=task&tab=view_task&action=view_task&task_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->task_id)).'" class="btn btn-success">'.esc_html__('View','lawyer_mgt').'</a>';
						 
						if($user_access['edit']=='1')
						{
							$document_row .='<a href="?dashboard=user&page=task&tab=add_task&action=edittask&task_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->task_id)).'" class="btn btn-info">'.esc_html__('Edit','lawyer_mgt').'</a>';
						}
						if($user_access['delete']=='1')
						{
							$document_row .='<a href="?dashboard=user&page=task&tab=tasklist&action=deletetask&case_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->case_id)).'&task_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->task_id)).'" class="btn btn-danger" onclick="return confirm(Are you sure you want to delete this record?);">
							'.esc_html__('Delete','lawyer_mgt').'</a>';
						}
					}	
				$document_row .='</td>';       
			'</tr>';			
			$task_filter_data[]=$document_row;					
		} 
	}	
	echo json_encode($task_filter_data);
	die();  
}
//---- COURT WISE FILTER -----------//
function MJ_lawmgt_court_wise_filter()
{		
 	$court_id= sanitize_text_field($_REQUEST['court_id']);
	 
	$user_role=MJ_lawmgt_get_current_user_role();
	 
	$obj_cause=new Lmgtcauselist;
	if($court_id == 'all')
	{
		if($user_role == 'attorney')
		{
			$cause_data=$obj_cause->MJ_lawmgt_get_current_date_causelist_by_attorney();
		}
		elseif($user_role == 'client')
		{	
			$cause_data=$obj_cause->MJ_lawmgt_get_current_date_causelist_by_client();
		}
		else
		{
			$cause_data=$obj_cause->MJ_lawmgt_get_current_date_causelist();
		}	
	}
	else
	{
			
		if($user_role == 'attorney')
		{
			$cause_data=$obj_cause->MJ_lawmgt_get_causelist_by_attorney_wise_court_filter($court_id);
		}
		elseif($user_role == 'client')
		{	
			$cause_data=$obj_cause->MJ_lawmgt_get_causelist_by_client_wise_court_filter($court_id);
		}
		else
		{
			$cause_data=$obj_cause->MJ_lawmgt_get_all_causelist_court_filter($court_id);
		}	
	}
	$cause_filter_data = array();	
	 
	if(!empty($cause_data))
	{
		foreach($cause_data as $retrieved_data)
		{
			$case_name=MJ_lawmgt_get_case_name_by_id($retrieved_data->id);
			foreach($case_name as $case_name1)
			{
				$case_name2=$case_name1->case_name;
			}
			 
			
			$user=explode(",",$retrieved_data->case_assgined_to);
			$attorney_name=array();
			if(!empty($user))
			{						
				foreach($user as $data4)
				{
					$attorney_name[]=MJ_lawmgt_get_display_name($data4);
				}
			}	
			$court_name=get_the_title($retrieved_data->court_id);
			$state_name=get_the_title($retrieved_data->state_id);
			$bench_name=get_the_title($retrieved_data->bench_id);
			
			$document_row ='<tr>
				<td class="case_link">';
				if (is_super_admin ())
				{
					$document_row.='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'">'.esc_html($case_name2).'</a>';
				}
				else
				{
					$document_row.='<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'">'.esc_html($case_name2).'</a>';
				}		
				$document_row.='</td>
				
				<td class="case_link">';
				if (is_super_admin ())
				{
					$document_row.=''.esc_html(implode(", ",$attorney_name)).'';
				}
				else
				{
					$document_row.=''.esc_html(implode(", ",$attorney_name)).'';
				}	
				
				$document_row.='</td>
				
				<td class="tags_name">'.esc_html($court_name).'</td>
				
				<td class="tags_name">'.esc_html($state_name).'</td>
				
				<td class="tags_name">'.esc_html($bench_name).'</td>
			</tr>';			
			$cause_filter_data[]=$document_row;					
		} 
	}	
	echo json_encode($cause_filter_data);
	die();  
}
//----NEXT HEARING DATE WISE  FILTER IN CASE DAIRY-----------//
function MJ_lawmgt_case_diary_filter_by_next_hearing_date()
{		
 	
	$starting_date = date('Y-m-d',strtotime(sanitize_text_field($_REQUEST['start_date'])));
	$ending_date  = date('Y-m-d',strtotime(sanitize_text_field($_REQUEST['end_date'])));
	 
	$obj_case=new MJ_lawmgt_case;
  
	$casedata_diary=$obj_case->MJ_lawmgt_get_case_diary_data_next_hearing_date_wise($starting_date,$ending_date);
	
	$case_diary_filter_data = array();	
	 
	if(!empty($casedata_diary))
	{
		foreach($casedata_diary as $retrieved_data)
		{
			$case_id=$retrieved_data->id;
			$caselink_contact=array();
			global $wpdb;
			$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';

			$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
			foreach ($result_link_contact as $key => $object)
			{			
				 $result=get_userdata($object->user_id);
				 $caselink_contact[]=$result->display_name ;
									
			}	
			$obj_next_hearing_date=new MJ_lawmgt_Orders;
			$next_hearing_date= $obj_next_hearing_date->MJ_lawmgt_get_next_hearing_date_asc_by_case_id($case_id);
			$hearing_date_array=array();
			foreach($next_hearing_date as $data)
			{
				$hearing_date_array[]=MJ_lawmgt_getdate_in_input_box($data->next_hearing_date);
			}
			$contact=implode(',',$caselink_contact); 
			$user=explode(",",$retrieved_data->case_assgined_to);
			$case_assgined_to=array();
			if(!empty($user))
			{						
				foreach($user as $data4)
				{
					$case_assgined_to[]=MJ_lawmgt_get_display_name($data4);
				}
			}
			
			$document_row ='<tr>';
				$document_row.='<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="'.esc_attr($retrieved_data->id).'"></td>
				<td class="tags_name">'.esc_html($retrieved_data->case_number).'</td>
				<td class="case_link">';
				$document_row.='<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr(MJ_lawmgt_id_encrypt($retrieved_data->id)).'">'.esc_html($retrieved_data->case_name).'</a>';
				 	
				$document_row.='</td>
				 
				<td class="tags_name">'.esc_html(get_the_title($retrieved_data->practice_area_id)).'</td>
				
				<td class="tags_name">'.esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->open_date)).'</td>
				
				<td class="tags_name">'.$contact.'</td>
				
				<td class="case_link">';
				 
				$document_row.=esc_html(MJ_lawmgt_get_display_name($retrieved_data->billing_contact_id));
				 	
				$document_row.='</td>
				
				<td class="case_link">';
				 
				$document_row.=''.esc_html(implode(", ",$case_assgined_to)).'';
				 	
				$document_row.='</td>';
				
				$document_row.='<td class="title">'.esc_html(get_the_title($retrieved_data->court_id)).' - '.esc_html(get_the_title($retrieved_data->state_id)).' - '.esc_html(get_the_title($retrieved_data->bench_id)).'</td>';
				
				$document_row.='<td class="title">'.implode(',</br>',$hearing_date_array).'</td>
				<td class="case_link">';
				if(!empty($retrieved_data->stages))
				{
					$stages=json_decode($retrieved_data->stages);
				}
				$increment = 0;
				foreach($stages as $data)
				{ 
					$increment++;
					$document_row.='<span class="">'.esc_html($increment).'.'.esc_html($data->value).'</span></br>';
				} 
				$document_row.='</td>';
			'</tr>';			
			$case_diary_filter_data[]=$document_row;					
		} 
	}	
	echo json_encode($case_diary_filter_data);
	die();  
}

//-------DATA TABLE MULTILANGUAGE-----------
function wpnc_datatable_multi_language()
{
	$datatable_attr=array("sEmptyTable"=> esc_html__("No data available in table","lawyer_mgt"),
	"sInfo"=> esc_html__("Showing _START_ to _END_ of _TOTAL_ entries","lawyer_mgt"),
	"sInfoEmpty"=>esc_html__("Showing 0 to 0 of 0 entries","lawyer_mgt"),
	"sInfoFiltered"=>esc_html__("(filtered from _MAX_ total entries)","lawyer_mgt"),
	"sInfoPostFix"=> "",
	"sInfoThousands"=>",",
	"sLengthMenu"=>esc_html__("Show _MENU_ entries","lawyer_mgt"),
	"sLoadingRecords"=>esc_html__("Loading...","lawyer_mgt"),
	"sProcessing"=>esc_html__("Processing...","lawyer_mgt"),
	"sSearch"=>esc_html__("Search: ","lawyer_mgt"),
	"sZeroRecords"=>esc_html__("No matching records found","lawyer_mgt"),
	"oPaginate"=>array(
	"sFirst"=>esc_html__("First","lawyer_mgt"),
	"sLast"=>esc_html__("Last","lawyer_mgt"),
	"sNext"=>esc_html__("Next","lawyer_mgt"),
	"sPrevious"=>esc_html__("Previous","lawyer_mgt")
	),
	"oAria"=>array(
	"sSortAscending"=>esc_html__(": activate to sort column ascending","lawyer_mgt"),
	"sSortDescending"=>esc_html__(": activate to sort column descending","lawyer_mgt")
	)
	);

	return $data=json_encode( $datatable_attr);
}

//strip tags and slashes
function MJ_lawmgt_strip_tags_and_stripslashes($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);	
    $string = htmlspecialchars_decode($string);
    $replace_string = strip_tags($string);
	return $replace_string;
}	
function MJ_lawmgt_password_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replace_string = strip_tags($string);
	return $replace_string;
}
function MJ_lawmgt_tax_value_by_id($id)
{
	global $wpdb;
	$table_taxes=$wpdb->prefix .'lmgt_taxes';
	$result = $wpdb->get_row("SELECT tax_value FROM $table_taxes where tax_id=".$id);
	return $result;
	
}
function MJ_lawmgt_get_tax_name($id)
{
	global $wpdb;			
	$table_taxes=$wpdb->prefix .'lmgt_taxes';	
	$result = $wpdb->get_row("SELECT tax_title FROM $table_taxes where tax_id=".$id);	
	 
	return $result->tax_title;
}
function MJ_lawmgt_browser_javascript_check()
{
	$plugins_url = plugins_url( 'lawyers-management/ShowErrorPage.php' );
	?>
	<noscript><meta http-equiv="refresh" content="0;URL=<?php echo esc_url($plugins_url); ?>"></noscript> 
	<?php
} 
//access right page not access message
function MJ_lawmgt_access_right_page_not_access_message()
{
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($)
		{	
			 "use strict";	
			alert('<?php esc_html_e('You do not have permission to perform this operation.','lawyer_mgt'); ?>');
			window.location.href='?dashboard=user';
		});
	</script>
<?php
}	
//user role wise access right array
function MJ_lawmgt_get_userrole_wise_access_right_array()
{
	$role=MJ_lawmgt_get_current_user_role();
	
	if($role=='attorney')
	{
		$menu = get_option( 'lmgt_access_right_attorney');
	}
	elseif($role=='staff_member')
	{
		$menu = get_option( 'lmgt_access_right_staff');
	}
	elseif($role=='client')
	{
		$menu = get_option( 'lmgt_access_right_contacts');
	}
	elseif($role=='accountant')
	{
		$menu = get_option( 'lmgt_access_right_accountant');
	}
		
	foreach ( $menu as $key1=>$value1 ) 
	{									
		foreach ( $value1 as $key=>$value ) 
		{				
			if ($_REQUEST ['page'] == $value['page_link'])
			{				
				return $value;
			}
		}
	}	
}
//user role wise access right array In Filter Data
function MJ_lawmgt_get_userrole_wise_filter_access_right_array($page_name)
{
	$role=MJ_lawmgt_get_current_user_role();
	
	if($role=='attorney')
	{
		$menu = get_option( 'lmgt_access_right_attorney');
	}
	elseif($role=='staff_member')
	{
		$menu = get_option( 'lmgt_access_right_staff');
	}
	elseif($role=='client')
	{
		$menu = get_option( 'lmgt_access_right_contacts');
	}
	elseif($role=='accountant')
	{
		$menu = get_option( 'lmgt_access_right_accountant');
	}
		
	foreach ( $menu as $key1=>$value1 ) 
	{									
		foreach ( $value1 as $key=>$value ) 
		{				
			if ($page_name == $value['page_link'])
			{				
				return $value;
			}
		}
	}	
}
//dashboard page access right //
function MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page)
{
	$role=MJ_lawmgt_get_current_user_role();
	
	if($role=='attorney')
	{
		$menu = get_option( 'lmgt_access_right_attorney');
	}
	elseif($role=='staff_member')
	{
		$menu = get_option( 'lmgt_access_right_staff');
	}
	elseif($role=='client')
	{
		$menu = get_option( 'lmgt_access_right_contacts');
	}
	elseif($role=='accountant')
	{
		$menu = get_option( 'lmgt_access_right_accountant');
	}
	
	foreach ( $menu as $key1=>$value1 ) 
	{									
		foreach ( $value1 as $key=>$value ) 
		{	
			if ($page == $value['page_link'])
			{				
				if($value['view']=='0')
				{			
					$flage=0;
				}
				else
				{
				  $flage=1;
				}
			}
		}
	}	
	
	return $flage;
}
//dashboard fronted own data access right //
function MJ_lawmgt_page_wise_view_data_on_fronted_dashboard($page)
{
	$role=MJ_lawmgt_get_current_user_role();
	
	if($role=='attorney')
	{
		$menu = get_option( 'lmgt_access_right_attorney');
	}
	elseif($role=='staff_member')
	{
		$menu = get_option( 'lmgt_access_right_staff');
	}
	elseif($role=='client')
	{
		$menu = get_option( 'lmgt_access_right_contacts');
	}
	elseif($role=='accountant')
	{
		$menu = get_option( 'lmgt_access_right_accountant');
	}
	
	foreach ( $menu as $key1=>$value1 ) 
	{									
		foreach ( $value1 as $key=>$value ) 
		{	
			if ($page == $value['page_link'])
			{				
				if($value['own_data']=='0')
				{			
					$flage=0;
				}
				else
				{
				  $flage=1;
				}
			}
		}
	}	
	
	return $flage;
}
//----------- LOCAL TIME -----------//
function MJ_lawmgt_wpnc_convert_time($time)
{
	$timestamp = strtotime( $time ); // Converting time to Unix timestamp
	$offset = get_option( 'gmt_offset' ) * 60 * 60; // Time offset in seconds
	$local_timestamp = $timestamp + $offset;
	$local_time = date_i18n('Y-m-d H:i:s', $local_timestamp );
	return $local_time;
}
function  MJ_lawmgt_logs_file()
{
//define( 'LAWMS_LOG_DIR',  wp_upload_dir().'/Lawyer_logs');
define( 'LAWMS_LOG_DIR',  WP_CONTENT_DIR.'/uploads/Lawyer_logs/');
//added new log file //
define( 'LAWMS_LOG_file_Downlaod', LAWMS_LOG_DIR.'/LAWMS_logs.txt',__FILE__ );
define( 'LAWMS_Case_LOG_file_download', LAWMS_LOG_DIR.'/LAWMS_caselogs.txt',__FILE__ );
define( 'LAWMS_Event_LOG_file_download', LAWMS_LOG_DIR.'/LAWMS_eventlogs.txt',__FILE__ );
//define( 'LAWMS_next_hearing_date_LOG_file_download', LAWMS_LOG_DIR.'/LAWMS_next_hearing_datelogs.txt' );
define( 'LAWMS_Note_LOG_file_download', LAWMS_LOG_DIR.'/LAWMS_notelogs.txt',__FILE__ );
define( 'LAWMS_Task_LOG_file_download', LAWMS_LOG_DIR.'/LAWMS_tasklogs.txt',__FILE__ );
define( 'LAWMS_Invoice_LOG_file_download', LAWMS_LOG_DIR.'/LAWMS_invoicelogs.txt',__FILE__ );
define( 'LAWMS_Workflow_LOG_file_download', LAWMS_LOG_DIR.'/LAWMS_workflowlogs.txt',__FILE__ );
define( 'LAWMS_Document_LOG_file_download', LAWMS_LOG_DIR.'/LAWMS_documentlogs.txt',__FILE__ );
define( 'LAWMS_Judgment_LOG_file_download', LAWMS_LOG_DIR.'/LAWMS_judgmentlogs.txt',__FILE__ );
define( 'LAWMS_Order_LOG_file_download', LAWMS_LOG_DIR.'/LAWMS_orders.txt',__FILE__ );
 // end new log file  //
  
define( 'LAWMS_LOG_file', LAWMS_LOG_DIR.'/LAWMS_log.txt',__FILE__ );
define( 'LAWMS_Case_LOG_file', LAWMS_LOG_DIR.'/LAWMS_caselog.txt',__FILE__ );
define( 'LAWMS_Event_LOG_file', LAWMS_LOG_DIR.'/LAWMS_eventlog.txt',__FILE__ );
define( 'LAWMS_Note_LOG_file', LAWMS_LOG_DIR.'/LAWMS_notelog.txt',__FILE__ );
define( 'LAWMS_Task_LOG_file', LAWMS_LOG_DIR.'/LAWMS_tasklog.txt',__FILE__ );
define( 'LAWMS_Invoice_LOG_file', LAWMS_LOG_DIR.'/LAWMS_invoicelog.txt',__FILE__ );
define( 'LAWMS_Workflow_LOG_file', LAWMS_LOG_DIR.'/LAWMS_workflowlog.txt',__FILE__ );
define( 'LAWMS_Document_LOG_file', LAWMS_LOG_DIR.'/LAWMS_documentlog.txt',__FILE__ );
define( 'LAWMS_Judgment_LOG_file', LAWMS_LOG_DIR.'/LAWMS_judgmentlog.txt',__FILE__ );
define( 'LAWMS_Order_LOG_file', LAWMS_LOG_DIR.'/LAWMS_order.txt',__FILE__ );

define( 'LAWMS_Court_LOG_file', LAWMS_LOG_DIR.'/LAWMS_courtlog.txt',__FILE__ );
define( 'LAWMS_next_hearing_date_LOG_file', LAWMS_LOG_DIR.'/LAWMS_next_hearing_datelog.txt',__FILE__ );

//--------- LOG BACKUP ----------------//
//define( 'LAWMS_LOG_DIR_backup',  wp_upload_dir().'/Lawyer_logs_backup');
define( 'LAWMS_LOG_DIR_backup',  WP_CONTENT_DIR.'/uploads/Lawyer_logs_backup/');
define( 'LAWMS_LOG_file_backup', LAWMS_LOG_DIR_backup.'/LAWMS_log_backup.txt',__FILE__ );
define( 'LAWMS_Case_LOG_file_backup', LAWMS_LOG_DIR_backup.'/LAWMS_caselog_backup.txt',__FILE__ );
define( 'LAWMS_Event_LOG_file_backup', LAWMS_LOG_DIR_backup.'/LAWMS_eventlog_backup.txt',__FILE__ );
define( 'LAWMS_Court_LOG_file_backup', LAWMS_LOG_DIR_backup.'/LAWMS_courtlog_backup.txt',__FILE__ );
define( 'LAWMS_next_hearing_date_LOG_file_backup', LAWMS_LOG_DIR_backup.'/LAWMS_next_hearing_datelog_backup.txt',__FILE__ );
define( 'LAWMS_Note_LOG_file_backup', LAWMS_LOG_DIR_backup.'/LAWMS_notelog_backup.txt',__FILE__ );
define( 'LAWMS_Task_LOG_file_backup', LAWMS_LOG_DIR_backup.'/LAWMS_tasklog_backup.txt',__FILE__ );
define( 'LAWMS_Invoice_LOG_file_backup', LAWMS_LOG_DIR_backup.'/LAWMS_invoicelog_backup.txt',__FILE__ );
define( 'LAWMS_Workflow_LOG_file_backup', LAWMS_LOG_DIR_backup.'/LAWMS_workflowlog_backup.txt',__FILE__ );
define( 'LAWMS_Document_LOG_file_backup', LAWMS_LOG_DIR_backup.'/LAWMS_documentlog_backup.txt',__FILE__ );
define( 'LAWMS_Judgment_LOG_file_backup', LAWMS_LOG_DIR_backup.'/LAWMS_judgmentlog_backup.txt',__FILE__ );
define( 'LAWMS_Order_LOG_file_backup', LAWMS_LOG_DIR_backup.'/LAWMS_order_backup.txt',__FILE__ );
//--------- LOG BACKUP END ----------------//
}
?>