<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
date_default_timezone_set('Asia/Taipei');
$lxp_json = new stdClass();
// $pdo = new PDO('mysql:host=localhost;dbname=figurelottery;charset=utf8', 'edc34099', 'x123698745',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
// $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);	
// $pdo->exec("set names 'utf8'");

class db{
    var $host=null;
    var $user=null;
    var $password=null;
    var $name=null;
    var $dbh=null;

    function open(){
        try{
            $lxp_dbhTemp=new PDO('mysql:host=localhost;dbname=figurelottery;charset=utf8', 'edc34099', 'x123698745',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $lxp_dbhTemp->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);	
            $lxp_dbhTemp->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            // $lxp_dbhTemp->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
            $lxp_dbhTemp->exec("set names 'utf8'");
            $lxp_dbhTemp->exec("SET TIME_ZONE='+8:00'");
            $this->dbh=$lxp_dbhTemp;
            //維持連線 , array(PDO::ATTR_PERSISTENT => true)
        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }
}
// $pdo->beginTransaction();
// print_r($pdo);

// 丟入陣列處理成字串加入資料庫
function insert($table,$fieldAry,$valueAry,$r){
	
    // global $pdo;
    // $a=$pdo->inTransaction();
    // if($a==false){
    //     $pdo->beginTransaction();
    // }
    
	$field='';

	for($i=0;$i<count($fieldAry);$i++){
		if($i==0){
			$field.='`'.$fieldAry[$i].'`';
		}else{
			$field.=',`'.$fieldAry[$i].'`';
		}
	}

	$value='';

	for($i=0;$i<count($valueAry);$i++){
		if($i==0){
			$value.=''.$valueAry[$i].'';
		}else{
			$value.=','.$valueAry[$i].'';
		}
	}	

	$sql='insert into '.$table.'('.$field.') values('.$value.')';
	if($r=='1'){
        return($sql);
    } 
        
    // $a=$pdo->exec($sql);
    // return $a;
}

// 丟入陣列處理成字串更新資料庫
function update($table,$fieldAry,$valueAry,$fieldAry2,$valueAry2){
	
	global $pdo;

	$field='';

	for($i=0;$i<count($fieldAry);$i++){
		if($i==0){
			$field.='`'.$fieldAry[$i].'`='.$valueAry[$i];
		}else{
			$field.=',`'.$fieldAry[$i].'`='.$valueAry[$i];
		}
	}

	$where='';
	
	for($i=0;$i<count($fieldAry2);$i++){
		if($i==0){
			$field.='`'.$fieldAry2[$i].'`='.$valueAry2[$i];
		}else{
			$field.=' and `'.$fieldAry2[$i].'`='.$valueAry2[$i];
		}
	}


	$sql='update '.$table.' set '.$field.' where '.$where;
	$pdo->exec($sql);
}

function getSql($sql){

	global $pdo;

	$data=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

	return $data;
}

function doSql($sql){

	global $pdo;

	$pdo->exec($sql);

	
}

function microtime_float($vVal1="0"){
	//$pAryUtimes = explode(" ", microtime());
	//return ((string)$pAryUtimes[1] . (string)($pAryUtimes[0]*1000000));
	$utimestamp = microtime(true);
	$timestamp = floor($utimestamp);
	$milliseconds = round(($utimestamp - $timestamp) * 100000);
	$milliseconds = str_pad($milliseconds,5,'0',STR_PAD_LEFT);

	$pRet=date(preg_replace('`(?<!\\\\)u`', $milliseconds, 'YmdHisu'), $timestamp);

	while ($vVal1===$pRet){
		//echo "<br />re:".$pRet."=".$vVal1."<br /><br />";
		//$lxp_json->description.="[|] replace:".$pRet."=".$vVal1;
		list($s1, $s2) = explode(' ', microtime()); 
		$pRet=date('YmdHis',$s2).substr(str_replace('0.','',$s1),0,5);			
	}

	if ($vVal1!==$pRet){
		return($pRet);
	}
	
}

function str($str){
	if($str!='null'){
		$str="'".$str."'";
	}
	return $str;
}

function getFiles() {
    $i = 0;  // 遞增 array 數量
 
    foreach ($_FILES as $file) {
        // string 型態，表示上傳單一檔案
        if (is_string($file['name'])) {
            $files[$i] = $file;
            $i++;
        }
        // array 型態，表示上傳多個檔案
        elseif (is_array($file['name'])) {
            foreach ($file['name'] as $key => $value) {
                $files[$i]['name'] = $file['name'][$key];
                $files[$i]['type'] = $file['type'][$key];
                $files[$i]['tmp_name'] = $file['tmp_name'][$key];
                $files[$i]['error'] = $file['error'][$key];
                $files[$i]['size'] = $file['size'][$key];
                $i++;
            }
        }
    }
 
    return $files;
}
 

function uploadFile($fileInfo, $uploadPath, $allowExt = array('jpeg', 'jpg', 'gif', 'png'), $maxSize = 2097152, $flag = true ){
    // 存放錯誤訊息
    $res = array();
 
    // 取得上傳檔案的擴展名
    $ext = pathinfo($fileInfo['name'], PATHINFO_EXTENSION); 
 
    // 確保檔案名稱唯一，防止重覆名稱產生覆蓋
    // $uniName = md5(uniqid(microtime(true), true)) . '.' . $ext;
    $uniName = microtime_float() . '.' . $ext;
    $destination = $uploadPath . '/' . $uniName;
     
    // 判斷是否有錯誤
    if ($fileInfo['error'] > 0) {
        // 匹配的錯誤代碼
        switch ($fileInfo['error']) {
            case 1:
                $res['mes'] = $fileInfo['name'] . ' 上傳的檔案超過了 php.ini 中 upload_max_filesize 允許上傳檔案容量的最大值';
                break;
            case 2:
                $res['mes'] = $fileInfo['name'] . ' 上傳檔案的大小超過了 HTML 表單中 MAX_FILE_SIZE 選項指定的值';
                break;
            case 3:
                $res['mes'] = $fileInfo['name'] . ' 檔案只有部分被上傳';
                break;
            case 4:
                $res['mes'] = $fileInfo['name'] . ' 沒有檔案被上傳（沒有選擇上傳檔案就送出表單）';
                break;
            case 6:
                $res['mes'] = $fileInfo['name'] . ' 找不到臨時目錄';
                break;
            case 7:
                $res['mes'] = $fileInfo['name'] . ' 檔案寫入失敗';
                break;
            case 8:
                $res['mes'] = $fileInfo['name'] . ' 上傳的文件被 PHP 擴展程式中斷';
                break;
        }
 
        // 直接 return 無需在往下執行
        return $res;
    }
 
    // 檢查檔案是否是通過 HTTP POST 上傳的
    if (!is_uploaded_file($fileInfo['tmp_name']))
        $res['mes'] = $fileInfo['name'] . ' 檔案不是通過 HTTP POST 方式上傳的';
     
    // 檢查上傳檔案是否為允許的擴展名
    if (!is_array($allowExt))  // 判斷參數是否為陣列
        $res['mes'] = $fileInfo['name'] . ' 檔案類型型態必須為 array';
    else {
        if (!in_array($ext, $allowExt))  // 檢查陣列中是否有允許的擴展名
            $res['mes'] = $fileInfo['name'] . ' 非法檔案類型';
    }
 
    // 檢查上傳檔案的容量大小是否符合規範
    if ($fileInfo['size'] > $maxSize)
        $res['mes'] = $fileInfo['name'] . ' 上傳檔案容量超過限制';
 
    // 檢查是否為真實的圖片類型
    if ($flag && !@getimagesize($fileInfo['tmp_name']))
        $res['mes'] = $fileInfo['name'] . ' 不是真正的圖片類型';
 
    // array 有值表示上述其中一項檢查有誤，直接 return 無需在往下執行
    if (!empty($res))
        return $res;
    else {
        // 檢查指定目錄是否存在，不存在就建立目錄
        if (!file_exists($uploadPath))
            mkdir($uploadPath, 0777, true);
         
        // 將檔案從臨時目錄移至指定目錄
        if (!@move_uploaded_file($fileInfo['tmp_name'], $destination))  // 如果移動檔案失敗
            $res['mes'] = $fileInfo['name'] . ' 檔案移動失敗';
 
        $res['mes'] = $fileInfo['name'] . ' 上傳成功';
        // $res['dest'] = $destination;
        $res['dest'] = $uniName;
 
        return $res;
    }
}
?>