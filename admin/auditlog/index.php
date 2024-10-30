<?php 
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'audit_log');
if(isset($_REQUEST['clear_log']))
{
	$path = sanitize_text_field($_REQUEST['path']);
	$path_backup = sanitize_text_field($_REQUEST['path_backup']);
	if (file_exists($path)) 
	{
		//open file to write & read
		if (!file_exists($path_backup)) 
		{
			$fp2 = fopen($path_backup, "w");	
		}

		$fp1 = fopen($path_backup, "r+");
		$fp = fopen($path, "r+");
		//get Data
		$file_contant_backup= file_get_contents($path_backup);
		$file_contant= file_get_contents($path);
		//Append data
		$file_contant_backup .= file_put_contents(LAWMS_LOG_file_backup,$file_contant,FILE_APPEND) or die("Could not copy file");
		// clear content to 0 bits
		ftruncate($fp, 0);
		//close file
		fclose($fp);
	} 	
}

if(isset($_REQUEST['download_log']))
{
	$path = LAWMS_LOG_file_Downlaod;
	header('Content-Type: application/octet-stream');
	header('Content-Type: text/plain');
	header('Content-Disposition: attachment; filename='.basename($path));
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($path));
	readfile($path);
}
?>
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV --> 
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' ));?></h3>
	  </div>
	</div>
	<div id="main-wrapper"><!--  MAIN WRAPER DIV   --> 
		<div class="row"><!--  ROW DIV   --> 
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white"><!-- PANEL WHITE  DIV -->
					<div class="panel-body"><!-- PANEL BODY  DIV -->
						<h2 class="nav-tab-wrapper">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="tablist">
								<li role="presentation" class="<?php echo $active_tab == 'audit_log' ? 'active' : ''; ?> menucss">
									<a href="?page=audit_log">
										<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('Audit Log/ALL Activity', 'lawyer_mgt'); ?></a>
									</a>
								</li>
							</ul>
						</h2>
						<div class="panel-body">
							<form name="audit_log_form" action="" method="post" class="form-horizontal" id="audit_log_form">
								<div class="audit_button">
									<?php
										//echo '<a href="'.LAWMS_PLUGIN_URL.'/download_log.php?mime=LAWMS_log.txt&title=audit_log.txt&token='.LAWMS_LOG_file_Downlaod.'" class="btn btn-success">'.esc_html__('Download Log','lawyer_mgt').'</a>'; 
									?>
									<input type="submit" value="<?php esc_attr_e('Download Log','lawyer_mgt');?>" name="download_log" class="btn btn-success"/>
									<input type="submit" value="<?php esc_attr_e('Clear Log','lawyer_mgt');?>" name="clear_log" class="btn btn-success"/>
								</div>
								<div class="aduit_log_file">
									<table id="examlist" class="table table-striped" cellspacing="0" width="100%" align="center">
										<tbody>	
											<?php 				
											if(file_exists(LAWMS_LOG_file)) 
											{
												foreach(array_reverse(file(LAWMS_LOG_file)) as $line)
												{
													?>
													<tr>
														<td><?php echo $line;?></td>						
													</tr>
													<?php
												}
											}
											else
											{												
												esc_html_e('No any Log found','lawyer_mgt');
											}
											?>
										</tbody>
									</table>		
								</div>
								<div class="audit_button">
									<?php
										//echo '<a href="'.LAWMS_PLUGIN_URL.'/download_log.php?mime=LAWMS_log.txt&title=audit_log.txt&token='.LAWMS_LOG_file_Downlaod.'" class="btn btn-success">'.esc_html__('Download Log','lawyer_mgt').'</a>'; 
									?>
									<input type="submit" value="<?php esc_attr_e('Download Log','lawyer_mgt');?>" name="download_log" class="btn btn-success"/>
									<input type="submit" value="<?php esc_attr_e('Clear Log','lawyer_mgt');?>" name="clear_log" class="btn btn-success"/>
								</div>
							</form>			
						</div>
					</div>	<!-- PANEL BODY  DIV -->
				</div>	<!-- ENDPANEL WHITE  DIV -->
			</div>
		</div><!--  END ROW DIV   --> 
 	</div><!-- 	END MAIN WRAPER DIV   --> 
</div><!-- END  PAGE INNER DIV --> 	