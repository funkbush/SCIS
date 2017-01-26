<?php
   $w=80;  //图像宽度
   $h=26;  //图像高度
   
   $str=Array();    //创建一个空数组
   $vcode="";   #放验证码数据用的
   
   $string="abcdegghijklmnopqrstuvwxyz0123456789";   //顺序无所谓
   
   for($i=0;$i<4;$i++)    //随机生成一个验证码
   {
       $str[$i]=$string[rand(0,35)];   //那个字符串中随机位置的字符
	   $vcode.=$str[$i];  #这个".="是连字符
   }
   
   /*if($_SESSION["vcode"])   //没用   
   {
       unset($_SESSION["vcode"]);
   }*/
   
   session_start();   //启动一个会话
   $_SESSION["vcode"]=$vcode;  //将验证码保存到会话变量中
   
   //echo $_SESSION["vcode"];
   
   $im=imagecreatetruecolor($w,$h);   //创建一个真彩色图像
   $white=imagecolorallocate($im,255,255,255);
   $blue=imagecolorallocate($im,0,0,255);
   
   imagefilledrectangle($im,0,0,$w,$h,$white);   //用白色矩形来填充
   imagerectangle($im,0,0,$w-1,$h-1,$blue);  //用蓝线画边框
   
   //以下用于生成雪花背景
   
   for($i=1;$i<200;$i++)
   {
        $x=mt_rand(1,$w-9);   //用mt_rand()生成随机数
		$y=mt_rand(1,$h-9);
		$color=imagecolorallocate($im,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));#随机生成一种颜色
		
		imagechar($im,1,$x,$y,"￥",$color);   //在图像中打入一个星号
   }
   
   
   //以下循环语句用于将验证码写入图像中
   for($i=0;$i<count($str);$i++)
   {
        $x=13+$i*($w-15)/4;
		$y=mt_rand(3,$h/3);
		$color=imagecolorallocate($im,mt_rand(0,255),mt_rand(0,150),mt_rand(0,225));
		imagechar($im,5,$x,$y,$str[$i],$color);
   }
   
   header("Content-type:image/gif");  //设置输出文件格式
   imagepng($im);    //把$im对象转为某种格式的图像
   imagedestroy($im);
   
?>
