<?php 
$note=new MJ_lawmgt_Note;
if($active_tab == 'viewnote')
{
	if(isset($_REQUEST['note_id']))
		$note_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['note_id']));
		if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'viewnote')
		{	
			$casedata=$note->MJ_lawmgt_get_signle_note_by_id($note_id);
		} 
        ?>		
		<div class="panel-body panel_body_flot_css"><!-- PANEL BODY DIV  -->
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
									 echo get_the_title(esc_html($casedata->practice_area_id));
									?>
								</span>
							</div>
						</div>
					</div>
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
											$user_name[]=MJ_lawmgt_get_display_name($data);
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
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 task_detail_div">							
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
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
								if(!empty($casedata->note))
								{
									 echo esc_html($casedata->note);
								}
								else{
									echo "-";
								}
									?>
								</span>
							</div>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
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
		</div><!-- END PANEL BODY DIV  -->
<?php 
}
?>