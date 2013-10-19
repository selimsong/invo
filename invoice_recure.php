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

$db = new dbClass($db_ado);
if(isset($_GET["ID"]))
{
    $ID = $_GET["ID"];
}else{exit("Error Accessing 1");}
$db = new dbClass($db_ado); 

$sql = "INSERT INTO `ap_07` (`trans_state`,`Exchange_rate`,`City`,`Country`,`curr_code`,`Invoice_date`,`Payment_date1`,`Payment_date2`,`doc_type`,`doc_type_num`,`Transaction_No`,`Invoice_No`,`Other_Party`,`Dept_info`,`Dept2_info`,`Client_Solutins_Major`,`Client`,`Payer`,`Property_Project_Name`,`Invoice_Amount`,`3rd_Pty`,`3rd_Pty_Fee`,`CWW_Referral_Fee`,`Net_Fee`,`Fee_sharing_p1`,`Fee_sharing_p1_fee`,`Fee_sharing_p1_percent`,`Fee_sharing_p2`,`Fee_sharing_p2_fee`,`Fee_sharing_p2_percent`,`Fee_sharing_p3`,`Fee_sharing_p3_fee`,`Fee_sharing_p3_percent`,`Fee_sharing_p4`,`Fee_sharing_p4_fee`,`Fee_sharing_p4_percent`,`Fee_sharing_p5`,`Fee_sharing_p5_fee`,`Fee_sharing_p5_percent`,`Fee_sharing_p6`,`Fee_sharing_p6_fee`,`Fee_sharing_p6_percent`,`Fee_sharing_p7`,`Fee_sharing_p7_fee`,`Fee_sharing_p7_percent`,`Fee_sharing_p8`,`Fee_sharing_p8_fee`,`Fee_sharing_p8_percent`,`Fee_sharing_p9`,`Fee_sharing_p9_fee`,`Fee_sharing_p9_percent`,`Fee_sharing_p10`,`Fee_sharing_p10_fee`,`Fee_sharing_p10_percent`,`Trans_Type_1`,`Trans_Type_2`,`Ppty_Type`,`Sq_Ft`,`Lease_Term`,`1_Mths_rent`,`Transaction_Value`,`Invoice_Amount_US`,`Net_Fee_US`,`Transaction_Value_US`,`Department_head`,`Preparers`,`Approved_by_dept`,`Approved_by_Dir`,`Create_by`,`Create_date`,`Modified_by`,`Modified_date`,`Fee_basis`,`Reimbursed`,`Invoice_to`,`Address`,`Special_instructions`,`Contact_person`,`Client_name`,`Client_title`,`Client_phone`,`Client_email`,`contact`,`Client_Type`,`complete_date`,`Payment_date1_estimate`,`Payment_date1_amount1`,`Payment_date1_amount1_percent`,`Payment_date2_estimate`,`Payment_date2_amount`,`Payment_date2_amount2_percent`,`Contact_info`,`cost_of_sales`,`CWWOffice`,`CWW_party_salesPerson`,`CWW_refPercent`,`CSOffice`,`CSsalesPerson`,`CSrefPercent`,`CSOfficeFee`,`clientSurveySent`,`referenceLetter`,`MajorCaseStudy`,`MinorCaseStudy`,`Online`,`Telephone`,`Inperson`,`sqft_local`,`sqft_local_name`,`inter_invoice`,`payment_remarks`,`invoice_to_trading_name`,`confidential_agreement`,`3rd_Pty2`,`3rd_Pty_Fee2`,`CWWOffice2`,`CWW_party_salesPerson2`,`CWW_refPercent2`,`CWW_Referral_Fee2`,`CWWOffice3`,`CWW_party_salesPerson3`,`CWW_refPercent3`,`CWW_Referral_Fee3`,`Invoice_to_address2`,`Invoice_to_city`,`Invoice_to_province`,`Invoice_to_country`,`Invoice_to_zipcode`,`approved_by`,`approved_date`,`date_paid1`,`date_paid2`,`client_reference_no`)
 select 1,`Exchange_rate`,`City`,`Country`,`curr_code`,'" . date("Y-m-d") . "',`Payment_date1`,`Payment_date2`,`doc_type`,`doc_type_num`,`Transaction_No`,`Invoice_No`,`Other_Party`,`Dept_info`,`Dept2_info`,`Client_Solutins_Major`,`Client`,`Payer`,`Property_Project_Name`,`Invoice_Amount`,`3rd_Pty`,`3rd_Pty_Fee`,`CWW_Referral_Fee`,`Net_Fee`,`Fee_sharing_p1`,`Fee_sharing_p1_fee`,`Fee_sharing_p1_percent`,`Fee_sharing_p2`,`Fee_sharing_p2_fee`,`Fee_sharing_p2_percent`,`Fee_sharing_p3`,`Fee_sharing_p3_fee`,`Fee_sharing_p3_percent`,`Fee_sharing_p4`,`Fee_sharing_p4_fee`,`Fee_sharing_p4_percent`,`Fee_sharing_p5`,`Fee_sharing_p5_fee`,`Fee_sharing_p5_percent`,`Fee_sharing_p6`,`Fee_sharing_p6_fee`,`Fee_sharing_p6_percent`,`Fee_sharing_p7`,`Fee_sharing_p7_fee`,`Fee_sharing_p7_percent`,`Fee_sharing_p8`,`Fee_sharing_p8_fee`,`Fee_sharing_p8_percent`,`Fee_sharing_p9`,`Fee_sharing_p9_fee`,`Fee_sharing_p9_percent`,`Fee_sharing_p10`,`Fee_sharing_p10_fee`,`Fee_sharing_p10_percent`,`Trans_Type_1`,`Trans_Type_2`,`Ppty_Type`,`Sq_Ft`,`Lease_Term`,`1_Mths_rent`,`Transaction_Value`,`Invoice_Amount_US`,`Net_Fee_US`,`Transaction_Value_US`,`Department_head`,`Preparers`,`Approved_by_dept`,`Approved_by_Dir`,`Create_by`,`Create_date`,`Modified_by`,`Modified_date`,`Fee_basis`,`Reimbursed`,`Invoice_to`,`Address`,`Special_instructions`,`Contact_person`,`Client_name`,`Client_title`,`Client_phone`,`Client_email`,`contact`,`Client_Type`,`complete_date`,`Payment_date1_estimate`,`Payment_date1_amount1`,`Payment_date1_amount1_percent`,`Payment_date2_estimate`,`Payment_date2_amount`,`Payment_date2_amount2_percent`,`Contact_info`,`cost_of_sales`,`CWWOffice`,`CWW_party_salesPerson`,`CWW_refPercent`,`CSOffice`,`CSsalesPerson`,`CSrefPercent`,`CSOfficeFee`,`clientSurveySent`,`referenceLetter`,`MajorCaseStudy`,`MinorCaseStudy`,`Online`,`Telephone`,`Inperson`,`sqft_local`,`sqft_local_name`,`inter_invoice`,`payment_remarks`,`invoice_to_trading_name`,`confidential_agreement`,`3rd_Pty2`,`3rd_Pty_Fee2`,`CWWOffice2`,`CWW_party_salesPerson2`,`CWW_refPercent2`,`CWW_Referral_Fee2`,`CWWOffice3`,`CWW_party_salesPerson3`,`CWW_refPercent3`,`CWW_Referral_Fee3`,`Invoice_to_address2`,`Invoice_to_city`,`Invoice_to_province`,`Invoice_to_country`,`Invoice_to_zipcode`,`approved_by`,`approved_date`,`date_paid1`,`date_paid2`,`client_reference_no`
 from ap_07 where ID=" . $ID;

 
if(mysql_query($sql)){
    echo "<script language='javascript'>
            window.location='" . $_SESSION["search_url"] . "';
        </script>";
}
else {
        echo "<script language='javascript'>
            window.alert('Sorry,error recuring');
            window.history.back();
        </script>";
}


?>