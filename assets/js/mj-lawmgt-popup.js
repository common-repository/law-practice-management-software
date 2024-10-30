jQuery(document).ready(function($)
{
	"use strict"; 	
	//Case Status Wise Filter
	$("body").on("change", ".case_stat", function()
	{	
		$('#case_status tbody tr td').remove();
			
		var selection_id = $(".case_stat").val();
		var attorney = $("#attorney").val();
		var curr_data = {
					action: 'MJ_lawmgt_case_status',
					selection_id: selection_id,	
					attorney: attorney,						
					dataType: 'json'
					};
					
					$.post(lmgt.ajax, curr_data, function(response) {
					
						var json_obj = $.parseJSON(response);//parse JSON
    					$('#case_status tbody').html(json_obj);		
						return true;			
					}); 
	});
 
	$("body").on("change", "#case_id", function()
	{	
		$('#practice_area_id').remove();
		$('#practice_area_id1').remove();
			
			var selection = $("#case_id").val();
			var optionval = $(this);
			var curr_data = {
				action: 'MJ_lawmgt_practice_by_case',
				selection_id: selection,			
				dataType: 'json'
			};
			
			$.post(lmgt.ajax, curr_data, function(response)
			{
			var json_obj = $.parseJSON(response);
					$('.practics').append(json_obj);
			});	
	});
	$("body").on("change", ".case_id", function()
	{
		
		$('#assigned_to_user').html('');
		$('#assigned_to_user').append('<option value="remove">Loading..</option>');
			var selection = $(".case_id").val();
			var task_id = $("#task_id").val();
			var optionval = $(this);
			var user_data ={
				action: 'MJ_lawmgt_get_user_by_case',
				selection_id: selection,			
				dataType: 'json'
			};
			
			$.post(lmgt.ajax, user_data, function(response) {
			   
					$(".assigned_to_user option[value='remove']").remove();
					$('.assigned_to_user').append(response);
	                 
					jQuery('.assigned_to_user').multiselect('rebuild');			
					return false;
				
			});	
	});	
	//Caes By Attorney//
	$("body").on("change", ".case_id", function()
	{		
		$('#assign_to_attorney').html('');
		$('#assign_to_attorney').append('<option value="remove">Loading..</option>');
			var selection = $(".case_id").val();
			 
			var task_id = $("#task_id").val();
			var optionval = $(this);
			var user_data ={
				action: 'MJ_lawmgt_get_attorney_by_case',
				selection_id: selection,			
				dataType: 'json'
			};
			
			$.post(lmgt.ajax, user_data, function(response) {
					$(".assign_to_attorney option[value='remove']").remove();
					$('.assign_to_attorney').append(response);
	                 
					jQuery('.assign_to_attorney').multiselect('rebuild');			
					return false;
				
			});	
	});	
	//invoice case link with contact
	$("body").on("change", "#invoice_case_id", function()
	{
		$('#invoice_contacts').html('');
		var invoice_case_id = $("#invoice_case_id").val();
		
		var user_data ={
			action: 'MJ_lawmgt_get_user_by_case_invoice',
			invoice_case_id: invoice_case_id,			
			dataType: 'json'
		};
		
		$.post(lmgt.ajax, user_data, function(response) {			   
				
				$('#invoice_contacts').append(response);	                 
						
				return false;
			
		});	
	});
   
	//document Status Task Module
	$("body").on("change", ".document_filter", function()
	{			
		$('.documents_list tbody tr td').remove();
			
		var case_id = $(".hidden_case_id").val();
		var selection_id = $(".document_filter").val();
		 
	    var curr_data = {
					action: 'MJ_lawmgt_document_status_filter',
					selection_id: selection_id,							
					case_id: case_id,							
					dataType: 'json'
					};
					
					$.post(lmgt.ajax, curr_data, function(response) {
                      				   
						var json_obj = $.parseJSON(response);//parse JSON						
						$('.documents_list tbody').html(json_obj);			
						return true;			
					}); 
	});
	
	//Task Module Case To  
	 $("body").on("change", ".task_case", function()
	 {
			
		 $('.tast_list1 tbody tr td').remove();
			
		 var selection_id = $(".task_case").val();
	     var curr_data1 = {
					action: 'MJ_lawmgt_case_stat',
					selection_id: selection_id,							
					dataType: 'json'
					};				
					$.post(lmgt.ajax, curr_data1, function(response) {						
						
						var json_obj = $.parseJSON(response);//parse JSON						
						$('.tast_list1 tbody').html(json_obj);			
						return true;			
					}); 
	});
	//Assign Task To
	$("body").on("change", ".assign_task_to", function()
	{			
		$('.tast_list1 tbody tr td').remove();
			
		var selection_id="";
		selection_id = $(".assign_task_to").val();			
		
		var curr_data = {
					action: 'MJ_lawmgt_assign_task',
					selection_id: selection_id,							
					dataType: 'json'
					};	
				
				$.post(lmgt.ajax, curr_data, function(response) {						
					
					var json_obj = $.parseJSON(response);//parse JSON						
					$('.tast_list1 tbody').html(json_obj);
					
					return true;			
				}); 
	});	
	//contact add in dropdownlist by company name
	jQuery("body").on("change", ".company_contact", function()
	{	
	
	     var company_contact_id = $(".company_contact").val();
		 var contactlist_by_company = $(".contactlist_by_company").empty();
		 var billing_contactlist_by_company = $(".billing_contactlist_by_company").empty();
		 var Case_name_by_contact = $(".Case_name_by_contact").empty();
			
		var curr_data = {
			action: 'MJ_lawmgt_conatct_by_company',
			company_contact_id: company_contact_id,			
			dataType: 'json'
		};
		
		 $.post(lmgt.ajax, curr_data, function(response) {
			
			var json_obj = $.parseJSON(response);
			
			var id = [];
			var name = [];
			var i=0;
			var j=0;
			
			 $.each(json_obj, function() {
				
				id[i] = this['id'];
				name[i] = this['name'];
					
				i++;
			});
			var select_message="<option value>Select Client Name</option>";			
			$(select_message).appendTo('.billing_contactlist_by_company'); 
			var select_message1="<option value>Select Case name</option>";
			$(select_message1).appendTo('.Case_name_by_contact'); 		
			
			for(j=0;j<id.length;j++)
			{			
				var billing_contactdata="<option value="+id[j] +">"+name[j]+"</option>";
					
				$(billing_contactdata).appendTo('.contactlist_by_company'); 
			
				$(billing_contactdata).appendTo('.billing_contactlist_by_company'); 
			}
			jQuery('.contactlist_by_company').multiselect('rebuild');			
			return false; 					
		});						
	});		
		
	//case add in dropdownlist by contact name
	$("body").on("change", ".caselist_by_contact_name", function()
	{	
	    var caselist_by_contact_id = $(".caselist_by_contact_name").val();
		var contactlist_by_company = $(".Case_name_by_contact").empty();

		var curr_data =
		{
			action: 'MJ_lawmgt_caselist_by_contact_name',
			caselist_by_contact_id: caselist_by_contact_id,			
			dataType: 'json'
		};
		 
		 $.post(lmgt.ajax, curr_data, function(response) {
			 
			var json_obj = $.parseJSON(response);
			
			var id = [];
			var name = [];
			var i=0;
			var j=0;
			
			 $.each(json_obj, function() {
				
				id[i] = this['id'];
				name[i] = this['name'];
					
				i++;
			});
			var select_message="<option value>Select Case name</option>";
			$(select_message).appendTo('.Case_name_by_contact'); 		
			for(j=0;j<id.length;j++)
			{		
				var case_name="<option value="+id[j]+">"+name[j]+"</option>";
							
				$(case_name).appendTo('.Case_name_by_contact'); 					
			} 					
		 return false; 					
		});			 			
	});	
	//$(".caselist_by_contact_name").trigger("change");
  //Group Add and Remove model
  $("body").on("click", "#addremove", function(event)
  {
	
	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	  var model  = $(this).attr('model') ;
	
	   var curr_data = {
	 					action: 'MJ_lawmgt_add_or_remove_group',
	 					model : model,
	 					dataType: 'json'
	 					};	
										
	 					$.post(lmgt.ajax, curr_data, function(response) { 	
				
							$('.popup-bg').show().css({'height' : docHeight});
							$('.group_list').html(response);	
												
							return true; 					
	 					});		 
  });
  
  //Event And task display model
  $("body").on("click", ".show_task_event", function(event)
  {
	
	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	  var id  = $(this).attr('id') ;
	  var model  = $(this).attr('model') ;
	
	   var curr_data = {
	 					action: 'MJ_lawmgt_show_event_task',
	 					id : id,
	 					model : model,
	 					dataType: 'json'
	 					};	
										
	 					$.post(lmgt.ajax, curr_data, function(response) { 	
							
							$('.popup-bg').show().css({'height' : docHeight});
							$('.task_event_list').html(response);	
												
							return true; 					
	 					});		 
  });
  $("body").on("click", ".close-btn", function()
  {		
		$( ".group_list" ).empty();
		
		$('.popup-bg').hide(); // hide the overlay
  });  

   $("body").on("click", ".btn-delete-group", function(){		
		var group_id  = $(this).attr('id') ;	

		 var model  = $(this).attr('model') ;
		
		if(confirm("Are you sure want to delete this record?"))
		{
			var curr_data = {
					action: 'MJ_lawmgt_remove_group',
					model : model,
					group_id:group_id,			
					dataType: 'json'
					};
					
					$.post(lmgt.ajax, curr_data, function(response) {					
						$('#group-'+group_id).hide();						
						$('#group').find('option[value='+group_id+']').remove();						
						return true;				
					});			
		}
	});	

  $("body").on("click", "#btn-add-group", function(){	
		
		var group_name  = $('#group_name').val() ;
		 
		var model  = $(this).attr('model');
	
		if(group_name != "")
		{
			var curr_data = {
					action: 'MJ_lawmgt_add_group',
					model : model,
					group_name: group_name,			
					dataType: 'json'
					};
					
					$.post(lmgt.ajax, curr_data, function(response) 
					{
					 
						var json_obj = $.parseJSON(response);//parse JSON						
						$('.group_listbox .table').append(json_obj[0]);
						$('#group_name').val("");
						$('#group').append(json_obj[1]);					
												
						return false;					
					});			
		}
		else
		{
			alert(language_translate.group_name_popup);
		}
	});
	//End Group Add Remove
  $("body").on("click", ".close-btn2", function()
  {				
		$('.popup-bg1').hide(); // hide the overlay
  });  
	
  $("body").on("click", ".close-btn", function(){		
		$('.popup-bg1').hide(); // hide the overlay
		});  
	$("body").on("click", ".event_close-btn", function()
	{		
		$('.popup-bg').hide(); // hide the overlay
	}); 
	//add custom field into database	
  $("body").on("click", "#btn-add-customfield", function(){	
		
		var form_name  = $('#form_name').val();
		var customfield_name  = $('#customfield_name').val();
		var field_type  = $('#field_type').val();			
		var model  = $(this).attr('model');
		var i=0;
		var customfieldtype_value=[];
		 $(".customfieldvalue_css #customfieldtype_value").each(function() {			
			customfieldtype_value[i]=$(this).val();
			i++;
		});
		var always_visible='yes';
	
		var required=$('input[name=required]:checked').val();
		var validation_type=$('#validation_type').val();		
		if(customfield_name != "")
		{
			var curr_data = {
					action: 'MJ_lawmgt_add_new_customfield',
					model : model,
					form_name: form_name,		
					customfield_name: customfield_name,		
					customfieldtype_value:customfieldtype_value,	
					field_type: field_type,			
					always_visible: always_visible,			
					required: required,			
					validation_type: validation_type,			
					dataType: 'json'
					};
					
					$.post(lmgt.ajax, curr_data, function(response) 
					{
						
						var json_obj = $.parseJSON(response);//parse JSON		
						if(json_obj['form_name']== "contact")	
						{
							$('.addnew_contact_form_customfield').append(json_obj['name']+json_obj['type']);
						}else if(json_obj['form_name']== "case")	
						{
							$('.addnew_case_form_customfield').append(json_obj['name']+json_obj['type']);
						}
						$('.popup-bg1').hide(); 						
						return false;					
					});			
		}
		else
		{
			alert(language_translate.name_popup);
		}
	});
//update custom field into database	
  $("body").on("click", "#btn-update-customfield", function(e)
  {		
		var custom_field_id  = $('#custom_field_id').val();		
		var customfield_name  = $('#customfield_name').val();		
		var always_visible=$('input[name=always_visible]:checked').val();
		var required=$('input[name=required]:checked').val();
		var validation_type=$('#validation_type').val();		
		
		if(customfield_name != "")
		{
			var curr_data = {
					action: 'lawmgt_update_customfield',								
					custom_field_id: custom_field_id,							
					customfield_name: customfield_name,												
					always_visible: always_visible,			
					required: required,			
					validation_type: validation_type,			
					dataType: 'json'
					};
					
					$.post(lmgt.ajax, curr_data, function(response) {
								
						$('.popup-bg1').hide();
						return false;					
					});			
		}
		else
		{
			alert(language_translate.name_popup);	
			
		}
	});

	$('body').on('focus',".customfielddate", function()
	{
		jQuery('.customfielddate').datepicker({
		  changeMonth: true,
	        changeYear: true,
	        yearRange:'-65:+0',
			autoclose: true,
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        }                   
       });	
	});

  $("body").on("click", "#customfielsaddvalue", function()
  {		
		var customfield_name  = $('#customfield_name').val();
		if(customfield_name != "")
		{
			
			var curr_data = {
				action: 'lawmgt_get_customfield_option_value',					
				dataType: 'json'
				};
				
				$.post(lmgt.ajax, curr_data, function(response) {
					
					var json_obj = $.parseJSON(response);//parse JSON		
					
					$('.customfieldvalue').append(json_obj);																
					return false;					
				});			
		}
		else
		{
			alert(language_translate.name_popup);
			$(".default_selected_type").prop('selected', true);
		}	 	
	}); 
		
	 //visable customfield attributes in model
	 $("body").on("change", "#field_type", function(event)
	 {
		  
		$('.always_checked').prop('checked', true);
		$('.required_checked').prop('checked', true);
	
		var customfield_name  = $('#customfield_name').val();
		var field_type  = $('#field_type').val();
		
		if(customfield_name != "")
		{
				if(field_type == 'dropdownlist')
				{
					$('#customfieldtype_value').val('');
					$('.customfieldvalue_css').show();	
					$('.addmorecustomvalue').hide();	
					$('.required_field_div').hide();						
				}
				if(field_type == 'textbox' || field_type == 'textarea' || field_type == 'number' || field_type == 'date')
				{
					$('.customfieldvalue_css').hide();			
				}
				if(field_type == 'dropdownlist' || field_type == 'textarea' || field_type == 'number' || field_type == 'date' || field_type == 'checkbox' || field_type == 'radio')
				{					
					$('.validation_type_div').hide();								
				}
				if(field_type == 'textbox')
				{
					$('.validation_type_div').show();				
				}	
				if(field_type == 'textbox' || field_type == 'textarea' || field_type == 'number' || field_type == 'date' || field_type == 'checkbox' || field_type == 'radio')
				{						
					$('.required_field_div').show();									
				}	
		}
		else
		{
			alert(language_translate.name_popup);	
			$(".default_selected_type").prop('selected', true);
		}		
	}); 
	//remove button customfield Remove from the database		
	 $("body").on("click", ".deletecustomfield", function()
	 {		
		if (confirm('Are you sure you want to delete this?')) 
		{
			var custom_field_id  = $(this).attr('custom_field_id');
			this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);
			var curr_data = {
					action: 'MJ_lawmgt_add_attorney_into_databasease',					
					dataType: 'json',
					custom_field_id: custom_field_id
					};
					
					$.post(lmgt.ajax, curr_data, function(response) {
						
						var json_obj = $.parseJSON(response);				
																						
						return false;					
					});	
		}	
	}); 	 
	
	//End Contact Form Custom Field 
	//get stafflink attorney info
	jQuery("body").on("change", "#stafflink_attorney", function()
	{	
		
		$('.remove_attorney_div').remove();		
		var selected = $("#stafflink_attorney option:selected");
		var case_id=$('input[name=case_id]').val();
		
        var stafflink_attorney_id = [];
		var i=0;
        selected.each(function ()
		{
            stafflink_attorney_id[i]=$(this).val();				
			i++;
        }); 
		
		var curr_data = {
					action: 'MJ_lawmgt_get_stafflink_attorney_info',					
					dataType: 'json',
					stafflink_attorney_id: stafflink_attorney_id,
					case_id: case_id
					};
					 
			
					$.post(lmgt.ajax, curr_data, function(response) {
						  
						var json_obj = $.parseJSON(response);				
						
						$('.staf_link_attorney').append(json_obj);																
						return false;					
					});		
	});
	//$("#stafflink_attorney").trigger("change");
	//Practice Area Add and Remove
    $("body").on("click", "#addremovearea", function(event)
	{
	
	   event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	   var docHeight = $(document).height(); //grab the height of the page
	   var scrollTop = $(window).scrollTop();
	   var model  = $(this).attr('model') ;
	
	   var curr_data = {
	 					action: 'MJ_lawmgt_add_or_remove_practice_area',
	 					model : model,
	 					dataType: 'json'
	 					};	
										
	 					$.post(lmgt.ajax, curr_data, function(response) { 	
				
							$('.popup-bg').show().css({'height' : docHeight});
							$('.company_list').html(response);	
												
							return true; 					
	 					});	
	
	});
  
   $("body").on("click", ".close-btn", function()
   {	
		$( ".company_list" ).empty();
		
		$('.popup-bg').hide(); // hide the overlay
	});  

	$("body").on("click", ".btn-delete-practice_area", function()
	{		
		var practice_area_id  = $(this).attr('id') ;	

		var model  = $(this).attr('model') ;
		if(confirm("Are you sure want to delete this record?"))
		{
			var curr_data = {
					action: 'MJ_lawmgt_remove_practice_area',
					model : model,
					practice_area_id:practice_area_id,			
					dataType: 'json'
					};
					
					$.post(lmgt.ajax, curr_data, function(response) {	
						
						$('#practice_area-'+practice_area_id).hide();					
						$('#practice_area_name').find('option[value='+practice_area_id+']').remove();						
						return true;				
					});			
		}
	});	

  $("body").on("click", "#btn-add-practice_area", function()
  {		
		var practice_area  = $('#practice_area').val() ;
		
		var model  = $(this).attr('model');
	
		if(practice_area != "")
		{
			var curr_data = {
				action: 'MJ_lawmgt_add_practice_area',
				model : model,
				practice_area: practice_area,			
				dataType: 'json'
				};
				
				$.post(lmgt.ajax, curr_data, function(response) 
				{				
					
					var json_obj = $.parseJSON(response);//parse JSON						
					$('.practice_areabox .table').append(json_obj[0]);
					$('#practice_area').val("");
					$('#practice_area_name').append(json_obj[1]);						
											
					return false;					
				});		
			 					
		}
		else
		{
			alert(language_translate.practice_area_popup);
		}
	});
	//End Practice Area Add Remove 
  //group Filter
  $("body").on("change", "#groupdrp1", function()
  {
		$('#contact_list1 tbody tr td').remove();
			
		var selection_id = $("#groupdrp1").val();
	
        var curr_data = {
					action: 'MJ_lawmgt_serch_group1',
					selection_id: selection_id,							
					dataType: 'json'
					};				
					$.post(lmgt.ajax, curr_data, function(response) {						
						 
						var json_obj = $.parseJSON(response);//parse JSON						
						$('#contact_list1 tbody').html(json_obj);			
						return true;			
					}); 
	});	
	$("body").on("change", "#groupdrp2", function()
	{	
		$('#contact_list2 tbody tr td').remove();			
		var selection_id = $("#groupdrp2").val();
	
        var curr_data = {
					action: 'MJ_lawmgt_serch_group2',
					selection_id: selection_id,							
					dataType: 'json'
					};				
					$.post(lmgt.ajax, curr_data, function(response)
					{	
						var json_obj = $.parseJSON(response);//parse JSON						
						$('#contact_list2 tbody').html(json_obj);			
						return true;			
					}); 
			});	
	//Practice area Filter all open mycase
	$("body").on("change", ".practice_area3", function()
	{			
		$('.case_list3 tbody tr td').remove();
			
		var selection_id = $(".practice_area3").val();
	
        var curr_data = {
					action: 'MJ_lawmgt_serch_practice_Area3',
					selection_id: selection_id,							
					dataType: 'json'
					};				
					$.post(lmgt.ajax, curr_data, function(response) {						
						
						var json_obj = $.parseJSON(response);					
						$('.case_list3 tbody').html(json_obj);			
						return true;			
					}); 
	});	
	 //Practice area Filter all close mycase	
	$("body").on("change", ".practice_area4", function()
	{
		$('.case_list4 tbody tr td').remove();
			
		var selection_id = $(".practice_area4").val();
	
        var curr_data = {
					action: 'MJ_lawmgt_serch_practice_Area4',
					selection_id: selection_id,							
					dataType: 'json'
					};				
					$.post(lmgt.ajax, curr_data, function(response) {						
						
						var json_obj = $.parseJSON(response);//parse JSON						
						$('.case_list4 tbody').html(json_obj);			
						return true;			
					}); 
	});			
	//Practice area Filter all firm open case
	$("body").on("change", ".practice_area1", function()
	{			
		$('.case_list1 tbody tr td').remove();
			
		var selection_id = $(".practice_area1").val();
	
        var curr_data = {
					action: 'MJ_lawmgt_serch_practice_Area1',
					selection_id: selection_id,							
					dataType: 'json'
					};				
					$.post(lmgt.ajax, curr_data, function(response) {						
						
						var json_obj = $.parseJSON(response);					
						$('.case_list1 tbody').html(json_obj);			
						return true;			
					}); 
	});	
	 //Practice area Filter all firm close case	
	$("body").on("change", ".practice_area2", function()
	{	
		$('.case_list2 tbody tr td').remove();
			
		var selection_id = $(".practice_area2").val();
	
        var curr_data = {
					action: 'MJ_lawmgt_serch_practice_Area2',
					selection_id: selection_id,							
					dataType: 'json'
					};				
					$.post(lmgt.ajax, curr_data, function(response) {						
						
						var json_obj = $.parseJSON(response);//parse JSON						
						$('.case_list2 tbody').html(json_obj);			
						return true;			
					}); 
	});	
		//end pracice area filter			
		//Case Name Filter all Documents
	$("body").on("change", "#name_filter_all_documents", function()
	{			
		$('.documents_list_all_documets tbody tr td').remove();
			
		var selection_id = $("#name_filter_all_documents").val();
		
        var curr_data = {
					action: 'MJ_lawmgt_serch_case_name_all_documents',
					selection_id: selection_id,							
					dataType: 'json'
					};				
					$.post(lmgt.ajax, curr_data, function(response) {						
						
						var json_obj = $.parseJSON(response);					
						$('.documents_list_all_documets tbody').html(json_obj);			
						return true;			
					}); 
	});	
	//Case Name Filter Unread Documents
	$("body").on("change", "#name_filter_unread_douments", function()
	{			
		$('.documents_list_unread_documents tbody tr td').remove();
			
		var selection_id = $("#name_filter_unread_douments").val();
		
        var curr_data = {
					action: 'MJ_lawmgt_serch_case_name_unread_documents',
					selection_id: selection_id,							
					dataType: 'json'
					};				
					$.post(lmgt.ajax, curr_data, function(response) {						
						
						var json_obj = $.parseJSON(response);					
						$('.documents_list_unread_documents tbody').html(json_obj);			
						return true;			
					}); 
	});		
	//Case Name Filter read Documents
	$("body").on("change", "#name_filter_read_douments", function()
	{			
		 $('.documents_list_read_documents tbody tr td').remove();
			
		var selection_id = $("#name_filter_read_douments").val();
		
        var curr_data = {
					action: 'MJ_lawmgt_serch_case_name_read_documents',
					selection_id: selection_id,							
					dataType: 'json'
					};				
					$.post(lmgt.ajax, curr_data, function(response) {						
						
						var json_obj = $.parseJSON(response);					
						$('.documents_list_read_documents tbody').html(json_obj);			
						return true;			
					}); 
});	
	// documents status change
	$("body").on("click", ".status_read", function()
	{				
		var record_id  = $(this).attr('record_id');
				
		var curr_data = {
				action: 'MJ_lawmgt_documets_status_change',				
				record_id: record_id,			
				dataType: 'json'
				};
				
				$.post(lmgt.ajax, curr_data, function(response) 
				{
					
					 var json_obj = $.parseJSON(response);//parse JSON						
					location.reload();				
					return false; 					
				});	
	});	
	// add tag name in mysql	    
	$("body").on("click", ".addtages_documents", function()
	{			
		 var row_no = $(this).attr('row');
		 var row_decrease = row_no-1;

		 var tag_name  = $('#tag_name'+row_no).val();
		
			var curr_data = {
					action: 'MJ_lawmgt_add_tags_documents',					
					tag_name: tag_name,			
					dataType: 'json'
					};
					
					$.post(lmgt.ajax, curr_data, function(response) {
						
						var json_obj = $.parseJSON(response);
						if(json_obj=='')
						{
							alert(language_translate.tag_name_popup);
						}
						else
						{
							
							var div_tag_name = $('#hidden_tags'+row_no).val().split(",");
							
							if(jQuery.inArray(json_obj, div_tag_name) !== -1)
							{
								alert(language_translate.tag_duplicate_popup);
								$('#tag_name'+row_no).val('');
							}
							else
							{
								$('#hidden_tags'+row_no).val($('#hidden_tags'+row_no).val()+','+ json_obj);
							
								$('.list_tag_name'+row_no).append('<div class="added_tag tagging_name margin_top_2px">'+json_obj+'<i class="close fa fa-times removetages sugcolor" row="'+row_no+'" value="'+json_obj+'"></i><input type="hidden"  name="documents_tag_names['+row_decrease+'][]" value="'+json_obj+'"></div>');	
								
								$('#tag_name'+row_no).val('');
							}									
						}														
						return false;					
					});		
	});
	// auto suggest box in tag
	jQuery(document).on('keydown', 'input.tages_add', function(ev) 	
	{
		var row_no = $(this).attr('row');
	
		var keyword=$('#tag_name'+row_no).val();

		var curr_data = {
				action: 'MJ_lawmgt_add_tags_documents_auto_suggesstion',		
				keyword:keyword,
				dataType: 'json'
				
				};
				
				$.post(lmgt.ajax, curr_data, function(response)
				{
					var json_obj = $.parseJSON(response);
				
					$('#tag_name'+row_no).autocomplete({
						source: json_obj
					});
					return false;					
				});		 
	});
	// close added tags
	$('body').on('click','.close',function()
	{
		var row_no = $(this).attr('row');	
		var remove_value = $(this).attr('value');	
	
		var hidden_tags=$('#hidden_tags'+row_no).val();
		
		var strArray = hidden_tags.split(',');

        for (var i = 0; i < strArray.length; i++)
	   {
             if (strArray[i] === remove_value) 
			{
                strArray.splice(i, 1);
            }
       }
		$('#hidden_tags'+row_no).val(strArray);									
		 
		$(this).parents('.added_tag').remove(); 
		
	});	
	 
	// get subtotal value in time entry
	jQuery(document).on('change', 'input.added_subtotal', function(ev) 	
	{			
		var row_no = $(this).attr('row');
		$('.time_entry_sub'+row_no).empty();
		var time_entry_hours=$('.time_entry_hours'+row_no).val();
		var time_entry_rate =$('.time_entry_rate'+row_no).val();
				
		if(time_entry_hours != "" || time_entry_hours != "")
		{	
			var curr_data = {
					action: 'MJ_lawmgt_display_time_entery_subtotal',		
					time_entry_hours:time_entry_hours,
					time_entry_rate:time_entry_rate,
					dataType: 'json'					
					};
					
					$.post(lmgt.ajax, curr_data, function(response) {
						var json_obj = $.parseJSON(response);
						
						$('.time_entry_sub'+row_no).val(json_obj);
						return false;					
					});		
		}					
	});	
	// get subtotal value in expenses
	jQuery(document).on('change', 'input.added_subtotal_expenses', function(ev) 	
	{			
		var row_no = $(this).attr('row');
		$('.expense_sub'+row_no).empty();
		var expense_quantity=$('.expense_quantity'+row_no).val();
		var expense_price =$('.expense_price'+row_no).val();
				
		if(expense_quantity != "" || expense_price != "")
		{	
			var curr_data = {
					action: 'MJ_lawmgt_display_expenses_subtotal',		
					expense_quantity:expense_quantity,
					expense_price:expense_price,
					dataType: 'json'					
					};
					
					$.post(lmgt.ajax, curr_data, function(response) {
						var json_obj = $.parseJSON(response);
						
						$('.expense_sub'+row_no).val(json_obj);
						return false;					
					});		
		}					
	});	
	// get subtotal value in flat fee
	jQuery(document).on('change', 'input.added_subtotal_flat_fee', function(ev) 	
	{			
		var row_no = $(this).attr('row');
		$('.flat_fee_sub'+row_no).empty();
		var flat_fee_quantity=$('.flat_fee_quantity'+row_no).val();
		var flat_fee_price =$('.flat_fee_price'+row_no).val();
				
		if(flat_fee_quantity != "" || flat_fee_price != "")
		{	
			var curr_data = 
					{
						action: 'MJ_lawmgt_display_flat_fee_subtotal',		
						flat_fee_quantity:flat_fee_quantity,
						flat_fee_price:flat_fee_price,
						dataType: 'json'					
					};
					
					$.post(lmgt.ajax, curr_data, function(response) {
						var json_obj = $.parseJSON(response);
						
						$('.flat_fee_sub'+row_no).val(json_obj);
						return false;					
					});		
		}					
	});
	//invoice add Payment Module pop up
	$("body").on("click", ".show-payment-popup", function(event)
	{		
		event.preventDefault(); // disable normal link function so that it doesn't refresh the page
		var docHeight = $(document).height(); //grab the height of the page
		var scrollTop = $(window).scrollTop();
		var invoice_id  = $(this).attr('invoice_id');
		var case_id  = $(this).attr('case_id');
		var view_type  = $(this).attr('view_type');
		var due_amount  = $(this).attr('due_amount');
	
		var curr_data = {
						action: 'MJ_lawmgt_add_payment',
						invoice_id: invoice_id,
						case_id: case_id,
						view_type: view_type,
						due_amount: due_amount,
						dataType: 'json'
						};	 	
											
						$.post(lmgt.ajax, curr_data, function(response) 
						{ 				 						 
							$('.popup-bg').show().css({'height' : docHeight});							
							$('.invoice_data').html(response);	
							return true; 					
						});			 
	});	
	// task Due date type
	$("body").on("change", "#due_date_type", function()
	{		
		var row_no = $(this).attr('row');
		 
		var due_date_type=$('.due_date_type'+row_no).val();	

		var event_name=[];
		var i=0;
			
		$(".event_subject").each(function () 
		{
			
			var e_subject=$(this).val();
			var option_class = $(this).attr('opt_class');
			
			event_name[i]='<option class='+option_class+' value='+e_subject+'>'+e_subject+'</option>';
			i++;
		});	  
		
		if($('.task_event_name'+row_no).find('option').length <= 0)
		{	
			$('.task_event_name'+row_no).html(event_name);	
		}	
		 
		 if(due_date_type == "automatically")
		 {	
				$('.date_time_by_event'+row_no).css("display", "block");		
			
		 }
		 if(due_date_type == "no_due_date")
		 { 
			$('.date_time_by_event'+row_no).css("display", "none");
		 }
			 
	});	
	// event subject add in task Due date type
	jQuery(document).on('keyup', 'input.event_subject', function(event) 	
	{
		var option_class = $(this).attr('opt_class');
		var e_subject=$(this).val();
		 
		$('.'+option_class).val(e_subject).text(e_subject);		 			
	});
	// delete event div in workflow
	$("body").on("click", ".remove_event", function(event)
	{
		$(this).closest('.workflow_item').remove();
		 var row = $(this).attr('row');
		
		$(".task_event_name option[class=op"+row+"]").remove();	 
	});
	//get Workflow Details
	$("body").on("change", "#apply_workflow_name", function()
	{	
		$('.apply_workflow_details_div').empty();
		
		var apply_workflow_id = $("#apply_workflow_name").val();
		var case_id = $("#case_id").val();
	
        var curr_data = {
							action: 'MJ_lawmgt_apply_workflow_details',
							apply_workflow_id: apply_workflow_id,							
							case_id: case_id,							
							dataType: 'json'
						};				
						$.post(lmgt.ajax, curr_data, function(response)
						{	
							var json_obj = $.parseJSON(response);//parse JSON	

							if(json_obj[0] == "all_ready_apply_workflow")
							{
								alert(language_translate.workflow_popup);
							}
							else
							{
								$('.apply_workflow_details_div').html(json_obj[1]);
								jQuery('.event_contact').multiselect({ nonSelectedText:'Select Client'});		
								jQuery('.event_contact').multiselect('rebuild');		
								jQuery('.task_contact').multiselect({ nonSelectedText:'Select Client'});		
								jQuery('.task_contact').multiselect('rebuild');	
							}								
														
							return false;			
						}); 
	});	
	$('body').on('focus',".apply_case_event_date", function()
	{		
		var date = new Date();
        date.setDate(date.getDate()-0);
		$('.apply_case_event_date').datepicker({
			startDate: date,
            autoclose: true
       });	
	});
	$("body").on("click","#profile_change",function() 
	{		
		//event.preventDefault(); // disable normal link function so that it doesn't refresh the page
		 var docHeight = $(document).height(); //grab the height of the page
		 var scrollTop = $(window).scrollTop();
	   
		 var curr_data = {
					action: 'MJ_lawmgt_change_profile_photo',
					dataType: 'json'
					};					
					
					$.post(lmgt.ajax, curr_data, function(response) {	
						$('.popup-bg').show().css({'height' : docHeight});
						$('.profile_picture').html(response);	
					});
	});
	
	// task repeat never then hide Repeat Until date		
	$("body").on("change", "#repeat", function()
	{	
		var repeat = $("#repeat").val();
		
		 if(repeat == "0")
		 { 
			$('.repeatuntil_div').css("display", "none");
		 }
		 else
		 {
			 $('.repeatuntil_div').css("display", "block");
		 }
	});	
	// end task repeat never then hide Repeat Until date		
	$('.onlyletter_number_space_validation').keypress(function( e ) 
	{     
		var regex = new RegExp("^[0-9a-zA-Z \b]+$");
		var key = String.fromCharCode(!event.charCode ? event.which: event.charCode);
		if (!regex.test(key)) 
		{
			event.preventDefault();
			return false;
		} 
   });  
  
  //------------------- ADDREMOVE CATEGORY -----------------//
  
  $("body").on("click", "#addremove_cat", function(event)
  {	  
	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	  var model  = $(this).attr('model') ;
	 
	   var curr_data = {
	 					action: 'MJ_lawmgt_add_or_remove_category',
	 					model : model,
	 					dataType: 'json'
	 					};	
										
	 					$.post(lmgt.ajax, curr_data, function(response) { 
						 
							$('.popup-bg').show().css({'height' : docHeight});
							$('.category_list').html(response);	
							return true; 					
	 					});		
  });  
  //--------------- ADD CATEGORY NAME -------------------//  
   $("body").on("click", "#btn-add-cat", function()
   {	
		var category_name  = $('#category_name').val();
		
		var model  = $(this).attr('model');
		/* alert(category_name);
		alert(model);
		return false;    */
		if(category_name != "")
		{	 
			var curr_data = {
					action: 'MJ_lawmgt_add_category',
					model : model,
					category_name: category_name,			
					dataType: 'json'
					};
					
					$.post(lmgt.ajax, curr_data, function(response) 
					{				
						var json_obj = $.parseJSON(response);//parse JSON	
						 
                        if(json_obj[2]=="1")
						{
							$('.category_listbox .table').append(json_obj[0]);
							$('#category_name').val("");
							
							if(model=="court_category")
							{
								$(".court_category").append(json_obj[1]);
							}
							else
							{  
								jQuery('.'+model).append(json_obj[1]);
								jQuery('#'+model).append(json_obj[1]);								
								jQuery('.case_type').append(json_obj[1]);
								jQuery('.bench_category').multiselect({ nonSelectedText:'Select Bench Name'});		
								jQuery('.bench_category').multiselect('rebuild'); 
							}
						}
						else 
						{
							alert(json_obj[3]);
						}
						return false;					
					});	
		}
		else
		{
			if(model == "court_category")
			{
				alert(language_translate.enter_court_category_alert);	
			}
			if(model == "state_category")
			{
				alert(language_translate.enter_state_category_alert);	
			}
			if(model == "bench_category")
			{
				alert(language_translate.enter_bench_category_alert);	
			}				
		} 
	});
	
	//---------- DELETE CATEGORY -----------//	
	$("body").on("click", ".btn-delete-cat", function()
	{		
		var cat_id  = $(this).attr('id') ;	
		var model  = $(this).attr('model') ;
		 
		if(confirm("Are you sure want to delete this record?"))
		{
			var curr_data = {
					action: 'MJ_lawmgt_remove_category',
					model : model,
					cat_id:cat_id,			
					dataType: 'json'
					};
					 
					$.post(lmgt.ajax, curr_data, function(response) {
                        
						jQuery('#cat-'+cat_id).hide();
						jQuery("#"+model).find('option[value='+cat_id+']').remove();	
						jQuery("."+model).find('option[value='+cat_id+']').remove();
						jQuery('.case_type').find('option[value='+cat_id+']').remove();					
                    	jQuery('.bench_category').multiselect('rebuild');				
						return true;				
					});			
		}
	});
	
	//------------- CLOSE POPUP -------------------//	
	$("body").on("click", ".close-btn", function()
	{	
		$( ".category_list" ).empty();				 		
		$('.popup-bg').hide(); // hide the overlay
	}); 		
	 
	//---------- State Name by Court Name ----------// 
	jQuery("body").on("change", ".courttostate", function()
	{		 
		var court_id = $(".courttostate").val();
		
		var user_data ={
			action: 'MJ_lawmgt_get_court_by_state',
			court_id : court_id,			
			dataType: 'json'
		};
		
		$.post(lmgt.ajax, user_data, function(response)
		{
			var json_obj = $.parseJSON(response);//parse JSON	
			$('.court_by_state').html('');	
			$('.court_by_state').append(json_obj); 
			return false;			
		});	
	});
	//---------- Bench Name by State Name ----------//company_by_assigned_attorney
	jQuery("body").on("change", ".state_to_bench", function()
	{
		var state_id = $(".state_to_bench").val();
		var user_data ={
			action: 'MJ_lawmgt_get_state_by_bench',
			state_id : state_id,			
			dataType: 'json'
		};
		$.post(lmgt.ajax, user_data, function(response)
		{ 
		 
		  var json_obj = $.parseJSON(response);//parse JSON	
		  $('.state_by_bench').html('');	
		  $('.state_by_bench').append(json_obj); 
		  return false;
			
		});	
	});
	// year change case Module
	$("body").on("change", ".case_year_filter", function()
	{		
		$('.case_list tbody tr td').remove();
			
		var selection_id = $(".case_year_filter").val();
		var hidden_case_filter = $(".hidden_case_filter").val();
		 
	    var curr_data = {
					action: 'MJ_lawmgt_case_year_filter',
					selection_id: selection_id,								
					hidden_case_filter: hidden_case_filter,								
					dataType: 'json'
					};
					
					$.post(lmgt.ajax, curr_data, function(response) {						
				    
						var json_obj = $.parseJSON(response);//parse JSON
						$('.case_list tbody').html(json_obj);			
						return true;			
					}); 
	});
	
	// Due Date Wise Data In Task
	$("body").on("click", "#filter_task_duedate", function()
	{
		
		$('.tast_list1 tbody tr td').remove();

		var start_date = $(".sdate").val();
		var end_date = $(".edate").val();
		 
		if(start_date != "" && end_date != "")
		{ 
			var curr_data = {
						action: 'MJ_lawmgt_task_duedate_by_filter',
						start_date: start_date,								
						end_date: end_date,								
						dataType: 'json'
						};
						
						$.post(lmgt.ajax, curr_data, function(response) {
							 
							var json_obj = $.parseJSON(response);//parse JSON						
							$('.tast_list1 tbody').html(json_obj);			
							return true;			
						}); 
		}
		else
		{
			alert(language_translate.select_date_popup);
		}
	});
	// Court Wise Filter Data
	$("body").on("change", ".court_filter", function()
	{		
		$('.cause_list_table tbody tr td').remove();
			
		var court_id = $(".court_filter").val();
		 
	    var curr_data = {
					action: 'MJ_lawmgt_court_wise_filter',
					court_id: court_id,								
					dataType: 'json'
					};
					
					$.post(lmgt.ajax, curr_data, function(response) {						
					  
						var json_obj = $.parseJSON(response);//parse JSON						
						$('.cause_list_table tbody').html(json_obj);			
						return true;			
					}); 
	});
	// NEXT HEARING DATE BY FILTER IN CASE DIARY
	$("body").on("click", "#filter_case_diary_next_hearing_date", function()
	{		
		$('.case_diary_list tbody tr td').remove();

		var start_date = $(".sdate").val();
		var end_date = $(".edate").val();
		if(start_date != "" && end_date != "")
		{ 
			var curr_data = {
						action: 'MJ_lawmgt_case_diary_filter_by_next_hearing_date',
						start_date: start_date,								
						end_date: end_date,								
						dataType: 'json'
						};
						
						$.post(lmgt.ajax, curr_data, function(response) 
						{								
							var json_obj = $.parseJSON(response);//parse JSON						
							$('.case_diary_list tbody').html(json_obj);			
							return true;			
						}); 
		}
		else
		{
			alert(language_translate.select_date_popup);
		}
	});
	jQuery("body").on("click",'.remove_time_entry',function() 
	{		
		if (confirm('Are you sure you want to delete this?')) 
		{
			$(this).closest('.main_time_entry_div').remove();
		}	
		return false;
	});
	jQuery("body").on("click",'.remove_expenses_entry',function() 
	{		
		if (confirm('Are you sure you want to delete this?')) 
		{
			$(this).closest('.main_expenses_entry_div').remove();
		}	
		return false;
	});
	jQuery("body").on("click",'.remove_flat_entry',function() 
	{		
		if (confirm('Are you sure you want to delete this?')) 
		{
			$(this).closest('.main_flat_entry_div').remove();
		}	
		return false;
	});
});