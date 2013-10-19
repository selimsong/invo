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

if($_SESSION["user_type"] == "Administrator" || (($_SESSION["user_type"] == "Account" ) && $_SESSION["currency_manager"] == "1" )){
	$db = new dbClass($db_ado);
	$ListSqlThisYearGroup = "SELECT curr_code FROM " . CURRENCY . " WHERE period_year='" . date("Y",time()) . "' GROUP BY curr_code";
	$listArrayGroup = $db->SelectSql($ListSqlThisYearGroup);
	if($listArrayGroup){
		$listArray = array();
		foreach($listArrayGroup as $key=>$curr_code){
			$ListSqlThisYear = "SELECT * FROM " . CURRENCY . " WHERE period_year='" . date("Y",time()) . "' AND curr_code='" . $curr_code["curr_code"] . "'";
	//		echo $ListSqlThisYear . "<br>";
			$returnArray = $db->SelectSql($ListSqlThisYear);
			$listArray[$key]["curr_code"] = $curr_code["curr_code"];
			foreach ($returnArray as $num=>$values){
				
				$listArray[$key]["month" . $values["period_month"]]= $values["curr_rate"];
			}
		}
		$invoiceTpl->assign("currList",$listArray);
	}
	$invoiceTpl->assign("sArray",$_SESSION);
	$invoiceTpl->display("admin_curr_info_list.htm");
//}
//else {
//		echo "<script language='javascript'>
//			window.alert('Sorry, this is protected ');
//			window.close();
//		</script>";
}

?>