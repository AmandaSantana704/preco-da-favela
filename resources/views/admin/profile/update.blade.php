@extends('admin.layout.main')
@section('title', 'Meu perfil')
@section('contain')


    <div class="col-7 align-self-center">
        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Seu perfil</h3>
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

                <form action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                
                    <section class="row">
                        <div class="col-md-3" style="margin-top: 12px;">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                  <div class="text-center mb-3 cropped-profile" style="width: 150px; height:150px;">
                                    @if($user->photo === null)
                                      <img src="{{asset('images/users/default.jpg')}}" alt="user">
                                      @else
                                      <img src="{{asset('images/users/'.$user->photo)}}" alt="user">
                                      @endif
                                  </div>
                  
                                  <h3 class="profile-username text-center">{{$user->name}}</h3>
                                  @foreach($roles as $role)
                                  <p class="text-muted text-center mb-3">{{$role->display_name}}</p>
                                  @endforeach

                                  <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                      <b>Criação</b> <a class="float-right">{{date('d/m/Y', strtotime($user->created_at))}}</a>
                                    </li>
                                    <li class="list-group-item">
                                      <b>Atualização</b> <a class="float-right">
                                          {{$user->updated_at === null ? '---' : date('d/m/Y', strtotime($user->updated_at))}}
                                        </a>
                                    </li>
                                  </ul>
                  
                                  {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
                                </div>
                                
                              </div>
                        </div>
                        <div class="col-md-9 mt-5">
                            <div class="row mb-3">
                                <div class="col-md-12 mb-3">
                                    <label for="nomeDoUsuario">Digite o nome do usuário <span style="color:#5f76e8;">*</span></label>
                                    <input type="text" name="name" class="form-control mb-3 @error('name')is-invalid @enderror" placeholder="Nome do usuário" value="{{$user['name']}}" maxlength="50">
                                    <label for="email">E-mail do usuário </label><span style="color:#5f76e8;">*</span></label>
                                    <input type="email" name="email" class="form-control mb-3 @error('name')is-invalid @enderror" disabled placeholder="Digite o e-mail do usuário" value="{{$user['email']}}">
                                    <label for="pass">Senha do usuário </label><span style="color:#5f76e8;">*</span></label>
                                   <input type="password" class="form-control mb-3 @error('name')is-invalid @enderror" name="password" placeholder="Digite a senha do usuário">
                                   <label for="confirmPass">Confirme a senha </label><span style="color:#5f76e8;">*</span></label>
                                   <input type="password" class="form-control sp_celphones mb-3" name="password_confirmation" placeholder="confirme a senha">
                                   <div class="row">
                                    <div class="col-md-12 mb-">
                                        <div class="col-md-12 input-custom btn waves-effect waves-light btn-rounded btn-outline-primary btn-lg bt-custom">
                                             <span>Sua foto<i class="fas fa-upload ml-3" aria-hidden="true"></i></span>
                                        </div>
                                        
                                         <div class="input-opacity">
                                             <input type="file" name="photo" index="0" value="{{$user['photo']}}" class="col-md-12 custom-file-input @error('photo')is-invalid @enderror" id="inputGroupFile01" style="position: relative; height: 50px; top:-50px; cursor: pointer;">
                                         </div>
                                    </div>
            
                                   </div> 

                                
                                   <input type="submit" value="Atualizar perfil" class="col-md-12 btn btn-success btn-rounded btn-lg">
                                </div>
                           </div>
                          
                           
                        </div>
                    </section>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script>
        activeHover('perfil', '#linkPanel', 'active', '#li-linkPanel', 'selected');

        let input = document.querySelectorAll('.custom-file-input');
    input.forEach((el) => {
        el.addEventListener('change', function(){
            let index = this.getAttribute('index');
            let btCustom = document.querySelectorAll('.bt-custom');
                btCustom[index].classList.remove('btn-outline-primary');
                btCustom[index].classList.add('btn-outline-success');
        });
    });
    </script>
       @if($errors->any())
       @foreach($errors->all() as $error)
           @component('component.alert')
           {{$error}}
           @endcomponent
       @endforeach
   @endif
@endsection