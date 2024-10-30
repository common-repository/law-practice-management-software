<?php  
$obj_case=new  MJ_lawmgt_case;
?>
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		"use strict";
		$('#case_reports').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
		 
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
	    <form method="post" id="case_reports">  
		<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css date_css_new" for="exam_id"><?php esc_html_e('Start Date','lawyer_mgt');?><span class="require-field">*</span></label>
		<div class="form-group col-md-2" >
			<input type="text" data-date-format="<?php echo esc_html(MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format')));?>"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>"  class="form-control sdate has-feedback-left validate[required]" name="sdate" 
			value="<?php if(isset($_REQUEST['sdate'])) echo sanitize_text_field($_REQUEST['sdate']);?>" readonly>
			<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>	
		</div>
		<label  class="col-lg-2 col-md-2 col-sm-2 col-xs-12 date_css date_css_new" for="exam_id"><?php esc_html_e('End Date','lawyer_mgt');?><span class="require-field">*</span></label>
		<div class="form-group col-md-2" >
				<input type="text"  class="form-control edate has-feedback-left validate[required]" data-date-format="<?php echo esc_html(MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format')));?>"  placeholder="<?php esc_html_e('Select Date','lawyer_mgt');?>" name="edate" 
				value="<?php if(isset($_REQUEST['edate'])) echo sanitize_text_field($_REQUEST['edate']);?>" readonly>
		<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>			
		</div>
		<div class="form-group col-md-2">
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
									<th><?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
									<th><?php esc_html_e('Open Date', 'lawyer_mgt' ) ;?></th>
									<th><?php  esc_html_e('Practice Area', 'lawyer_mgt' ) ;?></th>
									<th><?php  esc_html_e('Court Details', 'lawyer_mgt' ) ;?></th>
									<th><?php  esc_html_e('Client Link', 'lawyer_mgt' ) ;?></th>
									<th> <?php esc_html_e('Attorney Name', 'lawyer_mgt' ) ;?></th>
									<th> <?php esc_html_e('Case Status', 'lawyer_mgt' ) ;?></th>
									<th> <?php esc_html_e('Billing Client Name', 'lawyer_mgt' ) ;?></th>
								</tr>
								<br/>
							</thead>
							<tbody>
								<?php
								$or=array();
								$or['open_date >='] = ($_REQUEST['sdate'] != "")?sanitize_text_field(date("Y-m-d",strtotime($_REQUEST['sdate']))):NULL;
								$or['open_date <='] = ($_REQUEST['edate'] != "")?sanitize_text_field(date("Y-m-d",strtotime($_REQUEST['edate']))):NULL;
								 
								$keys = array_keys($or,"");	
								foreach ($keys as $k)
								{
									
									unset($or[$k]);
								}
							 
								if(!empty($or))
								{

									$case_data=$obj_case->MJ_lawmgt_get_all_case_by_additioncase_and_disposalcase_admin($or);
									
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
											<td><?php echo esc_html($retrieved_data->case_status);?></td>
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