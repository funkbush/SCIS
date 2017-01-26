<?php
include_once("connect.php");

$username=stripslashes(trim($_POST['username']));

//检测用户名是否存在
$query=mysql_query("select id from scis where username='$username'");
$num=mysql_num_rows($query);

if($num==1)
{
	echo '<script>alert("用户名已存在，请换个其他用户名");window.history.go(-1);</script>';
	exit;
}

$password=md5(trim($_POST['password']));
$email=trim($_POST['email']);
$regtime=time();

$token=md5($username.$password.$regtime); //创建用于激活识别码
$token_exptime=time()+60*60*24;//过期时间为24小时后


$sql="insert into scis(username,password,email,token,token_exptime,regtime) values('".$username."','".$password."','".$email."','".$token."','".$token_exptime."','".$regtime."');";

$query=mysql_query($sql);
//echo mysql_insert_id()."<br>";
//echo $query;
//**************上面没问题，下面有问题*****
if(mysql_insert_id())
//if($query==1)
{//写入成功，发邮件
	include_once("smtp.class.php");
	$smtpserver="smtp.163.com"; //SMTP服务器
    $smtpserverport=25; //SMTP服务器端口
    $smtpusermail="funkbush@163.com"; //SMTP服务器的用户邮箱
    $smtpuser="funkbush"; //SMTP服务器的用户帐号
    $smtppass="wjl19890527"; //SMTP服务器的用户密码
    $smtp=new Smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass); //这里面的一个true是表示使用身份验证,否则不使用身份验证.
    $emailtype="HTML"; //信件类型，文本:text；网页：HTML
    $smtpemailto=$email;
    $smtpemailfrom=$smtpusermail;
    $emailsubject="SCIS User ACTIVATE.";
    $emailbody="尊敬的".$username."：<br/>感谢注册。<br/>请点击链接激活帐号。<br/><a href='http://127.0.0.1/reg/active.php?verify=".$token."' target='_blank'>http://127.0.0.1/b/active.php?verify=".$token."</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。<br/>如果此次激活请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'>-------- Bush敬上</p>";
    $rs=$smtp->sendmail($smtpemailto,$smtpemailfrom,$emailsubject,$emailbody,$emailtype);
	
	if($rs==1)
	{
		$msg='注册成功,需要激活帐号<br/>请登录到邮箱及时激活帐号！';	
	}
	else
	{
		$msg=$rs;	
	}
	
	echo $msg;
}
?>