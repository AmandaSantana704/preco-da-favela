@extends('admin.layout.auth')
@section('title', 'Cadastrar')
@section('contain')
<section class="row">
    <div class="mx-auto p-3 mb-">
     <div class="navbar-brand">
         <!-- Logo icon -->
         <a href="{{route('painel.home')}}">
             <b class="logo-icon">
                 <!-- Dark Logo icon -->
                 <img src="{{asset('images/logo-icon.png')}}" alt="homepage" class="dark-logo" />
 
             </b>
             <!--End Logo icon -->
             <!-- Logo text -->
             <span class="logo-text">
                 <!-- dark Logo text -->
                 <img src="{{asset('images/logo-text.png')}}" alt="homepage" class="dark-logo" />
 
             </span>
         </a>
     </div>
    </div>
</section>
<div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative">
    <div class="auth-box row text-center" style="margin-top: 20px !important;">
        <div class="col-lg-7 col-md-5 modal-bg-img" style="background-image: url({{asset('images/big/create.svg')}});">
        </div>
        <div class="col-lg-5 col-md-7 bg-white card">
            <div class="p-3">
                <h2 class="mt-3 text-center">Crie a sua conta</h2>
               
                <form class="mt-4" method="POST" action="{{route('register.save')}}" id="register-form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input class="form-control @error('name')is-invalid @enderror" name="name" type="text" placeholder="Seu nome" value="{{old('name')}}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input class="form-control @error('name')is-invalid @enderror" name="email" type="email" placeholder="Seu e-mail" value="{{old('email')}}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input class="form-control @error('name')is-invalid @enderror" name="password" type="password" placeholder="Sua senha">
                            </div>
                           
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input class="form-control @error('name')is-invalid @enderror" name="password_confirmation" type="password" placeholder="Confirme a sua senha">
                            </div>
                            <small id="name1" class="badge badge-default badge-secondary form-text text-white float-left mb-4">
                                A senha precisa ter no mínimo 6 digitos
                                </small>
                        </div>
                        @captcha('pt')
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block btn-lg g-recaptcha">Criar conta</button>
                        </div>
                        <div class="col-lg-12 text-center mt-5">
                            Já é cadastrado? <a href="{{route('login')}}" class="text-danger">Entre</a>
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
  
@endsection