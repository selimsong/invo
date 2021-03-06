﻿<?php
/*
 * @Copyright (c) 2007, www.cushwake.com
 * @All rights reserved.
 *
 * @File name：search_list.php
 * 
 * @summery：get the list of the search result
 *
 * @author：leon.zhao@ap.cushwake.com
 * @date：06.22.2007 10:22 AM
 *
 */
require_once(dirname(__FILE__) . "/invoice.config.php");
require_once(dirname(__FILE__) . "/comm.inc.php"); 
require_once(dirname(__FILE__) . "/adodb.class.php");
require_once(dirname(__FILE__) . "/check_sess.php");
require_once(dirname(__FILE__) . "/banner.php");
require_once(__LIBPATH . "class/func.php");
require_once(__AJAXPAGE . "fill_form.invoice.common.php");
require_once("xajax.invoice.php");



//page initial
if(isset($_GET["pp"]))$page->setPp($_GET["pp"]);
if(isset($_GET["current_index_num"]))$page->setCurrentIndexNum($_GET["current_index_num"]);
if(isset($_GET["orderBy"]))$orderBy = $_GET["orderBy"];
else $orderBy = "ID DESC";


$db = new dbClass($db_ado);
$countryArray = $db->SelectSql("SELECT * FROM " . COUNTRY . " ORDER BY Country");
$deptArray = $db->getAllInfo(DEPT);
$majorAcountGroupArray = $db->SelectSql("SELECT * FROM " . MAG . " GROUP BY Client_Solutins_Major");

//get the invoice record of this year as default search condition.
$date1 = date("Y-01-01",time());
$date2 = date("Y-m-d",time());
$sqlDate =  " WHERE `City`='" . $_SESSION["priority_city"] . "' AND `Invoice_date` BETWEEN '" . $date1 . "' AND '" . $date2 . "'";

$currentDept    = $_SESSION["priority_dept"];
if('2.5' == $_SESSION['power'] || '2.3' == $_SESSION['power']){
	if(!empty($currentDept)){
		$currentDeptInfo = $db->SelectSql("SELECT dept2_id,dept2_code FROM " . DEPT2 . " WHERE  dept2_id='$currentDept' ");
		$globalDept  = $db->SelectSql("SELECT dept2_id FROM " . DEPT2 . " WHERE  dept2_code='".$currentDeptInfo[0]['dept2_code']."' ");
		$_orSql=null;
		for($i=0; $i< count($globalDept); $i++){
			$_orSql.= " OR Dept2_info='". $globalDept[$i]['dept2_id']."'   ";
		}
		$sqlDate =  " WHERE ( `City`='" . $_SESSION["priority_city"] . "'  ".$_orSql."  ) AND `Invoice_date` BETWEEN '" . $date1 . "' AND '" . $date2 . "'";
	}else{
		$globalDept = array();
	}
}


$db->setSqlWhere($sqlDate);
$db->setOrderBy($orderBy);

$r = mysql_query("SELECT * FROM " . INVLIST . " " . $sqlDate);
$page->setTotal(mysql_num_rows($r));
$page->page_records_num = 30;
$page->setFileName("search_list.php?orderby=" . $orderBy);

$_SESSION["sqlWhere"] = $sqlWhere;
$_SESSION["search_url"] = "search_list.php";


$db->setLimitRecords(($page->pp-1) * $page->page_records_num, $page->page_records_num);



$invoiceTpl->assign('globalDept', $globalDept);


$invoiceTpl->assign('state_options', $trans_state);
$invoiceTpl->assign('selectedState', "6");
$invoiceTpl->assign("date1", $date1);
$invoiceTpl->assign("date2", $date2);
$rowArray = $db->getInfo(INVLIST);
$invoiceTpl->assign("countryArray",$countryArray);
$invoiceTpl->assign("deptArray",$deptArray);
$invoiceTpl->assign("MAGroup",$majorAcountGroupArray);
$invoiceTpl->assign("invoiceAmountAbove",0);
$invoiceTpl->assign("doc_type", $doc_types);
$invoiceTpl->assign('search_ajax', $xajax->getJavascript($_xajaxJs));

$invoiceTpl->assign("searchFields", $searchFields);
$invoiceTpl->assign("orderBy", $orderBy);
$rowArray = patternNumToString($rowArray);
$invoiceTpl->assign("listArray", $rowArray);
$invoiceTpl->assign("sArray",$_SESSION);
$invoiceTpl->assign("PAGELINK", $page->getPageIndex());
$invoiceTpl->display("search_list.htm");
//print_r($db);
?>