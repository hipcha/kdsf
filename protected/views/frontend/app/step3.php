<?php 
# for js refresh
$setup = new BasicSetup();
$constants = $setup->getConstants();

$is_modify = $memInfo[mem_id]=="" ? "N" : "Y";
?>
<script type="text/javascript" src="/y/js/application.js?cache_num=<?=$constants[js_refresh_num]?>"></script>
<form name="appForm" id="appForm" method="post" enctype="multipart/form-data">
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
        <td height="50"></td>
      </tr>
      <tr>
        <td height="50" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="/y/images/app/text_top02_<?=strtolower($memInfo['mem_ctg'])?>.png" width="438" height="29" /></td>
            <td align="right"><img src="/y/images/app/step03.png" width="314" height="12" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="80%" border="0" cellpadding="5" cellspacing="3" class="text">
          <tr>
            <td height="30" colspan="4" align="left" bgcolor="#CCCCCC"><strong><img src="/y/images/app/blank.png" width="20" height="10" />APPLIACNT'S DETAILS</strong></td>
          </tr>
          <tr>
            <td width="150" align="left" bgcolor="#E9E9E9">Application Code<span class="red"></span></td>
            <td colspan="3">
            	<?=$memInfo['app_cd']=="" ? "It will be assigned if you complete the online application correctly." : $memInfo['app_cd']?> 
            </td>
          </tr>
          <tr>
            <td width="150" align="left" bgcolor="#E9E9E9">Applicant's Category<span class="red"></span></td>
            <td colspan="3">
            <?php if($memInfo['mem_ctg']=="A"){?>A. Member of Sa-Rang Community Church (남가주사랑의교회 성도 혹은 성도의 자녀)
            <?php }elseif($memInfo['mem_ctg']=="B"){?>B. Member of Other Churches/Communities (한인 및 타 인종 커뮤니티의 학생)
            <?php }elseif($memInfo['mem_ctg']=="C"){?>C. Child of Missionary in Other Countries (외국에서 선교하는 선교사의 자녀)
            <?php }elseif($memInfo['mem_ctg']=="D"){?>D. Child of Pastor in Non-Self Sufficient Church in U.S.A. (미국 내 미자립교회 목회자 자녀)
            <?php }elseif($memInfo['mem_ctg']=="E"){?>E. Local Theology Student recommended by Missionary (해외 선교지의 선교사가 추천한 현지인 신학생)
            <?php }?>
            </td>
          </tr>
          <tr>
            <td width="150" align="left" bgcolor="#E9E9E9">Applicant Name</td>
            <td width="251"><?=$memInfo['first_nm'].", ".$memInfo['last_nm']?></td>
            <td width="150" bgcolor="#E9E9E9">Date Of Birth : </td>
            <td width="250"><?=substr($memInfo['dob'],0,2)."/".substr($memInfo['dob'],2,2)."/".substr($memInfo['dob'],4)?></td>
          </tr>
          <tr>
            <td colspan="4" align="left" bgcolor="#E9E9E9">Home Address and Phones<span class="red"></span></td>
            </tr>
          <tr>
            <td colspan="4" align="center"><table width="90%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="50%">
                	<?=$memInfo['addr1']." ".$memInfo['addr2']?><br />
                  	<?=$memInfo['city']?>, <?=$memInfo['state']?> <?=$memInfo['zip_cd']?>,<br />
                  	<?=$memInfo['country_cd']?>
                </td>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr>
                    <td>Phone : <?=$memInfo['tel_no']?></td>
                  </tr>
                </table></td>
              </tr>
              </table></td>
          </tr>
          </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="80%" border="0" cellpadding="5" cellspacing="3" class="text">
          <tr>
            <td height="30" colspan="2" align="left" bgcolor="#CCCCCC"><strong><img src="/y/images/app/blank.png" width="20" height="10" />ACADEMIC LEVEL</strong></td>
          </tr>
          <tr>
            <td width="172" align="left" bgcolor="#E9E9E9">Academic Level<span class="red"></span></td>
            <td width="599"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><input type="radio" name="app[mem_level]" id="level_f" value="F" <?php if($memInfo[mem_level]=="F" ){?>checked<?php }?> /> F : To be college freshmen</td>
                <td><input type="radio" name="app[mem_level]" id="level_u" value="U" <?php if($memInfo[mem_level]=="U" ){?>checked<?php }?>  /> U : Undergraduate Student</td>
                <td><input type="radio" name="app[mem_level]" id="level_g" value="G" <?php if($memInfo[mem_level]=="G" ){?>checked<?php }?>  /> G : Graduate Student</td>
              </tr>
              <tr>
              	<td colspan="3" class="cls_err_msg" id="err__mem_level" style="padding-left:10px;color:red;"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><table width="92%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="118" height="30"><img src="/y/images/app/ball.png" width="6" height="6" align="baseline" /> High School</td>
                <td><label for="textfield"></label>
                  <input name="app[high_nm]" type="text" id="high_nm" size="60" value="<?=$memInfo[high_nm]?>" /></td>
              </tr>
              <tr>
                <td width="118" height="30"><img src="/y/images/app/ball.png" width="6" height="6" align="baseline" /> College/University</td>
                <td><input name="app[univ_nm]" type="text" id="univ_nm" size="60" value="<?=$memInfo[univ_nm]?>" /></td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td width="172" align="left" bgcolor="#E9E9E9">Transcript from Current School</td>
            <td>GPA
              <label for="textfield3"></label>
              <input name="app[gpa]" type="text" id="gpa" size="10" onkeyup="this.value=this.value.replace(/[^0-9.]/g,'');" value="<?=$memInfo[gpa]?>" /> 
              / 
            	<select name="app[gpa]" id="gpa_total">
              		<option value="">Select GPA Scales</option>
              		<option value="4.0" <?php if($memInfo[gpa_total]=="4.0"){?>selected<?php }?>>4.0</option>
              		<option value="4.5" <?php if($memInfo[gpa_total]=="4.5"){?>selected<?php }?>>4.5</option>
              		<option value="5.0" <?php if($memInfo[gpa_total]=="5.0"){?>selected<?php }?>>5.0</option>
            	</select>
            </td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="80%" border="0" cellpadding="5" cellspacing="3" class="text">
          <tr>
            <td height="30" colspan="2" align="left" bgcolor="#CCCCCC"><strong><img src="/y/images/app/blank.png" width="20" height="10" />FINANCIAL STATEMENT</strong></td>
          </tr>
          <tr>
            <td width="172" align="left" bgcolor="#E9E9E9">Total Family Income<span class="red"></span></td>
            <td width="599">$
              <input name="app[income]" type="text" id="income" size="15" value="<?=$memInfo[income]?>" />.00
			</td>
          </tr>
          <tr>
            <td align="left" bgcolor="#E9E9E9">Family Information</td>
            <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <!-- 
              <tr>
                <td width="118" height="30">Total Members</td>
                <td><label for="textfield3"></label>
                  <input name="app[family_count]" type="text" id="family_count" size="15" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="<?=$memInfo[family_count]?>" /> 
                  people in family</td>
              </tr>
              <tr>
                <td width="118" height="30">Total Students</td>
                <td><input name="app[family_student]" type="text" id="family_student" size="15" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="<?=$memInfo[family_student]?>" /> 
                  people in College/University/Graduate School</td>
              </tr>
            -->
	          <tr>
	            <td>
	            <?php for($i=0 ; $i<5 ; $i++){?>
	            	<div style="padding-top:20px;<?php if($i==4){?>padding-bottom:20px;<?php }?>">
		            	<input name="family_name[]" type="text" size="10" value="<?=$familyList[$i][family_name]?>" placeholder="Name" />&nbsp;
		            	<input name="family_relationship[]" type="text" size="10" value="<?=$familyList[$i][family_relationship]?>" placeholder="Relationship" />&nbsp;
		            	<input name="family_age[]" type="text" size="10" value="<?=$familyList[$i][family_age]?>" placeholder="Age" />&nbsp;
		            	<input name="family_occupation[]" type="text" size="10" value="<?=$familyList[$i][family_occupation]?>" placeholder="Occupation" />&nbsp;
		            	<input name="family_remark[]" type="text" size="18" value="<?=$familyList[$i][family_remark]?>" placeholder="Remark" />
		            	<select name="family_together[]">
		              		<option value="">==Living Together==</option>
		              		<option value="Y" <?php if($familyList[$i][family_together]=="Y"){?>selected<?php }?>>Yes</option>
		              		<option value="N" <?php if($familyList[$i][family_together]=="N"){?>selected<?php }?>>No</option>
		            	</select>&nbsp;
		            	<select name="family_marital[]">
		              		<option value="">==Marital Status==</option>
		              		<option value="M" <?php if($familyList[$i][family_marital]=="M"){?>selected<?php }?>>Married</option>
		              		<option value="S" <?php if($familyList[$i][family_marital]=="S"){?>selected<?php }?>>Single</option>
		              		<option value="D" <?php if($familyList[$i][family_marital]=="D"){?>selected<?php }?>>Divorced</option>
		              		<option value="W" <?php if($familyList[$i][family_marital]=="W"){?>selected<?php }?>>Widowed</option>
		            	</select>&nbsp;
		            </div>
		        <?php }?>
	            </td>
	          </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" bgcolor="#E9E9E9">Most members of family live in</td>
            <td>
            	<select name="app[family_country_cd]" id="family_country_cd">
            	<?php foreach($countryList as $data){?>
					<option value="<?=$data[country_cd]?>" <?php if(($is_modify=="N" && $data[country_cd]=="US") || ($is_modify=="Y" && $data[country_cd]==$memInfo[family_country_cd])){?>selected<?php }?>><?=$data[country_nm]?></option>
				<?php }?>
            	</select>
            </td>
          </tr>
          <tr>
            <td align="left" bgcolor="#E9E9E9">Cost of Attendance <br />
              (or Tuition, Dormitory,etc)</td>
            <td>$
              <input name="app[attendance_cost]" type="text" id="attendance_cost" size="15" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="<?=$memInfo[attendance_cost]?>" />.00 </td>
          </tr>
          <tr>
            <td colspan="2" align="left" bgcolor="#E9E9E9">Finacial Source of Tuition</td>
            </tr>
          <tr>
            <td colspan="2" align="center" bgcolor="#FFFFFF"><table width="92%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="159" height="30"><img src="/y/images/app/ball.png" width="6" height="6" align="baseline" /> Yourself</td>
                <td width="571">$
                  <input name="app[tuition_self]" type="text" id="tuition_self" size="15" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="<?=$memInfo[tuition_self]?>" />.00 </td>
              </tr>
              <tr>
                <td width="159" height="30"><img src="/y/images/app/ball.png" width="6" height="6" align="baseline" /> Parent(s)</td>
                <td>$
                  <input name="app[tuition_parent]" type="text" id="tuition_parent" size="15" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="<?=$memInfo[tuition_parent]?>" />.00 </td>
              </tr>
              <tr>
                <td height="30"><img src="/y/images/app/ball.png" width="6" height="6" align="baseline" /> Student Loan</td>
                <td>$
                  <input name="app[tuition_student_loan]" type="text" id="tuition_student_loan" size="15" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="<?=$memInfo[tuition_student_loan]?>" />.00 </td>
              </tr>
              <tr>
                <td height="30"><img src="/y/images/app/ball.png" width="6" height="6" align="baseline" /> Scholarship</td>
                <td>$
                  <input name="app[tuition_scholarship]" type="text" id="tuition_scholarship" size="15" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="<?=$memInfo[tuition_scholarship]?>" />.00 </td>
              </tr>
            </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="80%" border="0" cellpadding="5" cellspacing="3" class="text">
          <tr>
            <td height="30" colspan="2" align="left" bgcolor="#CCCCCC"><strong><img src="/y/images/app/blank.png" width="20" height="10" />FINANCIAL CIRCUMSTANCES</strong></td>
          </tr>
          <tr>
            <td align="left" bgcolor="#E9E9E9">Expenses<br/>(Monthly)</td>
            <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	          <tr>
	            <td>
	            <?php for($i=0 ; $i<12 ; $i++){?>
	            	<div style="padding-top:20px;<?php if($i==11){?>padding-bottom:20px;<?php }?>">
		            	<select name="expense_type[]">
		              		<option value="">===Expense Type===</option>
		              		<option value="RM" <?php if($expenseList[$i][expense_type]=="RM"){?>selected<?php }?>>Rent/Mortgage</option>
		              		<option value="CP" <?php if($expenseList[$i][expense_type]=="CP"){?>selected<?php }?>>Car Payment</option>
		              		<option value="GA" <?php if($expenseList[$i][expense_type]=="GA"){?>selected<?php }?>>Gas Auto</option>
		              		<option value="IS" <?php if($expenseList[$i][expense_type]=="IS"){?>selected<?php }?>>Insurance</option>
		              		<option value="FD" <?php if($expenseList[$i][expense_type]=="FD"){?>selected<?php }?>>Food</option>
		              		<option value="UT" <?php if($expenseList[$i][expense_type]=="UT"){?>selected<?php }?>>Utilities</option>
		              		<option value="IT" <?php if($expenseList[$i][expense_type]=="IT"){?>selected<?php }?>>Internet/Cable</option>
		              		<option value="PC" <?php if($expenseList[$i][expense_type]=="PC"){?>selected<?php }?>>Phone/Cell</option>
		              		<option value="MC" <?php if($expenseList[$i][expense_type]=="MC"){?>selected<?php }?>>Medical</option>
		              		<option value="CC" <?php if($expenseList[$i][expense_type]=="CC"){?>selected<?php }?>>Credit Cards</option>
		            	</select>&nbsp;
		            	<select name="expense_paidby[]">
		              		<option value="">===Paid By===</option>
		              		<option value="S" <?php if($expenseList[$i][expense_paidby]=="S"){?>selected<?php }?>>Self</option>
		              		<option value="P" <?php if($expenseList[$i][expense_paidby]=="P"){?>selected<?php }?>>Parents</option>
		              		<option value="O" <?php if($expenseList[$i][expense_paidby]=="O"){?>selected<?php }?>>Guardians/Others</option>
		            	</select>&nbsp;
		            	<input name="expense_amt[]" type="text" size="10" value="<?=$expenseList[$i][expense_amt]?>" placeholder="Amount" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" />&nbsp;
		            </div>
		        <?php }?>
	            </td>
	          </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="80%" border="0" cellpadding="5" cellspacing="3" class="text">
          <tr>
            <td height="30" colspan="2" align="left" bgcolor="#CCCCCC"><strong><img src="/y/images/app/blank.png" width="20" height="10" />FINANCIAL REFERENCES</strong></td>
          </tr>
          <tr>
            <td align="left" bgcolor="#E9E9E9">Reference</td>
            <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	          <tr>
	            <td>
	            <?php for($i=0 ; $i<2 ; $i++){?>
	            	<div style="padding-top:20px;<?php if($i==1){?>padding-bottom:20px;<?php }?>">
		            	<input name="ref_name[]" type="text" size="10" value="<?=$memInfo[family_name]?>" placeholder="Name" />&nbsp;
		            	<input name="ref_addr[]" type="text" size="20" value="<?=$memInfo[family_age]?>" placeholder="Address" />&nbsp;
		            	<input name="ref_relation[]" type="text" size="15" value="<?=$memInfo[family_relationship]?>" placeholder="Relation" />&nbsp;
		            	<input name="ref_email[]" type="text" size="15" value="<?=$memInfo[family_occupation]?>" placeholder="Email" />&nbsp;
		            	<input name="ref_tel_no[]" type="text" size="10" value="<?=$memInfo[family_remark]?>" placeholder="Phone" />&nbsp;
		            	<input name="ref_work_employer[]" type="text" size="10" value="<?=$memInfo[family_remark]?>" placeholder="Employer" />&nbsp;
		            	<input name="ref_work_addr[]" type="text" size="20" value="<?=$memInfo[family_remark]?>" placeholder="Work Address" />&nbsp;
		            	<input name="ref_work_position[]" type="text" size="15" value="<?=$memInfo[family_remark]?>" placeholder="Work Position" />
		            </div>
		        <?php }?>
	            </td>
	          </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="80%" border="0" cellpadding="5" cellspacing="3" class="text">
          <tr>
            <td width="771" height="30" align="left" bgcolor="#CCCCCC"><strong><img src="/y/images/app/blank.png" width="20" height="10" />APPLICANT'S ESSAY</strong></td>
          </tr>
          <tr>
            <td height="30" align="center" bgcolor="#E9E9E9">
            	<label for="textfield11"></label>
              	<textarea name="app[essay]" cols="90" rows="6" id="essay"><?=$memInfo[essay]?></textarea>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center"><table width="80%" border="0" cellpadding="5" cellspacing="3" class="text">
          <tr>
            <td width="771" height="30" align="left" bgcolor="#CCCCCC"><strong><img src="/y/images/app/blank.png" width="20" height="10" />APPLICANT'S COMMENT</strong></td>
          </tr>
          <tr>
            <td height="30" align="center" bgcolor="#E9E9E9">
            	<label for="textfield11"></label>
              	<textarea name="app[comment]" cols="90" rows="6" id="comment"><?=$memInfo[comment]?></textarea>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="80%" border="0" cellpadding="5" cellspacing="3" class="text">
          <tr>
            <td width="771" height="30" align="left" bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td><strong><img src="/y/images/app/blank.png" width="20" height="10" />APPLICANT'S DOCUMENTS</strong></td>
                </tr>
                <!-- 
                <tr>
                  <td align="center"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>1) The upload file size of each files will be limited to <span class="red">2MB in maximum.</span><br />
                        2) All Adobe PDF files, JPEG formated files, Microsoft Office 2003, or 2007 files and HWP files are acceptable.<br />
                        3) The attached filename shall be named in <span class="red">English only</span>. The filename with a different language will be subjected to suspend your application.<br />
                        4)<span class="red"> Before upload your files, you must rename the filename of the documents with your name as shown in below:   For example, KDSF_ApplicationForm_2013_Rev2_(Daniel Kim).xls</span></td>
                    </tr>
                  </table></td>
                </tr>
                 -->
            </table></td>
          </tr>
          <tr>
            <td height="30" align="center" bgcolor="#E9E9E9"><label for="textfield11"></label>
              <table width="95%" border="0" cellspacing="1" cellpadding="5">
                <tr>
                  <td bgcolor="#CCCCCC" class="bold">Proof of grade from previous level of education (전(全)학년성적증명서)</td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF">
                  	<input type="file" name="file_grade" id="file_grade" />
                  	&nbsp;<?php if($memInfo[file_grade]!=""){?><span style="color:red;font-weight:bold;">This File has been uploaded.</span><?php }?>
                  </td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td height="30" align="center" bgcolor="#E9E9E9"><table width="95%" border="0" cellspacing="1" cellpadding="5">
              <tr>
                <td bgcolor="#CCCCCC" class="bold">Proof of household income (가족 총수입의 제증빙서류)</td>
              </tr>
              <tr>
                  <td bgcolor="#FFFFFF">
                  	<input type="file" name="file_income" id="file_income" />
                  	&nbsp;<?php if($memInfo[file_income]!=""){?><span style="color:red;font-weight:bold;">This File has been uploaded.</span><?php }?>
                  </td>
              </tr>
            </table></td>
          </tr>
          <?php if($memInfo['mem_ctg']=="C"){?>
          <tr>
            <td height="30" align="center" bgcolor="#E9E9E9"><table width="95%" border="0" cellspacing="1" cellpadding="5">
              <tr>
                <td bgcolor="#CCCCCC" class="bold">Proof of missionary expedition (선교사 파송 증명서)</td>
              </tr>
              <tr>
                  <td bgcolor="#FFFFFF">
                  	<input type="file" name="file_missionary_expedition" id="file_missionary_expedition" />
                  	&nbsp;<?php if($memInfo[file_missionary_expedition]!=""){?><span style="color:red;font-weight:bold;">This File has been uploaded.</span><?php }?>
                  </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="30" align="center" bgcolor="#E9E9E9"><table width="95%" border="0" cellspacing="1" cellpadding="5">
              <tr>
                <td bgcolor="#CCCCCC" class="bold">Letter of introduction from missionary (선교사역소개서)</td>
              </tr>
              <tr>
                  <td bgcolor="#FFFFFF">
                  	<input type="file" name="file_missionary_introduction" id="file_missionary_introduction" />
                  	&nbsp;<?php if($memInfo[file_missionary_introduction]!=""){?><span style="color:red;font-weight:bold;">This File has been uploaded.</span><?php }?>
                  </td>
              </tr>
            </table></td>
          </tr>
          <?php }elseif($memInfo['mem_ctg']=="D"){?>
          <tr>
            <td height="30" align="center" bgcolor="#E9E9E9"><table width="95%" border="0" cellspacing="1" cellpadding="5">
              <tr>
                <td bgcolor="#CCCCCC" class="bold">Proof of church affiliation (교단소속증)</td>
              </tr>
              <tr>
                  <td bgcolor="#FFFFFF">
                  	<input type="file" name="file_church_affiliation" id="file_church_affiliation" />
                  	&nbsp;<?php if($memInfo[file_church_affiliation]!=""){?><span style="color:red;font-weight:bold;">This File has been uploaded.</span><?php }?>
                  </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="30" align="center" bgcolor="#E9E9E9"><table width="95%" border="0" cellspacing="1" cellpadding="5">
              <tr>
                <td bgcolor="#CCCCCC" class="bold">Degree in theology(graduate school) (신학교(대학원) 졸업증서)</td>
              </tr>
              <tr>
                  <td bgcolor="#FFFFFF">
                  	<input type="file" name="file_theology_degree" id="file_theology_degree" />
                  	&nbsp;<?php if($memInfo[file_theology_degree]!=""){?><span style="color:red;font-weight:bold;">This File has been uploaded.</span><?php }?>
                  </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="30" align="center" bgcolor="#E9E9E9"><table width="95%" border="0" cellspacing="1" cellpadding="5">
              <tr>
                <td bgcolor="#CCCCCC" class="bold">Latest print of church news (최근발행교회주보)</td>
              </tr>
              <tr>
                  <td bgcolor="#FFFFFF">
                  	<input type="file" name="file_church_news" id="file_church_news" />
                  	&nbsp;<?php if($memInfo[file_church_news]!=""){?><span style="color:red;font-weight:bold;">This File has been uploaded.</span><?php }?>
                  </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="30" align="center" bgcolor="#E9E9E9"><table width="95%" border="0" cellspacing="1" cellpadding="5">
              <tr>
                <td bgcolor="#CCCCCC" class="bold">Church budget report (교회예결산보고서)</td>
              </tr>
              <tr>
                  <td bgcolor="#FFFFFF">
                  	<input type="file" name="file_church_budget" id="file_church_budget" />
                  	&nbsp;<?php if($memInfo[file_church_budget]!=""){?><span style="color:red;font-weight:bold;">This File has been uploaded.</span><?php }?>
                  </td>
              </tr>
            </table></td>
          </tr>
          <?php }elseif($memInfo['mem_ctg']=="E"){?>
          <tr>
            <td height="30" align="center" bgcolor="#E9E9E9"><table width="95%" border="0" cellspacing="1" cellpadding="5">
              <tr>
                <td bgcolor="#CCCCCC" class="bold">Copy of bill of tuition (yearly) (등록금내역서사본(1년))</td>
              </tr>
              <tr>
                  <td bgcolor="#FFFFFF">
                  	<input type="file" name="file_tuition_bill" id="file_tuition_bill" />
                  	&nbsp;<?php if($memInfo[file_tuition_bill]!=""){?><span style="color:red;font-weight:bold;">This File has been uploaded.</span><?php }?>
                  </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="30" align="center" bgcolor="#E9E9E9"><table width="95%" border="0" cellspacing="1" cellpadding="5">
              <tr>
                <td bgcolor="#CCCCCC" class="bold">Letter of recommendation from missionary (선교사추천서)</td>
              </tr>
              <tr>
                  <td bgcolor="#FFFFFF">
                  	<input type="file" name="file_missionary_recommendation" id="file_missionary_recommendation" />
                  	&nbsp;<?php if($memInfo[file_missionary_recommendation]!=""){?><span style="color:red;font-weight:bold;">This File has been uploaded.</span><?php }?>
                  </td>
              </tr>
            </table></td>
          </tr>
          <?php }?>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="80%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30" align="center" bgcolor="#CCCCCC">
            	<input type="button" name="button7" id="button7" value="SAVE" onclick="saveStep3();" />
              	<input type="button" name="button8" id="button8" value="GO BACK" onclick="window.location.href='/y/app/step2';" />
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
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
