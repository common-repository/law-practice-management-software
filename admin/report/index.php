<?php 	
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'invoicereport');
if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
{
	//wp_redirect (admin_url().'admin.php?page=lmgt_system');
	$redirect_url= esc_url(admin_url().'admin.php?page=lmgt_system');
	if (!headers_sent())
	{
		header('Location: '.esc_url($redirect_url));
	}
	else 
	{
		echo '<script type="text/javascript">';
		echo 'window.location.href="'.esc_url($redirect_url).'";';
		echo '</script>';
	}
}
?>
<div class="page-inner min_height_1631_px_important">
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' ));?></h3>
	  </div>
	</div>
	<div id="main-wrapper">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<h2 class="nav-tab-wrapper">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="tablist">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'invoicereport' ? 'active' : ''; ?> menucss">
									<a href="?page=report&tab=invoicereport">
										<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Invoices', 'lawyer_mgt'); ?>
									</a>
								</li>	
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'paymentreport' ? 'active' : ''; ?> menucss">
									<a href="?page=report&tab=paymentreport">
										<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Payments', 'lawyer_mgt'); ?>
									</a>
								</li>
								 
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'casereport' ? 'active' : ''; ?> menucss">
									<a href="?page=report&tab=casereport">
										<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Cases', 'lawyer_mgt'); ?>
									</a>
								</li>			
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'expensereport' ? 'active' : ''; ?> menucss">
									<a href="?page=report&tab=expensereport">
										<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Expenses', 'lawyer_mgt'); ?>
									</a>
								</li>			
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'timeentriereport' ? 'active' : ''; ?> menucss">
									<a href="?page=report&tab=timeentriereport">
										<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Time Entries', 'lawyer_mgt'); ?>
									</a>
								</li>	
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'taskreport' ? 'active' : ''; ?> menucss">
									<a href="?page=report&tab=taskreport">
										<?php echo '<span class="dashicons dashicons-chart-bar"></span> '.esc_html__('Tasks', 'lawyer_mgt'); ?>
									</a>
								</li>				
						</h2>
					  <?php 
						if($active_tab == 'invoicereport')
						{ 
							require_once LAWMS_PLUGIN_DIR. '/admin/report/invoice_sub_menu.php';
						}
						 
						if($active_tab == 'paymentreport')
						{ 
							require_once LAWMS_PLUGIN_DIR. '/admin/report/payment_sub_menu.php';
						}
						if($active_tab == 'casereport')
						{ 
							require_once LAWMS_PLUGIN_DIR. '/admin/report/case_sub_menu.php';
						}
						if($active_tab == 'expensereport')
						{ 
							require_once LAWMS_PLUGIN_DIR. '/admin/report/expense_sub_menu.php';
						}
						if($active_tab == 'timeentriereport')
						{ 
							require_once LAWMS_PLUGIN_DIR. '/admin/report/timeentrie_sub_menu.php';
						}
						if($active_tab == 'taskreport')
						{ 
							require_once LAWMS_PLUGIN_DIR. '/admin/report/task_sub_menu.php';
						}
						?>
					</div>
			
	            </div>
	        </div>
        </div>
	</div>
</div>