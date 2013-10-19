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
error_reporting(0);

class ldap_invoice{
    var $server_address;
    var $ldapconn;
    var $ldapbind;
    var $dn;
    var $filter;
    var $justthese;
    var $info_array;
    function ldap_invoice(){
        //$this->server_address = "10.200.1.33";
		$this->server_address = "10.200.3.23";
        $this->dn = "OU=Asia Pacific,DC=ap,DC=cushwake,DC=gbl";
        
        $this->justthese = array();
        $this->ldapconn = ldap_connect($this->server_address);
        
    }
    function get_ldap_array($filter,$name=false,$pass=false){ 
        // $filter must be valid filters such as "(mail=leon.zhao@ap.cushwake.com)"
        // "connection authoritied name such as leon.zhao@ap.cushwake.com"
        // "connection password" usually the users email password.
        // usage: eg. get_ldap_array("(mail=leon.zhao@ap.cushwake.com)","leon.zhao@ap.cushwake.com","password");
        // return false if connection error or array if success.
        $this->filter = "(|" . $filter . ")";
        if(!ldap_bind($this->ldapconn,$name,$pass)){
            return false;
        }else{
            $sr=ldap_search($this->ldapconn, $this->dn, $this->filter, $this->justthese,0);
            $this->info_array = ldap_get_entries($this->ldapconn, $sr);
            //print_r($this->info_array);
            if(!$this->info_array){
                return false;
            }
            else {
                return $this->info_array;
            }
        }
        ldap_close($this->ldapconn);   
    }
    function format_info_array(){
        for($i=0;$i<$this->info_array["count"];$i++){
            echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"0\" style=\"border-collapse:collapse\">";
            for($j=0;$j<$this->info_array[$i]["count"];$j++){
                echo "<tr><td>";
                echo $this->info_array[$i][$j] . "</td><td>" . $this->info_array[$i][$this->info_array[$i][$j]][0] . "</td>";
                echo "</tr>";
            }
            echo "</table>"; 
            echo "<hr />";
    
        }
        echo "<pre>";
        print_r($this->info_array);
        echo "<pre>";
    }
    function format_country(){
        global $db_ado;
        $db = new dbClass($db_ado);
        $country_array = $db->SelectSql("SELECT * FROM " . COUNTRY . " ORDER BY Country");
        foreach($country_array as $key=>$perRow){
            $c_array[] = $perRow["Country"];
        }
        foreach($c_array as $key=>$value){
            if(stristr(($this->info_array[0]["co"][0]),$value))
            $this->info_array[0]["co"][0] = $value;
        }
    }
}


ldap_set_option($ldapconn, LDAP_OPT_SIZELIMIT, 2000);

//$ldap_obj = new ldap_invoice();
//$rs = $ldap_obj->get_ldap_array("(mail=gary.yeung@ap.cushwake.com)","gary.yeung@ap.cushwake.com","");
//if($rs)print_r($rs);else{echo "unauthorized error!";}
//$ldap_obj->format_country();
//$ldap_obj->format_info_array();




?>