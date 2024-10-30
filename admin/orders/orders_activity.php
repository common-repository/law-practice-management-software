<?php 
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
		$file_contant_backup .= file_put_contents(LAWMS_Order_LOG_file_backup,$file_contant,FILE_APPEND) or die("Could not copy file");
		 
		// clear content to 0 bits
		ftruncate($fp, 0);
		//close file
		fclose($fp);
	} 	
}
?>
<div  id="main-wrapper" class="marks_list"><!-- MAIN WRAPER  DIV -->
	<div class="panel panel-white">
		<div class="panel-body"><!-- PANEL BODY DIV  -->
		    <form name="audit_log_form" action="" method="post" class="form-horizontal" id="audit_log_form">
				<div class="audit_button">
					<?php
						echo '<a href="'.LAWMS_PLUGIN_URL.'/download_log.php?mime=LAWMS_log.txt&title=audit_log.txt&token='.LAWMS_Order_LOG_file_download.'" class="btn btn-success">'.esc_html__('Download Log','lawyer_mgt').'</a>'; 
					?>
					<input type="hidden" name="path" value = "<?php echo LAWMS_Order_LOG_file;?>" >
					<input type="hidden" name="path_backup" value = "<?php echo LAWMS_Order_LOG_file_backup;?>" >
					<input type="submit" value="<?php esc_attr_e('Clear Log','lawyer_mgt');?>" name="clear_log" class="btn btn-success"/>
				</div>
				<div class="aduit_log_file">
					<table id="examlist" class="table table-striped" cellspacing="0" width="100%" align="center">
						<tbody>	
							<?php 				
							if(file_exists(LAWMS_Order_LOG_file)) 
							{
								foreach(array_reverse(file(LAWMS_Order_LOG_file)) as $line)
								{
									?>
									<tr>
										<td><?php echo $line;?></td>						
									</tr>
									<?php
								}
							}
							else 	
								 esc_html_e('No any Log found','lawyer_mgt');
							?>
						</tbody>
					</table>
				</div>
				<div class="audit_button">
					<?php
						echo '<a href="'.LAWMS_PLUGIN_URL.'/download_log.php?mime=LAWMS_log.txt&title=audit_log.txt&token='.LAWMS_Order_LOG_file_download.'" class="btn btn-success">'.esc_html__('Download Log','lawyer_mgt').'</a>'; 
					?>
					<input type="hidden" name="path" value = "<?php echo LAWMS_Order_LOG_file;?>" >
					<input type="submit" value="<?php esc_attr_e('Clear Log','lawyer_mgt');?>" name="clear_log" class="btn btn-success"/>
				</div>
			</form>			
		</div>	<!--END  PANEL BODY DIV  -->
	</div>	
</div><!-- END  MAIN WRAPER  DIV -->