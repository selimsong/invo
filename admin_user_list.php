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

if(isset($_GET["pp"]))$page->setPp($_GET["pp"]);
if(isset($_GET["current_index_num"]))$page->setCurrentIndexNum($_GET["current_index_num"]);

if($_SESSION["power"] == 0){
	$db = new dbClass($db_ado);
    
    $r = mysql_query("SELECT * FROM " . USER . " WHERE `power` >  '0'");
    $page->setTotal(mysql_num_rows($r));
    $page->page_records_num = 30;                                                            
	$useListSql = "SELECT * FROM " . USER . " WHERE `power` >  '0' LIMIT " . ($page->pp-1) * $page->page_records_num . "," . $page->page_records_num;
	$userArray = $db->SelectSql($useListSql);
	$invoiceTpl->assign("sArray",$_SESSION);
	$invoiceTpl->assign("userList",$userArray);
    $invoiceTpl->assign("PAGELINK", $page->getPageIndex());
	$invoiceTpl->display("admin_user_list.htm");
}
else {
		echo "<script language='javascript'>
			window.alert('Sorry, this is protected ');
			window.close();
		</script>";
}

?>