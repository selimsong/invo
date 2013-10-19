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

if($_POST["user_id"] == ""){
            echo "<script language='javascript'>
            window.alert('Sorry, error loading page');
            window.close();
        </script>";
}
$dept = "";
foreach($_POST["priority_dept"] as $k=>$n){
    $dept .=  $n . ",";
}
$dept = substr($dept,0, -1);

$upArray["ID"] = $_POST["user_id"];
$upArray["priority_city"] = $_POST["priority_city"]; 
$upArray["priority_dept"] = $dept; 
$upArray["power"] = $_POST["power"]; 
$upArray["invoice_add"] = $_POST["invoice_add"]; 
$upArray["invoice_view"] = $_POST["invoice_view"]; 
$upArray["invoice_modify"] = $_POST["invoice_modify"]; 
$upArray["approve"] = $_POST["approve"];

if($_SESSION["user_type"] == "Account" || $_SESSION["user_type"] == "Administrator"){
	$db = new dbClass($db_ado);
    $db->setSqlWhere(" WHERE ID='" . $_POST['user_id'] . "'");
    $upr = $db->updateTable(USER,$upArray);
    
    //if(stristr($user_info[0]["priority_country"],$_SESSION["priority"]) === FALSE ){
    //            echo "<script language='javascript'>
    //        window.alert('Sorry, this is protected ');
    //        window.close();
    //    </script>";
    //    exit();
    //}
    //else{
    if($upr){
             echo "<script language='javascript'>
            window.alert('Success!');
            window.location='account_user_list.php';
        </script>";
    }
    else{
        echo "<script language='javascript'>
            window.alert('error!');
            window.history.back();
        </script>";
    }
    //}
}
else {
		echo "<script language='javascript'>
			window.alert('Sorry, this is protected ');
			window.close();
		</script>";
}

?>