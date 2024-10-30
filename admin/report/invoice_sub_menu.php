<?php
 $active_tab = sanitize_text_field(isset($_GET['tab1'])?$_GET['tab1']:'invoice_by_case_and_client'); 
?>
<h2>
<ul id="myTab" class="sub_menu_css line case_nav nav nav-tabs" role="tablist">
	<li role="presentation" class="<?php echo esc_html($active_tab) == 'invoice_by_case_and_client' ? 'active' : ''; ?> menucss">
			<a href="admin.php?page=report&tab=invoicereport&tab1=invoice_by_case_and_client">
				<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Invoice By Case And Client', 'lawyer_mgt'); ?>
			</a>
	</li>
</ul>	
</h2>
 <?php 
	if($active_tab == 'invoice_by_case_and_client')
	{ 				
		require_once LAWMS_PLUGIN_DIR. '/admin/report/invoice_by_case_and_client.php';
    }
	?>