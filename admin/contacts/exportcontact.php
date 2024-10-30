<div class="panel-body"><!-- PANEL BODY DIV -->
    <form name="upload_form" action="" method="post" class="form-horizontal" id="upload_form" enctype="multipart/form-data">
        <?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
		<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Filter By Client Status :','lawyer_mgt');?></label>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
					<select class="form-control document_filter" name="client_status">
						<option value="2"><?php esc_html_e('Select All','lawyer_mgt');?></option>
						<option value="0"><?php esc_html_e('Active','lawyer_mgt');?></option>
						<option value="1"><?php esc_html_e('Archived','lawyer_mgt');?></option>
					</select> 
				</div>
				<input type="submit" value="<?php esc_attr_e('Export Client in CSV File','lawyer_mgt');?>" name="exportcontacts_csv" class="btn btn-success csv_button"/> 
			</div>
	</form>
</div><!--END  PANEL BODY DIV -->