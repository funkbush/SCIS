<?php
function hex2asc($str)   //16进制转2进制 
{
    $str=join('',explode('\x',$str));
	$len=strlen($str);
	for($i=0;$i<$len;$i+=2) 
	{
	    $data.=chr(hexdec(substr($str,$i,2)));
	}
	return $data;
}

//此函数是为了生成那个六位十六进制时间
function get_date($str)
{
    $t1="2000-01-01";  //所有年月日的起始点
    $t2=$str;
  
	$str1=substr($t2,0,4);
	$str2=substr($t2,5,2);
	$str3=substr($t2,8,2);

	$tmp=$str1;
	  
	$str1=dechex(101+($str1-2000)*1296+($str2-1)*100+($str3-1)*1);   //16进制510的10进制是1296 
	$a=substr($str1,0,strlen($str1)-2);
	$str1=substr($str1,strlen($str1)-2,2); 
	 
	$str2=dechex(45+34*($tmp-2000)+hexdec($a));
	$b=substr($str2,0,strlen($str2)-2);
	$str2=substr($str2,strlen($str2)-2,2);
	   
	$str3=dechex(49+hexdec($b));
	   
	return $str1.$str2.$str3;
}	  

/*************************************下面是计算函数****************************************************************************************************/
function calc_qua($str)   //计算数量及价格基准，记住用此函数算价格基准要除以100
{
    $num=strlen($str);
	if($num==2)  //ok!
	{
	   $qua=hexdec($str); 
	}
    if($num==4)  //ok!
	{
	   $qua=(hexdec(substr($str,0,2))-128)+hexdec(substr($str,2,2))*64;
	}
	if($num==6)  //ok!
	{
	   $qua=(hexdec(substr($str,0,2))-128)+(hexdec(substr($str,2,2))-128)*64+hexdec(substr($str,4,2))*8192;
	}
    return $qua;  //返回一个值
}

//**************************************************************
function calc_prioffset($str)  //计算价格偏移
{
    $num=strlen($str);
	if($num==2)  
	{
	   $a=str_pad(decbin(hexdec($str)),8,0,STR_PAD_LEFT);  //ok
	   if(substr($a,1,1)==1)
	   {
	       $prioffset=bindec(substr($a,2,6))*(-1)/100;
	   } 
	   else
	   {
	       $prioffset=hexdec($str)/100;
	   }
	}//ok
    if($num==4) //*************!!!!num==4可以描述目前A股最高股价的单笔最大偏移 
	{
	   $a=str_pad(decbin(hexdec(substr($str,0,2))),8,0,STR_PAD_LEFT);  
	   if(substr($a,1,1)==1)
	   {
	       $prioffset=(bindec(substr($a,2,6))+hexdec(substr($str,2,2))*64)*(-1)/100;
	   } 
	   else
	   {
	       $prioffset=((hexdec(substr($str,0,2))-128)+hexdec(substr($str,2,2))*64)/100;
	   }
	  
	}//ok
	/*
	if($num==6)  
	{
	   $prioffset=((hexdec(substr($str,0,2))-128)+(hexdec(substr($str,2,2))-128)*64+hexdec(substr($str,4,2))*8192)/100;
	}
	*/
    return $prioffset;	//返回一个值
}

//**************************************************************

function get_time($str)    //ok!得到计算时间
{
   $a=substr($str,0,4);
   if(substr($a,3,1)==2)
   {
      $b=hexdec(substr($a,0,2))-58;
	  
	  $hour=(string)floor((570+$b)/60);
	  $min=(string)((570+$b)-floor((570+$b)/60)*60);
   }
   if(substr($a,3,1)==3)
   {
      $b=hexdec(substr($a,0,2))-12;
	  
	  $hour=(string)floor((780+$b)/60);
	  $min=(string)((780+$b)-floor((780+$b)/60)*60);
   }
   $time=str_pad($hour,2,0,STR_PAD_LEFT).":".str_pad($min,2,0,STR_PAD_LEFT);
   return $time;
}

function get_pro($str)  //ok!得到交易方向哦
{
    $a=substr($str,-3,1);
	if($a==0)
	{
	   return "B";
	}
	if($a==1)
	{
	   return "S";
	}
}

//*********************************************************
//基准价格最小四位，最大六位,价格偏移最小两位，最大四位，数量最小两位，最大六位

function get_priqua($str)    //求价格偏移量和数量   
{
    $str=substr($str,4,strlen($str)-8); //str取值为中间数据段
	$num=strlen($str);
	if($num==4)  //ok!
	{
	   $prioffset=calc_prioffset(substr($str,0,2));
	   $qua=calc_qua(substr($str,2,2));
	}
	if($num==6)  //ok!
	{
	   if(hexdec(substr($str,2,2))>=128)
	   { 
	       $prioffset=calc_prioffset(substr($str,0,2));
	       $qua=calc_qua(substr($str,2,4));
	   }
	   else
	   {
	       $prioffset=calc_prioffset(substr($str,0,4));
	       $qua=calc_qua(substr($str,4,2));
	   }
	}
	
	if($num==8)  //ok!
	{
	   if(hexdec(substr($str,2,2))>=128)
	   { 
	       $prioffset=calc_prioffset(substr($str,0,2));
	       $qua=calc_qua(substr($str,2,6));
	   }
	   else
	   {
	       $prioffset=calc_prioffset(substr($str,0,4));
	       $qua=calc_qua(substr($str,4,4));
	   }
	}
	if($num==10)  //ok!
	{
	   $prioffset=calc_prioffset(substr($str,0,4));
	   $qua=calc_qua(substr($str,4,6)); 
	}
	
	$arr=array($prioffset,$qua);
	return $arr;
	
}
//**************************************************************

//*****************************************************************************************
//基准价格最小两位，最大六位,价格偏移最小两位，最大四位，数量最小两位，最大六位

function get_prifou($str)   //求价格基数和数量
{
    $str=substr($str,4,strlen($str)-8);  //str取值为中间数据段
	$num=strlen($str);
	
    if($num==4)  //ok!
	{
	   $prifou=calc_qua(substr($str,0,2))/100;  //求价格基数用求数量函数除以100
	   $qua=calc_qua(substr($str,2,2));
	}
	if($num==6)  //ok!
	{
	   if(hexdec(substr($str,2,2))>=128)
	   { 
	       $prifou=calc_qua(substr($str,0,2))/100;
	       $qua=calc_qua(substr($str,2,4));
	   }
	   else
	   {
	       $prifou=calc_qua(substr($str,0,4))/100;
	       $qua=calc_qua(substr($str,4,2));
	   }
	}
	if($num==8) 
	{
	   if(hexdec(substr($str,2,2))>=128 && hexdec(substr($str,4,2))>=128)  //ok  
	   { 
	       $prifou=calc_qua(substr($str,0,2))/100;
	       $qua=calc_qua(substr($str,2,6));
	   }
	   elseif(hexdec(substr($str,0,2))>=128 && hexdec(substr($str,2,2))>=128)//ok
	   {
	       $prifou=calc_qua(substr($str,0,6))/100;
	       $qua=calc_qua(substr($str,6,2));
	   }
	   else  //ok
	   {
	       $prifou=calc_qua(substr($str,0,4))/100;
	       $qua=calc_qua(substr($str,4,4));
	   }
	}
	if($num==10)  //????????????????有问题
	{
	   if(hexdec(substr($str,0,2))>=128 && hexdec(substr($str,2,2))>=128)
	   { 
	       $prifou=calc_qua(substr($str,0,6))/100;
	       $qua=calc_qua(substr($str,6,4));
	   }
	   else
	   {
	       $prifou=calc_qua(substr($str,0,4))/100;
	       $qua=calc_qua(substr($str,4,6)); 
	   }
	}

	if($num==12)  //ok!
	{
	   $prifou=calc_qua(substr($str,0,6))/100;
	   $qua=calc_qua(substr($str,6,6)); 
	}
	$arr=array($prifou,$qua);
	return $arr;
	
}

//******************************************************************

?>