<?php
include ("../../lib/lib.php");
$myDb1 = new db; $myDb1->open();
$error="0";


// print_r($_POST);
// exit;


// 檢查日期
$today=strtotime(date("Y-m-d"));
$date1=strtotime($_POST['date1']);
$date2=strtotime($_POST['date2']);
if($date1>$today){
	$error="尚未開放購買";
}else if($date2<$today){
	$error="已經截止";
}
// 檢查日期

// 檢查剩餘抽數
if($error=="0"){
	// 取出已抽抽數
	// $sql="select IF(sum(num1) is null ,'0',sum(num1)) as sum from itemList03 b where b.relaId1=".$_POST['relaId1'];
	// $data=getSql($sql);
	$sql="select IF(sum(num1) is null ,'0',sum(num1)) as sum from itemList03 b where b.relaId1=?";
	$tValue=[$_POST['relaId1']];
	$doSql = $myDb1->dbh->prepare($sql);
	$doSql->execute($tValue);
	$data = $doSql->fetchAll(PDO::FETCH_ASSOC);
	// 取出已抽抽數

	
	$a=$data[0]['sum']+$_POST['num1'];//已抽總數+這次下單抽數

	if($a>$_POST['sum']){
		$error="剩餘數量不足";
	}
}
// 檢查剩餘抽數

if($error=="0"){

	try{

		$myDb1->dbh->beginTransaction();
		
		// 加入03訂單主表	
		$sys=microtime_float();
		
		$sql="insert into itemList03(systemId,relaId1,num1,store1,userId1) value(?,?,?,?,?)";
		$tValue=[$sys,$_POST['relaId1'],$_POST['num1'],$_POST['store1'],$_POST['userId1']];
		$doSql = $myDb1->dbh->prepare($sql);
		$doSql->execute($tValue);
		// 加入03訂單主表
		
		// 加入03子表
		$field=[];
		$value=[];
		for($j=0;$j<$_POST['num1'];$j++){
			
			$rand=rand(0,99999);

			$sql="insert into itemList03sub1(systemId,relaId1,relaId2,rand1,userId1) value(?,?,?,?,?)";
			$tValue=[microtime_float(),$_POST['relaId1'],$sys,$rand,$_POST['userId1']];
			$doSql = $myDb1->dbh->prepare($sql);
			$doSql->execute($tValue);			
		
		}
	
		// 加入03子表
		
		
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
