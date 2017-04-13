<?php 
# for js refresh
$setup = new BasicSetup();
$constants = $setup->getConstants();
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
        <td height="50"></p></td>
      </tr>
      <tr>
        <td height="50" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="/y/images/app/text_top02.png" width="310" height="29" /></td>
            <td align="right"><img src="/y/images/app/step02.png" width="314" height="12" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="80%" border="0" cellpadding="3" cellspacing="3" class="text">
          <tr>
            <td width="250" height="30" align="center" bgcolor="#E9E9E9"><table width="95%" border="0" cellpadding="5" cellspacing="0">
              <tbody>
                <tr>
                  <td align="left" height="10">Select your category applicable to your status.</td>
                </tr>
                <tr>
                  <td align="left"><strong>Applicant's Name :</strong> <?=$memInfo['first_nm'].", ".$memInfo['last_nm']?></td>
                </tr>
              </tbody>
 
  <tr>
    <td align="left"><strong>Select one of Applicant's Categories</strong></td>
  </tr>
  <tr>
    <td align="left" class="red">This is the last chance to define the Applicant's Category by yourself. Please think your case to be selected carefully. If you click the wrong category for your application, email us and/or leave a comment on your application. We are here for you.</td>
  </tr>
  <tr>
  </tr>
            </table></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="80%" border="0" cellpadding="3" cellspacing="3" class="text">
          <tr>
            <td width="250" align="center"><img src="/y/images/app/a.png" width="692" height="58" onclick="saveStep2('A');" style="cursor:pointer;" /></td>
          </tr>
          <tr>
            <td align="center"><img src="/y/images/app/b.png" width="692" height="58" onclick="saveStep2('B');" style="cursor:pointer;" /></td>
          </tr>
          <tr>
            <td align="center"><img src="/y/images/app/c.png" width="692" height="58" onclick="saveStep2('C');" style="cursor:pointer;" /></td>
          </tr>
          <tr>
            <td align="center"><img src="/y/images/app/d.png" width="692" height="58" onclick="saveStep2('D');" style="cursor:pointer;" /></td>
          </tr>
          <tr>
            <td align="center"><img src="/y/images/app/e.png" width="692" height="58" onclick="saveStep2('E');" style="cursor:pointer;" /></td>
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
