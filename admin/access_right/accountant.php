<?php 
	$access_right=get_option('lmgt_access_right_accountant');
	if(isset($_POST['save_accountant_access_right']))
	{
		$role_access_right = array();
		$result=get_option('lmgt_access_right_accountant');
		if($GLOBALS['lmgt_purchase_or_update_plan'] == 0)
		{
			$default_value=1;
		}
		else
		{
			$default_value=0;
		}
		$role_access_right['accountant'] =
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
			"own_data" =>sanitize_text_field(isset($_REQUEST['task_own_data'])?$_REQUEST['task_own_data']:0),
			"add" =>sanitize_text_field(isset($_REQUEST['task_add'])?$_REQUEST['task_add']:0),
			"edit"=>sanitize_text_field(isset($_REQUEST['task_edit'])?$_REQUEST['task_edit']:0),
			"view"=>sanitize_text_field(isset($_REQUEST['task_view'])?$_REQUEST['task_view']:0),
			"delete"=>sanitize_text_field(isset($_REQUEST['task_delete'])?$_REQUEST['task_delete']:0)
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
			"own_data" =>sanitize_text_field(isset($_REQUEST['documents_own_data'])?$_REQUEST['documents_own_data']:0),
			"add" =>sanitize_text_field(isset($_REQUEST['documents_add'])?$_REQUEST['documents_add']:0),
			"edit"=>sanitize_text_field(isset($_REQUEST['documents_edit'])?$_REQUEST['documents_edit']:0),
			"view"=>sanitize_text_field(isset($_REQUEST['documents_view'])?$_REQUEST['documents_view']:0),
			"delete"=>sanitize_text_field(isset($_REQUEST['documents_delete'])?$_REQUEST['documents_delete']:0)
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
		$result=update_option( 'lmgt_access_right_accountant',$role_access_right);
		if($result)
		{
		   //wp_redirect ( admin_url() . 'admin.php?page=access_right&tab=accountant_tab&message=1');
		   $url= admin_url().'admin.php?page=access_right&tab=accountant_tab&message=1';
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
				<?php esc_html_e( 'Accountant Access Right', 'lawyer_mgt'); ?>
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
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 attorney_access_right_margin_top">
						<span class="menu-label menu_left">
							<?php esc_html_e('Attorney','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['attorney']['own_data'],1);?> value="1" name="attorney_own_data" disabled>													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['attorney']['view'],1);?> value="1" name="attorney_view">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['accountant']['attorney']['add'],1);?> value="1" name="attorney_add" disabled>
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['attorney']['edit'],1);?> value="1" name="attorney_edit" disabled>
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['attorney']['delete'],1);?> value="1" name="attorney_delete" disabled>
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 attorney_access_right_margin_top">
						<span class="menu-label menu_left">
							<?php esc_html_e('Staff','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['staff']['own_data'],1);?> value="1" name="staff_own_data" disabled>													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['staff']['view'],1);?> value="1" name="staff_view">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['accountant']['staff']['add'],1);?> value="1" name="staff_add" disabled>
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['staff']['edit'],1);?> value="1" name="staff_edit" disabled>
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['staff']['delete'],1);?> value="1" name="staff_delete" disabled>
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 attorney_access_right_margin_top">
						<span class="menu-label menu_left">
							<?php esc_html_e('Accountant','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['accountant']['own_data'],1);?> value="1" name="accountant_own_data">													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['accountant']['view'],1);?> value="1" name="accountant_view">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['accountant']['accountant']['add'],1);?> value="1" name="accountant_add" disabled>
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['accountant']['edit'],1);?> value="1" name="accountant_edit" disabled>
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php  checked($access_right['accountant']['accountant']['delete'],1);?> value="1" name="accountant_delete" disabled>
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 attorney_access_right_margin_top">
						<span class="menu-label menu_left">
							<?php esc_html_e('Clients','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['contacts']['own_data'],1);?> value="1" name="contacts_own_data">													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['contacts']['view'],1);?> value="1" name="contacts_view">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['accountant']['contacts']['add'],1);?> value="1" name="contacts_add">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['contacts']['edit'],1);?> value="1" name="contacts_edit">
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['contacts']['delete'],1);?> value="1" name="contacts_delete">
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 attorney_access_right_margin_top">
						<span class="menu-label menu_left">
							<?php esc_html_e('Court','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['court']['own_data'],1);?> value="1" name="court_own_data">													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['court']['view'],1);?> value="1" name="court_view">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['accountant']['court']['add'],1);?> value="1" name="court_add">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['court']['edit'],1);?> value="1" name="court_edit">
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['court']['delete'],1);?> value="1" name="court_delete">
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 attorney_access_right_margin_top">
						<span class="menu-label menu_left">
							<?php esc_html_e('Cases','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['cases']['own_data'],1);?> value="1" name="cases_own_data">													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['cases']['view'],1);?> value="1" name="cases_view">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['accountant']['cases']['add'],1);?> value="1" name="cases_add">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['cases']['edit'],1);?> value="1" name="cases_edit">
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['cases']['delete'],1);?> value="1" name="cases_delete">
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 attorney_access_right_margin_top" >
						<span class="menu-label menu_left">
							<?php esc_html_e('Orders','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['orders']['own_data'],1);?> value="1" name="orders_own_data">													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['orders']['view'],1);?> value="1" name="orders_view">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['accountant']['orders']['add'],1);?> value="1" name="orders_add">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['orders']['edit'],1);?> value="1" name="orders_edit">
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['orders']['delete'],1);?> value="1" name="orders_delete">
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 attorney_access_right_margin_top">
						<span class="menu-label menu_left">
							<?php esc_html_e('Judgments','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['judgments']['own_data'],1);?> value="1" name="judgments_own_data">													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['judgments']['view'],1);?> value="1" name="judgments_view">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['accountant']['judgments']['add'],1);?> value="1" name="judgments_add">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['judgments']['edit'],1);?> value="1" name="judgments_edit">
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['judgments']['delete'],1);?> value="1" name="judgments_delete">
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 attorney_access_right_margin_top">
						<span class="menu-label menu_left">
							<?php esc_html_e('Cause List','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['causelist']['own_data'],1);?> value="1" name="causelist_own_data">													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['causelist']['view'],1);?> value="1" name="causelist_view">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['accountant']['causelist']['add'],1);?> value="1" name="causelist_add" disabled>
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['causelist']['edit'],1);?> value="1" name="causelist_edit" disabled>
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['causelist']['delete'],1);?> value="1" name="causelist_delete" disabled>
							</label>
						</div>
					</div>
				</div>
				<?php
				if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
				{
					?>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 attorney_access_right_margin_top">
						<span class="menu-label menu_left">
							<?php esc_html_e('Tasks','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['task']['own_data'],1);?> value="1" name="task_own_data">													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['task']['view'],1);?> value="1" name="task_view">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['accountant']['task']['add'],1);?> value="1" name="task_add">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['task']['edit'],1);?> value="1" name="task_edit">
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['task']['delete'],1);?> value="1" name="task_delete">
							</label>
						</div>
					</div>
				</div>
				<?php
				}
				?>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 attorney_access_right_margin_top">
						<span class="menu-label menu_left">
							<?php esc_html_e('Events','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['event']['own_data'],1);?> value="1" name="event_own_data">													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['event']['view'],1);?> value="1" name="event_view">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['accountant']['event']['add'],1);?> value="1" name="event_add">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['event']['edit'],1);?> value="1" name="event_edit">
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['event']['delete'],1);?> value="1" name="event_delete">
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 attorney_access_right_margin_top">
						<span class="menu-label menu_left">
							<?php esc_html_e('Notes','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['note']['own_data'],1);?> value="1" name="note_own_data">													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['note']['view'],1);?> value="1" name="note_view">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['accountant']['note']['add'],1);?> value="1" name="note_add">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['note']['edit'],1);?> value="1" name="note_edit">
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['note']['delete'],1);?> value="1" name="note_delete">
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 attorney_access_right_margin_top">
						<span class="menu-label menu_left">
							<?php esc_html_e('Workflow','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['workflow']['own_data'],1);?> value="1" name="workflow_own_data">													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['workflow']['view'],1);?> value="1" name="workflow_view">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['accountant']['workflow']['add'],1);?> value="1" name="workflow_add">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['workflow']['edit'],1);?> value="1" name="workflow_edit">
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['workflow']['delete'],1);?> value="1" name="workflow_delete">
							</label>
						</div>
					</div>
				</div>
				<?php
				if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
				{
					?>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 attorney_access_right_margin_top">
						<span class="menu-label menu_left">
							<?php esc_html_e('Documents','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['documents']['own_data'],1);?> value="1" name="documents_own_data">													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['documents']['view'],1);?> value="1" name="documents_view">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['accountant']['documents']['add'],1);?> value="1" name="documents_add">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['documents']['edit'],1);?> value="1" name="documents_edit">
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['documents']['delete'],1);?> value="1" name="documents_delete">
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 attorney_access_right_margin_top">
						<span class="menu-label menu_left">
							<?php esc_html_e('Invoices','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['invoice']['own_data'],1);?> value="1" name="invoice_own_data">													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['invoice']['view'],1);?> value="1" name="invoice_view">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['accountant']['invoice']['add'],1);?> value="1" name="invoice_add">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['invoice']['edit'],1);?> value="1" name="invoice_edit">
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['invoice']['delete'],1);?> value="1" name="invoice_delete">
							</label>
						</div>
					</div>
				</div>
				<?php
				}
				?>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 attorney_access_right_margin_top">
						<span class="menu-label menu_left">
							<?php esc_html_e('Rules','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['rules']['own_data'],1);?> value="1" name="rules_own_data" disabled>													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['rules']['view'],1);?> value="1" name="rules_view">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['accountant']['rules']['add'],1);?> value="1" name="rules_add" disabled>
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['rules']['edit'],1);?> value="1" name="rules_edit" disabled>
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['rules']['delete'],1);?> value="1" name="rules_delete" disabled>
							</label>
						</div>
					</div>
				</div>
				<?php
				if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
				{
					?>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 attorney_access_right_margin_top">
						<span class="menu-label menu_left">
							<?php esc_html_e('Reports','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['report']['own_data'],1);?> value="1" name="report_own_data">													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['report']['view'],1);?> value="1" name="report_view">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['accountant']['report']['add'],1);?> value="1" name="report_add" disabled>
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['report']['edit'],1);?> value="1" name="report_edit" disabled>
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['report']['delete'],1);?> value="1" name="report_delete" disabled>
							</label>
						</div>
					</div>
				</div>
				<?php
				}
				?>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 attorney_access_right_margin_top">
						<span class="menu-label menu_left">
							<?php esc_html_e('Messages','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['message']['own_data'],1);?> value="1" name="message_own_data" disabled>													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['message']['view'],1);?> value="1" name="message_view">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['accountant']['message']['add'],1);?> value="1" name="message_add">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['message']['edit'],1);?> value="1" name="message_edit" disabled>
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['message']['delete'],1);?> value="1" name="message_delete" >
							</label>
						</div>
					</div>
				</div>
				<div class="row attorney_access_right_div_css">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 attorney_access_right_margin_top">
						<span class="menu-label menu_left">
							<?php esc_html_e('Account','lawyer_mgt');?>
						</span>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['account']['own_data'],1);?> value="1" name="account_own_data" disabled>													
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php checked($access_right['accountant']['account']['view'],1);?> value="1" name="account_view">
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
							   <input type="checkbox" <?php checked($access_right['accountant']['account']['add'],1);?> value="1" name="account_add" disabled>
							</label>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['account']['edit'],1);?> value="1" name="account_edit" >
							</label>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						<div class="checkbox">
							<label>
								 <input type="checkbox" <?php checked($access_right['accountant']['account']['delete'],1);?> value="1" name="account_delete" disabled>
							</label>
						</div>
					</div>
				</div>	
				<div class="offset-sm-2 col-sm-8 margin_top_10px_css">
					<input type="submit" value="<?php esc_attr_e('Save', 'lawyer_mgt' ); ?>" name="save_accountant_access_right" class="btn btn-success"/>
			    </div>									
	        </form>
		</div>	<!-- END PANEL BODY  DIV -->
	</div>	<!-- END PANEL WHITE  DIV -->
</div><!-- END MAIN WRAPER  DIV -->