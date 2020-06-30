<html></html>

<!-- 上半部  輪播+商品內容 -->
<div class="row">
  <div  class="row col-6 m-1">
  
      <div id="carouselExampleIndicators2" class="carousel slide carousel-fade" data-ride="carousel" style="height:400px; width:100%; ">
        <ol class="carousel-indicators" data-name='imgOl'>
        
        </ol>
        <div data-name='imgZone'>
         
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button" data-slide="prev" '>
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next" '>
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>      

  </div>
    
  <div class='row col-6'>
 
    <div data-name='itemDetail'>

    </div>   
    <table class="table table-striped table-bordered " id="RWD">  
      <thead>
        <tr>
          <th>名稱</th>
          <th>數量</th>
          <th>機率</th>
        </tr>
      </thead>
      <tbody data-name='itemList'>
       
      </tbody>
    </table>
   
  </div>
  
</div>
<!-- 上半部  輪播+商品內容 -->

<!-- 下半部 購買清單 -->
<div class="p-5 row" >
<button data-name='goRand' class='btn  btn-primary m-2 ' style='display:none;'>抽獎</button>
<button data-name='save1' class='btn  btn-primary m-2 ' style='display:none;'>儲存</button>
<table id="RWD2">
  <thead>
    <tr>
      <th></th>
      <th>姓名</th>
      <th>抽數</th>
      <th>得獎項目</th>
      <th>訂單編號</th>
      <th>物流單號</th>
    </tr>
  </thead>
  <tbody data-name='bought'>

  </tbody>
</table>
<!-- <h1> <span class="badge badge-danger">最後賞</span>
          <span data-name='lastName1'></span>
          <span data-name='lastName2'></span>
</h1> -->
</div>
<!-- 下半部 購買清單 -->

</html>

<script>
  $(function(){
    var getUrlString = location.href;
    var url = new URL(getUrlString);
    var relaId1=url.searchParams.get('id');
    var date1="";
    var date2="";
    var sum="";//商品總抽數
    var unit="";//商品抽數單位

   
    // 讀取自己上架的商品列表
    var getList=function(){
      $("ol[data-name='imgOl']").html("");
      $("div[data-name='imgZone']").html("");
      $("div[data-name='itemDetail']").html("");
      if(login()=="y"){
       

        var id=""
        id=url.searchParams.get('id');
        $.ajax({
          url:"../backend/api/item/getdata1.php",
          method:"POST",
          data:{
            userId1:localStorage.getItem("userId"),
            id: id
          },
          dataType: 'json',
          success :function(r){
            console.log(r);
            // return false;
            

            if(localStorage.getItem("userId")!=r.datas[0].userId1){
              alert('你不是商品擁有者');
              document.location.href="https://figurelottery.com/";
            }
            date1=r.datas[0].date1;
            date2=r.datas[0].date2;
            unit=r.datas[0].unit1;
            sum=r.datas2[0].sum;
            

            // 處理圖片
            var html="";
            var html2="";
            for(var i=0; i<r.datas3.length;i++){
              var active=(i==0)?"active":"";
              html+='<li data-target="#carouselExampleIndicators2" data-slide-to="'+i+'" class="'+active+'"></li>';
              
              html2+= '<div class="carousel-item  rounded '+active+'"';
              html2+=  'style="background:url(../files/list/'+r.datas3[i].img1+'); height: 400px; background-repeat:no-repeat; background-position: center center; background-size: contain; transition:0.5S; border:solid 2px 	#C4E1E1;" >';
              html2+= '</div>';
                       
            }
            

            $("ol[data-name='imgOl']").html(html);
            $("div[data-name='imgZone']").html(html2);
            // 處理圖片

            //處理品項
            var html="";
            var num=0;
            
            for(var i=0; i<r.datas2.length;i++){
              html+=' <tr><td>'+r.datas2[i].name1+'</td><td>'+r.datas2[i].num1+'</td><td>'+Math.round(r.datas2[i].num1/r.datas2[i].sum*10000)/100+'%</td></tr>';
            }

            html+=' <tr><td>最後賞</td><td>'+r.datas[0].last1+'</td><td></td></tr>';

            $("tbody[data-name='itemList']").html(html);
            //處理品項

            // 處理商品主表資訊
            var html="";
            
            html+=' <h3>'+r.datas[0].name1+'</h3>';
            html+=' <p>單抽價格：　'+r.datas[0].price1+'</p>';           
            html+=' <p>抽數單位：　'+r.datas[0].unit1+'</p>';
            html+=' <p>集單日期：　'+r.datas[0].date1+'~'+r.datas[0].date2+'</p>';
            html+=' <p>說明：</p><p>'+r.datas[0].memo1+'</p>';
           
            

            $("div[data-name='itemDetail']").html(html);
            // 處理商品主表資訊


            // 處理購買清單
            
            var html="";
            var replaceName=function(name){
              var num=name.length;
              var a="";
              for(var i=0;i<(num-2);i++){
                a+="O";
              }
              var n=name.substr(0,1)+a+name.substr(-1,1);
              return n;
            }
            for(var i=0;i<r.datas4.length;i++){
              var name=replaceName(r.datas4[i].uName);
              html+='<tr><td>'+(i+1)+'</td>';
              html+='<td>'+name+'</td>';
              html+='<td>'+r.datas4[i].num1+'</td>';

              var item="";
              for(var j=0;j<r.datas5[i].item.length;j++){
               
                if(r.datas5[i].item[j].iName!=""){
                  item+="<p>"+(j+1)+". "+r.datas5[i].item[j].iName+"</p>";
                }
                
              }
              if(r.datas5[i].item[0].lastName!=""){
                item+="<p><span class='badge badge-danger'>最後賞</span> "+r.datas5[i].item[0].lastName+"</p>";
              }
              html+='<td>'+item+'</td>';
              html+='<td>'+r.datas4[i].systemId+'</td>';
              html+='<td><input type="text" data-name="delivery1" data-sId="'+r.datas4[i].systemId+'" value="'+r.datas4[i].delivery1+'"></td>';
              html+='</tr>';
            }
            $("tbody[data-name='bought']").html(html);

            // $("span[data-name='lastName1']").html(r.datas[0].last1+"<br> ❱❱❱ ");
            // $("span[data-name='lastName2']").html(replaceName(r.datas[0].lastName2));
            // 處理購買清單
            $("#RWD").basictable();
            $("#RWD2").basictable();


              
           
            
          

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
    getList();
    

   

    
  
    if(1){
    // if(visitor==localStorage.getItem("userId")){
              
              // 擁有者
              // 抽獎
              if(1){
                    $("button[data-name='goRand']").show();
                    $("button[data-name='goRand']").on("click",function(){
                      // $("div[data-name='loading']").show(); 
                      $.ajax({
                              url:"../backend/api/itemOwner/goRand1.php",
                              method:"POST",
                              data:{
                                userId1:localStorage.getItem("userId"),                  
                                relaId1:relaId1              
                              },
                              dataType:"json",
                              async:false,
                              success:function(r){
                                if(r.error!="0"){
                                  alert(r.error);
                                  $("div[data-name='loading']").hide();                     
                                  getList();
                                }else{
                                  console.log(r);
                                  $("div[data-name='loading']").hide();       
                                  getList();
                                }
                                
                              },
                              error:function(r){
                                console.log(r);
                              }
                            })

                    })
                  }
                  // 抽獎

                  // 儲存
                  if(1){
                    $("button[data-name='save1']").show();
                    $("button[data-name='save1']").on("click",function(){

                      var delivery1="";
                      var sId="";
                      $("input[data-name='delivery1']").each(function(i){

                        if(i==0){
                          // delivery1+="'"+$(this).val()+"'";
                          delivery1+=$(this).val();
                          sId+=$(this).attr("data-sId");
                        }else{
                          delivery1+=','+$(this).val();
                          // delivery1+=','+"'"+$(this).val()+"'";
                          sId+=','+$(this).attr("data-sId");
                        }

                      })

                      $.ajax({
                              url:"../backend/api/itemOwner/update1.php",
                              method:"POST",
                              data:{
                                userId1:localStorage.getItem("userId"),
                                relaId1:relaId1,
                                sId:sId,
                                delivery1:delivery1
                              },
                              dataType:"json",
                              async:false,
                              success:function(r){
                                if(r.error!="0"){
                                  alert(r.error);
                                  $("div[data-name='loading']").hide();                     
                                  getList();
                                }else{
                                  console.log(r);
                                  alert('儲存成功');
                                  $("div[data-name='loading']").hide();       
                                  getList();
                                }
                                
                              },
                              error:function(r){
                                console.log(r);
                              }
                            })

                                        })
                  }
                  // 儲存
                  
                  
                  // 擁有者
            }else{

              // 訪客
              $("button[data-name='goRand']").hide();
              $("button[data-name='save1']").hide();
              // 訪客

            }


    


    

  })
</script>