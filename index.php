<?php include_once("./backend/lib/lib.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>【一抽入魂】*~一番賞集單~*</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" type="image/png" sizes="32x32" href="images/logo/care-logo-t.png" />


    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/basicTable.css">

    <script type="text/javascript" src="./js/jquery.min.js"></script>
    <script defer type="text/javascript" src="./js/jquery.serializejson.min.js"></script>
    <script defer type="text/javascript" src="./js/jquery.form.min.js"></script>

    <script type="text/javascript" src="./js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="./js/basicTable.js"></script>

    <script src="https://kit.fontawesome.com/de3a3a2b24.js" crossorigin="anonymous"></script> 



    <style type="text/css">
       
    </style>
</head>

<body style='font-family:"微軟正黑體"'>
<div style='background:rgba(200,200,200,0.5); width:100%;height:100%; position:fixed; z-index:9999; display:none;' data-name='loading'>
<div class="d-flex justify-content-center" style='width:100%;height:100%; position:absolute; z-index:9999;'>
  <div class="spinner-border text-light" role="status" style="position:relative; top:50%; width: 3rem; height: 3rem;">
    <span class="sr-only">Loading...</span>
  </div>
</div>
</div>
     <!-- 版頭banner -->
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style='display:none; background:	#B3D9D9;'>
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner" style='height:20vh; '>
    <div class="carousel-item active">
      <img src="./img/broly/broly1.jpg" class="d-block w-80" style='margin:auto;' alt="...">
    </div>
    <div class="carousel-item">
      <img src="./img/broly/broly2.jpg" class="d-block w-80" style='margin:auto;' alt="...">
    </div>
    <div class="carousel-item">
      <img src="./img/broly/broly3.jpg" class="d-block w-80" style='margin:auto;' alt="...">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev" >
    <span class="carousel-control-prev-icon" aria-hidden="true" ></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next" >
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<ul class="nav justify-content-center bg-info">
<?php
  //產生導覽列
  $item=['home','list','myStore','member'];
  $itemC=['首頁','商品列表','賣家中心','會員中心'];
  $itemIcon=['<i class="fas fa-home m-1"></i>','<i class="fas fa-list-alt m-1"></i>','<i class="fas fa-store m-1"></i>','<i class="fas fa-user m-1"></i>'];

  $html='';
  for($i=0;$i<count($item);$i++){
    $html.='<li class="nav-item">';
    $html.='<a class="nav-link active text-light" href="https://figurelottery.com?p='.$item[$i].'" >'.$itemIcon[$i].$itemC[$i].'</a>';
    $html.='</li>';
   
  }
  echo $html;
?>
</ul>

<!-- <hr> -->



<div class="container" style='height:auto; background:rgba();' data-name='main'>
<?php

  $p=(!empty($_GET['p']))?$_GET['p']:"home";

  
  include('./pages/'.$p.'.php');
 

?>

</div>


<footer class="bg-info pt-5 mt-5 text-light">
      <div class="container">
        <p class="float-right">
          <a href="#">Back to top</a>
        </p>
        <!-- <h5 class="text-uppercase">一番賞集單</h5> -->
        <p>一個讓廠商上架一番賞提供給用戶集單的平台</p>
        <p>尚未正式營運，試營運期間將先以白名單的方式提供廠商上架，敬請期待</p>
        <p>商務合作及客戶服務信箱:kyifanshang@gmail.com</p>
      </div>
      <div class="footer-copyright text-center py-3">© 2020 Copyright:
    <a href="https://figurelottery.com/">figurelottery.com</a>
  </div>
    </footer>

</body>
<script type="text/javascript" src="./js/control.js"></script>
<script>

</script>
</html>




