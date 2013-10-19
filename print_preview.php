<?php
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
//page initial

$db = new dbClass($db_ado);

if(isset($_GET["ID"]))$ID = $_GET["ID"];
$db = new dbClass($db_ado);
$idArray = $db->getSpecificInfoById(INVLIST,$ID);    
if($idArray[0]["curr_info"] == "") 
{    
    $countryArray = $db->SelectSql("SELECT ID,Country,default_curr_code FROM " . COUNTRY . " WHERE Country='" . $idArray[0]["Country"] . "'");
    $idArray[0]["curr_info"] = $countryArray[0]["default_curr_code"];
    $idArray[0]["curr_info_id"] = $countryArray[0]["ID"];
}

if(checkPriority($idArray,'1')){
    reset($idArray);
    $idArray = patternNumToString($idArray);
//    $idArray = patternNumToString($idArray);
    //print_r($idArray);
    $invoiceTpl->assign("curr_info_id",$idArray[0]["curr_info_id"]); 
    $invoiceTpl->assign("sArray", $_SESSION);
    $invoiceTpl->assign("idArray", $idArray);
    $invoiceTpl->assign("doc_type", $doc_types);
    $invoiceTpl->display("print_preview.htm");
}
else{
		echo "<script language='javascript'>
			window.alert('Sorry, this invoice details information is protected ');
			window.close();
		</script>";
}
//print_r($db);
?>