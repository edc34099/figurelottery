
// $(document).ready(function (){
  
//   $("[data-style='item']").on("click",function(){
//     var name=$(this).attr("data-name");
//     alert(name);
//   })


//   // 點擊建立抽獎
//   if(0){
//     $("a[data-name='createList']").on("click",function(){

//       $("div[data-name='main']").html("");
      
//       if(0){

//         var user='1';
//         $.ajax({
//           "url":"../backend/api/getList1.php",
//           method: 'POST',
//           data: {
//             user:user
//           },
//           dataType: 'json',
//           success: function (r) {
//             console.log(r);
//             // alert('123');
//             // var html='';
            
//             // for(var i=0;i<r.datas.length;i++){
//               //   html+=`<div class="card" style="width: 18rem;">
//             //      <img src="..." class="card-img-top" alt="...">
//             //      <div class="card-body">`;
//             //   html+=`<h5 class="card-title">`+r.datas[i].name1+`</h5>
//             //        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
//             //      </div>
//             //      <ul class="list-group list-group-flush">
//             //        <li class="list-group-item">Cras justo odio</li>
//             //        <li class="list-group-item">Dapibus ac facilisis in</li>
//             //        <li class="list-group-item">Vestibulum at eros</li>
//             //      </ul>
//             //      <div class="card-body">
//             //        <a href="#" class="card-link">Card link</a>
//             //        <a href="#" class="card-link">Another link</a>
//             //      </div>
//             //     </div>`;
//             // }
//             // $("div[data-name='main']").html(html);
            
//           },
//           error:function(){
//             alert('error');
//           }
          
//         })
//       }
      
//       })
//   }

//   // 點擊抽獎列表
//   if(0){
//         $("a[data-name='list']").on("click",function(){

//           $("div[data-name='main']").html("");
          
//              var user='1';
//             $.ajax({
// 							"url":"../backend/api/getList1.php",
// 							method: 'POST',
// 							data: {
// 								user:user
// 							},
// 							dataType: 'json',
// 							success: function (r) {
//                 console.log(r);
//                 // alert('123');
//                 var html='';

//                 for(var i=0;i<r.datas.length;i++){
//                   html+=`<div class="card" style="width: 18rem;">
//                      <img src="..." class="card-img-top" alt="...">
//                      <div class="card-body">`;
//                   html+=`<h5 class="card-title">`+r.datas[i].name1+`</h5>
//                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
//                      </div>
//                      <ul class="list-group list-group-flush">
//                        <li class="list-group-item">Cras justo odio</li>
//                        <li class="list-group-item">Dapibus ac facilisis in</li>
//                        <li class="list-group-item">Vestibulum at eros</li>
//                      </ul>
//                      <div class="card-body">
//                        <a href="#" class="card-link">Card link</a>
//                        <a href="#" class="card-link">Another link</a>
//                      </div>
//                     </div>`;
//                 }
//                 $("div[data-name='main']").html(html);
								
//               },
//               error:function(){
//                 alert('error');
//               }
              
//             })
//           })

//   }







//   });