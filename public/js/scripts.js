$(document).ready(function(e){


			/*ALL ADMIN TO SUBSCRIBE TO MAILCHIMP NEWSLETTER*/

	$(".create_mailchimp_subscription").submit(function(e){
		e.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			type: "POST",
			url: $(this).attr('action'),
			data:formData,
			cache: false,
			contentType: false,
            processData: false,
			beforeSend: function(){
				$(".btn_submit_subscribe_to_mailchimp").html("Loading...")//.attr("disabled",true);
			}, 
			success: function(data){ 
				//alert(data);
				if (data=='newsletter_successfully_subscribed') {
					
					swal("Success","Please check your email for confirmation","success");

					setTimeout(function(){
					$(".btn_submit_subscribe_to_mailchimp").html("Subscribe").removeAttr("disabled",true);
					$(".mailchimp_subscribe_member_email_address").val('');
					},2000);
				}  
				else if (data=='already_subscribed') {
					swal("Already Subscribed","You've already subscribed to our Newsletter","warning");
					$(".btn_submit_subscribe_to_mailchimp").html("Subscribe").removeAttr("disabled",true);
				}  

				else if (data=='problem_encountered_try_later') {
					swal("Problem Occured","Something went wrong, please try again later.","error");
					$(".btn_submit_subscribe_to_mailchimp").html("Subscribe").removeAttr("disabled",true);
				}   
				else{
					swal("Unknown error occurred","Something went wrong while trying to initiate this request.","error");
					$(".btn_submit_subscribe_to_mailchimp").html("Subscribe").removeAttr("disabled",true);
				}

			}
		});

	});

			/*ALL ADMIN TO SUBSCRIBE TO MAILCHIMP NEWSLETTER*/
			
			
			
			
			
	
	
	
		/*SUBMIT TRANSFER PIN OTP*/
	$(".btn_submit_wallet_trf_sms_otp").click(function(e){
		e.preventDefault();
		var el = $(this);
		var set_wallet_transfer_pin = $(".set_wallet_transfer_pin").val();
		var set_wallet_transfer_token = $(".set_wallet_transfer_token").val();
		var to_use_transfer_sms_otp = $(".to_use_transfer_sms_otp").val();

		if (set_wallet_transfer_pin=='' && set_wallet_transfer_token=='') {
			swal("All fields are required","Please go back to the dashboard and come back here because to restart afresh because the system can not send an empty value","warning");
		}
		else if (to_use_transfer_sms_otp=='') {
			swal("OTP field is Required","You need to enter the OTP sent to your Mobile Phone before you can proceed","error");
		}
		else if (to_use_transfer_sms_otp.length<6) {
			swal("OTP code is lesser than 6 digit","Please your OTP must be of 6 digit before the system can allow you to proceed","warning");
		}
		else{
			$.ajax({
				type: "POST",
				url: "../includes/phpfiles",
				data: {set_wallet_transfer_pin,set_wallet_transfer_token,to_use_transfer_sms_otp},
				cache: false,
				beforeSend: function(){
					el.html("Please wait...").attr("disabled",true);
				},
				success: function(data){
					if (data=='account_not_exist') {
						swal("Account Not Exist","The user account not exist or user suspended","error");
						el.html("Submit OTP").removeAttr("disabled",true);
					}
					else if (data=='user_sms_otp_not_valid') {
						swal("OTP NOT VALID","The OTP you entered is not valid. If you retry after 3 times, you account will be suspended","error");
						el.html("Submit OTP").removeAttr("disabled",true);
					} 
					else if (data=='wallet_pin_success') {
						swal("Success","Wallet Transfer PIN created successfully.","success");
						setTimeout(function(){
						window.location='wallet-transfer';
						},2000);
					}
					else if (data=='wallet_pin_error') {
						swal("Oops!!, An Error Occured","Something went wrong while trying to create the Transfer PIN. Please try again or contact the site administrator if these error persist","error");
						el.html("Submit OTP").removeAttr("disabled",true);
					}
					else{
						swal("Unknown error occured","Please contact the site administrator to report this error","warning");
						el.html("Submit OTP").removeAttr("disabled",true);
					}
				}
			});
		}

	});
	/*SUBMIT TRANSFER PIN OTP*/

////end the document ready function
});