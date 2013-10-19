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

$db = new dbClass($db_ado);
if(($_SESSION["user_type"] == "Account" || $_SESSION["user_type"] == "Administrator")){
	
	$delSql = "DELETE FROM " . MAG . " WHERE ID=" . $_GET["ID"] . " LIMIT 1";
	$deptArray = $db_ado->Execute($delSql);
	if($deptArray){
			echo "<script language='javascript'>
			window.alert('Delete ok!');
			window.location='account_mag_list.php';
			</script>";
	}
	else{
		echo "<script language='javascript'>
			window.alert('Sorry, failed');
			window.history.back();
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