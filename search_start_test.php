<?php
/*
 * @Copyright (c) 2007, www.cushwake.com
 * @All rights reserved.
 *
 * @File name：search_start_test.php
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
//print_r($_GET);
//page initial
$sqlInvoiceNo = ($_POST["Transaction_No"] == "")?(false):($_POST["Transaction_No"]); 
$sqlDocNo = ($_POST["doc_type_num"] == "")?(false):($_POST["doc_type_num"]);
if(!isset($_GET["orderBy"])) $orderBy = $_POST["orderBySelect"];else $orderBy = $_GET["orderBy"];
$selectedCountry = $_GET["country"]?$_GET["country"]:$_POST["searchCountry"];
$selectedCity = $_GET["City"]?$_GET["City"]:$_POST["City"];
$selectedDocType = $_GET["doc_type"]?$_GET["doc_type"]:$_POST["doc_type"];

$selectedDept = $_GET["selectedDept"]?$_GET["selectedDept"]:$_POST["selectedDept"];
$selectedDept = ($selectedDept == "R_A")?("R&A"):$selectedDept;
$selectedMAG = $_GET["selectedMAG"]?$_GET["selectedMAG"]:$_POST["selectedMAG"];
$selectedMAG = ($selectedMAG == "S_S")?("S&S"):$selectedMAG;
$selectedState = $_GET["trans_state"]?$_GET["trans_state"]:$_POST["trans_state"];
$date1 = $_GET["date1"]?$_GET["date1"]:$_POST["date1"];
$date2 = $_GET["date2"]?$_GET["date2"]:$_POST["date2"];
$Client = $_GET["Client"]?$_GET["Client"]:$_POST["Client"];
$invoice_to_trading_name = $_GET["invoice_to_trading_name"]?$_GET["invoice_to_trading_name"]:$_POST["invoice_to_trading_name"];
$sqft = $_GET["sqft"]?$_GET["sqft"]:$_POST["sqft"];

$d = $_GET["desc"]?$_GET["desc"]:$_POST["desc"];
$desc = ($d == "asc")?"": " DESC ";

$sql_fee_split = "";
if(trim($_POST["fee_split"]) != "" || trim($_GET["fee_split"]) != ""){
    $fee_split = (trim($_POST["fee_split"]) == "")?trim($_GET["fee_split"]):trim($_POST["fee_split"]);
    $fee_split = str_replace(" ",".",$fee_split);
    $fields = "Fee_sharing_p1,Fee_sharing_p2,Fee_sharing_p3,Fee_sharing_p4,Fee_sharing_p5,Fee_sharing_p6,Fee_sharing_p7,Fee_sharing_p8,Fee_sharing_p9,Fee_sharing_p10";    
    if($_SESSION["power"] == 10){
        if(strtolower($fee_split) == strtolower($_SESSION["user_name"])){
            $sql_fee_split = " HAVING '" . $fee_split . "' IN (" . $fields . ") ";
        }
        else{
                echo "<script language='javascript'>
                        window.alert('Sorry, other user\' data is protected!');
                        window.location='./search_list.php';
                        </script>";
                exit();
        }    
    }
    elseif($_SESSION["power"] == 5){
        $sql_fee_split = " HAVING '" . $fee_split . "' IN (" . $fields . ") ";
        $selectedCountry = $_SESSION["priority_country"];
        $selectedCity = $_SESSION["priority_city"];
    }
    elseif($_SESSION["power"] == 4){
        $sql_fee_split = " HAVING '" . $fee_split . "' IN (" . $fields . ") ";
        $selectedCountry = $_SESSION["priority_country"];     
    }
    elseif($_SESSION["power"] <=2){
        $sql_fee_split = " HAVING '" . $fee_split . "' IN (" . $fields . ") ";         
    }
    else{exit();}
}
print_r($_SESSION);
$sqlCountry = ($selectedCountry == "all")?("WHERE 1"):("WHERE `Country`='" . $selectedCountry . "' ");
if($selectedCountry == "China_Hong Kong"){
    $sqlCountry = "WHERE `Country` in ('China','Hong Kong') ";
}

$sqlDocType = ($selectedDocType == "All")?(""):(" AND `doc_type`='" . $selectedDocType . "' ");
$sqlCity = ($selectedCity == "all")?(""):(" AND `City`='" . $selectedCity . "' "); 

 
$sqlDept = ($selectedDept == "all")?(""):(" AND `Dept_info`='" . $selectedDept . "' "); 
$sqlMAG = ($selectedMAG == "all" || $selectedMAG == '')?(""):(" AND `Client_Solutins_Major`='" . $selectedMAG . "' "); 
$sqlTrans_state = ($selectedState == "6")?(""):(" AND `trans_state`='" . $selectedState . "' ");
$sqlDate =  " AND `Invoice_date` BETWEEN '" . $date1 . "' AND '" . $date2 . "'";
$sqlClient = " AND `Client` LIKE  '%" . $Client . "%'";
$sqlInvoice_to_trading_names = " AND `invoice_to_trading_name` LIKE  '%" . $invoice_to_trading_name . "%'"; 

$sqlWhere = $sqlCountry . $sqlCity . $sqlDocType . $sqlDept . $sqlMAG . $sqlDate . $sqlClient  . $sqlInvoice_to_trading_names . $sqlTrans_state; 
if($sqlInvoiceNo)
$sqlWhere .= " AND `Transaction_No` LIKE '%" . $sqlInvoiceNo . "%' ";
if($sqlDocNo)
$sqlWhere .= " AND `doc_type_num` LIKE '%" . $sqlDocNo . "%' OR `Invoice_No` LIKE '%" . $sqlDocNo . "%'";
if($sql_fee_split)
$sqlWhere .= $sql_fee_split;


$db = new dbClass($db_ado);
$countryArray = $db->SelectSql("SELECT * FROM " . COUNTRY . " ORDER BY Country");
$deptArray = $db->getAllInfo(DEPT);
$majorAcountGroupArray = $db->SelectSql("SELECT * FROM " . MAG . " GROUP BY Client_Solutins_Major");

$db->setOrderBy($orderBy . $desc);
$db->setSqlWhere($sqlWhere);
$page->page_records_num = 30;
echo "from ".INVLIST." ".$sqlwhere;
$r = mysql_query("SELECT * FROM " . INVLIST . " " . $sqlWhere);
$page->setTotal(mysql_num_rows($r));





$invoiceTpl->assign("selectedDept", $selectedDept);
$invoiceTpl->assign("selectedMAG", $selectedMAG);
$selectedDept = ($selectedDept == "R&A")?("R_A"):$selectedDept;
$selectedMAG = ($selectedMAG == "S&S")?("S_S"):$selectedMAG;
$fileNames = $orderBy . "&date1=" . $date1 . 
            "&date2=" . $date2 . "&country=" . $selectedCountry . "&doc_type=" . $selectedDocType . 
            "&selectedDept=" . $selectedDept . "&Client=" . $Client . 
            "&selectedMAG=" . $selectedMAG  .
            "&trans_state=" . $selectedState . "&City=" . $selectedCity . "&fee_split=" . $fee_split . "&invoice_to_trading_name=" . $invoice_to_trading_name . "&desc=" . $d;
$page->setFileName("search_start_test.php?orderBy=" . $fileNames);

$_SESSION["sqlWhere"] = $sqlWhere;
$_SESSION["search_url"] = "search_start_test.php?orderBy=" . $fileNames;
print_r($_POST);
echo "<br />"; echo $_SESSION['sqlwhere'].'.......';

$db->setLimitRecords(($page->pp-1) * $page->page_records_num, $page->page_records_num);


$rowArray = $db->getInfo(INVLIST);

$invoiceTpl->assign("date1", $date1);
$invoiceTpl->assign("date2", $date2);

$invoiceTpl->assign("selectedCountry", $selectedCountry);
$invoiceTpl->assign("Client", $Client);
$invoiceTpl->assign("invoice_to_trading_name", $invoice_to_trading_name);
$invoiceTpl->assign("fee_split", $fee_split);

$invoiceTpl->assign('state_options', $trans_state);
$invoiceTpl->assign('selectedState', $selectedState);
$invoiceTpl->assign("countryArray",$countryArray);
$invoiceTpl->assign("deptArray",$deptArray);
$invoiceTpl->assign("MAGroup",$majorAcountGroupArray);
$invoiceTpl->assign("invoiceAmountAbove",$selectedInvoiceAmountAbove);
$invoiceTpl->assign("doc_type", $doc_types);
$invoiceTpl->assign("selected_doc_type", $selectedDocType);
$invoiceTpl->assign("search_conditions", $fileNames);
$invoiceTpl->assign('search_ajax', $xajax->getJavascript($_xajaxJs));  

$invoiceTpl->assign("searchFields", $searchFields);
$invoiceTpl->assign("desc", $d);
$invoiceTpl->assign("orderBy", $orderBy);
$rowArray = patternNumToString($rowArray);
$invoiceTpl->assign("listArray", $rowArray);
$invoiceTpl->assign("sArray",$_SESSION);
$invoiceTpl->assign("PAGELINK", $page->getPageIndex());
$invoiceTpl->display("search_list_test.htm");
//print_r($db);
?>