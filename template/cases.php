<?php 
MJ_lawmgt_browser_javascript_check();
//access right
$user_access=MJ_lawmgt_get_userrole_wise_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		MJ_lawmgt_access_right_page_not_access_message();
		die;
	}
	if(!empty($_REQUEST['action']))
	{
		if (isset ( $_REQUEST ['page'] ) && sanitize_text_field($_REQUEST['page']) == $user_access['page_link'] && (sanitize_text_field($_REQUEST['action'])=='edit'))
		{
			if($user_access['edit']=='0')
			{	
				MJ_lawmgt_access_right_page_not_access_message();
				die;
			}			
		}
		if (isset ( $_REQUEST ['page'] ) && sanitize_text_field($_REQUEST ['page']) == $user_access['page_link'] && (sanitize_text_field($_REQUEST['action'])=='delete'))
		{
			if($user_access['delete']=='0')
			{	
				MJ_lawmgt_access_right_page_not_access_message();
				die;
			}	
		}
		if (isset ( $_REQUEST ['page'] ) && sanitize_text_field($_REQUEST ['page']) == $user_access['page_link'] && (sanitize_text_field($_REQUEST['action'])=='add'))
		{
			if($user_access['add']=='0')
			{	
				MJ_lawmgt_access_right_page_not_access_message();
				die;
			}	
		} 
	}
}

$obj_case=new MJ_lawmgt_case;
$obj_documents=new MJ_lawmgt_documents;
$obj_case_tast= new MJ_lawmgt_case_tast;
$obj_next_hearing_date= new MJ_lawmgt_Orders;
$custom_field = new MJ_lawmgt_custome_field;
$note=new MJ_lawmgt_Note;
$event=new MJ_lawmgt_Event;
$obj_invoice=new MJ_lawmgt_invoice;
$obj_caseworkflow=new MJ_lawmgt_caseworkflow;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'caselist');
$page_columns_array=explode(',',get_option( 'lmgt_case_columns_option' ));
$page_export_array=explode(',',get_option( 'lmgt_case_export_option' ));	
$document_columns_array=explode(',',get_option('lmgt_document_columns_option'));
$document_export_array=explode(',',get_option('document_export_option'));
$invoice_columns_array=explode(',',get_option('lmgt_invoice_columns_option'));
$result=null;
?>

<!--<div class="page_inner_front with_Aa"><!-- PAGE INNER DIV -->
<div ><!-- PAGE INNER DIV -->

<script type="text/javascript">
var $ = jQuery.noConflict();
</script>	
	<?php 
	if(isset($_POST['case_excle']))
	{	
		if($user_role == 'attorney')
		{
			if($user_access['own_data'] == '1')
			{
				$user_id = get_current_user_id();
				$casedata=$obj_case->MJ_lawmgt_get_all_case_by_attorney_id($user_id);	
			}
			else
			{
				$casedata=$obj_case->MJ_lawmgt_get_all_case();
			}													
		}
		elseif($user_role == 'client')
		{
			if($user_access['own_data'] == '1')
			{
				$casedata=$obj_case->MJ_lawmgt_get_open_and_close_case_by_client();	
			}
			else
			{
				$casedata=$obj_case->MJ_lawmgt_get_all_case();
			}	
		}							   
		else
		{	
			if($user_access['own_data'] == '1')
			{
				$casedata = $obj_case->MJ_lawmgt_get_all_case_created_by();
			}
			else
			{
				$casedata=$obj_case->MJ_lawmgt_get_all_case();
			}
		}			
		if(!empty($casedata))
		{
			$header = array();			
			if(in_array('case_name',$page_export_array)) 
				{  
					$header[] = esc_html__('Case Name','lawyer_mgt');
				}  
			if(in_array('case_number',$page_export_array)) 
				{  
					$header[] = esc_html__('Case Number','lawyer_mgt');
				}  
			  
			if(in_array('attorney_name',$page_export_array)) 
				{  
					$header[] = esc_html__('Case Assgined To','lawyer_mgt');
				}  
			if(in_array('open_date',$page_export_array))
				{  
					$header[] = esc_html__('Open Date','lawyer_mgt');
		        } 
			if(in_array('practice_area',$page_export_array))
				{  
					$header[] = esc_html__('Practice Area','lawyer_mgt');
				}  
			if(in_array('statute_of_limitation',$page_export_array))
				{  
					$header[] = esc_html__('Statute Of Limitations Date','lawyer_mgt');
				}  
			if(in_array('priority',$page_export_array)) 
				{  
					$header[] = esc_html__('Priority','lawyer_mgt');
				}  
			   
			if(in_array('court_details',$page_export_array)) 
				{  
					$header[] = esc_html__('Court Name','lawyer_mgt');
				}  
			if(in_array('court_hall_no',$page_export_array)) 
				{  
					$header[] = esc_html__('Court Hall No','lawyer_mgt');
				}  
			if(in_array('floor',$page_export_array)) 
				{  
					$header[] = esc_html__('Floor','lawyer_mgt');
				} 
			if(in_array('court_details',$page_export_array)) 
				{  
					$header[] = esc_html__('State Name','lawyer_mgt');
				}  
			if(in_array('court_details',$page_export_array)) 
				{ 
					$header[] = esc_html__('Bench Name','lawyer_mgt');
				}
			if(in_array('hearing_date',$page_export_array))
				{  
					$header[] = esc_html__('Hearing Date','lawyer_mgt');
				}
			if(in_array('crime_no',$page_export_array)) 
				{  
					$header[] = esc_html__('Crime No of Police Station','lawyer_mgt');
				}
			if(in_array('fir_no',$page_export_array))
				{  
					$header[] = esc_html__('FIR No','lawyer_mgt');
				}
			if(in_array('crime_no',$page_export_array)) 
				{  
					$header[] = esc_html__('Crime Details','lawyer_mgt');
				}
			if(in_array('earlier_court_history',$page_export_array)) 
				{  
					$header[] = esc_html__('Earlier Court History','lawyer_mgt');
				}
			if(in_array('classification',$page_export_array)) 
				{  
					$header[] = esc_html__('Classification','lawyer_mgt');
				}
			if(in_array('referred_by',$page_export_array)) 
				{  
					$header[] = esc_html__('Referred By','lawyer_mgt');
				}
			if(in_array('contact_link',$page_export_array)) 
				{  
					$header[] = esc_html__('Linked Client','lawyer_mgt');
				}
			if(in_array('billing_contact_name',$page_export_array))
				{  
					$header[] = esc_html__('Billing Client','lawyer_mgt');
				}
			if(in_array('opponent_details',$page_export_array))
				{  
					$header[] = esc_html__('Opponents Details','lawyer_mgt');
				}
			if(in_array('opponent_attorney_details',$page_export_array)) 
				{  
					$header[] = esc_html__('Opponents Attorney Details','lawyer_mgt');
				}
			
			$filename='Reports/export_case.xls';
			$fh = fopen(LAWMS_PLUGIN_DIR.'/admin/'.$filename, 'w') or die("can't open file");
			fputcsv($fh, $header, "\t");
			if(!empty($casedata))
			{
			foreach($casedata as $retrive_data)
			{
				$case_id=$retrive_data->id;
														
				$case_contact=array();
				global $wpdb;
				$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';

				$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
				if(!empty($result_link_contact))
				{
					foreach ($result_link_contact as $key => $object)
					{			
						 $result=get_userdata($object->user_id);
						 $case_contact[]=esc_html($result->display_name);
					}	
                }				
			    $link_contact=implode(',',$case_contact);
				
				$row = array();	
				$user=explode(",",$retrive_data->case_assgined_to);
				$case_assgined_to=array();
				if(!empty($user))
				{						
					foreach($user as $data4)
					{
						$case_assgined_to[]=esc_html(MJ_lawmgt_get_display_name($data4));
					}
				}					
	
				if(in_array('case_name',$page_export_array)) 
				{  
					$row[] =  esc_html($retrive_data->case_name);
				}
				if(in_array('case_number',$page_export_array)) 
				{ 
					$row[] =  esc_html($retrive_data->case_number);
				}  
				  
				if(in_array('attorney_name',$page_export_array)) 
				{
					$row[] =  esc_html(implode(", ",$case_assgined_to));
				}  
				if(in_array('open_date',$page_export_array))
				{ 
					$row[] =  esc_html($retrive_data->open_date);
				} 
				if(in_array('practice_area',$page_export_array))
				{ 
					$row[] =  esc_html(get_the_title($retrive_data->practice_area_id));
				}  
				if(in_array('statute_of_limitation',$page_export_array))
				{
					$row[] =  esc_html($retrive_data->statute_of_limitations);
				}  
				if(in_array('priority',$page_export_array)) 
				{ 
					$row[] =  esc_html($retrive_data->priority);
				}  
				if(in_array('court_details',$page_export_array)) 
				{  
					$row[] =  esc_html(get_the_title($retrive_data->court_id));
				}  
				if(in_array('court_hall_no',$page_export_array)) 
				{ 
					$row[] =  esc_html($retrive_data->court_hall_no);
				}  
				if(in_array('floor',$page_export_array)) 
				{ 
					$row[] =  esc_html($retrive_data->floor);
				} 
				if(in_array('court_details',$page_export_array)) 
				{ 
					$row[] =  esc_html(get_the_title($retrive_data->state_id));
				}  
				if(in_array('court_details',$page_export_array)) 
				{ 
					$row[] =  esc_html(get_the_title($retrive_data->bench_id));
				}
				if(in_array('hearing_date',$page_export_array))
				{  
					$obj_next_hearing_date=new MJ_lawmgt_Orders;
					$next_hearing_date= $obj_next_hearing_date->MJ_lawmgt_get_next_hearing_date_asc_by_case_id($case_id);
					if(!empty($next_hearing_date))
					{
						$hearing_dates=array();
						foreach($next_hearing_date as $data)
						{
							$hearing_dates[]=esc_html($data->next_hearing_date);
						}					
						$row[] =  esc_html(implode(',',$hearing_dates));
					}
					else
					{
						$row[] = '';
					}
				}
				if(in_array('crime_no',$page_export_array)) 
				{
					$row[] =  esc_html($retrive_data->crime_no);
				}
				if(in_array('fir_no',$page_export_array))
				{  
					$row[] =  esc_html($retrive_data->fri_no);
				}
				if(in_array('crime_no',$page_export_array)) 
				{
					$row[] =  esc_html($retrive_data->crime_details);
				}
				if(in_array('earlier_court_history',$page_export_array)) 
				{  
					$row[] =  esc_html($retrive_data->earlier_history);
				}
				if(in_array('classification',$page_export_array)) 
				{ 
					$row[] =  esc_html($retrive_data->classification);
				}
				if(in_array('referred_by',$page_export_array)) 
				{ 
					$row[] =  esc_html($retrive_data->referred_by);
				}
				if(in_array('contact_link',$page_export_array)) 
				{ 
					$row[] =  esc_html($link_contact);
				}
				if(in_array('billing_contact_name',$page_export_array))
				{ 
					$row[] =  esc_html(MJ_lawmgt_get_display_name($retrive_data->billing_contact_id));
				}
				$opponents_details_array=json_decode($retrive_data->opponents_details);
				$opponents_array=array();	
					
				if(!empty($opponents_details_array))
				{
					foreach ($opponents_details_array as $data)
					{	
						if($data->opponents_name != '' && $data->opponents_email != '' && $data->opponents_mobile_number != '') 
						{							
							$opponents_array[]=esc_html($data->opponents_name.'-'.$data->opponents_email.'- '.$data->opponents_phonecode.' '.$data->opponents_mobile_number);		
						}
						elseif($data->opponents_name != '' && $data->opponents_email != '') 
						{
							$opponents_array[]=esc_html($data->opponents_name.'-'.$data->opponents_email);		
						}
						elseif($data->opponents_name != '' && $data->opponents_mobile_number != '') 
						{
							$opponents_array[]=esc_html($data->opponents_name.'- '.$data->opponents_phonecode.' '.$data->opponents_mobile_number);		
						}
						else
						{
							$opponents_array[]=esc_html($data->opponents_name);
						}					
					}
				}
				if(in_array('opponent_details',$page_export_array))
				{  
					$row[] =  esc_html(implode(',',$opponents_array));
				}
				$opponents_attorney_details=json_decode($retrive_data->opponents_attorney_details);
				$opponents_attorney_array=array();		
				if(!empty($opponents_attorney_details))
				{
					foreach ($opponents_attorney_details as $data)
					{
						if($data->opponents_attorney_name != '' && $data->opponents_attorney_email != '' && $data->opponents_attorney_mobile_number != '') 
						{							
							$opponents_attorney_array[]=esc_html($data->opponents_attorney_name.'-'.$data->opponents_attorney_email.'- '.$data->opponents_attorney_phonecode.' '.$data->opponents_attorney_mobile_number);		
						}
						elseif($data->opponents_attorney_name != '' && $data->opponents_attorney_email != '') 
						{
							$opponents_attorney_array[]=esc_html($data->opponents_attorney_name.'-'.$data->opponents_attorney_email);		
						}
						elseif($data->opponents_attorney_name != '' && $data->opponents_attorney_mobile_number != '') 
						{
							$opponents_attorney_array[]=esc_html($data->opponents_attorney_name.'- '.$data->opponents_attorney_phonecode.' '.$data->opponents_attorney_mobile_number);		
						}
						else
						{
							$opponents_attorney_array[]=esc_html($data->opponents_attorney_name);
						}
					}
				}
				if(in_array('opponent_attorney_details',$page_export_array)) 
				{ 
					$row[] =  esc_html(implode(',',$opponents_attorney_array));
				}
				
				fputcsv($fh, $row, "\t");
			}
			}
			fclose($fh);
	
			//download csv file.
			$file=LAWMS_PLUGIN_DIR.'/admin/Reports/export_case.xls';//file location
			
			//$mime = 'text/plain';
			header('Content-Type:application/force-download');
			header('Pragma: public');       // required
			header('Expires: 0');           // no cache
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file)).' GMT');
			header('Cache-Control: private',false);
			 header("Content-Type: application/vnd.ms-excel");
			header('Content-Disposition: attachment; filename="'.basename($file).'"');
			header('Content-Transfer-Encoding: binary');
			//header('Content-Length: '.filesize($file_name));      // provide file size
			header('Connection: close');
			readfile($file);		
			exit;			
		}
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
					<?php esc_html_e('Records not found.','lawyer_mgt');?>
				</div>
			<?php		
		}		
	} 
	if(isset($_POST['case_csv']))
	{		
		if($user_role == 'attorney')
		{
			if($user_access['own_data'] == '1')
			{
				$user_id = get_current_user_id();
				$casedata=$obj_case->MJ_lawmgt_get_all_case_by_attorney_id($user_id);	
			}
			else
			{
				$casedata=$obj_case->MJ_lawmgt_get_all_case();
			}													
		}
		elseif($user_role == 'client')
		{
			if($user_access['own_data'] == '1')
			{
				$casedata=$obj_case->get_open_and_close_case_by_client();	
			}
			else
			{
				$casedata=$obj_case->MJ_lawmgt_get_all_case();
			}	
		}							   
		else
		{	
			if($user_access['own_data'] == '1')
			{
				$casedata = $obj_case->MJ_lawmgt_get_all_case_created_by();
			}
			else
			{
				$casedata=$obj_case->MJ_lawmgt_get_all_case();
			}
		}
		
		if(!empty($casedata))
		{
			$header = array();			
			if(in_array('case_name',$page_export_array)) 
				{  
					$header[] = esc_html__('Case Name','lawyer_mgt');
				}  
			if(in_array('case_number',$page_export_array)) 
				{  
					$header[] = esc_html__('Case Number','lawyer_mgt');
				}  
			  
			if(in_array('attorney_name',$page_export_array)) 
				{  
					$header[] = esc_html__('Case Assgined To','lawyer_mgt');
				}  
			if(in_array('open_date',$page_export_array))
				{  
					$header[] = esc_html__('Open Date','lawyer_mgt');
		        } 
			if(in_array('practice_area',$page_export_array))
				{  
					$header[] = esc_html__('Practice Area','lawyer_mgt');
				}  
			if(in_array('statute_of_limitation',$page_export_array))
				{  
					$header[] = esc_html__('Statute Of Limitations Date','lawyer_mgt');
				}  
			if(in_array('priority',$page_export_array)) 
				{  
					$header[] = esc_html__('Priority','lawyer_mgt');
				}  
			   
			if(in_array('court_details',$page_export_array)) 
				{  
					$header[] = esc_html__('Court Name','lawyer_mgt');
				}  
			if(in_array('court_hall_no',$page_export_array)) 
				{  
					$header[] = esc_html__('Court Hall No','lawyer_mgt');
				}  
			if(in_array('floor',$page_export_array)) 
				{  
					$header[] = esc_html__('Floor','lawyer_mgt');
				} 
			if(in_array('court_details',$page_export_array)) 
				{  
					$header[] = esc_html__('State Name','lawyer_mgt');
				}  
			if(in_array('court_details',$page_export_array)) 
				{ 
					$header[] = esc_html__('Bench Name','lawyer_mgt');
				}
			if(in_array('hearing_date',$page_export_array))
				{  
					$header[] = esc_html__('Hearing Date','lawyer_mgt');
				}
			if(in_array('crime_no',$page_export_array)) 
				{  
					$header[] = esc_html__('Crime No of Police Station','lawyer_mgt');
				}
			if(in_array('fir_no',$page_export_array))
				{  
					$header[] = esc_html__('FIR No','lawyer_mgt');
				}
			if(in_array('crime_no',$page_export_array)) 
				{  
					$header[] = esc_html__('Crime Details','lawyer_mgt');
				}
			if(in_array('earlier_court_history',$page_export_array)) 
				{  
					$header[] = esc_html__('Earlier Court History','lawyer_mgt');
				}
			if(in_array('classification',$page_export_array)) 
				{  
					$header[] = esc_html__('Classification','lawyer_mgt');
				}
			if(in_array('referred_by',$page_export_array)) 
				{  
					$header[] = esc_html__('Referred By','lawyer_mgt');
				}
			if(in_array('contact_link',$page_export_array)) 
				{  
					$header[] = esc_html__('Linked Client','lawyer_mgt');
				}
			if(in_array('billing_contact_name',$page_export_array))
				{  
					$header[] = esc_html__('Billing Client','lawyer_mgt');
				}
			if(in_array('opponent_details',$page_export_array))
				{  
					$header[] = esc_html__('Opponents Details','lawyer_mgt');
				}
			if(in_array('opponent_attorney_details',$page_export_array)) 
				{  
					$header[] = esc_html__('Opponents Attorney Details','lawyer_mgt');
				}
			
			$filename='Reports/export_case.csv';
			
			$fh = fopen(LAWMS_PLUGIN_DIR.'/admin/'.$filename, 'w') or die("can't open file");
			fputcsv($fh, $header);
			
			foreach($casedata as $retrive_data)
			{
				$case_id=$retrive_data->id;
														
				$case_contact=array();
				global $wpdb;
				$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';

				$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
				if(!empty($result_link_contact))
		        {
					foreach ($result_link_contact as $key => $object)
					{			
						 $result=get_userdata($object->user_id);
						 $case_contact[]=esc_html($result->display_name);
					}
				}				
			    $link_contact=implode(',',$case_contact);
				
				$row = array();	
				
				$user=explode(",",$retrive_data->case_assgined_to);
				$case_assgined_to=array();
				if(!empty($user))
				{						
					foreach($user as $data4)
					{
						$case_assgined_to[]=esc_html(MJ_lawmgt_get_display_name($data4));
					}
				}	
				$attorney_name=get_userdata($retrive_data->case_assgined_to);
	
				if(in_array('case_name',$page_export_array)) 
				{  
					$row[] =  esc_html($retrive_data->case_name);
				}
				if(in_array('case_number',$page_export_array)) 
				{ 
					$row[] =  esc_html($retrive_data->case_number);
				}  
				 
				if(in_array('attorney_name',$page_export_array)) 
				{
					$row[] = esc_html(implode(", ",$case_assgined_to));
				}  
				if(in_array('open_date',$page_export_array))
				{ 
					$row[] =  esc_html($retrive_data->open_date);
				} 
				if(in_array('practice_area',$page_export_array))
				{ 
					$row[] =  esc_html(get_the_title($retrive_data->practice_area_id));
				}  
				if(in_array('statute_of_limitation',$page_export_array))
				{
					$row[] =  esc_html($retrive_data->statute_of_limitations);
				}  
				if(in_array('priority',$page_export_array)) 
				{ 
					$row[] =  esc_html($retrive_data->priority);
				}  
				if(in_array('court_details',$page_export_array)) 
				{  
					$row[] =  esc_html(get_the_title($retrive_data->court_id));
				}  
				if(in_array('court_hall_no',$page_export_array)) 
				{ 
					$row[] =  esc_html($retrive_data->court_hall_no);
				}  
				if(in_array('floor',$page_export_array)) 
				{ 
					$row[] =  esc_html($retrive_data->floor);
				} 
				if(in_array('court_details',$page_export_array)) 
				{ 
					$row[] =  esc_html(get_the_title($retrive_data->state_id));
				}  
				if(in_array('court_details',$page_export_array)) 
				{ 
					$row[] =  esc_html(get_the_title($retrive_data->bench_id));
				}
				if(in_array('hearing_date',$page_export_array))
				{  
					$obj_next_hearing_date=new MJ_lawmgt_Orders;
					$next_hearing_date= $obj_next_hearing_date->MJ_lawmgt_get_next_hearing_date_asc_by_case_id($case_id);
					if(!empty($next_hearing_date))
					{
						$hearing_dates=array();
						foreach($next_hearing_date as $data)
						{
							$hearing_dates[]=esc_html($data->next_hearing_date);
						}					
						$row[] =  esc_html(implode(',',$hearing_dates));
					}
					else
					{
						$row[] = '';
					}
				}
				if(in_array('crime_no',$page_export_array)) 
				{
					$row[] =  esc_html($retrive_data->crime_no);
				}
				if(in_array('fir_no',$page_export_array))
				{  
					$row[] =  esc_html($retrive_data->fri_no);
				}
				if(in_array('crime_no',$page_export_array)) 
				{
					$row[] =  esc_html($retrive_data->crime_details);
				}
				if(in_array('earlier_court_history',$page_export_array)) 
				{  
					$row[] =  esc_html($retrive_data->earlier_history);
				}
				if(in_array('classification',$page_export_array)) 
				{ 
					$row[] =  esc_html($retrive_data->classification);
				}
				if(in_array('referred_by',$page_export_array)) 
				{ 
					$row[] = esc_html($retrive_data->referred_by);
				}
				if(in_array('contact_link',$page_export_array)) 
				{ 
					$row[] =  esc_html($link_contact);
				}
				if(in_array('billing_contact_name',$page_export_array))
				{ 
					$row[] =  esc_html(MJ_lawmgt_get_display_name($retrive_data->billing_contact_id));
				}
				$opponents_details_array=json_decode($retrive_data->opponents_details);
				$opponents_array=array();	
					
				if(!empty($opponents_details_array))
				{
					foreach ($opponents_details_array as $data)
					{	
						if($data->opponents_name != '' && $data->opponents_email != '' && $data->opponents_mobile_number != '') 
						{							
							$opponents_array[]=esc_html($data->opponents_name.'-'.$data->opponents_email.'- '.$data->opponents_phonecode.' '.$data->opponents_mobile_number);		
						}
						elseif($data->opponents_name != '' && $data->opponents_email != '') 
						{
							$opponents_array[]=esc_html($data->opponents_name.'-'.$data->opponents_email);		
						}
						elseif($data->opponents_name != '' && $data->opponents_mobile_number != '') 
						{
							$opponents_array[]=esc_html($data->opponents_name.'- '.$data->opponents_phonecode.' '.$data->opponents_mobile_number);		
						}
						else
						{
							$opponents_array[]=esc_html($data->opponents_name);
						}					
					}
				}
				if(in_array('opponent_details',$page_export_array))
				{  
					$row[] =  esc_html(implode(',',$opponents_array));
				}
				$opponents_attorney_details=json_decode($retrive_data->opponents_attorney_details);
				$opponents_attorney_array=array();		
				if(!empty($opponents_attorney_details))
				{
					foreach ($opponents_attorney_details as $data)
					{
						if($data->opponents_attorney_name != '' && $data->opponents_attorney_email != '' && $data->opponents_attorney_mobile_number != '') 
						{							
							$opponents_attorney_array[]=esc_html($data->opponents_attorney_name.'-'.$data->opponents_attorney_email.'- '.$data->opponents_attorney_phonecode.' '.$data->opponents_attorney_mobile_number);		
						}
						elseif($data->opponents_attorney_name != '' && $data->opponents_attorney_email != '') 
						{
							$opponents_attorney_array[]=esc_html($data->opponents_attorney_name.'-'.$data->opponents_attorney_email);		
						}
						elseif($data->opponents_attorney_name != '' && $data->opponents_attorney_mobile_number != '') 
						{
							$opponents_attorney_array[]=esc_html($data->opponents_attorney_name.'- '.$data->opponents_attorney_phonecode.' '.$data->opponents_attorney_mobile_number);		
						}
						else
						{
							$opponents_attorney_array[]=esc_html($data->opponents_attorney_name);
						}
					}
				}
				if(in_array('opponent_attorney_details',$page_export_array)) 
				{ 
					$row[] =  esc_html(implode(',',$opponents_attorney_array));
				}
				
				fputcsv($fh, $row);
			}
			fclose($fh);
	
			//download csv file.
			$file=LAWMS_PLUGIN_DIR.'/admin/Reports/export_case.csv';//file location
			
			$mime = 'text/plain';
			header('Content-Type:application/force-download');
			header('Pragma: public');       // required
			header('Expires: 0');           // no cache
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file)).' GMT');
			header('Cache-Control: private',false);
			header('Content-Type: '.$mime);
			header('Content-Disposition: attachment; filename="'.basename($file).'"');
			header('Content-Transfer-Encoding: binary');
			//header('Content-Length: '.filesize($file_name));      // provide file size
			header('Connection: close');
			readfile($file);		
			exit;			
		}			
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
					<?php esc_html_e('Records not found.','lawyer_mgt');?>
				</div>
		<?php		
		}		
	}	
	if(isset($_POST['case_pdf']))
	{		
		if($user_role == 'attorney')
		{
			if($user_access['own_data'] == '1')
			{
				$user_id = get_current_user_id();
				$casedata=$obj_case->MJ_lawmgt_get_all_case_by_attorney_id($user_id);	
			}
			else
			{
				$casedata=$obj_case->MJ_lawmgt_get_all_case();
			}													
		}
		elseif($user_role == 'client')
		{
			if($user_access['own_data'] == '1')
			{
				$casedata=$obj_case->get_open_and_close_case_by_client();	
			}
			else
			{
				$casedata=$obj_case->MJ_lawmgt_get_all_case();
			}	
		}							   
		else
		{	
			if($user_access['own_data'] == '1')
			{
				$casedata = $obj_case->MJ_lawmgt_get_all_case_created_by();
			}
			else
			{
				$casedata=$obj_case->MJ_lawmgt_get_all_case();
			}
		}
		
		if(!empty($casedata))
		{
			wp_enqueue_style( 'bootstrap-css', plugins_url( '/assets/css/bootstrap.css', __FILE__) );
			wp_enqueue_script('bootstrap-js', plugins_url( '/assets/js/bootstrap.js', __FILE__ ) );
			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="invoice.pdf"');
			header('Content-Transfer-Encoding: binary');
			header('Accept-Ranges: bytes');	
			require LAWMS_PLUGIN_DIR. '/lib/mpdf/mpdf.php';	
			$stylesheet = wp_enqueue_style( 'bootstrap-css', plugins_url( '/assets/css/style.css', __FILE__) ); // Get css content
			$mpdf	=	new mPDF('c','A4','','' , 5 , 5 , 5 , 0 , 0 , 0); 

			$mpdf->debug = true;
			$mpdf->WriteHTML('<html>');
			$mpdf->WriteHTML('<head>');
			$mpdf->WriteHTML('<style></style>');
			$mpdf->WriteHTML($stylesheet,1); // Writing style to pdf
			$mpdf->WriteHTML('</head>');
			$mpdf->WriteHTML('<body>');		
			$mpdf->SetTitle('Cases');
			
			$mpdf->WriteHTML('<table class="table table-bordered width_100" border="1">');
					$mpdf->WriteHTML('<thead>');	
							$mpdf->WriteHTML('<tr>');
								if(in_array('case_name',$page_export_array)) 
								{
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Case Name ','lawyer_mgt').'</th>');
								}
								if(in_array('case_number',$page_export_array)) 
								{ 
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Case Number ','lawyer_mgt').'</th>');
								}
								 
								if(in_array('attorney_name',$page_export_array)) 
								{
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Case Assgined To ','lawyer_mgt').'</th>');
								}
								if(in_array('open_date',$page_export_array))
								{
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Open Date ','lawyer_mgt').'</th>');
								}
								if(in_array('practice_area',$page_export_array))
								{ 
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Practice Area ','lawyer_mgt').'</th>');
								}
								if(in_array('statute_of_limitation',$page_export_array))
								{ 
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Statute Of Limitations Date ','lawyer_mgt').'</th>');
								}
								if(in_array('priority',$page_export_array)) 
								{
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Priority ','lawyer_mgt').'</th>');
								}
								if(in_array('court_details',$page_export_array)) 
								{ 	 
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Court Name ','lawyer_mgt').'</th>');
								}
								if(in_array('court_hall_no',$page_export_array)) 
								{ 
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Court Hall No ','lawyer_mgt').'</th>');
								}
								if(in_array('floor',$page_export_array)) 
								{
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Floor ','lawyer_mgt').'</th>');
								}
								if(in_array('court_details',$page_export_array)) 
								{  
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('State Name ','lawyer_mgt').'</th>');
								}
								if(in_array('court_details',$page_export_array)) 
								{
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Bench Name ','lawyer_mgt').'</th>');
								}
								if(in_array('hearing_date',$page_export_array))
								{  
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Hearing Date ','lawyer_mgt').'</th>');
								}
								if(in_array('crime_no',$page_export_array)) 
								{  
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Crime No of Police Station ','lawyer_mgt').'</th>');
								}
								if(in_array('fir_no',$page_export_array))
								{
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('FIR No ','lawyer_mgt').'</th>');
								}
								if(in_array('crime_no',$page_export_array)) 
								{
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Crime Details ','lawyer_mgt').'</th>');
								}
								if(in_array('earlier_court_history',$page_export_array)) 
								{ 
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Earlier Court History ','lawyer_mgt').'</th>');
								}
								if(in_array('classification',$page_export_array)) 
								{  
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Classification ','lawyer_mgt').'</th>');
								}
								if(in_array('referred_by',$page_export_array)) 
								{ 
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Referred By ','lawyer_mgt').'</th>');
								}
								if(in_array('contact_link',$page_export_array)) 
								{
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Linked Client ','lawyer_mgt').'</th>');
								}
								if(in_array('billing_contact_name',$page_export_array))
								{ 
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Billing Client ','lawyer_mgt').'</th>');
								}
								if(in_array('opponent_details',$page_export_array))
								{ 
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Opponents Details ','lawyer_mgt').'</th>');
								}
								if(in_array('opponent_attorney_details',$page_export_array)) 
								{ 
									$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Opponents Attorney Details ','lawyer_mgt').'</th>');
								}
								
							$mpdf->WriteHTML('</tr>');	
					$mpdf->WriteHTML('</thead>');
					$mpdf->WriteHTML('<tbody>');
										
						foreach($casedata as $retrive_data)
						{
							$case_id=$retrive_data->id;
														
							$case_contact=array();
							global $wpdb;
							$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';

							$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
							if(!empty($result_link_contact))
							{
								foreach ($result_link_contact as $key => $object)
								{			
									 $result=get_userdata($object->user_id);
									 $case_contact[]=esc_html($result->display_name);
								}	
							}							
							$link_contact=implode(',',$case_contact);
						
							$attorney_name=get_userdata($retrive_data->case_assgined_to);
								
							$opponents_details_array=json_decode($retrive_data->opponents_details);
							$opponents_array=array();		
							if(!empty($opponents_details_array))
							{
								foreach ($opponents_details_array as $data)
								{	
									if($data->opponents_name != '' && $data->opponents_email != '' && $data->opponents_mobile_number != '') 
									{							
										$opponents_array[]=esc_html($data->opponents_name.'-'.$data->opponents_email.'- '.$data->opponents_phonecode.' '.$data->opponents_mobile_number);		
									}
									elseif($data->opponents_name != '' && $data->opponents_email != '') 
									{
										$opponents_array[]=esc_html($data->opponents_name.'-'.$data->opponents_email);		
									}
									elseif($data->opponents_name != '' && $data->opponents_mobile_number != '') 
									{
										$opponents_array[]=esc_html($data->opponents_name.'- '.$data->opponents_phonecode.' '.$data->opponents_mobile_number);		
									}
									else
									{
										$opponents_array[]=esc_html($data->opponents_name);
									}					
								}
							}
							
							
							$opponents_attorney_details=json_decode($retrive_data->opponents_attorney_details);
							$opponents_attorney_array=array();		
							if(!empty($opponents_attorney_details))
							{
								foreach ($opponents_attorney_details as $data)
								{
									if($data->opponents_attorney_name != '' && $data->opponents_attorney_email != '' && $data->opponents_attorney_mobile_number != '') 
									{							
										$opponents_attorney_array[]=esc_html($data->opponents_attorney_name.'-'.$data->opponents_attorney_email.'- '.$data->opponents_attorney_phonecode.' '.$data->opponents_attorney_mobile_number);		
									}
									elseif($data->opponents_attorney_name != '' && $data->opponents_attorney_email != '') 
									{
										$opponents_attorney_array[]=$data->opponents_attorney_name.'-'.$data->opponents_attorney_email;		
									}
									elseif($data->opponents_attorney_name != '' && $data->opponents_attorney_mobile_number != '') 
									{
										$opponents_attorney_array[]=esc_html($data->opponents_attorney_name.'- '.$data->opponents_attorney_phonecode.' '.$data->opponents_attorney_mobile_number);		
									}
									else
									{
										$opponents_attorney_array[]=esc_html($data->opponents_attorney_name);
									}
								}
							}							
				
							$mpdf->WriteHTML('<tr class="entry_list">');
								if(in_array('case_name',$page_export_array)) 
								{  
									$mpdf->WriteHTML('<td class="align_center table_td_font width_10_per_css">'.esc_html($retrive_data->case_name).'</td>');
								}
								if(in_array('case_number',$page_export_array)) 
								{  
									$mpdf->WriteHTML('<td class="align_center table_td_font width_10_per_css">'.esc_html($retrive_data->case_number).'</td>');
								}
								 
								if(in_array('attorney_name',$page_export_array)) 
								{
									$mpdf->WriteHTML('<td class="align_center table_td_font width_15_per_css">'.esc_html($attorney_name->display_name).'</td>');
								}
								if(in_array('open_date',$page_export_array))
								{
									$mpdf->WriteHTML('<td class="align_center table_td_font width_10_per_css">'.esc_html($retrive_data->open_date).'</td>');
								}
								if(in_array('practice_area',$page_export_array))
								{  
									$mpdf->WriteHTML('<td class="align_center table_td_font width_15_per_css">'.esc_html(get_the_title($retrive_data->practice_area_id)).'</td>');
								}
								if(in_array('statute_of_limitation',$page_export_array))
								{
									$mpdf->WriteHTML('<td class="align_center table_td_font width_15_per_css">'.esc_html($retrive_data->statute_of_limitations).'</td>');
								}
								if(in_array('priority',$page_export_array)) 
								{  
									$mpdf->WriteHTML('<td class="align_center table_td_font width_5_per_css">'.esc_html($retrive_data->priority).'</td>');
								}
									
									$obj_next_hearing_date=new MJ_lawmgt_Orders;
									$next_hearing_date= $obj_next_hearing_date->MJ_lawmgt_get_next_hearing_date_asc_by_case_id($case_id);
									if(!empty($next_hearing_date))
									{
										$hearing_dates=array();
										foreach($next_hearing_date as $data)
										{
											$hearing_dates[]=esc_html($data->next_hearing_date);
										}					
										$hearing_dates_value =  implode(',',$hearing_dates);
									}
									else
									{
										$hearing_dates_value = '';
									}				
									
								if(in_array('court_details',$page_export_array)) 
								{  
									$mpdf->WriteHTML('<td class="align_center table_td_font width_10_per_css">'.esc_html(get_the_title($retrive_data->court_id)).'</td>');
								}
								if(in_array('court_hall_no',$page_export_array)) 
								{ 
									$mpdf->WriteHTML('<td class="align_center table_td_font width_10_per_css">'.esc_html($retrive_data->court_hall_no).'</td>');	
								}
								if(in_array('floor',$page_export_array)) 
								{  
									$mpdf->WriteHTML('<td class="align_center table_td_font width_5_per_css">'.esc_html($retrive_data->floor).'</td>');	
								}
								if(in_array('court_details',$page_export_array)) 
								{  
									$mpdf->WriteHTML('<td class="align_center table_td_font width_10_per_css">'.esc_html(get_the_title($retrive_data->state_id)).'</td>');
								}	
								if(in_array('court_details',$page_export_array)) 
								{ 								
									$mpdf->WriteHTML('<td class="align_center table_td_font width_15_per_css">'.esc_html(get_the_title($retrive_data->bench_id)).'</td>');	
								}
								if(in_array('hearing_date',$page_export_array))
								{
									$mpdf->WriteHTML('<td class="align_center table_td_font width_10_per_css">'.esc_html($hearing_dates_value).'</td>');
								}
								if(in_array('crime_no',$page_export_array)) 
								{ 
									$mpdf->WriteHTML('<td class="align_center table_td_font width_10_per_css">'.esc_html($retrive_data->crime_no).'</td>');
								}	
								if(in_array('fir_no',$page_export_array))
								{
									$mpdf->WriteHTML('<td class="align_center table_td_font width_10_per_css">'.esc_html($retrive_data->fri_no).'</td>');
								}	
								if(in_array('crime_no',$page_export_array)) 
								{  
									$mpdf->WriteHTML('<td class="align_center table_td_font width_10_per_css">'.esc_html($retrive_data->crime_details).'</td>');	
								}
								if(in_array('earlier_court_history',$page_export_array)) 
								{ 	
									$mpdf->WriteHTML('<td class="align_center table_td_font width_15_per_css">'.esc_html($retrive_data->earlier_history).'</td>');
								}
								if(in_array('classification',$page_export_array)) 
								{ 
									$mpdf->WriteHTML('<td class="align_center table_td_font width_15_per_css">'.esc_html($retrive_data->classification).'</td>');
								}
								if(in_array('referred_by',$page_export_array)) 
								{  
									$mpdf->WriteHTML('<td class="align_center table_td_font width_10_per_css">'.esc_html($retrive_data->referred_by).'</td>');
								}
									if(in_array('contact_link',$page_export_array)) 
								{ 
									$mpdf->WriteHTML('<td class="align_center table_td_font width_20_per_css">'.esc_html($link_contact).'</td>');
								}
								if(in_array('billing_contact_name',$page_export_array))
								{ 
									$mpdf->WriteHTML('<td class="align_center table_td_font width_20_per_css">'.esc_html(MJ_lawmgt_get_display_name($retrive_data->billing_contact_id)).'</td>');	
								}									
								if(in_array('opponent_details',$page_export_array))
								{   
									$mpdf->WriteHTML('<td class="align_center table_td_font width_20_per_css">'.esc_html(implode(',',$opponents_array)).'</td>');
								}	
								if(in_array('opponent_attorney_details',$page_export_array)) 
								{  
									$mpdf->WriteHTML('<td class="align_center table_td_font width_20_per_css">'.esc_html(implode(',',$opponents_attorney_array)).'</td>');
								}								
							$mpdf->WriteHTML(' </tr>');
						}						
						
					$mpdf->WriteHTML('</tbody>');
				$mpdf->WriteHTML('</table>');
				
			$mpdf->WriteHTML("</body>");
			$mpdf->WriteHTML("</html>");
	
			$mpdf->Output('cases.pdf', 'D');
			unset($mpdf);
			exit;
		}
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
					<?php esc_html_e('Records not found.','lawyer_mgt');?>
				</div>
		<?php		
		}		
	}
	if(isset($_POST['case_diary_excle_selected']))
	{
		if(isset($_POST['selected_id']))
		{	
	        $selected_id_filter = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ));
            $all = implode(",", $selected_id_filter);
			$case_diary_data=$obj_case->MJ_lawmgt_export_selected_case_dairy($all);
			
			if(!empty($case_diary_data))
			{
				$header = array();			
				$header[] =  esc_html__('Case Number','lawyer_mgt');
				$header[] =  esc_html__('Case Name','lawyer_mgt');
				$header[] =  esc_html__('Practice Area','lawyer_mgt');
				$header[] =  esc_html__('Open Date','lawyer_mgt');
				$header[] =  esc_html__('Client Link','lawyer_mgt');		
				$header[] =  esc_html__('Billing Client Name','lawyer_mgt');
				$header[] =  esc_html__('Attorney Name','lawyer_mgt');
				$header[] =  esc_html__('Court Name','lawyer_mgt');
				$header[] =  esc_html__('State Name','lawyer_mgt');
				$header[] =  esc_html__('Bench Name','lawyer_mgt');
				$header[] =  esc_html__('Hearing Dates','lawyer_mgt');
				$header[] =  esc_html__('Stages','lawyer_mgt');
				
				$filename='Reports/export_case_dairy.xls';
				$fh = fopen(LAWMS_PLUGIN_DIR.'/admin/'.$filename, 'w') or die("can't open file");
				fputcsv($fh, $header);
				if(!empty($case_diary_data))
				{
					foreach($case_diary_data as $retrieved_data)
					{
						$case_id=$retrieved_data->id;
																
						$caselink_contact=array();
						global $wpdb;
						$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';

						$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
						if(!empty($result_link_contact))
						{
							foreach ($result_link_contact as $key => $object)
							{			
								 $result=get_userdata($object->user_id);
								 $caselink_contact[]=esc_html($result->display_name);
													
							}	
					    }						
						$contact=implode(',',$caselink_contact);
						$user=explode(",",$retrieved_data->case_assgined_to);
						$case_assgined_to=array();
						if(!empty($user))
						{						
							foreach($user as $data4)
							{
								$case_assgined_to[]=esc_html(MJ_lawmgt_get_display_name($data4));
							}
						}							
															
						$row = array();	
						
						$row[] =  esc_html($retrieved_data->case_number);
						$row[] =  esc_html($retrieved_data->case_name);
						$row[] =  esc_html(get_the_title($retrieved_data->practice_area_id));
						$row[] =  esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->open_date));
						$row[] =  esc_html($contact);
						$row[] =  esc_html(MJ_lawmgt_get_display_name($retrieved_data->billing_contact_id));
						$row[] = esc_html(implode(", ",$case_assgined_to));
						$row[] =  esc_html(get_the_title($retrieved_data->court_id));  
						$row[] =  esc_html(get_the_title($retrieved_data->state_id));  
						$row[] =  esc_html(get_the_title($retrieved_data->bench_id));  
						$obj_next_hearing_date=new MJ_lawmgt_Orders;
						$next_hearing_date= $obj_next_hearing_date->MJ_lawmgt_get_next_hearing_date_asc_by_case_id($case_id);
						if(!empty($next_hearing_date))
						{
							$hearing_dates=array();
							foreach($next_hearing_date as $data)
							{
								$hearing_dates[]=$data->next_hearing_date;
							}					
							$row[] =  esc_html(implode(',',$hearing_dates));
						}
						else
						{
							$row[] = '';
						}
						if(!empty($retrieved_data->stages))
						{
							$stages=json_decode($retrieved_data->stages);
						}
						if(!empty($stages))
						{
							$stage_value=array();
							foreach($stages as $data)
							{ 
								$stage_value[] = esc_html($data->value);
							} 
							$row[] =  esc_html(implode(',',$stage_value));
						}
						else
						{
							$row[] = '';
						}								
						fputcsv($fh, $row);
					}
				}
				/*var_dump($fh);
				var_dump($row);
				die;*/
				fclose($fh);
		
				//download csv file.
				$file=LAWMS_PLUGIN_DIR.'/admin/Reports/export_case_dairy.xls';//file location
				//$mime = 'text/plain';
				header('Content-Type:application/force-download');
				header('Pragma: public');       // required
				header('Expires: 0');           // no cache
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file)).' GMT');
				header('Cache-Control: private',false);
				 header("Content-Type: application/vnd.ms-excel");
				header('Content-Disposition: attachment; filename="'.basename($file).'"');
				header('Content-Transfer-Encoding: binary');
				//header('Content-Length: '.filesize($file_name));      // provide file size
				header('Connection: close');
				readfile($file);		
				exit;			
			}
			 
		}
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
					</button>
					<?php esc_html_e('Please Select At least One Record.','lawyer_mgt');?>
				</div>
		<?php		
		}		
	}		
	if(isset($_POST['save_workflow']))
	{
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_workflow_nonce' ) )
		{ 
			if(isset($_REQUEST['edit'])&& sanitize_text_field($_REQUEST['edit'])=='true')
			{	
				$result=$obj_caseworkflow->MJ_lawmgt_add_caseworkflow($_POST);
				
				$case_id=MJ_lawmgt_id_encrypt(sanitize_text_field($_REQUEST['case_id']));
				//wp_redirect ( home_url() . '?dashboard=user&page=cases&tab=casedetails&action=view&tab2=workflow&tab3=workflow_list&message=18&case_id='.$case_id);
				$redirect_url=home_url() . '?dashboard=user&page=cases&tab=casedetails&action=view&tab2=workflow&tab3=workflow_list&message=18&case_id='.$case_id;
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
			else
			{
				$result=$obj_caseworkflow->MJ_lawmgt_add_caseworkflow($_POST);		
				$case_id=MJ_lawmgt_id_encrypt(sanitize_text_field($_REQUEST['case_id']));
					//wp_redirect ( home_url() . '?dashboard=user&page=cases&tab=casedetails&action=view&tab2=workflow&tab3=workflow_list&message=17&case_id='.$case_id);
					$redirect_url=home_url() . '?dashboard=user&page=cases&tab=casedetails&action=view&tab2=workflow&tab3=workflow_list&message=17&case_id='.$case_id;
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
		}
	}
	if(isset($_POST['add_fee_payment']))
	{
		//POP up data save in payment history
	    if($_POST['payment_method'] == 'Paypal')
		{				
			require_once LAWMS_PLUGIN_DIR. '/lib/paypal/paypal_process.php';				
		}
		else
		{ 
			$result=$obj_invoice->MJ_lawmgt_add_feepayment($_POST);			
			if($result)
			{
				$case_id=MJ_lawmgt_id_encrypt(sanitize_text_field($_REQUEST['case_id']));
				//wp_redirect ( home_url() . '?dashboard=user&page=cases&tab=casedetails&action=view&tab2=invoice&tab3=invoicelist&message=16&case_id='.$case_id);
				$redirect_url=home_url() . '?dashboard=user&page=cases&tab=casedetails&action=view&tab2=invoice&tab3=invoicelist&message=16&case_id='.$case_id;
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
		}
	}	
	if(isset($_POST['save_invoice']))
	{
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_case_invouice_nonce' ) )
		{ 
			if(isset($_REQUEST['edit'])&& sanitize_text_field($_REQUEST['edit'])=='true')
			{	
				$result=$obj_invoice->MJ_lawmgt_add_invoice($_POST);
					
				if($result)
				{
					$case_id=sanitize_text_field($_REQUEST['case_id']);
					//wp_redirect ( home_url() . '?dashboard=user&page=cases&tab=casedetails&action=view&tab2=invoice&tab3=invoicelist&message=14&case_id='.$case_id);
					$redirect_url=home_url() . '?dashboard=user&page=cases&tab=casedetails&action=view&tab2=invoice&tab3=invoicelist&message=14&case_id='.$case_id;
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
			}
			else
			{
				$result=$obj_invoice->MJ_lawmgt_add_invoice($_POST);		
				$case_id=sanitize_text_field($_REQUEST['case_id']);
				if($result)
				{
					//wp_redirect ( home_url() . '?dashboard=user&page=cases&tab=casedetails&action=view&tab2=invoice&tab3=invoicelist&message=13&case_id='.$case_id);
					$redirect_url=home_url() . '?dashboard=user&page=cases&tab=casedetails&action=view&tab2=invoice&tab3=invoicelist&message=13&case_id='.$case_id;
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
			}	
		}
	}
	if(isset($_POST['save_documents']))
	{	
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_case_document_nonce' ) )
		{ 
			$upload_docs_array=array();	
			if(isset($_REQUEST['add'])&& sanitize_text_field($_REQUEST['add'])=='true')
			{
				if(!empty($_FILES['cartificate']['name']))
				{
					$count_array=count($_FILES['cartificate']['name']);

					for($a=0;$a<$count_array;$a++)
					{			
						foreach($_FILES['cartificate'] as $image_key=>$image_val)
						{		
							$document_array[$a]=array(
							'name'=>sanitize_file_name($_FILES['cartificate']['name'][$a]),
							'type'=>sanitize_file_name($_FILES['cartificate']['type'][$a]),
							'tmp_name'=>sanitize_text_field($_FILES['cartificate']['tmp_name'][$a]),
							'error'=>sanitize_file_name($_FILES['cartificate']['error'][$a]),
							'size'=>sanitize_file_name($_FILES['cartificate']['size'][$a])
							);	
								
						}
					}				
					foreach($document_array as $key=>$value)		
					{	
						$get_file_name=$document_array[$key]['name'];	
						
						$upload_docs_array[]=MJ_lawmgt_load_documets($value,$value,$get_file_name);				
					} 				
				}
			}
			
			if(isset($_REQUEST['edit'])&& sanitize_text_field($_REQUEST['edit'])=='true')
			{	
				
				 if($_FILES['cartificate']['name'] != "" && $_FILES['cartificate']['size'] > 0)
				 {
					$upload_docs_array=MJ_lawmgt_load_documets($_FILES['cartificate'],$_FILES['cartificate'],'cartificate');			
				 }
				 else
				 {
					 $upload_docs_array=sanitize_text_field($_REQUEST['old_hidden_cartificate']);
				 }		
				
				$result=$obj_documents->MJ_lawmgt_add_documents($_POST,$upload_docs_array);
			
				if($result)
				{
					$case_id=sanitize_text_field($_REQUEST['case_id']);
					//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=12&tab2=documents&tab3=documentslist&case_id='.$case_id);
					$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=12&tab2=documents&tab3=documentslist&case_id='.$case_id;
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
				
			}
			else
			{
				$result=$obj_documents->MJ_lawmgt_add_documents($_POST,$upload_docs_array);
			
				if($result)
				{
					 $case_id=sanitize_text_field($_REQUEST['case_id']);
					
					//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=10&tab2=documents&tab3=documentslist&case_id='.$case_id);
					$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=10&tab2=documents&tab3=documentslist&case_id='.$case_id;
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
			}
		}
	}
	if(isset($_POST['savetast']))
	{	
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_case_task_nonce' ) )
		{ 
			if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='edit')
			{
				$result=$obj_case_tast->MJ_lawmgt_add_tast($_POST);
				if($result)
				{
					$case_id=MJ_lawmgt_id_encrypt(sanitize_text_field($_REQUEST['case_id']));
					//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=20&tab2=task&tab3=tasklist&case_id='.$case_id);
					$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=20&tab2=task&tab3=tasklist&case_id='.$case_id;
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
			}
			else
			{
				$result=$obj_case_tast->MJ_lawmgt_add_tast($_POST);
				if($result)
				{
					$case_id=MJ_lawmgt_id_encrypt(sanitize_text_field($_REQUEST['case_id']));
					//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=5&tab2=task&tab3=tasklist&case_id='.$case_id);
					$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=5&tab2=task&tab3=tasklist&case_id='.$case_id;
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
			}
		}
	}
	if(isset($_POST['savenote']))
	{
			$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_case_note_nonce' ) )
		{ 
		   if(isset($_REQUEST['action1'])&& $_REQUEST['action1']=='editnote')
		   {
				$result=$note->MJ_lawmgt_add_note($_POST);
				if($result)
				{
					$case_id=MJ_lawmgt_id_encrypt(sanitize_text_field($_REQUEST['case_id']));
					//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=21&tab2=note&tab3=notelist&case_id='.$case_id);
					$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=21&tab2=note&tab3=notelist&case_id='.$case_id;
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
			}
			else
			{
				$result=$note->MJ_lawmgt_add_note($_POST);
				if($result)
				{
					$case_id=MJ_lawmgt_id_encrypt(sanitize_text_field($_REQUEST['case_id']));
					//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=6&tab2=note&tab3=notelist&case_id='.$case_id);
					$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=6&tab2=note&tab3=notelist&case_id='.$case_id;
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
			}
		}

	}
	if(isset($_POST['saveevent']))
	{	
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_case_event_nonce' ) )
		{ 
			if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='edit')
			{
				$result=$event->MJ_lawmgt_add_event($_POST);
				if($result)
				{
					$case_id=MJ_lawmgt_id_encrypt(sanitize_text_field($_REQUEST['case_id']));
					//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=88&tab2=event&tab3=eventlist&case_id='.$case_id);
					$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=88&tab2=event&tab3=eventlist&case_id='.$case_id;
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
			}
			else
			{
				$result=$event->MJ_lawmgt_add_event($_POST);
				if($result)
				{
					$case_id=MJ_lawmgt_id_encrypt(sanitize_text_field($_REQUEST['case_id']));
					//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=8&tab2=event&tab3=eventlist&case_id='.$case_id);
					$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=8&tab2=event&tab3=eventlist&case_id='.$case_id;
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
			}
		}
	}
	
	if(isset($_POST['save_case']))
	{
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_case_nonce' ) )
		{ 
			if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='edit')
			{	
				$case_number=array();
				$current_case_number=array();
				global $wpdb;
				$table_case = $wpdb->prefix. 'lmgt_cases';
				$result = $wpdb->get_results("SELECT case_number FROM $table_case");
				
				$current_case_number[]=sanitize_text_field($_POST['edit_case_number']);
			
				if(!empty($result))
				{
					foreach ($result as $retrive_data)
					{ 	
						$case_number[]=esc_attr($retrive_data->case_number);
					}
				}	
				
				$case_number_diff=array_diff($case_number,$current_case_number);	
				
				if(in_array($_POST['case_number'],$case_number_diff))
				{
				?>
				<div class="alert_msg alert alert-danger alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
				<?php esc_html_e('Case Number All Ready Exist...','lawyer_mgt');?>
				</div>		
				<?php
				}
				else
				{
					$result=$obj_case->MJ_lawmgt_add_case($_POST);
					// Custom Field File Update //
					$custom_field_file_array=array();		
					if(!empty($_FILES['custom_file']['name']))
					{
						$count_array=count($_FILES['custom_file']['name']);
						
						for($a=0;$a<$count_array;$a++)
						{			
							foreach($_FILES['custom_file'] as $image_key=>$image_val)
							{
								foreach($image_val as $image_key1=>$image_val2)
								{
									if($_FILES['custom_file']['name'][$image_key1]!='')
									{  	
										$custom_file_array[$image_key1]=array(
										'name'=>sanitize_file_name($_FILES['custom_file']['name'][$image_key1]),
										'type'=>sanitize_file_name($_FILES['custom_file']['type'][$image_key1]),
										'tmp_name'=>sanitize_text_field($_FILES['custom_file']['tmp_name'][$image_key1]),
										'error'=>sanitize_file_name($_FILES['custom_file']['error'][$image_key1]),
										'size'=>sanitize_file_name($_FILES['custom_file']['size'][$image_key1])
										);							
									}						
								}
							}
						}	
						
						if(!empty($custom_file_array))
						{
							foreach($custom_file_array as $key=>$value)		
							{	
								global $wpdb;
								$wpnc_custom_field_metas = $wpdb->prefix . 'lmgt_custom_field_metas';
				
								$get_file_name=$custom_file_array[$key]['name'];	
								
								$custom_field_file_value=MJ_lawmgt_load_documets($value,$value,$get_file_name);		
								
								//Add File in Custom Field Meta//				
								$module='case';					
								$updated_at=date("Y-m-d H:i:s");
								$update_custom_meta_data =$wpdb->query($wpdb->prepare("UPDATE `$wpnc_custom_field_metas` SET `field_value` = '$custom_field_file_value',updated_at='$updated_at' WHERE `$wpnc_custom_field_metas`.`module` = %s AND  `$wpnc_custom_field_metas`.`module_record_id` = %d AND `$wpnc_custom_field_metas`.`custom_fields_id` = %d",$module,$result,$key));
							} 	
						}		 		
					}
			
					$update_custom_field=$custom_field->MJ_lawmgt_update_custom_field_metas('case',sanitize_text_field($_POST['custom']),$result);
				//	wp_redirect ( home_url() . '?dashboard=user&page=cases&tab=caselist&tab2=open&message=2');
					$redirect_url=home_url() . '?dashboard=user&page=cases&tab=caselist&tab2=open&message=2';
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
			}
			else
			{	
				$case_number=array();
				global $wpdb;
				$table_case = $wpdb->prefix. 'lmgt_cases';
				$result = $wpdb->get_results("SELECT case_number FROM $table_case");
				
				if(!empty($result))
				{
					foreach ($result as $retrive_data)
					{ 	
						$case_number[]=esc_html($retrive_data->case_number);
					}
				}	
				if(in_array($_POST['case_number'],$case_number))
				{
				?>
					<div class="alert_msg alert alert-danger alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
				<?php esc_html_e('Case Number All Ready Exist...','lawyer_mgt');?>
				</div>		
				<?php
				}
				else
				{
					$result=$obj_case->MJ_lawmgt_add_case($_POST);
					// Custom Field File Insert //
						$custom_field_file_array=array();
						if(!empty($_FILES['custom_file']['name']))
						{
							$count_array=count($_FILES['custom_file']['name']);
							
							for($a=0;$a<$count_array;$a++)
							{			
								foreach($_FILES['custom_file'] as $image_key=>$image_val)
								{
									foreach($image_val as $image_key1=>$image_val2)
									{
										if($_FILES['custom_file']['name'][$image_key1]!='')
										{  	
											$custom_file_array[$image_key1]=array(
											'name'=>sanitize_file_name($_FILES['custom_file']['name'][$image_key1]),
											'type'=>sanitize_file_name($_FILES['custom_file']['type'][$image_key1]),
											'tmp_name'=>sanitize_text_field($_FILES['custom_file']['tmp_name'][$image_key1]),
											'error'=>sanitize_file_name($_FILES['custom_file']['error'][$image_key1]),
											'size'=>sanitize_file_name($_FILES['custom_file']['size'][$image_key1])
											);							
										}	
									}
								}
							}			
							if(!empty($custom_file_array))
							{
								foreach($custom_file_array as $key=>$value)		
								{	
									global $wpdb;
									$wpnc_custom_field_metas = $wpdb->prefix . 'lmgt_custom_field_metas';
					
									$get_file_name=$custom_file_array[$key]['name'];	
									
									$custom_field_file_value=MJ_lawmgt_load_documets($value,$value,$get_file_name);		
									
									//Add File in Custom Field Meta//
									$custom_meta_data['module']='case';
									$custom_meta_data['module_record_id']=$result;
									$custom_meta_data['custom_fields_id']=$key;
									$custom_meta_data['field_value']=$custom_field_file_value;
									$custom_meta_data['created_at']=date("Y-m-d H:i:s");
									$custom_meta_data['updated_at']=date("Y-m-d H:i:s");	
									 
									
									$insert_custom_meta_data=$wpdb->insert($wpnc_custom_field_metas, $custom_meta_data );		
								} 	
							}		 		
						}
					$add_custom_field=$custom_field->MJ_lawmgt_add_custom_field_metas('case',sanitize_text_field($_POST['custom']),$result);	
					//wp_redirect ( home_url() . '?dashboard=user&page=cases&tab=caselist&tab2=open&message=1');
					$redirect_url=home_url() . '?dashboard=user&page=cases&tab=caselist&tab2=open&message=1';
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
			}
		}			
	}	
	if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='delete')
	{		
		$result=$obj_case->MJ_lawmgt_delete_case(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id'])));	
		
		if($result)
		{
			//wp_redirect ( home_url() . '?dashboard=user&page=cases&tab=caselist&tab2=open&message=3');
			$redirect_url=home_url() . '?dashboard=user&page=cases&tab=caselist&tab2=open&message=3';
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
	}
	if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='reopen')
	{
		
		$result=$obj_case->MJ_lawmgt_reopen_case(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id'])));
		
		if($result)
		{
			//wp_redirect ( home_url() . '?dashboard=user&page=cases&tab=caselist&tab2=close&message=25');
			$redirect_url=home_url() . '?dashboard=user&page=cases&tab=caselist&tab2=close&message=25';
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
			
	}
	if(isset($_POST['case_delete_selected']))
	{
		if (isset($_POST["selected_id"]))
		{	
			$selected_id_filter = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ));
			$all = implode(",", $selected_id_filter);			
			$result=$obj_case->MJ_lawmgt_delete_selected_case($all);	
		}
		if($result)
		{
			//wp_redirect ( home_url() . '?dashboard=user&page=cases&tab=caselist&tab2=open&message=3');
			$redirect_url=home_url() . '?dashboard=user&page=cases&tab=caselist&tab2=open&message=3';
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
	}	
	if(isset($_REQUEST['deletedocuments'])&& sanitize_text_field($_REQUEST['deletedocuments'])=='true')
	{	
		$result=$obj_documents->MJ_lawmgt_delete_documets(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['documents_id'])));		
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			
			//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=11&tab2=documents&tab3=documentslist&case_id='.$case_id);
			$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=11&tab2=documents&tab3=documentslist&case_id='.$case_id;
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
	}
	if(isset($_POST['document_delete_selected']))
	{
		if (isset($_POST["selected_id"]))
		{
			$selected_id_filter = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ));
			$all = implode(",", $selected_id_filter);			
			$result=$obj_documents->MJ_lawmgt_delete_selected_documents($all);	
		}
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=11&tab2=documents&tab3=documentslist&case_id='.$case_id);
			$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=11&tab2=documents&tab3=documentslist&case_id='.$case_id;
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
	}
	if(isset($_REQUEST['deletetask'])&& sanitize_text_fieldS($_REQUEST['deletetask'])=='true')
	{				
		$result=$obj_case_tast->MJ_lawmgt_delete_tast(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['task_id'])));
		
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=4&tab2=task&tab3=tasklist&case_id='.$case_id);
			$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=4&tab2=task&tab3=tasklist&case_id='.$case_id;
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
	}
	if(isset($_POST['task_delete_selected']))
	{
		if (isset($_POST["selected_id"]))
		{	
			
			$selected_id_filter = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ));
			$all = implode(",", $selected_id_filter);			
			$result=$obj_case_tast->MJ_lawmgt_delete_selected_task($all);	
		}
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=4&tab2=task&tab3=tasklist&case_id='.$case_id);
			$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=4&tab2=task&tab3=tasklist&case_id='.$case_id;
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
	}	
	if(isset($_REQUEST['deletenote'])&& $_REQUEST['deletenote']=='true')
	{
		$result=$note->MJ_lawmgt_delete_note(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['note_id'])));
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=7&tab2=note&tab3=notelist&case_id='.$case_id);
			$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=7&tab2=note&tab3=notelist&case_id='.$case_id;
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
	}
	if(isset($_POST['note_delete_selected']))
	{
		if (isset($_POST["selected_id"]))
		{	
			$selected_id_filter = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ));
			$all = implode(",", $selected_id_filter);			
			$result=$note->MJ_lawmgt_delete_selected_note($all);	
		}
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=7&tab2=note&tab3=notelist&case_id='.$case_id);
			$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=7&tab2=note&tab3=notelist&case_id='.$case_id;
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
	}	
	if(isset($_REQUEST['deleteevent'])&& $_REQUEST['deleteevent']=='true')
	{
		
		$result=$event->MJ_lawmgt_get_signle_event_Delete_by_id(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id'])));
		
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=9&tab2=event&tab3=eventlist&case_id='.$case_id);
			$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=9&tab2=event&tab3=eventlist&case_id='.$case_id;
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
	}
	if(isset($_POST['event_delete_selected']))
	{
		if (isset($_POST["selected_id"]))
		{	
			$selected_id_filter = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ));
			$all = implode(",", $selected_id_filter);			
			$result=$event->MJ_lawmgt_delete_selected_event($all);	
		}
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=9&tab2=event&tab3=eventlist&case_id='.$case_id);
			$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=9&tab2=event&tab3=eventlist&case_id='.$case_id;
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
	}
	if(isset($_REQUEST['deleteinvoice'])&& sanitize_text_field($_REQUEST['deleteinvoice'])=='true')
	{
		$result=$obj_invoice->MJ_lawmgt_delete_invoice(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['invoice_id'])));				
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=15&tab2=invoice&tab3=invoicelist&case_id='.$case_id);
			$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=15&tab2=invoice&tab3=invoicelist&case_id='.$case_id;
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
	}
	if(isset($_POST['invoice_delete_selected']))
	{
		if (isset($_POST["selected_id"]))
		{	
			$selected_id_filter = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ));
			$all = implode(",", $selected_id_filter);			
			$result=$obj_invoice->MJ_lawmgt_delete_selected_invoice($all);	
		}
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=15&tab2=invoice&tab3=invoicelist&case_id='.$case_id);
			$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=15&tab2=invoice&tab3=invoicelist&case_id='.$case_id;
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
	}	
	if(isset($_REQUEST['deleteworkflow'])&& sanitize_text_field($_REQUEST['deleteworkflow'])=='true')
	{
		
		$result=$obj_caseworkflow->MJ_lawmgt_delete_workflow(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['workflow_id'])));				
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=19&tab2=workflow&tab3=workflow_list&case_id='.$case_id);
			$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=19&tab2=workflow&tab3=workflow_list&case_id='.$case_id;
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
	}
	if(isset($_POST['workflow_delete_selected']))
	{
		if (isset($_POST["selected_id"]))
		{	
			$selected_id_filter = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ));
			$all = implode(",", $selected_id_filter);			
			$result=$obj_caseworkflow->MJ_lawmgt_delete_selected_workflow($all);	
		}
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=19&tab2=workflow&tab3=workflow_list&case_id='.$case_id);
			$redirect_url=home_url().'?dashboard=user&page=cases&tab=casedetails&action=view&message=19&tab2=workflow&tab3=workflow_list&case_id='.$case_id;
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
	}
	if(isset($_POST['document_excle_selected']))
	{
		if (isset($_POST["selected_id"]))
		{	
			$selected_id_filter = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ));
			$all = implode(",", $selected_id_filter);			
			$documentdata=$obj_documents->MJ_lawmgt_export_selected_documents($all);
			
			if(!empty($documentdata))
			{
				$header = array();			
				if(in_array('document_title',$document_export_array))
						{
							$header[] =  esc_html__('Document Title','lawyer_mgt');
						}
					if(in_array('document_type',$document_export_array))
						{
							$header[] =  esc_html__('Document Type','lawyer_mgt');
						}
					if(in_array('document_case_link',$document_export_array))
						{
							$header[] =  esc_html__('Case Link','lawyer_mgt');
						}
					if(in_array('tag_name',$document_export_array))
						{
							$header[] =  esc_html__('Tags Name','lawyer_mgt');
						}
					if(in_array('status',$document_export_array))
						{
							$header[] =  esc_html__('Status','lawyer_mgt');	
						}
					if(in_array('last_updated',$document_export_array))
						{
							$header[] =  esc_html__('Last Updated','lawyer_mgt');
						}
					if(in_array('document_description',$document_export_array))
						{
							$header[] =  esc_html__('Description','lawyer_mgt');
						}
				
				$filename='Reports/export_documents.xls';
				$fh = fopen(LAWMS_PLUGIN_DIR.'/admin/'.$filename, 'w') or die("can't open file");
				fputcsv($fh, $header, "\t");
				
				foreach($documentdata as $retrive_data)
				{
					$case_id=$retrive_data->case_id;
															
					global $wpdb;		
					$table_cases = $wpdb->prefix. 'lmgt_cases';
					$case_name= $wpdb->get_row("SELECT case_name FROM $table_cases where id=".$case_id);
					
					$status=$obj_documents->MJ_lawmgt_check_documents_status_by_user($retrive_data->id);																
																
					$row = array();	
					
					if(in_array('document_title',$document_export_array))
						{
							$row[] =  esc_html($retrive_data->title);
						}
						if(in_array('document_type',$document_export_array))
						{
							$row[] =  esc_html($retrive_data->type);
						}
						if(in_array('document_case_link',$document_export_array))
						{
							$row[] =  esc_html($case_name->case_name);
						}
						if(in_array('tag_name',$document_export_array))
						{
							$row[] =  esc_html($retrive_data->tag_names);
						}
						if(in_array('status',$document_export_array))
						{
							$row[] =esc_html($status);
						}
						if(in_array('last_updated',$document_export_array))
						{
							$row[] =  esc_html($retrive_data->last_update);
						}
						if(in_array('document_description',$document_export_array))
						{
							$row[] =  esc_html($retrive_data->document_description);
						}
					
					fputcsv($fh, $row, "\t");
				}
				fclose($fh);
		
				//download csv file.
				$file=LAWMS_PLUGIN_DIR.'/admin/Reports/export_documents.xls';//file location
				
				//$mime = 'text/plain';
				header('Content-Type:application/force-download');
				header('Pragma: public');       // required
				header('Expires: 0');           // no cache
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file)).' GMT');
				header('Cache-Control: private',false);
				 header("Content-Type: application/vnd.ms-excel");
				header('Content-Disposition: attachment; filename="'.basename($file).'"');
				header('Content-Transfer-Encoding: binary');
				//header('Content-Length: '.filesize($file_name));      // provide file size
				header('Connection: close');
				readfile($file);		
				exit;			
			}
			
		}
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
					</button>
					<?php esc_html_e('Please Select At least One Record.','lawyer_mgt');?>
				</div>
		<?php		
		}		
	}	
	
	if(isset($_POST['document_csv_selected']))
	{
		if (isset($_POST["selected_id"]))
		{	
			$selected_id_filter = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ));
            $all = implode(",", $selected_id_filter);
			$documentdata=$obj_documents->MJ_lawmgt_export_selected_documents($all);
			
			if(!empty($documentdata))
			{
				$header = array();			
				if(in_array('document_title',$document_export_array))
						{
							$header[] =  esc_html__('Document Title','lawyer_mgt');
						}
					if(in_array('document_type',$document_export_array))
						{
							$header[] =  esc_html__('Document Type','lawyer_mgt');
						}
					if(in_array('document_case_link',$document_export_array))
						{
							$header[] =  esc_html__('Case Link','lawyer_mgt');
						}
					if(in_array('tag_name',$document_export_array))
						{
							$header[] =  esc_html__('Tags Name','lawyer_mgt');
						}
					if(in_array('status',$document_export_array))
						{
							$header[] =  esc_html__('Status','lawyer_mgt');	
						}
					if(in_array('last_updated',$document_export_array))
						{
							$header[] =  esc_html__('Last Updated','lawyer_mgt');
						}
					if(in_array('document_description',$document_export_array))
						{
							$header[] =  esc_html__('Description','lawyer_mgt');
						}
				
				
				$filename='Reports/export_documents.csv';
				$fh = fopen(LAWMS_PLUGIN_DIR.'/admin/'.$filename, 'w') or die("can't open file");
				fputcsv($fh, $header);
				
				foreach($documentdata as $retrive_data)
				{
					$case_id=$retrive_data->case_id;
															
					global $wpdb;		
					$table_cases = $wpdb->prefix. 'lmgt_cases';
					$case_name= $wpdb->get_row("SELECT case_name FROM $table_cases where id=".$case_id);
					
					$status=$obj_documents->MJ_lawmgt_check_documents_status_by_user($retrive_data->id);																
																
					$row = array();	
					
					if(in_array('document_title',$document_export_array))
						{
							$row[] =  esc_html($retrive_data->title);
						}
						if(in_array('document_type',$document_export_array))
						{
							$row[] =  esc_html($retrive_data->type);
						}
						if(in_array('document_case_link',$document_export_array))
						{
							$row[] =  esc_html($case_name->case_name);
						}
						if(in_array('tag_name',$document_export_array))
						{
							$row[] =  esc_html($retrive_data->tag_names);
						}
						if(in_array('status',$document_export_array))
						{
							$row[] =esc_html($status);
						}
						if(in_array('last_updated',$document_export_array))
						{
							$row[] =  esc_html($retrive_data->last_update);
						}
						if(in_array('document_description',$document_export_array))
						{
							$row[] =  esc_html($retrive_data->document_description);
						}
					
					fputcsv($fh, $row);
				}
				fclose($fh);
		
				//download csv file.
				$file=LAWMS_PLUGIN_DIR.'/admin/Reports/export_documents.csv';//file location
				
				$mime = 'text/plain';
				header('Content-Type:application/force-download');
				header('Pragma: public');       // required
				header('Expires: 0');           // no cache
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file)).' GMT');
				header('Cache-Control: private',false);
				header('Content-Type: '.$mime);
				header('Content-Disposition: attachment; filename="'.basename($file).'"');
				header('Content-Transfer-Encoding: binary');
				//header('Content-Length: '.filesize($file_name));      // provide file size
				header('Connection: close');
				readfile($file);		
				exit;			
			}
			
		}
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">X</span>
					</button>
					<?php esc_html_e('Please Select At least One Record.','lawyer_mgt');?>
				</div>
		<?php		
		}		
	}
	if(isset($_POST['document_pdf_selected']))
	{
		if (isset($_POST["selected_id"]))
		{	
			$selected_id_filter = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ));
            $all = implode(",", $selected_id_filter);
			
			$documentdata=$obj_documents->MJ_lawmgt_export_selected_documents($all);
			
			if(!empty($documentdata))
			{
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
				$mpdf->SetTitle('Documents');
				
				$mpdf->WriteHTML('<table class="table table-bordered width_100" border="1">');
						$mpdf->WriteHTML('<thead>');	
								$mpdf->WriteHTML('<tr>');
									if(in_array('document_title',$document_export_array))
									{
										$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Document Title ','lawyer_mgt').'</th>');
									}
								if(in_array('document_type',$document_export_array))
									{	
										$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Document Type ','lawyer_mgt').'</th>');
									}
								if(in_array('document_case_link',$document_export_array))
									{
										$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Case Link ','lawyer_mgt').'</th>');	
									}	
								if(in_array('tag_name',$document_export_array))
									{
										$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Tags Name ','lawyer_mgt').'</th>');
									}
								if(in_array('status',$document_export_array))
									{
										$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Status ','lawyer_mgt').'</th>');
									}
								if(in_array('last_updated',$document_export_array))
									{
										$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Last Updated ','lawyer_mgt').'</th>');
									}
								if(in_array('document_description',$document_export_array))
									{
										$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('Description ','lawyer_mgt').'</th>');
									}
								$mpdf->WriteHTML('</tr>');	
						$mpdf->WriteHTML('</thead>');
						$mpdf->WriteHTML('<tbody>');
											
							foreach($documentdata as $retrive_data)
							{
								$case_id=$retrive_data->case_id;
																
								global $wpdb;		
								$table_cases = $wpdb->prefix. 'lmgt_cases';
								$case_name= $wpdb->get_row("SELECT case_name FROM $table_cases where id=".$case_id);
								
								$status=$obj_documents->MJ_lawmgt_check_documents_status_by_user($retrive_data->id);		
								
								$mpdf->WriteHTML('<tr class="entry_list">');
									if(in_array('document_title',$document_export_array))
										{
											$mpdf->WriteHTML('<td class="align_center table_td_font width_20_per_css">'.esc_html($retrive_data->title).'</td>');
										}
									if(in_array('document_type',$document_export_array))
										{
											$mpdf->WriteHTML('<td class="align_center table_td_font width_10_per_css">'.esc_html($retrive_data->type).'</td>');
										}
									if(in_array('document_case_link',$document_export_array))
										{
											$mpdf->WriteHTML('<td class="align_center table_td_font width_20_per_css">'.esc_html($case_name->case_name).'</td>');
										}
									if(in_array('tag_name',$document_export_array))
										{
											$mpdf->WriteHTML('<td class="align_center table_td_font width_10_per_css">'.esc_html($retrive_data->tag_names).'</td>');
										}
									if(in_array('status',$document_export_array))
										{
											$mpdf->WriteHTML('<td class="align_center table_td_font width_10_per_css">'.esc_html__(''.$status.'','lawyer_mgt').'</td>');
										}
									if(in_array('last_updated',$document_export_array))
										{
											$mpdf->WriteHTML('<td class="align_center table_td_font width_20_per_css">'.esc_html($retrive_data->last_update).'</td>');
										}
									if(in_array('document_description',$document_export_array))
										{
											$mpdf->WriteHTML('<td class="align_center table_td_font width_20_per_css">'.esc_html($retrive_data->document_description).'</td>');
										}									
								$mpdf->WriteHTML(' </tr>');
							}						
							
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
					
				$mpdf->WriteHTML("</body>");
				$mpdf->WriteHTML("</html>");
		
				$mpdf->Output('documents.pdf', 'D');
				unset($mpdf);
				exit;
			}
			
		}
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
					</button>
					<?php esc_html_e('Please Select At least One Record.','lawyer_mgt');?>
				</div>
		<?php		
		}		
	}
	if(isset($_REQUEST['message']))
	{
		$message =sanitize_text_field($_REQUEST['message']);
		if($message == 1)
		{?>	
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
			<?php esc_html_e('Case Inserted Successfull','lawyer_mgt');?>
			</div>
		<?php 			
		}
		elseif($message == 2)
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<?php esc_html_e('Case Updated Successfully','lawyer_mgt');?>
			</div>
			<?php 			
		}
		elseif($message == 3) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Case Close Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 4) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Task Delete Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 5) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Task Inserted Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 6) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Note Inserted Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 7) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Delete Note Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 8) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Event Inserted Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		
		elseif($message == 88) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Event Updated Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 9) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Delete Event Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 10) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Documents Inserted successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 11) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Documents deleted successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 12) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Documents Updated successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 13) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Invoice Inserted Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 14) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Invoice Updated successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 15) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Invoice Deleted successfull','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 16) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Payment Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 17) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Apply Workflow Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}		
		elseif($message == 18) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Workflow  Updated Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}		
		elseif($message == 19) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Workflow Deleted Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
        elseif($message == 20) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Task Updated Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
        elseif($message == 21) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
             <?php esc_html_e('Note Updated Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 22) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
             <?php esc_html_e('Next Hearing Date Updated Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 23) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
             <?php esc_html_e('Next Hearing Date Inserted Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 24) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
             <?php esc_html_e('Delete Next Hearing Date Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 25) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
					</button>
			 <?php esc_html_e('Case ReOpen Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}			
	} 		
	?>
	<?php
	$user_role=MJ_lawmgt_get_current_user_role();
	?>
<script type="text/javascript">
jQuery(document).ready(function ($) 
{
	"use strict"; 
	var u_role = $("#aaa").val();
	 if(u_role == 'client'){
		$("h2").removeClass("height_h2");
	 }
	 
	 if(u_role == 'attorney'){
		$("h2").removeClass("height_h2_new");
	 }
		 
});
</script>

	<div id="main-wrapper"> <!-- MAIN WRAPER  DIV -->
		<div class="row">
			<div class="panel panel-white width_100 ">
				<div class="panel-body"><!-- PANEL BODY DIV  -->
					<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
						<input type="hidden" class="form-control" id="aaa" value="<?php echo esc_attr($user_role);?>">
						 
						<h2 class="nav-tab-wrapper height_h2 height_h2_new">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font my_tab_css" role="tablist">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'caselist' ? 'active' : ''; ?> menucss active_mt">
									<a href="?dashboard=user&page=cases&tab=caselist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Case List', 'lawyer_mgt'); ?>
									</a>
								</li>
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
								{?>
							    <li role="presentation" class="<?php echo esc_html($active_tab) == 'add_case' ? 'active' : ''; ?> menucss tab_mt">
									<a href="?dashboard=user&page=cases&tab=add_case&&action=edit&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
										<?php esc_html_e('Edit Case', 'lawyer_mgt'); ?>
									</a> 
                               </li> 									
								<?php 
								}
								else
								{
									if($user_access['add']=='1')
									{
										?>
										<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_case' ? 'active' : ''; ?> menucss tab_mt">
										<a href="?dashboard=user&page=cases&tab=add_case&&action=add">
											<?php echo '<span class="fa fa-plus-circle"></span> '.esc_html__('Add Case', 'lawyer_mgt');?>
										</a>  
										</li>
										<?php
									}  
								}?>
								<?php
								
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
								{?>
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'casedetails' ? 'active' : ''; ?> menucss tab_mt">
										<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
											<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('Case Details', 'lawyer_mgt'); ?>
										</a>
									</li>
								<?php
								}
								
								if($user_access['add']=='1')
								{
									if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
									{
									?>
										<li role="presentation" class="<?php echo esc_html($active_tab) == 'caseexport' ? 'active' : ''; ?> menucss active_mt">
											<a href="?dashboard=user&page=cases&tab=caseexport">
												<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Case Export', 'lawyer_mgt'); ?>
											</a>
										</li>	
									<?php
									}
								}
								if($user_role == 'attorney')
								{
								 ?>
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'case_diary' ? 'active' : ''; ?> menucss active_mt" >
										<a href="?dashboard=user&page=cases&tab=case_diary">
											<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__("Today's Case Diary", 'lawyer_mgt'); ?>
										</a>
									</li>	
								 <?php
								}
								?>	
							</ul>
						</h2>
					<?php 
					if($active_tab == 'caselist')
					{	
						$active_tab = sanitize_text_field(isset($_GET['tab2'])?$_GET['tab2']:'open');
						?>							
						<h2>
							<ul class="sub_menu_css line nav nav-tabs margin_cases" id="myTab" role="tablist">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'open' ? 'active' : ''; ?> menucss">
									<a href="?dashboard=user&page=cases&tab=caselist&tab2=open">
									<?php echo esc_html__('Open Cases', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'close' ? 'active' : ''; ?> menucss">
									<a href="?dashboard=user&page=cases&tab=caselist&tab2=close">
									<?php echo esc_html__('Close Cases', 'lawyer_mgt'); ?>
									</a>
								</li>	
							</ul>
						</h2>
						<?php		 
						if($active_tab == 'open')
						{
						?>
							<script type="text/javascript">
							    var $ = jQuery.noConflict();
								jQuery(document).ready(function($)
								{
									"use strict"; 
									jQuery('.case_list').DataTable({
										/* "responsive": true, */
										"autoWidth": false,
									"order": [[ 1, "asc" ]],
									language:<?php echo wpnc_datatable_multi_language();?>,
									 "aoColumns":[
												  {"bSortable": false},
												  <?php if(in_array('case_number',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>
												  <?php if(in_array('case_name',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>
												  <?php if(in_array('open_date',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>
												    
												  <?php if(in_array('statute_of_limitation',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>                
												  <?php if(in_array('priority',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?> 
												  <?php if(in_array('practice_area',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>
												  <?php if(in_array('court_details',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>               
												  <?php if(in_array('contact_link',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>               
												  <?php if(in_array('billing_contact_name',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>               
												  <?php if(in_array('billing_type',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>
												  <?php if(in_array('attorney_name',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>
												  <?php if(in_array('court_hall_no',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>
												  <?php if(in_array('floor',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>
												  <?php if(in_array('crime_no',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>
												  <?php if(in_array('fir_no',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>
												  <?php if(in_array('hearing_date',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>
												  <?php if(in_array('stages',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>
												  <?php if(in_array('classification',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>
												  <?php if(in_array('earlier_court_history',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>
												  <?php if(in_array('referred_by',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>
												  <?php if(in_array('opponent_details',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>
												  <?php if(in_array('opponent_attorney_details',$page_columns_array)){ ?> 
												  {"bSortable": true},
												  <?php } ?>
												  {"bSortable": false}
											   ]
									});	
								}); 
								jQuery(document).ready(function($)
								{		
									"use strict"; 
									jQuery('#select_all').on('click', function(e)
									{
										 if($(this).is(':checked',true))  
										 {
											$(".sub_chk").prop('checked', true);  
										 }  
										 else  
										 {  
											$(".sub_chk").prop('checked',false);  
										 } 
									});
									$("body").on("change", ".sub_chk", function()
									{ 
										if(false == $(this).prop("checked"))
										{ 
											$("#select_all").prop('checked', false); 
										}
										if ($('.sub_chk:checked').length == $('.sub_chk').length )
										{
											$("#select_all").prop('checked', true);
										}
									});
								});
							</script>	
							<form  action="" method="post" class="form-horizontal" enctype='multipart/form-data'>	
							<div class="panel-body">	
								<input type="hidden" name="case_open" class="hidden_case_filter" value="open">
									<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label class="col-lg-2 col-md-2 col-sm-1 col-xs-12 control-label filter_lable_year"><?php esc_html_e('Filter By Year :','lawyer_mgt');?></label>
										<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 case_year">
											<select class="form-control case_year_filter" name="case_year_status">
											<option value="all"><?php esc_html_e('All','lawyer_mgt');?></option>
												<?php 
												$start_year=get_option( 'lmgt_staring_year' );
												$current_year=date("Y");
												$a=$current_year-$start_year;
												$end_year=$start_year + $a;
												for ($start_year; $start_year <= $end_year; $start_year++) 
												{	
													echo '<option value='.esc_attr__($start_year).'>'.esc_html__($start_year).'</option>';
												}
												?>
											</select> 
										</div>	
									</div>
									<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<table id="case_list" class="open_case_export case_list case_list3 table table-striped table-bordered">
										<thead>
											<tr> 
											<th><input type="checkbox" id="select_all"></th>
										<?php if(in_array('case_number',$page_columns_array)){ ?> 
											<th><?php esc_html_e('Case Number', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('case_name',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('open_date',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Open Date', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										 
										<?php if(in_array('statute_of_limitation',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Statute Of Limitation', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('priority',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Prority', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('practice_area',$page_columns_array)){ ?>
											<th> <?php esc_html_e('Practice Area', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('court_details',$page_columns_array)){ ?>
											<th> <?php esc_html_e('Court Details', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('contact_link',$page_columns_array)){ ?>
											<th> <?php esc_html_e('Client Link', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('billing_contact_name',$page_columns_array)){ ?>
											<th> <?php esc_html_e('Billing Client Name', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('billing_type',$page_columns_array)){ ?>
											<th> <?php esc_html_e('Billing Type', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('attorney_name',$page_columns_array)){ ?>
											<th> <?php esc_html_e('Attorney Name', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('court_hall_no',$page_columns_array)){ ?>
											<th> <?php esc_html_e('Court Hall No', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('floor',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Floor', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('crime_no',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Crime No', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('fir_no',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('FIR No', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('hearing_date',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Hearing Dates', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('stages',$page_columns_array)){?> 
											<th><?php  esc_html_e('Stages', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('classification',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Classification', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('earlier_court_history',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Earlier Court History', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('referred_by',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Referred By', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('opponent_details',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Opponents Details', 'lawyer_mgt' ) ;?></th>
										<?php } ?>	
										<?php if(in_array('opponent_attorney_details',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Opponents Attorney Details', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
											<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
										</tr>
											<br/>
										</thead>
										<tbody>
											<?php
											if(isset($_REQUEST['attoeny_deatil'])&& sanitize_text_field($_REQUEST['attoeny_deatil'])=='true')
											{	
												$casedata=$obj_case->MJ_lawmgt_get_open_case_by_attorney(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['attorney_id'])));													
											}
											elseif($user_role == 'attorney')
											{
												if($user_access['own_data'] == '1')
												{
													$user_id = get_current_user_id();
													$casedata=$obj_case->MJ_lawmgt_get_open_case_by_attorney($user_id);	
												}
												else
												{
													$casedata=$obj_case->MJ_lawmgt_get_open_all_case();
												}													
											}
											elseif($user_role == 'client')
											{
												if($user_access['own_data'] == '1')
												{
													$casedata=$obj_case->MJ_lawmgt_get_open_case_by_client();	
												}
												else
												{
													$casedata=$obj_case->MJ_lawmgt_get_open_all_case();
												}	
											}							   
											else
											{	
												if($user_access['own_data'] == '1')
												{
													$casedata = $obj_case->MJ_lawmgt_get_open_all_case_created_by();
												}
												else
												{
													$casedata=$obj_case->MJ_lawmgt_get_open_all_case();
												}
											}
											   
											if(!empty($casedata))
											{
												foreach ($casedata as $retrieved_data)
												{
													$case_id=$retrieved_data->id;
													
													$caselink_contact=array();
													global $wpdb;
													$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
							
													$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
													if(!empty($result_link_contact))
											        {
														foreach ($result_link_contact as $key => $object)
														{			
															 $result=get_userdata($object->user_id);
															 $caselink_contact[]=esc_html($result->display_name);
																				
														}	
													}														
													$contact=implode(',',$caselink_contact);$attorney_name=get_userdata($retrieved_data->case_assgined_to);
													
													$opponents_details_array=json_decode($retrieved_data->opponents_details);
														$opponents_array=array();		
														if(!empty($opponents_details_array))
														{
															foreach ($opponents_details_array as $data)
															{	
																if($data->opponents_name != '' && $data->opponents_email != '' && $data->opponents_mobile_number != '') 
																{							
																	$opponents_array[]=esc_html($data->opponents_name.'-'.$data->opponents_email.'- '.$data->opponents_phonecode.' '.$data->opponents_mobile_number);		
																}
																elseif($data->opponents_name != '' && $data->opponents_email != '') 
																{
																	$opponents_array[]=esc_html($data->opponents_name.'-'.$data->opponents_email);		
																}
																elseif($data->opponents_name != '' && $data->opponents_mobile_number != '') 
																{
																	$opponents_array[]=esc_html($data->opponents_name.'- '.$data->opponents_phonecode.' '.$data->opponents_mobile_number);		
																}
																else
																{
																	$opponents_array[]=esc_html($data->opponents_name);
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
																$opponents_attorney_array[]=esc_html($data->opponents_attorney_name.'-'.$data->opponents_attorney_email.'- '.$data->opponents_attorney_phonecode.' '.$data->opponents_attorney_mobile_number);		
															}
															elseif($data->opponents_attorney_name != '' && $data->opponents_attorney_email != '') 
															{
																$opponents_attorney_array[]=esc_html($data->opponents_attorney_name.'-'.$data->opponents_attorney_email);		
															}
															elseif($data->opponents_attorney_name != '' && $data->opponents_attorney_mobile_number != '') 
															{
																$opponents_attorney_array[]=esc_html($data->opponents_attorney_name.'- '.$data->opponents_attorney_phonecode.' '.$data->opponents_attorney_mobile_number);		
															}
															else
															{
																$opponents_attorney_array[]=esc_html($data->opponents_attorney_name);
															}
														}
													}
													$attorney=$retrieved_data->case_assgined_to;
													$attorney_name=explode(',',$attorney);
													$attorney_name1=array();
													
													if(!empty($attorney_name))
													{
														foreach($attorney_name as $attorney_name2) 
														{
															$attorneydata=get_userdata($attorney_name2);	
																
															$attorney_name1[]=esc_html($attorneydata->display_name);										   
														}
													}
													?>
													<tr>
														<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->id); ?>"></td>
													<?php if(in_array('case_number',$page_columns_array)){ ?> 
														<td class="case_number"><?php echo esc_html($retrieved_data->case_number);?></td>
													<?php } ?>
													<?php if(in_array('case_name',$page_columns_array)){ ?> 	
														<td class="name"><a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>"><?php echo esc_html($retrieved_data->case_name);?></a></td>
													<?php } ?>
													<?php if(in_array('open_date',$page_columns_array)){ ?> 	
														<td class=""><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->open_date));?></td>
													<?php } ?>
													 
													<?php if(in_array('statute_of_limitation',$page_columns_array)){ ?>	 
														<td class=""><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->statute_of_limitations));?></td>
													<?php } ?>
													<?php if(in_array('priority',$page_columns_array)){ ?> 	
														<td class=""><?php echo esc_html($retrieved_data->priority);?></td>
													<?php } ?>
													<?php if(in_array('practice_area',$page_columns_array)){ ?>	
														<td class="prac_area"><?php echo esc_html(get_the_title($retrieved_data->practice_area_id));?></td>
													<?php } ?>
													<?php if(in_array('court_details',$page_columns_array)){ ?>	
														<td><?php echo esc_html(get_the_title($retrieved_data->court_id)); ?> - <?php echo esc_html(get_the_title($retrieved_data->state_id)); ?> - <?php echo esc_html(get_the_title($retrieved_data->bench_id)); ?></td>
													<?php } ?>
													<?php if(in_array('contact_link',$page_columns_array)){ ?>	
														<td class="contact_link"><?php echo  esc_html($contact);?></td>
													<?php } ?>
													<?php if(in_array('billing_contact_name',$page_columns_array)){ ?>	
														<td><?php echo esc_html(MJ_lawmgt_get_display_name($retrieved_data->billing_contact_id));?></td>
													<?php } ?>
													<?php if(in_array('billing_type',$page_columns_array)){ ?>	
														<td class=""><?php echo esc_html($retrieved_data->billing_type);?></td>
													<?php } ?>
													<?php if(in_array('attorney_name',$page_columns_array)){ ?>	
														<td class="added"><?php echo esc_html(implode(',',$attorney_name1));?></td>
													<?php } ?>
													<?php if(in_array('court_hall_no',$page_columns_array)){ ?>	
														<td class=""><?php echo esc_html($retrieved_data->court_hall_no);?></td>
													<?php } ?>
													<?php if(in_array('floor',$page_columns_array)){ ?> 	
														<td class=""><?php echo esc_html($retrieved_data->floor);?></td>
													<?php } ?>
													<?php if(in_array('crime_no',$page_columns_array)){ ?> 	
														<td class=""><?php echo esc_html($retrieved_data->crime_no);?></td>
													<?php } ?>
													<?php if(in_array('fir_no',$page_columns_array)){ ?>	
														<td class=""><?php echo esc_html($retrieved_data->fri_no);?></td>
													<?php } ?>
													<?php if(in_array('hearing_date',$page_columns_array)){ ?>	
														<td>
															<?php
															$obj_next_hearing_date=new MJ_lawmgt_Orders;
															$next_hearing_date= $obj_next_hearing_date->MJ_lawmgt_get_next_hearing_date_asc_by_case_id($case_id);
															$hearing_date_array=array();
															if(!empty($next_hearing_date))
															{
																foreach($next_hearing_date as $data)
																{
																	$hearing_date_array[]=esc_html(MJ_lawmgt_getdate_in_input_box($data->next_hearing_date));
																}
															}
															echo implode(',</br>',$hearing_date_array);
															?>
														</td>
													<?php } ?>
													<?php if(in_array('stages',$page_columns_array)){?>
														<td>
															<?php
															 if(!empty($retrieved_data->stages))
																{
																	$stages=json_decode($retrieved_data->stages);
																}
																$increment = 0;
																if(!empty($stages))
																{
																	foreach($stages as $data)
																	{ 
																		$increment++;
																		 echo esc_html($increment);?>.<?php echo esc_html($data->value); ?>
																		<?php
																	} 
																} 
																?>	
														</td>
													<?php } ?>
													<?php if(in_array('classification',$page_columns_array)){ ?>
														<td class=""><?php echo esc_html($retrieved_data->classification);?></td>
													<?php } ?>
													<?php if(in_array('earlier_court_history',$page_columns_array)){ ?> 
														<td class=""><?php echo esc_html($retrieved_data->earlier_history);?></td>
													<?php } ?>
													<?php if(in_array('referred_by',$page_columns_array)){ ?>
														<td class=""><?php echo esc_html($retrieved_data->referred_by);?></td>
													<?php } ?>	
													<?php if(in_array('opponent_details',$page_columns_array)){ ?>
														<td class=""><?php echo  esc_html(implode(',',$opponents_array));?></td>
													<?php } ?>	
													<?php if(in_array('opponent_attorney_details',$page_columns_array)){ ?>
														<td class=""><?php echo  esc_html(implode(',',$opponents_attorney_array));?></td>
													<?php } ?>	
														<td class="action"> 	
															<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
															<?php
															if($user_access['edit']=='1')
															{
															?>			
																<a href="?dashboard=user&page=cases&tab=add_case&action=edit&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
															<?php
															}
															if($user_access['delete']=='1')
															{
																?>	
																 <a href="?dashboard=user&page=cases&tab=caselist&action=delete&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" 
																	onclick="return confirm('<?php esc_html_e('Are you sure you want to Close this Case?','lawyer_mgt');?>');">
																  <?php esc_html_e('Close', 'lawyer_mgt' ) ;?> </a>
															<?php
															}
															?>	
														</td>               
													</tr>
											<?php 
												} 			
											} ?>     
										</tbody>  
									</table>
									<?php
									if($user_access['delete']=='1')
									{
										if(!empty($casedata))
										{
										?>	
											<div class="form-group">		
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
														<input type="submit" class="btn delete_margin_bottom btn-danger" name="case_delete_selected" onclick="return confirm('<?php esc_attr_e('Are you sure you want to Close this Cases?','lawyer_mgt');?>');" value="<?php esc_attr_e('Close', 'lawyer_mgt' ) ;?> " />
													</div>
												</div>
										   </div>
										<?php
										}
									}
									?>	
								</div>
							</div>	
							</form>	
						<?php	
						}
						if($active_tab == 'close')
						{
						?>
							<script type="text/javascript">
							   jQuery(document).ready(function($)
							   {
								   "use strict"; 
									jQuery('.case_list').DataTable({
										/* "responsive": true, */
										"autoWidth": false,
										"order": [[ 1, "asc" ]],
										language:<?php echo wpnc_datatable_multi_language();?>,
										 "aoColumns":[
													  <?php if(in_array('case_number',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>
													  <?php if(in_array('case_name',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>
													   <?php if(in_array('open_date',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>
													  {"bSortable": true},
													    
													  <?php if(in_array('statute_of_limitation',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>                
													  <?php if(in_array('priority',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?> 
													  <?php if(in_array('practice_area',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>
													  <?php if(in_array('court_details',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>               
													  <?php if(in_array('contact_link',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>               
													   <?php if(in_array('billing_contact_name',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>               
													   <?php if(in_array('billing_type',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>
													  <?php if(in_array('attorney_name',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>
													  <?php if(in_array('court_hall_no',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>
													  <?php if(in_array('floor',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>
													  <?php if(in_array('crime_no',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>
													   <?php if(in_array('fir_no',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>
													   <?php if(in_array('hearing_date',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>
													   <?php if(in_array('stages',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>
													   <?php if(in_array('classification',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>
													   <?php if(in_array('earlier_court_history',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>
													  <?php if(in_array('referred_by',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>
													  <?php if(in_array('opponent_details',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>
													  <?php if(in_array('opponent_attorney_details',$page_columns_array)){ ?> 
													  {"bSortable": true},
													  <?php } ?>
													  {"bSortable": false}
												   ]									
										});	
								}); 
							</script>
							<div class="panel-body">	
								<input type="hidden" name="case_open" class="hidden_case_filter" value="close">
									<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label class="col-lg-2 col-md-2 col-sm-1 col-xs-12 control-label filter_lable_year"><?php esc_html_e('Filter By Year :','lawyer_mgt');?></label>
										<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" >
											<select class="form-control case_year_filter " name="case_year_status">
											<option value="all"><?php esc_html_e('All','lawyer_mgt');?></option>
												<?php 
												$start_year=get_option( 'lmgt_staring_year' );
												$current_year=date("Y");
												$a=$current_year-$start_year;
												$end_year=$start_year + $a;
												for ($start_year; $start_year <= $end_year; $start_year++) 
												{	
												 echo '<option value='.esc_attr__($start_year).'>'.esc_html__($start_year).'</option>';
												}
												?>
											</select>
										</div>	
									</div>
								<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<table id="case_list" class="case_list case_list4 table table-striped table-bordered">
										<thead>
											<tr> 
										<?php if(in_array('case_number',$page_columns_array)){ ?> 
											<th><?php esc_html_e('Case Number', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('case_name',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('open_date',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Open Date', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<th><?php  esc_html_e('Close Date', 'lawyer_mgt' ) ;?></th>
										 
										<?php if(in_array('statute_of_limitation',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Statute Of Limitation', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('priority',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Prority', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('practice_area',$page_columns_array)){ ?>
											<th> <?php esc_html_e('Practice Area', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('court_details',$page_columns_array)){ ?>
											<th> <?php esc_html_e('Court Details', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('contact_link',$page_columns_array)){ ?>
											<th> <?php esc_html_e('Client Link', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('billing_contact_name',$page_columns_array)){ ?>
											<th> <?php esc_html_e('Billing Client Name', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('billing_type',$page_columns_array)){ ?>
											<th> <?php esc_html_e('Billing Type', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('attorney_name',$page_columns_array)){ ?>
											<th> <?php esc_html_e('Attorney Name', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('court_hall_no',$page_columns_array)){ ?>
											<th> <?php esc_html_e('Court Hall No', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('floor',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Floor', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('crime_no',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Crime No', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('fir_no',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('FIR No', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('hearing_date',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Hearing Dates', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('stages',$page_columns_array)){?> 
											<th><?php  esc_html_e('Stages', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('classification',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Classification', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('earlier_court_history',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Earlier Court History', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('referred_by',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Referred By', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
										<?php if(in_array('opponent_details',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Opponents Details', 'lawyer_mgt' ) ;?></th>
										<?php } ?>	
										<?php if(in_array('opponent_attorney_details',$page_columns_array)){ ?> 
											<th><?php  esc_html_e('Opponents Attorney Details', 'lawyer_mgt' ) ;?></th>
										<?php } ?>
											<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
										</tr>
										<br/>
										</thead>
										<tbody>
											<?php 			
											if(isset($_REQUEST['attoeny_deatil'])&& sanitize_text_field($_REQUEST['attoeny_deatil'])=='true')
											{
												$casedata=$obj_case->MJ_lawmgt_get_close_case_by_attorney(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['attorney_id'])));
											}
											elseif($user_role == 'attorney')
											{
												if($user_access['own_data'] == '1')
												{
													$user_id = get_current_user_id();
													$casedata=$obj_case->MJ_lawmgt_get_close_case_by_attorney($user_id);	
												}
												else
												{
													$casedata=$obj_case->MJ_lawmgt_get_close_all_case();	
												}													
											}
											elseif($user_role == 'client')
											{
												if($user_access['own_data'] == '1')
												{
													$casedata=$obj_case->MJ_lawmgt_get_close_case_by_client();
												}
												else
												{
													$casedata=$obj_case->MJ_lawmgt_get_close_all_case();	
												}												
											}
											else
											{			
												if($user_access['own_data'] == '1')
												{	
													$casedata=$obj_case->MJ_lawmgt_get_close_all_case_created_by();
												}
												else
												{
													$casedata=$obj_case->MJ_lawmgt_get_close_all_case();
												}												
											}
											  
											if(!empty($casedata))
											{
												foreach ($casedata as $retrieved_data)
												{
													$case_id=$retrieved_data->id;
												
													$caselink_contact=array();
													global $wpdb;
													$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
							
													$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
													foreach ($result_link_contact as $key => $object)
													{			
														$result=get_userdata($object->user_id);
														$caselink_contact[]='<a href="?dashboard=user&page=contacts&tab=viewcontact&action=view&contact_id='.MJ_lawmgt_id_encrypt(esc_attr($object->user_id)).'">'.esc_html($result->display_name).'</a>';
														
													}															
													$contact=implode(',',$caselink_contact);
													$attorney_name=get_userdata($retrieved_data->case_assgined_to);
													
													$opponents_details_array=json_decode($retrieved_data->opponents_details);
														$opponents_array=array();		
														if(!empty($opponents_details_array))
														{
															foreach ($opponents_details_array as $data)
															{	
																if($data->opponents_name != '' && $data->opponents_email != '' && $data->opponents_mobile_number != '') 
																{							
																	$opponents_array[]=esc_html($data->opponents_name.'-'.$data->opponents_email.'- '.$data->opponents_phonecode.' '.$data->opponents_mobile_number);		
																}
																elseif($data->opponents_name != '' && $data->opponents_email != '') 
																{
																	$opponents_array[]=esc_html($data->opponents_name.'-'.$data->opponents_email);		
																}
																elseif($data->opponents_name != '' && $data->opponents_mobile_number != '') 
																{
																	$opponents_array[]=esc_html($data->opponents_name.'- '.$data->opponents_phonecode.' '.$data->opponents_mobile_number);		
																}
																else
																{
																	$opponents_array[]=esc_html($data->opponents_name);
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
																$opponents_attorney_array[]=esc_html($data->opponents_attorney_name.'-'.$data->opponents_attorney_email.'- '.$data->opponents_attorney_phonecode.' '.$data->opponents_attorney_mobile_number);		
															}
															elseif($data->opponents_attorney_name != '' && $data->opponents_attorney_email != '') 
															{
																$opponents_attorney_array[]=esc_html($data->opponents_attorney_name.'-'.$data->opponents_attorney_email);		
															}
															elseif($data->opponents_attorney_name != '' && $data->opponents_attorney_mobile_number != '') 
															{
																$opponents_attorney_array[]=esc_html($data->opponents_attorney_name.'- '.$data->opponents_attorney_phonecode.' '.$data->opponents_attorney_mobile_number);		
															}
															else
															{
																$opponents_attorney_array[]=esc_html($data->opponents_attorney_name);
															}
														}
													}
													$attorney=$retrieved_data->case_assgined_to;
													$attorney_name=explode(',',$attorney);
													$attorney_name1=array();
													if(!empty($attorney_name))
                                                    {
														foreach($attorney_name as $attorney_name2) 
														{
															$attorneydata=get_userdata($attorney_name2);	
																
															$attorney_name1[]='<a href="?dashboard=user&page=attorney&tab=view_attorney&action=view&attorney_id='.MJ_lawmgt_id_encrypt(esc_attr($attorneydata->ID)).'">'.esc_html($attorneydata->display_name).'</a>';										   
														}
													}
													?>
													<tr> 
														 <?php if(in_array('case_number',$page_columns_array)){ ?> 
														<td class="case_number"><?php echo esc_html($retrieved_data->case_number);?></td>
													<?php } ?>
													<?php if(in_array('case_name',$page_columns_array)){ ?> 	
														<td class="name"><a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>"><?php echo esc_html($retrieved_data->case_name);?></a></td>
													<?php } ?>
													<?php if(in_array('open_date',$page_columns_array)){ ?> 	
														<td class=""><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->open_date));?></td>
													<?php } ?>
														<td class=""><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->close_date));?></td>
													 
													<?php if(in_array('statute_of_limitation',$page_columns_array)){ ?>	 
														<td class=""><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->statute_of_limitations));?></td>
													<?php } ?>
													<?php if(in_array('priority',$page_columns_array)){ ?> 	
														<td class=""><?php echo esc_html($retrieved_data->priority);?></td>
													<?php } ?>
													<?php if(in_array('practice_area',$page_columns_array)){ ?>	
														<td class="prac_area"><?php echo esc_html(get_the_title($retrieved_data->practice_area_id));?></td>
													<?php } ?>
													<?php if(in_array('court_details',$page_columns_array)){ ?>	
														<td><?php echo esc_html(get_the_title($retrieved_data->court_id)); ?> - <?php echo esc_html(get_the_title($retrieved_data->state_id)); ?> - <?php echo esc_html(get_the_title($retrieved_data->bench_id)); ?></td>
													<?php } ?>
													<?php if(in_array('contact_link',$page_columns_array)){ ?>	
														<td class="contact_link"><?php echo esc_html($contact);?></td>
													<?php } ?>
													<?php if(in_array('billing_contact_name',$page_columns_array)){ ?>	
														<td><a href="?dashboard=user&page=contacts&tab=viewcontact&action=view&contact_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->billing_contact_id));?>"><?php echo esc_html(MJ_lawmgt_get_display_name($retrieved_data->billing_contact_id));?></a></td>
													<?php } ?>
													<?php if(in_array('billing_type',$page_columns_array)){ ?>	
														<td class=""><?php echo esc_html($retrieved_data->billing_type);?></td>
													<?php } ?>
													<?php if(in_array('attorney_name',$page_columns_array)){ ?>	
														 <td class="added"><?php echo implode(',',$attorney_name1);?></td>
													<?php } ?>
													<?php if(in_array('court_hall_no',$page_columns_array)){ ?>	
														<td class=""><?php echo esc_html($retrieved_data->court_hall_no);?></td>
													<?php } ?>
													<?php if(in_array('floor',$page_columns_array)){ ?> 	
														<td class=""><?php echo esc_html($retrieved_data->floor);?></td>
													<?php } ?>
													<?php if(in_array('crime_no',$page_columns_array)){ ?> 	
														<td class=""><?php echo esc_html($retrieved_data->crime_no);?></td>
													<?php } ?>
													<?php if(in_array('fir_no',$page_columns_array)){ ?>	
														<td class=""><?php echo esc_html($retrieved_data->fri_no);?></td>
													<?php } ?>
													<?php if(in_array('hearing_date',$page_columns_array)){ ?>	
														<td>
															<?php
															$obj_next_hearing_date=new MJ_lawmgt_Orders;
															$next_hearing_date= $obj_next_hearing_date->MJ_lawmgt_get_next_hearing_date_asc_by_case_id($case_id);
															$hearing_date_array=array();
															foreach($next_hearing_date as $data)
															{
																$hearing_date_array[]=esc_html(MJ_lawmgt_getdate_in_input_box($data->next_hearing_date));
															}
															echo implode(',</br>',$hearing_date_array);
															?>
														</td>
													<?php } ?>
													<?php if(in_array('stages',$page_columns_array)){?>
														<td>
															<?php
															 if(!empty($retrieved_data->stages))
																{
																	$stages=json_decode($retrieved_data->stages);
																}
																$increment = 0;
																if(!empty($stages))
                                                                {
																	foreach($stages as $data)
																	{ 
																		$increment++;
																		 echo esc_html($increment);?><?php echo esc_html($data->value);?>
																		<?php
																	}
																}
																?>	
														</td>
													<?php } ?>
													<?php if(in_array('classification',$page_columns_array)){ ?>
														<td class=""><?php echo esc_html($retrieved_data->classification);?></td>
													<?php } ?>
													<?php if(in_array('earlier_court_history',$page_columns_array)){ ?> 
														<td class=""><?php echo esc_html($retrieved_data->earlier_history);?></td>
													<?php } ?>
													<?php if(in_array('referred_by',$page_columns_array)){ ?>
														<td class=""><?php echo esc_html($retrieved_data->referred_by);?></td>
													<?php } ?>
													<?php if(in_array('opponent_details',$page_columns_array)){ ?>
														<td class=""><?php echo  esc_html(implode(',',$opponents_array));?></td>
													<?php } ?>	
													<?php if(in_array('opponent_attorney_details',$page_columns_array)){ ?>
														<td class=""><?php echo  esc_html(implode(',',$opponents_attorney_array));?></td>
													<?php } ?>
														<td class="action"> 									
															 <a href="?dashboard=user& page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
														<?php
														if($user_access['add']=='1')
														{
															?>
															<a href="?dashboard=user& page=cases&tab=caselist&action=reopen&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-success" 
															onclick="return confirm('<?php esc_html_e('Are you sure you want to ReOpen this Case?','lawyer_mgt');?>');">
														  <?php esc_html_e('Reopen', 'lawyer_mgt' ) ;?> </a>
													<?php } ?>															 
														</td>			
													</tr>
											<?php 
												} 			
											} ?>     
										</tbody> 					
									</table>
								</div>
							</div>
						<?php		
						}
					}
					if($active_tab == 'case_diary')
					{
						?>
							<script type="text/javascript">
								jQuery(document).ready(function($)
								{
									"use strict"; 
									jQuery('.case_diary_list').DataTable({
										"responsive": true,
										"autoWidth": false,
									"order": [[ 1, "asc" ]],
									language:<?php echo wpnc_datatable_multi_language();?>,
									 "aoColumns":[
												  {"bSortable": false},
												  {"bSortable": true},
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
									
									jQuery('#select_all').on('click', function(e)
									{
										 if($(this).is(':checked',true))  
										 {
											$(".sub_chk").prop('checked', true);  
										 }  
										 else  
										 {  
											$(".sub_chk").prop('checked',false);  
										 } 
									});
									$("body").on("change", ".sub_chk", function()
									{ 
										if(false == $(this).prop("checked"))
										{ 
											$("#select_all").prop('checked', false); 
										}
										if ($('.sub_chk:checked').length == $('.sub_chk').length )
										{
											$("#select_all").prop('checked', true);
										}
									});
									
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
								<form  action="" method="post" class="form-horizontal" enctype='multipart/form-data'>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="row">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label filter_lable_case_dairy"><?php esc_html_e('Filter By Hearing Date:','lawyer_mgt');?></label>

										<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
											<input type="text" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>"  class="form-control sdate has-feedback-left validate[required]" name="sdate" placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>"
											value="<?php if(isset($_REQUEST['sdate'])) echo esc_attr($_REQUEST['sdate']);?>">
											<span class="fa fa-calendar form-control-feedback left cal_top_5" aria-hidden="true" style="left:10px;height: 33px;padding: 3px;"></span>
										</div>

										<label class="control-label  filter_lable_task_to"><?php esc_html_e('To','lawyer_mgt');?></label>
										<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
												<input type="text"  class="form-control edate has-feedback-left validate[required]" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>"  name="edate" placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>"
												value="<?php if(isset($_REQUEST['edate'])) echo esc_attr($_REQUEST['edate']);?>">
												<span class="fa fa-calendar form-control-feedback left cal_top_5" aria-hidden="true" style="left:10px;height: 33px;padding: 3px;"></span>
										</div>

										<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12 button-possition">
											<label for="subject_id">&nbsp;</label>
											<input type="button" name="filter_case_diary" id="filter_case_diary_next_hearing_date" Value="<?php esc_attr_e('Go','lawyer_mgt');?>"  class="btn btn-success filter_case_diary_next_hearing_date btn-go"/>
										</div>
										
									</div>
								</div>
								<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<table id="case_diary_list" class="case_diary_list case_list3 table table-striped table-bordered">
										<thead>
											<tr>
												<th><input type="checkbox" id="select_all"></th>
												<th> <?php esc_html_e('Case Number', 'lawyer_mgt' ) ;?></th>
												<th> <?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
												<th> <?php esc_html_e('Practice Area', 'lawyer_mgt' ) ;?></th>
												<th> <?php esc_html_e('Open Date', 'lawyer_mgt' ) ;?></th>
												<th> <?php esc_html_e('Client Link', 'lawyer_mgt' ) ;?></th>
												<th> <?php esc_html_e('Billing Client Name', 'lawyer_mgt' ) ;?></th>
												<th> <?php esc_html_e('Attorney Name', 'lawyer_mgt' ) ;?></th>
												<th> <?php esc_html_e('Court Details', 'lawyer_mgt' ) ;?></th>
												<th> <?php esc_html_e('Hearing Dates', 'lawyer_mgt' ) ;?></th>	
												<th> <?php esc_html_e('Stages', 'lawyer_mgt' ) ;?></th>
											</tr>
											<br/>
										</thead>
										<tbody>
											<?php
											
											$casedata_diary=$obj_case->MJ_lawmgt_get_cases_by_current_next_hearing_date_of_attorney();

											if(!empty($casedata_diary))
											{
												foreach ($casedata_diary as $retrieved_data)
												{
													$case_id=$retrieved_data->id;
													
													$caselink_contact=array();
													global $wpdb;
													$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
							
													$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
													if(!empty($result_link_contact))
                                                    {
														foreach ($result_link_contact as $key => $object)
														{			
															 $result=get_userdata($object->user_id);
															 $caselink_contact[]=esc_html($result->display_name);
														}
													}													
													$contact=implode(',',$caselink_contact);															
													?>
													<tr>
														<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->id); ?>"></td>
														<td class="case_number"><?php echo esc_html($retrieved_data->case_number);?></td>
														 <td class="name"><a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>"><?php echo esc_html($retrieved_data->case_name);?></a></td>				
														<td class="prac_area"><?php echo esc_html(get_the_title($retrieved_data->practice_area_id));?></td>	
														<td class=""><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->open_date));?></td>
														 <td class="contact_link"><?php echo  esc_html($contact);?></td>	
														 <td><a href="?dashboard=user&page=contacts&tab=viewcontact&action=view&contact_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->billing_contact_id));?>"><?php echo esc_html(MJ_lawmgt_get_display_name($retrieved_data->billing_contact_id));?></a></td>						 	
														 <?php 
														
														 $user=explode(",",$retrieved_data->case_assgined_to);
															$case_assgined_to=array();
															if(!empty($user))
															{						
																foreach($user as $data4)
																{
																	$case_assgined_to[]=esc_html(MJ_lawmgt_get_display_name($data4));
																}
															}	
														 ?>
														<td class="added"><?php echo  esc_html(implode(", ",$case_assgined_to));?></td>						 
														<td><?php echo esc_html(get_the_title($retrieved_data->court_id)); ?> - <?php echo esc_html(get_the_title($retrieved_data->state_id)); ?> - <?php echo esc_html(get_the_title($retrieved_data->bench_id)); ?></td>	
														<td>
														<?php
														$obj_next_hearing_date=new MJ_lawmgt_Orders;
														$next_hearing_date= $obj_next_hearing_date->MJ_lawmgt_get_next_hearing_date_asc_by_case_id($case_id);
														$hearing_date_array=array();
														foreach($next_hearing_date as $data)
														{
															$hearing_date_array[]=esc_html(MJ_lawmgt_getdate_in_input_box($data->next_hearing_date));
														}
														echo implode(',</br>',$hearing_date_array);
														?>
														</td>	
														<td>
														<?php
														 if(!empty($retrieved_data->stages))
															{
																$stages=json_decode($retrieved_data->stages);
															}
															$increment = 0;
															if(!empty($stages))
															{
																foreach($stages as $data)
																{ 
																	$increment++;
																	 echo esc_html($increment);?>.<?php echo esc_html($data->value); ?>
																	<?php
																} 
															}
															?>	
														</td>															
													</tr>
											<?php 
												} 			
											} ?>     
										</tbody>  
									</table>
									<input type="submit" class="btn delete_margin_bottom btn-primary dawnlod_botttom" name="case_diary_excle_selected" value="<?php esc_attr_e('Export IN CSV File', 'lawyer_mgt' ) ;?> " />	
								</div>
							</div>	
							</form>	
						<?php	
						}
					if($active_tab == 'add_case')
					{
						$obj_case=new MJ_lawmgt_case;
						?>
						 <!-- Company POP up code -->
						<div class="popup-bg">
							<div class="overlay-content">
								<div class="modal-content">
									<div class="company_list">
									</div>  
									<div class="attorney_list">
									</div>	
									<div class="category_list">
									</div> 			
								</div>
							</div>     
						</div>
						<script type="text/javascript">
						var $ = jQuery.noConflict();
							jQuery(document).ready(function($)
							{
								"use strict"; 
								$('#case_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
								
								$('#birth_date').datepicker({
										changeMonth: true,
										changeYear: true,	        
										yearRange:'-65:+0',
										 endDate: '+0d',
										autoclose: true,
										onChangeMonthYear: function(year, month, inst) {
											$(this).val(month + "/" + year);
										}                    
								}); 	
								 
								var start = new Date();
								var end = new Date(new Date().setYear(start.getFullYear()+1));

								$('.date1').datepicker({
									autoclose: true
								}).on('changeDate', function(){
									$('.date2').datepicker('setStartDate', new Date($(this).val()));
								}); 

								$('.date2').datepicker({
									startDate : start,
									endDate   : end,
									autoclose: true
								}).on('changeDate', function(){
									$('.date1').datepicker('setEndDate', new Date($(this).val()));
								});	
								
								$('.date3').datepicker({
									startDate : start,
									endDate   : end,
									autoclose: true
								});
								/* $("#contact_name").multiselect({ 
									enableFiltering: true,
									enableCaseInsensitiveFiltering: true,
									nonSelectedText :'<?php esc_html_e('Select Client Name','lawyer_mgt');?>',
									 minSelectedItems: 1,
									 selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
									 includeSelectAllOption: true         
								 }); */
								 $('#contact_name').multiselect({
									templates: {
										li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>'
									},
									buttonWidth: '50%',
									nonSelectedText :'<?php esc_html_e('Select Client Name','lawyer_mgt');?>',
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
								 /* $("#assginedto").multiselect({ 
									enableFiltering: true,
									enableCaseInsensitiveFiltering: true,
									 nonSelectedText :'<?php esc_html_e('Select Attorney Name','lawyer_mgt');?>',
									 minSelectedItems: 1,
									 selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
									 includeSelectAllOption: true         
								 }); */
								  $('#assginedto').multiselect({
									templates: {
										li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>'
									},
									buttonWidth: '100%',
									nonSelectedText :'<?php esc_html_e('Select Attorney Name','lawyer_mgt');?>',
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
		 
								$("#stafflink_attorney").multiselect({ 
										nonSelectedText :'<?php esc_html_e('Select Attorney Name','lawyer_mgt');?>',
										selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
										includeSelectAllOption: true         
								 });
								 //user name not  allow space validation
								$('#username').keypress(function( e ) {
								   if(e.which === 32) 
									 return false;
								});		
								 $("#casesubmit").on("click",function()
								{	
									var checked = $(".multiselect_validation .dropdown-menu input:checked").length;

									if(!checked)
									{
										alert("<?php esc_html_e('Please select atleast one Client Name','lawyer_mgt');?>");
										return false;
									}			
								});
								
								// File extension validation
								$(function() 
								{ 
								    "use strict"; 
									$(".pdf_validation").change(function ()
									{
										if(MJ_lawmgt_fileExtValidate(this))
										{	    	
											 
										}    
									});
								
									var validExt = ".pdf";
									function MJ_lawmgt_fileExtValidate(fdata)
									{
										"use strict"; 
										 var filePath = fdata.value;
										 var getFileExt = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();
										 var pos = validExt.indexOf(getFileExt);
										 if(pos < 0)
										 {
											alert("<?php esc_html_e('Please Only upload PDF file....','lawyer_mgt');?>");
											fdata.value = '';	
											return false;
										  } else {
											return true;
										  }
									}
								});									 
								 //------ADD Attorney AJAX----------
								   $('#attorney_form').on('submit', function(e) 
								   {
								
									e.preventDefault();
									 
									var valid = $('#attorney_form').validationEngine('validate');
									
									if (valid == true) 
									{		 
										var form = new FormData(this);
										 
										$.ajax({
											type:"POST",
											url: $(this).attr('action'),
											data:form,
											cache: false,
											contentType: false,
											processData: false,
											success: function(data)
											{   
												   if(data!="")
												   { 
													var json_obj = $.parseJSON(data);
													$('#attorney_form').trigger("reset");
													$('#stafflink_attorney').append(json_obj);
													$('#stafflink_attorney').multiselect('rebuild');	
													$('.upload_user_avatar_preview').html('<img alt="" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">');
													$('.lmgt_user_avatar_url').val('');
													$('.modal').modal('hide');
												  }    
											},
											error: function(data){
											}
										})
									}
								});  
										
							});

							function MJ_lawmgt_add_reminder()
							{
								"use strict"; 
								$("#reminder_entry").append('<div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="SOL Reminders"><?php esc_html_e('SOL Reminders','lawyer_mgt');?></label><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback"><select name="casedata[type][]" id="case_reminder_type"><option selected="selected" value="mail"><?php esc_html_e('Mail','lawyer_mgt');?></option></select></div><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 doc_label has-feedback"><input id="remindertimevalue" class="form-control text-input validate[required]" type="number"  value="1" name="casedata[remindertimevalue][]" min="1"></div><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 doc_label has-feedback"><select name="casedata[remindertimeformat][]" id="case_reminder_type"><option selected="selected" value="day"><?php esc_html_e('Day(s)','lawyer_mgt');?></option><option value="hour"><?php esc_html_e('Hour(s)','lawyer_mgt');?></option></select></div><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Statute Of Limitations','lawyer_mgt');?></label><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger"></div></div>');   		
							}  	
							
							function MJ_lawmgt_deleteParentElement(n)
							{
								"use strict"; 
								alert("<?php esc_html_e('Do you really want to delete this record ?','lawyer_mgt');?>");
								n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
							}
													
							//Multiple Stages Add//
							function MJ_lawmgt_add_more_stages()
							{
								"use strict"; 
								$("#diagnosissnosis_div").append('<div class="form-group input"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label "><?php esc_html_e('Case Stages','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback"><textarea name="stages[]" rows="3"  class="validate[required] width_100_per_css" maxlength="150"></textarea></div><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger"></div></div>');
							}			
							 
							//Multiple Stages Add End//
							//add multiple opponents //
							"use strict"; 
							var value = 1;
							function MJ_lawmgt_add_opponents()
							{	
								"use strict"; 
								value++;
								
								$("#opponents_div").append('<div><div class="col-sm-2"></div><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10"><input  class="form-control has-feedback-left validate[custom[onlyLetterSp]] text-input" maxlength="50" type="text" placeholder="<?php esc_html_e('Enter Name','lawyer_mgt');?>" name="opponents[]"><span class="fa fa-user form-control-feedback left" aria-hidden="true"> </span> </div><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10"><input class="form-control has-feedback-left validate[custom[email]] text-input" type="text"  maxlength="50" name="opponents_email[]" placeholder="<?php esc_html_e('Enter Email','lawyer_mgt');?>"><span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span></div><div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 margin_bottom_10"><input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  class="form-control"  name="opponents_phonecode[]"></div><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 has-feedback margin_bottom_10"><input  class="form-control has-feedback-left validate[custom[phone]] text-input" type="number" min="0" onKeyPress="if(this.value.length==15) return false;"  name="opponents_mobile_number[]" placeholder="<?php esc_html_e('Enter Mobile No','lawyer_mgt');?>"><span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span></div><div class="col-sm-1 margin_bottom_10"><input type="button" value="<?php esc_html_e('Delete','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger"></div></div>');
							}  	
							
							//add multiple opponents Attorney//
							"use strict"; 
							var value = 1;
							function MJ_lawmgt_add_opponents_attorney()
							{	
								"use strict"; 
								value++;
								
								$("#opponents_attorney_div").append('<div><div class="col-sm-2"></div><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10"><input  class="form-control has-feedback-left validate[custom[onlyLetterSp]] text-input" maxlength="50" type="text" placeholder="<?php esc_html_e('Enter Name','lawyer_mgt');?>" name="opponents_attorney[]"><span class="fa fa-user form-control-feedback left" aria-hidden="true">  </span></div><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10"><input class="form-control has-feedback-left validate[custom[email]] text-input" type="text"  maxlength="50" name="opponents_attorney_email[]" placeholder="<?php esc_html_e('Enter Email','lawyer_mgt');?>"><span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span></div><div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 margin_bottom_10"><input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  class="form-control"  name="opponents_attorney_phonecode[]"></div><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 has-feedback margin_bottom_10"><input  class="form-control has-feedback-left validate[custom[phone]] text-input" type="number" min="0" onKeyPress="if(this.value.length==15) return false;"  name="opponents_attorney_mobile_number[]" placeholder="<?php esc_html_e('Enter Mobile No','lawyer_mgt');?>"><span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span></div><div class="col-sm-1 margin_bottom_10"><input type="button" value="<?php esc_html_e('Delete','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger"></div></div>');
							}
							function MJ_lawmgt_deleteParentElement(n)
							{
								"use strict"; 
								alert("<?php esc_html_e('Do you really want to delete this ?','lawyer_mgt');?>");
								n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);				
							}
						</script>
						<?php					
						if($active_tab == 'add_case')
						{						 
							$case_id=0;
							$edit=0;
							if(isset($_REQUEST['case_id']))
								$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
								{					
									$edit=1;
									$case_info = $obj_case->MJ_lawmgt_get_single_case($case_id);	
														
								}
								?>
						
							<div class="panel-body">
								<form name="case_form" action="" method="post" class="form-horizontal" id="case_form" enctype='multipart/form-data'>	
									 <?php $action = sanitize_text_field(isset($_REQUEST['action'])?sanitize_text_field($_REQUEST['action']):'insert');?>
									<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
									<input type="hidden" name="case_id" value="<?php echo esc_attr($case_id);?>"  />
									<div class="header">	
										<h3 class="first_hed"><?php esc_html_e('Case Information','lawyer_mgt');?></h3>
										<hr>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Case Name','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="case_name" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]
											text-input " type="text" placeholder="<?php esc_html_e('Enter Case Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($case_info->case_name);}elseif(isset($_POST['case_name'])){ echo esc_attr($_POST['case_name']); } ?>" name="case_name">
											<span class="fa fa-briefcase form-control-feedback left" aria-hidden="true"></span>
										</div>
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_number"><?php esc_html_e('Case Number','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input type="hidden" name="edit_case_number" value="<?php if($edit){ echo esc_attr($case_info->case_number);}?>">
											<input id="case_number" class="form-control has-feedback-left validate[required,custom[popup_category_validation]],maxSize[15]] text-input" placeholder="<?php esc_html_e('Enter Case Number','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($case_info->case_number);}elseif(isset($_POST['case_number'])){ echo esc_attr($_POST['case_number']); } ?>" name="case_number" min="1">
											<span class="fa fa-sort-numeric-down form-control-feedback left" aria-hidden="true"></span>
										</div>			
									</div>
									<?php wp_nonce_field( 'save_case_nonce' ); ?>
									<div class="form-group">		
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin" for="open_date"><?php esc_html_e('Open Date','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="open_date"  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date1 form-control has-feedback-left validate[required]" type="text"  name="open_date"  placeholder="<?php esc_html_e('Select Open Date','lawyer_mgt');?>"
											value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($case_info->open_date));}elseif(isset($_POST['open_date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['open_date'])); } ?>" readonly>
											<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
											<span id="inputSuccess2Status2" class="sr-only"><?php esc_html_e('(success)','lawyer_mgt');?></span>
										</div>
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="statute_of_limitations"><?php esc_html_e('Statute Of Limitations','lawyer_mgt');?><span class="require-field">*</span></label>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
												<input id="statute_of_limitations"  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date2 form-control has-feedback-left validate[required]" type="text"  name="statute_of_limitations"  placeholder="<?php esc_html_e('Select Statute Of Limitations','lawyer_mgt');?>"
												value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($case_info->statute_of_limitations));}elseif(isset($_POST['statute_of_limitations'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['statute_of_limitations'])); } ?>" readonly>
												<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
												<span id="inputSuccess2Status2" class="sr-only">(success)</span>
											</div> 
									</div>
									<div class="form-group">
										
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="priority"><?php esc_html_e('Priority','lawyer_mgt');?> </label>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">			
												<select class="form-control" name="priority" id="priority">
												<?php 
												if($edit)
												{
													$priority =esc_html($case_info->priority);
												}							
												else
												{							
													$priority = "";
												}
												?>
													<option value="high" <?php echo selected($priority,'high');?>><?php esc_html_e('High','lawyer_mgt');?></option>
													<option value="medium" <?php echo selected($priority,'medium');?>><?php esc_html_e('Medium','lawyer_mgt');?></option>
													<option value="low" <?php echo selected($priority,'low');?>><?php esc_html_e('Low','lawyer_mgt');?></option>
												</select>				
											</div>
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="practice_area"><?php esc_html_e('Practice Area','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">			
											<select class="form-control validate[required]" name="practice_area" id="practice_area_name">
											<option value=""><?php esc_html_e('Select Area','lawyer_mgt');?></option>
											<?php 
											 if($edit)
												$practice_area =esc_html($case_info->practice_area_id);				
											else 
												$practice_area = "";
									
											$obj_practicearea=new MJ_lawmgt_practicearea;
											$result=$obj_practicearea->MJ_lawmgt_get_all_practicearea();	
											if(!empty($result))
											{
												foreach ($result as $retrive_data)
												{ 		 	
												?>
													<option value="<?php echo esc_attr($retrive_data->ID);?>" <?php selected($practice_area,$retrive_data->ID);  ?>><?php echo esc_html($retrive_data->post_title); ?> </option>
												<?php }
											} 
											?> 
											</select>				
										</div>
										<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
											<button type="button" id="addremovearea" class="btn btn-success btn_margin width_130" model="activity_practicearea"><?php esc_attr_e('Add Or Remove','lawyer_mgt');?></button>			
										</div>
									</div>
									<div class="form-group">		
										
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="case_description"><?php esc_html_e('Case Description','lawyer_mgt');?></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<textarea rows="3"  name="case_description" class="validate[custom[address_description_validation],maxSize[150]] width_100_per_css"  id="case_description"><?php if($edit){ echo esc_textarea($case_info->case_description);}elseif(isset($_POST['case_description'])){ echo esc_textarea($_POST['case_description']); } ?></textarea>				
										</div>	
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="earlier history"><?php esc_html_e('Crime Details','lawyer_mgt');?></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<textarea rows="3" class="validate[custom[popup_category_validation]],maxSize[150]] width_100_per_css" name="crime_details"  id="crime_details" ><?php if($edit){ echo esc_textarea($case_info->crime_details);}elseif(isset($_POST['crime_details'])){ echo esc_textarea($_POST['crime_details']); } ?></textarea>				
										</div>	
									</div>	
									<!---COURT DETAIL---->
									<div class="form-group">	
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin" for="court_id"><?php esc_html_e('Court Name','lawyer_mgt');?><span class="require-field">*</span></label>
										
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">			
											<select class="form-control courttostate validate[required]" name="court_id" id="courttostate">
											<option value=""><?php esc_html_e('Select Court','lawyer_mgt');?></option>
												<?php 
												if($edit)
												{
													$category =esc_html($case_info->court_id);
												}
												else 
												{
													$category = get_option( 'lmgt_default_court' );	
												}
												$court_category=MJ_lawmgt_get_all_category('court_category');
												if(!empty($court_category))
												{
													foreach ($court_category as $retrive_data)
													{
														echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected($category,$retrive_data->ID).'>'.esc_html($retrive_data->post_title).'</option>';
													}
												} 
												?>
											</select>
										</div>
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="activity_category"><?php esc_html_e('State Name','lawyer_mgt');?><span class="require-field">*</span></label>
										 
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">	
												<select class="form-control validate[required] state_to_bench court_by_state" name="state_id" id="state_to_bench">
													<option value=""><?php esc_html_e('Select State','lawyer_mgt');?></option>
													<?php 
													if($edit)
													{
														$court_id =$case_info->court_id;
														$stateid =$case_info->state_id;
														
														global $wpdb;
														$table_court = $wpdb->prefix.'lmgt_court';
							
														$result = $wpdb->get_results("SELECT * FROM $table_court where deleted_status=0 AND court_id=".$court_id);
														
														if(!empty($result))
														{
															foreach($result as $data)
															{
															 $state_id=$data->state_id;
															 $latest_posts = get_post($state_id);
															 
															 echo '<option value="'.esc_attr($latest_posts->ID).'" '.selected($stateid,$latest_posts->ID).'>'.esc_html($latest_posts->post_title).'</option>';
															}
														}
													}
													else
													{
														$default_court_id = get_option( 'lmgt_default_court' );	
														global $wpdb;
														$table_court = $wpdb->prefix.'lmgt_court';
							
														$result = $wpdb->get_results("SELECT * FROM $table_court where deleted_status=0 AND court_id=".$default_court_id);
														
														if(!empty($result))
														{
															foreach($result as $data)
															{
																$state_id=$data->state_id;
																$latest_posts = get_post($state_id);
															 
																echo '<option value="'.esc_attr($latest_posts->ID).'">'.esc_html($latest_posts->post_title).'</option>';
															}	
														}
													}
													?>							
												</select>
											</div>											
									</div>
									 
									<!---Bench DETAIL---->
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin" for="activity_category"><?php esc_html_e('Bench Name','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">	
											<select class="form-control validate[required] state_by_bench" name="bench_id">
													<option value=""><?php esc_html_e('Select Bench','lawyer_mgt');?></option>
													<?php 
													 
													if($edit)
													{
														$state_id =$case_info->state_id;
														$benchid =$case_info->bench_id;
														
														global $wpdb;
														$table_court = $wpdb->prefix.'lmgt_court';
							
														$result = $wpdb->get_results("SELECT * FROM $table_court where deleted_status=0 AND state_id=".$state_id);
														
														$bench_id=$result[0]->bench_id;
														if(!empty($bench_id))
														{
															$bench_id_array=explode(',',$bench_id);
														}
														else
														{
															$bench_id_array='';
														}													
														if(!empty($bench_id_array))
														{	
															foreach($bench_id_array as $data)
															{
																$latest_posts = get_post($data);
																echo '<option value="'.esc_attr($latest_posts->ID).'" '.selected($benchid,$latest_posts->ID).'>'.esc_html($latest_posts->post_title).'</option>';
															} 
														}
													}
													?>					
											</select>
										</div>	<!---Bench DETAIL END---->
										 <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" ><?php esc_html_e('Court Hall No','lawyer_mgt');?></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input class="form-control has-feedback-left  text-input validate[custom[number],maxSize[6]]" type="number"  placeholder="<?php esc_html_e('Enter Court Hall No','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($case_info->court_hall_no);}elseif(isset($_POST['court_hall_no'])){ echo esc_attr($_POST['court_hall_no']); } ?>" name="court_hall_no">
											<span class="fa fa-sort-numeric-down form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>
									<div class="form-group">
										
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" ><?php esc_html_e('Floor','lawyer_mgt');?></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input class="form-control has-feedback-left  text-input validate[custom[number],maxSize[6]]" type="number"   placeholder="<?php esc_html_e('Enter Floor No','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($case_info->floor);}elseif(isset($_POST['floor'])){ echo esc_attr($_POST['floor']); } ?>" name="floor">
											<span class="fa fa-sort-numeric-down form-control-feedback left" aria-hidden="true"></span>
										</div>
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " ><?php esc_html_e('Crime No of Police Station','lawyer_mgt');?></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input class="form-control has-feedback-left  text-input validate[custom[popup_category_validation]],maxSize[50]]"  type="text" placeholder="<?php esc_html_e('Enter Crime No of Police Station','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($case_info->crime_no);}elseif(isset($_POST['crime_no'])){ echo esc_attr($_POST['crime_no']); } ?>" name="crime_no">
											<span class="fa fa-briefcase form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>
									<div class="form-group">
										
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" ><?php esc_html_e('FIR No','lawyer_mgt');?></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input class="form-control has-feedback-left  text-input validate[custom[popup_category_validation]],maxSize[30]]" type="text" placeholder="<?php esc_html_e('Enter FIR No','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($case_info->fri_no);}elseif(isset($_POST['fri_no'])){ echo esc_attr($_POST['fri_no']); } ?>" name="fri_no">
											<span class="fa fa-sort-numeric-down form-control-feedback left" aria-hidden="true"></span>
										</div>

											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Classification"><?php esc_html_e('Classification','lawyer_mgt');?></label>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
												<input id="classification" class="form-control text-input validate[custom[onlyLetter_specialcharacter],maxSize[50]] "  type="text" placeholder="<?php esc_html_e('Enter Classification','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($case_info->classification);}elseif(isset($_POST['classification'])){ echo esc_attr($_POST['classification']); } ?>" name="classification">
											</div>
									</div>
									<div class="form-group">												
										
										<?php 
											if($edit == 0)
											{	?>
											 
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="open_date"><?php esc_html_e('First Hearing Date','lawyer_mgt');?><span class="require-field">*</span></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input id="first_hearing_date"  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date3 form-control has-feedback-left validate[required]" type="text"  name="first_hearing_date"  placeholder="<?php esc_html_e('Select First Hearing Date','lawyer_mgt');?>"
													value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($case_info->first_hearing_date)) ; }elseif(isset($_POST['first_hearing_date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['first_hearing_date'])); } ?>" readonly>
													<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
													 
												</div>
											 
										<?php  } ?>	
									</div>
									<div class="form-group">	
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin" for="earlier history"><?php esc_html_e('Earlier Court History','lawyer_mgt');?></label>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
												<textarea rows="3" class="validate[custom[address_description_validation],maxSize[150]] width_100_per_css" name="earlier_history" id="earlier_history" ><?php if($edit){ echo esc_textarea($case_info->earlier_history);}elseif(isset($_POST['earlier_history'])){ echo esc_textarea($_POST['earlier_history']); } ?></textarea>
											</div>	
									</div>
									<?php
									   if($edit)
										{ ?>
										<div id="diagnosissnosis_div">
									<?php
											if(!empty($case_info->stages))
											{
												$stages=json_decode($case_info->stages);
												 
											}
											if(!empty($stages))
											{
												foreach($stages as $data)
												{ 
												?>
													<div class="form-group input">
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label "><?php esc_html_e('Case Stages','lawyer_mgt');?><span class="require-field">*</span></label>
														<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
															<textarea name="stages[]" rows="3" class=" width_100_per_cssvalidate[required,custom[address_description_validation],maxSize[150]]" ><?php echo esc_textarea($data->value); ?></textarea>
														</div>
													</div>
												<?php
												}
											} 
											else
											{
											?>
												<div class="form-group">
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label "><?php esc_html_e('Case Stages','lawyer_mgt');?><span class="require-field">*</span></label>
													<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
														<textarea name="stages[]" rows="3" class=" width_100_per_css validate[required,custom[address_description_validation],maxSize[150]]" ></textarea>
													</div>
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger"></div>	
												</div>
												
											<?php
											}	
											?>
										</div>
										<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
											<input type="button" value="<?php esc_html_e('Add Case Stages','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_more_stages()" class="add_more_stages btn btn-success">
										</div>	
										<?php
										}
									   else
										{ ?>
										
											<div id="diagnosissnosis_div">	
												<div class="form-group">
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label "><?php esc_html_e('Case Stages','lawyer_mgt');?><span class="require-field">*</span></label>
													<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
														<textarea name="stages[]" rows="3"  class=" width_100_per_css validate[required,custom[address_description_validation],maxSize[150]]" ></textarea>
													</div>
												</div>
											</div>
											
											<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12 mt_10">
														<input type="button" value="<?php esc_html_e('Add Case Stages','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_more_stages()" class="add_more_stages btn btn-success">
											</div>
								<?php   } ?>
																
									<?php
									if($edit)
									{
										$result_reminder=$obj_case->MJ_lawmgt_get_single_case_reminder($case_id);					
										if(!empty($result_reminder))	
										{	
											foreach ($result_reminder as $retrive_data)
											{ 
											?>	
												<div id="reminder_entry">
													<div class="form-group">			
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="SOL Reminders"><?php esc_html_e('SOL Reminders','lawyer_mgt');?></label>
														<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
															<input type="hidden" name="casedata[id][]" value="<?php echo $retrive_data->id;?>">
															<select name="casedata[type][]" id="case_reminder_types">
																<option selected="selected" value="mail" <?php if($retrive_data=='mail') { print ' selected'; }?>><?php echo esc_html($retrive_data->reminder_type);?></option>
															</select>
														</div>
														<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 doc_label has-feedback">
														<input id="remindertimevalue" class="form-control text-input validate[required]" type="number"  value="<?php echo esc_attr($retrive_data->reminder_time_value);?>" name="casedata[remindertimevalue][]" min="1">
														</div>
														<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 doc_label has-feedback">
														<select name="casedata[remindertimeformat][]" id="case_reminder_type">
															<?php 
																$reminder_value=esc_html($retrive_data->reminder_time_format);
																?>
																<option value="day" <?php if($reminder_value=='day') { print ' selected'; }?>><?php esc_html_e('Day(s)','lawyer_mgt'); ?></option>
																<option value="hour" <?php if($reminder_value=='hour') { print ' selected'; }?>><?php esc_html_e('Hour(s)','lawyer_mgt'); ?></option>																
														</select>
														</div>
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Statute Of Limitations','lawyer_mgt') ?></label>
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
															<input type="button" value="<?php esc_attr_e('Remove','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger">
														</div>				
													</div>		
												</div>	
											<?php				
											}
										}
										else
										{
										?>
											 <div id="reminder_entry">
											 </div>
										<?php
										}	
										?>
										<div class=" offset-md-2 col-md-10">
											<input type="button" value="<?php esc_attr_e('Add Reminder','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_reminder()" class="add_reminder btn btn-success">
										</div>		
									<?php		
									}
									else
									{
									?>
										<div id="reminder_entry">
											<div class="form-group">	
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="SOL Reminders"><?php esc_html_e('SOL Reminders','lawyer_mgt');?></label>
												<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
													<select name="casedata[type][]" id="case_reminder_types">
														<option selected="selected" value="mail"><?php esc_html_e('Mail','lawyer_mgt') ?></option>
													</select>
												</div>
												<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 doc_label has-feedback">
												<input id="remindertimevalue" class="form-control text-input validate[required]" type="number"  value="1" name="casedata[remindertimevalue][]" min="1">
												</div>
												<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 doc_label has-feedback">
												<select name="casedata[remindertimeformat][]" id="case_reminder_type">
													<option selected="selected" value="day"><?php esc_html_e('Day(s)','lawyer_mgt') ?></option>
													<option value="hour"><?php esc_html_e('Hour(s)','lawyer_mgt') ?></option>													
												</select>
												</div>
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Statute Of Limitations','lawyer_mgt') ?></label>
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
													<input type="button" value="<?php esc_attr_e('Remove','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger">
												</div>		
											</div>		
										</div>				  
										<div class=" offset-md-2 col-md-10">
											<input type="button" value="<?php esc_attr_e('Add Reminder','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_reminder()" class="add_reminder btn btn-success">
										</div>	
									<?php 
									}?>
									<div class="form-group">		
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="referred_by"><?php esc_html_e('Referred By','lawyer_mgt');?> </label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<input id="referred_by" class="form-control has-feedback-left  validate[custom[onlyLetter_specialcharacter]],maxSize[50]] text-input" type="text" placeholder="<?php esc_html_e('Enter Referred Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($case_info->referred_by); }elseif(isset($_POST['referred_by'])){ echo esc_attr($_POST['referred_by']); } ?>" name="referred_by">
											<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>
									  <!-- Custom Fields Data -->	
							<script type="text/javascript">
							    var $ = jQuery.noConflict();
								jQuery("document").ready(function($)
								{			
									"use strict"; 
									//space validation
									$('.space_validation').keypress(function( e ) 
									{
									   if(e.which === 32) 
										 return false;
									});									
									//custom field datepicker
									$('.after_or_equal').datepicker({
										dateFormat: "yy-mm-dd",										
										minDate:0,
										beforeShow: function (textbox, instance) 
										{
											instance.dpDiv.css({
												marginTop: (-textbox.offsetHeight) + 'px'                   
											});
										}
									}); 
									$('.date_equals').datepicker({
										dateFormat: "yy-mm-dd",
										minDate:0,
										maxDate:0,										
										beforeShow: function (textbox, instance) 
										{
											instance.dpDiv.css({
												marginTop: (-textbox.offsetHeight) + 'px'                   
											});
										}
									}); 
									$('.before_or_equal').datepicker({
										dateFormat: "yy-mm-dd",
										maxDate:0,
										beforeShow: function (textbox, instance) 
										{
											instance.dpDiv.css({
												marginTop: (-textbox.offsetHeight) + 'px'                   
											});
										}
									}); 
								});
								//Custom Field File Validation//
								function MJ_lawmgt_custom_filed_fileCheck(obj)
								{	
									"use strict"; 
									var fileExtension = $(obj).attr('file_types');
									var fileExtensionArr = fileExtension.split(',');
									var file_size = $(obj).attr('file_size');
									
									var sizeInkb = obj.files[0].size/1024;
									
									if ($.inArray($(obj).val().split('.').pop().toLowerCase(), fileExtensionArr) == -1)
									{										
										alert("<?php esc_html_e('Only','wpnc');?> "+fileExtension+" <?php esc_html_e('formats are allowed.','wpnc');?>");
										$(obj).val('');
									}	
									else if(sizeInkb > file_size)
									{										
										alert("<?php esc_html_e('Only','wpnc');?> "+file_size+" <?php esc_html_e('kb size is allowed.','wpnc');?>");
										$(obj).val('');	
									}
								}
								//Custom Field File Validation//
							</script>
							<?php
							//Get Module Wise Custom Field Data
							$custom_field_obj =new MJ_lawmgt_custome_field;
							
							$module='case';	
							if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
							{ 
								$compact_custom_field=$custom_field_obj->MJ_lawmgt_getCustomFieldByModule($module);
							}
							else
							{
								$compact_custom_field='';
							}
							if(!empty($compact_custom_field))
							{
								?>		
								<div class="header">
									<h3><?php esc_html_e('Custom Fields','lawyer_mgt');?></h3>
									<hr>
								</div>						
								 
										<?php
										foreach($compact_custom_field as $custom_field)
										{
											if($edit)
											{
												$custom_field_id=$custom_field->id;
												$module_record_id=$case_id;
												
												$custom_field_value=$custom_field_obj->MJ_lawmgt_get_single_custom_field_meta_value($module,$module_record_id,$custom_field_id);
											}
											
											// Custom Field Validation // 
											$exa = explode('|',$custom_field->field_validation);
										 
											$min = "";
											$max = "";
											$required = "";
											$red = "";
											$limit_value_min = "";
											$limit_value_max = "";
											$numeric = "";
											$alpha = "";
											$space_validation = "";
											$alpha_space = "";
											$alpha_num = "";
											$email = "";
											$url = "";
											$minDate="";
											$maxDate="";
											$file_types="";
											$file_size="";
											$datepicker_class="";
											foreach($exa as $key=>$value)
											{
												if (strpos($value, 'min') !== false)
												{
												   $min = $value;
												   $limit_value_min = substr($min,4);
												}
												elseif(strpos($value, 'max') !== false)
												{
												   $max = $value;
												   $limit_value_max = substr($max,4);
												}
												elseif(strpos($value, 'required') !== false)
												{
													$required="required";
													$red="*";
												}
												elseif(strpos($value, 'numeric') !== false)
												{
													$numeric="number";
												}
												elseif($value == 'alpha')
												{
													$alpha="onlyLetterSp";
													$space_validation="space_validation";
												}
												elseif($value == 'alpha_space')
												{
													$alpha_space="onlyLetterSp";
												}
												elseif(strpos($value, 'alpha_num') !== false)
												{
													$alpha_num="onlyLetterNumber";
												}
												elseif(strpos($value, 'email') !== false)
												{
													$email = "email";
												}
												elseif(strpos($value, 'url') !== false)
												{
													$url="url";
												}
												elseif(strpos($value, 'after_or_equal:today') !== false )
												{
													$minDate=1;
													$datepicker_class='after_or_equal';
												}
												elseif(strpos($value, 'date_equals:today') !== false )
												{
													$minDate=$maxDate=1;
													$datepicker_class='date_equals';
												}
												elseif(strpos($value, 'before_or_equal:today') !== false)
												{	
													$maxDate=1;
													$datepicker_class='before_or_equal';
												}	
												elseif(strpos($value, 'file_types') !== false)
												{	
													$types = $value;													
												   
													$file_types=substr($types,11);
												}
												elseif(strpos($value, 'file_upload_size') !== false)
												{	
													$size = $value;
													$file_size=substr($size,17);
												}
											}
											$option =$custom_field_obj->MJ_lawmgt_getDropDownValue($custom_field->id);
											 
											$data = 'custom.'.$custom_field->id;
											$datas = 'custom.'.$custom_field->id;											
											
											if($custom_field->field_type =='text')
											{
												?>	
												 
												<div class="form-group">	
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="<?php echo $custom_field->id; ?>"><?php echo ucwords(esc_html__($custom_field->field_label)); ?><span class="required red"><?php echo $red; ?></span></label>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
														<input class="form-control hideattar<?php echo $custom_field->form_name; ?> validate[<?php if(!empty($required)){ echo $required; ?>,<?php } ?><?php if(!empty($limit_value_min)){ ?> minSize[<?php echo $limit_value_min; ?>],<?php } if(!empty($limit_value_max)){ ?> maxSize[<?php echo $limit_value_max; ?>],<?php } if($numeric != '' || $alpha != '' || $alpha_space != '' || $alpha_num != '' || $email != '' || $url != ''){ ?> custom[<?php echo $numeric; echo $alpha; echo $alpha_space; echo $alpha_num; echo $email; echo $url; ?>]<?php } ?>] <?php echo $space_validation; ?>" type="text" name="custom[<?php echo $custom_field->id; ?>]" id="<?php echo $custom_field->id; ?>" label="<?php echo $custom_field->field_label; ?>" <?php if($edit){ ?> value="<?php echo esc_attr($custom_field_value); ?>" <?php } ?>>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
													</div>
	                                            </div>
	                                                 
												<?php
											}
											elseif($custom_field->field_type =='textarea')
											{
												?>
												<div class="form-group">	
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label "><?php echo esc_html__($custom_field->field_label); ?><span class="required red"><?php echo $red; ?></span></label>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
														<textarea rows="3"
															class="form-control hideattar<?php echo $custom_field->form_name; ?> validate[<?php if(!empty($required)){ echo $required; ?>,<?php } ?><?php if(!empty($limit_value_min)){ ?> minSize[<?php echo $limit_value_min; ?>],<?php } if(!empty($limit_value_max)){ ?> maxSize[<?php echo $limit_value_max; ?>],<?php } if($numeric != '' || $alpha != '' || $alpha_space != '' || $alpha_num != '' || $email != '' || $url != ''){ ?> custom[<?php echo $numeric; echo $alpha; echo $alpha_space; echo $alpha_num; echo $email; echo $url; ?>]<?php } ?>] <?php echo $space_validation; ?>" 
															name="custom[<?php echo $custom_field->id; ?>]" 
															id="<?php echo $custom_field->id; ?>"
															label="<?php echo $custom_field->field_label; ?>"
															><?php if($edit){ echo esc_attr($custom_field_value); } ?></textarea>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
													</div>
	                                            </div>
												<?php 
											}
											elseif($custom_field->field_type =='date')
											{
												?>	
												<div class="form-group">
													 <label for="bdate" class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php echo ucwords(esc_html__($custom_field->field_label)); ?><span class="required red"><?php echo $red; ?></span></label>
												 
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
														<input class="form-control error custom_datepicker <?php echo $datepicker_class; ?>hideattar<?php echo $custom_field->form_name; ?> <?php if(!empty($required)){ ?> validate[<?php echo $required; ?>] <?php } ?>"name="custom[<?php echo $custom_field->id; ?>]"<?php if($edit){ ?> value="<?php echo esc_attr($custom_field_value); ?>" <?php } ?>id="<?php echo $custom_field->id; ?>" label="<?php echo $custom_field->field_label; ?>">
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
													</div>
	                                            </div>
												 	
												<?php 
											}
											elseif($custom_field->field_type =='dropdown')
											{
												?>	
												<div class="form-group">
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="<?php echo esc_html__($custom_field->id); ?>"><?php echo ucwords($custom_field->field_label); ?><span class="required red"><?php echo $red; ?></span></label>
													  
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
														<select class="form-control hideattar<?php echo $custom_field->form_name; ?> 
														<?php if(!empty($required)){ ?> validate[<?php echo $required; ?>] <?php } ?>" name="custom[<?php echo $custom_field->id; ?>]"	id="<?php echo $custom_field->id; ?>" label="<?php echo $custom_field->field_label; ?>"
														>
															<?php
															if(!empty($option))
															{															
																foreach ($option as $options)
																{
																	?>
																	<option value="<?php echo esc_attr($options->option_label); ?>" <?php if($edit){ echo selected($custom_field_value,$options->option_label); } ?>> <?php echo ucwords(esc_html($options->option_label)); ?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
													</div>
	                                            </div>
												 
												<?php 
											}
											elseif($custom_field->field_type =='checkbox')
											{
												?>	
													<div class="form-group">
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php echo ucwords(esc_html__($custom_field->field_label)); ?><span class="required red"><?php echo $red; ?></span></label>
													 
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
															<?php
															if(!empty($option))
															{
																foreach ($option as $options)
																{ 
																	if($edit)
																	{
																		$custom_field_value_array=explode(',',$custom_field_value);
																	}
																	?>	
																	<div class="d-inline-block custom-control custom-checkbox mr-1">
																		<input type="checkbox" value="<?php echo esc_attr($options->option_label); ?>"  <?php if($edit){  echo checked(in_array($options->option_label,$custom_field_value_array)); } ?> class="custom-control-input hideattar<?php echo $custom_field->form_name; ?>" name="custom[<?php echo $custom_field->id; ?>][]" >
																		<label class="custom-control-label" for="colorCheck1"><?php echo esc_html($options->option_label); ?></label>
																	</div>
																	<?php
																}
															}
															?>
														</div>
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
														</div>
													</div>
												<?php 
											}
											elseif($custom_field->field_type =='radio')
											{
												?>
												
												<div class="form-group">
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php echo ucwords(esc_html__($custom_field->field_label)); ?><span class="required red"><?php echo $red; ?></span></label>
														
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
															<?php
															if(!empty($option))
															{
																foreach ($option as $options)
																{
																	?>
																	<input type="radio"  value="<?php echo esc_attr($options->option_label); ?>" <?php if($edit){ echo checked( $options->option_label, $custom_field_value); } ?> name="custom[<?php echo $custom_field->id; ?>]"  class="custom-control-input hideattar<?php echo $custom_field->form_name; ?> error " id="<?php echo $options->option_label; ?>">
																	
																	<label class="custom-control-label mr-1" for="<?php echo $options->option_label; ?>"><?php echo esc_html($options->option_label); ?></label>
																	<?php
																}
															}
															?>
														</div>
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
														</div>
													</div>
												<?php
											}
											elseif($custom_field->field_type =='file')
											{
												?>	
												<div class="form-group">
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php echo ucwords(esc_html__($custom_field->field_label)); ?><span class="required red"><?php echo $red; ?></span></label>
													 
													<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
														<input type="file"  onchange="MJ_lawmgt_custom_filed_fileCheck(this);" Class="hideattar<?php echo $custom_field->form_name; if($edit){ if(!empty($required)){ if($custom_field_value==''){ ?> validate[<?php echo $required; ?>] <?php } } }else{ if(!empty($required)){ ?> validate[<?php echo $required; ?>] <?php } } ?>" name="custom_file[<?php echo $custom_field->id; ?>]" <?php if($edit){ ?> value="<?php echo esc_attr($custom_field_value); ?>" <?php } ?> id="<?php echo $custom_field->id; ?>" file_types="<?php echo $file_types; ?>" file_size="<?php echo $file_size; ?>">
														<p><?php esc_html_e('Please upload only ','wpnc'); echo $file_types; esc_html_e(' file','wpnc');?> </p>
													</div>
														<input type="hidden" name="hidden_custom_file[<?php echo $custom_field->id; ?>]" value="<?php if($edit){ echo $custom_field_value; } ?>">
														<label class="label_file"><?php if($edit){ echo esc_html($custom_field_value); } ?></label>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
													</div>
	                                            </div>
											<?php
											}
										}	
										?>	 
							<?php
							}
							?>
									 	
									<div class="header">	
										<h3 class="first_hed"><?php esc_html_e('Attorney & Client Link','lawyer_mgt');?></h3>
										<hr>
									</div>
									<div class="form-group">
											<p class="offset-md-2 col-md-10 font_weight_600_css"><?php esc_html_e('Which attorneys and clients  should be linked to this case?','lawyer_mgt');?></p>
									</div>
									
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="assginedto"><?php esc_html_e('Assigned To Attorney','lawyer_mgt');?><span class="require-field">*</span></label>
										
											<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 multiselect_validation">			
												<select class="form-control case_assgined_to assginedto validate[required]" multiple="multiple" name="assginedto[]" id="assginedto">
												 
												<?php 
												 if($edit)
												 {
													$assginedto =$case_info->case_assgined_to;
												 }							
												else 
												{
													$assginedto = "";
												}
												
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
												 
												if(!empty($attorney))
												{
													foreach ($attorney as $retrive_data)
													{ 		 	
													?>
														<option value="<?php print esc_attr($retrive_data->ID); ?>" <?php echo in_array($retrive_data->ID,explode(',',$assginedto)) ? 'selected': ''; ?>>
															<?php echo esc_html($retrive_data->display_name);?>
														</option>
													<?php 
													}
												} 
												?> 
												</select>				
											</div>
											 
										<div class="form-group">
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="contact_name"><?php esc_html_e('Client Name','lawyer_mgt');?><span class="require-field">*</span></label>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 multiselect_validation">						
												<select name="contact_name[]" multiple="multiple" id="contact_name" class="contactlist_by_company contact_name_data form-control validate[required]">   
													<?php
														if($edit)
														{		
														  global $wpdb;
															$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
															$result = $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
															
															if(!empty($result))
															{
																$select_user_id=array();
																
																foreach ($result as $data)
																{ 							
																	$select_user_id[]=esc_html($data->user_id);
																}								
															}
														}
														else
														{
															$select_user_id[]="";
														}
														$contactdata=get_users(array('role' => 'client',
																	'meta_query' =>array( 
																			array(
																					'key' => 'archive',
																					'value' =>0,
																					'compare' => '='
																				)
																		)	
																	)
																);
																if(!empty($contactdata))
                                                                {
																	foreach($contactdata as $retrive_data)
																	{  				
																	?>						
																		<option value="<?php echo esc_attr($retrive_data->ID);?>" <?php if(in_array($retrive_data->ID,$select_user_id)) { print "selected"; }?>><?php echo esc_html($retrive_data->display_name);?> </option>						
																	<?php 
																	}
																}
														?> 			
												</select>
											</div>
										</div>
									</div>
									<div class="header">	
										<h3 class="first_hed"><?php esc_html_e('Billing Information','lawyer_mgt');?></h3>
										<hr>
									</div>
									<div class="form-group">
											<p class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12 font_weight_600_css"><?php esc_html_e('Which Client will be the billing point of contact for this case?','lawyer_mgt');?></p>
									<div class="form-group">		
									</div>
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="billing_contact"><?php esc_html_e('Billing Client Name','lawyer_mgt');?><span class="require-field">*</span></label>
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
										<select class="form-control billing_contactlist_by_company validate[required]" name="billing_contact" id="billing_contact_data">	
										<option value=""><?php esc_html_e('Select Client Name','lawyer_mgt');?></option>
										<?php
											if($edit)
											{					
												$select_billing_id=$case_info->billing_contact_id;
											}
											else
											{
												$select_billing_id="";
											}
												 
												$contactdata=get_users(array('role' => 'client',
																	'meta_query' =>array( 
																			array(
																					'key' => 'archive',
																					'value' =>0,
																					'compare' => '='
																				)
																		)	
																	)
																);
													if(!empty($contactdata))
                                                    {
														foreach($contactdata as $retrive_data)
														{  				
													    ?>						
															<option value="<?php echo esc_attr($retrive_data->ID);?>" <?php selected($retrive_data->ID,$select_billing_id) ?>><?php echo esc_html($retrive_data->display_name);?> </option>
													    <?php
													    }	
													}
											?> 			
									</select>
									</div>
									</div>
									<div class="form-group">
										<p class="offset-md-2 col-md-10 font_weight_600_css"><?php esc_html_e('How should this case be billed?','lawyer_mgt');?></p>
									</div>
									<div class="form-group">		
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="billing_type"><?php esc_html_e('Billing Type','lawyer_mgt');?></label>
										<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
										<select class="form-control" name="billing_type" id="billing_type">		
										<option value=""><?php esc_html_e('Select Billing Type','lawyer_mgt');?></option>
												 <?php if($edit)
												$billing_type =$case_info->billing_type;					
											else 
												 $billing_type = ""; 
											 ?>
											<option value="hourly" <?php if($billing_type == 'hourly') echo 'selected = "selected"';?>><?php esc_html_e('Hourly','lawyer_mgt');?></option>
											<option value="contingency" <?php  if($billing_type == 'contingency') echo 'selected = "selected"';  ?>><?php esc_html_e('Contingency','lawyer_mgt');?></option>
											<option value="flat" <?php   if($billing_type == 'flat') echo 'selected = "selected"';  ?>><?php esc_html_e('Flat Fee','lawyer_mgt');?></option>
											<option value="mixed" <?php   if($billing_type == 'mixed') echo 'selected = "selected"';  ?>><?php esc_html_e('Mix of Flat Fee and Hourly','lawyer_mgt');?></option>
											<option value="pro_bono" <?php if($billing_type == 'pro_bono') echo 'selected = "selected"';  ?>><?php esc_html_e('Pro Bono','lawyer_mgt');?></option>		
										</select>
										</div>
									</div>
									<div class="header">	
										<h3 class="first_hed"><?php esc_html_e('Opponents','lawyer_mgt');?></h3>
										<hr>
									</div>
									<div class="form-group">
										<?php 			
										if($edit)
										{	
											?>
											<div id="opponents_div">	
												<?php
												$opponents_details_array=json_decode($case_info->opponents_details);
												$a=0;
												if(!empty($opponents_details_array))
												{
													foreach ($opponents_details_array as $data)
													{
													?> 	
													<div>	
														<div class="col-sm-2 margin_bottom_10">
														</div>
														<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10">
															<input  class="form-control has-feedback-left validate[custom[onlyLetter_specialcharacter]] text-input" maxlength="50" value="<?php if($edit){ echo esc_attr($data->opponents_name); } ?>" type="text" placeholder="<?php esc_html_e('Enter Name','lawyer_mgt');?>" name="opponents[]">
															<span class="fa fa-user form-control-feedback left" aria-hidden="true"> </span>
														</div>
														<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10">
															<input class="form-control has-feedback-left validate[custom[email]] text-input" type="text"  maxlength="50" name="opponents_email[]" value="<?php if($edit){ echo esc_attr($data->opponents_email); } ?>" placeholder="<?php esc_html_e('Enter Email','lawyer_mgt');?>">
															<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
														</div>
														<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 margin_bottom_10">				
															<input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  value="<?php if($edit){ echo esc_attr($data->opponents_phonecode); } ?>" class="form-control"  name="opponents_phonecode[]">
														</div>					
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 has-feedback margin_bottom_10">
															<input  class="form-control has-feedback-left  validate[custom[phone_number],minSize[6],maxSize[15]] text-input" type="number"  name="opponents_mobile_number[]" value="<?php if($edit){ echo esc_attr($data->opponents_mobile_number); } ?>" placeholder="<?php esc_html_e('Enter Mobile No','lawyer_mgt');?>">
															<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
														</div>
														<div class="col-sm-1 margin_bottom_10">
															<?php
															if($a != 0)
															{
																?>
																<input type="button" value="<?php esc_attr_e('Delete','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger">	
																<?php
															}
															?>
														</div>	
													</div>
													<?php
													$a=$a+1;
													}
												}
												?>
											</div>
											<?php
										}	
										else
										{		
											?>	
											<div id="opponents_div">	
												<div>	
													<div class="col-sm-2 margin_bottom_10">
													</div>
													<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10">
														<input  class="form-control has-feedback-left validate[custom[onlyLetter_specialcharacter],maxSize[50]] text-input"  type="text" placeholder="<?php esc_html_e('Enter Name','lawyer_mgt');?>" name="opponents[]">
														<span class="fa fa-user form-control-feedback left" aria-hidden="true"> </span>
													</div>
													<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10">
														<input class="form-control has-feedback-left validate[custom[email]] text-input" type="text"  maxlength="50" name="opponents_email[]" placeholder="<?php esc_html_e('Enter Email','lawyer_mgt');?>">
														<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
													</div>
													<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 margin_bottom_10">				
														<input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  class="form-control"  name="opponents_phonecode[]">
													</div>					
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 has-feedback margin_bottom_10">
														<input  class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]] text-input" type="number"  name="opponents_mobile_number[]" placeholder="<?php esc_html_e('Enter Mobile No','lawyer_mgt');?>">
														<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
													</div>
													<div class="col-sm-1 margin_bottom_10">
													</div>	
												</div>	
											</div>	
											<?php
										}
										?>	
										<div class=" offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
											<input type="button" value="<?php esc_attr_e('Add More Opponents','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_opponents()" class="add_cirtificate btn btn-success">
										</div>
									</div>
									<div class="header">	
										<h3 class="first_hed"><?php esc_html_e('Opponents Attorney','lawyer_mgt');?></h3>
										<hr>
									</div>	
									<div class="form-group">
										<?php 			
										if($edit)
										{	
											?>
											<div id="opponents_attorney_div">	
												<?php
												$opponents_attorney_details=json_decode($case_info->opponents_attorney_details);
												$a=0;
												if(!empty($opponents_attorney_details))
												{
													foreach ($opponents_attorney_details as $data)
													{
													?> 	
													<div>	
														<div class="col-sm-2 margin_bottom_10">
														</div>
														<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10">
															<input  class="form-control has-feedback-left validate[custom[onlyLetter_specialcharacter],maxSize[50]]text-input"   value="<?php if($edit){ echo esc_attr($data->opponents_attorney_name); } ?>" type="text" placeholder="<?php esc_html_e('Enter Name','lawyer_mgt');?>" name="opponents_attorney[]">
															<span class="fa fa-user form-control-feedback left" aria-hidden="true">  </span>
														</div>
														<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10">
															<input class="form-control has-feedback-left validate[custom[email]] text-input" type="text"  maxlength="50" name="opponents_attorney_email[]" value="<?php if($edit){ echo esc_attr($data->opponents_attorney_email); } ?>" placeholder="<?php esc_html_e('Enter Email','lawyer_mgt');?>">
															<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
														</div>
														<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 margin_bottom_10">				
															<input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  value="<?php if($edit){ echo esc_attr($data->opponents_attorney_phonecode); } ?>" class="form-control"  name="opponents_attorney_phonecode[]">
														</div>					
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 has-feedback margin_bottom_10">
															<input  class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]] text-input" type="number" name="opponents_attorney_mobile_number[]" value="<?php if($edit){ echo esc_attr($data->opponents_attorney_mobile_number); } ?>" placeholder="<?php esc_html_e('Enter Mobile No','lawyer_mgt');?>">
															<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
														</div>
														<div class="col-sm-1 margin_bottom_10">
															<?php
															if($a != 0)
															{
																?>
																<input type="button" value="<?php esc_attr_e('Delete','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger">	
																<?php
															}
															?>
														</div>	
													</div>
													<?php
													$a=$a+1;
													}
												}
												?>
											</div>
											<?php
										}	
										else
										{		
											?>	
											<div id="opponents_attorney_div">	
												<div>	
													<div class="col-sm-2 margin_bottom_10">
													</div>
													<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10">
														<input  class="form-control has-feedback-left validate[custom[onlyLetter_specialcharacter],maxSize[50]] text-input"  type="text" placeholder="<?php esc_html_e('Enter Name','lawyer_mgt');?>" name="opponents_attorney[]">
														<span class="fa fa-user form-control-feedback left" aria-hidden="true"> </span>
													</div>
													<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback margin_bottom_10">
														<input class="form-control has-feedback-left validate[custom[email]] text-input" type="text"  maxlength="50" name="opponents_attorney_email[]" placeholder="<?php esc_html_e('Enter Email','lawyer_mgt');?>">
														<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
													</div>
													<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 margin_bottom_10">				
														<input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  class="form-control"  name="opponents_attorney_phonecode[]">
													</div>					
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 has-feedback margin_bottom_10">
														<input  class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]] text-input" type="number" name="opponents_attorney_mobile_number[]" placeholder="<?php esc_html_e('Enter Mobile No','lawyer_mgt');?>">
														<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
													</div>
													<div class="col-sm-1 margin_bottom_10">
													</div>	
												</div>	
											</div>	
											<?php
										}
										?>	
										<div class=" offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
											<input type="button" value="<?php esc_attr_e('Add More Opponents Attorney','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_opponents_attorney()" class="add_cirtificate btn btn-success">
										</div>
									</div>
									<div class="offset-sm-2 col-sm-8">
										<input type="submit" id="casesubmit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Add Case','lawyer_mgt');}?>" name="save_case" class="btn btn-success"/>
									</div>		
								</form>
							</div> 
							<?php 
						} ?>
					    <!----------ADD Attorney------------->	 
							  
						<div class="modal fade overflow_scroll_css" id="myModal_add_attorney" role="dialog">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal">&times;</button>
									  <h3 class="modal-title"><?php esc_html_e('Add Attorney','lawyer_mgt');?></h3>
									</div>
									<div class="modal-body">
										<form name="attorney_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form-horizontal" id="attorney_form" enctype='multipart/form-data'>	         
											<input type="hidden" name="action" value="MJ_lawmgt_add_attorney_into_database">
											<input type="hidden" name="role" value="attorney"  />		
											<div class="header">	
												<h3 class="first_hed"><?php esc_html_e('Personal Information','lawyer_mgt');?></h3>
												<hr>
											</div>
											<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="first_name"><?php esc_html_e('First Name','lawyer_mgt');?><span class="require-field">*</span></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input id="first_name" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input"  type="text" placeholder="<?php esc_html_e('Enter First Name','lawyer_mgt');?>" value="" name="first_name">
													<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
												</div>
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="middle_name"><?php esc_html_e('Middle Name','lawyer_mgt');?></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input id="middle_name" class="form-control has-feedback-left  validate[custom[onlyLetter_specialcharacter],maxSize[50]]" type="text"  placeholder="<?php esc_html_e('Enter Middle Name','lawyer_mgt');?>" value="" name="middle_name">
													<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="last_name"><?php esc_html_e('Last Name','lawyer_mgt');?><span class="require-field">*</span></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input id="last_name" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input"  type="text"   placeholder="<?php esc_html_e('Enter Last Name','lawyer_mgt');?>" value="" name="last_name">
													<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
												</div>
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="birth_date"><?php esc_html_e('Date of birth','lawyer_mgt');?><span class="require-field">*</span></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input id="birth_date" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date form-control has-feedback-left validate[required]" type="text"  name="birth_date"  placeholder="<?php esc_html_e('Select Birth Date','lawyer_mgt');?>"
													<input id="birth_date" class="form-control has-feedback-left validate[required]" type="text"  name="birth_date"  placeholder="<?php esc_html_e('Select Birth Date','lawyer_mgt');?>"
													value="" readonly>
													<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
													<span id="inputSuccess2Status2" class="sr-only">(success)</span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="gender"><?php esc_html_e('Gender','lawyer_mgt');?></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
												<?php $genderval = "male"; ?>
													<label class="radio-inline">
													 <input type="radio" value="male" class="tog validate[required]" name="gender"  <?php  checked( 'male', $genderval);  ?>/><?php esc_html_e('Male','lawyer_mgt');?>
													</label>
													<label class="radio-inline">
													  <input type="radio"  value="female" class="tog validate[required]" name="gender"  <?php  checked( 'female', $genderval);  ?>/><?php esc_html_e('Female','lawyer_mgt');?> 
													</label>
												</div>
											</div>
											<div class="header">
												<h3><?php esc_html_e('Address Information','lawyer_mgt');?></h3>
												<hr>
											</div>
											<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="address"><?php esc_html_e('Address','lawyer_mgt');?><span class="require-field">*</span></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input id="address" class="form-control has-feedback-left validate[required,custom[address_description_validation],maxSize[150]]" type="text"  name="address"  placeholder="<?php esc_html_e('Enter Address','lawyer_mgt');?>"
													value="">
													<span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
												</div>
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="state_name"><?php esc_html_e('State','lawyer_mgt');?><span class="require-field">*</span></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input id="state_name" class="form-control has-feedback-left validate[required,custom[city_state_country_validation],maxSize[50]]"   type="text"  name="state_name" placeholder="<?php esc_html_e('Enter State Name','lawyer_mgt');?>"
													value="">
													<span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
												</div>
											</div>	
											<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="city_name"><?php esc_html_e('City','lawyer_mgt');?><span class="require-field">*</span></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input id="city_name" class="form-control has-feedback-left validate[required,custom[city_state_country_validation],maxSize[50]]"   type="text"  name="city_name"  placeholder="<?php esc_html_e('Enter City Name','lawyer_mgt');?>"
													value="">
													<span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
												</div>
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="pin_code"><?php esc_html_e('Pin Code','lawyer_mgt');?><span class="require-field">*</span></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input id="pin_code" class="form-control has-feedback-left validate[required,custom[onlyLetterNumber],maxSize[15]]" type="text" name="pin_code" placeholder="<?php esc_html_e('Enter Pin Code','lawyer_mgt');?>" 
													value="">
													<span class="fa fa-sort-numeric-down form-control-feedback left" aria-hidden="true"></span>
												</div>
											</div>		
											<div class="header">
												<h3><?php esc_html_e('Education Information','lawyer_mgt');?></h3>
												<hr>
											</div>
											<div class="form-group">		
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="degree"><?php esc_html_e('Degree','lawyer_mgt');?><span class="require-field">*</span></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input id="degree" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]"    type="text"  name="degree" placeholder="<?php esc_html_e('Enter Degree Name','lawyer_mgt');?>"
													value="">
													<span class="fa fa-graduation-cap form-control-feedback left" aria-hidden="true"></span>
												</div>
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="experience"><?php esc_html_e('Experience(Years)','lawyer_mgt');?><span class="require-field">*</span></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input id="experience" class="form-control has-feedback-left validate[required,custom[number],maxSize[6]]" type="number" min="0"    name="experience"  placeholder="<?php esc_html_e('Enter Experience','lawyer_mgt');?>"
													value="" min="0" max="99">
													<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
												</div>
											</div>	 		
											<div class="header">
												<h3><?php esc_html_e('Contact Information','lawyer_mgt');?></h3>
												<hr>
											</div>
											<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="mobile"><?php esc_html_e('Mobile Number','lawyer_mgt');?><span class="require-field">*</span></label>
												<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
												
												<input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  class="form-control" name="phonecode">
												</div>
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
													<input id="mobile" class="form-control has-feedback-left   validate[required,custom[phone_number],minSize[6],maxSize[15]] text-input" type="number" placeholder="<?php esc_html_e('Enter Mobile Number','lawyer_mgt');?>" name="mobile"
													value="">
													<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
												</div>
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="phone"><?php esc_html_e('Alternate Mobile Number','lawyer_mgt');?></label>
												<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
												
												<input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  class="form-control"  name="phonecode">
												</div>
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
													<input id="Altrmobile" class="form-control has-feedback-left   validate[custom[phone_number],minSize[6],maxSize[15]] text-input" type="number"  name="alternate_mobile"  placeholder="<?php esc_html_e('Enter Alternate Mobile Number','lawyer_mgt');?>"
													value="">
													<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
												</div>
											</div>
												<div class="form-group">
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="phone_home"><?php esc_html_e('Phone Home','lawyer_mgt');?></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input id="phone_home" class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]]  text-input" type="number"  name="phone_home" placeholder="<?php esc_html_e('Enter Home Phone Number','lawyer_mgt');?>"
													value="">
													<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
												</div>			

											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="phone_work"><?php esc_html_e('Phone Work','lawyer_mgt');?></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input id="phone_work" class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]]  text-input" type="number"  name="phone_work" placeholder="<?php esc_html_e('Enter Work Phone Number','lawyer_mgt');?>"
													value="">
													<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
												</div>
											</div>
											<div class="header">	
												<h3><?php esc_html_e('Login Information','lawyer_mgt');?></h3>
												<hr>
											</div>
											<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="email"><?php esc_html_e('Email','lawyer_mgt');?><span class="require-field">*</span></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input id="email" class="form-control has-feedback-left validate[required,custom[email]] text-input" type="text" maxlength="50" name="email" placeholder="<?php esc_html_e('Enter valid Email','lawyer_mgt');?>"
													value="">
													<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
												</div>
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="username"><?php esc_html_e('Username','lawyer_mgt');?><span class="require-field">*</span></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input id="username" class="form-control has-feedback-left validate[required,custom[username_validation],maxSize[30]]]" type="text"  name="username"  placeholder="<?php esc_html_e('Enter valid username','lawyer_mgt');?>"
													value="">
													<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="password"><?php esc_html_e('Password','lawyer_mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
													<input class="form-control has-feedback-left <?php if(!$edit){ echo 'validate[required,minSize[8]]'; }else{ echo 'validate[minSize[8]]'; }?>"  maxlength="12" type="password"  name="password" placeholder="<?php esc_html_e('Enter valid Password','lawyer_mgt');?>" value="">
													<span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
												</div>
											</div>
											<div class="header">	
												<h3><?php esc_html_e('Other Information','lawyer_mgt');?></h3>
												<hr>
											</div>
											<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="rate"><?php esc_html_e('Default Rate','lawyer_mgt');?></label>
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
													<input id="rate" class="form-control has-feedback-left validate[min[0],maxSize[8]] " step="0.01" type="number" name="rate"  placeholder="<?php esc_html_e('Enter Rate','lawyer_mgt');?>"
													value="">
													<span class="fa fa-rupee-sign form-control-feedback left" aria-hidden="true"></span>
												</div>
												<div class="attorny_default_rate attorny_default_rate_css">
														<?php esc_html_e('/ hr','lawyer_mgt');?>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="photo"><?php esc_html_e('Image','lawyer_mgt');?></label>
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
													<input type="text" id="lmgt_user_avatar_url" class="lmgt_user_avatar_url form-control has-feedback-left" name="lmgt_user_avatar"  placeholder="<?php esc_html_e('Select image','lawyer_mgt');?>"
													value="" />
													<span class="fa fa-image form-control-feedback left" aria-hidden="true"></span>
												</div>	
											 
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
													 <input type="hidden" name="hidden_upload_user_avatar_image" 
														value="<?php if(isset($_POST['upload_user_avatar_image'])) echo esc_url($_POST['upload_user_avatar_image']);
														else echo esc_url(get_option('lmgt_system_logo'));?>">
													 <input id="upload_user_avatar_image" name="upload_user_avatar_image" type="file" class="form-control file" value="<?php esc_html_e('Upload image', 'lawyer_mgt' ); ?>" />
												</div>
												<div class="clearfix"></div>												
												<div class="upload_img offset-sm-2 col-sm-8">
													<div id="upload_user_avatar_preview" >														 
														<img alt="" class="height_100px_width_100px" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
													</div>
											 </div>
											</div>
											<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="join"><?php esc_html_e('Curriculum Vitae','lawyer_mgt');?></label>
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
													<input  name="attorney_cv" class="form-control file pdf_validation" type="file">
													<input  name="hidden_cv"  type="hidden" value="">
													<p class="help-block"><?php esc_html_e('Upload document in PDF','lawyer_mgt');?></p> 
												</div>											
											</div>
											<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="join"><?php esc_html_e('Education Certificate','lawyer_mgt');?></label>
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
													<input name="education_certificate" class="pdf_validation form-control file" type="file">
													<input name="hidden_education_certificate"  type="hidden" value="">
													<p class="help-block"><?php esc_html_e('Upload document in PDF','lawyer_mgt');?></p> 
												</div>												
											</div>	
											<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="join"><?php esc_html_e('Experience Certificate','lawyer_mgt');?></label>
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
													<input  name="experience_cert" class="pdf_validation form-control file" type="file">
													<input  name="hidden_exp_certificate"  type="hidden" value="">
													<p class="help-block"><?php esc_html_e('Upload document in PDF','lawyer_mgt');?></p> 
												</div>												
											</div>			
											<div class="offset-sm-2 col-sm-8">
												<input type="submit" value="<?php  esc_attr_e('Add Attorney','lawyer_mgt');?>" name="save_attorney" class="btn btn-success"/>
											</div>
										</form>
									</div>	  
								</div>	  
							</div>	  
						</div>	  
						 <!----------END ADD Attorney------------->	
				  <?php
					}	 
					if($active_tab == 'casedetails')
					{
						?>
						<div class="col-md-12 float_template">
							<div class="navtab panel panel-white margin_template">
							  <?php 
								if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='view')
								{									
									$active_tab = sanitize_text_field(isset($_GET['tab2'])?$_GET['tab2']:'caseinfo');
											
									?>
										<h2>
											<ul id="myTab" class="sub_menu_css line case_nav nav nav-tabs margin_panel" role="tablist">
												<li role="presentation" class="<?php echo $active_tab == 'caseinfo' ? 'active' : ''; ?> menucss">
													<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
														<?php echo '<span class="fa fa-briefcase"></span> '.esc_html__('Case Info', 'lawyer_mgt'); ?>
													</a>
												</li>
												
												<?php  
												$page='documents';
												$documents=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
												if($documents)
												{
													if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
													{
														?>
														<li role="presentation" class="<?php echo $active_tab == 'documents' ? 'active' : ''; ?> menucss">
															<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=documents&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
																<?php echo '<span class="fa fa-file"></span> '.esc_html__('Documents', 'lawyer_mgt'); ?>
															</a>
														</li>
														<?php
													}
												}
												$page='task';
												$task=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
												if($task)
												{
													if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
													{	
													 ?>
														<li role="presentation" class="<?php echo $active_tab == 'task' ? 'active' : ''; ?> menucss">
															<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=task&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
																<?php echo '<span class="fa fa-tasks"></span> '.esc_html__('Task', 'lawyer_mgt'); ?>
															</a>
														</li>
													<?php
													}
												}
												$page='note';
												$note=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
												if($note)
												{
												?>	
												<li role="presentation" class="<?php echo $active_tab == 'note' ? 'active' : ''; ?> menucss">
													<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=note&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
														<?php echo '<span class="fa fa-file-o"></span> '.esc_html__('Notes', 'lawyer_mgt'); ?>
													</a>
												</li>
												<?php
												}
												$page='event';
												$event=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
												if($event)
												{
												?>
												<li role="presentation" class="<?php echo $active_tab == 'event' ? 'active' : ''; ?> menucss">
													<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=event&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
														<?php echo '<span class="fa fa-calendar"></span> '.esc_html__('Event', 'lawyer_mgt'); ?>
													</a>
												</li>
												<?php
												}
												$page='invoice';
												$invoice=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
												if($invoice)
												{
													if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
													{
														?>
														<li role="presentation" class="<?php echo $active_tab == 'invoice' ? 'active' : ''; ?> menucss">
														 <a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=invoice&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
																<?php echo '<span class="fa fa-file-text-o"></span> '.esc_html__('Invoice', 'lawyer_mgt'); ?>
															</a>
														</li>
													<?php
													}
												}
												$page='workflow';
												$workflow=MJ_lawmgt_page_access_rolewise_and_accessright_dashboard($page);
												if($workflow)
												{
												?>
													<li role="presentation" class="<?php echo $active_tab == 'workflow' ? 'active' : ''; ?> menucss">
													 <a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=workflow&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
															<?php echo '<span class="fa fa-stack-overflow"></span> '.esc_html__('Workflow', 'lawyer_mgt'); ?>
														</a>
													</li>
											 <?php
												}
											  ?>
											</ul>
										</h2>					
									<?php 
									}
									if($active_tab=='caseinfo')
									{?>
										<div class="panel-body"><!-- PANEL BODY  DIV   -->
											<div class="header">	
												<h3 class="first_hed"><?php esc_html_e('Case Information','lawyer_mgt');?></h3>
												<hr>
											</div>
											<div class="case_info_div col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<?php 
												if(isset($_REQUEST['case_id']))
												$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
												$obj_next_hearing_date=new MJ_lawmgt_Orders;
												$next_hearing_date= $obj_next_hearing_date->MJ_lawmgt_get_next_hearing_date_asc_by_case_id($case_id);
												$obj_case=new MJ_lawmgt_case;
												$case_info_data = $obj_case->MJ_lawmgt_get_single_case($case_id);
												 
												?>
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
														<?php esc_html_e('Case Name','lawyer_mgt');?>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<span class="txt_color">
															<?php  echo esc_html($case_info_data->case_name);?>
														</span>
													</div>
												</div>
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
														<?php esc_html_e('Case Number','lawyer_mgt');?>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<span class="txt_color">
															<?php  echo esc_html($case_info_data->case_number);?>
														</span>
													</div>
												</div>
												 
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
													 <?php esc_html_e('Practice Area','lawyer_mgt');?>
													 </div>
													 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<span class="txt_color">
															<?php echo get_the_title(esc_html($case_info_data->practice_area_id));?>
														</span>
													</div>
												</div>
												<?php
												if(!empty($case_info_data->case_description))
												{
													?>
													<div class="table_row">
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
														<?php esc_html_e('Case Description','lawyer_mgt');?>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<span class="txt_color">
															<?php  echo esc_html($case_info_data->case_description);?>
														</span>
														</div>
													
													</div>
												<?php } ?>
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
													<?php esc_html_e('Court Name','lawyer_mgt');?>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<?php 
															$court_id =$case_info_data->court_id;
															$latest_posts = get_post($court_id);
														echo '<span class="txt_color" value="'.esc_attr($latest_posts->ID).'">'.esc_html($latest_posts->post_title).'</span>';
														 ?>
													</div>
												</div>
											 <?php
												if(!empty($case_info_data->court_hall_no))
												{
													?>
													<div class="table_row">
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
														<?php esc_html_e('Court Hall No','lawyer_mgt');?>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<span class="txt_color">
															<?php  echo esc_html($case_info_data->court_hall_no);?>
														</span>
														</div>
													
													</div>
												<?php } ?>
												 <?php
												if(!empty($case_info_data->floor))
												{
													?>
													<div class="table_row">
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
														<?php esc_html_e('Floor','lawyer_mgt');?>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<span class="txt_color">
															<?php  echo esc_html($case_info_data->floor);?>
														</span>
														</div>
													
													</div>
												<?php } ?>
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
													<?php esc_html_e('State Name','lawyer_mgt');?>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<?php 
															$state_id =$case_info_data->state_id;
															$latest_posts = get_post($state_id);
														echo '<span class="txt_color" value="'.esc_attr($latest_posts->ID).'">'.esc_html($latest_posts->post_title).'</span>';
														 ?>
													</div>
												</div>
												
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
													<?php esc_html_e('Bench Name','lawyer_mgt');?>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<?php 
															$bench_id =$case_info_data->bench_id;
															$latest_posts = get_post($bench_id);
														echo '<span class="txt_color" value="'.esc_attr($latest_posts->ID).'">'.esc_html($latest_posts->post_title).'</span>';
														 ?>
													</div>
												</div>
												 
												<?php
												if(!empty($case_info_data->crime_no))
												{
													?>	
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
														<?php esc_html_e('Crime No of Police Station','lawyer_mgt');?>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<span class="txt_color">
															<?php  echo esc_html($case_info_data->crime_no);?>
														</span>
													</div>
												</div>
												<?php
												}
												if(!empty($case_info_data->fri_no))
												{
												?>
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
														<?php esc_html_e('FIR No','lawyer_mgt');?>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<span class="txt_color">
															<?php  echo esc_html($case_info_data->fri_no);?>
														</span>
													</div>
												</div>
												<?php
												}
												if(!empty($case_info_data->crime_details))
												{
													?>
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
														<?php esc_html_e('Crime Details','lawyer_mgt');?>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<span class="txt_color">
															<?php  echo esc_html($case_info_data->crime_details);?>
														</span>
													</div>
												</div>	
												<?php
												}
												if(!empty($case_info_data->earlier_history))
												{
													?>
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
														<?php esc_html_e('Earlier Court History','lawyer_mgt');?>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<span class="txt_color">
															<?php  echo esc_html($case_info_data->earlier_history);?>
														</span>
													</div>
												</div>	
												 <?php
												}
												if(!empty($case_info_data->priority))
												{
													?>
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
														<?php esc_html_e('Priority','lawyer_mgt');?>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<span class="txt_color">
															<?php  echo esc_html($case_info_data->priority);?>
														</span>
													</div>
												</div>		
												 <?php
												}
												if(!empty($case_info_data->classification))
												{
													?>
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
														<?php esc_html_e('Classification','lawyer_mgt');?>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<span class="txt_color">
															<?php  echo esc_html($case_info_data->classification);?>
														</span>
													</div>
												</div>		
												 <?php
												}
												if(!empty($case_info_data->referred_by))
												{
													?>
												<div class="table_row">
													<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
														<?php esc_html_e('Referred By','lawyer_mgt');?>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
														<span class="txt_color">
															<?php  echo esc_html($case_info_data->referred_by);?>
														</span>
													</div>
												</div>		
												 <?php
												}
												if(!empty($case_info_data->stages))
												{
												?>
												 <div class="table_row">
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
														<?php esc_html_e('Case Stages','lawyer_mgt');?>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
													 
															<?php 
														
															if(!empty($case_info_data->stages))
															{
																$stages=json_decode($case_info_data->stages);
															}
															 
															$increment = 0;
															foreach($stages as $data)
															{ 
																$increment++;
																?>	
																<span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 txt_color padding_0px_0px_5px_0px_css">
																<?php echo $increment;?>.<?php echo esc_html($data->value); ?>
																</span>
																<?php
															} 
															?>							
														</div>
													</div>
													 
												<?php
												}
												?>
											</div>								
												<div class="header">	
													<h3 class="first_hed"><?php esc_html_e('Important Date','lawyer_mgt');?></h3>
													<hr>
												</div>
													<div class="case_info_div col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
															<div class="table_row">
																<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
																	<?php esc_html_e('Open Date','lawyer_mgt');?>
																</div>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																	<span class="txt_color">
																	<?php									
																		 echo esc_html(MJ_lawmgt_getdate_in_input_box($case_info_data->open_date));
																		?>
																	</span>
																</div>
															</div>
															 
														 
															<div class="table_row">
																<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
																<?php esc_html_e('Statute of Limitations','lawyer_mgt');?>
																</div>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																	<span class="txt_color">
																	<?php									
																		 echo esc_html(MJ_lawmgt_getdate_in_input_box($case_info_data->statute_of_limitations));
																		?>
																	</span>
																</div>
															</div>
														</div>
														<div class="table_row">
															<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
															<?php esc_html_e('Hearing Dates','lawyer_mgt');?>
															</div>
															<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																<?php 
																$increment = 0;
																foreach($next_hearing_date as $data)
																{ 
																	$increment++;
																	?>	
																	<span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 txt_color padding_0px_0px_5px_0px_css">
																	<?php echo $increment;?>. <?php echo  esc_html($data->next_hearing_date); ?>
																	</span>
																	<?php
																} 
																?>							
															</div>
														</div>														
													</div>
												 
														
													<div class="header">	
														<h3 class="first_hed"><?php esc_html_e('Attorney And Client Link','lawyer_mgt');?></h3>
														<hr>
													</div>
													<div class="case_info_div col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<div class="table_row">
															<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
																<?php esc_html_e('Assigned To Attorney','lawyer_mgt');?>
															</div>
															<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																<span class="txt_color">
																<?php
																	$user=explode(",",$case_info_data->case_assgined_to);
																	$user_name=array();
																	if(!empty($user))
																	{						
																		foreach($user as $data4)
																		{
																			$user_name[]=MJ_lawmgt_get_display_name($data4);
																		}
																	}			
																	 echo esc_html(implode(", ",$user_name));
																	?>
																</span>
															</div>
														</div>	
														<div class="table_row">
															<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
																<?php esc_html_e('Client Name','lawyer_mgt');?>
															</div>
															<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																<span class="txt_color">
																<?php
																	global $wpdb;
																	$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
																	
																	$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
																	$result = $wpdb->get_results("SELECT * FROM $table_case_contacts where case_id=".$case_id);
																	$user_name=array();
																	if(!empty($result))
																	{						
																		foreach($result as $data)
																		{
																			$user_name[]=MJ_lawmgt_get_display_name($data->user_id);
																		}
																	}			
																	 echo esc_html(implode(", ",$user_name));
																	?>
																</span>
															</div>
														</div>	
																				
													</div>
													<?php
													global $wpdb;
													$table_case_staff_users = $wpdb->prefix. 'lmgt_case_staff_users';
													
													$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
													$result_staff = $wpdb->get_results("SELECT * FROM $table_case_staff_users where case_id=".$case_id);
													if(!empty($result_staff))
													{
														?>
													<div class="header">	
														<h3 class="first_hed"><?php esc_html_e('Staff Link','lawyer_mgt');?></h3>
														<hr>
													</div>
													<div class="case_info_div col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<?php
															
																foreach ($result_staff as $retrive_data)				
																{ 		 	
																?>
																<div class="table_row">
																 
																	 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 casedetail_link_user_link_div table_td">
																		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 user-link-name user-link-name-staff">
																		<?php $staff_name=MJ_lawmgt_get_display_name($retrive_data->user_id); ?> 
																			<span><?php echo esc_html($staff_name);?></span>
																		</div>
																		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 user-link-billing-rate">
																		<span class="float_left_css"><?php echo esc_html($retrive_data->fee); ?><?php esc_html_e(' / hr','lawyer_mgt');?></span>
																			 
																		</div>									
																	</div>
																</div>
																<?php
																
															}	
															?>
														</div>								
													</div>
												<?php  } ?>
												<div class="header">	
													<h3 class="first_hed"><?php esc_html_e('Opponents','lawyer_mgt');?></h3>
													<hr>
												</div>
												<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<table class="table table-bordered">
														<thead>
														  <tr>
															<th class="text_align_center_css" ><?php esc_html_e('Opponent Name ','lawyer_mgt');?></th>
															<th class="text_align_center_css" ><?php esc_html_e('Opponent Email','lawyer_mgt');?></th>
															<th class="text_align_center_css" ><?php esc_html_e('Opponent Mobile Number','lawyer_mgt');?></th>
														  </tr>
														</thead>
														<tbody>
														<?php
														$opponents_details_array=json_decode($case_info_data->opponents_details);
														
														if(!empty($opponents_details_array[0]->opponents_name))
														{
															foreach ($opponents_details_array as $data)
															{
															?> 
															  <tr>
																<td class="text_align_center_css" ><?php echo esc_html($data->opponents_name); ?></td>
																<td class="text_align_center_css" ><?php echo esc_html($data->opponents_email); ?></td>
																<td class="text_align_center_css" ><?php if(!empty($data->opponents_mobile_number)){ echo esc_html($data->opponents_phonecode); echo esc_html($data->opponents_mobile_number); } ?></td>							
															  </tr>	
															<?php
															}
														}		
														else
															{ ?>
														 
																  
																<td class="text_align_center_css"  colspan="3"><?php esc_html_e('No Data Available...','lawyer_mgt');?></td>
																 
														<?php 	
															}
															?>	
														</tbody>
													</table>
												</div>
												<div class="header">	
													<h3 class="first_hed"><?php esc_html_e('Opponents Attorney','lawyer_mgt');?></h3>
													<hr>
												</div>
												<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<table class="table table-bordered">
														<thead>
															  <tr>
																<th class="text_align_center_css" ><?php esc_html_e('Opponent Name ','lawyer_mgt');?></th>
																<th class="text_align_center_css" ><?php esc_html_e('Opponent Email','lawyer_mgt');?></th>
																<th class="text_align_center_css" ><?php esc_html_e('Opponent Mobile Number','lawyer_mgt');?></th>
															  </tr>
														</thead>
														<tbody>
															<?php
															$opponents_attorney_details=json_decode($case_info_data->opponents_attorney_details);
															if(!empty($opponents_attorney_details[0]->opponents_attorney_name))
															{
																foreach ($opponents_attorney_details as $data)
																{
																?> 
																  <tr>
																	<td class="text_align_center_css" ><?php echo esc_html($data->opponents_attorney_name); ?></td>
																	<td class="text_align_center_css" ><?php echo esc_html($data->opponents_attorney_email); ?></td>
																	<td  class="text_align_center_css" ><?php if(!empty($data->opponents_attorney_mobile_number)){ echo esc_html($data->opponents_attorney_phonecode); echo esc_html($data->opponents_attorney_mobile_number); } ?></td>							
																  </tr>	
																<?php
																}
															}		
															else
															{ ?>
																<td class="text_align_center_css" colspan="3"><?php esc_html_e('No Data Available...','lawyer_mgt');?></td>
														<?php 	
															}
															?>	
														</tbody>
													</table>
												</div>
												</div>
										</div>	<!-- END PANEL BODY  DIV   -->										
									<?php
									}
									if($active_tab=='documents')
									{		
											if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
											{
												//wp_redirect ( home_url() . '?dashboard=user');
												$redirect_url=home_url() . '?dashboard=user';
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
											$active_tab = sanitize_text_field(isset($_GET['tab3'])?$_GET['tab3']:'documentslist');
											$user_access_documents=MJ_lawmgt_get_userrole_wise_filter_access_right_array('documents');
											?>     
											<h2>	
											<ul id="myTab" class="sub_menu_css line nav nav-tabs case_details_documents" role="tablist">
												<li role="presentation" class="<?php echo esc_html($active_tab) == 'documentslist' ? 'active' : ''; ?> ">
													<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=documents&tab3=documentslist&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
														<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Documents List', 'lawyer_mgt'); ?>				
													</a>
												</li>
												
												<?php if(isset($_REQUEST['edit'])&& sanitize_text_field($_REQUEST['edit'])=='true') {?>
												<li role="presentation" class="<?php echo esc_html($active_tab) == 'adddocuments' ? 'active' : ''; ?>">
													<a href="?dashboard=user&page=cases&tab=casedetails&&action=view&tab2=documents&tab3=adddocuments&edit=true&tab4=alldocuments&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&documents_id=<?php echo esc_attr($_REQUEST['documents_id']);?>">
														<?php echo esc_html__('Edit Documents', 'lawyer_mgt'); ?>					
													</a>
												</li>
												<?php 
												}else
												{
													if($user_access_documents['add']=='1')
													{
														?>
														<li role="presentation" class="<?php echo esc_html($active_tab) == 'adddocuments' ? 'active' : ''; ?>">
															<a href="?dashboard=user&page=cases&tab=casedetails&action=view&add=true&tab2=documents&tab3=adddocuments&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
																<?php echo '<span class="fa fa-plus-circle"></span> '.esc_html__('Add Documents', 'lawyer_mgt'); ?>	
															</a>
														</li>
												<?php }
												}
												?>		
											</ul>
											</h2>
											<?php
											if($active_tab=='adddocuments')
											{	 
												$obj_documents=new MJ_lawmgt_documents;
												?>
												<script type="text/javascript">
												    var $ = jQuery.noConflict();
													jQuery(document).ready(function($)
													{
														"use strict"; 
														$('#documents_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
													});

													jQuery("body").on("change", ".input-file[type=file]", function ()
													{ 
														"use strict"; 
														var file = this.files[0]; 
														var file_id = jQuery(this).attr('id'); 
														var ext = $(this).val().split('.').pop().toLowerCase(); 
														//Extension Check 
														if($.inArray(ext, ['pdf','doc','docx','xls','xlsx','ppt','pptx','csv']) == -1)
														{
															 alert('<?php _e("Only pdf,doc,docx,xls,xlsx,ppt,pptx,csv formate are allowed. '  + ext + ' formate are not allowed.","lawyer_mgt") ?>');
															$(this).replaceWith('<input type="file" name="cartificate[]" class="form-control  file_validation input-file">');
															return false; 
														} 
														 //File Size Check 
														 if (file.size > 20480000) 
														 {
															alert("<?php esc_html_e('Too large file Size. Only file smaller than 10MB can be uploaded.','lawyer_mgt');?>");
															$(this).replaceWith('<input type="file" name="cartificate[]" class="form-control  file_validation input-file">'); 
															return false; 
														 }
													 });
														//add more file upload div append
														"use strict"; 
														var blank_cirtificate_entry ='';
														jQuery(document).ready(function($)
														{ 
															"use strict"; 
															blank_cirtificate_entry = $('#cartificate_entry1').html();   	
														}); 
														"use strict"; 
														var value = 1;
														function MJ_lawmgt_add_cirtificate()
														{
															"use strict"; 
															value++;
															$("#cartificate_div").append('<div id="cartificate_entry1" class="abc cartificate_entry clear_both_css" row="'+value+'"><input type="hidden" name="hidden_tags[]" value="" id="hidden_tags'+value+'" class="hidden_tags" row="'+value+'"><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Title','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="text"  name="cartificate_name[]" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>" class="form-control validate[required,custom[onlyLetter_specialcharacter]],maxSize[50]]"  /></div><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><input type="file" name="cartificate[]" class="form-control doc_label  file_validation input-file validate[required]"></div><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="text" name="tag_name" id="tag_name'+value+'" class="form-control doc_label tages_add ui-autocomplete-input validate[custom[onlyLetter_specialcharacter]],maxSize[50]]"  row="'+value+'" placeholder="<?php esc_html_e('Enter New Tages','lawyer_mgt');?>" autocomplete="off" value=""></div><div id="suggesstion-box"></div><div class="col-lg-1 col-md-2 col-sm-2 col-xs-12"><button type="button" class="btn btn-success botton_submit_pulse addtages_documents" row="'+value+'" id="addtages_community"><?php esc_html_e('Add Tag','lawyer_mgt');?></button></div><div class="col-lg-2 col-md-1 col-sm-1 col-xs-12"><input type="button" value="<?php esc_html_e('Delete','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate doc_label btn btn-danger"></div></div><div class="list_tag_name'+value+' col-lg-offset-7 col-lg-5 col-md-offset-7 col-md-5 col-sm-offset-7 col-sm-5 col-xs-12" row="'+value+'"></div></div>');
														}  	 	
														
														function MJ_lawmgt_deleteParentElement(n)
														{
															"use strict"; 
															alert("<?php esc_html_e('Do you really want to delete this ?','lawyer_mgt');?>");
															n.parentNode.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode.parentNode);		
															 
														}
												</script>
												<?php
												$documents_id=0;
												$edit=0;
												if(isset($_REQUEST['documents_id']))
													$documents_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['documents_id']));
												if(isset($_REQUEST['edit']) && sanitize_text_field($_REQUEST['edit']) == 'true')
												{		
														$edit=1;
														$document_result = $obj_documents->MJ_lawmgt_get_single_documents($documents_id);
												}
												?>
														
												<div class="panel-body">
													<form name="documents_form" action="" method="post" class="form-horizontal" id="documents_form" enctype='multipart/form-data'>	
														<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
														<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
														<input type="hidden" name="documents_id" value="<?php echo esc_attr($documents_id);?>"  />
														<div class="header">	
															<h3 class="first_hed"><?php esc_html_e('Documents Information','lawyer_mgt');?></h3>
															<hr>
														</div>
														<div class="form-group">		
															<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="documets_type"><?php esc_html_e('Documents Type','lawyer_mgt');?><span class="require-field">*</span></label>
															<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
															<select class="form-control validate[required]" name="documents_type" id="documents_type">		
															<option value=""><?php esc_html_e('Select Documents Type','lawyer_mgt');?></option>
																	 <?php 
															    if($edit)
																	$documents_type =$document_result->type;					
																else 
																	 $documents_type = ""; 
																 ?>
																<option value="Case Documents" <?php if($documents_type == 'Case Documents') echo 'selected = "selected"';?>><?php esc_html_e('Case Documents','lawyer_mgt');?></option>
																<option value="Firm Documents" <?php  if($documents_type == 'Firm Documents') echo 'selected = "selected"';  ?>><?php esc_html_e('Firm Documents','lawyer_mgt');?></option>
																<option value="Templates" <?php   if($documents_type == 'Templates') echo 'selected = "selected"';  ?>><?php esc_html_e('Template','lawyer_mgt');?></option>				
															</select>
															</div>
														</div>
														<?php wp_nonce_field( 'save_case_document_nonce' ); ?>
														<div class="form-group">
															<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Case Name','lawyer_mgt');?><span class="require-field">*</span></label>				
																<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">	
																		<?php
																			$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
																			
																			global $wpdb;
																			$table_case = $wpdb->prefix. 'lmgt_cases';
													
																			$result = $wpdb->get_row("SELECT * FROM $table_case where id=".$case_id);
																			
																		?>	
																		<input type="hidden" class="form-control" name="case_name" id="case_name" value="<?php echo esc_attr($result->id);?>">		
																		<input type="text" class="form-control" name="c_name" id="c_name" value="<?php echo esc_attr($result->case_name);?>" readonly="readonly">								
																</div>			
														</div>	
														<?php 			
														if($edit)
														{				
															?> 			
																	<div id="cartificate_entrys">
																		<?php 
																		$tag_name=explode(",",$document_result->tag_names);
																		$div_tag_names=array();
																		foreach ($tag_name as $retrive_data)
																		{ 	
																				$div_tag_names[]=$retrive_data;
																		}
																		?>
																		<input type="hidden" name="hidden_tags[]" value="<?php echo esc_attr(implode(',',$div_tag_names));?>" id="hidden_tags1" row="1">
																		<div class="form-group">
																			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Title','lawyer_mgt');?><span class="require-field">*</span></label>	
																			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
																				<input type="text" name="cartificate_name" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>" class="form-control validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]" value="<?php if($edit){ echo esc_attr($document_result->title);}elseif(isset($_POST['cartificate_name'])) {echo esc_attr($_POST['cartificate_name']); }
																				?>" />								
																			</div>
																		</div>
																		<div class="form-group">	
																			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Select File','lawyer_mgt');?><span class="require-field">*</span></label>	
																			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">					
																				<input type="file" name="cartificate" class="form-control file_validation input-file"/>						
																				<input type="hidden" name="old_hidden_cartificate" value="<?php if($edit){ echo esc_attr($document_result->document_url);}elseif(isset($_POST['cartificate'])){ echo esc_attr($_POST['cartificate']); } ?>">					
																			</div>
																			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																				<a  target="blank" class="status_read btn btn-default" href="<?php print content_url().'/uploads/document_upload/'.$document_result->document_url; ?>" record_id="<?php echo $document_result->id;?>>
																				<i class="fa fa-download"></i><?php echo $document_result->document_url;?></a>
																			</div>
																		</div>
																		<div class="form-group">	
																			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Tags','lawyer_mgt');?></label>	
																			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">	      
																				<input type="text" name="tag_name" id="tag_name1" class="form-control tages_add ui-autocomplete-input validate[custom[onlyLetter_specialcharacter],maxSize[50]]"  placeholder="<?php esc_html_e('Enter New Tages','lawyer_mgt');?>" autocomplete="off" value="" row="1">	
																			</div>
																			<div id="suggesstion-box"></div>
																			<div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
																				<button type="button" class="btn btn-success botton_submit_pulse addtages_documents" id=""  row="1"><?php esc_html_e('Add Tag','lawyer_mgt') ?></button>
																		 
																			</div>		
																		<div class="form-group">
																			<div class="list_tag_name1  col-lg-4  col-md-4  col-sm-4 col-xs-12" row="1">
																		<?php
																	
																		$tag_name=explode(",",$document_result->tag_names);
																		if(!empty($tag_name))
                                                                        {
																			
																		foreach ($tag_name as $retrive_data)
																		{ 
																			if(!empty($retrive_data))
																			{
																			?>
																				<div class="added_tag tagging_name"><?php echo $retrive_data;?>
																				<i class="close fa fa-times removetages sugcolor" row="1" value="<?php echo esc_attr($retrive_data);?>"></i>
																				<input type="hidden"  name="documents_tag_names[][]" value="<?php echo esc_attr($retrive_data);?>">
																				</div>
																			<?php
																			}
																		}	
																		}
																		?>
																			</div>
																		</div>
																	</div>
															<?php				
														}			
														else
														{
														?>		
														<div id="cartificate_div">			
														<div id="cartificate_entry1" class="cartificate_entry" row="1">
															<input type="hidden" name="hidden_tags[]" value="" id="hidden_tags1" row="1">
															<div class="form-group">
															<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Title','lawyer_mgt');?><span class="require-field">*</span></label>		
															<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																<input type="text"  name="cartificate_name[]" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>"   class="form-control validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]"/>
															</div>
															<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">					
														 						
															<input type="file" name="cartificate[]" class="form-control doc_label file_validation input-file validate[required]">				
															</div>					
															<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">	      
													<input type="text" name="tag_name" id="tag_name1" class="form-control tages_add margin_cause doc_label ui-autocomplete-input validate[custom[onlyLetter_specialcharacter],maxSize[50]]" placeholder="<?php esc_html_e('Enter New Tages','lawyer_mgt');?>" autocomplete="off" value="" row="1">	
												</div>
												<div id="suggesstion-box"></div>
												<div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
													<button type="button" class="btn btn-success botton_submit_pulse addtages_documents" id="addtages_documents"  row="1"><?php esc_html_e('Add Tag','lawyer_mgt') ?></button>
												</div>	
											
												 		
												</div>
												<div class="list_tag_name1 col-lg-offset-7 col-lg-5 col-md-offset-7 col-md-5 col-sm-offset-7 col-sm-5 col-xs-12" value="" row="1">
													
												</div>
														</div>		
														</div>		
														<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
															<input type="button" value="<?php esc_html_e('Add More Documents','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_cirtificate()" class="add_cirtificate btn btn-success">
														</div>
														<?php
														}
														?>	
														<div class="form-group">
															<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="document_description"><?php esc_html_e('Description','lawyer_mgt');?></label>
															<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
																<textarea rows="3" class=" width_100_per_css validate[custom[address_description_validation],maxSize[150]]" name="document_description" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" id="document_description"><?php if($edit){ echo esc_textarea($document_result->document_description);}elseif(isset($_POST['document_description'])){ echo esc_textarea($_POST['document_description']); } ?></textarea>				
															</div>		
														</div>	
														<div class="offset-sm-2 col-sm-8">
															<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Add Documents','lawyer_mgt');}?>" id="save_documents" name="save_documents" class="btn btn-success"/>
														</div>
													</form>
												</div>        
											<?php		
											}
											if($active_tab=='documentslist')
											{												
											?>   
												
												<script type="text/javascript">
												jQuery(document).ready(function($)
												{
													"use strict"; 
													jQuery('.documents_list').DataTable({
														"responsive": true,
														"autoWidth": false,
														"order": [[ 1, "asc" ]],
														language:<?php echo wpnc_datatable_multi_language();?>,
														 "aoColumns":[
																	  {"bSortable": false},
																	  <?php if(in_array('document_title',$document_columns_array)) { ?>
														  {"bSortable": true},
														<?php  } ?>	
														<?php if(in_array('document_type',$document_columns_array)) { ?>
																  {"bSortable": true},
														<?php  } ?>
														<?php if(in_array('document_case_link',$document_columns_array)) { ?> 
																  {"bSortable": true},
														<?php  } ?>
														<?php if(in_array('tag_name',$document_columns_array)) {  ?>
																  {"bSortable": true},
														<?php  } ?>
														<?php if(in_array('status',$document_columns_array)) { ?> 
																  {"bSortable": true},
														<?php  } ?>
														<?php if(in_array('last_updated',$document_columns_array)) {  ?>
																  {"bVisible": true},	
														<?php  } ?>
														<?php if(in_array('document_description',$document_columns_array)) {  ?>
																  {"bSortable": true},  
														<?php  } ?>                 
																	  {"bSortable": false}
																   ]											
													});	
													$(".delete_check").on('click', function()
													{	
														if ($('.sub_chk:checked').length == 0 )
														{
															alert("<?php esc_html_e('Please select atleast one record','lawyer_mgt');?>");
															return false;
														}
														else
														{
															alert("<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>");
															return true;
														}
													});
												});
												jQuery(document).ready(function($)
												{		
													"use strict"; 
													jQuery('#select_all').on('click', function(e)
													{
														 if($(this).is(':checked',true))  
														 {
															$(".sub_chk").prop('checked', true);  
														 }  
														 else  
														 {  
															$(".sub_chk").prop('checked',false);  
														 } 
													});
													$("body").on("change", ".sub_chk", function()
													{ 
														if(false == $(this).prop("checked"))
														{ 
															$("#select_all").prop('checked', false); 
														}
														if ($('.sub_chk:checked').length == $('.sub_chk').length )
														{
															$("#select_all").prop('checked', true);
														}
													});
												});
												</script>
													<style>
													.filter_lable_doc
													{
														width:170px;
													}
													</style>
													<form  action="" method="post" class="form-horizontal" enctype='multipart/form-data'>	
													<div class="panel-body">
															<input type="hidden" name="hidden_case_id" class="hidden_case_id" value="<?php echo MJ_lawmgt_id_decrypt($_REQUEST['case_id']);?>">
															<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
																<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label filter_lable_doc"><?php esc_html_e('Filter By Document Status :','lawyer_mgt');?></label>
																<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																	<select class="form-control document_filter" name="document_filter">
																		<option value="-1"><?php esc_html_e('Select All','lawyer_mgt');?></option>
																		<option value="0"><?php esc_html_e('Read','lawyer_mgt');?></option>
																		<option value="1"><?php esc_html_e('Unread','lawyer_mgt');?></option>
																	</select> 
																</div>
																<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">												
																<input type="submit" class="btn delete_margin_bottom btn-primary btn_export" name="document_excle_selected" value="<?php esc_attr_e('Excel', 'lawyer_mgt' ) ;?> " />											
																<input type="submit" class="btn delete_margin_bottom btn-primary btn_export" name="document_csv_selected" value="<?php esc_attr_e('CSV', 'lawyer_mgt' ) ;?> " />
																<input type="submit" class="btn delete_margin_bottom btn-primary btn_export" name="document_pdf_selected" value="<?php esc_attr_e('PDF', 'lawyer_mgt' ) ;?> " />
																</div>
															</div>
														<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
															<table id="documents_list" class="documents_list documents_list_all_documets table table-striped table-bordered">
																 <thead>				 
																<tr>
																	<th><input type="checkbox" id="select_all"></th>
																	<?php if(in_array('document_title',$document_columns_array)) { ?>
													<th><?php  esc_html_e('Document Title ', 'lawyer_mgt' ) ;?></th>
												<?php  } ?>	
												<?php if(in_array('document_type',$document_columns_array)) { ?>	
													<th><?php  esc_html_e('Document Type ', 'lawyer_mgt' ) ;?></th>
												<?php  } ?>	
												<?php if(in_array('document_case_link',$document_columns_array)) { ?> 
													<th><?php esc_html_e('Case Link', 'lawyer_mgt' ) ;?></th>
												<?php  } ?>	
												<?php if(in_array('tag_name',$document_columns_array)) {  ?>
													<th><?php esc_html_e('Tags Name ', 'lawyer_mgt' ) ;?></th>
												<?php  } ?>	
												<?php if(in_array('status',$document_columns_array)) { ?>
													<th><?php esc_html_e('Status', 'lawyer_mgt' ) ;?></th>
												<?php  } ?>	
												<?php if(in_array('last_updated',$document_columns_array)) {  ?>
													<th> <?php esc_html_e('Last Updated', 'lawyer_mgt' ) ;?></th>
												<?php  } ?>	
												<?php if(in_array('document_description',$document_columns_array)) {  ?>	
													<th><?php  esc_html_e('Description', 'lawyer_mgt' ) ;?></th>
												<?php  } ?>					
																	<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
																</tr>
																</thead>
																<tbody>
																 <?php 
																	$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
																	$user_documents_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('documents');
																	if($user_role == 'attorney')
																	{	
																		$result=$obj_documents->MJ_lawmgt_get_casewise_all_documents($case_id);	
																		
																	}
																	elseif($user_role == 'client')
																	{	
																		$result=$obj_documents->MJ_lawmgt_get_casewise_all_documents($case_id);	
																	}
																	else
																	{	
																		$result=$obj_documents->MJ_lawmgt_get_casewise_all_documents($case_id);	
																	}
																	if(!empty($result))
																	{	
																		foreach ($result as $retrieved_data)
																		{								
																			$case_id=$retrieved_data->case_id;
																			
																			global $wpdb;		
																			$table_cases = $wpdb->prefix. 'lmgt_cases';
																			$case_name= $wpdb->get_row("SELECT case_name FROM $table_cases where id=".$case_id);
																		?>
																	<tr>	
																		<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->id); ?>"></td>
																			<?php if(in_array('document_title',$document_columns_array)) { ?>
																			<td class="title"><?php echo esc_html($retrieved_data->title);?></td>
																	<?php  } ?>
																	<?php if(in_array('document_type',$document_columns_array)) { ?>															
																			<td class="title"><?php echo esc_html($retrieved_data->type);?></td>	
																	<?php  } ?>
																	<?php if(in_array('document_case_link',$document_columns_array)) { ?> 
																			<td class="case_link"><a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>"><?php echo esc_html($case_name->case_name);?></a></td>
																	<?php  } ?>
																	<?php if(in_array('tag_name',$document_columns_array)) {  ?>
																			<td class="tags_name"><?php echo esc_html($retrieved_data->tag_names);?></td>	
																	<?php  } ?>
																	<?php if(in_array('status',$document_columns_array)) { ?>
																			<td class="tags_name">
																			<?php
																			$status=$obj_documents->MJ_lawmgt_check_documents_status_by_user($retrieved_data->id);	
																			echo esc_html($status);
																			?></td>
																	<?php  } ?>
																	<?php if(in_array('last_updated',$document_columns_array)) {  ?>
																			<td class="last_update"><?php echo esc_html($retrieved_data->last_update);?></td>
																	<?php  } ?>
																	<?php if(in_array('document_description',$document_columns_array)) {  ?>
																			<td class=""><?php echo esc_html($retrieved_data->document_description);?></td>	
																	<?php  } ?>
																		<td class="action"> 				
																		<a target="blank" href="<?php print content_url().'/uploads/document_upload/'.$retrieved_data->document_url; ?>" class="status_read btn btn-default" record_id="<?php echo $retrieved_data->id;?>"><i class="fa fa-download"></i><?php esc_html_e(' Download', 'lawyer_mgt');?></a>				
																		<?php
																		if($user_access_documents['edit']=='1')
																		{
																		?>
																			<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=documents&tab3=adddocuments&edit=true&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&documents_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
																		<?php
																		}
																		if($user_access_documents['delete']=='1')
																		{
																			?>	
																			<a href="?dashboard=user&page=cases&tab=casedetails&action=view&deletedocuments=true&tab2=documents&tab3=documentslist&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&documents_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" 
																			onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');">
																			<?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>				
																	<?php
																		}
																		?>		
																		</td>               
																	</tr>
																	<?php 
																		} 
																	}
																	?>     
																</tbody>        
															</table>
															<?php
															if($user_access_documents['delete']=='1')
															{
																if(!empty($result))
																{
																	?>
																	<div class="form-group">		
																		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
																			<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="document_delete_selected"  value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
																		</div>
																	</div>
																	<?php
																}
															}
															?>	
														</div>
													</div>
													</form>
											<?php 
											}									
									}
									if($active_tab=='task')
									{
										if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
										{
											//wp_redirect ( home_url() . '?dashboard=user');
											$redirect_url=home_url() . '?dashboard=user';
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
										$note=new MJ_lawmgt_Note;
										?>
										  <!-- POP up code -->
										<div class="popup-bg">
											<div class="overlay-content">
												<div class="modal-content">
													<div class="company_list">
													</div>
												</div>
											</div> 
										</div>
										<!-- End POP-UP Code -->										
										<?php
										$user_access_task=MJ_lawmgt_get_userrole_wise_filter_access_right_array('task');
										$active_tab = sanitize_text_field(isset($_GET['tab3'])?$_GET['tab3']:'tasklist');
										?>
										<h2>
											<ul id="myTab" class="sub_menu_css line nav nav-tabs" role="tablist">
													<li role="presentation" class="<?php echo esc_html($active_tab) == 'tasklist' ? 'active' : ''; ?>">
														<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=task&tab3=tasklist&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">						
															<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Task List', 'lawyer_mgt'); ?>
														</a>
													</li>
													
													<?php if(isset($_REQUEST['edit'])&& sanitize_text_field($_REQUEST['edit'])=='true') {?>
													<li role="presentation" class="<?php echo esc_html($active_tab) == 'addtask' ? 'active' : ''; ?>">
														<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=task&tab3=addtask&edit=true&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&task_id=<?php echo esc_attr($_REQUEST['task_id']);?>">
															<?php echo esc_html__('Edit Task', 'lawyer_mgt'); ?>
														</a>
													</li>
													<?php }
													else
													{
														if($user_access_task['add']=='1')
														{
															?>
															<li role="presentation" class="<?php echo esc_html($active_tab) == 'addtask' ? 'active' : ''; ?>">
																<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=task&tab3=addtask&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
																	<?php echo '<span class="fa fa-plus-circle"></span> '.esc_html__('Add Task', 'lawyer_mgt'); ?>	
																</a>
															</li>
															<?php 
														}
													}	
													 if(isset($_REQUEST['view'])&& sanitize_text_field($_REQUEST['view'])=='true') {?>
													<li role="presentation" class="<?php echo esc_html($active_tab) == 'viewtask' ? 'active' : ''; ?>">
														<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=task&tab3=viewtask&view=true&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&task_id=<?php echo esc_attr($_REQUEST['task_id']);?>">
														<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('View Task', 'lawyer_mgt'); ?>
														</a>
													</li>
													<?php }?>	
											</ul>
										</h2>
											<?php
										if($active_tab=='addtask')
										{	 
											$active_tab = sanitize_text_field(isset($_GET['tab3'])?$_GET['tab3']:'tasklist');
		 
											$obj_case_tast= new MJ_lawmgt_case_tast;
											?>
											<script type="text/javascript">
												jQuery(document).ready(function($)
												{
													"use strict"; 
													jQuery('#task_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
													var date = new Date();
													date.setDate(date.getDate()-0);
													jQuery('.date1').datepicker
													({
														startDate: date,
														autoclose: true
													});			
												}); 
												jQuery(document).ready(function($)
												{
													"use strict"; 
													$("#assigned_to_user").multiselect({
														enableFiltering: true,
														enableCaseInsensitiveFiltering: true,
														nonSelectedText :'Select Client',
														includeSelectAllOption: true         
													});
													$(".tasksubmit").on("click",function()
													{	
														var checked = $(".multiselect_validation .dropdown-menu input:checked").length;

														if(!checked)
														{
															alert("<?php esc_html_e('Please select atleast one Client Name','lawyer_mgt');?>");
															return false;
														}			
													}); 	
												});
												jQuery(document).ready(function($)
												{	
													"use strict"; 
													$("#assign_to_attorney").multiselect({ 
														enableFiltering: true,
														enableCaseInsensitiveFiltering: true,
														 nonSelectedText :'<?php esc_html_e('Select Attorney Name','lawyer_mgt');?>',
														  selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
														 includeSelectAllOption: true         
													});
													 
													$(".tasksubmit").on("click",function()
													{	
														var checked = $(".multiselect_validation123 .dropdown-menu input:checked").length;

														if(!checked)
														{
															 
															alert("<?php esc_html_e('Please select atleast one Attorney Name','lawyer_mgt');?>");
															return false;
														}			
													}); 
												});	
												function MJ_lawmgt_add_reminder()
												{
													"use strict"; 
													$("#reminder_entry").append('<div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" ><?php esc_html_e('Task Reminders','lawyer_mgt');?></label><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback"><select name="casedata[type][]" id="case_reminder_type"><option selected="selected" value="mail"><?php esc_html_e('Mail','lawyer_mgt');?></option></select></div><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 btn_margin has-feedback"><input id="remindertimevalue" class="form-control text-input validate[required]" type="number"  value="1" name="casedata[remindertimevalue][]" min="1"></div><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 btn_margin has-feedback"><select name="casedata[remindertimeformat][]" id="case_reminder_type"><option selected="selected" value="day"><?php esc_html_e('Day(s)','lawyer_mgt');?></option><option value="hour"><?php esc_html_e('Hour(s)','lawyer_mgt');?></option></select></div><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Task Due Date','lawyer_mgt');?></label><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger"></div></div>');   		
												}  	

												function MJ_lawmgt_deleteParentElement(n)
												{
													"use strict"; 
													alert("<?php esc_html_e('Do you really want to delete this ?','lawyer_mgt');?>");
													n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
												}
											</script>
											<?php 
												$case_id=0;
												$edt=0;
												if(isset($_REQUEST['task_id']))
													$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['task_id']));
													if(isset($_REQUEST['edit']) && sanitize_text_field($_REQUEST['edit']) == 'true')
													{					
														$edt=1;
														$casedata=$obj_case_tast->MJ_lawmgt_get_all_edit_tast($case_id);
													}   		  
													$args = array(	
															'role' => 'client',
															'meta_key'     => 'archive',
															'meta_value'   => '0',
															'meta_compare' => '=',
														); 	
													$result =get_users($args);	
												?>
											<div class="panel-body">
												<form name="task_form" action="" method="post" class="form-horizontal" id="task_form" enctype='multipart/form-data'>	
													 <?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
													<input id="action" class="form-control  text-input" type="hidden"  value="<?php if($edt){ echo 'edit'; }?>" name="action">
													<input type="hidden" name="case_id" value="<?php echo esc_attr($case_id);?>"  />
													<input type="hidden" name="task_id" id="task_id" value="<?php if($edt){ echo esc_attr($casedata->task_id);}?>"  />
													<div class="header">	
														<h3 class="first_hed"><?php esc_html_e('Linked To','lawyer_mgt');?></h3>
														<hr>
													</div>
													<div class="form-group">
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Case Link','lawyer_mgt');?><span class="require-field">*</span></label>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
															<?php
															global $wpdb; 
															$table_case = $wpdb->prefix. 'lmgt_cases';
															$result = $wpdb->get_row("SELECT * FROM $table_case where id=".sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id'])));
															?>
															<input id="case_id" class="form-control   validate[required] text-input" type="hidden"  value="<?php echo esc_attr($result->id); ?>" name="case_id">
															<input id="case_name" class="form-control   validate[required] text-input" type="text"  value="<?php echo esc_attr($result->case_name); ?>" name="case_name" readonly>
																		
														</div>
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="practice_area_id"><?php esc_html_e('Practice Area','lawyer_mgt');?></label>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
														<?php if($edt){ $data=$casedata->practice_area_id;}else{ $data=''; }
														   $obj_practicearea=new MJ_lawmgt_practicearea;
														?>
															<input type="hidden" class="form-control" value="<?php echo esc_attr($result->practice_area_id);?>" name="practice_area_id" id="practice_area_id" readonly />
															<input type="text" class="form-control" value="<?php echo esc_attr(get_the_title($result->practice_area_id)); ?>" name="practice_area_id1" id="practice_area_id1" readonly />
														</div>
													</div>
													<div class="header">
														<h3><?php esc_html_e('Task Information','lawyer_mgt');?></h3>
														<hr>
													</div>
													<?php wp_nonce_field( 'save_case_task_nonce' ); ?>
													<div class="form-group">
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="task_name"><?php esc_html_e('Task Name','lawyer_mgt');?><span class="require-field">*</span></label>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
															<input id="task_name" class="form-control validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]text-input "  type="text" placeholder="<?php esc_html_e('Enter Task Name','lawyer_mgt');?>" value="<?php if($edt){ echo esc_attr($casedata->task_name);}elseif(isset($_POST['task_name'])){ echo esc_attr($_POST['task_name']); } ?>" name="task_name">
														</div>
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="due_date"><?php esc_html_e('Due Date','lawyer_mgt');?><span class="require-field">*</span></label>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
															<input id="due_date"  class="date1 form-control validate[required]  has-feedback-left " type="text"  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" name="due_date"  placeholder="<?php esc_html_e('Select Due Date','lawyer_mgt');?>"
															value="<?php if($edt){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($casedata->due_date));}elseif(isset($_POST['due_date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['due_date'])); } ?>" readonly>
															<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
														</div>
													</div>	
													<div class="form-group">
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="city_name"><?php esc_html_e('Status','lawyer_mgt');?><span class="require-field">*</span></label>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
															<select class="form-control validate[required]" name="status" id="status">				
																<?php 
																if($edt)
																{
																?>
																	<option value="0" <?php if($edt && $casedata->status=='0') { print ' selected'; }?>><?php esc_html_e('Not Completed','lawyer_mgt');?></option>
																	<option value="1" <?php if($edt && $casedata->status=='1') { print ' selected'; }?>><?php esc_html_e('Completed','lawyer_mgt');?></option>
																<?php
																}
																?>
																<option value="2" <?php if($edt && $casedata->status=='2') { print ' selected'; }?>><?php esc_html_e('In Progress','lawyer_mgt');?></option>
															</select>
														</div>
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="pin_code"><?php esc_html_e('Description','lawyer_mgt');?><span class="require-field"></span></label>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
															<textarea id="description" class="form-control validate[custom[address_description_validation],maxSize[150]]" type="text" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>"  value="" name="description"><?php if($edt){ echo esc_textarea($casedata->description) ; } ?></textarea></div>
														</div>
													<div class="form-group col-md-12">
														<div class="header">	
															<div class="form-group">
															<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 res_label control-label " for="priority"><?php esc_html_e('Priority','lawyer_mgt');?></label>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
																	<select class="form-control " name="priority" id="priority">	<option value="0" <?php if($edt && $casedata->priority=='0') { print ' selected'; }?>><?php esc_html_e('High','lawyer_mgt');?></option>
																		<option value="1" <?php if($edt && $casedata->priority=='1') { print ' selected'; }?>><?php esc_html_e('Low','lawyer_mgt');?></option>
																		<option value="2" <?php if($edt && $casedata->priority=='2') { print ' selected'; }?>><?php esc_html_e('Medium','lawyer_mgt');?></option>
																	</select>
															   </div>			
																<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="Repeat"><?php esc_html_e('Repeat','lawyer_mgt');?></label>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
																<select class="form-control validate[required]" name="repeat" id="repeat">
																	<option value="0" <?php if($edt && $casedata->repeat=='0') { print ' selected'; }?>><?php esc_html_e('Never','lawyer_mgt');?></option>
																	<option value="1" <?php if($edt && $casedata->repeat=='1') { print ' selected'; }?>><?php esc_html_e('Every day','lawyer_mgt');?></option>
																	<option value="2" <?php if($edt && $casedata->repeat=='2') { print ' selected'; }?>><?php esc_html_e('Every week','lawyer_mgt');?></option>
																	<option value="3" <?php if($edt && $casedata->repeat=='3') { print ' selected'; }?>><?php esc_html_e('Every 2 weeks','lawyer_mgt');?></option>
																	<option value="4" <?php if($edt && $casedata->repeat=='4') { print ' selected'; }?>><?php esc_html_e('Every month','lawyer_mgt');?></option>
																	<option value="5" <?php if($edt && $casedata->repeat=='5') { print ' selected'; }?>><?php esc_html_e('Every year','lawyer_mgt');?></option>
																</select>
																</div>
															   </div>
															   <?php 
																if($edt)
																{
																	$repeatdata=$casedata->repeat;
																}
																else
																{
																	$repeatdata="";
																}
															   ?>
															   <div class="form-group repeatuntil_div display_block_css" <?php if($edt && $repeatdata=='1' || $repeatdata=='2' || $repeatdata=='3' || $repeatdata=='4' || $repeatdata=='5') { ?> <?php }?>>
															   <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12has-feedback">
																	<input id="repeatuntil"  class="date1 form-control has-feedback-left " type="text" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>"  name="repeatuntil"  placeholder=""
																	value="<?php if($edt){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($casedata->repeat_until)); }elseif(isset($_POST['repeat_until'])){ echo (esc_attr($_POST['repeat_until'])); } ?>">
																	<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
																</div>
															</div>
															<?php
															if($edt)
															{
																$task_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['task_id']));
																$result_reminder=$obj_case_tast->MJ_lawmgt_get_single_task_reminder($task_id);				
																if(!empty($result_reminder))	
																{	
																	foreach ($result_reminder as $retrive_data)
																	{ 
																	?>	
																		<div id="reminder_entry">
																			<div class="form-group">			
																				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Task Reminders','lawyer_mgt');?></label>
																				<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
																					<input type="hidden" name="casedata[id][]" value="<?php echo esc_attr($retrive_data->id);?>">
																					<select name="casedata[type][]" id="case_reminder_types">
																						<option selected="selected" value="mail" <?php if($retrive_data=='mail') { print ' selected'; }?>><?php echo $retrive_data->reminder_type;?></option>
																					</select>
																				</div>
																				<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback btn_margin">
																				<input id="remindertimevalue" class="form-control text-input validate[required]" type="number"  value="<?php echo esc_attr($retrive_data->reminder_time_value); ?>" name="casedata[remindertimevalue][]" min="1">
																				</div>
																				<div class="ccol-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback btn_margin">
																				<select name="casedata[remindertimeformat][]" id="case_reminder_type">
																					<?php 
																						$reminder_value=$retrive_data->reminder_time_format;
																						?>
																						<option value="day" <?php if($reminder_value=='day') { print ' selected'; }?>><?php esc_html_e('Day(s)','lawyer_mgt'); ?></option>
																						<option value="hour" <?php if($reminder_value=='hour') { print ' selected'; }?>><?php esc_html_e('Hour(s)','lawyer_mgt'); ?></option>																						
																				</select>
																				</div>
																				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Task Due Date','lawyer_mgt') ?></label>
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																					<input type="button" value="<?php esc_html_e('Remove','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger">
																				</div>				
																			</div>		
																		</div>	
																	<?php				
																	}
																}
																else
																{
																?>
																	 <div id="reminder_entry">
																	 </div>
																<?php
																}	
																?>
																<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
																	<input type="button" value="<?php esc_html_e('Add Reminder','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_reminder()" class="add_reminder btn btn-success">
																</div>		
															<?php		
															}
															else
															{
															?>
																<div id="reminder_entry">
																	<div class="form-group">	
																		<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Task Reminders','lawyer_mgt');?></label>
																		<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
																			<select name="casedata[type][]" id="case_reminder_types">
																				<option selected="selected" value="mail"><?php esc_html_e('Mail','lawyer_mgt') ?></option>
																			</select>
																		</div>
																		<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 btn_margin has-feedback">
																		<input id="remindertimevalue" class="form-control text-input validate[required]" type="number"  value="1" name="casedata[remindertimevalue][]" min="1">
																		</div>
																		<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 btn_margin has-feedback">
																		<select name="casedata[remindertimeformat][]" id="case_reminder_type">
																			<option selected="selected" value="day"><?php esc_html_e('Day(s)','lawyer_mgt') ?></option>
																			<option value="hour"><?php esc_html_e('Hour(s)','lawyer_mgt') ?></option>																			
																		</select>
																		</div>
																		<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Before Task Due Date','lawyer_mgt') ?></label>
																		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																			<input type="button" value="<?php esc_attr_e('Remove','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger">
																		</div>		
																	</div>		
																</div>				  
																<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
																	<input type="button" value="<?php esc_attr_e('Add Reminder','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_reminder()" class="add_reminder btn btn-success">
																</div>	
															<?php 
															} 
															?>
															<div class="header">	
																<h3 class="tsk_label_new"><?php esc_html_e('Assign To','lawyer_mgt');?></h3>
																<hr>
															</div>
															<div class="form-group">
																<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="assigned_to_user"><?php esc_html_e('Contact Name','lawyer_mgt');?><span class="require-field">*</span></label>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback multiselect_validation">
																	<?php 
																	if($edt)
																	{ 
																	$data=$casedata->assigned_to_user;
																	}elseif(isset($_POST['assigned_to_user']))  
																	{ 
																	$data=sanitize_text_field($_POST['assigned_to_user']); 
																	}
																	?>
																		   <?php 
																				global $wpdb;
																				$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
																				
																				$userdata = $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id'])));
																				
																			?>
																		<select class="form-control validate[required]" multiple="multiple" name="assigned_to_user[]" id="assigned_to_user">				
																			<?php
																			if(!empty($userdata))
                                                                            {
																			foreach($userdata as $contactdata)
																			{ 
																				$user_details=get_userdata($contactdata->user_id);
																				$user_name=esc_html($user_details->display_name);	
																			?>
																			 <option value="<?php print esc_attr($contactdata->user_id); ?>" <?php echo in_array($contactdata->user_id,explode(',',$data)) ? 'selected' : ''; ?>>
																				<?php echo esc_html($user_name);?>
																			</option>
																		<?php }
																			}?>
																		</select>
																</div>
																<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="assigned_to_attorney"><?php esc_html_e('Attorney Name','lawyer_mgt');?><span class="require-field">*</span></label>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback multiselect_validation123">
																	<?php if($edt){ $data=$casedata->assign_to_attorney;}elseif(isset($_POST['assign_to_attorney'])) { $data=sanitize_text_field($_POST['assign_to_attorney']);
																	}
																	?>
																		<?php 
																				global $wpdb;
																				$table_case = $wpdb->prefix. 'lmgt_cases';													
																				$userdata = $wpdb->get_results("SELECT case_assgined_to FROM $table_case where id=".sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id'])));
																				 
																				$user_array=$userdata[0]->case_assgined_to;
																				  
																				$newarraay=explode(',',$user_array);
																				 
																			?>
																		<select class="form-control validate[required] assign_to_attorney" multiple="multiple" name="assign_to_attorney[]" id="assign_to_attorney">				
																			<?php 
																			if(!empty($newarraay))
																			{
																				foreach ($newarraay as $retrive_data)
																				{ 
																				$user_details=get_userdata($retrive_data);
																				$user_name=esc_html($user_details->display_name);
																				?>
																					<option value="<?php print esc_attr($user_details->ID);?>" <?php echo in_array($user_details->ID,explode(',',$data)) ? 'selected': ''; ?>>
																						<?php echo esc_html($user_name);?>
																					</option>
																				<?php 
																				}
																			} ?>
																		</select>
																</div>
															</div>
														 
														   </div>
															<div class="form-group margin_top_div_css1">
																<div class="offset-sm-2 col-sm-8">
																	  <input type="submit" id="" name="savetast" class="btn btn-success tasksubmit" value="<?php if($edt){
																	   esc_attr_e('Save Task','lawyer_mgt');}else{ esc_attr_e('Add Task','lawyer_mgt');}?>"></input>
																</div>
															</div>														   
														</div>       
													</div>       
												</form>
											</div>
										<?php
										}
										if($active_tab=='viewtask')
										{	
										?>
											<style>
												.task_detail_div
												{
													border: 1px solid #ddd;
													margin: 15px 0px;
													padding: 10px;
												}
												.table_row .table_td 
												{
												  padding: 10px 10px !important;
												}									
											</style>
										<?php 
											$obj_case_tast= new MJ_lawmgt_case_tast;
										
											if(isset($_REQUEST['task_id']))
												$task_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['task_id']));
												
												if(isset($_REQUEST['view']) && sanitize_text_field($_REQUEST['view']) == 'true')
												{	
													$casedata=$obj_case_tast->MJ_lawmgt_get_all_edit_tast($task_id);
												} 
												?>		
											<div class="panel-body panel_body_flot_css">
												<div class="header">	
													<h3 class="first_hed"><?php esc_html_e('Linked To','lawyer_mgt');?></h3>
													<hr>
												</div>
												<div class="viewtaskdetails">				
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 task_detail_div">							
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
															<div class="table_row">
																<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																	<?php esc_html_e('Case Name','lawyer_mgt'); ?>
																</div>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																	<span class="txt_color">
																	<?php
																		$case_link=MJ_lawmgt_get_case_name($casedata->case_id);
																		 echo esc_html($case_link);
																		?>
																	</span>
																</div>
															</div>
															<div class="table_row">
																<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																	<?php esc_html_e('Practice Area','lawyer_mgt'); ?>
																</div>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																	<span class="txt_color">
																	<?php
																		 echo esc_html(get_the_title($casedata->practice_area_id));
																		?>
																	</span>
																</div>
															</div>
														</div>
													</div>
													<div class="header">	
														<h3 class="first_hed"><?php esc_html_e('Task Information','lawyer_mgt');?></h3>
														<hr>
													</div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 task_detail_div">							
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
															<div class="table_row">
																<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																	<?php esc_html_e('Task Name','lawyer_mgt'); ?>
																</div>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																	<span class="txt_color">
																	<?php									
																		 echo esc_html($casedata->task_name);
																		?>
																	</span>
																</div>
															</div>
															<div class="table_row">
																<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																	<?php esc_html_e('Due Date','lawyer_mgt'); ?>
																</div>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																	<span class="txt_color">
																	<?php
																		 echo esc_html(MJ_lawmgt_getdate_in_input_box($casedata->due_date));
																		?>
																	</span>
																</div>
															</div>
														</div>
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
															<div class="table_row">
																<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																	<?php esc_html_e('Status','lawyer_mgt'); ?>
																</div>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																	<span class="txt_color">
																	<?php
																		if($casedata->status == '0')
																		{
																			$status="Not Completed";	
																		}
																		elseif($casedata->status == '1')
																		{
																			$status="Completed";	
																		}
																		elseif($casedata->status == '2')
																		{
																			$status="In Progress";	
																		}									
																		 echo esc_html($status);
																	?>
																	</span>
																</div>
															</div>
															<div class="table_row">
																<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																	<?php esc_html_e('Description','lawyer_mgt'); ?>
																</div>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																	<span class="txt_color">
																	<?php
																		 echo esc_html($casedata->description);
																		?>
																	</span>
																</div>
															</div>
														</div>
													</div>					
													<div class="header">	
														<h3 class="first_hed"><?php esc_html_e('Assign To','lawyer_mgt');?></h3>
														<hr>
													</div>							
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 task_detail_div">							
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
															<div class="table_row">
																<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																	<?php esc_html_e('Client Name','lawyer_mgt'); ?>
																</div>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																	<span class="txt_color">
																	<?php
																		$user=explode(",",$casedata->assigned_to_user);
																		$user_name=array();
																		if(!empty($user))
																		{						
																			foreach($user as $data)
																			{
																				$user_name[]=esc_html(MJ_lawmgt_get_display_name($data));
																			}
																		}			
																		 echo esc_html(implode(",",$user_name));
																		?>
																	</span>
																</div>
																<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																	<?php esc_html_e('Attorney Name','lawyer_mgt'); ?>
																</div>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																	<span class="txt_color">
																	<?php
																		$user=explode(",",$casedata->assign_to_attorney);
																		$user_name=array();
																		if(!empty($user))
																		{						
																			foreach($user as $data)
																			{
																				$user_name[]=esc_html(MJ_lawmgt_get_display_name($data));
																			}
																		}			
																		 echo esc_html(implode(",",$user_name));
																		?>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>	
											</div>
											 <?php 
										}
										if($active_tab=='tasklist')
										{?>
											<script type="text/javascript">
												jQuery(document).ready(function($)
												{
													"use strict"; 
													jQuery('#case_tast_list').DataTable({
															"responsive": true,
															"autoWidth": false,
															"order": [[ 1, "asc" ]],
															language:<?php echo wpnc_datatable_multi_language();?>,
															 "aoColumns":[																		
																		  {"bSortable": false},
																		  {"bSortable": true},
																		  {"bSortable": true},
																		  {"bSortable": true},
																		  {"bSortable": true},
																		   
																		  {"bSortable": true},
																		 {"bSortable": true},
																		  {"bSortable": true},
																		  {"bSortable": false}
																	   ]		               		
															});	
														$(".delete_check").on('click', function()
														{	
															if ($('.sub_chk:checked').length == 0 )
															{
																 alert("<?php esc_html_e('Please select atleast one record','lawyer_mgt');?>");
																return false;
															}
															else{
																alert("<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>");
																return true;
															}
															 
														});	 
												});
												jQuery(document).ready(function($)
												{	
													"use strict"; 
													jQuery('#select_all').on('click', function(e)
													{
														 if($(this).is(':checked',true))  
														 {
															$(".sub_chk").prop('checked', true);  
														 }  
														 else  
														 {  
															$(".sub_chk").prop('checked',false);  
														 } 
													});
													$("body").on("change", ".sub_chk", function()
													{ 
														if(false == $(this).prop("checked"))
														{ 
															$("#select_all").prop('checked', false); 
														}
														if ($('.sub_chk:checked').length == $('.sub_chk').length )
														{
															$("#select_all").prop('checked', true);
														}
													});
												});		
												jQuery(document).ready(function($) 
												{
													"use strict"; 
													jQuery('#tast_list').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
												} );
											</script>
											<form name="tast_list" action="" method="post" enctype='multipart/form-data'>
											<div class="panel-body">
												<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">	
													<table id="case_tast_list" class="tast_list1 table table-striped table-bordered">
														<thead>																		
														<?php	
															$user_task_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('task');
															$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
															if($user_role == 'attorney')
															{	
																$casedata=$obj_case_tast->MJ_lawmgt_get_tast_by_caseid($case_id);
															}
															elseif($user_role == 'client')
															{	
																if($user_task_access['own_data'] == '1')
																{	
																	$current_user_id = get_current_user_id();
																	$casedata=$obj_case_tast->MJ_lawmgt_get_tast_by_caseid_and_client($case_id,$current_user_id);	
																	
																}
																else
																{																	
																	$casedata=$obj_case_tast->MJ_lawmgt_get_tast_by_caseid($case_id);
																}
															}
															else
															{	
																if($user_task_access['own_data'] == '1')
																{																	
																	$casedata=$obj_case_tast->MJ_lawmgt_get_tast_by_caseid_created_by($case_id);
																}
																else
																{																	
																	$casedata=$obj_case_tast->MJ_lawmgt_get_tast_by_caseid($case_id);
																}															
															}
														?>      
														<tr>
															<th><input type="checkbox" id="select_all"></th>
															<th><?php  esc_html_e('Task Name', 'lawyer_mgt' ) ;?></th>
															<th><?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
															<th> <?php esc_html_e('Due Date', 'lawyer_mgt' ) ;?></th>
															<th> <?php esc_html_e('Status', 'lawyer_mgt' ) ;?></th>
															<th> <?php esc_html_e('Priority', 'lawyer_mgt' ) ;?></th>
														    <th> <?php esc_html_e('Assign To Client', 'lawyer_mgt' ) ;?></th>
															<th> <?php esc_html_e('Assign To Attorney', 'lawyer_mgt' ) ;?></th>
															<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
														</tr>														
														</thead>
														<tbody>
																<?php
																if(!empty($casedata))
																{		
																	foreach ($casedata as $retrieved_data)
																	{
																		$user_id=$retrieved_data->assigned_to_user;
																		 
																		$contac_id=explode(',',$user_id);
																		 
																		$user_name=array();
																		if(!empty($attorney_name))
																		{
																			foreach($contac_id as $contact_name)
																			{	
																				$userdata=get_userdata($contact_name);													
																				$user_name[]=esc_html($userdata->display_name);
																			}
																		}
																		 $attorney=$retrieved_data->assign_to_attorney;
																			$attorney_name=explode(',',$attorney);
																			$attorney_name1=array();
																			if(!empty($attorney_name))
																		    {
																				foreach($attorney_name as $attorney_name2) 
																				{
																					$attorneydata=get_userdata($attorney_name2);	
																						
																					$attorney_name1[]=esc_html($attorneydata->display_name);										   
																				}
																			}
																		$case_name=MJ_lawmgt_get_case_name_by_id($retrieved_data->case_id);
																		if(!empty($case_name))
																		{
																			foreach($case_name as $case_name1)
																			{
																				$case_name2=esc_html($case_name1->case_name);
																			}
																		}
																		
																		 if($retrieved_data->status==0){
																		 $statu='Not Completed';
																		 }else if($retrieved_data->status==1){
																		 $statu='Completed';
																		 }else{
																		 $statu='In Progress';
																		 }
																		 if($retrieved_data->priority==0){
																		 $prio='High';
																		 }else if($retrieved_data->priority==1){
																		 $prio='Low';
																		 }else{
																		 $prio='Medium';
																		 }
																		?>
																		<tr>
																			<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_attr($retrieved_data->task_id); ?>"></td>	
																			 <td class="email"><?php echo esc_html($retrieved_data->task_name);?></td>
																			 <td class="prac_area"><a href="?dashboard=user&page=cases&tab=casedetails&action=view&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>"><?php echo esc_html($case_name2); ?></a></td>	
																			<td class="added"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->due_date));?></td>						 
																			<td class="added"><?php echo esc_html($statu);?></td>
																			<td class="contact_link"><?php echo esc_html($prio); ?></td>					
																		 				 
																			<td class="added"><?php echo esc_html(implode($user_name,','));?></td>
																			<td class="added"><?php echo esc_html(implode($attorney_name1,','));?></td>
																			 
																			 <td class="action"> 
																			<a href="?dashboard=user&dashboard=user&page=cases&tab=casedetails&action=view&tab2=task&tab3=viewtask&view=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&task_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->task_id));?>" id='view_task_user' class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
																			 <?php
																			if($user_access_task['edit']=='1')
																			{
																				
																				?>
																				 <a href="?dashboard=user&dashboard=user&page=cases&tab=casedetails&action=view&tab2=task&tab3=addtask&edit=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&task_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->task_id));?>" id="ediit" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
																				 <?php
																			}		
																			if($user_access_task['delete']=='1')
																			{
																			
																			?>	
																			 <a href="?dashboard=user&page=cases&tab=casedetails&action=view&editats=true&deletetask=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&task_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->task_id));?>" class="btn btn-danger" 
																				onclick="return confirm('<?php esc_html_e('Are you sure you want to Delete this Task ?','lawyer_mgt');?>');">
																			  <?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>					
																		<?php
																			}
																			?>		
																			  </td>               
																		</tr>
															<?php 	} 			
																} ?>     
															</tbody> 
													 </table>
													  <?php
													if($user_access_task['delete']=='1')
													{
														if(!empty($casedata))
														{		
																	
															?>
															<div class="form-group">		
																<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
																	<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="task_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
																</div>
															</div>
															<?php
														}
													}
													?>	
												</div>
											</div>  
											</form>
										 <?php 
										}	  						
									}
									if($active_tab=='note')
									{
										$note=new MJ_lawmgt_Note;
										?>
										  <!-- POP up code -->
										<div class="popup-bg">
											<div class="overlay-content">
												<div class="modal-content">
													<div class="company_list">
													</div>
												</div>
											</div> 
										</div>
										<!-- End POP-UP Code -->
										<script type="text/javascript">
											jQuery(document).ready(function($)
											{
												"use strict"; 
												jQuery('#note_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
												
												var date = new Date();
												date.setDate(date.getDate()-0);
												jQuery('.date1').datepicker
												({
													startDate: date,
													autoclose: true
												});		
											}); 
											jQuery(document).ready(function($)
											{	
												"use strict"; 
												$("#assigned_to_user").multiselect({ 
													enableFiltering: true,
													enableCaseInsensitiveFiltering: true,
													nonSelectedText :'Select Client',
													 includeSelectAllOption: true         
												});	
												$(".submitnote").on("click",function()
												{	
													var checked = $(".multiselect_validation .dropdown-menu input:checked").length;

													if(!checked)
													{
														alert("<?php esc_html_e('Please select atleast one Client Name','lawyer_mgt');?>");
														return false;
													}			
												});			
											});
											jQuery(document).ready(function($)
											{		
												"use strict"; 
												$("#assign_to_attorney").multiselect({ 
													enableFiltering: true,
													enableCaseInsensitiveFiltering: true,
													 nonSelectedText :'<?php esc_html_e('Select Attorney Name','lawyer_mgt');?>',
													  selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
													 includeSelectAllOption: true         
												});
												 
												$(".submitnote").on("click",function()
												{	
													var checked = $(".multiselect_validation123 .dropdown-menu input:checked").length;

													if(!checked)
													{
														 
														alert("<?php esc_html_e('Please select atleast one Attorney Name','lawyer_mgt');?>");
														return false;
													}			
												}); 
											});	
										</script>	
										   <?php 	
											$user_access_note=MJ_lawmgt_get_userrole_wise_filter_access_right_array('note');	
											$active_tab = sanitize_text_field(isset($_GET['tab3'])?$_GET['tab3']:'notelist');
											?>
											<h2>
												<ul id="myTab" class="sub_menu_css line nav nav-tabs" role="tablist">
														<li role="presentation" class="<?php echo esc_html($active_tab) == 'notelist' ? 'active' : ''; ?>">
															<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=note&tab3=notelist&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
																<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Note List', 'lawyer_mgt'); ?>
															</a>
														</li>
														
														<?php if(isset($_REQUEST['editnote'])&& sanitize_text_field($_REQUEST['editnote'])=='true') {?>
														<li role="presentation" class="<?php echo esc_html($active_tab) == 'addnote' ? 'active' : ''; ?>">
															<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=note&tab3=addnote&editnote=true&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&note_id=<?php echo esc_attr($_REQUEST['note_id']);?>">
																<?php echo esc_html__('Edit Note', 'lawyer_mgt'); ?>
															</a>
														</li>
														<?php }
															else
															{
																if($user_access_note['add']=='1')
																{
																	?>
																	<li role="presentation" class="<?php echo esc_html($active_tab) == 'addnote' ? 'active' : ''; ?>">
																		<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=note&tab3=addnote&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
																			<?php echo '<span class="fa fa-plus-circle"></span> '.esc_html__('Add Note', 'lawyer_mgt'); ?>
																		</a>
																	</li>
																	<?php
																} 
														}
														if(isset($_REQUEST['viewnote'])&& sanitize_text_field($_REQUEST['viewnote'])=='true') {?>
														<li role="presentation" class="<?php echo $active_tab == 'viewnote' ? 'active' : ''; ?>">
															<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=note&tab3=viewnote&viewnote=true&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&note_id=<?php echo $_REQUEST['note_id'];?>">
																<?php echo esc_html__('View Note', 'lawyer_mgt'); ?>
															</a>
														</li>
														<?php } ?>
												</ul> 
											</h2>
											<?php
											if($active_tab=='viewnote')
											{
											?>
												<style>
													.task_detail_div
													{
														border: 1px solid #ddd;
														margin: 15px 0px;
														padding: 10px;
													}
													.table_row .table_td 
													{
													  padding: 10px 10px !important;
													}
												</style>
												<?php 
												$note=new MJ_lawmgt_Note;
											
												if(isset($_REQUEST['note_id']))
												$note_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['note_id']));
												if(isset($_REQUEST['viewnote']) && sanitize_text_field($_REQUEST['viewnote']) == 'true')
												{	
													$casedata=$note->MJ_lawmgt_get_signle_note_by_id($note_id);
												} 
													?>		
													<div class="panel-body viewnote">
														<div class="header">	
															<h3 class="first_hed"><?php esc_html_e('Linked To','lawyer_mgt');?></h3>
															<hr>
														</div>
														<div class="viewtaskdetails">				
															<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 task_detail_div">							
																<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
																	<div class="table_row">
																		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																			<?php esc_html_e('Case name','lawyer_mgt'); ?>
																		</div>
																		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 table_td">
																			<span class="txt_color">
																			<?php
																				$case_link=MJ_lawmgt_get_case_name($casedata->case_id);
																				echo esc_html($case_link);
																			?>
																			</span>
																		</div>
																	</div>
																	<div class="table_row">
																		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																			<?php esc_html_e('Practice Area','lawyer_mgt'); ?>
																		</div>
																		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 table_td">
																			<span class="txt_color">
																			<?php
																				 echo esc_html(get_the_title($casedata->practice_area_id));
																				?>
																			</span>
																		</div>
																	</div>
																</div>
																<div class="col-md-12">	
																	<div class="table_row">
																		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																			<?php esc_html_e('Client Name','lawyer_mgt'); ?>
																		</div>
																		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 table_td">
																			<span class="txt_color">
																		<?php
																				$user=explode(",",$casedata->assigned_to_user);
																				$user_name=array();
																				if(!empty($user))
																				{						
																					foreach($user as $data)
																					{
																						$user_name[]=esc_html(MJ_lawmgt_get_display_name($data));
																					}
																				}			
																				 echo esc_html(implode(",",$user_name));
																				?>
																			</span>
																		</div>
																		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																			<?php esc_html_e('Attorney Name','lawyer_mgt'); ?>
																		</div>
																		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																			<span class="txt_color">
																			<?php
																				$user=explode(",",$casedata->assign_to_attorney);
																				$user_name=array();
																				if(!empty($user))
																				{						
																					foreach($user as $data)
																					{
																						$user_name[]=esc_html(MJ_lawmgt_get_display_name($data));
																					}
																				}			
																				 echo esc_html(implode(",",$user_name));
																				?>
																			</span>
																		</div>
																	</div>
																</div>
															</div>
															<div class="header">	
																<h3 class="first_hed"><?php esc_html_e('Note Information','lawyer_mgt');?></h3>
																<hr>
															</div>
															<div class="col-md-12 col-sm-12 task_detail_div">							
																<div class="col-md-12">	
																	<div class="table_row">
																		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																			<?php esc_html_e('Note Name','lawyer_mgt'); ?>
																		</div>
																		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 table_td">
																			<span class="txt_color">
																			<?php									
																				 echo esc_html($casedata->note_name);
																				?>
																			</span>
																		</div>
																	</div>
																	<div class="table_row">
																		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																			<?php esc_html_e('Note','lawyer_mgt'); ?>
																		</div>
																		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 table_td">
																			<span class="txt_color">
																			<?php
																				 echo esc_html($casedata->note);
																				?>
																			</span>
																		</div>
																	</div>
																</div>
																<div class="col-md-12">	
																	<div class="table_row">
																		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																			<?php esc_html_e('Date','lawyer_mgt'); ?>
																		</div>
																		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 table_td">
																			<span class="txt_color">
																			<?php
																				 echo esc_html(MJ_lawmgt_getdate_in_input_box($casedata->date_time));
																				?>
																			</span>
																		</div>
																	</div>
																</div>
															</div>	
														</div>
													</div>
												 <?php 										 								 
											}
											if($active_tab=='addnote')
											{		
												$note_id=0;
												$edt=0;
												if(isset($_REQUEST['note_id']))
													$note_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['note_id']));
													$casedata='';
													if(isset($_REQUEST['editnote']) && sanitize_text_field($_REQUEST['editnote']) == 'true')
													{					
														$edt=1;
														$casedata=$note->MJ_lawmgt_get_signle_note_by_id($note_id);
													}?>
												<div class="panel-body">
													<form name="note_form" action="" method="post" class="form-horizontal" id="note_form" enctype='multipart/form-data'>	
														<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
														<input id="action" class="form-control  text-input" type="hidden"  value="<?php echo esc_attr($action); ?>" name="action">
														<input id="action1" class="form-control  text-input" type="hidden"  value="<?php if($edt) { echo 'editnote'; }?>" name="action1">
														<input type="hidden" name="note_id1" id="note_id" value="<?php if($edt){ echo esc_attr($casedata->note_id);}?>"  />
														<div class="header">	
															<h3 class="first_hed"><?php esc_html_e('Linked To','lawyer_mgt');?></h3>
															<hr>
														</div>
														<div class="form-group">
																<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Case Name','lawyer_mgt');?><span class="require-field">*</span></label>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
																	<?php 
																	global $wpdb;
																	$table_case = $wpdb->prefix. 'lmgt_cases';	
																	$result = $wpdb->get_row("SELECT * FROM $table_case where id=".sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id'])));
																	?>
																	<input id="case_id" class="form-control   validate[required] text-input" type="hidden"  value="<?php echo esc_attr($result->id); ?>" name="case_id">
																	<input id="case_name" class="form-control   validate[required] text-input" type="text"  value="<?php echo esc_attr($result->case_name); ?>" name="case_name" readonly>
																</div>
																<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="practice_area_id"><?php esc_html_e('Practice Area','lawyer_mgt');?></label>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
																<?php if($edt){ $data=$casedata->practice_area_id;}else{ $data=''; }
																   $obj_practicearea=new MJ_lawmgt_practicearea;
																?>
																	<input type="hidden" class="form-control" value="<?php echo esc_attr($result->practice_area_id);?>" name="practice_area_id" id="practice_area_id" readonly />
																	<input type="text" class="form-control" value="<?php echo esc_attr(get_the_title($result->practice_area_id)); ?>" name="practice_area_id1" id="practice_area_id1" readonly />
																</div>
														</div>
														<div class="form-group">
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="assigned_to_user"><?php esc_html_e('Client Name','lawyer_mgt');?><span class="require-field">*</span></label>
															<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback multiselect_validation">
															<?php if($edt){ $data=$casedata->assigned_to_user;}elseif(isset($_POST['assigned_to_user'])) { $data=sanitize_text_field($_POST['assigned_to_user']); } ?>
																<?php $conats=explode(',',$data);
																   $Editdata=MJ_lawmgt_get_user_by_edit_case_id(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id'])));
																?>
																<select class="form-control validate[required] assigned_to_user" multiple="multiple" name="assigned_to_user[]" id="assigned_to_user">				
																	<?php 
																	foreach($Editdata as $Editdata1)
																	{
																		$userdata=get_userdata($Editdata1->user_id);
																		$user_name=esc_html($userdata->display_name);
																	?>
																		<option value="<?php print esc_attr($Editdata1->user_id);?>" <?php echo in_array($Editdata1->user_id,explode(',',$data)) ? 'selected': ''; ?>>
																			<?php echo esc_html($user_name);?>
																		</option>
																	<?php 
																	 }
																	 ?>
																</select>
															</div>
															<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="assigned_to_attorney"><?php esc_html_e('Attorney Name','lawyer_mgt');?><span class="require-field">*</span></label>
															<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback multiselect_validation123">
																<?php if($edt){ $data=$casedata->assign_to_attorney;}elseif(isset($_POST['assign_to_attorney'])){ $data=sanitize_text_field($_POST['assign_to_attorney']); } ?>
																	<?php 
																			global $wpdb;
																			$table_case = $wpdb->prefix. 'lmgt_cases';													
																			$userdata = $wpdb->get_results("SELECT case_assgined_to FROM $table_case where id=".sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id'])));
																			 
																			$user_array=$userdata[0]->case_assgined_to;
																			  
																			$newarraay=explode(',',$user_array);
																			 
																		?>
																	<select class="form-control validate[required] assign_to_attorney" multiple="multiple" name="assign_to_attorney[]" id="assign_to_attorney">				
																		<?php 
																		if(!empty($newarraay))
																		{
																			foreach ($newarraay as $retrive_data)
																			{ 
																			$user_details=get_userdata($retrive_data);
																			$user_name=esc_html($user_details->display_name);
																			?>
																				<option value="<?php print esc_attr($user_details->ID);?>" <?php echo in_array($user_details->ID,explode(',',$data)) ? 'selected': ''; ?>>
																					<?php echo esc_html($user_name);?>
																				</option>
																			<?php 
																			}
																		} ?>
																	</select>
															</div>
														</div>
														<div class="header">
															<h3><?php esc_html_e('Note Information','lawyer_mgt');?></h3>
															<hr>
														</div>  
														<div class="form-group">
															<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="note_name"><?php esc_html_e('Note Name','lawyer_mgt');?><span class="require-field">*</span></label>
															<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
																<input id="note_name" class="form-control validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]text-input "  type="text" placeholder="<?php esc_html_e('Enter Note Name','lawyer_mgt');?>" value="<?php if($edt){ echo esc_attr($casedata->note_name);}elseif(isset($_POST['note_name'])) {echo esc_attr($_POST['note_name']); } ?>" name="note_name">
															</div>
														</div>
														<?php wp_nonce_field( 'save_case_note_nonce' ); ?>
														 <div class="form-group">
															<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="note"><?php esc_html_e('Note','lawyer_mgt');?><span class="require-field"></span></label>
															<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
																<?php 
																 $setting=array(
																 'media_buttons' => false,
																 'quicktags' => false,
																 'textarea_rows' => 10,
																 );
																if($edt)
																{
																	wp_editor(stripslashes($casedata->note),'note',$setting);
																}
																else
																{
																	wp_editor('','note',$setting);
																}
																 ?>
															</div>
														</div>
														
														<div class="form-group">
															<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="date_time"><?php esc_html_e('Date','lawyer_mgt');?><span class="require-field">*</span></label>
															<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
															 <input id="date_time" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date1 form-control validate[required]  has-feedback-left " type="text"  name="date_time"  placeholder=""
																	value="<?php if($edt){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($casedata->date_time));}else{ echo  date("Y/m/d");}?>" readonly>
																	<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
															</div>															
														</div>
													   <div class="form-group margin_top_div_css1">
														<div class="offset-sm-2 col-sm-8">
															  <input type="submit" id="" name="savenote" class="btn btn-success submitnote" value="<?php if($edt){
															   esc_attr_e('Save Note','lawyer_mgt');}else{ esc_attr_e('Add Note','lawyer_mgt');}?>"></input>
														</div>
														</div>
													</form>
												</div>
										  <?php 
										}
										if($active_tab=='notelist')
										{?>
											<script type="text/javascript">
												jQuery(document).ready(function($)
												{
													"use strict"; 
													jQuery('#note_list111').DataTable({
														"responsive": true,
														"autoWidth": false,
														"order": [[ 1, "asc" ]],
														language:<?php echo wpnc_datatable_multi_language();?>,
														 "aoColumns":[
																	  {"bSortable": false},
																	  {"bSortable": true},
																	  {"bSortable": true},
																	  {"bSortable": true},
																	  {"bSortable": true},
																	   {"bSortable": true},
																	  {"bSortable": true},
																	  {"bSortable": false}
																   ]		               		
														});	
														$(".delete_check").on('click', function()
														{	
															if ($('.sub_chk:checked').length == 0 )
														{
															alert("<?php esc_html_e('Please select atleast one record','lawyer_mgt');?>");
															return false;
														}
														else{
															alert("<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>");
															return true;
															}
													});
												} );
												jQuery(document).ready(function($)
												{	
													"use strict"; 
													jQuery('#select_all').on('click', function(e)
													{
														 if($(this).is(':checked',true))  
														 {
															$(".sub_chk").prop('checked', true);  
														 }  
														 else  
														 {  
															$(".sub_chk").prop('checked',false);  
														 } 
													});
													$("body").on("change", ".sub_chk", function()
													{ 
														if(false == $(this).prop("checked"))
														{ 
															$("#select_all").prop('checked', false); 
														}
														if ($('.sub_chk:checked').length == $('.sub_chk').length )
														{
															$("#select_all").prop('checked', true);
														}
													});
												});		
												jQuery(document).ready(function($) 
												{
													"use strict"; 
													jQuery('#note_list').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
												} );
											</script>
										<form name="" action="" method="post" enctype='multipart/form-data'>	
										<div class="panel-body">
											<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">	
												<table id="note_list111" class="tast_list1 table table-striped table-bordered">
													<thead>	
														<?php
														$user_access_note=MJ_lawmgt_get_userrole_wise_filter_access_right_array('note');
														$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
														if($user_role == 'attorney')
														{	
															$notedata=$note->MJ_lawmgt_get_note_by_caseid($case_id);
														}
														elseif($user_role == 'client')
														{
															if($user_access_note['own_data'] == '1')
															{																
																$notedata=$note->MJ_lawmgt_get_note_by_caseid_and_client($case_id);
															}
															else
															{
																$notedata=$note->MJ_lawmgt_get_note_by_caseid($case_id);
															}														
														}
														else
														{	
															if($user_access_note['own_data'] == '1')
															{
																$notedata=$note->MJ_lawmgt_get_note_by_caseid_created_by($case_id); 
															}
															else
															{
																$notedata=$note->MJ_lawmgt_get_note_by_caseid($case_id);
															}
														}
														?>
														<tr>
															<th><input type="checkbox" id="select_all"></th>
															<th><?php  esc_html_e('Note Name', 'lawyer_mgt' ) ;?></th>
															<th><?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
															<th><?php esc_html_e('Practice Area', 'lawyer_mgt' ) ;?></th>
															<th> <?php esc_html_e('Client Name', 'lawyer_mgt' ) ;?></th>
															<th> <?php esc_html_e('Attorney Name', 'lawyer_mgt' ) ;?></th>
															<th> <?php esc_html_e('Date', 'lawyer_mgt' ) ;?></th>
															<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
														</tr>
														<br/>
													</thead>
													<tbody>
													<?php
														if(!empty($notedata))
														{
															foreach ($notedata as $retrieved_data)
															{
																$case_name=MJ_lawmgt_get_case_name_by_id($retrieved_data->case_id);
																if(!empty($case_name))
																{
																	foreach($case_name as $case_name1)
																	{
																		$case_name2=esc_html($case_name1->case_name);
																	}
																}
															
																 $user_id=$retrieved_data->assigned_to_user;
																 $contac_id=explode(',',$user_id);
																 $conatc_name=array();
																 if(!empty($contac_id))
																{
																	foreach($contac_id as $contact_name) 
																	{	
																		$userdata=get_userdata($contact_name);
																		$conatc_name[]=esc_html($userdata->display_name);
																	}
																}
																$attorney=$retrieved_data->assign_to_attorney;
																$attorney_name=explode(',',$attorney);
																$attorney_name1=array();
																if(!empty($attorney_name))
																{
																	foreach($attorney_name as $attorney_name2) 
																	{
																		$attorneydata=get_userdata($attorney_name2);	
																			
																		$attorney_name1[]=esc_html($attorneydata->display_name);										   
																	}
																}
															?>
															<tr>
																<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_attr($retrieved_data->note_id); ?>"></td>														
																 <td class="email"><a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=note&tab3=viewnote&viewnote=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&note_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->note_id));?>"><?php echo esc_html($retrieved_data->note_name);?></a></td>
																 <td class="prac_area"><a href="?dashboard=user&page=cases&tab=casedetails&action=view&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>"><?php echo esc_html($case_name2); ?></a></td>	
																 <td class="added"><?php echo  get_the_title($retrieved_data->practice_area_id);?></td>	
																 <td class="added"><?php echo esc_html(implode(',',$conatc_name));?></td>
																 <td class="added"><?php echo esc_html(implode(',',$attorney_name1));?></td>
																 <td class="added"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->date_time));?></td>						
																 <td class="action"> 	
																<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=note&tab3=viewnote&viewnote=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&note_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->note_id));?>" class="btn btn-success"> <?php esc_html_e('view', 'lawyer_mgt' ) ;?></a>							 
																<?php
																if($user_access_note['edit']=='1')
																{
																	?>
																	<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=note&tab3=addnote&editnote=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&note_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->note_id));?>" id="ediit" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>	

																<?php
																}
																if($user_access_note['delete']=='1')
																{
																	?>
																	<a href="?dashboard=user&page=cases&tab=casedetails&action=view&editats=true&deletenote=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&note_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->note_id));?>" class="btn btn-danger" 
																		onclick="return confirm('<?php esc_html_e('Are you sure you want to Delete this Note ?','lawyer_mgt');?>');">
																	  <?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>					
																<?php
																}
																?>	
																</td>               
															</tr>
														<?php 
															} 			
														} ?>     
													</tbody>   
												</table>
												<?php
												if($user_access_note['delete']=='1')
												{
													if(!empty($notedata))
													{
														?>												
														<div class="form-group">		
															<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
																<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="note_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
															</div>
														</div>
														<?php
													}
												}
												?>	
											</div>
										 </div>
										</form>	
										 <?php 
										 }
									 
									}
									if($active_tab=='event')
									{
										$obj_case_tast= new MJ_lawmgt_case_tast;
										$event=new MJ_lawmgt_Event;
									?>
										  <!-- POP up code -->
										<div class="popup-bg">
											<div class="overlay-content">
												<div class="modal-content">
													<div class="company_list">
													</div>
												</div>
											</div> 
										</div>
										<!-- End POP-UP Code -->
										<script type="text/javascript">
										    var $ = jQuery.noConflict();
											jQuery(document).ready(function($)
											{
												"use strict"; 
												jQuery('#event_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
												
												var start = new Date();
												var end = new Date(new Date().setYear(start.getFullYear()+1));

												$('.date1').datepicker({
													startDate : start,
													endDate   : end,
													autoclose: true
												}).on('changeDate', function(){
													$('.date2').datepicker('setStartDate', new Date($(this).val()));
												}); 

												$('.date2').datepicker({
													startDate : start,
													endDate   : end,
													autoclose: true
												}).on('changeDate', function(){
													$('.date1').datepicker('setEndDate', new Date($(this).val()));
												});
												
												$('.date3').datepicker({
													startDate : start,
													endDate   : end,
													autoclose: true
												});
												jQuery('.time').timepicker({
											
													});	
												$('.submitevent').on("click",function()
												{
													var start_date = $("#start_date").val();
													var end_date = $("#end_date").val();
													var start_time = $("#start_time").val();
													var end_time = $("#end_time").val(); 
													
													if(start_date != "" || end_date != "" || start_time != "" || end_time != "")
													{
														if(start_date == end_date)
														{ 
															if(start_time > end_time)
															{ 
																alert("<?php esc_html_e('event start time must less then the end time...','lawyer_mgt');?>");
																$("#end_time").val('');
															}	
														}
													}
												});	
											}); 
											jQuery(document).ready(function($)
											{
												"use strict"; 
												$("#assigned_to_user").multiselect({
													enableFiltering: true,
													enableCaseInsensitiveFiltering: true,
													nonSelectedText :'Select Client',
													includeSelectAllOption: true  
												});
												$(".submitevent").on("click",function()
												{	
													var checked = $(".multiselect_validation .dropdown-menu input:checked").length;

													if(!checked)
													{
														alert("<?php esc_html_e('Please select atleast one Client Name','lawyer_mgt');?>");
														return false;
													}			
												});	 
												 
											});
											jQuery(document).ready(function($)
											{
												"use strict"; 
												$("#assign_to_attorney").multiselect({ 
													enableFiltering: true,
													enableCaseInsensitiveFiltering: true,
													 nonSelectedText :'<?php esc_html_e('Select Attorney Name','lawyer_mgt');?>',
													  selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
													 includeSelectAllOption: true         
												});
												 
												$(".submitevent").on("click",function()
												{	
													var checked = $(".multiselect_validation123 .dropdown-menu input:checked").length;

													if(!checked)
													{
														 
														alert("<?php esc_html_e('Please select atleast one Attorney Name','lawyer_mgt');?>");
														return false;
													}			
												}); 
											});	
											function MJ_lawmgt_add_reminder()
											{
												"use strict"; 
												$("#reminder_entry").append('<div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" ><?php esc_html_e('Event Reminders','lawyer_mgt');?></label><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback"><select name="casedata[type][]" id="case_reminder_type"><option selected="selected" value="mail"><?php esc_html_e('Mail','lawyer_mgt');?></option></select></div><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback btn_margin"><input id="remindertimevalue" class="form-control text-input validate[required]" type="number"  value="1" name="casedata[remindertimevalue][]" min="1"></div><div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 btn_margin has-feedback"><select name="casedata[remindertimeformat][]" id="case_reminder_type"><option selected="selected" value="day"><?php esc_html_e('Day(s)','lawyer_mgt');?></option><option value="hour"><?php esc_html_e('Hour(s)','lawyer_mgt');?></option></select></div><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Event Start Date','lawyer_mgt');?></label><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger"></div></div>');   		
											}  	

											function MJ_lawmgt_deleteParentElement(n)
											{
												"use strict"; 
												alert("<?php esc_html_e('Do you really want to delete this ?','lawyer_mgt');?>");
												n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
											}
										</script>	
										<?php 
										$user_access_event=MJ_lawmgt_get_userrole_wise_filter_access_right_array('event');
										$active_tab = sanitize_text_field(isset($_GET['tab3'])?$_GET['tab3']:'eventlist');
										?>
											<h2>
												<ul id="myTab" class="sub_menu_css line nav nav-tabs" role="tablist">
													<li role="presentation" class="<?php echo esc_html($active_tab) == 'eventlist' ? 'active' : ''; ?>">
														<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=event&tab3=eventlist&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
															<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Event List', 'lawyer_mgt'); ?>
														</a>
													</li>
													
													<?php if(isset($_REQUEST['editevent'])&& sanitize_text_field($_REQUEST['editevent'])=='true') {?>
													<li role="presentation" class="<?php echo esc_html($active_tab) == 'addevent' ? 'active' : ''; ?>">
														<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=event&tab3=addevent&editevent=true&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&id=<?php echo esc_attr($_REQUEST['id']);?>">
															<?php echo esc_html__('Edit Event', 'lawyer_mgt'); ?>
														</a>
													</li>
													<?php }
													else
													{
														if($user_access_event['add']=='1')
														{
															?>
															<li role="presentation" class="<?php echo esc_html($active_tab) == 'addevent' ? 'active' : ''; ?>">
																<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=event&tab3=addevent&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
																	<?php echo '<span class="fa fa-plus-circle"></span> '.esc_html__('Add Event', 'lawyer_mgt'); ?>	
																</a>
															</li>
															<?php 
														}
													}?>
													<?php if(isset($_REQUEST['viewevent'])&& $_REQUEST['viewevent']=='true') {?>
													<li role="presentation" class="<?php echo esc_html($active_tab) == 'viewevent' ? 'active' : ''; ?>">
														<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=event&tab3=viewevent&viewevent=true&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&id=<?php echo esc_attr($_REQUEST['id']);?>">
															<?php echo esc_html__('View Event', 'lawyer_mgt'); ?>
														</a>
													</li>
													<?php } ?>
												</ul>			
											</h2>
											<?php
											if($active_tab=='viewevent')
											{?>
												<style>
												.event_detail_div
												{
													border: 1px solid #ddd;
													margin: 15px 0px;
													padding: 10px;
												}
												.table_row .table_td 
												{
												  padding: 10px 10px !important;
												}												
												</style>
											<?php 
												$obj_case_tast= new MJ_lawmgt_case_tast;
												$event=new MJ_lawmgt_Event;
												if($active_tab == 'viewevent')
												{
													if(isset($_REQUEST['id']))
														$event_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id']));
														if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
														{	
															$casedata=$event->MJ_lawmgt_get_signle_event_by_id($event_id);
														} 
														?>		
															<div class="panel-body">
																<div class="header">	
																	<h3 class="first_hed"><?php esc_html_e('Linked To','lawyer_mgt');?></h3>
																	<hr>
																</div>
																<div class="viewtaskdetails">				
																	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 event_detail_div">							
																		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
																			<div class="table_row">
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">						
																					<?php esc_html_e('Case Name','lawyer_mgt'); ?>
																				</div>
																				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																					<span class="txt_color">
																					<?php
																						$case_link=esc_html(MJ_lawmgt_get_case_name($casedata->case_id));
																						 echo esc_html($case_link);
																						?>
																					</span>
																				</div>
																			</div>
																			<div class="table_row">
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																					<?php esc_html_e('Practice Area','lawyer_mgt'); ?>
																				</div>
																				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																					<span class="txt_color">
																					<?php
																						 echo esc_html(get_the_title($casedata->practice_area_id));
																						?>
																					</span>
																				</div>
																			</div>
																		</div>
																	 </div>
																	<div class="header">	
																		<h3 class="first_hed"><?php esc_html_e('Event Information','lawyer_mgt');?></h3>
																		<hr>
																	</div>
																	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 event_detail_div">							
																		 	
																			<div class="table_row">
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																					<?php esc_html_e('Event Name','lawyer_mgt'); ?>
																				</div>
																				<div class="col-lg-4 col-md-4 col-sm-10 col-xs-12 table_td">
																					<span class="txt_color">
																					<?php									
																						 echo esc_html($casedata->event_name);
																						?>
																					</span>
																				</div>
																			</div>
																		 
																			<div class="table_row">
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																					<?php esc_html_e('Start Date','lawyer_mgt'); ?>
																				</div>
																				<div class="col-lg-4 col-md-4 col-sm-10 col-xs-12 table_td">
																					<span class="txt_color">
																					<?php
																						 echo esc_html(MJ_lawmgt_getdate_in_input_box($casedata->start_date));
																						?>
																					</span>
																				</div>
																			</div>
																			<div class="table_row">
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																					<?php esc_html_e('Start Time','lawyer_mgt'); ?>
																				</div>
																				<div class="col-lg-4 col-md-4 col-sm-10 col-xs-12 table_td">
																					<span class="txt_color">
																					<?php
																						 echo esc_html($casedata->start_time);
																					?>
																					</span>
																				</div>
																			</div>
																		 
																			<div class="table_row">
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																					<?php esc_html_e('End Date','lawyer_mgt'); ?>
																				</div>
																				<div class="col-lg-4 col-md-4 col-sm-10 col-xs-12 table_td">
																					<span class="txt_color">
																						<?php
																							echo esc_html(MJ_lawmgt_getdate_in_input_box($casedata->end_date));
																						?>
																					</span>
																				</div>
																			</div>
																			<div class="table_row">
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																					<?php esc_html_e('End Time','lawyer_mgt'); ?>
																				</div>
																				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																					<span class="txt_color">
																					<?php
																						 echo esc_html($casedata->end_time);
																						?>
																					</span>
																				</div>
																			</div>
																				<?php if(!empty($casedata->description))
																			{?>
																			<div class="table_row">
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																					<?php esc_html_e('Description','lawyer_mgt'); ?>
																				</div>
																				<div class="col-lg-4 col-md-4 col-sm-10 col-xs-12 table_td">
																					<span class="txt_color">
																					<?php
																						 echo esc_html($casedata->description);
																						?>
																					</span>
																				</div>
																			</div>
																			<?php }?>
																			<div class="table_row">
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																					<?php esc_html_e('Address','lawyer_mgt'); ?>
																				</div>
																				<div class="col-lg-4 col-md-4 col-sm-10 col-xs-12 table_td">
																					<span class="txt_color">
																					<?php
																						 echo esc_html($casedata->address);
																						?>
																					</span>
																				</div>
																			</div>
																		 
																			<div class="table_row">
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																					<?php esc_html_e('State Name','lawyer_mgt'); ?>
																				</div>
																				<div class="col-lg-4 col-md-4 col-sm-10 col-xs-12 table_td">
																					<span class="txt_color">
																					<?php
																						 echo esc_html($casedata->state_name);
																						?>
																					</span>
																				</div>
																			</div>
																			<div class="table_row">
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																					<?php esc_html_e('City Name','lawyer_mgt'); ?>
																				</div>
																				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																					<span class="txt_color">
																					<?php
																						 echo esc_html($casedata->city_name);
																						?>
																					</span>
																				</div>
																			</div>
																		 
																			<div class="table_row">
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																					<?php esc_html_e('Pin Code','lawyer_mgt'); ?>
																				</div>
																				<div class="col-lg-4 col-md-4 col-sm-10 col-xs-12 table_td">
																					<span class="txt_color">
																					<?php
																						 echo esc_html($casedata->pin_code);
																						?>
																					</span>
																				</div>
																			</div>	
																		</div>	
																	 				
																	<div class="header">	
																		<h3 class="first_hed"><?php esc_html_e('Attendees To','lawyer_mgt');?></h3>
																		<hr>
																	</div>							
																	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 event_detail_div">							
																		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
																			<div class="table_row">
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																					<?php esc_html_e('Client Name','lawyer_mgt'); ?>
																				</div>
																				<div class="col-lg-4 col-md-4 col-sm-10 col-xs-12 table_td">
																					<span class="txt_color">
																					<?php
																						$user=explode(",",$casedata->assigned_to_user);
																						$user_name=array();
																						if(!empty($user))
																						{						
																							foreach($user as $data)
																							{
																								$user_name[]=MJ_lawmgt_get_display_name($data);
																							}
																						}			
																						 echo esc_html(implode(",",$user_name));
																						?>
																					</span>
																				</div>
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																					<?php esc_html_e('Attorney Name','lawyer_mgt'); ?>
																				</div>
																				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																					<span class="txt_color">
																					<?php
																						$user=explode(",",$casedata->assign_to_attorney);
																						$user_name=array();
																						if(!empty($user))
																						{						
																							foreach($user as $data)
																							{
																								$user_name[]=esc_html(MJ_lawmgt_get_display_name($data));
																							}
																						}			
																						 echo esc_html(implode(",",$user_name));
																						?>
																					</span>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>	
															</div>
													 <?php 
													 }
											}			
											if($active_tab=='addevent')
											{	
												$event_id=0;
												$edt=0;
												if(isset($_REQUEST['id']))
													$event_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id']));
													if(isset($_REQUEST['editevent']) && sanitize_text_field($_REQUEST['editevent']) == 'true')
													{					
														$edt=1;
														$casedata=$event->MJ_lawmgt_get_signle_event_by_id($event_id);
													}?>
												   <div class="panel-body">
														<form name="event_form" action="" method="post" class="form-horizontal" id="event_form" enctype='multipart/form-data'>	
														    
															 <?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
																<input id="action" class="form-control  text-input" type="hidden"  value="<?php if($edt){ echo 'edit'; }else echo $action ?>" name="action">
															<div class="header">	
																<h3 class="first_hed"><?php esc_html_e('Linked To','lawyer_mgt');?></h3>
																<hr>
															</div>
															<div class="form-group">
																	<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Case Name','lawyer_mgt');?><span class="require-field">*</span></label>
																	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
																	<?php 
																		global $wpdb;
																		$table_case = $wpdb->prefix. 'lmgt_cases';			
																		$result = $wpdb->get_row("SELECT * FROM $table_case where id=".sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id'])));			
																		?>
																		<input id="case_id" class="form-control   validate[required] text-input" type="hidden"  value="<?php echo esc_attr($result->id); ?>" name="case_id">
																		<input id="case_name" class="form-control   validate[required] text-input" type="text"  value="<?php echo esc_attr($result->case_name); ?>" name="case_name" readonly>
																		
																	</div>
																	<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="practice_area_id"><?php esc_html_e('Practice Area','lawyer_mgt');?></label>
																	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
																	<?php if($edt){ $data=$casedata->practice_area_id;}else{ $data=''; }
																		$obj_practicearea=new MJ_lawmgt_practicearea;
																	?>
																		<input type="hidden" class="form-control" value="<?php echo esc_attr($result->practice_area_id);?>" name="practice_area_id" id="practice_area_id" readonly />
																		<input type="text" class="form-control" value="<?php echo esc_attr(get_the_title($result->practice_area_id)); ?>" name="practice_area_id1" id="practice_area_id1" readonly />
																	</div>
															</div>
															<div class="header">
																<h3><?php esc_html_e('Event Information','lawyer_mgt');?></h3>
																<hr>
															</div>
															<div class="form-group">
																<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="task_name"><?php esc_html_e('Event Name','lawyer_mgt');?><span class="require-field">*</span></label>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12  has-feedback">
																	<input id="event_name" class="form-control  validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]text-input " type="text" placeholder="<?php esc_html_e('Enter Event Name','lawyer_mgt');?>" value="<?php if($edt){ echo esc_attr($casedata->event_name);}elseif(isset($_POST['event_name'])){ echo esc_attr($_POST['event_name']); } ?>" name="event_name">
																</div>
															</div>
															<div class="form-group">
																<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="start_date"><?php esc_html_e('Start Date','lawyer_mgt');?><span class="require-field">*</span></label>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
																	<input id="start_date" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date1 form-control  validate[required] has-feedback-left " type="text"  name="start_date"  placeholder="<?php esc_html_e('Select Start Date','lawyer_mgt');?>"
																	value="<?php if($edt){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($casedata->start_date));}elseif(isset($_POST['startdate'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['startdate'])); } ?>" readonly>
																	<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
																</div>
																<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="start_time"><?php esc_html_e('Start Time','lawyer_mgt');?><span class="require-field">*</span></label>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
																	<input id="start_time"  class="time form-control  validate[required] has-feedback-left " type="text"  name="start_time"  placeholder=""
																	value="<?php if($edt){ echo esc_attr($casedata->start_time);}elseif(isset($_POST['start_time'])) { echo esc_html($_POST['start_time']); } ?>">
																	<span class="fa fa-clock form-control-feedback left" aria-hidden="true"></span>
																</div>														
															</div>
															<?php wp_nonce_field( 'save_case_event_nonce' ); ?>
															<div class="form-group">
																<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="end_date"><?php esc_html_e('End Date','lawyer_mgt');?><span class="require-field">*</span></label>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
																	<input id="end_date"  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date2 form-control validate[required]  has-feedback-left " type="text"  name="end_date"  placeholder="<?php esc_html_e('Select End Date','lawyer_mgt');?>"
																		value="<?php if($edt){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($casedata->end_date)); }elseif(isset($_POST['end_date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['end_date'])); } ?>" readonly>
																		<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
																</div>
																<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="end_time"><?php esc_html_e('End Time','lawyer_mgt');?><span class="require-field">*</span></label>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
																	<input id="end_time"  class="time form-control  validate[required] has-feedback-left " type="text"  name="end_time"  placeholder=""
																	value="<?php if($edt){ echo esc_attr($casedata->end_time);}elseif(isset($_POST['end_time'])) { echo esc_attr($_POST['end_time']);
																	}
																	?>">
																	<span class="fa fa-clock form-control-feedback left" aria-hidden="true"></span>
																</div>
															</div>	
															<div class="form-group">
																<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="pin_code"><?php esc_html_e('Description','lawyer_mgt');?><span class="require-field"></span></label>
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
																	<textarea id="description" class="form-control validate[custom[address_description_validation],maxSize[150]]" type="text" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" value="" name="description"><?php if($edt){ echo esc_textarea($casedata->description) ; } ?></textarea>
																</div>															
															</div>															
															<?php
															if($edt)
															{
																$result_reminder=$event->MJ_lawmgt_get_single_event_reminder($event_id);				
																if(!empty($result_reminder))	
																{	
																	foreach ($result_reminder as $retrive_data)
																	{ 
																	?>	
																		<div id="reminder_entry">
																			<div class="form-group">			
																				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="SOL Reminders"><?php esc_html_e('Event Reminders','lawyer_mgt');?></label>
																				<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
																					<input type="hidden" name="casedata[id][]" value="<?php echo esc_attr($retrive_data->id);?>">
																					<select name="casedata[type][]" id="case_reminder_types">
																						<option selected="selected" value="mail" <?php if($retrive_data=='mail') { print ' selected'; }?>><?php echo esc_html($retrive_data->reminder_type); ?></option>
																					</select>
																				</div>
																				<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
																				<input id="remindertimevalue" class="form-control text-input validate[required]" type="number"  value="<?php echo esc_attr($retrive_data->reminder_time_value); ?>" name="casedata[remindertimevalue][]" min="1">
																				</div>
																				<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
																				<select name="casedata[remindertimeformat][]" id="case_reminder_type">
																						<?php 
																						$reminder_value=$retrive_data->reminder_time_format;
																						?>
																						<option value="day" <?php if($reminder_value=='day') { print ' selected'; }?>><?php esc_html_e('Day(s)','lawyer_mgt'); ?></option>
																						<option value="hour" <?php if($reminder_value=='hour') { print ' selected'; }?>><?php esc_html_e('Hour(s)','lawyer_mgt'); ?></option>																						
																				</select>
																				</div>
																				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Event Start Date','lawyer_mgt') ?></label>
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																					<input type="button" value="<?php esc_attr_e('Remove','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger">
																				</div>				
																			</div>		
																		</div>	
																	<?php				
																	}
																}
																else
																{
																?>
																	 <div id="reminder_entry">
																	 </div>
																<?php
																}	
																?>
																<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
																	<input type="button" value="<?php esc_attr_e('Add Reminder','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_reminder()" class="add_reminder btn btn-success">
																</div>		
															<?php		
															}
															else
															{
															?>
																<div id="reminder_entry">
																	<div class="form-group">	
																		<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Event Reminders','lawyer_mgt');?></label>
																		<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 has-feedback">
																			<select name="casedata[type][]" id="case_reminder_types">
																				<option selected="selected" value="mail"><?php esc_html_e('Mail','lawyer_mgt') ?></option>
																			</select>
																		</div>
																		<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 btn_margin has-feedback">
																		<input id="remindertimevalue" class="form-control text-input validate[required]" type="number"  value="1" name="casedata[remindertimevalue][]" min="1">
																		</div>
																		<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 btn_margin has-feedback">
																		<select name="casedata[remindertimeformat][]" id="case_reminder_type">
																			<option selected="selected" value="day"><?php esc_html_e('Day(s)','lawyer_mgt') ?></option>
																			<option value="hour"><?php esc_html_e('Hour(s)','lawyer_mgt') ?></option>					
																		</select>
																		</div>
																		<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="Event"><?php esc_html_e('Before Event Start Date','lawyer_mgt') ?></label>
																		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																			<input type="button" value="<?php esc_attr_e('Remove','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate btn btn-danger">
																		</div>		
																	</div>		
																</div>				  
																<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
																	<input type="button" value="<?php esc_attr_e('Add Reminder','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_reminder()" class="add_reminder btn btn-success">
																</div>	
															<?php 
															} 
															?>					
															<div class="header">
																<h3><?php esc_html_e('Address Information','lawyer_mgt');?></h3>					
																<hr>
															</div>
															<div class="form-group col-md-12">
																<div class="header">
																	<div class="form-group">
																		<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="address"><?php esc_html_e('Address','lawyer_mgt');?><span class="require-field">*</span></label>
																		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
																			<input id="address" class="form-control validate[required,custom[address_description_validation],maxSize[150]] has-feedback-left text-input"  type="text" placeholder="<?php esc_html_e('Enter Address','lawyer_mgt');?>" value="<?php if($edt){ echo esc_attr($casedata->address);}elseif(isset($_POST['address'])){ echo esc_attr($_POST['address']); } ?>" name="address">
																			<span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
																		</div>
																		<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="state_name"><?php esc_html_e('State','lawyer_mgt');?><span class="require-field">*</span></label>
																		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
																			<input id="state_name" class="form-control has-feedback-left validate[required,custom[city_state_country_validation],maxSize[50]]"  type="text"  name="state_name" placeholder="<?php esc_html_e('Enter State Name','lawyer_mgt');?>"
																			value="<?php if($edt){ echo esc_attr($casedata->state_name);}elseif(isset($_POST['state_name'])){ echo esc_attr($_POST['state_name']); } ?>">
																			<span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
																		</div>
																	</div>	
																	<div class="form-group">
																		<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="city_name"><?php esc_html_e('City','lawyer_mgt');?><span class="require-field">*</span></label>
																		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
																			<input id="city_name" class="form-control has-feedback-left validate[required,custom[city_state_country_validation],maxSize[50]]"  type="text"  name="city_name"  placeholder="<?php esc_html_e('Enter City Name','lawyer_mgt');?>"
																			value="<?php if($edt){ echo esc_attr($casedata->city_name);}elseif(isset($_POST['city_name'])){ echo esc_attr($_POST['city_name']); } ?>">
																			<span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
																		</div>
																		<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="pin_code"><?php esc_html_e('Pin Code','lawyer_mgt');?><span class="require-field">*</span></label>
																		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
																			<input id="pin_code" class="form-control has-feedback-left validate[required,custom[onlyLetterNumber],maxSize[15]]" type="text"  name="pin_code" placeholder="<?php esc_html_e('Enter Pin Code','lawyer_mgt');?>" 
																			value="<?php if($edt){ echo esc_attr($casedata->pin_code);}elseif(isset($_POST['pin_code'])){ echo esc_attr($_POST['pin_code']); } ?>">
																			<span class="fa fa-sort-numeric-down form-control-feedback left" aria-hidden="true"></span>
																		</div>
																	</div> 		
																	<div class="form-group">
																	<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="priority"><?php esc_html_e('Priority','lawyer_mgt');?></label>
																		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
																			<select class="form-control " name="priority" id="priority">				
																					<option value="0" <?php if($edt && $casedata->priority=='0') { print ' selected'; }?>><?php esc_html_e('High','lawyer_mgt');?></option>
																					<option value="1" <?php if($edt && $casedata->priority=='1') { print ' selected'; }?>><?php esc_html_e('Low','lawyer_mgt');?></option>
																					<option value="2" <?php if($edt && $casedata->priority=='2') { print ' selected'; }?>><?php esc_html_e('Medium','lawyer_mgt');?></option>
																			</select>
																	   </div>			
																		<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="Repeat"><?php esc_html_e('Repeat','lawyer_mgt');?></label>
																		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
																			<select class="form-control validate[required]" name="repeat" id="repeat">
																				<option value="0" <?php if($edt && $casedata->repeat=='0') { print ' selected'; }?>><?php esc_html_e('Never','lawyer_mgt');?></option>
																				<option value="1" <?php if($edt && $casedata->repeat=='1') { print ' selected'; }?>><?php esc_html_e('Every day','lawyer_mgt');?></option>
																				<option value="2" <?php if($edt && $casedata->repeat=='2') { print ' selected'; }?>><?php esc_html_e('Every week','lawyer_mgt');?></option>
																				<option value="3" <?php if($edt && $casedata->repeat=='3') { print ' selected'; }?>><?php esc_html_e('Every 2 weeks','lawyer_mgt');?></option>
																				<option value="4" <?php if($edt && $casedata->repeat=='4') { print ' selected'; }?>><?php esc_html_e('Every month','lawyer_mgt');?></option>
																				<option value="5" <?php if($edt && $casedata->repeat=='5') { print ' selected'; }?>><?php esc_html_e('Every year','lawyer_mgt');?></option>
																			</select>
																	   </div>
																	   </div>
																	 <div class="header">	
																		<h3><?php esc_html_e('Attendees To','lawyer_mgt');?></h3>
																		<hr>
																	 </div>
																	<div class="form-group">
																		<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="assigned_to_user"><?php esc_html_e('Client Name','lawyer_mgt');?><span class="require-field">*</span></label>
																		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback multiselect_validation">
																			<?php if($edt){ $data=$casedata->assigned_to_user;}elseif(isset($_POST['assigned_to_user'])){ $data=  sanitize_text_field($_POST['assigned_to_user']); }
																			?>
																				<?php $conats=explode(',',$data);
																					$Editdata=MJ_lawmgt_get_user_by_edit_case_id(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id'])));
																					?>
																				<select class="form-control validate[required] assigned_to_user" multiple="multiple" name="assigned_to_user[]" id="assigned_to_user">				
																					<?php
																					if(!empty($Editdata))
																					{	
																						foreach($Editdata as $Editdata1)
																						{
																							$userdata=get_userdata($Editdata1->user_id);
																							$user_name=esc_html($userdata->display_name);	
																							?>
																							<option value="<?php print esc_attr($Editdata1->user_id);?>" <?php echo in_array($Editdata1->user_id,explode(',',$data)) ? 'selected': ''; ?>>
																							<?php echo esc_html($user_name);?>
																							</option>
																							<?php 
																						 }
																					}
																					 ?>
																				</select>
																		</div>
																		<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="assigned_to_attorney"><?php esc_html_e('Attorney Name','lawyer_mgt');?><span class="require-field">*</span></label>
																		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback multiselect_validation123">
																			<?php if($edt){ $data=$casedata->assign_to_attorney;}elseif(isset($_POST['assign_to_attorney'])){ $data= sanitize_text_field($_POST['assign_to_attorney']);
																			}
																			?>
																				<?php 
																					global $wpdb;
																					$table_case = $wpdb->prefix. 'lmgt_cases';
																					$userdata = $wpdb->get_results("SELECT case_assgined_to FROM $table_case where id=".sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id'])));
																					 
																					$user_array=$userdata[0]->case_assgined_to;
																					  
																					$newarraay=explode(',',$user_array);
																						 
																					?>
																				<select class="form-control validate[required] assign_to_attorney" multiple="multiple" name="assign_to_attorney[]" id="assign_to_attorney">				
																					<?php 
																					if(!empty($newarraay))
																					{
																						foreach ($newarraay as $retrive_data)
																						{ 
																						$user_details=get_userdata($retrive_data);
																						$user_name=esc_html($user_details->display_name);
																						?>
																							<option value="<?php print esc_attr($user_details->ID); ?>" <?php echo in_array($user_details->ID,explode(',',$data)) ? 'selected': ''; ?>>
																							<?php echo esc_html($user_name); ?>
																							</option>
																						<?php 
																						}
																					} ?>
																				</select>
																		</div>
																	</div>																 
																</div>
																<div class="form-group margin_top_div_css1">
																	<div class="offset-sm-2 col-sm-8">
																		  <input type="submit" id="" name="saveevent" class="btn btn-success submitevent" value="<?php if($edt){
																		   esc_attr_e('Save Event','lawyer_mgt');}else{ esc_attr_e('Add Event','lawyer_mgt');}?>"></input>
																	</div>
																</div>																
															</div>
														</form>
													</div>											
										<?php
										}
										if($active_tab=='eventlist')
										{?>
										 <script type="text/javascript">
											jQuery(document).ready(function($)
											{
												"use strict"; 
												jQuery('#note_list111').DataTable({
													"responsive": true,
													"autoWidth": false,
													"order": [[ 1, "asc" ]],
													language:<?php echo wpnc_datatable_multi_language();?>,
													 "aoColumns":[
																  {"bSortable": false},
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": true},
																   {"bSortable": true},
																  {"bSortable": true},
																  {"bSortable": false}
															   ]		               		
													});	
													$(".delete_check").on('click', function()
													{	
														if ($('.sub_chk:checked').length == 0 )
													{
														alert("<?php esc_html_e('Please select atleast one record','lawyer_mgt');?>");
														return false;
													}
													else{
														alert("<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>");
														return true;
														}
												});
											} );
											jQuery(document).ready(function($)
											{	
												"use strict"; 
												jQuery('#select_all').on('click', function(e)
												{
													 if($(this).is(':checked',true))  
													 {
														$(".sub_chk").prop('checked', true);  
													 }  
													 else  
													 {  
														$(".sub_chk").prop('checked',false);  
													 } 
												});
												$("body").on("change", ".sub_chk", function()
												{ 
													if(false == $(this).prop("checked"))
													{ 
														$("#select_all").prop('checked', false); 
													}
													if ($('.sub_chk:checked').length == $('.sub_chk').length )
													{
														$("#select_all").prop('checked', true);
													}
												});
											});		
											jQuery(document).ready(function($) 
											{
												"use strict"; 
												jQuery('#event_list').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
											});
										</script>
										<form name="" action="" method="post" enctype='multipart/form-data'>
										<div class="panel-body">
											<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">	
												<table id="note_list111" class="tast_list1 table table-striped table-bordered">
													<thead>	
														<?php
														$user_event_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('event');
														$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
														if($user_role == 'attorney')
														{	
															$eventdata=$event->MJ_lawmgt_get_event_by_caseid($case_id); 
														}
														elseif($user_role == 'client')
														{	
															if($user_event_access['own_data'] == '1')
															{
																$current_user_id = get_current_user_id();
																$eventdata=$event->MJ_lawmgt_get_event_by_caseid_and_client($case_id,$current_user_id); 
															}
															else
															{																
																$eventdata=$event->MJ_lawmgt_get_event_by_caseid($case_id); 
															}
														}
														else
														{	
															if($user_event_access['own_data'] == '1')
															{
																$eventdata=$event->MJ_lawmgt_get_event_by_caseid_created_by($case_id); 
															}
															else
															{
																$eventdata=$event->MJ_lawmgt_get_event_by_caseid($case_id); 
															}
														}		
														?>
														<tr>
															<th><input type="checkbox" id="select_all"></th>
															<th><?php  esc_html_e('Event Name', 'lawyer_mgt' ) ;?></th>
															<th><?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
															<th><?php esc_html_e('Practice Area', 'lawyer_mgt' ) ;?></th>
															<th> <?php esc_html_e('Contact Name', 'lawyer_mgt' ) ;?></th>
															<th> <?php esc_html_e('Attorney Name', 'lawyer_mgt' ) ;?></th>
															<th> <?php esc_html_e('Date/Time', 'lawyer_mgt' ) ;?></th>
															<th><?php esc_html_e('Address', 'lawyer_mgt' ) ;?></th>
															<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
														</tr>
														<br/>
													</thead>
													<tbody>
														<?php
														if(!empty($eventdata))
														{
															foreach ($eventdata as $retrieved_data)
															{
																$case_name=MJ_lawmgt_get_case_name_by_id($retrieved_data->case_id);
																foreach($case_name as $case_name1)
																{
																$case_name2=esc_html($case_name1->case_name);
																}
															
																 $user_id=$retrieved_data->assigned_to_user;
																 $contac_id=explode(',',$user_id);
																 $conatc_name=array();
																foreach($contac_id as $contact_name)
																{
																	$userdata=get_userdata($contact_name);
																	$conatc_name[]=esc_html($userdata->display_name);
																}
																$attorney=$retrieved_data->assign_to_attorney;
																$attorney_name=explode(',',$attorney);
																$attorney_name1=array();
																foreach($attorney_name as $attorney_name2) 
																{
																	$attorneydata=get_userdata($attorney_name2);	
																		
																	$attorney_name1[]=esc_html($attorneydata->display_name);										   
																}
																?>
																<tr>	
																	<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_attr($retrieved_data->event_id); ?>"></td>						
																	 <td class="email"><a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=event&tab3=viewevent&viewevent=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->event_id));?>"><?php echo esc_html($retrieved_data->event_name);?></a></td>
																	 <td class="prac_area"><a href="?dashboard=user&page=cases&tab=casedetails&action=view&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>"><?php echo esc_html($case_name2); ?></a></td>	
																	<td class="added"><?php echo esc_html(get_the_title($retrieved_data->practice_area_id));?></td>	
																	<td class="added"><?php echo esc_html(implode(',',$conatc_name));?></td>
																	<td class="added"><?php echo esc_html(implode(',',$attorney_name1));?></td>					
																	<td class="added"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->start_date)).' '.$retrieved_data->start_time;?></td>
																	<td class="added"><?php echo esc_html($retrieved_data->address);?></td>						
																	 <td class="action"> 
																	<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=event&tab3=viewevent&viewevent=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->event_id));?>"  class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>								 
																	<?php
																	if($user_access_event['edit']=='1')
																	{
																	?>
																		<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=event&tab3=addevent&editevent=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->event_id));?>" id="ediit" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
																	<?php
																	}
																	if($user_access_event['delete']=='1')
																	{
																	?>					
																	
																		<a href="?dashboard=user&page=cases&tab=casedetails&action=view&editats=true&deleteevent=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->event_id));?>" class="btn btn-danger" 
																			onclick="return confirm('<?php esc_html_e('Are you sure you want to Delete this Event ?','lawyer_mgt');?>');">
																		  <?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>					
																	<?php
																	}
																	?>
																	  </td>               
																</tr>
													<?php 	} 			
														} ?>     
													</tbody>
												</table>
											<?php
											if($user_access_event['delete']=='1')
											{
												if(!empty($eventdata))
												{
													?>
													<div class="form-group">		
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
															<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="event_delete_selected"  value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
														</div>
													</div>
													<?php
												}
											}
											?>	
											</div>
										 </div> 
										</form>	
										 <?php 
										}						
									}
									if($active_tab=='invoice')
									{
										if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
										{
											//wp_redirect ( home_url() . '?dashboard=user');
											$redirect_url=home_url() . '?dashboard=user';
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
										?>
										<!-- POP up code -->
										<div class="popup-bg">
											<div class="overlay-content">
											<div class="modal-content">
											<div class="invoice_data">
											 </div>
											</div>
											</div> 
										</div>
										<!-- End POP-UP Code -->
										<?php 	
										$obj_invoice=new MJ_lawmgt_invoice;
										$user_access_invoice=MJ_lawmgt_get_userrole_wise_filter_access_right_array('invoice');
										$active_tab = sanitize_text_field(isset($_GET['tab3'])?$_GET['tab3']:'invoicelist');
										?>  
										<h2>	
											<ul id="myTab" class="sub_menu_css line nav nav-tabs case_details_documents" role="tablist">
												<li role="presentation" class="<?php echo esc_html($active_tab) == 'invoicelist' ? 'active' : ''; ?> ">
													<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=invoice&tab3=invoicelist&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
														<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Invoice List', 'lawyer_mgt'); ?>				
													</a>
												</li>
												
												<?php if(isset($_REQUEST['edit'])&& sanitize_text_field($_REQUEST['edit'])=='true') {?>
												<li role="presentation" class="<?php echo esc_html($active_tab) == 'addinvoice' ? 'active' : ''; ?>">
													<a href="?dashboard=user&page=cases&tab=casedetails&action=view&edit=true&tab2=invoice&tab3=addinvoice&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&invoice_id=<?php echo esc_attr($_REQUEST['invoice_id']);?>">
														<?php echo esc_html__('Edit Invoice', 'lawyer_mgt'); ?>					
													</a>
												</li>
												<?php }
												else
												{
													if($user_access_invoice['add']=='1')
													{
														?>
														<li role="presentation" class="<?php echo esc_html($active_tab) == 'addinvoice' ? 'active' : ''; ?>">
															<a href="?dashboard=user&page=cases&tab=casedetails&action=view&add=true&tab2=invoice&tab3=addinvoice&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
																<?php echo '<span class="fa fa-plus-circle"></span> '.esc_html__('Add Invoice', 'lawyer_mgt'); ?>	
															</a>
														</li>
														<?php 
													}
												}
												if(isset($_REQUEST['view'])&& sanitize_text_field($_REQUEST['view'])=='true')
												{
												?>
												<li role="presentation" class="<?php echo esc_html($active_tab) == 'viewinvoice' ? 'active' : ''; ?>">
													<a href="?dashboard=user&page=cases&tab=casedetails&action=view&view=true&tab2=invoice&tab3=viewinvoice&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&invoice_id=<?php echo esc_attr($_REQUEST['invoice_id']);?>">
														<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('View Invoice', 'lawyer_mgt'); ?>					
													</a>
												</li>
												<?php }	?>	
											</ul>
										</h2>
										<?php
										if($active_tab=='addinvoice')
										{	 
											$obj_invoice=new MJ_lawmgt_invoice;
											?>
											<script type="text/javascript">
										    	var $ = jQuery.noConflict();
												jQuery(document).ready(function($)
												{
													"use strict"; 
													function MJ_lawmgt_initMultiSelect()
													{
													  $(".tax_dropdawn").multiselect({
														 
														nonSelectedText :'<?php esc_html_e('Select Tax','lawyer_mgt');?>',
														selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
														includeSelectAllOption: true         
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
													
													 $(".tax_dropdawn").multiselect({
														nonSelectedText :'<?php esc_html_e('Select Tax','lawyer_mgt');?>',
														numberDisplayed: 1,	
														selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
														includeSelectAllOption: true         
													});

													$('.date1').datepicker({
														startDate : start,
														endDate   : end,
														autoclose: true
													}).on('changeDate', function(){
														$('.date').datepicker('setEndDate', new Date($(this).val()));
													});	
														$('.demo').on("click",function(){
														MJ_lawmgt_initMultiSelect();
														}) 
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
													 $(".tax_dropdawn").multiselect({
														nonSelectedText :'<?php esc_html_e('Select Tax','lawyer_mgt');?>',
														numberDisplayed: 1,	
														selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
														includeSelectAllOption: true         
													});  
													<?php
														$user = wp_get_current_user();
														$userid=$user->ID;
														$user_name=get_userdata($userid);	
													?>
													
													$(".time_entry_div").append('<div class="main_time_entry_div"><div class="form-group"><label class="col-sm-2 control-label" for="medicine_name"><?php esc_html_e('Time Entries','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-sm-3 margin_bottom_5px"><input class="form-control text-input validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]" type="text" value="" name="time_entry[]" placeholder="<?php esc_html_e('Enter time entry','lawyer_mgt');?>"></div> <div class="col-sm-3 margin_bottom_5px has-feedback">	 <input  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="customfielddate date_css date form-control has-feedback-left validate[required]" type="text"  name="time_entry_date[]"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>" value="" readonly><span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span> </div> <div class="col-sm-3 margin_bottom_5px"> <textarea class="validate[custom[address_description_validation],maxSize[150]]" rows="1" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" name="time_entry_description[]"></textarea> </div></div> <div class="form-group"><div class="col-sm-3 margin_bottom_5px offset-sm-2"> <input class="form-control text-input validate[required] added_subtotal time_entry_hours'+value+'" row="'+value+'" type="number" onKeyPress="if(this.value.length==2) return false;" value="" min="1" name="time_entry_hours[]" placeholder="<?php esc_html_e('Enter hours','lawyer_mgt');?>"></div><div class="col-sm-3 margin_bottom_5px"> <input  class="form-control text-input validate[required,min[0],maxSize[8]] added_subtotal time_entry_rate'+value+'" row="'+value+'" type="number" step="0.01" value="" name="time_entry_rate[]" placeholder="<?php esc_html_e('Enter rate','lawyer_mgt');?>"> </div><div class="col-sm-3 margin_bottom_5px"> <input   class="form-control text-input time_entry_sub'+value+'" row="'+value+'" placeholder="<?php esc_html_e('Time Entry Subtotal','lawyer_mgt');?>" type="text" value="" name="time_entry_sub[]" readonly="readonly"> </div></div><div class="form-group"><div class="col-sm-3 margin_bottom_5px offset-sm-2"> <input   class="form-control validate[min[0],max[100]] text-input" type="number" step="0.01" value="" name="time_entry_discount" placeholder="<?php esc_html_e('Enter Discount in (%)','lawyer_mgt');?>" ></div> <div class="col-sm-3 margin_bottom_5px"><select  class="form-control tax_charge tax_dropdawn"  multiple="multiple" name="time_entry_tax['+value+'][]" ><?php $obj_invoice= new MJ_lawmgt_invoice(); $hmgt_taxs=$obj_invoice->MJ_lawmgt_get_all_tax_data(); if(!empty($hmgt_taxs)){	foreach($hmgt_taxs as $entry){ ?> <option value="<?php echo esc_attr($entry->tax_id); ?>"><?php echo esc_html($entry->tax_title);?>-<?php echo esc_html($entry->tax_value);?></option> <?php } }	?></select></div><div class="col-sm-3 margin_bottom_5px"><input type="button"  value="Delete"  class="remove_time_entry btn btn-danger"></div></div><hr>');
													$('.time_increment').val(value); 
												}  	
												 	
												function MJ_lawmgt_add_expense()
												{	
													"use strict"; 
													var value_expence = $('.expenses_increment').val(); 
													value_expence++;
													$(".tax_dropdawn").multiselect({
														nonSelectedText :'<?php esc_html_e('Select Tax','lawyer_mgt');?>',
														numberDisplayed: 1,	
														selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
														includeSelectAllOption: true         
													}); 
													<?php
														$user = wp_get_current_user();
														$userid=$user->ID;
														$user_name=get_userdata($userid);	
													?>
													
													$(".expenses_entry_div").append('<div class="main_expenses_entry_div"><div class="form-group"><label class="col-sm-2 control-label" for="medicine_name"><?php esc_html_e('Expenses Entries','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-sm-3 margin_bottom_5px"><input class="form-control text-input validate[required] onlyletter_number_space_validation" maxlength="50" type="text" value="" name="expense[]" placeholder="<?php esc_html_e('Enter expense','lawyer_mgt');?>"></div> <div class="col-sm-3 margin_bottom_5px has-feedback">	 <input  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="customfielddate date_css date form-control has-feedback-left validate[required]" type="text"  name="expense_date[]"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>" value="" readonly><span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span> </div> <div class="col-sm-3 margin_bottom_5px"> <textarea class="validate[custom[address_description_validation],maxSize[150]]" rows="1"  maxlength="150" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" name="expense_description[]"></textarea> </div></div> <div class="form-group"><div class="col-sm-3 margin_bottom_5px offset-sm-2"> <input  class="form-control text-input validate[required] added_subtotal_expenses expense_quantity'+value_expence+'" row="'+value_expence+'" type="number" onKeyPress="if(this.value.length==2) return false;" value="" min="1" name="expense_quantity[]"  placeholder="<?php esc_html_e('Enter quantity','lawyer_mgt');?>"></div><div class="col-sm-3 margin_bottom_5px"> <input  class="form-control text-input added_subtotal_expenses validate[required,min[0],maxSize[8]] expense_price'+value_expence+'" row="'+value_expence+'"  type="number" value="" name="expense_price[]"  placeholder="<?php esc_html_e('Enter Price','lawyer_mgt');?>"> </div><div class="col-sm-3 margin_bottom_5px"> <input class="form-control text-input  expense_sub'+value_expence+'" row="'+value_expence+'" type="text" value="" placeholder="<?php esc_html_e('Expenses Entry Subtotal','lawyer_mgt');?>" name="expense_sub[]" readonly="readonly"> </div></div><div class="form-group"><div class="col-sm-3 margin_bottom_5px offset-sm-2"> <input class="form-control validate[min[0],max[100]] text-input" type="number" step="0.01" value="" name="expenses_entry_discount" placeholder="<?php esc_html_e('Enter Discount in (%)','lawyer_mgt');?>" ></div> <div class="col-sm-3 margin_bottom_5px"><select  class="form-control tax_charge tax_dropdawn"  multiple="multiple" name="expenses_entry_tax['+value_expence+'][]"><?php $obj_invoice= new MJ_lawmgt_invoice(); $hmgt_taxs=$obj_invoice->MJ_lawmgt_get_all_tax_data(); if(!empty($hmgt_taxs)){	foreach($hmgt_taxs as $entry){ ?> <option value="<?php echo esc_attr($entry->tax_id); ?>"><?php echo esc_html($entry->tax_title);?>-<?php echo esc_html($entry->tax_value);?></option> <?php } }	?></select></div><div class="col-sm-3 margin_bottom_5px"><input type="button" value="Delete" class="remove_expenses_entry btn btn-danger"></div></div><hr>');
													$('.expenses_increment').val(value); 
													 
												} 
												  
												function MJ_lawmgt_add_flat_fee()
												{	
													"use strict"; 
													var value_flat = $('.flat_increment').val(); 
													value_flat++;
													$(".tax_dropdawn").multiselect({
														nonSelectedText :'<?php esc_html_e('Select Tax','lawyer_mgt');?>',
														numberDisplayed: 1,	
														selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
														includeSelectAllOption: true         
													}); 
													<?php
														$user = wp_get_current_user();
														$userid=$user->ID;
														$user_name=get_userdata($userid);	
													?>
													
													$(".flat_entry_div").append('<div class="main_flat_entry_div"><div class="form-group"><label class="col-sm-2 control-label" for="medicine_name"><?php esc_html_e('Flat Entries','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-sm-3 margin_bottom_5px"><input class="form-control text-input validate[required] onlyletter_number_space_validation" maxlength="50" type="text" value="" name="flat_fee[]" placeholder="<?php esc_html_e('Enter Flat fee','lawyer_mgt');?>"></div> <div class="col-sm-3 margin_bottom_5px has-feedback"><input  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="customfielddate date_css date form-control has-feedback-left validate[required]" type="text"  name="flat_fee_date[]"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>" value="" readonly><span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span> </div> <div class="col-sm-3 margin_bottom_5px"> <textarea  class="validate[custom[address_description_validation],maxSize[150]]" rows="1" maxlength="150" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" name="flat_fee_description[]"></textarea> </div></div> <div class="form-group"><div class="col-sm-3 margin_bottom_5px offset-sm-2"> <input  class="form-control text-input validate[required] flat_fee_quantity'+value_flat+' added_subtotal_flat_fee" type="number" onKeyPress="if(this.value.length==2) return false;" value="" min="1" name="flat_fee_quantity[]" row="'+value_flat+'" placeholder="<?php esc_html_e('Enter quantity','lawyer_mgt');?>"></div><div class="col-sm-3 margin_bottom_5px"><input class="form-control text-input validate[required,min[0],maxSize[8]] flat_fee_price'+value_flat+' added_subtotal_flat_fee" type="number" value="" name="flat_fee_price[]" row="'+value_flat+'" placeholder="<?php esc_html_e('Enter Price','lawyer_mgt');?>"> </div><div class="col-sm-3 margin_bottom_5px"> <input  class="form-control text-input  flat_fee_sub'+value_flat+'" row="'+value_flat+'" type="text" value="" name="flat_fee_sub[]" placeholder="<?php esc_html_e('Flat Entry Subtotal','lawyer_mgt');?>" readonly="readonly"> </div></div><div class="form-group"><div class="col-sm-3 margin_bottom_5px offset-sm-2"> <input  class="form-control validate[min[0],max[100]] text-input" type="number" step="0.01" value="" name="flat_entry_discount" placeholder="<?php esc_html_e('Enter Discount in (%)','lawyer_mgt');?>" ></div> <div class="col-sm-3 margin_bottom_5px"><select  class="form-control tax_charge tax_dropdawn"  multiple="multiple" name="flat_entry_tax['+value_flat+'][]"><?php $obj_invoice= new MJ_lawmgt_invoice(); $hmgt_taxs=$obj_invoice->MJ_lawmgt_get_all_tax_data(); if(!empty($hmgt_taxs)){	foreach($hmgt_taxs as $entry){ ?> <option value="<?php echo esc_attr($entry->tax_id); ?>"><?php echo esc_html($entry->tax_title);?>-<?php echo esc_html($entry->tax_value);?></option> <?php } }	?></select></div><div class="col-sm-3 margin_bottom_5px"><input type="button" value="Delete" class="remove_flat_entry btn btn-danger"></div></div><hr>');
													$('.flat_increment').val(value); 
												}	
											</script>
										     <?php												
												$invoice_id=0;
												$edit=0;
												if(isset($_REQUEST['invoice_id']))
													$invoice_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['invoice_id']));
												if(isset($_REQUEST['edit']) && sanitize_text_field($_REQUEST['edit']) == 'true')
												{					
													$edit=1;
													$invoice_info=$obj_invoice->MJ_lawmgt_get_single_invoice($invoice_id);						
												} 
												
												$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
														
												global $wpdb;
												$table_case = $wpdb->prefix. 'lmgt_cases';
												$result = $wpdb->get_row("SELECT * FROM $table_case where id=".$case_id);			
												$case_name=esc_html($result->case_name);												 			
											?> 													
											<div class="panel-body">
												<form name="invoice_form" action="" method="post" class="form-horizontal" id="invoice_form" enctype='multipart/form-data'>	
													 <?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
													<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">	
													<input type="hidden" name="invoice_id1" value="<?php echo esc_attr($invoice_id);?>"  />
													<input type="hidden" name="paid_amount" value="<?php if($edit) { echo esc_attr($invoice_info->paid_amount); } ?>"  />		
													<div class="header">	
														<h3 class="first_hed"><?php esc_html_e('Linked To','lawyer_mgt');?></h3>
														<hr>
													</div>				
													<div class="form-group">
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="contact_name"><?php esc_html_e('Case Name','lawyer_mgt');?><span class="require-field">*</span></label>
													<div class="col-sm-4">
														<?php
														$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
														$case_name=MJ_lawmgt_get_case_name($case_id);		
														?>
														<input  class="form-control text-input" type="hidden"  value="<?php echo esc_attr($case_id); ?>" name="case_name">
														<input  class="form-control validate[required] text-input" type="text"  value="<?php echo esc_attr($case_name); ?>" name="name" readonly>
													</div>		
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="contact_name"><?php esc_html_e('Billing Client Name','lawyer_mgt');?><span class="require-field">*</span></label>
													<div class="col-sm-4">
													<select class="form-control validate[required]" name="contact_name" id="invoice_contacts">	
														<option value=""><?php esc_html_e('Select Client Name','lawyer_mgt');?></option>
													<?php
													if($edit)
													{ 
														$user_id=$invoice_info->user_id;
													}
													else
													{
														$user_id="";
													}	
													$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
													$contactdata=MJ_lawmgt_get_billing_user_by_case_id($case_id);
													
													foreach($contactdata as $retrive_data)
													{  		
													?>						
														<option value="<?php echo esc_attr($retrive_data->billing_contact_id);?>" <?php selected($retrive_data->billing_contact_id,$user_id) ?>><?php echo esc_html(MJ_lawmgt_get_display_name($retrive_data->billing_contact_id)); ?></option>						
													<?php 
													}		
													?>
													</select>
													</div>		
													</div>
													<div class="header">	
														<h3 class="first_hed"><?php esc_html_e('Invoice Information','lawyer_mgt');?></h3>
														<hr>
													</div>
													<?php wp_nonce_field( 'save_case_invouice_nonce' ); ?>
													<div class="form-group">			
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="invoice_number"><?php esc_html_e('Invoice Number','lawyer_mgt');?><span class="require-field">*</span></label>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
															<input id="invoice_number" class="form-control  validate[required] text-input" type="text"  value="<?php if($edit){ echo esc_attr($invoice_info->invoice_number);} else echo MJ_lawmgt_generate_invoce_number();?>" name="invoice_number" readonly>
														
														</div>		
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="date"><?php esc_html_e('Date','lawyer_mgt');?><span class="require-field">*</span></label>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
															<input id="date"  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date form-control has-feedback-left validate[required]" type="text"  name="invoice_generated_date"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>"
															value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($invoice_info->generated_date));}elseif(isset($_POST['invoice_generated_date'])) { echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['invoice_generated_date'])); } ?>" readonly>
															<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
															<span id="inputSuccess2Status2" class="sr-only">(success)</span>		
														</div>	
													</div>
													<div class="form-group">
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="due_date"><?php esc_html_e('Due Date','lawyer_mgt');?><span class="require-field">*</span></label>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
															<input id="due_date"  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date1 form-control has-feedback-left validate[required]" type="text"  name="due_date"  placeholder="<?php esc_html_e('Select Due Date','lawyer_mgt');?>"
															value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($invoice_info->due_date));}elseif(isset($_POST['due_date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['due_date'])); } ?>" readonly>
															<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
															<span id="inputSuccess2Status2" class="sr-only">(success)</span>
														</div>	
														 	
													</div>
													<div class="header">	
														<h3 class="first_hed"><?php esc_html_e('Time Entries','lawyer_mgt');?></h3>
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
																					<input class="form-control text-input validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]" type="text" value="<?php if($edit){ echo esc_attr($data->time_entry);}elseif(isset($_POST['time_entry'])) { echo esc_attr($_POST['time_entry']); } ?>" name="time_entry[]" placeholder="<?php esc_html_e('Enter time entry','lawyer_mgt');?>">
																				</div>
																				<div class="col-sm-3 margin_bottom_5px has-feedback">
																					<input  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date form-control date_css has-feedback-left validate[required]" type="text"  name="time_entry_date[]"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>"   value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($data->time_entry_date)) ;}elseif(isset($_POST['time_entry_date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['time_entry_date'])); } ?>" readonly>
																					<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
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
																					<input class="form-control text-input validate[required,min[0],maxSize[8]] time_entry_rate<?php echo $value; ?> added_subtotal" type="number" value="<?php if($edit){ echo esc_attr($data->rate);}elseif(isset($_POST['time_entry_rate'])){ echo esc_attr($_POST['time_entry_rate']); } ?>" name="time_entry_rate[]" row="<?php echo $value;?>" placeholder="<?php esc_html_e('Enter rate','lawyer_mgt');?>">
																				</div>
																				<div class="col-sm-3 margin_bottom_5px">
																					<input class="form-control text-input  time_entry_sub<?php echo $value; ?>" row="<?php echo $value;?>" type="text" value="<?php if($edit){ echo esc_attr($data->subtotal);}elseif(isset($_POST['time_entry_sub'])) { echo esc_attr($_POST['time_entry_sub']); } ?>" name="time_entry_sub[]" readonly="readonly">
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
																					<input type="button"  value="Delete" class="remove_time_entry btn btn-danger height_39_px_css">
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
															<input type="button" value="<?php esc_attr_e('Add More Time Entries','lawyer_mgt') ?>" onclick="MJ_lawmgt_add_time_entry()" class=" btn demo btn-success">
														</div>
												<!------------->
														<div class="header">	
															<h3 class="first_hed"><?php esc_html_e('Expenses','lawyer_mgt');?></h3>
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
																				
																					<input  data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date form-control date_css has-feedback-left validate[required]" type="text"  name="expense_date[]"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($data->expense_date));}elseif(isset($_POST['expense_date'])) { echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['expense_date'])); } ?>" readonly>
																					
																					<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
																					<span id="inputSuccess2Status2" class="sr-only">(success)</span>
																				</div>	
																				<div class="col-sm-3 margin_bottom_5px">
																					<textarea  rows="1" class=" validate[custom[address_description_validation],maxSize[150]]"  placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>"  name="expense_description[]"><?php if($edit){ echo esc_textarea($data->description);}elseif(isset($_POST['expense_description'])){ echo esc_textarea($_POST['expense_description']); } ?></textarea>
																				</div>
																				
																			</div>
																			<div class="form-group">
																				<div class="col-sm-3 offset-sm-2 margin_bottom_5px">
																					<input class="form-control invoice_td_height validate[required] expense_quantity<?php echo $value;?> added_subtotal_expenses" onKeyPress="if(this.value.length==2) return false;" min="1" type="number" value="<?php if($edit){ echo esc_attr($data->quantity);}elseif(isset($_POST['expense_quantity'])){ echo esc_attr($_POST['expense_quantity']); } ?>" name="expense_quantity[]" row="<?php echo $value;?>" placeholder="<?php esc_html_e('Enter quantity','lawyer_mgt');?>">
																				</div>
																				<div class="col-sm-3 margin_bottom_5px">
																					<input class="form-control invoice_td_height validate[required] expense_price<?php echo $value;?> added_subtotal_expenses" onKeyPress="if(this.value.length==8) return false;" min="0" type="number"  step="0.01" value="<?php if($edit){ echo esc_attr($data->price);}elseif(isset($_POST['expense_price'])) { echo esc_attr($_POST['expense_price']); } ?>" name="expense_price[]" row="<?php echo $value;?>" placeholder="<?php esc_html_e('Enter Price','lawyer_mgt');?>">
																				</div>
																				<div class="col-sm-3 margin_bottom_5px">
																					<input class="form-control invoice_td_height expense_sub<?php echo $value;?>" row="<?php echo $value;?>" type="text" value="<?php if($edit){ echo esc_attr($data->subtotal);}elseif(isset($_POST['expense_sub'])) { echo esc_attr($_POST['expense_sub']); }?>" name="expense_sub[]" readonly="readonly">
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="col-sm-3 offset-sm-2 margin_bottom_5px">
																					<input class="form-control height_34_px_css validate[min[0],max[100]] text-input" type="number" step="0.01" value="<?php if($edit){ echo esc_attr($data->expenses_entry_discount);}elseif(isset($_POST['expenses_entry_discount'])){ echo esc_attr($_POST['expenses_entry_discount']); } ?>" name="expenses_entry_discount" placeholder="<?php esc_html_e('Enter Discount in (%)','lawyer_mgt');?>" >
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
																					<input type="button" value="Delete" class="remove_expenses_entry btn btn-danger invoice_button">
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
												<!------------->
														<div class="header">	
															<h3 class="first_hed"><?php esc_html_e('Flat fee','lawyer_mgt');?></h3>
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
																					<input  class="form-control text-input validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] invoice_td_height"  type="text" value="<?php if($edit){ echo esc_attr($data->flat_fee);}elseif(isset($_POST['flat_fee'])){ echo esc_attr($_POST['flat_fee']); } ?>" name="flat_fee[]" placeholder="<?php esc_html_e('Enter Flat fee','lawyer_mgt');?>">
																				</div>
																				<div class="col-sm-3 margin_bottom_5px has-feedback">
																				
																					<input  data-date-format=<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date form-control date_css has-feedback-left validate[required]" type="text"  name="flat_fee_date[]"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($data->flat_fee_date));}elseif(isset($_POST['flat_fee_date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['flat_fee_date'])); }
																					?>" readonly>
																					<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
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
																					<input   class="form-control text-input validate[required,min[0],maxSize[8]] invoice_td_height flat_fee_price<?php echo $value;?> added_subtotal_flat_fee" type="number" step="0.01" value="<?php if($edit){ echo esc_attr($data->price);}elseif(isset($_POST['flat_fee_price'])) { echo esc_attr($_POST['flat_fee_price']); } ?>" name="flat_fee_price[]" row="<?php echo $value;?>" placeholder="<?php esc_html_e('Enter Price','lawyer_mgt');?>">
																				</div>
																				<div class="col-sm-3 margin_bottom_5px">
																					<input  class="form-control text-input invoice_td_height flat_fee_sub<?php echo $value;?>" row="<?php echo $value;?>" type="text" value="<?php if($edit){ echo esc_attr($data->subtotal);}elseif(isset($_POST['flat_fee_sub'])) { echo esc_attr($_POST['flat_fee_sub']); } ?>" name="flat_fee_sub[]" readonly="readonly">
																				</div>
																			</div>
																			<div class="form-group">
																				<div class="col-sm-3 offset-sm-2 margin_bottom_5px">
																					<input class="form-control height_34_px_css validate[min[0],max[100]] text-input" type="number" step="0.01" value="<?php if($edit){ echo esc_attr($data->flat_entry_discount);}elseif(isset($_POST['flat_entry_discount'])){ echo esc_attr($_POST['flat_entry_discount']); } ?>" name="flat_entry_discount" placeholder="<?php esc_html_e('Enter Discount in (%)','lawyer_mgt');?>" >
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
																					<input type="button" value="Delete" class="remove_flat_entry btn btn-danger invoice_button">
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
													<div class="offset-lg-2  offset-md-2 offset-sm-2 col-lg-10 col-md-10 col-sm-10 col-xs-12">
														<input type="button" value="<?php esc_attr_e('Add More Flat fee','lawyer_mgt') ?>" onclick="MJ_lawmgt_add_flat_fee()" class=" btn demo btn-success">
													</div>
													<div class="header">	
														<h3 class="first_hed"><?php esc_html_e('Notes,Terms & Conditions','lawyer_mgt');?></h3>
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
																wp_editor("",'note',$setting);
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
													<div class="offset-sm-2 col-sm-8">
														<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Add Invoice','lawyer_mgt');}?>" name="save_invoice" class="btn btn-success"/>
													</div>
												</form>
											</div>													
										<?php
										}
										if($active_tab=='viewinvoice')
										{	 
											$obj_case=new MJ_lawmgt_case;
											$obj_invoice=new MJ_lawmgt_invoice;
											$invoice_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['invoice_id']));
											$invoice_info=$obj_invoice->MJ_lawmgt_get_single_invoice($invoice_id);	
											$user_id=$invoice_info->user_id;	
											$case_id=$invoice_info->case_id;
											$case_info = $obj_case->MJ_lawmgt_get_single_case($case_id);	
											$user_info=get_userdata($user_id);
											 							
											?>
											
											<div class="modal-body invoice_body"><!-- MODEL BODY DIV  -->
												<div>
													<img class="invoicefont1"  src="<?php echo plugins_url('/lawyers-management/assets/images/invoice.jpg'); ?>" width="100%">
													<div class="main_div">	
														 
															<table class="width_100" border="0">					
																<tbody>
																	<tr>
																		<td class="width_1">
																			<img class="system_logo"  src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
																		</td>							
																		<td class="only_width_20">
																			<table border="0">					
																				<tbody>
																					<tr>																	
																						<td class="invoice_add">
																							<b><?php esc_html_e('Address:','lawyer_mgt');?></b>
																						</td>	
																						<td class="padding_left_5">
																							<?php echo chunk_split(esc_html(get_option( 'lmgt_address' )),15,"<BR>").""; ?>
																						</td>											
																					</tr>
																					<tr>			
																						<td>
																							<b><?php esc_html_e('Email :','lawyer_mgt');?></b>
																						</td>	
																						<td class="padding_left_5">
																							<?php echo esc_html(get_option( 'lmgt_email' ))."<br>"; ?>
																					</tr>
																					<tr>																	
																						<td>
																							<b><?php esc_html_e('Phone :','lawyer_mgt');?></b>
																						</td>	
																						<td class="padding_left_5">
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
																	<td colspan="2" class="billed_to" align="center">								
																		<h3 class="billed_to_lable" ><?php esc_html_e('| Bill To.','lawyer_mgt');?> </h3>
																	</td>
																	<td class="width_60">								
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
															$issue_date=esc_html(MJ_lawmgt_getdate_in_input_box($invoice_info->generated_date));						
															$payment_status=$invoice_info->payment_status;
															$invoice_no=$invoice_info->invoice_number;
																			?>
														<table class="width_50" border="0">
															<tbody>				
																<tr>	
																	<td class="width_30">
																	</td>
																	<td class="width_10" align="center">
																		<h3 class="invoice_lable"><span class="font_size_12_px_css"><?php echo esc_html__('INVOICE','lawyer_mgt'); '#'?><br></span><span class="font_size_18_px_css"><?php echo $invoice_no;?></span></h3>
																		<h5> <?php   echo esc_html__('Date','lawyer_mgt')." : ".$issue_date; ?></h5>
																		<h5><?php echo esc_html__('Status','lawyer_mgt')." : ". esc_html__($payment_status,'lawyer_mgt');?></h5>									
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
																		<h3 class="entry_lable"><?php esc_html_e('Time Entries','lawyer_mgt');?></h3>
																	</td>
																</tr>	
															</tbody>	
														</table>
														<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
															<table class="table table-bordered table_row_color" border="1">
																<thead class="entry_heading">					
																		<tr>
																			<th class="color_white align_center">#</th>
																			<th class="color_white align_center"> <?php esc_html_e('DATE','lawyer_mgt');?></th>
																			<th class="color_white"><?php esc_html_e('TIME ENTRY ACTIVITY','lawyer_mgt');?> </th>
																			<th class="color_white align_center"><?php esc_html_e('HOURS','lawyer_mgt');?></th>
																			<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('AMOUNT','lawyer_mgt');?></th>
																			<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('DISCOUNT','lawyer_mgt');?></th>
																			<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('TAX','lawyer_mgt');?></th>
																			<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('TOTAL AMOUNT','lawyer_mgt');?></th>
																			
																		</tr>						
																</thead>
																<tbody>
																<?php					
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
																			 
																		?>						 
																		  <tr class="entry_list">
																			<td class="align_center"><?php echo esc_html($id);?></td>
																			<td class="align_center"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($data->time_entry_date));?></td>
																			<td><?php echo esc_html($data->time_entry);?></td>							
																			<td class="align_center"><?php echo esc_html($data->hours);?></td>
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
														</div>
														<?php   
																$id=1;
																$result_expence=$obj_invoice->MJ_lawmgt_get_single_invoice_expenses($invoice_id);
																$expense_sub_total=0;
																$expense_discount=0;
																$expense_total_tax=0;
																$expense_entry_total_amount=0;
																if(!empty($result_expence))
																{	?>
														<table class="width_100">	
															<tbody>		
																<tr>
																	<td>						
																		<h3 class="entry_lable"><?php esc_html_e('Expenses Entries','lawyer_mgt');?></h3>
																	</td>
																</tr>	
															</tbody>	
														</table>
														<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
															<table class="table table-bordered table_row_color" border="1">
																<thead class="entry_heading">					
																		<tr>
																			<th class="color_white align_center">#</th>
																			<th class="color_white align_center"> <?php esc_html_e('DATE','lawyer_mgt');?></th>
																			<th class="color_white"><?php esc_html_e('EXPENSES ACTIVITY','lawyer_mgt');?> </th>	
																			<th class="color_white align_center"><?php esc_html_e('QUANTITY','lawyer_mgt');?></th>
																			<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('AMOUNT','lawyer_mgt');?></th>
																			<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('DISCOUNT','lawyer_mgt');?></th>
																			<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('TAX','lawyer_mgt');?></th>
																			<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('TOTAL AMOUNT','lawyer_mgt');?></th>														
																		</tr>						
																</thead>
																<tbody>
																<?php					
																	
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
																		?>						 
																	  <tr class="entry_list">
																		<td class="align_center"><?php echo esc_html($id);?></td>
																		<td class="align_center"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($data->expense_date));?></td>
																		<td><?php echo esc_html($data->expense);?></td>							
																		<td class="align_center"><?php echo esc_html($data->quantity);?></td>
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
														</div>
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
																		<h3 class="entry_lable"><?php esc_html_e('Flat Fees Entries','lawyer_mgt');?></h3>
																	</td>
																</tr>	
															</tbody>	
														</table>
														<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
															<table class="table table-bordered table_row_color" border="1">
																<thead class="entry_heading">					
																		<tr>
																			<th class="color_white align_center">#</th>
																			<th class="color_white align_center"> <?php esc_html_e('DATE','lawyer_mgt');?></th>
																			<th class="color_white"><?php esc_html_e('FLATE FEE ACTIVITY','lawyer_mgt');?> </th>	
																			<th class="color_white align_center"><?php esc_html_e('QUANTITY','lawyer_mgt');?></th>
																			<th class="color_white align_right"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('AMOUNT','lawyer_mgt');?></th>
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
																				<td class="align_center"><?php echo esc_html($id);?></td>
																				<td class="align_center"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($data->flat_fee_date));?></td>
																				<td><?php echo esc_html($data->flat_fee);?></td>
																				<td class="align_center"><?php echo esc_html($data->quantity);?></td>
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
														</div>
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
																	<h4><td class="width_80 align_right"><h4 class="margin"><?php esc_html_e('Subtotal Amount:','lawyer_mgt');?></h4></td>
																	<td class="align_right amount_padding_15"> <h4 class="margin"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".number_format(esc_html($subtotal_amount),2);?></h4></td>
																</tr>
																
																	<tr>
																		<td class="width_80 align_right"><h4 class="margin"><?php esc_html_e('Discount Amount :','lawyer_mgt');?></h4></td>
																		<td class="align_right amount_padding_15"> <h4 class="margin"><?php if(!empty($discount_amount)){ echo "<span> -(".MJ_lawmgt_get_currency_symbol().")</span>".number_format(esc_html($discount_amount),2); }else{ echo "<span> -(".MJ_lawmgt_get_currency_symbol().")</span>".'0'; } ?></h4></td>
																	</tr>
																	<tr>
																		<td class="width_80 align_right"><h4 class="margin"><?php esc_html_e('Tax Amount :','lawyer_mgt');?></h4></td>
																		<td class="align_right amount_padding_15"><h4 class="margin"><?php if(!empty($tax_amount)){ echo "<span> +(".MJ_lawmgt_get_currency_symbol().")</span>".number_format(esc_html($tax_amount),2); }else{ echo "<span>+(".MJ_lawmgt_get_currency_symbol().")</span>".'0'; }?></h4></td>
																	</tr>
																	<tr>
																		<td class="width_80 align_right"><h4 class="margin"><?php esc_html_e('Paid Amount :','lawyer_mgt');?></h4></td>
																		<td class="align_right amount_padding_15"> <h4 class="margin"><span ><?php if(!empty($paid_amount)){ echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".number_format(esc_html($paid_amount),2); }else{ echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".'0'; }?></h4></td>
																	</tr>						
																	<tr>
																		<td class="width_80 align_right due_amount_color"><h4 class="margin"><?php esc_html_e('Due Amount :','lawyer_mgt');?></h4></td>
																		<td class="align_right amount_padding_15 due_amount_color"> <h4 class="margin"><span ><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".number_format(esc_html($due_amount),2); ?></h4></td>
																	</tr>
																<tr>							
																	<td class="align_right grand_total_lable padding_11"><h3 class="padding color_white margin"><?php esc_html_e('Grand Total :','lawyer_mgt');?></h3></td>
																	<td class="align_right grand_total_amount amount_padding_15"><h3 class="padding color_white margin"><?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".number_format(esc_html($grand_total),2); ?></h3></td>
																</tr>							
															</tbody>
														</table>		
														<table class="width_46" border="0">
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
																	<td class="font_12">: <?php echo esc_html(get_option( 'lmgt_paypal_email'));?></td>
																</tr>
															<?php   } ?>
															</tbody>
														</table>
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
											<table class="table table-bordered table_row_color" border="1">
												<thead class="entry_heading">					
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
														<table class="table_invoice gst_details" border="0">
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
																}  
																?>
															</tr>	
														</thead>
														<tbody>
															<tr>								
																<td class="align_center"><?php echo esc_html($gst_number);?></td>
																<td class="align_center"><?php echo esc_html($tax_id);?></td>
																<td class="align_center"><?php echo esc_html($corporate_id);?></td>
															</tr>	
														</tbody>
														</table>
														</table>
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
														<div class="print-button pull-left">
															<a  href="?page=invoice&print=print&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($invoice_id));?>" target="_blank"class="btn btn-success"><?php esc_html_e('Print','lawyer_mgt');?></a>	
															<a  href="?page=invoice&invoicepdf=invoicepdf&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($invoice_id));?>" target="_blank"class="btn btn-success"><?php esc_html_e('PDF','lawyer_mgt');?></a>				
														</div>
													</div>
												</div>
												
											</div><!-- END MODEL BODY DIV  -->											
										<?php
										}
										if($active_tab=='invoicelist')
										{											
										?>      
											<script type="text/javascript">
												jQuery(document).ready(function($)
												{
													"use strict"; 
													jQuery('#invoice_list').DataTable({
														"responsive": true,
														"autoWidth": false,
														 "order": [[ 1, "asc" ]],
														 language:<?php echo wpnc_datatable_multi_language();?>,
														 "aoColumns":[
																	  {"bSortable": false},
																	   <?php if(in_array('invoice_number',$invoice_columns_array)) { ?>
													  {"bSortable": true},
														<?php  }  ?>
														<?php if(in_array('invoice_date',$invoice_columns_array)) {  ?>
																  {"bSortable": true},
														<?php   }   ?>
														<?php if(in_array('due_date',$invoice_columns_array)) {  ?>
																  {"bSortable": true},
														<?php   }   ?>
														 <?php if(in_array('invoice_billing_contact_name',$invoice_columns_array)) { ?>
																  {"bSortable": true},
														 <?php  }  ?>
														 <?php if(in_array('invoice_case_name',$invoice_columns_array)) { ?>
																  {"bSortable": true},	
														 <?php  }  ?>
														 <?php if(in_array('total_amount',$invoice_columns_array)) { ?>
																  {"bSortable": true},
														 <?php  }  ?>
														 <?php if(in_array('paid_amount',$invoice_columns_array)) {  ?>
																  {"bSortable": true},
														<?php  }  ?>
														<?php  if(in_array('due_amount',$invoice_columns_array)) {     ?>
																  {"bSortable": true},
														<?php  }  ?>
														<?php if(in_array('payment_status',$invoice_columns_array)) { ?>
																  {"bVisible": true},
														<?php  }  ?>
														 
														<?php if(in_array('invoice_notes',$invoice_columns_array)) { ?>
																  {"bSortable": true},
														<?php  }  ?>
														<?php if(in_array('terms',$invoice_columns_array)) {   ?>
																  {"bSortable": true},
														<?php  }  ?>	                 
																	  {"bSortable": false}
																   ]		 
														});
														$(".delete_check").on('click', function()
														{	
															if ($('.sub_chk:checked').length == 0 )
														{
															alert("<?php esc_html_e('Please select atleast one record','lawyer_mgt');?>");
															return false;
														}
														else{
															alert("<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>");
															return true;
															}
													});
												} );
												jQuery(document).ready(function($)
												{		
													"use strict"; 
													jQuery('#select_all').on('click', function(e)
													{
														 if($(this).is(':checked',true))  
														 {
															$(".sub_chk").prop('checked', true);  
														 }  
														 else  
														 {  
															$(".sub_chk").prop('checked',false);  
														 } 
													});
													$("body").on("change", ".sub_chk", function()
													{ 
														if(false == $(this).prop("checked"))
														{ 
															$("#select_all").prop('checked', false); 
														}
														if ($('.sub_chk:checked').length == $('.sub_chk').length )
														{
															$("#select_all").prop('checked', true);
														}
													});
												});	
											</script>
											<form name="wcwm_report" action="" method="post">
												<div class="panel-body">
													<div class="table-responsive">
														<table id="invoice_list" class="table table-striped table-bordered">
															<thead>
															<tr>
																<th><input type="checkbox" id="select_all"></th>
																<?php if(in_array('invoice_number',$invoice_columns_array)) { ?>
													<th><?php  esc_html_e('Invoice Number', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?>
											<?php if(in_array('invoice_date',$invoice_columns_array)) { ?>
													<th><?php esc_html_e('Invoice Date', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?>		
											<?php if(in_array('due_date',$invoice_columns_array)) { ?>
													<th><?php esc_html_e('Due Date', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?>		
											<?php if(in_array('invoice_billing_contact_name',$invoice_columns_array)) { ?>
													<th> <?php esc_html_e('Billing Client Name', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?>
											<?php if(in_array('invoice_case_name',$invoice_columns_array)) { ?>
													<th> <?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?>
											<?php if(in_array('total_amount',$invoice_columns_array)) { ?>
													<th> <?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('Total Amount', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?>
											<?php if(in_array('paid_amount',$invoice_columns_array)) { ?>
													<th> <?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('Paid Amount', 'lawyer_mgt' ) ;?></th>	
											<?php  }  ?>
											<?php if(in_array('due_amount',$invoice_columns_array)) { ?>
													<th> <?php echo "<span> (".MJ_lawmgt_get_currency_symbol().")</span>".esc_html_e('Due Amount', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?>
											<?php if(in_array('payment_status',$invoice_columns_array)) { ?>
													<th> <?php esc_html_e('Payment Status', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?>
											<?php if(in_array('invoice_notes',$invoice_columns_array)) { ?>
													<th><?php  esc_html_e('Notes', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?>
											<?php if(in_array('terms',$invoice_columns_array)) { ?>
													<th><?php  esc_html_e('Terms & Conditions', 'lawyer_mgt' ) ;?></th>
											<?php  }  ?> 		
																<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
															</tr>
															</thead>
															<tbody>
															 <?php 
																$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
																$user_invoice_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('invoice');
																if($user_role == 'attorney')
																{	
																	$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice_by_caseid($case_id);	
																}
																elseif($user_role == 'client')
																{
																	if($user_invoice_access['own_data'] == '1')
																	{
																		$current_user_id = get_current_user_id();
																		$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice_by_caseid_client($case_id,$current_user_id);
																	}
																	else
																	{
																		$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice_by_caseid($case_id);
																	}
																}
																else
																{	
																	if($user_invoice_access['own_data'] == '1')
																	{
																		$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice_by_caseid_created_by($case_id);
																	}
																	else
																	{
																		$invoicedata=$obj_invoice->MJ_lawmgt_get_all_invoice_by_caseid($case_id);
																	}
																}
																
																foreach ($invoicedata as $retrieved_data)
																{
																	$user_id=$retrieved_data->user_id;
																	$userdata=get_userdata($user_id);
																	$conatc_name=$userdata->display_name;
																?>
																<tr>
																	<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_attr($retrieved_data->id); ?>"></td>	
																	<?php if(in_array('invoice_number',$invoice_columns_array)) { ?>
													<td><?php echo esc_html($retrieved_data->invoice_number);?></td>
											<?php  }  ?>
											<?php if(in_array('invoice_date',$invoice_columns_array)) {  ?>
													<td><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->generated_date));?></td>		
											<?php  }  ?>
											<?php if(in_array('due_date',$invoice_columns_array)) {  ?>		
													<td><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->due_date));?></td>
											 <?php  }  ?>			
													<?php if(in_array('invoice_billing_contact_name',$invoice_columns_array)) { ?>
													<td><?php echo $conatc_name;?></td>
											 <?php  }  ?>
											 <?php if(in_array('invoice_case_name',$invoice_columns_array)) {  
													 				
													$case_id=$retrieved_data->case_id;
													$case_name=$obj_invoice->MJ_lawmgt_get_all_case_name_from_case_id($case_id); ?>
													<td><a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo esc_attr(MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id)));?>"><?php echo esc_html($case_name->case_name);?></a></td>
											 <?php  }        
											  if(in_array('total_amount',$invoice_columns_array)) { ?>
													<td><?php echo number_format(esc_html($retrieved_data->total_amount),2);?></td>
											<?php  }  	
											if(in_array('paid_amount',$invoice_columns_array)) {  ?>
													<td><?php echo number_format(esc_html($retrieved_data->paid_amount),2);?></td>
											<?php  }   
											if(in_array('due_amount',$invoice_columns_array)) {   ?>
													<td><?php echo number_format(esc_html($retrieved_data->due_amount),2);?></td>	
											<?php  }   	
											if(in_array('payment_status',$invoice_columns_array)) { ?>
													<td><span class="btn btn-success btn-xs"><?php echo MJ_lawmgt_get_invoice_paymentstatus($retrieved_data->id); ?></span></td>
											<?php  }  
											if(in_array('invoice_notes',$invoice_columns_array)) { ?>
													<td><?php echo  esc_html($retrieved_data->note); ?></td>
											<?php  }  
											if(in_array('terms',$invoice_columns_array)) {   ?>		
													<td><?php echo  esc_html($retrieved_data->terms); ?></td>	
											<?php  }  ?>
											<td>    
																	<?php 
																			if(MJ_lawmgt_get_invoice_paymentstatus_for_payment($retrieved_data->id) == 'Fully Paid')
																			{  ?>			
																			 	
																				<a href="?dashboard=user&page=cases&tab=casedetails&action=view&view=true&tab2=invoice&tab3=viewinvoice&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
																				<?php
																				if($user_access_invoice['edit']=='1')
																				{
																				?>
																					<a href="?dashboard=user&page=cases&tab=casedetails&action=view&edit=true&tab2=invoice&tab3=addinvoice&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
																				<?php
																				}
																				if($user_access_invoice['delete']=='1')
																				{
																				?>
																					<a href="?dashboard=user&page=cases&tab=casedetails&action=view&deleteinvoice=true&tab2=invoice&tab3=invoicelist&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" 
																					onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');">
																					<?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>		
																			<?php 
																				}
																			}
																		   else 
																		   {
																			if($user_role == 'client')
																			{	
																				?>
																				<a href="#"  class="show-payment-popup btn btn-default" case_id="<?php echo $retrieved_data->case_id; ?>" invoice_id="<?php echo $retrieved_data->id; ?>" view_type="payment" due_amount="<?php echo number_format($retrieved_data->due_amount,2, '.', '');?>"><?php esc_html_e('Pay','lawyer_mgt');?></a>	
																			<?php
																			}
																			?>
																			 
																				<a href="?dashboard=user&page=cases&tab=casedetails&action=view&view=true&tab2=invoice&tab3=viewinvoice&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
																				<?php
																				if($user_access_invoice['edit']=='1')
																				{
																					?>
																					<a href="?dashboard=user&page=cases&tab=casedetails&action=view&edit=true&tab2=invoice&tab3=addinvoice&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
																				<?php
																				}
																				if($user_access_invoice['delete']=='1')
																				{
																				?>
																					<a href="?dashboard=user&page=cases&tab=casedetails&action=view&deleteinvoice=true&tab2=invoice&tab3=invoicelist&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&invoice_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" 
																					onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');">
																					<?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>		
																		<?php
																				}
																		   }
																		 ?>				
																	</td>               
																</tr>
																<?php } 			
																?>     
															</tbody>        
														</table>
														<?php
														if($user_access_invoice['delete']=='1')
														{ 
															if(!empty($invoicedata))
															{
																?>
																<div class="form-group">		
																	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
																		<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="invoice_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
																	</div>
																</div>
																<?php
															}
														}
														 ?>	
													</div>
												</div>										   
											</form>
										 <?php 
										}											 
									}
									if($active_tab=='workflow')
									{
										$obj_caseworkflow=new MJ_lawmgt_caseworkflow;

										$active_tab = sanitize_text_field(isset($_GET['tab3'])?$_GET['tab3']:'workflow_list');
										$user_access_workflow=MJ_lawmgt_get_userrole_wise_filter_access_right_array('workflow');
										?>     
										<h2>	
											<ul id="myTab" class="sub_menu_css line nav nav-tabs case_details_documents" role="tablist">
												<li role="presentation" class="<?php echo esc_html($active_tab) == 'workflow_list' ? 'active' : ''; ?> ">
													<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=workflow&tab3=workflow_list&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
														<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Apply Workflow List', 'lawyer_mgt'); ?>				
													</a>
												</li>
												
												<?php if(isset($_REQUEST['edit'])&& sanitize_text_field($_REQUEST['edit'])=='true') {?>
												<li role="presentation" class="<?php echo esc_html($active_tab) == 'applyworkflow' ? 'active' : ''; ?>">
													<a href="?dashboard=user&page=cases&tab=casedetails&action=view&edit=true&tab2=workflow&tab3=applyworkflow&workflow_id=<?php echo esc_attr($_REQUEST['workflow_id']);?>&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
														<?php echo esc_html__('Edit Apply Workflow', 'lawyer_mgt'); ?>					
													</a>
												</li>
												<?php }
												else
												{
													if($user_access_workflow['add']=='1')
													{
														?>
														<li role="presentation" class="<?php echo esc_html($active_tab) == 'applyworkflow' ? 'active' : ''; ?>">
															<a href="?dashboard=user&page=cases&tab=casedetails&action=view&add=true&tab2=workflow&tab3=applyworkflow&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
																<?php echo '<span class="fa fa-plus-circle"></span> '.esc_html__('Apply Workflow', 'lawyer_mgt'); ?>	
															</a>
														</li>
														<?php 
													}
												}
												?>
												<?php if(isset($_REQUEST['view'])&& sanitize_text_field($_REQUEST['view'])=='true') 
												{
													?>
												<li role="presentation" class="<?php echo $active_tab == 'view_applyworkflow' ? 'active' : ''; ?> ">
													<a href="?dashboard=user&page=cases&tab=casedetails&action=view&view=true&tab2=workflow&tab3=view_applyworkflow&workflow_id=<?php echo esc_attr($_REQUEST['workflow_id']);?>&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
														<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('View Apply Workflow', 'lawyer_mgt'); ?>				
													</a>
												</li>
												<?php 
												}
												?>
											</ul>
										</h2>
										<?php
										if($active_tab=='applyworkflow')
										{?>	 
											<!-- Workflow Pop up Code -->
												<div class="popup-bg1">
													<div class="overlay-content">
														<div class="modal-content">
															<div class="workflow_list">
															</div>     
														</div>
													</div>     
												</div>
												<!-- Workflow List End POP-UP Code -->

												<script type="text/javascript">
													jQuery(document).ready(function($)
													{
														"use strict"; 
														$('#workflow_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
														
														$(".event_contact").multiselect({ 
															 nonSelectedText :'Select Client FFFF',
															 includeSelectAllOption: true         
														 });
														 $(".task_contact").multiselect({ 
															 nonSelectedText :'Select Client DDD',
															 includeSelectAllOption: true         
														 });
														 //------ADD workflow AJAX----------
														   $('#add_workflow_form').on('submit', function(e) 
														   {
														
															e.preventDefault();
															
															//var form = $(this).serialize(); 
															var valid = $('#add_workflow_form').validationEngine('validate');
															
															if (valid == true) 
															{		 
																var form = new FormData(this);
																 
																$.ajax({
																	type:"POST",
																	url: $(this).attr('action'),
																	data:form,
																	cache: false,
																	contentType: false,
																	processData: false,
																	success: function(data)
																	{   
																		   if(data!="")
																		   { 
																			var json_obj = $.parseJSON(data);
																			$('#add_workflow_form').trigger("reset");
																			$('#apply_workflow_name').append(json_obj);						
																			$('.modal').modal('hide');
																		  }     
																	},
																	error: function(data){
																	}
																})
															}
														});  
															
													});
												</script> 
												<?php 	
												$obj_workflow=new MJ_lawmgt_workflow;
												$obj_caseworkflow=new MJ_lawmgt_caseworkflow;

													$workflow_id=0;
													$edit=0;
													if(isset($_REQUEST['workflow_id']))
														$workflow_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['workflow_id']));
														$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
													if(isset($_REQUEST['edit']) && sanitize_text_field($_REQUEST['edit']) == 'true')
													{					
														$edit=1;
														$workflow_allevents=$obj_caseworkflow->MJ_lawmgt_get_single_applyworkflow_allevents_by_caseid($workflow_id,$case_id);						
														$workflow_alltasks=$obj_caseworkflow->MJ_lawmgt_get_single_applyworkflow_alltasks_by_caseid($workflow_id,$case_id);						
													}
													?>														
													<div class="panel-body">
														<form name="workflow_form" action="" method="post" class="form-horizontal" id="workflow_form" enctype='multipart/form-data'>	
															 <?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
															<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">	
															<input type="hidden" id="case_id" name="case_id" value="<?php echo esc_attr($case_id);?>"  />
															<input type="hidden" name="workflow_id" value="<?php echo esc_attr($workflow_id);?>"  />		
															<div class="header">	
																<h3 class="first_hed"><?php esc_html_e('Workflow Information','lawyer_mgt');?></h3>
																<hr>
															</div>	
															<?php
															if($edit==0)
															{
															?>
															<div class="form-group">
																<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Select Workflow','lawyer_mgt');?><span class="require-field">*</span></label>
																<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">			
																	<select class="form-control validate[required]" name="workflow_name" id="apply_workflow_name">
																	<option value=""><?php esc_html_e('Select Workflow','lawyer_mgt');?></option>
																	<?php
																	$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
																	$attorney_id=$obj_workflow->MJ_lawmgt_get_attorney_by_case($case_id);
																	
																	if($user_role == 'attorney')
																	{
																		if($user_access_workflow['own_data'] == '1')
																		{		
																			$workflow_data=$obj_workflow->MJ_lawmgt_get_all_workflow_by_case_attorney_own($attorney_id);
																		}
																		else
																		{	
																			$workflow_data=$obj_workflow->MJ_lawmgt_get_all_workflow_by_case_attorney($attorney_id);
																		}
																	}
																	else
																	{
																		if($user_access_workflow['own_data'] == '1')
																		{		
																			$workflow_data=$obj_workflow->MJ_lawmgt_get_all_workflow_by_case_attorney_and_created_by($attorney_id);
																		}
																		else
																		{	
																			$workflow_data=$obj_workflow->MJ_lawmgt_get_all_workflow_by_case_attorney($attorney_id);
																		}
																	}
																	
																	if(!empty($workflow_data))
																	{
																		foreach ($workflow_data as $retrive_data)
																		{ 		 	
																		?>
																			<option value="<?php echo esc_attr($retrive_data->id);?>"><?php echo esc_html($retrive_data->name); ?> </option>
																		<?php 
																		}
																	} 
																	?> 
																	</select>				
																</div>	
															<?php
															if($user_access_workflow['add']=='1')
															{
																?>	
																<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																	<a href="#" class="btn btn-success" data-toggle="modal" data-target="#myModal_add_workflow"> <?php esc_html_e('Add Workflow','lawyer_mgt');?></a>	
																</div>
																<?php
															}
															?>
															</div>			
															<div class="apply_workflow_details_div workflow_front">
															
															</div>	
															<?php 
															}
															?>
															<?php
															if($edit==1)
															{
															?>
																<div class="form-group">
																	<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Workflow Name','lawyer_mgt');?></label>
																	<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
																	<?php $workflow_name=MJ_lawmgt_get_workflow_name($workflow_id);?>
																			<input type="text" class="form-control" name="workflow_name"  value="<?php echo esc_attr($workflow_name);?>" readonly="readonly">	
																	</div>					
																</div>
																<div class="header">	
																<h3 class="first_hed"><?php esc_html_e('Workflow Events','lawyer_mgt');?></h3>
																<hr>
																</div>	
																<?php
																if(!empty($workflow_allevents))
																{				
																	foreach ($workflow_allevents as $retrive_data)
																	{
																	?>						
																		<div class="form-group workflow_item">
																			<input type="hidden" name="event_id[]" value="<?php echo esc_attr($retrive_data->id);?>">
																					<div class="form-group">
																						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="event_subject"><?php esc_html_e('Event Subject','lawyer_mgt');?></label>
																						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
																							<input id="event_subject" class="form-control has-feedback-left validate[required,custom[onlyLetterSp]] text-input event_subject" type="text" placeholder="<?php esc_html_e('Enter Event Subject','lawyer_mgt');?>" value="<?php echo esc_attr($retrive_data->subject);?>" name="event_subject[]" readonly="readonly">
																							<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
																						</div>
																					</div>
																					<div class="form-group">
																						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Event Date','lawyer_mgt');?><span class="require-field">*</span></label>
																						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
																							<input class="form-control has-feedback-left validate[required] text-input event_date apply_case_event_date" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" type="text" placeholder="<?php esc_html_e('Select Event Date','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($retrive_data->event_date));}elseif(isset($_POST['event_date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['event_date'])); } ?>" name="event_date[]">
																							<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
																						</div>	
																					</div>
																					<div class="form-group">
																						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" ><?php esc_html_e('Attendees','lawyer_mgt');?></label>
																						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">			
																						<select class="form-control event_contact"  multiple="multiple" name="event_contact[<?php echo $retrive_data->subject;?>][]">			
																				<?php
																				global $wpdb;
															
																				$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
																				
																				$case_conacts = $wpdb->get_results("SELECT * FROM $table_case_contacts where case_id=".$case_id);
																				
																				$selected_attendees=explode(",",$retrive_data->attendees);			
																				
																				if(!empty($case_conacts))
																				{
																					foreach ($case_conacts as $retrive_data)
																					{ 		
																					
																						$contact_name=MJ_lawmgt_get_display_name($retrive_data->user_id);
																						?>
																					<option value="<?php echo esc_attr($retrive_data->user_id); ?>" <?php if(!empty($selected_attendees)){ if(in_array($retrive_data->user_id,$selected_attendees)) { print "selected"; } }?>><?php echo esc_html($contact_name); ?></option>	
																				<?php
																					} 
																				} 								
																				?>	
																						</select>				
																					</div>
																					</div>
																				</div>	
																<?php
																	}
																} 
																?>		
																<div class="header">	
																<h3 class="first_hed"><?php esc_html_e('Workflow Tasks','lawyer_mgt');?></h3>
																<hr>
																</div>
																<?php
																if(!empty($workflow_alltasks))
																{				
																	foreach ($workflow_alltasks as $retrive_data)
																	{ ?>
																		<div class="form-group workflow_item">
																				<input type="hidden" name="task_id[]" value="<?php echo esc_attr($retrive_data->id);?>">
																				<div class="form-group">
																					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="task_subject"><?php esc_html_e('Task Subject','lawyer_mgt');?></label>
																					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
																						<input id="event_subject" class="form-control has-feedback-left validate[required] text-input task_subject" type="text" placeholder="<?php esc_html_e('Enter task Subject','lawyer_mgt');?>" value="<?php echo $retrive_data->subject;?>" name="task_subject[]" readonly="readonly">
																						<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label "><?php esc_html_e('Due Date','lawyer_mgt');?></label>
																					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
																				<?php
																					$due_date=$retrive_data->due_date;
																					 $data=json_decode($due_date);
																					$due_date_type =$data->due_date_type;
																					$days =$data->days;
																					$day_formate =$data->day_formate;
																					$day_type =$data->day_type;
																					$task_event_name =$data->task_event_name;
																				?>
																					<input type="hidden" name="due_date_type[]" value=<?php  echo esc_attr($due_date_type);?>>
																					<input type="hidden" name="days[]" value=<?php echo $days;?>>
																					<input type="hidden" name="day_formate[]" value=<?php echo esc_attr($day_formate);?>>
																					<input type="hidden" name="day_type[]" value=<?php echo esc_attr($day_type);?>>
																					<input type="hidden" name="task_event_name[]" value=<?php echo esc_attr($task_event_name);?>>
																					<?php
																					if($data->due_date_type == 'automatically')
																					{
																					?>
																						<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label task_due_date_css" name="due_date[]"> <?php echo $days;?> <?php echo $day_formate;?> <?php echo$day_type;?> <?php echo $task_event_name;?> </label>
																					<?php
																					}
																					else
																					{
																					?>
																						<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label task_due_date_css" name="due_date[]"><?php esc_html_e('No Due Date','lawyer_mgt');?></label>
																				 <?php
																					}
																					?>
																				</div>	
																				</div>
																				<div class="form-group">
																					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" ><?php esc_html_e('Assign To','lawyer_mgt');?></label>
																					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">			
																					<select class="form-control task_contact"  multiple="multiple" name="task_contact[<?php echo $retrive_data->subject;?>][]">	
																			<?php		
																			global $wpdb;
														
																			$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
																			
																			$case_conacts = $wpdb->get_results("SELECT * FROM $table_case_contacts where case_id=".$case_id);
																			
																			$selected_assign_to=explode(",",$retrive_data->assign_to);			
																			
																			if(!empty($case_conacts))
																			{
																				foreach ($case_conacts as $retrive_data)
																				{ 	
																					$contact_name=MJ_lawmgt_get_display_name($retrive_data->user_id);
																					?>	
																						<option value="<?php echo esc_attr($retrive_data->user_id);?>" <?php if(!empty($selected_assign_to)){ if(in_array($retrive_data->user_id,$selected_assign_to)) { print "selected"; } }?>><?php echo esc_html($contact_name);?></option>	
																			<?php
																				} 
																			} 						
																			?>	
																					</select>				
																				</div>
																				</div>
																			</div>
																			<?php
																	}
																}						
															}
															?>
															<?php wp_nonce_field( 'save_workflow_nonce' ); ?>
															<div class="offset-sm-2 col-sm-8">
																<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Apply Workflow','lawyer_mgt');}?>" name="save_workflow" class="btn btn-success"/>
															</div>
														</form>
													</div>													 
												<!----------ADD Workflow------------->	 
													
												<script type="text/javascript">
												    var $ = jQuery.noConflict();
													jQuery(document).ready(function($)
													{
														"use strict"; 
														$('#add_workflow_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
													});
													"use strict"; 
													var value = 1;
													function MJ_lawmgt_add_event()
													{
														"use strict"; 
														value++;
														
														$("#event_div").append('<div class="form-group workflow_item"><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="event_subject"><?php esc_html_e('Event Subject','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback"><input id="event_subject'+value+'" opt_class="op'+value+'" class="form-control has-feedback-left validate[required] text-input event_subject onlyletter_number_space_validation" maxlength="50" type="text" placeholder="<?php esc_html_e('Enter Event Subject','lawyer_mgt');?>" value="" name="event_subject[]"><span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span></div></div><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="event_description"><?php esc_html_e('Event Description','lawyer_mgt');?></label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback"><textarea rows="2"  name="event_description[]" class="width_100_per_resize_css" maxlength="150" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" id="event_description"></textarea></div></div><div class="form-group"><div class="offset-lg-2 col-lg-2 offset-md-2 col-md-2 offset-sm-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt');?>" class="remove_event btn btn-danger" row="'+value+'"></div></div></div>');   

														$(".task_event_name").append('<option class=op'+value+'></option>');
													}  	
													"use strict"; 	
													var value = 1;
													function MJ_lawmgt_add_task()
													{
														"use strict"; 
														value++;
														$("#task_div").append('<div class="form-group workflow_item"><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="task_subject"><?php esc_html_e('Task Subject','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback"><input id="task_subject" class="form-control has-feedback-left validate[required] text-input onlyletter_number_space_validation " type="text" placeholder="<?php esc_html_e('Enter Task Subject','lawyer_mgt');?>" maxlength="50" value="" name="task_subject[]"><span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span></div></div><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="task_description">Task Description</label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback"><textarea rows="2" name="task_description[]" class="width_100_per_resize_css" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" maxlength="150" id="task_description"></textarea></div></div><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="due_date_type">Due Date</label><div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"><select class="form-control due_date_type'+value+'" name="due_date_type[]"  id="due_date_type" row="'+value+'" ><option value="automatically"><?php esc_html_e('Automatically','lawyer_mgt');?></option><option value="no_due_date" selected><?php esc_html_e('No due date','lawyer_mgt');?></option></select></div><div class="date_time_by_event date_time_by_event_css  date_time_by_event'+value+'"><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><input class="form-control validate[required] text-input" type="number" placeholder="<?php esc_html_e('Enter Days','lawyer_mgt');?>" value="1" name="days[]"></div><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><select class="form-control" name="day_formate[]" id="days"><option value="days" selected>Days</option></select></div><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><select class="form-control" name="day_type[]" id="days"><option value="before" selected><?php esc_html_e('Before','lawyer_mgt');?></option><option value="after" ><?php esc_html_e('After','lawyer_mgt');?></option></select></div><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><select class="form-control validate[required] task_event_name task_event_name'+value+'" name="task_event_name[]" id="task_event_name"></select></div></div></div><div class="form-group"><div class="offset-lg-2 col-lg-2 offset-md-2 col-md-2 offset-sm-2 col-sm-2 col-xs-12"><input type="button" value="<?php esc_html_e('Remove','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement_task(this)" class="remove_task btn btn-danger"></div></div>');   		
														
														var event_name=[];
														var i=0;
															
														$(".event_subject").each(function () 
														{
															
															var e_subject=$(this).val();
															var option_class = $(this).attr('opt_class');
															
															event_name[i]='<option class='+option_class+' value='+e_subject+'>'+e_subject+'</option>';
															i++;
														});	
															
														$(".task_event_name"+value).html(event_name);
													}  	

													function MJ_lawmgt_deleteParentElement_task(n)
													{ 
														"use strict"; 
														alert("<?php esc_html_e('Do you really want to delete this ?','lawyer_mgt');?>");
													   n.closest('.workflow_item').remove();	  
													}
												</script>
													  
												<div class="modal fade overflow_scroll_css" id="myModal_add_workflow" role="dialog">
													<div class="modal-dialog modal-lg">
													  <div class="modal-content">
														<div class="modal-header">
														  <button type="button" class="close" data-dismiss="modal">&times;</button>
														  <h3 class="modal-title"><?php esc_html_e('Add Workflow','lawyer_mgt');?></h3>
														</div>
														<div class="modal-body">
															<form name="add_workflow_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form-horizontal" id="add_workflow_form" enctype='multipart/form-data'>	
														<input type="hidden" name="action" value="MJ_lawmgt_add_workflow_into_database">		
														<input type="hidden" name="workflow_id" value="<?php echo $workflow_id;?>"  />
														<div class="header">	
															<h3 class="first_hed"><?php esc_html_e('Workflow Information','lawyer_mgt');?></h3>
															<hr>
														</div>
														<div class="form-group">
															<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="workflow_name"><?php esc_html_e('Workflow Name','lawyer_mgt');?><span class="require-field">*</span></label>
															<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
																<input id="workflow_name" class="form-control has-feedback-left validate[required] text-input onlyletter_number_space_validation" maxlength="50" type="text" placeholder="<?php esc_html_e('Enter Workflow Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($workflow_info->name);}elseif(isset($_POST['workflow_name'])){ echo esc_attr($_POST['workflow_name']); } ?>" name="workflow_name">
																<span class="fa fa-stack-overflow form-control-feedback left" aria-hidden="true"></span>
															</div>			
														</div>	
														<div class="form-group">
															<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="workflow_description"><?php esc_html_e('Workflow Description','lawyer_mgt');?></label>
															<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
																<textarea rows="3" class="width_100_per_resize_none_css" name="workflow_description" maxlength="150" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" id="workflow_description"><?php if($edit){ echo esc_textarea($workflow_info->description);}elseif(isset($_POST['workflow_description'])){ echo esc_textarea($_POST['workflow_description']); } ?></textarea>
															</div>		
														</div>		
														<div class="form-group">		
															<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="permission_type"><?php esc_html_e('Workflow Permissions','lawyer_mgt');?></label>
															<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
															<select class="form-control" name="permission_type" id="workflow_permission_type">				
																	 <?php if($edit)
																	$permission_type =$workflow_info->permission;					
																else 
																	 $permission_type = ""; 
																 ?>
																<option value="Private" <?php if($permission_type == 'Private') echo 'selected = "selected"';?>><?php esc_html_e('This is my private workflow','lawyer_mgt');?></option>
																<option value="Public" <?php  if($permission_type == 'Public') echo 'selected = "selected"';  ?>><?php esc_html_e('Share this workflow with all users','lawyer_mgt');?></option>	
															</select>
															</div>
														</div>
														<?php
													 	if($user_role == 'attorney')
														{
															$attorney_id=get_current_user_id();	 	
															
															?>
															<input type="hidden" name="assginedto" value="<?php echo esc_attr($attorney_id);?>">
															<?php
														 }
														else
														{ ?>	
															<div class="form-group">	
																<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="assginedto"><?php esc_html_e('Assigned To Attorney','lawyer_mgt');?><span class="require-field">*</span></label>													
																<div class="col-sm-4">			
																	<select class="form-control case_assgined_to validate[required]" name="assginedto" id="assginedto">
																	<option value=""><?php esc_html_e('Select Attorney Name');?></option>
																	<?php 
																	$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));	
																	 $attorney_id=$obj_workflow->MJ_lawmgt_get_attorney_by_case($case_id);
																	$assginedto=explode(',',$attorney_id);
																	if(!empty($assginedto))
																	{
																		foreach ($assginedto as $retrive_data)
																		{ 		 	
																			$user_info = get_userdata($retrive_data);		
																			?>
																			<option value="<?php echo esc_attr($user_info->ID);?>"><?php echo esc_html($user_info->display_name); ?> </option>
																			<?php
																		}
																	} 
																	?> 
																	</select>				
																</div>
															</div>		
															<?php
														}
														?>														
														<div class="header">	
															<h3 class="first_hed"><?php esc_html_e('Workflow Events','lawyer_mgt');?></h3>
															<hr>
														</div>
														<?php
														if($edit)
														{
															$result_event=$obj_workflow->MJ_lawmgt_get_single_workflow_events($workflow_id);		
															?>
															<div id="event_div">
															<?php
															if(!empty($result_event))
															{
																$value = 1;
																$e_name_array = array();
																foreach ($result_event as $retrive_data)
																{
																	$value--; 	
																	
																	$e_name_array[] = array(
																					  "e_class" => 'op'.$value,
																					  "subject" => $retrive_data->subject
																					  ); 
																					  
																	$event_name_array=json_encode($e_name_array);					  
																					  
																	?>					
																		<div class="form-group workflow_item">
																			<div class="form-group">
																				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="event_subject"><?php esc_html_e('Event Subject','lawyer_mgt');?><span class="require-field">*</span></label>
																				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
																					<input id="event_subject" opt_class="<?php echo 'op'.$value; ?>" class="form-control has-feedback-left validate[required] text-input event_subject onlyletter_number_space_validation" maxlength="50" type="text" placeholder="<?php esc_html_e('Enter Event Subject','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($retrive_data->subject);}elseif(isset($_POST['event_subject'])) { echo esc_attr($_POST['event_subject']); } ?>" name="event_subject[]">
																					<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
																				</div>
																			</div>
																			<div class="form-group">
																				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="event_description"><?php esc_html_e('Event Description','lawyer_mgt');?></label>
																				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
																					<textarea rows="2" class="width_100_per_resize_css"  name="event_description[]" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" maxlength="150" id="event_description"><?php if($edit){ echo esc_textarea($retrive_data->description);}elseif(isset($_POST['event_description'])){ echo esc_textarea($_POST['event_description']); } ?></textarea>
																				</div>	
																			</div>	
																			<div class="form-group">
																				<div class="offset-lg-2 col-lg-2 offset-md-2 col-md-2 offset-sm-2 col-sm-2 col-xs-12">
																					<input type="button" value="<?php esc_html_e('Remove','lawyer_mgt') ?>" class="remove_event btn btn-danger" row="<?php echo $value; ?>">
																				</div>			
																			</div>			
																		</div>				
															<?php
																} 				
															}
															?>
															</div>
															<?php
														}
														else
														{	
															?>		  
															<div id="event_div">
																	
															</div>	
												 <?php  } ?>			
														<div class="offset-lg-2 col-lg-10 offset-md-2 col-md-10 offset-sm-2 col-sm-10 col-xs-12">
															<input type="button" value="<?php esc_html_e('Add More Event','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_event()" class="add_event btn btn-success">
														</div>			
														<div class="header">	
															<h3 class="first_hed"><?php esc_html_e('Workflow Tasks','lawyer_mgt');?></h3>
															<hr>
														</div>
														<?php
														if($edit)
														{
															$result_task=$obj_workflow->MJ_lawmgt_get_single_workflow_tasks($workflow_id);		
																	
															?>
																<div id="task_div">
															<?php
															if(!empty($result_task))
															{
																$value = 1;
																foreach ($result_task as $retrive_data)
																{ 
																	$value--; 		
															  ?>
																	<div class="form-group workflow_item">
																		<div class="form-group">
																			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="task_subject"><?php esc_html_e('Task Subject','lawyer_mgt');?><span class="require-field">*</span></label>
																			<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
																				<input id="task_subject" class="form-control has-feedback-left validate[required] text-input onlyletter_number_space_validation" maxlength="50" type="text" placeholder="<?php esc_html_e('Enter Task Subject','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($retrive_data->subject);}elseif(isset($_POST['task_subject'])) {echo esc_attr($_POST['task_subject']); } ?>" name="task_subject[]">
																				<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
																			</div>
																		</div>
																		<div class="form-group">
																			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="task_description"><?php esc_html_e('Task Description','lawyer_mgt');?></label>
																			<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
																				<textarea rows="2" class="width_100_per_resize_css" name="task_description[]" maxlength="150" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" id="task_description"><?php if($edit){ echo esc_textarea($retrive_data->description);}elseif(isset($_POST['task_description'])) { echo esc_textarea($_POST['task_description']);
																				} ?></textarea>
																			</div>	
																		</div>
																		<?php
																			$due_date=$retrive_data->due_date;
																			$data=json_decode( $due_date);
																		?>
																		<div class="form-group">
																		<label class="col-lg-3 col-md-3 col-sm-2 col-xs-12 control-label " for="due_date_type"><?php esc_html_e('Due DateDue Date','lawyer_mgt');?></label>						
																		<div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
																			<select class="form-control due_date_type<?php echo $value; ?>" name="due_date_type[]" id="due_date_type" row="<?php echo $value; ?>">
																			 <?php if($edit)
																					$due_date_type =$data->due_date_type;					
																				else 
																					 $due_date_type = ""; 
																				?>
																				<option value="automatically" <?php if($due_date_type == 'automatically') echo 'selected = "selected"';?>><?php esc_html_e('Automatically','lawyer_mgt');?></option>
																				<option value="no_due_date" <?php if($due_date_type == 'no_due_date') echo 'selected = "selected"';?>><?php esc_html_e('No due date','lawyer_mgt');?></option>										
																			</select>
																		</div>
																		<?php 
																		if($data->due_date_type == 'automatically')
																		{
																		?>
																			<div class="date_time_by_event  date_time_by_event<?php echo $value; ?> col-md-8" row="<?php echo $value; ?>" >	
																											
																					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																						<input class="form-control validate[required] text-input" type="number" placeholder="<?php esc_html_e('Enter Days','lawyer_mgt');?>" value="<?php if($edit){ echo $data->days;}elseif(isset($_POST['days'])){ echo esc_attr($_POST['days']); } ?>" name="days[]">
																					</div>
																					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																						<select class="form-control" name="day_formate[]" id="days">	

																							<option value="days" selected><?php esc_html_e('Days','lawyer_mgt');?></option>
																						</select>
																					</div>
																					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																						<select class="form-control" name="day_type[]" id="days">	
																						 <?php if($edit)
																							$day_type =$data->day_type;					
																							else 
																							$day_type = ""; 
																						?>
																							<option value="before" <?php if($day_type == 'before') echo 'selected = "selected"';?>><?php esc_html_e('Before','lawyer_mgt');?></option>
																							<option value="after" <?php if($day_type == 'after') echo 'selected = "selected"';?> ><?php esc_html_e('After','lawyer_mgt');?></option>
																						</select>
																					</div>
																					<div class="col-sm-2">
																						<select class="form-control validate[required] task_event_name task_event_name<?php echo $value; ?>" name="task_event_name[]" id="task_event_name">
																						<?php 
																						 if($edit)
																							$task_event_name =$data->task_event_name;				
																						else 
																							$task_event_name = "";		
																						
																						$event_data = json_decode($event_name_array);
																						if(!empty($event_data))
																						{
																		
																								foreach ($event_data as $retrive_data)
																								{ 	
																							?>
																								<option class="<?php echo $retrive_data->e_class;?>" value="<?php echo esc_attr($retrive_data->subject);?>" <?php selected($task_event_name,$retrive_data->subject);  ?>><?php echo esc_html($retrive_data->subject); ?> </option>
																							<?php }
																						} 
																						?> 										
																						</select>
																					</div>
																			</div>
																		<?php
																		}
																		else
																		{ ?>
																			<div class="date_time_by_event date_time_by_event_css  date_time_by_event<?php echo $value; ?> col-md-8" row="<?php echo $value; ?>" >	
																											
																					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																						<input class="form-control validate[required] text-input" type="number" placeholder="<?php esc_html_e('Enter Days','lawyer_mgt');?>" value="1" name="days[]">
																					</div>
																					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																						<select class="form-control" name="day_formate[]" id="days">	

																							<option value="days" selected><?php esc_html_e('Days','lawyer_mgt');?></option>
																						</select>
																					</div>
																					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
																						<select class="form-control" name="day_type[]" id="days">	
																						
																							<option value="before" selected><?php esc_html_e('Before','lawyer_mgt');?></option>
																							<option value="after" ><?php esc_html_e('After','lawyer_mgt');?></option>
																						</select>
																					</div>
																					<div class="col-sm-2">
																						<select class="form-control validate[required] task_event_name task_event_name<?php echo $value; ?>" name="task_event_name[]" id="task_event_name">
																						<?php 
																						$event_data = json_decode($event_name_array);
																						if(!empty($event_data))
																						{
																		
																								foreach ($event_data as $retrive_data)
																								{ 				 	
																								
																							?>
																								<option class="<?php echo $retrive_data->e_class;?>" value="<?php echo esc_attr($retrive_data->subject);?>" ><?php echo esc_html($retrive_data->subject); ?> </option>
																							<?php }
																						} 							
																						?>																
																						</select>
																					</div>
																			</div>
																		<?php 
																		}	
																		?>
																	</div>
																		<div class="form-group">
																			<div class="offset-lg-2 col-lg-2 offset-md-2 col-md-2 offset-sm-2 col-sm-2 col-xs-12">
																				<input type="button" value="<?php esc_html_e('Remove','lawyer_mgt') ?>" onclick="MJ_lawmgt_deleteParentElement_task(this)" class="remove_task btn btn-danger">
																			</div>			
																		</div>		
																	</div>		
															<?php
																} 				
															}
															?>
															</div>
														<?php
														}
														else
														{	
														?>		  
															<div id="task_div">
																
															</div> 
													<?php
														}
													?>			
														<div class="offset-lg-2 col-lg-2 offset-md-2 col-md-2 offset-sm-2 col-sm-2 col-xs-12">
															<input type="button" value="<?php esc_attr_e('Add More Task','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_task()" class="add_task btn btn-success">
														</div>			
														<div class="offset-sm-2 col-sm-8">
															<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Add Workflow','lawyer_mgt');}?>" name="save_workflow" class="btn btn-success"/>
														</div>
														</form>
														</div>	  
													  </div>	  
													</div>	  
												</div>	
										<?php
										}	
										if($active_tab=='view_applyworkflow')
										{	 
											$obj_workflow=new MJ_lawmgt_workflow;
											$obj_caseworkflow=new MJ_lawmgt_caseworkflow;
											$workflow_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['workflow_id']));
											$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
											$workflow_info = $obj_workflow->MJ_lawmgt_get_single_workflow($workflow_id);
																		
											if($active_tab == 'view_applyworkflow')
											{        	
											?>		
												<div class="panel-body">
													<form name="workflow_Details_form" action="" method="post" class="form-horizontal"  enctype='multipart/form-data'>   
														<div class="header">	
															<h3 class="first_hed"><?php esc_html_e('Workflow Information','lawyer_mgt');?></h3>
															<hr>
														</div>	
														<div class="">	
															<?php $workflow_name=MJ_lawmgt_get_workflow_name($workflow_id);?>		
															<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 workflow_info_div">	
																	<div class="table_row">
																		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																			<?php esc_html_e('Workflow Name','lawyer_mgt'); ?>
																		</div>
																		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																			<span class="txt_color">
																			<?php
																				 echo esc_html($workflow_name);
																				?>
																			</span>
																		</div>
																	</div>
																	 
															</div>
														</div>		
														<div class="header">	
															<h3 class="first_hed"><?php esc_html_e('Workflow Events','lawyer_mgt');?></h3>
															<hr>
														</div>																
														<?php
														$workflow_allevents=$obj_caseworkflow->MJ_lawmgt_get_single_applyworkflow_allevents_by_caseid($workflow_id,$case_id);
														?>
														<div id="event_div">
														<?php
														if(!empty($workflow_allevents))
														{
															foreach ($workflow_allevents as $retrive_data)
															{
															?>
																<div class="">		
																	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 workflow_info_div">	
																			<div class="table_row">
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																					<?php esc_html_e('Event Subject','lawyer_mgt'); ?>
																				</div>
																				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																					<span class="txt_color">
																					<?php
																						 echo esc_html($retrive_data->subject);
																						?>
																					</span>
																				</div>
																			</div>
																			<div class="table_row">
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																					<?php esc_html_e('Event Date','lawyer_mgt'); ?>
																				</div>
																				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																					<span class="txt_color">
																					<?php
																						 echo esc_html(MJ_lawmgt_getdate_in_input_box($retrive_data->event_date));
																						?>
																					</span>
																				</div>
																			</div>
																			<?php
																			$attendees_name=array();
																			$attendees=explode(",",$retrive_data->attendees);	
																			
																			if(!empty($attendees))
																			{
																				foreach ($attendees as $attendees_data)
																				{ 
																					$attendees_name[]=MJ_lawmgt_get_display_name($attendees_data);
																				}
																			}	
																			?>
																			<div class="table_row">
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																					<?php esc_html_e('Attendees','lawyer_mgt'); ?>
																				</div>
																				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																					<span class="txt_color">
																					<?php
																						  echo esc_html(implode(",",$attendees_name));
																						?>
																					</span>
																				</div>
																			</div>
																			 
																	</div>
																</div>
															<?php
															}
														}
														?>
														</div>
														 <div class="header">	
															<h3 class="first_hed"><?php esc_html_e('Workflow Tasks','lawyer_mgt');?></h3>
															<hr>
														</div>	
														<?php
														$workflow_alltasks=$obj_caseworkflow->MJ_lawmgt_get_single_applyworkflow_alltasks_by_caseid($workflow_id,$case_id);	
														?>
														<div id="task_div">
														<?php
														if(!empty($workflow_alltasks))
														{
															foreach ($workflow_alltasks as $retrive_data)
															{
															?>
																<div class="">		
																	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 workflow_info_div">	
																			<div class="table_row">
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																					<?php esc_html_e('Task Subject','lawyer_mgt'); ?>
																				</div>
																				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																					<span class="txt_color">
																					<?php
																						 echo esc_html($retrive_data->subject);
																						?>
																					</span>
																				</div>
																			</div>
																			 
																			<?php
																				$due_date=$retrive_data->due_date;
																				$data=json_decode( $due_date);
																			?>
																			<div class="table_row">
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																					<?php esc_html_e('Due Date','lawyer_mgt'); ?>
																				</div>
																				<?php 
																				if($data->due_date_type == 'automatically')
																				{
																				?>
																					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																						<span class="txt_color">
																						<?php
																							 echo  esc_html($data->days." ".$data->day_formate." ".$data->day_type." ".$data->task_event_name);
																							?>
																						</span>
																					</div>
																					<?php
																				}
																				else
																				{
																				?>
																				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																						<span class="txt_color">
																						<?php esc_html_e('No Due Date','lawyer_mgt');?>
																						</span>
																				</div>
																				  <?php
																				}	
																				?>	
																			</div>
																			<?php
																				$assign_to_name=array();
																				$assign_to=explode(",",$retrive_data->assign_to);	
																				
																				if(!empty($assign_to))
																				{
																					foreach ($assign_to as $assign_to_data)
																					{ 
																						$assign_to_name[]=MJ_lawmgt_get_display_name($assign_to_data);
																					}
																				}	
																				?>
																			<div class="table_row">
																				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
																					<?php esc_html_e('Attendees','lawyer_mgt'); ?>
																				</div>
																				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
																					<span class="txt_color">
																					<?php
																						 echo esc_html(implode(",",$assign_to_name));
																						?>
																					</span>
																				</div>
																			</div>
																			 
																	</div>
																</div>	
															<?php
															}
														}
														?>
														</div>
													</form>
												</div>												
											 <?php 
											}	
										}	
										if($active_tab=='workflow_list')
										{												
										?>      
											<script type="text/javascript">
												jQuery(document).ready(function($)
												{
													 "use strict"; 
													jQuery('#workflow_list').DataTable({
														"responsive": true,
														"autoWidth": false,
														"order": [[ 1, "asc" ]],
														language:<?php echo wpnc_datatable_multi_language();?>,
														 "aoColumns":[								 
																	  {"bSortable": false},		 							 
																	  {"bSortable": true},		 							 
																	  {"bSortable": false}
																   ]		               		
														});	
														$(".delete_check").on('click', function()
														{	
															if ($('.sub_chk:checked').length == 0 )
														{
															alert("<?php esc_html_e('Please select atleast one record','lawyer_mgt');?>");
															return false;
														}
														else{
															alert("<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>");
															return true;
															}
													});
												} );
												 
												jQuery(document).ready(function($)
												{		
													"use strict"; 
													jQuery('#select_all').on('click', function(e)
													{
														 if($(this).is(':checked',true))  
														 {
															$(".sub_chk").prop('checked', true);  
														 }  
														 else  
														 {  
															$(".sub_chk").prop('checked',false);  
														 } 
													});
													$("body").on("change", ".sub_chk", function()
													{ 
														if(false == $(this).prop("checked"))
														{ 
															$("#select_all").prop('checked', false); 
														}
														if ($('.sub_chk:checked').length == $('.sub_chk').length )
														{
															$("#select_all").prop('checked', true);
														}
													});
												});	
											</script>
											<form name="wcwm_report" action="" method="post">
												<div class="panel-body">
													<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">
														<table id="workflow_list" class="table table-striped table-bordered">
															<thead>					
																<tr>
																	<th><input type="checkbox" id="select_all"></th>
																	<th><?php  esc_html_e('Workflow Name', 'lawyer_mgt' ) ;?></th>
																	<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
																</tr>				
															</thead>
															<tbody>
																<?php	
																$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));					
																$workflowdata=$obj_caseworkflow->MJ_lawmgt_get_all_applyworkflow_by_caseid($case_id); 
																if(!empty($workflowdata))
																{					   
																	foreach ($workflowdata as $retrieved_data)
																	{			
																		$workflow_name=MJ_lawmgt_get_workflow_name($retrieved_data->workflow_id);
																	?>
																	<tr>
																		<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo $retrieved_data->workflow_id; ?>"></td>
																		
																		<td class="added"><?php echo esc_html($workflow_name);?></td>
																		
																		<td class="action"> 
																			<a href="?dashboard=user&page=cases&tab=casedetails&action=view&view=true&tab2=workflow&tab3=view_applyworkflow&workflow_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->workflow_id));?>&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>							
																			<?php
																			if($user_access_workflow['edit']=='1')
																			{
																				?>
																				<a href="?dashboard=user&page=cases&tab=casedetails&action=view&edit=true&tab2=workflow&tab3=applyworkflow&workflow_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->workflow_id))?>&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>" id="ediit" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>				
																			<?php
																			}
																			if($user_access_workflow['delete']=='1')
																			{
																				?>				
																				<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=workflow&tab3=workflow_list&deleteworkflow=true&workflow_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->workflow_id));?>&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>" class="btn btn-danger" 
																				onclick="return confirm('<?php esc_html_e('Are you sure you want to Delete this workflow ?','lawyer_mgt');?>');">
																				  <?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>					
																			  <?php
																			}
																			?>
																		  </td>               
																	</tr>
															<?php } 			
																} ?>     
															</tbody> 
														</table>
														<?php
														if($user_access_workflow['delete']=='1')
														{
															if(!empty($workflowdata))
																{
														?>
															<div class="form-group">		
																<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
																	<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="workflow_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
																</div>
															</div>
													 <?php
																}	
														}
														?>
													</div>
												</div>								   
											</form>
											 <?php 
										}
									}										
					}
					
					if($active_tab == 'caseexport')
					{
						if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
						{
							//wp_redirect ( home_url() . '?dashboard=user');
							$redirect_url=home_url() . '?dashboard=user';
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
					?>
						<div class="panel-body"><!-- PANEL BODY DIV -->
						<form name="upload_form" action="" method="post" class="form-horizontal" id="upload_form" enctype="multipart/form-data">
							<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
							<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
							<input type="hidden" name="role" value="<?php echo esc_attr($role);?>"  />				
							<div class="col-sm-12">        	
								<input type="submit" class="btn delete_margin_bottom btn-primary" name="case_excle" value="<?php esc_attr_e('Excel', 'lawyer_mgt' ) ;?> " />											
								<input type="submit" class="btn delete_margin_bottom btn-primary" name="case_csv" value="<?php esc_attr_e('CSV', 'lawyer_mgt' ) ;?> " />
								<input type="submit" class="btn delete_margin_bottom btn-primary" name="case_pdf" value="<?php esc_attr_e('PDF', 'lawyer_mgt' ) ;?> " />
							</div>		
						</form>
						</div><!--END  PANEL BODY DIV -->
					<?php	
					}
					?>														
							</div>									
						</div>							
					</div>
				</div>
			</div>
	</div><!-- END MAIN WRAPER DIV  -->
</div><!-- END PAGE INNER DIV -->