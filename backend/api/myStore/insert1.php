<?php
include ("../../lib/lib.php");
// error_reporting(E_ALL);

// ini_set('display_errors', 'On');
// $data=getSql("select * from itemList");

// print_r($data);
// print_r($_POST);
// print_r($_FILES);
// exit;
$error="0";

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
	$sql="select IF(sum(num1) is null ,'0',sum(num1)) as sum from itemList03 b where b.relaId1=".$_POST['relaId1'];
	$data=getSql($sql);
	// 取出已抽抽數
	
	$a=$data[0]['sum']+$_POST['num1'];//已抽總數+這次下單抽數

	if($a>$_POST['sum']){
		$error="剩餘數量不足";
	}
}
// 檢查剩餘抽數


if($error=="0"){
	
	$field=[];
	$value=[];

	// $i=0;
	// foreach($_POST['data1'] as $k=>$v){
	// 	$v=(!empty($v))?$v:'null';
	// 	$field[$i]=$k;
	// 	if($k=='name1'||$k=='memo1' ||$k=='last1' ||$k=='date1' ||$k=='date2'){
	// 		$v=str($v);
	// 	}
	// 	$value[$i]=$v;
	// 	$i++;
	// }
	// // print_r($post);
	// $sys=microtime_float();

	// $field[$i]="systemId";
	// $value[$i]=$sys;
	// $i++;

	// $field[$i]="userId1";
	// $value[$i]=$_POST['userId1'];
	// $i++;

	// insert("itemList",$field,$value,0);
	for($j=0;$j<$_POST['num1'];$j++){

		$i=0;
		foreach($_POST as $k=>$v){


				$v=(!empty($v))?$v:'null';
				
				$field[$i]=$k;
				if($k!='sum' && $k!='date1' && $k!='date2'){
					if($k=='num1'){
						$value[$i]='1';
					}else{
						$value[$i]=$v;
					}
					$i++;						
				}
			
			
		}
		// print_r($post);
		$sys=microtime_float();
		
		$field[$i]="systemId";
		$value[$i]=$sys;
		$i++;

		$rand=rand(0,99999);
		$field[$i]="rand1";
		$value[$i]=$rand;
		$i++;
		
		
		$a=insert("itemList03",$field,$value,0);
	}
	// print_r($a);
	
	
}
// $lxp_json->systemId=$sys;
$lxp_json->error=$error;
header("Content-type: application/text; charset=utf-8");
echo json_encode($lxp_json);

?>
