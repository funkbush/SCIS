var stock,sd,ed,server;

var filesize=0;

function $(obj)   //$()定义，简化写法
{
   return document.getElementById(obj);
}

function setDownloaded(fsize) 
{
   $("downloaded").innerHTML=fsize;
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

function check()
{
    document.getElementById("btn").disabled=true; 
	document.getElementById('pro').innerHTML="";//清空表示状态的div
	document.getElementById('res').innerHTML="";//清空叫res的div
	
	document.getElementById("res").style.display="block";
    stock=document.getElementById("stock").value;   
	sd=document.getElementById("sd").value;
	ed=document.getElementById("ed").value;
	server=document.getElementById("server").value;
	
	var timer;   //定时器
	
	var arr=sd.split("-");
    var start=new Date(arr[0],arr[1],arr[2]);
	
	arr=ed.split("-");
    var end=new Date(arr[0],arr[1],arr[2]);
    
	if(start.getTime()>end.getTime())
	{
	   alert("有没搞错??");
	   document.getElementById("btn").disabled=false; 
	}
	else
	{
	/*
	for(i=0;i<10;i++)    //可以创建div!
	{
		var oDiv=document.createElement('div');
		oDiv.id=i;
		document.body.appendChild(oDiv);  //body部分添加节点	
	}  
    */
		var xmlhttp;  //新建一个XHR变量，用于和服务器交换数据  等价于create XMLHttpRequest();
		var data="stock="+encodeURIComponent(stock)+"&server="+encodeURIComponent(server)+"&sd="+encodeURIComponent(sd)+"&ed="+encodeURIComponent(ed);
		
		if(window.XMLHttpRequest)
		{
			xmlhttp=new XMLHttpRequest();  //IE7及以上新的浏览器新建对象
		}
		else
		{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");//IE6、IE5老浏览器新建对象
		}
	
		xmlhttp.onreadystatechange=function() //每当 readyState 属性改变时，就会调用该函数。  
		{
		    
			if(xmlhttp.readyState==2 /*&& xmlhttp.status==200*/)  //如果请求已完成，且响应已就绪
			{
				document.getElementById('pro').innerHTML='Importing.....';
				//document.getElementById('res').innerHTML="";
				timer=setInterval(function(){document.getElementById("res").innerHTML=xmlhttp.responseText;},500);
				
				//document.getElementById("res").innerHTML=xmlhttp.responseText; 			
				//document.getElementById("btn").disabled=false; 
			}
			if(xmlhttp.readyState==4 && xmlhttp.status==200)  //如果请求已完成，且响应已就绪
			{	
				document.getElementById("res").innerHTML=xmlhttp.responseText;
                clearInterval(timer);				
				document.getElementById("btn").disabled=false; 
				document.getElementById('pro').innerHTML = 'Finish!!!';
			}
		} 
		
		xmlhttp.open("POST","yy.php",true);  
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");		
		xmlhttp.send(data);	
	}	
		//centerWindow("yy.php?a=1",' ',700,300).focus();			
}

function centerWindow(url,name,width,height)
{  
    var top=(screen.height-height)/2+50;  
    var left=(screen.width-width)/2;  
    window.open(url,name,'width='+width+',height='+height+',top='+top+',left='+left);  
} 	
