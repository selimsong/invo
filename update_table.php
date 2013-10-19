<?php
/*
 * @Copyright (c) 2007, www.cushwake.com
 * @All rights reserved.
 *
 * @File name：
 * 
 * @summery：
 *
 * @author：leon.zhao@ap.cushwake.com
 * @date：06.22.2007 10:22 AM
 *
 */
require_once(dirname(__FILE__) . "/invoice.config.php");
require_once(dirname(__FILE__) . "/adodb.class.php");

// ALTER TABLE ap_07 ADD Key_Client varchar(255) default 'NULL' 
$db = new dbClass($db_ado);
$approve_list_sql = "ALTER TABLE " . INVLIST . " ADD Key_Client varchar(255) default 'NULL'  ";
echo $approve_list_sql;
$r = $db->SelectSql($approve_list_sql);

echo "<br /><br /><br />";



echo "<br />";
echo "update success !";


?>