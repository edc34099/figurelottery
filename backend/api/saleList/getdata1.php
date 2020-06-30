<?php
include_once ("../../lib/lib.php");
$myDb1 = new db; $myDb1->open();
error_reporting(E_ALL);

// print_r($data);
// print_r($_POST);
// exit;

$sql="select *,
(select b.img1 from itemList02 b where b.relaId1=a.systemId and b.type1=1) as img 
from itemList a 
where a.userId1=?
and a.isDel=0 
and a.date1>=?
and a.date1<=?
order by date1,date2";
$tValue=[$_POST['userId1'],$_POST['date1'],$_POST['date2']];
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

	$lxp_json->datas[$i]=array();
	$lxp_json->datas[$i]=$row;
	
	$i++;
}
header("Content-type: application/text; charset=utf-8");
echo json_encode($lxp_json);

?>
