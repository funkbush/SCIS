<html>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<script type="text/javascript" src="js/st-login.js"></script>
<head>
<title>SCIS登录</title>
<!--<link href="CSS/style.css" rel="stylesheet">-->

<?php
session_start();    //启动一个会话
$url=$_SERVER['HTTP_REFERER'];   //取得上一个页面
$_SESSION["url"]=$url;    //塞进会话
?>

</head>
<body onload="getcode();">

<form name="form" method="post" action="st-chklogin.php">
  <table width="100%" height="90%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="30%" bgcolor="888888">&nbsp;</td>
      <td width="30%" background=""><h2>SCIS登录</h2>
	   <table width="70%" height="20%"  border="0" align="center" cellpadding="1" cellspacing="1" bordercolorlight="#888888" bordercolordark="#888888">
	    <a href="http://127.0.0.1/reg/index.php">没有注册点我</a>
		<tr>&nbsp;</tr>
		<tr>&nbsp;</tr>
		<tr>&nbsp;</tr>
		<tr>&nbsp;</tr>
		<tr>&nbsp;</tr>
		<tr>&nbsp;</tr>
		<tr>&nbsp;</tr>
		<tr>&nbsp;</tr>
        <tr align="left">
          <td height="30">用户名：<input name="name" type="text" class="logininput" id="name3" size="25" value="1"></td>
        </tr>
        <tr align="left">
          <td height="30">密&nbsp;码：<input name="pwd" type="password" class="logininput" id="pwd2" size="25" value="1"></td>
        </tr>
		<tr align="left">
		  <td height="30">验证码：<input name="txtvcode" type="text" id="txtvcode" size="25" /></td>
		 <td><image src="vcode.php" width=80 height=26 id="vcode" alt="看不清点我" onClick="getcode()"></td>
        </tr>
		<tr>
          <td height="30" align="center" valign="top">
          <br>    
		  <input name="submit" type="submit" class="btn_grey" value="确定" onClick="return check(form);">&nbsp;
		  <input name="submit3" type="reset" class="btn_grey" value="重置">&nbsp;
          <input name="submit2" type="button" class="btn_grey" value="关闭" onClick="window.close();">
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
