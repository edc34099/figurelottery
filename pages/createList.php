<?php
// 建立抽獎
// 抽獎名稱
// 抽獎說明
// 開始日期
// 集單期限
// 單抽金額
// 抽數單位
// 品項->數目
// 最後賞(另抽)


include ("../backend/lib/lib.php");
echo "createlist2";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>建立抽獎</title>
</head>
<body>
<!-- <form> -->
<form data-name='item' onsubmit='return false;' enctype="multipart/form-data">
  <div class="form-row">
    <div class="col">
      <label for="exampleFormControlInput1">名稱</label>
      <input class="form-control" data-name='name1' data-group='data1' name='name1'>
    </div>
  </div>
  <div class="form-row">
    <div class="col">
      <label for="exampleFormControlInput1">開始日期</label>
      <input type='date' class="form-control" data-name='date1' data-group='data1' name='date1'>
    </div>
  

    <div class="col">
      <label for="exampleFormControlInput1">結束日期</label>
      <input type='date' class="form-control" data-name='date2' data-group='data1' name='date2'>
    </div>
  </div>
  <div class="form-row">
    <div class="col">
      <label for="exampleFormControlInput1">單抽金額</label>
      <input class="form-control" data-name='cpb1' data-group='data1' name='cpb1'>
    </div>

    <div class="col">
      <label for="exampleFormControlInput1">抽數單位</label>
      <input class="form-control" data-name='unit1' data-group='data1' name='unit1'>
    </div>
  </div>

  <div class="form-row">
    <div class="col">
      <label for="exampleFormControlTextarea1">說明</label>
      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" data-name='memo1' data-group='data1' name='memo1'></textarea>
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-3">
      <button  class="btn btn-primary" data-name='add'>加入獎項</button>
    </div>
  </div>
    

  <div class="row mt-1 mb-1">
    <div class="col-3">
      <div  class="btn btn-primary" >圖片</div>
    </div>
    <div class="col">
      <div  class="btn btn-primary" >文字</div>
    </div>
    <div class="col-3">
      <!-- <div  class="btn btn-primary" ></div> -->
    </div>
  </div>


 

  <div data-name='item'>
    <div class="form-row md-1 mt-1" data-group="data2">
      <div class="col-3">
        <!-- <label for="exampleFormControlFile1">Example file input</label> -->
        <input type="file" class="form-control-file" id="exampleFormControlFile1" data-name='file1' name='file1' data-group="data2">
      </div>
   
      <div class="col">
        <!-- <label for="exampleFormControlInput1">數量</label> -->
        <input class="form-control" data-name='unit1' name='unit1' data-group="data2">
      </div>

      <div class="col-3">
        <!-- <button  class="btn btn-primary" data-name='del'>刪除</button> -->
      </div>

    </div>
  </div>

  <button class="btn btn-primary" data-name='submit'>送出</button>

</form>


</body>
</html>


<script>
  $(function(){

    // 加入獎項
    if(1){

      $("button[data-name='add']").on("click",function(){
        // var count=$("div[data-name='item']>div").length;
        // console.log(count);
        var html='';
        // html+='<div data-name="item">';
        html+=  '<div class="form-row md-1 mt-1" data-group="data2">';
        html+=    '<div class="col-3">';
        html+=      '<input type="file" class="form-control-file" id="exampleFormControlFile1" data-name="file1" name="file1" data-group="data2">';
        html+=    '</div>';
        html+=    '<div class="col">';
        html+=      '<input class="form-control" data-name="unit1" name="unit1" data-group="data2">';
        html+=    '</div>';
        html+=    '<div class="col-3">'
        html+=      '<button  class="btn btn-primary" data-name="del">刪除</button>'
        html+=    '</div>'
        html+=  '</div>'
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
        
      var postData={
        "data1":  $("form[data-name='item']").find("*[data-group='data1']").serializeJSON(),
        "data2": []
      };

      for (var i = 2; i <= 2; i++) {
								for (var j = 0; j < $("form[data-name='item']").find("div[data-group='data" + i + "']").length; j++) {
                  postData["data" + i].push($("form[data-name='item']").find("div[data-group='data" + i + "']:eq(" + j + ")").find("*[data-group='data"+i+"']").serializeJSON());
								}
			}
      
     
      console.log(postData);
        $.ajax({
          url:"../backend/api/createListApi.php",
          method:"POST",
          data:postData,
          success:function(r){
            console.log(r);

                    // 上傳檔案
                    var fileForm=$("<form action='../backend/api/createListUpload.php' method='post' enctype='multipart/form-data'></form>");
										fileForm.append("<input type=\"hidden\" name=\"subdir\" value=\"s1_sclass04\" />");
										// fileForm.append("<input type=\"hidden\" name=\"recordKey\" value=\""+pObjThis.data("tresponse1").datas[0].systemId+"\" />");
										// fileForm.append("<input type=\"hidden\" name=\"systemId\" value=\""+pObjThis.data("tresponse1").datas[0].systemId+"\" />");
										// fileForm.append("<input type=\"hidden\" name=\"studentId1\" value=\""+pObjThis.find("select[data-id='sId']").val()+"\" />");
										///var formData = new FormData();
										///formData.append('subdir', "s1_student");
										goUpload=false;
										  $("form[data-name='item']").find("input[type='file']").each(function(i){
											if ($(this).val().length>0){
												goUpload=true;
												fileForm.append("<input type=\"hidden\" name=\"field"+i+"\" value=\""+$(this).parent().find("input[type='text']:eq(0)").attr("name")+"\" />");
												var pObjTempS1=$(this).clone();
												pObjTempS1.attr("name","uploads"+i);
												fileForm.append(pObjTempS1);
											}
                    });
                    if(goUpload){

                 
                      fileForm.ajaxSubmit({
												dataType:  'json',
												beforeSend: function() {
													///alert("開始上傳");
												},
												uploadProgress: function(event, position, total, percentComplete) {
													///alert("上傳進度");
												},
												success: function(data) {
													// alert("資料己經存檔!!, 請繼續作業");
													
												},
												error:function(xhr){
												
												}
                      });

                    }
          },
          error:function(r){
            console.log(r);
          }
        })
      })
    }
    // 送出

  })
</script>

