<?php
session_start();    //启动一个会话
$A_name=$_POST[name];          //接收表单提交的用户名
$A_pwd=$_POST[pwd];            //接收表单提交的密码
$vcode=$_SESSION[vcode];   //这个是vcode.php生成的
$txtvcode=$_POST["txtvcode"];   //这个是页面输入的
$url=$_SESSION["url"];

//echo $txtvcode."*****".$vcode."<br>";
//echo $_SESSION["url"]."<br>";

class chkinput
{                //定义类
   var $name; 
   var $pwd;
   var $url;

   function chkinput($x,$y,$url,$vcode,$txtvcode)
   {
       $this->name=$x;
       $this->pwd=$y;
	   $this->url=$url;
	   $this->vcode=$vcode;
	   $this->txtvcode=$txtvcode;
   }

   function checkinput()
   {
       @mysql_connect("localhost","root","")or die("数据库连接失败！");
       @mysql_select_db("admin")or die("选择的数据库不存在或不可用!");
	   mysql_query("set names gb2312");   
       $sql=mysql_query("select * from scis where Username='".$this->name."' and Password='".md5($this->pwd)."' and Status='1';");
       $info=mysql_fetch_array($sql);       //检索管理员名称和密码是否正确
	   
		if($info==false)     //如果用户名称或密码不正确，则弹出相关提示信息
		{                    
			echo "<script language='javascript'>alert('Error with User or Password,please agian!');history.back();</script>";
			unset($_SESSION[vcode]);  //释放当前在内存中已经创建会话，但不删除会话文件以及不释放对应会话id
			exit;
		}
		
		if($this->vcode!=$this->txtvcode)
		{
		    echo "<script language='javascript'>alert('Error with Vcode,please agian!');history.back();</script>";
			unset($_SESSION[vcode]);   //释放当前在内存中已经创建会话，但不删除会话文件以及不释放对应会话id
			exit;
		}
		
		if($info==true && $this->vcode==$this->txtvcode)
		{                              //如果管理员名称或密码正确，则弹出相关提示信息
			if($this->url=="")
			{
				echo "<script>alert('User login sucessfully!');window.location='index.php';</script>";
				unset($_SESSION[vcode]);   //释放当前在内存中已经创建会话，但不删除会话文件以及不释放对应会话id
			}
			else
			{
				echo "<script>alert('User login sucessfully!');window.location='".$this->url."';</script>";
				unset($_SESSION[vcode]);   //释放当前在内存中已经创建会话，但不删除会话文件以及不释放对应会话id
			}
			
			$_SESSION[admin_name]=$info[Username];
			$_SESSION[pwd]=$info[Password];
		}
	   #############################################################################
	//session_destroy();
	//unset($_SESSION["vcode"]);   //放在这里会出错
   }
}
    $obj=new chkinput(trim($name),trim($pwd),$url,$vcode,$txtvcode);      //创建对象
    $obj->checkinput();	//调用类

?>
