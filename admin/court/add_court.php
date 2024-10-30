<?php 
$court=new MJ_lawmgt_Court;
$data=null;	
?>
<!--Group POP up code -->
  <div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list">
			</div>     
		</div>
    </div>     
  </div>
<script type="text/javascript">
   var $ = jQuery.noConflict();
	jQuery(document).ready(function($)
	{
		/* jQuery('body').on('click', '[data-toggle=dropdown]', function()
		{
			var opened = $(this).parent().hasClass("open");
			if (! opened) {
				$('.btn-group').addClass('open');
				$("button.multiselect").attr('aria-expanded', 'true');
			} else {
				$('.btn-group').removeClass('open');
				$("button.multiselect").attr('aria-expanded', 'false');
			}
	    }); */
	 "use strict";
	  $('#court_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
	  
		$('#bench_id').multiselect({
			templates: {
				li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>'
			},
			buttonWidth: '30%',
			numberDisplayed: 1,
			nonSelectedText :'<?php esc_html_e('Select Bench Name','lawyer_mgt');?>',
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
		$("#submitcourt").on("click",function()
		{	
			var checked = $(".multiselect_validation .dropdown-menu input:checked").length;

			if(!checked)
			{
				alert("<?php esc_html_e('Please select atleast one Bench','lawyer_mgt');?>");
				return false;
			}			
		});	 	
	});
</script>
<style>
.dropdown-menu{
	z-index:998;
}
</style>
<?php 	
if($active_tab == 'add_court')
{
	$c_id=0;
	$edit=0;
	if(isset($_REQUEST['id']))
		$c_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['id']));
		$court_data='';
		if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
		{					
			$edit=1;
			$court_data=$court->MJ_lawmgt_get_signle_court_by_id($c_id);
			 
		}?>
    <div class="panel-body"><!-- PANEL BODY DIV  -->
		<form name="court_form" action="" method="post" class="form-horizontal" id="court_form" enctype='multipart/form-data'>	
			<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
			<input id="action" class="form-control  text-input" type="hidden"  value="<?php echo esc_attr($action); ?>" name="action">
			 
			<div class="header">	
				<h3 class="first_hed"><?php esc_html_e('Court Information','lawyer_mgt');?></h3>
				<hr>
			</div>
			<!---COURT DETAIL---->
				<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="activity_category"><?php esc_html_e('Court Name','lawyer_mgt');?><span class="require-field">*</span></label>
					 
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<select class="form-control validate[required] court_category" name="court_id">
								<option value=""><?php esc_html_e('Select Court Name','lawyer_mgt');?></option>
								<?php 
								if($edit)
								{
									$category = sanitize_text_field($court_data->court_id);
								}
								elseif(isset($_REQUEST['court_id']))
								{
									$category = sanitize_text_field($_REQUEST['court_id']); 
								}									
								else 
								{
									$category = "";
								}
								 
								$court_category=MJ_lawmgt_get_all_category('court_category');
								if(!empty($court_category))
								{
									foreach ($court_category as $retrive_data)
									{
										echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected($category,esc_html($retrive_data->ID)).'>'.esc_html($retrive_data->post_title).'</option>';
									}
								} ?>
							</select>
						</div>					
						<div class="col-sm-2">
							<button id="addremove_cat" class="btn btn-success btn_margin" model="court_category"><?php esc_html_e('Add Or Remove','lawyer_mgt');?></button>
						</div>				
				</div><!---COURT DETAIL END---->
			<!---State DETAIL---->
				<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="activity_category"><?php esc_html_e('State Name','lawyer_mgt');?><span class="require-field">*</span></label>
					 
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<select class="form-control validate[required] state_category" name="state_id">
								<option value=""><?php esc_html_e('Select State Name','lawyer_mgt');?></option>
								<?php 
								if($edit)
									$category = sanitize_text_field($court_data->state_id);
								
								elseif(isset($_REQUEST['state_id']))
									$category = sanitize_text_field($_REQUEST['state_id']);  
								else 
									$category = "";
								
								$activity_category=MJ_lawmgt_get_all_category('state_category');
								if(!empty($activity_category))
								{
									foreach ($activity_category as $retrive_data)
									{
										echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected($category,esc_html($retrive_data->ID)).'>'.esc_html($retrive_data->post_title).'</option>';
									}
								} ?>
							</select>
						</div>					
						<div class="col-sm-2">
							<button id="addremove_cat" class="btn btn-success btn_margin" model="state_category"><?php esc_html_e('Add Or Remove','lawyer_mgt');?></button>
						</div>				
				</div><!---State DETAIL END---->
				<!---Bench DETAIL---->
				<div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="activity_category"><?php esc_html_e('Bench Name','lawyer_mgt');?><span class="require-field">*</span></label>
					 
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 has-feedback multiselect_validation">
						<select class="form-control validate[required] bench_category" multiple="multiple" name="bench_id[]" id="bench_id">	
						<?php if($edit){ $data=$court_data->bench_id;}elseif(isset($_POST['bench_category'])){ $data=esc_attr($_POST['bench_category']); }?>
								<?php 
								$activity_category=MJ_lawmgt_get_all_category('bench_category');
								if(!empty($activity_category))
								{
									foreach ($activity_category as $retrive_data)
									{
										?>
										<option value="<?php print esc_attr($retrive_data->ID);?>" <?php echo in_array(esc_html($retrive_data->ID),explode(',',$data)) ? 'selected': ''; ?>>
										<?php echo esc_html($retrive_data->post_title);?>
										</option>
									<?php 
									}
								} ?>
							</select>
						</div>					
						<div class="col-sm-2">
							<button id="addremove_cat" class="btn btn-success btn_margin" model="bench_category"><?php esc_html_e('Add Or Remove','lawyer_mgt');?></button>
						</div>				
					<?php
					//}
					?>
				</div><!---Bench DETAIL END---->
				<div class="form-group">	
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for=""><?php esc_html_e('Court Details','lawyer_mgt');?></label>
					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 has-feedback">
						<textarea rows="3" class="validate[custom[address_description_validation]],maxSize[150]] width_100_per" name="court_details"  id="court_details" ><?php if($edit){ echo esc_textarea ($court_data->court_details);}elseif(isset($_POST['court_details'])){ echo esc_textarea ($_POST['court_details']); } ?></textarea>				
					</div>	
				</div>
				<?php wp_nonce_field( 'save_court_nonce' ); ?>
			   <div class="form-group margin_top_div_css1">
					<div class="offset-sm-2 col-sm-8">
						<input type="submit" id="submitcourt" name="save_court" class="btn btn-success" value="<?php if($edit){
						esc_attr_e('Save Court','lawyer_mgt');}else{ esc_attr_e('Add Court','lawyer_mgt');}?>"></input>
					</div>
				</div>
        </form>
	</div><!-- END PANEL BODY DIV  -->
<?php 
}
?>	