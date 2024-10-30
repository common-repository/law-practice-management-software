<?php 
$role='accountant';
$obj_user=new MJ_lawmgt_Users;
?>
<script type="text/javascript">
    var $ = jQuery.noConflict();
	jQuery(document).ready(function($)
	{
		"use strict";
		$('#accountant_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
		$('#birth_date').datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange:'-65:+0',
			endDate: '+0d',
			autoclose: true,
			onChangeMonthYear: function(year, month, inst) {
				$(this).val(month + "/" + year);
			}                   
		}); 
		//user name not  allow space validation
		$('#username').keypress(function( e ) 
		{
		   if(e.which === 32) 
			 return false;
		});			
	});
</script>
<?php 	
if($active_tab == 'add_accountant')
{
	$accountant_id=0;
	$edit=0;
	if(isset($_REQUEST['accountant_id']))
	{
		$accountant_id=sanitize_text_field(MJ_lawmgt_id_decrypt($_REQUEST['accountant_id']));
	}
	if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
	{		
		$edit=1;
		$user_info = get_userdata($accountant_id);	
	}
	?>
		
    <div class="panel-body"><!-- PANEL BODY DIV    -->
        <form name="accountant_form" action="" method="post" class="form-horizontal" id="accountant_form">	
			<?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
			<input type="hidden" name="role" value="<?php echo esc_attr($role);?>"  />
			<input type="hidden" name="user_id" value="<?php echo esc_attr($accountant_id);?>"  />
			<div class="header">	
				<h3 class="first_hed"><?php esc_html_e('Personal Information','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="first_name"><?php esc_html_e('First Name','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="first_name" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter]],maxSize[50]] text-input"   type="text" placeholder="<?php esc_html_e('Enter First Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($user_info->first_name);}elseif(isset($_POST['first_name'])){ echo esc_attr($_POST['first_name']); }?>" name="first_name">
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="middle_name"><?php esc_html_e('Middle Name','lawyer_mgt');?></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="middle_name" class="form-control has-feedback-left validate[custom[onlyLetter_specialcharacter]],maxSize[50]]" type="text"  placeholder="<?php esc_html_e('Enter Middle Name','lawyer_mgt');?>" value="<?php if($edit){ echo esc_attr($user_info->middle_name);}elseif(isset($_POST['middle_name'])){ echo esc_attr($_POST['middle_name']); } ?>" name="middle_name">
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin" for="last_name"><?php esc_html_e('Last Name','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="last_name" class="form-control has-feedback-left validate[required,custom[onlyLetter_specialcharacter]],maxSize[50]] text-input"   type="text"   placeholder="<?php esc_html_e('Enter Last Name','lawyer_mgt');?>"value="<?php if($edit){ echo esc_attr($user_info->last_name);}elseif(isset($_POST['last_name'])){ echo esc_attr($_POST['last_name']); }?>" name="last_name">
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="birth_date"><?php esc_html_e('Date of birth','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="birth_date" data-date-format="<?php echo MJ_lawmgt_bootstrap_datepicker_dateformat(get_option('lmgt_datepicker_format'));?>" class="form-control has-feedback-left validate[required]" type="text"  name="birth_date"  placeholder="<?php esc_html_e('Select Birth Date','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_attr(MJ_lawmgt_getdate_in_input_box($user_info->birth_date));}elseif(isset($_POST['birth_date'])) { echo esc_attr(MJ_lawmgt_getdate_in_input_box($_POST['birth_date'])); }?>" readonly>
					<span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
					<span id="inputSuccess2Status2" class="sr-only">(success)</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin" for="gender"><?php esc_html_e('Gender','lawyer_mgt');?></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 gender_margin">
				<?php $genderval = "male"; if($edit){ $genderval=esc_attr($user_info->gender); }elseif(isset($_POST['gender'])) {$genderval=sanitize_text_field($_POST['gender']);}?>
					<label class="radio-inline">
					 <input type="radio" value="male" class="tog validate[required]" name="gender"  <?php  checked( 'male', $genderval);  ?>/><?php esc_html_e('Male','lawyer_mgt');?>
					</label>
					<label class="radio-inline">
					  <input type="radio"  value="female" class="tog validate[required]" name="gender"  <?php  checked( 'female', $genderval);  ?>/><?php esc_html_e('Female','lawyer_mgt');?> 
					</label>
				</div>
			</div>
			<div class="header">
				<h3><?php esc_html_e('Address Information','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="address"><?php esc_html_e('Address','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="address" class="form-control has-feedback-left validate[required,custom[address_description_validation]],maxSize[150]]" type="text"   name="address"  placeholder="<?php esc_html_e('Enter Address','lawyer_mgt');?>"
					value="<?php if($edit){echo esc_attr($user_info->address);}elseif(isset($_POST['address'])) { esc_attr($_POST['address']); } ?>">
					<span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
				</div>
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="state_name"><?php esc_html_e('State','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="state_name" class="form-control has-feedback-left validate[required,custom[city_state_country_validation]],maxSize[50]]"  type="text"  name="state_name" placeholder="<?php esc_html_e('Enter State Name','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_attr($user_info->state_name);}elseif(isset($_POST['state_name'])) { esc_attr($_POST['state_name']); } ?>">
					<span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>
				<?php wp_nonce_field( 'save_account_nonce' ); ?>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin" for="city_name"><?php esc_html_e('City','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="city_name" class="form-control has-feedback-left validate[required,custom[city_state_country_validation]],maxSize[50]]"   type="text"  name="city_name"  placeholder="<?php esc_html_e('Enter City Name','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_attr($user_info->city_name);}elseif(isset($_POST['city_name'])){ echo esc_attr($_POST['city_name']); } ?>">
					<span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
				</div>
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="pin_code"><?php esc_html_e('Pin Code','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="pin_code" class="form-control has-feedback-left validate[required,custom[onlyLetterNumber],maxSize[15]]"   type="text"  name="pin_code" placeholder="<?php esc_html_e('Enter Pin Code','lawyer_mgt');?>" 
					value="<?php if($edit){echo esc_attr($user_info->pin_code);}elseif(isset($_POST['pin_code'])) { esc_attr($_POST['pin_code']); }?>">
					<span class="fa fa-sort-numeric-down form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>				
			<div class="header">
				<h3><?php esc_html_e('Contact Information','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="mobile"><?php esc_html_e('Mobile Number','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">				
					<input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  class="form-control" name="phonecode">
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
					<input id="mobile" class="form-control has-feedback-left validate[required,custom[phone_number],minSize[6],maxSize[15]] text-input" type="number" min="0"   placeholder="<?php esc_html_e('Enter Mobile Number','lawyer_mgt');?>" name="mobile" 
					value="<?php if($edit){ echo esc_attr($user_info->mobile);}elseif(isset($_POST['mobile'])){  esc_attr($_POST['mobile']); }?>">
					<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
				</div>
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="phone"><?php esc_html_e('Alternate Mobile Number','lawyer_mgt');?></label>
				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">				
					<input type="text" readonly value="+<?php echo esc_attr(MJ_lawmgt_get_countery_phonecode(get_option( 'lmgt_contry' ))); ?>"  class="form-control" name="phonecode">
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 has-feedback">
					<input id="Altrmobile" class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]] text-input" type="number" min="0"  name="alternate_mobile" placeholder="<?php esc_html_e('Enter Alternate Mobile Number','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_attr($user_info->alternate_mobile);}elseif(isset($_POST['alternate_mobile'])) { esc_attr($_POST['alternate_mobile']); }?>">
					<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>
			<div class="form-group">
			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="phone_home"><?php esc_html_e('Phone Home','lawyer_mgt');?></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="phone_home" class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]] text-input" type="number" min="0"  name="phone_home" placeholder="<?php esc_html_e('Enter Home Phone Number','lawyer_mgt');?>"
					value="<?php if($edit){echo esc_attr($user_info->phone_home);}elseif(isset($_POST['phone_home'])) { esc_attr($_POST['phone_home']); } ?>">
					<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
				</div>			

			<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="phone_work"><?php esc_html_e('Work Phone','lawyer_mgt');?></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="phone_work" class="form-control has-feedback-left validate[custom[phone_number],minSize[6],maxSize[15]] text-input" type="number" min="0"  name="phone_work"  placeholder="<?php esc_html_e('Enter Work Phone Number','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_attr($user_info->phone_work);}elseif(isset($_POST['phone_work'])) { esc_attr($_POST['phone_work']); }?>">
					<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>
			<div class="header">	
				<h3><?php esc_html_e('Login Information','lawyer_mgt');?></h3>
				<hr>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label " for="email"><?php esc_html_e('Email','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="email" class="form-control has-feedback-left validate[required,custom[email]] text-input" maxlength="50" type="text"  name="email" placeholder="<?php esc_html_e('Enter valid Email','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_attr($user_info->user_email);}elseif(isset($_POST['email'])) { esc_attr($_POST['email']); } ?>">
					<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
				</div>
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="username"><?php esc_html_e('Username','lawyer_mgt');?><span class="require-field">*</span></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="username" class="form-control has-feedback-left validate[required,custom[username_validation],maxSize[30]]] " type="text"  name="username"  placeholder="<?php esc_html_e('Enter valid username','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_attr($user_info->user_login);}elseif(isset($_POST['username'])) { esc_attr($_POST['username']); } ?>" <?php if($edit) echo "readonly";?>>
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label last_name_margin" for="password"><?php esc_html_e('Password','lawyer_mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input id="password" class="form-control has-feedback-left <?php if(!$edit){ echo 'validate[required,minSize[8]]'; }else{ echo 'validate[minSize[8]]'; }?>" type="password"   maxlength="12" name="password" placeholder="<?php esc_html_e('Enter valid Password','lawyer_mgt');?>" value="">
					<span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
				</div>
			</div>
			<div class="header">	
				<h3><?php esc_html_e('Other Information','lawyer_mgt');?></h3>
				<hr>
			</div>
			<!--<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="photo"><?php esc_html_e('Image','lawyer_mgt');?></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input type="text" id="lmgt_user_avatar_url" class="form-control has-feedback-left" name="lmgt_user_avatar"  placeholder="<?php esc_html_e('Select image','lawyer_mgt');?>"
					value="<?php if($edit){ 
					
						esc_attr( $user_info->lmgt_user_avatar ); }elseif(isset($_POST['lmgt_user_avatar'])){  echo esc_url($_POST['lmgt_user_avatar']); }?>"  readonly />
					<span class="fa fa-image form-control-feedback left" aria-hidden="true"></span>
				</div>	
				<div class="col-sm-3">
					<input id="upload_user_avatar_button" type="button" class="btnupload button btn_margin" value="<?php esc_attr_e('Upload image', 'lawyer_mgt' ); ?>" />
					<span class="description"><?php esc_html_e('Upload image', 'lawyer_mgt' ); ?></span>
				
				</div>
				<div class="clearfix"></div>
				<div class="upload_img offset-sm-2 col-sm-8">
					<div id="upload_user_avatar_preview" >
					 <?php if($edit) 
					{
						if($user_info->lmgt_user_avatar == "")
						{?>
							<img alt="" class="user_image_upload" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
						<?php
						}
						else 
						{
						?>
						<img class="image_upload user_image_upload" src="<?php if($edit) echo esc_url( $user_info->lmgt_user_avatar ); ?>" />
						<?php 
						}
					}
					else
					{
						?>
						<img alt="" class="user_image_upload"  src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
						<?php 
					}?>
					</div>
				</div>
			</div>-->
			<div class="form-group">
				<label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label" for="photo"><?php esc_html_e('Image','lawyer_mgt');?></label>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 has-feedback">
					<input type="text" id="lmgt_user_avatar_url" class="form-control has-feedback-left" name="lmgt_user_avatar"  placeholder="<?php esc_html_e('Select image','lawyer_mgt');?>"
					value="<?php if($edit){ echo esc_url( $user_info->lmgt_user_avatar );} elseif(isset($_POST['lmgt_user_avatar'])){ echo esc_url($_POST['lmgt_user_avatar']); }?>" readonly />
					<span class="fa fa-image form-control-feedback left" aria-hidden="true"></span>
				</div>	
				<div class="col-sm-3">
					 <input id="upload_user_avatar_button" type="button" class="btnupload button btn_margin" value="<?php esc_attr_e('Upload image', 'lawyer_mgt' ); ?>" />
					 <span class="description"><?php esc_html_e('Upload image', 'lawyer_mgt' ); ?></span>
				</div>
				<div class="clearfix"></div>			
				<div class="upload_img offset-sm-2 col-sm-8">
					<div id="upload_user_avatar_preview" >
					 <?php if($edit) 
						{
						if($user_info->lmgt_user_avatar == "")
						{?>
							<img alt="" class="height_100px_width_100px" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
						<?php 
						}
						else 
						{
							?>
							<img class="image_upload height_100px_width_100px" src="<?php if($edit)echo esc_url( $user_info->lmgt_user_avatar ); ?>" />
						<?php 
						}
						}
						else {
							?>
							<img alt="" class="height_100px_width_100px" src="<?php echo esc_url(get_option( 'lmgt_system_logo' )); ?>">
							<?php 
						}?>
					</div>
				</div>
			</div>
			<div class="offset-sm-2 col-sm-8">
				<input type="submit" value="<?php if($edit){ esc_attr_e('Save','lawyer_mgt'); }else{ esc_attr_e('Add Accountant','lawyer_mgt');}?>" name="save_accountant" class="btn btn-success"/>
			</div>
        </form>
    </div> <!--END  PANEL BODY DIV    -->       
<?php 
}
?>