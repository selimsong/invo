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


if($_SESSION["user_type"] == "Account" || $_SESSION["user_type"] == "Administrator"){
	$db = new dbClass();

    $sqlWhere =  " as l left join " . DEPT . " as r on l.dept_id = r.ID WHERE l.`dept2_country` =  '" . $_SESSION["priority_country"] . "' ";
    $db->setOrderBy(" dept_id "); 

    $db->setSqlWhere($sqlWhere);
    $page->setTotalByArray($db->getInfo(DEPT2));                                         
    $dept2Array = $db->getInfo(DEPT2);        	

    $invoiceTpl->assign("sArray",$_SESSION);
	$invoiceTpl->assign("dept2Array",$dept2Array);
	$invoiceTpl->display("account_dept2_list.htm");
}
else {
		echo "<script language='javascript'>
			window.alert('Sorry, this is protected ');
			window.close();
		</script>";
}

?>