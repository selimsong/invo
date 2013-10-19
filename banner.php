<?php
/*
 * @Copyright (c) 2007, www.cushwake.com
 * @All rights reserved.
 *
 * @File name：check_sess.php
 * 
 * @summery：check_sess
 *
 * @author：leon.zhao@ap.cushwake.com
 * @date：06.22.2007 10:22 AM
 *
 */
require_once(dirname(__FILE__) . "/invoice.config.php");
require_once(dirname(__FILE__) . "/check_sess.php");

$invoiceTpl->assign("ID",$_SESSION["ID"]);
$invoiceTpl->assign("user_name",$_SESSION["user_name"]);
$invoiceTpl->assign("default_country",$_SESSION["default_country"]);
$invoiceTpl->assign("default_city",$_SESSION["default_city"]);
$invoiceTpl->assign("default_dept",$_SESSION["default_dept"]);
$invoiceTpl->assign("priority_country",$_SESSION["priority_country"]);
$invoiceTpl->assign("priority_city",$_SESSION["priority_city"]);
$invoiceTpl->assign("priority_dept",$_SESSION["priority_dept"]);
$invoiceTpl->assign("power",$_SESSION["power"]);
?>