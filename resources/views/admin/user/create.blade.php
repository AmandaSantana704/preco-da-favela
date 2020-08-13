@extends('admin.layout.main')
@section('title', 'Cadastrar usuário')
@section('contain')



    <div class="col-7 align-self-center">
        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Cadastre um novo usuário</h3>
        <div class="d-flex align-items-center mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 p-0">
                    <li class="breadcrumb-item">Campos marcados com <span style="color:#5f76e8;">*</span> são obrigatórios
                    </li>
                </ol>
            </nav>
        </div>
    </div>            
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <form action="{{route('user.save')}}" method="POST">
                    @csrf
                   <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="nomeDoUsuario">Digite o nome do usuário <span style="color:#5f76e8;">*</span></label>
                            <input type="text" name="name" class="form-control @error('name')is-invalid @enderror" placeholder="Nome do usuário" value="{{old('name')}}" maxlength="50">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="permissaoDoUsuario">Selecione a permissao <span style="color:#5f76e8;">*</span></label>
                            <select name="permission" class="form-control @error('name')is-invalid @enderror">
                                <option disabled selected>Selecione uma permissão</option>
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->display_name}}</option>
                                @endforeach
                                
                            </select>
                        </div>
                   </div>
                   <div class="row mb-3">
                       <div class="col mb-3">
                        <label for="email">E-mail do usuário </label><span style="color:#5f76e8;">*</span></label>
                        <input type="email" name="email" class="form-control @error('name')is-invalid @enderror" placeholder="Digite o e-mail do usuário" value="{{old('email')}}">
                       </div>
                   </div>
                   <div class="row mb-3">
                       <div class="col-md-6 mb-3">
                            <label for="horario">Senha do usuário </label><span style="color:#5f76e8;">*</span></label>
                           <input type="password" class="form-control @error('name')is-invalid @enderror" name="password" placeholder="Digite a senha do usuário">
                       </div>
                       <div class="col-md-6 mb-3">
                        <label for="numeroContato">Confirme a senha </label><span style="color:#5f76e8;">*</span></label>
                        <input type="password" class="form-control sp_celphones" name="password_confirmation" placeholder="confirme a senha">
                        </div>
                   </div>
                
                   <div class="row mb-3">
                        <input type="submit" value="Cadastrar usuário" class="col-md-12 btn btn-success">
                   </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script>
        activeHover('usuario', '#linkUser', 'active', '#li-linkUser', 'selected');
    </script>
      @if($errors->any())
      @foreach($errors->all() as $error)
          @component('component.alert')
          {{$error}}
          @endcomponent
      @endforeach
  @endif
@endsection