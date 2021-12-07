<!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="{{url('/admin/home')}}">
          {{-- <img src="{{asset('assets/atonergi.png')}}" alt="logo" style="margin-left: auto;"> --}}
          <h1 style="margin:auto; ">iWak</h1>
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{url('/admin/home')}}">
          {{-- <img src="{{asset('assets/atonergi-mini.png')}}" alt="logo"/> --}}
          <h1 style="margin:auto; ">{{getsingkatan("iWak")}}</h1>
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>
        <div class="search-field ml-4 d-none d-md-block">
          <form class="d-flex align-items-stretch h-100" action="#">
            <div class="input-group">
              <input id="filterInput" type="text" class="form-control bg-transparent border-0" placeholder="Search Menu">
              <div class="input-group-btn">
                <button id="btn-reset" type="button" class="btn bg-transparent px-0 d-none" style="cursor: pointer;"><i class="fa fa-times"></i></button>
                <!-- <button type="button" class="btn bg-transparent dropdown-toggle px-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="mdi mdi-earth"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="#">Today</a>
                  <a class="dropdown-item" href="#">This week</a>
                  <a class="dropdown-item" href="#">This month</a>
                  <div role="separator" class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Month and older</a>
                </div> -->
              </div>
              <div class="input-group-addon bg-transparent border-0 search-button">
                <button type="button" class="btn btn-sm bg-transparent px-0" id="btn-search-menu">
                  <i class="mdi mdi-magnify"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item d-none d-lg-block full-screen-link">
            <a class="nav-link">
              <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
            </a>
          </li>
         <!--  <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <i class="mdi mdi-email-outline"></i>
              <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
              <h6 class="p-3 mb-0">Messages</h6>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <img src="{{asset('assets/images/faces/face4.jpg')}}" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Mark send you a message</h6>
                  <p class="text-gray mb-0">
                    1 Minutes ago
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <img src="{{asset('assets/images/faces/face2.jpg')}}" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Cregh send you a message</h6>
                  <p class="text-gray mb-0">
                    15 Minutes ago
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <img src="{{asset('assets/images/faces/face3.jpg')}}" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Profile picture updated</h6>
                  <p class="text-gray mb-0">
                    18 Minutes ago
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <h6 class="p-3 mb-0 text-center">4 new messages</h6>
            </div>
          </li> -->

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle nav-profile" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              {{-- <img src="{{asset('assets/image/faces1.jpg')}}" alt="image"> --}}
              <span class="d-lg-inline">{{Auth::user()->fullname}}</span>
            </a>
            <div class="dropdown-menu navbar-dropdown w-100" aria-labelledby="profileDropdown">

              @if(Auth::user()->level == 'admin')
                <a class="dropdown-item" href="{{ url('admin/logout') }}">
                  <i class="mdi mdi-logout mr-2 text-primary"></i>
                  Signout
                </a>
              @else
                <a class="dropdown-item" href="{{ url('/') }}">
                  <i class="mdi mdi-logout mr-2 text-primary"></i>
                  Home
                </a>
              @endif
            </div>
          </li>
          @if(Auth::user()->level == 'admin')
          <li class="nav-item nav-logout d-none d-lg-block" title="Logout">
            <a class="nav-link" href="{{ url('admin/logout') }}">
              <i class="mdi mdi-power"></i>
            </a>
          </li>
          @else
            <li class="nav-item nav-logout d-none d-lg-block" title="Logout">
              <a class="nav-link" href="{{ url('/') }}">
                <i class="mdi mdi-power"></i>
              </a>
            </li>
          @endif
          <form id="logout-form" action="{{ url('admin/logout') }}" method="post" style="display: none;">
              {{ csrf_field() }}
          </form>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="row row-offcanvas row-offcanvas-right">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav" id="ayaysir">

            @if (Auth::user()->role == "admin")
              <li class="nav-item {{Request::is('admin/home') ? 'active' : ''}} {{Request::is('/') ? 'active' : ''}} ">
                <a class="nav-link" href="{{url('admin/home')}}">
                  <span class="menu-title">Dashboard</span>
                  {{-- <span class="menu-sub-title">( 2 new updates )</span> --}}
                  <i class="mdi mdi-home menu-icon"></i>
                </a>
              </li>

              <li class="nav-item {{Request::is('admin/user') ? 'active' : ''}}">
                <a class="nav-link" href="{{url('admin/user')}}">
                  <span class="menu-title">Manage User</span>
                  {{-- <span class="menu-sub-title">( 2 new updates )</span> --}}
                  <i class="mdi mdi-account menu-icon"></i>
                </a>
              </li>

              <li class="nav-item {{Request::is('admin/toko') ? 'active' : ''}}">
                <a class="nav-link" href="{{url('admin/toko')}}">
                  <span class="menu-title">Manage Toko</span>
                  {{-- <span class="menu-sub-title">( 2 new updates )</span> --}}
                  <i class="mdi mdi-store menu-icon"></i>
                </a>
              </li>

              <li class="nav-item {{Request::is('admin/feed') ? 'active' : ''}}">
                <a class="nav-link" href="{{url('admin/feed')}}">
                  <span class="menu-title">Manage Feedback / Review</span>
                  {{-- <span class="menu-sub-title">( 2 new updates )</span> --}}
                  <i class="mdi mdi-comment menu-icon"></i>
                </a>
              </li>

              <li class="nav-item {{Request::is('admin/category') ? 'active' : ''}}">
                <a class="nav-link" href="{{url('admin/category')}}">
                  <span class="menu-title">Manage Category Product</span>
                  {{-- <span class="menu-sub-title">( 2 new updates )</span> --}}
                  <i class="mdi mdi-book-open-variant menu-icon"></i>
                </a>
              </li>

              <li class="nav-item {{ ( ( Request::is('admin/setting/*') || Request::is('admin/setting') ) ? ' active' : '' ) }}">
                <a class="nav-link" data-toggle="collapse" href="#setting" aria-expanded="false" aria-controls="ui-basic">
                  <span class="menu-title">Setting Online Shop</span>
                  <span class="d-none">
                    Edit Info
                    Manage Info
                  </span>
                  <i class="menu-arrow"></i>
                  <i class="mdi mdi-settings menu-icon mdi-spin"></i>
                </a>
                <div class="collapse {{Request::is('admin/setting') ? 'show' : '' || Request::is('admin/setting/*') ? 'show' : '' }}" id="setting">
                  <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link {{Request::is('admin/setting/backgroundheader') || Request::is('admin/setting/backgroundheader/*') ? 'active' : '' }}" href="{{url('admin/setting/backgroundheader')}}">Background Header<span class="d-none">Setting</span></a></li>
                    <li class="nav-item"> <a class="nav-link {{Request::is('admin/setting/editinfo') || Request::is('admin/setting/editinfo/*') ? 'active' : '' }}" href="{{url('admin/setting/editinfo')}}">Edit Info<span class="d-none">Setting</span></a></li>
                    <li class="nav-item"> <a class="nav-link {{Request::is('admin/setting/social') || Request::is('admin/setting/social/*') ? 'active' : '' }}" href="{{url('admin/setting/social')}}">Manage Social<span class="d-none">Setting</span></a></li>
                  </ul>
                  </div>
              </li>
            @else
              <li class="nav-item {{Request::is('penjual/home') ? 'active' : ''}}">
                <a class="nav-link" href="{{url('penjual/home')}}">
                  <span class="menu-title">Laporan Performa Toko</span>
                  {{-- <span class="menu-sub-title">( 2 new updates )</span> --}}
                  <i class="mdi mdi-chart-areaspline menu-icon"></i>
                </a>
              </li>

              <li class="nav-item {{Request::is('penjual/toko') ? 'active' : ''}}">
                <a class="nav-link" href="{{url('penjual/toko')}}">
                  <span class="menu-title">Toko</span>
                  {{-- <span class="menu-sub-title">( 2 new updates )</span> --}}
                  <i class="mdi mdi-store menu-icon"></i>
                </a>
              </li>

              <li class="nav-item {{Request::is('penjual/produk') ? 'active' : ''}}">
                <a class="nav-link" href="{{url('penjual/produk')}}">
                  <span class="menu-title">Manage Produk</span>
                  {{-- <span class="menu-sub-title">( 2 new updates )</span> --}}
                  <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                </a>
              </li>

              <li class="nav-item {{Request::is('penjual/lelang') ? 'active' : ''}}">
                <a class="nav-link" href="{{url('penjual/lelang')}}">
                  <span class="menu-title">Manage Lelang</span>
                  <span class="menu-sub-title" id="lelangnotif">( 0 new )</span>
                  <i class="mdi mdi-sale menu-icon"></i>
                </a>
              </li>

              <li class="nav-item {{Request::is('penjual/listorder') ? 'active' : ''}}">
                <a class="nav-link" href="{{url('penjual/listorder')}}">
                  <span class="menu-title">List Pesanan</span>
                  <span class="menu-sub-title" id="pesanannotif">( 0 new )</span>
                  <i class="mdi mdi-cart-outline menu-icon"></i>
                </a>
              </li>

              <li class="nav-item {{Request::is('penjual/listfeed') ? 'active' : ''}}">
                <a class="nav-link" href="{{url('penjual/listfeed')}}">
                  <span class="menu-title">List Feedback / Review</span>
                  {{-- <span class="menu-sub-title">( 2 new updates )</span> --}}
                  <i class="mdi mdi-comment menu-icon"></i>
                </a>
              </li>

            @endif


            {{-- <li class="nav-item {{Request::is('mutasi') ? 'active' : ''}}">
              <a class="nav-link" href="{{url('/mutasi')}}">
                <span class="menu-title">Cek Mutasi</span> --}}
                {{-- <span class="menu-sub-title">( 2 new updates )</span> --}}
                {{-- <i class="fa fa-history"></i>
              </a>
            </li> --}}
              {{-- <li class="nav-item {{Request::is('setting') ? 'active' : '' || Request::is('setting/*') ? 'active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#setting" aria-expanded="false" aria-controls="ui-basic">
                  <span class="menu-title">Setup</span>
                  <span class="d-none">
                    Setting Level Account
                    Setting Account
                    Setting Hak Akses
                    Setting Daftar Menu
                  </span>
                  <i class="menu-arrow"></i>
                  <i class="mdi mdi-settings menu-icon mdi-spin"></i>
                </a>
                <div class="collapse {{Request::is('setting') ? 'show' : '' || Request::is('setting/*') ? 'show' : '' }}" id="setting">
                  <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link {{Request::is('setting/modul/keuangan/setting/klasifikasi-akun') ? 'active' : '' || Request::is('setting/modul/keuangan/setting/klasifikasi-akun/*') ? 'active' : '' }}" href="{{url('setting/modul/keuangan/setting/klasifikasi-akun')}}">Klasifikasi Akun<span class="d-none">Setting</span></a></li>
                    <li class="nav-item"> <a class="nav-link {{Request::is('setting/modul/keuangan/setting/klasifikasi-akun') ? 'active' : '' || Request::is('setting/modul/keuangan/setting/klasifikasi-akun/*') ? 'active' : '' }}" href="{{url('setting/modul/keuangan/setting/klasifikasi-akun')}}">Klasifikasi Akun<span class="d-none">Setting</span></a></li>

                  </ul>
                  </div>
              </li> --}}

          </ul>

        </nav>
