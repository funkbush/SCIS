<?php
session_start();    //����һ���Ự
$A_name=$_POST[name];          //���ձ��ύ���û���
$A_pwd=$_POST[pwd];            //���ձ��ύ������
$vcode=$_SESSION[vcode];   //�����vcode.php���ɵ�
$txtvcode=$_POST["txtvcode"];   //�����ҳ�������
$url=$_SESSION["url"];

//echo $txtvcode."*****".$vcode."<br>";
//echo $_SESSION["url"]."<br>";

class chkinput
{                //������
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
       @mysql_connect("localhost","root","")or die("���ݿ�����ʧ�ܣ�");
       @mysql_select_db("admin")or die("ѡ������ݿⲻ���ڻ򲻿���!");
	   mysql_query("set names gb2312");   
       $sql=mysql_query("select * from scis where Username='".$this->name."' and Password='".md5($this->pwd)."' and Status='1';");
       $info=mysql_fetch_array($sql);       //��������Ա���ƺ������Ƿ���ȷ
	   
		if($info==false)     //����û����ƻ����벻��ȷ���򵯳������ʾ��Ϣ
		{                    
			echo "<script language='javascript'>alert('Error with User or Password,please agian!');history.back();</script>";
			unset($_SESSION[vcode]);  //�ͷŵ�ǰ���ڴ����Ѿ������Ự������ɾ���Ự�ļ��Լ����ͷŶ�Ӧ�Ựid
			exit;
		}
		
		if($this->vcode!=$this->txtvcode)
		{
		    echo "<script language='javascript'>alert('Error with Vcode,please agian!');history.back();</script>";
			unset($_SESSION[vcode]);   //�ͷŵ�ǰ���ڴ����Ѿ������Ự������ɾ���Ự�ļ��Լ����ͷŶ�Ӧ�Ựid
			exit;
		}
		
		if($info==true && $this->vcode==$this->txtvcode)
		{                              //�������Ա���ƻ�������ȷ���򵯳������ʾ��Ϣ
			if($this->url=="")
			{
				echo "<script>alert('User login sucessfully!');window.location='index.php';</script>";
				unset($_SESSION[vcode]);   //�ͷŵ�ǰ���ڴ����Ѿ������Ự������ɾ���Ự�ļ��Լ����ͷŶ�Ӧ�Ựid
			}
			else
			{
				echo "<script>alert('User login sucessfully!');window.location='".$this->url."';</script>";
				unset($_SESSION[vcode]);   //�ͷŵ�ǰ���ڴ����Ѿ������Ự������ɾ���Ự�ļ��Լ����ͷŶ�Ӧ�Ựid
			}
			
			$_SESSION[admin_name]=$info[Username];
			$_SESSION[pwd]=$info[Password];
		}
	   #############################################################################
	//session_destroy();
	//unset($_SESSION["vcode"]);   //������������
   }
}
    $obj=new chkinput(trim($name),trim($pwd),$url,$vcode,$txtvcode);      //��������
    $obj->checkinput();	//������

?>
