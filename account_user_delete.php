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
$user = $db->SelectSql('SELECT * FROM ' . USER . ' WHERE ID=' . $_GET["ID"]);
if(($_SESSION["user_type"] == "Account" || $_SESSION["user_type"] == "Administrator") && $user[0]["priority_country"] == $_SESSION["priority_country"]){
	
	$delSql = "DELETE FROM " . USER . " WHERE ID=" . $_GET["ID"] . " LIMIT 1";
	$deptArray = $db_ado->Execute($delSql);
	header("location:account_user_list.php");
}
else {
		echo "<script language='javascript'>
			window.alert('Sorry, this is protected ');
			window.close();
		</script>";
}

?>