var stock,sd,ed;

function check()
{
    document.getElementById("res").style.display="block";
    stock=document.getElementById("stock").value;   
	sd=document.getElementById("sd").value;
	ed=document.getElementById("ed").value;
	
	var arr=sd.split("-");
    var start=new Date(arr[0],arr[1],arr[2]);
	
	arr=ed.split("-");
    var end=new Date(arr[0],arr[1],arr[2]);
    
	if(start.getTime()>end.getTime())
	{
	   alert("有没搞错??");
	}
	else
	{
	   document.getElementById('res').src="st-hys.php?stock="+stock+"&sd="+sd+"&ed="+ed;
	                                       
	}
	//alert(stock+sd+ed);
	/*
	else
	{
		var xmlhttp;  //新建一个XHR变量，用于和服务器交换数据  等价于create XMLHttpRequest();
		
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
                document.getElementById("res").innerHTML=xmlhttp.responseText; 			
	        }
        } 
		
		    xmlhttp.open("GET","st-result.php?stock="+stock+"&sd="+sd+"&ed="+ed,true);   
		    //xmlhttp.setRequestHeader("Content-type","application"/x-www-form-urlencoded);  //这一行不能加，加了会出错，原因待考
            xmlhttp.send();	

    			
    }*/			
}
	
