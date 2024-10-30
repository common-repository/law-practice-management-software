<?php 	
$obj_orders=new MJ_lawmgt_Orders;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'orderlist');
$result=null;
?>
<div class="page-inner page_inner_div">
    <!--  PAGE INNER DIV -->
    <div class="page-title">
        <div class="title_left">
            <h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo"
                    width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' ));?></h3>
        </div>
    </div>
    <?php 
	if(isset($_POST['save_orders']))
	{	
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_order_nonce' ) )
		{ 
			$upload_docs_array=array();	
			if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action']) == 'edit')
			{	
				//New Documents //
				if(!empty($_FILES['orders_documents']['name']))
				{
					$count_array=count($_FILES['orders_documents']['name']);

					for($a=0;$a<$count_array;$a++)
					{			
						foreach($_FILES['orders_documents'] as $image_key=>$image_val)
						{		
							$document_array[$a]=array(
							'name'=>sanitize_file_name($_FILES['orders_documents']['name'][$a]),
							'type'=>sanitize_file_name($_FILES['orders_documents']['type'][$a]),
							'tmp_name'=>sanitize_text_field($_FILES['orders_documents']['tmp_name'][$a]),
							'error'=>sanitize_file_name($_FILES['orders_documents']['error'][$a]),
							'size'=>sanitize_file_name($_FILES['orders_documents']['size'][$a])
							);							
						}
					}				
					foreach($document_array as $key=>$value)		
					{	
						$get_file_name=$document_array[$key]['name'];	
						
						$upload_docs_array[]=MJ_lawmgt_load_documets($value,$value,$get_file_name);				
					} 				
				}
				//Old Documents //
				if(!empty($_FILES['orders_documents_old']['name']))
				{
					$count_array=count($_FILES['orders_documents_old']['name']);

					for($a=0;$a<$count_array;$a++)
					{			
						foreach($_FILES['orders_documents_old'] as $image_key=>$image_val)
						{		
							$document_array1[$a]=array(
							'name'=>sanitize_file_name($_FILES['orders_documents_old']['name'][$a]),
							'type'=>sanitize_file_name($_FILES['orders_documents_old']['type'][$a]),
							'tmp_name'=>sanitize_text_field($_FILES['orders_documents_old']['tmp_name'][$a]),
							'error'=>sanitize_file_name($_FILES['orders_documents_old']['error'][$a]),
							'size'=>sanitize_file_name($_FILES['orders_documents_old']['size'][$a])
							);							
						}
					}	
					foreach($document_array1 as $key=>$value)		
					{	
						$get_file_name=$document_array1[$key]['name'];	
						
						if(!empty($get_file_name))
						{
							$upload_docs_array[]=MJ_lawmgt_load_documets($value,$value,$get_file_name);				
						}
						else
						{
							$upload_docs_array[]=sanitize_file_name($_POST['old_hidden_orders_documents'][$key]);
						}				
					} 				
				}
				
				$upload_docs_array_filter=array_filter($upload_docs_array);
				$result=$obj_orders->MJ_lawmgt_add_order($_POST,$upload_docs_array_filter);
					
				if($result)
				{
					//wp_redirect ( admin_url() . 'admin.php?page=orders&tab=orderlist&message=2');
					$redirect_url=admin_url().'admin.php?page=orders&tab=orderlist&message=2';
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
			}
			else
			{
				if(!empty($_FILES['orders_documents']['name']))
				{
					$count_array=count($_FILES['orders_documents']['name']);

					for($a=0;$a<$count_array;$a++)
					{			
						foreach($_FILES['orders_documents'] as $image_key=>$image_val)
						{		
							$document_array[$a]=array(
							'name'=>sanitize_file_name($_FILES['orders_documents']['name'][$a]),
							'type'=>sanitize_file_name($_FILES['orders_documents']['type'][$a]),
							'tmp_name'=>sanitize_text_field($_FILES['orders_documents']['tmp_name'][$a]),
							'error'=>sanitize_file_name($_FILES['orders_documents']['error'][$a]),
							'size'=>sanitize_file_name($_FILES['orders_documents']['size'][$a])
							);							
						}
					}				
					foreach($document_array as $key=>$value)		
					{	
						$get_file_name=$document_array[$key]['name'];	
						
						$upload_docs_array[]=MJ_lawmgt_load_documets($value,$value,$get_file_name);				
					} 				
				}
				$upload_docs_array_filter=array_filter($upload_docs_array);	
				$result=$obj_orders->MJ_lawmgt_add_order($_POST,$upload_docs_array_filter);
				
				if($result)
				{
					//wp_redirect ( admin_url() . 'admin.php?page=orders&tab=orderlist&message=1');
					$redirect_url=admin_url().'admin.php?page=orders&tab=orderlist&message=1';
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
			}
		}
	}	
	if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='delete')
	{	
		$result=$obj_orders->MJ_lawmgt_delete_orders(sanitize_text_field($_REQUEST['order_id']));				
		if($result)
		{
			//wp_redirect ( admin_url() . 'admin.php?page=orders&tab=orderlist&message=3');
			$redirect_url=admin_url().'admin.php?page=orders&tab=orderlist&message=3';
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
	}
	if(isset($_REQUEST['message']))
	{
		$message = sanitize_text_field($_REQUEST['message']);
		if($message == 1)
		{?>
    <div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <?php esc_html_e('Order Inserted Successfully','lawyer_mgt');?>
    </div>
    <?php 
			
		}
		elseif($message == 2)
		{?>
    <div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <?php esc_html_e('Order Updated Successfully','lawyer_mgt');?>
    </div>
    <?php 			
		}
		elseif($message == 3) 
		{?>
    <div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <?php esc_html_e('Order Deleted Successfully','lawyer_mgt');?>
    </div>
    <?php				
		}
	} 		 
	?>
    <div id="main-wrapper">
        <!--  MAIN WRAPER DIV   -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <div class="panel panel-white">
                    <div class="panel-body">
                        <h2 class="nav-tab-wrapper">
                            <ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="tablist">
                                <li role="presentation"
                                    class="<?php echo esc_html($active_tab) == 'orderlist' ? 'active' : ''; ?> menucss">
                                    <a href="?page=orders&tab=orderlist">
                                        <?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Orders List', 'lawyer_mgt'); ?>
                                    </a>
                                </li>
                                <li role="presentation"
                                    class="<?php echo esc_html($active_tab) == 'add_order' ? 'active' : ''; ?> menucss">
                                    <?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
								{?>
                                    <a
                                        href="?page=orders&tab=add_order&&action=edit&id=<?php echo sanitize_text_field($_REQUEST['id']);?>">
                                        <?php esc_html_e('Edit Order', 'lawyer_mgt'); ?>
                                    </a>
                                    <?php 
								}			
								else
								{?>
                                    <a href="?page=orders&tab=add_order">
                                        <?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Order', 'lawyer_mgt');?>
                                    </a>
                                    <?php  
								}?>
                                </li>
                                <li role="presentation"
                                    class="<?php echo esc_html($active_tab) == 'orders_activity' ? 'active' : ''; ?> menucss">
                                    <a href="?page=orders&tab=orders_activity">
                                        <?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('Order Activity', 'lawyer_mgt'); ?>
                                    </a>
                                </li>

                            </ul>
                        </h2>
                        <?php  
						if($active_tab == 'orderlist')
						{ 
						?>
                        <script type="text/javascript">
                        var $ = jQuery.noConflict();
                        jQuery(document).ready(function($) {
                            "use strict";
                            jQuery('#attorney_list').DataTable({
                                "responsive": true,
                                "autoWidth": false,
                                "order": [
                                    [1, "asc"]
                                ],
                                language: <?php echo wpnc_datatable_multi_language();?>,
                                "aoColumns": [{
                                        "bSortable": false
                                    },
                                    {
                                        "bSortable": true
                                    },
                                    {
                                        "bSortable": true
                                    },
                                    {
                                        "bSortable": false
                                    },
                                    {
                                        "bSortable": true
                                    },
                                    {
                                        "bSortable": true
                                    },
                                    {
                                        "bVisible": true
                                    },
                                    {
                                        "bSortable": false
                                    }
                                ]
                            });

                        });
                        jQuery(document).ready(function($) {
                            "use strict";
                            jQuery('#select_all').on('click', function(e) {
                                if ($(this).is(':checked', true)) {
                                    $(".sub_chk").prop('checked', true);
                                } else {
                                    $(".sub_chk").prop('checked', false);
                                }
                            });
                            $("body").on("change", ".sub_chk", function() {
                                if (false == $(this).prop("checked")) {
                                    $("#select_all").prop('checked', false);
                                }
                                if ($('.sub_chk:checked').length == $('.sub_chk').length) {
                                    $("#select_all").prop('checked', true);
                                }
                            });
                        });
                        </script>
                        <form name="wcwm_report" action="" method="post">
                            <div class="panel-body">
                                <div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                    <table id="attorney_list" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="select_all"></th>
                                                <th><?php esc_html_e('Case Name', 'lawyer_mgt' ) ;?></th>
                                                <th> <?php esc_html_e('Judge Name', 'lawyer_mgt' ) ;?></th>
                                                <th> <?php esc_html_e('Next Hearing Date', 'lawyer_mgt' ) ;?></th>
                                                <th> <?php esc_html_e('Order Details', 'lawyer_mgt' ) ;?></th>
                                                <th><?php esc_html_e('Purpose Of Hearing ', 'lawyer_mgt' ) ;?></th>
                                                <th> <?php esc_html_e('Order Document', 'lawyer_mgt' ) ;?></th>
                                                <th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
											$orders_result=$obj_orders->MJ_lawmgt_get_all_orders();
											 if(!empty($orders_result))
											 {
												foreach ($orders_result as $retrieved_data)
												{
													$case_name=MJ_lawmgt_get_case_name_by_id($retrieved_data->case_id);
													foreach($case_name as $case_name1)
													{
														$case_name2= sanitize_text_field($case_name1->case_name);
													}	
												?>
                                            <tr>
                                                <td class="title"><input type="checkbox" name="selected_id[]"
                                                        class="sub_chk"
                                                        value="<?php echo esc_html($retrieved_data->id); ?>"></td>

                                                <td class=""><?php echo esc_html($case_name2); ?></td>
                                                <td class=""><?php 
													if(!empty($retrieved_data->judge_name))
													{
														echo esc_html($retrieved_data->judge_name);
													}
													else
													{
														echo '<b class="desh_juge" >'."-".'</b>';
													}	
													?></td>
                                                <td class="">
                                                    <?php echo MJ_lawmgt_getdate_in_input_box($retrieved_data->next_hearing_date);?>
                                                </td>
                                                <td class=""><?php echo esc_html($retrieved_data->orders_details);?>
                                                </td>
                                                <td class=""><?php
													if(!empty($retrieved_data->purpose_of_hearing))
													{
														echo esc_html($retrieved_data->purpose_of_hearing);
													}
													else
													{
														
														echo '<b class="desh" >'."-".'</b>';
													}	
													 
													?></td>
                                                <td class="added">
                                                    <?php 
													$doc_data=json_decode($retrieved_data->orders_document);
													if(!empty($doc_data))
													{
														foreach ($doc_data as $retrieved_data1)
														{
															?><a target="blank" href="<?php print content_url().'/uploads/document_upload/'.esc_attr($retrieved_data1->value); ?>"
                                                        target="blank" class="status_read btn btn-default"
                                                        record_id="<?php echo esc_html($retrieved_data1->title);?>"><i
                                                            class="fa fa-download"></i><?php esc_html_e(' Download', 'lawyer_mgt');?></a><?php
														}															
													} 
													else
													{
														
														echo '<b class="desh" >'."-".'</b>';
													}
													?>
                                                </td>
                                                <td class="action">
                                                    <a href="?page=orders&tab=add_order&action=edit&id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>"
                                                        class="btn btn-info">
                                                        <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
                                                    <a href="?page=orders&tab=orderlist&action=delete&order_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->id));?>"
                                                        class="btn btn-danger"
                                                        onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');">
                                                        <?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>
                                                </td>
                                            </tr>
                                            <?php } 			
											} ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                        <?php 
							 }	
							if($active_tab == 'add_order')
							{		
								 require_once LAWMS_PLUGIN_DIR. '/admin/orders/add_order.php';	
							}
							if($active_tab == 'orders_activity')
							{		 
								require_once LAWMS_PLUGIN_DIR. '/admin/orders/orders_activity.php';		
							}
							?>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- 	END MAIN WRAPER DIV   -->
</div><!-- END  PAGE INNER DIV -->