<?php 
$obj_case_tast= new MJ_lawmgt_case_tast;
if($active_tab == 'viewtask')
{
	if(isset($_REQUEST['task_id']))
		$task_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['task_id']));
		
		if(isset($_REQUEST['view']) && sanitize_text_field($_REQUEST['view']) == 'true')
		{	
			$casedata=$obj_case_tast->MJ_lawmgt_get_all_edit_tast($task_id);
		} 
        ?>		
		<div class="panel-body"><!-- PANEL BODY DIV   -->
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
									$case_link=MJ_lawmgt_get_case_name(esc_html($casedata->case_id));
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
											$user_name[]=MJ_lawmgt_get_display_name($data);
										}
									}			
									$user_name_sanitize = array_map( 'sanitize_text_field', wp_unslash( $user_name ) );	
									 echo esc_html(implode(",",$user_name_sanitize));
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
									$user_name_sanitize = array_map( 'sanitize_text_field', wp_unslash( $user_name ) );		
									 echo esc_html(implode(",",$user_name_sanitize));
									?>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div><!-- END PANEL BODY DIV   -->
 <?php 
 }
 ?>