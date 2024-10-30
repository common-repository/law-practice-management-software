<?php 
 $obj_cause=new Lmgtcauselist;
 $active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'cause_list');
$result=null;
?>
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV -->
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' )); ?></h3>
	  </div>
	</div>
	 <?php
	if(isset($_POST['daily_causelist']))
	{
		 $causedata=$obj_cause->MJ_lawmgt_get_current_date_causelist();
		if(!empty($causedata))
		{
			$header = array();			
			$header[] =  esc_html__('Case Name','lawyer_mgt');
			$header[] =  esc_html__('Attorney Name','lawyer_mgt');
			$header[] =  esc_html__('Court Name','lawyer_mgt');
			$header[] =  esc_html__('State Name','lawyer_mgt');
			$header[] =  esc_html__('Bench Name','lawyer_mgt');
			
			$filename='Reports/export_causelist.csv';
			$fh = fopen(LAWMS_PLUGIN_DIR.'/admin/'.$filename, 'w') or die("can't open file");
			fputcsv($fh, $header);
			
			foreach($causedata as $retrive_data)
			{
				$case_name=MJ_lawmgt_get_case_name_by_id($retrive_data->id);
				foreach($case_name as $case_name1)
				{
					$case_name2=$case_name1->case_name;
				}
				 
				$row = array();	
				$row[] = esc_html($case_name2);
				$user=explode(",",$retrive_data->case_assgined_to);
				$case_assgined_to=array();
				if(!empty($user))
				{						
					foreach($user as $data4)
					{
						$case_assgined_to[]=MJ_lawmgt_get_display_name($data4);
					}
				}			
				$row[] =esc_html(implode(", ",$case_assgined_to));
				$row[] = esc_html(get_the_title(esc_html($retrive_data->court_id)));
				$row[] = esc_html(get_the_title(esc_html($retrive_data->state_id)));
				$row[] = esc_html(get_the_title(esc_html($retrive_data->bench_id)));
				
				fputcsv($fh, $row);
			}
			fclose($fh);
	
			//download csv file.
			$file=LAWMS_PLUGIN_DIR.'/admin/Reports/export_causelist.csv';//file location
			header('Content-Type:application/force-download');
			header('Pragma: public');       // required
			header('Expires: 0');           // no cache
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file)).' GMT');
			header('Cache-Control: private',false);
			 header("Content-Type: application/vnd.ms-excel");
			header('Content-Disposition: attachment; filename="'.basename($file).'"');
			header('Content-Transfer-Encoding: binary');
			header('Connection: close');
			readfile($file);		
			exit;			
		}
	}	
	
	if(isset($_POST['weekly_causelist']))
	{
		$causedata=$obj_cause->MJ_lawmgt_get_weekly_causelist();
		 		
		if(!empty($causedata))
		{
			$header = array();			
			$header[] =  esc_html__('Case Name','lawyer_mgt');
			$header[] =  esc_html__('Attorney Name','lawyer_mgt');
			$header[] =  esc_html__('Court Name','lawyer_mgt');
			$header[] =  esc_html__('State Name','lawyer_mgt');
			$header[] =  esc_html__('Bench Name','lawyer_mgt');
			
			$filename='Reports/export_causelist_weekly.csv';
			$fh = fopen(LAWMS_PLUGIN_DIR.'/admin/'.$filename, 'w') or die("can't open file");
			fputcsv($fh, $header);
			
			//echo $name;
			foreach($causedata as $retrive_data)
			{
				$case_name=MJ_lawmgt_get_case_name_by_id($retrive_data->id);
				foreach($case_name as $case_name1)
				{
					$case_name2=$case_name1->case_name;
				}
				 
				$row = array();	
				$row[] = esc_html($case_name2);
				$user=explode(",",$retrive_data->case_assgined_to);
				$case_assgined_to=array();
				if(!empty($user))
				{						
					foreach($user as $data4)
					{
						$case_assgined_to[]=MJ_lawmgt_get_display_name($data4);
					}
				}		
				$row[] = esc_html(implode(", ",$case_assgined_to));
				$row[] = esc_html(get_the_title($retrive_data->court_id));
				$row[] = esc_html(get_the_title($retrive_data->state_id));
				$row[] = esc_html(get_the_title($retrive_data->bench_id));
				
				fputcsv($fh, $row);
			}
			fclose($fh);
	
			//download csv file.
			$file=LAWMS_PLUGIN_DIR.'/admin/Reports/export_causelist_weekly.csv';//file location
			header('Content-Type:application/force-download');
			header('Pragma: public');       // required
			header('Expires: 0');           // no cache
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file)).' GMT');
			header('Cache-Control: private',false);
			 header("Content-Type: application/vnd.ms-excel");
			header('Content-Disposition: attachment; filename="'.basename($file).'"');
			header('Content-Transfer-Encoding: binary');
			header('Connection: close');
			readfile($file);		
			exit;			
		}
	}	
	 ?>
	<div id="main-wrapper"><!-- MAIN WRAPER  DIV -->
		<div class="row"><!--  ROW DIV   --> 
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white"><!-- PANEL WHITE  DIV -->
					<div class="panel-body"><!-- PANEL BODY  DIV -->
						<h2 class="nav-tab-wrapper margin_bottom_zero">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="cause_list">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'cause_list' ? 'active' : ''; ?> menucss">
									<a href="?page=causelist&tab=cause_list">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Cause List', 'lawyer_mgt'); ?>
									</a>
								</li>
							</ul>
					   </h2>
					   <?php
						if($active_tab == 'cause_list')
						{ ?>
							<script type="text/javascript">
							var $ = jQuery.noConflict();
								jQuery(document).ready(function($)
								{
								    "use strict";
									jQuery('#cause_list_table').DataTable({
										"responsive": true,
										"autoWidth": false,
										"order": [[ 1, "asc" ]],
										language:<?php echo wpnc_datatable_multi_language();?>,
										 "aoColumns":[								  
													  {"bSortable": true},
													  {"bSortable": true},
													  {"bSortable": true},
													  {"bSortable": true},
													  {"bSortable": true}
													 
												   ]		               		
										});	
								} );
								 
								jQuery(document).ready(function($) 
								{
									"use strict";
									jQuery('#tast_list').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
								});
							</script>	
							 
							<div class="tab-pane  tabs fade  active in" id="nav-open" role="tabpanel" aria-labelledby="nav-open-tab">
							<div class="panel-body">
								<form name="tast_list" id="tast_list" action="" method="post" enctype='multipart/form-data'>
								<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 margin_bottom_cuase">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-6 control-label court_lable"><b><?php esc_html_e('Select Court:','lawyer_mgt');?></b></label>
										<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">			
											<select class="form-control court_filter validate[required]" name="court_id" id="">
											<option value="all"><?php esc_html_e('All','lawyer_mgt');?></option>
											<?php 
													$court_category=MJ_lawmgt_get_all_category('court_category');
													if(!empty($court_category))
													{
														foreach ($court_category as $retrive_data)
														{
															echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected($retrive_data->ID).'>'.esc_html($retrive_data->post_title).'</option>';
														}
													} ?>
											</select>
										</div>
								</div>
								<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<table id="cause_list_table" class="cause_list_table table table-striped table-bordered">
										<thead>	
											<tr>
												<th><?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
												<th> <?php esc_html_e('Attorney Name', 'lawyer_mgt' ) ;?></th>
												<th> <?php esc_html_e('Court Name', 'lawyer_mgt' ) ;?></th>
												<th> <?php esc_html_e('State Name', 'lawyer_mgt' ) ;?></th>
												<th> <?php esc_html_e('Bench Name', 'lawyer_mgt' ) ;?></th>
											</tr>
											<br/>
										</thead>
										<tbody>
											<?php
											$causedata=$obj_cause->MJ_lawmgt_get_current_date_causelist();
											if(!empty($causedata))
											{										
												foreach ($causedata as $retrieved_data)
												{
													$case_name=MJ_lawmgt_get_case_name_by_id($retrieved_data->id);
													foreach($case_name as $case_name1)
													{
														$case_name2=$case_name1->case_name;
													}
													$user=explode(",",$retrieved_data->case_assgined_to);
													$attorney_name=array();
													if(!empty($user))
													{						
														foreach($user as $data4)
														{
															$attorney_name[]=MJ_lawmgt_get_display_name($data4);
														}
													}															
													$court_name=get_the_title($retrieved_data->court_id);
													$state_name=get_the_title($retrieved_data->state_id);
													$bench_name=get_the_title($retrieved_data->bench_id);
													?>
													<tr>
														<td class="prac_area"><a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>"><?php echo esc_html($case_name2); ?></a></td>	
														<td><?php echo  esc_html(implode(", ",$attorney_name));?></td>					 
														<td class="added"><?php echo  esc_html($court_name);?></td>
														<td class="added"><?php echo  esc_html($state_name);?></td> 
														<td class="added"><?php echo  esc_html($bench_name);?></td> 
													</tr>
											<?php 
												} 			
											}  
											?>     
										</tbody>   
									</table>
									<?php
									if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
									{
										?>
										<input type="submit" class="btn delete_margin_bottom btn-primary dawnlod_botttom" name="daily_causelist" value="<?php esc_attr_e('Download Daily Causelist', 'lawyer_mgt' ) ;?> " />
										<input type="submit" class="btn delete_margin_bottom btn-primary dawnlod_botttom" name="weekly_causelist" value="<?php esc_attr_e('Download Weekly Causelist', 'lawyer_mgt' ) ;?> " />
										<?php
									}
									?>
								</div>
							 </div>       	
							</form>
							</div>
							<?php 
						} ?>
					</div>	<!-- PANEL BODY  DIV -->
				</div>	<!-- ENDPANEL WHITE  DIV -->
			</div>
		</div><!--  END ROW DIV   --> 
 	</div><!-- 	END MAIN WRAPER DIV   --> 
</div><!-- END  PAGE INNER DIV --> 	