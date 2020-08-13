@extends('admin.layout.auth')
@section('title', 'Recuperar senha')
@section('css')
<style>
    body{
        background-image:url('http://127.0.0.1:8000/images/big/bg-forgot.jpg');
        background-size: cover;
        width: 100%;
    }
    .card{
        box-shadow: none !important;
    }
</style>
@endsection
@section('contain')
<section class="row">
    <div class="mx-auto p-3 mb-">
     <div class="navbar-brand">
         <!-- Logo icon -->
         <a href="{{route('painel.home')}}">
             <b class="logo-icon">
                 <!-- Dark Logo icon -->
                 <img src="{{asset('images/logo-icon-white.png')}}" alt="homepage" class="dark-logo" />
 
             </b>
             <!--End Logo icon -->
             <!-- Logo text -->
             <span class="logo-text">
                 <!-- dark Logo text -->
                 <img src="{{asset('images/logo-text-white.png')}}" alt="homepage" class="dark-logo" />
 
             </span>
         </a>
     </div>
    </div>
</section>
<div class="auth-wrappe d-flex justify-content-center align-items-center position-relative">
    <div class="auth-bo">
        {{-- <div class="col-lg-7 col-md-5 modal-bg-img" style="background-image: url({{asset('images/big/3.jpg')}});">
        </div> --}}
        <div class="mx-auto col-lg-8 col-md-7 bg-white card mt-3">
            <div class="p-3">
                
                <h2 class="mt-3 text-center">Esqueci minha senha</h2>
                <p class="text-center">Preencha o formulário abaixo com o seu e-mail</p>
                
                <form class="mt-4" method="POST" action="{{route('recover')}}" id="forgot-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-dark" for="uname">Seu e-mail</label>
                                <input class="form-control @error('name')is-invalid @enderror" name="email" id="uname" type="email" placeholder="Seu e-mail" value="{{old('email')}}">
                            </div>
                        </div>
                    
                        @captcha('pt')
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block btn-lg g-recaptcha">Recuperar senha</button>
                        </div>
                        <div class="col-lg-12 text-center mt-5">
                            <a href="{{route('login')}}" class="text-danger">Acessar minha conta</a>
                        </div>
                        <div class="col-12 text-center mt-5">
                            <p style="font-size: 12px;">Este formulário é protegido pelo reCAPTCHA</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')

      @if($errors->any())
      @foreach($errors->all() as $error)
          @component('component.alert')
          {{$error}}
          @endcomponent
      @endforeach
  @endif

    @if(session('warning'))
      @component('component.alert')
        {{session('warning')}}
      @endcomponent
    @endif
@endsection