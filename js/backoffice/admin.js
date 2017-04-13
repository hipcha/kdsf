// login check
function checkLoginForm(){
	if($('#email').val()==''){
		alert('Please input your E-mail.');
		$('#email').focus();
		return false;
	}
	if($('#pwd').val()==''){
		alert('Please input your password.');
		$('#pwd').focus();
		return false;
	}
	
	$.post('/y/backoffice/admin/login', {email:$('#email').val(), pwd:$('#pwd').val()}, function(req){
		if(req!=''){
	        var result = $.parseJSON(req);
	        if(result.status==='success') {
	            document.location.href = result.url;
	        }
	        else{
	        	alert(result.err_msg);
	        }
		}
	});
}

// menu authority save
function menuAuthoritySave(frm){
	var chkbox = frm['checkItem[]'];
	var count = 0;
	var menu_cds = "";
	for(i=0; i<chkbox.length; i++){
		if(chkbox[i].checked){
			if(menu_cds==""){
				menu_cds = chkbox[i].value;
			}
			else{
				menu_cds = menu_cds+","+chkbox[i].value;
			}
			count++;
		}
	}
	
	if(count > 0){
		var f = document.settingForm;
		blockui_open();
		
		var s_mode = $("'input:radio[name=s_mode]:checked").val();
		
		if(s_mode==0){
			$.post('/backoffice/system/menuAuthoritySave', {mem_id:$('#mem_id').val(), menu_cds:menu_cds, s_mode:s_mode}, function(req){
				var result = $.parseJSON(req);
		        if(result.status==true) {
		        	window.location.href = '/backoffice/system/menuAuthority?s_mode=0&mem_id='+$('#mem_id').val();
		        }
		        else{
		        	alert(result.err_msg);
		        	blockui_close();
		        }
			});
		}
		else{
			$.post('/backoffice/system/menuAuthoritySave', {admin_grp_cd:$('#admin_grp_cd').val(), menu_cds:menu_cds, s_mode:s_mode}, function(req){
				var result = $.parseJSON(req);
		        if(result.status==true) {
		        	window.location.href = '/backoffice/system/menuAuthority?s_mode=1&admin_grp_cd='+$('#admin_grp_cd').val();
		        }
		        else{
		        	alert(result.err_msg);
		        	blockui_close();
		        }
			});
		}
	}
	else{
		alert("Please check the menu to be granted.");
		return false;
	}
}

// group add
function groupAdd(){
	if($('#admin_grp_nm').val()==''){
		alert("Please input Group Name");
		$('#admin_grp_nm').focus();
		return false;
	}

	blockui_open();

	$.post('/backoffice/system/groupAdd', $('#settingForm').serialize(), function(req){
		var result = $.parseJSON(req);
        if(result.status==true) {
        	window.location.href = '/backoffice/system/adminGroup';
        }
        else{
        	alert(result.err_msg);
        	blockui_close();
        }
	});
}

// group modify
function groupModify(){
	if($('#admin_grp_nm').val()==''){
		alert("Please input Group Name");
		$('#admin_grp_nm').focus();
		return false;
	}

	blockui_open();

	$.post('/backoffice/system/groupModify', $('#settingForm').serialize(), function(req){
		var result = $.parseJSON(req);
		if(result.status==true) {
			window.location.href = '/backoffice/system/adminGroup?admin_grp_cd='+$('#admin_grp_cd').val();
		}
		else{
			alert(result.err_msg);
			blockui_close();
		}
	});
}

// group delete
function groupDelete(admin_grp_cd){
	var admin_grp_cd;
	
	if(confirm('Are you sure you want to delete this Group?')){
		blockui_open();
	
		$.post('/backoffice/system/groupDelete', {admin_grp_cd:admin_grp_cd}, function(req){
			var result = $.parseJSON(req);
			if(result.status==true) {
				window.location.href = '/backoffice/system/adminGroup';
			}
			else{
				alert(result.err_msg);
				blockui_close();
			}
		});
	}
}

// admin add
function adminAdd(){
	// check name
	if($('#mem_nm').val()==''){
		alert("Please input Admin Name.");
		$('#mem_nm').focus();
		return false;
	}

	// check email
	if($('#email').val()==''){
		alert("Please input E-mail Address.");
		$('#email').focus();
		return false;
	}
	
	// validate email
	if(!validateEmail($('#email').val())){
		alert("Invalid E-mail Address.");
		$('#email').focus();
		return false;
	}

	// check password
	if($('#pwd').val()==''){
		alert("Please input your password.");
		$('#pwd').focus();
		return false;
	}
	
	// check member
	$.post('/backoffice/system/checkAdmin', {email:encodeURIComponent($('#email').val())}, function(res){
		if(res==true){
			alert("E-mail Address Already in Use.");
			$('#email').focus();
			return false;
		}
		else{
			blockui_open();

			$.post('/backoffice/system/adminAdd', $('#settingForm').serialize(), function(req){
				var result = $.parseJSON(req);
				if(result.status==true) {
					window.location.href = '/backoffice/system/admin';
				}
				else{
					alert(result.err_msg);
					blockui_close();
				}
			});
		}
	});
}

// admin modify
function adminModify(){
	// check name
	if($('#mem_nm').val()==''){
		alert("Please input Admin Name.");
		$('#mem_nm').focus();
		return false;
	}

	// check email
	if($('#email').val()==''){
		alert("Please input E-mail Address.");
		$('#email').focus();
		return false;
	}
	
	// validate email
	if(!validateEmail($('#email').val())){
		alert("Invalid E-mail Address.");
		$('#email').focus();
		return false;
	}
	
	blockui_open();

	$.post('/backoffice/system/adminModify', $('#settingForm').serialize(), function(req){
		var result = $.parseJSON(req);
		if(result.status==true) {
			window.location.href = '/backoffice/system/admin?mem_id='+$('#mem_id').val();
		}
		else{
			alert(result.err_msg);
			blockui_close();
		}
	});
}

// admin delete
function adminDelete(mem_id){
	var mem_id;
	
	if(confirm('Are you sure you want to delete this User?')){
		blockui_open();
	
		$.post('/backoffice/system/adminDelete', {mem_id:mem_id}, function(req){
			var result = $.parseJSON(req);
			if(result.status==true) {
				window.location.href = '/backoffice/system/admin';
			}
			else{
				alert(result.err_msg);
				blockui_close();
			}
		});
	}
}

function cdsave(){
	if($('#search_class_cd').val()==''){
		alert("Please search first.");
		$('#search_class_cd').focus();
		return false;
	}
	if($('#cd').val()==''){
		alert("Please input Code.");
		$('#cd').focus();
		return false;
	}
	if($('#cd_nm').val()==''){
		alert("Please input Code name.");
		$('#cd_nm').focus();
		return false;
	}
	if($('#remark').val()==''){
		alert("Please input Description.");
		$('#remark').focus();
		return false;
	}
	
	var cd=document.settingForm.cd.value;
	var cd_len=cd.length;


	var id= document.getElementById("cd").value;
	  var regx = /^[a-zA-Z0-9]*$/;
	  if(!regx.test(id)){
	  alert("Code is Only English or Number");
	  $('#cd').focus();
	  return false;
	  }
	  
	if(cd_len>3){
		alert("Code is Too long");
		$('#cd').focus();
		return false;
	}
	
	
	$.post('/backoffice/system/createCodeCheck',  {search_class_cd:$('#search_class_cd').val(), cd:$('#cd').val(), cd_nm:$('#cd_nm').val(), remark:$('#remark').val()}, function(req){
		 var result = $.parseJSON(req);
		 if(result.status==='success') {
			 document.settingForm.submit();
		 }else{
		alert("Same code aready exist");
		 }
	   });
 }

function data_update($check){
	check_temp='';
	for(i=0;i<document.cdlist.elements.length;i++){
		var form_str = document.cdlist.elements[i];
		if(form_str.name=='checkItem[]'){
			if(form_str.checked) check_temp++;
		}
	}
	
	
	
	if(!check_temp){
		alert('선택된 정보가 없습니다.');
		return false;
	}
	
	if($check=="modify"){
		document.cdlist.action_admin.value="modify";
		document.cdlist.submit();
	}

	else if($check=="delete"){
		var class_cd=document.cdlist.pass_class_cd.value;
		if(class_cd=='00'){
			alert("코드구분이 00인것은 삭제 할 수 없습니다.");
			return;
		}
		document.cdlist.action_admin.value="delete";
		document.cdlist.submit();
		 //if(!confirm('정말 삭제 하시겠습니까?!!!!!!!!!!!!!!!!!!!!!!!!!!!!')) return false;
		if(confirm('Are you sure you want to delete this Group?')){
			blockui_open();
			document.cdlist.submit();
			$.post('/backoffice/system/codeUpdate', {tmp_class_cd:$('#tmp_class_cd').val(), tmp_cd:$('#tmp_cd').val()}, function(req){
				var result = $.parseJSON(req);
				if(result.status==true) {
					window.location.href = '/backoffice/system/codeManage';
				}
				else{
					alert(result.err_msg);
					blockui_close();
				}
			});
		}else{return;}
	}
}

function toggle(id){
	  var obj = document.getElementById(id);
		if(obj.style.display=='block'){
			obj.style.display = 'none';
		}
		else{
			obj.style.display = 'block';
		}
	}


//배너 추가 버튼 함수
function bannerAdd(){
	
	
	if($('#add_country').val()==''){
		alert("Please input Country.");
		$('#add_country').focus();
		return false;
	}else if($('#add_desc').val()==''){
		alert("Please input Description.");
		$('#add_desc').focus();
		return false;
	}else if($('#add_position').val()==''){
		alert("Please input Position.");
		$('#add_position').focus();
		return false;
	}else if($('#add_link').val()==''){
		alert("Please input Link.");
		$('#add_link').focus();
		return false;
	}else if($('#add_use').val()==''){
		alert("Please input Available.");
		$('#add_use').focus();
		return false;
	}else if($('#add_title').val()==''){
		alert("Please input Title.");
		$('#add_title').focus();
		return false;
	}else if($('#period_from').val()==''){
		alert("Please input From period.");
		$('#period_from').focus();
		return false;
	}else if($('#period_to').val()==''){
		alert("Please input To period.");
		$('#period_to').focus();
		return false;
	}
	
	$.post('/backoffice/system/usableCheck',  {add_country:$('#add_country').val(), add_use:$('#add_use').val(), add_position:$('#add_position').val(), orgin_banner_cd:$('#orgin_banner_cd').val()}, function(req){
		 var result = $.parseJSON(req);
		 if(result.status==='success') {
			 document.addForm.submit();	
		 }else{
			 alert(result.err_msg);
		 }
	   });
	
}

//체크박스 전체선택 / 해제
function checkToggleAll(){
	jQuery(".checkToggle").each(function(){
			var checkFlg = jQuery(this).attr("checked");
		    if( checkFlg == undefined ||
		        checkFlg == false      )
		    {
		      jQuery(this).attr("checked",true);
		    }
		    else
		    {
		      jQuery(this).attr("checked",false);
		    }
	});
}