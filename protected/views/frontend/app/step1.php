<?php 
# for js refresh
$setup = new BasicSetup();
$constants = $setup->getConstants();

$is_modify = $memInfo[mem_id]=="" ? "N" : "Y";
?>
<script type="text/javascript" src="/y/js/application.js?cache_num=<?=$constants[js_refresh_num]?>"></script>
<form name="appForm" id="appForm" method="post" enctype="multipart/form-data">
<input type="hidden" id="is_check_email" value="<?=$is_modify?>" />
<input type="hidden" id="is_modify" value="<?=$is_modify?>" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="120" align="center" bgcolor="#2a3037"><table width="1000" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><a href="/"><img src="/y/images/app/logo.png" width="199" height="80" border="0" /></a></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="1000" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="50"></p></td>
      </tr>
      <tr>
        <td height="50" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><?php if($is_modify=="N"){?><img src="/y/images/app/text_top01.png" width="346" height="29" /><?php }?></td>
            <td align="right"><img src="/y/images/app/step01.png" width="314" height="12" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="80%" border="0" cellpadding="3" cellspacing="3" class="text">
          <tr>
            <td height="30" colspan="2" align="left" bgcolor="#CCCCCC"><strong><img src="/y/images/app/blank.png" width="20" height="10" />EMAIL AND PASSWORD</strong></td>
            </tr>
          <tr>
            <td width="250" align="right">E-mail <span class="red">*</span></td>
            <td><input type="text" name="app[email]" id="email" value="<?=$memInfo[email]?>" <?php if($is_modify=="Y"){?>readonly<?php }?> />
              <?php if($is_modify=="N"){?><input type="button" name="button2" id="available" value="Check Availability" onclick="checkEmail();" /><?php }?>
              <span class="cls_err_msg" id="err__email" style="padding-left:10px;color:red;"></span>
            </td>
          </tr>
          <tr>
            <td width="250" align="right">Password :<span class="red">*</span></td>
            <td>
            	<input type="password" name="app[pwd]" id="pwd1" placeholder="Use at least 8 characters." />
              	<span class="cls_err_msg" id="err__pwd1" style="padding-left:10px;color:red;"></span>
            </td>
          </tr>
          </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="80%" border="0" cellpadding="3" cellspacing="3" class="text">
          <tr>
            <td height="30" colspan="2" align="left" bgcolor="#CCCCCC"><strong><img src="/y/images/app/blank.png" width="20" height="10" />Applicant Information</strong></td>
          </tr>
          <tr>
            <td width="250" align="right">Gender <span class="red">*</span></td>
            <td>
            	<select name="app[gender]" id="gender">
              		<option value="">Select a Gender</option>
              		<option value="M" <?php if($memInfo[gender]=="M"){?>selected<?php }?>>Male</option>
              		<option value="F" <?php if($memInfo[gender]=="F"){?>selected<?php }?>>Female</option>
            	</select>
              	<span class="cls_err_msg" id="err__gender" style="padding-left:10px;color:red;"></span>
            </td>
          </tr>
          <tr>
            <td width="250" align="right">User Name <span class="red">*</span></td>
            <td>
            	<input type="text" name="app[first_nm]" id="first_nm" placeholder="First" value="<?=$memInfo[first_nm]?>" />
            	<input type="text" name="app[last_nm]" id="last_nm" placeholder="Last" value="<?=$memInfo[last_nm]?>" />
              	<span class="cls_err_msg" id="err__user_nm" style="padding-left:10px;color:red;"></span>
            </td>
          </tr>
          <tr>
            <td width="250" align="right">Alternative Name</td>
            <td><input type="text" name="app[alter_nm]" id="alter_nm" value="<?=$memInfo[alter_nm]?>" />
              * if you have another name as an second language </td>
          </tr>
          <tr>
            <td width="250" align="right">Preferred Language <span class="red">*</span></td>
            <td>
            	<select name="app[lang_cd]" id="lang_cd">
              		<option value="ko" <?php if($memInfo[lang_cd]=="ko"){?>selected<?php }?>>Korean</option>
              		<option value="en" <?php if($memInfo[lang_cd]=="en"){?>selected<?php }?>>English</option>
            	</select>
            </td>
          </tr>
          <tr>
            <td width="250" align="right">Date of Birth <span class="red">*</span></td>
            <td>
            	<select name="dob_m" id="dob_m">
					<option value="01" <?php if(substr($memInfo[dob],0,2)=="01"){?>selected<?php }?>>January</option>
					<option value="02" <?php if(substr($memInfo[dob],0,2)=="02"){?>selected<?php }?>>February</option>
					<option value="03" <?php if(substr($memInfo[dob],0,2)=="03"){?>selected<?php }?>>March</option>
					<option value="04" <?php if(substr($memInfo[dob],0,2)=="04"){?>selected<?php }?>>April</option>
					<option value="05" <?php if(substr($memInfo[dob],0,2)=="05"){?>selected<?php }?>>May</option>
					<option value="06" <?php if(substr($memInfo[dob],0,2)=="06"){?>selected<?php }?>>June</option>
					<option value="07" <?php if(substr($memInfo[dob],0,2)=="07"){?>selected<?php }?>>July</option>
					<option value="08" <?php if(substr($memInfo[dob],0,2)=="08"){?>selected<?php }?>>August</option>
					<option value="09" <?php if(substr($memInfo[dob],0,2)=="09"){?>selected<?php }?>>September</option>
					<option value="10" <?php if(substr($memInfo[dob],0,2)=="10"){?>selected<?php }?>>October</option>
					<option value="11" <?php if(substr($memInfo[dob],0,2)=="11"){?>selected<?php }?>>November</option>
					<option value="12" <?php if(substr($memInfo[dob],0,2)=="12"){?>selected<?php }?>>December</option>
            	</select>
            	<select name="dob_d" id="dob_d">
            	<?php for($i=1 ; $i<=31; $i++){?>
					<option value="<?=sprintf('%02d',$i)?>" <?php if(substr($memInfo[dob],2,2)==sprintf('%02d',$i)){?>selected<?php }?>><?=$i?></option>
				<?php }?>
            	</select>
              	<input name="dob_y" type="text" id="dob_y" size="5" placeholder="Year" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="4" value="<?=substr($memInfo[dob],4)?>" />
              	<span class="cls_err_msg" id="err__dob" style="padding-left:10px;color:red;"></span>
            </td>
          </tr>
          <tr>
            <td width="250" align="right">Marital Status <span class="red">*</span></td>
            <td>
            	<select name="app[marital]" id="marital">
              		<option value="">Choose your martial status</option>
              		<option value="M" <?php if($memInfo[marital]=="M"){?>selected<?php }?>>Married</option>
              		<option value="S" <?php if($memInfo[marital]=="S"){?>selected<?php }?>>Single</option>
              		<option value="D" <?php if($memInfo[marital]=="D"){?>selected<?php }?>>Divorced</option>
              		<option value="W" <?php if($memInfo[marital]=="W"){?>selected<?php }?>>Widowed</option>
            	</select>
              	<span class="cls_err_msg" id="err__marital" style="padding-left:10px;color:red;"></span>
            </td>
          </tr>
          <tr>
            <td width="250" align="right">Have you ever been granted KDSF scholarship? <span class="red">*</span></td>
            <td>
            	<select name="app[scholarship]" id="scholarship">
              		<option value="">=====</option>
              		<option value="Y" <?php if($memInfo[scholarship]=="Y"){?>selected<?php }?>>Yes</option>
              		<option value="N" <?php if($memInfo[scholarship]=="N"){?>selected<?php }?>>No</option>
            	</select>
              	<span class="cls_err_msg" id="err__scholarship" style="padding-left:10px;color:red;"></span>
            </td>
          </tr>
          <tr>
            <td width="250" align="right">Do you have any disabilities? <span class="red">*</span></td>
            <td>
            	<select name="app[disability]" id="disability" onchange="checkDisability(this.value);">
              		<option value="">=====</option>
              		<option value="Y" <?php if($memInfo[disability]=="Y"){?>selected<?php }?>>Yes</option>
              		<option value="N" <?php if($memInfo[disability]=="N"){?>selected<?php }?>>No</option>
            	</select>
              	<span class="cls_err_msg" id="err__scholarship" style="padding-left:10px;color:red;"></span>
              	<div id="id_disability_detail" style="display:none;">
              		What type of disability? <span class="red">*</span> <input name="app[disability_detail]" type="text" id="disability_detail" size="25" value="<?=$memInfo[disability_detail]?>" />
              		<span class="cls_err_msg" id="err__disability_detail" style="padding-left:10px;color:red;"></span>
              	</div>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="80%" border="0" cellpadding="3" cellspacing="3" class="text">
          <tr>
            <td height="30" colspan="2" align="left" bgcolor="#CCCCCC"><strong><img src="/y/images/app/blank.png" width="20" height="10" />IN CASE YOU FORGET YOUR USER ID OR PASSWORD</strong></td>
          </tr>
          <tr>
            <td width="250" align="right">Security Question <span class="red">*</span></td>
            <td>
            	<select name="app[security_q]" id="security_q" style="width:300px;">
              		<option value="">Please select a question</option>
					<option value="1" <?php if($memInfo[security_q]=="1"){?>selected<?php }?>>What was your childhood nickname?</option>
					<option value="2" <?php if($memInfo[security_q]=="2"){?>selected<?php }?>>What is the name of your favorite childhood friend?</option>
					<option value="3" <?php if($memInfo[security_q]=="3"){?>selected<?php }?>>In what city or town did your mother and father meet?</option>
					<option value="4" <?php if($memInfo[security_q]=="4"){?>selected<?php }?>>What is the middle name of your oldest child?</option>
					<option value="5" <?php if($memInfo[security_q]=="5"){?>selected<?php }?>>What is your favorite team?</option>
					<option value="6" <?php if($memInfo[security_q]=="6"){?>selected<?php }?>>What is your favorite movie?</option>
					<option value="7" <?php if($memInfo[security_q]=="7"){?>selected<?php }?>>What was your favorite sport in high school?</option>
					<option value="8" <?php if($memInfo[security_q]=="8"){?>selected<?php }?>>What was your favorite food as a child?</option>
					<option value="9" <?php if($memInfo[security_q]=="9"){?>selected<?php }?>>What is the first name of the boy or girl that you first kissed?</option>
					<option value="10" <?php if($memInfo[security_q]=="10"){?>selected<?php }?>>What was the make and model of your first car?</option>
					<option value="11" <?php if($memInfo[security_q]=="11"){?>selected<?php }?>>What was the name of the hospital where you were born?</option>
					<option value="12" <?php if($memInfo[security_q]=="12"){?>selected<?php }?>>Who is your childhood sports hero?</option>
					<option value="13" <?php if($memInfo[security_q]=="13"){?>selected<?php }?>>What school did you attend for sixth grade?</option>
					<option value="14" <?php if($memInfo[security_q]=="14"){?>selected<?php }?>>What was the last name of your third grade teacher?</option>
					<option value="15" <?php if($memInfo[security_q]=="15"){?>selected<?php }?>>In what town was your first job?</option>
					<option value="16" <?php if($memInfo[security_q]=="16"){?>selected<?php }?>>What was the name of the company where you had your first job?</option>
            	</select>
              	<span class="cls_err_msg" id="err__security_q" style="padding-left:10px;color:red;"></span>
            </td>
          </tr>
          <tr>
            <td width="250" align="right">Your Answer <span class="red">*</span></td>
            <td>
            	<input name="app[security_a]" type="text" id="security_a" style="width:300px;" value="<?=$memInfo[security_a]?>" />
              	<span class="cls_err_msg" id="err__security_a" style="padding-left:10px;color:red;"></span>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="80%" border="0" cellpadding="3" cellspacing="3" class="text">
          <tr>
            <td height="30" colspan="2" align="left" bgcolor="#CCCCCC"><strong><img src="/y/images/app/blank.png" width="20" height="10" />SELECT PHONE AND ADDRESS </strong></td>
          </tr>
          <tr>
            <td width="250" align="right">Mobile Phone<span class="red"> *</span></td>
            <td>
            	<input name="app[tel_no]" type="text" id="tel_no" size="30" value="<?=$memInfo[tel_no]?>" />
              	<span class="cls_err_msg" id="err__tel_no" style="padding-left:10px;color:red;"></span>
            </td>
          </tr>
          <tr>
            <td width="250" align="right">Address 1 <span class="red">*</span></td>
            <td>
            	<input name="app[addr1]" type="text" id="addr1" size="50" value="<?=$memInfo[addr1]?>" />
              	<span class="cls_err_msg" id="err__addr1" style="padding-left:10px;color:red;"></span>
            </td>
          </tr>
          <tr>
            <td width="250" align="right">Address 2</td>
            <td><input name="app[addr2]" type="text" id="addr2" size="50" value="<?=$memInfo[addr2]?>" /></td>
          </tr>
          <tr>
            <td width="250" align="right">City <span class="red">*</span></td>
            <td>
            	<input name="app[city]" type="text" id="city" size="30" value="<?=$memInfo[city]?>" />
              	<span class="cls_err_msg" id="err__city" style="padding-left:10px;color:red;"></span>
            </td>
          </tr>
          <tr>
            <td width="250" align="right">State <span class="red">*</span></td>
            <td>
            	<select name="app[state]" id="state">
					<option value="AK" <?php if($memInfo[state]=="AK"){?>selected<?php }?>>Alaska</option>
					<option value="AL" <?php if($memInfo[state]=="AL"){?>selected<?php }?>>Alabama</option>
					<option value="AS" <?php if($memInfo[state]=="AS"){?>selected<?php }?>>American Samoa</option>
					<option value="AZ" <?php if($memInfo[state]=="AZ"){?>selected<?php }?>>Arizona</option>
					<option value="AR" <?php if($memInfo[state]=="AR"){?>selected<?php }?>>Arkansas</option>
					<option value="CA" <?php if($memInfo[state]=="CA" || $memInfo[state]==""){?>selected<?php }?> selected>California</option>
					<option value="CO" <?php if($memInfo[state]=="CO"){?>selected<?php }?>>Colorado</option>
					<option value="CT" <?php if($memInfo[state]=="CT"){?>selected<?php }?>>Connecticut</option>
					<option value="DE" <?php if($memInfo[state]=="DE"){?>selected<?php }?>>Delaware</option>
					<option value="DC" <?php if($memInfo[state]=="DC"){?>selected<?php }?>>District of Columbia</option>
					<option value="FM" <?php if($memInfo[state]=="FM"){?>selected<?php }?>>Federated States of Micronesia</option>
					<option value="FL" <?php if($memInfo[state]=="FL"){?>selected<?php }?>>Florida</option>
					<option value="GA" <?php if($memInfo[state]=="GA"){?>selected<?php }?>>Georgia</option>
					<option value="GU" <?php if($memInfo[state]=="GU"){?>selected<?php }?>>Guam</option>
					<option value="HI" <?php if($memInfo[state]=="HI"){?>selected<?php }?>>Hawaii</option>
					<option value="ID" <?php if($memInfo[state]=="ID"){?>selected<?php }?>>Idaho</option>
					<option value="IL" <?php if($memInfo[state]=="IL"){?>selected<?php }?>>Illinois</option>
					<option value="IN" <?php if($memInfo[state]=="IN"){?>selected<?php }?>>Indiana</option>
					<option value="IA" <?php if($memInfo[state]=="IA"){?>selected<?php }?>>Iowa</option>
					<option value="KS" <?php if($memInfo[state]=="KS"){?>selected<?php }?>>Kansas</option>
					<option value="KY" <?php if($memInfo[state]=="KY"){?>selected<?php }?>>Kentucky</option>
					<option value="LA" <?php if($memInfo[state]=="LA"){?>selected<?php }?>>Louisiana</option>
					<option value="ME" <?php if($memInfo[state]=="ME"){?>selected<?php }?>>Maine</option>
					<option value="MH" <?php if($memInfo[state]=="MH"){?>selected<?php }?>>Marshall Islands</option>
					<option value="MD" <?php if($memInfo[state]=="MD"){?>selected<?php }?>>Maryland</option>
					<option value="MA" <?php if($memInfo[state]=="MA"){?>selected<?php }?>>Massachusetts</option>
					<option value="MI" <?php if($memInfo[state]=="MI"){?>selected<?php }?>>Michigan</option>
					<option value="MN" <?php if($memInfo[state]=="MN"){?>selected<?php }?>>Minnesota</option>
					<option value="MS" <?php if($memInfo[state]=="MS"){?>selected<?php }?>>Mississippi</option>
					<option value="MO" <?php if($memInfo[state]=="MO"){?>selected<?php }?>>Missouri</option>
					<option value="MT" <?php if($memInfo[state]=="MT"){?>selected<?php }?>>Montana</option>
					<option value="NE" <?php if($memInfo[state]=="NE"){?>selected<?php }?>>Nebraska</option>
					<option value="NV" <?php if($memInfo[state]=="NV"){?>selected<?php }?>>Nevada</option>
					<option value="NH" <?php if($memInfo[state]=="NH"){?>selected<?php }?>>New Hampshire</option>
					<option value="NJ" <?php if($memInfo[state]=="NJ"){?>selected<?php }?>>New Jersey</option>
					<option value="NM" <?php if($memInfo[state]=="NM"){?>selected<?php }?>>New Mexico</option>
					<option value="NY" <?php if($memInfo[state]=="NY"){?>selected<?php }?>>New York</option>
					<option value="NC" <?php if($memInfo[state]=="NC"){?>selected<?php }?>>North Carolina</option>
					<option value="ND" <?php if($memInfo[state]=="ND"){?>selected<?php }?>>North Dakota</option>
					<option value="MP" <?php if($memInfo[state]=="MP"){?>selected<?php }?>>Northern Mariana Islands</option>
					<option value="OH" <?php if($memInfo[state]=="OH"){?>selected<?php }?>>Ohio</option>
					<option value="OK" <?php if($memInfo[state]=="OK"){?>selected<?php }?>>Oklahoma</option>
					<option value="OR" <?php if($memInfo[state]=="OR"){?>selected<?php }?>>Oregon</option>
					<option value="PW" <?php if($memInfo[state]=="PW"){?>selected<?php }?>>Palau</option>
					<option value="PA" <?php if($memInfo[state]=="PA"){?>selected<?php }?>>Pennsylvania</option>
					<option value="PR" <?php if($memInfo[state]=="PR"){?>selected<?php }?>>Puerto Rico</option>
					<option value="RI" <?php if($memInfo[state]=="RI"){?>selected<?php }?>>Rhode Island</option>
					<option value="SC" <?php if($memInfo[state]=="SC"){?>selected<?php }?>>South Carolina</option>
					<option value="SD" <?php if($memInfo[state]=="SD"){?>selected<?php }?>>South Dakota</option>
					<option value="TN" <?php if($memInfo[state]=="TN"){?>selected<?php }?>>Tennessee</option>
					<option value="TX" <?php if($memInfo[state]=="TX"){?>selected<?php }?>>Texas</option>
					<option value="UT" <?php if($memInfo[state]=="UT"){?>selected<?php }?>>Utah</option>
					<option value="VT" <?php if($memInfo[state]=="VT"){?>selected<?php }?>>Vermont</option>
					<option value="VI" <?php if($memInfo[state]=="VI"){?>selected<?php }?>>Virgin Islands</option>
					<option value="VA" <?php if($memInfo[state]=="VA"){?>selected<?php }?>>Virginia</option>
					<option value="WA" <?php if($memInfo[state]=="WA"){?>selected<?php }?>>Washington</option>
					<option value="WV" <?php if($memInfo[state]=="WV"){?>selected<?php }?>>West Virginia</option>
					<option value="WI" <?php if($memInfo[state]=="WI"){?>selected<?php }?>>Wisconsin</option>
					<option value="WY" <?php if($memInfo[state]=="WY"){?>selected<?php }?>>Wyoming</option>
					<option value="AE" <?php if($memInfo[state]=="AE"){?>selected<?php }?>>Armed Forces Africa</option>
					<option value="AA" <?php if($memInfo[state]=="AA"){?>selected<?php }?>>Armed Forces Americas (except Canada)</option>
					<option value="AE" <?php if($memInfo[state]=="AE"){?>selected<?php }?>>Armed Forces Canada</option>
					<option value="AE" <?php if($memInfo[state]=="AE"){?>selected<?php }?>>Armed Forces Europe</option>
					<option value="AE" <?php if($memInfo[state]=="AE"){?>selected<?php }?>>Armed Forces Middle East</option>
					<option value="AP" <?php if($memInfo[state]=="AP"){?>selected<?php }?>>Armed Forces Pacific</option>
            	</select>
            </td>
          </tr>
          <tr>
            <td width="250" align="right">Country/Region <span class="red">*</span></td>
            <td>
            	<select name="app[country_cd]" id="country_cd">
            	<?php foreach($countryList as $data){?>
					<option value="<?=$data[country_cd]?>" <?php if(($is_modify=="N" && $data[country_cd]=="US") || ($is_modify=="Y" && $data[country_cd]==$memInfo[country_cd])){?>selected<?php }?>><?=$data[country_nm]?></option>
				<?php }?>
            	</select>
            </td>
          </tr>
          <tr>
            <td width="250" align="right">Postal ZIP Code <span class="red">*</span></td>
            <td>
            	<input name="app[zip_cd]" type="text" id="zip_cd" size="20" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="5" value="<?=$memInfo[zip_cd]?>" />
              	<span class="cls_err_msg" id="err__zip_cd" style="padding-left:10px;color:red;"></span>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="80%" border="0" cellpadding="3" cellspacing="3" class="text">
          <tr>
            <td height="30" colspan="2" align="left" bgcolor="#CCCCCC"><strong><img src="/y/images/app/blank.png" width="20" height="10" />Activities </strong></td>
          </tr>
          <tr>
            <td colspan="2">
            <?php for($n=0 ; $n<4 ; $n++){?>
            	<div style="padding-top:5px;">
	            	<select name="activity_place[]">
	              		<option value="">Choose an activity place</option>
	              		<option value="C" <?php if($activityList[$n][activity_place]=="C"){?>selected<?php }?>>Church</option>
	              		<option value="M" <?php if($activityList[$n][activity_place]=="M"){?>selected<?php }?>>Mission</option>
	              		<option value="O" <?php if($activityList[$n][activity_place]=="O"){?>selected<?php }?>>Community</option>
	              		<option value="E" <?php if($activityList[$n][activity_place]=="E"){?>selected<?php }?>>School, Sports, ETC</option>
	            	</select>&nbsp;
	            	<select name="activity_from[]">
	              		<option value="">From Year</option>
	              		<?php for($i=1990 ; $i<=date('Y') ; $i++){?>
	              		<option value="<?=$i?>" <?php if($activityList[$n][activity_from]==$i){?>selected<?php }?>><?=$i?></option>
	              		<?php }?>
	            	</select>&nbsp;
	            	<select name="activity_to[]">
	              		<option value="">To Year</option>
	              		<?php for($i=1990 ; $i<=date('Y') ; $i++){?>
	              		<option value="<?=$i?>" <?php if($activityList[$n][activity_to]==$i){?>selected<?php }?>><?=$i?></option>
	              		<?php }?>
	            	</select>&nbsp;
	            	<input name="activity_contents[]" type="text" size="30" value="<?=$activityList[$n][activity_contents]?>" placeholder="Activities" />&nbsp;
	            	<input name="activity_role[]" type="text" size="24" value="<?=$activityList[$n][activity_role]?>" placeholder="Title & Roles" />
	            </div>
	        <?php }?>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="80%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30" align="center" bgcolor="#CCCCCC"><input type="button" name="button" id="button" value="NEXT" onclick="saveStep1();" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="120" align="center" bgcolor="#2a3037"><table width="1000" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="/y/images/app/sarang-logo-_red.png" width="1200" height="47" /></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>