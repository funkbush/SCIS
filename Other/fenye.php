<?php
function fenye($table,$pagesize="",$paixu="",$do="",$wwhere="")
{ 
   if(($table == "news_fabu") or ($table == "product_fabu") or ($table == "message") or ($table == "down_fabu") or ($table == "kucun"))
   { 
       $query = @mysql_query("select * from $table $wwhere"); 
       $pagesize = $pagesize; 
       $sum = mysql_num_rows($query); 
  
       if($sum == 0)
       { 
          $pagesize = 1; 
       } 
	   if($pagesize=="0"){ 
    $sum = "1"; 
 } 
    if (@($sum % $pagesize) == 0){ 
    $total = @(int)($sum / $pagesize); 
}else{ 
     $total = @(int)($sum / $pagesize) + 1; 
 } 
    if($total == 0){$total=1;} 
    if (isset($_get['page'])){ 
        $p = (int)$_get['page']; 
    }else{ 
        $p = 1; 
    } 
    $start = $pagesize * ($p - 1); 
    $query = @mysql_query("select * from $table $wwhere order by $paixu limit $start,$pagesize") or die ("数据查询失败2!"); 
    if ($do == 1){ 
        $queryarray = array($query,$total,$sum,$p); 
        return $queryarray; 
    } 
    if($do == 2){ 
        $parray = array($total,$sum,$p); 
        return $parray; 
    } 
 }else{ 
     $query = @mysql_query("select * from $table $wwhere order by $paixu limit $pagesize") or die ("数据查询失败1!"); 
     if ($do == 1){ 
            $queryarray = array($query,$total,$sum,$p); 
            return $queryarray; 
    } 
    if($do == 2){ 
            $parray = array($total,$sum,$p); 
            return $parray; 
     } 
 } 
} 
//返回分页条   
function fenyedaohang($total="",$sum="",$p="",$menut=""){ 
 $w = substr($menut,strrpos($menut,"&")+1,2); 
 $wr = substr($menut,strrpos($menut,"=")+1,strlen($menut)); 
$pindao = $_server["script_name"];$pinstrlen = strrpos($pindao,"/"); $pindao = substr($pindao,$pinstrlen+1,strlen($pindao)); 
    if($w == "pr"){ 
     $queryr = mysql_query("select feiye.feiye_what from feiye where feiye.feiye_page = '$pindao'"); 
  $rows = mysql_fetch_row($queryr); $rrows = $rows[0]; 
  if(emptyempty($rrows)){ 
      mysql_query("insert into `feiye` (`feiye_page`, `feiye_what`) values ('$pindao', '$wr')"); 
   echo "<meta http-equiv='refresh' content='0'>"; 
  }else{ 
      if($wr != $rrows){ 
        mysql_query("update `feiye` set `feiye_what`='$wr' where (`feiye_page`='$pindao')"); 
     echo "<meta http-equiv='refresh' content='0'>"; 
   } 
  } 
 } 
 if($w == "ne"){ 
     $queryr = mysql_query("select feiye.feiye_what from feiye where feiye.feiye_page = '$pindao'"); 
  $rows = mysql_fetch_row($queryr); $rrows = $rows[0]; 
 if(emptyempty($rrows)){ 
      mysql_query("insert into `feiye` (`feiye_page`, `feiye_what`) values ('$pindao', '$wr')"); 
   echo "<meta http-equiv='refresh' content='0'>"; 
  }else{ 
      if($wr != $rrows){ 
        mysql_query("update `feiye` set `feiye_what`='$wr' where (`feiye_page`='$pindao')"); 
     echo "<meta http-equiv='refresh' content='0'>"; 
   }  
  } 
 } 
    echo "共"."$total"."页&nbsp;"."记录"."$sum"."条&nbsp;当前"."$p"."/"."$total"."页&nbsp;&nbsp;"; 
    if($total == 1){ 
        echo "<font  class="page">首页</font>"; 
    }else{ 
        echo "<a href='?page=1&menu=$menut' class="page">首页</a>"."&nbsp;"; 
    } 
    if ($p > 1){ 
        $prev = $p - 1; 
        echo "<a href='?page=$prev&menu=$menut' class="page">上一页</a>"."&nbsp;"; 
    }else{ 
        echo "<font class="page">上一页</font>"."&nbsp;"; 
    } 
    $page = $_get["page"]; 
    $pagesum = $page+5; 
    if($total >= 11){ 
        if($pagesum <=11 ){ 
            $pagesum = 11; 
        } 
    } 
    if($pagesum >= $total){ 
        $pagesum = $total; 
   } 
    $pagestart = $page - 5; 
   if($pagestart <= 0){ 
        $pagestart = 1; 
    } 
    if($total >= 11 and ($total-4) <= $page){ 
        $pagestart = $total-10; 
   } 
    for($i=$pagestart;$i<=$pagesum;$i++){ 
        if($i == $p){ 
            echo "<font color=cccccc>&nbsp;$i&nbsp;</font>"; 
        }else{ 
            echo "<a href='?page=$i&menu=$menut' class="page" >$i</a>"; 
        } 
    } 
    if ($p < $total){ 
        $next = $p + 1; 
        echo "&nbsp;<a href='?page=$next&menu=$menut' class="page" >下一页</a>"."&nbsp;"; 
    }else{ 
       echo "<font class="page" >下一页</font>"."&nbsp;"; 
    }//开源代码phpfensi.com 
    if($total == 1){ 
        echo "<font  class="page">尾页</font>"; 
    }else{ 
        echo "<a href='?page=$total&menu=$menut' class="page">尾页</a>"; 
    } 
}
?>