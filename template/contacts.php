<?php 
MJ_lawmgt_browser_javascript_check();
//access right
$user_access=MJ_lawmgt_get_userrole_wise_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')     
	{	
		MJ_lawmgt_access_right_page_not_access_message();
		die;
	}
	if(!empty($_REQUEST['action']))
	{
		if (sanitize_text_field(isset ( $_REQUEST ['page'] ) && sanitize_text_field($_REQUEST ['page']) == $user_access['page_link'] && (sanitize_text_field($_REQUEST['action'])=='edit')))
		{
			if($user_access['edit']=='0')
			{	
				MJ_lawmgt_access_right_page_not_access_message();
				die;
			}			
		}
		if (isset ( $_REQUEST ['page'] ) && sanitize_text_field($_REQUEST ['page']) == $user_access['page_link'] && (sanitize_text_field($_REQUEST['action'])=='delete'))
		{
			if($user_access['delete']=='0')
			{	
				MJ_lawmgt_access_right_page_not_access_message();
				die;
			}	
		}
		if (isset ( $_REQUEST ['page'] ) && sanitize_text_field($_REQUEST ['page']) == $user_access['page_link'] && (sanitize_text_field($_REQUEST['action'])=='add'))
		{
			if($user_access['add']=='0')
			{	
				MJ_lawmgt_access_right_page_not_access_message();
				die;
			}	
		} 
	}
}

$curr_user_id=get_current_user_id();	
$custom_field = new MJ_lawmgt_custome_field;
$obj_user=new MJ_lawmgt_Users;
$active_tab = sanitize_text_field(isset($_GET['tab'])?$_GET['tab']:'contactlist');
$userrole=MJ_lawmgt_get_current_user_role();
$result=null;
$contact_columns_array=explode(',',get_option('lmgt_contact_columns_option'));
?>
<!--<div class="page_inner_front with_Aa">--><!-- PAGE INNER DIV -->
<div ><!-- PAGE INNER DIV -->
	<?php
	//export contact in csv
	if(isset($_POST['exportcontacts_csv']))
	{
		
		if($user_role == 'attorney')
		{
			if($user_access['own_data'] == '1')
			{
				$obj_case=new MJ_lawmgt_case;
				$current_user_id = get_current_user_id();
				$attorney_cases=$obj_case->MJ_lawmgt_get_all_case_by_attorney_id($current_user_id);
				$client_data=array();
				$attorneydata1=array();
				if(!empty($attorney_cases))
				{		
					foreach($attorney_cases as $data)
					{
						$case_contact_assigned=explode(',',$data->user_id);	
						if(!empty($case_contact_assigned))
						{		
							foreach($case_contact_assigned as $data1)
							{
								$client_data[]=$data1;
							}
						}
					}	
				}
				$client_unique=array_unique($client_data);
				 if(!empty($client_unique))
				{		
					foreach($client_unique as $data1)
					{
						$contactdata1[]=get_userdata($data1);
					}	
				}  
				 
				$contactdata_2=$contactdata1; 

				$contactdata_3 = get_users(
					array(
						'role' => 'client',
						'meta_query' => array(						
						array(
								'key' => 'created_by',
								'value' =>get_current_user_id(),
								'compare' => '='
							),
						)
					));	
					$contactdata =array_merge($contactdata_2,$contactdata_3);
					
			}
			else			
			{	
				$contactdata =get_users(array('role'=>'client'));	
			}																
				
		}
		elseif($user_role == 'client')
		{
			if($user_access['own_data'] == '1')
			{	
				$user_id = get_current_user_id();
				$contactdata=array();
				$contactdata[]=get_userdata($user_id);	
			}
			else			
			{	
				$contactdata =get_users(array('role'=>'client'));
			}																
		}
		else
		{	
			if($user_access['own_data'] == '1')
			{
				$contactdata = get_users(
					array(
						'role' => 'client',
						'meta_query' => array(						
						array(
								'key' => 'created_by',
								'value' =>get_current_user_id(),
								'compare' => '='
							),
						)
					));	
			}
			else			
			{				
				$contactdata =get_users(array('role'=>'client'));
			}																
		}
															 
		if(!empty($contactdata))
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
			foreach($contactdata as $retrive_data)
			{
				$client_status=get_user_meta($retrive_data->ID, 'archive',true);
				if($_REQUEST['client_status'] == $client_status || sanitize_text_field($_REQUEST['client_status']) == '2')
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
	//upload contact csv	
	if(isset($_REQUEST['upload_contact_csv_file']))
	{		
		if(isset($_FILES['contact_csv_file']))
		{				
			$errors= array();
			$file_name = sanitize_file_name($_FILES['contact_csv_file']['name']);
			$file_size =sanitize_file_name($_FILES['contact_csv_file']['size']);
			$file_tmp =sanitize_text_field($_FILES['contact_csv_file']['tmp_name']);
			$file_type=sanitize_file_name($_FILES['contact_csv_file']['type']);
			//$file_ext=strtolower(end(explode('.',$_FILES['contact_csv_file']['name'])));
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
						echo '<script>alert("Problems with user: ' . $username . ', we are going to skip");</script>';
						continue;
					}

					if(!( in_array("administrator", MJ_lawmgt_get_roles($user_id), FALSE) || is_multisite() && is_super_admin( $user_id ) ))
						wp_update_user(array ('ID' => $user_id, 'role' => 'client')) ;
					update_user_meta( $user_id, "archive", 0 );
				
					if(isset($csv['first name']))
						update_user_meta( $user_id, "first_name", sanitize_text_field($csv['first name']) );
					 
					if(isset($csv['last name']))
						update_user_meta( $user_id, "last_name", sanitize_text_field($csv['last name']) );
					if(isset($csv['middle name']))
						update_user_meta( $user_id, "middle_name", sanitize_text_field($csv['middle name']) );
					if(isset($csv['gender']))
						update_user_meta( $user_id, "gender", sanitize_text_field($csv['gender']) );
					if(isset($csv['birth date']))
						update_user_meta( $user_id, "birth_date", sanitize_text_field($csv['birth date']) );
					if(isset($csv['address']))
						update_user_meta( $user_id, "address", sanitize_text_field($csv['address']) );
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
						update_user_meta( $user_id, "phone_work", sanitize_text_field($csv['work phone number']) );					
					if(isset($csv['job title']))
						update_user_meta( $user_id, "job_title", sanitize_text_field($csv['job title']) );					
					if(isset($csv['fax']))
						update_user_meta( $user_id, "fax", sanitize_text_field($csv['fax']) );					
					if(isset($csv['website']))
						update_user_meta( $user_id, "website", sanitize_url($csv['website']) );
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
				//wp_redirect ( home_url().'?dashboard=user&page=contacts&tab=contactlist&message=7');
				$redirect_url=home_url().'?dashboard=user&page=contacts&tab=contactlist&message=7';
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
	 if(isset($_REQUEST['action'])&& sanitize_text_field($_REQUEST['action'])=='delete')
	{
		 if(isset($_REQUEST['contact_id']))
			{		
				$result=update_usermeta(sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['contact_id'])),'archive',1);
				if($result)
				{
					//wp_redirect ( home_url().'?dashboard=user&page=contacts&tab=contactlist&tab1=active&message=6');
				   $redirect_url=home_url().'?dashboard=user&page=contacts&tab=contactlist&tab1=active&message=6';
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
            $all = array_map( 'sanitize_text_field', wp_unslash( $_POST["selected_id"] ));			
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
			//wp_redirect ( home_url() . '?dashboard=user&page=contacts&tab=contactlist&tab1=active&message=6');
			$redirect_url=home_url() . '?dashboard=user&page=contacts&tab=contactlist&tab1=active&message=6';
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
	 
	//save_contact
	if(isset($_POST['save_contact']))
	{	
		$nonce = sanitize_text_field($_POST['_wpnonce']);
		if (wp_verify_nonce( $nonce, 'save_contact_nonce' ) )
		{ 

				if(isset($_FILES['upload_user_avatar_image']) && !empty($_FILES['upload_user_avatar_image']) && $_FILES['upload_user_avatar_image']['size'] !=0)
				{
					if($_FILES['upload_user_avatar_image']['size'] > 0)
					{
						$image=MJ_lawmgt_load_documets($_FILES['upload_user_avatar_image'],$_FILES['upload_user_avatar_image'],'pimg');
					
						$image_url=sanitize_url(content_url().'/uploads/document_upload/'.$image);

					}
					else 
					{
						$image=sanitize_url($_REQUEST['hidden_upload_user_avatar_image']);
						$image_url=sanitize_url($image);
					}					
				}
				else
				{
					if(isset($_REQUEST['hidden_upload_user_avatar_image']))
						$image=sanitize_url($_REQUEST['hidden_upload_user_avatar_image']);
						$image_url=sanitize_url($image);
				}
				
			if($_REQUEST['action']=='edit')
			{					
				$user_id=sanitize_text_field($_POST['user_id']);
				
				
				$result=$obj_user->MJ_lawmgt_add_user($_POST);
				
				$returnans=update_user_meta( $result,'lmgt_user_avatar',$image_url);
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
			
							$get_file_name=$custom_file_array[$key]['name'];	
							
							$custom_field_file_value=MJ_lawmgt_load_documets($value,$value,$get_file_name);		
							
							//Add File in Custom Field Meta//				
							$module='contact';					
							$updated_at=date("Y-m-d H:i:s");
							$update_custom_meta_data =$wpdb->query($wpdb->prepare("UPDATE `$wpnc_custom_field_metas` SET `field_value` = '$custom_field_file_value',updated_at='$updated_at' WHERE `$wpnc_custom_field_metas`.`module` = %s AND  `$wpnc_custom_field_metas`.`module_record_id` = %d AND `$wpnc_custom_field_metas`.`custom_fields_id` = %d",$module,$result,$key));
						} 	
					}		 		
				}
			
				$update_custom_field=$custom_field->MJ_lawmgt_update_custom_field_metas('contact', sanitize_text_field($_POST['custom']),$result);
				//wp_redirect ( home_url() . '?dashboard=user&page=contacts&tab=contactlist&tab1=active&message=5');
				$redirect_url=home_url() . '?dashboard=user&page=contacts&tab=contactlist&tab1=active&message=5';
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
				if( !email_exists( sanitize_email($_POST['email']) ) && !username_exists( sanitize_user($_POST['username']))) {
		
					$result=$obj_user->MJ_lawmgt_add_user($_POST);

					$returnans=update_user_meta( $result,'lmgt_user_avatar',$image_url);	
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
					$add_custom_field=$custom_field->MJ_lawmgt_add_custom_field_metas('contact', sanitize_text_field($_POST['custom']),$result);
					//wp_redirect ( home_url() . '?dashboard=user&page=contacts&tab=contactlist&tab1=active&message=4');
					$redirect_url=home_url() . '?dashboard=user&page=contacts&tab=contactlist&tab1=active&message=4';
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
		$message =sanitize_text_field($_REQUEST['message']);
		 
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
	<div id="main-wrapper"><!-- MAIN WRAPER  DIV -->
		<div class="row"><!-- ROW  DIV -->
			<div class="panel-body width_100">
			<!--<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">-->
				<div class="panel panel-white">
					<div class="panel-body panel_body_flot_css"><!-- PANEL BODY DIV -->
						<h2 class="nav-tab-wrapper contact margin_bottom">
							<ul id="myTab" class="nav nav-tabs bar_tabs cus_tab_font" role="tablist">
								<li role="presentation" class="<?php echo $active_tab == 'contactlist' ? 'active' : ''; ?> menucss active_mt">
									<a href="?dashboard=user&page=contacts&tab=contactlist">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Client List', 'lawyer_mgt'); ?>
									</a>
								</li>	
								<?php
								if($user_access['add']=='1')
									{
								?>			
								<li role="presentation" class="<?php echo $active_tab == 'add_contact' ? 'active' : ''; ?> menucss tab_mt">
									<?php  
									if(sanitize_text_field(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit' && isset($_REQUEST['contact_id'])))
									{
										?>				
										<a href="?dashboard=user&page=contacts&tab=add_contact&&action=edit&contact_id=<?php echo esc_attr($_REQUEST['contact_id']);?>">
										<?php esc_html_e('Edit Client', 'lawyer_mgt'); ?>
										</a>  
									<?php 
									}					
									else
									{
										
											?>
											<a href="?dashboard=user&page=contacts&tab=add_contact&&action=add">
												<?php echo '<span class="fa fa-plus-circle"></span> '.esc_html__('Add Client', 'lawyer_mgt');?>
											</a>  
										<?php 
																				
									}?>
								</li>
								<?php
									}
								?>	
								<?php
								
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
								{
								?>
									<li role="presentation" class="<?php echo $active_tab == 'viewcontact' ? 'active' : ''; ?> menucss tab_mt">
										<a href="?dashboard=user&page=contacts&tab=viewcontact&&action=view&contact_id=<?php echo esc_attr($_REQUEST['contact_id']);?>">
											<?php echo '<span class="dashicons dashicons-welcome-view-site"></span> '.esc_html__('View Client', 'lawyer_mgt');?>
										</a>  
									</li>									
								<?php  
								}
								if($user_access['add']=='1')
								{
								?>
								<?php 
								if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
	                            { ?>
								<li role="presentation" class="<?php echo $active_tab == 'uploadcontact' ? 'active' : ''; ?> menucss upload_css">
									<a href="?dashboard=user&page=contacts&tab=uploadcontact">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Upload', 'lawyer_mgt'); ?>
									</a>
								</li>
								<li role="presentation" class=" margin_bottom <?php echo $active_tab == 'exportcontact' ? 'active' : ''; ?> menucss upload_css">
									<a href="?dashboard=user&page=contacts&tab=exportcontact">
										<?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Export', 'lawyer_mgt'); ?>
									</a>
								</li>	
								<?php  
								}
								}
								?>								
							</ul>		
						</h2>
						<?php 				
						if($active_tab == 'contactlist') /* CONTACT LIST TAB */
						{
							$obj_user=new MJ_lawmgt_Users;
							?>
							<div class="row">
								<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">		
									<?php
									$active_tab = sanitize_text_field(isset($_GET['tab1'])?$_GET['tab1']:'active');
									?>	
									<script type="text/javascript">
										jQuery(document).ready(function($)
										{
											"use strict"; 
											jQuery('.contact_list').DataTable({
											//"responsive": true,
											"autoWidth": false,
											"order": [[ 1, "asc" ]],
											language:<?php echo wpnc_datatable_multi_language();?>,
											 "aoColumns":[
														  {"bSortable": false},
														  <?php if(in_array('photo',$contact_columns_array)) { ?>
														  {"bSortable": false},
														  <?php } ?>
														  <?php if(in_array('contact_name',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('date_of_birth',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('contact_email',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('mobile_no',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('contact_case_link',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('group',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('address',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('contact_city',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('contact_state',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('job_title',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('gender',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('pin_code',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('alternate_no',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('phone_home',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('phone_work',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('fax',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('license_no',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('website',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('contact_description',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  {"bSortable": false}
													   ]		               		
											});
											$(".delete_check").on('click', function()
											{	
												"use strict"; 
												if ($('.sub_chk:checked').length == 0 )
												{
													 alert("<?php esc_html_e('Please select atleast one record','lawyer_mgt');?>");
													return false;
												}
												else{
													alert("<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>");
													return true;
												}
												 
											});	 
											jQuery('.contact_list2').DataTable({
											//"responsive": true,
											"autoWidth": false,
											"order": [[ 1, "asc" ]],
											language:<?php echo wpnc_datatable_multi_language();?>,
											 "aoColumns":[
														  <?php if(in_array('photo',$contact_columns_array)) { ?>
														  {"bSortable": false},
														  <?php } ?>
														  <?php if(in_array('contact_name',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('date_of_birth',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('contact_email',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('mobile_no',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('contact_case_link',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('group',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('address',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('contact_city',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('contact_state',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('job_title',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('gender',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('pin_code',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('alternate_no',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('phone_home',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('phone_work',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('fax',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('license_no',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('website',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
														  <?php if(in_array('contact_description',$contact_columns_array)) { ?>
														  {"bSortable": true},
														  <?php } ?>
													   ]		               		
												});	
										} );
										jQuery(document).ready(function($)
										{		
											"use strict"; 
											jQuery('#select_all').on('click', function(e)
											{
												 if($(this).is(':checked',true))  
												 {
													$(".sub_chk").prop('checked', true);  
												 }  
												 else  
												 {  
													$(".sub_chk").prop('checked',false);  
												 } 
											});
											$("body").on("change", ".sub_chk", function()
											{ 
												if(false == $(this).prop("checked"))
												{ 
													$("#select_all").prop('checked', false); 
												}
												if ($('.sub_chk:checked').length == $('.sub_chk').length )
												{
													$("#select_all").prop('checked', true);
												}
											});
										});
									</script>	
									<h2>
										<ul class="sub_menu_css line nav nav-tabs" id="myTab" role="tablist">
											<li role="presentation" class="<?php echo $active_tab == 'active' ? 'active' : ''; ?> menucss">
												<a href="?dashboard=user&page=contacts&tab=contactlist&tab1=active">
												<?php echo esc_html__('Active', 'lawyer_mgt'); ?>
												</a>
											</li>
											<li role="presentation" class="<?php echo $active_tab == 'archived' ? 'active' : ''; ?> menucss">
												<a href="?dashboard=user&page=contacts&tab=contactlist&tab1=archived">
												<?php echo esc_html__('Archived', 'lawyer_mgt'); ?>
												</a>
											</li>			
										</ul>
									</h2> 
									<?php
									if($active_tab == 'active')
									{ 
									?>
										<div class="panel-body">	
											<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">	
												<table id="contact_list1" class="contact_list table csv_data table-striped table-bordered">
													<thead>	
														<tr>
															<th><input type="checkbox" id="select_all"></th>	
															<?php if(in_array('photo',$contact_columns_array)) { ?>
																<th class="width_80_px_css"><?php  esc_html_e('Photo', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('contact_name',$contact_columns_array)) { ?>
																<th><?php esc_html_e('Client Name', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('date_of_birth',$contact_columns_array)) { ?>
																<th><?php esc_html_e('Date Of Birth', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
														 
															<?php if(in_array('contact_email',$contact_columns_array)) { ?>
																<th> <?php esc_html_e('Client Email', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('mobile_no',$contact_columns_array)) { ?>
																<th> <?php esc_html_e('Mobile Number', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('contact_case_link',$contact_columns_array)) { ?>
																<th> <?php esc_html_e('Case Link', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('group',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Group', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('address',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Address', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('contact_city',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('City', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('contact_state',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('State', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('job_title',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Job Title', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('gender',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Gender', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('pin_code',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Pincode', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('alternate_no',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Alternate Mobile No', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('phone_home',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Phone Home', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('phone_work',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Phone Work', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('fax',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Fax', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('license_no',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('License No', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('website',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Website', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('contact_description',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Description', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<th><?php  esc_html_e('Action', 'lawyer_mgt' ) ;?></th>
														</tr>
														<br/>
													</thead>
													<tbody>			 
														<?php			
														if($user_role == 'attorney')
														{
															if($user_access['own_data'] == '1')
															{
																$obj_case=new MJ_lawmgt_case;
																$current_user_id = get_current_user_id();
																$attorney_cases=$obj_case->MJ_lawmgt_get_all_case_by_attorney_id($current_user_id);
																$client_data=array();
																$attorneydata1=array();
																if(!empty($attorney_cases))
																{		
																	foreach($attorney_cases as $data)
																	{
																		$case_contact_assigned=explode(',',$data->user_id);	
																		if(!empty($case_contact_assigned))
																		{		
																			foreach($case_contact_assigned as $data1)
																			{
																				$client_data[]=$data1;
																			}
																		}
																	}	
																}
																$client_unique=array_unique($client_data);
																 if(!empty($client_unique))
																{		
																	foreach($client_unique as $data1)
																	{
																		$contactdata1[]=get_userdata($data1);
																	}	
																}  
																 
																$contactdata_2=$contactdata1; 

																$contactdata_3 = get_users(
																	array(
																		'role' => 'client',
																		'meta_query' => array(
																		array(
																				'key' => 'archive',
																				'value' =>'0',
																				'compare' => '='
																			),
																		array(
																				'key' => 'created_by',
																				'value' =>get_current_user_id(),
																				'compare' => '='
																			),
																		)
																	));	
																	if(!empty($contactdata_2) OR (!empty($contactdata_3 )))
																	{
																	   $contactdata =array_merge($contactdata_2,$contactdata_3);
																	}
;
																	
															}
															else			
															{	
																$args = array(	
																		'role' => 'client',
																		'meta_key'     => 'archive',
																		'meta_value'   => '0',
																		'meta_compare' => '=',
																	); 	
																$contactdata =get_users($args);		
															}																
															 	
														}
														elseif($user_role == 'client')
														{
															if($user_access['own_data'] == '1')
															{
																 
																$user_id = get_current_user_id();
																$contactdata=array();
																$contactdata[]=get_userdata($user_id);	
															}
															else			
															{	
																 
																$args = array(	
																		'role' => 'client',
																		'meta_key'     => 'archive',
																		'meta_value'   => '0',
																		'meta_compare' => '=',
																	); 	
																$contactdata =get_users($args);	
															}																
														}
														else
														{	
															if($user_access['own_data'] == '1')
															{
																$contactdata = get_users(
																	array(
																		'role' => 'client',
																		'meta_query' => array(
																		array(
																				'key' => 'archive',
																				'value' =>'0',
																				'compare' => '='
																			),
																		array(
																				'key' => 'created_by',
																				'value' =>get_current_user_id(),
																				'compare' => '='
																			),
																		)
																	));	
															}
															else			
															{
																$args = array(	
																		'role' => 'client',
																		'meta_key'     => 'archive',
																		'meta_value'   => '0',
																		'meta_compare' => '=',
																	); 	
																$contactdata =get_users($args);	
															}																
														}
															if(!empty($contactdata))
															{
																foreach ($contactdata as $retrieved_data)
																{	
																	if($retrieved_data->archive == '0')
																	{
																	
																	$contact_id=$retrieved_data->ID;
																	
																	$contact_caselink=array();
																	global $wpdb;
																	$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
																	$table_cases = $wpdb->prefix. 'lmgt_cases';
																	$result_caselink= $wpdb->get_results("SELECT case_id FROM $table_case_contacts where user_id=".$contact_id);
																	foreach ($result_caselink as $key => $object)
																	{			
																		$case_id=$object->case_id;
																		$case_name= $wpdb->get_results("SELECT id,case_name FROM $table_cases where id=".$case_id);

																		foreach ($case_name as $key => $object)
																		{										
																			$contact_caselink[]='<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($object->id)).'">'.esc_html($object->case_name).'</a>';
																		}					
																	}							
																	$caselink=implode(',',$contact_caselink);

																	 
																	?>
																	<tr>
																		<td class="title"><input type="checkbox" name="selected_id[]" class="sub_chk" value="<?php echo $retrieved_data->ID; ?>"></td>				
																		<?php if(in_array('photo',$contact_columns_array)) { ?>	
																				<td class="user_image"><?php $uid=$retrieved_data->ID;
																				$userimage=get_user_meta($uid, 'lmgt_user_avatar', true);
																				if(empty($userimage))
																				{
																				echo '<img src='.esc_url(get_option( 'lmgt_system_logo' )).' height="50px" width="50px" class="img-circle" />';
																				}
																			else
																			{
																				echo '<img src='.esc_url($userimage).' height="50px" width="50px" class="img-circle"/>';
																			}?>
																				</td>
																		 <?php } ?>	
																		 
																		<?php 
																		if(in_array('contact_name',$contact_columns_array)) 
																		{
																			?>
																			<td class="name">
																			 <?php echo esc_html($retrieved_data->display_name); ?> 
																			</td>
																			<?php  
																		}?>	
																		<?php if(in_array('date_of_birth',$contact_columns_array)) { ?>	
																				<td class="company"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->birth_date));?></td>
																		<?php } ?>	
																		 
																		<?php if(in_array('contact_email',$contact_columns_array)) { ?>		
																				<td class="email"><?php echo esc_html($retrieved_data->user_email);?></td>
																		<?php } ?>	
																		<?php if(in_array('mobile_no',$contact_columns_array)) { ?>		
																				<td class="mobile"><?php echo esc_html($retrieved_data->mobile);?></td>
																		<?php } ?>	
																		<?php if(in_array('contact_case_link',$contact_columns_array)) { ?>		
																				<td class="caselink"><?php echo $caselink;?></td>
																		<?php } ?>	
																		<?php if(in_array('group',$contact_columns_array)) { ?>		
																				<td class="contactgroup"><?php echo get_the_title($retrieved_data->group);?></td>
																		<?php } ?>	
																		<?php if(in_array('address',$contact_columns_array)) { ?>
																				<td class=""><?php echo esc_html($retrieved_data->address);?></td>
																		<?php } ?>	
																		<?php if(in_array('contact_city',$contact_columns_array)) { ?>		
																				<td class=""><?php echo esc_html($retrieved_data->city_name);?></td>
																		<?php } ?>	
																		<?php if(in_array('contact_state',$contact_columns_array)) { ?>		
																				<td class=""><?php echo esc_html($retrieved_data->state_name);?></td>
																		<?php } ?>	
																		<?php if(in_array('job_title',$contact_columns_array)) { ?>		
																				<td class=""><?php echo esc_html($retrieved_data->job_title);?></td>
																		<?php } ?>	
																		<?php if(in_array('gender',$contact_columns_array)) { ?>
																				<td class=""><?php echo esc_html($retrieved_data->gender);?></td>
																		<?php } ?>	
																		<?php if(in_array('pin_code',$contact_columns_array)) { ?>
																				<td class=""><?php echo esc_html($retrieved_data->pin_code);?></td>
																		<?php } ?>	
																		<?php if(in_array('alternate_no',$contact_columns_array)) { ?>		
																				<td class=""><?php echo esc_html($retrieved_data->alternate_mobile);?></td>
																		<?php } ?>	
																		<?php if(in_array('phone_home',$contact_columns_array)) { ?>		
																				<td class=""><?php echo esc_html($retrieved_data->phone_home);?></td>
																		<?php } ?>	
																		<?php if(in_array('phone_work',$contact_columns_array)) { ?>		
																				<td class=""><?php echo esc_html($retrieved_data->phone_work);?></td>
																		<?php } ?>	
																		<?php if(in_array('fax',$contact_columns_array)) { ?>		
																				<td class=""><?php echo esc_html($retrieved_data->fax);?></td>
																		<?php } ?>	
																		<?php if(in_array('license_no',$contact_columns_array)) { ?>		
																				<td class=""><?php echo esc_html($retrieved_data->license_number);?></td>
																		<?php } ?>	
																		<?php if(in_array('website',$contact_columns_array)) { ?>		
																				<td class=""><?php echo esc_html($retrieved_data->website);?></td>
																		<?php } ?>	
																		<?php if(in_array('contact_description',$contact_columns_array)) { ?>		
																				<td class=""><?php echo esc_html($retrieved_data->contact_description);?></td>
																		<?php } ?>
																		<td class="action"> 
																		 
																				<a href="?dashboard=user&page=contacts&tab=viewcontact&action=view&contact_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>" class="btn btn-success"> <?php esc_html_e('View', 'lawyer_mgt' ) ;?></a>
																		<?php 
																		if($user_access['edit']=='1')
																		{
																		?>	
																			<a href="?dashboard=user&page=contacts&tab=add_contact&action=edit&contact_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>" class="btn btn-info"> <?php esc_html_e('Edit', 'lawyer_mgt' ) ;?></a>
																		<?php
																		}
																		if($user_access['delete']=='1')
																		{
																		?>	
																			<a href="?dashboard=user&page=contacts&tab=contactlist&action=delete&contact_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>" class="btn btn-danger" 
																			onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','lawyer_mgt');?>');">
																			<?php esc_html_e('Delete', 'lawyer_mgt' ) ;?> </a>	
																		<?php
																		}
																		?>		
																		</td>               
																	</tr>
														<?php 	} 			
															}
														}
														?>     
													</tbody> 
												</table>
												<?php
												if($user_access['delete']=='1')
												{
													if(!empty($contactdata))
														{
												?>	
													<div class="form-group">		
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 delete_padding_left">	
															<input type="submit" class="btn delete_check  delete_margin_bottom btn-danger" name="user_delete_selected"  value="<?php esc_attr_e('Delete', 'lawyer_mgt' ) ;?> " />
														</div>
													</div>
												<?php
														}
												}
												?>	
											</div>
										</div>       
									<?php
									}  /* CONTACT LIST TAB */
									if($active_tab=='archived')  /* START ARCHIVE TAB */
									{
									?>	
										<div class="panel-body">	
											<div class="table-responsive col-lg-12 col-md-12 col-xs-12 col-sm-12">	
												<table id="contact_list2" class="contact_list2 table csv_data table-striped table-bordered width_100_per">
													<thead>	
														<tr>
															<?php if(in_array('photo',$contact_columns_array)) { ?>
																<th class="width_80_px_css"><?php  esc_html_e('Photo', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('contact_name',$contact_columns_array)) { ?>
																<th><?php esc_html_e('Client Name', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('date_of_birth',$contact_columns_array)) { ?>
																<th><?php esc_html_e('Date Of Birth', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															 
															<?php if(in_array('contact_email',$contact_columns_array)) { ?>
																<th> <?php esc_html_e('Client Email', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('mobile_no',$contact_columns_array)) { ?>
																<th> <?php esc_html_e('Mobile Number', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('contact_case_link',$contact_columns_array)) { ?>
																<th> <?php esc_html_e('Case Link', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('group',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Group', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('address',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Address', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('contact_city',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('City', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('contact_state',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('State', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('job_title',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Job Title', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('gender',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Gender', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('pin_code',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Pincode', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('alternate_no',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Alternate Mobile No', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('phone_home',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Phone Home', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('phone_work',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Phone Work', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('fax',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Fax', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('license_no',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('License No', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('website',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Website', 'lawyer_mgt' ) ;?></th>
															<?php } ?>
															<?php if(in_array('contact_description',$contact_columns_array)) { ?>
																<th><?php  esc_html_e('Description', 'lawyer_mgt' ) ;?></th>
															<?php } ?>	
														</tr>
														<br/>
													</thead>
													<tbody>
														<?php
														if($user_role == 'attorney')
														{
															if($user_access['own_data'] == '1')
															{
																$obj_case=new MJ_lawmgt_case;
																$current_user_id = get_current_user_id();
																$attorney_cases=$obj_case->MJ_lawmgt_get_all_case_by_attorney_id($current_user_id);
																$client_data=array();
																$attorneydata1=array();
																if(!empty($attorney_cases))
																{		
																	foreach($attorney_cases as $data)
																	{
																		$case_contact_assigned=explode(',',$data->user_id);	
																		if(!empty($case_contact_assigned))
																		{		
																			foreach($case_contact_assigned as $data1)
																			{
																				$client_data[]=$data1;
																			}
																		}
																	}	
																}
																$client_unique=array_unique($client_data);
																 if(!empty($client_unique))
																{		
																	foreach($client_unique as $data1)
																	{
																		$contactdata1[]=get_userdata($data1);
																	}	
																}  
																 
																$contactdata_2=$contactdata1; 

																$contactdata_3 = get_users(
																	array(
																		'role' => 'client',
																		'meta_query' => array(
																		array(
																				'key' => 'archive',
																				'value' =>'1',
																				'compare' => '='
																			),
																		array(
																				'key' => 'created_by',
																				'value' =>get_current_user_id(),
																				'compare' => '='
																			),
																		)
																	));	
																	$contactdata =array_merge($contactdata_2,$contactdata_3);
																	
															}
															else			
															{	
																$args = array(	
																		'role' => 'client',
																		'meta_key'     => 'archive',
																		'meta_value'   => '1',
																		'meta_compare' => '=',
																	); 	
																$contactdata =get_users($args);		
															}																
															 	
														}
														elseif($user_role == 'client')
														{
															if($user_access['own_data'] == '1')
															{	
																$user_id = get_current_user_id();
																$contactdata=array();
																$contactdata[]=get_userdata($user_id);	
															}
															else			
															{	
																$args = array(	
																		'role' => 'client',
																		'meta_key'     => 'archive',
																		'meta_value'   => '1',
																		'meta_compare' => '=',
																	); 	
																$contactdata =get_users($args);	
															}																
														}
														else
														{	
															if($user_access['own_data'] == '1')
															{
																$contactdata = get_users(
																	array(
																		'role' => 'client',
																		'meta_query' => array(
																		array(
																				'key' => 'archive',
																				'value' =>'1',
																				'compare' => '='
																			),
																		array(
																				'key' => 'created_by',
																				'value' =>get_current_user_id(),
																				'compare' => '='
																			),
																		)
																	));	
															}
															else			
															{
																$args = array(	
																		'role' => 'client',
																		'meta_key'     => 'archive',
																		'meta_value'   => '1',
																		'meta_compare' => '=',
																	); 	
																$contactdata =get_users($args);	
															}																
														}														
														
															if(!empty($contactdata))
															{
																foreach ($contactdata as $retrieved_data)
																{
																	if($retrieved_data->archive == '1')
																	{
																	$contact_id=$retrieved_data->ID;
																	
																	$contact_caselink=array();
																	global $wpdb;
																	$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
																	$table_cases = $wpdb->prefix. 'lmgt_cases';
																	$result_caselink= $wpdb->get_results("SELECT case_id FROM $table_case_contacts where user_id=".$contact_id);
																	
																   foreach ($result_caselink as $key => $object)
																   {			
																	 $case_id=$object->case_id;
																	 $case_name= $wpdb->get_results("SELECT id,case_name FROM $table_cases where id=".$case_id);
																	  foreach ($case_name as $key => $object)
																	  {	
																		$contact_caselink[]='<a href="?dashboard=user&page=cases&tab=casedetails&action=view&tab2=caseinfo&case_id='.MJ_lawmgt_id_encrypt(esc_attr($object->id)).'">'.esc_html($object->case_name).'</a>';
																	  }					
																  }							
																$caselink=implode(',',$contact_caselink);
																?>
																<tr>
																	<?php if(in_array('photo',$contact_columns_array)) { ?>	
																			<td class="user_image"><?php $uid=$retrieved_data->ID;
																			$userimage=get_user_meta($uid, 'lmgt_user_avatar', true);
																			if(empty($userimage))
																			{
																			echo '<img src='.esc_url(get_option( 'lmgt_system_logo' )).' height="50px" width="50px" class="img-circle" />';
																			}
																			else
																			{
																			echo '<img src='.esc_url($userimage).' height="50px" width="50px" class="img-circle"/>';
																			}
																		?>
																			</td>
																	 <?php } ?>	
																	 <?php if(in_array('contact_name',$contact_columns_array)) { 
																			if($user_role == 'client')
																			{
																				?>
																				<td class="name">
																				<?php   if($retrieved_data->ID == $curr_user_id)
																				{	 ?>
																				<a href="?dashboard=user&page=contacts&tab=viewcontact&action=view&contact_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>"><?php echo esc_html($retrieved_data->display_name);?></a>
																				<?php  } 
																				else{
																				?>
																				 <?php echo esc_html($retrieved_data->display_name); ?> 
																				</td>
																				<?php  }
																				
																			}
																			else
																			{?>
																				<td class="name">
																				 
																				<a href="?dashboard=user&page=contacts&tab=viewcontact&action=view&contact_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($retrieved_data->ID));?>"><?php echo esc_html($retrieved_data->display_name); ?></a>
																				</td>
																				<?php
																			} 
																		} ?>	
																	<?php if(in_array('date_of_birth',$contact_columns_array)) { ?>	
																			<td class="company"><?php echo esc_html(MJ_lawmgt_getdate_in_input_box($retrieved_data->birth_date));?></td>
																	<?php } ?>	
																	 
																	<?php if(in_array('contact_email',$contact_columns_array)) { ?>		
																			<td class="email"><?php echo esc_html($retrieved_data->user_email);?></td>
																	<?php } ?>	
																	<?php if(in_array('mobile_no',$contact_columns_array)) { ?>		
																			<td class="mobile"><?php echo esc_html($retrieved_data->mobile);?></td>
																	<?php } ?>	
																	<?php if(in_array('contact_case_link',$contact_columns_array)) { ?>		
																			<td class="caselink"><?php echo $caselink;?></td>
																	<?php } ?>	
																	<?php if(in_array('group',$contact_columns_array)) { ?>		
																			<td class="contactgroup"><?php echo esc_html(get_the_title($retrieved_data->group));?></td>
																	<?php } ?>	
																	<?php if(in_array('address',$contact_columns_array)) { ?>
																			<td class=""><?php echo esc_html($retrieved_data->address);?></td>
																	<?php } ?>	
																	<?php if(in_array('contact_city',$contact_columns_array)) { ?>		
																			<td class=""><?php echo esc_html($retrieved_data->city_name);?></td>
																	<?php } ?>	
																	<?php if(in_array('contact_state',$contact_columns_array)) { ?>		
																			<td class=""><?php echo esc_html($retrieved_data->state_name);?></td>
																	<?php } ?>	
																	<?php if(in_array('job_title',$contact_columns_array)) { ?>		
																			<td class=""><?php echo esc_html($retrieved_data->job_title);?></td>
																	<?php } ?>	
																	<?php if(in_array('gender',$contact_columns_array)) { ?>
																			<td class=""><?php echo esc_html($retrieved_data->gender);?></td>
																	<?php } ?>	
																	<?php if(in_array('pin_code',$contact_columns_array)) { ?>
																			<td class=""><?php echo esc_html($retrieved_data->pin_code);?></td>
																	<?php } ?>	
																	<?php if(in_array('alternate_no',$contact_columns_array)) { ?>		
																			<td class=""><?php echo esc_html($retrieved_data->alternate_mobile);?></td>
																	<?php } ?>	
																	<?php if(in_array('phone_home',$contact_columns_array)) { ?>		
																			<td class=""><?php echo esc_html($retrieved_data->phone_home);?></td>
																	<?php } ?>	
																	<?php if(in_array('phone_work',$contact_columns_array)) { ?>		
																			<td class=""><?php echo esc_html($retrieved_data->phone_work);?></td>
																	<?php } ?>	
																	<?php if(in_array('fax',$contact_columns_array)) { ?>		
																			<td class=""><?php echo esc_html($retrieved_data->fax);?></td>
																	<?php } ?>	
																	<?php if(in_array('license_no',$contact_columns_array)) { ?>		
																			<td class=""><?php echo esc_html($retrieved_data->license_number);?></td>
																	<?php } ?>	
																	<?php if(in_array('website',$contact_columns_array)) { ?>		
																			<td class=""><?php echo esc_html($retrieved_data->website);?></td>
																	<?php } ?>	
																	<?php if(in_array('contact_description',$contact_columns_array)) { ?>		
																			<td class=""><?php echo esc_html($retrieved_data->contact_description);?></td>
																	<?php } ?>		
																</tr>
																<?php 
																} 
															}														
														} 
														?>     
													</tbody> 
												</table>
										   </div>
									  </div>      
									<?php	
									}
									?>
								</div>			
							</div>
						<?php
						} /* CONTACT LIST TAB */
						if($active_tab == 'add_contact')  /* ADD Contact TAB */
						{
							$role='client';
							$obj_user=new MJ_lawmgt_Users;
							?>
							 <!--Group POP up code -->

							<div class="popup-bg">
								<div class="overlay-content">
									<div class="modal-content">
										<div class="group_list">
										</div>     
									</div>
								</div>     
							</div>
							<!-- End Group POP-UP Code -->
							<!--Custom Field POP up code -->
							<div class="popup-bg1">
								<div class="overlay-content">
								<div class="modal-content">
									<div class="Customfield_list">
									</div>     
								</div>
								</div>     
							</div>
							<!-- End Custom Field POP-UP Code -->
							<script type="text/javascript">
								jQuery(document).ready(function($)
								{
									"use strict"; 	
									$('#contact_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
									$('#birth_date').datepicker({
										  changeMonth: true,
											changeYear: true,
											yearRange:'-65:+0',
											endDate: '+0d',
											autoclose: true,
											onChangeMonthYear: function(year, month, inst) 
											{
												$(this).val(month + "/" + year);
											}                   
									   });	
									   //user name not  allow space validation
									$('#username').keypress(function( e ) {
									   if(e.which === 32) 
											return false;
									});		

								});
								function MJ_lawmgt_ValidateFax() 
								{
									"use strict"; 
									var regex = new RegExp("^\\+[0-9]{1,3}-[0-9]{3}-[0-9]{7}$");
									var fax = document.getElementById("fax").value;
									if (fax != '')
									{
										if (regex.test(fax))
										{
											//alert("Fax no is valid");
										} 
										else 
										{
											alert("<?php esc_html_e('Fax no is invalid','lawyer_mgt');?>");
											$('#fax').val('');
										}
									} 
								}
							</script>
							<?php 	
							$contact_id=0;
							$edit=0;
							if(isset($_REQUEST['contact_id']))
								$contact_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['contact_id']));
							if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
							{									
								$edit=1;
								$user_info = get_userdata($contact_id);										
							}?>
							
							<div class="panel-body custom_field"><!-- PANEL BODY CUSTOM FIELD  -->
								<form name="contact_form" action="" method="post" class="form-horizontal" id="contact_form" enctype='multipart/form-data'>	
									 <?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
									<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
									<input type="hidden" name="form_name"  id="form_name" value="contact">
									<input type="hidden" name="role" value="<?php echo esc_attr($role);?>"  />
									<input type="hidden" name="user_id" value="<?php echo esc_attr($contact_id);?>"  />
									<div class="header">	
										<h3 class="first_hed"><?php esc_html_e('Client Information','lawyer_mgt');?></h3>
										<hr>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="first_name"><?php esc_html_e('First Name','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="first_name" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input"  type="text" placeholder="<?php esc_html_e('Enter First Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($user_info->first_name);}elseif(isset($_POST['first_name'])){ echo esc_attr($_POST['first_name']); } ?>" name="first_name">
											<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
										</div>
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="middle_name"><?php esc_html_e('Middle Name','lawyer_mgt');?></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="middle_name" class="form-control has-feedback-left validate[custom[onlyLetter_specialcharacter],maxSize[50]]" type="text"  placeholder="<?php esc_html_e('Enter Middle Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($user_info->middle_name);}elseif(isset($_POST['middle_name'])){ echo esc_attr($_POST['middle_name']); } ?>" name="middle_name">
											<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="last_name"><?php esc_html_e('Last Name','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="last_name" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter],maxSize[50]] text-input"  type="text"   placeholder="<?php esc_html_e('Enter Last Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($user_info->last_name);}elseif(isset($_POST['last_name'])){ echo esc_attr($_POST['last_name']); } ?>" name="last_name">
											<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
										</div>
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="birth_date"><?php esc_html_e('Date of birth','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="birth_date" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="form-control has-feedback-left validate[required]" type="text"  name="birth_date"  placeholder="<?php esc_html_e('Select Birth Date','lawyer_mgt');?>"
											value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($user_info->birth_date)) ;}elseif(isset($_POST['birth_date'])){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['birth_date'])); } ?>" readonly>
											<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
											<span id="inputSuccess2Status2" class="sr-only">(success)</span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="gender"><?php esc_html_e('Gender','lawyer_mgt');?></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 radio_left dis_flx">
										<?php $genderval = "male"; if($edit){ $genderval=$user_info->gender; }elseif(isset($_POST['gender'])) {$genderval=sanitize_text_field($_POST['gender']);}?>
										<div class="mt_ml mr_10">
											<label class="radio-inline">
											 <input type="radio" value="male" class="tog validate[required]" name="gender"  <?php  checked( 'male', $genderval);  ?>/><?php esc_html_e('Male','lawyer_mgt'); ?>
											</label>
										</div>	
										<div class="mt_ml">	
											<label class="radio-inline">
											  <input type="radio"  value="female" class="tog validate[required]" name="gender"  <?php  checked( 'female', $genderval);  ?>/><?php esc_html_e('Female','lawyer_mgt');?> 
											</label>
										</div>
										</div>
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="job_title"><?php esc_html_e('Job Title','lawyer_mgt');?></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="job_title" class="form-control has-feedback-left validate[custom[onlyLetter_specialcharacter],maxSize[50]] text-input"  type="text"   placeholder="<?php esc_html_e('Enter Job Title','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($user_info->job_title);}elseif(isset($_POST['job_title'])){ echo esc_attr($_POST['job_title']); } ?>" name="job_title">
											<span class="fa fa-graduation-cap form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>
									<div class="form-group">
									
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="group"><?php esc_html_e('Group','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">										
											<select class="form-control validate[required]" name="group" id="group">
											<option value=""><?php esc_html_e('Select Group','lawyer_mgt');?></option>
											<?php 
											if($edit)
												$group =$user_info->group;				
											else 
												$group = "";
									
											$obj_group=new MJ_lawmgt_group;
											$result=$obj_group->MJ_lawmgt_get_all_group();	
											if(!empty($result))
											{
												foreach ($result as $retrive_data)
												{ 		 	
												?>
												
													<option value="<?php echo esc_attr($retrive_data->ID);?>" <?php selected($group,$retrive_data->ID);  ?>><?php echo esc_html($retrive_data->post_title); ?> </option>
												<?php 
												}
											} 
											?> 
											</select>				
										</div>
										<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">	
											<button id="addremove" type="button" class="btn btn-success btn_margin btn_width1" model="activity_group"><?php esc_html_e('Add Or Remove','lawyer_mgt');?></button>
										</div>	
									</div>	
										 <!-- Custom Fields Data -->	
							<script type="text/javascript">
								jQuery("document").ready(function($)
								{				
									"use strict"; 	
									//space validation
									$('.space_validation').keypress(function( e ) 
									{
									   if(e.which === 32) 
										 return false;
									});									
									//custom field datepicker
									$('.after_or_equal').datepicker({
										dateFormat: "yy-mm-dd",										
										minDate:0,
										beforeShow: function (textbox, instance) 
										{
											instance.dpDiv.css({
												marginTop: (-textbox.offsetHeight) + 'px'                   
											});
										}
									}); 
									$('.date_equals').datepicker({
										dateFormat: "yy-mm-dd",
										minDate:0,
										maxDate:0,										
										beforeShow: function (textbox, instance) 
										{
											instance.dpDiv.css({
												marginTop: (-textbox.offsetHeight) + 'px'                   
											});
										}
									}); 
									$('.before_or_equal').datepicker({
										dateFormat: "yy-mm-dd",
										maxDate:0,
										beforeShow: function (textbox, instance) 
										{
											instance.dpDiv.css({
												marginTop: (-textbox.offsetHeight) + 'px'                   
											});
										}
									}); 
								});
								//Custom Field File Validation//
								function MJ_lawmgt_custom_filed_fileCheck(obj)
								{	
									"use strict"; 
									var fileExtension = $(obj).attr('file_types');
									var fileExtensionArr = fileExtension.split(',');
									var file_size = $(obj).attr('file_size');
									
									var sizeInkb = obj.files[0].size/1024;
									
									if ($.inArray($(obj).val().split('.').pop().toLowerCase(), fileExtensionArr) == -1)
									{										
										alert("<?php esc_html_e('Only','wpnc');?> "+fileExtension+" <?php esc_html_e('formats are allowed.','wpnc');?>");
										$(obj).val('');
									}	
									else if(sizeInkb > file_size)
									{										
										alert("<?php esc_html_e('Only','wpnc');?> "+file_size+" <?php esc_html_e('kb size is allowed.','wpnc');?>");
										$(obj).val('');	
									}
								}
								//Custom Field File Validation//
							</script>
							<?php
							//Get Module Wise Custom Field Data
							$custom_field_obj =new MJ_lawmgt_custome_field;
							
							$module='contact';	
							if($GLOBALS['lmgt_purchase_or_update_plan'] == 1)
							{ 
								$compact_custom_field=$custom_field_obj->MJ_lawmgt_getCustomFieldByModule($module);
							}
							else
							{
								$compact_custom_field='';
							}
							if(!empty($compact_custom_field))
							{
								?>		
								<div class="header">
									<h3><?php esc_html_e('Custom Fields','lawyer_mgt');?></h3>
									<hr>
								</div>						
								 
										<?php
										foreach($compact_custom_field as $custom_field)
										{
											if($edit)
											{
												$custom_field_id=$custom_field->id;
												$module_record_id=$contact_id;
												
												$custom_field_value=$custom_field_obj->MJ_lawmgt_get_single_custom_field_meta_value($module,$module_record_id,$custom_field_id);
											}
											
											// Custom Field Validation // 
											$exa = explode('|',$custom_field->field_validation);
										 
											$min = "";
											$max = "";
											$required = "";
											$red = "";
											$limit_value_min = "";
											$limit_value_max = "";
											$numeric = "";
											$alpha = "";
											$space_validation = "";
											$alpha_space = "";
											$alpha_num = "";
											$email = "";
											$url = "";
											$minDate="";
											$maxDate="";
											$file_types="";
											$file_size="";
											$datepicker_class="";
											foreach($exa as $key=>$value)
											{
												if (strpos($value, 'min') !== false)
												{
												   $min = $value;
												   $limit_value_min = substr($min,4);
												}
												elseif(strpos($value, 'max') !== false)
												{
												   $max = $value;
												   $limit_value_max = substr($max,4);
												}
												elseif(strpos($value, 'required') !== false)
												{
													$required="required";
													$red="*";
												}
												elseif(strpos($value, 'numeric') !== false)
												{
													$numeric="number";
												}
												elseif($value == 'alpha')
												{
													$alpha="onlyLetterSp";
													$space_validation="space_validation";
												}
												elseif($value == 'alpha_space')
												{
													$alpha_space="onlyLetterSp";
												}
												elseif(strpos($value, 'alpha_num') !== false)
												{
													$alpha_num="onlyLetterNumber";
												}
												elseif(strpos($value, 'email') !== false)
												{
													$email = "email";
												}
												elseif(strpos($value, 'url') !== false)
												{
													$url="url";
												}
												elseif(strpos($value, 'after_or_equal:today') !== false )
												{
													$minDate=1;
													$datepicker_class='after_or_equal';
												}
												elseif(strpos($value, 'date_equals:today') !== false )
												{
													$minDate=$maxDate=1;
													$datepicker_class='date_equals';
												}
												elseif(strpos($value, 'before_or_equal:today') !== false)
												{	
													$maxDate=1;
													$datepicker_class='before_or_equal';
												}	
												elseif(strpos($value, 'file_types') !== false)
												{	
													$types = $value;													
												   
													$file_types=substr($types,11);
												}
												elseif(strpos($value, 'file_upload_size') !== false)
												{	
													$size = $value;
													$file_size=substr($size,17);
												}
											}
											$option =$custom_field_obj->MJ_lawmgt_getDropDownValue($custom_field->id);
											 
											$data = 'custom.'.$custom_field->id;
											$datas = 'custom.'.$custom_field->id;											
											
											if($custom_field->field_type =='text')
											{
												?>	
												 
												<div class="form-group">	
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="<?php echo $custom_field->id; ?>"><?php echo ucwords(esc_html($custom_field->field_label)); ?><span class="required red"><?php echo $red; ?></span></label>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
														<input class="form-control hideattar<?php echo $custom_field->module; ?> validate[<?php if(!empty($required)){ echo $required; ?>,<?php } ?><?php if(!empty($limit_value_min)){ ?> minSize[<?php echo $limit_value_min; ?>],<?php } if(!empty($limit_value_max)){ ?> maxSize[<?php echo $limit_value_max; ?>],<?php } if($numeric != '' || $alpha != '' || $alpha_space != '' || $alpha_num != '' || $email != '' || $url != ''){ ?> custom[<?php echo $numeric; echo $alpha; echo $alpha_space; echo $alpha_num; echo $email; echo $url; ?>]<?php } ?>] <?php echo $space_validation; ?>" type="text" name="custom[<?php echo $custom_field->id; ?>]" id="<?php echo $custom_field->id; ?>" label="<?php echo $custom_field->field_label; ?>" <?php if($edit){ ?> value="<?php echo esc_attr($custom_field_value); ?>" <?php } ?>>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
													</div>
	                                            </div>
	                                                 
												<?php
											}
											elseif($custom_field->field_type =='textarea')
											{
												?>
												<div class="form-group">	
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label "><?php echo esc_html($custom_field->field_label); ?><span class="required red"><?php echo $red; ?></span></label>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
														<textarea rows="3"
															class="form-control hideattar<?php echo $custom_field->form_name; ?> validate[<?php if(!empty($required)){ echo $required; ?>,<?php } ?><?php if(!empty($limit_value_min)){ ?> minSize[<?php echo $limit_value_min; ?>],<?php } if(!empty($limit_value_max)){ ?> maxSize[<?php echo $limit_value_max; ?>],<?php } if($numeric != '' || $alpha != '' || $alpha_space != '' || $alpha_num != '' || $email != '' || $url != ''){ ?> custom[<?php echo $numeric; echo $alpha; echo $alpha_space; echo $alpha_num; echo $email; echo $url; ?>]<?php } ?>] <?php echo $space_validation; ?>" 
															name="custom[<?php echo $custom_field->id; ?>]" 
															id="<?php echo $custom_field->id; ?>"
															label="<?php echo $custom_field->field_label; ?>"
															><?php if($edit){ echo esc_attr($custom_field_value); } ?></textarea>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
													</div>
	                                            </div>
												<?php 
											}
											elseif($custom_field->field_type =='date')
											{
												?>	
												<div class="form-group">
													 <label for="bdate" class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php echo ucwords(esc_html($custom_field->field_label)); ?><span class="required red"><?php echo $red; ?></span></label>
												 
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
														<input class="form-control error custom_datepicker <?php echo $datepicker_class; ?>hideattar<?php echo $custom_field->form_name; ?> <?php if(!empty($required)){ ?> validate[<?php echo $required; ?>] <?php } ?>"name="custom[<?php echo $custom_field->id; ?>]"<?php if($edit){ ?> value="<?php echo esc_attr($custom_field_value); ?>" <?php } ?>id="<?php echo $custom_field->id; ?>" label="<?php echo $custom_field->field_label; ?>">
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
													</div>
	                                            </div>
												 	
												<?php 
											}
											elseif($custom_field->field_type =='dropdown')
											{
												?>	
												<div class="form-group">
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="<?php echo $custom_field->id; ?>"><?php echo ucwords(esc_html($custom_field->field_label)); ?><span class="required red"><?php echo $red; ?></span></label>
													  
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
														<select class="form-control hideattar<?php echo $custom_field->form_name; ?> 
														<?php if(!empty($required)){ ?> validate[<?php echo $required; ?>] <?php } ?>" name="custom[<?php echo $custom_field->id; ?>]"	id="<?php echo $custom_field->id; ?>" label="<?php echo $custom_field->field_label; ?>"
														>
															<?php
															if(!empty($option))
															{															
																foreach ($option as $options)
																{
																	?>
																	<option value="<?php echo esc_attr($options->option_label); ?>" <?php if($edit){ echo selected($custom_field_value,$options->option_label); } ?>> <?php echo ucwords(esc_html($options->option_label)); ?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
													</div>
	                                            </div>
												 
												<?php 
											}
											elseif($custom_field->field_type =='checkbox')
											{
												?>	
													<div class="form-group">
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php echo ucwords(esc_html($custom_field->field_label)); ?><span class="required red"><?php echo $red; ?></span></label>
													 
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
															<?php
															if(!empty($option))
															{
																foreach ($option as $options)
																{ 
																	if($edit)
																	{
																		$custom_field_value_array=explode(',',$custom_field_value);
																	}
																	?>	
																	<div class="d-inline-block custom-control custom-checkbox mr-1">
																		<input type="checkbox" value="<?php echo esc_attr($options->option_label); ?>"  <?php if($edit){  echo checked(in_array($options->option_label,$custom_field_value_array)); } ?> class="custom-control-input hideattar<?php echo $custom_field->form_name; ?>" name="custom[<?php echo $custom_field->id; ?>][]" >
																		<label class="custom-control-label" for="colorCheck1"><?php echo $options->option_label; ?></label>
																	</div>
																	<?php
																}
															}
															?>
														</div>
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
														</div>
													</div>
												<?php 
											}
											elseif($custom_field->field_type =='radio')
											{
												?>
												
												<div class="form-group">
														<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php echo ucwords($custom_field->field_label); ?><span class="required red"><?php echo $red; ?></span></label>
														
														 
													 
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
															<?php
															if(!empty($option))
															{
																foreach ($option as $options)
																{
																	?>
																	<input type="radio"  value="<?php echo esc_attr($options->option_label); ?>" <?php if($edit){ echo checked( $options->option_label, $custom_field_value); } ?> name="custom[<?php echo $custom_field->id; ?>]"  class="custom-control-input hideattar<?php echo $custom_field->form_name; ?> error " id="<?php echo $options->option_label; ?>">
																	
																	<label class="custom-control-label mr-1" for="<?php echo $options->option_label; ?>"><?php echo esc_html($options->option_label); ?></label>
																	<?php
																}
															}
															?>
														</div>
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
														</div>
													</div>
												<?php
											}
											elseif($custom_field->field_type =='file')
											{
												?>	
												<div class="form-group">
													<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php echo ucwords(esc_attr($custom_field->field_label)); ?><span class="required red"><?php echo $red; ?></span></label>
													 
													<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
														<input type="file"  onchange="MJ_lawmgt_custom_filed_fileCheck(this);" Class="hideattar<?php echo $custom_field->form_name; if($edit){ if(!empty($required)){ if($custom_field_value==''){ ?> validate[<?php echo $required; ?>] <?php } } }else{ if(!empty($required)){ ?> validate[<?php echo $required; ?>] <?php } } ?>" name="custom_file[<?php echo $custom_field->id; ?>]" <?php if($edit){ ?> value="<?php echo esc_attr($custom_field_value); ?>" <?php } ?> id="<?php echo $custom_field->id; ?>" file_types="<?php echo $file_types; ?>" file_size="<?php echo $file_size; ?>">
														<p><?php esc_html_e('Please upload only ','wpnc'); echo $file_types; esc_html_e(' file','wpnc');?> </p>
													</div>
														<input type="hidden" name="hidden_custom_file[<?php echo $custom_field->id; ?>]" value="<?php if($edit){ echo esc_attr($custom_field_value); } ?>">
														<label class="label_file"><?php if($edit){ echo esc_html($custom_field_value); } ?></label>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-0">
													</div>
	                                            </div>
											<?php
											}
										}	
										?>	 
							<?php
							}
							?>				
									<div class="header">
										<h3><?php esc_html_e('Address Information','lawyer_mgt');?></h3>
										<hr>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="address"><?php esc_html_e('Address','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="address" class="form-control has-feedback-left validate[required,custom[address_description_validation],maxSize[150]]" type="text"  name="address"  placeholder="<?php esc_html_e('Enter Address','lawyer_mgt');?>"
											value="<?php if($edit){ echo esc_attr($user_info->address);}elseif(isset($_POST['address'])){ echo esc_attr($_POST['address']); } ?>">
											<span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
										</div>
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="state_name"><?php esc_html_e('State','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="state_name" class="form-control has-feedback-left validate[required,custom[city_state_country_validation],maxSize[50]]" type="text"  name="state_name" placeholder="<?php esc_html_e('Enter State Name','lawyer_mgt');?>"
											value="<?php if($edit){ echo esc_attr($user_info->state_name);}elseif(isset($_POST['state_name'])){ echo  esc_attr($_POST['state_name']); } ?>">
											<span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>	
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="city_name"><?php esc_html_e('City','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="city_name" class="form-control has-feedback-left validate[required,custom[city_state_country_validation],maxSize[50]]" type="text"  name="city_name"  placeholder="<?php esc_html_e('Enter City Name','lawyer_mgt');?>"
											value="<?php if($edit){ echo esc_attr($user_info->city_name);}elseif(isset($_POST['city_name'])){ echo  esc_attr($_POST['city_name']); } ?>">
											<span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
										</div>
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="pin_code"><?php esc_html_e('Pin Code','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="pin_code" class="form-control has-feedback-left validate[required,custom[onlyLetterNumber],maxSize[15]]" type="text"  name="pin_code"  placeholder="<?php esc_html_e('Enter Pin Code','lawyer_mgt');?>" 
											value="<?php if($edit){ echo esc_attr($user_info->pin_code);}elseif(isset($_POST['pin_code'])){ echo  esc_attr($_POST['pin_code']); } ?>">
											<span class="fa fa-sort-numeric-down form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>		
									<div class="header">
										<h3><?php esc_html_e('Conatct Information','lawyer_mgt');?></h3>
										<hr>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="mobile"><?php esc_html_e('Mobile Number','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
										
										<input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  class="form-control" name="phonecode">
										</div>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
											<input id="mobile" class="form-control has-feedback-left validate[required,custom[phone_number],minSize[6],maxSize[15]] text-input" type="number"  placeholder="<?php esc_html_e('Enter Mobile Number','lawyer_mgt');?>" name="mobile"
											value="<?php if($edit){ echo esc_attr($user_info->mobile);}elseif(isset($_POST['mobile'])){ echo esc_attr($_POST['mobile']); } ?>">
											<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
										</div>
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="phone"><?php esc_html_e('Alternate Mobile Number','lawyer_mgt');?></label>
										<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
										
										<input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  class="form-control"  name="phonecode">
										</div>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
											<input id="Altrmobile" class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]] text-input" type="number"  name="alternate_mobile" placeholder="<?php esc_html_e('Enter Mobile Number','lawyer_mgt');?>"
											value="<?php if($edit){ echo esc_attr($user_info->alternate_mobile);}elseif(isset($_POST['alternate_mobile'])){ echo esc_attr($_POST['alternate_mobile']); } ?>">
											<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>
									<div class="form-group">
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="phone_home"><?php esc_html_e('Phone Home','lawyer_mgt');?></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="phone_home" class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]]  text-input" type="number" name="phone_home" placeholder="<?php esc_html_e('Enter Home Phone Number','lawyer_mgt');?>"
											value="<?php if($edit){ echo esc_attr($user_info->phone_home);}elseif(isset($_POST['phone_home'])){ echo esc_attr($_POST['phone_home']); } ?>">
											<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
										</div>			

									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="phone_work"><?php esc_html_e('Phone Work','lawyer_mgt');?></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="phone_work" class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]] text-input" type="number"  name="phone_work" placeholder="<?php esc_html_e('Enter Work Phone Number','lawyer_mgt');?>"
											value="<?php if($edit){ echo esc_attr($user_info->phone_work);}elseif(isset($_POST['phone_work'])){ echo esc_attr($_POST['phone_work']); } ?>">
											<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>
									<div class="form-group">
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="fax"><?php esc_html_e('Fax','lawyer_mgt');?></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="fax" class="form-control has-feedback-left text-input" type="text" onchange="MJ_lawmgt_ValidateFax()" name="fax"  placeholder="<?php esc_html_e('Enter Fax Number','lawyer_mgt');?>"
											value="<?php if($edit){ echo esc_attr($user_info->fax);}elseif(isset($_POST['fax'])){ echo esc_attr($_POST['fax']); } ?>">
											<span class="fa fa-fax form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>
									<div class="form-group">
										<label class="offset-sm-2 col-sm-4" ><b><?php esc_html_e('Formate : ','lawyer_mgt');?></b><?php esc_html_e('+(country code)(area code)(fax number)','lawyer_mgt');?></label>
									</div>
									<div class="form-group">
										<label class="offset-sm-2 col-sm-4" ><b><?php esc_html_e('Ex : ','lawyer_mgt');?></b><?php esc_html_e('+1-212-9876543','lawyer_mgt');?></label>
									</div>
									<div class="header">	
										<h3><?php esc_html_e('Login Information','lawyer_mgt');?></h3>
										<hr>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="email"><?php esc_html_e('Email','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="email" class="form-control has-feedback-left validate[required,custom[email]] text-input" maxlength="50" type="text"  name="email" placeholder="<?php esc_html_e('Enter valid Email','lawyer_mgt');?>"
											value="<?php if($edit){ echo esc_attr($user_info->user_email);}elseif(isset($_POST['email'])){ echo esc_attr($_POST['email']); } ?>">
											<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
										</div>
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="username"><?php esc_html_e('Username','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="username" class="form-control has-feedback-left validate[required,custom[username_validation],maxSize[30]]]" type="text"  name="username"  placeholder="<?php esc_html_e('Enter valid username','lawyer_mgt');?>"
											value="<?php if($edit){ echo esc_attr($user_info->user_login);}elseif(isset($_POST['username'])){ echo esc_attr($_POST['username']); } ?>" <?php if($edit) echo "readonly";?>>
											<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>
									<?php wp_nonce_field( 'save_contact_nonce' ); ?>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="password"><?php esc_html_e('Password','lawyer_mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input class="form-control has-feedback-left <?php if(!$edit){ echo 'validate[required,minSize[8]]'; }else{ echo 'validate[minSize[8]]'; }?>" type="password"  maxlength="12" name="password" placeholder="<?php esc_html_e('Enter valid Password','lawyer_mgt');?>" value="">
											<span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>
									<div class="header">	
										<h3><?php esc_html_e('Other Information','lawyer_mgt');?></h3>
										<hr>
									</div>								
									<div class="form-group">
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="license_number"><?php esc_html_e('License Number','lawyer_mgt');?></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="license_number" class="form-control has-feedback-left validate[custom[popup_category_validation]],maxSize[20]] text-input"    type="text"  name="license_number" placeholder="<?php esc_html_e('Enter License Number','lawyer_mgt');?>"
											value="<?php if($edit){ echo esc_attr($user_info->license_number);}elseif(isset($_POST['license_number'])) { echo esc_attr($_POST['license_number']); } ?>">
											<span class="fa fa-sort-numeric-down form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>
									<div class="form-group">
									<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="website"><?php esc_html_e('Website','lawyer_mgt');?></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<input id="website" class="form-control has-feedback-left validate[custom[onlyLetter_specialcharacter],maxSize[50]] text-input" type="text"   placeholder="<?php esc_html_e('Enter Website','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($user_info->website);}elseif(isset($_POST['website'])){ echo esc_attr($_POST['website']); } ?>" name="website">
											<span class="fab fa-google form-control-feedback left" aria-hidden="true"></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="photo"><?php esc_html_e('Image','lawyer_mgt');?></label>
										<div class="col-sm-3 has-feedback">
											<input type="text" id="lmgt_user_avatar_url" class="form-control has-feedback-left" name="lmgt_user_avatar"  placeholder="<?php esc_html_e('Select image','lawyer_mgt');?>"
											value="<?php if($edit){ echo esc_url( $user_info->lmgt_user_avatar );}elseif(isset($_POST['upload_user_avatar_image'])){ echo esc_url($_POST['upload_user_avatar_image']); } ?>" readonly />
											<span class="fa fa-image form-control-feedback left" aria-hidden="true"></span>
										</div>	
										<div class="col-sm-3">
											<input type="hidden" name="hidden_upload_user_avatar_image" 
												value="<?php if($edit){ echo $user_info->lmgt_user_avatar;}elseif(isset($_POST['upload_user_avatar_image'])){ echo esc_url($_POST['upload_user_avatar_image']); } 
												else echo esc_url(get_option('lmgt_system_logo'));?>">
											<input id="upload_user_avatar_image" name="upload_user_avatar_image" type="file" class="form-control file" value="<?php esc_html_e('Upload image', 'lawyer_mgt' ); ?>" />
										</div>
										<div class="clearfix"></div>										
										<div class="upload_img offset-sm-2 col-sm-8">
												 <div id="upload_user_avatar_preview" >
												 <?php if($edit) 
													{
													if($user_info->lmgt_user_avatar == "")
													{?>
													<img alt="" class="user_image_upload" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
													<?php }
													else {
														?>
													<img class="image_upload user_image_upload"  src="<?php if($edit)echo esc_url( $user_info->lmgt_user_avatar ); ?>" />
													<?php 
													}
													}
													else {
														?>
														<img alt=""  class="user_image_upload" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
														<?php 
													}?>
												</div>
										</div>
									</div>			
									<div class="form-group">
											<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="description"><?php esc_html_e('Description','lawyer_mgt');?></label>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
											<textarea rows="3" class="validate[custom[address_description_validation],maxSize[150]] width_414_px_resize_none_css" name="contact_description" maxlength="150" id="description"><?php if($edit){ echo esc_textarea($user_info->contact_description);}elseif(isset($_POST['contact_description'])){ echo esc_textarea($_POST['contact_description']); } ?></textarea>				
										</div>
									</div>					
									<div class="offset-sm-2 col-sm-8">
										<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Add Client','lawyer_mgt');}?>" name="save_contact" class="btn btn-success mt_10"/>
									</div>
								</form>
							</div>  <!-- END PANEL BODY CUSTOM FIELD  -->      
						<?php 	   
						}
						if($active_tab == 'viewcontact')  /* VIEW CONTACT  TAB */
						{
						?>
							<?php 
							$role='client';
							$obj_user=new MJ_lawmgt_Users;

							$contact_id=0;
							$edit=0;
							if(isset($_REQUEST['contact_id']))
								$contact_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['contact_id']));
								if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'view')
								{					
									$edit=1;
									$user_info = get_userdata($contact_id);						
								}?>								
								<div class="panel-body">
									<div class="header workflow_event">	
										<h3 class="first_hed"><?php esc_html_e('Personal Information','lawyer_mgt');?></h3>
										<hr>
									</div>
									<div class="member_view_row1">
										<div class="col-lg-8 col-md-12 col-xs-12 col-sm-12 membr_left">
											<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 left_side">
											 <?php if($edit) 
													{
														if($user_info->lmgt_user_avatar == "")
														{?>
														<img alt="" class="max_width_100px"  src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
														<?php }
														else {
															?>
														<img class="image_upload max_width_100px"  src="<?php if($edit)echo esc_url( $user_info->lmgt_user_avatar ); ?>" />
														<?php 
														}
													}
													else 
													{
														?>
														<img alt="" class="max_width_100px" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
														<?php 
													}?>
											</div>
											<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 right_side">
												<div class="table_row">
													<div class="col-md-5 col-sm-12 table_td">
														<i class="fa fa-user"></i>
														<?php esc_html_e('Name','lawyer_mgt'); ?>
													</div>
													<div class="col-md-7 col-sm-12 table_td">
													<span class="txt_color">
															<?php echo esc_html($user_info->first_name." ".$user_info->middle_name." ".$user_info->last_name);?>

														</span>
													</div>
												</div>
												<div class="table_row">
													<div class="col-md-5 col-sm-12 table_td">
														<i class="fa fa-envelope"></i>
														<?php esc_html_e('Email','lawyer_mgt');?>
													</div>
													<div class="col-md-7 col-sm-12 table_td">
														<span class="txt_color"><?php echo chunk_split($user_info->user_email,20,"<BR>"); ?></span>
													</div>
												</div>
												<div class="table_row">
													<div class="col-md-5 col-sm-12 table_td"><i class="fa fa-phone"></i> <?php esc_html_e('Mobile No','lawyer_mgt');?> </div>

													<div class="col-md-7 col-sm-12 table_td">
														<span class="txt_color">
															<span class="txt_color"><?php echo esc_html($user_info->mobile);?> </span>
														</span>
													</div>
												</div>
												<div class="table_row">
													<div class="col-md-5 col-sm-12 table_td">
														<i class="fa fa-calendar"></i> <?php esc_html_e('Date Of Birth','lawyer_mgt');?>
													</div>
													<div class="col-md-7 col-sm-12 table_td">
														<span class="txt_color"><?php echo MJ_lawmgt_getdate_in_input_box($user_info->birth_date);?></span>
													</div>
												</div>
												<div class="table_row">
													<div class="col-md-5 col-sm-12 table_td">
														<i class="fa fa-mars"></i> <?php esc_html_e('Gender','lawyer_mgt');?>
													</div>

													<div class="col-md-7 col-sm-12 table_td">
														<span class="txt_color"><?php echo esc_html($user_info->gender);?></span>
													</div>
												</div>
												<div class="table_row">
													<div class="col-md-5 col-sm-12 table_td">
														<i class="fa fa-user"></i> <?php esc_html_e('UserName','lawyer_mgt');?>
													</div>
													<div class="col-md-7 col-sm-12 table_td">
														<span class="txt_color"><?php echo esc_html($user_info->user_login);?> </span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-4 col-md-12 col-xs-12 col-sm-12 member_right">
											<span class="report_title">
												<span class="fa-stack cutomcircle">
													<i class="fa fa-align-left fa-stack-1x"></i>
												</span>
												<span class="shiptitle"><?php esc_html_e('More Info','lawyer_mgt');?></span>
											</span>
											<div class="table_row">
												<div class="col-md-4 col-sm-12 table_td">
													<i class="fa fa-map-marker"></i> <?php esc_html_e('Address','lawyer_mgt');?>
												</div>
												<div class="col-md-8 col-sm-12 table_td">
													<span class="txt_color"><?php
													if($edit)
													{ 
													 if($user_info->address != '')

														echo esc_html($user_info->address).", <BR>";

													 if($user_info->city_name != '')

														 echo esc_html($user_info->city_name).", <BR>";
													   
													if($user_info->state_name != '')

														 echo esc_html($user_info->state_name).", <BR>";
													   

													if($user_info->pin_code != '')

														echo esc_html($user_info->pin_code).".";
													   }

													?> </span>
												</div>
											</div>
										</div>
									</div> 		
								</div>	
								<?php
								$current_user_id = get_current_user_id();
								$contact_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['contact_id']));
								
								if($current_user_id == (int)$contact_id)
								{
								?>
								<div class="row padding_0px_20px_css">
									<div class="col-lg-4 col-md-4 col-xs-12 col-sm-12 close_padding">
										<div class="x_panel attorney_open_case background_color_f7f7f7">
											<div class="x_title">				   
												<h2><?php esc_html_e('Client Open Case History','lawyer_mgt');?></h2>
												<ul class="nav navbar-right panel_toolbox">
												  <li><a href="?dashboard=user&page=cases&tab=caselist&tab2=open&contact_details=true&contact_id=<?php echo esc_attr($_REQUEST['contact_id']); ?>" data-toggle="modal"  print="20" class="openserviceall"><button type="button" class="btn  btn-default btn_view_all margin_bottom_0_px_css"><?php esc_html_e('View All','lawyer_mgt');?></button></a>
												  </li>                      
												</ul>
												<div class="clearfix"></div>
											</div>
											<?php 					 
											global $wpdb;
											$table_case = $wpdb->prefix. 'lmgt_cases';
											$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
											$contact_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['contact_id']));		
											
											$case_id_by_contact_id=$wpdb->get_results("SELECT case_id FROM $table_case_contacts WHERE user_id=$contact_id");
												
											if(!empty($case_id_by_contact_id))
											{						
												foreach ($case_id_by_contact_id as $retrieved_data)
												{						
													$case_id=$retrieved_data->case_id;
												   
													$casedata=$wpdb->get_results("SELECT * FROM $table_case WHERE id=$case_id AND case_status='open' ORDER BY id DESC LIMIT 0 , 5");
												
													if(!empty($casedata))
													{							
														foreach($casedata as $data)
														{	
															$user=explode(",",$data->case_assgined_to);
															$case_assgined_to=array();
															if(!empty($user))
															{						
																foreach($user as $data4)
																{
																	$case_assgined_to[]=esc_html(MJ_lawmgt_get_display_name($data4));
																}
															}	
													?>
															 <div class="x_content">
															  <article class="media event">
																  <a class="pull-left date">
																	<p class="month"><?php echo date('M',strtotime($data->open_date));?></p>
																	<p class="day"><?php echo date('d',strtotime($data->open_date));?></p>
																  </a>
																  <div class="media-body">
																	 <h5> <b><?php esc_html_e('Attorney Name : ','lawyer_mgt');?></b> <span class="txt_color1"><?php echo implode(", ",$case_assgined_to);?></span> </h5>  
																	 <p><?php esc_html_e('Case Name: ','lawyer_mgt');?> <span class="txt_color1"><?php echo esc_html($data->case_name);?></span></p>
																  </div>
																  <a href="?dashboard=user&page=cases&tab=casedetails&action=view&close_case=true&tab2=caseinfo&case_id=<?php echo MJ_lawmgt_id_encrypt(esc_attr($case_id)); ?>"  data-target="#myModal-open-modal" print="20" class="openmodel"><i class="fa fa-eye eye" aria-hidden="true"></i></a>
																</article>
																</div>
														<?php 
														}						
													}		
												}		
											}
											else
											{
												echo esc_html_e('No Cases Available','lawyer_mgt');
											}
					
											?> 
										</div>
									</div>										  
									<div class="col-lg-4 col-md-4 col-xs-12 col-sm-12 close_padding">
										<div class="x_panel attorney_close_case background_color_f7f7f7">
											<div class="x_title">											   
												<h2><?php esc_html_e('Client Close Case History','lawyer_mgt');?></h2>
												<ul class="nav navbar-right panel_toolbox">
												  <li><a href="?dashboard=user&page=cases&tab=caselist&tab2=close&contact_details=true&contact_id=<?php echo $_REQUEST['contact_id']; ?>" data-toggle="modal"  print="20" class="openserviceall"><button type="button" class="btn  btn-default btn_view_all margin_bottom_0_px_css"><?php esc_html_e('View All','lawyer_mgt');?></button></a>
												  </li>                      
												</ul>
												<div class="clearfix"></div>
											</div>
											<?php				 
											global $wpdb;
											$table_case = $wpdb->prefix. 'lmgt_cases';
											$table_case_contacts = $wpdb->prefix. 'lmgt_case_contacts';
											$contact_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['contact_id']));		
											
											$case_id_by_contact_id=$wpdb->get_results("SELECT case_id FROM $table_case_contacts WHERE user_id=$contact_id");
												
											if(!empty($case_id_by_contact_id))
											{						
												foreach ($case_id_by_contact_id as $retrieved_data)
												{						
													$case_id=$retrieved_data->case_id;
												   
													$casedata=$wpdb->get_results("SELECT * FROM $table_case WHERE id=$case_id AND case_status='close' ORDER BY id DESC LIMIT 0 , 5");
												
													if(!empty($casedata))
													{							
														foreach($casedata as $data)								
														{
															$user=explode(",",$data->case_assgined_to);
															$case_assgined_to=array();
															if(!empty($user))
															{						
																foreach($user as $data4)
																{
																	$case_assgined_to[]=esc_html(MJ_lawmgt_get_display_name($data4));
																}
															}	
															?>
														<div class="x_content">
															<article class="media event">
																<a class="pull-left date">
																	<p class="month"><?php echo date('M',strtotime($data->open_date));?></p>
																	<p class="day"><?php echo date('d',strtotime($data->open_date));?></p>
																</a>
																<div class="media-body">
																   <h5> <b><?php esc_html_e('Attorney Name :','lawyer_mgt');?> </b> <span class="txt_color1"><?php echo implode(", ",$case_assgined_to);?></span> </h5>  
																	 <p><?php esc_html_e('Case Name : ','lawyer_mgt');?> <span class="txt_color1"><?php echo esc_html($data->case_name);?></span></p>
																</div>
																<a href="?dashboard=user&page=cases&tab=casedetails&action=view&close_case=true&tab2=caseinfo&case_id=<?php echo esc_attr(MJ_lawmgt_id_encrypt(esc_attr($case_id))); ?>"  data-target="#myModal-open-modal" print="20" class="openmodel"><i class="fa fa-eye eye" aria-hidden="true"></i></a>
															</article>
														</div>
													<?php
														} 
													}
												}	
											}
											else
											{
												echo esc_html_e('No Cases Available','lawyer_mgt');
											}
											?> 
										</div>
									</div>
								</div>		
								<?php 		 
								}
						}						
						if($active_tab == 'uploadcontact')  
						{
						?>
							<script type="text/javascript">
							jQuery(document).ready(function($)
							{
								"use strict"; 
								$('#upload_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
							});	
							 
							jQuery("body").on("change", ".contact_csv_file[type=file]", function ()
							{ 
								"use strict"; 
								var file = this.files[0]; 
								var file_id = jQuery(this).attr('id'); 
								var ext = $(this).val().split('.').pop().toLowerCase(); 
								//Extension Check 
								if($.inArray(ext, ['csv']) == -1)
								{
									 alert('<?php esc_html_e("Only CSV File Allowed .","lawyer_mgt") ?>');
									$(this).replaceWith('<input type="file" class="contact_csv_file width_230_px_css" name="contact_csv_file">			');
									return false; 
								} 
								 //File Size Check 
								 if (file.size > 20480000) 
								 {
									alert("<?php esc_html_e('Too large file Size. Only file smaller than 10MB can be uploaded.','lawyer_mgt');?>");
									$(this).replaceWith('<input type="file" class="contact_csv_file width_230_px_css" name="contact_csv_file">'); 
									return false; 
								 }
							});
							</script>
							<div class="panel-body"> <!-- PANEL BODY DIV  -->
								<form name="upload_form" action="" method="post" class="form-horizontal" id="upload_form" enctype="multipart/form-data">
									<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
									<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
									<input type="hidden" name="role" value="<?php echo esc_attr($role);?>"  />
									 
									<div class="form-group">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Select Client CSV File','lawyer_mgt');?><span class="require-field">*</span></label>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
											<input type="file" class="contact_csv_file form-control display_inline_css" name="contact_csv_file">			
										</div>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
											<input type="submit" value="<?php esc_attr_e('Upload Client CSV File','lawyer_mgt');?>" name="upload_contact_csv_file" class="btn btn-success"/>
										</div>
									</div>	
								</form>
							</div><!-- END PANEL BODY DIV  -->
						<?php
						}
						if($active_tab == 'exportcontact')  
						{
						?>
							<div class="panel-body"><!-- PANEL BODY DIV -->
								<form name="upload_form" action="" method="post" class="form-horizontal" id="upload_form" enctype="multipart/form-data">
									<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
									<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
									<input type="hidden" name="role" value="<?php echo esc_attr($role);?>"  />				
									<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"><?php esc_html_e('Filter By Client Status :','lawyer_mgt');?></label>
										<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
											<select class="form-control document_filter" name="client_status">
												<option value="2"><?php esc_html_e('Select All','lawyer_mgt');?></option>
												<option value="0"><?php esc_html_e('Active','lawyer_mgt');?></option>
												<option value="1"><?php esc_html_e('Archived','lawyer_mgt');?></option>
											</select> 
										</div>
										<input type="submit" value="<?php esc_attr_e('Export Client in CSV File','lawyer_mgt');?>" name="exportcontacts_csv" class="btn btn-success csv_button"/> 
									</div>		
								</form>
							</div><!--END  PANEL BODY DIV -->
						<?php
						}
						?>	
					</div>	<!-- END PANEL BODY DIV -->		
				</div>
			</div>
		</div><!-- END ROW -->
	</div><!-- END MAIN WRAPER DIV -->
</div><!-- PAGE INNER DIV -->