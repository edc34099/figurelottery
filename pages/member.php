<html>

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
   
  <button class="btn btn-primary" data-name='addValue' style="float:right; margin:30px;">購買代幣&nbsp;&nbsp;<span class="badge badge-light" data-name='welcome'></span></button>
 
</div>

<!-- 上半部  輪播+商品內容 -->
<div class="row">
   
  <div class='row col'> 

  <div class="row"><h3><span class="badge badge-secondary">購買記錄</span></h3></div>
    <table id="RWD">
      <thead>
        <tr>
          <th></th>
          <th>交易代碼</th>
          <th>狀態</th>
          <th>金額</th>
          <th>訂單編號</th>
          <th>交易時間</th>
        </tr>
      </thead>
      <tbody data-name='bought'>

      </tbody>
    </table>

   

  </div>
  
</div>
<!-- 上半部  輪播+商品內容 -->

<!-- 下半部 購買清單 -->
<div class="row" >
  <div class="row  mt-5 mb-3 "><h3><span class="badge badge-secondary">訂單記錄</span></h3></div>
      <div data-name='bought' class='col-12'>
    
      </div>
</div>
<!-- 下半部 購買清單 -->

</html>

<script>
  $(function(){
    $("span[data-name='welcome']").html("Hi,"+localStorage.getItem("userName"));
  
   
    // 讀取自己上架的商品列表
    var getList=function(){
    
      if(login()=="y"){
       
         $.ajax({
          url:"../backend/api/member/getdata1.php",
          method:"POST",
          data:{
            userId1:localStorage.getItem("userId")           
          },
          dataType: 'json',
          success :function(r){
            console.log(r);
            // return false;

            var html="";
            var type1="";
            if(r.add){

              for(var i=0;i<r.add.length;i++){
                type1=(r.add[i].type1==0)?'購買代幣':'消耗代幣';
                html+="<tr>";
                html+="<td>"+(i+1)+"</td>";
                html+="<td>"+r.add[i].systemId+"</td>";
                html+="<td>"+type1+"</td>";
                html+="<td>"+r.add[i].price+"</td>";
                html+="<td>"+r.add[i].relaId1+"</td>";
                html+="<td>"+r.add[i].createDatetime+"</td>";
                html+="</tr>";
                // html+="<table><tr><td>1</td><td>1</td><td>1</td><td>1</td></tr></table>";              
              }

            }
            $("tbody[data-name='bought']").html(html);
            $("#RWD").basictable();

            var html="";
            for(var i=0;i<r.datas.length;i++){
              html+='<div class="media m-1" style=" border:solid 2px 	#C4E1E1;">';
              // html+=  '<img src="../files/list/'+r.datas[i].img+'" class="mr-3" style="width:160px;height:90px;">';
              html+=  '<div style="background:url(../files/list/'+r.datas[i].img+'); height: 240px; width:135px; background-repeat:no-repeat; background-position: center center; background-size: contain; transition:0.5S;" class="mr-3" alt="..."></div>';
              html+=  '<div class="media-body">';
              html+=  '<h5 class="mt-0">'+(i+1)+'. '+r.datas[i].lName+'</h5>';
              html+=  '<div class="row col">訂單編號: '+r.datas[i].systemId+'</div>';
              html+=  '<div class="row col">物流單號: '+r.datas[i].delivery1+'</div>';
              html+=  '<div class="row"><div class="col">抽數: '+r.datas[i].num1+'</div><div class="col">金額: $'+r.datas[i].price+'</div><div class="col">購買時間: '+r.datas[i].createDatetime+'</div></div>';
              html+=  '<div class="media mt-3">';
              // html+=    '<a class="mr-3" href="#">';
              // html+=    '<img src="..." class="mr-3" alt="...">';
              // html+=    '</a>';
              html+=    '<div class="media-body">';
              html+=      '<h5 class="mt-0 badge badge-info">得獎內容</h5><br>';
              var item="";
              for(var j=0;j<r.datas2[i].item.length;j++){

                if(r.datas2[i].item[j].iName!=""){
                  item+="<p>"+(j+1)+". "+r.datas2[i].item[j].iName+"</p>";
                }

              }
              if(r.datas2[i].item[0].lastName!=""){
                item+="<p><span class='badge badge-danger'>最後賞</span> "+r.datas2[i].item[0].lastName+"</p>";
              }

              html+=     item;
              html+=    '</div>';
              html+=  '</div>';
              html+=  '</div>';
              html+='</div>';  
            }
            $("div[data-name='bought']").html(html);
            
            
          

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

   
     
    
    

  
    

    


    

  })
</script>