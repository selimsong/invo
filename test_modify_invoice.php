<?php
/*
 * @Copyright (c) 2007, www.cushwake.com
 * @All rights reserved.
 *
 * @File name：modify_invoice.php
 * 
 * @summery：modify invoice
 *
 * @author：leon.zhao@ap.cushwake.com
 * @date：10.22.2007 10:22 AM
 *
 */
require_once(dirname(__FILE__) . "/invoice.config.php");
require_once(dirname(__FILE__) . "/comm.inc.php");
require_once(dirname(__FILE__) . "/adodb.class.php");
require_once(dirname(__FILE__) . "/check_sess.php");
require_once(__LIBPATH . "class/func.php");
require_once(__AJAXPAGE . "fill_form.invoice.common.php");
require_once("xajax.invoice.php");
//require_once(dirname(__FILE__) . "/banner.php");

//$invoiceTpl->display("login.htm");
$db = new dbClass($db_ado);
$allCountry = $db->getInfo(COUNTRY);
foreach ($allCountry as $num=>$array){
    $curr_code_Array[$array["ID"]] = $array["default_curr_code"];
}



if(isset($_GET["ID"]))$ID = $_GET["ID"];
$db = new dbClass($db_ado);
$idArray = $db->getSpecificInfoById(INVLIST,$ID);	

$dept = $db->SelectSql("Select * from " . DEPT2 . " WHERE dept2_country = '" . $idArray[0]["Country"] . "'");



if($idArray[0]["curr_info"] == "") 
{	
	$countryArray = $db->SelectSql("SELECT ID,Country,default_curr_code FROM " . COUNTRY . " WHERE default_curr_code='" . $idArray[0]["curr_code"] . "'");
	$idArray[0]["curr_info"] = $countryArray[0]["default_curr_code"];
    $idArray[0]["curr_info_id"] = $countryArray[0]["ID"];
}

$invoiceTpl->assign("selectedCurr",$idArray[0]["curr_info"]);
$invoiceTpl->assign("countryArray",$newAllCountry);

//print_r($newAllCountry);

if(checkPriority($idArray,'2')){
	reset($idArray);
//	$idArray = patternNumToString($idArray);
	if($idArray[0]["Modified_date"] == ""){
		$idArray[0]["Modified_date"] = date("Y-m-d",time());
		$idArray[0]["Modified_by"] = $_SESSION["user_name"];
	}
    $db->setSqlWhere(" WHERE user_type='user' AND priority_country='" . $_SESSION["priority_country"] . "'");
    $userListArray = $db->getInfo(USER);
    
    
    $cityArr = $db->SelectSql("SELECT * FROM " . CITY . " WHERE Country='" . $idArray[0]["Country"] . "'");
    
    $invoiceTpl->assign("userListArray",$userListArray);
	//print_r($idArray);
    reset($idArray);
    $idArray = patternNumToString($idArray);

    $invoiceTpl->assign("curr_info_id",$idArray[0]["curr_info_id"]);
	$invoiceTpl->assign('fill_form_ajax', $xajax->getJavascript($_xajaxJs));
    $invoiceTpl->assign("deptArray", $dept); 
    $invoiceTpl->assign("curr_code_array", $curr_code_Array); 
	$invoiceTpl->assign("sArray", $_SESSION);
    $invoiceTpl->assign("city", $cityArr);
	$invoiceTpl->assign("idArray", $idArray);
    $invoiceTpl->assign("doc_type", $doc_types);
	$invoiceTpl->display("test_modify_invoice.htm");
}
else{
		echo "<script language='javascript'>
			window.alert('Sorry, this invoice details information is protected ');
			window.close();
		</script>";
}
?>