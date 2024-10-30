<?php 
$obj_case=new MJ_lawmgt_case;
$obj_documents=new MJ_lawmgt_documents;
$obj_next_hearing_date= new MJ_lawmgt_Orders;
$obj_case_tast= new MJ_lawmgt_case_tast;
$custom_field = new MJ_lawmgt_custome_field;
$note=new MJ_lawmgt_Note;
$event=new MJ_lawmgt_Event;
$obj_invoice=new MJ_lawmgt_invoice;
$obj_caseworkflow=new MJ_lawmgt_caseworkflow;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'caselist');
$result=null;
$page_columns_array=explode(',',get_option( 'lmgt_case_columns_option' ));
$page_export_array=explode(',',get_option( 'lmgt_case_export_option' ));
$document_columns_array=explode(',',get_option('lmgt_document_columns_option'));
$document_export_array=explode(',',get_option('document_export_option'));
?>
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV --> 
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' )); ?></h3>
	  </div>
	</div>
	<?php
	//-----------  CASE EXCLE -------------//
	if(isset($_POST['case_excle']))
	{		
		$casedata=$obj_case->MJ_lawmgt_get_all_case();
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
			
			foreach($casedata as $retrive_data)
			{
				$case_id= esc_attr($retrive_data->id);
				$case_contact=array();
				global $wpdb;
				$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';

				$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
				foreach ($result_link_contact as $key => $object)
				{			
					 $result=get_userdata($object->user_id);
					 $case_contact[]= esc_attr($result->display_name);
				}																
			    $link_contact=implode(',',$case_contact);
				
				$row = array();	
				$user=explode(",",$retrive_data->case_assgined_to);
				$attorney_name=array();
				if(!empty($user))
				{						
					foreach($user as $data4)
					{
						$attorney_name[]=esc_html(MJ_lawmgt_get_display_name($data4));
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
					$row[] =  esc_html(implode(", ",$attorney_name));
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
							$hearing_dates[]=$data->next_hearing_date;
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
				if(in_array('opponent_details',$page_export_array))
				{  
					$row[] =  implode(',',$opponents_array);
				}
				$opponents_attorney_details=json_decode($retrive_data->opponents_attorney_details);
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
				if(in_array('opponent_attorney_details',$page_export_array)) 
				{ 
					$row[] =  esc_html(implode(',',$opponents_attorney_array));
				}
				 
				fputcsv($fh, $row, "\t");
			}
			fclose($fh);

			//download csv file.
			$file=LAWMS_PLUGIN_DIR.'/admin/Reports/export_case.xls';//file location
			header('Content-Type:application/force-download');
			header('Pragma: public');       // required
			header('Expires: 0');           // no cache
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file)).' GMT');
			header('Cache-Control: private',false);
			 header("Content-Type: application/vnd.ms-excel");
			header('Content-Disposition: attachment; filename="'.basename($file).'"');
			header('Content-Transfer-Encoding: binary');
			header('Connection: close');
			readfile($file);		
			exit;			
		}
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">�</span>
					</button>
					<?php esc_html_e('Records not found.','lawyer_mgt');?>
				</div>
			<?php		
		}		
	} 
	//-----------  CASE CSV -------------//
	if(isset($_POST['case_csv']))
	{		
		$casedata=$obj_case->MJ_lawmgt_get_all_case();
		
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
				$case_id= esc_attr($retrive_data->id);
														
				$case_contact=array();
				global $wpdb;
				$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';

				$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
				foreach ($result_link_contact as $key => $object)
				{			
					 $result=get_userdata($object->user_id);
					 $case_contact[]=$result->display_name;
				}																
			    $link_contact=implode(',',$case_contact);
				
				$row = array();					
				$user=explode(",",$retrive_data->case_assgined_to);
				$attorney_name=array();
				if(!empty($user))
				{						
					foreach($user as $data4)
					{
						$attorney_name[]=MJ_lawmgt_get_display_name($data4);
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
					$row[] =  esc_html(implode(", ",$attorney_name)); 
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
							$hearing_dates[]=$data->next_hearing_date;
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
					$row[] =  $link_contact;
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
				if(in_array('opponent_details',$page_export_array))
				{  
					$row[] =  implode(',',$opponents_array);
				}
				$opponents_attorney_details=json_decode($retrive_data->opponents_attorney_details);
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
			header('Connection: close');
			readfile($file);		
			exit;			
		}			
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">�</span>
					</button>
					<?php esc_html_e('Records not found.','lawyer_mgt');?>
				</div>
		<?php		
		}		
	}
//-----------  CASE PDF -------------//	
	if(isset($_POST['case_pdf']))
	{		
		$casedata=$obj_case->MJ_lawmgt_get_all_case();
		
		if(!empty($casedata))
		{
			wp_enqueue_style( 'bootstrap-css', plugins_url( '/assets/css/bootstrap.css', __FILE__) );
			wp_enqueue_script('bootstrap-js', plugins_url( '/assets/js/bootstrap.js', __FILE__ ) );
			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="invoice.pdf"');
			header('Content-Transfer-Encoding: binary');
			header('Accept-Ranges: bytes');	
			require LAWMS_PLUGIN_DIR. '/lib/mpdf/mpdf.php';	
			$stylesheet=wp_enqueue_style( 'bootstrap-css', plugins_url( '/assets/css/style.css', __FILE__) );
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
							$case_id= esc_attr($retrive_data->id);
														
							$case_contact=array();
							global $wpdb;
							$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';

							$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
							foreach ($result_link_contact as $key => $object)
							{			
								 $result=get_userdata($object->user_id);
								 $case_contact[]=$result->display_name;
							}																
							$link_contact=implode(',',$case_contact);
						
							$user=explode(",",$retrive_data->case_assgined_to);
							$attorney_name=array();
							if(!empty($user))
							{						
								foreach($user as $data4)
								{
									$attorney_name[]=MJ_lawmgt_get_display_name($data4);
								}
							}	
							$opponents_details_array=json_decode($retrive_data->opponents_details);
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
							
							
							$opponents_attorney_details=json_decode($retrive_data->opponents_attorney_details);
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
									$mpdf->WriteHTML('<td class="align_center table_td_font width_15_per_css">'.esc_html(implode(", ",$attorney_name)).'</td>');
								}
								if(in_array('open_date',$page_export_array))
								{
									$mpdf->WriteHTML('<td class="align_center table_td_font width_10_per_css">'.esc_html($retrive_data->open_date).'</td>');
								}
								if(in_array('practice_area',$page_export_array))
								{  
									$mpdf->WriteHTML('<td class="align_center table_td_font width_15_per_css">'.esc_html(get_the_title(esc_html($retrive_data->practice_area_id))).'</td>');
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
											$hearing_dates[]=$data->next_hearing_date;
										}					
										$hearing_dates_value =  implode(',',$hearing_dates);
									}
									else
									{
										$hearing_dates_value = '';
									}				
									
								if(in_array('court_details',$page_export_array)) 
								{  
									$mpdf->WriteHTML('<td class="align_center table_td_font width_10_per_css">'.esc_html(get_the_title(esc_html($retrive_data->court_id))).'</td>');
								}
								if(in_array('court_hall_no',$page_export_array)) 
								{ 
									$mpdf->WriteHTML('<td class="align_center table_td_font width_10_per_css">'.esc_html($retrive_data->court_hall_no).'</td>');	
								}
								if(in_array('floor',$page_export_array)) 
								{  
									$mpdf->WriteHTML('<td class="align_center table_td_font">'.esc_html($retrive_data->floor).'</td>');	
								}
								if(in_array('court_details',$page_export_array)) 
								{  
									$mpdf->WriteHTML('<td class="align_center table_td_font width_10_per_css">'.esc_html(get_the_title(esc_html($retrive_data->state_id))).'</td>');
								}	
								if(in_array('court_details',$page_export_array)) 
								{ 								
									$mpdf->WriteHTML('<td class="align_center table_td_font width_15_per_css">'.esc_html(get_the_title(esc_html($retrive_data->bench_id))).'</td>');	
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
									$mpdf->WriteHTML('<td class="align_center table_td_font width_20_per_css">'.esc_html($retrive_data->earlier_history).'</td>');
								}
								if(in_array('classification',$page_export_array)) 
								{ 
									$mpdf->WriteHTML('<td class="align_center table_td_font width_20_per_css">'.esc_html($retrive_data->classification).'</td>');
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
									$mpdf->WriteHTML('<td class="align_center table_td_font width_20_per_css">'.MJ_lawmgt_get_display_name(esc_html($retrive_data->billing_contact_id)).'</td>');	
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
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">�</span>
					</button>
					<?php esc_html_e('Records not found.','lawyer_mgt');?>
				</div>
		<?php		
		}		
	}
	//-----------  SAVE WORKFLOW -------------//
	if(isset($_POST['save_workflow']))
	{	
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_case_work_nonce' ) )
		{ 
			if(isset($_REQUEST['edit'])&& sanitize_text_field($_REQUEST['edit'])=='true')
			{	
				$result=$obj_caseworkflow->MJ_lawmgt_add_caseworkflow(sanitize_text_field($_POST));
				$case_id=MJ_lawmgt_id_encrypt(sanitize_text_field($_REQUEST['case_id']));
				//wp_redirect ( admin_url() . 'admin.php?page=cases&tab=casedetails&action=view&tab2=workflow&tab3=workflow_list&message=18&case_id='.$case_id);
				$url= esc_urlesc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&tab2=workflow&tab3=workflow_list&message=18&case_id='.esc_attr($case_id));
				if (!headers_sent())
				{
					header('Location: '.esc_url($url));
				}
				else 
				{
					echo '<script type="text/javascript">';
					echo 'window.location.href="'.esc_url($url).'";';
					echo '</script>';
				}
		 
			}
			else
			{
				$result=$obj_caseworkflow->MJ_lawmgt_add_caseworkflow(sanitize_text_field($_POST));		
				$case_id=MJ_lawmgt_id_encrypt(sanitize_text_field($_REQUEST['case_id']));
				//wp_redirect ( admin_url() . 'admin.php?page=cases&tab=casedetails&action=view&tab2=workflow&tab3=workflow_list&message=17&case_id='.$case_id);
				$url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&tab2=workflow&tab3=workflow_list&message=17&case_id='.$case_id);
				if (!headers_sent())
				{
					header('Location: '.esc_url($url));
				}
				else 
				{
					echo '<script type="text/javascript">';
					echo 'window.location.href="'.esc_url($url).'";';
					echo '</script>';
				}
			}	
		}
	}
	if(isset($_POST['add_fee_payment']))
	{
		//POP up data save
		$result=$obj_invoice->MJ_lawmgt_add_feepayment($_POST);			
		if($result)
		{
			$case_id=MJ_lawmgt_id_encrypt(essanitize_text_fieldc_attr($_REQUEST['case_id']));
			//wp_redirect ( admin_url() . 'admin.php?page=cases&tab=casedetails&action=view&tab2=invoice&tab3=invoicelist&message=16&case_id='.$case_id);
		    $url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&tab2=invoice&tab3=invoicelist&message=16&case_id='.$case_id);
			if (!headers_sent())
			{
				header('Location: '.esc_url($url));
			}
			else 
			{
				echo '<script type="text/javascript">';
				echo 'window.location.href="'.esc_url($url).'";';
				echo '</script>';
			}
		}
	}	
	//----------- SAVE INVOICE -------------//
	if(isset($_POST['save_invoice']))
	{	
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_case_invoice_nonce' ) )
		{ 
			if(isset($_REQUEST['edit'])&& sanitize_text_field($_REQUEST['edit'])=='true')
			{	
				$result=$obj_invoice->MJ_lawmgt_add_invoice($_POST);
					
				if($result)
				{
					$case_id=sanitize_text_field($_REQUEST['case_id']);
					//wp_redirect ( admin_url() . 'admin.php?page=cases&tab=casedetails&action=view&tab2=invoice&tab3=invoicelist&message=14&case_id='.$case_id);
				    $redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&tab2=invoice&tab3=invoicelist&message=14&case_id='.$case_id);
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
					//wp_redirect ( admin_url() . 'admin.php?page=cases&tab=casedetails&action=view&tab2=invoice&tab3=invoicelist&message=13&case_id='.$case_id);
				    $redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&tab2=invoice&tab3=invoicelist&message=13&case_id='.$case_id);
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
	//-----------  SAVE DOCUMET -------------//
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
					 $upload_docs_array= sanitize_text_field($_REQUEST['old_hidden_cartificate']);
				 }		
				
				$result=$obj_documents->MJ_lawmgt_add_documents($_POST,$upload_docs_array);
			
				if($result)
				{
					$case_id=sanitize_text_field($_REQUEST['case_id']);
					//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=12&tab2=documents&tab3=documentslist&case_id='.$case_id);
					$redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=12&tab2=documents&tab3=documentslist&case_id='.$case_id);
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
					
					//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=10&tab2=documents&tab3=documentslist&case_id='.$case_id);
				    $redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=10&tab2=documents&tab3=documentslist&case_id='.$case_id);
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
	 //----------- SAVE TASK -------------//
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
						//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=20&tab2=task&tab3=tasklist&case_id='.$case_id);
						$redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=20&tab2=task&tab3=tasklist&case_id='.$case_id);
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
						//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=5&tab2=task&tab3=tasklist&case_id='.$case_id);
						$redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=5&tab2=task&tab3=tasklist&case_id='.$case_id);
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
	//----------- SAVE NOTES -------------//
	if(isset($_POST['savenote']))
	{	
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_case_note_nonce' ) )
		{ 
			if(isset($_REQUEST['editnote']) && sanitize_text_field($_REQUEST['editnote']) == 'true')
			{
				$result=$note->MJ_lawmgt_add_note($_POST);
				if($result)
				{
					$case_id=MJ_lawmgt_id_encrypt(sanitize_text_field($_REQUEST['case_id']));
					//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=21&tab2=note&tab3=notelist&case_id='.$case_id);
				    $redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=21&tab2=note&tab3=notelist&case_id='.$case_id);
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
					//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=6&tab2=note&tab3=notelist&case_id='.$case_id);
					$redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=6&tab2=note&tab3=notelist&case_id='.$case_id);
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
	//-----------SAVE EVENT -------------//
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
					//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=88&tab2=event&tab3=eventlist&case_id='.$case_id);
				    $redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=88&tab2=event&tab3=eventlist&case_id='.$case_id);
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
					//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=8&tab2=event&tab3=eventlist&case_id='.$case_id);
					$redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=8&tab2=event&tab3=eventlist&case_id='.$case_id);
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
	//----------- SAVE CASE-------------//
	if(isset($_POST['save_case']))
	{
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_cases_nonce' ) )
		{ 
			if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='edit')
			{	$_POST['custom']='';
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
						$case_number[]= esc_attr($retrive_data->case_number);
					}
				}	
				
				$case_number_diff=array_diff($case_number,$current_case_number);	
				
				if(in_array($_POST['case_number'],$case_number_diff))
				{
				?>
					<div class="alert_msg alert alert-danger alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">�</span>
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
					//wp_redirect ( admin_url() . 'admin.php?page=cases&tab=caselist&tab2=open&message=2');
				    $redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=caselist&tab2=open&message=2');
					
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
							$case_number[]= esc_attr($retrive_data->case_number);
						}
					}	
					if(in_array($_POST['case_number'],$case_number))
					{
					?>
						<div class="alert_msg alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">�</span>
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
					 
					//wp_redirect ( admin_url() . 'admin.php?page=cases&tab=caselist&tab2=open&message=1');
					$redirect_url = esc_url(admin_url().'admin.php?page=cases&tab=caselist&tab2=open&message=1');
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
	if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action']=='delete'))
	{
		$result=$obj_case->MJ_lawmgt_delete_case(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id'])));
		
		if($result)
		{
			//wp_redirect ( admin_url() . 'admin.php?page=cases&tab=caselist&tab2=open&message=3');
			$redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=caselist&tab2=open&message=3');
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
			//wp_redirect ( admin_url() . 'admin.php?page=cases&tab=caselist&tab2=close&message=25');
			$redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=caselist&tab2=close&message=25');
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
			$selected_id = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ) );
			$all = implode(",", $selected_id);			
			$result=$obj_case->MJ_lawmgt_delete_selected_case($all);	
		}
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">�</span>
					</button>
					<?php esc_html_e('Please Select At least One Record.','lawyer_mgt');?>
				</div>
		<?php		
		}	
		if($result)
		{
			//wp_redirect ( admin_url() . 'admin.php?page=cases&tab=caselist&tab2=open&message=3');
			$redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=caselist&tab2=open&message=3');
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
			//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=11&tab2=documents&tab3=documentslist&case_id='.$case_id);
		    $redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=11&tab2=documents&tab3=documentslist&case_id='.$case_id);
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
			$selected_id = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ) );
			$all = implode(",", $selected_id);			
			$result=$obj_documents->MJ_lawmgt_delete_selected_documents($all);	
		}
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">�</span>
					</button>
					<?php esc_html_e('Please Select At least One Record.','lawyer_mgt');?>
				</div>
		<?php		
		}	
		if($result)
		{
			 $case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=11&tab2=documents&tab3=documentslist&case_id='.$case_id);
			$redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=11&tab2=documents&tab3=documentslist&case_id='.$case_id);
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
	if(isset($_REQUEST['deletetask'])&& sanitize_text_field($_REQUEST['deletetask'])=='true')
	{				
		$result=$obj_case_tast->MJ_lawmgt_delete_tast(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['task_id'])));
		
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=4&tab2=task&tab3=tasklist&case_id='.$case_id);
		    $redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=4&tab2=task&tab3=tasklist&case_id='.$case_id);
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
			$selected_id = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ) );
			$all = implode(",", $selected_id);			
			$result=$obj_case_tast->MJ_lawmgt_delete_selected_task($all);	
		}
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">�</span>
					</button>
					<?php esc_html_e('Please Select At least One Record.','lawyer_mgt');?>
				</div>
		<?php		
		}	
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=4&tab2=task&tab3=tasklist&case_id='.$case_id);
		    $redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=4&tab2=task&tab3=tasklist&case_id='.$case_id);
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
	if(isset($_REQUEST['deletenote'])&& sanitize_text_field($_REQUEST['deletenote'])=='true')
	{
		
		$result=$note->MJ_lawmgt_delete_note(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['note_id'])));
		
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=7&tab2=note&tab3=notelist&case_id='.$case_id);
			$redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=7&tab2=note&tab3=notelist&case_id='.$case_id);
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
			$selected_id = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ) );
			$all = implode(",", $selected_id);			
			$result=$note->MJ_lawmgt_delete_selected_note($all);	
		}
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">�</span>
					</button>
					<?php esc_html_e('Please Select At least One Record.','lawyer_mgt');?>
				</div>
		<?php		
		}	
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=7&tab2=note&tab3=notelist&case_id='.$case_id);
		    $redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=7&tab2=note&tab3=notelist&case_id='.$case_id);
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
 	
	if(isset($_REQUEST['deleteevent'])&& sanitize_text_field($_REQUEST['deleteevent'])=='true')
	{
		$result=$event->MJ_lawmgt_get_signle_event_Delete_by_id(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id'])));
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=9&tab2=event&tab3=eventlist&case_id='.$case_id);
		    $redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=9&tab2=event&tab3=eventlist&case_id='.$case_id);
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
			$selected_id = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ) );
			$all = implode(",", $selected_id);			
			$result=$event->MJ_lawmgt_delete_selected_event($all);	
		}
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">�</span>
					</button>
					<?php esc_html_e('Please Select At least One Record.','lawyer_mgt');?>
				</div>
		<?php		
		}	
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=9&tab2=event&tab3=eventlist&case_id='.$case_id);
		    $redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=9&tab2=event&tab3=eventlist&case_id='.$case_id);
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
			//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=15&tab2=invoice&tab3=invoicelist&case_id='.$case_id);
		    $redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=15&tab2=invoice&tab3=invoicelist&case_id='.$case_id);
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
			$selected_id = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ) );
			$all = implode(",", $selected_id);			
			$result=$obj_invoice->MJ_lawmgt_delete_selected_invoice($all);	
		}
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">�</span>
					</button>
					<?php esc_html_e('Please Select At least One Record.','lawyer_mgt');?>
				</div>
		<?php		
		}	
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=15&tab2=invoice&tab3=invoicelist&case_id='.$case_id);
		    $redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=15&tab2=invoice&tab3=invoicelist&case_id='.$case_id);
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
			//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=19&tab2=workflow&tab3=workflow_list&case_id='.$case_id);
			$redirect_url=admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=19&tab2=workflow&tab3=workflow_list&case_id='.$case_id;
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
			$selected_id = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ) );
			$all = implode(",", $selected_id);			
			$result=$obj_caseworkflow->MJ_lawmgt_delete_selected_workflow($all);	
		}
		if($result)
		{
			$case_id=sanitize_text_field($_REQUEST['case_id']);
			//wp_redirect (admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=19&tab2=workflow&tab3=workflow_list&case_id='.$case_id);
		    $redirect_url= esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=19&tab2=workflow&tab3=workflow_list&case_id='.$case_id);
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
			$selected_id = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ) );
			$all = implode(",", $selected_id);	
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
					$case_id= esc_attr($retrive_data->case_id);
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
				
				header('Content-Type:application/force-download');
				header('Pragma: public');       // required
				header('Expires: 0');           // no cache
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file)).' GMT');
				header('Cache-Control: private',false);
				header("Content-Type: application/vnd.ms-excel");
				header('Content-Disposition: attachment; filename="'.basename($file).'"');
				header('Content-Transfer-Encoding: binary');
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
			$selected_id = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ) );
			$all = implode(",", $selected_id);	
			
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
					$case_id= esc_attr($retrive_data->case_id);
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
	if(isset($_POST['document_pdf_selected']))
	{
		if (isset($_POST["selected_id"]))
		{	
			$selected_id = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ) );
			$all = implode(",", $selected_id);	
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
								
								$status=$obj_documents->MJ_lawmgt_check_documents_status_by_user(esc_html($retrive_data->id));		
								
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
											$mpdf->WriteHTML('<td class="align_center table_td_fon width_10_per_css">'.esc_html($retrive_data->tag_names).'</td>');
										}
									if(in_array('status',$document_export_array))
										{
											$mpdf->WriteHTML('<td class="align_center table_td_font width_10_per_css">'.__(''.$status.'','lawyer_mgt').'</td>');
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
		$message = sanitize_text_field($_REQUEST['message']);
		if($message == 1)
		{?>	
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
				<?php esc_html_e('Case Inserted Successfully','lawyer_mgt');?>
				</div>
				<?php 
			
		}
		elseif($message == 2)
		{?>
				<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
					</button>
					<?php esc_html_e('Case Updated Successfully','lawyer_mgt');?>
				</div>
				<?php 			
		}
		elseif($message == 3) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Case Close Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 4) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Task Delete Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 5) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Task Inserted Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 6) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Note Inserted Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 7) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Delete Note Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 8) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Event Inserted Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 88) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Event Updated Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 9) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Delete Event Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 10) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Documents Inserted successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 11) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Documents deleted successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 12) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Documents Updated successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 13) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Invoice Inserted Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 14) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Invoice Updated successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 15) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Invoice Deleted successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 16) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Payment Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 17) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Apply Workflow Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}		
		elseif($message == 18) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Workflow  Updated Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}		
		elseif($message == 19) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Workflow Deleted Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
        elseif($message == 20) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Task Updated Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
        elseif($message == 21) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Note Updated Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}	
		elseif($message == 22) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Next Hearing Date Updated Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 23) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
                    </button>
             <?php esc_html_e('Next Hearing Date Inserted Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		elseif($message == 24) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
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
	<div id="main-wrapper"><!--  MAIN WRAPER  DIV -->
		<div class="row"><!--  ROW DIV -->
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white"><!-- PANEL WHITE  DIV -->
					<div class="panel-body"><!-- PANEL BODY  DIV -->
						<h2 class="nav-tab-wrapper">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="tablist">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'caselist' ? 'active' : ''; ?> menucss">
									<a href="?page=cases&tab=caselist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Case List', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_case' ? 'active' : ''; ?> menucss">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
								{?>
								<a href="?page=cases&tab=add_case&&action=edit&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
									<?php esc_html_e('Edit Case', 'lawyer_mgt'); ?>
								</a>  
								<?php 
								}
								else
								{?>
									<a href="?page=cases&tab=add_case&&action=add">
										<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Case', 'lawyer_mgt');?>
									</a>  
								<?php  
								}?>
								</li>
								<?php if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view'){?>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'casedetails' ? 'active' : ''; ?> menucss">
									<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
										<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('Case Details', 'lawyer_mgt'); ?>
									</a>
								</li>
								<?php } 
								
								if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
								{
									?>
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'caseexport' ? 'active' : ''; ?> menucss">
										<a href="?page=cases&tab=caseexport">
											<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Case Export', 'lawyer_mgt'); ?>
										</a>
									</li>
									<li role="presentation" class="<?php echo $active_tab == 'caseactivity' ? 'active' : ''; ?> menucss">
										<a href="?page=cases&tab=caseactivity">
											<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('Case Activity', 'lawyer_mgt'); ?>
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
							$active_tab = isset($_GET['tab2'])?esc_html($_GET['tab2']):'open';
							?>								
							<h2>
							<ul class="sub_menu_css line nav nav-tabs" id="myTab" role="tablist">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'open' ? 'active' : ''; ?> menucss">
									<a href="admin.php?page=cases&tab=caselist&tab2=open">
									<?php echo esc_html__('Open Cases', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'close' ? 'active' : ''; ?> menucss">
									<a href="admin.php?page=cases&tab=caselist&tab2=close">
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
										  /* responsive:true, */
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
								</script>
								<div class="panel-body">
									<form  action="" method="post" class="form-horizontal" enctype='multipart/form-data'>
									<input type="hidden" name="case_open" class="hidden_case_filter" value="open">
									<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label filter_lable_year"><?php esc_html_e('Filter By Year :','lawyer_mgt');?></label>
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
												 echo '<option value='.esc_attr($start_year).'>'.esc_html($start_year).'</option>';
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
												else
												{
													$casedata=$obj_case->MJ_lawmgt_get_open_all_case();
												}	
												if(!empty($casedata))
												{
													foreach ($casedata as $retrieved_data)
													{																
														$case_id= esc_attr($retrieved_data->id);
														
														$caselink_contact=array();
														global $wpdb;
														$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
								
														$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
														 foreach ($result_link_contact as $key => $object)
														 {			
															 $result=get_userdata($object->user_id);
															 $caselink_contact[]='<a href="?page=contacts&tab=viewcontact&action=view&contact_id='.MJ_lawmgt_id_encrypt(esc_attr($object->user_id)).'">'.esc_html($result->display_name).'</a>';
																				
														  }						
														  $caselink_contact_sanitize = array_map( 'sanitize_text_field', wp_unslash( $caselink_contact ) );										
														  $contact=implode(',',$caselink_contact_sanitize);														   
														  $attorney= esc_attr($retrieved_data->case_assgined_to);
															$attorney_name=explode(',',$attorney);
															$attorney_name1=array();
															foreach($attorney_name as $attorney_name2) 
															{
																$attorneydata=get_userdata($attorney_name2);	
																$attorney_name1[]='<a href="?page=attorney&tab=view_attorney&action=view&attorney_id='.MJ_lawmgt_id_encrypt(esc_attr($attorneydata->ID)).'">'.esc_html($attorneydata->display_name).'</a>';										   
															}
																	
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
												 
													?>
											<tr>
												<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->id); ?>"></td>
											<?php if(in_array('case_number',$page_columns_array)){ ?> 
												<td class="case_number"><?php echo esc_html($retrieved_data->case_number);?></td>
											<?php } ?>
											<?php if(in_array('case_name',$page_columns_array)){ ?> 	
												<td class="name"><a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>"><?php echo esc_html($retrieved_data->case_name);?></a></td>
											<?php } ?>
											<?php if(in_array('open_date',$page_columns_array)){ ?> 	
												<td class=""><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->open_date));?></td>
											<?php } ?>
										 
											<?php if(in_array('statute_of_limitation',$page_columns_array)){ ?>	 
												<td class=""><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->statute_of_limitations)); ?></td>
											<?php } ?>
											<?php if(in_array('priority',$page_columns_array)){ ?> 	
												<td class=""><?php echo esc_html($retrieved_data->priority);?></td>
											<?php } ?>
											<?php if(in_array('practice_area',$page_columns_array)){ ?>	
												<td class="prac_area"><?php echo esc_html(get_the_title(esc_html($retrieved_data->practice_area_id)));?></td>
											<?php } ?>
											<?php if(in_array('court_details',$page_columns_array)){ ?>	
												<td><?php echo esc_html(get_the_title($retrieved_data->court_id)); ?> - <?php echo esc_html(get_the_title($retrieved_data->state_id)); ?> - <?php echo esc_html(get_the_title($retrieved_data->bench_id)); ?></td>
											<?php } ?>
											<?php if(in_array('contact_link',$page_columns_array)){ ?>	
												<td class="contact_link"><?php echo $contact;?></td>
											<?php } ?>
											<?php if(in_array('billing_contact_name',$page_columns_array)){ ?>	
												<td><a href="?page=contacts&tab=viewcontact&action=view&contact_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->billing_contact_id));?>"><?php echo esc_html(MJ_lawmgt_get_display_name($retrieved_data->billing_contact_id));?></a></td>
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
											<?php if(in_array('hearing_date',$page_columns_array))
											{
												?>	
												<td>
													<?php
													$obj_next_hearing_date=new MJ_lawmgt_Orders;
													$next_hearing_date= $obj_next_hearing_date->MJ_lawmgt_get_next_hearing_date_asc_by_case_id($case_id);
													$hearing_date_array=array();
													foreach($next_hearing_date as $data)
													{
														$hearing_date_array[]=MJ_lawmgt_getdate_in_input_box($data->next_hearing_date);
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
														$increment  = 0;
														foreach($stages as $data)
														{ 
															$increment ++;
															echo $increment ;?>. <?php echo esc_html($data->value); 
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
												<td class=""><?php echo esc_html(implode(',',$opponents_attorney_array));?></td>
											<?php } ?>	
												<td class="action">
													 <a href="admin.php?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
													 <a href="?page=cases&tab=add_case&action=edit&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
													 <a href="?page=cases&tab=caselist&action=delete&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" 
														onclick="return confirm('<?php esc_html_e('Are you sure you want to Close this Case?','lawyer_mgt');?>');">
													  <?php esc_html_e('Close', 'lawyer_mgt' ) ;?> </a>
												</td>               
											</tr>
											<?php } 			
												} ?>     
										</tbody>  
									</table>
									<?php 
									if(!empty($casedata))
												{
									?>
									<div class="form-group">		
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
												<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="case_delete_selected" value="<?php esc_attr_e('Close', 'lawyer_mgt' ) ;?> " />
											</div>
									</div>
												<?php } ?>
								   </div>
								  </div>
								</form>	
							<?php	
							}
							if($active_tab == 'close')
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
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label filter_lable_year"><?php esc_html_e('Filter By Year :','lawyer_mgt');?></label>
										<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 case_year_close">
											<select class="form-control case_year_filter" name="case_year_status">
											<option value="all"><?php esc_html_e('All','lawyer_mgt');?></option>
												<?php 
												$start_year=get_option( 'lmgt_staring_year' );
												$current_year=date("Y");
												$a=$current_year-$start_year;
												$end_year=$start_year + $a;
												for ($start_year; $start_year <= $end_year; $start_year++) 
												{	
												 echo '<option value='.esc_attr($start_year).'>'.esc_html($start_year).'</option>';
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
											else
											{			
													
												$casedata=$obj_case->MJ_lawmgt_get_close_all_case();	
											}
											   
											if(!empty($casedata))
											{
												foreach ($casedata as $retrieved_data){

													$case_id= esc_attr($retrieved_data->id);
												
													$caselink_contact=array();
													global $wpdb;
													$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
							
													$result_link_contact= $wpdb->get_results("SELECT user_id FROM $table_case_contacts where case_id=".$case_id);
													foreach ($result_link_contact as $key => $object)
													{			
														 $result=get_userdata($object->user_id);
														 $caselink_contact[]='<a href="?page=contacts&tab=viewcontact&action=view&contact_id='.MJ_lawmgt_id_encrypt(esc_html($object->user_id)).'">'.$result->display_name.'</a>';
														
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
													$attorney=esc_attr($retrieved_data->case_assgined_to);
													$attorney_name=explode(',',$attorney);
													$attorney_name1=array();
													foreach($attorney_name as $attorney_name2) 
													{
														$attorneydata=get_userdata($attorney_name2);	
															
														$attorney_name1[]='<a href="?dashboard=user&page=attorney&tab=view_attorney&action=view&attorney_id='.MJ_lawmgt_id_encrypt(esc_attr($attorneydata->ID)).'">'.$attorneydata->display_name.'</a>';										   
													}
											?>
											<tr> 
												 <?php if(in_array('case_number',$page_columns_array)){ ?> 
												<td class="case_number"><?php echo esc_html($retrieved_data->case_number);?></td>
											<?php } ?>
											<?php if(in_array('case_name',$page_columns_array)){ ?> 	
												<td class="name"><a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>">
												<?php echo esc_html($retrieved_data->case_name);?></a></td>
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
												<td><?php echo esc_html(get_the_title($retrieved_data->court_id)); ?> - <?php echo esc_html(get_the_title($retrieved_data->state_id)); ?> - 
												<?php echo esc_html(get_the_title($retrieved_data->bench_id)); ?></td>
											<?php } ?>
											<?php if(in_array('contact_link',$page_columns_array)){ ?>	
												<td class="contact_link"><?php echo  $contact;?></td>
											<?php } ?>
											<?php if(in_array('billing_contact_name',$page_columns_array)){ ?>	
												<td><a href="?page=contacts&tab=viewcontact&action=view&contact_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->billing_contact_id));?>"><?php echo esc_html(MJ_lawmgt_get_display_name($retrieved_data->billing_contact_id));?></a></td>
											<?php } ?>
											<?php if(in_array('billing_type',$page_columns_array)){ ?>	
												<td class=""><?php echo esc_html($retrieved_data->billing_type);?></td>
											<?php } ?>
											<?php if(in_array('attorney_name',$page_columns_array)){ ?>	
												<td><?php echo implode(',',$attorney_name1);?></td>	
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
														$hearing_date_array[]=MJ_lawmgt_getdate_in_input_box($data->next_hearing_date);
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
														$increment  = 0;
														foreach($stages as $data)
														{ 
															$increment ++;
															 echo $increment ;?>.<?php echo  esc_html($data->value); ?>
															<?php
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
													<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>	
													 <a href="?page=cases&tab=caselist&action=reopen&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-success" 
														onclick="return confirm('<?php esc_html_e('Are you sure you want to ReOpen this Case?','lawyer_mgt');?>');">
													  <?php esc_html_e('Reopen', 'lawyer_mgt' ) ;?> </a>
												</td>			
											</tr>
										<?php } 			
											} ?>     
										</tbody>   
									
								</table>
							   </div>
							  </div>
							<?php		
							}
						}		
							if($active_tab == 'add_case')
							{
								require_once LAWMS_PLUGIN_DIR. '/admin/cases/add_case.php';
							}	 
							if($active_tab == 'casedetails')
							{
								require_once LAWMS_PLUGIN_DIR. '/admin/cases/case_details.php';
							}
							if($active_tab == 'caseexport')
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
								require_once LAWMS_PLUGIN_DIR. '/admin/cases/exportcase.php';
							}
							if($active_tab == 'caseactivity')
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
								require_once LAWMS_PLUGIN_DIR. '/admin/cases/case_activity.php';
							}
							?>
					</div><!-- PANEL BODY  DIV -->
				</div>	<!-- ENDPANEL WHITE  DIV -->
			</div>
		</div><!--  END ROW DIV   --> 
 	</div><!-- 	END MAIN WRAPER DIV   --> 
</div><!-- END  PAGE INNER DIV --> 	