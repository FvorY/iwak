<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <link rel="shortcut icon" href="{{asset('assets/iwak.jpeg')}}">
    <title>Chat</title>

    <style media="screen">
    * {
      margin: 0;
      padding: 0;
      border: 0;
      box-sizing: border-box;
      font: 16px sans-serif;
      }

      :focus {
      outline: 0;
      }

      a {
      text-decoration: none;
      }

      body {
      background: #F4F7F9;
      }

      html, body {
      height: 100% !important;
      }

      .container {
      display: flex;
      height: 100% !important;
      }

      sidebar {
      width: 300px;
      min-width: 300px;
      display: flex;
      background: #fff;
      flex-direction: column;
      border-right: 1px solid #ccc;
      transition: 500ms all;
      }
      sidebar .logo {
      display: flex;
      margin: 10px 0 0 0;
      padding-bottom: 10px;
      align-items: center;
      justify-content: center;
      color: #000;
      font-size: 3em;
      letter-spacing: 7px;
      border-bottom: 1px solid #ccc;
      }
      sidebar .list-wrap {
      width: 100%;
      overflow: auto;
      }
      sidebar .list-wrap .list {
      border-bottom: 1px solid #ccc;
      background: #fff;
      display: flex;
      align-items: center;
      padding: 5px;
      height: 70px;
      cursor: pointer;
      }
      sidebar .list-wrap .list:hover, sidebar .list-wrap .list.active {
      background: #F4F7F9;
      }
      sidebar .list-wrap .list img {
      border-radius: 50%;
      width: 50px;
      height: 50px;
      object-fit: cover;
      margin-right: 10px;
      box-shadow: 1px 2px 3px rgba(0, 0, 0, 0.5);
      }
      sidebar .list-wrap .list .info {
      flex: 1;
      }
      sidebar .list-wrap .list .info .user {
      font-weight: 700;
      }
      sidebar .list-wrap .list .info .text {
      display: flex;
      margin-top: 3px;
      font-size: 0.85em;
      }
      sidebar .list-wrap .list .time {
      margin-right: 5px;
      margin-left: 5px;
      font-size: 0.75em;
      color: #a9a9a9;
      }
      sidebar .list-wrap .list .count {
      font-size: 0.75em;
      background: #bde2f7;
      box-shadow: 0 5px 15px -5px rgba(0, 0, 0, 0.7);
      padding: 3px;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      text-align: center;
      color: #000;
      }

      .content {
      flex: 1;
      display: flex;
      flex-direction: column;
      }
      .content header {
      height: 76px;
      background: #fff;
      border-bottom: 1px solid #ccc;
      display: flex;
      padding: 10px;
      align-items: center;
      }
      .content header img {
      border-radius: 50%;
      width: 50px;
      height: 50px;
      object-fit: cover;
      margin-right: 10px;
      box-shadow: 1px 2px 3px rgba(0, 0, 0, 0.5);
      }
      .content header .info {
      flex: 1;
      }
      .content header .info .user {
      font-weight: 700;
      }
      .content header .info .time {
      display: flex;
      margin-top: 3px;
      font-size: 0.85em;
      }
      .content header .open {
      display: none;
      }
      .content header .open a {
      color: #000;
      letter-spacing: 3px;
      }

      .message-wrap {
      flex: 1;
      display: flex;
      flex-direction: column;
      padding: 15px;
      overflow: auto;
      }
      .message-wrap::before {
      content: "";
      margin-bottom: auto;
      }
      .message-wrap .message-list {
      align-self: flex-start;
      max-width: 70%;
      margin-bottom: 20px;
      }
      .message-wrap .message-list.me {
      align-self: flex-end;
      }
      .message-wrap .message-list.me .msg {
      background: #bde2f7;
      color: #111;
      }
      .message-wrap .message-list .msg {
      background: #fff;
      box-shadow: 0 5px 15px -5px rgba(0, 0, 0, 0.1);
      padding: 10px 5px;
      margin-bottom: 10px;
      border-radius: 5px;
      }
      .message-wrap .message-list .time {
      text-align: right;
      color: #999;
      font-size: 0.75em;
      }

      .message-footer {
      border-top: 1px solid #ddd;
      background: #eee;
      padding: 10px;
      display: flex;
      height: 60px;
      }
      .message-footer input {
      flex: 1;
      padding: 0 20px;
      border-radius: 5px;
      }

      @media only screen and (max-width: 480px), only screen and (max-width: 767px) {
      sidebar {
        position: absolute;
        width: 100%;
        min-width: 100%;
        height: 0vh;
        bottom: 0;
        box-shadow: 0 5px 25px -5px black;
      }
      sidebar.opened {
        height: 70vh !important;
      }
      sidebar .logo {
        display: none;
      }
      sidebar .list-wrap .list .count {
        font-size: 0.75em;
      }

      header .open {
        display: block !important;
      }
      }
    </style>

    <link rel="stylesheet" href="{{asset('assets/node_modules/font-awesome/css/font-awesome.min.css')}}" />
  </head>
  <body>


    <div class="container">
      <sidebar>
       <span class="logo">CHAT</span>
        <div class="list-wrap" id="listroom">
        </div>
      </sidebar>
      <div class="content">
        <header>
          <img src="" alt="">
          <div class="info">
            <span class="user"></span>
            <span class="time"></span>
          </div>
          <div class="open">
            <a href="javascript:;">UP</a>
          </div>
        </header>
        <div class="message-wrap" id="listchat">

        </div>
        <div class="message-footer">
          <input type="file" class="form-control form-control-sm uploadGambar" id="fileInput" name="image" accept="image/*" style="display:none;">
          <button type="button" name="button" style="background-color: grey; width:40px; color:white; border-radius: 10px;" onclick="document.getElementById('fileInput').click();"> <span class="fa fa-picture-o"></span> </button>
          <input type="text" data-placeholder="Send a message to {0}" id="placeholder" />
          <button type="button" name="button" onclick="sendmessage()" style="background-color: green; width:40px; color:white; border-radius: 10px;"> <span class="fa fa-send"></span> </button>
        </div>
      </div>
    </div>

    <script src="{{asset('assets/js/jquery.js')}}"></script>
    <script type="text/javascript">

        var idselect = 0;
        var penerima = "";

        roomchat();

        setInterval(function(){

          roomchat();

        }, 5000);

        function roomchat() {
          var html = "";

          $.ajax({
    				url: "{{url('/')}}" + "/listroom",
    				success: function(data) {
              console.log(data);

              if (data.length != 0) {
                for (var i = 0; i < data.length; i++) {
                  let res = data[i]

                  if (res.counter > 0) {
                    if res.account.profile_picture != null {
                      html += '<div class="list">'+
                        '<img src="{{url('/')}}/'+res.account.profile_picture+'" />'+
                        '<div class="info">'+
                          '<span class="user">'+res.account.fullname+'</span>'+
                          '<span class="text">'+res.last_message+'</span>'+
                        '</div>'+
                        '<span class="count">'+res.counter+'</span>'+
                        '<span class="time">'+res.created_at+'</span>'+
                        '<input type="hidden" class="iduser" name="id" value="'+res.id_roomchat+'">'+
                        '</div>';
                    } else {
                      html += '<div class="list">'+
                        '<img src="{{url('/')}}/'+res.account.profile_toko+'" />'+
                        '<div class="info">'+
                          '<span class="user">'+res.account.fullname+'</span>'+
                          '<span class="text">'+res.last_message+'</span>'+
                        '</div>'+
                        '<span class="count">'+res.counter+'</span>'+
                        '<span class="time">'+res.created_at+'</span>'+
                        '<input type="hidden" class="iduser" name="id" value="'+res.id_roomchat+'">'+
                        '</div>';
                    }
                  } else {
                    if res.account.profile_picture != null {
                      html += '<div class="list">'+
                        '<img src="{{url('/')}}/'+res.account.profile_picture+'" />'+
                        '<div class="info">'+
                          '<span class="user">'+res.account.fullname+'</span>'+
                          '<span class="text">'+res.last_message+'</span>'+
                        '</div>'+
                        '<span class="time">'+res.created_at+'</span>'+
                        '<input type="hidden" class="iduser" name="id" value="'+res.id_roomchat+'">'+
                        '</div>';
                    } else {
                      html += '<div class="list">'+
                        '<img src="{{url('/')}}/'+res.account.profile_toko+'" />'+
                        '<div class="info">'+
                          '<span class="user">'+res.account.fullname+'</span>'+
                          '<span class="text">'+res.last_message+'</span>'+
                        '</div>'+
                        '<span class="time">'+res.created_at+'</span>'+
                        '<input type="hidden" class="iduser" name="id" value="'+res.id_roomchat+'">'+
                        '</div>';
                    }

                  }
                }


                idselect = data[0].id_roomchat;

                listchat();

                $('#listroom').html(html);

                const ls = localStorage.getItem("selected");
                let selected = false;
                var list = document.querySelectorAll(".list"),
                  content = document.querySelector(".content"),
                  input = document.querySelector(".message-footer input"),
                  open = document.querySelector(".open a");

                //init
                function init() {
                //input.focus();
                let now = 2;
                const texts = ["İyi akşamlar", "Merhaba, nasılsın?",
                              "Harikasın! :)", "Günaydın", "Tünaydın",
                              "Hahaha", "Öğlen görüşelim.", "Pekala"];
                for(var i = 4; i < list.length; i++) {
                  list[i].querySelector(".time").innerText = `${now} day ago`;
                  list[i].querySelector(".text").innerText = texts[(i-4) < texts.length ? (i-4) : Math.floor(Math.random() * texts.length)];
                  now++;
                }
                }
                init();

                //process
                function process() {
                if(ls != null) {
                  selected = true;
                  click(list[ls], ls);
                }
                if(!selected) {
                  click(list[0], 0);
                }

                list.forEach((l,i) => {
                  l.addEventListener("click", function() {
                    click(l, i);
                  });
                });

                try {
                  document.querySelector(".list.active").scrollIntoView(true);
                }
                catch {}

                }
                process();

                //list click
                function click(l, index) {
                list.forEach(x => { x.classList.remove("active"); });
                if(l) {
                  l.classList.add("active");
                  document.querySelector("sidebar").classList.remove("opened");
                  open.innerText="UP";
                  const img = l.querySelector("img").src,
                        user = l.querySelector(".user").innerText,
                        time = l.querySelector(".time").innerText;
                        id = l.querySelector(".iduser").value;

                  content.querySelector("img").src = img;
                  content.querySelector(".info .user").innerHTML = user;
                  content.querySelector(".info .time").innerHTML = time;

                  const inputPH = $('#placeholder').data('placeholder');
                  // input.placeholder = inputPH.replace("{0}", user.split(' ')[0]);
                  $('#placeholder').attr('placeholder', inputPH.replace("{0}", user.split(' ')[0]));

                  document.querySelector(".message-wrap").scrollTop = document.querySelector(".message-wrap").scrollHeight;

                  idselect = id;

                  listchat(idselect);

                  $('#listchat').scrollTop($('#listchat')[0].scrollHeight);

                  localStorage.setItem("selected", index);
                }
                }

                open.addEventListener("click", (e) => {
                const sidebar = document.querySelector("sidebar");
                sidebar.classList.toggle("opened");
                if(sidebar.classList.value == 'opened')
                  e.target.innerText = "DOWN";
                else
                  e.target.innerText = "UP";
                });
              }

    				}
    			});
        }

        function listchat() {
          var html = "";

          $.ajax({
    				url: "{{url('/')}}" + "/listchat",
            data: {id: idselect},
    				success: function(data) {

              for (var i = 0; i < data.length; i++) {
                let res = data[i]
                let arraccount = res.account.split("-");

                if (arraccount[0] == "{{Auth::user()->id_account}}") {
                  penerima = arraccount[1];
                  if (res.photourl != null) {
                    html += '<div class="message-list me">'+
                              '<div class="msg">'+
                                  '<p>'+
                                  '<a href="{{url('/')}}/'+res.photourl+'" target="_blank"> <img src="{{url('/')}}/'+res.photourl+'" style="width:150px; height:150px;"> </a>'+
                                  '</p>'+
                              '</div>'+
                              '<div class="time">'+res.created_at+'</div>'+
                            '</div>';
                  } else {
                    html += '<div class="message-list me">'+
                              '<div class="msg">'+
                                  '<p>'+
                                  res.message +
                                  '</p>'+
                              '</div>'+
                              '<div class="time">'+res.created_at+'</div>'+
                            '</div>';
                  }
                } else {
                  penerima = arraccount[0];
                  if (res.photourl != null) {
                    html += '<div class="message-list">'+
                              '<div class="msg">'+
                                  '<p>'+
                                  '<a href="{{url('/')}}/'+res.photourl+'" target="_blank"> <img src="{{url('/')}}/'+res.photourl+'" style="width:150px; height:150px;"> </a>'+
                                  '</p>'+
                              '</div>'+
                              '<div class="time">'+res.created_at+'</div>'+
                            '</div>';
                  } else {
                    html += '<div class="message-list">'+
                              '<div class="msg">'+
                                  '<p>'+
                                  res.message +
                                  '</p>'+
                              '</div>'+
                              '<div class="time">'+res.created_at+'</div>'+
                            '</div>';
                  }
                }
              }

              $('#listchat').scrollTop($('#listchat')[0].scrollHeight);

              $('#listchat').html(html);

            }
          });
        }

        function sendmessage() {
          let message = $('#placeholder').val();

          $.ajax({
    				url: "{{url('/')}}" + "/sendchat",
            data: {id: idselect, message: message, penerima: penerima},
    				success: function(data) {
              $('#placeholder').val('');
              listchat();
            }
          });
        }

        $(".uploadGambar").on('change', function () {
          let message = $('#placeholder').val();

          var formdata = new FormData();
          formdata.append('image', $('.uploadGambar')[0].files[0]);
          formdata.append('id', idselect);
          formdata.append('message', message);
          formdata.append('penerima', penerima);

          $.ajax({
            type: "post",
            url: "{{url('/')}}" + '/sendimgchat?_token='+"{{csrf_token()}}",
            data: formdata,
            processData: false, //important
            contentType: false,
            cache: false,
            success:function(data){
              $('#placeholder').val('');
              listchat();
            }
          });
        });
    </script>
  </body>
</html>
