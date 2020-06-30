<?php
include_once ("../../lib/lib.php");
$error=0;
$myDb1 = new db; $myDb1->open();
error_reporting(E_ALL);



// print_r($_POST);

// exit;

try{

	$myDb1->dbh->beginTransaction();
	
	// 新增主表itemList
	$pData1=$_POST['data1'];
	$sys=microtime_float();
	
	$sql="insert into itemList(systemId,name1,date1,date2,price1,unit1,last1,memo1,userId1) value(?,?,?,?,?,?,?,?,?)";
	$tValue=[$sys,$pData1['name1'],$pData1['date1'],$pData1['date2'],$pData1['price1'],$pData1['unit1'],$pData1['last1'],$pData1['memo1'],$_POST['userId1']];
	$doSql = $myDb1->dbh->prepare($sql);
	$doSql->execute($tValue);
	// 新增主表itemList
	
	// 新增獎項itemList01
	foreach($_POST['data2'] as $pData2){
		$sql="insert into itemList01(systemId,relaId1,name1,num1,userId1) value(?,?,?,?,?)";
		$tValue=[microtime_float(),$sys,$pData2['name1'],$pData2['num1'],$_POST['userId1']];
		$doSql = $myDb1->dbh->prepare($sql);
		$doSql->execute($tValue);
	}
	// 新增獎項itemList01
	
	
	$myDb1->dbh->commit();

	
}catch (Exception $e){
		
	$myDb1->dbh->rollBack();

	$lxp_json->description=$e->getMessage();
}







$lxp_json->systemId=$sys;
$lxp_json->error=$error;
header("Content-type: application/text; charset=utf-8");
echo json_encode($lxp_json);

?>
