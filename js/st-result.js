var k,a
var filesize=0;
function $(obj)   //$()定义，简化写法
{
   return document.getElementById(obj);
}

//设置已经下载的,并计算百分比
function setDownloaded(fsize,filesize) 
{
   if(filesize>0) 
   {
       var percent=Math.round(fsize*100/filesize);
       $("progressbar").style.width=(percent+"%");
   
       if(percent>0) 
       {
            $("progressbar").innerHTML=percent+"%";
            $("progressText").innerHTML="";
       } 
       else 
       {
            $("progressText").innerHTML=percent+"%";
       }
    }
}
//setDownloaded(31,100);
/*
function process()
{
	document.getElementById('res').innerHTML="";//清空叫res的div	
	
	var timer;   //定时器
	
	var xmlhttp;  //新建一个XHR变量，用于和服务器交换数据  等价于create XMLHttpRequest();
	var data="k="+encodeURIComponent(k)+"&a="+encodeURIComponent(a);
	//alert(data);
		
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
			if(xmlhttp.readyState==2)  //如果刚好开始发送（状态2）
			{
				document.getElementById('res').innerHTML="";
				//timer=setInterval(function(){document.getElementById("res").innerHTML=xmlhttp.responseText;},500);//创建计时器
			}
			
            if(xmlhttp.readyState==4 && xmlhttp.status==200)  //如果请求已完成（状态4），且响应已就绪
	        {
                document.getElementById("res").innerText=xmlhttp.responseText;
                //clearInterval(timer);   //清掉计时器							
	        }
        }
		
		xmlhttp.open("POST","st-jdt.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send(data);	
        	
			
    }			
}
*/	
//process();