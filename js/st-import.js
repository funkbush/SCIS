var stock,sd,ed,server;

function check()
{
	document.getElementById("btn").disabled=true;
    document.getElementById('pro').innerHTML="";//清空表示状态的div
	document.getElementById('res').innerHTML="";//清空叫res的div
    $("progressbar").style.width=0;
	$("progressText").innerHTML="0%";   //清空进度条
    	
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
		var xmlhttp;  //新建一个XHR变量，用于和服务器交换数据  等价于create XMLHttpRequest();
		var data="stock="+encodeURIComponent(stock)+"&server="+encodeURIComponent(server)+"&sd="+encodeURIComponent(sd)+"&ed="+encodeURIComponent(ed);
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
				document.getElementById('pro').innerHTML='Importing.....';
				//document.getElementById('res').innerHTML="";
				timer=setInterval(function(){document.getElementById("res").innerHTML=xmlhttp.responseText;setDownloaded(grb(),(gtt(sd,ed)+1));},500);//创建计时器
			    //利用计时器不断刷新div中插入的内容和进度条
			}
			
            if(xmlhttp.readyState==4 && xmlhttp.status==200)  //如果请求已完成（状态4），且响应已就绪
	        {
                document.getElementById("res").innerHTML=xmlhttp.responseText;
				setDownloaded(grb(),(gtt(sd,ed)+1));   //最终刷新div中插入的内容和进度条
                clearInterval(timer);   //清掉计时器				
				document.getElementById("btn").disabled=false; 
				
				if(grb()/(gtt(sd,ed)+1)==1)
				{
				    document.getElementById('pro').innerHTML='Import Finish!!!';				
				}
                else
                {
					var errdate=new Date(Date.parse(sd)+(grb()-1)*3600*24*1000).Format("yyyy-MM-dd");   //出错的日期
					$('pro').innerHTML="Import this day "+errdate+" Error....";
					
					$('sd').onFocus=MyCalendar.SetDate;   //设置sd为出错日期
					$('sd').value=errdate;
					$("btn").disabled=true;   //获取按键变灰
					
					var oA=document.createElement('a');   //创建a标签
					oA.href='#';    //增加a标签的href属性
					oA.onclick=check;
					oA.innerHTML="Click Me to Continue.";   //给a标签添加内容
					$('pro').appendChild(oA);  //将a标签添加到div里面
				}					
	        }
        }
		
		xmlhttp.open("POST","st-result.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		//xmlhttp.open("GET","st-result.php?stock="+stock+"&server="+server+"&sd="+sd+"&ed="+ed,true);  
		//xmlhttp.send();
        xmlhttp.send(data);			
    }			
}

function fuck()
{
	alert("xxx");
}

function $(obj)   //$()定义，简化写法
{
   return document.getElementById(obj);
}

//文件长度
var filesize=0;
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

function gtt($time1,$time2)   //计算两日期间的差
{
    var time1=arguments[0],time2=arguments[1];  //每一个函数都有自己的argument属性。下面我们来看看argument属性：为当前执行的 function 对象返回一个arguments 对象，function 参数是当前执行函数的名称，可以省略。
    time1=Date.parse(time1)/1000;  //把指定格式时间转毫秒,/1000变成秒
    time2=Date.parse(time2)/1000;
    var time_=time2-time1;
    return(time_/(3600*24));
}

function grb()   //取得叫res的元素中回车<br>的个数
{ 
	var inplen=$("res").getElementsByTagName("br").length ;
	return inplen;
}

// 对Date的扩展，将 Date 转化为指定格式的String   
// 月(M)、日(d)、小时(h)、分(m)、秒(s)、季度(q) 可以用 1-2 个占位符，   
// 年(y)可以用 1-4 个占位符，毫秒(S)只能用 1 个占位符(是 1-3 位的数字)   
// 例子：   
// (new Date()).Format("yyyy-MM-dd hh:mm:ss.S") ==> 2006-07-02 08:09:04.423   
// (new Date()).Format("yyyy-M-d h:m:s.S")      ==> 2006-7-2 8:9:4.18   
Date.prototype.Format=function(fmt)     //定义Date Format
{ //author: meizz   
  var o=
  {   
    "M+" : this.getMonth()+1,                 //月份   
    "d+" : this.getDate(),                    //日   
    "h+" : this.getHours(),                   //小时   
    "m+" : this.getMinutes(),                 //分   
    "s+" : this.getSeconds(),                 //秒   
    "q+" : Math.floor((this.getMonth()+3)/3), //季度   
    "S"  : this.getMilliseconds()             //毫秒   
  };   
  if(/(y+)/.test(fmt))   
    fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));   
  for(var k in o)   
    if(new RegExp("("+ k +")").test(fmt))   
  fmt=fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));   
  return fmt;   
}
/*
function setSelectOption(objId,targetValue)
{//objid：下拉列表框的ID；targetValue：当前所选值 
	var obj=document.getElementById(objId); 
	if(obj)
	{  var options=obj.options;  
		if(options)
		{   var len=options.length;   
			for(var i=0;i<len;i++)
			{    
				if(options[i].value==targetValue)
				{     
					options[i].defaultSelected=true;     
					options[i].selected=true;     
					return true;    
				}   
			}  
		} 
		else 
		{   
			alert('missing element(s)!');  
		} 
	} 
	else 
	{  
		alert('missing element(s)!'); 
	}
}
*/
//setDownloaded(kkk(),(gtt(sd,ed)+1));