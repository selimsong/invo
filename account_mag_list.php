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
	$magArray = $db->SelectSql("SELECT * FROM " . MAG . " ORDER BY Client_Solutins_Major");
	$magGoup = $db->SelectSql("SELECT Client_Solutins_Major FROM " . MAG . " GROUP BY Client_Solutins_Major ORDER BY Client_Solutins_Major");
	

	$invoiceTpl->assign("sArray",$_SESSION);
	$invoiceTpl->assign("magArray",$magArray);
	$invoiceTpl->display("account_mag_list.htm");
}
else {
		echo "<script language='javascript'>
			window.alert('Sorry, this is protected ');
			window.close();
		</script>";
}

?>