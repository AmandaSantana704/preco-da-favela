@extends('admin.layout.auth')
@section('title', 'Login')
@section('css')
<style>
    body{
        background-image:url('http://127.0.0.1:8000/images/big/bg-login.jpg');
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
{{-- style="background:url({{asset('images/big/auth-bg.jpg')}}) no-repeat center center;" --}}

<div id="t" class="auth-wrappe d-flex justify-content-center align-items-center position-relative">
    <div class="auth-bo row container">
        {{-- <div class="col-lg-7 col-md-5 modal-bg-img" style="background-image: url({{asset('images/big/3.png')}});">
        </div> --}}
        <div class="mx-auto col-lg-5 col-md-7 bg-white card mt-3">
            
            <div class="p-4">  

                <form class="" method="POST" action="{{route('login.auth')}}" id="login-form">
                            
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="text-dark" for="uname">Usuário</label>
                                <input class="form-control @error('name')is-invalid @enderror" name="email" id="uname" type="email" placeholder="Seu e-mail" value="{{old('email')}}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="text-dark" for="pwd">Senha</label>
                                <input class="form-control @error('name')is-invalid @enderror" name="password" id="pwd" type="password" placeholder="Sua senha">
                            </div>
                        </div>

                        <div class="col-lg-12 custom-checkbox">
                            <div class="form-group" style="margin-left:30px;">
                                <input type="checkbox" name="remember" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">Lembrar usuário</label>
                            </div>
                        </div>
                        {{-- @captcha('pt') --}}
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block btn-lg g-reaptcha">Acessar</button>
                        </div>
                        
                        
                        <div class="col-lg-12 text-center mt-3 mb-3">
                            <a href="{{route('forgot')}}" class="text-primary">Esqueci minha senha</a>
                        </div>
                        <div class="col-lg-12 text-center">
                            Ainda não tem uma conta? <a href="{{route('panel.register')}}" class="text-danger">Criar uma conta</a>
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
    @if(session('success'))
    @component('component.success')
        {{session('success')}}
    @endcomponent
    @endif

@endsection
