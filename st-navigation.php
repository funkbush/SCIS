<?php
session_start();
@mysql_connect("localhost","root","")or die("数据库连接失败！");
@mysql_select_db("admin")or die("选择的数据库不存在或不可用!");
mysql_query("set names gb2312");
$query=mysql_query("select * from scis where Username='".$_SESSION[admin_name]."' and Password='".$_SESSION[pwd]."' and Status='1';");  //
$info=mysql_fetch_array($query);

if($info==false)
{
     echo "<script language='javascript'>alert('Please login SCIS first!');window.location='st-login.php';</script>";
}
?>

<table width="30%" border="0" align="right" cellpadding="0" cellspacing="0">
  <tr>
    <td height="25" align="right" valign="bottom" bgcolor="#FFFFFF">
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="30" align="right">User：<?php echo $_SESSION[admin_name];?>&nbsp;</td>
		<script type=text/javascript>
		//document.write("<span id='labtime' width='120px' Font-Size='9pt'></span>")
		//setInterval("labtime.innerText=new Date().toLocaleString()",1000)
		</script>
        <td width="70%" align="right"><a href="st-safequit.php" class="a1">Logout</a></td>
      </tr>
    </table></td>
  </tr>
</table>
