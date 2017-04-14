function signIn(){
	$('.cls_err_msg').hide();
	
	if($('#email').val()==""){
		$('#err__email').show();
		$('#err__email').html("You can't leave this empty.");
		$('#email').focus();
		
		return false;
	}

	if($('#pwd').val()==""){
		$('#err__pwd').show();
		$('#err__pwd').html("You can't leave this empty.");
		$('#pwd').focus();
		
		return false;
	}
	
	blockui_open();
	
	$.post('/y/app/signInComplete', {email:$('#email').val(),pwd:$('#pwd').val()}, function(res){
		var result = $.parseJSON(res);
		if(result.status==true) {
			window.location.href = "/y/app/step1";
		}
		else{
			$('#err__'+result.err_type).show();
			$('#err__'+result.err_type).html(result.err_msg);
			$('#'+result.err_type).select();
			blockui_close();
		}
	});
}

function checkEmail(){
	var email = $('#email').val();
	$('#err__email').css('color', 'red');
	
	if(email==""){
		$('#err__email').show();
		$('#err__email').html("You can't leave this empty.");
		$('#email').focus();
		
		return false;
	}

	if(email.length < 5 || email.indexOf('@') < 1 || email.indexOf('.') < 0){
		$('#err__email').show();
		$('#err__email').html("Invalid E-mail Format.");
		$('#email').focus();
			
		return false;
	}
	
	$.post('/y/app/checkEmail', {email:email}, function(res){
		var result = $.parseJSON(res);
		if(result.status==true) {
			$('#is_check_email').val('Y');
			$('#err__email').css('color', 'green');
			$('#err__email').html("You can use this Email.");	
		}
		else{
			$('#is_check_email').val('N');
			$('#err__email').show();
			$('#err__email').html("Someone's already using that Email.");
		}
	});
}

function saveStep1(){
	if(checkStep1()==true){
		blockui_open();
		
		$.post('/y/app/saveStep1', $('#appForm').serialize(), function(res){
			var result = $.parseJSON(res);
			if(result.status==true) {
				window.location.href="/y/app/step2";
			}
			else{
				alert('Error!'+result.err_msg);
				blockui_close();
			}
		});
	}
}

function checkStep1(){
	$('.cls_err_msg').hide();
	$('#err__email').css('color', 'red');
	
	var is_modify = $('#is_modify').val();

	if($('#email').val()=="" && is_modify=="N"){
		$('#err__email').show();
		$('#err__email').html("You can't leave this empty.");
		$('#email').focus();
		
		return false;
	}
	
	if($('#is_check_email').val()=="N"){
		$('#err__email').show();
		$('#err__email').html("Please check availability.");
		$('#available').focus();
		
		return false;
	}
	
	if($('#pwd1').val()=="" && is_modify=="N"){
		$('#err__pwd1').show();
		$('#err__pwd1').html("You can't leave this empty.");
		$('#pwd1').focus();
		
		return false;
	}
	
	if($('#pwd1').val().length < 6 && is_modify=="N") {
		$('#err__pwd1').show();
		$('#err__pwd1').html("6 or more characters.");
		$('#pwd1').focus();
		
		return false;
	}
	
	if($('#gender').val()==""){
		$('#err__gender').show();
		$('#err__gender').html("You can't leave this empty.");
		$('#gender').focus();
		
		return false;
	}
	
	if($('#first_nm').val()==""){
		$('#err__user_nm').show();
		$('#err__user_nm').html("You can't leave this empty.");
		$('#first_nm').focus();
		
		return false;
	}
	if($('#last_nm').val()==""){
		$('#err__user_nm').show();
		$('#err__user_nm').html("You can't leave this empty.");
		$('#last_nm').focus();
		
		return false;
	}
	
	if($('#dob_d').val()==""){
		$('#err__dob').show();
		$('#err__dob').html("You can't leave this empty.");
		$('#dob_d').focus();
		
		return false;
	}
	if($('#dob_y').val()==""){
		$('#err__dob').show();
		$('#err__dob').html("You can't leave this empty.");
		$('#dob_y').focus();
		
		return false;
	}
	if($('#dob_y').val().length!=4){
		$('#err__dob').show();
		$('#err__dob').html("4 digits.");
		$('#dob_y').focus();
		
		return false;
	}

	if($('#marital').val()==""){
		$('#err__marital').show();
		$('#err__marital').html("You can't leave this empty.");
		$('#marital').focus();
		
		return false;
	}

	if($('#scholarship').val()==""){
		$('#err__scholarship').show();
		$('#err__scholarship').html("You can't leave this empty.");
		$('#scholarship').focus();
		
		return false;
	}
	
	if($('#disability').val()=="Y" && ($('#disability_detail').val()=="")){
		$('#err__disability_detail').show();
		$('#err__disability_detail').html("You can't leave this empty.");
		$('#disability_detail').focus();
		
		return false;
	}
	
	if($('#security_q').val()==""){
		$('#err__security_q').show();
		$('#err__security_q').html("You can't leave this empty.");
		$('#security_q').focus();
		
		return false;
	}
	
	if($('#security_a').val()==""){
		$('#err__security_a').show();
		$('#err__security_a').html("You can't leave this empty.");
		$('#security_a').focus();
		
		return false;
	}
	
	if($('#tel_no').val()==""){
		$('#err__tel_no').show();
		$('#err__tel_no').html("You can't leave this empty.");
		$('#tel_no').focus();
		
		return false;
	}
	
	if($('#addr1').val()==""){
		$('#err__addr1').show();
		$('#err__addr1').html("You can't leave this empty.");
		$('#addr1').focus();
		
		return false;
	}
	
	if($('#city').val()==""){
		$('#err__city').show();
		$('#err__city').html("You can't leave this empty.");
		$('#city').focus();
		
		return false;
	}
		
	if($('#zip_cd').val()==""){
		$('#err__zip_cd').show();
		$('#err__zip_cd').html("You can't leave this empty.");
		$('#zip_cd').focus();
		
		return false;
	}
	
	return true;
}

function saveStep2(mem_ctg){
	blockui_open();
	
	$.post('/y/app/saveStep2', {mem_ctg:mem_ctg}, function(res){
		var result = $.parseJSON(res);
		if(result.status==true) {
			window.location.href="/y/app/step3";
		}
		else{
			alert('Error!');
			blockui_close();
		}
	});	
}

function saveStep3(){
	if(checkStep3()==true){	
		blockui_open();
		
		var f = document.appForm;
		f.action = "/y/app/saveStep3";
		f.submit();
	}
}

function checkDisability(val){
	if(val=="Y"){
		$('#id_disability_detail').fadeIn('slow');
		$('#disability_detail').focus();
	}
	else{
		$('#id_disability_detail').fadeOut('slow');
	}
}

function checkStep3(){
	$('.cls_err_msg').hide();
	
	var mem_level = $("input:radio[name=app[mem_level]]:checked").val();
	if(mem_level==undefined || mem_level=="" || mem_level==1){
		$('#err__mem_level').show();
		$('#err__mem_level').html("Please choose an academic level.");
		$('#level_f').focus();
		
		return false;
	}

	if($('#high_nm').val()==""){
		$('#err__high_nm').show();
		$('#err__high_nm').html("You can't leave this empty.");
		$('#high_nm').focus();
		
		return false;
	}

	if($('#univ_nm').val()==""){
		$('#err__univ_nm').show();
		$('#err__univ_nm').html("You can't leave this empty.");
		$('#univ_nm').focus();
		
		return false;
	}

	if($('#gpa').val()=="" || $('#gpa_total').val()==""){
		$('#err__gpa').show();
		$('#err__gpa').html("You can't leave this empty.");
		$('#gpa').focus();
		
		return false;
	}

	if($('#income').val()==""){
		$('#err__income').show();
		$('#err__income').html("You can't leave this empty.");
		$('#income').focus();
		
		return false;
	}

	if($('.family_name').filter(function(){ return !this.value.trim(); }).length){
		$('#err__family').show();
		$('#err__family').html("You can't leave this empty.");
		scrollToTarget('td_family');
		
		//return false;
	}
	
	return true;
}

function appSubmit(){
	if(checkStep3()==true){
		if(confirm("If you submit this application, you can't modify anymore.\rAre you sure you want to submit?")){
			
		}
	}
}
