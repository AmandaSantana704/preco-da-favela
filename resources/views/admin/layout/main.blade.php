<!DOCTYPE html>
<html dir="ltr" lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/favicon.png')}}">
    <title>@yield('title')</title>
    <!-- Custom CSS -->
    <link href="{{asset('css/chartist.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/fontawesome-all.css')}}" rel="stylesheet" />
    <link href="{{asset('css/simple-line-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('css/themify-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('css/dataTables.bootstrap4.css')}}" rel="stylesheet" />
    @yield('css')
    <link href="{{asset('css/style.min.css')}}" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link href="{{asset('css/main.css')}}" rel="stylesheet">

</head>

<body>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header modal-colored-header bg-warning">
            <h4 class="modal-title" id="warning-header-modalLabel">Modal Heading
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light btn-rounded" data-dismiss="modal">Cancelar</button>
          <button type="button" id="btConfirmDel" class="btn btn-warning btn-rounded">Excluir</button>
        </div>
      </div>
    </div>
  </div>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)" style="font-size: 30px;">
                        <i class="ti-menu ti-close feather-icon" id="icon-toggle"></i>
                        {{-- <i class="ti-menu ti-close"></i> --}}
                    </a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                   
                    <div class="navbar-brand">
                        <!-- Logo icon -->
                        <a href="{{route('painel.home')}}">
                            <b class="logo-icon">
                                <!-- Dark Logo icon -->
                                <img src="{{asset('images/logo-icon.png')}}" alt="homepage" class="dark-logo" />
                                <!-- Light Logo icon -->
                                <img src="{{asset('images/logo-icon.png')}}" alt="homepage" class="light-logo" />
                            </b>
                            <!--End Logo icon -->
                            <!-- Logo text -->
                            <span class="logo-text">
                                <!-- dark Logo text -->
                                <img src="{{asset('images/logo-text.png')}}" alt="homepage" class="dark-logo" />
                                <!-- Light Logo text -->
                                <img src="{{asset('images/logo-light-text.png')}}" class="light-logo" alt="homepage" />
                            </span>
                        </a>
                    </div>
                    
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="font-size: 30px;"><i
                            class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto ml-3 pl-1">
                        <!-- Notification -->
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="javascript:void(0)"
                                id="bell" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <span><i data-feather="bell" class="svg-icon"></i></span>
                                <span class="badge badge-primary notify-no rounded-circle">5</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left mailbox animated bounceInDown">
                                <ul class="list-style-none">
                                    <li>
                                        <div class="message-center notifications position-relative">
                                            <!-- Message -->
                                            <a href="javascript:void(0)"
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <div class="btn btn-danger rounded-circle btn-circle"><i
                                                        data-feather="airplay" class="text-white"></i></div>
                                                <div class="w-75 d-inline-block v-middle pl-2">
                                                    <h6 class="message-title mb-0 mt-1">Luanch Admin</h6>
                                                    <span class="font-12 text-nowrap d-block text-muted">Just see
                                                        the my new
                                                        admin!</span>
                                                    <span class="font-12 text-nowrap d-block text-muted">9:30 AM</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)"
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <span class="btn btn-success text-white rounded-circle btn-circle"><i
                                                        data-feather="calendar" class="text-white"></i></span>
                                                <div class="w-75 d-inline-block v-middle pl-2">
                                                    <h6 class="message-title mb-0 mt-1">Event today</h6>
                                                    <span
                                                        class="font-12 text-nowrap d-block text-muted text-truncate">Just
                                                        a reminder that you have event</span>
                                                    <span class="font-12 text-nowrap d-block text-muted">9:10 AM</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)"
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <span class="btn btn-info rounded-circle btn-circle"><i
                                                        data-feather="settings" class="text-white"></i></span>
                                                <div class="w-75 d-inline-block v-middle pl-2">
                                                    <h6 class="message-title mb-0 mt-1">Settings</h6>
                                                    <span
                                                        class="font-12 text-nowrap d-block text-muted text-truncate">You
                                                        can customize this template
                                                        as you want</span>
                                                    <span class="font-12 text-nowrap d-block text-muted">9:08 AM</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)"
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <span class="btn btn-primary rounded-circle btn-circle"><i
                                                        data-feather="box" class="text-white"></i></span>
                                                <div class="w-75 d-inline-block v-middle pl-2">
                                                    <h6 class="message-title mb-0 mt-1">Pavan kumar</h6> <span
                                                        class="font-12 text-nowrap d-block text-muted">Just
                                                        see the my admin!</span>
                                                    <span class="font-12 text-nowrap d-block text-muted">9:02 AM</span>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link pt-3 text-center text-dark" href="javascript:void(0);">
                                            <strong>Check all notifications</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}
                        <!-- End Notification -->
                        <!-- ============================================================== -->
                        <!-- create new -->
                        <!-- ============================================================== -->
                      
                        <li class="nav-item d-none d-md-block" style="display: none !important;">
                            <a class="nav-link" href="javascript:void(0)">
                                <div class="customize-input">
                                    <select
                                        class="custom-select form-control bg-white custom-radius custom-shadow border-0">
                                        <option selected>EN</option>
                                        <option value="1">AB</option>
                                        <option value="2">AK</option>
                                        <option value="3">BE</option>
                                    </select>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                        @if(Auth::user()->photo === null)
                                        <img src="{{asset('images/users/default.jpg')}}" alt="user" class="rounded-circle" width="45" height="45">
                                        @else
                                        <img src="{{asset('images/users/'.Auth::user()->photo)}}" alt="user" class="rounded-circle" width="45" height="45">
                                        @endif
                                        
                                        <span class="ml-2 d-none d-lg-inline-block"><span>Olá,</span> <span
                                        class="text-dark">{{Auth::user()->name}}</span> <i data-feather="chevron-down"
                                        class="svg-icon"></i></span>
                                    
                              
                               
                                
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <a class="dropdown-item" href="{{route('panel.profile')}}"><i data-feather="user"
                                        class="svg-icon mr-2 ml-1"></i>
                                   Meu perfil</a>
                               
                                {{-- <a class="dropdown-item" href="javascript:void(0)"><i data-feather="mail"
                                        class="svg-icon mr-2 ml-1"></i>
                                    Inbox</a> --}}
                                <div class="dropdown-divider"></div>
                                @if(Auth::user()->permission == 1)
                                <a class="dropdown-item" href=""><i data-feather="credit-card"
                                        class="svg-icon mr-2 ml-1"></i>
                                    Minha conta</a>
                                @endif
                                    <a class="dropdown-item" href="{{route('suport')}}"><i data-feather="settings"
                                        class="svg-icon mr-2 ml-1"></i>
                                    Suporte</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{route('logout')}}"><i data-feather="power"
                                        class="svg-icon mr-2 ml-1"></i>
                                    Sair</a>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item" id="li-linkPanel"> 
                            <a id="linkPanel" class="sidebar-link" href="{{route('painel.home')}}"
                            aria-expanded="false"><i data-feather="bar-chart" class="feather-icon"></i>
                            <span class="hide-menu">Painel</span></a>
                        </li>
                        @if(Auth::user()->permission == 1 || Auth::user()->permission == 2 || Auth::user()->permission == 3)
                        <li class="sidebar-item" id="li-linkCommerce"> 
                            <a id="linkCommerce" class="sidebar-link sidebar-link" href="{{route('panel.commerce')}}"
                            aria-expanded="false"><i data-feather="home" class="feather-icon"></i>
                            <span class="hide-menu">Comércio</span></a>
                        </li>
                        @endif
                        <li class="sidebar-item" id="li-linkProduct"> 
                            <a class="sidebar-link sidebar-link" id="linkProduct" href="{{route('panel.session')}}"
                            aria-expanded="false"><i data-feather="shopping-cart" class="feather-icon"></i>
                            <span class="hide-menu">Produto</span></a>
                        </li>
                        @if(Auth::user()->permission == 1)
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-feather feather-icon"><path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"></path><line x1="16" y1="8" x2="2" y2="22"></line><line x1="17.5" y1="15" x2="9" y2="15"></line></svg><span class="hide-menu">Categoria
                                </span></a>
                            <ul aria-expanded="false" class="collapse first-level base-level-line">
                                <li class="sidebar-item"><a href="icon-fontawesome.html" class="sidebar-link"><span class="hide-menu"> Comércio </span></a></li>

                                <li class="sidebar-item"><a href="icon-simple-lineicon.html" class="sidebar-link"><span class="hide-menu"> Produto </span></a></li>
                            </ul>
                        </li>
                        @endif
                        @if(Auth::user()->permission == 1)
                        <li class="sidebar-item" id="li-linkUser"> 
                            <a class="sidebar-link" id="linkUser" href="{{route('panel.user')}}"
                            aria-expanded="false"><i data-feather="home" class="feather-icon"></i>
                            <span class="hide-menu">Usuários</span></a>
                        </li>
                        @endif

                       
                        @if(Auth::user()->permission == 1)

                        <li class="sidebar-item"> 
                            <a class="sidebar-link" href="{{route('panel.plan')}}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Planos</span></a>
                        </li>

                        @endif
                        
                        </ul>
                        
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
       
        <div class="page-wrapper">
 
            <div class="container-fluid" style="background-color:#f1f5f4;">
                <div class="mb-5">
                    <a href="{{ url()->previous() }}" style="font-size: 25px; color: #333333;"><i class="fas fa-arrow-left"></i></a>
                </div>
                
                @yield('contain')
            </div>
            
            <footer class="footer text-center text-muted">
                All Rights Reserved by Eligius.
            </footer>
        </div>
       
    
    </div>

    <script src="{{asset('js/jquery.min.js')}}"></script>
    {{-- <script src="{{asset('js/popper.min.js')}}"></script> --}}
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="{{asset('js/app-style-switcher.js')}}"></script>
    <script src="{{asset('js/feather.min.js')}}"></script>
    <script src="{{asset('js/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('js/sidebarmenu.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('js/custom.min.js')}}"></script>
  
    <script src="{{asset('js/chartist.min.js')}}"></script>
    <script src="{{asset('js/chartist-plugin-tooltip.min.js')}}"></script>

    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#multi_col_order').dataTable( {
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
                }
            } );
        } );
    </script>

    <script src="{{asset('js/main.js')}}"></script>
    <script type="text/javascript">
        $(document).ready( function () {
            $('#multi_col_order').DataTable();
        }); 

        const toggleAction = () => {
            let element1 = document.querySelector('#main-wrapper');
            let element2 = document.querySelector('#navbarSupportedContent');
            let iconToggle = document.querySelector('#icon-toggle');
            let pageWrapper = document.querySelector('.page-wrapper');
                pageWrapper.addEventListener('click', () => {
                    if(element1.classList.contains('show-sidebar') && !iconToggle.classList.contains('ti-menu')){
                        element1.classList.remove('show-sidebar');
                        iconToggle.classList.add('ti-menu');
                    }
                    if(element2.classList.contains('show')){
                        element2.classList.remove('show');
                    }
                    
                });
        };
        toggleAction();
 
    </script>
    
    @yield('js')
</body>

</html>