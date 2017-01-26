function check()
{
  if(document.form1.user.value=="")
  {   
      alert("请输入用户名!")
	  document.form1.user.focus();
	  return false;
  }	  
	  
  if(document.form1.txtvcode.value=="")
  {
      alert("请输入验证码!\n验证码看不清按F5。");
	  document.form1.txtvcode.focus();
	  return false;
  }		   
}
   //####################################################################################################
function getcode()   //点击图片重新获取验证码    可以！
{
	/*	if(!xmlhttp)    //若没有XHR对象则建一个
		{  
		    xmlhttp=createXHR();
		}*/
		
	var xmlhttp;  //新建一个XHR变量，用于和服务器交换数据

    if(window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();  //IE7及以上新的浏览器新建对象
    }
    else
    {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");//IE6、IE5老浏览器新建对象
    }
		
    xmlhttp.onreadystatechange=function()
    {
        if(xmlhttp.readyState==4 && xmlhttp.status==200)  //如果请求已完成，且响应已就绪
	    {
	        document.getElementById('vcode').src='vcode.php?'+Math.random();	 
	    }
    } 
		
		xmlhttp.open("POST","admin_checklogin.php",true);   
		//xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");  //这一行不能加，加了会出错，原因待考
        xmlhttp.send();  
}
    //####################################################################################################
function createXHR()
{
    var xmlhttp;  //新建一个XHR变量，用于和服务器交换数据

    if(window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();  //IE7及以上新的浏览器新建对象
    }
    else
    {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");//IE6、IE5老浏览器新建对象
    }
 }
   