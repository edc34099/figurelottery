<html>
<!-- 上方按鈕列 -->
<div class="">
<!-- 新增按鈕 -->
<div data-name='' class="row">
  <div class="form-group col">
    <label for="formGroupExampleInput">開始日期</label>
    <input type="date" class="form-control" name='date1' data-name='qdate1'>
  </div>
  <div class="form-group col">
    <label for="formGroupExampleInput">結束日期</label>
    <input type="date" class="form-control" name='date2' data-name='qdate2'>
  </div>
  <button class="btn btn-primary" data-name="query" style="float:right; margin:30px;">查詢</button>   
 
  <button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl" style="float:right; margin:30px;">新增</button>
</div>

<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content p-5">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">新增</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-name="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form data-name='item' onsubmit='return false;' enctype="multipart/form-data">
        <div class="form-row">
          <div class="col">
            <label for="exampleFormControlInput1">名稱</label>
            <input class="form-control" data-name='name1' data-group='data1' name='name1' data-required="1">
          </div>
        </div>
        <div class="form-row">
          <div class="col">
            <label for="exampleFormControlInput1">開始日期</label>
            <input type='date' class="form-control" data-name='date1' data-group='data1' name='date1' data-required="1">
          </div>
        

          <div class="col">
            <label for="exampleFormControlInput1">結束日期</label>
            <input type='date' class="form-control" data-name='date2' data-group='data1' name='date2' data-required="1">
          </div>
        </div>
        <div class="form-row">
          <div class="col">
            <label for="exampleFormControlInput1">單抽金額</label>
            <input class="form-control" data-name='price1' data-group='data1' name='price1' data-required="1">
          </div>

          <div class="col">
            <label for="exampleFormControlInput1">抽數單位</label>
            <input class="form-control" data-name='unit1' data-group='data1' name='unit1' data-required="1">
          </div>
        </div>
        <div class="form-row">
          <div class="col">
            <label for="exampleFormControlInput1">封面圖片</label>
            <input type="file" class="form-control" data-name='file2' data-group='data1' name='file2' data-required="1" draggable="true" accept="image/*">
          </div>

          <div class="col">
            <label for="exampleFormControlInput1">最後賞</label>
            <input class="form-control" data-name='last1' data-group='data1' name='last1' data-required="1">
          </div>
        </div>
        
        <div class="form-row">
          <div class="col-4">
            <label for="exampleFormControlInput1">圖片(多選)</label>
            <input type="file" class="form-control" data-name='file1' data-group='data1' name='file1' data-required="0" multiple="multiple" draggable="true" accept="image/*">
          </div>        
        </div>
        

        <div class="form-row">
          <div class="col">
            <label for="exampleFormControlTextarea1">說明</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" data-name='memo1' data-group='data1' name='memo1' data-required="1" ></textarea>
          </div>
        </div>

        <hr>

        <div class="row">
          <div class="col-3">
            <button  class="btn btn-primary" data-name='add'>加入獎項</button>
          </div>
        </div>
          

        <div class="row mt-1 mb-1">
          <!-- <div class="col-3">
            <div  class="btn btn-primary" >圖片</div>
          </div> -->
          <div class="col-3">
            <div  class="btn btn-primary" >文字</div>
          </div>
          <div class="col-3">
            <div  class="btn btn-primary" >數量</div>
          </div>
        </div>


      

        <div data-name='item'>
          <div class="form-row md-1 mt-1" data-group="data2">
            <!-- <div class="col-3">
              <input type="file" class="form-control-file" id="exampleFormControlFile1" data-name='file1' name='file1' data-group="data2">
            </div> -->
        
            <div class="col-3">
              <input class="form-control" data-name='name1' name='name1' data-group="data2" data-required="1">
            </div>

            <div class="col-3">
              <input class="form-control" data-name='num1' name='num1' data-group="data2" data-required="1">
              <!-- <button  class="btn btn-primary" data-name='del'>刪除</button> -->
            </div>

          </div>
        </div>

        <button class="btn btn-primary m-1" data-name='submit'>送出</button>
        <button type="reset" class="btn btn-primary m-1" data-name='submit'>重置</button>

      </form>

    </div>
  </div>
</div>



</div>

<!-- 下方商品列表 -->
<div data-name='itemList' class="row">
 
</div>


</html>

<script>
  $(function(){

    // 讀取自己上架的商品列表
    var getList=function(date1,date2){
      $("div[data-name='itemList']").html("");
      if(login()=="y"){
      
        $.ajax({
          url:"../backend/api/saleList/getdata1.php",
          method:"POST",
          data:{
            date1:date1,
            date2:date2,
            userId1:localStorage.getItem("userId")
          },
          dataType: 'json',
          success :function(r){
            console.log(r);
            
            var html="";
            for(var i=0; i<r.datas.length;i++){

              var status="";
              
              if($.getSysdate()>=r.datas[i].date1 && $.getSysdate()<=r.datas[i].date2){
                status="<span style='color:blue;'>集單中</span>";
               }else if($.getSysdate()<r.datas[i].date1){
                 status="<span style='color:red;'>即將開始</span>";
               }else if($.getSysdate()>r.datas[i].date2){
                 status="<span style='color:red;'>已結束</span>";
              }


              //  html+='<div class="col-4">';
               html+='<div class="card col-4">';
               html+='<div style="width:100%; height:300px; background:url(../files/list/'+r.datas[i].img+'); background-size: contain; background-repeat:no-repeat;  background-position: center;">';
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
               html+=     '<div style="float:right;">';
               html+=      '<button type="button"  class="btn btn-primary m-1" data-name="viewItem" data-id="'+r.datas[i].systemId+'"><i class="fas fa-file-alt"></i></button>';       
               html+=      '<button type="button"  class="btn btn-primary m-1" data-name="deleteItem" data-id="'+r.datas[i].systemId+'"><i class="far fa-trash-alt"></i></button>';      
               html+=     '</div>';      
               html+=    '</div>';      
               html+=  '</div>';      
              //  html+=  '</div>';      

              
            }

            $("div[data-name='itemList']").html(html);

            //刪除
            $("button[data-name='deleteItem']").on("click",function(){
                var msg="確定刪除這項商品嗎?";
                var systemId=$(this).attr("data-id");
                if(confirm(msg)==true){
                  $.ajax({
                    url:"../backend/api/saleList/delete1.php",
                    method:"POST",
                    data:{
                      userId1: localStorage.getItem("userId"),
                      systemId: systemId
                    },
                    dataType: 'json',
                    success :function(r){
                      $("button[data-name='query']").click();
                    }
                  })
                
                }else{
                  
                }
              })
              //刪除

              //查看
              $("button[data-name='viewItem']").on("click",function(){
                var systemId=$(this).attr("data-id");
                if(login()=="y"){
                  window.location = 'https://figurelottery.com/?p=itemOwner&id='+systemId;
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

      }else{
        alert('請先登入會員');
        document.location.href="https://figurelottery.com/";
      }
    }
    // 讀取自己上架的商品列表
    // getList();
    

    // 新增

    // 加入獎項
    if(1){

      $("button[data-name='add']").on("click",function(){
        // var count=$("div[data-name='item']>div").length;
        // console.log(count);
        var html='';
        // html+='<div data-name="item">';
        html+=  '<div class="form-row md-1 mt-1" data-group="data2">';
        // html+=    '<div class="col-3">';
        // html+=      '<input type="file" class="form-control-file" id="exampleFormControlFile1" data-name="file1" name="file1" data-group="data2">';
        // html+=    '</div>';
        html+=    '<div class="col-3">';
        html+=      '<input class="form-control" data-name="name1" name="name1" data-group="data2" data-required="1">';
        html+=    '</div>';
        html+=    '<div class="col-3">';
        html+=      '<input class="form-control" data-name="num1" name="num1" data-group="data2" data-required="1">';
        html+=    '</div>';
        html+=    '<div class="col-3">';
        html+=      '<button  class="btn btn-primary" data-name="del">刪除</button>';
        html+=    '</div>';
        html+=  '</div>';
        // html+='</div>'
        
        $("div[data-name='item']").append(html);       

        // 刪除按鈕
        $("button[data-name='del']").on("click",function(){
          $(this).parent("div").parent("div").remove();
        })
        // 刪除按鈕
      })

    }
    // 加入獎項


    // 送出
    if(1){

      $("button[data-name='submit']").on("click",function(){
      
      $("div[data-name='loading']").show();//讀取畫面鎖定


      // 檢查必填
      if(0){

        var submit=true;
        $("input[data-required='1']").each(function(i){        
          $(this).css("background","");
          if($(this).val() == null || $(this).val()==undefined || $(this).val()==""){
            $(this).css("background","#e2fcfd");
            submit= false;
          }else{
            // $(this).prev("span").remove();
          }
        })
        if(submit==false){
          alert('有欄位未填');
          $("div[data-name='loading']").hide();
          return false;
        }

      }
      // 檢查必填


      // 檢查抽數單位與抽數總數
      if(0){

        var submit=true;
        var unit1=$("input[name='unit1'][data-group='data1']").val();
        var num=0;
        $("input[data-group='data2'][name='num1']").each(function(){
          num+=parseInt($(this).val());
        })
       
        if(num%unit1!=0){
          submit=false;
        }
        if(submit==false){
          alert('抽數總數不是抽數單位的倍數');
          $("div[data-name='loading']").hide();
          return false;
        }
      }
      // 檢查抽數單位與抽數總數


       // 檢查抽數單位與抽數總數
      if(1){

        var submit=true;
        var date1=$("input[name='date1']").val();
        var date2=$("input[name='date2']").val();
        if(date2<date1){
          submit=false;
        }
        if(submit==false){
          alert('結束日期不得小於開始日期');
          $("div[data-name='loading']").hide();
          return false;
        }

      }
      // 檢查抽數單位與抽數總數


      // 檢查檔案上傳數及附檔名
      if(1){
        console.log($("input[data-name='file1']")[0].files.length);
        console.log($("input[data-name='file1']")[0].files);
        if($("input[data-name='file1']")[0].files.length>10){
          alert('最多上傳10張圖檔');
          $("div[data-name='loading']").hide();
          return false;
        }

        for(var i=0;i<$("input[data-name='file1']")[0].files.length;i++){
          if($("input[data-name='file1']")[0].files[i].name.split('.').pop()!='jpg'){
            alert('請上傳jpg檔');
            $("div[data-name='loading']").hide();
            return false;
          }
        }

        if($("input[data-name='file2']")[0].files[0].name.split('.').pop()!='jpg'){
            alert('請上傳jpg檔');
            $("div[data-name='loading']").hide();
            return false;
          }
        // alert($("input[data-name='file2']").val());
        // return false;
      }
      // 檢查檔案上傳數及附檔名


      var postData={
        "data1":  $("form[data-name='item']").find("*[data-group='data1']").serializeJSON(),
        "data2": [],
        "userId1":localStorage.getItem("userId")
      };

      for (var i = 2; i <= 2; i++) {
								for (var j = 0; j < $("form[data-name='item']").find("div[data-group='data" + i + "']").length; j++) {
                  postData["data" + i].push($("form[data-name='item']").find("div[data-group='data" + i + "']:eq(" + j + ")").find("*[data-group='data"+i+"']").serializeJSON());
								}
			}
      

      // $("div[data-name='loading']").hide();
        $.ajax({
          url:"../backend/api/saleList/insert1.php",
          method:"POST",
          data:postData,
          dataType:"json",
          success:function(r){
            console.log(r);

                  // 上傳檔案
                  if(r.error=="0" && ($("input[data-name='file1']").val()!='' || $("input[data-name='file2']").val()!='')){
                    alert('上傳');
                    var formData = new FormData(); 
                    formData.append('file[]',$("input[data-name='file2']")[0].files[0]);
                    for(var i=0;i<$("input[data-name='file1']")[0].files.length;i++){
                      formData.append('file[]',$("input[data-name='file1']")[0].files[i]);
                    }
                    formData.append("systemId",r.systemId);
                    formData.append("userId1",localStorage.getItem("userId"));
                    $.ajax({ 
                          type: 'post', 
                          url: "../backend/api/saleList/upload1.php", 
                          data: formData,
                          dataType:"json", 
                          cache: false, 
                          processData: false, 
                          contentType: false, 
                          success:function (data) { 
                          // alert(data); 
                          $("div[data-name='loading']").hide();
                          $("button[data-name='close']").click();                          
                          $("button[data-name='query']").click();
                          },
                          error:function () { 
                          alert("上傳失敗"); 
                          }
                    })

                  }else if(r.error=="0"){
                  $("div[data-name='loading']").hide();
                  $("button[data-name='close']").click();                  
                  $("button[data-name='query']").click();
                  }
          },
          error:function(r){
            console.log(r);
          }
        })
      })
    }
    // 送出

    // 新增


      $("input[data-name='qdate1']").val($.getSysdate(-90));
      $("input[data-name='qdate2']").val($.getSysdate());
      
      

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