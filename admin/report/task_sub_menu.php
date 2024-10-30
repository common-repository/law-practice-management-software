<?php
 $active_tab = sanitize_text_field(isset($_GET['tab1'])?$_GET['tab1']:'tasks_by_case'); 
?>
<h2>
<ul id="myTab" class="sub_menu_css line case_nav nav nav-tabs" role="tablist">	
	<li role="presentation" class="<?php echo esc_html($active_tab) == 'tasks_by_case' ? 'active' : ''; ?> menucss">
			<a href="admin.php?page=report&tab=taskreport&tab1=tasks_by_case">
				<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Tasks By Case', 'lawyer_mgt'); ?>
			</a>
	</li>	
	 
</ul>	
</h2>
 <?php 
	if($active_tab == 'tasks_by_case')
	{ 				
		require_once LAWMS_PLUGIN_DIR. '/admin/report/tasks_by_case.php';
    }
	?>