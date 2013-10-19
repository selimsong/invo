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


if($_SESSION["user_type"] == "Account" || $_SESSION["user_type"] == "Administrator"){
	$updateSql = "";
	$db = new dbClass($db_ado);
	$db->setSqlWhere(" WHERE ID='" . $_POST["ID"] . "'");
	$update["Client_Solutins_Major"] = $_POST["Client_Solutins_Major"];
	$update["Client"] = $_POST["Client"];
	if($db->updateTable(MAG,$update)){
		echo "<script language='javascript'>
			window.alert('Ok,update success');
			window.location='account_mag_list.php';
		</script>";
	}

}
else {
		echo "<script language='javascript'>
			window.alert('Sorry, this is protected ');
			window.close();
		</script>";
}
?>