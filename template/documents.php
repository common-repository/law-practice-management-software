<?php 	
MJ_lawmgt_browser_javascript_check();
if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
{
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
		if (esc_attr(isset ( $_REQUEST ['page'] ) && sanitize_text_field($_REQUEST ['page']) == $user_access['page_link'] && (sanitize_text_field($_REQUEST['action'])=='edit')))
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
$obj_documents=new MJ_lawmgt_documents;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'documentslist');
$result=null;
$document_columns_array=explode(',',get_option('lmgt_document_columns_option'));
$document_export_array=explode(',',get_option('document_export_option'));
?>
<div class="page_inner_front"> <!--  PAGE INNER DIV -->
	
	<?php 
	if(isset($_POST['save_documents']))
	{	
		$nonce =  sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_documents_nonce' ) )
		{ 
			$upload_docs_array=array();	
			if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='add')
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
			if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='edit')
			{	
				
				 if($_FILES['cartificate']['name'] != "" && $_FILES['cartificate']['size'] > 0)
				 {
					$upload_docs_array=MJ_lawmgt_load_documets($_FILES['cartificate'],$_FILES['cartificate'],'cartificate');			
				 }
				 else
				 {
					 $upload_docs_array=esc_url($_REQUEST['old_hidden_cartificate']);
				 }		
				
				$result=$obj_documents->MJ_lawmgt_add_documents($_POST,$upload_docs_array);
				if($result)
				{
					$redirect_url=home_url() . '?dashboard=user&page=documents&tab=documentslist&message=2';
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
					if($result)
					{
					$redirect_url=home_url() . '?dashboard=user&page=documents&tab=documentslist&message=1';
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
		$result=$obj_documents->MJ_lawmgt_delete_documets(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['documents_id'])));			
		if($result)
		{
			//wp_redirect ( home_url() . '?dashboard=user&page=documents&tab=documentslist&message=3');
			$redirect_url=home_url() . '?dashboard=user&page=documents&tab=documentslist&message=3';
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
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
					<?php esc_html_e('Please Select At least One Record.','lawyer_mgt');?>
				</div>
		<?php		
		}	
		if($result)
		{
			$redirect_url=home_url() . '?dashboard=user&page=documents&tab=documentslist&message=3';
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
				$file=LAWMS_PLUGIN_DIR.'/admin/Reports/export_documents.csv';//file location
				 
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
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
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
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
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
								$case_id=esc_attr($retrive_data->case_id);
																
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
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
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
				<?php esc_html_e('Documents Inserted Successfully','lawyer_mgt');?>
				</div>
				<?php 
			
		}
		elseif($message == 2)
		{?>
				<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
					<?php esc_html_e('Documents Updated Successfully','lawyer_mgt');?>
				</div>
				<?php 			
		}
		elseif($message == 3) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
             <?php esc_html_e('Documents Deleted Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
	} 		
	?>
	<div id="main-wrapper"><!-- MAIN WRAPER  DIV -->
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<h2 class="nav-tab-wrapper">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="tablist">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'documentslist' ? 'active' : ''; ?> menucss">
									<a href="?dashboard=user&page=documents&tab=documentslist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Documents List', 'lawyer_mgt'); ?>
									</a>
								</li>							
								 
									<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_documents' ? 'active' : ''; ?> menucss">
									<?php  
									if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
									{?>
									<a href="?dashboard=user&page=documents&tab=add_documents&&action=edit&documents_id=<?php echo esc_attr($_REQUEST['documents_id']);?>">
										<?php esc_html_e('Edit Documents', 'lawyer_mgt'); ?>
									</a>  
									<?php 
									}
									else
									{
										if($user_access['add']=='1')
										{	
											?>
											<a href="?dashboard=user&page=documents&tab=add_documents&&action=add">
												<?php echo '<span class="fa fa-plus-circle"></span> '.esc_html__('Add Documents', 'lawyer_mgt');?>
											</a>  
										<?php 
										} 
									}
									?>
									</li>
								 
							</ul>	
						</h2>
						<?php 
						if($active_tab == 'documentslist')  /*-- DOCUMENT LIST ACTIVE TAB */
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
									jQuery("body").on("change", ".sub_chk", function()
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
									<input type="hidden" name="hidden_case_id" class="hidden_case_id" value="">
									<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label filter_lable_doc1"><?php esc_html_e('Filter By Document Status :','lawyer_mgt');?></label>
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
												if($user_role == 'attorney')
												{
													if($user_access['own_data'] == '1')
													{
														$result=$obj_documents->MJ_lawmgt_get_all_documents_by_attorney();
													}
													else
													{
														$result=$obj_documents->MJ_lawmgt_get_all_documents();	
													}	
												}
												elseif($user_role == 'client')
												{
													if($user_access['own_data'] == '1')
													{
														$result=$obj_documents->MJ_lawmgt_get_all_documents_by_client();	
													}
													else
													{
														$result=$obj_documents->MJ_lawmgt_get_all_documents();	
													}
												}
												else
												{
													if($user_access['own_data'] == '1')
													{
														$result=$obj_documents->MJ_lawmgt_get_all_documents_created_by();	
													}
													else
													{
														$result=$obj_documents->MJ_lawmgt_get_all_documents();	
													}
												}
												if(!empty($result))
												{			
													foreach ($result as $retrieved_data)
													{																	
														$case_id=esc_attr($retrieved_data->case_id);
														
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
																<a target="blank" href="<?php print esc_url(content_url().'/uploads/document_upload/'.$retrieved_data->document_url); ?>" class="status_read btn btn-default" record_id="<?php echo esc_attr($retrieved_data->id);?>"><i class="fa fa-download"></i><?php esc_html_e(' Download', 'lawyer_mgt');?></a>				
																<?php
																if($user_access['edit']=='1')
																{
																	?>
																	<a href="?dashboard=user&page=documents&tab=add_documents&action=edit&&documents_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
																	<?php
																}
																if($user_access['delete']=='1')
																{
																	?>
																	<a href="?dashboard=user&page=documents&tab=documentslist&action=delete&&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($case_id));?>&documents_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" 
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
										if($user_access['delete']=='1')
										{
											if(!empty($result))
											{
												?>
												<div class="form-group">		
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
														<input type="submit" class="btn delete_margin_bottom delete_check btn-danger" name="document_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
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
						}   /*-- END DOCUMENT LIST ACTIVE TAB */
						if($active_tab == 'add_documents') /*-- ADD DOCUMENT ACTIVE TAB */
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
										$(this).replaceWith('<input type="file" name="cartificate[]" class="form-control file_validation input-file">');
										return false; 
									} 
									 //File Size Check 
									 if (file.size > 20480000) 
									 {
										alert("<?php esc_html_e('Too large file Size. Only file smaller than 10MB can be uploaded.','lawyer_mgt');?>");
										$(this).replaceWith('<input type="file" name="cartificate[]" class="form-control file_validation input-file">'); 
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
										
										$("#cartificate_div").append('<div id="cartificate_entry1" class="abc cartificate_entry" row="'+value+'"><input type="hidden" name="hidden_tags[]" value="" id="hidden_tags'+value+'" class="hidden_tags" row="'+value+'"><div class="form-group"><label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Title','lawyer_mgt');?><span class="require-field">*</span></label><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="text"  name="cartificate_name[]" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>" class="form-control validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause"  /></div><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><input type="file" name="cartificate[]" class="form-control margin_cause file_validation input-file validate[required]"></div><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="text" name="tag_name" id="tag_name'+value+'" class="form-control margin_cause tages_add ui-autocomplete-input validate[custom[onlyLetter_specialcharacter],maxSize[50]]"   row="'+value+'" placeholder="<?php esc_html_e('Enter New Tages','lawyer_mgt');?>" autocomplete="off" value=""></div><div id="suggesstion-box"></div><div class="col-lg-1 col-md-2 col-sm-2 col-xs-12"><button type="button" class="btn btn-success botton_submit_pulse addtages_documents" row="'+value+'" id="addtages_community"><?php esc_html_e('Add Tag','lawyer_mgt');?></button></div><div class="col-lg-2 col-md-1 col-sm-1 col-xs-12"><input type="button" value="<?php esc_html_e('Delete','lawyer_mgt');?>" onclick="MJ_lawmgt_deleteParentElement(this)" class="remove_cirtificate doc_label  btn btn-danger"></div></div><div class="list_tag_name'+value+' col-lg-offset-7 col-lg-5 col-md-offset-7 col-md-5 col-sm-offset-7 col-sm-5 col-xs-12" row="'+value+'"></div></div>');
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
							if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
							{					
								$edit=1;
								$document_result = $obj_documents->MJ_lawmgt_get_single_documents($documents_id);				
							}
							?>								
							<div class="panel-body"><!-- PANEL BODY DIV  -->
								<form name="documents_form" action="" method="post" class="form-horizontal" id="documents_form" enctype='multipart/form-data'>	
									<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
									<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
									<input type="hidden" name="documents_id" value="<?php echo esc_attr($documents_id);?>"  />
									<div class="header margin_document_to">	
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
									<?php wp_nonce_field( 'save_documents_nonce' ); ?>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Case Name','lawyer_mgt');?><span class="require-field">*</span></label>				
										<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">			
											<select class="form-control validate[required]" name="case_name" id="case_name">
												<option value=""><?php esc_html_e('Select Case Name','lawyer_mgt');?></option>
												<?php 
												 if($edit)
													$case_name =$document_result->case_id;				
												else 
													$case_name = "";
										
												$obj_case=new MJ_lawmgt_case;
												$user_case_access=MJ_lawmgt_get_userrole_wise_filter_access_right_array('cases');
												if($user_role == 'attorney')
												{
													if($user_case_access['own_data'] == '1')
													{
														$attorney_id = get_current_user_id();
														
														$result = $obj_case->MJ_lawmgt_get_open_case_by_attorney($attorney_id);	
													}
													else
													{
														$result = $obj_case->MJ_lawmgt_get_open_all_case();
													}		
												}
												else
												{
													if($user_case_access['own_data'] == '1')
													{
														$result = $obj_case->MJ_lawmgt_get_open_all_case_created_by();
													}
													else
													{
														$result = $obj_case->MJ_lawmgt_get_open_all_case();
													}
												}
												if(!empty($result))
												{
													foreach ($result as $retrive_data)
													{ 		 	
													?>
														<option value="<?php echo esc_attr($retrive_data->id);?>" <?php selected($case_name,$retrive_data->id);  ?>><?php echo esc_html($retrive_data->case_name); ?> </option>
													<?php }
												} 
												?> 
											</select>				
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
											<input type="hidden" name="hidden_tags[]" value="<?php echo implode(',',$div_tag_names);?>" id="hidden_tags1" row="1">
											<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Title','lawyer_mgt');?><span class="require-field">*</span></label>	
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<input type="text" name="cartificate_name" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>" class="form-control validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] margin_cause" value="<?php if($edit){ echo esc_attr($document_result->title);}elseif(isset($_POST['cartificate_name'])){ echo esc_attr($_POST['cartificate_name']); } ?>" />								
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Select File','lawyer_mgt');?><span class="require-field">*</span></label>							
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">					
													<input type="file" name="cartificate" class="form-control file_validation input-file"/>						
													<input type="hidden" name="old_hidden_cartificate" value="<?php if($edit){ echo esc_attr($document_result->document_url);}elseif(isset($_POST['cartificate'])){ echo esc_attr($_POST['cartificate']); } ?>">					
												</div>
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
													<a  target="blank" class="status_read btn btn-default" href="<?php print content_url().'/uploads/document_upload/'.$document_result->document_url; ?>" record_id="<?php echo $document_result->id;?>">
													<i class="fa fa-download"></i><?php echo $document_result->document_url;?></a>
												</div>
											</div>
											
											<div class="form-group">	
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Tags','lawyer_mgt');?></label>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">	      
													<input type="text" name="tag_name" id="tag_name1" class="form-control tages_add margin_cause ui-autocomplete-input validate[custom[onlyLetter_specialcharacter],maxSize[50]]" placeholder="<?php esc_html_e('Enter New Tages','lawyer_mgt');?>" autocomplete="off" value="" row="1">	
												</div>
												<div id="suggesstion-box"></div>
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
													<button type="button" class="btn btn-success botton_submit_pulse addtages_documents" id=""  row="1"><?php esc_html_e('Add Tag','lawyer_mgt') ?></button>
												</div>
											</div>
											<div class="form-group">	
												<div class="list_tag_name1 offset-lg-2 col-lg-4 offset-md-2 col-md-4 offset-sm-2 col-sm-4 col-xs-12" row="1">
											
													<?php				
													$tag_name=explode(",",$document_result->tag_names);
																																
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
												<input type="hidden" name="hidden_tags[]" value="" id="hidden_tags1" class="hidden_tags" row="1">
												<div class="form-group">
												<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_name"><?php esc_html_e('Title','lawyer_mgt');?><span class="require-field">*</span></label>		
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
													<input type="text"  name="cartificate_name[]" id="title_value" placeholder="<?php esc_html_e('Enter Documents Title','lawyer_mgt');?>"  class="form-control validate[required,custom[onlyLetter_specialcharacter],maxSize[50]]"/>
												</div>
												<div class="col-md-3 margin_document ">																						
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
											<input type="button" value="<?php esc_attr_e('Add More Documents','lawyer_mgt') ?>"  onclick="MJ_lawmgt_add_cirtificate()" class="add_cirtificate btn btn-success">
										</div>
									<?php
									}
									?>	
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="document_description"><?php esc_html_e('Description','lawyer_mgt');?></label>
										<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 has-feedback">
											<textarea rows="3"  class="validate[custom[address_description_validation],maxSize[150]] width_100_per_css" name="document_description" placeholder="<?php esc_html_e('Enter Description','lawyer_mgt');?>" id="document_description"><?php if($edit){ echo esc_textarea($document_result->document_description);}elseif(isset($_POST['document_description'])){ echo esc_textarea($_POST['document_description']); } ?></textarea>				
										</div>		
									</div>	
									<div class="offset-sm-2 col-sm-8">
										<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Add Documents','lawyer_mgt');}?>" id="save_documents" name="save_documents" class="btn btn-success"/>
									</div>
								</form>
							</div>    <!--END  PANEL BODY DIV  -->    
						<?php
						}	 /*-- END ADD DOCUMENT ACTIVE TAB */
						?>
					</div>		
				</div>
			</div>
		</div>
	</div><!-- END  MAIN WRAPER  DIV -->
</div><!--  END PAGE INNER DIV -->