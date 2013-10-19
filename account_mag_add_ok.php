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

if($_SESSION["user_type"] == "Account" || $_SESSION["user_type"] == "Administrator" ){
	$db = new dbClass($db_ado);
	$insertArray["Client_Solutins_Major"] = $_POST["Client_Solutins_Major"];
	$insertArray["Client"] = $_POST["Client"];
	$add_mag = $db->insert(MAG,$insertArray);
	if($add_mag){
		echo "<script language='javascript'>
			window.alert('Add ok!');
			window.location='account_mag_list.php';
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