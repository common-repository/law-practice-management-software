<?php 	
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'attorney_tab');
?>
<div class="page-inner page_inner_div" ><!--  PAGE INNER DIV --> 
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' ));?></h3>
	  </div>
	</div>
	<div id="main-wrapper"><!--  MAIN WRAPER DIV   --> 
		<div class="row"> <!--  ROW DIV   --> 
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white">
					<div class="panel-body"> <!-- PANEL WHITE  DIV -->
						<h2 class="nav-tab-wrapper">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font accesstabs" role="add_event">
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'attorney_tab' ? 'active' : ''; ?> menucss">
									<a href="?page=access_right&tab=attorney_tab">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Attorney Access Right', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'client_tab' ? 'active' : ''; ?> menucss accesstabs">
									<a href="?page=access_right&tab=client_tab">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Client Access Right', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'staff_member_tab' ? 'active' : ''; ?> menucss accesstabs">
									<a href="?page=access_right&tab=staff_member_tab">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Staff Member Access Right', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo esc_html($active_tab) == 'accountant_tab' ? 'active' : ''; ?> menucss accesstabs">
									<a href="?page=access_right&tab=accountant_tab ">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Accountant Access Right', 'lawyer_mgt'); ?>
									</a>
								</li>
							</ul>
						</h2>
						<?php 	
						if($active_tab == 'attorney_tab')
						{						
						   require_once LAWMS_PLUGIN_DIR. '/admin/access_right/attorney.php';	
						}
						elseif($active_tab == 'client_tab')
						{						
						   require_once LAWMS_PLUGIN_DIR. '/admin/access_right/client.php';	
						}
						elseif($active_tab == 'staff_member_tab')
						{						
						   require_once LAWMS_PLUGIN_DIR. '/admin/access_right/staff_member.php';
						}					   
						elseif($active_tab == 'accountant_tab')
						{						
						   require_once LAWMS_PLUGIN_DIR. '/admin/access_right/accountant.php';	
						}
						?>
				    </div>	<!-- PANEL BODY  DIV -->
				</div>	<!-- ENDPANEL WHITE  DIV -->
			</div>
		</div><!--  END ROW DIV   --> 
	</div><!-- END MAIN WRAPER  DIV -->
</div><!--  END PAGE INNER DIV --> 