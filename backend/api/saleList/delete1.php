<?php
include_once ("../../lib/lib.php");
$myDb1 = new db; $myDb1->open();
$error=0;

try{

	$myDb1->dbh->beginTransaction();
	
  $sql="update itemList set isDel=1 where systemId=? and userId1=?";
  $tValue=[$_POST['systemId'],$_POST['userId1']];
  $doSql = $myDb1->dbh->prepare($sql);
  $doSql->execute($tValue);
  // $data = $doSql->fetchAll(PDO::FETCH_ASSOC);

	
	
	$myDb1->dbh->commit();

	
}catch (Exception $e){
		
	$myDb1->dbh->rollBack();

	$lxp_json->description=$e->getMessage();
}


$lxp_json->error=$error;

header("Content-type: application/text; charset=utf-8");
echo json_encode($lxp_json);

?>
