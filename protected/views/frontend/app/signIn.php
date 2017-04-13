<script>
$(function(){
	$('#email').focus();
});
</script>
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
            <td><img src="/y/images/app/LOGIN.png" width="107" height="29" /></td>
            <td align="right">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="80%" border="0" cellpadding="3" cellspacing="3" class="text">
          <tr>
            <td height="30" colspan="2" align="left" bgcolor="#CCCCCC"><strong><img src="/y/images/app/blank.png" width="20" height="10" />LOGIN TO MY ACCOUNT</strong></td>
            </tr>
          <tr>
            <td height="14" colspan="2" align="left" nowrap="nowrap">&nbsp;</td>
          </tr>
          <tr>
            <td width="320" align="right">Email</td>
            <td><input type="text" name="email" id="email" /><span class="cls_err_msg" id="err__email" style="padding-left:10px;color:red;"></span></td>
          </tr>
          <tr>
            <td width="320" align="right">Password</td>
            <td><input type="password" name="pwd" id="pwd" onkeydown="if(event.keyCode==13) signIn();" /><span class="cls_err_msg" id="err__pwd" style="padding-left:10px;color:red;"></span></td>
          </tr>
          <tr>
            <td colspan="2" align="right">&nbsp;</td>
            </tr>
          <tr>
            <td height="30" colspan="2" align="center" bgcolor="#CCCCCC"><table width="20%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center"><input type="button" name="button" id="button" value="Sign In" onclick="signIn();" /></td>
                <td align="center"><input type="button" name="button2" id="button2" value="Cancel" onclick="window.location.href='/y/app/signIn';" /></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="30" colspan="2" align="center" bgcolor="#CCCCCC"><table width="40%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" style="font-size:17px;">
                	Don't have an account? <span><a href="/y/app/step1" style="color:#188fff;text-decoration:none;">Sign Up</a></span>
                </td>
              </tr>
            </table></td>
          </tr>
          </table></td>
      </tr>
      <tr>
        <td align="right"><table width="50%" border="0" cellpadding="0" cellspacing="0" class="text">
        <!-- 
          <tr>
            <td height="30" align="center"><img src="/y/images/app/ball.png" width="6" height="6" align="baseline" /> Create new account</td>
            <td align="left"><img src="/y/images/app/ball.png" width="6" height="6" align="baseline" /> I can't access my account</td>
          </tr>
           -->
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="200" align="center">&nbsp;</td>
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