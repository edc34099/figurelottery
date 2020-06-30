<?php
include ("../../lib/lib.php");
// error_reporting(E_ALL);

// ini_set('display_errors', 'On');
// $data=getSql("select * from itemList");

// print_r($data);
// print_r($_POST);
// print_r($_FILES);
// exit;
// relaId1是商品單號
// 檢查userId1是否是擁有者
$error="0";
if($error=="0"){
	$sql="select * from itemList where systemId=".$_POST['relaId1'];
	$data=getSql($sql);

	if($data[0]['userId1']!=$_POST['userId1']){
		$error="擁有者才能進行抽獎";
	}
}
// 檢查userId1是否是擁有者

// 檢查是否滿單?
// 檢查是否滿單?

// 取出獎項陣列
if($error=="0"){
	$sql="select * from itemList01 where relaId1=".$_POST['relaId1'];
	$data=getSql($sql);

	// print_r($data);
	$item=[];
	foreach($data as $d){
		// 取出每列獎項的數目並丟進獎項陣列
		for($i=0;$i<$d['num1'];$i++){
			array_push($item,$d['systemId']);
		}
		// 取出每列獎項的數目並丟進獎項陣列
		
	}

	print_r($item);
}
// 取出獎項陣列

// 依照購買時的rand大小取出陣列
if($error=="0"){
	$sql="select * from itemList03sub1 where relaId1=".$_POST['relaId1']." order by rand1 DESC";
	$data1=getSql($sql);

	// print_r($data1);
	
	// 由大到小放入獎項
	for($i=0;$i<count($data1);$i++){
		$sql="update itemList03sub1 set relaId3=".$item[$i]." where systemId=".$data1[$i]['systemId'];
		doSql($sql);
	}
}
// 依照購買時的rand大小取出陣列

// 隨機總抽數用陣列位置發給隨機到的陣列位置-最後賞
if($error=="0"){
	// print_r(count($data1));
	// 陣列總數
	$ary=count($data1)-1;
	$rand=rand(0,$ary);
	print_r($data1);
	$sql="update itemList set last2=".$data1[$rand]['userId1'].", last3=".$data1[$rand]['relaId2']." where systemId=".$_POST['relaId1'];
	doSql($sql);

}
// 隨機總抽數用陣列位置發給隨機到的陣列位置-最後賞

 

// $lxp_json->systemId=$sys;
$lxp_json->error=$error;
header("Content-type: application/text; charset=utf-8");
echo json_encode($lxp_json);

?>
