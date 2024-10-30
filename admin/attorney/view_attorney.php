<?php 
$role='attorney';
$obj_user=new MJ_lawmgt_Users;
if($active_tab == 'view_attorney')
{	
	$attorney_id=0;
	$edit=0;
	if(isset($_REQUEST['attorney_id']))
		$attorney_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['attorney_id']));
		if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
		{					
			$edit=1;
			$user_info = get_userdata($attorney_id);			
		}?>		
		<div class="panel-body"><!-- PANEL BODY DIV   --> 
			<div class="header">	
				<h3 class="first_hed"><?php esc_html_e('Personal Information','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="member_view_row1">
				<div class="col-lg-8 col-md-8 col-xs-12 col-sm-12 membr_left">
					<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 left_side">
					 <?php 	if($edit) 
							{
								if($user_info->lmgt_user_avatar == "")
								{?>
									<img alt="" class="user_image_upload_view"  src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
								<?php 
								}
								else 
								{
								?>
									<img class="image_upload max_width_100px" src="<?php if($edit)echo esc_url( $user_info->lmgt_user_avatar ); ?>" />
								<?php 
								}
							}
							else 
							{
								?>
								<img alt="" class="max_width_100px" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
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
							<div class="col-md-5 col-sm-12 table_td" >
								<i class="fa fa-envelope"></i>
								<?php esc_html_e('Email','lawyer_mgt');?>
							</div>
							<div class="col-md-7 col-sm-12 table_td" >							
								<span class="txt_color"><?php echo chunk_split(esc_html($user_info->user_email,20,"<BR>")); ?></span>
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
								<span class="txt_color" ><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($user_info->birth_date));?></span>
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
							<i class="fa fa-graduation-cap"></i> <?php esc_html_e('Degree','lawyer_mgt'); ?>
						</div>
						<div class="col-md-8 col-sm-12 table_td">
							<span class="txt_color"><?php if($edit){ echo esc_html($user_info->degree);}?></span>
						</div>
					</div>
					<div class="table_row">
						<div class="col-md-4 col-sm-12 table_td">
							<i class="fa fa-power-off"></i> <?php esc_html_e('Experience','lawyer_mgt');?>
						</div>
						<div class="col-md-8 col-sm-12 table_td">
							<span class="txt_color"><?php if($edit){ echo esc_html($user_info->experience);}?></span>
						</div>
					</div>
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
						  ?></span>
						</div>
					</div>
						<div class="col-md-8 col-sm-12 table_td">
							<?php if(isset($user_info->attorney_cv) && $user_info->attorney_cv != ""){?>
					<a target="blank" href="<?php echo content_url().'/uploads/document_upload/'.esc_attr($user_info->attorney_cv);?>" class="btn btn-default"><i class="fa fa-download"></i> <?php esc_html_e('CV','lawyer_mgt');?></a>
					<?php } ?>	
						
					<div>
					<?php if(isset($user_info->education_certificate) && $user_info->education_certificate != ""){?>
					<a target="blank" href="<?php echo content_url().'/uploads/document_upload/'.esc_attr($user_info->education_certificate); ?>" class="btn btn-default"><i class="fa fa-download"></i> <?php esc_html_e('Education Certificate','lawyer_mgt');?></a>
					<?php } ?>			
					</div>	
					<div>
					<?php if(isset($user_info->experience_certificate) && $user_info->experience_certificate != ""){?>
					<a target="blank" href="<?php echo content_url().'/uploads/document_upload/'.esc_attr($user_info->experience_certificate); ?>" class="btn btn-default"><i class="fa fa-download"></i> <?php esc_html_e('Experience Certificate','lawyer_mgt');?></a>
					<?php } ?>			
					</div>
				</div>
			</div> 		
		</div><!-- PANEL BODY DIV   --> 
		<div class="row row_div_pading"><!-- ROW DIV   --> 
			<div class="col-lg-4 col-md-6 col-xs-12 col-sm-6 close_padding">
				<div class="x_panel attorney_open_case background_color_f7f7f7">
					<div class="x_title">				   
						<h2><?php esc_html_e('Attorney Open Case History','lawyer_mgt');?></h2>
							<ul class="nav navbar-right panel_toolbox custom_css_panel_toolbox">
							  <li><a href="admin.php?page=cases&tab=caselist&tab2=open&attoeny_deatil=true&attorney_id=<?php echo esc_attr($_REQUEST['attorney_id']); ?>" print="20" class="openserviceall"><button type="button" class="btn  btn-default btn_view_all margin_bottom_0px"><?php esc_html_e('View All','lawyer_mgt');?></button></a>
							  </li>
							  
							</ul>
						<div class="clearfix"></div>
					</div>
					<?php 					 
					global $wpdb;
					$attorney=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['attorney_id']));		 
					$table_case = $wpdb->prefix. 'lmgt_cases';
					$attorneydata=$wpdb->get_results("SELECT * FROM $table_case WHERE FIND_IN_SET($attorney,case_assgined_to) AND case_status='open' ORDER BY id DESC LIMIT 0 , 5");						
					if(!empty($attorneydata))
					{						
						foreach ($attorneydata as $retrieved_data)
						{						
							$case_id=$retrieved_data->id;
							$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
							$contactdata=$wpdb->get_results("SELECT * FROM $table_case_contacts WHERE case_id=$case_id");
							
							$username=array();
							
							if(!empty($contactdata))
							{							
								foreach($contactdata as $contactdata1)
								{				
									 $username[]=MJ_lawmgt_get_display_name(esc_attr($contactdata1->user_id));	
								}
								$user_name = array_map( 'sanitize_text_field', wp_unslash( $username ) );
								$contatc_name=implode(',',$user_name);						
							}
						?>
							<div class="x_content">
							  <article class="media event">
								  <a class="pull-left date">
									<p class="month"><?php echo date('M',strtotime(esc_html($retrieved_data->open_date)));?></p>
									<p class="day"><?php echo date('d',strtotime(esc_html($retrieved_data->open_date)));?></p>
								  </a>
								  <div class="media-body">
									 <h5> <b><?php esc_html_e('Client Name:','lawyer_mgt');?> </b> <span class=""><?php echo esc_html($contatc_name);?></span> </h5>  
									 <p><?php esc_html_e('Case Name:','lawyer_mgt');?>  <span class=""><?php echo esc_html($retrieved_data->case_name);?></span></p>
								  </div>
								  <a href="admin.php?page=cases&tab=casedetails&action=view&close_case=true&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($case_id)); ?>"  data-target="#myModal-open-modal" print="20" class="openmodel"><i class="fa fa-eye eye" aria-hidden="true"></i></a>
								</article>
							</div>
						<?php 
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
						<h2><?php esc_html_e('Attorney Close Case History','lawyer_mgt');?></h2>
						<ul class="nav navbar-right panel_toolbox custom_css_panel_toolbox">
						  <li><a href="admin.php?page=cases&tab=caselist&tab2=close&attoeny_deatil=true&attorney_id=<?php echo esc_attr($_REQUEST['attorney_id']); ?>"   print="20" class="openserviceall"><button type="button" class="btn  btn-default btn_view_all margin_bottom_0px"><?php esc_html_e('View All','lawyer_mgt');?></button></a>
						  </li>
						</ul>
						<div class="clearfix"></div>
					</div>
				  <?php 					 
					global $wpdb;
					$attorney=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['attorney_id']));		 
					$table_case = $wpdb->prefix. 'lmgt_cases';
					$attorneydata=$wpdb->get_results("SELECT * FROM $table_case WHERE FIND_IN_SET($attorney,case_assgined_to) AND case_status='close' ORDER BY id DESC LIMIT 0 , 5");
						
					if(!empty($attorneydata))
					{						
						foreach ($attorneydata as $retrieved_data)
						{						
							$case_id=$retrieved_data->id;
							$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
							$contactdata=$wpdb->get_results("SELECT * FROM  $table_case_contacts WHERE case_id=$case_id");
							$username=array();
							
							if(!empty($contactdata))
							{							
								foreach($contactdata as $contactdata1)
								{				
									 $username[]=MJ_lawmgt_get_display_name(esc_attr($contactdata1->user_id));	
								}
								$user_name = array_map( 'sanitize_text_field', wp_unslash( $username ) );
								$contatc_name=implode(',',$user_name);						
							}
							 ?>
							<div class="x_content">
								<article class="media event">
								  <a class="pull-left date">
									<p class="month"><?php echo date('M',strtotime(esc_html($retrieved_data->open_date)));?></p>
									<p class="day"><?php echo date('d',strtotime(esc_html($retrieved_data->open_date)));?></p>
								  </a>
								  <div class="media-body">
								   <h5> <b><?php esc_html_e('Client Name:','lawyer_mgt');?> </b> <span class=""><?php echo esc_html($contatc_name);?></span> </h5>  
									 <p><?php esc_html_e('Case Name:','lawyer_mgt');?><span class=""><?php echo esc_html($retrieved_data->case_name);?></span></p>
								  </div>
								  <a href="admin.php?page=cases&tab=casedetails&action=view&close_case=true&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($case_id)); ?>"  data-target="#myModal-open-modal" print="20" class="openmodel"><i class="fa fa-eye eye" aria-hidden="true"></i></a>
								</article>
							</div>
						<?php
						} 						
					}
					else
					{
						echo esc_html_e('No Cases Available','lawyer_mgt');
					}
					
					?> 
				</div>
			</div>
		</div><!--END  ROW DIV   --> 
	</div>
<?php 
}
?>