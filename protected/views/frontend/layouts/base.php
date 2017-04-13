<?
# for js refresh
$setup = new BasicSetup();
$constants = $setup->getConstants();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>KDSF</title>
	<style type="text/css">
	body {
		margin-left: 0px;
		margin-top: 0px;
		margin-right: 0px;
		margin-bottom: 0px;
	}
	.red {
		color: #F00;
	}
	.text {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
		font-style: normal;
		line-height: normal;
	}
	</style>
	<script type="text/javascript" src="/y/js/common.js"></script>
	<script type="text/javascript" src="/y/js/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="/y/js/jquery.blockUI.js"></script>
	<script type="text/javascript" src="/y/js/jquery.cookie.js"></script>
</head>

<body>
	<?php echo $content; ?>
</body>
</html>
