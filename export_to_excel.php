<?php
/*
 * @Copyright (c) 2007, www.cushwake.com
 * @All rights reserved.
 *
 * @File name：search_start.php
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
//require_once(dirname(__FILE__) . "/check_sess.php");
//require_once(dirname(__FILE__) . "/banner.php");
require_once(__LIBPATH . "class/func.php");

session_start();
if($_SESSION["user_type"] != "Account" && $_SESSION["user_type"] != "Administrator"){
    echo "<script>window.alert('Sorry, this is protected!');window.close();</script>";
    exit();
}
//print_r($_GET);
//page initial

$db = new dbClass($db_ado);

if($_GET["orderBy"] == ""){
    $orderBy = "ID DESC";
    $date1 = date("Y-01-01",time());
    $date2 = date("Y-m-d",time());
    $sql =  "SELECT * FROM " . INVLIST . " as l left join " . DEPT2 . " as r on l.Dept2_info = r.Dept2_id WHERE `Invoice_date` BETWEEN '" . $date1 . "' AND '" . $date2 . "'";
    //print_r($db);
    /*$s = mysql_query($sql);
    while($t = mysql_fetch_array($s)){
        $rowArray[] = $t;
    }*/
    $rowArray = $db->SelectSql($sql);
    //print_r($rowArray);
}
else{


    $countryArray = $db->SelectSql("SELECT * FROM " . COUNTRY . " ORDER BY Country");
    $deptArray = $db->getAllInfo(DEPT);
    $majorAcountGroupArray = $db->SelectSql("SELECT * FROM " . MAG . " GROUP BY Client_Solutins_Major");
    
    $rowArray = $db->SelectSql("SELECT * FROM " . INVLIST . " as l left join " . DEPT2 . " as r on l.Dept2_info = r.Dept2_id " . $_SESSION["sqlWhere"]);
}





//$rowArray = patternNumToString($rowArray); 

//print_r($rowArray);
//exit(); 
//export to excel
//header("Content-Type: application/vnd.ms-execl");
//header("Content-Disposition: attachment; filename=list.xls");
//header("Pragma: no-cache");
//header("Expires: 0");



/*first line*/
$excel_head = "Cushman & Wakefield of Asia Limited\n";
$excel_head .= "Date:\tFrom $_GET[date1] to $_GET[date2]\n";

$excel_title .= "Country\t";
$excel_title .= "City\t";
$excel_title .= "Curr Code\t";
$excel_title .= "Exchange Rate\t";
$excel_title .= "Date\t";
$excel_title .= "Transaction No.\t";
$excel_title .= "Invoice/Cr. Note No.\t";
$excel_title .= "Dept\t"; 
$excel_title .= "Client Solutions Major A/C\t";
$excel_title .= "Client\t";
$excel_title .= "Payer\t";
$excel_title .= "Property/Project Name\t";

$excel_title .= "Invoice Amount\t";
$excel_title .= "Cost of Sales\t";
$excel_title .= "3rd Pty Fee\t";
$excel_title .= "CWW Referral Fee\t";
$excel_title .= "CS A/C Mgt Fee\t";
$excel_title .= "Net Fee\t";

$excel_title .= "CWW Referring Office\t";
$excel_title .= "Referral %\t";
$excel_title .= "CS A/C Mgt Fee %\t";
$excel_title .= "Lead Rep\t";
$excel_title .= "Trans Type 1\t";
$excel_title .= "Trans Type 2\t";
$excel_title .= "Ppty Type\t";

$excel_title .= "Sale Price/Cons. Fee\t";
$excel_title .= "Sq. Ft.\t";
$excel_title .= "Lease Term\t";
$excel_title .= "1 Mths rent\t";
$excel_title .= "Transaction Value\t";
$excel_title .= "Invoice To\t";
$excel_title .= "At:(Specify nature of fee agreement)\t";

//new field
$excel_title .= "Fee_sharing_p1\t";
$excel_title .= "Fee_sharing_p1_fee\t";
$excel_title .= "Fee_sharing_p1_percent\t";
$excel_title .= "Fee_sharing_p2\t";
$excel_title .= "Fee_sharing_p2_fee\t";
$excel_title .= "Fee_sharing_p2_percent\t";
$excel_title .= "Fee_sharing_p3\t";
$excel_title .= "Fee_sharing_p3_fee\t";
$excel_title .= "Fee_sharing_p3_percent\t";
$excel_title .= "Fee_sharing_p4\t";
$excel_title .= "Fee_sharing_p4_fee\t";
$excel_title .= "Fee_sharing_p4_percent\t";
$excel_title .= "Fee_sharing_p5\t";
$excel_title .= "Fee_sharing_p5_fee\t";
$excel_title .= "Fee_sharing_p5_percent\t";
$excel_title .= "Fee_sharing_p6\t";
$excel_title .= "Fee_sharing_p6_fee\t";
$excel_title .= "Fee_sharing_p6_percent\t";
$excel_title .= "Fee_sharing_p7\t";
$excel_title .= "Fee_sharing_p7_fee\t";
$excel_title .= "Fee_sharing_p7_percent\t";
$excel_title .= "Fee_sharing_p8\t";
$excel_title .= "Fee_sharing_p8_fee\t";
$excel_title .= "Fee_sharing_p8_percent\t";
$excel_title .= "Fee_sharing_p9\t";
$excel_title .= "Fee_sharing_p9_fee\t";
$excel_title .= "Fee_sharing_p9_percent\t";
$excel_title .= "Fee_sharing_p10\t";
$excel_title .= "Fee_sharing_p10_fee\t";
$excel_title .= "Fee_sharing_p10_percent\t";
$excel_title .= "Contact_person\t";
$excel_title .= "Address\t";
$excel_title .= "Invoice_to_address2\t";
$excel_title .= "Invoice_to_city\t";
$excel_title .= "Invoice_to_province\t";
$excel_title .= "Invoice_to_country\t";
$excel_title .= "Invoice_to_zipcode\t";






$excel_title .= "\n";

//echo $excel_head;
//echo $excel_title;



//empty the temp directory
$dir    = dirname(__FILE__) . '/temp/';
$files1 = array_slice(scandir($dir),2);
if(is_array($files1)){
    foreach($files1 as $key=>$fname){
        $pieces = explode(".", $fname);
        if($pieces[1] == "xls"){
            unlink($dir . $fname);
        }
    }
}

//Create the excel file
$filename = dirname(__FILE__) . '/temp/' . md5(time()) . '.xls';
$somecontent = "Add this to the file\n";

if (!$handle = fopen($filename, 'a')) {
     echo "Cannot open file ($filename)";
     exit;
}
if (fwrite($handle, $excel_head) === FALSE) {
    echo "Cannot write to file ($filename)";
    exit;
}
if (fwrite($handle, $excel_title) === FALSE) {
    echo "Cannot write to file ($filename)";
    exit;
}


foreach($rowArray as $num=>$perRow){
    if(stristr($_SESSION["priority_country"],$perRow["Country"]) || ($_SESSION["power"] <= 2)){
        //remove the \n 
        foreach($perRow as $key=>$values){
            $perRow[$key] = str_replace("\n" , " ",$values);
            $perRow[$key] = str_replace("\r" , " ",$perRow[$key]);
        }
        
        $somecontent = "";
        $somecontent .= $perRow["Country"] . "\t";
        $somecontent .= $perRow["City"] . "\t";
        $somecontent .= $perRow["curr_code"] . "\t";
        $somecontent .= $perRow["Exchange_rate"] . "\t";
        $somecontent .= $perRow["Invoice_date"] . "\t";
        $somecontent .= $perRow["Transaction_No"] . "\t";
        $somecontent .= $perRow["doc_type_num"] . "\t";
        $somecontent .= $perRow["dept2_code"] . "\t";
        $somecontent .= $perRow["Client_Solutins_Major"] . "\t";
        $somecontent .= $perRow["Client"] . "\t";
        $somecontent .= $perRow["Payer"] . "\t";
        $somecontent .= $perRow["Property_Project_Name"] . "\t";

        $somecontent .= $perRow["Invoice_Amount"] . "\t";
        $somecontent .= $perRow["cost_of_sales"] . "\t";                 //
        $somecontent .= $perRow["3rd_Pty_Fee"] . "\t";
        $somecontent .= $perRow["CWW_Referral_Fee"] . "\t";
        $somecontent .= $perRow["CSOfficeFee"] . "\t";
        $somecontent .= $perRow["Net_Fee"] . "\t";

        $somecontent .= $perRow["CWWOffice"] . "\t";
        $somecontent .= $perRow["CWW_refPercent"] . "\t"; 
        $somecontent .= $perRow["CSrefPercent"] . "\t"; 
        $somecontent .= $perRow["Fee_sharing_p1"] . "\t";  
        $somecontent .= $perRow["Trans_Type_1"] . "\t";
        $somecontent .= $perRow["Trans_Type_2"] . "\t";
        $somecontent .= $perRow["Ppty_Type"] . "\t";

        $somecontent .= $perRow["Transaction_Value"] . "\t"; // Sale Price/Cons. Fee
        $somecontent .= $perRow["Sq_Ft"] . "\t";
        $somecontent .= $perRow["Lease_Term"] . "\t";
        $somecontent .= $perRow["1_Mths_rent"] . "\t";
        $somecontent .= $perRow["Transaction_Value"] . "\t";                
        $somecontent .= $perRow["Invoice_to"] . "\t";                
        $somecontent .= $perRow["contact"] . "\t";     
        //new field
        $somecontent .= $perRow["Fee_sharing_p1"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p1_fee"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p1_percent"] . "\t";    
        $somecontent .= $perRow["Fee_sharing_p2"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p2_fee"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p2_percent"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p3"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p3_fee"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p3_percent"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p4"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p4_fee"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p4_percent"] . "\t"; 
        $somecontent .= $perRow["Fee_sharing_p5"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p5_fee"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p5_percent"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p6"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p6_fee"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p6_percent"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p7"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p7_fee"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p7_percent"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p8"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p8_fee"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p8_percent"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p9"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p9_fee"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p9_percent"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p10"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p10_fee"] . "\t";
        $somecontent .= $perRow["Fee_sharing_p10_percent"] . "\t";
        $somecontent .= $perRow["Contact_person"] . "\t";
        $somecontent .= $perRow["Address"] . "\t";
        $somecontent .= $perRow["Invoice_to_address2"] . "\t";
        $somecontent .= $perRow["Invoice_to_city"] . "\t";
        $somecontent .= $perRow["Invoice_to_province"] . "\t";
        $somecontent .= $perRow["Invoice_to_country"] . "\t";
        $somecontent .= $perRow["Invoice_to_zipcode"] . "\t";
        
            
        $somecontent .= "\n";
        //echo $somecontent;
        if (fwrite($handle, $somecontent) === FALSE) {
            echo "Cannot write to file ($filename)";
            exit;
        }      
    }
    
    

}
// Write $somecontent to our opened file.

fclose($handle);
echo "<script>window.location='./temp/" . basename($filename) ."';</script>";

?>