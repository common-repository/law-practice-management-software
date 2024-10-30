<?php $active_tab = isset($_GET['tab2'])?$_GET['tab2']:'caseinfo';?>
 
	<div class="navtab panel panel-white">
	<?php 
	if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='view')
	{?>
		<h2>
			<ul id="myTab" class="sub_menu_css line case_nav nav nav-tabs" role="tablist">
				<li role="presentation" class="<?php echo esc_html($active_tab) == 'caseinfo' ? 'active' : ''; ?> menucss">
					<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
						<?php echo '<span class="fa fa-briefcase"></span> '.esc_html__('Case Info', 'lawyer_mgt'); ?>
					</a>
				</li>
				<?php
				if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
				{
					?>
					<li role="presentation" class="<?php echo esc_html($active_tab) == 'documents' ? 'active' : ''; ?> menucss">
						<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=documents&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
							<?php echo '<span class="fa fa-file"></span> '.esc_html__('Documents', 'lawyer_mgt'); ?>
						</a>
					</li>
				 <?php
				}			
				if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
				{
					
				 ?>
					<li role="presentation" class="<?php echo esc_html($active_tab) == 'task' ? 'active' : ''; ?> menucss">
						<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=task&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
							<?php echo '<span class="fa fa-tasks"></span> '.esc_html__('Task', 'lawyer_mgt'); ?>
						</a>
					</li>
					<?php
				}
				?>
				<li role="presentation" class="<?php echo esc_html($active_tab) == 'note' ? 'active' : ''; ?> menucss">
					<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=note&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
						<?php echo '<span class="fa fa-file-o"></span> '.esc_html__('Notes', 'lawyer_mgt'); ?>
					</a>
				</li>
				<li role="presentation" class="<?php echo esc_html($active_tab) == 'event' ? 'active' : ''; ?> menucss">
					<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=event&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
						<?php echo '<span class="fa fa-calendar"></span> '.esc_html__('Event', 'lawyer_mgt'); ?>
					</a>
				</li>
				<?php
				if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
				{
					?>
					<li role="presentation" class="<?php echo $active_tab == 'invoice' ? 'active' : ''; ?> menucss">
					 <a href="admin.php?page=cases&tab=casedetails&action=view&tab2=invoice&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
							<?php echo '<span class="fa fa-file-text-o"></span> '.esc_html__('Invoice', 'lawyer_mgt'); ?>
						</a>
					</li>
					<?php
				}
				?>
				<li role="presentation" class="<?php echo esc_html($active_tab) == 'workflow' ? 'active' : ''; ?> menucss">
				 <a href="admin.php?page=cases&tab=casedetails&action=view&&tab2=workflow&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
						<?php echo '<span class="fa fa-stack-overflow"></span> '.esc_html__('Workflow', 'lawyer_mgt'); ?>
					</a>
				</li>
			</ul>
		</h2>					
	<?php 
	}	
if($active_tab=='caseinfo')
{?>
	<div class="panel-body "><!-- PANEL BODY  DIV   -->
		<div class="header">	
			<h3 class="first_hed"><?php esc_html_e('Case Information','lawyer_mgt');?></h3>
			<hr>
		</div>
		<div class="case_info_div col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?php 
			if(isset($_REQUEST['case_id']))
			$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
			
			$obj_next_hearing_date=new MJ_lawmgt_Orders;
			$next_hearing_date= $obj_next_hearing_date->MJ_lawmgt_get_next_hearing_date_asc_by_case_id($case_id);
			$obj_case=new MJ_lawmgt_case;
			$case_info_data = $obj_case->MJ_lawmgt_get_single_case($case_id);
			?>
			<div class="table_row">
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
					<?php esc_html_e('Case Name','lawyer_mgt');?>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
					<span class="txt_color">
						<?php  echo esc_html($case_info_data->case_name);?>
					</span>
				</div>
			</div>
			<div class="table_row">
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
					<?php esc_html_e('Case Number','lawyer_mgt');?>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
					<span class="txt_color">
						<?php  echo esc_html($case_info_data->case_number);?>
					</span>
				</div>
			</div>
			<div class="table_row">
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
				 <?php esc_html_e('Practice Area','lawyer_mgt');?>
				 </div>
				 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
					<span class="txt_color">
						<?php echo get_the_title(esc_attr($case_info_data->practice_area_id));?>
					</span>
				</div>
			</div>
			<?php
			if(!empty($case_info_data->case_description))
			{
				?>
				<div class="table_row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
					<?php esc_html_e('Case Description','lawyer_mgt');?>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
					<span class="txt_color">
						<?php  echo esc_html($case_info_data->case_description);?>
					</span>
					</div>
			 	
				</div>
			<?php } ?>
				<div class="table_row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
					<?php esc_html_e('Court Name','lawyer_mgt');?>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
						<?php 
							$court_id =$case_info_data->court_id;
							$latest_posts = get_post($court_id);
						echo '<span class="txt_color" value="'.esc_attr($latest_posts->ID).'">'.esc_html($latest_posts->post_title).'</span>';
						 ?>
					</div>
				</div>
				<?php
			if(!empty($case_info_data->court_hall_no))
			{
				?>
				<div class="table_row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
					<?php esc_html_e('Court Hall No','lawyer_mgt');?>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
					<span class="txt_color">
						<?php  echo esc_html($case_info_data->court_hall_no);?>
					</span>
					</div>
			 	
				</div>
			<?php } ?>
			 <?php
			if(!empty($case_info_data->floor))
			{
				?>
				<div class="table_row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
					<?php esc_html_e('Floor','lawyer_mgt');?>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
					<span class="txt_color">
						<?php  echo esc_html($case_info_data->floor);?>
					</span>
					</div>
			 	
				</div>
			<?php } ?>
				<div class="table_row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
					<?php esc_html_e('State Name','lawyer_mgt');?>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
						<?php 
							$state_id =$case_info_data->state_id;
							$latest_posts = get_post($state_id);
						echo '<span class="txt_color" value="'.esc_attr($latest_posts->ID).'">'.esc_html($latest_posts->post_title).'</span>';
						 ?>
					</div>
				</div>
				<div class="table_row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
					<?php esc_html_e('Bench Name','lawyer_mgt');?>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
						<?php 
							$bench_id = esc_attr($case_info_data->bench_id);
							$latest_posts = get_post($bench_id);
						echo '<span class="txt_color" value="'.esc_attr($latest_posts->ID).'">'.esc_html($latest_posts->post_title).'</span>';
						 ?>
					</div>
				</div>
			<?php
			if(!empty($case_info_data->crime_no))
			{
				?>
				<div class="table_row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
						<?php esc_html_e('Crime No of Police Station','lawyer_mgt');?>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
						<span class="txt_color">
							<?php  echo esc_html($case_info_data->crime_no);?>
						</span>
					</div>
				</div>
			<?php
			}
			if(!empty($case_info_data->fri_no))
			{
				?>
				<div class="table_row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
						<?php esc_html_e('FIR No','lawyer_mgt');?>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
						<span class="txt_color">
							<?php  echo esc_html($case_info_data->fri_no);?>
						</span>
					</div>
				</div>
			<?php
			}
			if(!empty($case_info_data->crime_details))
			{
				?>
				<div class="table_row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
						<?php esc_html_e('Crime Details','lawyer_mgt');?>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
						<span class="txt_color">
							<?php echo esc_html($case_info_data->crime_details);?>
						</span>
					</div>
				</div>	
				<?php
			}
			if(!empty($case_info_data->earlier_history))
			{
				?>
				<div class="table_row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
						<?php esc_html_e('Earlier Court History','lawyer_mgt');?>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
						<span class="txt_color">
							<?php  echo esc_html($case_info_data->earlier_history);?>
						</span>
					</div>
				</div>		
			 <?php
			}
			if(!empty($case_info_data->priority))
			{
				?>
				<div class="table_row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
						<?php esc_html_e('Priority','lawyer_mgt');?>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
						<span class="txt_color">
							<?php  echo esc_html($case_info_data->priority);?>
						</span>
					</div>
				</div>		
			 <?php
			}
			if(!empty($case_info_data->classification))
			{
				?>
				<div class="table_row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
						<?php esc_html_e('Classification','lawyer_mgt');?>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
						<span class="txt_color">
							<?php  echo esc_html($case_info_data->classification);?>
						</span>
					</div>
				</div>		
			 <?php
			}
			if(!empty($case_info_data->referred_by))
			{
				?>
				<div class="table_row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
						<?php esc_html_e('Referred By','lawyer_mgt');?>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
						<span class="txt_color">
							<?php  echo  esc_html($case_info_data->referred_by);?>
						</span>
					</div>
				</div>		
			 <?php
			}
			if(!empty($case_info_data->stages))
			{
			?>
			 <div class="table_row">
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
				<?php esc_html_e('Case Stages','lawyer_mgt');?>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
			 
					<?php 
				
					if(!empty($case_info_data->stages))
					{
						$stages=json_decode($case_info_data->stages);
					}
					 
					$increment  = 0;
					foreach($stages as $data)
					{ 
						$increment ++;
						?>	
						<span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 txt_color padding_0px_0px_5px_0px_css">
						<?php echo $increment ;?>. <?php echo esc_html($data->value); ?>
						</span>
						<?php
					} 
					?>							
				</div>
			</div>
			<?php
			}
			?>
		</div>								
		<div class="header">	
			<h3 class="first_hed"><?php esc_html_e('Important Date','lawyer_mgt');?></h3>
			<hr>
		</div>
			<div class="case_info_div col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="table_row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
							<?php esc_html_e('Open Date','lawyer_mgt');?>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
							<span class="txt_color">
							<?php									
								 echo esc_html(MJ_lawmgt_getdate_in_input_box($case_info_data->open_date));
								?>
							</span>
						</div>
					</div>
					<div class="table_row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
						<?php esc_html_e('Statute of Limitations','lawyer_mgt');?>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
							<span class="txt_color">
							<?php									
								 echo esc_html(MJ_lawmgt_getdate_in_input_box($case_info_data->statute_of_limitations));
								?>
							</span>
						</div>
					</div>
					<div class="table_row">
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
						<?php esc_html_e('Hearing Dates','lawyer_mgt');?>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
							<?php 
							$increment  = 0;
							foreach($next_hearing_date as $data)
							{ 
								$increment ++;
								?>	
								<span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 txt_color padding_0px_0px_5px_0px_css">
								<?php echo $increment ;?>. <?php echo  esc_html(MJ_lawmgt_getdate_in_input_box($data->next_hearing_date)); ?>
								</span>
								<?php
							} 
							?>							
						</div>
					</div>
				</div>								
			</div>
			<div class="header">	
				<h3 class="first_hed"><?php esc_html_e('Attorney And Client Link','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="case_info_div col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="table_row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
						<?php esc_html_e('Assigned To Attorney','lawyer_mgt');?>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
						<span class="txt_color">
						<?php
							$user=explode(",",$case_info_data->case_assgined_to);
							$user_name=array();
							if(!empty($user))
							{						
								foreach($user as $data4)
								{
									$user_name[]=MJ_lawmgt_get_display_name($data4);
								}
							}			
							 echo esc_html(implode(", ",$user_name));
							?>
						</span>
					</div>
				</div>	
				<div class="table_row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 table_td">
						<?php esc_html_e('Client Name','lawyer_mgt');?>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 table_td">
						<span class="txt_color">
						<?php
							global $wpdb;
							$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
							
							$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
							$result = $wpdb->get_results("SELECT * FROM $table_case_contacts where case_id=".$case_id);
							$user_name=array();
							if(!empty($result))
							{						
								foreach($result as $data)
								{
									$user_name[]=MJ_lawmgt_get_display_name($data->user_id);
								}
							}			
							 echo esc_html(implode(", ",$user_name));
							?>
						</span>
					</div>
				</div>	
			</div>
			<?php
			global $wpdb;
					$table_case_staff_users = $wpdb->prefix. 'lmgt_case_staff_users';
					
					$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
					$result_staff = $wpdb->get_results("SELECT * FROM $table_case_staff_users where case_id=".$case_id);
					if(!empty($result_staff))
					{
						?>
				
			<div class="header">	
				<h3 class="first_hed"><?php esc_html_e('Staff Link','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="case_info_div col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<?php
					
						foreach ($result_staff as $retrive_data)				
						{ 		 	
						?>
						<div class="table_row">
						 
							 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 casedetail_link_user_link_div table_td">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 user-link-name user-link-name-staff">
								<?php $staff_name=MJ_lawmgt_get_display_name($retrive_data->user_id); ?> 
									<span><?php echo esc_html($staff_name);?></span>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 user-link-billing-rate">
								<span class="float_left_css"><?php echo esc_html($retrive_data->fee); ?><?php esc_html_e(' / hr','lawyer_mgt');?></span>
									 
								</div>									
							</div>
						</div>
						<?php
						
						}												
					?>
				</div>								
			</div>
			<?php
			}
			?>
		<div class="header">	
			<h3 class="first_hed"><?php esc_html_e('Opponents','lawyer_mgt');?></h3>
			<hr>
		</div>
		<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<table class="table table-bordered">
				<thead>
				  <tr>
					<th class="text_align_center_css"><?php esc_html_e('Opponent Name ','lawyer_mgt');?></th>
					<th class="text_align_center_css"><?php esc_html_e('Opponent Email','lawyer_mgt');?></th>
					<th class="text_align_center_css" ><?php esc_html_e('Opponent Mobile Number','lawyer_mgt');?></th>
				  </tr>
				</thead>
				<tbody>
				<?php
				$opponents_details_array=json_decode($case_info_data->opponents_details);
				
				if(!empty($opponents_details_array[0]->opponents_name))
				{
					foreach ($opponents_details_array as $data)
					{
					?> 
					  <tr>
						<td class="text_align_center_css" ><?php echo esc_html($data->opponents_name); ?></td>
						<td class="text_align_center_css"><?php echo esc_html($data->opponents_email); ?></td>
						<td  class="text_align_center_css" ><?php if(!empty($data->opponents_mobile_number)){ echo esc_html($data->opponents_phonecode); echo esc_html($data->opponents_mobile_number); } ?></td>							
					  </tr>	
					<?php
					}
				}	
				else
				{ ?>			 		 
					<td class="text_align_center_css" colspan="3"><?php esc_html_e('No Data Available...','lawyer_mgt');?></td>
					<?php 	
				}
				?>	
				</tbody>
			</table>
		</div>
		<div class="header">	
			<h3 class="first_hed"><?php esc_html_e('Opponents Attorney','lawyer_mgt');?></h3>
			<hr>
		</div>	
		<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<table class="table table-bordered">
				<thead>
				  <tr>
					<th class="text_align_center_css" ><?php esc_html_e('Opponent Name ','lawyer_mgt');?></th>
					<th class="text_align_center_css" ><?php esc_html_e('Opponent Email','lawyer_mgt');?></th>
					<th  class="text_align_center_css" ><?php esc_html_e('Opponent Mobile Number','lawyer_mgt');?></th>
				  </tr>
				</thead>
				<tbody>
				<?php
				$opponents_attorney_details=json_decode($case_info_data->opponents_attorney_details);
						
				if(!empty($opponents_attorney_details[0]->opponents_attorney_name))
				{
					foreach ($opponents_attorney_details as $data)
					{
					?> 
					  <tr>
						<td class="text_align_center_css"><?php echo esc_html($data->opponents_attorney_name); ?></td>
						<td class="text_align_center_css"><?php echo esc_html($data->opponents_attorney_email); ?></td>
						<td class="text_align_center_css"><?php if(!empty($data->opponents_attorney_mobile_number)){ echo esc_html($data->opponents_attorney_phonecode); echo esc_html($data->opponents_attorney_mobile_number); } ?></td>							
					  </tr>	
					<?php
					}
				}		
				else
				{ ?>
			 
					<td class="text_align_center_css"  colspan="3"><?php esc_html_e('No Data Available...','lawyer_mgt');?></td>
			<?php 	
				}
				?>	
				</tbody>
			</table>
		</div>
	</div>
</div>	<!-- END PANEL BODY  DIV   -->
<?php
}
if($active_tab=='documents')
{
	if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
	{
		    //wp_redirect (admin_url().'admin.php?page=lmgt_system');
		    $url=admin_url().'admin.php?page=lmgt_system';
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
	require_once LAWMS_PLUGIN_DIR. '/admin/cases/case_documents.php';
}
if($active_tab=='task')
{
	if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
	{
		//wp_redirect (admin_url().'admin.php?page=lmgt_system');
		$url=admin_url().'admin.php?page=lmgt_system';
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
	require_once LAWMS_PLUGIN_DIR. '/admin/cases/add_case_task.php';
}
if($active_tab=='note')
{
  require_once LAWMS_PLUGIN_DIR. '/admin/cases/addnotes.php';
}
if($active_tab=='event')
{
  require_once LAWMS_PLUGIN_DIR. '/admin/cases/addevent.php';
}
if($active_tab=='invoice')
{
	if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
	{
		//wp_redirect (admin_url().'admin.php?page=lmgt_system');
		$url=admin_url().'admin.php?page=lmgt_system';
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
	require_once LAWMS_PLUGIN_DIR. '/admin/cases/case_invoice.php';
}
if($active_tab=='workflow')
{
  require_once LAWMS_PLUGIN_DIR. '/admin/cases/case_workflow.php';
}				
?>		  