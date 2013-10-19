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
require_once(dirname(__FILE__) . "/check_sess.php");

$db = new dbClass($db_ado);
if($_SESSION["user_type"] == "Administrator"){
    
    if(isset($_GET["id"])){
        $delSql = "DELETE FROM " . LOG . " WHERE log_id=" . $_GET["id"] . " LIMIT 1";
        $d = $db_ado->Execute($delSql);
    }
    else if(isset($_POST["delid"])){
        foreach($_POST["delid"] as $key=>$id){
            $delSql = "DELETE FROM " . LOG . " WHERE log_id=" . $id. " LIMIT 1";
            $d = $db_ado->Execute($delSql);
        }
    }
    else{
        echo "<script language='javascript'>
        window.alert('Sorry, this is protected ');
        window.close();
        </script>"; 
    }   
	if($d){
			echo "<script language='javascript'>
			window.alert('Delete ok!');
			window.history.back();
			</script>";
	}
	else{
		echo "<script language='javascript'>
			window.alert('Sorry, failed');
			window.history.back();
		</script>";
	}
}
else {
		echo "<script language='javascript'>
			window.alert('Sorry, this is protected ');
			window.close();
		</script>";
}

?>