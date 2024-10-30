<?php
 $active_tab = sanitize_text_field(isset($_GET['tab1'])?$_GET['tab1']:'all_payments_by_case_and_client'); 
?>
<h2>
<ul id="myTab" class="sub_menu_css line case_nav nav nav-tabs" role="tablist">
	<li role="presentation" class="<?php echo esc_html($active_tab) == 'all_payments_by_case_and_client' ? 'active' : ''; ?> menucss">
		<a href="admin.php?page=report&tab=paymentreport&tab1=all_payments_by_case_and_client">
			<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('All Payments By Case And Client', 'lawyer_mgt'); ?>
		</a>
	</li>
	<li role="presentation" class="<?php echo esc_html($active_tab) == 'all_payments_by_case' ? 'active' : ''; ?> menucss">
		<a href="admin.php?page=report&tab=paymentreport&tab1=all_payments_by_case">
			<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('All Payments By Case Report', 'lawyer_mgt'); ?>
		</a>
	</li>	
</ul>	
</h2>
 <?php 
	if($active_tab == 'all_payments_by_case_and_client')
	{ 				
		require_once LAWMS_PLUGIN_DIR. '/admin/report/all_payments_by_case_and_client.php';
    }
	if($active_tab == 'all_payments_by_case')
	{ 				
		require_once LAWMS_PLUGIN_DIR. '/admin/report/all_payments_by_case.php';
    }
	 
	?>