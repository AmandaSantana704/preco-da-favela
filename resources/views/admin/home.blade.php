@extends('admin.layout.main')
@section('title', 'home')
@section('contain')
@if(session('success'))
    @component('component.success')
            {{session('success')}}
    @endcomponent
@endif

<div class="welcome">
    <img src="{{asset('images/store-2.png')}}" alt="">
    <h1>Olá, {{$user->name}}!</h1>
    <h2>Seja muito bem vindo(a) ao <strong>Preço da Favela!</strong>, 
        estamos em versão beta, em breve teremos 
        muitas novidades.</h2>
</div>

@endsection
    
