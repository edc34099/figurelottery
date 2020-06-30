<?php
include ("../../lib/lib.php");
$myDb1 = new db; $myDb1->open();
$error="0";


// print_r($_POST);
// exit;

if($error=="0"){

	try{

		$myDb1->dbh->beginTransaction();
		
		// 拆解每單的SYSTEMID
		$sId=explode(',',$_POST['sId']);
		$delivery1=explode(',',$_POST['delivery1']);
		// 拆解每單的SYSTEMID
		
		for($i=0;$i<count($sId);$i++){

			$sql="update itemList03 set delivery1=? where systemId=?";
			$tValue=[$delivery1[$i],$sId[$i]];
			$doSql = $myDb1->dbh->prepare($sql);
			$doSql->execute($tValue);

		}
		
		$myDb1->dbh->commit();
	
		
	}catch (Exception $e){
			
		$myDb1->dbh->rollBack();
	
		$lxp_json->description=$e->getMessage();
	}



	
	
	
}
// $lxp_json->systemId=$sys;
$lxp_json->error=$error;
header("Content-type: application/text; charset=utf-8");
echo json_encode($lxp_json);

?>
