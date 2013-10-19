<?php
/*
 * @Copyright (c) 2007, www.cushwake.com
 * @All rights reserved.
 *
 * @File name：add_invoice.php
 * 
 * @summery：add form
 *
 * @author：leon.zhao@ap.cushwake.com
 * @date：10.22.2007 10:22 AM
 *
 */
require_once(dirname(__FILE__) . "/invoice.config.php");
require_once(dirname(__FILE__) . "/adodb.class.php");
require_once(dirname(__FILE__) . "/check_sess.php");
//require_once(dirname(__FILE__) . "/banner.php");

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
//exit();
$db = new dbClass($db_ado);
$countryArray = $db->getSpecificInfoById(COUNTRY,$_POST["selCountry"]);
unset($_POST["selCountry"]);

$upArray["Invoice_to_address2"] = $_POST["Invoice_to_address2"];
$upArray["Invoice_to_city"] = $_POST["Invoice_to_city"];
$upArray["Invoice_to_province"] = $_POST["Invoice_to_province"];
$upArray["Invoice_to_country"] = $_POST["Invoice_to_country"];
$upArray["Invoice_to_zipcode"] = $_POST["Invoice_to_zipcode"];

$upArray["Invoice_No"] = $_POST["Invoice_No"];
$upArray["Transaction_No"] = $_POST["Transaction_No"]; 
$upArray["Country"] = $_POST["selsqft"];
$upArray["curr_code"] = $_POST["curr_code"];
$upArray["doc_type"] = $_POST["doc_type"];
$upArray["doc_type_num"] = $_POST["doc_type_num"];
$upArray["Exchange_rate"] = $_POST["todayCurrency"];
$upArray["Client_Solutins_Major"] = $_POST["Client_Solutins_Major"];
$upArray["City"] = $_POST["City"];
$upArray["Dept_info"] = $_POST["Dept_info"];
$upArray["Dept2_info"] = $_POST["Dept2_info"];
$upArray["Client"] = $_POST["Client"];
$upArray["Client_name"] = $_POST["Client_name"]; 
$upArray["Client_title"] = $_POST["Client_title"]; 
$upArray["Client_phone"] = $_POST["Client_phone"];  
$upArray["Client_email"] = $_POST["Client_email"];   
$upArray["Other_Party"] = $_POST["Other_Party"];   
$upArray["Payer"] = $_POST["Payer"]; 
$upArray["Property_Project_Name"] = $_POST["Property_Project_Name"]; 
$upArray["contact"] = $_POST["contact"];  
$upArray["Trans_Type_1"] = $_POST["Trans_Type_1"];
$upArray["Trans_Type_2"] = $_POST["Trans_Type_2"];
$upArray["Ppty_Type"] = $_POST["Ppty_Type"];
$upArray["Client_Type"] = $_POST["Client_Type"];
$upArray["Sq_Ft"] = str_replace(",","",$_POST["default_sqft_us"]);
$upArray["sqft_local_name"] = $_POST["sqft_local_name"];
$upArray["1_Mths_rent"] = str_replace(",","",$_POST["oneMonthRent"]);
$upArray["Lease_Term"] = $_POST["termOfLease"];
$upArray["Transaction_Value"] = str_replace(",","",$_POST["VofTRX"]);
$upArray["Transaction_Value_US"] = str_replace(",","",$_POST["VofTRX_US_hidden"]);
$upArray["complete_date"] = $_POST["date6"];
$upArray["Payment_date1"] = $_POST["date1"];
$upArray["Payment_date1_estimate"] = $_POST["date2"];
$upArray["Payment_date1_amount1"] = $_POST["amount1"];
$upArray["Payment_date1_amount1_percent"] = $_POST["amount_percent"];
$upArray["date_paid1"] = $_POST["date7"]; 
$upArray["Payment_date2"] = $_POST["date3"];
$upArray["Payment_date2_estimate"] = $_POST["date4"];
$upArray["Payment_date2_amount"] = $_POST["Payment_date2_amount"];
$upArray["Payment_date2_amount2_percent"] = $_POST["Payment_date2_amount2_percent"];
$upArray["date_paid2"] = $_POST["date8"];
$upArray["payment_remarks"] = $_POST["payment_remarks"];

$upArray["Invoice_date"] = $_POST["date5"];
$upArray["Invoice_to"] = $_POST["invoice_to"];
$upArray["Address"] = $_POST["Address"];
$upArray["invoice_to_trading_name"] = $_POST["invoice_to_trading_name"];
$upArray["Contact_person"] = $_POST["Contact_Person"]; 
$upArray["Contact_info"] = $_POST["Contact_info"]; 
$upArray["Fee_basis"] = $_POST["Fee_basis"]; 
$upArray["Reimbursed"] = $_POST["reimbursed"]; 
$upArray["Special_instructions"] = $_POST["Special_instructions"]; 
$upArray["Invoice_Amount"] = str_replace(",","",$_POST["InvAmount"]);
$upArray["Invoice_Amount_US"] = str_replace(",","",$_POST["InvAmountUsHidden"]);
$upArray["3rd_Pty"] = str_replace(",","",$_POST["3rd_Pty"]);
$upArray["3rd_Pty_Fee"] = $_POST["thirdAmount"];
$upArray["CWWOffice"] = $_POST["CWWOffice"];
$upArray["CWW_party_salesPerson"] = $_POST["CWW_party_salesPerson"];
$upArray["CWW_refPercent"] = $_POST["CWW_refPercent"]; 
$upArray["CWW_Referral_Fee"] = str_replace(",","",$_POST["CWW_Referral_Fee"]);

$upArray["3rd_Pty2"] = $_POST["3rd_Pty2"];
$upArray["3rd_Pty_Fee2"] = str_replace(",","",$_POST["thirdAmount2"]);
$upArray["CWWOffice2"] = $_POST["CWWOffice2"];
$upArray["CWW_party_salesPerson2"] = $_POST["CWW_party_salesPerson2"];
$upArray["CWW_refPercent2"] = $_POST["CWW_refPercent2"]; 
$upArray["CWW_Referral_Fee2"] = str_replace(",","",$_POST["CWW_Referral_Fee2"]);
$upArray["CWWOffice3"] = $_POST["CWWOffice3"];
$upArray["CWW_party_salesPerson3"] = $_POST["CWW_party_salesPerson3"];
$upArray["CWW_refPercent3"] = $_POST["CWW_refPercent3"]; 
$upArray["CWW_Referral_Fee3"] = str_replace(",","",$_POST["CWW_Referral_Fee3"]);



 
$upArray["CSOffice"] = $_POST["CSOffice"]; 
$upArray["CSsalesPerson"] = $_POST["CSsalesPerson"]; 
$upArray["CSrefPercent"] = $_POST["CSrefPercent"]; 
$upArray["CSOfficeFee"] = str_replace(",","",$_POST["CSOfficeFee"]); 
$upArray["Net_Fee"] = str_replace(",","",$_POST["netFeeAmount"]);
$upArray["Net_Fee_US"] = str_replace(",","",$_POST["netFeeUsHiddlen"]);
$upArray["Fee_sharing_p1"] = $_POST["Fee_sharing_p1"];
$upArray["Fee_sharing_p1_percent"] = $_POST["Fee_sharing_p1_percent"];
$upArray["Fee_sharing_p1_fee"] = str_replace(",","",$_POST["Fee_sharing_p1_fee"]);
$upArray["Fee_sharing_p2"] = $_POST["Fee_sharing_p2"];
$upArray["Fee_sharing_p2_percent"] = $_POST["Fee_sharing_p2_percent"];
$upArray["Fee_sharing_p2_fee"] = str_replace(",","",$_POST["Fee_sharing_p2_fee"]);
$upArray["Fee_sharing_p3"] = $_POST["Fee_sharing_p3"];
$upArray["Fee_sharing_p3_percent"] = $_POST["Fee_sharing_p3_percent"];
$upArray["Fee_sharing_p3_fee"] = str_replace(",","",$_POST["Fee_sharing_p3_fee"]);
$upArray["Fee_sharing_p4"] = $_POST["Fee_sharing_p4"];
$upArray["Fee_sharing_p4_percent"] = $_POST["Fee_sharing_p4_percent"];
$upArray["Fee_sharing_p4_fee"] = str_replace(",","",$_POST["Fee_sharing_p4_fee"]);
$upArray["Fee_sharing_p5"] = $_POST["Fee_sharing_p5"];
$upArray["Fee_sharing_p5_percent"] = $_POST["Fee_sharing_p5_percent"];
$upArray["Fee_sharing_p5_fee"] = str_replace(",","",$_POST["Fee_sharing_p5_fee"]);
$upArray["Fee_sharing_p6"] = $_POST["Fee_sharing_p6"];
$upArray["Fee_sharing_p6_percent"] = $_POST["Fee_sharing_p6_percent"];
$upArray["Fee_sharing_p6_fee"] = str_replace(",","",$_POST["Fee_sharing_p6_fee"]);
$upArray["Fee_sharing_p7"] = $_POST["Fee_sharing_p7"];
$upArray["Fee_sharing_p7_percent"] = $_POST["Fee_sharing_p7_percent"];
$upArray["Fee_sharing_p7_fee"] = str_replace(",","",$_POST["Fee_sharing_p7_fee"]);
$upArray["Fee_sharing_p8"] = $_POST["Fee_sharing_p8"];
$upArray["Fee_sharing_p8_percent"] = $_POST["Fee_sharing_p8_percent"];
$upArray["Fee_sharing_p8_fee"] = str_replace(",","",$_POST["Fee_sharing_p8_fee"]);
$upArray["Fee_sharing_p9"] = $_POST["Fee_sharing_p9"];
$upArray["Fee_sharing_p9_percent"] = $_POST["Fee_sharing_p9_percent"];
$upArray["Fee_sharing_p9_fee"] = str_replace(",","",$_POST["Fee_sharing_p9_fee"]);
$upArray["Fee_sharing_p10"] = $_POST["Fee_sharing_p10"];
$upArray["Fee_sharing_p10_percent"] = $_POST["Fee_sharing_p10_percent"];
$upArray["Fee_sharing_p10_fee"] = str_replace(",","",$_POST["Fee_sharing_p10_fee"]);
$upArray["clientSurveySent"] = $_POST["clientSurveySent"];
$upArray["referenceLetter"] = $_POST["referenceLetter"];
$upArray["MajorCaseStudy"] = $_POST["MajorCaseStudy"];
$upArray["MinorCaseStudy"] = $_POST["MinorCaseStudy"];
$upArray["Online"] = $_POST["Online"]; 
$upArray["Telephone"] = $_POST["Telephone"]; 
$upArray["Inperson"] = $_POST["Inperson"]; 

$upArray["Create_by"] = $_SESSION["user_name"];
$upArray["Create_date"] = date("Y-m-d",time());
$upArray["sqft_local"] = str_replace(",","",$_POST["sqft_local"]);
$upArray["trans_state"] = "1"; 
$upArray["inter_invoice"] = isset($_POST["inter_invoice"])?$_POST["inter_invoice"]:0; 

$upArray["confidential_agreement"] = $_POST["confidential_agreement"];
$upArray["cost_of_sales"] = str_replace(",","",$_POST["cost_of_sales"]);
$upArray["client_reference_no"] = $_POST["client_reference_no"];
$upArray["key_client"] = $_POST["key_client"];
if($countryArray = $db->insert(INVLIST,$upArray)){
	echo "<script language='javascript'>
			window.alert('New invoice added, back to invoice list');
			window.opener.location.href=window.opener.location.href;
			window.close();
		</script>";
}
else {
		echo "<script language='javascript'>
			window.alert('Sorry,error creating new invoice,please fill all necessary info');
			window.history.back();
		</script>";
}

?>