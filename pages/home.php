

<!-- 目前狀態：<span id="FB_STATUS_1"></span> -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title></title>
</head>
<body>
<div data-name='' class="row">
  <div class="form-group col">
    <label for="formGroupExampleInput">開始日期</label>
    <input type="date" class="form-control" name='date1'>
  </div>
  <div class="form-group col">
    <label for="formGroupExampleInput">結束日期</label>
    <input type="date" class="form-control" name='date2'>
  </div>
  <!-- <div class="form-group col"> -->
    <button class="btn btn-primary" data-name="query" style="float:right; margin:30px;">查詢</button>   
    <!-- <fb:login-button scope="public_profile,email"  onlogin="checkLoginState();" id="FB_login" style="display:none;"></fb:login-button> -->
    <!-- <span ></span> -->
    <button class="btn btn-primary" id="FB_login" style="float:right; margin:30px; display:none;">FB登入</button>   
    <button class="btn btn-primary" id="FB_logout" style="float:right; margin:30px; display:none;">登出&nbsp;&nbsp;<span class="badge badge-light" data-name='welcome'></span></button>   
  <!-- </div> -->
</div>
  <div data-name='itemList' class="row">

  </div>
</body>
</html>
<script>
  $(function(){
    $("#FB_login").click(function() {
    // 進行登入程序
    FB.login(function(response) {
    statusChangeCallback(response);
    }, {
    scope: 'public_profile,email'
    });
    });

    var getList=function(date1,date2){
      $("div[data-name='loading']").show();//讀取畫面鎖定   
      $.ajax({
          url:"../backend/api/home/getdata1.php",
          method:"POST",
          data:{
            date1:date1,
            date2:date2,
            page:1
          },
          dataType: 'json',
          success :function(r){
              $("div[data-name='loading']").hide();//讀取畫面解除鎖定   
              console.log(r);
              
              var html="";
              if(r.count>0){

                for(var i=0; i<r.datas.length;i++){
                  
                var status="";
                
                if($.getSysdate()>=r.datas[i].date1 && $.getSysdate()<=r.datas[i].date2){
                  status="<span style='color:blue;'>集單中</span>";
                  }else if($.getSysdate()<r.datas[i].date1){
                    status="<span style='color:red;'>即將開始</span>";
                  }else if($.getSysdate()>r.datas[i].date2){
                    status="<span style='color:red;'>已結束</span>";
                  }
                  
                  html+='<div class="card col-4">';
                html+='<div style="width:100%; height:300px; background:url(../files/list/'+r.datas[i].img+');background-size: contain; background-repeat:no-repeat;  background-position: center;">';
                //  html+=  '<img src="../files/list/'+r.datas[i].img+'" class="card-img-top" alt="..." style="width:100%;object-fit: fill;">';
                html+='</div>';
                html+=  '<div class="card-body">';
                html+=    '<h5 class="card-title">'+r.datas[i].name1+'</h5>';
                html+=    '<p class="card-text">'+status+'</p>';
                html+=  '</div>';
                html+=    '<ul class="list-group list-group-flush">';
                html+=      '<li class="list-group-item">抽數單位: '+r.datas[i].unit1+'</li>';
                html+=      '<li class="list-group-item">單抽金額: '+r.datas[i].price1+'</li>';
                html+=      '<li class="list-group-item">'+r.datas[i].date1+'~'+r.datas[i].date2+'</li>';
                html+=    '</ul>';
                html+=    '<div class="card-body">';
                html+=      '<div style="float:right;">';
                // html+=      '<a href="#" class="card-link">Card link</a>';      
                html+=      '<button type="button"  class="btn btn-primary" data-name="viewItem" data-id="'+r.datas[i].systemId+'"><i class="fas fa-file-alt"></i></button>';      
                //  html+=      '<button type="button"  class="btn btn-primary" data-name="deleteItem" data-id="'+r.datas[i].systemId+'">刪除</button>';      
                html+=      '</div>';      
                html+=    '</div>';      
                html+=  '</div>';      
                
                
                }
              }else{
                html+="<div  style='color:red;'>沒有符合條件的商品</div>";
              }
              
              $("div[data-name='itemList']").html(html);
              
               //查看
               $("button[data-name='viewItem']").on("click",function(){
                var systemId=$(this).attr("data-id");
                if(login()=="y"){
                  window.location = 'https://figurelottery.com/?p=item&id='+systemId;
                }else{
                  alert('請先登入會員');
                  document.location.href="https://figurelottery.com/";
                  return false;
                }
              })
              //查看
          },
          error: function(){
            
          }
          
        })
      }
      $("input[name='date1']").val($.getSysdate(-90));
      $("input[name='date2']").val($.getSysdate());
      
      // var date1= $("input[name='date1']").val();
      // var date2= $("input[name='date2']").val();

      // getList(date1,date2);

      // 查詢按鈕
      $("button[data-name='query']").on("click",function(){
        var date1= $("input[name='date1']").val();
        var date2= $("input[name='date2']").val();
        getList(date1,date2);
      })
      // 查詢按鈕
      $("button[data-name='query']").click();

    })
</script>