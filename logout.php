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
session_start();
$logoutName = $_SESSION["user_name"];

unset($_SESSION["ID"]);
unset($_SESSION["user_name"]);
unset($_SESSION["password"]);
unset($_SESSION["default_country"]);
unset($_SESSION["default_city"]);
unset($_SESSION["default_dept"]);
unset($_SESSION["priority_country"]);
unset($_SESSION["priority_city"]);
unset($_SESSION["priority_dept"]);
unset($_SESSION["power"]);
unset($_SESSION["invoice_add"]);
unset($_SESSION["invoice_view"]);
unset($_SESSION["invoice_modify"]);
unset($_SESSION["user_type"]);
unset($_SESSION["currency_manager"]);
unset($_SESSION["approve"]);

echo "<script language='javascript'>
	window.alert('" . $logoutName . ", logout ok,bye!');
	window.parent.location='login.php';
</script>";
?>