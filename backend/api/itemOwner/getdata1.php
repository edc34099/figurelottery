<?php
include_once ("../../lib/lib.php");
$myDb1 = new db; $myDb1->open();
$error=0;
// print_r($data);


try{

	$myDb1->dbh->beginTransaction();
	

	// 取得主表資料
	$sql="SELECT *
	,(select b.name1 from userInfo b where b.userId1=a.last2) as lastName2
	FROM	itemList a
	WHERE
	a.systemId = ?
	AND isDel = 0";
  $tValue=[$_POST['id']];
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
			if($key=='memo1'){
				$row[$key]=nl2br($value);		
			}
		}
		
		
		$lxp_json->datas[$i]=array();
		$lxp_json->datas[$i]=$row;
		
		$i++;
	}
	// 取得主表資料

	// 取得商品項目資料
	$sql="SELECT
	*
	,(select sum(b.num1) from itemList01 b where b.relaId1=a.relaId1) as sum
	FROM
	itemList01 a
	WHERE
	a.relaId1 = ?
	AND a.isDel = 0
	AND (	SELECT	b.isDel	FROM	itemList b	WHERE	b.systemId = a.relaId1) = 0";
  $tValue=[$_POST['id']];
  $doSql = $myDb1->dbh->prepare($sql);
	$doSql->execute($tValue);
	$data = $doSql->fetchAll(PDO::FETCH_ASSOC);

	$i=0;
	foreach ($data as $row) {
		foreach ($row as $key => $value) {
			if (gettype($value)=="NULL"){
				$row[$key]="";
			}else if (gettype($value)!="string"){+
				$row[$key]=(string)$value;
			}
		}
		
		$lxp_json->datas2[$i]=array();
		$lxp_json->datas2[$i]=$row;
		
		$i++;
	}
	// 取得商品項目資料


	// 取得圖片項目資料
	$sql="SELECT
	*
	FROM
	itemList02 a
	WHERE
	a.relaId1 = ?
	AND a.isDel = 0
	AND (	SELECT	b.isDel FROM	itemList b	WHERE	b.systemId = a.relaId1) = 0";
  $tValue=[$_POST['id']];
  $doSql = $myDb1->dbh->prepare($sql);
	$doSql->execute($tValue);
	$data = $doSql->fetchAll(PDO::FETCH_ASSOC);

	$i=0;
	foreach ($data as $row) {
		foreach ($row as $key => $value) {
			if (gettype($value)=="NULL"){
				$row[$key]="";
			}else if (gettype($value)!="string"){+
				$row[$key]=(string)$value;
			}
		}
		
		$lxp_json->datas3[$i]=array();
		$lxp_json->datas3[$i]=$row;
		
		$i++;
	}
	// 取得圖片項目資料

	// 取得購買清單
	$sql="SELECT
	*,
	(select b.name1 from userInfo b where b.userId1=a.userId1) as uName
	FROM
	itemList03 a
	WHERE
	a.relaId1 = ?
	AND a.isDel = 0
	AND (	SELECT	b.isDel	FROM	itemList b	WHERE	b.systemId = a.relaId1) = 0";
  $tValue=[$_POST['id']];
  $doSql = $myDb1->dbh->prepare($sql);
	$doSql->execute($tValue);
	$data = $doSql->fetchAll(PDO::FETCH_ASSOC);

	$i=0;
	foreach ($data as $row) {
		foreach ($row as $key => $value) {
			if (gettype($value)=="NULL"){
				$row[$key]="";
			}else if (gettype($value)!="string"){+
				$row[$key]=(string)$value;
			}
		}
		
		$lxp_json->datas4[$i]=array();
		$lxp_json->datas4[$i]=$row;
		
		$i++;
	}
	// 取得購買清單


	// 取得購買清單細項
	for($j=0;$j<count($data);$j++){

		$sql="SELECT
		*
		,(select b.name1 from itemList01 b where b.systemId=a.relaId3) as iName
		,(select b.last1 from itemList b where b.last3=a.relaId2) as lastName
		FROM
		itemList03sub1 a
		WHERE
		a.relaId2 = ?";
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
			
			$lxp_json->datas5[$j]->item[$i]=array();
			$lxp_json->datas5[$j]->item[$i]=$row;
			
			$i++;
		}
		
	}
	// 取得購買清單細項
	
	
	$myDb1->dbh->commit();

	
}catch (Exception $e){
		
	$myDb1->dbh->rollBack();

	$lxp_json->description=$e->getMessage();
}










$lxp_json->error=$error;

header("Content-type: application/text; charset=utf-8");
echo json_encode($lxp_json);

?>
