<?php 	
$obj_documents=new MJ_lawmgt_documents;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'documentslist');
$document_columns_array=explode(',',get_option('lmgt_document_columns_option'));
$document_export_array=explode(',',get_option('document_export_option'));
$result=null;
if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
{
	//wp_redirect (admin_url().'admin.php?page=lmgt_system');
	$redirect_url= esc_url(admin_url().'admin.php?page=lmgt_system');
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
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV -->
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' )); ?></h3>
	  </div>
	</div>
	<?php 
	if(isset($_POST['save_documents']))
	{	
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_document_nonce' ) )
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
					$upload_docs_array= sanitize_text_field($_REQUEST['old_hidden_cartificate']);
				}		
				
				$result=$obj_documents->MJ_lawmgt_add_documents($_POST,$upload_docs_array);
				if($result)
				{
					//wp_redirect ( admin_url() . 'admin.php?page=documents&tab=documentslist&message=2');
				    $redirect_url=esc_url(admin_url().'admin.php?page=cases&tab=casedetails&action=view&message=21&tab2=note&tab3=notelist&case_id='.$case_id);
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
					//wp_redirect ( admin_url() . 'admin.php?page=documents&tab=documentslist&message=1');
					$redirect_url= esc_url(admin_url().'admin.php?page=documents&tab=documentslist&message=1');
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
			//wp_redirect ( admin_url() . 'admin.php?page=documents&tab=documentslist&message=3');
			$redirect_url= esc_url(admin_url().'admin.php?page=documents&tab=documentslist&message=3');
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
		if(isset($_POST['selected_id']))
		{	
			$selected_id = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ) );
			$all = implode(",", $selected_id);			
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
			//wp_redirect ( admin_url() . 'admin.php?page=documents&tab=documentslist&message=3');
			$redirect_url = esc_url(admin_url().'admin.php?page=documents&tab=documentslist&message=3');
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
		if(isset($_POST['selected_id']))
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
					 
					header('Content-Type:application/force-download');
					header('Pragma: public');       // required
					header('Expires: 0');           // no cache
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file)).' GMT');
					header('Cache-Control: private',false);
					header("Content-Type: application/xls");    
					header('Content-Disposition: attachment; filename="'.basename($file).'"');
					header('Content-Transfer-Encoding: binary');
					//header('Content-Length: '.filesize($file_name));      // provide file size
					header('Connection: close');
					readfile($file);		
					exit;			
				}
			//}
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
		if(isset($_POST['selected_id']))
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
		if(isset($_POST['selected_id']))
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
							
				$stylesheet=wp_enqueue_style( 'bootstrap-css', plugins_url( '/assets/css/style.css', __FILE__) );
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
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
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
									<a href="?page=documents&tab=documentslist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Documents List', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'add_documents' ? 'active' : ''; ?> menucss">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
								{?>
								<a href="?page=documents&tab=add_documents&&action=edit&documents_id=<?php echo esc_attr($_REQUEST['documents_id']);?>">
									<?php esc_html_e('Edit Documents', 'lawyer_mgt'); ?>
								</a>  
								<?php 
								}
								else
								{?>
									<a href="?page=documents&tab=add_documents&&action=add">
										<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Documents', 'lawyer_mgt');?>
									</a>  
								<?php  
								}?>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'documentsactivity' ? 'active' : ''; ?> menucss">
									<a href="?page=documents&tab=documentsactivity">
										<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('Documents Activity', 'lawyer_mgt'); ?>
									</a>
								</li>
							</ul>
						</h2>
						<?php 
						if($active_tab == 'documentslist')
						{							
						?>	
							<script type="text/javascript">
							    var $ = jQuery.noConflict();
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
									<input type="hidden" name="hidden_case_id" class="hidden_case_id" value="">
									<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label filter_lable"><?php esc_html_e('Filter By Document Status :','lawyer_mgt');?></label>
										<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
											<select class="form-control document_filter" name="document_status">
												<option value="-1"><?php esc_html_e('Select All','lawyer_mgt');?></option>
												<option value="0"><?php esc_html_e('Read','lawyer_mgt');?></option>
												<option value="1"><?php esc_html_e('Unread','lawyer_mgt');?></option>
											</select> 
										</div>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
											<input type="submit" class="btn delete_margin_bottom btn-primary" name="document_excle_selected" value="<?php esc_attr_e('Excel', 'lawyer_mgt' ) ;?> " />											
											<input type="submit" class="btn delete_margin_bottom btn-primary" name="document_csv_selected" value="<?php esc_attr_e('CSV', 'lawyer_mgt' ) ;?> " />
											<input type="submit" class="btn delete_margin_bottom btn-primary" name="document_pdf_selected" value="<?php esc_attr_e('PDF', 'lawyer_mgt' ) ;?> " />
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
											 
												$result=$obj_documents->MJ_lawmgt_get_all_documents();	
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
															<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_attr($retrieved_data->id); ?>"></td>	
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
															<a href="?page=documents&tab=add_documents&action=edit&documents_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
															<a href="?page=documents&tab=documentslist&action=delete&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($case_id));?>&documents_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" 
															onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');">
															<?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>
															</td>               
														</tr>
														<?php 
													}
												}	
												?>     
											</tbody>        
										</table>
										<?php
										if(!empty($result))
											{ 
										?>
										<div class="form-group">		
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
												<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="document_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
											</div>
										</div>
											<?php  }  ?>
									</div>
								</form>								
							</div>       
						<?php
						}
						if($active_tab == 'add_documents')
						{
							require_once LAWMS_PLUGIN_DIR. '/admin/documents/add_documents.php';
						}
						if($active_tab == 'documentsactivity')
						{
							require_once LAWMS_PLUGIN_DIR. '/admin/documents/document_activity.php';
						}
					 ?>
					</div>			
				</div>
			</div>
		</div>
	</div><!-- END  MAIN WRAPER  DIV -->
</div><!-- END  INNER PAGE  DIV -->