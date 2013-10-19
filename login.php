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

if(stristr($_SERVER["HTTP_USER_AGENT"],"MSIE 7.0"))
{
?>
	<script>alert("You are using IE7, please use IE6/Firefox to try again!")</script>
<?php
	exit();
}

$invoiceTpl->display("login.htm");
?>