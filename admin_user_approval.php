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

//if(isset($_GET["pp"]))$page->setPp($_GET["pp"]);
//if(isset($_GET["current_index_num"]))$page->setCurrentIndexNum($_GET["current_index_num"]);

if($_SESSION["power"] == 0){
	$db = new dbClass($db_ado);
    
    $sql = "SELECT * FROM user_info as l left join dept2_info as r on l.priority_dept=r.dept2_id Where approve=1 order by priority_country,user_name";
    echo $sql;
    //$page->setTotal(mysql_num_rows($r));
    //$page->page_records_num = 60;                                                            
	//$logSql = "SELECT * FROM " . LOG . " order by log_time DESC LIMIT " . ($page->pp-1) * $page->page_records_num . "," . $page->page_records_num;
    
	$user = mysql_query($sql);
    echo "<table border=1>
            <th>ID</th>
            <th>user_name</th>
            <th>priority_country</th>
            <th>priority_city</th>
            <th>dept2_code</th>
            <th>priority_dept</th>
            <th>user type</th>
            <th>power</th>";
    while($st = mysql_fetch_array($user)){
        //print_r($st);
        echo "<tr>";
        echo "<td>$st[ID]</td>";
        echo "<td>$st[user_name]</td>";
        echo "<td>$st[priority_country]</td>";
        echo "<td>$st[priority_city]</td>";
        echo "<td>$st[dept2_code]</td>";
        echo "<td>$st[priority_dept]</td>";
        echo "<td>$st[user_type]</td>";
        echo "<td>".$power_type[$st['power']]."($st[power])</td>";
        echo "</tr>";        
    }
    echo "</table>";
    
    
    
    
	//$invoiceTpl->assign("sArray",$_SESSION);
	//$invoiceTpl->assign("logArray",$logArray);
    //$invoiceTpl->assign("PAGELINK", $page->getPageIndex());
	$invoiceTpl->display("admin_user_log.htm");
}
else {
		echo "<script language='javascript'>
			window.alert('Sorry, this is protected ');
			window.close();
		</script>";
}

?>