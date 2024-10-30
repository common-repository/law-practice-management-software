<?php 	
$obj_user=new MJ_lawmgt_Users;
$contact_columns_array=explode(',',get_option('lmgt_contact_columns_option'));
?>
<div class="row"><!-- PANEL ROW DIV -->
	<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">		
		<?php
		if($active_tab == 'contactlist')
		{ 
			$active_tab = sanitize_text_field(isset($_GET['tab1'])?$_GET['tab1']:'active');
		?>	
			<script type="text/javascript">
			var $ = jQuery.noConflict();
			jQuery(document).ready(function($)
			{
		    "use strict";
			jQuery('.contact_list').DataTable({
			"responsive": true,
			"autoWidth": false,
			"order": [[ 1, "asc" ]],
			language:<?php echo wpnc_datatable_multi_language();?>,
			 "aoColumns":[
						  {"bSortable": false},
						  <?php if(in_array('photo',$contact_columns_array)) { ?>
						  {"bSortable": false},
						  <?php } ?>
						  <?php if(in_array('contact_name',$contact_columns_array)) { ?>
						  {"bSortable": true},
						  <?php } ?>
						  <?php if(in_array('date_of_birth',$contact_columns_array)) { ?>
						  {"bSortable": true},
						  <?php } ?>
						  <?php if(in_array('contact_email',$contact_columns_array)) { ?>
						  {"bSortable": true},
						  <?php } ?>
						  <?php if(in_array('mobile_no',$contact_columns_array)) { ?>
						  {"bSortable": true},
						  <?php } ?>
						  <?php if(in_array('contact_case_link',$contact_columns_array)) { ?>
						  {"bSortable": true},
						  <?php } ?>
						  <?php if(in_array('group',$contact_columns_array)) { ?>
						  {"bSortable": true},
						  <?php } ?>
						  <?php if(in_array('address',$contact_columns_array)) { ?>
						  {"bSortable": true},
						  <?php } ?>
						  <?php if(in_array('contact_city',$contact_columns_array)) { ?>
						  {"bSortable": true},
						  <?php } ?>
						  <?php if(in_array('contact_state',$contact_columns_array)) { ?>
						  {"bSortable": true},
						  <?php } ?>
						  <?php if(in_array('job_title',$contact_columns_array)) { ?>
						  {"bSortable": true},
						  <?php } ?>
						  <?php if(in_array('gender',$contact_columns_array)) { ?>
						  {"bSortable": true},
						  <?php } ?>
						  <?php if(in_array('pin_code',$contact_columns_array)) { ?>
						  {"bSortable": true},
						  <?php } ?>
						  <?php if(in_array('alternate_no',$contact_columns_array)) { ?>
						  {"bSortable": true},
						  <?php } ?>
						  <?php if(in_array('phone_home',$contact_columns_array)) { ?>
						  {"bSortable": true},
						  <?php } ?>
						  <?php if(in_array('phone_work',$contact_columns_array)) { ?>
						  {"bSortable": true},
						  <?php } ?>
						  <?php if(in_array('fax',$contact_columns_array)) { ?>
						  {"bSortable": true},
						  <?php } ?>
						  <?php if(in_array('license_no',$contact_columns_array)) { ?>
						  {"bSortable": true},
						  <?php } ?>
						  <?php if(in_array('website',$contact_columns_array)) { ?>
						  {"bSortable": true},
						  <?php } ?>
						  <?php if(in_array('contact_description',$contact_columns_array)) { ?>
						  {"bSortable": true},
						  <?php } ?>
						  {"bSortable": false}
					   ]		               		
			});	
			jQuery('.contact_list2').DataTable({
				
				"responsive": true,
				language:<?php echo wpnc_datatable_multi_language();?>,
				"autoWidth": false,
				"order": [[ 1, "asc" ]],
				 "aoColumns":[							 
							   <?php if(in_array('photo',$contact_columns_array)) { ?>
							  {"bSortable": false},
							  <?php } ?>
							  <?php if(in_array('contact_name',$contact_columns_array)) { ?>
							  {"bSortable": true},
							  <?php } ?>
							  <?php if(in_array('date_of_birth',$contact_columns_array)) { ?>
							  {"bSortable": true},
							  <?php } ?>
							  <?php if(in_array('contact_email',$contact_columns_array)) { ?>
							  {"bSortable": true},
							  <?php } ?>
							  <?php if(in_array('mobile_no',$contact_columns_array)) { ?>
							  {"bSortable": true},
							  <?php } ?>
							  <?php if(in_array('contact_case_link',$contact_columns_array)) { ?>
							  {"bSortable": true},
							  <?php } ?>
							  <?php if(in_array('group',$contact_columns_array)) { ?>
							  {"bSortable": true},
							  <?php } ?>
							  <?php if(in_array('address',$contact_columns_array)) { ?>
							  {"bSortable": true},
							  <?php } ?>
							  <?php if(in_array('contact_city',$contact_columns_array)) { ?>
							  {"bSortable": true},
							  <?php } ?>
							  <?php if(in_array('contact_state',$contact_columns_array)) { ?>
							  {"bSortable": true},
							  <?php } ?>
							  <?php if(in_array('job_title',$contact_columns_array)) { ?>
							  {"bSortable": true},
							  <?php } ?>
							  <?php if(in_array('gender',$contact_columns_array)) { ?>
							  {"bSortable": true},
							  <?php } ?>
							  <?php if(in_array('pin_code',$contact_columns_array)) { ?>
							  {"bSortable": true},
							  <?php } ?>
							  <?php if(in_array('alternate_no',$contact_columns_array)) { ?>
							  {"bSortable": true},
							  <?php } ?>
							  <?php if(in_array('phone_home',$contact_columns_array)) { ?>
							  {"bSortable": true},
							  <?php } ?>
							  <?php if(in_array('phone_work',$contact_columns_array)) { ?>
							  {"bSortable": true},
							  <?php } ?>
							  <?php if(in_array('fax',$contact_columns_array)) { ?>
							  {"bSortable": true},
							  <?php } ?>
							  <?php if(in_array('license_no',$contact_columns_array)) { ?>
							  {"bSortable": true},
							  <?php } ?>
							  <?php if(in_array('website',$contact_columns_array)) { ?>
							  {"bSortable": true},
							  <?php } ?>
							  <?php if(in_array('contact_description',$contact_columns_array)) { ?>
							  {"bSortable": true},
							  <?php } ?>						  
							  {"bSortable": false}
						   ]		               		
				});	
				$(".delete_check").on('click', function()
				{	
					if ($('.sub_chk:checked').length == 0 )
					{
						 alert("<?php esc_html_e('Please select atleast one record','lawyer_mgt');?>");
						return false;
					}
					else{
						alert("<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>");
						return true;
					}
					 
				});	 
			} );
			jQuery(document).ready(function($)
			{
                "use strict";				
				jQuery('#select_all').on('click', function(e)
				{
					 if($(this).is(':checked',true))  
					 {
						$(".sub_chk").prop('checked', true);  
					 }  
					 else  
					 {  
						$(".sub_chk").prop('checked',false);  
					 } 
				});
				$("body").on("change", ".sub_chk", function()
				{ 
					if(false == $(this).prop("checked"))
					{ 
						$("#select_all").prop('checked', false); 
					}
					if ($('.sub_chk:checked').length == $('.sub_chk').length )
					{
						$("#select_all").prop('checked', true);
					}
				});
				
				$("body").on("change", ".dtr-control", function()
				{ 
					$(".child").css("display", "none");
					$('table.dataTable.dtr-inline.collapsed>tbody>tr.parent>td.dtr-control:before').css('display','none !important');
				});
			});
			</script>	
			<h2>
				<ul class="sub_menu_css line nav nav-tabs" id="myTab" role="tablist">
					<li role="presentation" class="<?php echo esc_html($active_tab) == 'active' ? 'active' : ''; ?> menucss">
						<a href="?page=contacts&tab=contactlist&tab1=active">
						<?php echo esc_html__('Active', 'lawyer_mgt'); ?>
						</a>
					</li>
					<li role="presentation" class="<?php echo esc_html($active_tab) == 'archived' ? 'active' : ''; ?> menucss">
						<a href="?page=contacts&tab=contactlist&tab1=archived">
						<?php echo esc_html__('Archived', 'lawyer_mgt'); ?>
						</a>
					</li>			
				</ul>
			</h2> 
			<?php
			if($active_tab == 'active')
			{ 
			?>
				<form name="wcwm_report" action="" method="post">
				<div class="panel-body">	
					<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">	
						<table id="contact_list1" class="contact_list table csv_data table-striped table-bordered">
							<thead>	
								<tr>
									<th><input type="checkbox" id="select_all"></th>	
									<?php if(in_array('photo',$contact_columns_array)) { ?>
										<th class="width_80_px_css"><?php  esc_html_e('Photo', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
									<?php if(in_array('contact_name',$contact_columns_array)) { ?>
										<th><?php esc_html_e('Client Name', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
									<?php if(in_array('date_of_birth',$contact_columns_array)) { ?>
										<th><?php esc_html_e('Date Of Birth', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
								 
									<?php if(in_array('contact_email',$contact_columns_array)) { ?>
										<th> <?php esc_html_e('Client Email', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
									<?php if(in_array('mobile_no',$contact_columns_array)) { ?>
										<th> <?php esc_html_e('Mobile Number', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
									<?php if(in_array('contact_case_link',$contact_columns_array)) { ?>
										<th> <?php esc_html_e('Case Link', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
									<?php if(in_array('group',$contact_columns_array)) { ?>
										<th><?php  esc_html_e('Group', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
									<?php if(in_array('address',$contact_columns_array)) { ?>
										<th><?php  esc_html_e('Address', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
									<?php if(in_array('contact_city',$contact_columns_array)) { ?>
										<th><?php  esc_html_e('City', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
									<?php if(in_array('contact_state',$contact_columns_array)) { ?>
										<th><?php  esc_html_e('State', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
									<?php if(in_array('job_title',$contact_columns_array)) { ?>
										<th><?php  esc_html_e('Job Title', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
									<?php if(in_array('gender',$contact_columns_array)) { ?>
										<th><?php  esc_html_e('Gender', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
									<?php if(in_array('pin_code',$contact_columns_array)) { ?>
										<th><?php  esc_html_e('Pincode', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
									<?php if(in_array('alternate_no',$contact_columns_array)) { ?>
										<th><?php  esc_html_e('Alternate Mobile No', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
									<?php if(in_array('phone_home',$contact_columns_array)) { ?>
										<th><?php  esc_html_e('Phone Home', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
									<?php if(in_array('phone_work',$contact_columns_array)) { ?>
										<th><?php  esc_html_e('Phone Work', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
									<?php if(in_array('fax',$contact_columns_array)) { ?>
										<th><?php  esc_html_e('Fax', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
									<?php if(in_array('license_no',$contact_columns_array)) { ?>
										<th><?php  esc_html_e('License No', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
									<?php if(in_array('website',$contact_columns_array)) { ?>
										<th><?php  esc_html_e('Website', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
									<?php if(in_array('contact_description',$contact_columns_array)) { ?>
										<th><?php  esc_html_e('Description', 'lawyer_mgt' ) ;?></th>
									<?php } ?>
									<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
								</tr>
								<br/>
							</thead>
							<tbody>
								<?php 
								$args = array(	
									'role' => 'client',
									'meta_key'     => 'archive',
									'meta_value'   => '0',
									'meta_compare' => '=',
								); 	
								$contactdata =get_users($args);		
								
								if(!empty($contactdata))
								{
									foreach ($contactdata as $retrieved_data)
									{							
										$contact_id= esc_attr($retrieved_data->ID);
										
										$contact_caselink=array();
										global $wpdb;
										$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
										$table_cases = $wpdb->prefix. 'lmgt_cases';
										$result_caselink= $wpdb->get_results("SELECT case_id FROM $table_case_contacts where user_id=".$contact_id);
										foreach ($result_caselink as $key => $object)
										{			
											$case_id=$object->case_id;
											$case_name= $wpdb->get_results("SELECT id,case_name FROM $table_cases where id=".$case_id);
											foreach ($case_name as $key => $object)
											{										
												$contact_caselink[]='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($object->id)).'">'.esc_attr($object->case_name).'</a>';
											}					
										}							
										$caselink=implode(',',$contact_caselink);

										?>
									
										<tr>
											<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->ID); ?>"></td>
									<?php if(in_array('photo',$contact_columns_array)) { ?>	
											<td class="user_image"><?php 
											$uid = esc_attr($retrieved_data->ID);
											$userimage=get_user_meta($uid, 'lmgt_user_avatar', true);
											if(empty($userimage))
											{
													echo '<img src='.esc_url(get_option( 'lmgt_system_logo' )).' height="50px" width="50px" class="img-circle" />';
											}
											else
													echo '<img src='.esc_url($userimage).' height="50px" width="50px" class="img-circle"/>';
										?>
											</td>
									 <?php } ?>	
									 <?php if(in_array('contact_name',$contact_columns_array)) { ?>
											<td class="name"><a href="?page=contacts&tab=viewcontact&action=view&contact_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>"><?php echo esc_html($retrieved_data->display_name);?></a></td>
									<?php } ?>	
									<?php if(in_array('date_of_birth',$contact_columns_array)) { ?>	
											<td class="company"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->birth_date));?></td>
									<?php } ?>	
									 
									<?php if(in_array('contact_email',$contact_columns_array)) { ?>		
											<td class="email"><?php echo esc_html($retrieved_data->user_email);?></td>
									<?php } ?>	
									<?php if(in_array('mobile_no',$contact_columns_array)) { ?>		
											<td class="mobile"><?php echo esc_html($retrieved_data->mobile);?></td>
									<?php } ?>	
									<?php if(in_array('contact_case_link',$contact_columns_array)) { ?>		
											<td class="caselink"><?php echo $caselink;?></td>
									<?php } ?>	
									<?php if(in_array('group',$contact_columns_array)) { ?>		
											<td class="contactgroup"><?php echo esc_html(get_the_title($retrieved_data->group));?></td>
									<?php } ?>	
									<?php if(in_array('address',$contact_columns_array)) { ?>
											<td class=""><?php echo esc_html($retrieved_data->address);?></td>
									<?php } ?>	
									<?php if(in_array('contact_city',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->city_name);?></td>
									<?php } ?>	
									<?php if(in_array('contact_state',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->state_name);?></td>
									<?php } ?>	
									<?php if(in_array('job_title',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->job_title);?></td>
									<?php } ?>	
									<?php if(in_array('gender',$contact_columns_array)) { ?>
											<td class=""><?php echo esc_html($retrieved_data->gender);?></td>
									<?php } ?>	
									<?php if(in_array('pin_code',$contact_columns_array)) { ?>
											<td class=""><?php echo esc_html($retrieved_data->pin_code);?></td>
									<?php } ?>	
									<?php if(in_array('alternate_no',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->alternate_mobile);?></td>
									<?php } ?>	
									<?php if(in_array('phone_home',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->phone_home);?></td>
									<?php } ?>	
									<?php if(in_array('phone_work',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->phone_work);?></td>
									<?php } ?>	
									<?php if(in_array('fax',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->fax);?></td>
									<?php } ?>	
									<?php if(in_array('license_no',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->license_number);?></td>
									<?php } ?>	
									<?php if(in_array('website',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->website);?></td>
									<?php } ?>	
									<?php if(in_array('contact_description',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->contact_description);?></td>
									<?php } ?>			
											<td class="action"> 
											<a href="?page=contacts&tab=viewcontact&action=view&contact_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
											<a href="?page=contacts&tab=add_contact&action=edit&contact_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
											<a href="?page=contacts&tab=contactlist&action=delete&contact_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>" class="btn btn-danger" 
											onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');">
											<?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>					
											</td>               
										</tr>
							<?php 	} 			
								} ?>     
							</tbody> 
						</table>
						<?php 
						if(!empty($contactdata))
							{
						?>
						<div class="form-group">		
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
								<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="user_delete_selected"  value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
							</div>
						</div>
							<?php } ?>
					</div>
				</div> 
				</form>	
			<?php
			}
			if($active_tab=='archived')
			{
			?>	
				<form name="wcwm_report" action="" method="post">
				<div class="panel-body">	
					<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">	
						<table id="contact_list2" class="contact_list2 table csv_data table-striped table-bordered width_100_per_css">
							<thead>	
								<tr>
								<?php if(in_array('photo',$contact_columns_array)) { ?>
									<th class="width_80_px_css"><?php  esc_html_e('Photo', 'lawyer_mgt' ) ;?></th>
								<?php } ?>
								<?php if(in_array('contact_name',$contact_columns_array)) { ?>
									<th><?php esc_html_e('Client Name', 'lawyer_mgt' ) ;?></th>
								<?php } ?>
								<?php if(in_array('date_of_birth',$contact_columns_array)) { ?>
									<th><?php esc_html_e('Date Of Birth', 'lawyer_mgt' ) ;?></th>
								<?php } ?>
								 
								<?php if(in_array('contact_email',$contact_columns_array)) { ?>
									<th> <?php esc_html_e('Client Email', 'lawyer_mgt' ) ;?></th>
								<?php } ?>
								<?php if(in_array('mobile_no',$contact_columns_array)) { ?>
									<th> <?php esc_html_e('Mobile Number', 'lawyer_mgt' ) ;?></th>
								<?php } ?>
								<?php if(in_array('contact_case_link',$contact_columns_array)) { ?>
									<th> <?php esc_html_e('Case Link', 'lawyer_mgt' ) ;?></th>
								<?php } ?>
								<?php if(in_array('group',$contact_columns_array)) { ?>
									<th><?php  esc_html_e('Group', 'lawyer_mgt' ) ;?></th>
								<?php } ?>
								<?php if(in_array('address',$contact_columns_array)) { ?>
									<th><?php  esc_html_e('Address', 'lawyer_mgt' ) ;?></th>
								<?php } ?>
								<?php if(in_array('contact_city',$contact_columns_array)) { ?>
									<th><?php  esc_html_e('City', 'lawyer_mgt' ) ;?></th>
								<?php } ?>
								<?php if(in_array('contact_state',$contact_columns_array)) { ?>
									<th><?php  esc_html_e('State', 'lawyer_mgt' ) ;?></th>
								<?php } ?>
								<?php if(in_array('job_title',$contact_columns_array)) { ?>
									<th><?php  esc_html_e('Job Title', 'lawyer_mgt' ) ;?></th>
								<?php } ?>
								<?php if(in_array('gender',$contact_columns_array)) { ?>
									<th><?php  esc_html_e('Gender', 'lawyer_mgt' ) ;?></th>
								<?php } ?>
								<?php if(in_array('pin_code',$contact_columns_array)) { ?>
									<th><?php  esc_html_e('Pincode', 'lawyer_mgt' ) ;?></th>
								<?php } ?>
								<?php if(in_array('alternate_no',$contact_columns_array)) { ?>
									<th><?php  esc_html_e('Alternate Mobile No', 'lawyer_mgt' ) ;?></th>
								<?php } ?>
								<?php if(in_array('phone_home',$contact_columns_array)) { ?>
									<th><?php  esc_html_e('Home Phone', 'lawyer_mgt' ) ;?></th>
								<?php } ?>
								<?php if(in_array('phone_work',$contact_columns_array)) { ?>
									<th><?php  esc_html_e('Work Phone', 'lawyer_mgt' ) ;?></th>
								<?php } ?>
								<?php if(in_array('fax',$contact_columns_array)) { ?>
									<th><?php  esc_html_e('Fax', 'lawyer_mgt' ) ;?></th>
								<?php } ?>
								<?php if(in_array('license_no',$contact_columns_array)) { ?>
									<th><?php  esc_html_e('License No', 'lawyer_mgt' ) ;?></th>
								<?php } ?>
								<?php if(in_array('website',$contact_columns_array)) { ?>
									<th><?php  esc_html_e('Website', 'lawyer_mgt' ) ;?></th>
								<?php } ?>
								<?php if(in_array('contact_description',$contact_columns_array)) { ?>
									<th><?php  esc_html_e('Description', 'lawyer_mgt' ) ;?></th>
								<?php } ?>		
									<th> <?php esc_html_e('Action', 'lawyer_mgt' ) ;?></th>			
								</tr>
								<br/>
							</thead>
							<tbody>
								<?php 		
								$args = array(	
								'role' => 'client',
								'meta_key'     => 'archive',
								'meta_value'   => '1',
								'meta_compare' => '=',
								); 	
								$contactdata =get_users($args);		
								if(!empty($contactdata))
								{
									foreach ($contactdata as $retrieved_data)
									{
										
										$contact_id=$retrieved_data->ID;
										
										$contact_caselink=array();
										global $wpdb;
										$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
										$table_cases = $wpdb->prefix. 'lmgt_cases';
										$result_caselink= $wpdb->get_results("SELECT case_id FROM $table_case_contacts where user_id=".$contact_id);
										
										foreach ($result_caselink as $key => $object)
										{			
											$case_id=$object->case_id;
											$case_name= $wpdb->get_results("SELECT id,case_name FROM $table_cases where id=".$case_id);
											foreach ($case_name as $key => $object)
											{	
												$contact_caselink[]='<a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.esc_attr($object->id).'">'.esc_html($object->case_name).'</a>';
											}					
										}							
										$caselink=implode(',',$contact_caselink);
										
										 
										?>
										<tr>
											<?php if(in_array('photo',$contact_columns_array)) { ?>	
											<td class="user_image"><?php $uid=$retrieved_data->ID;
											$userimage=get_user_meta($uid, 'lmgt_user_avatar', true);
											if(empty($userimage))
											{
													echo '<img src='.esc_url(get_option( 'lmgt_system_logo' )).' height="50px" width="50px" class="img-circle" />';
											}
											else
													echo '<img src='.esc_url($userimage).' height="50px" width="50px" class="img-circle"/>';
										?>
											</td>
									 <?php } ?>	
									 <?php if(in_array('contact_name',$contact_columns_array)) { ?>
											<td class="name"><a href="?page=contacts&tab=viewcontact&action=view&contact_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>"><?php echo esc_html($retrieved_data->display_name);?></a></td>
									<?php } ?>	
									<?php if(in_array('date_of_birth',$contact_columns_array)) { ?>	
											<td class="company"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->birth_date));?></td>
									<?php } ?>	
									 	
									<?php if(in_array('contact_email',$contact_columns_array)) { ?>		
											<td class="email"><?php echo esc_html($retrieved_data->user_email);?></td>
									<?php } ?>	
									<?php if(in_array('mobile_no',$contact_columns_array)) { ?>		
											<td class="mobile"><?php echo esc_html($retrieved_data->mobile);?></td>
									<?php } ?>	
									<?php if(in_array('contact_case_link',$contact_columns_array)) { ?>		
											<td class="caselink"><?php echo esc_html($caselink);?></td>
									<?php } ?>	
									<?php if(in_array('group',$contact_columns_array)) { ?>		
											<td class="contactgroup"><?php echo esc_html(get_the_title($retrieved_data->group));?></td>
									<?php } ?>	
									<?php if(in_array('address',$contact_columns_array)) { ?>
											<td class=""><?php echo esc_html($retrieved_data->address);?></td>
									<?php } ?>	
									<?php if(in_array('contact_city',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->city_name);?></td>
									<?php } ?>	
									<?php if(in_array('contact_state',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->state_name);?></td>
									<?php } ?>	
									<?php if(in_array('job_title',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->job_title);?></td>
									<?php } ?>	
									<?php if(in_array('gender',$contact_columns_array)) { ?>
											<td class=""><?php echo esc_html($retrieved_data->gender);?></td>
									<?php } ?>	
									<?php if(in_array('pin_code',$contact_columns_array)) { ?>
											<td class=""><?php echo esc_html($retrieved_data->pin_code);?></td>
									<?php } ?>	
									<?php if(in_array('alternate_no',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->alternate_mobile);?></td>
									<?php } ?>	
									<?php if(in_array('phone_home',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->phone_home);?></td>
									<?php } ?>	
									<?php if(in_array('phone_work',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->phone_work);?></td>
									<?php } ?>	
									<?php if(in_array('fax',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->fax);?></td>
									<?php } ?>	
									<?php if(in_array('license_no',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->license_number);?></td>
									<?php } ?>	
									<?php if(in_array('website',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->website);?></td>
									<?php } ?>	
									<?php if(in_array('contact_description',$contact_columns_array)) { ?>		
											<td class=""><?php echo esc_html($retrieved_data->contact_description);?></td>
									<?php } ?>
											  <td class="action">
												<a href="?page=contacts&tab=viewcontact&action=view&contact_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
											  </td>		
										</tr>
									<?php 
									}					
								} 
								?>     
							</tbody> 
						</table>
				   </div>
				</div> 
				</form>	
		<?php	
			}
		}
		?>
   </div>			
</div><!-- END PANEL ROW DIV -->