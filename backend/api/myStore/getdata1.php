<?php
include_once ("../../lib/lib.php");
$myDb1 = new db; $myDb1->open();
$error="0";

// 取得儲值清單
$sql="select *
 from addValue a where a.userId1=? and a.isDel=0";
$tValue=[$_POST['userId1']];
$doSql = $myDb1->dbh->prepare($sql);
$doSql->execute($tValue);
$data = $doSql->fetchAll(PDO::FETCH_ASSOC);

$i=0;
foreach ($data as $row) {
	foreach ($row as $key => $value) {
		if (gettype($value)=="NULL"){
			$row[$key]="";
		}else if (gettype($value)!="string"){
					$row[$key]=(string)$value;
		}		
	}
	
	
	$lxp_json->add[$i]=array();
	$lxp_json->add[$i]=$row;
	
	$i++;
}
// 取得儲值清單

$date1=(!empty($_POST['date1']))?" and date1>='".$_POST['date1']."'":"";
$date2=(!empty($_POST['date2']))?" and date1<='".$_POST['date2']."'":"";

// 取得主表資料
$sql="select *
,(select b.img1 from itemList02 b where b.relaId1=a.systemId and b.type1=1) as img
,(select sum(b.num1) from itemList01 b where b.relaId1=a.systemId) as num
,((select sum(b.num1) from itemList01 b where b.relaId1=a.systemId)*a.price1 ) as price
 from itemList a where a.userId1=? and a.status1=2 and a.isDel=0".$date1.$date2;
$tValue=[$_POST['userId1']];
$doSql = $myDb1->dbh->prepare($sql);
$doSql->execute($tValue);
$data = $doSql->fetchAll(PDO::FETCH_ASSOC);

$i=0;
foreach ($data as $row) {
	foreach ($row as $key => $value) {
		if (gettype($value)=="NULL"){
			$row[$key]="";
		}else if (gettype($value)!="string"){
					$row[$key]=(string)$value;
		}		
	}
	
	
	$lxp_json->datas[$i]=array();
	$lxp_json->datas[$i]=$row;
	
	$i++;
}
// 取得主表資料

// 取得訂單得獎項目
for($j=0;$j<count($data);$j++){


	// $sql="SELECT
	// *
	// ,(select b.name1 from itemList01 b where b.systemId=a.relaId3) as iName
	// ,(select b.last1 from itemList b where b.last3=a.relaId2) as lastName
	// FROM
	// itemList03sub1 a
	// WHERE
	// a.relaId2 = ".$data[$j]['systemId']."
	// ";
	
	// $data1=getSql($sql);
	$sql="select *
	,(select b.name1 from userInfo b where b.userId1=a.userId1) as uName
	,(num1 * (select b.price1 from itemList b where b.systemId=a.relaId1)) as price
	 from itemList03 a where a.relaId1=? ";
	$tValue=[$data[$j]['systemId']];
	$doSql = $myDb1->dbh->prepare($sql);
	$doSql->execute($tValue);
	$data1 = $doSql->fetchAll(PDO::FETCH_ASSOC);
	
	$i=0;
	foreach ($data1 as $row) {
		foreach ($row as $key => $value) {
			if (gettype($value)=="NULL"){
				$row[$key]="";
			}else if (gettype($value)!="string"){+
				$row[$key]=(string)$value;
			}
		}
		
		$lxp_json->datas2[$j]->item[$i]=array();
		$lxp_json->datas2[$j]->item[$i]=$row;
		
		$i++;
	}
	
	}
// 取得訂單得獎項目





header("Content-type: application/text; charset=utf-8");
echo json_encode($lxp_json);

?>
