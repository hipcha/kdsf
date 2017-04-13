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

<div class="clear"></div>
<div style="margin-top:50px;font-size:16px;color:#126490;font-weight:bold;">Reference</div>
<table width="100%" cellpadding="0" cellspacing="0" class="table_4">
	<tr>
		<th style="font-size:14px;background-color:#F6E3CE;width:200px">Category A</th>
		<td>Member of Sa-Rang Community Church (남가주사랑의교회 성도 혹은 성도의 자녀)</td>
    </tr>
	<tr>
		<th style="font-size:14px;background-color:#F6E3CE;">Category B</th>
		<td>Member of Other Churches/Communities (한인 및 타 인종 커뮤니티의 학생)</td>
    </tr>
	<tr>
		<th style="font-size:14px;background-color:#F6E3CE;">Category C</th>
		<td>Child of Missionary in Other Countries (외국에서 선교하는 선교사의 자녀)</td>
    </tr>
	<tr>
		<th style="font-size:14px;background-color:#F6E3CE;">Category D</th>
		<td>Child of Pastor in Non-Self Sufficient Church in U.S.A. (미국 내 미자립교회 목회자 자녀)</td>
    </tr>
	<tr>
		<th style="font-size:14px;background-color:#F6E3CE;">Category E</th>
		<td>Local Theology Student recommended by Missionary (해외 선교지의 선교사가 추천한 현지인 신학생)</td>
    </tr>
	<tr>
		<th style="font-size:14px;background-color:#F6E3CE;">Level</th>
		<td>
			Level F = Freshmen<br/>
			Level U = Undergraduate<br/>
			Level G = Graduate
		</td>
    </tr>
</table>

<div style="margin-top:50px;font-size:16px;color:#126490;font-weight:bold;">Total Applicants : <?=number_format($total['total'])?></div>
<table width="100%" cellpadding="0" cellspacing="0" class="table_4">
	<tr>
		<th style="font-size:14px;background-color:#F6E3CE;width:200px">Category</th>
		<th>Category A</th>
		<td><?=number_format($total['categoryTotal']['A'])?></td>
		<th>Category B</th>
		<td><?=number_format($total['categoryTotal']['B'])?></td>
		<th>Category C</th>
		<td><?=number_format($total['categoryTotal']['C'])?></td>
		<th>Category D</th>
		<td><?=number_format($total['categoryTotal']['D'])?></td>
		<th>Category E</th>
		<td><?=number_format($total['categoryTotal']['E'])?></td>
    </tr>
	<tr>
		<th style="font-size:14px;background-color:#F6E3CE;">Level</th>
		<th>Level F</th>
		<td><?=number_format($total['levelTotal']['F'])?></td>
		<th>Level U</th>
		<td><?=number_format($total['levelTotal']['U'])?></td>
		<th>Level G</th>
		<td><?=number_format($total['levelTotal']['G'])?></td>
		<td colspan=4></td>
    </tr>    
</table>

<div style="margin-top:50px;font-size:16px;color:#126490;font-weight:bold;">By Category</div>
<table width="100%" cellpadding="0" cellspacing="0" class="table_4">
	<tr>
		<th style="font-size:14px;background-color:#F6E3CE;width:200px;">Category A</th>
		<th>Level F</th>
		<td><?=number_format($total['cl']['A']['F'])?></td>
		<th>Level U</th>
		<td><?=number_format($total['cl']['A']['U'])?></td>
		<th>Level G</th>
		<td><?=number_format($total['cl']['A']['G'])?></td>
    </tr>
	<tr>
		<th style="font-size:14px;background-color:#F6E3CE;">Category B</th>
		<th>Level F</th>
		<td><?=number_format($total['cl']['B']['F'])?></td>
		<th>Level U</th>
		<td><?=number_format($total['cl']['B']['U'])?></td>
		<th>Level G</th>
		<td><?=number_format($total['cl']['B']['G'])?></td>
    </tr>
	<tr>
		<th style="font-size:14px;background-color:#F6E3CE;">Category C</th>
		<th>Level F</th>
		<td><?=number_format($total['cl']['C']['F'])?></td>
		<th>Level U</th>
		<td><?=number_format($total['cl']['C']['U'])?></td>
		<th>Level G</th>
		<td><?=number_format($total['cl']['C']['G'])?></td>
    </tr>
	<tr>
		<th style="font-size:14px;background-color:#F6E3CE;">Category D</th>
		<th>Level F</th>
		<td><?=number_format($total['cl']['D']['F'])?></td>
		<th>Level U</th>
		<td><?=number_format($total['cl']['D']['U'])?></td>
		<th>Level G</th>
		<td><?=number_format($total['cl']['D']['G'])?></td>
    </tr>
	<tr>
		<th style="font-size:14px;background-color:#F6E3CE;">Category E</th>
		<th>Level F</th>
		<td><?=number_format($total['cl']['E']['F'])?></td>
		<th>Level U</th>
		<td><?=number_format($total['cl']['E']['U'])?></td>
		<th>Level G</th>
		<td><?=number_format($total['cl']['E']['G'])?></td>
    </tr>
</table>

<div class="clear">&nbsp;</div>
    