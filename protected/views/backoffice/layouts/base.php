<?
# register css and js files for duplication and cache
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($baseUrl."/css/backoffice/main.css?r=2");
$cs->registerCssFile("http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css");
$cs->registerScriptFile($baseUrl."/js/jquery-1.6.1.min.js");
$cs->registerScriptFile($baseUrl."/js/jquery.blockUI.js");
$cs->registerScriptFile($baseUrl."/js/jquery-ui.min.js");
$cs->registerScriptFile($baseUrl."/js/backoffice/menu.js");
$cs->registerScriptFile($baseUrl."/js/common.js");
$cs->registerScriptFile($baseUrl."/js/jquery.cookie.js");

# menu list
$admin = new Admin();
$menu_depth1 = $admin->getMenuList("AND upper_menu_cd=0 AND is_use=1");
foreach($menu_depth1 as $depth1){
	$menu_depth2[$depth1[menu_cd]] = $admin->getMenuList("AND upper_menu_cd='".$depth1[menu_cd]."' AND is_use=1");
	foreach($menu_depth2[$depth1[menu_cd]] as $depth2){
		$menu_depth3[$depth2[menu_cd]] = $admin->getMenuList("AND upper_menu_cd='".$depth2[menu_cd]."' AND is_use=1");
	}
}

# menu authority
$menu_authority = $admin->getMenuAuthority("AND tma.mem_id='".Yii::app()->user->getState("mem_id")."'");
foreach($menu_authority as $data){
	$aAuthorityMenu[] = $data[menu_cd];
}

# current page
$v_sCurrentPage = "/".Yii::app()->request->getPathInfo();

# current menu
$current_menu = $admin->getMenuInfo("AND path='".$v_sCurrentPage."'");
if(!$current_menu){
	# 서브페이지의 경우 path_sub에서 체크
	$current_menu = $admin->getMenuInfo("AND path_sub LIKE '%".$v_sCurrentPage."%'");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo CHtml::encode(Yii::app()->name); ?></title>
</head>

<body>
<header>
  <!-- Start top_wrap -->
  <div class="top_wrapper">
      <div class="top_wrap">
          <a href="/y/backoffice/system/admin"><img src="/y/images/app/logo.png" class="top_logo" style="height:55px;" /></a>
          <div class="title"><?=$current_menu[menu_nm]?></div>
          <div class="right margin_top_10">
              [<?=Yii::app()->user->getState("mem_nm_en")?>]&nbsp;<a href="/y/backoffice/admin/logout">Logout</a>
          </div>
      </div>
  </div>
  <!-- End top_wrap -->
  <div class="clear"></div>
  <!-- Start top_sub_wrap -->
  <div class="top_sub_wrapper">
      <div class="top_sub_wrap">
          <ul class="top_menu text_dark_gray1 nav">
		<?php		
			foreach($menu_depth1 as $i => $depth1){	# depth1 menu
				$depth1_first_cls = $i==0 ? "first" : "";
		?>
              <li class="<?=$depth1_first_cls?>"><a href="#"><b><?=$depth1[menu_nm]?></b></a>
              <input type="hidden" id="first_hd" value="<?=$i?>">
		<?php if($menu_depth2[$depth1[menu_cd]]){?>
				<ul class="2nd" id="scnd_mu_<?=$i?>" style='display:none'>
		<?php		foreach($menu_depth2[$depth1[menu_cd]] as $depth2){	# depth2 menu
						# 메뉴 권한 체크
						$menu_uri = in_array($depth2[menu_cd], $aAuthorityMenu) ? $this->createUrl($depth2[path]) : "#";
						if($menu_uri!="#"){
		?>				
			<?			if($menu_depth3[$depth2[menu_cd]]){?>	 <!-- Depth 3 Menu -->
								<li class="arrow"><a href="<?=$menu_uri?>"><?=$depth2[menu_nm]?></a>
			<?			}else{?>
								<li><a href="<?=$menu_uri?>"><?=$depth2[menu_nm]?></a></li>
			<?			}?>
		<?php 	}?>
		<?php 	if($menu_depth3[$depth2[menu_cd]]){?>
						<ul id="trd_mu_<?=$depth2[menu_cd]?>" style='display:none'>
		<?php			foreach($menu_depth3[$depth2[menu_cd]] as $depth3){
								$sub_menu_uri = in_array($depth3[menu_cd], $aAuthorityMenu) ? $this->createUrl($depth3[path]) : "#";
								if($sub_menu_uri!="#"){
								?>
									<li><a href="<?=$sub_menu_uri?>" class=""><?=$depth3[menu_nm]?></a></li>
				<?php		}?>
			<?php		}?>
						</ul>
		<?php		}?>
		<?if($menu_depth3[$depth2[menu_cd]]){?>	
				</li>
		<?}?>		
		<?php }?>
			</ul>
		<?php
			}
		?>	
			</li>
		<?	
		}
		?>
          </ul>
      </div>
  </div>
  <!-- End top_sub_wrap -->
</header>
<!-- Start main_wrapper -->
<div class="main_wrapper">

	<?php echo $content; ?>

</div><!-- page -->

</body>
</html>
