<?php 
$role='client';
$obj_user=new MJ_lawmgt_Users;
if($active_tab == 'viewcontact')
{
    $contact_id=0;
	$edit=0;
	if(isset($_REQUEST['contact_id']))
		$contact_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['contact_id']));
		if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
		{					
			$edit=1;
			$user_info = get_userdata($contact_id);						
		}?>
	<div class="panel-body"><!--PANEL BODY DIV   -->
		<div class="header">	
			<h3 class="first_hed"><?php esc_html_e('Personal Information','lawyer_mgt');?></h3>
			<hr>
		</div>
		<div class="member_view_row1">
			<div class="col-lg-8 col-md-8 col-xs-12 col-sm-12 membr_left">
				<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 left_side">
				 <?php if($edit) 
					{
						if($user_info->lmgt_user_avatar == "")
						{?>
						<img alt="" class="max_width_100px"  src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
						<?php }
						else {
							?>
						<img class="image_upload max_width_100px" src="<?php if($edit)echo esc_url( $user_info->lmgt_user_avatar ); ?>" />
						<?php 
						}
					}
					else 
					{
						?>
						<img alt="" class="max_width_100_per_css" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
						<?php 
					}?>
				</div>
			<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 right_side">
				<div class="table_row">
					<div class="col-md-5 col-sm-12 table_td">
						<i class="fa fa-user"></i>
						<?php esc_html_e('Name','lawyer_mgt'); ?>
					</div>
					<div class="col-md-7 col-sm-12 table_td">
					<span class="txt_color">
							<?php echo esc_html($user_info->first_name." ".$user_info->middle_name." ".$user_info->last_name);?>

						</span>
					</div>
				</div>
				<div class="table_row">
					<div class="col-md-5 col-sm-12 table_td">
						<i class="fa fa-envelope"></i>
						<?php esc_html_e('Email','lawyer_mgt');?>
					</div>
					<div class="col-md-7 col-sm-12 table_td">
					<?php $user_email=esc_html($user_info->user_email); ?>
						<span class="txt_color"><?php echo chunk_split(esc_html($user_email),20,"<BR>"); ?></span>
					</div>
				</div>
				<div class="table_row">
					<div class="col-md-5 col-sm-12 table_td"><i class="fa fa-phone"></i> <?php esc_html_e('Mobile No','lawyer_mgt');?> </div>

					<div class="col-md-7 col-sm-12 table_td">
						<span class="txt_color">
							<span class="txt_color"><?php echo esc_html($user_info->mobile);?> </span>
						</span>
					</div>
				</div>
				<div class="table_row">
					<div class="col-md-5 col-sm-12 table_td">
						<i class="fa fa-calendar"></i> <?php esc_html_e('Date Of Birth','lawyer_mgt');?>
					</div>
					<div class="col-md-7 col-sm-12 table_td">
						<span class="txt_color"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($user_info->birth_date));?></span>
					</div>
				</div>
				<div class="table_row">
					<div class="col-md-5 col-sm-12 table_td">
						<i class="fa fa-mars"></i> <?php esc_html_e('Gender','lawyer_mgt');?>
					</div>

					<div class="col-md-7 col-sm-12 table_td">
						<span class="txt_color"><?php echo esc_html($user_info->gender);?></span>
					</div>
				</div>
				<div class="table_row">
					<div class="col-md-5 col-sm-12 table_td">
						<i class="fa fa-user"></i> <?php esc_html_e('UserName','lawyer_mgt');?>
					</div>
					<div class="col-md-7 col-sm-12 table_td">
						<span class="txt_color"><?php echo esc_html($user_info->user_login);?> </span>
					</div>
				</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-xs-12 col-sm-12 member_right">
					<span class="report_title">
						<span class="fa-stack cutomcircle">
							<i class="fa fa-align-left fa-stack-1x"></i>
						</span>
						<span class="shiptitle"><?php esc_html_e('More Info','lawyer_mgt');?></span>
					</span>
					<div class="table_row">
						<div class="col-md-4 col-sm-12 table_td">
							<i class="fa fa-map-marker"></i> <?php esc_html_e('Address','lawyer_mgt');?>
						</div>
						<div class="col-md-8 col-sm-12 table_td">
							<span class="txt_color"><?php
					if($edit)
					{ 
					 if($user_info->address != '')

						echo esc_html($user_info->address).", <BR>";

					 if($user_info->city_name != '')

						 echo esc_html($user_info->city_name).", <BR>";
					   
					if($user_info->state_name != '')

						 echo esc_html($user_info->state_name).", <BR>";
					   

					if($user_info->pin_code != '')

						echo esc_html($user_info->pin_code).".";
					   }

					?> </span>
						</div>
					</div>
			</div>
		</div> 		
	</div>	<!--END PANEL BODY DIV   -->
	 
	<div class="row row_div_pading_client"> <!--ROW DIV   -->
		<div class="col-lg-4 col-md-6 col-xs-12 col-sm-6 padding_css">
			<div class="x_panel attorney_open_case background_color_f7f7f7">
				<div class="x_title">				   
					<h2><?php esc_html_e('Client Open Case History','lawyer_mgt');?></h2>
					<ul class="nav navbar-right panel_toolbox">
					  <li><a href="admin.php?page=cases&tab=caselist&tab2=open&contact_details=true&contact_id=<?php echo esc_attr($_REQUEST['contact_id']); ?>"  print="20" class="openserviceall"><button type="button" class="btn  btn-default btn_view_all margin_bottom_0_px_css"><?php esc_html_e('View All','lawyer_mgt');?></button></a>
					  </li>                      
					</ul>
					<div class="clearfix"></div>
				</div>
				<?php 					 
				global $wpdb;
				$table_case = $wpdb->prefix. 'lmgt_cases';
				$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
				$contact_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['contact_id']));		
				
				$case_id_by_contact_id=$wpdb->get_results("SELECT case_id FROM $table_case_contacts WHERE user_id=$contact_id");
					
				if(!empty($case_id_by_contact_id))
				{						
					foreach ($case_id_by_contact_id as $retrieved_data)
					{						
						$case_id= sanitize_text_field($retrieved_data->case_id);
					   
						$casedata=$wpdb->get_results("SELECT * FROM $table_case WHERE id=$case_id AND case_status='open' ORDER BY id DESC LIMIT 0 , 5");
					
						if(!empty($casedata))
						{							
							foreach($casedata as $data)
							{		
								$user=explode(",",sanitize_text_field($data->case_assgined_to));
								$case_assgined_too=array();
								if(!empty($user))
								{						
									foreach($user as $data4)
									{
										$case_assgined_too[]=MJ_lawmgt_get_display_name(sanitize_text_field($data4));
									}
								}		
								$case_assgined_to = array_map( 'sanitize_text_field', wp_unslash( $case_assgined_too ) );
						?>
								 <div class="x_content">
								  <article class="media event">
									  <a class="pull-left date">
										<p class="month"><?php echo date('M',strtotime(esc_html($data->open_date)));?></p>
										<p class="day"><?php echo date('d',strtotime(esc_html($data->open_date)));?></p>
									  </a>
									  <div class="media-body">
										 <h5> <b><?php esc_html_e('Attorney Name : ','lawyer_mgt');?></b> <span class="txt_color1"><?php echo esc_html(implode(", ",$case_assgined_to));?></span> </h5>  
										 <p><?php esc_html_e('Case Name: ','lawyer_mgt');?> <span class="txt_color1"><?php echo esc_html($data->case_name);?></span></p>
									  </div>
									  <a href="admin.php?page=cases&tab=casedetails&action=view&close_case=true&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($case_id)); ?>"  data-target="#myModal-open-modal" print="20" class="openmodel"><i class="fa fa-eye eye" aria-hidden="true"></i></a>
									</article>
									</div>
							<?php 
							}						
						}		
					}		
				}
				else
				{
					echo esc_html_e('No Cases Available','lawyer_mgt');
				}
				
				?> 
			</div>
		</div>	  
		<div class="col-lg-4 col-md-6 col-xs-12 col-sm-6 close_padding">
			<div class="x_panel attorney_close_case background_color_f7f7f7">
				<div class="x_title">			   
					<h2><?php esc_html_e('Client Close Case History','lawyer_mgt');?></h2>
					<ul class="nav navbar-right panel_toolbox">
					  <li><a href="admin.php?page=cases&tab=caselist&tab2=close&contact_details=true&contact_id=<?php echo esc_attr($_REQUEST['contact_id']); ?>" print="20" class="openserviceall"><button type="button" class="btn  btn-default btn_view_all margin_bottom_0_px_css"><?php esc_html_e('View All','lawyer_mgt');?></button></a>
					  </li>                      
					</ul>
					<div class="clearfix"></div>
				</div>
			  <?php						 
				global $wpdb;
				$table_case = $wpdb->prefix. 'lmgt_cases';
				$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
				$contact_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['contact_id']));		
				
				$case_id_by_contact_id=$wpdb->get_results("SELECT case_id FROM $table_case_contacts WHERE user_id=$contact_id");
					
				if(!empty($case_id_by_contact_id))
				{						
					foreach ($case_id_by_contact_id as $retrieved_data)
					{						
						$case_id= sanitize_text_field($retrieved_data->case_id);
					   
						$casedata=$wpdb->get_results("SELECT * FROM $table_case WHERE id=$case_id AND case_status='close' ORDER BY id DESC LIMIT 0 , 5");
					
						if(!empty($casedata))
						{							
							foreach($casedata as $data)								
							{
								$user=explode(",",sanitize_text_field($data->case_assgined_to));
								$case_assgined_too=array();
								if(!empty($user))
								{						
									foreach($user as $data4)
									{
										$case_assgined_too[]=MJ_lawmgt_get_display_name(sanitize_text_field($data4));
									}
								}		
								$case_assgined_to = array_map( 'sanitize_text_field', wp_unslash( $case_assgined_too ) );
								?>
								 <div class="x_content">
								  <article class="media event">
									  <a class="pull-left date">
										<p class="month"><?php echo date('M',strtotime(esc_html($data->open_date)));?></p>
										<p class="day"><?php echo date('d',strtotime(esc_html($data->open_date)));?></p>
									  </a>
									  <div class="media-body">
									   <h5> <b><?php esc_html_e('Attorney Name :','lawyer_mgt');?> </b> <span class="txt_color1"><?php echo esc_html(implode(", ",$case_assgined_to));?></span> </h5>  
										 <p><?php esc_html_e('Case Name : ','lawyer_mgt');?> <span class="txt_color1"><?php echo esc_html($data->case_name);?></span></p>
									  </div>
									  <a href="admin.php?page=cases&tab=casedetails&action=view&close_case=true&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($case_id)); ?>"  data-target="#myModal-open-modal" print="20" class="openmodel"><i class="fa fa-eye eye" aria-hidden="true"></i></a>
									</article>
								</div>
								<?php
							} 
						  }
					}	
				}
				else
				{
					echo esc_html_e('No Cases Available','lawyer_mgt');
				}
					
				?> 
			</div>
		</div>
	</div>		<!--END ROW DIV   -->
<?php 
}
?>