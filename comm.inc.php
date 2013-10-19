<?php
/*
 * @Copyright (c) 2007, www.cushwake.com
 * @All rights reserved.
 *
 * @File name：comm.inc.php
 * 
 * @summery：comm vars
 *
 * @author：leon.zhao@ap.cushwake.com
 * @date：03.28.2008 10:22 AM
 *
 */

//Global vars in invoice system

$doc_types  = array("1"=>"IN","2"=>"CN","3"=>"ADJ");                                                     //document types selection
$doc_number = array("1"=>"Invoice No","2"=>"Credit Note No","3"=>"Adjustment No");                       //document number types
$power_type = array("0"=>"Administrator","2"=>"AP Group","3"=>"Global Department","4"=>"Country","5"=>"City","6"=>"National Department right","8"=>"Departmental right","10"=>"User");
$AP_VPN  = array(
                    "10.0.1."    => "NY",
                    "10.200.1."  => "GC-Shanghai",
                    "10.200.2."  => "GC-Beijing",
                    "10.200.3."  => "GC-HK",
                    "10.200.55." => "Japan",
                    "10.200.50." => "GC-Seoul",
                    "10.200.40." => "GC-Singapore",
                    "10.200.60." => "Sydney",
                    "10.200.20." => "IND-Gurgaon",
                    "10.200.21." => "IND-Mumbai",
                    "10.200.22." => "IND-Bangelore",
                    "10.200.23." => "IND-Chennai",
                    "10.200.24." => "IND-Pune",
                    "10.200.25." => "IND-Hyderabad",
                    "10.200.26." => "IND-Goregaon",
                    "10.200.28." => "IND-NewDelhi",
                    "10.200.99." => "GC-HKDC",
                    "10.200.90." => "GC-CWCA"
                );
$clientSurveySent_type = array("0" => "None","1" => "Online","2"=>"Telephone","3"=>"In person");


?>