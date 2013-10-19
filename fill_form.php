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
require_once(dirname(__FILE__) . "/comm.inc.php");
require_once(dirname(__FILE__) . "/adodb.class.php");
require_once(dirname(__FILE__) . "/check_sess.php");
require_once(dirname(__FILE__) . "/banner.php");

require_once(__AJAXPAGE . "fill_form.invoice.common.php");
require_once("xajax.invoice.php");

$db = new dbClass($db_ado);

$countryArray = $db->getInfo(COUNTRY);
$deptArray = $db->getInfo(DEPT);

$db->setSqlWhere(" WHERE user_type='user' AND priority_country='" . $_SESSION["priority_country"] . "'");
$db->setOrderBy(' user_name ');
$userListArray = $db->getInfo(USER);

$key_client = $db->SelectSql("select Client_Solutins_Major	as client from ". MAG ." group by Client_Solutins_Major ");

$invoiceTpl->assign("key_client",$key_client);
$invoiceTpl->assign("userListArray",$userListArray);
//print_r($userListArray);

$invoiceTpl->assign("doc_type",$doc_types);
$invoiceTpl->assign('sArray',$_SESSION);
$invoiceTpl->assign('fill_form_ajax', $xajax->getJavascript($_xajaxJs));
$invoiceTpl->assign("todayDate",$todayDate["fullDate"]);
$invoiceTpl->assign("countryArray",$countryArray);
$invoiceTpl->assign("deptArray",$deptArray);
$invoiceTpl->display("fill_form.htm");

?>