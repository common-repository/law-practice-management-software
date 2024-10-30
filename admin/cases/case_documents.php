<?php 		
if($active_tab == 'documents')
{
	$active_tab = isset($_GET['tab3'])?$_GET['tab3']:'documentslist';
	?>     
	<h2>	
		<ul id="myTab" class="sub_menu_css line nav nav-tabs case_details_documents" role="tablist">
			<li role="presentation" class="<?php echo esc_html($active_tab) == 'documentslist' ? 'active' : ''; ?> ">
				<a href="admin.php?page=cases&tab=casedetails&action=view&tab2=documents&tab3=documentslist&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
					<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Documents List', 'lawyer_mgt'); ?>				
				</a>
			</li>
			<?php if(isset($_REQUEST['edit'])&& sanitize_text_field($_REQUEST['edit'])=='true') {?>
			<li role="presentation" class="<?php echo $active_tab == 'adddocuments' ? 'active' : ''; ?>">
				<a href="admin.php?page=cases&tab=casedetails&&action=view&tab2=documents&tab3=adddocuments&edit=true&tab4=alldocuments&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&documents_id=<?php echo esc_attr($_REQUEST['documents_id']);?>">
					<?php echo esc_html__('Edit Documents', 'lawyer_mgt'); ?>					
				</a>
			</li>
			<?php }else{?>
			<li role="presentation" class="<?php echo esc_html($active_tab) == 'adddocuments' ? 'active' : ''; ?>">
				<a href="admin.php?page=cases&tab=casedetails&action=view&add=true&tab2=documents&tab3=adddocuments&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>">
					<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Documents', 'lawyer_mgt'); ?>	
				</a>
			</li>
			<?php }?>		
		</ul>
	</h2>
	<?php
	if($active_tab=='adddocuments')
	{	 
		require_once LAWMS_PLUGIN_DIR. '/admin/cases/add_case_documents.php'; 
	}
	if($active_tab=='documentslist')
	{	
		$document_columns_array=explode(',',get_option('lmgt_document_columns_option'));
		$document_export_array=explode(',',get_option('document_export_option'));
	?>
		<script type="text/javascript">
		var $ = jQuery.noConflict();
			jQuery(document).ready(function($)
			{
		    "use strict";
			jQuery('.documents_list').DataTable({
				"responsive": true,
				"autoWidth": false,
				"order": [[ 1, "asc" ]],
				language:<?php echo wpnc_datatable_multi_language();?>,
				 "aoColumns":[
							  {"bSortable": false},
							<?php if(in_array('document_title',$document_columns_array)) { ?>
									  {"bSortable": true},
							<?php  } ?>	
							<?php if(in_array('document_type',$document_columns_array)) { ?>
									  {"bSortable": true},
							<?php  } ?>
							<?php if(in_array('document_case_link',$document_columns_array)) { ?> 
									  {"bSortable": true},
							<?php  } ?>
							<?php if(in_array('tag_name',$document_columns_array)) {  ?>
									  {"bSortable": true},
							<?php  } ?>
							<?php if(in_array('status',$document_columns_array)) { ?> 
									  {"bSortable": true},
							<?php  } ?>
							<?php if(in_array('last_updated',$document_columns_array)) {  ?>
									  {"bVisible": true},	
							<?php  } ?>
							<?php if(in_array('document_description',$document_columns_array)) {  ?>
									  {"bSortable": true},  
							<?php  } ?>
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
			});
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
		</script>
		<form  action="" method="post" class="form-horizontal" enctype='multipart/form-data'>	
			<div class="panel-body">
				<input type="hidden" name="hidden_case_id" class="hidden_case_id" value="<?php echo esc_attr(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));?>">
				<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label filter_lable"><?php esc_html_e('Filter By Document Status :','lawyer_mgt');?></label>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
						<select class="form-control document_filter" name="document_status">
							<option value="-1"><?php esc_html_e('Select All','lawyer_mgt');?></option>
							<option value="0"><?php esc_html_e('Read','lawyer_mgt');?></option>
							<option value="1"><?php esc_html_e('Unread','lawyer_mgt');?></option>
						</select> 
					</div>
					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">												
						<input type="submit" class="btn delete_margin_bottom btn-primary" name="document_excle_selected" value="<?php esc_attr_e('Excel', 'lawyer_mgt' ) ;?> " />											
						<input type="submit" class="btn delete_margin_bottom btn-primary" name="document_csv_selected" value="<?php esc_attr_e('CSV', 'lawyer_mgt' ) ;?> " />
						<input type="submit" class="btn delete_margin_bottom btn-primary" name="document_pdf_selected" value="<?php esc_attr_e('PDF', 'lawyer_mgt' ) ;?> " />
					</div>	
				</div>	
				<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<table id="documents_list" class="documents_list documents_list_all_documets table table-striped table-bordered">
						<thead>				 
							<tr>
								<th><input type="checkbox" id="select_all"></th>
								<?php if(in_array('document_title',$document_columns_array)) { ?>
									<th><?php  esc_html_e('Document Title ', 'lawyer_mgt' ) ;?></th>
								<?php  } ?>	
								<?php if(in_array('document_type',$document_columns_array)) { ?>	
									<th><?php  esc_html_e('Document Type ', 'lawyer_mgt' ) ;?></th>
								<?php  } ?>	
								<?php if(in_array('document_case_link',$document_columns_array)) { ?> 
									<th><?php esc_html_e('Case Link', 'lawyer_mgt' ) ;?></th>
								<?php  } ?>	
								<?php if(in_array('tag_name',$document_columns_array)) {  ?>
									<th><?php esc_html_e('Tags Name ', 'lawyer_mgt' ) ;?></th>
								<?php  } ?>	
								<?php if(in_array('status',$document_columns_array)) { ?>
									<th><?php esc_html_e('Status', 'lawyer_mgt' ) ;?></th>
								<?php  } ?>	
								<?php if(in_array('last_updated',$document_columns_array)) {  ?>
									<th> <?php esc_html_e('Last Updated', 'lawyer_mgt' ) ;?></th>
								<?php  } ?>	
								<?php if(in_array('document_description',$document_columns_array)) {  ?>	
									<th><?php  esc_html_e('Description', 'lawyer_mgt' ) ;?></th>
								<?php  } ?>	
								<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
							</tr>
						</thead>
						<tbody>
						 <?php 
							$case_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['case_id']));
							$result=$obj_documents->MJ_lawmgt_get_casewise_all_documents($case_id);	
							if(!empty($result))
							{	
								foreach ($result as $retrieved_data)
								{								
									$case_id= esc_attr($retrieved_data->case_id);
									global $wpdb;		
									$table_cases = $wpdb->prefix. 'lmgt_cases';
									$case_name= $wpdb->get_row("SELECT case_name FROM $table_cases where id=".$case_id);
						 ?>
							<tr>
								<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo esc_html($retrieved_data->id); ?>"></td>				
								<?php if(in_array('document_title',$document_columns_array)) { ?>
										<td class="title"><?php echo esc_html($retrieved_data->title);?></td>
								<?php  } ?>
								<?php if(in_array('document_type',$document_columns_array)) { ?>															
										<td class="title"><?php echo esc_html($retrieved_data->type);?></td>	
								<?php  } ?>
								<?php if(in_array('document_case_link',$document_columns_array)) { ?> 
										<td class="case_link"><a href="?page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->case_id));?>"><?php echo esc_html($case_name->case_name);?></a></td>
								<?php  } ?>
								<?php if(in_array('tag_name',$document_columns_array)) {  ?>
										<td class="tags_name"><?php echo esc_html($retrieved_data->tag_names);?></td>	
								<?php  } ?>
								<?php if(in_array('status',$document_columns_array)) { ?>
										<td class="tags_name">
										<?php
										$status=$obj_documents->MJ_lawmgt_check_documents_status_by_user(esc_attr($retrieved_data->id));	
										echo esc_html($status);
										?></td>
								<?php  } ?>
								<?php if(in_array('last_updated',$document_columns_array)) {  ?>
										<td class="last_update"><?php echo esc_html($retrieved_data->last_update);?></td>
								<?php  } ?>
								<?php if(in_array('document_description',$document_columns_array)) {  ?>
										<td class=""><?php echo esc_html($retrieved_data->document_description);?></td>	
								<?php  } ?>
								<td class="action"> 				
								<a target="blank" href="<?php print content_url().'/uploads/document_upload/'.$retrieved_data->document_url; ?>" class="status_read btn btn-default" record_id="<?php echo esc_attr($retrieved_data->id);?>"><i class="fa fa-download"></i><?php esc_html_e(' Download', 'lawyer_mgt');?></a>				
								<a href="?page=cases&tab=casedetails&action=view&tab2=documents&tab3=adddocuments&edit=true&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&documents_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
								<a href="?page=cases&tab=casedetails&action=view&deletedocuments=true&tab2=documents&tab3=documentslist&case_id=<?php echo esc_attr($_REQUEST['case_id']);?>&documents_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>" class="btn btn-danger" 
								onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');">
								<?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>					
								</td>               
							</tr>
							<?php 
								} 
							}
							?>     
						</tbody>        
					</table>
					<?php if(!empty($result))
							{	?>
					<div class="form-group">		
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
							<input type="submit" class="btn delete_check delete_margin_bottom btn-danger" name="document_delete_selected"  value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
						</div>
					</div>
						<?php   }?>
				</div>				
			</div>     
			</form>
			<?php
	}
}
?>	