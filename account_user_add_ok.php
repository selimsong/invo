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

if($_SESSION["user_type"] == "Account"){
	$db = new dbClass($db_ado);
	$insertArray["user_name"] = $_POST["user_name"];
	$insertArray["password"] = md5($_POST["password"]);
	$insertArray["invoice_add"] = $_POST["invoice_add"]?1:0;
	$insertArray["invoice_view"] = $_POST["invoice_view"]?1:0;
	$insertArray["invoice_modify"] = $_POST["invoice_modify"]?1:0;
	$insertArray["priority_dept"] = $_POST["priority_dept"];
	$insertArray["priority_city"] = $_POST["priority_city"];
	$insertArray["priority_country"] = $_SESSION["priority_country"];
	$insertArray["user_type"] = "user";
	$insertArray["power"] = $_POST["power"];
	$add_user = $db->insert(USER,$insertArray);
	if($add_user){
		echo "<script language='javascript'>
			window.alert('New user added!');
			window.location='account_user_list.php';
			</script>";
	}
	else {
		echo "<script language='javascript'>
			window.alert('Sorry, user add failed');
			window.history.back();
		</script>";
	}
}
else {
		echo "<script language='javascript'>
			window.alert('Sorry, this is protected ');
			window.history.back();
		</script>";
}

?>