<?php	
$obj_workflow=new MJ_lawmgt_workflow;
$obj_caseworkflow=new MJ_lawmgt_caseworkflow;
$workflow_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['workflow_id']));
$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
$workflow_info = $obj_workflow->MJ_lawmgt_get_single_workflow($workflow_id);
if($active_tab == 'view_applyworkflow')
{        	
?>		
    <div class="panel-body"><!-- PANEL BODY  DIV   -->
        <form name="workflow_Details_form" action="" method="post" class="form-horizontal"  enctype='multipart/form-data'>   
			<div class="header">	
				<h3 class="first_hed"><?php esc_html_e('Workflow Information','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="">	
				<?php 
				$workflow_name=MJ_lawmgt_get_workflow_name($workflow_id);?>		
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
				<h3 class="first_hed"><?php esc_html_e('Workflow Events 2','lawyer_mgt');?></h3>
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
						$attendees_name_sanitize = array_map( 'sanitize_text_field', wp_unslash( $attendees_name ) );
						?>
						<div class="table_row">
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
								<?php esc_html_e('Attendees','lawyer_mgt'); ?>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
								<span class="txt_color">
								<?php
									  echo esc_html(implode(",",$attendees_name_sanitize));
									?>
								</span>
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
									$due_date= esc_attr($retrive_data->due_date);
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
									$assign_to_name_sanitize = array_map( 'sanitize_text_field', wp_unslash( $assign_to_name ) );	
									?>
								<div class="table_row">
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
										<?php esc_html_e('Attendees','lawyer_mgt'); ?>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
										<span class="txt_color">
										<?php
											 echo esc_html(implode(",",$assign_to_name_sanitize));
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
    </div> <!-- END PANEL BODY  DIV   -->
<?php 
}
?>