<?php 
$obj_invoice=new MJ_lawmgt_invoice;
?>
<script type="text/javascript">
jQuery(document).ready(function($)
{
	"use strict";
	$('#tax_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
});
</script>
 <?php 	
if($active_tab == 'add_tax')
{
	$tax_id=0;
	if(isset($_REQUEST['tax_id']))
	$tax_id= sanitize_text_field($_REQUEST['tax_id']);
	$edit=0;
	if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit_tax')
	{
		$edit=1;
		$result = $obj_invoice->MJ_lawmgt_get_single_tax_data($tax_id);
	}
	?>
    <div class="panel-body"><!-- PANEL BODY DIV START-->
        <form name="tax_form" action="" method="post" class="form-horizontal" id="tax_form">
			<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
			<input type="hidden" name="tax_id" value="<?php echo esc_attr($tax_id);?>">	
			<?php wp_nonce_field( 'save_tax_nonce' ); ?>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for=""><?php esc_html_e("Tax Name","lawyer_mgt");?><span class="require-field">*</span></label>
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
				<input id="" maxlength="30" class="form-control validate[required,custom[address_description_validation]] text-input" type="text" value="<?php if($edit){ echo esc_attr($result->tax_title);}elseif(isset($_POST['tax_title'])) { echo esc_attr($_POST['tax_title']); } ?>" name="tax_title">
			   </div>
			</div>  
			
			<div class="form-group">
			   <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for=""><?php esc_html_e("Tax Value","lawyer_mgt");?>(%)<span class="require-field">*</span></label>
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
					<input id="tax" class="form-control validate[required,custom[number]] text-input" onkeypress="if(this.value.length==6) return false;" step="0.01" type="number" value="<?php if($edit){ echo esc_attr($result->tax_value);}elseif(isset($_POST['tax_value'])) echo esc_attr($_POST['tax_value']);?>" name="tax_value" min="0" max="100">
				</div>
			</div>
			<div class="form-group">
				<div class="offset-sm-2 col-sm-8">
					<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Save','lawyer_mgt');}?>" name="save_tax" class="btn btn-success"/>
				</div>
			</div>
        </form>
    </div><!-- PANEL BODY DIV END-->    
<?php 
}
?>