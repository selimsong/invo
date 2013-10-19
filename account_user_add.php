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

if($_SESSION["user_type"] == "Account" || $_SESSION["user_type"] == "Administrator"){
	$db = new dbClass($db_ado);
	$deptSql = "SELECT * FROM " . DEPT;
	$citySql = "SELECT * FROM " . CITY . " WHERE Country='" . $_SESSION["priority_country"] . "'";
	$invoiceTpl->assign("sArray",$_SESSION);
	$invoiceTpl->assign("deptArray",$db->SelectSql($deptSql));
	$invoiceTpl->assign("cityArray",$db->SelectSql($citySql));
	$invoiceTpl->display("account_user_add.htm");
}
else {
		echo "<script language='javascript'>
			window.alert('Sorry, this is protected ');
			window.close();
		</script>";
}

?>