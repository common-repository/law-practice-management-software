<?php 
$obj_invoice=new MJ_lawmgt_invoice;
if($active_tab == 'taxlist')
{
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		"use strict";
		jQuery('#tax_list').DataTable({
			"responsive": true,
			"autoWidth": false,
			"order": [[ 1, "asc" ]],
			language:<?php echo wpnc_datatable_multi_language();?>,
			 "aoColumns":[
						  {"bSortable": true},
						  {"bSortable": false},
						  {"bSortable": false}
					   ]		               		
			});	
	});
	</script>
<div class="tab-pane  tabs fade  active in" id="nav-open" role="tabpanel" aria-labelledby="nav-open-tab">
	<form name="" action="" method="post" enctype='multipart/form-data'>
		<div class="panel-body">
			<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">	
				<table id="tax_list" class="tax_list table table-striped table-bordered">
					<thead>	
						<?php  ?>
						<tr>
							<th><?php esc_html_e('Tax Name', 'lawyer_mgt' ) ;?></th>
							<th> <?php  esc_html_e('Tax Value', 'lawyer_mgt' ) ;?> (%)</th>
							<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
						</tr>
						<br/>
					</thead>
					<tbody>
						<?php
						$taxdata=$obj_invoice->MJ_lawmgt_get_all_tax_data();
						if(!empty($taxdata))
						{													
							foreach ($taxdata as $retrieved_data)
							{
								?>
								<tr>
									<td class=""><?php echo esc_html($retrieved_data->tax_title); ?></td>
									<td class=""><?php echo esc_html($retrieved_data->tax_value); ?></td>							
									<td class="action">							
										<a href="?page=invoice&tab=add_tax&action=edit_tax&tax_id=<?php echo esc_html($retrieved_data->tax_id);?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>							
										<a href="?page=invoice&tab=taxlist&action=delete_tax&tax_id=<?php echo esc_html($retrieved_data->tax_id);?>" class="btn btn-danger" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');"><?php esc_html_e('Delete', 'lawyer_mgt' ) ;?>  </a>
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