<?php	
$obj_workflow=new MJ_lawmgt_workflow;
$workflow_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['workflow_id']));
$workflow_info = $obj_workflow->MJ_lawmgt_get_single_workflow($workflow_id);
if($active_tab == 'view_workflow')
{        	
?>		
    <div class="panel-body"><!--PANEL BODY  DIV -->
        <form name="workflow_Details_form" action="" method="post" class="form-horizontal"  enctype='multipart/form-data'>   
			<div class="header">	
				<h3 class="first_hed"><?php esc_html_e('Workflow Information','lawyer_mgt');?></h3>
				<hr>
			</div>	
			<div class="">		
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 workflow_info_div">	
						<div class="table_row">
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 table_td">							
								<?php esc_html_e('Workflow Name','lawyer_mgt'); ?>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 table_td">
								<span class="txt_color">
								<?php
									 echo esc_html($workflow_info->name);
									?>
								</span>
							</div>
						</div>
						<div class="table_row">
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 table_td">							
								<?php esc_html_e('Workflow Description','lawyer_mgt'); ?>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 table_td">
								<span class="txt_color">
								<?php
									 echo esc_html($workflow_info->description);
									?>
								</span>
							</div>
						</div>
						<div class="table_row">
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 table_td">							
								<?php esc_html_e('Workflow Permissions','lawyer_mgt'); ?>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 table_td">
								<span class="txt_color">
								<?php
									 echo esc_html($workflow_info->permission);
									?>
								</span>
							</div>
						</div> 
				</div>
			</div>	
 			
			<div class="header">	
				<h3 class="first_hed"><?php esc_html_e('Workflow Events 4','lawyer_mgt');?></h3>
				<hr>
			</div>	
				
			<?php
			$result_event=$obj_workflow->MJ_lawmgt_get_single_workflow_events($workflow_id);		
			?>
			<div id="event_div">
			<?php
			if(!empty($result_event))
			{
				foreach ($result_event as $retrive_data)
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
								<?php esc_html_e('Event Description','lawyer_mgt'); ?>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
								<span class="txt_color">
								<?php
									 echo esc_html($retrive_data->description);
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
			$result_task=$obj_workflow->MJ_lawmgt_get_single_workflow_tasks($workflow_id);		
			?>
			<div id="task_div">
				<?php
				if(!empty($result_task))
				{
					foreach ($result_task as $retrive_data)
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
								<div class="table_row">
									<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">							
										<?php esc_html_e('Task Description','lawyer_mgt'); ?>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
										<span class="txt_color">
										<?php
											 echo esc_html($retrive_data->description);
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
												 echo esc_html($data->days." ".$data->day_formate." ".$data->day_type." ".$data->task_event_name);
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
								 
						</div>
					</div>	
						 
					<?php
					}
				}
				?>
			</div>
        </form>
	</div>  <!--END PANEL BODY  DIV -->
<?php 
}
?>