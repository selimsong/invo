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
	$insertArray["dept2_code"] = $_POST["dept2_code"];
	$insertArray["dept2_desc"] = $_POST["dept2_desc"];
	$insertArray["dept_id"] = $_POST["dept_id"];
	$insertArray["dept2_country"] = $_SESSION["priority_country"];
	$insertArray["dept2_city"] = "";
	$insertArray["dept2_add_by"] = $_SESSION["user_name"];
	$insertArray["dept2_create_date"] = date("Y-m-d H:i:s");
	$add_user = $db->insert(DEPT2,$insertArray);
	if($add_user){
		echo "<script language='javascript'>
			window.alert('Add OK!');
			window.location='account_dept2_list.php';
			</script>";
	}
	else {
		echo "<script language='javascript'>
			window.alert('Sorry, failed');
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