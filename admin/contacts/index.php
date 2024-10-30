<?php 
$obj_user=new MJ_lawmgt_Users;
$custom_field = new MJ_lawmgt_custome_field;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'contactlist');
$result=null;	
?>
<div class="page-inner page_inner_div"><!--  PAGE INNER DIV --> 
	<div class="page-title">
	  <div class="title_left">
		<h3><img src="<?php echo esc_url(get_option( 'lmgt_system_logo' )) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option( 'lmgt_system_name' ));?></h3>
	  </div>
	</div>
	<?php
	//export contact in csv
	if(isset($_POST['exportcontacts_csv']))
	{
		$contact_list = get_users(array('role'=>'client'));
		if(!empty($contact_list))
		{
			$header = array();			
			$header[] = 'Username';
			$header[] = 'Email';
			$header[] = 'First Name';
			$header[] = 'Middle Name';
			$header[] = 'Last Name';			
			$header[] = 'Gender';
			$header[] = 'Birth Date';
			$header[] = 'Address';
			$header[] = 'City Name';
			$header[] = 'State Name';
			$header[] = 'Zip Code';
			$header[] = 'Mobile Number';
			$header[] = 'Alternate Mobile Number';			
			$header[] = 'Home Phone Number';	
			$header[] = 'Work Phone Number';	
			$header[] = 'Job Title';	
			$header[] = 'Fax';	
			$header[] = 'WebSite';	
			$header[] = 'License Number';	
			$header[] = 'Client Description';	
			$header[] = 'Group';	
			$header[] = 'Archive';	
			$filename='Reports/export_client.csv';
			$fh = fopen(LAWMS_PLUGIN_DIR.'/admin/'.$filename, 'w') or die("can't open file");
			fputcsv($fh, $header);
			foreach($contact_list as $retrive_data)
			{
				$client_status=get_user_meta($retrive_data->ID, 'archive',true);
				
				if(sanitize_text_field($_REQUEST['client_status']) == $client_status || sanitize_text_field($_REQUEST['client_status']) == '2')
				{
					$row = array();
					$user_info = get_userdata($retrive_data->ID);
					
					$row[] = esc_html($user_info->user_login);
					$row[] = esc_html($user_info->user_email);			
				
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'first_name',true));
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'middle_name',true));
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'last_name',true));
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'gender',true));
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'birth_date',true));
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'address',true));
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'city_name',true));
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'state_name',true));
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'pin_code',true));
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'mobile',true));
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'alternate_mobile',true));
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'phone_home',true));
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'phone_work',true));
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'job_title',true));
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'fax',true));
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'website',true));
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'license_number',true));
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'contact_description',true));
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'group',true));
					$row[] =  esc_html(get_user_meta($retrive_data->ID, 'archive',true));
					
					fputcsv($fh, $row);
				}
			}
			fclose($fh);
	
			//download csv file.
			$file=LAWMS_PLUGIN_DIR.'/admin/Reports/export_client.csv';//file location
			
			$mime = 'text/plain';
			header('Content-Type:application/force-download');
			header('Pragma: public');       // required
			header('Expires: 0');           // no cache
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file)).' GMT');
			header('Cache-Control: private',false);
			header('Content-Type: '.$mime);
			header('Content-Disposition: attachment; filename="'.basename($file).'"');
			header('Content-Transfer-Encoding: binary');
			//header('Content-Length: '.filesize($file_name));      // provide file size
			header('Connection: close');
			readfile($file);		
			exit;				
		}
		else
		{
			?>
				<div class="alert_msg alert alert-danger alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
					<?php esc_html_e('Records not found.','lawyer_mgt');?>
				</div>
			<?php	
		}		
	}
	//upload contact csv	//
	if(isset($_REQUEST['upload_contact_csv_file']))
	{		
		if(isset($_FILES['contact_csv_file']))
		{				
			$errors= array();
			$file_name = sanitize_file_name($_FILES['contact_csv_file']['name']);
			
			$file_size =sanitize_file_name($_FILES['contact_csv_file']['size']);
			$file_tmp =sanitize_text_field($_FILES['contact_csv_file']['tmp_name']);
			$file_type=sanitize_file_name($_FILES['contact_csv_file']['type']);
			$value = explode(".", $_FILES['contact_csv_file']['name']);
			$file_ext = strtolower(array_pop($value));
			$extensions = array("csv");
			$upload_dir = wp_upload_dir();
			 
			if(in_array($file_ext,$extensions )=== false)
			{
				$errors[]="please choose a CSV file.";
			}
			if($file_size > 2097152)
			{
				$errors[]='File size limit 2 MB';
			}			
			if(empty($errors)==true)
			{	
				$rows = array_map('str_getcsv', file($file_tmp));		
				 
				 			
				$header = array_map('strtolower',array_shift($rows));
				
				$csv = array();
				foreach ($rows as $row) 
				{			 
					$csv = array_combine($header, $row);
					$username = sanitize_user($csv['username']);
					$email = sanitize_email($csv['email']);
					$user_id = 0;
					$password = sanitize_text_field($csv['password']);
					$problematic_row = false;
					
					if( username_exists($username) )
					{ // if user exists, we take his ID by login
						$user_object = get_user_by( "login", $username );
						$user_id = $user_object->ID;
					
						if( !empty($password) )
							wp_set_password( $password, $user_id ); 
					}
					elseif( email_exists( $email ) )
					{ // if the email is registered, we take the user from this
						$user_object = get_user_by( "email", $email );
						$user_id = $user_object->ID;					
						$problematic_row = true;
					
						 if( !empty($password) )
							wp_set_password( $password, $user_id );  
					}
					else
					{
						if( empty($password) ) // if user not exist and password is empty but the column is set, it will be generated
							$password = wp_generate_password();
						$user_id = wp_create_user($username, $password, $email);
					}
					if( is_wp_error($user_id) )
					{ 
						// in case the user is generating errors after this checks
						echo '<script>alert("Problems with user: ' . esc_attr($username) . ', we are going to skip");</script>';
						continue;
					}

					if(!( in_array("administrator", MJ_lawmgt_get_roles($user_id), FALSE) || is_multisite() && is_super_admin( $user_id ) ))
						wp_update_user(array ('ID' => $user_id, 'role' => 'client')) ;
					update_user_meta( $user_id, "archive", 0 );
					 
					if(isset($csv['first name']))
						update_user_meta( $user_id, "first_name", sanitize_text_field($csv['first name']));
					 
					if(isset($csv['last name']))
						update_user_meta( $user_id, "last_name", sanitize_text_field($csv['last name']) );
					if(isset($csv['middle name']))
						update_user_meta( $user_id, "middle_name", sanitize_text_field($csv['middle name']) );
					if(isset($csv['gender']))
						update_user_meta( $user_id, "gender", sanitize_text_field($csv['gender']) );
					if(isset($csv['birth date']))
						update_user_meta( $user_id, "birth_date", sanitize_text_field($csv['birth date']) );
					if(isset($csv['address']))
						update_user_meta( $user_id, "address", sanitize_text_field($csv['address']));
					if(isset($csv['city name']))
						update_user_meta( $user_id, "city_name", sanitize_text_field($csv['city name']) );
					if(isset($csv['state name']))
						update_user_meta( $user_id, "state_name", sanitize_text_field($csv['state name']) );						
					if(isset($csv['zip code']))
						update_user_meta( $user_id, "pin_code", sanitize_text_field($csv['zip code']) );
					if(isset($csv['mobile number']))
						update_user_meta( $user_id, "mobile", sanitize_text_field($csv['mobile number']) );
					if(isset($csv['alternate mobile number']))
						update_user_meta( $user_id, "alternate_mobile", sanitize_text_field($csv['alternate mobile number']) );						
					if(isset($csv['home phone number']))
						update_user_meta( $user_id, "phone_home", sanitize_text_field($csv['home phone number']) );				
					
					if(isset($csv['work phone number']))
						update_user_meta( $user_id, "phone_work", sanitize_text_field(csv['work phone number']) );					
					if(isset($csv['job title']))
						update_user_meta( $user_id, "job_title", sanitize_text_field($csv['job title']) );					
					if(isset($csv['fax']))
						update_user_meta( $user_id, "fax", $csv['fax'] );					
					if(isset($csv['website']))
						update_user_meta( $user_id, "website", $csv['website'] );
					if(isset($csv['license number']))
						update_user_meta( $user_id, "license_number", sanitize_text_field($csv['license number']) );	
					if(isset($csv['client description']))
						update_user_meta( $user_id, "contact_description", sanitize_textarea_field($csv['client description']) );	
					 
					if(isset($csv['group']))
						update_user_meta( $user_id, "group", sanitize_text_field($csv['group']) );
					if(isset($csv['archive']))
						update_user_meta( $user_id, "archive", sanitize_text_field($csv['archive']) );							
					$success = 1;		
				}
			}
			else
			{
				foreach($errors as &$error) echo $error;
			}
			if(isset($success))
			{			
				//wp_redirect ( admin_url().'admin.php?page=contacts&tab=contactlist&message=7');
				$redirect_url=admin_url().'admin.php?page=contacts&tab=contactlist&message=7';
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
 
	if(isset($_POST['user_delete_selected']))
	{
		if (isset($_REQUEST['selected_id']))
		{	
			$all = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ) );
			foreach ($all as $record_id)
			{
				$result=update_usermeta($record_id,'archive',1);
			}	
		}
		else
		{
			?>
				<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
					<?php esc_html_e('Please Select At least One Record.','lawyer_mgt');?>
				</div>
		<?php		
		}	
		if($result)
		{
			//wp_redirect ( admin_url() . 'admin.php?page=contacts&tab=contactlist&tab1=active&message=6');
			$redirect_url=admin_url().'admin.php?page=contacts&tab=contactlist&tab1=active&message=6';
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
	if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='delete')
	{
		 if(isset($_REQUEST['contact_id']))
			{		
				$result=update_usermeta(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['contact_id'])),'archive',1);
				if($result)
				{
					//wp_redirect ( admin_url() . 'admin.php?page=contacts&tab=contactlist&tab1=active&message=6');
					$redirect_url=admin_url().'admin.php?page=contacts&tab=contactlist&tab1=active&message=6';
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
	//save_contact
	if(isset($_POST['save_contact']))
	{	
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_contact_nonce' ) )
		{ 
			if($_REQUEST['action']=='edit')
			{	
				$user_id=sanitize_text_field($_POST['user_id']);
				
				$result=$obj_user->MJ_lawmgt_add_user($_POST);
				// Custom Field File Update //
				$custom_field_file_array=array();		
				if(!empty($_FILES['custom_file']['name']))
				{
					$count_array=count($_FILES['custom_file']['name']);
					
					for($a=0;$a<$count_array;$a++)
					{			
						foreach($_FILES['custom_file'] as $image_key=>$image_val)
						{
							foreach($image_val as $image_key1=>$image_val2)
							{
								if($_FILES['custom_file']['name'][$image_key1]!='')
								{  	
									$custom_file_array[$image_key1]=array(
									'name'=>sanitize_file_name($_FILES['custom_file']['name'][$image_key1]),
									'type'=>sanitize_file_name($_FILES['custom_file']['type'][$image_key1]),
									'tmp_name'=>sanitize_text_field($_FILES['custom_file']['tmp_name'][$image_key1]),
									'error'=>sanitize_file_name($_FILES['custom_file']['error'][$image_key1]),
									'size'=>sanitize_file_name($_FILES['custom_file']['size'][$image_key1])
									);							
								}						
							}
						}
					}	
					
					if(!empty($custom_file_array))
					{
						foreach($custom_file_array as $key=>$value)		
						{	
							global $wpdb;
							$wpnc_custom_field_metas = $wpdb->prefix . 'lmgt_custom_field_metas';
			
							$get_file_name= $custom_file_array[$key]['name'];	
							$custom_field_file_value=MJ_lawmgt_load_documets($value,$value,$get_file_name);		
							
							//Add File in Custom Field Meta//				
							$module='contact';					
							$updated_at=date("Y-m-d H:i:s");
							$update_custom_meta_data =$wpdb->query($wpdb->prepare("UPDATE `$wpnc_custom_field_metas` SET `field_value` = '$custom_field_file_value',updated_at='$updated_at' WHERE `$wpnc_custom_field_metas`.`module` = %s AND  `$wpnc_custom_field_metas`.`module_record_id` = %d AND `$wpnc_custom_field_metas`.`custom_fields_id` = %d",$module,$result,$key));
						} 	
					}		 		
				}
			
				$update_custom_field=$custom_field->MJ_lawmgt_update_custom_field_metas('contact',$_POST['custom'],$result);
				//wp_redirect ( admin_url() . 'admin.php?page=contacts&tab=contactlist&tab1=active&message=5');
				$redirect_url=admin_url().'admin.php?page=contacts&tab=contactlist&tab1=active&message=5';
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
			else
			{
				if( !email_exists( sanitize_email($_POST['email']) ) && !username_exists( sanitize_user($_POST['username']))) 
				{	
					$result=$obj_user->MJ_lawmgt_add_user($_POST);
					// Custom Field File Insert //
					$custom_field_file_array=array();
					if(!empty($_FILES['custom_file']['name']))
					{
						$count_array=count($_FILES['custom_file']['name']);
						
						for($a=0;$a<$count_array;$a++)
						{			
							foreach($_FILES['custom_file'] as $image_key=>$image_val)
							{
								foreach($image_val as $image_key1=>$image_val2)
								{
									if($_FILES['custom_file']['name'][$image_key1]!='')
									{  	
										$custom_file_array[$image_key1]=array(
										'name'=>sanitize_file_name($_FILES['custom_file']['name'][$image_key1]),
										'type'=>sanitize_file_name($_FILES['custom_file']['type'][$image_key1]),
										'tmp_name'=>sanitize_text_field($_FILES['custom_file']['tmp_name'][$image_key1]),
										'error'=>sanitize_file_name($_FILES['custom_file']['error'][$image_key1]),
										'size'=>sanitize_file_name($_FILES['custom_file']['size'][$image_key1])
										);							
									}	
								}
							}
						}			
						if(!empty($custom_file_array))
						{
							foreach($custom_file_array as $key=>$value)		
							{	
								global $wpdb;
								$wpnc_custom_field_metas = $wpdb->prefix . 'lmgt_custom_field_metas';
				
								$get_file_name=$custom_file_array[$key]['name'];	
								
								$custom_field_file_value=MJ_lawmgt_load_documets($value,$value,$get_file_name);		
								
								//Add File in Custom Field Meta//
								$custom_meta_data['module']='contact';
								$custom_meta_data['module_record_id']=$result;
								$custom_meta_data['custom_fields_id']=$key;
								$custom_meta_data['field_value']=$custom_field_file_value;
								$custom_meta_data['created_at']=date("Y-m-d H:i:s");
								$custom_meta_data['updated_at']=date("Y-m-d H:i:s");	
								 
								
								$insert_custom_meta_data=$wpdb->insert($wpnc_custom_field_metas, $custom_meta_data );		
							} 	
						}		 		
					}
					$add_custom_field=$custom_field->MJ_lawmgt_add_custom_field_metas('contact',sanitize_text_field($_POST['custom']),$result);					
					 
					//wp_redirect ( admin_url() . 'admin.php?page=contacts&tab=contactlist&tab1=active&message=4');
					$redirect_url=admin_url().'admin.php?page=contacts&tab=contactlist&tab1=active&message=4';
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
				else
				{?>
					<div class="alert_msg alert alert-warning alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
						</button>
					<?php esc_html_e('Username Or Emailid All Ready Exist.','lawyer_mgt');?>
					</div>						
		  <?php }
			}
		}
	}		
	if(isset($_REQUEST['message']))
	{
		$message = sanitize_text_field($_REQUEST['message']);
		if($message == 4)
		{?>
	
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
				<?php esc_html_e('User Inserted Successfully','lawyer_mgt');?>
				</div>
				<?php 
			
		}
		elseif($message == 5)
		{?>
				<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
					<?php esc_html_e('User Updated Successfully','lawyer_mgt');?>
				</div>
				<?php 			
		}
		elseif($message == 6) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
             <?php esc_html_e('User Deleted Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}		
		elseif($message == 7) 
		{?>
			<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
             <?php esc_html_e('User Uploaded Successfully','lawyer_mgt');?>
			</div>
		<?php				
		}
		 		
	} 		
	?>
	<div id="main-wrapper">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<h2 class="nav-tab-wrapper">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="tablist">
								
								<li role="presentation" class="<?php echo $active_tab == 'contactlist' ? 'active' : ''; ?> menucss">
									<a href="?page=contacts&tab=contactlist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Client List', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo $active_tab == 'add_contact' ? 'active' : ''; ?> menucss">
								<?php  
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit' && isset($_REQUEST['contact_id']))
								{
									?>				
								<a href="?page=contacts&tab=add_contact&&action=edit&contact_id=<?php echo esc_attr( $_REQUEST['contact_id']);?>">
									<?php esc_html_e('Edit Client', 'lawyer_mgt'); ?>
								</a>  
								<?php 
								}									
								else
								{?>
									<a href="?page=contacts&tab=add_contact&&action=add">
										<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.esc_html__('Add Client', 'lawyer_mgt');?>
									</a>  
								<?php  
								}?>
								</li>
								<?php
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
								{
								?>	
									<li role="presentation" class="<?php echo $active_tab == 'viewcontact' ? 'active' : ''; ?> menucss">
										<a href="?page=contacts&tab=viewcontact&&action=view&contact_id=<?php echo esc_attr($_REQUEST['contact_id']);?>">
											<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('View Client', 'lawyer_mgt'); ?>
										</a>
									</li>
								<?php
								}
								if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
	                            {
								?>
								<li role="presentation" class="<?php echo $active_tab == 'uploadcontact' ? 'active' : ''; ?> menucss">
									<a href="?page=contacts&tab=uploadcontact">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Upload', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class="<?php echo $active_tab == 'exportcontact' ? 'active' : ''; ?> menucss">
									<a href="?page=contacts&tab=exportcontact">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Export', 'lawyer_mgt'); ?>
									</a>
								</li>
								<?php } ?>
							</ul>		
						</h2>
						<?php
						
						if($active_tab == 'contactlist')
						{
							require_once LAWMS_PLUGIN_DIR. '/admin/contacts/contact_list.php';
						}
						if($active_tab == 'add_contact')
						{
							if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
							{
								require_once LAWMS_PLUGIN_DIR. '/admin/contacts/add_contact.php';
							}	
							if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'add')
							{
								require_once LAWMS_PLUGIN_DIR. '/admin/contacts/add_contact.php';
							}
						}
						if($active_tab == 'viewcontact')
						{
							require_once LAWMS_PLUGIN_DIR. '/admin/contacts/view_contact.php';
						}
						if($active_tab == 'uploadcontact')
						{
							require_once LAWMS_PLUGIN_DIR. '/admin/contacts/uploadcontact.php';
						}
						if($active_tab == 'exportcontact')
						{
							require_once LAWMS_PLUGIN_DIR. '/admin/contacts/exportcontact.php';
						}
					 ?>
					</div>			
				</div>
			</div>
		</div>
	</div><!-- END  MAIN WRAPER  DIV -->
</div><!-- END  INNER PAGE  DIV -->