<?php
include_once ("../../lib/lib.php");
$myDb1 = new db; $myDb1->open();
$error=0;



// print_r($_POST);
// print_r($_FILES);
// exit;
$files = getFiles();
$path="../../../files/list";
// 依上傳檔案數執行
foreach ($files as $fileInfo) {
    // 呼叫封裝好的 function
    $res = uploadFile($fileInfo,$path);
 
    // 顯示檔案上傳訊息
    // echo $res['mes'] . '<br>';
 
    // 上傳成功，將實際儲存檔名存入 array（以便存入資料庫）
    if (!empty($res['dest'])) {
        $uploadFiles[] = $res['dest'];
    }
    // print_r($uploadFiles);
}

// print_r($uploadFiles[]);

    // print_r($a.'<br>');

try{

    $myDb1->dbh->beginTransaction();
        

    // $data = $doSql->fetchAll(PDO::FETCH_ASSOC);
    for($i=0;$i<count($uploadFiles);$i++){
        if($i==0){
            // $a=insert("itemList02",["systemId","relaId1","userId1","img1","type1"],[microtime_float(),$_POST['systemId'],$_POST['userId1'],str($uploadFiles[$i]),1],0);
            $sql="insert into itemList02(systemId,relaId1,userId1,img1,type1) values(?,?,?,?,?)";
            $tValue=[microtime_float(),$_POST['systemId'],$_POST['userId1'],$uploadFiles[$i],1];
            $doSql = $myDb1->dbh->prepare($sql);
            $doSql->execute($tValue);
        }else{
            // $a=insert("itemList02",["systemId","relaId1","userId1","img1"],[microtime_float(),$_POST['systemId'],$_POST['userId1'],str($uploadFiles[$i])],0);
            $sql="insert into itemList02(systemId,relaId1,userId1,img1,type1) values(?,?,?,?,?)";
            $tValue=[microtime_float(),$_POST['systemId'],$_POST['userId1'],$uploadFiles[$i],0];
            $doSql = $myDb1->dbh->prepare($sql);
            $doSql->execute($tValue);
        }
    }
	
	
	$myDb1->dbh->commit();

	
}catch (Exception $e){
		
	$myDb1->dbh->rollBack();

	$lxp_json->description=$e->getMessage();
}


$lxp_json->error=$error;
header("Content-type: application/text; charset=utf-8");
echo json_encode($lxp_json);

?>
