<?
# register css and js files for duplication and cache
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl."/js/backoffice/admin.js");
?>
<script>
	function search(){
		if($('#searchValue').val()==''){
			alert('Please enter a value to search.');
			$('#searchValue').focus();
			return false;
		}
		
		var f = document.searchForm;
		f.action = '/y/backoffice/admin/memberList';
		f.submit();
	}
</script>

<!-- End top_wrap -->
<div class="clear"></div>

<!-- start -->
<div class="margin_top_5"> </div>
<form name="searchForm" id="searchForm" method="get">
	<input type="hidden" name="mem_id" id="mem_id" value="<?=$mem_id?>" />
    <table cellpadding="0" cellspacing="0" border="0"  width="100%" class="table_light_blue text">
	    <tr>
	    	<td align="left">
	    		<select id="searchType" name="searchType" style="width:auto;">
				<option value="email" <?=$searchType=="email" ? "selected" : ""?>>Email
				<option value="name" <?=$searchType=="name" ? "selected" : ""?>>Name
				<option value="tel_no" <?=$searchType=="tel_no" ? "selected" : ""?>>Telephone
			</select>&nbsp;&nbsp;
		    <input type="text" name="searchValue" id="searchValue" value="<?=$searchValue?>" autofocus="autofocus" class="form_text_box width110" onKeyDown='javascript:if(event.keyCode==13){search();}'>
			&nbsp;&nbsp;&nbsp;&nbsp;	    		
			<button type="button" class="btn_blue" onclick="search();">search</button>				
			</td>	    
		</tr>
    </table>
</form>

<div class="margin_top_20"></div>

<table width="100%" cellpadding="0" cellspacing="0" class="table_2">
	<tr height=36>
		<th>No</th>
		<th>Category</th>
		<th>Level</th>
		<th>Email</th>
		<th>Name</th>
		<th>DOB</th>
		<th>Telephone</th>
		<th>Application Code</th>
		<th>Register Date</th>
    </tr>
	<?php foreach($memberList as $i => $row){?>
	<tr align="center">
		<td><?=$i+1?></td>
		<td><?=$row['mem_ctg']?></td>
		<td><?=$row['mem_level']?></td>
		<td><?=$row['email']?></td>
		<td><?=$row['first_nm']." ".$row['last_nm']?></td>
		<td><?=$row['dob']?></td>
		<td><?=$row['tel_no']?></td>
		<td><?=$row['app_cd']?></td>
		<td><?=$row['ins_dtime']?></td>
	</tr>
	<?php }?>
</table>
     
<div class="clear">&nbsp;</div>
    