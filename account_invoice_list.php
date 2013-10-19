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
require_once(__LIBPATH . "class/func.php");


if($_SESSION["user_type"] == "Administrator" ||$_SESSION["user_type"] == "Account"){

if(isset($_GET["pp"]))$page->setPp($_GET["pp"]);
if(isset($_GET["current_index_num"]))$page->setCurrentIndexNum($_GET["current_index_num"]);
$orderBy = "ID DESC";


$sql = "";
$sql .=  " WHERE `Invoice_date` BETWEEN '" . date("2000-01-01",time()) . "' AND '" . date("Y-m-d",time()) . "'";
if($_SESSION["power"] == 4){
	if($_SESSION["priority_country"] == "China_Hong Kong"){
		$sqlCountry = " AND Country IN ('China','Hong Kong') ";
	}
	else {
		$sqlCountry = " AND Country='" . $_SESSION["priority_country"] . "' ";
	}
}
$sql .= $sqlCountry;
$db = new dbClass($db_ado);
$db->setOrderBy($orderBy);


$db->setSqlWhere($sql);
$page->setTotalByArray($db->getInfo(INVLIST));
$page->page_records_num = 30;
//$page->setFileName("search_list.php?orderby=" . $orderBy);
$db->setLimitRecords(($page->pp-1) * $page->page_records_num, $page->page_records_num);
$rowArray = patternNumToString($db->getInfo(INVLIST));
//print_r($rowArray);



	$invoiceTpl->assign("listArray", $rowArray);
	$invoiceTpl->assign("PAGELINK", $page->getPageIndex());
	$invoiceTpl->assign("sArray",$_SESSION);
	$invoiceTpl->display("account_invoice_list.htm");
}
else{
			echo "<script language='javascript'>
			window.alert('Error, if you are Administrator, please login first');
			window.parent.location='login.php';
		</script>";
}
?>