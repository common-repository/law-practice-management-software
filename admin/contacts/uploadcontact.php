<script type="text/javascript">
var $ = jQuery.noConflict();
jQuery(document).ready(function($)
{
	"use strict";
	$('#upload_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
});	
jQuery("body").on("change", ".company_csv_file[type=file]", function ()
{ 
	"use strict";
	var file = this.files[0]; 
	var file_id = jQuery(this).attr('id'); 
	var ext = $(this).val().split('.').pop().toLowerCase(); 
	//Extension Check 
	if($.inArray(ext, ['csv']) == -1)
	{
		alert('<?php _e("Only CSV File Allowed . '  + ext + ' File Not Allowed.","lawyer_mgt") ?>');
	 
		$(this).replaceWith('<input type="file" class="company_csv_file width_245_px_css" name="company_csv_file">');
		return false; 
	} 
	 //File Size Check 
	 if (file.size > 20480000) 
	 {
		alert("<?php esc_html_e('Too large file Size. Only file smaller than 10MB can be uploaded.','lawyer_mgt');?>");
		$(this).replaceWith('<input type="file" class="company_csv_file width_245_px_css"name="company_csv_file">'); 
		return false; 
	 }
});
jQuery("body").on("change", ".contact_csv_file[type=file]", function ()
{ 
	"use strict";
	var file = this.files[0]; 
	var file_id = jQuery(this).attr('id'); 
	var ext = $(this).val().split('.').pop().toLowerCase(); 
	//Extension Check 
	if($.inArray(ext, ['csv']) == -1)
	{
		 alert('<?php esc_html_e("Only CSV File Allowed .","lawyer_mgt") ?>');
		$(this).replaceWith('<input type="file" class="contact_csv_file width_245_px_css" name="contact_csv_file">');
		return false; 
	} 
	 //File Size Check 
	 if (file.size > 20480000) 
	 {
		alert("<?php esc_html_e('Too large file Size. Only file smaller than 10MB can be uploaded.','lawyer_mgt');?>");
		$(this).replaceWith('<input type="file" class="contact_csv_file width_245_px_css" name="contact_csv_file">'); 
		return false; 
	 }
});
</script>
<div class="panel-body"> <!-- PANEL BODY DIV  -->
    <form name="upload_form" action="" method="post" class="form-horizontal" id="upload_form" enctype="multipart/form-data">
		<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
		<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
		 	
		<div class="form-group">
			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Select Client CSV File','lawyer_mgt');?><span class="require-field">*</span></label>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<input type="file" class="contact_csv_file form-control display_inline_css" name="contact_csv_file">			
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<input type="submit" value="<?php esc_attr_e('Upload Client CSV File','lawyer_mgt');?>" name="upload_contact_csv_file" class="btn btn-success"/>
			</div>
		</div>	
	</form>
</div><!-- END PANEL BODY DIV  -->