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
require_once(dirname(__FILE__) . "/comm.inc.php"); 
require_once(dirname(__FILE__) . "/adodb.class.php");

$db = new dbClass($db_ado);
if(trim($_POST["invoice_no"]) != ""){
    $sql = "SELECT * FROM ap_07 where doc_type_num like '" . $_POST["invoice_no"] . "'";
    $r = mysql_query($sql);
    if(mysql_num_rows($r) != 0){
        $rs = mysql_fetch_array($r);
        echo $rs["ID"];
    }
    else{
        echo 'failed';
    }
}
else{
    echo "Null";
}
?>