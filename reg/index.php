<html>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<head>
<title>SCISע��</title>
<script type="text/javascript">
function chk_form()
{
	var user=document.getElementById("user");
	if(user.value=="")
	{
		alert("�û�������Ϊ�գ�");
		return false;
		//user.focus();
	}
	
	var pass=document.getElementById("pass");
	if(pass.value=="")
	{
		alert("���벻��Ϊ�գ�");
		return false;
		//pass.focus();
	}
	var email=document.getElementById("email");
	if(email.value=="")
	{
		alert("Email����Ϊ�գ�");
		return false;
		//email.focus();
	}
	var preg=/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/; //ƥ��Email
	
	if(!preg.test(email.value))
	{ 
		alert("Email��ʽ����");
		return false;
		//email.focus();
	}
}
</script>
</head>

<body>

<form id="reg" action="register.php" method="post" onsubmit="return chk_form();">
  <table width="100%" height="90%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="30%" bgcolor="888888">&nbsp;</td>
      <td width="30%" background=""><h2>SCIS�˺�ע��</h2>
	   <table width="70%" height="20%"  border="0" align="center" cellpadding="1" cellspacing="1" bordercolorlight="#888888" bordercolordark="#888888">
	    <tr>&nbsp;</tr>
		<tr>&nbsp;</tr>
		<tr>&nbsp;</tr>
		<tr>&nbsp;</tr>
		<tr>&nbsp;</tr>
		<tr>&nbsp;</tr>
		<tr>&nbsp;</tr>
		<tr>&nbsp;</tr>
		<tr align="left">
          <td height="30">�����������:<input type="text" class="input" name="username" id="user"></td>
        </tr>
		<tr align="left">
          <td height="30">�����������:<input type="password" class="input" name="password" id="pass"></td>
        </tr>
		<!--
		<tr align="left">
          <td height="30">ȷ���������:<input type="password" class="input" name="enterpwd" id="enterpwd"></td>
        </tr>
		-->
		<tr align="left">
		  <td height="30">&nbsp;&nbsp;&nbsp;E-mail:<input type="text" class="input" name="email" id="email"></td>
        </tr>
        <tr>
          <td height="30" align="center" valign="top">
          <br>    
		  <input type="submit" class="btn" value="Submit!!!">
		  </td>
        </tr>
       </table>
	  </td>
	  
      <td width="30%" bgcolor="888888"><br></td>
    </tr>
  </table>
  <div align="center"><br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CopyRight 2014-2019 Bushit &nbsp;</div>
</form>
</body>
</html>