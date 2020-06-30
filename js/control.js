if(1){//FB登入SDK
  window.fbAsyncInit = function() {
    FB.init({
    appId: '215694669310338', // 填入 FB APP ID
    cookie: true,
    xfbml: true,
    version: 'v3.2'
    });
    
    FB.getLoginStatus(function(response) {
    statusChangeCallback(response);   
    console.log(localStorage);
    // location.reload();
    });
    };

  
    
    // 處理各種登入身份
    function statusChangeCallback(response) {
      
    // console.log(response);
    // var target = document.getElementById("FB_STATUS_1"),
    html = "";
    $("span[data-name='welcome']").html("");
    // 登入 FB 且已加入會員
    if (response.status === 'connected') {
    html = "已登入 FB，並加入 WFU BLOG DEMO 應用程式<br/>";
    
    FB.api('/me?fields=id,name,email', function(response) {
    console.log(response);
   
    // html += "會員暱稱：" + response.name + "<br/>";
    // html += "會員 email：" + response.email;
    // target.innerHTML = html;
    // console.log(response);
    // return response;
    localStorage.setItem("userName",response.name);
    localStorage.setItem("userMail",response.email);
    localStorage.setItem("userId",response.id);    
    
    //建立會員資料庫 
    $.ajax({
      url:"../backend/api/login/insert1.php",
      method:"POST",
      data:{
        userId1:response.id,
        email1:response.email,
        name1:response.name
        
      },
      dataType: 'json',
      success :function(r){
        console.log(r);
        html = "Hi, " + r.datas[0].name1 ;
        $("span[data-name='welcome']").html(html)
      },
      error: function(r){
        console.log(r);
      }
    })
    //建立會員資料庫

    if(localStorage.getItem("userId")!= null && localStorage.getItem("userId")!= undefined && localStorage.getItem("userId")!= "" && localStorage.getItem("userId")>0){

      $("#FB_logout").show();
      $("#FB_login").hide();
      $("#FB_logout").click(function() {
        FB.logout(function(response) {
        statusChangeCallback(response);
        $("#FB_login").show();
        $("#FB_logout").hide();
        localStorage.setItem("userName","");
        localStorage.setItem("userMail","");
        localStorage.setItem("userId","");
        });
        
        location.reload();//重整頁面讓沒登入時不該看的功能關閉
        });

    }
    
   
  });
}

// 登入 FB, 未偵測到加入會員
    else if (response.status === "not_authorized") {
      // target.innerHTML = "已登入 FB，但未加入 WFU BLOG DEMO 應用程式";
    
      
      if(localStorage.getItem("userId")!= null && localStorage.getItem("userId")!= undefined && localStorage.getItem("userId")!= "" && localStorage.getItem("userId")>0){
        $("#FB_login").hide();
        $("#FB_logout").show();
        $("#FB_logout").click(function() {

          FB.logout(function(response) {
          statusChangeCallback(response);
          $("#FB_login").show();
          $("#FB_logout").hide();
          localStorage.setItem("userName","");
          localStorage.setItem("userMail","");
          localStorage.setItem("userId","");
          });

          
          });
      
      }
    }

// 未登入 FB
    else {
     
      // target.innerHTML = "未登入 FB";
      
      if(localStorage.getItem("userId")!= null || localStorage.getItem("userId")!= undefined || localStorage.getItem("userId")!= "" ){
             
          $("#FB_login").show();
          $("#FB_logout").hide();
          localStorage.setItem("userName","");
          localStorage.setItem("userMail","");
          localStorage.setItem("userId","");
      
      }
    }

    // console.log(localStorage);
    }
    
    function checkLoginState() {         
    FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
    });     
    }
    
    // 載入 FB SDK
    (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "https://connect.facebook.net/zh_TW/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    

}//FB登入SDK


// 登入狀態
var login=function(){
  if(localStorage.getItem("userId")!= null && localStorage.getItem("userId")!= undefined && localStorage.getItem("userId")!= "" && localStorage.getItem("userId")>0){
    return "y";
  }else{
    return "n";
  }
}
// 登入狀態

// 當前日期 丟入參數+-幾天
$.getSysdate=function(days) {
  if(days == null || days==undefined || days=='') 
  {days=0;}
  var dateTime=new Date();
  dateTime=dateTime.setDate(dateTime.getDate()+days);
  dateTime=new Date(dateTime);
  var lxp_dd = dateTime.getDate();
  var lxp_mm = dateTime.getMonth()+1; //January is 0!
  var lxp_yyyy = dateTime.getFullYear();		
  var lxp_return=lxp_yyyy+'-'+(lxp_mm<10 ? "0"+lxp_mm : lxp_mm)+'-'+(lxp_dd<10 ? "0"+lxp_dd : lxp_dd);
  return(lxp_return);
}
// 當前日期 丟入參數+-幾天




