<script>
function download($path){

}
</script>
	
	<div class="clear"></div>
<style type="text/css">



</style>
    <!-- Start top_wrap -->
	<div class="margin_top_5"></div>
	<table cellpadding="0" cellspacing="0" border="0" width=100% class="table_light_blue text">
		<tr>
	    	<td height="40"><span class="font_18 bold padding_left_20">Notice</span></td>
	    </tr>
	</table>
	<div class="margin_top_5"></div>
<table width="100%" cellpadding="0" cellspacing="0" class="table_2">
<?php
  if(is_array($board_data) && count($board_data) > 0){ 
  foreach($board_data as $data){
  	if($data[warehouse]=='ZZ'){
  		$w_type="[ All Center]";
  		$color='RED';
  	}else{ 
  		$w_type='['.$data[warehouse].']';
  		$color='BLUE';
  	}
  	?>
	<tr  height=36 style="background-color: #f2f5f8;">
		<td>
			<span class="font_18 bold padding_left_20"> &middot; Title : <span style="color:<?=$color?>;"><?=$w_type?></span>&nbsp;&nbsp;<?=$data[title]?></span>
			<div class="right margin_right_10 width3" >&middot; Author : <?=$data[mem_nm_en]?>  &nbsp; &middot;  Notice Period : 
				<?php 
		        	$date = DateTime::createFromFormat('Ymd',$data[start_date] );
		        	echo $date->format('Y-m-d');
	        	?> ~ <?php 
		        	$date = DateTime::createFromFormat('Ymd',$data[end_date] );
			        echo $date->format('Y-m-d');
		        ?>
		        </div>
		</td>
	</tr>
	
	
	<tr>
		<td colspan=2>
						<span class="font_18 bold padding_left_20"> &middot; Attached File : <?php
									if(is_array($attached_data) && count($attached_data) > 0){
										foreach($attached_data as $a_data){
											if($a_data[actual_seq]==$data[seq]){?>
												<a href="/backoffice/system/fileDownload?path=<?=urlencode($a_data[path])?>" target="_blank"><?=$a_data[file_nm]?></a>, &nbsp;&nbsp;
												
												<?php  
											}
										}
									}
									?>
						</span>
			<div style="margin-left: 40px; margin-right: 40px">
					<?=$data[content]?>	
			</div>
		</td>
	</tr>
	<?}
 }?>
</table>
    <!-- end menu -->
