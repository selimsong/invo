<?php
/*
 * @Copyright (c) 2007, www.cushwake.com
 * @All rights reserved.
 *
 * @File name：
 * 
 * @summery：
 *
 * @author：leon.zhao@ap.cushwake.com
 * @date：06.22.2007 10:22 AM
 *
 */
require_once(dirname(__FILE__) . "/invoice.config.php");
require_once(dirname(__FILE__) . "/adodb.class.php");
require_once(dirname(__FILE__) . "/check_sess.php");


if($_SESSION["approve"] == 0){
        $alert = "Sorry, You do not have the right to approve the invoice!";    
        echo "<script language='javascript'>
            window.alert('$alert');
            window.close();
            </script>";
        exit();
}


// INVLIST--ap07    
 $db = new dbClass($db_ado);
$approve_list_sql = "SELECT * FROM " . INVLIST . " WHERE Country like '" . $_SESSION["priority_country"] . "' AND trans_state=1 AND dept2_info in (" . $_SESSION["priority_dept"] . ")";
echo $approve_list_sql;
$r = $db->SelectSql($approve_list_sql);

    $invoiceTpl->assign("sArray",$_SESSION);
    $invoiceTpl->assign("listArray",$r);
    $invoiceTpl->display("approve_list.htm");


?>