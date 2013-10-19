<?php
/*
 * @Copyright (c) 2007, www.cushwake.com
 * @All rights reserved.
 *
 * @File name：adodb.class.php
 * 
 * @summery：Adodb classes
 *
 * @author：leon.zhao@ap.cushwake.com
 * @date：06.22.2007 10:22 AM
 *
 */

class dbClass{
	var $db = false;
	var $message;
	var $orderBy;
	var $sqlWhere;
	var $limitRecords;
	var $fields;
	function dbClass($thisDB = false){
		global $db_ado;
		$this->db = $thisDB?$thisDB:$db_ado;
		$this->message = "";
		$this->orderBy = "ID";
		$this->sqlWhere = "WHERE 1";
		$this->limitRecords = "";
		$this->fields = "*";
	}
    function SelectSql($sql){
//    	echo "$sql\n";
        $row = false;
        $rs = $this->db->Execute($sql);
        if (!$rs) 
            return false;
        else
        while (!$rs->EOF) {
            $row[] = $rs->fields;
            $rs->MoveNext();
        }
        $rs->Close();
        return $row;
    }
	function getInfo($table){
		$sql = "SELECT " . $this->fields . " FROM " . $table . " " . $this->sqlWhere .  " order by " . $this->orderBy . $this->limitRecords;
		//echo $sql . "<br>";
		return $this->SelectSql($sql);
	}
	function setSelectFields($fields){
		if(!is_array($fields))$this->fields = $fields;
		else{
			$this->fields = "";
			foreach ($fields as $key=>$values){
				$this->fields .= $values . ",";
			}
			$this->fields = substr($this->fields,0,strlen($this->fields)-1);
		}
	}
	function setMessage($msg){
		$this->message = $this->message . $msg;
	}
	function sendMessage(){
		echo $this->message;
	}
    function insert($table,$array){
    	if(!is_array($array)||$table == ""){
    		$msg = 'error $db->getCostInfo syntax(error input)';
    		$this->setMessage($msg);
    		$this->sendMessage();
    	}
    	else{
    		$index = "";
    		$V = "";
    		foreach($array as $key=>$values){
    			$index = $index ." `". $key . "`,";
    			$V = $V ." '". $values . "',";
    		}
    		$index = substr($index,0,strlen($index)-1);
    		$V = substr($V,0,strlen($V)-1);
    		$sql = "INSERT INTO " . $table . " (" . $index . ") 
VALUES (" . $V . ")";
			$res = $this->db->Execute($sql);
			if(!$res){
				$msg = 'error message:<br /><font color=red>' . $this->db->ErrorMsg() . "</font>";
    			$this->setMessage($msg);
    			$this->sendMessage();
    			return false;
			}
			else{
				return true;
			}
    	}
    }
	function setLimitRecords($begin,$end){
		$this->limitRecords = " LIMIT " . $begin . " ," . $end;
	}
	function getAllInfo($table){
		$sql = "SELECT * FROM " . $table;
		return $this->SelectSql($sql);
	}
	function setOrderBy($order){
		$this->orderBy = $order;
	}
	function deleteFromTable($table,$id){
		$sql = "DELETE FROM " . $table . " WHERE ID=" . $id;
		$rs = $this->db->Execute($sql);
        if (!$rs){ 
			$msg = 'error message:<br /><font color=red>' . $this->db->ErrorMsg() . "</font>";
			$this->setMessage($msg);
			$this->sendMessage();
            return false;
        }
        else
        	return true;
        $rs->Close();
	}
	function getSpecificInfoById($table,$id){
		$sql = "SELECT " . $this->fields . " FROM " . $table . " WHERE ID=" . $id;
		return $this->SelectSql($sql);
	}
	function setSqlWhere($where){
		$this->sqlWhere = $where;
		return true;
	}
	function updateTable($table,$array){
		if(!is_array($array)){
			echo "error, for input updateTable function should be a array";
			exit();
		}
		$upStr = "";
		foreach($array as $key=>$values){
			$upStr = $upStr . " `" . $key . "` = '" . $values . "',";
		}
		$upStr = substr($upStr,0,strlen($upStr)-1);
		if($this->sqlWhere == "WHERE 1"){
			echo "error updating for you did not specify the sqlwhere ,please using <br><font color=red>function setSqlWhere(\$where)</font> to set the sqlWhere";
			exit();
		}
		$upsql = "UPDATE " . $table . " SET " . $upStr . " " . $this->sqlWhere;
//		echo $upsql . "<br>";
//		exit();
		$rs = $this->db->Execute($upsql);
		if(!$rs){
			return false;
		}
		else{
			return true;
		}
	}
}
?>