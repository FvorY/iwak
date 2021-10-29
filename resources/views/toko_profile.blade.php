@extends('layouts.homepage.app_home')

@section('content')

@include('modal_sendchat')

  <style media="screen">
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;700&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      align-items: center;
      justify-content: center;
      background-color: #ADE5F9;
      min-height: 100vh;
    }
    img {
      max-width: 100%;
      display: block;
    }
    ul {
      list-style: none;
    }

    /* Utilities */
    .card::after,
    .card img {
      border-radius: 50%;
    }
    body,
    .card,
    .stats {
      display: flex;
    }

    .card {
      margin: auto;
      margin-top: 20px;
      margin-bottom: 20px;
      /* margin-left: 20px;
      margin-right: 20px; */
      /* width: 50%; */
      /* border: 3px solid green; */
      /* padding: 10px; */
      padding: 2.5rem 2rem;
      border-radius: 10px;
      background-color: rgba(255, 255, 255, .5);
      max-width: 500px;
      box-shadow: 0 0 30px rgba(0, 0, 0, .15);
      /* margin: 1rem; */
      position: relative;
      transform-style: preserve-3d;
      overflow: hidden;
    }
    .card::before,
    .card::after {
      content: '';
      position: absolute;
      z-index: -1;
    }
    .card::before {
      width: 100%;
      height: 100%;
      border: 1px solid #FFF;
      border-radius: 10px;
      top: -.7rem;
      left: -.7rem;
    }
    .card::after {
      height: 15rem;
      width: 15rem;
      background-color: grey;
      top: -8rem;
      right: -8rem;
      box-shadow: 2rem 6rem 0 -3rem #FFF
    }

    .card img {
      width: 8rem;
      min-width: 80px;
      box-shadow: 0 0 0 5px #FFF;
    }

    .infos {
      margin-left: 2rem;
    }

    .name {
      margin-bottom: 1rem;
    }
    .name h2 {
      font-size: 20px;
    }
    .name h4 {
      font-size: 12px;
      color: #333
    }

    .text {
      font-size: 12px;
      margin-bottom: 1rem;
    }

    .stats {
      margin-bottom: 1rem;
    }
    .stats li {
      min-width: 5rem;
    }
    .stats li h3 {
      margin-top: 10px !important;
      font-size: 14px;
    }
    .stats li h4 {
      font-size: 12px;
    }

    .links button {
      font-family: 'Poppins', sans-serif;
      min-width: 120px;
      padding: .5rem;
      border: 1px solid #222;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
      transition: all .25s linear;
    }
    .links .follow,
    .links .view:hover {
      background-color: #222;
      color: #FFF;
    }
    .links .view,
    .links .follow:hover{
      background-color: transparent;
      color: #222;
    }

    @media screen and (max-width: 450px) {
      .card {
        display: block;
      }
      .infos {
        margin-left: 0;
        margin-top: 1.5rem;
      }
      .links button {
        min-width: 100px;
      }
    }

  </style>

			<!-- mt main start here -->
			<main id="mt-main">
        {{-- <center> --}}
        <div class="container">
          <div class="card">
            <div class="img">
              <img src="{{url('/')}}/{{$cek->profile_toko}}" style="width:80px; height:80px;">
            </div>
            <div class="infos">
              <div class="name">
                <h2>{{$cek->namatoko}}</h2>
              </div>
              <p class="text">
                <?php
                $string = $cek->address;
                $output = explode(" ",$string);
                ?>
                <span class="fa fa-map-marker"></span> {{end($output)}}
              </p>
              <ul class="stats">
                <li>
                  <h3>{{$countproduk}}</h3>
                  <h4>Product</h4>
                </li>
                <li>
                  <h3>{{$countreview}}</h3>
                  <h4>Review</h4>
                </li>
                <li>
                  <h3>{{(Int)$avgstar}}</h3>
                  <h4>Rating</h4>
                </li>
              </ul>
              <div class="links">
                <button class="follow" onclick="showWA({{$cek->phone}})">Whatsapp </button>
                <button class="view" onclick="showChat({{$cek->id_account}})">Chat Now</button>
              </div>
            </div>
          </div>
        </div>
      {{-- </center> --}}
			</main><!-- mt main end here -->
@endsection

@section('extra_script')
	<script type="text/javascript">

  function showWA(phone) {
      window.location.href = "https://api.whatsapp.com/send/?phone="+phone+"&text&app_absent=0";
  }

  function showChat(id) {
    $("#message-text").val("");
    $("#idtoko").val(id);
    $("#modalchat").modal("show");
  }

  $(document).ready(function(){
      setRandomColor();

    function getRandomColor() {
      var letters = '0123456789ABCDEF';
      var color = '#';
      for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
    }
    function setRandomColor() {
      $("body").css("background-color", getRandomColor());
    }
  })

  $("#simpanmessage").on('click', function() {
    let message = $('#message-text').val();
    let idtoko = $("#idtoko").val();

    $.ajax({
      url: "{{url('/')}}" + "/newchat",
      data: {idtoko: idtoko, message: message},
      success: function(data) {
        window.location.href = "{{url('/')}}/chat";
      }
    });
  })
	</script>
@endsection
