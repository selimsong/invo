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

function changeArrayPattern($array){
	$arrayNew = array();
	foreach ($array as $key1=>$values1){
		$key1 = explode("-",$key1);
		if(count($key1) > 1)
		$arrayNew[$key1["1"]][$key1["0"]] = 1;
	}
	return $arrayNew;
}

$updateArray = changeArrayPattern($_POST);

//print_r($updateArray);
if($_SESSION["user_type"] == "Account"){
	$db = new dbClass($db_ado);
	$updateToZero = "update " . USER . " SET `invoice_view` = 0,`invoice_modify` = 0,`invoice_add` = 0 WHERE `user_info`.`power` >  '4' AND `user_info`.`priority_country` = '" . $_SESSION["priority_country"] . "'";
	mysql_query($updateToZero);
	foreach ($updateArray as $ID => $array){
		$db->setSqlWhere(" WHERE ID=$ID");
		$db->updateTable(USER, $array);
	}
	//$update = $db->updateTable(USER, $_POST);
	header("location:account_user_list.php");
}
else {
		echo "<script language='javascript'>
			window.alert('Sorry, this is protected ');
			window.close();
		</script>";
}

?>