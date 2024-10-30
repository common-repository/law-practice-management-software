<?php 
	$access_right=get_option('lmgt_access_right_attorney');
	if(isset($_POST['save_attorney_access_right']))
	{
		$role_access_right = array();
		$result=get_option('lmgt_access_right_attorney');
		if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
		{
			$default_value=1;
		}
		else
		{
			$default_value=0;
		}
		$role_access_right['attorney'] =
		[
			"attorney"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/attorney.png' ),
			"menu_title"=>'Attorney',
			"page_link"=>'attorney',
			"own_data" =>sanitize_text_field(isset($_REQUEST['attorney_own_data'])?$_REQUEST['attorney_own_data']:0),
			"add" =>sanitize_text_field(isset($_REQUEST['attorney_add'])?$_REQUEST['attorney_add']:0),
			"edit"=>sanitize_text_field(isset($_REQUEST['attorney_edit'])?$_REQUEST['attorney_edit']:0),
			"view"=>sanitize_text_field(isset($_REQUEST['attorney_view'])?$_REQUEST['attorney_view']:0),
			"delete"=>sanitize_text_field(isset($_REQUEST['attorney_delete'])?$_REQUEST['attorney_delete']:0)
			],
			
			"staff"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/staff.png' ),
			"menu_title"=>'Staff',
			"page_link"=>'staff',
			"own_data" =>sanitize_text_field(isset($_REQUEST['staff_own_data'])?$_REQUEST['staff_own_data']:0),
			"add" =>sanitize_text_field(isset($_REQUEST['staff_add'])?$_REQUEST['staff_add']:0),
			"edit"=>sanitize_text_field(isset($_REQUEST['staff_edit'])?$_REQUEST['staff_edit']:0),
			"view"=>sanitize_text_field(isset($_REQUEST['staff_view'])?$_REQUEST['staff_view']:0),
			"delete"=>sanitize_text_field(isset($_REQUEST['staff_delete'])?$_REQUEST['staff_delete']:0)
			],
			
			"accountant"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/account.png' ),
			"menu_title"=>'Accountant',
			"page_link"=>'accountant',
			"own_data" =>sanitize_text_field(isset($_REQUEST['accountant_own_data'])?$_REQUEST['accountant_own_data']:0),
			"add" =>sanitize_text_field(isset($_REQUEST['accountant_add'])?$_REQUEST['accountant_add']:0),
			"edit"=>sanitize_text_field(isset($_REQUEST['accountant_edit'])?$_REQUEST['accountant_edit']:0),
			"view"=>sanitize_text_field(isset($_REQUEST['accountant_view'])?$_REQUEST['accountant_view']:0),
			"delete"=>sanitize_text_field(isset($_REQUEST['accountant_delete'])?$_REQUEST['accountant_delete']:0)
			],
			
			"contacts"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/contact.png' ),
			"menu_title"=>'Client',
			"page_link"=>'contacts',
			"own_data" =>sanitize_text_field(isset($_REQUEST['contacts_own_data'])?$_REQUEST['contacts_own_data']:0),
			"add" =>sanitize_text_field(isset($_REQUEST['contacts_add'])?$_REQUEST['contacts_add']:0),
			"edit"=>sanitize_text_field(isset($_REQUEST['contacts_edit'])?$_REQUEST['contacts_edit']:0),
			"view"=>sanitize_text_field(isset($_REQUEST['contacts_view'])?$_REQUEST['contacts_view']:0),
			"delete"=>sanitize_text_field(isset($_REQUEST['contacts_delete'])?$_REQUEST['contacts_delete']:0)
			],
			
			"court"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/Court-Module.png' ),
			"menu_title"=>'Court',
			"page_link"=>'court',
			"own_data" =>sanitize_text_field(isset($_REQUEST['court_own_data'])?$_REQUEST['court_own_data']:0),
			"add" =>sanitize_text_field(isset($_REQUEST['court_add'])?$_REQUEST['court_add']:0),
			"edit"=>sanitize_text_field(isset($_REQUEST['court_edit'])?$_REQUEST['court_edit']:0),
			"view"=>sanitize_text_field(isset($_REQUEST['court_view'])?$_REQUEST['court_view']:0),
			"delete"=>sanitize_text_field(isset($_REQUEST['court_delete'])?$_REQUEST['court_delete']:0)
			],
			
			"cases"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/case.png' ),
			"menu_title"=>'Cases',
			"page_link"=>'cases',
			"own_data" =>sanitize_text_field(isset($_REQUEST['cases_own_data'])?$_REQUEST['cases_own_data']:0),
			"add" =>sanitize_text_field(isset($_REQUEST['cases_add'])?$_REQUEST['cases_add']:0),
			"edit"=>sanitize_text_field(isset($_REQUEST['cases_edit'])?$_REQUEST['cases_edit']:0),
			"view"=>sanitize_text_field(isset($_REQUEST['cases_view'])?$_REQUEST['cases_view']:0),
			"delete"=>sanitize_text_field(isset($_REQUEST['cases_delete'])?$_REQUEST['cases_delete']:0)
			],
			
			"orders"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/order-court.png' ),
			"menu_title"=>'Orders',
			"page_link"=>'orders',
			"own_data" =>sanitize_text_field(isset($_REQUEST['orders_own_data'])?$_REQUEST['orders_own_data']:0),
			"add" =>sanitize_text_field(isset($_REQUEST['orders_add'])?$_REQUEST['orders_add']:0),
			"edit"=>sanitize_text_field(isset($_REQUEST['orders_edit'])?$_REQUEST['orders_edit']:0),
			"view"=>sanitize_text_field(isset($_REQUEST['orders_view'])?$_REQUEST['orders_view']:0),
			"delete"=>sanitize_text_field(isset($_REQUEST['orders_delete'])?$_REQUEST['orders_delete']:0)
			],
			
			"judgments"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/Judgement.png' ),
			"menu_title"=>'Judgments',
			"page_link"=>'judgments',
			"own_data" =>sanitize_text_field(isset($_REQUEST['judgments_own_data'])?$_REQUEST['judgments_own_data']:0),
			"add" =>sanitize_text_field(isset($_REQUEST['judgments_add'])?$_REQUEST['judgments_add']:0),
			"edit"=>sanitize_text_field(isset($_REQUEST['judgments_edit'])?$_REQUEST['judgments_edit']:0),
			"view"=>sanitize_text_field(isset($_REQUEST['judgments_view'])?$_REQUEST['judgments_view']:0),
			"delete"=>sanitize_text_field(isset($_REQUEST['judgments_delete'])?$_REQUEST['judgments_delete']:0)
			],
			
			"causelist"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/cause_list.png' ),
			"menu_title"=>'Cause List',
			"page_link"=>'causelist',
			"own_data" =>sanitize_text_field(isset($_REQUEST['causelist_own_data'])?$_REQUEST['causelist_own_data']:0),
			"add" =>sanitize_text_field(isset($_REQUEST['causelist_add'])?$_REQUEST['causelist_add']:0),
			"edit"=>sanitize_text_field(isset($_REQUEST['causelist_edit'])?$_REQUEST['causelist_edit']:0),
			"view"=>sanitize_text_field(isset($_REQUEST['causelist_view'])?$_REQUEST['causelist_view']:0),
			"delete"=>sanitize_text_field(isset($_REQUEST['causelist_delete'])?$_REQUEST['causelist_delete']:0)
			],
			
			"task"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/task.png' ),
			"menu_title"=>'Task',
			"page_link"=>'task',
			"own_data" =>sanitize_text_field(isset($_REQUEST['task_own_data'])?$_REQUEST['task_own_data']:$default_value),
			"add" =>sanitize_text_field(isset($_REQUEST['task_add'])?$_REQUEST['task_add']:$default_value),
			"edit"=>sanitize_text_field(isset($_REQUEST['task_edit'])?$_REQUEST['task_edit']:$default_value),
			"view"=>sanitize_text_field(isset($_REQUEST['task_view'])?$_REQUEST['task_view']:$default_value),
			"delete"=>sanitize_text_field(isset($_REQUEST['task_delete'])?$_REQUEST['task_delete']:$default_value)
			],
			
			"event"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/event.png' ),
			"menu_title"=>'Event',
			"page_link"=>'event',
			"own_data" =>sanitize_text_field(isset($_REQUEST['event_own_data'])?$_REQUEST['event_own_data']:0),
			"add" =>sanitize_text_field(isset($_REQUEST['event_add'])?$_REQUEST['event_add']:0),
			"edit"=>sanitize_text_field(isset($_REQUEST['event_edit'])?$_REQUEST['event_edit']:0),
			"view"=>sanitize_text_field(isset($_REQUEST['event_view'])?$_REQUEST['event_view']:0),
			"delete"=>sanitize_text_field(isset($_REQUEST['event_delete'])?$_REQUEST['event_delete']:0)
			],
			
			"note"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/note.png' ),
			"menu_title"=>'Note',
			"page_link"=>'note',
			"own_data" =>sanitize_text_field(isset($_REQUEST['note_own_data'])?$_REQUEST['note_own_data']:0),
			"add" =>sanitize_text_field(isset($_REQUEST['note_add'])?$_REQUEST['note_add']:0),
			"edit"=>sanitize_text_field(isset($_REQUEST['note_edit'])?$_REQUEST['note_edit']:0),
			"view"=>sanitize_text_field(isset($_REQUEST['note_view'])?$_REQUEST['note_view']:0),
			"delete"=>sanitize_text_field(isset($_REQUEST['note_delete'])?$_REQUEST['note_delete']:0)
			],
			
			"workflow"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/work_flow.png' ),
			"menu_title"=>'Workflow',
			"page_link"=>'workflow',
			"own_data" =>sanitize_text_field(isset($_REQUEST['workflow_own_data'])?$_REQUEST['workflow_own_data']:0),
			"add" =>sanitize_text_field(isset($_REQUEST['workflow_add'])?$_REQUEST['workflow_add']:0),
			"edit"=>sanitize_text_field(isset($_REQUEST['workflow_edit'])?$_REQUEST['workflow_edit']:0),
			"view"=>sanitize_text_field(isset($_REQUEST['workflow_view'])?$_REQUEST['workflow_view']:0),
			"delete"=>sanitize_text_field(isset($_REQUEST['workflow_delete'])?$_REQUEST['workflow_delete']:0)
			],
			
			"documents"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/document.png' ),
			"menu_title"=>'Documents',
			"page_link"=>'documents',
			"own_data" =>sanitize_text_field(isset($_REQUEST['documents_own_data'])?$_REQUEST['documents_own_data']:$default_value),
			"add" =>sanitize_text_field(isset($_REQUEST['documents_add'])?$_REQUEST['documents_add']:$default_value),
			"edit"=>sanitize_text_field(isset($_REQUEST['documents_edit'])?$_REQUEST['documents_edit']:$default_value),
			"view"=>sanitize_text_field(isset($_REQUEST['documents_view'])?$_REQUEST['documents_view']:$default_value),
			"delete"=>sanitize_text_field(isset($_REQUEST['documents_delete'])?$_REQUEST['documents_delete']:$default_value)
			],
			
			"invoice"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/invoice.png' ),
			"menu_title"=>'Invoice',
			"page_link"=>'invoice',
			"own_data" =>sanitize_text_field(isset($_REQUEST['invoice_own_data'])?$_REQUEST['invoice_own_data']:$default_value),
			"add" =>sanitize_text_field(isset($_REQUEST['invoice_add'])?$_REQUEST['invoice_add']:$default_value),
			"edit"=>sanitize_text_field(isset($_REQUEST['invoice_edit'])?$_REQUEST['invoice_edit']:$default_value),
			"view"=>sanitize_text_field(isset($_REQUEST['invoice_view'])?$_REQUEST['invoice_view']:$default_value),
			"delete"=>sanitize_text_field(isset($_REQUEST['invoice_delete'])?$_REQUEST['invoice_delete']:$default_value)
			],
			
			"rules"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/rules.png' ),
			"menu_title"=>'Rules',
			"page_link"=>'rules',
			"own_data" =>sanitize_text_field(isset($_REQUEST['rules_own_data'])?$_REQUEST['rules_own_data']:0),
			"add" =>sanitize_text_field(isset($_REQUEST['rules_add'])?$_REQUEST['rules_add']:0),
			"edit"=>sanitize_text_field(isset($_REQUEST['rules_edit'])?$_REQUEST['rules_edit']:0),
			"view"=>sanitize_text_field(isset($_REQUEST['rules_view'])?$_REQUEST['rules_view']:0),
			"delete"=>sanitize_text_field(isset($_REQUEST['rules_delete'])?$_REQUEST['rules_delete']:0)
			],
			
			"report"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/report.png' ),
			"menu_title"=>'Report',
			"page_link"=>'report',
			"own_data" =>sanitize_text_field(isset($_REQUEST['report_own_data'])?$_REQUEST['report_own_data']:$default_value),
			"add" =>sanitize_text_field(isset($_REQUEST['report_add'])?$_REQUEST['report_add']:0),
			"edit"=>sanitize_text_field(isset($_REQUEST['report_edit'])?$_REQUEST['report_edit']:0),
			"view"=>sanitize_text_field(isset($_REQUEST['report_view'])?$_REQUEST['report_view']:$default_value),
			"delete"=>sanitize_text_field(isset($_REQUEST['report_delete'])?$_REQUEST['report_delete']:0)
			],
			
			"message"=>["menu_icone"=>plugins_url( 'lawyers-management/assets/images/icons/message.png' ),
			"menu_title"=>'Message',
			"page_link"=>'message',
			"own_data" =>sanitize_text_field(isset($_REQUEST['message_own_data'])?$_REQUEST['message_own_data']:0),
			"add" =>sanitize_text_field(isset($_REQUEST['message_add'])?$_REQUEST['message_add']:0),
			"edit"=>sanitize_text_field(isset($_REQUEST['message_edit'])?$_REQUEST['message_edit']:0),
			"view"=>sanitize_text_field(isset($_REQUEST['message_view'])?$_REQUEST['message_view']:0),
			"delete"=>sanitize_text_field(isset($_REQUEST['message_delete'])?$_REQUEST['message_delete']:0)
			],
			
			"account"=>['menu_icone'=>plugins_url( 'lawyers-management/assets/images/icons/account1.png'),
			"menu_title"=>'Account',
			"page_link"=>'account',
			"own_data" => sanitize_text_field(isset($_REQUEST['account_own_data'])?$_REQUEST['account_own_data']:0),
			"add" => sanitize_text_field(isset($_REQUEST['account_add'])?$_REQUEST['account_add']:0),
			"edit"=>sanitize_text_field(isset($_REQUEST['account_edit'])?$_REQUEST['account_edit']:0),
			"view"=>sanitize_text_field(isset($_REQUEST['account_view'])?$_REQUEST['account_view']:0),
			"delete"=>sanitize_text_field(isset($_REQUEST['account_delete'])?$_REQUEST['account_delete']:0)
			]
		];
		$result=update_option( 'lmgt_access_right_attorney',$role_access_right);
		if($result)
		{
		   //wp_redirect ( admin_url() . 'admin.php?page=access_right&tab=attorney_tab&message=1');
		    $url=admin_url().'admin.php?page=access_right&tab=attorney_tab&message=1';
			if (!headers_sent())
			{
				header('Location: '.esc_url($url));
			}
			else 
			{ 
				echo '<script type="text/javascript">';
				echo 'window.location.href="'.esc_url($url).'";';
				echo '</script>';
			}
		}
	}
	if(isset($_REQUEST['message']))
	{
		$message = sanitize_text_field($_REQUEST['message']);
		if($message == 1)
		{?>	
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
				<?php esc_html_e('Record Updated Successfully','lawyer_mgt');?>
			</div>
				<?php
		}
	} 
?>
<div  id="main-wrapper" class="marks_list font_size_access"><!-- MAIN WRAPER  DIV -->
	<div class="panel panel-white"> <!-- PANEL WHITE  DIV -->
		<div class="panel-body"> <!-- PANEL BODY  DIV -->
			<h2>
				<?php esc_html_e( 'Attorney Access Right', 'lawyer_mgt'); ?>
			</h2>
			<form name="attorney_access_right" action="" method="post" class="form-horizontal" id="attorney_access_right">
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 menu_left"><?php esc_html_e('Menu','lawyer_mgt');?></div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 "><?php esc_html_e('Own Data','lawyer_mgt');?></div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 "><?php esc_html_e('View','lawyer_mgt');?></div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 margin_left_access"><?php esc_html_e('Add','lawyer_mgt');?></div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 "><?php esc_html_e('Edit','lawyer_mgt');?></div>
					<div class="col-lg-1 col-md-2 col-sm-1 col-xs-1 "><?php esc_html_e('Delete','lawyer_mgt');?></div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 access_right_margin_top_margin_top_5px">
						<span class="menu-label menu_left">
							<?php esc_html_e('Attorney','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['attorney']['own_data'],1);?> value="1" name="attorney_own_data"><!--Update by Vatsal -->													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['attorney']['view'],1);?> value="1" name="attorney_view"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['attorney']['attorney']['add'],1);?> value="1" name="attorney_add" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['attorney']['edit'],1);?> value="1" name="attorney_edit" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['attorney']['delete'],1);?> value="1" name="attorney_delete" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 access_right_margin_top_margin_top_5px">
						<span class="menu-label menu_left">
							<?php esc_html_e('Staff','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['staff']['own_data'],1);?> value="1" name="staff_own_data" disabled><!--Update by Vatsal -->													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['staff']['view'],1);?> value="1" name="staff_view"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['attorney']['staff']['add'],1);?> value="1" name="staff_add" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['staff']['edit'],1);?> value="1" name="staff_edit" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['staff']['delete'],1);?> value="1" name="staff_delete" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 access_right_margin_top_margin_top_5px">
						<span class="menu-label menu_left">
							<?php esc_html_e('Accountant','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['accountant']['own_data'],1);?> value="1" name="accountant_own_data" disabled><!--Update by Vatsal -->													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['accountant']['view'],1);?> value="1" name="accountant_view"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['attorney']['accountant']['add'],1);?> value="1" name="accountant_add" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['accountant']['edit'],1);?> value="1" name="accountant_edit" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['accountant']['delete'],1);?> value="1" name="accountant_delete" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 access_right_margin_top_margin_top_5px">
						<span class="menu-label menu_left">
							<?php esc_html_e('Clients','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['contacts']['own_data'],1);?> value="1" name="contacts_own_data"><!--Update by Vatsal -->													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['contacts']['view'],1);?> value="1" name="contacts_view"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['attorney']['contacts']['add'],1);?> value="1" name="contacts_add"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['contacts']['edit'],1);?> value="1" name="contacts_edit"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['contacts']['delete'],1);?> value="1" name="contacts_delete"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 access_right_margin_top_margin_top_5px">
						<span class="menu-label menu_left">
							<?php esc_html_e('Court','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['court']['own_data'],1);?> value="1" name="court_own_data"><!--Update by Vatsal -->													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['court']['view'],1);?> value="1" name="court_view"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['attorney']['court']['add'],1);?> value="1" name="court_add"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['court']['edit'],1);?> value="1" name="court_edit"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['court']['delete'],1);?> value="1" name="court_delete"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 access_right_margin_top_margin_top_5px">
						<span class="menu-label menu_left">
							<?php esc_html_e('Cases','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['cases']['own_data'],1);?> value="1" name="cases_own_data"><!--Update by Vatsal -->													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['cases']['view'],1);?> value="1" name="cases_view"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['attorney']['cases']['add'],1);?> value="1" name="cases_add"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['cases']['edit'],1);?> value="1" name="cases_edit"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['cases']['delete'],1);?> value="1" name="cases_delete"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 access_right_margin_top_margin_top_5px">
						<span class="menu-label menu_left">
							<?php esc_html_e('Orders','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['orders']['own_data'],1);?> value="1" name="orders_own_data"><!--Update by Vatsal -->													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['orders']['view'],1);?> value="1" name="orders_view"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['attorney']['orders']['add'],1);?> value="1" name="orders_add"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['orders']['edit'],1);?> value="1" name="orders_edit"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['orders']['delete'],1);?> value="1" name="orders_delete"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 access_right_margin_top_margin_top_5px">
						<span class="menu-label menu_left">
							<?php esc_html_e('Judgments','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['judgments']['own_data'],1);?> value="1" name="judgments_own_data"><!--Update by Vatsal -->													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['judgments']['view'],1);?> value="1" name="judgments_view"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['attorney']['judgments']['add'],1);?> value="1" name="judgments_add"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['judgments']['edit'],1);?> value="1" name="judgments_edit"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['judgments']['delete'],1);?> value="1" name="judgments_delete"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 access_right_margin_top_margin_top_5px">
						<span class="menu-label menu_left">
							<?php esc_html_e('Cause List','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['causelist']['own_data'],1);?> value="1" name="causelist_own_data"><!--Update by Vatsal -->													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['causelist']['view'],1);?> value="1" name="causelist_view"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['attorney']['causelist']['add'],1);?> value="1" name="causelist_add" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['causelist']['edit'],1);?> value="1" name="causelist_edit" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['causelist']['delete'],1);?> value="1" name="causelist_delete" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
				</div>
				<?php
				if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
				{
					?>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 access_right_margin_top_margin_top_5px">
						<span class="menu-label menu_left">
							<?php esc_html_e('Tasks','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['task']['own_data'],1);?> value="1" name="task_own_data"><!--Update by Vatsal -->													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['task']['view'],1);?> value="1" name="task_view"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['attorney']['task']['add'],1);?> value="1" name="task_add"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['task']['edit'],1);?> value="1" name="task_edit"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['task']['delete'],1);?> value="1" name="task_delete"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
				</div>
				<?php
				}
				?>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 access_right_margin_top_margin_top_5px">
						<span class="menu-label menu_left">
							<?php esc_html_e('Events','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['event']['own_data'],1);?> value="1" name="event_own_data"><!--Update by Vatsal -->													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['event']['view'],1);?> value="1" name="event_view"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['attorney']['event']['add'],1);?> value="1" name="event_add"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['event']['edit'],1);?> value="1" name="event_edit"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['event']['delete'],1);?> value="1" name="event_delete"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 access_right_margin_top_margin_top_5px">
						<span class="menu-label menu_left">
							<?php esc_html_e('Notes','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['note']['own_data'],1);?> value="1" name="note_own_data"><!--Update by Vatsal -->													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['note']['view'],1);?> value="1" name="note_view"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['attorney']['note']['add'],1);?> value="1" name="note_add"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['note']['edit'],1);?> value="1" name="note_edit"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['note']['delete'],1);?> value="1" name="note_delete"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 access_right_margin_top_margin_top_5px">
						<span class="menu-label menu_left">
							<?php esc_html_e('Workflow','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['workflow']['own_data'],1);?> value="1" name="workflow_own_data"><!--Update by Vatsal -->													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['workflow']['view'],1);?> value="1" name="workflow_view"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['attorney']['workflow']['add'],1);?> value="1" name="workflow_add"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['workflow']['edit'],1);?> value="1" name="workflow_edit"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['workflow']['delete'],1);?> value="1" name="workflow_delete"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
				</div>
				<?php
				if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
				{
					?>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 access_right_margin_top_margin_top_5px">
						<span class="menu-label menu_left">
							<?php esc_html_e('Documents','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['documents']['own_data'],1);?> value="1" name="documents_own_data"><!--Update by Vatsal -->													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['documents']['view'],1);?> value="1" name="documents_view"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['attorney']['documents']['add'],1);?> value="1" name="documents_add"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['documents']['edit'],1);?> value="1" name="documents_edit"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['documents']['delete'],1);?> value="1" name="documents_delete"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
				</div>
				
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 access_right_margin_top_margin_top_5px">
						<span class="menu-label menu_left">
							<?php esc_html_e('Invoices','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['invoice']['own_data'],1);?> value="1" name="invoice_own_data"><!--Update by Vatsal -->													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['invoice']['view'],1);?> value="1" name="invoice_view"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['attorney']['invoice']['add'],1);?> value="1" name="invoice_add"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['invoice']['edit'],1);?> value="1" name="invoice_edit"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['invoice']['delete'],1);?> value="1" name="invoice_delete"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
				</div>
				<?php
				}
				?>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 access_right_margin_top_margin_top_5px">
						<span class="menu-label menu_left">
							<?php esc_html_e('Rules','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['rules']['own_data'],1);?> value="1" name="rules_own_data" disabled><!--Update by Vatsal -->													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['rules']['view'],1);?> value="1" name="rules_view"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['attorney']['rules']['add'],1);?> value="1" name="rules_add" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['rules']['edit'],1);?> value="1" name="rules_edit" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['rules']['delete'],1);?> value="1" name="rules_delete" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
				</div>
				<?php
				if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
				{
					?>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 access_right_margin_top_margin_top_5px">
						<span class="menu-label menu_left">
							<?php esc_html_e('Reports','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['report']['own_data'],1);?> value="1" name="report_own_data"><!--Update by Vatsal -->													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['report']['view'],1);?> value="1" name="report_view"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['attorney']['report']['add'],1);?> value="1" name="report_add" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['report']['edit'],1);?> value="1" name="report_edit" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['report']['delete'],1);?> value="1" name="report_delete" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
				</div>
				<?php
				}
				?>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 access_right_margin_top_margin_top_5px">
						<span class="menu-label menu_left">
							<?php esc_html_e('Messages','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['message']['own_data'],1);?> value="1" name="message_own_data" disabled><!--Update by Vatsal -->													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['message']['view'],1);?> value="1" name="message_view"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['attorney']['message']['add'],1);?> value="1" name="message_add"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['message']['edit'],1);?> value="1" name="message_edit" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['message']['delete'],1);?> value="1" name="message_delete"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 access_right_margin_top_margin_top_5px">
						<span class="menu-label menu_left">
							<?php esc_html_e('Account','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['account']['own_data'],1);?> value="1" name="account_own_data" disabled><!--Update by Vatsal -->													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['attorney']['account']['view'],1);?> value="1" name="account_view"><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['attorney']['account']['add'],1);?> value="1" name="account_add" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['account']['edit'],1);?> value="1" name="account_edit" ><!--Update by Vatsal -->
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['attorney']['account']['delete'],1);?> value="1" name="account_delete" disabled><!--Update by Vatsal -->
							</label>
						</div>
					</div>
				</div>
				<div class="offset-sm-2 col-sm-8 margin_top_10px_css">
					<input type="submit" value="<?php esc_attr_e('Save', 'lawyer_mgt' ); ?>" name="save_attorney_access_right" class="btn btn-success"/>
			    </div>									
	        </form>
		</div>	<!-- PANEL BODY  DIV -->
	</div>	<!-- ENDPANEL WHITE  DIV -->
</div><!-- END MAIN WRAPER  DIV -->