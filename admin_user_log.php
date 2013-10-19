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
require_once(dirname(__FILE__) . "/check_sess.php");
require_once(dirname(__FILE__) . "/comm.inc.php");

if(isset($_GET["pp"]))$page->setPp($_GET["pp"]);
if(isset($_GET["current_index_num"]))$page->setCurrentIndexNum($_GET["current_index_num"]);

if($_SESSION["power"] == 0){
	$db = new dbClass($db_ado);
    
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
    echo "<table>";
    while($st = mysql_fetch_array($user_s)){
        if($st["priority_country"] != "China_Hong Kong"){
            echo "<tr><td align=\"right\">" . $st[1] . " : </td><td>&nbsp;&nbsp;" . $st[0] . "</td></tr>";
        }
        
    }
    echo "</table>";
    
    
    
    
	$invoiceTpl->assign("sArray",$_SESSION);
	$invoiceTpl->assign("logArray",$logArray);
    $invoiceTpl->assign("PAGELINK", $page->getPageIndex());
	$invoiceTpl->display("admin_user_log.htm");
}
else {
		echo "<script language='javascript'>
			window.alert('Sorry, this is protected ');
			window.close();
		</script>";
}

?>