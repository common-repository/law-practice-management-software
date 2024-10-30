<?php 
$note=new MJ_lawmgt_Note;
?>
<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="company_list">
			</div>
		</div>
    </div> 
</div>
<!-- End POP-UP Code -->
<script type="text/javascript">
    var $ = jQuery.noConflict();
	jQuery(document).ready(function($)
	{
		"use strict";
		jQuery('#note_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
		
		var date = new Date();
        date.setDate(date.getDate()-0);
		jQuery('.date1').datepicker
		({
			startDate: date,
            autoclose: true
		});		
	}); 
	jQuery(document).ready(function($)
	{	 
        "use strict";	
		$('#assigned_to_user').multiselect({
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>'
			},
			buttonWidth: '50%',
			nonSelectedText :'<?php esc_html_e('Select Client Name','lawyer_mgt');?>',
			selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
			enableFiltering: true,
			filterBehavior: 'text',
			enableCaseInsensitiveFiltering: true,
			includeSelectAllOption: true ,
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>',
				filter: '<li class="multiselect-item filter"><div class="input-group m-0 mb-1"><input class="form-control multiselect-search" type="text"></div></li>',
				filterClearBtn: '<div class="input-group-append"><button class="btn btn btn-outline-secondary multiselect-clear-filter" type="button"><i class="fa fa-times"></i></button></div>'
			}
			});
		$(".submitnote").on("click",function()
		{	
			var checked = $(".multiselect_validation .dropdown-menu input:checked").length;

			if(!checked)
			{
				 
				 alert("<?php esc_html_e('Please select atleast one Client Name','lawyer_mgt');?>");
				return false;
			}			
		});	 		
	});
	jQuery(document).ready(function($)
	{
        "use strict";		
		$('#assign_to_attorney').multiselect({
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>'
			},
			buttonWidth: '50%',
			nonSelectedText :'<?php esc_html_e('Select Attorney Name','lawyer_mgt');?>',
			selectAllText : '<?php esc_html_e('Select all','lawyer_mgt'); ?>',
			enableFiltering: true,
			filterBehavior: 'text',
			enableCaseInsensitiveFiltering: true,
			includeSelectAllOption: true ,
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>',
				filter: '<li class="multiselect-item filter"><div class="input-group m-0 mb-1"><input class="form-control multiselect-search" type="text"></div></li>',
				filterClearBtn: '<div class="input-group-append"><button class="btn btn btn-outline-secondary multiselect-clear-filter" type="button"><i class="fa fa-times"></i></button></div>'
			}
			});
		 
		$(".submitnote").on("click",function()
		{	
			var checked = $(".multiselect_validation123 .dropdown-menu input:checked").length;

			if(!checked)
			{
				 
				alert("<?php esc_html_e('Please select atleast one Attorney Name','lawyer_mgt');?>");
				return false;
			}			
		}); 
	});	
</script>	
<?php 	
if($active_tab == 'note')
{
	$active_tab = isset($_GET['tab3'])?$_GET['tab3']:'notelist';
	?>
	<h2>
		<ul id="myTab" class="sub_menu_css line nav nav-tabs" role="tablist">
				<li role="presentation" class="<?php echo esc_html($active_tab) == 'notelist' ? 'active' : ''; ?>">
					<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=note&tab3=notelist&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
						<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Note List', 'lawyer_mgt'); ?>
					</a>
				</li>
				<?php if(isset($_REQUEST['editnote']) && sanitize_text_field($_REQUEST['editnote']) == 'true') { ?>
				<li role="presentation" class="<?php echo esc_html($active_tab) == 'addnote' ? 'active' : ''; ?>">
					<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=note&tab3=addnote&editnote=true&case_id=<?php echo esc_attr($_REQUEST['case_id']); ?>&id=<?php echo esc_attr($_REQUEST['id']);?>">
						<?php echo esc_html__('Edit Note', 'lawyer_mgt'); ?>
					</a>
				</li>
				<?php }else{?>
				<li role="presentation" class="<?php echo esc_html($active_tab) == 'addnote' ? 'active' : ''; ?>">
					<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=note&tab3=addnote&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
						<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Note', 'lawyer_mgt'); ?>
					</a>
				</li>
				<?php }
				if(isset($_REQUEST['viewnote'])&& sanitize_text_field($_REQUEST['viewnote'])=='true') {?>
				<li role="presentation" class="<?php echo esc_html($active_tab) == 'viewnote' ? 'active' : ''; ?>">
					<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=note&tab3=viewnote&viewnote=true&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&note_id=<?php echo esc_attr($_REQUEST['note_id']);?>">
						<?php echo esc_html__('View Note', 'lawyer_mgt'); ?>
					</a>
				</li>
				<?php } ?>
		</ul> 
	</h2>
	<?php
	if($active_tab=='viewnote')
	{
		require_once LAWMS_PLUGIN_DIR. '/admin/cases/view_case_notes.php';
	}
	if($active_tab=='addnote')
	{		
		$note_id=0;
		$edt=0;
		if(isset($_REQUEST['id']))
			$note_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id']));
			$casedata='';
			if(isset($_REQUEST['editnote']) && sanitize_text_field($_REQUEST['editnote']) == 'true')
			{					
				$edt=1;
				$casedata=$note->MJ_lawmgt_get_signle_note_by_id($note_id);
			}?>
		<div class="panel-body">  <!--PANEL BODY DIV -->   
			<form name="note_form" action="" method="post" class="form-horizontal" id="note_form" enctype='multipart/form-data'>	
			   <?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
			   <input id="action" class="form-control  text-input" type="hidden"  value="<?php echo esc_attr($action); ?>" name="action">
				 
				<div class="header">	
					<h3 class="first_hed"><?php esc_html_e('Linked To','lawyer_mgt');?></h3>
					<hr>
				</div>
				<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="case_link"><?php esc_html_e('Case Name','lawyer_mgt');?><span class="require-field">*</span></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12  has-feedback">
						<?php 
						global $wpdb;
						$table_case = $wpdb->prefix. 'lmgt_cases';						
						$result = $wpdb->get_row("SELECT * FROM $table_case where id=".sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id'])));
						?>
						<input id="case_id" class="form-control   validate[required] text-input" type="hidden"  value="<?php echo esc_attr($result->id); ?>" name="case_id">
						<input id="case_name" class="form-control   validate[required] text-input" type="text"  value="<?php echo esc_attr($result->case_name); ?>" name="case_name" readonly>
					</div>
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="practice_area_id"><?php esc_html_e('Practice Area','lawyer_mgt');?></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12  has-feedback">
					<?php if($edt){ $data=$casedata->practice_area_id;}else{ $data=''; }
						$obj_practicearea=new MJ_lawmgt_practicearea;
					?>
						<input type="hidden" class="form-control" value="<?php echo esc_attr($result->practice_area_id);?>" name="practice_area_id" id="practice_area_id" readonly />
						<input type="text" class="form-control" value="<?php echo esc_attr(get_the_title($result->practice_area_id)); ?>" name="practice_area_id1" id="practice_area_id1" readonly />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="assigned_to_user"><?php esc_html_e('Client Name','lawyer_mgt');?><span class="require-field">*</span></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12  has-feedback multiselect_validation">
						<?php if($edt){ $data= esc_attr($casedata->assigned_to_user);}elseif(isset($_POST['assigned_to_user'])){ $data= sanitize_text_field($_POST['assigned_to_user']); }?>
							<?php $conats=explode(',',$data);
							   $Editdata=MJ_lawmgt_get_user_by_edit_case_id(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id'])));
							?>
							<select class="form-control validate[required] assigned_to_user" multiple="multiple" name="assigned_to_user[]" id="assigned_to_user">				
								<?php 
								foreach($Editdata as $Editdata1)
								{
									$userdata=get_userdata($Editdata1->user_id);
									$user_name= esc_attr($userdata->display_name);	
								?>
								<option value="<?php print esc_attr($Editdata1->user_id);?>" <?php echo in_array($Editdata1->user_id,explode(',',$data)) ? 'selected': ''; ?>>
									<?php echo esc_html($user_name);?>
								</option>
								<?php 
								 }
								 ?>
							</select>
					</div>
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="assigned_to_attorney"><?php esc_html_e('Attorney Name','lawyer_mgt');?><span class="require-field">*</span></label>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback multiselect_validation123">
						<?php if($edt){ $data=$casedata->assign_to_attorney;}elseif(isset($_POST['assign_to_attorney'])){ $data=sanitize_text_field($_POST['assign_to_attorney']); }?>
							<?php 
									global $wpdb;
									$table_case = $wpdb->prefix. 'lmgt_cases';													
									$userdata = $wpdb->get_results("SELECT case_assgined_to FROM $table_case where id=".sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id'])));
									 
									$user_array=$userdata[0]->case_assgined_to;
									  
									$newarraay=explode(',',$user_array);
									 
								?>
							<select class="form-control validate[required] assign_to_attorney" multiple="multiple" name="assign_to_attorney[]" id="assign_to_attorney">				
								<?php 
								if(!empty($newarraay))
								{
									foreach ($newarraay as $retrive_data)
									{ 
									$user_details=get_userdata($retrive_data);
									$user_name= esc_attr($user_details->display_name);
									?>
										<option value="<?php print esc_attr($user_details->ID);?>" <?php echo in_array($user_details->ID,explode(',',$data)) ? 'selected': ''; ?>>
											<?php echo esc_html($user_name);?>
										</option>
									<?php 
									}
								} ?>
							</select>
						</div>
				</div>
				<?php wp_nonce_field( 'save_case_note_nonce' ); ?>
				<div class="header">
					<h3><?php esc_html_e('Note Information','lawyer_mgt');?></h3>
					<hr>
				</div>
				<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="note_name"><?php esc_html_e('Note Name','lawyer_mgt');?><span class="require-field">*</span></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12  has-feedback">
						<input id="note_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]],maxSize[50]] text-input onlyletter_number_space_validation"  type="text" placeholder="<?php esc_html_e('Enter Note Name','lawyer_mgt');?>" value="<?php if($edt){ echo esc_attr($casedata->note_name);}elseif(isset($_POST['note_name'])){ echo esc_attr($_POST['note_name']); } ?>" name="note_name">
					</div>
				</div>	
				<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label control-label" for="note"><?php esc_html_e('Note','lawyer_mgt');?><span class="require-field"></span></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12  has-feedback">
						<?php 
						 $setting=array(
						 'media_buttons' => false,
						 'quicktags' => false,
						 'textarea_rows' => 10,
						 );
						 if($edt)
						 {
							wp_editor(stripslashes($casedata->note),'note',$setting); 
						 }
						 else
						 {
							wp_editor("",'note',$setting); 
						 }
						 ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="date_time"><?php esc_html_e('Date','lawyer_mgt');?><span class="require-field">*</span></label>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12  has-feedback">
					 <input id="date_time" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="date1 form-control validate[required]  has-feedback-left " type="text"  name="date_time"  placeholder=""
					value="<?php if($edt){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($casedata->date_time));}else{ echo  date("Y/m/d");}?>" readonly>
					<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
					</div>					
				</div>
			   <div class="form-group margin_top_div_css1">
				<div class="offset-sm-2 col-sm-8">
				  <input type="submit" id="" name="savenote" class="btn btn-success submitnote" value="<?php if($edt){
				   esc_attr_e('Save Note','lawyer_mgt');}else{ esc_attr_e('Add Note','lawyer_mgt');}?>"></input>
				</div>
				</div>
			</form>
		</div><!--END PANEL BODY DIV --> 
	<?php 
	}
	if($active_tab=='notelist')
	{?>
		<script type="text/javascript">
		var $ = jQuery.noConflict();
			jQuery(document).ready(function($)
			{
				"use strict";
				jQuery('#note_list111').DataTable({
					"responsive": true,
					"autoWidth": false,
					"order": [[ 1, "asc" ]],
					language:<?php echo wpnc_datatable_multi_language();?>,
					 "aoColumns":[
								  {"bSortable": false},
								  {"bSortable": false},
								  {"bSortable": true},
								  {"bSortable": true},
								  {"bSortable": true},
								  {"bSortable": true},
								  {"bSortable": true},
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
			});		
			jQuery(document).ready(function($) 
			{
				"use strict";
				jQuery('#note_list').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
			});
		</script>
		<form name="" action="" method="post" enctype='multipart/form-data'>
		<div class="panel-body">
			<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">	
				<table id="note_list111" class="tast_list1 table table-striped table-bordered">
					<thead>	
					<?php
					if(isset($_REQUEST['case_id']))
						$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
						$notedata=$note->MJ_lawmgt_get_note_by_caseid($case_id); ?>
					<tr>
						<th><input type="checkbox" id="select_all"></th>
						<th><?php  esc_html_e('Note Name', 'lawyer_mgt' ) ;?></th>
						<th><?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
						<th><?php esc_html_e('Practice Area', 'lawyer_mgt' ) ;?></th>
						<th> <?php esc_html_e('Client Name', 'lawyer_mgt' ) ;?></th>
						<th> <?php esc_html_e('Attorney Name', 'lawyer_mgt' ) ;?></th>
						<th> <?php esc_html_e('Date', 'lawyer_mgt' ) ;?></th>
						<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
					</tr>
					<br/>
				</thead>
				<tbody>
					<?php
					if(!empty($notedata))
					{
						foreach ($notedata as $retrieved_data)
						{
							$case_name=MJ_lawmgt_get_case_name_by_id($retrieved_data->case_id);
							foreach($case_name as $case_name1)
							{
								$case_name2= sanitize_text_field($case_name1->case_name);
							}
						
							 $user_id= sanitize_text_field($retrieved_data->assigned_to_user);
							 $contac_id=explode(',',$user_id);
							 $conatc_name=array();
							foreach($contac_id as $contact_name) 
							{	
								$userdata=get_userdata($contact_name);
								$conatc_name[]='<a href="?page=contacts&tab=add_contact&action=view&contact_id='.MJ_lawmgt_id_encrypt(esc_attr($userdata->ID)).'">'.esc_attr($userdata->display_name).'</a>';										   				   
							}
							$attorney=$retrieved_data->assign_to_attorney;
							$attorney_name=explode(',',$attorney);
							$attorney_name1=array();
							foreach($attorney_name as $attorney_name2) 
							{
								$attorneydata=get_userdata($attorney_name2);	
								$attorney_name1[]='<a href="?page=attorney&tab=view_attorney&action=view&attorney_id='.MJ_lawmgt_id_encrypt(esc_attr($attorneydata->ID)).'">'.esc_attr($attorneydata->display_name).'</a>';										   
							}
							?>
							<tr>
								<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->note_id); ?>"></td>												
								 <td class="email"><a href="admin.php?page=cases&tab=casedetails&action=view&tab2=note&tab3=viewnote&viewnote=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&note_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->note_id));?>"><?php echo esc_html($retrieved_data->note_name);?></a></td>
								 <td class="prac_area"><a href="?page=cases&tab=casedetails&action=view&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>"><?php echo esc_html($case_name2); ?></a></td>	
								 <td class="added"><?php echo  esc_html(get_the_title($retrieved_data->practice_area_id));?></td>	
								 <td class="added"><?php echo implode(',',$conatc_name);?></td>
								 <td class="added"><?php echo implode(',',$attorney_name1);?>
								 <td class="added"><?php echo  esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->date_time));?></td>
								 <td class="action"> 	
								<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=note&tab3=viewnote&viewnote=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&note_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->note_id));?>" class="btn btn-success"> <?php esc_html_e('view', 'lawyer_mgt' ) ;?></a>							 
								<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=note&tab3=addnote&editnote=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->note_id));?>" id="ediit" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>					
								<a href="?page=cases&tab=casedetails&action=view&editats=true&deletenote=true&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>&note_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->note_id));?>" class="btn btn-danger" 
									onclick="return confirm('<?php esc_html_e('Are you sure you want to Delete this Note ?','lawyer_mgt');?>');">
								  <?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>					
								  </td>               
							</tr>
				<?php 	} 			
					} ?>     
				</tbody>   
			</table>
			<?php  if(!empty($notedata))
					{
			?>
			<div class="form-group">		
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
					<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="note_delete_selected" value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
				</div>
			</div>
				<?php } ?>
		</div>
     </div> 
	</form>	
	 <?php 
	}	  
}
 ?>	