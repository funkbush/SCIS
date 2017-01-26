<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>BigPipe Demo 3</title>
<style type="text/css">
 * {margin: 0; padding:0;}
 body {background-color:#fff;}
 div{border:2px solid #4F81BD; margin:30px; padding: 10px;}
 p {word-wrap:break-wrod; word-break:break-all; color: #666;}
 .red {color: #f00;}
 .blue {color:blue;}
 .green {color:green;}
</style>
<script>
function render(nodeID,html){
    document.getElementById(nodeID).innerHTML=html;
}
</script>
</head>
<body>

<div id="header"><p>Loading...</p></div>
<div id="content"><p>Loading...</p></div>
<div id="footer"><p>Loading...</p></div>
<div id="xxx"><p>Loading...</p></div>

<?php 
    ob_flush(); 
    flush();
    sleep(1);
    
    //Ìî³ä»º³åÇø
    $header = str_pad('<span class="blue">111111</span>', 4096);
?>
<script>render('header', '<p><?php echo $header;?><p>');</script>

<?php 
    ob_flush(); 
    flush();
    sleep(1);
    
    $content = str_pad('<span class="red">222222</span>', 4096);
?>
<script>render('content', '<p><?php echo $content;?><p>');</script>

<?php 
    ob_flush(); 
    flush();
    sleep(1);
    
    $footer = str_pad('<span class="green">333333</span>', 4096);
?>
<script>render('footer', '<p><?php echo $footer;?><p>');</script>

<?php 
    ob_flush(); 
    flush();
    sleep(1);
    
    $xxx = str_pad('<span class="green">44444</span>', 4096);
?>
<script>render('xxx', '<p><?php echo $xxx;?><p>');</script>
<?php 
    ob_flush(); 
    flush();
?>

</body>
</html>

