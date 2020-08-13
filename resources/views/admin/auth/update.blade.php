@extends('admin.layout.auth')
@section('title', 'Recuperar senha')
@section('contain')
<div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative" style="background:url({{asset('images/big/auth-bg.jpg')}}) no-repeat center center;">
    <div class="auth-box col-md-8">
        {{-- <div class="col-lg-7 col-md-5 modal-bg-img" style="background-image: url({{asset('images/big/3.jpg')}});">
        </div> --}}
        <div class="bg-white">
            <div class="p-3">
                
                <h2 class="mt-3 text-center">Nova senha</h2>
                <p class="text-center">Preencha o formulário abaixo com os dados solicitados</p>
               
                <form class="mt-4" method="POST" action="{{route('sendpassword')}}" id="update-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="text-dark" for="email">Email</label>
                                <input class="form-control @error('email')is-invalid @enderror" name="email" id="uname" type="email" placeholder="Seu e-mail" value="{{old('email')}}">
                            </div>
                            <div class="form-group mb-3">
                                <label class="text-dark" for="pass">Nova senha</label>
                                <input class="form-control @error('password')is-invalid @enderror" name="password" type="password" placeholder="Nova senha">
                            </div>
                            <div class="form-group mb-3">
                                <label class="text-dark" for="pass">Confirme a nova senha</label>
                                <input class="form-control @error('password_confirmation')is-invalid @enderror" name="password_confirmation" type="password" placeholder="Confirme sua nova senha">
                            </div>
                            <div class="form-group mb-3">
                                <input class="form-control" name="accounttoken" type="hidden" value="{{$token}}">
                            </div>
                        </div>
                    
                        @captcha('pt')
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn btn-block btn-dark g-recaptcha">Alterar senha</button>
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