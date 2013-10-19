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








if($_SESSION["user_type"] == "Account" || $_SESSION["user_type"] == "Administrator"){
	$db = new dbClass();
    $join = " as l left join dept2_info as r on l.priority_dept=r.dept2_id ";
    $sqlWhere =  " WHERE (`power` >  4  OR `power`='2.3'  OR `power`='2.5' ) AND `priority_country`='" . $_SESSION["priority_country"] . "' ";
    $db->setOrderBy(" priority_city,priority_dept,user_name "); 
    if($_SESSION["user_type"] != "Administrator"){
    	$db->setSqlWhere($join . $sqlWhere);
    }
    if(isset($_POST['username'])){
    	$db->setSqlWhere(" where user_name like '%".$_POST['username']."%' " );
    	$page->setPp(1);
    }
    $page->setTotalByArray($db->getInfo(USER));
    $page->page_records_num = 30;
    //$page->setFileName("search_list.php?orderby=" . $orderBy);
    $db->setLimitRecords(($page->pp-1) * $page->page_records_num, $page->page_records_num);
    $userArray = $db->getInfo(USER);        	
    $invoiceTpl->assign("PAGELINK", $page->getPageIndex());
    $invoiceTpl->assign("sArray",$_SESSION);
    $invoiceTpl->assign("power_type",$power_type);
	$invoiceTpl->assign("userList",$userArray);
	$invoiceTpl->display("account_user_list.htm");
}
else {
		echo "<script language='javascript'>
			window.alert('Sorry, this is protected ');
			window.close();
		</script>";
}

?>