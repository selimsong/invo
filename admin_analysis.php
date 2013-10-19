<?php
/*
 * @Copyright (c) 2007, www.cushwake.com
 * @All rights reserved.
 *
 * @File name：login.php
 * 
 * @summery：login form
 *
 * @author：leon.zhao@ap.cushwake.com
 * @date：06.22.2007 10:22 AM
 *
 */
require_once(dirname(__FILE__) . "/invoice.config.php");
require_once(dirname(__FILE__) . "/adodb.class.php");
//require_once(dirname(__FILE__) . "/check_sess.php");
require_once(dirname(__FILE__) . "/comm.inc.php");


$year = $_GET["year"];

if(isset($_GET["pp"]))$page->setPp($_GET["pp"]);
if(isset($_GET["current_index_num"]))$page->setCurrentIndexNum($_GET["current_index_num"]);

if($_SESSION["power"] == 0){
	$db = new dbClass($db_ado);
    echo "";
    $r1 = "SELECT Country,count(*) FROM " . INVLIST . " WHERE Invoice_date like '" . $year . "%' GROUP BY Country";
    $t1 = mysql_query($r1);
    
    $r = mysql_query("SELECT * FROM " . LOG . " order by log_time DESC");
    $page->setTotal(mysql_num_rows($r));
    $page->page_records_num = 60;                                                            
	$logSql = "SELECT * FROM " . LOG . " order by log_time DESC LIMIT " . ($page->pp-1) * $page->page_records_num . "," . $page->page_records_num;
	$logArray = $db->SelectSql($logSql);
    
    foreach($logArray as $k=>$v){
        foreach($v as $t => $s){
            if($t == "user_ip"){
                $logArray[$k]["VPN_domain"] = $AP_VPN[implode(".", explode('.', $s, -1)) . "."];
            }   
        }
    }
    
    $c = "SELECT count(*),priority_country FROM " . USER . " GROUP BY priority_country";
    $user_s = mysql_query($c);
    //echo "<table>";
    while($st = mysql_fetch_array($user_s)){
        if($st["priority_country"] != "China_Hong Kong"){
            //echo "<tr><td align=\"right\">" . $st[1] . " : </td><td>&nbsp;&nbsp;" . $st[0] . "</td></tr>";
        }
        
    }
   // echo "</table>";
    
    
    
    
//	$invoiceTpl->assign("sArray",$_SESSION);
//	$invoiceTpl->assign("logArray",$logArray);
//    $invoiceTpl->assign("PAGELINK", $page->getPageIndex());
//	$invoiceTpl->display("admin_user_log.htm");
}
else {
		echo "<script language='javascript'>
			window.alert('Sorry, this is protected ');
			window.close();
		</script>";
}

?>
<link href="css/invocie_global.css" rel="stylesheet" type="text/css" />
<style>
body,div,table,td,tr,input {
    font-family:Verdana, Arial, Helvetica, sans-serif;
    font-size:10px;
}
table tr td{
    border-collapse: collapse;
    border-width: 1px;
    border-color: 0080FF;
}

</style>
<body>

<div style="font-size:12px;">The following table listed the fields with data records compared to the total(per Country), date from Jan 1st,<?php echo $year;?>.</div>
<br>
<div>

<?php

$item_all_s = mysql_fetch_array(mysql_query("select * from ap_07 limit 0,1"));
foreach($item_all_s as $k=>$n){
    if(!is_int($k))
    $item_all[] = $k;
}
//print_r($item_all);

$items = $item_all;
//$items = array("Exchange_rate","curr_code","Invoice_date","doc_type","Transaction_No","Dept_info","Client","Payer","Property_Project_Name","Invoice_Amount","3rd_Pty","3rd_Pty_Fee","Net_Fee","Fee_sharing_p1","Fee_sharing_p1_percent","Fee_sharing_p1_fee","Trans_Type_1","Trans_Type_2","Ppty_Type","Sq_Ft","Lease_Term","1_Mths_rent","Transaction_Value","client_reference_no");

$countryTotal = array();
$inAll = array();


while($e1 = mysql_fetch_array($t1)){
    $countryTotal[$e1["Country"]] = $e1[1];
}
foreach($items as $k=>$v){
//    echo "<strong>" . $v . "</strong>:<br>";
    $item_sql = "select Country,count(*) from ap_07 WHERE " . $v . "!=''  AND `ap_07`.`Invoice_date` like  '" . $year . "%' GROUP BY `ap_07`.`Country`";
    //echo $item_sql;
    $q = mysql_query($item_sql);
    while($qt = mysql_fetch_array($q)){
//        echo $qt[0] . " : " . $qt[1] . "/" . $countryTotal[$qt[0]] . "<br>";
        $inAll[$qt[0]][$v] = $qt[1];
    }
//    echo "<hr>";
}
?>
<div>
<br>

<table border=2>
<tr><th>Country</th>
<?php
foreach($items as $k=>$v){
    echo "<th>$v</th>";
}
?>
</tr>
<?php

foreach($countryTotal as $name=>$num){
    echo "<tr><td nowrap>$name</td>";
    
    foreach($items as $k=>$v){
        if($inAll[$name][$v]){
            echo "<td>". $inAll[$name][$v] ."/$num</td>";
        }
        else{
            echo "<td><font color=Red>None</font></td>";
        }
    }
    echo "</tr>";
}

?>
</table>
</div>
</div>
</body>