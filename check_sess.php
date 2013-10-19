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
define(SESSION_LIFE, 1800); //define session life time.

session_start();
if (!isset($_SESSION["power"])){
	echo "<script language='javascript'>
			window.alert('Please login first');
			window.parent.location='login.php';
		</script>";
	exit();
}
if ((time()-$_SESSION["login_time"]) >= SESSION_LIFE){
    echo "<script language='javascript'>
            window.alert('Welcome back, but you seems to leave too long!\\n Please login again!');
            window.parent.location='login.php';
        </script>";
    exit();
}
else{
    $_SESSION["login_time"] = time();
}
?>