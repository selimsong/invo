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


if($_SESSION["user_type"] == "Administrator" ||$_SESSION["user_type"] == "Account"){
	$invoiceTpl->display("admin_index.htm");
}
else{
			echo "<script language='javascript'>
			window.alert('Error, if you are Administrator, please login first');
			window.location='login.php';
		</script>";
}
?>