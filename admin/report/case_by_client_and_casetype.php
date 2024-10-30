<?php  
$obj_case=new  MJ_lawmgt_case;
?>
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		"use strict";
		$('#invoice_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
		 
		$('.sdate').datepicker({			 
			autoclose: true
		}).on('changeDate', function(){
			$('.edate').datepicker('setStartDate', new Date($(this).val()));
		}); 
		 
		$('.edate').datepicker({			 
			autoclose: true
		}).on('changeDate', function(){
			$('.sdate').datepicker('setEndDate', new Date($(this).val()));
		});
		 
	});
</script>
<div class="panel-body">
	<form method="post" id="invoice_form"> 
		<div class="form-group col-md-12" >
			
			<label  class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('Client Name','lawyer_mgt');?></label>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
				<select class="form-control" name="client_name" id="client_name">	
					<option value=""><?php esc_html_e('Select Client Name','lawyer_mgt');?></option>
					<?php
							$contactdata=get_users(array('role' => 'client',
												)
											);
								if(!empty($contactdata))
								{
									foreach($contactdata as $retrive_data)
									{  				
								?>						
										<option value="<?php echo esc_attr($retrive_data->ID);?>"><?php echo esc_html($retrive_data->display_name);?> </option>
								<?php }	
								}
						?> 			
				</select>
			</div>
			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css1" for="exam_id"><?php esc_html_e('Practice Area','lawyer_mgt');?></label>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" > 	
				<select class="form-control" name="case_type" id="case_type">	
					<option value=""><?php esc_html_e('Select Practice Area','lawyer_mgt');?></option>
					<?php
							$case_data1=$obj_case->MJ_lawmgt_get_all_practicearea();
							
							if(!empty($case_data1))
							{
								foreach($case_data1 as $retrive_data)
								{  				
							?>						
									<option value="<?php echo esc_attr($retrive_data->practice_area_id);?>"><?php echo esc_html(get_the_title($retrive_data->practice_area_id));?> </option>
							<?php }	
							}
						?> 			
				</select>
			</div>
		</div>
		<div class="form-group col-md-2 margin_top_custome">
			<label for="subject_id">&nbsp;</label>
			<input type="submit" name="case_report" Value="<?php esc_attr_e('Go','lawyer_mgt');?>"  class="btn btn-success"/>
		</div>
	</form>
</div>
<?php
	if(isset($_POST['case_report']))
	{ ?>
		<script type="text/javascript">
			jQuery(document).ready(function($)
			{
				"use strict";
				jQuery('#case_data_list').DataTable({
					"responsive": true,
					"autoWidth": false,
					"order": [[ 1, "asc" ]],
					language:<?php echo wpnc_datatable_multi_language();?>,
					 "aoColumns":[
								  {"bSortable": true},
								  {"bSortable": true},
								  {"bSortable": true},
								  {"bSortable": true},
								  {"bSortable": true},
								  {"bSortable": true},
								  {"bSortable": true},
								  {"bSortable": true}
							   ]		               		
					});	
			});
			jQuery(document).ready(function($) 
			{
				"use strict";
				jQuery('#note_list').validationEngine();
			});
		</script>	
		<div class="tab-pane  tabs fade  active in" id="nav-open" role="tabpanel" aria-labelledby="nav-open-tab">
			<form name="" action="" method="post" enctype='multipart/form-data'>
				<div class="panel-body">
					<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">	
						<table id="case_data_list" class="case_data_list table table-striped table-bordered">
							<thead>	
								<?php  ?>
								<tr>
									<th><?php  esc_html_e('Case Number', 'lawyer_mgt' ) ;?></th>
									<th><?php  esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
									<th><?php  esc_html_e('Open Date', 'lawyer_mgt' ) ;?></th>
									<th><?php  esc_html_e('Practice Area', 'lawyer_mgt' ) ;?></th>
									<th><?php  esc_html_e('Court Details', 'lawyer_mgt' ) ;?></th>
									<th><?php  esc_html_e('Client Link', 'lawyer_mgt' ) ;?></th>
									<th> <?php esc_html_e('Attorney Name', 'lawyer_mgt' ) ;?></th>
									<th> <?php esc_html_e('Billing Client Name', 'lawyer_mgt' ) ;?></th>
								</tr>
								<br/>
							</thead>
							<tbody>
								<?php
								$or=array();
								$or['user_id ='] = (!empty($_REQUEST['client_name']))?sanitize_text_field($_REQUEST['client_name']):NULL;
								$or['practice_area_id ='] = (!empty($_REQUEST['case_type']))?sanitize_text_field($_REQUEST['case_type']):NULL;
								 
								$keys = array_keys($or,"");	
								foreach ($keys as $k)
								{
									
									unset($or[$k]);
								}
							 
							 
								if(!empty($or))
								{
									 
									$case_data=$obj_case->MJ_lawmgt_get_all_case_by_clientname_and_casetype($or);
								}
								 
								if(!empty($case_data))
								{	
								 							
									foreach ($case_data as $retrieved_data)
									{
										?>
										<tr> 
										
											<td><?php echo esc_html($retrieved_data->case_number);?></td>
											<td><?php echo esc_html($retrieved_data->case_name);?></td>
											<td><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->open_date));?></td>
											<td><?php echo esc_html(get_the_title($retrieved_data->practice_area_id));?></td>
											<td><?php echo esc_html(get_the_title($retrieved_data->court_id)); ?> - <?php echo esc_html(get_the_title($retrieved_data->state_id)); ?> - <?php echo esc_html(get_the_title($retrieved_data->bench_id)); ?></td>
											<td><?php
												$result=get_userdata($retrieved_data->user_id);
												echo esc_html($result->display_name);?>
											</td>
											<td><?php
												$user=explode(",",$retrieved_data->case_assgined_to);
												$case_assgined_to=array();
												if(!empty($user))
												{						
													foreach($user as $data4)
													{
														$case_assgined_to[]=MJ_lawmgt_get_display_name($data4);
													}
												}												
												echo esc_html(implode(", ",$case_assgined_to));
												?>
											</td>
											<td><?php
												$result2=get_userdata($retrieved_data->billing_contact_id);
												echo esc_html($result2->display_name);?>
											</td>
											 
										</tr>
								<?php 
									} 			
								} ?>     
							</tbody>
						</table>
					</div>
				</div>       
			</form>
		</div>
	<?php 
	}
?>