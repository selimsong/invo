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
require_once(dirname(__FILE__) . "/check_sess.php");
require_once(dirname(__FILE__) . "/adodb.class.php");

if($_SESSION["user_type"] == "Administrator" || (($_SESSION["user_type"] == "Account" ) && $_SESSION["currency_manager"] == "1" )){
	$db = new dbClass($db_ado);
	$ListSqlThisYear = "SELECT * FROM " . CURRENCY . " WHERE period_year='" . date("Y",time()) . "' AND curr_code='" . $_GET["curr_code"] . "'";
	$listArray = $db->SelectSql($ListSqlThisYear);
	$invoiceTpl->assign("currList",$listArray);
	$invoiceTpl->display("admin_curr_modify.htm");
}
?>