<?php
/*
 * @Copyright (c) 2007, www.cushwake.com
 * @All rights reserved.
 *
 * @File name：config.inc.php
 * 
 * @summery：global config
 *
 * @author：leon.zhao@ap.cushwake.com
 * @date：06.22.2007 10:22 AM
 *
 */

error_reporting(0);


require_once(dirname(__FILE__) . "/../config/config.inc.php");
//require_once(dirname(__FILE__) . "comm.inc.php");
require_once(__CONFIG . "smarty.config.php");
require_once(__CONFIG . "adodb.config.php");
require_once(__LIBPATH . "class/Multipage.class.php");
//require_once(__LIBPATH . "class/func.php");
date_default_timezone_set("Asia/Shanghai");


if(!defined("__INVOICE")){
	define("__INVOICE", dirname(__FILE__) . "/");
}
/*
 * define the DB name of the invoice system
 * define the table names of every table in invoice system
 */
define("INVOICEDB", "test_staging"); //DB name

define("CUR" , "currency");
define("USER" , "user_info");
//define("INVLIST" , "xls_hk_total");
//define("INVLIST" , "AP_00_06_total");
define("INVLIST" , "ap_07");
define("TTYPE1" , "trx_type_1");
define("TTYPE2" , "trx_type_2");
define("PROPERTY" , "ppt_type");
define("CITY" , "city_info");
define("DEPT" , "dept_info");
define("DEPT2" , "dept2_info");
define("COUNTRY" , "country_info");
define("CURRENCY" , "curr_info");
define("MAG" , "major_acount_group");
define("LOG" , "log_info");


$searchFields = array("Country"=>"Country","Invoice_date"=>"Document Date", "doc_type"=>"Doc Type",
						"dept_info"=>"Dept Info",  "Client"=>"Client", "Sq_Ft"=>"Sq Ft", "Transaction_No"=>"Transaction No.",
                        "Invoice_No"=>"Original Inv No.", "doc_type_num"=>"Doc No.");
//$todayDate = array("fullDate"=>"2000-03-10","Year"=>"2000","Month"=>"03","Day"=>"10"); // For test date only.replace with date("Y-m-d",time());
$todayDate = array("fullDate"=>date("Y-m-d",time()),
					"Year"=>date("Y",time()),
					"Month"=>date("m",time()),
					"Day"=>date("d",time()));
$trans_state = array(
			6 => 'All status',
			1 => 'status1',
			2 => 'status2',
			3 => 'status3',
			4 => 'status4',
			0 => 'trashed');

class InvoiceSmarty extends SmartyAll
{
	function InvoiceSmarty()
	{
		$this->SmartyAll();
		$this->template_dir = __INVOICE . "html/";
	}
}


$db_ado->selectDB(INVOICEDB);
$invoiceTpl = new InvoiceSmarty();


//$invoiceTpl->display("test.htm");
//print_r($db_ado);
?>