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

if($_GET["ID"] == ""){
            echo "<script language='javascript'>
            window.alert('Sorry, this is protected ');
            window.close();
        </script>";
}


if($_SESSION["user_type"] == "Account" || $_SESSION["user_type"] == "Administrator"){
	$db = new dbClass($db_ado);
	$deptSql = "SELECT * FROM " . DEPT2 . " WHERE dept2_country='" . $_SESSION["priority_country"] . "' order by dept2_code";
	$citySql = "SELECT * FROM " . CITY . " WHERE Country='" . $_SESSION["priority_country"] . "'";
	if($_SESSION["user_type"] == "Administrator"){
		$citySql = "SELECT * FROM " . CITY ;
	}
	$user_info_sql = "SELECT * FROM " . USER . " WHERE ID='" . $_GET["ID"] . "'";
    $user_info = $db->SelectSql($user_info_sql);
    
    //if(stristr($user_info[0]["priority_country"],$_SESSION["priority"]) === FALSE ){
    //            echo "<script language='javascript'>
    //        window.alert('Sorry, this is protected ');
    //        window.close();
    //    </script>";
    //    exit();
    //}
    //else{
        $userDept  = $user_info[0]['priority_dept'];
        $userDept  = explode(',', $userDept);

	    $invoiceTpl->assign("sArray",$_SESSION);
	    $invoiceTpl->assign("user_array",$user_info);
        $invoiceTpl->assign("userDept",$userDept);
	    $invoiceTpl->assign("deptArray",$db->SelectSql($deptSql));
	    $invoiceTpl->assign("cityArray",$db->SelectSql($citySql));
	    $invoiceTpl->display("account_user_modify.htm");
    //}
}
else {
		echo "<script language='javascript'>
			window.alert('Sorry, this is protected ');
			window.close();
		</script>";
}

?>