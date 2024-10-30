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
	<div class="panel-body"><!-- PANEL BODY DIV   -->
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
						<div class="col-lg-4 col-md-4 col-sm-10 col-xs-12 table_td">
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
						<div class="col-lg-4 col-md-4 col-sm-10 col-xs-12 table_td">
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