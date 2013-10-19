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
$sql = "SELECT * FROM " . INVLIST . " as l left join " . DEPT2 . " as r on l.Dept2_info=r.dept2_id WHERE ID=$ID";
$idArray = $db->SelectSql($sql);   
if($idArray[0]["curr_info"] == "") 
{    
    $countryArray = $db->SelectSql("SELECT ID,Country,default_curr_code FROM " . COUNTRY . " WHERE Country='" . $idArray[0]["Country"] . "'");
    $idArray[0]["curr_info"] = $countryArray[0]["default_curr_code"];
    $idArray[0]["curr_info_id"] = $countryArray[0]["ID"];
}

$currentDept    = $_SESSION["priority_dept"];
if('2.5' == $_SESSION['power'] || '2.3' == $_SESSION['power']){
	if(!empty($currentDept)){
		$currentDeptInfo = $db->SelectSql("SELECT dept2_id,dept2_code FROM " . DEPT2 . " WHERE  dept2_id='$currentDept' ");
		$globalDept  = $db->SelectSql("SELECT dept2_id FROM " . DEPT2 . " WHERE  dept2_code='".$currentDeptInfo[0]['dept2_code']."' ");
	}else{
		$globalDept = array();
	}
}

$t_access = false;
foreach ($globalDept as $value){
	if($idArray[0]['Dept2_info'] == $value['dept2_id']){
		$t_access = true;
	}
}

if(checkPriority($idArray,'1') || $t_access == true){
    reset($idArray);
    $idArray = patternNumToString($idArray);
    
//    $idArray = patternNumToString($idArray); 
    
    $invoiceTpl->assign("curr_info_id",$idArray[0]["curr_info_id"]); 
    $invoiceTpl->assign("sArray", $_SESSION);
    $invoiceTpl->assign("doc_type", $doc_types);
    $invoiceTpl->assign("idArray", $idArray);
    $invoiceTpl->display("search_getDetail.htm");
}
else{
        echo "<script language='javascript'>
            window.alert('Sorry, this invoice details information is protected ');
            window.close();
        </script>";
}
?>