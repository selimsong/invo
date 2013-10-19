<?php
require_once(dirname(__FILE__) . "/invoice.config.php");
require_once(dirname(__FILE__) . "/adodb.class.php");
require_once(dirname(__FILE__) . "/check_sess.php");

//$sql["user"] = "select user_name from user_info where priority_country='" . $_SESSION["priority_country"] . "'";
//echo $sql["user"];
//$search["user"] = mysql_query($sql["user"]);
//while($result= mysql_fetch_array($search["user"])){
//	$user[] = $result["user"];
//}


$sql["fee_sharing_p1"]  = "select fee_sharing_p1,sum(Fee_sharing_p1_fee) as sum_fsp1 from " . INVLIST ;
$sql["fee_sharing_p1"] .= " where Invoice_date between '2008-01-01' AND '2008-12-31'";
$sql["fee_sharing_p1"] .= " AND Country='" . $_SESSION["priority_country"] . "' ";
$sql["fee_sharing_p1"] .= " group by fee_sharing_p1 order by sum_fsp1 DESC";
//echo $sql;
$s["fee_sharing_p1"] = mysql_query($sql["fee_sharing_p1"]);

$sql["Client"]  = "select Client,sum(Net_Fee) as sum_fsp1 from " . INVLIST ;
$sql["Client"] .= " where Invoice_date between '2008-01-01' AND '2008-12-31'";
$sql["Client"] .= " AND Country='" . $_SESSION["priority_country"] . "' ";
$sql["Client"] .= " group by Client order by sum_fsp1 DESC";
//echo $sql;
$s["Client"] = mysql_query($sql["Client"]);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Invoice login</title>
<link href="css/invocie_global.css" rel="stylesheet" type="text/css" />
<link href="css/drag_drop.css" rel="stylesheet" type="text/css" />
<link href="css/date_selector.css" rel="stylesheet" type="text/css" />
<style>
body,div,table,td,tr,input {
    font-family:Verdana, Arial, Helvetica, sans-serif;
    font-size:10px;
}
.right{
    color:#006600;
    font-weight:bolder;
}
.wrong{
    color:#FF0000;
    font-weight:bolder;
}
.div_percent{
	width:600px;
	background: green;
	height:10px;
}
</style>
</head>
<body>
fee split person 1:(<?=$_SESSION["priority_country"]?> office)
<table border=1>
<?php 
while($r = mysql_fetch_array($s["fee_sharing_p1"])){
?>
<tr><td><?=$r["fee_sharing_p1"] ?></td><td><div align="right"><?=$r["sum_fsp1"]?></div></td></tr>
<?php }?>
</table>
<hr>
Client Net Fee: (<?=$_SESSION["priority_country"]?> office)
<table border=1>
<?php 
while($r = mysql_fetch_array($s["Client"])){
?>
<tr><td><?=$r["Client"] ?></td><td><div align="right"><?=$r["sum_fsp1"]?></div></td></tr>
<?php }?>
</table>
<hr>
</body>
</html>