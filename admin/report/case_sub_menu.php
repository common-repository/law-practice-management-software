<?php
 $active_tab = sanitize_text_field(isset($_GET['tab1'])?$_GET['tab1']:'case_by_client_and_casetype'); 
?>
<h2>
<ul id="myTab" class="sub_menu_css line case_nav nav nav-tabs" role="tablist">
	<li role="presentation" class="<?php echo esc_html($active_tab) == 'case_by_client_and_casetype' ? 'active' : ''; ?> menucss">
			<a href="admin.php?page=report&tab=casereport&tab1=case_by_client_and_casetype">
				<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Cases By Client And Practice Area', 'lawyer_mgt'); ?>
			</a>
	</li>

	<li role="presentation" class="<?php echo esc_html($active_tab) == 'case_report' ? 'active' : ''; ?> menucss">
			<a href="admin.php?page=report&tab=casereport&tab1=case_report">
				<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Addition and Disposal Cases', 'lawyer_mgt'); ?>
			</a>
	</li>
	
</ul>	
</h2>
 <?php 
	if($active_tab == 'case_by_client_and_casetype')
	{ 				
		require_once LAWMS_PLUGIN_DIR. '/admin/report/case_by_client_and_casetype.php';
    }
	if($active_tab == 'case_report')
	{ 				
		require_once LAWMS_PLUGIN_DIR. '/admin/report/case_report.php';
    }
	?>