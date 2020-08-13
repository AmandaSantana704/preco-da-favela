<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scalable=1.0, user-scalable=no">
  <meta name="author" content="Eligius">
  <meta name="theme-color" content="#8274E6">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/favicon.png')}}">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" rel="stylesheet">
  <link href="{{asset('css/themify-icons.css')}}" rel="stylesheet" />
  <link rel="stylesheet" href="{{asset('css/app/owl.carousel.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/app/owl.theme.default.min.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>
  @yield('css')
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="{{asset('css/app/main.css')}}">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
</head>
<body>
  {{-- MODAL GET USE LOCATION --}}
  <div class="modal fade" id="modal-geolocation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <img class="mb-3" src="{{asset('images/app/geolocalization.svg')}}" alt="geolocalization">
          <h4 class="mb-3">Por favor, informe sua localização.</h4>
          <p class="mb-3">Precisamos da sua localização para exibir 
            comércios próximos a você</p>
            <button type="button" class="btn btn-app-primary btn-lg" id="getUserLocation">Informar localização</button>
        </div>
      </div>
    </div>
  </div>  
    <section class="menu">
            <nav>
              <ul>
                <li>
                  <a href="{{route('app.home')}}">
                    <div class="ti-home menu-icon" style="font-size: 22px;"></div>
                    Início
                  </a>
                </li>
                <li>
                  <a href="{{route('app.search')}}">
                    <div class="ti-search menu-icon" style="font-size: 22px;"></div>
                    Busca
                  </a>
                </li>
                <li>
                  <a href="{{route('app.offer')}}">
                    <div class="ti-receipt menu-icon" style="font-size: 22px;"></div>
                    Promoções
                  </a>
                </li>
                <li>
                  <a href="{{route('painel.home')}}" target="blank">
                    <div class="ti-user menu-icon" style="font-size: 22px;"></div>
                    Entrar
                  </a>
                </li>
              </ul>
            </nav>
    </section>
    @yield('section')
    <section class="spacing"></section>
 
    <script src="{{asset('js/app/owl.carousel.min.js')}}"></script>
    <script src="{{asset('js/app/main-carousel.js')}}"></script>
    <script src="{{asset('js/app/features.js')}}"></script>
    <script>
       $(function() {
        $('.lazy').Lazy();
      });
    </script>
    <script src="{{asset('js/app/getLocationUser.js')}}"></script>
    <script type="text/javascript">
      $(window).on('load',function(){
        if(sessionStorage.getItem('usergeolocation') != null){
          $('#modal-geolocation').modal('hide');
        }else{
          $('#modal-geolocation').modal('show');
        }
      });
  </script>

 <script>
   $(window).scroll(function(){
    if ($(window).scrollTop() >= 5) {
        $('.fixed-search').addClass('fixed-header');
        $('.fixed-search').addClass('animate__animated animate__fadeIn');        
    }
    else {
        $('.fixed-search').removeClass('fixed-header');
        $('.fixed-search').removeClass('animate__animated animate__fadeIn');
    }
  });
 </script>
  @yield('js')
</body>
</html>