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
	$CountryArray = $db->SelectSql("SELECT * FROM " . COUNTRY);
	foreach ($CountryArray as $key=>$items){
		$country[$items["default_curr_code"]] = $items["default_curr_code"];
	}

	$invoiceTpl->assign("countryOptions",$country);
	$invoiceTpl->assign("sArray",$_SESSION);
	$invoiceTpl->display("admin_curr_add.htm");
}
?>