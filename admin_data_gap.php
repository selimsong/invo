<?php
require_once(dirname(__FILE__) . "/invoice.config.php");
require_once(dirname(__FILE__) . "/adodb.class.php");
require_once(dirname(__FILE__) . "/check_sess.php");
require_once(dirname(__FILE__) . "/comm.inc.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/invocie_global.css" rel="stylesheet" type="text/css" />
<style>
body,div,table,td,tr,input {
    font-family:Verdana, Arial, Helvetica, sans-serif;
    font-size:10px;
}
table tr td{
    border-collapse: collapse;
    border-width: 1px;
    border-color: 0080FF;
}
</style>
<script>
function edit(id){
    window.open("modify_invoice.php?ID=" + id);
}
</script>
<body>
<div style="margin:2px;2px;0px;2px;">
<?php
$year = $_GET["year"];
$fields = array("Dept_info","Dept2_info","Trans_Type_1","Trans_Type_2","Ppty_Type");
$_SESSION["search_url"] = "admin_data_gap.php?year=$year";

foreach($fields as $k=>$v){
    $sql = "select * from ap_07 where Country='$_SESSION[priority_country]' AND (" . $fields[$k] . " = '' or " . $fields[$k] . " = 'unselected'  or " . $fields[$k] . " is NULL) AND Invoice_date like '$year%'";
    $re = mysql_query($sql);
    if(mysql_num_rows($re) > 0){
        echo "<div style='color:red;'>" . $fields[$k] . "</div>";
        echo "<div style=\"margin:5px;0px;0px;0px;\"><table border=1><tr><th>ID</th><th>Country</th><th>Doc Date</th><th>Client</th><th>option</th></tr>";
        while($s = mysql_fetch_array($re)){
            echo "<tr><td>$s[ID]</td><td>$s[Country]</td><td>$s[Invoice_date]</td><td>$s[Client]</td><td><input type=button value='Edit' onclick='edit($s[ID])'></td></tr>";
        }
        echo "</table></div>";
    }
}

$invoice_amount_sql = " select cast(invoice_amount*exchange_rate as decimal(18,2)) as temp,invoice_amount_us,invoice_amount,exchange_rate,invoice_date,curr_code,ID,country,client from ap_07 
                        where ((cast(invoice_amount_us as decimal(18,2))/cast(invoice_amount*exchange_rate as decimal(18,2))<0.98) or (cast(invoice_amount_us as decimal(18,2))/cast(invoice_amount*exchange_rate as decimal(18,2))>1.02)) 
                        and (invoice_date like '$year%') and country='$_SESSION[priority_country]'";
$r = mysql_query($invoice_amount_sql);

echo "A = C × D<br>B is the Invoice Amount in USD in the IRF system which should be equal to A<br>If B≠A, then which one should be reserved and which one to be removed";

echo "<div style=\"margin:5px;0px;0px;0px;\"><table border=1>";
echo "<tr>  <th>ID</th>
            <th>Invoice Amount (USD)<br>(Result by Ex * Invoice Amount)</th>
            <th>Invoice Amount (USD)<br>(in IRF system)</th>
            <th>Exchange Rate</th>
            <th>Invoice Amount</th>
            <th>Currency</th>
            <th>Invoice Date</th>
            <th>Client</th>
            <th>option</th>
      </tr>";
echo "<tr>  <th></th>
            <th>A</th>
            <th>B</th>
            <th>C</th>
            <th>D</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
      </tr>";
while($s=mysql_fetch_array($r)){
echo "<tr>  <td align=right>$s[ID]</td>
            <td align=right style='border:red 1px solid;'>$s[temp]</th>
            <td align=right style='border:blue 1px solid;'>$s[invoice_amount_us]</th>
            <td align=right style='border:blue 1px solid;'>$s[exchange_rate]</td>
            <td align=right style='border:blue 1px solid;'>$s[invoice_amount]</td>
            <td align=right>$s[curr_code]</td>
            <td align=right>$s[invoice_date]</td>
            <td >$s[client]</td>
            <td><input type=button value='Edit' onclick='edit($s[ID])'></td>
      </tr>";
}
echo "</table></div>";


?>