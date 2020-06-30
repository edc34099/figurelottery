<?php
include ("../../lib/lib.php");
$myDb1 = new db; $myDb1->open();
$error="0";

// print(date("Y-m-d H:i:s"));
// print_r($_POST);
// exit;
try{

	$myDb1->dbh->beginTransaction();
	// 檢查是否有資料
	$sql="select * from userInfo a where a.userId1=?";
	$tValue=[$_POST['userId1']];
	$doSql = $myDb1->dbh->prepare($sql);
	$doSql->execute($tValue);
	$data = $doSql->fetchAll(PDO::FETCH_ASSOC);
	// $sql="select * from userInfo a where a.userId1=".$_POST['userId1'];
	// print_r($sql);
	// $data=getSql($sql);
	if(count($data)>0){
		$error="已註冊";
	
		// 若會員資料不同
		if($data[0]['name1']!=$_POST['name1'] || $data[0]['email1']!=$_POST['email1']){
			// $sql="update userInfo set name1='".$_POST['name1']."' ,email1='".$_POST['email1']."' where userId1=".$_POST['userId1'];
			$sql="update userInfo set name1=? ,email1=? where userId1=?";
			$tValue=[$_POST['name1'],$_POST['email1'],$_POST['userId1']];
			$doSql = $myDb1->dbh->prepare($sql);
			$doSql->execute($tValue);
			// doSql($sql);
		}
		// 若會員資料不同
	}
	// 檢查是否有資料

	if($error=="0"){

		$field=[];
		$value=[];

		$i=0;
		foreach($_POST as $k=>$v){
			$v=(!empty($v))?$v:'null';
			
			$field[$i]=$k;
			if($k=='name1' || $k=='email1'){
				$v=str($v);			
			}
			$value[$i]=$v;
			$i++;

		}
		// print_r($_POST);
		$sql="insert into userInfo(systemId,name1,email1,userId1) values(?,?,?,?)";
		$tValue=[microtime_floa(),$_POST['name1'],$_POST['email1'],$_POST['userId1']];
		$doSql = $myDb1->dbh->prepare($sql);
		$doSql->execute($tValue);
		
		
	}

	$sql="select * from userInfo a where a.userId1=?";
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

	$myDb1->dbh->commit();

}catch (Exception $e){
		
	$myDb1->dbh->rollBack();

	$lxp_json->description=$e->getMessage();
}

// $lxp_json->sql=$sql;
$lxp_json->error=$error;
header("Content-type: application/text; charset=utf-8");
echo json_encode($lxp_json);

?>
