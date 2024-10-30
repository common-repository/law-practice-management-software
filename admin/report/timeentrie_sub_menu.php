<?php
 $active_tab = sanitize_text_field(isset($_GET['tab1'])?$_GET['tab1']:'timeentries_by_case_and_contact'); 
?>
<h2>
<ul id="myTab" class="sub_menu_css line case_nav nav nav-tabs" role="tablist">
	<li role="presentation" class="<?php echo esc_html($active_tab) == 'timeentries_by_case_and_contact' ? 'active' : ''; ?> menucss">
			<a href="admin.php?page=report&tab=timeentriereport&tab1=timeentries_by_case_and_contact">
				<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Time Entries By Case And Client', 'lawyer_mgt'); ?>
			</a>
	</li>	
	<li role="presentation" class="<?php echo esc_html($active_tab) == 'timeentries_by_case' ? 'active' : ''; ?> menucss">
			<a href="admin.php?page=report&tab=timeentriereport&tab1=timeentries_by_case">
				<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Time Entries By Case', 'lawyer_mgt'); ?>
			</a>
	</li>	
</ul>	
</h2>
<?php 
	if($active_tab == 'timeentries_by_case_and_contact')
	{ 				
		require_once LAWMS_PLUGIN_DIR. '/admin/report/timeentries_by_case_and_contact.php';
    }
	if($active_tab == 'timeentries_by_case')
	{ 				
		require_once LAWMS_PLUGIN_DIR. '/admin/report/timeentries_by_case.php';
    }
?>