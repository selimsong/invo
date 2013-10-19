<?php
/*
 * @Copyright (c) 2007, www.cushwake.com
 * @All rights reserved.
 *
 * @File name：fill_form.php
 * 
 * @summery：fill invoice form
 *
 * @author：leon.zhao@ap.cushwake.com
 * @date：06.22.2007 10:22 AM
 *
 */
require_once(dirname(__FILE__) . "/invoice.config.php");
require_once(dirname(__FILE__) . "/adodb.class.php");
require_once(dirname(__FILE__) . "/ldap_connect.php");

date_default_timezone_set("Asia/Shanghai");

$email_server = "@ap.cushwake.com";

/*
 * user connection && create
 * #1 if new user added in exchange server when he login irq system , if authorited with LDAP server, new user would be added in irq local database
 * #2 if this user login to irq system second time, irq would get the local system to check if his name & password correct ,if correct ,login in ,if not ,
 * the irq system would connect to the LDAP server to check if his name & password right.if authorited ,update the local database with his password or exit if error.
 * 
 */

$login_flag = false;

$db = new dbClass($db_ado);

//check if 3 times error hack
$error_log = "SELECT * FROM " . LOG . " WHERE log_name='" . $_POST["name"] . "' AND log_time>'" . date("Y-m-d H:i:s", (time()-600)) . "' AND log_status='0'";
$check_error = $db->SelectSql($error_log);
if($check_error && count($check_error) > 2){
    echo "<script language='javascript'>
            window.alert('You have logined over 3 times error!\\nPlease try again 10 minutes later');
            window.location='login.php';
            </script>";
    exit();
}




$loginSql = "SELECT * FROM " . USER . " WHERE user_name like '" . $_POST["name"] . "'";
$userArray = $db->SelectSql($loginSql);
if($userArray && (md5($_POST["password"]) == $userArray[0]["password"]) )
{
    $login_flag = true;
}
else if($userArray && (md5($_POST["password"]) != $userArray[0]["password"])){   
    $ldap_obj = new ldap_invoice();
    if(!($ldap_obj->get_ldap_array("(mail=" . $_POST["name"] . $email_server . ")",$_POST["name"] . $email_server ,$_POST["password"]))){
        $login_flag = false;
        echo "<script language='javascript'>
            window.alert('Error password.');
            window.location='login.php';
        </script>";
    }
    else{
        $upArray["password"] = md5($_POST["password"]);
        $db->setSqlWhere(" WHERE (`user_name`='" . $_POST["name"] . "')  ");
        $updateResult = $db->updateTable(USER,$upArray);
        $loginSql = "SELECT * FROM " . USER . " WHERE user_name='" . $_POST["name"] . "'";
        $userArray = $db->SelectSql($loginSql);
        $login_flag = true;
    } 
}
else if(!$userArray) {
    $ldap_obj = new ldap_invoice();
    if(!($ldap_obj->get_ldap_array("(mail=" . $_POST["name"] . $email_server . ")",$_POST["name"] . $email_server,$_POST["password"]))){
        $login_flag = false; 
    }
    else{
        $ldap_obj->format_country();
        $rs = $ldap_obj->info_array;
        $dept_Sql = "SELECT * FROM " . DEPT . " WHERE Dept_desc='" . $rs[0]["department"][0] . "'";
        $dept_Array = $db->SelectSql($dept_Sql);
        if($dept_Array)$dept = $dept_Array[0]["Dept_code"]; else{ $dept = $rs[0]["department"][0];}
       
        
        
        $insertArray["user_name"] = $_POST["name"];
        $insertArray["password"] = md5($_POST["password"]);
        $insertArray["invoice_add"] = 0;
        $insertArray["invoice_view"] = 0;
        $insertArray["invoice_modify"] = 0;
        $insertArray["priority_dept"] = $dept;
        $insertArray["priority_city"] = substr($rs[0]["physicaldeliveryofficename"][0],0,-7);
        $insertArray["priority_country"] = $rs[0]["co"][0];
        $insertArray["user_type"] = "user";
        $insertArray["power"] = "10";
        $add_user = $db->insert(USER,$insertArray);
        $loginSql = "SELECT * FROM " . USER . " WHERE user_name='" . $_POST["name"] . "'";
        $userArray = $db->SelectSql($loginSql);
        $login_flag = true; 
    }    
}


if($login_flag){
        $log_sql = "INSERT INTO `" . LOG . "` (`log_id`,`log_name`,`log_time`,`log_status`,`user_ip`) VALUES (NULL,'" . $_POST["name"] . "','" . date("Y-m-d H:i:s") . "','1','" . $_SERVER['REMOTE_ADDR'] . "')";
        $db_ado->Execute($log_sql);
		session_start();
		session_register("ID");
		session_register("user_name");
		session_register("password");
		session_register("default_country");
		session_register("default_city");
		session_register("default_dept");
		session_register("priority_country");
		session_register("priority_city");
		session_register("priority_dept");
		session_register("power");
		session_register("invoice_add");
		session_register("invoice_view");
		session_register("invoice_modify");
		session_register("user_type");
        session_register("currency_manger");
        session_register("approve");
		
		session_register("sqlWhere");
		session_register("search_url");
        session_register("login_time");
		
		$_SESSION["ID"] = $userArray[0]["ID"];
		$_SESSION["user_name"] = $userArray[0]["user_name"];
		$_SESSION["password"] = $userArray[0]["password"];
		$_SESSION["default_country"] = $userArray[0]["default_country"];
		$_SESSION["default_city"] = $userArray[0]["default_city"];
		$_SESSION["default_dept"] = $userArray[0]["default_dept"];
		$_SESSION["priority_country"] = $userArray[0]["priority_country"];
		$_SESSION["priority_city"] = $userArray[0]["priority_city"];
		$_SESSION["priority_dept"] = $userArray[0]["priority_dept"];
		$_SESSION["power"] = $userArray[0]["power"];
		$_SESSION["invoice_add"] = $userArray[0]["invoice_add"];
		$_SESSION["invoice_view"] = $userArray[0]["invoice_view"];
		$_SESSION["invoice_modify"] = $userArray[0]["invoice_modify"];
		$_SESSION["user_type"] = $userArray[0]["user_type"];
        $_SESSION["currency_manager"] = $userArray[0]["currency_manager"];
        $_SESSION["approve"] = $userArray[0]["approve"];

        
        $_SESSION["login_time"] = time();
//		print_r($_SESSION);
//		exit();
		if($_SESSION["user_type"] == "Administrator" || $_SESSION["user_type"] == "Account"){
			echo "<script>window.location='admin_index.php'</script>";
		}
		else{
            echo "<script>window.location='search_list.php'</script>"; 
		}
}
else {
        $log_sql = "INSERT INTO `" . LOG . "` (`log_id`,`log_name`,`log_time`,`log_status`,`user_ip`) VALUES (NULL,'" . $_POST["name"] . "','" . date("Y-m-d H:i:s") . "','0','" . $_SERVER['REMOTE_ADDR'] . "')";
        $db_ado->Execute($log_sql);
	echo "<script language='javascript'>
			window.alert('Error login name,please check the name and try again');
			window.location='login.php';
		</script>";
}
?>