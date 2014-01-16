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
require_once(dirname(__FILE__) . "/adodb.class.php");
require_once(dirname(__FILE__) . "/check_sess.php");
require_once(dirname(__FILE__) . "/banner.php");
require_once(__LIBPATH . "class/func.php");
//page initial

$db = new dbClass($db_ado);

if(isset($_GET["ID"]))$ID = $_GET["ID"];
$print_type = $_GET["type"];
$display_URL = "";

//Get the invoice from database
$db = new dbClass($db_ado);
$sql = "SELECT * FROM " . INVLIST . " as l left join " . DEPT2 . " as r on l.Dept2_info=r.dept2_id WHERE ID=$ID";
$idArray = $db->SelectSql($sql);


switch($print_type){
    case "india_1":
        $idArray[0]["service_tax"] = $idArray[0]["Invoice_Amount"] * 0.1;
        $idArray[0]["edu_cess"] = $idArray[0]["Invoice_Amount"] * 0.1 * 0.02;
        $idArray[0]["h_edu_cess"] = $idArray[0]["Invoice_Amount"] * 0.1  * 0.01;
        $idArray[0]["total_payable"] = $idArray[0]["Invoice_Amount"] + $idArray[0]["service_tax"] + $idArray[0]["edu_cess"] + $idArray[0]["h_edu_cess"];
        $display_URL = "invoice_print_india_1.htm";
        break;
    case "india_2":
        $change_time = strtotime("31 March 2012 22:00");
        $current_rate = (time() - $change_time > 0) ? 0.12 : 0.1 ;
        $idArray[0]["rate"] = (time() - $change_time > 0) ? "12%" : "10%" ;
        $idArray[0]["service_tax"] = round($idArray[0]["Invoice_Amount"] * $current_rate);
        $idArray[0]["edu_cess"] = round($idArray[0]["Invoice_Amount"] * $current_rate * 0.02);
        $idArray[0]["h_edu_cess"] = round($idArray[0]["Invoice_Amount"] * $current_rate  * 0.01);
        $idArray[0]["total_payable"] = $idArray[0]["Invoice_Amount"] + $idArray[0]["service_tax"] + $idArray[0]["edu_cess"] + $idArray[0]["h_edu_cess"];
        $display_URL = "invoice_print_india_2.htm";
        break;
    case "india_3":
        $idArray[0]["service_tax"] = $idArray[0]["Invoice_Amount"] * 0.1;
        $idArray[0]["edu_cess"] = $idArray[0]["Invoice_Amount"] * 0.1 * 0.02;
        $idArray[0]["h_edu_cess"] = $idArray[0]["Invoice_Amount"] * 0.1  * 0.01;
        $idArray[0]["total_payable"] = $idArray[0]["Invoice_Amount"] + $idArray[0]["service_tax"] + $idArray[0]["edu_cess"] + $idArray[0]["h_edu_cess"];
        $display_URL = "invoice_print_india_3.htm";
        break;
    case "india_4":
        $idArray[0]["service_tax"] = $idArray[0]["Invoice_Amount"] * 0.1;
        $idArray[0]["edu_cess"] = $idArray[0]["Invoice_Amount"] * 0.1 * 0.02;
        $idArray[0]["h_edu_cess"] = $idArray[0]["Invoice_Amount"] * 0.1  * 0.01;
        $idArray[0]["total_payable"] = $idArray[0]["Invoice_Amount"] + $idArray[0]["service_tax"] + $idArray[0]["edu_cess"] + $idArray[0]["h_edu_cess"];
        $display_URL = "invoice_print_india_4.htm";
        break;
    case "korea":
        $idArray[0]["VAT"] = addComma($idArray[0]["Invoice_Amount"] * 0.1);
        $idArray[0]["VAT_total"] = addComma($idArray[0]["Invoice_Amount"] * 1.1);
        $display_URL = "invoice_print_korea.htm";
        break;
	case "korea_y":
        $idArray[0]["VAT"] = addComma($idArray[0]["Invoice_Amount"] * 0.1);
        $idArray[0]["VAT_total"] = addComma($idArray[0]["Invoice_Amount"] * 1.1);
        $display_URL = "invoice_print_korea_y.htm";
        break;
	case "korea_a":
        $idArray[0]["VAT"] = addComma($idArray[0]["Invoice_Amount"] * 0.1);
        $idArray[0]["VAT_total"] = addComma($idArray[0]["Invoice_Amount"] * 1.1);
        $display_URL = "invoice_print_korea_a.htm";
        break;
    case "hk_hk":
        if($idArray[0]["doc_type"] == "2"){
            $idArray[0]["Invoice_header"] = "CREDIT NOTE";
        }
        else{
            $idArray[0]["Invoice_header"] = "INVOICE";
        }
        $td = explode("-",$idArray[0]["Invoice_date"]);
        $idArray[0]["Invoice_date"] = date("d F Y", mktime(0, 0, 0, $td[1], $td[2], $td[0]));
        $idArray[0]["Fee_sharing_p1"] = str_replace(".", " ", $idArray[0]["Fee_sharing_p1"]);
        $display_URL = "invoice_print_hk_HK.htm";
        break;
    case "hk_vas":
        if($idArray[0]["doc_type"] == "2"){
            $idArray[0]["Invoice_header"] = "CREDIT NOTE";
        }
        else{
            $idArray[0]["Invoice_header"] = "INVOICE";
        }
        $td = explode("-",$idArray[0]["Invoice_date"]);
        $idArray[0]["Invoice_date"] = date("d F Y", mktime(0, 0, 0, $td[1], $td[2], $td[0]));
        $idArray[0]["Fee_sharing_p1"] = str_replace(".", " ", $idArray[0]["Fee_sharing_p1"]);
        $display_URL = "invoice_print_hk_VAS.htm";
        break;
    case "cn_bj":
        $td = explode("-",$idArray[0]["Invoice_date"]);
        $idArray[0]["Invoice_date"] = date("d F Y", mktime(0, 0, 0, $td[1], $td[2], $td[0]));
        $idArray[0]["Fee_sharing_p1"] = str_replace(".", " ", $idArray[0]["Fee_sharing_p1"]);
        $display_URL = "invoice_print_cn_bj.htm";
        break;
    case "cn_sh":
        $td = explode("-",$idArray[0]["Invoice_date"]);
        $idArray[0]["Invoice_date"] = date("d F Y", mktime(0, 0, 0, $td[1], $td[2], $td[0]));
        $idArray[0]["Fee_sharing_p1"] = str_replace(".", " ", $idArray[0]["Fee_sharing_p1"]);
        $display_URL = "invoice_print_cn_sh.htm";
        break;
    case "jp_kk":
        $td = explode("-",$idArray[0]["Invoice_date"]);
        $idArray[0]["consumption_tax"] = floor($idArray[0]["Invoice_Amount"] * 0.05);
        $idArray[0]["Grand_Total"] = floor($idArray[0]["Invoice_Amount"] * 1.05);
         
        $idArray[0]["Invoice_date"] = date("F j, Y", mktime(0, 0, 0, $td[1], $td[2], $td[0]));
        $idArray[0]["Fee_sharing_p1"] = str_replace(".", " ", $idArray[0]["Fee_sharing_p1"]);
        $display_URL = "invoice_print_jp_kk.htm";
        break;
    case "jp_ia":
        $td = explode("-",$idArray[0]["Invoice_date"]);
        $idArray[0]["consumption_tax"] = floor($idArray[0]["Invoice_Amount"] * 0.05);
        $idArray[0]["Grand_Total"] = floor($idArray[0]["Invoice_Amount"] * 1.05);
        
        $idArray[0]["Invoice_date"] = date("F j, Y", mktime(0, 0, 0, $td[1], $td[2], $td[0]));
        $idArray[0]["Fee_sharing_p1"] = str_replace(".", " ", $idArray[0]["Fee_sharing_p1"]);
        $display_URL = "invoice_print_jp_ia.htm";
        break;
    case "jp_as":
        $td = explode("-",$idArray[0]["Invoice_date"]);
        $idArray[0]["consumption_tax"] = floor($idArray[0]["Invoice_Amount"] * 0.05);
        $idArray[0]["Grand_Total"] = floor($idArray[0]["Invoice_Amount"] * 1.05);
        
        $idArray[0]["Invoice_date"] = date("F j, Y", mktime(0, 0, 0, $td[1], $td[2], $td[0]));
        $idArray[0]["Fee_sharing_p1"] = str_replace(".", " ", $idArray[0]["Fee_sharing_p1"]);
        $display_URL = "invoice_print_jp_as.htm";
        break;
    case "indonesia":
        $idArray[0]["Invoice_date"] = date("d F Y", mktime(0, 0, 0, $td[1], $td[2], $td[0]));
        $idArray[0]["Fee_sharing_p1"] = str_replace(".", " ", $idArray[0]["Fee_sharing_p1"]);
        $idArray[0]["VAT"] = $idArray[0]["Invoice_Amount"] * 0.1;
        $idArray[0]["VAT_total"] = $idArray[0]["Invoice_Amount"] * 1.1;
        $display_URL = "invoice_print_indonesia.htm";
        break;
    case "vietnam":
        $idArray[0]["Invoice_date"] = date("d F Y", mktime(0, 0, 0, $td[1], $td[2], $td[0]));
        $idArray[0]["Fee_sharing_p1"] = str_replace(".", " ", $idArray[0]["Fee_sharing_p1"]);
        $idArray[0]["VAT"] = $idArray[0]["Invoice_Amount"] * 0.1;
        $idArray[0]["VAT_total"] = $idArray[0]["Invoice_Amount"] * 1.1;
        $display_URL = "invoice_print_vietnam.htm";
        break;    

	case "s_creditnote":
        $idArray[0]["VAT"] = addComma($idArray[0]["Invoice_Amount"] * 0.1);
	    $gst_percent       = $idArray[0]["gst"] * 0.01;
        $idArray[0]["GST_VAL"] = addComma(sprintf("%.2f", $idArray[0]["Invoice_Amount"] * $gst_percent ));
		$idArray[0]["TOTAL"] = addComma($idArray[0]["Invoice_Amount"]  +  $idArray[0]["GST_VAL"]);
        $display_URL = "invoice_print_singa_credit.htm";
		break;    
	
	case "s_tax":
        $idArray[0]["VAT"] = addComma($idArray[0]["Invoice_Amount"] * 0.1);
	    $gst_percent       = $idArray[0]["gst"] * 0.01;
        $idArray[0]["GST_VAL"] = addComma(sprintf("%.2f", $idArray[0]["Invoice_Amount"] * $gst_percent));
		$idArray[0]["TOTAL"] = addComma($idArray[0]["Invoice_Amount"]  +  $idArray[0]["GST_VAL"]);
		$idArray[0]["Saddress"] = explode(',', $idArray[0]["Address"]);
		$Scomplete_date = explode('-', $idArray[0]["complete_date"]);
		$idArray[0]["Scomplete_date"] = $Scomplete_date[2].'-'.$Scomplete_date[1].'-'.$Scomplete_date[0];
		$idArray[0]["STransaction_No"] = str_replace('I', 'N', $idArray[0]["Transaction_No"]);
		$sales = explode('.', $idArray[0]["Fee_sharing_p1"]);
		$idArray[0]["SFee_sharing_p1"] = ucfirst($sales[0]).'. '.ucfirst($sales[1]);
		 
		$display_URL = "invoice_print_singa_tax.htm";
		break;  
	
	case "sv_creditnote":
        $idArray[0]["VAT"] = addComma($idArray[0]["Invoice_Amount"] * 0.1);
	    $gst_percent       = $idArray[0]["gst"] * 0.01;
        $idArray[0]["GST_VAL"] = addComma(sprintf("%.2f", $idArray[0]["Invoice_Amount"] * $gst_percent ));
		$idArray[0]["TOTAL"] = addComma($idArray[0]["Invoice_Amount"]  +  $idArray[0]["GST_VAL"]);
        $display_URL = "invoice_print_singav_credit.htm";
		break;    
	
	case "sv_tax":
        $idArray[0]["VAT"] = addComma($idArray[0]["Invoice_Amount"] * 0.1);
	    $gst_percent       = $idArray[0]["gst"] * 0.01;
        $idArray[0]["GST_VAL"] = addComma(sprintf("%.2f", $idArray[0]["Invoice_Amount"] * $gst_percent));
		$idArray[0]["TOTAL"] = addComma($idArray[0]["Invoice_Amount"]  +  $idArray[0]["GST_VAL"]);
        $display_URL = "invoice_print_singav_tax.htm";
		break; 
   
    case "s_debit":
        $idArray[0]["VAT"] = addComma($idArray[0]["Invoice_Amount"] * 0.1);
        $gst_percent       = $idArray[0]["gst"] * 0.01;
        $idArray[0]["GST_VAL"] = addComma(sprintf("%.2f", $idArray[0]["Invoice_Amount"] * $gst_percent));
		$idArray[0]["TOTAL"] = addComma($idArray[0]["Invoice_Amount"]  +  $idArray[0]["GST_VAL"]);
        $display_URL = "invoice_print_singa_debit.htm";
		break; 

    default:
        $display_URL = "print_preview_invr.htm";
        break;        
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
    $invoiceTpl->assign("sArray", $_SESSION);
    $invoiceTpl->assign("doc_type", $doc_types);
    $invoiceTpl->assign("idArray", $idArray[0]);
    $invoiceTpl->display($display_URL);

}
else{
		echo "<script language='javascript'>
			window.alert('Sorry, this invoice details information is protected ');
			window.close();
		</script>";
}
//print_r($db);
?>