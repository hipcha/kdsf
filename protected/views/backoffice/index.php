<?
# register css and js files for duplication and cache
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($baseUrl."/css/backoffice/main.css");
$cs->registerScriptFile($baseUrl."/js/jquery-1.6.1.min.js");
$cs->registerScriptFile($baseUrl."/js/backoffice/admin.js");

# 이전에 로그인했던 warehouse를 cookie로 저장했다가 다시 로그인할 때, 셋팅해 줌.
$wh_before = Yii::app()->request->cookies->contains('login_warehouse') ? Yii::app()->request->cookies['login_warehouse']->value : '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo CHtml::encode(Yii::app()->name); ?></title>
	<script>
		$(function(){
			$('#email').focus();
		});
	</script>
</head>
<body>
<!-- Start main_wrapper -->
<div class="main_wrapper">
	<!-- Start mid_wrap -->
	<div class="main_wrap">
		<!-- start login_wrapper -->
		<div class="register_wrapper1">
		<form name='page_login' method='post' id='form_login'>
	        <table width="480"  cellpadding=0  bgcolor=#ffffff>
	        <tr>
	        <td class="padding_bottom_20"><img src="/y/images/logo.jpg" /></td>
	        </tr>
	        <tr>
	        	<td align="left" class="border_dark_blue_top bg_grey1 padding_top_20 padding_bottom_15 border_dark_blue_bottom">
		          <table width="100%" cellpadding="0" cellspacing="0" border="0">
		          <tr>
			          <td width="98" class="login_form_title">E-mail</td>
			          <td width="180" valign="top">
			          	<input type="text" name="email" id="email" class="form_text_box width170" tabindex="1" />
			          </td>
			          <td rowspan="2">
			          	<img src="/y/images/btn_login.gif" onclick="checkLoginForm();" class="padding_left_10" style="cursor:pointer;" />
			          </td>
		          </tr>
		          <tr>
			          <td class="login_form_title">Password</td>
			          <td valign="bottom"><input type="password" name="pwd" id="pwd" class="form_text_box width170" tabindex="2" onkeydown="if(event.keyCode==13){checkLoginForm();}" /></td>
		          </tr>
		          </table>
	       		</td>
	        </tr>
	        </table>
	      </form>
      </div>
      <!-- start login_wrapper end-->
  </div>
  <br class="clear">
</div>
<!-- Start main_wrapper end -->


</body>
</html>
