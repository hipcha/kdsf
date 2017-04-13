/**
 * 공통 자바스크립트 함수 모음
 */

// ajax실행시, 클릭못하게 하기 위해 화면을 block시키는 함수
function blockui_open(){
	$.blockUI({
	    // message displayed when blocking (use null for no message) 
	    message:  '<h1>Please wait...</h1>',
	    
		css: { 
			border: 'none', 
			padding: '15px', 
			backgroundColor: '#000', 
			'-webkit-border-radius': '10px', 
			'-moz-border-radius': '10px', 
			opacity: .5, 
			color: '#fff' 
		},
	});
}

// block 함수를 닫기
function blockui_close(){
	setTimeout($.unblockUI, 700);
}

// 팝업 가운데로 띄우기
function showPopWindow(pURL,pWidth,pHeight){
	var LeftPosition = (screen.width) ? (screen.width-pWidth)/2 : 0;
	var TopPosition  = (screen.height) ? (screen.height-pHeight)/2 : 0;
	var wLogin = window.open(pURL,'wLogin','width='+pWidth+',height='+pHeight+',left='+LeftPosition+',top='+TopPosition+'');
	wLogin.focus();
}

// 체크박스 전체 선택/해제
function checkall(frm){
	var i=0;
	var chkbox = frm['checkItem[]'];
	
	if(chkbox.length){
	
	}else{
		if(frm.allCheck.checked){
			chkbox.checked=true;
		}else{
			chkbox.checked=false;
		}
	}
	
	if(chkbox.length > 1){
		for(i=0; i<chkbox.length; i++){
			if(frm.allCheck.checked){
				chkbox[i].checked=true;
			}else{
				chkbox[i].checked=false;
			}
		}
	}
}

//체크박스 전체 선택/해제
//20150316 jmlee 추가
function checkall2(frm, checkName){
	var i=0;
	//var chkbox = frm['checkItem[]'];
	var chkbox = document.getElementsByName(checkName);
    var allCheck = document.getElementsByName("allCheck");
	
	if(allCheck.value=="1"){
		allCheck.value="0";
	}else{
		allCheck.value="1";
	}
	
	if(chkbox.length){
	
	}else{
		if(allCheck.value=="1"){
			chkbox.checked=true;
		}else{
			chkbox.checked=false;
		}
	}
	
	if(chkbox.length >= 1){
		for(i=0; i<chkbox.length; i++){
			if(allCheck.value=="1"){
				chkbox[i].checked=true;
			}else{
				chkbox[i].checked=false;
			}
		}
	}
}

// email check
function validateEmail(email){
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}


function invalidAlphaNum(str){
	var re = /[^a-zA-Z0-9]/gi;
	return re.test(str);
}

function invalidAlphaNumBlank(str){
	var re = /[^a-zA-Z0-9 ]/gi;
	return re.test(str);
}

function invalidNum(str){
	var re = /[^0-9 ]/gi;
	return re.test(str);
}

function invalidAlphaNumDash(str){
	var re = /[^a-zA-Z0-9-]/gi;
	return re.test(str);
}

//기본 화폐기호 정의
function setCurrencySymbol(warehouse_cd){
	var warehouse_cd;
	$.post('/common/getCurrencySymbol', {warehouse_cd:warehouse_cd}, function(currency_symbol){
		$(".currency_symbol").each(function(){
			$(this).html(currency_symbol);
		});
	});
}

function informUnderConstruction(e) {
	
	alert('The Menu is under construction.');
	
	//$(this).get(0).location.reload(true);
	
}
/*
 * Check Null Validation.
 * Parameter : AddForm
 * return : null
 * desc : 
 * 		1. attribute 값 중, chkNull 이 true 인 값을 가져와 체크한다.
 * 		2. 값이 없을 시에는 false를 리턴하고 focus 를 준다.
 */

function chkNullValidate(objAddForm) {

	var objName = objAddForm.selector;
	// 이미 다른 타입에서 오류가 날 경우, 하단 로직은 빠져나오게 한다.
	var rtnValue = true;

	// 1. text	일 경우.
	$("#"+objName+" input[type$='text']").each(
		function(key, obj){

			if(obj.getAttribute('chkNull')) {

				var chkNullDesc = obj.getAttribute('chkNullDesc');
								
				if(obj.value.trim() === "") {
					
					if(chkNullDesc.length > 0)
						alert('Please Check '+chkNullDesc+' information.');
					else 
						alert('Please Check Mandatory information.');
					
					obj.focus();
					rtnValue = false;
					return false;
				}
			}
		}
	)

	// 2. select 일 경우.
	if(rtnValue) {
		$("#"+objName+" select").each(
			function(key, obj){
	
				if(obj.getAttribute('chkNull')) {
	
					var chkNullDesc = obj.getAttribute('chkNullDesc');
									
					if(obj.value.trim() === "") {
						
						if(chkNullDesc.length > 0)
							alert('Please Check '+chkNullDesc+' information.');
						else 
							alert('Please Check Mandatory information.');
						
						obj.focus();
						rtnValue = false;
						return false;
					}
				}
			}
		)
	}
	
	return rtnValue;
}

// 천단위 쉼표추가 함수
function numberFormat(decimals, dec_point, thousands_sep,number_str) {
	decimals = Math.abs(decimals) + 1 ? decimals : 2;
	dec_point = dec_point || '.';
	thousands_sep = thousands_sep || ',';
	
	var matches = /(-)?(\d+)(\.\d+)?/.exec((isNaN(number_str) ? 0 : number_str) + ''); // returns matches[1] as sign, matches[2] as numbers and matches[3] as decimals
	var remainder = matches[2].length > 3 ? matches[2].length % 3 : 0;
	
	return (matches[1] ? matches[1] : '') + (remainder ? matches[2].substr(0, remainder) + thousands_sep : '') + matches[2].substr(remainder).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep) + 
	(decimals ? dec_point + (+matches[3] || 0).toFixed(decimals).substr(2) : '');
}

// 반올림
function roundXL(n, digits) {
	if (digits >= 0) return parseFloat(n.toFixed(digits)); // 소수부 반올림

	digits = Math.pow(10, digits); // 정수부 반올림
	var t = Math.round(n * digits) / digits;

	return parseFloat(t.toFixed(0));
}

function base64_decode(data) {
  //  discuss at: http://phpjs.org/functions/base64_decode/
  // original by: Tyler Akins (http://rumkin.com)
  // improved by: Thunder.m
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //    input by: Aman Gupta
  //    input by: Brett Zamir (http://brett-zamir.me)
  // bugfixed by: Onno Marsman
  // bugfixed by: Pellentesque Malesuada
  // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //   example 1: base64_decode('S2V2aW4gdmFuIFpvbm5ldmVsZA==');
  //   returns 1: 'Kevin van Zonneveld'
  //   example 2: base64_decode('YQ===');
  //   returns 2: 'a'

  var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
  var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
    ac = 0,
    dec = '',
    tmp_arr = [];

  if (!data) {
    return data;
  }

  data += '';

  do { // unpack four hexets into three octets using index points in b64
    h1 = b64.indexOf(data.charAt(i++));
    h2 = b64.indexOf(data.charAt(i++));
    h3 = b64.indexOf(data.charAt(i++));
    h4 = b64.indexOf(data.charAt(i++));

    bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;

    o1 = bits >> 16 & 0xff;
    o2 = bits >> 8 & 0xff;
    o3 = bits & 0xff;

    if (h3 == 64) {
      tmp_arr[ac++] = String.fromCharCode(o1);
    } else if (h4 == 64) {
      tmp_arr[ac++] = String.fromCharCode(o1, o2);
    } else {
      tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
    }
  } while (i < data.length);

  dec = tmp_arr.join('');

  return dec.replace(/\0+$/, '');
}

function urldecode(str) {
  //       discuss at: http://phpjs.org/functions/urldecode/
  //      original by: Philip Peterson
  //      improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //      improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //      improved by: Brett Zamir (http://brett-zamir.me)
  //      improved by: Lars Fischer
  //      improved by: Orlando
  //      improved by: Brett Zamir (http://brett-zamir.me)
  //      improved by: Brett Zamir (http://brett-zamir.me)
  //         input by: AJ
  //         input by: travc
  //         input by: Brett Zamir (http://brett-zamir.me)
  //         input by: Ratheous
  //         input by: e-mike
  //         input by: lovio
  //      bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //      bugfixed by: Rob
  // reimplemented by: Brett Zamir (http://brett-zamir.me)
  //             note: info on what encoding functions to use from: http://xkr.us/articles/javascript/encode-compare/
  //             note: Please be aware that this function expects to decode from UTF-8 encoded strings, as found on
  //             note: pages served as UTF-8
  //        example 1: urldecode('Kevin+van+Zonneveld%21');
  //        returns 1: 'Kevin van Zonneveld!'
  //        example 2: urldecode('http%3A%2F%2Fkevin.vanzonneveld.net%2F');
  //        returns 2: 'http://kevin.vanzonneveld.net/'
  //        example 3: urldecode('http%3A%2F%2Fwww.google.nl%2Fsearch%3Fq%3Dphp.js%26ie%3Dutf-8%26oe%3Dutf-8%26aq%3Dt%26rls%3Dcom.ubuntu%3Aen-US%3Aunofficial%26client%3Dfirefox-a');
  //        returns 3: 'http://www.google.nl/search?q=php.js&ie=utf-8&oe=utf-8&aq=t&rls=com.ubuntu:en-US:unofficial&client=firefox-a'
  //        example 4: urldecode('%E5%A5%BD%3_4');
  //        returns 4: '\u597d%3_4'

  return decodeURIComponent((str + '')
    .replace(/%(?![\da-f]{2})/gi, function() {
      // PHP tolerates poorly formed escape sequences
      return '%25';
    })
    .replace(/\+/g, '%20'));
}

function escape_decode(string) {
	return urldecode(base64_decode(string));
}

/*
 * lPad 함수.
 * param : n -> 변경 하고자 하는 숫자.
 * 		   width -> 원하는 길이.
 *         z -> 좌측에 채우고자 하는 숫자.
 */
function lpad(n, width, z) {
	  z = z || '0';
	  n = n + '';
	  return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}

// 금액 포맷 setting.
function setCurrencyFormat(){
	$(".currency_format").each(function(){
		var param = parseFloat($(this).html());
		
		$(this).html(numberFormat(2, ".", ",",roundXL(param, 2)));
	});
}

function scrollToTarget(targetID) {
	var target = $("#"+targetID);
	if(target != undefined) {
		var pos = target.offset().top;
		$("html, body").animate({scrollTop:pos},'slow');
	}
}

// 한글 체크
function koreanCheck(str){
	var result = str.match(/[ㄱ-ㅎ가-힣ㅏ-ㅣ]/g);
	
	if(result==null){
		return true;
	}
	
	return false;
}

// show help popup
function showHelp(type, obj_id){
	$(".help_popup_content").hide();
	$("#content_"+type).show();
	$("#help_order_popup").show();
	
	var main_height = $("#help_order_popup")[0].scrollHeight;
	var obj_pos_top = $("#"+obj_id).position();
	var new_top = 0;
	var height_pos_correction = 0;
	
	if(type==3 || type==5 || type==1007 || type==1019) top_margin = 530;
	else if(type==4) top_margin = 550;
	else if(type==12 ) top_margin = -147;
	else if(type==13) top_margin = -44;
	else if(type==14) top_margin = -260;
	else if(type==15) top_margin = -180;
	else if(type==20 || type==21 || type==22 || type==23 || type==24 || type==25) top_margin = 350;
	else if(type==1013 || type==1014) top_margin=280;
	else if(type==1004 || type==1005 || type==9999) top_margin = 280;
	else if(type==1006 ) top_margin = 300;
	else if(type==1015) top_margin=650;
	else if(type==1016) top_margin=500;
	else if(type==1008) top_margin=100;
	else if(type==26 || type==27 || type==28 || type==29){	// 통관품목 건강기능식품 선택시 / 상품명에 Ear Thermometer가 포함 / 단일 고정가 선택시
		top_margin = 200;
		
		// get position after appended element
		aStr1 = obj_id.split('__');
		aStr2 = aStr1[1].split('_');
		obj_pos_top.top = $('#seq_tracking_'+aStr2[0]).position().top + $('#'+obj_id).position().top;
	}
	else top_margin = 200;
	
	new_top = obj_pos_top.top - main_height + height_pos_correction + top_margin;
	
	
	/*팝업창 세로 정렬*/
	$("#help_order_popup").css('top',new_top+'px');
	
	/*팝업창 가로 가운데 정렬*/
    var pop_left = ($(window).width()) - 1140;
    if(pop_left < 0)
    	pop_left = 10;
    else
    	pop_left = pop_left / 2;
    $("#help_order_popup").css('left',pop_left+'px');
	
    
	$(".img_more_info").attr("src","http://118.217.181.6/ohmyzip/layer_popup/more_info.png");
	$("#"+obj_id).attr("src","http://118.217.181.6/ohmyzip/layer_popup/more_info_on.png");
}

// close help popup
function closeHelp(){
	$("#help_order_popup").hide();
	
	$(".img_more_info").attr("src","http://118.217.181.6/ohmyzip/layer_popup/more_info.png");
}

// 상단 배송신청내역 노출 여부
function showAppStatus(){
	if($('#top_status_1').is(':visible')==false){
		//$('#sh_btn').attr('src', '/images/help/btn_close.png');
		$.post('/common/translate', {category:'account',text:'/images/help/btn_close_em.png'}, function(msg){
			$('#sh_btn').attr('src', msg);
		});
		$('[id^="top_status_"]').fadeIn('slow');
		$("#blank").css('margin-bottom','0px');
	}
	else{
		//$('#sh_btn').attr('src', '/images/help/btn_open.png');
		$.post('/common/translate', {category:'account',text:'/images/help/btn_open_em.png'}, function(msg){
			$('#sh_btn').attr('src', msg);
		});
		$('[id^="top_status_"]').fadeOut('slow');
		$("#blank").css('margin-bottom','20px');
	}
}

// 포인트 팝업같은 경우는 다른 showHelp 와다름
function showHelpWithoutQues(type, obj_id){
	$(".help_popup_content").hide();
	$("#content_"+type).show();
	$("#help_order_popup").show();
	
	var main_height = $("#help_order_popup")[0].scrollHeight;
	var obj_pos_top = $("#"+obj_id).position();
	var new_top = 0;
	var height_pos_correction = 0;
	
	top_margin = 200;
	
	new_top = obj_pos_top.top - main_height + height_pos_correction + top_margin;
	
	/*팝업창 세로 정렬*/
	$("#help_order_popup").css('top',new_top+'px');
	
	/*팝업창 가로 가운데 정렬*/
    var pop_left = ($(window).width()) - 1140;
    if(pop_left < 0)
    	pop_left = 10;
    else
    	pop_left = pop_left / 2;
    $("#help_order_popup").css('left',pop_left+'px');
}

//close Cloase popup (포인트 팝업같은 경우는 다른 showHelp 와다름)
function closeHelpWithoutQues(){
	$("#help_order_popup").hide();
}

//close help popup (포인트 팝업같은 경우는 다른 showHelp 와다름)
function moveLink(link){
	$("#help_order_popup").hide();
	
	var link;
	window.location.href=link;
}