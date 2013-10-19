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
              
if(is_array($_POST["app_list"])){
    $db = new dbClass($db_ado);
    foreach($_POST["app_list"] as $k=>$v){
        $db->setSqlWhere(" WHERE (`ID`='" . $v . "')  ");
        $u["trans_state"] = 2;
        $u["approved_by"] = $_SESSION["ID"];
        $u["approved_date"] = date("Y-m-d H:i:s");
        $r = $db->updateTable(INVLIST,$u);
    }    
}

echo "<script language='javascript'>
window.alert('Approved ok. The invoice has been changed to status 2');
window.close();
</script>";
?>