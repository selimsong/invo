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
require_once(dirname(__FILE__) . "/comm.inc.php");
require_once(dirname(__FILE__) . "/adodb.class.php");
require_once(__LIBPATH . "class/func.php");
//page initial


?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Selection</title>
<link href="css/invocie_global.css" rel="stylesheet" type="text/css" />
<link href="css/drag_drop.css" rel="stylesheet" type="text/css" />
<link href="css/date_selector.css" rel="stylesheet" type="text/css" />
</head>
<style type="text/css">
body,div{font-size: 12px;} 
</style>
<script language="javascript">
function select_submit(){
	var selection;
	var loc = "";
	selection = document.selectForm.select_type.value;
	switch(selection){
		case "standard":
			loc = "print_preview_invr.php?ID=<?php echo $_GET["ID"];?>";
			break;
		case "india_1":
			loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=india_1";
			break;
        case "india_2":
            loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=india_2";
            break;
        case "india_3":
            loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=india_3";
            break;
		case "india_4":
			loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=india_4";
			break;
        case "korea":
            loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=korea";
            break;
		case "korea_y":
            loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=korea_y";
            break;
		case "korea_a":
            loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=korea_a";
            break;
        case "hk_hk":
            loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=hk_hk";
            break;
        case "hk_vas":
            loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=hk_vas";
            break;
        case "cn_bj":
            loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=cn_bj";
            break;
        case "cn_sh":
            loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=cn_sh";
            break;
        case "jp_kk":
            loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=jp_kk";
            break;
        case "jp_ia":
            loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=jp_ia";
            break;
        case "jp_as":
            loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=jp_as";
            break;
        case "indonesia":
            loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=indonesia";
            break;
        case "vietnam":
            loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=vietnam";
            break;
		case "s_creditnote":
            loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=s_creditnote";
            break;
		case "s_tax":
            loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=s_tax";
            break;
		case "sv_creditnote":
            loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=sv_creditnote";
            break;
		case "sv_tax":
            loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=sv_tax";
            break;
		case "s_debit":
            loc = "print_invr.php?ID=<?php echo $_GET["ID"];?>&type=s_debit";
            break;
		default:
			loc = "";
	}
	window.location=loc;
			
}
</script>
<body>

Please selection your print style:
<div style="margin-left:20px;">
<form action="login_ok.php" method="post" enctype="multipart/form-data" name="selectForm" target="_self">
<div style="margin-top:20px">Please select
  <select name="select_type">
  	<option value="standard">Invoice Fromat - standard</option>
    <option value="india_1">Invoice Format - India - Standard</option>
    <option value="india_2">Invoice Format - India - Tax</option>
    <option value="india_3">Invoice Format - PMSI - Standard</option>
    <option value="india_4">Invoice Format - PMSI - Tax</option>
    <option value="korea">Invoice Format - Korea</option>
	<option value="korea_y">Invoice Format - Korea - Yahoo</option>
	<option value="korea_a">Invoice Format - Korea - Apple</option>
    <option value="hk_hk">Invoice Format - HK - HK</option>
    <option value="hk_vas">Invoice Format - HK - VAS</option>
    <option value="cn_bj">Invoice Format - China - CWBJ</option>
    <option value="cn_sh">Invoice Format - China - CWSH</option>
    <option value="jp_kk">Invoice Format - Japan - CWKK</option>
    <option value="jp_ia">Invoice Format - Japan - CWIA</option>
    <option value="jp_as">Invoice Format - Japan - CWAM</option>
    <option value="indonesia">Invoice Format - Indonesia</option>
    <option value="vietnam">Invoice Format - Vietnam</option>
    <option value="s_tax">SG – CWS (Invoice)</option>
	<option value="s_creditnote">SG – CWS (Credit note)</option>
    <option value="sv_tax">SG – VHS (Invoice)</option>
	<option value="sv_creditnote">SG – VHS (Credit note)</option> 
  </select>
  <span style="margin-top:5px;">
  <input name="button" type="button" onClick="select_submit()" value="Preview">
  </span></div>
<div style="margin-top:5px;"></div>
<div><input type="hidden" name="ID" value=<?php echo $_GET["ID"];?> /></div>
</form>
</div>
</body>
</html>