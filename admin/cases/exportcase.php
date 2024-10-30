<div class="panel-body"><!-- PANEL BODY DIV -->
    <form name="upload_form" action="" method="post" class="form-horizontal" id="upload_form" enctype="multipart/form-data">
        <?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
		<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
		<div class="col-sm-12">        	
			<input type="submit" class="btn delete_margin_bottom btn-primary" name="case_excle" value="<?php esc_attr_e('Excel', 'lawyer_mgt' );?> " />											
			<input type="submit" class="btn delete_margin_bottom btn-primary" name="case_csv" value="<?php esc_attr_e('CSV', 'lawyer_mgt' ) ;?> " />
			<input type="submit" class="btn delete_margin_bottom btn-primary" name="case_pdf" value="<?php esc_attr_e('PDF', 'lawyer_mgt' ) ;?> " />
        </div>		
	</form>
</div><!--END  PANEL BODY DIV -->