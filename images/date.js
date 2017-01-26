



//==================================================== 参数设定部分 =======================================================
var bMoveable=true;  //设置日历是否可以拖动
var _VersionInfo="www.zuoyefeng.com view date" //版本信息

//==================================================== WEB 页面显示部分 =====================================================
var strFrame;  //存放日历层的HTML代码
document.writeln('<iframe id=meizzDateLayer Author=wayx frameborder=0 style="position: absolute; width: 144; height: 211; z-index: 9998; display: none"></iframe>');
strFrame='<style>';
strFrame+='INPUT.button{BORDER-RIGHT: #ff9900 1px solid;BORDER-TOP: #ff9900 1px solid;BORDER-LEFT: #ff9900 1px solid;';
strFrame+='BORDER-BOTTOM: #ff9900 1px solid;BACKGROUND-COLOR: #fff8ec;font-family:宋体;}';
strFrame+='TD{FONT-SIZE: 9pt;font-family:宋体;}';
strFrame+='</style>';
strFrame+='<scr' + 'ipt>';
strFrame+='var datelayerx,datelayery; /*存放日历控件的鼠标位置*/';
strFrame+='var bDrag; /*标记是否开始拖动*/';
strFrame+='function document.onmousemove() /*在鼠标移动事件中，如果开始拖动日历，则移动日历*/';
strFrame+='{if(bDrag && window.event.button==1)';
strFrame+=' {var DateLayer=parent.document.all.meizzDateLayer.style;';
strFrame+='  DateLayer.posLeft += window.event.clientX-datelayerx;/*由于每次移动以后鼠标位置都恢复为初始的位置，因此写法与div中不同*/';
strFrame+='  DateLayer.posTop += window.event.clientY-datelayery;}}';
strFrame+='function DragStart()  /*开始日历拖动*/';
strFrame+='{var DateLayer=parent.document.all.meizzDateLayer.style;';
strFrame+=' datelayerx=window.event.clientX;';
strFrame+=' datelayery=window.event.clientY;';
strFrame+=' bDrag=true;}';
strFrame+='function DragEnd(){  /*结束日历拖动*/';
strFrame+=' bDrag=false;}';
strFrame+='</scr' + 'ipt>';
strFrame+='<div style="z-index:9999;position: absolute; left:0; top:0;" onselectstart="return false"><span id=tmpSelectYearLayer Author=wayx style="z-index: 9999;position: absolute;top: 3; left: 19;display: none"></span>';
strFrame+='<span id=tmpSelectMonthLayer Author=wayx style="z-index: 9999;position: absolute;top: 3; left: 78;display: none"></span>';
strFrame+='<table border=1 cellspacing=0 cellpadding=0 width=142 height=160 bordercolor=#ff9900 bgcolor=#ff9900 Author="wayx">';
strFrame+='  <tr Author="wayx"><td width=142 height=23 Author="wayx" bgcolor=#FFFFFF><table border=0 cellspacing=1 cellpadding=0 width=140 Author="wayx" height=23>';
strFrame+='      <tr align=center Author="wayx"><td width=16 align=center bgcolor=#ff9900 style="font-size:12px;cursor: hand;color: #ffffff" ';
strFrame+='        onclick="parent.meizzPrevM()" title="向前翻 1 月" Author=meizz><b Author=meizz>&lt;</b>';
strFrame+='        </td><td width=60 align=center style="font-size:12px;cursor:default" Author=meizz ';
strFrame+='onmouseover="style.backgroundColor=\'#FFD700\'" onmouseout="style.backgroundColor=\'white\'" ';
strFrame+='onclick="parent.tmpSelectYearInnerHTML(this.innerText.substring(0,4))" title="点击这里选择年份"><span Author=meizz id=meizzYearHead></span></td>';
strFrame+='<td width=48 align=center style="font-size:12px;cursor:default" Author=meizz onmouseover="style.backgroundColor=\'#FFD700\'" ';
strFrame+=' onmouseout="style.backgroundColor=\'white\'" onclick="parent.tmpSelectMonthInnerHTML(this.innerText.length==3?this.innerText.substring(0,1):this.innerText.substring(0,2))"';
strFrame+='        title="点击这里选择月份"><span id=meizzMonthHead Author=meizz></span></td>';
strFrame+='        <td width=16 bgcolor=#ff9900 align=center style="font-size:12px;cursor: hand;color: #ffffff" ';
strFrame+='         onclick="parent.meizzNextM()" title="向后翻 1 月" Author=meizz><b Author=meizz>&gt;</b></td></tr>';
strFrame+='    </table></td></tr>';
strFrame+='  <tr Author="wayx"><td width=142 height=18 Author="wayx">';
strFrame+='<table border=1 cellspacing=0 cellpadding=0 bgcolor=#ff9900 ' + (bMoveable? 'onmousedown="DragStart()" onmouseup="DragEnd()"':'');
strFrame+=' BORDERCOLORLIGHT=#FF9900 BORDERCOLORDARK=#FFFFFF width=140 height=20 Author="wayx" style="cursor:' + (bMoveable ? 'move':'default') + '">';
strFrame+='<tr Author="wayx" align=center valign=bottom><td style="font-size:12px;color:#FFFFFF" Author=meizz>日</td>';
strFrame+='<td style="font-size:12px;color:#FFFFFF" Author=meizz>一</td><td style="font-size:12px;color:#FFFFFF" Author=meizz>二</td>';
strFrame+='<td style="font-size:12px;color:#FFFFFF" Author=meizz>三</td><td style="font-size:12px;color:#FFFFFF" Author=meizz>四</td>';
strFrame+='<td style="font-size:12px;color:#FFFFFF" Author=meizz>五</td><td style="font-size:12px;color:#FFFFFF" Author=meizz>六</td></tr>';
strFrame+='</table></td></tr><!-- Author:F.R.Huang(meizz) http://www.meizz.com/ mail: meizz@hzcnc.com 2002-10-8 -->';
strFrame+='  <tr Author="wayx"><td width=142 height=120 Author="wayx">';
strFrame+='    <table border=1 cellspacing=2 cellpadding=0 BORDERCOLORLIGHT=#FF9900 BORDERCOLORDARK=#FFFFFF bgcolor=#fff8ec width=140 height=120 Author="wayx">';
var n=0; for (j=0;j<5;j++){ strFrame+= ' <tr align=center Author="wayx">'; for (i=0;i<7;i++){
strFrame+='<td width=20 height=20 id=meizzDay'+n+' style="font-size:12px" Author=meizz onclick=parent.meizzDayClick(this.innerText,0)></td>';n++;}
strFrame+='</tr>';}
strFrame+='      <tr align=center Author="wayx">';
for (i=35;i<39;i++)strFrame+='<td width=20 height=20 id=meizzDay'+i+' style="font-size:12px" Author=wayx onclick="parent.meizzDayClick(this.innerText,0)"></td>';
strFrame+='        <td colspan=3 align=right Author=meizz><span onclick=parent.closeLayer() style="font-size:12px;cursor: hand"';
strFrame+='         Author=meizz title="' + _VersionInfo + '"><u>关闭</u></span>&nbsp;</td></tr>';
strFrame+='    </table></td></tr><tr Author="wayx"><td Author="wayx">';
strFrame+='        <table border=0 cellspacing=1 cellpadding=0 width=100% Author="wayx" bgcolor=#FFFFFF>';
strFrame+='          <tr Author="wayx"><td Author=meizz align=left><input Author=meizz type=button class=button value="<<" title="向前翻 1 年" onclick="parent.meizzPrevY()" ';
strFrame+='             onfocus="this.blur()" style="font-size: 12px; height: 20px"><input Author=meizz class=button title="向前翻 1 月" type=button ';
strFrame+='             value="< " onclick="parent.meizzPrevM()" onfocus="this.blur()" style="font-size: 12px; height: 20px"></td><td ';
strFrame+='             Author=meizz align=center><input Author=meizz type=button class=button value=Today onclick="parent.meizzToday()" ';
strFrame+='             onfocus="this.blur()" title="当前日期" style="font-size: 12px; height: 20px; cursor:hand"></td><td ';
strFrame+='             Author=meizz align=right><input Author=meizz type=button class=button value=" >" onclick="parent.meizzNextM()" ';
strFrame+='             onfocus="this.blur()" title="向后翻 1 月" class=button style="font-size: 12px; height: 20px"><input ';
strFrame+='             Author=meizz type=button class=button value=">>" title="向后翻 1 年" onclick="parent.meizzNextY()"';
strFrame+='             onfocus="this.blur()" style="font-size: 12px; height: 20px"></td>';
strFrame+='</tr></table></td></tr></table></div>';

window.frames.meizzDateLayer.document.writeln(strFrame);
window.frames.meizzDateLayer.document.close();  //解决ie进度条不结束的问题

//==================================================== WEB 页面显示部分 ======================================================
var outObject;
var outButton;  //点击的按钮
var outDate="";  //存放对象的日期
var odatelayer=window.frames.meizzDateLayer.document.all;  //存放日历对象
function setday(tt,obj) //主调函数
{
 if (arguments.length >  2){alert("对不起！传入本控件的参数太多！");return;}
 if (arguments.length == 0){alert("对不起！您没有传回本控件任何参数！");return;}
 var dads  = document.all.meizzDateLayer.style;
 var th = tt;
 var ttop  = tt.offsetTop;     //TT控件的定位点高
 var thei  = tt.clientHeight;  //TT控件本身的高
 var tleft = tt.offsetLeft;    //TT控件的定位点宽
 var ttyp  = tt.type;          //TT控件的类型
 while (tt = tt.offsetParent){ttop+=tt.offsetTop; tleft+=tt.offsetLeft;}
 dads.top  = (ttyp=="image")? ttop+thei : ttop+thei+6;
 dads.left = tleft;
 outObject = (arguments.length == 1) ? th : obj;
 outButton = (arguments.length == 1) ? null : th; //设定外部点击的按钮
 //根据当前输入框的日期显示日历的年月
 var reg = /^(\d+)-(\d{1,2})-(\d{1,2})$/; 
 var r = outObject.value.match(reg); 
 if(r!=null){
  r[2]=r[2]-1; 
  var d= new Date(r[1], r[2],r[3]); 
  if(d.getFullYear()==r[1] && d.getMonth()==r[2] && d.getDate()==r[3]){
   outDate=d;  //保存外部传入的日期
  }
  else outDate="";
   meizzSetDay(r[1],r[2]+1);
 }
 else{
  outDate="";
  meizzSetDay(new Date().getFullYear(), new Date().getMonth() + 1);
 }
 dads.display = '';

 event.returnValue=false;
}

var MonHead = new Array(12);         //定义阳历中每个月的最大天数
    MonHead[0] = 31; MonHead[1] = 28; MonHead[2] = 31; MonHead[3] = 30; MonHead[4]  = 31; MonHead[5]  = 30;
    MonHead[6] = 31; MonHead[7] = 31; MonHead[8] = 30; MonHead[9] = 31; MonHead[10] = 30; MonHead[11] = 31;

var meizzTheYear=new Date().getFullYear(); //定义年的变量的初始值
var meizzTheMonth=new Date().getMonth()+1; //定义月的变量的初始值
var meizzWDay=new Array(39);               //定义写日期的数组

function document.onclick() //任意点击时关闭该控件 //ie6的情况可以由下面的切换焦点处理代替
{ 
  with(window.event)
  { if (srcElement.getAttribute("Author")==null && srcElement != outObject && srcElement != outButton)
    closeLayer();
  }
}

function document.onkeyup()  //按Esc键关闭，切换焦点关闭
  {
    if (window.event.keyCode==27){
  if(outObject)outObject.blur();
  closeLayer();
 }
 else if(document.activeElement)
  if(document.activeElement.getAttribute("Author")==null && document.activeElement != outObject && document.activeElement != outButton)
  {
   closeLayer();
  }
  }

function meizzWriteHead(yy,mm)  //往 head 中写入当前的年与月
  {
 odatelayer.meizzYearHead.innerText  = yy + " 年";
    odatelayer.meizzMonthHead.innerText = mm + " 月";
  }

function tmpSelectYearInnerHTML(strYear) //年份的下拉框
{
  if (strYear.match(/\D/)!=null){alert("年份输入参数不是数字！");return;}
  var m = (strYear) ? strYear : new Date().getFullYear();
  if (m < 1000 || m > 9999) {alert("年份值不在 1000 到 9999 之间！");return;}
  var n = m - 10;
  if (n < 1000) n = 1000;
  if (n + 26 > 9999) n = 9974;
  var s = "<select Author=meizz name=tmpSelectYear style='font-size: 12px' "
     s += "onblur='document.all.tmpSelectYearLayer.style.display=\"none\"' "
     s += "onchange='document.all.tmpSelectYearLayer.style.display=\"none\";"
     s += "parent.meizzTheYear = this.value; parent.meizzSetDay(parent.meizzTheYear,parent.meizzTheMonth)'>\r\n";
  var selectInnerHTML = s;
  for (var i = n; i < n + 26; i++)
  {
    if (i == m)
       {selectInnerHTML += "<option Author=wayx value='" + i + "' selected>" + i + "年" + "</option>\r\n";}
    else {selectInnerHTML += "<option Author=wayx value='" + i + "'>" + i + "年" + "</option>\r\n";}
  }
  selectInnerHTML += "</select>";
  odatelayer.tmpSelectYearLayer.style.display="";
  odatelayer.tmpSelectYearLayer.innerHTML = selectInnerHTML;
  odatelayer.tmpSelectYear.focus();
}

function tmpSelectMonthInnerHTML(strMonth) //月份的下拉框
{
  if (strMonth.match(/\D/)!=null){alert("月份输入参数不是数字！");return;}
  var m = (strMonth) ? strMonth : new Date().getMonth() + 1;
  var s = "<select Author=meizz name=tmpSelectMonth style='font-size: 12px' "
     s += "onblur='document.all.tmpSelectMonthLayer.style.display=\"none\"' "
     s += "onchange='document.all.tmpSelectMonthLayer.style.display=\"none\";"
     s += "parent.meizzTheMonth = this.value; parent.meizzSetDay(parent.meizzTheYear,parent.meizzTheMonth)'>\r\n";
  var selectInnerHTML = s;
  for (var i = 1; i < 13; i++)
  {
    if (i == m)
       {selectInnerHTML += "<option Author=wayx value='"+i+"' selected>"+i+"月"+"</option>\r\n";}
    else {selectInnerHTML += "<option Author=wayx value='"+i+"'>"+i+"月"+"</option>\r\n";}
  }
  selectInnerHTML += "</select>";
  odatelayer.tmpSelectMonthLayer.style.display="";
  odatelayer.tmpSelectMonthLayer.innerHTML = selectInnerHTML;
  odatelayer.tmpSelectMonth.focus();
}

function closeLayer()               //这个层的关闭
  {
    document.all.meizzDateLayer.style.display="none";
  }

function IsPinYear(year)            //判断是否闰平年
  {
    if (0==year%4&&((year%100!=0)||(year%400==0))) return true;else return false;
  }

function GetMonthCount(year,month)  //闰年二月为29天
  {
    var c=MonHead[month-1];if((month==2)&&IsPinYear(year)) c++;return c;
  }
function GetDOW(day,month,year)     //求某天的星期几
  {
    var dt=new Date(year,month-1,day).getDay()/7; return dt;
  }

function meizzPrevY()  //往前翻 Year
  {
    if(meizzTheYear > 999 && meizzTheYear <10000){meizzTheYear--;}
    else{alert("年份超出范围（1000-9999）！");}
    meizzSetDay(meizzTheYear,meizzTheMonth);
  }
function meizzNextY()  //往后翻 Year
  {
    if(meizzTheYear > 999 && meizzTheYear <10000){meizzTheYear++;}
    else{alert("年份超出范围（1000-9999）！");}
    meizzSetDay(meizzTheYear,meizzTheMonth);
  }
function meizzToday()  //Today Button
  {
 var today;
    meizzTheYear = new Date().getFullYear();
    meizzTheMonth = new Date().getMonth()+1;
    today=new Date().getDate();
    //meizzSetDay(meizzTheYear,meizzTheMonth);
    if(outObject){
  outObject.value=meizzTheYear + "-" + meizzTheMonth + "-" + today;
    }
    closeLayer();
  }
function meizzPrevM()  //往前翻月份
  {
    if(meizzTheMonth>1){meizzTheMonth--}else{meizzTheYear--;meizzTheMonth=12;}
    meizzSetDay(meizzTheYear,meizzTheMonth);
  }
function meizzNextM()  //往后翻月份
  {
    if(meizzTheMonth==12){meizzTheYear++;meizzTheMonth=1}else{meizzTheMonth++}
    meizzSetDay(meizzTheYear,meizzTheMonth);
  }

function meizzSetDay(yy,mm)   //主要的写程序**********
{
  meizzWriteHead(yy,mm);
  //设置当前年月的公共变量为传入值
  meizzTheYear=yy;
  meizzTheMonth=mm;
  
  for (var i = 0; i < 39; i++){meizzWDay[i]=""};  //将显示框的内容全部清空
  var day1 = 1,day2=1,firstday = new Date(yy,mm-1,1).getDay();  //某月第一天的星期几
  for (i=0;i<firstday;i++)meizzWDay[i]=GetMonthCount(mm==1?yy-1:yy,mm==1?12:mm-1)-firstday+i+1 //上个月的最后几天
  for (i = firstday; day1 < GetMonthCount(yy,mm)+1; i++){meizzWDay[i]=day1;day1++;}
  for (i=firstday+GetMonthCount(yy,mm);i<39;i++){meizzWDay[i]=day2;day2++}
  for (i = 0; i < 39; i++)
  { var da = eval("odatelayer.meizzDay"+i)     //书写新的一个月的日期星期排列
    if (meizzWDay[i]!="")
      { 
  //初始化边框
  da.borderColorLight="#FF9900";
  da.borderColorDark="#FFFFFF";
  if(i<firstday)  //上个月的部分
  {
   da.innerHTML="<b><font color=gray>" + meizzWDay[i] + "</font></b>";
   da.title=(mm==1?12:mm-1) +"月" + meizzWDay[i] + "日";
   da.onclick=Function("meizzDayClick(this.innerText,-1)");
   if(!outDate)
    da.style.backgroundColor = ((mm==1?yy-1:yy) == new Date().getFullYear() && 
     (mm==1?12:mm-1) == new Date().getMonth()+1 && meizzWDay[i] == new Date().getDate()) ?
      "#FFD700":"#e0e0e0";
   else
   {
    da.style.backgroundColor =((mm==1?yy-1:yy)==outDate.getFullYear() && (mm==1?12:mm-1)== outDate.getMonth() + 1 && 
    meizzWDay[i]==outDate.getDate())? "#00ffff" :
    (((mm==1?yy-1:yy) == new Date().getFullYear() && (mm==1?12:mm-1) == new Date().getMonth()+1 && 
    meizzWDay[i] == new Date().getDate()) ? "#FFD700":"#e0e0e0");
    //将选中的日期显示为凹下去
    if((mm==1?yy-1:yy)==outDate.getFullYear() && (mm==1?12:mm-1)== outDate.getMonth() + 1 && 
    meizzWDay[i]==outDate.getDate())
    {
     da.borderColorLight="#FFFFFF";
     da.borderColorDark="#FF9900";
    }
   }
  }
  else if (i>=firstday+GetMonthCount(yy,mm))  //下个月的部分
  {
   da.innerHTML="<b><font color=gray>" + meizzWDay[i] + "</font></b>";
   da.title=(mm==12?1:mm+1) +"月" + meizzWDay[i] + "日";
   da.onclick=Function("meizzDayClick(this.innerText,1)");
   if(!outDate)
    da.style.backgroundColor = ((mm==12?yy+1:yy) == new Date().getFullYear() && 
     (mm==12?1:mm+1) == new Date().getMonth()+1 && meizzWDay[i] == new Date().getDate()) ?
      "#FFD700":"#e0e0e0";
   else
   {
    da.style.backgroundColor =((mm==12?yy+1:yy)==outDate.getFullYear() && (mm==12?1:mm+1)== outDate.getMonth() + 1 && 
    meizzWDay[i]==outDate.getDate())? "#00ffff" :
    (((mm==12?yy+1:yy) == new Date().getFullYear() && (mm==12?1:mm+1) == new Date().getMonth()+1 && 
    meizzWDay[i] == new Date().getDate()) ? "#FFD700":"#e0e0e0");
    //将选中的日期显示为凹下去
    if((mm==12?yy+1:yy)==outDate.getFullYear() && (mm==12?1:mm+1)== outDate.getMonth() + 1 && 
    meizzWDay[i]==outDate.getDate())
    {
     da.borderColorLight="#FFFFFF";
     da.borderColorDark="#FF9900";
    }
   }
  }
  else  //本月的部分
  {
   da.innerHTML="<b>" + meizzWDay[i] + "</b>";
   da.title=mm +"月" + meizzWDay[i] + "日";
   da.onclick=Function("meizzDayClick(this.innerText,0)");  //给td赋予onclick事件的处理
   //如果是当前选择的日期，则显示亮蓝色的背景；如果是当前日期，则显示暗黄色背景
   if(!outDate)
    da.style.backgroundColor = (yy == new Date().getFullYear() && mm == new Date().getMonth()+1 && meizzWDay[i] == new Date().getDate())?
     "#FFD700":"#e0e0e0";
   else
   {
    da.style.backgroundColor =(yy==outDate.getFullYear() && mm== outDate.getMonth() + 1 && meizzWDay[i]==outDate.getDate())?
     "#00ffff":((yy == new Date().getFullYear() && mm == new Date().getMonth()+1 && meizzWDay[i] == new Date().getDate())?
     "#FFD700":"#e0e0e0");
    //将选中的日期显示为凹下去
    if(yy==outDate.getFullYear() && mm== outDate.getMonth() + 1 && meizzWDay[i]==outDate.getDate())
    {
     da.borderColorLight="#FFFFFF";
     da.borderColorDark="#FF9900";
    }
   }
  }
        da.style.cursor="hand"
      }
    else{da.innerHTML="";da.style.backgroundColor="";da.style.cursor="default"}
  }
}

function meizzDayClick(n,ex)  //点击显示框选取日期，主输入函数*************
{
  var yy=meizzTheYear;
  var mm = parseInt(meizzTheMonth)+ex; //ex表示偏移量，用于选择上个月份和下个月份的日期
 //判断月份，并进行对应的处理
 if(mm<1){
  yy--;
  mm=12+mm;
 }
 else if(mm>12){
  yy++;
  mm=mm-12;
 }
 
  if (mm < 10){mm = "0" + mm;}
  if (outObject)
  {
    if (!n) {//outObject.value=""; 
      return;}
    if ( n < 10){n = "0" + n;}
    outObject.value= yy + "-" + mm + "-" + n ; //注：在这里你可以输出改成你想要的格式
    closeLayer(); 
  }
  else {closeLayer(); alert("您所要输出的控件对象并不存在！");}
}
 
 


//生成js


var m_iDatePickerCount=0;
var cl_dpMaxYear=9999;
var cl_dpMaxMonth=11;
var cl_dpMaxDay=31;
var cl_dpMinYear=1800;
var cl_dpMinMonth=0;
var cl_dpMinDay=1;

function createDTPicker(txtName, dateStr) {
	var aDate = new Array();
	aDate = dateStr.split("-");
	createDatePicker(txtName, aDate[0], aDate[1], aDate[2]);
}

function createDatePicker(txtName,lYear,lMonth,lDay)
{
	var dpID="dp_"+(m_iDatePickerCount++);
	var dt=dp_getValidDate(lYear,lMonth,lDay);
	if(dt==null)
		dt=new Date();

	document.write("<span class=DPFrame id="+dpID+">");
	document.write("<input class=DPYear type=text value="+dt.getFullYear()+" size=4 maxlength=4 onfocus=\"return dp_focus('year');\" onblur=\"return dp_blur('year');\" onkeypress=\"return KeyFilter('number');\" onkeydown=\"return dp_keyDown('year');\">");
	document.write("<font class=DPYearDes>年</font>");
	document.write("<input class=DPMonth type=text value="+(dt.getMonth()+1)+" size=2 maxlength=2 onfocus=\"return dp_focus('month');\" onblur=\"return dp_blur('month');\" onkeypress=\"return KeyFilter('number');\" onkeydown=\"return dp_keyDown('month');\">");
	document.write("<font class=DPMonthDes>月</font>");
	document.write("<input class=DPDay type=text value="+dt.getDate()+" size=2 maxlength=2 onfocus=\"return dp_focus('day');\" onblur=\"return dp_blur('day');\" onkeypress=\"return KeyFilter('number');\" onkeydown=\"return dp_keyDown('day');\">");
	document.write("<font class=DPDayDes>日</font>");
	document.write("<span class=DPSep></span>");
	document.write("<a class=DPDropBtn href=\"\" onclick=\"dp_DropClick();return false;\" title=\"选择日期\">▼</a>");
	if(typeof(txtName)=="string" && txtName.length>0)
	{
		document.write("<input type=hidden value='"+dt.format("yyyy.mm.dd")+"'  id=Edit_"+txtName+" name="+txtName+">");
	}
	document.write("</span>");

	var dp=document.all(dpID);
	dp_initDatePicker(dp,dt);
	return dp;
}

function dp_getValidDate(lYear,lMonth,lDay)
{
	var dt=new Date();
	if(lYear==null || isNaN(parseInt(lYear,10)))
		lYear=dt.getFullYear();
	else
		lYear=parseInt(lYear,10);

	if(lMonth==null || isNaN(parseInt(lMonth,10)))
		lMonth=dt.getMonth();
	else
		lMonth=parseInt(lMonth,10)-1;

	if(lDay==null || isNaN(parseInt(lDay,10)))
		lDay=dt.getDate();
	else
		lDay=parseInt(lDay,10);

	dt=new Date(lYear,lMonth,lDay);
	var cdMax=new Date(cl_dpMaxYear,cl_dpMaxMonth,cl_dpMaxDay);
	var cdMin=new Date(cl_dpMinYear,cl_dpMinMonth,cl_dpMinDay);
	if(dt.compare(cdMax)>0 || dt.compare(cdMin)<0)
		dt=null;
	return dt;
}

function dp_initDatePicker(dp,dt)
{
	if(dp)
	{
		//Private Property
		dp.curDate=dt;
		dp.dpEnabled=true;
		dp.maxDay=cl_dpMaxDay;
		dp.maxMonth=cl_dpMaxMonth;
		dp.maxYear=cl_dpMaxYear;
		dp.minDay=cl_dpMinDay;
		dp.minMonth=cl_dpMinMonth;
		dp.minYear=cl_dpMinYear;
		dp.oldDate=dt.clone();

		//Private Method
		dp.getDropDownTable=dp_getDropDownTable;
		dp.getMonthName=dp_getMonthName;
		dp.hideDropDown=dp_hideDropDown;
		dp.initDropDown=dp_initDropDown;
		dp.onDateChange=dp_onDateChange;
		dp.refreshPostText=dp_refreshPostText;
		dp.showDropDown=dp_showDropDown;

		//Public Property
		//All Span Properties can be used;
		dp.offsetHor=0;

		//Public Method
		dp.setFocus=dp_setFocus;
		dp.format=dp_format;
		dp.getDateContent=dp_getDateContent;
		dp.getDay=dp_getDay;
		dp.getEnabled=dp_getEnabled;
		dp.getMonth=dp_getMonth;
		dp.getYear=dp_getYear;
		dp.refreshView=dp_refreshView;
		dp.setAccessKey=dp_setAccessKey;
		dp.setCurDate=dp_setCurDate;
		dp.setDateDes=dp_setDateDes;
		dp.setEnabled=dp_setEnabled;
		dp.setFormat=dp_setFormat;
		dp.setMaxDate=dp_setMaxDate;
		dp.setMinDate=dp_setMinDate;
		dp.setTabIndex=dp_setTabIndex;
		dp.setWeekName=dp_setWeekName;

		//Event
		dp.dateChanged=null;

		//Init View
		dp.refreshView();
	}
}

function dp_createDropDown()
{
	var ddt=getDropDownTable();
	if(ddt)
		return ddt;
	document.body.insertAdjacentHTML("BeforeEnd",
					"<TABLE id=dpDropDownTable CELLSPACING=0 "+
					"onclick=\"dp_ddt_click();\" "+
					"ondblclick=\"dp_ddt_dblclick();\">"+
					"<TR class=DPTitle>"+
					"<TD><span class=DPBtn onclick=\"dp_monthChange(-1);\" title=\"上月\">《</span></TD>"+
					"<TD align=center colspan=5></TD>"+
					"<TD><span class=DPBtn onclick=\"dp_monthChange(1);\" title=\"下月\">》</span></TD>"+
					"</TR>"+
					"<TR>"+
					"<TD class=DPWeekName>星期日</TD>"+
					"<TD class=DPWeekName>星期一</TD>"+
					"<TD class=DPWeekName>星期二</TD>"+
					"<TD class=DPWeekName>星期三</TD>"+
					"<TD class=DPWeekName>星期四</TD>"+
					"<TD class=DPWeekName>星期五</TD>"+
					"<TD class=DPWeekName>星期六</TD>"+
					"</TR>"+
					"</TABLE>");
	ddt=getDropDownTable();
	if(ddt)
	{
		var row=null;
		var cell=null;
		for(var i=2; i<8; i++)
		{
			row=ddt.insertRow(i);
			if(row)
			{
				for(var j=0; j<7; j++)
				{
					cell=row.insertCell(j);
//					if(cell)
//					{
//					}
				}
			}
		}
	}
	if(ddt.rows.length!=8)
		ddt=null;
	return ddt;
}

function dp_getYear()
{
	var dp=this;
	return dp.curDate.getFullYear();
}

function dp_getMonth()
{
	var dp=this;
	return dp.curDate.getMonth()+1;
}

function dp_getDay()
{
	var dp=this;
	return dp.curDate.getDate();
}

function dp_format(sFormat)
{
	var dp=this;
	return dp.curDate.format(sFormat);
}

function dp_setAccessKey(sKey)
{
	var dp=this;
	var src=dp.children[0];
	if(src && src.tagName=="INPUT")
	{
		src.accessKey=sKey;
	}
}

function dp_getEnabled()
{
	var dp=this;
	var val=false;

	if(dp.dpEnabled)
		val=true;
	else
		val=false;
	return val;
}

function dp_setEnabled(val)
{
	var dp=this;
	var hr=false;

	var src=dp.children[0];
	if(src && src.tagName=="INPUT")
	{
		src.disabled=!val;
		src=dp.children[2];
		if(src && src.tagName=="INPUT")
		{
			src.disabled=!val;
			src=dp.children[4];
			if(src && src.tagName=="INPUT")
			{
				src.disabled=!val;
				dp.dpEnabled=val;
				hr=true;
			}
		}
	}
	return hr;
}

function dp_setFocus()
{
	var dp=this;
	var src=dp.children[0];
	if(src && src.tagName=="INPUT" && !src.disabled)
	{
		src.focus();
	}
}

function dp_getDateContent()
{
	var dp=this;
	var con="";
	var sYearDes="";
	var sMonthDes="";
	var sDayDes="";
	var src=dp.children[1];

	if(src && src.tagName=="FONT")
	{
		sYearDes=src.innerText;
		src=dp.children[3];
		if(src && src.tagName=="FONT")
		{
			sMonthDes=src.innerText;
			src=dp.children[5];
			if(src && src.tagName=="FONT")
			{
				sDayDes=src.innerText;
				var dt=dp.curDate;
				con=dt.getFullYear()+sYearDes+(dt.getMonth()+1)+sMonthDes+dt.getDate()+sDayDes;
			}
		}
	}
	return con;
}

function dp_setFormat(sFormat)
{
	this.formatString=sFormat;
	this.refreshPostText();
}

function dp_refreshPostText()
{
	var dp=this;
	var sFormat="yyyy.mm.dd";

	if(typeof(dp.formatString)=="string")
		sFormat=dp.formatString;
	var txt=dp.children[8];
	if(txt && txt.tagName=="INPUT")
		txt.value=dp.format(sFormat);
}

function dp_initDropDown()
{
	var dp=this;
	var ddt=dp.getDropDownTable();
	if(ddt)
	{
		ddt.curCell=null;
		var cell=null;
		var dt=new Date(dp.curDate.getFullYear(),dp.curDate.getMonth(),1);
		cell=ddt.rows[0].cells[1];
		if(cell)
		{
			cell.innerText=dp.getMonthName(dt.getMonth())+" "+dt.getFullYear();
		}

		var wd=dt.getDay();
		dt=new Date(dt.getFullYear(),dt.getMonth(),1-wd);
		var day=dt.getDate();


		for(var i=2; i<8; i++)
		{
			for(var j=0; j<7; j++)
			{
				cell=ddt.rows[i].cells[j];
				if(cell)
				{
					if(dp.curDate.getMonth()!=dt.getMonth())
						cell.className="DPCellOther";
					else if(dp.curDate.getDate()!=dt.getDate())
						cell.className="DPCell";
					else
					{
						cell.className="DPCell";
						dp_onCell(cell);
					}
					cell.innerText=day;
					cell.year=dt.getFullYear();
					cell.month=dt.getMonth();
					dt.setDate(day+1);
					day=dt.getDate();
				}
			}
		}
	}
}

function dp_getMonthName(lMonth)
{
	var mnArr=new Array("一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月");
	return mnArr[lMonth];

}

function dp_setWeekName()
{
	var dp=this;
	var ddt=dp.getDropDownTable();
	if(ddt)
	{
		var cell=null;

		for(var j=0; j<7; j++)
		{
			cell=ddt.rows[1].cells[j];
			if(cell)
			{
				cell.innerText=arguments[j];
			}
		}
	}
}

function dp_showDropDown()
{
	var dp=this;
	var ddt=dp.getDropDownTable();

	if(ddt)
	{
		if(ddt.style.display=="block")
		{
			dp.hideDropDown();
		}
		else
		{
			dp.initDropDown();
			if(ddt.clientWidth==0)
			{
				ddt.style.pixelLeft=-500;
				ddt.style.pixelTop=-500;
				ddt.style.display="block";
			}

			var ddtWidth=ddt.clientWidth==0?266:ddt.clientWidth;
			var ddtHeight=ddt.clientHeight==0?133:ddt.clientHeight;

			var lLeft=getOffsetLeft(dp);
			var lTop=getOffsetTop(dp)+dp.offsetHeight;
			if((lTop+ddtHeight)>(document.body.clientHeight+document.body.scrollTop))
			{
				lTop-=(ddtHeight+dp.offsetHeight+2);
			}

			if((lLeft+ddtWidth)>(document.body.clientWidth+document.body.scrollLeft))
			{
				lLeft=document.body.clientWidth+document.body.scrollLeft-ddtWidth-2;
			}

			var off=parseInt(dp.offsetHor,10);
			if(isNaN(off))
				off=0;
			ddt.style.pixelLeft=lLeft+off;
			ddt.style.pixelTop=lTop;
			ddt.dpOldDocClick=document.onclick;
			ddt.dpOldDocKeyDown=document.onkeydown;

			event.cancelBubble=true;
			event.returnValue=false;
			document.onclick=dp_sub_docClick;
			document.onkeydown=dp_sub_dockeydown;
			ddt.style.zIndex="102";
			ddt.style.display="block";
		}
	}
}

function getDropDownTable()
{
	var ddt=document.all("dpDropDownTable");
	if(!(ddt && ddt.tagName=="TABLE"))
		ddt=null;
	return ddt;
}

function dp_hideDropDown()
{
	var ddt=getDropDownTable();
	if(ddt)
	{
		ddt.style.display="none";
		document.onclick=ddt.dpOldDocClick;
		document.onkeydown=ddt.dpOldDocKeyDown;
	}
}

function dp_getDropDownTable()
{
	var dp=this;
	dp.dropDownTable=dp_createDropDown();

	if(dp.dropDownTable && dp.dropDownTable.tagName=="TABLE")
	{
		dp.dropDownTable.dp=dp;
		return dp.dropDownTable;
	}
	else
		return null;
}

function dp_onDateChange()
{
	var dp=this;
	if(dp.curDate.compare(dp.oldDate)!=0)
	{
		dp.oldDate=dp.curDate.clone();
		dp.refreshView();
		dp.refreshPostText();
		if(typeof(dp.dateChanged)=="function")
			dp.dateChanged(dp.curDate.getFullYear(),dp.curDate.getMonth()+1,dp.curDate.getDate());
	}
}

function dp_refreshView()
{
	var dp=this;
	var hr=false;

	if(dp && dp.curDate)
	{
		var src=dp.children[0];
		if(src && src.tagName=="INPUT")
		{
			src.value=dp.curDate.getFullYear();
			src=dp.children[2];
			if(src && src.tagName=="INPUT")
			{
				src.value=dp.curDate.getMonth()+1;
				src=dp.children[4];
				if(src && src.tagName=="INPUT")
				{
					src.value=dp.curDate.getDate();
					hr=true;
				}
			}
		}
	}
	return hr;
}

function dp_setTabIndex(lTabIndex)
{
	var dp=this;
	var hr=false;

	if(dp)
	{
		var src=dp.children[0];
		if(src && src.tagName=="INPUT")
		{
			src.tabIndex=lTabIndex;
			src=dp.children[2];
			if(src && src.tagName=="INPUT")
			{
				src.tabIndex=lTabIndex;
				src=dp.children[4];
				if(src && src.tagName=="INPUT")
				{
					src.tabIndex=lTabIndex;
					src=dp.children[7];
					if(src && src.tagName=="A")
					{
						src.tabIndex=lTabIndex;
						hr=true;
					}
				}
			}
		}
	}
	return hr;
}

function dp_setDateDes(sYearDes,sMonthDes,sDayDes)
{
	if(sYearDes==null)
		sYearDes="-";
	if(sMonthDes==null)
		sMonthDes="-";
	if(sDayDes==null)
		sDayDes="";

	var dp=this;
	var hr=false;

	var src=dp.children[1];
	if(src && src.tagName=="FONT")
	{
		src.innerText=sYearDes;
		src=dp.children[3];
		if(src && src.tagName=="FONT")
		{
			src.innerText=sMonthDes;
			src=dp.children[5];
			if(src && src.tagName=="FONT")
			{
				src.innerText=sDayDes;
				hr=true;
			}
		}
	}
	return hr;
}

function dp_setMaxDate(lYear,lMonth,lDay)
{
	var dp=this;
	var hr=false;

	if(dp)
	{
		lYear=parseInt(lYear,10);
		lMonth=parseInt(lMonth,10);
		lDay=parseInt(lDay,10);

		if(!(isNaN(lYear) || isNaN(lMonth) || isNaN(lDay)))
		{
			lMonth--;
			var dt=new Date(lYear,lMonth,lDay);
			var dMin=new Date(dp.minYear,dp.minMonth,dp.minDay);
			var cdMax=new Date(cl_dpMaxYear,cl_dpMaxMonth,cl_dpMaxDay);

			if(dt.compare(cdMax)<=0 && dt.compare(dMin)>=0)
			{
				dp.maxYear=dt.getFullYear();
				dp.maxMonth=dt.getMonth();
				dp.maxDay=dt.getDate();
				hr=true;
			}
		}
	}
	return hr;
}

function dp_setMinDate(lYear,lMonth,lDay)
{
	var dp=this;
	var hr=false;

	if(dp)
	{
		lYear=parseInt(lYear,10);
		lMonth=parseInt(lMonth,10);
		lDay=parseInt(lDay,10);

		if(!(isNaN(lYear) || isNaN(lMonth) || isNaN(lDay)))
		{
			lMonth--;
			var dt=new Date(lYear,lMonth,lDay);
			var dMax=new Date(dp.maxYear,dp.maxMonth,dp.maxDay);
			var cdMin=new Date(cl_dpMinYear,cl_dpMinMonth,cl_dpMinDay);

			if(dt.compare(dMax)<=0 && dt.compare(cdMin)>=0)
			{
				dp.minYear=dt.getFullYear();
				dp.minMonth=dt.getMonth();
				dp.minDay=dt.getDate();
				hr=true;
			}
		}
	}
	return hr;
}

function dp_setCurDate(lYear,lMonth,lDay)
{
	var dp=this;
	var hr=false;

	lYear=parseInt(lYear,10);
	lMonth=parseInt(lMonth,10);
	lDay=parseInt(lDay,10);

	if(!(isNaN(lYear) || isNaN(lMonth) || isNaN(lDay)))
	{
		var dt=new Date(lYear,lMonth-1,lDay);
		var dMax=new Date(dp.maxYear,dp.maxMonth,dp.maxDay);
		var dMin=new Date(dp.minYear,dp.minMonth,dp.minDay);
		if(dt.compare(dMax)<=0 && dt.compare(dMin)>=0)
		{
			dp.curDate=dt;
			dp.onDateChange();
			hr=true;
		}
	}

	if(!hr)
		dp.refreshView();
	return hr;
}

function dp_DropClick()
{
	var src=event.srcElement;
	var dp=getParentFromSrc(src,"SPAN")
	if(dp && dp.className=="DPFrame" && dp.dpEnabled)
	{
		dp.showDropDown();
	}
}

function dp_focus(srcType)
{
	var src=event.srcElement;
	if(src && src.tagName=="INPUT")
	{
		switch(srcType)
		{
			case 'year':
				break;
			case 'month':
				break;
			case 'day':
				break;
			default:;
		}
		src.select();
	}
	return true;
}

function dp_blur(srcType)
{
	var src=event.srcElement;
	var dp=getParentFromSrc(src,"SPAN")
	if(src && src.tagName=="INPUT" && dp && dp.className=="DPFrame")
	{
		var lYear=dp.curDate.getFullYear();
		var lMonth=dp.curDate.getMonth()+1;
		var lDay=dp.curDate.getDate();

		var val=parseInt(src.value,10);
		if(isNaN(val))
			val=-1;
		switch(srcType)
		{
			case 'year':
				lYear=val==-1?lYear:val;
				break;
			case 'month':
				lMonth=val==-1?lMonth:val;
				break;
			case 'day':
				lDay=val==-1?lDay:val;
				break;
			default:;
		}
		dp.setCurDate(lYear,lMonth,lDay);
		if(val==-1)
			dp.refreshView();
	}
	return true;
}

function dp_keyDown(srcType)
{
	var src=event.srcElement;
	var dp=getParentFromSrc(src,"SPAN")
	var bRefresh=true;

	if(dp && dp.className=="DPFrame")
	{
		var lYear=dp.curDate.getFullYear();
		var lMonth=dp.curDate.getMonth();
		var lDay=dp.curDate.getDate();
		var lStep=0;

		switch(event.keyCode)
		{
			case 38:
				lStep=1;
				break;
			case 40:
				lStep=-1;
				break;
			default:
				bRefresh=false;
		}

		switch(srcType)
		{
			case 'year':
				lYear+=lStep;
				break;
			case 'month':
				lMonth+=lStep;
				break;
			case 'day':
				lDay+=lStep;
				break;
			default:;
		}
		if(bRefresh)
			dp.setCurDate(lYear,lMonth+1,lDay);
	}
	return true;
}

function dp_monthChange(lStep)
{
	var src=event.srcElement;
	if(src)
	{
		var ddt=getDropDownTable();
		if(ddt && ddt.dp)
		{
			var dt=ddt.dp.curDate.clone();
			var lOldMonth=dt.getMonth();
			var lOldDay=dt.getDate();

			dt.setDate(1);
			dt.setMonth(lOldMonth+lStep+1);
			dt.setDate(0);
			if(dt.getDate()>lOldDay)
				dt.setDate(lOldDay);
			if(ddt.dp.setCurDate(dt.getFullYear(),dt.getMonth()+1,dt.getDate()))
				ddt.dp.initDropDown();
		}
	}
}

function dp_ddt_click()
{
	var src=event.srcElement;
	if(src && src.tagName=="TD")
	{
		var ddt=getDropDownTable();
		if(ddt && ddt.dp)
		{
			var lOldMonth=ddt.dp.curDate.getMonth();
			if(ddt.dp.setCurDate(src.year,parseInt(src.month,10)+1,parseInt(src.innerText,10)))
			{
				if(src.month!=lOldMonth)
					ddt.dp.initDropDown();
				else
					dp_onCell(src);
			}
		}
	}
}

function dp_onCell(src)
{
	var row=src.parentElement;
	if(row && row.tagName=="TR" && row.rowIndex>1)
	{
		var ddt=getDropDownTable();
		if(ddt)
		{
			if(ddt.curCell)
				ddt.curCell.className=ddt.curCellOldClass;
			ddt.curCellOldClass=src.className;
			src.className="DPCellSelect";
			ddt.curCell=src;
		}
	}
}

function dp_ddt_dblclick()
{
	var src=event.srcElement;
	if(src && src.tagName=="TD")
	{
		var ddt=getDropDownTable();
		if(ddt && ddt.dp)
		{
			var lOldMonth=ddt.dp.curDate.getMonth();
			if(ddt.dp.setCurDate(src.year,parseInt(src.month,10)+1,parseInt(src.innerText,10)))
			{
				ddt.dp.hideDropDown();
			}
		}
	}
}

function dp_sub_docClick()
{
	var src=event.srcElement;
	var ddt=getParentFromSrc(src,"TABLE");
	if(!ddt || ddt.id!="dpDropDownTable")
	{
		dp_hideDropDown();
	}
	event.cancelBubble=true;
	event.returnValue=false;

	return false;
}

function dp_sub_dockeydown()
{
	dp_hideDropDown();
	return true;
}

//----------------------------------editlib.js-------------------------------------------

function KeyFilter(type)
{
	var berr=false;

	switch(type)
	{
		case 'date':
			if (!(event.keyCode == 45 || event.keyCode == 47 || (event.keyCode>=48 && event.keyCode<=57)))
				berr=true;
			break;
		case 'number':
			if (!(event.keyCode>=48 && event.keyCode<=57))
				berr=true;
			break;
		case 'cy':
			if (!(event.keyCode == 46 || (event.keyCode>=48 && event.keyCode<=57)))
				berr=true;
			break;
		case 'long':
			if (!(event.keyCode == 45 || (event.keyCode>=48 && event.keyCode<=57)))
				berr=true;
			break;
		case 'double':
			if (!(event.keyCode == 45 || event.keyCode == 46 || (event.keyCode>=48 && event.keyCode<=57)))
				berr=true;
			break;
		default:
			if (event.keyCode == 35 || event.keyCode == 37 || event.keyCode==38)
				berr=true;
	}
	return !berr;
}

function getParentFromSrc(src,parTag)
{
	if(src && src.tagName!=parTag)
		src=getParentFromSrc(src.parentElement,parTag);
	return src;
}

function switchToOption(sel,newOption,byWhat)
{
	newOption=newOption.toString();
	if(newOption && sel && sel.tagName=="SELECT")
	{
		newOption=trim(newOption);
		var opts=sel.options;
		for(var i=0;i<opts.length;i++)
		{
			if(trim(opts[i][byWhat].toString())==newOption)
			{
				sel.selectedIndex=i;
				break;
			}
		}
	}
}

// Is a element visible?
function isElementVisible(src)
{
	if(src)
	{
		var x=getOffsetLeft(src)+2-document.body.scrollLeft;
		var y=getOffsetTop(src)+2-document.body.scrollTop;
		if(ptIsInRect(x,y,0,0,document.body.offsetWidth,document.body.offsetHeight))
		{
			var e=document.elementFromPoint(x,y);
			return src==e;
		}
	}

	return false;
}

function ptIsInRect(x,y,left,top,right,bottom)
{
	return (x>=left && x<right) && (y>=top && y<bottom);
}

function getOffsetLeft(src)
{
	var set=0;
	if(src)
	{
		if (src.offsetParent)
			set+=src.offsetLeft+getOffsetLeft(src.offsetParent);

		if(src.tagName!="BODY")
		{
			var x=parseInt(src.scrollLeft,10);
			if(!isNaN(x))
				set-=x;
		}
	}
	return set;
}
function getOffsetTop(src)
{
	var set=0;
	if(src)
	{
		if (src.offsetParent)
			set+=src.offsetTop+getOffsetTop(src.offsetParent);

		if(src.tagName!="BODY")
		{
			var y=parseInt(src.scrollTop,10);
			if(!isNaN(y))
				set-=y;
		}
	}
	return set;
}

function isAnyLevelParent(src,par)
{
	var hr=false;
	if(src==par)
		hr=true;
	else if(src!=null)
		hr=isAnyLevelParent(src.parentElement,par);

	return hr;
}

function isIE(version)
{
	var i0=navigator.appVersion.indexOf("MSIE")
	var i1=-1;
	var ver=0;
	if(i0>=0)
	{
		i1=navigator.appVersion.indexOf(" ",i0+1);
		if(i1>=0)
		{
			i0=i1;
			i1=navigator.appVersion.indexOf(";",i0+1);
			if(i1>=0)
			{
				ver=parseFloat(navigator.appVersion.substring(i0+1,i1));
				if(isNaN(ver))
					ver=0;
			}
		}
	}

	return (navigator.userAgent.indexOf("MSIE")!= -1
		&& navigator.userAgent.indexOf("Windows")!=-1
		&& ((ver<(version+1) && ver>=version) || version==0));
}

function getValidDate(str)
{
	var sDate=str.replace(/\//g,"-");
	var vArr=sDate.split("-");
	var sRet="";

	if(vArr.length>=3)
	{
		var year=parseInt(vArr[0],10);
		var month=parseInt(vArr[1],10);
		var day=parseInt(vArr[2],10);
		if(!(isNaN(year) || isNaN(month) || isNaN(day)))
			if(year>=1900 && year<9999 && month>=1 && month<=12)
			{
				var dt=new Date(year,month-1,day);
				year=dt.getFullYear();
				month=dt.getMonth()+1;
				day=dt.getDate();
				sRet=year+"-"+(month<10?"0":"")+month+"-"+(day<10?"0":"")+day;
			}
	}

	return sRet;
}

function getSafeValue(val,def)
{
	if(typeof(val)=='undefined' || val==null)
		return def;
	else
		return val;
}

//------------------------------------dateobject.js-------------------------------------

function initDateObject()
{
	Date.prototype.compare=date_compare;
	Date.prototype.clone=date_clone;
	Date.prototype.format=date_format;
}

function date_format(sFormat)
{
	var dt=this;
	if(sFormat==null || typeof(sFormat)!="string")
		sFormat="";
	sFormat=sFormat.replace(/yyyy/ig,dt.getFullYear());
	var y=""+dt.getYear();
	if(y.length>2)
	{
		y=y.substring(y.length-2,y.length);
	}
	sFormat=sFormat.replace(/yy/ig,y);
	sFormat=sFormat.replace(/mm/ig,dt.getMonth()+1);
	sFormat=sFormat.replace(/dd/ig,dt.getDate());
	return sFormat;
}

function date_clone()
{
	return new Date(this.getFullYear(),this.getMonth(),this.getDate());
}

function date_compare(dtCompare)
{
	var dt=this;
	var hr=0;

	if(dt && dtCompare)
	{
		if(dt.getFullYear()>dtCompare.getFullYear())
			hr=1;
		else if(dt.getFullYear()<dtCompare.getFullYear())
			hr=-1;
		else if(dt.getMonth()>dtCompare.getMonth())
			hr=1;
		else if(dt.getMonth()<dtCompare.getMonth())
			hr=-1;
		else if(dt.getDate()>dtCompare.getDate())
			hr=1;
		else if(dt.getDate()<dtCompare.getDate())
			hr=-1;
	}
	return hr;
}

function date_getDateFromVT_DATE(dt)
{
	dt=dt.replace(/./g,"/");
	dt=Date.parse(dt);
	if(isNaN(dt))
		dt=null;
	else
		dt=new Date(dt);
	return dt;
}

//Call the initialize function
initDateObject();
