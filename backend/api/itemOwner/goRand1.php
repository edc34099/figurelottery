<?php
include ("../../lib/lib.php");
$myDb1 = new db; $myDb1->open();
$error="0";



try{

	$myDb1->dbh->beginTransaction();
	
	// 檢查userId1是否是擁有者
	if($error=="0"){
		// $sql="select * from itemList where systemId=".$_POST['relaId1'];
		// $data=getSql($sql);

		$sql="select *
		,(select sum(b.num1) from itemList01 b where b.relaId1=a.systemId) as sumNum
		from itemList a where a.systemId=?";
		$tValue=[$_POST['relaId1']];
		$doSql = $myDb1->dbh->prepare($sql);
		$doSql->execute($tValue);
		$data = $doSql->fetchAll(PDO::FETCH_ASSOC);
	
		if($data[0]['userId1']!=$_POST['userId1']){
			$error="擁有者才能進行抽獎";
		}else if($data[0]['status2']!=0){
			$error="已經抽過獎";
		}

		$money=$data[0]['sumNum']*$data[0]['price1'];
	}
	// 檢查userId1是否是擁有者

	// 檢查是否滿單?
	if($error=="0"){
		// $sql="select * from itemList where systemId=".$_POST['relaId1'];
		// $data=getSql($sql);

		$sql="select sum(num1) as sum from itemList01 where relaId1=? and isDel=0";
		$tValue=[$_POST['relaId1']];
		$doSql = $myDb1->dbh->prepare($sql);
		$doSql->execute($tValue);
		$data1 = $doSql->fetchAll(PDO::FETCH_ASSOC);

		$sql="select sum(num1) as sum from itemList03 where relaId1=? and isDel=0";
		$tValue=[$_POST['relaId1']];
		$doSql = $myDb1->dbh->prepare($sql);
		$doSql->execute($tValue);
		$data2 = $doSql->fetchAll(PDO::FETCH_ASSOC);
	
		if($data1[0]['sum']>$data2[0]['sum']){
			$error="尚未滿單";
		}
	}
	// 檢查是否滿單?

	// 取出獎項陣列
	if($error=="0"){
		// $sql="select * from itemList01 where relaId1=".$_POST['relaId1'];
		// $data=getSql($sql);

		$sql="select * from itemList01 where relaId1=?";
		$tValue=[$_POST['relaId1']];
		$doSql = $myDb1->dbh->prepare($sql);
		$doSql->execute($tValue);
		$data = $doSql->fetchAll(PDO::FETCH_ASSOC);

		// print_r($data);
		$item=[];
		foreach($data as $d){
			// 取出每列獎項的數目並丟進獎項陣列
			for($i=0;$i<$d['num1'];$i++){
				array_push($item,$d['systemId']);
			}
			// 取出每列獎項的數目並丟進獎項陣列
			
		}

		// print_r($item);
	}
	// 取出獎項陣列


	// 依照購買時的rand大小取出陣列
	if($error=="0"){
		// $sql="select * from itemList03sub1 where relaId1=".$_POST['relaId1']." order by rand1 DESC";
		// $data1=getSql($sql);

		$sql="select * from itemList03sub1 where relaId1=? order by rand1 DESC";
		$tValue=[$_POST['relaId1']];
		$doSql = $myDb1->dbh->prepare($sql);
		$doSql->execute($tValue);
		$data1 = $doSql->fetchAll(PDO::FETCH_ASSOC);

		// print_r($data1);
		
		// 由大到小放入獎項
		for($i=0;$i<count($data1);$i++){
			// $sql="update itemList03sub1 set relaId3=".$item[$i]." where systemId=".$data1[$i]['systemId'];
			// doSql($sql);
			$sql="update itemList03sub1 set relaId3=? where systemId=?";
			$tValue=[$item[$i],$data1[$i]['systemId']];
			$doSql = $myDb1->dbh->prepare($sql);
			$doSql->execute($tValue);
		}
	}
	// 依照購買時的rand大小取出陣列


	// 隨機總抽數用陣列位置發給隨機到的陣列位置-最後賞
	if($error=="0"){
		// print_r(count($data1));
		// 陣列總數
		$ary=count($data1)-1;
		$rand=rand(0,$ary);
		// print_r($data1);
		// $sql="update itemList set last2=".$data1[$rand]['userId1'].", last3=".$data1[$rand]['relaId2']." where systemId=".$_POST['relaId1'];
		// doSql($sql);

		$sql="update itemList set last2=?, last3=? ,status2=1 where systemId=?";
		$tValue=[$data1[$rand]['userId1'],$data1[$rand]['relaId2'],$_POST['relaId1']];
		$doSql = $myDb1->dbh->prepare($sql);
		$doSql->execute($tValue);
		// $data = $doSql->fetchAll(PDO::FETCH_ASSOC);

	}
	// 隨機總抽數用陣列位置發給隨機到的陣列位置-最後賞

	// 把擁有者的可提領額度取出來  然後加上這單的98%金額
	if($error=="0"){

		$sql="select * from userInfo where userId1=?";
		$tValue=[$_POST['userId1']];
		$doSql = $myDb1->dbh->prepare($sql);
		$doSql->execute($tValue);
		$data = $doSql->fetchAll(PDO::FETCH_ASSOC);

		$money1=$data[0]['money1']+floor($money*0.98);

		$sql="update userInfo set money1=? where userId1=?";
		$tValue=[$money1,$_POST['userId1']];
		$doSql = $myDb1->dbh->prepare($sql);
		$doSql->execute($tValue);

	}
	// 把擁有者的可提領額度取出來  然後加上這單的98%金額


	
	$myDb1->dbh->commit();

	
}catch (Exception $e){
		
	$myDb1->dbh->rollBack();

	$lxp_json->description=$e->getMessage();
}









 

// $lxp_json->systemId=$sys;
$lxp_json->error=$error;
header("Content-type: application/text; charset=utf-8");
echo json_encode($lxp_json);

?>
