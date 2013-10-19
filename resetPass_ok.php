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
require_once(dirname(__FILE__) . "/adodb.class.php");

$db = new dbClass($db_ado); 
if($_SESSION["password"] == md5($_POST["old_pass"])){
    $updateSql = ""; 
    $updateSql = "UPDATE " . USER . " SET password='" . md5($_POST["new_pass"]);
    $updateSql .= "' WHERE user_name='" . $_SESSION["user_name"] . "' limit 1";
    mysql_query($updateSql);
    echo "<script language='javascript'>
        window.alert('Reset password ok!');
        window.close();
        </script>";    
}
else{
        echo "<script language='javascript'>
        window.alert('Error, please make sure you type in the old password correctly!');
        window.close();
        </script>";  
}                                     
?>